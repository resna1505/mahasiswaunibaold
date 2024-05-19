<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "Update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Edit Nilai Ujian Akhir Program", SIMPAN_DATA );
    }
    else
    {
        cekhaktulis( $kodemenu );
        $berhasil = 0;
        foreach ( $nilaiuap as $k => $v )
        {
            $q = "UPDATE mahasiswa SET IPKUAP='{$v}',LAMBANGUAP='".$lambanguap[$k]."' WHERE ID='{$k}'";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) )
            {
                ++$berhasil;
            }
        }
        $errmesg = "{$berhasil} data Nilai Ujian Akhir Program berhasil diupdate";
    }
}
if ( $aksi == "tampilkan" )
{
    include( "prosesujianakhir.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Edit Nilai Ujian Akhir Program" );
    printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Edit Nilai Ujian Akhir Program </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->";
							printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Nilai Ujian Akhir Program ");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
    if ( $jenisusers == 0 )
    {
        echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>    
										<div class=\"col-lg-6\">".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.id.value)\">daftar dosen</a>-->
											<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
												<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
											</div>
										</div>
									</div>";
    }
    else if ( $jenisusers == 1 )
    {
        echo "<input type=hidden name=iddosen value='{$users}'>";
    }
    echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<div class=\"col-lg-6\">";
											$waktu = getdate( );
    echo "									<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>    
										<div class=\"col-lg-6\">".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >daftar mahasiswa</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>"."
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>    
										<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Status Aktifitas</label>    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusmahasiswa as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Status Awal</label>    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=statusawal>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusmhsbaru as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</div>
									</div>\r\n <!-- \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tPeriode Tahun Akademik \r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n          <input type=checkbox name=iftahunakademik value=1>\r\n        ";
    $waktu = getdate( );
    if ( $tahun2 == "" )
    {
        $tahun2 = $waktu[year];
    }
    echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $tahun2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=form-control m-input> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t\t(Khusus untuk Status Mahasiswa)\r\n\t\t\t\t</td>\r\n\t\t\t</tr>      \r\n        -->
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>    
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
		<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>";
}
?>
