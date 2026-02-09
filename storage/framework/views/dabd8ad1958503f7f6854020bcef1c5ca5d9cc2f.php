<?php
  // View-only safe defaults (no logic changes)
  $brand     = isset($appName) && $appName ? $appName : (config('app.name', 'Online Banking'));
  $currency  = isset($currency) && $currency ? $currency : 'USD';
  $isCredit  = (isset($direction) && $direction === 'credit');
  $headline  = $isCredit ? 'Credit Posted' : 'Debit Posted';

  // Palette (dark blue primary; debit uses accessible red accent)
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

  $debitRed       = '#ef4444';
  $debitRedDeep   = '#991b1b';
  $debitSoftBg    = '#fee2e2';
  $debitSoftBrd   = '#fecaca';

  $accent       = $isCredit ? $blue : $debitRed;
  $chipBg       = $isCredit ? $blueSoftBg : $debitSoftBg;
  $chipText     = $isCredit ? $blueDeep   : $debitRedDeep;
  $chipBorder   = $isCredit ? $blueSoftBrd: $debitSoftBrd;

  // Numbers (avoid warnings if null)
  $amt          = number_format((float)($amount ?? 0), 2);
  $balBefore    = number_format((float)($balance_before ?? 0), 2);
  $balAfter     = number_format((float)($balance_after ?? 0), 2);
  $channelLabel = strtoupper(str_replace('_',' ', (string)($channel ?? '')));
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>Account Update: <?php echo e($headline); ?> | <?php echo e($brand); ?></title>
  <style>
    /* ===== Corporate Email (Dark Blue) — table-first for client compatibility ===== */
    html,body{margin:0;padding:0;background:#f6f8fb;color:#0b1320;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;}
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}

    /* Dark mode (supported clients) */
    @media (prefers-color-scheme: dark){
      html,body{background:#0b1220;color:#e6eef7}
    }
  </style>
</head>
<body>
  <!-- Inbox preview text (hidden) -->
  <div class="preheader">
    <?php echo e($isCredit ? 'A credit has been posted to your account.' : 'A debit has been posted to your account.'); ?>

  </div>

  <!-- Wrapper -->
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <!-- Card -->
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="640" style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td valign="middle" style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <?php if(isset($logoUrl)): ?>
                      <?php if($logoUrl): ?>
                        <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                      <?php endif; ?>
                    <?php endif; ?>
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                  </td>
                  <td align="right" valign="middle">
                    <!-- Status pill -->
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:<?php echo e($navy800); ?>;color:<?php echo e($isCredit ? '#9cc1ff' : '#f4b6bd'); ?>;">
                      <?php echo e($headline); ?>

                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting + Lead -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:<?php echo e($text); ?>;">
                Hi <?php echo e(trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer')); ?>,
              </h1>
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;color:<?php echo e($text); ?>;">
                We’ve <?php echo e($isCredit ? 'posted a credit' : 'recorded a debit'); ?> of
                <strong><?php echo e($amt); ?> <?php echo e($currency); ?></strong> to your account.
              </p>
            </td>
          </tr>

          <!-- Amount Summary (accented band) -->
          <tr>
            <td style="padding:0 22px 0 22px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:18px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="middle" style="font-size:28px;font-weight:900;color:<?php echo e($text); ?>;">
                          <?php echo e($isCredit ? '+' : '-'); ?><?php echo e($amt); ?> <?php echo e($currency); ?>

                        </td>
                        <td valign="middle" align="right">
                          <span style="font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:<?php echo e($chipBg); ?>;color:<?php echo e($chipText); ?>;border:1px solid <?php echo e($chipBorder); ?>;">
                            <?php echo e($channelLabel); ?>

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
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($ref ?? ''); ?></td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Date &amp; Time</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;">
                    <?php if(!empty($posted_at)): ?> <?php echo e($posted_at->format('Y-m-d H:i')); ?> <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Balance Before</td>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($balBefore); ?> <?php echo e($currency); ?></td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Balance After</td>
                  <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($balAfter); ?> <?php echo e($currency); ?></td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td style="padding:20px 22px 6px 22px;">
              <!-- Bulletproof button -->
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="left">
                <tr>
                  <td bgcolor="<?php echo e($blue); ?>" style="border-radius:12px;">
                    <a href="<?php echo e(url('/dashboard/accounthistory')); ?>"
                       style="display:inline-block;padding:12px 18px;border-radius:12px;background:<?php echo e($blue); ?>;border:1px solid <?php echo e($blue); ?>;color:#ffffff;font-weight:900;font-size:14px;line-height:1;text-decoration:none;">
                      View Transactions
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Support line -->
          <tr>
            <td style="padding:8px 22px 6px 22px;">
              <p style="margin:0;line-height:1.6;font-size:14px;color:<?php echo e($text); ?>;">
                If you have any questions about this activity, please reply to this email or contact support.
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
        <!-- /Card -->
      </td>
    </tr>
  </table>
  <!-- /Wrapper -->
</body>
</html>
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/balance-change.blade.php ENDPATH**/ ?>