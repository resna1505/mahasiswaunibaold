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
#printjudulmenu( "Label Kelas" );
if ( $aksi == "Simpan" )
{
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = "Sesi login Anda telah berubah.<br>Ulangi proses.";
    }
    else if ( is_array( $pilih ) )
    {
        foreach ( $pilih as $k => $v )
        {
            $q = "UPDATE labelkelas \r\n        SET \r\n        NAMA='".$kelas[$k]."'\r\n        WHERE ID='{$k}'";
            doquery($koneksi,$q);
        }
        $errmesg = "Data Label Kelas berhasil disimpan";
    }
}
printmesg( $errmesg );
/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Label Kelas</span>
                            </div>
                            <div class=\"tools\">";

echo "\r\n<form method=post action=index.php>\r\n  <input type=submit name=aksi value=Simpan class=\"btn green\"><input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n ".IKONTOOLS48."\r\n";  


echo"</form>
                            </div>
                        </div>
                        <div class=\"portlet-body\"><div class=\"table-scrollable\"><table class=\"table table-striped2 table-bordered table-hover\">";

#echo "\r\n    <tr class=juduldata  align=center>\r\n      <td></td>\r\n      <td></td>\r\n      <td></td>\r\n      <td><input type=submit name=aksi value='Simpan'> </td>\r\n    </tr>           \r\n \r\n          \r\n\r\n    <tr class=juduldata align=center>\r\n";      

echo "<thead>
                            <tr>
                                <th scope=\"col\">No</th>
                                <th scope=\"col\">Kode Kelas</th>
                                <th scope=\"col\">Label Kelas</th>
                                <th scope=\"col\">Aksi</th></tr></thead>";*/

#echo "<td>No</td>\r\n      <td>Kode Kelas</td>\r\n      <td>Label Kelas</td>\r\n      <td>Aksi</td>\r\n    </tr>\r\n ";

/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Scroller</span>
                            </div>
                            <div class=\"tools\">
                                <form action='index.php' method=post>

            <input type=hidden name=pilihan value='{$pilihan}'>
            <input type=hidden name=sessid value='{$_SESSION['token']}'>

            <input type=submit name=aksi value='Simpan' class=\"btn blue\">

                                </form>
                            </div>
                        </div>
                        <div class=\"portlet-body\">
                            <table class=\"table table-striped table-hover\" id=\"sample_5\">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kelas</th>
                                <th>Label Kelas</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>";*/
echo "<form method=post action=index.php>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>";							
echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"tools\">
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"></input>
													</td>
												</tr>
											</table>
									</div>{$tpage} {$tpage2}";
									
										printtitle("Data Label Kelas");
echo "								</div>
									<div class=\"m-portlet\">
									
									
									<div class=\"m-section__content\">
										<div class=\"table-responsive\">
											<table class=\"table table-bordered table-hover table-striped2\">
												<thead>
													<tr>
													<th align=\"center\">No</th>
													<th>Kode Kelas</th>
													<th>Label Kelas</th>
													<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													";
										
$q = "SELECT * FROM labelkelas ";
$h = doquery($koneksi,$q);
if(0 < sqlnumrows( $h )){
	while ( $d = sqlfetcharray( $h ) ) 
	{
		$arraylabelkelas[$d[ID]] = $d[NAMA];
	}
}
$i = 1;
while ( $i <= 99 )
{
    $kodekelas = addnol( $i, 2 );
    echo "<tr class=datagenap align=center>
            <td>{$i}</td>
            <td>{$kodekelas} </td>
            <td><input type=text name='kelas[{$kodekelas}]' size=20  value='".$arraylabelkelas[$kodekelas]."'></td>
            <td><input type=checkbox name=pilih[{$kodekelas}] value=1></td>
        </tr>";
    ++$i;
}
#echo "\r\n    <tr class=datagenap align=center>\r\n      <td></td>\r\n      <td></td>\r\n      <td></td>\r\n      <td><input type=submit name=aksi value='Simpan'> </td>\r\n    </tr>      \r\n      ";
echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
echo "</form>";
/*echo "</div>
        </div>
            </div>
                </div>
                    </div>
                        </div>";
echo "<hr>";*/
?>
