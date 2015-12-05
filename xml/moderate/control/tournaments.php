<?

require('../../../config.php');

$types_ar=array(0=>'на вылет',1=>'группа');	
$ft_types_ar=array(1=>'сражение',2=>'поединок',3=>'серия',4=>'выживание');	
$fights_ar=array('1','3','5');


if($act=="update") 
{
	if(!$id) exit;
	$q=select("select * from ft_tournament_types where TournamentTypeID='$id'");
	if(!$q[0]) exit;

	$_POST['Name']=$q[Name];
	$_POST['Description']=$q[Description];

	$res=runsql("select * from ft_stages where TournamentTypeID='$id' order by StageID");

	$_POST['maxstages']=mysql_num_rows($res);
	
	$i=1;

	while($q=mysql_fetch_array($res))
	{
		$_POST["numtour$i"]=$q[Tour2]-$q[Tour1]+1;
		$_POST["stagetype$i"]=$q[TypeID];

		$res1=runsql("select * from ft_reglaments where StageID='$q[StageID]' order by ReglamentID");

		$_POST["numfights$i"]=mysql_num_rows($res1);

		$j=0;

		while($q1=mysql_fetch_array($res1))
		{
			$_POST[$i."ftype".$j]=$q1[TypeID];
			$_POST[$i."limit".$j]=$q1[GladLimit];
			$_POST[$i."skill".$j]=$q1[SklLimit];
			$_POST[$i."extra".$j]=$q1[ExtraGlad];

			$j++;
		}

		$i++;
	}	


	$act="insert";
}

function create_tournament()
{
	global $_POST,$auth,$er, $types_ar,$ft_types_ar,$fights_ar ;


$name=$_POST['Name'];


$tour1=1;
$f=0;
$numplayers=0;
$id=$_POST[id];

for($i=$_POST['maxstages'];$i>=1;$i--)
{


if($num=$_POST["numtour$i"])
{
	$typeid=$_POST["stagetype$i"];

	$numfights=$_POST["numfights$i"];

	if($typeid==1) $_POST["numtour$i"]=3;

	if($typeid==0&&!$num) $_POST["numtour$i"]=1;

	if($typeid==0&&!$numplayers) $numplayers=pow(2,$num);
	elseif($typeid==0) $numplayers=$numplayers*pow(2,$num);

	if($typeid==1&&!$numplayers) $numplayers=4;
	elseif($typeid==1) $numplayers=$numplayers*2;	
}
		
}


if($numplayers>32) $er.="Максимальное число участников турнира на данный момент - 32<br>";
if($numplayers<4) $er.="Минимальное число участников турнира на данный момент - 4<br>";

if(!$er)
{

if($id) 
{
	
	$sql="update ft_tournament_types set
Name='$name',
UserID='$auth->user', 
GuildID='$guild',
Prize='$prize',
Description='$_POST[Description]',
StatusID=0,
NumPlayers='$numplayers',
NumStages='$_POST[cntstages]',
NumTours='$_POST[cnttours]',
NumFights='$_POST[cntfights]',
TotalTime='$_POST[cnttime]'
 where TournamentTypeID='$id'";
	mysql_query($sql);

	runsql("delete from ft_reglaments where StageID in (select StageID from ft_stages where TournamentTypeID='$id')");
	runsql("delete from ft_stages where TournamentTypeID='$id'");
	$tournament=$id;
}
else 
{

$sql="insert into ft_tournament_types(Name,Date,UserID, GuildID,Prize,StatusID,NumPlayers,NumStages,NumTours,NumFights,TotalTime,Description )
values('$name',unix_timestamp(),$auth->user, '$guild','$prize',0,'$numplayers','$_POST[cntstages]','$_POST[cnttours]','$_POST[cntfights]','$_POST[cnttime]','$_POST[Description]')";

mysql_query($sql);
$tournament=mysql_insert_id();

}

if(!$tournament) {print "Ошибка создания турнира";}

$reglament="<table border=0 bordercolor=78746C bgcolor=78746C cellpadding=4 width=100% cellspacing=1>
<tr class=header><td><center>Турнир проходит в ".$_POST[cntstages]." ";

if($_POST[cntstages]==1) $reglament.=" этап";
elseif($_POST[cntstages]<5) $reglament.=" этапа";
else $reglament.=" этапов";

$reglament.=":</td></tr>";



$ns=0;
for($i=1;$i<=$_POST['maxstages'];$i++)
{

//if($_POST[cntstages]>1) $reglament.="<br>";


if($num=$_POST["numtour$i"])
{
	$typeid=$_POST["stagetype$i"];
	$numfights=$_POST["numfights$i"];

	$ns++;

	$tour2=$tour1+$num-1;

	$sql="insert into ft_stages(TournamentTypeID,Tour1,Tour2,TypeID) values('$tournament','$tour1','$tour2','$typeid');";

//if($col=="#545E61") $col="#3B484C";
//else 
//$col="#545E61";

$col="#3B484C";

$reglament.="<tr bgcolor=\"$col\"><td>";

if($_POST[cntstages]>1) $reglament.="<img src=/images/marker3.gif width=11px height=11px> ";

$reglament.="$num";

if($num==1) $reglament.=" тур";
elseif($num<5) $reglament.=" тура";
else $reglament.=" туров";

$reglament.=" <b>".$types_ar[$typeid]."</b>  </u>(";

if($numfights>1)
{
$reglament.=$numfights;

if($numfights<5) $reglament.=" боя";
else $reglament.=" боёв";

$reglament.=" в туре: ";
}

	mysql_query($sql);
	$stage=mysql_insert_id();
	if(!$stage) {print "Ошибка создания турнира";}

$n=1;


for($j=0;$j<$numfights;$j++)
{


	$k=$j+$f;
	$typefight=$_POST[$i."ftype".$j];
	$limit=$_POST[$i."limit".$j];
	$skill=$_POST[$i."skill".$j];
	$extra=$_POST[$i."extra".$j];
	if($extra=='on') $extra=1;
	else $extra=0;

	$reglament.="<b>".$ft_types_ar[$typefight]."</b>";

	$reg="";
	if($typefight!=2) $reg.=" до $limit гладиаторов, ";
	if($skill) $reg.=" уровень до $skill, ";
	if($extra=='off'&&$typefight==1) $reg.=" без экстра-типов, ";
	if($reg) $reglament=$reglament." - ".substr($reg,0,strlen($reg)-2);

	$reglament.=", ";

	$sql="insert into ft_reglaments(StageID,TypeID,SklLimit,GladLimit ,ExtraGlad,Num  ) 
values('$stage','$typefight','$skill','$limit','$extra','$n');";
	$n++;

	mysql_query($sql);

}

$f+=$numfights;

$reglament=substr($reglament,0,strlen($reglament)-2);
$reglament.=")</td></tr>";

	
	$tour1=$tour2+1;
}
}


}

$reglament.="</table>";
runsql("update ft_tournament_types set Reglament='$reglament' where TournamentTypeID='$tournament'");

}



$type="control/tournaments";

require($site_path."moderate/up.php");


if($act!="insert")
{	
	$form->draw();
}
else
{





$form->Header();
$form->DrawHeader();
$form->DrawFields();


?>
<style>
	.row {background-color:#545E61; text-align:center;}
</style>
<script>
var numstage=0;
var maxstage=0;
var rowid=0;


function deleterow(id)
{

	if(numstage==1)
	{
		alert('Нельзя удалить эту стадию');
		return '';
	}
	
	update_rows(id,1);

	var d = document;
	var tbody=d.getElementById('stages');
	tbody.removeChild(d.getElementById('row'+id));

	ar=d.getElementsByName('label');

	for(var i=0; i<ar.length; i++)
	{
		ar[i].value=(i+1)+')';
	}

	numstage--;

	getnumplayers();
	gladlimit(0);

}

function deleterow2(name)
{

	var d = document;
	var tbody=d.getElementById('stages');

	tbody.removeChild(d.getElementById(name));

	ar=d.getElementsByName('label');

	for(var i=0; i<ar.length; i++)
	{
		ar[i].value=(i+1)+')';
	}


}

function gladlimit(type)
{

	var totaltime=0;
	var f=0;

	for(var i=maxstage;i>=1;  i--)
	{
if(document.forms.insert.elements['numfights'+i])
{

	for(var j=document.forms.insert.elements['numfights'+i].value-1;j>=0;  j--)
	{
		var ft=document.forms.insert.elements[i+'ftype'+j].value;
		var lt=document.forms.insert.elements[i+'limit'+j].value;

		var nt=document.forms.insert.elements['numtour'+i].value;

		if(ft==2) totaltime+=5*Math.round(nt)*Math.round(document.forms.insert.elements['numfights'+i].value);
		else totaltime+=10*Math.round(nt)*Math.round(document.forms.insert.elements['numfights'+i].value);

		if(ft!=1) document.forms.insert.elements[i+'extra'+j].checked=0;

		if(ft==2) {document.forms.insert.elements[i+'limit'+j].value=1;lt=1;}

		if((!lt&&!type)||lt>7) {document.forms.insert.elements[i+'limit'+j].value=7;lt=7;}

		if(ft==3&&(lt==2||lt==4||lt==6)) document.forms.insert.elements[i+'limit'+j].value=5;

		if((ft==3||ft==4)&&lt>5) {document.forms.insert.elements[i+'limit'+j].value=5;lt=5;}


	}
}

	}

	document.forms.insert.elements['cnttime'].value=totaltime;

}


function getnumplayers(type)
{
	var er=0;

	var numplayers=0;
	var numtours=0;
	var numfights=0;


	for(var i=maxstage;i>=1;  i--)
	{

if(document.forms.insert.elements['numtour'+i])
{
		var nt=document.forms.insert.elements['numtour'+i].value;

		numfights+=Math.round(nt)*Math.round(document.forms.insert.elements['numfights'+i].value);

		numtours=Math.round(numtours)+Math.round(nt);

		var st=document.forms.insert.elements['stagetype'+i].value;



		if(st==1&&nt!=3) {nt=3;document.forms.insert.elements['numtour'+i].value=3;}

		if(st==0&&nt==''&&!type) {nt=1;document.forms.insert.elements['numtour'+i].value=1;}

		if(st==0&&!numplayers) numplayers=Math.pow(2,nt);
		else if(st==0) numplayers=numplayers*Math.pow(2,nt);

		if(st==1&&!numplayers) numplayers=4;
		else if(st==1) numplayers=numplayers*2;		
}
	}


	document.forms.insert.elements['cntplayers'].value=numplayers;
	document.forms.insert.elements['cntstages'].value=numstage;
	document.forms.insert.elements['cnttours'].value=numtours;
	document.forms.insert.elements['cntfights'].value=numfights;
	document.forms.insert.elements['maxstages'].value=maxstage;
}

function addrow(id)
{

	var d = document;
	var tbody=d.getElementById('stages');

	numstage++;
	maxstage++;

	if(id>maxstage) maxstage=id;

	var row = d.createElement("TR");
	row.className='row';
	row.id="row"+id;


	tbody.appendChild(row);

   	var td1 = d.createElement("TD");
   	var td2 = d.createElement("TD");
   	var td3 = d.createElement("TD");
   	var td4 = d.createElement("TD");
   	var td5 = d.createElement("TD");
   	var td6 = d.createElement("TD");
   	var td7 = d.createElement("TD");
   	var td8 = d.createElement("TD");
   	var td9 = d.createElement("TD");

    	row.appendChild(td1);
    	row.appendChild(td2);
    	row.appendChild(td3);
    	row.appendChild(td4);
    	row.appendChild(td5);
    	row.appendChild(td6);
    	row.appendChild(td7);
    	row.appendChild(td8);
    	row.appendChild(td9);


	td1.innerHTML="<input class=clear name='label' readonly style='width:10px' value='"+numstage+")' type=text>";
	td2.innerHTML="<input type='text' name='numtour"+id+"' value=1 onkeypress='checknumeric(event);' onkeyup='getnumplayers(1)' size=2>";

<?
	$str= "<select name='stagetype\"+id+\"' onchange='getnumplayers(0);'>";

		foreach($types_ar as $k=>$v)
		{
			$str.= "<option value=$k>$v</option>";
		}

		$str.="</select>";

?>
	td3.innerHTML="<?=$str?>";

	
<?
		$str= "<input type='hidden' id='numfights\"+(id)+\"old'><select name='numfights\"+id+\"' onchange='update_rows(\"+(id)+\",this.value);gladlimit(0);getnumplayers(0);'>";

		foreach($fights_ar as $a)
		{
			$str.= "<option value=$a>$a</option>";
		}

		$str.= "</select>";
?>
	td4.innerHTML="<?=$str?>";


<?
		$str= "<select name='\"+id+\"ftype\"+0+\"' onchange='gladlimit(0);'>";

		foreach($ft_types_ar as $k=>$v)
		{
			$str.= "<option value=\'$k\'>$v</option>";
		}

		$str.= "</select>";
?>
	td5.innerHTML="<?=$str?>";

	td6.innerHTML="<input type='text' name='"+id+"limit"+0+"' value='' onkeypress='checknumeric(event);' onkeyup='gladlimit(1);' size=2>";
	td7.innerHTML="<input type='text' name='"+id+"skill"+0+"' value='' onkeypress='checknumeric(event);' size=2>";
	td8.innerHTML="<input type='checkbox' style='background-color:#545E61' name='"+id+"extra"+0+"' onclick='gladlimit(0);' checked>";

	td9.innerHTML='<a href=\"javascript:;\" onclick=\"deleterow(\''+(id)+'\')\"><img src=/images/engine/drop.png width=16 height=16 border=0></a>';
	rowid++;


	getnumplayers(0);
	gladlimit(0);
}



function update_rows(id,val)
{

	var old=document.getElementById('numfights'+id+'old').value;

	if(old!=val) 
	{

	if(old>1) 
	{

		for(var i=old-1; i>0; i--)
		{

			deleterow2(id+'reg'+i);
		}
	}

	for(var i=val-1; i>0; i--)
	{
		addrow2(id,i);
	}

	document.getElementById('numfights'+id+'old').value=val;

	}

	
}

function addrow2(id,i)
{
	var d = document;
	var tbody=d.getElementById('stage'+id);

	var r=d.getElementById('row'+id);

	var row = d.createElement("TR");
	row.className='row';

	row.id=id+'reg'+i;

	var newTr = r.parentNode.insertBefore(row, r.nextSibling);

   	var td1 = d.createElement("TD");
	td1.colSpan=4;
   	var td5 = d.createElement("TD");
   	var td6 = d.createElement("TD");
   	var td7 = d.createElement("TD");
   	var td8 = d.createElement("TD");
   	var td9 = d.createElement("TD");

    	row.appendChild(td1);
 
    	row.appendChild(td5);
    	row.appendChild(td6);
    	row.appendChild(td7);
    	row.appendChild(td8);
    	row.appendChild(td9);


<?
		$str= "<select name='\"+id+\"ftype\"+i+\"'  onchange='gladlimit(0)'>";

		foreach($ft_types_ar as $k=>$v)
		{
			$str.= "<option value=$k>$v</option>";
		}

		$str.= "</select>";
?>
	td5.innerHTML="<?=$str?>";

	td6.innerHTML="<input type='text' name='"+id+"limit"+i+"' onkeyup='gladlimit(1);' value='' size=2>";
	td7.innerHTML="<input type='text' name='"+id+"skill"+i+"' onkeypress='checknumeric(event);' value='' size=2>";
	td8.innerHTML="<input type='checkbox' style='background-color:#545E61' name='"+id+"extra"+i+"' onclick='gladlimit(0);' checked>";

	td9.innerHTML='';
	rowid++;



}
</script>

<?

print "<tr bgcolor=\"#545E61\"><td colspan=2 align=center>
<input type=hidden name='id' value='$id'>
<input type=hidden name=maxstages>Игроков: <input type=text class=clear readonly name=cntplayers value='0' style='width:20px'> ";
print " Этапов: <input type=text class=clear readonly name=cntstages value='0' style='width:20px'> ";
print " Туров: <input type=text class=clear readonly name=cnttours value='0' style='width:20px'> ";
print " Боев: <input type=text class=clear readonly name=cntfights value='0' style='width:20px'> ";
print " Время: <input type=text class=clear readonly name=cnttime value='0' style='width:20px'> ";

print "<tr bgcolor=\"#545E61\"><td colspan=2>";


	print "<table border=0 bgcolor=\"#78746C\" cellspacing=1 cellpadding=4 width=100%>
<thead>
	<tr class=header align=center><td></td><td>Туров</td><td>Регламент</td><td>Боев</td>
<td>Тип</td><td>Глад</td><td>Уровень</td><td>Спец</td><td></td></tr></thead>

<tbody id='stages'>";



print "</tbody>

<tr class=header><td colspan=9><div align=left><input type=button onclick=\"addrow(maxstage+1)\" value=Добавить class=button></div></td>";

	print "</table>";


print "</td></tr>";

$form->DrawButton(2);

$form->Footer();

print "<script>";

$f=0;



if($_POST['maxstages'])
{

for($i=1;$i<=$_POST['maxstages'];$i++)
{

if($_POST["numtour$i"])
{

$numfights=$_POST["numfights$i"];

?>

addrow(<?=$i?>);


document.forms.insert.elements['numtour<?=$i?>'].value=<?=$_POST["numtour$i"]?>;
document.forms.insert.elements['stagetype<?=$i?>'].value=<?=$_POST["stagetype$i"]?>;
document.forms.insert.elements['numfights<?=$i?>'].value=<?=$_POST["numfights$i"]?>;

<?

for($j=$numfights-1;$j>=0;$j--)
{

	$k=$j+$f;

	if($j>0) print "addrow2($i,$j);";

	$typefight=$_POST[$i."ftype".$j];
	$limit=$_POST[$i."limit".$j];
	$skill=$_POST[$i."skill".$j];
	$extra=$_POST[$i."extra".$j];

	if($typefight) print "document.forms.insert.elements[$i+'ftype'+$j].value=$typefight;\n";
	if($limit) print "document.forms.insert.elements[$i+'limit'+$j].value=$limit;\n";
	if($skill) print "document.forms.insert.elements[$i+'skill'+$j].value=$skill;\n";

	if($extra=='on'||$extra=='1') print "document.forms.insert.elements[$i+'extra'+$j].checked=true;\n\n";
	else print "document.forms.insert.elements[$i+'extra'+$j].checked=false;\n\n";

}


print "document.getElementById('numfights".$i."old').value=$numfights;";

$f+=$numfights;


}
}

	print "getnumplayers();";
	print "gladlimit(0);";

}
else print "addrow(1);";


print "</script>";

}
require($site_path."admin/bottom.php");

?>