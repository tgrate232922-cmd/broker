<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;700;900&display=swap" rel="stylesheet">

        <style>
            :root{
                /* Adjust these 3 to match your platform branding */
                --bg0: #070B1D;     /* page background */
                --card: #0E1633;    /* card background */
                --accent: #1EC7B6;  /* accent line / highlights */
                --accent2:#2B6CFF;  /* secondary accent */
                --text: #EAF0FF;    /* main text */
                --muted:#AAB6D3;    /* muted text */
                --border: rgba(255,255,255,.10);
            }

            html, body { height: 100%; }

            body {
                margin: 0;
                font-family: Nunito, sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                color: var(--text);
                background:
                    radial-gradient(900px 500px at 10% 20%, rgba(46, 108, 255, .18), transparent 60%),
                    radial-gradient(700px 450px at 90% 80%, rgba(30, 199, 182, .14), transparent 60%),
                    linear-gradient(180deg, var(--bg0), #050717 70%);
            }

            a { color: inherit; text-decoration: none; }

            .wrap {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            @media (min-width: 900px) {
                .wrap {
                    flex-direction: row;
                }
            }

            .left, .right {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @media (min-width: 900px) {
                .left, .right { width: 50%; }
            }

            .card {
                width: min(520px, calc(100% - 32px));
                background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
                border: 1px solid var(--border);
                border-radius: 18px;
                padding: 28px;
                box-shadow:
                    0 18px 50px rgba(0,0,0,.45),
                    0 0 0 1px rgba(255,255,255,.03) inset;
                backdrop-filter: blur(10px);
            }

            .code {
                font-weight: 900;
                letter-spacing: .03em;
                line-height: 1;
                font-size: 56px;
                margin: 0 0 10px 0;
            }

            @media (min-width: 900px) {
                .code { font-size: 96px; }
            }

            .bar {
                height: 4px;
                width: 76px;
                border-radius: 999px;
                background: linear-gradient(90deg, var(--accent), var(--accent2));
                margin: 16px 0 18px 0;
                box-shadow: 0 0 24px rgba(30,199,182,.22);
            }

            .msg {
                margin: 0 0 22px 0;
                color: var(--muted);
                font-weight: 300;
                font-size: 18px;
                line-height: 1.6;
            }

            @media (min-width: 900px) {
                .msg { font-size: 20px; }
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                padding: 12px 18px;
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,.14);
                background: rgba(255,255,255,.04);
                color: var(--text);
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .06em;
                font-size: 12px;
                transition: transform .12s ease, border-color .12s ease, background-color .12s ease;
            }

            .btn:hover {
                transform: translateY(-1px);
                border-color: rgba(30,199,182,.55);
                background: rgba(30,199,182,.08);
            }

            .btn:active {
                transform: translateY(0);
            }

            /* Right side: decorative background */
            .right {
                position: relative;
                overflow: hidden;
                min-height: 240px;
            }

            .orb {
                position: absolute;
                width: 520px;
                height: 520px;
                border-radius: 50%;
                filter: blur(24px);
                opacity: .55;
            }

            .orb.one {
                left: -180px;
                top: -140px;
                background: radial-gradient(circle at 30% 30%, rgba(43,108,255,.55), transparent 60%);
            }

            .orb.two {
                right: -220px;
                bottom: -180px;
                background: radial-gradient(circle at 30% 30%, rgba(30,199,182,.55), transparent 60%);
            }

            .grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px);
                background-size: 56px 56px;
                opacity: .10;
                mask-image: radial-gradient(400px 300px at 50% 45%, black, transparent 70%);
            }

            .watermark {
                position: absolute;
                bottom: 22px;
                left: 22px;
                right: 22px;
                color: rgba(234,240,255,.55);
                font-weight: 700;
                letter-spacing: .08em;
                text-transform: uppercase;
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                opacity: .7;
            }

            .pill {
                border: 1px solid rgba(255,255,255,.12);
                background: rgba(255,255,255,.03);
                padding: 8px 10px;
                border-radius: 999px;
                white-space: nowrap;
            }
        </style>
    </head>

    <body>
        <div class="wrap">
            <div class="left">
                <div class="card">
                    <div class="code">
                        @yield('code', __('Oh no'))
                    </div>

                    <div class="bar"></div>

                    <p class="msg">
                        @yield('message')
                    </p>

                    <a class="btn" href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                        {{ __('Go Home') }}
                    </a>
                </div>
            </div>

            <div class="right" aria-hidden="true">
                <div class="orb one"></div>
                <div class="orb two"></div>
                <div class="grid"></div>

                <div class="watermark">
                    <div class="pill">Security • Reliability</div>
                    <div class="pill">{{ config('app.name', 'Platform') }}</div>
                </div>
            </div>
        </div>
    </body>
</html>