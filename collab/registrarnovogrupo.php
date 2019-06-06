<?php

	session_start();

	$mensagem = null;
	$mensagemGrupo = null;
	$mensagemUsuarioGrupo = null;

	require_once "classes/GrupoClass.php";

	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true)
	header("Location: index.php");


	if (isset($_SESSION["login_id"])){
		$login_id = $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";
	}

	if (isset($_POST['nomegrupo'])){
		$grupo = new GrupoClass();
		$grupo->grupo_nome = $_POST["nomegrupo"];
		$grupo->grupo_usuariocriacao = $login_id;

		if ($grupo->RegistrarGrupo($grupo->grupo_nome, $grupo->grupo_usuariocriacao)){
			
			$mensagemGrupo = "Grupo cadastrado!";
			$getUltimoGrupo = $grupo->getUltimoGrupo();

			foreach($getUltimoGrupo as $ultimoGrupo){
				$grupo_id = $ultimoGrupo['ULTIMOGRUPO'];
			}

				if($grupo->RegistrarUsuarioGrupo($login_id, $grupo_id)){
					$mensagemUsuarioGrupo = "Você foi associado ao grupo " . $grupo->grupo_nome . ".";
				}else{
					$mensagemUsuarioGrupo = "Ocorreu um erro ao associar você ao grupo " . $grupo->grupo_nome . ".";
				}

		}else{
			$mensagemGrupo = "Grupo não cadastrado!";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Novo Grupo</title>
	</head>
	<body>
		<?php print $mensagemSession; ?><br />
		<?php print $mensagemGrupo; ?>	<?php print $mensagemUsuarioGrupo; ?><br />
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp<br>Novo Grupo</h1>
		<p>Digite o nome do novo grupo<br>de trabalho:</p>
		
		<form method="post" action="registrarnovogrupo.php">
			
			<table>
				<tr>
					<td>Nome do grupo: </td>
					<td><input id="nomegrupo" name="nomegrupo" type="text"></td>
				</tr>
				<tr>
					<td><input type="submit" value="OK" /> </td>
				</tr>
			</table>
		
		</form>
	</body>
</html>