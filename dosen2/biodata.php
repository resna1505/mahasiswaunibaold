<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
    $q = "SELECT * FROM dosen WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        #echo "\r\n\t\t<br><br>\r\n\t\t \r\n\t\t<table class=form> <tr class=judulform>\r\n\t\t\t<td width=25 0>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDDEPARTEMEN]]."</td>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen</td>\r\n\t\t\t<td><b>{$d['ID']}\r\n      \r\n      </td>\r\n\t\t</tr> \r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Dosen</td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."</td>\r\n\t\t</tr> \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Akte Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[AKTE]]."</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Izin Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[IZIN]]."</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Dosen</td>\r\n\t\t\t<td> ".$arraystatuskerjadosen[$d[STATUSKERJA]]."</td> \t\t\t\r\n\t\t</tr>";
        echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<div class=\"col-lg-6\">
									".$arrayprodidep[$d[IDDEPARTEMEN]]."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<div class=\"col-lg-6\">
								<b>{$d['ID']}</b>
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<div class=\"col-lg-6\">
								<b>{$d['NAMA']}</b>
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
							<div class=\"col-lg-6\">
								".nl2br( $d[ALAMAT] )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Akte Mengajar</label>\r\n    
							<div class=\"col-lg-6\">
								".$arrayya[$d[AKTE]]."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Izin Mengajar</label>\r\n    
							<div class=\"col-lg-6\">
								".$arrayya[$d[IZIN]]."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Status Dosen</label>\r\n    
							<div class=\"col-lg-6\">
								".$arraystatuskerjadosen[$d[STATUSKERJA]]."
							</div>
						</div>";
		include( "dosen2.php" );
        #echo "\r\n \r\n\t\t\t</table>\r\n\t \r\n \r\n\t\t";
		echo"		</div>
				</form>
			</div>";
    }
}
?>
