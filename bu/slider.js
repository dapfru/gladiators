var sliders = new Array();
var targetSlider = null;
var posX = 0;
var sliderValue = 0;


function createSliderHtml(name,id)
{
html="<input name=\""+name+"\" ";
html+="onkeypress=\"javascript: return checknumeric(event)\" ";
html+="onblur='FocusOUT(this);' onfocus='FocusIN(this);' ";
html+="type=\"text\" maxlength=\"\" value=\"100\" ";
html+="size=2  class='slider' id='"+id+"' />";
//html+="size=2  name='myInput' class='slider' id='"+id+"' />";
return html;
}

function createSlider(name,id)
{
document.write(createSliderHtml(name,id));
}

function processSliders()
{
    var bgImage = new Image(100,18);
    bgImage.src = "back.gif";
    var btImage = new Image(10,18);
    btImage.src = "slider.gif";
    var inputs = document.getElementsByTagName("input");
	    
for(var i=0; i<inputs.length; i++)
{
    if(inputs[i].className == "slider")
    {
	MakeSlider(inputs[i],bgImage,btImage,0,100,"%(0:100)");
					
							
		}
								
						}
}

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
	this.SetValue(this.MinValue + parseInt(value*this.Koef));
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
	this.SliderHint.innerHTML = this.value+" "+this.GetVar();
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
			left = X+10+"px";
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
				left = X+10+"px";
				top = Y+10+"px";
			}
		}
		
	}
}

function MakeSlider(inputElement, imgBackground, imgButton, minValue, maxValue, vars)
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
		backgroundColor = "#CBFF9B";
		border = "1px solid black";
		position = "absolute";
		display = "none";
		padding = "2px";
	}
	with(sliderBackgroundDiv.style)
	{
		width = imgBackground.width+"px";
		backgroundColor = "#2222ff";
		height = imgBackground.height+"px";
		backgroundImage = "url("+imgBackground.src+")";
		position = "relative";
	}
	with(sliderButtonDiv.style)
	{
		backgroundColor = "#ccccff";
		width = imgButton.width+"px";
		height = imgButton.height+"px";
		top = ((parseInt(sliderBackgroundDiv.style.height)/2)-(parseInt(height)/2))+"px";
		backgroundImage = "url("+imgButton.src+")";
		cursor = "pointer";
		position = "absolute";
	}
	inputElement.parentNode.appendChild(sliderBackgroundDiv);
	sliderBackgroundDiv.appendChild(sliderButtonDiv);
	container.appendChild(sliderHint);
	slider.StartListen();
	slider.SetValue(inputElement.value);
	

	
	inputElement.style.display = "none";
}
