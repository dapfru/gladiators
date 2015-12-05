<?php

require("../../config.php");




if($dbname) mysql_select_db($dbname);

if($record) 
{
	$res=mysql_query("select * from en_table_images where RecordID='$record'");
	$r=mysql_fetch_array($res);

	$format=$r[Format];



}
else 
{


	$res=mysql_query("select * from en_table_images where TableName='$table'");
	unset($r1);
	while($r=mysql_fetch_array($res))
	{
		if($r[FieldName]=="Small") $r1=$r;
		if($r[FieldName]=="Logo") $r2=$r;
		else $r3=$r;
	}


	if($r1[0]) $r=$r1;
	elseif($r2[0]) $r=$r2;
	else $r=$r3;

	$format=$r[Format];

}

$var=$r[FieldName];


	$res=mysql_query("select * from $r[TableName] where $r[IDName]='$id'");

	$r=mysql_fetch_array($res);


unset($table);


if(!$format) $format="jpeg";


header("Content-type: image/$format");

header('Content-Length: '.strlen($r[$var]));


if($r[ImageDate]) header('Last-Modified: '.gmdate('D, d M Y H:i:s',$r[ImageDate]).' GMT');

header('Cache-control: public');



print $r[$var];

$db->close();
?>