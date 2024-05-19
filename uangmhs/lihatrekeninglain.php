<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslihatrekeninglain.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Cari Data Pembayaran Keuangan Rekening Lain Mahasiswa" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t".IKONCARI48."\r\n \t\t<table  >";
    if ( $jenisusers == 0 )
    {
        echo "\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\"" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
        
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        echo "\r\n      \t\t<tr >\r\n    \t\t\t<td class=judulform>NIM</td>\r\n    \t\t\t<td><b>{$users}\r\n    \t\t\t</td>\r\n    \t\t</tr>";
    }
    echo "\r\n\t\t<tr >\r\n\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=checkbox name=istglbayar value=1>\r\n\t\t\t".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."\r\n\t\t\ts.d \r\n\t\t\t".createinputtanggal( "tglbayar2", $tglbayar2, " class=masukan" )."\r\n\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\t\r\n\t\t<tr >\r\n\t\t\t<td>Tanggal Entri Data</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=checkbox name=istglentri value=1>\r\n\t\t\t".createinputtanggal( "tglentri", $tglentri, " class=masukan" )."\r\n\t\t\ts.d \r\n\t\t\t".createinputtanggal( "tglentri2", $tglentri2, " class=masukan" )."\r\n\t\t\t</td>\r\n\t\t\t</tr>";
    
    echo "<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
