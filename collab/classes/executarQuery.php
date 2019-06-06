<?php
	require "appconf.php";

	function executarQuery($sql){
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB);
		
		if (mysqli_connect_errno()) {
			$error[] = "Connect failed: ". mysqli_connect_error();
			//para debugar problema de conexao, descomentar abaixo
			return $error;
			exit();
		} else {
		
			mysqli_set_charset($dbc, 'utf8');
			
			$sql_exec = mysqli_query($dbc, $sql);
			
			$arrReturn = array();
			while($linha = mysqli_fetch_assoc($sql_exec)){
				$arrReturn[] = $linha;
			}		
			
			mysqli_free_result($sql_exec);
			mysqli_close($dbc);
			
			return $arrReturn;
		}	
	}
	
	function executarQueryDML($sql){
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB);
		
		if (mysqli_connect_errno()) {
			$error[] = "Connect failed: ". mysqli_connect_error();
			//para debugar problema de conexao, descomentar abaixo
			return $error;
			exit();
		} else {
		
			mysqli_set_charset($dbc, 'utf8');
			
			$sql_exec = mysqli_query($dbc, $sql);
			
			mysqli_close($dbc);
			
			return $sql_exec;
		}		
		
	}
?>