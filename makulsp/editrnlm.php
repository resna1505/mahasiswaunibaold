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
    $q = "INSERT INTO trnlmsp \r\n          (THSMSTRNLM ,KDPTITRNLM ,KDPSTTRNLM ,KDJENTRNLM ,NIMHSTRNLM ,KDKMKTRNLM )\r\n          VALUES\r\n          ('".( $tahunlama - 1 )."{$sem}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idmahasiswa}','{$idmakul}')";
    mysqli_query($koneksi,$q);
    if ( sqlaffectedrows( $koneksi ) <= 0 )
    {
        $q = "UPDATE trnlmsp SET \r\n            KDPTITRNLM='{$kodept}' ,KDPSTTRNLM='{$kodeps}'  ,KDJENTRNLM='{$kodejenjang}' ,\r\n            KDKMKTRNLM='{$idmakul}'\r\n            WHERE \r\n            NIMHSTRNLM='{$idmahasiswa}' \r\n            AND THSMSTRNLM='".( $tahunlama - 1 )."{$sem}'";
        mysqli_query($koneksi,$q);
    }
}
?>
