<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $tahunajaran;
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $jenisusers == 3 || $jenisusers == 2 )
{
    $idmahasiswa = $users;
}
if ( $idmahasiswa != "" )
{
    $qfield .= " AND mahasiswa.ID = '{$idmahasiswa}'";
    $qjudul .= " NIM  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI = '{$idprodi}'";
    $qjudul .= " Prodi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tTANGGALBAYAR >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tTANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal bayar antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
}
if ( $tahunajaran != "" )
{
    $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
}
if ( $semesterbayar != "" )
{
    $qjudul .= " Semester '".$arraysemester[$semesterbayar]."' <br>";
}
$qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
$href .= "idkomponen={$idkomponen}&";
$qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
$href .= "tahunajaran={$tahunajaran}&";
$qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
$href .= "semesterbayar={$semesterbayar}&";
$qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
$href .= "semesterbayar2={$semesterbayar2}&";
$qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
$href .= "tahunajaran2={$tahunajaran2}&";
if ( $idkomponen != "" )
{
	#echo "kesini";exit();
    $qfield2 .= " \r\n\t\t\t\t\t\tAND ( bayarkomponen.IDKOMPONEN='{$idkomponen}')";
    $qjudul .= " Komponen Pembayaran : '".$arraykomponenpembayaran2[$idkomponen]."' <br>";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        if ( $tahunajaran != "" )
        {
            $qfield2 .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}' ";
        }
    }
    else
    {
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            if ( $semesterbayar != "" )
            {
                $qfield2 .= " AND (bayarkomponen.SEMESTER ='{$semesterbayar}' ) ";
            }
            if ( $tahunajaran != "" )
            {
                $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran}')";
                $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            }
        }
        else
        {
            if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
            {
                if ( $semesterbayar2 != "" )
                {
                    $qfield2 .= " AND ( bayarkomponen.SEMESTER ='{$semesterbayar2}') ";
                }
                if ( $tahunajaran2 != "" )
                {
                    $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran2}' )";
                }
            }
        }
    }
}
else
{
    $qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
    $href .= "idkomponen={$idkomponen}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
}
else
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
}
$q = "SELECT mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.ID,biayakomponen.IDKOMPONEN,komponenpembayaran.JENIS,biayakomponen.BIAYA AS TOTAL FROM  mahasiswa,biayakomponen  ,komponenpembayaran\r\n\tWHERE \r\n\tmahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n\tbiayakomponen.IDKOMPONEN=komponenpembayaran.ID AND komponenpembayaran.JENIS!=4 AND komponenpembayaran.JENIS!=6 AND komponenpembayaran.ID NOT IN ('103','120') AND biayakomponen.BIAYA>0 {$qfield}\r\n \t {$qfieldjeniskelasm}\r\n \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
#$q = "SELECT mahasiswa.IDPRODI,mahasiswa.NAMA,mahasiswa.ID,biayakomponen.IDKOMPONEN,biayakomponen.JENIS,biayakomponen.BIAYA AS JUMLAH FROM  mahasiswa,biayakomponen  ,komponenpembayaran\r\n\tWHERE \r\n\tmahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n\tbiayakomponen.IDKOMPONEN=komponenpembayaran.ID  {$qfield}\r\n \t {$qfieldjeniskelasm}\r\n \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";

#echo $q.'<br>';
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Laporan Keuangan : Mahasiswa yang Belum Membayar");
    if ( $aksi != "cetak" && !isset( $_SESSION[users_mobile] ) )
    {
        printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetaklaporan2.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";	

        #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan2.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n \t\t\t\t<td><b><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><b><a class='{$cetak}' href='{$href}"."sort=1'>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><b>Komponen Pembayaran</td>\r\n\t\t\t\t<td><b>Jumlah Per Periode</td>\r\n  \t\t\t</tr>\r\n\t\t";
    echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center><td><b><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><b><a class='{$cetak}' href='{$href}"."sort=1'>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><b>Komponen Pembayaran</td>\r\n\t\t\t\t<td><b>Jumlah Tunggakan</td>\r\n  \t\t\t</tr>\r\n\t\t";
	echo "											</thead>
													<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
	$idmahasiswa=$d['ID'];
	$idprodimahasiswa=$d['IDPRODI'];
	$tahunajaranakademik=$tahunajaran-1;
	$semesterajaranakademik=$semesterbayar;
	$semestermhsskrg=getsemesetermahasiswa($idmahasiswa,$tahunajaran,$semesterajaranakademik);
	#echo "IDPRODI=".$idprodimahasiswa.'<br>';
	#echo "SEMESTER SKRG=".$semestermhsskrg.'<br>';
	#echo "ID KOMPONEN=".$d['IDKOMPONEN'].'<br>';
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
		
        $qfield2 = "";
        if($d[IDKOMPONEN]!=99 && $d[IDKOMPONEN]!=98){
		if ( $d[JENIS]==0 || $d[JENIS]==1) { //1 kali awal kuliah
			$qcond="GROUP BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER";
			$qlimit="LIMIT 1";	
		}elseif ( $d[JENIS]==2 ) { // per tahun ajaran
			$qcond="GROUP BY pengambilanmk.TAHUN";
			$qlimit="";
		}elseif ( $d[JENIS]==3 ) { // per semester
			$qcond="GROUP BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER";
			$qlimit="";
		}	
	}else{
		$qcond="GROUP BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER";
		$qlimit="";

	}
	
	$q_tot_krs = "SELECT pengambilanmk.IDMAKUL,pengambilanmk.TAHUN,pengambilanmk.SEMESTER FROM pengambilanmk,tbkmk,msmhs WHERE pengambilanmk.IDMAHASISWA='{$idmahasiswa}' ".
	"AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK ".
	"AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA AND pengambilanmk.THNSM<='{$tahunajaranakademik}{$semesterbayar}' {$qcond} ".
	"ORDER BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER,pengambilanmk.IDMAKUL {$qlimit}";
	/*$q_tot_krs = "SELECT pengambilanmk.IDMAKUL,pengambilanmk.TAHUN,pengambilanmk.SEMESTER FROM pengambilanmk,tbkmk,msmhs WHERE pengambilanmk.IDMAHASISWA='{$idmahasiswa}' ".
	"AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK ".
	"AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA AND ".
	"CONCAT(pengambilanmk.TAHUN,pengambilanmk.SEMESTER)<='{$tahunajaranakademik}{$semesterbayar}' {$qcond} ".
	"ORDER BY pengambilanmk.TAHUN,pengambilanmk.SEMESTER,pengambilanmk.IDMAKUL {$qlimit}";*/
	#echo $d['IDKOMPONEN']." SQL KRS=".$q_tot_krs.'<br>';
	$h_tot_krs = mysqli_query($koneksi,$q_tot_krs);
        if(sqlnumrows($h_tot_krs)>0){
		while ($dt_tot_krs=sqlfetcharray($h_tot_krs)) {
			$tahun=$dt_tot_krs['TAHUN'];
			$semester=$dt_tot_krs['SEMESTER'];
			if($semester==1){
				$nama_semester='Ganjil';
			}else{
				$nama_semester='Genap';
			}
			$qbeasiswa="SELECT DISKON FROM diskonbeasiswa JOIN mahasiswa ON diskonbeasiswa.IDMAHASISWA=mahasiswa.ID ".
			"WHERE IDKOMPONEN='$d[IDKOMPONEN]' AND IDMAHASISWA='$idmahasiswa' AND APPROVEBEASISWA=1";
			#echo $qbeasiswa.'<br>';
			if ($d[JENIS]==5 || $d[JENIS]==4) { // BULANAN dan TIDAK TETAP, ABAIKAN  KECUALI ADA SPEK LAIN NANTI
			
			}
			elseif($d[IDKOMPONEN]!=99 && $d[IDKOMPONEN]!=98) { // NORMAL, BUKAN BIAYA TAMBAHAN SKS
			
				 if ( $d['JENIS']==0 ) { //0 = 1 x Awal Kuliah
				 	
					$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
					IDKOMPONEN='$d[IDKOMPONEN]'";
					#echo "1 KALI AWAL KULIAH=".$q.'<br>';	
					$ht2=mysqli_query($koneksi,$q);
					$dt2=sqlfetcharray($ht2);
					#$dt2['TOTAL']=0;				
					// BEASISWA
					#echo "BEASISWA 1 KALI AWAL KULIAH=".$qbeasiswa.'<br>';
					$hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
							
					if (sqlnumrows($hbeasiswa)>0) {
						$dbeasiswa=sqlfetcharray($hbeasiswa);
						$d['BATAS']=$d['TOTAL']*(100-$dbeasiswa[DISKON])/100;
					}else{
						$d['BATAS']=$d['TOTAL'];
					}
					#echo "TOTAL BIAYA=".$d[TOTAL].",TOTAL BAYAR=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';
					if ($d[TOTAL]>0 && $dt2[TOTAL]<$d['BATAS']) {
						$i++;
						$namakomponen=$d['IDKOMPONEN'];
						#$tahunajaranawalkuliah=($tahun-1)."/".$tahun." ".$nama_semester;
						$total_awal_kuliah[$d['IDKOMPONEN']]['$idmahasiswa']=$total_awal_kuliah[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2[TOTAL]);
						$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_awal_kuliah[$d['IDKOMPONEN']]['$idmahasiswa'];	
						#echo "KOMPONENNYA=".$namakomponen.",BIAYA AWAL KULIAH=".$d['BIAYA'].",TOTAL BIAYA AWAL KULIAH=".$total_awal_kuliah.",TOTAL TUNGGGAKAN AWAL KULIAH=".$total_tunggakan.'<br>';
					
						echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";        
					}

				 }else if($d['JENIS']==1){ //1 = 1 x Akhir Kuliah

					$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
					IDKOMPONEN='$d[IDKOMPONEN]'";
					#echo "1 KALI AKHIR KULIAH=".$q.'<br>';	
					$ht2=mysqli_query($koneksi,$q);
					$dt2=sqlfetcharray($ht2);
					#$dt2['TOTAL']=0;				
					// BEASISWA
					#echo "BEASISWA 1 KALI AKHIR KULIAH=".$qbeasiswa.'<br>';
					$hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
							
					if (sqlnumrows($hbeasiswa)>0) {
						$dbeasiswa=sqlfetcharray($hbeasiswa);
						$d['BATAS']=$d['TOTAL']*(100-$dbeasiswa[DISKON])/100;
					}else{
						$d['BATAS']=$d['TOTAL'];
					}
					#echo "TOTAL BIAYA=".$d[TOTAL].",TOTAL BAYAR=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';
					if ($d[TOTAL]>0 && $dt2[TOTAL]<$d['BATAS']) {
						$i++;
						$namakomponen=$d['IDKOMPONEN'];
						#$tahunajaranakhirkuliah=($tahun-1)."/".$tahun." ".$nama_semester;
						$total_akhir_kuliah[$d['IDKOMPONEN']]['$idmahasiswa']=$total_akhir_kuliah[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2[TOTAL]);
						$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_akhir_kuliah[$d['IDKOMPONEN']]['$idmahasiswa'];	
						#echo "KOMPONENNYA=".$namakomponen.",BIAYA AWAL KULIAH=".$d['BIAYA'].",TOTAL BIAYA AWAL KULIAH=".$total_awal_kuliah.",TOTAL TUNGGGAKAN AWAL KULIAH=".$total_tunggakan.'<br>';
					
						echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";        
					}

				 
				 }else if($d['JENIS']==2){ //2 = Per Tahun Ajaran
				 	$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
					IDKOMPONEN='$d[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' ";
					#echo "PER TAHUN AJARAN=".$q.'<br>';
					$ht2=mysqli_query($koneksi,$q);
					echo mysqli_error($koneksi);
					$dt2=sqlfetcharray($ht2);
					#$dt2['TOTAL']=0;
					// BEASISWA
					$qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' ";
					#echo "BEASISWA PER TAHUN AJARAN=".$q.'<br>';	 
					$hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
					if (sqlnumrows($hbeasiswa)>0) {
						$dbeasiswa=sqlfetcharray($hbeasiswa);
						$d['BATAS']=$d['TOTAL']*(100-$dbeasiswa[DISKON])/100;
					}else{
						$d['BATAS']=$d['TOTAL'];
					}
					#echo "TOTAL BIAYA=".$d[TOTAL].",TOTAL BAYAR=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';

					if ($d['TOTAL']>0 && $dt2['TOTAL']<$d['BATAS']) {
						$i++;
						$namakomponen=$d['IDKOMPONEN'];
						$tahunajaranpertahun=($tahun-1)."/".$tahun." ".$nama_semester;
						$total_per_tahun_ajaran[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_tahun_ajaran[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2[TOTAL]);
						$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_tahun_ajaran[$d['IDKOMPONEN']]['$idmahasiswa'];	
						#echo "KOMPONENNYA=".$namakomponen.",BIAYA PER TAHUN AJARAN=".$d['TOTAL'].",TOTAL BIAYA PER TAHUN AJARAN=".$total_per_tahun_ajaran.'<br>';
						echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]." ".$tahunajaranpertahun."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";


					}

				 }else if($d['JENIS']==3){ //3 = Per Semester
					 /*echo "IDPRODI=".$idprodimahasiswa.'<br>';
					 echo "SEMESTER SKRG=".$semestermhsskrg.'<br>';
					 echo "ID KOMPONEN=".$d['IDKOMPONEN'].'<br>';*/

				 	 $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL,BIAYA FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
					 IDKOMPONEN='$d[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester'  ";
					 #echo "PER SEMESTER=".$q.'<br>';	
					 $ht2=mysqli_query($koneksi,$q);
					 $dt2=sqlfetcharray($ht2);

					 if(!empty($dt2['BIAYA'])){
										$total_biaya_mhs=$dt2['BIAYA'];	
									}else{
										$total_biaya_mhs=$d['TOTAL'];
									}

					 // BEASISWA
					 $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' ";
					 #echo "BEASISWA PER SEMESTER=".$q.'<br>';	 
					 $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
					 //echo mysqli_error($koneksi);
					 if (sqlnumrows($hbeasiswa)>0) {
					 	$dbeasiswa=sqlfetcharray($hbeasiswa);
						#$d['BATAS']=$d['TOTAL']*(100-$dbeasiswa[DISKON])/100;
						$d['BATAS']=$total_biaya_mhs*(100-$dbeasiswa['DISKON'])/100;
					 }else{
					 	#$d['BATAS']=$d['TOTAL'];
						$d['BATAS']=$total_biaya_mhs;
					 }

					#echo "TOTAL BIAYA=".$d[TOTAL].",TOTAL BAYAR=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';
					#if($d['IDKOMPONEN']=='265' && $prodimhs=='1003' && )
					 if ($total_biaya_mhs>0 && $dt2['TOTAL']<$d['BATAS']) {
						if($idprodimahasiswa=='1003'){
							if($semestermhsskrg<8){
								$i++;
								$tahunajaranpersemester=($tahun-1)."/".$tahun." ".$nama_semester;
								$namakomponen=$d['IDKOMPONEN'];
								$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2['TOTAL']);
								$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa'];	
								#echo "KOMPONENNYA=".$namakomponen.",BIAYA PER SEMESTER=".$dkomponen['TOTAL'].",TOTAL BIAYA PER SEMESTER=".$total_per_tahun_ajaran.'<br>';
								echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]." ".$tahunajaranpersemester."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";		
							}else{
								if($d['IDKOMPONEN']!='265'){
									$i++;
									$tahunajaranpersemester=($tahun-1)."/".$tahun." ".$nama_semester;
									$namakomponen=$d['IDKOMPONEN'];
									$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2['TOTAL']);
									$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa'];	
									#echo "KOMPONENNYA=".$namakomponen.",BIAYA PER SEMESTER=".$dkomponen['TOTAL'].",TOTAL BIAYA PER SEMESTER=".$total_per_tahun_ajaran.'<br>';
									echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]." ".$tahunajaranpersemester."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";
								}
							}
						}else{
							$i++;
							$tahunajaranpersemester=($tahun-1)."/".$tahun." ".$nama_semester;
							$namakomponen=$d['IDKOMPONEN'];
							$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2['TOTAL']);
							$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_per_semester[$d['IDKOMPONEN']]['$idmahasiswa'];	
							#echo "KOMPONENNYA=".$namakomponen.",BIAYA PER SEMESTER=".$dkomponen['TOTAL'].",TOTAL BIAYA PER SEMESTER=".$total_per_tahun_ajaran.'<br>';
							echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]." ".$tahunajaranpersemester."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";
						}
						

					}


				 }


			} //END NORMAL, BUKAN BIAYA TAMBAHAN SKS
			else if ($d[IDKOMPONEN]==99){ //BIAYA TAMBAHAN SKS
				$jumlahsks=getjumlahsks($idmahasiswa,$tahun,$semester);
				$jumlahskswajib=getjumlahskswajib($idmahasiswa,$tahun,$semester);
				$skslebih=0;
				#echo "JUMLAH SKS DIAMBIL=".$jumlahsks."DDDD"."JUMLAH SKS WAJIB=".$jumlahskswajib.'<br>';
				if ($jumlahsks>$jumlahskswajib) {
					$skslebih=$jumlahsks-$jumlahskswajib;
				}
				#echo $BIAYASKSKULIAH.'<br>';
					$biayakomponen=$d['TOTAL']+0;
				if ($BIAYASKSKULIAH==1) {
					$d['BIAYA']=$jumlahsks*$biayakomponen;
				} else {
					#echo "SKS LEBIH=".$skslebih."KKKK".$biayakomponen.'<br>';
				 	$d['BIAYA']=$skslebih*$biayakomponen;
				}

				$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
				IDKOMPONEN='$d[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester'  ";
				#echo $q.'<br>';
				$ht2=mysqli_query($koneksi,$q);
				$dt2=sqlfetcharray($ht2);
					 
				// BEASISWA
				$qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
				#echo $qbeasiswa.'<br>';
				$hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
				if (sqlnumrows($hbeasiswa)>0) {
					$dbeasiswa=sqlfetcharray($hbeasiswa);
					$d['BATAS']=$d['BIAYA']*(100-$dbeasiswa[DISKON])/100;
				}else{
					
				}	$d['BATAS']=$d['BIAYA'];

				#echo "BIAYA=".$d[TOTAL].",TOTAL=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';

				if ($d['TOTAL']>0 && $dt2[TOTAL]<$d['BATAS']){ // Tidak Lunas
					$tahunajaranskslebih=($tahun-1)."/".$tahun." ".$nama_semester;
					$namakomponen=$d['IDKOMPONEN'];
					$total_biaya_sks[$d['IDKOMPONEN']]['$idmahasiswa']=$total_biaya_sks[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2[TOTAL]);
					$total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa']=$total_biaya_sks[$d['IDKOMPONEN']]['$idmahasiswa'];	
					#echo "KOMPONENNYA=".$namakomponen.",BIAYA SKS=".$total_biaya.",TOTAL BIAYA SKS=".$total_biaya_sks.",TOTAL TUNGGGAKAN=".$total_tunggakan.'<br>';
					
						echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]." ".$tahunajaranskslebih."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";					
				}
			}//END BIAYA TAMBAHAN SKS
			else if($d[IDKOMPONEN]==98){
				$jumlahskssp=getjumlahskssp($idmahasiswa,$tahun,$semester);
				$jumlahskswajibsp=0;
				$skslebihsp=0;
				#echo "JUMLAH SKS SP DIAMBIL=".$jumlahskssp."DDDD"."JUMLAH SKS WAJIB SP=".$jumlahskswajibsp."TAHUN=".$tahun.",SEMESTER=".$semester.'<br>';
				if ($jumlahskssp>$jumlahskswajibsp) {
					$skslebihsp=$jumlahskssp-$jumlahskswajibsp;
				}
				$biayakomponensp=$d['TOTAL']+0;
				if ($BIAYASKSKULIAH==1) {
					$d['BIAYA']=$jumlahskssp*$biayakomponensp;
				} else {
					$d['BIAYA']=$skslebihsp*$biayakomponensp;
				}

				$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
				IDKOMPONEN='$d[IDKOMPONEN]'  AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester' ";
				$ht2=mysqli_query($koneksi,$q);
				#echo "SP=".$q.'<br>';
				$dt2=sqlfetcharray($ht2);

				// BEASISWA
				$qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
				#echo "SP BEASISWA=".$qbeasiswa.'<br>';
				$hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
				if (sqlnumrows($hbeasiswa)>0) {
					$dbeasiswa=sqlfetcharray($hbeasiswa);
					$d['BATAS']=$d['BIAYA']*(100-$dbeasiswa[DISKON])/100;
				}else{
					$d['BATAS']=$d['BIAYA'];
				}
				#echo "BIAYA=".$d[TOTAL].",TOTAL=".$dt2['TOTAL'].",BATAS=".$d['BATAS'].'<br>';	
				if ($d['TOTAL']>0 && $dt2[TOTAL]<$d['BATAS']){ // Tidak Lunas
					#$i++;
					$tahunajaranskssp=($tahun-1)."/".$tahun." ".$nama_semester;
					$namakomponen=$d['IDKOMPONEN'];
					$total_biaya_sks_sp[$d['IDKOMPONEN']]['$idmahasiswa']=$total_biaya_sks_sp[$d['IDKOMPONEN']]['$idmahasiswa']+($d['BATAS']-$dt2[TOTAL]);
					$total_tunggakansp[$d['IDKOMPONEN']]['$idmahasiswa']=$total_biaya_sks_sp[$d['IDKOMPONEN']]['$idmahasiswa'];	
						#echo "KOMPONENNYA=".$namakomponen.",BIAYA SKS SP=".$total_biaya.",TOTAL BIAYA SKS SP=".$total_biaya_sks.'<br>';
					echo "<tr align=center {$kelas}{$aksi} valign=top><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]." ".$tahunajaranskssp."</td><td align=right>".cetakuang( ($d['BATAS']-$dt2[TOTAL]) )." </td</tr>";					
				}
			}//END BIAYA TAMBAHAN SKS SP
		   #if ($total_tunggakan[$d['IDKOMPONEN']]!=0) {
			#echo "<tr align=center {$kelas}{$aksi} valign=top><td>{$i}</td><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=right>".cetakuang( $total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa'] )." </td</tr>";					
			#$i++;
		   #}
		}//end while looping pengambilan KRS
		#if ($total_tunggakan[$d['IDKOMPONEN']]!=0) {
		#	echo "<tr align=center {$kelas}{$aksi} valign=top><td>{$i}</td><td align=left>{$d['ID']}</td><td align=left>{$d['NAMA']}</td><td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=right>".cetakuang( $total_tunggakan[$d['IDKOMPONEN']]['$idmahasiswa'] )." </td</tr>";					
		#	$i++;
		#}	
	}//end if data pengambilan krs ada
	
	#echo "NAMA KOMPONEN=".print_r($total_tunggakan).'<br>';
	
    }
    #echo "\r\n \t\t</table></div></div>{$tpage} {$tpage2}</div></div></div> ";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    if ( $i == 1 )
    {
        printmesg( "Data Laporan Keuangan Tidak Ada" );
    }
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Laporan Keuangan Tidak Ada";
    $aksi = "";
}
?>