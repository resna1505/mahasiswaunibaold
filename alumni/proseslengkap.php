<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT ID FROM alumni WHERE ID='{$id}'";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO ALUMNI (ID) VALUES('{$id}')";
    mysqli_query($koneksi,$q);
}
$q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS,alumni.* \r\n\tFROM mahasiswa,prodi,alumni WHERE \r\n\tmahasiswa.ID='{$id}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\tAND alumni.ID=mahasiswa.ID\r\n\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Rincian Data Alumni" );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Rincian Data Alumni" );
        printmesgcetak( $errmesg );
    }
    $d = sqlfetcharray( $h );
    $ipkuap = $d[IPKUAP];
    $jenis = $d[JENIS];
    $tmp = explode( "-", $d[TANGGAL] );
    $d[thn] = $tmp[0];
    $d[tgl] = $tmp[2];
    $d[bln] = $tmp[1];
    $tmp = explode( "-", $d[TANGGALMASUKINSTANSI] );
    $d2[thn] = $tmp[0];
    $d2[tgl] = $tmp[2];
    $d2[bln] = $tmp[1];
    $tmp = explode( " ", $d[PROSESMASUKKERJA] );
    if ( is_array( $tmp ) )
    {
        foreach ( $tmp as $k => $v )
        {
            $arraykerja[$v] = 1;
        }
    }
    if ( $aksi != "cetak" )
    {
        #echo "\r\n\t\t\t\t<table class=form{$cetak}>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklengkap.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=hidden name=id value='{$id}'>\r\n \t\t\t\t \r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    if ( file_exists( "../mahasiswa/foto/{$d['ID']}" ) )
    {
        $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='../mahasiswa/foto/{$d['ID']}' border=0 width=200><br>\r\n\t\t\t";
    }

    #echo "\r\n \t\t<table class=form{$cetak}>"."<tr valign=top>\r\n\t\t\t<td class=judulform{$cetak}>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n\t\t\t<td rowspan=15 align=left>{$fotosaatini}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>{$d['ANGKATAN']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Wali</td>\r\n\t\t\t<td>".$arraydosendep[$d[IDDOSEN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>NIM Alumni</td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>Nama Alumni</td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>{$d['ALAMAT']}</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>{$d['TEMPAT']} / {$d['tgl']} ".$arraybulan[$d[bln] - 1]." {$d['thn']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>{$d['TELEPON']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>{$d['ASAL']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Status</td>\r\n\t\t\t<td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>{$d['TA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".str_replace( "\n", "<br>", $d[DOSENTA] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2>&nbsp;</td>\r\n\t\t</tr>\r\n\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><b>Penempatan Kerja</td>\r\n\t\t</tr>\r\n\t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Nama Perusahaan</td>\r\n\t\t\t<td>{$d['INSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Alamat Perusahaan</td>\r\n\t\t\t<td>".nl2br( $d[ALAMATINSTANSI] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Telepon Perusahaan</td>\r\n\t\t\t<td>{$d['TELEPONINSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jabatan di Perusahaan</td>\r\n\t\t\t<td>{$d['JABATAN']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Masuk</td>\r\n\t\t\t<td>".$arraybulan[$d2[bln] - 1]." {$d2['thn']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status/bentuk Perusahaan</td>\r\n\t\t\t<td>{$d['STATUSINSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Berapa lama<br>dapat pekerjaan<br>semenjak lulus</td>\r\n\t\t\t<td>{$d['TAHUNLAMA']} tahun {$d['BULANLAMA']} bulan</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Gaji Pertama</td>\r\n\t\t\t<td>Rp. ".cetakuang( $d[GAJI] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2>&nbsp;</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><b>Proses Penempatan Kerja</td>\r\n\t\t</tr>\r\n\t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Masuk kerja melalui</td>\r\n\t\t\t<td> ";
    echo "	<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
    echo "				<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
							<div class='portlet box blue'>
								<div class='portlet-title'>
									<div class='caption'>";
										printmesg("Rincian Data Alumni");
	echo"							</div>
								</div>
								<div class='portlet-body form'>
									<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr valign=top>\r\n\t\t\t
													<td class=judulform{$cetak}>Foto</td>\r\n\t\t\t
													<td align=left>{$fotosaatini}</td>\r\n\t\t
												</tr>
												<tr valign=top>\r\n\t\t\t
													<td class=judulform{$cetak}>Jurusan/Program Studi</td>\r\n\t\t\t
													<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n\t\t\t
												</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>{$d['ANGKATAN']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Wali</td>\r\n\t\t\t<td>".$arraydosendep[$d[IDDOSEN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>NIM Alumni</td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>Nama Alumni</td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>{$d['ALAMAT']}</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>{$d['TEMPAT']} / {$d['tgl']} ".$arraybulan[$d[bln] - 1]." {$d['thn']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>{$d['TELEPON']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>{$d['ASAL']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Status</td>\r\n\t\t\t<td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>{$d['TA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".str_replace( "\n", "<br>", $d[DOSENTA] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2>&nbsp;</td>\r\n\t\t</tr>\r\n\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><b>Penempatan Kerja</td>\r\n\t\t</tr>\r\n\t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Nama Perusahaan</td>\r\n\t\t\t<td>{$d['INSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Alamat Perusahaan</td>\r\n\t\t\t<td>".nl2br( $d[ALAMATINSTANSI] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Telepon Perusahaan</td>\r\n\t\t\t<td>{$d['TELEPONINSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jabatan di Perusahaan</td>\r\n\t\t\t<td>{$d['JABATAN']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Masuk</td>\r\n\t\t\t<td>".$arraybulan[$d2[bln] - 1]." {$d2['thn']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status/bentuk Perusahaan</td>\r\n\t\t\t<td>{$d['STATUSINSTANSI']}</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Berapa lama<br>dapat pekerjaan<br>semenjak lulus</td>\r\n\t\t\t<td>{$d['TAHUNLAMA']} tahun {$d['BULANLAMA']} bulan</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Gaji Pertama</td>\r\n\t\t\t<td>Rp. ".cetakuang( $d[GAJI] )."</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2>&nbsp;</td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><b>Proses Penempatan Kerja</td>\r\n\t\t</tr>\r\n\t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Masuk kerja melalui</td>\r\n\t\t\t<td> ";
	foreach ( $arraymasukkerja as $k => $v )
    {
        if ( $arraykerja[$k] == 1 )
        {
            echo "\r\n\t\t\t\t\t\t- {$v} <br>\r\n\t\t\t\t\t";
        }
    }
    echo "\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
	#echo "\r\n\r\n\t\t\t</table>\r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t<br style='page-break-after:always'>\r\n\t\t\t\r\n\t\t";
	echo "</table></div></div>";
}
else
{
    $errmesg = "Data Alumni dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
