	<script>
		function checkSubMenus(anchor)
		{
			var subMenusExist = false;
			var anchors = document.getElementsByTagName(anchor.tagName);
			var parentId = (/menu(\d+)parent(\d+)/).exec(anchor.id)[1];
			for(var i=0; i<anchors.length; i++)
			{
				if(anchor.id != anchors[i].id)
				{
					var currId = anchors[i].id;
					var regEx = (/menu(\d+)parent(\d+)/).exec(currId);
					if(regEx)
					{
						var currParentId = regEx[2];
						if(currParentId == parentId)
						{
							subMenusExist = true;
							anchors[i].style.display = ("none" == anchors[i].style.display)?
								"block":"none";
						}
					}
				}
			
			}
			if(subMenusExist)
				anchor.style.marginTop = (anchor.style.marginTop == "3px")?"0px":"3px";
			return !subMenusExist;
		}
	</script>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>index</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="987" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><a href="index.php" width="309"><img src="images/logo.gif" alt="" width="243" height="92" border="0"></a></td>
        <td align="right" valign="top"><img src="images/tnav.gif" alt="" width="422" height="91" border="0" usemap="#Map">
          <map name="Map"><area shape="circle" coords="173,68,12" href="index.php">
        <area shape="circle" coords="243,68,11" href="mailto:#">
        <area shape="circle" coords="314,68,11" href="map.php#">
          </map></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="images/t1.jpg" alt="" width="265" height="161"></td>
        <td><img src="images/t2.jpg" alt="" width="300" height="161"></td>
        <td><img src="images/t3.jpg" alt="" width="154" height="161"></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="28" valign="top"><form name="form1" method="post" action="">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="164"><input type="text" name="textfield" style="width: 100%"></td>
                  <td align="center"><label>
                    <input type="image" name="imageField" src="images/btn-search.gif">
                  </label></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
          <tr>
            <td><img src="images/t4.jpg" alt="" width="268" height="133"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="90" align="right" class="tm-items"><a href="news.php" style="text-transform: uppercase;">Новости</a></td>
        <td width="48"><img src="images/tm/news.jpg" alt="" width="48" height="52"></td>
        <td valign="top" width="297"><img src="images/tm/subtop1.jpg" alt="" width="297" height="52"></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tm">
          <tr>
            <td width="80" valign="top"><img src="images/tm/tm-marker1.gif" alt="" width="58" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
          </tr>
          <tr>
<?
$res=runsql("select MenuID, Name_$lang as Name, PageName_$lang as PageName from en_menu where Parent=9 order by MenuID");
while ($r=mysql_fetch_array($res))
	{ 
?>
            <td  align="center" valign="top" class="tm-items"><a href=<?="$site_url"."page.php?id=$r[MenuID]";?>><?=$r[Name];?></a></td>

<?
	}
?>                   
	  </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="309"><img src="images/tsubmenu/h-ln1.gif" alt="" width="309" height="24"></td>
        <td><img src="images/tsubmenu/h-ln2.gif" alt="" width="678" height="24"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="100%"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="265" height="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<?

function tree($project,$daycount,$id,$task,$level,$str,$color,$parent,$own)
{
	global $lang,$j,$auth;



	$res = runsql("select TypeID, Name_$lang as Name  
 from ut_product_types 
order by TypeID asc");


$parent=0;
$j=1;
	if($level==10) {print "Бесконечный цикл"; exit;}

	if(mysql_num_rows($res)>0)
	{

		$i=1;
		while($r=mysql_fetch_array($res))
		{	



			print "<a href=\"javascript:;\" id=\"menu".$j."parent".$parent."\" onclick=\"return checkSubMenus(this)\"><b>";
					

			print "<font color=black>";
			print $str.$i.". $r[Name]</b></font>";


			$res1 = runsql("select ProductID, Name_$lang as Name  
			from ut_products 
			where TypeID='$r[TypeID]' order by ProductID asc");

			if(mysql_num_rows($res1)>0)
			{

			$parent2=$j;

			//$today=mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));

			while($r1=mysql_fetch_array($res1))
				{	

					print "<a href=\"products.php?id=$r1[ProductID]\"  style='display:block'  id=\"menu".$j."parent".$parent2."\" title='$products'>- $r1[Name]</a>";
					
				}

			}

			print "<br>";

			$i++;
	
$j++;
		}



	}

}


if($type=="products")
{
          	print "<tr><td width=\"36\">&nbsp;</td><td>";
		print "<font color=199FF8><h3>Продукты:</h3></font><br>";

		tree(1,1,1,1,0,'','','',0);

		print "</td></tr>";
}
else
{
	$res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where TypeID=7 order by Date desc limit 0,3");

	while($r=mysql_fetch_array($res))
	{
		print"
          	<tr>
          	  	<td width=\"36\">&nbsp;</td>
            		<td width=\"230\" class=\"lnews\"><a href=\"$site_url"."news.php?id=$r[MaterialID]\"><h2>".$r[Title]."</h2></a>
              		<p><img src=\"$img_url?id=$r[MaterialID]&record=2\" alt=\"\" width=\"69\" align=\"left\" style=\"margin-right: 6px;\">".$r[Headline]."</p></td>
          	</tr>
          	<tr>
            		<td colspan=\"2\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"details\">
              	<tr>
                	<td width=\"193\"><img src=\"images/left/h-ln-details.gif\" alt=\"$r[Title]\" width=\"193\" height=\"15\"></td>
                	<td valign=\"top\"><a href=\"$site_url"."news.php?id=$r[MaterialID]\">подробнее</a></td>
              	</tr>
            </table></td>
            </tr>
	";

	}
}
?>

        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/left/h-ln1.gif" alt="" width="265" height="24"></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right"><strong>РАССЫЛКА</strong></td>
                <td width="166"><img src="images/left/search.gif" alt="" width="166" height="49"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><img src="images/left/h-ln2.gif" alt="" width="265" height="9"></td>
          </tr>
          <tr>
            <td><form name="form2" method="post" action="">
              <table width="200" border="0" cellspacing="0" cellpadding="6" align="center" class="subs-frm">
                <tr>
                  <td>Имя</td>
                  <td width="140"><input type="text" name="textfield2" style="width: 100%"></td>
                </tr>
                <tr>
                  <td>E-mail</td>
                  <td width="140"><input type="text" name="textfield3" style="width: 100%"></td>
                </tr>
              </table>
                        </form>
            </td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="subs">
              <tr>
                <td width="170"><img src="images/left/h-ln-subs.gif" alt="" width="170" height="13"></td>
                <td><a href="#">Подписаться</a></td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="subs">
                <tr>
                  <td width="170"><img src="images/left/h-ln-subs.gif" alt="" width="170" height="13"></td>
                  <td><a href="#">Отписаться</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
        <td height="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="44"><img src="images/mid/about.gif" alt="" width="44" height="241"></td>
            <td valign="top" bgcolor="#f7f8f6" style="border-left: 2px #1879d0 solid; padding: 4px 24px 4px 24px; color: #4a4a49;">

