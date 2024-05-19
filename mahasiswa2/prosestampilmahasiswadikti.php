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
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
$qfield .= " AND ANGKATAN='{$angkatan}'";
$qjudul .= " Angkatan '{$angkatan}' <br>";
$qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
$href .= "angkatan={$angkatan}&";
if ( $id != "" )
{
    $qfield .= " AND ID LIKE '{$id}'";
    $qjudul .= " NIM mengandung kata '%{$id}%' <br>";
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
if ( $status != "" )
{
    $qfield .= " AND STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa ,,msmhs\r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT * FROM mahasiswa ,msmhs\r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Mahasiswa" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t<td>Kode PS</td>\r\n\t\t\t\t<td>Jenjang</td>\r\n\t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>TTL</td>\r\n        <td>Jenis Kelamin</td>\r\n        <td>Tahun Masuk</td> \r\n        <td>Semester Awal Terdaftar</td>\r\n        <td>Batas Studi</td>  \r\n        <td>Kode Propinsi Asal</td> \r\n        <td>Tanggal Masuk</td>\r\n        <td>Tanggal Lulus</td> \r\n        <td>Status Aktifitas</td> \r\n        <td>Status Awal</td>\r\n        <td>Jumlah SKS Diakui</td>\r\n        <td>NIM Asal<br>(Pindahan)</td>\r\n        <td>Kode PT Asal<br>(Pindahan)</td>\r\n        <td>Jenjang Studi Asal<br>(Pindahan)</td>\r\n        <td>Kode PS Asal<br>(Pindahan)</td>\r\n        <td>Kode Biaya Studi</td>\r\n        <td>Kode Pekerjaan</td>\r\n        <td>Nama Tempat Kerja<br>(Bukan Dosen)</td>\r\n        <td>Kode PT Tempat Kerja<br>(Dosen)</td>\r\n        <td>Kode PS Tempat Kerja<br>(Dosen)</td>\r\n        <td>NIDN<br>Promotor</td>\r\n        <td>NIDN<br>KO-Promotor #1</td>\r\n        <td>NIDN<br>KO-Promotor #2</td>\r\n        <td>NIDN<br>KO-Promotor #3</td>\r\n        <td>NIDN<br>KO-Promotor #4</td>\r\n        \r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=center>{$d['KDPTIMSMHS']}</td>\r\n\t\t\t\t\t<td align=center>{$d['KDPSTMSMHS']}</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t<td align=center>".$arrayjenjang[$d[KDJENMSMHS]]."</td>\r\n \t\t\t\t\t<td align=left> {$d['NIMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NMMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=left>{$d['TPLHRMSMHS']}, {$d['TGLHRMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['KDJEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUNMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SMAWLMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['BTSTUMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['ASSMAMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TGMSKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TGLLSMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>".$arraystatusmahasiswa[$d[STMHSMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSDIMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['ASNIMMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['ASPTIMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>".$arrayjenjang[$d[ASJENMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ASPSTMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['BISTUMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['PEKSBMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NMPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['PTPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['PSPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NOPRMMSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NOKP1MSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NOKP2MSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NOKP3MSMHS']}</td>\r\n \t\t\t\t\t<td align=center>{$d['NOKP4MSMHS']}</td>\r\n \t\t\t\t\t  \r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
