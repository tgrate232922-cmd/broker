<?php
  // Inputs expected from the mailable:
  // $brand, $logoUrl, $isAdmin, $ref, $amount, $currency, $payment_mode, $status, $proofUrl, $submitted_at,
  // $userFullName, $userEmail, $userPortalUrl, $adminPortalUrl, $supportEmail, $subjectLine

  // Headline from subject (keeps your controller-driven subject)
  $headline = $subjectLine ?: 'Deposit Update';

  // Palette (dark-blue primary, approved design)
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

  // Status accent
  $statusLower = strtolower($status ?? 'pending');
  if (in_array($statusLower, ['processed','success','successful','completed'])) {
    $pillColor = '#9cc1ff'; $chipBg=$blueSoftBg; $chipText=$blueDeep; $chipBorder=$blueSoftBrd; $accent=$blue;
  } elseif (in_array($statusLower, ['failed','rejected','declined'])) {
    $pillColor = '#f4b6bd'; $chipBg='#fee2e2'; $chipText='#991b1b'; $chipBorder='#fecaca'; $accent='#ef4444';
  } else { // pending
    $pillColor = '#c7d2fe'; $chipBg='#fef3c7'; $chipText='#f59e0b'; $chipBorder='#fde68a'; $accent=$blue;
  }

  $amt = number_format((float)$amount, 2);
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($headline); ?> | <?php echo e($brand); ?></title>
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
    <?php echo e($isAdmin ? "New deposit submitted by {$userFullName}" : "Your deposit request has been received"); ?>

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
                    <?php if(!empty($logoUrl)): ?>
                      <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                    <?php endif; ?>
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
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:#0b1320;">
                <?php echo e($isAdmin ? 'New Deposit Submitted' : 'Deposit Received'); ?>

              </h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;color:#0b1320;">
                <?php if($isAdmin): ?>
                  A customer has submitted a deposit request. Review the details below and take action in the dashboard.
                <?php else: ?>
                  We’ve recorded your deposit request. The details are below; you’ll receive an update once it’s processed.
                <?php endif; ?>
              </p>
            </td>
          </tr>

          <!-- Amount + Mode band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="font-size:28px;font-weight:900;color:#0b1320;">
                          <?php echo e($amt); ?> <?php echo e($currency); ?>

                        </td>
                        <td align="right">
                          <span style="font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:<?php echo e($chipBg); ?>;color:<?php echo e($chipText); ?>;border:1px solid <?php echo e($chipBorder); ?>;">
                            <?php echo e(strtoupper($payment_mode ?? 'N/A')); ?>

                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:12px;">
                          <div style="height:4px;width:100%;background:linear-gradient(90deg, <?php echo e($accent); ?> 0%, <?php echo e($accent); ?> 60%, rgba(0,0,0,0) 60%);border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Key-Value Grid -->
          <tr>
            <td style="padding:18px 22px 8px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <?php if($isAdmin): ?>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Customer</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:#0b1320;font-weight:900;font-size:14px;">
                    <?php echo e($userFullName); ?> &lt;<?php echo e($userEmail); ?>&gt;
                  </td>
                </tr>
                <?php endif; ?>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:#0b1320;font-weight:900;font-size:14px;"><?php echo e($ref); ?></td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:#0b1320;font-weight:900;font-size:14px;">
                    <?php echo e(ucfirst($statusLower)); ?>

                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Submitted</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:#0b1320;font-weight:900;font-size:14px;">
                    <?php echo e(optional($submitted_at)->format('Y-m-d H:i')); ?>

                  </td>
                </tr>
                <?php if(!empty($proofUrl)): ?>
                <tr>
                  <td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Proof</td>
                  <td style="padding:12px 14px;color:#0b1320;font-weight:900;font-size:14px;word-break:break-word;">
                    <a href="<?php echo e($proofUrl); ?>" style="color:#1d4ed8;text-decoration:underline;">View uploaded proof</a>
                  </td>
                </tr>
                <?php endif; ?>
              </table>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td style="padding:20px 22px 6px 22px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="left">
                <tr>
                  <td bgcolor="<?php echo e($blue); ?>" style="border-radius:12px;">
                    <a href="<?php echo e($isAdmin ? $adminPortalUrl : $userPortalUrl); ?>"
                       style="display:inline-block;padding:12px 18px;border-radius:12px;background:<?php echo e($blue); ?>;border:1px solid <?php echo e($blue); ?>;color:#ffffff;font-weight:900;font-size:14px;line-height:1;text-decoration:none;">
                      <?php echo e($isAdmin ? 'Open Admin Dashboard' : 'View Deposits'); ?>

                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Support -->
          <tr>
            <td style="padding:8px 22px 6px 22px;">
              <p style="margin:0;line-height:1.6;font-size:14px;color:#0b1320;">
                Questions? Contact <strong>support</strong>.
              </p>
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
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/deposits/status.blade.php ENDPATH**/ ?>