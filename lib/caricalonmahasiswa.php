<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
if ( isset( $_POST['queryString'] ) )
{
    $queryString = $_POST['queryString'];
    if ( 2 < strlen( $queryString ) )
    {
        $qfield = "";
        if ( $tahun != "" )
        {
            $qfield .= " AND calonmahasiswa.TAHUN='{$tahun}'";
        }
        if ( $gelombang != "" )
        {
            $qfield .= " AND calonmahasiswa.GELOMBANG='{$gelombang}'";
        }
        if ( $idpilihan != "" )
        {
            $qfield .= " AND calonmahasiswa.PILIHAN='{$idpilihan}'";
        }
        $q = "SELECT calonmahasiswa.ID,calonmahasiswa.NAMA, calonmahasiswa.LULUS AS IDPRODI   \r\n     FROM calonmahasiswa  \r\n     WHERE (calonmahasiswa.NAMA LIKE '%{$queryString}%' OR calonmahasiswa.ID LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY calonmahasiswa.ID,  calonmahasiswa.NAMA LIMIT 0,20";
        $h = mysqli_query($koneksi,$q);
        if (0 < sqlnumrows( $h ) )
        {
            while( $d = sqlfetcharray( $h ) )
            {
                echo "<li onClick=\"fillCalonMhs('".$d[ID]."');\"><b>{$d['ID']}</b> - ".$d[NAMA].",  ".$arrayprodidep[$d[IDPRODI]]."</li>";
            }
        }
    }
}
?>
