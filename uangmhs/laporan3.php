<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan3.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Laporan Keuangan: Rekapitulasi pembayaran" );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Rekapitulasi Pembayaran Umum");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\"  " )."
											<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$arrayangkatan = getarrayangkatan( );
												foreach ( $arrayangkatan as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
	echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Program Studi / Program Pendidikan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>semua</option>\r\n\t\t\t\t\t\t ";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Periode Pembayaran</label>\r\n    
										<div class=\"col-lg-8\">
											<div class=\"m-checkbox-list\">
												<label class=\"m-checkbox\">
													<input type=checkbox name=istglbayar value=1>
														".createinputtanggal( "tglbayar", $tglbayar, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )." s.d ".createinputtanggal( "tglbayar2", $tglbayar2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
													<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Periode Entri</label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=istglentri value=1>
															".createinputtanggal( "tglentri", $tglentri, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."s.d".createinputtanggal( "tglentri2", $tglentri2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
														<span></span>
													</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\"><b>Filter lain</b></label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik :</label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=istahunajaran value=1>
														<select name=tahunajaran class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
															$ii = 1900;
															while ( $ii <= $waktu[year] + 5 )
															{
																$cek = "";
																if ( $ii == $d2[TAHUNAJARAN] )
																{
																	$cek = "selected";
																}
																else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
																{
																	$cek = "selected";
																}
																echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
																++$ii;
															}
echo "													</select> (Khusus pilihan Komponen Per Tahun Akademik )
													</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Semester : </label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=issemester value=1>
														<select name=semesterbayar class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
															foreach ( $arraysemester as $k => $v )
															{
																$cek = "";
																if ( $k == $d2[SEMESTER] )
																{
																	$cek = "selected";
																}
																echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
															}
    echo "												</select>
														<select name=tahunajaran2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
															$ii = 1900;
															while ( $ii <= $waktu[year] + 5 )
															{
																$cek = "";
																if ( $ii == $d2[TAHUNAJARAN] )
																{
																	$cek = "selected";
																}
																else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
																{
																	$cek = "selected";
																}
																echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
																++$ii;
															}
    echo "												</select>(Khusus pilihan Komponen per Semester )
													</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Semester : </label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=iscuti value=1>
															<select name=semesterbayarc class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
																foreach ( $arraysemester as $k => $v )
																{
																	$cek = "";
																	if ( $k == $d2[SEMESTER] )
																	{
																		$cek = "selected";
																	}
																	echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
																}
    echo "													</select>
															<select name=tahunajaran2c class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
																$ii = 1900;
																while ( $ii <= $waktu[year] + 5 )
																{
																	$cek = "";
																	if ( $ii == $d2[TAHUNAJARAN] )
																	{
																		$cek = "selected";
																	}
																	else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
																	{
																		$cek = "selected";
																	}
																	echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
																	++$ii;
																}
    echo "													</select>(Khusus pilihan Komponen Cuti )
														</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Bulan/Tahun :</label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=isbulan value=1>
															<select name=semesterbayar2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
																foreach ( $arraybulan as $k => $v )
																{
																	$cek = "";
																	if ( $k == $d2[SEMESTER] )
																	{
																		$cek = "selected";
																	}
																	echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
																}
echo "														</select>
															<select name=tahunajaran3 class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
																$ii = 1900;
																while ( $ii <= $waktu[year] + 5 )
																{
																	$cek = "";
																	if ( $ii == $d2[TAHUNAJARAN] )
																	{
																		$cek = "selected";
																	}
																	else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
																	{
																		$cek = "selected";
																	}
																	echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
																	++$ii;
																}
echo "														</select> (Khusus pilihan Per Bulan )
														</label>
													</div>
												</div>
											</div>
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
												<div class=\"col-lg-6\">
													<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
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
