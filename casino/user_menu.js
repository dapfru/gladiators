var ie4, nn4, nn6;
var rX, lX, tY, bY;
var zi=100;
ie4 = nn4 = nn6 = 0;
if(document.all)
	{ie4=1; document.body.onmousemove=updateIt;}
if(document.layers)
	{nn4=1; window.captureEvents(Event.MOUSEMOVE); window.onmousemove=updateIt;}
if(document.getElementById&&!ie4)
	{nn6=1; document.body.onmousemove=updateIt;}
	
function dropit(e,oIEorNN6s,sOneNN,xMenu){
	if(ie4){
		oneIE = oIEorNN6s;
		if (window.themenu&&themenu.id!=oneIE.id)
			themenu.style.visibility="hidden";
		themenu=oneIE;
		themenu.style.left=document.body.scrollLeft+event.clientX-event.offsetX;
		themenu.style.top=document.body.scrollTop+event.clientY-event.offsetY+22;
		lX=themenu.style.posLeft-document.body.scrollLeft;
		rX=lX+themenu.offsetWidth;
		tY=themenu.style.posTop-document.body.scrollTop-25;
		bY=themenu.offsetHeight+tY+25;
		//updateIt(oneIE);
		if (themenu.style.visibility=="hidden"){
			themenu.style.visibility="visible";
			themenu.style.zIndex=zi++;
		}
	}
	if(nn4){
		if (window.themenu&&themenu.id!=eval(sOneNN).id)
			themenu.visibility="hide";
		themenu=eval(sOneNN);
		if (themenu.visibility=="hide")
			themenu.visibility="show";
		themenu.zIndex++;
		themenu.left=e.pageX-e.layerX;
		themenu.top=e.pageY-e.layerY+16;
		lX=themenu.left;
		rX=lX+themenu.clip.width;
		tY=themenu.top-25;
		bY=themenu.top+themenu.clip.height;
		return false;
	}
	if(nn6){
		oneNN = document.getElementById(oIEorNN6s); //eval(sOneNN);
		if (window.themenu&&themenu.id!=oneNN.id)
			themenu.style.visibility="hidden";
		themenu=oneNN;
		themenu.style.left=xMenu;
		themenu.style.top=82;
		lX=parseInt(themenu.style.left);
		rX=lX+themenu.offsetWidth;
		tY=parseInt(themenu.style.top);
		bY=themenu.offsetHeight+tY+25;
		//updateIt(oneNN);
		if (themenu.style.visibility=="hidden"){
			themenu.style.visibility="visible";
			themenu.style.zIndex=zi++;
			
		}
	}
}

function hidemenu (whichone){
	if(ie4) hidemenu1 (whichone);
	if(nn6) hidemenu3();
	if(nn4) hidemenu2();
}

function hidemenu1(whichone){
	if(window.themenu)
		themenu.style.visibility="hidden";
	hidemenu2();
}

function hidemenu2(){
	if(typeof(themenu)!="undefined")
		themenu.visibility="hide";
}

function hidemenu3(){
	if (themenu.style.visibility=="visible")
		themenu.style.visibility="hidden";
}

function updateIt(oneIE){
	var x,y
	if(ie4){
		x=window.event.clientX;
		y=window.event.clientY;
		if(x>rX || x<lX) hidemenu(oneIE);
		else if(y>bY+1 || y<tY) hidemenu1(oneIE);
	}
	if(nn6){
		x=oneIE.clientX;
		y=oneIE.clientY;
		if(x>rX || x<lX) hidemenu3();
		else if(y>bY+1 || y<tY-30) hidemenu3();
	}
	if(nn4){
		x=oneIE.pageX;
		y=oneIE.pageY;
		if(x>rX || x<=lX-1) hidemenu2();
		else if(y>bY || y<tY) hidemenu2();
	}
}
