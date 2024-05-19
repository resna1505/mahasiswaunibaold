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
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $angkatancari != "" )
    {
        $qfield .= " AND a.ANGKATAN='{$angkatancari}' ";
		$qfield2 .= " AND d.ANGKATAN='{$angkatancari}' ";
        $qjudul .= " Angkatan {$angkatancari} <br>";
    }
    if ( $idprodicari != "" )
    {
        $qfield .= " AND a.IDPRODI='{$idprodicari}' ";
		$qfield2 .= " AND d.IDPRODI='{$idprodicari}' ";
        $qjudul .= " Program Studi ".$arrayprodidep[$idprodicari]." <br>";
    }
	
	if ( $gelombang != "" )
    {
        $qfield .= " AND a.GELOMBANG='{$gelombang}' ";
        $qjudul .= " Gelombang {$gelombang} <br>";
    }
	
    if ( $jeniskolom == "SPC" )
    {
        $qfield .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
		$qfield2 .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	
	if ( $koderekening2 != "" )
    {
        $qfield .= " AND komponenpembayaran.KODEREKENING2='$koderekening2'";
		$qfield2 .= " AND komponenpembayaran.KODEREKENING2='$koderekening2' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	
    $qjudul .= " Tanggal Tagihan {$tanggal} <br>";
    
    $q = "SELECT komponenpembayaran.LABELSPC,komponenpembayaran.JENIS,komponenpembayaran.KODEREKENING2,buattagihanvabni.IDMAHASISWA,buattagihanvabni.IDKOMPONEN,".
	"buattagihanvabni.JUMLAH AS JUMLAH,buattagihanvabni.DENDA,buattagihanvabni.TANGGALTAGIHAN,buattagihanvabni.TAHUN,".
	"buattagihanvabni.SEMESTER,buattagihanvabni.TRXID,buattagihanvabni.VANUMB,buattagihanvabni.EXPDATE,".
	"buattagihanvabni.EXPTIME,buattagihanvabni.JUMLAH AS JUMLAH,buattagihanvabni.STATUS AS SUDAHDIPROSES,".
	"buattagihanvabni.STATUS AS TOTALDATA,a.NAMA,a.IDPRODI,a.ANGKATAN,a.ALAMAT,".
	"prodi.NAMA AS NAMAPRODI, prodi.TINGKAT,departemen.NAMA AS NAMAJURUSAN,fakultas.NAMA AS NAMAFAKULTAS ".
	"FROM mahasiswa a, prodi, departemen LEFT JOIN fakultas 
	ON fakultas.ID=departemen.IDFAKULTAS,buattagihanvabni,komponenpembayaran WHERE departemen.ID=prodi.IDDEPARTEMEN AND 
	a.IDPRODI=prodi.ID AND buattagihanvabni.IDKOMPONEN=komponenpembayaran.ID AND 
	a.ID=buattagihanvabni.IDMAHASISWA AND buattagihanvabni.TANGGALTAGIHAN='{$tanggal}' AND komponenpembayaran.KODEBANK2!='' {$qfield} 
	ORDER BY a.IDPRODI,a.ANGKATAN,IDMAHASISWA,IDKOMPONEN,TAHUN";	

	#}
	echo $q.'<br>';
	#exit();

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
									printtitle("Koreksi Tagihan VA BNI");
									printmesg( $qjudul );
       
        
        
		echo "						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='index.php'>
									<input type=hidden name=sessid value='{$_SESSION['token']}'>
									<div class=\"m-portlet\">
										<div class=\"tools\">										
				<div class=\"table-scrollable\">
					<table class=\"table table-striped table-bordered table-hover\">
						<tr>
							<td width=\"1%;\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=submit name=aksi value='Update' class=\"btn btn-brand\">
								<input type=submit name=aksi2 value='Hapus' class=\"btn btn-brand\">
								<!--<input type='submit' name='printbtn' value='Simpan' class=\"btn btn-brand\">-->										
							</td>
						</tr>
					</table>
				</div>
			 </div>										
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th><input type='checkbox' name='chkall' id='chkallva'></th> 
															<th>Tgl Tagihan</th>
															<th>NIM</th>
															<th>Nama</th>
															<th>Angkatan</th>
															<th>Program Studi</th>
															<th>Komponen</th>
															<th>Waktu</th>
															<th>Jumlah Tagihan</th>
															<td>Denda</td>
															<td>VA Numb</td>
															<th>Expired Date</th>
															";
        /*if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "<th>Hapus</th>\r\n\t\t\t\t\t\t\t";
        }*/
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
			echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td> <input type='checkbox' class='chkboxva' name='ids[]' value='".$i."' checked></td><td align=left nowrap>".$d['TANGGALTAGIHAN']."</td><td align=left nowrap>".$d['IDMAHASISWA']."</td><td align=left>{$d['NAMA']}</td><td align=left>".$d['ANGKATAN']."</td><td align=left>".$d['NAMAPRODI']."</td><td align=left>{$d['IDKOMPONEN']}/".$arraykomponenpembayaran[$d['IDKOMPONEN']]."</td><td align=left>{$waktu}</td><td align=left><input type='text' name='jml_tagihan_[{$i}]' size='10' value='{$d[JUMLAH]}'></td><td><input type='text' size='10' name='jml_denda_[{$i}]' value='{$d['DENDA']}'></td><td align=left><input type='text' size='12' maxlength='16' name='va_numb_[{$i}]' value='{$d['VANUMB']}'></td><td align=left><input type='text' size='8' maxlength='10' name='expired_tagihan_[{$i}]' value='{$d['EXPDATE']}'><input type='hidden' name='tgl_tagihan_[{$i}]' value='{$d['TANGGALTAGIHAN']}'><input type='hidden' name='komponen_tagihan_[{$i}]' value='{$d['IDKOMPONEN']}'><input type='hidden' name='id_mhs_[{$i}]' value='{$d['IDMAHASISWA']}'><input type='hidden' name='semester_ajaran_[{$i}]' value='{$d['SEMESTER']}'><input type='hidden' name='tahun_ajaran_[{$i}]' value='{$d['TAHUN']}'><input type='hidden' name='angkatan_mhs' value='{$d['ANGKATAN']}'><input type='hidden' name='prodi_mhs' value='{$d['IDPRODI']}'><input type='hidden' name='kode_rekening2' value='{$d['KODEREKENING2']}'><input type='hidden' name='va_numb_lama_[{$i}]' value='{$d['VANUMB']}'><input type='hidden' name='exp_date_lama_[{$i}]' value='{$d['EXPDATE']}'></td>";
			
		
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        
echo "					</tbody>
				</table>
			</div>
			</div>
			</div>
			<!--end::Section-->
			
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
