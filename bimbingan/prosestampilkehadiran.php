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
if ( $jenisusers == 1 )
{
    $iddosen = $users;
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
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
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
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
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
include( "prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs \r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT mahasiswa.ID,mahasiswa.NAMA \r\n  FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs\r\n\tWHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=ID'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=NAMA'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=NAMA'>Tanda Tangan</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td  > </td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
