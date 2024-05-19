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
#echo "JENIS=".$jenisusers.'<br>';
#print_r($tingkataksesusers).'<br>';
#echo '<br>';
#echo "TINGKAT=".$tingkataksesusers.'<br>';
#echo "KODE=".$kodemenu.'<br>';
if (
      (
        (
          $jenisusers==0 /*APAKAH OPERATOR??*/ 
          && $tingkataksesusers[$kodemenu]=="B" /*APAKAH PUNYA HAK AKSES TULIS??*/
        ) 
        || //ATAU
        (
          $jenisusers==1 /*APAKAH DOSEN??*/ 
          && $aturaneditnilaidosen==1 /*APAKAH ATURAN MEMBOLEHKAN DOSEN ENTRI NILAI*/
          && $users==$iddosenupdate
          && isdosenpengajar($iddosenupdate,$idmakulupdate,$tahunupdate,$semesterupdate,$kelasupdate,$idprodiupdate)
        )
      )
    ) {		
  printmesg("Maaf, Anda tidak punya hak untuk menggunakan fasilitas ini..");
  exit; // TIDAK PUNYA HAK
}				

//PERIKSA APAKAH WAKTU ENTRI NILAI SUDAH DI SETTING?
#if($jenisusers==0 && && $tingkataksesusers[$kodemenu]=="T"){
#	$waktuinputnilai=getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate);
#	echo "WAKTU INPUT NILAI";
#}

$waktuinputnilai=getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate);
echo "WAKTU INPUT NILAI=".$waktuinputnilai;

// PERIKSA APAKAH DOSEN YANG MASUK KE SINI BATAS WAKTU ENTRI NYA HABIS???
if (
      (
        $jenisusers==1 /*APAKAH DOSEN??*/
        && 
        $aturaneditnilaidosen==1 /*APAKAH ATURAN MEMBOLEHKAN????*/
        && getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate) /*APAKAH WAKTU HABIS??*/
      )
    ) {
		#echo "KEMANA=".getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate);
	if ($aksi!="cetak") {
   printmesg("Maaf, waktu untuk entri nilai sudah habis. Silakan kontak operator untuk menyelesaikan entri nilai jika memang entri nilai belum selesai.");
  }
   include "prosestampileditnilaim2.php";
 
} else {
    // KALAU DOSEN, DAN WAKTUNYA BELUM HABIS, TAMPILKAN BATAS WAKTUNYA
	#echo "KESINI";
	#echo '<br>';
	#echo $jenisusers.$aturaneditnilaidosen;
	#echo '<br>';
    if (($jenisusers==1 && $aturaneditnilaidosen==1 && (getwaktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate))==0)) {
		  echo "MASUK SINI GA";
		  echo '<br>';
        $tanggalselesai=waktueditnilai($tahunupdate,$semesterupdate,$idprodiupdate);
        $trtanggal="
          <tr>
            <td><b>Batas Akhir Entri Nilai</td>
            <td><b>: $tanggalselesai</td>
          </tr>
        ";
      }



//@$konf=file("konfig");
//if (is_array($konf)) {
//	if (trim($konf[0])=="1") {
	
        // KONVERSI UMUM
			$q="
				SELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum
				ORDER BY NILAI DESC
			";
			#echo $q;
      $hb=doquery($q,$koneksi);
      unset($arraybobotnilai);
      if (sqlnumrows($hb)) {
        while ($db=sqlfetcharray($hb)) {
          $arraybobotnilai["$db[SIMBOL]"]="$db[NILAI]";
		  $arraybobotnilai2["$d[SYARAT]"]="$d[SIMBOL]";
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
			#echo $q;
			$h=doquery($q,$koneksi);
			$bodycetak.= mysqli_error($koneksi);
			if (sqlnumrows($h)>0) {
  		  unset($arraybobotnilai);
		  unset($arraybobotnilai2);
 				while ($d=sqlfetcharray($h)) {
				$arraybobotnilai["$d[SIMBOL]"]="$d[NILAI]";
				//$arraybobotnilai["$d[SYARAT]"]["$d[SIMBOL]"]="$d[NILAI]";
				$arraybobotnilai2["$d[SYARAT]"]="$d[SIMBOL]";
				#$arraybobotnilai2["$d[SIMBOL]"]="$d[NILAI]";
 	 			}		
			}
          
      
      // KONVERSI KHUSUS
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversi
				WHERE 
				IDMAKUL='$idmakulupdate'
				AND TAHUN='$tahunupdate'
				AND SEMESTER='$semesterupdate'
				AND KELAS='$kelasupdate'
				ORDER BY NILAI DESC
				";
			#echo $q;
				$h=doquery($q,$koneksi);
				if (sqlnumrows($h)>0) {
  		    unset($arraybobotnilai);
 					while ($d=sqlfetcharray($h)) {
             $arraybobotnilai["$d[SIMBOL]"]="$d[NILAI]";
					}		
				}  
		/*print_r($arraybobotnilai);
		echo 'AAA<br>';
		echo '<br>';
		print_r($arraybobotnilai2).'BB';*/
       if (is_array($arraybobotnilai)) {
			#print_r($arraybobotnilai);
      		$bodycetak.= "
          <script>
            function setbobot(nilai,bobot) { 
			//var simbolbesar=nilai.value.toUpperCase();
			var lowerCaseLetters = /[a-z]/g;
			if(nilai.value.match(lowerCaseLetters)){
				alert('Simbol Huruf Harus Kapital');
			}
			//alert('bobot pertama'+nilai.value);
			";
              foreach ($arraybobotnilai as $k=>$v) {
				  #echo "NILAINYA=".$k."=".$v.'<br>';
				  $nilainya .=$k.' = '.$v.", ";
				  #$nilaistring .=substr($nilainya, 0, -1);
				  #echo "PAP=".$nilainya; 
				  
                $bodycetak.= "
                if (nilai.value=='$k') {
                  bobot.value='$v';
                } /*else{
					bobot.value='';
				}*/
                ";
              }
               $bodycetak.= "
               {
               }
            }
			function setbobot2(nilai2,bobot2) { 
			//alert('bobot kedua'+nilai2.value);
			";
              foreach ($arraybobotnilai2 as $k2=>$v2) {
				  #echo "NILAI BOBOT PAPA=".$k2."=".$v2.'<br>';
				  $nilaibobotnya .=$k2.'='.$v2." , ";
				  #$nilaibobotstring .=substr($nilaibobotnya, 0, -1);
                $bodycetak.= "
                if (nilai2.value>='$k2') {
                  bobot2.value='$v2';
                } /*else{
					bobot.value='';
				}*/
                ";
              }
               $bodycetak.= "
               {
               }
            }
          </script>
          
          ";
	     }
		 #$?nilaistring = substr($nilainya,0,-1);
		 
 //	}  
//}

//Husnil
//<code : begin>
if ($aksi!="cetak") {
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
}
//<code : end>

	if ($jenisusers==1 ) {
	 $iddosen=$users;
  }


	$konversisemua=0;
	@$konf=file("konfig");
	#print_r($konf);
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
 //		printjudulmenucetak("Data Nilai");
//		printmesgcetak($errmesg);
		$bodycetak="<h3>Rincian Data Nilai</h3>";
	}*/
 		/*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Ganti Password </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	
								
								
	$bodycetak.="				<div class='portlet-body form'>	
									<div class=\"table-scrollable\">
										<table  class=\"table table-striped table-bordered table-hover\">".
											"$trtanggal
											<tr  >
													<td  class='loseborder'>Prodi</td>
													<td  class='loseborder'>:  ".$arrayprodidep[$idprodiupdate]."</td>
											</tr>
											<tr  >
													<td  class='loseborder'>Mata Kuliah</td>
													<td  class='loseborder'>: $idmakulupdate, ".getnamamk("$idmakulupdate","".($tahunupdate-1)."$semesterupdate",$idprodiupdate)."</td>
											</tr>".
											"<tr  >
													<td  class='loseborder'>Tahun Akademik</td>
													<td  class='loseborder'>: ".($tahunupdate-1)."/$tahunupdate			
													</td>
											</tr>".
											"<tr >
													<td  class='loseborder'>Semester</td>
													<td  class='loseborder'>: ".$arraysemester[$semesterupdate]."			
													</td>
											</tr>".
											"<tr >
													<td class='loseborder'>Dosen Pengajar</td>
													<td  class='loseborder'>: $iddosenupdate, ".getnamafromtabel($iddosenupdate,"dosen")."</td>
											</tr>".
											"<tr  >
													<td   class='loseborder'>Kode Kelas</td>
													<td  class='loseborder'>: ".$arraylabelkelas[$kelasupdate]."</td>
											</tr>".
											"<tr  >
													<td   class='loseborder'>PAP</td>
													<td  class='loseborder'>: ".substr($nilaibobotnya,0,-2)."</td>
											</tr>".
											"
										</table>
									</div><div class=\"caption\">";
	$bodycetak .="						<div class=\"alert alert-success\"> Rincian Data Nilai Mahasiswa</div>";
	$bodycetak .="					</div>";
    /*		
		if ($konversisemua==1) {
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversiumum
				ORDER BY NILAI DESC
			";
			
			$h=doquery($q,$koneksi);
			if (sqlnumrows($h)>0) {
				while ($d=sqlfetcharray($h)) {
					$kon[]=$d;
	 			}		
			}
		}
    */
 
 
 		#if ($pdf!=1 && $aksi!="cetak") {
     #printjudulmenukecil("Rincian Data Nilai Mahasiswa");
 		#}
 		
 		
 		
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
		if ($konversisemua==0) {
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversi
				WHERE 
				IDMAKUL='$idmakulupdate'
				AND TAHUN='$tahunupdate'
				AND SEMESTER='$semesterupdate'
				AND KELAS='$kelasupdate'
				ORDER BY NILAI DESC
			";
			
			$h=doquery($q,$koneksi);
			if (sqlnumrows($h)>0) {
				while ($d=sqlfetcharray($h)) {
					$kon[]=$d;
	 			}		
			}
		}
    */


       $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmk.SIMBOL,pengambilanmk.BOBOT,pengambilanmk.NILAI
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

/*
     $q="
				SELECT mahasiswa.NAMA,mahasiswa.ID ,
				pengambilanmk.SIMBOL,pengambilanmk.BOBOT
				FROM mahasiswa,pengambilanmk,tbkmk,msmhs
				WHERE 
				mahasiswa.ID=pengambilanmk.IDMAHASISWA
				AND pengambilanmk.IDMAKUL='$idmakulupdate'
				AND pengambilanmk.TAHUN='$tahunupdate'
				AND pengambilanmk.SEMESTER='$semesterupdate'
				AND pengambilanmk.KELAS='$kelasupdate'
				AND tbkmk.KDKMKTBKMK=pengambilanmk.IDMAKUL
				AND tbkmk.THSMSTBKMK=concat(pengambilanmk.TAHUN-1,pengambilanmk.SEMESTER)
 				AND msmhs.NIMHSMSMHS=mahasiswa.ID
				AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK
				$qprodidep5
				$qprodideptbkmk
				ORDER BY mahasiswa.ID
			";

*/

			#echo $q;
			$h=doquery($q,$koneksi);
			//$bodycetak.= mysqli_error($koneksi);	
			if (sqlnumrows($h)>0) {
		 		if ($aksi!="cetak") {
					/*/$bodycetak.= "
						<table class=\"table table-striped table-bordered table-hover\">
						<tr><td>
					<form target=_blank action='cetaktampilnilaim.php'>
		 				<input type=submit name=aksi class=tombol value='Cetak' class=\"btn green\">
						 <input type=checkbox name=pdf value=1> PDF
						 <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> 
									
						<script>
						jQuery(document).ready(function () {
							jQuery('a.settingpdf').colorbox();
						});
					</script>
				".*/
				$bodycetak .="	<div class=\"tools\">
									<form target=_blank action='cetaktampilnilaim.php'>
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>
													".
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
											<tr class=juduldata$cetak align=center>
												<td class=juduldata align=right colspan=".(7+count($kp))."> 
												 <input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td>
											</tr>";
										}
											$bodycetak.= "
											<tr class=juduldata$cetak align=center>
												<td  align=center ><b>No</td>
												<td  align=center ><b>NIM</td>
												<td  align=center ><b>Nama</td>";
												/*foreach ($kp as $k=>$v) {
													$bodycetak.= "
														<td>$v[NAMA] ($v[BOBOT]%)</td>
													";
												}
												*/
							   if ($UNIVERSITAS=="UNM") {
							   } else {
		$bodycetak.= "
											<td  align=center ><b>Nilai Akhir</td>";
										 }
		$bodycetak.= "
											<td  align=center  ><b>Simbol</td>
											<td   align=center ><b>Bobot</td>";
										if ($aksi!="cetak") {
		$bodycetak.= "
											<td  align=center ><b>Pilih</td>";
										}						
		$bodycetak.= "
											</tr>
										</thead>
									<tbody>
									";
				$i=1;
				$totalbobot=0;
				while ($d=sqlfetcharray($h)) {
				   
					if (session_is_registered_sikad("prodis") && $_SESSION[prodis]!="") {
						$q=		"SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML 
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
					$kelas=kelas($i);
					if($d[ID]==61111036){
				
						$d[ID]='61111036.';
					
					}else{
					
						if($d[ID]==61112071){
						
							$d[ID]=61112071.;
							
						}else{						
					
							$d[ID]=$d[ID];
							
						}
					}
					$bodycetak.= "
						<tr $kelas$cetak  align=center>
							<td class=tdborder align=center>$i</td>
	
							<td class=tdborder align=left nowrap>$d[ID]</td>
							<td class=tdborder align=left nowrap>$d[NAMA]</td>";
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
								//	$bodycetak.= "$d2[IDKOMPONEN] ".$datanilai[$d2[IDKOMPONEN]]." <br>";
								}
							}
						$nilaiakhir=0;
						foreach ($kp as $k=>$v) {
							
 
								$bodycetak.= "
 
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
 
        	   if ($UNIVERSITAS=="UNM") {
        	   } else {
						    if ( $jenisusers==1 &&  getaturan("EDITNILAIDOSEN2")==1 && $simbolakhir!="" )  {
                $bodycetak.= "
  							   <td class=tdborder align=center>  
                  ".number_format_sikad($nilaiakhir,2,'.',',')."  </td>";
                } else {
                  /*$bodycetak.="
                     <td class=tdborder align=center> 
                  ".createinputtext("data_$d[ID]_NILAI",$nilaiakhir," class=masukan size=4")." </td>
                  
                  ";*/
				  $bodycetak.="
					<td class=tdborder>
						<input type='text' size=\"4\" onblur=\"setbobot2(data_".$d[ID]."_NILAI,data_".$d[ID]."_SIMBOL);\" id=\"data_".$d[ID]."_NILAI\" class=\"masukan\" value='$nilaiakhir' name=\"data_$d[ID]_NILAI\"></td>
					";
                }
			}
						
						if ($aksi=="cetak") {
              $bodycetak.= "
							<td class=tdborder align=center>$nilaiekakhir </td>
							<td class=tdborder align=center> $simbolakhir </td>";
            
            } else {
              
              // $jenisusers==1 /*APAKAH DOSEN??*/
              //&& 
              //getaturan("EDITNILAIDOSEN2")==1 
              if ( $jenisusers==1 &&  getaturan("EDITNILAIDOSEN2")==1 && $simbolakhir!="" )  {
               $bodycetak.= "
  							
  							<td class=tdborder align=center> $simbolakhir </td>
							<td class=tdborder align=center>$nilaiekakhir </td>
  							<td class=tdborder align=center> - </td>
                
                ";
             
              }  else {
				
				list($a,$b)=explode(".",$d[ID]);
				$nama=substr($d[ID], -1);
				if($nama=="."){
						
						$a=$a;
				
				}else{
				
						$a=$d[ID];
				}
				$bodycetak.= "
				<td class=tdborder><input type='text' size=\"4\" onblur=\"setbobot(data_".$a."_SIMBOL,data_".$a."_BOBOT);\" id=\"data_".$a."_SIMBOL\" class=\"masukan\" value='$simbolakhir' name=\"data_$d[ID]_SIMBOL\"></td>
  							<td class=tdborder> 
  							<input type=hidden name='datamahasiswa[$d[ID]]' value=1>
                <input type='text' size=\"4\" class=\"masukan\" value='$nilaiekakhir' name=\"data_$d[ID]_BOBOT\" id=\"data_".$a."_BOBOT\" readonly></td>
  							";
  
  						$bodycetak.= "
  						<td align=center class=tdborder><input type=checkbox name='pilihupdate[$d[ID]]' value=1></td>";
                /*$bodycetak.= "$a[nama],$nama,$a,$b
  							<td class=tdborder> 
  							<input type=hidden name='datamahasiswa[$d[ID]]' value=1>
                ".createinputtext("data_".$a."_BOBOT",$nilaiekakhir," class=masukan size=4")." </td>
  							<td class=tdborder>".createinputtext("data_".$a."_SIMBOL",$simbolakhir," class=masukan size=4
                onBlur=\"setbobot(data_".$a."_SIMBOL,data_".$a."_BOBOT);\"
                ")." </td>";
  
  						$bodycetak.= "
  						<td align=center class=tdborder><input type=checkbox name='pilihupdate[$d[ID]]' value=1></td>";*/
  
              }
             }
              $dpna[substr($simbolakhir,0,1)]++;
              
             $bodycetak.= "
						</tr>
					";
/*					
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
 */  
					 $q="UPDATE trnlm SET
						NLAKHTRNLM='$simbolakhir',
						 
						BOBOTTRNLM='$nilaiekakhir'
						WHERE NIMHSTRNLM='$d[ID]'
						AND trnlm.KDKMKTRNLM='$idmakulupdate'
						AND trnlm.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
					 
					";
					doquery($q,$koneksi);
        

					$totalbobotsemua+=$nilaiekakhir;
					$totalbobot+=$d[BOBOT];
					$i++;
 				}			
				$bodycetak.= " 
					<tr class=juduldata$cetak align=center>
						<td class=tdborder colspan=3 align=right>Total</td>";
						/*
						foreach ($kp as $k=>$v) {
							$bodycetak.= "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]],2,'.',',')."</td>
							";
						}
						*/
      	   if ($UNIVERSITAS=="UNM") {
      	   } else {
						$bodycetak.= "
								<td class=tdborder align=center>".number_format_sikad($totalnilaiakhir,2,'.',',')."</td>";
					}
                $bodycetak.= "
								<td class=tdborder align=center>".number_format_sikad($totalbobotsemua,2,'.',',')."</td>
								<td class=tdborder colspan=2>&nbsp;</td>
					</tr>
					<tr class=juduldata$cetak align=center>
						<td class=tdborder colspan=3 align=right>Rata-rata</td>";
						/*
						foreach ($kp as $k=>$v) {
							$bodycetak.= "
								<td>".number_format_sikad($total[$v[IDKOMPONEN]]/($i-1),2,'.',',')."</td>
							";
						}
						*/
	   if ($UNIVERSITAS=="UNM") {
	   } else {
						$bodycetak.= "
								<td class=tdborder align=center>".number_format_sikad($totalnilaiakhir/($i-1),2,'.',',')."</td>";
								}
                $bodycetak.= "
								<td class=tdborder align=center> ".number_format_sikad($totalbobotsemua/($i-1),2,'.',',')."</td>
								<td class=tdborder colspan=2>&nbsp;</td>
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
				if ($UNIVERSITAS=="UNM") {
        $bodycetak.= "
				<table class=\"table table-striped table-bordered table-hover\">
				  <tr>
				  <td> REKAPITULASI DPNA </td>
          </tr>
				  <tr>
				  <td> 
          NILAI A = ".($dpna["A"]+0)." Orang <br>
          NILAI B = ".($dpna["B"]+0)." Orang <br>
          NILAI C = ".($dpna["C"]+0)." Orang <br>
          NILAI D = ".($dpna["D"]+0)." Orang <br>
          NILAI E = ".($dpna["E"]+0)." Orang <br>
          NILAI T = ".($dpna["T"]+0)." Orang <br>
          NILAI K = ".($dpna["K"]+0)." Orang <br>
          </td>
          </tr>
				</table>
				<br>
				<table  class=\"table table-striped table-bordered table-hover\">
				  <tr>
				  <td align=right>Penanggung Jawab Mata Kuliah </td>
          </tr>
				  <tr>
				  <td align=right> 
              <br><br><br><br>
               <u>$iddosenupdate</u><br>
               ".getnamafromtabel($iddosenupdate,"dosen")."
          </td>
          </tr>
				</table>				
				<br><br>";
				}

    		if ($pdf==1) {
          cetakpdf($bodycetak,$stylecetak )		;	
    		
         } else {
    		  echo $stylecetak.$bodycetak;
    		}


			} else {
				$errmesg="Data mahasiswa yang mengambil mata kuliah ini belum ada";
				printmesg($errmesg);
			}
		}
		
}
?>
