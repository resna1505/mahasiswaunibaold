<?php 
function getipk($idmahasiswa,$tahun,$semester,$nilaidiambil=1,$nilaikosong=1) {
  global $koneksi,$sp;
  $q="SELECT ID,ANGKATAN,STPIDMSMHS  STATUS,mahasiswa.IDPRODI,IPKUAP FROM mahasiswa,msmhs WHERE ID='$idmahasiswa' AND mahasiswa.ID=msmhs.NIMHSMSMHS ";
  #echo $q.'<br>';
  $h=doquery($koneksi,$q);
  if (sqlnumrows($h)>0) {
    $d=sqlfetcharray($h);
     $statuspindahan=$d[STATUS];
     $idprodi=$d[IDPRODI];
     $ipkuap=$d[IPKUAP];
         
         $semestermahasiswa=(($tahun-1-$d[ANGKATAN])*2)+$semester;


        if ($statuspindahan=="P") {
            $q="SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, 
          SEMESTERMAKUL AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS
          FROM nilaikonversi,makul
          WHERE
          nilaikonversi.IDMAKUL=makul.ID
          AND IDMAHASISWA='$d[ID]'
          AND SEMESTERMAKUL<=$semestermahasiswa
          ORDER BY SEMESTERMAKUL,IDMAKUL";
		  #echo $q.'<br>';
			     $hn2=doquery($koneksi,$q);			if (sqlnumrows($hn2)>0) {
					 while ($dn2=sqlfetcharray($hn2)) {
					   $arraydatatranskrip["$dn2[SEMESTER]-$dn2[IDMAKUL]"]=$dn2;
					   $arraydatatranskrip2["$dn2[IDMAKUL]"]=$dn2;
				 }
			}
        }


			/*    $q="
				SELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,
				pengambilanmk.SKSMAKUL SKS,
				makul.NAMA,makul.JENIS,
				pengambilanmk.SEMESTERMAKUL
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'
				AND CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='$tahun$semester' 
				ORDER BY SEMESTERMAKUL,IDMAKUL,pengambilanmk.TAHUN ,pengambilanmk.SEMESTER 
			";
	#		echo $q.'<br>';
			$hn=doquery($koneksi,$q);			//echo mysqli_error($koneksi);
			if (sqlnumrows($hn)>0) {
 
				while ($d2=sqlfetcharray($hn)) {
				   if ($nilaidiambil!=1) { // Yang terbaik
						if ($arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
							 //if ($arraydatatranskrip2["$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
							   $arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
							   $arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
						}
					} else {
						$arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
						$arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
					}
				}
			}*/
		#}
		
		//end $statuspindahan="P";
	
		#else{			
			    $q="
				SELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,
				pengambilanmk.SKSMAKUL SKS,
				makul.NAMA,makul.JENIS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'
				AND CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='$tahun$semester' 
				ORDER BY SEMESTERMAKUL,IDMAKUL,pengambilanmk.TAHUN ,pengambilanmk.SEMESTER 
			";
			#echo $q.'<br>';
			$hn=doquery($koneksi,$q);			//echo mysqli_error($koneksi);
			if (sqlnumrows($hn)>0) {
 
				while ($d2=sqlfetcharray($hn)) {
				   if ($nilaidiambil!=1) { // Yang terbaik
#echo "KONDISI ARRAYDATATRANSKRIP".$arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"][BOBOT].'<br>'."MATA KULIAH=".$d2[IDMAKUL].'<br>'."BOBOT=".$d2[BOBOT].'<br>'."SKS=".$d2[SKS].'<br>';
						#if ($arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
							 if ($arraydatatranskrip2["$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
							   $arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
							   $arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
						}
					} else {
						$arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
						$arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
					}
				}
			}
			
		#}
		#print_r($arraydatatranskrip).'<br>';
		#echo "APA".'<br>';
      #print_r($arraydatatranskrip2).'<br>';
         if ($sp==1) {
    			      $q="
    				SELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,
				  pengambilanmksp.SKSMAKUL SKS,
    				makul.NAMA,makul.JENIS,
    				pengambilanmksp.SEMESTERMAKUL SEMESTER
    				FROM pengambilanmksp,makul 
    				WHERE 
    				pengambilanmksp.IDMAKUL=makul.ID
    				AND IDMAHASISWA='$d[ID]'
    				ORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER 
    			";
				#echo $q.'<br>';
    			$hn3=doquery($koneksi,$q);    			if (sqlnumrows($hn3)>0) {
    			
    			 while ($d3=sqlfetcharray($hn3)) {
    			   if ($nilaidiambil!=1) { // Yang terbaik
				#echo "kesini".'<br>';
    			     if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
    			     //if ($arraydatatranskrip2["$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
        			   $arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
        			   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
               }
             } else {
      			   $arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
      			   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
             }
           }
          }
        } 
 
        
        #@ksort($arraydatatranskrip);
        @usort($arraydatatranskrip2, 'SortBySemester');
			  unset($arraydatatranskrip);
				$arraydatatranskrip=$arraydatatranskrip2;
			 
 
				$i=1;
				$semlama="";
				unset($totals);
				//while ($d2=sqlfetcharray($hn))
				#print_r($arraydatatranskrip);
				#echo '<br>';
			#	echo '<br>';
        if (is_array($arraydatatranskrip))
		{ 
				foreach ($arraydatatranskrip as $k=>$d2) {
				  /*
					  $q="SELECT SKSMAKUL,TAHUN FROM pengambilanmk WHERE	
						IDMAHASISWA='$d[ID]'
						AND 
						IDMAKUL='$d2[IDMAKUL]'
						AND CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='$tahun$semester' 
						ORDER BY TAHUN DESC, SEMESTER DESC
						LIMIT 0,1
					";
					$hxx=doquery($koneksi,$q);					$dxx=sqlfetcharray($hxx);
					$tahunlama=$d2[TAHUN];
					if ($d2[SKS]=="") {
					 $d2[SKS]=$dxx[SKSMAKUL];
					}
					*/
					unset($kp);
					if ($konversisemua==0) {
						unset($kon);
					}
 
					$kelas=kelas($i);
				//	$tahunlama=$d2[TAHUN];
				unset($d2[TAHUN]);
				unset($d2[KELAS]);
				unset($ddmk);
					#$simbolmax="-";
					#$bobot=0;
					#$nilai="";
					#$nilai2=0;

          $bobot=$d2[BOBOT];
          $nilai=$d2[SIMBOL];
          $nilai2=0;
          $simbolmax=$nilai;

					/*
				if ($d2[BOBOT]!="") {
          $bobot=$d2[BOBOT];
          $nilai=$d2[NILAI];
          $nilai2=0;
          $simbolmax=$nilai;
        } 
        else 	
					
 				if ($nilaidiambil==1) {
					$q="SELECT 
						pengambilanmk.TAHUN,
						pengambilanmk.SEMESTER,
						pengambilanmk.KELAS,NILAI,BOBOT,SIMBOL
						FROM pengambilanmk
						WHERE
						IDMAHASISWA='$d[ID]'
						AND IDMAKUL='$d2[IDMAKUL]'
						AND CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='$tahun$semester' 
						ORDER BY TAHUN DESC,SEMESTER DESC
						LIMIT 0,1
					";
					$hmk=doquery($koneksi,$q);					if (sqlnumrows($hmk)>0) {
						$dmk=sqlfetcharray($hmk);
						$bobot=$dmk[BOBOT];
						$simbolmax=$nilai=$dmk[SIMBOL];
						$nilai2=$dmk[NILAI];
						$ddmk[]=$dmk;
						
						$semk=$dmk[SEMESTER];
						$tahunk=$dmk[TAHUN];
					}
					//$sp=0;
					if ($sp==1) {
  					$q="SELECT 
  						pengambilanmksp.TAHUN,
  						pengambilanmksp.SEMESTER,
  						pengambilanmksp.KELAS,NILAI,BOBOT,SIMBOL
  						FROM pengambilanmksp
  						WHERE
  						IDMAHASISWA='$d[ID]'
  						AND IDMAKUL='$d2[IDMAKUL]'
  						AND (TAHUN>='$tahunk')
  						AND CONCAT(pengambilanmksp.TAHUN,pengambilanmksp.SEMESTER)<='$tahun$semester' 
  						ORDER BY TAHUN DESC,SEMESTER DESC
  						LIMIT 0,1
  					";
  					$hmk=doquery($koneksi,$q);  					if (sqlnumrows($hmk)>0) {
  						$dmk=sqlfetcharray($hmk);
  						$bobot=$dmk[BOBOT];
  						$simbolmax=$nilai=$dmk[SIMBOL];
  						$nilai2=$dmk[NILAI];
  						$ddmk[]=$dmk;
  						
  						//$semk=$dmk[SEMESTER];
  						//$tahunk=$dmk[TAHUN];
  					}          
          }
				} else {
				  $simbolmax="-";
					$q="SELECT 
						pengambilanmk.TAHUN,
						pengambilanmk.SEMESTER,
						pengambilanmk.KELAS,NILAI,BOBOT,SIMBOL
						FROM pengambilanmk
						WHERE
						IDMAHASISWA='$d[ID]'
						AND IDMAKUL='$d2[IDMAKUL]'
						AND CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='$tahun$semester' 
						ORDER BY TAHUN DESC,SEMESTER DESC
						 
					";
					$hmk=doquery($koneksi,$q);
					if (sqlnumrows($hmk)>0) {
					   $bobot=0;
						while ($dmk=sqlfetcharray($hmk)) {
						  if ($dmk[BOBOT]>=$bobot) {
                $bobot=$dmk[BOBOT];
    						$simbolmax=$nilai=$dmk[SIMBOL];
    						$nilai2=$dmk[NILAI];

    						$semk=$dmk[SEMESTER];
    						$tahunk=$dmk[TAHUN];

              }
							$ddmk[]=$dmk;
						}
 					}
 					
 					if ($sp==1) {
    					$q="SELECT 
    						pengambilanmksp.TAHUN,
    						pengambilanmksp.SEMESTER,
    						pengambilanmksp.KELAS,NILAI,BOBOT,SIMBOL
    						FROM pengambilanmksp
    						WHERE
    						IDMAHASISWA='$d[ID]'
    						AND IDMAKUL='$d2[IDMAKUL]'
    						AND CONCAT(pengambilanmksp.TAHUN,pengambilanmksp.SEMESTER)<='$tahun$semester' 
    						ORDER BY TAHUN DESC,SEMESTER DESC
    						 
    					";
    					$hmk=doquery($koneksi,$q);    
    					if (sqlnumrows($hmk)>0) {
  
    						while ($dmk=sqlfetcharray($hmk)) {
    						  if ($dmk[BOBOT]>=$bobot) {
                    $bobot=$dmk[BOBOT];
        						$simbolmax=$nilai=$dmk[SIMBOL];
        						$nilai2=$dmk[NILAI];
    
        						//$semk=$dmk[SEMESTER];
        						//$tahunk=$dmk[TAHUN];
    
                  }
    							$ddmk[]=$dmk;
    						}
     					}          
           }
				}
				*/
////////////////////////////////////////////////////////////////////////////////////////////
          


			   if  (($nilaikosong==1) || ($nilai!="MD" && $nilai!="T"   && $nilai!="" && $nilaikosong==0)) 
				{
						  $totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
							$bobots[$d2[SEMESTER]]+=$d2[SKS];
							$bobotsemua+=$d2[SKS];
							$totalsemua+=$bobot*$d2[SKS];

						if ($bobot >1) {
							$bobotsemualulus+=$d2[SKS];
					   }


				} else {
					$bobot="";
				}
 
					$i++;
			}
		#}
		
				$jenisprodi=getjenisprodi($idprodi);
				if ($jenisprodi==0) { // Biasa
						$hasil[0]= @($totalsemua/$bobotsemua) ;
						$hasil[1]= $bobotsemua ;
				} elseif ($jenisprodi==1) { // profesi
					if (issudahlulus($idmahasiswa)) { // Hitung IPKUAP
						$datasemesterakhir=getsemesterterakhir($idmahasiswa);
					#	echo $datasemesterakhir[TAHUN].$datasemesterakhir[SEMESTER].   " = $tahun $semester";
					#	echo '<br>';
						
						if ($datasemesterakhir[TAHUN].$datasemesterakhir[SEMESTER]==$tahun.$semester) {
								#$hasil[0]= @((($totalsemua/$bobotsemua)+$ipkuap)/2) ;
								$hasil[1]= $bobotsemua ;
						} else {
								$hasil[0]= @($totalsemua/$bobotsemua) ;
								$hasil[1]= $bobotsemua ;
						
						}       
				  
					} else { // Hitung Biasa
							$hasil[0]= @($totalsemua/$bobotsemua) ;
							$hasil[1]= $bobotsemua ;
					}
				}
 
     				$hasil[2]= $totalsemua ;
    				$hasil[3]= $bobotsemualulus ;

 
 
		//	}  
		}
		return $hasil;
	}
}

function getips($idmahasiswa,$tahun,$semester,$nilaidiambil=1,$nilaikosong=1) {
  global $koneksi,$sp; 

  $q="SELECT ID,ANGKATAN,STPIDMSMHS  STATUS FROM mahasiswa,msmhs WHERE ID='$idmahasiswa' AND mahasiswa.ID=msmhs.NIMHSMSMHS ";
 # echo $q.'<br>';
  $h=doquery($koneksi,$q);
  if (sqlnumrows($h)>0) {
    $d=sqlfetcharray($h);
     $statuspindahan=$d[STATUS];
         
         $semestermahasiswa=(($tahun-1-$d[ANGKATAN])*2)+$semester;



			  $q="
				SELECT 
        pengambilanmk.BOBOT,
        pengambilanmk.SIMBOL,
        pengambilanmk.IDMAKUL,
				pengambilanmk.TAHUN,
				makul.NAMA NAMAMAKUL,pengambilanmk.NAMA,pengambilanmk.SKSMAKUL AS SKS,
				pengambilanmk.SEMESTER AS SEMESTERS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER 
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmk.SEMESTERMAKUL,
				IDMAKUL
			";
			#echo $q.'<br>';
			$hn=doquery($koneksi,$q);			////echo mysqli_error($koneksi);
			unset($arraydatanilai);
			if (sqlnumrows($hn)>0) {
			   while ($d2=sqlfetcharray($hn)) {
			     $arraydatanilai["$d2[TAHUN]-$d2[SEMESTERS]-$d2[IDMAKUL]"]=$d2;
			     //echo "$d2[IDMAKUL]-$d2[TAHUN]-$d2[SEMESTER]<br>";
			   }
			}
// SP
  if ($sp==1) {
			  $q="
				SELECT 
        pengambilanmksp.BOBOT,
        pengambilanmksp.SIMBOL,
        pengambilanmksp.IDMAKUL,
				pengambilanmksp.TAHUN,
				makul.NAMA NAMAMAKUL,pengambilanmksp.NAMA,pengambilanmksp.SKSMAKUL AS SKS,
				pengambilanmksp.SEMESTER AS SEMESTERS,
				pengambilanmksp.SEMESTERMAKUL AS SEMESTER 
				FROM pengambilanmksp,makul 
				WHERE 
				pengambilanmksp.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmksp.SEMESTERMAKUL,
				IDMAKUL
			";
			$hn2=doquery($koneksi,$q);			//echo mysqli_error($koneksi);
			//unset($arraydatanilai);
			if (sqlnumrows($hn2)>0) {
			   while ($d3=sqlfetcharray($hn2)) {
  			   if ($nilaidiambil!=1) { // Yang terbaik
  			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
  			     if ($arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
      			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
    			     $arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"]=$d3;
             }
           } else {
    			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
  			     $arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"]=$d3;
           }
			   }
			}
		}
// SP


        @ksort($arraydatanilai);

			if (is_array($arraydatanilai)) {

					if ($semester!=3) {
						 $semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+$semester;
					} else {
						$semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+0.5;
					}
 				$i=1;
				$semlama=$semlast=0;
				foreach ($arraydatanilai as $kk=>$d2) {
				  //echo "$kk <br>";
				//while ($d2=sqlfetcharray($hn)) {
					unset($kp);
 					if ($d2[SEMESTERS]!=3) {
						 $semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+$d2[SEMESTERS];
					} else {
						$semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+0.5;
					}
  						$kelas=kelas($i);
 						
 						$semlama=$semesterhitungx;
						
				  
					$kelas=kelas($i);
 
				
////////////////////////////////////////////////////////////////////////////////////////////
			$nilai="";
			$total="";
			$bobot="";
			$nilaiakhir=$nilaiakhirdicari=
			$totalmax=$totalmaxdicari=
			$bobotmax=$bobotmaxdicari=
			$simbolmax=$simbolmaxdicari=
			"-";
 
		 	$nilaiakhir=$nilaiakhirdicari;
			$totalmax=$totalmaxdicari;
			$bobotmax=$bobotmaxdicari;
			$simbolmax=$simbolmaxdicari;
////////////////////////////////////////////////////////////////////////////////////////							
 
	 		       if  (
                ($nilaikosong==1) || ($d2[SIMBOL]!="MD" && $d2[SIMBOL]!="" && $d2[SIMBOL]!="T" && $nilaikosong==0)
              ) {
 
								$totalnilaiakhir+=$nilaiakhir;
								 
								$nilai=$d2[SIMBOL];
								$bobot=$d2[BOBOT];
								$total=number_format_sikad($d2[SKS]*$d2[BOBOT],2,'.',',');
							 	$totals[$semesterhitungx]+=$total;
							 	$totalsemua+=$totalmax;
      					$bobots[$semesterhitungx]+=$d2[SKS];
      					$bobotsemua+=$d2[SKS];
               }  
      					$bobots2[$semesterhitungx]+=$d2[SKS];
               
                

 					if ($semesterhitung==$semesterhitungx) {

            if ($d2[NAMA]=="")  {
              $d2[NAMA]=$d2[NAMAMAKUL];
            } 
              $idmakul=$d2[IDMAKUL];
 						$i++;
					}
				}
   						
  }						
 

  
								$hasil[1]=$bobots2[$semestermahasiswa];
								$hasil[0]=@($totals[$semestermahasiswa]/$bobots[$semestermahasiswa]);

//echo "$hasil[0]=@($totals[$semestermahasiswa]/$bobots[$semestermahasiswa]);";

/*
			  $q="
				SELECT 
        pengambilanmk.BOBOT,
        pengambilanmk.SIMBOL,
        pengambilanmk.IDMAKUL,
				pengambilanmk.TAHUN,
				makul.NAMA,pengambilanmk.SKSMAKUL AS SKS,
				pengambilanmk.SEMESTER AS SEMESTERS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER 
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmk.SEMESTERMAKUL,
				IDMAKUL
			";
			$hn=doquery($koneksi,$q);
			//echo mysqli_error($koneksi);
			if (sqlnumrows($hn)>0) {
					if ($semester!=3) {
						 $semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+$semester;
					} else {
						$semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+0.5;
					}
 				$i=1;
				$semlama=$semlast=0;
				while ($d2=sqlfetcharray($hn)) {
					unset($kp);
 					if ($d2[SEMESTERS]!=3) {
						 $semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+$d2[SEMESTERS];
					} else {
						$semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+0.5;
					}
  						$kelas=kelas($i);
 						
 						$semlama=$semesterhitungx;
						
				  
					$kelas=kelas($i);
 
				
////////////////////////////////////////////////////////////////////////////////////////////
			$nilai="";
			$total="";
			$bobot="";
			$nilaiakhir=$nilaiakhirdicari=
			$totalmax=$totalmaxdicari=
			$bobotmax=$bobotmaxdicari=
			$simbolmax=$simbolmaxdicari=
			"-";
 
		 	$nilaiakhir=$nilaiakhirdicari;
			$totalmax=$totalmaxdicari;
			$bobotmax=$bobotmaxdicari;
			$simbolmax=$simbolmaxdicari;
////////////////////////////////////////////////////////////////////////////////////////							
 
	 		       if  (
                ($nilaikosong==1) || ($d2[SIMBOL]!="MD" &&  $d2[SIMBOL]!="" && $d2[SIMBOL]!="T" && $nilaikosong==0)
              ) {
  
								$totalnilaiakhir+=$nilaiakhir;
								 
								$nilai=$d2[SIMBOL];
								$bobot=$d2[BOBOT];
								$total=number_format_sikad($d2[SKS]*$d2[BOBOT],2,'.',',');
							 	$totals[$semesterhitungx]+=$total;
							 	$totalsemua+=$totalmax;
      					$bobots[$semesterhitungx]+=$d2[SKS];
      					$bobotsemua+=$d2[SKS];
               } 
 
					if ($semesterhitung==$semesterhitungx) {
 
              $idmakul=$d2[IDMAKUL];
 
						$i++;
					}
				}
						if ($semlama!="") {
						//echo $totals[$d2[SEMESTER]];
							if ($semesterhitungx==$semlama) {
								//echo $semlama;
								$hasil[1]=$bobots[$semesterhitung];
								$hasil[0]=@($totals[$semesterhitung]/$bobots[$semesterhitung]);
 
							}
						}
 		}
    */
  }
  return $hasil;
}

?>
