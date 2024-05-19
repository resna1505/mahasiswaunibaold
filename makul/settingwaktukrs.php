<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Setting Waktu KRS Online" );
    /*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <br><br><br><br>
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class=\"portlet light\">
                                <div class=\"portlet-title\">
                                    <div class=\"caption font-green-haze\">
        <i class=\"icon-settings font-green-haze\"></i>
        <span class=\"caption-subject bold uppercase\"> Setting Waktu KRS Online </span>
                                </div>
                            <div class=\"actions\"></div>
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
											printmesg("Setting Waktu KRS Online");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
    echo "\r\n<ol>\r\n  <li><a href='index.php?pilihan=waktukrsumum'>SETTING UMUM PER TAHUN SEMESTER</a></li>\r\n    Setting umum ini digunakan untuk menentukan kapan waktu KRS Online dilakukan. Setting ini berlaku per Tahun Semester untuk semua mahasiswa tanpa memandang Program Studi atau Angkatannnya. Setting ini akan berlaku apabila setting khusus di bawah (no. 2) tidak digunakan. <br><br>\r\n  <li><a href='index.php?pilihan=waktukrsprodi'>\r\n  SETTING KHUSUS PER TAHUN SEMESTER, PRODI, dan ANGKATAN</a></li>\r\n  Setting ini digunakan untuk menentukan waktu KRS online untuk masing2 Program Studi dan Angkatan mahasiswa pada Tahun Semester tertentu. Pemisahan waktu KRS online dilakukan dengan tujuan memngurangi beban server saat mahasiswa melakukan pengisian KRS online. APabila tidak digunakan, waktu KRS online akan mengacu pada Setting Umum No. 1.\r\n</ol> \r\n \r\n ";

    echo "						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
