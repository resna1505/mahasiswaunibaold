<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
echo "<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body\">
				<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height\">
					<div class=\"m-grid__item m-grid__item--fluid m-wrapper\">
						<!-- BEGIN: Subheader -->
						<div class=\"m-subheader \">
							<div class=\"d-flex align-items-center\">
								<div class=\"mr-auto\">
									<h3 class=\"m-subheader__title \">
										Dashboard
									</h3>
									<ul class=\"m-subheader__breadcrumbs m-nav m-nav--inline\">
										<li class=\"m-nav__item m-nav__item--home\">
											<a href=\"#\" class=\"m-nav__link m-nav__link--icon\">
												<i class=\"m-nav__link-icon la la-home\"></i>
											</a>
										</li>
										<li class=\"m-nav__separator\">
											-
										</li>
										<li class=\"m-nav__item\">
											<a class=\"m-nav__link\">
												<span class=\"m-nav__link-text\">
													Dashboard
												</span>
											</a>
										</li>
										<li class=\"m-nav__separator\">
											-
										</li>
										<li class=\"m-nav__item\">
											<a class=\"m-nav__link\">
												<span class=\"m-nav__link-text\">
													Mata Kuliah SP
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "mtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "makul.php" );
}
else if ( $pilihan == "mlihat" || $pilihan == "" )
{
    include( "makul.php" );
}
else if ( $pilihan == "dtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    include( "dosen.php" );
}
else if ( $pilihan == "dlihat" )
{
    include( "dosen.php" );
}
else if ( $pilihan == "ptambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    include( "mahasiswa.php" );
}
else if ( $pilihan == "plihat" )
{
    include( "mahasiswa.php" );
}
else if ( $pilihan == "psyarat" )
{
    include( "syaratkrs.php" );
}
else if ( $pilihan == "psyarat2" )
{
    include( "settingwaktukrs.php" );
}
else if ( $pilihan == "waktukrsumum" )
{
    include( "waktukrs.php" );
}
else if ( $pilihan == "waktukrsprodi" )
{
    include( "waktukrsprodi.php" );
}
else if ( $pilihan == "kurikulum" )
{
    include( "kurikulum.php" );
}
else if ( $pilihan == "copyk" )
{
    include( "copyk.php" );
}
else if ( $pilihan == "laporanm" )
{
    include( "laporanm.php" );
}
else if ( $pilihan == "lap1" )
{
    include( "lap1.php" );
}
else if ( $pilihan == "lap2" )
{
    include( "lap2.php" );
}
else if ( $pilihan == "p2tambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    include( "mahasiswastei.php" );
}
else if ( $pilihan == "p2lihat" )
{
    include( "mahasiswastei.php" );
}
else if ( $pilihan == "p2jadwal" )
{
    include( "jadwalstei.php" );
}
else if ( $pilihan == "psyarat3" )
{
    include( "waktupkrsstei.php" );
}
else
{
    if ( $pilihan == "mhsmakul" )
    {
        include( "mhsmakul.php" );
    }
    else
    {
        if ( $pilihan == "hapuskurikulum" )
        {
            include( "hapuskurikulum.php" );
        }
    }
}
?>
