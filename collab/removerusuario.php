<?php
	
	session_start();
	
	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true){
		header("Location: index.php");
	} else {
		$login_id = $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}
	
	require_once "classes/UsuarioClass.php";
	$usuario = new UsuarioClass();	
	
	$usuario_id = $_GET['usuario_id'];
	$grupo_id 	= $_GET['grupo_id'];
	
	if ($usuario->RemoverUsuario($usuario_id, $grupo_id)){
		header("Location: dashboardgrupo.php?grupo_id=$grupo_id");
	} else {
		print "Houve um erro ao remover o usuário.";
	}
	
?>