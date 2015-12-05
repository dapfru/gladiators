<?
require("config.php");

$dh = opendir($site_path."/files/gam/");

while($file = readdir($dh)) 
{


	if($file!="."&&$file!=".."&&(strstr($file,".gam")||strstr($file,".res")||strstr($file,".rep")))
	{
		$id=substr($file,0,strpos($file,"."));
		$ext=substr($file,1+strpos($file,"."),3);

		$fname=gampath($id)."/".$id.".$ext";
		if(!file_exists(gampath($id))) mkdir_r(gampath($id));
//print "copy($site_path /files/gam/ .$file,$fname)";
		copy($site_path."files/gam/".$file,$fname);
//if($id!=1516) exit;
	}
}


?>