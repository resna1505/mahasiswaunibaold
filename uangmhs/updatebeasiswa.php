<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Beasiswa", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    #else if ( $diskon <= 0 || 100 < $diskon )
    #{
    #    $errmesg = "Persentase diskon tidak valid. Harus diisi dengan nilai lebih dari 0 s.d 100";
    #}
	else if (100 < $diskon)
    {
        $errmesg = "Persentase diskon tidak valid. Harus diisi dengan nilai max 100";
    }else if ($diskon>0 && $diskon_rp>0){
	
	    $errmesg = "Diskon hanya boleh diisi salah satu";
    
	}
    else
    {
		if($diskon==0 && $diskon_rp!=0){
			$diskon=$diskon_rp;
		}elseif($diskon!=0 && $diskon_rp==0){
			$diskon=$diskon;
		}else{
			$diskon=$diskon;
		}
		
        $q = "UPDATE diskonbeasiswa \r\n      SET\r\n      DISKON='{$diskon}',\r\n      KET='{$ket}',\r\n      UPDATER='{$users}',\r\n      TANGGALUPDATE=NOW()\r\n      WHERE\r\n      IDMAHASISWA='{$idmahasiswaupdate}' AND\r\n      IDKOMPONEN='{$idkomponenupdate}' AND\r\n      TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'    \r\n       ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Diskon Mahasiswa berhasil disimpan.";
            $ketlog = "Update Beasiswa Mahasiswa NIM {$idmahasiswaupdate} dengan \r\n  \t\t\t\tID Komponen={$idkomponenupdate} senilai {$diskon} %, Tahun={$tahunupdate}, Sem/Bulan={$semesterupdate}, {$ket} \r\n  \t\t\t\t";
            buatlog( 93 );
        }
        else
        {
            $errmesg = "Diskon Mahasiswa tidak berhasil disimpan.";
        }
    }
}
#printjudulmenu( "Edit Beasiswa Mahasiswa" );
$q = "SELECT * FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswaupdate}' AND IDKOMPONEN='{$idkomponenupdate}' AND\r\n      TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'    \r\n    \r\n     ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
	if($d[DISKON]>100){
	
		$diskon_rp=$d[DISKON];
		$diskon=0;
	}else{
	
		$diskon=$d[DISKON];
		$diskon_rp=0;
	}
    $idkomponen = $idkomponenupdate;
    #printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Edit Beasiswa Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Beasiswa Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "pilihan", $pilihan, "" ).
								createinputhidden( "sessid", "{$token}", "" ).
								createinputhidden( "idmahasiswaupdate", "{$idmahasiswaupdate}", "" ).
								createinputhidden( "idkomponenupdate", "{$idkomponenupdate}", "" ).
								createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).
								createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).
								createinputhidden( "diskonlama", "{$d['DISKON']}", "" ).
								createinputhidden( "ketlama", "{$d['KET']}", "" )."
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM / Nama</label>\r\n    
										<label class=\"col-form-label\">
											<b>{$d['IDMAHASISWA']} / ".getnamafromtabel( $idmahasiswaupdate, "mahasiswa" )."</b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n    
										<label class=\"col-form-label\">
											<b>{$d['IDKOMPONEN']} / ".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</b>
										</label>
									</div>";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 || $arrayjeniskomponenpembayaran[$idkomponen] == 4 )
    {
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        echo "						<div id=pertahun class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>\r\n    
										<label class=\"col-form-label\">
											".( $d[TAHUN] - 1 )."/{$d['TAHUN']}
										</label>
									</div>";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
    {
        echo "						<div id=persemester class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".( $d[TAHUN] - 1 )."/{$d['TAHUN']} / ".$arraysemester[$d[SEMESTER]]."
										</label>
									</div>";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
    {
        echo "						<div id=persemester class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".( $d[TAHUN] - 1 )."/{$d['TAHUN']} / ".$arraysemester[$d[SEMESTER]]."
										</label>
									</div>";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
    {
        echo "						<div id=persemester class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Bulan-Tahun</label>\r\n    
										<label class=\"col-form-label\">
											".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUN']}
										</label>
									</div>";
    }
    #echo "\r\n       <tr class=judulform>\r\n      \t\t\t<td class=judulform>Diskon Pembayaran  </td>\r\n      \t\t\t<td>".createinputtext( "diskon", $d[DISKON], " class=masukan  size=5  " )." %\r\n  \r\n      \t\t\t</td>\r\n      \t\t</tr> \r\n\r\n      <tr class=judulform>\r\n      \t\t\t<td class=judulform>Keterangan</td>\r\n      \t\t\t<td>".createinputtext( "ket", $d[KET], " class=masukan  size=40  " )."  \r\n  \r\n      \t\t\t</td>\r\n      \t\t</tr> \r\n\r\n\r\n\r\n\r\n\r\n\r\n      <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>\r\n\t\t\t<br><br>\r\n \t\t";
	echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Diskon Pembayaran (%)</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "diskon", $diskon, " class=form-control m-input style=\"width:auto;display:inline-block;\" size=5  " )." %
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Diskon Pembayaran (Rp)</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "diskon_rp", $diskon_rp, " class=form-control m-input  size=20  " )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" >
										<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "ket", $d[KET], " class=form-control m-input  size=40  " )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-secondary\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			form.idmahasiswa.focus();
		</script>";

}
else
{
    printmesg( "Data beasiswa tidak ada." );
}
?>
