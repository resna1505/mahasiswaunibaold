<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM  mengandung kata  '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $tahuna != "" && $semestera != "" )
{
    $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
    $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
    $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
    $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
    $href .= "semestera={$semestera}&tahuna={$tahuna}&";
}
if ( $statusawal != "" )
{
    $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
    $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
    $href .= "statusawal={$statusawal}&";
    $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
}
if ( $status != "" )
{
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
    else
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
    }
}
include( "prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM  msmhs {$qtabel} ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT msmhs.* FROM msmhs {$qtabel} ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
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
        if ( $d[TGLLSMSMHS] == "0000-00-00" )
        {
            $d[TGLLSMSMHS] = "-";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=center nowrap>{$d['KDPTIMSMHS']}</td>\r\n\t\t\t\t\t<td align=center nowrap>{$d['KDPSTMSMHS']}</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t<td align=center nowrap>".$arrayjenjang[$d[KDJENMSMHS]]."</td>\r\n \t\t\t\t\t<td align=left nowrap> {$d['NIMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NMMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['TPLHRMSMHS']}, {$d['TGLHRMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['KDJEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TAHUNMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['SMAWLMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['BTSTUMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['ASSMAMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGMSKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLLSMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>".$arraystatusmahasiswa[$d[STMHSMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center nowrap>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['SKSDIMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['ASNIMMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['ASPTIMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>".$arrayjenjang[$d[ASJENMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['ASPSTMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['BISTUMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['PEKSBMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NMPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['PTPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['PSPEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NOPRMMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NOKP1MSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NOKP2MSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NOKP3MSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NOKP4MSMHS']}</td>\r\n \t\t\t\t\t  \r\n\t\t\t\t</tr>\r\n\t\t\t";
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
