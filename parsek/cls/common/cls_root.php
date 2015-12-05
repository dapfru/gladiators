<?

/***********************************************************************
                        –одительский класс
* ***********************************************************************/

Class cls_root
{
 var $xml_document;

 var $type;
 var $width;
 var $height;
 var $border=0;
 var $bgcolor="888888";
 var $rowcolor="ffffff";
 var $hcolor="FFC51C";
 var $cellspacing="1";
 var $cellpadding="3";
 var $pagecount=20;
 var $numrows;
 var $maxcount;
 var $pages=1;
 var $maxpages=30;
 var $mixcolor="f3f3f3";
 var $headerbg="/images/table-yellow-gradient.png";
 var $headerclass="black";
 var $align;

    //функци€ не используетс€-------------
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



	if($this->document&&$this->document->getElementsByTagName("button")) 
	{
		print "</form>";
	}


	print "</table>\n";
    }


    function Pages($cnum,$notable)
    {

	global $page,$QUERY_STRING,$sort,$type,$where,$act,$id,$class;

	$this->type=$type;

	if($page) $curpage=$page; //текуща€ страница
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
	else $page=1; //перва€ страница


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