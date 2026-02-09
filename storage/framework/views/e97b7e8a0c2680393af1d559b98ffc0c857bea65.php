<?php
  // Safe defaults
  $brand     = isset($appName) && $appName ? $appName : config('app.name','');
  $currency  = isset($currency) && $currency ? (string)$currency : 'USD';

  $isCredit  = (isset($direction) && $direction === 'credit');
  $headline  = $isCredit ? 'Account credit update' : 'Account debit update';

  // Screenshot-inspired palette (same as deposit/withdrawal)
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

  // Accent by direction
  if ($isCredit) {
    $accent = $green;
    $chipBg = 'rgba(34,197,94,.14)';
    $chipText = '#b7f7cb';
    $chipBorder = 'rgba(34,197,94,.28)';
    $sign = '+';
  } else {
    $accent = $red;
    $chipBg = 'rgba(251,113,133,.14)';
    $chipText = '#ffd0d7';
    $chipBorder = 'rgba(251,113,133,.28)';
    $sign = '−';
  }

  // User name
  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  // Numbers (avoid warnings if null)
  $amt       = number_format((float)($amount ?? 0), 2);
  $balBefore = number_format((float)($balance_before ?? 0), 2);
  $balAfter  = number_format((float)($balance_after ?? 0), 2);

  // Channel label
  $channelLabel = strtoupper(str_replace('_',' ', (string)($channel ?? 'N/A')));

  // Ref short (optional)
  $refSafe = (string)($ref ?? '');
  $refShort = $refSafe !== '' && strlen($refSafe) > 18 ? substr($refSafe, 0, 10) . '…' . substr($refSafe, -6) : $refSafe;

  // Date safe parse (supports Carbon/string/null)
  $dt = $posted_at ?? now();
  $dateText = \Illuminate\Support\Carbon::parse($dt)->format('D, M j, Y h:i A');

  // Optional logo
  $logoUrl = $logoUrl ?? null;

  // CTA (prefer absolute URL via APP_URL)
  $ctaUrl  = $transactionsUrl ?? url('/dashboard/accounthistory');
  $ctaText = 'View transactions';

  $support = (string)($supportEmail ?? '');
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
  <div class="preheader">
    <?php echo e($isCredit ? 'A credit entry was recorded on your account.' : 'A debit entry was recorded on your account.'); ?>

    Amount: <?php echo e($amt); ?> <?php echo e($currency); ?>.
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
                      ACCOUNT
                    </span>
                  </td>

                  <td align="right">
                    <span class="mono" style="display:inline-block;padding:6px 10px;border-radius:999px;
                                 background:<?php echo e($chipBg); ?>;border:1px solid <?php echo e($chipBorder); ?>;
                                 color:<?php echo e($chipText); ?>;font-weight:900;font-size:11px;">
                      <?php echo e($isCredit ? 'CREDIT' : 'DEBIT'); ?>

                    </span>
                  </td>
                </tr>
              </table>

              <div style="height:10px;"></div>

              <h1 style="margin:0;font-size:22px;line-height:1.25;color:<?php echo e($text); ?>;font-weight:900;">
                <?php echo e($headline); ?>

              </h1>
              <p style="margin:10px 0 0;line-height:1.7;font-size:14px;color:<?php echo e($muted); ?>;">
                Hi <?php echo e($fullName); ?>, here is a summary of recent account activity.
              </p>
            </td>
          </tr>

          <!-- Amount Card -->
          <tr>
            <td class="px" style="padding:16px 22px 6px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke); ?>;border-radius:18px;overflow:hidden;background:rgba(17,28,51,.55);">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="font-size:30px;font-weight:900;color:<?php echo e($text); ?>;letter-spacing:.2px;">
                          <?php echo e($sign); ?><?php echo e($amt); ?>

                          <span style="font-size:14px;font-weight:800;color:<?php echo e($muted2); ?>;"><?php echo e($currency); ?></span>
                        </td>
                        <td align="right">
                          <span class="mono" style="font-size:11px;font-weight:900;padding:7px 10px;border-radius:999px;
                                       background:rgba(11,18,32,.45);border:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted); ?>;">
                            <?php echo e($channelLabel); ?>

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
            <td class="px" style="padding:10px 22px 18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border:1px solid <?php echo e($stroke2); ?>;border-radius:16px;background:rgba(11,18,32,.35);">

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Transaction Type
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php echo e($channelLabel); ?>

                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;width:42%;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Reference
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php if($refSafe !== ''): ?>
                      <span class="mono" style="display:inline-block;padding:2px 8px;border-radius:999px;background:rgba(47,107,255,.12);border:1px solid rgba(47,107,255,.25);">
                        <?php echo e($refShort); ?>

                      </span>
                      
                    <?php else: ?>
                      —
                    <?php endif; ?>
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Date &amp; time
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <span class="mono"><?php echo e($dateText); ?></span>
                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Balance before
                  </td>
                  <td style="padding:14px 14px;border-bottom:1px solid <?php echo e($stroke2); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php echo e($balBefore); ?> <?php echo e($currency); ?>

                  </td>
                </tr>

                <tr>
                  <td style="padding:14px 14px;color:<?php echo e($muted2); ?>;font-size:12px;font-weight:800;">
                    Balance after
                  </td>
                  <td style="padding:14px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:13px;">
                    <?php echo e($balAfter); ?> <?php echo e($currency); ?>

                  </td>
                </tr>
              </table>

              <div style="height:14px;"></div>

              <a href="<?php echo e($ctaUrl); ?>"
                 style="display:block;width:100%;max-width:420px;margin:0 auto;
                        padding:14px 16px;border-radius:14px;
                        background:linear-gradient(135deg, <?php echo e($blue2); ?> 0%, <?php echo e($blue); ?> 45%, <?php echo e($cyan); ?> 100%);
                        color:#071019;font-weight:900;font-size:14px;letter-spacing:.2px;text-align:center;">
                <?php echo e($ctaText); ?>

              </a>

              <div style="height:12px;"></div>

              <div style="color:<?php echo e($muted2); ?>;font-size:12px;line-height:1.6;text-align:center;">
                This message was sent to <?php echo e($user->email ?? 'your email'); ?> because you have an account with <?php echo e($brand); ?>.
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px" style="padding:14px 22px;border-top:1px solid <?php echo e($stroke2); ?>;
                                  background:rgba(11,18,32,.35);color:<?php echo e($muted2); ?>;
                                  font-size:12px;line-height:1.6;">
              Support: <a href="mailto:<?php echo e($support); ?>" style="color:<?php echo e($blue); ?>;text-decoration:underline;font-weight:800;"><?php echo e($support); ?></a><br>
              © <?php echo e(date('Y')); ?> <?php echo e($brand); ?>.
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>
</body>
</html><?php /**PATH /home/kriprand/radexchain.com/account/resources/views/emails/balance-change.blade.php ENDPATH**/ ?>