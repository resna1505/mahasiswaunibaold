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


printmesg( $errmesg );
if ( $aksi == "Salin Data!" )
{
    include( "prosescopymksp.php" );
    $aksi = "";
    echo "";
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    /*echo "\r\n <div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">Lihat Kurikulum Mata Kuliah Semester Pendek</span>
                            </div>
                           
                        </div>
                        <div class=\"portlet-body form\"> 
						<form action=index.php method=post\r\n  onSubmit='return confirm(\"Salin data?\")'\r\n  >\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=sessid value='{$token}'>\r\n\t\t\t".IKONTOOLS48."<div class=\"portlet-body\">
						<div class=\"table-scrollable\"><table class=\"table table-striped table-bordered table-hover\"><tr>\t\r\n\t\t\t\t<td width=300 >\r\n\t\t\t\t\tSalin data Kurikulum Mata Kuliah dari Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tke Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0, "tahun2", "semester2", 5 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n  \r\n            <tr> <td colspan=2>         <input type=submit name=aksi value='Salin Data!' class=\"btn blue\"> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n </div></div> </form></div></div>\r\n";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "			<div class='portlet-title'>";
						printmesg("Salin Data Kurikulum Mata Kuliah Semester Pendek");
	echo "		</div>";
	echo "		<div class=\"m-portlet\">
					<!--begin::Form-->";
	echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post\r\n  onSubmit='return confirm(\"Salin data?\")'\r\n  >
						<input type=hidden name=pilihan value='{$pilihan}'>
						<input type=hidden name=sessid value='{$token}'>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Salin data Kurikulum Mata Kuliah dari Semester</label>\r\n    
								<label class=\"col-form-label\">".createinputtahunajaransemester( 0 )." </label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Ke Semester</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtahunajaransemester( 0, "tahun2", "semester2", 5 )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit name=aksi value='Salin Data!' class=\"btn btn-brand\">
								</div>
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
            </script>
    ";
}

?>
