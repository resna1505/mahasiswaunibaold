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
            $q = "DELETE FROM tbkmk WHERE THSMSTBKMK='".( $tahun - 1 )."{$semester}' ";
            mysqli_query($koneksi,$q);
            $total = sqlaffectedrows( $koneksi );
            if ( 0 < $total )
            {
                $errmesg = "{$total} data kurikulum berhasil dihapus";
                $ketlog = "Hapus Kurikulum ".( $tahun - 1 )."{$semester}. Supervisor : {$idsp}. User : {$users} ";
                buatlog( 90 );
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
   /* echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Hapus Data Kurikulum Mata Kuliah </span>
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
					printmesg("Hapus Data Kurikulum");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->";
    echo "\r\n  <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post\r\n  onSubmit='return confirm(\"Hapus data?\")'> 
		<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=sessid value='{$token}'> 
		<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Hapus data Kurikulum Mata Kuliah Semester</label>\r\n    
								<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">ID Supervisor</label>\r\n    
								<div class=\"col-lg-6\"><input type=text name=idsp value='' size=20 class=form-control m-input></div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Password Supervisor</label>\r\n    
								<div class=\"col-lg-6\"><input type=password name=passwordsp value='' size=20 class=form-control m-input></div>
							</div>
							<div class=\"form-group m-form__group row\">
								<div class=\"col-lg-6\">
									 <input type=submit name=aksi value='Hapus Data!' class=\"btn btn-brand\">
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
