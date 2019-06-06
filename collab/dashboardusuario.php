<?php

	session_start();
	require_once "classes/GrupoClass.php";

	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true)
	header("Location: index.php");	


	if (isset($_SESSION["login_id"])){
		$login_id 	= $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$mensagem 	= "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Dashboar Usuario</title>
	</head>
	<body>
		<?php print $mensagem; ?>
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp<br>Dashboard Usuario</h1>
		<p><a href="registrarnovogrupo.php">Novo Grupo</a></p>
		

		
		<p>Meus Grupos:
		<table border="1px">
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>Proprietário</th>
				<th>Dthr Criação</th>
			</tr>
			
		<?php
			$grupo = new GrupoClass();
			$grupo->usuario_id 	= $login_id;
			$resultMeusGrupos 	= $grupo->MeusGrupos($grupo->usuario_id);
			
			foreach($resultMeusGrupos as $meusgrupos){
				$meuGrupo_id 	= $meusgrupos['GRUPO_ID'];
				$meuGrupo_nome 	= $meusgrupos['GRUPO_NOME'];
				$meuGrupo_proprietario = $meusgrupos['USUARIO_NOME'];
				$meuGrupo_dthr 	= $meusgrupos['DTHR_CRIACAO'];
			
		?>			
			
			<tr>
				<td><?php print $meuGrupo_id; ?></td>
				<td><a href="dashboardgrupo.php?grupo_id=<?php print $meuGrupo_id; ?>"><?php print $meuGrupo_nome; ?></a></td>
				<td><?php print $meuGrupo_proprietario; ?></td>
				<td><?php print $meuGrupo_dthr; ?></td>
			</tr>
			
		<?php 
			}
		?>
		</table></p>
		
		<p>Grupos que faço parte:
		<table border="1px">
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>Proprietário</th>
				<th>Adicionado em</th>
			</tr>
		<?php
			$resultGruposFazParte = $grupo->GruposFazParte($grupo->usuario_id);
			
			foreach($resultGruposFazParte as $gruposinfo){
				$grupo_id = $gruposinfo['GRUPO_ID'];
				$grupo_nome = $gruposinfo['GRUPO_DSNOME'];
				$grupo_proprietario = $gruposinfo['GRUPO_PROPIETARIO'];
				$grupo_dthr = $gruposinfo['GRUPO_TDHRADICIONADO'];
			
		?>			
			<tr>
				<td><?php print $grupo_id; ?></td>
				<td><a href="dashboardgrupo.php?grupo_id=<?php print $grupo_id; ?>"><?php print $grupo_nome; ?></a></td>
				<td><?php print $grupo_proprietario; ?></td>
				<td><?php print $grupo_dthr; ?></td>
			</tr>
		<?php
			}
		?>
		</table></p>		
		
	</body>
</html>