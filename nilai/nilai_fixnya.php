<?
#echo $aksi.'llll'.$pilihan;exit();
periksaroot();
//cekhaktulis($kodemenu);

    				$updatenilai=0;
if ($aksitambah=="Update"  && $REQUEST_METHOD==POST ) {
//Husnil
//<code : begin>
if ($_POST['sessid'] != $_SESSION['token'])
{
	$errmesg = token_err_mesg('Nilai',SIMPAN_DATA);
}else{
	unset($_SESSION['token']);
//<code : end>
	#print_r($pilihupdate);exit();
	if (is_array($pilihupdate)) {
	   if ($pilihan=="ntambah") {
    		$jmlaf=0;		
    		 $q="
    			SELECT IDKOMPONEN,NAMA  FROM komponen
    			WHERE IDMAKUL='$idmakulupdate'
    			AND TAHUN='$tahunupdate'
    			AND SEMESTER='$semesterupdate'
    			AND IDDOSEN='$iddosenupdate'
    			AND KELAS='$kelasupdate'
    			AND IDPRODI='$idprodiupdate'
    		";
    		$h=doquery($q,$koneksi);
    		if (sqlnumrows($h)>0) {
    			while ($d=sqlfetcharray($h)) {
    				$kp[]=$d[IDKOMPONEN];
					$namakomponen[$d[IDKOMPONEN]] = $d[NAMA];
     			}
//Husnil 
//<code : begin>
				$vld[] = cekvaliditaskodemakul('Kode Makul',$idmakulupdate);
				$vld[] = cekvaliditaskodeprodi('Kode Prodi',$idprodiupdate);
				$vld[] = cekvaliditasthnajaran('Tahun Akademik',$tahunupdate,$semesterupdate);
				$vld[] = cekvaliditasinteger('Kelas',$kelasupdate,2);
				$vld[] = cekvaliditaskode('Dosen',$iddosenupdate);
				foreach($data as $nimid => $v21)
				{
				 if ($pilihupdate[$nimid]==1) {
  					foreach($v21 as $k2 => $v2)
  					{
  						$vld[] = cekvaliditasnumerik("Nilai '$namakomponen[$k2]' untuk NIM $nimid : $v2",$v2,5);
  					}
					}
				}
				$vld = array_filter($vld,'filter_not_empty');
				if(isset($vld) && count($vld) > 0)
				{
					$errmesg = val_err_mesg($vld,2,SIMPAN_DATA);
				}else{
//<code : end>

    			foreach ($data as $k=>$v) {
				   if ($pilihupdate[$k]==1) {
    				//echo $k;
    						foreach ($kp as $kk=>$vk) {
     							 $q="
    								INSERT INTO nilai (IDMAHASISWA,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NILAI,SEMESTER)
    								VALUES
    								('$k','$vk','$idmakulupdate','$tahunupdate','$kelasupdate','".$v[$vk]."','$semesterupdate')
    							
    							";
     							doquery($q,$koneksi);
     							if (sqlaffectedrows($koneksi)>0) {
    
    								$ketlog="Tambah Data Nilai dengan 
    								ID Makul=$idmakulupdate, 
    								Tahun Akademik=".($tahunupdate-1)."/$tahunupdate,
    								Semester=".$arraysemester[$semesterupdate].",
    								Kelas=$kelasupdate,
    								ID Komponen=$vk,
    								ID Mahasiswa=$k,
    								Nilai=".$v[$vk]."
    								";
    								buatlog(33);
    
    
    								$jmlaf++;
    							} else {
    				 				 $q="
    									UPDATE nilai SET 
    									NILAI='".$v[$vk]."'
    									WHERE
    									IDMAKUL='$idmakulupdate' AND
    									TAHUN='$tahunupdate' AND 
										SEMESTER='$semesterupdate' AND
    									KELAS='$kelasupdate' AND
    									IDMAHASISWA='$k' AND
    									IDKOMPONEN='$vk'
    									
    								";
    								doquery($q,$koneksi);
    									$jmlaf++;
     								if (sqlaffectedrows($koneksi)>0) {
    									$ketlog="Update Data Nilai dengan 
    									ID Makul=$idmakulupdate, 
    									Tahun Akademik=".($tahunupdate-1)."/$tahunupdate,
    									Semester=".$arraysemester[$semesterupdate].",
    									Kelas=$kelasupdate,
    									ID Komponen=$vk,
    									ID Mahasiswa=$k,
    									Nilai=".$v[$vk]."
    									";
    									buatlog(34);
    								}
    							}
    						}
    					}
    	 		}
    			if ($jmlaf>0) {
    				$errmesg="Data nilai   berhasil diupdate";
    				$updatenilai=1;
    			} else {
    				$errmesg="Data nilai tidak diupdate";
    			}
    		}
		}
    } else {
			
//Husnil 
//<code : begin>
				$vld[] = cekvaliditaskodemakul('Kode Makul',$idmakulupdate);
				$vld[] = cekvaliditaskodeprodi('Kode Prodi',$idprodiupdate);
				$vld[] = cekvaliditasthnajaran('Tahun Akademik',$tahunupdate,$semesterupdate);
				$vld[] = cekvaliditasinteger('Kelas',$kelasupdate,2);
				$vld[] = cekvaliditaskode('Dosen',$iddosenupdate);
        foreach(/*$datamahasiswa*/ $pilihupdate as $nimid => $v21)
				{
     		  $str="data_".$nimid."_NILAI";
    		  $data[$nimid][NILAI]=$$str;


     		  $str="data_".$nimid."_BOBOT";
    		  $data[$nimid][BOBOT]=$$str;
    		  $str="data_".$nimid."_SIMBOL";
    		  $data[$nimid][SIMBOL]=$$str;
          $v21=$data[$nimid];
					$vld[] = cekvaliditasnilaibobot("Nilai BOBOT NIM $nimid : $v21[BOBOT]",$v21[BOBOT],5);
					$vld[] = cekvaliditasnilaihuruf("Nilai SIMBOL NIM $nimid : $v21[SIMBOL]",$v21[SIMBOL],5);
				}
				$vld = array_filter($vld,'filter_not_empty');
				if(isset($vld) && count($vld) > 0)
				{
					$errmesg = val_err_mesg($vld,2,SIMPAN_DATA);
				}else{
//<code : end>
				#print_r($data);exit();
				foreach ($data as $k=>$v) {
//						NILAI='$v[NILAI]',

					$q="UPDATE pengambilanmk SET
						NILAI='$v[NILAI]',
						SIMBOL='$v[SIMBOL]',
						BOBOT='$v[BOBOT]'
						WHERE IDMAHASISWA='$k'
						AND pengambilanmk.IDMAKUL='$idmakulupdate'
						AND pengambilanmk.TAHUN='$tahunupdate'
						AND pengambilanmk.SEMESTER='$semesterupdate'
						AND pengambilanmk.KELAS='$kelasupdate'
					";
					doquery($q,$koneksi);
      //  echo $q.mysqli_error($koneksi);
					 $q="UPDATE trnlm SET
						NLAKHTRNLM='$v[SIMBOL]',
						 
						BOBOTTRNLM='$v[BOBOT]'
						WHERE NIMHSTRNLM='$k'
						AND trnlm.KDKMKTRNLM='$idmakulupdate'
						AND trnlm.THSMSTRNLM='".($tahunupdate-1)."$semesterupdate' 
					 
					";
					doquery($q,$koneksi);    
  				$ketlog="Edit Nilai Mahasiswa $k, MK=$idmakulupdate, TAHUN=$tahunupdate/".($tahunupdate+1).", SEM=$semesterupdate, NILAI=$v[NILAI], BOBOT=$v[BOBOT], SIMBOL=$v[SIMBOL]";
    			buatlog(58);
					
					
				}
        $errmesg="Data nilai sudah diupdate.";
		}
	}
	} else {
    $errmesg="Tidak ada data yang dipilih.";
  }
	}
	$aksi="formtambah";
}



if ($aksi=="lihatdata") {
    if ($aksi=="lihatdata" && $pilihan=="ntambah") {
 	    include "prosestampileditnilai2.php";
    } elseif ($aksi=="lihatdata" && $pilihan=="ntambahm") {
	   include "prosestampileditnilaim2.php";
    }

}

unset($kp);

  //echo "$aksi";
if ($aksi=="formtambah") {
	#echo $aturaneditnilai."vvv".$pilihan;
///
   //echo $jenisusers.$aturaneditnilaidosen;
  if ($jenisusers==1 && $aturaneditnilaidosen==0) {
    echo "Maaf, Anda tidak dapat mengedit nilai.";
    exit; 
  } else {
      $aturaneditnilai=getaturan("EDITNILAI");
	  #echo $aturaneditnilai."vvv".$pilihan;
    //echo $pilihan;
    if ($aturaneditnilai==1 && $pilihan!="editmhs") { // Periksa Testing 
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
				AND SIMBOL=''
				ORDER BY mahasiswa.ID
			";
     $ht=doquery($q,$koneksi);
     //echo "jumlah nilai: ".sqlnumrows($ht);
     if (sqlnumrows($ht)>0) { // Ada nilai yang belum masuk
      session_register_sikad("statusnilai");
      $_SESSION[statusnilai]=1;
      //echo "Boleh Entri tanpa Password";
      } else {
      //echo "Minta Password";
      //session_unregister_sikad("statusnilai");
     // $statusnilai=0;
      }
      
    } elseif ($aturaneditnilai==1 && $pilihan=="editmhs") {
     	  $q="
    				SELECT mahasiswa.NAMA,mahasiswa.ID ,
    				pengambilanmk.SIMBOL,pengambilanmk.BOBOT
    				FROM mahasiswa,pengambilanmk
    				WHERE 
    				mahasiswa.ID='$id' AND
            mahasiswa.ID=pengambilanmk.IDMAHASISWA
     				AND SIMBOL=''
    				LIMIT 0,1
    			";
         $ht=doquery($q,$koneksi);
         if (sqlnumrows($ht)>0) { // Ada nilai yang belum masuk
            session_register_sikad("statusnilai");
            $_SESSION[statusnilai]=1;
          }  
    }    else {
      session_register_sikad("statusnilai");
      $_SESSION[statusnilai]=1;
    }
  }

///  
  if (!session_is_registered_sikad("statusnilai") || $_SESSION[statusnilai]!=1) {
	#echo "lll";
    include "passwordnilai.php";
  } elseif (session_is_registered_sikad("statusnilai") && $_SESSION[statusnilai]==1) {
    if ($aksi=="formtambah" && $pilihan=="ntambah") {
		#echo "kkk";
 	    include "prosestampileditnilai.php";
    } elseif ($aksi=="formtambah" && $pilihan=="ntambahm") {
		#echo "ccc";exit();
	   include "prosestampileditnilaim.php";
    } elseif ($aksi=="formtambah" && $pilihan=="editmhs") {
		#echo "aaa";
      include "proseseditnilaimahasiswa.php";
    }
  }
}
 
if ($aksi=="tampilkanawal") {
	#echo "jjj";
	$aksi="";
	session_unregister_sikad("statusnilai");
  	include "prosestampilnilaiawal.php";
}
 
 if ($aksi=="tampilkan") {
	$aksi=" ";
	include "prosestampilnilai.php";
}

if ($aksi=="tambahawal") { 
  if ($pilihan=="ntambah") {
    $judultambahan="(Otomatis)";
  } elseif($pilihan=="ntambahm") {
    $judultambahan="(Manual)";
  }
	#echo $judultambahan;
	printjudulmenu("Edit Nilai Mata Kuliah $judultambahan ");
	printmesg($errmesg);
	session_unregister_sikad("statusnilai");
	echo "
		<form name=form action=index.php method=post>
			<input type=hidden name=pilihan value='$pilihan'>
			<input type=hidden name=aksi value='tampilkanawal'>
			<table class=form>
 			<tr>	
				<td class=judulform>
					Jurusan/Program Studi
				</td>
				<td>
					<select class=masukan name=idprodi>
						 ";
						foreach ($arrayprodidepmakul as $k=>$v) {
							echo "<option value='$k'>$v</option>";
						}
						echo "
					</select>
				</td>
			</tr>";
		if ($jenisusers==0) { 
			echo "
  		<tr >
			<td class=judulform>NIDN Dosen </td>
			<td>".
		createinputtext("iddosen",$iddosen," class=masukan  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" ").
			"
			<a 
			href=\"javascript:daftardosen('form,wewenang,iddosen',
			document.form.iddosen.value)\" >
			daftar dosen
			</a>
               <div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
               <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\">
			
			
			</td>
		</tr>";
		}
		echo
 		"<tr class=judulform>
			<td>Kode Mata Kuliah</td>
			<td>".
		createinputtext("idmakul",$idmakul," class=masukan  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\"").
			"
			<a 
			href=\"javascript:daftarmakul('form,wewenang,idmakul',
			document.form.idmakul.value)\" >
			daftar mata kuliah
			</a>
               <div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
               <div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\">
			
			</td>
		</tr> 

 			<tr>	
				<td>
					Tahun Akademik / Semester
				</td>
				<td>".createinputtahunajaransemester(0 )." 
				</td>
			</tr>";

			$arraylabelkelas[""]="Semua";
 
      echo "
 
 		 <tr class=judulform>
			<td>Kelas</td>
			<td>		 
".createinputselect("kelas",$arraylabelkelas,$kelas,"","")."

              
      
      </td>
		</tr> 
			<tr>
				<td colspan=2>
					<input type=submit value='Lanjut' class=masukan>
				</td>
			</tr>
		</table>
		</form>
 	";
}

if ($aksi=="tambahawalm") { 
	printjudulmenu("Edit Nilai Mata Kuliah per Mahasiswa");
	printmesg($errmesg);
	session_unregister_sikad("statusnilai");
	echo "
		<form name=form action=index.php method=post>
			<input type=hidden name=pilihan value='$pilihan'>
			<input type=hidden name=aksi value='formtambah'>
			<table class=form>

 		<tr class=judulform>
			<td>NIM</td>
			<td>".
		createinputtext("id",$id," class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" ").

			"
			<a 
			href=\"javascript:daftarmhs('form,wewenang,id',
			document.form.id.value)\" >
			daftar mahasiswa
			</a>
               <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
               <div class=\"suggestionList\" id=\"autoSuggestionsList\">
			
			</td>
		</tr>

   	 <tr class=judulform>
 			<tr>
				<td colspan=2>
					<input type=submit value='Lanjut' class=masukan>
				</td>
			</tr>
		</table>
		</form>
 	";
}
 

?>
