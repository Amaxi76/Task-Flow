<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">

	<title><?= lang('Errors.whoops') ?></title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body class="d-flex flex-column min-vh-100">

	<div class="container text-center my-auto">
		<header class="mb-4">
			<img src="<?= base_url('assets/images/LogoSeul.svg') ?>" alt="Logo de TaskFlow" class="img-fluid">
		</header>

		<h1 class="headline" style="color: #379EE8;"><?= lang('Errors.whoops') ?></h1>

		<p class="lead" style="color: #1C4973;"><?= lang('Errors.weHitASnag') ?></p>
	</div>

	<!-- Bootstrap JS and dependencies -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
