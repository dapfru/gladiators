<?
Class cls_photo extends cls_root
{
var $name;
var $type;
var $maxsize;
var $size;
var $photo;
var $small;

  function cls_photo($row)
  {
     $this->photo=$row[Photo];
     $this->small=$row[Small];
     $this->type=$row[Type];
     $this->name=$row[Name];
     $this->size=strlen($this->photo);

  } 

  function Preview($row)
  {
    header("Content-type: image/jpeg");
    print $this->small;
  } 

  function Draw($row)
  {
    header("Content-type: image/jpeg");
    print $this->photo;
  } 
}

?>