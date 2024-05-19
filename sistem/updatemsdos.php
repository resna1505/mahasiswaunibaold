<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

header( "Cache-control: private" );
header( "Content-Type: application/octet-stream" );
header( "Content-Disposition: filename=updatemsdosmspds.sql" );
$root = "../";
include( $root."header.php" );
periksaroot( );
$jml = 0;
$str = "";
$q = "SELECT  NODOSMSDOS AS ID FROM msdos \r\n    WHERE KDJENMSDOS = '' OR KDPSTMSDOS =''\r\n   ORDER BY NODOSMSDOS ";
$h = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $d2[KDPSTTBDOS] = "9000";
    $d2[KDJENTBDOS] = "C";
    $str .= "UPDATE msdos SET KDPSTMSDOS ='{$d2['KDPSTTBDOS']}', KDJENMSDOS='{$d2['KDJENTBDOS']}' WHERE  NODOSMSDOS='{$d['ID']}'  ;\n";
    ++$jml;
}
echo $str;
$q = "SELECT KDPTIMSPTI FROM mspti";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$kdpti = $d[KDPTIMSPTI];
$str = "";
$q = "SELECT  NODOSMSPDS AS ID FROM mspds \r\n    WHERE KDJENMSPDS = '' OR KDPSTMSPDS ='' OR KDPTIMSPDS=''\r\n   ORDER BY NODOSMSPDS ";
$h = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $d2[KDPSTTBDOS] = "9000";
    $d2[KDJENTBDOS] = "C";
    $str .= "UPDATE mspds SET KDPSTMSPDS ='{$d2['KDPSTTBDOS']}', KDJENMSPDS='{$d2['KDJENTBDOS']}',KDPTIMSPDS='{$kdpti}' WHERE  NODOSMSPDS='{$d['ID']}'  ;\n";
    ++$jml;
}
echo $str;
?>
