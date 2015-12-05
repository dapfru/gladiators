<?
require_once("xajax.inc.php");

function myFunction()
{

	$objResponse = new xajaxResponse();

//$objResponse->setCharEncoding("windows-1251");

	$objResponse->addAssign("SomeElementId","innerHTML",'тест');

	return $objResponse;
}

$xajax = new xajax();
$xajax->registerFunction("myFunction");
$xajax->processRequests();
?>
<head>
<?php $xajax->printJavascript(); ?>
</head>

<body>

<div id="SomeElementId"></div>
<input type="button" value="ok" onclick="xajax_myFunction();">
