<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

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
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tUNION\r\n\t\t\t\tSELECT DISTINCT nilaikonversi.IDMAKUL, \r\n        makul.NAMA, makul.JENIS, makul.SEMESTER\r\n\t\t\t\tFROM nilaikonversi,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tnilaikonversi.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n \t\t\t\tORDER BY SEMESTER,IDMAKUL \r\n\t\t\t\tLIMIT 0,1\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$bodytranskrip .= mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hn ) )
{
    #$bodytranskrip .= "  \r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table  {$border} width=600 border=0  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n \t\t\t\t";
    $bodytranskrip .= "  \r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table  width='900' border='1' style='border-collapse:collapse;'>\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n \t\t\t\t\t\t<tr align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td width='5%'>Kode</td>\r\n\t\t\t\t\t\t\t<td width='15%'>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td width='7%'>SKS</td>\r\n\t\t\t\t\t\t\t<td width='7%'>Mutu</td>\r\n\t\t\t\t\t\t\t<td width='7%'>Lambang</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n \t\t\t\t";
    
	$jenislama = 0 - 1;
    foreach ( $arrayjenismakul as $kk => $vv )
    {
        unset( $arraydatatranskrip );
        unset( $arraydatatranskrip2 );
        $stylepage = "";
        $bodytranskrip .= "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center {$stylepage}>\r\n\t \r\n\t\t\t\t\t\t\t<td colspan=7  align=left> {$vv}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        if ( $statuspindahan == "P" )
        {
            $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t  AND makul.JENIS='{$kk}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
            $hn2 = mysqli_query($koneksi,$q);
            if (sqlnumrows($hn2)>0) {
      			while ($dn2=sqlfetcharray($hn2)) {
      			   //$arraydatatranskrip["$dn2[SEMESTER]-$dn2[IDMAKUL]"]=$dn2;
      			   $arraydatatranskrip2["$dn2[IDMAKUL]"]=$dn2;
				}
			}
        }
        $q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND \r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tAND makul.JENIS='{$kk}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
		
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
        @usort( @$arraydatatranskrip2, "SortBySemester" );
        unset( $arraydatatranskrip );
        $arraydatatranskrip = $arraydatatranskrip2;
        $i = 1;
        $s = 1;
        $semlama = "";
        unset( $totals );
        if ( is_array( $arraydatatranskrip ) )
        {
			
			$ab=array();
			$ab[0]=1;
			
			foreach ( $arraydatatranskrip as $k => $d2 )
			{
				
				unset( $kp );
                if ( $konversisemua == 0 )
                {
                    unset( $kon );
                }
				
				//sfafsf
				$ab[$s]=$d2['SEMESTER'];
				if($ab[$s]!=$ab[$s-1]){
					$bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>IP Semester ".($ab[$s-1])." : ".number_format_sikad(@($totalsemuasp/$bobotsemuasp),2,'.',',')."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
					$bobotsemuasp =0;
					$totalsemuasp = 0;
				}
				
                if ( $d2[SEMESTER] != $semlama )
                {
					//var_dump($i);
                    $kelas = kelas( $i );
					
                    $i++;
					//echo "KKK".$i.'<br>';
					//$textsemester=$d2['SEMESTER']-1;
					// if($i>2){
						// $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=center>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>IP Semester ".$textsemester." : ".number_format_sikad(@($totalsemuasp/$bobotsemuasp),2,'.',',')."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
						// $bobotsemuasp =0;
						// $totalsemuasp = 0;
					// }
					$bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>Semester {$d2['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
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
					//persemester
					$bobotps += $d2[SKS];
					$bobotsemuasp += $d2[SKS];
                    $totalsemuasp += $bobot * $d2[SKS];
					//
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
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                
				++$i;
				if($s==count($arraydatatranskrip)){
					
					$bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>IP Semester ".$ab[$s-1]." : ".number_format_sikad(@($totalsemuasp/$bobotsemuasp),2,'.',',')."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
					$bobotsemuasp =0;
					$totalsemuasp = 0;
				}
				$s++;
				
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
    #$bodytranskrip .= "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=630>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=900>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    #echo $d[JENIS]."MM";
	if ( $d[JENIS] == 0 || $UNIVERSITAS == "STIKES SAMARINDA" )
    {
        $ipkku=@($totalsemua/$bobotsemua);
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        if ( issudahlulus( $d[ID] ) )
        {
            $ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
        }
        else
        {
            $ipkku=@($totalsemua/$bobotsemua);
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>: ".number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
	getpenandatangan();
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50%  ><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table><table><tr><td nowrap>*Penjelasan:<br>Nilai IPK: Jumlah Semua Nilai Mata Kuliah / Jumlah Semua SKS</td></tr><tr><td>Catatan :<br>	Kredit yg harus ditempuh ....... sks<br>	Kredit yg sudah ditempuh ....... sks<br>	Kredit yg belum ditempuh ....... sks<br><br>	Keperluan transkrip untuk ....... </td></tr></table></td><td width=10%></td><td align=center nowrap width=50%>".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}<br><br><br><br><br><br><u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</tr></table>\r\n ";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t";
    //sab
	/*$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50%  ><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>";
    @include( "footertranskrip.php" );
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";*/
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $bodytranskrip .= "</table>\r\n\t\t\t\t";
}
if ( is_array( $totals ) )
{
    $xx = mt_rand( );
    $datatabel[panjang] = 400;
    $datatabel[lebar] = 250;
    $datatabel[jarakbingkai] = 30;
    $datatabel[minx] = 0;
    $datatabel[miny] = 0;
    $datatabel[maxx] = count( $totals ) + 1;
    $datatabel[maxy] = 4;
    $pembagi = 4;
    $datatabel[jmltitiky] = $pembagi;
    $datatabel[jmltitikx] = 20;
    $datatabel[jarakbatang] = 10;
    $i = 1;
   for ($i=1;$i<=count($totals);$i++) {
							 $data[$i]=@($totals[$i]/$bobots[$i]);
							$datanx[$i]=$i;
						}
    $juduldiagram[1][nama] = "Grafik Perkembangan IP";
    $juduldiagram[2][nama] = getnamafromtabel( $d[ID], "mahasiswa" )." ( {$d['ID']} ) ";
    $juduldiagram[x][nama] = "Semester";
    $juduldiagram[y][nama] = "Indeks Prestasi";
    $juduldiagram[x][font] = 2;
    $juduldiagram[y][font] = 2;
    $juduldiagram[1][font] = 4;
    $juduldiagram[2][font] = 3;
    $juduldiagram[ny][font] = 1;
    $juduldiagram[nx][font] = 1;
    $xx = creatediagrambatang( $datatabel, $data, $datanx, $juduldiagram, $folder, $xx );
    $q = "INSERT INTO gambartemp VALUES('{$folder}"."{$xx}',NOW())";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $bodytranskrip .= "<br style='page-break-after:always'>";
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<image src='{$folder}"."{$xx}' >\r\n\t\t\t\t\t\t\t\t</td></tr></table>\r\n\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t";
    }
}
?>
