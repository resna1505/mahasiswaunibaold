<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n";
echo "<s";
echo "tyle type=\"text/css\">\r\n\ttd{\r\n\t\tborder:1px solid black;\r\n\t\t}\r\n\t\t\r\n\t.clearborder td{\r\n\t\tborder:none;\r\n\t\t}\t\r\n</style>\r\n";
#include( "../libchart/libchart.php" );
periksaroot();
#unset( $arraydatanilai );
#unset( $arrayipkmhs );
/*$q = "SELECT pengambilanmk.BOBOT,pengambilanmk.SIMBOL,pengambilanmk.IDMAKUL,pengambilanmk.TAHUN,pengambilanmk.NAMA,pengambilanmk.SKSMAKUL AS SKS,".
"pengambilanmk.SEMESTER AS SEMESTERS,pengambilanmk.SEMESTERMAKUL AS SEMESTER,tbkmk.NAKMKTBKMK AS NAMAMAKUL FROM pengambilanmk,tbkmk,msmhs WHERE ".
"pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK AND ".
"msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA AND IDMAHASISWA='{$d['ID']}' ".
"AND pengambilanmk.TAHUN='{$tahun}' AND pengambilanmk.SEMESTER='{$semester}' ORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL";*/
$q="SELECT pengambilanmk.BOBOT,pengambilanmk.SIMBOL,pengambilanmk.IDMAKUL,pengambilanmk.TAHUN,makul.NAMA NAMAMAKUL,".
"pengambilanmk.NAMA,pengambilanmk.SKSMAKUL AS SKS,pengambilanmk.SEMESTER AS SEMESTERS,pengambilanmk.SEMESTERMAKUL AS SEMESTER ". 
"FROM pengambilanmk,makul WHERE pengambilanmk.IDMAKUL=makul.ID AND IDMAHASISWA='{$d['ID']}' ORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL";
#echo $q.'<br>';
$hn = doquery($koneksi,$q );
unset($arraydatanilai);
$bodykhs .= mysqli_error($koneksi);
#while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
#{
#    $arraydatanilai["{$d2['TAHUN']}-{$d2['SEMESTERS']}-{$d2['IDMAKUL']}"] = $d2;
#}
if (sqlnumrows($hn)>0) {
			   while ($d2=sqlfetcharray($hn)) {
			     $arraydatanilai["$d2[TAHUN]-$d2[SEMESTERS]-$d2[IDMAKUL]"]=$d2;
			     //$bodykhs .=  "$d2[IDMAKUL]-$d2[TAHUN]-$d2[SEMESTER]<br>";
			   }
}
if ( $sp == 1 )
{
    /*$q = "SELECT pengambilanmksp.BOBOT,pengambilanmksp.SIMBOL,pengambilanmksp.IDMAKUL,pengambilanmksp.TAHUN,pengambilanmksp.NAMA,".
	"pengambilanmksp.SKSMAKUL AS SKS,pengambilanmksp.SEMESTER AS SEMESTERS,pengambilanmksp.SEMESTERMAKUL AS SEMESTER,".
	"tbkmksp.NAKMKTBKMK AS NAMAMAKUL FROM pengambilanmksp,tbkmksp,msmhs WHERE pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  ".
	"AND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK AND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK ".
	"AND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK AND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA AND IDMAHASISWA='{$d['ID']}' ".
	"AND pengambilanmksp.TAHUN='{$tahun}' AND pengambilanmksp.SEMESTER='{$semester}' ORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL";*/
	$q = "SELECT pengambilanmksp.BOBOT,pengambilanmksp.SIMBOL,pengambilanmksp.IDMAKUL,pengambilanmksp.TAHUN,pengambilanmksp.NAMA,".
	"pengambilanmksp.SKSMAKUL AS SKS,pengambilanmksp.SEMESTER AS SEMESTERS,pengambilanmksp.SEMESTERMAKUL AS SEMESTER,".
	"tbkmksp.NAKMKTBKMK AS NAMAMAKUL FROM pengambilanmksp,tbkmksp,msmhs WHERE pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  ".
	"AND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK AND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK ".
	"AND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK AND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA AND IDMAHASISWA='{$d['ID']}' ".
	"ORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL";
    #echo $q.'<br>';
	$hn2 = doquery($koneksi,$q );
	if (sqlnumrows($hn2)>0) {
			   while ($d3=sqlfetcharray($hn2)) {
  			   if ($nilaidiambil!=1) { // Yang terbaik
  			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
  			     if ($arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"]['BOBOT']<=$d3['BOBOT']) {
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
@ksort($arraydatanilai );
#print_r($arraydatanilai);
#echo '<br>';
#$totals[$semesterhitungx]=array();
if ( is_array( $arraydatanilai ) )
{
	#echo "masuk array";
    if ( $semester != 3 )
    {
        #$semesterhitung = (( $tahun - 1 - $d['ANGKATAN'] ) * 2) + $semester;
		$smstrhtg = (( $tahun - 1 - $d['ANGKATAN'] ) * 2) + $semester;
    }
    else
    {
        #$semesterhitung = (( $tahun - 1 - $d['ANGKATAN'] ) * 2) + 0.5;
		$smstrhtg = (( $tahun - 1 - $d['ANGKATAN'] ) * 2) + 0.5;
    }
    $bodykhs .= "<br><div style='padding:2px; border:0px solid black; width:100%;'><table celpadding=0 cellspacing=0 {$border} class=borderblack>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center style='background:#d7d7d7;'>\r\n\t \r\n\t\t\t\t\t\t\t<td  class=tengah width=5%><b>No</td>\r\n\t\t\t\t\t\t\t<td  class=tengah  width=12%><b>Kode  </td>\r\n\t\t\t\t\t\t\t<td  class=tengah  width=56%><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td  class=tengah  width=8%><b>SKS</td>\r\n\t\t\t\t\t\t\t<!-- <td class=tengah  width=9%><b>Bobot</td> -->\r\n\t\t\t\t\t\t\t<td class=tengah  width=9%><b>Nilai</td>\r\n\t\t\t\t\t\t\t<td  class=tengah width=10%><b>Mutu</td>\r\n\t\t\t\t\t\t\t<td  class=tengah><b>Keterangan</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $semlama = $semlast = 0;
    foreach ( $arraydatanilai as $kk => $d2 )
    {
		#print_r($arraydatanilai);
		#echo '<br>';
        unset( $kp );
        if ( $d2['SEMESTERS'] != 3 )
        {
            $semesterhitungnya = (( $d2['TAHUN'] - 1 - $d['ANGKATAN'] ) * 2) + $d2['SEMESTERS'];
			#$smstrhtgx = (( $d2['TAHUN'] - 1 - $d['ANGKATAN'] ) * 2) + $d2['SEMESTERS'];
        }
        else
        {
            $semesterhitungnya = (( $d2['TAHUN'] - 1 - $d['ANGKATAN'] ) * 2) + 0.5;
			#$smstrhtgx = (( $d2['TAHUN'] - 1 - $d['ANGKATAN'] ) * 2) + 0.5;
        }
        $kelas = kelas($i);
		#echo "KELAS 1";
		#echo '<br>';
        $semlama = $semesterhitungnya;
        $kelas = kelas($i);
        #echo "KELAS 2";
		#echo '<br>';
		$nilai = "";
        $total = "";
        $bobot = "";
		$totalnilaiakhir=0;
		#$totals[$semesterhitungx]=0;
		#$bobots[$semesterhitungx]="";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        $nilaiakhir = $nilaiakhirdicari;
        $totalmax = $totalmaxdicari;
        $bobotmax = $bobotmaxdicari;
        $simbolmax = $simbolmaxdicari;
	#echo "NILAI KOSONG=".$nilaikosong;
	#echo "<br>";
	#echo "SIMBOL=".$d2['SIMBOL']."<br>";
        #if ( $nilaikosong == 1 || $d2[SIMBOL] != "MD" && $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" && $nilaikosong == 0 )
		if(($nilaikosong==1) || ($d2['SIMBOL']!="MD" && $d2['SIMBOL']!="" && $d2['SIMBOL']!="T" && $nilaikosong==0))
        {
			#echo "NILAI KOSONG";
			#echo '<br>';
		
            $totalnilaiakhir+=$nilaiakhir;								 
			$nilai=$d2['SIMBOL'];
			$bobot=$d2['BOBOT'];
			$IDMAKUL=$d2['IDMAKUL'];
			/*$total=number_format_sikad($d2['SKS']*$d2['BOBOT'],2,'.',',');
			
			$totals[$semesterhitungx]= $totals[$semesterhitungx]+($d2['SKS']*$d2['BOBOT']);
			$totalsemua=$totalsemua+$totals[$semesterhitungx];
			#$totalsemua=$totalsemua+$totalmax;
			$bobots[$semesterhitungx]=$bobots[$semesterhitungx]+$d2['SKS'];
			$bobotsemua=$bobotsemua+$d2['SKS'];
			
			echo "TOTAL=".$total.'<br>';
			echo "SEMESTER HITUNG X=".$semesterhitungx.'<br>';
			echo "TOTAL SEMESTER HITUNG X=".$totals[$semesterhitungx].'<br>';
			echo "TOTAL SEMUA=".$totalsemua.'<br>';
			echo "BOBOT SEMESTER HITUNG X=".$bobots[$semesterhitungx].'<br>';
			echo "BOBOT SEMUA=".$bobotsemua.'<br>';*/

			$total=number_format_sikad($d2['SKS']*$d2['BOBOT'],2,'.',',');
			/*echo "TOTAL=".$total.'<br>';
			$totalnya=$total;
			$sksbobot=$sksbobot+($d2['SKS']*$d2['BOBOT']);
			echo "SKS BOBOT=".$sksbobot.'<br>';
			#$totals[$smstrhtgx] += $total;
			echo "SEMESTER HITUNG =".$smstrhtg.'<br>';
			echo "SEMESTER HITUNG X=".$semesterhitungnya.'<br>';
			
			$totals[$semesterhitungnya]=$totals[$semesterhitungnya]+$totalnya;
			print_r($totals);
			echo "<br>";
			echo "TOTAL SEMESTER HITUNG X=".$totals[$semesterhitungnya].'<br>';
			
			#$totals2[$semesterhitungnya]=$totals2[$semesterhitungnya]+$totals[$semesterhitungnya];
			#echo "TOTAL 2 SEMESTER HITUNG X=".$totals2[$semesterhitungnya].'<br>';
			#$totalsemua=$totalsemua+$totalmax;
			$totalsemua+=$total;
			echo "TOTAL SEMUA=".$totalsemua.'<br>';
			
			$bobots[$semesterhitungnya]=$bobots[$semesterhitungnya]+$d2['SKS'];
			echo "BOBOT SEMESTER HITUNG X=".$bobots[$semesterhitungnya].'<br>';
			
			$bobotsemua+=$d2['SKS'];
			echo "BOBOT SEMUA=".$bobotsemua.'<br>';*/
			#echo "BOBOT SEMUA";
			#echo '<br>';
        }
		
			$bobots2[$semesterhitungnya]+=$d2['SKS'];
			
			
			#$bobots2[$smstrhtg]+=$d2['SKS'];
			#$totals2[$smstrhtg]+=$sksbobot;
        #if ( $semesterhitung == $semesterhitungx )
		if ( $smstrhtg == $semesterhitungnya )	
        {
			#echo "SEMESTER HITUNG SAMA";
			#echo '<br>';
			
			$totals2[$semesterhitungnya]+=$total;
			
            if ( $d2['NAMA'] == "" )
            {
                $d2['NAMA'] = $d2['NAMAMAKUL'];
            }
            $bodykhs .= "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t\t<td align=center width=5%>{$i}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center width=10%>{$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td width=56%> {$d2['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center width=5%>{$d2['SKS']} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<!-- <td align=center width=9%>{$bobot} &nbsp; </td> -->\r\n\t\t\t\t\t\t\t\t\t<td align=center width=5%>{$nilai}  &nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>&nbsp;</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t";
            $idmakul = $d2['IDMAKUL'];
			#echo "MAKUL".'<br>';
			include "../makul/editrnlm.php";
					   $q="UPDATE trnlm SET
							  NLAKHTRNLM='$nilai', 
                BOBOTTRNLM='$bobot'
                WHERE
                NIMHSTRNLM='$idmahasiswa'
                AND THSMSTRNLM='".($tahunlama-1)."$sem'
                AND KDKMKTRNLM='$d2[IDMAKUL]'
                ";
				#echo $q.'<br>';
                doquery($koneksi,$q);   
            ++$i;
        }
    }
    #if ( $semlama != "" && $semesterhitungx == $semlama )
	if($semlama!="")
    {
		#echo "SEM LAMA GET IPK";
			#echo '<br>';
		#if ($semesterhitungx==$semlama) {
		if ($semesterhitungnya==$semlama) {	

                   $arrayipkmhs=getipk($d['ID'],$tahun,$semester,$nilaidiambil,$nilaikosong);
                  $ipkmhs=$arrayipkmhs[0];
                  $sksmhs=$arrayipkmhs[1];

							
								//$bodykhs .=  $semlama;
								$bodykhs .=  "
	               </table>	
                 
                <table>
 
 

								";
		}
        #$arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
        #$ipkmhs = $arrayipkmhs[0];
        #$sksmhs = $arrayipkmhs[1];
        #$bodykhs .= "\r\n\t               </table>\t\r\n                 \r\n                <table>\r\n \r\n \r\n\r\n\t\t\t\t\t\t\t\t";
    }
    if ( 0 )
    {
		#echo "GET IPK";
			#echo '<br>';
        $arrayipkmhs = getipk( $d['ID'], $tahun, $semester, $nilaidiambil, $nilaikosong );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        $bodykhs .= "\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>\r\n\t\t\t\t\t\t\t\t<td class=tengah>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    }
    if ( 0 < $smstrhtg && $smstrhtg <= $batasstudimhs )
    {
        if ( isoperator( ) && $tingkataksesusers[$kodemenu] == "T" )
        {
			#echo "OPERATOR";
			#echo '<br>';
            include( "../makul/edittrakm.php" );
        }
	#echo "IPK MHS=".$ipkmhs.'<br>';
		/*echo "Totals=".$totals[$smstrhtg].'<br>';
        echo "Bobots=".$bobots[$smstrhtg].'<br>';
		echo "Totalsx=".$totals[$semesterhitungnya].'<br>';
        echo "Bobotsx=".$bobots[$semesterhitungnya].'<br>';
		echo "Totals2=".$totals2[$smstrhtg].'<br>';
        echo "Bobots2=".$bobots2[$smstrhtg].'<br>';
		echo "Totals2x=".$totals2[$semesterhitungnya].'<br>';
        echo "Bobots2x=".$bobots2[$semesterhitungnya].'<br>';*/
	

        
		 /*$q="UPDATE trakm SET
							  NLIPSTRAKM='".number_format_sikad(@($totals[$smstrhtg]/$bobots[$smstrhtg]),2)."', 
							  NLIPKTRAKM='".number_format_sikad($ipkmhs,2)."', 
                SKSTTTRAKM='$sksmhs',
                SKSEMTRAKM='$bobots[$smstrhtg]'
                WHERE
                NIMHSTRAKM='$idmahasiswa'
                AND THSMSTRAKM='".($tahunlama-1)."$sem'
                ";*/
				$q="UPDATE trakm SET
							  NLIPSTRAKM='".number_format_sikad(@($totals2[$smstrhtg]/$bobots2[$smstrhtg]),2)."', 
							  NLIPKTRAKM='".number_format_sikad($ipkmhs,2)."', 
                SKSTTTRAKM='$sksmhs',
                SKSEMTRAKM='$bobots2[$semesterhitungnya]'
                WHERE
                NIMHSTRAKM='$idmahasiswa'
                AND THSMSTRAKM='".($tahunlama-1)."$sem'
                ";
		/*$q = "UPDATE trakm SET NLIPSTRAKM='".number_format_sikad( $ipsemmhs, 2 )."', NLIPKTRAKM='".number_format_sikad( $ipkmhs, 2 )."', SKSTTTRAKM='{$sksmhs}',SKSEMTRAKM='{$skssemmhs}' WHERE  NIMHSTRAKM='{$idmahasiswa}' AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'";
                            #echo "UPDATE IPS / IPK=".$q.'<br>';
		*/
				#echo $q.'<br>';
                 doquery($koneksi,$q);      
    }
    #$bodykhs .= "</table>\r\n\t\t\t\t</div>\r\n\t\t\t\t<div style='padding:2px border:none; width:650px;'>\r\n\t\t\t\t<table width=100% celpadding=0 cellspacing=0 {$border} class=clearborder >\r\n                 <tr valign=top>\r\n\t\t\t\t\t <td align=left >\t\r\n\t\t\t\t\t <b style='font-size:8pt;'>\t\r\n\t\t\t\t\t Jumlah SKS : {$bobots[$semesterhitung]}. Jumlah Angka Mutu : {$totals[$semesterhitung]}\t\t<br>\r\n\t\t\t\t\t Indeks Prestasi Sementara : ".number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t Indeks Prestasi Kumulatif : ".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t <br><br>\r\n\t\t\t\t\t \r\n\t\t\t\t\t A=4 B=3 C=2 D=1 E=0\r\n\t\t\t\t\t </td>\r\n\t\t\t\t\t <td>\r\n\t\t\t\t\t <!--FOOTERKHS-->\r\n\t\t\t\t\t </td>\r\n                 </tr>\r\n                 </table>\r\n\t\t\t\t</div>\r\n\t\t\t\t";
    $bodykhs .=  "</table>
				</div>
				<div style='padding:2px border:none; width:650px;'>
				<table width=100% celpadding=0 cellspacing=0 $border class=clearborder >
                 <tr valign=top>
					 <td align=left >	
					 <b style='font-size:8pt;'>	
					 Jumlah SKS : $bobots2[$smstrhtg]. Jumlah Angka Mutu : $totals2[$smstrhtg]		<br>
					 Indeks Prestasi Sementara : ".number_format_sikad(@($totals2[$smstrhtg]/$bobots2[$smstrhtg]),2,'.',',')."
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
	include( "footerlaporankhsuniversitasbatam.php" );
    $bodykhs = str_replace( "<!--FOOTERKHS-->", $footerkhsx, $bodykhs );
    
}
?>
