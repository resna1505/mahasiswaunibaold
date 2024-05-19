<?php
periksaroot();
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester Ajaran", $tahun, $semester, false );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Nilai SP", $sp );
$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
$vld[] = cekvaliditastanggal( "Tanggal", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    include( "fungsinilai.php" );
    #include( "../libchart/libchart.php" );
    $href = "dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&sp={$sp}&kopsurat={$kopsurat}&diagram={$diagram}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Jurusan/Program Studi</td>\r\n      <td>".$arrayprodidep[$idprodi]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Dosen Wali</td>\r\n      <td>".$arraydosen[$iddosen]."</td>\r\n    </tr>\r\n    ";
    }
    if ( ismahasiswa( ) || iswali( ) )
    {
        $idmhs = $users;
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Angkatan</td>\r\n      <td>".$angkatan."</td>\r\n    </tr>\r\n    ";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>NIM</td>\r\n      <td>".$id."</td>\r\n    </tr>\r\n    ";
    }
    if ( $idmhs != "" )
    {
        $qfield .= " AND mahasiswa.ID = '{$idmhs}'";
        $qjudul .= " NIM = '{$idmhs}' <br>";
        $qinput .= " <input type=hidden name=idmhs value='{$idmhs}'>";
        $href .= "idmhs={$idmhs}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Nama Mhs</td>\r\n      <td>".$nama."</td>\r\n    </tr>\r\n    ";
    }
    if ( $status != "" )
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Status Mahasiswa</td>\r\n      <td>".$arraystatusmahasiswa["{$status}"]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
        #$qtabel .= "\r\n    <tr>\r\n      <td>Jenis Kelas</td>\r\n      <td>".$arraykelasstei["{$jeniskelas}"]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";
    $href2 = "{$href}";
    $href = "index.php?{$href}";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  ,trakm\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  \r\n  AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  ,trakm\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
    $q = "SELECT mahasiswa.*,prodi.SKSMIN ,COUNT(pengambilanmksp.IDMAHASISWA) AS JMLKRS , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  ,pengambilanmksp\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  pengambilanmksp.TAHUN='{$tahun}' \r\n  AND  pengambilanmksp.SEMESTER='{$semester}' \r\n  AND  pengambilanmksp.IDMAHASISWA=mahasiswa.ID\r\n  AND\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\t\r\n\tGROUP BY mahasiswa.ID\r\n\tHAVING JMLKRS > 0\r\n\t\r\n\tORDER BY {$sort} {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    //echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Kartu Hasil Studi (KHS)" );
            /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Kartu Hasil Studi (KHS) </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>

                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <span class=\"caption-subject bold uppercase\"> Filter/Setting </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
			 echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										printmesg( $qjudul );
										printmesg( $errmesg );
			echo "						<div class='portlet-title'>";
											printmesg("Filter / Setting");
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" >
											<div class=\"m-portlet__body\">	";
            echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Nilai MK yg diambil</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
														if ( $nilaidiambil == 0 )
														{
															echo "Nilai Terbaik";
														}
														else
														{
															echo "Nilai Terakhir";
														}
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
														if ( $nilaikosong == 0 )
														{
															echo "Tidak dihitung";
														}
														else
														{
															echo "Dihitung";
														}
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nilai SP</label>
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $sp == 1 )
            {
                echo "Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)";
            }
            else
            {
                echo "Tidak diambil langsung.";
            }
			echo "									</label>
												</div>";
            /*echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t<tr>\r\n\t\t<!--<td>Cetak Diagram\r\n\t\t</td>-->\r\n\t\t<td>";
            if ( $diagram == 0 )
            {
                echo "Tidak ";
            }
            else
            {
                echo "Ya";
            }
            echo "\r\n\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jenis\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";*/
			echo "								<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $jenistampilan == 99 )
            {
                echo "\r\n       \t\tKHS Universitas  \r\n        ";
            }
            else
            {
                echo "\r\n       \t\tStandar\r\n        ";
            }
            echo "</label>
						</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$tgllap['tgl']}-{$tgllap['bln']}-{$tgllap['thn']}</label>
					</div>";
            if ( $jenisusers != 2 && $jenisusers != 3 )
            {
                echo "<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$maxdata}\r\n \t\t</label>
						</div>";
                if ( $jenisusers == 0 )
                {
                    echo "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Kop Surat</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
                    if ( $kopsurat == 1 )
                    {
                        echo "Cetak";
                    }
                    else
                    {
                        echo "Tidak dicetak.";
                    }
                    #echo "\r\n\t\t</td>\r\n\t</tr>";
					echo "\r\n\t\t</label>\r\n\t</div>";
                }
                #echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td  >\r\n\t\t\t\t\tCatatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t ".nl2br( $catatan )."\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \r\n   \r\n\r\n    </table>\r\n    <hr>\r\n    ";
				echo "</div>	<hr>";
			}
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
            #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkhs.php' method=post>\r\n \t\t\t\t&nbsp;&nbsp;&nbsp;<input type=submit name=aksi class=\"btn blue\" value='Cetak'>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n \t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "catatan", "{$catatan}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n\t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata align=center>\r\n        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Cetak KHS</td>\r\n      </tr>\r\n    ";
        echo "<form method='POST' action='cetakkhs2.php'>.
		".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."
		".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."
		".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."
		".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."
		".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."
		".createinputhidden( "diagram", "{$diagram}", "" )."
		".createinputhidden( "catatan", "{$catatan}", "" )."
		".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."
		".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."
		".createinputhidden( "sp", "{$sp}", "" )."
		".createinputhidden( "kopsurat", "{$kopsurat}", "" )."{$qinput}{$input}";
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata align=center>\r\n        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td></td>\r\n      </tr>\r\n 
							</thead>
							<tbody>";	
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            if($jenisusers==2){
				
					echo "\r\n        <tr {$kelas}>\r\n          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td align=center><a href='cetakkhs.php?idmhs={$d['ID']}&pdf=1&".$href2."'>Download</a><a target=_blank href='cetakkhs.php?idmhs={$d['ID']}&".$href2."'>Cetak</a></td>\r\n        </tr>\r\n        ";
			
			}else{	
			
				echo "\r\n        <tr {$kelas}>\r\n          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td align=center><a target=_blank href='cetakkhs.php?idmhs={$d['ID']}&".$href2."'>Cetak</a></td>\r\n        </tr>\r\n        ";
			
			}
		}
        #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
		echo "				</tbody>
						</table>
						<!--<input type='submit' name='printbtn' value='Cetak' class=\"btn btn-brand\"><br>
						<br>-->
					</div>
				</div>				
			</div>			
		</form>
		</div>
		</div>
		</div>
		</div>";
    }
    else
    {
        $errmesg = "Data KHS mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
