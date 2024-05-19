<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( isset( $_SESSION['users_mobile'] ) )
{
    $users = $_SESSION['users_mobile'];
    $jenisusers = 2;
}
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan1.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Laporan Keuangan: Mahasiswa yg Sudah Membayar" );
     echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Laporan Keuangan Mahasiswa yang Sudah Membayar");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">	";
    if ( $jenisusers == 0 )
    {
        echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input style=\"width:auto;display:inline-block;\" id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."
											<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >daftar mahasiswa</a>
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
		echo "								<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>semua</option>\r\n\t\t\t\t\t\t ";
												$cek = "";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													$cek = "";
													++$i;
												}
        echo "								</select>
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
        echo "								</select>
										</label>
									</div>";
    }
    else if ( $jenisusers == 3 || $jenisusers == 2 || isset( $_SESSION['users_mobile'] ) )
    {
        echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\"><b>{$users}  </b> </label>
									</div>";
    }
    if ( !isset( $_SESSION['users_mobile'] ) )
    {
        echo "						<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tanggal Pembayaran</label>\r\n    
											<div class=\"col-lg-8\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=istglbayar value=1>
															".createinputtanggal( "tglbayar", $tglbayar, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."s.d".createinputtanggal( "tglbayar2", $tglbayar2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
													<span></span>
													</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tanggal Entri Data</label>\r\n    
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
											<label class=\"col-lg-2 col-form-label\">Cara Pembayaran</label>\r\n    
											<label class=\"col-form-label\">
												<select name=carabayar class=form-control m-input><option value=''>Semua</option>\r\n            ";
													foreach ( $arraycarabayar as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>";
    }
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idkomponen><option value=''>Semua</option>";
													foreach ( $arraykomponenpembayaran as $k => $v )
													{
														echo "<option value={$k}>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
											<label class=\"col-form-label\">
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
    echo "										</select> (Khusus pilihan Per Tahun Akademik\tdan Semester )
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Semester :</label>\r\n    
											<label class=\"col-form-label\">
												<select name=tahunajaran2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
													$ii = $tahunawal;
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
    echo "										</select>
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
    echo "										</select> (Khusus pilihan Semester)
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Semester :</label>\r\n    
											<label class=\"col-form-label\">
												<select name=tahunajaran2c class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
													$ii = $tahunawal;
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
    echo "										</select>
												<select name=semesterbayarc class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
													foreach ( $arraysemester as $k => $v )
													{
														$cek = "";
														if ( $k == $d2[SEMESTER] )
														{
															$cek = "selected";
														}
														echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
													}
    echo "										</select> (Khusus pilihan Cuti)
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Bulan/Tahun</label>\r\n    
											<label class=\"col-form-label\">
												<select name=semesterbayar2 class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
													foreach ( $arraybulan as $k => $v )
													{
														$cek = "";
														if ( $k == $d2[SEMESTER] )
														{
															$cek = "selected";
														}
														echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
													}
    echo "										</select>
												<select name=tahunajaran2 class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>";
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
    echo "										</select> (Khusus pilihan Per Bulan )
											</label>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Status Pembayaran</label>
											<div class=\"col-lg-6\">
												<div class=\"m-radio-list\">
													<label class=\"m-radio\">
														<input type=radio name=jenisbayar value=1 checked> Lunas
														<span></span>
													</label>
													<label class=\"m-radio\">
														<input type=radio name=jenisbayar value=0 > Belum Lunas
														<span></span>
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
