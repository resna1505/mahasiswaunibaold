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
if ( $aksi == "formupdate" )
{
    include( "proseskelas.php" );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilkelasawal.php" );
}
if ( $aksi == "" )
{
    $arraykelompokmk[''] = "Semua";
    #printjudulmenu( "Pembagian Kelas Mata Kuliah " );
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
                                <span class=\"caption-subject bold uppercase\"> Pembagian Kelas Mata Kuliah </span>
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
								printmesg("Pembagian Kelas Mata Kuliah");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>";
	echo "				<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
								<div class=\"col-lg-6\">".createinputtahunajaransemester( 0, "tahunk", "semesterk","" )." </div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";

	foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Kode MK</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahunk.value,form.semesterk.value);\"" )."\r\n\t\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\"> <div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div></div></div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama MK</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=40" )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Semester Makul</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "semester", $semester, " class=form-control m-input  size=2" )."</div>
							</div> 
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "sks", $sks, " class=form-control m-input  size=2" )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
								<div class=\"col-lg-6\"><select class=form-control m-input name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayjenismakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</div>\r\n\t\t\t</div> 
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
								<div class=\"col-lg-6\">".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$kelompokkurikulum}", "", " class=form-control m-input " )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">KELOMPOK MATA KULIAH</label>\r\n    
								<div class=\"col-lg-6\">".createinputselect( "kelompok", $arraykelompokmk, "{$kelompok}", "", " class=form-control m-input " )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\"><input type=submit value='Tampilkan' class=\"btn btn-brand\"></div>
							</div>
						</div></form>
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
