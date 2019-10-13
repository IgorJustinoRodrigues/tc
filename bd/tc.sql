DROP SCHEMA IF EXISTS tc;
CREATE SCHEMA IF NOT EXISTS `tc` DEFAULT CHARACTER SET utf8 ;
USE `tc` ;

CREATE TABLE IF NOT EXISTS `tc`.`tipo_usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `fone` VARCHAR(16) NULL DEFAULT NULL,
  `endereco` VARCHAR(200) NULL DEFAULT NULL,
  `bairro` VARCHAR(100) NULL DEFAULT NULL,
  `cidade` VARCHAR(100) NULL DEFAULT NULL,
  `cargo` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `ultimaSenha` VARCHAR(32) NULL DEFAULT NULL,
  `token` VARCHAR(32) NULL DEFAULT NULL,
  `status` INT(2) NOT NULL,
  `cadastro` DATETIME NOT NULL,
  `tipo_usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `tipo_usuario_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_usuario_tipo_usuario1_idx` (`tipo_usuario_id` ASC),
  CONSTRAINT `fk_usuario_tipo_usuario1`
    FOREIGN KEY (`tipo_usuario_id`)
    REFERENCES `tc`.`tipo_usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`auditoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` INT(1) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  `tabela` VARCHAR(60) NOT NULL,
  `campos` TEXT NULL DEFAULT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_auditoria_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_auditoria_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `tc`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`permissao` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  `nivel` INT(2) NOT NULL,
  `status` INT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`veiculo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` INT(2) NULL DEFAULT NULL,
  `modelo` VARCHAR(100) NULL DEFAULT NULL,
  `placa` VARCHAR(8) NOT NULL,
  `cidadePlaca` VARCHAR(100) NULL DEFAULT NULL,
  `cor` VARCHAR(60) NULL DEFAULT NULL,
  `observacoes` TEXT NULL DEFAULT NULL,
  `cadastro` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`registro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `veiculo_id` INT(11) NOT NULL,
  `entrada` DATETIME NOT NULL,
  `saida` DATETIME NULL DEFAULT NULL,
  `condutor` VARCHAR(100) NULL DEFAULT NULL,
  `motivo` INT(2) NULL DEFAULT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `status` INT(1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_has_veiculo_veiculo1_idx` (`veiculo_id` ASC),
  INDEX `fk_registro_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_veiculo_veiculo1`
    FOREIGN KEY (`veiculo_id`)
    REFERENCES `tc`.`veiculo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `tc`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tc`.`tipo_usuario_permissao` (
  `tipo_usuario_id` INT(11) NOT NULL,
  `permissao_id` INT(11) NOT NULL,
  PRIMARY KEY (`tipo_usuario_id`, `permissao_id`),
  INDEX `fk_tipo_usuario_has_permissao_permissao1_idx` (`permissao_id` ASC),
  INDEX `fk_tipo_usuario_has_permissao_tipo_usuario1_idx` (`tipo_usuario_id` ASC),
  CONSTRAINT `fk_tipo_usuario_has_permissao_permissao1`
    FOREIGN KEY (`permissao_id`)
    REFERENCES `tc`.`permissao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipo_usuario_has_permissao_tipo_usuario1`
    FOREIGN KEY (`tipo_usuario_id`)
    REFERENCES `tc`.`tipo_usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `tc`.`permissao` (`descricao`, `nivel`, `status`) VALUES ('Gerenciar Usuários', '1', '1');
INSERT INTO `tc`.`permissao` (`descricao`, `nivel`, `status`) VALUES ('Gerenciar Auditoria', '2', '1');
INSERT INTO `tc`.`permissao` (`descricao`, `nivel`, `status`) VALUES ('Gerenciar Veículos', '3', '1');
INSERT INTO `tc`.`permissao` (`descricao`, `nivel`, `status`) VALUES ('Gerenciar Entradas e Saídas', '4', '1');

INSERT INTO `tc`.`tipo_usuario` (`descricao`) VALUES ('Administrador');
INSERT INTO `tc`.`tipo_usuario` (`descricao`) VALUES ('Gerente');
INSERT INTO `tc`.`tipo_usuario` (`descricao`) VALUES ('Guarda');

INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('1', '1');
INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('1', '2');
INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('1', '3');
INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('2', '2');
INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('2', '3');
INSERT INTO `tc`.`tipo_usuario_permissao` (`tipo_usuario_id`, `permissao_id`) VALUES ('3', '3');

INSERT INTO `tc`.`usuario` (`nome`, `email`, `cargo`, `senha`, `ultimaSenha`, `status`, `tipo_usuario_id`) VALUES ('Admin', 'admin@gmail.com', 'Admin', md5('admin'), md5('admin'), '1', '1');