<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\r\nthead tr td{\r\n\tborder-top:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\t\r\ntfoot td {\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\r\n</style>\r\n";
unset( $totalbm );
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
$jmlkonversi = 0;
if ( $statuspindahan == "P" )
{
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,NAMAMAKUL AS NAMAMAKUL, makul.NAMA2,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    #echo $q;
	$hn2 = mysqli_query($koneksi,$q);
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    if (sqlnumrows($hn2)>0) {
	
		while ($dn2=sqlfetcharray($hn2))
        {
            #$arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
			$arraydatatranskrip2["$dn2[IDMAKUL]"]=$dn2;
            $jmlkonversi++;
        }
    }
}
$q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,tbkmk.NAMA2,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
#echo $q;
$hn = mysqli_query($koneksi,$q);
$jumlahmakuldiambil = sqlnumrows( $hn ) + $jmlkonversi;
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,pengambilanmksp.NAMA,\r\n    \t\t\ttbkmksp.NAKMKTBKMK  AS NAMAMAKUL,tbkmksp.NAMA2,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul,tbkmksp ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    #echo $q;
	$hn3 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysqli_error($koneksi);
    /*do
    {
        if ( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) )
        {
        }
        else if ( $nilaidiambil != 1 )
        {
            if ( $arraydatatranskrip2["{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
            {
                $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
            }
        }
        else
        {
            $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
            ++$jumlahmakuldiambil;
        }
    } while ( 1 );*/
	 while ($d3=sqlfetcharray($hn3)) {
    			if ($nilaidiambil!=1){ // Yang terbaik
						 //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
						if ($arraydatatranskrip2["$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
						   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
						   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
						}
				}else{
      			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
      			   $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
				}
             $jumlahmakuldiambil++;
           }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
#print_r()
$jumlahmakuldiambil = count( $arraydatatranskrip );
if ( $jumlahmakuldiambil % 2 == 1 )
{
    $jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
}
else
{
    $jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
}
if ( 0 < $jumlahmakuldiambil )
{
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table width=98% >\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50% valign=top>";
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table  class=borderline  width=100% border=0 cellpadding=0 cellspacing=0>\r\n\t\t\t\t\t <thead class=borderhead>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center valign=top> \r\n\t \r\n\t\t\t\t\t\t\t<td align=center><b>No</td>\r\n\t\t\t\t\t\t\t<!-- <td align=center><b>Kode</td>-->\r\n\t\t\t\t\t\t\t<td align=center><b>MATA KULIAH<br>\r\n              <i>Courses Title</i></td>\r\n\t\t\t\t\t\t\t<td align=center><b>KREDIT<br>\r\n              <i>Credit</i></td>\r\n \r\n\t\t\t\t\t\t\t<td align=center><b>NILAI<br>\r\n              <i>Grade</td>\r\n\t\t\t\t\t\t\t<td align=center><b>ANGKA<br>\r\n              <i>Score</td>\r\n \t\t\t\t\t\t\t<td align=center><b>KxA</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $aksi == "cetak" && $i == $jumlahmakuldiambilper2 + 1 )
            {
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table class=borderline  width=100% border=0 cellpadding=0 cellspacing=0 style='margin-left:10px;'>\r\n      \t\t\t\t\t <thead>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center valign=top>\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>No</td>\r\n      \t\t\t\t\t\t\t<!-- <td align=center><b>Kode</td>-->\r\n      \t\t\t\t\t\t\t<td align=center><b>MATA KULIAH<br>\r\n                    <i>Courses Title</i></td>\r\n      \t\t\t\t\t\t\t<td align=center><b>KREDIT<br>\r\n                    <i>Credit</i></td>\r\n       \r\n      \t\t\t\t\t\t\t<td align=center><b>NILAI<br>\r\n                    <i>Grade</td>\r\n      \t\t\t\t\t\t\t<td align=center><b>ANGKA<br>\r\n                    <i>Score</td>\r\n       \t\t\t\t\t\t\t<td align=center><b>KxA</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
            }
            unset( $kp );
            if ( $konversisemua == 0 )
            {
                unset( $kon );
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
            $nilaiakhir = $d2[NILAI];
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
                $totalbm += $d2[SKS] * $bobot;
            }
            else
            {
                $bobot = "";
            }
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top>\r\n\t\t\t\t\t\t\t\t<td class=whiteborder >{$i}</td>\r\n\t\t\t\t\t\t\t\t<!-- <td>{$d2['IDMAKUL']}</td> -->\r\n\t\t\t\t\t\t\t\t<td  class=whiteborder >{$d2['NAMA']} / <i> {$d2['NAMA2']}</i></td>\r\n\t\t\t\t\t\t\t\t<td class=whiteborder  align=center>{$d2['SKS']} </td>\r\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>{$nilai}</td>\r\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>".number_format_sikad( $bobot, 1 )."</td>\r\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>".number_format_sikad( $d2[SKS] * $bobot, 0 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t<!-- \t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=3 align=center><b>JUMLAH</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n \r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 0 )."</td>\r\n\t\t\t\t\t\t\t</tr> -->\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        $bodytranskrip .= "<TABLE>";
    }
    $catatan = "";
    $bodytranskrip .= "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<hr/ style='width:98%'>\r\n\t\t\t\t\t<table border=0 width=98%>\r\n\t\t\t\t\t\t<tr  align=left valign=top>\r\n\t\t\t\t\t\t\t<td width=50%>\r\n\t\t\t\t\t\t\t\t<table  width=88%>\r\n\t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        /*$ipkku = @$totalsemua / @$bobotsemua;
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
        }*/
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
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td width=25%>\r\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i></td><td><b>:  ".number_format_sikad($totalbm,0)." / $bobotsemua = $ipkkuteks ($tmp1 koma $tmp2)<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        /*if ( 0 )
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
            $ipkkuteks = number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2 );
        }
        else
        {
            $ipkku = @$totalsemua / @$bobotsemua;
            $ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
        }*/
		if (issudahlulus($d[ID])) { // Hitung IPKUAP
    								#$ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
    								#$ipkkuteks=number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2);
									$ipkku=@($totalsemua/$bobotsemua);
    								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua ),2);
                    
                    } else { // Hitung Biasa
    								$ipkku=@($totalsemua/$bobotsemua);
    								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua ),2);
                    }
        /*$tmp = explode( ".", $ipkkuteks );
        $tmp1 = angkatoteks( $tmp[0] );
        $blkkoma = $tmp[1];
        $tmp2 = "";
        $ia = 0;
        while ( $ia <= strlen( $blkkoma ) - 1 )
        {
            $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
            ++$ia;
        }*/
		#$ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
								$tmp=explode(".",$ipkkuteks);
								$tmp1=angkatoteks($tmp[0]);
								$blkkoma=$tmp[1];
								$tmp2="";
								for ($ia=0;$ia<=strlen($blkkoma)-1;$ia++) {
									 //$bodytranskrip.= $blkkoma[$ia];
									 $tmp2.=$angka[$blkkoma[$ia]+0]." ";
								}
        /*$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td width=25%>\r\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i></td><td><b>:  ".number_format_sikad( $totalbm, 0 )." / {$bobotsemua} = ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')."<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n                    <!-- \t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i> </td><td><b>:   ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t-->\r\n\t\t\t\t\t\t\t\t\t<tr><td width=35%>\r\n\t\t\t\t\t\t\t\t\t\t<b>Ujian AKhir Program (UAP)</td><td><b>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )."  ( {$d['LAMBANGUAP']} ) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<!--\r\n                  <tr><td width=75%>\r\n\t\t\t\t\t\t\t\t\t\t<b>Indeks Prestasi Kumulatif </td><td><b>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t-->\r\n\t\t\t\t\t\t\t\t\t\t";*/
		$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td width=25%>\r\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i></td><td><b>:  ".number_format_sikad( $totalbm, 0 )." / {$bobotsemua} = {$ipkkuteks}  ({$tmp1} koma {$tmp2})<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n                    <!-- \t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i> </td><td><b>:   ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t-->\r\n\t\t\t\t\t\t\t\t\t<tr><td width=35%>\r\n\t\t\t\t\t\t\t\t\t\t<b>Ujian AKhir Program (UAP)</td><td><b>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )."  ( {$d['LAMBANGUAP']} ) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<!--\r\n                  <tr><td width=75%>\r\n\t\t\t\t\t\t\t\t\t\t<b>Indeks Prestasi Kumulatif </td><td><b>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t-->\r\n\t\t\t\t\t\t\t\t\t\t";
    
	}
    $predikat = "";
	#echo $ipkku.'<br>';
	#print_r($konpredikat);
	#echo '<br>';
	#print_r($d);
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            #if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
			if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
            {
                $predikat = " {$v['NAMA']} / <i>{$v['NAMA2']}</i>";
                break;
            }
        }
    }
    
    if($d["TINGKAT"]=='B' || $d["TINGKAT"]=='A'){	
    	$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t<!-- \t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Tanggal Yudisium </td><td>:  <b>{$tglyudisium2} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr> -->\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Yudisium / <i>Yudicium</i> </td><td>:  <b>{$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left >\r\n\t\t\t\t\t\t\t\t\t\t<td  nowrap ><b>{$d['LABELSKRIPSI']} / <i>{$d['LABELSKRIPSI2']}</i> </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \r\n\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<br><br><br>\r\n\t\t\t\t\t\t\t\tSistem Penilaian / Grading System : A=4 A-=3.5 B+=3 B=2.5 C+=2 C=1.5 D=1 E=0\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td>\r\n \r\n ";
 	#$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t<!-- \t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Tanggal Yudisium </td><td>:  <b>{$tglyudisium2} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr> -->\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Yudisium / <i>Yudicium</i> </td><td>:  <b>{$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left >\r\n\t\t\t\t\t\t\t\t\t\t<td  nowrap ><b>{$d['LABELSKRIPSI']} / <i>{$d['LABELSKRIPSI2']}</i> </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \r\n\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<br><br><br>\r\n\t\t\t\t\t\t\t\tSistem Penilaian / Grading System : A=4 B=3 C=2 D=1 E=0\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td>\r\n \r\n ";
 
    }else{
 	$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t<!-- \t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Tanggal Yudisium </td><td>:  <b>{$tglyudisium2} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr> -->\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<b>Yudisium / <i>Yudicium</i> </td><td>:  <b>{$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left >\r\n\t\t\t\t\t\t\t\t\t\t<td  nowrap ><b>{$d['LABELSKRIPSI']} / <i>{$d['LABELSKRIPSI2']}</i> </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \r\n\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<br><br><br>\r\n\t\t\t\t\t\t\t\tSistem Penilaian / Grading System : A=4 B=3 C=2 D=1 E=0\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td>\r\n \r\n ";
   
    }
    $footertranskrip = "";
    @include( "footertranskripuniversitasbataminggris.php" );
    $footertranskrip2 = $footertranskrip;
    $footertranskrip = "";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $bodytranskrip .= "\r\n \t\t\t\t\t\r\n \t\t\t\t\t{$footertranskrip2}\r\n \t\t\t\t</td>\r\n \t\t\t\t</tr></table>\r\n \t\t\t\t\t";
}
if ( $diagram == 1 )
{
    #include( "../libchart/libchart.php" );
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
}
?>