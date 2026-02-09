<?php
  $brand   = $appName ?? config('app.name','');

  $statusLower = strtolower($status ?? '');
  $state = in_array($statusLower, ['approved','processed','success','successful','completed'])
      ? 'approved'
      : (in_array($statusLower, ['rejected','declined','failed'])
          ? 'rejected'
          : 'updated');

  $headline = [
    'approved' => 'Deposit Confirmed',
    'rejected' => 'Deposit Not Confirmed',
    'updated'  => 'Deposit Update',
  ][$state];

  // UI palette inspired by your screenshots (image2/image3)
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
  $green     = '#22c55e';
  $amber     = '#fbbf24';
  $red       = '#fb7185';

  if ($state === 'approved') {
    $accent    = $green;
    $chipBg    = 'rgba(34,197,94,.14)';
    $chipText  = '#b7f7cb';
    $chipBorder= 'rgba(34,197,94,.28)';
    $statusLabel = 'Confirmed';
  } elseif ($state === 'rejected') {
    $accent    = $red;
    $chipBg    = 'rgba(251,113,133,.14)';
    $chipText  = '#ffd0d7';
    $chipBorder= 'rgba(251,113,133,.28)';
    $statusLabel = 'Review Needed';
  } else {
    $accent    = $amber;
    $chipBg    = 'rgba(251,191,36,.14)';
    $chipText  = '#ffe3a3';
    $chipBorder= 'rgba(251,191,36,.28)';
    $statusLabel = 'In Progress';
  }

  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $amount    = number_format((float)($deposit->amount ?? 0), 2);
  $currencyC = $currency ?? 'USD';
  $method    = $deposit->payment_mode ?? 'Payment';
  $ref       = $reference ?? ('DEP-'.$deposit->id);

  $refShort  = $ref ? (strlen($ref) > 18 ? substr($ref, 0, 10) . '…' . substr($ref, -6) : $ref) : 'N/A';

  $dateText = isset($posted_at)
    ? \Illuminate\Support\Carbon::parse($posted_at)->format('D, M j, Y h:i A')
    : '';

  // Keep language neutral to avoid spammy phrasing.
  $bodyLine = match ($state) {
    'approved' => 'Your deposit has been recorded and reflected on your account.',
    'rejected' => 'We were unable to confirm this deposit with the information provided.',
    default    => 'There is an update to your deposit record.',
  };

  // CTA (optional)
  $ctaUrl  = $dashboardUrl ?? ($userPortalUrl ?? '');
  $ctaText = 'Open Dashboard';
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo e($bg); ?>;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectLine ?? $headline); ?> – <?php echo e($brand); ?></title>
  <style>
    html,body{
      margin:0;padding:0;background:<?php echo e($bg); ?>;color:<?php echo e($text); ?>;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }
    a{color:inherit;text-decoration:none}
    .preheader{
      display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;
      max-height:0;max-width:0;opacity:0;overflow:hidden;
    }
    .mono{
      font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
      letter-spacing:.2px;
    }
    @media (max-width:680px){
      .container{width:100%!important;}
      .px{padding-left:16px!important;padding-right:16px!important;}
    }
  </style>
</head>
<body>
  <div class="preheader">
    <?php echo e($headline); ?> — <?php echo e($amount); ?> <?php echo e($currencyC); ?> (<?php echo e(strtoupper($method)); ?>).
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
         style="background:<?php echo e($bg); ?>;padding:28px 14px;">
    <tr>
      <td align="center">

        <table role="presentation" class="container" width="640" cellpadding="0" cellspacing="0" border="0"
               style="max-width:640px;background:<?php echo e($panel); ?>;
                      border:1px solid <?php echo e($stroke); ?>;
                      border-radius:18px;overflow:hidden;
                      box-shadow:0 18px 60px rgba(0,0,0,.55);">

          <!-- Header -->
          <tr>
            <td class="px" style="padding:18px 22px;border-bottom:1px solid <?php echo e($stroke2); ?>;
              background:
                radial-gradient(900px 260px at 50% -40%, rgba(47,107,255,.35) 0%, rgba(47,107,255,0) 60%),
                radial-gradient(700px 240px at 110% 0%, rgba(34,211,238,.18) 0%, rgba(34,211,238,0) 60%),
                <?php echo e($panel); ?>;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:<?php echo e($text); ?>;font-weight:950;letter-spacing:.35px;font-size:14px;line-height:1.2;">
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                    <span style="display:inline-block;margin-left:10px;padding:3px 10px;border-radius:999px;
                                 border:1px solid rgba(226,232,240,.14);
                                 background:rgba(17,28,51,.65);
                                 color:<?php echo e($muted); ?>;font-size:11px;font-weight:900;">
                      DEPOSIT
                    </span>
                  </td>

                  <td align="right">
                    <span class="mono" style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:<?php echo e($chipBg); ?>;border:1px solid <?php echo e($chipBorder); ?>;
                                 color:<?php echo e($chipText); ?>;font-weight:950;font-size:11px;">
                      <?php echo e(strtoupper($statusLabel)); ?>

                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:<?php echo e($text); ?>;font-weight:950;">
                <?php echo e($headline); ?>

              </h1>
              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:<?php echo e($muted); ?>;">
                Hi <?php echo e($fullName); ?>,<br> <?php echo e($bodyLine); ?>

              </p>
            </td>
          </tr>

          <!-- Amount card -->
          <tr>
            <td class="px" style="padding:16px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke); ?>;border-radius:18px;overflow:hidden;
                            background:rgba(17,28,51,.60);">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="font-size:30px;font-weight:950;color:<?php echo e($text); ?>;letter-spacing:.2px;">
                          <?php echo e($amount); ?>

                          <span style="font-size:14px;font-weight:900;color:<?php echo e($muted2); ?>;"><?php echo e($currencyC); ?></span>
                        </td>
                        <td align="right">
                          <span class="mono" style="font-size:11px;font-weight:950;padding:7px 10px;border-radius:999px;
                                       background:rgba(11,18,32,.55);border:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted); ?>;">
                            <?php echo e(strtoupper($method)); ?>

                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:12px;">
                          <div style="height:4px;width:100%;
                                      background:linear-gradient(90deg, <?php echo e($blue2); ?> 0%, <?php echo e($cyan); ?> 55%, <?php echo e($accent); ?> 100%);
                                      border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Details -->
          <tr>
            <td class="px" style="padding:0 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(11,18,32,.40);">
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;width:42%;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;letter-spacing:.25px;">
                    REFERENCE
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:950;font-size:13px;">
                    <span class="mono" style="display:inline-block;padding:2px 8px;border-radius:999px;background:rgba(47,107,255,.12);border:1px solid rgba(47,107,255,.25);">
                      <?php echo e($refShort); ?>

                    </span>
                    <span class="mono" style="color:<?php echo e($muted2); ?>;margin-left:8px;"><?php echo e($ref); ?></span>
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;letter-spacing:.25px;">
                    DATE &amp; TIME
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:950;font-size:13px;">
                    <span class="mono"><?php echo e($dateText); ?></span>
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;letter-spacing:.25px;">
                    STATUS
                  </td>
                  <td style="padding:14px 14px;color:<?php echo e($text); ?>;font-weight:950;font-size:13px;">
                    <?php echo e(ucfirst($statusLower ?: $state)); ?>

                  </td>
                </tr>
              </table>

              <?php if(!empty($ctaUrl)): ?>
                <div style="height:14px;"></div>
                <a href="<?php echo e($ctaUrl); ?>"
                   style="display:block;width:100%;max-width:420px;margin:0 auto;
                          padding:14px 16px;border-radius:14px;
                          background:linear-gradient(135deg, <?php echo e($blue2); ?> 0%, <?php echo e($blue); ?> 45%, <?php echo e($cyan); ?> 100%);
                          color:#071019;font-weight:950;font-size:14px;letter-spacing:.25px;text-align:center;">
                  <?php echo e($ctaText); ?>

                </a>
              <?php endif; ?>

              <div style="height:12px;"></div>

              <div style="color:<?php echo e($muted2); ?>;font-size:12px;line-height:1.6;text-align:center;">
                If you did not initiate this request, please contact support.
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px" style="padding:14px 22px;border-top:1px solid <?php echo e($stroke2); ?>;
                                  background:rgba(11,18,32,.35);color:<?php echo e($muted2); ?>;
                                  font-size:12px;line-height:1.6;">
              © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html><?php /**PATH /home/kriprand/radexchain.com/account/resources/views/emails/deposits/admin-deposit-status.blade.php ENDPATH**/ ?>