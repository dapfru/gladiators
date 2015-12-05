CREATE TABLE `en_permissions` (
  `PermissionID` int(11) NOT NULL auto_increment,
  `Type` varchar(20) default NULL,
  `Name` varchar(20) default NULL,
  `TypeID` int(11) default NULL,
  `UserID` int(11) default NULL,
  `Ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`PermissionID`),
  KEY `Ts` (`Ts`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=9 ;


CREATE TABLE `en_menu` (
  `MenuID` int(11) NOT NULL auto_increment,
  `Title` varchar(20) NOT NULL,
  `Name_rus` varchar(50) default NULL,
  `Name_eng` varchar(50) default NULL,
  `Name_ger` varchar(50) default NULL,
  `Url` varchar(150) default NULL,
  `Rang` tinyint(4) NOT NULL,
  `Icon` varchar(50) NOT NULL,
  `Icon_width` tinyint(4) NOT NULL,
  `Parent` int(11) default NULL,
  `Target` varchar(10) NOT NULL,
  `Ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`MenuID`),
  KEY `Ts` (`Ts`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;


INSERT INTO `en_permissions` VALUES (1, '*', '', 0, 1, '2006-07-06 20:25:30');

INSERT INTO `en_permissions` VALUES (2, '*', '', 0, 51, '2006-07-06 20:25:30');
-- --------------------------------------------------------

-- 
-- Структура таблицы `en_project`
-- 

CREATE TABLE `en_project` (
  `Name` varchar(255) default NULL,
  `Author` varchar(255) default NULL,
  `Synchro` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `en_project`
-- 

INSERT INTO `en_project` VALUES ('', 'Nekki', '2006-07-14 19:45:07');

-- --------------------------------------------------------

-- 
-- Структура таблицы `en_synchronize`
-- 

CREATE TABLE `en_synchronize` (
  `RecordID` int(11) NOT NULL auto_increment,
  `TableName` varchar(30) default NULL,
  `IDName` varchar(20) default NULL,
  `TS` datetime default NULL,
  PRIMARY KEY  (`RecordID`),
  KEY `TS` (`TS`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=25 ;

-- 
-- Дамп данных таблицы `en_synchronize`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `en_table_images`
-- 

CREATE TABLE `en_table_images` (
  `RecordID` int(11) NOT NULL auto_increment,
  `TableName` varchar(30) default NULL,
  `FieldName` varchar(20) default NULL,
  `IDName` varchar(20) default NULL,
  `Format` varchar(5) default 'jpeg',
  `Ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`RecordID`),
  KEY `Ts` (`Ts`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=9 ;

-- 
-- Дамп данных таблицы `en_table_images`
-- 

INSERT INTO `en_table_images` VALUES (1, 'ut_materials', 'Image', 'MaterialID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (2, 'ut_materials', 'Small', 'MaterialID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (3, 'ut_screenshots', 'ScreenshotFile', 'ScreenshotID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (4, 'ut_screenshots', 'Small', 'ScreenshotID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (5, 'ut_users', 'Image', 'UserID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (6, 'ut_users', 'Small', 'UserID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (7, 'ut_projects', 'Image', 'ProjectID', 'jpeg', '0000-00-00 00:00:00');
INSERT INTO `en_table_images` VALUES (8, 'ut_projects', 'Small', 'ProjectID', 'jpeg', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Структура таблицы `lk_messages`
-- 

CREATE TABLE `lk_messages` (
  `MessageID` int(11) NOT NULL auto_increment,
  `rus` varchar(255) default NULL,
  `eng` varchar(255) default NULL,
  `TypeID` int(11) NOT NULL default '0',
  `Ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`MessageID`),
  KEY `Ts` (`Ts`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=9 ;

-- 
-- Дамп данных таблицы `lk_messages`
-- 

INSERT INTO `lk_messages` VALUES (1, 'Тест', 'Test', 0, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (2, 'Добавить', 'Add', 0, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (3, 'Список', 'List', 0, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (5, 'Не введен логин', 'Please write your login', 2, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (6, 'Создать', 'Create', 1, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (7, 'Неправильный пароль', 'Password is wrong', 1, '0000-00-00 00:00:00');
INSERT INTO `lk_messages` VALUES (8, 'Пользователь с таким логином не найден', 'No user with such login', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Структура таблицы `lk_system`
-- 

CREATE TABLE `lk_system` (
  `MessageID` int(11) NOT NULL auto_increment,
  `rus` varchar(255) default NULL,
  `eng` varchar(255) default NULL,
  `ger` varchar(255) default NULL,
  `TypeID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`MessageID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

-- 
-- Дамп данных таблицы `lk_system`
-- 

INSERT INTO `lk_system` VALUES (1, 'Удалить', 'Delete', '', 1);
INSERT INTO `lk_system` VALUES (2, 'Редактировать', 'Edit', '', 1);
INSERT INTO `lk_system` VALUES (3, 'В таблице уже есть ', 'Not unique value', '', 1);
INSERT INTO `lk_system` VALUES (4, 'Файл не загружен', 'File was not uploaded', 'Datei wurde nicht hinaufgeladen', 1);
INSERT INTO `lk_system` VALUES (5, 'Загружайте файлы с расширением', 'Upload only files like', 'Hinaufgeladen Sie bitte nur Dateien wie', 1);
INSERT INTO `lk_system` VALUES (6, 'Значение', 'The value of', 'Die Zahl', 1);
INSERT INTO `lk_system` VALUES (7, 'не уникально', 'is not unique', 'ist schon belegt', 1);
INSERT INTO `lk_system` VALUES (8, 'Неправильный формат', 'Wrong format of', 'Falsches Format', 1);
INSERT INTO `lk_system` VALUES (9, 'Вы должны ввести', 'You should enter', 'Schreiben Sie bitte', 1);
INSERT INTO `lk_system` VALUES (10, 'Длина поля', 'The length of', 'Die Zahl der Symbolen', 1);
INSERT INTO `lk_system` VALUES (11, 'не должна превышать', 'should be less than', 'soll nicht mehr sein als', 1);
INSERT INTO `lk_system` VALUES (12, 'не должна быть меньше', 'should not be less than', 'soll nicht weniger sein als', 1);
INSERT INTO `lk_system` VALUES (13, 'не должно превышать', 'should not be more than', 'soll weniger sein als', 1);
INSERT INTO `lk_system` VALUES (14, 'не должно быть ниже', 'should not be less than', 'soll mehr sein als', 1);
INSERT INTO `lk_system` VALUES (15, 'и', 'and', 'und', 1);
      CREATE TABLE `ut_users` (
  `UserID` int(10) unsigned NOT NULL auto_increment,
  `Date` int(11) NOT NULL,
  `Lang` char(3) NOT NULL,
  `Login` varchar(30) default NULL,
  `Avatar` mediumblob,
  `Approved` tinyint(4) NOT NULL,
  `Small` blob NOT NULL,
  `FirstName` varchar(30) default NULL,
  `LastName` varchar(30) default NULL,
  `BirthDate` date default NULL,
  `Gender` tinyint(4) default NULL,
  `Email` varchar(30) default NULL,
  `CountryID` int(11) default NULL,
  `City` varchar(30) default NULL,
  `Url` varchar(40) default NULL,
  `Icq` varchar(20) default NULL,
  `Study` varchar(30) default NULL,
  `Work` varchar(30) default NULL,
  `Job` varchar(30) default NULL,
  `Club` varchar(30) default NULL,
  `Player` varchar(30) default NULL,
  `Music` varchar(30) default NULL,
  `Hobby` text,
  `Games` varchar(100) default NULL,
  `Adver` varchar(50) NOT NULL default '',
  `Password` varchar(32) default NULL,
  `Rang` tinyint(4) NOT NULL,
  `Info` varchar(255) NOT NULL,
  `Internet` tinyint(4) NOT NULL,
  `Education` tinyint(4) NOT NULL,
  `Occupation` tinyint(4) NOT NULL,
  `SocialStatus` tinyint(4) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  `Inchat` int(11) NOT NULL,
  `MarketDate` int(11) NOT NULL,
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=54 ;

-- 
-- Дамп данных таблицы `ut_users`
-- 

INSERT INTO `ut_users` VALUES (1, 0, 'rus', 'Outlaw', 0x47494638396112001200c41800d4d2d547414dffffff554a5e2a22292922283326374d42518f8f91807c8445424b3d303e4d404d2e242c1531193324314d424c493443493e4d40303ef2f8f23a324047414799909dffffff00000000000000000000000000000000000000000021f90401000018002c000000001200120000057520268a940459162451633b1ace54559363b8d8a00407f32c02c1e2c1380414030c212060060009042201703609856613c0bd5cb8556da1e1049bc1ce06617b6e330991417b0e1844720326bd39488ef4734d38806d822e4c0285862d888a0183418e908967418f879485978c019d9e9f9b38a22e21003b, 0, 0x47494638396112001200c41800d4d2d547414dffffff554a5e2a22292922283326374d42518f8f91807c8445424b3d303e4d404d2e242c1531193324314d424c493443493e4d40303ef2f8f23a324047414799909dffffff00000000000000000000000000000000000000000021f90401000018002c000000001200120000057520268a940459162451633b1ace54559363b8d8a00407f32c02c1e2c1380414030c212060060009042201703609856613c0bd5cb8556da1e1049bc1ce06617b6e330991417b0e1844720326bd39488ef4734d38806d822e4c0285862d888a0183418e908967418f879485978c019d9e9f9b38a22e21003b, 'Дмитрий', 'Терёхин', '1984-03-12', 0, 'manowar@manowar.ru', 0, 'Москва', 'http://www.butsa.ru', '', 'МИФИ', 'Nekki', '', 'Динамо М', '', 'Рок, металл', '', '', 'оттуда', 'fb1bc5ff751d7733e3751de1277be424', 3, '', 1, 4, 4, 1, 1, 0, 1153464287);
INSERT INTO `ut_users` VALUES (51, 0, 'rus', 'Dinadan', '', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0, '', 0, 0, 0, 0, 1, 0, 1153407995);
