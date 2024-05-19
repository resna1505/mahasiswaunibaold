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
    if ( $aksi == "krs" )
    {
        include( "krs.php" );
    }
    if ( $aksi == "tampilkan" )
    {
        $aksi = " ";
        include( "prosestampilmahasiswa.php" );
    }
    if ( $aksi == "" )
    {
        #printjudulmenu( "Lihat KRS Semester Pendek Mahasiswa " );
        #printmesg( $errmesg );
        #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t<table class=form>\r\n\r\n \r\n\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \r\n \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>\r\n\t";
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
        echo "			<div class='portlet-title'>";
							printmesg("Lihat KRS Semester Pendek Mahasiswa");
		echo "			</div>";
		echo "  		<div class=\"m-portlet\">
						<!--begin::Form-->";
        echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
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
