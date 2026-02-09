<?php
  // Branding
  $brand   = isset($appName) && $appName ? $appName : (config('app.name', 'Online Banking'));
  $logo    = $logoUrl ?? null;

  // Normalize status -> state used by the approved design
  $rawStatus = strtolower(trim($status ?? ''));
  if (in_array($rawStatus, ['verified','approve','approved','accept','accepted'])) {
    $state = 'approved';
  } elseif (in_array($rawStatus, ['reject','rejected','declined','denied'])) {
    $state = 'rejected';
  } else {
    $state = 'under_review';
  }

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

  // Palette (approved)
  $navy        = '#0f172a';
  $navy800     = '#0b1220';
  $textColor   = '#0b1320';
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
    $pillColor = '#9cc1ff'; $chipBg=$blueSoftBg; $chipText=$blueDeep; $chipBorder=$blueSoftBrd;
  } elseif($state === 'rejected'){
    $pillColor = '#f4b6bd'; $chipBg=$redBg; $chipText=$redDeep; $chipBorder=$redBrd;
  } else { // under_review
    $pillColor = '#c7d2fe'; $chipBg=$amberBg; $chipText=$amber; $chipBorder=$amberBrd;
  }

  // Recipient name
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  // Optional fields (only render if provided)
  $ref       = $reference ?? null;
  $posted_at = isset($posted_at) ? \Illuminate\Support\Carbon::parse($posted_at) : null;
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectLine ?? 'KYC Update'); ?> – <?php echo e($brand); ?></title>
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
  <!-- Inbox preview text -->
  <div class="preheader">
    <?php echo e($state === 'approved' ? 'Your KYC has been approved.' : ($state === 'rejected' ? 'A decision has been made on your KYC.' : 'Your KYC application has been received.')); ?>

  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <?php if(!empty($logo)): ?>
                      <img src="<?php echo e($logo); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                    <?php endif; ?>
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:#0b1220;color:<?php echo e($pillColor); ?>;">
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
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:<?php echo e($textColor); ?>;">Hi <?php echo e($fullName); ?>,</h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;color:<?php echo e($textColor); ?>;"><?php echo e($intro); ?></p>
            </td>
          </tr>

          <!-- Key-Value details -->
          <tr>
            <td style="padding:0 22px 8px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <?php if($ref): ?>
                  <tr>
                    <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Reference</td>
                    <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($textColor); ?>;font-weight:900;font-size:14px;"><?php echo e($ref); ?></td>
                  </tr>
                <?php endif; ?>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Date &amp; Time</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($textColor); ?>;font-weight:900;font-size:14px;">
                    <?php echo e($posted_at ? $posted_at->format('Y-m-d H:i') : ''); ?>

                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($textColor); ?>;font-weight:900;font-size:14px;">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:<?php echo e($chipBg); ?>;color:<?php echo e($chipText); ?>;border:1px solid <?php echo e($chipBorder); ?>;">
                      <?php echo e(strtoupper(str_replace('_',' ', $state))); ?>

                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <?php if(!empty($adminMessage)): ?>
            <!-- Admin note (optional) -->
            <tr>
              <td style="padding:12px 22px 8px 22px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;background:#f8fafc;">
                  <tr>
                    <td style="padding:12px 14px;">
                      <div style="color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;margin-bottom:6px;">Message from our team</div>
                      <div style="color:<?php echo e($textColor); ?>;font-size:14px;font-weight:500;line-height:1.6;">
                        <?php echo e($adminMessage); ?>

                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          <?php endif; ?>

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
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/kyc-status.blade.php ENDPATH**/ ?>