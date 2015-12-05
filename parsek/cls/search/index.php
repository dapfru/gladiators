<?
 ############################################################################
 # WFSearch Engine Pro by jID     Version 1.0 (PHP4)                        #
 # Copyright (C) jID, 2003                                                  #
 #                                                                          #
 # search form :: форма для поиска                                          #
 ############################################################################

  require("connect.php");
  require("lang.php");
  require("include/header.php");
  require("include/footer.php");

  session_start();
  place_header($lang_srchtitle);
?>
  <form method=post action=wfsearchpro.php>
  <input name=query length=40><input type=submit value='<?echo $lang_search;?>'><br>
  <input type=radio checked name=m value=or><?echo $lang_usingor;?><br>
  <input type=radio name=m value=and><?echo $lang_usingand;?>
  </input>
  </form>
<?
  place_footer();
?>