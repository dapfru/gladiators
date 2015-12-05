<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # first administration tool :: первый модуль администрирования             #
 ############################################################################

unset($ok);
require("session.php");
require("lang.php");

if ((isset($ok)) && (@$ok=="ok")) header ("Location: admin2.php");

// Search language files
// Поиск языковых файлов
$lang_files=array();
@$dir=opendir("./language/");
if ($dir)
{
  while (($f=readdir($dir))!==false)
  {
    if ((!is_dir($f) && (strpos($f,".php")))) array_push($lang_files, $f);
  }
  closedir($dir);
}

echo "<html>\n".
     "<title>WFSearch Engine Pro - $lang_admtitle</title>\n".
     "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang_codepage\">\n".
     "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n".
     "<link href=\"wfsearch.css\" rel=\"stylesheet\" type=\"text/css\">\n".
     "<body><p>\n";

if (isset($new_password))
{
  if ((!isset($pwd1)) || (!isset($pwd2)) || ($pwd1 != $pwd2))
  {
    echo $lang_wrongpwd1;
  } else
  {
    mysql_query("update _wfspro_admin set pwd='".md5($pwd1)."'") or die(mysql_error());
    echo $lang_step1ok;
  }
} else
{
  $result=mysql_query("select * from _wfspro_admin");
  $row=@mysql_fetch_array($result);
  if (mysql_errno()==1146)
  {
    // Initial language selecting
    // Начальный выбор языка
    for ($i=0; $i<count($lang_files); $i++)
    {
      include("language/".$lang_files[$i]);
      echo $lang_install."<hr>";
    }
    echo "</p></body></html>";
    die();
  }
  if (mysql_error()) echo mysql_error();
  if (@$row[pwd]=="")
  {
    echo $lang_first;
    ?>
    <center>
    <form action="admin.php" method=post>
      <input type=hidden name=new_password>
      <table border=0>
      <tr><td><?echo $lang_inputpwd;?></td><td><input type=password name=pwd1></td></tr>
      <tr><td><?echo $lang_repeatpwd;?></td><td><input type=password name=pwd2></td></tr>
      <tr><td></td><td align=right><input type=submit value="   Ok   "></td></tr>
      </table>
    </form>
    </center>
    <?
  } else
  {
    echo "<p align=justify>&nbsp;&nbsp;&nbsp;$lang_admin1</p>";
    if (isset($wrong))
    {
      echo "<p align=justify><b>$lang_wrongpwd2</b><p>";
      session_destroy();
    }
    ?>
    <form action="admin2.php" method=post>
      <input type=hidden name=auth>
      <table border=0>
      <tr><td><?echo $lang_inputpwd;?></td><td><input type=password name=password></td></tr>
      <tr><td></td><td align=right><input type=submit value="   Ok   "></td></tr>
      </table>
    </form>
    <?
  }
}
?>
</body>
</html>
