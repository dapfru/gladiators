<?

require("cls_editor.php");

//28.3.07 set_form : []

//include_once($engine_path."cls/common/profiler.php");

Class cls_form extends cls_root
{
 var $mode;
 var $type;
 var $sqlres;
 var $attributes;
 var $templateattributes;
 var $serialize;
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

 var $noheader;

 var $pageid;

 //var $maxwidth;
 //var $maxheight;

/***********************************************************************
                        ������������� ������
* ***********************************************************************/


function cls_form($type,$tag)
    {
	global $test,$site,$lang,$gl_file,$debug,$site_path,$engine_path,$site,$idt,$step;

	$this->type=$type;
	$this->name=$tag;

	if(!$type) return false;





	if(!$tag) $tag="select";


	//$xml=select("select p.PageID,p.Xml Form,t.Xml Tag,p.Date from en_tags t join en_pages p using(PageID) where p.Type='$type' and t.Act='$tag'");	


	$xml=select("select PageID,Xml,Date from en_pages where Type='$type' and Site='$site'");	

	if((!$xml[0]||$xml[Date]<filemtime($site_path."xml/".$site.$type.".xml"))&&file_exists($site_path."xml/".$site.$type.".xml"))
	{
		$item=xml_contents($site_path."xml/".$site.$type.".xml");
		$q=select("select PageID from en_pages where Type='$type' and Site='$site'");
		runsql("delete from en_pages where Type='$type' and Site='$site'");
		runsql("delete from en_tags where PageID='$q[0]'");
		$item->Xml2File($type,$tag);
		$xml=select("select PageID,Xml,Date from en_pages where Type='$type' and Site='$site'");	
	}

	$this->pageid=$xml[0];


//$this->mode=1;

	if($this->mode==1) $this->template=xml_contents($engine_path."xml/templates/main.xml");

	if(!$this->mode)
	{


		$str=$xml[Xml];
//print $str;
		$ar2=explode("|?;",$str);
		$t=$ar2[0];

		for($i=1;$i<count($ar2);$i++)
		{
			if($i%2==0) 
			{

				$this->attributes[$t][$k]=$ar2[$i];

			}
			else $k=$ar2[$i];
		}

		$j++;

		if(!$this->name&&$this->attributes['form']['name']) $this->name=$this->attributes['form']['name'];
		if(!$this->name) $this->name="select";

		$xmlpage=$xml[PageID];


		$xml=select("select TagID,Xml from en_tags where Act='$this->name' and PageID='$xmlpage'");

		if(!$xml[0]&&file_exists($site_path."xml/".$site.$type.".xml"))
		{

			$item=xml_contents($site_path."xml/".$site.$type.".xml");
			$item->Xml2File($type,$this->name);
			$xml=select("select TagID,Xml from en_tags where Act='$this->name' and PageID='$xmlpage'");
		}

		$str=$xml[Xml];

		$ar=explode("#?;",$str);
		$j=0;


		foreach($ar as $v2)
		{
			$ar2=explode("|?;",$v2);
			$t=$ar2[0];
			

			for($i=1;$i<count($ar2);$i++)
			{
				if($i%2==0) 
				{

					if($t=="field"||$t=="item"||$t=="button") $this->attributes[$t][$j][$k]=$ar2[$i];
					else $this->attributes[$t][$k]=$ar2[$i];

				}
				else $k=$ar2[$i];
			}

			$j++;

		}

		$this->mode=2;


	}
	else
	{

		$item=xml_contents($site_path."xml/".$site.$type.".xml");
        	if(!$item) {print "$site_path"."xml/".$site.$type.".xml not found"; return false;}
		$this->mode=1;
	}



if($this->mode==1)
{
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
//??
	if(!$tag) $this->name=set_params($item->getAttribute('name',''));


	$this->empty=set_params($item->getAttribute('empty',''));


	$this->banner=$item->getAttribute('banner','');


}
else
{

	$ar=$this->attributes['form'];
	foreach($ar as $k=>$v)
	{
		if(strstr($v,"\$")) $v=set_params($v);

		if(substr($k,strlen($k)-4,1)=="_")
		{

			if(substr($k,strlen($k)-3)==$lang)
			{
				$k=substr($k,0,strlen($k)-4);
				$this->$k=$v;
			}
		}
		elseif($k!="name"||!$this->name)  $this->$k=$v;
	}



	
}

	if(!$this->name) $this->name="select";

//���� ����� ������-------------------------------

if($this->mode==1)
{
	$table = $item->getElementsByTagName($this->name);
	$this->document=$table[0];
	if(!$table[0]) { return false;}

	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
		if(strlen($v=$table[0]->getAttribute($name,''))) $this->$name=$v;
	}
}
else
{

	$ar=$this->attributes[$this->name];



	foreach($ar as $k=>$v)
	{


		//if(strstr($v,"\$")) $v=set_params($v);

		if(substr($k,strlen($k)-4,1)=="_")
		{


			if(substr($k,strlen($k)-3)==$lang)
			{
				$k=substr($k,0,strlen($k)-4);
				$this->$k=$v;
			}
		}
		else $this->$k=$v;
	}


	
}



	if(substr($this->sql,0,6)=="select"&&$this->name!="search"&&$this->act!="search") $this->act="select";
	elseif(!$this->act) $this->act=$this->name;
	
	$this->hint=nl2br($this->hint);
	

	if($this->act=="select"&&$this->sql) $this->getRows();

	if($site=="moderate/") $this->privacy=2;
	if($site=="admin/") $this->privacy=2;
	if(strstr($site,"admin")) $this->privacy=2;

	$this->rowdesign=trim($this->attributes[$this->name]['text']);

    }


function getTemplates()
{
	global $site_path;


	$xml=select("select PageID,Xml,Date from en_pages where Type='templates'");	
	if(!$xml[0]||$xml[Date]<filemtime($site_path."xml/templates/main.xml"))
	{
		$item=xml_contents($site_path."xml/templates/main.xml");
		$item->Xml2File('templates','');
		$xml=select("select PageID,Xml from en_pages where Type='templates'");
	}

	if($xml[0])
	{

		$str=$xml[1];
//print $str;
//exit;
		$ar=explode("#?;",$str);
		$j=0;

		foreach($ar as $v2)
		{
			$ar2=explode("|?;",$v2);
			$t=$ar2[0];
			

			for($i=1;$i<count($ar2);$i++)
			{
				if($i%2==0) 
				{

					if($t=="field"||$t=="item"||$t=="button") $this->templateattributes[$t][$j][$k]=$ar2[$i];
					else $this->templateattributes[$t][$k]=$ar2[$i];

				}
				else $k=$ar2[$i];
			}

			$j++;

		}
	}
}


function getRows()
{
	global $step,$debug,$serialized;

	$this->sql=$this->limitsql($this->sql);

	$sql="SELECT SQL_CALC_FOUND_ROWS ".substr($this->sql,6);

	if(strstr($this->sql,"@n:=")) {mysql_query("set @n:=$num");}

	if($this->serialize) 
	{

		eval($this->set_form_params(substr($this->serialize,1),$i));
		$this->numrows=count($serialized);

	}
	else
	{

		$this->sqlres=runsql($sql,$this->name);

		$res=mysql_query("SELECT FOUND_ROWS()");
		$r=mysql_fetch_array($res);	

		$this->numrows=$r[0];

	}
}

function getTemplateControl($item)
{

	$item=new cls_controls($item,$this);


	if($item->type=="template"&&!$this->templateattributes) $this->getTemplates();

	if($item->type=="template"&&($this->template&&$this->mode==1 || $this->templateattributes&&$this->mode==2)) 
	{


		if($this->mode==1&& !$table = $this->template->getElementsByTagName($item->name)) {print icon("error","Element $item->name not found in the template");exit;}
		elseif($this->mode==2&& !$table[0] = $this->templateattributes[strtolower($item->name)]) {print icon("error","Element $item->name not found in the template");exit;} 
		else
		{

			$newitem=new cls_controls($table[0],$this);

			if(strlen($item->needed)) $newitem->needed=$item->needed;

			return $newitem;


		}
	}
	else return $item;
}

function getTemplateHeader($item)
{

	$item=new cls_header($item,$this);

	if($item->type=="template"&&!$this->templateattributes) $this->getTemplates();

	if($item->type=="template"&&($this->template&&$this->mode==1 || $this->templateattributes&&$this->mode==2)) 
	{


		if($this->mode==1&& !$table = $this->template->getElementsByTagName($item->name)) {print icon("error","Element $item->name not found in the template");exit;}
		elseif($this->mode==2&& !$table[0] = $this->templateattributes[strtolower($item->name)]) {print icon("error","Element $item->name not found in the template");exit;} 
		else
		{


			$newitem=new cls_header($table[0],$this);


			if(strlen($item->needed)) $newitem->needed=$item->needed;
			if(strlen($item->order)&&($item->order!=$item->name || !$newitem->order)) $newitem->order=$item->order;
			if(strlen($item->format)) $newitem->format=$item->format;
			if(strlen($item->colspan)) $newitem->colspan=$item->colspan;

			return $newitem;
		}
	}
	else return $item;
}


function getfields()
{
	if($this->mode==1)
	{
		$inner = $this->document->getElementsByTagName("fields");

		$fields = $inner[0]->getElementsByTagName("field");
	}
	else
	$fields= $this->attributes['field'];

		return $fields;
}

function set_form_params($str,$i)
    {

	global $id,$engine_path,$site_path,$search,$im_array,$r,$REMOTE_ADDR,$_FILES,$_POST,$_GET,$id,$secpass,$lang,$auth,$er;


	$ndate=0;
	$st=$str;


	if(is_Array($_POST)&&is_Array($_GET)) $_POST=array_merge($_POST,$_GET);
	elseif(is_Array($_GET)) $_POST=$_GET;


	$im_count=0;


	if($_POST['numrows']) $mult=1;
 
	if(!$_POST['Time']) $Time=mktime();

	if(!$_POST['Day']) $Date=mktime();

	if(!$_POST['IP']) $IP=$REMOTE_ADDR;

if($this->mode==1)
{
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
}
else
{
	if($this->act=="select")
	{
		$fields =$this->attributes['item'];
	}
	else
	{
		$fields =$this->attributes['field'];
	}
}


	foreach($fields as $field)
	{

		$item=$this->getTemplateControl($field);

        	//$name=$field->getAttribute("name","no");

		$name=$item->name;

		if($name=="IP") {$$name=$REMOTE_ADDR;}


		$items[$name]=$item;

		if($item->default&&!$_POST[$name]) $_POST[$name]=$item->default;
		elseif($item->type=="stringlike") $_POST[$name]="%$_POST[$name]%";

		if($_POST[$name]=="%%") $_POST[$name]="%";


		if($mult) 
		{

			$f['name']=$_FILES[$name]['name'][$i];


			$f['tmp_name']=$_FILES[$name]['tmp_name'][$i];
			$f['size']=$_FILES[$name]['size'][$i];
			$f['type']=$_FILES[$name]['type'][$i];
		}
		else $f=$_FILES[$name];



		$type=$item->type;


		if(($type=="file"||$type=="image"||$type=="imageeditor"||$type=="flag")&&$f[name]) 
		{
			$file=fopen($f['tmp_name'],"r");

			if(!$file) $er=sysmessage(4)."<br>";

			$fname=$f['tmp_name'];
if($thios->mode==1)
{
			$maxsize=$field->getAttribute("maxsize",'');
			$format=$field->getAttribute("format",'');
}
else
{
			$maxsize=$field['maxsize'];
			$format=$field['format'];
}

			if(!strstr($format,strtolower(substr($f['name'],strpos($f['name'],".")+1)))&&$format) $er=sysmessage(5)." .$format!<br>";



			${$name}=fread($file,filesize($fname));


			if($type=="file") ${$name}=addslashes(${$name});


		}

//print "$type<br>";
//exit;
		if(($type=="flag"||$type=="image"||$type=="imageeditor")&&($f[name]||$_POST['UploadedImage'])
&&($id||strstr($str,"insert ")))
		{

//print $str;
//exit;

			$image= new cls_image($f);

if($this->mode==1)
{
			$image->maxsize=$field->getAttribute("maxsize",'');
			$image->maxwidth=$field->getAttribute("maxwidth",'');
			$image->maxheight=$field->getAttribute("maxheight",'');
			$image->mix=$field->getAttribute("mix",'');
			$image->mix2=$field->getAttribute("mix2",'');



			if($position=$field->getAttribute("position",'')) 
			{
				$image->position=$position;
			}


			if($width=$field->getAttribute("width",'')) 
			{
				$image->newWidth=$width; 
				$image->fix="width";
			}

			if($height=$field->getAttribute("height",'')) 
			{
				$image->newHeight=$height; 
				$image->fix="height";
			}

			if($fix=$field->getAttribute("fix",'')) $image->fix=$fix;

}
else
{
			$image->maxsize=$field['maxsize'];
			$image->maxwidth=$field['maxwidth'];
			$image->maxheight=$field['maxheight'];
			$image->mix=$field['mix'];
			$image->mix2=$field['mix2'];


			if($image->mix2) 
			{
				$image2 =new cls_image($image->imageMix($image->mix2));
				$image->contents=$image2->contents;
			}


			if($position=$field['position']) 
			{
				$image->position=$position;
			}


			if($width=$field['width']) 
			{
				$image->newWidth=$width; 
				$image->fix="width";
			}

			if($height=$field['height']) 
			{
				$image->newHeight=$height; 
				$image->fix="height";
			}

			if($fix=$field['fix'])  $image->fix=$fix;
}





			

			if($_POST['UploadedImage']==1)
			{

				$file_name=$site_path."/images/".$this->table."/".strtolower($name)."/0.jpg";
				$file=fopen($file_name,"r");
				$image->contents=fread($file,filesize($file_name));
				fclose($file);
				$image->type="jpeg";

			}
			else $image->check();

			${$name} =$image->contents;

			$im_array[$im_count]['name']=$item->name;
			$im_array[$im_count]['image']=$image->contents;

			if(($width||$height)&&$image->type=="gif")
			{

				if($this->mode==1) if(!$bgcolor=$field->getAttribute("bgcolor",'')) $bgcolor="515E64";
				elseif(!$bgcolor=$field['bgcolor']) $bgcolor="515E64";


				if($width&&($image->width>$width)||($height&&($image->height>$height))) $image->gif2jpeg($bgcolor);

			}

			$Type=$image->type;
			$ph[$name]=1;
			$ph['Small']=1;
			if($image->type!="gif") {



				$Small=new cls_image($image->imageResize()); 


				unlink($engine_path."tmp/".$image->name);
				$Small=$Small->contents; 


			}
			else $Small=${$name};



			if($_POST['UploadedImage']==1)
			{

				$file_name=$site_path."/images/".$this->table."/"."small"."/0.jpg";
				$file=fopen($file_name,"r");
				$Small=fread($file,filesize($file_name));
				fclose($file);

				$file_name=$site_path."/images/".$this->table."/".strtolower($name)."/0.jpg";
				$file=fopen($file_name,"r");
				$image->contents=fread($file,filesize($file_name));
				fclose($file);


			}



			$im_array[$im_count]['small']=$Small;
			$im_array[$im_count]['type']=$image->imtype;
			$im_count++;

			$ImageFormat=$image->imtype;
		}
		elseif($type=="date"||$type=="currentdate"||$type=="datetime"||$type=="currentdatetime") {

		$$name=mktime($_POST['hour'][$ndate],$_POST['minute'][$ndate],$_POST['seconds'][$ndate],$_POST['month'][$ndate],$_POST['day'][$ndate],$_POST['year'][$ndate]); if(($$name==-1)|| !$_POST['month'][$ndate] ||!$_POST['day'][$ndate] ||!$_POST['year'][$ndate]) unset($$name); $ndate++; 

}

		elseif($type=="sqldate") {


$$name=($_POST['year'][$ndate]."-".$_POST['month'][$ndate]."-".$_POST['day'][$ndate]); 


if(($$name==-1)|| !$_POST['month'][$ndate] ||!$_POST['day'][$ndate] ||!$_POST['year'][$ndate]) unset($$name); 

$ndate++; 

}

		if(($type=="url"||$name=="url")&&$$name&&!strstr($$name,"http://")) $$name="http://".$$name;
	}




      while($q=strpos($str,"$"))
      {

        $par_name=substr($str,1+$q,strpos($str,";",1+$q)-$q-1);

		if(strstr($par_name,"->")) 
		{

			$ob=substr($par_name,0,strpos($par_name,"->"));
			$var=substr($par_name,2+strpos($par_name,"->"));

			if(strstr($var,"[")) $vname=$ob.substr($var,0,strpos($var,"[")).substr($var,1+strpos($var,"["),strpos($var,"]")-strpos($var,"[")-1);
			else $vname=$ob.$var;

			$st=str_replace($par_name,$vname,$st);
			$str=str_replace($par_name,$vname,$str);

			$par_name=$vname;

			if(!$$par_name) 
			{
				if(!strstr($var,"[")) $$par_name=${$ob}->$var;
				else
				{

					$var1=substr($var,0,strpos($var,"["));
					$var=substr($var,1+strpos($var,"["));
					$var=substr($var,0,strlen($var)-1);




					$v=${$ob}->$var1;



					$$par_name=$v[$var];

				}
			}

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
			//elseif(is_Array($_POST[$par_name])) $$par_name=$_POST[$par_name][$i];
			elseif($_POST[$par_name]) $$par_name=$_POST[$par_name];



			if(!$$par_name&&!strstr($par_name,">")) 
			{

				$p=select("select @$par_name");
				if($p[0]) $$par_name=$p[0];
			}

//print "$i:".$par_name.is_Array($$par_name).$parval[$i].")";
			if(is_Array($$par_name)) 
			{
				$parval=$$par_name;
				$$par_name=$parval[$i];
			}



		        $str=substr($str,1+$q);

			$$par_name=str_replace(";","#dot",$$par_name);

      			$st=  str_replace("\$".$par_name.";",$$par_name,$st);
      			$str= str_replace("\$".$par_name.";",$$par_name,$str);




		}

      }

	$str=$st;

	$w=0;


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

		//�������� �� ;

		$pos=strpos($str,";",1+$q);
		if($pos&&(!($pos2=strpos($str,"=",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str,",",1+$q))||$pos<$pos2)&&(!($pos2=strpos($str," ",1+$q))||$pos<$pos2)) 
		{

		$par_name=substr($str,1+$q,$pos-$q-1);
		$str=substr($str,1+$q);


		$item=$items[$par_name];


		if($item->unique&&$mult)
		{
			foreach($_POST[$par_name] as $val)
			{
				if($ar[$val]) $er.=sysmessage(6)." $item->caption=$val ".sysmessage(7)."!<br>";
				else $ar[$val]=1;
			}
		}
			//elseif(is_Array($_POST[$par_name])) $$par_name=$_POST[$par_name][$i];

		if(!$$par_name&&is_Array($_POST[$par_name])) $par_val=$_POST[$par_name][$i];
		elseif(!$$par_name) $par_val=$_POST[$par_name];
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

			if($item->type!="flag"&&$item->type!="image"&&$item->type!="imageeditor"&&$par_name!="Small"&&$item->type!="file")
			{


				$par_val=str_replace("<", "&lt;", $par_val);
				$par_val=str_replace(">", "&gt;", $par_val);

				//if($item->type=="numeric") $par_val=intval($par_val);
				if($item->type=="text"||$item->type=="editor"||$item->type=="string") $search.=strip_tags($par_val)." ";


				if($item->type=="text"||$item->type=="editor") 
				{

if($item->type=="text")
{
					$par_val=str_replace("\r\n","<br />",$par_val);
					if($item->type=="text") $par_val=mysql_real_escape_string($par_val);
}


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
//print "$sql";
		} 


		$par_val=stripslashes($par_val);


//$a=$par_val;
		if($item->unique&&$par_val&&!$mult)
		{
			$par_val=addslashes($par_val);
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



//if($a!=$par_val) print "$par_name ���������<br>";
      }



	return $st;
    }


function runsql($noprint)
    {
	global $search,$auth,$idn,$id,$site_path,$im_array,$test,$i,$er,$lang,$_POST,$insertid,$r;

	if(!$this->checkPermission(1)) return 0;

	if($this->act!="select") $sql= $this->sql;
	else  $sql= $this->action;

	if($sql)
	{

	if(!$numrows=$_POST['numrows']) $numrows=1;

	$tmpsql=$sql;

	for($i=0;$i<$numrows;$i++)
	{

			$sql=$tmpsql;

			$sql=str_replace("&lt;","<",$sql);			
			$sql=str_replace("&gt;",">",$sql);


			$sqlar=explode("#",$sql);

                	foreach($sqlar as $sql)
			{

				$j++;

				$l=substr($sql,0,1);
				if($l=="^") {
					eval($this->set_form_params(substr($sql,1),$i));

				}
				else
				{



		if(((($this->mode==2)&&($this->attributes['field']||$this->attributes['item']))||
(($this->mode==1)&&($this->document->getElementsByTagName("fields")||$this->document->getElementsByTagName("header")))
)&&$this->name!="delete"&&$this->name!="create"&&$this->name!="drop") $sql=$this->set_form_params($sql,$i);
		else $sql=set_params($sql);

		if($er) 
		{
			break;
		}
		else
		{


				if(strstr($sql,"insert")) $c=1;

				$sqlstr=str_replace(";","",$sql);
				$sqlstr=str_replace("#dot",";",$sqlstr);

				if($res=runquery($sqlstr)) 
				{

					$str= set_params($this->success); 
				}
				else 
				{	


					if(strstr(mysql_error(),"MySQL server has gone away")) $er.= "������ ����������, ���������� ����� ����� ���� �����.";
					else $er.= "<font color=black>Error<br> ".str_replace(";","",$sql)." <br></font>".mysql_error(); 
					break;

				}


		if(substr($sql,0,6)=="select") {$r=mysql_fetch_array($res); }


if(!$er)
{
					if($im_array)
					{

						$name=$this->table;
						if(!$name) $name="unfiled";

						$q=select("select @insertid");

						if($q[0]) $idn=$q[0];
						else $idn=$id;

						foreach($im_array as $v)
						{
				
//header("Content-type: image/gif");
//print $v['small'];


//if($idn) 
//{
//header("Content-type: image/gif");
//print $v['small'];
//}

//if($idn) exit;

							if($name&&$v['image']&&$idn)
							{
								$path=$site_path."images/".$name."/".strtolower($v['name'])."/";
								if(!file_exists($path)) mkdir_r($path);
								$file=fopen($path.$idn.".jpg","w");
								fputs($file,$v['image']);

								fclose($file);

							}

							if($v['small']&&$name&&$idn)
							{
								$path=$site_path."images/".$name."/small/";
								if(!file_exists($path)) mkdir_r($path);

								$file=fopen($path.$idn.".jpg","w");
								fputs($file,$v['small']);		
								fclose($file);
							}
							

						}

						//����� ���� �� ������������ - �� �������� $idn ��� insert ����� ������ ��������
						if($idn) unset($im_array);

					}


}


		}

				}

		$r1=select("select @error");

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


//�����----------------------------------
			if($this->act=="insert"||substr($sql,0,6)=="insert")
			{
				$q=select("select SearchID from en_search where TableName='$this->table'");

				if($q[0]&&$search)
				{
					$insert=select("@insertid");
					$search=str_replace("\n\r"," ",$search);
					$search=str_replace("�","�",$search);

					$search=downstr(addslashes($search));
					$ar=explode(" ",$search);
					$position=1;
					foreach($ar as $word)
					{
						if($word) 
						{
							mysql_query("insert into en_searchindex(Word,SearchID,RecordID,Position) values('$word','$q[0]','$insert[0]','$position')");
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
					$search=str_replace("�","�",$search);

					$search=cut_end_word(downstr(addslashes($search)));

					$ar=explode(" ",$search);
					$position=1;

					foreach($ar as $word)
					{

						if($word) 
						{
							runsql("insert into en_searchindex(Word,SearchID,RecordID,Position) values('$word','$q[0]','$id','$position')");
							$position++;
						}
					}

				}

				unset($search);
			}


			if($this->act=="delete"||substr($sql,0,6)=="delete")
			{


				$q=select("select SearchID from en_search where TableName='$this->table'");


				if($q[0])
				{

					mysql_query("delete from en_searchindex where SearchID='$q[0]' and RecordID='$id'");
				}
			}

//�����-----------------------------------



			}



		if($er) break;

	}
//if($auth->user==455)
//{
//	exit;
//}

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




	if($this->act=="select"&&$this->numrows)
	{

               	$cnum=0;

		print "<tr bgcolor=".$this->hcolor." ";

		print "  align=\"center\" class=\"header\">\n";

		if($this->numrows>$this->pagecount||!strlen($this->numrows)) $numrows=$this->pagecount;
		else $numrows=$this->numrows;

		print "<input type=\"hidden\" name=\"numrows\" id=\"numrows\" value=\"$numrows\"/>";

		if($this->mode==1) $items = $header[0]->getElementsByTagName("item");
		else $items=$this->attributes['item'];

		foreach($items as $item)
		{


			$this->items[$cnum]=$this->getTemplateHeader($item);

			if($this->items[$cnum]->type!="hidden"&&!($colspan>1)) $this->items[$cnum]->Draw();
				
			if($colspan) $colspan--;

			if($this->items[$cnum]->colspan>1) $colspan=$this->items[$cnum]->colspan;

			$cnum++;
		}

		print "</tr>\n";

	}

	return $cnum;

    }

function limitsql($sql)
    {
	global $debug,$page,$sort;


	if(!$page) $pag=1;
	else $pag=$page;

	if($sort)
	{
	  if(!strstr($sql,"order by")) $sql.=" order by $sort";
	  else $sql=substr($sql,0,strpos($sql,"order by"))." order by $sort";
	}

	$num=(($pag-1)*$this->pagecount);
	if($this->pagecount&&!strstr($sql,"limit")) $sql.=" limit $num,$this->pagecount";


	return $sql;
    }




function BrowseSerialized()
    {
 	global $rowcolor,$serialized,$debug,$number,$_POST,$site,$page,$num,$sort,$st,$lang,$cnum,$r,$noedit;

	//eval($this->set_form_params(substr($this->serialize,1),$i));

	if(!count($serialized)) print "<tr><td bgcolor=ffffff>".$this->empty."</td></tr>";

	foreach($serialized as $r)
	{

		$numrow++;

		$_POST['numrow']=$numrow;

		if($color!=$this->rowcolor) $color=$this->rowcolor;
		elseif($this->mixcolor)  $color=$this->mixcolor;


		$rowcolor=$color;

		print "<tr bgcolor=".$color." ";

		if($this->style) print set_params($this->style);

		print ">";



		foreach($this->items as $item)
		{ 

			$item->DrawRow($r,$numrow);


			if($item->count) {
				$count[$item->name]+=$item->value; 
				if($item->value!=0) $c[$item->name]++; 
			}
			elseif(!$numcols) $cols++;

		}



		print "</tr>";
	}
    }

function Browse()
    {
 	global $rowcolor,$debug,$number,$_POST,$site,$page,$num,$sort,$st,$lang,$cnum,$r,$noedit;

	$number=0;
	$res=$this->sqlres;
	if($page>1) $number=($page-1)*$this->pagecount;

	if(!mysql_num_rows($res)) print "<tr><td bgcolor=ffffff>".$this->empty."</td></tr>";

	if(!$this->numrows) $this->numrows=mysql_num_rows($res);


	while($r=mysql_fetch_array($res))
	{


		$numrow++;

		$_POST['numrow']=$numrow;

if(!$this->rowdesign)
{
		if($color!=$this->rowcolor) $color=$this->rowcolor;
		elseif($this->mixcolor)  $color=$this->mixcolor;

		$rowcolor=$color;

		print "<tr bgcolor=".$color." ";

		if($this->style) print set_params($this->style);

		print ">";



		foreach($this->items as $item)
		{ 

			$item->DrawRow($r,$numrow);


			if($item->count) {
				$count[$item->name]+=$item->value; 

				if($item->value!=0) $c[$item->name]++; 
			}
			elseif(!$numcols) $cols++;

		}



		print "</tr>";
}
else
{
	print set_params($this->rowdesign);
}	

	

	}


		if(count($count))
		{
			print "<tr class=header>";


			foreach($this->items as $item)
			{ 

				print "<td>";

				if($item->align=="center") print "<center>";
				elseif($item->align) print "<div align=\"$item->align\">";

				if($item->count=="avg"&&$c[$item->name]!=0) { 
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
	global $project_name,$auth,$site_url,$site;

	if($this->vip&&!($auth->rang>=$this->vip)) 
	{ 
		if($this->vip==1) print icon("vip",message(196)); 
		elseif($this->vip==2) print icon("vip",message(197)); 
		elseif($this->vip==3) print icon("vip",message(198)); 
		if(!$step||$this->name=="vip") print "<br>";

		if($step) return 0;
	}

	if(($project_name=="butsa")&&$this->privacy==1&&!$auth->team) 
	{ 
		print icon("error",sysmessage(16)."<br><a href=\"$site_url"."xml/office/free.php\">".message(55)."</a></center>"); 
		return 0;
	}


	if($this->privacy==2) 
	{ 


		//if($project_name=="butsa") 


$r=select("select PermissionID from en_permissions where 
(Site='$site' or Site='".substr($site,0,strlen($site)-1)."' or Type='**') and 
(Type='$this->type' or Type='*' or Type='**') and (Act='' or Act='$this->name') 
and (UserID='$auth->user' or TypeID in 
(select p.TypeID from ut_posts p where p.TypeID=TypeID and p.UserID='$auth->user'))");

		//else  $r=select("select PermissionID from en_permissions where (Type='$this->type' or Type='*') and (Name='' or Name='$this->name') and (UserID='$auth->user')");

		if(!$r[0]||!$auth->user) 
		{
			print icon("error",message(182)); 
			return 0;
		}
	}

	return 1;
    }

//������ �����------------------------------
function Draw()
    {
	global $debug,$gl_file,$cnum,$act,$auth,$lang,$id,$r,$type,$num,$cnum,$engine_path,$site,$form_ok;

	if($this->mode==1&&!$this->document) {
	print "$type $act, XML error"; 
	return 0;
	}
	elseif($this->mode==2&&!$this->attributes) {
 	 print "$type $act, Attributes error"; 
	 return 0;
	 }

	if($act=="search"&&$act!=$this->name) $step=1;


	if(!$this->checkPermission($step))
	{
	 return 0;
	 }



	if($this->act=="select"&&!$this->numrows)
	{
		if($this->empty) print icon('green',$this->empty);
		return 0;
	}


	//�������� ������ ��� ����������-----------


	if($this->select)
	{
		$l=substr($this->select,0,1);
		if($l=="^") eval($this->set_form_params(substr($this->select,1),$i));
		else $r=select(settags($this->select));
	}


	if(!$r[0]&&$this->error) 
	{
		if(!$form_ok) print icon('error',$this->error);
		return 0;
	}


	if(!$this->rowdesign) $this->Header();


	if(!$this->rowdesign) $cnum=$this->DrawHeader();

	if(!$cnum) $cnum=2;

	$this->DrawFields();
	$this->DrawButton($cnum);

        if(!$this->rowdesign) $this->Footer();

	unset($num);
    }


function DrawFields()
    {
   // tic("DrawFields");
	global $debug,$cnum,$r,$step,$er;


	if($this->act!="select")
	{

if($this->mode==1)
{
		$inner = $this->document->getElementsByTagName("fields");
		if(!$inner[0])	return false;

		if(strlen($inner[0]->text)) print settags($inner[0]->text);

		$fields = $inner[0]->getElementsByTagName("field");
}
else
{
		if(strlen($this->attributes['fields']['text'])) print settags($this->attributes['fields']['text']);
		$fields =$this->attributes['field'];
}



if(!$this->rowdesign)
{
		//������ ����------------------------------
		foreach($fields as $field)
		{



			if($control&&$control->type!="hidden"&&$color!=$this->rowcolor||!$control) $color=$this->rowcolor;
			elseif($control&&$control->type!="hidden"&&$this->mixcolor)  $color=$this->mixcolor;

			$control=$this->getTemplateControl($field);


			$control->rowcolor=$color;

	 		$control->Draw(1,'');


		}

}
else
{
	print set_params($this->rowdesign);
}


	}
	elseif($this->serialize) $this->BrowseSerialized();
	elseif($this->act=="select") $this->Browse();



	//tac();
    }

function DrawButton($cnum)
    {
	global $lang,$firstpage;



	if($this->mode==1) 
	  $buttons = $this->document->getElementsByTagName("button");
	else 
	  $buttons=$this->attributes['button'];


	if($buttons&&($this->act!="select"||$this->numrows>0)) 
	{

		print "<input type=\"hidden\" name=\"oldact\" value=\"$this->name\"/>\n";


		print "<tr bgcolor=".$this->hcolor."  class=\"header\"><td colspan=$cnum>\n";

		$type="submit";

			foreach($buttons as $button)
			{
				if($this->mode==1)
				{
					print  $button->text;
					if($newact=($button->getAttribute("act",''))) print "<input type=\"hidden\" name=\"act\" value=\"$newact\"/>\n";
		

					$name=$button->getAttribute("name",'');
					if($typ=$button->getAttribute("type",'')) $type=$typ;
					$format=set_params($button->getAttribute("format",''));
					if($align=$button->getAttribute("align",'')) print "<div align=\"$align\">\n";
				}
				else
				{
					print $button['text'];

					if($newact=($button['act'])) print "<input type=\"hidden\" name=\"act\" value=\"$newact\"/>\n";


					$n="name_".$lang;
					$name=$button[$n];

					if($typ=$button['type']) $type=$typ;

					$format=set_params($button['format']);

					if($align=$button['align']) print "<div align=\"$align\">\n";
				}

				if(!$type) $type="button";

				if($type=="submit") $format.=" onclick=\"this.disabled = true; this.className='disabledbutton'; this.form.submit();\" ";

				if($type=="return") 
				{
					$type="button"; 
					if($button['redirect']) $format.=" onclick=\"location='".$button['redirect']."'\" ";
					else $format.=" onclick=\"location='$firstpage'\" ";
				}
				
				print "<input type=\"$type\" value=\"$name\" class=\"button\" $format/> ";
				unset($type);

			}


		print "</td></tr>\n";
	}

    }

function DrawImage()
    {
	global $er,$form_ok;

	//if(!$this->document) return 0;

	if(!$er&&!$form_ok&&$this->image) print "<center><img src=\"$this->image\"></center><hr>\n";
    }

}


Class cls_controls 
{
 var $name;
 var $table;
 var $caption;
 var $type;
 var $rowcolor;

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
                        ������������� ������
* ***********************************************************************/



function cls_controls($field,$table)
    {
      global $lang;


	$this->table=$table;

if($table->mode==1)
{
	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
		if($name=="vars") $nam=$name."_$lang";
		else $nam=$name;

		if(strlen($v=$field->getAttribute($nam,''))) $this->$name=$v;
	}

}
else
{

	foreach($field as $k=>$v)
	{
		//if(strstr($v,"\$")) $v=set_params($v);

		if(substr($k,strlen($k)-4,1)=="_")
		{

			if(substr($k,strlen($k)-3)==$lang)
			{
				$k=substr($k,0,strlen($k)-4);
				$this->$k=$v;
			}
		}
		else $this->$k=$v;
	}


}

	$this->rowcolor=$table->rowcolor;

	if(strstr($this->type,"\$")) $this->type=set_params($this->type);

	if(!$this->caption) $this->caption=$this->name;

if($table->mode==1)
{
	$this->name=$field->getAttribute("name","no");
	if(!$this->name) $this->name=$field->getAttribute("name","eng");
	$this->text=$field->text;
}
else
{
	if($field['name']) $this->name=$field['name'];	
	elseif(!$this->name) $this->name=$field['name_eng'];
	$this->text=$field['text'];
}





    }

function Draw($drawTable,$form)
    {
	global $path,$engine_path,$site_path,$site_url,$engine_url,$_GET,$img_url,$ndate,$r,$id,$_POST,$db,$gd,$lang,$_GLOBALS,$dbname,$day,$month,$year;

	if(count($_GET)>count($_POST)) $_POST=$_GET;

	if(!$form) $form=$this->table;
	else $this->rowcolor=$form->rowcolor;



	if(!$ndate) $ndate=0;

	if(strstr($this->text,"\$")) $this->text=set_params($this->text);

	if(strlen($this->text)) $this->val=$this->text;

	if(strlen($r[$this->name])) $this->val=$r[$this->name]; 



	if($_GLOBALS[$this->name]&&!$this->val) $this->val=$_GLOBALS[$this->name];

	if($_POST[$this->name]&&$this->name!="act"&&!$this->val) $this->val=$_POST[$this->name];

	if($this->sql&&($this->type!="sqlist")&&($this->type!="sqllabel")&&($this->type!="sqlradio"))
	{

		$res=runsql($this->sql);
		$r1=mysql_fetch_array($res);

		$this->val=$r1[0];
		$_POST[$this->name]=$this->val;
	}

	if($this->type=="sqldatelabel"&&$this->val=="0000-00-00") $this->val="";
	if($this->type=="urllabel"&&$this->val=="http://") $this->val="";

	if(!$this->val&&($this->table->short&&!$this->colspan)&&$this->type!="list"&&$this->type!="sqlist") $this->type="hidden";


	if($this->name!="Xml"&&(strstr($this->val,"&lt")||strstr($this->val,"&gt"))) $this->val=settags($this->val);

	if(strstr($this->format,"&lt")||strstr($this->format,"&gt")) $this->format=settags($this->format);


	//$this->val=stripslashes($this->val);

	if($this->type!="hidden")
	{
		if($drawTable)
		{

			print "<tr bgcolor=".$this->rowcolor.">";

			print "<td valign=top";
			if($this->colspan>1) print " colspan=".$this->colspan;
			if($this->tdstyle) print " ".$this->tdstyle;
			print ">";

	 	if($this->nobr) print "<nobr>";

		if($this->align =="center") print "<center>";

         	if($this->needed) print "<b>";
		
		if($form->wrong&&in_array($this->name,$form->wrong)) print "<font color=red>";

		$this->caption=str_replace("&gt;",">",$this->caption);
		$this->caption=str_replace("&lt;","<",$this->caption);

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
			print "<input $this->format name=\"".$this->name."\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' size=\"".$this->size."\" type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" $this->format/>";
		break;

		case "secret":

			if(!$code=$_POST['SecretCode']) $code=mktime();
			print "<input type=\"hidden\" name=\"SecretCode\" value=\"".$code."\"/>";
			print " <img src=\"$engine_url"."cls/common/code.php?id=$code\" border=1>";
			print "<br><input $this->format name=\"".$this->name."\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' size=\"".$this->size."\" type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" $this->format/>";
		break;

		case "password":
			if(strlen($this->val)==32) unset($this->val);
			print "<input onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."\" size=\"".$this->size."\" type=\"password\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\"/>";
		break;


		case "datelabel":

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

			if($_POST['day'][$ndate]) $day[$ndate]=$_POST['day'][$ndate];
			if($_POST['month'][$ndate]) $month[$ndate]=$_POST['month'][$ndate];
			if($_POST['year'][$ndate]) $year[$ndate]=$_POST['year'][$ndate];

			if($_POST['hour'][$ndate]) $hour[$ndate]=$_POST['hour'][$ndate];
			if($_POST['minute'][$ndate]) $minute[$ndate]=$_POST['minute'][$ndate];



			$dd=$day[$ndate];
			$mm=$month[$ndate];
			$yr=$year[$ndate];
			$hour=$hour[$ndate];
			$minute=$minute[$ndate];


			$ndate++;

			if(!$day[$ndate]&&strlen($this->val)>1&&is_numeric($this->val)) 
			{
				$dd=date("d",$this->val);
				$mm=date("m",$this->val);
				$yr=date("Y",$this->val);

				$hour=date("H",$this->val);
				$minute=date("i",$this->val);
			}
			
			if(!$dd&&$this->maxyear) $dd=1;
			
			$strday= "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"day[]\"><option value=\"\"></option>";

			for($i=1;$i<=31;$i++)
			{
				$strday.= "<option value=\"$i\"";
				if($i==$dd) $strday.= " selected";
				$strday.= ">$i</option>";
			}

			$strday.= "</select>";

			$strmonth= "<select onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"month[]\">";

			$months['rus']=array('�����','������','�������','�����','������','���','����','����','�������','��������','�������','������','�������');
			$months['eng']=array('Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$months['ger']=array('Monat', 'Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
			$months['ita']=array('mese','gennaio','febbraio','marzo','aprile','maggio','giugno','luglio','agosto','settembre','ottobre','novembre','dicembre');

 
			$i=0;
			foreach($months[$lang] as $m)
			{
				$strmonth.= "<option value=\"$i\"";
				if($i==$mm) $strmonth.= " selected";
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
				if($i==$yr) $stryear.= " selected";
				$stryear.= ">$i</option>";
			}

			$stryear.="</select>";


			if($lang=="eng") print "$strmonth $strday $stryear";
			else print "$strday $strmonth $stryear";

			if($en_datetime) print " <input type=\"text\" onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" name=\"hour[]\" size=2 maxlength=2 value=\"$hour\"/>:<input type=\"text\" onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" name=\"minute[]\" size=2 maxlength=2 value=\"$minute\"/>";
		break;

		case "numeric":
			if($this->size==20) $this->size=3;
			print "<input $this->format name=\"".$this->name."\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format/>";
		break;

		case "between":
			if($this->size==20) $this->size=3;

			$n1=$this->name."_1";
			$val1=$_POST[$n1];

			$n1=$this->name."_sign1";
			$sval1=$_POST[$n1];

			$n2=$this->name."_2";
			$val2=$_POST[$n2];

			$n2=$this->name."_sign2";
			$sval2=$_POST[$n2];


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

			print "<input $this->format name=\"".$this->name."_1\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$val1."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format/> ";

			print sysmessage(15);


			print " <select name=\"".$this->name."_sign2\">";

			foreach($ar as $a)
			{
				print "<option value=\"$a\"";
				if($a==$sval2) print " selected";
				print ">$a</option>";
			}


			print "</select>";

			print " <input $this->format name=\"".$this->name."_2\" type=\"".$this->type."\" maxlength=\"".$this->maxlength."\" value=\"".$val2."\" size=".$this->size." onfocus='FocusIN(this);' onblur='FocusOUT(this);'  onkeypress=\"javascript: return checknumeric(event)\" $this->format/>";

		break;

		case "text":
			print "<textarea $this->format name=\"".$this->name."\" cols=\"".$this->cols."\" rows=\"".$this->rows."\" maxlength=\"".$this->maxlength."\">".str_replace("<br />","\r\n",$this->val)."</textarea>";
		break;

		case "editor":
			require_once($engine_path."cls/editor/fckeditor.php") ;
			$oFCKeditor = new FCKeditor($this->name) ;

			$oFCKeditor->ToolbarSet = 'Basic' ;
			if(!$this->height) $oFCKeditor->Height = 400 ;
			else $oFCKeditor->Height = $this->height ;

			if($this->format) $oFCKeditor->ToolbarSet = $this->format ;

			$oFCKeditor->Value = $this->val;
			$oFCKeditor->Create() ;

		break;


		case "calendar":
print "<script src='".$path."calendar.js' language='javascript' type='text/javascript'></script>";


?>
<input type="text" name="Date�" id="date1"><a id="date1_a"
href="javascript:popUpCalendar(document.getElementById('date1_a'),
document.getElementById('date1'), 'dd.mm.yyyy', 0);"><img id="date1_img" border="0" src="images/engine/date.gif" alt="������� ����"></a>

<?
		break;


		case "radio":

			if($this->format) $vals=explode(";",$this->format);

			$ar=explode(";",$this->vars);
			$n=0;
			$i=0;

			foreach($ar as $v)
			{

				print "<input class=\"radio\" name=\"".$this->name."\" type=\"radio\" ".$this->action." ";

				if($vals[$i]) $val=$vals[$i]; 
				else $val=$n; 

				print " value=\"".$val."\"";

                       		if(($this->default!="0"||($this->val==$val&&$val))&&($this->val==$val||$r[$this->name]==$n||($this->text==$v&&!$r[$this->name]))) print " checked";
				print "/>$v<br>";
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
            			elseif(!strlen($this->val)&&($this->text=="$var"||($this->text==$v&&!$r[$this->name]))) print " selected";


            			print ">$v</option>";
				$n++; 
				$i++;
			}

			print "</select>";
		break;

		case "urllabel":

			$this->val=str_replace(">","&gt;",$this->val);
			$this->val=str_replace("<","&lt;",$this->val);

			if($this->val&&!strstr($this->val,"http://")) $this->val="http://".$this->val;

			if($this->val&&$this->val!="http://") print "<a href=\"$this->val\">$this->val</a>";
		break;

		case "emaillabel":

			$this->val=str_replace(">","&gt;",$this->val);
			$this->val=str_replace("<","&lt;",$this->val);

			if($this->val) print "<a href=\"mailto:$this->val\">$this->val</a>";
		break;

		case "icqlabel":

			$this->val=str_replace(">","&gt;",$this->val);
			$this->val=str_replace("<","&lt;",$this->val);

			$icq=str_replace("-","",$this->val);
			$icq=str_replace(" ","",$icq);
			if($this->val) print "<img src=\"http://status.icq.com/online.gif?icq=$icq&img=5\" height=18px width=18px/> ";
			if($this->val) print "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$icq\">".$this->val."</a>";
		break;

		case "listlabel":
			$ar=explode(";",$this->vars);

			if(!$this->vars) $ar=$_GLOBALS[$this->default];

			$i=0;
			print $ar[$this->val-1];

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

				if($r1[color]) print " style='background-color:$r1[color]' ";				
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

				print "<input ".$this->format." class=\"radio\" name=\"".$this->name."\" type=\"radio\"  value=\"".$r1[0]."\"";
				if(($this->val==$r1[0]&&$this->val)||$r[$this->name]==$r1[0]||(($this->text==$r1[1]||$this->text=="$n")&&!$r[$this->name])) print " checked";
				print "/>$r1[$n]";
				if(!$this->horizontal) print "<br>";

				$n++;
         		}

		break;

		case "checkbox":
			print "<input  class=\"checkbox\" $this->format type=\"checkbox\" value=\"1\" name=\"".$this->name."\"";
			if($this->val) print " checked";
			print "/>";
		break;

		case "image":

			srand();

			if(!$id) $id=$r[0];

			if(file_exists($site_path."images/".$this->table->table."/small/$id.jpg")) print "<img src=".$site_url."images/".$this->table->table."/small/$id.jpg?rnd=".mt_rand(0,1000)."><br>";
			elseif(strlen($r[$this->name])>0) print "<img src=\"$site_url"."cls/images/image.php?id=$r[0]&table=$form->table&dbname=$dbname&rnd=".mt_rand(0,1000)."\" border=0><br>";
			print "<input type=\"file\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' name=\"".$this->name."\"/>";
		break;



		case "imageeditor":

			$q=select("select RecordID,IDName from en_table_images where TableName='$form->table' and FieldName='$this->name'");
			$record=$q[0];
			$fieldname=$q[1];

			if(strlen($r[$this->name])>0) 
			{

?>

<iframe src="<?=$site_url?>js/resize.php?width=<?=$this->width?>&height=<?=$this->height?>&id=<?=$id?>&image=1&record=<?=$q[0]?>" width="700" height="700" hspace="10" vspace="10" align="center">
��� ������� �� ������������ ��������� ������!
</iframe> 

<?

			}
			else
			{

?>

<iframe src="<?=$site_url?>js/resize.php?width=<?=$this->width?>&height=<?=$this->height?>&image=0&record=<?=$q[0]?>&id=<?=$id?>" width="700" height="700" hspace="10" vspace="10" align="center">
��� ������� �� ������������ ��������� ������!
</iframe> 

<?

			}
			


		break;

		case "flag":
			if(strlen($r[$this->name])>0) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[0]&dbname=$db->dbname\" title=\"$r[Country]\" width=21px height=13px border=0/><br>";
			print "<input type=\"file\" name=\"".$this->name."\"/>";
		break;

		case "clear":
			print $this->val.$this->format;
		break;

          	case "safelabel":


			$this->val=str_replace(">","&gt;",$this->val);
			$this->val=str_replace("<","&lt;",$this->val);
			$this->val=str_replace("&lt;br /&gt;","<br>",$this->val);


			$this->val=stripslashes($this->val);
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\"/>";
               		print "<span $this->format>$this->val</span>";
          	break;

          	case "label":
			$this->val=stripslashes($this->val);
			if(strstr($this->val,"\$")) $this->val=set_params($this->val);
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\"/>";
               		print "<span $this->format>$this->val</span>";
          	break;

		case "dots":
			$this->val=trim($this->val);
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\"/>";
			print dots($this->val).$this->format;
		break;
		case "money":
			print "<input type=\"hidden\" name=\"".$this->name."\" value=\"".$this->val."\"/>";
			print dots($this->val).$gd;
		break;

		default:
			print "<input name=\"".$this->name."\" type=\"".$this->type."\" value=\"".$this->val."\" $this->format/>";
		break;
	 }

	if($this->align =="left") print $this->caption;

	if($drawTable&&$this->type!="hidden")	print "</td>\n</tr>\n";
        
    }
}



Class cls_header
{
 var $name;
 var $caption;
 var $lang;
 var $type;
 var $format;
 var $action;
 var $table;
 var $order;
 var $align;
 var $width;
 var $background;
 var $val;
 var $value;
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
                        ������������� ������
* ***********************************************************************/



function cls_header($field,$table)
    {
      global $lang,$r;


	$this->table=$table;

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

if($table->mode==1)
{
	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
		if($name=="vars") $nam=$name."_$lang";
		else $nam=$name;

		if(strlen($v=$field->getAttribute($nam,''))) $this->$name=$v;
	
	}
}
else
{

	foreach($field as $k=>$v)
	{
		//if(strstr($v,"\$")) $v=set_params($v);

		if(substr($k,strlen($k)-4,1)=="_")
		{

			if(substr($k,strlen($k)-3)==$lang)
			{
				$k=substr($k,0,strlen($k)-4);
				$this->$k=$v;
			}
		}
		else $this->$k=$v;
	}


}
	if(strstr($this->type,"\$")) $this->type=set_params($this->type);

	//$this->text=$field->text;

	if(!$this->caption) $this->caption=$this->name;

if($table->mode==1)
{
	$this->name=$field->getAttribute("name","no");

	if(!$this->name) $this->name=$field->getAttribute("name","eng");
}
else
{
	if($field['name']) $this->name=$field['name'];	
	elseif(!$this->name) $this->name=$field['name_eng'];
}

	if($this->lang) $this->name.="_$lang";

	if(strstr($this->name,"\$")) $this->name=set_params($this->name);
	if(!$this->order) $this->order=$this->name;



	if(strstr($this->caption,"\$")) $this->caption=set_params($this->caption);


    }

function Draw()
    {
	global $st,$sort,$act,$r,$QUERY_STRING,$PHP_SELF;

	$table=$this->table;

	print "<td ";

	if($this->colspan>1) print "colspan=$this->colspan ";
	if($this->width) print "width=$this->width ";

	if($table->headerbg) print "background=\"$table->headerbg\" ";

	print ">";

if(!$table->noheader)
{
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

	print ">"; 
	print "<b>".$this->caption."</b></a>";

	}
	else
	{
		print "<span ";
		if($this->title) print " title=\"".$this->title."\"";
		print "><b>".$this->caption."</b></span>";
	}
}
	print "</td>\n";
    }

function DrawRow($r,$numrow)
    {
	global $type,$site_path,$debug,$img_url,$site_url,$r,$gd,$db,$number,$_POST,$auth,$dbname,$img_url;


	if($this->default) $this->val=$this->default;

	if($r[$this->name]) $this->val=$r[$this->name]; 
	elseif($_POST[$this->name]) $this->val=$_POST[$this->name];
	elseif($this->text) $this->val=$this->text;

	if(is_Array($this->val)) $this->val=$this->val[$numrow];

	//if(strstr($this->val,"\$")) $this->val=set_params($this->val);
	//if(strstr($this->text,"\$")) $this->text=set_params($this->text);

	$name=$this->name;
	if(strlen($r[$name])) $this->val=$r[$name];

	if(strstr($this->format,"&lt")||strstr($this->format,"&gt")) $this->format=settags($this->format);

	if(strstr($this->format,"\$")) $format=set_params($this->format);
	else $format=$this->format;



	if($this->type!="hidden")
	{


	if($this->tdstyle&&strstr($this->tdstyle,"\$")) print "<td ".set_params($this->tdstyle).">\n";
	elseif($this->tdstyle) print "<td ".$this->tdstyle.">\n";
	else print "<td>";

	if($this->align=="center") print "<center>";
	elseif($this->align) print "<div align=\"$this->align\">";




	switch($this->type)
	{
		case "flag":

/*
			if(strlen($r[$name])>0&&!strstr($name,"ID")) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[0]&dbname=$db->dbname\" title=\"$r[Country]\" border=0 width=21px height=13px/>";
			elseif(strlen($r[$name])>0) print "<img src=\"$site_url"."cls/images/flag.php?id=$r[$name]\" width=21px height=13px border=0 title=\"$r[Country]\"/>";
*/

print "<img src=\"$site_url"."images/flag/$r[$name].gif\" width=21px height=13px border=0 title=\"$r[Country]\"/>";


			break;
		case "kit":
			if(strlen($r[$name])>0) print "<img src=\"/images/ut_kits/kit/$r[0].jpg\" border=0>";
			break;
		case "showimage":
			$table=$this->table;
			$fname="/images/".$table->table."/".strtolower($this->name)."/$r[0].jpg";

			if(file_exists($site_path.$fname)) print "<img src=\"$fname?rnd=".mt_rand(0,10000)."\" title=\"$r[Name]\" alt=\"$r[Name]\" border=0>";
			elseif($r[$name]) print "<img src=\"$img_url?id=$r[0]&table=".$table->table."\" title=\"$r[Name]\" alt=\"$r[Name]\" border=0>";
			break;
		case "team":
			$name2=$name."ID";
			if(!$r[TeamID]) $r[$name2];
			if($r[Flag]&&$r[CountryID]) print "<img src=\"/cls/images/flag.php?id=$r[CountryID]\" border=0 title=\"$r[Country]\" width=21px height=13px/> ";
			print "<a href=\"/xml/players/roster.php?id=$r[TeamID]\">";
			if($r[TeamID]==$auth->id) print "<b>";
			print $r[$name];
			print "</a>";
			break;
		case "mail":
		
			if($r[GuildID]) print "<a href=/guilds/$r[GuildID]><img src=/images/gd_guilds/small/$r[GuildID].jpg border=0></a> ";

			if($r[Status]==0) print "<img src=\"/images/engine/mail.gif\" width=14px height=11px/>";
			else print "<img src=\"/images/engine/read.gif\">";
			print " <a href=\"$PHP_SELF?id=$r[MessageID]&type=$type&act=message\">";

			if($r[Status]==0) print "<b>".$this->val."</b>";
			else print $this->val;

			print "</a>";
			break;
		case "icon":
			print "<center><a href=".set_params($this->text)."><img src=\"$format\" $this->style border=0></a>";
			break;
		case "icq":
			$this->val=str_replace(" ","",$this->val);
			$icq=str_replace("-","",$this->val);

			if($this->val) print "<img src=\"http://status.icq.com/online.gif?icq=$icq&img=5\"  height=18px width=18px/> ";
			if($this->val) print "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$icq\">$this->val</a>";

			break;
		case "date":
			if(is_numeric($r[$name])&&($r[$name]>0)) print "<nobr>".date($format,$this->val)."</nobr>";
			elseif($r[$name]>0) print $r[$name];
			break;
		case "number":
			$number++;
			print "<div align=right>".$number.".";
			break;
		case "numeric":
			if($this->size==20) $this->size=3;

			print "<input name=\"".$this->name."[".($numrow-1)."]\" ";

			if(!strstr($this->format,"readonly")) print "onkeypress=\"javascript: return checknumeric(event)\" onblur='FocusOUT(this);' onfocus='FocusIN(this);'";

			print " type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." $format/>";
			break;
		case "string":
			print "<input name=\"".$this->name."[".($numrow-1)."]\" onfocus='FocusIN(this);' onblur='FocusOUT(this);' type=\"text\" maxlength=\"".$this->maxlength."\" value=\"".$this->val."\" size=".$this->size." $format/>";
			break;
		case "image":
			print "<input type=\"file\" name=\"".$this->name."[".($numrow-1)."]\" style='width:170px'/>";
			break;

		case "text":

			print "<textarea $this->format name=\"".$this->name."[".($numrow-1)."]\" cols=20 rows=2 maxlength=\"".$this->maxlength."\">".str_replace("<br />","\r\n",$this->val)."</textarea>";


			break;

		case "file":
			print "<input type=\"file\" name=\"".$this->name."[]\" style='width:170px'/>";
			break;

		case "preview":
			if(strlen($r[$name])>0) print "<img src=\"$img_url"."?id=$r[0]&table=".$this->table->table."&dbname=".$dbname."\" border=0><br>";
		break;

		case "dots":
			print "<nobr>";
			if($this->val) print dots($this->val).$format;
			else print "0".$format;
			break;
		case "money":
			print "<nobr>";
			if($this->val) print $format.dots($this->val);
			elseif(strlen($this->val)) print $format."0";
			break;

		case "report":
			print "<a href=\"$site_url"."admin/adm_games.php?id=".$r[0]."\"><img src=\"$site_url"."images/icons/report.gif\" width=17px height=16px border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"/></a>";
			break;
		case "golden":
			print "<nobr>";
			print dots($this->val).$format.$gd;
			break;
		case "edit":
			print "<a href=\"$PHP_SELF?act=update&id=$r[0]&type=".($this->table->type)."\"><img src=\"$site_url"."images/engine/edit.png\" width=16px height=16px border=0 alt=\"".sysmessage(2)."\" title=\"".sysmessage(2)."\"/></a>";
			break;
		case "delete":
			print "<a href=\"$PHP_SELF?act=delete&id=$r[0]&step=1&type=".($this->table->type)."\" onclick=\"return confirm('".sysmessage(17)."')\"><img src=\"$site_url"."images/engine/drop.png\" width=16px height=16px border=0 alt=\"".sysmessage(1)."\" title=\"".sysmessage(1)."\"/></a>";
			break;

		case "up":
			print "<a href=\"$PHP_SELF?act=up&id=$r[0]&step=1&type=".($this->table->type)."\"><img src=\"$site_url"."images/engine/up1.gif\" width=12px height=12px border=0  /></a>";
			break;
		case "down":
			print "<a href=\"$PHP_SELF?act=down&id=$r[0]&step=1&type=".($this->table->type)."\"><img src=\"$site_url"."images/engine/down1.gif\" width=12px height=12px border=0 /></a>";
			break;

		case "remove":
			print "<a href=\"$PHP_SELF?act=remove&id=$r[0]&step=1&type=".($this->table->type)."\" onclick=\"return confirm('".sysmessage(17)."')\"><img src=\"$site_url"."images/engine/drop.png\" width=16px height=16px border=0 alt=\"".sysmessage(1)."\" title=\"".sysmessage(1)."\"/></a>";
			break;
		case "checkbox":
			print "<input class=\"checkbox\" type=\"checkbox\" name=\"".$this->name."[".($numrow-1)."]\"";
			if($r[$this->name]==1) print " checked";
			print "/>";
			break;
		case "radio":


			if($this->vals) $this->val=set_params($this->vals);

			print "<input  class=\"radio\" type=\"radio\" name=\"".$this->name."\"";
			print " value='$this->val'";

			if($this->val==$this->text) print " checked=1";

			print "/>";
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
		case "2dreport":
			if($r[Finished]) print "<a href=\"$site_url"."xml/tour/getmatch.php?id=".set_params("\$MatchID;")."\" target=_blank><img src=\"$site_url"."images/engine/goal.gif\" width=15px height=15px border=0/></a>";
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
			else print "<input type=\"hidden\" name=\"$this->name[".($numrow-1)."]\"/>";
			
		break;
		default:
			print $format.stripslashes($r[$name]);
			break;


	}



	print "</td>\n";

	}
	else print "<input type=\"hidden\" name=\"$this->name[".($numrow-1)."]\" $format value=\"$this->val\"/>";

	$this->value=$this->val;
	unset($this->val);

    }



}


function cut_end_word($word){ 
//������� ��������� ��������� �����, ����������� ����� ����� 4 �������, ���� ������, �� �� �������� 
        if (strlen($word)>=6) { 
            //������ ��������� ��������������, ��������������� 
          # $word=preg_replace('/(.*)(?:�|�|�|�|�|�|�|�|�|���|���|��|��|��|��|��)$/', "\1",$word); 
           if (preg_match('/(.*)(?:���|���|���|��|��|��|��|��|��|��)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
           else if (preg_match('/(.*)(?:�|�|�|�|�|�|�|�|�)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
        elseif (strlen($word)==5) { 
            //������ ��������� �������������� �������� ����, ��������������� 
           if (preg_match('/(.*)(?:��|��|��|��|��|��|��)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
           else if (preg_match('/(.*)(?:�|�|�|�|�|�|�|�|�)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
        elseif (strlen($word)==4) { 
            //������ ��������� ��������������� 
           if (preg_match('/(.*)(?:�|�|�|�|�|�|�|�|�)$/', $word, $m)) { 
              $word=$m[1]; 
           } 
        } 
   return $word; 
}

?>