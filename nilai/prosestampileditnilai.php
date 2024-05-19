<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ll";

echo "<s";
echo "tyle type=\"text/css\">\r\n\t\r\ntr.datagenapcetak td, tr.dataganjilcetak td, tr.juduldatacetak td {\r\n\tborder:none;\r\n    border-collapse: collapse;\r\n}\r\n\r\n\t.borderblack {\r\n\t\tborder-top:1px solid black;\r\n\t\tborder-right:1px solid black;\r\n\t\t}\r\n\t\t\r\n\t.borderblack tr td {\r\n\t\tborder-bottom:1px solid black;\r\n\t\tborder-left:1px solid black;\r\n\t\t}\r\n</style>\r\n\r\n";
periksaroot( );
if ( !( $jenisusers == 0 && ( $tingkataksesusers[$kodemenu] == "T" || $tingkataksesusers[$kodemenu] == "B" ) || $jenisusers == 1 && $aturaneditnilaidosen == 1 && $users == $iddosenupdate && isdosenpengajar( $iddosenupdate, $idmakulupdate, $tahunupdate, $semesterupdate, $kelasupdate, $idprodiupdate ) ) )
{
    printmesg( "Maaf, Anda tidak punya hak untuk menggunakan fasilitas ini.." );
    exit( );
}
if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 && !getwaktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate ) )
{
	#echo "ll";
    if ( $aksi != "cetak" )
    {
        printmesg( "Maaf, waktu untuk entri nilai sudah habis. Silakan kontak operator untuk menyelesaikan entri nilai jika memang entri nilai belum selesai." );
    }
    $DOSENTIDAKBOLEHENTRI = 1;
    include_once( "prosestampileditnilai2.php" );
}
else
{
	#echo "mm";
    if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 && getwaktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate ) )
    {
        $tanggalselesai = waktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate );
        $trtanggal = "\r\n          <tr>\r\n            <td><b>Batas Akhir Entri Nilai</td>\r\n            <td><b>: {$tanggalselesai}</td>\r\n          </tr>\r\n        ";
    }
    if ( $jenisusers == 1 )
    {
        $iddosen = $users;
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
	/*$bodycetak ="<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";*/
	$bodycetak="";
    if ( $aksi != "cetak" )
    {
        printmesg( "Edit Data Nilai (Otomatis)" );
        printmesg( $errmesg );
    }
    #else
    #{
    #    $bodycetak = "<h3>Rincian Data Nilai</h3>";
    #}
	$bodycetak .="				<div class='portlet-body form'>";

    $bodycetak .= "					<div class=\"table-scrollable\">
										<table class=\"table table-striped table-bordered table-hover\">"."\r\n \t\t{$trtanggal}\r\n     <tr  >\r\n\t\t\t<td class='loseborder'>Prodi </td>\r\n\t\t\t<td  class='loseborder' >:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td  class='loseborder'>Mata Kuliah</td>\r\n\t\t\t<td  class='loseborder' >: {$idmakulupdate}, ".getnamamk( "{$idmakulupdate}", "".( $tahunupdate - 1 )."{$semesterupdate}", $idprodiupdate )."</td>\r\n\t\t</tr>\r\n    \r\n    "."<tr >\r\n\t\t\t<td class='loseborder'>Tahun Akademik</td>\r\n\t\t\t<td class='loseborder'>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td class='loseborder'>Semester</td>\r\n\t\t\t<td class='loseborder'>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td  class='loseborder' >Dosen Pengajar</td>\r\n\t\t\t<td class='loseborder'>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr  >\r\n\t\t\t<td class='loseborder'>Kode Kelas</td>\r\n\t\t\t<td class='loseborder'>: ".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>".
										"</table>
									</div>
									<div class=\"caption\">";
	$bodycetak .="						<div class=\"alert alert-success\"> Rincian Data Nilai Mahasiswa</div>";
	$bodycetak .="					</div>";
    if (1/*$konversisemua==1*/) // Konversi Default Umum 
    {
        /*$q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
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
				SELECT SIMBOL,NILAI,SYARAT FROM konversiumum
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

		#}

    }
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tAND IDDOSEN='{$iddosenupdate}'\r\n\t\t\tAND IDPRODI='{$idprodiupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $arraykomponendefault = getkomponendefault( );
        if ( is_array( $arraykomponendefault ) )
        {
            foreach ( $arraykomponendefault as $k => $d )
            {
                $q = "INSERT INTO komponen\r\n    \t\t\t\t(IDPRODI,IDDOSEN,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n    \t\t\t\tVALUES\r\n    \t\t\t\t('{$idprodiupdate}','{$iddosenupdate}',{$k},'{$idmakulupdate}','{$tahunupdate}','{$kelasupdate}','{$d['NAMA']}','{$d['PERSEN']}','{$semesterupdate}')";
                mysqli_query($koneksi,$q);
            }
        }
    }
    #if ( $pdf != 1 && $aksi != "cetak" )
    #{
    #    printjudulmenukecil( "Rincian Data Nilai Mahasiswa" );
    #}
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\tWHERE \r\n\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tAND IDDOSEN='{$iddosenupdate}'\r\n\t\t\tAND IDPRODI='{$idprodiupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    #echo $q.'<br>';
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
        $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t\t";
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
		
		if ($updatenilai==1) {
        $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmk.SIMBOL,pengambilanmk.BOBOT
				FROM mahasiswa,pengambilanmk 
				WHERE 
				mahasiswa.ID=pengambilanmk.IDMAHASISWA
				AND pengambilanmk.IDMAKUL='$idmakulupdate'
				AND pengambilanmk.TAHUN='$tahunupdate'
				AND pengambilanmk.SEMESTER='$semesterupdate'
				AND pengambilanmk.KELAS='$kelasupdate'
 				$qprodidep5
 
				ORDER BY mahasiswa.ID
			";
			
 			$h=doquery($q,$koneksi);
 
 			
			if (sqlnumrows($h)>0) {
  				$i=1;
				$totalbobot=0;
				while ($d=sqlfetcharray($h)) {
			        if (session_is_registered_sikad("prodis") && $_SESSION[prodis]!="") {
				      $q="SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML 
						FROM tbkmk,msmhs WHERE
						tbkmk.KDKMKTBKMK='$idmakulupdate'
						AND tbkmk.THSMSTBKMK=concat('".($tahunupdate-1)."','$semesterupdate')
						AND msmhs.NIMHSMSMHS='$d[ID]'
						AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
						AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK				  
						$qprodideptbkmk
					";
            $hxx=doquery($q,$koneksi);
            //$bodycetak.= mysqli_error($koneksi);
            $dxx=sqlfetcharray($hxx);
				    if ($dxx[JML]<=0) {
				      continue;
            }
          }
           
           //exit;

 							 $q="
								SELECT IDKOMPONEN,NILAI FROM nilai
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
								//	$bodycetak.= "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
						$nilaiakhir=0;
						
						foreach ($kp as $k=>$v) 
						{
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
					   $q="UPDATE pengambilanmk SET
						SIMBOL='$simbolakhir',
						NILAI='$nilaiakhir',
						BOBOT='$nilaiekakhir'
						WHERE IDMAHASISWA='$d[ID]'
						AND pengambilanmk.IDMAKUL='$idmakulupdate'
						AND pengambilanmk.TAHUN='$tahunupdate'
						AND pengambilanmk.SEMESTER='$semesterupdate'
						AND pengambilanmk.KELAS='$kelasupdate'
					";
					doquery($q,$koneksi);
          //$bodycetak.= $q."<br>";
          
					 $q="UPDATE trnlm SET
						NLAKHTRNLM='$simbolakhir',
						BOBOTTRNLM='$nilaiekakhir'
						WHERE NIMHSTRNLM='$d[ID]'
						AND trnlm.KDKMKTRNLM='$idmakulupdate'
						AND trnlm.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
					 
					";
					doquery($q,$koneksi);
           }


   
  				}			
 
 







			   }  
      }
        /*if ( $updatenilai == 1 )
        {
            $q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmk \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
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
                    else if ( session_is_registered_sikad( "prodis" ) && $_SESSION[prodis] != "" )
                    {
                        $q = "SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML \r\n\t\t\t\t\t\tFROM tbkmk,msmhs WHERE\r\n\t\t\t\t\t\ttbkmk.KDKMKTBKMK='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND tbkmk.THSMSTBKMK=concat('".( $tahunupdate - 1 )."','{$semesterupdate}')\r\n\t\t\t\t\t\tAND msmhs.NIMHSMSMHS='{$d['ID']}'\r\n\t\t\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\t\t\t\t  \r\n\t\t\t\t\t\t{$qprodideptbkmk}\r\n\t\t\t\t\t";
                        $hxx = mysqli_query($koneksi,$q);
                        $dxx = sqlfetcharray( $hxx );
                        if ( $dxx[JML] <= 0 )
                        {
                            continue;
                        }
                    }
                    $q = "\r\n\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t";
                    $h2 = mysqli_query($koneksi,$q);
                    unset( $datanilai );
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
                        $q = "UPDATE pengambilanmk SET\r\n\t\t\t\t\t\tSIMBOL='{$simbolakhir}',\r\n\t\t\t\t\t\tNILAI='{$nilaiakhir}',\r\n\t\t\t\t\t\tBOBOT='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                        mysqli_query($koneksi,$q);
                        $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\tNLAKHTRNLM='{$simbolakhir}',\r\n\t\t\t\t\t\tBOBOTTRNLM='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE NIMHSTRNLM='{$d['ID']}'\r\n\t\t\t\t\t\tAND trnlm.KDKMKTRNLM='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND trnlm.THSMSTRNLM='".( $tahunupdate - 1 )."{$semesterupdate}' \r\n\t\t\t\t\t \r\n\t\t\t\t\t";
                        mysqli_query($koneksi,$q);
                    }
                } while ( 1 );
            }
        }*/
        $q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmk \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
        #echo $q;
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
                #$bodycetak .= "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetaktampilnilai.php'>\r\n\t\t \t\t\t\t&nbsp;<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n             <input type=checkbox name=pdf value=1> PDF\r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
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
			#echo "mmm";
            $bodycetak .= "<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" );
            #$bodycetak .= "<table  class=\"table table-striped table-bordered table-hover\">";
			$bodycetak.="<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
            if ( $aksi != "cetak" )
            {
                #$bodycetak .= "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t\t<td colspan=".( 7 + count( $kp ) )." align=right> <input type=submit name=aksitambah value='Update' class=\"btn blue\"> </td>\r\n\t \t\t\t\t\t</tr>";
				$bodycetak .= "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=right>\r\n\t\t\t\t\t\t\t<th scope=col colspan=".( 7 + count( $kp ) )." align=right> <input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"> </th>\r\n\t \t\t\t\t\t</tr>";
				
			}
            #$bodycetak .= "\r\n\t\t\t\t\t<thead style='display:table-header-group;'>\r\n          <tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td  align=center><b>No</td>\r\n\t\t\t\t\t\t<td align=center><b>NIM</td>\r\n\t\t\t\t\t\t<td align=center><b>Nama</td>";
            $bodycetak .= "<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<th scope=col align=center><b>No</b></th>\r\n\t\t\t\t\t\t<th scope=col align=center><b>NIM</b></th>\r\n\t\t\t\t\t\t<th scope=col align=center><b>Nama</b></th>";
            
			foreach ( $kp as $k => $v )
            {
                $bodycetak .= "\r\n\t\t\t\t\t\t\t\t<th scope=col align=center><b>{$v['NAMA']} ({$v['BOBOT']}%)</th>\r\n\t\t\t\t\t\t\t";
            }
            $bodycetak .= "\r\n\t\t\t\t\t\t<th scope=col align=center><b>Nilai Akhir</b></th>\r\n\t\t\t\t\t\t<th scope=col align=center><b>Bobot Hitung/  (Asli)</b></td>\r\n\t\t\t\t\t\t<th scope=col align=center><b>Simbol Hitung/ (Asli)</b> </th>";
            if ( $aksi != "cetak" )
            {
                $bodycetak .= "\r\n\t\t\t\t\t\t<th scope=col align=center><b>Pilih</b></th>";
            }
            $bodycetak .= "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead><tbody>\r\n\t\t\t\t";
            $i = 1;
            $totalbobot = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                if ( session_is_registered_sikad( "prodis" ) && $_SESSION[prodis] != "" )
                {
                    $q = "SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML \r\n\t\t\t\t\t\tFROM tbkmk,msmhs WHERE\r\n\t\t\t\t\t\ttbkmk.KDKMKTBKMK='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND tbkmk.THSMSTBKMK=concat('".( $tahunupdate - 1 )."','{$semesterupdate}')\r\n\t\t\t\t\t\tAND msmhs.NIMHSMSMHS='{$d['ID']}'\r\n\t\t\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\t\t\t\t  \r\n\t\t\t\t\t\t{$qprodideptbkmk}\r\n\t\t\t\t\t";
                    $hxx = mysqli_query($koneksi,$q);
                    $dxx = sqlfetcharray( $hxx );
                    if ( $dxx[JML] <= 0 )
                    {
                        continue;
                    }
                }
                $kelas = kelas( $i );
                $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=center>\r\n\t\t\t\t\t\t\t<th scope=col align=center>{$i} &nbsp;</th>\r\n\t\r\n\t\t\t\t\t\t\t<th scope=col align=left nowrap>{$d[ID]}\r\n                            <input type=hidden name='datamahasiswa[{$d['ID']}]' value=1>\r\n                            </th>\r\n\t\t\t\t\t\t\t<th scope=col align=left nowrap>{$d['NAMA']} &nbsp;</th>";
                $q = "\r\n\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t";
                $h2 = mysqli_query($koneksi,$q);
                unset( $datanilai );
                /*while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) )
                {
                    $datanilai[$d2[IDKOMPONEN]] = $d2[NILAI];
                }*/
				if (sqlnumrows($h2)>0) {
								while ($d2=sqlfetcharray($h2)) {
									$datanilai[$d2[IDKOMPONEN]]=$d2[NILAI];
								//	$bodycetak.= "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
                $nilaiakhir = 0;
                foreach ( $kp as $k => $v )
                {
                    if ( $aksi != "cetak" )
                    {
                        if ( $jenisusers == 1 && getaturan( "EDITNILAIDOSEN2" ) == 1 && $datanilai[$v[IDKOMPONEN]] != 0 )
                        {
                            $bodycetak .= "\r\n\t\t\t\t\t\t\t\t\t<th scope=col>".$datanilai[$v[IDKOMPONEN]]."\r\n                  \r\n                  ".createinputhidden( "data[{$d['ID']}][{$v['IDKOMPONEN']}]", $datanilai[$v[IDKOMPONEN]], " class=masukan size=4" )." &nbsp;\r\n                  </th>\r\n\t\t\t\t\t\t\t\t";
                        }
                        else
                        {
                            if ( isoperator( ) && getaturan( "EDITNILAIOPERATOR" ) == 1 && 0 < $datanilai[$v[IDKOMPONEN]] && $_SESSION[statusnilaisupervisor] != 1 )
                            {
                                $bodycetak .= "\r\n      \t\t\t\t\t\t\t\t\t<th scope=col>".$datanilai[$v[IDKOMPONEN]]."\r\n                        \r\n                        ".createinputhidden( "data[{$d['ID']}][{$v['IDKOMPONEN']}]", $datanilai[$v[IDKOMPONEN]], " class=masukan size=4" )."\r\n                         &nbsp;</th>\r\n      \t\t\t\t\t\t\t\t";
                            }
                            else
                            {
                                $bodycetak .= "\r\n      \t\t\t\t\t\t\t\t\t<th scope=col>".createinputtext( "data[{$d['ID']}][{$v['IDKOMPONEN']}]", $datanilai[$v[IDKOMPONEN]], " class=masukan size=4" )." &nbsp;</th>\r\n      \t\t\t\t\t\t\t\t";
                            }
                        }
                    }
                    else
                    {
                        $bodycetak .= "\r\n\t\t\t\t\t\t\t\t\t<th scope=col>".$datanilai[$v[IDKOMPONEN]]." &nbsp;</th>\r\n\t\t\t\t\t\t\t\t";
                    }
                    #$total += $v[IDKOMPONEN];
					$total[$v[IDKOMPONEN]]+=$datanilai[$v[IDKOMPONEN]];
                    #$nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
					$nilaiakhir+=($datanilai[$v[IDKOMPONEN]]*$v[BOBOT]/100);
                }
                $totalnilaiakhir += $nilaiakhir;
                $simbolakhir = "?";
                $nilaiekakhir = "?";
				#print_r($kon);
                if ( is_array( $kon ) )
                {
                    foreach ( $kon as $k => $v )
                    {
                        if ( $v[SYARAT] <= $nilaiakhir )
                        {
                            $simbolakhir = $v[SIMBOL];
                            $nilaiekakhir = $v[NILAI];
                            break;
                            #break;
                        }
                    }
                }
                if ( !isset( $pertama ) && $pertama != 1 && $updatenilai == 1 && $pilihupdate[$d[ID]] == 1 )
                {
                    $q = "UPDATE pengambilanmk SET\r\n\t\t\t\t\t\tSIMBOL='{$simbolakhir}',\r\n\t\t\t\t\t\tNILAI='{$nilaiakhir}',\r\n\t\t\t\t\t\tBOBOT='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                    #echo $q;
					mysqli_query($koneksi,$q);
                    $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\tNLAKHTRNLM='{$simbolakhir}',\r\n\t\t\t\t\t\tBOBOTTRNLM='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE NIMHSTRNLM='{$d['ID']}'\r\n\t\t\t\t\t\tAND trnlm.KDKMKTRNLM='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND trnlm.THSMSTRNLM='".( $tahunupdate - 1 )."{$semesterupdate}' \r\n\t\t\t\t\t \r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                }
                $styletd = "";
                if ( $d[SIMBOL] != $simbolakhir )
                {
                    $styletd = "style='background-color:#FFFF00;'";
                }
                $bodycetak .= "\r\n\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $nilaiakhir, 2, ".", "," )." </th>\r\n\t\t\t\t\t\t\t<th scope=col nowrap>".number_format_sikad( $nilaiekakhir, 2, ".", "," )." ({$d['BOBOT']}) </th>\r\n\t\t\t\t\t\t\t<th scope=col {$styletd} >{$simbolakhir} ({$d['SIMBOL']})</th>";
                if ( $aksi != "cetak" )
                {
                    $bodycetak .= "\r\n\t\t\t\t\t\t<th scope=col align=center><input type=checkbox name='pilihupdate[{$d['ID']}]' value=1>&nbsp;</th>";
                }
                $bodycetak .= "\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                $totalbobotsemua += $nilaiekakhir;
                $totalbobot += $d[BOBOT];
                ++$i;
            }
			#echo $totalnilaiakhir;
            $bodycetak .= " \r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<th scope=col colspan=3 align=right>Total</th>";
            foreach ( $kp as $k => $v )
            {
                $bodycetak .= "\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $total[$v[IDKOMPONEN]], 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t";
            }
            $bodycetak .= "\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $totalnilaiakhir, 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $totalbobotsemua, 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t\t<th scope=col colspan=2>&nbsp;</th>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<th scope=col colspan=3 align=right>Rata-rata</th>";
            foreach ( $kp as $k => $v )
            {
                $bodycetak .= "\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $total[$v[IDKOMPONEN]] / ( $i - 1 ), 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t";
            }
            $bodycetak .= "\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $totalnilaiakhir / ( $i - 1 ), 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t\t<th scope=col>".number_format_sikad( $totalbobotsemua / ( $i - 1 ), 2, ".", "," )."</th>\r\n\t\t\t\t\t\t\t\t<th scope=col colspan=2>&nbsp;</th>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            $bodycetak .= "\r\n        </tbody>
							</table>
						</div>
					</div>
				</div>
			</form>
			</div>
			";
            if ( $pdf == 1 )
            {
                cetakpdf( $bodycetak, $stylecetak );
            }
            else
            {
				#echo "kesini";exit();
                echo $bodycetak;
            }
        }
        else
        {
            $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
            printmesg( $errmesg );
        }
    }
}
?>
