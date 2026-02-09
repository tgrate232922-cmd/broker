@php
  $brand    = isset($appName) && $appName ? $appName : (config('app.name', 'Online Banking'));
  $isRenew  = true;
@endphp
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>Trade Signals Subscription Renewed – {{ $brand }}</title>
  <style>
    /* ===== Corporate Email – Dark Blue Primary (no emojis) ===== */
    :root{
      --navy:#0f172a;       /* primary dark blue */
      --navy-800:#0b1220;
      --blue:#1d4ed8;       /* action blue */
      --text:#0b1320;       /* high-contrast text */
      --muted:#475569;
      --card:#ffffff;
      --border:#e6ecf5;
      --radius:14px;
      --shadow:0 14px 38px rgba(3,10,26,.14);
    }

    html,body{
      margin:0;padding:0;background:#f6f8fb;color:var(--text);
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    }

    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}

    .wrap{width:100%;padding:28px 14px;}
    .card{
      width:100%;max-width:640px;margin:0 auto;background:var(--card);
      border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);
    }

    /* Masthead */
    .mast{background:var(--navy);color:#e6eef7;padding:18px 22px;border-bottom:1px solid rgba(255,255,255,.12);}
    .brandrow{display:flex;align-items:center;gap:12px;}
    .brandname{font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;}
    .status{margin-left:auto;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);}
    .status.renew{background:var(--navy-800);color:#9cc1ff;}

    /* Body */
    .body{padding:22px;}
    h1{margin:0 0 6px;font-size:20px;line-height:1.35;color:var(--text);}
    p{margin:10px 0 0;line-height:1.6;font-size:14px;color:var(--text);}
    .lead{margin-top:12px;font-size:15px;}

    .amount{margin:18px 0 16px;display:flex;align-items:baseline;gap:12px;flex-wrap:wrap;}
    .amt-val{font-size:28px;font-weight:900;color:var(--text);}
    .amt-chip{font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:#eef2ff;color:#1e40af;border:1px solid #e0e7ff;}

    .kv{margin:18px 0;border:1px solid var(--border);border-radius:12px;overflow:hidden;}
    .row{display:flex;justify-content:space-between;gap:14px;padding:12px 14px;border-top:1px solid var(--border);}
    .row:first-child{border-top:0;}
    .k{font-weight:800;font-size:12px;color:var(--muted);letter-spacing:.02em;}
    .v{font-weight:900;color:var(--text);font-size:14px;word-break:break-word;}

    .cta{margin:22px 0 8px;}
    .btn{
      display:inline-block;text-decoration:none;font-weight:900;font-size:14px;padding:12px 16px;border-radius:12px;
      border:1px solid var(--blue);background:var(--blue);color:#fff;
    }

    .foot{padding:14px 22px;border-top:1px solid var(--border);background:#f8fafc;color:var(--muted);font-size:12px;line-height:1.5;}

    /* Dark mode */
    @media (prefers-color-scheme: dark){
      html,body{background:#0b1220;color:#e6eef7;}
      .card{background:#0f172a;border-color:#1e293b;}
      .mast{background:#0b1220;border-bottom-color:#1e293b;}
      .body p, .k, .v, h1 { color:#e6eef7; }
      .kv{border-color:#1e293b;}
      .row{border-top-color:#1e293b;}
      .foot{background:#0b1220;border-top-color:#1e293b;color:#9fb1c7;}
      .amt-chip{background:#1e293b;color:#bfdbfe;border-color:#334155;}
      .btn{border-color:#60a5fa;background:#60a5fa;}
    }
  </style>
</head>
<body>
  <!-- Inbox preview text (hidden) -->
  <div class="preheader">Your trade signals subscription has been renewed.</div>

  <div class="wrap">
    <div class="card">
      <!-- Masthead -->
      <div class="mast">
        <div class="brandrow">
          @isset($logoUrl)
            @if($logoUrl)
              <img src="{{ $logoUrl }}" alt="{{ $brand }} logo" width="28" height="28" style="display:block;border:0;border-radius:6px;">
            @endif
          @endisset
          <div class="brandname">{{ $brand }}</div>
          <div class="status renew">Subscription Renewed</div>
        </div>
      </div>

      <!-- Body -->
      <div class="body">
        <h1>
          Hi {{ trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer') }},
        </h1>

        <p class="lead">
          Your trade signals subscription has been renewed successfully.
        </p>

        <div class="amount">
          <div class="amt-val">
            {{ number_format($amount ?? 0, 2) }} {{ $currency ?? 'USD' }}
          </div>
          <div class="amt-chip">{{ strtoupper($subscription ?? 'MONTHLY') }}</div>
        </div>

        <div class="kv">
          <div class="row">
            <div class="k">Reference</div>
            <div class="v">{{ $reference ?? '' }}</div>
          </div>
          <div class="row">
            <div class="k">Date &amp; Time</div>
            <div class="v">
              @if(!empty($posted_at)) {{ \Illuminate\Support\Carbon::parse($posted_at)->format('Y-m-d H:i') }} @endif
            </div>
          </div>
          <div class="row">
            <div class="k">Plan</div>
            <div class="v">{{ $subscription ?? 'Monthly' }}</div>
          </div>
          <div class="row">
            <div class="k">Next Renewal</div>
            <div class="v">
              @if(!empty($next_renewal)) {{ \Illuminate\Support\Carbon::parse($next_renewal)->format('Y-m-d') }} @endif
            </div>
          </div>
        </div>

       

        <p style="margin-top:14px;">
          If you have any questions about your subscription, please reply to this email or contact support.
        </p>
      </div>

      <!-- Footer -->
      <div class="foot">
        © {{ date('Y') }} {{ $brand }}. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
