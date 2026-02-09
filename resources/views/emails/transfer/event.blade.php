@php
  // Brand + palette
  $brand = $appName ?? config('app.name','Online Banking');
  $navy='#0f172a'; $navy800='#0b1220'; $text='#0b1320'; $muted='#475569';
  $border='#e6ecf5'; $card='#ffffff'; $blue='#1d4ed8';

  $isCredit = ($direction ?? '') === 'credit';
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $amt      = number_format((float)($amount ?? 0), 2);
  $fee      = number_format((float)($charges ?? 0), 2);
  $before   = number_format((float)($balance_before ?? 0), 2);
  $after    = number_format((float)($balance_after ?? 0), 2);
@endphp
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>{{ $isCredit ? 'Transfer Alert: Credit Received' : 'Transfer Alert: Debit Sent' }} | {{ $brand }}</title>
  <style>
    html,body{margin:0;padding:0;background:#f6f8fb;color:#0b1320;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;}
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){ html,body{background:#0b1220;color:#e6eef7} }
  </style>
</head>
<body>
  <div class="preheader">
    {{ $isCredit ? 'You received a transfer into your account.' : 'A transfer has been sent from your account.' }}
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:{{ $card }};border:1px solid {{ $border }};border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:{{ $navy }};border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;">
                    @if(!empty($logoUrl))
                      <img src="{{ $logoUrl }}" alt="{{ $brand }} logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                    @endif
                    <span style="vertical-align:middle">{{ $brand }}</span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:{{ $navy800 }};color:{{ $isCredit ? '#9cc1ff' : '#f4b6bd' }};">
                      {{ $isCredit ? 'Credit Received' : 'Transfer Sent' }}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting + Lead -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:#0b1320;">Hi {{ $fullName }},</h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                {{ $isCredit
                    ? 'A transfer has been posted to your account. The summary is below.'
                    : 'Your transfer has been processed. The summary is below.' }}
              </p>
            </td>
          </tr>

          <!-- Amount strip -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" style="border:1px solid {{ $border }};border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%">
                      <tr>
                        <td style="font-size:18px;font-weight:900;color:#0b1320;">
                          {{ $isCredit ? '+' : '-' }}{{ $amt }} {{ $currency }}
                        </td>
                        <td align="right" style="font-size:12px;font-weight:800;">
                          {{ $isCredit ? 'From' : 'To' }}: {{ $counterparty ?? '—' }}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:10px;">
                          <div style="height:4px;width:100%;background:linear-gradient(90deg, {{ $blue }} 0%, {{ $blue }} 60%, rgba(0,0,0,0) 60%);border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Key/Value grid -->
          <tr>
            <td style="padding:18px 22px 8px 22px;">
              <table role="presentation" width="100%" style="border:1px solid {{ $border }};border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;width:40%;color:{{ $muted }};font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">{{ $ref ?? '—' }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Date &amp; Time</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">@if(!empty($posted_at)) {{ $posted_at->format('Y-m-d H:i') }} @else — @endif</td>
                </tr>
                @if(!$isCredit)
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Transfer Fee</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">{{ $fee }} {{ $currency }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Total Deducted</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">
                    {{ number_format((float)($amount + $charges), 2) }} {{ $currency }}
                  </td>
                </tr>
                @endif
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Balance Before</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">{{ $before }} {{ $currency }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:{{ $muted }};font-size:12px;font-weight:800;">Balance After</td>
                  <td style="padding:12px 14px;color:{{ $text }};font-weight:900;font-size:14px;">{{ $after }} {{ $currency }}</td>
                </tr>
              </table>
            </td>
          </tr>

         

          <!-- Footer -->
          <tr>
            <td style="padding:8px 22px 6px 22px;">
              <p style="margin:0;line-height:1.6;font-size:14px;">
                Questions? Contact <strong>Support</strong>.
              </p>
            </td>
          </tr>
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
