<!doctype html>
<html>
	<head>
            <base href="<?php echo base_url(); ?>" />
		<meta charset="utf-8">
		<title>[Dashboard] MusicLovr</title>
		<link rel="stylesheet" href="assets/css/dashboard.css">
                <script charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script charset="utf-8" src="assets/js/nicEdit-latest.js"></script>
	</head>
	<body>
		<header>
			<a href="<?php echo base_url(); ?>"><h1>MusicLovr</h1></a>
			<nav>
				<ul>
					<li><a href="<?php echo base_url(); ?>home/new_post">Agregar rola</a></li>
					<li><a href="<?php echo base_url(); ?>home/profile">Mi perfil</a></li>
					<li><a href="<?php echo base_url(); ?>home/add_category">Temas</a></li>
					<li><a href="<?php echo base_url(); ?>logout">Salir</a></li>
				</ul>
			</nav>
		</header>
	        <?php echo $strContentView; ?>
	</body>
</html>