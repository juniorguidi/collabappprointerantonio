<?php

	require_once "classes/executarQuery.php";

	class GrupoClass {

		public $grupo_nome;
		public $grupo_usuariocriacao;
		public $grupo_id;
		public $usuario_id;

		public function RegistrarGrupo($grupo_nome, $grupo_usuariocriacao){
			$query_RegistrarGrupo = "CALL sp_incluirGrupo('$grupo_nome', '$grupo_usuariocriacao');";
			$info = executarQueryDML($query_RegistrarGrupo);

			return $info;
		}

		public function getUltimoGrupo(){

			$query_getUltimoGrupo = "SELECT MAX(gt.grupo_id) AS 'ULTIMOGRUPO' FROM tb_grupostrabalho gt;";
			$info = executarQuery($query_getUltimoGrupo);

			return $info;
		}
		
		public function getNomeGrupo($grupo_id){
			
			$query_getNomeGrupo = "SELECT gp.grupo_nome AS 'GRUPO_NOME' FROM tb_grupostrabalho gp WHERE gp.grupo_id = $grupo_id;";
			$info = executarQuery($query_getNomeGrupo);

			return $info;			
		}
		
		public function RegistrarUsuarioGrupo($usuario_id, $grupo_id){

			$query_RegistrarUsuarioGrupo = "CALL sp_incluirUsuarioGrupo('$usuario_id', '$grupo_id');";
			$info = executarQueryDML($query_RegistrarUsuarioGrupo);

			return $info;
		}
		
		public function UsuariosNoGrupo($grupo_id){
			
			$query_UsuariosNoGrupo = "SELECT u.usuario_id	AS 'USUARIO_ID',
											 u.usuario_nome AS 'USUARIO_NOME',
											 ug.usuariosgrupo_dthr AS 'ADICIONADO_EM'
									  FROM tb_usuariosgrupo ug
									 INNER JOIN tb_usuarios u
										ON ug.usuariosgrupo_usuarioid = u.usuario_id
									 WHERE ug.usuariosgrupo_grupoid = $grupo_id;";
			$info = executarQuery($query_UsuariosNoGrupo);

			return $info;			
		}		

		public function MeusGrupos($usuario_id){
			$query_MeusGrupos = "SELECT u.usuario_id as 'USUARIO_ID',
								        u.usuario_nome as 'USUARIO_NOME',
								        gp.grupo_id as 'GRUPO_ID',
								        gp.grupo_nome as 'GRUPO_NOME',
								        gp.grupo_usuariocriacao as 'USUARIOCRIACAO',
								        gp.grupo_dthr as 'DTHR_CRIACAO'
								   FROM tb_grupostrabalho gp
						     INNER JOIN tb_usuarios u
								     ON gp.grupo_usuariocriacao = u.usuario_id
								  WHERE gp.grupo_usuariocriacao = $usuario_id;";

			$info = executarQuery($query_MeusGrupos);

			return $info;
		}

		public function GruposFazParte($usuario_id){
			$query_GruposFazParte = "    SELECT ug.usuariosgrupo_grupoid AS 'GRUPO_ID',
		                                        gp.grupo_nome			   AS 'GRUPO_DSNOME',
		                                        u.usuario_nome				AS 'GRUPO_PROPIETARIO',
		 	                                    ug.usuariosgrupo_dthr	   AS 'GRUPO_TDHRADICIONADO'
                                           FROM tb_usuariosgrupo ug
                                     INNER JOIN tb_grupostrabalho gp
		                                     ON ug.usuariosgrupo_grupoid = gp.grupo_id
                                     INNER JOIN tb_usuarios u
		                                     ON gp.grupo_usuariocriacao = u.usuario_id
  	                                      WHERE ug.usuariosgrupo_usuarioid = $usuario_id;";

			$info = executarQuery($query_GruposFazParte);

			return $info;
		}
	}

?>