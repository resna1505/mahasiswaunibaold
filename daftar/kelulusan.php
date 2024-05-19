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
if ( $aksi == "tampilkan" )
{
	#echo "mm";exit();
    if ( $aksi2 == "Simpan Status Kelulusan" )
    {
		#print_r($lulus);
		#echo '<br>';
        foreach ( $lulus as $k => $v )
        {
            foreach ( $v as $k2 => $v2 )
            {
                foreach ( $v2 as $k3 => $v3 )
                {
                    $q = "UPDATE calonmahasiswa SET LULUS='{$v3}' WHERE ID='{$k3}' AND \r\n            TAHUN='{$tahunmasuk}' AND GELOMBANG='{$k}' AND PILIHAN='".$idpilihanlulus[$k][$k2][$k3]."'";
                    #echo $q;
					doquery($koneksi,$q);
                    $ketlog = "Entri Status kelulusan Calon Mahasiswa.   ID={$k3}, LULUS={$v3},   PILIHAN='".$idpilihanlulus[$k][$k2][$k3]."'";
                    buatlog( 87 );
                }
            }
        }
        $errmesg = "Data Status Kelulusan Calon mahasiswa telah disimpan";
    }
    if ( $gelombang != "" )
    {
        $qf = "AND GELOMBANG='{$gelombang}'";
        $ff = "dan Gelombang {$gelombang}";
    }
    $q = "select * from filterpmb where TAHUN='{$tahunmasuk}' ";
	#echo $q;exit();
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
		#echo $q;exit();
        while ( $d = sqlfetcharray( $h ) )
        {
            $datafilter[$d[GELOMBANG]][$d[IDPRODI]][NILAI] = $d[NILAI];
            $datafilter[$d[GELOMBANG]][$d[IDPRODI]][JUMLAH] = $d[JUMLAH];
        }
        include( "proseskelulusan.php" );
    }else{
	
		$errmesg = "Setting Saringan Masuk untuk Tahun {$tahunmasuk} {$ff} belum dibuat. Silakan buat dahulu setting saringan masuk.";
		$aksi = "";
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
								printmesg("Proses Kelulusan Calon Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->  
							<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
		echo "								<select name=tahunmasuk class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 2007;
												while ( $i <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $i == $waktu[year] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
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
										<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idpilihan><option value=''>Semua</option>";
												foreach ( $arraypilihanpmb as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">ID/Nomor Tes</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $id, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Pilihan Program Studi 1</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi1>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    #echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tPilihan Program Studi 2\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi2>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    #foreach ( $arrayprodidep as $k => $v )
    #{
    #    echo "<option value='{$k}'>{$v}</option>";
    #}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<button type='submit' value='Tampilkan' class='btn btn-brand'>Tampilkan</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>form.id.focus();</script>";
}
?>
