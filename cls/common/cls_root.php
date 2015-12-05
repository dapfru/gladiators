<?

/***********************************************************************
                        Родительский класс
* ***********************************************************************/

Class cls_root
{
 var $xml_document;

 var $type;
 var $width;
 var $height;
 var $border=0;
 var $bgcolor="#78746C";
 var $rowcolor="#545E61";
 var $hcolor="#687174";
 var $cellspacing="1";
 var $cellpadding="4";
 var $pagecount=20;
 var $numrows;
 var $maxcount;
 var $pages=1;
 var $maxpages=30;
 var $mixcolor="";
 var $headerbg="";
 var $headerclass="header";
 var $align;
    //функция не используется-------------
    function root($tag)
    {

	$item=xml_contents("xml/common/root.xml");


	$table = $item->getElementsByTagName($tag);

	$this->xml_document=$table[0];

	foreach(get_class_vars(get_class($this)) as $val=>$name)
	{
 	  if(strlen($v=$table[0]->getAttribute($name))) $this->$name=$v;
	}

    }

    function Header()
    {
	global $id,$PHP_SELF,$QUERY_STRING,$_SERVER;


if($this->mode==1)
{
	$header = $this->document->getElementsByTagName("header");
	if($header[0]) $this->style=$header[0]->getAttribute("style",'');
	if(!$header[0]&&$this->act=="select") return false;
	print settags($header[0]->text);
}
else 
{
	$this->style=$this->attributes['header']['style'];
	if(strlen($this->attributes['header']['text'])) print settags($this->attributes['header']['text']);


}

	$act=$this->name;

if($this->mode==1)
{
	$buttons = $this->document->getElementsByTagName("button");
	if($buttons[0])
	{
		if($buttons[0]->getAttribute("act",'')) $act=($buttons[0]->getAttribute("act",''));
	}
}
else
{
	$buttons=count($this->attributes['button']);
	$act1=reset($this->attributes['button']);
	if($act1=$act1['act']) $act=$act1;

}

	$action="$PHP_SELF?type=$this->type&act=$act";

	if($buttons) 
	{

		$method="post";
		if($this->act=="search") $method="get";


		print "\n<form name=\"$this->name\" method=\"$method\" ";

//например переход на WM
		if($this->action&&strstr($this->action,"http")) $action=$this->action;
		else print "enctype=\"multipart/form-data\"";

		//if(!strstr($action,"http://")&&substr($action,0,1)=="/") $action="http://".$_SERVER['SERVER_NAME'].$action;

		if(!$firstpage) $firstpage=$PHP_SELF."?".$QUERY_STRING;

		print " action=\"$action\">";



		print "<input type=\"hidden\" name=\"step\" value=\"1\"/>
		<input type=\"hidden\" name=\"type\" value=\"$this->type\"/>

		<input type=\"hidden\" name=\"firstpage\" value=\"$firstpage\"/>

		<input type=\"hidden\" name=\"act\" value=\"".$this->name."\"/>";
	}

	//передаем дальше параметр $id--------------
	if($id) print "<input type=\"hidden\" name=\"id\" value=\"$id\"/>\n";



	print "<table border=".$this->border;
	if(strlen($this->height)) print " height=".$this->height;
	if(strlen($this->width)) print " width=".$this->width;
	if(strlen($this->bgcolor)) print " bgcolor=".$this->bgcolor;
	if(strlen($this->cellspacing)) print " cellspacing=".$this->cellspacing; 
	if(strlen($this->cellpadding)) print " cellpadding=".$this->cellpadding;

	if(strlen($this->style)) print " $this->style";
	print ">\n";
    }

    function Footer()
    {



	//if($this->mode==1&&$this->document&&$this->document->getElementsByTagName("button") || $this->attributes['button']) 
	//{
		//print "</form>";
	//}


	print "</table>\n";

	if(count($this->attributes['button'])) print "</form>";
    }


    function Pages($notable)
    {

	global $page,$QUERY_STRING,$sort,$type,$where,$act,$id,$class;

	if(!$this->maxpages) return '';
	
	$this->type=$type;

	if($page) $curpage=$page; //текущая страница
	else {$curpage=1;$cp=1;}

	$pagecount=$this->pagecount; //шаг страницы

	$max=$this->maxcount; //ограничение страниц



	$num=$this->numrows; //число записей

	$start=0; //начало отсчета
	$count=$pagecount;



  		 if($num>$pagecount&&$pagecount) 
  		 {

	if(!$notable) print "\n<tr bgcolor=\"".$this->hcolor."\"><td colspan=$cnum>\n";

	if($page>$this->maxpages) 
	{
		$page=1+($page-$page%$this->maxpages);
		$prevpage=$page-$this->maxpages;
		$this->maxpages=$page+$this->maxpages-1;
		print "<a href=\"$PHP_SELF?page=$prevpage&type=$this->type$str\">(..)</a> ";

	}
	else $page=1; //первая страница


	if($max&&($num>$max)) $num=$max;

	if($sort) $str="&sort=$sort";
	if($class) $str="&class=$class";
	if($id&&!strstr($QUERY_STRING,"id=")) $str.="&id=$id";


	while($count<($num+$pagecount)&&$page<=$this->maxpages)
	{

		if($count>=$num) $count=$num;

		if($curpage!=$page) 
		{
 			if(!$cp) print "<a href=\"$PHP_SELF?".str_replace("page=$curpage","page=".($page),$QUERY_STRING)."$str\">";
			else  print "<a href=\"$PHP_SELF?page=$page&type=$this->type$str&$QUERY_STRING\">";
		}

		if(!$this->pages) print "$start-$count"; 
		else print "$page";

		if($curpage!=$page) print "</a>\n";

		if($count<$num) { print " | ";}
		$start=$count;
		$count=$count+$pagecount;
		$page++; 

	}

	if($num>$pagecount*$this->maxpages) print " <a href=\"$PHP_SELF?page=".($this->maxpages+1)."&type=$this->type&act=$act$str\">(..)</a>";

	if(!$notable) print "</td></tr>\n";
	else print " ";

  		 }
    }
}
?>