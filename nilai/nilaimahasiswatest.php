<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum ORDER BY NILAI DESC";
$hb = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
if(sqlnumrows( $hb )>0){
	while ( $db = sqlfetcharray( $hb ))
	{
		$arraybobotnilai["{$db['SIMBOL']}"] = "{$db['NILAI']}";
	}
}
if ( is_array( $arraybobotnilai ) )
{
    echo "\r\n          <script>\r\n            function setbobot(nilai,bobot) { ";
    foreach ( $arraybobotnilai as $k => $v )
    {
        echo "\r\n                if (nilai.value=='{$k}') {\r\n                  bobot.value='{$v}';\r\n                } else\r\n                ";
    }
    echo "\r\n               {\r\n               }\r\n            }\r\n          </script>\r\n          \r\n          ";
}
if ( $aksi2 == "Simpan" && $tingkataksesusers[$kodemenu] == "T" )
{
    print_r($datamakul);
    echo "<br>";		
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Nilai Mahasiswa", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $datamakul ) )
    {
        foreach ( $datamakul as $k => $v )
        {
	    	
            $str = "nilai_{$k}";
            $nilai[$k] = $$str;
            $str = "bobot_{$k}";
            $bobot[$k] = $$str;
	    $str = "nilaiakhirmhs_{$k}";
            $nilaiakhirmhs[$k] = $$str;	
            $vld[] = cekvaliditasnilaihuruf( "Nilai {$k} : {$nilai[$k]}", $nilai[$k] );
            $vld[] = cekvaliditasnilaibobot( "Bobot {$k} : {$bobot[$k]}", $bobot[$k] );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
		print_r($nilai);
		echo "<br>";
            foreach ( $nilai as $k => $v )
            {
                $q = "UPDATE pengambilanmk SET SIMBOL='{$v}',BOBOT='".$bobot[$k]."',NILAI='".$nilaiakhirmhs[$k]."' WHERE IDMAHASISWA='{$id}' AND TAHUN='".( $tahunupdate + 1 )."' AND\r\n\t\t\t      SEMESTER='{$semesterupdate}' AND\r\n\t\t\t      IDMAKUL='{$k}'\r\n\t\t\t      ";
                echo $q."<br>";
		#mysqli_query($koneksi,$q);
                $q = "UPDATE trnlm SET \r\n\t\t\t      NLAKHTRNLM ='{$v}',\r\n\t\t\t      BOBOTTRNLM ='".$bobot[$k]."'\r\n\t\t\t      WHERE NIMHSTRNLM ='{$id}' AND\r\n\t\t\t       THSMSTRNLM ='{$tahunupdate}{$semesterupdate}' AND\r\n\t\t\t      KDKMKTRNLM ='{$k}'\r\n\t\t\t      ";
                echo $q."<br>";
		#mysqli_query($koneksi,$q);
                $ketlog = "Edit Nilai Mahasiswa {$id}, MK={$k}, TAHUN={$tahunupdate}/".( $tahunupdate + 1 ).", SEM={$semesterupdate}, SIMBOL={$v}, BOBOT=".$bobot[$k]."";
                #buatlog( 58 );
            }
            $errmesg = "Data nilai telah disimpan.";
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );

#echo "TAHUN=".$tahunnilai;
if($tahunnilai==''){
	$tahunnilai=$tahunupdate;
}else{
	$tahunnilai=$tahunnilai;
}

if($semesternilai==''){
	$semesternilai=$semesterupdate;
}else{
	$semesternilai=$semesternilai;
}		
$tahunpengambilanmk=$tahunnilai+1;
$semesterpengambilanmk=$semesternilai;

//cek approval input nilai berdasarkan nama mahasiswa dan tahun akademik
#$tahunapprovalnilai=$tahunnilai+1;
#$semesterapprovalnilai=$semesternilai;		
$approvalnilai=getapprovalnilai($tahunpengambilanmk,$semesterpengambilanmk,$idmahasiswa);
if($approvalnilai['approval']==0){
	if ( $aksi != "cetak" )
    	{
		printmesg("Proses Input Nilai Belum disetujui, silahkan melakukan persetujuan input nilai kepada user yang bersangkutan");
		exit();	
	}
}	
$q = "SELECT pengambilanmk.BOBOT,pengambilanmk.SIMBOL,pengambilanmk.NILAI,pengambilanmk.IDMAKUL,pengambilanmk.TAHUN,tbkmk.NAKMKTBKMK AS NAMAMAKUL,pengambilanmk.NAMA,".
"pengambilanmk.SKSMAKUL AS SKS,pengambilanmk.SEMESTER AS SEMESTERS,pengambilanmk.SEMESTERMAKUL AS SEMESTER ".
"FROM pengambilanmk,tbkmk,msmhs WHERE pengambilanmk.IDMAHASISWA='{$idmahasiswa}' AND pengambilanmk.TAHUN='{$tahunpengambilanmk}' ".
"AND pengambilanmk.SEMESTER='{$semesterpengambilanmk}' AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK ".
"AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK ".
"AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA ORDER BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER, pengambilanmk.IDMAKUL ";
#echo $q.'<br>';
$hn = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hn ) )
{
    if ( $semester != 3 )
    {
        #$semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
		$semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+$semester;
    }
    else
    {
        #$semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
		$semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+0.5;
    }
    echo "\r\n\t\t\t\t\t<br>\r\n  \t\t\t\t\r\n \r\n\t\t\t\t";
    $i = 1;
    $tahunii = 0;
    $semlama = $semlast = $semesterhitungx = 0;
    while ( $d2 = sqlfetcharray( $hn ) )
    {
        unset( $kp );
        /*if ( $d2[SEMESTERS] != 3 )
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d2[SEMESTERS];
        }
        else
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + 0.5;
        }*/
		if ($d2[SEMESTERS]!=3) {
			 $semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+$d2[SEMESTERS];
		} else {
			$semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+0.5;
		}
			$kelas=kelas($i);
			
			$semlama=$semesterhitungx;
		
        #$kelas = kelas( $i );
        #$semlama = $semesterhitungx;
        $kelas = kelas( $i );
	$nilaiakhirmhs = "";
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        $nilaiakhir = $nilaiakhirdicari;
        $totalmax = $totalmaxdicari;
        $bobotmax = $bobotmaxdicari;
        $simbolmax = $simbolmaxdicari;
        if ( $semesterhitungx != $semlast )
        {
            $i = 1;
            /*if ( 0 < $semlast )
            {
                echo "\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t<td></td>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=4 align=left>JUMLAH NILAI  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td>".number_format_sikad($totals[$semlast]+0,2)."</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>JUMLAH SKS  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $bobots[$semlast] + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>IP SEMESTER</td>\r\n\t\t\t\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad(@($totals[$semlast]/$bobots[$semlast])+0,2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t </table>\r\n                 </form>\r\n                  ";
            }*/
			if ($semlast>0) {

								echo "
									<tr align=center >
									<td></td>
										<td colspan=5 align=left>JUMLAH NILAI </td>
										<td  >
										".number_format_sikad($totals[$semlast]+0,2)."
										</td>
									</tr>
									<tr align=center >
										<td></td>
                    <td  colspan=5 align=left>JUMLAH SKS  </td>
										<td  >
										".number_format_sikad($bobots[$semlast]+0,2)."
										</td>
									</tr>
									<tr  align=center>
										<td></td>
                    <td  colspan=5 align=left>IP SEMESTER</td>
										<td >
										".number_format_sikad(@($totals[$semlast]/$bobots[$semlast])+0,2 )."
										</td>
									</tr>
								 
                  ";
				  echo "						</tbody>
							</table>
						</div>
					</div>
				</div>
			</form>";
			}
            $semesterupdate = $semesterhitungx % 2;
            if ( $semesterupdate == 0 )
            {
                $semesterupdate = 2;
            }
            else if ( 2 < $semesterhitungx )
            {
                $tahunii = floor( $semesterhitungx / 2 );
            }
            $tahunupdate = $d2[TAHUN] - 1;
            echo " 	<form action='index.php' method=post>\r\n          <input type=hidden name=pilihan value='{$pilihan}'> \r\n          <input type=hidden name=aksi value='{$aksi}'> \r\n\t\t  <input type=hidden name=sessid value='{$token}'> \r\n          <input type=hidden name=id value='{$id}'> \r\n          <input type=hidden name=tahunupdate value='{$tahunupdate}'> \r\n          <input type=hidden name=semesterupdate value='{$semesterupdate}'>"; 
			echo "	<div class=\"m-portlet\">			
						<div class=\"m-section__content\">
							<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">
									<thead>
										<tr class=juduldata{$cetak} align=center>
											<td  colspan=6><b>Semester ".( $semesterhitungx + $plus1 )."</b>,  {$tahunupdate}/".( $tahunupdate + 1 )." ".$arraysemester[$semesterupdate]."</td><td>";
			if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "<input type=submit name=aksi2 class=\"btn btn-brand\" value='Simpan'>";
            }
            echo "						</td></tr><tr class=juduldata{$cetak} align=center><td>No</td><td >Kode</td><td width=300>Nama Mata Kuliah</td><td >SKS</td><td>Nilai Akhir</td><td>Simbol</td><td>Bobot</td></tr>";
            $semlast = $semesterhitungx;
        }
	$nilaiakhirmhs = $d2[NILAI];
        $nilai = $d2[SIMBOL];
        $bobot = $d2[BOBOT];
        if ( $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" )
        {
            /*$totalnilaiakhir += $nilaiakhir;
            $nilai = $d2[SIMBOL];
            $bobot = $d2[BOBOT];
            #$total = number_format_sikad( $d2[SKS] * $d2[BOBOT] + 0, 2, ".", "," );
			$total=number_format_sikad(($d2[SKS]*$d2[BOBOT])+0,2,'.',',');
            $totals += $semesterhitungx;
            $totalsemua += $totalmax;
            $bobots += $semesterhitungx;
            $bobotsemua += $d2[SKS];*/
			$totalnilaiakhir+=$nilaiakhir;
								 $nilaiakhirmhs=$d2[NILAI];
								$nilai=$d2[SIMBOL];
								$bobot=$d2[BOBOT];
								$total=number_format_sikad(($d2[SKS]*$d2[BOBOT])+0,2,'.',',');
							 	$totals[$semesterhitungx]+=$total;
							 	$totalsemua+=$totalmax;
      					$bobots[$semesterhitungx]+=$d2[SKS];
      					$bobotsemua+=$d2[SKS];
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
		echo "		</thead>
					<tbody>";
        echo "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}  </td>\r\n\t\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}  </td>\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n                  ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "<td align=center><input type=hidden name='datamakul[{$d2['IDMAKUL']}]' value='1'><input type=text name='nilaiakhirmhs_{$d2['IDMAKUL']}' value='{$nilaiakhirmhs}' size=2></td><td align=center><input type=text name='nilai_{$d2['IDMAKUL']}' value='{$nilai}' size=2 onBlur=\"setbobot(nilai_{$d2['IDMAKUL']},bobot_{$d2['IDMAKUL']});\"></td><td align=center> <input type=text name='bobot_{$d2['IDMAKUL']}' value='{$bobot}' size=2></td>";
        }
        else
        {
            echo "<td align=center>{$nilai}</td><td align=center>  {$bobot} </td>";
        }
        echo "</tr>";
        $idmakul = $d2[IDMAKUL];
        ++$i;
    }
    if ( $semlama != "" && $semesterhitungx == $semlama )
    {
		#echo "<tr><td></td><td  colspan=4 align=left>JUMLAH NILAI BAWAH </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semlast] + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td colspan=4  align=left>JUMLAH SKS  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $bobots[$semlast] + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>IP SEMESTER</td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad(@($totals[$semlast]/$bobots[$semlast])+0,2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>";
		echo "
									<tr align=center >
									<td></td>
										<td colspan=5 align=left>JUMLAH NILAI </td>
										<td  >
										".number_format_sikad($totals[$semlast]+0,2)."
										</td>
									</tr>
									<tr align=center >
										<td></td>
                    <td  colspan=5 align=left>JUMLAH SKS  </td>
										<td  >
										".number_format_sikad($bobots[$semlast]+0,2)."
										</td>
									</tr>
									<tr  align=center>
										<td></td>
                    <td  colspan=5 align=left>IP SEMESTER</td>
										<td >
										".number_format_sikad(@($totals[$semlast]/$bobots[$semlast])+0,2 )."
										</td>
									</tr>
								 
                  ";
	}
	
    if ( $semlama != "" )
    {
        $arrayipkmhs = getipk( $d[ID], $tahunupdate + 1, $semesterupdate, $nilaidiambil, $nilaikosong );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        #echo "  \r\n\t\t\t\t\t\t<table width=100% border=1 style='border-collapse:collapse;'>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL NILAI</td>\r\n\t\t\t\t\t\t\t\t<td align=center> \r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs * $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL SKS TELAH DITEMPUH</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>IP KUMULATIF\r\n                <br>\r\n\t\t\t\t\t\t\t\tNilai IPK ini tidak mencerminkan nilai IPK sebenarnya. Gunakan fasilitas Transkrip atau Proses IPS/IPK untuk melihat nilai IPK yang sebenarnya.\r\n\t\t\t\t\t\t\t\r\n                </td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t";
	    #echo "  <tr><td  align=left>TOTAL NILAI</td>\r\n\t\t\t\t\t\t\t\t<td align=center> \r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs * $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL SKS TELAH DITEMPUH</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>IP KUMULATIF\r\n                <br>\r\n\t\t\t\t\t\t\t\tNilai IPK ini tidak mencerminkan nilai IPK sebenarnya. Gunakan fasilitas Transkrip atau Proses IPS/IPK untuk melihat nilai IPK yang sebenarnya.\r\n\t\t\t\t\t\t\t\r\n                </td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>";
		echo "		<div class=\"m-portlet\">			
						<div class=\"m-section__content\">
							<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">
									<thead>
										<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL NILAI</td>\r\n\t\t\t\t\t\t\t\t<td align=center> \r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs * $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL SKS TELAH DITEMPUH</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>IP KUMULATIF\r\n                <br>\r\n\t\t\t\t\t\t\t\tNilai IPK ini tidak mencerminkan nilai IPK sebenarnya. Gunakan fasilitas Transkrip atau Proses IPS/IPK untuk melihat nilai IPK yang sebenarnya.\r\n\t\t\t\t\t\t\t\r\n                </td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs + 0, 2 )."\r\n\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>";
	}
	
}
?>
