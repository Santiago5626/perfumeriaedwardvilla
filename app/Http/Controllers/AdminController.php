<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Offer;
use App\Models\User;
use App\Models\Subscriber;
use App\Mail\NewOfferNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Dashboard principal
     */
    public function dashboard()
    {
        // Estadísticas generales
        $stats = [
            'total_sales' => Order::sum('total'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('is_admin', false)->count(),
        ];

        // Ventas por mes (últimos 6 meses)
        $monthlySales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Productos más vendidos
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->with('category')
            ->groupBy('products.id', 'products.name', 'products.description', 'products.price', 'products.image', 'products.stock', 'products.category_id', 'products.size', 'products.gender', 'products.active', 'products.created_at', 'products.updated_at')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Ofertas activas
        $activeOffers = Offer::with('product')
            ->where('end_date', '>=', now())
            ->where('active', true)
            ->get();

        return view('admin.dashboard', compact('stats', 'monthlySales', 'topProducts', 'activeOffers'));
    }

    /**
     * Gestión de ofertas
     */
    public function offers()
    {
        $offers = Offer::with('product')->latest()->paginate(10);
        $products = Product::where('active', true)->get();
        
        return view('admin.offers.index', compact('offers', 'products'));
    }

    /**
     * Crear nueva oferta
     */
    public function storeOffer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:500'
        ]);

        $product = Product::findOrFail($request->product_id);
        $finalPrice = $product->price * (1 - ($request->discount_percentage / 100));

        $offer = Offer::create([
            'product_id' => $request->product_id,
            'discount_percentage' => $request->discount_percentage,
            'final_price' => $finalPrice,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'active' => true
        ]);

        // Enviar correos a los suscriptores
        $this->notifySubscribers($offer);

        return redirect()->route('admin.offers')->with('success', 'Oferta creada exitosamente y notificaciones enviadas a los suscriptores');
    }

    /**
     * Notificar a los suscriptores sobre nueva oferta
     */
    private function notifySubscribers(Offer $offer)
    {
        try {
            // Obtener todos los suscriptores activos y verificados
            $subscribers = Subscriber::activeAndVerified()->get();

            if ($subscribers->count() === 0) {
                Log::info('No hay suscriptores para notificar sobre la nueva oferta', [
                    'offer_id' => $offer->id,
                    'product_name' => $offer->product->name
                ]);
                return;
            }

            Log::info('Iniciando envío de notificaciones de nueva oferta', [
                'offer_id' => $offer->id,
                'product_name' => $offer->product->name,
                'subscribers_count' => $subscribers->count()
            ]);

            // Enviar correos en lotes para evitar problemas de rendimiento
            $subscribers->chunk(50, function ($subscriberChunk) use ($offer) {
                foreach ($subscriberChunk as $subscriber) {
                    try {
                        Mail::to($subscriber->email)->send(new NewOfferNotification($offer));
                        
                        Log::info('Correo de oferta enviado', [
                            'subscriber_email' => $subscriber->email,
                            'offer_id' => $offer->id
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error al enviar correo de oferta', [
                            'subscriber_email' => $subscriber->email,
                            'offer_id' => $offer->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            });

            Log::info('Notificaciones de nueva oferta completadas', [
                'offer_id' => $offer->id,
                'total_subscribers' => $subscribers->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error general al notificar suscriptores', [
                'offer_id' => $offer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Actualizar oferta
     */
    public function updateOffer(Request $request, Offer $offer)
    {
        $request->validate([
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'end_date' => 'required|date|after:today',
            'description' => 'nullable|string|max:500'
        ]);

        $finalPrice = $offer->product->price * (1 - ($request->discount_percentage / 100));

        $offer->update([
            'discount_percentage' => $request->discount_percentage,
            'final_price' => $finalPrice,
            'end_date' => $request->end_date,
            'description' => $request->description
        ]);

        return redirect()->route('admin.offers')->with('success', 'Oferta actualizada exitosamente');
    }

    /**
     * Desactivar oferta
     */
    public function deactivateOffer(Offer $offer)
    {
        $offer->update(['active' => false]);
        return redirect()->route('admin.offers')->with('success', 'Oferta desactivada exitosamente');
    }

    /**
     * Reporte de ventas
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $sales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.product'])
            ->latest()
            ->get();

        $summary = [
            'total_sales' => $sales->sum('total'),
            'total_orders' => $sales->count(),
            'average_order' => $sales->avg('total'),
            'products_sold' => $sales->flatMap->items->sum('quantity')
        ];

        return view('admin.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Reporte de inventario
     */
    public function inventoryReport()
    {
        $products = Product::with('category')
            ->select('products.*', DB::raw('(
                SELECT SUM(order_items.quantity) 
                FROM order_items 
                WHERE order_items.product_id = products.id
            ) as total_sold'))
            ->orderBy('stock', 'asc')
            ->get();

        $lowStock = $products->where('stock', '<', 10)->count();
        $outOfStock = $products->where('stock', 0)->count();

        return view('admin.reports.inventory', compact('products', 'lowStock', 'outOfStock'));
    }
}
