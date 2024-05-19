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
$maxbaris = 47;
$tinggibaris = 20 / $maxbaris;
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
$q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,tbkmk.KDKELTBKMK,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY KDKELTBKMK,pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul,tbkmksp ,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY KDKELTBKMK,pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
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
if ( $PROFESI == 1 )
{
    @usort( @$arraydatatranskrip2, "SortBySemester" );
}
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
if ( 0 < $jumlahmakuldiambil )
{
    $bodytranskrip .= "\r\n\r\n          <table celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n            <tr valign=top>\r\n              <td style='width:10.3cm;'  valign=top>\r\n \r\n\t\t\t\t\t<table  celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n \r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center  valign=top> \r\n \r\n      \t\t\t\t\t\t\t<td style='width:2.5cm;height:1cm;border:none;'   ><!--<b>KODE MK.--></td>\r\n    \t\t\t\t\t\t\t<td style='width:6.5cm;height:1cm;border:none;'  align=center ><!--<b>MATA KULIAH--></td>\r\n    \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center ><!--<b>N--></td>\r\n     \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center  ><!--<b>K--></td> \r\n     \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center  ><!--<b>NxK--></td> \r\n\r\n\t\t\t\t\t\t</tr> \t\t\t\t\r\n      \r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    $kelompokmk = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $i == 47 )
            {
                $bodytranskrip .= "\r\n            \t <!--INSERTSISABARIS-->\r\n            \t </table>\r\n            \t   </td>\r\n                 <td  style='width:10.3cm;' valign=top >\r\n  \r\n\t\t\t\t\t<table  celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n           \r\n          \t\t\t\t\t\t<tr class=juduldata{$cetak} align=center  valign=top> \r\n           \r\n      \t\t\t\t\t\t\t<td style='width:2.5cm;height:1cm;border:none;'   ><!--<b>KODE MK.--></td>\r\n    \t\t\t\t\t\t\t<td style='width:6.5cm;height:1cm;border:none;'  align=center ><!--<b>MATA KULIAH--></td>\r\n    \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center ><!--<b>N--></td>\r\n     \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center  ><!--<b>K--></td> \r\n     \t\t\t\t\t\t\t<td style='width:0.7cm;height:1cm;border:none;'  align=center  ><!--<b>NxK--></td> \r\n\r\n          \r\n          \t\t\t\t\t\t</tr> \t\r\n\r\n  \r\n              \r\n              ";
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
                $totalbobot += $bobot;
            }
            else
            {
                $bobot = "";
            }
            if ( $nilai == "" && $nilaikosong == 0 )
            {
                echo "{$d2['IDMAKUL']} - Nilai kosong tidak dihitung<br>";
            }
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $namakelompokmk = "";
            if ( $kelompokmk != $arraykelompokmk[$d2[KDKELTBKMK]] )
            {
                $namakelompokmk = $arraykelompokmk[$d2[KDKELTBKMK]];
                $kelompokmk = $arraykelompokmk[$d2[KDKELTBKMK]];
            }
            $styleborderkosong = "";
            $styleborderkosong = "style='border-top:none;border-bottom:none;font-size:10pt;' ";
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr  align=left valign=top    >\r\n \r\n \r\n                  \t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=left   {$styleborderkosong} nowrap>{$d2['IDMAKUL']}</td> \r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<td  style='height:".$tinggibaris."cm;border:none;font-size:8pt;' {$styleborderkosong} nowrap > {$d2['NAMA']} </td>\r\n  \t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center   {$styleborderkosong} > {$nilai}</td>\r\n  \t\t\t\t\t\t\t<!-- \t<td align=center   {$styleborderkosong} >".number_format_sikad( $bobot, 0 )." </td> -->\r\n\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center   {$styleborderkosong} >{$d2['SKS']} </td>\r\n  \t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center    {$styleborderkosong} >".number_format_sikad( $d2[SKS] * $bobot, 0 )."  </td>\r\n \t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
    }
    $insertsisabaris = "";
    $sisabaris = $maxbaris - $i;
    if ( $sisabaris <= 0 )
    {
        $sisabaris = 1;
    }
    else if ( $sisabaris == 0 )
    {
        $sisabaris = 0;
    }
    if ( 0 < $sisabaris )
    {
        $is = 0;
        while ( $is <= $sisabaris )
        {
            $insertsisabaris .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top  {$styleborderkosong} >\r\n                <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=left   {$styleborderkosong} nowrap>&nbsp;</td> \r\n \t\t\t\t\t\t\t\t<td  style='height:".$tinggibaris."cm;border:none;font-size:8pt;' {$styleborderkosong} nowrap >&nbsp;</td>\r\n  \t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center   {$styleborderkosong} >&nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center   {$styleborderkosong} >&nbsp;</td>\r\n  \t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center    {$styleborderkosong} >&nbsp;</td>\r\n \t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t";
            ++$is;
        }
    }
    if ( $maxbaris - $i < 0 )
    {
        $bodytranskrip = str_replace( "<!--INSERTSISABARIS-->", $insertsisabaris, $bodytranskrip );
    }
    else
    {
        $bodytranskrip .= $insertsisabaris;
    }
    $bodytranskrip .= "</table>  \r\n          \r\n          </td></tr>\r\n          </table> \r\n          ";
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
    }
    else if ( $d[JENIS] != 0 || $PROFESI == 1 )
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
    @include( "footertranskripuntagblanko.php" );
    $bodytranskrip .= "\r\n          <table celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n            <tr valign=top>\r\n              <td style='width:10cm;'>                \r\n              \r\n              <table>\r\n                  <tr>\r\n                    <td style='width:3cm;height:0.5cm;border:none;font-size:8pt;' ><!-- TOTAL --> \r\n                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n                    NK</td>\r\n                    <td style='height:0.5cm;border:none;font-size:8pt;'>".number_format_sikad( $totalbm, 0 )."</td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td style='width:3cm;height:0.5cm;border:none;font-size:8pt;' ><!-- IP KUMULATIF --></td>\r\n                    <td  style='height:0.5cm;border:none;font-size:8pt;'></td>\r\n                  </tr>\r\n                </table>\r\n              \r\n              </td>\r\n              \r\n              \r\n\t\t\t\t       <td style='width:10cm;'> \r\n                <table>\r\n                  <tr>\r\n                    <td style='width:3cm;height:0.5cm;border:none;font-size:8pt;' ><!-- TOTAL--> </td>\r\n                    <td  style='height:0.5cm;border:none;font-size:8pt;'>{$bobotsemua}</td>\r\n                  </tr>\r\n                  <tr>\r\n                    <td style='width:3cm;height:0.5cm;border:none;font-size:8pt;' ><!-- IP KUMULATIF--></td>\r\n                    <td  style='height:0.5cm;border:none;font-size:8pt;'>{$ipkkuteks}</td>\r\n                  </tr>\r\n                </table>\r\n              \r\n              </td>\r\n              \r\n\t\t\t\t    </tr>\r\n\t\t\t\t  </table>\r\n\t\t\t\t  \r\n          <table celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n            <tr valign=top>\r\n              <td style='height:0.5cm;' colspan=2 >&nbsp;                \r\n              </td>\r\n             </tr>\r\n\r\n\r\n            <tr valign=top>\r\n              <td style='width:9.5cm;font-size:8pt;' valign=top>   \r\n              <br>\r\n              ".str_replace( "\n", "<br>", $d[TA] )."             \r\n              </td>\r\n              <td style='width:9.5cm;font-size:8pt;' valign=top >          \r\n              {$footertranskrip2}      \r\n              </td>\r\n            </tr>\r\n\t\t\t\t  </table>\r\n\t\t\t\t  \r\n\t\t\t\t  <!-- \r\n\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n \r\n  \t\t\t\t\t\t\t\t<td colspan=2><b>JUMLAH <font style='margin-left:105px;'>:</font></td>\r\n  \t\t\t\t\t\t\t\t<td align=center><b>  ".number_format_sikad( $totalbobot, 0 )." </td>\r\n  \t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n  \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 0 )."</td>\r\n \r\n\t\t\t\t\t\t\t</tr>\r\n \r\n \r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n \r\n  \t\t\t\t\t\t\t\t<td colspan=2  ><b>Indeks Prestasi Kumulatif</td>\r\n  \t\t\t\t\t\t\t\t<td style='border-left:1px solid white;'>: {$ipkkuteks}   </td> \r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n \r\n  \t\t\t\t\t\t\t\t<td colspan=3  valign=top ><b>Judul Skripsi</b> <font style='margin-left:80px;'>:</font><br><br> <br> ".str_replace( "\n", "<br>", $d[TA] )."  </td> \r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\r\n          \r\n              \r\n              </table>";
    $tmpcetakawal = str_replace( "<!--PREDIKATLULUS-->", $predikat, $tmpcetakawal );
    $bodytranskrip .= "\r\n\t\t\t\t  -->\r\n\t\t\t\t\t<table>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n \r\n \r\n ";
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
