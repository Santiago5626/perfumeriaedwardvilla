<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Nueva Oferta Especial en Edward Villa Perfumería!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        h2 {
            color: #34495e;
            font-size: 20px;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .benefits {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .benefits ul {
            list-style: none;
            padding: 0;
        }
        .benefits li {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .benefits li:last-child {
            border-bottom: none;
        }
        .offer-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .price {
            font-size: 24px;
            color: #e74c3c;
            font-weight: bold;
            margin: 15px 0;
        }
        .original-price {
            text-decoration: line-through;
            color: #95a5a6;
            font-size: 18px;
        }
        .discount {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .unsubscribe {
            font-size: 12px;
            color: #6c757d;
            margin-top: 20px;
        }
        .unsubscribe a {
            color: #6c757d;
        }
        .valid-until {
            font-style: italic;
            color: #666;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Nueva Oferta Especial!</h1>
        </div>

        <p>Hola,</p>

        <p>Tenemos una increíble oferta especial para ti en <strong>Edward Villa Perfumería</strong>.</p>

        <h2>Oferta Destacada</h2>
        
        <div class="offer-details">
            <h3>{{ $offer->product->name }}</h3>
            
            <div class="discount">{{ $offer->discount_percentage }}% OFF</div>
            
            <div class="price">
                <span class="original-price">${{ number_format($offer->product->price, 2) }}</span><br>
                <span>${{ number_format($offer->final_price, 2) }}</span>
            </div>

            @if($offer->description)
            <p>{{ $offer->description }}</p>
            @endif

            <p class="valid-until">Válido hasta: {{ \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') }}</p>
        </div>

        <h2>¿Por qué elegir Edward Villa Perfumería?</h2>
        
        <div class="benefits">
            <ul>
                <li><strong>Fragancias auténticas</strong> de las mejores marcas</li>
                <li><strong>Precios exclusivos</strong> para suscriptores</li>
                <li><strong>Envío seguro</strong> a toda Colombia</li>
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('products.show', $offer->product) }}" class="button">Ver Producto</a>
        </div>

        <p>No te pierdas esta oportunidad única de obtener tu fragancia favorita a un precio especial.</p>

        <div class="footer">
            <strong>Edward Villa Perfumería</strong><br>
            <em>Esencia y apariencia</em>
            
            <div class="unsubscribe">
                Si no deseas recibir más correos de ofertas, puedes <a href="{{ $unsubscribeUrl }}">desuscribirte aquí</a>.
            </div>
        </div>
    </div>
</body>
</html>
