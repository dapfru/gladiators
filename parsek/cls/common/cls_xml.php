<?php
//    $neediconv = true;
//    $fromcodepage= "utf-8";
//    $tocodepage= "cp1251";
//версия бутсы от 2.8.6

Class cls_xml extends cls_node
{
    var $parser;
    var $values = array();
    var $indexes =array();
    var $documentElement;
    var $nodes = array();

    var $neediconv = true;
    var $fromcodepage= "utf-8";
    var $tocodepage= "cp1251";

/***********************************************************************
                                        Инициализируем класс
                                        * если на входе есть xml-строка,
                                        строка сразу парсится и возвращает 2 массива
***********************************************************************/
    function cls_xml()
    {
                   $this->indexes =array();
                $this->values = array();

        if (func_num_args()==1)
        {
                $data = func_get_arg(0);
        $this->loadxml($data);
                }
        elseif (func_num_args()==0)
        {
                return true;
        }
        else
        {
                return false;
        }
    }

// -------------------- Читает xml из файла
        function load($filepath)
        {
                $data = implode("",file($filepath));
                $this->loadxml($data);
        }
    function createElement()
    {
            return new cls_node();
    }
// -------------------- Читает xml из строки
        function loadxml($xmlstring)
        {

                $this->parser = xml_parser_create();
                xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING,0);
            xml_parser_set_option($this->parser,XML_OPTION_SKIP_WHITE,1);
                xml_set_object($this->parser, &$this);
                xml_parse_into_struct($this->parser, $xmlstring, $this->values, $this->indexes);
                xml_parser_free($this->parser);

        $parents = array();
        array_push($parents, 0);
        $relation = array();
        for ($i=0; $i<count($this->values); $i++)
        {

            if ((@$this->values[$i]['type']!="close") && (@$this->values[$i]['type']!="cdata"))
            {
                    $childNode = new cls_node();
                    $tmp = array_push($this->nodes, $childNode);
                    $tmp--;

                    $this->nodes[$tmp]->attributes = @$this->values[$i]['attributes'];
//print "--- ".count($this->nodes[$tmp]->attributes)."<br> ";
                if (!is_array($this->nodes[$tmp]->attributes)) $this->nodes[$tmp]->attributes = array();


                        $this->nodes[$tmp]->text = @$this->values[$i]['value'];

	if ($this->neediconv)
          $this->nodes[$tmp]->text=iconv($this->fromcodepage,$this->tocodepage,$this->nodes[$tmp]->text);

                        $this->nodes[$tmp]->tagname = @$this->values[$i]['tag'];
                        $this->nodes[$tmp]->level = @$this->values[$i]['level'];
                        $this->nodes[$tmp]->parentNodeId = $parents[count($parents)-1];
                        $this->nodes[$tmp]->ownerDocument = &$this;
                        $this->nodes[$tmp]->id = $i+1;
                        $relation[$i] = &$this->nodes[$tmp];
            }
            if (@$this->values[$i]['type']=="open")
            {
                        array_push($parents, $i+1);
            }
            if (@$this->values[$i]['type']=="cdata")
            {

//             $this->nodes[$this->indexes[$this->values[$i]["tag"]][0]]->text = @$this->values[$i]['value'];

               $relation[$this->indexes[$this->values[$i]["tag"]][0]]->text.= @$this->values[$i]['value'];
            }
            if (@$this->values[$i]['type']=="close")
            {
                        array_pop($parents);
            }
        }
        unset($relation);
        $this->documentElement = &$this->nodes[0];
        }
    //-----------------------------------------
        //        Возвращает коллекцию своих нодов
    //-----------------------------------------
    function &nodes($index=0)
    {
       return $this->nodes;
    }
    //-----------------------------------------
        //        Возвращает коллекцию своих индексов
    //-----------------------------------------
    function &indexes($tagname="")
    {
       return $this->indexes;
    }

}


Class cls_node
{
             var $attributes = array();
             var $text;
             var $tagname;
             var $level;
             var $parentNodeId;
             var $id;
             var $ownerDocument;
             var $neediconv = true;
             var $fromcodepage= "utf-8";
             var $tocodepage= "cp1251";



    function cls_node()
    {
    }


    function getElementsByTagName($name)
    {
        $toreturn = array();
        $forsearch = array();
        array_push($forsearch, $this->id);

        $nodes =  &$this->ownerDocument->nodes();
        $i=0;
        for ($i=0; $i<count($nodes);$i++)
        {

            if (($nodes[$i]->tagname==$name) && (in_array($nodes[$i]->parentNodeId, $forsearch)!=false))
            {
                array_push($toreturn, &$this->ownerDocument->nodes[$i]);
                array_push($forsearch, $nodes[$i]->id);
            }

        }
                return $toreturn;
    }
    function selectNodes($nodename)
    {
            $toreturn = array();
        $nodes =  &$this->ownerDocument->nodes;
        for ($i=0; $i<count($nodes);$i++)
        {
                if (($nodes[$i]->tagname==$nodename) && ($nodes[$i]->parentNodeId==$this->id))
            array_push($toreturn, $this->ownerDocument->nodes[$i]);
        }
        return $toreturn;
    }



    function getAttribute($name,$lng)
    {
	global $lang;

	if(!$lng) $lng=$lang;
	if($lng=="no") unset($lng);


	if($lng) $lname="$name"."_"."$lng";
	else $lname=$name;

	$ename="$name"."_"."eng";

        if (array_key_exists($lname, $this->attributes))
        {
                $str= $this->attributes[$lname];
        }

        if(!$str&&array_key_exists($ename, $this->attributes))
        {
		//$str=$this->attributes[$ename]
                if($str=$this->attributes[$ename]) $str="<b>!</b>".$str;
        }

        if(!$str&&array_key_exists($name, $this->attributes))
        {
                $str= $this->attributes[$name];
        }

	if ($this->neediconv)
          $str=iconv($this->fromcodepage,$this->tocodepage,$str);

	return $str;
    }



	function childNodes()
	{
	 	$toreturn = array();
        	$nodes =  &$this->ownerDocument->nodes;
		for ($i=0; $i<count($nodes);$i++)
        	{
                	if ($nodes[$i]->parentNodeId==$this->id)
			array_push($toreturn, $this->ownerDocument->nodes[$i]);
	        }
        	return $toreturn;
	}


	function Xml2File($type,$tag)
	{
		global $site;

        	$nodes =  &$this->ownerDocument->nodes;


		for($i=0; $i<count($nodes);$i++)
        	{


	 	 	$a=$this->ownerDocument->nodes[$i];

			if($a->tagname=="form"&&$tag)
			{
				$str=strtolower($a->tagname);
				$str.=$this->childAttributes($i);
				$name_rus=addslashes($a->attributes['title_rus']);

				if ($this->neediconv) $name_rus=iconv($this->fromcodepage,$this->tocodepage,$name_rus);

				$name_eng=addslashes($a->attributes['title_eng']);
				$name_ger=addslashes($a->attributes['title_ger']);

				$str=addslashes($str);

				if ($this->neediconv) $str=iconv($this->fromcodepage,$this->tocodepage,$str);

				$sql="insert into en_pages(Name_rus,Name_eng,Name_ger,Site,Type,Xml,Date) 
					values('$name_rus','$name_eng','$name_ger','$site','$type','$str',unix_timestamp()) 
					on duplicate key update Name_rus='$name_rus',Name_eng='$name_eng',Name_ger='$name_ger',Xml='$str',Date=unix_timestamp()";
				mysql_query($sql);

						if(mysql_error()) print "$sql<br>".mysql_error();
				$str="";
				$id=mysql_insert_id();
			}
			elseif(!$tag||($a->tagname==$tag || ($level&&($a->level)>$level)))
			{

				if(!$level) $level=$a->level;

				$str.="#?;".strtolower($a->tagname);
				$str.=$this->childAttributes($i);
				


			}
			elseif($level&&(($a->level)<=$level)) break;


	        }

	if ($this->neediconv) $str=iconv($this->fromcodepage,$this->tocodepage,$str);

	$str=addslashes($str);


	if($str&&$tag) mysql_query("insert into en_tags(Act,Xml,PageID) values('$tag','$str','$id')
					on duplicate key update Xml='$str'");
	elseif(!$tag) mysql_query("insert into en_pages(Name_rus,Name_eng,Name_ger,Site,Type,Xml,Date) 
					values('Шаблоны','Templates','Templates','$site','$type','$str',unix_timestamp())
					on duplicate key update Name_rus='$name_rus',Name_eng='$name_eng',Name_ger='$name_ger',Xml='$str',Date=unix_timestamp()");
		//if(mysql_error) print "$sql<br>".mysql_error();


	}



	function childAttributes($j)
	{


		$ar=&$this->ownerDocument->nodes[$j]->attributes;

		foreach($ar as $k=>$v)
		{
			$str.="|?;".strtolower($k)."|?;$v";
		}

		$text=trim(&$this->ownerDocument->nodes[$j]->text);
		if(strlen($text)) 
		{
			if ($this->neediconv) $text=iconv($this->fromcodepage,$this->tocodepage,$text);
			$str.="|?;text|?;$text";
		}




		return($str);
	}




}

?>