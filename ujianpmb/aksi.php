<?php
#echo "\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"../tiny_mce/init_tiny_mce.js\"></script>\r\n";
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
													Ujian PMB
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "bidangsoalpmb" )
{
    include( "bidangsoal.php" );
}
else if ( $pilihan == "formtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "banksoalpmb.php" );
}
else if ( $pilihan == "cari" || $pilihan == "" )
{
	#echo "ll";exit();
    include( "banksoalpmb.php" );
}
else if ( $pilihan == "copy" )
{
    include( "copybanksoalpmb.php" );
}
else if ( $pilihan == "tambahoperatorbank" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "operatorbank.php" );
}
else if ( $pilihan == "lihatoperatorbank" )
{
    include( "operatorbank.php" );
}
else if ( $pilihan == "jadwalp" )
{
    include( "waktupendaftaran.php" );
}
else if ( $pilihan == "jadwalu" )
{
    include( "waktuujianpmb.php" );
}
else if ( $pilihan == "konfigmail" )
{
    include( "konfigmail.php" );
}
else if ( $pilihan == "konfigresetpassword" )
{
    include( "konfigresetpassword.php" );
}
else if ( $pilihan == "konfigpendaftaran" )
{
    include( "konfigpendaftaran.php" );
}
else if ( $pilihan == "settingwaktu" )
{
    include( "settingwaktu.php" );
}
else
{
    if ( $pilihan == "keterangan" )
    {
        include( "keterangan.php" );
    }
    else
    {
        if ( $pilihan == "konfigpengumuman" )
        {
            include( "konfigpengumuman.php" );
        }
    }
}
?>
