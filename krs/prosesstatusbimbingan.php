<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi2 == "Simpan Status" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Status Bimbingan", SIMPAN_DATA );
    }
    else if ( is_array( $datamahasiswa ) )
    {
        foreach ( $datamahasiswa as $k => $v )
        {
            $q = "REPLACE INTO statusbimbingan \r\n        (IDMAHASISWA,TAHUN,SEMESTER,STATUS,LASTUPDATE,UPDATER) \r\n        VALUES ('{$k}','{$tahun}','{$semester}','".$statusbimbingan[$k]."',NOW(),'{$users}')";
            mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
        }
        $errmesg = "Status bimbingan mahasiswa sudah disimpan";
    }
}
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND ID LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $tahun != "" )
{
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $sort == "" )
{
    $sort = "  ID  ";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT   ID,mahasiswa.NAMA  ,\r\n\tmahasiswa.ANGKATAN,statusbimbingan.STATUS ,LASTUPDATE,UPDATER\r\n\t \r\n\tFROM  mahasiswa LEFT JOIN statusbimbingan ON statusbimbingan.IDMAHASISWA=mahasiswa.ID\r\n\tAND statusbimbingan.TAHUN='{$tahun}'\r\n\tAND statusbimbingan.SEMESTER='{$semester}'\r\n\tWHERE  IDDOSEN='{$users}'\r\n\t \r\n\t{$qfield}\r\n\tORDER BY {$sort} ";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
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
												printmesg("Edit Status Bimbingan Mahasiswa");
		echo "						</div>";		
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Edit Status Bimbingan Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    /*else
    {
        printjudulmenucetak( "Edit Status Bimbingan Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #echo "\r\n \t\t<form method=post action=index.php>\r\n \t\t   <input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t   <input type=hidden name=aksi value='tampilkan'>\r\n \t\t   <input type=hidden name=sessid value='{$token}'>\r\n  \t\t   {$qinput}\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n  \t\t\t\t<td  align=right colspan=5>\r\n   \t\t   <input type=submit name=aksi2 value='Simpan Status'>\r\n          </td>\r\n \t\t\t</tr>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n  \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n \t\t\t\t<td>Nama Mahasiswa</td>\r\n \t\t\t\t<td>Angkatan</td>\r\n \t\t\t\t<td>Sudah Bimbingan</td>\r\n  \t\t\t</tr>\r\n\t\t";
    echo "						<form method=post action=index.php>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<input type=hidden name=sessid value='{$token}'>
									{$qinput}
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n  \t\t\t\t<td  align=right colspan=5>\r\n   \t\t   <input type=submit name=aksi2 value='Simpan Status' class=\"btn btn-brand\">\r\n          </td>\r\n \t\t\t</tr>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n  \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n \t\t\t\t<td>Nama Mahasiswa</td>\r\n \t\t\t\t<td>Angkatan</td>\r\n \t\t\t\t<td>Sudah Bimbingan</td>\r\n  \t\t\t</tr>\r\n\t\t";
    echo "											</thead>
													<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $cek = "";
        if ( $d[STATUS] == 1 )
        {
            $cek = "checked";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n    \t\t\t\t<td align=left>{$d['ID']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n   \t\t\t\t<td align=center nowrap>{$d['ANGKATAN']}</td>\r\n   \t\t\t\t<td align=center nowrap>\r\n           <input type=hidden name='datamahasiswa[{$d['ID']}]' value=1  >\r\n           <input type=checkbox name='statusbimbingan[{$d['ID']}]' value=1 {$cek} >\r\n           </td>\r\n  \t\t\t\t\t\r\n \t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "\r\n \r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n  \t\t\t\t<td  align=right colspan=5>\r\n \t\t   <input type=submit name=aksi2 value='Simpan Status' class=\"btn btn-brand\">\r\n          </td>\r\n \t\t\t</tr>";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</form>
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
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
