<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
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
													Data Dosen
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "dtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
	/*echo "<!-- BEGIN PAGE HEAD-->
                            <div class=\"page-head\">
                                <div class=\"container-fluid\">";
	echo "<div class=\"page-title\" style=font-weight:bold;>Dosen <font size=1px>>></font> Form Tambah</div></div></div>";*/
	
    include( "dosen.php" );
}
else if ( $pilihan == "dlihat" || $pilihan == "" )
{
	
	
    include( "dosen.php" );
}
else if ( $pilihan == "lengkap" )
{
	/*echo "<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body\">
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
													Data Dosen
												</span>
											</a>
										</li>
									</ul>
								</div>
								
							</div>
						</div>
						<!-- END: Subheader -->"; 	
	echo "<div class=\"m-content\">";*/
    include( "lengkap.php" );
}
else if ( $pilihan == "mrekap" )
{
	/*echo "<!-- BEGIN PAGE HEAD-->
                            <div class=\"page-head\">
                                <div class=\"container-fluid\">";
	echo "<div class=\"page-title\" style=font-weight:bold;>Dosen <font size=1px>>></font> Rekap Data Dosen</div></div></div>";	*/
	/*echo "<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body\">
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
													Data Dosen
												</span>
											</a>
										</li>
									</ul>
								</div>
								
							</div>
						</div>
						<!-- END: Subheader -->"; 	
	echo "<div class=\"m-content\">";*/
    include( "rekap.php" );
}
else if ( $pilihan == "koreksi" )
{
	/*echo "<!-- BEGIN PAGE HEAD-->
                            <div class=\"page-head\">
                                <div class=\"container-fluid\">";
	echo "<div class=\"page-title\" style=font-weight:bold;>Dosen <font size=1px>>></font> Koreksi Data Dosen</div></div></div>";*/	
    include( "koreksidosen.php" );
}
else
{
    if ( $pilihan == "sinkronisasi" )
    {
        include( "sinkronisasi.php" );
    }
    else
    {
        if ( $pilihan == "koreksi2" )
        {
			/*echo "<!-- BEGIN PAGE HEAD-->
                            <div class=\"page-head\">
                                <div class=\"container-fluid\">";
			echo "<div class=\"page-title\" style=font-weight:bold;>Dosen <font size=1px>>></font> Periksa Data Dosen Ganda</div></div></div>";	*/	
            include( "dosenganda.php" );
        }
    }
}
?>
