<?

$debug=0;

function getmicrotime() 
{ 
   list($usec, $sec) = explode(" ", microtime()); 
   return ((float)$usec + (float)$sec); 
} 

function ProfilerStart() 
{
	global $gl_file,$debug,$site_path,$engine_path,$site,$idt,$step;
  if($debug) 
    $gl_file=fopen($site_path."debug.txt","w");
}

function ProfilerStop() 
{
	global $gl_file,$debug,$site_path,$engine_path,$site,$idt,$step;
  if($debug) 
    if($debug) fclose($gl_file);
}

function tic($name)
{
	global $debug;
	if($debug)
	{
	global $gl_depth,$gl_time,$gl_count,$gl_names;
  $gl_depth++;
  $gl_time[$gl_depth]=getmicrotime();
  $gl_names[$gl_depth]=$name;
  $gl_count[$name]++;
  global $site_path,$gl_file;
	fputs($gl_file,">$name \r\n");
}
}

function tac()
{
	global $debug;
	if($debug)
	{
	global $gl_depth,$gl_time,$gl_count,$gl_names;
	$name=$gl_names[$gl_depth];
  log_write(getmicrotime()-$gl_time[$gl_depth],$gl_names[$gl_depth],$gl_count[$name],$gl_depth);  
  $gl_depth--;
  }
}

function log_write($time,$name,$count,$gl_depth)
{
	global $site_path,$gl_file;

	fputs($gl_file,"$gl_depth $name ".($time*1000)." ($count)\r\n");

}
?>