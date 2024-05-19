<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.borderline {\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\r\nthead tr td{\r\n\tborder-top:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\t\r\ntfoot td {\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\r\n</style>\r\n";
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
    do
    {
        if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
            ++$jmlkonversi;
        }
    } while ( 1 );
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
    $hn3 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysqli_error($koneksi);
    do
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
    } while ( 1 );
}
@usort( @$arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil );
if ( 0 < $jumlahmakuldiambil )
{
    $bodytranskrip .= "\r\n\t\t\t\t\t\r\n\t\t\t\t\t<table      border=0 cellpadding=0 cellspacing=0 style='width:20cm;'>\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\t<tr  align=left valign=top  style='height:2cm;'>\r\n\t\t\t\t\t\t\t\t<td   style='width:1.5cm;' align=center>&nbsp;</td>\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t<td  style='width:8cm;'   >&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td  style='width:2cm;'  align=center>&nbsp;</td>\r\n  \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>&nbsp;</td>\r\n  \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>&nbsp;</td>\r\n  \t\t\t\t\t\t\t\t<td style='width:4cm;'  align=center>&nbsp; </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t \r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $i % 38 == 0 )
            {
                $bodytranskrip .= "\r\n            </table>\r\n            <br><br><br><br> \r\n            <table  >\r\n              <tr>\r\n                <td style='width:13cm;'>&nbsp;</td>\r\n                <td align=center  ><b>Buka halaman berikutnya</b><br><i>Please see next page</i></td>\r\n              </tr>\r\n              \r\n            </table>\r\n            \r\n            </div>";
                $bodytranskrip .= "\r\n     \t\t\t\t \r\n    \t\t\t\t\t".str_replace( "-after", "-before", $tmpcetakawal )."\r\n    \t\t\t\t\t<table      border=0 cellpadding=0 cellspacing=0 style='width:20cm;'>\r\n    \t\t\t\t\t \r\n    \t\t\t\t\t\t\t<tr  align=left valign=top  style='height:2cm;'>\r\n    \t\t\t\t\t\t\t\t<td   style='width:1.5cm;' align=center>&nbsp;</td>\r\n    \t\t\t\t\t\t\t\t \r\n    \t\t\t\t\t\t\t\t<td  style='width:8cm;'   >&nbsp;</td>\r\n    \t\t\t\t\t\t\t\t<td  style='width:2cm;'  align=center>&nbsp;</td>\r\n      \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>&nbsp;</td>\r\n      \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>&nbsp;</td>\r\n      \t\t\t\t\t\t\t\t<td style='width:4cm;'  align=center>&nbsp; </td>\r\n    \t\t\t\t\t\t\t</tr>\r\n    \t\t\t\t \r\n    \t\t\t\t";
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
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top>\r\n\t\t\t\t\t\t\t\t<td   style='width:1cm;' align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t<!-- <td>{$d2['IDMAKUL']}</td> -->\r\n\t\t\t\t\t\t\t\t<td  style='width:8.7cm;'   ><i> {$d2['NAMA']}</i></td>\r\n\t\t\t\t\t\t\t\t<td  style='width:2cm;'  align=center>{$d2['SKS']} </td>\r\n  \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>{$nilai}</td>\r\n  \t\t\t\t\t\t\t\t<td style='width:2cm;'  align=center>".number_format_sikad( $bobot, 0 )."</td>\r\n  \t\t\t\t\t\t\t\t<td style='width:4cm;'  align=center>".number_format_sikad( $d2[SKS] * $bobot, 0 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t \t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=center><b> </td>\r\n\t\t\t\t\t\t\t\t<td align=center colspan=4><hr></td>\r\n \r\n \t\t\t\t\t\t\t</tr>  \t\t\t\t\t \t\r\n              <tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=center><b> </td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n \r\n\t\t\t\t\t\t\t\t<td align=center> </td><td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 0 )."</td>\r\n\t\t\t\t\t\t\t</tr>  \r\n\t\t\t\t\t\t\t ";
    $catatan = "";
    $bodytranskrip .= "\r\n              <tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td  align=center><b> </td>\r\n\t\t\t\t\t\t\t\t<td align=left> \r\n\t\t\t\t\t\t\t\t<table width=100%>\r\n            \r\n            ";
    if ( $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / @$bobotsemua;
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
        }
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t   \r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n                     <td  > <b>IPK <br></b> <i>(Grade Point Average)</i></td><td><b>:   {$ipkkuteks}  </td>\r\n                   </tr>";
    }
    else
    {
        if ( issudahlulus( $d[ID] ) )
        {
            $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
            $ipkkuteks = number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2 );
        }
        else
        {
            $ipkku = @$totalsemua / @$bobotsemua;
            $ipkkuteks = number_format_sikad( @$totalsemua / @$bobotsemua, 2 );
        }
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
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
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n                     <td  > <b>Indeks Prestasi Kumulatif Semester  </b> </td><td><b>:   ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )."  </td>\r\n                   </tr>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n                     <td  > <b>Indeks Prestasi Ujian AKhir Program (UAP)</b> </td><td><b>:   ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )."  </td>\r\n                   </tr>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n                     <td  > <b>IPK <br></b> <i>(Grade Point Average)</i></td><td><b>:   {$ipkkuteks}  </td>\r\n                   </tr>                                      \r\n\r\n \r\n\t\t\t\t\t\t\t\t\t\t";
    }
    $predikat = "";
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
            {
                $predikat = " {$v['NAMA']} / <i>{$v['NAMA2']}</i>";
                break;
            }
        }
    }
    $sisakebawah = number_format( 19.5 - ( ( $i - 37 ) * 0.49 + 5 ), 2 );
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t   \r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n                     <td  > <b>Predikat Kelulusan</b> <br> <i>(Completion Predicate)</i></td><td><b>:   {$predikat}  </td>\r\n                     \r\n                  </tr>\r\n                  </table>\r\n                  <br><br>\r\n                  <b>TRANSKRIP INI DIBUAT DENGAN SEBENARNYA</b><br>\r\n                  <i>This Transcript is Certified to be Correct and Accurate</i>\r\n                  \r\n                  \r\n                  <table>\r\n                  <tr style='height:".$sisakebawah."cm'>\r\n                    <td>&nbsp;  </td>\r\n                  </tr>\r\n                  </table>\r\n                  \r\n                  \r\n                  </td>\r\n                  \r\n                  </tr>\r\n                  \r\n                  </table>\r\n                  ";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $footertranskrip = "";
    @include( "footertranskripunimal.php" );
    $bodytranskrip .= $footertranskrip;
    $footertranskrip = "";
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
