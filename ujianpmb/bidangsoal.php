<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Data Bidang Soal" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $ket[$k] ) != "" )
            {
                $query = "UPDATE bidangsoalpmb SET \r\n\t\t\t\t\tNAMA='".$ket[$k]."'\r\n\t\t\t\t\tWHERE ID='{$k}'";
                $hasil = doquery($koneksi, $query);
                echo mysqli_error($koneksi);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Bidang Soal berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Bidang Soal tidak berhasil dilakukan.";
        }
    }
}
if ( $aksi == "Hapus" && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM bidangsoalpmb  WHERE ID='{$k}'";
        $hasil = doquery($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data Bidang Soal    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data Bidang Soal    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" )
{
    if ( trim( $id ) == "" )
    {
        $errmesg = "ID bidang soal harus diisi";
    }
    else if ( validasi_kode( $id, 20, false ) == false )
    {
        $errmesg = "ID bidang soal harus diisi tanpa spasi, hanya angka dan huruf saja";
    }
    else if ( trim( $ket ) == "" )
    {
        $errmesg = "Nama bidang soal harus diisi";
    }
    else
    {
        $query = "INSERT INTO bidangsoalpmb VALUES('{$id}','{$ket}' )";
        $hasil = doquery($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Bidang Soal      berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data Bidang Soal      gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
printjudulmenukecil( "Tambah Data Bidang Soal" );
echo "\t\t\t\t<form action=index.php?pilihan=bidangsoalpmb method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=bidangsoalpmb>\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tID bidang soal \r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=20  name=id>  \r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulf";
echo "orm>\r\n\t\t\t\t\t\t\t\tNama bidang soal \r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=masukan type=text size=50  name=ket>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \r\n\r\n";
$query = "SELECT ID,NAMA FROM bidangsoalpmb WHERE ID!='N' ORDER BY ID";
$hasil = doquery($koneksi,$query);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hasil ) )
{
    printjudulmenukecil( "Data  Bidang Soal" );
    echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=bidangsoalpmb>\r\n\t\t\t\t";
    echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t<td colspan=3>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Bidang Soal ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tID\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama  \r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap";
        }
        else
        {
            $kelas = "class=dataganjil";
        }
        $ket = $datauser[NAMA];
        $bidangsoalpmb = $datauser[ID];
        $gol = $datauser[GOL];
        $subgol = $datauser[SUBGOL];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$bidangsoalpmb}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t";
        if ( $bidangsoalpmb == "" )
        {
            echo "\r\n  \t\t\t\t\t\t\t <td align=center >\t\r\n  \t\t\t\t\t\t\t {$ket}\r\n  \t\t\t\t\t\t\t</td>\r\n  \r\n  \r\n  \t\t\t\t\t\t\t<td align=center >\r\n  \t\t\t\t\t\t\t -\r\n   \t\t\t\t\t\t\t</td>\r\n  \r\n  \t\t\t\t\t\t\t<td align=center >\r\n  \t\t\t\t\t\t\t -\r\n   \t\t\t\t\t\t\t</td>";
        }
        else
        {
            echo "\r\n                  <td align=center >\r\n    \t\t\t\t\t\t\t\t<input type=text name='ket[{$bidangsoalpmb}]' value='{$ket}' size=50  class=masukan>\r\n    \t\t\t\t\t\t\t</td>\r\n    \r\n    \r\n    \t\t\t\t\t\t\t<td align=center >\r\n    \t\t\t\t\t\t\t\t<input type=checkbox name='idupdate[{$bidangsoalpmb}]' value=1 class=tombol >\r\n    \t\t\t\t\t\t\t</td>\r\n    \r\n    \t\t\t\t\t\t\t<td align=center >\r\n    \t\t\t\t\t\t\t\t\t<input type=checkbox name='idhapus[{$bidangsoalpmb}]' value=1 class=tombol >\r\n    \t\t\t\t\t\t\t</td>";
        }
        echo "\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";
}
else
{
    printmesg( "Data Bidang Soal tidak ada." );
    $aksi = "";
}
echo "<br>\r\n";
?>
