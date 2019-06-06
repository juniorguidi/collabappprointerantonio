<?php
	session_start();
	session_destroy();

	$mensagem = "Deslogado!";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Dashboar Usuario</title>
	</head>
	<body>
		<?php print $mensagem; ?>
		<p><a href="index.php">Login</a></p>
	</body>
</html>  