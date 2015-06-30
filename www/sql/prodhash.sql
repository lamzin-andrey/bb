-- MySQL
DROP TABLE IF EXISTS `prodhash`;

CREATE TABLE IF NOT EXISTS `prodhash`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   region INTEGER COMMENT '����� �������',
   KEY `region` (`region`),
   city INTEGER COMMENT '����� ������',
   KEY `city` (`city`),
   category INTEGER COMMENT '����� ���������',
   KEY `category` (`category`),
   price DECIMAL(12,2) COMMENT '���������',
   title VARCHAR(255) COMMENT '��������� ����������',
   image VARCHAR(512) COMMENT '���� � ����� ����������� �� ����� �������',
   addtext VARCHAR(1000) COMMENT '����� ����������',
   uid INT(11) COMMENT '����� ������������',
   KEY `uid` (`uid`),
   `pinned` SMALLINT DEFAULT 0 COMMENT '��������� ������� �����',
   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '����� ���������� �������',
   date_top DATETIME COMMENT '�����, ����� ���������� �������� ������ ������� � ����� �������',
   count_down TINYINT DEFAULT 0 COMMENT '1 - ���������� �������� ��������, ������ �����',
   is_accepted INTEGER DEFAULT 0 COMMENT '�������������� ��',
   is_hide INTEGER DEFAULT 0 COMMENT '������ ��',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���.',
   delta INTEGER COMMENT '�������.'
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
