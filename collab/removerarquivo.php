<?php
	
	session_start();
	
	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true){
		header("Location: index.php");
	} else {
		$login_id = $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}
	
	require_once "classes/ArquivoClass.php";
	$arquivo = new ArquivoClass();
	
	$arquivo_id = $_GET['arquivo_id'];
	$grupo_id 	= $_GET['grupo_id'];
	$nome_arquivo = $_GET['nome_arquivo'];
	
	if ($arquivo->RemoverArquivoGrupo($arquivo_id, $grupo_id)){
		if ($arquivo->RemoverArquivo($arquivo_id, $nome_arquivo)){
			header("Location: dashboardgrupo.php?grupo_id=$grupo_id");
		} else {
			print "Houve um erro ao remover o arquivo.";
		}
	} else {
		print "Houve um erro ao remover o arquivo do grupo.";
	}
	
?>