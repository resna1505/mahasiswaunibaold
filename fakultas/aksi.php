<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( !isoperator( ) )
{
    exit( );
}
echo "PILIHAN=".$pilihan;
echo "AKSI=".$aksi;
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
													Akademik
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "ftambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
					
    include( "fakultas.php" );
}
else if ( $pilihan == "flihat" )
{
	
    include( "fakultas.php" );
}
else if ( $pilihan == "dtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
	
    include( "departemen.php" );
}
else if ( $pilihan == "dlihat" )
{
	
		include( "departemen.php" );
}
else if ( $pilihan == "ptambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
	
    include( "prodi.php" );
}
else if ( $pilihan == "plihat" || $pilihan == "" )
{
	
    include( "prodi.php" );
}
else if ( $pilihan == "pkoreksi" )
{
	
    include( "koreksiprodi.php" );
}
else
{
    if ( $pilihan == "yayasan" )
    {
		
		include( "yayasan.php" );
	}
    else
    {
        if ( $pilihan == "pt" )
        {
			
				include( "pt.php" );
        }
    }
}
?>
