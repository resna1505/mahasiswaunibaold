<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Nilai Pindahan Mahasiswa (TRNLP)" );
$q = "SELECT COUNT(NIMHSTRNLP) AS JML FROM trnlp \r\n   WHERE KDPSTTRNLP ='{$kodeps}'\r\n   AND KDJENTRNLP='{$kodejenjang}'\r\n   AND KDPTITRNLP='{$kodept}'\r\n   ";
$qf = "AND KDPSTTRNLP ='{$kodeps}'\r\n   AND KDJENTRNLP='{$kodejenjang}'\r\n   AND KDPTITRNLP='{$kodept}'\r\n   ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$i = 0;
while ( $i < 20 )
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
    $q = "SELECT NIMHSTRNLP,NIMHSMSMHS,KDKMKTRNLP FROM trnlp   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLP=NIMHSMSMHS\r\n        WHERE \r\n        NIMHSMSMHS IS NULL  \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIM tidak ada di MSMHS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLP']} - {$d2['NMMHSMSMHS']} - {$d2['KDKMKTRNLP']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLP,KDKMKTRNLP FROM trnlp   LEFT JOIN tbkmk\r\n      ON  \r\n        (\r\n          KDKMKTRNLP=KDKMKTBKMK AND\r\n          KDPTITRNLP=KDPTITBKMK AND\r\n          KDJENTRNLP=KDJENTBKMK AND\r\n          KDPSTTRNLP=KDPSTTBKMK \r\n        )\r\n        WHERE \r\n        KDKMKTBKMK IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode MK tidak ada di TBKMK</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLP']} Kode MK: {$d2['KDKMKTRNLP']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLP,NLAKHTRNLP FROM trnlp   LEFT JOIN tbbnl\r\n      ON  \r\n        (\r\n          NLAKHTRNLP=NLAKHTBBNL AND\r\n          KDPTITRNLP=KDPTITBBNL AND\r\n          KDJENTRNLP=KDJENTBBNL AND\r\n          KDPSTTRNLP=KDPSTTBBNL \r\n        )\r\n        WHERE \r\n        NLAKHTBBNL IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai # Tabel Bobot Nilai</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLP']}  - Nilai: {$d2['NLAKHTRNLP']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLP,BOBOTTRNLP FROM trnlp   LEFT JOIN tbbnl\r\n      ON  \r\n        (\r\n          BOBOTTRNLP=BOBOTTBBNL AND\r\n          KDPTITRNLP=KDPTITBBNL AND\r\n          KDJENTRNLP=KDJENTBBNL AND\r\n          KDPSTTRNLP=KDPSTTBBNL \r\n        )\r\n        WHERE \r\n        BOBOTTBBNL IS NULL\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Bobot Nilai # Tabel Bobot Nilai</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLP']}  - {$d2['BOBOTTRNLP']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLP, KDKMKTRNLP, COUNT( KDKMKTRNLP ) AS JML\r\n            FROM trnlp\r\n            WHERE 1=1 {$qf}\r\n            GROUP BY NIMHSTRNLP, KDKMKTRNLP\r\n            HAVING JML >1\r\n\r\n       ";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>Jumlah Record dobel</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLP']}  - {$d2['KDKMKTRNLP']} <br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['3']} >Nilai # Tabel Bobot Nilai</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']} </td>\r\n      <td  {$valid2['0']}>NIM tidak ada di MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['4']}>Bobot Nilai # Tabel Bobot Nilai</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']} </td>\r\n      <td  {$valid2['1']} >Kode MK tidak ada di TBKMK</td>\r\n      <td  align=center {$valid2['1']} >{$valid['1']}  </td>\r\n    </tr>\r\n    \r\n  </table>\r\n  {$tmpdata}\r\n  \r\n  ";
echo " \r\n \r\n";
?>
