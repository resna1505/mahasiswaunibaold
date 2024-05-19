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
$q = "SELECT ID FROM user WHERE ID='{$idsp}' AND \r\n \r\n(\r\n            (PASSWORD=PASSWORD('{$passwordsp}') AND FLAGPASSWORD=0 ) \r\n            OR\r\n            (PASSWORD=MD5('{$passwordsp}') AND FLAGPASSWORD=1 ) \r\n          )   \r\n AND TINGKAT LIKE '%F5:B%' AND JENIS='1' AND ID!='{$users}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    session_register_sikad( "statusnilai" );
    session_register_sikad( "statusnilaisupervisor" );
    $_SESSION[statusnilai] = 1;
    $_SESSION[statusnilaisupervisor] = 1;
    Header( "Location:index.php?pilihan={$pilihan}&aksi=formtambah&idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&kelasupdate={$kelasupdate}&semesterupdate={$semesterupdate}&id={$id}&idprodiupdate={$idprodiupdate}" );
}
else
{
    Header( "Location:index.php?pilihan={$pilihan}&aksi=formtambah&idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&kelasupdate={$kelasupdate}&semesterupdate={$semesterupdate}&errmesg=ID dan Password Salah&id={$id}&idprodiupdate={$idprodiupdate}" );
}
?>
