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
if ( $aksi == "Tampilkan" )
{
	#echo "aaa";exit();
    include( "prosesnilaiipsipk.php" );
}
if ( $aksi == "" )
{
	#echo "jjj";
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Proses Nilai IPS/IPK Mahasiswa untuk Semester Tertentu (Disimpan di TRAKM)" );
    
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Proses Nilai IPS/IPK Mahasiswa untuk Semester Tertentu (Disimpan di TRAKM) </span>
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
		echo "					<div class='portlet-title'>";
									printmesg( $errmesg );
									printmesg("Proses Nilai IPS/IPK Mahasiswa untuk Semester Tertentu (Disimpan di TRAKM)");										
		echo "					</div>	
							<div class=\"m-portlet\">
								<!--begin::Form-->";
		echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<input type=hidden name=sessid value='{$token}'>
									<div class=\"m-portlet__body\">";
    if ( $jenisusers != 2 )
    {
        echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</div>
										</div>";
    }
    if ( $jenisusers == 0 )
    {
        /*echo "							<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													foreach ( $arraydosendep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</div>
										</div>";*/
		echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "iddosen", "", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    if ( $jenisusers != 2 )
    {
        echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
											<div class=\"col-lg-6\">";
        $waktu = getdate( );
        echo "									<select name=angkatan class=form-control m-input><option value=''>Semua</option>";
													$i = 1900;
													while ( $i <= $waktu[year] + 5 )
													{
														echo "<option value='{$i}' {$cek}>{$i}</option>";
														++$i;
													}
        echo "									</select>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa atau Alumni...\"" )."
												<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\">[ mahasiswa ]</a>
												<a href=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ alumni ]</a>-->
												<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
													<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
												</div>
											</div>
										</div>"."
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
											<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													foreach ( $arraystatusmahasiswa as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</div>
										</div>";
    }
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
											<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )." </div>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=nilaidiambil>
													<option value='1'>Nilai Terakhir</option>
													<option value='0' selected>Nilai Terbaik</option>
												</select>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=nilaikosong>
													<option value='1'>Dihitung</option>
													<option value='0'>Tidak dihitung</option>
												</select>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Nilai SP</label>  
											<div class=\"col-lg-6\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox name=sp value=1>Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)
														<span></span>
													</label>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Status Simpan</label>\r\n    
											<div class=\"col-lg-6\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox class=form-control m-input name=simpanipk value='1'  >Simpan IPS/IPK langsung (jangan dipilih jika Anda hanya ingin membandingkan IPS/IPK di TRAKM dgn IPS/IPK dari KRS)
														<span></span>
													</label>
												</div>
											</div>
										</div>";
    if ( $jenisusers != 2 )
    {
    echo "								<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>  
											<div class=\"col-lg-6\">
												<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2> Sebaiknya nilainya diperkecil karena pemrosesan akan memakan waktu relatif lama
											</div>
										</div>";
    }
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
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
