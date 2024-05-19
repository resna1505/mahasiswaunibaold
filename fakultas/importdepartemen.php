<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$ok = 0;
$q = "SELECT DISTINCT KDFAKMSPST,KDPSTMSPST,NMPSTMSPST FROM mspst ";
$h = doquery($koneksi, $q );
$jmldata = sqlnumrows( $h );
while ( !( 0 < $jmldata ) || !( $d = sqlfetcharray( $h ) ) )
{
    $q = "INSERT INTO departemen (IDFAKULTAS,ID,NAMA) \r\n    VALUES ('{$d['KDFAKMSPST']}','{$d['KDPSTMSPST']}','{$d['NMPSTMSPST']}')";
    doquery($koneksi, $q );
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        ++$ok;
    }
}
echo "\r\n<b>Import Data Departemen</b> <br>\r\nJumlah Data : <b>{$jmldata}</b> <br>\r\nData berhasil diimpor : <b>{$ok}</b> <br><br>\r\n";
?>
