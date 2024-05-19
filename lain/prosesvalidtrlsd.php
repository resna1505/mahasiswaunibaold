<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Transaksi Keluar/Cuti/Studi Dosen (TRLSD)" );
$q = "SELECT COUNT(NODOSTRLSD) AS JML FROM trlsd\r\n   ";
$qf = "";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$i = 0;
while ( $i < 20 )
{
    $valid[$i] = 0;
    ++$i;
}
$tmpdata = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = $jmlrecw = "";
    $d = sqlfetcharray( $h );
    $q = "SELECT NODOSTRLSD,NMDOSMSDOS  FROM trlsd   LEFT JOIN msdos\r\n      ON  NODOSTRLSD=NODOSMSDOS\r\n        WHERE \r\n        (NODOSMSDOS ='' )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b> No. Dosen tidak ada di MSDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRLSD']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Jumlah Record Dobel</td>\r\n      <td  align=center  >0</td>\r\n      <td  {$valid2['0']}>No. Dosen tidak ada di MSDOS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['1']}>Keluar Masih Ada di TRAKD</td>\r\n      <td  align=center {$valid2['1']}>{$valid['1']} </td>\r\n      <td   >Kode Status Aktifitas # TBKOD </td>\r\n      <td  align=center   >0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Status Aktifitas Tidak Boleh 'A'</td>\r\n      <td  align=center {$valid2['2']}>{$valid['2']} </td>\r\n      <td   > </td>\r\n      <td  align=center > </td>\r\n    </tr>\r\n   \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
