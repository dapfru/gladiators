<?

$type="news";
require("config.php");
require("up.php");


if(!$id)
{
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              
              <td valign="top"><h4>Наши новости</h4></td>
            </tr>
            <tr>
            
              <td valign="top" bgcolor="#f7f8f6">


<table width="100%" border="0" cellspacing="10" cellpadding="0">

<?
  $form=new cls_form("main/news","browse");
  $res = $form->sqlres;

  //$res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where TypeID=7 order by Date desc limit 0,3");

  while($r=mysql_fetch_array($res))
	{
	
	print"
                <tr>
                  <td width=\"130\" align=\"center\" valign=\"top\"><img src=\"$img_url?id=$r[MaterialID]&record=2\" alt=\"\" width=\"69\"></td>
                  <td valign=\"top\"><h5>".$r[Title]."</h5>
                    <p>".$r[Headline]."</p>
                    <p align=\"right\"><a href=\"$site_url"."news.php?id=$r[MaterialID]\" class=\"lnk\">подробнее</a></p></td>
                </tr>
	     ";
	}


?>
              </table>
<?
	print "<table width=100% cellspacing=0 cellpadding=2 border=0>";
        $form->Pages('');
	print "</table>";
?>    
          </td>
            </tr>
            <tr>
            
              <td valign="top"><img src="images/mid/shad2.jpg" alt="" width="248" height="27"></td>

            </tr>

          </table>
<?

}
else
{
	$res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where MaterialID=$id");

	while($r=mysql_fetch_array($res))
	{
		print"
			<h3>".$r[Title]."</h3><br>";
		if($r[Small]) {
		print"<img src=\"$img_url?id=$r[MaterialID]&record=1\" alt=\"$r[Title]\" align=\"left\" style=\"margin-right: 6px;\"></img>";
		}
        	print"<p>".settags($r[Message])."</p>";
	}

}

require("bottom.php");

?>