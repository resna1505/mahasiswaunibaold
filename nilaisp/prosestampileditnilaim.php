<?php
periksaroot();

$stylecetak.="
<style type=\"text/css\">

a:link {
	text-decoration:none;
	}

td {
	border:none;
	font-size:12px;
	}

.makebordering {
	border-top:1px solid #003757;
	border-right:1px solid #003757;
	width:99%;
	}
	
.juduldata {
	border-bottom:1px solid #003757;
	border-left:1px solid #003757;
	padding:5px;
	font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;
	}

.tdborder {
	border-bottom:1px solid #003757;
	border-left:1px solid #003757;
	}

</style>
";
// PERIKSA APAKAH YANG MASUK KE SINI PUNYA HAK AKSES???
if (!
      (
        (
          $jenisusers==0 /*APAKAH OPERATOR??*/ 
          && $tingkataksesusers[$kodemenu]=="T" || $tingkataksesusers[$kodemenu]=="B" /*APAKAH PUNYA HAK AKSES TULIS??*/
        ) 
        || //ATAU
        (
          $jenisusers==1 /*APAKAH DOSEN??*/ 
          && $aturaneditnilaidosen==1 /*APAKAH ATURAN MEMBOLEHKAN DOSEN ENTRI NILAI*/
          && $users==$iddosenupdate
          && isdosenpengajar($iddosenupdate,$idmakulupdate,$tahunupdate,$semesterupdate,$kelasupdate,$idprodiupdate,1)
        )
      )
    ) {		
  printmesg("Maaf, Anda tidak punya hak untuk menggunakan fasilitas ini..");
  exit; // TIDAK PUNYA HAK
}				


// PERIKSA APAKAH DOSEN YANG MASUK KE SINI BATAS WAKTU ENTRI NYA HABIS???
if (
      (
        $jenisusers==1 /*APAKAH DOSEN??*/
        && 
        $aturaneditnilaidosen==1 /*APAKAH ATURAN MEMBOLEHKAN????*/
        && !getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate,1) /*APAKAH WAKTU SP HABIS??*/
      )
    ) {
    if ($aksi!="cetak") {
     printmesg("Maaf, waktu untuk entri nilai sudah habis. Silakan kontak operator untuk menyelesaikan entri nilai jika memang entri nilai belum selesai.");
    }
     include_once "prosestampileditnilaim2.php";
 
} else {
    // KALAU DOSEN, DAN WAKTUNYA BELUM HABIS, TAMPILKAN BATAS WAKTUNYA
    if (
        (
          $jenisusers==1 
          && 
          $aturaneditnilaidosen==1 
          && 
          getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate,1) 
        )
      ) {
        $tanggalselesai=waktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate,1);
        $trtanggal="
          <tr>
            <td><b>Batas Akhir Entri Nilai</td>
            <td><b>: $tanggalselesai</td>
          </tr>
        ";
      }


        // KONVERSI UMUM
			$q="
				SELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumumsp
				ORDER BY NILAI DESC
			";
      $hb=doquery($q,$koneksi);
      unset($arraybobotnilai);
      if (sqlnumrows($hb)) {
        while ($db=sqlfetcharray($hb)) {
          $arraybobotnilai["$db[SIMBOL]"]="$db[NILAI]";
         }
      }  
      // KONVERSI MENENGAH
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
			echo mysqli_error($koneksi);
			if (sqlnumrows($h)>0) {
  		  unset($arraybobotnilai);
 				while ($d=sqlfetcharray($h)) {
         $arraybobotnilai["$d[SIMBOL]"]="$d[NILAI]";
 	 			}		
			}
          
      
      // KONVERSI KHUSUS
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversisp
				WHERE 
				IDMAKUL='$idmakulupdate'
				AND TAHUN='$tahunupdate'
				AND SEMESTER='$semesterupdate'
				AND KELAS='$kelasupdate'
				ORDER BY NILAI DESC
				";
			
				$h=doquery($q,$koneksi);
				if (sqlnumrows($h)>0) {
  		    unset($arraybobotnilai);
 					while ($d=sqlfetcharray($h)) {
             $arraybobotnilai["$d[SIMBOL]"]="$d[NILAI]";
					}		
				}  


       if (is_array($arraybobotnilai)) {
      		echo "
          <script>
            function setbobot(nilai,bobot) { ";
              foreach ($arraybobotnilai as $k=>$v) {
                echo "
                if (nilai.value=='$k') {
                  bobot.value='$v';
                } else
                ";
              }
               echo "
               {
               }
            }
          </script>
          
          ";
	     }
 //	}  
//}


//Husnil
//<code : begin>
if ($aksi!="cetak") {
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
}//<code : end>

	$konversisemua=0;
	@$konf=file("konfig");
	if (is_array($konf)) {
		if (trim($konf[0])=="0") {
			$konversisemua=0;
		} else {
			$konversisemua=1;
		} 
	}
	if ($aksi!="cetak") {
 		printmesg("Edit Data Nilai (Manual)");
		printmesg($errmesg);
	} /*else {
 		printjudulmenucetak("Data Nilai");
		printmesgcetak($errmesg);
	}*/
 		
		$bodycetak.="			<div class='portlet-body form'>	
									<div class=\"table-scrollable\">
										<table  class=\"table table-striped table-bordered table-hover\">"."
											$trtanggal
											 <tr  >
													<td class=judulform>Prodi</td>
													<td>:  ".$arrayprodidep[$idprodiupdate]."</td>
												</tr>     
											<tr  >
													<td class=judulform>Mata Kuliah</td>
													<td>: $idmakulupdate, ".getnamafromtabel($idmakulupdate,"makul")."</td>
												</tr>".
												"<tr class=judulform>
													<td>Tahun Akademik</td>
													<td>: ".($tahunupdate-1)."/$tahunupdate			
													</td>
												</tr>".
												"<tr class=judulform>
													<td>Semester</td>
													<td>: ".$arraysemester[$semesterupdate]."			
													</td>
												</tr>".
												"<tr class=judulform>
													<td class=judulform>Dosen Pengajar</td>
													<td>: $iddosenupdate, ".getnamafromtabel($iddosenupdate,"dosen")."</td>
												</tr>".
												"<tr class=judulform>
													<td>Kode Kelas</td>
													<td>: ".$arraylabelkelas[$kelasupdate]."</td>
												</tr>".
													
												"
												</table>
											
									</div><div class=\"caption\">";
	$bodycetak .="						<div class=\"alert alert-success\"> Rincian Data Nilai Mahasiswa</div>";
	$bodycetak .="					</div>";
 		
 		
 		
 		
/* 	$q="
			SELECT IDKOMPONEN,NAMA,BOBOT FROM komponen
			WHERE 
			IDMAKUL='$idmakulupdate'
			AND TAHUN='$tahunupdate'
			AND SEMESTER='$semesterupdate'
			AND KELAS='$kelasupdate'
			AND IDDOSEN='$iddosenupdate'
			ORDER BY BOBOT
		";
		$h=doquery($q,$koneksi);
		if (sqlnumrows($h)<=0) {
			printmesg("Komponen nilai untuk mata kuliah ini belum ada");
		}
		else */
    {
		//	while ($d=sqlfetcharray($h)) {
		//		$kp[]=$d;
 		//	}		


 

/*
 echo $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmksp.SIMBOL,pengambilanmksp.BOBOT
				FROM mahasiswa,pengambilanmksp,tbkmksp
				WHERE 
				mahasiswa.ID=pengambilanmksp.IDMAHASISWA
				AND pengambilanmksp.IDMAKUL='$idmakulupdate'
				AND pengambilanmksp.TAHUN='$tahunupdate'
				AND pengambilanmksp.SEMESTER='$semesterupdate'
				AND pengambilanmksp.KELAS='$kelasupdate'
				AND tbkmksp.KDKMKTBKMK=pengambilanmksp.IDMAKUL
				AND tbkmksp.THSMSTBKMK=concat(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)
 				$qprodidep5sp
				$qprodideptbkmksp
				ORDER BY mahasiswa.ID
			";
*/
       $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmksp.SIMBOL,pengambilanmksp.BOBOT,pengambilanmksp.NILAI
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
			
			$h=doquery($q,$koneksi);
			//echo mysql_error();	
			if (sqlnumrows($h)>0) {
		 		if ($aksi!="cetak") {
					$bodycetak .="	<div class=\"tools\">
									<form target=_blank action='cetaktampilnilaim.php'>
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>".
																createinputhidden("pilihan",$pilihan,"").
																createinputhidden("aksi","tambah","").
																createinputhidden("idprodiupdate","$idprodiupdate","").
																createinputhidden("idmakulupdate","$idmakulupdate","").
																createinputhidden("iddosenupdate","$iddosenupdate","").
																createinputhidden("tahunupdate","$tahunupdate","").
																createinputhidden("kelasupdate","$kelasupdate","").
																createinputhidden("semesterupdate","$semesterupdate","").
																"
														</td>
												</tr>
											</table>
										</div>
									</form>
								</div>";
				}
				$bodycetak.= "
				<form name=form action=index.php method=post>".
				createinputhidden("pilihan",$pilihan,"").
				createinputhidden("aksi","tambah","").
				createinputhidden("idprodiupdate","$idprodiupdate","").
				createinputhidden("idmakulupdate","$idmakulupdate","").
				createinputhidden("iddosenupdate","$iddosenupdate","").
				createinputhidden("tahunupdate","$tahunupdate","").
				createinputhidden("kelasupdate","$kelasupdate","").
				createinputhidden("sessid",$token,"").
				createinputhidden("semesterupdate","$semesterupdate","");
		$bodycetak.= 
				"		<div class=\"m-portlet\">			
							<div class=\"m-section__content\">
								<div class=\"table-responsive\">
									<table class=\"table table-bordered table-hover\">
										<thead>";
					if ($aksi!="cetak") {
						$bodycetak.= "
						<tr class=juduldata$cetak align=right>
							<td colspan=".(7+count($kp)).">
              <input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td>
	 					</tr>";
	 				}
	 				$bodycetak.= "
					<tr class=juduldata$cetak align=center>
						<td>No</td>
						<td>NIM</td>
						<td>Nama</td>";
						/*foreach ($kp as $k=>$v) {
							echo "
								<td>$v[NAMA] ($v[BOBOT]%)</td>
							";
						}
						*/
						$bodycetak.= "
						<td>Nilai Akhir</td>
						<td>Simbol</td>
						<td>Bobot</td>";
					if ($aksi!="cetak") {
						$bodycetak.= "
						<td>Pilih</td>";
          }						
           $bodycetak.= "
											</tr>
										</thead>
									<tbody>
									";
				$i=1;
				$totalbobot=0;
				while ($d=sqlfetcharray($h)) {
					$kelas=kelas($i);
					$bodycetak.= "
						<tr $kelas$cetak  align=center>
							<td align=center>$i</td>
	
							<td  align=left nowrap>$d[ID]</td>
							<td  align=left nowrap>$d[NAMA]</td>";
							/*
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
								//	echo "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
						$nilaiakhir=0;
						foreach ($kp as $k=>$v) {
							
 
								echo "
 
									<td>".$datanilai[$v[IDKOMPONEN]]."</td>
								";
 
							$total[$v[IDKOMPONEN]]+=$datanilai[$v[IDKOMPONEN]];
							$nilaiakhir+=($datanilai[$v[IDKOMPONEN]]*$v[BOBOT]/100);
						}
						*/
						
						$nilaiakhir=$d[NILAI];
							$totalnilaiakhir+=$nilaiakhir;
						$simbolakhir=$d[SIMBOL];
						$nilaiekakhir=$d[BOBOT];
 
 
          if ( $jenisusers==1 &&  getaturan("EDITNILAIDOSEN2")==1 && $simbolakhir!="" )  {

						$bodycetak.= "
							<td>   ".number_format_sikad($nilaiakhir,2,'.',',')."</td>
							<td>
							<input type=hidden name='datamahasiswa[$d[ID]]' value=1>
               $nilaiekakhir </td>
							<td> $simbolakhir </td>
              ";
  					if ($aksi!="cetak") {
  						$bodycetak.= "
  						<td align=center>- </td>";
            }						

          } else {
          
						$bodycetak.= "
						  <td class=tdborder align=center>  
                  ".createinputtext("data_$d[ID]_NILAI",$nilaiakhir," class=masukan size=4")." </td>
							<td>".createinputtext("data_$d[ID]_SIMBOL",$simbolakhir," class=masukan size=2
              onBlur=\"setbobot(data_$d[ID]_SIMBOL,data_$d[ID]_BOBOT);\"
              ")." </td> 
							<td>
							<input type=hidden name='datamahasiswa[$d[ID]]' value=1>
              ".createinputtext("data_$d[ID]_BOBOT",$nilaiekakhir," class=masukan size=2")." </td>
							";
          

  					if ($aksi!="cetak") {
  						$bodycetak.= "
  						<td align=center><input type=checkbox name='pilihupdate[$d[ID]]' value=1></td>";
            }						

          }
 
            $bodycetak.= "
						</tr>
					";
/*					
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
 */  
					 $q="UPDATE trnlmsp SET
						NLAKHTRNLM='$simbolakhir',
						 
						BOBOTTRNLM='$nilaiekakhir'
						WHERE NIMHSTRNLM='$d[ID]'
						AND trnlmsp.KDKMKTRNLM='$idmakulupdate'
						AND trnlmsp.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
					 
					";
					doquery($q,$koneksi);
        

					$totalbobotsemua+=$nilaiekakhir;
					$totalbobot+=$d[BOBOT];
					$i++;
 				}			
				$bodycetak.= "
					<tr class=juduldata$cetak align=center>
						<td colspan=3 align=right>Total</td>";
						/*
						foreach ($kp as $k=>$v) {
							echo "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]],2,'.',',')."</td>
							";
						}
						*/
						$bodycetak.= "
								<td>".number_format_sikad($totalnilaiakhir,2,'.',',')."</td>
								<td>".number_format_sikad($totalbobotsemua,2,'.',',')."</td>
								<td colspan=2></td>
					</tr>
					<tr class=juduldata$cetak align=center>
						<td colspan=3 align=right>Rata-rata</td>";
						/*
						foreach ($kp as $k=>$v) {
							echo "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]]/($i-1),2,'.',',')."</td>
							";
						}
						*/
						$bodycetak.= "
								<td>".number_format_sikad($totalnilaiakhir/($i-1),2,'.',',')."</td>
								<td>".number_format_sikad($totalbobotsemua/($i-1),2,'.',',')."</td>
								<td colspan=2> </td>
					</tr>
				";

				$bodycetak.= "
					</tbody>
				</table>
			</div>
			</div>
			</div>
		</form>
	</div>
		";
		 echo $bodycetak;
			} else {
				$errmesg="Data mahasiswa yang mengambil mata kuliah ini belum ada";
				printmesg($errmesg);
			}
		}
}
?>
