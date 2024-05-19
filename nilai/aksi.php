<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $UNIVERSITAS;exit();
periksaroot();
#echo "PILIHANNYA".$pilihan."ll".$aksi;exit();
#echo $pilihan.$idupdate.$jenisusers;
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
													Nilai
												</span>
											</a>
										</li>
									</ul>
								</div> <!--- div mr-auto-->								
							</div> <!-- end div d-flex align-items-center-->
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\">";	
if ( $pilihan == "ktambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    if ( isoperator( ) || isdosen( ) && getaturan( "EDITKOMPONENNILAIDOSEN" ) == 1 )
    {
        include( "komponen.php" );
    }
}
else if ( ( isoperator( ) || isdosen( ) ) && ( $pilihan == "klihat" || $pilihan == "" && isoperator( ) ) )
{
	#echo "kaka";exit();
    if ( isoperator( ) || isdosen( ) && getaturan( "EDITKOMPONENNILAIDOSEN" ) == 1 )
    {
        include( "komponen.php" );
    }
}
else if ( $pilihan == "ntambah" || $pilihan == "" && isdosen( ) )
{
	#echo "kjh";exit();
    if ($aksi == "" )
    {
        $aksi = "tambahawal";
    }
    if ( isoperator( ) || isdosen( ) )
    {
		#echo "LL";exit();
		include( "nilai.php" );
    }
}
else if ( $pilihan == "ntambahm" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    if ( isoperator( ) || isdosen( ) )
    {
        include( "nilai.php" );
    }
}
else if ( $pilihan == "ujianakhir" )
{
    if ( isoperator( ) )
    {
        include( "ujianakhir.php" );
    }
}
else if ( $pilihan == "editmhs" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawalm";
    }
    if ( isoperator( )  || isdosen( ))
    {
        include( "nilai.php" );
    }
}
else if ( $pilihan == "editmhstest" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawalm";
    }
    if ( isoperator( )  || isdosen( ))
    {
        include( "nilaitest.php" );
    }
}

else if ( $pilihan == "transkrip" )
{
    if ( isoperator( ) )
    {
        include( "transkrip.php" );
    }
}
else if ( $pilihan == "ptambah" )
{
    if ( isoperator( ) || isdosen( ) && getaturan( "EDITKOMPONENNILAIDOSEN" ) == 1 )
    {
        include( "konversi.php" );
    }
}
else if ( $pilihan == "ipk" )
{
    if ( isoperator( ) )
    {
        include( "rekaptranskrip.php" );
    }
}
else if ( $pilihan == "nilai" )
{
    if ( isoperator( ) )
    {
        include( "rekapnilai.php" );
    }
}
else if ( $pilihan == "konfigkonversi" )
{
    if ( isoperator( ) )
    {
        include( "konfigkonversi.php" );
    }
}
else if ( $pilihan == "khs" || $pilihan == "" )
{
    if ( isoperator( ) || ismahasiswa( ) || iswali( ) )
    {
		#echo "aa";exit();
        include( "khs.php" );
		#include( "nilaikuliah.php" );
    }
}
else if ( $pilihan == "konfigpredikat" )
{
    if ( isoperator( ) )
    {
        include( "konfigpredikat.php" );
    }
}
else if ( $pilihan == "penandatangan" )
{
    if ( isoperator( ) )
    {
        include( "ttd.php" );
    }
}
else if ( $pilihan == "importdmr" )
{
    if ( $aksi == "" )
    {
        $aksi = "tambahawal";
    }
    if ( isoperator( ) )
    {
        include( "importdmr.php" );
    }
}
else if ( $pilihan == "diagramip" )
{
    if ( isoperator( ) )
    {
        include( "diagramipsemester.php" );
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
        include( "rekapipk.php" );
    }
}
else if ( $pilihan == "laporan2" )
{
    if ( isoperator( ) )
    {
        include( "rekapips.php" );
    }
}
else if ( $pilihan == "setingijazah" )
{
    if ( isoperator( ) )
    {
        include( "setingijazah.php" );
    }
}
else if ( $pilihan == "waktuijazah" )
{
    if ( isoperator( ) )
    {
        include( "waktuijazah.php" );
    }
}
else if ( $pilihan == "rekapnilaidosenmhs" )
{
    if ( isoperator( ) )
    {
        include( "rekapnilaidosenmahasiswa.php" );
    }
}
else if ( $pilihan == "cetakijazah" )
{
    if ( isoperator( ) )
    {
        include( "cetakijazah.php" );
    }
}
else if ( $pilihan == "prosesipk" )
{
	
    if ( isoperator( ) )
    {
        include( "prosesnilaiipk.php" );
    }
}
else if ( $pilihan == "komponendefault" )
{
    if ( isoperator( ) )
    {
        include( "komponendefault.php" );
    }
}
else if ( $pilihan == "kop" )
{
    if ( isoperator( ) )
    {
        include( "pilihkop.php" );
    }
}
else if ( $pilihan == "koptranskrip" )
{
    if ( isoperator( ) )
    {
        include( "pilihkoptranskrip.php" );
    }
}
else if ( $pilihan == "waktunilai" )
{
    if ( isoperator( ) )
    {
        include( "waktunilai.php" );
    }
}
else if ( $pilihan == "waktunilaiumum" )
{
    if ( isoperator( ) )
    {
        include( "waktunilaiumum.php" );
    }
}
else if ( $pilihan == "waktunilaiprodi" )
{
    if ( isoperator( ) )
    {
        include( "waktunilaiprodi.php" );
    }
}
else if ( $pilihan == "kopumum" )
{
    if ( isoperator( ) )
    {
        include( "kop.php" );
    }
}
else if ( $pilihan == "koptranskripumum" )
{
    if ( isoperator( ) )
    {
        include( "koptranskrip.php" );
    }
}
else if ( $pilihan == "kopfakultas" )
{
    if ( isoperator( ) )
    {
        include( "kopfakultas.php" );
    }
}
else if ( $pilihan == "koptranskripfakultas" )
{
    if ( isoperator( ) )
    {
        include( "koptranskripfakultas.php" );
    }
}
else if ( $pilihan == "prosesstatusmahasiswa" )
{
	
    if ( isoperator( ) )
    {
        include( "prosesstatusmahasiswa.php" );
    }
}
else if ( $pilihan == "rekapakademik" )
{
    if ( isoperator( ) )
    {
        include( "rekapakademik.php" );
    }
}else if ( $pilihan == "detailrekapnilai" )
{
    if ( isoperator( ) )
    {
        include( "detailrekapnilai.php" );
    }
}
else
{
	#echo "lll";exit();
    if ((($jenisusers==2 || $jenisusers==3) && ($pilihan=="daftarnilai" || $pilihan=="" ) ) || ($pilihan=="" && ($jenisusers==0  )  ) ) 
    {
		#echo "lll";exit();
        include( "daftarnilai.php" );
		#include( "nilaikuliah.php" );
    }
    else
    {
		#echo "aaaa";exit();
        if ( $pilihan == "formnilaikosong" )
        {
            if ( $aksi == "" )
            {
                $aksi = "tambahawal";
            }
            if ( isoperator( ) )
            {
                include( "formnilaikosong.php" );
            }
        }
    }
}
?>
