<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Dosen Mengajar (TRAKD)" );
$q = "SELECT COUNT(NODOSTRAKD) AS JML FROM trakd\r\n   WHERE KDPSTTRAKD ='{$kodeps}'\r\n   AND KDJENTRAKD='{$kodejenjang}'\r\n   AND KDPTITRAKD='{$kodept}'\r\n   AND THSMSTRAKD='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTRAKD ='{$kodeps}'\r\n   AND KDJENTRAKD='{$kodejenjang}'\r\n   AND KDPTITRAKD='{$kodept}'\r\n   AND THSMSTRAKD='{$tahun}{$semester}'";
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
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n        NODOSMSDOS IS NULL  \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. Dosen tidak ada di MSDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n        (KELASTRAKD='' OR KELASTRAKD+0=0)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode Kelas Paralele Kosong/Salah</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']}  - {$d2['NMDOSMSDOS']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n          TMRENTRAKD>30\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Rencana Tatap Muka Tidak Wajar</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']}  - {$d2['NMDOSMSDOS']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n          TMRENTRAKD=0\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Rencana Tatap Muka Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']}  - {$d2['NMDOSMSDOS']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n          TMRELTRAKD>TMRENTRAKD\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Realisasi Tatap Muka > Rencana</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']}  - {$d2['NMDOSMSDOS']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD,NMDOSMSDOS,KDKMKTRAKD,KELASTRAKD FROM trakd   LEFT JOIN msdos\r\n      ON  NODOSTRAKD=NODOSMSDOS\r\n        WHERE \r\n          TMRELTRAKD=0\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>Realisasi Tatap Muka Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']}  - {$d2['NMDOSMSDOS']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD, KDKMKTRAKD,KELASTRAKD ,KDKMKTBKMK\r\n       FROM trakd   LEFT JOIN tbkmk\r\n      ON  KDKMKTRAKD=KDKMKTBKMK AND THSMSTRAKD=THSMSTBKMK\r\n        WHERE \r\n          KDKMKTBKMK IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode MK tidak ada di TBKMK</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRAKD, KDKMKTRAKD,KELASTRAKD ,KDKMKTRNLM\r\n       FROM trakd   LEFT JOIN trnlm\r\n      ON  KDKMKTRAKD=KDKMKTRNLM AND THSMSTRAKD=THSMSTRNLM\r\n        WHERE \r\n          KDKMKTRNLM IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[7] = 1;
        $valid2[7] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode MK tidak ada di TRNLM </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRAKD']} - {$d2['KDKMKTRAKD']}/{$d2['KELASTRAKD']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center 0>0 </td>\r\n      <td  {$valid2['0']}>No. Dosen tidak ada di MSDOS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['6']}>Kode MK tidak ada di TBKMK</td>\r\n      <td  align=center {$valid2['6']}>{$valid['6']} </td>\r\n      <td  {$valid2['7']}>Kode MK tidak ada di TRNLM</td>\r\n      <td  align=center  {$valid2['7']} >{$valid['7']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['1']}>Kode Kelas Paralel Kosong/Salah</td>\r\n      <td  align=center {$valid2['1']} >{$valid['1']}  </td>\r\n      <td  {$valid2['3']} >Rencana Tatap Muka Tidak Wajar</td>\r\n      <td  align=center {$valid2['2']} >{$valid['2']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['3']} >Rencana Tatap Muka Kosong</td>\r\n      <td  align=center  {$valid2['3']} >{$valid['3']} </td>\r\n      <td   {$valid2['4']}>Realisasi Tatap Muka > Rencana</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']}   </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['5']}>Realisasi Tatap Muka Kosong</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']}   </td>\r\n      <td  > </td>\r\n      <td  align=center > </td>\r\n    </tr> \r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
