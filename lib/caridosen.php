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
        if ( $prodi != "" )
        {
            $qfield .= " AND dosen.IDDEPARTEMEN='{$prodi}'";
        }
        if ( $_SESSION['prodis'] != "" )
        {
            $qfield .= " AND dosen.IDDEPARTEMEN='".$_SESSION['prodis']."'";
        }
        $q = "SELECT dosen.ID,dosen.NAMA, dosen.IDDEPARTEMEN AS IDPRODI   \r\n     FROM dosen\r\n     WHERE (dosen.NAMA LIKE '%{$queryString}%' OR dosen.ID LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY dosen.ID, dosen.IDDEPARTEMEN,dosen.NAMA LIMIT 0,20";
        $h = mysqli_query($koneksi,$q);
        #echo mysql_error( );
        if (0 < sqlnumrows( $h ) )
        {
            while( $d = sqlfetcharray( $h ) )
            {
                echo "<li onClick=\"fillDosen('".$d[ID]."');\"><b>{$d['ID']}</b> - ".$d[NAMA]." - ".$arrayprodidep[$d[IDPRODI]]."</li>";
            }
        }
    }
}
?>
