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
													Mahasiswa
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
    if ( isoperator( ) )
    {
        include( "mahasiswa.php" );
    }
}
else if ( $pilihan == "mlihat" || $pilihan == "" )
{
    if ( isoperator( ) || isdosen( ) )
    {
        include( "mahasiswa.php" );
    }
}
else if ( $pilihan == "mlihat3")
{
    if ( isoperator( ) || isdosen( ) )
    {
        include( "mahasiswapmb.php" );
    }
}
else if ( $pilihan == "mlihat2")
{
    if ( isoperator( ) || isdosen( ) )
    {
        include( "mahasiswakrs.php" );
    }
}
else if ( $pilihan == "lengkap" )
{
    include( "lengkap.php" );
}
else if ( $pilihan == "mrekap" )
{
    if ( isoperator( ) )
    {
        include( "rekap.php" );
    }
}
else if ( $pilihan == "kelas" )
{
    if ( isoperator( ) )
    {
        include( "kelas.php" );
    }
}
else if ( $pilihan == "kartu" )
{
    include( "settingkartu.php" );
}
else if ( $pilihan == "templatekartu" )
{
    if ( isoperator( ) )
    {
        include( "templatekartu.php" );
    }
}
else
{
    if ( $pilihan == "koreksi" )
    {
        if ( isoperator( ) )
        {
            include( "koreksimhs.php" );
        }
    }
    else
    {
        if ( $pilihan == "labelkelas" && isoperator( ) )
        {
            include( "labelkelas.php" );
        }
    }
}
?>
