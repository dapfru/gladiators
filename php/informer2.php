<?php
/**********************************************************
* Parse XML data into an array structure                 *
* Usage: array parse_rss ( string data )                 *
**********************************************************/


function parse_rss($reg_exp, $xml_data) {
   preg_match_all($reg_exp, $xml_data, $temp);


   return array(
       'count'=>count($temp[0]),
       'title'=>$temp[1],
       'link'=>$temp[2],
       'date'=>$temp[3],

   );
}

/**********************************************************
* Parse Array data into an HTML structure                *
* Usage: string parse_rss ( array data )                 *
**********************************************************/
function output_rss($pattern, $rss_data) {
	global $num;

foreach($rss_data as $k=>$v)
{
	if($k!="count")
	{
		foreach($v as $k1=>$v1)
		{
			
			if($k=="date") $ar[$k1]['realdate']=$v1;
			if($k=="date") $v1=strtotime((string)($v1));
			$ar[$k1][$k]=$v1;

		}
	}
	
}

$rss_data=$ar;

usort($rss_data, array(new CompareByDesc, "date"));

$i=0;
   foreach($rss_data as $k=>$v) {
	$i++;
       $temp .= sprintf($pattern,
           $v['link'],
           html_entity_decode($v['title']),
		html_entity_decode($v['date']),
		html_entity_decode($v['realdate'])



  
       );
	if($i==5) break;


   }
	$temp=str_replace("<![CDATA[","",$temp);
	$temp=str_replace("]]>","",$temp);

   return $temp;
}

class CompareBy {
   function __call($col, $args) {
      return strcmp($args[0][$col], $args[1][$col]);
   }
}

class CompareByDesc {
   function __call($col, $args) {
      return strcmp($args[1][$col], $args[0][$col]);
   }
}


/**********************************************************
* Settings                                               *
**********************************************************/

$url = 'http://forum.gladiators.ru/index.php?act=rssout&id=2';

$reg_exp  = '#<item>.*?.*?';
$reg_exp .='<title>(.*?)<\/title>.*?';
$reg_exp .='<link>(.*?)<\/link>.*?';
$reg_exp .='<pubDate>(.*?)<\/pubDate>.*?';
//$reg_exp .='.*?';
$reg_exp .='<\/item>#si';

$pattern ='   <tr>
                                <td width="20" align="left" valign="top"><img src=/images/marker3.gif width=11px height=11px> </td>
                                <td align="left" valign="top"><a href="%s" target=_blank><b>%s</b></a><br><br></td></tr>';


//ereg_replace("+0400", "df", $pattern); 

/**********************************************************
* Main script                                            *
**********************************************************/
if ( $xml_data = file_get_contents($url) ) {

   $rss_data = parse_rss($reg_exp, $xml_data);

	$file=fopen("/var/www/gladiators.ru/php/informer2.html","w");
	fputs($file,$str=output_rss($pattern, $rss_data));
	fclose($file);
   echo $str;
}
/**********************************************************
* The END                                                *
**********************************************************/
?>
