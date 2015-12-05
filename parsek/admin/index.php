<?

$site="admin/";

require("../config.php");

if(!$type) $type="engine/menu";



require($engine_path."cls/auth/session.php");

if($type=="engine/templates"&&$step)
{

	$_POST['Header']=str_replace("\\\"","\\\\'",$_POST['Header']);
	$_POST['Footer']=str_replace("\\\"","\\\\'",$_POST['Footer']);
//print $_POST['Header'];
//exit;
}

if($act=="search"&&$step)
{

 $searchform = new cls_form($type,'search');
 $form  = new cls_form($type,'select');
 $searchform->set_form_params($searchform->sql);

 $form->sql=$searchform->sql;

}
else
{

$form = new cls_form($type,$act);

if($step||$act=="delete"||$act=="create"||$act=="drop") 
{
	$form_result=$form->runsql(1); $runsql=1;

	if($form->redirect&&!$er) header("location:$form->redirect");
}
if($step&&$act=="update"&&!$er) {$form = new cls_form($type,"select"); unset($act);}

if($step&&$act=="translate"&&!$er) {$form = new cls_form($type,"translate"); unset($act);}


}



if(($type=="engine/messages"||$type=="localization/system")&&$step)
{
	global $lang,$adm,$message,$site_path,$_POST;

	$fname=$site_path."lang/messages/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}
elseif(($type=="engine/texts"||$type=="localization/system")&&$step)
{
	global $lang,$adm,$message,$site_path,$_POST;

	$fname=$site_path."lang/texts/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}
elseif(($type=="engine/system"||$type=="localization/system")&&$step)
{
	global $lang,$adm,$message,$site_path,$_POST;

	$fname=$site_path."lang/system/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}


if($type=="engine/templates"&&$step)
{
	if($id) $_POST['TemplateID']=$id;
	else $_POST['TemplateID']=$insertid;


	if(!file_exists($site_path."templates/")) mkdir_r($site_path."templates/");	

function recTemplate($id)
{
	global $_POST;
	
	$q=select("select TemplateID,Header,Footer,ParentID from en_templates where TemplateID='$id'");
	if($q[0])
	{
		$_POST['Header']=$q[Header].$_POST['Header'];
		$_POST['Footer']=$_POST['Footer'].$q[Footer];

		if($q[ParentID]) recTemplate($q[ParentID]);
	}
}

function makeTemplate($id)
{
	global $_POST,$site_path;

	if($_POST['ParentID']) recTemplate($_POST['ParentID']);

	$f=fopen($site_path."templates/".$_POST['TemplateID']."up.php","w");

	
	$_POST['Header']=str_replace("<br />","\r\n",$_POST['Header']);
	$_POST['Footer']=str_replace("<br />","\r\n",$_POST['Footer']);

	fputs($f,setTags($_POST['Header']));
	fclose($f);


	$f=fopen($site_path."templates/".$_POST['TemplateID']."bottom.php","w");
	fputs($f,setTags($_POST['Footer']));
	fclose($f);
}

function makeTemplate2($id)
{
	global $_POST;

	$res=runsql("select * from en_templates where ParentID='$id'");
	while($r=mysql_fetch_array($res))
	{
		$_POST['Header']=$r[Header];
		$_POST['Footer']=$r[Footer];
		$_POST['TemplateID']=$r[TemplateID];
		$_POST['ParentID']=$r[ParentID];
		makeTemplate($r[TemplateID]);
		makeTemplate2($r[TemplateID]);
	}
}

makeTemplate($id);
makeTemplate2($id);

}
elseif($type=="engine/messages"&&$step)
{

	$fname=$site_path."lang/messages/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}
elseif($type=="engine/texts"&&$step)
{

	$fname=$site_path."lang/texts/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}
elseif($type=="engine/system"&&$step)
{

	$fname=$site_path."lang/system/".$lang.".txt";
	$file=fopen($fname,"r");
	$str=fread($file,filesize($fname));

	fclose($file);

	if(strstr($str,"message[".$id."]"))
	{
		$str=substr($str,0,strpos($str,"\$message[".$id))."\$message[".$id."] = '".$_POST[$lang]."';\r\n".substr($str,strpos($str,"\$message",1+strpos($str,"\$message[".$id)));

		$file=fopen($fname,"w");
		fputs($file,$str);
		fclose($file);
	}
}


?>

<head>
<link href="<?=$site_url?>admin.css" rel="stylesheet" type="text/css">
</head><body  background="<?=$site_url?>images/bg.gif" style="margin-top:0px;background-repeat:repeat-x">
<?
print "<script src='".$path."functions.js' language='javascript' type='text/javascript'></script>";

print "<table width=600px height=500px bgcolor=ffffff cellspacing=0 cellpadding=0><td>";

drawheader("");


$q=select("select PermissionID from en_permissions where UserID='$auth->user'");
$q[0]=1;
if(!$q[0]) print icon("error","У вас нет прав доступа");
else
{
	
if($act=="delete"&&$step&&!$er) {$form=new cls_form($type,"select");$act="select";}
if($act=="insert"&&$step&&!$er) {$form=new cls_form($type,"select");$act="select";}


print "
Вы авторизованы как $auth->nick. <a href=\"".$site_url."login.php?do=logout&act=auth&type=main/authorize\">[выйти]</a> <a href=\"/\">[ooo-parsek.ru]</a>";
print "<hr><center>";

$menu=new cls_menu("menu/menu","toolbar",1);
$menu->Draw('');



$menu=new cls_menu("menu/toolbar","toolbar/".substr($type,0,strpos($type,"/")),2);
$menu->bgcolor="f3f3f3";
$menu->align="center";
$menu->headerbg="";
$menu->height="25px";
$menu->width="100%";
$menu->cellspacing=1;
$menu->bgcolor="ffffff";
$menu->hcolor="f3f3f3";
$menu->headerclass="black";

$menu->Draw('');

print "</center>";


print "<hr><center><a href=\"$PHP_SELF?act=insert&type=$type\" class=black>".message(2)."</a> |
 <a href=\"$PHP_SELF?type=$type\"  class=black>".message(3)."</a>  |
<a href=\"$PHP_SELF?type=$type&act=create\"  class=black>".message(6)."</a>
</center><hr>"; 




if($form_result) print $form_result;

$form->width="100%";

	if(($type=="engine/menu"||$type=="engine/tags")&&(!$act||$act=="select"))
	{


?>

<script>

function GetLevel(R)
{
  var n = 0, I = R.id + "", L = I.length;

  for(var i = 0; i < L; i++)
    if(I.charAt(i) == ".")
      n++;
  return(n);
}

function Collapse(T, J)
{
  var f, B, C, N, R, S, V, E = document.getElementById(T).childNodes, L = E.length, n = -1;

  if(document.images["Image" + J].id=='plus') 
  {
	document.images["Image" + J].src="<?=$site_url."images/engine/minus.gif";?>";
	document.images["Image" + J].id='minus';
  }
  else 
  {
	document.images["Image" + J].src="<?=$site_url."images/engine/plus.gif";?>";
	document.images["Image" + J].id='plus';
  }


  for(var i = 0; i < L; i++)
    if((B = E[i]).nodeName == "TBODY") {
      N = (C = B.childNodes).length;
      for(var j = 0; j < N; j++) {
        if((R = C[j]).nodeName == "TR") {
          if(n >= 0) {
            if((R.id != "") && (GetLevel(R) <= n))
              return;
            S = R.style;
            if(f) {
              V = (S.display == "none" ? "" : "none");
              f = false;

            }


            S.display = V;

if(R.id&&document.images["Image" + R.id])
{

	document.images["Image" + R.id].src="<?=$site_url."images/engine/minus.gif";?>";
	document.images["Image" + R.id].id='minus';
}

          } else if(R.id == J) {
            n = GetLevel(R);
            f = true;
          }
        }
      }
    }

}
</script>


<?

	}


	if($type=="engine/menu"&&(!$act||$act=="select"))
	{

print "<table border=0 width=100% id='table0' cellspacing=0 cellpadding=0>";

$start=0;

//функция

function menurec($parent,$level,$ended,$numstr,$col,$template)
{
	global $site_url,$lang,$start;



$res=runsql("select *,if(Url<>'',Url,concat('page.php?id=',MenuID)) Url,TemplateID,Name_$lang Name,if(MenuID in (select Parent from en_menu),1,0) haveChild from en_menu where Parent='$parent' order by Rang");
$i=0;

while($r=mysql_fetch_array($res))
{

	$i++;


	if($numstr) $nstr=$numstr.".".$i;
	else $nstr=$i;

	if($col!="EAEEF1") $col="EAEEF1";
	else $col="ffffff";

	print "<tr";
	if($level>0) print " style=\"display:none\"";
	print " id='menu".$nstr."' bgcolor=$col><td valign=bottom width=100% >";



	$str="";
	for($j=1;$j<=$level;$j++)
	{
		//if(strlen($ended)&&($j==$ended+1)) 	$str.= "<img src=\"$site_url"."images/engine/empty.gif\" width=20  height=20   align=absmiddle>";
		//else $str.= "<img src=\"$site_url"."images/engine/line1.gif\"  width=20  height=20   align=absmiddle>";

		$str.= "<img src=\"$site_url"."images/engine/line1.gif\"  width=20  height=20   align=absmiddle>";
	}

	if(!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

	print "$str<img src=\"$site_url"."images/engine/line2.gif\" width=20  height=20   align=absmiddle> ";

	if($r[haveChild]) print "<img src=\"$site_url"."images/engine/plus.gif\" onclick=\"JavaScript: Collapse('table0', 'menu".$nstr."')\"  style=\"cursor:hand\" id=\"plus\" align=absmiddle  name=\"Imagemenu".$nstr."\" >";
	print "<a href=\"$r[Url]\">$r[Name]</a></td>

<td><div style=\"margin:6px\"><a href=\"$PHP_SELF?act=up&step=1&id=$r[MenuID]\"><img src=\"$site_url"."images/engine/up.gif\" align=absmiddle border=0></a></td>
<td><div style=\"margin:6px\"><a href=\"$PHP_SELF?act=down&step=1&id=$r[MenuID]\"><img src=\"$site_url"."images/engine/down.gif\" align=absmiddle border=0></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?act=insert&Rang=1&Parent=$r[MenuID]&TemplateID=$r[TemplateID]\"><img src=\"$site_url"."images/engine/new.gif\" align=absmiddle border=0></a></td>
<td><a href=\"$PHP_SELF?type=engine/menu&act=translate&id=$r[MenuID]\"><img src=\"$site_url"."images/engine/report.gif\" align=absmiddle border=0></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?act=update&id=$r[MenuID]\"><img src=\"$site_url"."images/engine/edit.png\" align=absmiddle border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?act=delete&step=1&id=$r[MenuID]\" onclick=\"return confirm('".sysmessage(17)."')\"><img src=\"$site_url"."images/engine/drop.png\" alt=\"".sysmessage(1)."\" title=\"".sysmessage(1)."\" align=absmiddle border=0></a></td>
</tr>";



	if($i==mysql_num_rows($res)) $ended=$level;



	menurec($r[MenuID],$level+1,$ended,$nstr,$col,$r[TemplateID]);


	if($i==mysql_num_rows($res)) 
	{

		if($col!="EAEEF1") $col="EAEEF1";
		else $col="ffffff";

		$i++;

		if($numstr) $nstr=$numstr.".".$i;
		else $nstr=$i;

		print "<tr";
		if($level>0) print " style=\"display:none\"";
		print " id='menu".$nstr."' bgcolor=$col><td valign=bottom width=100% colspan=7>";

		print "$str<img src=\"$site_url"."images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"$site_url"."images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?act=insert&type=engine/menu&Parent=$r[Parent]&Rang=".($r[Rang]+1)."&TemplateID=$template\">Добавить</a> ";
	}


}




	if(mysql_num_rows($res)>0) return 1;

}
//функция


print "<tr><td valign=middle><img src=\"$site_url"."images/engine/home.gif\" align=absmiddle width=15 height=18 > Структура сайта</td></tr>";

if(!menurec(0,0,'','')) print "<tr><td colspan=10><img src=\"$site_url"."images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"$site_url"."images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?act=insert&type=engine/menu&Parent=0&Rang=1\">Добавить</a></td></tr> ";

print "</table>";

	}
	elseif($type=="engine/tags"&&(!$act||$act=="select"))
	{

//дерево тагов


function menurec($step,$level,$ended,$numstr,$col,$template,$site,$page,$typestr)
{
	global $site_url,$lang,$start;



if($step==0) $res=runsql("select if(Site='','/',Site) Name,Site,PageID,1 as haveChild from en_pages group by Site order by Site");
elseif($step==1) $res=runsql("select  substring_index(Type,'/',1) Name,1 as haveChild,Site,PageID from en_pages where Site='$site' group by substring_index(Type,'/',1) order by Type");
elseif($step==2) $res=runsql("select 
concat_ws(' ',substring_index(Type,'/',-1),if(Name_$lang<>'',concat('(',Name_$lang,')'),null))

 Name,
1 as haveChild,Site,PageID from en_pages where Site='$site' and substring_index(Type,'/',1)='$typestr' group by substring_index(Type,'/',-1) order by substring_index(Type,'/',-1)");
elseif($step==3) $res=runsql("select TagID,Act Name,0 as haveChild from en_tags where PageID='$page' group by Act order by Act");


$i=0;

while($r=mysql_fetch_array($res))
{

	$i++;

	$site=$r[Site];
	if($step==2) $page=$r[PageID];
	if($step==1) $typestr=$r[Name];

	if($numstr) $nstr=$numstr.".".$i;
	else $nstr=$i;

	if($col!="EAEEF1") $col="EAEEF1";
	else $col="ffffff";

	print "<tr";
	if($level>0) print " style=\"display:none\"";
	print " id='menu".$nstr."' bgcolor=$col><td valign=bottom width=100% ><font color=444444>";

	if($step==2) print "<b>";
	if($step==1) print "<h3>";
	if($step==0) print "<h2>";
	$str="";

	for($j=1;$j<=$level;$j++)
	{
		$str.= "<img src=\"$site_url"."images/engine/line1.gif\"  width=20  height=20   align=absmiddle>";
	}

	if(!strstr($r[Url],"http://")) $r[Url]="$site_url".$r[Url];

	print "$str<img src=\"$site_url"."images/engine/line2.gif\" width=20  height=20   align=absmiddle> ";

	if($r[haveChild]) print "<img src=\"$site_url"."images/engine/plus.gif\" onclick=\"JavaScript: Collapse('table0', 'menu".$nstr."')\"  style=\"cursor:hand\" id=\"plus\" align=absmiddle  name=\"Imagemenu".$nstr."\" >";

	print "$r[Name]</td>";

if($step==3) print "
<td><a href=\"$PHP_SELF?type=engine/tags&act=translate&id=$r[TagID]\"><img src=\"$site_url"."images/engine/report.gif\" align=absmiddle border=0></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?type=engine/tags&act=update&id=$r[TagID]\"><img src=\"$site_url"."images/engine/edit.png\" align=absmiddle border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?type=engine/tags&act=delete&step=1&id=$r[TagID]\" onclick=\"return confirm('".sysmessage(17)."')\"><img src=\"$site_url"."images/engine/drop.png\" alt=\"".sysmessage(1)."\" title=\"".sysmessage(1)."\" align=absmiddle border=0></a></td>
</tr>";
elseif($step==2) print "
<td><a href=\"$PHP_SELF?type=engine/pages&act=translate&id=$r[PageID]\"><img src=\"$site_url"."images/engine/report.gif\" align=absmiddle border=0></a></td>
<td><div style=\"margin:2px\"><a href=\"$PHP_SELF?type=engine/pages&act=update&id=$r[PageID]\"><img src=\"$site_url"."images/engine/edit.png\" align=absmiddle border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"></a></td>
<td><div style=\"margin:2px\"></td>
</tr>";
else print "
<td></td>
<td></td>
<td></td>
</tr>";



	if($i==mysql_num_rows($res)) $ended=$level;



	if($step<4) menurec($step+1,$level+1,$ended,$nstr,$col,$r[TemplateID],$site,$page,$typestr);

	if($i==mysql_num_rows($res)) 
	{

		if($col!="EAEEF1") $col="EAEEF1";
		else $col="ffffff";

		$i++;

		if($numstr) $nstr=$numstr.".".$i;
		else $nstr=$i;

		print "<tr";
		if($level>0) print " style=\"display:none\"";
		print " id='menu".$nstr."' bgcolor=$col><td valign=bottom width=100% colspan=8>";



		if($step==3) print "$str<img src=\"$site_url"."images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"$site_url"."images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?type=engine/tags&act=insert&PageID=$page\">Добавить</a> ";
		elseif($step>1) print "$str<img src=\"$site_url"."images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"$site_url"."images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?type=engine/pages&act=insert&Site=$site\">Добавить</a> ";
	}


}

	if(!mysql_num_rows($res)&&$step==3) 
	{

		if($col!="EAEEF1") $col="EAEEF1";
		else $col="ffffff";

		$i++;

		if($numstr) $nstr=$numstr.".".$i;
		else $nstr=$i;

		for($j=1;$j<=$level;$j++)
		{
			$str.= "<img src=\"$site_url"."images/engine/line1.gif\"  width=20  height=20   align=absmiddle>";
		}

		print "<tr";
		if($level>0) print " style=\"display:none\"";
		print " id='menu".$nstr."' bgcolor=$col><td valign=bottom width=100% colspan=8>";

		print "$str<img src=\"$site_url"."images/engine/line3.gif\" width=20 height=20 align=absmiddle> <img src=\"$site_url"."images/engine/new.gif\" border=0 align=absmiddle> <a href=\"$PHP_SELF?type=engine/tags&act=insert&PageID=$page\">Добавить</a> ";

	}


	if(mysql_num_rows($res)>0) return 1;

}


print "<table border=0 width=100% id='table0' cellspacing=0 cellpadding=0>";

$start=0;

print "<tr><td valign=middle><img src=\"$site_url"."images/engine/tree.gif\" align=absmiddle  > Структура файлов</td></tr>";

menurec(0,0,'','');

print "</table>";


//заокнчилось дерево тагов
	}
	elseif($type) $form->Draw();
}


drawfooter();

print "</td></table>";
$db->close();



function printattributes($form,$tag,$attr)
{	
	global $level,$tags,$r;

	$r[Xml].="&lt;$tag";

	if(!$attr) $attr=$form->attributes[$tag];

	$i=0;

	foreach($attr as $k=>$v)
	{
		$i++;

		$name=substr($k,0,strrpos($k,"_"));

		if(strstr($k,"_")) $lng=substr($k,strrpos($k,"_")+1);
		else unset($lng);

		if($k!="text"&&(strlen($lng)!=3||!$attr[$name."_code"])) $r[Xml].="\r\n  $k=\"$v\"";



		if($lng=="code")
		{
			$q=select("select * from lk_xml where TextID='$v'");
			
			$r[Xml].="\r\n  <-- \r\n";
			$r[Xml].="  ".$name."_rus = \"$q[rus]\"\r\n";
			$r[Xml].="  ".$name."_eng = \"$q[eng]\"\r\n";
			$r[Xml].="  ".$name."_ger = \"$q[ger]\"\r\n";
			$r[Xml].= "  -->";
			
		}

	}
	$level++;
	$tags[$level]=$tag;

	if(count($attr)) $r[Xml].="\r\n";

	$r[Xml].="&gt;";

	if($attr['text']) $r[Xml].="<![CDATA[".$attr['text']."]]>";

}


function endtag()
{	
	global $level,$tags,$r;

	$tag=$tags[$level];
	$level--;
	$r[Xml].="\n&lt;/$tag&gt;";
}


function xml2bd()
{	
	global $Xml,$Type,$Act,$PageID,$id,$site_path,$error;
	

	while(strstr($Xml,"<--"))
	{
		$Xml=substr($Xml,0,strpos($Xml,"<--")).substr($Xml,strpos($Xml,"-->",strpos($Xml,"<--"))+3);
	}

	if(!$Type)
	{
		$q=select("select @Type");
		$Type=$q[0];
	}
	if(!$Site)
	{
		$q=select("select @Site");
		$Site=$q[0];
	}

	$id=$PageID;
	$Xml=stripslashes($Xml);
	$tmp = new cls_xml();
	$tmp->loadxml($Xml);
	$item=$tmp->documentElement;

	$a=$item->ownerDocument->nodes[0];
	$Act=$a->tagname;


	if(!$item) runsql("set @error='Not valid XML'");
	else
	$item->Xml2File($Type,$Act);

	//if(file_exists($site_path."xml/".$Site.$Type.))

}




function makexml($site1,$type,$act)
{
	global $site,$level,$tages,$r;

	$r[Xml]="";
	$level=0;
	$site2=$site;
	$site=$site1;

	$form=new cls_form($type,$act);

	printattributes($form,$act);

	$i=0;
	if($form->attributes['item'])
	{
	$r[Xml].="\r\n";
	$r[Xml].="\r\n";
		printattributes($form,'header');
	$r[Xml].="\r\n";
	$r[Xml].="\r\n";
			foreach($form->attributes['item'] as $item)
			{
				printattributes($form,'item',$item);
				endtag();
				$r[Xml].="\r\n";
				if($i++<>count($form->attributes['item'])-1) $r[Xml].="\r\n";
			}
		endtag();
	//$r[Xml].="\r\n";

	}


	$i=0;
	if($form->attributes['field'])
	{
	$r[Xml].="\r\n";
	$r[Xml].="\r\n";
		printattributes($form,'fields');
	$r[Xml].="\r\n";
	$r[Xml].="\r\n";

		if($form->attributes['field'])
		{

			foreach($form->attributes['field'] as $field)
			{
				printattributes($form,'field',$field);
				endtag();
				$r[Xml].="\r\n";
				if($i++<>count($form->attributes['field'])-1) $r[Xml].="\r\n";
			}
		}

		endtag();
	//$r[Xml].="\r\n";

	}


	$i=0;

		if($form->attributes['button'])
		{
			$r[Xml].="\r\n";
			$r[Xml].="\r\n";

			foreach($form->attributes['button'] as $button)
			{
				printattributes($form,'button',$button);
				endtag();
				$r[Xml].="\r\n";
				if($i++<>count($form->attributes['button'])-1) $r[Xml].="\r\n";
			}
		}

	//$r[Xml].="\r\n";

	

	endtag();


	$site=$site2;

}

function getmessages($id)
{
	global $site_path;

	$q=select("select Url from en_menu where MenuID='$id'");
	if(!$q[Url]) $q[Url]="page.php";

	if($q[Url]&&file_exists($site_path.$q[Url]))
	{

		$f=fopen($site_path.$q[Url],"r");
		$str=fread($f,filesize($site_path.$q[Url]));
		while($n=strpos($str,"message("))
		{
			$st.= substr($str,$n+8,strpos($str,")",$n+8)-$n-8).",";
			$str=substr($str,$n+1);
		}

		if($st) print substr($st,0,strlen($st)-1);
		else print "999999";
	}
	else print "999999";
}

?>