
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema esan-dsg08
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Table `esan-dsg08`.`GENERO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`GENERO` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `SEXO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `SEXO_UNIQUE` (`SEXO` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`ORIENTACAO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`ORIENTACAO` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ORIENTACAO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ORIENTACAO_UNIQUE` (`ORIENTACAO` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`DISTRITOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`DISTRITOS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `DISTRITO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `DISTRITO_UNIQUE` (`DISTRITO` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`USUARIOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`USUARIOS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(255) NOT NULL,
  `DATA_NASCIMENTO` DATE NOT NULL,
  `EMAIL` VARCHAR(255) NOT NULL,
  `SENHA` VARCHAR(15) NOT NULL,
  `IDADE` INT (3),
  `ADM` TINYINT NULL,
  `DESCRICAO` TEXT NULL,
  `SEXO_GENERO` VARCHAR(255) NULL,
  `ORIENTACAO_ORIENTACAO` VARCHAR(255) NULL,
  `DISTRITO_DISTRITOS` VARCHAR(255) NULL,
  `FOTO_PERFIL` VARCHAR(255) NULL,
  `LINK_DISCORD` VARCHAR(255) NOT NULL,
  `LINK_INSTAGRAM` VARCHAR(255) NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `email_UNIQUE` (`EMAIL` ASC),
  INDEX `fk_usuarios_sexo1_idx` (`SEXO_GENERO` ASC),
  INDEX `fk_usuarios_orientacao1_idx` (`ORIENTACAO_ORIENTACAO` ASC),
  INDEX `fk_USUARIOS_DISTRITOS1_idx` (`DISTRITO_DISTRITOS` ASC),
  CONSTRAINT `fk_usuarios_sexo1`
    FOREIGN KEY (`SEXO_GENERO`)
    REFERENCES `esan-dsg08`.`GENERO` (`SEXO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_orientacao1`
    FOREIGN KEY (`ORIENTACAO_ORIENTACAO`)
    REFERENCES `esan-dsg08`.`ORIENTACAO` (`ORIENTACAO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIOS_DISTRITOS1`
    FOREIGN KEY (`DISTRITO_DISTRITOS`)
    REFERENCES `esan-dsg08`.`DISTRITOS` (`DISTRITO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`POSTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`POSTS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `CONTEUDO` VARCHAR(255) NOT NULL,
  `ID_USUARIO` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_posts_usuarios1_idx` (`ID_USUARIO` ASC),
  CONSTRAINT `fk_posts_usuarios1`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`JOGOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`JOGOS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `JOGO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `JOGO_UNIQUE` (`JOGO` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`JOGOS_HAS_USUARIOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`JOGOS_HAS_USUARIOS` (
  `JOGOS_JOGO` VARCHAR(255) NOT NULL,
  `ID_USUARIO` INT NOT NULL,
  INDEX `fk_jogos_has_usuarios_usuarios1_idx` (`ID_USUARIO` ASC),
  INDEX `fk_jogos_has_usuarios_jogos1_idx` (`JOGOS_JOGO` ASC),
  CONSTRAINT `fk_jogos_has_usuarios_jogos1`
    FOREIGN KEY (`JOGOS_JOGO`)
    REFERENCES `esan-dsg08`.`JOGOS` (`JOGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_jogos_has_usuarios_usuarios1`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`CHAT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`CHAT` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `MENSAGEM` TEXT NOT NULL,
  `ID_REMETENTE` INT NOT NULL,
  `ID_RECETOR` INT NOT NULL,
  `TIMESTAMP` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`USUARIOS_HAS_CHAT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`USUARIOS_HAS_CHAT` (
  `ID_USUARIO` INT NOT NULL,
  `ID_CHAT` INT NOT NULL,
  INDEX `fk_usuarios_has_chat_chat1_idx` (`ID_CHAT` ASC),
  INDEX `fk_usuarios_has_chat_usuarios1_idx` (`ID_USUARIO` ASC),
  CONSTRAINT `fk_usuarios_has_chat_usuarios1`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_chat_chat1`
    FOREIGN KEY (`ID_CHAT`)
    REFERENCES `esan-dsg08`.`CHAT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`NOTIFICACOES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`NOTIFICACOES` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `MENSAGEM` TEXT NOT NULL,
  `ID_USUARIO` INT NOT NULL,
  `ESTADO` TINYINT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_notificacoes_usuarios1_idx` (`ID_USUARIO` ASC),
  CONSTRAINT `fk_notificacoes_usuarios1`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `esan-dsg08`.`CONVITES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esan-dsg08`.`CONVITES` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ID_REMETENTE` INT NOT NULL,
  `ID_RECETOR` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_CONVITES_USUARIOS1_idx` (`ID_REMETENTE` ASC),
  INDEX `fk_CONVITES_USUARIOS2_idx` (`ID_RECETOR` ASC),
  CONSTRAINT `fk_CONVITES_USUARIOS1`
    FOREIGN KEY (`ID_REMETENTE`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CONVITES_USUARIOS2`
    FOREIGN KEY (`ID_RECETOR`)
    REFERENCES `esan-dsg08`.`USUARIOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `esan-dsg08`.`GENERO`
-- -----------------------------------------------------
START TRANSACTION;
USE `esan-dsg08`;
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Homem');
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Mulher');
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Homem trans');
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Mulher trans');
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Não binário');
INSERT INTO `esan-dsg08`.`GENERO` (`ID`, `SEXO`) VALUES (DEFAULT, 'Outro');

COMMIT;


-- -----------------------------------------------------
-- Data for table `esan-dsg08`.`ORIENTACAO`
-- -----------------------------------------------------
START TRANSACTION;
USE `esan-dsg08`;
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Hétero');
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Gay');
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Bi');
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Assexual');
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Pansexual');
INSERT INTO `esan-dsg08`.`ORIENTACAO` (`ID`, `ORIENTACAO`) VALUES (DEFAULT, 'Outro');

COMMIT;


-- -----------------------------------------------------
-- Data for table `esan-dsg08`.`DISTRITOS`
-- -----------------------------------------------------
START TRANSACTION;
USE `esan-dsg08`;
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Aveiro');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Beja');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Braga');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Bragança');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Castelo Branco');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Coimbra');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Évora');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Faro');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Guarda');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Leiria');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Lisboa');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Portalegre');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Porto');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Santarém');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Setúbal');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Viana do Castelo');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Vila Real');
INSERT INTO `esan-dsg08`.`DISTRITOS` (`ID`, `DISTRITO`) VALUES (DEFAULT, 'Viseu');

COMMIT;


-- -----------------------------------------------------
-- Data for table `esan-dsg08`.`USUARIOS`
-- -----------------------------------------------------
START TRANSACTION;
USE `esan-dsg08`;
INSERT INTO `esan-dsg08`.`USUARIOS` (`ID`, `NOME`, `DATA_NASCIMENTO`, `EMAIL`, `SENHA`, `IDADE`, `ADM`, `DESCRICAO`, `SEXO_GENERO`, `ORIENTACAO_ORIENTACAO`, `DISTRITO_DISTRITOS`, `FOTO_PERFIL`, `LINK_DISCORD`, `LINK_INSTAGRAM`) VALUES (DEFAULT, 'Admin', '2000/01/01', 'admin@ua.pt', '1234abcd', NULL, true, NULL, NULL, NULL, NULL, NULL, 'admin', NULL);
INSERT INTO `esan-dsg08`.`USUARIOS` (`ID`, `NOME`, `DATA_NASCIMENTO`, `EMAIL`, `SENHA`, `IDADE`, `ADM`, `DESCRICAO`, `SEXO_GENERO`, `ORIENTACAO_ORIENTACAO`, `DISTRITO_DISTRITOS`, `FOTO_PERFIL`, `LINK_DISCORD`, `LINK_INSTAGRAM`) VALUES (DEFAULT, 'Mario Pinto', '2001/02/02', 'mjp@ua.pt', 'abcd1234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'discord.com', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `esan-dsg08`.`JOGOS`
-- -----------------------------------------------------
START TRANSACTION;
USE `esan-dsg08`;
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'League of Legends');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Smite');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Minecraft');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Valorant');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Dota 2');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Fortnite');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Counter-Strike');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Call of Duty');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'PUBG');
INSERT INTO `esan-dsg08`.`JOGOS` (`ID`, `JOGO`) VALUES (DEFAULT, 'Overwatch 2');

COMMIT;

