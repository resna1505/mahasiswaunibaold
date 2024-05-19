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
    #printjudulmenu( "Jadwal Pendaftaran PMB" );
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Pendaftaran PMB", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktudaftarpmb WHERE TAHUN='{$tahunhapus}' AND GELOMBANG='{$gelombanghapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Pendaftaran PMB", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditastahun( "Tahun", $tahun );
            $vld[] = cekvaliditasinteger( "Gelombang", $gelombang );
            $vld[] = cekvaliditastanggal( "Tanggal Mulai", $mulai['tgl'], $mulai['bln'], $mulai['thn'] );
            $vld[] = cekvaliditastanggal( "Tanggal Selesai", $selesai['tgl'], $selesai['bln'], $selesai['thn'] );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktudaftarpmb \r\n  (TAHUN,GELOMBANG,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER,BIAYA,PRODI)\r\n  VALUES \r\n  ('{$tahun}','{$gelombang}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}','{$biaya}','{$idprodi1}')\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Jadwal Pendaftaran PMB berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktudaftarpmb \r\n        SET\r\n        BIAYA='{$biaya}',\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         GELOMBANG='{$gelombang}' AND PRODI='{$idprodi1}' ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Jadwal Pendaftaran PMB berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Jadwal Pendaftaran PMB tidak disimpan";
                    }
                }
            }
        }
        $aksi = "";
    }
    if ( $aksi == "" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
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
								printmesg("Jadwal Pendaftaran PMB");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form action='index.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=sessid value='{$token}'>
								<div class=\"m-portlet__body\">	
									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
										<label class=\"col-lg-2 col-form-label\">Pilihan Program Studi 1</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi1>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>	
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tahun class=form-control m-input>\r\n              ";
												$i = 1901;
												while ( $i <= $waktu[year] + 5 )
												{
													if ( $i == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "<option {$selected} value='{$i}'>{$i}</option>";
													$selected = "";
													++$i;
												}
        echo "								</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text size=2 value='{$gelombang}' name=gelombang class=form-control m-input>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Mulai</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "mulai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Selesai</label>\r\n
										<label class=\"col-form-label\">
											".createinputtanggal( "selesai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Biaya Pendaftaran</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "biaya", "{$biaya}", "class=form-control m-input", "" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
        $q = "SELECT * FROM waktudaftarpmb ORDER BY TAHUN,GELOMBANG";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*printjudulmenukecil( "<b>Data Jadwal Pendaftaran PMB</b>" );
            echo "\r\n    <div class=portlet-body>
							<div class=table-responsive><table class=\"table table-striped table-bordered table-hover\">\r\n      <tr>\r\n      <thead>  <th>Tahun Masuk</th>\r\n        <th>Gelombang</th>\r\n        <th>Mulai</th>\r\n        <th>Selesai</th>\r\n        <td>Biaya</th>\r\n        <th>Tgl Update</th>\r\n        <th>Pengubah</th>\r\n        <th>Hapus</th>\r\n      </tr></thead>\r\n    ";
            */
			echo "			<div class='portlet-title'>";
								printmesg("Data Jadwal Pendaftaran PMB");
			echo "			</div>";
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														 <tr>
															<td>Tahun Masuk</td>\r\n        <td>Gelombang</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Biaya</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>
													</thead>
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
                echo "\r\n      <tr {$kelas}>\r\n        <td>{$d['TAHUN']} </td>\r\n        <td> {$d['GELOMBANG']} </td>\r\n        <td><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td><b>".cetakuang( $d[BIAYA] )."</td>\r\n        <td >{$d['LASTUPDATE']}</td>
				\r\n        <td>{$d['UPDATER']}</td>\r\n     
				<td><a class=\"btn red\" href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&gelombanghapus={$d['GELOMBANG']}&aksi=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus waktu KRS Online?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
            }
            #echo "</table></div></div></div></div></div>";
			echo "		</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->	
	</div>
	</div>
	</div>
	</div>	
		";
        }
        else
        {
            printmesg( "Data Jadwal Pendaftaran PMB Tidak Ada" );
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
