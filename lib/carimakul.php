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
            $qfield .= " AND makul.IDPRODI='{$prodi}' ";
        }
        if ( $_SESSION['prodis'] != "" )
        {
            $qfield .= "AND makul.IDPRODI='".$_SESSION['prodis']."'";
        }
        $q = "SELECT makul.ID\t ,makul.NAMA,  makul.IDPRODI\r\n     FROM makul\r\n     WHERE \r\n      \r\n     (makul.NAMA LIKE '%{$queryString}%' OR makul.ID LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY makul.ID   \r\n     LIMIT 0,20";
        $h = mysqli_query($koneksi,$q);
        #echo mysql_error( );
        if (0 < sqlnumrows( $h ) )
        {
            while ($d=sqlfetcharray($h))
            {
                echo "<li onClick=\"fillMakul('".$d[ID]."');\"><b>{$d['ID']}</b> - ".$d[NAMA].",  ".$arrayprodidep[$d[IDPRODI]]."</li>";
            }
        }
    }
}
?>
