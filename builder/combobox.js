function createComboboxHtml(options)
{
  var html="<SELECT>";
  for (i=0; i<options.length; i++)
    html+="<OPTION> "+options[i];
  html+="</SELECT>";  
  return html;
}