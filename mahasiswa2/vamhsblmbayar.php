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

if ( isset( $vldts ) && 0 < count( $vldts ) ) {
    $errmesg = "Data pencarian berikut tidak valid, silahkan cek kembali".inv_message( $vldts, 2 );
    unset( $vldts );
    $aksi = "";
} else {
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
        $qfield .= " AND komponenpembayaran.KODEREKENING2='$koderekening'";
		$qjudul .= " Kode Rekening {$koderekening} <br>";
		#$qfield2 .= " AND komponenpembayaran.KODEREKENING2='$koderekening' ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
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

	$q = "SELECT DATE_FORMAT(a.TANGGAL,'%d-%m-%Y') AS TANGGALTAGIHAN,b.ID,b.NAMA,c.ID AS IDKOMPONEN,a.BIAYA, DATE_FORMAT(a.TANGGALBAYAR2,'%d-%m-%Y') AS BATASBAYAR FROM biayakomponen_tagihan a JOIN mahasiswa b ON a.IDPRODI=b.IDPRODI AND a.GELOMBANG=b.GELOMBANG AND a.ANGKATAN=b.ANGKATAN JOIN komponenpembayaran c ON a.IDKOMPONEN=c.ID WHERE b.ID='{$users}' AND YEAR(a.TANGGAL)>=YEAR(NOW()) ORDER BY a.TAHUN,a.SEMESTER,a.TANGGAL";
	echo $q.'<br>';
	#exit();
	$h = mysqli_query($koneksi,$q);
	if ( 0 < sqlnumrows( $h ) )
	{	   
		echo "<div class='m-portlet'>
                <form class='m-form m-form--fit m-form--label-align-right m-form--group-seperator' name=form action=index.php method=post>
			<input type=text name=pilihan value='$pilihan'>      				
					<div class='m-section__content'>
						<div class='table-responsive'>
							<table class='table table-bordered table-hover'>
								<thead>
                                    <tr class=juduldata{$aksi} align=center>
                                        <td>No</td>	
                                        <td>Tgl Tagihan</td>
                                        <td>NIM</td>
                                        <td>Nama</td>
                                        <td>Komponen</td>
                                        <td>Tagihan</td>									
                                        <td>Batas Bayar</td>
                                        <td>Pilih</td>	
                                    </tr>
                                </thead>
							<tbody>";	
                            $i = 1;
                            while ( $d = sqlfetcharray( $h ) ) {
                                $waktu = "-";
                                if ( $d['JENIS'] == 2 ) {
                                    $waktu = ( $d['TAHUN'] - 1 )."/{$d['TAHUN']}";
                                }
                                else if ( $d['JENIS'] == 3 || $d['JENIS'] == 6 ) {
                                    $waktu = "".$arraysemester[$d['SEMESTER']]." ".( $d['TAHUN'] - 1 )."/{$d['TAHUN']}";
                                }
                                else if ( $d['JENIS'] == 5 ) {
                                    $waktu = "".$arraybulan[$d['SEMESTER'] - 1]." {$d['TAHUN']}";
                                }
				
                                echo "<tr align=center {$kelas}{$aksi} {$stylestrike}>
                                        <td align=left nowrap>".$i."</td>
                                        <td align=left nowrap>".$d['TANGGALTAGIHAN']."</td>
                                        <td align=left nowrap>".$d['ID']."</td>
                                        <td align=left>{$d['NAMA']}</td>
                                        <td align=left>".$arraykomponenpembayaran[$d['IDKOMPONEN']]."</td>
                                        <td align=right>".cetakuang($d['BIAYA'])."</td>
                                        <td align=right>".$d['BATASBAYAR']."</td>
                                        <td align=center><input type='checkbox' name='pilih[]' value='{$d['ID']}{$d['BIAYA']}'></td>
                                    </tr>";
                                ++$i;
                            }

		                    echo "  </tbody>
								    </table>
                                    <div class='form-group m-form__group row' style='background-color:#f7f8fa;'>
                                        <label class='col-lg-11 col-form-label'>&nbsp;</label>    
                                        <div class='col-lg-1'>
                                            <input type=submit value='Tambah' name='aksi2' class='btn btn-brand'>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>";
		$aksi = "tampilkan";
	}
	else
	{
		$errmesg = "Data VA Tidak Ada";
		$aksi = "";
	}
}
?>
