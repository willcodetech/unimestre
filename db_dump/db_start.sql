-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 09/04/2025 às 19:26
-- Versão do servidor: 8.0.33-cll-lve
-- Versão do PHP: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `willcode_unimestre`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `change_history`
--

CREATE TABLE `change_history` (
  `id` int NOT NULL,
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int DEFAULT NULL,
  `field` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='List of fields that will have a change record';

--
-- Despejando dados para a tabela `change_history`
--

INSERT INTO `change_history` (`id`, `object_name`, `create_date`, `update_date`, `create_user_id`, `field`, `active`) VALUES
(4, 'curriculum', '2025-04-09 15:50:00', NULL, 1, 'salary_claim', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int DEFAULT NULL,
  `record` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `company`
--

INSERT INTO `company` (`id`, `name`, `code`, `create_date`, `update_date`, `create_user_id`, `record`, `email`, `phone`, `address`) VALUES
(6, 'WillCode', 'WCD', '2024-06-19 10:44:49', '2024-06-19 10:45:24', 1, '32117546000113', 'william@willcode.tech', '47992242607', 'Rua Otto Wille, 441, Água Verde, Blumenau - SC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `company_group`
--

CREATE TABLE `company_group` (
  `id` int NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `create_user_id` int DEFAULT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `company_group_company`
--

CREATE TABLE `company_group_company` (
  `id` int NOT NULL,
  `company_group_id` int NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Relacionamento de empresas com grupo de empresas';

-- --------------------------------------------------------

--
-- Estrutura para tabela `currency`
--

CREATE TABLE `currency` (
  `id` int NOT NULL,
  `code` varchar(45) NOT NULL,
  `name` varchar(100) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int NOT NULL,
  `active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `currency`
--

INSERT INTO `currency` (`id`, `code`, `name`, `symbol`, `create_date`, `update_date`, `create_user_id`, `active`) VALUES
(1, 'AFN', 'Afegane afegão', '', '2023-10-29 12:59:07', NULL, 1, 0),
(2, 'MGA', 'Ariari malgaxe', 'Ar', '2023-10-29 12:59:07', NULL, 1, 0),
(3, 'THB', 'Baht tailandês', '', '2023-10-29 12:59:07', NULL, 1, 0),
(4, 'PAB', 'Balboa panamense', 'B/.', '2023-10-29 12:59:07', NULL, 1, 0),
(5, 'ETB', 'Birr etíope', 'Br', '2023-10-29 12:59:07', NULL, 1, 0),
(6, 'VES', 'Bolívar Soberano Venezuelano', 'Bs S', '2023-10-29 12:59:07', NULL, 1, 0),
(7, 'BOB', 'Boliviano', 'Bs.', '2023-10-29 12:59:07', NULL, 1, 0),
(8, 'GHS', 'Cedi do Gana', '', '2023-10-29 12:59:07', NULL, 1, 0),
(9, 'CRC', 'Colón costarriquenho', '', '2023-10-29 12:59:07', NULL, 1, 0),
(10, 'NIO', 'Córdoba nicaraguano', 'C$', '2023-10-29 12:59:07', NULL, 1, 0),
(11, 'CZK', 'Coroa checa', 'Kc', '2023-10-29 12:59:07', NULL, 1, 0),
(12, 'DKK', 'Coroa dinamarquesa', 'kr', '2023-10-29 12:59:07', NULL, 1, 0),
(13, 'ISK', 'Coroa islandesa', 'kr', '2023-10-29 12:59:07', NULL, 1, 0),
(14, 'NOK', 'Coroa norueguesa', 'kr', '2023-10-29 12:59:07', NULL, 1, 0),
(15, 'SEK', 'Coroa sueca', 'kr', '2023-10-29 12:59:07', NULL, 1, 0),
(16, 'GMD', 'Dalasi gambiano', 'D', '2023-10-29 12:59:07', NULL, 1, 0),
(17, 'DZD', 'Dinar argelino', '', '2023-10-29 12:59:07', NULL, 1, 0),
(18, 'BHD', 'Dinar barenita', '', '2023-10-29 12:59:07', NULL, 1, 0),
(19, 'KWD', 'Dinar cuaitiano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(20, 'IQD', 'Dinar iraquiano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(21, 'JOD', 'Dinar jordano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(22, 'LYD', 'Dinar líbio', '', '2023-10-29 12:59:07', NULL, 1, 0),
(23, 'MKD', 'Dinar macedónio', '', '2023-10-29 12:59:07', NULL, 1, 0),
(24, 'RSD', 'Dinar sérvio', '', '2023-10-29 12:59:07', NULL, 1, 0),
(25, 'TND', 'Dinar tunisino', '', '2023-10-29 12:59:07', NULL, 1, 0),
(26, 'AED', 'Dirame dos Emirados Árabes Unidos', '', '2023-10-29 12:59:07', NULL, 1, 0),
(27, 'MAD', 'Dirame marroquino', '', '2023-10-29 12:59:07', NULL, 1, 0),
(28, 'STD', 'Dobra de São Tomé e Príncipe', 'Db', '2023-10-29 12:59:07', NULL, 1, 0),
(29, 'AUD', 'Dólar australiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(30, 'BSD', 'Dólar baamense', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(31, 'BMD', 'Dólar bermudense', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(32, 'CAD', 'Dólar canadiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(33, 'NZD', 'Dólar da Nova Zelândia', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(34, 'XCD', 'Dólar das Caraíbas Orientais', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(35, 'KYD', 'Dólar das Ilhas Caimão', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(36, 'SBD', 'Dólar das Ilhas Salomão', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(37, 'HKD', 'Dólar de Honguecongue', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(38, 'SGD', 'Dólar de Singapura', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(39, 'TTD', 'Dólar de Trindade e Tobago', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(40, 'BZD', 'Dólar do Belize', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(41, 'BND', 'Dólar do Brunei', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(42, 'BBD', 'Dólar dos Barbados', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(43, 'USD', 'Dólar dos Estados Unidos', '$', '2023-10-29 12:59:07', NULL, 1, 1),
(44, 'FJD', 'Dólar fijiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(45, 'GYD', 'Dólar guianense', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(46, 'JMD', 'Dólar jamaicano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(47, 'LRD', 'Dólar liberiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(48, 'NAD', 'Dólar namibiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(49, 'SRD', 'Dólar surinamês', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(50, 'VND', 'Dongue vietnamita', '', '2023-10-29 12:59:07', NULL, 1, 0),
(51, 'AMD', 'Dram arménio', '', '2023-10-29 12:59:07', NULL, 1, 0),
(52, 'CVE', 'Escudo cabo-verdiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(53, 'EUR', 'Euro', '€', '2023-10-29 12:59:07', NULL, 1, 1),
(54, 'ANG', 'Florim antilhano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(55, 'AWG', 'Florim arubano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(56, 'HUF', 'Florim húngaro', 'Ft', '2023-10-29 12:59:07', NULL, 1, 0),
(57, 'BIF', 'Franco burundiano', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(58, 'XOF', 'Franco CFA BCEAO', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(59, 'XAF', 'Franco CFA BEAC', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(60, 'XPF', 'Franco CFP', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(61, 'KMF', 'Franco comorense', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(62, 'CDF', 'Franco congolês', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(63, 'GNF', 'Franco guineense', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(64, 'DJF', 'Franco jibutiano', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(65, 'RWF', 'Franco ruandês', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(66, 'CHF', 'Franco suíço', 'Fr', '2023-10-29 12:59:07', NULL, 1, 0),
(67, 'UAH', 'Grívnia ucraniana', '', '2023-10-29 12:59:07', NULL, 1, 0),
(68, 'PYG', 'Guarani paraguaio', '', '2023-10-29 12:59:07', NULL, 1, 0),
(69, 'HTG', 'Gurde haitiano', 'G', '2023-10-29 12:59:07', NULL, 1, 0),
(70, 'JPY', 'Iene japonês', '¥', '2023-10-29 12:59:07', NULL, 1, 0),
(71, 'CNY', 'Iuane chinês', '¥', '2023-10-29 12:59:07', NULL, 1, 0),
(72, 'PGK', 'Kina papuásia', 'K', '2023-10-29 12:59:07', NULL, 1, 0),
(73, 'LAK', 'Kipe lau', '', '2023-10-29 12:59:07', NULL, 1, 0),
(74, 'HRK', 'Kuna croata', 'kn', '2023-10-29 12:59:07', NULL, 1, 0),
(75, 'MWK', 'Kwacha malauiano', 'MK', '2023-10-29 12:59:07', NULL, 1, 0),
(76, 'ZMK', 'Kwacha zambiano', 'ZK', '2023-10-29 12:59:07', NULL, 1, 0),
(77, 'AOA', 'Kwanza angolano', 'Kz', '2023-10-29 12:59:07', NULL, 1, 0),
(78, 'MMK', 'Kyat de Mianmar', 'Ks', '2023-10-29 12:59:07', NULL, 1, 0),
(79, 'GEL', 'Lari georgiano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(80, 'ALL', 'Lek albanês', 'L', '2023-10-29 12:59:07', NULL, 1, 0),
(81, 'HNL', 'Lempira hondurenha', 'L', '2023-10-29 12:59:07', NULL, 1, 0),
(82, 'SLL', 'Leone serra-leonino', 'Le', '2023-10-29 12:59:07', NULL, 1, 0),
(83, 'MDL', 'Leu moldávio', 'L', '2023-10-29 12:59:07', NULL, 1, 0),
(84, 'RON', 'Leu romeno', 'lei', '2023-10-29 12:59:07', NULL, 1, 0),
(85, 'BGN', 'Lev búlgaro', '', '2023-10-29 12:59:07', NULL, 1, 0),
(86, 'FKP', 'Libra das Ilhas Malvinas', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(87, 'GIP', 'Libra de Gibraltar', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(88, 'GGP', 'Libra de Guernesei', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(89, 'JEP', 'Libra de Jérsia', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(90, 'SHP', 'Libra de Santa Helena', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(91, 'EGP', 'Libra egípcia', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(92, 'GBP', 'Libra esterlina', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(93, 'LBP', 'Libra libanesa', '', '2023-10-29 12:59:07', NULL, 1, 0),
(94, 'IMP', 'Libra manesa', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(95, 'SYP', 'Libra síria', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(96, 'SDG', 'Libra sudanesa', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(97, 'SSP', 'Libra sul-sudanesa', '£', '2023-10-29 12:59:07', NULL, 1, 0),
(98, 'SZL', 'Lilangeni suazilandês', 'L', '2023-10-29 12:59:07', NULL, 1, 0),
(99, 'TRY', 'Lira turca', '', '2023-10-29 12:59:07', NULL, 1, 0),
(100, 'LSL', 'Loti do Lesoto', 'L', '2023-10-29 12:59:07', NULL, 1, 0),
(101, 'AZN', 'Manat azerbaijano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(102, 'TMT', 'Manat turcomeno', 'm', '2023-10-29 12:59:07', NULL, 1, 0),
(103, 'BAM', 'Marco convertível da Bósnia e Herzegovina', 'KM', '2023-10-29 12:59:07', NULL, 1, 0),
(104, 'MZN', 'Metical moçambicano', 'MT', '2023-10-29 12:59:07', NULL, 1, 0),
(105, 'NGN', 'Naira nigeriano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(106, 'ERN', 'Nakfa eritreia', 'Nfk', '2023-10-29 12:59:07', NULL, 1, 0),
(107, 'BTN', 'Ngultrum butanês', 'Nu.', '2023-10-29 12:59:07', NULL, 1, 0),
(108, 'TWD', 'Novo dólar de Taiuã', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(109, 'ILS', 'Novo siclo israelita', '', '2023-10-29 12:59:07', NULL, 1, 0),
(110, 'PEN', 'Novo sol peruano', 'S/.', '2023-10-29 12:59:07', NULL, 1, 0),
(111, 'TOP', 'Paanga tonganesa', 'T$', '2023-10-29 12:59:07', NULL, 1, 0),
(112, 'MOP', 'Pataca macaense', 'P', '2023-10-29 12:59:07', NULL, 1, 0),
(113, 'ARS', 'Peso argentino', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(114, 'CLP', 'Peso chileno', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(115, 'COP', 'Peso colombiano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(116, 'CUP', 'Peso cubano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(117, 'CUC', 'Peso cubano convertível', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(118, 'DOP', 'Peso dominicano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(119, 'PHP', 'Peso filipino', '', '2023-10-29 12:59:07', NULL, 1, 0),
(120, 'MXN', 'Peso mexicano', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(121, 'UYU', 'Peso uruguaio', '$', '2023-10-29 12:59:07', NULL, 1, 0),
(122, 'BWP', 'Pula do Botsuana', 'P', '2023-10-29 12:59:07', NULL, 1, 0),
(123, 'GTQ', 'Quetzal guatemalteco', 'Q', '2023-10-29 12:59:07', NULL, 1, 0),
(124, 'ZAR', 'Rand sul-africano', 'R', '2023-10-29 12:59:07', NULL, 1, 0),
(125, 'BRL', 'Real', 'R$', '2023-10-29 12:59:07', NULL, 1, 1),
(126, 'QAR', 'Rial catarense', '', '2023-10-29 12:59:07', NULL, 1, 0),
(127, 'YER', 'Rial iemenita', '', '2023-10-29 12:59:07', NULL, 1, 0),
(128, 'IRR', 'Rial iraniano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(129, 'OMR', 'Rial omanense', '', '2023-10-29 12:59:07', NULL, 1, 0),
(130, 'SAR', 'Rial saudita', '', '2023-10-29 12:59:07', NULL, 1, 0),
(131, 'KHR', 'Riel cambojano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(132, 'MYR', 'Ringuite malaio', 'RM', '2023-10-29 12:59:07', NULL, 1, 0),
(133, 'BYR', 'Rublo bielorrusso', 'Br', '2023-10-29 12:59:07', NULL, 1, 0),
(134, 'RUB', 'Rublo russo', '', '2023-10-29 12:59:07', NULL, 1, 0),
(135, 'PNB', 'Rublo transdniestriano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(136, 'LKR', 'Rupia do Sri Lanka', 'Rs', '2023-10-29 12:59:07', NULL, 1, 0),
(137, 'INR', 'Rupia indiana', '', '2023-10-29 12:59:07', NULL, 1, 0),
(138, 'IDR', 'Rupia indonésia', 'Rp', '2023-10-29 12:59:07', NULL, 1, 0),
(139, 'MVR', 'Rupia maldiva', '', '2023-10-29 12:59:07', NULL, 1, 0),
(140, 'MUR', 'Rupia maurícia', '', '2023-10-29 12:59:07', NULL, 1, 0),
(141, 'NPR', 'Rupia nepalesa', '', '2023-10-29 12:59:07', NULL, 1, 0),
(142, 'PKR', 'Rupia paquistanesa', '', '2023-10-29 12:59:07', NULL, 1, 0),
(143, 'SCR', 'Rupia seichelense', '', '2023-10-29 12:59:07', NULL, 1, 0),
(144, 'KGS', 'Som quirguiz', '', '2023-10-29 12:59:07', NULL, 1, 0),
(145, 'UZS', 'Som usbeque', '', '2023-10-29 12:59:07', NULL, 1, 0),
(146, 'TJS', 'Somoni tajique', 'SM', '2023-10-29 12:59:07', NULL, 1, 0),
(147, 'BDT', 'Taka bangladexense', '', '2023-10-29 12:59:07', NULL, 1, 0),
(148, 'WST', 'Tala samoana', 'T', '2023-10-29 12:59:07', NULL, 1, 0),
(149, 'KZT', 'Tengue cazaque', '', '2023-10-29 12:59:07', NULL, 1, 0),
(150, 'MNT', 'Tugrik mongol', '', '2023-10-29 12:59:07', NULL, 1, 0),
(151, 'MRO', 'Uguia mauritana', 'UM', '2023-10-29 12:59:07', NULL, 1, 0),
(152, 'VUV', 'Vatu do Vanuatu', 'Vt', '2023-10-29 12:59:07', NULL, 1, 0),
(153, 'KPW', 'Won norte-coreano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(154, 'KRW', 'Won sul-coreano', '', '2023-10-29 12:59:07', NULL, 1, 0),
(155, 'KES', 'Xelim queniano', 'Sh', '2023-10-29 12:59:07', NULL, 1, 0),
(156, 'SOS', 'Xelim somaliano', 'Sh', '2023-10-29 12:59:07', NULL, 1, 0),
(157, 'TZS', 'Xelim tanzaniano', 'Sh', '2023-10-29 12:59:07', NULL, 1, 0),
(158, 'UGX', 'Xelim ugandês', 'Sh', '2023-10-29 12:59:07', NULL, 1, 0),
(159, 'PLN', 'Zlóti polaco', '', '2023-10-29 12:59:07', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curriculum`
--

CREATE TABLE `curriculum` (
  `id` int NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `birth_date` date NOT NULL,
  `gender_id` int NOT NULL,
  `marital_status_id` int NOT NULL,
  `education_id` int NOT NULL,
  `courses` json DEFAULT NULL,
  `experiences` json DEFAULT NULL,
  `salary_claim` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `curriculum`
--

INSERT INTO `curriculum` (`id`, `create_date`, `update_date`, `create_user_id`, `user_id`, `cpf`, `birth_date`, `gender_id`, `marital_status_id`, `education_id`, `courses`, `experiences`, `salary_claim`) VALUES
(1, '2025-04-04 09:38:22', '2025-04-09 10:15:18', 1, 1, '08357065910', '1993-03-30', 2, 2, 5, '{\"1\": {\"name\": \"Técnico em Informática\", \"date_end\": \"2016-12-31\", \"date_start\": \"2015-01-01\", \"institution\": \"Cedup HH\"}, \"2\": {\"name\": \"Tecnologia em cibersegurança\", \"date_end\": \"2025-12-31\", \"date_start\": \"2023-02-01\", \"institution\": \"Unicesumar\"}, \"3\": {\"name\": \"AutoCad\", \"date_end\": \"2012-06-06\", \"date_start\": \"2012-01-01\", \"institution\": \"Senai\"}}', '{\"1\": {\"name\": \"Programador PHP\", \"company\": \"Willcode\", \"date_end\": \"\", \"date_start\": \"2018-11-01\", \"description\": \"<p>Desenvolvedor Web</p>\"}, \"2\": {\"name\": \"Analista de TI\", \"company\": \"Wanke SA\", \"date_end\": \"2018-11-01\", \"date_start\": \"2017-08-01\", \"description\": \"<p>Administração de servidores, suporte ao usuário e consultoria</p>\"}, \"3\": {\"name\": \"Analista de TI\", \"company\": \"Jung\", \"date_end\": \"2017-07-01\", \"date_start\": \"2012-01-01\", \"description\": \"<p>Gerenciamento de servidores, infraestrutura e dados</p>\"}}', 15000.00),
(4, '2025-04-04 09:38:22', '2025-04-09 15:53:49', 1, 120, '04511191930', '1990-01-30', 2, 4, 5, '{\"1\": {\"name\": \"Técnico em Informática\", \"date_end\": \"2016-12-31\", \"date_start\": \"2015-01-01\", \"institution\": \"Cedup HH\"}, \"2\": {\"name\": \"Tecnologia em cibersegurança\", \"date_end\": \"2025-12-31\", \"date_start\": \"2023-02-01\", \"institution\": \"Unicesumar\"}, \"3\": {\"name\": \"\", \"date_end\": \"\", \"date_start\": \"\", \"institution\": \"\"}}', '{\"1\": {\"name\": \"Programador PHP\", \"company\": \"Willcode\", \"date_end\": \"\", \"date_start\": \"2018-11-01\", \"description\": \"<p>Desenvolvedor Web</p>\"}, \"2\": {\"name\": \"Analista de TI\", \"company\": \"Wanke SA\", \"date_end\": \"2018-11-01\", \"date_start\": \"2017-08-01\", \"description\": \"<p>Administração de servidores, suporte ao usuário e consultoria</p>\"}, \"3\": {\"name\": \"Analista de TI\", \"company\": \"Jung\", \"date_end\": \"2017-07-01\", \"date_start\": \"2012-01-01\", \"description\": \"<p>Gerenciamento de servidores, infraestrutura e dados</p>\"}}', 7200.00),
(5, '2025-04-09 16:25:15', '2025-04-09 16:36:44', 121, 121, '08642607920', '1995-02-22', 2, 3, 8, '{\"1\": {\"name\": \"Graduação em Ciências Contábeis \", \"date_end\": \"2015-12-31\", \"date_start\": \"2012-01-01\", \"institution\": \"UNIASSELVI - FAMEBLU\"}, \"2\": {\"name\": \"Pós Graduação em Direito Tributário\", \"date_end\": \"2026-12-31\", \"date_start\": \"2025-01-01\", \"institution\": \"UNIVALI\"}, \"3\": {\"name\": \"\", \"date_end\": \"\", \"date_start\": \"\", \"institution\": \"\"}}', '{\"1\": {\"name\": \"Contador\", \"company\": \"Tambosi Contadores S/S\", \"date_end\": \"2025-04-30\", \"date_start\": \"2019-01-01\", \"description\": \"<p>Contador da empresa, responsável técnico por balanços, envio de declarações, apurações de impostos, abertura baixa e alteração contratual.</p>\"}, \"2\": {\"name\": \"Analista Contábil\", \"company\": \"Ideal Contabildiade\", \"date_end\": \"2019-04-02\", \"date_start\": \"2017-05-02\", \"description\": \"<p>Responsável por fechamento balanços, envio de declarações, apresentação de resultados. Analise de balanço junto ao cliente</p>\"}, \"3\": {\"name\": \"\", \"company\": \"\", \"date_end\": \"\", \"date_start\": \"\", \"description\": \"\"}}', 10500.00),
(6, '2025-04-09 18:22:45', '2025-04-09 18:26:18', 123, 123, '09129876931', '2010-02-01', 2, 4, 6, '{\"1\": {\"name\": \"Gestão de Projetos\", \"date_end\": \"2024-12-31\", \"date_start\": \"2024-01-01\", \"institution\": \"Senai\"}, \"2\": {\"name\": \"Liderança\", \"date_end\": \"2024-08-03\", \"date_start\": \"2024-01-01\", \"institution\": \"Unicesumar\"}, \"3\": {\"name\": \"AutoCad\", \"date_end\": \"2023-09-30\", \"date_start\": \"2022-01-01\", \"institution\": \"Udemy\"}}', '{\"1\": {\"name\": \"Tech Lead\", \"company\": \"Senior\", \"date_end\": \"\", \"date_start\": \"2023-04-01\", \"description\": \"<p>Acompanhava os programadores e fazia a gestão das tarefas</p>\"}, \"2\": {\"name\": \"\", \"company\": \"\", \"date_end\": \"\", \"date_start\": \"\", \"description\": \"\"}, \"3\": {\"name\": \"\", \"company\": \"\", \"date_end\": \"\", \"date_start\": \"\", \"description\": \"\"}}', 5500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `education`
--

CREATE TABLE `education` (
  `id` int NOT NULL,
  `code` char(2) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `education`
--

INSERT INTO `education` (`id`, `code`, `description`) VALUES
(1, 'fi', 'Ensino Fundamental Incompleto'),
(2, 'fc', 'Ensino Fundamental Completo'),
(3, 'mi', 'Ensino Médio Incompleto'),
(4, 'mc', 'Ensino Médio Completo'),
(5, 'si', 'Superior Incompleto'),
(6, 'sc', 'Superior Completo'),
(7, 'pc', 'Pós Graduação Completa'),
(8, 'pi', 'Pós Graduação Incompleta');

-- --------------------------------------------------------

--
-- Estrutura para tabela `file`
--

CREATE TABLE `file` (
  `id` int NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `create_user_id` int DEFAULT NULL,
  `original_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `size` decimal(10,0) DEFAULT NULL COMMENT 'File size mb',
  `object` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `extension` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Extension (e: pdf, png, jpeg)',
  `mime_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Mime type, used to define whether it is pdf, text, etc. (parameter to generate header())',
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'File name saved in folder, random hash',
  `register_id` int DEFAULT NULL COMMENT 'ID of the referenced record, related to the reported object.\nFor example:\nOBJECT "company"\nRECORD_ID 2, indicates that the file belongs to the company object referring to ID 2 of the company table',
  `path` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci COMMENT 'Full file path',
  `hash` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Unique hash of the file, used to search the API',
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='File control.\nThe files will be saved in folders, not in the database, but the information and file links are stored in the database\nto facilitate links and research';

--
-- Despejando dados para a tabela `file`
--

INSERT INTO `file` (`id`, `description`, `create_date`, `create_user_id`, `original_name`, `size`, `object`, `extension`, `mime_type`, `name`, `register_id`, `path`, `hash`, `type`) VALUES
(108, 'Simbolo.jpg', '2024-06-07 13:35:41', 1, 'Simbolo.jpg', 282069, 'user', 'jpg', 'image/jpeg', '2024-06-07_01-06_oA3J9nz9P0D3T4HTACTUdBOAJ', 1, 'user/1/2024-06-07_01-06_oA3J9nz9P0D3T4HTACTUdBOAJ', 'MjAyNC0wNi0wN18wMS0wNl9vQTNKOW56OVAwRDNUNEhUQUNUVWRCT0FK', 'profile_picture');

-- --------------------------------------------------------

--
-- Estrutura para tabela `file_mime_type`
--

CREATE TABLE `file_mime_type` (
  `id` int NOT NULL,
  `description` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `create_user_id` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `extension` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mime_type` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `allow_upload` tinyint(1) DEFAULT '0' COMMENT 'Define se permite upload pelo gerenciador de arquivo',
  `group_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Grupo do tipo, imagem, aplicação etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='List of Apache extensions and MIME types';

--
-- Despejando dados para a tabela `file_mime_type`
--

INSERT INTO `file_mime_type` (`id`, `description`, `create_date`, `create_user_id`, `active`, `extension`, `mime_type`, `allow_upload`, `group_name`) VALUES
(1, NULL, '2022-06-02 15:38:57', 1, 1, 'wvx', 'video/x-ms-wvx', 0, 'video'),
(2, NULL, '2022-06-02 15:38:57', 1, 1, 'susp', 'application/vnd.sus-calendar', 0, 'application'),
(3, NULL, '2022-06-02 15:38:57', 1, 1, 'tmo', 'application/vnd.tmobile-livetv', 0, 'application'),
(4, NULL, '2022-06-02 15:38:57', 1, 1, 'm2v', 'video/mpeg', 0, 'video'),
(5, NULL, '2022-06-02 15:38:57', 1, 1, 'plf', 'application/vnd.pocketlearn', 0, 'application'),
(6, NULL, '2022-06-02 15:38:57', 1, 1, 'der', 'application/x-x509-ca-cert', 0, 'application'),
(7, NULL, '2022-06-02 15:38:57', 1, 1, 'plb', 'application/vnd.3gpp.pic-bw-large', 0, 'application'),
(8, NULL, '2022-06-02 15:38:57', 1, 1, 'plc', 'application/vnd.mobius.plc', 0, 'application'),
(9, NULL, '2022-06-02 15:38:57', 1, 1, 'ttc', 'application/x-font-ttf', 0, 'application'),
(10, NULL, '2022-06-02 15:38:57', 1, 1, 'car', 'application/vnd.curl.car', 0, 'application'),
(11, NULL, '2022-06-02 15:38:57', 1, 1, 'onepkg', 'application/onenote', 0, 'application'),
(12, NULL, '2022-06-02 15:38:57', 1, 1, 'def', 'text/plain', 0, 'text'),
(13, NULL, '2022-06-02 15:38:57', 1, 1, 'vcard', 'text/vcard', 0, 'text'),
(14, NULL, '2022-06-02 15:38:57', 1, 1, 'sus', 'application/vnd.sus-calendar', 0, 'application'),
(15, NULL, '2022-06-02 15:38:57', 1, 1, 'iif', 'application/vnd.shana.informed.interchange', 0, 'application'),
(16, NULL, '2022-06-02 15:38:57', 1, 1, 'deb', 'application/x-debian-package', 0, 'application'),
(17, NULL, '2022-06-02 15:38:57', 1, 1, 'm2a', 'audio/mpeg', 0, 'audio'),
(18, NULL, '2022-06-02 15:38:57', 1, 1, 'pls', 'application/pls+xml', 0, 'application'),
(19, NULL, '2022-06-02 15:38:57', 1, 1, 'cgm', 'image/cgm', 1, 'image'),
(20, NULL, '2022-06-02 15:38:57', 1, 1, 'rdz', 'application/vnd.data-vision.rdz', 0, 'application'),
(21, NULL, '2022-06-02 15:38:57', 1, 1, 'ttf', 'application/x-font-ttf', 0, 'application'),
(22, NULL, '2022-06-02 15:38:57', 1, 1, 'ecma', 'application/ecmascript', 0, 'application'),
(23, NULL, '2022-06-02 15:38:57', 1, 1, 'uu', 'text/x-uuencode', 0, 'text'),
(24, NULL, '2022-06-02 15:38:57', 1, 1, 'meta4', 'application/metalink4+xml', 0, 'application'),
(25, NULL, '2022-06-02 15:38:57', 1, 1, 'roa', 'application/rpki-roa', 0, 'application'),
(26, NULL, '2022-06-02 15:38:57', 1, 1, 'cww', 'application/prs.cww', 0, 'application'),
(27, NULL, '2022-06-02 15:38:57', 1, 1, 'rdf', 'application/rdf+xml', 0, 'application'),
(28, NULL, '2022-06-02 15:38:57', 1, 1, 'igl', 'application/vnd.igloader', 0, 'application'),
(29, NULL, '2022-06-02 15:38:57', 1, 1, 'clp', 'application/x-msclip', 0, 'application'),
(30, NULL, '2022-06-02 15:38:57', 1, 1, 'dvb', 'video/vnd.dvb.file', 0, 'video'),
(31, NULL, '2022-06-02 15:38:57', 1, 1, 'sub', 'text/vnd.dvb.subtitle', 0, 'text'),
(32, NULL, '2022-06-02 15:38:57', 1, 1, 'igm', 'application/vnd.insors.igm', 0, 'application'),
(33, NULL, '2022-06-02 15:38:57', 1, 1, 'n-gage', 'application/vnd.nokia.n-gage.symbian.install', 0, 'application'),
(34, NULL, '2022-06-02 15:38:57', 1, 1, 'pgp', 'application/pgp-encrypted', 0, 'application'),
(35, NULL, '2022-06-02 15:38:57', 1, 1, 'hdf', 'application/x-hdf', 0, 'application'),
(36, NULL, '2022-06-02 15:38:57', 1, 1, 'pnm', 'image/x-portable-anymap', 0, 'image'),
(37, NULL, '2022-06-02 15:38:57', 1, 1, 'm21', 'application/mp21', 0, 'application'),
(38, NULL, '2022-06-02 15:38:57', 1, 1, 'scq', 'application/scvp-cv-request', 0, 'application'),
(39, NULL, '2022-06-02 15:38:57', 1, 1, 'les', 'application/vnd.hhe.lesson-player', 0, 'application'),
(40, NULL, '2022-06-02 15:38:57', 1, 1, 'pgn', 'application/x-chess-pgn', 0, 'application'),
(41, NULL, '2022-06-02 15:38:57', 1, 1, 'cdmic', 'application/cdmi-container', 0, 'application'),
(42, NULL, '2022-06-02 15:38:57', 1, 1, 'fdf', 'application/vnd.fdf', 0, 'application'),
(43, NULL, '2022-06-02 15:38:57', 1, 1, 'uvp', 'video/vnd.dece.pd', 0, 'video'),
(44, NULL, '2022-06-02 15:38:57', 1, 1, 'fst', 'image/vnd.fst', 0, 'image'),
(45, NULL, '2022-06-02 15:38:57', 1, 1, 'cdmia', 'application/cdmi-capability', 0, 'application'),
(46, NULL, '2022-06-02 15:38:57', 1, 1, 'vcg', 'application/vnd.groove-vcard', 0, 'application'),
(47, NULL, '2022-06-02 15:38:57', 1, 1, 'vcf', 'text/x-vcard', 0, 'text'),
(48, NULL, '2022-06-02 15:38:57', 1, 1, 'vcd', 'application/x-cdlink', 0, 'application'),
(49, NULL, '2022-06-02 15:38:57', 1, 1, 'sgl', 'application/vnd.stardivision.writer-global', 0, 'application'),
(50, NULL, '2022-06-02 15:38:57', 1, 1, 'sgm', 'text/sgml', 0, 'text'),
(51, NULL, '2022-06-02 15:38:57', 1, 1, 'dssc', 'application/dssc+der', 0, 'application'),
(52, NULL, '2022-06-02 15:38:57', 1, 1, 'vcx', 'application/vnd.vcx', 0, 'application'),
(53, NULL, '2022-06-02 15:38:57', 1, 1, 'mods', 'application/mods+xml', 0, 'application'),
(54, NULL, '2022-06-02 15:38:57', 1, 1, 'org', 'application/vnd.lotus-organizer', 0, 'application'),
(55, NULL, '2022-06-02 15:38:57', 1, 1, 'xvm', 'application/xv+xml', 0, 'application'),
(56, NULL, '2022-06-02 15:38:57', 1, 1, 'vcs', 'text/x-vcalendar', 0, 'text'),
(57, NULL, '2022-06-02 15:38:57', 1, 1, 'roff', 'text/troff', 0, 'text'),
(58, NULL, '2022-06-02 15:38:57', 1, 1, 'cif', 'chemical/x-cif', 0, 'chemical'),
(59, NULL, '2022-06-02 15:38:57', 1, 1, 'grv', 'application/vnd.groove-injector', 0, 'application'),
(60, NULL, '2022-06-02 15:38:57', 1, 1, 'rif', 'application/reginfo+xml', 0, 'application'),
(61, NULL, '2022-06-02 15:38:57', 1, 1, 'cil', 'application/vnd.ms-artgalry', 0, 'application'),
(62, NULL, '2022-06-02 15:38:57', 1, 1, 'fig', 'application/x-xfig', 0, 'application'),
(63, NULL, '2022-06-02 15:38:57', 1, 1, 'cii', 'application/vnd.anser-web-certificate-issue-initiation', 0, 'application'),
(64, NULL, '2022-06-02 15:38:57', 1, 1, 'lostxml', 'application/lost+xml', 0, 'application'),
(65, NULL, '2022-06-02 15:38:57', 1, 1, 'gre', 'application/vnd.geometry-explorer', 0, 'application'),
(66, NULL, '2022-06-02 15:38:57', 1, 1, 'ivu', 'application/vnd.immervision-ivu', 0, 'application'),
(67, NULL, '2022-06-02 15:38:57', 1, 1, 'ivp', 'application/vnd.immervision-ivp', 0, 'application'),
(68, NULL, '2022-06-02 15:38:57', 1, 1, 'sitx', 'application/x-stuffitx', 0, 'application'),
(69, NULL, '2022-06-02 15:38:57', 1, 1, 'xyz', 'chemical/x-xyz', 0, 'chemical'),
(70, NULL, '2022-06-02 15:38:57', 1, 1, 'smil', 'application/smil+xml', 0, 'application'),
(71, NULL, '2022-06-02 15:38:57', 1, 1, 'jpgv', 'video/jpeg', 0, 'video'),
(72, NULL, '2022-06-02 15:38:57', 1, 1, 'bed', 'application/vnd.realvnc.bed', 0, 'application'),
(73, NULL, '2022-06-02 15:38:57', 1, 1, 'cmdf', 'chemical/x-cmdf', 0, 'chemical'),
(74, NULL, '2022-06-02 15:38:57', 1, 1, 'pskcxml', 'application/pskc+xml', 0, 'application'),
(75, NULL, '2022-06-02 15:38:57', 1, 1, 'lwp', 'application/vnd.lotus-wordpro', 0, 'application'),
(76, NULL, '2022-06-02 15:38:57', 1, 1, 'avi', 'video/x-msvideo', 0, 'video'),
(77, NULL, '2022-06-02 15:38:57', 1, 1, 'in', 'text/plain', 0, 'text'),
(78, NULL, '2022-06-02 15:38:57', 1, 1, 'ico', 'image/x-icon', 0, 'image'),
(79, NULL, '2022-06-02 15:38:57', 1, 1, 'saf', 'application/vnd.yamaha.smaf-audio', 0, 'application'),
(80, NULL, '2022-06-02 15:38:57', 1, 1, 'dist', 'application/octet-stream', 0, 'application'),
(81, NULL, '2022-06-02 15:38:57', 1, 1, 'sit', 'application/x-stuffit', 0, 'application'),
(82, NULL, '2022-06-02 15:38:57', 1, 1, 'z2', 'application/x-zmachine', 0, 'application'),
(83, NULL, '2022-06-02 15:38:57', 1, 1, 'z1', 'application/x-zmachine', 0, 'application'),
(84, NULL, '2022-06-02 15:38:57', 1, 1, 'z7', 'application/x-zmachine', 0, 'application'),
(85, NULL, '2022-06-02 15:38:57', 1, 1, 'crt', 'application/x-x509-ca-cert', 0, 'application'),
(86, NULL, '2022-06-02 15:38:57', 1, 1, 'z5', 'application/x-zmachine', 0, 'application'),
(87, NULL, '2022-06-02 15:38:57', 1, 1, 'sis', 'application/vnd.symbian.install', 0, 'application'),
(88, NULL, '2022-06-02 15:38:57', 1, 1, 'wbxml', 'application/vnd.wap.wbxml', 0, 'application'),
(89, NULL, '2022-06-02 15:38:57', 1, 1, 'z8', 'application/x-zmachine', 0, 'application'),
(90, NULL, '2022-06-02 15:38:57', 1, 1, 'weba', 'audio/webm', 0, 'audio'),
(91, NULL, '2022-06-02 15:38:57', 1, 1, 'dwg', 'image/vnd.dwg', 0, 'image'),
(92, NULL, '2022-06-02 15:38:57', 1, 1, 'sig', 'application/pgp-signature', 0, 'application'),
(93, NULL, '2022-06-02 15:38:57', 1, 1, 'aiff', 'audio/x-aiff', 0, 'audio'),
(94, NULL, '2022-06-02 15:38:57', 1, 1, 'crd', 'application/x-mscardfile', 0, 'application'),
(95, NULL, '2022-06-02 15:38:57', 1, 1, 'sil', 'audio/silk', 0, 'audio'),
(96, NULL, '2022-06-02 15:38:57', 1, 1, 'webm', 'video/webm', 0, 'video'),
(97, NULL, '2022-06-02 15:38:57', 1, 1, 'crl', 'application/pkix-crl', 0, 'application'),
(98, NULL, '2022-06-02 15:38:57', 1, 1, 'xla', 'application/vnd.ms-excel', 1, 'application'),
(99, NULL, '2022-06-02 15:38:57', 1, 1, 'ei6', 'application/vnd.pg.osasli', 0, 'application'),
(100, NULL, '2022-06-02 15:38:57', 1, 1, 'm1v', 'video/mpeg', 0, 'video'),
(101, NULL, '2022-06-02 15:38:57', 1, 1, 'yin', 'application/yin+xml', 0, 'application'),
(102, NULL, '2022-06-02 15:38:57', 1, 1, 'jnlp', 'application/x-java-jnlp-file', 0, 'application'),
(103, NULL, '2022-06-02 15:38:57', 1, 1, 'teacher', 'application/vnd.smart.teacher', 0, 'application'),
(104, NULL, '2022-06-02 15:38:57', 1, 1, 'xlc', 'application/vnd.ms-excel', 1, 'application'),
(105, NULL, '2022-06-02 15:38:57', 1, 1, 'pqa', 'application/vnd.palm', 0, 'application'),
(106, NULL, '2022-06-02 15:38:57', 1, 1, 'blb', 'application/x-blorb', 0, 'application'),
(107, NULL, '2022-06-02 15:38:57', 1, 1, 'h263', 'video/h263', 0, 'video'),
(108, NULL, '2022-06-02 15:38:57', 1, 1, 'oxps', 'application/oxps', 0, 'application'),
(109, NULL, '2022-06-02 15:38:57', 1, 1, 'h261', 'video/h261', 0, 'video'),
(110, NULL, '2022-06-02 15:38:57', 1, 1, 'dna', 'application/vnd.dna', 0, 'application'),
(111, NULL, '2022-06-02 15:38:57', 1, 1, 'onetoc2', 'application/onenote', 0, 'application'),
(112, NULL, '2022-06-02 15:38:57', 1, 1, 'omdoc', 'application/omdoc+xml', 0, 'application'),
(113, NULL, '2022-06-02 15:38:57', 1, 1, 'ods', 'application/vnd.oasis.opendocument.spreadsheet', 0, 'application'),
(114, NULL, '2022-06-02 15:38:57', 1, 1, 'odp', 'application/vnd.oasis.opendocument.presentation', 0, 'application'),
(115, NULL, '2022-06-02 15:38:57', 1, 1, 'pbd', 'application/vnd.powerbuilder6', 0, 'application'),
(116, NULL, '2022-06-02 15:38:57', 1, 1, 'odt', 'application/vnd.oasis.opendocument.text', 0, 'application'),
(117, NULL, '2022-06-02 15:38:57', 1, 1, 'sql', 'application/x-sql', 0, 'application'),
(118, NULL, '2022-06-02 15:38:57', 1, 1, 'odi', 'application/vnd.oasis.opendocument.image', 0, 'application'),
(119, NULL, '2022-06-02 15:38:57', 1, 1, 'daf', 'application/vnd.mobius.daf', 0, 'application'),
(120, NULL, '2022-06-02 15:38:57', 1, 1, 'odm', 'application/vnd.oasis.opendocument.text-master', 0, 'application'),
(121, NULL, '2022-06-02 15:38:57', 1, 1, 'odc', 'application/vnd.oasis.opendocument.chart', 0, 'application'),
(122, NULL, '2022-06-02 15:38:57', 1, 1, 'qwt', 'application/vnd.quark.quarkxpress', 0, 'application'),
(123, NULL, '2022-06-02 15:38:57', 1, 1, 'oda', 'application/oda', 0, 'application'),
(124, NULL, '2022-06-02 15:38:57', 1, 1, 'listafp', 'application/vnd.ibm.modcap', 0, 'application'),
(125, NULL, '2022-06-02 15:38:57', 1, 1, 'odg', 'application/vnd.oasis.opendocument.graphics', 0, 'application'),
(126, NULL, '2022-06-02 15:38:57', 1, 1, 'odf', 'application/vnd.oasis.opendocument.formula', 0, 'application'),
(127, NULL, '2022-06-02 15:38:57', 1, 1, 'vis', 'application/vnd.visionary', 0, 'application'),
(128, NULL, '2022-06-02 15:38:57', 1, 1, 'jam', 'application/vnd.jam', 0, 'application'),
(129, NULL, '2022-06-02 15:38:57', 1, 1, 'p10', 'application/pkcs10', 0, 'application'),
(130, NULL, '2022-06-02 15:38:57', 1, 1, 'cmc', 'application/vnd.cosmocaller', 0, 'application'),
(131, NULL, '2022-06-02 15:38:57', 1, 1, 'jad', 'text/vnd.sun.j2me.app-descriptor', 0, 'text'),
(132, NULL, '2022-06-02 15:38:57', 1, 1, 'jpgm', 'video/jpm', 0, 'video'),
(133, NULL, '2022-06-02 15:38:57', 1, 1, 'mjp2', 'video/mj2', 0, 'video'),
(134, NULL, '2022-06-02 15:38:57', 1, 1, 'gramps', 'application/x-gramps-xml', 0, 'application'),
(135, NULL, '2022-06-02 15:38:57', 1, 1, 'dtshd', 'audio/vnd.dts.hd', 0, 'audio'),
(136, NULL, '2022-06-02 15:38:57', 1, 1, 'mk3d', 'video/x-matroska', 0, 'video'),
(137, NULL, '2022-06-02 15:38:57', 1, 1, 'cct', 'application/x-director', 0, 'application'),
(138, NULL, '2022-06-02 15:38:57', 1, 1, 'gnumeric', 'application/x-gnumeric', 0, 'application'),
(139, NULL, '2022-06-02 15:38:57', 1, 1, '3dml', 'text/vnd.in3d.3dml', 0, 'text'),
(140, NULL, '2022-06-02 15:38:57', 1, 1, 'jar', 'application/java-archive', 0, 'application'),
(141, NULL, '2022-06-02 15:38:57', 1, 1, 'xslt', 'application/xslt+xml', 0, 'application'),
(142, NULL, '2022-06-02 15:38:57', 1, 1, 'ntf', 'application/vnd.nitf', 0, 'application'),
(143, NULL, '2022-06-02 15:38:57', 1, 1, 'uvx', 'application/vnd.dece.unspecified', 0, 'application'),
(144, NULL, '2022-06-02 15:38:57', 1, 1, 'uvs', 'video/vnd.dece.sd', 0, 'video'),
(145, NULL, '2022-06-02 15:38:57', 1, 1, 'dxp', 'application/vnd.spotfire.dxp', 0, 'application'),
(146, NULL, '2022-06-02 15:38:57', 1, 1, 'sh', 'application/x-sh', 0, 'application'),
(147, NULL, '2022-06-02 15:38:57', 1, 1, 'conf', 'text/plain', 0, 'text'),
(148, NULL, '2022-06-02 15:38:57', 1, 1, 'cla', 'application/vnd.claymore', 0, 'application'),
(149, NULL, '2022-06-02 15:38:57', 1, 1, 'uvt', 'application/vnd.dece.ttml+xml', 0, 'application'),
(150, NULL, '2022-06-02 15:38:57', 1, 1, 'dcurl', 'text/vnd.curl.dcurl', 0, 'text'),
(151, NULL, '2022-06-02 15:38:57', 1, 1, 'uvi', 'image/vnd.dece.graphic', 0, 'image'),
(152, NULL, '2022-06-02 15:38:57', 1, 1, 'uvh', 'video/vnd.dece.hd', 0, 'video'),
(153, NULL, '2022-06-02 15:38:57', 1, 1, 'uvm', 'video/vnd.dece.mobile', 0, 'video'),
(154, NULL, '2022-06-02 15:38:57', 1, 1, 'uva', 'audio/vnd.dece.audio', 0, 'audio'),
(155, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvu', 'video/vnd.uvvu.mp4', 0, 'video'),
(156, NULL, '2022-06-02 15:38:57', 1, 1, 'mrc', 'application/marc', 0, 'application'),
(157, NULL, '2022-06-02 15:38:57', 1, 1, 'uvf', 'application/vnd.dece.data', 0, 'application'),
(158, NULL, '2022-06-02 15:38:57', 1, 1, 'xltm', 'application/vnd.ms-excel.template.macroenabled.12', 1, 'application'),
(159, NULL, '2022-06-02 15:38:57', 1, 1, 'uvd', 'application/vnd.dece.data', 0, 'application'),
(160, NULL, '2022-06-02 15:38:57', 1, 1, 'mseed', 'application/vnd.fdsn.mseed', 0, 'application'),
(161, NULL, '2022-06-02 15:38:57', 1, 1, 'scs', 'application/scvp-cv-response', 0, 'application'),
(162, NULL, '2022-06-02 15:38:57', 1, 1, 'zaz', 'application/vnd.zzazz.deck+xml', 0, 'application'),
(163, NULL, '2022-06-02 15:38:57', 1, 1, 'lha', 'application/x-lzh-compressed', 0, 'application'),
(164, NULL, '2022-06-02 15:38:57', 1, 1, 'bz2', 'application/x-bzip2', 0, 'application'),
(165, NULL, '2022-06-02 15:38:57', 1, 1, 'setreg', 'application/set-registration-initiation', 0, 'application'),
(166, NULL, '2022-06-02 15:38:57', 1, 1, 'edm', 'application/vnd.novadigm.edm', 0, 'application'),
(167, NULL, '2022-06-02 15:38:57', 1, 1, 'link66', 'application/vnd.route66.link66+xml', 0, 'application'),
(168, NULL, '2022-06-02 15:38:57', 1, 1, 'gif', 'image/gif', 1, 'image'),
(169, NULL, '2022-06-02 15:38:57', 1, 1, 'scd', 'application/x-msschedule', 0, 'application'),
(170, NULL, '2022-06-02 15:38:57', 1, 1, 'edx', 'application/vnd.novadigm.edx', 0, 'application'),
(171, NULL, '2022-06-02 15:38:57', 1, 1, 'scurl', 'text/vnd.curl.scurl', 0, 'text'),
(172, NULL, '2022-06-02 15:38:57', 1, 1, 'scm', 'application/vnd.lotus-screencam', 0, 'application'),
(173, NULL, '2022-06-02 15:38:57', 1, 1, 'fcdt', 'application/vnd.adobe.formscentral.fcdt', 0, 'application'),
(174, NULL, '2022-06-02 15:38:57', 1, 1, 'eml', 'message/rfc822', 0, 'message'),
(175, NULL, '2022-06-02 15:38:57', 1, 1, 'kne', 'application/vnd.kinar', 0, 'application'),
(176, NULL, '2022-06-02 15:38:57', 1, 1, 'slt', 'application/vnd.epson.salt', 0, 'application'),
(177, NULL, '2022-06-02 15:38:57', 1, 1, 'emf', 'application/x-msmetafile', 0, 'application'),
(178, NULL, '2022-06-02 15:38:57', 1, 1, 'dxr', 'application/x-director', 0, 'application'),
(179, NULL, '2022-06-02 15:38:57', 1, 1, 'emz', 'application/x-msmetafile', 0, 'application'),
(180, NULL, '2022-06-02 15:38:57', 1, 1, 'wmv', 'video/x-ms-wmv', 0, 'video'),
(181, NULL, '2022-06-02 15:38:57', 1, 1, 'lvp', 'audio/vnd.lucent.voice', 0, 'audio'),
(182, NULL, '2022-06-02 15:38:57', 1, 1, 'irm', 'application/vnd.ibm.rights-management', 0, 'application'),
(183, NULL, '2022-06-02 15:38:57', 1, 1, 'trm', 'application/x-msterminal', 0, 'application'),
(184, NULL, '2022-06-02 15:38:57', 1, 1, 'bh2', 'application/vnd.fujitsu.oasysprs', 0, 'application'),
(185, NULL, '2022-06-02 15:38:57', 1, 1, 'dxf', 'image/vnd.dxf', 0, 'image'),
(186, NULL, '2022-06-02 15:38:57', 1, 1, 'wcm', 'application/vnd.ms-works', 0, 'application'),
(187, NULL, '2022-06-02 15:38:57', 1, 1, 'f90', 'text/x-fortran', 0, 'text'),
(188, NULL, '2022-06-02 15:38:57', 1, 1, 'knp', 'application/vnd.kinar', 0, 'application'),
(189, NULL, '2022-06-02 15:38:57', 1, 1, 'fxp', 'application/vnd.adobe.fxp', 0, 'application'),
(190, NULL, '2022-06-02 15:38:57', 1, 1, 'wmls', 'text/vnd.wap.wmlscript', 0, 'text'),
(191, NULL, '2022-06-02 15:38:57', 1, 1, 'wdb', 'application/vnd.ms-works', 0, 'application'),
(192, NULL, '2022-06-02 15:38:57', 1, 1, 'tra', 'application/vnd.trueapp', 0, 'application'),
(193, NULL, '2022-06-02 15:38:57', 1, 1, 'ssml', 'application/ssml+xml', 0, 'application'),
(194, NULL, '2022-06-02 15:38:57', 1, 1, 'g3', 'image/g3fax', 1, 'image'),
(195, NULL, '2022-06-02 15:38:57', 1, 1, 'dsc', 'text/prs.lines.tag', 0, 'text'),
(196, NULL, '2022-06-02 15:38:57', 1, 1, 'sid', 'image/x-mrsid-image', 0, 'image'),
(197, NULL, '2022-06-02 15:38:57', 1, 1, 'wmlc', 'application/vnd.wap.wmlc', 0, 'application'),
(198, NULL, '2022-06-02 15:38:57', 1, 1, 'mif', 'application/vnd.mif', 0, 'application'),
(199, NULL, '2022-06-02 15:38:57', 1, 1, 'wdp', 'image/vnd.ms-photo', 0, 'image'),
(200, NULL, '2022-06-02 15:38:57', 1, 1, 'bat', 'application/x-msdownload', 0, 'application'),
(201, NULL, '2022-06-02 15:38:57', 1, 1, 'mbox', 'application/mbox', 0, 'application'),
(202, NULL, '2022-06-02 15:38:57', 1, 1, 'rmvb', 'application/vnd.rn-realmedia-vbr', 0, 'application'),
(203, NULL, '2022-06-02 15:38:57', 1, 1, 'h', 'text/x-c', 0, 'text'),
(204, NULL, '2022-06-02 15:38:57', 1, 1, 'mie', 'application/x-mie', 0, 'application'),
(205, NULL, '2022-06-02 15:38:57', 1, 1, 'xul', 'application/vnd.mozilla.xul+xml', 0, 'application'),
(206, NULL, '2022-06-02 15:38:57', 1, 1, 'mka', 'audio/x-matroska', 0, 'audio'),
(207, NULL, '2022-06-02 15:38:57', 1, 1, 'umj', 'application/vnd.umajin', 0, 'application'),
(208, NULL, '2022-06-02 15:38:57', 1, 1, 'lzh', 'application/x-lzh-compressed', 0, 'application'),
(209, NULL, '2022-06-02 15:38:57', 1, 1, 'pre', 'application/vnd.lotus-freelance', 0, 'application'),
(210, NULL, '2022-06-02 15:38:57', 1, 1, 'prc', 'application/x-mobipocket-ebook', 0, 'application'),
(211, NULL, '2022-06-02 15:38:57', 1, 1, 'mks', 'video/x-matroska', 0, 'video'),
(212, NULL, '2022-06-02 15:38:57', 1, 1, 'mkv', 'video/x-matroska', 0, 'video'),
(213, NULL, '2022-06-02 15:38:57', 1, 1, 'm3u8', 'application/vnd.apple.mpegurl', 0, 'application'),
(214, NULL, '2022-06-02 15:38:57', 1, 1, 'pub', 'application/x-mspublisher', 0, 'application'),
(215, NULL, '2022-06-02 15:38:57', 1, 1, 'cpio', 'application/x-cpio', 0, 'application'),
(216, NULL, '2022-06-02 15:38:57', 1, 1, 'djv', 'image/vnd.djvu', 0, 'image'),
(217, NULL, '2022-06-02 15:38:57', 1, 1, 'mts', 'model/vnd.mts', 0, 'model'),
(218, NULL, '2022-06-02 15:38:57', 1, 1, 'c4p', 'application/vnd.clonk.c4group', 0, 'application'),
(219, NULL, '2022-06-02 15:38:57', 1, 1, 'nc', 'application/x-netcdf', 0, 'application'),
(220, NULL, '2022-06-02 15:38:57', 1, 1, 'mpga', 'audio/mpeg', 0, 'audio'),
(221, NULL, '2022-06-02 15:38:57', 1, 1, 'mobi', 'application/x-mobipocket-ebook', 0, 'application'),
(222, NULL, '2022-06-02 15:38:57', 1, 1, 'acu', 'application/vnd.acucobol', 0, 'application'),
(223, '', '2022-06-02 15:38:57', 1, 1, 'pdf', 'application/pdf', 1, 'application'),
(224, NULL, '2022-06-02 15:38:57', 1, 1, 'gxt', 'application/vnd.geonext', 0, 'application'),
(225, NULL, '2022-06-02 15:38:57', 1, 1, 'aifc', 'audio/x-aiff', 0, 'audio'),
(226, NULL, '2022-06-02 15:38:57', 1, 1, 'pdb', 'application/vnd.palm', 0, 'application'),
(227, NULL, '2022-06-02 15:38:57', 1, 1, 'mqy', 'application/vnd.mobius.mqy', 0, 'application'),
(228, NULL, '2022-06-02 15:38:57', 1, 1, 'arc', 'application/x-freearc', 0, 'application'),
(229, NULL, '2022-06-02 15:38:57', 1, 1, 'vsd', 'application/vnd.visio', 0, 'application'),
(230, NULL, '2022-06-02 15:38:57', 1, 1, 'ufdl', 'application/vnd.ufdl', 0, 'application'),
(231, NULL, '2022-06-02 15:38:57', 1, 1, 'i2g', 'application/vnd.intergeo', 0, 'application'),
(232, NULL, '2022-06-02 15:38:57', 1, 1, 'gram', 'application/srgs', 0, 'application'),
(233, NULL, '2022-06-02 15:38:57', 1, 1, 'sfv', 'text/x-sfv', 0, 'text'),
(234, NULL, '2022-06-02 15:38:57', 1, 1, 'sfs', 'application/vnd.spotfire.sfs', 0, 'application'),
(235, NULL, '2022-06-02 15:38:57', 1, 1, 'jsonml', 'application/jsonml+json', 0, 'application'),
(236, NULL, '2022-06-02 15:38:57', 1, 1, 'cod', 'application/vnd.rim.cod', 0, 'application'),
(237, NULL, '2022-06-02 15:38:57', 1, 1, 'x3d', 'model/x3d+xml', 0, 'model'),
(238, NULL, '2022-06-02 15:38:57', 1, 1, 'jpeg', 'image/jpeg', 1, 'image'),
(239, NULL, '2022-06-02 15:38:57', 1, 1, 'oprc', 'application/vnd.palm', 0, 'application'),
(240, NULL, '2022-06-02 15:38:57', 1, 1, 'p', 'text/x-pascal', 0, 'text'),
(241, NULL, '2022-06-02 15:38:57', 1, 1, 'fvt', 'video/vnd.fvt', 0, 'video'),
(242, NULL, '2022-06-02 15:38:57', 1, 1, 'zirz', 'application/vnd.zul', 0, 'application'),
(243, NULL, '2022-06-02 15:38:57', 1, 1, 'pgm', 'image/x-portable-graymap', 0, 'image'),
(244, NULL, '2022-06-02 15:38:57', 1, 1, 'dump', 'application/octet-stream', 0, 'application'),
(245, NULL, '2022-06-02 15:38:57', 1, 1, 'hpid', 'application/vnd.hp-hpid', 0, 'application'),
(246, NULL, '2022-06-02 15:38:57', 1, 1, 'ace', 'application/x-ace-compressed', 0, 'application'),
(247, NULL, '2022-06-02 15:38:57', 1, 1, 'c4u', 'application/vnd.clonk.c4group', 0, 'application'),
(248, NULL, '2022-06-02 15:38:57', 1, 1, 'mesh', 'model/mesh', 0, 'model'),
(249, NULL, '2022-06-02 15:38:57', 1, 1, 'rlc', 'image/vnd.fujixerox.edmics-rlc', 0, 'image'),
(250, NULL, '2022-06-02 15:38:57', 1, 1, 'lbd', 'application/vnd.llamagraphics.life-balance.desktop', 0, 'application'),
(251, NULL, '2022-06-02 15:38:57', 1, 1, 'com', 'application/x-msdownload', 0, 'application'),
(252, NULL, '2022-06-02 15:38:57', 1, 1, 'frame', 'application/vnd.framemaker', 0, 'application'),
(253, NULL, '2022-06-02 15:38:57', 1, 1, 'twd', 'application/vnd.simtech-mindmapper', 0, 'application'),
(254, NULL, '2022-06-02 15:38:57', 1, 1, 'djvu', 'image/vnd.djvu', 0, 'image'),
(255, NULL, '2022-06-02 15:38:57', 1, 1, 'gqs', 'application/vnd.grafeq', 0, 'application'),
(256, NULL, '2022-06-02 15:38:57', 1, 1, 'ptid', 'application/vnd.pvi.ptid1', 0, 'application'),
(257, NULL, '2022-06-02 15:38:57', 1, 1, 'gex', 'application/vnd.geometry-explorer', 0, 'application'),
(258, NULL, '2022-06-02 15:38:57', 1, 1, 'xdw', 'application/vnd.fujixerox.docuworks', 0, 'application'),
(259, NULL, '2022-06-02 15:38:57', 1, 1, 'xdp', 'application/vnd.adobe.xdp+xml', 0, 'application'),
(260, NULL, '2022-06-02 15:38:57', 1, 1, 'java', 'text/x-java-source', 0, 'text'),
(261, NULL, '2022-06-02 15:38:57', 1, 1, 'chm', 'application/vnd.ms-htmlhelp', 0, 'application'),
(262, NULL, '2022-06-02 15:38:57', 1, 1, 'xdm', 'application/vnd.syncml.dm+xml', 0, 'application'),
(263, NULL, '2022-06-02 15:38:57', 1, 1, 'uri', 'text/uri-list', 0, 'text'),
(264, NULL, '2022-06-02 15:38:57', 1, 1, 'gqf', 'application/vnd.grafeq', 0, 'application'),
(265, NULL, '2022-06-02 15:38:57', 1, 1, 'ggb', 'application/vnd.geogebra.file', 0, 'application'),
(266, NULL, '2022-06-02 15:38:57', 1, 1, 'mpg4', 'video/mp4', 0, 'video'),
(267, NULL, '2022-06-02 15:38:57', 1, 1, 'xdf', 'application/xcap-diff+xml', 0, 'application'),
(268, NULL, '2022-06-02 15:38:57', 1, 1, 'for', 'text/x-fortran', 0, 'text'),
(269, NULL, '2022-06-02 15:38:57', 1, 1, 'docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 1, 'application'),
(270, NULL, '2022-06-02 15:38:57', 1, 1, 'dfac', 'application/vnd.dreamfactory', 0, 'application'),
(271, NULL, '2022-06-02 15:38:57', 1, 1, 'silo', 'model/mesh', 0, 'model'),
(272, NULL, '2022-06-02 15:38:57', 1, 1, 'mlp', 'application/vnd.dolby.mlp', 0, 'application'),
(273, NULL, '2022-06-02 15:38:57', 1, 1, 'f4v', 'video/x-f4v', 0, 'video'),
(274, NULL, '2022-06-02 15:38:57', 1, 1, 'htke', 'application/vnd.kenameaapp', 0, 'application'),
(275, NULL, '2022-06-02 15:38:57', 1, 1, 'iges', 'model/iges', 0, 'model'),
(276, NULL, '2022-06-02 15:38:57', 1, 1, 'x32', 'application/x-authorware-bin', 0, 'application'),
(277, NULL, '2022-06-02 15:38:57', 1, 1, 'msh', 'model/mesh', 0, 'model'),
(278, NULL, '2022-06-02 15:38:57', 1, 1, 'docm', 'application/vnd.ms-word.document.macroenabled.12', 0, 'application'),
(279, NULL, '2022-06-02 15:38:57', 1, 1, 'xop', 'application/xop+xml', 0, 'application'),
(280, NULL, '2022-06-02 15:38:57', 1, 1, 'xenc', 'application/xenc+xml', 0, 'application'),
(281, NULL, '2022-06-02 15:38:57', 1, 1, 'install', 'application/x-install-instructions', 0, 'application'),
(282, NULL, '2022-06-02 15:38:57', 1, 1, 'ltf', 'application/vnd.frogans.ltf', 0, 'application'),
(283, NULL, '2022-06-02 15:38:57', 1, 1, 'nlu', 'application/vnd.neurolanguage.nlu', 0, 'application'),
(284, NULL, '2022-06-02 15:38:57', 1, 1, 'mc1', 'application/vnd.medcalcdata', 0, 'application'),
(285, NULL, '2022-06-02 15:38:57', 1, 1, 'dts', 'audio/vnd.dts', 0, 'audio'),
(286, NULL, '2022-06-02 15:38:57', 1, 1, 'xspf', 'application/xspf+xml', 0, 'application'),
(287, NULL, '2022-06-02 15:38:57', 1, 1, 'gca', 'application/x-gca-compressed', 0, 'application'),
(288, NULL, '2022-06-02 15:38:57', 1, 1, 'latex', 'application/x-latex', 0, 'application'),
(289, NULL, '2022-06-02 15:38:57', 1, 1, 'sldx', 'application/vnd.openxmlformats-officedocument.presentationml.slide', 1, 'application'),
(290, NULL, '2022-06-02 15:38:57', 1, 1, 'bz', 'application/x-bzip', 0, 'application'),
(291, NULL, '2022-06-02 15:38:57', 1, 1, 'm14', 'application/x-msmediaview', 0, 'application'),
(292, NULL, '2022-06-02 15:38:57', 1, 1, 'xbm', 'image/x-xbitmap', 0, 'image'),
(293, NULL, '2022-06-02 15:38:57', 1, 1, 'c4f', 'application/vnd.clonk.c4group', 0, 'application'),
(294, NULL, '2022-06-02 15:38:57', 1, 1, 'm13', 'application/x-msmediaview', 0, 'application'),
(295, NULL, '2022-06-02 15:38:57', 1, 1, 'uvv', 'video/vnd.dece.video', 0, 'video'),
(296, NULL, '2022-06-02 15:38:57', 1, 1, 'sldm', 'application/vnd.ms-powerpoint.slide.macroenabled.12', 0, 'application'),
(297, NULL, '2022-06-02 15:38:57', 1, 1, 'igx', 'application/vnd.micrografx.igx', 0, 'application'),
(298, NULL, '2022-06-02 15:38:57', 1, 1, 'class', 'application/java-vm', 0, 'application'),
(299, NULL, '2022-06-02 15:38:57', 1, 1, 'setpay', 'application/set-payment-initiation', 0, 'application'),
(300, NULL, '2022-06-02 15:38:57', 1, 1, 'skd', 'application/vnd.koan', 0, 'application'),
(301, NULL, '2022-06-02 15:38:57', 1, 1, 'bmp', 'image/bmp', 1, 'image'),
(302, NULL, '2022-06-02 15:38:57', 1, 1, 'x3dbz', 'model/x3d+binary', 0, 'model'),
(303, NULL, '2022-06-02 15:38:57', 1, 1, 'pvb', 'application/vnd.3gpp.pic-bw-var', 0, 'application'),
(304, NULL, '2022-06-02 15:38:57', 1, 1, 'dot', 'application/msword', 1, 'application'),
(305, NULL, '2022-06-02 15:38:57', 1, 1, 'eva', 'application/x-eva', 0, 'application'),
(306, NULL, '2022-06-02 15:38:57', 1, 1, 'igs', 'model/iges', 0, 'model'),
(307, NULL, '2022-06-02 15:38:57', 1, 1, 'fsc', 'application/vnd.fsc.weblaunch', 0, 'application'),
(308, NULL, '2022-06-02 15:38:57', 1, 1, 'p8', 'application/pkcs8', 0, 'application'),
(309, NULL, '2022-06-02 15:38:57', 1, 1, 'itp', 'application/vnd.shana.informed.formtemplate', 0, 'application'),
(310, NULL, '2022-06-02 15:38:57', 1, 1, 'nsf', 'application/vnd.lotus-notes', 0, 'application'),
(311, NULL, '2022-06-02 15:38:57', 1, 1, 'evy', 'application/x-envoy', 0, 'application'),
(312, NULL, '2022-06-02 15:38:57', 1, 1, 'nsc', 'application/x-conference', 0, 'application'),
(313, NULL, '2022-06-02 15:38:57', 1, 1, 'bcpio', 'application/x-bcpio', 0, 'application'),
(314, NULL, '2022-06-02 15:38:57', 1, 1, 'dll', 'application/x-msdownload', 0, 'application'),
(315, NULL, '2022-06-02 15:38:57', 1, 1, 'uris', 'text/uri-list', 0, 'text'),
(316, NULL, '2022-06-02 15:38:57', 1, 1, 'mp2a', 'audio/mpeg', 0, 'audio'),
(317, NULL, '2022-06-02 15:38:57', 1, 1, 'bmi', 'application/vnd.bmi', 0, 'application'),
(318, NULL, '2022-06-02 15:38:57', 1, 1, 'ahead', 'application/vnd.ahead.space', 0, 'application'),
(319, NULL, '2022-06-02 15:38:57', 1, 1, 'doc', 'application/msword', 1, 'application'),
(320, NULL, '2022-06-02 15:38:57', 1, 1, 'texinfo', 'application/x-texinfo', 0, 'application'),
(321, NULL, '2022-06-02 15:38:57', 1, 1, 'nzb', 'application/x-nzb', 0, 'application'),
(322, NULL, '2022-06-02 15:38:57', 1, 1, 'qxb', 'application/vnd.quark.quarkxpress', 0, 'application'),
(323, NULL, '2022-06-02 15:38:57', 1, 1, 'wqd', 'application/vnd.wqd', 0, 'application'),
(324, NULL, '2022-06-02 15:38:57', 1, 1, 'qxd', 'application/vnd.quark.quarkxpress', 0, 'application'),
(325, NULL, '2022-06-02 15:38:57', 1, 1, 'mov', 'video/quicktime', 0, 'video'),
(326, NULL, '2022-06-02 15:38:57', 1, 1, 'sgi', 'image/sgi', 1, 'image'),
(327, NULL, '2022-06-02 15:38:57', 1, 1, 'qxl', 'application/vnd.quark.quarkxpress', 0, 'application'),
(328, NULL, '2022-06-02 15:38:57', 1, 1, 'distz', 'application/octet-stream', 0, 'application'),
(329, NULL, '2022-06-02 15:38:57', 1, 1, 'cpp', 'text/x-c', 0, 'text'),
(330, NULL, '2022-06-02 15:38:57', 1, 1, 'qxt', 'application/vnd.quark.quarkxpress', 0, 'application'),
(331, NULL, '2022-06-02 15:38:57', 1, 1, 'twds', 'application/vnd.simtech-mindmapper', 0, 'application'),
(332, NULL, '2022-06-02 15:38:57', 1, 1, 'xht', 'application/xhtml+xml', 0, 'application'),
(333, NULL, '2022-06-02 15:38:57', 1, 1, 'ifm', 'application/vnd.shana.informed.formdata', 0, 'application'),
(334, NULL, '2022-06-02 15:38:57', 1, 1, 'gdl', 'model/vnd.gdl', 0, 'model'),
(335, NULL, '2022-06-02 15:38:57', 1, 1, 'mdi', 'image/vnd.ms-modi', 0, 'image'),
(336, NULL, '2022-06-02 15:38:57', 1, 1, 'prf', 'application/pics-rules', 0, 'application'),
(337, NULL, '2022-06-02 15:38:57', 1, 1, 'z6', 'application/x-zmachine', 0, 'application'),
(338, NULL, '2022-06-02 15:38:57', 1, 1, 'ps', 'application/postscript', 0, 'application'),
(339, NULL, '2022-06-02 15:38:57', 1, 1, 'lbe', 'application/vnd.llamagraphics.life-balance.exchange+xml', 0, 'application'),
(340, NULL, '2022-06-02 15:38:57', 1, 1, 'mdb', 'application/x-msaccess', 0, 'application'),
(341, NULL, '2022-06-02 15:38:57', 1, 1, 'ecelp9600', 'audio/vnd.nuera.ecelp9600', 0, 'audio'),
(342, NULL, '2022-06-02 15:38:57', 1, 1, 'mp4', 'video/mp4', 0, 'video'),
(343, NULL, '2022-06-02 15:38:57', 1, 1, 'pic', 'image/x-pict', 0, 'image'),
(344, NULL, '2022-06-02 15:38:57', 1, 1, 'vob', 'video/x-ms-vob', 0, 'video'),
(345, NULL, '2022-06-02 15:38:57', 1, 1, 'html', 'text/html', 0, 'text'),
(346, NULL, '2022-06-02 15:38:57', 1, 1, 'xbap', 'application/x-ms-xbap', 0, 'application'),
(347, NULL, '2022-06-02 15:38:57', 1, 1, 'kmz', 'application/vnd.google-earth.kmz', 0, 'application'),
(348, NULL, '2022-06-02 15:38:57', 1, 1, 'torrent', 'application/x-bittorrent', 0, 'application'),
(349, NULL, '2022-06-02 15:38:57', 1, 1, 'rmp', 'audio/x-pn-realaudio-plugin', 0, 'audio'),
(350, NULL, '2022-06-02 15:38:57', 1, 1, 'qfx', 'application/vnd.intu.qfx', 0, 'application'),
(351, NULL, '2022-06-02 15:38:57', 1, 1, 'txd', 'application/vnd.genomatix.tuxedo', 0, 'application'),
(352, NULL, '2022-06-02 15:38:57', 1, 1, 'mus', 'application/vnd.musician', 0, 'application'),
(353, NULL, '2022-06-02 15:38:57', 1, 1, 'txf', 'application/vnd.mobius.txf', 0, 'application'),
(354, NULL, '2022-06-02 15:38:57', 1, 1, 'x3db', 'model/x3d+binary', 0, 'model'),
(355, NULL, '2022-06-02 15:38:57', 1, 1, 'xar', 'application/vnd.xara', 0, 'application'),
(356, NULL, '2022-06-02 15:38:57', 1, 1, 'x3dz', 'model/x3d+xml', 0, 'model'),
(357, NULL, '2022-06-02 15:38:57', 1, 1, 'xap', 'application/x-silverlight-app', 0, 'application'),
(358, NULL, '2022-06-02 15:38:57', 1, 1, 'nbp', 'application/vnd.wolfram.player', 0, 'application'),
(359, NULL, '2022-06-02 15:38:57', 1, 1, 'x3dv', 'model/x3d+vrml', 0, 'model'),
(360, NULL, '2022-06-02 15:38:57', 1, 1, 'clkx', 'application/vnd.crick.clicker', 0, 'application'),
(361, NULL, '2022-06-02 15:38:57', 1, 1, 'lnk', 'application/x-ms-shortcut', 0, 'application'),
(362, NULL, '2022-06-02 15:38:57', 1, 1, 'clkw', 'application/vnd.crick.clicker.wordbank', 0, 'application'),
(363, NULL, '2022-06-02 15:38:57', 1, 1, 'clkt', 'application/vnd.crick.clicker.template', 0, 'application'),
(364, NULL, '2022-06-02 15:38:57', 1, 1, 'p7m', 'application/pkcs7-mime', 0, 'application'),
(365, NULL, '2022-06-02 15:38:57', 1, 1, 'atc', 'application/vnd.acucorp', 0, 'application'),
(366, NULL, '2022-06-02 15:38:57', 1, 1, 'clkp', 'application/vnd.crick.clicker.palette', 0, 'application'),
(367, NULL, '2022-06-02 15:38:57', 1, 1, 'semd', 'application/vnd.semd', 0, 'application'),
(368, NULL, '2022-06-02 15:38:57', 1, 1, 'p7c', 'application/pkcs7-mime', 0, 'application'),
(369, NULL, '2022-06-02 15:38:57', 1, 1, 'p7b', 'application/x-pkcs7-certificates', 0, 'application'),
(370, NULL, '2022-06-02 15:38:57', 1, 1, 'blorb', 'application/x-blorb', 0, 'application'),
(371, NULL, '2022-06-02 15:38:57', 1, 1, 'mpg', 'video/mpeg', 0, 'video'),
(372, NULL, '2022-06-02 15:38:57', 1, 1, 'swf', 'application/x-shockwave-flash', 0, 'application'),
(373, NULL, '2022-06-02 15:38:57', 1, 1, 'epub', 'application/epub+zip', 0, 'application'),
(374, NULL, '2022-06-02 15:38:57', 1, 1, 'cdxml', 'application/vnd.chemdraw+xml', 0, 'application'),
(375, NULL, '2022-06-02 15:38:57', 1, 1, 'p7r', 'application/x-pkcs7-certreqresp', 0, 'application'),
(376, NULL, '2022-06-02 15:38:57', 1, 1, 'clkk', 'application/vnd.crick.clicker.keyboard', 0, 'application'),
(377, NULL, '2022-06-02 15:38:57', 1, 1, 'atx', 'application/vnd.antix.game-component', 0, 'application'),
(378, NULL, '2022-06-02 15:38:57', 1, 1, 'ac', 'application/pkix-attr-cert', 0, 'application'),
(379, NULL, '2022-06-02 15:38:57', 1, 1, 'kml', 'application/vnd.google-earth.kml+xml', 0, 'application'),
(380, NULL, '2022-06-02 15:38:57', 1, 1, 'wbs', 'application/vnd.criticaltools.wbs+xml', 0, 'application'),
(381, NULL, '2022-06-02 15:38:57', 1, 1, 'elc', 'application/octet-stream', 0, 'application'),
(382, NULL, '2022-06-02 15:38:57', 1, 1, 'ai', 'application/postscript', 0, 'application'),
(383, NULL, '2022-06-02 15:38:57', 1, 1, 'gv', 'text/vnd.graphviz', 0, 'text'),
(384, NULL, '2022-06-02 15:38:57', 1, 1, 'skt', 'application/vnd.koan', 0, 'application'),
(385, NULL, '2022-06-02 15:38:57', 1, 1, 'tsv', 'text/tab-separated-values', 0, 'text'),
(386, NULL, '2022-06-02 15:38:57', 1, 1, 'fe_launch', 'application/vnd.denovo.fcselayout-link', 0, 'application'),
(387, NULL, '2022-06-02 15:38:57', 1, 1, 'aw', 'application/applixware', 0, 'application'),
(388, NULL, '2022-06-02 15:38:57', 1, 1, 'mvb', 'application/x-msmediaview', 0, 'application'),
(389, NULL, '2022-06-02 15:38:57', 1, 1, 'skm', 'application/vnd.koan', 0, 'application'),
(390, NULL, '2022-06-02 15:38:57', 1, 1, 'p7s', 'application/pkcs7-signature', 0, 'application'),
(391, NULL, '2022-06-02 15:38:57', 1, 1, 'ott', 'application/vnd.oasis.opendocument.text-template', 0, 'application'),
(392, NULL, '2022-06-02 15:38:57', 1, 1, 'jpe', 'image/jpeg', 1, 'image'),
(393, NULL, '2022-06-02 15:38:57', 1, 1, 'dpg', 'application/vnd.dpgraph', 0, 'application'),
(394, NULL, '2022-06-02 15:38:57', 1, 1, 'npx', 'image/vnd.net-fpx', 0, 'image'),
(395, NULL, '2022-06-02 15:38:57', 1, 1, 'psb', 'application/vnd.3gpp.pic-bw-small', 0, 'application'),
(396, NULL, '2022-06-02 15:38:57', 1, 1, 'gph', 'application/vnd.flographit', 0, 'application'),
(397, NULL, '2022-06-02 15:38:57', 1, 1, 'mwf', 'application/vnd.mfer', 0, 'application'),
(398, NULL, '2022-06-02 15:38:57', 1, 1, 'mads', 'application/mads+xml', 0, 'application'),
(399, NULL, '2022-06-02 15:38:57', 1, 1, 'xsm', 'application/vnd.syncml+xml', 0, 'application'),
(400, NULL, '2022-06-02 15:38:57', 1, 1, 'xsl', 'application/xml', 0, 'application'),
(401, NULL, '2022-06-02 15:38:57', 1, 1, 'sbml', 'application/sbml+xml', 0, 'application'),
(402, NULL, '2022-06-02 15:38:57', 1, 1, 'json', 'application/json', 0, 'application'),
(403, NULL, '2022-06-02 15:38:57', 1, 1, 'cdkey', 'application/vnd.mediastation.cdkey', 0, 'application'),
(404, NULL, '2022-06-02 15:38:57', 1, 1, 'pclxl', 'application/vnd.hp-pclxl', 0, 'application'),
(405, NULL, '2022-06-02 15:38:57', 1, 1, 'sisx', 'application/vnd.symbian.install', 0, 'application'),
(406, NULL, '2022-06-02 15:38:57', 1, 1, 'icm', 'application/vnd.iccprofile', 0, 'application'),
(407, NULL, '2022-06-02 15:38:57', 1, 1, 'xls', 'application/vnd.ms-excel', 1, 'application'),
(408, NULL, '2022-06-02 15:38:57', 1, 1, 'bin', 'application/octet-stream', 0, 'application'),
(409, NULL, '2022-06-02 15:38:57', 1, 1, 'ice', 'x-conference/x-cooltalk', 0, 'x-conference'),
(410, NULL, '2022-06-02 15:38:57', 1, 1, 'asc', 'application/pgp-signature', 0, 'application'),
(411, NULL, '2022-06-02 15:38:57', 1, 1, 'src', 'application/x-wais-source', 0, 'application'),
(412, NULL, '2022-06-02 15:38:57', 1, 1, 'ggt', 'application/vnd.geogebra.tool', 0, 'application'),
(413, NULL, '2022-06-02 15:38:57', 1, 1, 'icc', 'application/vnd.iccprofile', 0, 'application'),
(414, NULL, '2022-06-02 15:38:57', 1, 1, 'psd', 'image/vnd.adobe.photoshop', 0, 'image'),
(415, NULL, '2022-06-02 15:38:57', 1, 1, 'psf', 'application/x-font-linux-psf', 0, 'application'),
(416, NULL, '2022-06-02 15:38:57', 1, 1, 'cc', 'text/x-c', 0, 'text'),
(417, NULL, '2022-06-02 15:38:57', 1, 1, 'sfd-hdstx', 'application/vnd.hydrostatix.sof-data', 0, 'application'),
(418, NULL, '2022-06-02 15:38:57', 1, 1, 'vsw', 'application/vnd.visio', 0, 'application'),
(419, NULL, '2022-06-02 15:38:57', 1, 1, 'chat', 'application/x-chat', 0, 'application'),
(420, NULL, '2022-06-02 15:38:57', 1, 1, 'kfo', 'application/vnd.kde.kformula', 0, 'application'),
(421, NULL, '2022-06-02 15:38:57', 1, 1, 'hps', 'application/vnd.hp-hps', 0, 'application'),
(422, NULL, '2022-06-02 15:38:57', 1, 1, 'ics', 'text/calendar', 0, 'text'),
(423, NULL, '2022-06-02 15:38:57', 1, 1, 'hpgl', 'application/vnd.hp-hpgl', 0, 'application'),
(424, NULL, '2022-06-02 15:38:57', 1, 1, 'ami', 'application/vnd.amiga.ami', 0, 'application'),
(425, NULL, '2022-06-02 15:38:57', 1, 1, 'mng', 'video/x-mng', 0, 'video'),
(426, NULL, '2022-06-02 15:38:57', 1, 1, 'txt', 'text/plain', 0, 'text'),
(427, NULL, '2022-06-02 15:38:57', 1, 1, 'rpst', 'application/vnd.nokia.radio-preset', 0, 'application'),
(428, NULL, '2022-06-02 15:38:57', 1, 1, 't3', 'application/x-t3vm-image', 0, 'application'),
(429, NULL, '2022-06-02 15:38:57', 1, 1, 'fm', 'application/vnd.framemaker', 0, 'application'),
(430, NULL, '2022-06-02 15:38:57', 1, 1, 'curl', 'text/vnd.curl', 0, 'text'),
(431, NULL, '2022-06-02 15:38:57', 1, 1, 'skp', 'application/vnd.koan', 0, 'application'),
(432, NULL, '2022-06-02 15:38:57', 1, 1, 'fh', 'image/x-freehand', 0, 'image'),
(433, NULL, '2022-06-02 15:38:57', 1, 1, 'stf', 'application/vnd.wt.stf', 0, 'application'),
(434, NULL, '2022-06-02 15:38:57', 1, 1, 'std', 'application/vnd.sun.xml.draw.template', 0, 'application'),
(435, NULL, '2022-06-02 15:38:57', 1, 1, 'stc', 'application/vnd.sun.xml.calc.template', 0, 'application'),
(436, NULL, '2022-06-02 15:38:57', 1, 1, 'ogg', 'audio/ogg', 0, 'audio'),
(437, NULL, '2022-06-02 15:38:57', 1, 1, 'pml', 'application/vnd.ctc-posml', 0, 'application'),
(438, NULL, '2022-06-02 15:38:57', 1, 1, 'book', 'application/vnd.framemaker', 0, 'application'),
(439, NULL, '2022-06-02 15:38:57', 1, 1, 'stl', 'application/vnd.ms-pki.stl', 0, 'application'),
(440, NULL, '2022-06-02 15:38:57', 1, 1, 'stk', 'application/hyperstudio', 0, 'application'),
(441, NULL, '2022-06-02 15:38:57', 1, 1, 'sti', 'application/vnd.sun.xml.impress.template', 0, 'application'),
(442, NULL, '2022-06-02 15:38:57', 1, 1, 'fnc', 'application/vnd.frogans.fnc', 0, 'application'),
(443, NULL, '2022-06-02 15:38:57', 1, 1, 'stw', 'application/vnd.sun.xml.writer.template', 0, 'application'),
(444, NULL, '2022-06-02 15:38:57', 1, 1, 'dbk', 'application/docbook+xml', 0, 'application'),
(445, NULL, '2022-06-02 15:38:57', 1, 1, 'mcd', 'application/vnd.mcd', 0, 'application'),
(446, NULL, '2022-06-02 15:38:57', 1, 1, 'str', 'application/vnd.pg.format', 0, 'application'),
(447, NULL, '2022-06-02 15:38:57', 1, 1, 'movie', 'video/x-sgi-movie', 0, 'video'),
(448, NULL, '2022-06-02 15:38:57', 1, 1, 'bpk', 'application/octet-stream', 0, 'application'),
(449, NULL, '2022-06-02 15:38:57', 1, 1, 'ogx', 'application/ogg', 0, 'application'),
(450, NULL, '2022-06-02 15:38:57', 1, 1, 'mcurl', 'text/vnd.curl.mcurl', 0, 'text'),
(451, NULL, '2022-06-02 15:38:57', 1, 1, 'pya', 'audio/vnd.ms-playready.media.pya', 0, 'audio'),
(452, NULL, '2022-06-02 15:38:57', 1, 1, 'wbmp', 'image/vnd.wap.wbmp', 0, 'image'),
(453, NULL, '2022-06-02 15:38:57', 1, 1, 'tei', 'application/tei+xml', 0, 'application'),
(454, NULL, '2022-06-02 15:38:57', 1, 1, 'mxu', 'video/vnd.mpegurl', 0, 'video'),
(455, NULL, '2022-06-02 15:38:57', 1, 1, 'n3', 'text/n3', 0, 'text'),
(456, NULL, '2022-06-02 15:38:57', 1, 1, 'mets', 'application/mets+xml', 0, 'application'),
(457, NULL, '2022-06-02 15:38:57', 1, 1, 'ez3', 'application/vnd.ezpix-package', 0, 'application'),
(458, NULL, '2022-06-02 15:38:57', 1, 1, 'rep', 'application/vnd.businessobjects', 0, 'application'),
(459, NULL, '2022-06-02 15:38:57', 1, 1, 'res', 'application/x-dtbresource+xml', 0, 'application'),
(460, NULL, '2022-06-02 15:38:57', 1, 1, 'ssdl', 'application/ssdl+xml', 0, 'application'),
(461, NULL, '2022-06-02 15:38:57', 1, 1, 'mxl', 'application/vnd.recordare.musicxml', 0, 'application'),
(462, NULL, '2022-06-02 15:38:57', 1, 1, 'tr', 'text/troff', 0, 'text'),
(463, NULL, '2022-06-02 15:38:57', 1, 1, 'seed', 'application/vnd.fdsn.seed', 0, 'application'),
(464, NULL, '2022-06-02 15:38:57', 1, 1, 'tex', 'application/x-tex', 0, 'application'),
(465, NULL, '2022-06-02 15:38:57', 1, 1, 'mxf', 'application/mxf', 0, 'application'),
(466, NULL, '2022-06-02 15:38:57', 1, 1, 'cfs', 'application/x-cfs-compressed', 0, 'application'),
(467, NULL, '2022-06-02 15:38:57', 1, 1, 'snd', 'audio/basic', 0, 'audio'),
(468, NULL, '2022-06-02 15:38:57', 1, 1, 'snf', 'application/x-font-snf', 0, 'application'),
(469, NULL, '2022-06-02 15:38:57', 1, 1, 'wmx', 'video/x-ms-wmx', 0, 'video'),
(470, NULL, '2022-06-02 15:38:57', 1, 1, 'wmz', 'application/x-msmetafile', 0, 'application'),
(471, NULL, '2022-06-02 15:38:57', 1, 1, 'gxf', 'application/gxf', 0, 'application'),
(472, NULL, '2022-06-02 15:38:57', 1, 1, 'grxml', 'application/srgs+xml', 0, 'application'),
(473, NULL, '2022-06-02 15:38:57', 1, 1, 'xer', 'application/patch-ops-error+xml', 0, 'application'),
(474, NULL, '2022-06-02 15:38:57', 1, 1, 'ipk', 'application/vnd.shana.informed.package', 0, 'application'),
(475, NULL, '2022-06-02 15:38:57', 1, 1, 'au', 'audio/basic', 0, 'audio'),
(476, NULL, '2022-06-02 15:38:57', 1, 1, 'ttl', 'text/turtle', 0, 'text'),
(477, NULL, '2022-06-02 15:38:57', 1, 1, 'inkml', 'application/inkml+xml', 0, 'application'),
(478, NULL, '2022-06-02 15:38:57', 1, 1, 'wml', 'text/vnd.wap.wml', 0, 'text'),
(479, NULL, '2022-06-02 15:38:57', 1, 1, 'nfo', 'text/x-nfo', 0, 'text'),
(480, NULL, '2022-06-02 15:38:57', 1, 1, 'wmd', 'application/x-ms-wmd', 0, 'application'),
(481, NULL, '2022-06-02 15:38:57', 1, 1, 'wmf', 'application/x-msmetafile', 0, 'application'),
(482, NULL, '2022-06-02 15:38:57', 1, 1, 'cdbcmsg', 'application/vnd.contact.cmsg', 0, 'application'),
(483, NULL, '2022-06-02 15:38:57', 1, 1, 'qbo', 'application/vnd.intu.qbo', 0, 'application'),
(484, NULL, '2022-06-02 15:38:57', 1, 1, 'wma', 'audio/x-ms-wma', 0, 'audio'),
(485, NULL, '2022-06-02 15:38:57', 1, 1, 'lasxml', 'application/vnd.las.las+xml', 0, 'application'),
(486, NULL, '2022-06-02 15:38:57', 1, 1, 'js', 'application/javascript', 0, 'application'),
(487, NULL, '2022-06-02 15:38:57', 1, 1, 'xlf', 'application/x-xliff+xml', 0, 'application'),
(488, NULL, '2022-06-02 15:38:57', 1, 1, 'nml', 'application/vnd.enliven', 0, 'application'),
(489, NULL, '2022-06-02 15:38:57', 1, 1, 'c11amc', 'application/vnd.cluetrust.cartomobile-Something is wrong', 0, 'application'),
(490, NULL, '2022-06-02 15:38:57', 1, 1, 'xlm', 'application/vnd.ms-excel', 1, 'application'),
(491, NULL, '2022-06-02 15:38:57', 1, 1, 'apr', 'application/vnd.lotus-approach', 0, 'application'),
(492, NULL, '2022-06-02 15:38:57', 1, 1, 'vrml', 'model/vrml', 0, 'model'),
(493, NULL, '2022-06-02 15:38:57', 1, 1, 'tsd', 'application/timestamped-data', 0, 'application'),
(494, NULL, '2022-06-02 15:38:57', 1, 1, 'xlt', 'application/vnd.ms-excel', 1, 'application'),
(495, NULL, '2022-06-02 15:38:57', 1, 1, 'apk', 'application/vnd.android.package-archive', 0, 'application'),
(496, NULL, '2022-06-02 15:38:57', 1, 1, 'xlw', 'application/vnd.ms-excel', 1, 'application'),
(497, NULL, '2022-06-02 15:38:57', 1, 1, 'gim', 'application/vnd.groove-identity-message', 0, 'application'),
(498, NULL, '2022-06-02 15:38:57', 1, 1, 'xvml', 'application/xv+xml', 0, 'application'),
(499, NULL, '2022-06-02 15:38:57', 1, 1, 'xfdf', 'application/vnd.adobe.xfdf', 0, 'application'),
(500, NULL, '2022-06-02 15:38:57', 1, 1, 'f77', 'text/x-fortran', 0, 'text'),
(501, NULL, '2022-06-02 15:38:57', 1, 1, 'xdssc', 'application/dssc+xml', 0, 'application'),
(502, NULL, '2022-06-02 15:38:57', 1, 1, 'xfdl', 'application/vnd.xfdl', 0, 'application'),
(503, NULL, '2022-06-02 15:38:57', 1, 1, 'c11amz', 'application/vnd.cluetrust.cartomobile-Something is wrong-pkg', 0, 'application'),
(504, NULL, '2022-06-02 15:38:57', 1, 1, 'cpt', 'application/mac-compactpro', 0, 'application'),
(505, NULL, '2022-06-02 15:38:57', 1, 1, 'ait', 'application/vnd.dvb.ait', 0, 'application'),
(506, NULL, '2022-06-02 15:38:57', 1, 1, 'davmount', 'application/davmount+xml', 0, 'application'),
(507, NULL, '2022-06-02 15:38:57', 1, 1, 'rtf', 'application/rtf', 0, 'application'),
(508, NULL, '2022-06-02 15:38:57', 1, 1, 'mid', 'audio/midi', 0, 'audio'),
(509, NULL, '2022-06-02 15:38:57', 1, 1, 'vst', 'application/vnd.visio', 0, 'application'),
(510, NULL, '2022-06-02 15:38:57', 1, 1, 'vss', 'application/vnd.visio', 0, 'application'),
(511, NULL, '2022-06-02 15:38:57', 1, 1, 'eps', 'application/postscript', 0, 'application'),
(512, NULL, '2022-06-02 15:38:57', 1, 1, 'rld', 'application/resource-lists-diff+xml', 0, 'application'),
(513, NULL, '2022-06-02 15:38:57', 1, 1, 'onetoc', 'application/onenote', 0, 'application'),
(514, NULL, '2022-06-02 15:38:57', 1, 1, 'ez', 'application/andrew-inset', 0, 'application'),
(515, NULL, '2022-06-02 15:38:57', 1, 1, 'rtx', 'text/richtext', 0, 'text'),
(516, NULL, '2022-06-02 15:38:57', 1, 1, 'gbr', 'application/rpki-ghostbusters', 0, 'application'),
(517, NULL, '2022-06-02 15:38:57', 1, 1, 'uvg', 'image/vnd.dece.graphic', 0, 'image'),
(518, NULL, '2022-06-02 15:38:57', 1, 1, 'vsf', 'application/vnd.vsf', 0, 'application'),
(519, NULL, '2022-06-02 15:38:57', 1, 1, 'atomsvc', 'application/atomsvc+xml', 0, 'application'),
(520, NULL, '2022-06-02 15:38:57', 1, 1, 'kia', 'application/vnd.kidspiration', 0, 'application'),
(521, NULL, '2022-06-02 15:38:57', 1, 1, 'rcprofile', 'application/vnd.ipunplugged.rcprofile', 0, 'application'),
(522, NULL, '2022-06-02 15:38:57', 1, 1, 'adp', 'audio/adpcm', 0, 'audio'),
(523, NULL, '2022-06-02 15:38:57', 1, 1, 'c4g', 'application/vnd.clonk.c4group', 0, 'application'),
(524, NULL, '2022-06-02 15:38:57', 1, 1, 'fti', 'application/vnd.anser-web-funds-transfer-initiation', 0, 'application'),
(525, NULL, '2022-06-02 15:38:57', 1, 1, 'pwn', 'application/vnd.3m.post-it-notes', 0, 'application'),
(526, NULL, '2022-06-02 15:38:57', 1, 1, 'ftc', 'application/vnd.fluxtime.clip', 0, 'application'),
(527, NULL, '2022-06-02 15:38:57', 1, 1, 'webp', 'image/webp', 1, 'image'),
(528, NULL, '2022-06-02 15:38:57', 1, 1, 'c4d', 'application/vnd.clonk.c4group', 0, 'application'),
(529, NULL, '2022-06-02 15:38:57', 1, 1, 'list3820', 'application/vnd.ibm.modcap', 0, 'application'),
(530, NULL, '2022-06-02 15:38:57', 1, 1, 'xwd', 'image/x-xwindowdump', 0, 'image'),
(531, NULL, '2022-06-02 15:38:57', 1, 1, 'xaml', 'application/xaml+xml', 0, 'application'),
(532, NULL, '2022-06-02 15:38:57', 1, 1, 'mscml', 'application/mediaservercontrol+xml', 0, 'application'),
(533, NULL, '2022-06-02 15:38:57', 1, 1, 'cdx', 'chemical/x-cdx', 0, 'chemical'),
(534, '', '2022-06-02 15:38:57', 1, 1, '7z', 'application/x-7z-compressed', 1, 'application'),
(535, NULL, '2022-06-02 15:38:57', 1, 1, 'wsdl', 'application/wsdl+xml', 0, 'application'),
(536, NULL, '2022-06-02 15:38:57', 1, 1, 'mny', 'application/x-msmoney', 0, 'application'),
(537, NULL, '2022-06-02 15:38:57', 1, 1, 'dgc', 'application/x-dgc-compressed', 0, 'application'),
(538, NULL, '2022-06-02 15:38:57', 1, 1, 'swi', 'application/vnd.aristanetworks.swi', 0, 'application'),
(539, NULL, '2022-06-02 15:38:57', 1, 1, 'rss', 'application/rss+xml', 0, 'application'),
(540, NULL, '2022-06-02 15:38:57', 1, 1, 'obd', 'application/x-msbinder', 0, 'application'),
(541, NULL, '2022-06-02 15:38:57', 1, 1, 'wps', 'application/vnd.ms-works', 0, 'application'),
(542, NULL, '2022-06-02 15:38:57', 1, 1, 'swa', 'application/x-director', 0, 'application'),
(543, NULL, '2022-06-02 15:38:57', 1, 1, 'htm', 'text/html', 0, 'text'),
(544, NULL, '2022-06-02 15:38:57', 1, 1, 'vxml', 'application/voicexml+xml', 0, 'application'),
(545, NULL, '2022-06-02 15:38:57', 1, 1, 'wpl', 'application/vnd.ms-wpl', 0, 'application'),
(546, NULL, '2022-06-02 15:38:57', 1, 1, 'jlt', 'application/vnd.hp-jlyt', 0, 'application'),
(547, NULL, '2022-06-02 15:38:57', 1, 1, 'wpd', 'application/vnd.wordperfect', 0, 'application');
INSERT INTO `file_mime_type` (`id`, `description`, `create_date`, `create_user_id`, `active`, `extension`, `mime_type`, `allow_upload`, `group_name`) VALUES
(548, NULL, '2022-06-02 15:38:57', 1, 1, 'irp', 'application/vnd.irepository.package+xml', 0, 'application'),
(549, NULL, '2022-06-02 15:38:57', 1, 1, 'rsd', 'application/rsd+xml', 0, 'application'),
(550, NULL, '2022-06-02 15:38:57', 1, 1, 'aif', 'audio/x-aiff', 0, 'audio'),
(551, NULL, '2022-06-02 15:38:57', 1, 1, 'musicxml', 'application/vnd.recordare.musicxml+xml', 0, 'application'),
(552, NULL, '2022-06-02 15:38:57', 1, 1, 'acc', 'application/vnd.americandynamics.acc', 0, 'application'),
(553, NULL, '2022-06-02 15:38:57', 1, 1, 'mpn', 'application/vnd.mophun.application', 0, 'application'),
(554, NULL, '2022-06-02 15:38:57', 1, 1, 'z4', 'application/x-zmachine', 0, 'application'),
(555, NULL, '2022-06-02 15:38:57', 1, 1, 'st', 'application/vnd.sailingtracker.track', 0, 'application'),
(556, NULL, '2022-06-02 15:38:57', 1, 1, 'asx', 'video/x-ms-asf', 0, 'video'),
(557, NULL, '2022-06-02 15:38:57', 1, 1, 'air', 'application/vnd.adobe.air-application-installer-package+zip', 0, 'application'),
(558, NULL, '2022-06-02 15:38:57', 1, 1, 'dtd', 'application/xml-dtd', 0, 'application'),
(559, NULL, '2022-06-02 15:38:57', 1, 1, 'mgp', 'application/vnd.osgeo.mapguide.package', 0, 'application'),
(560, NULL, '2022-06-02 15:38:57', 1, 1, 'sm', 'application/vnd.stepmania.stepchart', 0, 'application'),
(561, NULL, '2022-06-02 15:38:57', 1, 1, 'cb7', 'application/x-cbr', 0, 'application'),
(562, NULL, '2022-06-02 15:38:57', 1, 1, 'so', 'application/octet-stream', 0, 'application'),
(563, NULL, '2022-06-02 15:38:57', 1, 1, 'qps', 'application/vnd.publishare-delta-tree', 0, 'application'),
(564, NULL, '2022-06-02 15:38:57', 1, 1, 'sc', 'application/vnd.ibm.secure-container', 0, 'application'),
(565, NULL, '2022-06-02 15:38:57', 1, 1, 'mgz', 'application/vnd.proteus.magazine', 0, 'application'),
(566, NULL, '2022-06-02 15:38:57', 1, 1, 'ustar', 'application/x-ustar', 0, 'application'),
(567, NULL, '2022-06-02 15:38:57', 1, 1, 'afm', 'application/x-font-type1', 0, 'application'),
(568, NULL, '2022-06-02 15:38:57', 1, 1, 'spx', 'audio/ogg', 0, 'audio'),
(569, NULL, '2022-06-02 15:38:57', 1, 1, 'ktz', 'application/vnd.kahootz', 0, 'application'),
(570, NULL, '2022-06-02 15:38:57', 1, 1, 'ktx', 'image/ktx', 1, 'image'),
(571, NULL, '2022-06-02 15:38:57', 1, 1, 'paw', 'application/vnd.pawaafile', 0, 'application'),
(572, NULL, '2022-06-02 15:38:57', 1, 1, 'spq', 'application/scvp-vp-request', 0, 'application'),
(573, NULL, '2022-06-02 15:38:57', 1, 1, 'spp', 'application/scvp-vp-response', 0, 'application'),
(574, NULL, '2022-06-02 15:38:57', 1, 1, 'pas', 'text/x-pascal', 0, 'text'),
(575, NULL, '2022-06-02 15:38:57', 1, 1, 'ktr', 'application/vnd.kahootz', 0, 'application'),
(576, NULL, '2022-06-02 15:38:57', 1, 1, 'atom', 'application/atom+xml', 0, 'application'),
(577, NULL, '2022-06-02 15:38:57', 1, 1, 'sgml', 'text/sgml', 0, 'text'),
(578, NULL, '2022-06-02 15:38:57', 1, 1, 'fbs', 'image/vnd.fastbidsheet', 0, 'image'),
(579, NULL, '2022-06-02 15:38:57', 1, 1, 'spl', 'application/x-futuresplash', 0, 'application'),
(580, NULL, '2022-06-02 15:38:57', 1, 1, 'spc', 'application/x-pkcs7-certificates', 0, 'application'),
(581, NULL, '2022-06-02 15:38:57', 1, 1, 'tfm', 'application/x-tex-tfm', 0, 'application'),
(582, NULL, '2022-06-02 15:38:57', 1, 1, 'pcurl', 'application/vnd.curl.pcurl', 0, 'application'),
(583, NULL, '2022-06-02 15:38:57', 1, 1, 'spf', 'application/vnd.yamaha.smaf-phrase', 0, 'application'),
(584, NULL, '2022-06-02 15:38:57', 1, 1, 'afp', 'application/vnd.ibm.modcap', 0, 'application'),
(585, NULL, '2022-06-02 15:38:57', 1, 1, 'cba', 'application/x-cbr', 0, 'application'),
(586, NULL, '2022-06-02 15:38:57', 1, 1, 'uvva', 'audio/vnd.dece.audio', 0, 'audio'),
(587, NULL, '2022-06-02 15:38:57', 1, 1, 'xo', 'application/vnd.olpc-sugar', 0, 'application'),
(588, NULL, '2022-06-02 15:38:57', 1, 1, 'rar', 'application/x-rar-compressed', 0, 'application'),
(589, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvd', 'application/vnd.dece.data', 0, 'application'),
(590, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvf', 'application/vnd.dece.data', 0, 'application'),
(591, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvg', 'image/vnd.dece.graphic', 0, 'image'),
(592, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvh', 'video/vnd.dece.hd', 0, 'video'),
(593, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvi', 'image/vnd.dece.graphic', 0, 'image'),
(594, NULL, '2022-06-02 15:38:57', 1, 1, 'onetmp', 'application/onenote', 0, 'application'),
(595, NULL, '2022-06-02 15:38:57', 1, 1, 'dmp', 'application/vnd.tcpdump.pcap', 0, 'application'),
(596, NULL, '2022-06-02 15:38:57', 1, 1, 'tao', 'application/vnd.tao.intent-module-archive', 0, 'application'),
(597, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvm', 'video/vnd.dece.mobile', 0, 'video'),
(598, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvp', 'video/vnd.dece.pd', 0, 'video'),
(599, NULL, '2022-06-02 15:38:57', 1, 1, 'tar', 'application/x-tar', 0, 'application'),
(600, NULL, '2022-06-02 15:38:57', 1, 1, 'cbr', 'application/x-cbr', 0, 'application'),
(601, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvt', 'application/vnd.dece.ttml+xml', 0, 'application'),
(602, NULL, '2022-06-02 15:38:57', 1, 1, 'cbt', 'application/x-cbr', 0, 'application'),
(603, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvv', 'video/vnd.dece.video', 0, 'video'),
(604, NULL, '2022-06-02 15:38:57', 1, 1, 'xz', 'application/x-xz', 0, 'application'),
(605, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvx', 'application/vnd.dece.unspecified', 0, 'application'),
(606, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvz', 'application/vnd.dece.zip', 0, 'application'),
(607, NULL, '2022-06-02 15:38:57', 1, 1, 'cbz', 'application/x-cbr', 0, 'application'),
(608, NULL, '2022-06-02 15:38:57', 1, 1, 'ram', 'audio/x-pn-realaudio', 0, 'audio'),
(609, NULL, '2022-06-02 15:38:57', 1, 1, 'tpt', 'application/vnd.trid.tpt', 0, 'application'),
(610, NULL, '2022-06-02 15:38:57', 1, 1, 'css', 'text/css', 0, 'text'),
(611, NULL, '2022-06-02 15:38:57', 1, 1, 'csp', 'application/vnd.commonspace', 0, 'application'),
(612, NULL, '2022-06-02 15:38:57', 1, 1, 'csv', 'text/csv', 0, 'text'),
(613, NULL, '2022-06-02 15:38:57', 1, 1, 'cst', 'application/x-director', 0, 'application'),
(614, NULL, '2022-06-02 15:38:57', 1, 1, 'mrcx', 'application/marcxml+xml', 0, 'application'),
(615, NULL, '2022-06-02 15:38:57', 1, 1, 'eol', 'audio/vnd.digital-winds', 0, 'audio'),
(616, NULL, '2022-06-02 15:38:57', 1, 1, 'ufd', 'application/vnd.ufdl', 0, 'application'),
(617, NULL, '2022-06-02 15:38:57', 1, 1, 'acutc', 'application/vnd.acucorp', 0, 'application'),
(618, NULL, '2022-06-02 15:38:57', 1, 1, 'pyv', 'video/vnd.ms-playready.media.pyv', 0, 'video'),
(619, NULL, '2022-06-02 15:38:57', 1, 1, 'uvu', 'video/vnd.uvvu.mp4', 0, 'video'),
(620, NULL, '2022-06-02 15:38:57', 1, 1, 'vox', 'application/x-authorware-bin', 0, 'application'),
(621, NULL, '2022-06-02 15:38:57', 1, 1, 'gmx', 'application/vnd.gmx', 0, 'application'),
(622, NULL, '2022-06-02 15:38:57', 1, 1, 'tpl', 'application/vnd.groove-tool-template', 0, 'application'),
(623, NULL, '2022-06-02 15:38:57', 1, 1, 'mseq', 'application/vnd.mseq', 0, 'application'),
(624, NULL, '2022-06-02 15:38:57', 1, 1, 'csh', 'application/x-csh', 0, 'application'),
(625, NULL, '2022-06-02 15:38:57', 1, 1, 'rp9', 'application/vnd.cloanto.rp9', 0, 'application'),
(626, NULL, '2022-06-02 15:38:57', 1, 1, 'dvi', 'application/x-dvi', 0, 'application'),
(627, NULL, '2022-06-02 15:38:57', 1, 1, 'xpx', 'application/vnd.intercon.formnet', 0, 'application'),
(628, NULL, '2022-06-02 15:38:57', 1, 1, '3gp', 'video/3gpp', 0, 'video'),
(629, NULL, '2022-06-02 15:38:57', 1, 1, 'pcap', 'application/vnd.tcpdump.pcap', 0, 'application'),
(630, NULL, '2022-06-02 15:38:57', 1, 1, 'fh7', 'image/x-freehand', 0, 'image'),
(631, NULL, '2022-06-02 15:38:57', 1, 1, 'xpr', 'application/vnd.is-xpr', 0, 'application'),
(632, NULL, '2022-06-02 15:38:57', 1, 1, 'xps', 'application/vnd.ms-xpsdocument', 0, 'application'),
(633, NULL, '2022-06-02 15:38:57', 1, 1, 'pkipath', 'application/pkix-pkipath', 0, 'application'),
(634, NULL, '2022-06-02 15:38:57', 1, 1, 'xpw', 'application/vnd.intercon.formnet', 0, 'application'),
(635, NULL, '2022-06-02 15:38:57', 1, 1, 'xpi', 'application/x-xpinstall', 0, 'application'),
(636, NULL, '2022-06-02 15:38:57', 1, 1, 'xpl', 'application/xproc+xml', 0, 'application'),
(637, NULL, '2022-06-02 15:38:57', 1, 1, 'xpm', 'image/x-xpixmap', 0, 'image'),
(638, NULL, '2022-06-02 15:38:57', 1, 1, 'karbon', 'application/vnd.kde.karbon', 0, 'application'),
(639, NULL, '2022-06-02 15:38:57', 1, 1, 'vor', 'application/vnd.stardivision.writer', 0, 'application'),
(640, NULL, '2022-06-02 15:38:57', 1, 1, 'ief', 'image/ief', 1, 'image'),
(641, NULL, '2022-06-02 15:38:57', 1, 1, 'mpeg', 'video/mpeg', 0, 'video'),
(642, NULL, '2022-06-02 15:38:57', 1, 1, 'tfi', 'application/thraud+xml', 0, 'application'),
(643, NULL, '2022-06-02 15:38:57', 1, 1, 'xm', 'audio/xm', 0, 'audio'),
(644, NULL, '2022-06-02 15:38:57', 1, 1, 'sdw', 'application/vnd.stardivision.writer', 0, 'application'),
(645, NULL, '2022-06-02 15:38:57', 1, 1, 'ppt', 'application/vnd.ms-powerpoint', 0, 'application'),
(646, NULL, '2022-06-02 15:38:57', 1, 1, 'mmd', 'application/vnd.chipnuts.karaoke-mmd', 0, 'application'),
(647, NULL, '2022-06-02 15:38:57', 1, 1, 'etx', 'text/x-setext', 0, 'text'),
(648, NULL, '2022-06-02 15:38:57', 1, 1, 'ras', 'image/x-cmu-raster', 0, 'image'),
(649, NULL, '2022-06-02 15:38:57', 1, 1, 'mmr', 'image/vnd.fujixerox.edmics-mmr', 0, 'image'),
(650, NULL, '2022-06-02 15:38:57', 1, 1, 'ppd', 'application/vnd.cups-ppd', 0, 'application'),
(651, NULL, '2022-06-02 15:38:57', 1, 1, 'fpx', 'image/vnd.fpx', 0, 'image'),
(652, NULL, '2022-06-02 15:38:57', 1, 1, 'metalink', 'application/metalink+xml', 0, 'application'),
(653, NULL, '2022-06-02 15:38:57', 1, 1, 'ppm', 'image/x-portable-pixmap', 0, 'image'),
(654, NULL, '2022-06-02 15:38:57', 1, 1, 'hqx', 'application/mac-binhex40', 0, 'application'),
(655, NULL, '2022-06-02 15:38:57', 1, 1, 'cdmid', 'application/cdmi-domain', 0, 'application'),
(656, NULL, '2022-06-02 15:38:57', 1, 1, 'mbk', 'application/vnd.mobius.mbk', 0, 'application'),
(657, NULL, '2022-06-02 15:38:57', 1, 1, 'potm', 'application/vnd.ms-powerpoint.template.macroenabled.12', 0, 'application'),
(658, NULL, '2022-06-02 15:38:57', 1, 1, 'ipfix', 'application/ipfix', 0, 'application'),
(659, NULL, '2022-06-02 15:38:57', 1, 1, 'cdmio', 'application/cdmi-object', 0, 'application'),
(660, NULL, '2022-06-02 15:38:57', 1, 1, 'atomcat', 'application/atomcat+xml', 0, 'application'),
(661, NULL, '2022-06-02 15:38:57', 1, 1, 'potx', 'application/vnd.openxmlformats-officedocument.presentationml.template', 1, 'application'),
(662, NULL, '2022-06-02 15:38:57', 1, 1, 'pki', 'application/pkixcmp', 0, 'application'),
(663, NULL, '2022-06-02 15:38:57', 1, 1, 'urls', 'text/uri-list', 0, 'text'),
(664, NULL, '2022-06-02 15:38:57', 1, 1, 'cdmiq', 'application/cdmi-queue', 0, 'application'),
(665, NULL, '2022-06-02 15:38:57', 1, 1, 'ccxml', 'application/ccxml+xml', 0, 'application'),
(666, NULL, '2022-06-02 15:38:57', 1, 1, 'pkg', 'application/octet-stream', 0, 'application'),
(667, NULL, '2022-06-02 15:38:57', 1, 1, 'fhc', 'image/x-freehand', 0, 'image'),
(668, NULL, '2022-06-02 15:38:57', 1, 1, 'cryptonote', 'application/vnd.rig.cryptonote', 0, 'application'),
(669, NULL, '2022-06-02 15:38:57', 1, 1, 'g3w', 'application/vnd.geospace', 0, 'application'),
(670, NULL, '2022-06-02 15:38:57', 1, 1, 'kwd', 'application/vnd.kde.kword', 0, 'application'),
(671, NULL, '2022-06-02 15:38:57', 1, 1, 'ghf', 'application/vnd.groove-help', 0, 'application'),
(672, NULL, '2022-06-02 15:38:57', 1, 1, 'ssf', 'application/vnd.epson.ssf', 0, 'application'),
(673, NULL, '2022-06-02 15:38:57', 1, 1, 'taglet', 'application/vnd.mynfc', 0, 'application'),
(674, NULL, '2022-06-02 15:38:57', 1, 1, 'sse', 'application/vnd.kodak-descriptor', 0, 'application'),
(675, NULL, '2022-06-02 15:38:57', 1, 1, 'ngdat', 'application/vnd.nokia.n-gage.data', 0, 'application'),
(676, NULL, '2022-06-02 15:38:57', 1, 1, 'dcr', 'application/x-director', 0, 'application'),
(677, NULL, '2022-06-02 15:38:57', 1, 1, 'm4u', 'video/vnd.mpegurl', 0, 'video'),
(678, NULL, '2022-06-02 15:38:57', 1, 1, 'm4v', 'video/x-m4v', 0, 'video'),
(679, NULL, '2022-06-02 15:38:57', 1, 1, 'wtb', 'application/vnd.webturbo', 0, 'application'),
(680, NULL, '2022-06-02 15:38:57', 1, 1, 'kwt', 'application/vnd.kde.kword', 0, 'application'),
(681, NULL, '2022-06-02 15:38:57', 1, 1, 'qwd', 'application/vnd.quark.quarkxpress', 0, 'application'),
(682, NULL, '2022-06-02 15:38:57', 1, 1, 'mp3', 'audio/mpeg', 0, 'audio'),
(683, NULL, '2022-06-02 15:38:57', 1, 1, 'mp2', 'audio/mpeg', 0, 'audio'),
(684, NULL, '2022-06-02 15:38:57', 1, 1, 'mar', 'application/octet-stream', 0, 'application'),
(685, NULL, '2022-06-02 15:38:57', 1, 1, 'rnc', 'application/relax-ng-compact-syntax', 0, 'application'),
(686, NULL, '2022-06-02 15:38:57', 1, 1, 'uoml', 'application/vnd.uoml+xml', 0, 'application'),
(687, NULL, '2022-06-02 15:38:57', 1, 1, 'flv', 'video/x-flv', 0, 'video'),
(688, NULL, '2022-06-02 15:38:57', 1, 1, 'wg', 'application/vnd.pmi.widget', 0, 'application'),
(689, NULL, '2022-06-02 15:38:57', 1, 1, 'aep', 'application/vnd.audiograph', 0, 'application'),
(690, NULL, '2022-06-02 15:38:57', 1, 1, 'wm', 'video/x-ms-wm', 0, 'video'),
(691, NULL, '2022-06-02 15:38:57', 1, 1, 'thmx', 'application/vnd.ms-officetheme', 0, 'application'),
(692, NULL, '2022-06-02 15:38:57', 1, 1, 'nb', 'application/mathematica', 0, 'application'),
(693, NULL, '2022-06-02 15:38:57', 1, 1, 'shar', 'application/x-shar', 0, 'application'),
(694, NULL, '2022-06-02 15:38:57', 1, 1, 'cu', 'application/cu-seeme', 0, 'application'),
(695, NULL, '2022-06-02 15:38:57', 1, 1, 'uvvs', 'video/vnd.dece.sd', 0, 'video'),
(696, NULL, '2022-06-02 15:38:57', 1, 1, 'opml', 'text/x-opml', 0, 'text'),
(697, NULL, '2022-06-02 15:38:57', 1, 1, 'cer', 'application/pkix-cert', 0, 'application'),
(698, NULL, '2022-06-02 15:38:57', 1, 1, 'x3dvz', 'model/x3d+vrml', 0, 'model'),
(699, NULL, '2022-06-02 15:38:57', 1, 1, 'f', 'text/x-fortran', 0, 'text'),
(700, NULL, '2022-06-02 15:38:57', 1, 1, 'z3', 'application/x-zmachine', 0, 'application'),
(701, NULL, '2022-06-02 15:38:57', 1, 1, 'mpe', 'video/mpeg', 0, 'video'),
(702, NULL, '2022-06-02 15:38:57', 1, 1, 'kpr', 'application/vnd.kde.kpresenter', 0, 'application'),
(703, NULL, '2022-06-02 15:38:57', 1, 1, 'nitf', 'application/vnd.nitf', 0, 'application'),
(704, NULL, '2022-06-02 15:38:57', 1, 1, 'texi', 'application/x-texinfo', 0, 'application'),
(705, NULL, '2022-06-02 15:38:57', 1, 1, 'mpc', 'application/vnd.mophun.certificate', 0, 'application'),
(706, NULL, '2022-06-02 15:38:57', 1, 1, 'kpt', 'application/vnd.kde.kpresenter', 0, 'application'),
(707, NULL, '2022-06-02 15:38:57', 1, 1, 'mpm', 'application/vnd.blueice.multipass', 0, 'application'),
(708, NULL, '2022-06-02 15:38:57', 1, 1, 'xbd', 'application/vnd.fujixerox.docuworks.binder', 0, 'application'),
(709, NULL, '2022-06-02 15:38:57', 1, 1, 'tcap', 'application/vnd.3gpp2.tcap', 0, 'application'),
(710, NULL, '2022-06-02 15:38:57', 1, 1, 'rmi', 'audio/midi', 0, 'audio'),
(711, NULL, '2022-06-02 15:38:57', 1, 1, 'mpt', 'application/vnd.ms-project', 0, 'application'),
(712, NULL, '2022-06-02 15:38:57', 1, 1, 'appcache', 'text/cache-manifest', 0, 'text'),
(713, NULL, '2022-06-02 15:38:57', 1, 1, 'abw', 'application/x-abiword', 0, 'application'),
(714, NULL, '2022-06-02 15:38:57', 1, 1, 'mpp', 'application/vnd.ms-project', 0, 'application'),
(715, NULL, '2022-06-02 15:38:57', 1, 1, 'rms', 'application/vnd.jcp.javame.midlet-rms', 0, 'application'),
(716, NULL, '2022-06-02 15:38:57', 1, 1, 'sema', 'application/vnd.sema', 0, 'application'),
(717, NULL, '2022-06-02 15:38:57', 1, 1, 'utz', 'application/vnd.uiq.theme', 0, 'application'),
(718, NULL, '2022-06-02 15:38:57', 1, 1, 'mpy', 'application/vnd.ibm.minipay', 0, 'application'),
(719, NULL, '2022-06-02 15:38:57', 1, 1, 'portpkg', 'application/vnd.macports.portpkg', 0, 'application'),
(720, NULL, '2022-06-02 15:38:57', 1, 1, 'semf', 'application/vnd.semf', 0, 'application'),
(721, NULL, '2022-06-02 15:38:57', 1, 1, 'mp4v', 'video/mp4', 0, 'video'),
(722, NULL, '2022-06-02 15:38:57', 1, 1, 'flx', 'text/vnd.fmi.flexstor', 0, 'text'),
(723, NULL, '2022-06-02 15:38:57', 1, 1, 'mp4s', 'application/mp4', 0, 'application'),
(724, NULL, '2022-06-02 15:38:57', 1, 1, 'yang', 'application/yang', 0, 'application'),
(725, NULL, '2022-06-02 15:38:57', 1, 1, 'ser', 'application/java-serialized-object', 0, 'application'),
(726, NULL, '2022-06-02 15:38:57', 1, 1, 'rpss', 'application/vnd.nokia.radio-presets', 0, 'application'),
(727, NULL, '2022-06-02 15:38:57', 1, 1, 't', 'text/troff', 0, 'text'),
(728, NULL, '2022-06-02 15:38:57', 1, 1, 'maker', 'application/vnd.framemaker', 0, 'application'),
(729, NULL, '2022-06-02 15:38:57', 1, 1, 'opf', 'application/oebps-package+xml', 0, 'application'),
(730, NULL, '2022-06-02 15:38:57', 1, 1, 'mp4a', 'audio/mp4', 0, 'audio'),
(731, NULL, '2022-06-02 15:38:57', 1, 1, 'gpx', 'application/gpx+xml', 0, 'application'),
(732, NULL, '2022-06-02 15:38:57', 1, 1, 'viv', 'video/vnd.vivo', 0, 'video'),
(733, NULL, '2022-06-02 15:38:57', 1, 1, 'hbci', 'application/vnd.hbci', 0, 'application'),
(734, NULL, '2022-06-02 15:38:57', 1, 1, 'ecelp4800', 'audio/vnd.nuera.ecelp4800', 0, 'audio'),
(735, NULL, '2022-06-02 15:38:57', 1, 1, 'mathml', 'application/mathml+xml', 0, 'application'),
(736, NULL, '2022-06-02 15:38:57', 1, 1, 'see', 'application/vnd.seemail', 0, 'application'),
(737, NULL, '2022-06-02 15:38:57', 1, 1, 'gml', 'application/gml+xml', 0, 'application'),
(738, NULL, '2022-06-02 15:38:57', 1, 1, 'gac', 'application/vnd.groove-account', 0, 'application'),
(739, NULL, '2022-06-02 15:38:57', 1, 1, 'text', 'text/plain', 0, 'text'),
(740, NULL, '2022-06-02 15:38:57', 1, 1, 'dwf', 'model/vnd.dwf', 0, 'model'),
(741, NULL, '2022-06-02 15:38:57', 1, 1, 'smzip', 'application/vnd.stepmania.package', 0, 'application'),
(742, NULL, '2022-06-02 15:38:57', 1, 1, 'gam', 'application/x-tads', 0, 'application'),
(743, NULL, '2022-06-02 15:38:57', 1, 1, 'vtu', 'model/vnd.vtu', 0, 'model'),
(744, NULL, '2022-06-02 15:38:57', 1, 1, 'dd2', 'application/vnd.oma.dd2+xml', 0, 'application'),
(745, NULL, '2022-06-02 15:38:57', 1, 1, 'boz', 'application/x-bzip2', 0, 'application'),
(746, NULL, '2022-06-02 15:38:57', 1, 1, 'csml', 'chemical/x-csml', 0, 'chemical'),
(747, NULL, '2022-06-02 15:38:57', 1, 1, 'box', 'application/vnd.previewsystems.box', 0, 'application'),
(748, NULL, '2022-06-02 15:38:57', 1, 1, 'esa', 'application/vnd.osgi.subsystem', 0, 'application'),
(749, NULL, '2022-06-02 15:38:57', 1, 1, 'oa2', 'application/vnd.fujitsu.oasys2', 0, 'application'),
(750, NULL, '2022-06-02 15:38:57', 1, 1, 'oa3', 'application/vnd.fujitsu.oasys3', 0, 'application'),
(751, NULL, '2022-06-02 15:38:57', 1, 1, 'esf', 'application/vnd.epson.esf', 0, 'application'),
(752, NULL, '2022-06-02 15:38:57', 1, 1, 'exe', 'application/x-msdownload', 0, 'application'),
(753, NULL, '2022-06-02 15:38:57', 1, 1, 'dp', 'application/vnd.osgi.dp', 0, 'application'),
(754, NULL, '2022-06-02 15:38:57', 1, 1, 'dms', 'application/octet-stream', 0, 'application'),
(755, NULL, '2022-06-02 15:38:57', 1, 1, 'xlam', 'application/vnd.ms-excel.addin.macroenabled.12', 1, 'application'),
(756, NULL, '2022-06-02 15:38:57', 1, 1, 'iota', 'application/vnd.astraea-software.iota', 0, 'application'),
(757, NULL, '2022-06-02 15:38:57', 1, 1, 'cxt', 'application/x-director', 0, 'application'),
(758, NULL, '2022-06-02 15:38:57', 1, 1, 'cxx', 'text/x-c', 0, 'text'),
(759, NULL, '2022-06-02 15:38:57', 1, 1, 'exi', 'application/exi', 0, 'application'),
(760, NULL, '2022-06-02 15:38:57', 1, 1, 'dmg', 'application/x-apple-diskimage', 0, 'application'),
(761, NULL, '2022-06-02 15:38:57', 1, 1, 'ext', 'application/vnd.novadigm.ext', 0, 'application'),
(762, NULL, '2022-06-02 15:38:57', 1, 1, 'sdd', 'application/vnd.stardivision.impress', 0, 'application'),
(763, NULL, '2022-06-02 15:38:57', 1, 1, 'kar', 'audio/midi', 0, 'audio'),
(764, NULL, '2022-06-02 15:38:57', 1, 1, 'xhvml', 'application/xv+xml', 0, 'application'),
(765, NULL, '2022-06-02 15:38:57', 1, 1, 'm3a', 'audio/mpeg', 0, 'audio'),
(766, NULL, '2022-06-02 15:38:57', 1, 1, 'ppsm', 'application/vnd.ms-powerpoint.slideshow.macroenabled.12', 0, 'application'),
(767, NULL, '2022-06-02 15:38:57', 1, 1, 'ddd', 'application/vnd.fujixerox.ddd', 0, 'application'),
(768, NULL, '2022-06-02 15:38:57', 1, 1, 'list', 'text/plain', 0, 'text'),
(769, NULL, '2022-06-02 15:38:57', 1, 1, 'svd', 'application/vnd.svd', 0, 'application'),
(770, NULL, '2022-06-02 15:38:57', 1, 1, 'svg', 'image/svg+xml', 1, 'image'),
(771, NULL, '2022-06-02 15:38:57', 1, 1, 'es3', 'application/vnd.eszigno3+xml', 0, 'application'),
(772, NULL, '2022-06-02 15:38:57', 1, 1, 'svc', 'application/vnd.dvb.service', 0, 'application'),
(773, NULL, '2022-06-02 15:38:57', 1, 1, 'mag', 'application/vnd.ecowin.chart', 0, 'application'),
(774, NULL, '2022-06-02 15:38:57', 1, 1, 'ink', 'application/inkml+xml', 0, 'application'),
(775, NULL, '2022-06-02 15:38:57', 1, 1, 'm3u', 'audio/x-mpegurl', 0, 'audio'),
(776, NULL, '2022-06-02 15:38:57', 1, 1, 'ppsx', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 1, 'application'),
(777, NULL, '2022-06-02 15:38:57', 1, 1, 'man', 'text/troff', 0, 'text'),
(778, NULL, '2022-06-02 15:38:57', 1, 1, '3ds', 'image/x-3ds', 0, 'image'),
(779, NULL, '2022-06-02 15:38:57', 1, 1, 'oas', 'application/vnd.fujitsu.oasys', 0, 'application'),
(780, NULL, '2022-06-02 15:38:57', 1, 1, 'flw', 'application/vnd.kde.kivio', 0, 'application'),
(781, NULL, '2022-06-02 15:38:57', 1, 1, 'eot', 'application/vnd.ms-fontobject', 0, 'application'),
(782, NULL, '2022-06-02 15:38:57', 1, 1, 'me', 'text/troff', 0, 'text'),
(783, NULL, '2022-06-02 15:38:57', 1, 1, 'mb', 'application/mathematica', 0, 'application'),
(784, NULL, '2022-06-02 15:38:57', 1, 1, 'pot', 'application/vnd.ms-powerpoint', 0, 'application'),
(785, NULL, '2022-06-02 15:38:57', 1, 1, 'ma', 'application/mathematica', 0, 'application'),
(786, NULL, '2022-06-02 15:38:57', 1, 1, 'rs', 'application/rls-services+xml', 0, 'application'),
(787, NULL, '2022-06-02 15:38:57', 1, 1, 'cml', 'chemical/x-cml', 0, 'chemical'),
(788, NULL, '2022-06-02 15:38:57', 1, 1, 'rq', 'application/sparql-Something is wrong', 0, 'application'),
(789, NULL, '2022-06-02 15:38:57', 1, 1, 'fly', 'text/vnd.fly', 0, 'text'),
(790, NULL, '2022-06-02 15:38:57', 1, 1, 'unityweb', 'application/vnd.unity', 0, 'application'),
(791, NULL, '2022-06-02 15:38:57', 1, 1, 'jisp', 'application/vnd.jisp', 0, 'application'),
(792, NULL, '2022-06-02 15:38:57', 1, 1, 'mfm', 'application/vnd.mfmp', 0, 'application'),
(793, NULL, '2022-06-02 15:38:57', 1, 1, 'woff', 'application/x-font-woff', 0, 'application'),
(794, NULL, '2022-06-02 15:38:57', 1, 1, 'ms', 'text/troff', 0, 'text'),
(795, NULL, '2022-06-02 15:38:57', 1, 1, 'rm', 'application/vnd.rn-realmedia', 0, 'application'),
(796, NULL, '2022-06-02 15:38:57', 1, 1, 'mft', 'application/rpki-manifest', 0, 'application'),
(797, NULL, '2022-06-02 15:38:57', 1, 1, 'wad', 'application/x-doom', 0, 'application'),
(798, NULL, '2022-06-02 15:38:57', 1, 1, 'ra', 'audio/x-pn-realaudio', 0, 'audio'),
(799, NULL, '2022-06-02 15:38:57', 1, 1, 'fli', 'video/x-fli', 0, 'video'),
(800, NULL, '2022-06-02 15:38:57', 1, 1, 'obj', 'application/x-tgif', 0, 'application'),
(801, NULL, '2022-06-02 15:38:57', 1, 1, 'flo', 'application/vnd.micrografx.flo', 0, 'application'),
(802, NULL, '2022-06-02 15:38:57', 1, 1, 'xlsb', 'application/vnd.ms-excel.sheet.binary.macroenabled.12', 1, 'application'),
(803, NULL, '2022-06-02 15:38:57', 1, 1, 'ecelp7470', 'audio/vnd.nuera.ecelp7470', 0, 'audio'),
(804, NULL, '2022-06-02 15:38:57', 1, 1, 'w3d', 'application/x-director', 0, 'application'),
(805, NULL, '2022-06-02 15:38:57', 1, 1, 'dae', 'model/vnd.collada+xml', 0, 'model'),
(806, NULL, '2022-06-02 15:38:57', 1, 1, 'aam', 'application/x-authorware-map', 0, 'application'),
(807, NULL, '2022-06-02 15:38:57', 1, 1, 'aab', 'application/x-authorware-bin', 0, 'application'),
(808, NULL, '2022-06-02 15:38:57', 1, 1, 'aac', 'audio/x-aac', 0, 'audio'),
(809, NULL, '2022-06-02 15:38:57', 1, 1, 'ksp', 'application/vnd.kde.kspread', 0, 'application'),
(810, NULL, '2022-06-02 15:38:57', 1, 1, 'fcs', 'application/vnd.isac.fcs', 0, 'application'),
(811, NULL, '2022-06-02 15:38:57', 1, 1, 'xlsm', 'application/vnd.ms-excel.sheet.macroenabled.12', 1, 'application'),
(812, NULL, '2022-06-02 15:38:57', 1, 1, 'zmm', 'application/vnd.handheld-entertainment+xml', 0, 'application'),
(813, NULL, '2022-06-02 15:38:57', 1, 1, 'oga', 'audio/ogg', 0, 'audio'),
(814, NULL, '2022-06-02 15:38:57', 1, 1, 'tga', 'image/x-tga', 0, 'image'),
(815, NULL, '2022-06-02 15:38:57', 1, 1, 'odb', 'application/vnd.oasis.opendocument.database', 0, 'application'),
(816, NULL, '2022-06-02 15:38:57', 1, 1, 'pfb', 'application/x-font-type1', 0, 'application'),
(817, NULL, '2022-06-02 15:38:57', 1, 1, 'aas', 'application/x-authorware-seg', 0, 'application'),
(818, NULL, '2022-06-02 15:38:57', 1, 1, 'xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 1, 'application'),
(819, NULL, '2022-06-02 15:38:57', 1, 1, 'pfa', 'application/x-font-type1', 0, 'application'),
(820, NULL, '2022-06-02 15:38:57', 1, 1, 'sxc', 'application/vnd.sun.xml.calc', 0, 'application'),
(821, NULL, '2022-06-02 15:38:57', 1, 1, 'fzs', 'application/vnd.fuzzysheet', 0, 'application'),
(822, NULL, '2022-06-02 15:38:57', 1, 1, 'sxg', 'application/vnd.sun.xml.writer.global', 0, 'application'),
(823, NULL, '2022-06-02 15:38:57', 1, 1, 'fg5', 'application/vnd.fujitsu.oasysgp', 0, 'application'),
(824, NULL, '2022-06-02 15:38:57', 1, 1, 'sxd', 'application/vnd.sun.xml.draw', 0, 'application'),
(825, NULL, '2022-06-02 15:38:57', 1, 1, 'sv4cpio', 'application/x-sv4cpio', 0, 'application'),
(826, NULL, '2022-06-02 15:38:57', 1, 1, 'sxi', 'application/vnd.sun.xml.impress', 0, 'application'),
(827, NULL, '2022-06-02 15:38:57', 1, 1, 'cap', 'application/vnd.tcpdump.pcap', 0, 'application'),
(828, NULL, '2022-06-02 15:38:57', 1, 1, 'sxm', 'application/vnd.sun.xml.math', 0, 'application'),
(829, NULL, '2022-06-02 15:38:57', 1, 1, 'tif', 'image/tiff', 1, 'image'),
(830, NULL, '2022-06-02 15:38:57', 1, 1, 'sxw', 'application/vnd.sun.xml.writer', 0, 'application'),
(831, NULL, '2022-06-02 15:38:57', 1, 1, 'osf', 'application/vnd.yamaha.openscoreformat', 0, 'application'),
(832, NULL, '2022-06-02 15:38:57', 1, 1, 'caf', 'audio/x-caf', 0, 'audio'),
(833, NULL, '2022-06-02 15:38:57', 1, 1, 'mxml', 'application/xv+xml', 0, 'application'),
(834, NULL, '2022-06-02 15:38:57', 1, 1, 'cab', 'application/vnd.ms-cab-compressed', 0, 'application'),
(835, NULL, '2022-06-02 15:38:57', 1, 1, 'gtar', 'application/x-gtar', 0, 'application'),
(836, NULL, '2022-06-02 15:38:57', 1, 1, 'c', 'text/x-c', 0, 'text'),
(837, NULL, '2022-06-02 15:38:57', 1, 1, 'oti', 'application/vnd.oasis.opendocument.image-template', 0, 'application'),
(838, NULL, '2022-06-02 15:38:57', 1, 1, 'oth', 'application/vnd.oasis.opendocument.text-web', 0, 'application'),
(839, NULL, '2022-06-02 15:38:57', 1, 1, 'dotx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 1, 'application'),
(840, NULL, '2022-06-02 15:38:57', 1, 1, 'udeb', 'application/x-debian-package', 0, 'application'),
(841, NULL, '2022-06-02 15:38:57', 1, 1, 'jpg', 'image/jpeg', 1, 'image'),
(842, NULL, '2022-06-02 15:38:57', 1, 1, 'otc', 'application/vnd.oasis.opendocument.chart-template', 0, 'application'),
(843, NULL, '2022-06-02 15:38:57', 1, 1, 'rip', 'audio/vnd.rip', 0, 'audio'),
(844, NULL, '2022-06-02 15:38:57', 1, 1, 'ris', 'application/x-research-info-systems', 0, 'application'),
(845, NULL, '2022-06-02 15:38:57', 1, 1, 'rl', 'application/resource-lists+xml', 0, 'application'),
(846, NULL, '2022-06-02 15:38:57', 1, 1, 'otg', 'application/vnd.oasis.opendocument.graphics-template', 0, 'application'),
(847, NULL, '2022-06-02 15:38:57', 1, 1, 'otf', 'application/x-font-otf', 0, 'application'),
(848, NULL, '2022-06-02 15:38:57', 1, 1, 's3m', 'audio/s3m', 0, 'audio'),
(849, NULL, '2022-06-02 15:38:57', 1, 1, 'gsf', 'application/x-font-ghostscript', 0, 'application'),
(850, NULL, '2022-06-02 15:38:57', 1, 1, 'dotm', 'application/vnd.ms-word.template.macroenabled.12', 0, 'application'),
(851, NULL, '2022-06-02 15:38:57', 1, 1, 'log', 'text/plain', 0, 'text'),
(852, NULL, '2022-06-02 15:38:57', 1, 1, 'qam', 'application/vnd.epson.quickanime', 0, 'application'),
(853, NULL, '2022-06-02 15:38:57', 1, 1, 'ots', 'application/vnd.oasis.opendocument.spreadsheet-template', 0, 'application'),
(854, NULL, '2022-06-02 15:38:57', 1, 1, 'dart', 'application/vnd.dart', 0, 'application'),
(855, NULL, '2022-06-02 15:38:57', 1, 1, 'otp', 'application/vnd.oasis.opendocument.presentation-template', 0, 'application'),
(856, NULL, '2022-06-02 15:38:57', 1, 1, 'flac', 'audio/x-flac', 0, 'audio'),
(857, NULL, '2022-06-02 15:38:57', 1, 1, 'ncx', 'application/x-dtbncx+xml', 0, 'application'),
(858, NULL, '2022-06-02 15:38:57', 1, 1, 'wav', 'audio/x-wav', 0, 'audio'),
(859, NULL, '2022-06-02 15:38:57', 1, 1, 'bdm', 'application/vnd.syncml.dm+wbxml', 0, 'application'),
(860, NULL, '2022-06-02 15:38:57', 1, 1, 'bdf', 'application/x-font-bdf', 0, 'application'),
(861, NULL, '2022-06-02 15:38:57', 1, 1, 'xif', 'image/vnd.xiff', 0, 'image'),
(862, NULL, '2022-06-02 15:38:57', 1, 1, 'gtm', 'application/vnd.groove-tool-message', 0, 'application'),
(863, NULL, '2022-06-02 15:38:57', 1, 1, 'sdkm', 'application/vnd.solent.sdkm+xml', 0, 'application'),
(864, NULL, '2022-06-02 15:38:57', 1, 1, 'wspolicy', 'application/wspolicy+xml', 0, 'application'),
(865, NULL, '2022-06-02 15:38:57', 1, 1, 'gtw', 'model/vnd.gtw', 0, 'model'),
(866, NULL, '2022-06-02 15:38:57', 1, 1, 'wgt', 'application/widget', 0, 'application'),
(867, NULL, '2022-06-02 15:38:57', 1, 1, 'ogv', 'video/ogg', 0, 'video'),
(868, NULL, '2022-06-02 15:38:57', 1, 1, 'sdkd', 'application/vnd.solent.sdkm+xml', 0, 'application'),
(869, NULL, '2022-06-02 15:38:57', 1, 1, 'fh4', 'image/x-freehand', 0, 'image'),
(870, NULL, '2022-06-02 15:38:57', 1, 1, 'mj2', 'video/mj2', 0, 'video'),
(871, NULL, '2022-06-02 15:38:57', 1, 1, 'fh5', 'image/x-freehand', 0, 'image'),
(872, NULL, '2022-06-02 15:38:57', 1, 1, 'hvd', 'application/vnd.yamaha.hv-dic', 0, 'application'),
(873, NULL, '2022-06-02 15:38:57', 1, 1, 'dic', 'text/x-c', 0, 'text'),
(874, NULL, '2022-06-02 15:38:57', 1, 1, 'wrl', 'model/vrml', 0, 'model'),
(875, NULL, '2022-06-02 15:38:57', 1, 1, 'wri', 'application/x-mswrite', 0, 'application'),
(876, NULL, '2022-06-02 15:38:57', 1, 1, 'pfx', 'application/x-pkcs12', 0, 'application'),
(877, NULL, '2022-06-02 15:38:57', 1, 1, 'hlp', 'application/winhlp', 0, 'application'),
(878, NULL, '2022-06-02 15:38:57', 1, 1, 'hvs', 'application/vnd.yamaha.hv-script', 0, 'application'),
(879, NULL, '2022-06-02 15:38:57', 1, 1, 'hvp', 'application/vnd.yamaha.hv-voice', 0, 'application'),
(880, NULL, '2022-06-02 15:38:57', 1, 1, 'ims', 'application/vnd.ms-ims', 0, 'application'),
(881, NULL, '2022-06-02 15:38:57', 1, 1, 'imp', 'application/vnd.accpac.simply.imp', 0, 'application'),
(882, NULL, '2022-06-02 15:38:57', 1, 1, 'dis', 'application/vnd.mobius.dis', 0, 'application'),
(883, NULL, '2022-06-02 15:38:57', 1, 1, 'dir', 'application/x-director', 0, 'application'),
(884, NULL, '2022-06-02 15:38:57', 1, 1, 'geo', 'application/vnd.dynageo', 0, 'application'),
(885, NULL, '2022-06-02 15:38:57', 1, 1, 'wax', 'audio/x-ms-wax', 0, 'audio'),
(886, '', '2022-06-02 15:38:57', 1, 1, 'png', 'image/png', 1, 'image'),
(887, NULL, '2022-06-02 15:38:57', 1, 1, 'jpm', 'video/jpm', 0, 'video'),
(888, NULL, '2022-06-02 15:38:57', 1, 1, 'qt', 'video/quicktime', 0, 'video'),
(889, NULL, '2022-06-02 15:38:57', 1, 1, 'mime', 'message/rfc822', 0, 'message'),
(890, NULL, '2022-06-02 15:38:57', 1, 1, 'sv4crc', 'application/x-sv4crc', 0, 'application'),
(891, NULL, '2022-06-02 15:38:57', 1, 1, 'application', 'application/x-ms-application', 0, 'application'),
(892, NULL, '2022-06-02 15:38:57', 1, 1, 'mpkg', 'application/vnd.apple.installer+xml', 0, 'application'),
(893, NULL, '2022-06-02 15:38:57', 1, 1, 'pptx', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 1, 'application'),
(894, NULL, '2022-06-02 15:38:57', 1, 1, 'pfr', 'application/font-tdpfr', 0, 'application'),
(895, NULL, '2022-06-02 15:38:57', 1, 1, 'mp21', 'application/mp21', 0, 'application'),
(896, NULL, '2022-06-02 15:38:57', 1, 1, 'hh', 'text/x-c', 0, 'text'),
(897, NULL, '2022-06-02 15:38:57', 1, 1, 'pptm', 'application/vnd.ms-powerpoint.presentation.macroenabled.12', 0, 'application'),
(898, NULL, '2022-06-02 15:38:57', 1, 1, 'xhtml', 'application/xhtml+xml', 0, 'application'),
(899, NULL, '2022-06-02 15:38:57', 1, 1, 'msty', 'application/vnd.muvee.style', 0, 'application'),
(900, NULL, '2022-06-02 15:38:57', 1, 1, 'ulx', 'application/x-glulx', 0, 'application'),
(901, NULL, '2022-06-02 15:38:57', 1, 1, 'g2w', 'application/vnd.geoplan', 0, 'application'),
(902, NULL, '2022-06-02 15:38:57', 1, 1, 'pcf', 'application/x-font-pcf', 0, 'application'),
(903, NULL, '2022-06-02 15:38:57', 1, 1, 'pcl', 'application/vnd.hp-pcl', 0, 'application'),
(904, NULL, '2022-06-02 15:38:57', 1, 1, 'wmlsc', 'application/vnd.wap.wmlscriptc', 0, 'application'),
(905, NULL, '2022-06-02 15:38:57', 1, 1, 'pct', 'image/x-pict', 0, 'image'),
(906, NULL, '2022-06-02 15:38:57', 1, 1, 'sru', 'application/sru+xml', 0, 'application'),
(907, NULL, '2022-06-02 15:38:57', 1, 1, 'srt', 'application/x-subrip', 0, 'application'),
(908, NULL, '2022-06-02 15:38:57', 1, 1, 'srx', 'application/sparql-results+xml', 0, 'application'),
(909, NULL, '2022-06-02 15:38:57', 1, 1, 'pcx', 'image/x-pcx', 0, 'image'),
(910, NULL, '2022-06-02 15:38:57', 1, 1, 'ifb', 'text/calendar', 0, 'text'),
(911, NULL, '2022-06-02 15:38:57', 1, 1, 'cdf', 'application/x-netcdf', 0, 'application'),
(912, NULL, '2022-06-02 15:38:57', 1, 1, 'hal', 'application/vnd.hal+xml', 0, 'application'),
(913, NULL, '2022-06-02 15:38:57', 1, 1, 'tcl', 'application/x-tcl', 0, 'application'),
(914, NULL, '2022-06-02 15:38:57', 1, 1, '3g2', 'video/3gpp2', 0, 'video'),
(915, NULL, '2022-06-02 15:38:57', 1, 1, 'dtb', 'application/x-dtbook+xml', 0, 'application'),
(916, NULL, '2022-06-02 15:38:57', 1, 1, 'h264', 'video/h264', 0, 'video'),
(917, NULL, '2022-06-02 15:38:57', 1, 1, 'spot', 'text/vnd.in3d.spot', 0, 'text'),
(918, NULL, '2022-06-02 15:38:57', 1, 1, 'rgb', 'image/x-rgb', 0, 'image'),
(919, NULL, '2022-06-02 15:38:57', 1, 1, 'deploy', 'application/octet-stream', 0, 'application'),
(920, NULL, '2022-06-02 15:38:57', 1, 1, 'cdy', 'application/vnd.cinderella', 0, 'application'),
(921, NULL, '2022-06-02 15:38:57', 1, 1, 'shf', 'application/shf+xml', 0, 'application'),
(922, '', '2022-06-02 15:38:57', 1, 1, 'zip', 'application/zip', 1, 'application'),
(923, NULL, '2022-06-02 15:38:57', 1, 1, 'zir', 'application/vnd.zul', 0, 'application'),
(924, NULL, '2022-06-02 15:38:57', 1, 1, 'odft', 'application/vnd.oasis.opendocument.formula-template', 0, 'application'),
(925, NULL, '2022-06-02 15:38:57', 1, 1, 'msf', 'application/vnd.epson.msf', 0, 'application'),
(926, NULL, '2022-06-02 15:38:57', 1, 1, 'uvz', 'application/vnd.dece.zip', 0, 'application'),
(927, NULL, '2022-06-02 15:38:57', 1, 1, 'et3', 'application/vnd.eszigno3+xml', 0, 'application'),
(928, NULL, '2022-06-02 15:38:57', 1, 1, 'msi', 'application/x-msdownload', 0, 'application'),
(929, NULL, '2022-06-02 15:38:57', 1, 1, 'pfm', 'application/x-font-type1', 0, 'application'),
(930, NULL, '2022-06-02 15:38:57', 1, 1, 'msl', 'application/vnd.mobius.msl', 0, 'application'),
(931, NULL, '2022-06-02 15:38:57', 1, 1, 'ez2', 'application/vnd.ezpix-album', 0, 'application'),
(932, NULL, '2022-06-02 15:38:57', 1, 1, 'teicorpus', 'application/tei+xml', 0, 'application'),
(933, NULL, '2022-06-02 15:38:57', 1, 1, 'pps', 'application/vnd.ms-powerpoint', 0, 'application'),
(934, NULL, '2022-06-02 15:38:57', 1, 1, 'mxs', 'application/vnd.triscape.mxs', 0, 'application'),
(935, NULL, '2022-06-02 15:38:57', 1, 1, 'tiff', 'image/tiff', 1, 'image'),
(936, NULL, '2022-06-02 15:38:57', 1, 1, 'fgd', 'application/x-director', 0, 'application'),
(937, NULL, '2022-06-02 15:38:57', 1, 1, 'mmf', 'application/vnd.smaf', 0, 'application'),
(938, NULL, '2022-06-02 15:38:57', 1, 1, 'u32', 'application/x-authorware-bin', 0, 'application'),
(939, NULL, '2022-06-02 15:38:57', 1, 1, 'wks', 'application/vnd.ms-works', 0, 'application'),
(940, NULL, '2022-06-02 15:38:57', 1, 1, 'cmp', 'application/vnd.yellowriver-custom-menu', 0, 'application'),
(941, NULL, '2022-06-02 15:38:57', 1, 1, 'efif', 'application/vnd.picsel', 0, 'application'),
(942, NULL, '2022-06-02 15:38:57', 1, 1, 'btif', 'image/prs.btif', 0, 'image'),
(943, NULL, '2022-06-02 15:38:57', 1, 1, 'sdp', 'application/sdp', 0, 'application'),
(944, NULL, '2022-06-02 15:38:57', 1, 1, 'cmx', 'image/x-cmx', 0, 'image'),
(945, NULL, '2022-06-02 15:38:57', 1, 1, 'midi', 'audio/midi', 0, 'audio'),
(946, NULL, '2022-06-02 15:38:57', 1, 1, 'azf', 'application/vnd.airzip.filesecure.azf', 0, 'application'),
(947, NULL, '2022-06-02 15:38:57', 1, 1, 'emma', 'application/emma+xml', 0, 'application'),
(948, NULL, '2022-06-02 15:38:57', 1, 1, 'sdc', 'application/vnd.stardivision.calc', 0, 'application'),
(949, NULL, '2022-06-02 15:38:57', 1, 1, 'sda', 'application/vnd.stardivision.draw', 0, 'application'),
(950, NULL, '2022-06-02 15:38:57', 1, 1, 'azs', 'application/vnd.airzip.filesecure.azs', 0, 'application'),
(951, NULL, '2022-06-02 15:38:57', 1, 1, 'ppam', 'application/vnd.ms-powerpoint.addin.macroenabled.12', 0, 'application'),
(952, NULL, '2022-06-02 15:38:57', 1, 1, 's', 'text/x-asm', 0, 'text'),
(953, NULL, '2022-06-02 15:38:57', 1, 1, 'azw', 'application/vnd.amazon.ebook', 0, 'application'),
(954, NULL, '2022-06-02 15:38:57', 1, 1, 'kon', 'application/vnd.kde.kontour', 0, 'application'),
(955, NULL, '2022-06-02 15:38:57', 1, 1, 'chrt', 'application/vnd.kde.kchart', 0, 'application'),
(956, NULL, '2022-06-02 15:38:57', 1, 1, 'xltx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template', 1, 'application'),
(957, NULL, '2022-06-02 15:38:57', 1, 1, 'smf', 'application/vnd.stardivision.math', 0, 'application'),
(958, NULL, '2022-06-02 15:38:57', 1, 1, 'smi', 'application/smil+xml', 0, 'application'),
(959, NULL, '2022-06-02 15:38:57', 1, 1, 'oxt', 'application/vnd.openofficeorg.extension', 0, 'application'),
(960, NULL, '2022-06-02 15:38:57', 1, 1, 'joda', 'application/vnd.joost.joda-archive', 0, 'application'),
(961, NULL, '2022-06-02 15:38:57', 1, 1, 'iso', 'application/x-iso9660-image', 0, 'application'),
(962, NULL, '2022-06-02 15:38:57', 1, 1, 'fxpl', 'application/vnd.adobe.fxp', 0, 'application'),
(963, NULL, '2022-06-02 15:38:57', 1, 1, 'smv', 'video/x-smv', 0, 'video'),
(964, NULL, '2022-06-02 15:38:57', 1, 1, 'nnd', 'application/vnd.noblenet-directory', 0, 'application'),
(965, NULL, '2022-06-02 15:38:57', 1, 1, 'svgz', 'image/svg+xml', 1, 'image'),
(966, NULL, '2022-06-02 15:38:57', 1, 1, 'dra', 'audio/vnd.dra', 0, 'audio'),
(967, NULL, '2022-06-02 15:38:57', 1, 1, 'osfpvg', 'application/vnd.yamaha.openscoreformat.osfpvg+xml', 0, 'application'),
(968, NULL, '2022-06-02 15:38:57', 1, 1, 'xml', 'application/xml', 0, 'application'),
(969, NULL, '2022-06-02 15:38:57', 1, 1, '123', 'application/vnd.lotus-1-2-3', 0, 'application'),
(970, NULL, '2022-06-02 15:38:57', 1, 1, 'cat', 'application/vnd.ms-pki.seccat', 0, 'application'),
(971, NULL, '2022-06-02 15:38:57', 1, 1, 'asf', 'video/x-ms-asf', 0, 'video'),
(972, NULL, '2022-06-02 15:38:57', 1, 1, 'nnw', 'application/vnd.noblenet-web', 0, 'application'),
(973, NULL, '2022-06-02 15:38:57', 1, 1, 'lrf', 'application/octet-stream', 0, 'application'),
(974, NULL, '2022-06-02 15:38:57', 1, 1, 'kpxx', 'application/vnd.ds-keypoint', 0, 'application'),
(975, NULL, '2022-06-02 15:38:57', 1, 1, 'nns', 'application/vnd.noblenet-sealer', 0, 'application'),
(976, NULL, '2022-06-02 15:38:57', 1, 1, 'dataless', 'application/vnd.fdsn.seed', 0, 'application'),
(977, NULL, '2022-06-02 15:38:57', 1, 1, 'asm', 'text/x-asm', 0, 'text'),
(978, NULL, '2022-06-02 15:38:57', 1, 1, 'aso', 'application/vnd.accpac.simply.aso', 0, 'application'),
(979, NULL, '2022-06-02 15:38:57', 1, 1, 'pbm', 'image/x-portable-bitmap', 0, 'image'),
(980, NULL, '2022-06-02 15:38:57', 1, 1, 'p12', 'application/x-pkcs12', 0, 'application'),
(981, NULL, '2022-06-02 15:38:57', 1, 1, 'lrm', 'application/vnd.ms-lrm', 0, 'application');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gender`
--

CREATE TABLE `gender` (
  `id` int NOT NULL,
  `description` varchar(20) DEFAULT NULL,
  `code` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `gender`
--

INSERT INTO `gender` (`id`, `description`, `code`) VALUES
(1, 'Feminino', 'f'),
(2, 'Masculino', 'm');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_edit`
--

CREATE TABLE `log_edit` (
  `id` int NOT NULL,
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `register_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int DEFAULT NULL,
  `old_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `new_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `log_edit`
--

INSERT INTO `log_edit` (`id`, `object_name`, `register_id`, `create_date`, `update_date`, `create_user_id`, `old_value`, `new_value`, `field`) VALUES
(62, 'curriculum', '4', '2025-04-09 15:53:49', NULL, 120, '6500.00', '7200', 'salary_claim'),
(63, 'curriculum', '5', '2025-04-09 16:36:44', NULL, 121, '9500.00', '10500', 'salary_claim'),
(64, 'curriculum', '6', '2025-04-09 18:24:40', NULL, 123, '7000.00', '5500', 'salary_claim');

-- --------------------------------------------------------

--
-- Estrutura para tabela `marital_status`
--

CREATE TABLE `marital_status` (
  `id` int NOT NULL,
  `code` char(1) NOT NULL,
  `description` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `marital_status`
--

INSERT INTO `marital_status` (`id`, `code`, `description`) VALUES
(1, 'c', 'Casado(a)'),
(2, 'd', 'Divorciado(a)'),
(3, 'u', 'União Estável'),
(4, 's', 'Solteiro(a)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `parameter`
--

CREATE TABLE `parameter` (
  `id` int NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `default_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `parameter`
--

INSERT INTO `parameter` (`id`, `description`, `code`, `create_date`, `update_date`, `create_user_id`, `value`, `default_value`) VALUES
(1, 'Nome do Aplicativo', 'system_name', '2024-03-07 15:48:46', '2024-03-07 05:36:26', NULL, 'Unimestre Case - William G. Marquetti', 'WillCode Portal'),
(2, 'Url Base', 'base_url', '2024-03-07 15:48:46', '2024-10-16 02:33:03', NULL, 'http://unimestre.local', 'http://portal.willcode.local/'),
(3, 'Tamanho Máximo Imagem de Perfil (kb)', 'profile_image_max_size', '2024-03-09 15:27:05', NULL, NULL, '1000', '1000'),
(9, 'Assunto do email para convite de usuário', 'user_invite_email_subject', '2024-05-31 14:18:19', '2024-09-11 03:54:49', NULL, 'Unimestre Case - Registre seu usuário', 'Registre seu usuário no portal'),
(10, 'Texto do email para convite de usuário', 'user_invite_email_text', '2024-05-31 14:18:19', NULL, NULL, 'Você foi convidado para participar da plataforma, clique no botão abaixo e conclua seu registro', 'Você foi convidado para participar da plataforma, clice no botão abaixo e conclua seu registro'),
(11, 'Assunto do email para recuperação de senha', 'user_reset_password_email_subject', '2024-05-31 14:18:19', '2024-09-11 03:55:00', NULL, 'Unimestre Case - Solicitação de Recuperação de Senha', 'Solicitação de Recuperação de senha'),
(12, 'Texto do email para convite de usuário', 'user_reset_password_email_text', '2024-05-31 14:18:19', NULL, NULL, 'Foi solicitada a recuperação de senha do seu usuário. Para realizar alteração clique no botão abaixo', 'Foi solicitada a recuperação de senha do seu usuário. Para realizar alteração clicque no botão abaixo'),
(14, 'Cor Inicial Degradê ', 'gradient_color_start', '2024-06-07 14:07:29', NULL, NULL, '#929697', '#929697'),
(15, 'Cor Final Degradê ', 'gradient_color_end', '2024-06-07 14:07:29', NULL, NULL, '#2b3147', '#1b395b'),
(16, 'Logo padrão', 'default_logo', '2024-06-07 14:17:26', NULL, NULL, 'logo_wcode.png', 'null'),
(17, 'Idioma Padrão', 'default_language', '2024-06-08 09:00:19', NULL, NULL, 'pt_br', 'pt_br'),
(21, 'Atributos do Logo Principal', 'main_logo_img_attr', '2024-06-07 14:01:47', NULL, NULL, 'width=\"65\" style=\"margin-top: -20px;margin-left: 50px;\"', 'width=\"65\" style=\"margin-top: -20px;margin-left: 50px;\"'),
(22, 'Caminho Logo Principal', 'main_logo_path', '2024-06-07 14:01:47', NULL, NULL, '/assets/img/logo_unimestre.png', '/assets/img/wcode.png'),
(23, 'Caminho Logo Pequeno', 'small_logo_path', '2024-06-07 14:01:47', NULL, NULL, '/assets/img/logo_unimestre.png', '/assets/img/wcode.png'),
(24, 'Atributos do Logo Pequeno', 'small_logo_img_attr', '2024-06-07 14:01:47', NULL, NULL, 'style=\"margin-top: -4px;margin-left: -6px;\"', 'width=\"65\" style=\"margin-top: -20px;margin-left: 50px;\"'),
(25, 'Caminho Logo Tela Login', 'login_logo_path', '2024-06-07 14:01:47', NULL, NULL, '/assets/img/logo_unimestre.png', '<img src=\"/assets/img/logo.png\" class=\'login_logo\' alt=\"logo\">'),
(26, 'Atributos do Logo Login', 'login_logo_img_attr', '2024-06-07 14:01:47', NULL, NULL, 'class=\'login_logo\' alt=\'logo\'', 'width=\"65\" style=\"margin-top: -20px;margin-left: 50px;\"'),
(27, 'Permite Login de Equipamento Pela INterface', 'enable_interface_equipment_login', '2024-06-07 14:01:47', NULL, NULL, 'false', 'false'),
(28, 'Cor Base', 'custom_color', '2024-10-24 14:21:40', NULL, NULL, '#07020a', NULL),
(29, 'Cor secundária', 'color_secondary', '2024-10-24 14:26:51', NULL, NULL, '#4a464d', NULL),
(30, 'Cor Primária', 'color_primary', '2024-10-24 14:31:36', NULL, NULL, '#07020a', NULL),
(31, 'Utiliza Cores padrão', 'use_default_colors', '2024-10-24 14:45:07', NULL, NULL, 'false', NULL),
(32, 'Cor sucesso', 'color_success', '2024-10-24 14:26:51', NULL, NULL, '#7b7f85', NULL),
(33, 'Cor erro', 'color_danger', '2024-10-24 16:22:52', NULL, NULL, '#f06565', NULL),
(34, 'Cor informação', 'color_info', '2024-10-24 16:22:52', NULL, NULL, '#098596', NULL),
(35, 'Cor aviso', 'color_warning', '2024-10-24 16:22:52', NULL, NULL, '#e79702', NULL),
(36, 'Cor cabeçalho', 'color_header', '2024-10-24 16:22:52', NULL, NULL, '#07020a', NULL),
(37, 'Caminho Logo email', 'email_logo_path', '2024-06-07 14:01:47', NULL, NULL, '/assets/img/logo_unimestre.png', '<img src=\"/assets/img/logo.png\" class=\'login_logo\' alt=\"logo\">'),
(38, 'Atributos do Logo email', 'email_logo_img_attr', '2024-06-07 14:01:47', NULL, NULL, 'class=\'email_logologo\' alt=\'logo\' width=\'200\'', 'width=\"65\" style=\"margin-top: -20px;margin-left: 50px;\"'),
(39, 'Nome do Remetente de Email', 'mail_sender_name', '2024-03-07 15:48:46', '2024-03-07 05:36:26', NULL, 'Unimestre Case - William Gustavo Marquetti', 'WillCode Portal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `permission`
--

CREATE TABLE `permission` (
  `id` int NOT NULL,
  `code` varchar(200) NOT NULL,
  `description` varchar(250) NOT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `permission`
--

INSERT INTO `permission` (`id`, `code`, `description`, `active`) VALUES
(1, 'user_create', 'Usuários - Criar', 1),
(2, 'user_edit', 'Usuários - Editar', 1),
(3, 'user_delete', 'Usuários - Excluir', 1),
(4, 'user_list', 'Usuários - Listar', 1),
(61, 'user_group_create', 'Grupos de Usuário - Criar', 0),
(62, 'user_group_edit', 'Grupos de Usuário - Editar', 0),
(63, 'user_group_delete', 'Grupos de Usuário - Excluir', 0),
(72, 'user_group_list', 'Grupos de Usuário - Listar', 0),
(80, 'process_list', 'Processos - Listar', 0),
(81, 'process_edit', 'Processos - Editar', 0),
(82, 'process_delete', 'Processos - Excluir', 0),
(83, 'process_change_status', 'Processos - Alterar Status', 0),
(84, 'process_create', 'Processos - Criar', 0),
(89, 'company_create', 'Empresas - Criar', 0),
(90, 'company_list', 'Empresas - Listar', 0),
(91, 'company_edit', 'Empresas - Editar', 0),
(92, 'company_delete', 'Empresas - Excluir', 0),
(93, 'company_group_create', 'Grupo de Empresas - Criar', 0),
(94, 'company_group_list', 'Grupo de Empresas  - Listar', 0),
(95, 'company_group_edit', 'Grupo de Empresas - Editar', 0),
(96, 'company_group_delete', 'Grupo de Empresas - Excluir', 0),
(105, 'parameter_list', 'Parâmetros - Listar', 0),
(106, 'parameter_create', 'Parâmetros - Criar', 0),
(107, 'parameter_edit', 'Parâmetros - Editar', 0),
(108, 'parameter_delete', 'Parâmetros - Excluir', 0),
(121, 'curriculum_list', 'Listar Currículos', 1),
(122, 'curriculum_create', 'Criar Currículos', 1),
(123, 'curriculum_edit', 'Editar Currículos', 1),
(124, 'curriculum_delete', 'Excluir Currículos', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `create_user_id` int DEFAULT NULL,
  `code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `create_date`, `update_date`, `active`, `create_user_id`, `code`) VALUES
(6, 'Candidato', '2025-04-09 10:47:43', NULL, 1, NULL, 'CND');

-- --------------------------------------------------------

--
-- Estrutura para tabela `permission_group_permission`
--

CREATE TABLE `permission_group_permission` (
  `id` int NOT NULL,
  `permission_group_id` int NOT NULL,
  `permission_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Relacionamento de usuário com permissões';

--
-- Despejando dados para a tabela `permission_group_permission`
--

INSERT INTO `permission_group_permission` (`id`, `permission_group_id`, `permission_id`) VALUES
(72, 6, 121),
(73, 6, 122),
(74, 6, 123);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(200) NOT NULL COMMENT 'Utilizado para fazer login',
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(250) NOT NULL,
  `api_token` varchar(200) DEFAULT NULL COMMENT 'Token para autenticação via API',
  `update_date` datetime DEFAULT NULL,
  `permission_group_id` int DEFAULT NULL,
  `create_user_id` int DEFAULT NULL,
  `language_code` varchar(10) DEFAULT NULL,
  `verify_token` varchar(100) DEFAULT NULL COMMENT 'Token de verificação para registro e recuperação de senha',
  `verify_token_expiration` datetime DEFAULT NULL COMMENT 'Expiração to token de verificação',
  `role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `seller` tinyint(1) DEFAULT '0',
  `client` tinyint(1) DEFAULT '0',
  `supplier` tinyint(1) DEFAULT '0',
  `profile_picture_url` varchar(250) DEFAULT NULL,
  `token_type` varchar(100) DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `company_group_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Cadastro de usuários';

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`, `create_date`, `active`, `name`, `api_token`, `update_date`, `permission_group_id`, `create_user_id`, `language_code`, `verify_token`, `verify_token_expiration`, `role`, `seller`, `client`, `supplier`, `profile_picture_url`, `token_type`, `company_id`, `company_group_id`) VALUES
(1, 'admin', 'admin@willcode.tech', '348d08a66034be4699aaed27f5b6205c', '2023-10-09 10:57:35', 1, 'Administrador', 'ba8d6f9d3199aa173290f9bd5f3863de', '2024-07-10 03:09:07', NULL, NULL, NULL, NULL, NULL, 'admin', 0, 0, 0, '/api/?api=file&action=get&hash=MjAyNC0wNi0wN18wMS0wNl9vQTNKOW56OVAwRDNUNEhUQUNUVWRCT0FK', NULL, 1, NULL),
(120, 'teste', 'email@email.com', 'd4f3a251e07d6e8afadc4739f2877ae5', '2025-04-09 10:51:32', 1, 'João Silva', '57a19bd12988edb4047870f89989a2c1', NULL, 6, NULL, NULL, NULL, NULL, 'user', 0, 0, 0, NULL, NULL, NULL, NULL),
(121, 'thiago.andregtoni', 'falecomthiago@outlook.com.br', '3ac22d433964b887fd2179447cb20e99', '2025-04-09 16:15:58', 1, 'Thiago', 'a68086e7a5058485de3f541161d19506', NULL, 6, NULL, NULL, NULL, NULL, 'user', 0, 0, 0, NULL, NULL, NULL, NULL),
(122, 'unimestre', 'unimestre@willcode.tech', '23474d0ac91da83b58e49a07109cab37', '2025-04-09 16:43:26', 1, 'Unimestre - Admin', 'e579d46fb71ab0d69c25116bdbfd0aa3', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 0, 0, 0, NULL, NULL, NULL, NULL),
(123, 'unimestre_teste', 'teste@willcode.tech', '56f10e9b7e826a454b9c4f5e124ab1af', '2025-04-09 18:16:04', 1, 'Candidato Teste', '7c71588d282c42fcf1532b5c6ef7a04d', NULL, 6, NULL, NULL, NULL, NULL, 'user', 0, 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Relacionamento de usuário com permissões';

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `change_history`
--
ALTER TABLE `change_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_type_user_FK` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_create_user_id_FK` (`create_user_id`);

--
-- Índices de tabela `company_group`
--
ALTER TABLE `company_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_group_unique` (`code`),
  ADD KEY `fk_company_group_user_id_idx` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `company_group_company`
--
ALTER TABLE `company_group_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_group_FK0_idx` (`company_group_id`) USING BTREE,
  ADD KEY `company_group_FK_1` (`company_id`) USING BTREE;

--
-- Índices de tabela `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD KEY `fk_currency_user_id_idx` (`create_user_id`);

--
-- Índices de tabela `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curriculum_unique_user_Id` (`user_id`),
  ADD UNIQUE KEY `curriculum_unique` (`cpf`),
  ADD KEY `curriculum_user_id_IDX` (`user_id`) USING BTREE,
  ADD KEY `curriculum_cpf_IDX` (`cpf`) USING BTREE,
  ADD KEY `curriculum_gender_IDX` (`gender_id`) USING BTREE;

--
-- Índices de tabela `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `education_unique` (`code`);

--
-- Índices de tabela `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ID_UNIQUE` (`id`),
  ADD UNIQUE KEY `ARQUIVO_HASH` (`hash`),
  ADD UNIQUE KEY `ARQUIVO_HASH_IDX` (`hash`) USING BTREE,
  ADD KEY `fk_create_user_id_file` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `file_mime_type`
--
ALTER TABLE `file_mime_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unique` (`id`),
  ADD UNIQUE KEY `file_mime_type_unique_extension` (`extension`),
  ADD KEY `file_mime_type_create_user_id` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gender_unique` (`code`);

--
-- Índices de tabela `log_edit`
--
ALTER TABLE `log_edit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_type_user_FK` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `marital_status`
--
ALTER TABLE `marital_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marital_status_unique` (`code`);

--
-- Índices de tabela `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parameters_unique` (`code`),
  ADD KEY `product_type_user_FK` (`create_user_id`) USING BTREE;

--
-- Índices de tabela `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_UN_code` (`code`);

--
-- Índices de tabela `permission_group`
--
ALTER TABLE `permission_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_group_unique` (`code`),
  ADD KEY `fk_permission_group_user_id_idx` (`create_user_id`);

--
-- Índices de tabela `permission_group_permission`
--
ALTER TABLE `permission_group_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permission_FK_1` (`permission_id`),
  ADD KEY `user_permission_FK0_idx` (`permission_group_id`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_UN_login` (`login`),
  ADD UNIQUE KEY `user_UN_email` (`email`),
  ADD UNIQUE KEY `user_UN_verify_token` (`verify_token`),
  ADD KEY `fk_user_permission_group_id_idx` (`permission_group_id`),
  ADD KEY `fk_user_create_user_id_idx` (`create_user_id`);

--
-- Índices de tabela `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permission_FK` (`user_id`),
  ADD KEY `user_permission_FK_1` (`permission_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `change_history`
--
ALTER TABLE `change_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `company_group`
--
ALTER TABLE `company_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `company_group_company`
--
ALTER TABLE `company_group_company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de tabela `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `education`
--
ALTER TABLE `education`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `file`
--
ALTER TABLE `file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `file_mime_type`
--
ALTER TABLE `file_mime_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=982;

--
-- AUTO_INCREMENT de tabela `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `log_edit`
--
ALTER TABLE `log_edit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `marital_status`
--
ALTER TABLE `marital_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `parameter`
--
ALTER TABLE `parameter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de tabela `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `permission_group_permission`
--
ALTER TABLE `permission_group_permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de tabela `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `change_history`
--
ALTER TABLE `change_history`
  ADD CONSTRAINT `change_history_create_user_FK` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_create_user_id_FK` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `company_group`
--
ALTER TABLE `company_group`
  ADD CONSTRAINT `fk_company_group_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `fk_currency_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`);

--
-- Restrições para tabelas `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `fk_create_user_id_file` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`);

--
-- Restrições para tabelas `file_mime_type`
--
ALTER TABLE `file_mime_type`
  ADD CONSTRAINT `fk_ARQUIVO_MIME_TYPE_ID_USUARIO_INCLUSAO` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`);

--
-- Restrições para tabelas `log_edit`
--
ALTER TABLE `log_edit`
  ADD CONSTRAINT `log_edit_create_user_FK` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `parameter`
--
ALTER TABLE `parameter`
  ADD CONSTRAINT `parameters_create_user_FK` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `permission_group`
--
ALTER TABLE `permission_group`
  ADD CONSTRAINT `fk_permission_group_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`);

--
-- Restrições para tabelas `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`);

--
-- Restrições para tabelas `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_permission_FK_1` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
