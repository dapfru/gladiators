<?php
//    $neediconv = true;
//    $fromcodepage= "utf-8";
//    $tocodepage= "cp1251";

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

                if (!is_array($this->nodes[$tmp]->attributes)) $this->nodes[$tmp]->attributes = array();


                        $this->nodes[$tmp]->text = @$this->values[$i]['value'];


	if ($this->neediconv)
          //$this->nodes[$tmp]->text=iconv($this->fromcodepage,$this->tocodepage,$this->nodes[$tmp]->text);

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
		global $test,$idn,$site,$id,$PageID,$TagID,$updateid,$upcount;

		$upcount=0;

		$q=select("select PageID from en_pages where Type='$type' and Site='$site'");
		$PageID=$q[0];



		$q=select("select TagID from en_tags where Act='$tag' and PageID='$q[0]'");
		$TagID=$q[0];

        	$nodes =  &$this->ownerDocument->nodes;

		for($i=0; $i<count($nodes);$i++)
        	{


	 	 	$a=$this->ownerDocument->nodes[$i];

			if($a->tagname=="form"&&$tag)
			{

				$str=strtolower($a->tagname);
				$str.=$this->childAttributes($i);
				$name_rus=addslashes($a->attributes['title_rus']);

			//if ($this->neediconv) $name_rus=iconv($this->fromcodepage,$this->tocodepage,$name_rus);

				$name_eng=addslashes($a->attributes['title_eng']);
				$name_ger=addslashes($a->attributes['title_ger']);

				$str=addslashes($str);

			//	if ($this->neediconv) $str=iconv($this->fromcodepage,$this->tocodepage,$str);

				$sql="insert into en_pages(Name_rus,Name_eng,Name_ger,Site,Type,Xml,Date) 
					values('$name_rus','$name_eng','$name_ger','$site','$type','$str',unix_timestamp()) 
					on duplicate key update Name_rus='$name_rus',Name_eng='$name_eng',Name_ger='$name_ger',Xml='$str',Date=unix_timestamp()";
				mysql_query($sql);

if($test) print $sql;
				if(mysql_insert_id()) $PageID=mysql_insert_id();

						if(mysql_error()) print "$sql<br>".mysql_error();
				$str="";
				$idn=mysql_insert_id();
			}
			elseif(!$tag||($a->tagname==$tag || ($level&&($a->level)>$level)))
			{

				if(!$level) $level=$a->level;

				$str.="#?;".strtolower($a->tagname);
				$str.=$this->childAttributes($i);
				


			}
			elseif($level&&(($a->level)<=$level)) break;


	        }

	//if ($this->neediconv) $str=iconv($this->fromcodepage,$this->tocodepage,$str);

	$str=addslashes($str);

	if(!$idn) $idn=$id;
	if($str&&$tag) 
	{

		mysql_query("insert into en_tags(Act,Xml,PageID) values('$tag','$str','$idn')
					on duplicate key update Xml='$str'");

		if(mysql_insert_id()) $TagID=mysql_insert_id();
	}
	elseif(!$tag) 
	{

		mysql_query("insert into en_pages(Name_rus,Name_eng,Name_ger,Site,Type,Xml,Date) 
					values('Шаблоны','Templates','Templates','$site','$type','$str',unix_timestamp())
					on duplicate key update Name_rus='$name_rus',Name_eng='$name_eng',Name_ger='$name_ger',Xml='$str',Date=unix_timestamp()");

		if(mysql_insert_id()) $PageID=mysql_insert_id();
	}
		//if(mysql_error) print "$sql<br>".mysql_error();

	foreach($updateid as $v)
	{
		if($PageID) mysql_query("update lk_xml set PageID='$PageID' where TextID='$v'");
		if($TagID) mysql_query("update lk_xml set TagID='$TagID' where TextID='$v'");
	}




	}



	function childAttributes($j)
	{
		global $PageID,$TagID,$updateid,$upcount;


		$ar=&$this->ownerDocument->nodes[$j]->attributes;

		
		foreach($ar as $k=>$v)
		{
			if(strstr($k,"_")) 
			{

				$lng=substr($k,strrpos($k,"_")+1);
				$name=substr($k,0,strrpos($k,"_"));

				//$lng=substr($k,strlen($k)-3);

				//$name=substr($k,0,strlen($k)-4);

				if($lng=="code") $mas[$name]=$v;
				elseif(strlen($lng)==3)
				{
					$val=addslashes($v);
					if($mas[$name]&&$v) 
					{
						mysql_query("insert into lk_xml(TextID,$lng,PageID,TagID) values('".$mas[$name]."','$val','$PageID','$TagID') on duplicate key update  $lng='$val',PageID='$PageID',TagID='$TagID'");
						if($mas[$name]) $updateid[$upcount]=$mas[$name];
						else $updateid[$upcount]=mysql_insert_id();
						$upcount++;
					}
					elseif($v)
					{
						//$q=select("select TextID from lk_xml where $lng='$val'");
						//if($q[0]) 
						//{
						//	$mas[$name]=$q[0];
						//	$str.="|?;".$name."_code|?;".$mas[$name];
						//}
						//else
						//{

							mysql_query("insert into lk_xml($lng,PageID,TagID) values('$val','$PageID','$TagID')");
							$mas[$name]=mysql_insert_id();
							$updateid[$upcount]=$mas[$name];
							$upcount++;

							$str.="|?;".$name."_code|?;".$mas[$name];
						//}
					}
				}


				if(!$ar[$name."_ger"]) 
				{
					$k1=$name."_ger";
					$v1=$ar[$name."_eng"];
					$val=addslashes($v1);
					if($val) $q=select("select ger from lk_xml where eng='$val'");
					else unset($q);

					if($q[0]) $v1=addslashes($q[0]);

					if($v1)
					{
						//mysql_query("insert into lk_xml($lng,PageID,TagID) values('$v1','$PageID','$TagID')");
						//$str.="|?;".strtolower($k1)."|?;$v1";
						$ar[$name."_ger"]=$v1;
					}

				}
			}


			if(!strstr($k,"_")||substr($k,strrpos($k,"_")+1)=="code") $str.="|?;".strtolower($k)."|?;$v";
		}

	//	foreach($mas as $name=>$code)
		{
			$q=select("select * from lk_xml where TextID='$code'");
			
			$str.="|?;".strtolower($name)."_rus|?;$q[rus]";
			$str.="|?;".strtolower($name)."_eng|?;$q[eng]";
			$str.="|?;".strtolower($name)."_ger|?;$q[ger]";
		}

		$text=trim(&$this->ownerDocument->nodes[$j]->text);
		if(strlen($text)) 
		{


			//if ($this->neediconv) $text=iconv($this->fromcodepage,$this->tocodepage,$text);
		//	if ($this->neediconv) $text=iconv($this->tocodepage,$this->fromcodepage,$text);

//print $text;
//exit;
			$str.="|?;text|?;$text";

		}




		return($str);
	}


	function Translate($type,$tag)
	{
		global $site;

        	$nodes =  &$this->ownerDocument->nodes;


		for($i=0; $i<count($nodes);$i++)
        	{

			$this->TranslateAttributes($i);


	        }

	}



	function TranslateAttributes($j)
	{
		global $PageID,$TagID,$updateid,$upcount;


		$ar=&$this->ownerDocument->nodes[$j]->attributes;

		
		foreach($ar as $k=>$v)
		{
			if(strstr($k,"_")) 
			{

				$lng=substr($k,strrpos($k,"_")+1);
				$name=substr($k,0,strrpos($k,"_"));

				if($lng=="rus"&&($ar[$name."_eng"]||$ar[$name."_ger"])) 
				{
$v=iconv($this->fromcodepage,$this->tocodepage,$v);

					$v2=$ar[$name."_eng"];
					$v3=$ar[$name."_ger"];
					

					$v=addslashes($v);
					$v2=addslashes($v2);
					$v3=addslashes($v3);


mysql_query("update lk_xml set rus='$v' where eng ='$v2'");
mysql_query("update lk_xml set rus='$v' where ger ='$v3'");

$v2=str_replace("<","&lt;",$v2);
$v2=str_replace(">","&gt;",$v2);
mysql_query("update lk_xml set rus='$v' where eng ='$v2'");
mysql_query("update lk_xml set rus='$v' where ger ='$v3'");

				}

if($lng=="rus"&&!$ar[$name."_eng"]&&!$ar[$name."_ger"]&&$ar[$name."_rus"])
{
//$v=iconv($this->fromcodepage,$this->tocodepage,$v);

//	print $ar[$name."_ger"]." $v ".$name."_eng";
//exit;
}

			}


		}

	}


}

?>