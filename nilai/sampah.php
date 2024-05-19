<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "TRANSKRIPASLI\r\n\r\n";
if ( $konversisemua == 1 )
{
    $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
        {
            $kon[] = $dkonversi;
        }
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT DISTINCT pengambilanmk.IDMAKUL, \r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tmakul.SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tORDER BY makul.SEMESTER,IDMAKUL\r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    echo "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table {$border} width=600 border=0  >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    while ( $d2 = sqlfetcharray( $hn ) )
    {
        $q = "SELECT SKSMAKUL,TAHUN FROM pengambilanmk WHERE\t\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC, SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
        $hxx = mysqli_query($koneksi,$q);
        $dxx = sqlfetcharray( $hxx );
        $tahunlama = $d2[TAHUN];
        $d2[SKS] = $dxx[SKSMAKUL];
        unset( $kp );
        if ( $konversisemua == 0 )
        {
            unset( $kon );
        }
        if ( $d2[SEMESTER] != $semlama )
        {
            if ( $semlama != "" )
            {
                echo "\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=2\r\n\t\t\t\t\t\t\t\tstyle=''\r\n\t\t\t\t\t\t\t\talign=right\r\n\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\tJumlah SKS \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format( $bobots[$semlama], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2  >\r\n\t\t\t\t\t\t\t\tIndeks Prestasi : ".number_format( @$totals[$semlama] / @$bobots[$semlama], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                $sem = $semlama % 2;
                if ( $sem == 0 )
                {
                    $sem = 2;
                }
                $semkurang = ceil( $semlama / 2 );
                $tahunlama = $angkatanmhs + $semkurang;
                $idmahasiswa = $d[ID];
                include( "../makul/edittrakm.php" );
                $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  NLIPKTRAKM='".number_format( @$totalsemua / @$bobotsemua, 2 )."', \r\n                SKSTTTRAKM='{$bobotsemua}'\r\n                WHERE\r\n                NIMHSTRAKM='{$d['ID']}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
                mysqli_query($koneksi,$q);
            }
            $kelas = kelas( $i );
            ++$i;
            echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t\t\t<td colspan=5><b>Semester {$d2['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
            $semlama = $d2[SEMESTER];
        }
        $kelas = kelas( $i );
        unset( $d2[TAHUN] );
        unset( $d2[KELAS] );
        unset( $ddmk );
        if ( $nilaidiambil == 1 )
        {
            $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
            $hmk = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hmk ) )
            {
                $dmk = sqlfetcharray( $hmk );
                $ddmk[] = $dmk;
            }
        }
        else
        {
            do
            {
                $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t";
                $hmk = mysqli_query($koneksi,$q);
            } while ( 0 );
            do
            {
                if ( !( 0 < sqlnumrows( $hmk ) ) || !( $dmk = sqlfetcharray( $hmk ) ) )
                {
                    $ddmk[] = $dmk;
                    break;
                }
            } while ( 1 );
        }
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        if ( is_array( $ddmk ) )
        {
            foreach ( $ddmk as $kmk => $vmk )
            {
                $bobotmax = 0;
                $totalmax = 0;
                $nilaiakhir = 0;
                $d2[TAHUN] = $vmk[TAHUN];
                $d2[SEMESTERX] = $vmk[SEMESTER];
                $d2[KELAS] = $vmk[KELAS];
                $q = "\r\n\t\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t";
                $hkom = mysqli_query($koneksi,$q);
                if ( sqlnumrows( $hkom ) <= 0 )
                {
                    $nilai = "";
                    $bobot = "";
                    $total = "";
                }
                else
                {
                    while ( $dkom = sqlfetcharray( $hkom ) )
                    {
                        $kp[] = $dkom;
                    }
                    if ( $konversisemua == 0 )
                    {
                        $q = "\r\n\t\t\t\t\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t\t\t\t\t";
                        $hkon = mysqli_query($koneksi,$q);
                        do
                        {
                            if ( !( 0 < sqlnumrows( $hkon ) ) || !( $dkon = sqlfetcharray( $hkon ) ) )
                            {
                                $kon[] = $dkon;
                            }
                        } while ( 1 );
                    }
                    $q = "\r\n\t\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t";
                    $hnilai = mysqli_query($koneksi,$q);
                    unset( $datanilai );
                    $nilaiakhir = "-";
                    if ( 0 < sqlnumrows( $hnilai ) )
                    {
                        while ( $dnilai = sqlfetcharray( $hnilai ) )
                        {
                            $datanilai[$dnilai[IDKOMPONEN]] = $dnilai[NILAI];
                        }
                        $nilaiakhir = 0;
                        foreach ( $kp as $k => $v )
                        {
                            $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                        }
                        if ( is_array( $kon ) )
                        {
                            foreach ( $kon as $k => $v )
                            {
                                if ( $v[SYARAT] <= $nilaiakhir )
                                {
                                    $totalmax = $v[NILAI] * $d2[SKS];
                                    $bobotmax = $v[NILAI];
                                    $simbolmax = $v[SIMBOL];
                                    break;
                                    break;
                                }
                            }
                        }
                    }
                    if ( $totalmaxdicari <= $totalmax )
                    {
                        $totalmaxdicari = $totalmax;
                        $bobotmaxdicari = $bobotmax;
                        $simbolmaxdicari = $simbolmax;
                        $nilaiakhirdicari = $nilaiakhir;
                    }
                }
            }
            $nilaiakhir = $nilaiakhirdicari;
            $totalmax = $totalmaxdicari;
            $bobotmax = $bobotmaxdicari;
            $simbolmax = $simbolmaxdicari;
            if ( $simbolmax != "-" )
            {
                $totalnilaiakhir += $nilaiakhir;
                $nilai = $simbolmax;
                $bobot = number_format( $bobotmax, 2, ".", "," );
                $total = number_format( $totalmax, 2, ".", "," );
                $totals += $d2[SEMESTER];
                $totalsemua += $totalmax;
            }
        }
        if ( $simbolmax != "-" )
        {
            $bobots += $d2[SEMESTER];
            $bobotsemua += $d2[SKS];
        }
        echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']} </td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $idmakul = $d2[IDMAKUL];
        $sem = $semlama % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $semlama / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        include( "../makul/editrnlm.php" );
        $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\t\t  NLAKHTRNLM='{$nilai}', \r\n                BOBOTTRNLM='{$bobot}'\r\n                WHERE\r\n                NIMHSTRNLM='{$idmahasiswa}'\r\n                AND THSMSTRNLM='".( $tahunlama - 1 )."{$sem}'\r\n                AND KDKMKTRNLM='{$d2['IDMAKUL']}'\r\n                ";
        mysqli_query($koneksi,$q);
        ++$i;
    }
    if ( $semlama != "" )
    {
        echo "\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td colspan=2\r\n\t\t\t\t\t\t\t\tstyle=''\r\n\t\t\t\t\t\t\t\talign=right\r\n\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\tJumlah SKS \r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format( $bobots[$semlama], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2 >\r\n\t\t\t\t\t\t\t\tIndeks Prestasi : ".number_format( @$totals[$semlama] / @$bobots[$semlama], 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t";
        $sem = $semlama % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $semlama / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        include( "../makul/edittrakm.php" );
        $q = "UPDATE trakm SET\r\n\t\t\t\t\t\t\t  NLIPKTRAKM='".number_format( @$totalsemua / @$bobotsemua, 2 )."', \r\n                SKSTTTRAKM='{$bobotsemua}'\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
        mysqli_query($koneksi,$q);
    }
    if ( $semlama != "" )
    {
        $catatan = "";
        echo "\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table   width=600>\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
        if ( !( $bobotsemua < $d[SKSMIN] ) || $d[JENIS] == 0 )
        {
            $ipkku = @$totalsemua / @$bobotsemua;
            echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
        }
        else
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
            echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
        $i = 1;
        while ( $i <= count( $totals ) )
        {
            $data[$i] = $totals[$i] / @$bobots[$i];
            $datanx[$i] = $i;
            ++$i;
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
}
echo "\r\n TRANSKRIP\r\n \r\n Waks";
if ( $konversisemua == 1 )
{
    $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
        {
            $kon[] = $dkonversi;
        }
    } while ( 1 );
}
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
            if ( $nilaidiambil == 1 )
            {
                $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
                $hmk = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hmk ) )
                {
                    $dmk = sqlfetcharray( $hmk );
                    $ddmk[] = $dmk;
                }
            }
            else
            {
                do
                {
                    $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t";
                    $hmk = mysqli_query($koneksi,$q);
                } while ( 0 );
                do
                {
                    if ( !( 0 < sqlnumrows( $hmk ) ) || !( $dmk = sqlfetcharray( $hmk ) ) )
                    {
                        $ddmk[] = $dmk;
                        break;
                    }
                } while ( 1 );
            }
            $nilai = "";
            $total = "";
            $bobot = "";
            $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
            if ( is_array( $ddmk ) )
            {
                foreach ( $ddmk as $kmk => $vmk )
                {
                    $bobotmax = 0;
                    $totalmax = 0;
                    $nilaiakhir = 0;
                    $d2[TAHUN] = $vmk[TAHUN];
                    $d2[SEMESTERX] = $vmk[SEMESTER];
                    $d2[KELAS] = $vmk[KELAS];
                    $q = "\r\n\t\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t";
                    $hkom = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $hkom ) <= 0 )
                    {
                        $nilai = "";
                        $bobot = "";
                        $total = "";
                    }
                    else
                    {
                        while ( $dkom = sqlfetcharray( $hkom ) )
                        {
                            $kp[] = $dkom;
                        }
                        if ( $konversisemua == 0 )
                        {
                            $q = "\r\n\t\t\t\t\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t\t\t\t\t";
                            $hkon = mysqli_query($koneksi,$q);
                            do
                            {
                                if ( !( 0 < sqlnumrows( $hkon ) ) || !( $dkon = sqlfetcharray( $hkon ) ) )
                                {
                                    $kon[] = $dkon;
                                }
                            } while ( 1 );
                        }
                        $q = "\r\n\t\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t";
                        $hnilai = mysqli_query($koneksi,$q);
                        unset( $datanilai );
                        $nilaiakhir = "-";
                        if ( 0 < sqlnumrows( $hnilai ) )
                        {
                            while ( $dnilai = sqlfetcharray( $hnilai ) )
                            {
                                $datanilai[$dnilai[IDKOMPONEN]] = $dnilai[NILAI];
                            }
                            $nilaiakhir = 0;
                            foreach ( $kp as $k => $v )
                            {
                                $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                            }
                            if ( is_array( $kon ) )
                            {
                                foreach ( $kon as $k => $v )
                                {
                                    if ( $v[SYARAT] <= $nilaiakhir )
                                    {
                                        $totalmax = $v[NILAI] * $d2[SKS];
                                        $bobotmax = $v[NILAI];
                                        $simbolmax = $v[SIMBOL];
                                        break;
                                        break;
                                    }
                                }
                            }
                        }
                        if ( $totalmaxdicari <= $totalmax )
                        {
                            $totalmaxdicari = $totalmax;
                            $bobotmaxdicari = $bobotmax;
                            $simbolmaxdicari = $simbolmax;
                            $nilaiakhirdicari = $nilaiakhir;
                        }
                    }
                }
                $nilaiakhir = $nilaiakhirdicari;
                $totalmax = $totalmaxdicari;
                $bobotmax = $bobotmaxdicari;
                $simbolmax = $simbolmaxdicari;
                if ( $simbolmax != "-" )
                {
                    $totalnilaiakhir += $nilaiakhir;
                    $nilai = $simbolmax;
                    $bobot = number_format( $bobotmax, 2, ".", "," );
                    $total = number_format( $totalmax, 2, ".", "," );
                    $totals += $d2[SEMESTER];
                    $totalsemua += $totalmax;
                    $totals2[$d2[SEMESTER]] += $d2[JENIS];
                }
            }
            if ( $simbolmax != "-" )
            {
                $bobots += $d2[SEMESTER];
                $bobotsemua += $d2[SKS];
                $bobots2[$d2[SEMESTER]] += $d2[JENIS];
            }
            echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $idmakul = $d2[IDMAKUL];
            $sem = $d2[SEMESTER] % 2;
            if ( $sem == 0 )
            {
                $sem = 2;
            }
            $semkurang = ceil( $d2[SEMESTER] / 2 );
            $tahunlama = $angkatanmhs + $semkurang;
            include( "../makul/editrnlm.php" );
            $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\t\t  NLAKHTRNLM='{$nilai}', \r\n                BOBOTTRNLM='{$bobot}'\r\n                WHERE\r\n                NIMHSTRNLM='{$idmahasiswa}'\r\n                AND THSMSTRNLM='".( $tahunlama - 1 )."{$sem}'\r\n                AND KDKMKTRNLM='{$d2['IDMAKUL']}'\r\n                ";
            mysqli_query($koneksi,$q);
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
    echo "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=600>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=7>\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / @$bobotsemua;
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    $i = 1;
    while ( $i <= count( $totals ) )
    {
        $data[$i] = $totals[$i] / @$bobots[$i];
        $datanx[$i] = $i;
        ++$i;
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
echo "\r\n/// TRANSKRIP KOLOM \r\n\r\n";
if ( $konversisemua == 1 )
{
    $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
        {
            $kon[] = $dkonversi;
        }
    } while ( 1 );
}
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
            if ( $nilaidiambil == 1 )
            {
                $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
                $hmk = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hmk ) )
                {
                    $dmk = sqlfetcharray( $hmk );
                    $ddmk[] = $dmk;
                }
            }
            else
            {
                do
                {
                    $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t";
                    $hmk = mysqli_query($koneksi,$q);
                } while ( 0 );
                do
                {
                    if ( !( 0 < sqlnumrows( $hmk ) ) || !( $dmk = sqlfetcharray( $hmk ) ) )
                    {
                        $ddmk[] = $dmk;
                        break;
                    }
                } while ( 1 );
            }
            $nilai = "";
            $total = "";
            $bobot = "";
            $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
            if ( is_array( $ddmk ) )
            {
                foreach ( $ddmk as $kmk => $vmk )
                {
                    $bobotmax = 0;
                    $totalmax = 0;
                    $nilaiakhir = 0;
                    $d2[TAHUN] = $vmk[TAHUN];
                    $d2[SEMESTERX] = $vmk[SEMESTER];
                    $d2[KELAS] = $vmk[KELAS];
                    $q = "\r\n\t\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t";
                    $hkom = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $hkom ) <= 0 )
                    {
                        $nilai = "";
                        $bobot = "";
                        $total = "";
                    }
                    else
                    {
                        while ( $dkom = sqlfetcharray( $hkom ) )
                        {
                            $kp[] = $dkom;
                        }
                        if ( $konversisemua == 0 )
                        {
                            $q = "\r\n\t\t\t\t\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t\t\t\t\t";
                            $hkon = mysqli_query($koneksi,$q);
                            do
                            {
                                if ( !( 0 < sqlnumrows( $hkon ) ) || !( $dkon = sqlfetcharray( $hkon ) ) )
                                {
                                    $kon[] = $dkon;
                                }
                            } while ( 1 );
                        }
                        $q = "\r\n\t\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t";
                        $hnilai = mysqli_query($koneksi,$q);
                        unset( $datanilai );
                        $nilaiakhir = "-";
                        if ( 0 < sqlnumrows( $hnilai ) )
                        {
                            while ( $dnilai = sqlfetcharray( $hnilai ) )
                            {
                                $datanilai[$dnilai[IDKOMPONEN]] = $dnilai[NILAI];
                            }
                            $nilaiakhir = 0;
                            foreach ( $kp as $k => $v )
                            {
                                $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                            }
                            if ( is_array( $kon ) )
                            {
                                foreach ( $kon as $k => $v )
                                {
                                    if ( $v[SYARAT] <= $nilaiakhir )
                                    {
                                        $totalmax = $v[NILAI] * $d2[SKS];
                                        $bobotmax = $v[NILAI];
                                        $simbolmax = $v[SIMBOL];
                                        break;
                                        break;
                                    }
                                }
                            }
                        }
                        if ( $totalmaxdicari <= $totalmax )
                        {
                            $totalmaxdicari = $totalmax;
                            $bobotmaxdicari = $bobotmax;
                            $simbolmaxdicari = $simbolmax;
                            $nilaiakhirdicari = $nilaiakhir;
                        }
                    }
                }
                $nilaiakhir = $nilaiakhirdicari;
                $totalmax = $totalmaxdicari;
                $bobotmax = $bobotmaxdicari;
                $simbolmax = $simbolmaxdicari;
                if ( $simbolmax != "-" )
                {
                    $totalnilaiakhir += $nilaiakhir;
                    $nilai = $simbolmax;
                    $bobot = number_format( $bobotmax, 2, ".", "," );
                    $total = number_format( $totalmax, 2, ".", "," );
                    $totals += $d2[SEMESTER];
                    $totalsemua += $totalmax;
                    $totals2[$d2[SEMESTER]] += $d2[JENIS];
                }
            }
            if ( $simbolmax != "-" )
            {
                $bobots += $d2[SEMESTER];
                $bobotsemua += $d2[SKS];
                $bobots2[$d2[SEMESTER]] += $d2[JENIS];
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
            $idmakul = $d2[IDMAKUL];
            $sem = $d2[SEMESTER] % 2;
            if ( $sem == 0 )
            {
                $sem = 2;
            }
            $semkurang = ceil( $d2[SEMESTER] / 2 );
            $tahunlama = $angkatanmhs + $semkurang;
            include( "../makul/editrnlm.php" );
            $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\t\t  NLAKHTRNLM='{$nilai}', \r\n                BOBOTTRNLM='{$bobot}'\r\n                WHERE\r\n                NIMHSTRNLM='{$idmahasiswa}'\r\n                AND THSMSTRNLM='".( $tahunlama - 1 )."{$sem}'\r\n                AND KDKMKTRNLM='{$d2['IDMAKUL']}'\r\n                ";
            mysqli_query($koneksi,$q);
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
        echo "<td align=center> ".number_format( @$totals[$is] / @$bobots[$is], 2, ".", "," )."</td>";
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
        $q = "UPDATE trakm SET\r\n                       NLIPKTRAKM='".number_format( $sumkr / $sumbobot, 2 )."'\r\n                        WHERE\r\n                        NIMHSTRAKM='{$idmahasiswa}'\r\n                        AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                        ";
        mysqli_query($koneksi,$q);
        ++$is;
    }
    echo "\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    echo "\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<table width=600>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=".( 3 + $semmax ).">\r\n\t\t\t\t\t\t\t\t<p>\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<table >\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tJumlah Mutu </td><td>: ".number_format( $totalsemua, 2, ".", "," )."\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\tJumlah Kredit </td><td>: ".number_format( $bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / @$bobotsemua;
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>:  ".number_format( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    $i = 1;
    while ( $i <= count( $totals ) )
    {
        $data[$i] = $totals[$i] / @$bobots[$i];
        $datanx[$i] = $i;
        ++$i;
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
echo "\r\n// Transkrip 2 Kolom\r\n\r\n";
if ( $konversisemua == 1 )
{
    $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
        {
            $kon[] = $dkonversi;
        }
    } while ( 1 );
}
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
        if ( $nilaidiambil == 1 )
        {
            $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\tLIMIT 0,1\r\n\t\t\t\t\t";
            $hmk = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hmk ) )
            {
                $dmk = sqlfetcharray( $hmk );
                $ddmk[] = $dmk;
            }
        }
        else
        {
            do
            {
                $q = "SELECT \r\n\t\t\t\t\t\tpengambilanmk.TAHUN,\r\n\t\t\t\t\t\tpengambilanmk.SEMESTER,\r\n\t\t\t\t\t\tpengambilanmk.KELAS\r\n\t\t\t\t\t\tFROM pengambilanmk\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND IDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tORDER BY TAHUN DESC,SEMESTER DESC\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t";
                $hmk = mysqli_query($koneksi,$q);
            } while ( 0 );
            do
            {
                if ( !( 0 < sqlnumrows( $hmk ) ) || !( $dmk = sqlfetcharray( $hmk ) ) )
                {
                    $ddmk[] = $dmk;
                    break;
                }
            } while ( 1 );
        }
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        if ( is_array( $ddmk ) )
        {
            foreach ( $ddmk as $kmk => $vmk )
            {
                $bobotmax = 0;
                $totalmax = 0;
                $nilaiakhir = 0;
                $d2[TAHUN] = $vmk[TAHUN];
                $d2[SEMESTERX] = $vmk[SEMESTER];
                $d2[KELAS] = $vmk[KELAS];
                $q = "\r\n\t\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t";
                $hkom = mysqli_query($koneksi,$q);
                if ( sqlnumrows( $hkom ) <= 0 )
                {
                    $nilai = "";
                    $bobot = "";
                    $total = "";
                }
                else
                {
                    while ( $dkom = sqlfetcharray( $hkom ) )
                    {
                        $kp[] = $dkom;
                    }
                    if ( $konversisemua == 0 )
                    {
                        $q = "\r\n\t\t\t\t\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t\t\t\t\t";
                        $hkon = mysqli_query($koneksi,$q);
                        do
                        {
                            if ( !( 0 < sqlnumrows( $hkon ) ) || !( $dkon = sqlfetcharray( $hkon ) ) )
                            {
                                $kon[] = $dkon;
                            }
                        } while ( 1 );
                    }
                    $q = "\r\n\t\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\t\tIDMAKUL='{$d2['IDMAKUL']}'\r\n\t\t\t\t\t\t\t\t\tAND TAHUN='{$d2['TAHUN']}'\r\n\t\t\t\t\t\t\t\t\tAND SEMESTER='{$d2['SEMESTERX']}'\r\n\t\t\t\t\t\t\t\t\tAND KELAS='{$d2['KELAS']}'\r\n\t\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t\t";
                    $hnilai = mysqli_query($koneksi,$q);
                    unset( $datanilai );
                    $nilaiakhir = "-";
                    if ( 0 < sqlnumrows( $hnilai ) )
                    {
                        while ( $dnilai = sqlfetcharray( $hnilai ) )
                        {
                            $datanilai[$dnilai[IDKOMPONEN]] = $dnilai[NILAI];
                        }
                        $nilaiakhir = 0;
                        foreach ( $kp as $k => $v )
                        {
                            $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                        }
                        if ( is_array( $kon ) )
                        {
                            foreach ( $kon as $k => $v )
                            {
                                if ( $v[SYARAT] <= $nilaiakhir )
                                {
                                    $totalmax = $v[NILAI] * $d2[SKS];
                                    $bobotmax = $v[NILAI];
                                    $simbolmax = $v[SIMBOL];
                                    break;
                                    break;
                                }
                            }
                        }
                    }
                    if ( $totalmaxdicari <= $totalmax )
                    {
                        $totalmaxdicari = $totalmax;
                        $bobotmaxdicari = $bobotmax;
                        $simbolmaxdicari = $simbolmax;
                        $nilaiakhirdicari = $nilaiakhir;
                    }
                }
            }
            $nilaiakhir = $nilaiakhirdicari;
            $totalmax = $totalmaxdicari;
            $bobotmax = $bobotmaxdicari;
            $simbolmax = $simbolmaxdicari;
            if ( $simbolmax != "-" )
            {
                $totalnilaiakhir += $nilaiakhir;
                $nilai = $simbolmax;
                $bobot = number_format( $bobotmax, 2, ".", "," );
                $total = number_format( $totalmax, 2, ".", "," );
                $totals += $d2[SEMESTER];
                $totalsemua += $totalmax;
            }
        }
        if ( $simbolmax != "-" )
        {
            $bobots += $d2[SEMESTER];
            $bobotsemua += $d2[SKS];
            $totalbm += $d2[SKS] * $bobot;
        }
        echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>".number_format( $nilaiakhir, 2 )."</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n \t\t\t\t\t\t\t\t<td align=center>".number_format( $d2[SKS] * $bobot, 2 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $idmakul = $d2[IDMAKUL];
        $sem = $d2[SEMESTER] % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $d2[SEMESTER] / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
        include( "../makul/editrnlm.php" );
        $q = "UPDATE trnlm SET\r\n\t\t\t\t\t\t\t  NLAKHTRNLM='{$nilai}', \r\n                BOBOTTRNLM='{$bobot}'\r\n                WHERE\r\n                NIMHSTRNLM='{$idmahasiswa}'\r\n                AND THSMSTRNLM='".( $tahunlama - 1 )."{$sem}'\r\n                AND KDKMKTRNLM='{$d2['IDMAKUL']}'\r\n                ";
        mysqli_query($koneksi,$q);
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=center><b>JUMLAH</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center> </td>\r\n\t\t\t\t\t\t\t\t<td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format( $totalbm, 2 )."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        echo "<TABLE>";
    }
    $catatan = "";
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<table>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table  width=600>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap><b>Judul Tugas Akhir  </td> \r\n\t\t\t\t\t\t\t\t\t\t\t<td>: \r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\r\n\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t</tr> \t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    if ( !( $bobotsemua < $d[SKSMIN] ) || $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / @$bobotsemua;
        $ipkkuteks = number_format( @$totalsemua / @$bobotsemua, 2 );
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
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK)</td><td>:  {$ipkkuteks} ({$tmp1} koma {$tmp2})<br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        $ipkkuteks = number_format( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2 );
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
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t\t\t\t\t\t\t\t\t</td></tr>\r\n\t\t\t\t\t\t\t\t\t\t";
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
    $i = 1;
    while ( $i <= count( $totals ) )
    {
        $data[$i] = $totals[$i] / @$bobots[$i];
        $datanx[$i] = $i;
        ++$i;
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
echo "\r\n\r\n";
?>
