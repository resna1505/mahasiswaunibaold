<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
#echo $pilihan."ll".$aksi;exit();
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
													Sistem
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "update" )
{
    include( "sistem.php" );
}
else if ( $pilihan == "lblihat" )
{
    include( "libur.php" );
}
else if ( $pilihan == "lbtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambah";
    }
    include( "libur.php" );
}
else if ( $pilihan == "dlihat" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilkan";
    }
    include( "dana.php" );
}
else if ( $pilihan == "dtambah" )
{
    include( "dana.php" );
}
else if ( $pilihan == "llihat" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilkan";
    }
    include( "link.php" );
}
else if ( $pilihan == "ltambah" )
{
    include( "link.php" );
}
else if ( $pilihan == "pupdate" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilkan";
    }
    include( "pooling.php" );
}
else if ( $pilihan == "ptambah" )
{
    include( "pooling.php" );
}
else if ( $pilihan == "log" || $pilihan == "" )
{
    include( "log.php" );
}
else if ( $pilihan == "aturan" )
{
    include( "aturan.php" );
}
else if ( $pilihan == "tools" )
{
    include( "tools.php" );
}
else
{
    if ( $pilihan == "field" )
    {
        include( "fieldbebas.php" );
    }
    else
    {
        if ( $pilihan == "tesmodul" )
        {
            include( "tesmodul.php" );
        }
    }
}
?>