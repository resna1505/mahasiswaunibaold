<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletranskrip .= "<style type=\"text/css\">\n\n.lineborderblack {\n\tborder-top:1px solid black;\n\t\n\t}\n\t\n.lineborderblack td {\n\tborder-bottom:1px solid black;\n\tborder-left:1px solid black;\n\tpadding-left:3px;\n\tmargin:0px;\n\t}\n\t\n.lineborderblack td:last-child {\n\tborder-right:1px solid black;\n\t}\n\t\n\n</style>\n<style type=\"text/css\">\n\n.makeborder {\n\twidth:100%;\n\tborder-bottom:1px solid black;\n\tborder-left:1px solid black;\n\t}\n\n.makeborder td {\n\tborder-top:1px solid black;\n\tborder-right:1px solid black;\n\tfont-size:8px;\n\t}\n\t\ntd {\n\tpadding:0px;\n\tmargin:0px;\n\tfont-size:12px;\n\t}\n\t\n</style>";
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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \n          {$fpenempatankonversi} AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\n          FROM nilaikonversi,makul\n          WHERE\n          nilaikonversi.IDMAKUL=makul.ID\n          AND IDMAHASISWA='{$d['ID']}'\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
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
$q = "\n\t\t\t\tSELECT  \n        pengambilanmk.IDMAKUL, \n        pengambilanmk.BOBOT,\n        pengambilanmk.NILAI,\n        pengambilanmk.SIMBOL,\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,\n        pengambilanmk.NAMA,\n\t\t\t\ttbkmk.NAKMKTBKMK    AS NAMAMAKUL,\n\t\t\t\ttbkmk.NAMA2    ,\n        makul.JENIS,\n\t\t\t\t{$fpenempatan} SEMESTER\n\t\t\t\tFROM pengambilanmk,makul,tbkmk  ,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n\t\t\t\t\n \t\t\t\t\n\t\t\t\t{$qcuti}\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n\t\t\t";
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
    $q = "\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\n    \t\t\t\ttbkmksp.NAKMKTBKMK    AS  NAMA,\n\t\t\t\ttbkmk.NAMA2     ,\n            makul.JENIS,\n    \t\t\t\t{$fpenempatansp} SEMESTER\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n    \t\t\t";
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
    $bodytranskrip .= "\n\t\t\t\t\n\t\t\t\t<table cellpading=0 cellspacing=0 width=1000 border=0 >\n\n \n\t\t\t\t";
    ++$semcount;
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
            if ( $semcount % 2 == 1 )
            {
                if ( 2 < $semcount )
                {
                    $bodytranskrip .= "\n                  </table></td></tr>";
                }
                $bodytranskrip .= "\n         \t\t\t\t<tr valign=top>\n        \t\t\t\t  <td width=50% align=center>\n    \t\t\t\t\t\t\t\t <b>  Semester ".$arrayromawi[$d2[SEMESTER]]."&nbsp; \n        \t\t\t\t\t\n        \t\t\t\t\t\n \n              ";
            }
            else
            {
                $bodytranskrip .= "\n                     </table>  \n                </td>\n                <td width=50%  align=center>\n        \t\t\t\t\t <b>  Semester ".$arrayromawi[$d2[SEMESTER]]."&nbsp; \n                   \n              ";
            }
            ++$semcount;
            $sem = $semlama % 2;
            if ( $sem == 0 )
            {
                $sem = 2;
            }
            $semkurang = ceil( $semlama / 2 );
            $tahunlama = $angkatanmhs + $semkurang;
            $idmahasiswa = $d[ID];
            $kelas = kelas( $i );
            ++$i;
            $bodytranskrip .= "\n    \t\t\t\t\t \n    \t\t\t\t\t\t \n        \t\t\t\t\t<table cellpading=0 cellspacing=0 width=450 class=lineborderblack  >\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\n        \t \n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>No.</td>\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>KODE MK</td>\n        \t\t\t\t\t\t\t<td nowrap rowspan=2><b>MATA KULIAH </td>\n         \t\t\t\t\t\t\t<td nowrap colspan=3><b>NILAI</td>\n         \t\t\t\t\t\t</tr>\n         \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\n        \t \n         \t\t\t\t\t\t\t<td nowrap><b>K </td>\n         \t\t\t\t\t\t\t<td nowrap><b>H </td>\n        \t\t\t\t\t\t\t<td nowrap  ><b>NM </td>\n         \t\t\t\t\t\t</tr>\n                       \n                    \t\t\t\t\t\t\t\n    \t\t\t\t\t\t";
            $xxx = 0;
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
        $bodytranskrip .= "\n\t\t\t\t\t  \n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\n\t\t\t\t\t\t\t\t<td align=center>  {$xxx} </td>\n\t\t\t\t\t\t\t\t<td align=center>  {$d2['IDMAKUL']}&nbsp;</td>\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']} {$namainggris}</td>\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} &nbsp;</td>\n \t\t\t\t\t\t\t\t<td align=center>{$nilai} &nbsp; </td>\n \t\t\t\t\t\t\t\t<td align=center>{$skor} &nbsp; </td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t \n\t\t\t\t\t";
        ++$ii;
        ++$i;
    }
    if ( $semlama != "" )
    {
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
        $ipkbeneran = @$totalsemua / @$bobotsemua;
        $ipkbeneran = @$totalsemua / @$bobotsemua;
        $predikat = "";
        if ( is_array( $konpredikat ) )
        {
            foreach ( $konpredikat as $k => $v )
            {
                if ( $v[SYARAT] <= $ipkbeneran && $d[MASABELAJAR] <= $v[SYARATW] )
                {
                    $predikat = $v[NAMA];
                    break;
                }
            }
        }
        $bodytranskrip .= "\n \t\n\t\t\t\t\t\t\n\t\t\t\t\t\t\n\t\t\t\t\t\t\t</table> \n\n \n                      \n \n \n          </td>\n         </tr>\n        </table>\t\t\t\t\t\t\n        <br>\t\t\n\t            <table width=1000>\n              <tr valign=top>\n                <td width=30%>\n                  <table >\n                    <tr>\n                      <td>Jumlah Kredit</td>\n                      <td>{$bobotsemua} </td>\n                    </tr>\n                    <tr>\n                      <td>Indeks prestasi Kumulatif</td>\n                      <td>".number_format_sikad( $ipkbeneran, 2, ".", "," )."</td>\n                    </tr>\n                    <tr>\n                      <td>Predikat Kelulusan</td>\n                      <td>{$predikat} </td>\n                    </tr>\n                  </table>\n                \n                </td>\n                <td  width=30%>\n                <b>KETERANGAN</b>\n                <table>\n                  <tr valign=top>\n                    <td nowrap>\n                      <table>\n                        <tr>\n                          <td  nowrap>A=4 : Sangat Baik</td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>B=3 : Baik</td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>C=2 : Cukup</td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>D=1 : Kurang</td>\n                        </tr>\n                      </table>\n                    </td>\n                    <td nowrap>\n                      <table>\n                        <tr>\n                          <td  nowrap>K = Kredit</td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>H = Hasil</td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>NM = Nilai Mutu </td>\n                        </tr>\n                        <tr>\n                          <td  nowrap>MK = Mata Kuliah</td>\n                        </tr>\n                      </table>                    \n                    </td>\n                  </tr>\n                </table>\n                \n                </td>\n                <td  width=30%>Judul : </b>".str_replace( "\n", "<br>", $d[TA] )." </td>\n              </tr>\n            </table>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</p>";
        include( "footertranskripunilak.php" );
        $bodytranskrip .= "\n\t\t\t\t\t\t";
        $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \n\t\t\t\t\t\tWHERE\n\t\t\t\t\t\tID='{$d['ID']}'";
        mysqli_query($koneksi,$q);
        $bodytranskrip .= "\n \t\t\t\t</td>\n \t\t\t\t</tr></table>\n \t\t\t\t\t";
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
