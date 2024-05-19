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
    $qjudul .= " Program Studi / Program Pendidikan '".$arrayprodidep[$idprodi]."' <br>";
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
if ( $angkatan != "" )
{
    $qfield .= " AND ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
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
$q = "SELECT * FROM mahasiswa \r\n\tWHERE 1=1\r\n\t{$qfield}\r\n\tORDER BY {$sort}";
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
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>Alamat</td>\r\n\t\t\t\t<td>TTL</td>\r\n\t\t\t\t<td>Kelamin</td>\r\n\t\t\t\t<td>Agama</td>\r\n\t\t\t\t<td>Telepon</td>\r\n\t\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t\t<td>Status</td>\r\n\t\t\t\t<td>Dosen Wali</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td nowrap align=left>{$d['NAMA']}</td>\r\n\t\t\t\t\t<td nowrap align=left>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td  >{$d['ANGKATAN']}</td>\r\n\t \t\t\t\t<td align=left>{$d['ALAMAT']}</td>\r\n\t\t\t\t\t<td align=left>{$d['TEMPAT']}</td>\r\n\t\t\t\t\t<td>{$d['KELAMIN']}</td>\r\n\t\t\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t\t\t\t<td align=left>{$d['TELEPON']}</td>\r\n\t\t\t\t\t<td align=left>{$d['ASAL']}</td>\r\n\t\t\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>Update</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Mahasiswa Dengan NIM = {$d['ID']} ? Seluruh data mata kuliah yang diambil dan nilainya juga akan dihapus');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}'>Hapus</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
