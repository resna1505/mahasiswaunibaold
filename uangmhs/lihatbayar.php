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
    include( "proseslihatbayar.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cari Data Pembayaran Keuangan Mahasiswa" );
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Cari Data Pembayaran Keuangan Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
									<input type=hidden name=pilihan value='{$pilihan}'>
									<div class=\"m-portlet__body\">";
    if ( $jenisusers == 0 )
    {
        echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
											<div class=\"col-lg-6\">
												".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
												<!--<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>-->
												<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
													<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
											<label class=\"col-form-label\">";
												$waktu = getdate( );
			echo "								<select name=angkatan class=form-control m-input> <option value=''>semua</option>";
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
											<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idprodi><option value=''>semua</option>\r\n\t\t\t\t\t\t ";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</label>
										</div>";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
											<label class=\"col-form-label\"><b>{$users}</b></label>
										</div>";
    }
    echo "								
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tanggal</label>\r\n    
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
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=idkomponen><!--<option value=''>Semua</option>-->";
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
											<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
											<label class=\"col-form-label\">
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
    echo "										</select> (Khusus pilihan Semester )
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
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
                   ";
}
?>
