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
if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
   
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( " Batas Waktu Entri Nilai untuk Dosen", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROm waktunilaiprodisp WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'\r\n   AND PRODI='{$idprodihapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "Tampilkan";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( " Batas Waktu Entri Nilai untuk Dosen", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
            $vld[] = cekvaliditastanggal( "Tanggal Selesai", $selesai['tgl'], $selesai['bln'], $selesai['thn'] );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktunilaiprodisp \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER,PRODI)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}','{$idprodi}' \r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data  Batas Waktu Entri Nilai untuk Dosen berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktunilaiprodisp \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}' AND \r\n         PRODI='{$idprodi}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data  Batas Waktu Entri Nilai untuk Dosen online berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data  Batas Waktu Entri Nilai untuk Dosen tidak disimpan";
                    }
                }
            }
        }
        $aksi = "";
    }
    if ( $aksi == "Tampilkan" )
    {
        $qfield = $jfield = $href = "";
        if ( $ifprodi == 1 )
        {
            $qfield .= " AND PRODI='{$idprodi}' ";
            $jfield .= " Prodi Mata Kuliah ".$arrayprodidep[$idprodi]." <br>";
            $href .= "&ifprodi={$ifprodi}&idprodi={$idprodi}";
        }
        if ( $iftahun == 1 )
        {
            $qfield .= " AND TAHUN='{$tahun}' AND SEMESTER = '{$semester}' ";
            $jfield .= " Tahun Semester ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." <br>";
            $href .= "&iftahun={$iftahun}&tahun={$tahun}&semester={$semester}";
        }
        $aksi = "";
        $aksi2 = "Tampilkan";
    }
    if ( $aksi == "" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        
        echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->";
		echo "					<div class='portlet-title'>";
									printmesg( $errmesg );
									printmesg("Edit Batas Waktu Entri Nilai untuk Dosen -  KHUSUS");										
		echo "					</div>	
							<div class=\"m-portlet\">
								<!--begin::Form-->";
		echo "					<form action='index.php' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method=post >
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=sessid value='{$token}'>
									<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun/Semester</label>\r\n    
											<label class=\"col-form-label\">
												<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\">";
													$i = 1901;
													while ( $i <= $waktu[year] + 5 )
													{
														if ( $i == $waktu[year] + 1 )
														{
															$selected = "selected";
														}
														echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
														$selected = "";
														++$i;
													}
		echo "									</select>/
												<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\">\r\n            ";
													foreach ( $arraysemester as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" >
											<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Mata Kuliah</label>\r\n    
											<label class=\"col-form-label\">
												".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=form-control m-input" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Batas Waktu Entri Nilai s.d Tanggal</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtanggal( "selesai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"></div>
											</div>
										</div>
									</div>									
								</form>";
        echo "					<form action='index.php' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
										<div class=\"m-portlet__body\">		
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Tahun/Semester</label>\r\n    
												<div class=\"col-lg-6\">
													<div class=\"m-checkbox-list\">
														<label class=\"m-checkbox\">
															<input type=checkbox name=iftahun value=1>
																<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\">";
																	$i = 1901;
																	while ( $i <= $waktu[year] + 5 )
																	{
																		if ( $i == $waktu[year] + 1 )
																		{
																			$selected = "selected";
																		}
																		echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
																		$selected = "";
																		++$i;
																	}
        echo "													</select>/
																<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\">\r\n            ";
																	foreach ( $arraysemester as $k => $v )
																	{
																		echo "<option value='{$k}'>{$v}</option>";
																	}
        echo "													</select>
															<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class=\"form-group m-form__group row\" >
												<label class=\"col-lg-2 col-form-label\">Prodi Mata Kuliah</label>\r\n    
												<div class=\"col-lg-6\">
													<div class=\"m-checkbox-list\">
														<label class=\"m-checkbox\">
															<input type=checkbox name=ifprodi value=1>
																<select name=idprodi class=form-control m-input style=\"width:auto;display:inline-block;\">";
																	foreach ( $arrayprodidep as $k => $v )
																	{
																		if ( $k == $idprodi )
																		{
																			$selected = "selected";
																		}
																		echo "<option {$selected} value='{$k}'>{$v}</option>";
																		$selected = "";
																	}
        echo "													</select>
														<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
												<div class=\"col-lg-6\">
													<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
												</div>
											</div>
										</div>
							</form>";
        if ( $aksi2 == "Tampilkan" )
        {
            $q = "SELECT * FROM waktunilaiprodisp \r\n  WHERE 1=1\r\n  {$qfield}\r\n  ORDER BY TAHUN DESC,SEMESTER,PRODI DESC";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
               /* printjudulmenukecil( "<b>Data   Batas Waktu Entri Nilai untuk Dosen Khusus</b>" );
                printjudulmenukecil( $jfield );
                echo "\r\n    <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Program Studi Makul</td>\r\n         <td>Batas Waktu s.d Tanggal</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
                */
				echo "	<div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("<b>Data Batas Waktu Entri Nilai untuk Dosen Khusus</b>");
				echo "					</div>
									</div>";
				echo "			 	<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
				echo "									<tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Program Studi Makul</td>\r\n         <td>Batas Waktu s.d Tanggal</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>";
				echo "								</thead>
													<tbody>";
				$i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    $kelas = kelas( $i );
                    $tmp = explode( "-", $d[TANGGALMULAI] );
                    $tglmulai = $tmp[2];
                    $blnmulai = $tmp[1];
                    $thnmulai = $tmp[0];
                    $tmp = explode( "-", $d[TANGGALSELESAI] );
                    $tglselesai = $tmp[2];
                    $blnselesai = $tmp[1];
                    $thnselesai = $tmp[0];
                    echo "\r\n      <tr {$kelas}>\r\n        <td nowrap>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        <td nowrap>".$arrayprodidep[$d[PRODI]]."</td>\r\n         <td   nowrap align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td   nowrap align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&idprodihapus={$d['PRODI']}&aksi=hapus&sessid={$token}{$href}'\r\n       onClick=\"return confirm('Hapus  Batas Waktu Entri Nilai untuk Dosen?');\">hapus</a></td>      \r\n       </tr>\r\n      ";
                }
                #echo "</table></div></div></div></div></div>";
				echo "								</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
				</div>
				</div>";
            }
            else
            {
                printmesg( "Data  Batas Waktu Entri Nilai untuk Dosen Khusus Tidak Ada. <br>{$jfield}" );
            }
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
