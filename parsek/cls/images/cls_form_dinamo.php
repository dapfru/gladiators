<?

Class cls_form extends cls_root
{
 var $type;
 var $sqlres;

 var $template;

 var $name;
 var $title;
 var $banner;
 var $act; 

 var $table;
 var $php;
 var $image;

 var $items;

 var $sql;
 var $acterror;

 var $action;
 var $select;
 var $display;

 var $success;
 var $error;
 var $wrong;

 var $privacy;

 var $empty;
 var $style;
 var $showlogo;
 var $formwidth;
 var $short;

 var $redirect;
 var $hint;
 var $vip;
 var $undercolor;

 var $method;

 //var $maxwidth;
 //var $maxheight;

/***********************************************************************
                        Инициализация класса
* ***********************************************************************/


function cls_form($type,$tag)
    {
	global $site_path,$engine_path,$site,$idt,$step;

	$this->type=$type;
	$this->name=$tag;

	if(!$type) return false;

	$this->template=xml_contents($engine_path."xml/templates/main.xml");

	$item=xml_contents($site_path."xml/".$site.$type.".xml");

        if(!$item) {print "$site_path"."xml/".$site.$type.".xml not found"; return false;}

	$this->table=$item->getAttribute('table','');
	$this->act=$item->getAttribute('act','');

	$this->image=$item->getAttribute('image','');
	$this->php=$item->getAttribute('php','');

	$this->title=set_params($item->getAttribute('title',''));
	$this->privacy=set_params($item->getAttribute('privacy',''));
	$this->showlogo=set_params($item->getAttribute('showlogo',''));
	$this->formwidth=set_params($item->getAttribute('formwidth',''));
	$this->short=set_params($item->getAttribute('short',''));
	$this->redirect=set_params($item->getAttribute('redirect',''));
	$this->hint=set_params($item->getAttribute('hint',''));
	$this->success=set_params($item->getAttribute('success',''));
	$this->vip=set_params($item->getAttribute('vip',''));

	if(!$tag) $this->name=set_params($item->getAttribute('name',''));
	if(!$this->name) $this->name="select";

	$this->empty=set_params($item->getAttribute('empty',''));
	//if(!$this->empty) $this->empty="Records not found";

	$this->banner=$item->getAttribute('banner','');

	$table = $item->getElementsByTagName($this->name);

	$this->document=$table[0];
	if(!$table[0]) { return false;}

	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
	  if(strlen($v=$table[0]->getAttribute($name,''))) $this->$name=$v;
	 //print $name."=$v<br>";
	}

	if(substr($this->sql,0,6)=="select"&&$this->name!="search"&&$this->act!="search") $this->act="select";
	elseif(!$this->act) $this->act=$this->name;
	
	$this->hint=nl2br($this->hint);
	
	if($this->act=="select") $this->getRows();

	if($site=="moderate/") $this->privacy=2;
	if($site=="admin/") $this->privacy=2;
	if(strstr($site,"admin")) $this->privacy=2;


    }

function getTemplateControl($item)
{

	$item=new cls_controls($item,$this);

	if($item->type=="template"&&$this->template) 
	{

		$table = $this->template->getElementsByTagName($item->name);
		
		$newitem=new cls_controls($table[0],$this);

		if(strlen($item->needed)) $newitem->needed=$item->needed;

		return $newitem;
	}
	else return $item;
}



function getRows()
{
	global $step;




		//$this->sql=$this->limitsql($this->sql);

		$sql="SELECT SQL_CALC_FOUND_ROWS ".substr($this->limitsql($this->sql),6);
	


		if(strstr($this->sql,"@n:=")) {mysql_query("set @n:=$num");}

		$this->sqlres=runsql($sql,$this->name);


		$res=mysql_query("SELECT FOUND_ROWS()");
		$r=mysql_fetch_array($res);	

		$this->numrows=$r[0];


	//}
}

function getTemplateHeader($item)
{

	$item=new cls_header($item,$this);

	if($item->type=="template"&&$this->template) 
	{

		$table = $this->template->getElementsByTagName($item->name);

		$newitem=new cls_header($table[0],$this);

		if(strlen($item->needed)) $newitem->needed=$item->needed;

		return $newitem;
	}
	else return $item;
}


function getfields()
{
		$inner = $this->document->getElementsByTagName("fields");

		$fields = $inner[0]->getElementsByTagName("field");
		return $fields;
}

function set_form_params($str,$i)
    {

	global $search,$site_url,$engine_path,$r,$REMOTE_ADDR,$HTTP_POST_FILES,$HTTP_POST_VARS,$HTTP_GET_VARS,$id,$secpass,$lang,$auth,$er;

	$ndate=0;
	$st=$str;

	if(count($HTTP_GET_VARS)>count($HTTP_POST_VARS)) $HTTP_POST_VARS=$HTTP_GET_VARS;

	if($HTTP_POST_VARS['numrows']) $mult=1;
 
	if(!$HTTP_POST_VARS['Time']) $Time=mktime();
	if(!$HTTP_POST_VARS['Date']) $Date=mktime();
	if(!$HTTP_POST_VARS['IP']) $IP=$REMOTE_ADDR;

	if($this->act=="select")
	{
		$inner = $this->document->getElementsByTagName("header");
		$fields = $inner[0]->getElementsByTagName("item");
	}
	else
	{
		$inner = $this->document->getElementsByTagName("fields");
		$fields = $inner[0]->getElementsByTagName("field");
	}

	foreach($fields as $field)
	{

		$item=$this->getTemplateControl($field);

        	//$name=$field->getAttribute("name","no");

		$name=$item->name;

		if($name=="IP") {$$name=$REMOTE_ADDR;}


		$items[$name]=$item;

		if($item->default&&!$HTTP_POST_VARS[$name]) $HTTP_POST_VARS[$name]=$item->default;
		elseif($item->type=="stringlike") $HTTP_POST_VARS[$name]="%$HTTP_POST_VARS[$name]%";

		if($HTTP_POST_VARS[$name]=="%%") $HTTP_POST_VARS[$name]="%";


		if($mult) 
		{

			$f['name']=$HTTP_POST_FILES[$name]['name'][$i];


			$f['tmp_name']=$HTTP_POST_FILES[$name]['tmp_name'][$i];
			$f['size']=$HTTP_POST_FILES[$name]['size'][$i];
			$f['type']=$HTTP_POST_FILES[$name]['type'][$i];
		}
		else $f=$HTTP_POST_FILES[$name];

		$type=$item->type;


		if(($type=="file"||$type=="image"||$type=="flag")&&$f[name]) 
		{

			$file=fopen($f['tmp_name'],"r");
//print $f[name].$f['tmp_name'];
//exit;
			if(!$file) $er=sysmessage(4)."<br>";

			$fname=$f['tmp_name'];
			$maxsize=$field->getAttribute("maxsize",'');
			$format=$field->getAttribute("format",'');

			if(!strstr($format,strtolower(substr($f['name'],strpos($f['name'],".")+1)))&&$format) $er=sysmessage(5)." .$format!<br>";

			${$name}=fread($file,filesize($fname));


//обработка файлов--------------------
			if($item->type=="file"&&$f[name])
			{

				if(!$id) $q=select("select 1+max(".$name."ID) from ".$this->table);
				else $q[0]=$id;

				$dir="files/".$q[0].".".substr($f['name'],1+strpos($f['name'],"."));
				move_uploaded_file($fname, $engine_path.$dir);
				$$name=$site_url.$dir;
//print $par_val;
//exit;
			}
		}

		if(($type=="flag"||$type=="image")&&$f[name]) 
		{


			$image= new cls_image($f);

			$image->maxsize=$field->getAttribute("maxsize",'');
			$image->mix=$field->getAttribute("mix",'');

			if($width=$field->getAttribute("width",'')) {$image->newWidth=$width; $image->fix="width";}
			if($height=$field->getAttribute("height",'')) {$image->newHeight=$height; $image->fix="height";}

			$image->check();

			${$name} =$image->contents;

			$Type=$image->type;
			$ph[$name]=1;
			$ph['Small']=1;

			if($image->type!="gif") {$Small=new cls_image($image->imageResize()); $Small=$Small->contents; }
			else $Small=${$name};


			$ImageFormat=$image->imtype;
		}
		elseif($type=="date"||$type=="currentdate"||$type=="datetime"||$type=="currentdatetime") {$$name=mktime($HTTP_POST_VARS['hour'][$ndate],$HTTP_POST_VARS['minute'][$ndate],$HTTP_POST_VARS['seconds'][$ndate],$HTTP_POST_VARS['month'][$ndate],$HTTP_POST_VARS['day'][$ndate],$HTTP_POST_VARS['year'][$ndate]); if(($$name==-1)|| !$HTTP_POST_VARS['month'][$ndate] ||!$HTTP_POST_VARS['day'][$ndate] ||!$HTTP_POST_VARS['year'][$ndate]) unset($$name); $ndate++; }
		elseif($type=="sqldate") {$$name=($HTTP_POST_VARS['year'][$ndate]."-".$HTTP_POST_VARS['month'][$ndate]."-".$HTTP_POST_VARS['day'][$ndate]); if(($$name==-1)|| !$HTTP_POST_VARS['month'][$ndate] ||!$HTTP_POST_VARS['day'][$ndate] ||!$HTTP_POST_VARS['year'][$ndate]) unset($$name); $ndate++; }

		if(($type=="url"||$name=="url")&&$$name&&!strstr($$name,"http://")) $$name="http://".$$name;
	}




      while($q=strpos($str,"$"))
      {

        $par_name=substr($str,1+$q,strpos($str,";",1+$q)-$q-1);

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

			if($r[$par_name]) $$par_name=$r[$par_name];
			elseif($HTTP_POST_VARS[$par_name]) $$par_name=$HTTP_POST_VARS[$par_name];



			if(!$$par_name&&!strstr($par_name,">")) 
			{

				$p=select("select @$par_name");
				if($p[0]) $$par_name=$p[0];
			}


			if(is_Array($$par_name)) 
			{
				$parval=$$par_name;
				$$par_name=$parval[$i];
			}

		        $str=substr($str,1+$q);
      			$st=  str_replace("\$".$par_name.";",$$par_name,$st);
      			$str= str_replace("\$".$par_name.";",$$par_name,$str);
		}

      }

	$str=$st;

	$w=0;

	while($q=strpos($str,"@"))
	{

		//отсекаем до ;

		$pos=strpos($str,";",1+$q);
		if($pos&&(!($pos2=strpos($str,"=",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str,",",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str," ",1+$q))||$pos<$pos2)) 
		{

		$par_name=substr($str,1+$q,$pos-$q-1);
		$str=substr($str,1+$q);


		$item=$items[$par_name];


		if($item->unique&&$mult)
		{
			foreach($HTTP_POST_VARS[$par_name] as $val)
			{
				if($ar[$val]) $er.=sysmessage(6)." $item->caption=$val ".sysmessage(7)."!<br>";
				else $ar[$val]=1;
			}
		}

		if(!$$par_name&&is_Array($HTTP_POST_VARS[$par_name])) $par_val=$HTTP_POST_VARS[$par_name][$i];
		elseif(!$$par_name) $par_val=$HTTP_POST_VARS[$par_name];
		else $par_val=$$par_name;



		$error=$er;

		if($item->type=="email") $item->preg="/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/";

		if($item->preg&&$par_val&&!preg_match( $item->preg, $par_val )) $er.=sysmessage(8)." $item->caption<br>";
		if(strlen($par_val)==0&&$item->needed) $er.=sysmessage(9)." $item->caption<br>"; 

		if($par_val&&$item->maxlength&&(strlen($par_val)>$item->maxlength)) $er.=sysmessage(10)." $item->caption ".sysmessage(11)." $item->maxlength"; 
		if($par_val&&$item->minlength&&(strlen($par_val)<$item->minlength)) $er.=sysmessage(10)." $item->caption ".sysmessage(12)." $item->minlength"; 

		if(strlen($par_val)&&strlen($item->max)&&($par_val>$item->max)) $er= sysmessage(6)." $item->caption ".sysmessage(13)." $item->max<br>"; 

		if(strlen($par_val)&&strlen($item->min)&&($par_val<$item->min)) $er= sysmessage(6)." $item->caption ".sysmessage(14)." $item->min<br>"; 


		if($er!=$error) {$this->wrong[$w]=$par_name; $w++;}


		if($par_name) 
		{

			if($item->type!="file"&&$item->type!="flag"&&$item->type!="image"&&$par_name!="Small")
			{
				$par_val=str_replace("<", "&lt;", $par_val);
				$par_val=str_replace(">", "&gt;", $par_val);

				//if($item->type=="numeric") $par_val=intval($par_val);

				if($item->type=="text"||$item->type=="editor"||$item->type=="string") $search.=strip_tags($par_val)." ";


				if($item->type=="text"||$item->type=="editor") 
				{

					if($item->type!="editor") {$par_val=str_replace("\r\n","<br />",$par_val);
					$par_val=mysql_real_escape_string($par_val);}

					$par_val=stripslashes($par_val);



				}
				else
				{
					
					$par_val=mysql_real_escape_string($par_val);
					$par_val=stripslashes($par_val);
				}

			$par_val=stripslashes($par_val);

			}





			$par_val=addslashes($par_val);

			$sql="SET @"."$par_name='$par_val'";



			mysql_query($sql);
//print substr($sql,0,1000)."<br>";
		} 

		$par_val=stripslashes($par_val);


//$a=$par_val;
		if($item->unique&&$par_val&&!$mult)
		{

			$sql="select * from $this->table where $par_name='$par_val' and $item->unique";

			if($this->select) 
			{
				$sq.=" and ".str_replace("=","<>",substr($this->select,strpos($this->select,"where ")+6));

				while(strstr($sq,"."))
				{
					$sq=substr($sq,0,strpos($sq,".")-1).substr($sq,1+strpos($sq,"."));
				}

				$sql.=$sq;
			}

			$res=runsql($sql,$this->name);

			if(mysql_num_rows($res)) $er.=sysmessage(3)." $item->caption=$par_val<br>";

		}

		}
		else $str=substr($str,1+$q);



//if($a!=$par_val) print "$par_name изменился<br>";
      }



	return $st;
    }


function runsql($noprint)
    {
	global $id,$search,$er,$lang,$HTTP_POST_VARS,$insertid,$r;

	if(!$this->checkPermission(1)) return 0;

	if($this->sql)
	{

	if(!$numrows=$HTTP_POST_VARS['numrows']) $numrows=1;

	for($i=0;$i<$numrows;$i++)
	{
		if($this->act!="select") $sql= $this->sql;
		else  $sql= $this->action;


			$sqlar=explode("#",$sql);

                	foreach($sqlar as $sql)
			{

				$l=substr($sql,0,1);
				if($l=="^") {
					eval($this->set_form_params(substr($sql,1),$i));
				}
				else
				{

		if($this->name!="delete"&&$this->name!="create"&&$this->name!="drop") $sql=$this->set_form_params($sql,$i);
		else $sql=set_params($sql);

		if($er) 
		{
			break;
		}
		else
		{


				if(strstr($sql,"insert")) $c=1;

				if($res=runquery(str_replace(";","",$sql))) {$str= set_params($this->success); unset($HTTP_POST_VARS);}
				else 
				{
					$er.= "<font color=black>Error<br> ".str_replace(";","",$sql)." <br></font>".mysql_error(); 
				}

		if(substr($sql,0,6)=="select") {$r=mysql_fetch_array($res); }

		//print "$sql<br><font color=red>".mysql_error()."</font><br>";

		if($num=mysql_insert_id()) {$insertid=$num;mysql_query("set @insertid='$insertid'"); }


		if(substr($sql,0,6)=="insert") $insertid=mysql_insert_id();


		$res=mysql_query("select @error");

		$r1=mysql_fetch_array($res);

			if($r1[0]) 
			{
				if(strstr($r1[0],"#"))
				{
					if(substr($r1[0],strlen($r1[0])-1,1)=="#") $r1[0]=substr($r1[0],0,strlen($r1[0])-1);
					$ar=explode("#",$r1[0]);
					foreach($ar as $a)
					{
						$er.=message($a)."<br>";
					}
				}
				else
				$er.=message($r1[0]);

				break;
			}

//поиск----------------------------------
			if($this->act=="insert"||substr($sql,0,6)=="insert")
			{
				$q=select("select SearchID from en_search where TableName='$this->table'");

				if($q[0]&&$search)
				{
					$insert=select("@insertid");
					$search=str_replace("\n\r"," ",$search);
					$search=str_replace("ё","е",$search);

					$search=downstr(addslashes($search));
					$ar=explode(" ",$search);
					$position=1;
					foreach($ar as $word)
					{
						if($word) 
						{
							mysql_query("insert into en_searchindex values('$word','$q[0]','$insert[0]','$position')");
							$position++;
						}
					}
				}

				unset($search);
			}


			if($this->act=="update"||substr($sql,0,6)=="update")
			{


				$q=select("select SearchID from en_search where TableName='$this->table'");

				if($q[0]&&$search)
				{

					mysql_query("delete from en_searchindex where SearchID='$q[0]' and RecordID='$id'");

					$search=str_replace("\n\r"," ",$search);
					$search=str_replace("ё","е",$search);

					$search=cut_end_word(downstr(addslashes($search)));

					$ar=explode(" ",$search);
					$position=1;
					foreach($ar as $word)
					{
						if($word) 
						{
							mysql_query("insert into en_searchindex values('$word','$q[0]','$id','$position')");
							$position++;
						}
					}
				}

				unset($search);
			}
//поиск-----------------------------------

		}

				}
			}

		if($er) break;
	}
//exit;
	if($er) $retstr=icon('error',"<font color=red>$er</font>")."<br>";
	elseif($str) $retstr=icon('ok',"$str")."<br>";
	else $retstr="";

	if(!$noprint) print $retstr;
	else return $retstr;

	}

    }


function DrawHeader()
    {
	global $id,$PHP_SELF,$where,$firstpage,$QUERY_STRING;

	if(!$this->document) return false;

	$header = $this->document->getElementsByTagName("header");

	if($header[0]) $this->style=$header[0]->getAttribute("style",'');


	if(!$header[0]&&$this->act=="select") return false;

	print $header[0]->text;

	$act=$this->name;

	$buttons = $this->document->getElementsByTagName("button");
	if($buttons[0])
	{
		if($buttons[0]->getAttribute("act",'')) $act=($buttons[0]->getAttribute("act",''));
	}


	$action="$PHP_SELF?type=$this->type&act=$act";

	if($this->document->getElementsByTagName("button")) 
	{

		$method="post";
		if($this->act=="search") $method="get";
		if($this->method) $method=$this->method;

		print "\n<form name=\"$this->name\" method=\"$method\" ";

//например переход на WM
		if($this->action&&strstr($this->action,"http:")) $action=$this->action;
		else print "enctype=\"multipart/form-data\"";

		if(!$firstpage) $firstpage=$PHP_SELF."?".$QUERY_STRING;

		print " action=\"$action\">

		<input type=\"hidden\" name=\"step\" value=\"1\">
		<input type=\"hidden\" name=\"type\" value=\"$this->type\">

		<input type=\"hidden\" name=\"firstpage\" value=\"$firstpage\">

		<input type=\"hidden\" name=\"act\" value=\"".$this->name."\">";
	}
	//передаем дальше параметр $id--------------
	if($id) print "<input type=\"hidden\" name=\"id\" value=\"$id\">\n";


	if($this->act=="select")
	{

		//подсчитываем число записей в SQL запросе--------------



		if($this->numrows>0)
		{
               		$cnum=0;

			print "<tr bgcolor=".$this->hcolor." ";

			print "  align=\"center\" class=\"header\">\n";

			print "<input type=\"hidden\" name=\"numrows\" id=\"numrows\" value=\"$this->numrows\">";

			$items = $header[0]->getElementsByTagName("item");
			foreach($items as $item)
			{

				$this->items[$cnum]=$this->getTemplateHeader($item);


				if($this->items[$cnum]->type!="hidden"&&!($colspan>1)) $this->items[$cnum]->Draw();
				
				if($colspan) $colspan--;

				if($this->items[$cnum]->colspan>1) $colspan=$this->items[$cnum]->colspan;


		 		//if($this->items[$cnum]->type!="hidden")
				$cnum++;
			}
			print "</tr>\n";
       		}

	}

	return $cnum;

    }

function limitsql($sql)
    {
	global $page,$sort;

	if(!$page) $pag=1;
	else $pag=$page;

	if($sort)
	{
	  if(!strstr($sql,"order")) $sql.=" order by $sort";
	  else $sql=substr($sql,0,strpos($sql,"order"))." order by $sort";
	}

	$num=(($pag-1)*$this->pagecount);
	if($this->pagecount&&!strstr($sql,"limit")) $sql.=" limit $num,$this->pagecount";


	return $sql;
    }

function Browse()
    {
 	global $number,$HTTP_POST_VARS,$site,$page,$num,$sort,$st,$lang,$cnum,$r,$noedit;




	$number=0;
	$res=$this->sqlres;


	if(!mysql_num_rows($res)) print "<tr><td bgcolor=ffffff>".$this->empty."</td></tr>";

	if(!$this->numrows) $this->numrows=mysql_num_rows($res);

	while($r=mysql_fetch_array($res))
	{

		$numrow++;

		$HTTP_POST_VARS['numrow']=$numrow;


		if($color!=$this->rowcolor) $color=$this->rowcolor;
		elseif($this->mixcolor)  $color=$this->mixcolor;

		print "<tr bgcolor=".$color." ";

		if($this->style) print set_params($this->style);

		print ">";

		foreach($this->items as $item)
		{ 
			$item->DrawRow($r,$numrow);
			if($item->count) {
				$count[$item->name]+=$item->val; 
				if($item->val!=0) $c[$item->name]++; 
			}
			elseif(!$numcols) $cols++;
		}


		print "</tr>";
			

	}

		if(count($count))
		{
			print "<tr class=header>";


			foreach($this->items as $item)
			{ 

				print "<td>";

				if($item->align=="center") print "<center>";
				elseif($item->align) print "<div align=\"$item->align\">";

				if($item->count=="avg") { 
					$num=($count[$item->name]/$c[$item->name]); 
					if($num>1000) $round=0;
					else $round=1;
					print dots(round($num,$round));
				}
				elseif($item->count=="sum") print dots(($count[$item->name]));
				elseif($item->count=="cnt") print $c[$item->name];

				print "</td>";

			}

			print "</tr>";
		}

	$this->Pages($cnum+2);
    }


function checkPermission($step)
    {
	global $auth,$site_url,$site;

	if($this->vip&&!($auth->rang>=$this->vip)) 
	{ 
		if($this->vip==1) print icon("vip",message(196)); 
		elseif($this->vip==2) print icon("vip",message(197)); 
		elseif($this->vip==3) print icon("vip",message(198)); 
		if(!$step||$this->name=="vip") print "<br>";

		if($step) return 0;
	}

	if($this->privacy==1&&!$auth->team) 
	{ 
		print icon("error","<center>".sysmessage(16)."<br><a href=\"$site_url"."xml/office/free.php\">".message(55)."</a></center>"); 
		return 0;
	}

	if($this->privacy==2) 
	{ 
		if(!strstr($site,"dinamo")) $r=select("select PermissionID from en_permissions where (Type='$this->type' or Type='*') and (Name='' or Name='$this->name') and (UserID='$auth->user' or TypeID in (select p.TypeID from ut_posts p where p.TypeID=TypeID and p.UserID='$auth->user'))");
		else  $r=select("select PermissionID from en_permissions where (Type='$this->type' or Type='*') and (Name='' or Name='$this->name') and (UserID='$auth->user')");

		if(!$r[0]) 
		{
			print icon("error","У Вас нет прав для просмотра этой страницы"); 
			return 0;
		}
	}

	return 1;
    }

//рисуем форму------------------------------
function Draw()
    {


	global $cnum,$act,$auth,$lang,$id,$r,$type,$num,$cnum,$engine_path,$site,$form_ok;

	if(!$this->document) {print "XML error"; return 0;}

	if($act=="search"&&$act!=$this->name) $step=1;

	if(!$this->checkPermission($step)) return 0;
	
	if($this->act=="select"&&!$this->numrows)
	{
		if($this->empty) print icon('green',$this->empty);
		return 0;
	}


	//выбираем данные для заполнения-----------
	if($this->select) $r=select($this->select);
	if(!$r[0]&&$this->error) 
	{
		if(!$form_ok) print icon('error',$this->error);
		return 0;
	}


	$this->Header();


	$cnum=$this->DrawHeader();

	if(!$cnum) $cnum=2;

	$this->DrawFields();

	$this->DrawButton($cnum);

        $this->Footer();

	unset($num);
    }


function DrawFields()
    {
	global $cnum,$r,$step,$er;
	if($this->act!="select")
	{



		if(!$this->document) {print "XML error $this->type,$this->name";return false;}

		$inner = $this->document->getElementsByTagName("fields");

		if(!$inner[0]) return false;

		if(strlen($inner[0]->text)) print $inner[0]->text;

		$fields = $inner[0]->getElementsByTagName("field");

		//рисуем поля------------------------------
		foreach($fields as $field)
		{


			if($control&&$control->type!="hidden"&&$color!=$this->rowcolor||!$control) $color=$this->rowcolor;
			elseif($control&&$control->type!="hidden"&&$this->mixcolor)  $color=$this->mixcolor;

			$control=$this->getTemplateControl($field);


			$control->table->rowcolor=$color;

	 		$control->Draw(1);


		}

	}
	elseif($this->act=="select") $this->Browse();
    }

function DrawButton($cnum)
    {
	global $firstpage;


	if(($buttons = $this->document->getElementsByTagName("button"))&&($this->act!="select"||$this->numrows>0)) 
	{

		print "<input type=\"hidden\" name=\"oldact\" value=\"$this->name\">\n";


		print "<tr bgcolor=".$this->hcolor."  class=\"header\"><td colspan=$cnum>\n";

		$type="submit";

			foreach($buttons as $button)
			{

				print  $button->text;

				if($newact=($button->getAttribute("act",''))) print "<input type=\"hidden\" name=\"act\" value=\"$newact\">\n";

				$name=$button->getAttribute("name",'');
				if($typ=$button->getAttribute("type",'')) $type=$typ;
				$format=$button->getAttribute("format",'');


				if(!$type) $type="button";

				if($align=$button->getAttribute("align",'')) print "<div align=\"$align\">\n";

				if($type=="submit") $format.=" onclick=\"this.disabled = true; this.className='disabledbutton'; this.form.submit();\" ";

				if($type=="return") {$type="button"; $format.=" onclick=\"location='$firstpage'\" ";}
				

				print "<input type=\"$type\" value=\"$name\" class=\"button\" $format> ";
				unset($type);

			}

		print "</td></tr>\n";
	}
    }

function DrawImage()
    {
	global $er,$form_ok;

	if(!$this->document) return 0;

	if(!$er&&!$form_ok&&$this->image) print "<center><img src=\"$this->image\"></center><hr>\n";
    }

}


Class cls_controls 
{
 var $name;
 var $table;
 var $caption;
 var $type;

 var $needed;
 var $unique;

 var $maxlength;
 var $minlength;
 var $max;
 var $min;

 var $maxyear;
 var $minyear;

 var $sql;
 var $action;

 var $val;
 var $text;
 var $button;
 var $default;

 var $format;

 var $preg;

 var $cols=40;
 var $rows=4;

 var $size=20;
 var $vars;
 var $vals;

 var $colspan;
 var $align;
 var $icon;

 var $tdstyle;
 var $nobr;


/***********************************************************************
                        Инициализация класса
* ***********************************************************************/



function cls_controls($field,$table)
    {
      global $lang;

	$this->table=$table;

	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
		if($name=="vars") $nam=$name."_$lang";
		else $nam=$name;

		if(strlen($v=$field->getAttribute($nam,''))) $this->$name=$v;

	 //print $name."=$v<br>";
	}

	$this->type=set_params($this->type);

	if(!$this->caption) $this->caption=$this->name;

	$this->name=$field->getAttribute("name","no");

	if(!$this->name) $this->name=$field->getAttribute("name","eng");

	$this->text=$field->text;


    }

function Draw($drawTable,$form)
    {
	global $img_url,$HTTP_GET_VARS,$ndate,$r,$id,$HTTP_POST_VARS,$db,$gd,$lang,$_GLOBALS,$dbname,$day,$month,$year;

	if(count($HTTP_GET_VARS)>count($HTTP_POST_VARS)) $HTTP_POST_VARS=$HTTP_GET_VARS;

	if(!$form) $form=$this->table;
	if(!$ndate) $ndate=0;

	$this->text=set_params($this->text);

	if(strlen($this->text)) $this->val=$this->text;

	if(strlen($r[$this->name])) $this->val=$r[$this->name]; 

	if($_GLOBALS[$this->name]&&!$this->val) $this->val=$_GLOBALS[$this->name];

	if($HTTP_POST_VARS[$this->name]&&$this->name!="act"&&!$this->val) $this->val=$HTTP_POST_VARS[$this->name];

	if($this->sql&&($this->type!="sqlist")&&($this->type!="sqllabel"))
	{
		$res=runsql($this->sql);
		$r1=mysql_fetch_array($res);

		$this->val=$r1[0];
		$HTTP_POST_VARS[$this->name]=$this->val;
	}

	if(!$this->val&&$this->table->short&&$this->type!="list"&&$this->type!="sqlist") $this->type="hidden";

	//$this->val=stripslashes($this->val);

	if($this->type!="hidden")
	{
		if($drawTable)
		{

			print "<tr bgcolor=".$form->rowcolor.">";

			print "<td valign=top";
			if($this->colspan>1) print " colspan=".$this->colspan;
			if($this->tdstyle) print " ".$this->tdstyle;
			print ">";

	 	if($this->nobr) print "<nobr>";

		if($this->align =="center") print "<center>";

         	if($this->needed) print "<b>";
		
		if(in_array($this->name,$form->wrong)) print "<font color=red>";

        	if(!$this->align || $this->align =="right"|| $this->align =="center") print $this->caption;

		}
		if($drawTable)
		{
			if(!($this->colspan>1)) 
			{
				print "</td>";

				if($this->icon) print "<td><center><img src=\"$this->icon\"></td>";

				print "<td ";

				if($this->table->width) print "width=".$this->table->width;

				print ">";
			}
		}
	}

	if($this->val=="%") unset($this->val);

	if($this->type=="currentdate"||$this->type=="currentdatetime")
	{
		$day[$ndate]=round(date('d',mktime()));
		$month[$ndate]=round(date('m',mktime()));
		$year[$ndate]=round(date('Y',mktime()));

		$hour[$ndate]=round(date('H',mktime()));
		$minute[$ndate]=round(date('i',mktime()));

		$this->type="date";
	}

	if($this->type=="datetime")
	{
		$this->type="date";
		$en_datetime=1;
	}
	else $en_datetime=0;

	if($this->type=="sqldate")
	{



		if($this->val) 
		{

			$ar=explode("-",$this->val);
			$day[$ndate]=$ar[2];
			$month[$ndate]=$ar[1];
			$year[$ndate]=$ar[0];

		}	
		
		$this->type="date";
	}

	if($this->type!="editor") $this->val=str_replace("\"","&quot;",$this->val);

	$this->val=str_replace("&gt;",">",$this->val);
	$this->val=str_replace("&lt;","<",$this->val);


	switch($this->type)
	{

		case "string":
		case "email":
		case "url":
		case "stringlike":
			print "<input $this->format name=\"".$this->name."\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' size=\"".$this->size."\" type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" $this->format>";
		break;

		case "secret":

			if(!$code=$HTTP_POST_VARS['SecretCode']) $code=mktime();
			print "<input type=\"hidden\" name=\"SecretCode\" value=\"".$code."\">";
			print " <img src=\"http://www.frela23.ru/test/izobrnew.php?id=$code\" border=1>";
			print "<br><input $this->format name=\"".$this->name."\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' size=\"".$this->size."\" type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" $this->format>";
		break;

		case "password":
			if(strlen($this->val)==32) unset($this->val);
			print "<input onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."\" size=\"".$this->size."\" type=\"password\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\">";
		break;


		case "datelabel":

			//if(strlen($this->val)>0) {$day=date("d",$this->val);$month=date("m",$this->val);$year=date("Y",$this->val);}
			//else
			//{
			//	unset($day);
			//	unset($month);
			//	unset($year);
			//}

			if(!$this->format) $this->format="d.m.Y";
			if($this->val) print date($this->format,$this->val);


		break;

		case "sqldatelabel":

			$ar=explode("-",$this->val);
			$day[$ndate]=$ar[2];
			$month[$ndate]=$ar[1];
			$year[$ndate]=$ar[0];

			if($day[$ndate]&&$day[$ndate]!="00") print "$day[$ndate].$month[$ndate].$year[$ndate]";


		break;
		case "date":

			$day=$day[$ndate];
			$month=$month[$ndate];
			$year=$year[$ndate];
			$hour=$hour[$ndate];
			$minute=$minute[$ndate];

			$ndate++;

			if(!strlen($day)&&strlen($this->val)>1) 
			{

				$day=date("d",$this->val);
				$month=date("m",$this->val);
				$year=date("Y",$this->val);

				$hour=date("H",$this->val);
				$minute=date("i",$this->val);
			}
			
			if(!$day&&$this->maxyear) $day=1;
			
			$strday= "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"day[]\"><option value=\"\"></option>";

			for($i=1;$i<=31;$i++)
			{
				$strday.= "<option value=\"$i\"";
				if($i==$day) $strday.= " selected";
				$strday.= ">$i</option>";
			}

			$strday.= "</select>";

			$strmonth= "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"month[]\">";

			$months['rus']=array('месяц','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
			$months['eng']=array('Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

			$i=0;
			foreach($months[$lang] as $m)
			{
				$strmonth.= "<option value=\"$i\"";
				if($i==$month) $strmonth.= " selected";
				$strmonth.= ">$m</option>";
				$i++;
			}

			$strmonth.="</select>";

			$stryear="<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"year[]\"><option value=\"\"></option>";

			if(!$maxyear=$this->maxyear) $maxyear=date("Y",mktime())+1;
			if(!$minyear=$this->minyear) $minyear=1930;

			for($i=$maxyear;$i>=$minyear;$i--)
			{
				$stryear.= "<option value=\"$i\"";
				if($i==$year) $stryear.= " selected";
				$stryear.= ">$i</option>";
			}

			$stryear.="</select>";


			if($lang=="eng") print "$strmonth $strday $stryear";
			else print "$strday $strmonth $stryear";

			if($en_datetime) print " <input type=\"text\" onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" name=\"hour[]\" size=2 maxlength=2 value=\"$hour\">:<input type=\"text\" onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" name=\"minute[]\" size=2 maxlength=2 value=\"$minute\">";
		break;

		case "numeric":
			if($this->size==20) $this->size=3;
			print "<input $this->format name=\"".$this->name."\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format>";
		break;

		case "between":
			if($this->size==20) $this->size=3;

			$n1=$this->name."_1";
			$val1=$HTTP_POST_VARS[$n1];

			$n1=$this->name."_sign1";
			$sval1=$HTTP_POST_VARS[$n1];

			$n2=$this->name."_2";
			$val2=$HTTP_POST_VARS[$n2];

			$n2=$this->name."_sign2";
			$sval2=$HTTP_POST_VARS[$n2];


			$ar=array("=","&gt;","&lt;","&lt;&gt;","&gt;=","&lt;=");

				$sval1=str_replace("<", "&lt;",$sval1);
				$sval1=str_replace(">", "&gt;", $sval1);

				$sval2=str_replace("<", "&lt;",$sval2);
				$sval2=str_replace(">", "&gt;", $sval2);

			print " <select name=\"".$this->name."_sign1\">";

			foreach($ar as $a)
			{

				print "<option value=\"$a\"";
				if("$a"=="$sval1") print " selected";
				print ">$a</option>";
			}


			print "</select>";

			print "<input $this->format name=\"".$this->name."_1\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$val1."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format> ";

			print sysmessage(15);


			print " <select name=\"".$this->name."_sign2\">";

			foreach($ar as $a)
			{
				print "<option value=\"$a\"";
				if($a==$sval2) print " selected";
				print ">$a</option>";
			}


			print "</select>";

			print " <input $this->format name=\"".$this->name."_2\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$val2."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format>";

		break;

		case "text":
			print "<textarea $this->format name=\"".$this->name."\" cols=\"".$this->cols."\" rows=\"".$this->rows."\" maxlength=\"".$this->maxlength."\">".str_replace("<br />","\r\n",$this->val)."</textarea>";
		break;


		case "editor":
			require_once($engine_path."cls/editor/fckeditor.php") ;
			$oFCKeditor = new FCKeditor($this->name) ;


			$oFCKeditor->ToolbarSet = 'Basic' ;
			if($this->format) $oFCKeditor->ToolbarSet = $this->format ;

			if(!$this->height) $oFCKeditor->Height = 400 ;
			else $oFCKeditor->Height = $this->height ;

			$oFCKeditor->Value = $this->val;
			$oFCKeditor->Create() ;

		break;

		case "radio":

			if($this->format) $vals=explode(";",$this->format);

			$ar=explode(";",$this->vars);
			$n=0;
			$i=0;

			foreach($ar as $v)
			{

				print "<input name=\"".$this->name."\" type=\"radio\" ".$this->action." ";

				if($vals[$i]) $val=$vals[$i]; 
				else $val=$n; 

				print " value=\"".$val."\"";

                       		if(($this->default!="0"||($this->val==$val&&$val))&&($this->val==$val||$r[$this->name]==$n||($this->text==$v&&!$r[$this->name]))) print " checked";
				print ">$v<br>";
				$n++; 
				$i++;
			}
		break;

		case "list":

         	        print "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' $this->format name=\"".$this->name."\">";

			if($this->vals) $vals=explode(";",$this->vals);

			if(!strlen($this->text)) 
			{
				print "<option value=\"$this->default\">-</option>";
				$n=1;
			}
			else $n=0;

			$ar=explode(";",$this->vars);

			if(!$this->vars) $ar=$_GLOBALS[$this->default];

			$i=0;
			foreach($ar as $v)
			{

				if(strlen($vals[$i])) $var=$vals[$i];
				else $var=$n;

				print "<option value=\"$var\"";

				if($this->val==$var) print " selected";
            			elseif(!$this->val&&($this->text=="$var"||($this->text==$v&&!$r[$this->name]))) print " selected";

//!$this->val&&($var==$r[$this->name]&&$r[$this->name]||$this->text=="$var"||($this->text==$v&&!$r[$this->name]))

            			print ">$v</option>";
				$n++; 
				$i++;
			}

			print "</select>";
		break;

		case "urllabel":
			if($this->val&&!strstr($this->val,"http://")) $this->val="http://".$this->val;

			if($this->val&&$this->val!="http://") print "<a href=\"$this->val\">$this->val</a>";
		break;

		case "emaillabel":
			if($this->val) print "<a href=\"mailto:$this->val\">$this->val</a>";
		break;

		case "icqlabel":
			$icq=str_replace("-","",$this->val);
			$icq=str_replace(" ","",$icq);
			if($this->val) print "<img src=\"http://status.icq.com/online.gif?icq=$icq&img=5\" height=18px width=18px> ";
			if($this->val) print "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$icq\">".$this->val."</a>";
		break;

		case "listlabel":
			$ar=explode(";",$this->vars);

			if(!$this->vars) $ar=$_GLOBALS[$this->default];

			$i=0;
			print $ar[$this->val];

		break;

		case "sqllabel":
         		$res=runsql($this->sql);
         		while($r1=mysql_fetch_array($res))
          		{

				if("$this->val"==$r1[0]) print "$r1[1]";

				$n++;
         		}
		break;

		case "sqlist":

         		print "<select $this->format name=\"".$this->name."\">";

         		$res=runsql($this->sql);

        		print "<option value=\"$this->default\">-";

         		print "</option>";

	 		$n=1;

         		while($r1=mysql_fetch_array($res))
          		{
				$n="Name_".$lang;
				if(!$r1[$n]) $n="Name_rus";
				if(!$r1[$n]) $n=1;
				print "<option value=\"$r1[0]\"";

				if($r1[2]) print " style='background-color:$r1[2]' ";				
				if("$this->val"==$r1[0]||("$this->val"==$r1[$n])) print " selected";

				print ">$r1[$n]</option>";
				$n++;
         		}
        		print "</select>";
		break;

		case "sqlradio":


         		$res=runsql($this->sql);


	 		$n=1;

         		while($r1=mysql_fetch_array($res))
          		{
				$n="Name_".$lang;
				if(!$r1[$n]) $n="Name_rus";
				if(!$r1[$n]) $n=1;
//print $this->name."($this->val==$r1[0]&&$this->val)||".$r[$this->name]."==$r1[0]||(($this->text==$r1[1]||$this->text==$n)&&!".$r[$this->name].")";
				print "<input name=\"".$this->name."\" type=\"radio\"  value=\"".$r1[0]."\"";
				if(($this->val==$r1[0]&&$this->val)||$r[$this->name]==$r1[0]||(($this->text==$r1[1]||$this->text=="$n")&&!$r[$this->name])) print " checked";
				print ">$r1[$n]<br>";

				$n++;
         		}

		break;

		case "checkbox":
			print "<input $this->format type=\"checkbox\" value=\"1\" name=\"".$this->name."\"";
			if($this->val) print " checked";
			print ">";
		break;

		case "image":

			if(strlen($r[$this->name])>0) print "<img src=\"$img_url?id=$r[0]&table=$form->table&dbname=$dbname\" border=0><br>";
			print "<input type=\"file\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."\">";
		break;


		case "flag":
			if(strlen($r[$this->name])>0) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[0]&dbname=$db->dbname\" title=\"$r[Country]\" border=0><br>";
			print "<input type=\"file\" name=\"".$this->name."\">";
		break;

		case "clear":
			print $this->val.$this->format;
		break;

          	case "label":
			$this->val=stripslashes($this->val);
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\">";
               		print "<span $this->format>$this->val</span>";
          	break;

		case "dots":
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\">";
			print dots($this->val).$this->format;
		break;
		case "money":
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\">";
			print dots($this->val).$gd;
		break;

		default:
			print "<input name=\"".$this->name."\" type=\"".$this->type."\" value=\"".$this->val."\" $this->format>";
		break;
	 }

	if($this->align =="left") print $this->caption;

	if($drawTable)	
	{
		print "</td>\n";
		if($this->table->undercolor&&$this->type!="hidden") print "<tr height=\"1px\"><td colspan=2 height=\"1px\" bgcolor=".$this->table->undercolor."></td></tr>";
		print "</tr>\n";
	}
        
    }
}



Class cls_header
{
 var $form;
 var $name;
 var $caption;
 var $lang;
 var $type;
 var $format;
 var $type;
 var $action;
 var $table;
 var $order;
 var $align;
 var $width;
 var $background;
 var $val;
 var $size;
 var $min;
 var $max;
 var $sql;
 var $default;
 var $vars;
 var $text;
 var $colspan;
 var $count;
 var $tdstyle;
 var $style;
 var $title;
/***********************************************************************
                        Инициализация класса
* ***********************************************************************/



function cls_header($field,$table)
    {
      global $lang,$r;

	$this->table=$table;
	//$this->type=$table->type;

	if($table->document->getElementsByTagName("button")) $this->form=1;


	if($pos=strpos($table->sql,"order by"))
	{
		$order=substr($table->sql,$pos+9);
		if($order==$this->name) 
		{
			$this->order=$order;
			if(strstr($this->order,"asc")) $this->order=str_replace("asc","desc",$this->order);
			elseif(!strstr($this->order,"desc")) $this->order.=" desc";
		}
	}

	$this->action=$table->name;


	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
		if($name=="vars") $nam=$name."_$lang";
		else $nam=$name;

		if(strlen($v=$field->getAttribute($nam,''))) $this->$name=$v;
//print "$name $v <br>";
	
	}


	$this->type=set_params($this->type);


	$this->text=$field->text;

	if(!$this->caption) $this->caption=$this->name;

	//if($this->text) $this->caption=$this->text;

	$this->name=$field->getAttribute("name","no");

	if(!$this->name) $this->name=$field->getAttribute("name","eng");

	if($this->lang) $this->name.="_$lang";

	if(!$this->order) $this->order=set_params($this->name);

	$this->name=set_params($this->name);
	$this->caption=set_params($this->caption);

	if($table->numrows>$table->pagecount) $table->numrows=$table->pagecount;



    }

function Draw()
    {
	global $st,$sort,$act,$r,$QUERY_STRING;

	$table=$this->table;

	print "<td ";

	if($this->colspan>1) print "colspan=$this->colspan ";
	if($this->width) print "width=$this->width ";

	if($table->headerbg) print "background=\"$table->headerbg\" ";

	print ">";
	if($sort!=$this->order." desc"&&$sort!=$this->order." asc"&&$sort!=$this->order) $srt=$this->order;
	else
	{
		if(strstr($sort,"desc")) {$srt=str_replace("desc","asc",$sort);}
		elseif(strstr($sort,"asc")) {$srt=str_replace("asc","desc",$sort);}
		else 
		{
			$srt=$sort." desc";
		}
	}

	$table=$this->table;

	if($table->act=="select"&&$this->order!="no") { print "<a href=\"$PHP_SELF?";



	if($QUERY_STRING) 
	{
		if($pos=strpos($QUERY_STRING,"sort")) $QUERY_STRING=substr($QUERY_STRING,0,$pos-1);
		print $QUERY_STRING;
		if(!strstr($QUERY_STRING,"type")) print "&type=".$this->table->type;
		if(!strstr($QUERY_STRING,"act")) print "&act=$this->action";
		print "&sort=".$srt;
	}
	else print "type=".$this->table->type."&act=$this->action&sort=".$srt;


	print "\"";
	if($table->headerclass) print " class=\"$table->headerclass\" ";

	if($this->title) print " title=\"".$this->title."\"";

	print ">"; }

	print "<b>".$this->caption."</b></a></td>\n";
    }

function DrawRow($r,$numrow)
    {
	global $img_url,$site_url,$r,$gd,$db,$number,$HTTP_POST_VARS,$auth,$dbname,$img_url;


	if($this->default) $this->val=$this->default;

	if($r[$this->name]) $this->val=$r[$this->name]; 
	elseif($HTTP_POST_VARS[$this->name]) $this->val=$HTTP_POST_VARS[$this->name];
	elseif($this->text) $this->val=set_params($this->text);

	$name=$this->name;
	if(strlen($r[$name])) $this->val=$r[$name];

	$this->format=set_params($this->format);

	if($this->type!="hidden")
	{


	print "<td ".set_params($this->tdstyle).">\n";

	if($this->align=="center") print "<center>";
	elseif($this->align) print "<div align=\"$this->align\">";



	switch($this->type)
	{
		case "flag":
			if(strlen($r[$name])>0&&!strstr($name,"ID")) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[0]&dbname=$db->dbname\" title=\"$r[Country]\" border=0>";
			elseif(strlen($name)>0) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[$name]\" border=0 title=\"$r[Country]\">";
			break;
		case "kit":
			if(strlen($r[$name])>0) print "<img src=\"$img_url?id=$r[0]&table=ut_kits\" border=0>";
			break;
		case "showimage":
			$table=$this->table;
			if($r[$name]) print "<img src=\"/engine/cls/images/image.php?id=$r[0]&table=".$table->table."\" title=\"$r[Name]\" alt=\"$r[Name]\" border=0>";
			break;
		case "team":
			$name2=$name."ID";
			if(!$r[TeamID]) $r[$name2];
			if($r[Flag]&&$r[CountryID]) print "<img src=\"/engine/cls/images/flag.php?id=$r[CountryID]\" border=0 title=\"$r[Country]\" width=21px height=13px> ";
			print "<a href=\"/roster.php?id=$r[TeamID]\">";
			if($r[TeamID]==$auth->id) print "<b>";
			print $r[$name];
			print "</a>";
			break;
		case "mail":
			if($r[Status]==0) print "<img src=\"/engine/img/mail/new.gif\" width=14px height=11px>";
			else print "<img src=\"/engine/img/mail/read.gif\">";
			print " <a href=\"$PHP_SELF?id=$r[MessageID]\">";

			if($r[Status]==0) print "<b>".$this->val."</b>";
			else print $this->val;

			print "</a>";
			break;
		case "icon":
			print "<center><a href=\"".set_params($this->text)."\"><img src=\"$this->format\" $this->style border=0></a>";
			break;
		case "icq":
			$this->val=str_replace(" ","",$this->val);
			$icq=str_replace("-","",$this->val);

			if($this->val) print "<img src=\"http://status.icq.com/online.gif?icq=$icq&img=5\"  height=18px width=18px> ";
			if($this->val) print "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$icq\">$this->val</a>";

			break;
		case "date":
			if(is_numeric($r[$name])&&($r[$name]>0)) print "<nobr>".date($this->format,$this->val)."</nobr>";
			elseif($r[$name]>0) print $r[$name];
			break;
		case "number":
			$number++;
			$this->val=$number;
			print "<div align=right>".$this->val.".</div>";
			break;

		case "string":
			print "<input name=\"".$this->name."[".($numrow-1)."]\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." $this->format>";
			break;
		case "numeric":
			if(!$this->size) $this->size=2;
			print "<input name=\"".$this->name."[".($numrow-1)."]\" onfocus='FocusIN(this);' onblur='FocusOUT(this);'  type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." $this->format>";
			break;
		case "image":
			print "<input type=\"file\" name=\"".$this->name."[]\" style='width:170px'>";
			break;

		case "preview":
			if(strlen($r[$name])>0) print "<img src=\"$img_url"."?id=$r[0]&table=".$this->table->table."&dbname=".$dbname."\" border=0><br>";
		break;

		case "dots":
			print "<nobr>";
			if($this->val) print dots($this->val).$this->format;
			else print "0".$this->format;
			break;
		case "money":
			print "<nobr>";
			if($this->val) print $this->format.dots($this->val);
			else print $this->format."0";
			break;
		case "golden":
			print "<nobr>";
			print dots($this->val).$this->format.$gd;
			break;
		case "edit":
			print "<a href=\"$PHP_SELF?act=update&id=$r[0]&type=".($this->table->type)."\"><img src=\"$site_url"."images/icons/edit.png\" width=16px height=16px border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"></a>";
			break;
		case "delete":
			print "<a href=\"$PHP_SELF?act=delete&id=$r[0]&step=1&type=".($this->table->type)."\" onclick=\"return confirm('Вы уверены? Запись будет удалена')\"><img src=\"$site_url"."images/icons/drop.png\" width=16px height=16px border=0 alt=\"".sysmessage(1)."\" title=\"".sysmessage(1)."\"></a>";
			break;
		case "checkbox":
			print "<input type=\"checkbox\" name=\"".$this->name."[".($numrow-1)."]\"";
			if($r[$this->name]==1) print " checked";
			print ">";
			break;
		case "radio":

			print "<input type=\"radio\" name=\"".$this->name."[".($numrow-1)."]\"";
			print " value='$this->val'";

			if($this->val==set_params($this->text)) print " checked=1";

			print ">";
			break;
		case "list":
         		 print "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."[]\">";

         		if(!strlen($this->text)) 
			{ 
				print "<option value=\"$this->default\">-";
	        		print "</option>";
			}

				$ar=explode(";",$this->vars);
				$n=0;
				foreach($ar as $v)
				{
            				print "<option value=\"$n\"";
            				if($r[$this->name]==$n||($this->text==$v&&!$r[$this->name])) print " selected";
            				print ">$v</option>\n";
					$n++; 
				}

		          print "</select>\n";
		break;
		case "sqlist":


         		$res=runsql($this->sql);
			if(mysql_num_rows($res))
			{

         		print "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."[]\">\n";



         			if(!strlen($this->text)) 
				{ 
        				print "<option value=\"$this->default\">-";
         				print "</option>";
				}

	 			$n=0;
         			while($r1=mysql_fetch_array($res))
          			{

					print "<option value=\"$r1[0]\"";
					if($r1[2]) print " style='background-color:$r1[2]' ";
					if(($this->val==$r1[0]&&$this->val)||$r[$this->name]==$r1[0]||(($this->text==$r1[1]||$this->text=="$n")&&!$r[$this->name])) print " selected";
					print ">";
					print "$r1[1]</option>\n";
					$n++;
         			}

        			print "</select>\n";
			}
			else print "<input type=\"hidden\" name=\"$this->name[".($numrow-1)."]\">";
			
		break;
		default:
			print $this->format.stripslashes($r[$name]);
			break;
	}

	if($this->form&&(!$this->type||$this->type=="number")) print "<input type=\"hidden\" name=\"$this->name[]\" value=\"$this->val\">";
	print "</td>\n";

	}
	else print "<input type=\"hidden\" name=\"$this->name[".($numrow-1)."]\" value=\"$this->val\">";
    }
}
?>