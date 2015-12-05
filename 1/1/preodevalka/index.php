<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
<meta http-equiv='Cache-Control' content='no-cache'>
<meta http-equiv='PRAGMA' content='NO-CACHE'>
<meta name='TITLE' content='Переодевалка'>
<meta name='DESCRIPTION' content='Переодевалка'>

<script language="JavaScript" type="text/javascript" src="censored.js><!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<title>Переодевалка</title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<link href="main.css" type=text/css rel=stylesheet>
<link href="redress.css" type=text/css rel=stylesheet>
</head>
<body bgcolor="#666666" background="fon%20copy.jpg" text="#000000" link="#FFFFFF" vlink="#FFFFFF" alink="#990000">
</strong></center>

                       <body bgcolor="#FFFFFF"leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" onLoad="Initialize()">



    </tr>
        <tr>
                <td height=36 style="background-repeat:no-repeat; padding-left: 10px;" class="back1">


<table width="100%" cellspacing="1" cellpadding="4" class="mainrow" height="1293">
        <tr class="back3">
                <td valign="top" bgcolor="#000000" colspan="4">
&nbsp;<tr class="back3">
                <td valign="top" height="98%" width="10%" bgcolor="#3D3D3B">
<td  align="right" width="10%">                </td></td>
</td>
                <td valign="top" height="98%" class="back4" align="center">


<SCRIPT language=JavaScript
      src="items.js"></SCRIPT>

      <SCRIPT language=JavaScript type=text/JavaScript>
var type="";
Rings1 = new Array;
Rings2 = new Array;
Rings3 = new Array;


function ShowItems(a){
                document.getElementById("info").style.visibility='hidden';
                document.getElementById("items").style.visibility='hidden';
                document.getElementById("descr").style.visibility='hidden';
                document.getElementById("filter").style.visibility='hidden';


                type=a;
                if ((a==Rings1)||(a==Rings2)||(a==Rings3)) {a=Rings;}
                ImagesList="";
                ImagesList+="<table cellspacing=1 class=rh1>";
                k=0;
                for (var i=0; i<a.length; i++ ){
                        if (Math.floor(k/5)==(k/5)) {ImagesList+="<tr>"};
                        it=DetectAvail(All_Items[a[i]][1]);
                        imp=All_Items[a[i]][0].charCodeAt(0);
                        if ( ((imp>64)&&(imp<91)) || ((imp>96)&&(imp<123)) ) {impt="1"} else {impt="0"}
                        if ((All_Items[a[i]][MfSelect.value]!='0')&&(All_Items[a[i]][2]>=parseInt(levelfrom.value))&&(All_Items[a[i]][2]<=parseInt(levelto.value))&&((ImportSelect.value==0) ||((ImportSelect.value==1)&&(impt=="0")) ) ){

//                        if ((All_Items[a[i]][MfSelect.value]!='0')&&(All_Items[a[i]][2]>=parseInt(levelfrom.value))&&(All_Items[a[i]][2]<=parseInt(levelto.value))){
                        if (ItemsSelect.value==0){
                         if (it=="0"){ImagesList=ImagesList+"<td width=60 align=right class=\"redbg\"><a href=\"#\" onMouseOver=ShowActualAlt('"+All_Items[a[i]][1]+"') onClick=DressItem('"+All_Items[a[i]][1]+"') onMouseOut=\"info.style.visibility='hidden'\"><img src=img/o/"+All_Items[a[i]][1]+".gif border=0></a></td>";}
                         else
                        {ImagesList=ImagesList+"<td width=60 align=right class=\"normalbgSI\"><a href=\"#\" onMouseOver=ShowActualAlt('"+All_Items[a[i]][1]+"') onClick=DressItem('"+All_Items[a[i]][1]+"') onMouseOut=\"info.style.visibility='hidden'\"><img src=img/o/"+All_Items[a[i]][1]+".gif border=0></a></td>";}
                        k++;
                        } else {
                                if (All_Items[a[i]][75]!='1'){
                                         if (it=="0"){ImagesList=ImagesList+"<td width=60 align=right class=\"redbg\"><a href=\"#\" onMouseOver=ShowActualAlt('"+All_Items[a[i]][1]+"') onClick=DressItem('"+All_Items[a[i]][1]+"') onMouseOut=\"info.style.visibility='hidden'\"><img src=img/o/"+All_Items[a[i]][1]+".gif border=0></a></td>";}
                                         else
                                        {ImagesList=ImagesList+"<td width=60 align=right class=\"normalbgSI\"><a href=\"#\" onMouseOver=ShowActualAlt('"+All_Items[a[i]][1]+"') onClick=DressItem('"+All_Items[a[i]][1]+"') onMouseOut=\"info.style.visibility='hidden'\"><img src=img/o/"+All_Items[a[i]][1]+".gif border=0></a></td>";}
                        k++;
                                }
                        }
                        }
                        if (Math.floor(k/5)==(k/5)) {ImagesList+="</tr>"};

                }
                ImagesList+="<tr><td colspan=5 align=center bgcolor=#666666><a href=\"#\" onClick=\"items.style.visibility='hidden'\" class=\"closestyle\">Закрыть</a></td></tr>";
                ImagesList+="</table>";
                document.getElementById("items").innerHTML=ImagesList;
                PositionControl(items);
                document.getElementById("items").style.visibility='visible';
}

function PositionControl (a){
        var rightedge=document.body.clientWidth-event.clientX;
        var bottomedge=document.body.clientHeight-event.clientY;
        if (rightedge<a.offsetWidth)
                a.style.left=document.body.scrollLeft+event.clientX-a.offsetWidth;
        else
                a.style.left=document.body.scrollLeft+event.clientX+15;
        if (bottomedge>a.offsetHeight)
                a.style.top=document.body.scrollTop+event.clientY;
}

function ShowAlt(a){
                document.getElementById("info").style.visibility='hidden';
                document.getElementById("info").style.width=10;
                document.getElementById("info").sig
                a_item=DetectItem(a);
                fc=a_item.charAt(0);
                if ((fc=="w")&&(!DetectExceptions(a_item))) {document.getElementById("info").innerHTML="<table cellspacing=1 class=rh><tr><td align=center bgcolor=#f4f4f4><span class=infostylebold><nobr>Данный слот пуст</nobr></span><br><span class=infostyle><nobr>Нажмите правую кнопку мыши для выбора предмета</nobr></span></td></tr></table>";
                        PositionControl(info);
                        document.getElementById("info").style.visibility='visible';
                        } else {
                        ShowActualAlt(a_item);
                        }
}

function ShowActualAlt(a){
                document.getElementById("info").style.visibility='hidden';
                document.getElementById("info").style.width=10;
                document.getElementById("info").style.height=10;
                text="";
                text+="<table cellspacing=1 cellpadding=0 class=rh><tr><td class=infoheader><nobr>"+All_Items[a][0];
                if (All_Items[a][21]==1){text+=" <img src='img/o/align1.gif'>"}
                if (All_Items[a][21]==2){text+=" <img src='img/o/align3.gif'>"}
                if (All_Items[a][74]==1){text+=" <img src='img/o/artefact.gif'>"}
                text+="</nobr></td></tr><tr><td class=otstup>";
                text+="<span class=infostylebold>Характеристики</span><br><nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;Цена: "+All_Items[a][22]+"</span></nobr><br><nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;Масса: "+All_Items[a][23]+"</span></nobr><br><nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;Долговечность: "+All_Items[a][24]+"</span></nobr><br>";
                if (a!="roba1") {text+="<span class=infostylebold>Требования</span><br>"}
                for (var i=2; i<21; i++){
                        if (All_Items[a][i]!="0") {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[i]+": "+All_Items[a][i]+"</span></nobr><br>"}
                }
                text+="<span class=infostylebold>Действие</span><br>";
                for (var i=25; i<72; i++){
                        if (All_Items[a][i]!="0") {
                                if (All_Items[a][i]>0){text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[i]+": "+All_Items[a][i]+"</span></nobr><br>"} else
                                        {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[i]+":</span><span class=infored> "+All_Items[a][i]+"</span></nobr><br>"} }
                        if (i==51){
                                for (var j=86;j<89;j++){
                                        if (All_Items[a][j]!="0") {
                                                if (All_Items[a][j]>0){text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[j]+": +"+All_Items[a][j]+"</span></nobr><br>"} else
                                                        {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[j]+":</span><span class=infored> "+All_Items[a][j]+"</span></nobr><br>"}
                                        }
                                 }
                        }
                }
                if (All_Items[a][76]!="0") {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[76]+": "+All_Items[a][76]+"</span></nobr><br>"}
                if (All_Items[a][89]!="0") {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[89]+": "+All_Items[a][89]+"</span></nobr><br>"}
                if (All_Items[a][85]!="0") {text+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[85]+": "+All_Items[a][85]+"</span></nobr><br>"}
                if (All_Items[a][73]!="0") {text+="<br><nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[73]+"</span></nobr><br>"}
                otext="<span class=infostylebold>Особенности</span><br>";
                ind=0;
                for (var i=77; i<85;i++){
                        if  (All_Items[a][i]!="0"){otext+="<nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[i]+": "+All_Items[a][i]+"</span></nobr><br>"; ind=1;}
                }
                if (All_Items[a][72]!="0") {text+="<br><nobr><span class=infostyle>&nbsp;&nbsp;&nbsp;"+Description[72]+"</span></nobr><br>"}

                if (ind==1){text+=otext}
                if (All_Items[a][75]!="0") {text+="<br><nobr><span class=inforedbold>"+Description[75]+"</span></nobr><br><br>"} else {text+="<br>"}
                otext="<span class=inforedbold>Недостающие параметры</span><br>";
                ind=0;
                if (All_Items[a][2]>parseInt(ActLevel.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Уровень: нужно еще "+(All_Items[a][2]-parseInt(ActLevel.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][3]>parseInt(ActStr.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Сила: нужно еще "+(All_Items[a][3]-parseInt(ActStr.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][4]>parseInt(ActAg.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Ловкость: нужно еще "+(All_Items[a][4]-parseInt(ActAg.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][5]>parseInt(ActInt.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Интуиция: нужно еще "+(All_Items[a][5]-parseInt(ActInt.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][6]>parseInt(ActEnd.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Выносливость: нужно еще "+(All_Items[a][6]-parseInt(ActEnd.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][7]>parseInt(ActIntel.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Интеллект: нужно еще "+(All_Items[a][7]-parseInt(ActIntel.innerHTML))+"</span></nobr><br>";}
                if (All_Items[a][8]>parseInt(ActWis.innerHTML)){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;Мудрость: нужно еще "+(All_Items[a][8]-parseInt(ActWis.innerHTML))+"</span></nobr><br>";}
                for (var i=9;i<14;i++){
                        if (All_Items[a][i]>parseInt(eval("A"+(i+47)+".innerHTML"))){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;"+Description[i]+": нужно еще "+(All_Items[a][i]-parseInt(eval("A"+(i+47)+".innerHTML")))+"</span></nobr><br>";}
                }
                for (var i=14;i<21;i++){
                        if (All_Items[a][i]>parseInt(eval("A"+(i+30)+".innerHTML"))){ind=1; otext+="<nobr><span class=infored>&nbsp;&nbsp;&nbsp;"+Description[i]+": нужно еще "+(All_Items[a][i]-parseInt(eval("A"+(i+30)+".innerHTML")))+"</span></nobr><br>";}
                }

                if (ind==1){text+=otext;}
                text+="</td></tr></table>";
                document.getElementById("info").innerHTML=text;
                PositionControl(info);
                document.getElementById("info").style.visibility='visible';
}

function DressItem(a){
        if (type==Helmets) {Helmet.src="img/o/"+a+".gif";}
        if (type==Belts) {Belt.src="img/o/"+a+".gif";}
        if (type==Amulets) {Amulet.src="img/o/"+a+".gif";}
        if (type==Naruchis) {Naruchi.src="img/o/"+a+".gif";}
        if (type==Braslets) {Braslet.src="img/o/"+a+".gif";}
        if (type==Rings1) {Ring1.src="img/o/"+a+".gif";}
        if (type==Rings2) {Ring2.src="img/o/"+a+".gif";}
        if (type==Rings3) {Ring3.src="img/o/"+a+".gif";}
        if (type==Bootss) {Boots.src="img/o/"+a+".gif";}
        if (type==Clips) {Clip.src="img/o/"+a+".gif";}
        if (type==Shirts) {Shirt.src="img/o/"+a+".gif";}
        if ((type==HArmor)||(type==LArmor)) {Armor.src="img/o/"+a+".gif";}
        if ((type==Knives)||(type==Axes)||(type==Hammers)||(type==Swords)||(type==Bukets)) {
                b=DetectItem(Shield);
                if (b.charAt(0)=="w"){Shield.src="img/o/w10.gif"; ShieldCanvas.className="normalbg";}
                Weapon.src="img/o/"+a+".gif";
                if (All_Items[a][73]=="1"){Shield.src='img/o/w3.gif'; ShieldCanvas.className="normalbg";}
                }
        if ((type==SKnives)||(type==SAxes)||(type==Shields)||(type==SSwords)||(type==SBukets)||(type==SHammers)) {
                b=DetectItem(Weapon);
                if ((b.charAt(0)=="w")||(All_Items[b][73]!="1")){Shield.src="img/o/"+a+".gif";}
                }


        document.getElementById("items").style.visibility='hidden';
        document.getElementById("info").style.visibility='hidden';
        ReCount();
}

function UndressItem(a){
        items.style.visibility="hidden";
        info.style.visibility="hidden";
        if (a==Clip) {a.src='img/o/w1.gif'; ClipCanvas.className="normalbg";}
        if (a==Helmet) {a.src='img/o/w9.gif'; HelmetCanvas.className="normalbg";}
        if (a==Belt) {a.src='img/o/w5.gif'; BeltCanvas.className="normalbg";}
        if (a==Amulet) {a.src='img/o/w2.gif'; AmuletCanvas.className="normalbg";}
        if (a==Naruchi) {a.src='img/o/w11.gif'; NaruchiCanvas.className="normalbg";}
        if (a==Braslet) {a.src='img/o/w13.gif'; BrasletCanvas.className="normalbg";}
        if (a==Ring1) {a.src='img/o/w6.gif'; Ring1Canvas.className="normalbg";}
        if (a==Ring2) {a.src='img/o/w7.gif'; Ring2Canvas.className="normalbg";}
        if (a==Ring3) {a.src='img/o/w8.gif'; Ring3Canvas.className="normalbg";}
        if (a==Boots) {a.src='img/o/w12.gif'; BootsCanvas.className="normalbg";}
        if (a==Shirt) {a.src='img/o/w4.gif'; ShirtCanvas.className="normalbg";}
        if (a==Armor) {a.src='img/o/w4.gif'; ArmorCanvas.className="normalbg";}
        if (a==Weapon) {b=DetectItem(Weapon); if((b.charAt(0)!="w")&&(All_Items[b][73]=="1")){Shield.src="img/o/w10.gif"; ShieldCanvas.className="normalbg";} a.src='w3.gif'; WeaponCanvas.className="normalbg";}
        if (a==Shield) {a.src='img/o/w10.gif'; ShieldCanvas.className="normalbg";}
        ReCount();
}

function ChooseItems(a){
        info.style.visibility="hidden";
        items.style.visibility="hidden";
        if (a==Armor){
                text="";
                text+="<table cellspacing=1 cellpadding=0   class=rh>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(HArmor)\"><nobr>Тяжелая Броня</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(LArmor)\"><nobr>Легкая Броня</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'\"><nobr>Закрыть</nobr></a></td></tr>";
                text+="</table>";
        }
        if (a==Weapon){
                text="";
                text+="<table cellspacing=1 cellpadding=0 class=rh>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Knives)\"><nobr>Ножи</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Axes)\"><nobr>Топоры</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Swords)\"><nobr>Мечи</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Hammers)\"><nobr>Дубины</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Bukets)\"><nobr>Букеты</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'\"><nobr>Закрыть</nobr></a></td></tr>";
                text+="</table>";
        }
        if (a==Shield){
                text="";
                text+="<table cellspacing=1 cellpadding=0  class=rh>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(SKnives)\"><nobr>Второй Нож</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(SAxes)\"><nobr>Второй топор</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(SSwords)\"><nobr>Второй меч</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(SHammers)\"><nobr>Второй молот</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(Shields)\"><nobr>Щиты</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'; ShowItems(SBukets)\"><nobr>Букеты</nobr></a></td></tr>";
                text+="<tr><td><a href=\"#\" onClick=\"descr.style.visibility='hidden'\"><nobr>Закрыть</nobr></a></td></tr>";
                text+="</table>";
        }
                document.getElementById("descr").innerHTML=text;
                PositionControl(descr);
                descr.style.visibility="visible";
}

function DetectItem(a){
        a_location=a.src;
        address=a_location.split("/");
        a_name=address[address.length-1].split(".");
        a_item=a_name[0];
        return a_item;
}

function ReCount (){
        Dr = new Array();
        St = new Array();
        NSt = new Array();
        for (var i=0; i<90; i++) {St[i]=0; NSt[i]=0;}
        text="";


// одетые вещи
        Dr[1]=DetectItem(Helmet);
        Dr[2]=DetectItem(Weapon);
        Dr[3]=DetectItem(Armor);
        Dr[4]=DetectItem(Belt);
        Dr[5]=DetectItem(Clip);
        Dr[6]=DetectItem(Amulet);
        Dr[7]=DetectItem(Braslet);
        Dr[8]=DetectItem(Naruchi);
        Dr[9]=DetectItem(Ring1);
        Dr[10]=DetectItem(Ring2);
        Dr[11]=DetectItem(Ring3);
        Dr[12]=DetectItem(Shield);
        Dr[13]=DetectItem(Boots);
        Dr[14]=DetectItem(Shirt);

// --------------------------------------------------------



// подсчет модификаторов
        for (var i=1; i<15; i++){
                a=Dr[i].charAt(0);
                if ((a!="w")||(DetectExceptions(Dr[i]))){
                        for (var j=22; j<72; j++){
                                b=All_Items[Dr[i]][j];
                                St[j]=St[j]+parseInt(b);
                        }
                }
        }

        for (var i=1; i<15; i++){
                a=Dr[i].charAt(0);

                if ((a!="w")||(DetectExceptions(Dr[i]))) {
                                b=All_Items[Dr[i]][76];
                                St[76]=St[76]+parseInt(b);
                                b=All_Items[Dr[i]][86];
                                St[86]=St[86]+parseInt(b);
                                b=All_Items[Dr[i]][87];
                                St[87]=St[87]+parseInt(b);

                                b=All_Items[Dr[i]][88];
                                St[88]=St[88]+parseInt(b);
                                b=All_Items[Dr[i]][89];
                                St[89]=St[89]+parseInt(b);

                }
        }

// -------------------------------------------------------


// нехватающие и присутствующие статы

        sum=parseInt(Strvalue.value)+parseInt(Agvalue.value)+parseInt(Intvalue.value)+parseInt(Endvalue.value)+parseInt(Intelvalue.value)+parseInt(Wisvalue.value);
        AllStat.innerHTML="<center>"+sum+"</center>";
        ActLevel.innerHTML=parseInt(levelvalue.value);
        ActStr.innerHTML=parseInt(Strvalue.value)+St[25];
        ActAg.innerHTML=parseInt(Agvalue.value)+St[26];
        ActInt.innerHTML=parseInt(Intvalue.value)+St[27];
        ActEnd.innerHTML=parseInt(Endvalue.value);
        ActIntel.innerHTML=parseInt(Intelvalue.value)+St[28];
        ActWis.innerHTML=parseInt(Wisvalue.value);
        ActAllStat.innerHTML=parseInt(Strvalue.value)+St[25]+parseInt(Agvalue.value)+St[26]+parseInt(Intvalue.value)+St[27]+parseInt(Endvalue.value)+parseInt(Intelvalue.value)+St[28]+parseInt(Wisvalue.value);


        for (var i=1; i<15; i++){
                a=Dr[i].charAt(0);
                if ((a!="w")||(DetectExceptions(Dr[i]))){
                        if ((parseInt(levelvalue.value)-All_Items[Dr[i]][2])<NSt[0]){NSt[0]=parseInt(levelvalue.value)-All_Items[Dr[i]][2]}
                        if ((parseInt(Strvalue.value)+St[25]-All_Items[Dr[i]][3])<NSt[1]){NSt[1]=parseInt(Strvalue.value)+St[25]-All_Items[Dr[i]][3]}
                        if ((parseInt(Agvalue.value)+St[26]-All_Items[Dr[i]][4])<NSt[2]){NSt[2]=parseInt(Agvalue.value)+St[26]-All_Items[Dr[i]][4]}
                        if ((parseInt(Intvalue.value)+St[27]-All_Items[Dr[i]][5])<NSt[3]){NSt[3]=parseInt(Intvalue.value)+St[27]-All_Items[Dr[i]][5]}
                        if ((parseInt(Endvalue.value)-All_Items[Dr[i]][6])<NSt[4]){NSt[4]=parseInt(Endvalue.value)-All_Items[Dr[i]][6]}
                        if ((parseInt(Intelvalue.value)+St[28]-All_Items[Dr[i]][7])<NSt[5]){NSt[5]=parseInt(Intelvalue.value)+St[28]-All_Items[Dr[i]][7]}
                        if ((parseInt(Wisvalue.value)-All_Items[Dr[i]][8])<NSt[6]){NSt[6]=parseInt(Wisvalue.value)-All_Items[Dr[i]][8]}
                        for (var j=44;j<51;j++){
                                eval("s=parseInt(I"+j+".value)+St["+j+"]-All_Items[Dr["+i+"]]["+(j-30)+"]");
                                if (s<NSt[j]){NSt[j]=s}
                        }
                        for (var j=56;j<61;j++){
                                eval("s=parseInt(I"+j+".value)+St["+j+"]-All_Items[Dr["+i+"]]["+(j-47)+"]");
                                if (s<NSt[j]){NSt[j]=s}
                        }
                }
        }
        if (NSt[0]!=0){NLevel.innerHTML=NSt[0];        } else {NLevel.innerHTML="&nbsp;";}
        if (NSt[1]!=0){NStr.innerHTML=NSt[1];        } else {NStr.innerHTML="&nbsp;";}
        if (NSt[2]!=0){NAg.innerHTML=NSt[2];        } else {NAg.innerHTML="&nbsp;";}
        if (NSt[3]!=0){NInt.innerHTML=NSt[3];        } else {NInt.innerHTML="&nbsp;";}
        if (NSt[4]!=0){NEnd.innerHTML=NSt[4];} else {NEnd.innerHTML="&nbsp;";}
        if (NSt[5]!=0){NIntel.innerHTML=NSt[5];} else {NIntel.innerHTML="&nbsp;";}
        if (NSt[6]!=0){NWis.innerHTML=NSt[6];} else {NWis.innerHTML="&nbsp;";}
        for (var j=44;j<51;j++){
                if (NSt[j]!=0){eval ("N"+j+".innerHTML=NSt["+j+"]");} else {eval ("N"+j+".innerHTML=\"&nbsp;\"");}
        }
        for (var j=56;j<61;j++){
                if (NSt[j]!=0){eval ("N"+j+".innerHTML=NSt["+j+"]");} else {eval ("N"+j+".innerHTML=\"&nbsp;\"");}
        }

        N=NSt[1]+NSt[2]+NSt[3]+NSt[4]+NSt[5]+NSt[6];
        if (N!=0){NAllStat.innerHTML=N;} else {NAllStat.innerHTML="&nbsp;";}
// ---------------------------------------------------------------------


// вывод суммирующих значений мф

        for (var i=25; i<44;i++){eval ("A"+i+".innerHTML=St["+i+"]");}
        for (var i=51; i<56;i++){eval ("A"+i+".innerHTML=St["+i+"]");}
        for (var i=61; i<70;i++){eval ("A"+i+".innerHTML=St["+i+"]");}
        A76.innerHTML=St[76];
        A89.innerHTML=St[89];
        A22.innerHTML=St[22];
        A23.innerHTML=St[23];
        A86.innerHTML=St[86];
        A87.innerHTML=St[87];
        A88.innerHTML=St[88];
        for (var i=44; i<51;i++){eval ("A"+i+".innerHTML=St["+i+"]+parseInt(I"+i+".value)");}
        for (var i=56; i<61;i++){eval ("A"+i+".innerHTML=St["+i+"]+parseInt(I"+i+".value)");}
        fullHP.innerHTML=(parseInt(Endvalue.value))*6+parseInt(A42.innerHTML);
        fullMana.innerHTML=(parseInt(Wisvalue.value))*10+parseInt(A43.innerHTML);

        min1Dmg=0;
        max1Dmg=0;
        min2Dmg=0;
        max2Dmg=0;

//пересчет на второе оружие, если есть
                if (DetectSecondWeapon(Dr[12])) {
                        if ((Dr[2].charAt(0)!="w")||(DetectExceptions(Dr[2])) ){
                                S29.innerHTML=St[29]-parseInt(All_Items[Dr[2]][29]);
                                S31.innerHTML=St[31]-parseInt(All_Items[Dr[2]][31]);
                                S33.innerHTML=St[33]-parseInt(All_Items[Dr[2]][33]);
                                S35.innerHTML=St[35]-parseInt(All_Items[Dr[2]][35]);
                                S38.innerHTML=St[38]-parseInt(All_Items[Dr[2]][38]);
                                S39.innerHTML=St[39]-parseInt(All_Items[Dr[2]][39]);
                                S40.innerHTML=St[40]-parseInt(All_Items[Dr[2]][40]);
                                S41.innerHTML=St[41]-parseInt(All_Items[Dr[2]][41]);
                                A29.innerHTML=St[29]-parseInt(All_Items[Dr[12]][29]);
                                A31.innerHTML=St[31]-parseInt(All_Items[Dr[12]][31]);
                                A33.innerHTML=St[33]-parseInt(All_Items[Dr[12]][33]);
                                A35.innerHTML=St[35]-parseInt(All_Items[Dr[12]][35]);
                                A38.innerHTML=St[38]-parseInt(All_Items[Dr[12]][38]);
                                A39.innerHTML=St[39]-parseInt(All_Items[Dr[12]][39]);
                                A40.innerHTML=St[40]-parseInt(All_Items[Dr[12]][40]);
                                A41.innerHTML=St[41]-parseInt(All_Items[Dr[12]][41]);
                                if (parseInt(ActStr.innerHTML)>49){
                                        A38.innerHTML=parseInt(A38.innerHTML)+10;
                                        A39.innerHTML=parseInt(A39.innerHTML)+10;
                                        A40.innerHTML=parseInt(A40.innerHTML)+10;
                                        A41.innerHTML=parseInt(A41.innerHTML)+10;
                                        S38.innerHTML=parseInt(S38.innerHTML)+10;
                                        S39.innerHTML=parseInt(S39.innerHTML)+10;
                                        S40.innerHTML=parseInt(S40.innerHTML)+10;
                                        S41.innerHTML=parseInt(S41.innerHTML)+10;
                                }
                                if (parseInt(ActStr.innerHTML)>99){
                                        A38.innerHTML=parseInt(A38.innerHTML)+15;
                                        A39.innerHTML=parseInt(A39.innerHTML)+15;
                                        A40.innerHTML=parseInt(A40.innerHTML)+15;
                                        A41.innerHTML=parseInt(A41.innerHTML)+15;
                                        S38.innerHTML=parseInt(S38.innerHTML)+15;
                                        S39.innerHTML=parseInt(S39.innerHTML)+15;
                                        S40.innerHTML=parseInt(S40.innerHTML)+15;
                                        S41.innerHTML=parseInt(S41.innerHTML)+15;
                                }
                                if (parseInt(ActInt.innerHTML)>49){
                                        A29.innerHTML=parseInt(A29.innerHTML)+35;
                                        S29.innerHTML=parseInt(S29.innerHTML)+35;
                                        A31.innerHTML=parseInt(A31.innerHTML)+10;
                                        S31.innerHTML=parseInt(S31.innerHTML)+10;
                                        A33.innerHTML=parseInt(A33.innerHTML)+15;
                                        S33.innerHTML=parseInt(S33.innerHTML)+15;
                                }
                                if (parseInt(ActAg.innerHTML)>49){
                                        A33.innerHTML=parseInt(A33.innerHTML)+25;
                                        S33.innerHTML=parseInt(S33.innerHTML)+25;
                                }
                                if (parseInt(ActAg.innerHTML)>99){
                                        A33.innerHTML=parseInt(A33.innerHTML)+50;
                                        S33.innerHTML=parseInt(S33.innerHTML)+50;
                                }
                                if (parseInt(ActStr.innerHTML)>3){
                                                min1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+1+St[70]-parseInt(All_Items[Dr[12]][70]);
                                                 max1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+5+St[71]-parseInt(All_Items[Dr[12]][71]);
                                                min2Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+1+St[70]-parseInt(All_Items[Dr[2]][70]);
                                                 max2Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+5+St[71]-parseInt(All_Items[Dr[2]][71]);
                                        } else {
                                                min1Dmg=2+St[70]-parseInt(All_Items[Dr[12]][70]);
                                                 max1Dmg=5+St[71]-parseInt(All_Items[Dr[12]][71]);
                                                min2Dmg=2+St[70]-parseInt(All_Items[Dr[2]][70]);
                                                 max2Dmg=5+St[71]-parseInt(All_Items[Dr[2]][71]);
                                }
                                if (DetectWeaponType(Dr[12])=="1") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I59.value)+St[59]-parseInt(All_Items[Dr[2]][59]))*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I59.value)+St[59]-parseInt(All_Items[Dr[2]][59]))*2;}
                                if (DetectWeaponType(Dr[12])=="2") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I57.value)+St[57]-parseInt(All_Items[Dr[2]][57]))*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I57.value)+St[57]-parseInt(All_Items[Dr[2]][57]))*2;}
                                if (DetectWeaponType(Dr[12])=="3") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I56.value)+St[56]-parseInt(All_Items[Dr[2]][56]))*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I56.value)+St[56]-parseInt(All_Items[Dr[2]][56]))*2;}
                                if (DetectWeaponType(Dr[12])=="4") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I58.value)+St[58]-parseInt(All_Items[Dr[2]][56]))*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(St[58]-parseInt(All_Items[Dr[2]][58]))*2;}
                                if (DetectWeaponType(Dr[2])=="1") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I59.value)+St[59]-parseInt(All_Items[Dr[12]][59]))*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I59.value)+St[59]-parseInt(All_Items[Dr[12]][59]))*2;}
                                if (DetectWeaponType(Dr[2])=="2") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I57.value)+St[57]-parseInt(All_Items[Dr[12]][57]))*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I57.value)+St[57]-parseInt(All_Items[Dr[12]][57]))*2;}
                                if (DetectWeaponType(Dr[2])=="3") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I56.value)+St[56]-parseInt(All_Items[Dr[12]][56]))*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I56.value)+St[56]-parseInt(All_Items[Dr[12]][56]))*2;}
                                if (DetectWeaponType(Dr[2])=="4") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I58.value)+St[58]-parseInt(All_Items[Dr[12]][56]))*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I58.value)+St[58]-parseInt(All_Items[Dr[12]][58]))*2;}
                        } else {
                                S29.innerHTML=St[29];
                                S31.innerHTML=St[31];
                                S33.innerHTML=St[33];
                                S35.innerHTML=St[35];
                                S38.innerHTML=St[38];
                                S39.innerHTML=St[39];
                                S40.innerHTML=St[40];
                                S41.innerHTML=St[41];
                                if (parseInt(ActStr.innerHTML)>3){
                                                min1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+1+St[70]-parseInt(All_Items[Dr[12]][70]);
                                                 max1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+5+St[71]-parseInt(All_Items[Dr[12]][71]);
                                                min2Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+1+St[70];
                                                 max2Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+5+St[71];
                                        } else {
                                                min1Dmg=2+St[70]-parseInt(All_Items[Dr[12]][70]);
                                                 max1Dmg=5+St[71]-parseInt(All_Items[Dr[12]][71]);
                                                min2Dmg=2+St[70];
                                                 max2Dmg=5+St[71];
                                        }
                                if (DetectWeaponType(Dr[12])=="1") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I59.value)+St[59])*2;; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I59.value)+St[59])*2;}
                                if (DetectWeaponType(Dr[12])=="2") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I57.value)+St[57])*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I57.value)+St[57])*2;}
                                if (DetectWeaponType(Dr[12])=="3") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I56.value)+St[56])*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(parseInt(I56.value)+St[56])*2;}
                                if (DetectWeaponType(Dr[12])=="4") {min2Dmg=min2Dmg+parseInt(Zat2.value)+(parseInt(I58.value)+St[58])*2; max2Dmg=max2Dmg+parseInt(Zat2.value)+(St[58])*2;}
                        A29.innerHTML=St[29]-parseInt(All_Items[Dr[12]][29]);
                        A31.innerHTML=St[31]-parseInt(All_Items[Dr[12]][31]);
                        A33.innerHTML=St[33]-parseInt(All_Items[Dr[12]][33]);
                        A35.innerHTML=St[35]-parseInt(All_Items[Dr[12]][35]);
                        A38.innerHTML=St[38]-parseInt(All_Items[Dr[12]][38]);
                        A39.innerHTML=St[39]-parseInt(All_Items[Dr[12]][39]);
                        A40.innerHTML=St[40]-parseInt(All_Items[Dr[12]][40]);
                        A41.innerHTML=St[41]-parseInt(All_Items[Dr[12]][41]);
                                if (parseInt(ActStr.innerHTML)>49){
                                        A38.innerHTML=parseInt(A38.innerHTML)+10;
                                        A39.innerHTML=parseInt(A39.innerHTML)+10;
                                        A40.innerHTML=parseInt(A40.innerHTML)+10;
                                        A41.innerHTML=parseInt(A41.innerHTML)+10;
                                        S38.innerHTML=parseInt(S38.innerHTML)+10;
                                        S39.innerHTML=parseInt(S39.innerHTML)+10;
                                        S40.innerHTML=parseInt(S40.innerHTML)+10;
                                        S41.innerHTML=parseInt(S41.innerHTML)+10;
                                }
                                if (parseInt(ActStr.innerHTML)>99){
                                        A38.innerHTML=parseInt(A38.innerHTML)+15;
                                        A39.innerHTML=parseInt(A39.innerHTML)+15;
                                        A40.innerHTML=parseInt(A40.innerHTML)+15;
                                        A41.innerHTML=parseInt(A41.innerHTML)+15;
                                        S38.innerHTML=parseInt(S38.innerHTML)+15;
                                        S39.innerHTML=parseInt(S39.innerHTML)+15;
                                        S40.innerHTML=parseInt(S40.innerHTML)+15;
                                        S41.innerHTML=parseInt(S41.innerHTML)+15;
                                }
                                if (parseInt(ActInt.innerHTML)>49){
                                        A29.innerHTML=parseInt(A29.innerHTML)+35;
                                        S29.innerHTML=parseInt(S29.innerHTML)+35;
                                        A31.innerHTML=parseInt(A31.innerHTML)+10;
                                        S31.innerHTML=parseInt(S31.innerHTML)+10;
                                        A33.innerHTML=parseInt(A33.innerHTML)+15;
                                        S33.innerHTML=parseInt(S33.innerHTML)+15;
                                }
                                if (parseInt(ActAg.innerHTML)>49){
                                        A33.innerHTML=parseInt(A33.innerHTML)+25;
                                        S33.innerHTML=parseInt(S33.innerHTML)+25;
                                }
                                if (parseInt(ActAg.innerHTML)>99){
                                        A33.innerHTML=parseInt(A33.innerHTML)+50;
                                        S33.innerHTML=parseInt(S33.innerHTML)+50;
                                }
                        }
                } else {
                        S29.innerHTML="&nbsp;";
                        S31.innerHTML="&nbsp;";
                        S33.innerHTML="&nbsp;";
                        S35.innerHTML="&nbsp;";
                        S38.innerHTML="&nbsp;";
                        S39.innerHTML="&nbsp;";
                        S40.innerHTML="&nbsp;";
                        S41.innerHTML="&nbsp;";
                                if (parseInt(ActStr.innerHTML)>49){
                                        A38.innerHTML=parseInt(A38.innerHTML)+10;
                                        A39.innerHTML=parseInt(A39.innerHTML)+10;
                                        A40.innerHTML=parseInt(A40.innerHTML)+10;
                                        A41.innerHTML=parseInt(A41.innerHTML)+10;
                                }
                                if (parseInt(ActStr.innerHTML)>99){
                                        A38.innerHTML=parseInt(A38.innerHTML)+15;
                                        A39.innerHTML=parseInt(A39.innerHTML)+15;
                                        A40.innerHTML=parseInt(A40.innerHTML)+15;
                                        A41.innerHTML=parseInt(A41.innerHTML)+15;
                                }
                                if (parseInt(ActInt.innerHTML)>49){
                                        A29.innerHTML=parseInt(A29.innerHTML)+35;
                                        A31.innerHTML=parseInt(A31.innerHTML)+10;
                                        A33.innerHTML=parseInt(A33.innerHTML)+15;
                                }
                                if (parseInt(ActAg.innerHTML)>49){
                                        A33.innerHTML=parseInt(A33.innerHTML)+25;
                                }
                                if (parseInt(ActAg.innerHTML)>99){
                                        A33.innerHTML=parseInt(A33.innerHTML)+50;
                                }
                        min2Dmg="&nbsp;";
                        max2Dmg="&nbsp;";
                        if (parseInt(ActStr.innerHTML)>3){
                                        min1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+1+St[70];
                                         max1Dmg=Math.floor((parseInt(ActStr.innerHTML)-1)/3)+5+St[71];
                                } else {
                                        min1Dmg=2+St[70];
                                         max1Dmg=5+St[71];
                        }
                        if (DetectWeaponType(Dr[2])=="1") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I59.value)+St[59])*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I59.value)+St[59])*2;}
                        if (DetectWeaponType(Dr[2])=="2") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I57.value)+St[57])*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I57.value)+St[57])*2;}
                        if (DetectWeaponType(Dr[2])=="3") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I56.value)+St[56])*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I56.value)+St[56])*2;}
                        if (DetectWeaponType(Dr[2])=="4") {min1Dmg=min1Dmg+parseInt(Zat1.value)+(parseInt(I58.value)+St[58])*2; max1Dmg=max1Dmg+parseInt(Zat1.value)+(parseInt(I58.value)+St[58])*2;}
                }
                A70.innerHTML=min1Dmg;
                A71.innerHTML=max1Dmg;
                S70.innerHTML=min2Dmg;
                S71.innerHTML=max2Dmg;

        // --------------------------------------------------------
// --------------------------------------------------------


// проверка на подсвечивание неодеваемых вещей на игроке

        if ((Dr[1].charAt(0)!="w")||(DetectExceptions(Dr[1]))){it=DetectAvail(Dr[1]); if (it=="0") {HelmetCanvas.className="redbg";} else {HelmetCanvas.className="normalbg";} }
        if ((Dr[2].charAt(0)!="w")||(DetectExceptions(Dr[2]))){it=DetectAvail(Dr[2]); if (it=="0") {WeaponCanvas.className="redbg";} else {WeaponCanvas.className="normalbg";} }
        if ((Dr[3].charAt(0)!="w")||(DetectExceptions(Dr[3]))){it=DetectAvail(Dr[3]); if (it=="0") {ArmorCanvas.className="redbg";} else {ArmorCanvas.className="normalbg";} }
        if ((Dr[4].charAt(0)!="w")||(DetectExceptions(Dr[4]))){it=DetectAvail(Dr[4]); if (it=="0") {BeltCanvas.className="redbg";} else {BeltCanvas.className="normalbg";} }
        if ((Dr[5].charAt(0)!="w")||(DetectExceptions(Dr[5]))){it=DetectAvail(Dr[5]); if (it=="0") {ClipCanvas.className="redbg";} else {ClipCanvas.className="normalbg";} }
        if ((Dr[6].charAt(0)!="w")||(DetectExceptions(Dr[6]))){it=DetectAvail(Dr[6]); if (it=="0") {AmuletCanvas.className="redbg";} else {AmuletCanvas.className="normalbg";} }
        if ((Dr[7].charAt(0)!="w")||(DetectExceptions(Dr[7]))){it=DetectAvail(Dr[7]); if (it=="0") {BrasletCanvas.className="redbg";} else {BrasletCanvas.className="normalbg";} }
        if ((Dr[8].charAt(0)!="w")||(DetectExceptions(Dr[8]))){it=DetectAvail(Dr[8]); if (it=="0") {NaruchiCanvas.className="redbg";} else {NaruchiCanvas.className="normalbg";} }
        if ((Dr[9].charAt(0)!="w")||(DetectExceptions(Dr[9]))){it=DetectAvail(Dr[9]); if (it=="0") {Ring1Canvas.className="redbg";} else {Ring1Canvas.className="normalbg";} }
        if ((Dr[10].charAt(0)!="w")||(DetectExceptions(Dr[10]))){it=DetectAvail(Dr[10]); if (it=="0") {Ring2Canvas.className="redbg";} else {Ring2Canvas.className="normalbg";} }
        if ((Dr[11].charAt(0)!="w")||(DetectExceptions(Dr[11]))){it=DetectAvail(Dr[11]); if (it=="0") {Ring3Canvas.className="redbg";} else {Ring3Canvas.className="normalbg";} }
        if ((Dr[12].charAt(0)!="w")||(DetectExceptions(Dr[12]))){it=DetectAvail(Dr[12]); if (it=="0") {ShieldCanvas.className="redbg";} else {ShieldCanvas.className="normalbg";} }
        if ((Dr[13].charAt(0)!="w")||(DetectExceptions(Dr[13]))){it=DetectAvail(Dr[13]); if (it=="0") {BootsCanvas.className="redbg";} else {BootsCanvas.className="normalbg";} }
        if ((Dr[14].charAt(0)!="w")||(DetectExceptions(Dr[14]))){it=DetectAvail(Dr[14]); if (it=="0") {ShirtCanvas.className="redbg";} else {ShirtCanvas.className="normalbg";} }
// -----------------------------------------------------------------------------------

        if (parseInt(ActEnd.innerHTML)>49){
                A61.innerHTML=parseInt(A61.innerHTML)+10;
        }

        if (parseInt(ActAg.innerHTML)>49){
                A32.innerHTML=parseInt(A32.innerHTML)+25;
                A34.innerHTML=parseInt(A34.innerHTML)+5;
                A36.innerHTML=parseInt(A36.innerHTML)+5;
        }

        if (parseInt(ActAg.innerHTML)>99){
                A32.innerHTML=parseInt(A32.innerHTML)+50;
                A34.innerHTML=parseInt(A34.innerHTML)+10;
                A36.innerHTML=parseInt(A36.innerHTML)+10;
        }

}

function DetectExceptions(a){
        j=0;
        for (var k=0; k<Exceptions.length; k++){
                if (a==Exceptions[k]){j=1;}
        }
        if (j==1){return true;} else {return false;}
}

function DetectSecondWeapon (a) {
        ind=0;
        if ((a.charAt(0)!="w")||(DetectExceptions(a))) {
                for (var i=0; i<SKnives.length; i++) {if (SKnives[i]==a){ind=1;} }
                for (var i=0; i<SAxes.length; i++) {if (SAxes[i]==a){ind=1;} }
                for (var i=0; i<SSwords.length; i++) {if (SSwords[i]==a){ind=1;} }
                for (var i=0; i<SHammers.length; i++) {if (SHammers[i]==a){ind=1;} }
        }
        if (ind==0) {return false;} else {return true;}
}


function DetectWeaponType (a) {
                for (var i=0; i<Knives.length; i++) {if (Knives[i]==a){return "1";} }
                for (var i=0; i<Axes.length; i++) {if (Axes[i]==a){return "2";} }
                for (var i=0; i<Swords.length; i++) {if (Swords[i]==a){return "3";} }
                for (var i=0; i<Hammers.length; i++) {if (Hammers[i]==a){return "4";} }
                for (var i=0; i<Bukets.length; i++) {if (Bukets[i]==a){return "5";} }
        }


function DetectAvail (a){
        if ((All_Items[a][2]>parseInt(ActLevel.innerHTML))||(All_Items[a][3]>parseInt(ActStr.innerHTML))||(All_Items[a][4]>parseInt(ActAg.innerHTML))||(All_Items[a][5]>parseInt(ActInt.innerHTML))||(All_Items[a][6]>parseInt(ActEnd.innerHTML))||(All_Items[a][7]>parseInt(ActIntel.innerHTML))||(All_Items[a][8]>parseInt(ActWis.innerHTML))||(All_Items[a][9]>parseInt(A56.innerHTML))||(All_Items[a][10]>parseInt(A57.innerHTML))||(All_Items[a][11]>parseInt(A58.innerHTML))||(All_Items[a][12]>parseInt(A59.innerHTML))||(All_Items[a][13]>parseInt(A60.innerHTML))||(All_Items[a][14]>parseInt(A44.innerHTML))||(All_Items[a][15]>parseInt(A45.innerHTML))||(All_Items[a][16]>parseInt(A46.innerHTML))||(All_Items[a][17]>parseInt(A47.innerHTML))||(All_Items[a][18]>parseInt(A48.innerHTML))||(All_Items[a][19]>parseInt(A49.innerHTML))||(All_Items[a][20]>parseInt(A50.innerHTML))) { return "0";} else {return "1";}
}


function Correct(a){
        if (a==Strvalue){St="сила"}
        if (a==Strvalue){St="сила"}
        if (a==Agvalue){St="ловкость"}
        if (a==Intvalue){St="интуиция"}
        if (a==Endvalue){St="выносливость"}
        if (a==Intelvalue){St="интеллект"}
        if (a==Wisvalue){St="мудрость"}
        if (a==levelvalue){St="уровень"}
        if (a==I44){St="владение магией тьмы"}
        if (a==I45){St="владение магией света"}
        if (a==I46){St="владение серой магией"}
        if (a==I47){St="владение магией огня"}
        if (a==I48){St="владение магией воды"}
        if (a==I49){St="владение магией воздуха"}
        if (a==I50){St="владение магией земли"}
        if (a==I56){St="владение мечами"}
        if (a==I57){St="владение топорами и секирами"}
        if (a==I58){St="владение булавами и дубинами"}
        if (a==I59){St="владение ножами и кинжалами"}

        if (a==I60){St="владение посохами"}
        if ((a==Zat1)||(a==Zat2)){St="заточка"}


        if ((a==levelvalue)||(a==Intelvalue)||(a==Wisvalue)){
                        if (a.value=="") {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (isNaN(a.value)) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (parseInt(a.value)<0) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if ((parseInt(a.value)>21)&&(a==levelvalue)) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (a.value.lastIndexOf(".")!=-1){
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
        }


        if ((a==Strvalue)||(a==Agvalue)||(a==Intvalue)||(a==Endvalue)){
                if (a.value=="") {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                if (isNaN(a.value)) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=3;
                        }
                if (parseInt(a.value)<3) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=3;
                        }
                if (a.value.lastIndexOf(".")!=-1){
                        alert ("Значение параметра "+St+"  недопустимо");
                        a.value=3;
                        }
        }
        if ((a==I44)||(a==I45)||(a==I46)||(a==I47)||(a==I48)||(a==I49)||(a==I50)||(a==I56)||(a==I57)||(a==I58)||(a==I59)||(a==I60)){
                        if (a.value=="") {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }

                        if (isNaN(a.value)) {
                        alert ("Значение параметра "+St+" недопустимо");




                        a.value=0;
                        }
                        if (parseInt(a.value)<0) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (parseInt(a.value)>5) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (a.value.lastIndexOf(".")!=-1){
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
        }
                if ((a==Zat1)||(a==Zat2)){
                        if (a.value=="") {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }

                        if (isNaN(a.value)) {
                        alert ("Значение параметра "+St+" недопустимо");

                        a.value=0;
                        }
                        if (parseInt(a.value)<0) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (parseInt(a.value)>5) {
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
                        if (a.value.lastIndexOf(".")!=-1){
                        alert ("Значение параметра "+St+" недопустимо");
                        a.value=0;
                        }
        }
        ReCount();
}

function InitStat () {
        levelvalue.value=0;
        Strvalue.value=0;
        Agvalue.value=0;
        Intvalue.value=0;
        Endvalue.value=0;
        Intelvalue.value=0;
        Wisvalue.value=0;
        I44.value=0;
        I45.value=0;
        I46.value=0;
        I47.value=0;
        I48.value=0;
        I49.value=0;
        I50.value=0;
        I56.value=0;
        I57.value=0;
        I58.value=0;
        I59.value=0;
        I60.value=0;
        Zat1.value=0;
        Zat2.value=0;
        ReCount();
}


function InitItems (){
        UndressItem(Helmet);
        UndressItem(Weapon);
        UndressItem(Armor);
        UndressItem(Belt);
        UndressItem(Shirt);
        UndressItem(Clip);
        UndressItem(Amulet);
        UndressItem(Braslet);
        UndressItem(Naruchi);
        UndressItem(Ring1);
        UndressItem(Ring2);
        UndressItem(Ring3);
        UndressItem(Shield);
        UndressItem(Boots);
        ReCount();
}

function SetStats(){
        InitStat();
        if (NLevel.innerHTML!="&nbsp;"){levelvalue.value=parseInt(levelvalue.value)-parseInt(NLevel.innerHTML)}
        if (NStr.innerHTML!="&nbsp;"){Strvalue.value=parseInt(Strvalue.value)-parseInt(NStr.innerHTML)}
        if (NAg.innerHTML!="&nbsp;"){Agvalue.value=parseInt(Agvalue.value)-parseInt(NAg.innerHTML)}
        if (NInt.innerHTML!="&nbsp;"){Intvalue.value=parseInt(Intvalue.value)-parseInt(NInt.innerHTML)}
        if (NEnd.innerHTML!="&nbsp;"){Endvalue.value=parseInt(Endvalue.value)-parseInt(NEnd.innerHTML)}
        if (NIntel.innerHTML!="&nbsp;"){Intelvalue.value=parseInt(Intelvalue.value)-parseInt(NIntel.innerHTML)}
        if (NWis.innerHTML!="&nbsp;"){Wisvalue.value=parseInt(Wisvalue.value)-parseInt(NWis.innerHTML)}
        for (var i=44; i<51;i++){eval ("if(N"+i+".innerHTML!=\"&nbsp;\"){I"+i+".value=parseInt(I"+i+".value)-parseInt(N"+i+".innerHTML)}");}
        for (var i=56; i<61;i++){eval ("if(N"+i+".innerHTML!=\"&nbsp;\"){I"+i+".value=parseInt(I"+i+".value)-parseInt(N"+i+".innerHTML)}");}
//        for (var i=56; i<61;i++){eval ("A"+i+".innerHTML=St["+i+"]+parseInt(I"+i+".value)");}
        ReCount();
}



function InitPlayer(DrItems) {

for (var i=0; i<DrItems.length; i++){
        for (var j=0; j<Clips.length; j++){
                if (DrItems[i]==Clips[j]){Clip.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Amulets.length; j++){
                if (DrItems[i]==Amulets[j]){Amulet.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<HArmor.length; j++){
                if (DrItems[i]==HArmor[j]){Armor.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Belts.length; j++){
                if (DrItems[i]==Belts[j]){Belt.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Helmets.length; j++){
                if (DrItems[i]==Helmets[j]){Helmet.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Naruchis.length; j++){
                if (DrItems[i]==Naruchis[j]){Naruchi.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Bootss.length; j++){
                if (DrItems[i]==Bootss[j]){Boots.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Braslets.length; j++){
                if (DrItems[i]==Braslets[j]){Braslet.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Rings.length; j++){
                if (DrItems[i]==Rings[j]){
                        r1=DetectItem(Ring1);
                        r2=DetectItem(Ring2);
                        r3=DetectItem(Ring3);
                        if (r1=="w6"){Ring1.src="img/o/"+DrItems[i]+".gif";} else {
                                if (r2=="w7"){Ring2.src="img/o/"+DrItems[i]+".gif";} else {
                                        if (r3=="w8"){Ring3.src="img/o/"+DrItems[i]+".gif";}
                                }
                        }
                }
        }
        for (var j=0; j<Shields.length; j++){
                if (DrItems[i]==Shields[j]){Shield.src="img/o/"+DrItems[i]+".gif";}
        }
        for (var j=0; j<Swords.length; j++){
                if (DrItems[i]==Swords[j]){
                        a=DetectItem(Weapon);
                        if (a=="w3") {Weapon.src="img/o/"+DrItems[i]+".gif";} else {
                                ind=0;
                                for (var k=0; k<SSwords.length; k++){
                                        if (DrItems[i]==SSwords[k]){ind=1;}
                                }
                                if (ind==1){Shield.src="img/o/"+DrItems[i]+".gif";}else {
                                        Shield.src="img/o/"+a+".gif";
                                        Weapon.src="img/o/"+DrItems[i]+".gif";
                                }
                        }
                }
        }
        for (var j=0; j<Axes.length; j++){
                if (DrItems[i]==Axes[j]){
                        a=DetectItem(Weapon);
                        if (a=="w3") {Weapon.src="img/o/"+DrItems[i]+".gif";} else {
                                ind=0;
                                for (var k=0; k<SAxes.length; k++){
                                        if (DrItems[i]==SSwords[k]){ind=1;}
                                }
                                if (ind==1){Shield.src="img/o/"+DrItems[i]+".gif";}else {
                                        Shield.src="img/o/"+a+".gif";
                                        Weapon.src="img/o/"+DrItems[i]+".gif";
                                }
                        }
                }
        }
        for (var j=0; j<Hammers.length; j++){
                if (DrItems[i]==Hammers[j]){
                        a=DetectItem(Weapon);
                        if (a=="w3") {Weapon.src="img/o/"+DrItems[i]+".gif";} else {
                                ind=0;
                                for (var k=0; k<SHammers.length; k++){
                                        if (DrItems[i]==SSwords[k]){ind=1;}
                                }
                                if (ind==1){Shield.src="img/o/"+DrItems[i]+".gif";}else {
                                        Shield.src="img/o/"+a+".gif";
                                        Weapon.src="img/o/"+DrItems[i]+".gif";
                                }
                        }
                }
        }
        for (var j=0; j<Knives.length; j++){
                if (DrItems[i]==Knives[j]){
                        a=DetectItem(Weapon);
                        if (a=="w3") {Weapon.src="img/o/"+DrItems[i]+".gif";} else {
                                ind=0;
                                for (var k=0; k<SKnives.length; k++){
                                        if (DrItems[i]==SSwords[k]){ind=1;}
                                }
                                if (ind==1){Shield.src="img/o/"+DrItems[i]+".gif";}else {
                                        Shield.src="img/o/"+a+".gif";
                                        Weapon.src="img/o/"+DrItems[i]+".gif";
                                }
                        }
                }
        }
        for (var j=0; j<Bukets.length; j++){
                if (DrItems[i]==Bukets[j]){
                        a=DetectItem(Weapon);
                        if (a=="w3") {Weapon.src="img/o/"+DrItems[i]+".gif";} else {
                                ind=0;
                                for (var k=0; k<SBukets.length; k++){
                                        if (DrItems[i]==SSwords[k]){ind=1;}
                                }
                                if (ind==1){Shield.src="img/o/"+DrItems[i]+".gif";}else {
                                        Shield.src="img/o/"+a+".gif";
                                        Weapon.src="img/o/"+DrItems[i]+".gif";
                                }
                        }
                }
        }
}

}
function Initialize() { InitStat(); }

function SaveComplect(){
        complect="";
        complect=levelvalue.value+"/"+Strvalue.value+"/"+Agvalue.value+"/"+Intvalue.value+"/"+Endvalue.value+"/"+Intelvalue.value+"/"+Wisvalue.value+"/"+Zat1.value+"/"+Zat2.value+"/"+I59.value+"/"+I57.value+"/"+I56.value+"/"+I58.value+"/"+I60.value+"/"+I47.value+"/"+I48.value+"/"+I49.value+"/"+I50.value+"/"+I45.value+"/"+I44.value+"/"+I46.value;
        Dr = new Array();
        Dr[1]=DetectItem(Helmet);
        Dr[2]=DetectItem(Weapon);
        Dr[3]=DetectItem(Armor);
        Dr[4]=DetectItem(Belt);
        Dr[5]=DetectItem(Clip);
        Dr[6]=DetectItem(Amulet);
        Dr[7]=DetectItem(Braslet);
        Dr[8]=DetectItem(Naruchi);
        Dr[9]=DetectItem(Ring1);
        Dr[10]=DetectItem(Ring2);
        Dr[11]=DetectItem(Ring3);
        Dr[12]=DetectItem(Shield);
        Dr[13]=DetectItem(Boots);
        Dr[14]=DetectItem(Shirt);
        for (var i=1; i<15;i++) {
                complect+="/"+Dr[i];
        }
        newWindow= new Object()                                                                           ;
        newWindow.document.write("<form method=post action=sc.php><input type=hidden name=complect value="+complect+">1111111111111111111111<input type=submit value=Сохранить >");
}

</SCRIPT>


      <DIV id=items
      style="BORDER-RIGHT: #dcdcdc 1px solid; BORDER-TOP: #dcdcdc 1px solid; Z-INDEX: 1; LEFT: 206px; VISIBILITY: hidden; OVERFLOW: visible; BORDER-LEFT: #dcdcdc 1px solid; WIDTH: 10px; BORDER-BOTTOM: #dcdcdc 1px solid; POSITION: absolute; TOP: 191px; HEIGHT: 10px; BACKGROUND-COLOR: #f4f4f4; layer-background-color: #f4f4f4"></DIV>
      <DIV id=info
      style="BORDER-RIGHT: #dcdcdc 1px solid; BORDER-TOP: #dcdcdc 1px solid; Z-INDEX: 1; LEFT: 206px; VISIBILITY: hidden; OVERFLOW: visible; BORDER-LEFT: #dcdcdc 1px solid; WIDTH: 10px; BORDER-BOTTOM: #dcdcdc 1px solid; POSITION: absolute; TOP: 191px; HEIGHT: 10px; BACKGROUND-COLOR: #f4f4f4; layer-background-color: #f4f4f4"></DIV>
      <DIV id=descr
      style="BORDER-RIGHT: #dcdcdc 1px solid; BORDER-TOP: #dcdcdc 1px solid; Z-INDEX: 1; LEFT: 206px; VISIBILITY: hidden; OVERFLOW: visible; BORDER-LEFT: #dcdcdc 1px solid; WIDTH: 10px; BORDER-BOTTOM: #dcdcdc 1px solid; POSITION: absolute; TOP: 191px; HEIGHT: 10px; BACKGROUND-COLOR: #f4f4f4; layer-background-color: #f4f4f4"></DIV>
      <DIV id=filter
      style="BORDER-RIGHT: #dcdcdc 1px solid; BORDER-TOP: #dcdcdc 1px solid; Z-INDEX: 1; LEFT: 10px; VISIBILITY: hidden; OVERFLOW: visible; BORDER-LEFT: #dcdcdc 1px solid; WIDTH: 10px; BORDER-BOTTOM: #dcdcdc 1px solid; POSITION: absolute; TOP: 350px; HEIGHT: 10px; BACKGROUND-COLOR: #f4f4f4; layer-background-color: #f4f4f4">
      <TABLE class=rh1 cellSpacing=2 cellPadding=2 border=0>
        <TBODY>
        <TR>
          <TD class=infostyle>Показывать <SELECT size=1 name=ImportSelect>
              <OPTION value=0>все вещи</OPTION> <OPTION value=1 selected>только
              из русской версии</OPTION></SELECT></TD></TR>
        <TR>
          <TD class=infostyle>Вещи <SELECT size=1 name=ItemsSelect> <OPTION
              value=0>показывать все</OPTION> <OPTION value=1 selected>только
              новые</OPTION></SELECT></TD></TR>
        <TR>
          <TD class=infostyle><NOBR>Уровень от <INPUT maxLength=3 size=3
            value=0 name=levelfrom> до <INPUT maxLength=3 size=3 value=21
            name=levelto> уровня</NOBR></TD></TR>
        <TR>
          <TD class=infostyle><NOBR>Показывать вещи, дающие <SELECT
            name=MfSelect> <OPTION value=0 selected></OPTION> <OPTION
              value=25>Сила</OPTION> <OPTION value=26>Ловкость</OPTION> <OPTION
              value=27>Интуиция</OPTION> <OPTION value=28>Интеллект</OPTION>
              <OPTION value=29>Крит</OPTION> <OPTION value=30>Антикрит</OPTION>
              <OPTION value=31>Мощность</OPTION> <OPTION
              value=32>Уворот</OPTION> <OPTION value=33>Антиуворот</OPTION>
              <OPTION value=34>Контрудар</OPTION> <OPTION value=35>Удар сквозь
              броню</OPTION> <OPTION value=36>Парирование</OPTION> <OPTION
              value=37>Блок щитом</OPTION></SELECT></NOBR></TD></TR>
        <TR>
          <TD align=middle><A class=closestyle
            onclick="filter.style.visibility='hidden'"
            href=""></A></TD></TR></TBODY></TABLE></DIV>
      <p></p>
      <TABLE border=0 height="56">
      
        <TBODY>
        <TR>
        
        
        
                      <TD id=BrasletCanvas width=62 height=16></TD></TR>
                      <TD id=ClipCanvas width=62 height=14><b>Переодевалка</b></TD></TR>
                      <TD id=BootsCanvas width=62 height=18></TD>

      <TABLE border=0>
        <TBODY>
        <TR>
          <TD vAlign=top width="198">
            <TABLE cellSpacing=2 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD width=10 height=10></TD>
                <TD height=10><IMG height=8
                  src="1green.gif"
                  width="100%"></TD>
                <TD class=infostylebold id=fullHP align=right width=30
                  height=10>0</TD></TR>
              <TR>
                <TD width=10 height=10></TD>
                <TD height=10><IMG height=8
                  src="Mherz.gif"
                  width="100%"></TD>
                <TD class=infostylebold id=fullMana align=right width=30
                height=10>0</TD></TR></TBODY></TABLE>
            <TABLE height=244 cellSpacing=0 cellPadding=0 width=187
            bgColor=#e1e1e1 border=0 background="w15.gif">
              <TBODY>
              <TR>
                <TD vAlign=top width=60 height=244 rowspan="2">
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 height="245">
                    <TBODY>
                    <TR>
                      <TD id=HelmetCanvas width=62 height=40><IMG
                        oncontextmenu="ShowItems(Braslets); return false"
                        id=Braslet onmouseover=ShowAlt(Braslet)
                        onclick=UndressItem(Braslet)
                        onmouseout="info.style.visibility='hidden'" height=40
                        src="w13.gif"
                        width=62></TD></TR>
                    <TR>
                      <TD id=WeaponCanvas width=62 height=91><IMG
                        oncontextmenu="ChooseItems(Weapon); return false"
                        id=Weapon onmouseover=ShowAlt(Weapon)
                        onclick=UndressItem(Weapon)
                        onmouseout="info.style.visibility='hidden'" height=91
                        src="w3.gif"
                        width=62></TD></TR>
                    <TR>
                      <TD id=ArmorCanvas width=60 height=83>
						<IMG
                        oncontextmenu="ChooseItems(Armor); return false"
                        id=Armor onmouseover=ShowAlt(Armor)
                        onclick=UndressItem(Armor)
                        onmouseout="info.style.visibility='hidden'" height=83
                        src="w4.gif"
                        width=62></TD></TR>
                    <TR>
                      <TD id=BeltCanvas width=62 height=31>
						<IMG
                        oncontextmenu="ShowItems(Belts); return false" id=Belt
                        onmouseover=ShowAlt(Belt) onclick=UndressItem(Belt)
                        onmouseout="info.style.visibility='hidden'" height=33
                        src="w5.gif"
                        width=62></TD></TR></TBODY></TABLE></TD>
                <TD vAlign=top width=63 height=244 rowspan="2">
                  <TABLE cellSpacing=0 cellPadding=0 width="88%" border=0 height="228">
                    <TBODY>
                    <TR>
                      <TD width=63 height=55>
<IMG
                        oncontextmenu="ShowItems(Helmets); return false"
                        id=Helmet onmouseover=ShowAlt(Helmet)
                        onclick=UndressItem(Helmet)
                        onmouseout="info.style.visibility='hidden'" height=65
                        src="w9.gif"
                        width=63></DIV></TD></TR>
                    <TR>
                      <TD width=63 height=80>
                        <TABLE cellSpacing=0 cellPadding=0 width="78%"
border=0>
                          <TBODY>
                          <TR>
                          
                            <TD id=ShirtCanvas width=60>
							<IMG
                              oncontextmenu="ShowItems(Shirts); return false"
                              id=Shirt onmouseover=ShowAlt(Shirt)
                              onclick=UndressItem(Shirt)
                              onmouseout="info.style.visibility='hidden'"
                              height=80
                              src="w16.gif"
                              width=63></TD>
                            </TR></TBODY></TABLE></TD></TR>
                    <TR>
                      <TD width=63 height=62>
                        <IMG
                        oncontextmenu="ShowItems(Bootss); return false" id=Boots
                        onmouseover=ShowAlt(Boots) onclick=UndressItem(Boots)
                        onmouseout="info.style.visibility='hidden'" height=62
                        src="w12.gif"
                        width=63></TD></TR>
                    <TR>
                      <TD width=63 height=21>
                        <TABLE height=20 cellSpacing=0 cellPadding=0
                        width="100%" border=0>
                          <TBODY>
                          <TR>
                            <TD id=El1Canvas width=20 height=20>
							<IMG id=El1
                              height=20
                              src="0.gif"
                              width=21></TD>
                            <TD id=El2Canvas width=22 height=20>
							<IMG
                        oncontextmenu="ShowItems(Clips); return false" id=Clip
                        onmouseover=ShowAlt(Clip) onclick=UndressItem(Clip)
                        onmouseout="info.style.visibility='hidden'" height=20
                        src="w1.gif"
                        width=22></TD>
                            <TD id=El2Canvas width=21 height=20>
							<IMG id=El2
                              height=20
                              src="0.gif"
                              width=20></TD></TR>
                          <TR>
                            <TD id=El1Canvas width=20 height=20>
							<img border="0" src="0.gif" width="21" height="20"></TD>
                            <TD id=El2Canvas width=22 height=20>
							<img border="0" src="0.gif" width="22" height="20"></TD>
                            <TD id=El2Canvas width=21 height=20>
							<img border="0" src="0.gif" width="20" height="20"></TD></TR></TBODY></TABLE></TD></TR>
                    <TR>
                     </TD></TR></TBODY></TABLE>
					</TD>
                <TD vAlign=top width=62 height=120>
                  <TABLE cellSpacing=0 cellPadding=0 width="87%" border=0 height="186">
                    <TBODY>
                    <TR>
                                          <TR>
                      <TD id=AmuletCanvas width=62 height=35><IMG
                        oncontextmenu="ShowItems(Amulets); return false"
                        id=Amulet onmouseover=ShowAlt(Amulet)
                        onclick=UndressItem(Amulet)
                        onmouseout="info.style.visibility='hidden'" height=35
                        src="w2.gif"
                        width=62></TD></TR>
                                        <TR>
                      <TD id=NaruchiCanvas width=62 height=40><IMG
                        oncontextmenu="ShowItems(Naruchis); return false"
                        id=Naruchi onmouseover=ShowAlt(Naruchi)
                        onclick=UndressItem(Naruchi)
                        onmouseout="info.style.visibility='hidden'" height=40
                        src="w11.gif"
                        width=62></TD></TR>
                    <TR>
                      <TD width=62 height=20>
                        <TABLE cellSpacing=0 cellPadding=0 width="100%"
border=0>
                          <TBODY>
                          <TR>
                            <TD id=Ring1Canvas width=20 height=20><IMG
                              oncontextmenu="ShowItems(Rings1); return false"
                              id=Ring1 onmouseover=ShowAlt(Ring1)
                              onclick=UndressItem(Ring1)
                              onmouseout="info.style.visibility='hidden'"
                              height=20
                              src="w6.gif"
                              width=20></TD>
                            <TD id=Ring2Canvas width=20 height=20><IMG
                              oncontextmenu="ShowItems(Rings2); return false"
                              id=Ring2 onmouseover=ShowAlt(Ring2)
                              onclick=UndressItem(Ring2)
                              onmouseout="info.style.visibility='hidden'"
                              height=20
                              src="w7.gif"
                              width=20></TD>
                            <TD id=Ring3Canvas width=22 height=20><IMG
                              oncontextmenu="ShowItems(Rings3); return false"
                              id=Ring3 onmouseover=ShowAlt(Ring3)
                              onclick=UndressItem(Ring3)
                              onmouseout="info.style.visibility='hidden'"
                              height=20
                              src="w8.gif"
                              width=20></TD></TR></TBODY></TABLE></TD></TR>
                    <TR>
                      <TD id=ShieldCanvas width=62 height=91><IMG
                        oncontextmenu="ChooseItems(Shield); return false"
                        id=Shield onmouseover=ShowAlt(Shield)
                        onclick=UndressItem(Shield)
                        onmouseout="info.style.visibility='hidden'" height=91
                        src="w10.gif"
                        width=62></TD></TR>
                    <TR>
                      </TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD vAlign=top width=62 height=58>
                  <img border="0" src="w15.gif" width="62" height="61"></TD></TR></TBODY></TABLE><INPUT class=butt style="WIDTH: 198px" onclick=SetStats(); type=button value="Подогнать статы"><BR>&nbsp;<INPUT class=butt style="WIDTH: 198px" onclick=InitItems() type=button value=Раздеть><BR><INPUT class=butt style="WIDTH: 198px" onclick="InitItems(); InitStat()" type=button value="Раздеть и обнулить"><BR><!--        <input type=button onClick="SaveComplect();" class="butt" value="Запомнить комплект" style='width: 198'><br>
 --></TD>
          <TD vAlign=top bgColor=#e1e1e1>
            <TABLE cellSpacing=2 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=levelvalue onchange=Correct(levelvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NLevel width=30>&nbsp;</TD>
                <TD class=actstatstyle id=ActLevel width=30>0</TD>
                <TD class=statstyle>уровень</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Strvalue onchange=Correct(Strvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NStr>&nbsp;</TD>
                <TD class=actstatstyle id=ActStr>0</TD>
                <TD class=statstyle>сила</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Agvalue onchange=Correct(Agvalue) size=2
                  value=0></TD>
                <TD class=needstatstyle id=NAg>&nbsp;</TD>
                <TD class=actstatstyle id=ActAg>0</TD>
                <TD class=statstyle>ловкость</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Intvalue onchange=Correct(Intvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NInt>&nbsp;</TD>
                <TD class=actstatstyle id=ActInt>0</TD>
                <TD class=statstyle>интуиция</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Endvalue onchange=Correct(Endvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NEnd>&nbsp;</TD>
                <TD class=actstatstyle id=ActEnd>0</TD>
                <TD class=statstyle>выносливость</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Intelvalue onchange=Correct(Intelvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NIntel>&nbsp;</TD>
                <TD class=actstatstyle id=ActIntel>0</TD>
                <TD class=statstyle>интеллект</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD width=5><INPUT id=Wisvalue onchange=Correct(Wisvalue)
                  size=2 value=0></TD>
                <TD class=needstatstyle id=NWis>&nbsp;</TD>
                <TD class=actstatstyle id=ActWis>0</TD>
                <TD class=statstyle>мудрость</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=actstatstyle id=AllStat>
                  <CENTER>0</CENTER></TD>
                <TD class=needstatstyle id=NAllStat>&nbsp;</TD>
                <TD class=actstatstyle id=ActAllStat>0</TD>
                <TD class=statstyle>сумма статов</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A23>0</TD>
                <TD class=statstyle>вес вещей</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A22>0</TD>
                <TD class=statstyle>стоимость вещей</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S70>&nbsp;</TD>
                <TD class=actstatstyle id=A70>2</TD>
                <TD class=statstyle>min урон</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S71>&nbsp;</TD>
                <TD class=actstatstyle id=A71>5</TD>
                <TD class=statstyle>max урон</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD><INPUT id=Zat2 onchange=Correct(Zat2) size=2 value=0></TD>
                <TD><INPUT id=Zat1 onchange=Correct(Zat1) size=2 value=0></TD>
                <TD class=statstyle>заточка</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A42>0</TD>
                <TD class=statstyle>+ HP</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A43>0</TD>
                <TD class=statstyle>+ мана</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A25>0</TD>
                <TD class=statstyle>+ сила</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A26>0</TD>
                <TD class=statstyle>+ ловкость</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A27>0</TD>
                <TD class=statstyle>+ интуиция</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A28>0</TD>
                <TD class=statstyle>+ интеллект</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A66>0</TD>
                <TD class=statstyle>броня головы</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A67>0</TD>
                <TD class=statstyle>броня корпуса</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A68>0</TD>
                <TD class=statstyle>броня пояса</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A69>0</TD>
                <TD class=statstyle>броня ног</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S29>&nbsp;</TD>
                <TD class=actstatstyle id=A29>0</TD>
                <TD class=statstyle>мф критического удара</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A30>0</TD>
                <TD class=statstyle>мф против критического удара</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A32>0</TD>
                <TD class=statstyle>мф увертывания</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S33>&nbsp;</TD>
                <TD class=actstatstyle id=A33>0</TD>
                <TD class=statstyle>мф против увертывания</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S31>&nbsp;</TD>
                <TD class=actstatstyle id=A31>0</TD>
                <TD class=statstyle>мф мощности критического удара</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A34>0</TD>
                <TD class=statstyle>мф контрудара</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S35>&nbsp;</TD>
                <TD class=actstatstyle id=A35>0</TD>
                <TD class=statstyle>мф удара сквозь броню</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A36>0</TD>
                <TD class=statstyle>мф парирования</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A37>0</TD>
                <TD class=statstyle>мф блока щитом</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A76>0</TD>
                <TD class=statstyle>мф восстановления HP</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A89>0</TD>
                <TD class=statstyle>мф восстановления маны</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S38>&nbsp;</TD>
                <TD class=actstatstyle id=A38>0</TD>
                <TD class=statstyle>мф мощности рубящего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S40>&nbsp;</TD>
                <TD class=actstatstyle id=A40>0</TD>
                <TD class=statstyle>мф мощности колющего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S41>&nbsp;</TD>
                <TD class=actstatstyle id=A41>0</TD>
                <TD class=statstyle>мф мощности режущего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=S39>&nbsp;</TD>
                <TD class=actstatstyle id=A39>0</TD>
                <TD class=statstyle>мф мощности дробящего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A51>0</TD>
                <TD class=statstyle>защита от магии</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A86>0</TD>
                <TD class=statstyle>защита от магии света</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A87>0</TD>
                <TD class=statstyle>защита от магии тьмы</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A88>0</TD>
                <TD class=statstyle>защита от нейтральной магии</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A52>0</TD>
                <TD class=statstyle>защита от магии огня</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A53>0</TD>
                <TD class=statstyle>защита от магии воды</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A54>0</TD>
                <TD class=statstyle>защита от магии воздуха</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A55>0</TD>
                <TD class=statstyle>защита от магии земли</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A61>0</TD>
                <TD class=statstyle>защита от урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A63>0</TD>
                <TD class=statstyle>защита от колющего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A62>0</TD>
                <TD class=statstyle>защита от рубящего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A64>0</TD>
                <TD class=statstyle>защита от режущего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD class=actstatstyle id=A65>0</TD>
                <TD class=statstyle>защита от дробящего урона</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I59 onchange=Correct(I59) size=2 value=0></TD>
                <TD class=needstatstyle id=N59>&nbsp;</TD>
                <TD class=actstatstyle id=A59>0</TD>
                <TD class=statstyle>+ к владению ножами и кинжалами</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I57 onchange=Correct(I57) size=2 value=0></TD>
                <TD class=needstatstyle id=N57>&nbsp;</TD>
                <TD class=actstatstyle id=A57>0</TD>
                <TD class=statstyle>+ к владению топорами и секирами</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I56 onchange=Correct(I56) size=2 value=0></TD>
                <TD class=needstatstyle id=N56>&nbsp;</TD>
                <TD class=actstatstyle id=A56>0</TD>
                <TD class=statstyle>+ к владению мечами</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I58 onchange=Correct(I58) size=2 value=0></TD>
                <TD class=needstatstyle id=N58>&nbsp;</TD>
                <TD class=actstatstyle id=A58>0</TD>
                <TD class=statstyle>+ к владению булавами и дубинами</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I60 onchange=Correct(I60) size=2 value=0></TD>
                <TD class=needstatstyle id=N60>&nbsp;</TD>
                <TD class=actstatstyle id=A60>0</TD>
                <TD class=statstyle>+ к владению посохами</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD class=rh colSpan=4 height=1><IMG height=1
                  src="transp.gif"
                  width=1></TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I47 onchange=Correct(I47) size=2 value=0></TD>
                <TD class=needstatstyle id=N47>&nbsp;</TD>
                <TD class=actstatstyle id=A47>0</TD>
                <TD class=statstyle>+ к владению магией огня</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I48 onchange=Correct(I48) size=2 value=0></TD>
                <TD class=needstatstyle id=N48>&nbsp;</TD>
                <TD class=actstatstyle id=A48>0</TD>
                <TD class=statstyle>+ к владению магией воды</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I49 onchange=Correct(I49) size=2 value=0></TD>
                <TD class=needstatstyle id=N49>&nbsp;</TD>
                <TD class=actstatstyle id=A49>0</TD>
                <TD class=statstyle>+ к владению магией воздуха</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I50 onchange=Correct(I50) size=2 value=0></TD>
                <TD class=needstatstyle id=N50>&nbsp;</TD>
                <TD class=actstatstyle id=A50>0</TD>
                <TD class=statstyle>+ к владению магией земли</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I45 onchange=Correct(I45) size=2 value=0></TD>
                <TD class=needstatstyle id=N45>&nbsp;</TD>
                <TD class=actstatstyle id=A45>0</TD>
                <TD class=statstyle>+ к владению магией света</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I44 onchange=Correct(I44) size=2 value=0></TD>
                <TD class=needstatstyle id=N44>&nbsp;</TD>
                <TD class=actstatstyle id=A44>0</TD>
                <TD class=statstyle>+ к владению магией тьмы</TD></TR>
              <TR bgColor=#f4f4f4>
                <TD><INPUT id=I46 onchange=Correct(I46) size=2 value=0></TD>
                <TD class=needstatstyle id=N46>&nbsp;</TD>
                <TD class=actstatstyle id=A46>0</TD>
                <TD class=statstyle>+ к владению серой
            магией</TD>
        </tr>
      </table>
</td></tr></table>
<td  align="left" width="10%" bgcolor="#3D3D3B"></vid>
    </vid>
<SCRIPT language="JavaScript1.2"><!--
if (document.all)
document.write('<DIV ID="object1" style="Position : Absolute ;Left : 0px ;Top : 50px ;Width : 0px ;Z-Index : 20">')//-->
</SCRIPT>
<div id="Layer1" style="position:absolute; width:200px; height:189px; z-index:1; left: 71px; top: 126px">
  &nbsp;</div>
<div id="Layer3" style="position:absolute; width:200px; height:115px; z-index:3; left: 52px; top: -73px;">&nbsp;</div>
<div id="Layer4" style="position:absolute; width:88px; height:165px; z-index:4; left: 29px; top: 397px;"><br><br><br>
<div id="Layer5" style="position:absolute; width:89px; height:85px; z-index:1; left: 10px; top: 1px;">
    <p><br><br><br> </p>
    <p>
    
		<tr>
                <td valign="top" height="1%" bgcolor="#000000" colspan="4">
<p align="center"><font color="#FFFFFF"><span class="style6">Copyright © </span>
Скрипт разработан <span lang="en-us">&quot;Webmoney-Vl&quot; </span>в 2007 году</font></tr>

    
</html>