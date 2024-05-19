<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Validasi Data Semester" );
$warnatidakvalid = "style='background-color:#ff0000;color:#FFFF00;'";
if ( $aksi == "Validasi Data!" )
{
    if ( 0 )
    {
        $errmesg = token_err_mesg( "Validasi Data Semester", CARI_DATA );
    }
    else
    {
        $vld[] = cekvaliditasthnajaran( "Semester/Tahun", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
        $vld[] = cekvaliditaskode( "MSYYS,MSPTI,MSPST, TRFAS,TRKAP,TRPIM", $pilihtabel[0], 1 );
        $vld[] = cekvaliditaskode( "MSMHS (Master Data Mahasiswa)", $pilihtabel[1], 1 );
        $vld[] = cekvaliditaskode( "MSDOS (Master Data Dosen)", $pilihtabel[2], 1 );
        $vld[] = cekvaliditaskode( "TRAKM (Transaksi Aktifitas Kuliah Mahasiswa)", $pilihtabel[3], 1 );
        $vld[] = cekvaliditaskode( "TRNLM (Transaksi Nilai Mahasiswa, KRS)", $pilihtabel[9], 1 );
        $vld[] = cekvaliditaskode( "TRAKD (Transaksi Mengajar Dosen)", $pilihtabel[4], 1 );
        $vld[] = cekvaliditaskode( "TRPUD (Publikasi Penelitian Dosen)", $pilihtabel[5], 1 );
        $vld[] = cekvaliditaskode( "TBKMK (Mata Kuliah/Kurikulum)", $pilihtabel[6], 1 );
        $vld[] = cekvaliditaskode( "TRLSM (Transaksi Cuti/Lulus/Berhenti/DO Mahasiswa)", $pilihtabel[7], 1 );
        $vld[] = cekvaliditaskode( "TRLSD (Transaksi Keluar/Cuti/Studi Dosen)", $pilihtabel[8], 1 );
        $vld[] = cekvaliditaskode( "TRNLP (Transaksi Nilai Pindahan Mahasiswa)", $pilihtabel[10], 1 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
            unset( $vld );
        }
        else
        {
            $q = "SELECT KDYYSMSYYS ,NMYYSMSYYS  FROM msyys LIMIT 0,1";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $kodebh = $d[KDYYSMSYYS];
                $namabh = $d[NMYYSMSYYS];
            }
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $kodept = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            echo "\r\n  <table class=form>\r\n     <tr>\r\n      <td width=150>Tahun Semester</td>\r\n      <td><b><b>{$tahun}/".( $tahun + 1 )." ".$arraysemester[$semester]."</td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Badan Hukum</td>\r\n      <td><b><b>{$kodebh} - {$namabh}</td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Perguruan Tinggi</td>\r\n      <td><b>{$kodept} - ".getfield( "NMPTIMSPTI", "mspti", " WHERE KDPTIMSPTI='{$kodept}'" )."</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Program Studi</td>\r\n      <td><b>{$kodeps} - ".getfield( "NMPSTMSPST", "mspst", " WHERE KDPSTMSPST='{$kodeps}'" )."</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Jenjang</td>\r\n      <td><b>{$kodejenjang} - ".$arrayjenjang[$kodejenjang]."</td>\r\n    </tr>\r\n  </table>\r\n  <hr>\r\n  <ul>\r\n  <li>Catatan : Data VALID bila kolom Validitas terisi 0 (nol), kecuali pada baris Jumlah Record\r\nyang menyatakan jumlah record pada Tabel ybs. \r\n</li>\r\n<li>\r\n  Warna MERAH menyatakan data TIDAK VALID\r\n</li>\r\n</ul>\r\n  ";
            if ( $pilihtabel[0] == 1 )
            {
                if ( $semester == 1 )
                {
                    $semester2 = 2;
                    $tahun2 = $tahun;
                }
                else if ( $semester == 2 )
                {
                    $semester2 = 1;
                    $tahun2 = $tahun + 1;
                }
                include( "prosesvalidbh.php" );
                include( "prosesvalidpt.php" );
                include( "prosesvalidps.php" );
                include( "prosesvalidtrfas.php" );
                include( "prosesvalidkap.php" );
                include( "prosesvalidtrpim.php" );
            }
            if ( $pilihtabel[1] == 1 )
            {
                include( "prosesvalidmhs.php" );
            }
            if ( $pilihtabel[2] == 1 )
            {
                include( "prosesvaliddos.php" );
            }
            if ( $pilihtabel[3] == 1 )
            {
                include( "prosesvalidtrakm.php" );
            }
            if ( $pilihtabel[9] == 1 )
            {
                include( "prosesvalidtrnlm.php" );
                if ( $semester == 1 )
                {
                    $semester2 = 2;
                    $tahun2 = $tahun;
                }
                else if ( $semester == 2 )
                {
                    $semester2 = 1;
                    $tahun2 = $tahun + 1;
                }
                include( "prosesvalidtrnlm2.php" );
            }
            if ( $pilihtabel[4] == 1 )
            {
                include( "prosesvalidtrakd.php" );
            }
            if ( $pilihtabel[5] == 1 )
            {
                include( "prosesvalidtrpud.php" );
            }
            if ( $pilihtabel[6] == 1 )
            {
                include( "prosesvalidtbkmk.php" );
                $tahunx = $tahun;
                $semesterx = $semester;
                if ( $semester == 1 )
                {
                    $semester = 2;
                    $tahun = $tahun;
                }
                else if ( $semester == 2 )
                {
                    $semester = 1;
                    $tahun = $tahun + 1;
                }
                include( "prosesvalidtbkmk.php" );
                $tahun = $tahunx;
                $semester = $semesterx;
            }
            if ( $pilihtabel[7] == 1 )
            {
                include( "prosesvalidtrlsm.php" );
            }
            if ( $pilihtabel[8] == 1 )
            {
                include( "prosesvalidtrlsd.php" );
            }
            if ( $pilihtabel[10] == 1 )
            {
                include( "prosesvalidtrnlp.php" );
            }
            if ( $semester == 1 )
            {
                $semester2 = 2;
                $tahun2 = $tahun;
            }
            else if ( $semester == 2 )
            {
                $semester2 = 1;
                $tahun2 = $tahun + 1;
            }
            include( "prosesvalidakm.php" );
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi == "" )
{
    echo "\r\n<form action=index.php method=post onSubmit='return confirm(\"Validasi data?\")' >\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n  ".IKONTOOLS48."\r\n    <table>\r\n\t\t<tr>\r\n        <td>Semester/Tahun</td>\r\n        <td>\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>";
    $waktu = getdate( );
    if ( $tahun == "" )
    {
        $tahun = $waktu[year];
    }
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $tahun )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select> \r\n\r\n            \r\n        </td>\r\n      </tr>\r\n  \r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n      <tr>\r\n        <td colspan=2>\r\n          <hr>\r\n        </td>\r\n      </tr>  \r\n      <tr>\r\n        <td>Tabel yang divalidasi</td>\r\n         <td>\r\n         <input type=checkbox name='pilihtabel[0]' value='1'>MSYYS,MSPTI,MSPST, TRFAS,TRKAP,TRPIM<br> \r\n         <input type=checkbox name='pilihtabel[1]' value='1'>MSMHS (Master Data Mahasiswa)<br> \r\n        <!-- <input type=checkbox name='pilihtabel[2]' value='1'>MSDOS (Master Data Dosen)<br> --> \r\n         <input type=checkbox name='pilihtabel[3]' value='1'>TRAKM (Transaksi Aktifitas Kuliah Mahasiswa)<br> \r\n         <input type=checkbox name='pilihtabel[9]' value='1'>TRNLM (Transaksi Nilai Mahasiswa, KRS)<br> \r\n         <input type=checkbox name='pilihtabel[4]' value='1'>TRAKD (Transaksi Mengajar Dosen)<br> \r\n         <input type=checkbox name='pilihtabel[5]' value='1'>TRPUD (Publikasi Penelitian Dosen)<br> \r\n         <input type=checkbox name='pilihtabel[6]' value='1'>TBKMK (Mata Kuliah/Kurikulum)<br> \r\n         <input type=checkbox name='pilihtabel[7]' value='1'>TRLSM (Transaksi Cuti/Lulus/Berhenti/DO Mahasiswa)<br> \r\n         <input type=checkbox name='pilihtabel[8]' value='1'>TRLSD (Transaksi Keluar/Cuti/Studi Dosen)<br> \r\n         <input type=checkbox name='pilihtabel[10]' value='1'>TRNLP (Transaksi Nilai Pindahan Mahasiswa)<br> \r\n         <input type=checkbox name='pilihtabel[11]' value='1'>Verifikasi AKM-NLM-KRS-LSM<br> \r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td></td>\r\n         <td>\r\n         <input type=submit name=aksi value='Validasi Data!'> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n";
}
?>
