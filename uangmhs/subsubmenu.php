<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#print_r($_SESSION);
periksaroot();
if($_SESSION['users']=='annisa01' || $_SESSION['users']=='admin' || $_SESSION['users']=='verif01' || $_SESSION['users']=='verif02' || $_SESSION['users']=='Mercy01' || $_SESSION['users']=='ferani' || $_SESSION['users']=='lilys'){
$arraysubsubmenu[6]['Judul'] = "Impor VA Mandiri";
$arraysubsubmenu[6]['k'] = 0;
$arraysubsubmenu[6]['href'] = "index.php?pilihan=imporbankvamandiri";
$arraysubsubmenu[6]['t'] = "T";
#$arraysubmenu[6][ico] = to;
#$arraysubsubmenu[6]['Judul'] = "Impor Pembayaran VA Mandiri";
#$arraysubsubmenu[6]['k'] = 0;
#$arraysubsubmenu[6]['href'] = "index.php?pilihan=bayarbatam";
#$arraysubsubmenu[6]['t'] = "T";
#$arraysubmenu[6][ico] = to;
$arraysubsubmenu[7]['Judul'] = "Impor VA BNI";
$arraysubsubmenu[7]['k'] = 0;
$arraysubsubmenu[7]['href'] = "index.php?pilihan=imporbankvabni";
$arraysubsubmenu[7]['t'] = "T";
#$arraysubmenu[7][ico] = to;
$arraysubsubmenu[8]['Judul'] = "Entri Pembayaran";
$arraysubsubmenu[8]['k'] = 0;
$arraysubsubmenu[8]['href'] = "index.php?pilihan=bayarbatam";
$arraysubsubmenu[8]['t'] = "T";
#$arraysubmenu[7][ico] = to;
}
$arraysubsubmenu[4]['Judul'] = "Cari Pembayaran";
$arraysubsubmenu[4]['k'] = 0;
$arraysubsubmenu[4]['href'] = "index.php?pilihan=lihatbayar";
$arraysubsubmenu[4]['t'] = "B";
#$arraysubmenu[4][ico] = to;

$arraysubsubmenu[0]['Judul'] = "Biaya Komponen";
$arraysubsubmenu[1]['Judul'] = "Tambah Komponen ";
$arraysubsubmenu[2]['Judul'] = "Update Komponen ";
$arraysubsubmenu[3]['Judul'] = "Data Credential Komponen ";
$arraysubsubmenu[0]['k'] = 1;
$arraysubsubmenu[1]['k'] = 1;
$arraysubsubmenu[2]['k'] = 1;
$arraysubsubmenu[3]['k'] = 1;
$arraysubsubmenu[0]['href'] = "index.php?pilihan=biaya";
$arraysubsubmenu[1]['href'] = "index.php?pilihan=mtambah";
$arraysubsubmenu[2]['href'] = "index.php?pilihan=mlihat";
$arraysubsubmenu[3]['href'] = "index.php?pilihan=mlihat2";
$arraysubsubmenu[0]['t'] = "T";
$arraysubsubmenu[1]['t'] = "T";
$arraysubsubmenu[2]['t'] = "T";
$arraysubsubmenu[3]['t'] = "T";
#$arraysubmenu[0][ico] = to;
#$arraysubmenu[1][ico] = to;
#$arraysubmenu[2][ico] = to;

$arraysubsubmenu[15]['Judul'] = "Setting Cicilan Tagihan";
$arraysubsubmenu[16]['Judul'] = "Buat Tagihan VA Mandiri";
$arraysubsubmenu[17]['Judul'] = "Koreksi Tagihan VA Mandiri";
$arraysubsubmenu[25]['Judul'] = "Buat Tagihan VA BNI";
$arraysubsubmenu[26]['Judul'] = "Koreksi Tagihan VA BNI";
$arraysubsubmenu[27]['Judul'] = "Kirim Tagihan VA BNI";
$arraysubsubmenu[28]['Judul'] = "Inquiry Tagihan VA BNI";
$arraysubsubmenu[15]['k'] = 2;
$arraysubsubmenu[16]['k'] = 2;
$arraysubsubmenu[17]['k'] = 2;
$arraysubsubmenu[25]['k'] = 2;
$arraysubsubmenu[26]['k'] = 2;
$arraysubsubmenu[27]['k'] = 2;
$arraysubsubmenu[28]['k'] = 2;
$arraysubsubmenu[15]['href'] = "index.php?pilihan=settingcicilantagihan";
$arraysubsubmenu[16]['href'] = "index.php?pilihan=buattagihanvamandiri";
$arraysubsubmenu[17]['href'] = "index.php?pilihan=koreksitagihanvamandiri";
$arraysubsubmenu[25]['href'] = "index.php?pilihan=buattagihanvabni";
$arraysubsubmenu[26]['href'] = "index.php?pilihan=koreksitagihanvabni";
$arraysubsubmenu[27]['href'] = "index.php?pilihan=kirimtagihanvabni";
$arraysubsubmenu[28]['href'] = "index.php?pilihan=inquirytagihanvabni";
$arraysubsubmenu[15]['t'] = "T";
$arraysubsubmenu[16]['t'] = "T";
$arraysubsubmenu[17]['t'] = "T";
$arraysubsubmenu[25]['t'] = "T";
$arraysubsubmenu[26]['t'] = "T";
$arraysubsubmenu[27]['t'] = "T";
$arraysubsubmenu[28]['t'] = "T";
#$arraysubsubmenu[15][ico] = to;
#$arraysubsubmenu[16][ico] = to;
#$arraysubsubmenu[17][ico] = to;

#if($_SESSION['users']=='annisa01' || $_SESSION['users']=='admin' || $_SESSION['users']=='verif01' || $_SESSION['users']=='verif02'){

#$arraysubsubmenu[18]['Judul'] = "Impor Rekening S1";
#$arraysubsubmenu[20]['Judul'] = "Impor Rekening S2";
#$arraysubsubmenu[21]['Judul'] = "Impor VA BNI";
#$arraysubsubmenu[24]['Judul'] = "Impor VA Mandiri";
#$arraysubsubmenu[18]['k'] = 3;
#$arraysubsubmenu[20]['k'] = 3;
#$arraysubsubmenu[21]['k'] = 3;
#$arraysubsubmenu[24]['k'] = 3;
#$arraysubsubmenu[18]['href'] = "index.php?pilihan=imporbank";
#$arraysubsubmenu[20]['href'] = "index.php?pilihan=imporbank2";
#$arraysubsubmenu[21]['href'] = "index.php?pilihan=imporbankva";
#$arraysubsubmenu[24]['href'] = "index.php?pilihan=imporvamandiri";
#$arraysubsubmenu[24]['t'] = "T";
#$arraysubsubmenu[24][ico] = to;

#$arraysubsubmenu[18]['t'] = "T";
#$arraysubsubmenu[18][ico] = to;
#}
			
if ( isoperator( ) )
{
    if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
    {
        #$arraysubmenu[109]['Judul'] = "Registrasi Mhs baru";
        #$arraysubmenu[109]['href'] = "index.php?pilihan=daftarulang";
        #$arraysubmenu[109]['t'] = "T";
        #$arraysubmenu[109][ico] = u;
    }
	
	if ( getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1 && ($_SESSION['users']=='elly123'))	
	{
		
        $arraysubsubmenu[19]['Judul'] = "Approve Beasiswa";
        $arraysubsubmenu[19]['href'] = "index.php?pilihan=approvebeasiswa";
		$arraysubsubmenu[19]['k'] = 4;
        $arraysubsubmenu[19]['t'] = "T";
        #$arraysubsubmenu[19][ico] = to;
		
		$arraysubsubmenu[13]['Judul'] = "Cari Beasiswa";
		$arraysubsubmenu[13]['href'] = "index.php?pilihan=lihatbeasiswa";
		$arraysubsubmenu[13]['k'] = 4;
		$arraysubsubmenu[13]['t'] = "T";
		#$arraysubsubmenu[13][ico] = to;	
			
			
    }
	else{
			
			
			if ( $STEIINDONESIA == 1 )
			{
				$arraysubmenu[x2]['Judul'] = "STEI INDONESIA";
				$arraysubmenu[8]['Judul'] = "TAMBAH DEPOSIT";
				$arraysubmenu[8]['href'] = "index.php?pilihan=dtambah";
				$arraysubmenu[8]['t'] = "T";
				#$arraysubmenu[8][ico] = t;
				$arraysubmenu[9]['Judul'] = "LIHAT DEPOSIT";
				$arraysubmenu[9]['href'] = "index.php?pilihan=dlihat";
				$arraysubmenu[9]['t'] = "B";
				#$arraysubmenu[9][ico] = cu;
				$arraysubmenu[10]['Judul'] = "PEMAKAIAN DEPOSIT";
				$arraysubmenu[10]['href'] = "index.php?pilihan=dpakai";
				$arraysubmenu[10]['t'] = "B";
				#$arraysubmenu[10][ico] = to;
				$arraysubmenu[11]['Judul'] = "SISA DEPOSIT";
				$arraysubmenu[11]['href'] = "index.php?pilihan=dsisa";
				$arraysubmenu[11]['t'] = "B";
				#$arraysubmenu[11][ico] = u;
				$arraysubmenu[x3]['Judul'] = "BIAYA SKS";
				$arraysubmenu[6]['Judul'] = "TAMBAH BIAYA SKS";
				$arraysubmenu[6]['href'] = "index.php?pilihan=btambah";
				$arraysubmenu[6]['t'] = "T";
				$arraysubmenu[7]['Judul'] = "LIHAT BIAYA SKS";
				$arraysubmenu[7]['href'] = "index.php?pilihan=blihat";
				$arraysubmenu[7]['t'] = "B";
				#$arraysubmenu[7][ico] = cu;
			}
			
			$arraysubsubmenu[12]['Judul'] = "Tambah Beasiswa";
			$arraysubsubmenu[13]['Judul'] = "Cari Beasiswa";
			#$arraysubsubmenu[19]['Judul'] = "Approve Beasiswa";
			$arraysubsubmenu[12]['k'] = 4;
			$arraysubsubmenu[13]['k'] = 4;
			#$arraysubsubmenu[19]['k'] = 4;
			$arraysubsubmenu[12]['href'] = "index.php?pilihan=beasiswa";
			$arraysubsubmenu[13]['href'] = "index.php?pilihan=lihatbeasiswa";
			#$arraysubsubmenu[19]['href'] = "index.php?pilihan=approvebeasiswa";
			$arraysubsubmenu[12]['t'] = "T";
			$arraysubsubmenu[13]['t'] = "T";
			#$arraysubsubmenu[19]['t'] = "T";
			#$arraysubsubmenu[12][ico] = to;
			#$arraysubsubmenu[13][ico] = to;
			#$arraysubsubmenu[19][ico] = to;
			
			if ( (getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1) && ($_SESSION['users']=='admin' || $_SESSION['users']=='fariz02' || $_SESSION['users']=='Mercy01'))
			{
			
				$arraysubsubmenu[19]['Judul'] = "Approve Beasiswa";
				$arraysubsubmenu[19]['href'] = "index.php?pilihan=approvebeasiswa";
				$arraysubsubmenu[19]['k'] = 4;
				$arraysubsubmenu[19]['t'] = "T";
				#$arraysubsubmenu[19][ico] = to;
				
				/*$arraysubmenu[13]['Judul'] = "Cari Beasiswa";
				$arraysubmenu[13]['href'] = "index.php?pilihan=lihatbeasiswa";
				$arraysubmenu[13]['t'] = "T";
				$arraysubmenu[13][ico] = to;*/	
					
					
			}
		}
		if ( $jenisusers == 3 || $jenisusers == 2 )
		{
			$arraysubmenu[4]['Judul'] = "Cari Pembayaran";
			$arraysubmenu[4]['href'] = "index.php?pilihan=lihatbayar";
			#$arraysubmenu[4][ico] = cu;
			$arraysubmenu[5]['Judul'] = "Laporan";
			$arraysubmenu[5]['href'] = "index.php?pilihan=laporan";
			$arraysubmenu[5]['t'] = "B";
			#$arraysubmenu[5][ico] = l;
		}
		
			
	}
#$kodemenu = "F9";
#$judulsubmenu = "Keuangan Mhs";
?>
