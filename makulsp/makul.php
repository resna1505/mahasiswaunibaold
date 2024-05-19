<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $tab == 0 || $tab == "" )
    {
        include( "dikti.php" );
    }
    else if ( $tab == 1 )
    {
        include( "dikti.php" );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
   
    $arraymenutab[1] = "Kurikulum Semester Pendek";
    /*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Data {$JUDULFAKULTAS}</span>
                            </div>
                            <div class=\"tools\">
                                <form action=cetakfakultas.php target=_blank method=post> <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"><tr>\r\n\t";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Update Data Mata Kuliah SP");
								echo	"</div>
										
									</div>
									<div class='portlet-body form'>
                           <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr>\r\n\t";
    foreach ( $arraymenutab as $k => $v )
    {
        echo "<td align=center><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
    }
   
    echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div></div>";
	
	echo "<div class=\"m-portlet__body\">";	 
    if ( $tab == 0 || $tab == "" )
    {
		
        include( "dikti.php" );
    }
    else if ( $tab == 1 )
    {
        include( "dikti.php" );
    }
	 #echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div></div></div></div>\r\n\t";
	echo "</div>";
		
}
if ( $aksi == "tampilkan" )
{
    #include( "../strip_input_error.php" );
    $aksi = " ";
    include( "prosestampilmakul.php" );
}
if ( $aksi == "" )
{
  
    /*printmesg( $errmesg );
    echo "<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">Edit Kurikulum SP / Cari Data Mata Kuliah</span>
                            </div>
                           
                        </div>
                        <div class=\"portlet-body form\">*/
	echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">
							<!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "			<div class='portlet-title'>";
						printmesg("Edit Kurikulum SP / Cari Data Mata Kuliah");
	echo "		</div>";
	echo "		<div class=\"m-portlet\">
					<!--begin::Form-->
						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
								<label class=\"col-form-label\">
									<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arrayprodidepmakul as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
	echo "							</select>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode MK</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,form.idprodi.value );\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
									<!--<a href=\"javascript:daftarmakul('form,wewenang,id',document.form.id.value)\" >daftar mata kuliah</a>-->
									<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
										<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
									</div>
								</div>
							</div>"."
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Nama MK</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "semester", $semester, " class=form-control m-input  size=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "sks", $sks, " class=form-control m-input  size=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
								<label class=\"col-form-label\">
									<select class=form-control m-input name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arrayjenismakul as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
    echo "							</select>
								</label>
							</div>";
    echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Tampilkan' class=\"btn btn-brand\"></div>
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
            </script>
    ";
}
?>
