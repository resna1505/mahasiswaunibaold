<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#printjudulmenu( "Laporan Pengambilan KRS Mahasiswa" );
/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Laporan Pengambilan KRS Mahasiswa </span>
                            </div>
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
											printmesg("Laporan Pengambilan KRS Mahasiswa");
								echo	"</div>
									</div>";
								echo "<div class='portlet-body form'>
									<table class=\"table table-striped table-bordered table-hover\">";	
echo "<tr>\r\n<td>\r\n  <ul>\r\n    <li><a href='index.php?pilihan=lap1'>Daftar Mahasiswa yang Sudah Mengambil KRS</a></li>\r\n    <li><a href='index.php?pilihan=lap2'>Daftar Mahasiswa yang Belum Mengambil KRS</li>\r\n  </ul>\r\n  </td>\r\n  </tr>\r\n  </table>\r\n";

echo "							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
?>
