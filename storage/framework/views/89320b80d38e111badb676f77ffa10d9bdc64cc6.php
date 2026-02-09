<?php
  $brand = $appName ?? config('app.name','Online Banking');

  // Palette
  $navy='#0f172a'; $navy800='#0b1220'; $text='#0b1320'; $muted='#475569';
  $border='#e6ecf5'; $card='#ffffff'; $blue='#1d4ed8';

  $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');

  $name   = $copyTrade->name ?? optional($copyTrade->expert)->name ?? 'Expert';
  $price  = number_format((float)($copyTrade->price ?? 0), 2);
  $curr   = $currency ?? 'USD';

  $current_balance = number_format((float)($extras['current_balance'] ?? $copyTrade->current_balance ?? 0), 2);
  $total_profit    = number_format((float)($copyTrade->total_profit ?? 0), 2);
  $profit_amt      = number_format((float)($extras['profit'] ?? 0), 2);
  $total_return    = number_format((float)($extras['total_return'] ?? 0), 2);

  $isStarted = $event === 'started';
  $isStopped = $event === 'stopped';
  $isProfit  = $event === 'profit';

  $status = $isStopped ? 'Stopped' : 'Active';
  $preheader = $isStarted
      ? "You’ve started copying {$name}."
      : ($isStopped ? "You’ve stopped copying {$name}."
                    : "Your copy trading with {$name} recorded a profit update.");
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectLine); ?> | <?php echo e($brand); ?></title>
  <style>
    html,body{margin:0;padding:0;background:#f6f8fb;color:#0b1320;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;}
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){ html,body{background:#0b1220;color:#e6eef7} }
  </style>
</head>
<body>
  <div class="preheader"><?php echo e($preheader); ?></div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;">
                    <?php if(!empty($logoUrl)): ?>
                      <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($brand); ?> logo" width="28" height="28" style="vertical-align:middle;border:0;border-radius:6px;margin-right:10px;">
                    <?php endif; ?>
                    <span style="vertical-align:middle"><?php echo e($brand); ?></span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:<?php echo e($navy800); ?>;color:#9cc1ff;">
                      <?php echo e($isStarted ? 'Started' : ($isStopped ? 'Stopped' : 'Profit Update')); ?>

                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Greeting -->
          <tr>
            <td style="padding:22px;">
              <h1 style="margin:0 0 8px;font-size:20px;line-height:1.35;color:#0b1320;">Hi <?php echo e($fullName); ?>,</h1>
              <?php if($isStarted): ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">You’ve started copying <strong><?php echo e($name); ?></strong>. Here’s your summary.</p>
              <?php elseif($isStopped): ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">You’ve stopped copying <strong><?php echo e($name); ?></strong>. Here’s your summary.</p>
              <?php else: ?>
                <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">Your copy trading with <strong><?php echo e($name); ?></strong> has a new profit update. Details below.</p>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Summary band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px;">
                    <table role="presentation" width="100%">
                      <tr>
                        <td style="font-size:18px;font-weight:900;color:#0b1320;">
                          Copy Trading • <?php echo e($name); ?>

                        </td>
                        <td align="right" style="font-size:12px;font-weight:800;">
                          Submitted: <?php echo e($posted_at->format('Y-m-d H:i')); ?>

                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-top:10px;">
                          <div style="height:4px;width:100%;background:linear-gradient(90deg, <?php echo e($blue); ?> 0%, <?php echo e($blue); ?> 60%, rgba(0,0,0,0) 60%);border-radius:999px;"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Key/Value grid -->
          <tr>
            <td style="padding:18px 22px 8px 22px;">
              <table role="presentation" width="100%" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;width:40%;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Reference</td>
                  <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($ref); ?></td>
                </tr>

                <?php if($isStarted): ?>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Initial Investment</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($price); ?> <?php echo e($curr); ?></td></tr>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;">Active</td></tr>
                <?php elseif($isStopped): ?>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Total Return</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($total_return); ?> <?php echo e($curr); ?></td></tr>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Total Profit</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($total_profit); ?> <?php echo e($curr); ?></td></tr>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;">Stopped</td></tr>
                <?php else: ?>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Profit</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($profit_amt); ?> <?php echo e($curr); ?></td></tr>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Current Balance</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;"><?php echo e($current_balance); ?> <?php echo e($curr); ?></td></tr>
                  <tr><td style="padding:12px 14px;color:<?php echo e($muted); ?>;font-size:12px;font-weight:800;">Status</td>
                      <td style="padding:12px 14px;color:<?php echo e($text); ?>;font-weight:900;font-size:14px;">Active</td></tr>
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
                    <a href="<?php echo e($isStopped ? $dashboardUrl : $detailsUrl); ?>" style="display:inline-block;padding:12px 18px;border-radius:12px;background:<?php echo e($blue); ?>;border:1px solid <?php echo e($blue); ?>;color:#fff;font-weight:900;font-size:14px;line-height:1;text-decoration:none;">
                      <?php echo e($isStopped ? 'Go to Dashboard' : 'View Copy Trade'); ?>

                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:8px 22px 6px 22px;"><p style="margin:0;line-height:1.6;font-size:14px;">Questions? Contact <strong>support</strong>.</p></td>
          </tr>
          <tr>
            <td style="padding:14px 22px;border-top:1px solid <?php echo e($border); ?>;background:#f8fafc;color:<?php echo e($muted); ?>;font-size:12px;line-height:1.5;">© <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. All rights reserved.</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/copytrading/event.blade.php ENDPATH**/ ?>