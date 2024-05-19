<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenukecil( "<b>Validasi Data Mahasiswa (MSMHS)" );
$q = "SELECT COUNT(NIMHSMSMHS) AS JML FROM msmhs \r\n   WHERE \r\n   KDPSTMSMHS ='{$kodeps}'\r\n   AND KDJENMSMHS='{$kodejenjang}'\r\n   AND KDPTIMSMHS='{$kodept}'\r\n\r\n   ";
$qf = "\r\n   AND KDPSTMSMHS ='{$kodeps}'\r\n   AND KDJENMSMHS='{$kodejenjang}'\r\n   AND KDPTIMSMHS='{$kodept}'\r\n    \r\n    ";
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
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs    \r\n        WHERE \r\n        (NIMHSMSMHS LIKE '% %' OR NIMHSMSMHS ='')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $nimw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : NIM Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs    \r\n        WHERE \r\n        ( NMMHSMSMHS ='')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $nama = sqlnumrows( $h2 );
    if ( 0 < $nama )
    {
        $namaw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Nama Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs    \r\n        WHERE \r\n        ( TPLHRMSMHS ='')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tempat = sqlnumrows( $h2 );
    if ( 0 < $tempat )
    {
        $tempatw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tempat Lahir Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs    \r\n        WHERE \r\n        ( TGLHRMSMHS ='0000-00-00')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tgl = sqlnumrows( $h2 );
    if ( 0 < $tgl )
    {
        $tglw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tanggal Lahir Kosong atau ada Spasi </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==>  {$d2['TGLHRMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,TGLHRMSMHS  FROM msmhs    \r\n        WHERE \r\n        ( YEAR(NOW()) - YEAR(TGLHRMSMHS) < 15)\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $tgl2 = sqlnumrows( $h2 );
    if ( 0 < $tgl2 )
    {
        $tgl2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tanggal Lahir Tidak Wajar </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Tanggal Lahir : {$d2['TGLHRMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs    \r\n        WHERE \r\n        ( TAHUNMSMHS ='')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $angkatan = sqlnumrows( $h2 );
    if ( 0 < $angkatan )
    {
        $angkatanw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Angkatan/Tahun Masuk Kosong  </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,BTSTUMSMHS  FROM msmhs    \r\n        WHERE \r\n        (  SUBSTR(BTSTUMSMHS,1,4)  -  SUBSTR(SMAWLMSMHS,1,4)   < 0)\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Batas Studi : {$tmp1}/".( $tmp1 + 1 )." ".$arraysemester[$tmp2]."<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,BTSTUMSMHS  FROM msmhs    \r\n        WHERE \r\n        (  BTSTUMSMHS='' OR BTSTUMSMHS IS NULL )\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,ASSMAMSMHS  FROM msmhs    \r\n        LEFT JOIN TBPRO ON msmhs.ASSMAMSMHS=tbpro.KDPROTBPRO\r\n        WHERE tbpro.KDPROTBPRO IS NULL AND\r\n        msmhs.ASSMAMSMHS!=''  \r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $prop = sqlnumrows( $h2 );
    if ( 0 < $prop )
    {
        $propw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode Propinsi # TBPROP </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Kode Propinsi :  {$d2['ASSMAMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS   FROM msmhs    \r\n        WHERE  \r\n        msmhs.ASSMAMSMHS=''  \r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $prop2 = sqlnumrows( $h2 );
    if ( 0 < $prop2 )
    {
        $prop2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode Propinsi Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS ,TAHUNMSMHS,TGMSKMSMHS  FROM msmhs    \r\n        WHERE  \r\n        (NOT \r\n          (\r\n          TAHUNMSMHS=YEAR(TGMSKMSMHS) OR \r\n          TAHUNMSMHS+1=YEAR(TGMSKMSMHS)\r\n          )\r\n        )\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $angkatan2 = sqlnumrows( $h2 );
    if ( 0 < $angkatan2 )
    {
        $angkatan2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Tahun Tgl Masuk # Tahun Angkatan </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Angkatan = {$d2['TAHUNMSMHS']},  Tanggal Masuk = {$d2['TGMSKMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS    FROM msmhs    \r\n        WHERE  \r\n        STMHSMSMHS=''  \r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $status = sqlnumrows( $h2 );
    if ( 0 < $status )
    {
        $statusw = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status Mahasiswa Kosong </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,ASSMAMSMHS,TGMSKMSMHS,TGLLSMSMHS,STMHSMSMHS  \r\n        FROM msmhs    \r\n        WHERE  \r\n        ((TGLLSMSMHS < TGMSKMSMHS AND STMHSMSMHS='L')\r\n        OR\r\n        (TGLLSMSMHS IS NOT NULL AND TGLLSMSMHS !='0000-00-00' AND STMHSMSMHS!='L'))\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  ==> Status : {$d2['STMHSMSMHS']}, Tgl Lulus : {$d2['TGLLSMSMHS']}, Tgl Masuk : {$d2['TGMSKMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, TGLLSMSMHS,STMHSMSMHS  \r\n        FROM msmhs    \r\n        WHERE  \r\n        \r\n        \r\n        ((TGLLSMSMHS IS NULL OR TGLLSMSMHS ='0000-00-00') AND STMHSMSMHS='L')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  ==> Status : {$d2['STMHSMSMHS']}, Tgl Lulus : {$d2['TGLLSMSMHS']}  <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, STPIDMSMHS \r\n        FROM msmhs    \r\n        WHERE  \r\n        \r\n        \r\n        STPIDMSMHS=''\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} <br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, STPIDMSMHS,SKSDIMSMHS \r\n        FROM msmhs    \r\n        WHERE  \r\n        STPIDMSMHS='B' AND SKSDIMSMHS > 0\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> SKS : {$d2['SKSDIMSMHS']}, Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, STPIDMSMHS,SKSDIMSMHS \r\n        FROM msmhs    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND SKSDIMSMHS = 0\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> SKS : {$d2['SKSDIMSMHS']}, Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, STPIDMSMHS \r\n        FROM msmhs    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND ASPTIMSMHS = ''\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==>  Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS, STPIDMSMHS \r\n        FROM msmhs    \r\n        WHERE  \r\n        STPIDMSMHS='P' AND ASPSTMSMHS = ''\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
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
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==>  Status Pindahan : {$d2['STPIDMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,ASPTIMSMHS  FROM msmhs    \r\n        LEFT JOIN tbpti ON msmhs.ASPTIMSMHS=tbpti.KDPTITBPTI\r\n        WHERE tbpti.KDPTITBPTI IS NULL AND\r\n        msmhs.ASPTIMSMHS!=''  AND msmhs.ASPTIMSMHS!='000000'\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanpt2 = sqlnumrows( $h2 );
    if ( 0 < $pindahanpt2 )
    {
        $pindahanpt2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode P.T. Pindahan # TBPTI </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Kode P.T. Pindahan :  {$d2['ASPTIMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,ASPSTMSMHS  FROM msmhs    \r\n        LEFT JOIN tbpst ON msmhs.ASPSTMSMHS=tbpst.KDPSTTBPST\r\n        WHERE tbpst.KDPSTTBPST IS NULL AND\r\n        msmhs.ASPSTMSMHS!=''  AND msmhs.ASPSTMSMHS!='00000'  \r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
    $h2 = mysqli_query($koneksi,$q);
    $pindahanps2 = sqlnumrows( $h2 );
    if ( 0 < $pindahanps2 )
    {
        $pindahanps2w = $warnatidakvalid;
        $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Kode P.S. Pindahan # TBPTI </b><br>";
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Kode P.S. Pindahan :  {$d2['ASPSTMSMHS']}<br>";
        }
        $tmpdata .= "</p>";
    }
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS, TGLLSMSMHS,STMHSMSMHS  \r\n        FROM msmhs    \r\n        WHERE  \r\n        \r\n        \r\n        ((TGLLSMSMHS IS NOT NULL AND TGLLSMSMHS !='0000-00-00') AND STMHSMSMHS='A')\r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
$h2 = mysqli_query($koneksi,$q);
$status2 = sqlnumrows( $h2 );
if ( 0 < $status2 )
{
    $status2w = $warnatidakvalid;
    $tmpdata .= "<p><b>Data Mahasiswa Tidak Valid : Status 'A' Tanggal Lulus Ada' </b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmp1 = substr( $d2[BTSTUMSMHS], 0, 4 );
        $tmp2 = substr( $d2[BTSTUMSMHS], 4, 1 );
        $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']}  ==> Status : {$d2['STMHSMSMHS']}, Tgl Lulus : {$d2['TGLLSMSMHS']}  <br>";
    }
    $tmpdata .= "</p>";
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  0>Jumlah Record dobel</td>\r\n      <td  align=center 0>0 </td>\r\n      <td  {$nimw}>NIM Kosong / Ada Spasi</td>\r\n      <td  align=center {$nimw}>{$nim} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$namaw}>Nama Mahasiswa Kosong / ada spasi</td>\r\n      <td  align=center {$namaw}>{$nama} </td>\r\n      <td  {$tempatw}>Tempat Lahir Kosong / Ada Spasi</td>\r\n      <td  align=center {$tempatw}>{$tempat} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$tglw}>Tanggal Lahir Kosong / ada spasi</td>\r\n      <td  align=center {$tglw}>{$tgl} </td>\r\n      <td  {$tgl2w}>Tanggal Lahir Tidak Wajar</td>\r\n      <td  align=center {$tgl2w}>{$tgl2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Kode Jenis Kelamin kosong</td>\r\n      <td  align=center  >0 </td>\r\n      <td  >Kode Jenis Kelamin # TBKOD</td>\r\n      <td  align=center >0</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$angkatanw}>Tahun Angkatan Kosong</td>\r\n      <td  align=center {$angkatanw}>{$angkatan} </td>\r\n      <td  {$batasw}>Batas Studi tidak benar</td>\r\n      <td  align=center {$batasw}>{$batas} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$batas2w}>Batas Studi Kosong</td>\r\n      <td  align=center {$batas2w}>{$batas2} </td>\r\n      <td  {$propw}>Asal Propinsi # TBPRO</td>\r\n      <td  align=center {$propw}>{$prop} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$prop2w}>Asal Propinsi Kosong</td>\r\n      <td  align=center {$prop2w}>{$prop2} </td>\r\n      <td  {$angkatan2w}>Tahun Tgl Masuk # Tahun Angkatan</td>\r\n      <td  align=center {$angkatan2w}>{$angkatan2} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Tanggal Masuk Kosong</td>\r\n      <td  align=center  >0 </td>\r\n      <td  >Status Mahasiswa # TBKOD</td>\r\n      <td  align=center >0</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$statusw}>Status Mahasiswa Kosong</td>\r\n      <td  align=center {$statusw}>{$status} </td>\r\n      <td  {$tgllulusw}>Tgl.Lulus < Tgl.Masuk/Status # 'L'</td>\r\n      <td  align=center {$tgllulusw}>{$tgllulus} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$status2w}>Status Lulus 'L' Tgl Lulus Kosong</td>\r\n      <td  align=center {$status2w}>{$status2} </td>\r\n      <td   >Status Baru/Pindahan # TBKOD</td>\r\n      <td  align=center  >0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$status4w}>Status Baru/Pindahan kosong  </td>\r\n      <td  align=center {$status4w}>{$status4} </td>\r\n      <td  {$status5w}>Status Baru tetapi SKS > 0</td>\r\n      <td  align=center {$status5w}>{$status5} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$status6w}>Status Pindahan tetapi SKS kosong</td>\r\n      <td  align=center {$status6w}>{$status6} </td>\r\n      <td   >SKS Diakui > Total SKS Lulus</td>\r\n      <td  align=center  >? </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$pindahanptw}>Status Pindahan Asal P.T. kosong</td>\r\n      <td  align=center {$pindahanptw}>{$pindahanpt} </td>\r\n      <td  {$pindahanpsw}>Status Pindahan Asal P.S. kosong</td>\r\n      <td  align=center {$pindahanpsw}>{$pindahanps} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$pindahanpt2w}>Kode P.T. Pindahan # TBPTI</td>\r\n      <td  align=center {$pindahanpt2w}>{$pindahanpt2} </td>\r\n      <td  {$pindahanps2w}>Kode P.S. Pindahan # TBPST</td>\r\n      <td  align=center {$pindahanps2w}>{$pindahanps2} </td>\r\n    </tr>\r\n    ";
$i = 0;
while ( $i < 20 )
{
    $valid[$i] = 0;
    $valid2[$i] = "";
    ++$i;
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs        \r\n        WHERE \r\n          STPIDMSMHS='P' AND ASNIMMSMHS=''\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[0] = 1;
    $valid2[0] = $warnatidakvalid;
    $tmpdata .= "<p><b>Asal NIM Mhs Pindahan Kosong</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs  LEFT JOIN trpid ON \r\n        KDPTITRPID =KDPTIMSMHS AND\r\n        KDJENTRPID=KDJENMSMHS AND\r\n        KDPSTTRPID=KDPSTMSMHS AND\r\n        NIMHSTRPID=NIMHSMSMHS      \r\n        WHERE \r\n          STPIDMSMHS='P' AND (NMPTITRPID='' OR NMPTITRPID IS NULL )\r\n          AND\r\n          SMAWLMSMHS='{$tahun}{$semester}'\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[1] = 1;
    $valid2[1] = $warnatidakvalid;
    $tmpdata .= "<p><b>Nama Asal PT Pindahan Kosong</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs  LEFT JOIN trpid ON \r\n        KDPTITRPID =KDPTIMSMHS AND\r\n        KDJENTRPID=KDJENMSMHS AND\r\n        KDPSTTRPID=KDPSTMSMHS AND\r\n        NIMHSTRPID=NIMHSMSMHS      \r\n        WHERE \r\n          STPIDMSMHS='P' AND (NMPSTTRPID='' OR NMPSTTRPID IS NULL )\r\n          AND\r\n          SMAWLMSMHS='{$tahun}{$semester}'\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[2] = 1;
    $valid2[2] = $warnatidakvalid;
    $tmpdata .= "<p><b>Nama Asal PS Pindahan Kosong</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS  FROM msmhs        \r\n        WHERE \r\n          KDJENMSMHS='A' AND\r\n          (PEKSBMSMHS!='A' AND PEKSBMSMHS!='B' AND \r\n          PEKSBMSMHS!='C' AND PEKSBMSMHS!='D')\r\n          AND PEKSBMSMHS=''\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[3] = 1;
    $valid2[3] = $warnatidakvalid;
    $tmpdata .= "<p><b>Nama Pekerjaan Kosong</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,PTPEKMSMHS FROM msmhs  LEFT JOIN tbpti \r\n       ON PTPEKMSMHS=KDPTITBPTI      \r\n        WHERE \r\n          KDJENMSMHS='A' AND\r\n          (PEKSBMSMHS='A' OR PEKSBMSMHS='B' OR\r\n          PEKSBMSMHS='C' OR PEKSBMSMHS='D')\r\n          AND PTPEKMSMHS IS NULL\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[4] = 1;
    $valid2[4] = $warnatidakvalid;
    $tmpdata .= "<p><b>Kode PT Pekerjaan # TBPTI</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,PTPEKMSMHS FROM msmhs   \r\n       \r\n        WHERE \r\n          KDJENMSMHS='A' AND\r\n          (PEKSBMSMHS='A' OR PEKSBMSMHS='B' OR\r\n          PEKSBMSMHS='C' OR PEKSBMSMHS='D')\r\n          AND PTPEKMSMHS =''\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[5] = 1;
    $valid2[5] = $warnatidakvalid;
    $tmpdata .= "<p><b>Kerja di PT Kode PT Kosong</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,PTPEKMSMHS FROM msmhs  LEFT JOIN tbpst \r\n       ON PSPEKMSMHS=KDPSTTBPST      \r\n        WHERE \r\n          KDJENMSMHS='A' AND\r\n          (PEKSBMSMHS='A' OR PEKSBMSMHS='B' OR\r\n          PEKSBMSMHS='C' OR PEKSBMSMHS='D')\r\n          AND KDPSTTBPST IS NULL\r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[6] = 1;
    $valid2[6] = $warnatidakvalid;
    $tmpdata .= "<p><b>Kode PS Pekerjaan # TBPST</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOKP1MSMHS FROM msmhs   LEFT JOIN msdos\r\n       ON NOKP1MSMHS=NODOSMSDOS\r\n         WHERE \r\n          KDJENMSMHS='A'  \r\n          AND NOKP1MSMHS IS NULL \r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[8] = 1;
    $valid2[8] = $warnatidakvalid;
    $tmpdata .= "<p><b>Dosen Promotor # MSDOS</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOKP2MSMHS FROM msmhs   LEFT JOIN msdos\r\n       ON NOKP2MSMHS=NODOSMSDOS\r\n         WHERE \r\n          KDJENMSMHS='A'  \r\n          AND NOKP2MSMHS IS NULL \r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[9] = 1;
    $valid2[9] = $warnatidakvalid;
    $tmpdata .= "<p><b>Dosen Ko-Promotor#1 # MSDOS</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOKP3MSMHS FROM msmhs   LEFT JOIN msdos\r\n       ON NOKP3MSMHS=NODOSMSDOS\r\n         WHERE \r\n          KDJENMSMHS='A'  \r\n          AND NOKP3MSMHS IS NULL \r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[10] = 1;
    $valid2[10] = $warnatidakvalid;
    $tmpdata .= "<p><b>Dosen Ko-Promotor#2 # MSDOS</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOPRMMSMHS FROM msmhs   LEFT JOIN msdos\r\n       ON NOPRMMSMHS=NODOSMSDOS\r\n         WHERE \r\n          KDJENMSMHS='A'  \r\n          AND NODOSMSDOS IS NULL \r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[7] = 1;
    $valid2[7] = $warnatidakvalid;
    $tmpdata .= "<p><b>Dosen Ko-Promotor#3 # MSDOS</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOKP4MSMHS FROM msmhs   LEFT JOIN msdos\r\n       ON NOKP4MSMHS=NODOSMSDOS\r\n         WHERE \r\n          KDJENMSMHS='A'  \r\n          AND NOKP4MSMHS IS NULL \r\n        {$qf}";
$h2 = mysqli_query($koneksi,$q);
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[11] = 1;
    $valid2[11] = $warnatidakvalid;
    $tmpdata .= "<p><b>Dosen Ko-Promotor#4 # MSDOS</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,NOKP4MSMHS FROM msmhs    \r\n         WHERE TAHUNMSMHS!=SUBSTR(SMAWLMSMHS,1,4)\r\n         {$qf}\r\n         \r\n          ";
$h2 = mysqli_query($koneksi,$q);
echo mysql_error( );
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[12] = 1;
    $valid2[12] = $warnatidakvalid;
    $tmpdata .= "<p><b>Semester Masuk Tidak Sesuai</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,COUNT(NIMHSTRNLP) AS JML \r\n         FROM msmhs  LEFT JOIN trnlp   ON\r\n         NIMHSTRNLP=NIMHSMSMHS AND\r\n         KDPSTTRNLP=KDPSTMSMHS AND\r\n         KDJENTRNLP=KDJENMSMHS  \r\n         WHERE STPIDMSMHS='P' AND TAHUNMSMHS='{$tahun}'\r\n         \r\n         {$qf}\r\n         GROUP BY NIMHSMSMHS\r\n         HAVING JML <=0\r\n          \r\n          ";
$h2 = mysqli_query($koneksi,$q);
echo mysql_error( );
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[13] = 1;
    $valid2[13] = $warnatidakvalid;
    $tmpdata .= "<p><b>Status Pindahan tidak ada TRNLP</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,ASPSTMSMHS  FROM msmhs    \r\n        LEFT JOIN tbpst ON \r\n        msmhs.ASPSTMSMHS=tbpst.KDPSTTBPST\r\n        WHERE tbpst.KDPSTTBPST IS NULL AND\r\n        tbpst.KDJENTBPST IS NULL AND\r\n        msmhs.ASPSTMSMHS!=''  AND msmhs.ASPSTMSMHS!='00000' AND  \r\n        msmhs.ASJENMSMHS!=''  AND msmhs.ASJENMSMHS!='0'  \r\n        \r\n        AND KDPSTMSMHS ='{$kodeps}'\r\n        AND KDJENMSMHS='{$kodejenjang}'\r\n        AND KDPTIMSMHS='{$kodept}'   ";
$h2 = mysqli_query($koneksi,$q);
$pindahanps2 = sqlnumrows( $h2 );
if ( 0 < $pindahanps2 )
{
    $valid[14] = 1;
    $valid2[14] = $warnatidakvalid;
    $tmpdata .= "<p><b>Jenjang dan Prodi Pindahan # TBPST </b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']} - {$d2['NMMHSMSMHS']} ==> Kode P.S. Pindahan :  {$d2['ASPSTMSMHS']}-{$d2['ASJENMSMHS']}<br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS ,SKSDIMSMHS,SUM(SKSMKTBKMK) AS JML\r\n         FROM msmhs  LEFT JOIN trnlp   ON\r\n         NIMHSTRNLP=NIMHSMSMHS AND\r\n         KDPSTTRNLP=KDPSTMSMHS AND\r\n         KDJENTRNLP=KDJENMSMHS  \r\n         LEFT JOIN tbkmk ON\r\n         THSMSTBKMK=SMAWLMSMHS AND\r\n         KDJENTBKMK=KDJENMSMHS AND\r\n         KDPSTTBKMK=KDPSTMSMHS AND\r\n         KDKMKTBKMK=KDKMKTRNLP\r\n         WHERE STPIDMSMHS='P'\r\n         {$qf}\r\n         GROUP BY NIMHSMSMHS\r\n         HAVING SUM(SKSMKTBKMK) !=SKSDIMSMHS          \r\n          ";
$h2 = mysqli_query($koneksi,$q);
echo mysql_error( );
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[15] = 1;
    $valid2[15] = $warnatidakvalid;
    $tmpdata .= "<p><b>SKS diakui # data di TRNLP</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']} : DIAKUI = {$d2['SKSDIMSMHS']}, TRNLP = {$d2['JML']} <br>";
    }
    $tmpdata .= "</p>";
}
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS  \r\n         FROM msmhs  LEFT JOIN mspst   ON\r\n          KDPSTMSPST=KDPSTMSMHS AND\r\n         KDJENMSPST=KDJENMSMHS  \r\n         WHERE SUBSTRING(SMAWLMSMHS,1,4)>YEAR(TGLAKMSPST) \r\n         {$qf} \r\n         \r\n           ";
$h2 = mysqli_query($koneksi,$q);
echo mysql_error( );
$nim = sqlnumrows( $h2 );
if ( 0 < $nim )
{
    $valid[16] = 1;
    $valid2[16] = $warnatidakvalid;
    $tmpdata .= "<p><b>Sem. Awal Masuk > Tgl. Ijin SK</b><br>";
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        $tmpdata .= "{$d2['NIMHSMSMHS']}  - {$d2['NMMHSMSMHS']}  <br>";
    }
    $tmpdata .= "</p>";
}
echo "\r\n    <tr class=datagenap   >\r\n      <td   >Kelas Reg/NonReg/Kerjasama # RNK</td>\r\n      <td  align=center > 0 </td>\r\n      <td   >Asal Jenjang Pindahan # TBKOD</td>\r\n      <td  align=center  > 0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['0']}>Asal NIM Mhs Pindahan Kosong</td>\r\n      <td  align=center  {$valid2['0']}>  {$valid['0']} </td>\r\n      <td   {$valid2['1']}>Nama Asal PT Pindahan Kosong</td>\r\n      <td  align=center  {$valid2['1']}>  {$valid['1']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td    {$valid2['2']}>Nama Asal PS Pindahan Kosong</td>\r\n      <td  align=center  {$valid2['2']}>  {$valid['2']} </td>\r\n      <td   >Semester Masuk tidak sesuai</td>\r\n      <td  align=center  {$valid2['12']}>  {$valid['12']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   >Biaya Studi # TBKOD</td>\r\n      <td  align=center > 0 </td>\r\n      <td   >Kode Pekerjaan # TBKOD</td>\r\n      <td  align=center  > 0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['3']} >Nama Pekerjaan Kosong</td>\r\n      <td  align=center {$valid2['3']}>  {$valid['3']} </td>\r\n      <td {$valid2['4']}  >Kode PT Pekerjaan # TBPTI</td>\r\n      <td  align=center  {$valid2['4']}>  {$valid['4']}  </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$valid2['5']}  >Kerja di PT Kode PT Kosong</td>\r\n      <td  align=center {$valid2['5']}>  {$valid['5']} </td>\r\n      <td  {$valid2['6']} >Kode PS Pekerjaan # TBPST</td>\r\n      <td  align=center  {$valid2['6']}>  {$valid['6']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$valid2['7']}  >Dosen Promotor # MSDOS</td>\r\n      <td  align=center {$valid2['7']}>  {$valid['7']} </td>\r\n      <td {$valid2['8']}  >Dosen Ko-Promotor#1 # MSDOS</td>\r\n      <td  align=center  {$valid2['8']}>  {$valid['8']} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['9']} >Dosen Ko-Promotor#2 # MSDOS</td>\r\n      <td  align=center {$valid2['9']}>  {$valid['9']} </td>\r\n      <td  {$valid2['10']} >Dosen Ko-Promotor#3 # MSDOS</td>\r\n      <td  align=center  {$valid2['10']}>  {$valid['10']}</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['11']}>Dosen Ko-Promotor#4 # MSDOS</td>\r\n      <td  align=center {$valid2['11']}>  {$valid['11']}</td>\r\n      <td   > </td>\r\n      <td  align=center ></td>\r\n    </tr>\r\n\r\n\r\n    <tr class=datagenap   >\r\n      <td  {$valid2['9']} >Status Pindahan tidak ada TRNLP</td>\r\n      <td  align=center {$valid2['13']}>  {$valid['13']} </td>\r\n      <td  {$valid2['10']} >P.S. & Jen. Pindahan # TBPST</td>\r\n      <td  align=center  {$valid2['14']}>  {$valid['14']}</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td   {$valid2['11']}>SKS diakui # data di TRNLP</td>\r\n      <td  align=center {$valid2['15']}>  {$valid['15']}</td>\r\n      <td   >Sem.Awal Masuk > Tgl.Ijin SK </td>\r\n      <td  align=center {$valid2['16']}>  {$valid['16']}</td>\r\n    </tr>\r\n\r\n\r\n  </table>\r\n  \r\n  {$tmpdata}\r\n  ";
echo " \r\n \r\n";
?>
