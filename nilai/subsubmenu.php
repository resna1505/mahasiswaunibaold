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
  
  
  	    $arraysubsubmenu[0]['Judul']="Edit Komponen Nilai";
	  	$arraysubsubmenu[1]['Judul']="Cari Komponen Nilai";
		$arraysubsubmenu[0]['k'] = 0;
		$arraysubsubmenu[1]['k'] = 0;
		$arraysubsubmenu[0]['href']="index.php?pilihan=ktambah";
		$arraysubsubmenu[1]['href']="index.php?pilihan=klihat";
		$arraysubsubmenu[0]['t']="T";
		$arraysubsubmenu[1]['t']="B";
	}
	
	if ($jenisusers==0) {
 	  $arraysubsubmenu[106]['Judul']="Komponen Default";
	  $arraysubsubmenu[106]['k'] = 0;
	  $arraysubsubmenu[106]['href']="index.php?pilihan=komponendefault";
	  $arraysubsubmenu[106]['t']="T";
	}

//	if (($jenisusers==1 /*&& $konversisemua==0*/) || $jenisusers==0) {
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
		#$arraysubsubmenu[x1]['Judul']="Konversi Nilai";
		$arraysubsubmenu[4]['Judul']="Edit Konversi Nilai";
		$arraysubsubmenu[4]['k']=1;
		$arraysubsubmenu[4]['href']="index.php?pilihan=ptambah";
		#$arraysubsubmenu[x1]['t']="T";
		$arraysubsubmenu[4]['t']="T";
	}
	if ($jenisusers==0) {
		//$arraysubsubmenu[7]['Judul']="Setting Konversi";
	}


	if ($jenisusers==0 || $jenisusers==1) {

		#$arraysubsubmenu[x]['Judul']="Nilai Mahasiswa";
		#$arraysubsubmenu[2]['Judul']="Edit Nilai (Otomatis)";
		$arraysubsubmenu[101]['Judul']="Edit Nilai (Manual)";	
		#$arraysubsubmenu[2]['k']=2;
		$arraysubsubmenu[101]['k']=2;
		$arraysubsubmenu[2]['href']="index.php?pilihan=ntambah";
		#$arraysubsubmenu[2]['t']="B";
		$arraysubsubmenu[101]['href']="index.php?pilihan=ntambahm";
		$arraysubsubmenu[101]['t']="B";
	}
	if ($jenisusers==0) {

	
		$arraysubsubmenu[111]['Judul']="Edit Nilai per Mhs";

		$arraysubsubmenu[111]['k']=2;
      
		$arraysubsubmenu[112]['Judul']="Waktu Entri Nilai Dosen";
		$arraysubsubmenu[112]['k']=2;
		
		$arraysubsubmenu[111]['href']="index.php?pilihan=editmhs";
		$arraysubsubmenu[111]['t']="B";
		
		$arraysubsubmenu[112]['href']="index.php?pilihan=waktunilai";
		$arraysubsubmenu[112]['t']="T";
		
		$arraysubsubmenu[109]['Judul'] = "Edit Nilai Ujian Akhir";
		$arraysubsubmenu[109]['k']=2;
		$arraysubsubmenu[109]['href'] = "index.php?pilihan=ujianakhir";
		$arraysubsubmenu[109]['t'] = "T";
		#$arraysubsubmenu[109][ico] = u;

	}
	
	//$arraysubsubmenu[10]['Judul']="Import Data Nilai DMR";


if ($jenisusers==0) {
	#$arraysubsubmenu[x2]['Judul']="Laporan";
	$arraysubsubmenu[105]['Judul']="Proses IPS/IPK";
	$arraysubsubmenu[3]['Judul']="Transkrip Nilai";
	$arraysubsubmenu[105]['k']=3;
	$arraysubsubmenu[3]['k']=3;
	
	$arraysubsubmenu[105]['href']="index.php?pilihan=prosesipk";
	$arraysubsubmenu[105]['t']="T";
	$arraysubsubmenu[3]['href']="index.php?pilihan=transkrip";
	$arraysubsubmenu[3]['t']="B";
}

if ($jenisusers==2 || $jenisusers==3) {
	$arraysubsubmenu[8]['Judul']="Kartu Hasil Studi";
	$arraysubsubmenu[8]['href']="index.php?pilihan=khs";
	$arraysubsubmenu[8]['t']="B";
	#$arraysubsubmenu[8][ico]=l;

	#$arraysubsubmenu[8]['k']=3;
	$arraysubsubmenu[8]['k']=0;
	
}

if ($jenisusers==0) {

	$arraysubsubmenu[8]['Judul']="Kartu Hasil Studi";
	$arraysubsubmenu[8]['href']="index.php?pilihan=khs";
	$arraysubsubmenu[8]['t']="B";
	#$arraysubsubmenu[8][ico]=l;

	#$arraysubsubmenu[8]['k']=3;
	$arraysubsubmenu[8]['k']=3;
	
	$arraysubsubmenu[5]['Judul']="Rekap IP Kumulatif";
	$arraysubsubmenu[6]['Judul']="Rekap Nilai MK";
	$arraysubsubmenu[102]['Judul']="Laporan Rekap Nilai";
	$arraysubsubmenu[104]['Judul']="Cetak Ijazah";
	$arraysubsubmenu[7]['Judul'] = "Rekap Nilai Dosen Mahasiswa";
	
	$arraysubsubmenu[5]['k']=3;
	$arraysubsubmenu[6]['k']=3;
	$arraysubsubmenu[102]['k']=3;
	$arraysubsubmenu[104]['k']=3;
	$arraysubsubmenu[7]['k']=3;
	
	$arraysubsubmenu[5]['href']="index.php?pilihan=ipk";
	$arraysubsubmenu[6]['href']="index.php?pilihan=nilai";
	$arraysubsubmenu[5]['t']="B";
	$arraysubsubmenu[6]['t']="B";
	$arraysubsubmenu[7]['href']="index.php?pilihan=rekapnilaidosenmhs";
	$arraysubsubmenu[7]['t']="B";
	
	$arraysubsubmenu[102]['href']="index.php?pilihan=laporan";
	$arraysubsubmenu[102]['t']="B";
	$arraysubsubmenu[104]['href']="index.php?pilihan=cetakijazah";
	$arraysubsubmenu[104]['t']="T";


	$arraysubsubmenu[9]['Judul']="Predikat Kelulusan";
		$arraysubsubmenu[11]['Judul']="Penanda tangan";
		$arraysubsubmenu[103]['Judul']="Setting Cetak Ijazah";
		$arraysubsubmenu[107]['Judul']="Setting Kop Surat";
		$arraysubsubmenu[110]['Judul'] = "Setting Waktu Cetak Ijazah";
		

		$arraysubsubmenu[9]['k']=4;
		$arraysubsubmenu[11]['k']=4;
		$arraysubsubmenu[103]['k']=4;
		$arraysubsubmenu[107]['k']=4;
		$arraysubsubmenu[110]['k']=4;

		$arraysubsubmenu[9]['href']="index.php?pilihan=konfigpredikat";
		$arraysubsubmenu[9]['t']="T";
		$arraysubsubmenu[11]['href']="index.php?pilihan=penandatangan";
		$arraysubsubmenu[11]['t']="T";
		
		$arraysubsubmenu[103]['href']="index.php?pilihan=setingijazah";
		$arraysubsubmenu[103]['t']="T";
		$arraysubsubmenu[107]['href']="index.php?pilihan=kop";
		
		$arraysubsubmenu[107]['t']="T";
		$arraysubsubmenu[110]['href']="index.php?pilihan=waktuijazah";
		$arraysubsubmenu[110]['t']="T";

}
//	if ($jenisusers!=2) {
//		$arraysubsubmenu[11]['Judul']="Perkembangan IP Semester";
//	}
	/*if ($jenisusers==0) {
		#$arraysubsubmenu[x3]['Judul']="Konfigurasi Lain";
		$arraysubsubmenu[9]['Judul']="Predikat Kelulusan";
		$arraysubsubmenu[11]['Judul']="Penanda tangan";
		$arraysubsubmenu[103]['Judul']="Setting Cetak Ijazah";
		$arraysubsubmenu[107]['Judul']="Setting Kop Surat";
		$arraysubsubmenu[110]['Judul'] = "Setting Waktu Cetak Ijazah";

		$arraysubsubmenu[9]['k']=4;
		$arraysubsubmenu[11]['k']=4;
		$arraysubsubmenu[103]['k']=4;
		$arraysubsubmenu[107]['k']=4;
		$arraysubsubmenu[110]['k']=4;

		$arraysubsubmenu[9]['href']="index.php?pilihan=konfigpredikat";
		$arraysubsubmenu[9]['t']="T";
		$arraysubsubmenu[11]['href']="index.php?pilihan=penandatangan";
		$arraysubsubmenu[11]['t']="T";
		
		$arraysubsubmenu[103]['href']="index.php?pilihan=setingijazah";
		$arraysubsubmenu[103]['t']="T";
		$arraysubsubmenu[107]['href']="index.php?pilihan=kop";
		
		$arraysubsubmenu[107]['t']="T";
		$arraysubsubmenu[110]['href']="index.php?pilihan=waktuijazah";
		$arraysubsubmenu[110]['t']="T";
    
	}*/


	/*if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
   	
  }
	if ($jenisusers==0 || $jenisusers==1) {
		
		
  }
  if ($jenisusers==0) {


	
  	
	   if ($UNIVERSITAS=="UNM") {
    	$arraysubsubmenu[113]['href']="index.php?pilihan=formnilaikosong";
     }
  
  }

if ($jenisusers==0) {
	
	
	
	
	
	
	
	   if ($UNIVERSITAS=="UNM") {
    	$arraysubsubmenu[108]['href']="index.php?pilihan=rekapakademik";
     }
}

	if ($jenisusers==0) {
		
		
		
	}
//	$arraysubsubmenu[10]['href']="index.php?pilihan=importdmr";
//	if ($jenisusers!=2) {
///		$arraysubsubmenu[11]['href']="index.php?pilihan=diagramip";
// 	}

	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
  	#$arraysubsubmenu[0]['t']="T";
  	#$arraysubsubmenu[1]['t']="B";
  } 	
	if ($jenisusers==0 || $jenisusers==1) {
  	
	
  }
  if ($jenisusers==0) {


	
  	
	   if ($UNIVERSITAS=="UNM") {
      	$arraysubsubmenu[113]['t']="B";
      }
  
  }

if ($jenisusers==0) {
	
	
	
	
	
	
	
	   if ($UNIVERSITAS=="UNM") {
    	$arraysubsubmenu[108]['t']="B";
    }
}

	if ($jenisusers==0) {
		
		
		
	}
//	$arraysubsubmenu[10]['t']="T";
//	if ($jenisusers!=2) {
//		$arraysubsubmenu[11]['t']="B";
//	}	
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
//	if (($jenisusers==1 /* && $konversisemua==0 *///) || $jenisusers==0) {
/*		$arraysubsubmenu[4]['href']="index.php?pilihan=ptambah";
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
	#$arraysubsubmenu[x3]['t']="T";
	}




///////////////

 	
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
     #$arraysubsubmenu[0]=u;
   	 #$arraysubsubmenu[1][ico]=c;
  }
	if ($jenisusers==0 || $jenisusers==1) {
  	#$arraysubsubmenu[2][ico]=u;
	 #$arraysubsubmenu[101][ico]=u;
  }
  if ($jenisusers==0) {


	#$arraysubsubmenu[111][ico]=u;
  	#$arraysubsubmenu[112][ico]=to;
	   if ($UNIVERSITAS=="UNM") {
    	#$arraysubsubmenu[113][ico]=l;
    }
  
  }

if ($jenisusers==0) {
	#$arraysubsubmenu[3][ico]=l;
	 #$arraysubsubmenu[5][ico]=l;
	#$arraysubsubmenu[6][ico]=l;
	#$arraysubsubmenu[102][ico]=l;
	#$arraysubsubmenu[104][ico]=l;
	#$arraysubsubmenu[105][ico]=to;
	#$arraysubsubmenu[106][ico]=to;
	#$arraysubsubmenu[107][ico]=to;
	   if ($UNIVERSITAS=="UNM") {
    	#$arraysubsubmenu[108][ico]=l;
    }
}

	if ($jenisusers==0) {
		#$arraysubsubmenu[9][ico]=to;
		#$arraysubsubmenu[11][ico]=to;
		#$arraysubsubmenu[103][ico]=to;
	}
	if ($jenisusers==0 || ($jenisusers==1 && getaturan("EDITKOMPONENNILAIDOSEN")==1  )) {
// 	if (($jenisusers==1 /*&& $konversisemua==0*///) || $jenisusers==0) {
 	/*	$arraysubsubmenu[4][ico]=u;
	}
	if ($jenisusers==0) {
		//$arraysubsubmenu[7][ico]=to;
 	}

	if ($jenisusers==0) {
  	#$arraysubsubmenu[x][ico]="T";
  	#$arraysubsubmenu[x2][ico]="B";
	#$arraysubsubmenu[x3][ico]="T";
	}*/


if ($jenisusers==2 || $jenisusers==3) {
  	$arraysubsubmenu[120]['Judul']="Daftar Nilai Ujian";
	$arraysubsubmenu[120]['href']="index.php?pilihan=daftarnilai";
  	$arraysubsubmenu[120]['t']="B";
  	#$arraysubsubmenu[120][ico]=l;
	$arraysubsubmenu[120]['k']=0;

}


	$kodemenu="F5";
	$judulsubmenu="Laporan";

?>