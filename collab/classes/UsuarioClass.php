<?php

	require_once "classes/executarQuery.php";
 
class UsuarioClass { 
    
	public $usuario_id;
	public $usuario_nome; 
    public $usuario_email; 
    public $usuario_senha;
    
    public function VerificaUsuario($usuario_nome) { 
        
		$sql_VerificaLogin = "SELECT case 
			when COUNT(*) = 0 THEN 
			'N' 
			ELSE 
			'S' 
			END AS 'VALIDALOGIN',
			u.usuario_id as 'USUARIO_ID',
			u.usuario_nome as 'USUARIO_NOME'
		  FROM tb_usuarios u 
		 WHERE u.usuario_nome = '$usuario_nome'";

		$info[] = executarQuery($sql_VerificaLogin);
				
		return $info;
    }
	
    public function FazLogin($usuario_nome, $usuario_senha) { 
        //print "Fiz login com o usuário " . $usuario_nome . "<br>";
		
		$sql_VerificaLogin = "SELECT case 
			when COUNT(*) = 0 THEN 
			'N' 
			ELSE 
			'S' 
			END AS 'VALIDALOGIN',
			u.usuario_id as 'USUARIO_ID',
			u.usuario_nome as 'USUARIO_NOME'
		  FROM tb_usuarios u 
		 WHERE u.usuario_nome = '$usuario_nome' 
		   AND u.usuario_senha = '$usuario_senha';";

		$info[] = executarQuery($sql_VerificaLogin);
				
		return $info;
    }

	public function RegistrarUsuario($usuario_nome, $usuario_email, $usuario_senha){
		
		$query_RegistrarUsuario = "CALL sp_incluirUsuario('$usuario_nome', '$usuario_email', '$usuario_senha');";
		$info = executarQueryDML($query_RegistrarUsuario);
		
		return $info;		
	}
	
	public function ListaDeUsuariosComFiltro($grupo_id){

		$query_ListaDeUsuariosComFiltro = "SELECT u.usuario_id 	 AS 'USUARIO_ID',
													 u.usuario_nome AS 'USUARIO_NOME'
											  FROM tb_usuarios u
											 WHERE u.usuario_id 
												   NOT IN (SELECT usuariosgrupo_usuarioid 
																  FROM tb_usuariosgrupo ug 
																 WHERE ug.usuariosgrupo_grupoid = $grupo_id)
											 ORDER BY u.usuario_nome ASC;";
		$info = executarQuery($query_ListaDeUsuariosComFiltro);

		return $info;
	}
	
	public function RemoverUsuario($usuario_id, $grupo_id){
		
		$query_RemoverUsuario = "DELETE FROM tb_usuariosgrupo 
								 WHERE usuariosgrupo_usuarioid = $usuario_id 
								   AND usuariosgrupo_grupoid = $grupo_id;";
		$info = executarQueryDML($query_RemoverUsuario);	
		
		return $info;
	}
} 
 
?> 