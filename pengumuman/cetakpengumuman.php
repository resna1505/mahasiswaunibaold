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
echo "<html>\r\n<head>\r\n\t<title>Pengumuman\r\n\t</title>\r\n</head>\r\n<body>\r\n<table style='color:#000000;'  width=700 height=100% border=1 cellpadding=3 cellspacing=0\r\n bordercolor=#000000  style='color:#ffffff;font-size:11pt;border-collapse: collapse;'>\r\n<tr valign=top >\r\n<td  align=justify>\r\n<h2 align=center>Pengumuman</h3>\r\n";
if ( $aksi == "cetaksatu" )
{
    $where = " WHERE ID ='{$idpengumuman}' ";
}
else if ( $aksi == "Cetak 10 terbaru" )
{
    $limit = "LIMIT 0,10";
}
else
{
    $limit = "";
}
$query = "SELECT DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL, RINCIAN,JUDUL, LOKASI FROM\r\n\tpengumuman {$where} ORDER BY TANGGAL DESC {$limit}";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    if ( 1 < sqlnumrows( $hasil ) )
    {
        echo "<ol>";
        while ( $data = sqlfetcharray( $hasil ) )
        {
            echo "<li align=justify>{$data['RINCIAN']}... <font style='font-size:8pt;'>(".$arraylokasi[$data[LOKASI]].", {$data['TGL']})</font>";
        }
        echo "</ol>";
    }
    else
    {
        while ( $data = sqlfetcharray( $hasil ) )
        {
            echo "<center><h3 style='font-family:Arial'>{$data['JUDUL']}</h3>";
            echo "<center>{$data['RINCIAN']}... <font style='font-size:8pt;'>({$data['TGL']})</font>";
        }
    }
}
echo "<center>Tidak ada pengumuman...</center>";
@mysql_close( );
echo "</td>\r\n</tr>\r\n</table>\r\n\r\n\r\n\r\n\r\n\r\n</body>\r\n</html>\r\n";
?>
