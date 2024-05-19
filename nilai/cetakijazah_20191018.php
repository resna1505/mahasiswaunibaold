<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    $konversisemua = 1;
}
if ( $aksi == "tampilkan" && $diagram == 1 )
{
    delgambartemp( );
    $seed = mt_srand( make_seed( ) );
    $folder = "gambardiagram/";
    $ombangambing = 1;
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cetak Ijazah" );
    #printmesg( $errmesg );
    #echo "\r\n\t\t<form name=form action=cetakijazah2.php method=post target=_blank>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  >";
    echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Cetak Ijazah");
											printmesg( $errmesg );
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
			echo "						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=cetakijazah2.php method=post target=_blank>
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='tampilkan'>
										<div class=\"m-portlet__body\">";
    							
	if ( $jenisusers != 2 )
    {
        echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
														foreach ( $arrayprodidep as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
        echo "										</select>
												</label>
											</div>";
    }
    if ( $jenisusers != 2 )
    {
        echo "								<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													".createinputtext( "angkatan", $angkatan, " class=form-control m-input  size=4" )."
												</label>
											</div>
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
												<div class=\"col-lg-6\">
													".createinputtext( "id", $id, " class=form-control m-input  size=20  id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa atau Alumni...\"" )."
													<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >[mahasiswa]</a>
													<a href=\"javascript:daftaralumni('form,wewenang,id',document.form.id.value)\" >[alumni]</a>-->
													<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
														<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
													</div>
												</div>
											</div>				
											<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
														foreach ( $arraystatusmahasiswa as $k => $v )
														{
															echo "<option value='{$k}'>{$v}</option>";
														}
        echo "										</select>
												</label>
											</div>";
    }
    if ( $UNIVERSITAS != "UNIVERSITAS 17 AGUSTUS 1945" )
    {
        echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input style=\"width:auto;display:inline-block;\""  )."
												</label>
											</div>";
		echo "								<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">SK Pendirian</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													".createinputtext( "skpendirian", $skpendirian, " class=form-control m-input  size=50" )."
												</label>
											</div>";
	}
    echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Max data</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2 >
												</label>
											</div>";
    if ( $UNIVERSITAS == "STIKES_UBUDIYAH" || $UNIVERSITAS == "STMIK_UBUDIYAH" )
    {
        echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Peringkat Akreditasi</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<input type=checkbox class=form-control m-input name=ifperingkat value='1'  > Tampilkan
												</label>
											</div>";
    }
    echo "									<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
												<div class=\"col-lg-6\">
													<input type=submit value='Tampilkan' class=\"btn btn-brand\">
													<!--<input type=checkbox name=pdf value=1> PDF
													<a class='settingpdf' href='../lib/settingpdf.php' >Setting</a>
													<script>
														jQuery(document).ready(
															function () {jQuery('a.settingpdf').colorbox();});
													</script>-->
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
