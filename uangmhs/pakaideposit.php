<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $STEIINDONESIA != 1 )
{
    exit( );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilpakaideposit.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Pemakaian Deposit Mahasiswa " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pemakaian</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input type=checkbox name=iftglbayar value=1>\r\n            ".createinputtanggal( "tglbayar1", $tglbayar1, " class=masukan" )." s.d\r\n            ".createinputtanggal( "tglbayar2", $tglbayar2, " class=masukan" )."\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n<!--\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Entri</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input type=checkbox name=iftglentri value=1>\r\n            ".createinputtanggal( "tglentri1", $tglentri1, " class=masukan" )." s.d\r\n            ".createinputtanggal( "tglentri2", $tglentri2, " class=masukan" )."\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n-->\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
