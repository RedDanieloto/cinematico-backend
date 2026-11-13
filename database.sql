-- ==========================================================
-- Base de Datos MySQL: cinematico
-- Tablas: Directores, Categorias, Peliculas
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `cinematico`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `cinematico`;

DROP TABLE IF EXISTS `Peliculas`;
DROP TABLE IF EXISTS `Directores`;
DROP TABLE IF EXISTS `Categorias`;

-- 1. Tabla Directores (IDDirector, Director)
CREATE TABLE `Directores` (
  `IDDirector` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Director` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`IDDirector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla Categorías (Identificador, Categoría)
CREATE TABLE `Categorias` (
  `Identificador` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Categoria` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Identificador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla Películas (Identificador, Titulo, IDDirector, Duración, IDCategoria, Sinopsis)
CREATE TABLE `Peliculas` (
  `Identificador` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Titulo` VARCHAR(200) NOT NULL,
  `IDDirector` BIGINT UNSIGNED NOT NULL,
  `Duracion` VARCHAR(50) NOT NULL,
  `IDCategoria` BIGINT UNSIGNED NOT NULL,
  `Sinopsis` TEXT NOT NULL,
  PRIMARY KEY (`Identificador`),
  CONSTRAINT `fk_peliculas_director`
    FOREIGN KEY (`IDDirector`) REFERENCES `Directores` (`IDDirector`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_peliculas_categoria`
    FOREIGN KEY (`IDCategoria`) REFERENCES `Categorias` (`Identificador`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- Datos iniciales (Seed)
-- ==========================================================

INSERT INTO `Directores` (`IDDirector`, `Director`) VALUES
(1, 'Christopher Nolan'),
(2, 'Guillermo del Toro'),
(3, 'Denis Villeneuve'),
(4, 'Greta Gerwig'),
(5, 'Hayao Miyazaki'),
(6, 'Alfonso Cuarón');

INSERT INTO `Categorias` (`Identificador`, `Categoria`) VALUES
(1, 'Ciencia Ficción'),
(2, 'Fantasía Oscura'),
(3, 'Acción y Aventura'),
(4, 'Comedia y Drama'),
(5, 'Animación'),
(6, 'Suspenso Espacial');

INSERT INTO `Peliculas` (`Identificador`, `Titulo`, `IDDirector`, `Duracion`, `IDCategoria`, `Sinopsis`) VALUES
(1, 'Interstellar', 1, '169 min', 1, 'Un grupo de exploradores espaciales viaja a través de un agujero de gusano cerca de Saturno en busca de un nuevo hogar para la humanidad mientras la Tierra agoniza.'),
(2, 'El Laberinto del Fauno', 2, '118 min', 2, 'En la España de 1944, la joven Ofelia descubre un antiguo laberinto habitado por un fauno que le revela que ella es la reencarnación de una princesa subterránea y debe superar tres pruebas.'),
(3, 'Dune: Parte Dos', 3, '166 min', 1, 'Paul Atreides se une a Chani y a los Fremen mientras busca venganza contra los conspiradores que destruyeron a su familia en el desierto de Arrakis.'),
(4, 'Oppenheimer', 1, '180 min', 4, 'La historia del físico estadounidense J. Robert Oppenheimer y su papel al frente del Proyecto Manhattan en el desarrollo de la primera arma nuclear durante la Segunda Guerra Mundial.'),
(5, 'El Viaje de Chihiro', 5, '125 min', 5, 'Chihiro, una niña de diez años, queda atrapada en un mundo mágico gobernado por dioses, brujas y espíritus, donde los humanos son transformados en bestias y debe trabajar en una casa de baños para liberar a sus padres.'),
(6, 'Gravity', 6, '91 min', 6, 'Dos astronautas quedan a la deriva en la inmensidad del espacio tras la destrucción de su transbordador por desechos orbitales y deben encontrar la forma de regresar a la Tierra.');
