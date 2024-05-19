<?php 
periksaroot();
	$konversisemua=0;
	@$konf=file("konfig");
	if (is_array($konf)) {
		if (trim($konf[0])=="0") {
			$konversisemua=0;
		} else {
			$konversisemua=1;
		} 
	}
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
	//if ($jenisusers==0 || $jenisusers==1) {
		$arraysubmenu[0]['Judul']="Komponen Nilai";
		$arraysubmenu[1]['Judul']="Konversi Nilai";
		#$arraysubmenu[0]['href']="index.php?pilihan=klihat";
		#$arraysubmenu[1]['href']="index.php?pilihan=ptambah";
		$arraysubmenu[0]['t'] = "B";
		$arraysubmenu[1]['t'] = "T";
		$arraysubmenu[0]['k'] = 0;
		$arraysubmenu[1]['k'] = 1;
	}
	
	if ($jenisusers==2){
	
		$arraysubmenu[0]['Judul']="Komponen Nilai";
		#$arraysubmenu[0]['href']="index.php?pilihan=klihat";
		$arraysubmenu[0]['t'] = "B";
		$arraysubmenu[0]['k'] = 0;
			
	}
	

	if ($jenisusers==0 || $jenisusers==1) {
		$arraysubmenu[2]['Judul']="Nilai Mahasiswa";
		#$arraysubmenu[2]['href']="index.php?pilihan=editmhs";
		$arraysubmenu[2]['t'] = "T";
		$arraysubmenu[2]['k'] = 2;
  }

	if ($jenisusers==0) {
		$arraysubmenu[3]['Judul']="Laporan";
		#$arraysubmenu[3]['href']="index.php?pilihan=transfer";
		$arraysubmenu[3]['t'] = "B";
		$arraysubmenu[3]['k'] = 3;

  }
  
		
		
		
 $kodemenu = "F5";
$judulsubmenu = "Komponen Nilai (SP)";
?>
