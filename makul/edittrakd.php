<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $sem == 1 || $sem == 2 )
{
    $idprodi = $idprodiampu;
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $hx = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = sqlfetcharray( $hx );
        $kodept = $dx[KDPTIMSPST];
        $kodejenjang = $dx[KDJENMSPST];
        $kodeps = $dx[KDPSTMSPST];
    }
    $q = "\r\n            INSERT INTO trakd \r\n            (THSMSTRAKD ,KDPTITRAKD ,KDPSTTRAKD ,KDJENTRAKD ,NODOSTRAKD ,\r\n            KDKMKTRAKD ,KELASTRAKD,TMRENTRAKD,TMRELTRAKD)\r\n            VALUES\r\n            ('".( $tahunlama - 1 )."{$sem}','{$kodept}','{$kodeps}','{$kodejenjang}','{$iddosen}',\r\n            '{$idmakul}','{$kelas}','{$jumlahtatap}','{$jumlahtatap2}')\r\n            ";
    mysqli_query($koneksi,$q);
}
?>
