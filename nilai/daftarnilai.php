<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
#echo $aksi;
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi == "tampilkan" )
{
	#echo "mm";exit();
    if ( $diagram == 1 )
    {
        delgambartemp( );
        $seed = mt_srand( make_seed( ) );
        $folder = "gambardiagram/";
        $ombangambing = 1;
    }
    include( "prosesdaftarnilai.php" );
}
if ( $aksi == "" )
{
	#echo $jenisusers."ll";
    #printjudulmenu( "DAFTAR NILAI UJIAN" );
    #printmesg( $errmesg );
    #echo "<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  >\r\n    ";
     echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										printmesg( $qjudul );
										printmesg( $errmesg );
			echo "						<div class='portlet-title'>";
											printmesg("Filter / Setting");
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->
										<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
											<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>
											<div class=\"m-portlet__body\">	";
											
	if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
    }
    if ( $jenisusers == 0 )
    {
        echo "									<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														<select class=form-control m-input name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															foreach ( $arraydosendep as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";
    }
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
														$waktu = getdate( );
        echo "											<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															$arrayangkatan = getarrayangkatan( );
															foreach ( $arrayangkatan as $k => $v )
															{
																echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
															}
        echo "											</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."
														<a href=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ mahasiswa ]</a>
														<a href=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ alumni ]</a>
														<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
															<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
														</div>
													</label>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
													</label>
												</div> 
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															foreach ( $arraystatusmahasiswa as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";
    }
    if ( ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 ) && $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
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
        echo "											</select>
													</label>
												</div>";
    }
    echo "										<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														<select class=form-control m-input name=nilaidiambil>";
															if ( $UNIVERSITAS != "STEI INDONESIA" )
															{
																echo "\r\n\t\t\t\t\t\t<option value='1'>Nilai Terakhir</option>";
															}
    echo "													<option value='0'>Nilai Terbaik</option>";
    echo "												</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														<select class=form-control m-input name=nilaikosong>";
    if ( $UNIVERSITAS != "STEI INDONESIA" )
    {
        echo "												<option value='1'>Dihitung</option>
															<option value='0' selected>Tidak dihitung</option>";
    }
    else
    {
        echo "												<option value='0'>Tidak dihitung</option>";
    }
    echo "												</select>
														<input type=hidden name=penempatansemester value=1>
													</label>
												</div>
												<!-- \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tPenempatan Semester Mata Kuliah\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=penempatansemester>\r\n\t\t\t\t\t\t<option value='1'>Kurikulum</option>\r\n\t\t\t\t\t\t<option value='0'>Master Mata Kuliah</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t--> 
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Nilai SP</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
														if ( $UNIVERSITAS == "STEI INDONESIA" )
														{
															$ceksp = "checked";
														}
    echo "												<input type=checkbox name=sp value=1 {$ceksp}>Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)
													</label>
												</div>";
    echo "										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2>Sebaiknya nilainya diperkecil karena pemrosesan transkrip akan memakan waktu relatif lama
													</label>
												</div>";
	if($jenisusers!=2){
    echo "										<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Kop Surat</label>
													<div class=\"col-lg-6\">
														<div class=\"m-radio-list\">
															<label class=\"m-radio\">
																<input type=radio class=form-control m-input name=kopsurat value='' checked>Tanpa Kop
																<span></span>
															</label>
															<label class=\"m-radio\">
																<input type=radio class=form-control m-input name=kopsurat value='1' >Cetak Kop Surat Umum
																<span></span>
															</label>
															<label class=\"m-radio\">
																<input type=radio class=form-control m-input name=kopsurat value='2' >Cetak Kop Surat Fakultas
																<span></span>
															</label>
														</div>
													</div>
												</div>";
	}
    if ( $jenisusers != 2 && $jenisusers != 3 && $jenisusers == 0 && $UNIVERSITAS == "STIKES_UBUDIYAH" )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nilai Ujian  Komprehensif</label>\r\n    
													<div class=\"col-lg-6\">
														<div class=\"m-checkbox-list\">
															<label class=\"m-checkbox\">
																<input type=checkbox class=form-control m-input name=kompre value='1' >Tampilkan
																<span></span>
															</label>
														</div>
													</div>
												</div>";
    }
    echo "										<div class=\"form-group m-form__group row\">
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
					</div>";
}
?>
