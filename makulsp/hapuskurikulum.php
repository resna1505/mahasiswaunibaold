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
if ( $tingkataksesusers['F4'] != "T" )
{
    exit( );
}
#printjudulmenu( "Hapus Data Kurikulum Mata Kuliah", "bantuan" );
printhelp( trim( $arrayhelp[copydikti] ), "bantuan" );
if ( $aksi == "Hapus Data!" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kurikulum", HAPUS_DATA );
    }
    else if ( $idsp == "" )
    {
        $errmesg = "ID Supervisor wajib diisi.";
    }
    else if ( $passwordsp == "" )
    {
        $errmesg = "Password Supervisor wajib diisi.";
    }
    else
    {
        $q = "SELECT ID FROM user WHERE ID='{$idsp}' AND \r\n     \r\n              (\r\n                (PASSWORD=PASSWORD('{$passwordsp}') AND FLAGPASSWORD=0 ) \r\n                OR\r\n                (PASSWORD=MD5('{$passwordsp}') AND FLAGPASSWORD=1 ) \r\n              )   \r\n     AND TINGKAT LIKE '%F4:B%' AND JENIS='1'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $q = "DELETE FROM tbkmksp WHERE THSMSTBKMK='".( $tahun - 1 )."{$semester}' ";
            mysqli_query($koneksi,$q);
            $total = sqlaffectedrows( $koneksi );
            if ( 0 < $total )
            {
                $errmesg = "{$total} data kurikulum berhasil dihapus";
                $ketlog = "Hapus Kurikulum SP ".( $tahun - 1 )."{$semester}. Supervisor : {$idsp}. User : {$users} ";
                buatlog( 91 );
            }
            else
            {
                $errmesg = "Tidak ada data kurikulum yang  dihapus";
            }
        }
        else
        {
            $errmesg = "Maaf, password supervisor salah.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    /*echo "\r\n   <div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">Hapus Data Kurikulum Mata Kuliah</span>
                            </div>
                           
                        </div>
                        <div class=\"portlet-body form\"> <form action=index.php method=post\r\n  onSubmit='return confirm(\"Hapus data?\")'\r\n  >\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=sessid value='{$token}'>\r\n\t".IKONTOOLS48."\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=300 >\r\n\t\t\t\t\tHapus data Kurikulum Mata Kuliah Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=300 >\r\n\t\t\t\t\tID Supervisor\r\n\t\t\t\t</td>\r\n\t\t\t\t<td> <input type=text name=idsp value='' size=20>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>  \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=300 >\r\n\t\t\t\t\tPassword Supervisor\r\n\t\t\t\t</td>\r\n\t\t\t\t<td> <input type=password name=passwordsp value='' size=20>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>  \r\n \r\n      <tr>\r\n        <td colspan=2>\r\n          <hr>\r\n        </td>\r\n      </tr>  \r\n      <tr>\r\n        <td></td>\r\n         <td>\r\n         <input type=submit name=aksi value='Hapus Data!' class=\"btn blue\"> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form></div></div></div></div></div>\r\n";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "			<div class='portlet-title'>";
						printmesg("Hapus Data Kurikulum");
	echo "		</div>";
	echo "		<div class=\"m-portlet\">
					<!--begin::Form-->";
	 echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post\r\n  onSubmit='return confirm(\"Hapus data?\")'> 
						<input type=hidden name=pilihan value='{$pilihan}'>
						<input type=hidden name=sessid value='{$token}'>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Hapus data Kurikulum Mata Kuliah Semester</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtahunajaransemester( 0 )."</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">ID Supervisor</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text name=idsp value='' size=20 class=form-control m-input>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Password Supervisor</label>\r\n    
								<label class=\"col-form-label\">
									<input type=password name=passwordsp value='' size=20 class=form-control m-input></label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit name=aksi value='Hapus Data!' class=\"btn btn-brand\">
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
