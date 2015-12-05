var sliders = new Array();
var targetSlider = null;
var posX = 0;
var sliderValue = 0;

//---class Slider
function Slider(name)
{
	this.name = name;
	this.value = 0;
	this.enableHint = false;
	this.canChangeInput = true;
}
Slider.prototype.EnableHint = function()
{
	this.enableHint = true;
}
Slider.prototype.GetHintState = function()
{
	return this.enableHint;
}
Slider.prototype.SetValuePixel = function(value)
{
	var val=this.MinValue + parseInt(value*this.Koef);

	this.SetValue(val);

	if(val<0) val=0;
	if(val>100) val=100;


	updatetrain(val,this);
	

}


Slider.prototype.SetValue = function(value)
{
	if(!value)
		value = 0;
	if(value > this.MaxValue)
	{
		this.value = this.MaxValue;
	}
	else if(value < this.MinValue)
	{
		this.value = this.MinValue;
	}
	else
	{
		this.value = value;
	}
	this.SliderBTDiv.style.left = (parseInt(this.value-this.MinValue)/this.Koef)+"px";
	canChangeInput = false;
	this.InputElement.value = this.value;
	canChangeInput = true;
	this.SliderHint.innerHTML = this.value+this.GetVar();
}
Slider.prototype.GetValue = function()
{
	return this.value;
}
Slider.prototype.GetValuePixel = function()
{
	return (parseInt(this.value-this.MinValue)/this.Koef);
}
Slider.prototype.GetVar = function()
{
	var vars = this.Vars.split(',');
	for(var i=0; i<vars.length;i++)
	{
		var vr = vars[i].split('(');
		if(!vr[1])
		   break;
		var numbers = vr[1].substring(0,vr[1].length-1).split(':');
		if(this.value >= parseInt(numbers[0]) && this.value <= parseInt(numbers[1]))
			return vr[0];
	}
	return "";
}
Slider.prototype.StartListen = function()
{
	this.SliderBTDiv.onmousedown = onSliderBTMouseDown;
	this.SliderBTDiv.onmouseover = onSliderBTMouseEnter;
	this.SliderBTDiv.onmouseout = onSliderBTMouseLeave;
	if(!document.all)
	{
		this.InputElement.addEventListener("change",onSliderInputElementChange,false);
	}
	else
	{
		this.InputElement.attachEvent("onchange",onSliderInputElementChange);
	}
	
	this.Koef = (this.MaxValue - this.MinValue)/(parseInt(this.SliderBGDiv.style.width) - parseInt(this.SliderBTDiv.style.width));
}
//----end class SLider
function getSliderByBT(bt)
{
	for(var i=0; i<sliders.length; i++)
	{
		if(sliders[i].SliderBTDiv == bt)
			return sliders[i];
	}
}
function getSliderByInput(input)
{
	for(var i=0; i<sliders.length; i++)
	{
		if(sliders[i].InputElement ==input)
			return sliders[i];
	}
}
function onSliderInputElementChange(evt)
{



	var el = (!document.all)?evt.target:window.event.srcElement;
	var slider = getSliderByInput(el);
	if(canChangeInput)
		slider.SetValue(el.value)
}
function onSliderBTMouseLeave(evt)
{
	var bt = (!document.all)?evt.target:window.event.srcElement;
	var slider = getSliderByBT(bt);
	if(!targetSlider)
		slider.SliderHint.style.display = "none";


	
}
function onSliderBTMouseEnter(evt)
{
	var bt = (!document.all)?evt.target:window.event.srcElement;
	var slider = getSliderByBT(bt);
	if(slider.GetHintState())
	{
		var X = (!document.all) ?evt.pageX : event.clientX+document.body.scrollLeft;
		var Y = (!document.all) ?evt.pageY : event.clientY+document.body.scrollTop;
		with(slider.SliderHint.style)
		{
			left = X-50+"px";
			top = Y+10+"px";
			display = "block";
			zIndex = 1000;
		}
	}


	
}
function onSliderBTMouseDown(evt)
{
	var bt = (!document.all)?evt.target:window.event.srcElement;
	targetSlider = getSliderByBT(bt);
	posX = (!document.all)?evt.clientX:window.event.clientX;
	sliderValue = targetSlider.GetValuePixel();
}
window.document.onmouseup = function(evt)
{
	if(targetSlider)
		targetSlider.SliderHint.style.display = "none";
	targetSlider = null;
}
if(!document.all)
{
	window.document.addEventListener("mousemove",myMove,false);
}
else
{
	window.document.attachEvent("onmousemove",myMove);
}

function myMove(evt)
{
	if(targetSlider)
	{
		var X =  (!document.all) ?evt.pageX : event.clientX+document.body.scrollLeft;
		var Y = (!document.all) ?evt.pageY : event.clientY+document.body.scrollTop;
		

		targetSlider.SetValuePixel(parseInt(sliderValue)+parseInt(X-posX));
		if(targetSlider.GetHintState())
		{
			with(targetSlider.SliderHint.style)
			{		
				left = X-50+"px";
				top = Y+10+"px";
			}
		}
		
	}


}


function MakeSlider(inputElement, imgBackground, imgButton, minValue, maxValue, vars)
{

	var id=eval(inputElement.id.substring(4,10))-1;


	if(eval(getElementByName('Injury['+id+']').value)>0)
	{

		var ErrorDiv = document.createElement("div");
		ErrorDiv.innerHTML='<a href=recovery.php>травмирован</a>';
		inputElement.parentNode.appendChild(ErrorDiv);

		inputElement.style.display = "none";



		updatestamina(0,inputElement);


	}
	else if(eval(getElementByName('Trainer['+id+']').value)==0)
	{

		var ErrorDiv = document.createElement("div");
		ErrorDiv.innerHTML='';
		inputElement.parentNode.appendChild(ErrorDiv);

		inputElement.style.display = "none";



		updatestamina(0,inputElement);
	}
	else
	{



	var sliderBackgroundDiv = document.createElement("div");
	var sliderButtonDiv = document.createElement("div");
	var sliderHint = document.createElement("div");
	
	var slider = new Slider(inputElement.name);
	slider.InputElement = inputElement;
	slider.MinValue = minValue;
	slider.MaxValue = maxValue;
	slider.id = inputElement.id;
	slider.SliderBGDiv = sliderBackgroundDiv;
	slider.SliderBTDiv = sliderButtonDiv;
	slider.SliderHint = sliderHint; 
	slider.Vars = vars;
	slider.EnableHint();
	window.sliders.push(slider);
	

	with(sliderHint.style)
	{
		height = "20px";
		border = "1px solid black";
		backgroundColor = "#CBFF9B";
		position = "absolute";
		display = "none";
		padding = "2px";
	}

	with(sliderBackgroundDiv.style)
	{
		width = imgBackground.width+"px";
		backgroundColor = "#78746C";
		height = imgBackground.height+"px";
		backgroundImage = "url("+imgBackground.src+")";
		position = "relative";
	}
	with(sliderButtonDiv.style)
	{
		backgroundColor = "#D0D7E2";
		width = imgButton.width+"px";
		height = imgButton.height+"px";
		top = ((parseInt(sliderBackgroundDiv.style.height)/2)-(parseInt(height)/2))+"px";
		backgroundImage = "url("+imgButton.src+")";
		cursor = "pointer";
		position = "absolute";
	}



	inputElement.parentNode.appendChild(sliderBackgroundDiv);
	sliderBackgroundDiv.appendChild(sliderButtonDiv);



	slider.StartListen();
	slider.SetValue(inputElement.value);
	

	updatetrain(inputElement.value,slider);

	inputElement.style.display = "none";

	}
}

function restore()
{

	var inputs = document.getElementsByTagName("input");

	for(var i=0; i<inputs.length; i++)
	{
		if(inputs[i].className == "slider")
		{
			slider=getSliderByInput(inputs[i]);

			slider.SetValue(document.getElementById('percent'+slider.id).value);

			updatetrain(inputs[i].value,slider);

		}

	}
	
}

function updatetrain(val,slider)
{
	var id=eval(slider.id.substring(4,10))-1;



var v=Math.round(0.13*Math.exp((
eval(getElementByName('Age['+id+']').value)-23)*(
eval(getElementByName('Age['+id+']').value)-23)/-200)*
eval(getElementByName('Trainer['+id+']').value)*
val*
eval(getElementByName('Talent['+id+']').value));


	document.getElementById('train'+slider.id).value=Math.round(0.8*v)+'-'+Math.round(1.2*v);

	updatestamina(val,slider);
}

function updatestamina(val,slider)
{
	var id=eval(slider.id.substring(4,10))-1;

	document.getElementById('stamina'+slider.id).value=Math.round(eval(10+0.3*(100-val)))+'%';

	if(getElementByName('Injury['+id+']').value>0) document.getElementById('stamina'+slider.id).value='';
}
