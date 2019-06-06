<?php

	session_start();
	
	$mensagemSession = null;
	
	require_once "classes/GrupoClass.php";
	require_once "classes/ArquivoClass.php";

	if(!isset($_SESSION["collabapp"]) || $_SESSION["collabapp"] != true)
	header("Location: index.php");	


	if (isset($_SESSION["login_id"])){
		$login_id 	= $_SESSION["login_id"];
		$login_nome = $_SESSION["login_nome"];
		$grupo_id 	= $_GET["grupo_id"];
		$mensagemSession = "<div>Você já está logado como <b>$login_nome</b>. <a href='sair.php'>Sair</a></div>";		
	}
	
		$grupo = new GrupoClass();
		$arquivo = new ArquivoClass();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CollabApp - Dashboard do Grupo</title>
	</head>
	<body>
		<?php print $mensagemSession; ?>
		<p><a href="dashboardusuario.php">Home</a></p>
		<h1>CollabApp<br>Dashboard do Grupo</h1>
		<h2><i>
			<?php foreach($grupo->getNomeGrupo($grupo_id) as $nomeGrupo){
				print $nomeGrupo['GRUPO_NOME'];
			} ?>
		</h2></i>
		
		<p>Usuários no grupo de trabalho:</p>
				
		<table border="1px">
			<tr>
				<th>Nome</th>
				<th>Adicionado em</th>
				<th>Opções</th>
			</tr>
			<?php foreach($grupo->UsuariosNoGrupo($grupo_id) as $UsuariosNoGrupo){ 
				$usuario_id=$UsuariosNoGrupo['USUARIO_ID']; ?>			
			<tr>
				<td><?php print $UsuariosNoGrupo['USUARIO_NOME']; ?></td>
				<td><?php print $UsuariosNoGrupo['ADICIONADO_EM']; ?></td>
				<?php 
					if($usuario_id == $login_id){
						print "<td></td>";
					} else {
						print "<td><a href='removerusuario.php?usuario_id=$usuario_id&grupo_id=$grupo_id'>Remover</a></td>";
					}
				?>
			</tr>
			<?php }	?>
		</table>
		<a href="adicionarusuario.php?grupo_id=<?php print $grupo_id; ?>">Adicionar Usuário</a>

		<p>Meus arquivos no grupo de trabalho:</p>

		<table border="1px">
			<tr>
				<th>Nome</th>
				<th>Adicionado em</th>
				<th>Opções</th>
			</tr>
			<?php foreach($arquivo->ListarArquivosDoGrupo($grupo_id, $login_id) as $ArquivosNoGrupo){?>			
			<tr>
				<td><a href="<?php print $ArquivosNoGrupo['NOME_ARQUIVO']; ?>"><?php print basename($ArquivosNoGrupo['NOME_ARQUIVO']); ?></a></td>
				<td><?php print $ArquivosNoGrupo['ADICIONADO_EM']; ?></td>
				<td><a href="removerarquivo.php?arquivo_id=<?php print $ArquivosNoGrupo['ARQUIVO_ID'] ?>&grupo_id=<?php print $grupo_id; ?>&nome_arquivo=<?php print $ArquivosNoGrupo['NOME_ARQUIVO'] ?>">Remover<a></td>
			</tr>
			<?php } ?>
		</table>
		<a href="adicionararquivo.php?grupo_id=<?php print $grupo_id; ?>">Adicionar Arquivo</a>

		<p>Último arquivo enviado:</p>
		
		<table border="1px">
			<tr>
				<th>Nome</th>
				<th>Adicionado em</th>
				<th>Adicionado por</th>
			</tr>
			<?php foreach($arquivo->getUltimoArquivoDoGrupo($grupo_id) as $UltimoArquivoDoGrupo){?>
			<tr>
				<td><a href="<?php print $UltimoArquivoDoGrupo['NOME_ARQUIVO']; ?>"><?php print basename($UltimoArquivoDoGrupo['NOME_ARQUIVO']); ?></a></td>
				<td><?php print $UltimoArquivoDoGrupo['ADICIONADO_EM']; ?></td>
				<td><?php print $UltimoArquivoDoGrupo['ADICIONARO_POR']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</body>
</html>