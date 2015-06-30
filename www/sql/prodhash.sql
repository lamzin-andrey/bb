-- MySQL
DROP TABLE IF EXISTS `prodhash`;

CREATE TABLE IF NOT EXISTS `prodhash`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   region INTEGER COMMENT 'Номер региона',
   KEY `region` (`region`),
   city INTEGER COMMENT 'Номер города',
   KEY `city` (`city`),
   category INTEGER COMMENT 'Номер категории',
   KEY `category` (`category`),
   price DECIMAL(12,2) COMMENT 'Стоимость',
   title VARCHAR(255) COMMENT 'Заголовок объявления',
   image VARCHAR(512) COMMENT 'Путь к файлу изображений от корня сервера',
   addtext VARCHAR(1000) COMMENT 'Текст объявления',
   uid INT(11) COMMENT 'Номер пользователя',
   KEY `uid` (`uid`),
   `pinned` SMALLINT DEFAULT 0 COMMENT 'Закреплен наверху ленты',
   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Время публикации проекта',
   date_top DATETIME COMMENT 'Время, когда объявление достигло первой позиции в своем разделе',
   count_down TINYINT DEFAULT 0 COMMENT '1 - Объявление достигло верхушки, отсчет начат',
   is_accepted INTEGER DEFAULT 0 COMMENT 'Промодерирован ли',
   is_hide INTEGER DEFAULT 0 COMMENT 'Скрыто ли',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет.',
   delta INTEGER COMMENT 'Позиция.'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS `biprodhash`;

DELIMITER //

CREATE TRIGGER  `biprodhash` BEFORE INSERT ON `prodhash`
FOR EACH ROW BEGIN
 SET NEW.delta = (SELECT max(delta) FROM `prodhash`) + 1;
 IF NEW.delta IS NULL THEN
     SET NEW.delta = 1;
 END IF;
END//

DELIMITER ;

;
