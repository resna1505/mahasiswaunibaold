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
    $aksi = " ";
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "" )
{
    if ( $pilihan == "krs" )
    {
        $judulmenu = "Cetak KRS";
    }
    else if ( $pilihan == "ujian" )
    {
        $judulmenu = "Cetak Kartu Ujian";
    }
    #printjudulmenu( "{$judulmenu}" );
    #printmesg( $errmesg );
    echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg($judulmenu);
		echo "			</div>";
		echo "			<div class=\"m-portlet\">				
							<!--begin::Form-->";
    echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtahunajaransemester(0)."
											</label>
										</div>";
    if ( $pilihan == "ujian" )
    {
        echo "  					<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenis</label>    
										<label class=\"col-form-label\"> 
											<div class=\"m-radio-list\">
												<label class=\"m-radio\">
													<input type=radio name=jenis value='UTS' checked> UTS
													<span></span>
												</label>
												<label class=\"m-radio\">
													<input type=radio name=jenis value='UAS'> UAS
													<span></span>
												</label>
											</div>
										</label>
									</div>";
    }
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\" " ).
											"<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.id.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select></label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >daftar mahasiswa</a>-->
												<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
													<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
												</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusmahasiswa as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>";
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
										<label class=\"col-form-label\">
											<select name='jeniskelas' >\r\n        <option value=''>Semua</option>\r\n      ";
												foreach ( $arraykelasstei as $k => $v )
												{
													$selected = "";
													if ( $k == $d[JENISKELAS] )
													{
														$selected = "selected";
													}
													echo "<option value='{$k}' {$selected}>{$v}</option>";
												}
        echo "								</select>
										</label>
									</div>";
    }
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kop Surat</label>\r\n    
										<label class=\"col-form-label\">
											<div class=\"m-checkbox-list\">
												<label class=\"m-checkbox\">
													<input type=checkbox class=form-control m-input name=kopsurat value='1' checked>Cetak<span></span>
												</label>
											</div>
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
		<script>form.id.focus();</script>";
}
?>
