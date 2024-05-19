<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $sem == 1 || $sem == 2 )
{
    $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $hx = mysqli_query($koneksi,$q);
    $dx = sqlfetcharray( $hx );
    $idprodi = $dx[IDPRODI];
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $hx = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = sqlfetcharray( $hx );
        $kodept = $dx[KDPTIMSPST];
        $kodejenjang = $dx[KDJENMSPST];
        $kodeps = $dx[KDPSTMSPST];
    }
    $q = "INSERT INTO trakm \r\n          (THSMSTRAKM ,KDPTITRAKM ,KDPSTTRAKM ,KDJENTRAKM ,NIMHSTRAKM  )\r\n          VALUES\r\n          ('".( $tahunlama - 1 )."{$sem}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idmahasiswa}')";
    mysqli_query($koneksi,$q);
    if ( sqlaffectedrows( $koneksi ) <= 0 )
    {
        $q = "UPDATE trakm SET \r\n            KDPTITRAKM='{$kodept}' ,KDPSTTRAKM='{$kodeps}'  ,KDJENTRAKM='{$kodejenjang}' \r\n            WHERE \r\n            NIMHSTRAKM='{$idmahasiswa}' \r\n            AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'";
        mysqli_query($koneksi,$q);
    }
}
?>
