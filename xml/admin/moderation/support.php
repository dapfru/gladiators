<?require('../../../config.php');
$form_width=170;

if($id) $act="respond";
if(!$act) $act="inbox";

if($act=="inbox"&&!$ok) unset($form_ok);

$type="moderation/support";

if($id) mysql_query("update ut_messages set Status=1 where Status=0 and MessageID='$id' and Support='1'");

require($site_path."admin/up.php");


$inbox=select("select count(*) from ut_messages where Support=1 and (UserID2='$auth->user' or UserID2 is null) and Status<2");

$unread=select("select count(*) from ut_messages where Support=1 and (UserID2='$auth->user' or UserID2 is null) and Status=0");

$sent=select("select count(*) from ut_messages where Support=2 and Status=2");

$deleted=select("select count(*) from ut_messages where Support=1 and Status=3");

$answered=select("select count(*) from ut_messages where Support=1 and Status=4");


$str=$inbox[0];
if($unread>0) $str="<b>$unread[0]</font>/".$str;

unset($menu);

$menu[0]="<a href=\"$PHP_SELF?act=inbox\">".message(167).": "."##$str</a>";
$menu[1]="<a href=\"$PHP_SELF?act=sent\">".message(168).":##$sent[0]</a>";
$menu[2]="<a href=\"$PHP_SELF?act=deleted\">".message(238).":##$deleted[0]</a>";
$menu[3]="<a href=\"$PHP_SELF?act=answered\">".message(239).":##$answered[0]</a>";
$menu[4]="<a href=\"$PHP_SELF?act=write\">".message(169)." </a>";

print "<table>";

		foreach($menu as $a)
		{

			if($a)
			{


?>
                          <tr class=menu>
				<td height=20px>
<?

				if(strstr($a,"##")) 
				{
					$b=explode("##",$a);
					print "<table border=0 cellspacing=0 cellpadding=0 width=180px><tr>";

					print "<td width=14px><img src=\"/images/marker3.gif\" width=11 height=11   align=\"absmiddle\"/></td><td>";

					print "$b[0]</td><td align=right><nobr>$b[1]</td></table>";
				}
				else
				{
					if(!strstr($a,"<img")) 	print "<img src=\"/images/marker3.gif\" width=11 height=11/>";
					print " $a</td>";
				}

                        	print "</tr>";
	
				print "<tr><td><img src=\"/images/hr2.gif\" height=10px width=180px></td></tr>";

			}

			$i++;
		}
print "</table>";

if($id)
{
	$f=new cls_form($type,"message");
	$f->Draw();
	print "<br>";

}

if($user)
{
	$q=select("select Login from ut_users where UserID='$user'");
	$r[Login]=$q[0];
}

unset($r[Body]);
$r[Subject]="Re:$r[Subject]";if($type&&$act!="delete") $form->Draw();

if($id)
{


$row=runsql("select * from ut_messages where Support=2  and Status=0 and AnswerID='$id'");
if(mysql_num_rows($row))
{
print "<hr><center><b>".message(240).":</b></center><hr>";
	while($r1=mysql_fetch_array($row))
	{
		$HTTP_GET_VARS['id']=$r1[MessageID];	
		$HTTP_POST_VARS['id']=$r1[MessageID];	
		$f=new cls_form($type,"message");
		$f->Draw();
	}

}



function rec($id)
{
	global $type,$HTTP_POST_VARS;

	$q=select("select AnswerID from ut_messages where MessageID='$id'");
	$row=runsql("select * from ut_messages where  MessageID='$q[0]'");
	if(mysql_num_rows($row))
	{
		while($r1=mysql_fetch_array($row))
		{
			print "<hr>";
			$HTTP_GET_VARS['id']=$r1[MessageID];	
			$HTTP_POST_VARS['id']=$r1[MessageID];	
			$f=new cls_form($type,"message");
			$f->Draw();
		}

		rec($q[0]);
	}

}

rec($id);

}

require($site_path."admin/bottom.php");?>