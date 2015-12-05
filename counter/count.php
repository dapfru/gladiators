<?
//exit;
		//подключемся к базе для просмотра посешений
	$query = "SELECT * FROM top_sites where SiteID=".$id."";
	$result = MYSQL_QUERY($query);
	$rw = mysql_fetch_array($result);

		//кол-во хостов сегодня
	$hostdate = $rw["Hosts"];
		//кол-во хитов сегодня
	$hitdate = $rw["Hits"];
		//всего хитов

	$guild = $rw["GuildID"];


	$top_pix = $rw["ImageID"];

	$color1 = $rw["Color1"];
	$color2 = $rw["Color2"];
	$bordercolor = $rw["BorderColor"];

	if(!$color1) $color1="3B484C";
	if(!$color2) $color2="0C0E0F";
	if(!$bordercolor) $bordercolor="56666B";

function string_size($string)
        {
        if (strlen($string) == "1") { $string = "         $string"; }
        if (strlen($string) == "2") { $string = "        $string"; }
        if (strlen($string) == "3") { $string = "       $string"; }
        if (strlen($string) == "4") { $string = "      $string"; }
        if (strlen($string) == "5") { $string = "     $string"; }
        if (strlen($string) == "6") { $string = "    $string"; }
        if (strlen($string) == "7") { $string = "   $string"; }
        if (strlen($string) == "8") { $string = "  $string"; }
        if (strlen($string) == "9") { $string = " $string"; }
        if (strlen($string) == "10") { $string = "$string"; }
        if (strlen($string) > "10") { $string = "1234567890"; }

        return $string;
        }

if(!$hostdate) $hostdate=0;
if(!$hitdate) $hitdate=0;


$hostdate = string_size($hostdate);
$hitdate = string_size($hitdate);

header("Content-Type:image/png"); 
header('Cache-control: no-cache');

$image=imagecreatetruecolor(88,31);

$width=88;
$height=31;

$belty=1;
$beltheight=9;


$col=$color1;

$prired=hexdec("0x".substr($col,0,2));
$prigreen=hexdec("0x".substr($col,2,2));
$priblue=hexdec("0x".substr($col,4,2));



$primary=imagecolorallocate($image, $prired,$prigreen,$priblue);

$col=$color2;

$prired=hexdec("0x".substr($col,0,2));
$prigreen=hexdec("0x".substr($col,2,2));
$priblue=hexdec("0x".substr($col,4,2));

$secondary=imagecolorallocate($image, $prired,$prigreen,$priblue);

imagefilledrectangle($image,0,0,$width,$height,$primary);
imagefilledrectangle($image,0,$belty,$width,$belty+$beltheight,$secondary);

$fcol = imagecolorallocate($image, 0,0,0);

$imgname="gladiators.png";
$label = imagecreatefrompng($imgname);
imagecopy($image,$label,28,2,0,0,imagesx($label),imagesy($label));

if(!$top_pix) $top_pix=1;

if($guild)
{
	$imgname = "../images/gd_guilds/small/$guild.jpg";
	$logo = imagecreatefromgif($imgname);
	imagecopy($image,$logo,2+(20-imagesy($logo))/2,(31-imagesy($logo))/2,0,0,imagesx($logo),imagesy($logo));
}
else
{
	$imgname = "../counter/pix/".$top_pix.".png";
	$logo = imagecreatefrompng($imgname);
	imagecopy($image,$logo,0,0,0,0,imagesx($logo),imagesy($logo));
}



$col="E5CEA6";
$col="FFB636";

$prired=hexdec("0x".substr($col,0,2));
$prigreen=hexdec("0x".substr($col,2,2));
$priblue=hexdec("0x".substr($col,4,2));

$color=imagecolorallocate($image, $prired,$prigreen,$priblue);




ImageString($image, 1, 36, 20, "$hostdate", $color);
ImageString($image, 1, 36, 12, "$hitdate", $color);


$bordercolor=hexdec($bordercolor);

imagerectangle($image,0,0,$width-1,$height-1,$bordercolor);



ImagePNG ($image); 
ImageDestroy ($image);
?>