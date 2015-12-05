<?
Class cls_calendar
{
 var $hcol="F1F4F7"; //÷вет сегодн€шнего дн€ и событи€ 																		
 var $hcolday="E2E2E2"; //÷вет сегодн€шнего дн€ и событи€ 									
 var $bgcol="FFFAE4"; //цвет таблицы
 var $currentcol="FFFAE4"; //цвет таблицы
 var $datecol="#FDE76E";

 var $weekdays;
 var $months;
 var $months2;


 var $day;
 var $month;
 var $year;
 var $hour;
 var $minute;

 var $prevm;
 var $nextm;

 var $currentmonth;
 var $firstdayarray;
 var $lastdayarray;

function cls_calendar($month,$year)
  {

	$this->weekdays['rus']=array("ѕн","¬т","—р","„т","ѕт","—б","¬с");
	$this->months['rus']=array('ƒекабрь','январь','‘евраль','ћарт','јпрель','ћай','»юнь','»юль','јвгуст','—ент€брь','ќкт€брь','Ќо€брь','ƒекабрь','январь');
	$this->months2['rus']=array('декабр€','€нвар€','феврал€','марта','апрел€','ма€','июн€','июл€','августа','сент€бр€','окт€бр€','но€бр€','декабр€','€нвар€');

	$this->weekdays['eng']=array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
	$this->months['eng']=array('December','January','February','March','April','May','June','July','August','September','October','November','December','January');
	$this->months2['eng']=array('December','January','February','March','April','May','June','July','August','September','October','November','December','January');

	$this->weekdays['ger']=array("ѕн","¬т","—р","„т","ѕт","—б","¬с");
	$this->months['ger']=array('ƒекабрь','январь','‘евраль','ћарт','јпрель','ћай','»юнь','»юль','јвгуст','—ент€брь','ќкт€брь','Ќо€брь','ƒекабрь','январь');
	$this->months2['ger']=array('декабр€','€нвар€','феврал€','марта','апрел€','ма€','июн€','июл€','августа','сент€бр€','окт€бр€','но€бр€','декабр€','€нвар€');


	//выбираем текущий или заданный год--------------------------------------------

	if(!$this->year=$year) $this->year=date("Y");

	$this->day=date("d");

	//выбираем текущий или заданный мес€ц. если надо - переключаем год-------------

	if($month>12)
	{
		$this->year=$this->year+1;
		$this->month=1;
	}
	elseif($month<=0&&strlen($month)>0)
	{
		$this->year=$this->year-1;
		$this->month=12;
	}
	elseif(!$this->month=$month) $this->month=date("n");

	$this->hour=date("H");
	$this->minute=date("i");

	//номера предыдущего и следующего мес€цев--------------------------------------

	$this->prevm=$this->month-1;
	$this->nextm=$this->month+1;

	//узнаЄм, €вл€етс€ ли мес€ц текущим--------------------------------------------

	if(($this->month==date("n")&&$this->year==date("Y"))) $this->currentmonth=1;


	//номера предыдущего и следующего мес€цев--------------------------------------

	$this->firstdayarray = getdate(mktime(0,0,0,$this->month,1,$this->year));

	$this->lastdayarray = getdate(mktime(0,0,0,$this->month+1,1,$this->year)-1);

	if($this->firstdayarray[wday]==0) $this->firstdayarray[wday]=7;
  }

function DrawHeader()
  {
	global $PHP_SELF,$lang;

	print "<table border=0 bordercolor=E0E9F0 cellspacing=0 cellpadding=0 width=100%><tr><td align=center>";
	print "<table border=0 cellspacing=0 cellpadding=0 width=100%>

		<td align=left><a href=\"$PHP_SELF?month=$this->prevm&year=$this->year&act=schedule\">

			<B>&lt;&lt&lt ".$this->months[$lang][$this->prevm]."</B></a></td>

		<td align=center>";

	if($this->currentmonth)	print "<B>$this->day ".$this->months2[$lang][$this->month]." $this->year</B></td>";
	else print "<B>".$this->months[$lang][$this->month]." $this->year</B></td>";

	print "	<td align=right><a href=\"$PHP_SELF?month=$this->nextm&year=$this->year&act=schedule\">

			<B>".$this->months[$lang][$this->nextm]." &gt;&gt;&gt;</B></a>

		</td></table></td></tr>";

	print "<tr><td><br><table border=0 cellspacing=1 cellpadding=0 bgcolor=D0D0D0 width=100%><tr class=header>";

	//дни недели---------
	foreach($this->weekdays[$lang] as $day)
	{
		print "<td border=0 width=14% align=middle bgcolor=$this->hcolday>$day</td>";
	}

	print "</tr>";

  }

function Draw()
  {
	global $test,$days;

	$this->DrawHeader();
//print $this->firstdayarray[wday];
//$this->firstdayarray[wday]=$this->firstdayarray[wday]-2;

	//if($this->firstdayarray[wday]-1=="0") $x=0;
	//else $x=1;

	$counter=0;



	for($y=0;$y<=($this->lastdayarray[mday]+$this->firstdayarray[wday]-2);$y++)
	{

  		if( $y % 7 == 0) {echo "<tr  bgcolor=$this->bgcol>"; $cn=1;}
  		else $cn++;

  		if($y == $this->firstdayarray[wday]-1) $day=1;

		$item=new cls_calendar_item($this,$day,$y);

		unset($r);




		while($days[$counter][Date]<$item->end&&$days[$counter][Date]>=$item->start)
		{

			if(!$r[TeamID]) $r=$days[$counter];
			$counter++;
		}

		$item->Draw($r);

		if($day) $day++;

	}

	for($i=$cn;$i<7;$i++)
	{
//print "_ $i _ ";
 		print "<td bgcolor=$this->hcol></td>";
	}

	print "</table><br></td></tr></table>";


  }
}

Class cls_calendar_item
{
 var $day;
 var $num;
 var $start;
 var $endt;
 var $calendar;

function cls_calendar_item($calendar,$day,$num)
  {


	$this->calendar=$calendar;
	$this->day=$day;
	$this->num=$num;

	$this->start=mktime( 0, 0, 0, $calendar->month, $day, $calendar->year );
	$this->end=$this->start+60*60*24;

  }

function Draw($r)
  {
	global $site_url,$lang,$img_url,$auth,$days,$counter;


	$str="$r[OpponentName]";
	if($r[SmallLogo]) $team=$r[TeamID];

	if($r[Day]) $gameday= "<font size=1px>$r[Day]".message(11)."</b>";
	else $gameday="";

	//while($r=mysql_fetch_array($res))
	//{
		//$str.="\n$r1[Name]";

		//if($r[SmallLogo]) $team=$r[TeamID];
	//}


$color=$this->calendar->hcolday;



$border=0;
	$bordercolor="";

if($r[TeamID]&&!$r[OrderFile]) {$bordercolor="F0AE73";$border=1;}
if($r[TeamID]&&$r[OrderFile]) {$bordercolor="AFF073";$border=1;}


if($this->day==date("d") && $this->calendar->currentmonth) $color="F4CB31";
elseif($bordercolor) $color=$bordercolor;
else $color=$this->calendar->hcolday;

	$tex= "<table cellspacing=0 width=100% height=66 cellpadding=0 border=$border bordercolor=$bordercolor><td><table border=0 cellspacing=0 cellpadding=2 width=100% height=100%>
		<tr><td bgcolor=".$color."><font size=1px >".$this->day."</font></td>
		<td width=100% align=right>$gameday</td></tr><tr height=30px><td colspan=2>";



	if($r[Day])
	{

if(strlen($str)>1) $title=" Title=\"$str\" ";
else unset($title);

if($r[MatchID]) $tex.="<a href=\"$site_url"."xml/tour/match.php?id=$r[MatchID]\">";

if($team) $tex.="<center><img src=\"$img_url"."?id=$team&record=25\" $title border=0></a>\n";
else  $tex.="<center><img src=\"/images/ball.gif\" $title border=0></a>\n";

//		if($r[ShortName]=="champ" or $r[ShortName]=="tov") $tex.="<center><img src=\"http://www.butsa.ru/php/roster/ball.gif\" $title>\n";
//		else $tex.="<center><img src=\"http://www.butsa.ru/php/roster/cup.gif\" $title>\n";
	}

	if($this->num <  $this->calendar->firstdayarray[wday]-1) print "<td align=middle valign=middle  bgcolor=".$this->calendar->hcol."><table border=0 cellspacing=0 cellpadding=0 width=100% height=100%><td bgcolor=".$this->calendar->hcol."></td>\n";
	elseif($this->day==date("d") && $this->calendar->currentmonth) print "<td align=middle valign=middle bgcolor=".$this->calendar->currentcol."><B>$tex</B></td></table></td>\n";
	else print "<td align=middle valign=middle>$tex</td></table></td>\n";

	print "</table>\n";

  }
}
?>