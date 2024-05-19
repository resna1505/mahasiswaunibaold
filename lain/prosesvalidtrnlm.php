<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Nilai Semester Mahasiswa (TRNLM)" );
$q = "SELECT COUNT(NIMHSTRNLM) AS JML FROM trnlm \r\n   WHERE KDPSTTRNLM ='{$kodeps}'\r\n   AND KDJENTRNLM='{$kodejenjang}'\r\n   AND KDPTITRNLM='{$kodept}'\r\n   AND THSMSTRNLM='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTRNLM ='{$kodeps}'\r\n   AND KDJENTRNLM='{$kodejenjang}'\r\n   AND KDPTITRNLM='{$kodept}'\r\n   AND THSMSTRNLM='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$i = 0;
if ( $i < 20 )
{
    $valid[$i] = 0;
    $valid2[$i] = 0;
    ++$i;
}
$tmpdata = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = $jmlrecw = "";
    $d = sqlfetcharray( $h );
    $q = "SELECT NIMHSTRNLM,NIMHSMSMHS,KDKMKTRNLM FROM trnlm   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLM=NIMHSMSMHS\r\n        WHERE \r\n        NIMHSMSMHS IS NULL  \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIM tidak ada di MSMHS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']} - {$d2['NMMHSMSMHS']} - {$d2['KDKMKTRNLM']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,KDKMKTRNLM FROM trnlm   LEFT JOIN tbkmk\r\n      ON  \r\n        (\r\n          KDKMKTRNLM=KDKMKTBKMK AND\r\n          THSMSTRNLM=THSMSTBKMK AND\r\n          KDPTITRNLM=KDPTITBKMK AND\r\n          KDJENTRNLM=KDJENTBKMK AND\r\n          KDPSTTRNLM=KDPSTTBKMK \r\n        )\r\n        WHERE \r\n        KDKMKTBKMK IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode MK tidak ada di TBKMK</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLM']} Kode MK: {$d2['KDKMKTRNLM']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,KDKMKTRNLM, KELASTRNLM FROM trnlm   LEFT JOIN trakd\r\n      ON  \r\n        (\r\n          KDKMKTRNLM=KDKMKTRAKD AND\r\n          THSMSTRNLM=THSMSTRAKD AND\r\n          KDPTITRNLM=KDPTITRAKD AND\r\n          KDJENTRNLM=KDJENTRAKD AND\r\n          KDPSTTRNLM=KDPSTTRAKD \r\n        )\r\n        WHERE \r\n        KDKMKTRAKD IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode MK tidak ada di TRAKD</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLM']} Kode MK:  {$d2['KDKMKTRNLM']} Kelas :  {$d2['KELASTRNLM']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,NLAKHTRNLM FROM trnlm   LEFT JOIN tbbnl\r\n      ON  \r\n        (\r\n          NLAKHTRNLM=NLAKHTBBNL AND\r\n          THSMSTRNLM=THSMSTBBNL AND\r\n          KDPTITRNLM=KDPTITBBNL AND\r\n          KDJENTRNLM=KDJENTBBNL AND\r\n          KDPSTTRNLM=KDPSTTBBNL \r\n        )\r\n        WHERE \r\n        NLAKHTBBNL IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai # Tabel Bobot Nilai</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLM']}  - Nilai: {$d2['NLAKHTRNLM']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,BOBOTTRNLM FROM trnlm   LEFT JOIN tbbnl\r\n      ON  \r\n        (\r\n          BOBOTTRNLM=BOBOTTBBNL AND\r\n          THSMSTRNLM=THSMSTBBNL AND\r\n          KDPTITRNLM=KDPTITBBNL AND\r\n          KDJENTRNLM=KDJENTBBNL AND\r\n          KDPSTTRNLM=KDPSTTBBNL \r\n        )\r\n        WHERE \r\n        BOBOTTBBNL IS NULL\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Bobot Nilai # Tabel Bobot Nilai</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']}  - {$d2['BOBOTTRNLM']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM FROM trnlm   LEFT JOIN trakm\r\n      ON  \r\n        (\r\n          NIMHSTRNLM=NIMHSTRAKM AND\r\n          THSMSTRNLM=THSMSTRAKM AND\r\n          KDPTITRNLM=KDPTITRAKM AND\r\n          KDJENTRNLM=KDJENTRAKM AND\r\n          KDPSTTRNLM=KDPSTTRAKM \r\n        )\r\n        WHERE \r\n        NIMHSTRAKM IS NULL\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIM tidak ada di TRAKM</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM, KDKMKTRNLM,THSMSTRNLM, COUNT( KDKMKTRNLM ) AS JML\r\n            FROM trnlm\r\n            WHERE 1=1 {$qf}\r\n            GROUP BY NIMHSTRNLM, KDKMKTRNLM,THSMSTRNLM\r\n            HAVING JML >1\r\n\r\n       ";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>Jumlah Record dobel</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']}  - {$d2['KDKMKTRNLM']}  - {$d2['THSMSTRNLM']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center {$valid2['6']} >{$valid['6']} </td>\r\n      <td  {$valid2['0']}>NIM tidak ada di MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['0']}>NIM # MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n      <td  {$valid2['1']} >Kode MK tidak ada di TBKMK</td>\r\n      <td  align=center {$valid2['1']} >{$valid['1']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Kode MK tidak ada di TRAKD</td>\r\n      <td  align=center {$valid2['2']} >{$valid['2']}  </td>\r\n      <td  {$valid2['3']} >Nilai # Tabel Bobot Nilai</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['4']}>Bobot Nilai # Tabel Bobot Nilai</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']} </td>\r\n      <td   {$valid2['5']}>NIM tidak ada di TRAKM</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']}   </td>\r\n    </tr>\r\n  \r\n  </table>\r\n  {$tmpdata}\r\n  \r\n  ";
echo " \r\n \r\n";
?>
