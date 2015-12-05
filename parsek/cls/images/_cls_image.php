<?

//28.07.06

function LoadGif ($imgname) {

	$im = @imagecreatefromgif ($imgname); /* попытка открыть */

	if (!$im) 
	{ 
		$im = imagecreate (150, 30); /* создание пустого изображения */
		$bgc = imagecolorallocate ($im, 255, 255, 255);
		$tc = imagecolorallocate ($im, 0, 0, 0);
		imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
        
        	imagestring ($im, 1, 5, 5, "Error loading $imgname", $tc);
	}

	return $im;
}

function gif2jpeg($p_fl, $p_new_fl='', $bgcolor=false)
{

  list($wd, $ht, $tp, $at)=getimagesize($p_fl);

  $img_src=imagecreatefromgif($p_fl);
  $img_dst=imagecreatetruecolor($wd,$ht);

  if(!$bgcolor) $bgcolor="ffffff";

  $bgcolor=str_replace("#","",$bgcolor);
  $clr['red'] = hexdec( substr($bgcolor, 0, 2) );
  $clr['green'] = hexdec( substr($bgcolor, 2, 2) );
  $clr['blue'] = hexdec( substr($bgcolor, 4, 2) );

  $kek=imagecolorallocate($img_dst,$clr['red'],$clr['green'],$clr['blue']);

  imagefill($img_dst,0,0,$kek);
  imagecopyresampled($img_dst, $img_src, 0, 0,  0, 0, $wd, $ht, $wd, $ht);

  $draw=true;
  if(strlen($p_new_fl)>0)
  {
	if($hnd=fopen($p_new_fl,'w'))
	{
		$draw=false;
		fclose($hnd);
	}
  }

  if(true==$draw)
  {
	header("Content-type: image/jpeg");
	imagejpeg($img_dst);
  }
  else imagejpeg($img_dst, $p_new_fl);

  imagedestroy($img_dst);
  imagedestroy($img_src);

}

Class cls_image
{
var $file;
var $image;
var $name;
var $type;
var $imtype;
var $mix;
var $width;
var $height;
var $maxwidth;
var $maxheight;
var $newWidth = 160;
var $newHeight = 120;
var $permitted= array("image/png","image/jpeg","image/pjpeg","image/gif","image/x-png");
var $maxsize;
var $size;
var $contents;
var $fix;
var $mixpos;

  function cls_image($file)
  {
	global $er;

	$this->image=$file['tmp_name'];
	list($this->width, $this->height, $tp, $at)=getimagesize($this->image);

	$this->file=$file;

	$this->imtype=$file[type];
	$this->name=$file[name];


	$parts = explode("/",$file[type]);
	$this->type=$parts[1];

	$this->size=$file[size];

	$fil=fopen($this->image,"r");
	$this->contents=fread($fil,filesize($this->image));    




  }

  function gif2jpeg($bgcolor=false)
  {
	$p_fl=$this->image;

  	list($wd, $ht, $tp, $at)=getimagesize($p_fl);

  	$img_src=imagecreatefromgif($p_fl);
  	$img_dst=imagecreatetruecolor($wd,$ht);

  	if(!$bgcolor) $bgcolor="ffffff";

 	$bgcolor=str_replace("#","",$bgcolor);
 	$clr['red'] = hexdec( substr($bgcolor, 0, 2) );
  	$clr['green'] = hexdec( substr($bgcolor, 2, 2) );
  	$clr['blue'] = hexdec( substr($bgcolor, 4, 2) );

	$kek=imagecolorallocate($img_dst,$clr['red'],$clr['green'],$clr['blue']);

 	imagefill($img_dst,0,0,$kek);
	imagecopyresampled($img_dst, $img_src, 0, 0,  0, 0, $wd, $ht, $wd, $ht);

 	imagedestroy($img_src);

	$name=$engine_path."img/small/".$this->name;
	imagejpeg($img_dst,$this->image);

 	imagedestroy($img_dst);

	$fil=fopen($this->image,"r");
	$this->contents=fread($fil,filesize($this->image));  

	$this->imtype="image/jpeg";
	$this->type="jpeg";


  }

  function check()
  {
	global $er,$engine_path;

	if(!$this->file) $er="Файл не загружен!<br>";
	if(!in_array($this->imtype,$this->permitted)) $er="Неправильный тип файла!<br>";
	if( $this->maxsize && ($this->size > $this->maxsize) ) $er.="Загружайте файлы не больше ".$this->maxsize."<br>";

       if( $this->maxheight && ($this->height > $this->maxheight) ) $er.="Загружайте изображения не выше ".$this->maxheight."<br>";
       if( $this->maxwidth && ($this->width > $this->maxwidth) ) $er.="Загружайте изображения не шире ".$this->maxwidth."<br>";

  }

  function imageResize() {
     global $engine_path,$ImageTrimX,$ImageTrimY;


	$source=$this->image;
	$newWidth   = $this->newWidth;
	$newHeight  = $this->newHeight;
	$imType  = $this->type;


	if ($imType=="jpeg"||$imType=="pjpeg") $srcImage = ImageCreateFromJPEG($source);
	elseif($imType=="gif") $srcImage = LoadGif($source);
	else $srcImage = ImageCreateFromPNG($source);


	$srcWidth = ImageSX($srcImage);
	$srcHeight = ImageSY($srcImage);

	$ratioWidth = $srcWidth/$newWidth;
	$ratioHeight = $srcHeight/$newHeight;



	if(($ratioWidth<1&&$this->fix=="width") || ($ratioHeight<1&&$this->fix=="height"))
	{
		$destWidth   = $srcWidth;
		$destHeight  = $srcHeight;	
//print "mode 1";
//exit;
	}
	elseif(( $ratioWidth > $ratioHeight) || ( $ratioWidth < $ratioHeight && $this->fix!="width") || $this->fix=="height") 
	{
		$destWidth = $srcWidth/$ratioHeight;
		$destHeight = $newHeight;
//print "mode 2";
//exit;
	} 
	else 
	{
		$destWidth = $newWidth;
		$destHeight = $srcHeight/$ratioWidth;
//print "mode 3 $ratioHeight $ratioWidth $this->fix";
//exit;
	}

	//$this->newWidth=$destWidth;
	//$this->newHeight=$desHeight;
//print "$this->newWidth - $this->newHeight";
//print $srcImage." $ratioWidth $ratioHeight $this->fix $destWidth $destHeight";
//print "-($newHeight-$destHeight)/2";
//exit;
	if($newWidth!=$srcWidth&&$newHeight!=$srcHeight&&$newWidth!=160)
	{

		if(!strlen($ImageTrim)) $ImageTrim=2;


		if($ImageTrimY==0) $y=0;
		elseif($ImageTrimY==1) $y=($newHeight-$destHeight)/4;
		elseif($ImageTrimY==2) $y=($newHeight-$destHeight)/2;
		elseif($ImageTrimY==3) $y=3*($newHeight-$destHeight)/2;
		elseif($ImageTrimY==4) $y=5*($newHeight-$destHeight)/2;


		if($ImageTrimX==0) $x=0;
		elseif($ImageTrimX==1) $x=($newWidth-$destWidth)/4;
		elseif($ImageTrimX==2) $x=($newWidth-$destWidth)/2;
		elseif($ImageTrimX==3) $x=3*($newWidth-$destWidth)/2;
		elseif($ImageTrimX==4) $x=5*($newWidth-$destWidth)/2;
//print "$ImageTrimY $ImageTrimX $x $y";
//exit;
		$destImage = imagecreatetruecolor( $newWidth, $newHeight);
		imagecopyresampled( $destImage, $srcImage, $x, $y, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight );
	}
	else
	{
		$destImage = imagecreatetruecolor( $destWidth, $destHeight);
		imagecopyresampled( $destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight );
	}

	if($this->mix) $destImage =$this->mix($destImage );

	$name=$engine_path."img/small/".$this->name;


	if ($imType=="jpeg"||$imType=="pjpeg") 
	{
		Imagejpeg($destImage,$name);
	} 
	elseif($imType=="gif") 
	{
		Imagegif($destImage,$name);
	}
	else 
	{
		Imagepng($destImage,$name);
	}

	$file['tmp_name']=$name;



	ImageDestroy( $srcImage);
	ImageDestroy( $destImage);


	return($file); 
  }

 function mix($image)
 {
	global $site_url;


	$foto="image.jpg";         //Файл исходной картинки....

	$foto_nal=$this->mix;  	  //Файл картинки наложения...должен быть формат как и у исходной...


	/* Вставляем фотку на расстоянии от левого верхнего угла на заданное ниже растояние в (пкс) */
	$size_x=0;
	$size_y=0;

	//Доля яркости передаваемой картинки ...
	$jark=100;

	$proverka=explode(".",$foto_nal);

	if($proverka[1] == "bmp") $image_nal=imagecreatefromwbmp($foto_nal);
	elseif($proverka[1] == "jpg") $image_nal=imagecreatefromjpeg($foto_nal);
	elseif($proverka[1] == "gif") 
	{
		$image_nal=imagecreatefromgif($foto_nal);
	}
	elseif($proverka[1] == "png") $image_nal=imagecreatefrompng($foto_nal);


	if($image_nal == 0) {print "Mix image not found<br>";exit;}

	$height_nal=imageSY($image_nal);
	$width_nal=imageSX($image_nal);



	if($this->mixpos=="center") {
//imagecopymerge($image,$image_nal,$size_x,$size_y,-25, 0,$width_nal,$height_nal,$jark); 

imagecopymerge($image,$image_nal,($this->newWidth-$width_nal)/2, ($this->newHeight-$height_nal)/2,0,0,$width_nal,$height_nal,$jark); 
//print ($this->newWidth/2)." -"; print "$this->newHeight";exit;
}
	else imagecopymerge($image,$image_nal,$size_x,$size_y,0,0,$width_nal,$height_nal,$jark);

	return $image;

	ImageDestroy($image);
 }
}

?>