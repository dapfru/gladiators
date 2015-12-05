function CheckAll() {
	var fmobj = document.reputation_form;
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if (e.type=='checkbox') {
			e.checked = fmobj.allitems.checked;
		}
	}
}

function insert_clan_plus_login() {
   align = window.prompt("Склонность клана (0 - без склонности, 0.5 - нейтральная склонность, 3 - темная", "3")
   clan = window.prompt("Введите название клана", "Censored")
   login = window.prompt("Введите логин персонажа", "И..")
   level = window.prompt("Введите уровень персонажа", "8")
   if (!align || !clan || !login || !level) alert("Что-то вы там неправильно написали...=)")
   else {

   newspost.newstext.value=newspost.newstext.value+"<img src='/img/bk/align/align"+align+".gif' width='12' height='15'><a href='http://capitalcity.combats.ru/encicl/klan/"+clan+".html' target='_blank'><img src='/img/bk/clans/"+clan+".gif' border='0' width='24' height='15'></a><a href='http://capitalcity.combats.ru/inf.pl?login="+login+"' target='_blank'><b>"+login+"</b></a> ["+level+"]"
   }
}
function insert_clan() {
   clan = window.prompt("Введите название клана", "Censored")
   align = window.prompt("Склонность клана (0 - без склонности, 0.5 - нейтральная склонность, 3 - темная", "3")
   if (!clan || !align) alert("Что-то вы там неправильно написали...=)")
   else {
   
   newspost.newstext.value=newspost.newstext.value+"<img src='/img/bk/align/align"+align+".gif' width='12' height='15'><a href='http://capitalcity.combats.ru/encicl/klan/"+clan+".html' target='_blank'><img src='/img/bk/clans/"+clan+".gif' border='0' width='24' height='15'><b>"+clan+"</b></a>"
   
   }
}
function insert_login() {
   login = window.prompt("Введите ник персонажа", "И..")
   align = window.prompt("Склонность персонажа (0 - без склонности, 0.5 - нейтральная склонность, 3 - темная", "3")
   level = window.prompt("Введите уровень персонажа", "8")
   if (!login || !align || !level) alert("Что-то не заполнено...")
   else {
   
   newspost.newstext.value=newspost.newstext.value+"<img src='/img/bk/align/align"+align+".gif' width='12' height='15'><a href='http://capitalcity.combats.ru/inf.pl?login="+login+"' target='_blank'><b>"+login+"</b></a> ["+level+"]"
   
   }
}
function insert_url() {
   url = window.prompt("Введите ссылку", "http://censored.com.ua/")
   text_url = window.prompt("Введите название ссылки", "Наш сайт")
   if (!url || !text_url) alert("Что-то не заполнено...")
   else {
   
   newspost.newstext.value=newspost.newstext.value+"<a href='"+url+"' target='_blank'><b>"+text_url+"</b></a>"
   
   }
}
function insert_img() {
   img = window.prompt("Введите ссылку на картинку", "http://www.combats.ru/i/smile/help.gif")
   if (!img) return false;
   else {
   
   newspost.newstext.value=newspost.newstext.value+"<img src='"+img+"'>"
   
   }
}
function clear_field(field)
{
    if (field.value==field.defaultValue)
    {
        field.value=''
    }
}

function check_field(field)
{
    if (field.value=='' ||
    field.value==' ')
    {
        field.value=field.defaultValue
    }
}

function close_menu(name)
{
	document.all[name+"_menu"].style.visibility="hidden";
	document.all[name+"_menu_cl"].style.visibility="visible";
}

function open_menu(name)
{
	document.all[name+"_menu"].style.visibility="visible";
	document.all[name+"_menu_cl"].style.visibility="hidden";
}

function PLogin(login)
{
   newpost.newpost.value = newpost.newpost.value+"[b]"+login+", [/b]";
   newpost.newpost.focus();
}

function copy(login)
{
	var link = "private ["+login+"]";
	window.clipboardData.setData('Text', link);
}

function CheckSubmit(tocheack){
 if (document.all || document.getElementById){
     for (i=0; i < tocheack.length;i++){
          if(tocheack.elements[i].type.toLowerCase()=="submit"||tocheack.elements[i].type.toLowerCase()=="reset") {
             tocheack.elements[i].disabled = true
            }
         }
    }
}

function doInsert(str)
{
alert("Test");
newspost.newstext.value = str;
}

function gallery(id,c1,c2)
	{ window.open('pfs.php?m=gallery&id='+id+'&c1='+c1+'&c2='+c2,'PFS','status=1, toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=754,height=512,left=32,top=16'); }

function pfs(id,c1,c2)
	{ window.open('pfs.php?c1='+c1+'&c2='+c2,'PFS','status=1, toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=754,height=512,left=32,top=16'); }

function help(rcode,c1,c2)
	{ window.open('plug.php?h='+rcode+'&c1='+c1+'&c2='+c2,'Help','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=32,top=16'); }

function comments(rcode)
	{ window.open('comments.php?id='+rcode,'Comments','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function ratings(rcode)
	{ window.open('ratings.php?id='+rcode,'Ratings','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function polls(rcode)
	{ window.open('polls.php?id='+rcode,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function pollvote(rcode,rvote)
	{ window.open('polls.php?a=send&id='+rcode+'&vote='+rvote,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function picture(url,sx,sy)
	{ window.open('pfs.php?m=view&id='+url,'Picture','toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width='+sx+',height='+sy+',left=0,top=0'); }

function redirect(url)
	{ location.href = url.options[url.selectedIndex].value; }