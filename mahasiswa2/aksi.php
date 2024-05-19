<?php
#echo $pilihan.$idupdate;
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
if( $pilihan == ""){
	if ( $aksi == "tagihanvamahasiswa" ){
    	include("tagihanvamahasiswa.php");
    }
}
if ( $pilihan == "mtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "mahasiswa.php" );
}
else
{
	#echo "AKSI=".$aksi."AKSI2=".$aksi2."PILIHAN=".print_r($pilihan);	
    if ( $pilihan == "mlihat" || $pilihan == "" ){
		#echo "masuk";exit();
		if($aksi2=="Tambah"){			
			echo var_dump($pilih);exit();
		}else{	
			include( "mahasiswa.php" );
		}
    }
    else
    {
        if ( $pilihan == "lengkap" )
        {
            include( "lengkap.php" );
        }
    }
}
?>
