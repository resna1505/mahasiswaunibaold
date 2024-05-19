<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n \t\t\t\tORDER BY makul.SEMESTER DESC,IDMAKUL \r\n\t\t\t\tLIMIT 0,1\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    $dn = sqlfetcharray( $hn );
    $semmax = $dn[SEMESTER];
    echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table border=1 width=600 style='border-collapse:collapse;'  >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2 >Kode</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 >Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 >SKS</td>\r\n \t\t\t\t\t\t\t<td colspan={$semmax}>NILAI SEMESTER</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    echo "<tr class=juduldata{$cetak} align=center>";
    $is = 1;
    while ( $is <= $semmax )
    {
        echo "<td align=center>{$is}</td>";
        ++$is;
    }
    echo "</tr>\r\n\t\t\t\t\t\t";
    $jenislama = 0 - 1;
    $arrayjenismakul2 = krsort( $arrayjenismakul );
    unset( $totals );
    foreach ( $arrayjenismakul as $kk => $vv )
    {
        echo "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center {$stylepage}>\r\n\t \r\n\t\t\t\t\t\t\t<td colspan=".( 3 + $semmax )."  align=left><br>{$vv}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        $q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tAND makul.JENIS='{$kk}'\r\n\t\t\t\tORDER BY makul.SEMESTER,IDMAKUL\r\n\t\t\t";
        $hn = mysqli_query($koneksi,$q);
        $i = 1;
        $semlama = "";
        while ( $d2 = sqlfetcharray( $hn ) )
        {
            $q = "SELECT SKSMAKUL FROM pengambilanmk WHERE\t\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC, SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
            $hxx = mysqli_query($koneksi,$q);
            $dxx = sqlfetcharray( $hxx );
            $d2[SKS] = $dxx[SKSMAKUL];
            unset( $kp );
            if ( $konversisemua == 0 )
            {
                unset( $kon );
            }
            if ( $d2[SEMESTER] != $semlama )
            {
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
            if ( $nilaidiambil == 1 )
            {
                $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS,NILAI,BOBOT,SIMBOL\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
                $hmk = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hmk ) )
                {
                    $dmk = sqlfetcharray( $hmk );
                    /*$bobot = $dmk[BOBOT];
                    $simbolmax = $nilai = $dmk[SIMBOL];
                    $nilai2 = $dmk[NILAI];
                    $ddmk[] = $dmk;*/
					$bobot=$dmk[BOBOT];
					$simbolmax=$nilai=$dmk[SIMBOL];
					$nilai2=$dmk[NILAI];						
					$ddmk[]=$dmk;
                }
            }
            else
            {
                #do
                #{
                    $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS,NILAI,BOBOT,SIMBOL\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t";
                    $hmk = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hmk ) )
                    {
                        $bobot = 0;
						while ($dmk=sqlfetcharray($hmk)) {
							if ($dmk[BOBOT]>=$bobot) {
								$bobot=$dmk[BOBOT];
								$simbolmax=$nilai=$dmk[SIMBOL];
								$nilai2=$dmk[NILAI];
							}
							$ddmk[]=$dmk;
						}
                    }
                #} while ( 0 );
                /*while ( $dmk = sqlfetcharray( $hmk ) )
                {
                    if ( $bobot <= $dmk[BOBOT] )
                    {
                        $bobot = $dmk[BOBOT];
                        $simbolmax = $nilai = $dmk[SIMBOL];
                        $nilai2 = $dmk[NILAI];
                    }
                    $ddmk[] = $dmk;
                    break;
                }*/
            }
            if ( $simbolmax != "-" && $nilai != "T" )
            {
                /*$bobots += $d2[SEMESTER];
                $totals += $d2[SEMESTER];
                $bobotsemua += $d2[SKS];
                $totalsemua += $bobot * $d2[SKS];
                $bobots2[$d2[SEMESTER]] += $d2[JENIS];
                $totals2[$d2[SEMESTER]] += $d2[JENIS];*/
				$bobots[$d2[SEMESTER]]+=$d2[SKS];
	 				    $totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
						  $bobotsemua+=$d2[SKS];
						  $totalsemua+=$bobot*$d2[SKS];
  						$bobots2[$d2[SEMESTER]][$d2[JENIS]]+=$d2[SKS];
   						$totals2[$d2[SEMESTER]][$d2[JENIS]]+=$bobot*$d2[SKS];
            }
            echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>";
            $is = 1;
            while ( $is <= $semmax )
            {
                if ( $is == $d2[SEMESTER] )
                {
                    echo "<td align=center>{$nilai}</td>";
                }
                else
                {
                    echo "<td align=center></td>";
                }
                ++$is;
            }
            echo "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
        if ( $semlama != "" )
        {
            $catatan = "";
            if ( $bobotsemua < $d[SKSMIN] )
            {
            }
        }
    }
    echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2>JUMLAH SKS</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobotsemua}</td>\r\n\t\t\t\t\t\t\t\t";
    $sumbobot = 0;
    $is = 1;
    while ( $is <= $semmax )
    {
        echo "<td align=center>".$bobots[$is]."</td>";
        $sumbobot += $bobots[$is];
        $sem = $is % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $is / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        include( "../makul/edittrakm.php" );
        $q = "UPDATE trakm SET\r\n                       SKSTTTRAKM='{$sumbobot}'\r\n                        WHERE\r\n                        NIMHSTRAKM='{$idmahasiswa}'\r\n                        AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                        ";
        mysqli_query($koneksi,$q);
        ++$is;
    }
    echo "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=3>INDEKS PRESTASI PER SEMESTER</td>\r\n\t\t\t\t\t\t\t\t";
    $sumbobot = $sumkr = 0;
    $is = 1;
    while ( $is <= $semmax )
    {
        echo "<td align=center> ".number_format_sikad(@($totals[$is]/$bobots[$is]),2,'.',',')."</td>";
        $sumbobot += $bobots[$is];
        $sumkr += $totals[$is];
        $sem = $is % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $is / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        include( "../makul/edittrakm.php" );
        $q = "UPDATE trakm SET\r\n                       NLIPKTRAKM='".number_format_sikad(@($sumkr/$sumbobot),2)."'  WHERE   NIMHSTRAKM='{$idmahasiswa}'  AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                        ";
        mysqli_query($koneksi,$q);
        ++$is;
    }
    echo "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    echo "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=600>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=".( 3 + $semmax ).">\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        $ipkku=@($totalsemua/$bobotsemua);
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        $ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')."  <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tPredikat Kelulusan </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap><b>Judul Karya Tulis Ilmiah : </b> <br>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>";
    @include( "footertranskrip.php" );
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    echo "</table>\r\n\t\t\t\t";
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
        echo "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
    }
}
?>
