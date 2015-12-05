<?
Class cls_catalog extends cls_root
{
var $numbered=1;
var $id;
var $table;
var $type;
var $val;

    function DrawPart($parent,$pref)
    { 

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
		print " <option value=\"$r[0]\"";
		if($r[0]==$this->val) print " selected";
		print ">$str $r[1]</option>";
	}
	else
	{
		print "$str <a href=\"$PHP_SELF?id=$r[0]\">$r[1]</a>";
		print "<br>";
	}


      $r[types]+=$this->DrawPart($r[0],$str);


     }
     return($r[types]);
    }


    function Draw($table,$id,$type,$val)
    {
	$this->type=$type;
	$this->val=$val;

	$this->table=$table;
	$this->id=$id;
	$this->DrawPart(0);

    }

}

?>