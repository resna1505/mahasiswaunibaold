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
#echo "\r\n".IKONLAPORAN48."\r\n<table>\r\n<tr><td>\r\n  <ul>\r\n    <li><a href='index.php?pilihan=lap1'>Daftar Mahasiswa yang  Mengambil KRS Semester pendek</a></li>\r\n    <li><a href='index.php?pilihan=lap2'>Daftar Mahasiswa yang Tidak/Belum Mengambil KRS Semester Pendek</li>\r\n  </ul>\r\n  </td>\r\n  </tr></table>\r\n";
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
											printmesg("Laporan Pengambilan KRS Semester Pendek Mahasiswa");
								echo	"</div>
									</div>";
								echo "<div class='portlet-body form'>
									<table class=\"table table-striped table-bordered table-hover\">";	
echo "									<tr><td>\r\n  <ul>\r\n    <li><a href='index.php?pilihan=lap1'>Daftar Mahasiswa yang  Mengambil KRS Semester pendek</a></li>\r\n    <li><a href='index.php?pilihan=lap2'>Daftar Mahasiswa yang Tidak/Belum Mengambil KRS Semester Pendek</li>\r\n  </ul>\r\n  </td>\r\n  </tr></table>\r\n";
echo "							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
?>
