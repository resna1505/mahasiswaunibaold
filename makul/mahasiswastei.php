<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "updatemk" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $aksi4 == "Ambil" )
    {
        if ( $pilihkelas != "" )
        {
            $tmp = explode( "_", $pilihkelas );
            $kelasmakul = $tmp[0];
            $jeniskelas = $tmp[1];
            $jammulai = $tmp[2];
            $jamselesai = $tmp[3];
            $biaya = $tmp[4];
            $q = "SELECT syaratpengambilanmk.*  \r\n          FROM syaratpengambilanmk  \r\n          WHERE\r\n          syaratpengambilanmk.IDMAKUL='{$idmakul}' AND\r\n          syaratpengambilanmk.TAHUN='{$data['tahun']}'\r\n          AND syaratpengambilanmk.SEMESTER='{$data['semester']}'\r\n           \r\n           ";
            $hss = mysqli_query($koneksi,$q);
            $daftarsyarat = "";
            $syaratok = 1;
            $jmlsyarat = sqlnumrows( $hss );
            $totalsyarat = 0;
            if ( 0 < sqlnumrows( $hss ) )
            {
                $syaratok = 0;
                while ( $dss = sqlfetcharray( $hss ) )
                {
                    $q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \r\n              FROM pengambilanmk  \r\n              WHERE\r\n              pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\r\n               IDMAHASISWA='{$idmahasiswa}'\r\n              AND BOBOT >= {$dss['BOBOT']}\r\n               ";
                    $hss2 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hss2 ) )
                    {
                        ++$totalsyarat;
                    }
                    $logicsyarat = $dss[LOGIC];
                }
            }
            if ( ( $jmlsyarat <= $totalsyarat && $logicsyarat == "AND" || 0 < $totalsyarat && $logicsyarat == "OR" ) && 0 < $jmlsyarat )
            {
                $syaratok = 1;
            }
            if ( $syaratok != 1 )
            {
                $errmesg = "\r\n             TIDAK MEMENUHI SYARAT!!! PERGI JAUH2!!\r\n             ";
            }
            else if ( $syaratok == 1 )
            {
                $q = "SELECT KELAS FROM jadwalkuliahkurikulum \r\n           WHERE\r\n          IDPRODI='{$idprodi}' AND\r\n          IDMAKUL='{$idmakul}' AND\r\n          KELAS='{$kelasmakul}' AND\r\n          JAM='{$jammulai}' AND\r\n          TAHUN='{$data['tahun']}' AND\r\n          SEMESTER='{$data['semester']}' AND\r\n          TERISI < KUOTA\r\n          ";
                $h = mysqli_query($koneksi,$q);
                if ( sqlnumrows( $h ) <= 0 )
                {
                    $errmesg = "Maaf, kuota telah penuh. Proses pengambilan Mata Kuliah tidak berhasil dilakukan.";
                }
                else
                {
                    $q = "INSERT INTO  pengambilanmk \r\n    \t\t\t\t(IDMAHASISWA,IDMAKUL,TAHUN,KELAS,SEMESTER,SEMESTERMAKUL,SKSMAKUL,NAMA,\r\n            JENISKELAS,JAM,BIAYA,JENIS,THNSM\r\n            ) \r\n    \t\t\t\tVALUES('{$idmahasiswa}','{$idmakul}','{$data['tahun']}','{$kelasmakul}',{$data['semester']},\r\n    \t\t\t\t'{$semestermakul}','{$sksmakul}','{$namamakul}',\r\n            '{$jeniskelas}','{$jammulai} - {$jamselesai}','{$biaya}','".$_SESSION['jeniskrs']."','".( $data[tahun] - 1 )."{$data['semester']}')\r\n    \t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $q = "UPDATE jadwalkuliahkurikulum \r\n              SET TERISI=TERISI+1 \r\n              WHERE\r\n              IDPRODI='{$idprodi}' AND\r\n              IDMAKUL='{$idmakul}' AND\r\n              KELAS='{$kelasmakul}' AND\r\n              JAM='{$jammulai}' AND\r\n              TAHUN='{$data['tahun']}' AND\r\n              SEMESTER='{$data['semester']}' AND\r\n              TERISI < KUOTA\r\n              ";
                        mysqli_query($koneksi,$q);
                        $errmesg = "Data Mata Kuliah {$idmakul} {$namamakul} berhasil diambil";
                        $q = "INSERT INTO pakaideposit \r\n              (ID,IDMAHASISWA,TANGGAL,JUMLAH,KET,UPDATER,LASTUPDATE)\r\n              VALUES \r\n              ('{$idmahasiswa}-{$idmakul}-{$data['tahun']}-{$data['semester']}','{$idmahasiswa}',NOW(),'{$biaya}',\r\n              'Ambil makul {$idmakul},{$data['tahun']}-{$data['semester']},kelas {$kelasmakul} ".$arraykelasstei[$jeniskelas]."',\r\n              '{$users}',NOW())";
                        mysqli_query($koneksi,$q);
                        $sem = $data[semester];
                        $tahunlama = $data[tahun];
                        include( "edittrakm.php" );
                    }
                    else
                    {
                        $errmesg = "Data Mata Kuliah {$idmakul} {$namamakul} tidak berhasil diambil";
                    }
                }
            }
        }
        unset( $tmp );
    }
    if ( $aksi4 == "Batal" )
    {
        $q = "DELETE FROM pengambilanmk \r\n\t\t  \tWHERE\r\n\t\t\t\tIDMAHASISWA='{$idmahasiswa}' AND\r\n        IDMAKUL='{$idmakul}' AND\r\n        TAHUN='{$data['tahun']}' AND\r\n        SEMESTER='{$data['semester']}'\r\n        \r\n \t\t\t\t";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $q = "UPDATE jadwalkuliahkurikulum \r\n          SET TERISI=TERISI-1 \r\n          WHERE\r\n          IDPRODI='{$idprodi}' AND\r\n          IDMAKUL='{$idmakul}' AND\r\n          KELAS='{$kelasmakul}' AND\r\n          JAM='{$jammulai}' AND\r\n          TAHUN='{$data['tahun']}' AND\r\n          SEMESTER='{$data['semester']}' AND\r\n          TERISI > 0\r\n          ";
            mysqli_query($koneksi,$q);
            $errmesg = "Data Pengambilan Mata Kuliah {$idmakul} {$namamakul} telah dihapus";
            if ( $_SESSION['jeniskrs'] == 0 )
            {
                $q = "DELETE FROM pakaideposit WHERE\r\n            ID='{$idmahasiswa}-{$idmakul}-{$data['tahun']}-{$data['semester']}'";
                mysqli_query($koneksi,$q);
            }
            else if ( $_SESSION['jeniskrs'] == 1 )
            {
                if ( $idsaatpengambilan == 0 )
                {
                    $q = "UPDATE pakaideposit SET \r\n              JUMLAH=JUMLAH*(1-{$PEMBATALANMAKUL}) ,\r\n              KET=CONCAT(KET,'\nPembatalan KRS.'),\r\n              ID='{$idmahasiswa}-{$idmakul}-{$data['tahun']}-{$data['semester']}-PKRS'\r\n              WHERE\r\n              ID='{$idmahasiswa}-{$idmakul}-{$data['tahun']}-{$data['semester']}'";
                    mysqli_query($koneksi,$q);
                }
                else if ( $idsaatpengambilan == 1 )
                {
                    $q = "DELETE FROM pakaideposit WHERE\r\n                ID='{$idmahasiswa}-{$idmakul}-{$data['tahun']}-{$data['semester']}'";
                    mysqli_query($koneksi,$q);
                }
            }
            $q = "SELECT IDMAHASISWA FROM pengambilanmk \r\n          WHERE \r\n          IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $q = "delete FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' \r\n            AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'";
                mysqli_query($koneksi,$q);
            }
        }
        else
        {
            $errmesg = "Data Mata Kuliah {$idmakul} {$namamakul} tidak berhasil dihapus";
        }
        unset( $tmp );
    }
    $aksi = "tampiledit";
}
if ( $aksi == "tampiledit" )
{
    $tmpcetak = "";
    cekhaktulis( $kodemenu );
    if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
    {
        $errmesg = "NIM harus diisi atau tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
        $aksi = "tambahawal";
    }
    else if ( !ismahasiswaaktif( $idmahasiswa ) )
    {
        $errmesg = "Data tidak dapat diproses karena mahasiswa dengan ID '{$idmahasiswa}' DO/Lulus/Cuti";
        $aksi = "tambahawal";
    }
    else
    {
        if ( trim( $data[semester] ) == "" || !isintegerpositif( $data[semester] ) )
        {
            $errmesg = "Semester Mata Kuliah harus diisi dengan angka > 0";
            $aksi = "tambahawal";
        }
        else
        {
            if ( $prodis != "" )
            {
                $qfilter = " AND mahasiswa.IDPRODI='{$prodis}' ";
            }
            $q = "\r\n\t\t\tSELECT mahasiswa.NAMA,ANGKATAN,IDPRODI,KELAS AS KELASDEFAULT,\r\n      KDPSTMSMHS,KDJENMSMHS ,GELOMBANG\r\n\t\t\t\r\n\t\t\tFROM  mahasiswa,msmhs\r\n\t\t\tWHERE\r\n\t\t\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\t\t  mahasiswa.ID='{$idmahasiswa}'\r\n\t\t  {$qfilter}\r\n \t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $errmesg = "Data Mahasiswa / Data Dosen Wali Tidak Ada";
                $aksi = "tambahawal";
            }
            else
            {
                $d = sqlfetcharray( $h );
                if ( $data[semester] != 3 )
                {
                    $semesterx = "".( ( $data[tahun] - 1 - $d[ANGKATAN] ) * 2 + $data[semester] )."";
                    $kurawal = "(";
                    $kurtutup = ")";
                }
                if ( $data[semester] != 3 && $semesterx <= 0 )
                {
                    $errmesg = "Tahun Akademik salah. Mahasiswa ybs belum masuk pada tahun ajaran yang dipilih.";
                    $aksi = "tambahawal";
                }
                else
                {
                    printjudulmenu( "EDIT KRS MAHASISWA" );
                    printmesg( $errmesg );
                    $angkatanx = $d[ANGKATAN];
                    $q = "SELECT sksmaksimum.* \r\n            FROM sksmaksimum ,mahasiswa\r\n            WHERE \r\n            mahasiswa.IDPRODI=sksmaksimum.IDPRODI\r\n              AND mahasiswa.ID='{$idmahasiswa}'\r\n            ";
                    $hs = mysqli_query($koneksi,$q);
                    $jenisip = 0;
                    if ( 0 < sqlnumrows( $hs ) )
                    {
                        $ds = sqlfetcharray( $hs );
                        $sksmaksimum = $ds[SKS];
                        $semesteracuan = $ds[SEMESTER];
                        $jenisip = $ds[JENISIP] + 0;
                    }
                    $thnlalu = $data[tahun] - 1;
                    $semlalu = $data[semester];
                    if ( 0 < $semesteracuan )
                    {
                        if ( $semlalu % 2 == 0 )
                        {
                            $thnlalu = $thnlalu - floor( $semesteracuan / 2 );
                            if ( $semesteracuan % 2 == 0 )
                            {
                                $semlalu = 2;
                            }
                            else
                            {
                                $semlalu = 1;
                            }
                        }
                        else
                        {
                            $thnlalu = $thnlalu - ceil( $semesteracuan / 2 );
                            if ( $semesteracuan % 2 == 0 )
                            {
                                $semlalu = 1;
                            }
                            else
                            {
                                $semlalu = 2;
                            }
                        }
                    }
                    if ( $data[semester] == 2 )
                    {
                        $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
                    }
                    else
                    {
                        $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
                    }
                    if ( $jenisip == 0 )
                    {
                        $qtrakm = " NLIPSTRAKM AS ";
                        $jtrakm = " Semester (IPS) ";
                    }
                    else
                    {
                        $qtrakm = " NLIPKTRAKM AS ";
                        $jtrakm = " Kumulatif (IPK) ";
                    }
                    $q = "\r\n    \t\t\tSELECT {$qtrakm} NLIPSTRAKM\r\n    \t\t\tFROM  trakm\r\n    \t\t\tWHERE\r\n    \t\t  NIMHSTRAKM='{$idmahasiswa}' AND\r\n    \t\t  THSMSTRAKM<='{$thnlalu}{$semlalu}'\r\n    \t\t  ORDER BY THSMSTRAKM DESC LIMIT 0,1\r\n    \t\t  \r\n     \t\t";
                    $hip = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hip ) )
                    {
                        $dip = sqlfetcharray( $hip );
                        $ips = $dip[NLIPSTRAKM];
                    }
                    else
                    {
                        $ips = "Tidak ada";
                    }
                    $semesterkrs = $semesterx;
                    $tmpcetak .= "\r\n\t\t\t\t<br>\r\n\t\t\t\t<table width=100%>\r\n\t\t\t\t<tr>\r\n\t\t\t\t  <td width=50%>\r\n\t\t\t\t<table class=form width=100%>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t\t\t\t<td > {$semesterx} {$kurawal} ".$arraysemester[$data[semester]]." {$kurtutup} </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td ><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t<td >Jenis Pengambilan</td>\r\n\t\t\t\t\t\t";
                    if ( !session_is_registered_sikad( "jeniskrs" ) )
                    {
                        session_register_sikad( "jeniskrs" );
                    }
                    if ( $_SESSION['jeniskrs'] != $jeniskrs && $jeniskrs != "" )
                    {
                        $_SESSION['jeniskrs'] = $jeniskrs;
                    }
                    $tmpcetak .= "\r\n\t\t\t\t\t\t<td ><b>".$arrayjeniskrs[$_SESSION['jeniskrs']]." </b><br>\r\n            Ket: untuk Perbaikan KRS, <br>\r\n            Biaya Pengambilan Makul = ".$PENGAMBILANMAKUL * 100." % * Harga normal <br>\r\n            Biaya Pembatalan Makul = ".( 1 - $PEMBATALANMAKUL ) * 100." % * Harga normal <br>\r\n            </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t</td><td width=50%>\r\n\t\t\t\t\t<table class=form width=100%>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Angkatan</td>\r\n\t\t\t\t\t\t<td >{$d['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Gelombang Masuk</td>\r\n\t\t\t\t\t\t<td >{$d['GELOMBANG']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >IP {$jtrakm} ";
                    if ( 0 < $semesteracuan )
                    {
                        $tmpcetak .= "{$semesteracuan} Semester Lalu";
                    }
                    else
                    {
                        $tmpcetak .= "semester ini";
                    }
                    $sisadeposit = get_deposit_mahasiswa( $idmahasiswa );
                    $tmpcetak .= "</td>\r\n\t\t\t\t\t\t<td ><b>{$ips}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Sisa Deposit </td>\r\n\t\t\t\t\t\t<td ><b style='font-size:14pt;'>Rp. ".cetakuang( $sisadeposit )."</b></td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t</table>\r\n        </tr>\r\n        </table>\r\n        <br><br>\r\n\t\t\t";
                    $idprodimhs = $d[IDPRODI];
                    $kodeprodi = $d[KDPSTMSMHS];
                    $kodejenjang = $d[KDJENMSMHS];
                    $q = "SELECT * FROM syaratkrs WHERE IDPRODI='{$idprodimhs}' ORDER BY SKS DESC";
                    $hkrs = mysqli_query($koneksi,$q);
                    while ( !( 0 < sqlnumrows( $hkrs ) ) || !( $dkrs = sqlfetcharray( $hkrs ) ) )
                    {
                        $arraysyaratkrs["{$dkrs['SKS']}"] = "{$dkrs['IPS']}";
                    }
                    if ( $idprodi == "" )
                    {
                        $idprodi = $d[IDPRODI];
                    }
                    $tmpcetak .= "\r\n\t\t<form  action=index.php method=post>\r\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "{$aksi}", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\r\n\t\t</form>";
                    $tmpcetak .= "\r\n        \t\t\t\t<form action=cetakkrs.php method=post target=_blank>\r\n\t\t\t\t  <input type=hidden name=idmahasiswaupdate value='{$idmahasiswa}'>\r\n\t\t\t\t  <input type=hidden name=tahunupdate value='{$data['tahun']}'>\r\n          <input type=hidden name=semesterupdate value='{$data['semester']}'>\r\n          <input type=submit value='Cetak KRS'>\r\n\t\t\t\t</form>\t\t\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" );
                    $tmpcetak .= "\r\n\t\t\t\r\n<!--\t\t\t\r\n\t\t<table width=100%>\r\n\t\t<tr valign=top>\r\n    -->\r\n    ";
                    if ( $aksiproseskrs == "proseskrs" )
                    {
                        $q = "SELECT * FROM biayasks WHERE\r\n  ANGKATAN='{$d['ANGKATAN']}' AND\r\n  GELOMBANG='{$d['GELOMBANG']}' AND\r\n  PRODI='{$idprodi}' AND \r\n  TAHUN='{$data['tahun']}' \r\n  ";
                        $hb = mysqli_query($koneksi,$q);
                        while ( !( 0 < sqlnumrows( $hb ) ) || !( $db = sqlfetcharray( $hb ) ) )
                        {
                            $databiayasks["{$db['KELAS']}"] = $db[BIAYA];
                        }
                        $q = "SELECT makul.ID,tbkmk.NAKMKTBKMK  NAMA  ,THSMSTBKMK,\r\n      tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER\r\n\t\tFROM makul,tbkmk\r\n\t\tWHERE\r\n\t\t  makul.ID=tbkmk.KDKMKTBKMK AND\r\n\t\t  tbkmk.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\r\n\t\t  tbkmk.STKMKTBKMK='A' AND\r\n\t\t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' )) AND\r\n\t\t\t\tKDKMKTBKMK='{$idmakul}'\r\n\t\t\tORDER BY SEMESTER,ID\r\n\t\t";
                        $hp = mysqli_query($koneksi,$q);
                        if ( sqlnumrows( $hp ) <= 0 )
                        {
                            printmesg( "Data Mata Kuliah Jurusan / Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
                        }
                        else
                        {
                            $dp = sqlfetcharray( $hp );
                            $q = "SELECT syaratpengambilanmk.*  \r\n        FROM syaratpengambilanmk  \r\n        WHERE\r\n        syaratpengambilanmk.IDMAKUL='{$dp['ID']}' AND\r\n        syaratpengambilanmk.TAHUN='{$data['tahun']}'\r\n        AND syaratpengambilanmk.SEMESTER='{$data['semester']}'\r\n         \r\n         ";
                            $hss = mysqli_query($koneksi,$q);
                            $daftarsyarat = "";
                            $syaratok = 1;
                            $jmlsyarat = sqlnumrows( $hss );
                            $totalsyarat = 0;
                            if ( 0 < sqlnumrows( $hss ) )
                            {
                                $syaratok = 0;
                                while ( $dss = sqlfetcharray( $hss ) )
                                {
                                    $q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \r\n            FROM pengambilanmk  \r\n            WHERE\r\n            pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\r\n             IDMAHASISWA='{$idmahasiswa}'\r\n            AND BOBOT >= {$dss['BOBOT']} AND SIMBOL!='MD'\r\n             ";
                                    $hss2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $hss2 ) )
                                    {
                                        ++$totalsyarat;
                                    }
                                    $logicsyarat = $dss[LOGIC];
                                }
                            }
                            if ( ( $jmlsyarat <= $totalsyarat && $logicsyarat == "AND" || 0 < $totalsyarat && $logicsyarat == "OR" ) && 0 < $jmlsyarat )
                            {
                                $syaratok = 1;
                            }
                            if ( $syaratok != 1 )
                            {
                                $tmpcetak .= "\r\n          <!-- <td width=50%> -->\r\n          TIDAK MEMENUHI SYARAT!!! PERGI JAUH2!!\r\n          <!-- </td> -->\r\n          ";
                            }
                            else
                            {
                                if ( $syaratok == 1 )
                                {
                                    $tmpcetak .= "\r\n      ".createinputhidden( "idmakul", "{$idmakul}", "" )."\r\n      ".createinputhidden( "namamakul", "{$dp['NAMA']}", "" )."\r\n      ".createinputhidden( "sksmakul", "{$dp['SKS']}", "" )."\r\n      ".createinputhidden( "semestermakul", "{$dp['SEMESTER']}", "" )."\r\n      <!-- <td width=50%> -->\r\n\t\t<b>Proses Pengambilan Mata Kuliah</b><br> \r\n    <table clas=form width=100% border=0>\r\n      <tr>\r\n        <td  width=200>Kode Mata Kuliah</td>\r\n        <td nowrap>: <b>{$idmakul}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Nama Mata Kuliah</td>\r\n        <td nowrap>: <b>{$dp['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Jumlah SKS</td>\r\n        <td nowrap>: <b>{$dp['SKS']}</td>\r\n      </tr>\r\n";
                                    $q = "SELECT IDMAHASISWA,KELAS,JAM,JENIS FROM pengambilanmk \r\n          WHERE \r\n          IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'\r\n          AND IDMAKUL='{$idmakul}'\r\n          ";
                                    $hst = mysqli_query($koneksi,$q);
                                    $statuspengambilan = 0;
                                    if ( 0 < sqlnumrows( $hst ) )
                                    {
                                        $statuspengambilan = 1;
                                        $dst = sqlfetcharray( $hst );
                                    }
                                    $saatpengambilan = "-";
                                    $idsaatpengambilan = 0 - 1;
                                    if ( $dst[JENIS] != "" )
                                    {
                                        $saatpengambilan = $arrayjeniskrs[$dst[JENIS]];
                                        $idsaatpengambilan = $dst[JENIS];
                                    }
                                    $tmpcetak .= "\r\n      <tr>\r\n        <td>Saat Pengambilan</td>\r\n        <td nowrap>: <b>".$saatpengambilan."</td>\r\n      </tr>\r\n      </table>\r\n    <table clas=form width=100% border=0>\r\n       <tr>\r\n        <td colspan=2>\r\n        <br>\r\n        <b>Jadwal Kuliah Pilihan</b>";
                                    $q = "SELECT jadwalkuliahkurikulum.* ,(KUOTA-TERISI) SISAKUOTA\r\n      from jadwalkuliahkurikulum \r\n      WHERE \r\n      IDMAKUL='{$idmakul}' AND \r\n      IDPRODI='{$idprodi}' AND \r\n      TAHUN='{$data['tahun']}' AND \r\n      SEMESTER='{$data['semester']}' \r\n      ORDER BY KELAS,JAM";
                                    $hjadwal = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $hjadwal ) )
                                    {
                                        $tmpcetak .= "\r\n            <table width=100% >\r\n              <tr class=juduldata align=center>\r\n                <td>Kelas</td>\r\n                <td>Jenis Kelas</td>\r\n                <td>Jam Kuliah</td>\r\n                <td>Hari</td>\r\n                <td>Ruangan</td>\r\n                <td>Dosen</td>\r\n                <td>Biaya per SKS</td>\r\n                <td>Total Biaya </td>\r\n                ";
                                        if ( $_SESSION['jeniskrs'] == 1 )
                                        {
                                            $tmpcetak .= "\r\n                    <td>PKRS</td>\r\n                  ";
                                        }
                                        $tmpcetak .= "\r\n                <td>Kuota</td>\r\n                <td>Sisa Kuota </td>\r\n                <td>Pilih</td>\r\n              </tr>\r\n          ";
                                        $jmlpilih = 0;
                                        while ( $djadwal = sqlfetcharray( $hjadwal ) )
                                        {
                                            $warnakelas = "";
                                            if ( $dst[KELAS] == "{$djadwal['KELAS']}" && $dst[JAM] == "{$djadwal['JAM']} - {$djadwal['JAMSELESAI']}" )
                                            {
                                                $warnakelas = "style='background-color:#AAFFAA;'";
                                                $tmpcetak .= "      \r\n              ".createinputhidden( "kelasmakul", "{$djadwal['KELAS']}", "" ).createinputhidden( "jammulai", "{$djadwal['JAM']}", "" )."";
                                            }
                                            $tmpcetak .= "\r\n              <tr class=datagenap {$warnakelas}>\r\n                <td align=center>\r\n                  {$djadwal['KELAS']}\r\n                </td>\r\n                <td>\r\n                  ".$arraykelasstei[$djadwal[JENISKELAS]]."\r\n                </td>\r\n                <td align=center >  \r\n                   {$djadwal['JAM']} - {$djadwal['JAMSELESAI']}\r\n                </td>\r\n                <td align=center >  \r\n                   {$djadwal['HARI']}\r\n                </td>\r\n                <td align=center >  \r\n                   {$djadwal['RUANGAN']}\r\n                </td>\r\n                <td align=center >  \r\n                   {$djadwal['DOSEN']}\r\n                </td>\r\n                <td align=right>  \r\n                  ".cetakuang( $databiayasks["{$djadwal['JENISKELAS']}"] )."\r\n                 </td>\r\n                <td align=right>  <b>\r\n                  ".cetakuang( $databiayasks["{$djadwal['JENISKELAS']}"] * $dp[SKS] )."\r\n                 </td>                ";
                                            $totalbiayakrs = $databiayasks["{$djadwal['JENISKELAS']}"] * $dp[SKS];
                                            if ( $_SESSION['jeniskrs'] == 1 )
                                            {
                                                $tmpcetak .= "\r\n                <td align=right>  <b>\r\n                  ".cetakuang( $PENGAMBILANMAKUL * $databiayasks["{$djadwal['JENISKELAS']}"] * $dp[SKS] )."\r\n                 </td>                  ";
                                                $totalbiayakrs = $PENGAMBILANMAKUL * $databiayasks["{$djadwal['JENISKELAS']}"] * $dp[SKS];
                                            }
                                            $tmpcetak .= "\r\n\r\n                <td align=center>{$djadwal['KUOTA']}</td>\r\n                <td align=center>{$djadwal['SISAKUOTA']}</td>\r\n                 \r\n                 <td align=center>";
                                            if ( $totalbiayakrs <= $sisadeposit && 0 < $djadwal[SISAKUOTA] && $statuspengambilan == 0 )
                                            {
                                                $tmpcetak .= "\r\n                   <input type=radio name='pilihkelas' value='{$djadwal['KELAS']}_{$djadwal['JENISKELAS']}_{$djadwal['JAM']}_{$djadwal['JAMSELESAI']}_".$totalbiayakrs."' checked>";
                                                ++$jmlpilih;
                                            }
                                            else if ( $statuspengambilan == 1 )
                                            {
                                                $tmpcetak .= "-";
                                            }
                                            else
                                            {
                                                $tmpcetak .= "Deposit tidak cukup/kuota habis";
                                            }
                                            $tmpcetak .= " \r\n                   <input type=hidden name=idsaatpengambilan value='{$idsaatpengambilan}'>\r\n                 </td>\r\n              </tr>\r\n              \r\n            ";
                                        }
                                        $tmpcetak .= "</table>";
                                    }
                                    $tmpcetak .= "\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n      <td align=right colspan=2>";
                                    if ( $statuspengambilan == 0 && 0 < $jmlpilih )
                                    {
                                        $tmpcetak .= "\r\n        <input type=submit name=aksi4 value='Ambil' onClick=\"return confirm('Ambil Kelas Mata Kuliah? ');\">";
                                    }
                                    else if ( $statuspengambilan == 1 )
                                    {
                                        $tmpcetak .= "\r\n        <input type=submit name=aksi4 value='Batal' onClick=\"return confirm('Batalkan Pengambilan Kelas Mata Kuliah? ');\">";
                                    }
                                    $tmpcetak .= "\r\n      <input type=submit name=aksi4 value='Kembali' onClick=\"return confirm('Kembali ke daftar kurikulum? ');\">\r\n      </td>\r\n      </tr>\r\n    </table>\r\n    <!-- </td> --> ";
                                }
                            }
                        }
                    }
                    else if ( $aksiproseskrs == "" )
                    {
                        $q = "SELECT makul.ID,tbkmk.NAKMKTBKMK  NAMA  ,THSMSTBKMK,\r\n      tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER\r\n\t\tFROM makul,tbkmk\r\n\t\tWHERE\r\n\t\t  makul.ID=tbkmk.KDKMKTBKMK AND\r\n\t\t  tbkmk.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\r\n\t\t  tbkmk.STKMKTBKMK='A' AND\r\n\t\t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' ))\r\n\t\t\tORDER BY SEMESTER,ID\r\n\t\t";
                        $hp = mysqli_query($koneksi,$q);
                        if ( sqlnumrows( $hp ) <= 0 )
                        {
                            printmesg( "Data Mata Kuliah Jurusan / Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
                        }
                        else
                        {
                            $tmpcetak .= "\r\n      <!-- <td width=50%> -->\r\n\t\t<b>Kurikulum Mata Kuliah Semester Ini</b><br>\r\n\t\t\t\t<table  class=form width=100%>\r\n \t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Wajib/Pilihan</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t<td>Syarat</td>\r\n \t\t\t\t\t<td>Jumlah Jadwal</td>\r\n\t\t\t\t\t<td>Proses</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
                            $i = 0;
                            $semlama = "";
                            $startawal = 0;
                            while ( $dp = sqlfetcharray( $hp ) )
                            {
                                if ( $pilihtampil == 1 && !( $dp[SEMESTER] % 2 == $semesterx % 2 ) )
                                {
                                    continue;
                                }
                                if ( $semlama != $dp[SEMESTER] )
                                {
                                    if ( $semlama != "" )
                                    {
                                        $tmpcetak .= "\r\n \t\t\t\t\t\t\t";
                                        $startawal = $i;
                                    }
                                    $semlama = $dp[SEMESTER];
                                    $tmpcetak .= "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=11>Semester {$dp['SEMESTER']} </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                                }
                                $kelas = kelas( $i );
                                $q = "SELECT syaratpengambilanmk.*  \r\n        FROM syaratpengambilanmk  \r\n        WHERE\r\n        syaratpengambilanmk.IDMAKUL='{$dp['ID']}' AND\r\n        syaratpengambilanmk.TAHUN='{$data['tahun']}'\r\n        AND syaratpengambilanmk.SEMESTER='{$data['semester']}'\r\n         \r\n         ";
                                $hss = mysqli_query($koneksi,$q);
                                $daftarsyarat = "";
                                $syaratok = 1;
                                $jmlsyarat = sqlnumrows( $hss );
                                $totalsyarat = 0;
                                if ( 0 < sqlnumrows( $hss ) )
                                {
                                    $syaratok = 0;
                                    while ( $dss = sqlfetcharray( $hss ) )
                                    {
                                        $daftarsyarat .= "{$dss['IDSYARAT']}, {$dss['NILAI']}, {$dss['BOBOT']} <br>";
                                        $q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \r\n            FROM pengambilanmk  \r\n            WHERE\r\n            pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\r\n             IDMAHASISWA='{$idmahasiswa}'\r\n            AND BOBOT >= {$dss['BOBOT']} AND SIMBOL!='MD'\r\n             ";
                                        $hss2 = mysqli_query($koneksi,$q);
                                        if ( 0 < sqlnumrows( $hss2 ) )
                                        {
                                            ++$totalsyarat;
                                        }
                                        $logicsyarat = $dss[LOGIC];
                                    }
                                    $daftarsyarat .= "{$logicsyarat}";
                                }
                                if ( ( $jmlsyarat <= $totalsyarat && $logicsyarat == "AND" || 0 < $totalsyarat && $logicsyarat == "OR" ) && 0 < $jmlsyarat )
                                {
                                    $syaratok = 1;
                                }
                                $tmpcetak .= "\r\n\t\t\t\t\t<tr align=center {$kelas}>\r\n\t\t\t\t\t\t<td>  ".( $i + 1 )." \r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][semester]", "{$dp['SEMESTER']}", "class=masukan size=2" )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][sks]", "{$dp['SKS']}", "class=masukan size=2" )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][nama]", "{$dp['NAMA']}", "class=masukan  " )."\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['ID']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMA']}   </td>\r\n\t\t\t\t\t\t<td align=center>".$arrayjenismk[$dp[KDWPLTBKMK]]."</td>\r\n\t\t\t\t\t\t<td>{$dp['SKS']}  </td>\r\n\t\t\t\t\t\t<td nowrap>{$daftarsyarat}</td>";
                                if ( $syaratok == 1 )
                                {
                                    $jumlahjadwal = getfield( "COUNT(*)", "jadwalkuliahkurikulum", "WHERE IDMAKUL='{$dp['ID']}' AND IDPRODI='{$idprodi}' AND\r\n           TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}'" );
                                    $tmpcetak .= "\r\n \t\t\t\t\t\t<td>{$jumlahjadwal}</td>";
                                    if ( 0 < $jumlahjadwal )
                                    {
                                        $tmpcetak .= "<td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksiproseskrs=proseskrs&idmahasiswa={$idmahasiswa}&data[tahun]={$data['tahun']}&data[semester]={$data['semester']}&pilihtampil={$pilihtampil}&pilihtampil2={$pilihtampil2}&idmakul={$dp['ID']}'>proses</a></td>";
                                    }
                                    else
                                    {
                                        $tmpcetak .= "<td>-</td>";
                                    }
                                    $arraycekmakul[$dp[ID]] = $i;
                                }
                                else
                                {
                                    $tmpcetak .= "<td colspan=2 align=center nowrap><b>tidak memenuhi syarat</td>";
                                }
                                $tmpcetak .= "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
                                ++$i;
                            }
                            $tmpcetak .= "\r\n\r\n\t\t\t</table>\r\n\r\n \t\t\t\t<input type=hidden name=count value='{$i}'>\r\n\r\n\r\n\t\t\t\r\n\t\t\t</form>\r\n\r\n\t\t\t<script>\r\n \t\t\t\tvar count={$i};\r\n\t\t\t\tfunction cekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n\t\t\t\tfunction uncekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n \t\t\t</script>\r\n\t\t\t</td>";
                        }
                    }
                    $tmpcetak .= "\r\n\r\n      <!-- <td width=50%> -->\r\n       <b>Mata Kuliah Yang Telah Diambil </b><br>\r\n\t\t\t";
                    $q = "SELECT IDMAHASISWA FROM pengambilanmk \r\n          WHERE \r\n          IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'";
                    $h = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $h ) <= 0 )
                    {
                        $q = "delete FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' \r\n            AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'";
                        mysqli_query($koneksi,$q);
                    }
                    if ( $pilihtampil2 == 0 )
                    {
                        $qfield = "";
                    }
                    else
                    {
                        $qfield = "AND pengambilanmk.TAHUN='{$data['tahun']}' AND pengambilanmk.SEMESTER ='{$data['semester']}'";
                    }
                    $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\tmakul.NAMA NAMAMAKUL,\r\n\t\t\t\tSKSMAKUL AS SKS\r\n\t\t\t\tFROM pengambilanmk,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.TAHUN,pengambilanmk.SEMESTER\r\n\t\t\t";
                    $h = mysqli_query($koneksi,$q);
                    $tmpcetak .= mysqli_error($koneksi);
                    if ( sqlnumrows( $h ) <= 0 )
                    {
                        printmesg( "Data Pengambilan Mata Kuliah belum ada<br><BR>" );
                        $tmpcetak .= "<br><br>Tidak/belum ada mata kuliah yang diambil.";
                    }
                    else
                    {
                        $tmpcetak .= " \r\n\r\n\r\n        ";
                        $tmpcetak .= "\r\n\t\t\t\t\r\n\t\t\t\t\t<table class=data width=100%>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Jenis</td>\r\n\t\t\t\t\t\t<td>Jam</td>\r\n\t\t\t\t\t\t<td>Biaya</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
                        $i = 1;
                        $semlama = "";
                        $tahunlama = "";
                        while ( $d = sqlfetcharray( $h ) )
                        {
                            $semesterx = ( $d[TAHUN] - 1 - $angkatanx ) * 2 + $d[SEMESTER];
                            $semestertulis = $semesterx;
                            $kurawal = "(";
                            $kurakhir = ")";
                            if ( $d[SEMESTER] == 3 )
                            {
                                $semesterx += 0.5;
                                $semestertulis = "";
                                $kurawal = $kurakhir = "";
                            }
                            $tmp = "";
                            if ( $semlama != $semesterx )
                            {
                                if ( $semlama != "" )
                                {
                                    $tmp = "\r\n\t\t\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\r\n\t\t\t\t\t\t\t\t\t<td colspan=5></td>\r\n\t\t\t\t\t\t      <td align=right>".cetakuang( $totalbiaya2[$semlama] )."</td>\r\n\t\t\t\t\t\t\t\t</tr>";
                                    include( "edittrakm.php" );
                                    $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t   SKSEMTRAKM='{$total[$semlama]}',\r\n\t\t\t\t\t\t\t   SKSTTTRAKM='{$totalsks}'\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
                                    mysqli_query($koneksi,$q);
                                }
                                $semlama = $semesterx;
                                $tmpcetak .= "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=11>Semester {$semestertulis}  \r\n\t\t\t\t\t\t\t\t{$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurakhir}</td>\r\n\t\t\t\t\t\t\t</tr>";
                            }
                            $kelas = kelas( $i );
                            $styleerror = "";
                            $errornamakurikulum = "";
                            if ( $d[NAMA] == "" )
                            {
                                $d[NAMA] = $d[NAMAMAKUL];
                            }
                            $tmpa = "";
                            $tmpcetak .= "\r\n\t\t\t\t\t<tr {$kelas} {$styleerror}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td> <a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksiproseskrs=proseskrs&idmahasiswa={$idmahasiswa}&data[tahun]={$data['tahun']}&data[semester]={$data['semester']}&pilihtampil={$pilihtampil}&pilihtampil2={$pilihtampil2}&idmakul={$d['IDMAKUL']}'> \r\n            {$d['IDMAKUL']}</a> </td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']} {$namamakulkurikulum} {$errornamakurikulum}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>{$d['KELAS']}</td>\r\n\t\t\t\t\t\t<td align=center>".$arraykelasstei[$d[JENISKELAS]]."</td>\r\n\t\t\t\t\t\t<td align=center>{$d['JAM']}</td>\r\n\t\t\t\t\t\t<td align=right>".cetakuang( $d[BIAYA] )."</td>\r\n\t\t\t\t\t</tr>";
                            $totalsks += $d[SKS];
                            $total += $semesterx;
                            $totalbiaya2 += $semesterx;
                            $totalbiaya += $d[BIAYA];
                            $tahunlama = $d[TAHUN];
                            $sem = $d[SEMESTER] % 2;
                            if ( $sem == 0 )
                            {
                                $sem = 2;
                            }
                            $idmakul = $d[IDMAKUL];
                            $kelasmk = $d[KELAS];
                            include( "editrnlm.php" );
                            ++$i;
                        }
                        if ( $semlama != "" )
                        {
                            $tmpcetak .= "\r\n\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}  </td>\r\n\t\t\t\t\t\t\t<td colspan=5></td>\r\n\t\t\t\t\t\t<td align=right>".cetakuang( $totalbiaya2[$semlama] )."</td>\r\n\t\t\t\t\t\t</tr>";
                            include( "edittrakm.php" );
                            $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  SKSEMTRAKM='{$total[$semlama]}',\r\n\t\t\t\t\t\t\t   SKSTTTRAKM='{$totalsks}'\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
                            mysqli_query($koneksi,$q);
                        }
                        $tmpcetak .= " \r\n\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=5></td>\r\n\t\t\t\t\t\t<td align=right>".cetakuang( $totalbiaya )."</td>\r\n\t\t\t\t\t</tr>";
                        $tmpcetak .= "\r\n\t\t\t\t\t</table>\r\n\r\n\t\t\t\t";
                        if ( $total[$semesterkrs] + 0 == 0 )
                        {
                            $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  SKSEMTRAKM='0'                \r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'\r\n                ";
                            mysqli_query($koneksi,$q);
                        }
                        if ( $sksmaksimum < $total[$semesterkrs] && 0 < $sksmaksimum )
                        {
                            printmesg( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", SKS maksimum yang dapat diambil adalah {$sksmaksimum}." );
                        }
                        if ( is_array( $arraysyaratkrs ) )
                        {
                            foreach ( $arraysyaratkrs as $k => $v )
                            {
                                if ( $total[$semesterkrs] < $k )
                                {
                                    continue;
                                }
                                if ( $ips < $v )
                                {
                                    printmesg( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", syarat SKS >= {$k} adalah IP {$jtrakm} {$semesteracuan} semester yg lalu minimal {$v}. IP {$jtrakm} yg lalu mahasiswa adalah {$ips}." );
                                    break;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $tmpcetak .= "\t\t\t\r\n  <!-- \r\n  </tr>\r\n\t\t\t</table> -->\r\n\t\t\t\t\t\r\n\t\t\t\t\t<br>";
    echo $tmpcetak;
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "EDIT KRS MAHASISWA" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tampiledit", "" )."<tr class=judulform>\r\n\t\t\t<td class=judulform>NIM *</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".createinputtahunajaran( "data[tahun]", $data[tahun], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputselect( "data[semester]", $arraysemester, "{$data['semester']}", "", " class=masukan" )."</td>\r\n\t\t</tr> \r\n \r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Filter Kurikulum</td>\r\n\t\t\t<td>\r\n        <input type=radio name=pilihtampil value=0 >Tampilkan semua mata kuliah <br>\r\n        <input type=radio name=pilihtampil value=1 checked >Tampilkan mata kuliah semester ganjil/genap saja\r\n      </td>\r\n\t\t</tr> \r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Filter Mata Kuliah yg Diambil</td>\r\n\t\t\t<td>\r\n        <input type=radio name=pilihtampil2 value=0 >Tampilkan semua mata kuliah yg telah diambil<br>\r\n        <input type=radio name=pilihtampil2 value=1 checked >Tampilkan mata kuliah yg telah diambil di semester ini saja\r\n      </td>\r\n\t\t</tr> \r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Jenis Pengambilan</td>\r\n\t\t\t<td>\r\n        <input type=radio name=jeniskrs value=0 checked>KRS<br>\r\n        <input type=radio name=jeniskrs value=1 >Perbaikan KRS\r\n      </td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Edit' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilmahasiswastei.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "LIHAT KRS MAHASISWA" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t<table class=form>\r\n\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan / Program Studi Mata Kuliah\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan / Program Studi Mahasiswa\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodim>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'',form.idprodim.value);\"" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=masukan  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\"" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n\t\t\t\r\n               <div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">\r\n               <div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n              <select name='kelas' >\r\n                <option value=''>Semua</option>\r\n            ";
    $ik = 1;
    while ( $ik < 100 )
    {
        if ( $ik < 10 )
        {
            $idkelas = "0{$ik}";
        }
        else
        {
            $idkelas = "{$ik}";
        }
        $selected = "";
        if ( $idkelas == $kelas )
        {
            $selected = "selected";
        }
        echo "<option value='{$idkelas}' {$selected} >{$idkelas}</option>";
        ++$ik;
    }
    echo "\r\n            </select>\r\n      \r\n      </td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
