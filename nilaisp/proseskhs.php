<?php
$stylekhs .="<style type=\"text/css\">\r\n\ttr.datagenapcetak td, tr.dataganjilcetak td, tr.juduldatacetak td {\r\n\t\tfont-size:16px;\r\n\t\tpadding:3px;\r\n\t\t}\r\n\t\t\r\n\ttr.juduldatacetak, td {\r\n\t\tfont-weight:normal;\r\n\t\t}\r\n</style>\r\n";
periksaroot( );
unset( $arraydatanilai );
unset( $arrayipkmhs );
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n        pengambilanmksp.NAMA,\r\n        pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER, \r\n \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\r\n\t\t\t\tWHERE \r\n\r\n\t\t\t\t pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    if ( $semester != 3 )
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
    }
    else
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
    }
    #echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table celpadding=0 cellspacing=0 style='width:660px; border-collapse:collapse;font-size:16px;' class=borderblack>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2>No</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Kode</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>Bobot/<br>Sks<br>(b)</td>\r\n\t\t\t\t\t\t\t<td colspan=2>Nilai</td>\r\n\t\t\t\t\t\t\t<td rowspan=2>(b)x(m) <br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t\t<td>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td >1</td>\r\n\t\t\t\t\t\t\t<td >2</td>\r\n\t\t\t\t\t\t\t<td >3</td>\r\n\t\t\t\t\t\t\t<td >4</td>\r\n\t\t\t\t\t\t\t<td >5</td>\r\n\t\t\t\t\t\t\t<td >6</td>\r\n\t\t\t\t\t\t\t<td >7</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $bodykhs .="<br>
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
						</tr>";
    
	$i = 1;
    $semlama = $semlast = 0;
    while ( $d2 = sqlfetcharray( $hn ) )
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
        if ( $nilaikosong == 1 || $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" && $nilaikosong == 0 )
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
            #echo "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$nilai}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$bobot}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total}</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
            $bodykhs .= "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$nilai}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$bobot}  </td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total}</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
            
			$idmakul = $d2[IDMAKUL];
            ++$i;
        }
    }
    if ( $semlama != "" && $semesterhitungx == $semlama )
    {
        #echo "\r\n\t\t\t\t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Jumlah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Semester</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t".@number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t";
		$bodykhs .=  "\r\n\t\t\t\t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Jumlah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Semester</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t\t\t".@number_format_sikad( @$totals[$semesterhitung] / @$bobots[$semesterhitung], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t";
    
	}
    if ( $semlama != "" )
    {
        $arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        $bodykhs .= "<tr class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    }
    $bodykhs .="<tr  align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=6 align=left>Jumlah SKS yang Diambil</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$bobots[$semesterhitungx], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n";
    $bodykhs .="</table><br>";
}
include( "footerlaporankhs.php" );
?>
