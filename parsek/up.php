<?


if($type)
{

	$form = new cls_form($type,$act);

	unset($form_result);

	if($step&&$form->act=="search")
	{
		$searchform=$form;
		$act="select";
		$form = new cls_form($type,'select');

		$form->sql=$searchform->sql;
		$form->vip=$searchform->vip;

		$form->numrows=$searchform->numrows;

		unset($step);
	}


	if($step&&!$form->sql) $form->sql=$form->select;

	unset($runsql);

	if($step) {

$form_result=$form->runsql(1); $runsql=1;}

	if($form_ok==1) 
	{

		$form_result=icon('ok',set_params($form->success));

		//if($act=="insert"||$act=="update") $form = new cls_form($type);
	}

	if($form->redirect) $form->redirect=set_params($form->redirect);


	if($step&&!$er&&$form->redirect&&$form_result) 
	{
		if(strstr($form->redirect,"?")) header("Location:$form->redirect&form_ok=1");
		else header("Location:$form->redirect?form_ok=1");
	}
	elseif($step&&!$er&&$form_result) 
	{
		if(strstr($QUERY_STRING,"step")) $QUERY_STRING=str_replace("step","st",$QUERY_STRING);

		if($id) $QUERY_STRING.="&id=$id";

		header("Location:$PHP_SELF?$QUERY_STRING&form_ok=1");
	}



}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
print "<script src='".$path."functions.js' language='javascript' type='text/javascript'></script>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>

<?
if($form_title) print $form_title." - ООО \"Парсек\"";
elseif($form&&$form->title) print $form->title." - ООО \"Парсек\"";
else print "ООО \"Парсек\"";
?>

</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="987" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr height="91">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" height="91">
      <tr>
        <td valign="top"><a href=<?=$site_url."index.php";?> width="309"><img src="images/logo.gif" alt="" width="243" height="91" border="0"></a></td>
        <td align="right" valign="top"><img src="images/tnav.gif" alt="" width="422" height="91" border="0" usemap="#Map"><map name="Map"><area shape="circle" coords="173,68,12" href="index.php"><area shape="circle" coords="243,68,11" href="mailto:office@ooo-parsek.ru"><area shape="circle" coords="314,68,11" href="javascript:window.external.addFavorite('http://ooo-parsek.ru', 'ООО &quot;Парсек&quot;')"></map></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="/"><img src="images/t1.jpg" alt="" width="265" height="161" border=0></a></td>
        <td><a href="/"><img src="images/t2.jpg" alt="" width="300" height="161" border=0></a></td>
        <td><a href="/"><img src="images/t3.jpg" alt="" width="154" height="161" border=0></a></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="28" valign="top"><form name="form1" method="post" action="search.php">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="164"><input type="text" name="str" style="width: 100%"></td>
                  <td align="center"><label>
                    <input type="image" src="images/btn-search.gif">
                  </label></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
          <tr>
            <td><a href="/"><img src="images/t4.jpg" alt="" width="268" height="133" border=0></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>

<td></td><td></td>

        <td valign="top" rowspan=2 width="297"><img src="images/tm/subtop1.jpg" alt="" width="297" height="52"></td>
        <td valign="top" rowspan=2><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tm">
          
            <td width="80" valign="top"><img src="images/tm/tm-marker1.gif" alt="" width="58" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            <td align="center" valign="top"><img src="images/tm/tm-marker2.gif" alt="" width="20" height="28"></td>
            
          




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
<tr>
<?
if(($id==3)||($first_page==1)) 
{
?>
        <td width="90" align="right" class="tm-items"><a href="page.php?id=3" style="text-transform: uppercase;">Продукция</a></td>
<?
} elseif($id==5) 
{
?>
        <td width="90" align="right" class="tm-items" style="text-transform: uppercase;">Инструкция</td>
<?
} elseif($id==6) 
{
?>
        <td width="90" align="right" class="tm-items" style="text-transform: uppercase;">Поддержка</td>
<?
} elseif($id==7) 
{
?>
        <td width="90" align="right" class="tm-items" style="text-transform: uppercase;">Галереи</td>
<?
}
elseif($id==1) 
{
?>
        <td width="90" align="right" class="tm-items" style="text-transform: uppercase;">О компании</td>
<?
}
else 
{
?>
        <td width="90" align="right" class="tm-items"><a href="page.php?id=2" style="text-transform: uppercase;">Новости</a></td>
<?
}
?>
        <td width="48"><img src="images/tm/news.jpg" alt="" width="48" height="52"></td>

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
print"<tr><td colspan=3><font color=199FF8> <h6><img src=\"images/engine/tree.gif\" align=absmiddle> Продукты:</td>";

	if(mysql_num_rows($res)>0)
	{

		$i=1;
		while($r=mysql_fetch_array($res))
		{	
		
		if($i==mysql_num_rows($res)) $line="line3"; else $line="line2";	

			print "<tr>";
			if($line!="line3") print "<td background=\"images/engine/line1.gif\">"; else print "<td>";
			print "<img src=\"images/engine/$line.gif\"></td><td colspan=2><a href=\"javascript:;\" id=\"menu".$j."parent".$parent."\" onclick=\"return checkSubMenus(this)\"><b>".$str.$i.". $r[Name]</b></font></td></tr>";

			$res1 = runsql("select ProductID, Name_$lang as Name  
			from ut_products 
			where TypeID='$r[TypeID]' order by ProductID asc");

			if(mysql_num_rows($res1)>0)
			{

			$parent2=$j;

			//$today=mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));
			$k=1;
			while($r1=mysql_fetch_array($res1))
				{	
					if($k==mysql_num_rows($res1)) $line="line3"; else $line="line2";
					$k++;

					print "<tr id=\"menu".$j."parent".$parent2."\" style='display:anything'>";
					if($i!=mysql_num_rows($res)) print"<td background=\"images/engine/line1.gif\"><img src=\"images/engine/empty.gif\">";
					else print"<td><img src=\"images/engine/emp.gif\">";
					print"</td>";
					if($line!="line3") print"<td background=\"images/engine/line2.gif\" style=\"background-repeat:repeat-y\">";
					else print"<td background=\"images/engine/line3.gif\" style=\"background-repeat:no-repeat\">";
					print"<img src=\"images/engine/empty.gif\" align=\"absmiddle\"></td><td> <a href=\"page.php?id=3&product=$r1[ProductID]\"  title='$products'><font color=black>$r1[Name]</font></a></td>";
					
				}

			}


			$i++;
	
$j++;
		}



	}

}   //tree



function zakaztree($project,$daycount,$id,$task,$level,$str,$color,$parent,$own)
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

		print "<tr><td width=\"20\"><img src=\"images/engine/tree.gif\"></td>
		<td colspan=2><center><b>Название</b><center></td>
		<td width=\"40\"><center><b>Цена</b></center></td>
		<td width=\"50\"><center><b>Кол-во</b></center></td></tr>";		

		$i=1;
		while($r=mysql_fetch_array($res))
		{	
		
		if($i==mysql_num_rows($res)) $line="line3_m"; else $line="line2_m";	

			print "<tr><td width=\"20\"><img src=\"images/engine/$line.gif\"></td><td colspan=2><a href=\"javascript:;\" id=\"menu".$j."parent".$parent."\" onclick=\"return checkSubMenus(this)\"><b>".$str.$i.". $r[Name]</b></font></td>";

			print"<td width=\"40\"></td><td width=\"50\"></td>";			

			$res1 = runsql("select ProductID, Name_$lang as Name, Price  
			from ut_products 
			where TypeID='$r[TypeID]' order by ProductID asc");

			if(mysql_num_rows($res1)>0)
			{

			$parent2=$j;

			//$today=mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));
			$k=1;
			while($r1=mysql_fetch_array($res1))
				{	
					if($k==mysql_num_rows($res1)) $line="line3_m"; else $line="line2_m";
					$k++;
					print "<tr id=\"menu".$j."parent".$parent2."\" style='display:anything'><td>";
					if($i!=mysql_num_rows($res)) print"<img src=\"images/engine/line1_m.gif\">";
					print"</td><td colspan=2><img src=\"images/engine/$line.gif\" align=\"absmiddle\"> <a href=\"page.php?id=3&product=$r1[ProductID]\"  title='$products'><font color=black>$r1[Name]</font></a></td>
					<td style=\"font-size:11\" align=\"right\">".$r1[Price]."р.</td>
					<td width=\"50\"><center><input type=\"text\" name=\"quantity[]\" style=\"width: 60%\" style=\"font-size:10\" value=0><input type=\"hidden\" name=\"productid[]\" value=\"$r1[ProductID]\"></center></td><tr>";
					
				}

			}


			$i++;
	
$j++;
		}


print"<tr height=40><td colspan=5><input type=\"submit\" value=\"Заказать\"></td>";
	}

}   //zakaztree


function workertree($project,$daycount,$id,$task,$level,$str,$color,$parent,$own)
{
	global $lang,$j,$auth;



	$res = runsql("select PostID, Name_$lang as Name  
 from ut_posts 
order by Name_$lang asc");

$k=0;
$parent=0;
$j=1;
	if($level==10) {print "Бесконечный цикл"; exit;}
print"<tr><td><font color=199FF8> <h6><img src=\"images/engine/tree.gif\" align=absmiddle> Сотрудники:</td></tr>";

	if(mysql_num_rows($res)>0)
	{

		$i=1;
		while($r=mysql_fetch_array($res))
		{	
		
		if($i==mysql_num_rows($res)) $line="line3"; else $line="line2";	

			print "<tr><td valign=\"middle\"><img src=\"images/engine/$line.gif\" align=\"absmiddle\">"." "."<a href=\"javascript:;\" id=\"menu".$j."parent".$parent."\" onclick=\"return checkSubMenus(this)\"><b>$r[Name]</b></font></td></tr>";


			$res1 = runsql("select WorkerID, Name, Surname, Lastname  
			from ut_workers 
			where PostID='$r[PostID]' order by Surname asc");

			if(mysql_num_rows($res1)>0)
			{

			$parent2=$j;

			//$today=mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));
			$k=1;
			while($r1=mysql_fetch_array($res1))
				{	
					if($k==mysql_num_rows($res1)) $line="line3"; else $line="line2";
					$k++;
					print "<tr id=\"menu".$j."parent".$parent2."\" style='display:anything'><td>";
					if($i!=mysql_num_rows($res)) print"<img src=\"images/engine/line1.gif\" align=\"absmiddle\">"; else print"<img src=\"images/engine/empty.gif\" align=\"absmiddle\">";
					print"<img src=\"images/engine/$line.gif\" align=\"absmiddle\"> <a href=\"page.php?id=1&worker=$r1[WorkerID]\"  title='$products'><font color=black>".$r1[Surname]." ".$r1[Name]." ".$r1[Lastname]."</font></a></td></tr>";
					
				}

			}


			$i++;
	
$j++;
		}



	}

}   //workertree



if($typ=="products")
{


		tree(1,1,1,1,0,'','','',0);

		
}
elseif($typ=="galleries")
{

$res=runsql("select GalleryID, Name_$lang Name from ut_galleries order by Name_$lang");

while($r=mysql_fetch_array($res))
	{
		$a=select("select count(*) Count from ut_screenshots where GalleryID=$r[GalleryID]");
           print "<tr>
		<td width='36'> </td>
               <td align=\"left\" valign=\"top\">
		<a href=\"page.php?id=7&gallery=$r[GalleryID]\">".$r[Name]."(".$a[Count].")</a>
		</td>";
	}
if(!$gallery) 
	{ 
	$rs=runsql("select GalleryID from ut_galleries order by GalleryID");
	$r=mysql_fetch_array($rs);
	$gallery=$r[GalleryID];  
	}

}
elseif($typ=="zakaz")
{
$r=select("select * from lk_texts where TextID='5'");
	print " <tr>
		<td width='20'> </td><td><br>$r[rus]</td>
		<tr>
		<td width='20'> </td><td><br><img src=\"$site_url"."images/doc.gif\" align=\"absmiddle\"> <a href=\"$site_url"."files/karta_zakaz.doc\">karta_zakaz.doc</a></td>";
}
elseif($typ=="support")
{

$res=runsql("select DocumentID, Name_$lang Name from ut_documents order by Name_$lang");

while($r=mysql_fetch_array($res))
	{
           print "<tr>
		<td width='36'> </td>
               <td align=\"left\" valign=\"top\">
		<a href=\"page.php?id=6&document=$r[DocumentID]\">$r[Name]</a>
		</td>";
	}	
if(!$document) 
	{ 
	$rs=runsql("select DocumentID from ut_documents order by DocumentID");
	$r=mysql_fetch_array($rs);
	$document=$r[DocumentID];  
	}

print "<tr height=20>
<td><tr>
<td width='36'> </td>
<td align=\"left\" valign=\"top\">
<a href=\"page.php?id=6&document=pr_list\">Программное обеспечение</a>
</td>";

} 
else
{
	if($id==1)
	{	
		workertree(1,1,1,1,0,'','','',0);

		//print "</td></tr>";

		print"</table><br><br><table border=0>";

           	print "<tr>
		<td width='20'> </td>
              	<td align=\"left\"><h6>Партнеры:</h6></td>";

		$res2=runsql("select * from ut_partners order by Name_rus");
		while($r2=mysql_fetch_array($res2))
		{
			print "<tr>
			<td width='20'> </td><td align=\"left\" valign=\"top\">
			<a href=\"page.php?id=1&partner=$r2[PartnerID]\">".$r2[Name_rus]."</a>
			</td>";
		}
	} 
	else
	{
		$res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where TypeID=7 order by Date desc limit 0,3");

		while($r=mysql_fetch_array($res))
		{
		print"
          	<tr>
          	  	<td width='36'> </td>
            		<td width='230' class='lnews'><a href='$site_url"."news.php?id=$r[MaterialID]'><h2>".$r[Title]."</h2></a>
              		<p><img src='$img_url?id=$r[MaterialID]&record=2' alt='' width='69' align='left' style='margin-right: 6px;'>".$r[Headline]."</p></td>
          	</tr>
          	<tr>
            		<td colspan='2'><table width='100%' border='0' cellspacing='0' cellpadding='0' class='details'>
              	<tr>
                	<td width='193'><img src='images/left/h-ln-details.gif' alt='$r[Title]' width='193' height='15'></td>
                	<td valign='top'><a href='$site_url"."news.php?id=$r[MaterialID]'>подробнее</a></td>
              	</tr>
            	</table></td>
            	</tr>
		";
		}
	}
}
?>

        </table>

<? 
if($first_page==1)
{
?>
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
            <td><form name="subscribe" method="post" action="<?="$site_url"."subscribe.php";?>">
              <table width="200" border="0" cellspacing="0" cellpadding="6" align="center" class="subs-frm">
                <tr>
                  <td>Имя</td>
                  <td width="140"><input type="text" name="name" style="width: 100%"></td>
                </tr>
                <tr>
                  <td>E-mail</td>
                  <td width="140"><input type="text" name="email" style="width: 100%"></td>
                </tr>
		<input type="hidden" name="unsubscribe"  value=0>
              </table>
                        
            </td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="subs">
              <tr>
                <td width="170"><img src="images/left/h-ln-subs.gif" alt="" width="170" height="13"></td>
                <td><a href="#" onclick="document.forms.subscribe.submit()">Подписаться</a></td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="subs">
                <tr>
                  <td width="170"><img src="images/left/h-ln-subs.gif" alt="" width="170" height="13"></td>
                  <td><a href="#" onclick="document.forms.subscribe.unsubscribe.value=1; document.forms.subscribe.submit()">Отписаться</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
		</form>
<?
}
?>
        <td height="100%" valign="top">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="44" valign="top"><img src="images/mid/about.gif" alt="" width="44" height="241"></td>
            <td valign="top" bgcolor="#f7f8f6" style="border-left: 2px #1879d0 solid; padding: 4px 24px 4px 24px; color: #4a4a49;">
<?

if(!$form->title) $form->title=$form_title;
if($form->title) print "<br><h6>".$form->title."</h6>";

if($form_result) print $form_result;
elseif($step&&!$runsql) $form->runsql();


if($oldact&&($oldact!=$act)&&$er&&$step) {$form = new cls_form($type,$oldact);$act=$oldact;}


?>