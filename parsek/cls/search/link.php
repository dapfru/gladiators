<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # redirect file :: файл перехода                                           #
 ############################################################################

  require("connect.php");
  require("include/header.php");
  require("include/footer.php");
  require("lang.php");

  function if_mysql_error()
  {
  global $lang_idgoerr;
  if (mysql_error())
    {
      place_header();
      echo $lang_idgoerr." '$id'.<br>";
      echo mysql_error();
      place_footer();
      die("");
    }
  }

  $result=mysql_query("select * from _wfspro_admin");
  if_mysql_error();
  $row=mysql_fetch_array($result);
  if_mysql_error();
  $real_loc=$row[@root];

  if (isset($id))
  {
    mysql_query("update _wfspro_index set pop=pop+1 where id='$id'");
    if_mysql_error();
    $result=mysql_query("select * from _wfspro_index where id='$id'");
    $row=mysql_fetch_array($result);
    if_mysql_error();
    $path=str_replace($real_loc, "", $row[@path]);
    header("Location: ".$path);
  }
  else
  {
    place_header();
    echo $lang_idgoerr." '$id'.";
    place_footer();
  }
?>