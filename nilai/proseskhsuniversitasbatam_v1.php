
<style type="text/css">
	td{
		border:1px solid black;
		}
		
	.clearborder td{
		border:none;
		}	
</style>
<?

periksaroot();

			unset($arraydatanilai);
			unset($arrayipkmhs);



 
 
	/*
		if ($konversisemua==1) {
			$q="
				SELECT SIMBOL,NILAI,SYARAT FROM konversiumum
				ORDER BY NILAI DESC
			";
			
			$hkonversi=doquery($q,$koneksi);
			if (sqlnumrows($hkonversi)>0) {
				while ($dkonversi=sqlfetcharray($hkonversi)) {
					$kon[]=$dkonversi;
	 			}		
			}
		}

  */
/*  
			  $q="
				SELECT 
        pengambilanmk.BOBOT,
        pengambilanmk.SIMBOL,
        pengambilanmk.IDMAKUL,
				pengambilanmk.TAHUN,
        pengambilanmk.NAMA,
        pengambilanmk.SKSMAKUL AS SKS,
				pengambilanmk.SEMESTER AS SEMESTERS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER, 
				makul.NAMA NAMAMAKUL,
				FROM pengambilanmk,makul 
				WHERE 
				pengambilanmk.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmk.SEMESTERMAKUL,
				IDMAKUL
			";

*/

			  $q="
				SELECT 
        pengambilanmk.BOBOT,
        pengambilanmk.SIMBOL,
        pengambilanmk.IDMAKUL,
				pengambilanmk.TAHUN,
        pengambilanmk.NAMA,
        pengambilanmk.SKSMAKUL AS SKS,
				pengambilanmk.SEMESTER AS SEMESTERS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER, 
 				tbkmk.NAKMKTBKMK AS NAMAMAKUL
				FROM pengambilanmk,tbkmk,msmhs
				WHERE 

				 pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  
				AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA

				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmk.SEMESTERMAKUL,
				IDMAKUL
			";

// 				AND CONCAT(pengambilanmk.TAHUN-1,pengambilanmk.SEMESTER)=tbkmk.THSMSTBKMK  


			$hn=doquery($q,$koneksi);
			$bodykhs .=  mysqli_error($koneksi);
			if (sqlnumrows($hn)>0) {
			   while ($d2=sqlfetcharray($hn)) {
			     $arraydatanilai["$d2[TAHUN]-$d2[SEMESTERS]-$d2[IDMAKUL]"]=$d2;
			     //$bodykhs .=  "$d2[IDMAKUL]-$d2[TAHUN]-$d2[SEMESTER]<br>";
			   }
			}
// SP
  if ($sp==1) {
			  /*
        $q="
				SELECT 
        pengambilanmksp.BOBOT,
        pengambilanmksp.SIMBOL,
        pengambilanmksp.IDMAKUL,
				pengambilanmksp.TAHUN,
				makul.NAMA NAMAMAKUL,
        pengambilanmksp.NAMA,
        pengambilanmksp.SKSMAKUL AS SKS,
				pengambilanmksp.SEMESTER AS SEMESTERS,
				pengambilanmksp.SEMESTERMAKUL AS SEMESTER 
				FROM pengambilanmksp,makul 
				WHERE 
				pengambilanmksp.IDMAKUL=makul.ID
				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmksp.SEMESTERMAKUL,
				IDMAKUL
			";
      */
 			  $q="
				SELECT 
        pengambilanmksp.BOBOT,
        pengambilanmksp.SIMBOL,
        pengambilanmksp.IDMAKUL,
				pengambilanmksp.TAHUN,
        pengambilanmksp.NAMA,
        pengambilanmksp.SKSMAKUL AS SKS,
				pengambilanmksp.SEMESTER AS SEMESTERS,
				pengambilanmksp.SEMESTERMAKUL AS SEMESTER, 
 				tbkmksp.NAKMKTBKMK AS NAMAMAKUL
				FROM pengambilanmksp,tbkmksp,msmhs
				WHERE 

				 pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  
				AND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA

				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmksp.SEMESTERMAKUL,
				IDMAKUL
			";


			$hn2=doquery($q,$koneksi);
			//$bodykhs .=  mysqli_error($koneksi);
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
				$bodykhs .=  "
					<br>
					<div style='padding:2px; border:1px solid black; width:650px;'>
					<table celpadding=0 cellspacing=0 $border class=borderblack>
						<tr class=juduldata$cetak align=center style='background:#d7d7d7;'>
	 
							<td  class=tengah width=5%><b>No</td>
							<td  class=tengah  width=10%><b>Kode  </td>
							<td  class=tengah  width=56%><b>Mata Kuliah</td>
							<td  class=tengah  width=5%><b>SKS</td>
							<!-- <td class=tengah  width=9%><b>Bobot</td> -->
							<td class=tengah  width=7%><b>Nilai</td>
							<td  class=tengah><b>Mutu</td>
							<td  class=tengah><b>Keterangan</td>
						</tr>
				";
				$i=1;
				$semlama=$semlast=0;
				foreach ($arraydatanilai as $kk=>$d2) {
				  //$bodykhs .=  "$kk <br>";
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
                ($nilaikosong==1) || 
                ($d2[SIMBOL]!="MD" && $d2[SIMBOL]!="" && $d2[SIMBOL]!="T" && $nilaikosong==0)
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

//					$bodykhs .=  "$d2[TAHUN] $semesterhitungx === $semesterhitung <br>";
					if ($semesterhitung==$semesterhitungx) {

            if ($d2[NAMA]=="")  {
              $d2[NAMA]=$d2[NAMAMAKUL];
            } 
						$bodykhs .=  "
								<tr $kelas$cetak align=left>
									<td align=center width=5%>$i&nbsp;</td>
									<td align=center width=10%>$d2[IDMAKUL]&nbsp;</td>
									<td width=56%> $d2[NAMA]&nbsp;</td>
									<td align=center width=5%>$d2[SKS] &nbsp;</td>
									<!-- <td align=center width=9%>$bobot &nbsp; </td> -->
									<td align=center width=5%>$nilai  &nbsp;</td>
									<td align=center>$total&nbsp;</td>
									<td align=center>&nbsp;</td>
								</tr>
								
								
						";
						// <td> ".getnamamk("$d2[IDMAKUL]","".($tahun-1)."$semester",$d[IDPRODI])."</td>
              $idmakul=$d2[IDMAKUL];
              /*
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

						  */
						$i++;
					}
				}
						if ($semlama!="") {
						//$bodykhs .=  $totals[$d2[SEMESTER]];
							if ($semesterhitungx==$semlama) {

                   $arrayipkmhs=getipk($d[ID],$tahun,$semester,$nilaidiambil,$nilaikosong);
                  $ipkmhs=$arrayipkmhs[0];
                  $sksmhs=$arrayipkmhs[1];

							
								//$bodykhs .=  $semlama;
								$bodykhs .=  "
	               </table>	
                 
                <table>
 
 

								";
							}
						}
 						if (0/*$semlama!=""  Ditutup dulu*/) {
                  /*$q="SELECT NLIPKTRAKM FROM trakm
                  WHERE
                  THSMSTRAKM='".($tahun-1)."$semester' AND 
                  NIMHSTRAKM='$d[ID]'";
                  $hipk=doquery($q,$koneksi);
                  $dipk=sqlfetcharray($hipk);
                  */
                   $arrayipkmhs=getipk($d[ID],$tahun,$semester,$nilaidiambil,$nilaikosong);
                  $ipkmhs=$arrayipkmhs[0];
                  $sksmhs=$arrayipkmhs[1];
						$bodykhs .=  "
							<tr >
								<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>
								<td class=tengah>
								".number_format_sikad($ipkmhs ,2)."
								</td>
							</tr>
						";
						//".number_format_sikad(@($d[BOBOT]/$d[SKS]),2,'.',',')."
 
						}
 
            if ($semesterhitung > 0 && $semesterhitung <=$batasstudimhs) {
              if (isoperator() && $tingkataksesusers[$kodemenu]=="T") {
    						include "../makul/edittrakm.php";
    					}
					      $q="UPDATE trakm SET
							  NLIPSTRAKM='".number_format_sikad(@($totals[$semesterhitung]/$bobots[$semesterhitung]),2)."', 
							  NLIPKTRAKM='".number_format_sikad($ipkmhs,2)."', 
                SKSTTTRAKM='$sksmhs',
                SKSEMTRAKM='$bobots[$semesterhitung]'
                WHERE
                NIMHSTRAKM='$idmahasiswa'
                AND THSMSTRAKM='".($tahunlama-1)."$sem'
                ";
				#echo $q;exit();
                 doquery($q,$koneksi);          
                 }   

 
	 	
				$bodykhs .=  "</table>
				</div>
				<div style='padding:2px border:none; width:650px;'>
				<table width=100% celpadding=0 cellspacing=0 $border class=clearborder >
                 <tr valign=top>
					 <td align=left >	
					 <b style='font-size:8pt;'>	
					 Jumlah SKS : $bobots[$semesterhitung]. Jumlah Angka Mutu : $totals[$semesterhitung]		<br>
					 Indeks Prestasi Sementara : ".number_format_sikad(@($totals[$semesterhitung]/$bobots[$semesterhitung]),2,'.',',')."
					 Indeks Prestasi Kumulatif : ".number_format_sikad($ipkmhs ,2)."
					 <br><br>
					 
					 A=4 B=3 C=2 D=1 E=0
					 </td>
					 <td>
					 <!--FOOTERKHS-->
					 </td>
                 </tr>
                 </table>
				</div>
				";	 	

  	 	include "footerlaporankhsuniversitasbatam.php";
      $bodykhs=str_replace("<!--FOOTERKHS-->",$footerkhsx,$bodykhs);
      $bodykhs="<br>";
		
		/// Gambar Grafik ///
				if ($diagram==1) {
	
		$q="SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='$idmahasiswa' ORDER BY THSMSTRAKM  ";
		#echo $q;exit();
		$hg=doquery($q,$koneksi);
		if (sqlnumrows($h)>0) {
		
      delgambartemp();      

      $xx1=mt_rand();
      

      $q="INSERT INTO gambartemp VALUES('gambardiagram/"."$xx1.png',NOW())";
      doquery($q,$koneksi);
		
      	$chart = new VerticalChart();
        while ($dg=sqlfetcharray($hg)) {
          $thnd=substr($dg[THSMSTRAKM],0,4);
          $semd=substr($dg[THSMSTRAKM],4,1);
          $semd=$arraysemester[$semd];
        	$chart->addPoint(new Point("$semd $thnd/".($thnd+1)."", $dg[NLIPSTRAKM]));
        }
      	$chart->setTitle("Grafik IP Mahasiswa ($idmahasiswa) per Semester");
      	$chart->render("gambardiagram/$xx1.png");		  
		    $bodykhs .=  "<img  src='gambardiagram/$xx1.png' style='border: 1px solid gray;'/>"; 
		}
		
			} else {
				#echo "lll";exit();
			}
		}

?>
