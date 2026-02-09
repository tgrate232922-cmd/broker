
<?php
  $brand = $appName ?? config('app.name','Online Banking');
  $navy='#0f172a'; $navy800='#0b1220'; $text='#0b1320'; $muted='#475569'; $border='#e6ecf5'; $card='#ffffff';
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');
  $amt = number_format((float)($investment->investment_amount ?? 0), 2);
  $duration = $investment->expires_at ? \Carbon\Carbon::parse($investment->started_at)->diffInDays(\Carbon\Carbon::parse($investment->expires_at)) : ($bot->duration_days ?? 0);
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>Bot Investment Confirmed | <?php echo e($brand); ?></title>
  <style>
    html,body{margin:0;padding:0;background:#f6f8fb;color:#0b1320;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){ html,body{background:#0b1220;color:#e6eef7} }
  </style>
</head>
<body>
  <div class="preheader">Your bot investment has been created.</div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr><td align="center">
      <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
        <tr>
          <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
            <table width="100%"><tr>
              <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;">
                <?php if(!empty($logoUrl)): ?>
                  <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                <?php endif; ?>
                <span style="vertical-align:middle"><?php echo e($brand); ?></span>
              </td>
              <td align="right">
                <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:#0b1220;color:#9cc1ff;">Bot Investment</span>
              </td>
            </tr></table>
          </td>
        </tr>

        <tr>
          <td style="padding:22px;">
            <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:#0b1320;">Hi <?php echo e($fullName); ?>,</h1>
            <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
              Your investment in <strong><?php echo e($bot->name); ?></strong> is confirmed.
            </p>
          </td>
        </tr>

        <tr>
          <td style="padding:0 22px;">
            <table role="presentation" width="100%" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
              <tr>
                <td style="padding:12px 14px;width:40%;color:#475569;font-size:12px;font-weight:800;">Amount</td>
                <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;"><?php echo e($amt); ?> <?php echo e($currency); ?></td>
              </tr>
              <tr>
                <td style="padding:12px 14px;color:#475569;font-size:12px;font-weight:800;">Auto Reinvest</td>
                <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;">
                  <?php echo e($investment->auto_reinvest ? 'Enabled' : 'Disabled'); ?>

                  <?php if($investment->auto_reinvest): ?> (<?php echo e((float)($investment->reinvest_percentage ?? 0)); ?>%) <?php endif; ?>
                </td>
              </tr>
              <tr>
                <td style="padding:12px 14px;color:#475569;font-size:12px;font-weight:800;">Duration</td>
                <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;"><?php echo e($duration); ?> days</td>
              </tr>
              <tr>
                <td style="padding:12px 14px;color:#475569;font-size:12px;font-weight:800;">Start</td>
                <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;"><?php echo e(\Carbon\Carbon::parse($investment->started_at)->format('Y-m-d H:i')); ?></td>
              </tr>
              <tr>
                <td style="padding:12px 14px;color:#475569;font-size:12px;font-weight:800;">Ends</td>
                <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;"><?php echo e(\Carbon\Carbon::parse($investment->expires_at)->format('Y-m-d H:i')); ?></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td style="padding:20px 22px 6px 22px;">
            <a href="<?php echo e($txUrl); ?>" style="display:inline-block;padding:12px 18px;border-radius:12px;background:#1d4ed8;border:1px solid #1d4ed8;color:#fff;font-weight:900;font-size:14px;line-height:1;text-decoration:none;">
              View Transactions
            </a>
          </td>
        </tr>

        <tr>
          <td style="padding:14px 22px;border-top:1px solid <?php echo e($border); ?>;background:#f8fafc;color:#475569;font-size:12px;line-height:1.5;">
            © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. All rights reserved.
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/bot/investment-created.blade.php ENDPATH**/ ?>