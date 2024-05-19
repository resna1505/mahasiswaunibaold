<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."header.php" );
$q = "SELECT * FROM pengambilanmk WHERE KELAS!='01'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $jmldata = 0;
    do
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            $q = "UPDATE trnlm SET KELASTRNLM='{$d['KELAS']}' \r\n     WHERE \r\n     THSMSTRNLM='".( $d[TAHUN] - 1 )."{$d['SEMESTER']}' AND \r\n      NIMHSTRNLM='{$d['IDMAHASISWA']}' AND\r\n     KDKMKTRNLM='{$d['IDMAKUL']}'  \r\n     \r\n     ";
            mysqli_query($koneksi,$q);
        }
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$jmldata;
        }
    } while ( 1 );
}
echo "{$i} data kelas trnlm telah diupdate";
?>
