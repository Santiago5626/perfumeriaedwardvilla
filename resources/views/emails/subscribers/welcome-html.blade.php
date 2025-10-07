<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a Edward Villa Perfumería!</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a Edward Villa Perfumería!</h1>
        </div>

        <p>Hola,</p>

        <p>¡Gracias por suscribirte! Estamos emocionados de tenerte como parte de nuestra familia de amantes de las fragancias.</p>

        <h2>¿Qué puedes esperar?</h2>
        
        <div class="benefits">
            <ul>
                <li><strong>Ofertas exclusivas</strong> en perfumes de lujo</li>
                <li><strong>Descuentos especiales</strong> solo para suscriptores</li>
                <li><strong>Acceso anticipado</strong> a promociones</li>
            </ul>
        </div>

        <h2>Nuestras Marcas Destacadas</h2>
        
        <p>Trabajamos con las mejores marcas de perfumería internacional para ofrecerte fragancias únicas y de la más alta calidad.</p>

        <div style="text-align: center;">
            <a href="{{ route('home') }}" class="button">Explorar Catálogo</a>
        </div>

        <p>Mantente atento a tu bandeja de entrada para no perderte nuestras increíbles ofertas.</p>

        <div class="footer">
            <strong>Edward Villa Perfumería</strong><br>
            <em>Esencia y apariencia</em>
            
            <div class="unsubscribe">
                Si no deseas recibir más correos, puedes <a href="{{ $unsubscribeUrl }}">desuscribirte aquí</a>.
            </div>
        </div>
    </div>
</body>
</html>
