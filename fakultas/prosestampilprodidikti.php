<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arraysort[0] = "prodi.IDDEPARTEMEN";
$arraysort[1] = "prodi.NAMA";
$arraysort[2] = "prodi.TINGKAT";
$arraysort[3] = "prodi.JENIS";
$arraysort[4] = "mspst.KDPSTMSPST";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $iddepartemen != "" )
{
    $qfield .= " AND IDDEPARTEMEN='{$iddepartemen}'";
    $qjudul .= " Kode Jurusan '{$iddepartemen}' / ".$arraydepfak[$iddepartemen]."";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $namaprodi != "" )
{
    $qfield .= " AND NAMA LIKE '%{$namaprodi}%'";
    $qjudul .= " Nama Program Studi '{$namaprodi}'";
    $qinput .= " <input type=hidden name=namaprodi value='{$namaprodi}'>";
    $href .= "namaprodi={$namaprodi}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 4;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM mspst,prodi \r\n\tWHERE mspst.IDX=prodi.ID AND !(IDX >=9000 AND IDX <=9999)\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = doquery($koneksi, $q );
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Program Studi" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Program Studi" );
        printmesgcetak( $qjudul );
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>Kode PT</td>\r\n \t\t\t\t<td>Kode {$JUDULFAKULTAS}</td>\r\n \t\t\t\t<td>Jenjang</td>\r\n\t\t\t\t<td>Kode P.S.</td>\r\n\t\t\t\t<td>Nama P.S.</td>\r\n\t\t\t\t<td>Tgl Berdiri</td>\r\n\t\t\t\t<td>Sem. Awal Mulai Lapor</td>\r\n\t\t\t\t<td>Status</td>\r\n\t\t\t\t<td>Mulai Semester</td>\r\n\t\t\t\t<td>SKS Minimum</td>\r\n\t\t\t\t<td>Email</td>\r\n\t\t\t\t<td>No. SK</td>\r\n\t\t\t\t<td>Tgl Awal SK</td>\r\n\t\t\t\t<td>Tgl Akhir SK</td>\r\n\t\t\t\t<td>No. Akreditasi</td>\r\n\t\t\t\t<td>Tgl Awal Akreditasi</td>\r\n\t\t\t\t<td>Tgl Akhir Akreditasi</td>\r\n\t\t\t\t<td>Status Akreditasi</td>\r\n\t\t\t\t<td>Frekuensi Pemutakhiran Kurikulum</td>\r\n\t\t\t\t<td>Pelaksanaan Pemutakhiran Kurikulum</td>\r\n\t\t\t\t<td>NIDN Ketua P.S.</td>\r\n\t\t\t\t<td>Telepon Ketua P.S.</td>\r\n\t\t\t\t<td>Telepon P.S.</td>\r\n\t\t\t\t<td>Fax P.S.</td>\r\n\t\t\t\t<td>Nama Operator</td>\r\n\t\t\t\t<td>Telepon Operator</td>\r\n\t\t\t\t\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=center>{$d['KDPTIMSPST']}</td>\r\n  \t\t\t\t\t<td align=center>{$d['KDFAKMSPST']}</td>\r\n  \t\t\t\t\t<td align=center>".$arrayjenjang[$d[KDJENMSPST]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['KDPSTMSPST']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NMPSTMSPST']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGAWLMSPST']}</td>\r\n  \t\t\t\t<td align=center nowrap>{$d['SMAWLMSPST']}</td>\r\n  \t\t\t\t\t<td align=center>".$arraystatuspt[$d[STATUMSPST]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['MLSEMMSPST']}</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSTTMSPST']}</td>\r\n \t\t\t\t\t<td align=center>{$d['EMAILMSPST']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NOMSKMSPST']}</td> \r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLSKMSPST']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLAKMSPST']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NOMBAMSPST']}</td> \r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLBAMSPST']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLABMSPST']}</td>\r\n \t\t\t\t\t<td align=center>".$arrayakreditasipt[$d[KDSTAMSPST]]."</td>\r\n \t\t\t\t\t<td align=center>".$arrayfpk[$d[KDFREMSPST]]."</td>\r\n \t\t\t\t\t<td align=center>".$arrayppk[$d[KDPELMSPST]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['NOKPSMSPST']}</td> \r\n \t\t\t\t\t<td align=left>{$d['TELPSMSPST']}</td> \r\n \t\t\t\t\t<td align=left>{$d['TELPOMSPST']}</td> \r\n \t\t\t\t\t<td align=left>{$d['FAKSIMSPST']}</td> \r\n \t\t\t\t\t<td align=left>{$d['NMOPRMSPST']}</td> \r\n \t\t\t\t\t<td align=left>{$d['TELPRMSPST']}</td> \r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Program Studi Tidak Ada";
    $aksi = "";
}
?>
