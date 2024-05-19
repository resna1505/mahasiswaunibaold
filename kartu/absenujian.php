<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#echo $aksi;exit();
if ( $aksi == "tampilkanawal" )
{
	#echo "kkk";
    $aksi = " ";
    include( "prosestampilabsenawal.php" );
}
if ( $aksi == "formtambah" )
{
    $aksi = " ";
    if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
    {
        include( "prosesabsenuniversitasborobudur.php" );
    }
    else
    {
		echo "lll";exit();
        include( "prosestampileditabsen.php" );
    }
}
if ( $aksi == "beritaacara" )
{
    $aksi = " ";
    include( "prosestampilberitaacara.php" );
}
if ( $aksi == "" )
{
    
    printmesg( $errmesg );
    /*echo "<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">Cetak Absensi</span>
                            </div>
                           
                        </div>
                        <div class=\"portlet-body form\"><form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>\r\n      ".IKONLAPORAN48."<div class=\"portlet-body\">
						<div class=\"table-scrollable\"><table class=\"table table-striped table-bordered table-hover\">     <tr class=judulform>\r\n\t\t\t<td>Jenis</td>\r\n\t\t\t<td>\r\n\t\t\t <input type=radio name=jenis value='UTS' checked> UTS\r\n\t\t\t <input type=radio name=jenis value='UAS'> UAS\r\n\t\t\t <input type=radio name=jenis value='Kuliah'> Kuliah\r\n \t\t\t</td>\r\n\t\t</tr><tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>     \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<!-- <option value=''>Semua</option> -->";
    */
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
									<!--begin::Form-->
									<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>
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
										</div>
										<div class=\"form-group m-form__group row\">
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
}
?>
