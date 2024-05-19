<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
periksaroot( );
$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
$gelombang = getfield( "GELOMBANG", "mahasiswa", " WHERE ID='{$idupdate}'" );
$angkatan = getfield( "ANGKATAN", "mahasiswa", " WHERE ID='{$idupdate}'" );

#echo "AKSI3=".$aksi3;
/*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div></div></div></div>\r\n";
*/
/*echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php?aksi=formupdate&pilihan=mlihat&tab=12&aksi2=formtambah&idupdate={$idupdate}\" method=\"post\">
					<div class=\"m-portlet__body\">	";*/
		echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
					<div class=\"m-portlet__body\">	";			
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						
						</div>
					</div>
				</form>";
if ( $aksi2 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Reschedule Tagihan Mahasiswa", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
		
		//cek sudah ada transaksi atau belum
		$sql_transaksi="SELECT COUNT(IDKOMPONEN) AS record_trx FROM bayarkomponen WHERE IDMAHASISWA='$idupdate' AND IDKOMPONEN='$idkomponen'";
		#echo $sql_transaksi.'<br>';
		$query_transaksi=mysqli_query($koneksi,$sql_transaksi);
		$data_transaksi=sqlfetcharray($query_transaksi);
		if($data_transaksi['record_trx']>0){
		
			$errmesg = "Sudah ada pembayaran terhadap Komponen ".$arraykomponenpembayaran_tagihan[$idkomponen].", Silahkan Hapus Transaksi Pembayaran Terlebih Dahulu";
			#echo $errmesg;
			#exit();
		}else{
			$sql_child="SELECT COUNT(IDKOMPONEN) AS record_tagihan FROM trakk_tagihan WHERE IDMAHASISWA='$idupdate' AND IDKOMPONEN='$idkomponen'";
			#echo $sql_child.'<br>';
			$query_child=mysqli_query($koneksi,$sql_child);
			$data_child=sqlfetcharray($query_child);
			if($data_child['record_tagihan']>0){
		
				$errmesg = "Detail Cicilan Pada Komponen ".$arraykomponenpembayaran_tagihan[$idkomponen]." belum dihapus, silahkan hapus terlebih dahulu";
				#echo $errmesg;
				#exit();
			}else{
				#exit();
				$q = "DELETE FROM trakk WHERE NIMHSTRAKK='$idupdate' AND IDKOMPONEN='$idkomponen' ";
				#echo $q;
				#mysql_query($q,$koneksi);
				doquery($koneksi,$q);
				if ( 0 < sqlaffectedrows( $koneksi ) )
				{
					$errmesg = "Data Reschedule Tagihan Mahasiswa berhasil dihapus";
				}
				else
				{
					$errmesg = "Data Reschedule Tagihan tidak dihapus";
				}
			}
		}
        $aksi2 = "";
    }
}
if ( $aksi2 == "Tambah" )
{
	/*print_r($_POST);
	echo '<br>';
	print_r($_SESSION);
	echo '<br>';exit();*/
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Reschedule Tagihan Mahasiswa", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Data", $tahun2, $semester2 );
        $vld[] = cekvaliditastanggal( "Tanggal Awal", $tglawal['tgl_awal'], $tglawal['bln_awal'], $tglawal['thn_awal'] );
		$vld[] = cekvaliditastanggal( "Tanggal Akhir", $tglakhir['tgl_akhir'], $tglakhir['bln_akhir'], $tglakhir['thn_akhir'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        }
        else
        {
            $tanggalawal = "'{$tglawal['thn']}-{$tglawal['bln']}-{$tglawal['tgl']}'";
            $tanggalakhir = "'{$tglakhir['thn']}-{$tglakhir['bln']}-{$tglakhir['tgl']}'";
            $q = "INSERT INTO trakk (IDKOMPONEN,THSMSTRAKK,NIMHSTRAKK,TGLAWLTRAKK,TGLAKHTRAKK,JMLTRAKK,CCLTRAKK,KRS,UTS,UAS,TGLBTSTRAKK,DENDA) VALUES ('{$idkomponen}','{$tahun2}{$semester2}','{$idupdate}',{$tanggalawal},{$tanggalakhir},'{$totaltagihan}','{$cicilan}','{$minimalkrs}','{$minimaluts}','{$minimaluas}','{$tglbatas}','{$denda}')";
            #echo $q;exit();
			$ketlog = "Tambah Reschedule Tagihan dengan ID Komponen={$idkomponen}, Tahun Akademik=".($tahunhapus2).",Semester=".$arraysemester[$semester2].",ID Mahasiswa={$idupdate} ";
            buatlog(30);
			doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Reschedule Tagihan Mahasiswa berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Reschedule Tagihan Mahasiswa tidak disimpan {$errmesgblanko}";
            }
        }
    }
    $aksi2 = "formtambah";
}
#echo "USER=".$_SESSION['users'];
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">";
							if ($_SESSION['users']=='egi' || $_SESSION['users']=='fariz02' || $_SESSION['users']=='admin' || $_SESSION['users']=='Mercy01'){
								echo "	<tr>
											<td width=50% align=center>
												<a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> ".IKONTAMBAH." Tambah Data Baru 
											</td>
											<td width=50% align=center>
												<a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> ".IKONUPDATE." Edit Data Lama
											</td>
										</tr>";
							}
echo "						</table>
						</div>
					</div>\r\n";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    */
	echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php?aksi=formupdate&pilihan=mlihat&tab=12&aksi2=formtambah&idupdate={$idupdate}\" method=\"post\">";
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi2", "{$aksi2}", "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "aksi3", "{$aksi3}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
	include( "formresechedule.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n </div></div> ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
									<input type=reset value='Reset' class=\"btn btn-secondary\">
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "formtambah" )
{
	#echo "lll";
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    */
	echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php?aksi=formupdate&pilihan=mlihat&tab=12&aksi2=formtambah&idupdate={$idupdate}\" method=\"post\">";
	#echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">";
		echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi2", "{$aksi2}", "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "angkatan", "{$angkatan}", "" ).createinputhidden( "gelombang", "{$gelombang}", "" ).createinputhidden( "idprodi", "{$idprodi}", "" )."";
	
	include( "formreschedule.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn red \">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div></div></div> </form>\r\n  ";
	echo "					
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
#if ( $aksi2 == "" || $aksi2 == "tampilkan" )
	if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trakk WHERE NIMHSTRAKK='{$idupdate}' ORDER BY THSMSTRAKK DESC";
	#echo $q;
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar/Lulus</td>\r\n          <td>Total SK Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td>\r\n          <td>Tanggal S.K. Yudisium</td>\r\n          <td>Nomor Seri Ijazah</td>\r\n          <td>Jalur</td>\r\n          <td>Skripsi Individu atau Kelompok</td>\r\n          <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        /*  echo "\r\n    <br>\r\n    <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar / Lulus</td>\r\n          <td>Total SKS Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td><td>Tanggal S.K. Yudisium</td><td>Nomor Seri Ijazah</td><td>Jalur</td><td>Skripsi Individu / Kelompok</td>  <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n          <td colspan=2>Aksi</td>\r\n        </tr>";
      
		*/
		
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata{$cetak} align=center><td>No.</td>\r\n          <td>Tahun / Semester Mulai</td>\r\n          <td>Nama Komponen</td><td>Tanggal Awal</td><td>Tanggal Akhir</td><td>Total Tagihan</td><td>Denda</td><td>Tanggal Batas Pembayaran</td><td colspan='2'></td></tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
			$tmp1 = explode( "-", $d[TGLAWLTRAKK] );
            $tglawal[thn] = $tmp1[0];
            $tglawal[tgl] = $tmp1[2];
            $tglawal[bln] = $tmp1[1];
            $tmp2 = explode( "-", $d[TGLAKHTRAKK] );
            $tglakhir[thn] = $tmp2[0];
            $tglakhir[tgl] = $tmp2[2];
            $tglakhir[bln] = $tmp2[1];
            $tmp = $d[THSMSTRAKK];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            
			echo "<tr valign=top align=center {$kelas}{$cetak}>
					<td>{$i}</td>
					<td nowrap>".$tahun." / ".($tahun+1)." ".$arraysemester[$semester]." </td>
					<td>".$arraykomponenpembayaran2[$d['IDKOMPONEN']]."</td>
					<td nowrap>{$d['TGLAWLTRAKK']}</td>
					<td>{$d['TGLAKHTRAKK']}</td>
					<td>".cetakuang($d['JMLTRAKK'])."</td>
					<td>".$d['DENDA']."</td><td>".$d['TGLBTSTRAKK']."</td>
					<td>";
					if ($_SESSION['users']=='egi' || $_SESSION['users']=='fariz02' || $_SESSION['users']=='admin' || $_SESSION['users']=='Mercy01'){
			echo "		<a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksi3=settingcicilan&tab={$tab}&idupdate={$idupdate}&idkomponen={$d['IDKOMPONEN']}&sessid={$_SESSION['token']}'>Setting Cicilan</i>";
					}	
			echo "	</td>
					<td>";
					if ($_SESSION['users']=='egi' || $_SESSION['users']=='fariz02' || $_SESSION['users']=='admin' || $_SESSION['users']=='Mercy01'){
			echo "		<a onClick='return confirm(\"Hapus Data Reschedule Tagihan Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&idkomponen={$d['IDKOMPONEN']}&aksi2=hapus&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i>";
					}
			echo "	</td>
				</tr>";
            
				$q = "SELECT  trakk_tagihan.*,DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS TANGGALANGSURAN\r\n            ,DATE_FORMAT(TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1\r\n            ,DATE_FORMAT(TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n             FROM trakk_tagihan WHERE trakk_tagihan.IDMAHASISWA='{$idupdate}' AND trakk_tagihan.IDKOMPONEN='{$d['IDKOMPONEN']}' ORDER BY TAHUN,SEMESTER,TANGGAL";
				#echo $q.'<br>';
				$h3 = doquery( $q, $koneksi );
				echo mysqli_error($koneksi);
				if ( 0 < sqlnumrows( $h3 ) )
				{
					$j = 0;
					$totaltagihan = 0;
					$tahuns = 0;
					$semesters = 0;
					$bulans = 0;
					echo "<tr class=juduldata><td></td>                 <td align='center'>Periode</td>\r\n                    <td align='center'>Angsuran Ke</td>\r\n                    <td colspan='2' align='center'>Jumlah Tagihan</td>\r\n                    <td colspan='2' align='center'>Waktu Penagihan</td>\r\n                    <td colspan='2' align='center'>Periode Pembayaran</td>\r\n                  </tr>\r\n   ";
					while ( $d3 = sqlfetcharray( $h3 ) )
					{
						if($d3[TAHUN].$d3[SEMESTER] != $bulans){
							if ( $bulans != 0 )
							{
								$kettotaltagihan = "";
								if ( $d2[BIAYA] != $totaltagihan_bulan[$bulans] )
								{
									$kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_bulan[$bulans], 0 ).")</b>";
								}
								#echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total  </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
							}
							$bulans = $d3[TAHUN].$d3[SEMESTER];
							$i = 0;
						}
						++$j;
						$totaltagihan += $d3[BIAYA];
						#echo $arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']} ";
						$totaltagihan_bulan[$d3[TAHUN].$d3[SEMESTER]] += $d3[BIAYA];
						echo "<td></td><td align='center'>".$arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']}</td> <td align='center'>{$j}</td> <td colspan='2' align='center'>".cetakuang( $d3[BIAYA], 0 )."</td><td colspan='2' align='center'>{$d3['TANGGALANGSURAN']}</td>\r\n                    <td colspan='2' align='center'>{$d3['TGLBAYAR1']} s.d {$d3['TGLBAYAR2']}</td> </tr>                \r\n                ";
					}
					#echo "</table>";
				}
				++$i;
			
        }
		
        #echo "\r\n      </table>\r\n    ";
		#echo "\r\n      </table>\r\n  </div></div>  ";
		echo "								</tbody>
								</table>
							</div>";
		echo "				<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">";
								
								if($aksi3=='settingcicilan'){
									$errmesgsetting = "";
									if ( $aksi4 == "x" )
									{
										$q = "DELETE FROM  trakk_tagihan WHERE trakk_tagihan.IDMAHASISWA='{$idupdate}' AND trakk_tagihan.IDKOMPONEN='{$idkomponen}' AND   trakk_tagihan.TANGGAL='{$tanggalhapus}' {$qfield} ";
										#echo $q;exit();
										doquery( $q, $koneksi );
										echo mysqli_error($koneksi);
										if ( 0 < sqlaffectedrows( $koneksi ) )
										{
											$errmesgsetting = "Data setting   cicilan tagihan tanggal {$tanggalhapus} berhasil dihapus.";
										}
										else
										{
											$errmesgsetting = "Data setting   cicilan tagihan tanggal {$tanggalhapus}  tidak berhasil dihapus.";
										}
									}
									if ( $aksi4 == "+" )
									{
										#echo "aaaa";exit();
										#print_r($_REQUEST);exit();
										if ($biayaangsuran <= 0)
										{
											$errmesgsetting = "Biaya Angsuran harus diisi lebih dari Nol (0).";
										}
										else
										{
											$q = "REPLACE INTO trakk_tagihan\r\n              (IDKOMPONEN,IDMAHASISWA,ANGKATAN,GELOMBANG,JENISKELAS,TANGGAL,BIAYA,TAHUN,SEMESTER,\r\n              TANGGALBAYAR1,TANGGALBAYAR2) \r\n              VALUES \r\n              ('{$idkomponen}','{$idupdate}','{$angkatan}','{$gelombang}','{$jeniskelas}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','{$biayaangsuran}',\r\n              '{$tahunajaran}' ,'{$semestertagihan}',\r\n              '{$tglbayar1['thn']}-{$tglbayar1['bln']}-{$tglbayar1['tgl']}',\r\n              '{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}')";
											#echo $q;
											doquery( $q, $koneksi );
											if ( 0 < sqlaffectedrows( $koneksi ) )
											{
												$errmesgsetting = "Data setting   cicilan tagihan berhasil disimpan.";
											}
											else
											{
												$errmesgsetting = "Data setting   cicilan tagihan tidak berhasil disimpan.";
											}
										}
									}
										printmesg( $errmesgsetting );
										printmesg("Setting Cicilan Tagihan");
										echo "	<form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
											<input type=hidden name='pilihan' value='{$pilihan}'>
											<input type=hidden name='aksi' value='{$aksi}'>
											<input type=hidden name='aksi2' value='{$aksi2}'>
											<input type=hidden name='aksi3' value='{$aksi3}'>
											<input type=hidden name='idprodi' value='{$idprodi}'>
											<input type=hidden name='tab' value='{$tab}'>
											<input type=hidden name='idkomponen' value='{$idkomponen}'>
											<input type=hidden name='sessid' value='{$_SESSION['token']}'>
											<input type=hidden name='idupdate' value='{$idupdate}'>";	
										echo "	<tr align=center class=juduldata>\r\n              <td ></td>  <td >No</td>\r\n                <td >Periode</td>\r\n                <td >Biaya Angsuran</td>\r\n                <td >Waktu Penagihan</td>\r\n                <td colspan='3'>Periode Pembayaran</td>\r\n                <td > </td>\r\n              </tr>";
										echo "										<tr align=center><td ></td><td >*</td>\r\n                <td nowrap> ";
										echo "".createinputselect( "semestertagihan", $arraybulan2, $semestertagihan, "", "" )."";
											echo "<select name=tahunajaran class=masukan> \r\n        \t\t\t\t\t\t ";
											$arrayangkatan = getarrayangkatan( "", 0, $angkatan );
											$k = $angkatan;
											while ( $k <= $angkatan + 8 )
											{
												$selected = "";
												if ( $k == $tahunajaran )
												{
													$selected = "selected";
												}
												echo "\r\n        \t\t\t\t\t\t\t<option value='".$k."' {$selected} >".$k."</option>\r\n        \t\t\t\t\t\t\t";
												++$k;
											}
											echo "\r\n        \t\t\t\t\t\t</select> ";	
										echo "\r\n                  </td>\r\n                <td >";
										echo "<input type=text name=biayaangsuran value='{$biayaangsuran}' size=10>";
										echo "</td>\r\n                <td nowrap>".createinputtanggal( "tgl", $tgl, "", "" )."</td>\r\n                <td colspan='3'>\r\n                  ".createinputtanggal( "tglbayar1", $tglbayar1, "", "" )."\r\n                  <br> s.d. <br> \r\n                  ".createinputtanggal( "tglbayar2", $tglbayar2, "", "" )."\r\n                </td>\r\n                 <td><!--<a onClick='return confirm(\"Tambah Data Angsuran?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksi3=settingcicilan&aksi4=tambah&tab={$tab}&idupdate={$idupdate}&idkomponen={$d['IDKOMPONEN']}&sessid={$_SESSION['token']}'>tambah</a>--><input type=submit name=aksi4 value='+' onClick=\"return confirm('Simpan setting tagihan ?')\"></td>\r\n              </tr>\r\n          ";	
										echo "</form>";
										$q = "SELECT  trakk_tagihan.*,DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS TANGGALANGSURAN\r\n            ,DATE_FORMAT(TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1\r\n            ,DATE_FORMAT(TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n             FROM trakk_tagihan WHERE trakk_tagihan.IDMAHASISWA='{$idupdate}' AND trakk_tagihan.IDKOMPONEN='{$idkomponen}' ORDER BY TAHUN,SEMESTER,TANGGAL";
										#echo $q.'<br>';
										$h3 = doquery( $q, $koneksi );
										echo mysqli_error($koneksi);
										if ( 0 < sqlnumrows( $h3 ) )
										{
											$k = 0;
											$totaltagihan = 0;
											$tahuns = 0;
											$semesters = 0;
											$bulans = 0;
											while ( $d3 = sqlfetcharray( $h3 ) )
											{
												if($d3[TAHUN].$d3[SEMESTER] != $bulans){
													if ( $bulans != 0 )
													{
														$kettotaltagihan = "";
														if ( $d2[BIAYA] != $totaltagihan_bulan[$bulans] )
														{
															$kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_bulan[$bulans], 0 ).")</b>";
														}
														#echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total  </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
													}
													$bulans = $d3[TAHUN].$d3[SEMESTER];
													$i = 0;
												}
												echo "BULAN=".$bulans;
												$k++;
												$totaltagihan += $d3[BIAYA];
												#echo $arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']} ";
												$totaltagihan_bulan[$d3[TAHUN].$d3[SEMESTER]] += $d3[BIAYA];
												echo "<td></td><td align='center'>{$k}</td><td align='center'>".$arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']}</td><td align='center'>".cetakuang( $d3[BIAYA], 0 )."</td><td align='center'>{$d3['TANGGALANGSURAN']}</td><td align='center' colspan='3'>{$d3['TGLBAYAR1']} s.d {$d3['TGLBAYAR2']}</td><td align='center'><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksi3=settingcicilan&tab={$tab}&aksi4=x&idupdate={$idupdate}&idkomponen={$idkomponen}&tanggalhapus={$d3['TANGGAL']}' onClick=\"return confirm('Hapus data setting tagihan tanggal {$d3['TANGGALANGSURAN']} ? ')\">x</a></td>\r\n                  </tr>                \r\n                ";
											}
										}
								}
		echo "						</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
		echo "<p>";
        printmesg( "Data Reschedule Tagihan Mahasiswa tidak ada" );
		echo "</p>";
    }
    echo "\r\n   \r\n  ";
}
?>
