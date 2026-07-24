<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'YES INDIA SCHOOLS ERP - Registration & Status Management System')</title>
    <meta name="description" content="YES INDIA Schools ERP - School Registration and Status Management System.">

    <!-- Google Fonts: Inter & Playfair Display / Serif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=Newsreader:ital,opsz,wght@1,6..72,400;1,6..72,500;1,6..72,600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['Newsreader', 'Georgia', 'serif'],
                    },
                    colors: {
                        erp: {
                            bg: '#ffffff',
                            purple: '#271e6d',
                            purpleDark: '#1f1659',
                            purpleLight: '#372d85',
                            pillBg: '#f3f2fa',
                            pillBorder: '#e2e1f0',
                            inputBg: '#f9f9fd',
                            inputBorder: '#e2e2ee',
                            dotGreen: '#10b981',
                            dotYellow: '#eab308',
                            dotPurple: '#a855f7',
                            dotRed: '#ef4444',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1e1b4b;
        }

        /* Title Typography */
        .title-brand {
            color: #271e6d;
            font-weight: 800;
            letter-spacing: 0.05em;
        }
        .section-italic-title {
            font-family: 'Newsreader', Georgia, serif;
            font-style: italic;
            color: #271e6d;
            font-weight: 500;
        }

        /* Pill Badge */
        .badge-status-top {
            background-color: #271e6d;
            color: #ffffff;
            border-radius: 9999px;
            padding: 8px 24px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Zone Filter Pill */
        .zone-pill-btn {
            background-color: #f3f2fa;
            color: #271e6d;
            border: 1px solid #e2e1f0;
            border-radius: 12px;
            padding: 6px 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }

        /* Dark Purple Status Card */
        .card-status-dark {
            background-color: #271e6d;
            color: #ffffff;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 4px 12px rgba(39, 30, 109, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 110px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-status-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(39, 30, 109, 0.25);
        }

        /* Custom Form Input Fields matching reference */
        .form-pill-input {
            width: 100%;
            background-color: #f9f9fd;
            border: 1px solid #e2e2ee;
            border-radius: 14px;
            padding: 10px 16px;
            font-size: 0.875rem;
            color: #271e6d;
            outline: none;
            transition: all 0.2s ease;
        }
        .form-pill-input:focus {
            background-color: #ffffff;
            border-color: #271e6d;
            box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.10);
        }
        .form-pill-select {
            width: 100%;
            background-color: #f3f2fa;
            border: 1px solid #e2e1f0;
            border-radius: 14px;
            padding: 10px 36px 10px 16px;
            font-size: 0.875rem;
            color: #271e6d;
            font-weight: 500;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23271e6d'%3E%3Cpath d='M12 15l-5-5h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .form-pill-select:focus {
            background-color: #ffffff;
            border-color: #271e6d;
        }

        /* Form Buttons */
        .btn-purple-action {
            background-color: #271e6d;
            color: #ffffff;
            border-radius: 14px;
            padding: 12px 32px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(39, 30, 109, 0.25);
            transition: all 0.2s ease;
        }
        .btn-purple-action:hover {
            background-color: #1f1659;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(39, 30, 109, 0.35);
        }

        /* Green Indicator Dot */
        .dot-indicator-green {
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background-color: #10b981;
            display: inline-block;
            flex-shrink: 0;
        }

        /* Blinking dot animation */
        @keyframes dotBlink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.3; transform: scale(0.75); }
        }
        .dot-blink {
            animation: dotBlink 1.2s ease-in-out infinite;
        }

        /* Smooth animation */
        main { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: none; } }

        /* Scroll-to-Top Button */
        #scrollTopBtn {
            position: fixed;
            bottom: 32px;
            right: 28px;
            z-index: 999;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #271e6d;
            color: #ffffff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(39, 30, 109, 0.35);
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.3s ease, transform 0.3s ease, background 0.2s ease;
            pointer-events: none;
        }
        #scrollTopBtn.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        #scrollTopBtn:hover {
            background: #1f1659;
            box-shadow: 0 8px 24px rgba(39, 30, 109, 0.45);
        }
    </style>

    @yield('styles')
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-800 antialiased">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 px-5 py-3.5 bg-white border border-emerald-200 rounded-2xl shadow-xl text-sm text-emerald-800 font-semibold max-w-sm">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 px-5 py-3.5 bg-white border border-red-200 rounded-2xl shadow-xl text-sm text-red-800 font-semibold max-w-sm">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Main Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Official Laravel Framework Footer (Public Portal Only) -->
    @unless(request()->is('admin*'))
        <x-footer />
    @endunless

    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" title="Scroll to top" aria-label="Scroll to top">
        <i class="fa-solid fa-chevron-up text-sm"></i>
    </button>

    <script>
        (function () {
            // Auto scroll to top on every page load
            if (history.scrollRestoration) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);

            const btn = document.getElementById('scrollTopBtn');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    btn.classList.add('visible');
                } else {
                    btn.classList.remove('visible');
                }
            }, { passive: true });
            btn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
    </script>

    @yield('scripts')
</body>
</html>
