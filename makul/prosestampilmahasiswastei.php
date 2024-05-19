<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "trnlm.THSMSTRNLM";
$arraysort[1] = "trnlm.THSMSTRNLM";
$arraysort[2] = "trnlm.NIMHSTRNLM";
$arraysort[3] = "NAMAMAHASISWA";
$arraysort[4] = "trnlm.KDKMKTRNLM";
$arraysort[5] = "tbkmk.NAKMKTBKMK";
$arraysort[6] = "tbkmk.SKSMKTBKMK";
$arraysort[7] = "trnlm.KELASTRNLM";
$arraysort[8] = "trnlm.THSMSTRNLM,trnlm.NIMHSTRNLM,trnlm.KDKMKTRNLM";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst \r\n          WHERE IDX='{$idprodi}'";
    $hx = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = sqlfetcharray( $hx );
        $kodept = $dx[KDPTIMSPST];
        $kodejenjang = $dx[KDJENMSPST];
        $kodeps = $dx[KDPSTMSPST];
    }
    $qfield .= " AND tbkmk.KDPSTTBKMK='{$kodeps}' AND tbkmk.KDJENTBKMK='{$kodejenjang}' AND tbkmk.KDPTITBKMK='{$kodept}' ";
    $qjudul .= " Jurusan / Program Studi Mata Kuliah '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idprodim != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodim}'";
    $qjudul .= " Jurusan / Program Studi Mahasiswa '".$arrayprodidep[$idprodim]."' <br>";
    $qinput .= " <input type=hidden name=idprodim value='{$idprodim}'>";
    $href .= "idprodim={$idprodim}&";
}
if ( $idmahasiswa != "" )
{
    $qfield .= " AND NIMHSTRNLM LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND KDKMKTRNLM LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND SUBSTRING(trnlm.THSMSTRNLM,1,4) = '".( $tahun - 1 )."'";
    $qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND SUBSTRING(trnlm.THSMSTRNLM,5,1) = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND trnlm.KELASTRNLM = '{$kelas}'";
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 8;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM trnlm,mahasiswa , tbkmk\r\n\tWHERE    \r\n   mahasiswa.ID=trnlm.NIMHSTRNLM AND\r\n\t trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK AND \r\n   tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\r\n   tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND \r\n   tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND\r\n   tbkmk.KDPTITBKMK=trnlm.KDPTITRNLM \r\n\t{$qfield}\r\n \r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT trnlm.*,NAKMKTBKMK AS NAMAMAKUL,mahasiswa.NAMA AS NAMAMAHASISWA,\r\n\tmahasiswa.ANGKATAN,\r\n\tSKSMKTBKMK SKS,KDPSTTBKMK AS IDPRODI,mahasiswa.IDPRODI AS IDP\r\n\tFROM trnlm,mahasiswa , tbkmk\r\n\tWHERE    \r\n   mahasiswa.ID=trnlm.NIMHSTRNLM AND\r\n\t trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK AND \r\n   tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\r\n   tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND \r\n   tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND\r\n   tbkmk.KDPTITBKMK=trnlm.KDPTITRNLM \r\n\t\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Pengambilan M-K Mahasiswa (KRS)" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Pengambilan M-K Mahasiswa (KRS)" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo " {$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmahasiswastei.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Semester</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama Mahasiswa</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Kelas</td>\r\n \t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $semesterx = "";
        $kurawal = "";
        $kurtutup = "";
        $styleerror = "";
        $errornamakurikulum = "";
        $namamakulkurikulum = getnamamk( "{$d['KDKMKTRNLM']}", "".( $d[TAHUN] - 1 )."{$d['SEMESTER']}", $d[IDP] );
        if ( $namamakulkurikulum == "" )
        {
            $styleerror = "style='background-color:#ffaaaa'";
            $errornamakurikulum = "tidak ada di kurikulum";
        }
        $d[TAHUN] = substr( $d[THSMSTRNLM], 0, 4 ) + 1;
        $d[SEMESTER] = substr( $d[THSMSTRNLM], 4, 1 );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left  nowrap>{$semesterx} {$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurtutup} &nbsp;</td>\r\n   \t\t\t\t<td align=left>{$d['NIMHSTRNLM']}&nbsp;</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMAMAHASISWA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['KDKMKTRNLM']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMAMAKUL']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['SKS']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['KELASTRNLM']}&nbsp;</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        $totalsks += $d[SKS];
        if ( $tingkataksesusers[$kodemenu] == "T" && ( $statusoperatormakul == 1 && $prodis == $d[IDP] || $prodis == "" ) )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>  <a href='index.php?pilihan=p2tambah&aksi=tampiledit&data[tahun]={$d['TAHUN']}&data[semester]={$d['SEMESTER']}&idmahasiswa={$d['NIMHSTRNLM']}'>Edit KRS</td>\r\n \t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td colspan=7 align=right\t>Total SKS</td>\r\n   \t\t\t\t<td align=center>{$totalsks}</td>\r\n   \t\t\t \t<td align=center>&nbsp;</td>\r\n\t\t\t\t</tr>\t\t\r\n\t\t</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Pengambilan M-K Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
