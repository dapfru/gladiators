<?
$type="products";
require("up.php");

if(!$id) $id='3';

$res=runsql("select p.*, p.Name_$lang as Name, p.Description_$lang as Description, t.Name_$lang as Type from ut_products p 
left outer join ut_product_types t using(TypeID) where ProductID=$id");

$r=mysql_fetch_array($res);

	print"
	<h3>".$r[Name]."</h3><br>
     	<h5>Класс: ".($r[Type])."</h5><br>";
	
	if ($r[Image]) print"<img src=\"$img_url?id=$r[ProductID]&record=9\"><br>";
        print settags($r[Description]);

require("bottom.php");

?>