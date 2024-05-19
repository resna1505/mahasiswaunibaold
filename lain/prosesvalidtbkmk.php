<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Kurikulum Mata Kuliah (TBKMK) {$tahun}{$semester}" );
$q = "SELECT COUNT(KDKMKTBKMK) AS JML FROM tbkmk\r\n   WHERE KDPSTTBKMK ='{$kodeps}'\r\n   AND KDJENTBKMK='{$kodejenjang}'\r\n   AND KDPTITBKMK='{$kodept}'\r\n   AND THSMSTBKMK='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTBKMK ='{$kodeps}'\r\n   AND KDJENTBKMK='{$kodejenjang}'\r\n   AND KDPTITBKMK='{$kodept}'\r\n   AND THSMSTBKMK='{$tahun}{$semester}'";
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
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n        (NAKMKTBKMK ='' )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>Nama M.K. Kosong/ada spasi awal</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']} - {$d2['NAKMKTBKMK']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n \r\n        WHERE \r\n        (KDKMKTBKMK='')\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>Kode M.K. Kosong/ada spasi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          SKSTMTBKMK+SKSLPTBKMK+SKSPRTBKMK=0\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>SKS Tatap Muka + Prak + Prak. Lap. =0</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          SKSMKTBKMK+0=0\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>SKS mata kuliah blank/kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          (SKSMKTBKMK>9 OR SKSTMTBKMK>9 OR SKSPRTBKMK>9 OR SKSLPTBKMK>9)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Ada isian SKS > 9 SKS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          (NODOSTBKMK='' OR NODOSTBKMK IS NULL)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. Dosen Pengampu Kosong</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          NODOSMSDOS IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. Dosen Pengampu # MSDOS</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN mspst\r\n      ON  KDPSTTBKMK=KDPSTMSPST\r\n        WHERE \r\n          KDPSTMSPST IS NULL\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[7] = 1;
        $valid2[7] = $warnatidakvalid;
        $tmpdata .= "<p><b>Prog. Studi Pengampu # MSPST</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          STDOSMSDOS !='A'\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[8] = 1;
        $valid2[8] = $warnatidakvalid;
        $tmpdata .= "<p><b>Status Dosen pengampu # 'A'</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT KDKMKTBKMK,NAKMKTBKMK,NODOSTBKMK  FROM tbkmk   LEFT JOIN msdos\r\n      ON  NODOSTBKMK=NODOSMSDOS\r\n        WHERE \r\n          (SKSMKTBKMK< SKSTMTBKMK+SKSPRTBKMK+SKSLPTBKMK)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[9] = 1;
        $valid2[9] = $warnatidakvalid;
        $tmpdata .= "<p><b>SKS tatap muka + prak + lapangan < sks mata kuliah</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['KDKMKTBKMK']}  - {$d2['NAKMKTBKMK']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT \r\n       SUM(IF(SEMESTBKMK='01',1,0)) AS SATU,\r\n       SUM(IF(SEMESTBKMK='02',1,0)) AS DUA,\r\n       SUM(IF(SEMESTBKMK='03',1,0)) AS TIGA,\r\n       SUM(IF(SEMESTBKMK='04',1,0)) AS EMPAT,\r\n       SUM(IF(SEMESTBKMK='05',1,0)) AS LIMA,\r\n       SUM(IF(SEMESTBKMK='06',1,0)) AS ENAM,\r\n       SUM(IF(SEMESTBKMK='07',1,0)) AS TUJUH,\r\n       SUM(IF(SEMESTBKMK='08',1,0)) AS DELAPAN\r\n       FROM tbkmk    \r\n        WHERE \r\n          1=1\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $d2 = sqlfetcharray( $h2 );
        $status = 1;
        if ( $d2[SATU] <= 0 )
        {
            $status = 0;
            $semsalah .= "01,";
        }
        if ( $d2[DUA] <= 0 )
        {
            $status = 0;
            $semsalah .= "02,";
        }
        if ( $d2[TIGA] <= 0 )
        {
            $status = 0;
            $semsalah .= "03,";
        }
        if ( $d2[EMPAT] <= 0 )
        {
            $status = 0;
            $semsalah .= "04,";
        }
        if ( $d2[LIMA] <= 0 )
        {
            $status = 0;
            $semsalah .= "05,";
        }
        if ( $d2[ENAM] <= 0 )
        {
            $status = 0;
            $semsalah .= "06,";
        }
        if ( $d2[TUJUH] <= 0 )
        {
            $status = 0;
            $semsalah .= "07,";
        }
        if ( $d2[DELAPAN] <= 0 )
        {
            $status = 0;
            $semsalah .= "08,";
        }
        if ( $status == 0 )
        {
            $tmpdata .= "<p><b>Alokasi Semester {$semsalah} pada TBKMK belum diisi - Perbaiki !!\r\nAnda belum mendatakan seluruh M.K. yang ada di Kurikulum</b><br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Jumlah Record Dobel</td>\r\n      <td  align=center  >0</td>\r\n      <td  {$valid2['0']}>Nama M.K. Kosong/ada spasi awal</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['1']}>Kode M.K. Kosong/ada spasi</td>\r\n      <td  align=center {$valid2['1']}>{$valid['1']} </td>\r\n      <td  {$valid2['2']}>SKS Tatap Muka + Prak. + Prak. Lap. =0 </td>\r\n      <td  align=center   {$valid2['2']}>{$valid['2']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['3']}>SKS mata kuliah blank/kosong</td>\r\n      <td  align=center {$valid2['3']}>{$valid['3']} </td>\r\n      <td   {$valid2['4']}>Ada isian SKS > 9 SKS</td>\r\n      <td  align=center {$valid2['4']}>{$valid['4']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td    >Kode Semester MK tidak benar</td>\r\n      <td  align=center   >0 </td>\r\n      <td   >Wajib/pilihan # TBKOD</td>\r\n      <td  align=center  > 0  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td    >Kode Kelompok MK # TBKOD</td>\r\n      <td  align=center   >0 </td>\r\n      <td   >Kode Kurikulum # TBKOD</td>\r\n      <td  align=center  > 0  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['5']}>No. Dosen Pengampu Kosong</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']}   </td>\r\n      <td  {$valid2['4']}>No. Dosen Pengampu # MSDOS</td>\r\n      <td  align=center {$valid2['6']} >{$valid['6']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['7']}>Prog. Studi Pengampu # MSPST</td>\r\n      <td  align=center {$valid2['7']} >{$valid['7']}   </td>\r\n      <td   >Jenjang Pengampu MK # TBKOD/MSPST</td>\r\n      <td  align=center  >0</td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td   >Kode SAP # TBKOD</td>\r\n      <td  align=center  >0</td>\r\n      <td  >Kode Silabus # TBKOD</td>\r\n      <td  align=center >0 </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td   >Kode Bahan Ajar # TBKOD</td>\r\n      <td  align=center  >0</td>\r\n      <td  >Kode Diktat # TBKOD</td>\r\n      <td  align=center >0 </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td   >Status Mata Kuliah # TBKOD</td>\r\n      <td  align=center  >0</td>\r\n      <td  {$valid2['8']}>Status Dosen pengampu # 'A'</td>\r\n      <td  align=center {$valid2['8']} >{$valid['8']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td   {$valid2['9']}>SKS tatap muka + prak + lapangan < sks mata kuliah</td>\r\n      <td  align=center  {$valid2['9']} >{$valid['9']}</td>\r\n      <td  ></td>\r\n      <td  align=center ></td>\r\n    </tr> \r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
