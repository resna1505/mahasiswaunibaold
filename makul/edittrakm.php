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
    $q = "INSERT INTO trakm (THSMSTRAKM ,KDPTITRAKM ,KDPSTTRAKM ,KDJENTRAKM ,NIMHSTRAKM  ) VALUES ('".( $tahunlama - 1 )."{$sem}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idmahasiswa}')";
    #echo "INSERT TRAKM=".$q.'<br>';
    mysqli_query($koneksi,$q);
    if ( sqlaffectedrows( $koneksi ) <= 0 )
    {
        $q = "UPDATE trakm SET KDPTITRAKM='{$kodept}' ,KDPSTTRAKM='{$kodeps}'  ,KDJENTRAKM='{$kodejenjang}' WHERE NIMHSTRAKM='{$idmahasiswa}' AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'";
        #echo "UPDATE TRAKM=".$q.'<br>';
	mysqli_query($koneksi,$q);
    }
}
?>
