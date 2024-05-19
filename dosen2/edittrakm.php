<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo $data[semester]."<h1>Woooi</h1>";
if ( $data[semester] == 1 || $data[semester] == 2 )
{
    $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $idprodi = $d[IDPRODI];
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    echo $q = "INSERT INTO trakm \r\n          (THSMSTRAKM ,KDPTITRAKM ,KDPSTTRAKM ,KDJENTRAKM ,NIMHSTRAKM  )\r\n          VALUES\r\n          ('".( $data[tahun] - 1 )."{$data['semester']}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idmahasiswa}')";
    mysqli_query($koneksi,$q);
    if ( sqlaffectedrows( $koneksi ) <= 0 )
    {
        $q = "UPDATE trakm SET \r\n            KDPTITRAKM='{$kodept}' ,KDPSTTRAKM='{$kodeps}'  ,KDJENTRAKM='{$kodejenjang}' \r\n            WHERE \r\n            NIMHSTRAKM='{$idmahasiswa}' \r\n            AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'";
        mysqli_query($koneksi,$q);
    }
}
?>
