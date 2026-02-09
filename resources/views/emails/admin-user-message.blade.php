@php
  $brand = $appName ?? config('app.name','');
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  // Screenshot-inspired palette (same family as deposit emails)
  $bg        = '#0b1220';
  $panel     = '#0f172a';
  $panel2    = '#111c33';
  $stroke    = 'rgba(148,163,184,.16)';
  $stroke2   = 'rgba(148,163,184,.12)';
  $text      = '#e6eef7';
  $muted     = '#9fb0c7';
  $muted2    = '#7f93ad';

  $blue      = '#2f6bff';
  $blue2     = '#1f4fff';
  $cyan      = '#22d3ee';

  $subjectSafe = (string)($subjectLine ?? 'Message');
  $bodySafe    = (string)($messageBody ?? '');

  // Safer date handling (prevents render failure if $posted_at is null/string)
  $dt = $posted_at ?? now();
  $sentAt = \Illuminate\Support\Carbon::parse($dt)->format('D, M j, Y h:i A');

  $support = (string)($supportEmail ?? '');

  // Optional CTA
  $ctaUrl  = $userPortalUrl ?? '';
  $ctaText = 'Open Dashboard';
@endphp

<!DOCTYPE html>
<html lang="en" style="background:{{ $bg }};">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $subjectSafe }} – {{ $brand }}</title>
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
  <div class="preheader">{{ $subjectSafe }}</div>

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
                radial-gradient(900px 260px at 50% -40%, rgba(47,107,255,.26) 0%, rgba(47,107,255,0) 60%),
                radial-gradient(700px 240px at 110% 0%, rgba(34,211,238,.14) 0%, rgba(34,211,238,0) 60%),
                {{ $panel }};">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:{{ $text }};font-weight:900;letter-spacing:.35px;font-size:14px;line-height:1.2;">
                    <span style="vertical-align:middle">{{ $brand }}</span>
                    <span style="display:inline-block;margin-left:10px;padding:3px 10px;border-radius:999px;
                                 border:1px solid rgba(226,232,240,.14);
                                 background:rgba(17,28,51,.65);
                                 color:{{ $muted }};font-size:11px;font-weight:900;">
                      MESSAGE
                    </span>
                  </td>
                  <td align="right">
                    <span class="mono" style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:rgba(11,18,32,.45);border:1px solid {{ $stroke2 }};
                                 color:{{ $muted }};font-weight:900;font-size:11px;">
                      {{ $sentAt }}
                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:{{ $text }};font-weight:900;">
                {{ $subjectSafe }}
              </h1>
              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:{{ $muted }};">
                Dear {{ $fullName }}, 
              </p>
            </td>
          </tr>

          <!-- Message Card -->
          <tr>
            <td class="px" style="padding:16px 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid {{ $stroke2 }};border-radius:18px;overflow:hidden;background:rgba(17,28,51,.55);">
                <tr>
                  <td style="padding:16px;">
                    

                    <div style="color:{{ $text }};font-size:14px;line-height:1.75;">
                      {!! nl2br(e($bodySafe)) !!}
                    </div>

                    <div style="margin-top:14px;height:1px;background:{{ $stroke2 }};"></div>

                    <div style="margin-top:12px;color:{{ $muted2 }};font-size:12px;line-height:1.6;">
                      Sent on <span class="mono">{{ $sentAt }}</span>
                    </div>
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
              
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px" style="padding:14px 22px;border-top:1px solid {{ $stroke2 }};
                                  background:rgba(11,18,32,.35);color:{{ $muted2 }};
                                  font-size:12px;line-height:1.6;">
              Support<br>
              © {{ date('Y') }} {{ $brand }}.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>