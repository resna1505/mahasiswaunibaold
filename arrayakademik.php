<?php
periksaroot();

 

$arraypeminatan[""]="-";

$arraypeminatan["HP"]="HUKUM PIDANA";
$arraypeminatan["HB"]="HUKUM BISNIS";


$arraypeminatan["KR"]="KESEHATAN REPRODUKSI";
$arraypeminatan["GM"]="GIZI MASYARAKAT";
$arraypeminatan["KK"]="KEBIDANAN KOMUNITAS";
$arraypeminatan["MPK"]="MANAJEMEN PELAYANAN KESEHATAN";
$arraypeminatan["MAR"]="MANAJEMEN ADMINISTRASI RUMAH SAKIT";
$arraypeminatan["KKK"]="KESEHATAN DAN KESELAMATAN KERJA";
$arraypeminatan["KL"]="KESEHATAN LINGKUNGAN";
$arraypeminatan["E"]="EPIDEMIOLOGI";

$q="SELECT ID,NAMA,POLA FROM pilihanpmb ORDER BY ID";
$h=mysqli_query($koneksi, $q);
$i=0;
while ($d=mysqli_fetch_array($h)) {
	$arraypilihanpmb2[$d['ID']]=$d['POLA'];
	$arraypilihanpmb[$d['ID']]=$d['NAMA'];
	if ($i==0) {
    $initidpilihan="$d[ID]";
  }
  $i++;
}

$arraywn[0]="WNI";
$arraywn[1]="WNI Keturunan";
$arraywn[2]="WNA";


$arraystatuslulus[0]="Tidak Lulus";
$arraystatuslulus[1]="Lulus";

$q="SELECT * FROM kelompokkurikulum  
ORDER BY ID";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraykelompokkurikulum["$d[ID]"]=$d['NAMA'];
	}
}



$arraysistemkrs[0]="TIDAK PAKET";
$arraysistemkrs[1]="PAKET";


$arrayjeniskrs[0]="KRS";
$arrayjeniskrs[1]="PERBAIKAN KRS";

$arraykelasstei["01"]="Pagi";
$arraykelasstei["02"]="Malam";
$arraykelasstei["03"]="Weekend";

if ($UMJ==1) {
  unset($arraykelasstei);
  $arraykelasstei["01"]="Pagi";
  $arraykelasstei["04"]="Sore";
  $arraykelasstei["05"]="P2K";
}

if ($UNIVERSITAS=="UNIVERSITAS 17 AGUSTUS 1945") {
  unset($arraykelasstei);
  $arraykelasstei["01"]="Reguler Pagi";
  $arraykelasstei["04"]="Reguler Sore";
  $arraykelasstei["06"]="Alumni";
  $arraykelasstei["07"]="Non Alumni";
  $arraykelasstei["08"]="Khusus";
}

unset($arrayprodidikti);
$q="SELECT KDPSTMSPST,NMPSTMSPST FROM mspst ORDER BY KDPSTMSPST";
$h=mysqli_query($koneksi, $q);
if (mysqli_num_rows($h)>0) {
  while ($d=mysqli_fetch_array($h)) {
    $arrayprodidikti[$d['KDPSTMSPST']]="$d[KDPSTMSPST] - $d[NMPSTMSPST]";
  }
}



$arrayjenispembayaran[0]="1 Kali Awal Kuliah";
$arrayjenispembayaran[1]="1 Kali Akhir Kuliah";
$arrayjenispembayaran[2]="Per Tahun Ajaran";
$arrayjenispembayaran[3]="Per Semester";
$arrayjenispembayaran[5]="Per Bulan";
$arrayjenispembayaran[4]="Tidak tetap";
$arrayjenispembayaran[6]="Saat Cuti";

$arrayjenispembayaran2['AMOUNT_1']="Total Semester I";
$arrayjenispembayaran2['AMOUNT_2']="Total Semester I";
$arrayjenispembayaran2['AMOUNT_3']="Total Semester III";
$arrayjenispembayaran2['AMOUNT_4']="Total Semester IV";



if ($BIAYASKS==1) {
  $where99=" WHERE komponenpembayaran.ID!='99' AND komponenpembayaran.ID!='98' ";
  $where992=" AND komponenpembayaran.ID!='99' AND komponenpembayaran.ID!='98' ";
 

}
$field99=" ,komponenpembayaran.NAMA NAMAKOMPONEN";
if ($BIAYASKSKULIAH==1) {
  $field99=" ,IF(komponenpembayaran.ID!='99',
    
      IF(
        komponenpembayaran.ID!='98',
        komponenpembayaran.NAMA,
        'BIAYA KULIAH PER SKS - SEMESTER PENDEK'
      ),
    'BIAYA KULIAH PER SKS - SEMESTER REGULER') NAMAKOMPONEN ";

 
}

  $q="SELECT ID $field99 ,JENIS  FROM komponenpembayaran $where99 ORDER BY  NAMA";
 #echo $q;
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraykomponenpembayaran["$d[ID]"]=$d['NAMAKOMPONEN']." - ".$arrayjenispembayaran[$d['JENIS']];
		$arraykomponenpembayaran2["$d[ID]"]=$d['NAMAKOMPONEN'];
		$arrayjeniskomponenpembayaran["$d[ID]"]=$d['JENIS'];
	}
}

//untuk S2
if ($BIAYASKS==1) {
  $where99=" WHERE komponenpembayaran.ID!='99' AND komponenpembayaran.ID!='98' ";
  $where992=" AND komponenpembayaran.ID!='99' AND komponenpembayaran.ID!='98' ";
 

}
$field99=" ,komponenpembayaran.NAMA NAMAKOMPONEN";
if ($BIAYASKSKULIAH==1) {
  $field99=" ,IF(komponenpembayaran.ID!='99',
    
      IF(
        komponenpembayaran.ID!='98',
        komponenpembayaran.NAMA,
        'BIAYA KULIAH PER SKS - SEMESTER PENDEK'
      ),
    'BIAYA KULIAH PER SKS - SEMESTER REGULER') NAMAKOMPONEN ";

 
}

  $q="SELECT ID $field99 ,JENIS  FROM komponenpembayaran $where99 ORDER BY   JENIS,NAMA";
 
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraykomponenpembayaran["$d[ID]"]=$d['NAMAKOMPONEN']." - ".$arrayjenispembayaran[$d['JENIS']];
		$arraykomponenpembayaran2["$d[ID]"]=$d['NAMAKOMPONEN'];
		$arrayjeniskomponenpembayaran["$d[ID]"]=$d['JENIS'];
	}
}

//end untuk s2

$arraykelompokmakul[0]="MPK";
$arraykelompokmakul[1]="MKK";
$arraykelompokmakul[2]="MKB";
$arraykelompokmakul[3]="MPB";
$arraykelompokmakul[4]="MBB";

/*
   a. mpk (mata kuliah pengembangan kepribadian)
   b. MKK (Mata kuliah keilmuan dan keterampilan)
   c. MKB (mata kuliah keahlian berkarya)
   d. MPB (mata kuliah perilaku bekarya)
   e. MBB ( Mata kuliah berkehidupan bersama)

*/
 


$arrayjenismakul[0]="Teori";
$arrayjenismakul[1]="Praktek";
$arrayjenismakul[2]="Teori dan Praktek";

$arraymasukkerja[0]="Melamar";
$arraymasukkerja[1]="Tempat Job Training";
$arraymasukkerja[2]="Informasi Lembaga";
$arraymasukkerja[3]="Media Informasi Kampus";
$arraymasukkerja[4]="Koran";


$arraysemester[1]="Ganjil";
$arraysemester[2]="Genap";
//$arraysemester[3]="Pendek";

$arrayjenisprodi[0]="Biasa";
$arrayjenisprodi[1]="Keprofesian";

$arrayskm[1]="Surat Cuti";
$arrayskm[2]="Surat Aktif Kuliah";
$arrayskm[3]="Surat Ket Lulus";
$arrayskm[4]="Surat Penelitian";
$arrayskm[5]="Surat Pengambilan Data";
$arrayskm[6]="Surat Pindah";

$arraysemesterskm[1]="I (Satu)";
$arraysemesterskm[2]="II (Dua)";
$arraysemesterskm[3]="III (Tiga)";
$arraysemesterskm[4]="IV (Empat)";
$arraysemesterskm[5]="V (Lima)";
$arraysemesterskm[6]="VI (Enam)";
$arraysemesterskm[7]="VII (Tujuh)";
$arraysemesterskm[8]="VIII (Delapan)";
$arraysemesterskm[9]="IX (Sembilan)";
$arraysemesterskm[10]="X (Sepuluh)";
$arraysemesterskm[11]="XI (Sebelas)";
$arraysemesterskm[12]="XII (Dua Belas)";

/*
$arraystatusmahasiswa[0]="Kuliah";
$arraystatusmahasiswa[1]="Lulus";
$arraystatusmahasiswa[2]="Cuti";
$arraystatusmahasiswa[3]="D.O.";
*/

$arraystatusmahasiswa['A']="Aktif";
$arraystatusmahasiswa['C']="Cuti";
$arraystatusmahasiswa['D']="Drop Out";
$arraystatusmahasiswa['L']="Lulus";
$arraystatusmahasiswa['K']="Keluar";
$arraystatusmahasiswa['N']="Non-Aktif";


$arraystatusdosen['A']="Dosen Tetap";
$arraystatusdosen['B']="Dosen PNS DPK";
$arraystatusdosen['C']="Dosen Honorer PTN";
$arraystatusdosen['D']="Dosen Honorer Non PTN";
$arraystatusdosen['E']="Dosen Kontrak/Tetap Kontrak";

$arraystatuskerjadosen['A']="Aktif Mengajar";
$arraystatuskerjadosen['C']="Cuti";
$arraystatuskerjadosen['K']="Keluar";
$arraystatuskerjadosen['P']="Pensiun";
$arraystatuskerjadosen['S']="Studi Lanjut";
$arraystatuskerjadosen['T']="Tugas di Instansi Lain";
$arraystatuskerjadosen['M']="Almarhum";

$arraysesuaibidangdosen['S']="Sesuai Bidang PS";
$arraysesuaibidangdosen['D']="Diluar Bidang PS";

/*
$arraystatuskerjadosen[0]="Aktif Mengajar";
$arraystatuskerjadosen[1]="Keluar";
$arraystatuskerjadosen[2]="Cuti";
$arraystatuskerjadosen[3]="Tugas Belajar";
*/

/*
$q="SELECT prodi.ID,prodi.NAMA ,departemen.ID AS IDD,departemen.NAMA AS NAMAD 
 
FROM prodi,departemen 
 WHERE prodi.IDDEPARTEMEN=departemen.ID
 ORDER BY  departemen.NAMA,prodi.NAMA";
*/
 
if (session_is_registered_sikad("prodis") && $prodis!="") {
  $qprodidep=" AND prodi.ID='$prodis'";
  $qprodidep2=" AND IDPRODI='$prodis'";
  $qprodidep3=" AND IDDEPARTEMEN='$prodis'";
  $qprodidep4=" AND makul.IDPRODI='$prodis'";
  $qprodidep5=" AND mahasiswa.IDPRODI='$prodis'";
  $qprodidep5sp=" AND mahasiswa.IDPRODI='$prodis'";
   $q="SELECT KDPSTMSPST,KDJENMSPST FROM mspst WHERE IDX='$prodis'";
  $h=mysqli_query($koneksi, $q);
  if (mysqli_num_rows($h)>0) {
    $d=mysqli_fetch_array($h);
     $qprodidepmspst=" AND mspst.KDPSTMSPST='$d[KDPSTMSPST]' AND mspst.KDJENMSPST='$d[KDJENMSPST]'  ";


     $qprodideptbkmk=" AND tbkmk.KDPSTTBKMK='$d[KDPSTMSPST]' AND tbkmk.KDJENTBKMK='$d[KDJENMSPST]'  ";

      $qprodideptbkmksp=" AND tbkmksp.KDPSTTBKMK='$d[KDPSTMSPST]' AND tbkmksp.KDJENTBKMK='$d[KDJENMSPST]'  ";

      $kodejenjangmakul=$d[KDJENMSPST];
      $kodeprodimakul=$d[KDPSTMSPST];
  }
  $statusoperatormakul=1;
}

//echo "$prodis";
$q="SELECT prodi.ID,prodi.NAMA,prodi.TINGKAT,mspst.KDPSTMSPST,fakultas.NAMA AS NAMAF FROM mspst ,prodi

LEFT JOIN departemen ON departemen.ID=prodi.IDDEPARTEMEN
LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS

WHERE prodi.ID=mspst.IDX $qprodidep
ORDER BY KDPSTMSPST";
#echo $q;
$h=mysqli_query($koneksi, $q);
#echo mysqli_error();
if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayprodidep[$d['ID']]=$d['KDPSTMSPST']." - ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
		$arrayprodifakultas[$d['ID']]=$d['NAMAF']." - PROGRAM STUDI ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
		$arrayprodidepbuatskm[$d['ID']]=$d['NAMAF']." / ".$d['KDPSTMSPST']." - ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
		#$arrayprodifakultas[$d['ID']]=$d['NAMAF']." - PROGRAM STUDI ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
	}
}

$q="SELECT ID,NAMA,TINGKAT,KDPSTMSPST FROM prodi,mspst 
WHERE prodi.ID=mspst.IDX 
ORDER BY KDPSTMSPST";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayprodidepmakul[$d['ID']]=$d['KDPSTMSPST']." - ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
	}
}


$q="SELECT ID,NAMA,TINGKAT,KDPSTMSPST FROM prodi,mspst 
WHERE prodi.ID=mspst.IDX 
ORDER BY KDPSTMSPST";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayprodidep2[$d['ID']]=$d['KDPSTMSPST']." - ".$d['NAMA']." ( ".$arrayjenjang[$d['TINGKAT']]." )";
	}
}



$q="SELECT dosen.ID,dosen.NAMA FROM dosen 
 
ORDER BY dosen.ID";
$h=mysqli_query($koneksi, $q);
////echo mysql_error();

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraydosendep[$d['ID']]="$d[ID] - ".$d['NAMA'];
	}
}

$q="SELECT dosen.ID,dosen.NAMA  FROM dosen
ORDER BY dosen.ID";
$h=mysqli_query($koneksi, $q);
////echo mysql_error();

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraydosen[$d['ID']]=$d['NAMA'];
	}
}

$q="SELECT ID,NAMA FROM prodi ORDER BY ID";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayprodi[$d['ID']]= $d['NAMA'];
	}
}

$q="SELECT ID,NAMA FROM fakultas ORDER BY ID";
$h=mysqli_query($koneksi, $q);

$arrayfakultas[""]="-";
if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		#echo "NN".$arrayfakultas.'<br>';
		$arrayfakultas[$d['ID']]=$d['NAMA'];
	}
	#exit();
}

$q="SELECT ID,NAMA FROM departemen ORDER BY ID";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraydepartemen[$d['ID']]=$d['NAMA'];
	}
}

$q="SELECT departemen.ID,
departemen.NAMA, 
departemen.IDFAKULTAS,
fakultas.NAMA AS NAMAF 
FROM departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID
  ORDER BY 
 fakultas.ID,departemen.ID";
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraydepfak["$d[ID]"]="$d[NAMAF] --> ".$d['NAMA'];
		$arraydepfak2["$d[ID]"]=$d['IDFAKULTAS'];
    		//echo  $d[NAMA];
	}
}

$arraygedung["192.168.100.171"] = "Gedung Kedokteran Lantai 1";
$arraygedung["192.168.100.172"] = "Gedung Kedokteran Lantai 2";
$arraygedung["192.168.100.173"] = "Gedung Biru";

$arraysatuantatapmuka[1] = "Kali";
$arraysatuantatapmuka[2] = "Jam";

$q="SELECT kecamatan.id_wil,kecamatan.nm_wil as nama_kecamatan,
       kabupaten.nm_wil as nama_kabupaten
FROM data_wilayah AS kecamatan
LEFT JOIN data_wilayah AS kabupaten 
  ON kabupaten.id_wil = kecamatan.id_induk_wilayah
	WHERE SUBSTRING(kecamatan.nm_wil,1,3)='kec' order by kecamatan.nm_wil ASC ";
#echo $q;
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arraykecamatan["$d[id_wil]"]=$d['nama_kecamatan']." - ".$d['nama_kabupaten'];
	}
}

$q = "SELECT * FROM komponenpembayaran WHERE 1=1 AND ID IN (268,269)";
$hb = mysqli_query($koneksi, $q);
if ( 0 < mysqli_num_rows( $hb ) )
{
	while ( $db = mysqli_fetch_array( $hb ) )
	{
		$arraykomponenpembayaran_tagihan[$db['ID']] = "{$db['NAMA']} - ".$arrayjenispembayaran[$db['JENIS']];
	}
}

$q="SELECT KODEREKENING	FROM komponenpembayaran WHERE KODEREKENING!='' order by KODEREKENING ASC";
#echo $q;
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayrekening[$d['KODEREKENING']]=$d['KODEREKENING'];
	}
}

$q="SELECT KODEREKENING2 FROM komponenpembayaran WHERE KODEREKENING2!='' order by KODEREKENING2 ASC";
#echo $q;
$h=mysqli_query($koneksi, $q);

if (mysqli_num_rows($h)>0) {
	while ($d=mysqli_fetch_array($h)) {
		$arrayrekening2[$d['KODEREKENING2']]=$d['KODEREKENING2'];
	}
}

$arraybaju[0]="S";
$arraybaju[1]="M";
$arraybaju[2]="L";
$arraybaju[3]="XL";
$arraybaju[4]="XXL";
$arraybaju[5]="XXXL";

?>
