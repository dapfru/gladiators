<?
$type="main";
require("config.php");

$first_page=1;

require("up.php");


$res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where TypeID=9 and MaterialID=34");

$r=mysql_fetch_array($res);

	print"
	<h3>".$r[Title]."</h3>
     	<p>".settags($r[Message])."</p>
          <p align=\"right\"><a href=\"$site_url"."news.php?id=30\" class=\"lnk\">подробнее о компании</a></p>
	";


require("bottom.php");

?>