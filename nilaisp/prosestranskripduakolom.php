<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tORDER BY makul.SEMESTER,IDMAKUL\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$jumlahmakuldiambil = sqlnumrows( $hn );
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
if ( 0 < sqlnumrows( $hn ) )
{
    if ( $aksi == "cetak" )
    {
        echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table >\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50%>";
    }
    echo "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table  {$borderx}   border=0  >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t<td>Nilai</td>\r\n\t\t\t\t\t\t\t<td>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t<td>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t<td>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    while ( $d2 = sqlfetcharray( $hn ) )
    {
        if ( $aksi == "cetak" && $i == $jumlahmakuldiambilper2 + 1 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table  {$borderx}  border=0  >\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>Bobot/<br>SKS<br>(b)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>Nilai</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>Nilai<br>Mutu<br>(n)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>Angka<br>Mutu<br>(m)</td>\r\n\t\t\t\t\t\t\t\t\t\t<td>(b)x(m)<br><br>(t)</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
        }
        $q = "SELECT SKSMAKUL FROM pengambilanmk WHERE\t\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC, SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
        $hxx = mysqli_query($koneksi,$q);
        $dxx = sqlfetcharray( $hxx );
        $d2[SKS] = $dxx[SKSMAKUL];
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
 						   $totalbm+=($d2[SKS]*$bobot);
        }
        echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format_sikad( $nilaiakhir, 2 )."</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>".number_format_sikad( $d2[SKS] * $bobot, 2 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=center><b>JUMLAH</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center> </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 2 )."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        echo "<TABLE>";
    }
    $catatan = "";
	if ($d[SKSMIN] > $bobotsemua) {
	}
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<table>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table  width=600>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap><b>Judul Tugas Akhir  </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    if ($d[JENIS] == 0 )
    {
        $ipkku=@($totalsemua/$bobotsemua);
								$ipkkuteks=number_format_sikad(@($totalsemua/$bobotsemua),2);
								$tmp=explode(".",$ipkkuteks);
								$tmp1=angkatoteks($tmp[0]);
								$blkkoma=$tmp[1];
								$tmp2="";
        for ($ia=0;$ia<=strlen($blkkoma)-1;$ia++) {
									 //echo $blkkoma[$ia];
									 $tmp2.=$angka[$blkkoma[$ia]+0]." ";
								}
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  {$ipkkuteks} ({$tmp1} koma {$tmp2})<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        $ipkku=@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2);
								$ipkkuteks=number_format_sikad(@((($totalsemua/$bobotsemua)+$d[IPKUAP])/2),2);
								$tmp=explode(".",$ipkkuteks);
								$tmp1=angkatoteks($tmp[0]);
								$blkkoma=$tmp[1];
								$tmp2="";
								for ($ia=0;$ia<=strlen($blkkoma)-1;$ia++) {
									 //echo $blkkoma[$ia];
									 $tmp2.=$angka[$blkkoma[$ia]+0]." ";
								}
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad(@($totalsemua/$bobotsemua),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad(@($d[IPKUAP]),2,'.',',')." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tYudisium </td><td>:  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap> ";
    if ( $konversisemua == 1 )
    {
        $q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        $ha = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $ha ) )
        {
            echo "\r\n\t\t\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>Keterangan Mutu Nilai</td></tr>";
            $syaratlama = 100;
            while ( $da = sqlfetcharray( $ha ) )
            {
                echo "\r\n  \t\t\t\t\t\t\t<tr><td  >{$da['SIMBOL']} = {$da['SYARAT']} - {$syaratlama} </td></tr>\r\n  \t\t\t\t\t";
                $syaratlama = $da[SYARAT] - 0.01;
            }
            echo " </table>\r\n\t\t\t\t<br><br>";
        }
    }
    $q = "\r\n\t\t\t\tSELECT ID,NAMA,SYARAT,SYARATW FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW ASC\r\n\t\t\t";
    $ha = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $ha ) )
    {
        echo "\r\n\r\n\t\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t<td><b>Predikat Kelulusan</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t ";
        $syaratlama = 4;
        while ( $da = sqlfetcharray( $ha ) )
        {
            echo "\r\n\t\t\t\t\t\t<tr >\r\n \r\n\t\t\t\t\t\t\t<td  >  \r\n \t\t\t\t\t\t \r\n \t\t\t\t\t\t\tIPK      {$da['SYARAT']} - {$syaratlama}\r\n \t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t\t<td>: {$da['NAMA']}</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $syaratlama = $da[SYARAT] - 0.01;
        }
        echo "</table>\r\n\t\t\t\t<br><br>";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>*Penjelasan:\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tNilai IPK: Jumlah Semua Nilai Mata Kuliah / Jumlah Semua SKS</td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t</table>\t\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=30%>";
    @include( "footertranskrip.php" );
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table>\r\n \r\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    echo "\r\n \t\t\t\t</td>\r\n \t\t\t\t</tr></table>\r\n \t\t\t\t\t";
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
