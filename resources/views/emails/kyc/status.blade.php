@php
  $brand   = $appName ?? config('app.name','Online Banking');
  $state   = $status ?? 'under_review';

  $headline = [
    'under_review' => 'Application Received',
    'approved'     => 'Application Approved',
    'rejected'     => 'Application Decision',
  ][$state] ?? 'Application Status';

  $intro = [
    'under_review' => 'We have received your identity verification application. Our team is reviewing your information.',
    'approved'     => 'Your identity verification has been approved. Your account is now verified.',
    'rejected'     => 'Your identity verification has been reviewed. Please see the details below.',
  ][$state] ?? 'Here is an update regarding your identity verification.';

  // Dark-blue palette
  $navy        = '#0f172a';
  $navy800     = '#0b1220';
  $text        = '#0b1320';
  $muted       = '#475569';
  $border      = '#e6ecf5';
  $card        = '#ffffff';
  $blue        = '#1d4ed8';
  $blueDeep    = '#1e40af';
  $blueSoftBg  = '#eef2ff';
  $blueSoftBrd = '#e0e7ff';

  $amber       = '#f59e0b';
  $amberBg     = '#fef3c7';
  $amberBrd    = '#fde68a';

  $red         = '#ef4444';
  $redDeep     = '#991b1b';
  $redBg       = '#fee2e2';
  $redBrd      = '#fecaca';

  if($state === 'approved'){
    $pillColor = '#9cc1ff'; $chipBg=$blueSoftBg; $chipText=$blueDeep; $chipBorder=$blueSoftBrd; $accent=$blue;
  } elseif($state === 'rejected'){
    $pillColor = '#f4b6bd'; $chipBg=$redBg; $chipText=$redDeep; $chipBorder=$redBrd; $accent=$red;
  } else { // under_review
    $pillColor = '#c7d2fe'; $chipBg=$amberBg; $chipText=$amber; $chipBorder=$amberBrd; $accent=$blue;
  }

  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');
@endphp
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>KYC Update: {{ $headline }} | {{ $brand }}</title>
  <style>
    html,body{margin:0;padding:0;background:#f6f8fb;color:#0b1320;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;}
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){
      html,body{background:#0b1220;color:#e6eef7}
    }
  </style>
</head>
<body>
  <div class="preheader">
    {{ $state === 'approved' ? 'Your KYC has been approved.' : ($state === 'rejected' ? 'A decision has been made on your KYC.' : 'Your KYC application has been received.') }}
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:{{ $card }};border:1px solid {{ $border }};border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:{{ $navy }};border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    @if(!empty($logoUrl))
                      <img src="{{ $logoUrl }}" alt="{{ $brand }} logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                    @endif
                    <span style="vertical-align:middle">{{ $brand }}</span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:{{ $navy800 }};color:{{ $pillColor }};">
                      {{ $headline }}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting + Intro -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:#0b1320;">Hi {{ $fullName }},</h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;color:#0b1320;">{{ $intro }}</p>
            </td>
          </tr>

          <!-- Info band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid {{ $border }};border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="font-size:14px;color:#0b1320;">
                          Document Type: <strong>{{ strtoupper($kyc->document_type ?? 'N/A') }}</strong>
                          &nbsp;•&nbsp; Country: <strong>{{ $kyc->country ?? 'N/A' }}</strong>
                        </td>
                        <td align="right">
                          <span style="font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:{{ $chipBg }};color:{{ $chipText }};border:1px solid {{ $chipBorder }};">
                            {{ strtoupper(str_replace('_',' ', $state)) }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:12px;">
                          <div style="height:4px;width:100%;background:linear-gradient(90deg, {{ $accent }} 0%, {{ $accent }} 60%, rgba(0,0,0,0) 60%);border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>
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
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};width:40%;color:{{ $muted }};font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:#0b1320;font-weight:900;font-size:14px;">{{ $ref }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:{{ $muted }};font-size:12px;font-weight:800;">Submitted</td>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:#0b1320;font-weight:900;font-size:14px;">
                    {{ optional($posted_at)->format('Y-m-d H:i') }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:{{ $muted }};font-size:12px;font-weight:800;">Name</td>
                  <td style="padding:12px 14px;border-bottom:1px solid {{ $border }};color:#0b1320;font-weight:900;font-size:14px;">
                    {{ $fullName }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Email</td>
                  <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;">
                    {{ $user->email ?? $kyc->email ?? '' }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

       

          <!-- Support -->
          <tr>
            <td style="padding:8px 22px 6px 22px;">
              <p style="margin:0;line-height:1.6;font-size:14px;color:#0b1320;">
                Need help? Contact us at <strong>support</strong>.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 22px;border-top:1px solid {{ $border }};background:#f8fafc;color:{{ $muted }};font-size:12px;line-height:1.5;">
              © {{ date('Y') }} {{ $brand }}. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
