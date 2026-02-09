
<?php
  // ===== Incoming data (from your $demo object) =====
  $receiverName = (string)($demo->receiver_name ?? 'Member');

  // Re-map legacy "plan" fields to DAO terminology
  $poolName   = (string)($demo->receiver_plan ?? $demo->pool_name ?? 'DAO Pool');
  
  $amount = $demo->received_amount ?? '0.00';

 

  // Date (safe parse)
  $dt = $demo->date ?? now();
  $dateStr = \Illuminate\Support\Carbon::parse($dt)->format('D, M j, Y h:i A');

  // Sender / branding
  $brand      = config('app.name','');
  $senderName = (string)($demo->sender ?? $brand);
  $logoUrl    = config('app.logo_url');

  // ===== UI palette (same as deposit/withdrawal screenshots) =====
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

  // Event content (DAO)
  $headline  = (string)($headline ?? $subjectLine ?? 'DAO pool cycle completed');
  $statusLabel = 'Completed';

  // Reference / position id (optional)
  $ref = (string)($demo->ref ?? $demo->position_id ?? ('DAO-POOL-'.($demo->id ?? '0')));
  $refShort = strlen($ref) > 18 ? substr($ref, 0, 10) . '…' . substr($ref, -6) : $ref;

  // Use DAO terms: "stake release" / "rewards release"
  // You can override via $demo->release_type e.g. "Stake Released" or "Rewards Released"
  $releaseType = (string)($demo->release_type ?? 'Stake Released');

  $preheader = "DAO pool update: {$poolName} completed. {$releaseType}: {$amount} ";
?>

<!DOCTYPE html>
<html lang="en" style="background:<?php echo e($bg); ?>;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo e($headline); ?> | <?php echo e($brand); ?></title>
  <style>
    html,body{
      margin:0;padding:0;background:<?php echo e($bg); ?>;color:<?php echo e($text); ?>;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    .mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;letter-spacing:.2px;}
    @media (max-width:680px){ .container{width:100%!important;} .px{padding-left:16px!important;padding-right:16px!important;} }
  </style>
</head>

<body>
  <div class="preheader"><?php echo e($preheader); ?></div>

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
                radial-gradient(900px 260px at 50% -40%, rgba(47,107,255,.26) 0%, rgba(47,107,255,0) 60%),
                radial-gradient(700px 240px at 110% 0%, rgba(34,211,238,.14) 0%, rgba(34,211,238,0) 60%),
                <?php echo e($panel); ?>;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:<?php echo e($text); ?>;font-weight:900;letter-spacing:.35px;font-size:14px;line-height:1.2;">
                    <?php if(!empty($logoUrl)): ?>
                      <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28"
                           style="vertical-align:middle;border:0;border-radius:8px;margin-right:10px;">
                    <?php endif; ?>
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>

                    <span style="display:inline-block;margin-left:10px;padding:3px 10px;border-radius:999px;
                                 border:1px solid rgba(226,232,240,.14);
                                 background:rgba(17,28,51,.65);
                                 color:<?php echo e($muted); ?>;font-size:11px;font-weight:900;">
                      DAO HUB
                    </span>
                  </td>

                  <td align="right">
                    <span class="mono" style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:rgba(34,197,94,.14);border:1px solid rgba(34,197,94,.28);
                                 color:#b7f7cb;font-weight:900;font-size:11px;">
                      <?php echo e($statusLabel); ?>

                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:<?php echo e($text); ?>;font-weight:900;">
                <?php echo e($headline); ?>

              </h1>

              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:<?php echo e($muted); ?>;">
                Hello <?php echo e($receiverName); ?>, your DAO pool cycle has completed. A release summary is below.
              </p>
            </td>
          </tr>

          <!-- Summary -->
          <tr>
            <td class="px" style="padding:16px 22px 6px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke); ?>;border-radius:18px;overflow:hidden;background:rgba(17,28,51,.55);">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="color:<?php echo e($text); ?>;font-weight:900;font-size:16px;">
                          <?php echo e($poolName); ?>

                        </td>
                     
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:12px;">
                          <div style="height:4px;width:100%;
                                      background:linear-gradient(90deg, <?php echo e($blue2); ?> 0%, <?php echo e($cyan); ?> 55%, <?php echo e($green); ?> 100%);
                                      border-radius:999px;"></div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:10px;color:<?php echo e($muted2); ?>;font-size:12px;">
                          Pool status: <span class="mono" style="color:<?php echo e($text); ?>;font-weight:800;">COMPLETED</span>
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
            <td class="px" style="padding:10px 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(11,18,32,.35);">

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;width:42%;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Position ID
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <span class="mono" style="display:inline-block;padding:2px 8px;border-radius:999px;background:rgba(47,107,255,.12);border:1px solid rgba(47,107,255,.25);">
                      <?php echo e($refShort); ?>

                    </span>
                    
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    DAO Pool
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php echo e($poolName); ?>

                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    <?php echo e($releaseType); ?>

                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php echo e($amount); ?> 
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Date
                  </td>
                  <td style="padding:14px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <span class="mono"><?php echo e($dateStr); ?></span>
                  </td>
                </tr>
              </table>

              <div style="height:12px;"></div>

              <div style="color:<?php echo e($muted2); ?>;font-size:12px;line-height:1.6;">
                Kind regards,<br>
                <?php echo e($senderName); ?>.
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px" style="padding:14px 22px;border-top:1px solid <?php echo e($stroke2); ?>;
                                  background:rgba(11,18,32,.35);color:<?php echo e($muted2); ?>;
                                  font-size:12px;line-height:1.6;">
              © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/emails/endplan.blade.php ENDPATH**/ ?>