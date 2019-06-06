<?php

	require_once "classes/executarQuery.php";
	
	Class ArquivoClass {

		public $arquivosgrupo_arquivoid;
		public $arquivosgrupo_grupoid;
		public $arquivosgrupo_usuarioid;
		public $arquivosgrupo_dthr;
		
		public $arquivo_link;
		public $arquivo_dthr;
		public $arquivo_usuariocriacao;
		
		public $arquivo;
		public $diretorio;
	
		
		public function GravarArquivo($arquivo_tmp, $diretorio, $arquivo_usuariocriacao){
				
			if(move_uploaded_file($arquivo_tmp, $diretorio)){
				$query_GravarArquivo = "CALL sp_incluirArquivo('$diretorio', $arquivo_usuariocriacao);";
				$info = executarQueryDML($query_GravarArquivo);
			} else {
				$info = "Erro ao realizar upload!";
			}
			
			return $info;			
		}

		public function getUltimoArquivo(){
			$query_getUltimoArquivo = "SELECT MAX(a.arquivo_id) AS 'ULTIMOARQUIVO' FROM tb_arquivos a;";
			$info = executarQuery($query_getUltimoArquivo);

			return $info;
		}

		public function getUltimoArquivoDoGrupo($arquivosgrupo_grupoid){
			$query_getUltimoArquivoDoGrupo = "     SELECT a.arquivo_id	AS 'ARQUIVO_ID',
														a.arquivo_link AS 'NOME_ARQUIVO',
														a.arquivo_dthr AS 'ADICIONADO_EM',
														a.arquivo_usuariocriacao AS 'USUARIO_ID',
														ag.arquivosgrupo_grupoid AS 'GRUPO_ID',
														u.usuario_nome AS 'ADICIONARO_POR'
											   FROM tb_arquivosgrupo ag
										 INNER JOIN tb_arquivos a
												 ON ag.arquivosgrupo_arquivoid = a.arquivo_id
										 INNER JOIN tb_usuarios u
													ON ag.arquivosgrupo_usuarioid = u.usuario_id
											  WHERE ag.arquivosgrupo_grupoid = $arquivosgrupo_grupoid
												  AND a.arquivo_id = (SELECT MAX(arquivo_id) FROM tb_arquivos);";
			$info = executarQuery($query_getUltimoArquivoDoGrupo);

			return $info;
		}
		
		public function AssociarArquivoGrupo($arquivosgrupo_arquivoid, $arquivosgrupo_grupoid, $arquivosgrupo_usuarioid){
			$query_AssociarArquivoGrupo = "CALL sp_incluirArquivoGrupo($arquivosgrupo_arquivoid, $arquivosgrupo_grupoid, $arquivosgrupo_usuarioid);";
			$info = executarQueryDML($query_AssociarArquivoGrupo);

			return $info;
		}
		
		public function ListarArquivosDoGrupo($arquivosgrupo_grupoid, $arquivosgrupo_usuarioid){
			$query_ListarArquivosDoGrupo = "SELECT 
												 a.arquivo_id	 AS 'ARQUIVO_ID',
												 a.arquivo_link AS 'NOME_ARQUIVO',
												 a.arquivo_dthr AS 'ADICIONADO_EM',
												 u.usuario_nome AS 'ENVIADO_POR',
												 u.usuario_id	 AS 'USUARIO_ID' 
										  FROM tb_arquivosgrupo ag
										  INNER JOIN tb_arquivos a
											 ON ag.arquivosgrupo_arquivoid = a.arquivo_id
										  INNER JOIN tb_usuarios u
											 ON ag.arquivosgrupo_usuarioid = u.usuario_id
										 WHERE ag.arquivosgrupo_grupoid = $arquivosgrupo_grupoid
										   AND ag.arquivosgrupo_usuarioid = $arquivosgrupo_usuarioid
										   ORDER BY a.arquivo_dthr DESC;";
			$info = executarQuery($query_ListarArquivosDoGrupo);

			return $info;			
		}
		
		public function RemoverArquivoGrupo($arquivosgrupo_arquivoid, $arquivosgrupo_grupoid){
			$query_RemoverArquivoGrupo = "DELETE 
									  FROM tb_arquivosgrupo
									  WHERE arquivosgrupo_arquivoid = $arquivosgrupo_arquivoid 
										AND arquivosgrupo_grupoid = $arquivosgrupo_grupoid;";
			$info = executarQueryDML($query_RemoverArquivoGrupo);

			return $info;
		}
		
		public function RemoverArquivo($arquivosgrupo_arquivoid, $arquivo_link){
			
			//$caminho = "arquivos/" . $arquivo_link;
			
			unlink ($arquivo_link);
			
			$query_RemoverArquivo = "DELETE 
									  FROM tb_arquivos
									  WHERE arquivo_id = $arquivosgrupo_arquivoid;";
			$info = executarQueryDML($query_RemoverArquivo);
			
			return $info;			
		}		
		
	}
?>