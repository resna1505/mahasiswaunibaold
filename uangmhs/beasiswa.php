<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
cekhaktulis( $kodemenu );
if ( $aksi == "Tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
		#echo "kkk";exit();
        $errmesg = token_err_mesg( "Beasiswa", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( getnamafromtabel( $idmahasiswa, "mahasiswa" ) == "" )
    {
        $errmesg = "ID Mahasiswa tidak valid";
    }
    #else if ( $diskon <= 0 || 100 < $diskon)
	else if (100 < $diskon)
    {
        $errmesg = "Persentase diskon tidak valid. Harus diisi dengan nilai max 100";
    }else if ($diskon>0 && $diskon_rp>0){
	
	    $errmesg = "Diskon hanya boleh diisi salah satu";
    
	}
    else
    {
        $tahunbayar = $semesterbayar = "";
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
        {
            $tahunbayar = $tahunajaran;
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            $tahunbayar = $tahun;
            $semesterbayar = $semester;
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
        {
            $tahunbayar = $tahunc;
            $semesterbayar = $semesterc;
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
        {
            $tahunbayar = $tahunbulan;
            $semesterbayar = $bulan;
        }
		
		if($diskon==0 && $diskon_rp!=0){
			$diskon=$diskon_rp;
		}elseif($diskon!=0 && $diskon_rp==0){
			$diskon=$diskon;
		}else{
			$diskon=$diskon;
		}
		
        $q = "INSERT INTO diskonbeasiswa  (IDMAHASISWA,IDKOMPONEN,DISKON,KET,UPDATER,TANGGALUPDATE,TAHUN,SEMESTER) VALUES ('{$idmahasiswa}','{$idkomponen}','{$diskon}','{$ket}','{$users}',NOW(),'{$tahunbayar}','{$semesterbayar}')\r\n      ";
        #echo $q;exit();
		mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Diskon Mahasiswa berhasil disimpan.";
            #$ketlog = "Tambah Beasiswa Mahasiswa NIM {$idmahasiswa} dengan \r\n  \t\t\t\tID Komponen={$idkomponen} senilai {$diskon} %, Tahun={$tahunbayar}, Sem/Bulan={$semesterbayar}, {$ket} \r\n  \t\t\t\t";
            if($diskon==0 && $diskon_rp!=0){
				#$diskon=$diskon_rp;
				$ketlog = "Tambah Beasiswa Mahasiswa NIM {$idmahasiswa} dengan \r\n  \t\t\t\tID Komponen={$idkomponen} senilai {$diskon} , Tahun={$tahunbayar}, Sem/Bulan={$semesterbayar}, {$ket} \r\n  \t\t\t\t";
           
			}elseif($diskon!=0 && $diskon_rp==0){
				#$diskon=$diskon;
				$ketlog = "Tambah Beasiswa Mahasiswa NIM {$idmahasiswa} dengan \r\n  \t\t\t\tID Komponen={$idkomponen} senilai {$diskon} %, Tahun={$tahunbayar}, Sem/Bulan={$semesterbayar}, {$ket} \r\n  \t\t\t\t";
        
			}else{
				#$diskon=$diskon;
				$ketlog = "Tambah Beasiswa Mahasiswa NIM {$idmahasiswa} dengan \r\n  \t\t\t\tID Komponen={$idkomponen} senilai {$diskon} %, Tahun={$tahunbayar}, Sem/Bulan={$semesterbayar}, {$ket} \r\n  \t\t\t\t";
        
			}
			buatlog( 92 );
        }
        else
        {
            $errmesg = "Diskon Mahasiswa tidak berhasil disimpan.";
        }
    }
}
#printjudulmenu( "Tambah Beasiswa Mahasiswa" );
#printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$diskon=0;
$diskon_rp=0;
 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Tambah Beasiswa Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "pilihan", $pilihan, "" ).
								createinputhidden( "sessid", "{$token}", "" )."
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n    
										<label class=\"col-form-label\">
											<script>\r\n            var  arrayjeniskomponen = new Array;\r\n            ";
												foreach ( $arraykomponenpembayaran as $k => $v )
												{
													echo "\r\n                arrayjeniskomponen['{$k}']=".$arrayjeniskomponenpembayaran[$k].";\r\n              ";
												}
echo "										</script>
											<select name=idkomponen onChange='gantilabel(this.value);' class=form-control m-input><option value='' >Pilih Komponen Pembayaran</option>";
												foreach ( $arraykomponenpembayaran as $k => $v )
												{
													echo "<option value={$k}>{$v}</option>";
												}
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" id=pertahun style=\"background-color:#f7f8fa;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tahunajaran class=form-control m-input>";
												$arrayangkatan = getarrayangkatan( "R" );
												foreach ( $arrayangkatan as $k => $v )
												{
													$selected = "";
													if ( $k == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
												++$k;
echo "											<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>";
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" id=persemester style=\"background-color:#f7f8fa;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtahunajaransemester( $semua = 0 )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" id=cuti style=\"background-color:#f7f8fa;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtahunajaransemestercuti( $semua = 0, "semestercuti", $idmahasiswa )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" id=perbulan style=\"background-color:#f7f8fa;display:none;\">
										<label class=\"col-lg-2 col-form-label\">Bulan-Tahun</label>\r\n    
										<label class=\"col-form-label\">
											<select name=bulan class=form-control m-input>";
												foreach ( $arraybulan as $k => $v )
												{
													$cek = "";
													if ( $k + 1 == $w[mon] )
													{
														$cek = "selected";
													}
													echo "<option value='".( $k + 1 )."' {$cek}>{$v}</option>";
												}
echo "										</select>
											<select name=tahunbulan class=form-control m-input>";
												$ii = 1990;
												while ( $ii <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $ii == $d2[TAHUNAJARAN] )
													{
														$cek = "selected";
													}
													else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}> {$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
													++$ii;
												}
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Diskon Pembayaran (%)</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "diskon", $diskon, " class=form-control m-input style=\"width:auto;display:inline-block;\"  size=5  " )." % <br><br>(Misal persentase 40%, biaya yg harus dibayar adalah 60 (100-40) % x Jumlah Biaya)
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Diskon Pembayaran (Rp)</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "diskon_rp", $diskon_rp, " class=form-control m-input  size=20  " )." 
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "ket", $ket, " class=form-control m-input  size=40  " )." 
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit id=aksi2 name=aksi value='Tambah' class=\"btn btn-brand\" style='display:none;'>
											<input type=reset id=aksi2r  value='Reset' class=form-control m-input style='display:none;'>
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
				function gantilabel(v) {
					//alert(document.getElementById('pertahun').style.visibility);
					//alert(arrayjeniskomponen[v]);
					document.getElementById('pertahun').style.display='none';
					document.getElementById('persemester').style.display='none';
					document.getElementById('perbulan').style.display='none';
					document.getElementById('cuti').style.display='none';
					document.getElementById('aksi2').style.display='inline';
					if (  v=='') { 
						// Tidak memilihdocument.getElementById('aksi2').style.display='none';
					} 
					else if (  arrayjeniskomponen[v]==0) { 
						// 1 Kali Awal Kuliah
					} else if (  arrayjeniskomponen[v]==1) { 
						// 1 Kali Akhir Kuliah
					} else if (  arrayjeniskomponen[v]==2) { 
						// Per tahun Ajaran
						document.getElementById('pertahun').style.display='';
					} else if (  arrayjeniskomponen[v]==3) { 
						// Per Semesteran
						document.getElementById('persemester').style.display='';
					} else if (  arrayjeniskomponen[v]==4) { 
						// Tidak tetap
					} else if (  arrayjeniskomponen[v]==5) { 
						// Bulanan 
						document.getElementById('perbulan').style.display='';
					} else if (  arrayjeniskomponen[v]==6) { 
						// Cuti
						document.getElementById('cuti').style.display='';
					}
				}
			</script>
			<script>form.idmahasiswa.focus();</script>";
?>
