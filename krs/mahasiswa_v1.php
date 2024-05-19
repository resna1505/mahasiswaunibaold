<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "kk";exit();
periksaroot();
#printjudulmenu( "KRS ONLINE" );
#echo "ll".$aksi;exit();
#echo $jenisusers;exit();
if ( $jenisusers == 2 )
{
	#echo $jenisusers;
    $q = "SELECT mahasiswa.ANGKATAN,mahasiswa.IDPRODI,mahasiswa.SISTEMKRS,mahasiswa.KELOMPOKKURIKULUM,mahasiswa.GELOMBANG,mahasiswa.JENISKELAS ,prodi.TAMPILANKRS FROM mahasiswa,prodi WHERE mahasiswa.IDPRODI=prodi.ID AND\nmahasiswa.ID='{$users}'";
    #echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $prodimahasiswa = $d[IDPRODI];
    $angkatanmahasiswa = $d[ANGKATAN];
    $gelombang = $d[GELOMBANG];
    $sistemkrs = $d[SISTEMKRS];
    $kelompokkurikulum = $d[KELOMPOKKURIKULUM];
    $jeniskelas = $d[JENISKELAS];
    $tampilankrs = $d[TAMPILANKRS];
    $pilihtampil = 1;
    if ( $tampilankrs == 1 )
    {
        $pilihtampil = 0;
    }
    $online = false;
    $q = "SELECT \n *,\n  DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y') AS TM,\n  DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y') AS TS\n   FROM waktukrsprodi WHERE \n  CURDATE() >= TANGGALMULAI AND\n  CURDATE() <= TANGGALSELESAI AND\n  PRODI='{$prodimahasiswa}' AND \n  ANGKATAN='{$angkatanmahasiswa}'\n";
	#echo $q.'<br>';
	$h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $tahunupdate = $d[TAHUN];
        $data[tahun] = $tahunupdate;
        $semesterupdate = $d[SEMESTER];
        $data[semester] = $semesterupdate;
        $idmahasiswa = $users;
        $tanggalmulai = $d[TM];
        $tanggalselesai = $d[TS];
        $online = true;
    }
    if ( $online != true )
    {
        $q = "SELECT \n     *,\n      DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y') AS TM,\n      DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y') AS TS\n       FROM waktukrs WHERE \n      CURDATE() >= TANGGALMULAI AND\n      CURDATE() <= TANGGALSELESAI\n    ";
		#echo $q;exit();
		$h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $tahunupdate = $d[TAHUN];
            $data[tahun] = $tahunupdate;
            $semesterupdate = $d[SEMESTER];
            $data[semester] = $semesterupdate;
            $idmahasiswa = $users;
            $tanggalmulai = $d[TM];
            $tanggalselesai = $d[TS];
            $online = true;
        }
    }
	#echo $online;
    if ( $online == true )
    {
        $q = "SELECT sksmaksimum.* \n            FROM sksmaksimum ,mahasiswa\n            WHERE \n            mahasiswa.IDPRODI=sksmaksimum.IDPRODI\n            AND mahasiswa.ID='{$idmahasiswa}'\n            ";
        #echo $q;exit();
		$hs = mysqli_query($koneksi,$q);
        $jenisip = 0;
        if ( 0 < sqlnumrows( $hs ) )
        {
            $ds = sqlfetcharray( $hs );
            $sksmaksimum = $ds[SKS];
            $semesteracuan = $ds[SEMESTER];
            $jenisip = $ds[JENISIP] + 0;
        }
        $thnlalu = $data[tahun] - 1;
        $semlalu = $data[semester];
        if ( 0 < $semesteracuan )
        {
            if ( $semlalu % 2 == 0 )
            {
                $thnlalu = $thnlalu - floor( $semesteracuan / 2 );
                if ( $semesteracuan % 2 == 0 )
                {
                    $semlalu = 2;
                }
                else
                {
                    $semlalu = 1;
                }
            }
            else
            {
                $thnlalu = $thnlalu - ceil( $semesteracuan / 2 );
                if ( $semesteracuan % 2 == 0 )
                {
                    $semlalu = 1;
                }
                else
                {
                    $semlalu = 2;
                }
            }
        }
        if ( $data[semester] == 2 )
        {
            $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
        }
        else
        {
            $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
        }
        if ( $jenisip == 0 )
        {
            $qtrakm = " NLIPSTRAKM AS ";
            $jtrakm = " Semester (IPS) ";
        }
        else
        {
            $qtrakm = " NLIPKTRAKM AS ";
            $jtrakm = " Kumulatif (IPK) ";
        }
        $q = "\n    \t\t\tSELECT {$qtrakm} NLIPSTRAKM\n    \t\t\tFROM  trakm\n    \t\t\tWHERE\n    \t\t  NIMHSTRAKM='{$idmahasiswa}' AND\n    \t\t   THSMSTRAKM<='{$thnlalu}{$semlalu}'\n    \t\t  ORDER BY THSMSTRAKM DESC LIMIT 0,1\n     \t\t";
        $hip = mysqli_query($koneksi,$q);
        #echo $q;
		if ( 0 < sqlnumrows( $hip ) )
        {
            $dip = sqlfetcharray( $hip );
            $ips = $dip[NLIPSTRAKM];
        }
        else
        {
            $ips = "Tidak ada";
        }
        $syaratkrs = 1;
        if ( $ips != "Tidak ada" )
        {
            $syaratkrs = 0;
            $q = "SELECT syaratkrs.* FROM syaratkrs,mahasiswa \n    WHERE \n    mahasiswa.IDPRODI=syaratkrs.IDPRODI AND\n    mahasiswa.ID='{$idmahasiswa}' \n    ORDER BY SKS DESC";
            #echo $q;exit();
			$hkrs = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hkrs ) )
            {
                #do
                #{
                    while ( $dkrs = sqlfetcharray( $hkrs ) )
                    {
                        if ( $ips <= $dkrs[IPS] )
                        {
                            $sksmaksimum = $dkrs[SKS] - 1;
                            $ipsminimum = $dkrs[IPS];
                            $syaratkrs = 1;
                        }
                    }
                #} while ( 1 );
            }
            else
            {
                $syaratkrs = 0;
            }
        }
        else
        {
            $ipsminimum = 0;
            $syaratkrs = 0;
        }
		
        $q = "SELECT sksmaksimum.* FROM sksmaksimum,mahasiswa WHERE \n            mahasiswa.IDPRODI=sksmaksimum.IDPRODI\n            AND mahasiswa.ID='{$idmahasiswa}'\n            ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $sksmaksimum2 = $d[SKS];
        }
        #$q = "SELECT SKSEMTRAKM FROM trakm WHERE NIMHSTRAKM='{$users}' AND THSMSTRAKM='".( $tahunupdate - 1 )."{$semesterupdate}'";
		$q = "SELECT SKSEMTRAKM,SKSTTTRAKM FROM trakm WHERE NIMHSTRAKM='{$users}' AND THSMSTRAKM='".( $tahunupdate - 1 )."{$semesterupdate}'";
        $h = mysqli_query($koneksi,$q);
        $skssekarang = 0;
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
			
			//tambahan hafizd
			#if ($ips != "Tidak ada"){
			
			#	$skssekarang = $d[SKSEMTRAKM];
			
			#}else{
			
				$skssekarang = $d[SKSTTTRAKM];
			#}
        }
        $sksdiambil = $skssekarang;
    }
    if ( $online == false )
    {
        printmesg( "KRS Online telah ditutup. Terima kasih" );
    }
    else
    {
        $statubimbingan = 0;
        $q = "SELECT STATUS FROM statusbimbingan WHERE IDMAHASISWA='{$users}' AND TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'";
		#echo $q;
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $statusbimbingan = $d[STATUS];
        }
        $statuskrs = 1;
		#echo getaturan( "KRSONLINE" );exit();
        if ( getaturan( "KRSONLINE" ) == 1 )
        {
            $idkomponen = getaturan( "SYARATKRSONLINE" );
            $statuskrs = 0;
            $q = "SELECT NAMA,JENIS FROM komponenpembayaran WHERE ID='{$idkomponen}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $namakomponen = $d[NAMA];
            $jeniskomponen = $d[JENIS];
            if ( $jeniskomponen == 2 )
            {
                $qfilterkeuangan = " AND TAHUNAJARAN='{$data['tahun']}' ";
                $qbeasiswa = " AND TAHUN='{$data['tahun']}' ";
            }
            else if ( $jeniskomponen == 3 )
            {
                $qfilterkeuangan = " AND TAHUNAJARAN='{$data['tahun']}' \n      AND SEMESTER='{$data['semester']}' ";
                $qbeasiswa = " AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}'  ";
            }
            else if ( $jeniskomponen == 5 )
            {
                $qfilterkeuangan = "  \n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL 0 MONTH) >=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL -3 MONTH) <=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n\n      ";
                $qf2 = "*3 AS BIAYA ";
            }
            $q = "SELECT IDPRODI,ANGKATAN,JENISKELAS FROM mahasiswa WHERE ID='{$idmahasiswa}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $idprodi = $d[IDPRODI];
            $angkatan = $d[ANGKATAN];
            $jeniskelas = $d[JENISKELAS];
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
            }
            else
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
            }
            $q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $biaya = $d[BIAYA] + 0;
            #$q = "SELECT DISKON FROM beasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' {$qbeasiswa} ";
			$q = "SELECT DISKON FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' {$qbeasiswa} ";
			#echo $q;
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $beasiswa = $d[DISKON];
                $biaya = $biaya * ( 100 - $beasiswa ) / 100;
            }
            $q = "SELECT \n      SUM(JUMLAH+DISKON)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' \n      {$qfilterkeuangan}\n      AND IDMAHASISWA='{$idmahasiswa}'\n      HAVING SISA >=0\n      ";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $statuskrs = 1;
            }
            else
            {
                #$mesgkrs .= "Anda belum membayar lunas {$namakomponen}. Silakan lunasi pembayaran Anda terlebih dahulu.<br>";
				$mesgkrs = "Anda belum melengkapi administrasi keuangan, silahkan lunasi pembayaran Anda dengan menghubungi bagian keuangan";
            }
        }
        else if ( getaturan( "KRSONLINE" ) == 2 )
        {
            $statuskrs = 0;
            $q = "SELECT SEMESTER1,SEMESTER2 FROM biayakomponen WHERE IDPRODI='{$prodimahasiswa}' AND\n      \t\t\t \n            ANGKATAN='{$angkatanmahasiswa}'  AND\n            GELOMBANG='{$gelombang}' {$qfieldjeniskelas} LIMIT 0,1";
            $hs = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hs ) )
            {
                $ds = sqlfetcharray( $hs );
                $semester1 = $ds[SEMESTER1];
                $semester2 = $ds[SEMESTER2];
            }
            $tanggalmulaikeuangan = "";
            $tanggalselesaikeuangan = "";
            if ( getaturan( "SYARATKRSONLINE2" ) == "T" )
            {
                if ( $data[semester] == 1 )
                {
                    $q = "SELECT * FROM waktukeuangan WHERE TAHUN='{$data['tahun']}' AND SEMESTER='1'";
                    $hk = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hk ) )
                    {
                        $dk = sqlfetcharray( $hk );
                        $tanggalmulaikeuangan = $dk[TANGGALMULAI];
                        $tanggalselesaikeuangan = $dk[TANGGALSELESAI];
                    }
                }
                else
                {
                    if ( $data[semester] == 2 )
                    {
                        $q = "SELECT * FROM waktukeuangan WHERE TAHUN='{$data['tahun']}' AND SEMESTER='1'";
                        $hk = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $hk ) )
                        {
                            $dk = sqlfetcharray( $hk );
                            $tanggalmulaikeuangan = $dk[TANGGALMULAI];
                        }
                        $q = "SELECT * FROM waktukeuangan WHERE TAHUN='{$data['tahun']}' AND SEMESTER='2'";
                        $hk = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $hk ) )
                        {
                            $dk = sqlfetcharray( $hk );
                            $tanggalselesaikeuangan = $dk[TANGGALSELESAI];
                        }
                    }
                }
            }
            else if ( getaturan( "SYARATKRSONLINE2" ) == "S" )
            {
                $q = "SELECT * FROM waktukeuangan WHERE TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}'";
                $hk = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hk ) )
                {
                    $dk = sqlfetcharray( $hk );
                    $tanggalmulaikeuangan = $dk[TANGGALMULAI];
                    $tanggalselesaikeuangan = $dk[TANGGALSELESAI];
                }
            }
            if ( $tanggalmulaikeuangan != "" && $tanggalselesaikeuangan != "" )
            {
                $q = "SELECT SUM(JUMLAH-DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\n            TANGGALBAYAR >= '{$tanggalmulaikeuangan}' AND\n            TANGGALBAYAR <= '{$tanggalselesaikeuangan}'  \n            \n            ";
                $h = mysqli_query($koneksi,$q);
                echo mysqli_error($koneksi);
                $d = sqlfetcharray( $h );
                $totalbayar = $d[TOTAL];
                if ( getaturan( "SYARATKRSONLINE2" ) == "T" )
                {
                    if ( $data[semester] == 1 )
                    {
                        if ( $totalbayar < $semester1 )
                        {
                            $mesgkrs .= "Anda belum membayar jumlah minimal pembayaran (".cetakuang( $semester1 ).") \n                   untuk Tahun Ajaran ".( $data[tahun] - 1 )."/{$data['tahun']} ".$arraysemester[$data[semester]].". \n                   Total pembayaran Anda baru mencapai ".cetakuang( $totalbayar ).". \n                   Silakan lakukan pembayaran minimal terlebih dahulu.<br>";
                        }
                        else
                        {
                            $statuskrs = 1;
                        }
                    }
                    else
                    {
                        if ( $data[semester] == 2 )
                        {
                            if ( $totalbayar < $semester2 )
                            {
                                $mesgkrs .= "Anda belum membayar jumlah minimal pembayaran (".cetakuang( $semester2 ).") \n                   untuk Tahun Ajaran ".( $data[tahun] - 1 )."/{$data['tahun']} Ganjil dan Genap. \n                   Total pembayaran Anda baru mencapai ".cetakuang( $totalbayar ).". \n                   Silakan lakukan pembayaran minimal terlebih dahulu.<br>";
                            }
                            else
                            {
                                $statuskrs = 1;
                            }
                        }
                    }
                }
                else if ( getaturan( "SYARATKRSONLINE2" ) == "S" )
                {
                    if ( $totalbayar < $semester1 )
                    {
                        $mesgkrs .= "Anda belum membayar jumlah minimal pembayaran (".cetakuang( $semester1 ).") \n                   untuk Tahun Ajaran ".( $data[tahun] - 1 )."/{$data['tahun']} ".$arraysemester[$data[semester]].". \n                   Total pembayaran Anda baru mencapai ".cetakuang( $totalbayar ).". \n                   Silakan lakukan pembayaran minimal terlebih dahulu.<br>";
                    }
                    else
                    {
                        $statuskrs = 1;
                    }
                }
            }
        }
        $statuskrsonline = 0;
        $statusmahasiswabaru = $statusmahasiswabimbingan = 1;
        if ( getaturan( "KRSONLINE2" ) == 0 && $ips == "Tidak ada" )
        {
            $mesgkrs .= "Mahasiswa Baru (belum punya IP {$jtrakm} Semester yg lalu) tidak dapat melakukan KRS Online. <br>";
            $statusmahasiswabaru = 0;
        }
        if ( getaturan( "KRSONLINE3" ) == 1 && $statusbimbingan == 0 )
        {
            $mesgkrs .= "Mahasiswa yang belum bimbingan ke dosen PA/Wali tidak dapat melakukan krs online. <br>";
            $statusmahasiswabimbingan = 0;
        }
        $aturankeuangan = getaturan( "KRSONLINE" );
		#echo $aturankeuangan;exit();
        if ( $aturankeuangan == 3 )
        {
			#echo "kk";exit();
			#echo $idmahasiswa."mmm".$tahunupdate."ccc".$semesterupdate."ZZZ";
            #$lunas = getstatusminimalpembayaranmahasiswa( $idmahasiswa, $tahunupdate, $semesterupdate, "KRS" );
			$lunas = getstatusminimalpembayaransppmahasiswa( $idmahasiswa, $tahunupdate, $semesterupdate, "KRS" );
            if ( $lunas[LUNAS] < 0 )
            {
                $statuskrs = 0;
                $mesgkrs .= "Anda belum melunasi kewajiban Anda. Silakan hubungi bagian keuangan.<br>{$lunas['STATUS']}";
				#$mesgkrs .= "Maaf Anda belum menyelesaikan administrasi keuangan / Komponen Pembayaran Angkatan untuk pengisian krs belum terintegrasi. <br> Silakan hubungi bagian keuangan";
            
			}/*elseif($lunas[LUNAS]==''){
				$statuskrs = 0;
				$mesgkrs .= "Komponen Pembayaran Angkatan untuk pengisian krs belum terintegrasi, Silakan hubungi bagian keuangan";
            
			}*/
            else
            {
                $statuskrs = 1;
            }
        }
        if ( $statusmahasiswabaru == 1 && $statusmahasiswabimbingan == 1 && $statuskrs == 1 )
        {
            $statuskrsonline = 1;
        }
        else
        {
            printmesg( $mesgkrs );
        }
		#echo $statuskrsonline;exit();
        if ( $statuskrsonline == 1 )
        {
		
			#echo $aksi;
			
            if ( $aksi == "updatemk" )
            {
                $halamankonfirmasi = 0;
                $prosesmakul = 1;
                if ( is_array( $datax ) && $aksi2 == "ambil" && $UNIVERSITAS == "UNIVERSITAS BATAM" )
                {
					#echo "kesini";exit();
					//cek dulu pengambilanmk sudah pernah diinput blom
					/*$sqlambilmk="SELECT COUNT(IDMAHASISWA) AS ambilmk FROM pengambilanmk WHERE IDMAHASISWA='{$idmahasiswa}' AND SEMESTER='{$data['semester']}' AND TAHUN='{$data['tahun']}'";
					#echo $sqlambilmk;exit();
					$hambilmk = mysql_query($sqlambilmk, $koneksi);
					#$h = mysqli_query($koneksi,$q);
					$dambilmk = sqlfetcharray($hambilmk);
					#if($dambilmk['ambilmk']>0 && $sksdiambil==$sksmaksimum2){
					if($dambilmk['ambilmk']>0){
						
						$errmesg = "Anda sudah melakukan pengambilan KRS, jika ingin melakukan perubahan data silahkan hubungi operator";
						$prosesmakul=0;
						#exit(1);
					
					}*/
					#else{
						#echo "lll";exit();		
						$q = "SELECT IDPRODI,ANGKATAN FROM mahasiswa WHERE ID='{$idmahasiswa}'";
						$h = mysqli_query($koneksi,$q);
						$d = sqlfetcharray( $h );
						$idprodi = $d[IDPRODI];
						$angkatan = $d[ANGKATAN];
						$input = "\n        \t\t\t\t\t\t".createinputhidden( "count", "{$count}", "class=masukan  " )."\n          \n          ";
						$j = 0;
						while ( $j < $count )
						{
							$ttmp = "idambil_{$j}";
							$idambil[$$ttmp] = 1;
							$input .= "\n        \t\t\t\t\t\t".createinputhidden( "idambil_{$j}", $$ttmp, "class=masukan  " )."\n             \n             ";
							++$j;
						}
						unset( $arraymakuldiambil );
						$q = "SELECT * FROM pengambilanmk WHERE IDMAHASISWA='{$idmahasiswa}' AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}'";
						#echo $q;exit();
						$h = doquery($koneksi,$q);
						if(0 < sqlnumrows( $h )){
						
							#$errmesg = "Pengambilan KRS hanya boleh dilakukan satu kali";
								
							#break;
							while ($d = sqlfetcharray( $h ))
							{
								$arraymakuldiambil[$d[IDMAKUL]] = $d[IDMAKUL];
							}
						}
						#echo "ll";exit();
						$q = "SELECT BIAYA FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n               AND IDKOMPONEN='99' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
						$h = mysqli_query($koneksi,$q);
						$d = sqlfetcharray( $h );
						$biayaskstambahan = $d[BIAYA] + 0;
						$jumlahsks = getjumlahsks( $idmahasiswa, $data[tahun], $data[semester] );
						$jumlahskswajib = getjumlahskswajib( $idmahasiswa, $data[tahun], $data[semester] );
						$sksbaru = 0;
						foreach ( $datax as $k => $v )
						{
							if ( $idambil[$k] == 1 && $aksi2 == "ambil" && $arraymakuldiambil[$k] != $k )
							{
								$sksbaru += $v[sks];
							}
							$input .= "\n        \t\t\t\t\t\t".createinputhidden( "datax[{$k}][semester]", "{$v['semester']}", "class=masukan size=2" )."\n        \t\t\t\t\t\t".createinputhidden( "datax[{$k}][sks]", "{$v['sks']}", "class=masukan size=2" )."\n        \t\t\t\t\t\t".createinputhidden( "datax[{$k}][nama]", "{$v['nama']}", "class=masukan  " )."\n        \t\t\t\t\t\t".createinputhidden( "datax[{$k}][kelas]", "{$v['kelas']}", "class=masukan  " )."\n                  \n                  ";
						}
						$skslebih = $sksbaru + $jumlahsks - $jumlahskswajib;
						if ( 0 < $skslebih )
						{
							$halamankonfirmasi = 1;
							$prosesmakul = 0;
							echo "\n                <form action=index.php method=post>\n            \t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\n            \t\t\t".createinputhidden( "aksi", "updatemk", "" )."\n            \t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\n            \t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\n            \t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\n            \t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\n            \t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\n            \t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" )."\n            \t\t\t{$input}\n                <table>\n                <tr>\n                <td align=center>\n                <h1>HALAMAN KONFIRMASI PERSETUJUAN MEMBAYAR BIAYA TAMBAHAN SKS</h1>\n                </td>\n                </tr>\n                <tr>\n                <td  >\n                <br>\n                <p>\n                Anda akan mengambil mata kuliah sejumlah ".( $sksbaru + $jumlahsks )." SKS, melebihi jumlah paket sebanyak {$jumlahskswajib} SKS. Karena melebih jumlah paket SKS, anda wajib membayar biaya tambahan SKS sebesar\n                </p>\n                <br> \n                <p>\n                <b>{$skslebih} SKS  (Rp.  ".cetakuang( $skslebih * $biayaskstambahan ).")</b>\n                </p>\n                <br>\n                <p>\n                Jika anda menyetujui klik <b>OK</b> dan data KRS akan tersimpan\nJika anda batal mengambil KRS klik <b>Batal</b> maka data KRS tidak tersimpan dan pengisian KRS bisa anda ulang\n                </p>\n                    <br>\n                <p>Silahkan menyelesaikan pembayaran dan melapor ke bagian keuangan</p>\n                  <br>\n                <p>Terima Kasih</p>\n                </tr>\n\n                <tr>\n                <td  >\n                 <input type=submit name=aksi2 value='OK'>\n                 <input type=submit name=aksi2 value='Batal'>\n                </td>\n                </tr>\n\n\n                </table>\n                </form>\n             ";
						}
						
					#}
                }
                if ( $prosesmakul == 1 && is_array( $datax ) && $halamankonfirmasi == 0 )
                {
                    $jmlupdate = 0;
                    $jmlhapus = 0;
                    $j = 0;
                    while ( $j < $count )
                    {
                        $ttmp = "idambil_{$j}";
                        $idambil[$$ttmp] = 1;
                        ++$j;
                    }
                    foreach ( $datax as $k => $v )
                    {
                        if ( $idambil[$k] == 1 && ( $aksi2 == "ambil" || $aksi2 == "OK" ) )
                        {
							//cek dulu pengambilanmk sudah pernah diinput blom
							/*$sqlambilmk="SELECT COUNT(IDMAHASISWA) AS ambilmk FROM pengambilanmk WHERE IDMAHASISWA='{$idmahasiswa}' AND SEMESTER='{$data['semester']}' AND TAHUN='{$data['tahun']}'";
							#echo $sqlambilmk;exit();
							$hambilmk = mysql_query($sqlambilmk, $koneksi);
							#$h = mysqli_query($koneksi,$q);
							$dambilmk = sqlfetcharray($hambilmk);
							#if($dambilmk['ambilmk']>0 && $sksdiambil==$sksmaksimum2){
							if($dambilmk['ambilmk']>0 && $sksdiambil==$sksmaksimum2){
								
								$errmesg = "Pengambilan KRS hanya boleh dilakukan satu kali";
                            
								break;
							
							}*/
							#echo "lll".$sistemkrs."mmm".$sksmaksimum2."LLL".$v[sks]."CCCC".$sksdiambil."QQQQ".'<br>';exit();
                            if ( $sistemkrs == 0 && ( $sksmaksimum < $v[sks] + $sksdiambil && $syaratkrs == 1 && $sksmaksimum>=0 ) )
                            {
								#echo "KESINI";
                                $errmesg = "SKS yang hendak diambil {$k} (".( $v[sks] + $sksdiambil ).") melebihi batas maksimum SKS yang boleh diambil (".$sksmaksimum."). Proses pengambilan SKS Mata Kuliah dihentikan.";
                                break;
                            }
                            if ( $sistemkrs == 0 && ( $sksmaksimum2 < $v[sks] + $sksdiambil && $sksmaksimum2>0 ) )
                            {
								#echo "KESANA";
                                $errmesg = "SKS yang hendak diambil (".( $v[sks] + $sksdiambil ).") melebihi batas maksimum SKS yang boleh diambil ({$sksmaksimum2}). Proses pengambilan SKS Mata Kuliah dihentikan.";
                                break;
                            }
							#exit();
                            $q = "INSERT INTO  pengambilanmk \n\t\t\t\t(IDMAHASISWA,IDMAKUL,TAHUN,KELAS,SEMESTER,SEMESTERMAKUL,SKSMAKUL,NAMA,THNSM) \n\t\t\t\tVALUES('{$idmahasiswa}','{$k}','{$data['tahun']}','{$v['kelas']}',{$data['semester']},\n\t\t\t\t'{$v['semester']}','{$v['sks']}','{$v['nama']}', '".( $data[tahun] - 1 )."{$data['semester']}')\n\t\t\t\t";
                            mysqli_query($koneksi,$q);
                            if ( sqlaffectedrows( $koneksi ) <= 0 )
                            {
                                $q = "UPDATE pengambilanmk \n\t\t\t\t\tSET \n\t\t\t\t\t\tKELAS='{$v['kelas']}',\n\t\t\t\t\t\tSEMESTER='{$data['semester']}',\n\t\t\t\t\t\tSEMESTERMAKUL='{$v['semester']}',\t\t\t\t\t\t\n\t\t\t\t\t\tNAMA='{$v['nama']}',\t\t\t\t\t\t\n\t\t\t\t\t\tSKSMAKUL='{$v['sks']}'\n\t\t\t\t\tWHERE\n\t\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\n\t\t\t\t\tAND IDMAKUL='{$k}'";
                                mysqli_query($koneksi,$q);
                                if ( 0 < sqlaffectedrows( $koneksi ) )
                                {
                                    mysqli_query($koneksi,$q);
                                    $ketlog = "Update Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                                    buatlog( 25 );
                                    $sem = $data[semester];
                                    $tahunlama = $data[tahun];
                                    include( "edittrakm.php" );
                                    ++$jmlupdate;
                                }
                            }
                            else
                            {
                                $sksdiambil += $v[sks];
                                ++$jmlupdate;
                                $ketlog = "Tambah Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                                buatlog( 24 );
                                $sem = $data[semester];
                                $tahunlama = $data[tahun];
                                include( "edittrakm.php" );
                            }
                        }
                        else if ( $idambil[$k] == 1 && $aksi2 == "batal" )
                        {
                            $q = "DELETE FROM pengambilanmk WHERE \n\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\n\t\t\t\tAND TAHUN='{$data['tahun']}'\n\t\t\t\tAND IDMAKUL='{$k}'\n\t\t\t\tAND SEMESTER='{$data['semester']}'\n\t\t\t\t";
                            mysqli_query($koneksi,$q);
                            if ( 0 < sqlaffectedrows( $koneksi ) )
                            {
                                $sksdiambil -= $v[sks];
                                $ketlog = "Hapus Pengambilan Mata Kuliah dengan ID Makul={$k}, \n\t\t\t\t\t\tTahun Ajaran=".( $data[tahun] - 1 )."/{$data['tahun']},\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                                buatlog( 26 );
                                $q = "DELETE FROM trnlm WHERE \n    \t\t\t\tNIMHSTRNLM='{$idmahasiswa}'\n    \t\t\t\tAND THSMSTRNLM='".( $data[tahun] - 1 )."{$data['semester']}'\n    \t\t\t\tAND KDKMKTRNLM='{$k}'\n    \t\t\t\t \n    \t\t\t\t";
                                mysqli_query($koneksi,$q);
                                $q = "SELECT IDMAHASISWA FROM pengambilanmk \n          WHERE \n          IDMAHASISWA='{$idmahasiswa}'\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\n          AND SEMESTER='{$data['semester']}'";
                                $h = mysqli_query($koneksi,$q);
                                if ( sqlnumrows( $h ) <= 0 )
                                {
                                    $q = "delete FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' \n            AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'";
                                    mysqli_query($koneksi,$q);
                                }
                                ++$jmlhapus;
                            }
                        }
                    }
                    if ( 0 < $jmlupdate )
                    {
                        $errmesg .= "Pengambilan Mata Kuliah Telah ditambahkan/diupdate sebanyak {$jmlupdate} buah";
                    }
                    if ( 0 < $jmlhapus )
                    {
                        $errmesg .= "<br>Pengambilan Mata Kuliah Telah Dihapus sebanyak {$jmlhapus} buah";
                    }
                }
                $aksi = "tampiledit";
            }
            if ( $aksi == "tampiledit" && $halamankonfirmasi == 0 )
            {
				#echo "KK";exit();
                $statuskrs = 1;
                #if ( getaturan( "KRSONLINE" ) == 1 )
				//cek mahasiswa ini sudah ada ijazah atau belom
				#$sql_cek_ijazah="SELECT count(ID) FROM mahasiswa JOIN calonmahasiswa ON WHERE"
				if ( getaturan( "KRSONLINE" ) == 3 )
                {
					#echo "sini";exit();
                    $idkomponen = getaturan( "SYARATKRSONLINE" );
					#echo $idkomponen.'<br>';
                    $statuskrs = 0;
                    $q = "SELECT NAMA,JENIS FROM komponenpembayaran WHERE ID='{$idkomponen}'";
					#echo $q;
                    $h = mysqli_query($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $namakomponen = $d[NAMA];
                    $jeniskomponen = $d[JENIS];
                    if ( $jeniskomponen == 2 )
                    {
                        $qfilterkeuangan = " AND TAHUN='{$data['tahun']}' ";
                    }
                    else if ( $jeniskomponen == 3 )
                    {
                        $qfilterkeuangan = " AND TAHUNAJARAN='{$data['tahun']}' \n      AND SEMESTER='{$data['semester']}' ";
						#$qfilterkeuangan = " AND (DATE_ADD(CURDATE(), INTERVAL 0 MONTH) >=DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL -3 MONTH) <=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n      ";
                       
                    }
                    else if ( $jeniskomponen == 5 )
                    {
                        $qfilterkeuangan = "  \n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL 0 MONTH) >=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n        AND \n        (\n        DATE_ADD(CURDATE(), INTERVAL -3 MONTH) <=\n        DATE_ADD(concat(TAHUNAJARAN,'-',SEMESTER,'-01'), INTERVAL 0 MONTH)\n        )\n      ";
                        $qf2 = "*3 AS BIAYA ";
                    }
                    $q = "SELECT IDPRODI,ANGKATAN FROM mahasiswa WHERE ID='{$idmahasiswa}'";
                    #echo $q.'<br>';
					$h = mysqli_query($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $idprodi = $d[IDPRODI];
                    $angkatan = $d[ANGKATAN];
                    #$q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                    #$q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                    
					$q = "SELECT BIAYA{$qf2} FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                    
					$q = "SELECT biayakomponen.krs{$qf2} AS BIAYA FROM biayakomponen WHERE ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}'\n       AND IDKOMPONEN='{$idkomponen}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                    
					#echo $q.'<br>';exit();
					$h = mysqli_query($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $biaya = $d[BIAYA] + 0;
					
					$q = "SELECT DISKON FROM diskonbeasiswa JOIN mahasiswa ON diskonbeasiswa.IDMAHASISWA=mahasiswa.ID WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND YEAR(TANGGALUPDATE)='{$w['year']}' AND APPROVEBEASISWA=1 ORDER BY TANGGALUPDATE DESC LIMIT 1";
					#echo $q.'<br>';
					$h = mysqli_query($koneksi,$q);
					if ( 0 < sqlnumrows( $h ) )
					{
						$d = sqlfetcharray( $h );
						$diskonnya = $d[DISKON];
						if($diskonnya>100.00){
			
							#	$diskonnya = $diskonnya;
							$q = "SELECT \n      SUM(JUMLAH+{$diskonnya})-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' AND YEAR(TANGGALBAYAR)=YEAR(CURDATE())   AND IDMAHASISWA='{$idmahasiswa}'  HAVING SUM(JUMLAH)-{$biaya} >=0 	     ";
                    
						}else if($diskonnya==100.00){
						
							$q = "SELECT DISKON FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND YEAR(TANGGALUPDATE)='{$w['year']}' ORDER BY TANGGALUPDATE DESC LIMIT 1";
					
						}
						else{
							$diskonbeasiswanya=1-($diskonnya/100);	
							#	$diskonnya = ( 100 - $diskonnya ) / 100;
							$q = "SELECT \n      SUM(JUMLAH)-({$biaya}*$diskonbeasiswanya) AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' AND YEAR(TANGGALBAYAR)=YEAR(CURDATE())   AND IDMAHASISWA='{$idmahasiswa}'  HAVING SUM(JUMLAH)-({$biaya}*$diskonbeasiswanya) >=0 	     ";
                    
						}
						#$beasiswa = $d[DISKON];
						#$biaya = $biaya * ( 100 - $beasiswa ) / 100;
					}else{
						$q = "SELECT \n      SUM(JUMLAH)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' \n      {$qfilterkeuangan}\n      AND IDMAHASISWA='{$idmahasiswa}'\n      HAVING SUM(JUMLAH)-{$biaya} >=0\n      ";
                    #$q = "SELECT \n      SUM(JUMLAH)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' AND (MONTH(TANGGALBAYAR)=MONTH(CURDATE()))      AND IDMAHASISWA='{$idmahasiswa}'\n      HAVING SUM(JUMLAH)-{$biaya} >=0\n      ";
                    #if($diskonnya>100){
						#$q = "SELECT \n      SUM(JUMLAH)-{$biaya} AS SISA \n      FROM bayarkomponen WHERE \n      IDKOMPONEN='{$idkomponen}' AND YEAR(TANGGALBAYAR)=YEAR(CURDATE())   AND IDMAHASISWA='{$idmahasiswa}'  HAVING SUM(JUMLAH)-{$biaya} >=0 	     ";
                    }
					#echo $q.'<br>';
					$h = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
						#echo "mmm";
                        $d = sqlfetcharray( $h );
                        #if($d['sisa']==NULL){
							#echo "lll";
						#	$statuskrs=0;
						#}else{
						$statuskrs = 1;
						#}
                    }
                }
				#echo $statuskrs;exit();
                $tmpcetak = "";
                $idmahasiswa = $users;
                if ( $statuskrs == 0 )
                {
                    $errmesg = "Maaf, Anda belum membayar lunas {$namakomponen}. Silakan lunasi pembayaran Anda terlebih dahulu.";
					#$errmesg .= "Maaf Anda belum menyelesaikan administrasi keuangan. Silakan hubungi bagian keuangan";
                    $aksi = "";
                }
                else if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
                {
                    $errmesg = "NIM harus diisi atau tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
                    $aksi = "";
                }
                else if ( !ismahasiswaaktif( $idmahasiswa ) )
                {
                    $errmesg = "Data tidak dapat diproses karena mahasiswa dengan ID '{$idmahasiswa}' DO/Lulus/Cuti";
                    $aksi = "";
                }
                else
                {
					#echo "akaka";
                    $q = "\n\t\t\tSELECT mahasiswa.NAMA,ANGKATAN,IDPRODI,KELAS AS KELASDEFAULT,\n      KDPSTMSMHS,KDJENMSMHS \n\t\t\t\n\t\t\tFROM  mahasiswa,msmhs\n\t\t\tWHERE\n\t\t\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\n\t\t  mahasiswa.ID='{$idmahasiswa}'\n \t\t";
                    #echo $q;exit();
					$h = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $h ) <= 0 )
                    {
                        $errmesg = "Data Mahasiswa / Data Dosen Wali Tidak Ada";
                        $aksi = "tambahawal";
                    }
                    else
                    {
                        $d = sqlfetcharray( $h );
                        if ( $data[semester] != 3 )
                        {
							#echo "sini";exit();
							
                            $semesterx = "".( ( $data[tahun] - 1 - $d[ANGKATAN] ) * 2 + $data[semester] )."";
							
							//hapus hafizd
                            /*if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
                            {
								#echo "ccc";exit();
                                $semesterx = getsemesetermahasiswa( $idmahasiswa, $data[tahun], $data[semester] ) + 0;
                            }*/
                            $kurawal = "(";
                            $kurtutup = ")";
                        }
						#echo "nyampe";exit();
						#echo $data[tahun]."mmm".$data[semester];exit();
                        if ( $data[semester] != 3 && $semesterx <= 0 )
                        {
							#echo "KKK";exit();
                            $errmesg = "Tahun Ajaran salah. Mahasiswa ybs belum masuk pada tahun ajaran yang dipilih.";
                            $aksi = "tambahawal";
							#echo $aksi;
                        }
                        else
                        {
							#echo "loncat";exit();
                            #printjudulmenukecil( "<b>Edit Data Pengambilan Mata Kuliah" );
                            #printmesg( $errmesg );
							echo "<div class=\"page-content\">
									<div class=\"container-fluid\">
										<div class=\"row\">
											<div class=\"col-md-12\">
											
												<!-- BEGIN SAMPLE FORM PORTLET-->
												<div class=\"portlet light\">";
													printmesg( $errmesg );
													echo "<div class=\"portlet-body form\">
															<div class='tab-pane' id='tab_1'>
																<div class='portlet box blue'>
																	<div class='portlet-title'>
																		<div class='caption'>";
																			printmesg("Edit Data Pengambilan KRS");
													echo"				</div>																	
																	</div>
																	<div class='portlet-body form'>
																			<div class=\"portlet-body\">
																				<div class=\"table-scrollable\">";
                            $angkatanx = $d[ANGKATAN];
                            if ( $data[semester] == 2 )
                            {
                                $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
                            }
                            else
                            {
                                $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
                            }
                            $semesterkrs = $semesterx;
                            #$tmpcetak .= "\n\t\t\t\t<br>\n\t\t\t\t<table class=form>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform width=250>Tahun Ajaran</td>\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']} ".$arraysemester[$data[semester]]."</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform>Semester </td>\n\t\t\t\t\t\t<td > {$semesterx}  </td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=judulform>NIM</td>\n\t\t\t\t\t\t<td >{$idmahasiswa}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >Nama</td>\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >Angkatan</td>\n\t\t\t\t\t\t<td >{$d['ANGKATAN']}</td>\n\t\t\t\t\t</tr>";
                            $tmpcetak .= "<table class=\"table table-striped table-bordered table-hover\">
											<tr>
												<td class=judulform width=250>Tahun Ajaran</td>
												<td >".( $data[tahun] - 1 )."/{$data['tahun']} ".$arraysemester[$data[semester]]."</td>
											</tr>
											<tr>
												<td class=judulform>Semester </td>
												<td > {$semesterx}  </td>
											</tr>
											<tr>
												<td class=judulform>NIM</td>
												<td >{$idmahasiswa}</td>
											</tr>
											<tr>
												<td >Nama</td>
												<td >{$d['NAMA']}</td>
											</tr>
											<tr>
												<td >Angkatan</td>
												<td >{$d['ANGKATAN']}</td>
											</tr> ";
                    
							if ( $sistemkrs == 0 )
                            {
                                $tmpcetak .= "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >IP {$jtrakm} ";
                                if ( 0 < $semesteracuan )
                                {
                                    $tmpcetak .= "{$semesteracuan} Semester Lalu";
                                }
                                else
                                {
                                    $tmpcetak .= "semester ini";
                                }
                                $tmpcetak .= "</td>\n\t\t\t\t\t\t<td ><b>{$ips}</td>\n\t\t\t\t\t</tr>";
                                $sksmaksimumsp = $sksmaksimum;
                                if ( $sksmaksimumsp == 0 - 1 )
                                {
                                    $sksmaksimumsp = $sksmaksimum2;
                                }
                                $tmpcetak .= "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td >SKS Semester Maksimum </td>\n\t\t\t\t\t\t<td ><b>{$sksmaksimumsp}</td>\n\t\t\t\t\t</tr>";
                            }
                            $tmpcetak .= "					</table>";
                            $idprodimhs = $d[IDPRODI];
                            $kodeprodi = $d[KDPSTMSMHS];
                            $kodejenjang = $d[KDJENMSMHS];
                            $angkatan = $d[ANGKATAN];
                            unset( $arraysyaratkrs );
                            $q = "SELECT * FROM syaratkrs WHERE IDPRODI='{$idprodimhs}' ORDER BY SKS DESC";
                            $hkrs = mysqli_query($koneksi,$q);
                            
							#echo $q;exit();
							/*while ( !( 0 < sqlnumrows( $hkrs ) ) || !( $dkrs = sqlfetcharray( $hkrs ) ) )
                            {
                                $arraysyaratkrs["{$dkrs['SKS']}"] = "{$dkrs['IPS']}";
                            }*/
							if(0 < sqlnumrows( $hkrs )){
							
								while($dkrs=sqlfetcharray($hkrs)){
								
									$arraysyaratkrs["$dkrs[SKS]"]="$dkrs[IPS]";
								}
							
							}
                            if ( $idprodi == "" )
                            {
                                $idprodi = $d[IDPRODI];
                            }
                            /*$tmpcetak .= "\n\t\t\n\t\t<table>\n\t\t<tr valign=top><td width=50%>\n\t\t<b>Kurikulum Mata Kuliah Semester Ini</b><br>\n\t\t<b>Klik nama mata kuliah untuk melihat Jadwal Kuliah\n\t\t\n\t\t\n\t\t<form  action=index.php method=post>\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\n\t\t\t".createinputhidden( "aksi", "{$aksi}", "" )."\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\n\t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" )."\n\n\t\t</form>";
                            */
							//tutup div kotak atas
							/*$tmpcetak.="				
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>";*/
							#$qkurikulum = "";
                            /*if ( getaturan( "KURIKULUM" ) == 1 && getfield( "STPIDMSMHS", "msmhs", "WHERE NIMHSMSMHS='{$users}' " ) == "B" && !isadacuti( $users ) )
                            {
								echo "mmm";
                                $semx = getsemesetermahasiswa( $users, $data[tahun], $data[semester] );
                                $qkurikulum = " AND tbkmk.SEMESTBKMK+0 = '{$semx}' ";
                                $quniontidaklulus = "\n    \n    UNION\n\n      SELECT DISTINCT tbkmk.KDKMKTBKMK AS ID,tbkmk.NAKMKTBKMK AS NAMA  ,\n            tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     \n            SEMESTBKMK  +0 AS SEMESTER,\n            tbkmk.THSMSTBKMK\n      \t\tFROM  tbkmk,trnlm\n      \t\tWHERE\n      \t\t   \n      \t\t  tbkmk.THSMSTBKMK<'".( $data[tahun] - 1 )."{$data['semester']}' AND\n      \t\t  tbkmk.STKMKTBKMK='A' AND\n      \t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' )) AND\n      \t\t\ttbkmk.KELOMPOKKURIKULUM='{$kelompokkurikulum}'    AND\n      \t\t\t\n      \t\t\ttbkmk.KDPTITBKMK=trnlm.KDPTITRNLM AND\n      \t\t\ttbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\n      \t\t\ttbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND\n      \t\t\ttbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND\n      \t\t\ttbkmk.KDKMKTBKMK=trnlm.KDKMKTRNLM AND\n      \t\t\ttrnlm.NIMHSTRNLM='{$users}' AND\n      \t\t\t( trnlm.NLAKHTRNLM LIKE 'D%' OR trnlm.NLAKHTRNLM LIKE 'E%'  )\n    \n    ";
                            }*/
							$qkurikulum="";
if (getaturan("KURIKULUM")==1  // Aturan Tampilan Batam
  && 
  getfield("STPIDMSMHS","msmhs","WHERE NIMHSMSMHS='$users' ")=="B" // Mahasiswa Baru, Bukan Pindahan
  && 
  !isadacuti($users) // Tidak ada Cuti
  
  ) {
    
    $semx=getsemesetermahasiswa($users,$data[tahun],$data[semester]);
    $qkurikulum=" AND tbkmk.SEMESTBKMK+0 = '$semx' ";
    
      $quniontidaklulus="
    
    UNION

      SELECT DISTINCT tbkmk.KDKMKTBKMK AS ID,tbkmk.NAKMKTBKMK AS NAMA  ,
            tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     
            SEMESTBKMK  +0 AS SEMESTER,
            tbkmk.THSMSTBKMK
      		FROM  tbkmk,trnlm
      		WHERE
      		   
      		  tbkmk.THSMSTBKMK<'".($data[tahun]-1)."$data[semester]' AND
      		  tbkmk.STKMKTBKMK='A' AND
      			(  (KDPSTTBKMK='$kodeprodi' AND KDJENTBKMK='$kodejenjang' )) AND
      			tbkmk.KELOMPOKKURIKULUM='$kelompokkurikulum'    AND
      			
      			tbkmk.KDPTITBKMK=trnlm.KDPTITRNLM AND
      			tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND
      			tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND
      			tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND
      			tbkmk.KDKMKTBKMK=trnlm.KDKMKTRNLM AND
      			trnlm.NIMHSTRNLM='$users' AND
      			( trnlm.NLAKHTRNLM LIKE 'D%' OR trnlm.NLAKHTRNLM LIKE 'E%'  )
    
    ";
  
  }
                            #$q = "SELECT tbkmk.KDKMKTBKMK AS ID,tbkmk.NAKMKTBKMK AS NAMA  ,\n      tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,    \n      SEMESTBKMK  +0 AS SEMESTER,\n      tbkmk.THSMSTBKMK\n\t\tFROM  tbkmk\n\t\tWHERE\n\t\t   \n\t\t  tbkmk.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\n\t\t  tbkmk.STKMKTBKMK='A' AND\n\t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' )) AND\n\t\t\ttbkmk.KELOMPOKKURIKULUM='{$kelompokkurikulum}'\n\t\t\t\n\t\t\t{$qkurikulum}\n\t\t\t\n\t\t\t{$quniontidaklulus}\n\t\t\t\n\t\t\tORDER BY SEMESTER,ID\n\t\t";
							 	          $q="SELECT tbkmk.KDKMKTBKMK AS ID,tbkmk.NAKMKTBKMK AS NAMA  ,
      tbkmk.KDWPLTBKMK,SKSMKTBKMK AS SKS ,    
      SEMESTBKMK  +0 AS SEMESTER,
      tbkmk.THSMSTBKMK
		FROM  tbkmk
		WHERE
		   
		  tbkmk.THSMSTBKMK='".($data[tahun]-1)."$data[semester]' AND
		  tbkmk.STKMKTBKMK='A' AND
			(  (KDPSTTBKMK='$kodeprodi' AND KDJENTBKMK='$kodejenjang' )) AND
			tbkmk.KELOMPOKKURIKULUM='$kelompokkurikulum'
			
			$qkurikulum
			
			$quniontidaklulus
			
			ORDER BY SEMESTER,ID
		";
							#echo $q;
						   $hp = mysqli_query($koneksi,$q);
                            if ( sqlnumrows( $hp ) <= 0 )
                            {
                                printmesg( "Data Mata Kuliah Jurusan / Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
                            }
                            else
                            {
								
                                #$tmpcetak .= "\n\t\t\t\t<table  class=form>\n\t\t\t\t<tr align=center class=juduldata>\n\t\t\t\t\t<td colspan=8 align=right>\n\t\t\t\t\t\t<a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='ambil' onClick=\"return confirm('Proses Pengambilan Mata Kuliah Hanya Bisa Dilakukan Satu Kali,Yakin Akan Diproses?');\"><!--<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">--></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr align=center class=juduldata>\n\t\t\t\t\t<td>No  </td>\n\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\n\t\t\t\t\t<td>Wajib/Pilihan</td>\n\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t<td>Syarat</td>\n \t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t<td>Ambil </td>\n\t\t\t\t</tr>\n\t\t\t";
                                /*$tmpcetak .="<form name=form action=index.php method=post>
												".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "sessid", "{$token}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" );
								*/
								$tmpcetak.="<form name=form action=index.php method=post>
												".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."
												".createinputhidden( "aksi", "updatemk", "" )."
												".createinputhidden( "pilihan", "{$pilihan}", "" )."
												".createinputhidden( "idprodi", "{$idprodi}", "" )."
												".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."
												".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."
												".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."
												".createinputhidden( "data[semester]", "{$data['semester']}", "" )."
											";
								$tmpcetak.="
								<div class=\"row\">
									<div class=\"col-md-6\">	
										<div class=\"m-portlet m-portlet--mobile\">
													<div class=\"m-portlet__head\">
														<div class=\"m-portlet__head-caption\">
															<div class=\"m-portlet__head-title\">
																<h3 class=\"m-portlet__head-text\">
																	Kurikulum Mata Kuliah Semester Ini
																</h3>
															</div>					
														</div>
													</div>";
						$tmpcetak.="	<div class=\"m-portlet\">			
											<div class=\"m-section__content\">
												<div class=\"table-responsive\">
													<table class=\"table table-bordered table-hover\">
														<thead>
															<tr align=center class=juduldata>\n\t\t\t\t\t<td colspan=8 align=left>\n\t\t\t\t\t\t<a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Proses Pengambilan Mata Kuliah Hanya Bisa Dilakukan Satu Kali,Yakin Akan Diproses?');\"><!--<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">--></td>\n\t\t\t\t</tr>
															<tr align=center class=juduldata>\n\t\t\t\t\t<td>No  </td>\n\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\n\t\t\t\t\t<td>Wajib/Pilihan</td>\n\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t<td>Syarat</td>\n \t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t<td>Ambil </td>\n\t\t\t\t</tr>\n\t\t\t";	
						$tmpcetak.="					</thead>
														<tbody>";			
								$i = 0;
                                $semlama = "";
                                $startawal = 0;
                                $totalskswajib = 0;
                                while ( $dp = sqlfetcharray( $hp ) )
                                {
									#echo "kk";
                                    #if ( $pilihtampil == 1 && !( $dp[SEMESTER] % 2 == $semesterx % 2 ) && $dp[SEMESTER] != 0 )
                                    #{
                                    #    continue;
                                    #}
									if ($pilihtampil==1 ) 				{
											   // echo "$dp[SEMESTER] $semesterx <br>";
											   if ((!($dp[SEMESTER]%2==$semesterx%2)  )  && $dp[SEMESTER]!=0  ) {
													#echo "$dp[SEMESTER]<br>";
											continue;
										 }
									}	
                                    if ( $semlama != $dp[SEMESTER] )
                                    {
                                        /*if ( $semlama != "" )
                                        {
                                            #$tmpcetak .= "\n\t\t\t\t\t\t\t <tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=4>Total SKS Semester </td>\n\t\t\t\t\t\t\t\t<td align=center>".$totalskskrs[$semlama]." </td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=right>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua] </a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\n\t\t\t\t\t\t\t\t\t<script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=true;\t\t\t\t\t\t\t\t\t\t\t\t  \n\t\t\t\t\t\t\t\t\t\t//\t\teval('form.idambil_'+i+'.checked=true');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=false;\n\t\t\t\t\t\t\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                                            $tmpcetak .= "\n\t\t\t\t\t\t\t <tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=4>Total SKS Semester </td>\n\t\t\t\t\t\t\t\t<td align=center>".$totalskskrs[$semlama]." </td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=right>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua] </a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='ambil' onClick=\"return confirm('Proses Pengambilan Mata Kuliah Hanya Bisa Dilakukan Satu Kali,Yakin Akan Diproses?');\">\n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\n\t\t\t\t\t\t\t\t\t<script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=true;\t\t\t\t\t\t\t\t\t\t\t\t  \n\t\t\t\t\t\t\t\t\t\t//\t\teval('form.idambil_'+i+'.checked=true');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=false;\n\t\t\t\t\t\t\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                                            $startawal = $i;
                                        }*/
										if ($semlama!="") {
												$tmpcetak.= "
												<tr class=juduldata>
													<td colspan=8 align=left>
														<a href='#' onClick='cekall$semlama();return false;'>[pilih semua] </a>
														<a href='#' onClick='uncekall$semlama();return false;'>[batal pilih semua]</a> 
										<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">
										<!--<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">-->
														<script>
															var start$semlama=$startawal;
															var count$semlama=$i;
															function cekall$semlama() {
																var i=0;
																for (i=start$semlama;i<count$semlama ;i++) {
																	 x=document.getElementsByName('idambil_'+i);
																	 x[0].checked=true;												  
															//		eval('form.idambil_'+i+'.checked=true');
																}
															}
															function uncekall$semlama() {
																var i=0;
																for (i=start$semlama;i<count$semlama ;i++) {
																	 x=document.getElementsByName('idambil_'+i);
																	 x[0].checked=false;
																	//eval('form.idambil_'+i+'.checked=false');
																}
															}
														</script>
														
													</td>
												</tr>							
												";
												$startawal=$i;
											}
                                        $semlama_tmp = $semlama;
                                        $semlama = $dp[SEMESTER];
                                        $tmpcetak .= "\n\n\n \t\t\t\t\t\t{$tmp}\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8>Semester {$dp['SEMESTER']} </td>\n\t\t\t\t\t\t\t</tr>\n\n\t\t\t\t\t\t";
                                    }
                                    $totalskskrs += $dp[SEMESTER];
                                    $kelas = kelas( $i );
                                    $q = "SELECT syaratpengambilanmk.*  \n        FROM syaratpengambilanmk  \n        WHERE\n        syaratpengambilanmk.IDMAKUL='{$dp['ID']}' AND\n        syaratpengambilanmk.TAHUN='{$data['tahun']}'\n        AND syaratpengambilanmk.SEMESTER='{$data['semester']}'\n         \n         ";
                                    $hss = mysqli_query($koneksi,$q);
                                    $daftarsyarat = "";
                                    $syaratok = 1;
                                    $jmlsyarat = sqlnumrows( $hss );
                                    $totalsyarat = 0;
                                    if ( 0 < sqlnumrows( $hss ) )
                                    {
                                        $syaratok = 0;
                                        while ( $dss = sqlfetcharray( $hss ) )
                                        {
                                            $daftarsyarat .= "{$dss['IDSYARAT']}, {$dss['NILAI']}, {$dss['BOBOT']} <br>";
                                            $q = "SELECT pengambilanmk.NILAI,BOBOT,SIMBOL  \n            FROM pengambilanmk  \n            WHERE\n            pengambilanmk.IDMAKUL='{$dss['IDSYARAT']}' AND\n            IDMAHASISWA='{$idmahasiswa}'\n            AND BOBOT >= {$dss['BOBOT']} AND SIMBOL!='MD'\n             ";
                                            $hss2 = mysqli_query($koneksi,$q);
                                            if ( 0 < sqlnumrows( $hss2 ) )
                                            {
                                                ++$totalsyarat;
                                            }
                                            $logicsyarat = $dss[LOGIC];
                                        }
                                        $daftarsyarat .= "{$logicsyarat}";
                                    }
                                    if ( ( $jmlsyarat <= $totalsyarat && $logicsyarat == "AND" || 0 < $totalsyarat && $logicsyarat == "OR" ) && 0 < $jmlsyarat )
                                    {
                                        $syaratok = 1;
                                    }
                                    $tmpcetak .= "\n\t\t\t\t\t<tr align=center {$kelas}>\n\t\t\t\t\t\t<td>  ".( $i + 1 )."\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][semester]", "{$dp['SEMESTER']}", "class=masukan size=2" )."\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][sks]", "{$dp['SKS']}", "class=masukan size=2" )."\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][nama]", "{$dp['NAMA']}", "class=masukan  " )."\n\t\t\t\t\t\t</td>\n\t\t\t\t\t\t<td>{$dp['ID']}</td>";
                                    /*if ( $STEIINDONESIA != 1 )
                                    {
                                        $tmpcetak .= "  \n  \t\t\t\t\t\t<td align=left><a class='lihatjadwal".( $i + 1 )."' href='lihatjadwal.php?tahun={$data['tahun']}&semester={$data['semester']}&idmakul={$dp['ID']}&idprodi={$idprodi}&namamakul=".str_replace( " ", "_", $dp[NAMA] )."' >{$dp['NAMA']}</a></td>";
                                        $colorbox .= "jQuery('a.lihatjadwal".( $i + 1 )."').colorbox();\n";
                                    }
                                    else
                                    {*/
                                        $tmpcetak .= "  \n  \t\t\t\t\t\t<td align=left>{$dp['NAMA']}</td>";
                                    #}
                                    $tmpcetak .= "  \n\t\t\t\t\t\t<td align=center>".$arrayjenismk[$dp[KDWPLTBKMK]]."</td>\n\t\t\t\t\t\t<td>{$dp['SKS']}</td>\n            <td nowrap>{$daftarsyarat}</td>";
                                    unset( $arraykelasdosenpengajar );
                                    if ( $syaratok == 1 )
                                    {
                                        if ( getaturan( "KELASKRSONLINE" ) == 0 )
                                        {
                                            $tmpcetak .= "\n     \t\t\t\t\t\t<td>".createinputselect( "datax[".$dp[ID]."][kelas]", $arraylabelkelas, $dx[KELAS], "", "" )."\n                   \n                 \n                 </td>";
                                            $tmpcetak .= "\n    \t\t\t\t\t\t<td> \n                ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=masukan" )."\n                ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=masukan" )."\n                \n                </td>";
                                        }
                                        else if ( getaturan( "KELASKRSONLINE" ) == 1 )
                                        {
                                            $q = "SELECT DISTINCT KELAS FROM dosenpengajar \n              WHERE IDMAKUL='{$dp['ID']}' AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}' AND\n              IDPRODI='{$idprodi}'\n              ORDER BY KELAS ";
                                            $hkelas = mysqli_query($koneksi,$q);
                                            if ( 0 < sqlnumrows( $hkelas ) )
                                            {
                                                while ( $dkelas = sqlfetcharray( $hkelas ) )
                                                {
                                                    $arraykelasdosenpengajar[$dkelas[KELAS]] = $arraylabelkelas[$dkelas[KELAS]];
                                                }
                                                $tmpcetak .= "\n   \t\t\t\t\t\t<td> ".createinputselect( "datax[".$dp[ID]."][kelas]", $arraykelasdosenpengajar, $dx[KELAS], "", "" )."\n                 \n               \n               </td>";
                                                $tmpcetak .= "\n  \t\t\t\t\t\t<td> \n              ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=masukan" )."\n              ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=masukan" )."\n              \n              </td>";
                                            }
                                            else
                                            {
                                                $tmpcetak .= "\n                <td align=center>tidak ada dosen pengajar</td>\n                <td align=center>-</td>\n                ";
                                            }
                                        }
                                        $arraycekmakul[$dp[ID]] = $i;
                                    }
                                    else
                                    {
                                        $tmpcetak .= "<td colspan=2 align=center nowrap><b>tidak memenuhi syarat</td>";
                                    }
                                    $tmpcetak .= "\n\t\t\t\t\t</tr>\n\t\t\t\t";
                                    if ( $dp[THSMSTBKMK] == ( $data[tahun] - 1 )."{$data['semester']}" )
                                    {
                                        $totalskswajib += $dp[SKS];
                                    }
                                    ++$i;
                                }
								$tmpcetak.="</tbody>";
                                #$tmpcetak .= "\n\t\t\t\t\t\t\t <tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=4>Total SKS Semester </td>\n\t\t\t\t\t\t\t\t<td align=center>".$totalskskrs[$semlama]." </td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=right>\n\t\t\t\t\t\t\t\t\t <a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua] </a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\n\t\t\t\t\t<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\n\t\t\t\t\t\t\t\t\t<script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tvar x;\n\t\t\t\t\t\t\t\t\t\t\t//alert('tes');\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n \n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=true;\n \n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t\t\t\t\t\t\tx=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=false;\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                                $tmpcetak .= "\n\t\t\t\t\t\t\t <tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=4>Total SKS Semester </td>\n\t\t\t\t\t\t\t\t<td align=center>".$totalskskrs[$semlama]." </td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t\t<td  >&nbsp;</td>\n\t\t\t\t\t\t\t</tr>";
								$tmpcetak .= "<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=8 align=left>\n\t\t\t\t\t\t\t\t\t <a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua] </a>\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Proses Pengambilan Mata Kuliah Hanya Bisa Dilakukan Satu Kali,Yakin Akan Diproses?');\"><!--<input type=submit class=masukan name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">--><script>\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tvar x;\n\t\t\t\t\t\t\t\t\t\t\t//alert('tes');\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n \n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=true;\n \n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=false');\n\t\t\t\t\t\t\t\t\t\t\t\tx=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=false;\n\t\t\t\t\t\t \t\t\t\t\t}\n\t\t\t\t\t\t \t\t\t\t}\n\t\t\t\t\t\t \t\t\t</script>\n\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
                                $tmpcetak .= "\n\n\t\t\t</table>";
								#$tmpcetak .= "<script>\n            jQuery(document).ready(function () {\n                {$colorbox}\n            });\n        </script>";
								$tmpcetak .= "<input type=hidden name=count value='{$i}'>\n\n\n\t\t\t\n\t\t\t</form>\n\n\t\t\t";
								$tmpcetak.="	</div>  
											</div>
										</div>
									</div>
								</div>";
								$tmpcetak .= "<script>\n \t\t\t\tvar count={$i};\n\t\t\t\tfunction cekall() {\n\t\t\t\t\tvar i=0;\n\t\t\t\t\tfor (i=0;i<count ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=true;\t\t\t\t\t\t \n\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=true');\n \t\t\t\t\t}\n \t\t\t\t\t//alert(skslebih());\n \t\t\t\t}\n\t\t\t\tfunction uncekall() {\n\t\t\t\t\tvar i=0;\n\t\t\t\t\tfor (i=0;i<count ;i++) {\n\t\t\t\t\t\t\t\t\t\t\t\t x=document.getElementsByName('idambil_'+i);\n\t\t\t\t\t\t\t\t\t\t\t\t x[0].checked=false;\n\t\t\t\t\t\t//eval('form.idambil_'+i+'.checked=false');\n \t\t\t\t\t}\n \t\t\t\t}\n \n \n \t\t\t</script>";
								/*$tmpcetak .= "\n \t\t\t\n\t\t\t</td>\n\n      <td width=50%>\n       <b>Mata Kuliah Yang Telah Diambil <br></b>\n       [ <a href='index.php?pilihan={$pilihan}&aksi={$aksi}&pilihtampil2=0'>tampilkan semua</a> ] \n       [ <a href='index.php?pilihan={$pilihan}&aksi={$aksi}&pilihtampil2=1'>tampilkan semester ini saja</a> ]<br>\n \t\t\t\n\t\t\t";
								*/
								$tmpcetak.="
										<div class=\"col-md-6\">	
											<div class=\"m-portlet m-portlet--mobile\">
														<div class=\"m-portlet__head\">
															<div class=\"m-portlet__head-caption\">
																<div class=\"m-portlet__head-title\">
																	<h3 class=\"m-portlet__head-text\">
																		Mata Kuliah Yang Telah Diambil
																	</h3>
																</div>					
															</div>
														</div>";
							}
                            $q = "SELECT IDMAHASISWA FROM pengambilanmk \n          WHERE \n          IDMAHASISWA='{$idmahasiswa}'\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\n          AND SEMESTER='{$data['semester']}'";
                            #echo $q.'<br>';
							$h = mysqli_query($koneksi,$q);
                            if ( sqlnumrows( $h ) <= 0 )
                            {
                                $q = "delete FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' \n            AND THSMSTRAKM='".( $data[tahun] - 1 )."{$data['semester']}'";
                                mysqli_query($koneksi,$q);
                            }
                            if ( $pilihtampil2 == 0 )
                            {
                                $qfield = "";
                            }
                            else
                            {
                                $qfield = "AND pengambilanmk.TAHUN='{$data['tahun']}' AND pengambilanmk.SEMESTER ='{$data['semester']}'";
                            }
                            $q = "\n\t\t\t\tSELECT \n\t\t\t\tpengambilanmk.* ,\n \t\t\t\tSKSMAKUL AS SKS,\n \t\t\t\ttbkmk.NAKMKTBKMK AS NAMA\n\t\t\t\tFROM pengambilanmk,tbkmk,msmhs\n\t\t\t\tWHERE\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswa}'\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA AND\n\t\t\t\ttbkmk.KELOMPOKKURIKULUM='{$kelompokkurikulum}'\n\t\t\t\t{$qfield}\n\t\t\t\tORDER BY \n\t\t\t\tpengambilanmk.TAHUN,pengambilanmk.SEMESTER \n\t\t\t";
                            #echo $q;
							$h = mysqli_query($koneksi,$q);
                            $tmpcetak .= mysqli_error($koneksi);
							$tmpcetak.="	<div class=\"m-portlet\">			
											<div class=\"m-section__content\">
												<div class=\"table-responsive\">";
                            if ( sqlnumrows( $h ) <= 0 )
                            {
                                printmesg( "Data Pengambilan Mata Kuliah belum ada<br><BR>" );
                            }
                            else
                            {
                                #$tmpcetak .= "\n\t\t\t\t\t<table class=data>\n\t\t\t\t\t<tr class=juduldata align=center>\n\t\t\t\t\t\t<td>No</td>\n\t\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t\t<td>Nama M-K</td>\n\t\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\n\t\t\t\t\t\t<td>Sem M-K</td>\n\t\t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t</tr>\n\t\t\t\t";
                                $tmpcetak.="		<table class=\"table table-bordered table-hover\">
														<thead>	
															<tr class=juduldata align=center>\n\t\t\t\t\t\t<td>No</td>\n\t\t\t\t\t\t<td>Kode</td>\n\t\t\t\t\t\t<td>Nama M-K</td>\n\t\t\t\t\t\t<td>SKS</td>\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\n\t\t\t\t\t\t<td>Sem M-K</td>\n\t\t\t\t\t\t<td>Kelas</td>\n\t\t\t\t\t</tr>\n\t\t\t\t";
								$tmpcetak.= "			</thead>
														<tbody>";
								$i = 1;
                                $semlama = "";
                                $tahunlama = "";
                                while ( $d = sqlfetcharray( $h ) )
                                {
                                    $semesterx = ( $d[TAHUN] - 1 - $angkatanx ) * 2 + $d[SEMESTER];
                                    if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
                                    {
                                        $semesterx = getsemesetermahasiswa( $idmahasiswa, $d[TAHUN], $d[SEMESTER] ) + 0;
                                    }
                                    $semestertulis = $semesterx;
                                    $kurawal = "(";
                                    $kurakhir = ")";
                                    if ( $d[SEMESTER] == 3 )
                                    {
                                        $semesterx += 0.5;
                                        $semestertulis = "";
                                        $kurawal = $kurakhir = "";
                                    }
                                    $tmp = "";
                                    if ( $semlama != $semesterx )
                                    {
                                        if ( $semlama != "" )
                                        {
                                            $tmp = "\n\t\t\t\t\t\t\t\t<tr class=juduldata >\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\n\t\t\t\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t\t\t\t</tr>";
                                            include( "edittrakm.php" );
                                            $q = "UPDATE trakm SET\n\t\t\t\t\t\t\t   SKSEMTRAKM='{$total[$semlama]}',\n\t\t\t\t\t\t\t   SKSTTTRAKM='{$totalsks}'\n                WHERE\n                NIMHSTRAKM='{$idmahasiswa}'\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\n                ";
                                            mysqli_query($koneksi,$q);
                                        }
                                        $semlama = $semesterx;
                                        $tmpcetak .= "\n \t\t\t\t\t\t{$tmp}\n\t\t\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t\t\t<td colspan=7>Semester {$semestertulis}   </td>\n\t\t\t\t\t\t\t</tr>";
                                    }
                                    $kelas = kelas( $i );
                                    $tmpa = "";
                                    if ( $semesterkrs == $semestertulis )
                                    {
                                        $tmpa = "<a href='#' onClick=\"\n              if (form.idambil_".$arraycekmakul[$d[IDMAKUL]].".checked == true) {\n                eval('form.idambil_'+".$arraycekmakul[$d[IDMAKUL]]."+'.checked=false');\n              } else {\n                eval('form.idambil_'+".$arraycekmakul[$d[IDMAKUL]]."+'.checked=true');\n              }\n              return false;\">";
                                    }
                                    $tmpcetak .= "\n\t\t\t\t\t<tr {$kelas}>\n\t\t\t\t\t\t<td align=center>{$i}</td>\n\t\t\t\t\t\t<td>\n            {$tmpa} {$d['IDMAKUL']}</td>\n\t\t\t\t\t\t<td> {$d['NAMA']}</td>\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\n\t\t\t\t\t\t<td align=center>".$arraylabelkelas[$d[KELAS]]."</td>\n\t\t\t\t\t</tr>";
                                    $totalsks += $d[SKS];
                                    $total += $semesterx;
                                    $tahunlama = $d[TAHUN];
                                    $sem = $d[SEMESTER] % 2;
                                    if ( $sem == 0 )
                                    {
                                        $sem = 2;
                                    }
                                    $idmakul = $d[IDMAKUL];
                                    $kelasmk = $d[KELAS];
                                    include( "editrnlm.php" );
                                    ++$i;
                                }
                                if ( $semlama != "" )
                                {
                                    $tmpcetak .= "\n\t\t\t\t\t\t<tr class=juduldata >\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}  </td>\n\t\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t\t</tr>";
                                    include( "edittrakm.php" );
                                    $q = "UPDATE trakm SET\n\t\t\t\t\t\t\t  SKSEMTRAKM='{$total[$semlama]}',\n\t\t\t\t\t\t\t   SKSTTTRAKM='{$totalsks}'\n                WHERE\n                NIMHSTRAKM='{$idmahasiswa}'\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\n                ";
                                    mysqli_query($koneksi,$q);
                                }
                                $tmpcetak .= " \n\t\t\t\t\t<tr class=juduldata>\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\n\t\t\t\t\t\t<td colspan=3></td>\n\t\t\t\t\t</tr>";
                                #$tmpcetak .= "\n\t\t\t\t\t</table>\n\t\t\t\t\t\n\t\t\t\t\t<div align=center style='font-size:16pt;'>\n          <br> \n           <a href='cetakkrs.php?idmahasiswaupdate={$users}&tahunupdate={$data['tahun']}&semesterupdate={$data['semester']}' target=_blank><b >Cetak KRS</b></a> </div>\n\t\t\t\t\t<br>\n\t\t\t\t";
                                #$tmpcetak .= "\n\t\t\t\t\t</table>";
								$tmpcetak .= "</tbody></table>";
								$tmpcetak .= "<div align=center style='font-size:16pt;'>\n          <br> \n           <a href='cetakkrs.php?idmahasiswaupdate={$users}&tahunupdate={$data['tahun']}&semesterupdate={$data['semester']}' target=_blank><b >Cetak KRS</b></a> </div>\n\t\t\t\t\t<br>\n\t\t\t\t";
                                
								if ( $total[$semesterkrs] + 0 == 0 )
                                {
                                    $q = "UPDATE trakm SET\n\t\t\t\t\t\t\t  SKSEMTRAKM='0'                \n                WHERE\n                NIMHSTRAKM='{$idmahasiswa}'\n                AND THSMSTRAKM='".( $tahunupdate - 1 )."{$semesterupdate}'\n                ";
                                    mysqli_query($koneksi,$q);
                                }
                                if ( $sistemkrs == 0 && is_array( $arraysyaratkrs ) )
                                {
                                    foreach ( $arraysyaratkrs as $k => $v )
                                    {
                                        if ( $total[$semesterkrs] < $k )
                                        {
                                            continue;
                                        }
                                        if ( $ips < $v )
                                        {
                                            $cancel = 1;
                                            printmesg( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", syarat SKS >= {$k} adalah IP {$jtrakm} {$semesteracuan} semester yg lalu minimal {$v}. IP {$jtrakm} yg lalu Anda adalah {$ips}." );
                                            break;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                #$tmpcetak .= "\t\t\t</tr>\n\t\t\t</table>\n\t\t\t\t\t\n\t\t\t\t\t<br>";
				$tmpcetak .= "			</div>
						</div>
					</div>
				</div>
			</div>";
                echo $tmpcetak;
            }
        }
        if ( $aksi == "" )
        {
            #printmesg( $errmesg );
			echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						";
							printmesg( $errmesg );
			echo "			<div class='portlet-title'>";
									printmesg("KRS Online");
					echo "	</div>";
											
			echo "			<div class='portlet-title'>";
									printmesg("Anda dapat mengedit Kartu Rencana Studi untuk Semester ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate} dari tanggal <b>{$tanggalmulai}</b> s.d <b>{$tanggalselesai}</b>. Untuk mengedit KRS, silahkan klik link di bawah ini\n    <br><br>\n    <a href='index.php?pilihan={$pilihan}&aksi=tampiledit&pilihtampil2=1'>Edit KRS</a>\n ");
			echo "			</div>
						</div>
					</div>
				</div>
			</div>";
								
            #echo "				\n  <table>\n    <tr>\n      <td>\n    Anda dapat mengedit Kartu Rencana Studi untuk Semester ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate} dari tanggal <b>{$tanggalmulai}</b> s.d <b>{$tanggalselesai}</b>. Untuk mengedit KRS, silahkan klik link di bawah ini\n    <br><br>\n    <a href='index.php?pilihan={$pilihan}&aksi=tampiledit&pilihtampil2=1'>Edit KRS</a>\n    </td>\n    </tr>\n    </table>\n    \n  ";
        }
    }
}
?>
