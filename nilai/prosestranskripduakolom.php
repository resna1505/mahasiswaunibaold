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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    #do
    #{
	while ($dn2 = sqlfetcharray( $hn2 ))
	{
        if (0 < sqlnumrows( $hn2 ))
        {
			
				$arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
				++$jmlkonversi;
			
		}
	}
    #} while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul,tbkmksp ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    #echo $q;
	$hn3 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysqli_error($koneksi);
    #do
	/*while($d3 = sqlfetcharray( $hn3 ))
    {
        if (0 < sqlnumrows( $hn3 ))
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
    }*/
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
             $jumlahmakuldiambil++;
           }
          }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
$jumlahmakuldiambilper2 = 30;
if ( 0 < $jumlahmakuldiambil )
{
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table >\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50% valign=top>";
    }
    #$bodytranskrip .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table  {$borderx}   border=0  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Nilai</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $bodytranskrip .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table  {$borderx}   border=0  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center><td width='1%'>No</td><td align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t<td align=center><b>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $aksi == "cetak" && $i == $jumlahmakuldiambilper2 + 1 )
            {
                #$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table  {$borderx}  border=0  >\r\n      \t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Nilai</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
				$bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table  {$borderx}  border=0  >\r\n      \t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center><td width='1%'>No</td><td align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
           
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
			#echo $nilaikosong;
            if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
            {
				#echo "kkk";
                $bobots[$d2[SEMESTER]]+=$d2[SKS];
	 				    $totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
						  $bobotsemua+=$d2[SKS];
						  $totalsemua+=$bobot*$d2[SKS];
  						$bobots2[$d2[SEMESTER]][$d2[JENIS]]+=$d2[SKS];
   						$totals2[$d2[SEMESTER]][$d2[JENIS]]+=$bobot*$d2[SKS];
 						   $totalbm+=($d2[SKS]*$bobot);
            }
            else
            {
                $bobot = "";
            }
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $stylenoborder = "style='border-top:none;border-bottom:none;' ";
            #$bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top {$stylenoborder}><td {$stylenoborder}>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} nowrap>{$i} {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>".number_format_sikad( $nilaiakhir, 2 )."</td>\r\n \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td  {$stylenoborder} align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>".number_format_sikad( $d2[SKS] * $bobot, 2 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top {$stylenoborder}><td {$stylenoborder}>{$i}</td><td {$stylenoborder}>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} nowrap>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>{$d2['SKS']} </td><td {$stylenoborder} align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td  {$stylenoborder} align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>".number_format_sikad( $d2[SKS] * $bobot, 2 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
    }
    $sisa = 60 - $i;
    if ( 30 <= $sisa )
    {
        $i = $i;
        while ( $i <= 30 )
        {
            $bodytranskrip .= "\r\n    \t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left {$stylenoborder}>\r\n    \t\t\t\t\t\t\t\t<td {$stylenoborder}  align=center>&nbsp; </td>\r\n    \t\t\t\t\t\t\t\t<td {$stylenoborder}  align=center>&nbsp; </td>\r\n    \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>  </td>\r\n    \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n     \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n    \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n     \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n    \t\t\t\t\t\t\t</tr>\r\n              \r\n              ";
            ++$i;
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table  {$borderx}  border=0  >\r\n      \t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center  >\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Kode</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Nilai</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td   align=center><b>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
        $sisa = 60 - $i;
    }
    $ss = 1;
    while ( $ss <= $sisa )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left {$stylenoborder}>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder}  align=center>&nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder}  align=center>&nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center>  </td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n\t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n \t\t\t\t\t\t\t\t<td {$stylenoborder} align=center> </td>\r\n\t\t\t\t\t\t\t</tr>\r\n          \r\n          ";
        ++$ss;
    }
	$jmlakhir=$i-1;
    #$bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=center><b>JUMLAH {$i}</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center> </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 2 )."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left><td></td><td colspan=2 align=center><b>JUMLAH {$jmlakhir}</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t<td align=center> </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 2 )."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        $bodytranskrip .= "<TABLE>";
    }
    $catatan = "";
    $bodytranskrip .= "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<table>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table  width=600>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>Judul Tugas Akhir  </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 || $UNIVERSITAS == "STIKES SAMARINDA" )
    {
        #$ipkku = @$totalsemua / @$bobotsemua;
		$ipkku=@($totalsemua/$bobotsemua);
        #$ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
		$ipkkuteks = number_format_sikad( @($totalsemua / $bobotsemua), 2 );
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
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  {$ipkkuteks} ({$tmp1} koma {$tmp2})<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        if ( issudahlulus( $d[ID] ) )
        {
            #$ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
			$ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
			$ipkkuteks = number_format_sikad( @(($totalsemua/@$bobotsemua) + @$d[IPKUAP] ) / 2, 2 );
            #$ipkkuteks = number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2 );
        }
        else
        {
            #$ipkku = @$totalsemua / @$bobotsemua;
            #$ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
			$ipkku = @($totalsemua/$bobotsemua);
            $ipkkuteks = number_format_sikad( @($totalsemua/$bobotsemua), 2 );
        }
        #$ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
		$ipkku = @(($totalsemua /$bobotsemua) + @$d[IPKUAP] ) / 2;
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
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad( @($totalsemua / $bobotsemua), 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tYudisium </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap> ";
    if ( $konversisemua == 1 )
    {
        $q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        $ha = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $ha ) )
        {
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>Keterangan Mutu Nilai</td></tr>";
            $syaratlama = 100;
            while ( $da = sqlfetcharray( $ha ) )
            {
                $bodytranskrip .= "\r\n  \t\t\t\t\t\t\t<tr><td  >{$da['SIMBOL']} = {$da['SYARAT']} - {$syaratlama} </td></tr>\r\n  \t\t\t\t\t";
                $syaratlama = $da[SYARAT] - 0.01;
            }
            $bodytranskrip .= " </table>\r\n\t\t\t\t<br><br>";
        }
    }
    $q = "\r\n\t\t\t\tSELECT ID,NAMA,SYARAT,SYARATW FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW ASC\r\n\t\t\t";
    $ha = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $ha ) )
    {
        $bodytranskrip .= "\r\n\r\n\t\t\t\t\t\t<table border='0'>\r\n\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t<td nowrap><b>Predikat Kelulusan</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\r\n\t\t\t\t\t\t ";
        $syaratlama = 4;
        while ( $da = sqlfetcharray( $ha ) )
        {
            $bodytranskrip .= "\r\n\t\t\t\t\t\t<tr >\r\n \r\n\t\t\t\t\t\t\t<td  nowrap>  \r\n \t\t\t\t\t\t \r\n \t\t\t\t\t\t\tIPK      {$da['SYARAT']} - {$syaratlama}\r\n \t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t\t<td nowrap>: {$da['NAMA']}</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $syaratlama = $da[SYARAT] - 0.01;
        }
        $bodytranskrip .= "</table>\r\n\t\t\t\t<br><br>";
    }
	getpenandatangan();
    $bodytranskrip .= "<table><tr><td nowrap>*Penjelasan:<br>Nilai IPK: Jumlah Semua Nilai Mata Kuliah / Jumlah Semua SKS</td></tr><tr><td>Catatan :<br>	Kredit yg harus ditempuh ....... sks<br>	Kredit yg sudah ditempuh ....... sks<br>	Kredit yg belum ditempuh ....... sks<br><br>	Keperluan transkrip untuk ....... </td></tr></table></td><td width=10%></td><td align=center nowrap width=50%>".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}<br><br><br><br><br><br><u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIP. {$nipdirektur}\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</tr></table>\r\n ";
    @include( "footertranskrip.php" );
    $bodytranskrip .= "\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $bodytranskrip .= "\r\n \t\t\t\t</td>\r\n \t\t\t\t</tr></table>\r\n \t\t\t\t\t";
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
}
?>
