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
if ( $aksi == "Simpan Perubahan" )
{
    if ( is_array( $arrayupdate ) )
    {
        foreach ( $arrayupdate as $k => $v )
        {
            $q = "INSERT INTO filterpmb (TAHUN,GELOMBANG,IDPRODI,NILAI,JUMLAH,UPDATER,TANGGALUPDATE) \r\n      VALUES ('{$tahunmasuk}','{$gelombang}','{$k}','".$nilai[$k]."','".$jumlah[$k]."','{$users}',NOW())";
            doquery($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "UPDATE filterpmb SET NILAI='".$nilai[$k]."', JUMLAH='".$jumlah[$k]."'\r\n        WHERE TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' AND IDPRODI='{$k}'";
                doquery($koneksi,$q);
            }
            $ketlog = "Edit Filter Saringan Masuk Calon Mahasiswa. Tahun={$tahunmasuk}, Gel={$gelombang}, PRODI={$k}, PIG=".$nilai[$k].", JUMLAH=".$jumlah[$k]."";
            buatlog( 85 );
        }
        $errmesg = "Data Saringan Masuk Telah Disimpan";
    }
    $aksi = "Lanjutkan";
}
if ( $aksi == "Lanjutkan" )
{
    if ( trim( $gelombang ) == "" )
    {
        $errmesg = "Gelombang PMB harus diisi";
    }
    else
    {
       
        
        #printmesg( $errmesg );
        echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Setting Saringan Masuk Per Prodi");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
								<input type=hidden name=gelombang value='{$gelombang}'>
								<div class=\"portlet-body\">";
						echo "															
									<div class=\"tools\">
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr>
														<td>
															<input type=submit name=aksi value='Simpan Perubahan' class=\"btn btn-brand\">
														</td>
													</tr>
												</table>
											</div>
									</div>"; 
						echo "		<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n      <td>Program Studi</td>\r\n      <td>Pass in Grade</td>\r\n      <td>Jumlah Maksimum Mahasiswa</td></tr>
													</thead>
													<tbody>";
        foreach ( $arrayprodidep as $k => $v )
        {
            unset( $d );
            $q = "SELECT * FROM filterpmb WHERE IDPRODI='{$k}' AND GELOMBANG='{$gelombang}' AND TAHUN='{$tahunmasuk}'";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
            }
            echo "\r\n      <tr >\r\n        <td>{$v}\r\n        <input type=hidden name='arrayupdate[{$k}]' value='{$k}'>\r\n        </td>\r\n        <td align=center><input type=text name='nilai[{$k}]' value='{$d['NILAI']}' size=4></td>\r\n        <td  align=center><input type=text name='jumlah[{$k}]' value='{$d['JUMLAH']}' size=4></td>\r\n      </tr>\r\n      ";
        }
        #echo "</table></div></div></div></div></div></div></div>";
		echo "										</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
    }
}
if ( $aksi == "" )
{
   
    #printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
     echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Setting Saringan Masuk Per Prodi");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form action=index.php class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
		echo "								<select name=tahunmasuk class=form-control m-input> \r\n\t\t\t\t\t\t ";
												$i = 2007;
												while ( $i <= $waktu[year] + 5 )
												{
													$selected = "";
													if ( $i == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$selected}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<button type='submit' class='btn btn-brand' name=aksi value='Lanjutkan'>Lanjutkan</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
}
?>
