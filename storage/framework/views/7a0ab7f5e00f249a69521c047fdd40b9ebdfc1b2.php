<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $__env->yieldContent('title'); ?> - <?php echo e($settings->site_name); ?></title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:700,900&display=swap" rel="stylesheet">

	<!-- Font Awesome Icon -->
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('error/css/font-awesome.min.css')); ?>" />

	<!-- Custom stylesheet (keep if you still want it for icons/etc.) -->
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('error/css/style.css')); ?>" />

	<style>
		:root{
			/* Change these 3 to match your platform brand */
			--bg0: #070B1D;     /* page background */
			--card: #0E1633;    /* card background */
			--accent: #1EC7B6;  /* primary accent */
			--accent2:#2B6CFF;  /* secondary accent */
			--text: #EAF0FF;    /* main text */
			--muted:#AAB6D3;    /* muted text */
			--border: rgba(255,255,255,.12);
		}

		html, body { height: 100%; }

		body{
			margin:0;
			font-family: 'Montserrat', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
			color: var(--text);
			background:
				radial-gradient(900px 500px at 10% 20%, rgba(43,108,255,.20), transparent 60%),
				radial-gradient(700px 450px at 90% 80%, rgba(30,199,182,.16), transparent 60%),
				linear-gradient(180deg, var(--bg0), #050717 70%);
		}

		#notfound{
			position: relative;
			height: 100vh;
			display:flex;
			align-items:center;
			justify-content:center;
			padding: 24px;
		}

		/* override existing bg block to match theme */
		.notfound-bg{
			position:absolute;
			inset:0;
			opacity:.10;
			background-image:
				linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
				linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px);
			background-size: 56px 56px;
			mask-image: radial-gradient(420px 320px at 50% 45%, black, transparent 72%);
		}

		.notfound{
			position:relative;
			width: min(640px, 100%);
			text-align:center;
			padding: 34px 26px 28px;
			border-radius: 18px;
			border: 1px solid var(--border);
			background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
			box-shadow:
				0 18px 55px rgba(0,0,0,.48),
				0 0 0 1px rgba(255,255,255,.03) inset;
			backdrop-filter: blur(10px);
		}

		.notfound-404 h1{
			margin: 0;
			font-size: 84px;
			line-height: 1;
			font-weight: 900;
			letter-spacing: .02em;
			background: linear-gradient(90deg, var(--accent), var(--accent2));
			-webkit-background-clip: text;
			background-clip: text;
			color: transparent;
			text-shadow: 0 0 28px rgba(30,199,182,.15);
		}

		@media (min-width: 768px){
			.notfound-404 h1{ font-size: 120px; }
		}

		/* Accent bar under code */
		.notfound-404::after{
			content:"";
			display:block;
			margin: 16px auto 18px;
			width: 88px;
			height: 4px;
			border-radius: 999px;
			background: linear-gradient(90deg, var(--accent), var(--accent2));
			box-shadow: 0 0 24px rgba(30,199,182,.20);
		}

		.notfound h2{
			margin: 0 0 18px 0;
			font-size: 18px;
			font-weight: 700;
			color: var(--muted);
			line-height: 1.6;
		}

		.home-btn{
			display:inline-flex;
			align-items:center;
			justify-content:center;
			padding: 12px 18px;
			border-radius: 12px;
			border: 1px solid rgba(255,255,255,.14);
			background: rgba(255,255,255,.04);
			color: var(--text);
			font-weight: 800;
			text-transform: uppercase;
			letter-spacing: .06em;
			font-size: 12px;
			transition: transform .12s ease, border-color .12s ease, background-color .12s ease;
			text-decoration:none;
		}

		.home-btn:hover{
			transform: translateY(-1px);
			border-color: rgba(30,199,182,.55);
			background: rgba(30,199,182,.08);
		}

		.home-btn:active{ transform: translateY(0); }

		/* Optional: small footer watermark */
		.brand-row{
			margin-top: 18px;
			display:flex;
			justify-content:center;
			gap: 10px;
			flex-wrap: wrap;
			opacity: .75;
			font-size: 11px;
			letter-spacing: .08em;
			text-transform: uppercase;
			color: rgba(234,240,255,.70);
		}

		.brand-pill{
			border: 1px solid rgba(255,255,255,.12);
			background: rgba(255,255,255,.03);
			padding: 8px 10px;
			border-radius: 999px;
			white-space: nowrap;
		}
	</style>
</head>


<body>
	<div id="notfound">
		<div class="notfound-bg"></div>

		<div class="notfound">
			<div class="notfound-404">
				<h1><?php echo $__env->yieldContent('code'); ?></h1>
			</div>

			<h2><?php echo $__env->yieldContent('message'); ?></h2>

		<a href="<?php echo e(\Illuminate\Support\Facades\Route::has('login') ? route('login') : url('/login')); ?>" class="home-btn">
    Go Back
</a>

			<div class="brand-row" aria-hidden="true">
				<span class="brand-pill"><?php echo e($settings->site_name); ?></span>
				<span class="brand-pill">Secure • Reliable</span>
			</div>
		</div>
	</div>
</body>
</html><?php /**PATH /home/kriprand/radexchain.com/account/resources/views/errors/minimal.blade.php ENDPATH**/ ?>