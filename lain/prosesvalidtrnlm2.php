<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data KRS Mahasiswa (TRNLM) {$tahun2}{$semester2}" );
$q = "SELECT COUNT(NIMHSTRNLM) AS JML FROM trnlm \r\n   WHERE KDPSTTRNLM ='{$kodeps}'\r\n   AND KDJENTRNLM='{$kodejenjang}'\r\n   AND KDPTITRNLM='{$kodept}'\r\n   AND THSMSTRNLM='{$tahun2}{$semester2}'\r\n   ";
$qf = "AND KDPSTTRNLM ='{$kodeps}'\r\n   AND KDJENTRNLM='{$kodejenjang}'\r\n   AND KDPTITRNLM='{$kodept}'\r\n   AND THSMSTRNLM='{$tahun2}{$semester2}'";
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
            $tmpdata .= "{$d2['NIMHSTRNLM']} - {$d2['KDKMKTRNLM']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,NIMHSMSMHS,KDKMKTRNLM, NLAKHTRNLM,BOBOTTRNLM  FROM trnlm   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLM=NIMHSMSMHS\r\n        WHERE \r\n        (NLAKHTRNLM !='' AND NLAKHTRNLM IS NOT NULL) \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nilai tidak boleh ada isinya</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLM']} KODE MK: {$d2['KDKMKTRNLM']} NILAI: ({$d2['NLAKHTRNLM']},{$d2['BOBOTTRNLM']}) <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,NIMHSMSMHS,KDKMKTRNLM, BOBOTTRNLM FROM trnlm   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLM=NIMHSMSMHS\r\n        WHERE \r\n        BOBOTTRNLM IS NOT NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Bobot Nilai tidak boleh diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "NIM: {$d2['NIMHSTRNLM']} KODE MK: {$d2['KDKMKTRNLM']} NILAI: ({$d2['NLAKHTRNLM']},{$d2['BOBOTTRNLM']}) <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,NIMHSMSMHS,KDKMKTRNLM, KELASTRNLM FROM trnlm   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLM=NIMHSMSMHS\r\n        WHERE \r\n        LENGTH(KELASTRNLM)!=2\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kelas harus penuh 2 digit</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']} - {$d2['NIMHSMSMHS']} - {$d2['KDKMKTRNLM']} - {$d2['KELASTRNLM']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRNLM,NIMHSMSMHS,KDKMKTRNLM, KELASTRNLM FROM trnlm   LEFT JOIN msmhs\r\n      ON  NIMHSTRNLM=NIMHSMSMHS\r\n        WHERE \r\n        LENGTH(KELASTRNLM)!=2\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kelas harus diisi abjad atau '00'</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRNLM']} - {$d2['NIMHSMSMHS']} - {$d2['KDKMKTRNLM']} - {$d2['KELASTRNLM']} <br>";
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
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center {$valid2['6']}>{$valid['6']} </td>\r\n      <td  {$valid2['0']}>NIM tidak ada di MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['0']}>NIM # MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n      <td  {$valid2['1']} >Kode MK tidak ada di TBKMK</td>\r\n      <td  align=center {$valid2['1']} >{$valid['1']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Nilai tidak boleh ada isinya</td>\r\n      <td  align=center {$valid2['2']} >{$valid['2']}  </td>\r\n      <td  {$valid2['3']} >Bobot Nilai tidak boleh diisi</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['4']}>Kelas harus penuh 2 digit</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']} </td>\r\n      <td   {$valid2['5']}>Kelas harus diisi abjad atau '00'</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']}   </td>\r\n    </tr>\r\n  \r\n  </table>\r\n  \r\n {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
