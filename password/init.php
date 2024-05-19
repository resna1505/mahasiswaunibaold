<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
include( $root."css/arraytampilan.php" );
if ( $jenisusers == 0 )
{
    $tabeluser = "user";
}
else if ( $jenisusers == 1 )
{
    $tabeluser = "dosen";
}
else
{
    $tabeluser = "mahasiswa";
}
if ( $aksi == "tganti" && $REQUEST_METHOD == POST )
{
    $ok = true;
    if ( $jenisusers == 0 )
    {
        $tabeluser = "user";
    }
    else if ( $jenisusers == 1 )
    {
        $tabeluser = "dosen";
    }
    else
    {
        $tabeluser = "mahasiswa";
    }
    $query = "UPDATE {$tabeluser} SET CSS='{$tampilan}' \r\n\t\tWHERE ID='{$users}' ";
   mysqli_query($koneksi,$query);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Tampilan SITU Anda telah diganti dengan yang baru. Untuk mengaktifkan, \r\n\t\t\tsilakan kklik sembarang menu. Terima kasih\r\n\t\t\t";
        $css = $tampilan;
        header( "Location: index.php?pilihan=tupdate" );
    }
    else
    {
        $errmesg = "Tampilan SITU Anda tidak diganti dengan yang baru";
    }
}
echo " \r\n";
?>
