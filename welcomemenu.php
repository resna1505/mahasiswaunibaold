<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $pilihan == "" )
{
    $pilihan = "berita";
    $REQUEST_URI .= "?pilihan=berita";
}
$arraymenu[0]['Judul'] = "Berita dan Pengumuman";
$arraymenu[1]['Judul'] = "Jadwal Kuliah";
$arraymenu[2]['Judul'] = "Forum";
$arraymenu[3]['Judul'] = "Layar Sentuh";
$arraymenu[0]['href'] = "index.php?pilihan=berita";
$arraymenu[1]['href'] = "index.php?pilihan=jadwal";
$arraymenu[2]['href'] = "index.php?pilihan=forum";
$arraymenu[3]['href'] = "index2.php?pilihan=forum";
$jumlahmenu = count( $arraymenu );
//echo "\r\n    <!-- Begin Navigasi --><div><img src=\"gambar/uniba.png\" width=\"60\" height=\"54\"></div><div align=\"center\" style=\"margin-top:-40px;font-size:17px;\">";
//echo "<div align=center>";
//echo "Selamat Datang di Academic Management System";
//echo "</div>";
//echo "\r\n <div style=\"margin-top:-33px;float:right;\"><img src=\"gambar/uniba.png\" width=\"60\" height=\"54\"></div>";
#echo "<li>Selamat Datang di Sistem Informasi Manajemen Akademik Universitas Batam</li><li>Selamat Datang di Sistem Informasi Manajemen Akademik Universitas Batam</li>";
#echo "\r\n    </ul></div>";
#echo "\r\n    </ul><p class=\"datepresent\">";
#include( $root."tampilan/siteheaderclock.php" );
#echo "</p></div><!-- End Navigasi --> ";
?>
<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<div align="center"><br><img src="gambar/logo-uniba.png" width="100px" height="100px" align="center"></div>
			<!-- END LOGO -->
		</div>
	</div>
	<br>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu" style="margin-top:50px;">
	<?php
	//printmesg( $errmesg );
echo "<br><div style=\"margin-left:10px;width:44%;height:100%;\"><marquee width='1330px' behavior='alternate' ><font color=#ffffff>Diberitahukan kepada seluruh user untuk mengganti password secara berkala</font></marquee><br>" ; 
echo "</div>";
?>
		<div class="container-fluid">
			<!-- BEGIN HEADER SEARCH BOX -->
			
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					
						</ul>
					</li>
					
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
