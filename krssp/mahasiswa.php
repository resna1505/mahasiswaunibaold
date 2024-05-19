<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT ANGKATAN,IDPRODI,SISTEMKRS,KELOMPOKKURIKULUM,GELOMBANG,JENISKELAS FROM mahasiswa WHERE ID='{$users}'";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$prodimahasiswa = $d[IDPRODI];
$angkatanmahasiswa = $d[ANGKATAN];
$sistemkrs = $d[SISTEMKRS];
$kelompokkurikulum = $d[KELOMPOKKURIKULUM];
$gelombang = $d[GELOMBANG];
$jeniskelas = $d[JENISKELAS];
$online = false;
$q = "SELECT \n *,\n  DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y') AS TM,\n  DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y') AS TS\n   FROM waktukrsprodisp WHERE \n  CURDATE() >= TANGGALMULAI AND\n  CURDATE() <= TANGGALSELESAI AND\n  PRODI='{$prodimahasiswa}' AND \n  ANGKATAN='{$angkatanmahasiswa}'\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $tahunupdate = $d[TAHUN];
    $data[tahun] = $tahunupdate;
    $semesterupdate = $d[SEMESTER];
    $data[semester] = $semesterupdate;
    $idmahasiswa = $users;
    $tanggalmulai = $d[TM];
    $tanggalselesai = $d[TS];
    $pilihtampil = 1;
    $online = true;
}
if ( $online != true )
{
    $q = "SELECT \n *,\n  DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y') AS TM,\n  DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y') AS TS\n   FROM waktukrssp WHERE \n  NOW() >= TANGGALMULAI AND\n  NOW() <= TANGGALSELESAI\n";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $tahunupdate = $d[TAHUN];
        $data[tahun] = $tahunupdate;
        $semesterupdate = $d[SEMESTER];
        $data[semester] = $semesterupdate;
        $idmahasiswa = $users;
        $tanggalmulai = $d[TM];
        $tanggalselesai = $d[TS];
        $pilihtampil = 1;
        $online = true;
    }
}
if ( $online == true )
{
    $q = "SELECT sksmaksimumsp.* \n            FROM sksmaksimumsp ,mahasiswa\n            WHERE \n            mahasiswa.IDPRODI=sksmaksimumsp.IDPRODI\n            AND mahasiswa.ID='{$idmahasiswa}'\n            ";
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
    $q = "\n    \t\t\tSELECT {$qtrakm} NLIPSTRAKM\n    \t\t\tFROM  trakm\n    \t\t\tWHERE\n    \t\t  NIMHSTRAKM='{$idmahasiswa}' AND\n    \t\t   THSMSTRAKM<='{$thnlalu}{$semlalu}'\n    \t\t  ORDER BY THSMSTRAKM DESC LIMIT 0,1\n     \t\t";
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
    $syaratkrs = 1;
    if ( $ips != "Tidak ada" )
    {
        $syaratkrs = 0;
        $q = "SELECT syaratkrssp.* FROM syaratkrssp,mahasiswa \n    WHERE \n    mahasiswa.IDPRODI=syaratkrssp.IDPRODI AND\n    mahasiswa.ID='{$idmahasiswa}' \n    ORDER BY SKS DESC";
        $hkrs = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $hkrs ) )
        {
            /*do
            {
                if ( $dkrs = sqlfetcharray( $hkrs ) )
                {
                    if ( $ips <= $dkrs[IPS] )
                    {
                        $sksmaksimum = $dkrs[SKS] - 1;
                        $ipsminimum = $dkrs[IPS];
                        $syaratkrs = 1;
                    }
                }
            } while ( 1 );*/
			while ($dkrs=sqlfetcharray($hkrs)) {
				if ($dkrs[IPS]>=$ips) {
				   
				  $sksmaksimum=$dkrs[SKS]-1;
				  $ipsminimum=$dkrs[IPS];
					$syaratkrs=1;          
				  }
			 }
        }
        else
        {
            $syaratkrs = 0;
        }
    }
    else
    {
        $ipsminimum = 0;
        $syaratkrs = 0;
    }
    $q = "SELECT sksmaksimumsp.* FROM sksmaksimumsp,mahasiswa WHERE \n            mahasiswa.IDPRODI=sksmaksimumsp.IDPRODI\n            AND mahasiswa.ID='{$idmahasiswa}' \n            ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $sksmaksimum2 = $d[SKS];
    $q = "SELECT SUM(SKSMAKUL) AS SKSEMTRAKM FROM pengambilanmksp \n    WHERE IDMAHASISWA='{$users}' AND TAHUN='".$tahunupdate."'  AND   SEMESTER='{$semesterupdate}'";
    $h = mysqli_query($koneksi,$q);
    $skssekarang = 0;
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $skssekarang = $d[SKSEMTRAKM];
    }
    $sksdiambil = $skssekarang;
}
if ( $online == false )
{
    printmesg( "KRS Online telah ditutup. Terima kasih" );
}
else
{
    $statuskrs = 1;
    if ( getaturan( "KRSONLINE" ) == X )
    {
        $idkomponen = getaturan( "SYARATKRSONLINE" );
        $statuskrs = 0;
        $q = "SELECT NAMA,JENIS FROM komponenpembayaran WHERE ID='{$idkomponen}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $namakomponen = $d[NAMA];
        $jeniskomponen = $d[JENIS];
        if ( $jeniskomponen == 2 )
        {
            $qfilterkeuangan = " AND TAHUN='{$data['tahun']}' ";
            $qbeasiswa = " AND TAHUN='{$data['tahun']}' ";
        }
        else if ( $jeniskomponen == 3 )
        {
            $qfilterkeuangan = " AND TAHUNAJARAN='{$data['tahun']}' \n      AND SEMESTER='{$data['semester']}' ";
            $qbeasiswa = " AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}'  ";
        }
        else if ( $jeniskomponen == 5 )
        {
            $qfilterkeuangan = "  \n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL 0 MONTH) >=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL -3 MONTH) <=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n      ";
            $qf2 = "*3 AS BIAYA ";
        }
        $q = "SELECT IDPRODI,ANGKATAN,JENISKELAS FROM mahasiswa WHERE ID='{$idmahasiswa}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $idprodi = $d[IDPRODI];
        $angkatan = $d[ANGKATAN];
        $jeniskelas = $d[JENISKELAS];
        if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
        }
        else
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
        }
        $q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $biaya = $d[BIAYA] + 0;
        $q = "SELECT DISKON FROM beasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' {$qbeasiswa} ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $beasiswa = $d[DISKON];
            $biaya = $biaya * ( 100 - $beasiswa ) / 100;
        }
        $q = "SELECT \n      SUM(JUMLAH)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' \n      {$qfilterkeuangan}\n      AND IDMAHASISWA='{$idmahasiswa}'\n      HAVING SUM(JUMLAH)-{$biaya} >=0\n      ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $statuskrs = 1;
        }
        else
        {
            $mesgkrs .= "Anda belum membayar lunas {$namakomponen}. Silakan lunasi pembayaran Anda terlebih dahulu.<br>";
        }
    }
    $statubimbingan = 0;
    $statuskrsonline = 0;
    $statusmahasiswabaru = $statusmahasiswabimbingan = 1;
    $q = "SELECT STATUS FROM statusbimbingansp WHERE IDMAHASISWA='{$users}' AND TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $statusbimbingan = $d[STATUS];
    }
    if ( getaturan( "KRSONLINE3" ) == 1 && $statusbimbingan == 0 )
    {
        $mesgkrs .= "Mahasiswa yang belum bimbingan ke dosen PA/Wali tidak dapat melakukan krs online. <br>";
        $statusmahasiswabimbingan = 0;
    }
    if ( $statusmahasiswabimbingan == 1 && $statuskrs == 1 )
    {
        $statuskrsonline = 1;
    }
    else
    {
        printmesg( $mesgkrs );
    }
    if ( $statuskrsonline == 1 )
    {
        if ( $aksi == "updatemk" )
        {
            if ( is_array( $data ) )
            {
                $jmlupdate = 0;
                $jmlhapus = 0;
                $j = 0;
                while ( $j < $count )
                {
                    $ttmp = "idambil_{$j}";
                    $idambil[$$ttmp] = 1;
                    ++$j;
                }
                foreach ( $datax as $k => $v )
                {
                    if ( $idambil[$k] == 1 )
                    {
                        if ( $sistemkrs == 0 && ( $sksmaksimum < $v[sks] + $sksdiambil && $syaratkrs == 1 && 0 <= $sksmaksimum ) )
                        {
                            $errmesg = "SKS yang hendak diambil (".( $v[sks] + $sksdiambil ).") melebihi batas maksimum SKS yang boleh diambil (".( $sksmaksimum + 1 )."). Proses pengambilan SKS Mata Kuliah dihentikan.";
                            break;
                        }
                        if ( $sistemkrs == 0 && ( $sksmaksimum2 < $v[sks] + $sksdiambil && 0 < $sksmaksimum2 ) )
                        {
                            $errmesg = "SKS yang hendak diambil (".( $v[sks] + $sksdiambil ).") melebihi batas maksimum SKS yang boleh diambil ({$sksmaksimum2}). Proses pengambilan SKS Mata Kuliah dihentikan.";
                            break;
                        }
                        $q = "INSERT INTO  pengambilanmksp \n\t\t\t\t(IDMAHASISWA,IDMAKUL,TAHUN,KELAS,SEMESTER,SEMESTERMAKUL,SKSMAKUL,THNSM) \n\t\t\t\tVALUES('{$idmahasiswa}','{$k}','{$data['tahun']}','{$v['kelas']}',{$data['semester']},\n\t\t\t\t'{$v['semester']}','{$v['sks']}', '".( $data[tahun] - 1 )."{$data['semester']}')\n\t\t\t\t";
                        mysqli_query($koneksi,$q);
                        if ( sqlaffectedrows( $koneksi ) <= 0 )
                        {
                            $q = "UPDATE pengambilanmksp \n\t\t\t\t\tSET \n\t\t\t\t\t\tKELAS='{$v['kelas']}',\n\t\t\t\t\t\tSEMESTER='{$data['semester']}',\n\t\t\t\t\t\tSEMESTERMAKUL='{$v['semester']}',\t\t\t\t\t\t\n\t\t\t\t\t\tSKSMAKUL='{$v['sks']}'\n\t\t\t\t\tWHERE\n\t\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\n\t\t\t\t\tAND IDMAKUL='{$k}'";
                            mysqli_query($koneksi,$q);
                            if ( 0 < sqlaffectedrows( $koneksi ) )
                            {
                                mysqli_query($koneksi,$q);
                                $ketlog = "Update Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                                buatlog( 25 );
                                $sem = $data[semester];
                                $tahunlama = $data[tahun];
                                ++$jmlupdate;
                            }
                        }
                        else
                        {
                            $sksdiambil += $v[sks];
                            ++$jmlupdate;
                            $ketlog = "Tambah Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                            buatlog( 24 );
                            $sem = $data[semester];
                            $tahunlama = $data[tahun];
                        }
                    }
                    else
                    {
                        $q = "DELETE FROM pengambilanmksp WHERE \n\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\n\t\t\t\tAND TAHUN='{$data['tahun']}'\n\t\t\t\tAND IDMAKUL='{$k}'\n\t\t\t\tAND SEMESTER='{$data['semester']}'\n\t\t\t\t";
                        mysqli_query($koneksi,$q);
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            $sksdiambil -= $v[sks];
                            $ketlog = "Hapus Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                            buatlog( 26 );
                            $q = "DELETE FROM trnlmsp WHERE \n    \t\t\t\tNIMHSTRNLM='{$idmahasiswa}'\n    \t\t\t\tAND THSMSTRNLM='".( $data[tahun] - 1 )."{$data['semester']}'\n    \t\t\t\tAND KDKMKTRNLM='{$k}'\n    \t\t\t\t \n    \t\t\t\t";
                            mysqli_query($koneksi,$q);
                            $q = "SELECT IDMAHASISWA FROM pengambilanmksp \n          WHERE \n          IDMAHASISWA='{$idmahasiswa}'\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\n          AND SEMESTER='{$data['semester']}'";
                            $h = mysqli_query($koneksi,$q);
                            ++$jmlhapus;
                        }
                    }
                }
                if ( 0 < $jmlupdate )
                {
                    $errmesg .= "Pengambilan Mata Kuliah Telah ditambahkan/diupdate sebanyak {$jmlupdate} buah";
                }
                if ( 0 < $jmlhapus )
                {
                    $errmesg .= "<br>Pengambilan Mata Kuliah Telah Dihapus sebanyak {$jmlhapus} buah";
                }
            }
            $aksi = "tampiledit";
        }
        if ( $aksi == "tampiledit" )
        {
            $statuskrs = 1;
            if ( getaturan( "KRSONLINE" ) == X )
            {
                $idkomponen = getaturan( "SYARATKRSONLINE" );
                $statuskrs = 0;
                $q = "SELECT NAMA,JENIS FROM komponenpembayaran WHERE ID='{$idkomponen}'";
                $h = mysqli_query($koneksi,$q);
                $d = sqlfetcharray( $h );
                $namakomponen = $d[NAMA];
                $jeniskomponen = $d[JENIS];
                if ( $jeniskomponen == 2 )
                {
                    $qfilterkeuangan = " AND TAHUN='{$data['tahun']}' ";
                }
                else if ( $jeniskomponen == 3 )
                {
                    $qfilterkeuangan = " AND TAHUNAJARAN='{$data['tahun']}' \n      AND SEMESTER='{$data['semester']}' ";
                }
                else if ( $jeniskomponen == 5 )
                {
                    $qfilterkeuangan = "  \n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL 0 MONTH) >=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL -3 MONTH) <=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n      ";
                    $qf2 = "*3 AS BIAYA ";
                }
                $q = "SELECT IDPRODI,ANGKATAN FROM mahasiswa WHERE ID='{$idmahasiswa}'";
                $h = mysqli_query($koneksi,$q);
                $d = sqlfetcharray( $h );
                $idprodi = $d[IDPRODI];
                $angkatan = $d[ANGKATAN];
                $q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                $h = mysqli_query($koneksi,$q);
                $d = sqlfetcharray( $h );
                $biaya = $d[BIAYA] + 0;
                $q = "SELECT \n      SUM(JUMLAH)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' \n      {$qfilterkeuangan}\n      AND IDMAHASISWA='{$idmahasiswa}'\n      HAVING SUM(JUMLAH)-{$biaya} >=0\n      ";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $statuskrs = 1;
                }
            }
            $tmpcetak = "";
            $idmahasiswa = $users;
            if ( $statuskrs == 0 )
            {
                $errmesg = "Maaf, Anda belum membayar lunas {$namakomponen}. Silakan lunasi pembayaran Anda terlebih dahulu.";
                $aksi = "";
            }
            else if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
            {
                $errmesg = "NIM harus diisi atau tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
                $aksi = "";
            }
            else if ( !ismahasiswaaktif( $idmahasiswa ) )
            {
                $errmesg = "Data tidak dapat diproses karena mahasiswa dengan ID '{$idmahasiswa}' DO/Lulus/Cuti";
                $aksi = "";
            }
            else
            {
                $q = "\n\t\t\tSELECT mahasiswa.NAMA,ANGKATAN,IDPRODI,KELAS AS KELASDEFAULT,\n      KDPSTMSMHS,KDJENMSMHS \n\t\t\t\n\t\t\tFROM  mahasiswa,msmhs\n\t\t\tWHERE\n\t\t\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\n\t\t  mahasiswa.ID='{$idmahasiswa}'\n \t\t";
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
                        $errmesg = "Tahun Ajaran salah. Mahasiswa ybs belum masuk pada tahun ajaran yang dipilih.";
                        $aksi = "tambahawal";
                    }
                    else
                    {
                        #printjudulmenu( "Edit KRS Mata Kuliah Semester Pendek" );
                        #printmesg( $errmesg );
						echo "<div class=\"page-content\">
									<div class=\"container-fluid\">
										<div class=\"row\">
											<div class=\"col-md-12\">
											
												<!-- BEGIN SAMPLE FORM PORTLET-->
												<div class=\"portlet light\">";
													printmesg( $errmesg );
													echo "<div class=\"portlet-body form\">
															<div class='tab-pane' id='tab_1'>
																<div class='portlet box blue'>
																	<div class='portlet-title'>
																		<div class='caption'>";
																			printmesg("Edit Data Pengambilan KRS SP");
													echo"				</div>																	
																	</div>
																	<div class='portlet-body form'>
																			<div class=\"portlet-body\">
																				<div class=\"table-scrollable\">";
                        $angkatanx = $d[ANGKATAN];
                        if ( $data[semester] == 2 )
                        {
                            $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
                        }
                        else
                        {
                            $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
                        }
                        $semesterkrs = $semesterx;
                        #$tmpcetak .= "\n\t\t\t\t<br>\n\t\t\t\t<table class=form>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform>Tahun Ajaran</td>\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform>Semester</td>\n\t\t\t\t\t\t<td > {$semesterx} {$kurawal} ".$arraysemester[$data[semester]]." {$kurtutup} </td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform>NIM</td>\n\t\t\t\t\t\t<td >{$idmahasiswa}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >Nama</td>\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >Angkatan</td>\n\t\t\t\t\t\t<td >{$d['ANGKATAN']}</td>\n\t\t\t\t\t</tr>";
                        $tmpcetak .= "<table class=\"table table-striped table-bordered table-hover\">
											<tr>
												<td class=judulform width=250>Tahun Ajaran</td>
												<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>
											</tr>
											<tr>
												<td class=judulform>Semester </td>
												<td > {$semesterx} {$kurawal} ".$arraysemester[$data[semester]]." {$kurtutup}  </td>
											</tr>
											<tr>
												<td class=judulform>NIM</td>
												<td >{$idmahasiswa}</td>
											</tr>
											<tr>
												<td >Nama</td>
												<td >{$d['NAMA']}</td>
											</tr>
											<tr>
												<td >Angkatan</td>
												<td >{$d['ANGKATAN']}</td>
											</tr> ";
						if ( $sistemkrs == 0 )
                        {
                            $tmpcetak .= "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >IP {$jtrakm} ";
                            if ( 0 < $semesteracuan )
                            {
                                $tmpcetak .= "{$semesteracuan} Semester Lalu";
                            }
                            else
                            {
                                $tmpcetak .= "semester ini";
                            }
                            $sksmaksimumsp = $sksmaksimum;
                            if ( $sksmaksimumsp == 0 - 1 )
                            {
                                $sksmaksimumsp = $sksmaksimum2;
                            }
                            $tmpcetak .= "</td>\n\t\t\t\t\t\t<td ><b>{$ips}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >SKS Semester Maksimum</td>\n\t\t\t\t\t\t<td ><b>{$sksmaksimumsp}</td>\n\t\t\t\t\t</tr>";
                        }
                        $tmpcetak .= "\n \n\t\t\t\t</table>\n\t\t\t";
                        $idprodimhs = $d[IDPRODI];
                        $kodeprodi = $d[KDPSTMSMHS];
                        $kodejenjang = $d[KDJENMSMHS];
                        unset( $arraysyaratkrs );
                        $q = "SELECT * FROM syaratkrssp WHERE IDPRODI='{$idprodimhs}' ORDER BY SKS DESC";
                        $hkrs = mysqli_query($koneksi,$q);
                        while ( $dkrs = sqlfetcharray( $hkrs ) )
                        {
                            $arraysyaratkrs["{$dkrs['SKS']}"] = "{$dkrs['IPS']}";
                        }
                        if ( $idprodi == "" )
                        {
                            $idprodi = $d[IDPRODI];
                        }
                        $tmpcetak .= "\n\t\t<form  action=index.php method=post>\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\n\t\t\t".createinputhidden( "aksi", "{$aksi}", "" )."\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" )."\n\n\t\t</form>";
                        $q = "SELECT makul.ID,tbkmksp.NAKMKTBKMK  AS NAMA  ,\n      tbkmksp.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     \n      SEMESTBKMK  +0 AS SEMESTER\n\t\tFROM makul,tbkmksp\n\t\tWHERE\n\t\t  makul.ID=tbkmksp.KDKMKTBKMK AND\n\t\t  tbkmksp.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\n\t\t  tbkmksp.STKMKTBKMK='A' AND\n\t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' )) AND\n\t\t\ttbkmksp.KELOMPOKKURIKULUM='{$kelompokkurikulum}'\n\t\t\tORDER BY SEMESTER,ID\n\t\t";
                        $hp = mysqli_query($koneksi,$q);
                        if ( sqlnumrows( $hp ) <= 0 )
                        {
                            printmesg( "Data Mata Kuliah Jurusan / Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
                        }
                        else
                        {
                            $tmpcetak .= "\n\t\t<form name=form action=index.php method=post>\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" );
                            #$tmpcetak .= "\n\t\t\t\t<table  class=form>\n\t\t\t\t<tr align=center class=juduldata>\n\t\t\t\t\t<td colspan=8 align=right>\n\t\t\t\t\t\t<a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=masukan value='update'>\n\t\t\t\t\t</td>\n\t\t\t\t</tr>\n\t\t\t\t<tr align=center class=juduldata>\n\t\t\t\t\t<td>No</td>\n\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\n\t\t\t\t\t<td>Wajib/Pilihan</td>\n\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t<td>Syarat</td>\n \t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t<td>Ambil</td>\n\t\t\t\t</tr>\n\t\t\t";
                            $tmpcetak.="
								<div class=\"row\">
									<div class=\"col-md-6\">	
										<div class=\"m-portlet m-portlet--mobile\">
													<div class=\"m-portlet__head\">
														<div class=\"m-portlet__head-caption\">
															<div class=\"m-portlet__head-title\">
																<h3 class=\"m-portlet__head-text\">
																	Kurikulum Mata Kuliah Semester Pendek Ini
																</h3>
															</div>					
														</div>
													</div>";
							$tmpcetak.="	<div class=\"m-portlet\">			
											<div class=\"m-section__content\">
												<div class=\"table-responsive\">
													<table class=\"table table-bordered table-hover\">
														<thead>
															<tr align=center class=juduldata>\n\t\t\t\t\t<td colspan=8 align=left>\n\t\t\t\t\t\t<a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" value='update'>\n\t\t\t\t\t</td>\n\t\t\t\t</tr>
															<tr align=center class=juduldata>\n\t\t\t\t\t<td>No</td>\n\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\n\t\t\t\t\t<td>Wajib/Pilihan</td>\n\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t<td>Syarat</td>\n \t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t<td>Ambil</td>\n\t\t\t\t</tr>\n\t\t\t";
							$tmpcetak.="				</thead>
														<tbody>";
							$i = 0;
                            $semlama = "";
                            $startawal = 0;
                            while ( $dp = sqlfetcharray( $hp ) )
                            {
                                if ( !( $dp[SEMESTER] % 2 == $semesterx % 2 ) && $dp[SEMESTER] != 0 )
                                {
                                    continue;
                                }
                                if ( $semlama != $dp[SEMESTER] )
                                {
                                    if ( $semlama != "" )
                                    {
                                        $tmpcetak .= "\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=left>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua]</a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> <input type=submit class=\"btn btn-brand\" value='update'>\n\t\t\t\t\t\t\t\t\t<script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t  \n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                                        $startawal = $i;
                                    }
                                    $semlama = $dp[SEMESTER];
                                    $tmpcetak .= "\n \t\t\t\t\t\t{$tmp}\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8>Semester {$dp['SEMESTER']} </td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t";
                                }
                                $kelas = kelas( $i );
                                $q = "SELECT KELAS,SEMESTER FROM pengambilanmksp WHERE\n\t\t\t\tIDMAHASISWA='{$idmahasiswa}' AND\n\t\t\t\tTAHUN='{$data['tahun']}' AND\n\t\t\t\tSEMESTER='{$data['semester']}' AND\n\t\t\t\tIDMAKUL='{$dp['ID']}'\n\t\t\t\t";
                                $hx = mysqli_query($koneksi,$q);
                                unset( $dx );
                                unset( $cekdx );
                                if ( 0 < sqlnumrows( $hx ) )
                                {
                                    $dx = sqlfetcharray( $hx );
                                    $cekdx = "checked";
                                }
                                else
                                {
                                    $dx[KELAS] = $d[KELASDEFAULT];
                                }
                                $q = "SELECT syaratpengambilanmksp.*  \n        FROM syaratpengambilanmksp  \n        WHERE\n        syaratpengambilanmksp.IDMAKUL='{$dp['ID']}' AND\n        syaratpengambilanmksp.TAHUN='{$data['tahun']}'\n        AND syaratpengambilanmksp.SEMESTER='{$data['semester']}'\n         \n         ";
                                $hss = mysqli_query($koneksi,$q);
                                $daftarsyarat = "";
                                $syaratok = 1;
                                $jmlsyarat = sqlnumrows( $hss );
                                $totalsyarat = 0;
                                if ( 0 < sqlnumrows( $hss ) )
                                {
                                    $syaratok = 0;
                                    /*do
                                    {
                                        if ( !( $dss = sqlfetcharray( $hss ) ) )
                                        {
                                            break;
                                        }
                                        else
                                        {
                                            $daftarsyarat .= "{$dss['IDSYARAT']}, {$dss['NILAI']}, {$dss['BOBOT']} <br>";
                                            $q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \n            FROM pengambilanmk  \n            WHERE\n            pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\n            IDMAHASISWA='{$idmahasiswa}'\n            AND BOBOT >= {$dss['BOBOT']}\n             ";
                                            $hss2 = mysqli_query($koneksi,$q);
                                        }
                                        if ( 0 < sqlnumrows( $hss2 ) )
                                        {
                                            ++$totalsyarat;
                                        }
                                    } while ( 1 );*/
									while ($dss = sqlfetcharray( $hss )){
										$daftarsyarat .= "{$dss['IDSYARAT']}, {$dss['NILAI']}, {$dss['BOBOT']} <br>";
										$q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \n            FROM pengambilanmk  \n            WHERE\n            pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\n            IDMAHASISWA='{$idmahasiswa}'\n            AND BOBOT >= {$dss['BOBOT']}\n             ";
                                        $hss2 = mysqli_query($koneksi,$q);
										if ( 0 < sqlnumrows( $hss2 ) )
                                            {
                                                ++$totalsyarat;
                                            }
									}
                                }
                                if ( $jmlsyarat <= $totalsyarat && 0 < $jmlsyarat )
                                {
                                    $syaratok = 1;
                                }
                                $tmpcetak .= "\n\t\t\t\t\t<tr align=center {$kelas}>\n\t\t\t\t\t\t<td>  ".( $i + 1 )."\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][semester]", "{$dp['SEMESTER']}", "class=masukan size=2" )."\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][sks]", "{$dp['SKS']}", "class=masukan size=2" )."\n\t\t\t\t\t\t</td>\n\t\t\t\t\t\t<td>{$dp['ID']}</td>\n\t\t\t\t\t\t<td align=left>{$dp['NAMA']}</td>\n\t\t\t\t\t\t<td align=center>".$arrayjenismk[$dp[KDWPLTBKMK]]."</td>\n\t\t\t\t\t\t<td>{$dp['SKS']}</td>\n            <td nowrap>{$daftarsyarat}</td>";
                                unset( $arraykelasdosenpengajar );
                                if ( $syaratok == 1 )
                                {
                                    if ( getaturan( "KELASKRSONLINE" ) == 0 )
                                    {
                                        $tmpcetak .= "\n           \t\t\t\t\t\t<td>".createinputselect( "datax[".$dp[ID]."][kelas]", $arraylabelkelas, $dx[KELAS], "", "" )."\n                         \n                       \n                       </td>";
                                        $tmpcetak .= "\n          \t\t\t\t\t\t<td> \n                      ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=masukan" )."\n                      ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=masukan" )."\n                      \n                      </td>";
                                    }
                                    else if ( getaturan( "KELASKRSONLINE" ) == 1 )
                                    {
                                        $q = "SELECT DISTINCT KELAS FROM dosenpengajarsp \n                    WHERE IDMAKUL='{$dp['ID']}' AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}' AND\n                    IDPRODI='{$idprodi}'\n                    ORDER BY KELAS ";
                                        $hkelas = mysqli_query($koneksi,$q);
                                        if ( 0 < sqlnumrows( $hkelas ) )
                                        {
                                            while ( $dkelas = sqlfetcharray( $hkelas ) )
                                            {
                                                $arraykelasdosenpengajar[$dkelas[KELAS]] = $arraylabelkelas[$dkelas[KELAS]];
                                            }
                                            $tmpcetak .= "\n         \t\t\t\t\t\t<td> ".createinputselect( "datax[".$dp[ID]."][kelas]", $arraykelasdosenpengajar, $dx[KELAS], "", "" )."\n                       \n                     \n                     </td>";
                                            $tmpcetak .= "\n        \t\t\t\t\t\t<td> \n                    ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=masukan" )."\n                    ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=masukan" )."\n                    \n                    </td>";
                                        }
                                        else
                                        {
                                            $tmpcetak .= "\n                      <td align=center>tidak ada dosen pengajar</td>\n                      <td align=center>-</td>\n                      ";
                                        }
                                    }
                                    $arraycekmakul[$dp[ID]] = $i;
                                }
                                else
                                {
                                    $tmpcetak .= "<td colspan=2 align=center nowrap><b>tidak memenuhi syarat</td>";
                                }
                                $tmpcetak .= "\n\t\t\t\t\t</tr>\n\t\t\t\t";
                                ++$i;
                            }
							$tmpcetak.="</tbody>";
                            $tmpcetak .= "\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=left>\n\t\t\t\t\t\t\t\t\t <a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua]</a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> <input type=submit class=\"btn btn-brand\" value='update'>\n\t\t\t\t\t\t\t\t\t<script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t  \n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                            $tmpcetak .= "</table>";
							$tmpcetak .= "<input type=hidden name=count value='{$i}'>\n\n\n\t\t\t\n\t\t\t</form>";
							$tmpcetak.="	</div>  
											</div>
										</div>
									</div>
								</div>";
							$tmpcetak .= "<script>\n \t\t\t\tvar count={$i};\n\t\t\t\tfunction cekall() {\n\t\t\t\t\tvar i=0;\n\t\t\t\t\tfor (i=0;i<count ;i++) {\n\t\t\t\t\t\t \n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\n \t\t\t\t\t}\n \t\t\t\t}\n\t\t\t\tfunction uncekall() {\n\t\t\t\t\tvar i=0;\n\t\t\t\t\tfor (i=0;i<count ;i++) {\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\n \t\t\t\t\t}\n \t\t\t\t}\n \t\t\t</script>\n\t\t\t";
							$tmpcetak.="
										<div class=\"col-md-6\">	
											<div class=\"m-portlet m-portlet--mobile\">
														<div class=\"m-portlet__head\">
															<div class=\"m-portlet__head-caption\">
																<div class=\"m-portlet__head-title\">
																	<h3 class=\"m-portlet__head-text\">
																		Mata Kuliah Yang Telah Diambil
																	</h3>
																</div>					
															</div>
														</div>";
						}
                        $q = "\n\t\t\t\tSELECT \n\t\t\t\tpengambilanmksp.* ,\n \t\t\t\tSKSMAKUL AS SKS,\n \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMA\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\n\t\t\t\tWHERE\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswa}'\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \n\t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA AND\n\t\t\ttbkmksp.KELOMPOKKURIKULUM='{$kelompokkurikulum}'\n\t\t\t\t{$qfield}\n \t\t\t\tORDER BY \n\t\t\t\tpengambilanmksp.TAHUN,pengambilanmksp.SEMESTER \n\t\t\t";
                        $h = mysqli_query($koneksi,$q);
                        $tmpcetak .= mysqli_error($koneksi );
						$tmpcetak.="	<div class=\"m-portlet\">			
											<div class=\"m-section__content\">
												<div class=\"table-responsive\">";
                        if ( sqlnumrows( $h ) <= 0 )
                        {
                            printmesg( "Data KRS Mata Kuliah Semester Pendek belum ada<br><BR>" );
                        }
                        else
                        {
                            #$tmpcetak .= "<br><br><b>Data Mata Kuliah Yang Telah Diambil</b><br>";
                            #$tmpcetak .= "\n\t\t\t\t\t<table class=form>\n\t\t\t\t\t<tr class=juduldata align=center>\n\t\t\t\t\t\t<td>No</td>\n\t\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t\t<td>Nama M-K</td>\n\t\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\n\t\t\t\t\t\t<td>Sem M-K</td>\n\t\t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t</tr>\n\t\t\t\t";
                            $tmpcetak.="		<table class=\"table table-bordered table-hover\">
														<thead>	
															<tr class=juduldata align=center>\n\t\t\t\t\t\t<td>No</td>\n\t\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t\t<td>Nama M-K</td>\n\t\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\n\t\t\t\t\t\t<td>Sem M-K</td>\n\t\t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t</tr>\n\t\t\t\t";
							$tmpcetak.= "				</thead>
														<tbody>";
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
                                        $tmp = "\n\t\t\t\t\t\t\t\t<tr class=juduldata >\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\n\t\t\t\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t\t\t\t</tr>";
                                    }
                                    $semlama = $semesterx;
                                    $tmpcetak .= "\n \t\t\t\t\t\t{$tmp}\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=7>Semester {$semestertulis}  \n\t\t\t\t\t\t\t\t{$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurakhir}</td>\n\t\t\t\t\t\t\t</tr>";
                                }
                                $kelas = kelas( $i );
                                $tmpcetak .= "\n\t\t\t\t\t<tr {$kelas}>\n\t\t\t\t\t\t<td align=center>{$i}</td>\n\t\t\t\t\t\t<td>{$d['IDMAKUL']}</td>\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\n\t\t\t\t\t\t<td align=center>".$arraylabelkelas[$d[KELAS]]."</td>\n\t\t\t\t\t</tr>";
                                $totalsks += $d[SKS];
                                $total += $semesterx;
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
                                $tmpcetak .= "\n\t\t\t\t\t\t<tr class=juduldata >\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}  </td>\n\t\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t\t</tr>";
                            }
                            $tmpcetak .= " \n\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\n\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t</tr>";
                            $tmpcetak .= "</tbody></table>";
							$tmpcetak .= "<div align=center style='font-size:16pt;'>\n          <br> \n           <a href='cetakkrs.php?idmahasiswaupdate={$users}&tahunupdate={$data['tahun']}&semesterupdate={$data['semester']}' target=_blank><b >Cetak KRS</b></a> </div>\n\t\t\t\t\t<br>\n\t\t\t\t";
                            if ( $sistemkrs == 0 && is_array( $arraysyaratkrs ) )
                            {
                                foreach ( $arraysyaratkrs as $k => $v )
                                {
                                    if ( $total[$semesterkrs] < $k )
                                    {
                                        continue;
                                    }
                                    if ( $ips < $v )
                                    {
                                        $cancel = 1;
                                        printmesg( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", syarat SKS >= {$k} adalah IP {$jtrakm} {$semesteracuan} semester yg lalu minimal {$v}. IP {$jtrakm} yg lalu Anda adalah {$ips}." );
                                        break;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
			$tmpcetak .= "			</div>
						</div>
					</div>
				</div>
			</div>";
            echo $tmpcetak;
        }
    }
    if ( $aksi == "" )
    {
        #printjudulmenu( "Edit KRS Online Semester Pendek" );
        #printmesg( $errmesg );
        #echo "\n  <table>\n    <tr>\n      <td>\n    Anda dapat mengedit Kartu Rencana Studi untuk Semester Pendek ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate} dari tanggal <b>{$tanggalmulai}</b> s.d <b>{$tanggalselesai}</b>. Untuk mengedit KRS, silakan klik link di bawah ini\n    <br><br>\n    <a href='index.php?pilihan={$pilihan}&aksi=tampiledit'>Edit KRS</a>\n    </td>\n    </tr>\n    </table>\n    \n  ";
		echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						";
							printmesg( $errmesg );
			echo "			<div class='portlet-title'>";
									printmesg("KRS Online Semester Pendek");
					echo "	</div>";
											
			echo "			<div class='portlet-title'>";
									printmesg("Anda dapat mengedit Kartu Rencana Studi untuk Semester Pendek ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate} dari tanggal <b>{$tanggalmulai}</b> s.d <b>{$tanggalselesai}</b>. Untuk mengedit KRS, silakan klik link di bawah ini\n    <br><br>\n    <a href='index.php?pilihan={$pilihan}&aksi=tampiledit'>Edit KRS</a>\n ");
			echo "			</div>
						</div>
					</div>
				</div>
			</div>";
	}
}
?>
