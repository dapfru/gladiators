<?
if($form->hint) print "<br>".hint($form->hint,$form->pageid)."<br>";


print "<center><img src=\"/images/line-sep4.gif\" width=491 height=30><br><a href=\"$PHP_SELF?act=insert&type=$type\" class=black>".message(2)."</a> |
 <a href=\"$PHP_SELF?type=$type\"  class=black>".message(3)."</a>  
<br><img src=\"/images/line-sep4.gif\" width=491 height=30></center>"; 



print "</center><br>";



print "</table></td>";


print "</table></td><tr><td height=50px background=\"/images/admin-bottom-bg.gif\"></table>";

//drawfooter();
$db->close();
?>