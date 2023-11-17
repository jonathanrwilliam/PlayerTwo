DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

SET @CREATE_DATE = '2023-09-01 09:01:01';
INSERT INTO `categories` (`id`, `name`, `description`, `created`) VALUES
(1, 'Eventos', 'Eventos culturais, Espetáculos, Festivais entre outros', @CREATE_DATE),
(2, 'Música', 'Música',  @CREATE_DATE),
(3, 'Filmes', 'Filmes, Séries e Audiovisual',  @CREATE_DATE),
(4, 'Livros', 'Livros, Revistas, Papelaria',  @CREATE_DATE),
(5, 'Desporto', 'Items desportivos',  @CREATE_DATE);

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;


INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `created`) VALUES
(1, 'Semana Académica - 2022', 'Fantástica experiência', '25', 1,  @CREATE_DATE),
(2, 'Dead Combo', 'Dead Combo Vol.I - 2004', '18', 2,  @CREATE_DATE),
(3, 'Paris, Texas', 'Wim Wenders, 1984', '5', 3,  @CREATE_DATE),
(4, 'O Homem Duplicado', 'José Saramago, 2002', '15', 4,  @CREATE_DATE),
(5, 'Kit Ping Pong', '2x raquetes, 6x bolas, rede amovível', '25', 5,  @CREATE_DATE),
(6, 'Snooker World Championship 2024', 'Crucible Theater - ESGOTADO', '0', 1, @CREATE_DATE);