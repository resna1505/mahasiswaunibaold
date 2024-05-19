<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestransferawal.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Transfer Nilai SP ke Nilai Semester Normal" );
    /*printmesg( $errmesg );
    echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Transfer Nilai SP ke Nilai Semester Normal </span>
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
								<!-- BEGIN SAMPLE FORM PORTLET-->";
	echo "						<div class='portlet-title'>";
									printmesg("Transfer Nilai SP ke Nilai Semester Normal");										
	echo "						</div>	
								<div class=\"m-portlet\">
								<!--begin::Form-->";
    echo "						<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<div class=\"m-portlet__body\"> 
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
											<label class=\"col-form-label\">";
													$waktu = getdate( );
	echo "										<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t ";
													$i = 1900;
													while ( $i <= $waktu[year] + 5 )
													{
														$selected = "";
														if ( $waktu[year] + 1 == $i )
														{
															$selected = "selected";
														}
														echo "\r\n\t\t\t\t\t\t\t<option {$selected} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
														++$i;
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
											<label class=\"col-form-label\">
												<select name=semester class=form-control m-input>";
													foreach ( $arraysemester as $k => $v )
													{
														echo "<option value='{$k}' {$cek}>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">
												<b>FILTER</b>
											</label>\r\n    
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idprodi>
													<option value=''>Semua</option>";
														foreach ( $arrayprodidep as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
											<label class=\"col-form-label\">";
												$waktu = getdate( );
	echo "										<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													$i = 1900;
													while ( $i <= $waktu[year] + 5 )
													{
														echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
														++$i;
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."
												<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >daftar mahasiswa</a>
												<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
													<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
												</div>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=status><option value=''>Semua</option>";
													foreach ( $arraystatusmahasiswa as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit value='Tampilkan' class=\"btn btn-brand\">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>form.id.focus();</script>";
}
?>
