<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n \t\t\t\tORDER BY makul.SEMESTER,IDMAKUL \r\n\t\t\t\tLIMIT 0,1\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    echo "  \r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table  {$border} width=600 border=0  >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $jenislama = 0 - 1;
    foreach ( $arrayjenismakul as $kk => $vv )
    {
        $stylepage = "";
        if ( $kk == 1 )
        {
            $stylepage = "style='page-break-before:always;'";
        }
        echo "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center {$stylepage}>\r\n\t \r\n\t\t\t\t\t\t\t<td colspan=7  align=left><br>{$vv}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        $q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tAND makul.JENIS='{$kk}'\r\n\t\t\t\tORDER BY makul.SEMESTER,IDMAKUL\r\n\t\t\t";
        $hn = mysqli_query($koneksi,$q);
        $i = 1;
        $semlama = "";
        unset( $totals );
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
                $kelas = kelas( $i );
                ++$i;
                echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>Semester {$d2['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
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
                    $bobot = $dmk[BOBOT];
                    $simbolmax = $nilai = $dmk[SIMBOL];
                    $nilai2 = $dmk[NILAI];
                    $ddmk[] = $dmk;
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
						while ( $dmk = sqlfetcharray( $hmk ) )
						{
							if ( $bobot <= $dmk[BOBOT] )
							{
								$bobot = $dmk[BOBOT];
								$simbolmax = $nilai = $dmk[SIMBOL];
								$nilai2 = $dmk[NILAI];
							}
							$ddmk[] = $dmk;
							#break;
						}
                    }
                #} while ( 0 );
               
            }
            if ( $simbolmax != "-" && $nilai != "T" )
            {
                $bobots[$d2[SEMESTER]]+=$d2[SKS];
	 				    $totals[$d2[SEMESTER]]+=$bobot*$d2[SKS];
						  $bobotsemua+=$d2[SKS];
						  $totalsemua+=$bobot*$d2[SKS];
  						$bobots2[$d2[SEMESTER]][$d2[JENIS]]+=$d2[SKS];
   						$totals2[$d2[SEMESTER]][$d2[JENIS]]+=$bobot*$d2[SKS];
            }
            echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
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
    echo "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=600>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format_sikad( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format_sikad( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        #$ipkku = @$totalsemua / @$bobotsemua;
		$ipkku=@($totalsemua/$bobotsemua);
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:   ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        #$ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
		$ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
if ( $diagram == 1 && is_array( $totals ) )
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
    /*$i = 1;
    while ( $i <= count( $totals ) )
    {
        $data[$i] = $totals[$i] / @$bobots[$i];
        $datanx[$i] = $i;
        ++$i;
    }*/
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
        echo "<br style='page-break-after:always'>";
        echo "\r\n\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t<image src='{$folder}"."{$xx}' >\r\n\t\t\t\t\t\t\t\t</td></tr></table>\r\n\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t";
    }
}
?>
