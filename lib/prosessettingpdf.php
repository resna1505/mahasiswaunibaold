<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
if ( $ukuran != "" )
{
    $q = "UPDATE settingpdf \r\nSET \r\n  UKURAN='{$ukuran}',\r\n  ORIENTASI='{$orientasi}',\r\n  MARGINKIRI='{$marginkiri}',\r\n  MARGINKANAN='{$marginkanan}',\r\n  MARGINATAS='{$marginatas}',\r\n  MARGINBAWAH='{$marginbawah}'\r\nWHERE ID=0";
    mysqli_query($koneksi,$q);
}
?>
