-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2023 a las 04:08:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdsubliprintleo`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateProductInventory` (IN `idProduct` VARCHAR(8), IN `idInventory` INT, IN `priceInit` FLOAT, IN `amountInit` INT)   BEGIN
    DECLARE subtotal FLOAT;
    
    -- Calcular el subtotal
    SET subtotal = priceInit * amountInit;
    
    -- Insertar el producto en la tabla productinventory
    INSERT INTO productinventory (idProduct, idInventory, amountInit, priceInit, subtotal)
    VALUES (idProduct, idInventory, amountInit, priceInit, subtotal);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteInventoryChecking` (IN `idInventoryParam` INT)   BEGIN
	DELETE FROM inventory
    WHERE idInventory = idInventoryParam
    AND NOT EXISTS (SELECT 1 FROM productinventory WHERE idInventory = inventory.idInventory);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteProduct` (IN `idProduct` VARCHAR(8))   BEGIN
	DELETE p FROM product p
    INNER JOIN productinventory pi ON pi.idProduct=p.idProduct
    WHERE pi.amountInit=0 AND p.idProduct = idProduct;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBuyDetails` (IN `userId` VARCHAR(50))   BEGIN
    SELECT 
      bu.idBuyUser,
      bu.stateBuy,
      bu.dateBuy,
     orb.dateOrder,
     ord.idProduct,
     p.nameProduct,
     p.description,
     p.imgProduct,
    ord.priceProduct,
    ord.amountProduct,
    orb.total 
   FROM orderdetail ord 
  INNER JOIN orderbuy orb
  ON ord.idOrderBuy = orb.idOrderBuy 
  INNER JOIN product p
  ON ord.idProduct = p.idProduct
  INNER JOIN buyuser bu
  ON bu.idOrder = orb.idOrderBuy 
  WHERE bu.idBuyUser = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductByIdProduct` (IN `idProduct` VARCHAR(8))   BEGIN
	SELECT 
    	p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        pi.amountInit,
        p.idCategory,
        c.nameCategory,
	i.idInventory, p.expire_product
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory i ON i.idInventory = pi.idInventory
    WHERE p.idProduct = idProduct;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsByInventory` (IN `InventoryId` INT)   BEGIN
  SELECT 
        p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        c.nameCategory,
        pi.amountInit
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory ip ON ip.idInventory = pi.idInventory
    WHERE ip.idInventory =  InventoryId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsByInventoryAndCategory` (IN `idInventory` INT, IN `idCategory` INT)   BEGIN
	SELECT 
        p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        c.nameCategory,
        pi.amountInit
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory ip ON ip.idInventory = pi.idInventory
    WHERE ip.idInventory =  idInventory AND p.idCategory = idCategory;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsByInventoryPagination` (IN `idInventory` INT, IN `pageInit` INT, IN `pageEnd` INT)   BEGIN
	SELECT 
        p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        c.nameCategory,
        pi.amountInit
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory ip ON ip.idInventory = pi.idInventory
    WHERE ip.idInventory =  idInventory ORDER BY p.idProduct ASC LIMIT pageInit, pageEnd;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertOrderProducts` (IN `id_user` INT, IN `p_monto_total` FLOAT, IN `p_productos` JSON, IN `date_create_order` DATETIME)   BEGIN
    -- TODO:Los campos que seran nulos se insertan con el valor por defecto
    DECLARE v_id_orderproducts VARCHAR(10);

    -- Insertar en la tabla orderproducts
    INSERT INTO orderbuy (idOrderBuy, dateOrder, stateOrder, total)
    VALUES ( UUID() ,date_create_order, "Pendiente", p_monto_total);
    -- Obtener el ID del pedido recién insertado de la tabla orderproducts
    
   SET @v_idOrderBuy = (SELECT idOrderBuy FROM orderbuy WHERE idLastOrderBuy = (SELECT o.idLastOrderBuy FROM orderbuy o ORDER BY o.idLastOrderBuy DESC LIMIT 1));
    
    FOR i IN 0..JSON_LENGTH(p_productos) - 1 DO
        SET @idProduct = JSON_UNQUOTE(JSON_EXTRACT(p_productos, CONCAT('$[', i, '].idProduct')));
        SET @amountProduct = JSON_EXTRACT(p_productos, CONCAT('$[', i, '].amount'));
        SET @priceProduct = JSON_EXTRACT(p_productos, CONCAT('$[', i, '].price'));
        --  Insertar en la tabla orderdetail donde se almacenan los productos del pedido
-- Actualizar la forma de agregar productos
        INSERT INTO orderdetail (idOrderBuy,idProduct,priceProduct,amountProduct)
        VALUES (@v_idOrderBuy, @idProduct,@priceProduct, @amountProduct);
    END FOR;

    -- Insertar en la tabla userbuys
    INSERT INTO buyuser (idBuyUser, idOrder,idUser, stateBuy)
    VALUES (UUID(), @v_idOrderBuy, id_user, 'No Pagado');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchProduct` (IN `idInventory` INT, IN `search` TEXT)   BEGIN
	SELECT 
        p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        c.nameCategory,
        pi.amountInit
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory ip ON ip.idInventory = pi.idInventory
    WHERE ip.idInventory =  idInventory AND (
        p.nameProduct LIKE CONCAT('%', search, '%')
        OR p.idProduct LIKE CONCAT('%', search, '%')
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProductInventory` (IN `idProduct` VARCHAR(8), IN `priceInit` FLOAT, IN `amountInit` INT)   BEGIN
	UPDATE productinventory p SET 
    p.priceInit = priceInit, p.amountInit = amountInit WHERE p.idProduct = idProduct;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buyuser`
--

CREATE TABLE `buyuser` (
  `lastId` int(11) NOT NULL,
  `idBuyUser` varchar(10) NOT NULL,
  `idOrder` varchar(10) NOT NULL,
  `idUser` int(11) NOT NULL,
  `stateBuy` varchar(20) NOT NULL,
  `dateBuy` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `buyuser`
--

INSERT INTO `buyuser` (`lastId`, `idBuyUser`, `idOrder`, `idUser`, `stateBuy`, `dateBuy`) VALUES
(1, '643b8593-8', 'f6391150-8', 2, 'Pagado', '2023-11-18 22:58:31'),
(2, '9d7f4254-8', 'f6391150-8', 2, 'Pagado', '2023-11-20 08:39:39'),
(6, 'd04d3fcf-8', 'd04cc1e2-8', 2, 'Pagado', '2023-11-20 08:53:12'),
(7, '1956b04f-8', '195474a4-8', 2, 'Pagado', '2023-11-20 22:27:30'),
(9, 'd3668bed-8', 'd36635a3-8', 2, 'Pagado', '2023-11-20 08:57:03'),
(11, 'aee5ef45-8', 'aee5ac55-8', 2, 'Pagado', '2023-11-20 22:26:22'),
(12, '07c04141-8', '07bfd0d2-8', 2, 'Pagado', '2023-11-20 22:25:08'),
(13, '8f4be7ad-8', '8f4bb061-8', 2, 'Pagado', '2023-11-20 08:40:54'),
(14, 'a59181ca-8', 'a590ea4f-8', 2, 'Pagado', '2023-11-20 22:23:20'),
(15, '7c17b92d-8', '7c176434-8', 2, 'Pagado', '2023-11-20 22:22:13'),
(16, 'b2c364d8-8', 'b2c3122e-8', 2, 'Pagado', '2023-11-20 22:20:03'),
(17, 'e2dbf2e2-8', 'e2db82f1-8', 2, 'Pagado', '2023-11-20 09:13:20'),
(18, 'e2b30962-8', 'e2b22c2f-8', 2, 'Pagado', '2023-11-20 22:18:15'),
(20, '21c11a52-8', '21c0c56d-8', 2, 'Pagado', '2023-11-20 22:39:24'),
(24, '579827b3-8', '57973aea-8', 2, 'Pagado', '2023-11-21 12:19:21'),
(25, '04a93688-8', '04a76aa1-8', 2, 'Pagado', '2023-12-02 19:47:45'),
(26, 'e74dbb91-8', 'e746c85f-8', 5, 'Pagado', '2023-11-22 18:23:22'),
(27, '3cb1df53-8', '3cb0f041-8', 5, 'No Pagado', '0000-00-00 00:00:00'),
(28, 'd0be018a-8', 'd0bd8526-8', 6, 'Pagado', '2023-11-26 18:10:50'),
(29, 'f5d1a6a7-8', 'f5d15a68-8', 6, 'Pagado', '2023-11-26 16:17:16'),
(30, '04bdaf24-8', '04bc45b0-8', 6, 'Pagado', '2023-11-26 18:18:51'),
(31, '4cd3c715-8', '4cd30634-8', 6, 'Pagado', '2023-11-26 18:20:03'),
(32, '64a3328b-8', '64a29d31-8', 6, 'Pagado', '2023-11-26 18:20:42'),
(33, '39de1008-8', '39dd8a70-8', 6, 'Pagado', '2023-11-26 18:27:48'),
(35, '6f3be136-8', '6f3b059c-8', 6, 'Pagado', '2023-11-26 18:36:30'),
(36, '4e5a33fd-8', '4e5978f8-8', 6, 'Pagado', '2023-11-26 18:50:24'),
(37, '5a4fdee8-8', '5a4f2547-8', 6, 'Pagado', '2023-11-26 18:42:01'),
(40, '9486fd6f-9', '94863444-9', 2, 'Pagado', '2023-12-02 12:25:02'),
(41, '03864a99-9', '0385877c-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(42, '11332e6f-9', '1132bc6b-9', 2, 'Pagado', '2023-12-02 00:00:00'),
(43, '66c6e049-9', '66c5c65f-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(44, '8c0b5c12-9', '8c0acf3f-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(45, '003789ad-9', '0036378e-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(46, '1790bc02-9', '1790308f-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(47, '1857fc72-9', '18575cc1-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(48, '1b64eb97-9', '1b646904-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(49, '24a0ac79-9', '249f65ed-9', 2, 'No Pagado', '0000-00-00 00:00:00'),
(71, 'ad6e073f-9', 'ad6cfa96-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(74, 'd906f690-9', 'd906ac69-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(75, 'd9d6ed10-9', 'd9d64fe7-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(76, 'fca7bc8f-9', 'fca76d5f-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(77, '0605b27b-9', '06057310-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(78, '0687bb56-9', '06873fe2-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(79, '2c9cdd7f-9', '2c9c76f3-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(84, '3cbb4402-9', '3cbaee1d-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(85, '8b859645-9', '8b853559-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(86, 'a4b611e1-9', 'a4b5d575-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(87, 'ab38da30-9', 'ab385a90-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(88, 'ab8a1b94-9', 'ab89964d-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(89, 'abe19318-9', 'abe155b7-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(93, '7af33bed-9', '7af2f25d-9', 6, 'No Pagado', '0000-00-00 00:00:00'),
(94, 'd10f98c0-9', 'd10eef98-9', 13, 'No Pagado', '0000-00-00 00:00:00'),
(95, 'fa79f729-9', 'fa795ebb-9', 13, 'No Pagado', '0000-00-00 00:00:00'),
(96, '03eed612-9', '03edba76-9', 13, 'No Pagado', '0000-00-00 00:00:00'),
(97, '6776243a-9', '67751e86-9', 13, 'Pagado', '2023-12-03 03:11:16'),
(98, '5ba7c456-9', '5ba77e03-9', 13, 'No Pagado', '0000-00-00 00:00:00'),
(140, '710d012a-8', '710ca167-8', 6, 'No Pagado', '0000-00-00 00:00:00'),
(141, '6a3168c7-8', '6a31081e-8', 6, 'Pagado', '2023-11-29 00:39:09'),
(142, '6b76f466-8', '6b764068-8', 6, 'No Pagado', '0000-00-00 00:00:00'),
(143, '4d2ece28-8', '4d2e8c7e-8', 17, 'No Pagado', '0000-00-00 00:00:00'),
(144, '8cef7042-8', '8ceebd9f-8', 20, 'No Pagado', '0000-00-00 00:00:00'),
(145, 'cf696f6a-8', 'cf68315a-8', 17, 'Pagado', '2023-11-28 13:56:45'),
(146, '25838265-8', '25834776-8', 17, 'No Pagado', '0000-00-00 00:00:00'),
(147, '6a5e618f-8', '6a5e0557-8', 17, 'Pagado', '2023-11-28 14:25:37'),
(148, '8ef9474b-8', '8ef8e126-8', 6, 'No Pagado', '0000-00-00 00:00:00'),
(149, 'a7731ea8-8', 'a772eac5-8', 6, 'Pagado', '2023-11-29 00:27:48'),
(150, '2261350b-8', '2260c025-8', 24, 'Pagado', '2023-11-29 00:50:45'),
(151, '6a3f0688-8', '6a3e7840-8', 24, 'Pagado', '2023-11-29 01:01:02'),
(152, 'd4003b68-8', 'd4000abf-8', 6, 'No Pagado', '0000-00-00 00:00:00'),
(153, 'c65ec479-8', 'c65e55ea-8', 24, 'No Pagado', '0000-00-00 00:00:00'),
(154, 'e120e331-8', 'e120c748-8', 24, 'No Pagado', '0000-00-00 00:00:00'),
(155, 'e94fcdaa-8', 'e94fa36c-8', 24, 'No Pagado', '0000-00-00 00:00:00'),
(156, '10f04408-8', '10efc98f-8', 25, 'No Pagado', '0000-00-00 00:00:00'),
(157, 'bc8f4497-8', 'bc8ee643-8', 22, 'Pagado', '2023-11-29 16:41:38'),
(158, 'd2f67feb', '23a74388', 19, 'No Pagado', '0000-00-00 00:00:00'),
(159, '388dae58', '4e75cc23', 19, 'Pagado', '2023-11-30 01:21:38'),
(160, '58c6f81d', 'aedfb29f', 19, 'No Pagado', '0000-00-00 00:00:00'),
(161, '91006ba0', 'b37d81d4', 2, 'No Pagado', '0000-00-00 00:00:00'),
(162, '9dfca8ff-9', '9dfbce5f-9', 19, 'No Pagado', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `nameCategory` varchar(255) NOT NULL,
  `statusCategory` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`idCategory`, `nameCategory`, `statusCategory`) VALUES
(1, 'Tazas personalizadas', 'activo'),
(2, 'Polos personalizados', 'activo'),
(3, 'Agendas personalizadas', 'activo'),
(4, 'Gorras personalizadas', 'activo'),
(5, 'Case de celulares personalizadas', 'activo'),
(6, 'Truzas personalizadas', 'activo'),
(7, 'Llaveros personalizados', 'activo'),
(8, 'Vasos personalizados', 'activo'),
(9, 'Stickers personalizados', 'activo'),
(10, 'Cuadros personalizados', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infopage`
--

CREATE TABLE `infopage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ruc` varchar(11) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `dollarValue` float NOT NULL,
  `workingHours` varchar(255) NOT NULL,
  `holidayHours` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `infopage`
--

INSERT INTO `infopage` (`id`, `name`, `ruc`, `address`, `phone`, `email`, `dollarValue`, `workingHours`, `holidayHours`) VALUES
(1, 'Subliprint Leo', '20223968971', 'Av. Sanchez Cerro 929-633', '981518655', 'ventas@ferreteriacotlear.com', 3.45, '8:00 a.m. a 6:00 p.m.', '8:00 a.m. a 2:00 p.m.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

CREATE TABLE `inventory` (
  `idInventory` int(11) NOT NULL,
  `note` text NOT NULL,
  `dateInventory` date NOT NULL,
  `idProvider` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventory`
--

INSERT INTO `inventory` (`idInventory`, `note`, `dateInventory`, `idProvider`) VALUES
(1, 'Nota 1', '2023-10-23', 45),
(8, 'Nota 2', '2023-10-30', 46),
(19, 'Nota 4', '2023-11-29', 51),
(20, 'Nota 5', '2023-11-29', 50),
(21, 'Nota 6', '2023-11-29', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orderbuy`
--

CREATE TABLE `orderbuy` (
  `idLastOrderBuy` int(11) NOT NULL,
  `idOrderBuy` varchar(10) NOT NULL,
  `dateOrder` datetime NOT NULL,
  `dateDelivery` datetime DEFAULT NULL,
  `dateConfirm` datetime DEFAULT NULL,
  `stateOrder` varchar(20) NOT NULL,
  `total` float NOT NULL,
  `idPaymentMethod` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orderbuy`
--

INSERT INTO `orderbuy` (`idLastOrderBuy`, `idOrderBuy`, `dateOrder`, `dateDelivery`, `dateConfirm`, `stateOrder`, `total`, `idPaymentMethod`) VALUES
(1, '1ffb5349-8', '2023-11-18 22:45:47', NULL, NULL, 'Pendiente', 310, 3),
(2, '2fd0be27-8', '2023-11-18 22:39:04', NULL, NULL, 'Pendiente', 310, 3),
(3, '46078202-8', '2023-11-18 22:46:51', NULL, NULL, 'Pendiente', 310, 3),
(4, '643ad338-8', '2023-11-18 22:54:51', NULL, NULL, 'Pendiente', 310, 3),
(5, '6f63dc7c-8', '2023-11-18 22:12:13', NULL, NULL, 'Pendiente', 310, 3),
(6, '765b70cb-8', '2023-11-18 22:12:24', NULL, NULL, 'Pendiente', 310, 3),
(7, '7bc39042-8', '2023-11-18 22:34:02', NULL, NULL, 'Pendiente', 310, 3),
(8, '98866dfa-8', '2023-11-18 22:20:31', NULL, NULL, 'Pendiente', 310, 3),
(9, '9d7e9d66-8', '2023-11-18 22:56:27', NULL, NULL, 'Pendiente', 310, NULL),
(10, 'a0902545-8', '2023-11-18 22:13:35', NULL, NULL, 'Pendiente', 310, 3),
(11, 'da9b004f-8', '2023-11-18 22:36:41', NULL, NULL, 'Pendiente', 310, 3),
(12, 'de46a662-8', '2023-11-18 23:19:44', NULL, NULL, 'Pendiente', 100, 3),
(13, 'f6391150-8', '2023-11-18 22:37:27', '2023-11-27 15:00:50', NULL, 'Enviado', 310.5, 3),
(14, '212c72f8-8', '2023-11-18 23:28:46', NULL, NULL, 'Pendiente', 100, 3),
(15, '35f776e5-8', '2023-11-18 23:29:21', NULL, NULL, 'Pendiente', 100, 3),
(16, '96ea8509-8', '2023-11-18 23:46:23', NULL, NULL, 'Pendiente', 100, 3),
(17, '9ba313d6-8', '2023-11-18 23:46:30', NULL, NULL, 'Pendiente', 100, 3),
(18, '05d91683-8', '2023-11-18 23:49:29', NULL, NULL, 'Pendiente', 310, 1),
(19, '400cf9e3-8', '2023-11-18 23:51:06', NULL, NULL, 'Pendiente', 310, 1),
(20, '1388eba0-8', '2023-11-19 00:04:11', NULL, NULL, 'Pendiente', 310, 1),
(21, '526bb1e9-8', '2023-11-19 00:05:56', NULL, NULL, 'Pendiente', 310, 1),
(22, 'a01607f8-8', '2023-11-19 00:08:06', NULL, NULL, 'Pendiente', 310, 1),
(23, 'd04cc1e2-8', '2023-11-19 00:09:27', '2023-11-26 19:19:24', NULL, 'Aceptado', 300, 1),
(24, '195474a4-8', '2023-11-19 22:58:44', '2023-11-26 19:19:29', NULL, 'Aceptado', 74, 1),
(26, 'd36635a3-8', '2023-11-19 23:03:56', '2023-11-27 14:50:18', NULL, 'Enviado', 148, 1),
(28, 'aee5ac55-8', '2023-11-19 23:31:33', '2023-11-21 12:12:21', NULL, 'Aceptado', 46, NULL),
(29, '07bfd0d2-8', '2023-11-19 23:34:02', '2023-11-27 20:15:30', NULL, 'Aceptado', 310, NULL),
(30, '8f4bb061-8', '2023-11-19 23:37:49', '2023-11-21 12:17:55', NULL, 'Aceptado', 49.4, NULL),
(31, 'a590ea4f-8', '2023-11-20 08:56:47', '2023-11-21 12:13:23', NULL, 'Aceptado', 173, NULL),
(32, '7c176434-8', '2023-11-20 09:02:47', '2023-11-27 22:11:06', NULL, 'Enviado', 88, NULL),
(33, 'b2c3122e-8', '2023-11-20 09:11:28', '2023-11-21 12:17:50', NULL, 'Aceptado', 44, NULL),
(34, 'e2db82f1-8', '2023-11-20 09:12:49', '2023-11-21 12:18:08', NULL, 'Aceptado', 67, NULL),
(35, 'e2b22c2f-8', '2023-11-20 21:44:26', NULL, NULL, 'Aceptado', 111, NULL),
(37, '21c0c56d-8', '2023-11-20 22:29:09', '2023-11-21 12:13:19', NULL, 'Aceptado', 44, NULL),
(41, '57973aea-8', '2023-11-21 10:47:57', '2023-11-27 12:49:55', NULL, 'Aceptado', 517, NULL),
(42, '04a76aa1-8', '2023-11-21 12:18:41', NULL, NULL, 'Pendiente', 233, NULL),
(43, 'e746c85f-8', '2023-11-22 18:21:45', '2023-11-27 22:30:27', NULL, 'Enviado', 247.5, NULL),
(44, '3cb0f041-8', '2023-11-22 18:24:09', NULL, NULL, 'Pendiente', 170.5, NULL),
(45, 'a0bcedce-8', '2023-11-26 16:13:21', NULL, NULL, 'Pendiente', 0, NULL),
(46, 'c1b91087-8', '2023-11-26 16:14:16', NULL, NULL, 'Pendiente', 0, NULL),
(47, 'c1fe8907-8', '2023-11-26 16:14:17', NULL, NULL, 'Pendiente', 0, NULL),
(48, 'd0bd8526-8', '2023-11-26 16:14:41', '2023-11-27 14:51:04', NULL, 'Enviado', 168, NULL),
(49, 'f5d15a68-8', '2023-11-26 16:15:44', '2023-11-27 12:51:00', NULL, 'Aceptado', 168, NULL),
(50, '04bc45b0-8', '2023-11-26 16:16:09', '2023-11-27 14:30:04', NULL, 'Aceptado', 168, NULL),
(51, '4cd30634-8', '2023-11-26 18:19:51', '2023-11-27 14:31:18', NULL, 'Enviado', 32.5, NULL),
(52, '64a29d31-8', '2023-11-26 18:20:31', NULL, NULL, 'Pendiente', 32.5, NULL),
(53, '39dd8a70-8', '2023-11-26 18:26:29', NULL, NULL, 'Pendiente', 65, NULL),
(55, '6f3b059c-8', '2023-11-26 18:35:08', NULL, NULL, 'Pendiente', 130, NULL),
(56, '4e5978f8-8', '2023-11-26 18:41:22', NULL, NULL, 'Pendiente', 130, NULL),
(57, '5a4f2547-8', '2023-11-26 18:41:42', NULL, NULL, 'Pendiente', 195, NULL),
(60, '94863444-9', '2023-12-02 12:23:54', NULL, NULL, 'Pendiente', 205, 1),
(61, '0385877c-9', '2023-12-02 19:43:38', NULL, NULL, 'Pendiente', 195, 1),
(62, '1132bc6b-9', '2023-12-02 19:44:01', NULL, NULL, 'Pendiente', 195, 1),
(63, '66c5c65f-9', '2023-12-02 23:21:10', NULL, NULL, 'Pendiente', 205, 1),
(64, '8c0acf3f-9', '2023-12-02 23:22:12', NULL, NULL, 'Pendiente', 205, 1),
(65, '0036378e-9', '2023-12-02 23:25:27', NULL, NULL, 'Pendiente', 205, 1),
(66, '1790308f-9', '2023-12-02 23:26:06', NULL, NULL, 'Pendiente', 205, 1),
(67, '18575cc1-9', '2023-12-02 23:26:07', NULL, NULL, 'Pendiente', 205, 1),
(68, '1b646904-9', '2023-12-02 23:26:13', NULL, NULL, 'Pendiente', 205, 1),
(69, '249f65ed-9', '2023-12-02 23:26:28', NULL, NULL, 'Pendiente', 80, 1),
(91, 'ad6cfa96-9', '2023-12-03 01:03:21', NULL, NULL, 'Pendiente', 44, 1),
(94, 'd906ac69-9', '2023-12-03 01:04:34', NULL, NULL, 'Pendiente', 44, 1),
(95, 'd9d64fe7-9', '2023-12-03 01:04:36', NULL, NULL, 'Pendiente', 44, 1),
(96, 'fca76d5f-9', '2023-12-03 01:05:34', NULL, NULL, 'Pendiente', 24.7, 1),
(97, '06057310-9', '2023-12-03 01:05:50', NULL, NULL, 'Pendiente', 24.7, 1),
(98, '06873fe2-9', '2023-12-03 01:05:51', NULL, NULL, 'Pendiente', 24.7, 1),
(99, '2c9c76f3-9', '2023-12-03 01:06:54', NULL, NULL, 'Pendiente', 24.7, 1),
(104, '3cbaee1d-9', '2023-12-03 01:07:21', NULL, NULL, 'Pendiente', 24.7, 1),
(105, '8b853559-9', '2023-12-03 01:09:34', NULL, NULL, 'Pendiente', 24.7, 1),
(106, 'a4b5d575-9', '2023-12-03 01:10:16', NULL, NULL, 'Pendiente', 24.7, 1),
(107, 'ab385a90-9', '2023-12-03 01:10:27', NULL, NULL, 'Pendiente', 24.7, 1),
(108, 'ab89964d-9', '2023-12-03 01:10:27', NULL, NULL, 'Pendiente', 24.7, 1),
(109, 'abe155b7-9', '2023-12-03 01:10:28', NULL, NULL, 'Pendiente', 24.7, 1),
(113, '7af2f25d-9', '2023-12-03 01:16:15', NULL, NULL, 'Pendiente', 60, 1),
(114, 'd10eef98-9', '2023-12-03 03:06:02', NULL, NULL, 'Pendiente', 44, 1),
(115, 'fa795ebb-9', '2023-12-03 03:07:12', NULL, NULL, 'Pendiente', 44, 1),
(116, '03edba76-9', '2023-12-03 03:07:28', NULL, NULL, 'Pendiente', 44, 1),
(117, '67751e86-9', '2023-12-03 03:10:15', '2023-12-03 03:16:09', '2023-12-03 03:12:20', 'Enviado', 80, 1),
(118, '5ba77e03-9', '2023-12-03 11:16:39', NULL, NULL, 'Pendiente', 205, 1),
(242, '710ca167-8', '2023-11-26 23:42:59', NULL, NULL, 'Pendiente', 210, 1),
(243, '6a31081e-8', '2023-11-27 01:44:29', NULL, NULL, 'Pendiente', 27, 1),
(244, '6b764068-8', '2023-11-28 04:41:39', NULL, NULL, 'Pendiente', 140, 1),
(245, '4d2e8c7e-8', '2023-11-28 12:33:15', NULL, NULL, 'Pendiente', 38.5, 1),
(246, '8ceebd9f-8', '2023-11-28 13:25:08', NULL, NULL, 'Pendiente', 74, 1),
(247, 'cf68315a-8', '2023-11-28 13:55:38', '2023-11-29 18:20:20', NULL, 'Enviado', 399.98, 1),
(248, '25834776-8', '2023-11-28 13:58:02', NULL, NULL, 'Pendiente', 399.98, 1),
(249, '6a5e0557-8', '2023-11-28 14:21:26', '2023-11-29 15:27:46', NULL, 'Aceptado', 78.9, 1),
(250, '8ef8e126-8', '2023-11-28 23:55:07', NULL, NULL, 'Pendiente', 161.9, 1),
(251, 'a772eac5-8', '2023-11-29 00:24:26', '2023-11-29 00:31:16', NULL, 'Aceptado', 39, 1),
(252, '2260c025-8', '2023-11-29 00:49:21', '2023-11-29 00:56:30', NULL, 'Enviado', 298, 1),
(253, '6a3e7840-8', '2023-11-29 00:58:31', '2023-11-29 15:26:09', NULL, 'Aceptado', 298, 1),
(254, 'd4000abf-8', '2023-11-29 01:01:29', NULL, NULL, 'Pendiente', 3432, 1),
(255, 'c65e55ea-8', '2023-11-29 01:22:34', NULL, NULL, 'Pendiente', 5279.12, 1),
(256, 'e120c748-8', '2023-11-29 01:23:19', NULL, NULL, 'Pendiente', 5279.12, 1),
(257, 'e94fa36c-8', '2023-11-29 01:23:33', NULL, NULL, 'Pendiente', 4799.2, 1),
(258, '10efc98f-8', '2023-11-29 03:19:11', NULL, NULL, 'Pendiente', 132, 1),
(259, 'bc8ee643-8', '2023-11-29 16:38:33', NULL, NULL, 'Pendiente', 46, 1),
(260, '781c8828', '2023-11-30 00:38:45', NULL, NULL, 'Pendiente', 49, 1),
(261, '19826b92', '2023-11-30 00:38:50', NULL, NULL, 'Pendiente', 49, 1),
(262, '01df84f0', '2023-11-30 00:40:52', NULL, NULL, 'Pendiente', 49, 1),
(263, 'aa140e1d', '2023-11-30 00:40:53', NULL, NULL, 'Pendiente', 49, 1),
(264, '3a8ced50', '2023-11-30 00:41:00', NULL, NULL, 'Pendiente', 49, 1),
(265, 'f045e52e', '2023-11-30 00:42:57', NULL, NULL, 'Pendiente', 49, 1),
(266, 'f8caf583', '2023-11-30 00:43:18', NULL, NULL, 'Pendiente', 29.9, 1),
(267, 'f8b1bd3e', '2023-11-30 00:43:25', NULL, NULL, 'Pendiente', 49, 1),
(268, '50640428', '2023-11-30 00:43:57', NULL, NULL, 'Pendiente', 49, 1),
(269, '6e90bc3e', '2023-11-30 00:43:58', NULL, NULL, 'Pendiente', 49, 1),
(270, '9fb47d70', '2023-11-30 00:43:59', NULL, NULL, 'Pendiente', 49, 1),
(271, 'a81e25a5', '2023-11-30 00:44:01', NULL, NULL, 'Pendiente', 49, 1),
(272, 'bef5344c', '2023-11-30 00:44:02', NULL, NULL, 'Pendiente', 49, 1),
(273, '1612684c', '2023-11-30 00:45:44', NULL, NULL, 'Pendiente', 49, 1),
(274, 'd6d7ac8d', '2023-11-30 00:45:49', NULL, NULL, 'Pendiente', 49, 1),
(275, '23a74388', '2023-11-30 00:55:13', NULL, NULL, 'Pendiente', 129, 1),
(276, '4e75cc23', '2023-11-30 01:19:50', '2023-11-30 01:25:53', NULL, 'Enviado', 258, 1),
(277, 'aedfb29f', '2023-11-30 01:25:04', NULL, NULL, 'Pendiente', 44, 1),
(278, 'b37d81d4', '2023-12-02 17:27:15', NULL, NULL, 'Pendiente', 229, 1),
(279, '9dfbce5f-9', '2023-12-08 21:56:37', NULL, NULL, 'Pendiente', 45, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orderdetail`
--

CREATE TABLE `orderdetail` (
  `idOrderDetail` int(11) NOT NULL,
  `idOrderBuy` varchar(10) NOT NULL,
  `idProduct` varchar(8) NOT NULL,
  `priceProduct` float NOT NULL,
  `amountProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orderdetail`
--

INSERT INTO `orderdetail` (`idOrderDetail`, `idOrderBuy`, `idProduct`, `priceProduct`, `amountProduct`) VALUES
(40, 'e2b22c2f-8', '017EDD5C', 27, 3),
(52, '57973aea-8', '39153B41', 70, 2),
(54, '04a76aa1-8', '05A0B0DC', 206, 1),
(55, '04a76aa1-8', '017EDD5C', 27, 1),
(76, '0385877c-9', '3FAB0141', 65, 3),
(77, '1132bc6b-9', '3FAB0141', 65, 3),
(134, '710ca167-8', '39153B41', 70, 3),
(135, '6a31081e-8', '017EDD5C', 27, 1),
(136, '6b764068-8', '39153B41', 70, 2),
(150, 'a772eac5-8', '3DFAB170', 39, 1),
(157, 'd4000abf-8', '3DFAB170', 39, 88),
(185, '9dfbce5f-9', '5FCDB6B9', 45, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `idPaymentMethod` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paymentmethod`
--

INSERT INTO `paymentmethod` (`idPaymentMethod`, `name`, `description`, `state`) VALUES
(1, 'Paypal', 'Método de pago en línea', 'Activo'),
(2, 'Tarjeta', 'Pago con tarjeta de crédito o débito', 'Activo'),
(3, 'Nulo', 'Nulo', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `idProduct` varchar(8) NOT NULL,
  `nameProduct` text NOT NULL,
  `brand` text NOT NULL,
  `description` text NOT NULL,
  `statusProduct` varchar(50) NOT NULL,
  `imgProduct` text NOT NULL,
  `price` float NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `expire_product` date DEFAULT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`idProduct`, `nameProduct`, `brand`, `description`, `statusProduct`, `imgProduct`, `price`, `unit`, `create_at`, `update_at`, `expire_product`, `idCategory`) VALUES
('017EDD5C', 'Planers', 'Subliprint Leo', 'Libreta personalizada A4 Buo Magico Etc', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086274/products-subliprint-leo/evndrcpb4hupsqh5psq6.png', 500, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:46:50', '0001-01-01', 3),
('05A0B0DC', 'Taza Profesiones', 'Subliprint Leo', 'Taza con estilo personalizado profesion', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086399/products-subliprint-leo/twhdtane5umg6oiwn2dr.png', 206, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:46:37', '0001-01-01', 1),
('074C200B', 'Cuadernos', 'Subliprint Leo', 'Cuadernos personalizados con frases, nombres, imagenes, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088262/products-subliprint-leo/qsra5s1awqb9hxfzykfo.png', 14, 'Ninguna', '2023-12-08 21:17:43', '2023-12-08 21:17:43', '0001-01-01', 2),
('0AA93A9E', 'Taza Cumpleaños', 'Subliprint Leo', 'Taza de cumpleaños personalizada con nombre o fotos', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086509/products-subliprint-leo/o2wdn7l0mjzdv8gsjkhg.png', 36.9, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:48:27', '0001-01-01', 1),
('0C07BABA', 'Vasos personalizados.', 'Subliprint Leo', 'Vasos personalizados con frases, memes, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702090511/products-subliprint-leo/izwxgr6xumcb45i1s4zu.png', 19.99, 'Ninguna', '2023-12-08 21:55:12', '2023-12-08 21:55:12', '0001-01-01', 1),
('1A0609DC', 'Vinil Sublime', 'Subliprint Leo', 'Vinil Sublime con imagenes personalizadas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089993/products-subliprint-leo/z9qpvedvi2nqqdx0tcwt.png', 42.5, 'Ninguna', '2023-12-08 21:46:34', '2023-12-08 21:46:34', '0001-01-01', 2),
('1CB527F9', 'Gorra B personalizada', 'Subliprint Leo', 'Gorras personalizadas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089564/products-subliprint-leo/yy7njl2wtbsvjigd6xys.png', 15, 'Ninguna', '2023-12-08 21:39:25', '2023-12-08 21:39:25', '0001-01-01', 4),
('2CA5C88B', 'Taza Personalizada para niños aña', 'Subliprint Leo', 'Taza para niños personalizadas, con diseños como Mario Bros', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086590/products-subliprint-leo/k1mldvxvpxllzaemdq9h.png', 30, 'Ninguna', '2023-11-29 09:09:08', '2023-12-08 20:49:48', '0001-10-01', 1),
('31EAF45F', 'Cuaderno personalizado Profesiones', 'Subliprint Leo', 'Cuaderno personalizado Profesiones.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088721/products-subliprint-leo/ulrtlpualqqdvamzvn8r.png', 15, 'Ninguna', '2023-12-08 21:25:22', '2023-12-08 21:25:22', '0001-01-01', 3),
('38332529', 'Case personalizada con imagenes', 'Subliprint Leo', 'Case personalizada con imagenes personalizadas.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089650/products-subliprint-leo/sxi1kbm9yrttnprv4jrb.png', 25, 'Ninguna', '2023-12-08 21:40:51', '2023-12-08 21:40:51', '0001-01-01', 5),
('39153B41', 'Taza Recuerdos', 'Subliprint Leo', 'Taza de recuerdos de 15 años', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086706/products-subliprint-leo/volkylgzy54g0nyafweq.png', 70, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:51:44', '0001-10-01', 1),
('3D67FB2E', 'Polo Cumpleaños', 'Subliprint Leo', 'Polos estampados para cumpleaños de Mario u otros personajes', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702087913/products-subliprint-leo/xm0qsd0srjj066eshvve.png', 30, 'Ninguna', '2023-12-08 21:11:54', '2023-12-08 21:11:54', '0001-01-01', 2),
('3D9ED6F7', 'Vinil PVC', 'Subliprint Leo', 'Vinil PVC', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702090045/products-subliprint-leo/w2ovw6ysbkmhzuzl4xwr.png', 27, 'Ninguna', '2023-12-08 21:47:26', '2023-12-08 21:47:26', '0001-01-01', 2),
('3DFAB170', 'Taza Graduación UCV XD', 'Subliprint Leo', 'Taza Graduación, Etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086828/products-subliprint-leo/zoggubhp2uc5nr17p0wu.png', 39, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:53:46', '0001-01-01', 1),
('3FAB0141', 'Taza pareja', 'Subliprint Leo', 'Taza para parejas.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702086883/products-subliprint-leo/gkqecofa5ukamuev2czf.png', 65, 'Ninguna', '2023-11-13 00:00:00', '2023-12-08 20:54:42', '0001-01-01', 1),
('4200F4C3', 'Cuaderno de negocios', 'Subliprint Leo', 'Cuaderno de negocios', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088876/products-subliprint-leo/taolkwjwtli7fcqk8gqh.png', 14.5, 'Ninguna', '2023-12-08 21:27:57', '2023-12-08 21:27:57', '0001-01-01', 3),
('5FCDB6B9', 'Copas GIN para hombres y mujeres.', 'Subliprint Leo', 'Copas GIN para hombres y mujeres personalizadas con imagenes.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702090175/products-subliprint-leo/ldpe8czhhs7envzpkqkj.png', 45, 'Ninguna', '2023-12-08 21:49:36', '2023-12-08 21:49:36', '0001-01-01', 1),
('6050FDAE', 'Polo Replica', 'Subliprint Leo', 'Polo Replica, Polos de replica de marcas internacionalmente conocidas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702087974/products-subliprint-leo/ljdmvl1fjomsyqzdhews.png', 39, 'Ninguna', '2023-12-08 21:12:55', '2023-12-08 21:12:55', '0001-01-01', 2),
('70A59EC9', 'Thermos', 'Subliprint Leo', 'Thermos personalizadas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089708/products-subliprint-leo/mhcvduzdi0hv4nmsd4np.png', 35.5, 'Ninguna', '2023-12-08 21:41:48', '2023-12-08 21:41:48', '0001-01-01', 1),
('888FD628', 'Polo pareja', 'Subliprint Leo', 'Polo para parejas personalizados', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088039/products-subliprint-leo/l8vs4vxyfews1p6xwall.png', 31, 'Ninguna', '2023-12-08 21:14:00', '2023-12-08 21:14:00', '0001-01-01', 2),
('8D6ADF20', 'Chops', 'Subliprint Leo', 'Chops personalizadas con memes, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089751/products-subliprint-leo/ew2ghqj4nk3bn5grldsd.png', 17, 'Ninguna', '2023-12-08 21:42:32', '2023-12-08 21:42:32', '0001-01-01', 1),
('960482FB', 'Taza Pareja Ositos', 'Subliprint Leo', 'Taza Pareja Ositos para parejas con imagen de oso u otros.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702087792/products-subliprint-leo/o8puydetu6vvaadicqup.png', 50, 'Ninguna', '2023-12-08 21:09:53', '2023-12-08 21:09:53', '0001-01-01', 1),
('9DA9FE3D', 'Libretas', 'Subliprint Leo', 'Libretas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089331/products-subliprint-leo/n6fyfjhswcczjq5cbu95.png', 10, 'Ninguna', '2023-12-08 21:35:32', '2023-12-08 21:35:32', '0001-11-11', 3),
('A441AB7E', 'LLaveros', 'Subliprint Leo', 'LLaveros personalizados para parejas, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702090290/products-subliprint-leo/cp1ha0qdmexn1h2c0gjv.png', 7.9, 'Ninguna', '2023-12-08 21:51:31', '2023-12-08 21:51:31', '0001-01-01', 7),
('A7491173', 'Cuadros de Spotify', 'Subliprint Leo', 'Cuadros de Spotify, YouTube, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089804/products-subliprint-leo/b4utxf1yeyf4zyyo8qwf.png', 30, 'Ninguna', '2023-12-08 21:43:25', '2023-12-08 21:43:25', '0001-01-01', 10),
('ABD8DF30', 'Polos para negocios', 'Subliprint Leo', 'Polos personalizados para negocios', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088080/products-subliprint-leo/a7uglmqlcxgpkaqiydl8.png', 50, 'Ninguna', '2023-12-08 21:14:41', '2023-12-08 21:14:41', '0001-01-01', 2),
('AEA9C1DB', 'Dedicatorias', 'Subliprint Leo', 'Libretas de Dedicatorias', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089445/products-subliprint-leo/svwv1ktkxk1ml7k70y0v.png', 17, 'Ninguna', '2023-12-08 21:37:26', '2023-12-08 21:37:26', '0001-01-01', 3),
('C37C35CC', 'Polos Vinial', 'Subliprint Leo', 'Polos Vinil', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088137/products-subliprint-leo/yzad5qinppu9manthqef.png', 44, 'Ninguna', '2023-12-08 21:15:38', '2023-12-08 21:15:38', '0001-01-01', 2),
('C7A5D44C', 'Taza Thermo', 'Subliprint Leo', 'Taza thermo personalizada, con frases imagenes, etc.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089883/products-subliprint-leo/y7zqqm4fzqghl6pc5q9l.png', 39.5, 'Ninguna', '2023-12-08 21:44:44', '2023-12-08 21:44:44', '0001-01-01', 1),
('E5D9BF76', 'Polo recuerdos', 'Subliprint Leo', 'Polo para recuerdos de familiares', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702088184/products-subliprint-leo/crz8kbuojzxvuqgxjkbn.png', 50, 'Ninguna', '2023-12-08 21:16:25', '2023-12-08 21:16:25', '0001-01-01', 2),
('E926CAFA', 'Prendas', 'Subliprint Leo', 'Prendas de vestir personalizadas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702090342/products-subliprint-leo/i7ueg2swjm1ealiu7gr1.png', 50.9, 'Ninguna', '2023-12-08 21:52:23', '2023-12-08 21:52:23', '0001-01-01', 6),
('F1314824', 'Libretas con imagenes personalizadas', 'Subliprint Leo', 'Libretas con imagenes personalizadas', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089488/products-subliprint-leo/mthpq4w7uwvthab0xe5e.jpg', 24, 'Ninguna', '2023-12-08 21:38:09', '2023-12-08 21:38:09', '0001-01-01', 3),
('F75DC975', 'Vinil Glitter', 'Subliprint Leo', 'Vinil Glitter con imagenes de super heroes.', 'activo', 'https://res.cloudinary.com/dqpzipc8i/image/upload/v1702089931/products-subliprint-leo/be3crnvcws9ay9fswlbn.png', 39, 'Ninguna', '2023-12-08 21:45:32', '2023-12-08 21:45:32', '0001-01-01', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productinventory`
--

CREATE TABLE `productinventory` (
  `idProductInventory` int(11) NOT NULL,
  `idProduct` varchar(8) NOT NULL,
  `idInventory` int(11) NOT NULL,
  `amountInit` int(11) NOT NULL,
  `priceInit` float NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productinventory`
--

INSERT INTO `productinventory` (`idProductInventory`, `idProduct`, `idInventory`, `amountInit`, `priceInit`, `subtotal`) VALUES
(27, '017EDD5C', 1, 100, 500, 50000),
(28, '3FAB0141', 1, 150, 65, 9750),
(31, '05A0B0DC', 1, 25, 206, 5150),
(32, '39153B41', 1, 25, 70, 1750),
(33, '0AA93A9E', 1, 40, 36.9, 1476.0000610351562),
(37, '3DFAB170', 1, 50, 39, 1950),
(44, '2CA5C88B', 1, 19, 30, 570),
(68, '960482FB', 1, 100, 50, 5000),
(69, '3D67FB2E', 8, 100, 30, 3000),
(70, '6050FDAE', 8, 100, 39, 3900),
(71, '888FD628', 8, 200, 31, 6200),
(72, 'ABD8DF30', 8, 200, 50, 10000),
(73, 'C37C35CC', 8, 100, 44, 4400),
(74, 'E5D9BF76', 8, 200, 50, 10000),
(75, '074C200B', 19, 50, 14, 700),
(76, '31EAF45F', 19, 200, 15, 3000),
(77, '4200F4C3', 19, 200, 14.5, 2900),
(78, '9DA9FE3D', 19, 122, 10, 1220),
(79, 'AEA9C1DB', 19, 200, 17, 3400),
(80, 'F1314824', 19, 124, 24, 2976),
(81, '1CB527F9', 20, 50, 15, 750),
(82, '38332529', 20, 150, 25, 3750),
(83, '70A59EC9', 20, 200, 35.5, 7100),
(84, '8D6ADF20', 20, 200, 17, 3400),
(85, 'A7491173', 20, 200, 30, 6000),
(86, 'C7A5D44C', 20, 200, 39.5, 7900),
(87, 'F75DC975', 20, 50, 39, 1950),
(88, '1A0609DC', 20, 200, 42.5, 8500),
(89, '3D9ED6F7', 20, 125, 27, 3375),
(90, '5FCDB6B9', 21, 200, 45, 9000),
(91, 'A441AB7E', 21, 20, 7.9, 158),
(92, 'E926CAFA', 21, 50, 50.9, 2545),
(93, '0C07BABA', 21, 200, 19.99, 3998);

--
-- Disparadores `productinventory`
--
DELIMITER $$
CREATE TRIGGER `trg_CalculateSubtotal` BEFORE UPDATE ON `productinventory` FOR EACH ROW BEGIN
    -- Calcular el subtotal antes de la actualización
    SET NEW.subtotal = NEW.amountInit * NEW.priceInit;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `idProvider` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateRegister` date NOT NULL,
  `description` text NOT NULL,
  `ruc` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`idProvider`, `name`, `state`, `phone`, `address`, `email`, `dateRegister`, `description`, `ruc`) VALUES
(37, 'DeWalt', 'inactivo', '555-555-5555', '456 Oak Ave2', 'dewalt@example.com', '2023-10-30', 'Conocido por sus herramientas eléctricas de alta calidad.', '93677523808'),
(38, 'Bosch', 'activo', '777-777-7777', '789 Elm Rd', 'bosch@examplea.com', '2023-10-30', 'Fabricante de herramientas eléctricas y productos de seguridad.', '37618286518'),
(39, '3M', 'activo', '333-333-3333', '101 Pine Ln', '3m@example.com', '2023-10-30', 'Ofrece una amplia gama de productos de adhesivos, cintas y suministros de seguridad.', '73725530562'),
(40, 'Sherwin-Williams', 'activo', '999-999-9999', '567 Maple Blvd', 'sherwin@example.com', '2023-10-30', 'Conocido por sus productos de pintura y recubrimientos.', '66883907104'),
(42, 'Schlage', 'activo', '888-888-8888', '333 Birch Rd', 'schlage@example.com', '2023-10-30', 'Especializado en cerraduras y sistemas de seguridad para puertas.', '13242946567'),
(43, 'Phillips', 'activo', '666-666-6666', '444 Willow Ave', 'phillips@example.com', '2023-10-30', 'Fabricante de productos de iluminación y bombillas.', '32229680918'),
(44, 'Makita', 'activo', '111-111-1111', '555 Redwood Ln', 'makita@example.com', '2023-10-30', 'Conocido por sus herramientas eléctricas, especialmente en la industria de la construcción.', '21419567624'),
(45, 'Black & Decker', 'activo', '222-222-2222', '777 Chestnut St', 'bnd@example.com', '2023-10-30', 'Ofrece una amplia gama de herramientas eléctricas y electrodomésticos.', '88186575874'),
(46, 'Ryobi', 'activo', '777-777-7777', '888 Pine Ave', 'ryobi@example.com', '2023-10-30', 'Fabricante de herramientas eléctricas y productos de jardinería.', '98896401456'),
(47, 'Genie', 'activo', '999-999-9999', '111 Oak St', 'genie@example.com', '2023-10-30', 'Especializado en sistemas de apertura de puertas de garaje.', '41033393503'),
(48, 'Toro', 'inactivo', '555-555-5555', '222 Elm Rd', 'toro@example.com', '2023-10-30', 'Fabricante de equipos de jardinería, incluyendo cortacéspedes y sopladores.', '75144432543'),
(49, 'Weber', 'activo', '333-333-3333', '333 Cedar Blvd', 'weber@example.com', '2023-10-30', 'Conocido por sus parrillas y accesorios para barbacoa.', '63733096055'),
(50, 'Honeywell', 'activo', '777-777-7777', '666 Birch St', 'honeywell@example.com', '2023-10-30', 'Fabricante de productos de seguridad y termostatos.', '82121074264'),
(51, 'Master Lock', 'inactivo', '111-111-1111', '555 Willow Rd', 'masterlock@example.com', '2023-10-30', 'Especializado en candados y sistemas de seguridad.', '30517197004'),
(52, 'Proveedor de Ejemplo4', 'inactivo', '1234-133-4444', 'Example ALgo4444', 'Example@gmail.com', '2023-11-02', 'EWDSFASF', '72889431622'),
(53, 'Proveedor de Ejemplo1', 'inactivo', '1234-133-4230', 'Example ALgo', 'Exarewmple@gmail.com', '2023-11-06', 'fasdfasdf', '84006680946'),
(54, 'fasfd', 'activo', '1234-222-4230', 'Example ALgo4444', 'fasd@fsadf.c', '2023-11-06', 'sdfdsafasfdsaf', '12476223708'),
(55, 'Proveedor de Ejemplo', 'activo', '1234-133-4230', 'Example ALgo', 'Example@gmail.com', '2023-11-27', 'Ejmeplo', '10164121600');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipmentinformation`
--

CREATE TABLE `shipmentinformation` (
  `idShipment` int(11) NOT NULL,
  `idBuyUser` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `nameUser` varchar(255) NOT NULL,
  `lastnameUser` varchar(255) NOT NULL,
  `phoneContact` varchar(9) NOT NULL,
  `address` text NOT NULL,
  `reference` text NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `shipmentinformation`
--

INSERT INTO `shipmentinformation` (`idShipment`, `idBuyUser`, `idUser`, `nameUser`, `lastnameUser`, `phoneContact`, `address`, `reference`, `location`) VALUES
(5, 1, 2, 'Manuel Navarro', 'Apellidos A', '123456778', 'Dirección A', 'Dirección de referencia A', '12234324'),
(6, 24, 2, 'Manuel Navarro', 'Apellidos A', '123456778', 'Dirección A', 'Dirección de referencia A', '12234324'),
(21, 2, 6, 'Manuel', 'Navarro Zeta', '123456799', 'Av. Jesus del valle SIAA', 'Dirección de referencia A', 'Piura'),
(32, 93, 6, 'Manuel', 'Navarro Zeta', '958614633', 'Prolongación Morropon Piura', 'Espaldas del colegios', 'Piura'),
(33, 95, 13, 'Walter Alexis', 'Navarro Silupu', '958614632', 'Dirección ABB', 'Dirección de referencia ABBBB', 'San Martín'),
(34, 96, 13, 'Walter Alexis', 'Navarro Silupu', '958614632', 'Dirección ABB', 'Dirección de referencia ABBBB', 'San Martín'),
(35, 97, 13, 'Walter Alexis', 'Navarro Silupu', '958614632', 'Dirección ABB', 'Dirección de referencia ABBBB', 'San Martín'),
(36, 98, 13, 'Walter Alexis', 'Navarro Silupu', '958614632', 'Dirección ABB', 'Dirección de referencia ABBBB', 'San Martín'),
(37, 162, 19, 'Andres', 'Pasache', '915239215', 'Jose Carlos Mareategui #705', 'Mecanico', 'Piura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE `token` (
  `idToken` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `detailsToken` varchar(255) NOT NULL,
  `create_token` datetime NOT NULL,
  `expire_token` datetime NOT NULL,
  `stateToken` varchar(255) NOT NULL DEFAULT 'Habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`idToken`, `idUser`, `token`, `detailsToken`, `create_token`, `expire_token`, `stateToken`) VALUES
(1, 6, '1535e943', '', '2023-11-25 11:33:51', '2023-11-25 11:47:53', 'Expirado'),
(2, 2, '9befb01b', '', '2023-11-25 11:33:51', '2023-11-25 11:47:53', 'Habilitado'),
(3, 6, 'a81be6b8', 'Recuperar contraseña', '2023-11-25 11:43:45', '2023-11-25 11:53:45', 'Expirado'),
(4, 6, '56ec89e2', 'Recuperar contraseña', '2023-11-25 11:46:08', '2023-11-25 11:56:08', 'Expirado'),
(5, 2, '9f2d3f21', 'Recuperar contraseña', '2023-11-25 12:49:00', '2023-11-25 12:59:00', 'Expirado'),
(6, 6, '5af7b52d', 'Recuperar contraseña', '2023-11-25 15:12:05', '2023-11-25 15:22:05', 'Expirado'),
(7, 6, '838f9695', 'Recuperar contraseña', '2023-11-25 15:22:07', '2023-11-25 15:32:07', 'Expirado'),
(8, 6, '719cbb80', 'Recuperar contraseña', '2023-11-25 15:29:54', '2023-11-25 15:39:54', 'Expirado'),
(9, 6, 'fca9d712', 'Recuperar contraseña', '2023-11-25 15:44:11', '2023-11-25 15:54:11', 'Habilitado'),
(10, 6, 'b4a812c3', 'Recuperar contraseña', '2023-11-25 15:55:10', '2023-11-25 16:05:10', 'Habilitado'),
(11, 6, '6a87484b', 'Recuperar contraseña', '2023-11-25 15:59:03', '2023-11-25 16:09:03', 'Habilitado'),
(12, 6, '76ab8843', 'Recuperar contraseña', '2023-11-25 16:00:01', '2023-11-25 16:10:01', 'Habilitado'),
(13, 6, 'a9fcb23a', 'Recuperar contraseña', '2023-11-25 16:08:42', '2023-11-25 16:18:42', 'Habilitado'),
(18, 13, 'd0d0f83c', 'Confirmar cuenta', '2023-11-26 11:05:03', '2023-11-26 11:15:03', 'Habilitado'),
(19, 13, 'd4d1721f', 'Recuperar contraseña', '2023-11-26 11:15:49', '2023-11-26 11:25:49', 'Habilitado'),
(20, 14, 'dfe6a227', 'Confirmar cuenta', '2023-11-26 11:17:46', '2023-11-26 11:27:46', 'Habilitado'),
(21, 6, 'c903ac66', 'Recuperar contraseña', '2023-11-26 23:43:13', '2023-11-26 23:53:13', 'Habilitado'),
(23, 16, '056e3763', 'Confirmar cuenta', '2023-11-27 07:55:56', '2023-11-27 08:05:56', 'Habilitado'),
(24, 6, 'eb614ec7', 'Recuperar contraseña', '2023-11-27 09:38:17', '2023-11-27 09:48:17', 'Habilitado'),
(25, 6, '7c872327', 'Recuperar contraseña', '2023-11-27 09:52:04', '2023-11-27 10:02:04', 'Habilitado'),
(26, 6, '92d60c35', 'Recuperar contraseña', '2023-11-27 09:58:25', '2023-11-27 10:08:25', 'Habilitado'),
(27, 17, '749ae3fb', 'Confirmar cuenta', '2023-11-28 12:30:47', '2023-11-28 12:40:47', 'Habilitado'),
(28, 18, 'd60ec718', 'Confirmar cuenta', '2023-11-28 13:11:24', '2023-11-28 13:21:24', 'Habilitado'),
(29, 19, '6032e53a', 'Confirmar cuenta', '2023-11-28 13:15:40', '2023-11-28 13:25:40', 'Habilitado'),
(30, 20, 'f2ae29e5', 'Confirmar cuenta', '2023-11-28 13:21:20', '2023-11-28 13:31:20', 'Habilitado'),
(31, 21, '1cd3c6aa', 'Confirmar cuenta', '2023-11-28 13:42:31', '2023-11-28 13:52:31', 'Habilitado'),
(32, 22, 'c4ecd477', 'Confirmar cuenta', '2023-11-28 15:06:17', '2023-11-28 15:16:17', 'Habilitado'),
(33, 23, '45f8776d', 'Confirmar cuenta', '2023-11-28 16:03:37', '2023-11-28 16:13:37', 'Habilitado'),
(34, 6, 'cd82128a', 'Recuperar contraseña', '2023-11-29 00:21:47', '2023-11-29 00:31:47', 'Habilitado'),
(35, 24, '12d6657d', 'Confirmar cuenta', '2023-11-29 00:48:22', '2023-11-29 00:58:22', 'Habilitado'),
(36, 25, 'a664f0bc', 'Confirmar cuenta', '2023-11-29 03:16:06', '2023-11-29 03:26:06', 'Habilitado'),
(37, 19, 'f07d9872', 'Recuperar contraseña', '2023-11-29 23:59:30', '2023-11-30 00:09:30', 'Habilitado'),
(38, 6, 'e013afb1', 'Recuperar contraseña', '2023-11-30 00:58:13', '2023-11-30 01:08:13', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `typeuser`
--

CREATE TABLE `typeuser` (
  `idTypeUser` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `typeuser`
--

INSERT INTO `typeuser` (`idTypeUser`, `name`, `description`) VALUES
(1, 'Usuario Normal', 'Usuario con permisos estándar'),
(2, 'Administrador', 'Usuario con permisos de administración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `reference` text NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `city` text NOT NULL,
  `idTypeUser` int(11) NOT NULL,
  `create_user` datetime NOT NULL,
  `update_user` date DEFAULT NULL,
  `stateAccount` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `password`, `name`, `lastname`, `address`, `reference`, `mail`, `phone`, `city`, `idTypeUser`, `create_user`, `update_user`, `stateAccount`) VALUES
(1, '$2y$10$63JoXRJZVZR/IUf2O/wR7OpZlIji2EhwC.91/qWz474Ed413T.78i', 'Nombres A', 'Apellidos A', 'Dirección A', 'Dirección de referencia A', 'mail@gmail.com', 'Ciudad A', '12234324', 1, '2023-11-13 00:00:00', NULL, 1),
(2, '$2y$10$m.B9pjtIl31fLT5MHARvPuy4FphE7a0u1zrTxLi0LEZMU9GO4p9PS', 'Manuel Navarro', 'Apellidos A', 'Dirección A', 'Dirección de referencia A', 'mail2@gmail.com', '123456778', '12234324', 1, '2023-11-13 00:00:00', '2023-12-02', 1),
(4, '$2y$10$j971t9RG2GG9mVFV.3ppNO/94VDcu0XJtCSHf4cfAgtwtIEQqkRnu', 'Manuel Navarro', 'Apellidos b', 'Dirección ABB', 'Dirección de referencia ABBBB', 'mail3@gmail.com', '12234324', 'Ciudad ABBB', 1, '2023-11-17 00:00:00', NULL, 1),
(5, '$2y$10$qTS1gEtvZEuoD646eglMG.rgB7XoJ7JwhDGegQ6joetwf46rtHYs2', 'Paolo', 'Guerrero', 'Av. Morropon', 'Colegio San Andres', 'paolo@gmail.com', '123456789', 'Piura', 1, '2023-11-22 00:00:00', NULL, 1),
(6, '$2y$10$1w9nlR0QPFgc5KLzebTGHeoVAdSFWNOCXWtpQc/G2ExqUn6NOG/My', 'Manuel', 'Navarro Zeta', 'Prolongación Morropon Piura', 'Espaldas del colegio', 'manuel08n@gmail.com', '958614633', 'Piura', 2, '2023-11-24 00:00:00', '2023-12-03', 1),
(13, '$2y$10$qXCDuXb4vKFPZ/wzlgMxXeYMLeaUhKSiJ6dyIBibFEYwzGj49dxyS', 'Walter Alexis', 'Navarro Silupu', 'Dirección ABB', 'Dirección de referencia ABBBB', 'kodep13de@gmail.com', '958614632', 'San Martín', 1, '2023-11-26 00:00:00', '2023-12-03', 1),
(14, '$2y$10$NughVb32ACC8hY9s2AwBR..LsOvuKPmj4ZQAw8o2hOSEFRUcomXq6', 'Manuel Navarro', 'Apellidos A', 'Dirección ABB', 'Dirección de referencia ABBBB', 'email1@gmail.com', '986667316', 'Madre de Dios', 1, '2023-11-26 00:00:00', NULL, 0),
(16, '$2y$10$tFlAhAo0tHHcEbGViwtCGOzUGuTr3R/rcqyB1q0kdpgR0ZYIHzWvu', 'Manuel Navarro', 'Apellidos A', 'Dirección ABB', 'Dirección de referencia ABBBB', 'fbn@gmail.com', '122343243', 'Amazonas', 2, '2023-11-27 00:00:00', NULL, 0),
(17, '$2y$10$WwE7Iu2YcbIdDLl1/bFwp.XLq2HX3YlUihoKo4yNi3I1S6BfZuHBi', 'Oscar', 'Navarro Veg', 'Los olivos', 'Sullana', 'navarrovegaoscar@gmail.com', '961576391', 'Piura', 2, '2023-11-28 00:00:00', '2023-11-29', 1),
(18, '$2y$10$l9g0gqj6x.hcPvhaddZGteg5ZIfqsF6KZ/PauCSMrLbanHSqPDQYi', 'David Rodolfo ', 'Lachira Garces', 'david_Garces12345@outlook.com', 'Sullana', 'david_garces12345@outlook.com', '994927677', 'Piura', 2, '2023-11-28 00:00:00', NULL, 0),
(19, '$2y$10$fHF5f827sx/pOzWIRO8sLO9XkocvOJj7py3G/KngHjw81ktfpbqAG', 'Andres', 'Pasache', 'Jose Carlos Mareategui #705', 'Mecanico', 'pasache.1518@gmail.com', '915239215', 'Piura', 1, '2023-11-28 00:00:00', '2023-12-08', 1),
(20, '$2y$10$/VnK54NfgMLziorqpOWr2O.fcKx7OwmZVF4jYKWXq20gHpXes97yu', 'Darwin', 'Neyra', 'Calle Ignacio sanchez', 'Sullana', 'neyradarwin81@gmail.com', '994927677', 'Piura', 1, '2023-11-28 00:00:00', '2023-11-28', 1),
(21, '$2y$10$S9GeREvlYFKKZfein2sFGO3Pvr5BdcPMuO4RGsO3E8jTRxeeCMGWu', 'Ana ', 'Carreño Girón ', 'Calle Cuzco #731', 'Espaldas del colegio ', 'yarally2002@gmail.com', '965099644', 'Piura', 2, '2023-11-28 00:00:00', NULL, 1),
(22, '$2y$10$MQfCVFS67lnKp2W7sRsyJOMkj5/jbX.MoOP80adv/x0dvj6ucf.QK', 'Luis Franklin', 'Zeta Juarez', 'Parque los educadorés Piura', 'Alfrente de la tienda de doña Mari', 'Zetajuarezluisfranklin744@gmail.com', '929074959', 'Piura', 2, '2023-11-28 00:00:00', '2023-11-29', 1),
(23, '$2y$10$K.amiKrQFdLhocTr3F2OA.ggGLAyxiGOkxDa4HaYELvQVpmmWwU8a', 'Luis Franklin', 'Zeta Juarez', 'Parque los educadores', 'Al frente de la tienda de doña Mari', 'Zetajuarezluisfranklin744@gmail', '929074959', 'Piura', 2, '2023-11-28 00:00:00', NULL, 0),
(24, '$2y$10$9X4GM7BRY3vQat.hw64Viud7s6qhjNVJw21.cib0nzMKX2QUOWg2K', 'jorge', 'ochoa', 'paita', 'paita', 'horuhe_drum@outlook.com', '976396991', 'Piura', 1, '2023-11-28 00:00:00', '2023-11-29', 1),
(25, '$2y$10$tVBy0d/vsLnO/bt3JZ5bKO3YxHTOSC0cIzhH2ED7.0juZ1LqPHrxq', 'Paola ', 'Zeta Juarez ', 'Jr 12 de abril', 'Tambo grande ', 'samypaolaz@gmail.com', '918487542', 'Amazonas', 1, '2023-11-28 00:00:00', '2023-11-29', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `buyuser`
--
ALTER TABLE `buyuser`
  ADD PRIMARY KEY (`lastId`),
  ADD UNIQUE KEY `idBuyUser` (`idBuyUser`),
  ADD KEY `FK_OrderProducts_BuyUser` (`idOrder`),
  ADD KEY `FK_BuyUser_User` (`idUser`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `infopage`
--
ALTER TABLE `infopage`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`idInventory`),
  ADD KEY `FK_Inventory_Provider` (`idProvider`);

--
-- Indices de la tabla `orderbuy`
--
ALTER TABLE `orderbuy`
  ADD PRIMARY KEY (`idLastOrderBuy`),
  ADD UNIQUE KEY `idOrderBuy` (`idOrderBuy`),
  ADD KEY `FK_OrderBuy_PaymentMethod` (`idPaymentMethod`);

--
-- Indices de la tabla `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`idOrderDetail`),
  ADD KEY `FK_OrderDetail_OrderBuy` (`idOrderBuy`),
  ADD KEY `FK_OrderDetail_Product` (`idProduct`);

--
-- Indices de la tabla `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`idPaymentMethod`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `FK_Product_Category` (`idCategory`);

--
-- Indices de la tabla `productinventory`
--
ALTER TABLE `productinventory`
  ADD PRIMARY KEY (`idProductInventory`),
  ADD KEY `FK_ProductInventory_Product` (`idProduct`),
  ADD KEY `FK_ProductInventory_Provider` (`idInventory`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`idProvider`);

--
-- Indices de la tabla `shipmentinformation`
--
ALTER TABLE `shipmentinformation`
  ADD PRIMARY KEY (`idShipment`),
  ADD KEY `FK_IdUser_IdUserShipment` (`idUser`),
  ADD KEY `FK_IdBuyUser_Shipment` (`idBuyUser`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`idToken`),
  ADD KEY `FK_idUserToken_User` (`idUser`);

--
-- Indices de la tabla `typeuser`
--
ALTER TABLE `typeuser`
  ADD PRIMARY KEY (`idTypeUser`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `UNIKE_MAIL` (`mail`),
  ADD KEY `FK_Type_User` (`idTypeUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `buyuser`
--
ALTER TABLE `buyuser`
  MODIFY `lastId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `infopage`
--
ALTER TABLE `infopage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `idInventory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `orderbuy`
--
ALTER TABLE `orderbuy`
  MODIFY `idLastOrderBuy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT de la tabla `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `idOrderDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT de la tabla `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `idPaymentMethod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productinventory`
--
ALTER TABLE `productinventory`
  MODIFY `idProductInventory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `idProvider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `shipmentinformation`
--
ALTER TABLE `shipmentinformation`
  MODIFY `idShipment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `token`
--
ALTER TABLE `token`
  MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `typeuser`
--
ALTER TABLE `typeuser`
  MODIFY `idTypeUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `buyuser`
--
ALTER TABLE `buyuser`
  ADD CONSTRAINT `FK_BuyUser_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `FK_OrderProducts_BuyUser` FOREIGN KEY (`idOrder`) REFERENCES `orderbuy` (`idOrderBuy`);

--
-- Filtros para la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `FK_Inventory_Provider` FOREIGN KEY (`idProvider`) REFERENCES `providers` (`idProvider`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orderbuy`
--
ALTER TABLE `orderbuy`
  ADD CONSTRAINT `FK_OrderBuy_PaymentMethod` FOREIGN KEY (`idPaymentMethod`) REFERENCES `paymentmethod` (`idPaymentMethod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `FK_OrderDetail_OrderBuy` FOREIGN KEY (`idOrderBuy`) REFERENCES `orderbuy` (`idOrderBuy`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_OrderDetail_Product` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_Product_Category` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productinventory`
--
ALTER TABLE `productinventory`
  ADD CONSTRAINT `FK_ProductInventory_Product` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ProductInventory_Provider` FOREIGN KEY (`idInventory`) REFERENCES `inventory` (`idInventory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `shipmentinformation`
--
ALTER TABLE `shipmentinformation`
  ADD CONSTRAINT `FK_IdBuyUser_Shipment` FOREIGN KEY (`idBuyUser`) REFERENCES `buyuser` (`lastId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_IdUser_IdUserShipment` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `FK_idUserToken_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_Type_User` FOREIGN KEY (`idTypeUser`) REFERENCES `typeuser` (`idTypeUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
