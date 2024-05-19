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
		$arraysubsubmenu[0]['Judul']="Edit Komponen Nilai";
		$arraysubsubmenu[0]['k']=0;
		
	  	$arraysubsubmenu[1]['Judul']="Cari Komponen Nilai";
		$arraysubsubmenu[1]['k']=0;
  }
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
	//if (($jenisusers==1 /* && $konversisemua==0 */) || $jenisusers==0) {
 

		#$arraysubsubmenu[x1]['Judul']="Konversi Nilai";
		$arraysubsubmenu[4]['Judul']="Edit Konversi Nilai";
		$arraysubsubmenu[4]['k']=1;
	}
	if ($jenisusers==0) {
		//$arraysubsubmenu[7]['Judul']="Setting Konversi Nilai";
	}

	if ($jenisusers==0 || $jenisusers==1) {
	#$arraysubsubmenu[x]['Judul']="Nilai Mahasiswa";
  	#$arraysubsubmenu[2]['Judul']="Edit Nilai (Otomatis)";
	#$arraysubsubmenu[2]['k']=2;
	
  	$arraysubsubmenu[101]['Judul']="Edit Nilai (Manual)";
	$arraysubsubmenu[101]['k']=2;
  }

	if ($jenisusers==0) {
  	$arraysubsubmenu[111]['Judul']="Edit Nilai per Mhs";
	$arraysubsubmenu[111]['k']=2;
  	$arraysubsubmenu[112]['Judul']="Waktu Entri Nilai Dosen";
	$arraysubsubmenu[112]['k']=2;
  }
	//$arraysubsubmenu[10]['Judul']="Import Data Nilai DMR";


 

if ($jenisusers==0) {
 
	#$arraysubsubmenu[x2]['Judul']="Laporan";
	$arraysubsubmenu[6]['Judul']="Transfer Nilai SP";
	$arraysubsubmenu[6]['k']=3;
 
 
}
if ($jenisusers==2 || $jenisusers==3) {
 	$arraysubsubmenu[8]['Judul']="Kartu Hasil Studi";
	#$arraysubsubmenu[8][ico]="l";
	$arraysubsubmenu[8]['href']="index.php?pilihan=khs";
	$arraysubsubmenu[8]['t']="B";
	#$arraysubsubmenu[8][ico]=l;
	$arraysubsubmenu[8]['k']=0;

}

//	if ($jenisusers!=2) {
//		$arraysubsubmenu[11]['Judul']="Perkembangan IP Semester";
//	}
	if ($jenisusers==0) {
 
		//$arraysubsubmenu[11]['Judul']="Penanda tangan";
 
		$arraysubsubmenu[8]['Judul']="Kartu Hasil Studi";
		$arraysubsubmenu[8]['href']="index.php?pilihan=khs";
		$arraysubsubmenu[8]['t']="B";
		#$arraysubsubmenu[8][ico]=l;

		#$arraysubsubmenu[8]['k']=3;
		$arraysubsubmenu[8]['k']=3;
 
	}


	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
  	$arraysubsubmenu[0]['href']="index.php?pilihan=ktambah";
  	$arraysubsubmenu[1]['href']="index.php?pilihan=klihat";
  }
	if ($jenisusers==0 || $jenisusers==1) {

  	$arraysubsubmenu[2]['href']="index.php?pilihan=ntambah";
	 $arraysubsubmenu[101]['href']="index.php?pilihan=ntambahm";
  }
	if ($jenisusers==0) {
  	$arraysubsubmenu[111]['href']="index.php?pilihan=editmhs";
  	$arraysubsubmenu[112]['href']="index.php?pilihan=waktunilai";
  }

 
if ($jenisusers==0) {
 
 	$arraysubsubmenu[6]['href']="index.php?pilihan=transfer";
 
 
}

	if ($jenisusers==0) {
 
		//$arraysubsubmenu[11]['href']="index.php?pilihan=penandatangan";
 
 
	}
//	$arraysubsubmenu[10]['href']="index.php?pilihan=importdmr";
//	if ($jenisusers!=2) {
///		$arraysubsubmenu[11]['href']="index.php?pilihan=diagramip";
// 	}

 	

	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
  	$arraysubsubmenu[0]['t']="T";
  	$arraysubsubmenu[1]['t']="B";
  }
	if ($jenisusers==0 || $jenisusers==1) {
    	#$arraysubsubmenu[2]['t']="B";
	   $arraysubsubmenu[101]['t']="B";
  }
	if ($jenisusers==0) {
  	$arraysubsubmenu[111]['t']="B";
  	$arraysubsubmenu[112]['t']="T";
  }
if ($jenisusers==0) {
 
 
 	$arraysubsubmenu[6]['t']="T";
 
 
}

	if ($jenisusers==0) {
 
		//$arraysubsubmenu[11]['t']="T";
 
 
	}
//	$arraysubsubmenu[10]['t']="T";
//	if ($jenisusers!=2) {
//		$arraysubsubmenu[11]['t']="B";
//	}	
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
//	if (($jenisusers==1 /*&& $konversisemua==0*/) || $jenisusers==0) {
		$arraysubsubmenu[4]['href']="index.php?pilihan=ptambah";
		#$arraysubsubmenu[x1]['t']="T";
		$arraysubsubmenu[4]['t']="T";
	}
	if ($jenisusers==0) {
		//$arraysubsubmenu[7]['t']="T";
		//$arraysubsubmenu[7]['href']="index.php?pilihan=konfigkonversi";
	}

	if ($jenisusers==0) {
	#$arraysubsubmenu[x]['t']="T";
	#$arraysubsubmenu[x2]['t']="B";
 
	}




///////// IKON ////

 	
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
  	#$arraysubsubmenu[0][ico]=t;
  	#$arraysubsubmenu[1][ico]=c;
  }
	if ($jenisusers==0 || $jenisusers==1) {

  	#$arraysubsubmenu[2][ico]=u;
	# $arraysubsubmenu[101][ico]=u;
  }
	if ($jenisusers==0) {
  	#$arraysubsubmenu[111][ico]=u;
  	#$arraysubsubmenu[112][ico]=to;
  }
if ($jenisusers==0) {
 
 
 	#$arraysubsubmenu[6][ico]=to;
 
 
}

	if ($jenisusers==0) {
 
		//$arraysubsubmenu[11][ico]=to;
 
 
	}
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
 //	if (($jenisusers==1 /*&& $konversisemua==0*/) || $jenisusers==0) {
 		#$arraysubsubmenu[4][ico]=u;
	}
	if ($jenisusers==0) {
		//$arraysubsubmenu[7][ico]=to;
 	}

	$kodemenu="F5";
	$judulsubmenu="Komponen Nilai (SP)";

?>
