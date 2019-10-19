-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: nbdata2018_1
-- ------------------------------------------------------
-- Server version	10.1.34-MariaDB-1~xenial

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `idarea` tinyint(3) NOT NULL,
  `area` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'ADMINISTRACION'),(2,'VENTAS'),(3,'ALMACEN'),(4,'TESORERIA'),(5,'SISTEMAS'),(6,'CONTABILIDAD');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caja`
--

DROP TABLE IF EXISTS `caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caja` (
  `idcaja` char(15) NOT NULL,
  `idlocal` tinyint(3) NOT NULL,
  `tipo` char(10) NOT NULL,
  `idcajero` char(15) NOT NULL,
  `documento` char(18) NOT NULL,
  `fecha` date NOT NULL,
  `hora` char(12) NOT NULL,
  `forma_pago` char(20) DEFAULT NULL,
  `ref_pago` char(20) DEFAULT NULL,
  `concepto` char(60) DEFAULT NULL,
  `entrada` decimal(15,4) NOT NULL,
  `salida` decimal(15,4) NOT NULL,
  `moneda` char(3) NOT NULL,
  `turno` tinyint(2) DEFAULT NULL,
  `num_caja` tinyint(2) DEFAULT NULL,
  `usuario` char(20) NOT NULL,
  `orig_dest` varchar(50) DEFAULT NULL,
  KEY `idcaja` (`idcaja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja`
--

LOCK TABLES `caja` WRITE;
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clases`
--

DROP TABLE IF EXISTS `clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clases` (
  `idclase` decimal(4,0) NOT NULL,
  `nombre` char(15) NOT NULL,
  KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clases`
--

LOCK TABLES `clases` WRITE;
/*!40000 ALTER TABLE `clases` DISABLE KEYS */;
/*!40000 ALTER TABLE `clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idcliente` char(15) NOT NULL,
  `cliente` char(80) NOT NULL,
  `ruc` char(15) NOT NULL,
  `ncomercial` varchar(50) DEFAULT NULL,
  `contacto` varchar(30) DEFAULT NULL,
  `dni` char(15) DEFAULT NULL,
  `giro` varchar(35) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `departamento` varchar(30) DEFAULT NULL,
  `provincia` varchar(30) DEFAULT NULL,
  `distrito` varchar(30) DEFAULT NULL,
  `telefono` varchar(35) DEFAULT NULL,
  `celular` varchar(35) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `credito` decimal(15,2) DEFAULT NULL,
  `lista_prec` decimal(2,0) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `idvendedor` char(15) DEFAULT NULL,
  PRIMARY KEY (`idcliente`),
  KEY `ruc` (`ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES ('1','CLIENTE PUBLICO','00000000','','','','','LIMA - LIMA - LIMA','LIMA','LIMA','LIMA','','','',0.00,0,'2019-01-17','');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compras` (
  `idcompra` char(15) NOT NULL DEFAULT '',
  `idlocal` int(3) NOT NULL,
  `tipodoc` char(2) NOT NULL,
  `idproveedo` char(15) NOT NULL,
  `ruc` char(15) DEFAULT NULL,
  `proveedor` varchar(60) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `idpersonal` char(15) DEFAULT NULL,
  `usuario` char(20) DEFAULT NULL,
  `documento` char(30) NOT NULL,
  `fecha` date NOT NULL,
  `hora` char(12) DEFAULT NULL,
  `moneda` char(4) DEFAULT NULL,
  `cambio` decimal(8,3) DEFAULT NULL,
  `condicion` varchar(30) DEFAULT NULL,
  `fecha_vto` date DEFAULT NULL,
  `ocompra` varchar(20) DEFAULT NULL,
  `guia` varchar(20) DEFAULT NULL,
  `inc_igv` tinyint(1) DEFAULT NULL,
  `inicial` decimal(15,4) DEFAULT NULL,
  `saldo` decimal(15,4) DEFAULT NULL,
  `bruto` decimal(15,4) DEFAULT NULL,
  `descuento` decimal(15,4) DEFAULT NULL,
  `subtotal` decimal(15,4) DEFAULT NULL,
  `igv` decimal(15,4) DEFAULT NULL,
  `total` decimal(15,4) DEFAULT NULL,
  `percepcion` decimal(15,4) DEFAULT NULL,
  `detraccion` decimal(15,4) DEFAULT NULL,
  `total_pagar` decimal(15,4) DEFAULT NULL,
  `forma_pago` varchar(30) DEFAULT NULL,
  `ref_pago` varchar(30) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `idkardex` varchar(20) DEFAULT NULL,
  `idpago` varchar(15) DEFAULT NULL,
  `idcaja` varchar(15) DEFAULT NULL,
  `canjeado` tinyint(1) DEFAULT NULL,
  `act_stock` tinyint(1) DEFAULT NULL,
  `notac_ref` varchar(20) DEFAULT NULL,
  `notac_idcom` varchar(15) DEFAULT NULL,
  `idpagomov` varchar(15) DEFAULT NULL,
  `idorden` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idcompra`),
  KEY `documento` (`documento`),
  KEY `idproveedo` (`idproveedo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentas_cobrar`
--

DROP TABLE IF EXISTS `cuentas_cobrar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentas_cobrar` (
  `idcobro` char(15) NOT NULL,
  `idventa` char(15) NOT NULL,
  `idlocal` int(3) NOT NULL,
  `idcliente` char(15) NOT NULL,
  `tipodoc` char(3) NOT NULL,
  `documento` char(15) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_vto` date NOT NULL,
  `moneda` char(6) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `estado` char(1) NOT NULL,
  `inicial` decimal(15,4) NOT NULL,
  `saldo` decimal(15,4) NOT NULL,
  `banco` varchar(60) DEFAULT NULL,
  `idencargado` char(6) NOT NULL,
  `usuario` char(20) NOT NULL,
  `doc_referencia` varchar(50) DEFAULT NULL,
  `numero_unico` varchar(30) DEFAULT NULL,
  KEY `idventa` (`idcobro`),
  KEY `idencargado` (`idencargado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentas_cobrar`
--

LOCK TABLES `cuentas_cobrar` WRITE;
/*!40000 ALTER TABLE `cuentas_cobrar` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentas_cobrar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentas_cobrar_mov`
--

DROP TABLE IF EXISTS `cuentas_cobrar_mov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentas_cobrar_mov` (
  `idcobromov` char(15) NOT NULL,
  `idcobro` char(15) NOT NULL,
  `idlocal` int(3) NOT NULL,
  `idcliente` char(15) NOT NULL,
  `documento_ref` char(20) DEFAULT NULL,
  `forma_pago` char(30) DEFAULT NULL,
  `ref_pago` char(20) DEFAULT NULL,
  `moneda` char(6) NOT NULL,
  `monto` decimal(15,4) NOT NULL,
  `fecha_cob` date NOT NULL,
  `hora` char(12) NOT NULL,
  `idcobrador` char(5) NOT NULL,
  `idcaja` char(15) NOT NULL,
  `usuario` char(20) NOT NULL,
  `observacion` varchar(50) DEFAULT NULL,
  KEY `idcobro` (`idcobro`),
  KEY `idcobromov` (`idcobromov`),
  KEY `idcobrador` (`idcobrador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentas_cobrar_mov`
--

LOCK TABLES `cuentas_cobrar_mov` WRITE;
/*!40000 ALTER TABLE `cuentas_cobrar_mov` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentas_cobrar_mov` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentas_pagar`
--

DROP TABLE IF EXISTS `cuentas_pagar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentas_pagar` (
  `idpago` char(15) NOT NULL,
  `idcompra` char(15) NOT NULL,
  `idlocal` int(3) NOT NULL,
  `idproveedor` char(15) NOT NULL,
  `tipodoc` char(3) NOT NULL,
  `documento` char(15) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_vto` date NOT NULL,
  `moneda` char(6) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `estado` char(1) NOT NULL,
  `inicial` decimal(15,4) NOT NULL,
  `saldo` decimal(15,4) NOT NULL,
  `banco` char(60) NOT NULL,
  `idencargado` char(6) NOT NULL,
  `usuario` char(20) NOT NULL,
  `doc_referencia` varchar(50) DEFAULT NULL,
  `numero_unico` varchar(30) DEFAULT NULL,
  KEY `idpago` (`idpago`),
  KEY `idencargado` (`idencargado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentas_pagar`
--

LOCK TABLES `cuentas_pagar` WRITE;
/*!40000 ALTER TABLE `cuentas_pagar` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentas_pagar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentas_pagar_mov`
--

DROP TABLE IF EXISTS `cuentas_pagar_mov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentas_pagar_mov` (
  `idpagomov` char(15) NOT NULL,
  `idpago` char(15) NOT NULL,
  `idlocal` int(3) NOT NULL,
  `idproveedor` char(15) NOT NULL,
  `documento_ref` char(20) DEFAULT NULL,
  `forma_pago` char(30) DEFAULT NULL,
  `ref_pago` char(20) DEFAULT NULL,
  `moneda` char(6) NOT NULL,
  `monto` decimal(15,4) NOT NULL,
  `fecha_pag` date NOT NULL,
  `hora` char(12) NOT NULL,
  `idencargado` char(5) NOT NULL,
  `idcaja` char(15) NOT NULL,
  `usuario` char(20) NOT NULL,
  `observacion` varchar(50) DEFAULT NULL,
  KEY `idencargado` (`idencargado`),
  KEY `idpago` (`idpago`),
  KEY `idpagomov` (`idpagomov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentas_pagar_mov`
--

LOCK TABLES `cuentas_pagar_mov` WRITE;
/*!40000 ALTER TABLE `cuentas_pagar_mov` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentas_pagar_mov` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_art`
--

DROP TABLE IF EXISTS `det_art`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_art` (
  `idproducto` char(15) DEFAULT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `cantidad` decimal(8,3) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_art`
--

LOCK TABLES `det_art` WRITE;
/*!40000 ALTER TABLE `det_art` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_art` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_com`
--

DROP TABLE IF EXISTS `det_com`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_com` (
  `idcompra` char(15) NOT NULL,
  `idlocal` int(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `marca` char(30) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `desc_cad` char(20) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `precio_neto` decimal(15,4) DEFAULT NULL,
  `importe` decimal(15,4) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT NULL,
  KEY `idcompra` (`idcompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_com`
--

LOCK TABLES `det_com` WRITE;
/*!40000 ALTER TABLE `det_com` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_com` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_gui`
--

DROP TABLE IF EXISTS `det_gui`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_gui` (
  `idguia` char(15) NOT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `marca` char(50) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `desc_cad` char(20) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `precio_neto` decimal(15,4) DEFAULT NULL,
  `importe` decimal(15,4) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `codigo2` char(20) DEFAULT NULL,
  `peso` decimal(10,4) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT NULL,
  KEY `idguia` (`idguia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_gui`
--

LOCK TABLES `det_gui` WRITE;
/*!40000 ALTER TABLE `det_gui` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_gui` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_ing`
--

DROP TABLE IF EXISTS `det_ing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_ing` (
  `idingreso` char(15) NOT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `marca` char(30) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  KEY `idingreso` (`idingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_ing`
--

LOCK TABLES `det_ing` WRITE;
/*!40000 ALTER TABLE `det_ing` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_ing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_ord`
--

DROP TABLE IF EXISTS `det_ord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_ord` (
  `idorden` char(15) NOT NULL,
  `idlocal` int(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `codigo2` varchar(20) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  `cantidad` decimal(8,4) DEFAULT NULL,
  `medida` varchar(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `moneda` char(6) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `desc_cad` char(20) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `precio_neto` decimal(15,4) DEFAULT NULL,
  `importe` decimal(15,4) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT NULL,
  `canjeado` tinyint(1) DEFAULT NULL,
  KEY `idorden` (`idorden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_ord`
--

LOCK TABLES `det_ord` WRITE;
/*!40000 ALTER TABLE `det_ord` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_ord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_pro`
--

DROP TABLE IF EXISTS `det_pro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_pro` (
  `idproforma` char(15) NOT NULL,
  `idlocal` int(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `codigo2` varchar(20) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  `cantidad` decimal(8,4) DEFAULT NULL,
  `medida` varchar(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `moneda` char(3) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `desc_cad` char(20) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `precio_neto` decimal(15,4) DEFAULT NULL,
  `importe` decimal(15,4) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT NULL,
  `canjeado` tinyint(1) DEFAULT NULL,
  KEY `idproforma` (`idproforma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_pro`
--

LOCK TABLES `det_pro` WRITE;
/*!40000 ALTER TABLE `det_pro` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_pro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_sal`
--

DROP TABLE IF EXISTS `det_sal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_sal` (
  `idsalida` char(15) NOT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `marca` char(30) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  KEY `idsalida` (`idsalida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_sal`
--

LOCK TABLES `det_sal` WRITE;
/*!40000 ALTER TABLE `det_sal` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_sal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_tra`
--

DROP TABLE IF EXISTS `det_tra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_tra` (
  `idtraslado` char(15) NOT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `marca` char(30) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  KEY `idtraslado` (`idtraslado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_tra`
--

LOCK TABLES `det_tra` WRITE;
/*!40000 ALTER TABLE `det_tra` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_tra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_vta`
--

DROP TABLE IF EXISTS `det_vta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_vta` (
  `idventa` char(15) NOT NULL,
  `idlocal` int(3) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `codigo` char(20) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `marca` char(50) DEFAULT NULL,
  `cantidad` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `desc_cad` char(20) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `precio_neto` decimal(15,4) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `importe` decimal(15,4) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `medida` varchar(20) DEFAULT NULL,
  `num_um` tinyint(1) DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `lotes` varchar(50) DEFAULT NULL,
  `tallas` varchar(50) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT NULL,
  KEY `idventa` (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_vta`
--

LOCK TABLES `det_vta` WRITE;
/*!40000 ALTER TABLE `det_vta` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_vta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direcciones` (
  `idcliente` char(15) NOT NULL,
  `num_dir` int(2) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `codempresa` char(3) NOT NULL,
  `ruc` char(15) DEFAULT NULL,
  `empresa` varchar(60) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `pagina` varchar(60) DEFAULT NULL,
  `correo` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES ('001','12345678901','EMPRESA EJEMPLO SAC                                         ','AV. MI DIRECCION 100 - DISTRITO - DEPARTAMENTO                                                                                                        ','01-1234567                              ','www.mipagina.com                                  ','micorreo@mipagina.com                             ');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guias`
--

DROP TABLE IF EXISTS `guias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guias` (
  `idguia` char(15) NOT NULL DEFAULT '',
  `idlocal` tinyint(3) NOT NULL,
  `documento` char(20) NOT NULL,
  `ref_tipodoc` char(7) DEFAULT NULL,
  `ref_num_doc` char(15) DEFAULT NULL,
  `idcliente` char(15) NOT NULL,
  `partida` varchar(100) DEFAULT NULL,
  `llegada` varchar(100) DEFAULT NULL,
  `idpersonal` char(15) DEFAULT NULL,
  `usuario` char(20) DEFAULT NULL,
  `fecha_emi` date NOT NULL,
  `fecha_tra` date NOT NULL,
  `hora` char(12) DEFAULT NULL,
  `lista_prec` int(2) NOT NULL,
  `idtranspor` char(8) DEFAULT NULL,
  `moneda` char(5) NOT NULL,
  `cambio` decimal(5,3) NOT NULL,
  `condicion` varchar(50) NOT NULL,
  `inc_igv` tinyint(2) NOT NULL,
  `peso` decimal(10,4) NOT NULL,
  `idkardex` char(15) NOT NULL,
  `observacion` varchar(80) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `certificado` varchar(20) DEFAULT NULL,
  `licencia` varchar(20) DEFAULT NULL,
  `chofer` varchar(20) DEFAULT NULL,
  `act_stock` tinyint(1) NOT NULL,
  `anulada` tinyint(1) NOT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `ruc_transp` char(15) DEFAULT NULL,
  `emp_transp` varchar(50) DEFAULT NULL,
  `direcc_transp` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idguia`),
  KEY `documento` (`documento`),
  KEY `idcliente` (`idcliente`),
  KEY `idtranspor` (`idtranspor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guias`
--

LOCK TABLES `guias` WRITE;
/*!40000 ALTER TABLE `guias` DISABLE KEYS */;
/*!40000 ALTER TABLE `guias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingresos` (
  `idingreso` char(15) NOT NULL DEFAULT '',
  `idlocal` int(3) NOT NULL,
  `documento` char(20) NOT NULL,
  `idproveedor` char(12) NOT NULL,
  `idpersonal` char(12) NOT NULL,
  `usuario` char(10) NOT NULL,
  `fecha` date NOT NULL,
  `hora` char(12) NOT NULL,
  `moneda` char(6) NOT NULL,
  `cambio` decimal(8,3) NOT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `orden` char(15) NOT NULL,
  `guia` char(15) NOT NULL,
  `inc_igv` tinyint(2) NOT NULL,
  `observac` varchar(100) DEFAULT NULL,
  `idkardex` char(15) NOT NULL,
  `act_stock` tinyint(1) NOT NULL,
  PRIMARY KEY (`idingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos`
--

LOCK TABLES `ingresos` WRITE;
/*!40000 ALTER TABLE `ingresos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kardex`
--

DROP TABLE IF EXISTS `kardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kardex` (
  `idlocal` int(3) DEFAULT NULL,
  `idkardex` char(15) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `idmov` char(15) DEFAULT NULL,
  `documento` char(24) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` char(12) DEFAULT NULL,
  `usuario` char(15) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `entrada` decimal(15,4) DEFAULT NULL,
  `salida` decimal(15,4) DEFAULT NULL,
  `valor_cos` decimal(15,4) DEFAULT NULL,
  `stock_ant` decimal(15,4) DEFAULT NULL,
  `stock_act` decimal(15,4) DEFAULT NULL,
  `val_existe` decimal(15,4) DEFAULT NULL,
  `observac` varchar(100) DEFAULT NULL,
  `notas` varchar(100) DEFAULT NULL,
  KEY `idproducto` (`idproducto`),
  KEY `idkardex` (`idkardex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kardex`
--

LOCK TABLES `kardex` WRITE;
/*!40000 ALTER TABLE `kardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `kardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locales`
--

DROP TABLE IF EXISTS `locales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locales` (
  `idlocal` int(3) NOT NULL,
  `local` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locales`
--

LOCK TABLES `locales` WRITE;
/*!40000 ALTER TABLE `locales` DISABLE KEYS */;
INSERT INTO `locales` VALUES (1,'LOCAL PRINCIPAL');
/*!40000 ALTER TABLE `locales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lotes`
--

DROP TABLE IF EXISTS `lotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lotes` (
  `num_mov` char(20) DEFAULT NULL,
  `lote` char(35) DEFAULT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idproducto` char(12) DEFAULT NULL,
  `iddoc` char(20) DEFAULT NULL,
  `num_doc` char(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `entrada` decimal(10,2) DEFAULT NULL,
  `salida` decimal(10,2) DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL,
  `empresa` varchar(80) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lotes`
--

LOCK TABLES `lotes` WRITE;
/*!40000 ALTER TABLE `lotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `lotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marcas` (
  `idmarca` tinyint(3) NOT NULL,
  `nombre` char(30) DEFAULT NULL,
  KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes` (
  `idorden` char(15) NOT NULL DEFAULT '',
  `idlocal` tinyint(3) NOT NULL,
  `idproveedo` char(15) NOT NULL,
  `idpersonal` char(15) NOT NULL,
  `documento` char(15) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_req` date NOT NULL,
  `fecha_vto` date NOT NULL,
  `moneda` char(5) NOT NULL,
  `cambio` decimal(8,4) NOT NULL,
  `bruto` decimal(15,4) NOT NULL,
  `descuento` decimal(15,4) NOT NULL,
  `subtotal` decimal(15,4) NOT NULL,
  `igv` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `observac` varchar(100) DEFAULT NULL,
  `condicion` varchar(30) DEFAULT NULL,
  `usuario` char(20) DEFAULT NULL,
  `hora` char(12) DEFAULT NULL,
  `cond_impuesto` char(30) DEFAULT NULL,
  `atencion` char(30) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `mod_pago` char(30) DEFAULT NULL,
  PRIMARY KEY (`idorden`),
  KEY `documento` (`documento`),
  KEY `idproveed` (`idproveedo`),
  KEY `idpersonal` (`idpersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `pais` char(30) NOT NULL,
  `tcambio` decimal(8,4) DEFAULT NULL,
  `optimizar` tinyint(1) DEFAULT NULL,
  `igv_inc` tinyint(1) DEFAULT NULL,
  `moneda` char(5) DEFAULT NULL,
  `nom_moneda` char(20) DEFAULT NULL,
  `defaul_mon` tinyint(1) DEFAULT NULL,
  `impuesto_porcentaje` decimal(5,2) DEFAULT NULL,
  `impuesto_nombre` char(20) DEFAULT NULL,
  `ruc_nombre` char(20) DEFAULT NULL,
  `percepcion_procentaje` decimal(5,2) DEFAULT NULL,
  `detraccion_porcentaje` decimal(5,2) DEFAULT NULL,
  `formato_ruc` char(20) DEFAULT NULL,
  `dec_totales` tinyint(1) DEFAULT NULL,
  `dec_precios` tinyint(1) DEFAULT NULL,
  `dec_cantidad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES ('PERU',3.0000,0,1,'S/','Soles',1,18.00,'IGV','RUC',2.00,NULL,'99999999999',2,2,2);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal` (
  `idpersonal` char(12) NOT NULL,
  `dni` char(15) DEFAULT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `correo` varchar(60) DEFAULT NULL,
  `celular` varchar(30) DEFAULT NULL,
  `observac` varchar(80) DEFAULT NULL,
  `comision` decimal(10,3) DEFAULT NULL,
  `zona` varchar(30) DEFAULT NULL,
  `fecha_reg` date DEFAULT NULL,
  `vendedor` tinyint(1) DEFAULT NULL,
  `cobrador` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idpersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `idproducto` char(15) NOT NULL,
  `idlocal` int(3) DEFAULT '0',
  `codigo` char(20) DEFAULT NULL,
  `codigo2` char(20) DEFAULT NULL,
  `codigo_bar` char(20) DEFAULT NULL,
  `codigo_fab` char(20) DEFAULT NULL,
  `descripcion` char(80) DEFAULT NULL,
  `clase` varchar(30) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `fec_reg` date DEFAULT NULL,
  `stock_min` decimal(7,2) DEFAULT NULL,
  `medida` char(20) DEFAULT NULL,
  `medida_fra` char(20) DEFAULT NULL,
  `fraccion` int(4) DEFAULT '1',
  `costo` decimal(15,4) DEFAULT NULL,
  `precio` decimal(15,4) DEFAULT NULL,
  `precio1` decimal(15,4) DEFAULT NULL,
  `precio2` decimal(15,4) DEFAULT NULL,
  `precio3` decimal(15,4) DEFAULT NULL,
  `precio4` decimal(15,4) DEFAULT NULL,
  `precio_fra` decimal(15,4) DEFAULT NULL,
  `precio_prm` decimal(15,4) DEFAULT NULL,
  `moneda` char(8) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `imagen` varchar(120) DEFAULT NULL,
  `contenido` varchar(100) DEFAULT NULL,
  `propiedad` varchar(100) DEFAULT NULL,
  `stock` decimal(8,2) DEFAULT NULL,
  `lotes` tinyint(1) DEFAULT '0',
  `series` tinyint(1) DEFAULT '0',
  `tallas` tinyint(1) DEFAULT '0',
  `exonerado` tinyint(1) DEFAULT '0',
  `procedencia` varchar(20) DEFAULT NULL,
  `proveedor` varchar(15) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `no_stock` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idproducto`),
  KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES ('1',0,'31','12','123',NULL,'Clavos',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2.0000,1.0000,1.0000,1.0000,1.0000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,NULL,NULL,NULL,0),('2',0,'31','12','123',NULL,'Martillos',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2.0000,1.0000,1.0000,1.0000,1.0000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,NULL,NULL,NULL,0),('3',2,'333','2232','123',NULL,'Pintura',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2.0000,1.0000,1.0000,1.0000,1.0000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proformas`
--

DROP TABLE IF EXISTS `proformas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proformas` (
  `idproforma` char(15) NOT NULL DEFAULT '',
  `idlocal` tinyint(3) NOT NULL,
  `idcliente` char(15) NOT NULL,
  `idvendedor` char(8) NOT NULL,
  `documento` char(20) NOT NULL,
  `fecha` date NOT NULL,
  `lista_prec` int(1) NOT NULL,
  `moneda` char(3) NOT NULL,
  `cambio` decimal(8,4) NOT NULL,
  `bruto` decimal(15,4) NOT NULL,
  `descuento` decimal(15,4) NOT NULL,
  `subtotal` decimal(15,4) NOT NULL,
  `igv` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `observac` varchar(80) DEFAULT NULL,
  `condicion` varchar(30) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `hora` char(12) DEFAULT NULL,
  `cond_impuesto` varchar(30) DEFAULT NULL,
  `atencion` varchar(50) DEFAULT NULL,
  `tentrega` varchar(50) DEFAULT NULL,
  `toferta` varchar(50) DEFAULT NULL,
  `estado` char(3) DEFAULT NULL,
  PRIMARY KEY (`idproforma`),
  KEY `documento` (`documento`),
  KEY `idcliente` (`idcliente`),
  KEY `idvendedor` (`idvendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proformas`
--

LOCK TABLES `proformas` WRITE;
/*!40000 ALTER TABLE `proformas` DISABLE KEYS */;
/*!40000 ALTER TABLE `proformas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `idproveedo` char(15) NOT NULL,
  `ruc` char(20) NOT NULL,
  `proveedor` char(80) NOT NULL,
  `ncomercial` varchar(80) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `pagina` varchar(50) DEFAULT NULL,
  `telefonos` varchar(35) DEFAULT NULL,
  `celulares` varchar(35) DEFAULT NULL,
  `cuentas` varchar(50) DEFAULT NULL,
  `observac` varchar(80) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idproveedo`),
  KEY `ruc` (`ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salidas`
--

DROP TABLE IF EXISTS `salidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salidas` (
  `idsalida` char(15) NOT NULL DEFAULT '',
  `idlocal` tinyint(3) NOT NULL,
  `documento` char(20) NOT NULL,
  `idcliente` char(12) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `idpersonal` char(12) DEFAULT NULL,
  `usuario` char(10) DEFAULT NULL,
  `lista_prec` tinyint(2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` char(12) DEFAULT NULL,
  `moneda` char(6) DEFAULT NULL,
  `cambio` decimal(8,3) DEFAULT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `proforma` char(15) DEFAULT NULL,
  `guia` char(15) DEFAULT NULL,
  `inc_igv` tinyint(2) DEFAULT NULL,
  `observac` varchar(80) DEFAULT NULL,
  `idkardex` char(15) DEFAULT NULL,
  `act_stock` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idsalida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidas`
--

LOCK TABLES `salidas` WRITE;
/*!40000 ALTER TABLE `salidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `salidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series` (
  `iddoc` char(20) NOT NULL,
  `documento` char(20) DEFAULT NULL,
  `idproducto` char(15) DEFAULT NULL,
  `serie` char(30) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo_mov` char(1) DEFAULT NULL,
  `observa` varchar(80) DEFAULT NULL,
  `idclipro` char(15) DEFAULT NULL,
  `idlocal` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tallas`
--

DROP TABLE IF EXISTS `tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tallas` (
  `talla` char(15) DEFAULT NULL,
  `descrip` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tallas`
--

LOCK TABLES `tallas` WRITE;
/*!40000 ALTER TABLE `tallas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tallas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tallas_mov`
--

DROP TABLE IF EXISTS `tallas_mov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tallas_mov` (
  `iddoc` char(15) NOT NULL,
  `documento` char(20) DEFAULT NULL,
  `idproducto` char(12) DEFAULT NULL,
  `talla` char(15) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `entrada` decimal(10,2) DEFAULT NULL,
  `salida` decimal(10,2) DEFAULT NULL,
  `idlocal` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tallas_mov`
--

LOCK TABLES `tallas_mov` WRITE;
/*!40000 ALTER TABLE `tallas_mov` DISABLE KEYS */;
/*!40000 ALTER TABLE `tallas_mov` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transportistas`
--

DROP TABLE IF EXISTS `transportistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transportistas` (
  `idtranspor` char(12) NOT NULL,
  `transpor` char(60) NOT NULL,
  `ruc` char(15) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `chofer` varchar(50) DEFAULT NULL,
  `marca` varchar(20) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `certificado` varchar(20) DEFAULT NULL,
  `licencia` varchar(20) DEFAULT NULL,
  `celular` varchar(30) DEFAULT NULL,
  KEY `idtranspor` (`idtranspor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transportistas`
--

LOCK TABLES `transportistas` WRITE;
/*!40000 ALTER TABLE `transportistas` DISABLE KEYS */;
/*!40000 ALTER TABLE `transportistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traslados`
--

DROP TABLE IF EXISTS `traslados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traslados` (
  `idtraslado` char(15) NOT NULL,
  `idlocal` tinyint(3) NOT NULL,
  `idlocal_ori` tinyint(3) NOT NULL,
  `idlocal_des` tinyint(3) NOT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `documento` char(20) DEFAULT NULL,
  `idpersonal` char(12) DEFAULT NULL,
  `usuario` char(15) DEFAULT NULL,
  `lista_prec` tinyint(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` char(12) DEFAULT NULL,
  `moneda` char(6) DEFAULT NULL,
  `cambio` decimal(8,3) DEFAULT NULL,
  `motivo` varchar(40) DEFAULT NULL,
  `proforma` varchar(20) DEFAULT NULL,
  `guia` varchar(20) DEFAULT NULL,
  `inc_igv` tinyint(1) DEFAULT NULL,
  `observac` varchar(100) DEFAULT NULL,
  `idkardex` char(15) DEFAULT NULL,
  `act_stock` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idtraslado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traslados`
--

LOCK TABLES `traslados` WRITE;
/*!40000 ALTER TABLE `traslados` DISABLE KEYS */;
/*!40000 ALTER TABLE `traslados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuario` char(20) NOT NULL,
  `contraseña` char(15) NOT NULL,
  `idlocal` tinyint(3) DEFAULT NULL,
  `idpersonal` char(10) DEFAULT NULL,
  `tipo` char(30) DEFAULT NULL,
  `idarea` tinyint(1) DEFAULT NULL,
  `caja_abierto` tinyint(1) DEFAULT NULL,
  `almacen` tinyint(1) DEFAULT NULL,
  `alm_crear` tinyint(1) DEFAULT NULL,
  `alm_consulta` tinyint(1) DEFAULT NULL,
  `alm_kardex` tinyint(1) DEFAULT NULL,
  `alm_guia` tinyint(1) DEFAULT NULL,
  `alm_guia_consulta` tinyint(1) DEFAULT NULL,
  `alm_ingreso` tinyint(1) DEFAULT NULL,
  `alm_ing_consulta` tinyint(1) DEFAULT NULL,
  `alm_salida` tinyint(1) DEFAULT NULL,
  `alm_sal_consulta` tinyint(1) DEFAULT NULL,
  `alm_traslados` tinyint(1) DEFAULT NULL,
  `alm_tras_consulta` tinyint(1) DEFAULT NULL,
  `alm_transport` tinyint(1) DEFAULT NULL,
  `compras` tinyint(1) DEFAULT NULL,
  `com_emision` tinyint(1) DEFAULT NULL,
  `com_consulta` tinyint(1) DEFAULT NULL,
  `com_prov` tinyint(1) DEFAULT NULL,
  `com_comprados` tinyint(1) DEFAULT NULL,
  `com_letras` tinyint(1) DEFAULT NULL,
  `com_creditos` tinyint(1) DEFAULT NULL,
  `com_orden` tinyint(1) DEFAULT NULL,
  `com_ord_consulta` tinyint(1) DEFAULT NULL,
  `ventas` tinyint(1) DEFAULT NULL,
  `ven_emision` tinyint(1) DEFAULT NULL,
  `ven_consulta` tinyint(1) DEFAULT NULL,
  `ven_clie` tinyint(1) DEFAULT NULL,
  `ven_vendidos` tinyint(1) DEFAULT NULL,
  `ven_letras` tinyint(1) DEFAULT NULL,
  `ven_creditos` tinyint(1) DEFAULT NULL,
  `ven_proformas` tinyint(1) DEFAULT NULL,
  `ven_prof_consulta` tinyint(1) DEFAULT NULL,
  `ven_guias` tinyint(1) DEFAULT NULL,
  `ven_gui_consulta` tinyint(1) DEFAULT NULL,
  `cuentas` tinyint(1) DEFAULT NULL,
  `cta_cobrar` tinyint(1) DEFAULT NULL,
  `cta_letra_cob` tinyint(1) DEFAULT NULL,
  `cta_credito_cob` tinyint(1) DEFAULT NULL,
  `cta_consulta_cob` tinyint(1) DEFAULT NULL,
  `cta_pagar` tinyint(1) DEFAULT NULL,
  `cta_letra_pag` tinyint(1) DEFAULT NULL,
  `cta_credito_pag` tinyint(1) DEFAULT NULL,
  `cta_consulta_pag` tinyint(1) DEFAULT NULL,
  `cta_caja` tinyint(1) DEFAULT NULL,
  `cta_caja_consulta` tinyint(1) DEFAULT NULL,
  `cta_caja_mov` tinyint(1) DEFAULT NULL,
  `administracion` tinyint(1) DEFAULT NULL,
  `adm_productos` tinyint(1) DEFAULT NULL,
  `adm_compras` tinyint(1) DEFAULT NULL,
  `adm_ventas` tinyint(1) DEFAULT NULL,
  `adm_cuentas` tinyint(1) DEFAULT NULL,
  `adm_utilidades` tinyint(1) DEFAULT NULL,
  `adm_personal` tinyint(1) DEFAULT NULL,
  `configuracion` tinyint(1) DEFAULT NULL,
  `con_usuarios` tinyint(1) DEFAULT NULL,
  `con_empresa` tinyint(1) DEFAULT NULL,
  `con_subir_datos` tinyint(1) DEFAULT NULL,
  `con_conexion` tinyint(1) DEFAULT NULL,
  `con_parametros` tinyint(1) DEFAULT NULL,
  `con_mantenimiento` tinyint(1) DEFAULT NULL,
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('ADMIN','2531',1,'','ADMINISTRADOR',1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),('conde','secret',1,'','ADMINISTRADOR',1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),('abel','secret',1,'','ADMINISTRADOR',1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `idventa` char(15) NOT NULL DEFAULT '',
  `idlocal` int(3) NOT NULL,
  `tipodoc` char(4) NOT NULL,
  `documento` char(20) NOT NULL,
  `idcliente` char(15) DEFAULT NULL,
  `ruc` char(20) DEFAULT NULL,
  `cliente` varchar(80) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `idpersonal` varchar(10) DEFAULT NULL,
  `idcajero` varchar(10) DEFAULT NULL,
  `usuario` varchar(20) NOT NULL,
  `lista_prec` int(2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` char(12) NOT NULL,
  `moneda` char(6) NOT NULL,
  `cambio` decimal(8,3) NOT NULL,
  `condicion` varchar(60) NOT NULL,
  `fecha_vto` date NOT NULL,
  `proforma` varchar(20) NOT NULL,
  `guia` varchar(20) NOT NULL,
  `inc_igv` tinyint(4) NOT NULL,
  `bruto` decimal(15,4) NOT NULL,
  `descuento` decimal(15,4) NOT NULL,
  `subtotal` decimal(15,4) NOT NULL,
  `igv` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `percepcion` decimal(15,4) NOT NULL,
  `detraccion` decimal(15,4) NOT NULL,
  `total_pagar` decimal(15,4) NOT NULL,
  `efectivo` decimal(15,4) NOT NULL,
  `inicial` decimal(15,4) NOT NULL,
  `saldo` decimal(15,4) NOT NULL,
  `forma_pago` varchar(40) DEFAULT NULL,
  `ref_pago` varchar(30) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `observacion` varchar(150) DEFAULT NULL,
  `idkardex` varchar(20) DEFAULT NULL,
  `idcobro` varchar(20) DEFAULT NULL,
  `idcaja` varchar(20) DEFAULT NULL,
  `act_stock` tinyint(1) DEFAULT NULL,
  `notac_ref` varchar(20) DEFAULT NULL,
  `notac_idven` varchar(15) DEFAULT NULL,
  `idcobromov` varchar(15) DEFAULT NULL,
  `idventanc` varchar(50) DEFAULT NULL,
  `idventanv` varchar(30) DEFAULT NULL,
  `notaventa` varchar(15) DEFAULT NULL,
  `idproforma` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idventa`),
  KEY `documento` (`documento`),
  KEY `idcliente` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-17 16:04:04
