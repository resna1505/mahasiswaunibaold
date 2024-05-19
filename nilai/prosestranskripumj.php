<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arraydatacsv[$d[ID]][biodata] = $d;
$qcuti = prepare_cuti_mahasiswa( $d[ID], "pengambilanmk" );
unset( $arraydatatranskrip2 );
unset( $jumlahmakuldiambil );
$totalbm = 0;
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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    do
    {
        if ( !( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) ) )
        {
            break;
        }
        else
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
            $q = "SELECT KDKELTBKMK FROM tbkmk WHERE KDKMKTBKMK = '{$dn2['IDMAKUL']}' \r\n               ORDER BY THSMSTBKMK DESC LIMIT 0,1";
            $htmp = mysqli_query($koneksi,$q);
        }
        if ( 0 < sqlnumrows( $h ) )
        {
            $dtmp = sqlfetcharray( $htmp );
        }
        $arraydatatranskrip2["{$dn2['IDMAKUL']}"][KDKELTBKMK] = $dtmp[KDKELTBKMK];
        unset( $htmp );
    } while ( 1 );
}
$q = "\r\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\r\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\r\n\t\t\t\ttbkmk.NAKMKTBKMK   AS NAMAMAKUL,makul.JENIS,\r\n\t\t\t\t{$fpenempatan} SEMESTER, KDKELTBKMK\r\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n \t\t\t\ttbkmk.THSMSTBKMK=pengambilanmk.THNSM AND\r\n\t\t\t\ttbkmk.KDKMKTBKMK=pengambilanmk.IDMAKUL AND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t{$qcuti}\r\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
$jumlahmakuldiambil += sqlnumrows( $hn );
$tmpcetak = "";
$tmpcetak .= "\r\n       ";
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
    $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,makul.JENIS,\r\n    \t\t\t\t{$fpenempatansp} SEMESTER, KDKELTBKMK\r\n    \t\t\t\tFROM pengambilanmksp,makul ,tbkmksp,mspst\r\n\t\t\t\tWHERE \r\n        mspst.IDX='{$d['IDPRODI']}' AND\r\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\r\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n     \t\t\t\ttbkmksp.THSMSTBKMK=pengambilanmksp.THNSM AND\r\n    \t\t\t\ttbkmksp.KDKMKTBKMK=pengambilanmksp.IDMAKUL AND\r\n    \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
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
        $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
    }
}
@usort( @$arraydatatranskrip2, "SortByKelompok" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
if ( 0 < $jumlahmakuldiambil )
{
    $tmpcetak .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table  border=1 style='border-collapse:collapse;' width=800 border=0  cellpadding=4 cellspacing=0>\r\n\t\t\t\t\t <thead style='display:table-header-group;' >\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td rowspan=2 style='border-right:none;' align=center> </td>\r\n\t\t\t\t\t\t\t<td rowspan=2 style='border-left:none;' align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td rowspan=2 align=center><b>Kode<br>Mata<br>Kuliah</td>\r\n\t\t\t\t\t\t\t<td colspan=4 align=center><b>Prestasi</td>\r\n\t\t\t\t\t\t\t \r\n  \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n \t\t\t\t\t\t\t<td align=center><b>HM</td>\r\n\t\t\t\t\t\t\t<td align=center><b>AM</td>\r\n\t\t\t\t\t\t\t<td align=center><b>K</td>\r\n\t\t\t\t\t\t\t<td align=center><b>M</td>\r\n \t\t\t\t\t\t</tr>\r\n \t\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    unset( $datacsv );
    $lastkelompok = "";
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
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
            if ( $lastkelompok != $d2[KDKELTBKMK] )
            {
                $ii = 1;
                $tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t   <td style='border-right:none;'></td>\r\n\t\t\t\t\t\t\t\t<td  style='border-left:none;'> <b>".$arraykelompokmk[$d2[KDKELTBKMK]]."</td>\r\n\t\t\t\t\t\t\t   <td  >&nbsp;</td>\r\n\t\t\t\t\t\t\t   <td  >&nbsp;</td>\r\n\t\t\t\t\t\t\t   <td  >&nbsp;</td>\r\n\t\t\t\t\t\t\t   <td  >&nbsp;</td>\r\n\t\t\t\t\t\t\t   <td  >&nbsp;</td>\r\n\t\t\t\t\t\t\t</tr>\r\n            ";
                $lastkelompok = $d2[KDKELTBKMK];
            }
            $tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<td  style='border-right:none;' align=center> {$ii} </td>\r\n\t\t\t\t\t\t\t\t<td  style='border-left:none;'> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}</td>\r\n\t\t\t\t\t\t\t\t \r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$bobot}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<td align=center>".$d2[SKS] * $bobot." </td>\r\n \t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $arraycsvmakul["{$d2['IDMAKUL']}"] = $d2[NAMA];
            unset( $tmp );
            $tmp[nilai] = $nilai;
            $tmp[bobot] = number_format_sikad( $bobot );
            $tmp[total] = number_format_sikad( $bobot * $d2[SKS] );
            $arraycsvmakulmhs["{$d['ID']}"]["{$d2['IDMAKUL']}"] = $tmp;
            unset( $tmp );
            ++$i;
            ++$ii;
        }
    }
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
    $tmpcetak .= "\r\n \r\n     \t\t\t\t\t\t<tr align=left> \r\n      \t\t\t\t\t\t  <td style='border-right:none;'></td>\r\n      \t\t\t\t\t\t  <td style='border-left:none;' colspan=4><b>J U M L A H</td>\r\n      \t\t\t\t\t\t  <td align=center><b>{$bobotsemua}</td>\r\n      \t\t\t\t\t\t  <td  align=center><b>{$totalbm}</td>\r\n      \t\t\t\t\t\t</tr>\r\n     \t\t\t\t\t\t<tr align=left> \r\n      \t\t\t\t\t\t  <td style='border-right:none;'></td>\r\n      \t\t\t\t\t\t  <td style='border-left:none;' colspan=4  style='border-right:none'><b>Tanggal Yusidium</td>\r\n      \t\t\t\t\t\t  <td colspan=2 align=right  style='border-left:none'><b>{$tglyudisium}</td>\r\n       \t\t\t\t\t\t</tr>\r\n     \t\t\t\t\t\t<tr align=left> \r\n      \t\t\t\t\t\t  <td style='border-right:none;'></td>\r\n      \t\t\t\t\t\t  <td style='border-left:none;' colspan=4 style='border-right:none'><b>Jumlah Kredit Kumulatif</td>\r\n      \t\t\t\t\t\t  <td colspan=2 align=right  style='border-left:none'><b>{$bobotsemua}</td>\r\n       \t\t\t\t\t\t</tr>\r\n     \t\t\t\t\t\t<tr align=left> \r\n      \t\t\t\t\t\t  <td style='border-right:none;'></td>\r\n      \t\t\t\t\t\t  <td style='border-left:none;' colspan=4 style='border-right:none'><b>Indeks Prestasi Kumulatif</td>\r\n      \t\t\t\t\t\t  <td colspan=2 align=right  style='border-left:none'><b>{$ipkkuteks}</td>\r\n       \t\t\t\t\t\t</tr>\r\n     \t\t\t\t\t\t<tr align=left> \r\n      \t\t\t\t\t\t  <td style='border-right:none;'></td>\r\n      \t\t\t\t\t\t  <td style='border-left:none;' colspan=2 style='border-right:none'><b>PREDIKAT KELULUSAN</td>\r\n      \t\t\t\t\t\t  <td colspan=4 style='border-left:none' align=right><b>{$predikat}</td>\r\n       \t\t\t\t\t\t</tr>\r\n \t\t\t\t\t\t\t</table>\r\n \t\t\t\t\t\t\t<table>\r\n \t\t\t\t\t\t\t  <tr align=left>\r\n \t\t\t\t\t\t\t    <td colspan=3>Keterangan</td>\r\n  \t\t\t\t\t\t\t  </tr>\r\n \t\t\t\t\t\t\t  <tr align=left>\r\n \t\t\t\t\t\t\t    <td>HM</td>\r\n \t\t\t\t\t\t\t    <td>=</td>\r\n \t\t\t\t\t\t\t    <td>Huruf Mutu (A,B,C,D)</td>\r\n \t\t\t\t\t\t\t  </tr>\r\n \t\t\t\t\t\t\t  <tr align=left>\r\n \t\t\t\t\t\t\t    <td>AM</td>\r\n \t\t\t\t\t\t\t    <td>=</td>\r\n \t\t\t\t\t\t\t    <td>Angka Mutu (4,3,2,1)</td>\r\n \t\t\t\t\t\t\t  </tr>\r\n \t\t\t\t\t\t\t  <tr align=left>\r\n \t\t\t\t\t\t\t    <td>K</td>\r\n \t\t\t\t\t\t\t    <td>=</td>\r\n \t\t\t\t\t\t\t    <td>Kredit (2 sks, dsb)</td>\r\n \t\t\t\t\t\t\t  </tr>\r\n \t\t\t\t\t\t\t  <tr align=left>\r\n \t\t\t\t\t\t\t    <td>M</td>\r\n \t\t\t\t\t\t\t    <td>=</td>\r\n \t\t\t\t\t\t\t    <td>Mutu (perkalian dari AM dan K)</td>\r\n \t\t\t\t\t\t\t  </tr>\r\n \t\t\t\t\t\t\t</table>\r\n                \r\n               ";
    $catatan = "";
    $tmpcetak .= "\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t</table>\r\n\t\t\t   </td>\r\n         </tr>\r\n         <tr>\r\n         <td>\t\t \r\n\t\t\t\t\t<table width=100%>\r\n \t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n                  <td colspan=2>\r\n                  <br><br>\r\n                  ";
    $arraydatacsv["{$d['ID']}"][TOTAL] = $totalbm;
    $arraydatacsv["{$d['ID']}"][IPK] = $ipkkuteks;
    $arraydatacsv["{$d['ID']}"][YUDISIUM] = $predikat;
    if ( $iscsv == 1 )
    {
        if ( $aksi != "cetak" )
        {
            $bodytranskrip .= $tmpcetak;
        }
    }
    else
    {
        $bodytranskrip .= $tmpcetak;
    }
    $tmpcetak = "\r\n                \r\n                   </td>\r\n                  \r\n                  </tr>\r\n\t\t\t\t\t\t\t\t</table>\t\t\r\n       \r\n  \t\t\t\t\t\t\t\t\r\n ";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\r\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
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
        $tmpcetak .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
    }
}
if ( $iscsv == 1 )
{
    if ( $aksi != "cetak" )
    {
        $bodytranskrip .= $tmpcetak;
    }
}
else
{
    $bodytranskrip .= $tmpcetak;
}
?>
