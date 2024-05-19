<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
echo "\r\n\t<link rel=\"stylesheet\" href=\"".$root."css/indexc.css\" type=\"text/css\" />";
if ( $_SESSION[TAMPILAN][MENUUTAMA] == 0 || $_SESSION[TAMPILAN][MENUUTAMA] == "" )
{
    echo "\r\n\t   <link rel=\"stylesheet\" href=\"".$root."css/hmenu.css\" type=\"text/css\" />";
}
else
{
    echo "\r\n\t   <link rel=\"stylesheet\" href=\"".$root."css/vmenu.css\" type=\"text/css\" />";
}
echo "\r\n\t<!--[if lte IE 6]>\r\n\t<link href=\"".$root."css/iehackc.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n\t<![endif]--> \r\n\t<!--[if lte IE 7]>\r\n\t<link href=\"".$root."css/iehackc.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n\t<![endif]--> \r\n\t</head>\r\n\t";
?>
