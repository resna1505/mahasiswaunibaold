<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    echo $q;
	$h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        if ( file_exists( "../mahasiswa/foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='../mahasiswa/foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        echo "<br>
			<table class=form border='0'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."
			<tr class=judulform>\r\n\t\t\t<td width=250>Jurusan/Program Studi</td><td>".$arrayprodidep[$d[IDPRODI]]."</td></tr>
			<tr><td>Angkatan</td><td>{$d['ANGKATAN']}</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Dosen Wali </td>\r\n\t\t\t<td>".$arraydosendep[$d[IDDOSEN]]."</td></tr>
			<tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa</td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td></tr>
			<tr class=judulform>\r\n\t\t\t<td>Foto</td>\r\n\t\t\t<td>\r\n\t\t\t{$fotosaatini}\r\n\t\t\t \r\n\t\t\t</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."</td>\r\n\t\t</tr>
			<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td> {$d['TEMPAT']}  /  {$d['tgl']}-{$d['bln']}-{$d['thn']} </td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>{$d['TELEPON']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>{$d['ASAL']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas Default Pengambilan Mata Kuliah</td>\r\n\t\t\t<td>{$d['KELAS']}</td>\r\n\t\t</tr> \r\n \t\t<tr >\r\n\t\t\t<td>Tanggal Masuk</td>\r\n\t\t\t<td>{$dtm['tgl']}-{$dtm['bln']}-{$dtm['thn']}</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>{$dtk['tgl']}-{$dtk['bln']}-{$dtk['thn']}</td>\r\n\t\t</tr>"."\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Kuliah</td>\r\n\t\t\t<td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>".nl2br( $d[TA] )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".nl2br( $d[DOSENTA] )."</td>\r\n\t\t</tr>";
        include( "mahasiswa2.php" );
        echo "\r\n \r\n\t\t\t</table>\r\n \r\n \r\n\t\t";
    }
}
?>
