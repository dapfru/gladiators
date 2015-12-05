function Common()
{
}
Common.prototype.setOpacity = function(obj,opacity)
{
	obj.style.MozOpacity = opacity/100;
	obj.style.filter = "alpha(opacity="+opacity+")";
	obj.style.opacity = opacity/100;
}
Common.prototype.getPixels = function getPixels(x)
{
	res = x.substring(0,x.length-2)*1;
	return res;
}
var common = new Common();

