<?php

	session_start();
	require "classes/UsuarioClass.php";
	$mensagem = "";
	
	if (isset($_POST["login"]) && isset($_POST["senha"])){
		
		$usuario = new UsuarioClass();
		$usuario->usuario_nome = $_POST["login"];
		$usuario->usuario_senha = $_POST["senha"];
		$result = $usuario->FazLogin($usuario->usuario_nome, $usuario->usuario_senha);
		
/*		foreach($result[0] as $usuarioinfo){
				$login_id = $usuarioinfo['USUARIO_ID'];
				$login_nome = $usuarioinfo['USUARIO_NOME'];
		}
		print $login_id;
		print $login_nome;
		print_r ($result[0]);
*/
		if($result[0][0]['VALIDALOGIN'] == "S"){
			
			foreach($result[0] as $usuarioinfo){
				$login_id = $usuarioinfo['USUARIO_ID'];
				$login_nome = $usuarioinfo['USUARIO_NOME'];
			}				
			
			$_SESSION["collabapp"] = TRUE;
			$_SESSION["login_id"] = $login_id;
			$_SESSION["login_nome"] = $login_nome;
			header("Location: dashboardusuario.php");
			exit;
		} else {
			$mensagem = "<div>Usuário ou senha inválidos!</div>";
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Login</title>
	</head>
	<body>
		
		<?php print $mensagem; ?>
		<h1>CollabApp - Login</h1>
		<p>Faça login ou <a href="registrar.php">cadastre-se</a>.</p>
		
		<form method="post" action="index.php">
			
			<table>
				<tr>
					<td>Login: </td>
					<td><input id="login" name="login" type="text"></td>
				</tr>
				<tr>
					<td>Senha: </td>
					<td><input id="senha" name="senha" type="password"></td>
				</tr>
				<tr>
					<td><button type="submmit">OK</button> </td>
				</tr>
			</table>
		
		</form>
	</body>
</html>