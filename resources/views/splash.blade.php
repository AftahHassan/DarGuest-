<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DarGuest</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; background: #fff; }
        .splash-bg-pattern {
            position: absolute; inset: 0; opacity: 0.03;
            background-image: radial-gradient(circle at 2px 2px, #2563EB 1px, transparent 0);
            background-size: 32px 32px;
        }
        .splash-illustration {
            position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 600px; height: 300px; opacity: 0.06;
            background: radial-gradient(ellipse at bottom, #2563EB, transparent 70%);
        }
        @keyframes logoEntry {
            0% { opacity: 0; transform: scale(0.5) translateY(20px); }
            60% { opacity: 1; transform: scale(1.05) translateY(-5px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes textEntry {
            0% { opacity: 0; transform: translateY(16px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes barLoad {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
        .anim-logo { animation: logoEntry 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards; opacity: 0; }
        .anim-title { animation: textEntry 0.6s ease-out 0.7s forwards; opacity: 0; }
        .anim-slogan { animation: textEntry 0.6s ease-out 0.9s forwards; opacity: 0; }
        .anim-bar { animation: barLoad 1.8s ease-in-out 0.5s forwards; width: 0%; }
        .anim-exit { animation: fadeOut 0.4s ease-in 2.8s forwards; }
    </style>
</head>
<body>
    <div class="splash-screen anim-exit">
        <div class="splash-bg-pattern"></div>
        <div class="splash-illustration"></div>

        <div class="relative z-10 flex flex-col items-center">
            {{-- Logo --}}
            <div class="anim-logo mb-6">
                <div class="w-20 h-20 rounded-2xl bg-primary-600 flex items-center justify-center shadow-elevated">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
            </div>

            {{-- Name --}}
            <h1 class="anim-title text-3xl font-bold text-surface-900 tracking-tight mb-2">
                Dar<span class="text-primary-600">Guest</span>
            </h1>

            {{-- Slogan --}}
            <p class="anim-slogan text-surface-500 text-sm font-medium tracking-wide">
                Smart Concierge for Vacation Rentals
            </p>

            {{-- Loading Bar --}}
            <div class="mt-10 splash-progress">
                <div class="splash-progress-bar anim-bar"></div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = '{{ route("login") }}';
        }, 3200);
    </script>
</body>
</html>
