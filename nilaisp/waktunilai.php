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
if ( $jenisusers == 0 && $prodis == "" )
{
    cekhaktulis( $kodemenu );
  
    echo "<div class=\"page-content\">
   			<div class=\"container-fluid\">
       			<div class=\"row\">
           			<div class=\"col-md-12\">
                <!-- BEGIN SAMPLE FORM PORTLET-->
						<div class=\"portlet light\">
							<div class=\"portlet-title\">
								<div class='caption'>";
									printmesg("Edit Konversi Nilai");
	echo"						</div>                    
							</div>
							<div>";
	echo "						<ol>\r\n  <li><a href='index.php?pilihan=waktunilaiumum'>SETTING UMUM PER TAHUN SEMESTER</a></li>\r\n    Setting umum ini digunakan untuk menentukan kapan batas waktu akhir Dosen dapat entri nilai mahasiswa. Setting ini berlaku per Tahun Semester  kurikulum  untuk semua mata kuliah tanpa memandang Program Studi-nya. Setting ini akan berlaku apabila setting khusus di bawah (no. 2) tidak digunakan. <br><br>\r\n  <li><a href='index.php?pilihan=waktunilaiprodi'>\r\n  SETTING KHUSUS PER TAHUN SEMESTER dan PRODI</a></li>\r\n  Setting ini digunakan untuk menentukan batas waktu terakhir Dosen dapat entri nilai mahasiswa untuk masing2 Program Studi mata kuliah kurikulum Tahun Semester tertentu. Pemisahan waktu entri nilai untuk dosen dilakukan dengan tujuan supaya masing-masing Program Studi dapat menentukan sendiri batas akhir entri nilai. Apabila tidak digunakan, batas waktu entri nilai akan mengacu pada Setting Umum No. 1.\r\n</ol> \r\n \r\n<b>CATATAN: </b>\r\n<ul>\r\n<li>Apabila tidak ada setting waktu yang dibuat, maka Dosen BEBAS mengentri nilai kapan pun.</li>\r\n<li>Setting ini hanya berlaku untuk DOSEN, tidak untuk operator. Operator tetap bebas mengentri nilai kapanpun sesuai kapasitasnya</li>\r\n</ul>";
	echo "	</div>
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
