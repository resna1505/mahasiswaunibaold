<?php

#echo "KADIEU".$aksi.$pilihan;exit();
echo "\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"../tiny_mce/init_tiny_mce.js\"></script>\r\n \r\n";
#echo "aaa".$pilihan.$aksi;exit();
echo "<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body\">
				<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height\">
					<div class=\"m-grid__item m-grid__item--fluid m-wrapper\">
						<!-- BEGIN: Subheader -->
						<div class=\"m-subheader \" style=\"padding:10px 0px 0px 0px; margin: 0px;\">
							<div class=\"d-flex align-items-center\">
								<div class=\"mr-auto\">
									<h3 class=\"m-subheader__title \">
										Dashboard
									</h3>
									<!--<ul class=\"m-subheader__breadcrumbs m-nav m-nav--inline\">
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
													Pengumuman
												</span>
											</a>
										</li>
									</ul>-->
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "tambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilawal";
    }
    include( "pengumuman.php" );
}
else if ( $pilihan == "edit")
{
    if ( $aksi == "" )
    {
        $aksi = "caripengumuman";
    }
    include( "pengumuman.php" );
}
else if ( $pilihan == "lihat" || $pilihan == "" )
{
    if ( $aksi != "tampilkan" )
    {
        $aksi = "";
    }
    include("pengumuman.php");
}
else
{
	#echo "kkk";
    if ( $pilihan == "itambah" )
    {
        if ( $aksi == "" )
        {
            $aksi = "tampilawal";
        }
        include( "info.php" );
    }
    else
    {
        if ( $pilihan == "ilihat" )
        {
            if ( $aksi != "tampilkan" )
            {
                $aksi = "";
            }
            include( "info.php" );
        }
    }
}
?>
