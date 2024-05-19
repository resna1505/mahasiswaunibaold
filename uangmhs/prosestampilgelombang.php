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
$arraysort[0] = "a.IDPRODI";
$arraysort[1] = "a.ANGKATAN";
$arraysort[2] = "a.ID";
$arraysort[3] = "a.NAMA";
$arraysort[4] = "a.STATUS";
$arraysort[5] = "a.IDDOSEN";
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
	
    #$qjudul .= " Tanggal Tagihan {$tanggal} <br>";
	if ( $arraysort[$sort] == "" )
    {
        $sort = 2;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(DISTINCT(a.ID)) AS JML \r\n  FROM msmhs b  ,mahasiswa a LEFT JOIN mahasiswa2 c ON a.ID=c.ID 
	WHERE a.ID=b.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
    #echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
	/*if($status=="L"){
    
		$q = "SELECT mahasiswa.HP,mahasiswa.KTP,mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR \r\n,trlsm.NOIJATRLSM  FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    
	}else{*/
	
		#$q = "SELECT DISTINCT(mahasiswa.ID),mahasiswa.HP,mahasiswa.KTP,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR,trlsm.NOIJATRLSM \r\n  FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID LEFT JOIN trlsm ON trlsm.NIMHSTRLSM=mahasiswa.ID WHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    		$q = "SELECT DISTINCT(a.ID),a.HP,a.KTP,a.NAMA,a.ANGKATAN,a.STATUS,a.GELOMBANG,
			a.IDDOSEN,a.IDPRODI,YEAR(NOW())-YEAR(a.TANGGAL) AS UMUR FROM msmhs {$qtabel}, mahasiswa a 
			LEFT JOIN mahasiswa2 ON a.ID=mahasiswa2.ID WHERE \r\n   
			a.ID=msmhs.NIMHSMSMHS {$qprodidep2} {$qfield} AND a.STATUS='A' ORDER BY ".$arraysort[$sort]."";
    	

	#}
	#echo $q.'<br>';

	$h = mysqli_query($koneksi,$q);

	#}
	
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
									printtitle("Data Mahasiswa");
									printmesg( $qjudul );
       
        
        
		echo "						<div class=\"m-portlet\">	
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='index.php'>
										<input type=hidden name=sessid value='{$_SESSION['token']}'>
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th><input type='checkbox' name='chkall' id='chkall'></th> 
															<th>NIM</th>
															<th>Nama</th>
															<th>Angkatan</th>
															<th>Program Studi</th>
															<th>Gelombang</th>
															<th>Pindah ke Gelombang</th>
															";
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
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td> <input type='checkbox' class='chkbox' name='ids[]' value='".$i."' ></td><td align=left nowrap>".$d[ID]."</td><td align=left>{$d['NAMA']}</td><td align=left>".$d[ANGKATAN]."</td><td align=left>".$arrayprodidep[$d[IDPRODI]]."</td><td align=center>{$d['GELOMBANG']}</td><td align=left><input type='text' name='gelombang_baru_[{$i}]' value='{$d[GELOMBANG]}'><input type='hidden' name='gelombang_awal_[{$i}]' value='{$d[GELOMBANG]}'><input type='hidden' name='id_mhs_[{$i}]' value='{$d[ID]}'></td></td>";
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
				<div class=\"tools\">										
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td width=\"1%;\">
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='simpandata'>
										<input type='submit' name='printbtn' value='Simpan' class=\"btn btn-brand\">
									</td>
								</tr>
							</table>
						</div>
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
