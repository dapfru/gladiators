<?
error_reporting(0);
header("Content-type: image/png");
function GetPic($id)
 { 
  $head="GET ".$id." HTTP/1.0\r\n";
  $head.="Accept: */*\r\n";
  $head.="Referer: http://passport.bigmir.net/icq\r\n";
  $head.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n";
  $head.="Host: ui.bigmir.net\r\n\r\n";
  if(!$sock=fsockopen("ui.bigmir.net",80)) return 0;
  fputs($sock, $head);	
  while(fgets($sock,2048)!="\r\n"&&!feof($sock));
  unset($pic);
  while (!feof($sock)) $pic.=fread($sock,1024);
  fclose($sock);   
  return $pic;
 }

$ret=GetPic(base64_decode($HTTP_GET_VARS["code"]));
if(strlen($ret)<1000||strpos($ret,"404 Not Found")!=0) readfile("error.png");
else echo $ret;
?>