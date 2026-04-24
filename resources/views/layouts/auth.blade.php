<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JustProperties - Auth')</title>
    @livewireStyles

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #147257 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .background span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }

        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Main Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Card */
        .auth-card {
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Left Panel - Branding */
        .brand-panel {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            padding: 3rem 2rem;
            color: white;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .brand-content {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
        }

        .logo img {
            width: 48px;
            height: 48px;
            filter: brightness(0) invert(1);
        }

        .logo span {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .brand-text {
            margin-bottom: 3rem;
        }

        .brand-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 1rem;
            color: #d1fae5;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* Features List */
        .features {
            list-style: none;
            margin-top: auto;
        }

        .features li {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .features li:last-child {
            border-bottom: none;
        }

        .features i {
            font-size: 1.25rem;
            color: #d1fae5;
        }

        .features span {
            font-size: 0.95rem;
        }

        /* Right Panel - Form */
        .form-panel {
            padding: 3rem 2.5rem;
            background: white;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-header a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 2rem 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Animated Background -->
    <div class="background" id="background"></div>

    <div class="container">
        {{ $slot }}
    </div>

    <script>
        // Generate animated background bubbles
        function createBubbles() {
            const background = document.getElementById('background');
            const colors = ['rgba(5,150,105,0.1)', 'rgba(5,150,105,0.2)', 'rgba(5,150,105,0.15)'];

            for (let i = 0; i < 50; i++) {
                const span = document.createElement('span');
                const size = Math.random() * 100 + 20;
                span.style.width = size + 'px';
                span.style.height = size + 'px';
                span.style.left = Math.random() * 100 + '%';
                span.style.animationDuration = Math.random() * 20 + 10 + 's';
                span.style.animationDelay = Math.random() * 5 + 's';
                span.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                span.style.borderRadius = '50%';
                background.appendChild(span);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            createBubbles();
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
