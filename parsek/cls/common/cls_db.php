<?

class cls_db
{
	var $db;
	var $dbname="nekki-parsek";

	var $dbhost="83.222.14.89";
	var $dbport="3306"; 
	var $dblogin="parsek";
	var $dbpass="parsek";
	var $current=null;

	function cls_db($dbname)
	{
		global $auth;
		if($dbname) $this->dbname=$dbname;
	}

	function connect()
	{
		global $engine_path,$PHP_SELF,$dblink;

		if (!($this->db=mysql_connect($this->dbhost, $this->dblogin, $this->dbpass))){   echo "Error connecting to the database\n";   exit;}
		mysql_select_db ($this->dbname);
                mysql_query("set names cp1251");     
  
//runsql("insert into sql_connections values('$PHP_SELF','0')");

		return $this->db;
	}	


	function __destruct() {
	}


	function close()
	{
		global $engine_path,$PHP_SELF;

//runsql("insert into sql_connections values('$PHP_SELF','1')");
		
		mysql_close($this->db);

		$this->__destruct();
	}

}

//if(is_array($_POST)&&is_array($_GET)) $_POST=array_merge($_POST,$_GET);


function set_params($str)
    {
      global $test,$user,$img_url,$dbname,$site_url,$er,$id,$lang,$auth,$games,$r,$_POST,$_GET,$_GLOBALS,$act,$insertid;

	$str=str_replace("-&gt;","->",$str);
	$str=str_replace("-&gt","->",$str);


	
if(is_array($_POST)&&is_array($_GET)) $_POST=array_merge($_POST,$_GET);
elseif(is_array($_GET)) $_POST=$_GET;

      $st=$str;

      while(strlen($q=strpos($str,"$")))
      {

        $par_name=substr($str,1+$q,strpos($str,";",1+$q)-$q-1);


	if(!strlen($$par_name)) $$par_name=$_GLOBALS[$par_name];

		if(strstr($par_name,"->")) 
		{

			$ob=substr($par_name,0,strpos($par_name,"->"));
			$var=substr($par_name,2+strpos($par_name,"->"));

			$vname=$ob.$var;

			$st=str_replace($par_name,$vname,$st);
			$str=str_replace($par_name,$vname,$str);

			$par_name=$vname;
			if(!$$par_name) $$par_name=${$ob}->$var;

		}
		elseif(strstr($par_name,"message(")) 
		{

			$var=substr($par_name,1+strpos($par_name,"("));
			$var=substr($var,0,strlen($var)-1);
			$$par_name=message($var);
		}
		elseif(strstr($par_name,"image(")) 
		{


			$var=substr($par_name,1+strpos($par_name,"("));
			$var=substr($var,0,strlen($var)-1);

			$vars=explode(",",$var);
			$var=$vars[0];

			$st=str_replace($par_name,"image".$var,$st);
			$str=str_replace($par_name,"image".$var,$str);

			$par_name="image".$var;

			if(!$vars[1]) $$par_name="<img src='$img_url?id=$var&record=12&dbname=$dbname' border=\"0\">";
			else $$par_name="<a href=\"$img_url?id=$var&dbname=$dbname&record=12\" target=_blank><img src='$img_url?id=$var&record=5&dbname=$dbname' border=\"0\"></a>";
		}
		elseif(strstr($par_name,"[")) 
		{

			$ob=substr($par_name,0,strpos($par_name,"["));
			$var=substr($par_name,1+strpos($par_name,"["));
			$var=substr($var,0,strlen($var)-1);


			$st=str_replace($par_name,$var,$st);
			$str=str_replace($par_name,$var,$str);

			$par_name=$var;
			if(!$$par_name) $$par_name=${$ob}[$var];


		}

		else
		{

//print "$_POST['team'] $par_name";

			if($r[$par_name]) $$par_name=$r[$par_name];
			elseif(strlen($_POST[$par_name])) $$par_name=$_POST[$par_name];

			if(!$$par_name&&!strstr($par_name,">")) 
			{

				$p=select("select @$par_name");
				if($p[0]) $$par_name=$p[0];
			}

		        $str=substr($str,1+$q);

			$$par_name=addslashes($$par_name);

			$$par_name=str_replace(";","#dot",$$par_name);

      			$st=  str_replace("\$".$par_name.";",$$par_name,$st);
      			$str= str_replace("\$".$par_name.";",$$par_name,$str);

		}

      }

      $str=$st;

	while(strlen($q=strpos($str,"^")))
	{


		$par_name=substr($str,1+$q,strpos($str,";",1+$q)-$q-1);

		if(strstr($par_name,"(")) 
		{



			$result= myeval($par_name.";");


			if($result) $st= str_replace("^".$par_name.";",$result,$st);

		}

		$str=substr($str,1+$q);
	}

      $str=$st;

      while($q=strpos($str,"@"))
      {


	$pos=strpos($str,";",1+$q);
	if($pos&&(!($pos2=strpos($str,"=",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str,",",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str," ",1+$q))||$pos<$pos2)) 
	{

        	$par_name=substr($str,1+$q,$pos-$q-1);

		if(!$$par_name) $$par_name=$_POST[$par_name];

        	$str=substr($str,1+$q);

        	if(strstr($par_name,"lang"))  $par_val=str_replace("lang",$lang,$par_name);
        	else $par_val=$$par_name;

        	if($par_name) 
		{

			$par_val=str_replace("<", "&lt", $par_val);
			$par_val=str_replace(">", "&gt", $par_val);
//if($test) print "SET @"."$par_name='$par_val'<br>";
			$sql="SET @"."$par_name='$par_val'";
        // print "-".$sql.";<br>" ;
       			 runquery($sql);

		} 

	}
	else  $str=substr($str,1+$q);
      }


     return $st;
    }


function runquery($sql)
    {
	global $Login,$mysqlerror,$insertid;

/*
  	$mtime = microtime();
 	$mtime = explode(" ",$mtime);
  	$mtime = $mtime[1] + $mtime[0];
 	$tstart = $mtime;
*/

	$res= mysql_query($sql);
	$mysqlerror=mysql_error();

/*
  	$mtime = microtime();
  	$mtime = explode(" ",$mtime);
  	$mtime = $mtime[1] + $mtime[0];
  	$tend = $mtime;
  	$tpassed = ($tend - $tstart);
	$time=mktime();
*/

	$sql=addslashes($sql);

	if(substr($sql,0,6)=="insert"&&mysql_insert_id()) {$insertid=mysql_insert_id();mysql_query("set @insertid='$insertid'"); }

//mysql_query("insert into en_sql_statistics values('','$time','$sql','$tpassed')");

	return $res;

    }

function runsql($sql)
    {
	global $mysqlerror;

	if($sql)
	{

		$sql=set_params($sql);
		$sql=str_replace(";","",$sql);
		$sql=str_replace("#dot",";",$sql);



		$res=runquery($sql);


	//print "<b>".$sql.";</b><br><br>";

		if($mysqlerror) 
		{
			print "<b>".$sql."</b><br><font color=red>".$mysqlerror."</font><br>" ; 
			exit;
		}

		return $res;

	}
    }

function simplerunsql($sql)
    {
	global $mysqlerror;

	if($sql)
	{

		$sql=set_params($sql);
		$sql=str_replace(";","",$sql);


		$res=mysql_query($sql);

		if(mysql_error()) 
		{
			print "<b>".$sql."</b><br><font color=red>".mysql_error()."</font><br>" ; 
			exit;
		}
		return $res;
	}
    }

function select($sql)
    {
	if(substr($sql,0,6)!="select") $sql="select ".$sql;
	$res=simplerunsql($sql);


	return mysql_fetch_array($res);
    }

$db=new cls_db($dbname);
$db->connect();

?>