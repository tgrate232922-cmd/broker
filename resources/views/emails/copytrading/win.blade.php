@php
  $brand     = $appName ?? config('app.name','Online Banking');
  $fullName  = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $profitFmt   = number_format($profit ?? 0, 2);
  $balanceFmt  = number_format($currentBalance ?? 0, 2);
  $pairName    = $copyTrade->name ?? 'Copy Trading';
  $ref         = $reference ?? ('CPY-'.($copyTrade->id ?? ''));
  $dateText    = isset($posted_at) ? \Illuminate\Support\Carbon::parse($posted_at)->format('Y-m-d H:i') : now()->format('Y-m-d H:i');

  // Approved dark-blue palette
  $navy        = '#0f172a';
  $text        = '#0b1320';
  $muted       = '#475569';
  $border      = '#e6ecf5';
  $card        = '#ffffff';
  $blueDeep    = '#1e40af';
  $blueSoftBg  = '#eef2ff';
  $blueSoftBrd = '#e0e7ff';

  // Profit pill
  $pillColor = '#9cc1ff';
@endphp
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>{{ $subjectLine ?? 'Trade Win' }} – {{ $brand }}</title>
  <style>
    html,body{
      margin:0;padding:0;background:#f6f8fb;color:#0b1320;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){
      html,body{background:#0b1220;color:#e6eef7}
    }
  </style>
</head>
<body>
  <div class="preheader">
    Trade Win: +{{ $profitFmt }} {{ $currency }} on {{ $pairName }}. New balance: {{ $balanceFmt }} {{ $currency }}.
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:{{ $card }};border:1px solid {{ $border }};border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:{{ $navy }};border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <span style="vertical-align:middle">{{ $brand }}</span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:#0b1220;color:{{ $pillColor }};">
                      Profit
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting + Intro -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;">Hi {{ $fullName }},</h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                You just earned a profit on your copy trade with <strong>{{ $pairName }}</strong>.
              </p>
            </td>
          </tr>

          <!-- Amount band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid {{ $border }};border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;font-size:14px;color:{{ $text }};">
                    <strong style="font-size:18px;">+{{ $profitFmt }} {{ $currency }}</strong>
                    <span style="display:inline-block;margin-left:10px;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:{{ $blueSoftBg }};color:{{ $blueDeep }};border:1px solid {{ $blueSoftBrd }};">
                      CURRENT BAL: {{ $balanceFmt }} {{ $currency }}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Key-Value details -->
          <tr>
            <td style="padding:18px 22px 8px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid {{ $border }};border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};width:40%;color:#475569;font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:#0b1320;font-weight:900;font-size:14px;">{{ $ref }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};width:40%;color:#475569;font-size:12px;font-weight:800;">Date &amp; Time</td>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:#0b1320;font-weight:900;font-size:14px;">{{ $dateText }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:#475569;font-size:12px;font-weight:800;">Copy Trader</td>
                  <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;">{{ $pairName }}</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 22px;border-top:1px solid {{ $border }};background:#f8fafc;color:#475569;font-size:12px;line-height:1.5;">
              © {{ date('Y') }} {{ $brand }}. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
