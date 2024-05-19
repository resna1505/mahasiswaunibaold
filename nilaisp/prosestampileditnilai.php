<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( !( $jenisusers == 0 && $tingkataksesusers[$kodemenu] == "T" || $tingkataksesusers[$kodemenu] == "B" || $jenisusers == 1 && $aturaneditnilaidosen == 1 && $users == $iddosenupdate && isdosenpengajar( $iddosenupdate, $idmakulupdate, $tahunupdate, $semesterupdate, $kelasupdate, $idprodiupdate, 1 ) ) )
{
    printmesg( "Maaf, Anda tidak punya hak untuk menggunakan fasilitas ini.." );
    exit( );
}
if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 && !getwaktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate, 1 ) )
{
    if ( $aksi != "cetak" )
    {
        printmesg( "Maaf, waktu untuk entri nilai sudah habis. Silakan kontak operator untuk menyelesaikan entri nilai jika memang entri nilai belum selesai." );
    }
    include_once( "prosestampileditnilai2.php" );
}
else
{
    if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 && getwaktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate, 1 ) )
    {
        $tanggalselesai = waktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate, 1 );
        $trtanggal = "\r\n          <tr>\r\n            <td><b>Batas Akhir Entri Nilai</td>\r\n            <td><b>: {$tanggalselesai}</td>\r\n          </tr>\r\n        ";
    }
    $konversisemua = 0;
    @$konf = @file( "konfig" );
    if ( is_array( $konf ) )
    {
        if ( trim( $konf[0] ) == "0" )
        {
            $konversisemua = 0;
        }
        else
        {
            $konversisemua = 1;
        }
    }
    if ( $aksi != "cetak" )
    {
        printmesg( "Edit Data Nilai (Otomatis)" );
        printmesg( $errmesg );
    }
    #else
    #{
    #    printjudulmenucetak( "Data Nilai" );
    #    printmesgcetak( $errmesg );
    #}
    #echo "<table  class=form>"."\r\n \t\t{$trtanggal}\r\n     <tr  >\r\n\t\t\t<td class=judulform>Prodi </td>\r\n\t\t\t<td>:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar</td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>: ".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t\r\n\t\t";
    $bodycetak .="				<div class='portlet-body form'>";

    $bodycetak .= "					<div class=\"table-scrollable\">
										<table class=\"table table-striped table-bordered table-hover\">
											"."{$trtanggal}\r\n     <tr  >\r\n\t\t\t<td class=judulform>Prodi </td>\r\n\t\t\t<td>:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar</td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>: ".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>".
	"</table>
									</div>
									<div class=\"caption\">";
	$bodycetak .="						<div class=\"alert alert-success\"> Rincian Data Nilai Mahasiswa</div>";
	$bodycetak .="					</div>";
	if (1/*$konversisemua==1*/)
    {
        /*$q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumumsp\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        unset( $kon );
        unset( $konumum );
        $h = mysqli_query($koneksi,$q);
        while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
        {
            $kon[] = $d;
            $konumum[] = $d;
        }
        $q = "\r\n\t\t\t\tSELECT NLAKHTBBNL AS SIMBOL,BOBOTTBBNL AS NILAI,SYARAT \r\n        FROM tbbnl,mspst\r\n\t\t\t\tWHERE\r\n\t\t\t\ttbbnl.KDPTITBBNL=mspst.KDPTIMSPST AND\r\n\t\t\t\ttbbnl.KDJENTBBNL=mspst.KDJENMSPST AND\r\n\t\t\t\ttbbnl.KDPSTTBBNL=mspst.KDPSTMSPST AND\r\n\t\t\t\t\r\n\t\t\t\tTHSMSTBBNL='".( $tahunupdate - 1 )."{$semesterupdate}' AND\r\n \t\t\t\tIDX='{$idprodiupdate}'\r\n         ORDER BY BOBOTTBBNL DESC\r\n\t\t\t";
        $h = mysqli_query($koneksi,$q);
        unset( $kon );
        unset( $konumum );
        do
        {
            if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
            {
                $kon[] = $d;
                $konumum[] = $d;
            }
        } while ( 1 );*/
		
		
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversiumumsp
				ORDER BY NILAI DESC
			";
			unset($kon);
			unset($konumum);
			$h=doquery($q,$koneksi);
			if (sqlnumrows($h)>0) {
				while ($d=sqlfetcharray($h)) {
					$kon[]=$d;
					$konumum[]=$d;
	 			}		
			}
      // KOnversi Default Umum Per Semester Per Prodi
			$q="
				SELECT NLAKHTBBNL AS SIMBOL,BOBOTTBBNL AS NILAI,SYARAT 
        FROM tbbnl,mspst
				WHERE
				tbbnl.KDPTITBBNL=mspst.KDPTIMSPST AND
				tbbnl.KDJENTBBNL=mspst.KDJENMSPST AND
				tbbnl.KDPSTTBBNL=mspst.KDPSTMSPST AND
				
				THSMSTBBNL='".($tahunupdate-1)."$semesterupdate' AND
 				IDX='$idprodiupdate'
         ORDER BY BOBOTTBBNL DESC
			";
			
			$h=doquery($q,$koneksi);
			
			if (sqlnumrows($h)>0) {
			  unset($kon);
			  unset($konumum);
				while ($d=sqlfetcharray($h)) {
					$kon[]=$d;
					$konumum[]=$d;
	 			}		
			}
    }
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponensp\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tAND IDDOSEN='{$iddosenupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $arraykomponendefault = getkomponendefault( );
        if ( is_array( $arraykomponendefault ) )
        {
            foreach ( $arraykomponendefault as $k => $d )
            {
                $q = "INSERT INTO komponensp\r\n    \t\t\t\t(IDPRODI,IDDOSEN,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n    \t\t\t\tVALUES\r\n    \t\t\t\t('{$idprodiupdate}','{$iddosenupdate}',{$k},'{$idmakulupdate}','{$tahunupdate}','{$kelasupdate}','{$d['NAMA']}','{$d['PERSEN']}','{$semesterupdate}')";
                mysqli_query($koneksi,$q);
            }
        }
    }
    #printjudulmenukecil( "Rincian Data Nilai Mahasiswa" );
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponensp\r\n\t\t\tWHERE \r\n\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tAND IDDOSEN='{$iddosenupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        printmesg( "Komponen nilai untuk mata kuliah ini belum ada" );
    }
    else
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $kp[] = $d;
        }
        $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversisp\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t\t";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            unset( $kon );
            while ( $d = sqlfetcharray( $h ) )
            {
                $kon[] = $d;
            }
        }
        else
        {
            $kon = $konumum;
        }
        if ( $updatenilai == 1 )
        {
			

       $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmksp.SIMBOL,pengambilanmksp.BOBOT
				FROM mahasiswa,pengambilanmksp 
				WHERE 
				mahasiswa.ID=pengambilanmksp.IDMAHASISWA
				AND pengambilanmksp.IDMAKUL='$idmakulupdate'
				AND pengambilanmksp.TAHUN='$tahunupdate'
				AND pengambilanmksp.SEMESTER='$semesterupdate'
				AND pengambilanmksp.KELAS='$kelasupdate'
 				$qprodidep5
 
				ORDER BY mahasiswa.ID
			";
/*
 	 $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID 
				FROM mahasiswa,pengambilanmksp,tbkmksp
				WHERE 
				mahasiswa.ID=pengambilanmksp.IDMAHASISWA
				AND pengambilanmksp.IDMAKUL='$idmakulupdate'
				AND pengambilanmksp.TAHUN='$tahunupdate'
				AND pengambilanmksp.SEMESTER='$semesterupdate'
				AND pengambilanmksp.KELAS='$kelasupdate'
				AND tbkmksp.KDKMKTBKMK=pengambilanmksp.IDMAKUL
				AND tbkmksp.THSMSTBKMK=concat(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)
				AND tbkmksp.THSMSTBKMK=concat(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)
				$qprodidep5sp
				$qprodideptbkmksp
				ORDER BY mahasiswa.ID
			";
	*/		
			$h=doquery($q,$koneksi);
 
			if (sqlnumrows($h)>0) {
     		$i=1;
				$totalbobot=0;
				while ($d=sqlfetcharray($h)) {
  							 $q="
								SELECT IDKOMPONEN,NILAI FROM nilaisp
								WHERE 
								IDMAKUL='$idmakulupdate'
								AND TAHUN='$tahunupdate'
								AND SEMESTER='$semesterupdate'
								AND KELAS='$kelasupdate'
								AND IDMAHASISWA='$d[ID]'
							";
							$h2=doquery($q,$koneksi);
							unset($datanilai);
							if (sqlnumrows($h2)>0) {
								while ($d2=sqlfetcharray($h2)) {
									$datanilai[$d2[IDKOMPONEN]]=$d2[NILAI];
								//	echo "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
						$nilaiakhir=0;
						foreach ($kp as $k=>$v) {
							
 							$total[$v[IDKOMPONEN]]+=$datanilai[$v[IDKOMPONEN]];
							$nilaiakhir+=($datanilai[$v[IDKOMPONEN]]*$v[BOBOT]/100);
						}
							$totalnilaiakhir+=$nilaiakhir;
						$simbolakhir="?";
						$nilaiekakhir="?";
						if (is_array($kon)) {
							foreach ($kon as $k=>$v) {
								if ($nilaiakhir>=$v[SYARAT]) {
									$simbolakhir=$v[SIMBOL];
									$nilaiekakhir=$v[NILAI];
									break;
								}
							}
						}

 
 					if(!isset($pertama) && $pertama!=1 && $updatenilai==1 && $pilihupdate[$d[ID]]==1) {
							$q="UPDATE pengambilanmksp SET
								SIMBOL='$simbolakhir',
								NILAI='$nilaiakhir',
								BOBOT='$nilaiekakhir'
								WHERE IDMAHASISWA='$d[ID]'
								AND pengambilanmksp.IDMAKUL='$idmakulupdate'
								AND pengambilanmksp.TAHUN='$tahunupdate'
								AND pengambilanmksp.SEMESTER='$semesterupdate'
								AND pengambilanmksp.KELAS='$kelasupdate'
							";
							doquery($q,$koneksi);

							 $q="UPDATE trnlmsp SET
								NLAKHTRNLM='$simbolakhir',
								 
								BOBOTTRNLM='$nilaiekakhir'
								WHERE NIMHSTRNLM='$d[ID]'
								AND trnlmsp.KDKMKTRNLM='$idmakulupdate'
								AND trnlmsp.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
							 
							";
							doquery($q,$koneksi);
					}           

 				}			
 			}  
            /*$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmksp.SIMBOL,pengambilanmksp.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmksp \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $i = 1;
                $totalbobot = 0;
                do
                {
                    if ( !( $d = sqlfetcharray( $h ) ) )
                    {
                        break;
                    }
                    else
                    {
                        $q = "\r\n\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilaisp\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t";
                        $h2 = mysqli_query($koneksi,$q);
                        unset( $datanilai );
                    }
                    while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) )
                    {
                        $datanilai[$d2[IDKOMPONEN]] = $d2[NILAI];
                    }
                    $nilaiakhir = 0;
                    foreach ( $kp as $k => $v )
                    {
                        $total += $v[IDKOMPONEN];
                        $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                    }
                    $totalnilaiakhir += $nilaiakhir;
                    $simbolakhir = "?";
                    $nilaiekakhir = "?";
                    if ( is_array( $kon ) )
                    {
                        foreach ( $kon as $k => $v )
                        {
                            if ( $v[SYARAT] <= $nilaiakhir )
                            {
                                $simbolakhir = $v[SIMBOL];
                                $nilaiekakhir = $v[NILAI];
                                break;
                                break;
                            }
                        }
                    }
                    if ( !isset( $pertama ) && $pertama != 1 && $updatenilai == 1 && $pilihupdate[$d[ID]] == 1 )
                    {
                        $q = "UPDATE pengambilanmksp SET\r\n\t\t\t\t\t\tSIMBOL='{$simbolakhir}',\r\n\t\t\t\t\t\tNILAI='{$nilaiakhir}',\r\n\t\t\t\t\t\tBOBOT='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                        mysqli_query($koneksi,$q);
                        $q = "UPDATE trnlmsp SET\r\n\t\t\t\t\t\tNLAKHTRNLM='{$simbolakhir}',\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\tBOBOTTRNLM='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE NIMHSTRNLM='{$d['ID']}'\r\n\t\t\t\t\t\tAND trnlmsp.KDKMKTRNLM='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND trnlmsp.THSMSTRNLM='".( $tahunupdate - 1 )."{$semesterupdate}' \r\n\t\t\t\t\t \r\n\t\t\t\t\t";
                        mysqli_query($koneksi,$q);
                    }
                } while ( 1 );
            }*/
        }
		
		  $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmksp.SIMBOL,pengambilanmksp.BOBOT
				FROM mahasiswa,pengambilanmksp 
				WHERE 
				mahasiswa.ID=pengambilanmksp.IDMAHASISWA
				AND pengambilanmksp.IDMAKUL='$idmakulupdate'
				AND pengambilanmksp.TAHUN='$tahunupdate'
				AND pengambilanmksp.SEMESTER='$semesterupdate'
				AND pengambilanmksp.KELAS='$kelasupdate'
 				$qprodidep5
 
				ORDER BY mahasiswa.ID
			";
/*
 	 $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID 
				FROM mahasiswa,pengambilanmksp,tbkmksp
				WHERE 
				mahasiswa.ID=pengambilanmksp.IDMAHASISWA
				AND pengambilanmksp.IDMAKUL='$idmakulupdate'
				AND pengambilanmksp.TAHUN='$tahunupdate'
				AND pengambilanmksp.SEMESTER='$semesterupdate'
				AND pengambilanmksp.KELAS='$kelasupdate'
				AND tbkmksp.KDKMKTBKMK=pengambilanmksp.IDMAKUL
				AND tbkmksp.THSMSTBKMK=concat(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)
				AND tbkmksp.THSMSTBKMK=concat(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)
				$qprodidep5sp
				$qprodideptbkmksp
				ORDER BY mahasiswa.ID
			";
	*/		
			$h=doquery($q,$koneksi);
			//echo mysql_error();	

//Husnil
//<code : begin>
if ($aksi!="cetak") {

$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
}//<code : end>

			if (sqlnumrows($h)>0) {
		 		if ($aksi!="cetak") {
					/*echo "
						<table class=form>
						<tr><td>
					<form target=_blank action='cetaktampilnilai.php'>
		 				<input type=submit name=aksi class=tombol value='Cetak'>".
				createinputhidden("pilihan",$pilihan,"").
				createinputhidden("aksi","tambah","").
				createinputhidden("idprodiupdate","$idprodiupdate","").
				createinputhidden("idmakulupdate","$idmakulupdate","").
				createinputhidden("iddosenupdate","$iddosenupdate","").
				createinputhidden("tahunupdate","$tahunupdate","").
				createinputhidden("kelasupdate","$kelasupdate","").
				createinputhidden("semesterupdate","$semesterupdate","").
				"
					</form>
						</td></tr></table>";*/
					$bodycetak .="<div class=\"tools\">
										<form target=_blank action='cetaktampilnilai.php'>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>
														<!--<input type=checkbox name=pdf value=1> PDF\r\n             
															<a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    -->         ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."
													</td>
												</tr>
											</table>
										</form>
									</div>";	
				}
				$bodycetak .= "
				<form name=form action=index.php method=post>".
				createinputhidden("pilihan",$pilihan,"").
				createinputhidden("aksi","tambah","").
				createinputhidden("idprodiupdate","{$idprodiupdate}","").
				createinputhidden("idmakulupdate","{$idmakulupdate}","").
				createinputhidden("iddosenupdate","{$iddosenupdate}","").
				createinputhidden("tahunupdate","{$tahunupdate}","").
				createinputhidden("kelasupdate","{$kelasupdate}","").
				createinputhidden("sessid","{$token}","").
				createinputhidden("semesterupdate","{$semesterupdate}","");
		/*echo 
				"<table $border class=data$cetak>";*/
				$bodycetak.="<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
					if ($aksi!="cetak") {
						$bodycetak .= "
						<tr class=juduldata$cetak align=center>
							<td align=right colspan=".(7+count($kp))."> <input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td>
	 					</tr>";
	 				}
	 				$bodycetak .= "
					<tr class=juduldata$cetak align=center>
						<td>No</td>
						<td>NIM</td>
						<td>Nama</td>";
						foreach ($kp as $k=>$v) {
							$bodycetak .= "
								<td>$v[NAMA] ($v[BOBOT]%)</td>
							";
						}
						$bodycetak .= "
						<td>Nilai Akhir</td>
						<td>Bobot Hitung/  (Asli)</td>
						<td>Simbol Hitung/ (Asli) </td>
            ";
					if ($aksi!="cetak") {
						$bodycetak .= "
						<td>Pilih</td>";
          }						
            /*echo "
					</tr>
				";*/
				$bodycetak .= "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead><tbody>\r\n\t\t\t\t";
				$i=1;
				$totalbobot=0;
				while ($d=sqlfetcharray($h)) {
					$kelas=kelas($i);
					$bodycetak .= "
						<tr $kelas$cetak  align=center>
							<td align=center>$i</td>
	
							<td  align=left nowrap>$d[ID]
              <input type=hidden name='datamahasiswa[$d[ID]]' value=1></td>
							<td  align=left nowrap>$d[NAMA]</td>";
							 $q="
								SELECT IDKOMPONEN,NILAI FROM nilaisp
								WHERE 
								IDMAKUL='$idmakulupdate'
								AND TAHUN='$tahunupdate'
								AND SEMESTER='$semesterupdate'
								AND KELAS='$kelasupdate'
								AND IDMAHASISWA='$d[ID]'
							";
							$h2=doquery($q,$koneksi);
							unset($datanilai);
							if (sqlnumrows($h2)>0) {
								while ($d2=sqlfetcharray($h2)) {
									$datanilai[$d2[IDKOMPONEN]]=$d2[NILAI];
								//	echo "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
						$nilaiakhir=0;
						foreach ($kp as $k=>$v) {
							
							if ($aksi!="cetak") {

							 if ( $jenisusers==1 &&  getaturan("EDITNILAIDOSEN2")==1 && $datanilai[$v[IDKOMPONEN]]!=0 )  {

								$bodycetak .=  "
									<td>".$datanilai[$v[IDKOMPONEN]]."
                  
                  ".createinputhidden("data[$d[ID]][$v[IDKOMPONEN]]",
									$datanilai[$v[IDKOMPONEN]]," class=masukan size=4")."
                  </td>
								";

							 } else {

								$bodycetak .= "
									<td>".createinputtext("data[$d[ID]][$v[IDKOMPONEN]]",
									$datanilai[$v[IDKOMPONEN]]," class=masukan size=4")."</td>
								";
               }

								/*echo "
									<td>".createinputtext("data[$d[ID]][$v[IDKOMPONEN]]",
									$datanilai[$v[IDKOMPONEN]]," class=masukan size=4")."</td>
								";*/
							} else {
								$bodycetak .= "
									<td>".$datanilai[$v[IDKOMPONEN]]."</td>
								";
							}
							$total[$v[IDKOMPONEN]]+=$datanilai[$v[IDKOMPONEN]];
							$nilaiakhir+=($datanilai[$v[IDKOMPONEN]]*$v[BOBOT]/100);
						}
							$totalnilaiakhir+=$nilaiakhir;
						$simbolakhir="?";
						$nilaiekakhir="?";
						if (is_array($kon)) {
							foreach ($kon as $k=>$v) {
								if ($nilaiakhir>=$v[SYARAT]) {
									$simbolakhir=$v[SIMBOL];
									$nilaiekakhir=$v[NILAI];
									break;
								}
							}
						}

            $styletd="";
						if ($d[SIMBOL]!=$simbolakhir) {
              $styletd="style='background-color:#FFFF00;'";
            }

						$bodycetak .= "
							<td>".number_format_sikad($nilaiakhir,2,'.',',')."</td>
							<td>".number_format_sikad($nilaiekakhir,2,'.',',')." ($d[BOBOT])</td>
							<td $styletd >$simbolakhir ($d[SIMBOL]) </td>";
					if ($aksi!="cetak") {
						$bodycetak .= "
						<td align=center><input type=checkbox name='pilihupdate[$d[ID]]' value=1></td>";
          }						
            $bodycetak .= "
						</tr>
					";
					if(!isset($pertama) && $pertama!=1 && $updatenilai==1 && $pilihupdate[$d[ID]]==1) {
					$q="UPDATE pengambilanmksp SET
						SIMBOL='$simbolakhir',
						NILAI='$nilaiakhir',
						BOBOT='$nilaiekakhir'
						WHERE IDMAHASISWA='$d[ID]'
						AND pengambilanmksp.IDMAKUL='$idmakulupdate'
						AND pengambilanmksp.TAHUN='$tahunupdate'
						AND pengambilanmksp.SEMESTER='$semesterupdate'
						AND pengambilanmksp.KELAS='$kelasupdate'
					";
					doquery($q,$koneksi);

					 $q="UPDATE trnlmsp SET
						NLAKHTRNLM='$simbolakhir',
						 
						BOBOTTRNLM='$nilaiekakhir'
						WHERE NIMHSTRNLM='$d[ID]'
						AND trnlmsp.KDKMKTRNLM='$idmakulupdate'
						AND trnlmsp.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
					 
					";
					doquery($q,$koneksi);
          }           

					$totalbobotsemua+=$nilaiekakhir;
					$totalbobot+=$d[BOBOT];
					$i++;
 				}			
				$bodycetak .= " 
					<tr class=juduldata$cetak align=center>
						<td colspan=3 align=right>Total</td>";
						foreach ($kp as $k=>$v) {
							$bodycetak .= "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]],2,'.',',')."</td>
							";
						}
						$bodycetak .= "
								<td>".number_format_sikad($totalnilaiakhir,2,'.',',')."</td>
								<td>".number_format_sikad($totalbobotsemua,2,'.',',')."</td>
								<td colspan=2></td>
					</tr>
					<tr class=juduldata$cetak align=center>
						<td colspan=3 align=right>Rata-rata</td>";
						foreach ($kp as $k=>$v) {
							$bodycetak .= "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]]/($i-1),2,'.',',')."</td>
							";
						}
						$bodycetak .= "
								<td>".number_format_sikad($totalnilaiakhir/($i-1),2,'.',',')."</td>
								<td>".number_format_sikad($totalbobotsemua/($i-1),2,'.',',')."</td>
								<td colspan=2></td>
					</tr>
				";

				/*echo	 "</table>
				<br><br>";*/
				$bodycetak .= "\r\n        </tbody>
							</table>
						</div>
					</div>
				</div>
			</form>
			</div>";
			echo $bodycetak;
			} else {
				$errmesg="Data mahasiswa yang mengambil mata kuliah ini belum ada";
				printmesg($errmesg);
			}
			
			
			
		}
        /*$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmksp.SIMBOL,pengambilanmksp.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmksp \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
        $h = mysqli_query($koneksi,$q);
        if ( $aksi != "cetak" )
        {
            $token = md5( uniqid( rand( ), TRUE ) );
            $_SESSION['token'] = $token;
        }
        if ( 0 < sqlnumrows( $h ) )
        {
            if ( $aksi != "cetak" )
            {
                echo "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetaktampilnilai.php'>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
            }
            echo "\r\n\t\t\t\t<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" );
            echo "<table {$border} class=data{$cetak}>";
            if ( $aksi != "cetak" )
            {
                echo "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t\t<td align=right colspan=".( 7 + count( $kp ) )."> <input type=submit name=aksitambah value='Update' class=masukan></td>\r\n\t \t\t\t\t\t</tr>";
            }
            echo "\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>NIM</td>\r\n\t\t\t\t\t\t<td>Nama</td>";
            foreach ( $kp as $k => $v )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td>{$v['NAMA']} ({$v['BOBOT']}%)</td>\r\n\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t\t<td>Nilai Akhir</td>\r\n\t\t\t\t\t\t<td>Bobot Hitung/  (Asli)</td>\r\n\t\t\t\t\t\t<td>Simbol Hitung/ (Asli) </td>\r\n            ";
            if ( $aksi != "cetak" )
            {
                echo "\r\n\t\t\t\t\t\t<td>Pilih</td>";
            }
            echo "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            $i = 1;
            $totalbobot = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                echo "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}\r\n              <input type=hidden name='datamahasiswa[{$d['ID']}]' value=1></td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td>";
                $q = "\r\n\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilaisp\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t";
                $h2 = mysqli_query($koneksi,$q);
                unset( $datanilai );
                while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) )
                {
                    $datanilai[$d2[IDKOMPONEN]] = $d2[NILAI];
                }
                $nilaiakhir = 0;
                foreach ( $kp as $k => $v )
                {
                    if ( $aksi != "cetak" )
                    {
                        if ( $jenisusers == 1 && getaturan( "EDITNILAIDOSEN2" ) == 1 && $datanilai[$v[IDKOMPONEN]] != 0 )
                        {
                            echo "\r\n\t\t\t\t\t\t\t\t\t<td>".$datanilai[$v[IDKOMPONEN]]."\r\n                  \r\n                  ".createinputhidden( "data[{$d['ID']}][{$v['IDKOMPONEN']}]", $datanilai[$v[IDKOMPONEN]], " class=masukan size=4" )."\r\n                  </td>\r\n\t\t\t\t\t\t\t\t";
                        }
                        else
                        {
                            echo "\r\n\t\t\t\t\t\t\t\t\t<td>".createinputtext( "data[{$d['ID']}][{$v['IDKOMPONEN']}]", $datanilai[$v[IDKOMPONEN]], " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t\t";
                        }
                    }
                    else
                    {
                        echo "\r\n\t\t\t\t\t\t\t\t\t<td>".$datanilai[$v[IDKOMPONEN]]."</td>\r\n\t\t\t\t\t\t\t\t";
                    }
                    $total += $v[IDKOMPONEN];
                    $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                }
                $totalnilaiakhir += $nilaiakhir;
                $simbolakhir = "?";
                $nilaiekakhir = "?";
                if ( is_array( $kon ) )
                {
                    foreach ( $kon as $k => $v )
                    {
                        if ( $v[SYARAT] <= $nilaiakhir )
                        {
                            $simbolakhir = $v[SIMBOL];
                            $nilaiekakhir = $v[NILAI];
                            break;
                            break;
                        }
                    }
                }
                $styletd = "";
                if ( $d[SIMBOL] != $simbolakhir )
                {
                    $styletd = "style='background-color:#FFFF00;'";
                }
                echo "\r\n\t\t\t\t\t\t\t<td>".number_format_sikad( $nilaiakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t<td>".number_format_sikad( $nilaiekakhir, 2, ".", "," )." ({$d['BOBOT']})</td>\r\n\t\t\t\t\t\t\t<td {$styletd} >{$simbolakhir} ({$d['SIMBOL']}) </td>";
                if ( $aksi != "cetak" )
                {
                    echo "\r\n\t\t\t\t\t\t<td align=center><input type=checkbox name='pilihupdate[{$d['ID']}]' value=1></td>";
                }
                echo "\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                if ( !isset( $pertama ) && $pertama != 1 && $updatenilai == 1 && $pilihupdate[$d[ID]] == 1 )
                {
                    $q = "UPDATE pengambilanmksp SET\r\n\t\t\t\t\t\tSIMBOL='{$simbolakhir}',\r\n\t\t\t\t\t\tNILAI='{$nilaiakhir}',\r\n\t\t\t\t\t\tBOBOT='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    $q = "UPDATE trnlmsp SET\r\n\t\t\t\t\t\tNLAKHTRNLM='{$simbolakhir}',\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\tBOBOTTRNLM='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE NIMHSTRNLM='{$d['ID']}'\r\n\t\t\t\t\t\tAND trnlmsp.KDKMKTRNLM='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND trnlmsp.THSMSTRNLM='".( $tahunupdate - 1 )."{$semesterupdate}' \r\n\t\t\t\t\t \r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                }
                $totalbobotsemua += $nilaiekakhir;
                $totalbobot += $d[BOBOT];
                ++$i;
            }
            echo " \r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Total</td>";
            foreach ( $kp as $k => $v )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $total[$v[IDKOMPONEN]], 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Rata-rata</td>";
            foreach ( $kp as $k => $v )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $total[$v[IDKOMPONEN]] / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            echo "</table>\r\n\t\t\t\t<br><br>";
        }
        else
        {
            $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
            printmesg( $errmesg );
        }
    }*/
}
?>
