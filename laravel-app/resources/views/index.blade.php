<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <style>
        body {
            font-family: 'figtree', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        video {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            transform: translateX(-50%) translateY(-50%);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            z-index: 1;
        }

        .auth-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .auth-buttons a {
            display: inline-block;
            margin: 8px;
            padding: 20px 20px;
            font-size: 18px;
            text-decoration: none;
            color: #fff;
            background-color: #0852C5;
            border-radius: 8px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .auth-buttons a:hover {
            background-color: #06428C;
        }
    </style>
</head>
<body>
    <video autoplay muted loop>
        <source src="{{ asset('videos/videoAutoconf.mp4') }}" type="video/mp4">
        Seu navegador não suporta a tag de vídeo.
    </video>
    
    <div class="overlay"></div>

    <div class="container">
        <div class="auth-buttons">
            @auth
                <a href="{{ url('/dashboard') }}">Painel</a>
            @else
                <a href="{{ route('login') }}">Entrar</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registrar</a>
                @endif
            @endauth
        </div>
    </div>
</body>
</html>
