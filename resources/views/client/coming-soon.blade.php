<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetConnect – Client Portal Coming Soon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            color: #f8fafc;
            padding: 2rem;
            overflow: hidden;
        }

        /* Animated background orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #3b82f6, transparent);
            top: -100px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #8b5cf6, transparent);
            bottom: -80px; right: -80px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-30px); }
        }

        .card {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 3rem 3.5rem;
            max-width: 560px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }

        .paw-icon {
            font-size: 4rem;
            margin-bottom: 1.25rem;
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.12); }
        }

        .badge {
            display: inline-block;
            background: rgba(59,130,246,0.2);
            border: 1px solid rgba(59,130,246,0.4);
            color: #93c5fd;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.35rem 1rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff 30%, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        p {
            color: #94a3b8;
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .user-info {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            color: #cbd5e1;
        }
        .user-info span { color: #f8fafc; font-weight: 600; }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 4px 20px rgba(59,130,246,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(59,130,246,0.5);
        }
        .btn-outline {
            background: transparent;
            color: #94a3b8;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.05);
            color: #f8fafc;
            border-color: rgba(255,255,255,0.2);
        }

        .footer-note {
            margin-top: 2.5rem;
            font-size: 0.78rem;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="paw-icon">🐾</div>
        <div class="badge">Client Portal</div>
        <h1>Coming Very Soon!</h1>
        <p>
            We're building something great for you, <strong style="color:#f1f5f9;">{{ auth()->user()->name }}</strong>!
            Your pet owner dashboard is currently under development and will be ready shortly.
        </p>

        <div class="user-info">
            ✉️ Logged in as: <span>{{ auth()->user()->email }}</span>
        </div>

        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                🏠 Go to Home Page
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="width:100%;">
                    🚪 Sign Out
                </button>
            </form>
        </div>
    </div>

    <div class="footer-note">
        VetConnect &copy; {{ date('Y') }} &mdash; Pet Care Management System
    </div>
</body>
</html>
