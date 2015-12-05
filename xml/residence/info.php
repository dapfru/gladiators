<?
require('../../config.php');
$form_width=170;

if($act=="distribution") unset($act);

function upfirst($name,$delimeter,$flag)
{
 if(strstr($name,$delimeter))
 {
	$nameArr = split( $delimeter, trim( $name ) ); 
	foreach( $nameArr as $namePart ) { 
	if (!$flag) $namePart = downstr( trim($namePart) ); 
	$finName .= upstr( substr( $namePart, 0, 1 ) ) . substr( $namePart, 1, strlen( $namePart ) - 1 ) . $delimeter; 
 } 
 $name = substr( $finName, 0,  strlen( $finName ) - 1); 


 }

	return $name;
}



require($engine_path."cls/auth/session.php");

if($user&&!is_numeric($user))
{
	if($lang=="rus") $user=iconv("UTF-8", "Windows-1251", $user);

	$user=addslashes($user);
	$user=strip_tags($user);

	$q=select("select UserID from ut_users where Login='$user'");
	$user=$q[0];
	$_POST['user']=$user;

}

if(!$user) $user=$auth->user;

$_GET['user']=$user;
$id=$user;


$t=explode("/",$type);

if($t[0]!="residence") $type="residence/profile";

if($type=="residence/photos"&&!$act) $act="listphotos";
elseif($type=="residence/friends"&&!$act) $act="friends";


if($step)
{
	$_POST['pwd']=md5($_POST['NewPassword'].$secpass);

$_POST['FirstName']=upfirst($_POST['FirstName'],"-",0);
$_POST['LastName']=upfirst($_POST['LastName'],"-",0);
$_POST['City']=upfirst($_POST['City']," ",0);
$_POST['City']=upfirst($_POST['City'],"-",1);


}

if(!$act) $act="info";

require($site_path."up.php");

$cur=1;
if($step&&!$er) $cur=2;


if((!$act||$act=="select")&&$auth->user!=$user&&$type=="residence/profile") 
{
	$leftcontent="<br><table width=186 border=0 height=100% cellspacing=0 cellpadding=0>";

	$q=select("select Login,if(UserID in (select FriendID from jr_friends where UserID='$auth->user'),1,0) from ut_users where UserID='$user'");

if(!$q[1])
{
	$leftcontent.="<tr height=20px>
<td><img src=\"/images/icons/user.gif\" border=0 width=17px height=17px></td>
<td width=166><a href=\"$PHP_SELF?type=residence/friends&act=insert&step=1&Login=$q[0]\" class=\"boldlink\">".message(177)."</a></td>
<tr><td colspan=2><img src=\"/images/hr2.gif\" height=10px></td></tr>";
}

	$leftcontent.= "
<tr height=20px>
<td><img src=\"/images/icons/mail.gif\" border=0 ></td>
<td><a href=\"$site_url"."xml/residence/mail.php?act=write&user=$user\" class=\"boldlink\">".message(178)."</a></td>
<tr><td colspan=2><img src=\"/images/hr2.gif\" height=10px></td>";

	$leftcontent.= "</tr></table>";
}



require($site_path."left.php");



$img=0;

if($act=="info"&&file_exists($site_path."images/ut_users/small/$id.jpg")) 
{
	$q=select("select Approved from ut_users where UserID='$id'");

	if($q[Approved]==1) 
	{
		$img=1;
		print "<table border=0 cellspacing=0 cellpadding=0 width=100%><td width=100% valign=top>";
		if($type) $form->Draw();
		print "</td><td valign=top style='padding-left:10px'><img src=/images/ut_users/small/$id.jpg ></td></table>";

	}
}

if($type&&!$img) $form->Draw();


if($act=="info")
{


if($user==$auth->user) 
{

	print "<br>";
	$form=new cls_form($type,"chars");


if($step)
{

$rst=$auth->rst;
lock_rst($auth->user);

if($rst[Points]+$rst[Charisma]+$rst[Command]+$rst[Management]+$rst[Commerce]!=$_GET[Charisma]+$_GET[Command]+$_GET[Management]+$_GET[Commerce]) $er=1;
else $rst[Points]=0;

if($_GET[Charisma]>=$rst[Charisma]) $rst[Charisma]=$_GET[Charisma];
else $er=2;

if($_GET[Command]>=$rst[Command]) $rst[Command]=$_GET[Command];
else $er=3;

if($_GET[Management]>=$rst[Management]) $rst[Management]=$_GET[Management];
else $er=4;

if($_GET[Commerce]>=$rst[Commerce]) $rst[Commerce]=$_GET[Commerce];
else $er=5;

if(!$er) {write_rst($auth->user,$rst);$auth->rst=$rst;}

unlock_rst($auth->user);


}




$points= $auth->rst[Points];

?>

<table border=0 bgcolor=#78746C cellspacing=1 cellpadding=4>

<?
$gladiator[Level]=$q[Level];
?>
<form name="distribution" method="post" enctype="multipart/form-data" action="<?=$PHP_SELF?>?step=1">
<input type="hidden" name="step" value="1"/>


<?
$res=runsql("select *,Name_$lang as Name from ut_abilities where AbilityID>=7 and AbilityID<=10 order by AbilityID");

if($points>0) print "<tr bgcolor=#545E61><td colspan=3>".message(251).": <input type=\"string\" size=\"2\" name=\"Points\" id=\"Points\" readonly class=clear value=\"$points\" > </td></tr>";

$col="545E61";

while($r=mysql_fetch_array($res))
{
	if($col=="3B484C") $col="545E61";
	else $col="3B484C";

	print "<tr bgcolor=$col><td>$r[Name]</td><td>";

if($points>0) print "<input type=\"button\" onclick=\"changeAbility('$r[Ability]',-1)\" id=\"$r[Ability]Minus\" class=disabledbutton style=\"width:20;\" value=\"-\"> ";

print "<input type=\"string\" id=\"$r[Ability]\" size=\"2\" name=\"$r[Ability]\" readonly class=clear style=\"text-align:center;height:16px;background-color:$col\" value=\"".$auth->rst[$r[Ability]]."\"> ";

print "<input type=\"hidden\" id=\"Cur$r[Ability]\" value=\"".$auth->rst[$r[Ability]]."\"> ";

if($points>0) print "<input type=\"button\" onclick=\"changeAbility('$r[Ability]',1)\" id=\"$r[Ability]Plus\" class=bluebutton style=\"width:20\" value=\"+\">";

print "</td>";



}

if($points>0)
{
?>
<tr><td colspan=3 bgcolor=#68717>
<input class=disabledbutton type=submit id="Submit" 
value=Сохранить onclick="this.disabled = true; this.className='disabledbutton';
document.getElementById('CharismaMinus').disabled = true; 
document.getElementById('CommandMinus').disabled = true; 
document.getElementById('ManagementMinus').disabled = true; 
document.getElementById('CommerceMinus').disabled = true; 
 this.form.submit();">

</td></tr>

<?
}
?>

</form></table>

<?
if($points>0)
{
?>

<script>

document.getElementById("CharismaMinus").disabled = true; 
document.getElementById("CommandMinus").disabled = true; 
document.getElementById("ManagementMinus").disabled = true; 
document.getElementById("CommerceMinus").disabled = true; 


document.getElementById("Submit").disabled = true; 


function changeAbility(ability,change)
{


	if(eval(document.getElementById("Points").value)==0&&change>0) return false;


	document.getElementById(ability).value=eval(document.getElementById(ability).value)+change;

	document.getElementById("Points").value=eval(document.getElementById("Points").value)-change;

	if(eval(document.getElementById(ability).value)>eval(document.getElementById("Cur"+ability).value)) 
	{document.getElementById(ability+"Minus").disabled=false;document.getElementById(ability+"Minus").className='bluebutton';}
	else {document.getElementById(ability+"Minus").disabled=true;document.getElementById(ability+"Minus").className='disabledbutton';}

	if(eval(document.getElementById("Points").value)==0) 
	{
		document.getElementById("CharismaPlus").disabled=true;
		document.getElementById("CharismaPlus").className='disabledbutton';

		document.getElementById("CommandPlus").disabled=true;
		document.getElementById("CommandPlus").className='disabledbutton';

		document.getElementById("ManagementPlus").disabled=true;
		document.getElementById("ManagementPlus").className='disabledbutton';

		document.getElementById("CommercePlus").disabled=true;
		document.getElementById("CommercePlus").className='disabledbutton';

		document.getElementById("Submit").disabled=false;
		document.getElementById("Submit").className='button';

		
	}
	else
	{
		document.getElementById("CharismaPlus").disabled=false;
		document.getElementById("CharismaPlus").className='bluebutton';

		document.getElementById("CommandPlus").disabled=false;
		document.getElementById("CommandPlus").className='bluebutton';

		document.getElementById("ManagementPlus").disabled=false;
		document.getElementById("ManagementPlus").className='bluebutton';

		document.getElementById("CommercePlus").disabled=false;
		document.getElementById("CommercePlus").className='bluebutton';

		document.getElementById("Submit").disabled=true;
		document.getElementById("Submit").className='disabledbutton';
	}


}
</script>

<?
}
}
}



if($user!=$auth->user)
{
	print "<p><img src=/images/icons/mail.gif> <a href=/xml/residence/mail.php?act=write&Login=$r[Login]><b>Написать личное сообщение</b></a><p>";
	$act="select";
	$type="gladiators/roster";
	$form=new cls_form($type,$act);
	require($site_path."xml/gladiators/gladiators.php");
}


require($site_path."bottom.php");
?>
