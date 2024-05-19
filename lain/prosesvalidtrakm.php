<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Transaksi Aktifitas Mahasiswa (TRAKM)" );
$q = "SELECT COUNT(NIMHSTRAKM) AS JML FROM trakm \r\n   WHERE KDPSTTRAKM ='{$kodeps}'\r\n   AND KDJENTRAKM='{$kodejenjang}'\r\n   AND KDPTITRAKM='{$kodept}'\r\n   AND THSMSTRAKM='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTRAKM ='{$kodeps}'\r\n   AND KDJENTRAKM='{$kodejenjang}'\r\n   AND KDPTITRAKM='{$kodept}'\r\n   AND THSMSTRAKM='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
unset( $valid );
unset( $valid2 );
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
    $q = "SELECT NIMHSTRAKM,NIMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n        NIMHSMSMHS IS NULL  \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIM tidak ada di MSMHS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRAKM']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRAKM,NMMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n        NLIPKTRAKM = 0 AND NLIPSTRAKM!=0 \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai IPK=0 sedang IPS # 0</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRAKM,NMMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n          NLIPSTRAKM>4\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai IPS di luar range wajar</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRAKM,NMMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n          NLIPKTRAKM>4\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai IPK tidak wajar (>4)</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRAKM,NMMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n          SKSEMTRAKM>30\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Jumlah SKS Semester > 30 sks</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
}
$q = "SELECT NIMHSTRAKM,NMMHSMSMHS FROM trakm   LEFT JOIN msmhs\r\n      ON  NIMHSTRAKM=NIMHSMSMHS\r\n        WHERE \r\n          NLIPSTRAKM=0 AND SKSEMTRAKM=0 AND STMHSMSMHS ='A'\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[5] = 1;
    $valid2[5] = $warnatidakvalid;
    $tmpdata .= "<p><b>Jumlah SKS Diperoleh Blank</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSTRAKM,NMMHSMSMHS,COUNT(NIMHSTRNLM) AS JML \r\n       FROM trakm   \r\n       LEFT JOIN msmhs ON  NIMHSTRAKM=NIMHSMSMHS\r\n      LEFT JOIN trnlm ON \r\n        NIMHSTRNLM=NIMHSTRAKM AND THSMSTRNLM=THSMSTRAKM AND\r\n        KDJENTRAKM=KDJENTRNLM AND KDPSTTRAKM=KDPSTTRNLM AND KDPTITRAKM=KDPTITRNLM\r\n        WHERE\r\n        1=1\r\n         {$qf}\r\n        GROUP BY NIMHSTRAKM\r\n        HAVING JML <=0\r\n         ";
$h2 = mysqli_query($koneksi,$q);
echo mysql_error( );
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[6] = 1;
    $valid2[6] = $warnatidakvalid;
    $tmpdata .= "<p><b>NIM tidakada di TRNLM</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSTRAKM']}  - {$d2['NMMHSMSMHS']} <br>";
    }
    $tmpdata .= "</p>";
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center 0>0 </td>\r\n      <td  {$valid2['0']}>NIM tidak ada di MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >NIM Kosong</td>\r\n      <td  align=center >0 </td>\r\n      <td  {$valid2['1']} >Nilai IPK=0 sedang IPS # 0</td>\r\n      <td  align=center {$valid2['1']} >{$valid['1']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Nilai IPS di luar range wajar</td>\r\n      <td  align=center {$valid2['2']} >{$valid['2']}  </td>\r\n      <td  {$valid2['3']} >Nilai IPK tidak wajar (>4)</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Jumlah SKS semester blank</td>\r\n      <td  align=center  >0 </td>\r\n      <td   {$valid2['4']}>Jumlah SKS Semester > 30 sks</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']}   </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['5']}>Jumlah SKS diperoleh blank</td>\r\n      <td  align=center {$valid2['5']}>{$valid['5']} </td>\r\n      <td  >SKS Sem. TRAKM # Jumlah SKS MK TRNLM</td>\r\n      <td  align=center >0</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >IPS di TRAKM # IPS di TRNLM</td>\r\n      <td  align=center  >0 </td>\r\n      <td  >NIM tidak ada di TRNLM</td>\r\n      <td  align=center {$valid2['6']}>{$valid['6']}</td>\r\n    </tr>\r\n \r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
