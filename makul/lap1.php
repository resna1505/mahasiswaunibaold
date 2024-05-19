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
    #printjudulmenu( "Daftar Mahasiswa yang Sudah Mengambil KRS" );
    #printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Daftar Mahasiswa yang Sudah Mengambil KRS </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Daftar Mahasiswa yang sudah mengambil KRS");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">";
    echo "\r\n\t\t<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
			<input type=hidden name=pilihan value='{$pilihan}'>
			<input type=hidden name=aksi value='tampilkan'>";
	/*echo "<div class='portlet-body form'>
									<table class=\"table table-striped table-bordered table-hover\">
										<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n\r\n\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<b>FILTER\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n \t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    */
	 echo "<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
								<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\"><b>FILTER</b></label>\r\n    
								<div class=\"col-lg-6\"></div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\"><select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
	foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
								<div class=\"col-lg-6\">";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t	<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "					</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
        echo "<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default </label>\r\n    
						<div class=\"col-lg-6\"> <select name='jeniskelas' >\r\n        <option value=''>Semua</option>\r\n      ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n      </select>\r\n      \r\n      </div>\r\n\t\t</div>\r\n     ";
    }
    echo "   <div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
						<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=40" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmahasiswa as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "			</select>
				</div>
			</div>";
    $arraylabelkelas[''] = "Semua";
    echo "	<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
				<label class=\"col-form-label\">".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "class=form-control m-input" )."</label>
			</div>
			
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
