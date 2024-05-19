<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Transaksi Cuti/Lulus/Berhenti/DO Mahasiswa (TRLSM)" );
$q = "SELECT COUNT(NIMHSTRLSM) AS JML FROM trlsm\r\n   WHERE KDPSTTRLSM ='{$kodeps}'\r\n   AND KDJENTRLSM='{$kodejenjang}'\r\n   AND KDPTITRLSM='{$kodept}'\r\n   AND THSMSTRLSM='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTRLSM ='{$kodeps}'\r\n   AND KDJENTRLSM='{$kodejenjang}'\r\n   AND KDPTITRLSM='{$kodept}'\r\n   AND THSMSTRLSM='{$tahun}{$semester}'";
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
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (NIMHSMSMHS ='' )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b> \tNIM tidak ada di MSMHS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']} - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM  FROM trlsm   LEFT JOIN trakm\r\n      ON  \r\n      (THSMSTRLSM=THSMSTRAKM AND\r\n      KDPTITRLSM=KDPTITRAKM AND\r\n      KDJENTRLSM=KDJENTRAKM AND\r\n      KDPSTTRLSM=KDPSTTRAKM AND\r\n      NIMHSTRLSM=NIMHSTRAKM\r\n        )\r\n        WHERE \r\n        STMHSTRLSM='L' AND\r\n        STLLSTRLSM IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIM Mhs Lulus tidak ada di TRAKM</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}   <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND TGLLSTRLSM ='0000-00-00')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, Tgl Lulus Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='A'  )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Mahasiswa tidak boleh 'A'</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND NLIPKTRLSM =0)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, IPK Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND STMHSTRLSM !='K' AND  TGLLSTRLSM !='0000-00-00'  )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status # Lulus, Tgl Lulus Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND SKSTTTRLSM =0)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, Total SKS Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND NLIPKTRLSM >0)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[7] = 1;
        $valid2[7] = $warnatidakvalid;
        $tmpdata .= "<p><b> \tStatus # Lulus, IPK Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (TGLLSTRLSM >NOW())\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[8] = 1;
        $valid2[8] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tgl Lulus > Hari ini</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND SKSTTTRLSM >0)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[9] = 1;
        $valid2[9] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status # Lulus, Total SKS Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND NOSKRTRLSM='')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[10] = 1;
        $valid2[10] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, No SK Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND NOSKRTRLSM !='')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[11] = 1;
        $valid2[11] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status # Lulus, No. SK Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND NOIJATRLSM='')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[12] = 1;
        $valid2[12] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, No Ijazah Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND NOIJATRLSM !='')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[13] = 1;
        $valid2[13] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status # Lulus, No. Ijazah Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND TGLRETRLSM='0000-00-00')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[14] = 1;
        $valid2[14] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Lulus, Tgl SK Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM !='L' AND TGLRETRLSM !='0000-00-00')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[15] = 1;
        $valid2[15] = $warnatidakvalid;
        $tmpdata .= "<p><b> \tStatus # Lulus, Tgl SK Ada Isi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (STMHSTRLSM ='L' AND TGLRETRLSM<TGLLSTRLSM)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[16] = 1;
        $valid2[16] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tgl SK Yudisium < Tgl Lulus</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSTRLSM,NMMHSMSMHS  FROM trlsm   LEFT JOIN msmhs\r\n      ON  NIMHSTRLSM=NIMHSMSMHS\r\n        WHERE \r\n        (TGLRETRLSM>NOW())\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[17] = 1;
        $valid2[17] = $warnatidakvalid;
        $tmpdata .= "<p><b> Tgl SK Yudisium > Hari ini</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSTRLSM']}  - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Jumlah Record Dobel</td>\r\n      <td  align=center  >0</td>\r\n      <td  {$valid2['0']}>NIM tidak ada di MSMHS</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['1']}>NIM Mhs Lulus tidak ada di TRAKM</td>\r\n      <td  align=center {$valid2['1']}>{$valid['1']} </td>\r\n      <td   >Kode Status Mahasiswa # TBKOD </td>\r\n      <td  align=center   >0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Status Lulus, Tgl Lulus Kosong</td>\r\n      <td  align=center {$valid2['2']}>{$valid['2']} </td>\r\n      <td   {$valid2['3']}>Status Mahasiswa tidak boleh 'A'</td>\r\n      <td  align=center {$valid2['3']}>{$valid['3']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['4']} >Status Lulus, IPK Kosong</td>\r\n      <td  align=center   {$valid2['4']}>{$valid['4']} </td>\r\n      <td   {$valid2['5']}>Status # Lulus, Tgl Lulus Ada Isi</td>\r\n      <td  align=center  {$valid2['5']}>{$valid['5']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['6']} >Status Lulus, Total SKS Kosong</td>\r\n      <td  align=center   {$valid2['6']}>{$valid['6']}</td>\r\n      <td   {$valid2['7']}>Status # Lulus, IPK Ada Isi</td>\r\n      <td  align=center  {$valid2['7']}>{$valid['7']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['8']}>Tgl Lulus > Hari ini</td>\r\n      <td  align=center {$valid2['8']} >{$valid['8']}   </td>\r\n      <td  {$valid2['9']}>Status # Lulus, Total SKS Ada Isi</td>\r\n      <td  align=center {$valid2['9']} >{$valid['9']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['10']}>Status Lulus, No SK Kosong</td>\r\n      <td  align=center {$valid2['10']} >{$valid['10']}   </td>\r\n      <td  {$valid2['11']} >Status # Lulus, No. SK Ada Isi</td>\r\n      <td  align=center  {$valid2['11']}>{$valid['11']}</td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['12']} >Status Lulus, No Ijazah Kosong</td>\r\n      <td  align=center  {$valid2['12']}>{$valid['12']}</td>\r\n      <td  {$valid2['13']}>Status # Lulus, No. Ijazah Ada Isi</td>\r\n      <td  align=center {$valid2['13']}>{$valid['13']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td {$valid2['14']}  >Status Lulus, Tgl SK Kosong</td>\r\n      <td  align=center  {$valid2['14']}>{$valid['14']}</td>\r\n      <td {$valid2['15']} >Status # Lulus, Tgl SK Ada Isi</td>\r\n      <td  align=center {$valid2['15']}>{$valid['15']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['16']} >Tgl SK Yudisium < Tgl Lulus</td>\r\n      <td  align=center  {$valid2['16']}>{$valid['16']}</td>\r\n      <td  {$valid2['17']}>Tgl SK Yudisium > Hari ini</td>\r\n      <td  align=center {$valid2['17']} >{$valid['17']} </td>\r\n    </tr> \r\n  \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
