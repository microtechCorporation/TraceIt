CREATE DATABASE  IF NOT EXISTS `dbsistema_tracemz` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbsistema_tracemz`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbsistema_tracemz
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Admin Principal','admin@tracemz.com','$2y$10$8bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ0a1bZ','2025-09-16 10:37:45','2025-09-16 10:37:45',1);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispositivos`
--

DROP TABLE IF EXISTS `dispositivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dispositivos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `imei` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `marca` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fotos` text COLLATE utf8mb4_general_ci,
  `status` enum('ativo','roubado','perdido','recuperado') COLLATE utf8mb4_general_ci DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo_dispositivo` enum('celular','laptop') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'celular',
  PRIMARY KEY (`id`),
  UNIQUE KEY `imei` (`imei`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `dispositivos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivos`
--

LOCK TABLES `dispositivos` WRITE;
/*!40000 ALTER TABLE `dispositivos` DISABLE KEYS */;
INSERT INTO `dispositivos` VALUES (1,72,'123456789012345','Samsung','Galaxy S21','Preto','samsung_s21_preto.jpg','ativo','2025-09-16 10:37:45','2025-09-16 10:37:45','celular'),(2,72,'987654321098765','Apple','iPhone 13','Branco','iphone_13_branco.jpg','roubado','2025-09-16 10:37:45','2025-09-16 10:37:45','celular'),(3,73,'456789123456789','Xiaomi','Redmi Note 10','Azul','xiaomi_redmi_note10_azul.jpg','perdido','2025-09-16 10:37:45','2025-09-16 10:37:45','celular'),(4,73,'654321987654321','Huawei','P40 Lite','Verde','huawei_p40lite_verde.jpg','ativo','2025-09-16 10:37:45','2025-09-16 10:37:45','celular'),(5,74,'789123456789123','Motorola','Moto G100','Cinza','moto_g100_cinza.jpg','recuperado','2025-09-16 10:37:45','2025-09-16 10:37:45','celular'),(6,72,'123456789012346','iPhone','15','rosa',NULL,'ativo','2025-09-18 14:50:01','2025-09-18 14:50:01','celular'),(14,72,'123456789012342','Assus','11th geração','preto',NULL,'ativo','2025-09-19 08:31:38','2025-09-19 08:31:38','laptop'),(18,72,'123456789012343','Samsung','A12','Preto',NULL,'perdido','2025-09-19 08:43:59','2025-09-19 14:44:54','celular'),(21,72,'123456789012348','Hp','8th geração','Cinzento','/assets/uploads/devices/21_20250919180901.png','ativo','2025-09-19 13:36:26','2025-09-19 16:09:01','laptop'),(22,72,'123456789012322','Tecno','Spark','Branco',NULL,'roubado','2025-09-19 13:55:17','2025-09-19 14:44:23','celular'),(23,72,'123456789112342','iPhone','13','Azul','/assets/uploads/devices/123456789112342_20250919174321.jpg','ativo','2025-09-19 15:43:21','2025-09-23 16:11:23','celular');
/*!40000 ALTER TABLE `dispositivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs_admins`
--

DROP TABLE IF EXISTS `logs_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs_admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `acao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `ip_origem` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `logs_admins_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_admins`
--

LOCK TABLES `logs_admins` WRITE;
/*!40000 ALTER TABLE `logs_admins` DISABLE KEYS */;
INSERT INTO `logs_admins` VALUES (1,1,'Aprovar Ocorrência','Admin aprovou a ocorrência de recuperação do dispositivo ID 5.','192.168.1.100','Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/117.0.0.0','2025-09-16 10:37:45');
/*!40000 ALTER TABLE `logs_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs_usuarios`
--

DROP TABLE IF EXISTS `logs_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `acao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `ip_origem` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `logs_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_usuarios`
--

LOCK TABLES `logs_usuarios` WRITE;
/*!40000 ALTER TABLE `logs_usuarios` DISABLE KEYS */;
INSERT INTO `logs_usuarios` VALUES (1,72,'Login','Usuário Horácio fez login no sistema.','192.168.1.10','Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/117.0.0.0','2025-09-16 10:37:45'),(2,73,'Registro Dispositivo','Usuário Ana registrou um novo dispositivo.','192.168.1.11','Mozilla/5.0 (Android 12; Mobile) Chrome/117.0.0.0','2025-09-16 10:37:45'),(3,74,'Reporte Ocorrência','Usuário João reportou uma ocorrência de recuperação.','192.168.1.12','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/16.0','2025-09-16 10:37:45');
/*!40000 ALTER TABLE `logs_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ocorrencias`
--

DROP TABLE IF EXISTS `ocorrencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ocorrencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dispositivo_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `data_ocorrencia` date NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'registrado',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dispositivo_id` (`dispositivo_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `ocorrencias_ibfk_1` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`),
  CONSTRAINT `ocorrencias_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ocorrencias`
--

LOCK TABLES `ocorrencias` WRITE;
/*!40000 ALTER TABLE `ocorrencias` DISABLE KEYS */;
INSERT INTO `ocorrencias` VALUES (1,1,72,'Furto','2025-09-01','Maputo, Av. 24 de Julho','Dispositivo roubado em um assalto à mão armada.','registrado','2025-09-16 10:37:45','2025-09-16 10:37:45'),(2,2,72,'Roubo','2025-09-05','Maputo, Bairro Central','iPhone roubado de dentro do carro.','em investigação','2025-09-16 10:37:45','2025-09-16 10:37:45'),(3,3,73,'Perda','2025-09-03','Matola, Mercado','Dispositivo perdido durante compras no mercado.','registrado','2025-09-16 10:37:45','2025-09-16 10:37:45'),(4,5,74,'Recuperação','2025-09-10','Maputo, Polícia','Dispositivo recuperado pela polícia após denúncia.','recuperado','2025-09-16 10:37:45','2025-09-16 10:37:45'),(10,22,72,'furto','2025-09-06','Bairro de Benfica','Na paragem','registrado','2025-09-19 14:44:23','2025-09-19 14:44:23'),(11,18,72,'perda','2025-09-05','Bairro de Benfica','No chapa','registrado','2025-09-19 14:44:54','2025-09-19 14:44:54');
/*!40000 ALTER TABLE `ocorrencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token_api` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ativo` tinyint(1) DEFAULT '1',
  `email_verificado` tinyint(1) DEFAULT '0',
  `codigo_verificacao` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo_expiracao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `token_api` (`token_api`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (72,'Horacio','gunehoracio@gmail.com','$2y$10$ikkUWMyhlKDyEO3JuX.1/e/HMPSeYqgk9u4ncqM3E5JHWX94xvfhS','3bb1d7ad26a67b6d4cc67957265334ce31f1bfbe42831c75a917e125f5e41b13','2025-09-06 23:22:04','2025-09-06 23:22:29',1,1,NULL,NULL),(73,'Ana Silva','ana.silva@gmail.com','$2y$10$6zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9zX8Y9z','4bb2e8be27b78c7e5dd78068376435df42g2cgcf53942d86b028f236g6f52c24','2025-09-16 10:37:45','2025-09-16 10:37:45',1,1,NULL,NULL),(74,'João Mário','joao.mario@gmail.com','$2y$10$7aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY9Z0aY','5cc3f9cf38c89d8f6ee89179487546eg53h3dhdf64953e97c139g7g63d35','2025-09-16 10:37:45','2025-09-16 10:37:45',1,1,NULL,NULL),(76,'Clementina Elihud','clementinaelihud@gmail.com','1234','8492','2025-09-16 11:43:27','2025-09-16 11:43:27',1,1,NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-23 19:19:15
