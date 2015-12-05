<?
print "$step--";
foreach($_POST as $k=>$v)
{
	print "$k=>$v<br>";
}

foreach($_GET as $k=>$v)
{
	print "$k=>$v<br>";
}


foreach($_FILES as $k=>$v)
{
	print "$k=>$v<br>";
}
?>

<form name="my" method="post"  action="test.php">
<input type="hidden" name="step" value="1"/>

<tr bgcolor=#687174  class="header"><td colspan=2>
<input type="submit" value="Отказаться"> </td></tr>
</table>
</form>