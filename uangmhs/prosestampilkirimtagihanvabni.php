<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
periksaroot();
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$vldts[] = cekvaliditasinteger( "Jurusan/Prodi", $idprodi, 10 );
$vldts[] = cekvaliditasinteger( "NIDN", $iddosen, 10 );
$vldts[] = cekvaliditastahun( "Angkatan", $angkatan );
$vldts[] = cekvaliditaskode( "NIM", $id, 16 );
$vldts[] = cekvaliditasnama( "Nama", $nama, 32 );
$vldts[] = cekvaliditaskode( "Status", $status, 1 );
$vldts[] = cekvaliditasthnajaran( "Semester Awal", $tahuna, $semestera );
$vldts = array_filter( $vldts, "filter_not_empty" );
if ( isset( $vldts ) && 0 < count( $vldts ) )
{
    $errmesg = "Data pencarian berikut tidak valid, silahkan cek kembali".inv_message( $vldts, 2 );
    unset( $vldts );
    $aksi = "";
}
else
{
    #$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
	$href = "index.php?pilihan={$pilihan}&";
    if ( $angkatancari != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatancari}' ";
		$qfield2 .= " AND d.ANGKATAN='{$angkatancari}' ";
        $qjudul .= " Angkatan {$angkatancari} <br>";
    }
    if ( $idprodicari != "" )
    {
        $qfield .= " AND mahasiswa.IDPRODI='{$idprodicari}' ";
		$qfield2 .= " AND d.IDPRODI='{$idprodicari}' ";
        $qjudul .= " Program Studi ".$arrayprodidep[$idprodicari]." <br>";
    }
	
	if ( $gelombang != "" )
    {
        $qfield .= " AND mahasiswa.GELOMBANG='{$gelombang}' ";
        $qjudul .= " Gelombang {$gelombang} <br>";
    }
	
    if ( $jeniskolom == "SPC" )
    {
       # $qfield .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
	#	$qfield2 .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
	$qfield .= " AND komponenpembayaran.LABELSPC!=''";
	#	$qfield2 .= " AND komponenpembayaran.LABELSPC!=''";

        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	
    if ( $koderekening2 != "" )
    {
        $qfield .= " AND komponenpembayaran.KODEREKENING2='$koderekening2'";
		$qjudul .= " Kode Rekening {$koderekening2} <br>";
		#$qfield2 .= " AND komponenpembayaran.KODEREKENING='$koderekening' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }

    if ( $idkomponencari != "" )
    {
        $qfield .= " AND komponenpembayaran.ID='{$idkomponencari}' ";
        $qjudul .= " Komponen ".$arraykomponenpembayaran[$idkomponencari]." <br>";
    }	

    if ( $statuskirim != "" )
    {
        $qfield .= " AND buattagihanvabni.STATUS='$statuskirim'";
	if($statuskirim==0){
		$statuskiriman="Kirim Data Baru";
	}if($statuskirim==4){
		$statuskiriman="Berhasil Kirim Ulang";
	}else{
		$statuskiriman="Kirim Ulang Data";
	}
	
	$qjudul .= " Status {$statuskiriman} <br>";
		#$qfield2 .= " AND komponenpembayaran.KODEREKENING='$koderekening' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	
	
    $qjudul .= " Tanggal Tagihan {$tanggal} <br>";
	if ( $arraysort[$sort] == "" )
	{
		$sort = 0;
	}
	$qinput .= " <input type=hidden name=sort value='{$sort}'>";

    
    $q = "SELECT buattagihanvabni.TANGGALTAGIHAN,buattagihanvabni.IDMAHASISWA,buattagihanvabni.TRXID,buattagihanvabni.VANUMB,buattagihanvabni.IDKOMPONEN,
	SUM(buattagihanvabni.JUMLAH) AS TOTALTAGIHAN,buattagihanvabni.EXPDATE,buattagihanvabni.EXPTIME,buattagihanvabni.STATUS AS STATUSTRANSAKSI,
	SUM(buattagihanvabni.STATUS) AS SUDAHDIPROSES,SUM(buattagihanvabni.DENDA) AS TOTALDENDA,buattagihanvabni.TAHUN,buattagihanvabni.SEMESTER,
	COUNT(buattagihanvabni.STATUS) AS TOTALDATA, mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.ANGKATAN ,mahasiswa.ALAMAT,
	prodi.NAMA AS NAMAPRODI, prodi.TINGKAT, departemen.NAMA AS NAMAJURUSAN, fakultas.NAMA AS NAMAFAKULTAS,komponenpembayaran.KODEREKENING2,
	komponenpembayaran.JENISBILLING,komponenpembayaran.JENIS FROM mahasiswa, prodi, departemen LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS ,buattagihanvabni,komponenpembayaran 
	WHERE departemen.ID=prodi.IDDEPARTEMEN AND mahasiswa.IDPRODI=prodi.ID AND buattagihanvabni.IDKOMPONEN=komponenpembayaran.ID AND 
	mahasiswa.ID=buattagihanvabni.IDMAHASISWA AND buattagihanvabni.TANGGALTAGIHAN='{$tanggal}' {$qfield} 
	AND komponenpembayaran.KODEBANK2!=''
	GROUP BY buattagihanvabni.VANUMB ORDER BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN";


	#}
	#echo $q.'<br>';

	$h = mysqli_query($koneksi,$q);

    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printtitle("Kirim Tagihan VA BNI");
									printmesg( $qjudul );      
        
        
		echo "						<div class=\"m-portlet\">	
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='index.php'>
										<input type=hidden name=sessid value='{$_SESSION['token']}'>
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th>No</th>
															<th>Tgl Tagihan</th>
															<th>NIM</th>
															<th>Nama</th>
															<th>Angkatan</th>
															<th>Program Studi</th>
															<th>Komponen</th>	
															<th>Total Tagihan</th>
															<th>Total Denda</th>
															<th>TRX ID</th>
															<th>VA Numb</th>
															<th>Expired Date</th>
															";
															if ( $tingkataksesusers[$kodemenu] == "T" )
															{
																echo "<th>Aksi</th>";															}

        #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
			
			$waktu = "-";
				if ( $d[JENIS] == 2 )
				{
					$waktu = ( $d[TAHUN] - 1 )."/{$d['TAHUN']}";
				}
				else if ( $d[JENIS] == 3 || $d[JENIS] == 6 )
				{
					$waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUN] - 1 )."/{$d['TAHUN']}";
				}
				else if ( $d[JENIS] == 5 )
				{
					$waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUN']}";
				}
            #echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td> <input type='checkbox' class='chkbox' name='ids[]' value='".$i."' ></td><td align=left nowrap>".$d[TANGGALTAGIHAN]."</td><td align=left nowrap>".$d[IDMAHASISWA]."</td><td align=left>{$d['NAMA']}</td><td align=left>".$d[ANGKATAN]."</td><td align=left>".$d[NAMAPRODI]."</td><td align=left>{$d['IDKOMPONEN']}/".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=left>{$waktu}</td><td align=left><input type='text' name='jml_tagihan_[{$i}]' value='{$d[JUMLAH]}'></td><td align=left><input type='text' size='10' maxlength='10' name='expired_tagihan_[{$i}]' value='{$d[EXPDATE]}'><input type='hidden' name='tgl_tagihan_[{$i}]' value='{$d[TANGGALTAGIHAN]}'><input type='hidden' name='komponen_tagihan_[{$i}]' value='{$d[IDKOMPONEN]}'><input type='hidden' name='id_mhs_[{$i}]' value='{$d[IDMAHASISWA]}'><input type='hidden' name='semester_ajaran_[{$i}]' value='{$d[SEMESTER]}'><input type='hidden' name='tahun_ajaran_[{$i}]' value='{$d[TAHUN]}'></td></td>";
			echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td align=left nowrap>".$i."</td><td align=left nowrap>".$d['TANGGALTAGIHAN']."</td><td align=left nowrap>".$d['IDMAHASISWA']."</td><td align=left>{$d['NAMA']}</td><td align=left>".$d['ANGKATAN']."</td><td align=left>".$d['NAMAPRODI']."</td><td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]."</td><!--<td align=left>{$waktu}</td>--><td align=right>".$d['TOTALTAGIHAN']."</td><td>".$d['TOTALDENDA']."<td>".$d['TRXID']."</td><td>".$d['VANUMB']."</td><td align=left>".$d['EXPDATE']."</td>";
			if ( $tingkataksesusers[$kodemenu] == "T" )
			{
				#echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td>\r\n\t\t\t\t\t\t\t";
				
					#echo "\t<td   align=center ><a onclick=\"return confirm('Kirim Data Tagihan Tanggal = {$d['TANGGALTAGIHAN']},NIM={$d['IDMAHASISWA']},KOMPONEN={$arraykomponenpembayaran[$d[IDKOMPONEN]]} ? ?');\" href='{$href}aksi2=kirimdata&tanggal={$d['TANGGALTAGIHAN']}&idmhs={$d['IDMAHASISWA']}&idkomponen={$d['IDKOMPONEN']}&tahun={$d['TAHUN']}&semester={$d['SEMESTER']}&sessid={$_SESSION['token']}'>Kirim Data</td>\r\n  \t\t\t\t\t\t\t\t";
					$bill_type=$d['JENISBILLING'];
				
				$total_tagihan_mhs=$d['TOTALTAGIHAN']+$d['TOTALDENDA'];
				#echo "STATUSNYA=".$d['STATUSTRANSAKSI'];
				if($d['STATUSTRANSAKSI']==2){
					
					$gabungwaktuexpired=$d['EXPDATE']." ".$d['EXPTIME'];
					#echo "GABUNG=".$gabungwaktuexpired;
					$waktuskrg = strtotime(date("Y-m-d H:i:s")); 
					$waktuexpired = strtotime($gabungwaktuexpired);
					
					#if($waktuskrg>$waktuexpired){
					#	echo "<td align=center ><a href='{$href}aksi2=kirimdata&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=createbilling&client_id={$d['KODEREKENING']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Kirim Data Baru</td>";
					#}else{
				
						echo "<td align=center >{$teks}<a style='color:#2f44e8;' href='{$href}aksi2=kirimulang&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=updatebilling&client_id={$d['KODEREKENING2']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Kirim Ulang Data</td>";
				
					#}
	
					
				}elseif($d['STATUSTRANSAKSI']==4){
					
					$gabungwaktuexpired=$d['EXPDATE']." ".$d['EXPTIME'];
					#echo "GABUNG=".$gabungwaktuexpired;
					$waktuskrg = strtotime(date("Y-m-d H:i:s")); 
					$waktuexpired = strtotime($gabungwaktuexpired);
					
					#if($waktuskrg>$waktuexpired){
					#	echo "<td align=center ><a href='{$href}aksi2=kirimdata&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=createbilling&client_id={$d['KODEREKENING']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Kirim Data Baru</td>";
					#}else{
				
						#echo "<td align=center>Berhasil</td>";
						echo "<td align=center >{$teks}<a style='color:#2f44e8;' href='{$href}aksi2=kirimulang&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=updatebilling&client_id={$d['KODEREKENING2']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Berhasil</td>";
				

				
					#}
	
					
				}
				elseif($d['STATUSTRANSAKSI']==1){
					
					$gabungwaktuexpired=$d['EXPDATE']." ".$d['EXPTIME'];
					#echo "GABUNG=".$gabungwaktuexpired;
					$waktuskrg = strtotime(date("Y-m-d H:i:s")); 
					$waktuexpired = strtotime($gabungwaktuexpired);
					
					#if($waktuskrg>$waktuexpired){
					#	echo "<td align=center ><a href='{$href}aksi2=kirimdata&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=createbilling&client_id={$d['KODEREKENING']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Kirim Data Baru</td>";
					#}else{
				
						echo "<td align=center>Tagihan sudah dibayar</td>";
						#echo "<td align=center >{$teks}<a href='{$href}aksi2=kirimulang&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=updatebilling&client_id={$d['KODEREKENING2']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Berhasil</td>";
				

				
					#}
	
					
				}

				else{
					echo "<td align=center><a style='color:#2f44e8;' href='{$href}aksi2=kirimdata&tgl_tagihan={$d['TANGGALTAGIHAN']}&angkatan_mhs={$d['ANGKATAN']}&prodi_mhs={$d['IDPRODI']}&type=createbilling&client_id={$d['KODEREKENING2']}&trx_id={$d['TRXID']}&trx_amount={$total_tagihan_mhs}&billing_type={$bill_type}&dateexpired={$d['EXPDATE']}&timeexpired={$d['EXPTIME']}&virtual_account={$d['VANUMB']}&customer_name={$d['NAMA']}&statuskirim={$statuskirim}&sessid={$_SESSION['token']}'>Kirim Data Baru</td>";
				}
			}

            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				
			</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Tagihan Tidak Ada";
        $aksi = "";
    }
}
?>
