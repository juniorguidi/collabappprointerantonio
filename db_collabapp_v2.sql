-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.37-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para db_collabapp_v2
CREATE DATABASE IF NOT EXISTS `db_collabapp_v2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_collabapp_v2`;

-- Copiando estrutura para procedure db_collabapp_v2.sp_incluirArquivo
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incluirArquivo`(
	IN `vArquivo_link` VARCHAR(45),
	IN `vArquivo_usuarioid` INT(11)





)
BEGIN

	INSERT INTO tb_arquivos (arquivo_link, arquivo_dthr, arquivo_usuariocriacao)
	VALUES (vArquivo_link, sysdate(), vArquivo_usuarioid);
	
END//
DELIMITER ;

-- Copiando estrutura para procedure db_collabapp_v2.sp_incluirArquivoGrupo
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incluirArquivoGrupo`(
	IN `vArquivoid` INT(11),
	IN `vGrupoid` INT(11)

,
	IN `vUsuarioid` INT(11)

)
BEGIN

	INSERT INTO tb_arquivosgrupo (arquivosgrupo_arquivoid, arquivosgrupo_grupoid, arquivosgrupo_usuarioid, arquivosgrupo_dthr)
	VALUES (vArquivoid, vGrupoid, vUsuarioid, sysdate());

END//
DELIMITER ;

-- Copiando estrutura para procedure db_collabapp_v2.sp_incluirGrupo
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incluirGrupo`(
	IN `vGrupo_nome` VARCHAR(45),
	IN `vGrupo_usuarioid` INT(11)



)
BEGIN
	INSERT INTO tb_grupostrabalho (grupo_nome, grupo_usuariocriacao, grupo_dthr)
	VALUES (vGrupo_nome, vGrupo_usuarioid, sysdate());
END//
DELIMITER ;

-- Copiando estrutura para procedure db_collabapp_v2.sp_incluirUsuario
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incluirUsuario`(
	IN `vUsuario_nome` VARCHAR(45),
	IN `vUsuario_email` VARCHAR(45),
	IN `vUsuario_senha` VARCHAR(45)



)
BEGIN

	INSERT INTO tb_usuarios (usuario_nome, usuario_email, usuario_senha, usuario_dthr)
	VALUES (vUsuario_nome, vUsuario_email, vUsuario_senha, sysdate());
	
END//
DELIMITER ;

-- Copiando estrutura para procedure db_collabapp_v2.sp_incluirUsuarioGrupo
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incluirUsuarioGrupo`(
	IN `vUsuarioid` INT,
	IN `vGrupoid` INT
)
BEGIN

	INSERT INTO tb_usuariosgrupo (usuariosgrupo_usuarioid, 
											usuariosgrupo_grupoid, 
											usuariosgrupo_dthr)
	VALUES (vUsuarioid, vGrupoid, sysdate());

END//
DELIMITER ;

-- Copiando estrutura para tabela db_collabapp_v2.tb_arquivos
CREATE TABLE IF NOT EXISTS `tb_arquivos` (
  `arquivo_id` int(11) NOT NULL AUTO_INCREMENT,
  `arquivo_link` varchar(100) NOT NULL,
  `arquivo_dthr` datetime NOT NULL,
  `arquivo_usuariocriacao` int(11) NOT NULL,
  PRIMARY KEY (`arquivo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela db_collabapp_v2.tb_arquivosgrupo
CREATE TABLE IF NOT EXISTS `tb_arquivosgrupo` (
  `arquivosgrupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `arquivosgrupo_arquivoid` int(11) NOT NULL,
  `arquivosgrupo_grupoid` int(11) NOT NULL,
  `arquivosgrupo_usuarioid` int(11) NOT NULL,
  `arquivosgrupo_dthr` datetime NOT NULL,
  PRIMARY KEY (`arquivosgrupo_id`),
  KEY `fk_grupoid_idx` (`arquivosgrupo_grupoid`),
  KEY `fk_arquivoid_idx` (`arquivosgrupo_arquivoid`),
  KEY `fk_tbarqg_usuarioid_idx` (`arquivosgrupo_usuarioid`),
  CONSTRAINT `fk_tbarqg_arquivoid` FOREIGN KEY (`arquivosgrupo_arquivoid`) REFERENCES `tb_arquivos` (`arquivo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbarqg_grupoid` FOREIGN KEY (`arquivosgrupo_grupoid`) REFERENCES `tb_grupostrabalho` (`grupo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbarqg_usuarioid` FOREIGN KEY (`arquivosgrupo_usuarioid`) REFERENCES `tb_usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela db_collabapp_v2.tb_grupostrabalho
CREATE TABLE IF NOT EXISTS `tb_grupostrabalho` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_nome` varchar(45) NOT NULL,
  `grupo_usuariocriacao` int(11) NOT NULL,
  `grupo_dthr` datetime NOT NULL,
  PRIMARY KEY (`grupo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela db_collabapp_v2.tb_usuarios
CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(45) NOT NULL,
  `usuario_email` varchar(45) NOT NULL,
  `usuario_senha` varchar(45) NOT NULL,
  `usuario_dthr` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela db_collabapp_v2.tb_usuariosgrupo
CREATE TABLE IF NOT EXISTS `tb_usuariosgrupo` (
  `usuariosgrupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuariosgrupo_usuarioid` int(11) NOT NULL,
  `usuariosgrupo_grupoid` int(11) NOT NULL,
  `usuariosgrupo_dthr` datetime NOT NULL,
  PRIMARY KEY (`usuariosgrupo_id`),
  KEY `fk_usuarioid_idx` (`usuariosgrupo_usuarioid`),
  KEY `fk_grupoid_idx` (`usuariosgrupo_grupoid`),
  CONSTRAINT `fk_tbusug_usuarioid` FOREIGN KEY (`usuariosgrupo_usuarioid`) REFERENCES `tb_usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usug_grupoid` FOREIGN KEY (`usuariosgrupo_grupoid`) REFERENCES `tb_grupostrabalho` (`grupo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
