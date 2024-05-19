<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
@cekuser( "" );
if ( $aksi == "ganti" && $REQUEST_METHOD == POST )
{
    $ok = true;
    if ( trim( $iduser ) == "" )
    {
        $ok = false;
        $errmesg = "User ID harus diisi";
        buatlog( 5, $iduser );
    }
    else if ( trim( $passlama ) == "" )
    {
        $ok = false;
        $errmesg = "Password lama harus diisi";
        buatlog( 5, $iduser );
    }
    else if ( trim( $pass == "" ) || strlen( $pass ) < 4 )
    {
        $ok = false;
        $errmesg = "Password baru harus diisi minimum 4 karakter";
        buatlog( 5, $iduser );
    }
    else if ( trim( $pass2 == "" ) || strlen( $pass2 ) < 4 )
    {
        $ok = false;
        $errmesg = "Konfirmasi password baru harus diisi minimum 4 karakter";
        buatlog( 5, $iduser );
    }
    else if ( $pass != $pass2 )
    {
        $ok = false;
        $errmesg = "Password baru dan konfirmasi password baru harus sama";
        buatlog( 5, $iduser );
    }
    else
    {
        $pass = str_replace( "'", "\\'", $pass );
        $pass2 = str_replace( "'", "\\'", $pass2 );
        $passlama = str_replace( "'", "\\'", $passlama );
        if ( $jenisusers == 0 )
        {
            $tabeluser = "user";
        }
        else if ( $jenisusers == 1 )
        {
            $tabeluser = "dosen";
        }
        else
        {
            $tabeluser = "mahasiswa";
        }
        #$query = "UPDATE {$tabeluser} SET PASSWORD=PASSWORD('{$pass}') ,FLAGPASSWORD=0\r\n  \t\tWHERE ID='{$iduser}' AND \r\n      (\r\n        (PASSWORD=PASSWORD('{$passlama}') AND FLAGPASSWORD=0 ) \r\n        OR\r\n        (PASSWORD=PASSWORD('{$passlama}') AND FLAGPASSWORD=1 ) \r\n      )\r\n      ";
        $query = "UPDATE {$tabeluser} SET PASSWORD=PASSWORD('{$pass}') ,FLAGPASSWORD=0\r\n  \t\tWHERE ID='{$iduser}'";
        
		mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) == 1 )
        {
            $errmesg = "Password Anda telah diganti dengan yang baru. Terima kasih";
            $iduser = "";
            $passlama = "";
            $pass = "";
            $pass2 = "";
        }
        else
        {
            $errmesg = "User ID dan password Anda tidak sesuai. Silakan ulangi penggantian password";
            $passlama = "";
            $pass = "";
            $pass2 = "";
        }
    }
}
if ( $errmesg != "" && $pgl != "" )
{
    $errmesg = "{$pgl}. ".$errmesg;
}
#printjudulmenu( "Ganti Password" );
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Ganti Password");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";                        
echo "						<form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=aksi value=\"ganti\">\r\n";
echo "						<input type=hidden name=iduser value='$users'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Password lama</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input type=password name=passlama size=20 value='$passlama'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Password baru</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input type=password name=pass size=20 value='$pass'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Konfirmasi password baru</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input type=password name=pass2 size=20 value='$pass2'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Ganti' class=\"btn btn-brand\">
											<input type=reset value=Reset class=\"btn btn-secondary\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
        ";
?>
