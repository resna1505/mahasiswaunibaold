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
if ( $jenisusers == 1 )
{
    $qfield .= " AND DOSENTA REGEXP  '[[:<:]]".$users."[[:>:]]' ";
}
if ( $iddosen != "" )
{
    $qfield .= " AND DOSENTA LIKE '%{$iddosen}%'";
    $qjudul .= " Dosen Pembimbing TA '".$arraydosen[$iddosen]."' <br>";
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
    $qfield .= " AND ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
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
$q = "SELECT COUNT(*) AS JML FROM mahasiswa \r\n\tWHERE 1=1 {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT * FROM mahasiswa \r\n\tWHERE 1=1 {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
	echo "							<div class=\"caption\">";
												printmesg("Data Mahasiswa");
	echo "						</div>";	
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Mahasiswa" );
        printmesg( $qjudul );
    }
    /*else
    {
        printjudulmenucetak( "Data Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
    if ( $aksi != "cetak" )
    {
		echo " {$tpage} {$tpage2}";
        /*echo " 
				<form target=_blank action='cetakmahasiswa.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>";
        if ( $jenisusers == 0 )
        {
            echo "\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Lengkap'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Data Dikti'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Form Kehadiran'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Kartu'>";
        }
        #echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
		echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>";*/
    }
    #echo "\r\n \t\t\t<table {$border} class=for{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDPRODI'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ANGKATAN'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=NAMA'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=STATUS'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDDOSEN'>Dosen Wali</td>";
    echo "
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDPRODI'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ANGKATAN'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=NAMA'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=STATUS'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDDOSEN'>Dosen Wali</td>";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "											</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>Update</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Mahasiswa Dengan NIM = {$d['ID']} ? Seluruh data mata kuliah yang diambil dan nilainya juga akan dihapus');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}'>Hapus</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>";
	echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								<!--end::Section-->
								</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Bimbingan TA Tidak Ada";
    $aksi = "";
}
?>
