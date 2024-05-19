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
    include( "proseslap1.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Daftar Mahasiswa yang Mengambil KRS Semester Pendek" );
    #printmesg( $errmesg );
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Daftar Mahasiswa yang sudah mengambil KRS Semester Pendek");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">";
    echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t ";
											$i = 1900;
											while ( $i <= $waktu[year] + 5 )
											{
												$selected = "";
												if ( $w[year] == $i )
												{
													$selected = "selected";
												}
												echo "\r\n\t\t\t\t\t\t\t<option {$selected} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
												++$i;
											}
    echo "									</select>
										</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
										<label class=\"col-form-label\">
											<select name=semester class=form-control m-input>";
												foreach ( $arraysemester as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
    echo "									</select>
										</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\"><b>FILTER</b></label>\r\n    
								<div class=\"col-lg-6\"></div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<label class=\"col-form-label\">";
										$waktu = getdate( );
										echo "<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										$i = 1900;
										while ( $i <= $waktu[year] + 5 )
										{
											echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
											++$i;
										}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
										<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >daftar mahasiswa</a>-->
										<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
											<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
										</div>
									</div>
								</div>";
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "					<div class=\"form-group m-form__group row\" >
									<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default </label>\r\n    
									<label class=\"col-form-label\">
										<select name='jeniskelas'>
											<option value=''>Semua</option>";
												foreach ( $arraykelasstei as $k => $v )
												{
													$selected = "";
													if ( $k == $d[JENISKELAS] )
													{
														$selected = "selected";
													}
													echo "<option value='{$k}' {$selected}>{$v}</option>";
												}
        echo "							</select>
									</label>
								</div>";
    }
    echo "    					<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=status>
											<option value=''>Semua</option>";
												foreach ( $arraystatusmahasiswa as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\"><input type=submit value='Tampilkan' class=\"btn btn-brand\"></div>
								</div>
							</div>
							</form>
									<!--end::Form-->
								</div>
								<!--end::Portlet-->
										</div>
							<!--end::md-12-->	
						</div>
						<!--end::row-->	
					</div>
					<!--end::container-fluid-->
            <script>
                form.id.focus();
            </script>";
}
?>
