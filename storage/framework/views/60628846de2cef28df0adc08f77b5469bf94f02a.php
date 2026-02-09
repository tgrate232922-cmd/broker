<?php
  $brand     = $appName ?? config('app.name','Online Banking');
  $fullName  = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->username ?? 'Customer');
  $dateText  = isset($posted_at) ? \Illuminate\Support\Carbon::parse($posted_at)->format('Y-m-d H:i') : now()->format('Y-m-d H:i');

  /* Approved palette */
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
  $pillColor   = '#9cc1ff';
?>
<!DOCTYPE html>
<html lang="en" style="background:#f6f8fb;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title><?php echo e($subjectLine ?? ('Welcome – '.$brand)); ?></title>
  <style>
    html,body{
      margin:0;padding:0;background:#f6f8fb;color:#0b1320;
      font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial;
    }
    a{color:inherit;text-decoration:none}
    .preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;}
    @media (prefers-color-scheme: dark){
      html,body{background:#0b1220;color:#e6eef7}
    }
  </style>
</head>
<body>
  <div class="preheader">
    Welcome to <?php echo e($brand); ?> — start investing with plans, copy trading, and signals.
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f8fb;padding:28px 14px;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:<?php echo e($card); ?>;border:1px solid <?php echo e($border); ?>;border-radius:14px;overflow:hidden;box-shadow:0 14px 38px rgba(3,10,26,.14);">
          <!-- Masthead -->
          <tr>
            <td style="background:<?php echo e($navy); ?>;border-bottom:1px solid rgba(255,255,255,.12);padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="color:#e6eef7;font-weight:800;letter-spacing:.2px;font-size:16px;line-height:1.2;">
                    <span><?php echo e($brand); ?></span>
                  </td>
                  <td align="right">
                    <span style="display:inline-block;font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.22);background:<?php echo e($navy800); ?>;color:<?php echo e($pillColor); ?>;">
                      Welcome
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
              <p style="margin:8px 0 0;line-height:1.6;font-size:14px;">
                Welcome to <strong><?php echo e($brand); ?></strong>—your all-in-one investment platform for
                diversified <strong>investment plans</strong>, expert-led <strong>copy trading</strong>, and actionable <strong>trade signals</strong>.
                Fund your account, pick a strategy, and track growth in real time.
              </p>
            </td>
          </tr>

          <!-- Quick start band -->
          <tr>
            <td style="padding:0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:16px 16px 8px 16px;color:<?php echo e($text); ?>;font-size:14px;font-weight:800;">Get started</td>
                </tr>
                <tr>
                  <td style="padding:0 16px 16px 16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding:8px 0;font-size:14px;color:<?php echo e($text); ?>;">1. <strong>Fund your wallet</strong> via your preferred method.</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;font-size:14px;color:<?php echo e($text); ?>;">2. Choose an <strong>investment plan</strong> or start <strong>copy trading</strong> a top expert.</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;font-size:14px;color:<?php echo e($text); ?>;">3. Enable <strong>signals</strong> for timely entries and smarter risk management.</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Highlights / value props -->
          <tr>
            <td style="padding:18px 22px 0 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid <?php echo e($border); ?>;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;">
                    <span style="display:inline-block;font-weight:900;background:<?php echo e($blueSoftBg); ?>;color:<?php echo e($blueDeep); ?>;border:1px solid <?php echo e($blueSoftBrd); ?>;border-radius:999px;padding:6px 10px;font-size:12px;margin-right:6px;">Plans</span>
                    Fixed-term and flexible options tailored to your goals.
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;border-bottom:1px solid <?php echo e($border); ?>;color:<?php echo e($text); ?>;">
                    <span style="display:inline-block;font-weight:900;background:<?php echo e($blueSoftBg); ?>;color:<?php echo e($blueDeep); ?>;border:1px solid <?php echo e($blueSoftBrd); ?>;border-radius:999px;padding:6px 10px;font-size:12px;margin-right:6px;">Copy Trading</span>
                    Mirror vetted experts and compound outcomes over time.
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 14px;color:<?php echo e($text); ?>;">
                    <span style="display:inline-block;font-weight:900;background:<?php echo e($blueSoftBg); ?>;color:<?php echo e($blueDeep); ?>;border:1px solid <?php echo e($blueSoftBrd); ?>;border-radius:999px;padding:6px 10px;font-size:12px;margin-right:6px;">Signals</span>
                    Timely alerts and structured trade ideas to support decisions.
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td style="padding:22px;">
              <a href="<?php echo e(url('/login')); ?>"
                 style="display:inline-block;text-decoration:none;font-weight:900;font-size:14px;padding:12px 16px;border-radius:12px;border:1px solid <?php echo e($blue); ?>;background:<?php echo e($blue); ?>;color:#fff;">
                Go to Dashboard
              </a>
              <div style="font-size:12px;color:<?php echo e($muted); ?>;margin-top:10px;">
                Joined on <?php echo e($dateText); ?>.
              </div>
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
<?php /**PATH /home/lumenvestasset/public_html/resources/views/emails/welcome.blade.php ENDPATH**/ ?>