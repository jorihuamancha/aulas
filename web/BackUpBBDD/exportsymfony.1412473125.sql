# MySQL dump of database 'symfony' on host 'localhost'
# backup date and time: 05.10.2014 03:38 Uhr
# built by phpMyBackupPro v.2.3
# http://www.phpMyBackupPro.net

# comment:
# Alta base de datos papa

### used character set: latin1 ###
set names latin1;


# ring constraints workaround
SET FOREIGN_KEY_CHECKS=0;
SET AUTOCOMMIT=0;
START TRANSACTION;


### structure of table `actividad` ###

DROP TABLE IF EXISTS `actividad`;

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `actividad` ###



### structure of table `alerta` ###

DROP TABLE IF EXISTS `alerta`;

CREATE TABLE `alerta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `alerta` ###



### structure of table `aula` ###

DROP TABLE IF EXISTS `aula`;

CREATE TABLE `aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `piso` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `aula` ###



### structure of table `carrera` ###

DROP TABLE IF EXISTS `carrera`;

CREATE TABLE `carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `carrera` ###



### structure of table `curso` ###

DROP TABLE IF EXISTS `curso`;

CREATE TABLE `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `anio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `curso` ###



### structure of table `docente` ###

DROP TABLE IF EXISTS `docente`;

CREATE TABLE `docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `docente` ###



### structure of table `movimiento` ###

DROP TABLE IF EXISTS `movimiento`;

CREATE TABLE `movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `movimiento` ###



### structure of table `persona` ###

DROP TABLE IF EXISTS `persona`;

CREATE TABLE `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `persona` ###



### structure of table `recurso` ###

DROP TABLE IF EXISTS `recurso`;

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `recurso` ###



### structure of table `reserva` ###

DROP TABLE IF EXISTS `reserva`;

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tareas_id` int(11) DEFAULT NULL,
  `aula_id` int(11) DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `horaRegistro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fechaRegistro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horaDesde` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horaHasta` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fechaReserva` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D73017A730113414` (`tareas_id`),
  UNIQUE KEY `UNIQ_D73017A7AD1A1255` (`aula_id`),
  CONSTRAINT `FK_D73017A730113414` FOREIGN KEY (`tareas_id`) REFERENCES `tarea` (`id`),
  CONSTRAINT `FK_D73017A7AD1A1255` FOREIGN KEY (`aula_id`) REFERENCES `aula` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `reserva` ###



### structure of table `tarea` ###

DROP TABLE IF EXISTS `tarea`;

CREATE TABLE `tarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `tarea` ###



### structure of table `usuario` ###

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personas_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EDD889C192FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_EDD889C1A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_EDD889C155394E80` (`personas_id`),
  CONSTRAINT `FK_EDD889C155394E80` FOREIGN KEY (`personas_id`) REFERENCES `persona` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2;


### data of table `usuario` ###

insert into `usuario` values ('1', null, 'root', 'root', 'test@example.com', 'test@example.com', '1', 'cf83s3edxtwgckkg0gowk4wscgo00sk', 'zMj6WdfQIBvgKfbsIbxSA+TKkEqS9nBB5zoUAetWWN5Umg3SO+FRO6kFTkUIwFwUTskGSIyWBngdk4NvPwTKmg==', '2014-10-05 03:09:25', '0', '0', null, null, null, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', '0', null);


# ring constraints workaround
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
