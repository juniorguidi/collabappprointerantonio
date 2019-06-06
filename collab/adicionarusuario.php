<?php

	session_start();
	
	$mensagemSession = null;
	
	require "classes/GrupoClass.php";
	require "classes/UsuarioClass.php";

	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true)
	header("Location: index.php");

	if (isset($_SESSION["login_id"])){
		$login_id 	= $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$grupo_id 	= $_GET["grupo_id"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}

	$grupo = new GrupoClass();
	$usuario = new UsuarioClass();
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Adicionar Usuário</title>
	</head>
	<body>
		<?php print $mensagemSession; ?>
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp<br>Adicionar Usuário</h1>
		<h2><i>
			<?php foreach($grupo->getNomeGrupo($grupo_id) as $nomeGrupo){
				print $nomeGrupo['GRUPO_NOME'];
			} ?>
		</h2></i>		
		<p>Selecione os usuários:</p>
		
		<form action="adicionarusuarioaogrupo.php?grupo_id=12">
			<input type="hidden" name="grupoid" id="grupoid" value="<?php print $grupo_id; ?>">	
			<br><select name="listaUsuarios[]" multiple required style="width:150px; height:300px">
			<?php
				foreach($usuario->ListaDeUsuariosComFiltro($grupo_id) as $listaUsuarios){
			?>
			  <option value="<?php print $listaUsuarios['USUARIO_ID']; ?>"><?php print $listaUsuarios['USUARIO_NOME']; ?></option>
			<?php } ?>
			</select> 
			<br><button type="submmit">OK</button>
		</form>
	</body>
</html>