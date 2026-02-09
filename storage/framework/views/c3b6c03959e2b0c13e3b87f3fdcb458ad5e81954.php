<?php
  $brand   = $appName ?? config('app.name','Online Banking');
  $state   = in_array(strtolower($status ?? ''), ['approved','processed']) ? 'approved' : (in_array(strtolower($status ?? ''), ['rejected','declined']) ? 'rejected' : 'updated');

  $headline = [
    'approved' => 'Deposit Approved',
    'rejected' => 'Deposit Rejected',
    'updated'  => 'Deposit Update',
  ][$state];

  // Approved dark-blue palette
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
  $red         = '#ef4444';
  $redDeep     = '#991b1b';
  $redBg       = '#fee2e2';
  $redBrd      = '#fecaca';

  if($state === 'approved'){
    $pillColor = '#9cc1ff'; $chipBg=$blueSoftBg; $chipText=$blueDeep; $chipBorder=$blueSoftBrd;
  } elseif($state === 'rejected'){
    $pillColor = '#f4b6bd'; $chipBg=$redBg; $chipText=$redDeep; $chipBorder=$redBrd;
  } else {
    $pillColor = '#c7d2fe'; $chipBg=$blueSoftBg; $chipText=$blueDeep; $chipBorder=$blueSoftBrd;
  }

  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $amount    = number_format($deposit->amount ?? 0, 2);
  $method    = $deposit->payment_mode ?? 'Payment';
  $ref       = $reference ?? ('DEP-'.$deposit->id);
  $dateText  = isset($posted_at) ? \Illuminate\Support\Carbon::parse($posted_at)->format('Y-m-d H:i') : '';
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectLine ?? $headline); ?> – <?php echo e($brand); ?></title>
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
    <?php echo e($headline); ?> for <?php echo e($amount); ?> <?php echo e($currency ?? 'USD'); ?> via <?php echo e($method); ?>.
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead (logo removed, clean brand + status) -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:<?php echo e($navy800); ?>;color:<?php echo e($pillColor); ?>;">
                      <?php echo e($headline); ?>

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
              <?php if($state === 'approved'): ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                  Your deposit has been approved and added to your account balance.
                </p>
              <?php elseif($state === 'rejected'): ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                  Your deposit could not be approved. See the details below.
                </p>
              <?php else: ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                  There is an update to your deposit. See the details below.
                </p>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Amount band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;font-size:14px;color:<?php echo e($text); ?>;">
                    <strong style="font-size:18px;"><?php echo e($amount); ?> <?php echo e($currency ?? 'USD'); ?></strong>
                    <span style="display:inline-block;margin-left:10px;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:<?php echo e($chipBg); ?>;color:<?php echo e($chipText); ?>;border:1px solid <?php echo e($chipBorder); ?>;">
                      <?php echo e(strtoupper($method)); ?>

                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Key-Value details -->
          <tr>
            <td style="padding:18px 22px 8px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($ref); ?></td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Date &amp; Time</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($dateText); ?></td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;">
                    <?php echo e(ucfirst($state)); ?>

                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 22px;border-top:1px solid <?php echo e($border); ?>;background:#f8fafc;color:<?php echo e($muted); ?>;font-size:12px;line-height:1.5;">
              © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/deposits/admin-deposit-status.blade.php ENDPATH**/ ?>