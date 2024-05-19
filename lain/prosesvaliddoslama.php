<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Dosen (MSDOS)" );
$q = "SELECT COUNT(NODOSMSDOS) AS JML FROM msdos \r\n   WHERE KDPSTMSDOS ='{$kodeps}'\r\n   AND KDJENMSDOS='{$kodejenjang}'\r\n   AND KDPTIMSDOS='{$kodept}'\r\n   ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$nim = $nama = $tempat = $tgl = $tgl2 = $angkatan = $batas = $batas2 = $prop = $prop2 = $angkatan2 = $status = $tgllulus = $status2 = $status4 = $status5 = $status6 = $pindahanpt = $pindahanps = $pindahanpt2 = $pindahanps2 = 0;
$nimw = $namaw = $tempatw = $tglw = $tgl2w = $angkatanw = $batasw = $batas2w = $propw = $prop2w = $angkatan2w = $statusw = $tgllulusw = $status2w = $status4w = $status5w = $status6w = $pindahanptw = $pindahanpsw = $pindahanpt2w = $pindahanps2w = "";
$tmpdata = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = $jmlrecw = "";
    $d = sqlfetcharray( $h );
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos    \r\n        WHERE \r\n        (NODOSMSDOS LIKE '% %' OR NODOSMSDOS ='')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $nimw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : NIM Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos    \r\n        WHERE \r\n        ( NMDOSMSDOS ='')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $nama = sqlnumrows( $h2 );
    if ( 0 < $nama )
    {
        $namaw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Nama Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos    \r\n        WHERE \r\n        ( TPLHRMSMHS ='')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tempat = sqlnumrows( $h2 );
    if ( 0 < $tempat )
    {
        $tempatw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tempat Lahir Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos    \r\n        WHERE \r\n        ( TGLHRMSMHS ='0000-00-00')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tgl = sqlnumrows( $h2 );
    if ( 0 < $tgl )
    {
        $tglw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tanggal Lahir Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==>  {$d2['TGLHRMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,TGLHRMSMHS  FROM msdos    \r\n        WHERE \r\n        ( YEAR(NOW()) - YEAR(TGLHRMSMHS) < 15)\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tgl2 = sqlnumrows( $h2 );
    if ( 0 < $tgl2 )
    {
        $tgl2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tanggal Lahir Tidak Wajar </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Tanggal Lahir : {$d2['TGLHRMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS  FROM msdos    \r\n        WHERE \r\n        ( TAHUNMSMHS ='')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $angkatan = sqlnumrows( $h2 );
    if ( 0 < $angkatan )
    {
        $angkatanw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Angkatan/Tahun Masuk Kosong  </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,BTSTUMSMHS  FROM msdos    \r\n        WHERE \r\n        (  SUBSTR(BTSTUMSMHS,1,4)  -  SUBSTR(SMAWLMSMHS,1,4)   < 0)\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $batas = sqlnumrows( $h2 );
    if ( 0 < $batas )
    {
        $batasw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Batas Studi Tidak Benar </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Batas Studi : {$tmp1}/".( $tmp1 + 1 )." ".$arraysemester[$tmp2]."<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,BTSTUMSMHS  FROM msdos    \r\n        WHERE \r\n        (  BTSTUMSMHS='' OR BTSTUMSMHS IS NULL )\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $batas2 = sqlnumrows( $h2 );
    if ( 0 < $batas2 )
    {
        $batas2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Batas Studi Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,ASSMAMSMHS  FROM msdos    \r\n        LEFT JOIN TBPRO ON msdos.ASSMAMSMHS=tbpro.KDPROTBPRO\r\n        WHERE tbpro.KDPROTBPRO IS NULL AND\r\n        msdos.ASSMAMSMHS!=''  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $prop = sqlnumrows( $h2 );
    if ( 0 < $prop )
    {
        $propw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode Propinsi # TBPROP </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Kode Propinsi :  {$d2['ASSMAMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS   FROM msdos    \r\n        WHERE  \r\n        msdos.ASSMAMSMHS=''  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $prop2 = sqlnumrows( $h2 );
    if ( 0 < $prop2 )
    {
        $prop2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode Propinsi Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS ,TAHUNMSMHS,TGMSKMSMHS  FROM msdos    \r\n        WHERE  \r\n        TAHUNMSMHS!=YEAR(TGMSKMSMHS)  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $angkatan2 = sqlnumrows( $h2 );
    if ( 0 < $angkatan2 )
    {
        $angkatan2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tahun Tgl Masuk # Tahun Angkatan </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Angkatan = {$d2['TAHUNMSMHS']},  Tanggal Masuk = {$d2['TGMSKMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS    FROM msdos    \r\n        WHERE  \r\n        STMHSMSMHS=''  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status = sqlnumrows( $h2 );
    if ( 0 < $status )
    {
        $statusw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Mahasiswa Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,ASSMAMSMHS,TGMSKMSMHS,TGLLSMSMHS,STMHSMSMHS  \r\n        FROM msdos    \r\n        WHERE  \r\n        ((TGLLSMSMHS < TGMSKMSMHS AND STMHSMSMHS='L')\r\n        OR\r\n        (TGLLSMSMHS IS NOT NULL AND TGLLSMSMHS !='0000-00-00' AND STMHSMSMHS!='L'))\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tgllulus = sqlnumrows( $h2 );
    if ( 0 < $tgllulus )
    {
        $tgllulusw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tanggal Lulus < Tanggal Masuk STATUS # 'L' </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}  ==> Status : {$d2['STMHSMSMHS']}, Tgl Lulus : {$d2['TGLLSMSMHS']}, Tgl Masuk : {$d2['TGMSKMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, TGLLSMSMHS,STMHSMSMHS  \r\n        FROM msdos    \r\n        WHERE  \r\n        \r\n        \r\n        ((TGLLSMSMHS IS NULL OR TGLLSMSMHS ='0000-00-00') AND STMHSMSMHS='L')\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status2 = sqlnumrows( $h2 );
    if ( 0 < $status2 )
    {
        $status2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Lulus 'L' Tanggal Lulus Kosong' </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']}  ==> Status : {$d2['STMHSMSMHS']}, Tgl Lulus : {$d2['TGLLSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, STPIDMSMHS \r\n        FROM msdos    \r\n        WHERE  \r\n        \r\n        \r\n        STPIDMSMHS=''\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status4 = sqlnumrows( $h2 );
    if ( 0 < $status4 )
    {
        $status4w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : STATUS Baru/Pindahan Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, STPIDMSMHS,SKSDIMSMHS \r\n        FROM msdos    \r\n        WHERE  \r\n        STPIDMSMHS='B' AND SKSDIMSMHS > 0\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status5 = sqlnumrows( $h2 );
    if ( 0 < $status5 )
    {
        $status5w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid :  Status baru, SKS > 0 </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> SKS : {$d2['SKSDIMSMHS']}, Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, STPIDMSMHS,SKSDIMSMHS \r\n        FROM msdos    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND SKSDIMSMHS = 0\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status6 = sqlnumrows( $h2 );
    if ( 0 < $status6 )
    {
        $status6w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Pindahan, SKS Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> SKS : {$d2['SKSDIMSMHS']}, Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, STPIDMSMHS \r\n        FROM msdos    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND ASPTIMSMHS = ''\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanpt = sqlnumrows( $h2 );
    if ( 0 < $pindahanpt )
    {
        $pindahanptw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Pindahan, Asal PT Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==>  Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS, STPIDMSMHS \r\n        FROM msdos    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND ASPSTMSMHS = ''\r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanps = sqlnumrows( $h2 );
    if ( 0 < $pindahanps )
    {
        $pindahanpsw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Pindahan, Asal PS Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
            $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==>  Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,ASPTIMSMHS  FROM msdos    \r\n        LEFT JOIN tbpti ON msdos.ASPTIMSMHS=tbpti.KDPTITBPTI\r\n        WHERE tbpti.KDPTITBPTI IS NULL AND\r\n        msdos.ASPTIMSMHS!=''  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanpt2 = sqlnumrows( $h2 );
    if ( 0 < $pindahanpt2 )
    {
        $pindahanpt2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode P.T. Pindahan # TBPTI </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Kode P.T. Pindahan :  {$d2['ASPTIMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NODOSMSDOS,NMDOSMSDOS,ASPSTMSMHS  FROM msdos    \r\n        LEFT JOIN tbpst ON msdos.ASPSTMSMHS=tbpst.KDPSTTBPST\r\n        WHERE tbpst.KDPSTTBPST IS NULL AND\r\n        msdos.ASPSTMSMHS!=''  \r\n        AND KDPSTMSDOS ='{$kodeps}'\r\n        AND KDJENMSDOS='{$kodejenjang}'\r\n        AND KDPTIMSDOS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanps2 = sqlnumrows( $h2 );
    if ( 0 < $pindahanps2 )
    {
        $pindahanps2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode P.S. Pindahan # TBPTI </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NODOSMSDOS']} - {$d2['NMDOSMSDOS']} ==> Kode P.S. Pindahan :  {$d2['ASPSTMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $tmp = explode( "-", $d[TGAWLMSPST] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglawal = 1;
        $tglawalw = $warnatidakvalid;
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center 0>0 </td>\r\n      <td  {$namaw}>Nama Dosen Kosong/Ada spasi</td>\r\n      <td  align=center {$namaw}>{$nama} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$nimw}>Nomer Dosen Kosong / ada spasi</td>\r\n      <td  align=center {$nimw}>{$nim} </td>\r\n      <td  {$ktp2w}>No KTP tidak berisi angka</td>\r\n      <td  align=center {$ktp2w}>{$ktp2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$ktpw}>Nomer KTP Kosong</td>\r\n      <td  align=center {$ktpw}>{$ktp} </td>\r\n      <td  {$gelarw}>Gelar Akademik Bukan Singkatan</td>\r\n      <td  align=center {$gelarw}>{$gelar} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$gelar2w}>Gelar Akademik Kosong/Ada Spasi</td>\r\n      <td  align=center {$gelar2w}>{$gelar2} </td>\r\n      <td  {$tglw}>Tanggal Lahir Kosong / ada spasi</td>\r\n      <td  align=center {$tglw}>{$tgl} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$tempatw}>Tempat Lahir Kosong / ada spasi</td>\r\n      <td  align=center {$tempatw}>{$tempat} </td>\r\n      <td  {$tgl2w}>Tanggal Lahir Tidak Wajar</td>\r\n      <td  align=center {$tgl2w}>{$tgl2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Kode Jenis Kelamin kosong</td>\r\n      <td  align=center  >0 </td>\r\n      <td  >Kode Jenis Kelamin # TBKOD</td>\r\n      <td  align=center >0</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$jabatanw}>Kode Jabatan Akademik Kosong</td>\r\n      <td  align=center {$jabatanw}>{$jabatan} </td>\r\n      <td  {$jabatan2w}>Kode Jabatan Akademik # TBKOD</td>\r\n      <td  align=center {$jabatan2w}>{$jabatan2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$pendidikanw}>Kode Pendidikan Teringgi Kosong</td>\r\n      <td  align=center {$pendidikanw}>{$pendidikan} </td>\r\n      <td  {$pendidikan2w}>Kode Pendidikan Teringgi  # TBKOD</td>\r\n      <td  align=center {$pendidikan2w}>{$pendidikan2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$ikatanw}>Status Ikatan Kerja Kosong</td>\r\n      <td  align=center {$ikatanw}>{$ikatan} </td>\r\n      <td  {$ikatan2w}>Status Ikatan Kerja # TBKOD</td>\r\n      <td  align=center {$ikatan2w}>{$ikatan2} </td>\r\n    </tr>\r\n \r\n    <tr class=datagenap   >\r\n      <td  {$asalptw}>Asal PT Kosong/ada Spasi</td>\r\n      <td  align=center {$asalptw}>{$asalpt} </td>\r\n      <td  {$bidangilmuw}>Bidang Ilmu Kosong/ada spasi</td>\r\n      <td  align=center {$bidangilmuw}>{$bidangilmu} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td    >Sertifikat Mengajar Kosong</td>\r\n      <td  align=center  >0 </td>\r\n      <td   >Kode Sertifikat Mengajar Bukan Y/T</td>\r\n      <td  align=center  >0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Surat Izin Mengajar Kosong  </td>\r\n      <td  align=center >0</td>\r\n      <td  >Kode Surat Izin Mengajar bukan Y/T</td>\r\n      <td  align=center >0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$nipw}>Dosen PNS NIP kosong/sebaliknya</td>\r\n      <td  align=center {$nipw}>{$nip} </td>\r\n      <td  {$nip2w} >Bukan Dosen PNS Depdiknas diisi NIP</td>\r\n      <td  align=center  {$nip2w}>{$nip2}</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$ptw}>Instansi Induk Dosen kosong</td>\r\n      <td  align=center {$ptw}>{$pt} </td>\r\n      <td  {$pt2w}>Kode Instansi Induk # TBPTI</td>\r\n      <td  align=center {$pt2w}>{$pt2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$dosentetapw}>Dosen Tetap Instansi Induk Salah</td>\r\n      <td  align=center {$dosentetapw}>{$dosentetap} </td>\r\n      <td  {$dosenhonorerw}>Dosen Honorer Instansi Induk Salah</td>\r\n      <td  align=center {$dosenhonorerw}>{$dosenhonorer} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$indukw}>Dosen PNS Instansi Induk Salah</td>\r\n      <td  align=center {$indukw}>{$induk} </td>\r\n      <td  {$induk2w}>Bukan Dosen PTN Instansi Induk Salah</td>\r\n      <td  align=center {$induk2w}>{$induk2} </td>\r\n    </tr>\r\n\r\n \r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
