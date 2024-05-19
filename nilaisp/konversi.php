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
if ( $tab == "umum" && $jenisusers == 0 )
{
    include( "editkonversiumum.php" );
}
else if ( $tab == "semester" && $jenisusers == 0 )
{
    include( "editkonversisemester.php" );
}
else if ( $tab == "khusus" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    include( "editkonversikhusus.php" );
}
if ( $tab == "" )
{
    #printjudulmenu( "EDIT KONVERSI NILAI" );
    echo "<div class=\"page-content\">
   			<div class=\"container-fluid\">
       			<div class=\"row\">
           			<div class=\"col-md-12\">
                <!-- BEGIN SAMPLE FORM PORTLET-->
						<div class=\"portlet light\">
							<div class=\"portlet-title\">
								<div class='caption'>";
									printmesg("Edit Konversi Nilai Semester Pendek");
	echo"						</div>                    
							</div>
							<div>";
    echo "\r\n  <ul>";
    if ( $jenisusers == 0 )
    {
        

        echo "\r\n    <li><a href='index.php?pilihan={$pilihan}&tab=umum'>KONVERSI NILAI DEFAULT UMUM</a>\r\n    <br><br>\r\n    Ini adalah setting default untuk semua mata kuliah. Setting ini akan digunakan  apabila setting yang lain tidak ditemukan/digunakan.  \r\n    <br><br>\r\n    </li>\r\n     <li><a href='index.php?pilihan={$pilihan}&tab=semester'>KONVERSI NILAI DEFAULT PER SEMESTER PER PRODI</a>\r\n    <br><br>\r\n    Ini adalah setting default untuk prodi dan semester tertentu. Setting ini akan digunakan  apabila setting khusus tidak ditemukan/digunakan. Setting ini juga merupakan tabel TBBLN untuk laporan DIKTI.  \r\n    <br><br>\r\n      </li>";
    }
    echo "\r\n    <li><a href='index.php?pilihan={$pilihan}&tab=khusus'>KONVERSI NILAI KHUSUS PER PENGAJAR MATA KULIAH</a>\r\n    <br><br>\r\n    Ini adalah setting khusus per pengajar mata kuliah.  \r\n    <br><br>\r\n    \r\n    </li>\r\n  </ul>
							</div>
						</div>
					</div>
				</div>
            </div>
		</div>";
}
?>
