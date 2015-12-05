<?require('../../config.php');
//$form_width=170;

require($engine_path."cls/auth/session.php");if(!$act) $act="select";
$type="residence/treasury";

if($user&&checkpriv("control/support","")) setvar('user',$user);
else {setvar('user',$auth->user);$user=$auth->user;}


require($site_path."up.php");
function getmenurow($name,$value,$money)
{
	global $gd;

	if($value<0) $color="red";
	elseif($value>0) $color="green";
	else $color="black";

	if($money) $value="$value"."$gd";

	return "<font class=blue>$name:##<font color=$color>$value</b></font>";
}



Class cls_catalog extends cls_root
{
var $numbered=1;
var $id;
var $table;
var $type;
var $val;

    function DrawPart($parent,$pref)
    { 
	global $resstr;

     $res=runsql("select t.$this->id,t.Name_\$lang; as Name from $this->table t left outer join $this->table p on p.$this->id=t.$this->id where t.Parent='$parent' and t.$this->id<>t.Parent group by t.$this->id order by t.Name_\$lang;");

	if(mysql_error()) {print mysql_error();exit;}

     while($r=mysql_fetch_array($res))
     { 
      $num++;

      unset($str);
      if($pref) $str="$pref";

      if($this->numbered==1) $str.="$num.";
      elseif($parent<>'0') $str.="&nbsp;&nbsp;";

	if($this->type=="select")
	{
		$resstr.= " <option value=\"$r[0]\"";
		if($r[0]==$this->val) $resstr.= " selected";
		$resstr.= ">$str $r[1]</option>";
	}
	else
	{
		$resstr.= "$str ";

		if($id!=$r[0]) $resstr.="<a href=\"$PHP_SELF?id=$r[0]\">";

		if(strlen($str)<4) $resstr.= "<b>";

		$resstr.= "$r[1]";
	
		$resstr.= "</b></a>";
		$resstr.= "<br>";
	}


      $r[types]+=$this->DrawPart($r[0],$str);


     }
     return($r[types]);
    }


    function Draw($table,$id,$type,$val)
    {
	global $resstr;

	$this->type=$type;
	$this->val=$val;

	$this->table=$table;
	$this->id=$id;
	$this->DrawPart(0);

	return $resstr;
    }

}


$catalog = new cls_catalog();
$leftcontent= $catalog->Draw('fn_operation_types','TypeID','list',$id);


require($site_path."left.php");



?>
<center><img src="/images/art/treasury.jpg" width=500px height=300px></center>
<?





print "<img src=/images/hr.gif width=473 height=10>";

$form->Draw();
require($site_path."bottom.php");?>