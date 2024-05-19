<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "" )
{
    #printjudulmenu( "Laporan Keuangan Mahasiswa" );
    #printmesg( $errmesg );
    #echo "\r\n\t".IKONLAPORAN48."\r\n\t<table  >\r\n\t\t<tr>\r\n\t\t\t<td align=left>\r\n \t\t<ul >\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan1'>\r\n \t\t\t\t\tLaporan Mahasiswa yg Sudah Membayar\r\n \t\t\t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan2'>\r\n\t\t \t\t\tLaporan Mahasiswa yg Belum Membayar\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan4'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Mahasiswa\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan3'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Umum\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan5'>\r\n\t\t \t\t\tRekapitulasi Laporan Harian\r\n\t\t \t\t</a> \r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan6'>\r\n\t\t \t\tLaporan Harian\r\n\t\t \t\t</a> \r\n \t\t\t<!--<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan7'>\r\n\t\t \t\tRekap Tunggakan Pembayaran Mahasiswa\r\n\t\t \t\t</a> -->\r\n \t\t</ul>\r\n \t\t\t</td>\r\n \t\t</tr>\r\n \t</table>\r\n\t";
	#echo "\r\n\t".IKONLAPORAN48."\r\n\t<table  >\r\n\t\t<tr>\r\n\t\t\t<td align=left>\r\n \t\t<ul >\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan1'>\r\n \t\t\t\t\tLaporan Mahasiswa yg Sudah Membayar\r\n \t\t\t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan2'>\r\n\t\t \t\t\tLaporan Mahasiswa yg Belum Membayar\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan4'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Mahasiswa\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan3'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Umum\r\n\t\t \t\t</a>\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan5'>\r\n\t\t \t\t\tRekapitulasi Laporan Harian\r\n\t\t \t\t</a> \r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan6'>\r\n\t\t \t\tLaporan Harian\r\n\t\t \t\t</a> \r\n \t\t\t\r\n \t\t</ul>\r\n \t\t\t</td>\r\n \t\t</tr>\r\n \t</table>\r\n\t";
	echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">                
							<!-- BEGIN SAMPLE FORM PORTLET-->
							<div class=\"portlet light\">
								<div class=\"portlet-body form\">
									<div class='tab-pane' id='tab_1'>
										<div class='portlet box blue'>
											<div class='portlet-title'>
												<div class='caption'>";
													printmesg("Laporan Keuangan Mahasiswa");
													printmesg( $errmesg );
	echo "										</div>
											</div>
											<div class='portlet-body form'>";
	echo "											<ul >\r\n \t\t\t<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan1'>\r\n \t\t\t\t\tLaporan Mahasiswa yg Sudah Membayar\r\n \t\t\t\t</a></li><li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan2'>\r\n\t\t \t\t\tLaporan Mahasiswa yg Belum Membayar\r\n\t\t \t\t</a></li><li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan4'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Mahasiswa\r\n\t\t \t\t</a></li><li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan3'>\r\n\t\t \t\t\tRekapitulasi Pembayaran Umum\r\n\t\t \t\t</a></li><!--<li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan5'>\r\n\t\t \t\t\tRekapitulasi Laporan Harian\r\n\t\t \t\t</a> </li>--><li>\r\n \t\t\t\t<a style='font-size:14px;' href='index.php?pilihan=laporan6'>\r\n\t\t \t\tLaporan Harian\r\n\t\t \t\t</a></li></ul>";
	echo "						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
}
?>
