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
#printjudulmenu( "Salin Data Kurikulum Mata Kuliah", "bantuan" );
printhelp( trim( $arrayhelp[copydikti] ), "bantuan" );
if ( $aksi == "Salin Data!" )
{
    include( "../lain/prosescopymk.php" );
    $aksi = "";
    echo "<hr>";
}
printmesg( $errmesg );
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
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
                                <span class=\"caption-subject bold uppercase\"> Salin Data Kurikulum Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	/*echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Salin Data Kurikulum Mata Kuliah");
								echo	"</div>
										</div>
									<div class='portlet-body form'>";
    echo "<form action=index.php method=post\r\n  onSubmit='return confirm(\"Salin data?\")'\r\n  >\r\n    
			<input type=hidden name=pilihan value='{$pilihan}'> 
			<input type=hidden name=dari value='makul'>
			<input type=hidden name=sessid value='{$token}'>
				<table class=\"table table-striped table-bordered table-hover\">
					<tr>
						<td width=300 >Salin data Kurikulum Mata Kuliah dari Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tke Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0, "tahun2", "semester2", 5 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n \r\n      <tr>\r\n        <td colspan=2>\r\n          <hr>\r\n        </td>\r\n      </tr>  \r\n      <tr>\r\n        <td></td>\r\n         <td>\r\n         <input type=submit name=aksi value='Salin Data!' class=\"btn btn-brand\"> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n</div></div><br><br><br></div></div></div><br>";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
echo "			<div class='portlet-title'>";
					printmesg("Salin Data Kurikulum Mata Kuliah");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->";
echo "	       <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" onSubmit='return confirm(\"Salin data?\")' action=index.php method=post>
					<input type=hidden name=pilihan value='{$pilihan}'> 
					<input type=hidden name=dari value='makul'>
					<input type=hidden name=sessid value='{$token}'>
					<div class=\"m-portlet__body\">
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Salin data Kurikulum Mata Kuliah dari Semester</label>\r\n    
						<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )." </div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">ke Semester</label>\r\n    
						<div class=\"col-lg-6\">".createinputtahunajaransemester( 0, "tahun2", "semester2", 5 )." </div>
					</div
					<div class=\"form-group m-form__group row\">
						<div class=\"col-lg-6\">
							<input type=submit name=aksi value='Salin Data!' class=\"btn btn-brand\"><br>
						</div>
					</div>
				</form>
			</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->
</div>";
}
?>
