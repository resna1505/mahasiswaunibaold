<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
#echo getaturan( "APPROVEBEASISWA" )."KK".$jenisusers.$_SESSION['jeniss'].$_SESSION['users'];
#print_r($_SESSION);
#echo $jeniss;
#getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1 && $_SESSION['users']=='admin'
if ( isoperator( ) )
{
    if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
    {
        #$arraysubmenu[109][Judul] = "Registrasi Mhs baru";
        #$arraysubmenu[109][href] = "index.php?pilihan=daftarulang";
        #$arraysubmenu[109][t] = "T";
        #$arraysubmenu[109][ico] = u;
    }
	
	if ( getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1 && ($_SESSION['users']=='elly123'))	
	{
        $arraysubmenu[19][Judul] = "Approve Beasiswa";
        $arraysubmenu[19][href] = "index.php?pilihan=approvebeasiswa";
        $arraysubmenu[19][t] = "T";
        $arraysubmenu[19][ico] = to;
		
		$arraysubmenu[13][Judul] = "Cari Beasiswa";
		$arraysubmenu[13][href] = "index.php?pilihan=lihatbeasiswa";
		$arraysubmenu[13][t] = "T";
		$arraysubmenu[13][ico] = to;	
			
			
    }
	else{
			/*if ( getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1 && $_SESSION['users']=='admin')
			{
			
				$arraysubmenu[17][Judul] = "Approve Beasiswa";
				$arraysubmenu[17][href] = "index.php?pilihan=approvebeasiswa";
				$arraysubmenu[17][t] = "T";
				$arraysubmenu[17][ico] = to;
				
				$arraysubmenu[13][Judul] = "Cari Beasiswa";
				$arraysubmenu[13][href] = "index.php?pilihan=lihatbeasiswa";
				$arraysubmenu[13][t] = "T";
				$arraysubmenu[13][ico] = to;	
					
					
			}*/	
			$arraysubmenu[6][Judul] = "Impor Pembayaran";
			$arraysubmenu[14][Judul] = "Entri Pembayaran";
			$arraysubmenu[14][href] = "index.php?pilihan=bayarbatam";
			$arraysubmenu[14][t] = "T";
			$arraysubmenu[14][ico] = t;
			$arraysubmenu[4][Judul] = "Cari Pembayaran";
			$arraysubmenu[5][Judul] = "Laporan";
			#$arraysubmenu[xb][Judul] = "Beasiswa";
			$arraysubmenu[12][Judul] = "Tambah Beasiswa";
			$arraysubmenu[13][Judul] = "Cari Beasiswa";
			
			#$arraysubmenu[xc][Judul] = "Tagihan";
			$arraysubmenu[18][Judul] = "Impor Rekening S1";
			$arraysubmenu[18][href] = "index.php?pilihan=imporbank";
			$arraysubmenu[18][t] = "T";
			$arraysubmenu[18][ico] = to;
			
			$arraysubmenu[20][Judul] = "Impor Rekening S2";
			$arraysubmenu[20][href] = "index.php?pilihan=imporbank2";
			$arraysubmenu[20][t] = "T";
			$arraysubmenu[20][ico] = to;
			
			#$arraysubmenu[19][Judul] = "Cari Rekening Koran";
			#$arraysubmenu[19][href] = "index.php?pilihan=lihatrekeningkoran";
			#$arraysubmenu[19][t] = "B";
			#$arraysubmenu[19][ico] = to;
			
			/*$arraysubmenu[20][Judul] = "Impor Rekening Lain";
			$arraysubmenu[20][href] = "index.php?pilihan=imporbanklain";
			$arraysubmenu[20][t] = "T";
			$arraysubmenu[20][ico] = to;
			
			$arraysubmenu[21][Judul] = "Cari Rekening Lain";
			$arraysubmenu[21][href] = "index.php?pilihan=lihatrekeninglain";
			$arraysubmenu[21][t] = "B";
			$arraysubmenu[21][ico] = to;*/
			
			$arraysubmenu[15][Judul] = "Setting Cicilan Tagihan";
			$arraysubmenu[15][href] = "index.php?pilihan=settingcicilantagihan";
			$arraysubmenu[15][t] = "T";
			$arraysubmenu[15][ico] = to;
			$arraysubmenu[16][Judul] = "Buat Tagihan S1";
			$arraysubmenu[16][href] = "index.php?pilihan=buattagihan";
			$arraysubmenu[16][t] = "T";
			$arraysubmenu[16][ico] = to;
			
			$arraysubmenu[17][Judul] = "Buat Tagihan S2";
			$arraysubmenu[17][href] = "index.php?pilihan=buattagihan2";
			$arraysubmenu[17][t] = "T";
			$arraysubmenu[17][ico] = to;
			
			#$arraysubmenu[x][Judul] = "Data Dasar";
			$arraysubmenu[0][Judul] = "Biaya Komponen";
			$arraysubmenu[1][Judul] = "Tambah Komponen ";
			$arraysubmenu[2][Judul] = "Update Komponen ";
			$arraysubmenu[7][Judul] = "Kalender keuangan";
			$arraysubmenu[0][href] = "index.php?pilihan=biaya";
			$arraysubmenu[1][href] = "index.php?pilihan=mtambah";
			$arraysubmenu[2][href] = "index.php?pilihan=mlihat";
			$arraysubmenu[4][href] = "index.php?pilihan=lihatbayar";
			$arraysubmenu[5][href] = "index.php?pilihan=laporan";
			$arraysubmenu[6][href] = "index.php?pilihan=impor";
			$arraysubmenu[7][href] = "index.php?pilihan=waktukeuangan";
			$arraysubmenu[12][href] = "index.php?pilihan=beasiswa";
			$arraysubmenu[13][href] = "index.php?pilihan=lihatbeasiswa";
			$arraysubmenu[0][t] = "T";
			$arraysubmenu[1][t] = "T";
			$arraysubmenu[2][t] = "T";
			$arraysubmenu[4][t] = "";
			$arraysubmenu[5][t] = "B";
			$arraysubmenu[6][t] = "T";
			$arraysubmenu[7][t] = "T";
			$arraysubmenu[12][t] = "T";
			$arraysubmenu[13][t] = "T";
			#$arraysubmenu[x][t] = "T";
			$arraysubmenu[0][ico] = to;
			$arraysubmenu[1][ico] = to;
			$arraysubmenu[2][ico] = to;
			$arraysubmenu[4][ico] = cu;
			$arraysubmenu[5][ico] = l;
			$arraysubmenu[6][ico] = to;
			$arraysubmenu[7][ico] = to;
			$arraysubmenu[12][ico] = to;
			$arraysubmenu[13][ico] = to;
			if ( $STEIINDONESIA == 1 )
			{
				$arraysubmenu[x2][Judul] = "STEI INDONESIA";
				$arraysubmenu[8][Judul] = "TAMBAH DEPOSIT";
				$arraysubmenu[8][href] = "index.php?pilihan=dtambah";
				$arraysubmenu[8][t] = "T";
				$arraysubmenu[8][ico] = t;
				$arraysubmenu[9][Judul] = "LIHAT DEPOSIT";
				$arraysubmenu[9][href] = "index.php?pilihan=dlihat";
				$arraysubmenu[9][t] = "B";
				$arraysubmenu[9][ico] = cu;
				$arraysubmenu[10][Judul] = "PEMAKAIAN DEPOSIT";
				$arraysubmenu[10][href] = "index.php?pilihan=dpakai";
				$arraysubmenu[10][t] = "B";
				$arraysubmenu[10][ico] = to;
				$arraysubmenu[11][Judul] = "SISA DEPOSIT";
				$arraysubmenu[11][href] = "index.php?pilihan=dsisa";
				$arraysubmenu[11][t] = "B";
				$arraysubmenu[11][ico] = u;
				$arraysubmenu[x3][Judul] = "BIAYA SKS";
				$arraysubmenu[6][Judul] = "TAMBAH BIAYA SKS";
				$arraysubmenu[6][href] = "index.php?pilihan=btambah";
				$arraysubmenu[6][t] = "T";
				$arraysubmenu[7][Judul] = "LIHAT BIAYA SKS";
				$arraysubmenu[7][href] = "index.php?pilihan=blihat";
				$arraysubmenu[7][t] = "B";
				$arraysubmenu[7][ico] = cu;
			}
			
			if ( (getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1) && ($_SESSION['users']=='admin' || $_SESSION['users']=='fariz02' || $_SESSION['users']=='Mercy01'))
			{
			
				$arraysubmenu[19][Judul] = "Approve Beasiswa";
				$arraysubmenu[19][href] = "index.php?pilihan=approvebeasiswa";
				$arraysubmenu[19][t] = "T";
				$arraysubmenu[19][ico] = to;
				
				/*$arraysubmenu[13][Judul] = "Cari Beasiswa";
				$arraysubmenu[13][href] = "index.php?pilihan=lihatbeasiswa";
				$arraysubmenu[13][t] = "T";
				$arraysubmenu[13][ico] = to;*/	
					
					
			}
		}
		if ( $jenisusers == 3 || $jenisusers == 2 )
		{
			$arraysubmenu[4][Judul] = "Cari Pembayaran";
			$arraysubmenu[4][href] = "index.php?pilihan=lihatbayar";
			$arraysubmenu[4][ico] = cu;
			$arraysubmenu[5][Judul] = "Laporan";
			$arraysubmenu[5][href] = "index.php?pilihan=laporan";
			$arraysubmenu[5][t] = "B";
			$arraysubmenu[5][ico] = l;
		}
		
			
	}
$kodemenu = "F9";
$judulsubmenu = "Keuangan Mhs";
?>
