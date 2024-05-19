<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
periksaroot( );
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
	
	if ( $koderekening != "" )
    {
        $qfield .= " AND komponenpembayaran.KODEREKENING2='$koderekening2'";
		$qjudul .= " Kode Rekening {$koderekening2} <br>";
		#$qfield2 .= " AND komponenpembayaran.KODEREKENING2='$koderekening2' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }

    if ( $statusimpor != "" )
    {
        $qfield .= " AND buattagihanvabni.STATUS!='$statusimpor'";
	$statusimpordata="Impor Data";
		$qjudul .= " Status Impor {$statusimpordata} <br>";
		#$qfield2 .= " AND komponenpembayaran.KODEREKENING='$koderekening' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
		
    $qjudul .= " Tanggal Tagihan {$tanggal} <br>";
	if ( $arraysort[$sort] == "" )
	{
		$sort = 0;
	}
	$qinput .= " <input type=hidden name=sort value='{$sort}'>";
	
	$q = "SELECT buattagihanvabni.TANGGALTAGIHAN,buattagihanvabni.IDMAHASISWA,buattagihanvabni.TRXID,buattagihanvabni.VANUMB,bniva_paid.payment_amount,
	buattagihanvabni.STATUS AS STATUSTRANSAKSI,bniva_paid.trx_amount,DATE_FORMAT(bniva_paid.datetime_payment,'%Y-%m-%d') AS payment_date,
	bniva_paid.datetime_payment AS payment_time,buattagihanvabni.IDKOMPONEN,mahasiswa.NAMA,mahasiswa.IDPRODI,komponenpembayaran.KODEREKENING 
	FROM mahasiswa JOIN buattagihanvabni ON mahasiswa.ID=buattagihanvabni.IDMAHASISWA JOIN bniva_paid ON bniva_paid.trx_id=buattagihanvabni.TRXID 
	JOIN komponenpembayaran ON komponenpembayaran.ID=buattagihanvabni.IDKOMPONEN WHERE buattagihanvabni.TANGGALTAGIHAN='{$tanggal}' {$qfield} GROUP BY TRXID 
	ORDER BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
	echo $q.'<br>';


	#}
	echo $q.'<br>';

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
									printtitle("Import Bayar VA BNI");
									printmesg( $qjudul );      
        
        
		echo "						<div class=\"m-portlet\">	
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='index.php'>
										<input type=hidden name=sessid value='{$_SESSION['token']}'>
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th>Tgl Tagihan</th>
															<th>Trx ID</th>
															<th>VA Numb</th>
															<th>Komponen</th>
															<th>NIM</th>
															<th>Nama</th>
															<th>Total Tagihan</th>
															<th>Total Bayar</th>
															<th>Tgl Bayar</th>															";
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
					$waktu = ( $d['TAHUN'] - 1 )."/{$d['TAHUN']}";
				}
				else if ( $d[JENIS] == 3 || $d[JENIS] == 6 )
				{
					$waktu = "".$arraysemester[$d['SEMESTER']]." ".( $d['TAHUN'] - 1 )."/{$d['TAHUN']}";
				}
				else if ( $d[JENIS] == 5 )
				{
					$waktu = "".$arraybulan[$d['SEMESTER'] - 1]." {$d['TAHUN']}";
				}
            		#echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td> <input type='checkbox' class='chkbox' name='ids[]' value='".$i."' ></td><td align=left nowrap>".$d[TANGGALTAGIHAN]."</td><td align=left nowrap>".$d[IDMAHASISWA]."</td><td align=left>{$d['NAMA']}</td><td align=left>".$d[ANGKATAN]."</td><td align=left>".$d[NAMAPRODI]."</td><td align=left>{$d['IDKOMPONEN']}/".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td><td align=left>{$waktu}</td><td align=left><input type='text' name='jml_tagihan_[{$i}]' value='{$d[JUMLAH]}'></td><td align=left><input type='text' size='10' maxlength='10' name='expired_tagihan_[{$i}]' value='{$d[EXPDATE]}'><input type='hidden' name='tgl_tagihan_[{$i}]' value='{$d[TANGGALTAGIHAN]}'><input type='hidden' name='komponen_tagihan_[{$i}]' value='{$d[IDKOMPONEN]}'><input type='hidden' name='id_mhs_[{$i}]' value='{$d[IDMAHASISWA]}'><input type='hidden' name='semester_ajaran_[{$i}]' value='{$d[SEMESTER]}'><input type='hidden' name='tahun_ajaran_[{$i}]' value='{$d[TAHUN]}'></td></td>";
			echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td align=center nowrap>".$d['TANGGALTAGIHAN']."</td><td>".$d['TRXID']."</td><td>".$d['VANUMB']."</td><td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]."</td><td align=left nowrap>".$d['IDMAHASISWA']."</td><td align=left>{$d['NAMA']}</td><td align=right>".$d['trx_amount']."</td><td align=right>".$d['payment_amount']."</td><td align=center>".$d['payment_time']."</td>";
			
			if ( $tingkataksesusers[$kodemenu] == "T" )
			{
				
				
				$total_tagihan_mhs=$d['TOTALTAGIHAN']+$d['TOTALDENDA'];
				if($d['STATUSTRANSAKSI']==1){
				
					#echo "<td   align=center >Data Sudah di Impor</td>";
						echo "<td   align=center ><a href='{$href}aksi2=sinkrondata&tgl_tagihan={$d['TANGGALTAGIHAN']}&prodi_mhs={$d['IDPRODI']}&trx_id={$d['TRXID']}&date_payment={$d['payment_date']}&virtual_account={$d['VANUMB']}&payment_amount={$d['payment_amount']}&client_id={$koderekening}&statusimpor={$statusimpor}&sessid={$_SESSION['token']}'>Impor Ulang</td>";
					
				}else{
					echo "<td   align=center ><a href='{$href}aksi2=sinkrondata&tgl_tagihan={$d['TANGGALTAGIHAN']}&prodi_mhs={$d['IDPRODI']}&trx_id={$d['TRXID']}&date_payment={$d['payment_date']}&virtual_account={$d['VANUMB']}&payment_amount={$d['payment_amount']}&client_id={$koderekening}&statusimpor={$statusimpor}&sessid={$_SESSION['token']}'>Impor Data</td>";
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
