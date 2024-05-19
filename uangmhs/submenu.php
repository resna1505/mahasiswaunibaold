<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();

if ( isoperator( ) )
{
	if ( getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1 && ($_SESSION['users']=='elly123'))	
	{
		$arraysubmenu[4]['Judul'] = "Beasiswa";
		$arraysubmenu[4]['t'] = "B";
		$arraysubmenu[4]['k']=4;
	
	}else{
		#
			$arraysubmenu[0]['Judul'] = "Pembayaran";
			$arraysubmenu[0]['t'] = "B";
			$arraysubmenu[0]['k']=0;
		if($_SESSION['users']=='annisa01' || $_SESSION['users']=='admin'){
			#$arraysubmenu[3]['Judul'] = "Impor Rekening";
			#$arraysubmenu[3]['t'] = "B";
			#$arraysubmenu[3]['k']=3;
		}
		$arraysubmenu[1]['Judul'] = "Komponen Pembayaran";
		$arraysubmenu[2]['Judul'] = "Tagihan";
		
		$arraysubmenu[4]['Judul'] = "Beasiswa";
		$arraysubmenu[5]['Judul'] = "Laporan";
		$arraysubmenu[5]['href'] = "index.php?pilihan=laporan";
		#$arraysubmenu[6]['Judul'] = "Kalender Keuangan";
		#$arraysubmenu[6]['href'] = "index.php?pilihan=waktukeuangan";
		#$arraysubmenu[7]['Judul'] = "Proses Status Mahasiswa";
		#$arraysubmenu[7]['href'] = "index.php?pilihan=prosesstatusmahasiswa";
		$arraysubmenu[8]['Judul'] = "Proses Pindah Gelombang";
		$arraysubmenu[8]['href'] = "index.php?pilihan=pindahgelombang";
		$arraysubmenu[9]['Judul'] = "Rekap Nilai Dosen Mahasiswa";
		$arraysubmenu[9]['href'] = "index.php?pilihan=rekapnilaidosenmhs";
					
		#$arraysubmenu[1]['href'] = "index.php?pilihan=dlihat";
		#$arraysubmenu[2]['href'] = "index.php?pilihan=plihat";
		
		$arraysubmenu[1]['t'] = "B";
		$arraysubmenu[2]['t'] = "B";
		
		$arraysubmenu[4]['t'] = "B";
		$arraysubmenu[5]['t'] = "B";
		#$arraysubmenu[6]['t'] = "T";
		#$arraysubmenu[7]['t'] = "T";
		$arraysubmenu[8]['t'] = "T";
		$arraysubmenu[9]['t'] = "B";

		
		$arraysubmenu[1]['k']=1;
		$arraysubmenu[2]['k']=2;
		
		$arraysubmenu[4]['k']=4;
	}
}
$kodemenu = "F9";
$judulsubmenu = "Keuangan Mhs";
?>
