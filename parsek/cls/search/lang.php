<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # language selecting unit :: модуль выбора языка                           #
 ############################################################################

 include("language/english.php");
 $result=mysql_query("select * from _wfspro_admin");
 $row=@mysql_fetch_array($result);
 if (!mysql_error())
 {
   if (file_exists("language/".$row[@language]))
     include("language/".$row[@language]);
 }
?>