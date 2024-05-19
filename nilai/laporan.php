<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#printjudulmenu( "Laporan Nilai Mahasiswa" );
#echo "\r\n".IKONLAPORAN48."\r\n\r\n<table>\r\n<tr><td>\r\n<ul>\r\n  <li><a href='index.php?pilihan=laporan1'>Rekap Indeks Prestasi Kumulatif (IPK)</a></li>\r\n  <li><a href='index.php?pilihan=laporan2'>Rekap Indeks Prestasi Semester (IPS)</a></li>\r\n</ul>\r\n</td></tr></table>\r\n";
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
											printmesg("Laporan Nilai Mahasiswa");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
    echo "<ul>\r\n  <li><a href='index.php?pilihan=laporan1'>Rekap Indeks Prestasi Kumulatif (IPK)</a></li>\r\n  <li><a href='index.php?pilihan=laporan2'>Rekap Indeks Prestasi Semester (IPS)</a></li>\r\n</ul>";

    echo "						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
?>
