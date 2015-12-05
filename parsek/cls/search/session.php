<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # session file :: файл регистрации сессий                                  #
 ############################################################################

  require("connect.php");
  session_start();
  session_register("password");
  session_register("ok");
  $request="select * from _wfspro_admin";
  $result=mysql_query($request);
  $row=@mysql_fetch_array($result);
  if (@$row[pwd]==@md5($password))
  {
    $ok="ok";
  }
?>
