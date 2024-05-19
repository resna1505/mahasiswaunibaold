<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletranskrip .= "<style type=\"text/css\">\r\n\r\n.lineborderblack {\r\n\tborder-top:1px solid black;\r\n\t\r\n\t}\r\n\t\r\n.lineborderblack td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding-left:3px;\r\n\tmargin:0px;\r\n\t}\r\n\t\r\n.lineborderblack td:last-child {\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n\r\n</style>\r\n<style type=\"text/css\">\r\n\r\n.makeborder {\r\n\twidth:100%;\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n.makeborder td {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\tfont-size:8px;\r\n\t}\r\n\t\r\ntd {\r\n\tpadding:0px;\r\n\tmargin:0px;\r\n\tfont-size:7.5px;\r\n\t}\r\n\t\r\n</style>";
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
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
        }
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT  \r\n        pengambilanmk.IDMAKUL, \r\n        pengambilanmk.BOBOT,\r\n        pengambilanmk.NILAI,\r\n        pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\r\n        pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\r\n\t\t\t\ttbkmk.NAMA2    ,\r\n        makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\r\n \t\t\t\t\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$bodytranskrip .= mysqli_error($koneksi);
while ( !( 0 < sqlnumrows( $hn ) ) || !( $d2 = sqlfetcharray( $hn ) ) )
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\ttbkmksp.NAKMKTBKMK    AS  NAMA,\r\n\t\t\t\ttbkmk.NAMA2     ,\r\n            makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
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
        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d3;
    }
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$i = $ii = 1;
$semlama = "";
unset( $totals );
if ( is_array( $arraydatatranskrip ) )
{
    $bodytranskrip .= "\r\n\t\t\t\t\r\n\t\t\t\t<table cellpading=0 cellspacing=0 width=1000  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t  <td width=50% align=left>\r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table cellpading=0 cellspacing=0 width=450 class=lineborderblack  >\r\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n        \t \r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>No.</td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>KODE MK</td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>MATA KULIAH </td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>SKS </td>\r\n        \t\t\t\t\t\t\t<td nowrap colspan=2><b>NILAI</td>\r\n         \t\t\t\t\t\t\t<td nowrap rowspan=2><b>MUTU</td>\r\n        \t\t\t\t\t\t</tr>\r\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n        \t \r\n         \t\t\t\t\t\t\t<td nowrap><b>ANGKA </td>\r\n        \t\t\t\t\t\t\t<td nowrap style='border-right:none;'><b>HURUF </td>\r\n         \t\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t";
    $xxx = 0;
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
                if ( $jenistampilan != "mrh" )
                {
                    $bodytranskrip .= "\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t   <td colspan=2 style='border:none' align=right > </td>\r\n                 <td   style='' align=right > Jumlah SKS   </td>\r\n\t\t\t\t\t\t\t\t<td align=center style='border-right:1px solid black;'>".number_format_sikad( $bobots[$semlama], 2, ".", "," )." </td>\r\n\t\t\t\t\t\t\t   <td colspan=2 style='border-bottom:none; ' align=right > </td>\r\n\t\t\t\t\t\t\t\t<td  align=center > ".number_format_sikad( @$totals[$semlama], 2, ".", "," )." </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t   <td colspan=2 style='border:none'  align=right > </td>\r\n                 <td   style='' align=right >   IP Semester  {$semlama}  </td>\r\n\t\t\t\t\t\t\t\t<td align=center style='border-right:1px solid black;'>".number_format_sikad( @$totals[$semlama] / @$bobots[$semlama], 2, ".", "," )." &nbsp; </td>\r\n\t\t\t\t\t\t\t\t<td colspan=3 style='border-bottom:none;border-right:none; ' >  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t";
                }
                if ( $semlama == 3 )
                {
                    $bodytranskrip .= "\r\n                  </table>\r\n                </td>\r\n                <td width=50% align=left>\r\n        \t\t\t\t\t<table cellpading=0 cellspacing=0 width=450 class=lineborderblack  >\r\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n        \t \r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>No.</td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>KODE MK</td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>MATA KULIAH </td>\r\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>SKS </td>\r\n        \t\t\t\t\t\t\t<td nowrap colspan=2><b>NILAI</td>\r\n         \t\t\t\t\t\t\t<td nowrap rowspan=2><b>MUTU</td>\r\n        \t\t\t\t\t\t</tr>\r\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n        \t \r\n         \t\t\t\t\t\t\t<td nowrap><b>ANGKA </td>\r\n        \t\t\t\t\t\t\t<td nowrap style='border-right:none;'><b>HURUF </td>\r\n         \t\t\t\t\t\t</tr>\r\n              ";
                }
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
            if ( $jenistampilan != "mrh" )
            {
                $bodytranskrip .= "\r\n    \t\t\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n    \t\t\t\t\t\t \r\n    \t\t\t\t\t\t\t\t<td colspan=7 style='border-left:none;border-right:none;' > Semester {$d2['SEMESTER']}&nbsp;</td>\r\n                    \t\t\t\t\t\t\t</tr>\r\n    \t\t\t\t\t\t";
                $xxx = 0;
            }
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
        $skor = "";
        $bobot = $d2[BOBOT];
        $nilai = $d2[SIMBOL];
        $nilai2 = 0;
        $simbolmax = $nilai;
        if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
        {
            $totals += $d2[SEMESTER];
            $bobots += $d2[SEMESTER];
            $bobotsemua += $d2[SKS];
            $totalsemua += $bobot * $d2[SKS];
            $skor = $bobot * $d2[SKS];
        }
        else
        {
            $bobot = "";
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        ++$xxx;
        $namainggris = "";
        if ( $d2[NAMA2] != "" )
        {
            $namainggris = "<i>({$d2['NAMA2']})</i>";
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td align=center>  {$xxx} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>  {$d2['IDMAKUL']}&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']} {$namainggris}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot} &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai} &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center>{$skor} &nbsp; </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$ii;
        ++$i;
    }
    if ( $semlama != "" )
    {
        if ( $jenistampilan != "mrh" )
        {
            $bodytranskrip .= "\r\n  \t\t\t\t\t \r\n  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t\t<tr >\r\n  \t\t\t\t\t\t\t   <td colspan=2 style='border:none' align=right > </td>\r\n                   <td   style='' align=right > Jumlah SKS   </td>\r\n  \t\t\t\t\t\t\t\t<td align=center style='border-right:1px solid black;'>".number_format_sikad( $bobots[$semlama], 2, ".", "," )." &nbsp; </td>\r\n  \t\t\t\t\t\t\t   <td colspan=2 style='border-bottom:none; ' align=right > </td>\r\n  \t\t\t\t\t\t\t\t<td  align=center > ".number_format_sikad( @$totals[$semlama], 2, ".", "," )." </td>\r\n  \t\t\t\t\t\t\t</tr>\r\n  \t\t\t\t\t\t\t<tr >\r\n  \t\t\t\t\t\t\t   <td colspan=2 style='border:none'  align=right > </td>\r\n                   <td   style='' align=right >   IP Semester  {$semlama}  </td>\r\n  \t\t\t\t\t\t\t\t<td align=center style='border-right:1px solid black;'>".number_format_sikad( @$totals[$semlama] / @$bobots[$semlama], 2, ".", "," )." &nbsp; </td>\r\n  \t\t\t\t\t\t\t\t<td colspan=3 style='border-bottom:none;border-right:none; ' >  </td>\r\n  \t\t\t\t\t\t\t</tr>\r\n  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t";
        }
        $sem = $semlama % 2;
        if ( $sem == 0 )
        {
            $sem = 2;
        }
        $semkurang = ceil( $semlama / 2 );
        $tahunlama = $angkatanmhs + $semkurang;
    }
    if ( $semlama != "" )
    {
        $catatan = "";
        $bodytranskrip .= "\r\n              <tr>\r\n\t\t\t\t\t\t\t\t<td align=center style='border:none;'>  </td>\r\n\t\t\t\t\t\t\t\t<td align=center style='border:none;'>  &nbsp;</td>\r\n\t \r\n\t\t\t\t\t\t\t\t<td   style='border:none;'> <b>TOTAL KREDIT</td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'><b>{$bobotsemua} &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td align=center  style='border:none;'>  &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'>  &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'><b>{$totalsemua} </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t";
        $ipkbeneran = @$totalsemua / @$bobotsemua;
        if ( $d[JENIS] == 0 )
        {
            $ipkbeneran = @$totalsemua / @$bobotsemua;
        }
        $bodytranskrip .= "\r\n              <tr>\r\n\t\t\t\t\t\t\t\t<td align=center style='border:none;'>  </td>\r\n\t\t\t\t\t\t\t\t<td align=center style='border:none;'>  &nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td  style='border:none;' > <b>INDEKS PRESTASI KUMULATIF</td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'> </td>\r\n\t\t\t\t\t\t\t\t<td align=center  style='border:none;'>  &nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'>  &nbsp; </td>\r\n \t\t\t\t\t\t\t\t<td align=center  style='border:none;'> <b>".number_format_sikad( $ipkbeneran, 2, ".", "," )." </td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</table>";
        if ( $jenistampilan != "mrh" )
        {
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<br>\r\n      \t\t\t\t\t<table cellpading=0 cellspacing=0 width=450 class=lineborderblack  >\r\n       \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n      \t \r\n      \t\t\t\t\t\t\t<td nowrap rowspan=2><b>No.</td>\r\n      \t\t\t\t\t\t\t<td nowrap rowspan=2><b>NAMA MATA AJARAN</td>\r\n      \t\t\t\t\t\t\t<td nowrap colspan=2><b>NILAI</td>\r\n      \t\t\t\t\t\t</tr>\r\n       \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n       \t\t\t\t\t\t\t<td nowrap><b>ANGKA </td>\r\n      \t\t\t\t\t\t\t<td nowrap><b>HURUF </td>\r\n      \t\t\t\t\t\t</tr>\r\n\r\n\r\n       \t\t\t\t\t\t<tr class=juduldata{$cetak} >\r\n      \t \r\n      \t\t\t\t\t\t\t<td nowrap align=center >1.</td>\r\n      \t\t\t\t\t\t\t<td nowrap style='border-right:1px solid black;'>Nilai rata-rata ujian tulis</td>\r\n      \t\t\t\t\t\t\t<td nowrap align=center >{$NILAIUAPTULIS}</td>\r\n      \t\t\t\t\t\t\t<td nowrap align=center >{$SIMBOLUAPTULIS}</td>\r\n      \t\t\t\t\t\t</tr>\r\n       \t\t\t\t\t\t<tr class=juduldata{$cetak} >\r\n      \t \r\n      \t\t\t\t\t\t\t<td nowrap align=center >2.</td>\r\n      \t\t\t\t\t\t\t<td nowrap style='border-right:1px solid black;'>Nilai rata-rata ujian praktek</td>\r\n      \t\t\t\t\t\t\t<td nowrap align=center >{$NILAIUAPPRAKTEK}</td>\r\n      \t\t\t\t\t\t\t<td nowrap align=center >{$SIMBOLUAPPRAKTEK}</td>\r\n      \t\t\t\t\t\t</tr>\r\n \r\n\r\n\t\t\t\t\t\t\t\t</table>  ";
        }
        $bodytranskrip .= "            \r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<table    width=450 >\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td   ><b>Judul Karya Tulis Ilmiah : </b>".str_replace( "\n", "<br>", $d[TA] )."  <br>\r\n                    </td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table> \r\n\r\n                  </table>\r\n          </td>\r\n         </tr>\r\n        </table>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</p>";
        if ( $jenistampilan != "mrh" )
        {
            include( "footertranskripmitrariahusada.php" );
        }
        else
        {
            include( "footertranskripmitrariahusada2.php" );
        }
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
}
?>
