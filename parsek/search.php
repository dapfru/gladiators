<?

require("config.php");
$form_title="Поиск по сайту";


$type="main/search";
$act="request";


$str=str_replace("ё","е",$str);
$str=str_replace("Ё","Е",$str);

$HTTP_GET_VARS['str']=$str;

require("up.php");

if($str&&strlen($str)<3) 
{
	print icon("error","Введите запрос не менее 3 символов")."<br>";
	unset($str);
}

$t=0;
$ar=explode(" ",$str);
foreach($ar as $a)
{
if(strlen($a)>2) $t=1;
}


if($t==0) {print icon("error","Неправильный запрос")."<br>";unset($str);}


$form->draw();

if($str)
{

$time=microtime(1);


$ar=explode(" ",$str);

$sql="select * from en_searchindex s1";

$sql1="";
$n=1;
$sql2="";
$sql3="";

$i=0;


foreach($ar as $a)
{

if(strlen($a)>2)
{
	$a=cut_end_word(downstr($a));
	$ar[$i]=$a;
	$i++;

	$sql1.=" join (select SearchID,RecordID,Position,Word from en_searchindex where Word like '$a%'";
	if($n>2) $sql1.=" group by SearchID,RecordID";
	$sql1.=") s$n ";

	if($n==1) $sql1.=" on s.TableName<>'' and s.TableName is not null and s.SearchID=s1.SearchID ";
	else $sql1.=" on s$n.RecordID=s".($n-1).".RecordID and s$n.SearchID=s".($n-1).".SearchID";	

	$sql2.="Position$n-";
	$sql3.="s$n.Position as Position$n, ";
	$sql4.="s$n.Position-";
	if(count($ar)>1) $sql5.="Position$n asc,";

	$n++;
}

}
$sql.=" order by ";


$sql="select s.*,s.Name_$lang as Name,if(".count($ar).">1,min(abs(".substr($sql4,0,strlen($sql4)-1).")),0) as num,s1.RecordID,".substr($sql3,0,strlen($sql3)-2)." from en_search s 

$sql1
left outer join ut_materials m on m.MaterialID=s1.RecordID
 group by s1.RecordID,s1.SearchID 
 order by num asc,s1.SearchID desc, $sql5 m.Date desc";

$form->sql=$sql;
//print $sql;
//exit;

$form->getrows();

$res=$form->sqlres;

$num=$form->numrows;

print "<div align=right>";

if(substr($num,strlen($num)-1,1)==1) print "Найдена";
elseif(substr($num,strlen($num)-1,1)<5&&$num>0) print "Найдены";
else print "Найдено";

print " <b>".$num."</b> ";


if(substr($num,strlen($num)-1,1)==1) print "запись";
elseif(substr($num,strlen($num)-1,1)<5&&$num>0) print "записи";
else print "записей";


print " для <b>\"$str\"</b><hr>";

while($row=mysql_fetch_array($res))
{
	$recordid=$row[TableID];
	$title=set_params($row[Title]);
	$headline=set_params($row[Headline]);
	if(!$headline) $headline="''";

	$r=select("select *,$headline as Headline,$title as Title from $row[TableName] where $row[TableID]=$row[RecordID]");
	if($r[0]) 
	{

		print "<table border=0 cellspacing=1 width=100% cellpadding=4>";

		if($r[Small]) print "<td valign=top><div class=\"img-border-1\"><img src=\"$img_url?id=".$r[$recordid]."&table=$row[TableName]\" align=left width=81px border=\"0\"></div></td><td valign=top width=100%>";
		else print "<td width=87px></td><td valign=top>";

		if(strlen($r[Headline])>200&&$pos=strpos($r[Headline],".",200)) $r[Headline]=substr($r[Headline],0,1+$pos)."...";

$r[Headline]=strip_tags($r[Headline]);

$har=explode(" ",$r[Headline]);
foreach($har as $h)
{
	$word=cut_end_word(downstr($h));

	foreach($ar as $a)
	{
		if(strlen($a)>2)
		{
			if(strstr($word,$a)&&!strstr($word,"<b>")) $r[Headline]=str_replace($h,"<b>$h</b>",$r[Headline]);
		}
	}
}

$har=explode(" ",$r[Title]);
foreach($har as $h)
{
	$word=cut_end_word(downstr($h));

	foreach($ar as $a)
	{

		if(strstr($word,$a)&&!strstr($word,"<b>")) $r[Title]=str_replace($h,"<b>$h</b>",$r[Title]);

	}
}

	//	if(!strstr($row[Url],"?")) $url="$row[Url]?id=".$r[$recordid];
	//	else $url="$row[Url]&id=".$r[$recordid];

		$url=set_params($row[Url]);

		if($row[TableName]=="ut_materials"&&$r[Date]) print "<br>".date("d.m.Y",$r[Date])." ";
		print "<a href=\"$url\">".$r[Title]."</a><br>".$r[Headline];

		print "</td></table>";

		print "<hr>";
	}

}

	print "<table width=100% cellspacing=0 cellpadding=2 border=0>";
        $form->Pages();
	print "</table>";


print "Время поиска: ".round((microtime(1)-$time),2)." секунды";

}

require("bottom.php");
?>