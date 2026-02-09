@php
  $brand = $appName ?? config('app.name','Scalpchain');

  // Screenshot-inspired palette (image2/image3)
  $bg        = '#0b1220';
  $panel     = '#0f172a';
  $panel2    = '#111c33';
  $stroke    = 'rgba(148,163,184,.18)';
  $stroke2   = 'rgba(148,163,184,.12)';
  $text      = '#e6eef7';
  $muted     = '#9fb0c7';
  $muted2    = '#7f93ad';

  $blue      = '#2f6bff';
  $blue2     = '#1f4fff';
  $cyan      = '#22d3ee';
  $green     = '#22c55e';
  $amber     = '#fbbf24';
  $red       = '#fb7185';

  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $currencySafe = (string)($currency ?? 'USD');

  $amt   = number_format((float)($withdrawal->amount ?? 0), 2);

  // fee can error if any part is null; guard it
  $toDeductRaw = (float)($withdrawal->to_deduct ?? 0);
  $amtRaw      = (float)($withdrawal->amount ?? 0);
  $feeRaw      = max(0, $toDeductRaw - $amtRaw);

  $fee   = number_format($feeRaw, 2);
  $total = number_format($toDeductRaw, 2);

  // Use safe string outputs to avoid view failures
  $method = strtoupper((string)($withdrawal->payment_mode ?? 'N/A'));

  $statusLower = strtolower((string)($withdrawal->status ?? 'pending'));
  if (in_array($statusLower, ['processed','success','successful','completed','approved','paid'])) {
    $accent = $green;
    $chipBg = 'rgba(34,197,94,.14)';
    $chipText = '#b7f7cb';
    $chipBorder = 'rgba(34,197,94,.28)';
    $statusLabel = 'Approved';
  } elseif (in_array($statusLower, ['failed','rejected','declined','cancelled','canceled'])) {
    $accent = $red;
    $chipBg = 'rgba(251,113,133,.14)';
    $chipText = '#ffd0d7';
    $chipBorder = 'rgba(251,113,133,.28)';
    $statusLabel = 'Rejected';
  } else {
    $accent = $amber;
    $chipBg = 'rgba(251,191,36,.14)';
    $chipText = '#ffe3a3';
    $chipBorder = 'rgba(251,191,36,.28)';
    $statusLabel = 'Pending';
  }

  $ref = 'WDL-'.str_pad((string)($withdrawal->id ?? 0), 8, '0', STR_PAD_LEFT);
  $refShort = (strlen($ref) > 18) ? substr($ref, 0, 10).'…'.substr($ref, -6) : $ref;

  $dt = $posted_at ?? ($withdrawal->created_at ?? now());
  $dateText = \Illuminate\Support\Carbon::parse($dt)->format('D, M j, Y h:i A');

  $headline = $subjectLine ?? 'Withdrawal update';

  // Optional CTA (use absolute URLs if provided)
  $ctaUrl  = $userPortalUrl ?? '';
  $ctaText = 'Open Dashboard';

  $support = (string)($supportEmail ?? 'support@scalpchain.com');
@endphp

<!DOCTYPE html>
<html lang="en" style="background:{{ $bg }};">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $headline }} | {{ $brand }}</title>
  <style>
    html,body{
      margin:0;padding:0;background:{{ $bg }};color:{{ $text }};
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    .mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;letter-spacing:.2px;}
    @media (max-width:680px){ .container{width:100%!important;} .px{padding-left:16px!important;padding-right:16px!important;} }
  </style>
</head>
<body>
  <div class="preheader">
    Withdrawal update: {{ $amt }} {{ $currencySafe }} — {{ $statusLabel }}.
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
         style="background:{{ $bg }};padding:28px 14px;">
    <tr>
      <td align="center">

        <table role="presentation" class="container" width="640" cellpadding="0" cellspacing="0" border="0"
               style="max-width:640px;background:{{ $panel }};
                      border:1px solid {{ $stroke }};
                      border-radius:18px;overflow:hidden;
                      box-shadow:0 18px 60px rgba(0,0,0,.55);">

          <!-- Header -->
          <tr>
            <td class="px" style="padding:18px 22px;border-bottom:1px solid {{ $stroke2 }};
              background:
                radial-gradient(900px 260px at 50% -40%, rgba(47,107,255,.28) 0%, rgba(47,107,255,0) 60%),
                radial-gradient(700px 240px at 110% 0%, rgba(34,211,238,.16) 0%, rgba(34,211,238,0) 60%),
                {{ $panel }};">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:{{ $text }};font-weight:900;letter-spacing:.35px;font-size:14px;line-height:1.2;">
                    @if(!empty($logoUrl))
                      <img src="{{ $logoUrl }}" alt="{{ $brand }} logo" width="28" height="28"
                           style="vertical-align:middle;border:0;border-radius:8px;margin-right:10px;">
                    @endif
                    <span style="vertical-align:middle">{{ $brand }}</span>
                    <span style="display:inline-block;margin-left:10px;padding:3px 10px;border-radius:999px;
                                 border:1px solid rgba(226,232,240,.14);
                                 background:rgba(17,28,51,.65);
                                 color:{{ $muted }};font-size:11px;font-weight:900;">
                      WITHDRAWAL
                    </span>
                  </td>
                  <td align="right">
                    <span class="mono" style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:{{ $chipBg }};border:1px solid {{ $chipBorder }};
                                 color:{{ $chipText }};font-weight:900;font-size:11px;">
                      {{ $statusLabel }}
                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:{{ $text }};font-weight:900;">
                {{ $headline }}
              </h1>
              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:{{ $muted }};">
                Hi {{ $fullName }}, this message confirms an update to your withdrawal request.
              </p>
            </td>
          </tr>

          <!-- Amount -->
          <tr>
            <td class="px" style="padding:16px 22px 6px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid {{ $stroke }};border-radius:18px;overflow:hidden;background:rgba(17,28,51,.55);">
                <tr>
                  <td style="padding:16px;text-align:center;">
                    <div style="color:{{ $muted2 }};font-size:12px;font-weight:800;letter-spacing:.2px;">REQUESTED AMOUNT</div>
                    <div style="margin-top:8px;color:{{ $text }};font-size:38px;font-weight:900;letter-spacing:.2px;">
                      {{ $amt }} <span style="font-size:14px;color:{{ $muted2 }};font-weight:800;">{{ $currencySafe }}</span>
                    </div>
                    <div style="margin-top:14px;height:4px;width:100%;
                                background:linear-gradient(90deg, {{ $blue }} 0%, {{ $cyan }} 55%, {{ $accent }} 100%);
                                border-radius:999px;"></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Details -->
          <tr>
            <td class="px" style="padding:10px 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid {{ $stroke2 }};border-radius:16px;background:rgba(11,18,32,.35);">
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};width:42%;color:{{ $muted2 }};font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $text }};font-weight:900;font-size:13px;">
                    <span class="mono" style="display:inline-block;padding:2px 8px;border-radius:999px;background:rgba(47,107,255,.12);border:1px solid rgba(47,107,255,.25);">
                      {{ $refShort }}
                    </span>
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $muted2 }};font-size:12px;font-weight:800;">Fees</td>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $text }};font-weight:900;font-size:13px;">
                    {{ $fee }} {{ $currencySafe }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $muted2 }};font-size:12px;font-weight:800;">Total to deduct</td>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $text }};font-weight:900;font-size:13px;">
                    {{ $total }} {{ $currencySafe }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $muted2 }};font-size:12px;font-weight:800;">Method</td>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $text }};font-weight:900;font-size:13px;">
                    <span class="mono">{{ $method }}</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $muted2 }};font-size:12px;font-weight:800;">Status</td>
                  <td style="padding:14px 14px;border-bottom:1px solid {{ $stroke2 }};color:{{ $text }};font-weight:900;font-size:13px;">
                    {{ $statusLabel }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;color:{{ $muted2 }};font-size:12px;font-weight:800;">Date &amp; time</td>
                  <td style="padding:14px 14px;color:{{ $text }};font-weight:900;font-size:13px;">
                    <span class="mono">{{ $dateText }}</span>
                  </td>
                </tr>
              </table>

              @if(!empty($ctaUrl))
                <div style="height:14px;"></div>
                <a href="{{ $ctaUrl }}"
                   style="display:block;width:100%;max-width:420px;margin:0 auto;
                          padding:14px 16px;border-radius:14px;
                          background:linear-gradient(135deg, {{ $blue2 }} 0%, {{ $blue }} 45%, {{ $cyan }} 100%);
                          color:#071019;font-weight:900;font-size:14px;letter-spacing:.2px;text-align:center;">
                  {{ $ctaText }}
                </a>
              @endif

              <div style="height:12px;"></div>
              <div style="color:{{ $muted2 }};font-size:12px;line-height:1.6;text-align:center;">
                This message was sent to {{ $user->email ?? 'your email' }} because you have an account with {{ $brand }}.
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px" style="padding:14px 22px;border-top:1px solid {{ $stroke2 }};
                                  background:rgba(11,18,32,.35);color:{{ $muted2 }};
                                  font-size:12px;line-height:1.6;">
              Support: <a href="mailto:{{ $support }}" style="color:{{ $blue }};text-decoration:underline;font-weight:800;">{{ $support }}</a><br>
              © {{ date('Y') }} {{ $brand }}.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>