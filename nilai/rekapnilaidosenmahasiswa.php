<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "ganti" )
{
    $aksi = "lanjut";
}
else if ( $aksi2 == "Tampilkan" )
{
    if ( !is_array( $datamk ) )
    {
        $aksi = "lanjut";
        $errmesg = "Silakan pilih mata kuliah yang hendak dicetak nilainya";
    }
    else
    {
        include( "prosesrekapnilaidosenmahasiswa.php" );
    }
}
if ( $aksi == "lanjut" )
{
    #printjudulmenu( "Laporan Nilai Mata Kuliah " );
    #printmesg( $errmesg );
	 echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printtitle("Rekap Nilai Dosen Mahasiswa");
											printmesg( $errmesg );
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
    if ( $idprodi == "" )
    {
        $idprodi = $idprodi2;
		#$qfield .= " AND TAHUN = '{$tahun}'";
        
    }
    if ( $tahun != "" )
    {
        $qfield .= " AND TAHUN = '{$tahun}'";
        #$qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
        #$qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND dosenpengajar.iddosen = '{$iddosen}'";
        #$qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
        #$qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $semester != "" )
    {
        $qfield .= " AND dosenpengajar.SEMESTER = '{$semester}'";
        #$qjudul .= " Semester ".$arraysemester[$semester]." <br>";
        #$qinput .= " <input type=hidden name=semester value='{$semester}'>";
        $href .= "semester={$semester}&";
    }
    #echo "\r\n\t\t<table class=form>";
	echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
					<div class=\"m-portlet__body\">	";
    if ( $jenisusers != 2 )
    {
        echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
        if ( $idprodi2 == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $arrayprodidep[$idprodi2];
        }
        echo "				</label>
						</div>";
    }
    if ( $jenisusers == 0 )
    {
        echo "			<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Dosen Pengajar</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
        if ( $iddosen == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $arraydosendep[$iddosen];
        }
		echo "				</label>
						</div>";
    }
    
    echo "				<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
							<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
							
    if ( $nilaidiambil == 1 )
    {
        echo "Nilai Terakhir";
    }
    else
    {
        echo "Nilai Terbaik";
    }
    echo "					</label>
						</div>";
	echo "				<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
							echo "".($tahun-1)."/".$tahun." ".$arraysemester[$semester];
	echo "					</label>
						</div>";
    if ( $aksi == "" )
    {
        echo "			<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Lanjut' class=masukan>
							</div>
						</div>";
    }
    echo "			</div>
				</form>
			</div>
			<div class=\"m-portlet\">
				<!--begin::Form-->
				<!--<form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">-->
				    <form target=_blank action='cetakrekapnilaidosenmahasiswa.php'>	
					".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."
					".createinputhidden( "iddosen", "{$iddosen}", "" )."
					".createinputhidden( "id", "{$id}", "" )."".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."
					".createinputhidden( "id", "{$id}", "" )."
					".createinputhidden( "nama", "{$nama}", "" )."
					".createinputhidden( "aksi", "{$aksi}", "" )."
					".createinputhidden( "idprodi2", "{$idprodi2}", "" )."
					".createinputhidden( "angkatan", "{$angkatan}", "" )."
					".createinputhidden( "pilihan", "{$pilihan}", "" )."
					".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."
					".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."
					".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."
					".createinputhidden( "tahun", "{$tahun}", "" )."
					".createinputhidden( "semester", "{$semester}", "" )."
					".createinputhidden( "kopsurat", "{$kopsurat}", "" )."
					
				";
    if ( $jenisusers == 2 )
    {
        echo "<input type=hidden name=id value='{$users}'>";
    }
    #$q = "SELECT * FROM makul WHERE IDPRODI='{$idprodi}' ORDER BY SEMESTER,ID";
	$q = "SELECT dosenpengajar.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN FROM dosenpengajar,makul,dosen WHERE 1=1 ".
	"AND dosen.ID=dosenpengajar.IDDOSEN AND makul.ID=dosenpengajar.IDMAKUL AND dosenpengajar.IDPRODI='{$idprodi}' {$qfield} ORDER BY makul.NAMA ASC";
	#echo $q.'<br>';
    $hp = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $hp ) <= 0 )
    {
        printmesg( "Data Mata Kuliah Jurusan/Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
    }
    else
    {
        echo "	".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."
				".createinputhidden( "aksi", "updatemk", "" )."
				".createinputhidden( "pilihan", "{$pilihan}", "" )."
				".createinputhidden( "idprodi", "{$idprodi}", "" )."
				".createinputhidden( "idprodi2", "{$idprodi2}", "" )."
				".createinputhidden( "angkatan", "{$angkatan}", "" )."
				".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."
				".createinputhidden( "data[semester]", "{$data['semester']}", "" );
        #echo "\r\n\t\t\t\r\n\t\t\t\t<table class=data>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td colspan=6 align=right>\r\n\t\t\t\t\t<input type=submit name=aksi2 class=masukan value='Tampilkan'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n \t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>";
		echo "					<tr align=center class=juduldata><td colspan=7 align=left><input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Dosen Pengajar</td><td>Total Mahasiswa</td><td>Total Nilai Mahasiswa</td></tr>
							</thead>
							<tbody>";
        
		$i = 1;
        $semlama = "";
        while ( $dp = sqlfetcharray( $hp ) )
        {
            /*if ( $semlama != $dp[SEMESTER] )
            {
                $semlama = $dp[SEMESTER];
                echo "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=6>Semester {$dp['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }*/
			//cek total mahasiswa
			$sqltotalmhs = "SELECT COUNT(mahasiswa.ID) AS total_mhs
			FROM mahasiswa,pengambilanmk
			WHERE 
			mahasiswa.ID=pengambilanmk.IDMAHASISWA 
			AND pengambilanmk.IDMAKUL='{$dp['IDMAKUL']}'
			AND pengambilanmk.TAHUN='{$dp['TAHUN']}'
			AND pengambilanmk.SEMESTER='{$dp['SEMESTER']}'
			AND pengambilanmk.KELAS='{$dp['KELAS']}'";
			#echo $sqltotalmhs.'<br>';
			$qtotalmhs = doquery($koneksi,$sqltotalmhs);
			$datatotalmhs=sqlfetcharray($qtotalmhs);
			$totalmhs=$datatotalmhs['total_mhs'];
			
			//cek total nilai mahasiswa
			$sqltotalnilaimhs = "SELECT COUNT(pengambilanmk.SIMBOL) AS total_nilai_mhs
			FROM mahasiswa,pengambilanmk
			WHERE 
			mahasiswa.ID=pengambilanmk.IDMAHASISWA
			AND pengambilanmk.IDMAKUL='{$dp['IDMAKUL']}'
			AND pengambilanmk.TAHUN='{$dp['TAHUN']}'
			AND pengambilanmk.SEMESTER='{$dp['SEMESTER']}' 
			AND pengambilanmk.KELAS='{$dp['KELAS']}'
			AND SIMBOL!=''";
			#echo $sqltotalnilaimhs.'<br>';
			$qtotalnilaimhs = doquery($koneksi,$sqltotalnilaimhs);
			$datatotalnilaimhs=sqlfetcharray($qtotalnilaimhs);
			$totalnilaimhs=$datatotalnilaimhs['total_nilai_mhs'];
			#$totalnilaimhs=sqlnumrows($qtotalnilaimhs);
			if($totalmhs>$totalnilaimhs){
				
				$styleerror = "style='background-color:#ffaaaa'";
			
			}else{
				$styleerror = "";
			
			}
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr align=center {$kelas} {$styleerror}>\r\n\t\t\t\t\t\t<td>{$i}\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td><a class='{$cetak}' href='index.php?pilihan=detailrekapnilai&idmakulupdate={$dp['IDMAKUL']}&iddosenupdate={$dp['IDDOSEN']}&tahunupdate={$dp['TAHUN']}&semesterupdate={$dp['SEMESTER']}&kelasupdate={$dp['KELAS']}&idprodiupdate={$dp['IDPRODI']}'>{$dp['IDMAKUL']}</a></td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMAMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$dp['NAMADOSEN']}</td><td>{$totalmhs}</td><td>{$totalnilaimhs}</td></tr>\r\n\t\t\t\t";
            ++$i;
        }
        echo "				</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>";
    }
}
if ( $aksi == "" )
{
    #printjudulmenu( "Laporan Nilai Mata Kuliah " );
    #printmesg( $errmesg );
    echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Rekap Nilai Dosen Mahasiswa");
											printmesg( $errmesg );
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
	echo "								<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
											<input type=hidden name=pilihan value='{$pilihan}'>
											<input type=hidden name=aksi value='lanjut'>
											<div class=\"m-portlet__body\">	";
    if ( $jenisusers != 2 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
													<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=idprodi2>";
															foreach ( $arrayprodidep as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";
    }
    if ( $jenisusers == 0 )
    {
        /*echo "									<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															foreach ( $arraydosendep as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";*/
		echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Dosen Pengajar</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "iddosen", "", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    
		echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
													<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>   
													<label class=\"col-form-label\">
														<select class=form-control m-input name=nilaidiambil>
															<option value='1'>Nilai Terakhir</option>
															<option value='0'>Nilai Terbaik</option>
														</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
													<div class=\"col-lg-6\">".createinputtahunajaransemester( )." </div>
												</div>		
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
													<div class=\"col-lg-6\">
														<input type=submit value='Lanjut' class=\"btn btn-brand\">
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>";
}
?>
