<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletranskrip .= "\r\n<style type=\"text/css\">\r\n\r\n.makeline {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\twidth:600px;\r\n\t}\r\n\t\r\n.makeline td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.smalline {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\twidth:150px;\r\n\t}\r\n\r\n.smalline td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n.skripsi {\r\n\tmargin: 10px 0;\r\n\tpadding: 10px;\r\n\tborder: 1px solid black;\r\n}\r\n\r\n\r\n</style>\r\n";
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
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\r\n          FROM nilaikonversi,makul\r\n          WHERE\r\n          nilaikonversi.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t  AND makul.JENIS='{$kk}'\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
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
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
if ( 0 < $jumlahmakuldiambil )
{
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t<table  >\r\n\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t<td width=50% valign=top>";
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t \r\n\t\t\t\t\t<table  celpadding=0 cellspacing=0 class=makeline >\r\n\t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<!-- <td>Kode</td> -->\r\n\t\t\t\t\t\t\t<td align=center><b>No</td>\r\n\t\t\t\t\t\t\t<td  align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t<td align=center><b>SKS</td>\r\n\t\t\t\t\t\t\t<!-- <td>Nilai</td> -->\r\n\t\t\t\t\t\t\t<td align=center><b>N</td>\r\n\t\t\t\t\t\t\t<!-- <td>Angka<br>Mutu<br>(m)</td>-->\r\n\t\t\t\t\t\t\t<td align=center><b>AK</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</thead>\r\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $aksi == "cetak" && $i == $jumlahmakuldiambilper2 + 1 )
            {
                $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td valign=top>\r\n\t\t\t\t\t\t\t\t<table   celpadding=0 cellspacing=0  class=makeline >\r\n      \t\t\t\t\t <thead style='display:table-header-group;'>\r\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t\t<!-- <td>Kode</td> -->\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>No</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>Mata Kuliah</td>\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>SKS</td>\r\n\t\t\t\t\t\t\t\t\t\t<!--<td>Nilai</td>-->\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>N</td>\r\n\t\t\t\t\t\t\t\t\t\t<!--<td>Angka<br>Mutu<br>(m)</td>-->\r\n\t\t\t\t\t\t\t\t\t\t<td align=center><b>AK</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\r\n\t\t\t            </thead>\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
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
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t\t\t<!-- <td>{$d2['IDMAKUL']}</td> -->\r\n\t\t\t\t\t\t\t\t<td  align=center> {$i}</td>\r\n\t\t\t\t\t\t\t\t<td> {$d2['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n\t\t\t\t\t\t\t\t<!-- <td align=center>".number_format_sikad( $nilaiakhir, 2 )."</td> -->\r\n \t\t\t\t\t\t\t\t<td align=center>{$nilai}</td>\r\n\t\t\t\t\t\t\t\t<!-- <td align=center>{$bobot}</td>-->\r\n \t\t\t\t\t\t\t\t<td align=center>".number_format_sikad( $d2[SKS] * $bobot, 2 )."  </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            ++$i;
        }
    }
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=2 align=left><b>JUMLAH</td>\r\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\r\n\t\t\t\t\t\t\t\t<!-- <td align=center> </td>\r\n \t\t\t\t\t\t\t\t<td align=center>&nbsp; </td> -->\r\n\t\t\t\t\t\t\t\t<td align=center>&nbsp;</td>\r\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 2 )."</td>\r\n\t\t\t\t\t\t\t</tr>";
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
        $statusipk = "\r\n \t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif (IPK) :  {$ipkkuteks} <!-- ({$tmp1} koma {$tmp2}) --><br>\r\n\t\t\t\t\t\t\t\t\t\t ";
    }
    else
    {
        $ipkku = @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2;
        $ipkkuteks = number_format_sikad( @( @$totalsemua / @$bobotsemua + @$d[IPKUAP] ) / 2, 2 );
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
        $statusipk = "\r\n \t\t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif Semester </td><td>:  ".number_format_sikad( @$totalsemua / @$bobotsemua, 2, ".", "," )." <br>\r\n  \t\t\t\t\t\t\t\t\t\tIndeks Prestasi Ujian AKhir Program (UAP)</td><td>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )." <br>\r\n\t  \t\t\t\t\t\t\t\t\tIndeks Prestasi Kumulatif </td><td>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\r\n\t\t \t\t\t\t\t\t\t\t";
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
    $statuspredikat = "\r\n \t\t\t\t\t\t\t\tPredikat  :  {$predikat} <br>\r\n\t\t\t\t\t\t\t\t ";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=left>\r\n\t\t\t\t\t\t\t\t<td colspan=5 align=left><b>\r\n                {$statusipk}\r\n                {$statuspredikat}\r\n                </td>\r\n \t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
    }
    else
    {
        $bodytranskrip .= "<TABLE>";
    }
    $catatan = "";
    $bodytranskrip .= "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<table border=0 width=95% cellpadding=0 cellspacing=0>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table width=50%>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\r\n\t\t\t\t\t\t\t\t\t\t<td  colspan='2'><b>Judul Skripsi  : </td> \r\n\t\t\t\t\t\t\t\t\t\t<td>\t\t\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t</tr> \t\r\n\t\t\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t\t\t<td colspan = '2'>\r\n\t\t\t\t\t\t\t\t\t\t<div class='skripsi'>\r\n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )."\r\n\t\t\t\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t\t";
    $bodytranskrip .= "\r\n\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t</p>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n              </table>\r\n              \r\n\t\t\t\t\t<table border=0 width=95%>\r\n\t\t\t\t\t\t<tr  align=left>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<table   class=form>\r\n\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% nowrap alig=center> ";
    if ( $konversisemua == 1 )
    {
        $q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        $ha = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $ha ) )
        {
            $bodytranskrip .= "\r\n\t\t\t\t\t\t\t<table>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<td><b>Keterangan Mutu Nilai</td></tr>";
            $syaratlama = 100;
            while ( $da = sqlfetcharray( $ha ) )
            {
                $bodytranskrip .= "\r\n  \t\t\t\t\t\t\t<tr><td  >{$da['SIMBOL']} = {$da['SYARAT']} - {$syaratlama} </td></tr>\r\n  \t\t\t\t\t";
                $syaratlama = $da[SYARAT] - 0.01;
            }
            $bodytranskrip .= " </table>\r\n\t\t\t\t<br><br>";
        }
    }
    $bodytranskrip .= "\r\n\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t</table><center>\r\n ";
    @include( "footertranskrip.php" );
    $bodytranskrip .= "<br>\r\n  <center>\r\n  <table  >\r\n    <tr align=center valign=top>\r\n    <td width=50% align=right>\r\n    <center>\r\n\t\t\t\t\t\t\t\t\t\t\t Keterangan Nilai:<br><br>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<table class=smalline cellpadding=0 cellspacing=0>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Nilai</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Bobot Nilai</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Predikat</td> \r\n                            </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>A</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>4</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Sangat Baik</td> \r\n                            </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>B+:B</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>3.5-3</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Baik</td> \r\n                            </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>C+:C</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>2.5-2</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Cukup</td> \r\n                            </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>D+:D</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>1.5-1</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Kurang</td> \r\n                            </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t</table>\t\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t<td width=50% align=left> \r\n                       <center>       \r\n\t\t\t\t\t\t\t\t\t\t\t Keterangan Singkatan :<br><br>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<table  class=smalline cellpadding=0 cellspacing=0>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>SKS</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Satuan Kredit Semester</td> \r\n                             </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>N</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Nilai</td> \r\n                             </tr>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<tr align=center>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>AK</td> \r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Angka Kualitas (SKS x N)</td> \r\n                             </tr>\r\n \t\t\t\t\t\t\t\t\t\t\t\t</table>\t\t\t\t\t\t\t\t\t\t\t\r\n    </td></tr></table>\r\n";
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
