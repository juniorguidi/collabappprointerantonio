<?php
	
	session_start();
	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true)
	header("Location: index.php");
	
	require_once "classes/GrupoClass.php";
	$grupo = new GrupoClass();
	
	$grupo_id = $_GET["grupoid"];
	
	foreach($_GET["listaUsuarios"] as $id_usuario){
		$grupo->RegistrarUsuarioGrupo($id_usuario, $grupo_id);
	}
	
	header("Location: dashboardgrupo.php?grupo_id=$grupo_id");
?>