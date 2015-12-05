<?
require('config.php');

require($engine_path."cls/auth/session_lite.php");

//unset($type);


if($step&&$type=="main/register")
{
	$_POST['pwd']=md5($_POST['Password'].$secpass);

	$_POST['RealCode']=substr(md5($_POST['SecretCode']."hgfjdj"),0,6);

}
	if((($id!=1)||((!$worker)&&(!$partner)))&&($id!=7))
		{
			$pageres=select("select PageName_$lang as PageName,Content,TemplateID from en_menu where MenuID='$id'");
			$content=set_params(setTags($pageres[Content]));
			if(strstr($pageres[PageName],"\$")) $form_title=set_params($pageres[PageName]);
			else  $form_title=$pageres[PageName];
		}
if ($zak==1) { $act=anketa; $id=5;}


if($id==3) $typ="products";
if($id==7) $typ="galleries";
if($id==5) $typ="zakaz";
if($id==6) $typ="support";

require($site_path."up.php");


if($typ=="zakaz"&&$act)
{
	$i=0;
$zakaz="";
$price=0;
	foreach($HTTP_POST_VARS['quantity'] as $k=>$quantity)
	{
		//print "$k $quantity ".$HTTP_POST_VARS['productid'][$k]."<br>";
		//$i++;
		
		if($HTTP_POST_VARS['quantity'][$k]>='1')
		{
		$prod=$HTTP_POST_VARS['productid'][$k];
		//print $prod;
		$r3=select("select * from ut_products where ProductID='$prod'");
		$zakaz.=$r3[Name_rus].": ".$HTTP_POST_VARS['quantity'][$k]."шт.<br>";
		$pr=$HTTP_POST_VARS['quantity'][$k]*$r3[Price];
		$price=$price+$pr;
		//print $price."<br>";
		}
	}
}

if($act==anketa) $typ="zakaz";

// message(10); message(16) message(19)


if($id)
{
	if($worker)
		{
			$res=runsql("select WorkerID, Name, Surname, Lastname, About, concat(Day(BirthDate),'.',Month(BirthDate),'.',Year(BirthDate)) as BirthDate, Image from ut_workers where WorkerID='$worker'");
			$r=mysql_fetch_array($res);
			print"
			<h3>".$r[Surname]." ".$r[Name]." ".$r[Lastname]."</h3><br>";
	
			if ($r[Image]) print"<img src=\"\images\ut_workers\image\\".$r[WorkerID].".jpg\"><br>";
     			if ($r[BirthDate]!='0.0.0') print "Дата рождения: ".$r[BirthDate]."<br><br>";
			if ($r[About]) print settags($r[About]);	
		}
	if($partner)
		{
			$res=runsql("select PartnerID, Name_$lang as Name, Description_$lang as Info, Url, Image from ut_partners where PartnerID='$partner'");
			$r=mysql_fetch_array($res);
			print"
			<h3>".$r[Name]."</h3><br>";
	
			if ($r[Image]) print"<img src=\"\images\ut_partners\image\\".$r[PartnerID].".jpg\"><br>";
     			if ($r[Info]) print settags($r[Info]);
			if ($r[Url]) print"<br><a href=\"$r[Url]\">".$r[Url];
		}
	if($product)
		{
			$res=runsql("select p.*, p.Name_$lang as Name, p.Description_$lang as Description, t.Name_$lang as Type from ut_products p left outer join ut_product_types t using(TypeID) where ProductID='$product'");

			$r=mysql_fetch_array($res);

			print"
			<h3>".$r[Name]."</h3><br>
     			<h5>Класс: ".($r[Type])."</h5><br>";
	
			if ($r[Image]) print"<img src=\"$img_url?id=$r[ProductID]&record=9\"><br>";
     			print settags($r[Description]);
		}
	elseif($gallery)
		{

			$r1=select("select Name_rus from ut_galleries where GalleryID='$gallery'");

			print"<h3>".$r1[Name_rus].":</h3><br>";

			$res=runsql("select ScreenshotID, Name_$lang Name, Small from ut_screenshots where GalleryID='$gallery' order by ScreenshotID desc");

			$i=1;
		
			print "<table border=0 cellspacing=0 cellpadding=2>";

			while($r=mysql_fetch_array($res))
			{

				if($i==1) print "<tr>";

        			        print"<td width=\"114\" height=\"91\" align=\"center\" valign=\"middle\">
					<a href=\"\images\ut_screenshots\screenshotfile\\".$r[ScreenshotID].".jpg\" target=\"blank\">
					<img src=\"\images\ut_screenshots\small\\".$r[ScreenshotID].".jpg\" width=\"100\" height=\"75\"></a></td>";
				
				$i++;
				if($i==6) $i=1;

			}
	
			print "</table>";
		}
	elseif($typ=="zakaz")
		{
/*
					$form1= new cls_form("main/anketa","anketa");
					$form1->Draw();
print"---";
*/			
			if(!$act)
				{
					print"<table border=0 cellspacing=0 cellpadding=0><form name=\"zakaz\" method=\"post\" action=\"$site_url"."page.php\">";
					zakaztree(1,1,1,1,0,'','','',0);
					print "<input type=\"hidden\" name=\"zak\" act=\"anketa\" value=1>";
					print"</form></table>";
				}
					else 
				{
					if($zakaz!="")
					{
						print "Ваш заказ:<br>".$zakaz."<br>";
						print "Стоимость заказа: <b>".$price."р.</b><br><br>";
						print "<b>Заполните, пожалуйста, следующую анкету:</b><br><br>";
						$form1= new cls_form("main/anketa","anketa");
						$form1->Draw();
					}
					else
					{
						print("Вы не выбрали продукцию для заказа.<br>
							Пожалуйста, укажите необходимое количество интересующего вас оборудования и повторите попытку.<br><br>");
						unset($act);
						print"<table border=0 cellspacing=0 cellpadding=0><form name=\"zakaz\" method=\"post\" action=\"$site_url"."page.php\">";
						zakaztree(1,1,1,1,0,'','','',0);
						print "<input type=\"hidden\" name=\"zak\" act=\"anketa\" value=1>";
						print"</form></table>";
					}
				}

		}
	elseif($typ=="support")
		{  
			if($document==pr_list) 
				{
					$res=runsql("select *,Name_$lang as Name, Description_$lang as Description from ut_programs order by ProgramID");
					if(mysql_num_rows($res)>0)
					{						
						print"<b>Программное обеспечение</b><br>";
						$i=1;
						while($r=mysql_fetch_array($res))
						{
							print"<br>".$i.". ".$r[Name];
							print"<br>$r[Description]";
							print"<br><a href=\"$r[Url]\">cкачать</a>";
							print"<br>";
							$i++;
						}
					}
				}
			else
				{
					$r=select("select *,Name_$lang as Name, Description_$lang as Description from ut_documents where DocumentID='$document'");
					if($r[Name])
					{	
					print"<br><b>$r[Name]</b>";
					print"<br>$r[Description]";
					print"<br><a href=\"$r[Url]\">cкачать</a>";
					}	
				}
		}
	else
		{

	$q=$pageres;


	//if($q[TemplateID]) include_once($site_path."/templates/".$q[TemplateID]."up.php");

print "<br>".$content."<br>";

	//if($q[TemplateID]) include_once($site_path."/templates/".$q[TemplateID]."bottom.php");
	//print $site_path."/templates/".$q[TemplateID]."up.php";

		}

}

require($site_path."bottom.php");
?>
