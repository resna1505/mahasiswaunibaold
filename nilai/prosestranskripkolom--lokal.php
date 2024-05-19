<?
#echo "lll";exit();
periksaroot(); 
$qcuti=prepare_cuti_mahasiswa($d[ID],"pengambilanmk");
unset($arraydatatranskrip2);
 
 
if ($penempatansemester==1) { // KURIKULUM
  $fpenempatan=" pengambilanmk.SEMESTERMAKUL ";
  $fpenempatansp=" pengambilanmksp.SEMESTERMAKUL ";
  $fpenempatankonversi=" nilaikonversi.SEMESTERMAKUL ";
} else { // Master Mata Kuliah
  $fpenempatan=" makul.SEMESTER ";
  $fpenempatansp=" makul.SEMESTER ";
  $fpenempatankonversi=" makul.SEMESTER ";
}
		

			  $q="
				SELECT DISTINCT pengambilanmk.IDMAKUL,
				makul.NAMA,makul.JENIS,
				$fpenempatan SEMESTER
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'
				$qcuti
 					UNION
				SELECT DISTINCT nilaikonversi.IDMAKUL, 
        makul.NAMA, makul.JENIS, makul.SEMESTER
				FROM nilaikonversi,makul
				WHERE
				nilaikonversi.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'
 				ORDER BY SEMESTER DESC,IDMAKUL 
				LIMIT 0,1
 			";
 			//,IDMAKUL 
			$hn=doquery($q,$koneksi);
		if (sqlnumrows($hn)>0) {
		    //$bodytranskrip.= sqlnumrows($hn);
				$dn=sqlfetcharray($hn);
				$semmax=$dn[SEMESTER];
 				if ($statuspindahan=="P") {
  			  $q="
  				SELECT nilaikonversi.IDMAKUL,
  				makul.NAMA,makul.JENIS,
  				$fpenempatankonversi SEMESTER
  				FROM nilaikonversi,makul 
  				WHERE 
  				nilaikonversi.IDMAKUL=makul.ID
  				AND IDMAHASISWA='$d[ID]'
   				ORDER BY nilaikonversi.SEMESTERMAKUL DESC,IDMAKUL 
  				LIMIT 0,1
  			";
			 $hn=doquery($q,$koneksi);				
    		if (sqlnumrows($hn)>0) {
    				$dn=sqlfetcharray($hn);
    				if ($dn[SEMESTER]>$semmax) {
      				$semmax=$dn[SEMESTER];
            }
    		}
			 }
				/*$bodytranskrip.= "
					<br>
					<table border=1 width=600 style='border-collapse:collapse;'  >
					 <thead style='display:table-header-group;'>
						<tr class=juduldata$cetak align=center>
	 
							<td rowspan=2 align=center><b>Kode</td>
							<td rowspan=2 align=center><b>Nama Mata Kuliah</td>
							<td rowspan=2 align=center><b>SKS</td>
 							<td colspan=$semmax align=center><b>NILAI SEMESTER</td>
						</tr>
						";*/
						
						$bodytranskrip.= "
					<br>
					<table border=1 width=900 style='border-collapse:collapse;'  >
					 <thead style='display:table-header-group;'>
						<tr class=juduldata$cetak align=center>
	 
							<td rowspan=2 align=center width='5%'><b>Kode</td>
							<td rowspan=2 align=center width='15%'><b>Nama Mata Kuliah</td>
							<td rowspan=2 align=center width='1%'><b>SKS</td>
 							<td colspan=$semmax align=center><b>NILAI SEMESTER</td>
						</tr>
						";
						
						$bodytranskrip.= "<tr class=juduldata$cetak align=center>";
						for ($is=1;$is<=$semmax;$is++) {
							$bodytranskrip.= "<td align=center width='3%'><b>$is</td>";
						}	
						$bodytranskrip.= "</tr>
						</thead>
						";
						
		$jenislama=-1;
		$arrayjenismakul2=krsort($arrayjenismakul);
				unset($totals);
		foreach ($arrayjenismakul as $kk=>$vv) {
		    unset($arraydatatranskrip);
		    unset($arraydatatranskrip2);
 				$bodytranskrip.= "
						<tr class=juduldata$cetak align=center $stylepage>
	 
							<td colspan=".(3+$semmax)."  align=left>$vv</td>
						</tr>
				";

        if ($statuspindahan=="P") {
          $q="SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, 
          $fpenempatankonversi SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS
          FROM nilaikonversi,makul
          WHERE
          nilaikonversi.IDMAKUL=makul.ID
          AND IDMAHASISWA='$d[ID]'
				  AND makul.JENIS='$kk'
          ORDER BY SEMESTERMAKUL,IDMAKUL";
			     $hn2=doquery($q,$koneksi);
          if (sqlnumrows($hn2)>0) {
      			 while ($dn2=sqlfetcharray($hn2)) {
      			   //$arraydatatranskrip["$dn2[SEMESTER]-$dn2[IDMAKUL]"]=$dn2;
      			   $arraydatatranskrip2["$dn2[IDMAKUL]"]=$dn2;
             }
          }
        }



			  $q="
				SELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,
				pengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,
				tbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,
				$fpenempatan SEMESTER
				FROM pengambilanmk,makul ,tbkmk,mspst
				WHERE 
        mspst.IDX='$d[IDPRODI]' AND
        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND
        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND
 				pengambilanmk.IDMAKUL=makul.ID
    				AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  
    				AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  
				AND IDMAHASISWA='$d[ID]'
				AND makul.JENIS='$kk'
				$qcuti
				ORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER 
			";
			$hn=doquery($q,$koneksi);

			 while ($d2=sqlfetcharray($hn)) {
			   if ($nilaidiambil!=1) { // Yang terbaik
			     //if ($arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
			     if ($arraydatatranskrip2["$d2[IDMAKUL]"][BOBOT]<=$d2[BOBOT]) {
    			   //$arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
    			   $arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
           }
         } else {
  			   //$arraydatatranskrip["$d2[SEMESTER]-$d2[IDMAKUL]"]=$d2;
  			   $arraydatatranskrip2["$d2[IDMAKUL]"]=$d2;
         }
       }
       
         if ($sp==1) {
    			    $q="
    				SELECT pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,
				  pengambilanmksp.SKSMAKUL SKS,
    				tbkmksp.NAKMKTBKMK AS NAMA,makul.JENIS,
    				$fpenempatansp SEMESTER
    				FROM pengambilanmksp,makul ,tbkmksp,mspst
				WHERE 
        mspst.IDX='$d[IDPRODI]' AND
        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND
        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND
     				pengambilanmksp.IDMAKUL=makul.ID
    				AND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  
    				AND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  
    				AND IDMAHASISWA='$d[ID]'
    					AND makul.JENIS='$kk'
    				ORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER 
    			";
    			$hn3=doquery($q,$koneksi);
    			if (sqlnumrows($hn3)>0) {
    			
    			 while ($d3=sqlfetcharray($hn3)) {
    			   if ($nilaidiambil!=1) { // Yang terbaik
    			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
    			     if ($arraydatatranskrip2["$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
        			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
        			   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
               }
             } else {
      			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
      			   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
             }
           }
          }
        } 
       
       
        // @ksort($arraydatatranskrip);
        @usort($arraydatatranskrip2, 'SortBySemester');
			  unset($arraydatatranskrip);
				$arraydatatranskrip=$arraydatatranskrip2;




				$i=1;
				$semlama="";

				if (is_array($arraydatatranskrip))
				foreach ($arraydatatranskrip as $k=>$d2) {
				  /*
					$q="SELECT SKSMAKUL FROM pengambilanmk WHERE	
						IDMAHASISWA='$d[ID]'
						AND 
						IDMAKUL='$d2[IDMAKUL]'
						ORDER BY TAHUN DESC, SEMESTER DESC
						LIMIT 0,1
					";
					$hxx=doquery($q,$koneksi);
					$dxx=sqlfetcharray($hxx);
					if ($d2[SKS]=="") {
					 $d2[SKS]=$dxx[SKSMAKUL];
					}
					*/
					unset($kp);
					if ($konversisemua==0) {
						unset($kon);
					}
 					if ($d2[SEMESTER]!=$semlama) {
 
						$semlama=$d2[SEMESTER];
						
					} 
					$kelas=kelas($i);
					
				unset($d2[TAHUN]);
				unset($d2[KELAS]);
				unset($ddmk);
					$simbolmax="-";
					$bobot=0;
					$nilai="";
					$nilai2=0;				
					
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
						ORDER BY TAHUN DESC,SEMESTER DESC
						LIMIT 0,1
					";
					$hmk=doquery($q,$koneksi);
					if (sqlnumrows($hmk)>0) {
						$dmk=sqlfetcharray($hmk);
						$bobot=$dmk[BOBOT];
						$simbolmax=$nilai=$dmk[SIMBOL];
						$nilai2=$dmk[NILAI];						
            $ddmk[]=$dmk;
    						$semk=$dmk[SEMESTER];
    						$tahunk=$dmk[TAHUN];            
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
  						AND (TAHUN>='$tahunk')
  						ORDER BY TAHUN DESC,SEMESTER DESC
  						LIMIT 0,1
  					";
  					$hmk=doquery($q,$koneksi);
  					if (sqlnumrows($hmk)>0) {
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
					$q="SELECT 
						pengambilanmk.TAHUN,
						pengambilanmk.SEMESTER,
						pengambilanmk.KELAS,NILAI,BOBOT,SIMBOL
						FROM pengambilanmk
						WHERE
						IDMAHASISWA='$d[ID]'
						AND IDMAKUL='$d2[IDMAKUL]'
						ORDER BY TAHUN DESC,SEMESTER DESC
						 
					";
					$hmk=doquery($q,$koneksi);
					if (sqlnumrows($hmk)>0) {
					   $bobot=0;
						while ($dmk=sqlfetcharray($hmk)) {
						  if ($dmk[BOBOT]>=$bobot) {
                $bobot=$dmk[BOBOT];
    						$simbolmax=$nilai=$dmk[SIMBOL];
    						$nilai2=$dmk[NILAI];
    						$semk=$dmk[SEMESTER];
    						$tahunk=$dmk[TAHUN];              }
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
    						ORDER BY TAHUN DESC,SEMESTER DESC
    						 
    					";
    					$hmk=doquery($q,$koneksi);
    
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
 
	       if  (
            ($nilaikosong==1) || ($nilai!="MD" && $nilai!="T"   && $nilai!="" && $nilaikosong==0)
          ) {

						  $bobots[$d2[SEMESTER]]+=$d2[SKS];
	 				    $totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
						  $bobotsemua+=$d2[SKS];
						  $totalsemua+=$bobot*$d2[SKS];
  						$bobots2[$d2[SEMESTER]][$d2[JENIS]]+=$d2[SKS];
   						$totals2[$d2[SEMESTER]][$d2[JENIS]]+=$bobot*$d2[SKS];
 				} else {
            $bobot="";
          }
          if ($d2[NAMA]=="")  {
            $d2[NAMA]=$d2[NAMAMAKUL];
          }          
					$bodytranskrip.= "
							<tr $kelas$cetak align=left>
								<td>$d2[IDMAKUL]</td>
								<td> $d2[NAMA]</td>
								<td align=center>$d2[SKS] </td>";
//								<td> ".getnamamk("$d2[IDMAKUL]","".($tahunk-1)."$semk",$d[IDPRODI])."</td>
 
 								for ($is=1;$is<=$semmax;$is++) {
 									if($is==$d2[SEMESTER]) {
										$bodytranskrip.= "<td align=center>$nilai</td>";
									} else {
										$bodytranskrip.= "<td align=center></td>";
									}
								}	
 

 								$bodytranskrip.= "
							</tr>
					";
/*
///////////////// DIKTI TRNLM /////
              $idmakul=$d2[IDMAKUL];

						 $sem=$d2[SEMESTER]%2;
            if ($sem==0) {$sem=2;}//Genap
            $semkurang=ceil($d2[SEMESTER]/2);
            $tahunlama=$angkatanmhs+($semkurang);
					   include "../makul/editrnlm.php";
					    $q="UPDATE trnlm SET
							  NLAKHTRNLM='$nilai', 
                BOBOTTRNLM='$bobot'
                WHERE
                NIMHSTRNLM='$idmahasiswa'
                AND THSMSTRNLM='".($tahunlama-1)."$sem'
                AND KDKMKTRNLM='$d2[IDMAKUL]'
                ";
                 doquery($q,$koneksi);       
///////////////// END DIKTI TRNLM /////
	*/				
					$i++;
				}
 
						if ($semlama!="") {
 
						$catatan="";
						if ($d[SKSMIN] > $bobotsemua) {
							//$catatan="Total SKS tidak cukup. Total SKS minimum adalah $d[SKSMIN] SKS<br>";
						}
				}
			}	
					$bodytranskrip.= "
							<tr $kelas$cetak align=left>
								<td colspan=2>JUMLAH SKS</td>
								<td align=center>$bobotsemua</td>
								";
                $sumbobot=0;
 								for ($is=1;$is<=$semmax;$is++) {
										$bodytranskrip.= "<td align=center>".$bobots[$is]."</td>";
                    $sumbobot+=$bobots[$is];
        						 $sem=$is%2;
                    if ($sem==0) {$sem=2;}//Genap
                    $semkurang=ceil($is/2);
                    $tahunlama=$angkatanmhs+($semkurang);
                    /*
        						 	include "../makul/edittrakm.php";
//        							  NLIPKTRAKM='".number_format_sikad(@($totalsemua/$bobotsemua),2)."', 
 
        					   $q="UPDATE trakm SET
                       SKSTTTRAKM='$sumbobot'
                        WHERE
                        NIMHSTRAKM='$idmahasiswa'
                        AND THSMSTRAKM='".($tahunlama-1)."$sem'
                        ";
                        doquery($q,$koneksi);         
                        */
  								}
  								$bodytranskrip.= "
							</tr>
					";
					$bodytranskrip.= "
							<tr $kelas$cetak  align=left>
								<td colspan=3>INDEKS PRESTASI PER SEMESTER</td>
								";
                $sumbobot=$sumkr=0;
 								for ($is=1;$is<=$semmax;$is++) {
										$bodytranskrip.= "<td align=center> ".number_format_sikad(@($totals[$is]/$bobots[$is]),2,'.',',')."</td>";
                    $sumbobot+=$bobots[$is];
                    $sumkr+=$totals[$is];
        						 $sem=$is%2;
                    if ($sem==0) {$sem=2;}//Genap
                    $semkurang=ceil($is/2);
                    $tahunlama=$angkatanmhs+($semkurang);
                    /*
        						 	include "../makul/edittrakm.php";
//        							  NLIPKTRAKM='".number_format_sikad(@($totalsemua/$bobotsemua),2)."', 
 
        					   $q="UPDATE trakm SET
                       NLIPKTRAKM='".number_format_sikad(@($sumkr/$sumbobot),2)."'
                        WHERE
                        NIMHSTRAKM='$idmahasiswa'
                        AND THSMSTRAKM='".($tahunlama-1)."$sem'
                        ";
                        doquery($q,$koneksi);         
                        */

  								}
  								$bodytranskrip.= "
							</tr>
					";
						


						/*$bodytranskrip.= "
						</table>
						<table width=600>							
						<tr align=left>
								<td colspan=".(3+$semmax).">
								<p>
								<br><br>
								<table >
									<tr><td>
										Jumlah Mutu </td><td>: ".number_format_sikad($totalsemua,2,'.',',')."
									</td></tr>
									<tr><td>
								Jumlah Kredit </td><td>: ".number_format_sikad($bobotsemua,2,'.',',')." <br>
									</td></tr>
									";*/
							$bodytranskrip.= "
						</table>
						<table width=900>							
						<tr align=left>
								<td colspan=".(3+$semmax).">
								<p>
								<br><br>
								<table >
									<tr><td>
										Jumlah Mutu </td><td>: ".number_format_sikad($totalsemua,2,'.',',')."
									</td></tr>
									<tr><td>
								Jumlah Kredit </td><td>: ".number_format_sikad($bobotsemua,2,'.',',')." <br>
									</td></tr>";		
							//$bodytranskrip.= $d[JENIS]=1;		
							if ($d[JENIS]==0) { /// Biasa
								$ipkku=@($totalsemua/$bobotsemua);
								$bodytranskrip.= "
									<tr><td>
										Indeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>
										</td></tr>";
							}	 else { /// Profesi
                    if (issudahlulus($d[ID])) { // Hitung IPKUAP
    								$ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
    								$ipkkuteks=number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2);
                    
                    } else { // Hitung Biasa
    								$ipkku=@($totalsemua/$bobotsemua);
    								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua ),2);
                    }

								$bodytranskrip.= "
									<tr><td>
										Indeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>
										</td></tr>
									<tr><td>
										Indeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')." <br>
										</td></tr>
									<tr><td>
										Indeks Prestasi Kumulatif </td><td>:  ".number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2,'.',',')." <br>
										</td></tr>
										";
								}
						 //$bodytranskrip.= $d[MASABELAJAR];
						//$ipkku=0;
						 //$bodytranskrip.= $ipkku;
						$predikat="";
						#print_r($konpredikat)."ll".'<br>';
						#echo $ipkku;exit();
							if (is_array($konpredikat)) {
								//$bodytranskrip.= "hoooi";
								foreach ($konpredikat as $k=>$v) {
									if ($ipkku>=$v[SYARAT] && $d[MASABELAJAR] <= $v[SYARATW]) {
										$predikat=$v[NAMA];
 										break;
									}
								}
							}

								/*$bodytranskrip.= "
									<tr><td>
								Predikat Kelulusan </td><td>:  $predikat <br>
									</td></tr>
								</table>
								</p>
								<table   class=form>
									<tr valign=top>
										<td width=50% ><b>Judul Karya Tulis Ilmiah : </b> <br>
										".str_replace("\n","<br>",$d[TA])." </td>
										<td width=30%>
										</td>
									</tr>
								</table>
								</p>";
										
		@include "footertranskrip.php";
										
										$bodytranskrip.= "
								</td>
							</tr>
						";*/
						getpenandatangan();
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50%  ><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table><table><tr><td nowrap>*Penjelasan:<br>Nilai IPK: Jumlah Semua Nilai Mata Kuliah / Jumlah Semua SKS</td></tr><tr><td>Catatan :<br>	Kredit yg harus ditempuh ....... sks<br>	Kredit yg sudah ditempuh ....... sks<br>	Kredit yg belum ditempuh ....... sks<br><br>	Keperluan transkrip untuk ....... </td></tr></table></td><td width=10%></td><td align=center nowrap width=50%>".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}<br><br><br><br><br><br><u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</tr></table>\r\n ";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t";
    
						$q="UPDATE mahasiswa SET SKS='$bobotsemua',
						BOBOT='$totalsemua' 
						WHERE
						ID='$d[ID]'";
						doquery($q,$koneksi);

				$bodytranskrip.= "</table>
				";

						}
				
				if ($diagram==1) {
				   include "../libchart/libchart.php"; 
					if (is_array($totals)) {
 						$xx1=mt_rand();
						
            $q="INSERT INTO gambartemp VALUES('gambardiagram/"."$xx1.png',NOW())";
            doquery($q,$koneksi);
          $chart = new VerticalChart(); 
						foreach ($totals as $k=>$v) {
						   
              	$chart->addPoint(new Point("$k",@($v/$bobots[$k])));
 						}
         	$chart->setTitle("Grafik Perkembangan IP per Semester ($d[ID])");
        	$chart->render("gambardiagram/$xx1.png");		  
            $bodytranskrip.= "<img  src='gambardiagram/$xx1.png' style='border: 1px solid gray;'/>"; 
					}
				}


?>

<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
/*
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $d[ID], "pengambilanmk" );
unset( $arraydatatranskrip2 );
if ( $penempatansemester == 1 )
{
    $fpenempatan = " pengambilanmk.SEMESTERMAKUL ";
    $fpenempatansp = " pengambilanmksp.SEMESTERMAKUL ";
    $fpenempatankonversi = " nilaikonversi.SEMESTERMAKUL ";
}
else
{
    $fpenempatan = " makul.SEMESTER ";
    $fpenempatansp = " makul.SEMESTER ";
    $fpenempatankonversi = " makul.SEMESTER ";
}
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n \t\t\t\t\tUNION\r\n\t\t\t\tSELECT DISTINCT nilaikonversi.IDMAKUL, \r\n        makul.NAMA, makul.JENIS, makul.SEMESTER\r\n\t\t\t\tFROM nilaikonversi,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tnilaikonversi.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n \t\t\t\tORDER BY SEMESTER DESC,IDMAKUL \r\n\t\t\t\tLIMIT 0,1\r\n \t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    $dn = sqlfetcharray( $hn );
    $semmax = $dn[SEMESTER];
    if ( $statuspindahan == "P" )
    {
        $q = "\r\n  \t\t\t\tSELECT nilaikonversi.IDMAKUL,\r\n  \t\t\t\tmakul.NAMA,makul.JENIS,\r\n  \t\t\t\t{$fpenempatankonversi} SEMESTER\r\n  \t\t\t\tFROM nilaikonversi,makul \r\n  \t\t\t\tWHERE \r\n  \t\t\t\tnilaikonversi.IDMAKUL=makul.ID\r\n  \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n   \t\t\t\tORDER BY nilaikonversi.SEMESTERMAKUL DESC,IDMAKUL \r\n  \t\t\t\tLIMIT 0,1\r\n  \t\t\t";
        $hn = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $hn ) )
        {
            $dn = sqlfetcharray( $hn );
            if ( $semmax < $dn[SEMESTER] )
            {
                $semmax = $dn[SEMESTER];
            }
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table border=1 width=600 style='border-collapse:collapse;'  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2 align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 align=center><b>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 align=center><b>SKS</td>\r\n \t\t\t\t\t\t\t<td colspan={$semmax} align=center><b>NILAI SEMESTER</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    $bodytranskrip .= "<tr class=juduldata{$cetak} align=center>";
    $is = 1;
    while ( $is <= $semmax )
    {
        $bodytranskrip .= "<td align=center><b>{$is}</td>";
        ++$is;
    }
    $bodytranskrip .= "</tr>\r\n\t\t\t\t\t\t</thead>\r\n\t\t\t\t\t\t";
    $jenislama = 0 - 1;
    $arrayjenismakul2 = krsort( $arrayjenismakul );
    unset( $totals );
    foreach ( $arrayjenismakul as $kk => $vv )
    {
        unset( $arraydatatranskrip );
        unset( $arraydatatranskrip2 );
        $bodytranskrip .= "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center {$stylepage}>\r\n\t \r\n\t\t\t\t\t\t\t<td colspan=".( 3 + $semmax )."  align=left>{$vv}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        if ( $statuspindahan == "P" )
        {
            $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t  AND makul.JENIS='{$kk}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
            $hn2 = mysqli_query($koneksi,$q);
            #do
			while($dn2 = sqlfetcharray( $hn2 ))
            {
                if (0 < sqlnumrows( $hn2 ))
                {
                    $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
                }
            }
        }
        $q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tAND makul.JENIS='{$kk}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
        $hn = mysqli_query($koneksi,$q);
        while ( $d2 = sqlfetcharray( $hn ) )
        {
            if ( $nilaidiambil != 1 )
            {
                if ( $arraydatatranskrip2["{$d2['IDMAKUL']}"][BOBOT] <= $d2[BOBOT] )
                {
                    $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
                }
            }
            else
            {
                $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
            }
        }
        if ( $sp == 1 )
        {
            $q = "\r\n    \t\t\t\tSELECT pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\t\tAND makul.JENIS='{$kk}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
            $hn3 = mysqli_query($koneksi,$q);
            if (sqlnumrows($hn3)>0) {
    			
    			while ($d3=sqlfetcharray($hn3)) {
					if ( $nilaidiambil != 1 )
					{
						if ( $arraydatatranskrip2["{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
						{
							$arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
						}
					}
					else
					{
						$arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
					}
					
				}
					
			}
        }
        @usort( @$arraydatatranskrip2, "SortBySemester" );
        unset( $arraydatatranskrip );
        $arraydatatranskrip = $arraydatatranskrip2;
        $i = 1;
        $semlama = "";
        if ( is_array( $arraydatatranskrip ) )
        {
            foreach ( $arraydatatranskrip as $k => $d2 )
            {
                unset( $kp );
                if ( $konversisemua == 0 )
                {
                    unset( $kon );
                }
                if ( $d2[SEMESTER] != $semlama )
                {
                    $semlama = $d2[SEMESTER];
                }
                $kelas = kelas( $i );
                unset( $d2[TAHUN] );
                unset( $d2[KELAS] );
                unset( $ddmk );
                $simbolmax = "-";
                $bobot = 0;
                $nilai = "";
                $nilai2 = 0;
                $bobot = $d2[BOBOT];
                $nilai = $d2[SIMBOL];
                $nilai2 = 0;
                $simbolmax = $nilai;
                if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
                {
                    $bobots += $d2[SEMESTER];
                    $totals += $d2[SEMESTER];
                    $bobotsemua += $d2[SKS];
                    $totalsemua += $bobot * $d2[SKS];
                    $bobots2[$d2[SEMESTER]] += $d2[JENIS];
                    $totals2[$d2[SEMESTER]] += $d2[JENIS];
                }
                else
                {
                    $bobot = "";
                }
                if ( $d2[NAMA] == "" )
                {
                    $d2[NAMA] = $d2[NAMAMAKUL];
                }
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>";
                $is = 1;
                while ( $is <= $semmax )
                {
                    if ( $is == $d2[SEMESTER] )
                    {
                        $bodytranskrip .= "<td align=center>{$nilai}</td>";
                    }
                    $bodytranskrip .= "<td align=center></td>";
                    ++$is;
                }
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                ++$i;
            }
        }
        if ( $semlama != "" )
        {
            $catatan = "";
            if ( $bobotsemua < $d[SKSMIN] )
            {
            }
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2>JUMLAH SKS</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobotsemua}</td>\r\n\t\t\t\t\t\t\t\t";
    $sumbobot = 0;
    $is = 1;
    while ( $is <= $semmax )
    {
        $bodytranskrip .= "<td align=center>".$bobots[$is]."</td>";
        $sumbobot += $bobots[$is];
        $sem = $is % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $is / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        ++$is;
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=3>INDEKS PRESTASI PER SEMESTER</td>\r\n\t\t\t\t\t\t\t\t";
    $sumbobot = $sumkr = 0;
    $is = 1;
    while ( $is <= $semmax )
    {
        $bodytranskrip .= "<td align=center> ".number_format_sikad(@($totals[$is]/$bobots[$is]),2,'.',',')."</td>";
        $sumbobot += $bobots[$is];
        $sumkr += $totals[$is];
        $sem = $is % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $is / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        ++$is;
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=600>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=".( 3 + $semmax ).">\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 || $UNIVERSITAS == "STIKES SAMARINDA" )
    {
        $ipkku = @($totalsemua / $bobotsemua);
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        if ( issudahlulus( $d[ID] ) )
        {
            $ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
    		$ipkkuteks=number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2);
        }
        else
        {
            $ipkku=@($totalsemua/$bobotsemua);
    		$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua ),2);
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
    }
    $predikat = "";
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
            {
                $predikat = $v[NAMA];
                break;
            }
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>";
    @include( "footertranskrip.php" );
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $bodytranskrip .= "</table>\r\n\t\t\t\t";
}
if ( $diagram == 1 )
{
    include( "../libchart/libchart.php" );
    if ( is_array( $totals ) )
    {
        $xx1 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
        mysqli_query($koneksi,$q);
        $chart = new VerticalChart( );
        foreach ( $totals as $k => $v )
        {
            $chart->addPoint( new Point( "{$k}", @$v / @$bobots[$k] ) );
        }
        $chart->setTitle( "Grafik Perkembangan IP per Semester ({$d['ID']})" );
        $chart->render( "gambardiagram/{$xx1}.png" );
        $bodytranskrip .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
    }
}*/
?>
