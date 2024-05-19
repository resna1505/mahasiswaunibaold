<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Publikasi Penelitian Dokter (TRPUD)" );
$q = "SELECT COUNT(NODOSTRPUD) AS JML FROM trpud\r\n   WHERE KDPSTTRPUD ='{$kodeps}'\r\n   AND KDJENTRPUD='{$kodejenjang}'\r\n   AND KDPTITRPUD='{$kodept}'\r\n   AND THSMSTRPUD='{$tahun}{$semester}'\r\n   ";
$qf = "AND KDPSTTRPUD ='{$kodeps}'\r\n   AND KDJENTRPUD='{$kodejenjang}'\r\n   AND KDPTITRPUD='{$kodept}'\r\n   AND THSMSTRPUD='{$tahun}{$semester}'";
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
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n        (KDSTAMSDOS !='A'  OR KDSTAMSDOS IS NULL)\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[0] = 1;
        $valid2[0] = $warnatidakvalid;
        $tmpdata .= "<p><b>Bukan Dosen Tetap home base</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n        (NORUTTRPUD='' OR NORUTTRPUD+0>9 OR NORUTTRPUD+0=0 )\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[1] = 1;
        $valid2[1] = $warnatidakvalid;
        $tmpdata .= "<p><b>No. Urut Kosong/Bukan 1-9</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n          JMBIYTRPUD<0\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[2] = 1;
        $valid2[2] = $warnatidakvalid;
        $tmpdata .= "<p><b>Biaya Penelitian < 0</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n          JUDU1TRPUD=''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[3] = 1;
        $valid2[3] = $warnatidakvalid;
        $tmpdata .= "<p><b>Baris Judul #1 harus diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n         JUDU2TRPUD='' AND JUDU3TRPUD!=''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[4] = 1;
        $valid2[4] = $warnatidakvalid;
        $tmpdata .= "<p><b>Judul #2 Kosong tapi #3 diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n          JUDU3TRPUD='' AND JUDU4TRPUD!=''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[5] = 1;
        $valid2[5] = $warnatidakvalid;
        $tmpdata .= "<p><b>Judul #3 Kosong tapi #4 diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSTRPUD,NMDOSMSDOS,NORUTTRPUD FROM trpud   LEFT JOIN msdos\r\n      ON  NODOSTRPUD=NODOSMSDOS\r\n        WHERE \r\n          JUDU4TRPUD='' AND JUDU5TRPUD!=''\r\n        {$qf}";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $valid[6] = 1;
        $valid2[6] = $warnatidakvalid;
        $tmpdata .= "<p><b>Judul #4 Kosong tapi #5 diisi</b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSTRPUD']}  - {$d2['NMDOSMSDOS']} - {$d2['NORUTTRPUD']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['0']}>Bukan Dosen Tetap home base</td>\r\n      <td  align=center {$valid2['0']}>{$valid['0']} </td>\r\n      <td  {$valid2['1']}>No. Urut Kosong/Bukan 1-9</td>\r\n      <td  align=center {$valid2['1']}>{$valid['1']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Kode Publikasi # TBKOD</td>\r\n      <td  align=center >0 </td>\r\n      <td  >Kode Jenis Penelitian # TBKOD</td>\r\n      <td  align=center   >0  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Kode Author # TBKOD</td>\r\n      <td  align=center > 0 </td>\r\n      <td   >Kode Mandiri/Kelompok # M/K</td>\r\n      <td  align=center> 0</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td    >Isian Tahun/Bulan tidak Sesuai</td>\r\n      <td  align=center   >0 </td>\r\n      <td   >Kode Biaya # TBKOD</td>\r\n      <td  align=center  > 0  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['2']}>Biaya Penelitian < 0</td>\r\n      <td  align=center {$valid2['2']} >{$valid['2']}   </td>\r\n      <td  {$valid2['4']}> Judul #2 Kosong tapi #3 diisi</td>\r\n      <td  align=center {$valid2['4']} >{$valid['4']} </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['3']}>Baris Judul #1 harus diisi</td>\r\n      <td  align=center {$valid2['3']} >{$valid['3']}   </td>\r\n      <td  {$valid2['6']}> Judul #4 Kosong tapi #5 diisi</td>\r\n      <td  align=center {$valid2['6']} >{$valid['6']}  </td>\r\n    </tr> \r\n    <tr class=datagenap   >\r\n      <td  {$valid2['5']}>  Judul #3 Kosong tapi #4 diisi</td>\r\n      <td  align=center {$valid2['5']} >{$valid['5']}   </td>\r\n      <td  ></td>\r\n      <td  align=center > </td>\r\n    </tr> \r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
