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
        include( "prosesrekapnilai.php" );
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
											printmesg("Laporan Nilai Mata Kuliah");
											printmesg( $errmesg );
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
    if ( $idprodi == "" )
    {
        $idprodi = $idprodi2;
    }
    #echo "\r\n\t\t<table class=form>";
	echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
					<div class=\"m-portlet__body\">	";
    if ( $jenisusers != 2 )
    {
        echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
							<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
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
    if ( $jenisusers != 2 )
    {
        echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
        if ( $angkatan == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $angkatan;
        }
        echo "				</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$id}</label>
						</div>"."
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$nama}</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
								if ( $status == "" )
								{
									echo "Semua";
								}
								else
								{
									echo $arraystatusmahasiswa[status];
								}
        echo "				</label>
						</div>";
    }
    echo "				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
				<form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
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
					".createinputhidden( "kopsurat", "{$kopsurat}", "" )."
					<!--<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi Mata Kuliah</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".createinputselect( "idprodi", $arrayprodidep, "{$idprodi}", "", "class=form-control m-input" )."
								<input type=submit name=aksi2 value='ganti' class=\"btn btn-brand\">
							</label>
					</div>-->
				";
    if ( $jenisusers == 2 )
    {
        echo "<input type=hidden name=id value='{$users}'>";
    }
    $q = "SELECT * \r\n\t\tFROM makul\r\n\t\tWHERE\r\n\t\t\tIDPRODI='{$idprodi}'\r\n\t\t\tORDER BY SEMESTER,ID\r\n\t\t";
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
		echo "					<tr align=center class=juduldata><td colspan=6 align=right><input type=submit name=aksi2 class=\"btn btn-brand\" value='Tampilkan'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n \t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t</tr>
							</thead>
							<tbody>";
        
		$i = 1;
        $semlama = "";
        while ( $dp = sqlfetcharray( $hp ) )
        {
            if ( $semlama != $dp[SEMESTER] )
            {
                $semlama = $dp[SEMESTER];
                echo "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=6>Semester {$dp['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr align=center {$kelas}>\r\n\t\t\t\t\t\t<td>{$i}\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['ID']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMA']}</td>\r\n\t\t\t\t\t\t<td>{$dp['SKS']}</td>\r\n \t\t\t\t\t\t<td>".createinputcek( "datamk[{$dp['ID']}]", "1", "", "", "class=masukan" )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
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
											printmesg("Laporan IPK");
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
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=idprodi2>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
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
											<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "iddosen", "", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    if ( $jenisusers != 2 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
													<label class=\"col-form-label\">";
														$waktu = getdate( );
	echo "											<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
														$i = 1900;
														while ( $i <= $waktu[year] + 5 )
														{
															echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
															++$i;
														}
        echo "											</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
													<div class=\"col-lg-6\">
														".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi2.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa atau Alumni...\"" )."
														<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >[ mahasiswa ]</a>
														<a href=\"javascript:daftaralumni('form,wewenang,id',document.form.id.value)\" >[ alumni ]</a>-->
														<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
															<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
														</div>
													</div>
												</div>"."
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nama</label>   
													<label class=\"col-form-label\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Status</label>   
													<label class=\"col-form-label\">
														<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															foreach ( $arraystatusmahasiswa as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";
    }
		echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>   
													<label class=\"col-form-label\">
														<select class=form-control m-input name=nilaidiambil>
															<option value='1'>Nilai Terakhir</option>
															<option value='0'>Nilai Terbaik</option>
														</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>   
													<label class=\"col-form-label\">".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</label>
												</div> 
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Kop Surat</label>   
													<div class=\"col-lg-6\">
														<div class=\"m-checkbox-list\">
															<label class=\"m-checkbox\">
																<input type=checkbox class=form-control m-input name=kopsurat value='1' checked>Cetak
																<span></span>
															</label>
														</div>	
													</div>
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
