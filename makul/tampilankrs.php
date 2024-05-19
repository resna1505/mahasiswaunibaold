<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#printjudulmenu( "TAMPILAN KRS ONLINE MAHASISWA" );
if ( $aksi == "Simpan" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        foreach ( $tampilankrs as $k => $v )
        {
            $q = "UPDATE prodi SET TAMPILANKRS='{$v}' WHERE ID='{$k}'";
            mysqli_query($koneksi,$q);
        }
        $errmesg = "Data telah disimpan.";
    }
    else
    {
        $errmesg = token_err_mesg( "Tampilan KRS", SIMPAN_DATA );
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <br><br>
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class=\"portlet light\">
                                <div class=\"portlet-title\">
                                    <div class=\"caption font-green-haze\">
        <i class=\"icon-settings font-green-haze\"></i>
        <span class=\"caption-subject bold uppercase\"> TAMPILAN KRS ONLINE MAHASISWA </span>
                                </div>
                            <div class=\"actions\"><input type=submit name=aksi value='Simpan' class=\"btn blue\"></div>
                    </div>";*/
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Tampilan KRS Online Mahasiswa");
								echo	"</div>
									</div>";
														
echo "\r\n<form method=post action=index.php>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."
<div class='portlet-body form'>
									<table class=\"table table-striped table-bordered table-hover\">";
/*echo "<div class=\"portlet-body\">
                            <div class=\"table-scrollable\">
                                <table class=\"table table-striped table-bordered table-hover\">";*/

#echo "<table>\r\n  ";

#echo "<tr class=juduldata align=center>";

#echo "<th colspan=2 align=right><input type=submit name=aksi value='Simpan'></th>\r\n   </tr>\r\n  ";
#echo "<thead><tr class=juduldata align=center>\r\n    <th scope-col>Program Studi</th>\r\n    <th scope-col>Kurikurum yang Tampil</th>\r\n  </tr></thead>\r\n";
echo "<tr class=juduldata align=center>\r\n    <th scope-col>Program Studi</th>\r\n    <th scope-col>Kurikurum yang Tampil</th>\r\n  </tr>";

foreach ( $arrayprodidep as $k => $v )
{
    if ( $prodis == "" || $prodis == $k )
    {
        $q = "SELECT TAMPILANKRS FROM prodi WHERE ID='{$k}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $cek0 = $cek1 = "";
        if ( $d[TAMPILANKRS] == 0 )
        {
            $cek0 = "checked";
        }
        else if ( $d[TAMPILANKRS] == 1 )
        {
            $cek1 = "checked";
        }
        echo "\r\n      <tr>\r\n        <td>{$k} / {$v}</td>\r\n        <td>\r\n          <input type=radio name='tampilankrs[{$k}]' value=0 {$cek0} > Tampilkan Kurikulum Ganjil atau Genap saja. <br>\r\n          <input type=radio name='tampilankrs[{$k}]' value=1 {$cek1} > Tampilkan Semua Mata Kuliah Kurikulum\r\n        </td>\r\n      </tr>\r\n    \r\n    ";
    }
}
echo "<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t";
echo "								</table>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>";
/*echo "\r\n</table>\r\n</form></div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    </div>\r\n";*/
?>
