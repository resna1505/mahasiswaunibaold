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
/*$strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>No</td>\r\n                  <td><b>NIM</td>\r\n                  <td><b>Nama</td>\r\n                  <td><b>Angkatan</td>\r\n                  <td><b>Program Studi</td>\r\n                  <td><b>Jumlah Tagihan</td> \r\n          \r\n                  ";
echo "DATA D=";
echo '<br>';
print_r($d);

echo "DATA KOMPONEN";
echo '<br>';
print_r($arraydatakomponen);
echo '<br>';
echo "DATA MAHASISWA";
echo '<br>';
print_r($arraydatamahasiswa);
echo '<br>';
echo "DATA TAGIHAN";
echo '<br>';
print_r($arraydatatagihan);
echo '<br>';*/
/*foreach ( $arraydatakomponen as $idkomponen => $d )
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
$strtmp .= "</table>";*/
   $strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>TRX_ID</td>\r\n                  <td><b>VIRTUAL_ACCOUNT</td>\r\n                  <td><b>CUSTOMER_NAME</td>\r\n                  <td><b>CUSTOMER_EMAIL</td>\r\n                  <td><b>CUSTOMER_PHONE</td>\r\n                  <td><b>TRX_AMOUNT</td>\r\n                  <td><b>EXPIRED_DATE</td>\r\n                  <td><b>EXPIRED_TIME</td>\r\n                  <td><b>DESCRIPTION</b></td>";

foreach ($arraydatatagihan as $tagihan => $d ){
	$strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['TRXID']}</td>\r\n                  <td nowrap>{$d['VANUMB']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap></td>\r\n                  <td nowrap></td><td nowrap align=right>".intval( $arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']] )."</td> <td nowrap>{$d['EXPDATE']}</td><td nowrap>{$d['EXPTIME']}</td>";
    
}
$strtmp .= "</table>";
echo $strtmp;
?>
