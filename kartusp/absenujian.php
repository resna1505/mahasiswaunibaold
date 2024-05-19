<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "tampilkanawal" )
{
	#echo "tampilkanawal";exit();
    $aksi = " ";
    include( "prosestampilabsenawal.php" );
}
if ( $aksi == "formtambah" )
{
	#echo "tampileditabsen";exit();
    $aksi = " ";
    include( "prosestampileditabsen.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cetak Absensi" );
    /*printmesg( $errmesg );
    echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Cetak Absensi </span>
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
								printmesg( $errmesg );
	echo "						<div class='portlet-title'>";
								printmesg("Cetak Absensi");
	echo "						</div>";
	echo "						<div class=\"m-portlet\">				
									<!--begin::Form-->";
    echo "							<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='tampilkanawal'>
										<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
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
													<label class=\"m-radio\">
														<input type=radio name=jenis value='Kuliah'> Kuliah
														<span></span>
													</label>
												</div>
											</label>
										</div>";
	echo "								<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtahunajaransemester( )."</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<!-- <option value=''>Semua</option> -->";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>";
	echo "									</label>
										</div>";
    if ( $jenisusers == 0 )
    {
        echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
											<div class=\"col-lg-6\">
												".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    #echo "<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">\r\n               <div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n";
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
											<div class=\"col-lg-6\">
												".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
												<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\">daftar mata kuliah</a>-->
													<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
														<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
													</div>
											</div>
										</div>";
    
	if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
											<label class=\"col-form-label\">
												<select name='jeniskelas' ><option value=''>Semua</option>\r\n      ";
													foreach ( $arraykelasstei as $k => $v )
													{
														$selected = "";
														if ( $k == $d[JENISKELAS] )
														{
															$selected = "selected";
														}
														echo "<option value='{$k}' {$selected}>{$v}</option>";
													}
        echo "									</select>
											</label>
										</div>\r\n     ";
    }
    $arraylabelkelas[''] = "Semua";
    echo " 								<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
											<label class=\"col-form-label\">
												".createinputselect( "kelas", $arraylabelkelas, $kelas, "class=form-control m-input", "" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Khusus Kuliah: Jumlah Pertemuan</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "datakuliah", 16, " class=form-control m-input  size=2" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Kop Surat</label>\r\n    
											<label class=\"col-form-label\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox class=form-control m-input name=kopsurat value='1' checked>Cetak
													<span></span>
													</label>
												</div>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
			";
	/*echo "								<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $jenisusers == 0 )
    {
        echo "\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIDN Dosen</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.iddosen.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n              <div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">\r\n               <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\">\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    }
    echo "<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=masukan  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\"" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">\r\n               <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr> ";
    $arraylabelkelas[''] = "Semua";
    echo "\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n ".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )."\r\n      \r\n </td>\r\n\t\t</tr> \r\n";
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Jenis Kelas Default </td>\r\n\t\t\t<td>\r\n        <select name='jeniskelas' >\r\n        <option value=''>Semua</option>\r\n      ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n      </select>\r\n      \r\n      </td>\r\n\t\t</tr>\r\n     ";
    }
    echo " \t\t <tr class=judulform>\r\n\t\t\t<td>Khusus Kuliah: Jumlah Pertemuan</td>\r\n\t\t\t<td>".createinputtext( "datakuliah", 16, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\t<tr>\r\n\t\t<td class=judulform>Kop Surat\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=checkbox class=masukan name=kopsurat value='1' checked>Cetak\r\n\t\t</td>\r\n\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=\"btn blue\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form></div></div></div>
                    </div>
                        </div>
                            </div>\r\n \t";*/
}
?>
