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
    if ( $idprodi != "" )
    {
        $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $jenisusers == 1 )
    {
        $iddosen = $users;
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    $qtabel = "";
    if ( $status != "" )
    {
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
        /*if ( $iftahunakademik == 1 )
        {
            #$qtabel = ", trlsm ";
            #$qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
            $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}'";
            
			$qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
            $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
            $href .= "iftahunakademik={$iftahunakademik}&tahun2={$tahun2}&semester2={$semester2}&";
        }
        #else
        #{
		#		$qfield .= " AND mahasiswa.STATUS='{$status}' AND trlsm.STMHSTRLSM='{$status}'";
	 # }
		$qfield .= " AND mahasiswa.STATUS='{$status}'";
		#$qfield .= " AND mahasiswa.STATUS='{$status}' AND trlsm.STMHSTRLSM='{$status}'";*/
	$qfield .= " AND mahasiswa.STATUS='{$status}'";

	if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
   	$href .= "iftahunakademik={$iftahunakademik}&tahun2={$tahun2}&semester2={$semester2}&";
 
   }


    }
    if ( $statusawal != "" )
    {
        $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
        $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
        $href .= "statusawal={$statusawal}&";
        $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
    }
    if ( $tahuna != "" && $semestera != "" )
    {
        $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
        $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
        $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
        $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
        $href .= "semestera={$semestera}&tahuna={$tahuna}&";
    }
	
    include( "prosescari2.php" );
    if ( $arraysort[$sort] == "" )
    {
        $sort = 2;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(DISTINCT(mahasiswa.ID)) AS JML \r\n  FROM msmhs {$qtabel}  ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID WHERE mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
    #echo $q.'<br>';
    $h = doquery($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
	/*if($status=="L"){
    
		$q = "SELECT mahasiswa.HP,mahasiswa.KTP,mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR \r\n,trlsm.NOIJATRLSM  FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    
	}else{*/
	
		#$q = "SELECT DISTINCT(mahasiswa.ID),mahasiswa.HP,mahasiswa.KTP,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR,trlsm.NOIJATRLSM \r\n  FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID LEFT JOIN trlsm ON trlsm.NIMHSTRLSM=mahasiswa.ID WHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    		$q = "SELECT DISTINCT(mahasiswa.ID),mahasiswa.HP,mahasiswa.KTP,mahasiswa.EMAIL,mahasiswa.EMAIL2,mahasiswa.NAMA,mahasiswa.IDCALONMAHASISWA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID WHERE mahasiswa.ID=msmhs.NIMHSMSMHS {$qprodidep2} {$qfield} ORDER BY ".$arraysort[$sort]." {$qlimit}";
    	

	#}
	#echo $q.'<br>';

	$h = doquery($koneksi,$q);

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
								
        if ( $aksi != "cetak" )
        {
			printtitle( $qjudul );
            #printmesg( $qjudul );
            #printmesg( $errmesg );
			/*echo "					{$tpage} {$tpage2}<div class=\"tools\">
										<form target=_blank action='cetakmahasiswa.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn green\">
														<input type=submit name=aksi2 value='Cetak Lengkap' class=\"btn btn-brand\">
														<input type=submit name=aksi2 green value='Cetak Data Dikti' class=\"btn btn-brand\">
														<input type=submit name=aksi2 value='Form Kehadiran' class=\"btn btn-brand\">
														<input type=submit name=aksi2 value='Kartu' class=\"btn btn-brand\">
														<input type=submit name=aksi2 value='Kartu Baru' class=\"btn btn-brand\">
													</td>
												</tr>
											</table>
										</form>
									</div>";*/
        }
        #else
        #{
        #    printjudulmenucetak( "Data Mahasiswa" );
        #    printmesgcetak( $qjudul );
        #}
        if ( $aksi != "cetak" )
        {
            echo " {$tpage} {$tpage2}";
			echo "	<form target=_blank action='cetakmahasiswa.php'>
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td>
										<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>";
            if ( $jenisusers == 0 )
            {
                echo "\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Lengkap'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Data Dikti'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Form Kehadiran'><input type=submit name=aksi2 class=\"btn btn-brand\" value='Kartu Baru'>\r\n          ";
                if ( $semestera != "" && $tahuna != "" )
                {
                    echo "\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Permohonan NIMAN'>";
                }
                if ( getaturan( "PUSAKA" ) == 1 && getaturan( "URLPUSAKA" ) != "" )
                {
                    echo "\r\n   \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Ekspor ke Pusaka'>";
                }
            }
            echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}</td></tr></table></div></form>";
        }
        #if ( $aksi != "cetak" )
        #{
            #echo "\r\n\t\t<table>\r\n\t\t<tr>\r\n\t\t<td>\r\n\t\tData dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data mahasiswa tersebut.\r\n\t\t</td>\r\n\t\t</tr>\r\n    </table>";
        #}
        //echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td>";

      
							echo "						<div class=\"caption\">";
												printtitle("Data dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data mahasiswa tersebut.");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th scope=\"col\">No</th>
															<th><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</a></th>
															<th><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</a></th>
															<th><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</a></th>
															<th><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</a></th>
															<th><a class='{$cetak}' href='{$href}"."&sort=4'>Status</a></th>
															<th>KTP</th>
															<th>Email</th>
															<th>Email Pembayaran</th>
															<th>No. Ijazah</th>";
        if ( $tingkataksesusers[$kodemenu] == "T")
        {
            echo "\r\n\t\t\t\t\t\t\t<th>Edit</th><th>Hapus</th>\r\n\t\t\t\t\t\t\t";
        
	}else if($_SESSION['users']=='willy' || $_SESSION['users']=='perdana'){
	    echo "\r\n\t\t\t\t\t\t\t<th>Edit</th>";	
	}
        #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            #$kelas = kelas( $i );
	    $sql_cek_data="SELECT trlsm.STMHSTRLSM AS stat_trlsm,trlsm.NOIJATRLSM FROM trlsm WHERE trlsm.NIMHSTRLSM='{$d['ID']}' ORDER BY trlsm.THSMSTRLSM DESC LIMIT 1";
	    #echo $sql_cek_data;	
	    $query_cek_data=mysqli_query($koneksi,$sql_cek_data);
	    $data_cek_data=sqlfetcharray($query_cek_data);	

	    //ambil data ktp dari table calon mahasiswa
	   /*$sql_calon_mahasiswa="SELECT KTP FROM calonmahasiswa WHERE ID='{$d[IDCALONMAHASISWA]}'";
           #echo $sql_calon_mahasiswa;
           $h_calon_mahasiswa = mysql_query( $sql_calon_mahasiswa);
	   $d_calon_mahasiswa = sqlfetcharray( $h_calon_mahasiswa );
	   $KTP=$d_calon_mahasiswa['KTP'];*/

	   if($d['IDCALONMAHASISWA']==''){

		//ambil data ktp dari table mahasiswa
		$sql_mahasiswa_lama="SELECT KTP FROM mahasiswa WHERE ID='{$d[ID]}'";
        	$h_mahasiswa_lama = mysqli_query($koneksi,$sql_mahasiswa_lama);
		$d_mahasiswa_lama = sqlfetcharray( $h_mahasiswa_lama );
		$KTP=$d_mahasiswa_lama['KTP'];

	
	   }else{
		//ambil data ktp dari table calon mahasiswa
		$sql_calon_mahasiswa="SELECT KTP FROM calonmahasiswa WHERE ID='{$d[IDCALONMAHASISWA]}'";
        	$h_calon_mahasiswa = mysqli_query($koneksi,$sql_calon_mahasiswa);
		$d_calon_mahasiswa = sqlfetcharray( $h_calon_mahasiswa );
		$KTP=$d_calon_mahasiswa['KTP'];
		
	   }
	
	
            $kelas = kelas( $i );
	
            #if ( $d[UMUR] <= 15 && $aksi != "cetak" )
	    if ( ($d[UMUR] <= 15 || $data_cek_data['stat_trlsm']!=$d[STATUS]) && $d[STATUS]!='A'  && $aksi != "cetak" )	
            {
                $kelas = "style='background-color:#ffff00'";
            }
            #echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."</td>";
            #echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."</td><td align=left>".$d[KTP]."</td><td align=left>".$d[HP]."</td><td align=left>".$d[NOIJATRLSM]."</td>";
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td><td align=left>".$KTP."</td><td align=left>".$d[EMAIL]."</td><td align=left>".$d[EMAIL2]."</td><td align=left>".$data_cek_data[NOIJATRLSM]."</td>";
            
	    if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>"."<i class=\"fa fa-edit\"></i>"."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Mahasiswa Dengan NIM = {$d['ID']} ? Seluruh data mata kuliah yang diambil dan nilainya juga akan dihapus');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-trash\"></i>"."</td>\r\n\t\t\t\t\t\t\t\t";
            
            }else if($_SESSION['users']=='willy' || $_SESSION['users']=='perdana' || $_SESSION['users']=='dewi01'){
	    	echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan=mlihat3&aksi=formupdate&idupdate={$d['ID']}'>"."<i class=\"fa fa-edit\"></i>"."</td>";
	    }	
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        /*echo "</table>
        </diV>
        {$tpage} {$tpage2}
                </div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    ";*/
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
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
