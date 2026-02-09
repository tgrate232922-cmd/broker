<?php
  $brand = $appName ?? config('app.name','Online Banking');
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  // Palette
  $navy        = '#0f172a';
  $navy800     = '#0b1220';
  $text        = '#0b1320';
  $muted       = '#475569';
  $border      = '#e6ecf5';
  $card        = '#ffffff';

  $subjectSafe = $subjectLine ?? 'Message';
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectSafe); ?> – <?php echo e($brand); ?></title>
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
  <div class="preheader"><?php echo e($subjectSafe); ?></div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0"
               style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:<?php echo e($navy800); ?>;color:#c7d2fe;">
                      Message
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting + Intro -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;">Hi <?php echo e($fullName); ?>,</h1>
              <p style="margin:6px 0 0;line-height:1.6;font-size:14px;">
                You’ve received a new message from our team.
              </p>
            </td>
          </tr>

          <!-- Message block -->
          <tr>
            <td style="padding:0 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;background:#f8fafc;">
                <tr>
                  <td style="padding:16px 16px 8px 16px;color:#475569;font-size:12px;font-weight:800;">
                    Subject
                  </td>
                </tr>
                <tr>
                  <td style="padding:0 16px 14px 16px;color:#0b1320;font-size:14px;font-weight:900;">
                    <?php echo e($subjectSafe); ?>

                  </td>
                </tr>
                <tr>
                  <td style="padding:0 16px 10px 16px;color:#475569;font-size:12px;font-weight:800;">
                    Message
                  </td>
                </tr>
                <tr>
                  <td style="padding:0 16px 18px 16px;color:#0b1320;font-size:14px;line-height:1.7;">
                    <?php echo nl2br(e($messageBody ?? '')); ?>

                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 16px;border-top:1px solid <?php echo e($border); ?>;color:#0b1320;font-size:12px;">
                    Sent on <?php echo e(\Illuminate\Support\Carbon::parse($posted_at)->format('Y-m-d H:i')); ?>

                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 22px;border-top:1px solid <?php echo e($border); ?>;background:#f8fafc;color:#475569;font-size:12px;line-height:1.5;">
              © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/admin-user-message.blade.php ENDPATH**/ ?>