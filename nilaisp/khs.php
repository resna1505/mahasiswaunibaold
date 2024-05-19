<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
error_reporting(1);
#echo $jenistampilan;
$seed = mt_srand( make_seed( ) );
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
    include( "proseslihatkhs.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Kartu Hasil Studi Semester Pendek" );
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
                                <span class=\"caption-subject bold uppercase\"> Kartu Hasil Studi Semester Pendek </span>
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
									printmesg( $errmesg );
									printmesg("Kartu Hasil Studi Semester Pendek");										
	echo "						</div>	
								<div class=\"m-portlet\">
								<!--begin::Form-->";
    echo "							<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='tampilkan'>
											<div class=\"m-portlet__body\">";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=idprodi><option value=''>Semua</option>";
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
													<label class=\"col-form-label\">
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
													<label class=\"col-form-label\">";
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
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
													<label class=\"col-form-label\">
														".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."
														<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >[ mahasiswa ]</a><a href=\"javascript:daftaralumni('form,wewenang,id',document.form.id.value)\" >[ alumni ]</a>
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
														<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
															foreach ( $arraystatusmahasiswa as $k => $v )
															{
																echo "<option value='{$k}'>{$v}</option>";
															}
        echo "											</select>
													</label>
												</div>";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        echo "									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
													<label class=\"col-form-label\">{$users}</label>
												</div> ";
    }
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "									<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
													<label class=\"col-form-label\">
														<select name='jeniskelas'><option value=''>Semua</option>";
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
    echo "										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
													<label class=\"col-form-label\">
														".createinputtahunajaransemester( 0 )."</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=nilaidiambil>
															<option value='1'>Nilai Terakhir</option>
															<option value='0' selected>Nilai Terbaik</option>
														</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Belum Ada</label>\r\n    
													<label class=\"col-form-label\">
														<select class=form-control m-input name=nilaikosong>
															<option value='1'>Dihitung</option>
															<option value='0'>Tidak dihitung</option>
														</select>
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>\r\n    
													<label class=\"col-form-label\">
														".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input  style=\"width:auto;display:inline-block;\"" )."
													</label>
												</div>";
											if ( $jenisusers != 2 && $jenisusers != 3 )
											{
	echo "										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>\r\n    
													<label class=\"col-form-label\">
														<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2>Sebaiknya nilainya diperkecil karena pemrosesan KHS akan memakan waktu relatif lama
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
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
												</div>	";
											}
    echo "									<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
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
