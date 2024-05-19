<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
if ( $aksitambah == "Hapus" && is_array( $data ) )
{
    $jmlaf = 0;
    foreach ( $data as $k => $v )
    {
        if ( $v[hapus] == 1 )
        {
            $q = "\r\n\t\t\t\t\t\tDELETE FROM konversipredikat \r\n\t\t\t\t\t\tWHERE\r\n \t\t\t\t\t\tID='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$jmlaf;
            }
        }
    }
    if ( 0 < $jmlaf )
    {
        $errmesg = "Data Predikat Kelulusan berhasil dihapus";
    }
    else
    {
        $errmesg = "Data Predikat Kelulusan tidak dihapus";
    }
}
if ( $aksitambah == "Update" && is_array( $data ) )
{
    $jmlaf = 0;
    foreach ( $data as $k => $v )
    {
        if ( $v[update] == 1 )
        {
            $q = "\r\n\t\t\t\t\t\tUPDATE konversipredikat \r\n\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\tNAMA='{$v['nama']}',\r\n\t\t\t\t\t\t\tSYARAT='{$v['syarat']}',\r\n\t\t\t\t\t\t\tSYARATW='{$v['syaratw']}'\r\n \t\t\t\t\t\tWHERE\r\n \t\t\t\t\t\tID='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$jmlaf;
            }
        }
    }
    if ( 0 < $jmlaf )
    {
        $errmesg = "Data Predikat Kelulusan berhasil diupdate";
    }
    else
    {
        $errmesg = "Data Predikat Kelulusan tidak diupdate";
    }
}
if ( $aksi == "tambah" )
{
    if ( trim( $nama ) == "" )
    {
        $errmesg = "Nama Predikat Kelulusan harus diisi (contoh: Cum Laude)";
    }
    else if ( trim( $data[syarat] ) == "" || $data[syarat] < 0 )
    {
        $errmesg = "Syarat Predikat Kelulusan harus diisi >= 0";
    }
    else
    {
        $idbaru = getnewidsyarat( "ID", "konversipredikat", "" );
        $q = "\r\n\t\t\t\tINSERT INTO konversipredikat (ID,NAMA,SYARAT,SYARATW) \r\n\t\t\t\tVALUES ('{$idbaru}','{$nama}','{$data['syarat']}','{$data['syaratw']}')\r\n\t\t\t";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Predikat Kelulusan berhasil ditambah";
            $data = "";
            $nama = "";
        }
        else
        {
            $errmesg = "Data Predikat Kelulusan  tidak berhasil ditambah";
        }
    }
}
printjudulmenu( "Edit Predikat Kelulusan" );
printmesg( $errmesg );
echo "\r\n\t\t\t<form name=form action=index.php method=post>".createinputhidden( "aksi", "tambah", "" ).createinputhidden( "pilihan", $pilihan, "" );
printjudulmenukecil( "Data Predikat Kelulusan Baru" );
echo "\r\n\t\t\t<table class=form>\r\n\t \t\t <tr class=judulform>\r\n\t\t\t\t<td class=judulform>Nama</td>\r\n\t\t\t\t<td>".createinputtext( "nama", "{$nama}", "size=40 class=masukan" )."</td>\r\n\t\t\t</tr>"."<tr class=judulform>\r\n\t\t\t\t<td>Syarat</td>\r\n\t\t\t\t<td> \r\n\t\t\t\tIPK >= ".createinputtext( "data[syarat]", "{$data['syarat']}", "size=4 class=masukan" )." \r\n\t\t\t\tdan \r\n\t\t\t\tMasa Belajar <= ".createinputtext( "data[syaratw]", "{$data['syaratw']}", "size=4 class=masukan" )." tahun\r\n\r\n\t\t\t\t</td>\r\n\t\t\t</tr>"."\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t\t\t<script>\r\n\t\t\t\tform.nama.focus();\r\n\t\t\t</script>\r\n\t \t\t";
printjudulmenukecil( "Rincian Predikat Kelulusan" );
$q = "\r\n\t\t\t\tSELECT ID,NAMA,SYARAT,SYARATW FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW ASC\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n\t\t\t<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" )."<table class=data>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t<td ><input type=submit name=aksitambah value='Update' class=masukan></td>\r\n\t\t\t\t\t\t<td ><input type=submit name=aksitambah value='Hapus' class=masukan\r\n\t\t\t\t\t\tonClick=\"return confirm('Hapus Data Predikat Kelulusan?')\"\r\n\t\t\t\t\t\t></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n \t\t\t\t\t\t<td>Syarat</td>\r\n\t\t\t\t\t\t<td >Pilih Update</td>\r\n\t\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['ID']}][nama]", "{$d['NAMA']}", " class=masukan size=30" )."</td>\r\n \t\t\t\t\t\t\t<td  nowrap>\r\n \t\t\t\t\t\t\tIPK >= ".createinputtext( "data[{$d['ID']}][syarat]", "{$d['SYARAT']}", " class=masukan size=4" )."\r\n \t\t\t\t\t\t\tdan\r\n \t\t\t\t\t\t\tMasa Belajar <= ".createinputtext( "data[{$d['ID']}][syaratw]", "{$d['SYARATW']}", " class=masukan size=4" )."\r\n \t\t\t\t\t\t\ttahun\r\n \t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['ID']}][update]", "1", "", "", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['ID']}][hapus]", "1", "", "", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobot += $d[SYARAT];
        ++$i;
    }
    echo "</table>\r\n\t\t\t\t<br><br>";
}
else
{
    $errmesg = "Predikat Kelulusan belum ada";
    printmesg( $errmesg );
}
?>
