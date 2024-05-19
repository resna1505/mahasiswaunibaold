<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID LIKE '%{$id}%'";
    $qjudul .= " Kode mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $semester != "" )
{
    $qfield .= " AND SEMESTER = '{$semester}'";
    $qjudul .= " Semester '{$semester}' <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $sks != "" )
{
    $qfield .= " AND SKS = '{$sks}'";
    $qjudul .= " SKS '{$sks}' <br>";
    $qinput .= " <input type=hidden name=sks value='{$sks}'>";
    $href .= "sks={$sks}&";
}
if ( $jenismakul != "" )
{
    $qfield .= " AND JENIS='{$jenismakul}'";
    $qjudul .= " Jenis '".$arrayjenismakul[$jenismakul]."' <br>";
    $qinput .= " <input type=hidden name=jenismakul value='{$jenismakul}'>";
    $href .= "jenismakul={$jenismakul}&";
}
if ( $kelompokmakul != "" )
{
    $qfield .= " AND KELOMPOK='{$kelompokmakul}'";
    $qjudul .= " Kelompk '".$arraykelompokmakul[$kelompokmakul]."' <br>";
    $qinput .= " <input type=hidden name=kelompokmakul value='{$kelompokmakul}'>";
    $href .= "kelompokmakul={$kelompokmakul}&";
}
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT tbkmk.* FROM makul ,tbkmk\r\n\tWHERE makul.ID=tbkmk.KDKMKTBKMK {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY {$sort}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Mata Kuliah" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Mata Kuliah" );
        printmesgcetak( $qjudul );
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td>Tahun Semester</td> \r\n        <td>Kode PT</td>\r\n        <td>Kode PS</td>\r\n        <td>Jenjang</td>\r\n\r\n\t\t\t\t<td>Kode MK</td>\r\n\t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>SKS</td>\r\n\t\t\t\t<td>SKS Tatap Muka</td>\r\n\t\t\t\t<td>SKS Praktikum</td>\r\n\t\t\t\t<td>SKS Praktek Lapangan</td>\r\n\t\t\t\t<td>Semester</td>\r\n\t\t\t\t<td>Kelompok</td>\r\n\t\t\t\t<td>Kurikulum</td>\r\n\t\t\t\t<td>Wajib/Pilihan</td>\r\n\t\t\t\t<td>NIDN Dosen Pengampu</td>\r\n\t\t\t\t<td>Jenjang PS Pengampu</td>\r\n\t\t\t\t<td>PS Pengampu</td>\r\n\t\t\t\t<td>Status MK</td>\r\n \r\n\t\t\t\t<td>Silabus</td>\r\n\t\t\t\t<td>Satuan Acara Perkuliahan</td>\r\n\t\t\t\t<td>Bahan Ajar</td>\r\n\t\t\t\t<td>Diktat</td>\r\n \r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=center> {$d['THSMSTBKMK']}</td> \r\n  \t\t\t\t<td align=center> {$d['KDPTITBKMK']}</td> \r\n  \t\t\t\t<td align=center> {$d['KDPSTTBKMK']}</td> \r\n  \t\t\t\t<td align=center>".$arrayjenjang[$d[KDJENTBKMK]]."</td> \r\n  \t\t\t\t\t<td align=center>{$d['KDKMKTBKMK']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAKMKTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSMKTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSTMTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSPRTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSLPTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SEMESTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>".$arraykelompokmk[$d[KDKELTBKMK]]."</td>\r\n \t\t\t\t\t<td align=center>".$arrayjeniskurikulum[$d[KDKURTBKMK]]."</td>\r\n \t\t\t\t\t<td align=center>".$arrayjenismk[$d[KDWPLTBKMK]]."</td>\r\n \t\t\t\t\t<td >{$d['NODOSTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>".$arrayjenjang[$d[JENJATBKMK]]."</td> \r\n  \t\t\t\t<td align=center>{$d['PRODITBKMK']}</td>\r\n \t\t\t\t<td align=center>".$arraystatuspt[$d[STKMKTBKMK]]."</td>\r\n \r\n \t\t\t\t\t<td align=center>{$d['SLBUSTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SAPPPTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['BHNAJTBKMK']}</td>\r\n \t\t\t\t\t<td align=center>{$d['DIKTTTBKMK']}</td>\r\n \t\t\t\t\t\r\n \r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "";
}
?>
