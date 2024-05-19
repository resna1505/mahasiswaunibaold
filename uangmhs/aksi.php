<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
#echo getaturan('APPROVEBEASISWA').'<br>';
#echo "JENIS=".$jeniss.",JENIS USER=".$jenisusers.",PILIHAN=".$pilihan.",AKSI=".$aksi;
#echo $jenisusers.$pilihan.$aksi;exit();
#$pilihan=$_POST['pilihan'];
#echo "JENIS=".$jeniss.",JENIS USER=".$jenisusers.",PILIHAN=".$pilihan.",AKSI=".$aksi;
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
													Keuangan Mahasiswa
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $jenisusers == 0 )
{
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
    else if ( $pilihan == "mlihat" )
    {
        if ( isoperator( ) )
        {
            include( "mahasiswa.php" );
        }
    }
    else if ( $pilihan == "mlihat2" )
    {
        if ( isoperator( ) )
        {
            include( "mahasiswa.php" );
        }
    }	
    else if ( $pilihan == "biaya" )
    {
        if ( isoperator( ) )
        {
            include( "biayakomponen.php" );
        }
    }
    else if ( $pilihan == "settingcicilantagihan" )
    {
        if ( isoperator( ) )
        {
            include( "settingcicilantagihan.php" );
        }
    }
    else if ( $pilihan == "buattagihan" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihan.php" );
        }
    }
   else if ( $pilihan == "buattagihan2" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihan2.php" );
        }
    }
   else if ( $pilihan == "buattagihanva" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihanva.php" );
        }
    }
    else if ( $pilihan == "buattagihanvamandiri" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihanvamandiri.php" );
        }
    }
    else if ( $pilihan == "buattagihanvamandiritest" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihanvamandiritest.php" );
        }
    }
    else if ( $pilihan == "buattagihanvabni" )
    {
        if ( isoperator( ) )
        {
            include( "buattagihanvabni.php" );
        }
    }
			
    else if ( $pilihan == "koreksitagihan" )
    {
        if ( isoperator( ) )
        {
            include( "koreksitagihan.php" );
        }
    }
	else if ( $pilihan == "koreksitagihanva" )
    {
        if ( isoperator( ) )
        {
            include( "koreksitagihanva.php" );
        }
    }
    else if ( $pilihan == "koreksitagihanvamandiri" )
    {
		echo "AKSI =".$aksi.'<br>';
		echo "PILIHAN =".$pilihan.'<br>';
		#exit();
        if ( isoperator( ) )
        {
            include( "koreksitagihanvamandiri.php" );
        }
    }
    else if ( $pilihan == "koreksitagihanvabni" )
    {
		echo "AKSI =".$aksi.'<br>';
		echo "PILIHAN =".$pilihan.'<br>';
		#exit();
        if ( isoperator( ) )
        {
            include( "koreksitagihanvabni.php" );
        }
    }
    else if ( $pilihan == "kirimtagihanvabni" )
    {
        if ( isoperator( ) )
        {
            include( "kirimtagihanvabni.php" );
        }
    }	 					
    else if ( $pilihan == "lihatrekeningkoran" )
    {
        if ( isoperator( ) )
        {
            include( "lihatrekeningkoran.php" );
        }
    }
	else if ( $pilihan == "lihatrekeninglain" )
    {
        if ( isoperator( ) )
        {
            include( "lihatrekeninglain.php" );
        }
    }
    else if ( $pilihan == "bayar")
    {
		#echo $BATAM;
        if ( $BATAM == 1 )
        {
            include( "bayarbatam.php" );
        }
        else
        {
            include( "bayar.php" );
        }
    }
	else if ( $pilihan == "bayarrekeningkoran")
    {
		#echo $BATAM;
        if ( $BATAM == 1 )
        {
            include( "bayarrekeningkoranbatam.php" );
        }
        else
        {
            include( "bayar.php" );
        }
    }
	else if ( $pilihan == "bayarrekeninglain")
    {
		#echo $BATAM;
        if ( $BATAM == 1 )
        {
            include( "bayarrekeninglainbatam.php" );
        }
        else
        {
            include( "bayar.php" );
        }
    }
    else if ( $pilihan == "lihatbayar" || $pilihan == "" )
    {
		
        if ( isoperator( ) )
        {
			#echo "aaa";exit();
            include( "lihatbayar.php" );
        }
    }
    else if ( $pilihan == "laporan" )
    {
		
        if ( isoperator( ) )
        {
            include( "laporan.php" );
        }
    }
    else if ( $pilihan == "laporan1" )
    {
        if ( isoperator( ) )
        {
            include( "laporan1.php" );
        }
    }
    else if ( $pilihan == "laporan2" )
    {
        if ( isoperator( ) )
        {
            include( "laporan2.php" );
        }
    }
    else if ( $pilihan == "teslaporan2" )
    {
        if ( isoperator( ) )
        {
            include( "teslaporan2.php" );
        }
    }	
    else if ( $pilihan == "laporan3" )
    {
        if ( isoperator( ) )
        {
            include( "laporan3.php" );
        }
    }
    else if ( $pilihan == "laporan4" )
    {
        if ( isoperator( ) )
        {
            include( "laporan4.php" );
        }
    }
    else if ( $pilihan == "laporan5" )
    {
        if ( isoperator( ) )
        {
            include( "laporan5.php" );
        }
    }
    else if ( $pilihan == "laporan6" )
    {
        if ( isoperator( ) )
        {
            include( "laporan6.php" );
        }
    }
    else if ( $pilihan == "laporan7" )
    {
        if ( isoperator( ) )
        {
            include( "laporan7.php" );
        }
    }
    else if ( $pilihan == "btambah" )
    {
        if ( $aksi == "" )
        {
            $aksi = "formtambah";
        }
        if ( isoperator( ) )
        {
            include( "biayasks.php" );
        }
    }
    else if ( $pilihan == "blihat" )
    {
        if ( isoperator( ) )
        {
            include( "biayasks.php" );
        }
    }
    else if ( $pilihan == "dtambah" )
    {
        if ( $aksi == "" )
        {
            $aksi = "formtambah";
        }
        if ( isoperator( ) )
        {
            include( "deposit.php" );
        }
    }
    else if ( $pilihan == "dlihat" )
    {
        if ( isoperator( ) )
        {
            include( "deposit.php" );
        }
    }
    else if ( $pilihan == "dpakai" )
    {
        if ( isoperator( ) )
        {
            include( "pakaideposit.php" );
        }
    }
    else if ( $pilihan == "dsisa" )
    {
        if ( isoperator( ) )
        {
            include( "sisadeposit.php" );
        }
    }
    else if ( $pilihan == "impor" )
    {
        if ( isoperator( ) )
        {
            include( "impor.php" );
        }
    }
	else if ( $pilihan == "imporbank" )
    {
        if ( isoperator( ) )
        {
            include( "imporbank.php" );
        }
    }
    else if ( $pilihan == "imporbankva" )
    {
        if ( isoperator( ) )
        {
            include( "imporbankva.php" );
        }
    }
    else if ( $pilihan == "imporbankvamandiri" )
    {
        if ( isoperator( ) )
        {
            include( "imporbankvamandiri.php" );
        }
    }
    else if ( $pilihan == "imporbankvabni" )
    {
        if ( isoperator( ) )
        {
            include( "imporbankvabni.php" );
        }
    }	
    else if ( $pilihan == "imporbankvamandiritest" )
    {
        if ( isoperator( ) )
        {
            include( "imporbankvamandiritest.php" );
        }
    }		
    else if ( $pilihan == "imporbank2" )
    {
        if ( isoperator( ) )
        {
            include( "imporbank2.php" );
        }
    }
	/*else if ( $pilihan == "imporbanklain" )
    {
        if ( isoperator( ) )
        {
            include( "imporbanklain.php" );
        }
    }*/
    else if ( $pilihan == "waktukeuangan" )
    {
        if ( isoperator( ) )
        {
            include( "waktukeuangan.php" );
        }
    }
    else if ( $pilihan == "beasiswa" )
    {
        if ( isoperator( ) )
        {
            include( "beasiswa.php" );
        }
    }
    else if ( $pilihan == "lihatbeasiswa" )
    {
        if ( isoperator( ) )
        {
            include( "lihatbeasiswa.php" );
        }
    }
    else if ( $pilihan == "updatebeasiswa" )
    {
        if ( isoperator( ) )
        {
            include( "updatebeasiswa.php" );
        }
    }
    else if ( $pilihan == "historybeasiswa" )
    {
        if ( isoperator( ) )
        {
            include( "historybeasiswa.php" );
        }
    }
    else if ( $pilihan == "bayarbatam" )
    {
		#echo "llll";exit();
        if ( isoperator( ) )
        {
            include( "bayarbatambaru.php" );
		
		}
    }
    else if ( $pilihan == "bayarbatamemail" )
    {
		#echo "llll";exit();
        if ( isoperator( ) )
        {
            include( "bayarbatambaruemail.php" );
		
		}
    }
    else if ( $pilihan == "bayarbatammail" )
    {
		#echo "llll";exit();
        if ( isoperator( ) )
        {
            include( "bayarbatambarumail.php" );
		
		}
    }	
    else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $pilihan == "daftarulang" )
    {
        if ( isoperator( ) )
        {
            include( "daftarulang.php" );
        }
    }
    else if ( $pilihan == "approvebeasiswa" && isoperator() && getaturan( "APPROVEBEASISWA" ) == 1 && $jeniss == 1 )
    {
		#echo "ll";exit();
        include( "approvebeasiswa.php" );
    }
    elseif ( $pilihan == "pindahgelombang" )
    {
		if ( isoperator( ) )
		{
			include( "pindahgelombang.php" );
		}
    }
    elseif ( $pilihan == "rekapnilaidosenmhs" )
    {
		if ( isoperator( ) )
		{
			include( "rekapnilaidosenmahasiswa.php" );
		}
    }
}
if ( $jenisusers == 3 || $jenisusers == 2 )
{
    if ( $pilihan == "lihatbayar" || $pilihan == "" )
    {
		#echo "lll";exit();
        include( "lihatbayar.php" );
    }
    else if ( $pilihan == "laporan" )
    {
        include( "laporanortu.php" );
    }
    if ( $pilihan == "laporan1" )
    {
        include( "laporan1.php" );
    }
    if ( $pilihan == "laporan2" )
    {
        include( "laporan2.php" );
    }
}
?>
