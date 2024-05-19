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
$q = "SELECT ID FROM user WHERE ID='{$idsp}' AND PASSWORD=PASSWORD('{$passwordsp}') AND TINGKAT LIKE '%F5:B%'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    session_register_sikad( "statusnilai" );
    $statusnilai = 1;
    Header( "Location:index.php?pilihan={$pilihan}&aksi=formtambah&idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&kelasupdate={$kelasupdate}&semesterupdate={$semesterupdate}" );
}
else
{
    Header( "Location:index.php?pilihan={$pilihan}&aksi=formtambah&idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&kelasupdate={$kelasupdate}&semesterupdate={$semesterupdate}&errmesg=ID dan Password Salah" );
}
?>
