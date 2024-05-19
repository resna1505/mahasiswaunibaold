<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Ganti" )
{
    if ( $jenisusers == 0 )
    {
        $q = "UPDATE user SET CSS='{$tampilanuser}' WHERE ID='{$users}' ";
    }
    else if ( $jenisusers == 1 )
    {
        $q = "UPDATE dosen SET CSS='{$tampilanuser}' WHERE ID='{$users}' ";
    }
    else if ( $jenisusers == 2 )
    {
        $q = "UPDATE mahasiswa SET CSS='{$tampilanuser}' WHERE ID='{$users}' ";
    }
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Tampilan telah diganti.";
    }
    else
    {
        $errmesg = "Tampilan tidak diganti.";
    }
}
printjudulmenu( "Ganti Tampilan" );
printmesg( $errmesg );
if ( $jenisusers == 0 )
{
    $q = "SELECT CSS FROM user WHERE ID='{$users}'";
}
else if ( $jenisusers == 1 )
{
    $q = "SELECT CSS FROM dosen WHERE ID='{$users}'";
}
else if ( $jenisusers == 2 )
{
    $q = "SELECT CSS FROM mahasiswa WHERE ID='{$users}'";
}
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$cssasli = $d['CSS'];
echo "<form action=index.php method=post>\r\n<input type=hidden name=aksi value=\"tganti\">\r\n<input type=hidden name=pilihan value=\"tupdate\"> \r\n";
echo IKONMONITOR48;
echo "<table  >\r\n\t<tr valign=top>\r\n\t\t<td  ><b>Pilih Jenis Tampilan </td>\r\n \r\n\t\t</tr>\r\n\t<tr>\r\n\t<td  align=left>\r\n\t\t<table border=0 width=90%>\r\n\t\r\n\t\t";
foreach ( $arraycss as $k => $v )
{
    if ( $k == $cssasli )
    {
        $cek2 = "checked";
    }
    else
    {
        $cek2 = "";
    }
    echo "<tr valign=top> ";
    echo "<td  >";
    echo "\r\n          <!-- <img {$cek} src='../css/{$tmp}/contoh.jpg' width=150> <br> -->\r\n\t\t\t\t\t<input type=radio name=tampilanuser {$cek2} value='{$k}'>{$v}\r\n\t\t\t\t\t \r\n\t\t\t\t\t";
    echo "</td></tr>";
}
echo "\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr valign=top>\r\n\t\t<td   >\r\n\t\t<br>\r\n\t\t\t<input class=tombol type=submit name=aksi value='Ganti'>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n\r\n";
?>
