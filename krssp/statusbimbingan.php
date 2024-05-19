<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $jenisusers == 1 )
{
    if ( $aksi == "tampilkan" )
    {
        $aksi = " ";
        include( "prosesstatusbimbingan.php" );
    }
    if ( $aksi == "" )
    {
        #printjudulmenu( "Edit Status Bimbingan Mahasiswa " );
        #printmesg( $errmesg );
        echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
    echo "				<div class='portlet-title'>";
							printmesg("Edit Status Bimbingan Semester Pendek");
	echo "				</div>";
	echo "				<div class=\"m-portlet\">				
						<!--begin::Form-->";
	 echo "				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
									<div class=\"col-lg-6\">
									".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" placeholder=\"Ketik NIM / Nama Mahasiswa...\" " )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >daftar mahasiswa
											</a>-->
										<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
											<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
									<div class=\"col-lg-6\">";
										$waktu = getdate( );
								echo "	<select name=tahun class=form-control m-input> \r\n             ";
											$i = 2001;
											while ( $i <= $waktu[year] + 5 )
											{
												if ( $waktu[year] == $i )
												{
													$cek = "selected";
												}
												echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
												$cek = "";
												++$i;
											}
    echo "								</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
									<div class=\"col-lg-6\">
										<select name=semester class=form-control m-input> \r\n             ";
											foreach ( $arraysemester as $k => $v )
											{
												echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
											}
    echo "								</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
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
	<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>\r\n\t";
    }
}
?>
