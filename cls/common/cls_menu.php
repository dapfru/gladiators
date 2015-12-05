<?
Class cls_menu extends cls_root
{
var $position;
var $level;
var $icon;

/***********************************************************************
                        Инициализация класса
* ***********************************************************************/
function cls_menu($xml_url,$type)
    {
	global $elm,$engine_path,$site,$site_path;

	$this->level=$level;

	$xml_document = xml_contents($site_path."xml/".$site.$xml_url.".xml");

        if(!$xml_document) {print "$site_path"."xml/".$site.$type.".xml not found"; return false;}


	$toolbar[0]=$xml_document;
	$ar=explode("/",$type);
	foreach($ar as $tag)
	{
		//print "$tag<br>";
		if(!$toolbar = $toolbar[0]->getElementsByTagName($tag)) return false;
//print "error reading XML: $tag<br>";
	}

	$this->xml_document=$toolbar[0];


	foreach(get_class_vars(get_class($this)) as $name=>$val)
	{
	  if(strlen($v=$toolbar[0]->getAttribute($name,''))) $this->$name=$v;
	}

    }


    function Draw($level)
    {

     $this->Header();
     print "<tr bgcolor=".$this->rowcolor."";

	if($this->headerclass) print " class='$this->headerclass'";
	print ">";

	if(!$this->xml_document) return 0;

     $toolbaritems = $this->xml_document->getElementsByTagName("item");


        $j=0;

        for ($i=0;$i<count($toolbaritems);$i++)
        {
		$item= new cls_menuitems($toolbaritems[$i],$this);
		$item->Draw($level);
		if($this->position=="vertical"&&$i!=count($toolbaritems)-1) print "</tr><tr bgcolor=".$this->rowcolor.">";
        }
     $this->Footer();
    }

    function getMenu()
    {

	if(!$this->xml_document) return 0;

	$toolbaritems = $this->xml_document->getElementsByTagName("item");

        $j=0;

        for ($i=0;$i<count($toolbaritems);$i++)
        {
		$item= new cls_menuitems($toolbaritems[$i],$this);
		
		$ar[$i]="<a href=\"$item->name\">$item->caption</a>";
        }
	
	return $ar;
    }
}





Class cls_menuitems
{
 var $name;
 var $menu;
 var $vars;
 var $caption;
 var $fontcolor;

/***********************************************************************
                        Инициализация класса
* ***********************************************************************/
function cls_menuitems($elm,$menu)
    {

	$this->vars=array('caption','fontcolor');

	$this->menu=$menu;

	foreach($this->vars as $k)
	{
		if($v=$elm->getAttribute($k,'')) $this->$k=$v;
	}

	$this->name=$elm->getAttribute("name","no");

	if(!$this->caption) $this->caption=$elm->getAttribute("name",'');
    }

function Draw($level)
    {
	global $type,$act,$PHP_SELF;

	$ar1=explode("/",$type);

	if(!$pos=strpos($this->name,"=")) $ar=explode("/",$this->name);
	elseif(strstr($this->name,"/")) $ar=explode("/",substr($this->name,$pos+1));
	else  $ar=explode("act=",$this->name);

	if($pos=strpos($ar[count($ar)-1],"&"))
	{
		$a=substr($ar[count($ar)-1],$pos+5);
		$ar[count($ar)-1]=substr($ar[count($ar)-1],0,$pos);
	}

	$file1=substr($this->name,strrpos($this->name,"/"),strpos($this->name,".php")+4-strrpos($this->name,"/"));
	//$file2=substr($PHP_SELF,strrpos($PHP_SELF,"/"),strpos($PHP_SELF,".php")+4-strrpos($PHP_SELF,"/"));

//print $level." $file2==$file1&&$file1 len: ".strlen($ar[$level])."&&$ar1[$level]==$ar[$level])||($a==$act&&$act&&(".$ar1[$level]."==".$ar[$level].")))<br>";

	print "<td ";

	if($this->menu->align) print " align=".$this->menu->align." ";



	//if((strstr($PHP_SELF,$file1)&&$file1&&$act&&$act==$ar[1])||(strstr($PHP_SELF,$file1)&&$file1&&!$act)||(strlen($ar[$level])&&$ar1[$level]==$ar[$level])||($a==$act&&$act&&($ar1[$level]==$ar[$level]))) print "bgcolor=dddddd";

	print " >";

	print $this->menu->icon;


	//$this->caption=set_params($this->caption);

	if($this->name!=$type) print "<a href=\"".$this->name."\">";

	print $this->caption;
	print "</td>";
    }
}
?>