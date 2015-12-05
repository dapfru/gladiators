<?php

//Отрисовка ищображений ключевого значения, случаенных 6-х символов ...  

$id=$_REQUEST['id'];

function transfer($string){
	$isostring = convert_cyr_string($string, "w", "i");
	for ($i=0; $i < strlen($isostring); $i++){
		$char=substr($isostring,$i,1);
		$charcode=ord($char);
		$unistring.=($charcode>175) ? "&#" . (1040+($charcode-176)). ";" : $char; 
	}
	return $unistring;

}
$seec=substr(md5($id."hgfjdj"),0,6);

mt_srand(time()*100000);
$mas_angle=array(-10,-5,10,9,-10,8);
shuffle($mas_angle);

//$seec - это любое кодовое слово... !! 

$reference=$_SERVER["DOCUMENT_ROOT"]."/cls/common/arial.ttf";

$obch_dlina=0; //Общая длина всех букв(цифр)

$size=15;
$counter=0;
$d_y=25;

$shirina_l=10;

$seec="$seec";
//анализатор...

for($i=0;$i<6;$i++){

	$prom_t=transfer($seec[$i]);

	if($i == 0){$measurTTF=imagettfbbox($size,$mas_angle[0],$reference,$prom_t);}
	if($i == 1){$measurTTF=imagettfbbox($size,$mas_angle[1],$reference,$prom_t);}
	if($i == 2){$measurTTF=imagettfbbox($size,$mas_angle[2],$reference,$prom_t);}
	if($i == 3){$measurTTF=imagettfbbox($size,$mas_angle[3],$reference,$prom_t);}
	if($i == 4){$measurTTF=imagettfbbox($size,$mas_angle[4],$reference,$prom_t);}
	if($i == 5){$measurTTF=imagettfbbox($size,$mas_angle[5],$reference,$prom_t);}
	
	$dlinax=$measurTTF[4]-$measurTTF[6];
	if($i == 0){
	$dlinay=$measurTTF[1]-$measurTTF[7];
	}
	$obch_dlina=$obch_dlina+$dlinax;

}





//print "$dlinay";


$im = imagecreatetruecolor($obch_dlina+10,$d_y);
//Меняем цвет....
$b_color=imagecolorallocate($im, 186, 174, 156);
$t_color = imagecolorallocate($im, 38, 60, 66);
$l_color = imagecolorallocate($im, 104, 113, 116);

imagefilledrectangle($im, 0,0,$obch_dlina+10,$d_y,$b_color);

$nach=-$d_y/2;
for($k=0; $k<4; $k++){

	for($i=0;$i < $shirina_l;$i++){

	
			imageline($im,$nach+$i, 0,$nach+$i+2* $shirina_l, $d_y,$l_color );
		 

	}
$nach=$nach + 2* $shirina_l;

}

for($i=0;$i<6;$i++){

	$prom_t=transfer($seec[$i]);

	
	if($i == 0){$measurTTF=imagettfbbox($size,$mas_angle[0],$reference,$prom_t);}
	if($i == 1){$measurTTF=imagettfbbox($size,$mas_angle[1],$reference,$prom_t);}
	if($i == 2){$measurTTF=imagettfbbox($size,$mas_angle[2],$reference,$prom_t);}
	if($i == 3){$measurTTF=imagettfbbox($size,$mas_angle[3],$reference,$prom_t);}
	if($i == 4){$measurTTF=imagettfbbox($size,$mas_angle[4],$reference,$prom_t);}
	if($i == 5){$measurTTF=imagettfbbox($size,$mas_angle[5],$reference,$prom_t);}
	$dlinax=$measurTTF[4]-$measurTTF[6];

	imagettftext($im,$size,$mas_angle[$i],(($obch_dlina+10)/2)-($obch_dlina/2)+$counter,$d_y/2+$dlinay/2,$t_color,$reference,$prom_t);

	$counter=$counter+$dlinax;
}
/*
print "$seec[0]<br>";

print "$obch_dlina<br>";


print "$dlinay<br>";
*/

imageline($im, 0, $d_y*1/3,$obch_dlina+10, $d_y*1/3,$l_color );
imageline($im, 0, $d_y*2/3,$obch_dlina+10, $d_y*2/3,$l_color );
imageline($im, 0, $d_y*1/2,$obch_dlina+10, $d_y*1/2,$l_color );
header("Content-type: image/png ");
imagepnG($im);


ImageDestroy($im);


?>