<?php

	require "classes/UsuarioClass.php";
	$mensagem = "";
	
	if (isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["senha"])){	
		$usuario = new UsuarioClass();
		$usuario->usuario_nome = $_POST["login"];
		$usuario->usuario_email = $_POST["email"];
		$usuario->usuario_senha = $_POST["senha"];
		$result = $usuario->VerificaUsuario($usuario->usuario_nome);

		if($result[0][0]['VALIDALOGIN'] == "S"){
			$mensagem = "Usuario ja existe!";
		}else{
			if ($result = $usuario->RegistrarUsuario($usuario->usuario_nome, $usuario->usuario_email, $usuario->usuario_senha)){
				print "Usuário cadastrado com sucesso!";
				
			}
		}
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Registrar</title>
	</head>
	<body>
		
		<?php print $mensagem; ?>
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp - Registrar</h1>
		<p>Digite suas informações:</p>
		
		<form method="post" action="registrar.php">
			
			<table>
				<tr>
					<td>Login: </td>
					<td><input id="login" name="login" type="name"></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input id="email" name="email" type="email"></td>
				</tr>				
				<tr>
					<td>Senha: </td>
					<td><input id="senha" name="senha" type="password"></td>
				</tr>
				<tr>
					<td><button type="submmit">Registrar</button> </td>
				</tr>
			</table>
		
		</form>
	</body>
</html>