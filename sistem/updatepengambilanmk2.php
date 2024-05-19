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
header( "Content-Disposition: filename=updatepengambilanmksemestermakul.sql" );
$root = "../";
include( $root."header.php" );
$jml = 0;
$q = "SELECT  DISTINCT IDMAKUL,TAHUN,SEMESTER FROM pengambilanmk \r\n   ORDER BY IDMAKUL,TAHUN,SEMESTER ";
$h = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $q = "SELECT SEMESTBKMK FROM tbkmk WHERE THSMSTBKMK='".( $d[TAHUN] - 1 )."{$d['SEMESTER']}' AND KDKMKTBKMK='{$d['IDMAKUL']}'";
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        if ( trim( $d2[SEMESTBKMK] ) != "" )
        {
            $semestermakul = $d2[SEMESTBKMK];
            $str .= "UPDATE pengambilanmk SET SEMESTERMAKUL='{$semestermakul}' WHERE  IDMAKUL='{$d['IDMAKUL']}' AND TAHUN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' ;\r\n ";
            ++$jml;
        }
    }
}
echo $str;
?>
