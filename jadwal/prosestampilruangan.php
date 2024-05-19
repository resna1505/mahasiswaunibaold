<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$token = md5( uniqid( rand( ), true ) );
$_SESSION['token'] = $token;
if ( $aksi != "cetak" )
{
    printjudulmenu( "Data Ruangan" );
}
else
{
    printjudulmenucetak( "Data Ruangan" );
}
printmesg( $errmesg );
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM ruangan ORDER BY {$sort}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $href = "index.php?pilihan={$pilihan}&{$aksi}={$aksi}&";
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
    if ( $aksi != "cetak" )
    {
        printmesg( "Data Ruangan" );
        printmesg( $errmesg );
		echo "						<div class=\"tools\">
										<form action=index.php method=post target=_blank action='cetakruangan.php'>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t
													</td>
												</tr>
											</table>											
										</form>
									</div>{$tpage} {$tpage2}";
        #echo "\r\n\t\t\t\t<table>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakruangan.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Ruangan </span>
                            </div>
                            <div class=\"actions\"><form target=_blank action='cetakruangan.php'>
                            <input type=submit name=aksi class=\"btn green\" value='Cetak'></form>
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
    echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=ID'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=NAMA'>Nama</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=KET'>Keterangan</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "												</tr> 
													</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td>{$d['ID']}</td>\r\n\t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>{$d['KET']}</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Ruangan Dengan Kode = {$d['ID']} ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
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
}
else
{
    $errmesg = "Data Ruangan Tidak Ada";
    printmesg( $errmesg );
}
?>
