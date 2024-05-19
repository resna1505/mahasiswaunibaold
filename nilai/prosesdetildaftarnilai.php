<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $totalbm );
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $d['ID'], "pengambilanmk" );
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
$jmlkonversi = 0;
if ( $statuspindahan == "P" )
{
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = doquery($koneksi,$q );
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    if (sqlnumrows($hn2)>0) {
      			 while ($dn2=sqlfetcharray($hn2)) {
      			   //$arraydatatranskrip["$dn2['SEMESTER']-$dn2['IDMAKUL']"]=$dn2;
      			   $arraydatatranskrip2["{$dn2['IDMAKUL']}"]=$dn2;
      			   $jmlkonversi++;
             }
    }

}
$q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = doquery($koneksi,$q );
$jumlahmakuldiambil = sqlnumrows( $hn ) + $jmlkonversi;
while ( $d2 = sqlfetcharray( $hn ) )
{
    if ( $nilaidiambil != 1 )
    {
        if ( $arraydatatranskrip2["{$d2['IDMAKUL']}"]['BOBOT'] <= $d2['BOBOT'] )
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul,tbkmksp ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = doquery($koneksi,$q );
    $bodytranskrip .= mysqli_error($koneksi);
    if (sqlnumrows($hn3)>0) {
    			
    			 while ($d3=sqlfetcharray($hn3)) {
    			   if ($nilaidiambil!=1) { // Yang terbaik
    			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
    			     if ($arraydatatranskrip2["{$d3['IDMAKUL']}"]['BOBOT']<=$d3['BOBOT']) {
        			   //$arraydatatranskrip["$d3['SEMESTER']-$d3['IDMAKUL']"]=$d3;
        			   $arraydatatranskrip2["{$d3['IDMAKUL']}"]=$d3;
               }
             } else {
      			   //$arraydatatranskrip["$d3['SEMESTER']-$d3['IDMAKUL']"]=$d3;
      			   $arraydatatranskrip2["{$d3['IDMAKUL']}"]=$d3;
             }
             $jumlahmakuldiambil++;
           }
          }
}
usort($arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$borderkanan = " style='border-right:solid ;border-right-width:1px;'";
$borderbawah = " style='border-bottom:solid ;border-bottom-width:1px;'";
$jumlahmakuldiambilper2 = ceil( count( $arraydatatranskrip ) / 2 );
if ( 0 < $jumlahmakuldiambil )
{
	
				/*if ($aksi=="cetak") {
					$bodytranskrip.= "
					<br>
					<table width=900 cellspacing=0 cellpadding=0>
					<tr valign=top>
					<td width=50% valign=top>";
				}*/
	$bodytranskrip.="	<div class=\"m-portlet\">			
							<div class=\"m-section__content\">
								<div class=\"table-responsive\">
									<table class=\"table table-bordered table-hover\">
										<thead>";		
					
				
				$i=1;
				$semlama="";
				unset($totals);
				if (is_array($arraydatatranskrip))
				foreach ($arraydatatranskrip as $k=>$d2) {
					if ($aksi=="cetak") {
						if ($i==$jumlahmakuldiambilper2+1 ) {
									/*$bodytranskrip.= "
									
				
						 
						 
											<tr class=juduldata$cetak align=center>
						 
												 
											<td align=center $borderkanan  ><b>No</td>
												<td align=center $borderkanan><b>Kode</td>
												<td align=center  $borderkanan><b>Mata Kuliah</td>
										<td align=center $borderkanan><b>Sem</td>
										<td align=center $borderkanan><b>SKS<br>(K)</td>
										<td align=center $borderkanan><b>Nilai<br>(M)</td>
			   
										<td align=center><b>KxM</td>
											</tr>									
								</thead>					
									";*/
							$bodytranskrip.= "		<tr class=juduldata$cetak align=center>						 
												<td align=center ><b>No</td>
												<td align=center ><b>Kode</td>
												<td align=center ><b>Mata Kuliah</td>
													<td align=center ><b>Sem</td>
												<td align=center><b>SKS <br>(K)</td>
												<td align=center><b>Nilai <br>(M)</td>
					 
												<td align=center  ><b>KxM</td>
											</tr>
										</thead>
										<tbody>";		
						}
					}	
					
					
 
					unset($kp);
					if ($konversisemua==0) {
						unset($kon);
					}
 
					$kelas=kelas($i);
					
				unset($d2['TAHUN']);
				unset($d2['KELAS']);
				unset($ddmk);
					$simbolmax="-";
					$bobot=0;
					$nilai="";
					$nilai2=0;				
					
          $bobot=$d2[BOBOT];
          $nilai=$d2[SIMBOL];
          $nilaiakhir=$d2[NILAI];
          $nilai2=0;
          $simbolmax=$nilai;					
					
 
 
	       if  (
            ($nilaikosong==1) || ($nilai!="MD" && $nilai!="T"   && $nilai!="" && $nilaikosong==0)
          ) {
						  $bobots[$d2['SEMESTER']]=$bobots[$d2['SEMESTER']]+$d2['SKS'];
	 				    $totals[$d2['SEMESTER']]=$totals[$d2['SEMESTER']]+($bobot*$d2['SKS']);
						  $bobotsemua=$bobotsemua+$d2['SKS'];
						  $totalsemua=$totalsemua+($bobot*$d2['SKS']);
  						$bobots2[$d2['SEMESTER']][$d2['JENIS']]=($bobots2[$d2['SEMESTER']][$d2['JENIS']])+$d2[SKS];
   						$totals2[$d2['SEMESTER']][$d2['JENIS']]=($totals2[$d2['SEMESTER']][$d2['JENIS']])+$bobot*$d2[SKS];
 						   $totalbm=$totalbm+($d2['SKS']*$bobot);
					} else {
            $bobot="";
          }
          if ($d2['NAMA']=="")  {
            $d2['NAMA']=$d2['NAMAMAKUL'];
          }          
					$bodytranskrip.= "
							<tr $kelas$cetak align=left valign=top>
								<td align=right width=\"5%\" >$i.</td>
								<td width=\"10%\">{$d2['IDMAKUL']}</td>
								<td width=\"45%\">{$d2['NAMA']}</td>
  								<td width=\"5%\" align=center>{$d2['SEMESTER']} <!-- ".number_format_sikad($bobot,0)." --> </td>
								<td width=\"5%\" align=center>{$d2['SKS']}</td>
  								<td width=\"5%\" align=center>{$nilai}</td>
  								<td width=\"5%\" align=center >".number_format_sikad($d2['SKS']*$bobot,0)."  </td>
							</tr>
					";
					
					if ($bobot>=2) {
            $totalnilailulus+=$d2['SKS'];
          }
					
//								<td>  ".getnamamk("{$d2['IDMAKUL']}","".($tahunk-1)."$semk",$d['IDPRODI'])."</td>
					
 
					$i++;
				}

					/*$bodytranskrip.= "
							<tr $kelas$cetak  align=left>
								<td colspan=4 align=left> JUMLAH SKS YANG DIKUMPUL</td>
								<td align=center><b>$bobotsemua </td>
 
								<td align=center> </td>
		
 								<td align=center><b>".number_format_sikad($totalbm,0)."</td>
							</tr>
							</table>";*/
							$bodytranskrip.= "
							<tr $kelas$cetak  align=left>
								<td colspan=4 align=left> JUMLAH SKS YANG DIKUMPUL</td>
								<td align=center><b>$bobotsemua </td>
 
								<td align=center> </td>
		
 								<td align=center><b>".number_format_sikad($totalbm,0)."</td>
							</tr>
							";
							
							/*if ($aksi=="cetak") {
							$bodytranskrip.= "
							</td>
							</tr>
							<tr>
							<td colspan=2>
								
							";
							} else {
								$bodytranskrip.= "<TABLE>";
							}*/

 
						$catatan="";
						if ($d['SKSMIN'] > $bobotsemua) {
							//$catatan="Total SKS tidak cukup. Total SKS minimum adalah $d[SKSMIN] SKS<br>";
						}
						

							if ($d['JENIS']==0) { /// Biasa
								$ipkku=@($totalsemua/$bobotsemua);
								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua),2);
								$tmp=explode(".",$ipkkuteks);
								$tmp1=angkatoteks($tmp[0]);
								$blkkoma=$tmp[1];
								$tmp2="";
								for ($ia=0;$ia<=strlen($blkkoma)-1;$ia++) {
									 //$bodytranskrip.= $blkkoma[$ia];
									 $tmp2.=$angka[$blkkoma[$ia]+0]." ";
								}
 
							}	 else { /// Profesi
 

                    if (issudahlulus($d[ID])) { // Hitung IPKUAP
    								$ipkku=@((($totalsemua/$bobotsemua)+$d['IPKUAP'])/2);
    								$ipkkuteks=number_format_sikad(@((($totalsemua/$bobotsemua)+$d['IPKUAP'])/2),2);
                    
                    } else { // Hitung Biasa
    								$ipkku=@($totalsemua/$bobotsemua);
    								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua ),2);
                    }

                  
                  
								$ipkku=@((($totalsemua/$bobotsemua)+$d['IPKUAP'])/2);
								$tmp=explode(".",$ipkkuteks);
								$tmp1=angkatoteks($tmp[0]);
								$blkkoma=$tmp[1];
								$tmp2="";
								for ($ia=0;$ia<=strlen($blkkoma)-1;$ia++) {
									 //$bodytranskrip.= $blkkoma[$ia];
									 $tmp2.=$angka[$blkkoma[$ia]+0]." ";
								}							
 
								}
 
						$predikat="";
							if (is_array($konpredikat)) {
								//$bodytranskrip.= "hoooi";
								foreach ($konpredikat as $k=>$v) {
									if ($ipkku>=$v['SYARAT'] && $d['MASABELAJAR'] <= $v['SYARATW']) {
										$predikat=$v['NAMA'];
 										break;
									}
								}
							}

						
						/*$bodytranskrip.= "
						<tr>
              <td>Keterangan : <br>
              * = Nilai Ujian Pengawasan Mutu <br>
              KxM = Kredit dikalikan Nilai 
                                          </td>
              <td  align=left>
                <table width=100% border=1  style='border-collapse:collapse;' >
                  <tr>
                    <td>Jumlah SKS Yang Lulus</td>
                    <td>:</td>
                    <td>$totalnilailulus </td>
                  </tr>
                  <tr>
                    <td>Indeks Prestasi Kumulatif</td>
                    <td>:</td>
                    <td>$ipkkuteks </td>
                  </tr>                
                   
                  </table>
               </td>
            </tr>
 
					</table>";
			*/	
$bodytranskrip.= "
						<tr>
              <td colspan=\"2\">Keterangan : <br>
              * = Nilai Ujian Pengawasan Mutu <br>
              KxM = Kredit dikalikan Nilai 
                                          </td>
              <td  align=left>
                <table width=100% border=1  style='border-collapse:collapse;' >
                  <tr>
                    <td>Jumlah SKS Yang Lulus</td>
                    <td>:</td>
                    <td>$totalnilailulus </td>
                  </tr>
                  <tr>
                    <td>Indeks Prestasi Kumulatif</td>
                    <td>:</td>
                    <td>$ipkkuteks </td>
                  </tr>                
                   
                  </table>
               </td>
            </tr>";			
		include "footerdaftarnilai.php";
										
										$bodytranskrip.= "
						";
					/*	$q="UPDATE mahasiswa SET SKS='$bobotsemua',
						BOBOT='$totalsemua' 
						WHERE
						ID='$d[ID]'";
						doquery($q,$koneksi);
					*/	  
 
    /*if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table width=900 cellspacing=0 cellpadding=0>\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50% valign=top>";
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table    border=1 width=100%  style='border-collapse:collapse;'   >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center {$borderbawah}>\r\n\t \r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t<td align=center {$borderkanan}  ><b>No</td>\r\n\t\t\t\t\t\t\t<td align=center {$borderkanan}  ><b>Kode</td>\r\n\t\t\t\t\t\t\t<td align=center  {$borderkanan}  ><b>Mata Kuliah</td>\r\n      \t\t\t\t\t\t\t<td align=center {$borderkanan}  ><b>Sem</td>\r\n\t\t\t\t\t\t\t<td align=center {$borderkanan}  ><b>SKS <br>(K)</td>\r\n\t\t\t\t\t\t\t<td align=center {$borderkanan}  ><b>Nilai <br>(M)</td>\r\n \r\n \t\t\t\t\t\t\t<td align=center  ><b>KxM</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $aksi == "cetak" && $i == $jumlahmakuldiambilper2 + 1 )
            {
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\r\n \t\t\r\n                 \r\n                 </table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table   border=1 width=100%  style='border-collapse:collapse;' >\r\n      \t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t        \t<td align=center {$borderkanan}  ><b>No</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center {$borderkanan}><b>Kode</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center  {$borderkanan}><b>Mata Kuliah</td>\r\n      \t\t\t\t\t\t\t<td align=center {$borderkanan}><b>Sem</td>\r\n      \t\t\t\t\t\t\t<td align=center {$borderkanan}><b>SKS<br>(K)</td>\r\n      \t\t\t\t\t\t\t<td align=center {$borderkanan}><b>Nilai<br>(M)</td>\r\n       \r\n       \t\t\t\t\t\t\t<td align=center><b>KxM</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
            }
            unset( $kp );
            if ( $konversisemua == 0 )
            {
                unset( $kon );
            }
            $kelas = kelas( $i );
            unset( $d2['TAHUN'] );
            unset( $d2['KELAS'] );
            unset( $ddmk );
            $simbolmax = "-";
            $bobot = 0;
            $nilai = "";
            $nilai2 = 0;
            $bobot = $d2['BOBOT'];
            $nilai = $d2['SIMBOL'];
            $nilaiakhir = $d2['NILAI'];
            $nilai2 = 0;
            $simbolmax = $nilai;
            if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
            {
                $bobots=$bobots+$d2['SEMESTER'];
                $totals=$totals+$d2['SEMESTER'];
                $bobotsemua=$bobotsemua+$d2['SKS'];
                $totalsemua=$totalsemua+($bobot * $d2['SKS']);
                $bobots2[$d2['SEMESTER']]=$bobots2[$d2['SEMESTER']]+$d2['JENIS'];
                $totals2[$d2['SEMESTER']]=$totals2[$d2['SEMESTER']]+$d2['JENIS'];
                $totalbm=$totalbm+($d2['SKS'] * $bobot);
            }
            else
            {
                $bobot = "";
            }
            if ( $d2['NAMA'] == "" )
            {
                $d2['NAMA'] = $d2['NAMAMAKUL'];
            }
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top>\r\n\t\t\t\t\t\t\t\t<td align=right  >{$i}.</td>\r\n\t\t\t\t\t\t\t\t<td {$borderkanan}>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td {$borderkanan}> {$d2['NAMA']}</td>\r\n  \t\t\t\t\t\t\t\t<td align=center {$borderkanan}> {$d2['SEMESTER']} <!-- ".number_format_sikad( $bobot, 0 )." --> </td>\r\n\t\t\t\t\t\t\t\t<td align=center {$borderkanan}>{$d2['SKS']} </td>\r\n  \t\t\t\t\t\t\t\t<td align=center {$borderkanan}>{$nilai} </td>\r\n  \t\t\t\t\t\t\t\t<td align=center >".number_format_sikad( $d2['SKS'] * $bobot, 0 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            if ( 2 <= $bobot )
            {
                $totalnilailulus=$totalnilailulus+$d2['SKS'];
            }
            ++$i;
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=4 align=left> JUMLAH SKS YANG DIKUMPUL</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n \r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n\t\t\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 0 )."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        $bodytranskrip .= "<TABLE>";
    }
    $catatan = "";
    if ( !( $bobotsemua < $d[SKSMIN] ) || $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / @$bobotsemua;
        $ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
        $tmp = explode( ".", $ipkkuteks );
        $tmp1 = angkatoteks( $tmp[0] );
        $blkkoma = $tmp[1];
        $tmp2 = "";
        $ia = 0;
        while ( $ia <= strlen( $blkkoma ) - 1 )
        {
            $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
            ++$ia;
        }
    }
    else
    {
        if ( issudahlulus( $d['ID'] ) )
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d['IPKUAP'] ) / 2;
            $ipkkuteks = number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d['IPKUAP'] ) / 2, 2 );
        }
        else
        {
            $ipkku = @$totalsemua / @$bobotsemua;
            $ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
        }
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d['IPKUAP'] ) / 2;
        $tmp = explode( ".", $ipkkuteks );
        $tmp1 = angkatoteks( $tmp[0] );
        $blkkoma = $tmp[1];
        $tmp2 = "";
        $ia = 0;
        while ( $ia <= strlen( $blkkoma ) - 1 )
        {
            $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
            ++$ia;
        }
    }
    $predikat = "";
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            if ( $v['SYARAT'] <= $ipkku && $d['MASABELAJAR'] <= $v['SYARATW'] )
            {
                $predikat = $v['NAMA'];
                break;
            }
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t<tr>\r\n              <td>Keterangan : <br>\r\n              * = Nilai Ujian Pengawasan Mutu <br>\r\n              KxM = Kredit dikalikan Nilai \r\n                                          </td>\r\n              <td  align=left>\r\n                <table width=100% border=1  style='border-collapse:collapse;' >\r\n                  <tr>\r\n                    <td>Jumlah SKS Yang Lulus</td>\r\n                    <td>:</td>\r\n                    <td>{$totalnilailulus} </td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td>Indeks Prestasi Kumulatif</td>\r\n                    <td>:</td>\r\n                    <td>{$ipkkuteks} </td>\r\n                  </tr>                \r\n                   \r\n                  </table>\r\n               </td>\r\n            </tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\r\n \r\n ";
    @include( "footerdaftarnilai.php" );
    $bodytranskrip .= "\r\n\t\t\t\t\t\t";*/
}
/*if ( $diagram == 1 )
{
    #include( "../libchart/libchart.php" );
    if ( is_array( $totals ) )
    {
        $xx1 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
        doquery($koneksi,$q );
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
