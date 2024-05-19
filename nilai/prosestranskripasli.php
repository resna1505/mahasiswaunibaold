<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletranskrip .= "<style type=\"text/css\">\r\n\r\n.lineborderblack {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n.lineborderblack td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n\r\n</style>\r\n<style type=\"text/css\">\r\n\r\n.makeborder {\r\n\twidth:100%;\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n.makeborder td {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\tfont-size:10px;\r\n\t}\r\n\t\r\ntd {\r\n\tfont-size:10px;\r\n\t}\r\n\t\r\n</style>";
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $id, "pengambilanmk" );
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
if ( $statuspindahan == "P" )
{
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysqli_error($koneksi);
    /*do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );*/
	if (sqlnumrows($hn2)>0) {
      			 while ($dn2=sqlfetcharray($hn2)) {
      			   //$arraydatatranskrip["$dn2[SEMESTER]-$dn2[IDMAKUL]"]=$dn2;
      			   //$bodytranskrip.= $dn2[NILAI];
      			   $arraydatatranskrip2["$dn2[IDMAKUL]"]=$dn2;
             }
          }
}
$q = "\r\n\t\t\t\tSELECT  \r\n        pengambilanmk.IDMAKUL, \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.NILAI,\r\n        pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\r\n        pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\r\n        makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$IDPRODI}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\r\n \t\t\t\t\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
#echo $q;
$hn = mysqli_query($koneksi,$q);
$bodytranskrip .= mysqli_error($koneksi);
/*while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
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
}*/
if (sqlnumrows($hn)>0) {
			#echo "lll";
			 //$bodytranskrip.= "Wooi";
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
      } 
if ( $sp == 1 )
{
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\ttbkmksp.NAKMKTBKMK    AS  NAMA,\r\n            makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
    /*if ( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) )
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
        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d3;
    }*/
	if (sqlnumrows($hn3)>0) {
    			
    			 while ($d3=sqlfetcharray($hn3)) {
    			   //$bodytranskrip.= $d3[BOBOT]."  $nilaidiambil ";
    			   if ($nilaidiambil!=1) { // Yang terbaik
    			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
    			     if ($arraydatatranskrip2["$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
        			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
          			 $arraydatatranskrip2["$d3[IDMAKUL]"]=$d3;
               }
             } else {
      			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
        			 $arraydatatranskrip2["$d2[IDMAKUL]"]=$d3;
             }
           }
          }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$i = $ii = 1;
$semlama = "";
unset( $totals );
#print_r($arraydatatranskrip);
if ( is_array( $arraydatatranskrip ) )
{
    #$bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table cellpading=0 cellspacing=0 width=600 class=lineborderblack  >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $bodytranskrip.= "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">";
	
	foreach ( $arraydatatranskrip as $k => $d2 )
    {
        $tahunlama = $d2[TAHUN];
        if ( $d2[SKS] == "" )
        {
            $d2[SKS] = $dxx[SKSMAKUL];
        }
        unset( $kp );
        if ( $konversisemua == 0 )
        {
            unset( $kon );
        }
        if ( $d2[SEMESTER] != $semlama )
        {
            if ( $semlama != "" )
            {
				#echo "kesini";	
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=2\r\n\t\t\t\t\t\t\t\tstyle=''\r\n\t\t\t\t\t\t\t\talign=right\r\n\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\tJumlah SKS \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format_sikad( $bobots[$semlama], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2  >\r\n\t\t\t\t\t\t\t\tIndeks Prestasi : ".number_format_sikad( @$totals[$semlama] / @$bobots[$semlama], 2, ".", "," )."&nbsp;\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                $sem = $semlama % 2;
                if ( $sem == 0 )
                {
                    $sem = 2;
                }
                $semkurang = ceil( $semlama / 2 );
                $tahunlama = $angkatanmhs + $semkurang;
                $idmahasiswa = $d[ID];
            }
            $kelas = kelas( $i );
            ++$i;
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>Semester {$d2['SEMESTER']}&nbsp;</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
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
            /*$totals += $d2[SEMESTER];
            $bobots += $d2[SEMESTER];
            $bobotsemua += $d2[SKS];
            $totalsemua += $bobot * $d2[SKS];*/
			$totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
						$bobots[$d2[SEMESTER]]+=$d2[SKS];
						$bobotsemua+=$d2[SKS];
						$totalsemua+=$bobot*$d2[SKS];
        }
        else
        {
            $bobot = "";
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>  {$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot} &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai} &nbsp; </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$ii;
        ++$i;
    }
    if ( $semlama != "" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=2\r\n\t\t\t\t\t\t\t\tstyle=''\r\n\t\t\t\t\t\t\t\talign=right\r\n\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\tJumlah SKS  \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format_sikad( $bobots[$semlama], 2, ".", "," )." &nbsp;\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2 >\r\n\t\t\t\t\t\t\t\tIndeks Prestasi : ".number_format_sikad(@($totals[$semlama]/$bobots[$semlama]),2,'.',',')."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t";
        $sem = $semlama % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $semlama / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
    }
	#echo "SEM LAMA=".$semlama;
    if ( $semlama != "" )
    {
        $catatan = "";
        #$bodytranskrip .= "\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table   width=600>\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
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
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% ><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t\r\n                    ".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>";
        @include( "footertranskrip.php" );
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
        #$q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
        #mysqli_query($koneksi,$q);
        #$bodytranskrip .= "</table>\r\n\t\t\t\t";
		$bodytranskrip.="</table></div></div>";
    }
    
}
?>
