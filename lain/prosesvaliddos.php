<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

exit( );
printjudulmenukecil( "<b>Validasi Data Dosen (MSDOS)" );
$q = "SELECT COUNT(NODOSMSDOS) AS JML FROM msdos\r\n   WHERE KDPSTMSDOS ='{$kodeps}'\r\n   AND KDJENMSDOS='{$kodejenjang}'\r\n   AND KDPTIMSDOS='{$kodept}'\r\n \r\n   ";
$qf = "AND KDPSTMSDOS ='{$kodeps}'\r\n   AND KDJENMSDOS='{$kodejenjang}'\r\n   AND KDPTIMSDOS='{$kodept}'\r\n  ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$i = 0;
while ( $i <= 25 )
{
    $valid[$i] = 0;
    $valid2[$i] = "";
    ++$i;
}
$tmpdata = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = $jmlrecw = "";
    $d = sqlfetcharray( $h );
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  WHERE \r\n        NMDOSMSDOS =''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nama Dosen Kosong/Spasi Awal</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  WHERE \r\n        NODOSMSDOS LIKE '% %'\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. Dosen Kosong/Ada Notasi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  WHERE \r\n          (NOKTPMSDOS NOT LIKE '%0%' AND\r\n        NOKTPMSDOS NOT LIKE '%1%' AND\r\n        NOKTPMSDOS NOT LIKE '%2%' AND\r\n        NOKTPMSDOS NOT LIKE '%3%' AND\r\n        NOKTPMSDOS NOT LIKE '%4%' AND\r\n        NOKTPMSDOS NOT LIKE '%5%' AND\r\n        NOKTPMSDOS NOT LIKE '%6%' AND\r\n        NOKTPMSDOS NOT LIKE '%7%' AND\r\n        NOKTPMSDOS NOT LIKE '%8%' AND\r\n        NOKTPMSDOS NOT LIKE '%9%' ) \r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. KTP yg Tidak berisi Angka</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  WHERE \r\n          NIDNNMSDOS=''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIDN Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  WHERE \r\n          NIDNNMSDOS!=NODOSMSDOS\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>No Dosen # NIDN</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBDOS\r\n           ON NODOSMSDOS=NIDNNTBDOS\r\n           WHERE \r\n          (NIDNNTBDOS IS NULL OR NIDNNMSDOS !=NIDNNTBDOS) \r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIDN # TBDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBDOS\r\n           ON NODOSMSDOS=NIDNNTBDOS\r\n           WHERE \r\n          (TPLHRMSDOS  !=TPLHRTBDOS )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tempat Lahir # TBDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBDOS\r\n           ON NODOSMSDOS=NIDNNTBDOS\r\n           WHERE \r\n          (TGLHRMSDOS   !=TGLHRTBDOS )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[7] = 1;
        $valid2[7] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tanggal Lahir # TBDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          NOKTPMSDOS =''\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[8] = 1;
        $valid2[8] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. KTP Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          GELARMSDOS =''\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[9] = 1;
        $valid2[9] = $warnatidakvalid;
        $tmpdata .= "<p><b>Gelar Akademik Bukan Singkatan</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          (GELARMSDOS ='' OR GELARMSDOS LIKE '% %')\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[10] = 1;
        $valid2[10] = $warnatidakvalid;
        $tmpdata .= "<p><b>Gelar Akademik Kosong/Ada Spas</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          TGLHRMSDOS ='0000-00-00'\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[11] = 1;
        $valid2[11] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tanggal Lahir Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          (TPLHRMSDOS ='' OR TPLHRMSDOS LIKE ' %' OR TPLHRMSDOS LIKE '% ')\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[12] = 1;
        $valid2[12] = $warnatidakvalid;
        $tmpdata .= "<p><b>Tempat Lahir Kosong/Ada Spasi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n          YEAR(NOW())-YEAR(TGLHRMSDOS) < 17\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[13] = 1;
        $valid2[13] = $warnatidakvalid;
        $tmpdata .= "<p><b>  \tUsia/Tanggal Lahir tidak wajar</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos   \r\n          \r\n           WHERE \r\n           (((KDSTAMSDOS='F' OR KDSTAMSDOS='B') AND NIPNSMSDOS='')\r\n           OR \r\n           (!(KDSTAMSDOS='F' OR KDSTAMSDOS='B') AND NIPNSMSDOS!='')\r\n          )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[14] = 1;
        $valid2[14] = $warnatidakvalid;
        $tmpdata .= "<p><b>  PNS NIP Kosong/Sebaliknya</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBDOS\r\n           ON NODOSMSDOS=NIDNNTBDOS\r\n           WHERE \r\n          (NIPNSMSDOS   !=NIPNSTBDOS  )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[15] = 1;
        $valid2[15] = $warnatidakvalid;
        $tmpdata .= "<p><b>NIP PNS # NIP TBDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (KDPTITBPTI IS NULL)\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[16] = 1;
        $valid2[16] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode Instansi Induk # TBPTI</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (KDPTITBPTI IS NULL)\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $valid[17] = "?";
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $tmpdata .= "<p><b>Dosen Non PTN Instansi Induk Salah</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $valid[18] = "?";
    $valid[19] = "?";
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (MLSEMMSDOS!='' AND NOT (STDOSMSDOS='K' OR STDOSMSDOS='M') )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[20] = 1;
        $valid2[20] = $warnatidakvalid;
        $tmpdata .= "<p><b>  \tDosen Tidak Keluar Sem Diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (MLSEMMSDOS='' AND (STDOSMSDOS='K' OR STDOSMSDOS='M') )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[21] = 1;
        $valid2[21] = $warnatidakvalid;
        $tmpdata .= "<p><b>  \tDosen Keluar Mulai Sem Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (\r\n          (SUBSTR(MLSEMMSDOS,5,1)!='1' AND SUBSTR(MLSEMMSDOS,5,1)!='2') \r\n          AND (STDOSMSDOS='K' OR STDOSMSDOS='M') )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[22] = 1;
        $valid2[22] = $warnatidakvalid;
        $tmpdata .= "<p><b>  \tSemester pada Mulai Sem # 1/2</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos  LEFT JOIN TBPTI\r\n           ON PTINDMSDOS=KDPTITBPTI\r\n           WHERE \r\n          (\r\n           SUBSTR(MLSEMMSDOS,1,4)+0<2002    \r\n          AND (STDOSMSDOS='K' OR STDOSMSDOS='M') )\r\n       {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[23] = 1;
        $valid2[23] = $warnatidakvalid;
        $tmpdata .= "<p><b>  Isian Mulai Sem < 2002</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT COUNT(NODOSMSPDS) AS JML,NODOSMSDOS,NMDOSMSDOS  \r\n            FROM msdos LEFT JOIN mspds\r\n           ON NODOSMSPDS=NODOSMSDOS\r\n            WHERE (ASPTIMSPDS ='' OR ASPTIMSPDS IS NULL)\r\n            \r\n           \r\n       {$qf}\r\n       \r\n       GROUP BY NODOSMSDOS\r\n       HAVING JML=0";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[24] = 1;
        $valid2[24] = $warnatidakvalid;
        $tmpdata .= "<p><b> Dosen tidak ada riwayat Pendidikan</b><br>";
        if ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center 0>0 </td>\r\n      <td  {$valid2['0']}>Nama Dosen Kosong/Spasi Awal</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['1']}>No. Dosen Kosong/Ada Notasi</td>\r\n      <td  align=center {$valid2['1']}>{$valid['1']} </td>\r\n      <td  {$valid2['2']}>No. KTP yg Tidak berisi Angka</td>\r\n      <td  align=center   {$valid2['2']}>{$valid['2']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['3']}>NIDN Kosong</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']}  </td>\r\n      <td  {$valid2['4']} >No Dosen # NIDN</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['5']} >NIDN # TBDOS</td>\r\n      <td  align=center  {$valid2['5']} >{$valid['5']} </td>\r\n      <td   {$valid2['6']}>Tempat Lahir # TBDOS</td>\r\n      <td  align=center {$valid2['6']} >{$valid['6']}   </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['7']}>Tanggal Lahir # TBDOS</td>\r\n      <td  align=center {$valid2['7']} >{$valid['7']}   </td>\r\n      <td  > </td>\r\n      <td  align=center > </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['8']}>No. KTP Kosong</td>\r\n      <td  align=center {$valid2['8']} >{$valid['8']}   </td>\r\n      <td  {$valid2['9']}>Gelar Akademik Bukan Singkatan</td>\r\n      <td  align=center {$valid2['9']} >{$valid['9']}  </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['10']}>Gelar Akademik Kosong/Ada Spasi</td>\r\n      <td  align=center {$valid2['10']} >{$valid['10']}   </td>\r\n      <td  {$valid2['11']} >Tanggal Lahir Kosong</td>\r\n      <td  align=center {$valid2['11']} >{$valid['11']}  </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['12']}>Tempat Lahir Kosong/Ada Spasi</td>\r\n      <td  align=center {$valid2['12']} >{$valid['12']}   </td>\r\n      <td  {$valid2['13']}>Usia/Tanggal Lahir tidak wajar</td>\r\n      <td  align=center  {$valid2['13']} >{$valid['13']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  >Kode Jenis Kelamin # TBKOD</td>\r\n      <td  align=center  >0 </td>\r\n      <td  >Kode Jabatan Akademik # TBKOD</td>\r\n      <td  align=center >0 </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  >Kode Pend. Tertinggi # TBKOD</td>\r\n      <td  align=center >0   </td>\r\n      <td  >Status Ikatan Kerja # TBKOD</td>\r\n      <td  align=center  >0</td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['14']}>PNS NIP Kosong/Sebaliknya</td>\r\n      <td  align=center {$valid2['14']} >{$valid['14']}   </td>\r\n      <td  {$valid2['15']}>NIP PNS # NIP TBDOS</td>\r\n      <td  align=center {$valid2['15']} >{$valid['15']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['16']}>Kode Instansi Induk # TBPTI</td>\r\n      <td  align=center {$valid2['16']} >{$valid['16']}   </td>\r\n      <td  {$valid2['17']}>Dosen Non PTN Instansi Induk Salah</td>\r\n      <td  align=center {$valid2['17']} >{$valid['17']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['18']}>Dosen Tetap Instansi Induk Salah</td>\r\n      <td  align=center {$valid2['18']} >{$valid['18']}   </td>\r\n      <td  >Status Aktifitas Dosen # TBKOD</td>\r\n      <td  align=center >0 </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['19']}>Dosen PNS Instansi Induk Salah</td>\r\n      <td  align=center {$valid2['19']} >{$valid['19']}   </td>\r\n      <td  {$valid2['20']}>Dosen Tidak Keluar Sem Diisi</td>\r\n      <td  align=center {$valid2['20']} >{$valid['20']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['21']}>Dosen Keluar Mulai Sem Kosong</td>\r\n      <td  align=center {$valid2['21']} >{$valid['21']}   </td>\r\n      <td  {$valid2['22']}>Semester pada Mulai Sem # 1/2</td>\r\n      <td  align=center {$valid2['22']} >{$valid['22']}</td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['23']}>Isian Mulai Sem < 2002</td>\r\n      <td  align=center {$valid2['23']} >{$valid['23']}   </td>\r\n      <td  {$valid2['24']}>Dosen tidak ada riwayat Pendidikan</td>\r\n      <td  align=center {$valid2['24']} >{$valid['24']}  </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['25']}>Dosen Keluar Sem. ini # TRLSD</td>\r\n      <td  align=center {$valid2['25']} >{$valid['25']}   </td>\r\n      <td  ></td>\r\n      <td  align=center > </td>\r\n    </tr> \r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
