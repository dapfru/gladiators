<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # main search unit :: главный модуль поиска                                #
 ############################################################################

$time=explode(' ', microtime());
$start_time=$time[1]+$time[0];
if (!isset($m)) $m="and";
if (!isset($from)) $from=1;
if (isset($query))
{
  $query=strtolower(trim(strip_tags($query)));
  $q=explode(" ",$query);
}
require("connect.php");
require("lang.php");
require("include/header.php");
require("include/footer.php");
session_start();
place_header($lang_srchtitle);
?>
  <form method=post action=wfsearchpro.php>
  <input name=query length=40 value='<?echo @$query;?>'><input type=submit value='<?echo $lang_search;?>'><br>
  <input type=radio checked name=m value=or><?echo $lang_usingor;?><br>
  <input type=radio name=m value=and><?echo $lang_usingand;?>
  </input>
  </form>
<?
  $result=mysql_query("select * from _wfspro_admin");
  $row=mysql_fetch_array($result);
  $real_loc=$row[@root];
  $desc_header=$row[@desc_header];
  $desc_footer=$row[@desc_footer];
  $color1=$row[@color1];
  $color2=$row[@color2];
  $pages=$row[@pages];

  if (isset($query))
  {
    $query=strtolower($query);
    mysql_query("drop table if exists tmp".$PHPSESSID."");
    if (mysql_error()) echo mysql_error();
    mysql_query("create table tmp".$PHPSESSID." (
     id int(12) not null auto_increment,
     dosearch int(12),
     execindex int(12),
     path text,
     content text,
     date datetime,
     pop int(12),
     keywords text,
     primary key (id))");

    if ($m=="or")
    // Search when even one word is match to query ("or")
    // Поиск с совпадением хотябы одного слова из запроса ("или")
    for ($i=0; $i<count($q); ++$i)
    {
      $request="insert into tmp".$PHPSESSID." select * from _wfspro_index where (((content regexp \"$q[$i]\") or (keywords regexp \"$q[$i]\")) and dosearch > 0)";
      mysql_query($request);
      if (mysql_error()) echo mysql_error()."<br>".$request;
    } else

    // Search with matching all words ("and")
    // Поиск с совпадением всех слов из запроса ("и")
    {
      $request="insert into tmp".$PHPSESSID." select * from _wfspro_index where (";
      for ($i=0; $i<count($q); $i++)
        $request.="((content regexp \"$q[$i]\") or (keywords regexp \"$q[$i]\")) and ";
      $request.="(dosearch > 0))";
      mysql_query($request);
      if (mysql_error()) echo mysql_error()."<br>".$request;
    }

    $result=mysql_query("select count(*) as count from tmp".$PHPSESSID);
    if (mysql_error()) echo mysql_error();
    $row=mysql_fetch_array($result);
    if (mysql_error()) echo mysql_error();
    $count=$row[@count];

    if ($count > 0)
    {
      $time=explode(' ', microtime());
      $seconds=($time[1]+$time[0]-$start_time);
      echo str_replace("%2", sprintf("%01.3f", $seconds), str_replace("%1", $count, $lang_wasfound));
      $result=mysql_query("select * from tmp".$PHPSESSID." order by pop desc");
      echo "<center><table width=95% cellspacing=0 cellpadding=1>\n";

      // Output beginning navigation bar
      // Вывести начальную панель навигации страниц
      echo "<tr bgcolor=#E4EBEF><td align=center>";
      for ($k=1; $k<=$count; $k+=$pages)
      {
        if ($k!=1) echo " :: ";
        echo "<a href=$PHP_SELF?query=".urlencode($query)."&m=$m&from=$k>$k-";
        if ($k+$pages>$count) echo $count; else echo ($k-1+$pages);
        echo "</a>";
      }
      echo "</td></tr>\n";

      $showed=0;

      while ($row=mysql_fetch_array($result))
      {
        ++$showed;
        if (mysql_error()) echo mysql_error();
        if (($showed>=$from) && ($showed<$from+$pages))
        {
          // output short description
          // вывести короткую аннотацию
          $path=str_replace($real_loc, "", $row[@path]);
          $fc=explode("*^!unique!^*", $row[@content]);
          if ($showed&1)
            echo "<tr><td bgcolor=$color2>\n";
          else
            echo "<tr><td bgcolor=$color1>\n";

          $occurrence=0;
          echo str_replace("%1", $showed, "<b><font color=black>%1)</b></font> ");
          echo "<a href=link.php?id=".$row[@id].">$path</a>\n";
          echo "<br>$desc_header";
          for ($i=0; $i<count($fc); ++$i)
          {
            $occ=0;
            $s=strtolower(strip_tags($fc[$i]));
            for ($j=0; $j<count($q); ++$j)
            {
              if (stristr($s, $q[$j]))
              {
                $s=str_replace($q[$j], "<b>$q[$j]</b>", $s);
                $occ=1;
              }
              else
              {
                $key=htmlentities($q[$j]);
                if (stristr($s, $key))
                {
                  $s=str_replace($key, "<b>$key</b>", $s);
                  $occ=1;
                }
              }
            }
            if ($occ)
            {
              $occ=0;
              echo "...$s...";
              ++$occurrence;
              if ($occurrence > 3) break;
            }
          }
          echo $desc_footer;

          echo "</td></tr>\n\n";
        }
      }

      // Output ending navigation bar
      // Вывести конечную панель навигации страниц
      echo "<tr bgcolor=#E4EBEF><td align=center>";
      for ($k=1; $k<=$count; $k+=$pages)
      {
        if ($k!=1) echo " :: ";
        echo "<a href=$PHP_SELF?query=".urlencode($query)."&m=$m&from=$k>$k-";
        if ($k+$pages>$count) echo $count; else echo ($k-1+$pages);
        echo "</a>";
      }
      echo "</td></tr>\n";

      echo "</table></center>";
    } else
    {
      $time=explode(' ', microtime());
      $seconds=($time[1]+$time[0]-$start_time);
      echo str_replace("%1", sprintf("%01.3f", $seconds), $lang_nofiles);
    }
    mysql_query("drop table if exists tmp".$PHPSESSID."");
    if (mysql_error()) echo mysql_error();
  } else echo $lang_noquery;
$time=explode(' ',microtime());
$seconds=($time[1]+$time[0]-$start_time);
echo "<p align=right><small>".str_replace("%1", sprintf("%01.3f", $seconds), $lang_generated)."</small></p>";
place_footer();
?>
