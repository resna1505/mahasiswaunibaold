<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "tampilkan" )
{
    include( "prosesrekapipk.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Laporan Indeks Prestasi Kumulatif (IPK)" );
    #printmesg( $errmesg );
    echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg( $errmesg );
											printmesg("Laporan Indeks Prestasi Kumulatif (IPK)");
											
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
	#echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    echo "								<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='tampilkan'>
										<div class=\"m-portlet__body\">
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".createinputtahunajaransemester( 0 )."</label>
											</div>
											<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";    
														foreach ( $arrayprodidep as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
    echo "											</select>
												</label>
											</div>";
    if ( $jenisusers == 0 )
    {
        /*echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<select class=form-control m-input name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
														foreach ( $arraydosendep as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
        echo "										</select>
												</label>
											</div>";*/
		echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "iddosen", "", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    echo "									<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
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
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
												<div class=\"col-lg-6\">
													".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa atau Alumni...\"" )."
													<!--<a href=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ mahasiswa ]</a>
													<a href=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ alumni ]</a>-->
													<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
														<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
													</div>
												</div>
											</div>"."
											<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
												</label>
											</div>
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
														foreach ( $arraystatusmahasiswa as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
    echo "											</select>
												</label>
											</div>
											<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
												</label>
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
													<input type=submit value='Tampilkan' class=\"btn btn-brand\"></div>
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
