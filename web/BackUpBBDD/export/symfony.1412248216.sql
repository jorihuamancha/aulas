# MySQL dump of database 'symfony' on host 'localhost'
# backup date and time: 02.10.2014 13:10 Uhr
# built by phpMyBackupPro v.2.3
# http://www.phpMyBackupPro.net

### used character set: latin1 ###
set names latin1;


# ring constraints workaround
SET FOREIGN_KEY_CHECKS=0;
SET AUTOCOMMIT=0;
START TRANSACTION;


### structure of table `Actividad` ###

DROP TABLE IF EXISTS `Actividad`;

CREATE TABLE `Actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Actividad` ###



### structure of table `Alerta` ###

DROP TABLE IF EXISTS `Alerta`;

CREATE TABLE `Alerta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Alerta` ###



### structure of table `Aula` ###

DROP TABLE IF EXISTS `Aula`;

CREATE TABLE `Aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `piso` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Aula` ###



### structure of table `Carrera` ###

DROP TABLE IF EXISTS `Carrera`;

CREATE TABLE `Carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Carrera` ###



### structure of table `Curso` ###

DROP TABLE IF EXISTS `Curso`;

CREATE TABLE `Curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `anio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Curso` ###



### structure of table `Docente` ###

DROP TABLE IF EXISTS `Docente`;

CREATE TABLE `Docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3;


### data of table `Docente` ###

insert into `Docente` values ('1', 'Pedro alfonnsoooo', 'asdadsasd', '0');
insert into `Docente` values ('2', 'asd', 'asd', '0');


### structure of table `Movimiento` ###

DROP TABLE IF EXISTS `Movimiento`;

CREATE TABLE `Movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Movimiento` ###



### structure of table `Persona` ###

DROP TABLE IF EXISTS `Persona`;

CREATE TABLE `Persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Persona` ###



### structure of table `Recurso` ###

DROP TABLE IF EXISTS `Recurso`;

CREATE TABLE `Recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Recurso` ###



### structure of table `Reserva` ###

DROP TABLE IF EXISTS `Reserva`;

CREATE TABLE `Reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `horaRegistro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fechaRegistro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horaDesde` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horaHasta` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fechaReserva` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `aula_id` int(11) DEFAULT NULL,
  `tareas_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D73017A7AD1A1255` (`aula_id`),
  UNIQUE KEY `UNIQ_D73017A730113414` (`tareas_id`),
  CONSTRAINT `FK_D73017A730113414` FOREIGN KEY (`tareas_id`) REFERENCES `Tarea` (`id`),
  CONSTRAINT `FK_D73017A7AD1A1255` FOREIGN KEY (`aula_id`) REFERENCES `Aula` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Reserva` ###



### structure of table `Tarea` ###

DROP TABLE IF EXISTS `Tarea`;

CREATE TABLE `Tarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


### data of table `Tarea` ###



### structure of table `Usuario` ###

DROP TABLE IF EXISTS `Usuario`;

CREATE TABLE `Usuario` (
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
  CONSTRAINT `FK_EDD889C155394E80` FOREIGN KEY (`personas_id`) REFERENCES `Persona` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2;


### data of table `Usuario` ###

insert into `Usuario` values ('1', null, 'root', 'root', 'root@root.com', 'root@root.com', '1', '3eofut8ydcw0s84kgk4gowoc8w40c0s', 'tSMR4Bi4PD/NGS+Yom/k6tDm3AICha+ALFJywVhHpL8NmBSwHMIZa1xvcJDC2tbikYdhJoxmXDzdD8gNBeFtkg==', '2014-10-02 12:04:32', '0', '0', null, null, null, 'a:0:{}', '0', null);


# ring constraints workaround
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
