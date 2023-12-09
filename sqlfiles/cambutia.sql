SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `cliente` (`id`, `nome`, `cpf`, `telefone`) VALUES
(1, 'MAGNO ALEXANDRE', '018.831.314-13', '(84) 99966-3245'),
(2, 'MARIA DO CEU B. FONSECA', '323.866.994-04', '(84) 99225-1870');

DROP TABLE IF EXISTS `detalhespedido`;
CREATE TABLE IF NOT EXISTS `detalhespedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `detalhespedido` (`id`, `pedido_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 1),
(3, 2, 1, 2),
(4, 3, 4, 1);

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `hora_pedido` time NOT NULL,
  `data_pedido` date NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pedido` (`id`, `id_cliente`, `hora_pedido`, `data_pedido`, `endereco`, `pagamento`) VALUES
(1, 1, '15:00:00', '2023-10-22', 'RUA HIROSHI IENAGA,1170 BLO E APTO 305 - PAJUÇARA', 'crédito - ENTREGA'),
(2, 1, '15:59:00', '2023-10-22', 'dos pegas', 'Espécie - ENTREGA'),
(3, 2, '10:00:00', '2023-10-22', 'RUA SALGUEIRO,46 PAJUÇARA I', 'Crédito - ENTREGA');

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `produto` (`id`, `nome`, `descricao`, `preco`) VALUES
(1, 'KIT DO MEIDIA', '05 MARMITAS CASEIRA', '115.00'),
(2, 'KIT FITNESS', '05 MARMITAS FIT COM 350G', '110.00'),
(3, 'KIT LOW CARD', '05 MARMITAS LOW CARD 300G', '110.00'),
(4, 'KIT VEGANO', '05 MARMITAS COMIDA VEGANA 350G', '120.00');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
