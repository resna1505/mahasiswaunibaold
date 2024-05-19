<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
#echo $aksi2.$aksi;exit();
$q = "SELECT * FROM aturan ";
$h2 = doquery( $q, $koneksi );
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $aturankeuangan = $d2[KRSONLINE];
}
printjudulmenu( "Pembayaran Keuangan Mahasiswa" );
if ( $aksi == "Lanjut" )
{
	#echo "lll";exit();
    if ( getfieldfromtabel( $idmahasiswa, "ID", "mahasiswa" ) == "" )
    {
        $errmesg = "Data Mahasiswa dengan ID {$idmahasiswa} tidak ada.";
        $aksi = "";
    }
    else
    {
		#echo $aksi2.$aksi;exit();
        if ( $aksi2 == "hapus" )
        {
			#echo "iii";exit();
            if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
            {
				#echo "apa iya";exit();
                if ( $_GET['sessid'] != $_SESSION['token'] )
                {
                    $errmesg = token_err_mesg( "Keuangan", HAPUS_DATA );
                    $aksi2 = "Data Baru";
                }
                else
                {
                    $q = "DELETE FROM bayarkomponen WHERE ID='{$idhapus}'";
                    doquery( $q, $koneksi );
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data berhasil dihapus";
                        $q = "SELECT ID FROM transkeuangan WHERE KODE='BK-{$idhapus}'";
                        $h = doquery( $q, $koneksi );
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $d = sqlfetcharray( $h );
                            $q = "DELETE FROM detilkeuangansgm WHERE IDTRANS='{$d['ID']}'";
                            doquery( $q, $koneksi );
                            $q = "DELETE FROM transkeuangan WHERE ID='{$d['ID']}'";
                            doquery( $q, $koneksi );
                        }
                    }
                }
            }
            $aksi2 = "Data Baru";
        }
        if ( $aksi2 == "Simpan" )
        {
			#echo "jjj";exit();
            if ( $_POST['sessid'] != $_SESSION['token'] )
            {
                $errmesg = token_err_mesg( "Keuangan", SIMPAN_DATA );
                $aksi2 = "Data Baru";
            }
            else
            {
                $qperiode = "";
                if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunajaran}'";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}' ";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunbulan}' AND SEMESTER='{$bulan}' ";
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
                {
                    $qperiode = " AND TAHUNAJARAN='{$tahunc}' AND SEMESTER='{$semesterc}' ";
                }
                $q = "SELECT * FROM bayarkomponen WHERE \r\n        IDMAHASISWA='{$idmahasiswa}' AND \r\n        TANGGALBAYAR=DATE_FORMAT('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','%Y-%m-%d') AND \r\n        IDKOMPONEN='{$idkomponen}' AND JUMLAH='{$bayar}' \r\n        {$qperiode}\r\n        LIMIT 0,1";
                $hx = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hx ) )
                {
                    $errmesg = "Maaf sudah ada pembayaran dengan ID Komponen {$idkomponen} (".$arraykomponenpembayaran[$idkomponen].") pada tanggal {$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']} untuk mahasiswa {$idmahasiswa}";
                    $aksi2 = "Lanjut";
                   # unset( $_SESSION['token'] );
                }
				else{
					 unset( $_SESSION['token'] );
					if ( $idkomponen != "" )
					{
						#if ( $bayar + $diskon <= 0 )
						if ( $bayar + $diskon < 0 )
						{
							$errmesg = "Total pembayaran dan diskon (".cetakuang( $bayar + $diskon ).") harus diisi lebih dari Nol. \r\n            Proses penyimpanan tidak dilakukan.";
							$aksi2 = "Lanjut";
						}
						else
						{
							if ( $sisa < $bayar + $diskon )
							{
								$errmesg = "Total pembayaran dan diskon (".cetakuang( $bayar + $diskon ).") lebih daripada sisa yang harus dibayar (".cetakuang( $sisa ).") . \r\n            Proses penyimpanan tidak dilakukan.";
								$aksi2 = "Lanjut";
							}
							else
							{
								$errmesg = "OK DISIMPAN";
								$tahunbayar = $semesterbayar = "";
								if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
								{
									$tahunbayar = $tahunajaran;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
								{
									$tahunbayar = $tahun;
									$semesterbayar = $semester;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
								{
									$tahunbayar = $tahunc;
									$semesterbayar = $semesterc;
								}
								else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
								{
									$tahunbayar = $tahunbulan;
									$semesterbayar = $bulan;
								}
								$q = "INSERT INTO bayarkomponen \r\n        \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n        \t\t\t'{$bayar}','{$ket}',\r\n        \t\t\t'{$tahunbayar}','{$semesterbayar}','{$carabayar}','{$diskon}',\r\n              NOW(),'{$users}',NOW(),'{$denda}','{$biaya}','{$beasiswa}')";
								#echo $q;exit();
								doquery( $q, $koneksi );
								if ( 0 < sqlaffectedrows( $koneksi ) )
								{
									$ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$idkomponen} (".$bayar."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}\r\n        \t\t\t\t";
									buatlog( 54 );
									$jenisjurnal = $arrayakunjenisjurnal[$carabayar];
									#echo $jenisjurnal.'<br>';
									$idbayar = mysqli_insert_id($koneksi);
									$q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
									$h = doquery( $q, $koneksi );
									$d = sqlfetcharray( $h );
									if ( $d[MAX] == "" )
									{
										$idbaru = 1;
									}
									else
									{
										$idbaru = $d[MAX] + 1;
									}
									$q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','{$users}',NOW(),'BK-{$idbayar}')";
									#echo $q.'<br>';
									doquery( $q, $koneksi );
									if ( 0 < sqlaffectedrows( $koneksi ) )
									{
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = doquery( $q, $koneksi );
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										if ( $carabayar == 0 )
										{
											$idakun = $arrayakun[kas];
										}
										else
										{
											$idakun = $arrayakun[bank];
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)  ".
										"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayar + $denda )."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','D')\r\n                              ";
										#echo $q.'<br>';
										doquery( $q, $koneksi );
										$q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
										$h = doquery( $q, $koneksi );
										$d = sqlfetcharray( $h );
										if ( $d[MAX] == "" )
										{
											$iddetilbaru = 0;
										}
										else
										{
											$iddetilbaru = $d[MAX] + 1;
										}
										$q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN) ".
										"VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".( $bayar + $denda )."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar." \\ ".$arraysemesterbayar." \r\n                            ".$ket." ','K')\r\n                              ";
										#echo $q;
										doquery( $q, $koneksi );
									}
									#exit();

									$errmesg = "Data pembayaran berhasil disimpan";
									$aksi2 = "Data Baru";
								}
								else
								{
									$errmesg = "Data pembayaran tidak disimpan";
									$aksi2 = "Lanjut";
								}
							}
						}
					}
					else
					{
						$aksi2 = "Data Baru";
					}
				
				}
            }
        }
		#echo "lll";
        $q = "SELECT ID,NAMA,ANGKATAN,IDPRODI,GELOMBANG,SMAWLMSMHS,JENISKELAS FROM mahasiswa,msmhs \r\n      WHERE mahasiswa.ID=msmhs.NIMHSMSMHS AND mahasiswa.ID='{$idmahasiswa}' ";
        #echo $q.'<br>';
		$h = doquery( $q, $koneksi );
        $d = sqlfetcharray( $h );
        $angkatan = $d[ANGKATAN];
        $idprodi = $d[IDPRODI];
        $gelombang = $d[GELOMBANG];
        $jeniskelas = $d[JENISKELAS];
        if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
            $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
            $fieldjeniskelas = "\r\n            <tr>\r\n            <td>Jenis Kelas</td>\r\n            <td>".$arraykelasstei[$jeniskelas]."</td>\r\n            </tr>\r\n            ";
        }
        else
        {
            $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
            $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
        }
        $tmp = $d[SMAWLMSMHS];
        $tahunawal = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $tahunawal++;
        $semesterawal = $tmp[4];
        #if ( $aksi2 == "Lanjut" && getaturan( "KEUANGAN2" ) == 1 && $arrayjeniskomponenpembayaran[$idkomponen] == 3 && $idkomponen != 99 && $idkomponen != 98 )
        #{
		
		if ( $aksi2 == "Lanjut" && getaturan( "KEUANGAN2" ) == 1){
			#echo "ksini ga";exit();
			if($arrayjeniskomponenpembayaran[$idkomponen] == 3 && $idkomponen != 99 && $idkomponen != 98 ){
		
				$angkatan = $d[ANGKATAN];
				if ( $tahunawal < 1901 )
				{
					$tahunawal = $d[ANGKATAN] + 1;
				}
				if ( $semester == 2 )
				{
					$semesterlalu = 1;
					$tahunlalu = $tahun;
				}
				else
				{
					$semesterlalu = 2;
					$tahunlalu = $tahun - 1;
				}
				$stop = 0;
				while ( !$stop )
				{
					$q = "SELECT * FROM trlsm WHERE THSMSTRLSM='".( $tahunlalu - 1 )."{$semesterlalu}' AND NIMHSTRLSM='{$idmahasiswa}' AND STMHSTRLSM='C'";
					$hx = doquery( $q, $koneksi );
					echo mysqli_error($koneksi);
					if ( 0 < sqlnumrows( $hx ) )
					{
						if ( $semesterlalu == 2 )
						{
							$semesterlalu = 1;
							$tahunlalu = $tahunlalu;
						}
						else
						{
							$semesterlalu = 2;
							$tahunlalu = $tahunlalu - 1;
						}
					}
					else
					{
						$stop = 1;
					}
				}
				if ( $tahunawal == $tahun && $semester <= $semesterawal )
				{
				}
				else if ( $tahunawal <= $tahunlalu )
				{
					$q = "SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran\r\n                   WHERE\r\n                   biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n                   biayakomponen.IDKOMPONEN='{$idkomponen}' AND \r\n                   biayakomponen.ANGKATAN='{$angkatan}' AND\r\n                   biayakomponen.IDPRODI='{$idprodi}'  AND\r\n                   biayakomponen.GELOMBANG='{$gelombang}'  \r\n                   {$qfieldjeniskelas}\r\n                   \r\n                   ";
					#echo "qqqq".$q.'<br>';
					$h2 = doquery( $q, $koneksi );
					if ( 0 < sqlnumrows( $h ) )
					{
						$d2 = sqlfetcharray( $h2 );
						$databiayakomponen = $d2;
						$biaya = $d2[BIAYA];
					}
					$diskonbeasiswa = 0;
					$q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n                    TAHUN='{$tahunlalu}' AND SEMESTER='{$semesterlalu}'";
					#echo "kkk".$q.'<br>';
					$hdiskon = doquery( $q, $koneksi );
					if ( 0 < sqlnumrows( $hdiskon ) )
					{
						$ddiskon = sqlfetcharray( $hdiskon );
						$diskonbeasiswa = $ddiskon[DISKON];
					}
					$harusdibayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
					$q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n              TAHUNAJARAN='{$tahunlalu}' AND SEMESTER='{$semesterlalu}' AND JENIS='3' AND\r\n              IDKOMPONEN='{$idkomponen}'";
					#echo "ccc".$q.'<br>';
					$hx = doquery( $q, $koneksi );
					$dx = sqlfetcharray( $hx );
					$sudahdibayar = $dx[TOTAL];
					#echo $sudahdibayar.'aaaa'.$harusdibayar;
					if ( $sudahdibayar < $harusdibayar )
					{
						$aksi2 = "";
						$errmesg = "Maaf. Mahasiswa ybs belum melunasi pembayaran komponen ini (".$arraykomponenpembayaran[$idkomponen].") untuk semester lalu (".$arraysemester[$semesterlalu]." ".( $tahunlalu - 1 )."/{$tahunlalu}) ";
					}
				}
				
			}
        }
		echo "kalau kadieu".$aksi2;
        printmesg( $errmesg );
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        echo "\r\n    \t\t<form name=form action=index.php method=post>\r\n    \t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n    \t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n    \t\t\t<input type=hidden name=aksi value='{$aksi}'>\r\n     \t\t<table class=form>\r\n      \t\t<tr >\r\n    \t\t\t<td class=judulform width=150 >NIM</td>\r\n    \t\t\t<td>{$idmahasiswa} </td>\r\n    \t\t</tr> \r\n      \t\t<tr >\r\n    \t\t\t<td class=judulform>NAMA</td>\r\n    \t\t\t<td>{$d['NAMA']}</td>\r\n    \t\t</tr>      \r\n      \t\t<tr >\r\n    \t\t\t<td class=judulform>Angkatan</td>\r\n    \t\t\t<td>{$d['ANGKATAN']}</td>\r\n    \t\t</tr>       \r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Prodi</td>\r\n    \t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n    \t\t</tr>  {$fieldjeniskelas}   ";
        if ( $aksi2 == "Data Baru" )
        {
            $aksi2 = "";
        }
        if ( $aksi2 == "" )
        {
			#echo "apa";exit();
            $q = "SELECT komponenpembayaran.* FROM komponenpembayaran,biayakomponen\r\n        WHERE\r\n        komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND\r\n        biayakomponen.IDPRODI='{$idprodi}' AND\r\n        biayakomponen.GELOMBANG='{$gelombang}' AND\r\n        biayakomponen.ANGKATAN='{$angkatan}' AND\r\n        biayakomponen.BIAYA > 0 {$qfieldjeniskelas}\r\n        ORDER BY komponenpembayaran.JENIS,komponenpembayaran.ID\r\n        ";
            #echo $q.'<br>';exit();
 		    $hb = doquery( $q, $koneksi );
            if ( 0 < sqlnumrows( $hb ) )
            {
                while ( $db = sqlfetcharray( $hb ) )
                {
                    $arraykomponenpembayaran_baru[$db[ID]] = "{$db['NAMA']} - ".$arrayjenispembayaran[$db[JENIS]];
                }
            }
			#echo "kkk";exit();
            #$arraykomponenpembayaran_baru[''] = "Biaya komponen pembayaran belum diisi!!";
			#print_r ($arraykomponenpembayaran_baru).'<br>'; 
            #echo "  \t\t\t\t\t\t\r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Tanggal Bayar</td>\r\n    \t\t\t<td>".createinputtanggal( "tgl", "", "" )."</td>\r\n    \t\t</tr> \r\n    \t\t           \r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Komponen </td>\r\n    \t\t\t<td> \r\n          <script>\r\n            var  arrayjeniskomponen = new Array;\r\n            ";
            #echo
			echo "  						
      	<tr >
    			<td class=judulform>Tanggal Bayar</td>
    			<td>".createinputtanggal("tgl","","")."</td>
    		</tr> 
    		           
      	<tr >
    			<td class=judulform>Komponen</td>
    			<td> 
          <script>
            var  arrayjeniskomponen = new Array;
            ";
			foreach ( $arraykomponenpembayaran_baru as $k => $v )
            {
                echo "\r\n                arrayjeniskomponen['$k']=".$arrayjeniskomponenpembayaran[$k].";\r\n              ";
            }
            echo "\r\n          </script>\r\n          \r\n           <select name=idkomponen  onChange='gantilabel(this.value);'> \r\n             <option value='' >Pilih Komponen Pembayaran</option>\r\n           ";
            foreach ( $arraykomponenpembayaran_baru as $k => $v )
            {
                echo "<option value='$k'>$v</option>";
            }
            echo "\r\n              </select>  \r\n              <input type=checkbox name=pilihisi value=1 > Isi otomatis\r\n        </td></tr>\r\n        <tr id=pertahun style='display:none;'>\r\n          <td>Tahun Ajaran</td>\r\n           <td>\r\n            \r\n\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t ";
            #echo "\r\n              </select><tr id=pertahun style='display:none;'>\r\n          <td>Tahun Ajaran</td>\r\n           <td>\r\n            \r\n\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t ";
            
			$arrayangkatan = getarrayangkatan( "R" );
            foreach ( $arrayangkatan as $k => $v )
            {
                $selected = "";
                if ( $k == $waktu[year] )
                {
                    $selected = "selected";
                }
                 echo "
							<option value='".($k)."' $selected >".($v-1)."/$v</option>
							";
            }
            $k++;
            echo "
							<option value='".($k)."' $selected >".($k-1)."/$k</option>
							";
            echo "\r\n\t\t\t\t\t\t</select> \r\n\r\n            \r\n            </td>\r\n        </tr>\r\n       <tr id=persemester style='display:none;'>\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td> ".createinputtahunajaransemester( $semua = 0, $tahun = "tahun", $semester = "semester", $addnumber = 0, $plus1 = 0, $tambah1 = 1 )."  \r\n             </td>\r\n        </tr>\r\n       <tr id=cuti style='display:none;'>\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".createinputtahunajaransemestercuti( $semua = 0, "semestercuti", $idmahasiswa )."  \r\n             </td>\r\n        </tr>\r\n       <tr id=perbulan style='display:none;'>\r\n          <td>Bulan-Tahun</td>\r\n           <td>\r\n\r\n            <select name=bulan class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t  ";
            foreach ( $arraybulan as $k => $v )
            {
                $cek = "";
                if ( $k + 1 == $w[mon] )
                {
                    $cek = "selected";
                }
               echo "
											<option value='".($k+1)."' $cek>$v</option>
											";
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t<select name=tahunbulan class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
            $ii = 1990;
            #do
            #{
			for ($ii=1990;$ii<=$waktu[year]+5;$ii++) {
                $cek = "";
                if ( $ii == $d2[TAHUNAJARAN] )
                {
                    $cek = "selected";
                }
                else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
                {
                    $cek = "selected";
                }
                echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}> {$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                $ii++;
			}
            #} while ( 1 );
            echo "\r\n\t\t\t\t\t\t\t\t\t</select>\r\n        \r\n            \r\n            \r\n          </td>\r\n    \t\t</tr>           \r\n        <tr>\r\n    \t\t\t\t<td colspan=2>\r\n    \t\t\t\t\t<input id=aksi2 type=submit name=aksi2 value='Lanjut' class=masukan  style='display:none;'>\r\n    \t\t\t\t</td>\r\n    \t\t</tr>";
        }
        if ( $aksi2 == "Lanjut" )
        {
			#echo "mmm";exit();
            echo "  \t\t\t\t\t\t\r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Tanggal Bayar</td>\r\n    \t\t\t<td>{$tgl['tgl']}-{$tgl['bln']}-{$tgl['thn']} \r\n            <input type=hidden name='tgl[tgl]' value='{$tgl['tgl']}'>\r\n            <input type=hidden name='tgl[bln]' value='{$tgl['bln']}'>\r\n            <input type=hidden name='tgl[thn]' value='{$tgl['thn']}'>\r\n          </td>\r\n    \t\t</tr> \r\n    \t\t           \r\n      \t<tr >\r\n    \t\t\t<td class=judulform>Komponen</td>\r\n    \t\t\t<td> ".$arraykomponenpembayaran[$idkomponen]."  \r\n    \t\t\t<input type=hidden name=idkomponen value='{$idkomponen}'>\r\n          \r\n         </td></tr>";
            $biaya = $totalbayar = $totaldiskon = $ketdiskon = $diskon = $dibayar = $ketsks = $denda = "";
            $q = "SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran\r\n             WHERE\r\n             biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n             biayakomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             biayakomponen.ANGKATAN='{$angkatan}' AND\r\n             biayakomponen.IDPRODI='{$idprodi}'  AND\r\n                   biayakomponen.GELOMBANG='{$gelombang}'\r\n                   {$qfieldjeniskelas}\r\n             \r\n             ";
            $h2 = doquery( $q, $koneksi );
            if ( 0 < sqlnumrows( $h2 ) )
            {
                $d2 = sqlfetcharray( $h2 );
                $databiayakomponen = $d2;
                $biaya = $d2[BIAYA];
            }
			#echo $arrayjeniskomponenpembayaran[$idkomponen];exit();
            if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 || $arrayjeniskomponenpembayaran[$idkomponen] == 4 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' ";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}' \r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
            }
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunajaran}' ";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunajaran}'\r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                echo "\r\n            <tr id=pertahun  >\r\n              <td>Tahun Ajaran</td>\r\n               <td>".( $tahunajaran - 1 )."/{$tahunajaran}\r\n               <input type=hidden name=tahunajaran value='{$tahunajaran}'>\r\n                \r\n                 </td>\r\n            </tr>\r\n            \r\n            ";
            }
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
            {
				#echo "kkk";
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahun}' AND SEMESTER='{$semester}'";
                #echo $q;
  			    $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahun}' AND\r\n             bayarkomponen.SEMESTER='{$semester}'\r\n             \r\n             ";
                #echo $q;
				$h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
				#echo "kkk".$BIAYASKSKULIAH;
                if ( $idkomponen == "99" )
                {
                    $jumlahsks = getjumlahsks( $idmahasiswa, $tahun, $semester );
                    $jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahun, $semester );
                    $skslebih = 0;
                    if ( $jumlahskswajib < $jumlahsks )
                    {
                        $skslebih = $jumlahsks - $jumlahskswajib;
                    }
                    if ( $BIAYASKSKULIAH == 1 )
                    {
                        $biaya = $jumlahsks * $biaya;
                        $ketsks = "\r\n                       Total SKS: <b> {$jumlahsks} SKS </b>\r\n                     ";
                    }
                    else
                    {
                        $biaya = $skslebih * $biaya;
                        $ketsks = "\r\n                      SKS Lebih : <b> {$skslebih} SKS </b>\r\n                     ";
                    }
                }
                if ( $idkomponen == 98 )
                {
                    $jumlahsks = getjumlahskssp( $idmahasiswa, $tahun, $semester );
                    $skslebih = $jumlahsks;
                    $biaya = $skslebih * $biaya;
                }
				#echo $tgl[tgl].'OH'.$UNIVERSITAS.'VV'.$KODESPP.'ZZZZ'.$idkomponen.'QQQQ'.$TANGGALDENDA;
                if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $KODESPP == $idkomponen && $TANGGALDENDA < $tgl[tgl] )
                {
                    $denda = $JUMLAHDENDA;
                }
                echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $tahun - 1 )."/{$tahun} / ".$arraysemester[$semester]."\r\n           <input type=hidden name=tahun value='{$tahun}'>\r\n           <input type=hidden name=semester value='{$semester}'>\r\n            \r\n             </td>\r\n        </tr>";
           }
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
            {
                $tahunc = substr( $semestercuti, 0, 4 ) + 1;
                $semesterc = substr( $semestercuti, 4, 1 );
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunc}' AND SEMESTER='{$semesterc}'";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunc}' AND\r\n             bayarkomponen.SEMESTER='{$semesterc}'\r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $tahunc - 1 )."/{$tahunc} / ".$arraysemester[$semesterc]."\r\n           <input type=hidden name=tahunc value='{$tahunc}'>\r\n           <input type=hidden name=semesterc value='{$semesterc}'>\r\n            \r\n             </td>\r\n        </tr>";
            }
            else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND\r\n              TAHUN='{$tahunbulan}' AND SEMESTER='{$bulan}'";
                $hdiskon = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    #$diskonbeasiswa = $ddiskon[DISKON];
                    #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					if($ddiskon[DISKON]>100){
	
						$diskon_rp=$ddiskon[DISKON];
						#$diskon=0;
						$diskonbeasiswa=$diskon_rp;
						$ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
					}else{
					
						$diskon=$ddiskon[DISKON];
						$diskon_rp=0;
						$diskonbeasiswa=$diskon;
						$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
					}
                }
                $q = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$idmahasiswa}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$tahunbulan}' AND\r\n             bayarkomponen.SEMESTER='{$bulan}'\r\n             \r\n             ";
                $h2 = doquery( $q, $koneksi );
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $totalbayar = $d2[TOTALBAYAR];
                    $totaldiskon = $d2[TOTALDISKON];
                }
                $totaldenda = 0;
                $kettambahan = "";
                $q = "SELECT TO_DAYS('{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}')-TO_DAYS('{$tahunbulan}-{$bulan}-{$databiayakomponen['TANGGAL']}') AS HARI ";
                #echo $q;
				$hx = doquery( $q, $koneksi );
                $dx = sqlfetcharray( $hx );
                $jumlahhari = $dx[HARI] + 0;
                if ( 0 < $jumlahhari )
                {
                    if ( $databiayakomponen[JENISDENDA] == 0 )
                    {
                        $denda = $databiayakomponen[DENDA];
                    }
                    else
                    {
                        $denda = $databiayakomponen[DENDA] * $jumlahhari;
                    }
                    $kettambahan = "Denda terlambat {$jumlahhari} hari Rp. ".cetakuang( $denda );
                }
                echo "\r\n        <tr id=perbulan  >\r\n          <td>Bulan-Tahun</td>\r\n           <td> ".$arraybulan[$bulan - 1]." {$tahunbulan}\r\n           <input type=hidden name=bulan value='{$bulan}'>\r\n           <input type=hidden name=tahunbulan value='{$tahunbulan}'>\r\n            \r\n             </td>\r\n        </tr>";
            }
            #$biayatampil = ( 100 - $diskonbeasiswa ) / 100 * $biaya;
			if($diskonbeasiswa>100){
				$biayatampil = $biaya-$diskonbeasiswa;
			
				#$diskon_rp=$ddiskon[DISKON];
				#$diskon=0;
				#$diskonbeasiswa=$diskon_rp;
				#$ketdiskon = "Sudah Diskon {$diskonbeasiswa}.";
			}else{
				$biayatampil = ( 100 - $diskonbeasiswa ) / 100 * $biaya;
			
				#$diskon=$ddiskon[DISKON];
				#$diskon_rp=0;
				#$diskonbeasiswa=$diskon;
				#$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
			}
			#echo $biayatampil."ll".$totalbayar.$totaldiskon;
            $sisa = $biayatampil - ( $totalbayar + $totaldiskon );
            $dibayar = $sisa - $diskon;
            if ( $idkomponen == 98 )
            {
                echo "\r\n                <tr id=persemester  >\r\n                  <td>Total SKS</td>\r\n                   <td>{$skslebih} SKS\r\n                      </td>\r\n                </tr>";
            }
            echo "\r\n\r\n\r\n\r\n\r\n            <tr   >\r\n              <td>Biaya Rp. </td>\r\n               <td> <b>".cetakuang( $biayatampil )."  . </b> {$ketdiskon}\r\n               Total Bayar : <b> Rp. ".cetakuang( $totalbayar )." </b>\r\n               <!-- Total Beasiswa : <b> Rp. ".cetakuang( $totaldiskon )." </b> -->\r\n               Total Tunggakan : <b> Rp. ".cetakuang( $sisa )." </b>  \r\n              {$ketsks} </td>\r\n            </tr>\r\n            <input type=hidden name=sessid value='{$token}'>\r\n            <input type=hidden name=sisa value='{$sisa}'>\r\n            <input type=hidden name=biaya value='{$biaya}'>\r\n            <input type=hidden name=beasiswa value='{$diskonbeasiswa}'>\r\n            <input type=hidden name=biayatampil value='{$biaya}'>\r\n             \r\n            ";
            if ( $pilihisi != 1 )
            {
                $dibayar = "";
                $diskon = "";
            }
            $diskon = "";
            if ( 0 < $diskonbeasiswa )
            {
                echo "\r\n              <!-- \r\n                <script>\r\n                  var diskonbeasiswa={$diskonbeasiswa};\r\n                  function gantidiskon(biaya) {\r\n                       var bayar=  document.getElementById('biaya');\r\n                       var diskon= document.getElementById('diskon');\r\n                      \r\n                      diskon.value=biaya*diskonbeasiswa/100;\r\n                      bayar.value=biaya-diskon.value;\r\n                  }\r\n                \r\n                </script>\r\n                -->\r\n              ";
            }
            echo " \r\n\r\n\r\n         <tr>\r\n          <td> Jumlah Bayar </td>\r\n          <td> <input type=text id=biaya name=bayar value='{$dibayar}' size=20 {$fungsi} >   </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Jumlah Diskon </td>\r\n          <td> <input type=text id=diskon name=diskon value='".$diskon."' size=20> <!-- {$ketdiskon} --> </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Jumlah Denda </td>\r\n          <td> <input type=text name=denda value='{$denda}' size=20> {$kettambahan} </td>\r\n        </tr>\r\n        <tr>\r\n          <td> Keterangan </td>\r\n          <td> <input type=text name=ket value='' size=50> </td>\r\n        </tr>                      \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Cara Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=carabayar>";
            foreach ( $arraycarabayar as $k => $v )
            {
                $cek = "";
                if ( $k == 1 )
                {
                    $cek = "selected";
                }
                echo "<option value='{$k}' {$cek}>{$v}</option>";
            }
            echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n                \r\n        <tr>\r\n    \t\t\t\t<td  >\r\n    \t\t\t\t\t<input id=aksi2 type=submit name=aksi2 value='Simpan' class=masukan  >\r\n    \t\t\t\t\t\r\n    \t\t\t\t\t\r\n    \t\t\t\t</td>\r\n    \t\t\t\t<td  align=right>\r\n    \t\t\t\t\t<input id=aksi2 type=submit name=aksi2 value='Data Baru' class=masukan  >\r\n    \t\t\t\t\t\r\n    \t\t\t\t\t\r\n    \t\t\t\t</td>\r\n    \t\t</tr>";
        }
       # echo "\r\n    \t\t</table>\r\n    \t\t</form>\r\n\r\n\r\n<script>\r\nfunction gantilabel(v) {\r\n   //alert(document.getElementById('pertahun').style.visibility);\r\n  document.getElementById('pertahun').style.display='none';\r\n  document.getElementById('persemester').style.display='none';\r\n  document.getElementById('perbulan').style.display='none';\r\n document.getElementById('cuti').style.display='none';\r\n    document.getElementById('aksi2').style.display='inline';\r\n  if (  v=='') { // Tidak memilih\r\n    document.getElementById('aksi2').style.display='none';\r\n  } else if (  arrayjeniskomponen[v]==0) { // 1 Kali Awal Kuliah\r\n  } else if (  arrayjeniskomponen[v]==1) { // 1 Kali Akhir Kuliah\r\n  } else if (  arrayjeniskomponen[v]==2) { // Per tahun Ajaran\r\n    document.getElementById('pertahun').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==3) { // Per Semesteran\r\n    document.getElementById('persemester').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==4) { // Tidak tetap\r\n  } else if (  arrayjeniskomponen[v]==5) { // Bulanan\r\n    document.getElementById('perbulan').style.display='table-row';\r\n  } else if (  arrayjeniskomponen[v]==6) { // Cuti\r\n    document.getElementById('cuti').style.display='table-row';\r\n  }\r\n \r\n}\r\n</script>\t    \t\t\r\n    \t\t\r\n    \t";
         echo "
    		</table>
    		</form>


<script>
function gantilabel(v) {
   //alert(document.getElementById('pertahun').style.visibility);
  document.getElementById('pertahun').style.display='none';
  document.getElementById('persemester').style.display='none';
  document.getElementById('perbulan').style.display='none';
 document.getElementById('cuti').style.display='none';
    document.getElementById('aksi2').style.display='inline';
  if (  v=='') { // Tidak memilih
    document.getElementById('aksi2').style.display='none';
  } else if (  arrayjeniskomponen[v]==0) { // 1 Kali Awal Kuliah
  } else if (  arrayjeniskomponen[v]==1) { // 1 Kali Akhir Kuliah
  } else if (  arrayjeniskomponen[v]==2) { // Per tahun Ajaran
    document.getElementById('pertahun').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==3) { // Per Semesteran
    document.getElementById('persemester').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==4) { // Tidak tetap
  } else if (  arrayjeniskomponen[v]==5) { // Bulanan
    document.getElementById('perbulan').style.display='table-row';
  } else if (  arrayjeniskomponen[v]==6) { // Cuti
    document.getElementById('cuti').style.display='table-row';
  }
 
}
</script>	    		
    		
    	";  

		$tgltrans[tgl] = $w[mday];
        $tgltrans[bln] = $w[mon];
        $tgltrans[thn] = $w[year];
        $q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,\r\n\t\t\t DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND\r\n        \r\n      IDMAHASISWA='{$idmahasiswa}'  {$qfieldjeniskelasm}\r\n      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
        echo $q;
		$h = doquery( $q, $koneksi );
        echo mysqli_error($koneksi);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n\t\t\t\t<form name=form action=cetakkuitansibaru.php method=post target=_blank>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n <input class=masukan type=submit name=aksi value='Cetak Kuitansi'>        \r\n      \r\n\r\n\t\t\t   <br>\r\n\t\t\t   <b>Rincian Transaksi Keuangan Mahasiswa <!-- - Tanggal Entri {$tgltrans['tgl']}-{$tgltrans['bln']}-{$tgltrans['thn']} --></b>\r\n          <table class=form width=95%>\r\n            <tr class=juduldata align=center>\r\n              <td>Nama</td>\r\n              <td>Jenis</td>\r\n               <td>Waktu</td>\r\n               <td>Tanggal Bayar</td>\r\n              <td>Biaya</td>\r\n              <td>Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Sisa</td>\r\n              <td>Denda</td>\r\n              <td>Ket</td>\r\n              <td>Pilih Cetak</td>\r\n              <td>Hapus</td>\r\n            </tr>";
            $idkomponenlama = $tahunlama = $semlama = 0 - 1;
            $sisa = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $waktu = "-";
                if ( $d[BIAYA] == 0 )
                {
                    $d[BIAYA] = $d[BIAYA2];
                }
				if($d[BEASISWA]>100){
	
						$biaya = $d[BIAYA] - $d[BEASISWA] ;
					}else{
					
						$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
					}
                #$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
                if ( $d[JENIS] == 2 )
                {
                    $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 3 || $d[JENIS] == 6 )
                {
                    $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 5 )
                {
                    $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                }
				
				
				if (
                
                  ($d[JENIS]==0 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==1 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==2 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN]  ) ) ||
                  ($d[JENIS]==3 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) )  || 
                  ($d[JENIS]==4 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==5 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) ||
                  ($d[JENIS]==6 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) 
                    
                
                
                ) {
                  //$sisa=$d[BIAYA];
                  $sisa=$biaya;
                    $idkomponenlama=$d[IDKOMPONEN];
                  $tahunlama=$d[TAHUNAJARAN];
                  $semlama=$d[SEMESTER];
                  //$tr="class=juduldata";
                  
                  echo "
                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>
                  ";
                  
               }


              #$sisa-=($d[JUMLAH]+$d[DISKON]);
			  $sisa-=($d[JUMLAH]+$diskon);
			  
              
              if ($sisa<0) {
                $sisa=0;
              }
              
              $trtgl="";
              $cek="";
              if ($d[STATUSTANGGAL]==1) {
                $trtgl="style='background-color:#ffff00;'";
                $cek="checked";
              }
              
              echo "
            <tr valign=top $tr $trtgl>
              <td nowrap> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>
              <td nowrap> ".$arrayjenispembayaran[$d[JENIS]]." </td>
               <td align=center nowrap>$waktu </td>
               <td align=center nowrap>$d[TGLBAYAR]</td>
              <td align=right>".cetakuang($biaya)." </td>
              <td align=right>".cetakuang($d[JUMLAH])."</td>
              <td align=right>".cetakuang($d[DISKON])."</td>
              <td align=right> ".cetakuang($sisa)."</td>
              <td align=right>".cetakuang($d[DENDA])."</td>
              <td align=left>$d[KET]</td>
              <td align=center><input type=checkbox name='pilihcetak[$d[ID]]' value=1 $cek ></td>
              <td align=center>";
              if (getaturan("KEUANGAN")==0 ||  (getaturan("KEUANGAN")==1 &&  issupervisor($users)) ) {
                echo "<a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan=$pilihan&idhapus=$d[ID]&aksi=$aksi&aksi2=hapus&idmahasiswa=$idmahasiswa&sessid=$token&$href'>hapus</a>";
              } else {
                echo "-";
              }
              echo "</td>
            </tr>";


             }
            echo "
          </table>
          
            </form>
         ";
                /*if ( $d[JENIS] == 2 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] ) || $d[JENIS] == 3 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) || $d[JENIS] == 4 && $idkomponenlama != $d[IDKOMPONEN] || $d[JENIS] == 5 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) || $d[JENIS] == 6 && ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] ) )
                {
                    $sisa = $biaya;
                    $idkomponenlama = $d[IDKOMPONEN];
                    $tahunlama = $d[TAHUNAJARAN];
                    $semlama = $d[SEMESTER];
                    echo "\r\n                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>\r\n                  ";
                }
                $sisa -= $d[JUMLAH] + $d[DISKON];
                if ( $sisa < 0 )
                {
                    $sisa = 0;
                }
                $trtgl = "";
                $cek = "";
                if ( $d[STATUSTANGGAL] == 1 )
                {
                    $trtgl = "style='background-color:#ffff00;'";
                    $cek = "checked";
                }
                echo "\r\n            <tr valign=top {$tr} {$trtgl}>\r\n              <td nowrap> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n              <td nowrap> ".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n               <td align=center nowrap>{$waktu} </td>\r\n               <td align=center nowrap>{$d['TGLBAYAR']}</td>\r\n              <td align=right>".cetakuang( $biaya )." </td>\r\n              <td align=right>".cetakuang( $d[JUMLAH] )."</td>\r\n              <td align=right>".cetakuang( $d[DISKON] )."</td>\r\n              <td align=right> ".cetakuang( $sisa )."</td>\r\n              <td align=right>".cetakuang( $d[DENDA] )."</td>\r\n              <td align=left>{$d['KET']}</td>\r\n              <td align=center><input type=checkbox name='pilihcetak[{$d['ID']}]' value=1 {$cek} ></td>\r\n              <td align=center>";
                if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
                {
                    echo "<a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan={$pilihan}&idhapus={$d['ID']}&aksi={$aksi}&aksi2=hapus&idmahasiswa={$idmahasiswa}&sessid={$token}&{$href}'>hapus</a>";
                }
                else
                {
                    echo "-";
                }
                echo "</td>\r\n            </tr>";
            }
            echo "\r\n          </table>\r\n          \r\n            </form>\r\n         ";*/
        }
    }
}
if ( $aksi == "" )
{
	#echo "lll";
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20      id='inputString' onkeyup=\"lookup(this.value,'','');\" \r\n\t" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \r\n\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
