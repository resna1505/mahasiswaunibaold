<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    $q = "UPDATE setingijazah SET\r\n \r\n  REKTOR='{$rektor}'\r\n \r\n  ";
    mysqli_query($koneksi,$q);
}
printjudulmenu( "Setting Cetak Ijazah" );
$q = "SELECT * FROM setingijazah ";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO setingijazah (ID) VALUES (0)";
    mysqli_query($koneksi,$q);
    $q = "SELECT * FROM setingijazah ";
    $h = mysqli_query($koneksi,$q);
}
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    echo "\r\n  <form action=index.php method=post>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table class=form>\r\n \r\n    <tr>\r\n      <td>Nama Rektor</td>\r\n      <td><input name=rektor value='{$d['REKTOR']}' size=30></td>\r\n    </tr>\r\n \r\n    <tr>\r\n      <td></td>\r\n      <td>\r\n      <input type=submit name=aksi value='Simpan' >\r\n      <input type=reset  value='Reset' >\r\n      </td>\r\n    </tr>\r\n  </table>\r\n  </form>\r\n  ";
}
?>
