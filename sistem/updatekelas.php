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
header( "Content-Disposition: filename=updatekelas.sql" );
$root = "../";
include( $root."header.php" );
$q = "SELECT * FROM trakd  ORDER BY THSMSTRAKD,KDPSTTRAKD,KDJENTRAKD,KDKMKTRAKD,KELASTRAKD ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $jmldata = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "UPDATE trnlm SET KELASTRNLM='{$d['KELASTRAKD']}' \r\n     WHERE \r\n     THSMSTRNLM='{$d['THSMSTRAKD']}' AND \r\n      KDPSTTRNLM='{$d['KDPSTTRAKD']}' AND\r\n      KDJENTRNLM='{$d['KDJENTRAKD']}' AND\r\n     KDKMKTRNLM='{$d['KDKMKTRAKD']}'  ;\r\n     \r\n     ";
        $str .= $q;
    }
}
echo $str;
?>
