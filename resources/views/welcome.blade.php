<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Modern GIS') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg-dark: #0f172a;
            --accent: #22d3ee;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: #f8fafc;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(34, 211, 238, 0.1) 0%, transparent 50%);
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 32px;
            padding: 4rem 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .hero-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .badge-new {
            background: rgba(99, 102, 241, 0.1);
            color: var(--accent);
            border: 1px solid rgba(34, 211, 238, 0.2);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .btn-modern {
            padding: 14px 32px;
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary-modern {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 20px -10px var(--primary);
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            transform: translateY(-5px);
            color: white;
            box-shadow: 0 15px 25px -10px var(--primary);
        }

        .btn-outline-modern {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
        }

        .btn-outline-modern:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.4);
        }

        footer {
            position: absolute;
            bottom: 2rem;
            width: 100%;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Abstract Shape */
        .shape {
            position: absolute;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="hero-card">
                    <span class="badge-new">
                        <i class="bi bi-stars me-2"></i>Next-Gen Mapping App
                    </span>
                    
                    <div class="feature-icon">
                        <i class="bi bi-geo-fill"></i>
                    </div>

                    <h1 class="display-4 gradient-text mb-3">GeoSpatial Intelligence</h1>
                    <p class="lead text-secondary mb-5 px-md-5">
                        Kelola data spasial dengan antarmuka modern. Visualisasikan titik, poligon, dan jalur secara real-time dengan akurasi tinggi.
                    </p>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn-modern btn-primary-modern">
                                    <i class="bi bi-compass"></i> Dashboard Utama
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-modern btn-primary-modern">
                                    <i class="bi bi-door-open"></i> Mulai Sekarang
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-modern btn-outline-modern">
                                        Buat Akun Baru
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                    
                    <div class="row mt-5 pt-4 border-top border-secondary border-opacity-10">
                        <div class="col-4 border-end border-secondary border-opacity-10">
                            <h5 class="mb-1 fw-bold">10+</h5>
                            <p class="small text-secondary mb-0">Basemaps</p>
                        </div>
                        <div class="col-4 border-end border-secondary border-opacity-10">
                            <h5 class="mb-1 fw-bold">Live</h5>
                            <p class="small text-secondary mb-0">Editing</p>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-1 fw-bold">Fast</h5>
                            <p class="small text-secondary mb-0">Analysis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Crafted for the Future
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>