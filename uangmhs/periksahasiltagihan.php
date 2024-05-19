<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$strtmp = "";
$jenisfile = "HTML";
$strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>No</td>\r\n                  <td><b>NIM</td>\r\n                  <td><b>Nama</td>\r\n                  <td><b>Angkatan</td>\r\n                  <td><b>Program Studi</td>\r\n                  <td><b>Jumlah Tagihan</td> \r\n          \r\n                  ";
foreach ( $arraydatakomponen as $idkomponen => $d )
{
    $strtmp .= "\r\n                <td><b>".$arraykomponenpembayaran[$idkomponen]."</td>\r\n               ";
}
$strtmp .= "</tr>";
$i = 0;
foreach ( $arraydatamahasiswa as $idmahasiswa => $d )
{
    ++$i;
    $strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$i}</td>\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap align=center>{$d['ANGKATAN']}</td>\r\n                  <td nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n                  <td nowrap align=right>".intval( $arrayjumlahtagihan[$idmahasiswa] )."</td>\r\n                ";
    foreach ( $arraydatakomponen as $idkomponen => $d2 )
    {
        $strtmp .= "\r\n                  <td  nowrap align=right>".intval( $arraydatatagihan[$idmahasiswa][$idkomponen][JUMLAH] )."</td>";
    }
    $strtmp .= "</tr>";
}
$strtmp .= "</table>";
echo $strtmp;
?>
