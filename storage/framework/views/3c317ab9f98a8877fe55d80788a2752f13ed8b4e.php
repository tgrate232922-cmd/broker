<?php
  // Inputs expected from the mailable:
  // $brand, $logoUrl, $isAdmin, $ref, $amount, $currency, $payment_mode, $status, $proofUrl, $submitted_at,
  // $userFullName, $userEmail, $userPortalUrl, $adminPortalUrl, $supportEmail, $subjectLine

  $headline = $subjectLine ?: 'Deposit Update';

  // Palette inspired by the provided UI screenshots (image2/image3):
  // Deep navy background + smoky panels + soft borders + blue primary + status chips
  $bg        = '#0b1220';   // app background
  $panel     = '#0f172a';   // main card/panel
  $panel2    = '#111c33';   // inner card
  $stroke    = 'rgba(148,163,184,.18)'; // subtle border
  $stroke2   = 'rgba(148,163,184,.12)';
  $text      = '#e6eef7';
  $muted     = '#9fb0c7';
  $muted2    = '#7f93ad';

  $blue      = '#2f6bff';   // primary blue
  $blue2     = '#1f4fff';   // deep blue for gradients
  $cyan      = '#22d3ee';   // accent
  $green     = '#22c55e';
  $amber     = '#fbbf24';
  $red       = '#fb7185';

  // Status accent
  $statusLower = strtolower($status ?? 'pending');
  if (in_array($statusLower, ['processed','success','successful','completed'])) {
    $accent = $green;
    $chipBg = 'rgba(34,197,94,.14)';
    $chipText = '#b7f7cb';
    $chipBorder = 'rgba(34,197,94,.28)';
    $statusLabel = 'Approved';
  } elseif (in_array($statusLower, ['failed','rejected','declined'])) {
    $accent = $red;
    $chipBg = 'rgba(251,113,133,.14)';
    $chipText = '#ffd0d7';
    $chipBorder = 'rgba(251,113,133,.28)';
    $statusLabel = 'Rejected';
  } else {
    $accent = $amber;
    $chipBg = 'rgba(251,191,36,.14)';
    $chipText = '#ffe3a3';
    $chipBorder = 'rgba(251,191,36,.28)';
    $statusLabel = 'Pending';
  }

  $amt = number_format((float)$amount, 2);

  // Short hash-like reference for “blockchain” look
  $refShort = $ref ? (strlen($ref) > 18 ? substr($ref, 0, 10) . '…' . substr($ref, -6) : $ref) : 'N/A';

  // CTA target
  $ctaUrl  = $isAdmin ? ($adminPortalUrl ?? '') : ($userPortalUrl ?? '');
  $ctaText = $isAdmin ? 'Open Admin Console' : 'Back to Dashboard';

  $submittedText = optional($submitted_at)->format('D, M j, Y h:i A');
?>

<!DOCTYPE html>
<html lang="en" style="background:<?php echo e($bg); ?>;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($headline); ?> | <?php echo e($brand); ?></title>
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
    <?php echo e($isAdmin ? "New deposit submitted by {$userFullName}" : "Deposit receipt created — awaiting validation"); ?>

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

          <!-- Top / Brand -->
          <tr>
            <td class="px" style="padding:18px 22px;border-bottom:1px solid <?php echo e($stroke2); ?>;
              background:
                radial-gradient(900px 260px at 50% -40%, rgba(47,107,255,.35) 0%, rgba(47,107,255,0) 60%),
                radial-gradient(700px 240px at 110% 0%, rgba(34,211,238,.20) 0%, rgba(34,211,238,0) 60%),
                <?php echo e($panel); ?>;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:<?php echo e($text); ?>;font-weight:950;letter-spacing:.35px;font-size:14px;line-height:1.2;">
                    <?php if(!empty($logoUrl)): ?>
                      <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28"
                           style="vertical-align:middle;border:0;border-radius:8px;margin-right:10px;">
                    <?php endif; ?>
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                    <span style="display:inline-block;margin-left:10px;padding:3px 10px;border-radius:999px;
                                 border:1px solid rgba(226,232,240,.14);
                                 background:rgba(17,28,51,.65);
                                 color:<?php echo e($muted); ?>;font-size:11px;font-weight:900;">
                      DEPOSIT RECEIPT
                    </span>
                  </td>

                  <td align="right">
                    <span style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:<?php echo e($chipBg); ?>;border:1px solid <?php echo e($chipBorder); ?>;
                                 color:<?php echo e($chipText); ?>;font-weight:950;font-size:11px;"
                          class="mono">
                      <?php echo e(strtoupper($statusLabel)); ?>

                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:<?php echo e($text); ?>;font-weight:950;">
                <?php echo e($isAdmin ? 'Processing Deposit…' : 'Processing…'); ?>

              </h1>
              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:<?php echo e($muted); ?>;">
                <?php echo e($isAdmin
                    ? 'A deposit request has been created. Review details and update status in the console.'
                    : ' Your deposit request is in our queue. Once confirmed and reconciled, your balance will update automatically.'); ?>

              </p>
            </td>
          </tr>

          <!-- Progress (3-step like screenshot) -->
          <tr>
            <td class="px" style="padding:14px 22px 0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(17,28,51,.55);">
                <tr>
                  <td style="padding:14px 14px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td align="center" width="33%">
                          <div style="width:36px;height:36px;border-radius:999px;
                                      background:rgba(47,107,255,.95);
                                      box-shadow:0 10px 25px rgba(47,107,255,.25);
                                      display:inline-block;line-height:36px;color:#071019;font-weight:950;">✓</div>
                          <div style="margin-top:8px;color:<?php echo e($muted2); ?>;font-size:11px;font-weight:900;">SUBMITTED</div>
                        </td>
                        <td align="center" width="34%">
                          <div style="height:2px;background:linear-gradient(90deg, rgba(47,107,255,.9), rgba(34,211,238,.65));border-radius:999px;margin:0 10px;"></div>
                          <div style="margin-top:8px;color:<?php echo e($muted2); ?>;font-size:11px;font-weight:900;">VALIDATING</div>
                        </td>
                        <td align="center" width="33%">
                          <div style="width:36px;height:36px;border-radius:999px;
                                      background:rgba(34,197,94,.12);
                                      border:1px solid rgba(34,197,94,.35);
                                      display:inline-block;line-height:36px;color:<?php echo e($green); ?>;font-weight:950;">3</div>
                          <div style="margin-top:8px;color:<?php echo e($muted2); ?>;font-size:11px;font-weight:900;">CONFIRMED</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Receipt Card -->
          <tr>
            <td class="px" style="padding:16px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke); ?>;border-radius:18px;overflow:hidden;
                            background:
                              radial-gradient(700px 220px at 70% -50%, rgba(124,58,237,.22) 0%, rgba(124,58,237,0) 70%),
                              radial-gradient(600px 220px at 10% 120%, rgba(34,211,238,.16) 0%, rgba(34,211,238,0) 70%),
                              rgba(17,28,51,.62);">
                <tr>
                  <td style="padding:16px 16px 12px 16px;border-bottom:1px solid <?php echo e($stroke2); ?>;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="color:<?php echo e($text); ?>;font-weight:950;font-size:16px;">
                          Deposit Receipt
                        </td>
                        <td align="right" class="mono" style="color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;">
                          Ref: <?php echo e($refShort); ?>

                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 16px 16px 16px;">
                    <!-- Amount panel -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                           style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(11,18,32,.55);">
                      <tr>
                        <td style="padding:16px;text-align:center;">
                          <div style="color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;letter-spacing:.25px;">
                            DEPOSIT AMOUNT
                          </div>
                          <div style="margin-top:8px;color:<?php echo e($text); ?>;font-size:38px;font-weight:950;letter-spacing:.2px;">
                            $<?php echo e($amt); ?>

                          </div>
                          <div style="margin-top:6px;color:<?php echo e($muted); ?>;font-size:13px;line-height:1.6;">
                            If pending, the system will validate and credit your balance after confirmation.
                          </div>

                          <div style="margin-top:14px;height:4px;width:100%;
                                      background:linear-gradient(90deg, <?php echo e($blue); ?> 0%, <?php echo e($cyan); ?> 55%, <?php echo e($accent); ?> 100%);
                                      border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>

                    <div style="height:12px;"></div>

                    <!-- Details rows (like screenshot blocks) -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                           style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(11,18,32,.40);">
                      <?php if($isAdmin): ?>
                      <tr>
                        <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;">
                          <div style="color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;">USERNAME</div>
                          <div style="margin-top:6px;color:<?php echo e($text); ?>;font-size:14px;font-weight:950;">
                            <?php echo e($userFullName); ?>

                            <span style="color:<?php echo e($muted2); ?>;font-weight:800;">&lt;<?php echo e($userEmail); ?>&gt;</span>
                          </div>
                        </td>
                      </tr>
                      <?php endif; ?>

                      <tr>
                        <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;">
                          <div style="color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;">DATE &amp; TIME</div>
                          <div style="margin-top:6px;color:<?php echo e($text); ?>;font-size:14px;font-weight:950;">
                            <?php echo e($submittedText ?: optional($submitted_at)->format('Y-m-d H:i')); ?>

                          </div>
                          <div class="mono" style="margin-top:6px;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;">
                            Receipt ID: <?php echo e($refShort); ?>

                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding:14px 14px;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="vertical-align:middle;">
                                <div style="color:<?php echo e($muted2); ?>;font-size:13px;font-weight:1000;">DEPOSIT STATUS</div>
                                
                              </td>
                              <td align="right" style="vertical-align:middle;">
                                <span style="display:inline-block;padding:8px 12px;border-radius:999px;
                                             background:<?php echo e($chipBg); ?>;border:1px solid <?php echo e($chipBorder); ?>;
                                             color:<?php echo e($chipText); ?>;font-weight:950;font-size:12px;">
                                  ● <?php echo e($statusLabel); ?>

                                </span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                       <tr>
                        <td style="padding:14px 14px;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="vertical-align:middle;">
                                <div style="color:<?php echo e($muted2); ?>;font-size:13px;font-weight:1000;">ASSET</div>
                               
                              </td>
                               <td align="right" style="vertical-align:middle;">
                                <span style="display:inline-block;padding:8px 12px;border-radius:999px;
             background:<?php echo e($chipBg); ?>;border:1px solid <?php echo e($chipBorder); ?>;
             color:<?php echo e($chipText); ?>;font-weight:900;font-size:12px;">
  ● <?php echo e(strtoupper((string) ($deposit->payment_mode ?? 'N/A'))); ?>

</span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      
                      
                      
                      
                    </table>

                    <?php if(!empty($proofUrl)): ?>
                      <div style="height:12px;"></div>
                      
                    <?php endif; ?>

                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA + Support -->
          <tr>
            <td class="px" style="padding:0 22px 18px 22px;">
              <?php if(!empty($ctaUrl)): ?>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="center" style="padding-top:6px;">
                      <a href="<?php echo e(route('dashboard')); ?>"
                         style="display:block;width:100%;max-width:420px;
                                padding:14px 16px;border-radius:14px;
                                background:linear-gradient(135deg, <?php echo e($blue2); ?> 0%, <?php echo e($blue); ?> 45%, <?php echo e($cyan); ?> 100%);
                                color:#071019;font-weight:950;font-size:14px;letter-spacing:.25px;">
                        <?php echo e($ctaText); ?>

                      </a>
                    </td>
                  </tr>
                </table>
              <?php endif; ?>

              <div style="height:12px;"></div>

              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke2); ?>;border-radius:14px;background:rgba(11,18,32,.35);">
                <tr>
                  <td style="padding:14px 14px;">
                    <div style="color:<?php echo e($muted2); ?>;font-size:12px;font-weight:900;">SUPPORT</div>
                    <div style="margin-top:8px;color:<?php echo e($muted); ?>;font-size:13px;line-height:1.65;">
                      Need help? Email
                      <a href="mailto:<?php echo e($supportEmail ?? ''); ?>" style="color:<?php echo e($blue); ?>;text-decoration:underline;font-weight:950;">
                        <?php echo e($supportEmail ?? 'support'); ?>

                      </a>.
                    </div>
                  </td>
                </tr>
              </table>
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
</html><?php /**PATH /home/kriprand/radexchain.com/account/resources/views/emails/deposits/status.blade.php ENDPATH**/ ?>