CREATE DATABASE pbook;
USE pbook;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `is_admin` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `libros` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `author` varchar(50) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `year` int(11) DEFAULT NULL,
    `category` varchar(25) DEFAULT NULL,
    `img_url` varchar(255) DEFAULT 'https://edit.org/images/cat/portadas-libros-big-2019101610.jpg',
    `user_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_libros_usuarios` (`user_id`),
    CONSTRAINT `FK_libros_usuarios` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;