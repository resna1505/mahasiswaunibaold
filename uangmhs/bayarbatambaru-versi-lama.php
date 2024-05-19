<?
periksaroot();
cekhaktulis($kodemenu);

      $q="SELECT * FROM aturan ";
      $h2=mysqli_query($koneksi,$q);
      if (sqlnumrows($h2)>0) {
        $d2=sqlfetcharray($h2);
        $aturankeuangan=$d2[KRSONLINE];
      }

printjudulmenu("Pembayaran Keuangan Mahasiswa");



if ($aksi=="Lanjut") {
  if (getfieldfromtabel($idmahasiswa,"ID","mahasiswa" )=="") {
    $errmesg="Data Mahasiswa dengan ID $idmahasiswa tidak ada.";
    $aksi="";
  } else {
  
   
      if ($aksi2=="hapus") {

        if (getaturan("KEUANGAN")==0 ||  (getaturan("KEUANGAN")==1 &&  issupervisor($users)) ) {

        if ($_GET['sessid'] != $_SESSION['token']) {
         	$errmesg = token_err_mesg('Keuangan',HAPUS_DATA);
          $aksi2="Data Baru";
        } else {

           $q="DELETE FROM bayarkomponen WHERE ID='$idhapus'";
           mysqli_query($koneksi,$q);
           if (sqlaffectedrows($koneksi)>0) {
            $errmesg="Data berhasil dihapus";
            $q="SELECT ID FROM transkeuangan WHERE KODE='BK-$idhapus'";
            $h=mysqli_query($koneksi,$q);
            if (sqlnumrows($h)>0) {
              $d=sqlfetcharray($h);
              $q="DELETE FROM detilkeuangansgm WHERE IDTRANS='$d[ID]'";
              mysqli_query($koneksi,$q);
              $q="DELETE FROM transkeuangan WHERE ID='$d[ID]'";
              mysqli_query($koneksi,$q);
            }
           }

        }
        }
          $aksi2="Data Baru";
      }
  
      if ($aksi2=="Simpan") {
        if ($_POST['sessid'] != $_SESSION['token']) {
         	$errmesg = token_err_mesg('Keuangan',SIMPAN_DATA);
          $aksi2="Data Baru";
        } else {
        
        
        $qperiode="";
          if ( $arrayjeniskomponenpembayaran[$idkomponen]==2) { // Tahunan
          $qperiode=" AND TAHUNAJARAN='$tahunajaran'";
        } else if ( $arrayjeniskomponenpembayaran[$idkomponen]==3) { // Semesteran
          $qperiode=" AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester' ";
        } else if ( $arrayjeniskomponenpembayaran[$idkomponen]==5) { // Bulanan
          $qperiode=" AND TAHUNAJARAN='$tahunbulan' AND SEMESTER='$bulan' ";
        } else if ( $arrayjeniskomponenpembayaran[$idkomponen]==6) { // Cuti
            //$tahunc=substr($semestercuti,0,4)+1;
            // $semesterc=substr($semestercuti,4,1);
          $qperiode=" AND TAHUNAJARAN='$tahunc' AND SEMESTER='$semesterc' ";
        }
        
        
          $q="SELECT * FROM bayarkomponen WHERE 
        IDMAHASISWA='$idmahasiswa' AND 
        TANGGALBAYAR=DATE_FORMAT('$tgl[thn]-$tgl[bln]-$tgl[tgl]','%Y-%m-%d') AND 
        IDKOMPONEN='$idkomponen' AND JUMLAH='$bayar' 
        $qperiode
        LIMIT 0,1";
        $hx=mysqli_query($koneksi,$q);
        if (sqlnumrows($hx)>0) {
          $errmesg="Maaf sudah ada pembayaran dengan ID Komponen $idkomponen (".$arraykomponenpembayaran[$idkomponen].") pada tanggal $tgl[thn]-$tgl[bln]-$tgl[tgl] untuk mahasiswa $idmahasiswa";
            $aksi2="Lanjut";
        } else {
        
        
          unset($_SESSION['token']);
        if ($idkomponen!="") {
          if ($bayar+$diskon <= 0) {
            $errmesg="Total pembayaran dan diskon (".cetakuang($bayar+$diskon).") harus diisi lebih dari Nol. 
            Proses penyimpanan tidak dilakukan.";
            $aksi2="Lanjut";
          } else
          if ($bayar+$diskon > $sisa ) {
            $errmesg="Total pembayaran dan diskon (".cetakuang($bayar+$diskon).") lebih daripada sisa yang harus dibayar (".cetakuang($sisa).") . 
            Proses penyimpanan tidak dilakukan.";
            $aksi2="Lanjut";
          } else {
            $errmesg="OK SIAP DISIMPAN";
            $tahunbayar=$semesterbayar="";
            if ($arrayjeniskomponenpembayaran[$idkomponen]==2)  { // TAHUNAN
                $tahunbayar=$tahunajaran;
            } else
            if ($arrayjeniskomponenpembayaran[$idkomponen]==3)  { // SEMESTER
                $tahunbayar=$tahun;
                $semesterbayar=$semester;
            } else
            if ($arrayjeniskomponenpembayaran[$idkomponen]==6)  { // Cuti
                $tahunbayar=$tahunc;
                $semesterbayar=$semesterc;
            } else
            if ($arrayjeniskomponenpembayaran[$idkomponen]==5)  { // BULANAN
                $tahunbayar=$tahunbulan;
                $semesterbayar=$bulan;
            }
            
             $q="INSERT INTO bayarkomponen 
        			(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,
              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)
        			VALUES 
        			('$idmahasiswa','$tgl[thn]-$tgl[bln]-$tgl[tgl]','$idkomponen','".$arrayjeniskomponenpembayaran[$idkomponen]."',
        			'$bayar','$ket',
        			'$tahunbayar','$semesterbayar','$carabayar','$diskon',
              NOW(),'$users',NOW(),'$denda','$biaya','$beasiswa')";
            
            //echo $q;
            mysqli_query($koneksi,$q);
            if (sqlaffectedrows ($koneksi)>0 ) {
        				$ketlog="Tambah Pembayaran dengan 
        				ID Komponen=$idkomponen (".$bayar."),ID Mahasiswa=$idmahasiswa,
        				Tanggal bayar=$tgl[thn]-$tgl[bln]-$tgl[tgl]
        				";
                buatlog(54);

        				          $jenisjurnal=$arrayakunjenisjurnal[$carabayar];
        				          $idbayar=mysqli_insert_id($koneksi);     
        				
                        	$q="SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='$jenisjurnal'";
                        	$h=mysqli_query($koneksi,$q);
                        	$d=sqlfetcharray($h);
                        	if ($d[MAX]=="") {
                        		$idbaru=1;
                        	} else {
                        		$idbaru=$d[MAX]+1;
                        	}
                        	$q="INSERT INTO transkeuangan 
                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)
                          VALUES
                          ('$idbaru','$jenisjurnal','$tgl[thn]-$tgl[bln]-$tgl[tgl]',
                        	'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM $idmahasiswa ".$tahunbayar." \ ".$arraysemesterbayar." 
                            ".$ket." ','$users',NOW(),'BK-$idbayar')";
                        
                        	//echo "$q";
                        	
                        	mysqli_query($koneksi,$q);
                          if (sqlaffectedrows($koneksi)>0) {
                          		$q="SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='$jenisjurnal' AND IDTRANS='$idbaru'";
                          		$h=mysqli_query($koneksi,$q);
                          		$d=sqlfetcharray($h);
                          		if ($d[MAX]=="") {
                          			$iddetilbaru=0;
                          		} else {
                          			$iddetilbaru=$d[MAX]+1;
                          		}
        	   
        	                     if ($carabayar==0) { // KAS
                                  $idakun=$arrayakun[kas];
                               } else {
                                  $idakun=$arrayakun[bank];
                               }
                              $q="INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)
                                  VALUES ('$iddetilbaru','$idbaru','$jenisjurnal','".($bayar+$denda)."','$tanda','".$idakun."','$users',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM $idmahasiswa ".$tahunbayar." \ ".$arraysemesterbayar." 
                            ".$ket." ','D')
                              ";		
                              mysqli_query($koneksi,$q);

                          		$q="SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='$jenisjurnal' AND IDTRANS='$idbaru'";
                          		$h=mysqli_query($koneksi,$q);
                          		$d=sqlfetcharray($h);
                          		if ($d[MAX]=="") {
                          			$iddetilbaru=0;
                          		} else {
                          			$iddetilbaru=$d[MAX]+1;
                          		}

                              $q="INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)
                                  VALUES ('$iddetilbaru','$idbaru','$jenisjurnal','".($bayar+$denda)."','$tanda','".$arrayakun[pendapatan]."-$idkomponen','$users',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM $idmahasiswa ".$tahunbayar." \ ".$arraysemesterbayar." 
                            ".$ket." ','K')
                              ";		
                              mysqli_query($koneksi,$q);
                          }

              $errmesg="Data pembayaran berhasil disimpan";
              $aksi2="Data Baru";
              
            } else {
              $errmesg="Data pembayaran tidak disimpan";
              $aksi2="Lanjut";
            }
           }
        } else {
          $aksi2="Data Baru";
        }
        
        } //END PERIKSA
        
        
        
        }
       
      }


          $q="SELECT ID,NAMA,ANGKATAN,IDPRODI,GELOMBANG,SMAWLMSMHS,JENISKELAS FROM mahasiswa,msmhs 
      WHERE mahasiswa.ID=msmhs.NIMHSMSMHS AND mahasiswa.ID='$idmahasiswa' ";
      $h=mysqli_query($koneksi,$q);
      $d=sqlfetcharray($h);
      $angkatan=$d[ANGKATAN];
      $idprodi=$d[IDPRODI];
      $gelombang=$d[GELOMBANG];
        $jeniskelas=$d[JENISKELAS];

      if ($JENISKELAS==1 && getaturan("BIAYAKEUANGAN")==1 ) {
              $qfieldjeniskelas=" AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='$jeniskelas' ";
            $qfieldjeniskelasm=" AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
            
            $fieldjeniskelas="
            <tr>
            <td>Jenis Kelas</td>
            <td>".$arraykelasstei[$jeniskelas]."</td>
            </tr>
            ";
            
      }  else {
            $qfieldjeniskelas=" AND biayakomponen.JENISKELAS='' ";
            $qfieldjeniskelasm=" AND biayakomponen.JENISKELAS='' ";
      }


       $tmp=$d[SMAWLMSMHS];
        $tahunawal=$tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $tahunawal++;
      $semesterawal=$tmp[4];  
      
      if ($aksi2=="Lanjut" && getaturan("KEUANGAN2")==1) {
        // Periksa apakah pada tanggal yg sama ada komponen yg dibayar yg sama komponennya.
         {
          if ($arrayjeniskomponenpembayaran[$idkomponen]==3 && $idkomponen!=99 && $idkomponen!=98) { // SEMESTERAN
            // PERIKSA APAKAH Semester Sebelum nya sudah lunas
             
            // Hitung semester lalu
            $angkatan=$d[ANGKATAN];
            if ($tahunawal<1901) {
              $tahunawal=$d[ANGKATAN]+1;
            }
            if ($semester==2) {
              $semesterlalu=1;
              $tahunlalu=$tahun;
            } else {
              $semesterlalu=2;
              $tahunlalu=$tahun-1;
            
            }
            
            // Periksa Cuti 
            $stop=0;
            while (!$stop) {
              $q="SELECT * FROM trlsm WHERE THSMSTRLSM='".($tahunlalu-1)."$semesterlalu' AND NIMHSTRLSM='$idmahasiswa' AND STMHSTRLSM='C'";
              $hx=mysqli_query($koneksi,$q);
              echo mysqli_error($koneksi);
              if (sqlnumrows($hx)>0) {
                
                  if ($semesterlalu==2) {
                    $semesterlalu=1;
                    $tahunlalu=$tahunlalu;
                  } else {
                    $semesterlalu=2;
                    $tahunlalu=$tahunlalu-1;
                  
                  }   
                       
              } else {
                $stop=1;
              }
            }
            
            //echo "Semester Lalu : $tahun $semesterlalu $tahunlalu $angkatan $tahunawal";
            
            if ($tahunawal==$tahun && $semester<=$semesterawal) { // Semester Pertama. Tidak perlu diperiksa
                //echo "Semester Pertama";
            } elseif($tahunawal<=$tahunlalu) { // periksa apakah sudah bayar belum...

                    $q="SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran
                   WHERE
                   biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND
                   biayakomponen.IDKOMPONEN='$idkomponen' AND 
                   biayakomponen.ANGKATAN='$angkatan' AND
                   biayakomponen.IDPRODI='$idprodi'  AND
                   biayakomponen.GELOMBANG='$gelombang'  
                   $qfieldjeniskelas
                   
                   ";
                   $h2=mysqli_query($koneksi,$q);
                   if (sqlnumrows($h)>0) {
                    $d2=sqlfetcharray($h2);
                    $databiayakomponen=$d2;
                    $biaya=$d2[BIAYA];
                    
                   }
                  $diskonbeasiswa=0;
                    $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' AND
                    TAHUN='$tahunlalu' AND SEMESTER='$semesterlalu'";
                    $hdiskon=mysqli_query($koneksi,$q);
                    //echo mysqli_error($koneksi);
                    if (sqlnumrows($hdiskon)>0) {
                      $ddiskon=sqlfetcharray($hdiskon);
                      $diskonbeasiswa=$ddiskon[DISKON];
                       
                    }
                    $harusdibayar=$biaya*(100-$diskonbeasiswa)/100;


                $q="SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND 
              TAHUNAJARAN='$tahunlalu' AND SEMESTER='$semesterlalu' AND JENIS='3' AND
              IDKOMPONEN='$idkomponen'";
              $hx=mysqli_query($koneksi,$q);
              $dx=sqlfetcharray($hx);
              $sudahdibayar=$dx[TOTAL];
              // echo "<br>Sudah dibayar: $sudahdibayar $harusdibayar";
              
              if ($sudahdibayar < $harusdibayar) {
                //echo "Bayar dulu";
                $aksi2="";
                $errmesg="Maaf. Mahasiswa ybs belum melunasi pembayaran komponen ini (".$arraykomponenpembayaran[$idkomponen].") untuk semester lalu (".$arraysemester[$semesterlalu]." ".($tahunlalu-1)."/$tahunlalu) ";
                
              }
            }
            
          }
        
        
        }
      
      }
      
  
        printmesg($errmesg);
      
       
        $token = md5(uniqid(rand(),TRUE));
        $_SESSION['token'] = $token;

      
    	echo "
    		<form name=form action=index.php method=post>
    			<input type=hidden name=pilihan value='$pilihan'>
    			<input type=hidden name=idmahasiswa value='$idmahasiswa'>
    			<input type=hidden name=aksi value='$aksi'>
     		<table class=form>
      		<tr >
    			<td class=judulform width=150 >NIM</td>
    			<td>$idmahasiswa </td>
    		</tr> 
      		<tr >
    			<td class=judulform>NAMA</td>
    			<td>$d[NAMA]</td>
    		</tr>      
      		<tr >
    			<td class=judulform>Angkatan</td>
    			<td>$d[ANGKATAN]</td>
    		</tr>       
      	<tr >
    			<td class=judulform>Prodi</td>
    			<td>".$arrayprodidep[$d[IDPRODI]]."</td>
    		</tr>  $fieldjeniskelas   ";
    		
    		if ($aksi2=="Data Baru") {
          $aksi2="";
        }
    		if ($aksi2=="") {
    		echo "  						
      	<tr >
    			<td class=judulform>Tanggal Bayar</td>
    			<td>".createinputtanggal("tgl","","")."</td>
    		</tr> 
    		           
      	<tr >
    			<td class=judulform>Komponen</td>
    			<td> 
          <script>
            var  arrayjeniskomponen = new Array;
            ";
            foreach ($arraykomponenpembayaran as $k=>$v ) {
            
              echo "
                arrayjeniskomponen['$k']=".$arrayjeniskomponenpembayaran[$k].";
              ";
            
            }
            echo "
          </script>
          
           <select name=idkomponen  onChange='gantilabel(this.value);'> 
             <option value='' >Pilih Komponen Pembayaran</option>
           ";
              foreach ($arraykomponenpembayaran as $k=>$v) {
                echo "<option value='$k' >$v  </option>";
 
              }
          echo "
              </select>  
              <input type=checkbox name=pilihisi value=1 > Isi otomatis
        </td></tr>
        <tr id=pertahun style='display:none;'>
          <td>Tahun Ajaran</td>
           <td>
            
						<select name=tahunajaran class=masukan> 
						 ";


						 $arrayangkatan=getarrayangkatan("R");
						 foreach ($arrayangkatan as $k=>$v) {
              $selected="";
              if ($k==$waktu[year]) {
                $selected="selected";
              } 							
              echo "
							<option value='".($k)."' $selected >".($v-1)."/$v</option>
							";
             
             }						
             $k++;
              echo "
							<option value='".($k)."' $selected >".($k-1)."/$k</option>
							";
 
					echo "
						</select> 

            
            </td>
        </tr>
       <tr id=persemester style='display:none;'>
          <td>Tahun Ajaran/Semester</td>
           <td>".createinputtahunajaransemester($semua=0)."  
             </td>
        </tr>
       <tr id=cuti style='display:none;'>
          <td>Tahun Ajaran/Semester</td>
           <td>".createinputtahunajaransemestercuti($semua=0,"semestercuti" ,$idmahasiswa)."  
             </td>
        </tr>
       <tr id=perbulan style='display:none;'>
          <td>Bulan-Tahun</td>
           <td>

            <select name=bulan class=masukan> 
										  ";
										foreach ($arraybulan as $k=>$v) {
											 $cek="";
				 							if($k+1==$w[mon]) {
				 								$cek="selected";
				 							} 
				 							echo "
											<option value='".($k+1)."' $cek>$v</option>
											";
										}
									echo "
										</select>
										
										<select name=tahunbulan class=masukan> 
									 ";
									for ($ii=1990;$ii<=$waktu[year]+5;$ii++) {
			 							$cek="";
			 							if($ii==$d2[TAHUNAJARAN]) {
			 								$cek="selected";
			 							} elseif ($ii==$waktu[year]  && $d2[TAHUNAJARAN]=="") {
			 								$cek="selected";
			 							}
			 							echo "
										<option value='$ii' $cek> $ii</option>
										";
									}
								echo "
									</select>
        
            
            
          </td>
    		</tr>           
        <tr>
    				<td colspan=2>
    					<input id=aksi2 type=submit name=aksi2 value='Lanjut' class=masukan  style='display:none;'>
    				</td>
    		</tr>";
    		}
    		if ($aksi2=="Lanjut") {

    		echo "  						
      	<tr >
    			<td class=judulform>Tanggal Bayar </td>
    			<td>$tgl[tgl]-$tgl[bln]-$tgl[thn] 
            <input type=hidden name='tgl[tgl]' value='$tgl[tgl]'>
            <input type=hidden name='tgl[bln]' value='$tgl[bln]'>
            <input type=hidden name='tgl[thn]' value='$tgl[thn]'>
          </td>
    		</tr> 
    		           
      	<tr >
    			<td class=judulform>Komponen</td>
    			<td> ".$arraykomponenpembayaran[$idkomponen]."  
    			<input type=hidden name=idkomponen value='$idkomponen'>
          
         </td></tr>";
         $biaya=$totalbayar=$totaldiskon=$ketdiskon=$diskon=$dibayar=$ketsks=$denda="";

                    $q="SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran
             WHERE
             biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND
             biayakomponen.IDKOMPONEN='$idkomponen' AND 
             biayakomponen.ANGKATAN='$angkatan' AND
             biayakomponen.IDPRODI='$idprodi'  AND
                   biayakomponen.GELOMBANG='$gelombang'
                   $qfieldjeniskelas
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h2)>0) {
              $d2=sqlfetcharray($h2);
              $databiayakomponen=$d2;
                $biaya=$d2[BIAYA];
              
             }



         if ($arrayjeniskomponenpembayaran[$idkomponen]==0 || $arrayjeniskomponenpembayaran[$idkomponen]==1 
            || $arrayjeniskomponenpembayaran[$idkomponen]==4
         ) { // 1 x Awal atau Akhir kuliah atau TIDAK TETAP

              $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' ";
              $hdiskon=mysqli_query($koneksi,$q);
              //echo mysqli_error($koneksi);
              if (sqlnumrows($hdiskon)>0) {
                $ddiskon=sqlfetcharray($hdiskon);
                $diskonbeasiswa=$ddiskon[DISKON];
                $ketdiskon = "Sudah Diskon $diskonbeasiswa %.";
              }


            $q="SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
            FROM bayarkomponen
             WHERE
              bayarkomponen.IDKOMPONEN='$idkomponen' AND 
             bayarkomponen.IDMAHASISWA='$idmahasiswa' 
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h)>0) {
              $d2=sqlfetcharray($h2);
              $totalbayar=$d2[TOTALBAYAR];
              $totaldiskon=$d2[TOTALDISKON];
             }
                          
 

             

          } else
         if ($arrayjeniskomponenpembayaran[$idkomponen]==2) { // TAHUNAN

              $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' AND
              TAHUN='$tahunajaran' ";
              $hdiskon=mysqli_query($koneksi,$q);
              //echo mysqli_error($koneksi);
              if (sqlnumrows($hdiskon)>0) {
                $ddiskon=sqlfetcharray($hdiskon);
                $diskonbeasiswa=$ddiskon[DISKON];
                $ketdiskon = "Sudah Diskon $diskonbeasiswa %.";
              } 
             
            $q="SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
            FROM bayarkomponen
             WHERE
              bayarkomponen.IDKOMPONEN='$idkomponen' AND 
             bayarkomponen.IDMAHASISWA='$idmahasiswa'  AND
             bayarkomponen.TAHUNAJARAN='$tahunajaran'
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h)>0) {
              $d2=sqlfetcharray($h2);
              $totalbayar=$d2[TOTALBAYAR];
              $totaldiskon=$d2[TOTALDISKON];
             }
                          
 


             echo "
            <tr id=pertahun  >
              <td>Tahun Ajaran</td>
               <td>".($tahunajaran-1)."/$tahunajaran
               <input type=hidden name=tahunajaran value='$tahunajaran'>
                
                 </td>
            </tr>
            
            ";
         } elseif($arrayjeniskomponenpembayaran[$idkomponen]==3) { // SEMESTERAN

                $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' AND
              TAHUN='$tahun' AND SEMESTER='$semester'";
              $hdiskon=mysqli_query($koneksi,$q);
              //echo mysqli_error($koneksi);
              if (sqlnumrows($hdiskon)>0) {
                $ddiskon=sqlfetcharray($hdiskon);
                $diskonbeasiswa=$ddiskon[DISKON];
                $ketdiskon = "Sudah Diskon $diskonbeasiswa %.";
              }  

             
             $q="SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
            FROM bayarkomponen
             WHERE
              bayarkomponen.IDKOMPONEN='$idkomponen' AND 
             bayarkomponen.IDMAHASISWA='$idmahasiswa'  AND
             bayarkomponen.TAHUNAJARAN='$tahun' AND
             bayarkomponen.SEMESTER='$semester'
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h)>0) {
              $d2=sqlfetcharray($h2);
              $totalbayar=$d2[TOTALBAYAR];
              $totaldiskon=$d2[TOTALDISKON];
             }

 
 
            if ($idkomponen=="99") { // BIAYA SKS ATAU TAMBAHAN SKS
              
                $jumlahsks=getjumlahsks($idmahasiswa,$tahun,$semester);
                $jumlahskswajib=getjumlahskswajib($idmahasiswa,$tahun,$semester);
                $skslebih=0;
                if ($jumlahsks>$jumlahskswajib) {
                   $skslebih=$jumlahsks-$jumlahskswajib;
                }
                 if ($BIAYASKSKULIAH==1) {
                    $biaya=$jumlahsks*$biaya;
                    $ketsks="
                       Total SKS: <b> $jumlahsks SKS </b>
                     ";
                 } else {
                    $biaya=$skslebih*$biaya;
                    $ketsks="
                      SKS Lebih : <b> $skslebih SKS </b>
                     ";
                }
                 
 
            
            }
            if ($idkomponen==98) { // BIAYA SKS ATAU TAMBAHAN SKS SEMESTER PENDEK
                $jumlahsks=getjumlahskssp($idmahasiswa,$tahun,$semester);
                //$jumlahskswajib=getjumlahskswajib($idmahasiswa,$tahun,$semester);
                $skslebih=$jumlahsks;
                     $biaya=$skslebih*$biaya;
                    //$ketsks="
                     //  Total SKS: <b> $skslebih SKS </b>
                     //";


             }

            // KHUSUS BATAM...
            if ($UNIVERSITAS=="UNIVERSITAS BATAM") {
              if ($KODESPP==$idkomponen) { // kalau tanggal bayar seharusnya $tgl[tgl]> $TANGGALDENDA
                if ($tgl[tgl]> $TANGGALDENDA) {
                  $denda=$JUMLAHDENDA;
                }
              
              }
            }
            
            /// DENDA

         echo "
        <tr id=persemester  >
          <td>Tahun Ajaran/Semester</td>
           <td>".($tahun-1)."/$tahun / ".$arraysemester[$semester]."
           <input type=hidden name=tahun value='$tahun'>
           <input type=hidden name=semester value='$semester'>
            
             </td>
        </tr>";
        
      } elseif($arrayjeniskomponenpembayaran[$idkomponen]==6) { // CUTI

            $tahunc=substr($semestercuti,0,4)+1;
             $semesterc=substr($semestercuti,4,1);


              $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' AND
              TAHUN='$tahunc' AND SEMESTER='$semesterc'";
              $hdiskon=mysqli_query($koneksi,$q);
              //echo mysqli_error($koneksi);
              if (sqlnumrows($hdiskon)>0) {
                $ddiskon=sqlfetcharray($hdiskon);
                $diskonbeasiswa=$ddiskon[DISKON];
                $ketdiskon = "Sudah Diskon $diskonbeasiswa %.";
              }  

             
            $q="SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
            FROM bayarkomponen
             WHERE
              bayarkomponen.IDKOMPONEN='$idkomponen' AND 
             bayarkomponen.IDMAHASISWA='$idmahasiswa'  AND
             bayarkomponen.TAHUNAJARAN='$tahunc' AND
             bayarkomponen.SEMESTER='$semesterc'
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h)>0) {
              $d2=sqlfetcharray($h2);
              $totalbayar=$d2[TOTALBAYAR];
              $totaldiskon=$d2[TOTALDISKON];
             }

             
            /// DENDA

         echo "
        <tr id=persemester  >
          <td>Tahun Ajaran/Semester</td>
           <td>".($tahunc-1)."/$tahunc / ".$arraysemester[$semesterc]."
           <input type=hidden name=tahunc value='$tahunc'>
           <input type=hidden name=semesterc value='$semesterc'>
            
             </td>
        </tr>";
        
        
               
        } elseif($arrayjeniskomponenpembayaran[$idkomponen]==5) { // BULANAN


              $q="SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='$idmahasiswa' AND IDKOMPONEN='$idkomponen' AND
              TAHUN='$tahunbulan' AND SEMESTER='$bulan'";
              $hdiskon=mysqli_query($koneksi,$q);
              //echo mysqli_error($koneksi);
              if (sqlnumrows($hdiskon)>0) {
                $ddiskon=sqlfetcharray($hdiskon);
                $diskonbeasiswa=$ddiskon[DISKON];
                $ketdiskon = "Sudah Diskon $diskonbeasiswa %.";
              }  


            $q="SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON 
            FROM bayarkomponen
             WHERE
              bayarkomponen.IDKOMPONEN='$idkomponen' AND 
             bayarkomponen.IDMAHASISWA='$idmahasiswa'  AND
             bayarkomponen.TAHUNAJARAN='$tahunbulan' AND
             bayarkomponen.SEMESTER='$bulan'
             
             ";
             $h2=mysqli_query($koneksi,$q);
             if (sqlnumrows($h)>0) {
              $d2=sqlfetcharray($h2);
              $totalbayar=$d2[TOTALBAYAR];
              $totaldiskon=$d2[TOTALDISKON];
             }


                  $totaldenda=0;
                  $kettambahan="";
                    $q="SELECT TO_DAYS('$tgl[thn]-$tgl[bln]-$tgl[tgl]')-TO_DAYS('$tahunbulan-$bulan-$databiayakomponen[TANGGAL]') AS HARI ";
                    $hx=mysqli_query($koneksi,$q);
                    $dx=sqlfetcharray($hx);
                      $jumlahhari=$dx[HARI]+0;
                       
                  if ($jumlahhari>0)  {
                    if ($databiayakomponen[JENISDENDA]==0) { // sekali
                       $denda=$databiayakomponen[DENDA];
                    } else {
                       $denda=$databiayakomponen[DENDA]*($jumlahhari);
                    }
                    //$totaldenda;
                    $kettambahan="Denda terlambat $jumlahhari hari Rp. ".cetakuang($denda);
                  }		
             
          echo "
        <tr id=perbulan  >
          <td>Bulan-Tahun</td>
           <td> ".$arraybulan[$bulan-1]." $tahunbulan
           <input type=hidden name=bulan value='$bulan'>
           <input type=hidden name=tahunbulan value='$tahunbulan'>
            
             </td>
        </tr>";

        }
        $biayatampil=((100-$diskonbeasiswa)/100)*$biaya;
             $sisa=$biayatampil-($totalbayar+$totaldiskon);           
            //$diskon=(int)(($diskonbeasiswa)*$sisa/100);
            $dibayar=$sisa-$diskon;

          if ($idkomponen==98) {
                 echo "
                <tr id=persemester  >
                  <td>Total SKS</td>
                   <td>$skslebih SKS
                      </td>
                </tr>";          
          
          }

             echo "




            <tr   >
              <td>Biaya Rp. </td>
               <td> <b>".cetakuang($biayatampil)."  . </b> $ketdiskon
               Total Bayar : <b> Rp. ".cetakuang($totalbayar)." </b>
               <!-- Total Beasiswa : <b> Rp. ".cetakuang($totaldiskon)." </b> -->
               Total Tunggakan : <b> Rp. ".cetakuang($sisa)." </b>  
              $ketsks </td>
            </tr>
            <input type=hidden name=sessid value='$token'>
            <input type=hidden name=sisa value='$sisa'>
            <input type=hidden name=biaya value='$biaya'>
            <input type=hidden name=beasiswa value='$diskonbeasiswa'>
            <input type=hidden name=biayatampil value='$biaya'>
             
            ";
            
            if ($pilihisi!=1) {
              $dibayar="";
              $diskon="";
            }
            $diskon="";
            
            if ($diskonbeasiswa>0) {
              echo "
              <!-- 
                <script>
                  var diskonbeasiswa=$diskonbeasiswa;
                  function gantidiskon(biaya) {
                       var bayar=  document.getElementById('biaya');
                       var diskon= document.getElementById('diskon');
                      
                      diskon.value=biaya*diskonbeasiswa/100;
                      bayar.value=biaya-diskon.value;
                  }
                
                </script>
                -->
              ";
              //$fungsi=" onChange='gantidiskon(this.value);'  ";
            }
            
        echo " 


         <tr>
          <td> Jumlah Bayar </td>
          <td> <input type=text id=biaya name=bayar value='$dibayar' size=20 $fungsi >   </td>
        </tr>
        <tr>
          <td> Jumlah Diskon </td>
          <td> <input type=text id=diskon name=diskon value='".($diskon)."' size=20> <!-- $ketdiskon --> </td>
        </tr>
        <tr>
          <td> Jumlah Denda </td>
          <td> <input type=text name=denda value='$denda' size=20> $kettambahan </td>
        </tr>
        <tr>
          <td> Keterangan </td>
          <td> <input type=text name=ket value='' size=50> </td>
        </tr>                      
					<tr >
						<td>Cara Pembayaran</td>
						<td>
            <select name=carabayar>";
            foreach ($arraycarabayar as $k=>$v) {
              $cek="";
              if ($k==1) {
                $cek="selected";
              }
              echo "<option value='$k' $cek>$v</option>";
            }
            echo"
              </select>
            </td>
						</tr>				
                
        <tr>
    				<td  >
    					<input id=aksi2 type=submit name=aksi2 value='Simpan' class=masukan  >
    					
    					
    				</td>
    				<td  align=right>
    					<input id=aksi2 type=submit name=aksi2 value='Data Baru' class=masukan  >
    					
    					
    				</td>
    		</tr>";


        
        }
        echo "
    		</table>
    		</form>


<script>
function gantilabel(v) {
   //alert(document.getElementById('pertahun').style.visibility);
  document.getElementById('pertahun').style.display='none';
  document.getElementById('persemester').style.display='none';
  document.getElementById('perbulan').style.display='none';
 document.getElementById('cuti').style.display='none';
    document.getElementById('aksi2').style.display='inline';
  if (  v=='') { // Tidak memilih
    document.getElementById('aksi2').style.display='none';
  } else if (  arrayjeniskomponen[v]==0) { // 1 Kali Awal Kuliah
  } else if (  arrayjeniskomponen[v]==1) { // 1 Kali Akhir Kuliah
  } else if (  arrayjeniskomponen[v]==2) { // Per tahun Ajaran
    document.getElementById('pertahun').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==3) { // Per Semesteran
    document.getElementById('persemester').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==4) { // Tidak tetap
  } else if (  arrayjeniskomponen[v]==5) { // Bulanan
    document.getElementById('perbulan').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==6) { // Cuti
    document.getElementById('cuti').style.display='table-row';
  }
 
}
</script>	    		
    		
    	";  

      $tgltrans[tgl]=$w[mday];
      $tgltrans[bln]=$w[mon];
      $tgltrans[thn]=$w[year];

			 $q="SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,
			 IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,
			 DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR
       FROM bayarkomponen,biayakomponen ,mahasiswa
       WHERE 
       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND
       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND
       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND
       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND
        
      IDMAHASISWA='$idmahasiswa'  $qfieldjeniskelasm
      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
	  #echo $q;exit();
			$h=mysqli_query($koneksi,$q);
			echo mysqli_error($koneksi);
			if (sqlnumrows($h)>0) {
			   echo "
				<form name=form action=cetakkuitansibaru.php method=post target=_blank>
					<input type=hidden name=idmahasiswa value='$idmahasiswa'>
 <input class=masukan type=submit name=aksi value='Cetak Kuitansi'>        
      

			   <br>
			   <b>Rincian Transaksi Keuangan Mahasiswa <!-- - Tanggal Entri $tgltrans[tgl]-$tgltrans[bln]-$tgltrans[thn] --></b>
          <table class=form width=95%>
            <tr class=juduldata align=center>
              <td>Nama</td>
              <td>Jenis</td>
               <td>Waktu</td>
               <td>Tanggal Bayar</td>
              <td>Biaya</td>
              <td>Bayar</td>
              <td>Diskon</td>
              <td>Sisa</td>
              <td>Denda</td>
              <td>Ket</td>
              <td>Pilih Cetak</td>
              <td>Hapus</td>
            </tr>";
            $idkomponenlama=$tahunlama=$semlama=-1;
            $sisa=0;
            while ($d=sqlfetcharray($h)) {
              $waktu="-";
              
              if ($d[BIAYA]==0) {
                $d[BIAYA]=$d[BIAYA2];
              }
              $biaya=($d[BIAYA]*(100-$d[BEASISWA])/100);
              
              
              if ($d[JENIS]==2) { // Tahun Akademik
                $waktu=($d[TAHUNAJARAN]-1)."/$d[TAHUNAJARAN]";
              } else
              if ($d[JENIS]==3 || $d[JENIS]==6) { // Semester Tahun Akademik
                $waktu="".$arraysemester[$d[SEMESTER]]." ".($d[TAHUNAJARAN]-1)."/$d[TAHUNAJARAN]";
              } else 
              if ($d[JENIS]==5) { // Bulan 
                $waktu="".$arraybulan[$d[SEMESTER]-1]." $d[TAHUNAJARAN]";
              
              }

              if (
                
                  ($d[JENIS]==0 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==1 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==2 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN]  ) ) ||
                  ($d[JENIS]==3 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) )  || 
                  ($d[JENIS]==4 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==5 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) ||
                  ($d[JENIS]==6 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) 
                    
                
                
                ) {
                  //$sisa=$d[BIAYA];
                  $sisa=$biaya;
                    $idkomponenlama=$d[IDKOMPONEN];
                  $tahunlama=$d[TAHUNAJARAN];
                  $semlama=$d[SEMESTER];
                  //$tr="class=juduldata";
                  
                  echo "
                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>
                  ";
                  
               }


              $sisa-=($d[JUMLAH]+$d[DISKON]);
              
              if ($sisa<0) {
                $sisa=0;
              }
              
              $trtgl="";
              $cek="";
              if ($d[STATUSTANGGAL]==1) {
                $trtgl="style='background-color:#ffff00;'";
                $cek="checked";
              }
              
              echo "
            <tr valign=top $tr $trtgl>
              <td nowrap> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>
              <td nowrap> ".$arrayjenispembayaran[$d[JENIS]]." </td>
               <td align=center nowrap>$waktu </td>
               <td align=center nowrap>$d[TGLBAYAR]</td>
              <td align=right>".cetakuang($biaya)." </td>
              <td align=right>".cetakuang($d[JUMLAH])."</td>
              <td align=right>".cetakuang($d[DISKON])."</td>
              <td align=right> ".cetakuang($sisa)."</td>
              <td align=right>".cetakuang($d[DENDA])."</td>
              <td align=left>$d[KET]</td>
              <td align=center><input type=checkbox name='pilihcetak[$d[ID]]' value=1 $cek ></td>
              <td align=center>";
              if (getaturan("KEUANGAN")==0 ||  (getaturan("KEUANGAN")==1 &&  issupervisor($users)) ) {
                echo "<a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan=$pilihan&idhapus=$d[ID]&aksi=$aksi&aksi2=hapus&idmahasiswa=$idmahasiswa&sessid=$token&$href'>hapus</a>";
              } else {
                echo "-";
              }
              echo "</td>
            </tr>";


             }
            echo "
          </table>
          
            </form>
         ";
 			
      }


    }
}


if ($aksi=="") {
	printmesg($errmesg);
	echo "
		<form name=form action=index.php method=post>
			<input type=hidden name=pilihan value='$pilihan'>
 		<table class=form>
  		<tr >
			<td class=judulform>NIM</td>
			<td>".
		createinputtext("idmahasiswa",$idmahasiswa," class=masukan  size=20      id='inputString' onkeyup=\"lookup(this.value,'','');\" 
	").
			"
			<a 
			href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',
			document.form.idmahasiswa.value)\" >
			daftar mahasiswa
			</a>
             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
               <div class=\"suggestionList\" id=\"autoSuggestionsList\">
				
			</td>
		</tr> 
 

						<tr>
				<td colspan=2>
					<input type=submit name=aksi value='Lanjut' class=masukan>
				</td>
		</table>
		</form>
	";
}

?>
