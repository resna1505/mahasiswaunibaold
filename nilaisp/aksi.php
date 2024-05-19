<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $pilihan."apa".$aksi;exit();
periksaroot( );
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
													Nilai SP
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
//else if ( $pilihan == "klihat" || $pilihan == "" && isoperator( ) )
else if ( ( isoperator( ) || isdosen( ) ) && ( $pilihan == "klihat" || $pilihan == "" && isoperator( ) ) )
{
    if ( isoperator( ) || isdosen( ) && getaturan( "EDITKOMPONENNILAIDOSEN" ) == 1 )
    {
        include( "komponen.php" );
    }
}
else if ( $pilihan == "ntambah" || $pilihan == "" && isdosen( ) )
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
    if ( isoperator( ) || isdosen( ) )
    {
        include( "nilai.php" );
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
	#echo "aaaa";exit();
    if ( isoperator( ) || ismahasiswa( ) || iswali( ) )
    {
        include( "khs.php" );
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
else if ( $pilihan == "cetakijazah" )
{
    if ( isoperator( ) )
    {
        include( "cetakijazah.php" );
    }
}
else if ( $pilihan == "transfer" )
{
    if ( isoperator( ) )
    {
        include( "transfernilai.php" );
    }
}
else if ( $pilihan == "waktunilai" )
{
    if ( isoperator( ) )
    {
        include( "waktunilai.php" );
    }
}
else
{
    if ( $pilihan == "waktunilaiumum" )
    {
        if ( isoperator( ) )
        {
            include( "waktunilaiumum.php" );
        }
    }
    else
    {
        if ( $pilihan == "waktunilaiprodi" && isoperator( ) )
        {
            include( "waktunilaiprodi.php" );
        }
    }
}
/*periksaroot();
///////////////////////////////////////////////////

if ($pilihan=="ktambah") {
	if ($aksi=="") {
		$aksi="tambahawal";
	}
	if (isoperator() || (isdosen() && getaturan("EDITKOMPONENNILAIDOSEN")==1) ) include "komponen.php";
}	elseif ($pilihan=="klihat"  || ( $pilihan=="" && isoperator())  ) {
	if (isoperator() || (isdosen() && getaturan("EDITKOMPONENNILAIDOSEN")==1) ) include "komponen.php";
}  elseif ($pilihan=="ntambah" ||  ($pilihan =="" && isdosen()) ) {
	if ($aksi=="") {
		$aksi="tambahawal";
	}
	if (isoperator() || isdosen() ) include "nilai.php";
}  elseif ($pilihan=="ntambahm") {
	if ($aksi=="") {
		$aksi="tambahawal";
	}
	if (isoperator() || isdosen()) include "nilai.php";
}  elseif ($pilihan=="editmhs") {
	if ($aksi=="") {
		$aksi="tambahawalm";
	}
	if (isoperator() || isdosen() ) include "nilai.php";
}	elseif ($pilihan=="transkrip") {
 	if (isoperator()) include "transkrip.php";
}  elseif ($pilihan=="ptambah") {
 	if (isoperator() || (isdosen() && getaturan("EDITKOMPONENNILAIDOSEN")==1) ) include "konversi.php";
}	elseif ($pilihan=="ipk") {
	if (isoperator()) include "rekaptranskrip.php";
}	elseif ($pilihan=="nilai") {
	if (isoperator()) include "rekapnilai.php";
}	elseif ($pilihan=="konfigkonversi") {
	if (isoperator()) include "konfigkonversi.php";
}	elseif ($pilihan=="khs" || $pilihan=="" ) {
 	if (isoperator() || ismahasiswa() || iswali()) include "khs.php";
}	elseif ($pilihan=="konfigpredikat") {
	if (isoperator()) include "konfigpredikat.php";
}	elseif ($pilihan=="penandatangan") {
	if (isoperator()) include "ttd.php";
}	elseif ($pilihan=="importdmr") {
	if ($aksi=="") {
		$aksi="tambahawal";
	}
 	if (isoperator()) include "importdmr.php";
}	elseif ($pilihan=="diagramip") {
	if (isoperator()) include "diagramipsemester.php";
}	elseif ($pilihan=="laporan") {
	if (isoperator()) include "laporan.php";
}	elseif ($pilihan=="laporan1") {
	if (isoperator()) include "rekapipk.php";
}	elseif ($pilihan=="laporan2") {
	if (isoperator()) include "rekapips.php";
}	elseif ($pilihan=="setingijazah") {
  if (isoperator()) 	include "setingijazah.php";
}	elseif ($pilihan=="cetakijazah") {
	if (isoperator()) include "cetakijazah.php";
}	elseif ($pilihan=="transfer") {
	if (isoperator()) include "transfernilai.php";
}	elseif ($pilihan=="waktunilai") {
	if (isoperator()) include "waktunilai.php";
}	elseif ($pilihan=="waktunilaiumum") {
	if (isoperator()) include "waktunilaiumum.php";
}	elseif ($pilihan=="waktunilaiprodi") {
	if (isoperator()) include "waktunilaiprodi.php";
}*/
 ////////////////////////////////////////////////////
?>
