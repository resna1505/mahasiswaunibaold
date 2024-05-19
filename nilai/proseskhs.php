<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

/*periksaroot( );
unset( $arraydatanilai );
unset( $arrayipkmhs );
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.SIMBOL,\r\n        pengambilanmk.IDMAKUL,\r\n\t\t\t\tpengambilanmk.TAHUN,\r\n        pengambilanmk.NAMA,\r\n        pengambilanmk.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmk.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmk.SEMESTERMAKUL AS SEMESTER, \r\n \t\t\t\ttbkmk.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmk,tbkmk,msmhs\r\n\t\t\t\tWHERE \r\n\r\n\t\t\t\t pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
$hn = doquery($koneksi,$q );
$bodykhs .= mysqli_error($koneksi);
while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
{
    $arraydatanilai["{$d2['TAHUN']}-{$d2['SEMESTERS']}-{$d2['IDMAKUL']}"] = $d2;
}
if ( $sp == 1 )
{
    $q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n        pengambilanmksp.NAMA,\r\n        pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER, \r\n \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\r\n\t\t\t\tWHERE \r\n\r\n\t\t\t\t pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
    $hn2 = doquery($koneksi,$q );
    if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $d3 = sqlfetcharray( $hn2 ) ) )
    {
    }
    else if ( $nilaidiambil != 1 )
    {
        if ( $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
        {
            $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"] = $d3;
        }
    }
    else
    {
        $arraydatanilai["{$d3['TAHUN']}-{$d3['SEMESTERS']}-{$d3['IDMAKUL']}"] = $d3;
    }
}
@ksort( @$arraydatanilai );
if ( is_array( $arraydatanilai ) )
{
    if ( $semester != 3 )
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
    }
    else
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
    }
    $bodykhs .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table celpadding=0 cellspacing=0 {$border} class=borderblack>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2 class=tengah><b>No</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 class=tengah><b>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 class=tengah><b>Kode</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 class=tengah><b>Bobot/<br>Sks<br>(b)</td>\r\n\t\t\t\t\t\t\t<td colspan=2 class=tengah><b>Nilai</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 class=tengah><b>(b)x(m) <br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t\t<td class=tengah><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center >\r\n\t \r\n\t\t\t\t\t\t\t<td class=tengah><b>1</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>2</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>3</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>4</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>5</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>6</td>\r\n\t\t\t\t\t\t\t<td class=tengah><b>7</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $semlama = $semlast = 0;
    foreach ( $arraydatanilai as $kk => $d2 )
    {
        unset( $kp );
        if ( $d2[SEMESTERS] != 3 )
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d2[SEMESTERS];
        }
        else
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + 0.5;
        }
        $kelas = kelas( $i );
        $semlama = $semesterhitungx;
        $kelas = kelas( $i );
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        $nilaiakhir = $nilaiakhirdicari;
        $totalmax = $totalmaxdicari;
        $bobotmax = $bobotmaxdicari;
        $simbolmax = $simbolmaxdicari;
        if ( $nilaikosong == 1 || $d2[SIMBOL] != "MD" && $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" && $nilaikosong == 0 )
        {
            $totalnilaiakhir += $nilaiakhir;
            $nilai = $d2[SIMBOL];
            $bobot = $d2[BOBOT];
            $total = number_format_sikad( $d2[SKS] * $d2[BOBOT], 2, ".", "," );
            $totals += $semesterhitungx;
            $totalsemua += $totalmax;
            $bobots += $semesterhitungx;
            $bobotsemua += $d2[SKS];
        }
        if ( $semesterhitung == $semesterhitungx )
        {
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $bodykhs .= "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$nilai}  &nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$bobot} &nbsp; </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
            $idmakul = $d2[IDMAKUL];
            ++$i;
        }
    }
    if ( $semlama != "" && $semesterhitungx == $semlama )
    {
        $bodykhs .= "\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Jumlah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td class=tengah>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Semester</td>\r\n\t\t\t\t\t\t\t\t\t\t<td class=tengah>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t\t\t";
    }
    if ( $semlama != "" )
    {
        $arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        $bodykhs .= "\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>\r\n\t\t\t\t\t\t\t\t<td class=tengah>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    }
    $bodykhs .= "\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6  >Jumlah SKS yang Diambil</td>\r\n\t\t\t\t\t\t\t\t\t\t<td class=tengah>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n";
    if ( 0 < $semesterhitung && $semesterhitung <= $batasstudimhs )
    {
        if ( isoperator( ) && $tingkataksesusers[$kodemenu] == "T" )
        {
            include( "../makul/edittrakm.php" );
        }
        $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  NLIPSTRAKM='".number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2 )."', \r\n\t\t\t\t\t\t\t  NLIPKTRAKM='".number_format_sikad( $ipkmhs, 2 )."', \r\n                SKSTTTRAKM='{$sksmhs}',\r\n                SKSEMTRAKM='{$bobots[$semesterhitung]}'\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
        doquery($koneksi,$q );
    }
    $bodykhs .= "</table><br>";
    include( "footerlaporankhs.php" );
    if ( $diagram == 1 )
    {
        $q = "SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' ORDER BY THSMSTRAKM  ";
        $hg = doquery($koneksi,$q );
        if ( 0 < sqlnumrows( $h ) )
        {
            delgambartemp( );
            $xx1 = mt_rand( );
            $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
            doquery($koneksi,$q );
            $chart = new VerticalChart( );
            while ( $dg = sqlfetcharray( $hg ) )
            {
                $thnd = substr( $dg[THSMSTRAKM], 0, 4 );
                $semd = substr( $dg[THSMSTRAKM], 4, 1 );
                $semd = $arraysemester[$semd];
                $chart->addPoint( new Point( "{$semd} {$thnd}/".( $thnd + 1 )."", $dg[NLIPSTRAKM] ) );
            }
            $chart->setTitle( "Grafik IP Mahasiswa ({$idmahasiswa}) per Semester" );
            $chart->render( "gambardiagram/{$xx1}.png" );
            $bodykhs .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
        }
    }
}*/
?>
<?php
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

			#echo $q;
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
					<table celpadding=0 cellspacing=0 $border class=borderblack>
						<tr class=juduldata$cetak align=center>
	 
							<td rowspan=2 class=tengah><b>No</td>
							<td rowspan=2 class=tengah><b>Nama Mata Kuliah</td>
							<td rowspan=2 class=tengah><b>Kode</td>
							<td rowspan=2 class=tengah><b>Bobot/<br>Sks<br>(b)</td>
							<td colspan=2 class=tengah><b>Nilai</td>
							<td rowspan=2 class=tengah><b>(b)x(m) <br><br>(t)</td>
						</tr>
						<tr class=juduldata$cetak align=center>
							<td class=tengah><b>Nilai<br>Mutu<br>(n)</td>
							<td class=tengah><b>Angka<br>Mutu<br>(m)</td>
						</tr>						
						<tr class=juduldata$cetak align=center >
	 
							<td class=tengah><b>1</td>
							<td class=tengah><b>2</td>
							<td class=tengah><b>3</td>
							<td class=tengah><b>4</td>
							<td class=tengah><b>5</td>
							<td class=tengah><b>6</td>
							<td class=tengah><b>7</td>
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
		 
									<td align=center>$i&nbsp;</td>
									<td> $d2[NAMA]&nbsp;</td>
									<td align=center>$d2[IDMAKUL]&nbsp;</td>
									<td align=center>$d2[SKS] &nbsp;</td>
									<td align=center>$nilai  &nbsp;</td>
									<td align=center>$bobot &nbsp; </td>
									<td align=center>$total&nbsp;</td>
								</tr>
						";
						// <td> ".getnamamk("$d2[IDMAKUL]","".($tahun-1)."$semester",$d[IDPRODI])."</td>
              $idmakul=$d2[IDMAKUL];
              
						 include "../makul/editrnlm.php";
					   $q="UPDATE trnlm SET
							  NLAKHTRNLM='$nilai', 
                BOBOTTRNLM='$bobot'
                WHERE
                NIMHSTRNLM='$idmahasiswa'
                AND THSMSTRNLM='".($tahunlama-1)."$sem'
                AND KDKMKTRNLM='$d2[IDMAKUL]'
                ";
		#echo $q;
                doquery($q,$koneksi);           

						  
						$i++;
					}
				}
						if ($semlama!="") {
						//$bodykhs .=  $totals[$d2[SEMESTER]];
							if ($semesterhitungx==$semlama) {
								//$bodykhs .=  $semlama;
								$bodykhs .=  "
									<tr align=center >
										<td colspan=6 align=left>Jumlah</td>
										<td class=tengah>
										".number_format_sikad($totals[$semesterhitung],2,'.',',')."
										</td>
									</tr>
									<tr  align=center>
										<td colspan=6 align=left>Indeks Prestasi Semester</td>
										<td class=tengah>
										".number_format_sikad(@($totals[$semesterhitung]/$bobots[$semesterhitung]),2,'.',',')."
										</td>
									</tr>

								";
							}
						}
 						if ($semlama!="") {
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
$bodykhs .=  "
									<tr  align=center>
										<td colspan=6  >Jumlah SKS yang Diambil</td>
										<td class=tengah>
										".number_format_sikad(@($bobots[$semesterhitung]),2,'.',',')."
										</td>
									</tr>
";						
						
            if ($semesterhitung > 0 && $semesterhitung <=$batasstudimhs) {
              if (isoperator()  && $tingkataksesusers[$kodemenu]=="T"   ) {
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
                 doquery($q,$koneksi);          
                 }   
				$bodykhs .=  "</table><br>";
 
		include "footerlaporankhs.php";
		
		/// Gambar Grafik ///
				if ($diagram==1) {
	
		$q="SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='$idmahasiswa' ORDER BY THSMSTRAKM  ";
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
		
			}/* else {
 
			}*/
	}

?>