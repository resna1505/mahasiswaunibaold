<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.indexborder {\r\n\tborder-top:1px solid #166897;\r\n\tborder-left:1px solid #166897;\r\n\tposition:relative;\r\n\tleft:-7px;\r\n\t}\r\n\t\r\n.indexborder td {\r\n\tborder-right:1px solid #166897;\r\n\tborder-bottom:1px solid #166897;\r\n\tbackground-color:#afdcf6;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n</style>\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "jadwalkuliahsp.IDMAKUL";
$arraysort[1] = "jadwalkuliahsp.KELAS";
$arraysort[2] = "jadwalkuliahsp.IDRUANGAN";
$arraysort[3] = "jadwalkuliahsp.HARI";
$arraysort[4] = "jadwalkuliahsp.MULAI";
$arraysort[5] = "jadwalkuliahsp.SELESAI";
$arraysort[6] = "jadwalkuliahsp.RENCANA";
$arraysort[7] = "jadwalkuliahsp.TIM";
$arraysort[8] = "jadwalkuliahsp.IDPRODI";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSIOn['token'] = $token;
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&sessid={$token}&asal={$asal}&";
if ( $jenisusers == 1 && $caridosen == 1 )
{
    $qfield .= " AND jadwalkuliahsp.TIM LIKE '%{$users}%'";
    $qjudul .= " NIDN Dosen  {$users} <br>";
    $qinput .= " <input type=hidden name=caridosen value='{$caridosen}'>";
    $href .= "caridosen={$caridosen}&";
}
if ( $semester != "" )
{
    $qfield .= " AND jadwalkuliahsp.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."  <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND jadwalkuliahsp.TAHUN='{$tahun}'";
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}  <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" )
{
    $qfield .= " AND jadwalkuliahsp.IDPRODI='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $makul != "" )
{
    $qfield .= " AND IDMAKUL = '{$makul}'";
    $qjudul .= " ID MAKUL = {$makul} (".getnamafromtabel( $makul, "makul" ).") <br>";
    $qinput .= " <input type=hidden name=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}
if ( $kelasjadwal != "" )
{
    $qfield .= " AND KELAS = '{$kelasjadwal}'";
    $qjudul .= " Kelas = '".$arraylabelkelas[$kelasjadwal]."' <br>";
    $qinput .= " <input type=hidden name=kelasjadwal value='{$kelasjadwal}'>";
    $href .= "kelasjadwal={$kelasjadwal}&";
}
if ( $hari != "" )
{
    $qfield .= " AND HARI='{$hari}'";
    $qjudul .= " Hari '".$arrayhari[$hari]."' <br>";
    $qinput .= " <input type=hidden name=hari value='{$hari}'>";
    $href .= "hari={$hari}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT jadwalkuliahsp.* \r\n   FROM jadwalkuliahsp \r\n\t WHERE 1=1  \r\n\t {$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Jadwal Kuliah SP" );
        printmesg( $errmesg );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Jadwal Kuliah SP" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">";
    if ( $aksi != "cetak" && $_SESSION['asal'] != "depan" )
    {
		printmesg( "Data Jadwal Kuliah SP" );
        printmesg( $errmesg );
        printmesg( $qjudul );
        #echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakjadwal.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=checkbox name=pilihcetak value=1 > Dikelompokkan berdasarkan \r\n \t\t\t\t<select name=jeniscetak >\r\n \t\t\t\t";
        echo "						<div class=\"tools\">
										<form target=_blank action='cetakjadwal.php'>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=tombol value='Cetak'>
														{$qinput}\n \t\t\t\t{$input}
													</td>
												</tr>
											</table>
											</div>
										</form>
									</div>{$tpage} {$tpage2}";
		/*foreach ( $arraykelompokcetak as $k => $v )
        {
            echo "<option value={$k} >{$v}</option>";
        }
        echo "\r\n \t\t\t\t</select>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n \t\t\t \r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";*/
    }
    #echo "\r\n \t\t\t<table   cellpadding=0 cellspacing=0 width=300px>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode MK</td>\r\n\t\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Ruangan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Hari</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Jam Mulai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jam Selesai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Rencana<br>Tatap<br>Muka</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Tim<br>Pengajar</td>\r\n\t\t\t ";
    echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode MK</td>\r\n\t\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Ruangan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Hari</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Jam Mulai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jam Selesai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Rencana<br>Tatap<br>Muka</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Tim<br>Pengajar</td>";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=3  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "												</tr> 
													</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "\n", $d[TIM] );
        $timpengajar = "";
        foreach ( $tmp as $k => $v )
        {
            $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
        }
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t \r\n  \t\t\t\t\t<td align=left> ".$arrayprodidep[$d[IDPRODI]]."</td>\r\n  \t\t\t\t\t<td align=left> {$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left  >".getnamafromtabel( $d[IDMAKUL], "makul" )."</td>\r\n  \t\t\t\t\t<td > ".$arraylabelkelas[$d[KELAS]]."</td>\r\n \t\t\t\t\t<td nowrap>".$arrayruangan[$d[IDRUANGAN]]."</td>\r\n \t\t\t\t\t<td nowrap>".$arrayhari[$d[HARI]]."</td>\r\n  \t\t\t\t\t<td > {$d['MULAI']}</td>\r\n  \t\t\t\t\t<td > {$d['SELESAI']}</td>\r\n  \t\t\t\t\t<td > {$d['RENCANA']}</td>\r\n  \t\t\t\t\t<td align=left> {$timpengajar}</td>\r\n \t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Jadwal Kuliah SP  ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i></td><!--<td   align=center><a alt='Klik di sini untuk menentukan tanggal-tanggal kuliah berdasarkan Jadwal Kuliah SP untuk kepentingan absensi' href='index.php?pilihan=detiljadwal&idupdate={$d['ID']}'>Detil Tanggal Jadwal</td>-->";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>";
	echo "								</tbody>
									</table>
								</div>
						</div>
					</div>
					<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Jadwal Kuliah SP Tidak Ada";
    $aksi = "";
}
?>
