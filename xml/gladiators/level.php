<?
require('../../config.php');
$form_width=170;
require($engine_path."cls/auth/session.php");
$type="gladiators/train";

$act="distribution";

$rst=$auth->rst;

unset($r);



if($step)
{

lock_rst($auth->user);

$gladiator=$auth->rst[Gladiators][$id];

$k=$id;


$exp=round($gladiator[Exp]+expgained($auth->rst));
$q=select("select Level from ut_exp where Points<='$exp' order by Level desc limit 0,1");
$points=($q[Level]-$gladiator[Level])*3;

	$level=$q[Level];

	unset($er);


	if(!$id) $er="error 1";

	if(($_GET['Vit']+$_GET['Dex']+$_GET['Acc']+$_GET['Str'])-($gladiator[Vit]+$gladiator[Dex]+$gladiator[Acc]+$gladiator[Str])!=$points) $er="error 2";
	
	if(($_GET['Vit']<$gladiator[Vit])||!$_GET['Vit']) $er="error 3";
	if(($_GET['Dex']<$gladiator[Dex])||!$_GET['Dex']) $er="error 4";
	if(($_GET['Acc']<$gladiator[Acc])||!$_GET['Acc']) $er="error 5";
	if(($_GET['Str']<$gladiator[Str])||!$_GET['Str']) $er="error 6";

	if(!$level) $er="error 7";

	if(!$auth->rst[Gladiators][$id]) $er="error 8";
	
	if($er) print icon("error",$er)."<br>";

	if(!$er)
	{

		runsql("update ut_gladiators g set Price=round(power(1.18,'$level')*(12/(10-Talent)-1)*(select Coefficient from ut_gladiator_types where TypeID=g.TypeID)*1.5*EXP((Age-23)*(Age-23)/-200)*100) where GladiatorID='$id'");

		$rst=$auth->rst;

		$q=select("select Price from ut_gladiators where GladiatorID='$id'");
		$rst[Gladiators][$id][Price]=$q[0];		

		$rst[Gladiators][$id][Level]=$level;		
		$rst[Gladiators][$id][Vit]=$_GET['Vit'];
		$rst[Gladiators][$id][Dex]=$_GET['Dex'];
		$rst[Gladiators][$id][Acc]=$_GET['Acc'];
		$rst[Gladiators][$id][Str]=$_GET['Str'];
		
		$auth->rst=$rst;
		write_rst($auth->user,$rst);

	}



unlock_rst($auth->user);

header("Location:/xml/gladiators/train.php");

}

require($site_path."up.php");


require($site_path."left.php");



$gladiator=$auth->rst[Gladiators][$id];

$k=$id;
unset($serialized);
$gladiator[Exp]=round($gladiator[Exp]+expgained($auth->rst));
$exp=$gladiator[Exp];

$q=select("select Level from ut_exp where Points<='$exp' order by Level desc limit 0,1");
$points=($q[Level]-$gladiator[Level])*3;




if($id&&$gladiator&&$points>0)
{
?>

<table border=0 bgcolor=#78746C cellspacing=1 cellpadding=4>

<tr bgcolor=#545E61><td colspan=3><img align=absmiddle src=/images/types/<?=$gladiator[TypeID]?>.gif> <?=$gladiator[Name]?> [<?=$gladiator[Level]?>]</td></tr>

<?
$gladiator[Level]=$q[Level];
?>
<form name="distribution" method="post" enctype="multipart/form-data" action="/xml/gladiators/level.php?type=gladiators/train&act=distribution">
<input type="hidden" name="step" value="1"/>
<input type="hidden" name="id" value="<?=$id?>"/>


<?
$res=runsql("select *,Name_$lang as Name from ut_abilities where AbilityID>=1 and AbilityID<=6 order by AbilityID");


while($r=mysql_fetch_array($res))
{

	if($r[AbilityID]<=2)
	{
		print "<tr bgcolor=#545E61><td>$r[Name]</td><td >".$gladiator[$r[Ability]]."</td></tr>";
	}
	else
	{

	print "<tr bgcolor=#545E61><td>$r[Name]</td><td>
<input type=\"button\" onclick=\"changeAbility('$r[Ability]',-1)\" id=\"$r[Ability]Minus\" class=disabledbutton style=\"width:20;\" value=\"-\"> 
<input type=\"string\" id=\"$r[Ability]\" size=\"2\" name=\"$r[Ability]\" readonly class=clear style=\"text-align:center;height:16px\" value=\"".$gladiator[$r[Ability]]."\"> 
<input type=\"hidden\" id=\"Cur$r[Ability]\" value=\"".$gladiator[$r[Ability]]."\"> 
<input type=\"button\" onclick=\"changeAbility('$r[Ability]',1)\" id=\"$r[Ability]Plus\" class=bluebutton style=\"width:20\" value=\"+\"></td>";
	}

	if($r[AbilityID]==2) 	print "<tr bgcolor=#545E61><td colspan=3>".message(251).": <input type=\"string\" size=\"2\" name=\"Points\" id=\"Points\" readonly class=clear value=\"$points\" > </td></tr>";

}
?>
<tr><td colspan=3 bgcolor=#68717>
<input class=disabledbutton type=submit id="Submit" 
value=Сохранить onclick="this.disabled = true; this.className='disabledbutton';
document.getElementById('VitMinus').disabled = true; 
document.getElementById('DexMinus').disabled = true; 
document.getElementById('AccMinus').disabled = true; 
document.getElementById('StrMinus').disabled = true; 
 this.form.submit();"></td></tr>
</form></table>

<script>
document.getElementById("VitMinus").disabled = true; 
document.getElementById("DexMinus").disabled = true; 
document.getElementById("AccMinus").disabled = true; 
document.getElementById("StrMinus").disabled = true; 

document.getElementById("Submit").disabled = true; 


function changeAbility(ability,change)
{

	if(document.getElementById("Points").value==0&&change>0) return false;


	document.getElementById(ability).value=eval(document.getElementById(ability).value)+change;

	document.getElementById("Points").value=eval(document.getElementById("Points").value)-change;

	if(eval(document.getElementById(ability).value)>eval(document.getElementById("Cur"+ability).value)) 
	{document.getElementById(ability+"Minus").disabled=false;document.getElementById(ability+"Minus").className='bluebutton';}
	else {document.getElementById(ability+"Minus").disabled=true;document.getElementById(ability+"Minus").className='disabledbutton';}

	if(eval(document.getElementById("Points").value)==0) 
	{
		document.getElementById("VitPlus").disabled=true;
		document.getElementById("VitPlus").className='disabledbutton';

		document.getElementById("DexPlus").disabled=true;
		document.getElementById("DexPlus").className='disabledbutton';

		document.getElementById("AccPlus").disabled=true;
		document.getElementById("AccPlus").className='disabledbutton';

		document.getElementById("StrPlus").disabled=true;
		document.getElementById("StrPlus").className='disabledbutton';

		document.getElementById("Submit").disabled=false;
		document.getElementById("Submit").className='button';

		
	}
	else
	{
		document.getElementById("VitPlus").disabled=false;
		document.getElementById("VitPlus").className='bluebutton';

		document.getElementById("DexPlus").disabled=false;
		document.getElementById("DexPlus").className='bluebutton';

		document.getElementById("AccPlus").disabled=false;
		document.getElementById("AccPlus").className='bluebutton';

		document.getElementById("StrPlus").disabled=false;
		document.getElementById("StrPlus").className='bluebutton';

		document.getElementById("Submit").disabled=true;
		document.getElementById("Submit").className='disabledbutton';
	}


}
</script>

<?

}

require($site_path."bottom.php");

?>