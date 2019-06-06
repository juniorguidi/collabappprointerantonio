<?php

	session_start();

	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true){
		header("Location: index.php");
	} else {
		$login_id = $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$grupo_id 	= $_GET["grupo_id"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}
	
	require_once "classes/ArquivoClass.php";
	
	$mensagemArquivoGrupo = null;
	$extensoes['extensoes'] = array("doc", "docx", "xls", "xlsx", "xml");	

	if (isset($_FILES['arquivo']['name'])){
		$diretorio = 'arquivos/';
		$destino = $diretorio . $login_id . "_" . time() . "_" . basename($_FILES['arquivo']['name']);
		$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
		
		$tmp = explode('.', $_FILES['arquivo']['name']);
		$extensao = end($tmp);
		
		if (array_search($extensao, $extensoes['extensoes']) === false) {
			$mensagemArquivoGrupo = "Por favor, envie arquivos com as seguintes extensões: DOC, XLS ou XML";
		} else {
			$arquivo = new ArquivoClass();
			
			if($arquivo->GravarArquivo($arquivo_tmp, $destino, $login_id)){
				
				$getUltimoArquivo = $arquivo->getUltimoArquivo();
				
				foreach($getUltimoArquivo as $ultimoArquivo){
					$ultimoArquivo_id = $ultimoArquivo['ULTIMOARQUIVO'];
				}
				
				if($arquivo->AssociarArquivoGrupo($ultimoArquivo_id, $grupo_id, $login_id)){
					$mensagemArquivoGrupo = "Arquivo enviado com sucesso.";
				}else{
					$mensagemArquivoGrupo = "Ocorreu um erro ao enviar o arquivo.";
				}			
			} else {
				$mensagemArquivoGrupo = "Arquivo não enviado.";
			}			
		}
	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Adicionar Arquivos</title>
	</head>
	<body>
		<?php print $mensagemSession; ?><br />
		<?php print $mensagemArquivoGrupo; ?><br />
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp<br>Adicionar Arquivos</h1>
		<p>Selecione o arquivo:</p>
		
		<form action="#" method="POST" enctype="multipart/form-data">
			<input type="file" name="arquivo"><br>
			Apenas arquivos DOC, XLS, XML.
			<p><button type="submmit">OK</button></p>
		</form>
	</body>
</html>