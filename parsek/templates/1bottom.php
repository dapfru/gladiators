</td>
          </tr>


  <?

	//if($first_page==1)
	//{

?>   
          <tr>
            <td width="44"> </td>
            <td align="right" valign="top"><img src="images/mid/shad1.jpg" alt="" width="205" height="9"></td>
          </tr>
<?
	//}

?>

        </table>

<?

	if($first_page==1)
	{

?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="44" valign="top"> </td>
              <td valign="top"><h4>Наши новинки</h4></td>
            </tr>
            <tr>
              <td width="44" valign="top"> </td>
              <td valign="top" bgcolor="#f7f8f6"><table width="100%" border="0" cellspacing="10" cellpadding="0">

<?


  $res=runsql("select MaterialID,Date,Headline_$lang as Headline, Name_$lang as Title, Message_$lang as Message, Small from ut_materials where TypeID=8 order by Date desc limit 0,3");

  while($r=mysql_fetch_array($res))
	{
	
	print"
                <tr>
                  <td width='130' align='center' valign='top'><img src='$img_url?id=$r[MaterialID]&record=2' alt='' width='124'></td>
                  <td valign='top'><h5>".$r[Title]."</h5>
                    <br/>".$r[Headline]."
                    <p align='right'><a href='$site_url"."news.php?id=$r[MaterialID]' class='lnk'>подробнее</a></td>
                </tr>
	     ";
	}


?>
              </table></td>
            </tr>
            <tr>
              <td width="44" valign="top"> </td>
              <td valign="top"><img src="images/mid/shad2.jpg" alt="" width="248" height="27"></td>

            </tr>

          </table>
<?
}
?></td>
      </tr>
    </table></td>

  </tr>


  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="304"><img src="images/bott/l1.gif" alt="" width="304" height="15"></td>
        <td><img src="images/bott/r.gif" alt="" width="678" height="15"></td>
      </tr>
      <tr>
<?
  $r=select("select rus from lk_texts where TextID=1");
?>
        <td height="101" valign="top" class="copy"><?=settags($r[rus])?></td>
        <td height="101" valign="top" class="bott"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="204" valign="top"><img src="images/bott/marker1.gif" alt="" width="204" height="35"></td>
            <td width="238" valign="top"><img src="images/bott/marker2.gif" alt="" width="238" height="35"></td>
            <td valign="top"><img src="images/bott/marker3.gif" alt="" width="236" height="35"></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
<?
  $r=select("select rus from lk_texts where TextID=2");
?>
                <td width="28"> </td>
                <td><?=settags($r[rus])?></td>

              </tr>
            </table></td>
<?
  $r=select("select rus from lk_texts where TextID=3");
?>
            <td valign="top"><?=settags($r[rus])?></td>
<?
  $r=select("select rus from lk_texts where TextID=4");
?>
            <td valign="top"><?=settags($r[rus])?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
