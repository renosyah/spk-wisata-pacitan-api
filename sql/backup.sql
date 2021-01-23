-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: spk_wisata_pacitan_api_db
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text,
  `username` text,
  `password` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pariwisata`
--

DROP TABLE IF EXISTS `data_pariwisata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_pariwisata` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori_id` int NOT NULL,
  `nama` text,
  `lokasi` text,
  `deskripsi` text,
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `data_pariwisata_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pariwisata`
--

LOCK TABLES `data_pariwisata` WRITE;
/*!40000 ALTER TABLE `data_pariwisata` DISABLE KEYS */;
INSERT INTO `data_pariwisata` VALUES (2,2,'Pantai pasir panjang','di pacitan','Pantai pasir panjang tempat wisata');
/*!40000 ALTER TABLE `data_pariwisata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pariwisata_attribut`
--

DROP TABLE IF EXISTS `data_pariwisata_attribut`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_pariwisata_attribut` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_pariwisata_id` int NOT NULL,
  `kriteria_range_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `data_pariwisata_id` (`data_pariwisata_id`),
  KEY `kriteria_range_id` (`kriteria_range_id`),
  CONSTRAINT `data_pariwisata_attribut_ibfk_1` FOREIGN KEY (`data_pariwisata_id`) REFERENCES `data_pariwisata` (`id`),
  CONSTRAINT `data_pariwisata_attribut_ibfk_2` FOREIGN KEY (`kriteria_range_id`) REFERENCES `kriteria_range` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pariwisata_attribut`
--

LOCK TABLES `data_pariwisata_attribut` WRITE;
/*!40000 ALTER TABLE `data_pariwisata_attribut` DISABLE KEYS */;
INSERT INTO `data_pariwisata_attribut` VALUES (2,2,4);
/*!40000 ALTER TABLE `data_pariwisata_attribut` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (2,'Pantai','wisata pantai'),(3,'Rekreasi','wisata rekreasi'),(4,'Goa','wisata goa');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriteria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text,
  `deskripsi` text,
  `nilai` float DEFAULT NULL,
  `attribut` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria`
--

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` VALUES (2,'Tiket Masuk','Tiket Masuk',4.4,'COST'),(3,'Jarak','Jarak tempat wisata',3.5,'COST'),(4,'Umur','umur untuk masuk tempat wisata',2.1,'BENEFIT'),(5,'Fasilitas','Fasilitas tempat wisata',3.9,'BENEFIT');
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria_range`
--

DROP TABLE IF EXISTS `kriteria_range`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriteria_range` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kriteria_id` int NOT NULL,
  `nama` text,
  `deskripsi` text,
  `nilai` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kriteria_id` (`kriteria_id`),
  CONSTRAINT `kriteria_range_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria_range`
--

LOCK TABLES `kriteria_range` WRITE;
/*!40000 ALTER TABLE `kriteria_range` DISABLE KEYS */;
INSERT INTO `kriteria_range` VALUES (2,5,'Tempat Parkir','Fasilitas Tempat Parkir tempat wisata',4),(3,5,'Tempat Makan','Fasilitas Tempat makan tempat wisata',6),(4,5,'Tempat Ibadah','Fasilitas Tempat makan tempat wisata',3),(5,5,'Hotel','Fasilitas hotel tempat swisata',5);
/*!40000 ALTER TABLE `kriteria_range` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-23 23:55:59
