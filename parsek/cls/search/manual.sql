 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # manual filling of MySQL tables :: ручная установка MySQL таблиц          #
 ############################################################################

 # Создание используемой базы
create database wfsearch_pro;
use wfsearch_pro;

 # Таблица индекса
create table _wfspro_index (
  id int(12) not null auto_increment default '1',
  dosearch int(12),
  path text,
  content text,
  date datetime,
  pop int(12),
  keywords text,
  primary key (id)
);

 # Таблица администратора
create table _wfspro_admin (
  id int(12) not null auto_increment default '1',
  pwd text,
  lastindex datetime,
  indexed int(12),
  allowed text,
  disallowed text,
  root text,
  desc_header text,
  desc_footer text,
  color1 text,
  color2 text,
  startpath text,
  pages int(12),
  language text,
  primary key (id)
);

 # Заполнение значений таблицы администратора
insert into _wfspro_admin (
  indexed, allowed, disallowed, desc_header, desc_footer, color1, color2, startpath, pages, language, root)
  values(0,'.php,.htm,.html,.txt','wfsearchpro.php,admin.php,admin2.php,connect.php,link.php,header.php,footer.php,english.php,russian.php','<font size=-1>','</font>','#F0F0F0','#D0D0D0','..\.',5,'english.php',''
);
