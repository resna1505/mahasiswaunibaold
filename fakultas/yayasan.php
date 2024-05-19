<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
cekhaktulis( $kodemenu );
#echo "AKSI=".$aksi;
if ( $aksi == "Simpan" )
{
	#echo "mmm";exit();
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
		#$thn2=$_POST['thn2'];
		#$bln2=$_POST['bln2'];
		#$tgl2=$_POST['tgl2'];	
        if ( $thn2 == "" || $bln2 == "" || $tgl2 == "" )
        {
            $tanggal2 = "NULL";
        }
        else
        {
            $tanggal2 = "'{$thn2}-{$bln2}-{$tgl2}'";
        }
        $vld[] = cekvaliditaskode( "Kode Badan Hukum", $id, 10, false );
        $vld[] = cekvaliditasnama( "Nama", $nama, 64, false );
        $vld[] = cekvaliditastanggal( "Tanggal Awal Berdiri", $tgla, $blna, $thna );
        $vld[] = cekvaliditasnama( "Kota", $kota );
        $vld[] = cekvaliditasinteger( "Kode Pos", $kodepos );
        $vld[] = cekvaliditastelp( "Telepon", $telepon );
        $vld[] = cekvaliditastelp( "Faks", $faks );
        $vld[] = cekvaliditaskode( "No SK. Terakhir", $nomorsk, 32 );
        $vld[] = cekvaliditastanggal( "Tanggal Akta Terakhir", $tgl1, $bln1, $thn1 );
        $vld[] = cekvaliditaskode2( "Nomor Pengesahan", $nomor2, 32 );
        $vld[] = cekvaliditastanggal( "Tanggal Pengesahan", $tgl2, $bln2, $thn2 );
        $vld[] = cekvaliditasemail( "Email", $email );
        $vld[] = cekvaliditasweb( "Homepage", $homepage );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            foreach($vld as $v) {
                if($v=="Email") {
                    $errmesg = val_err_mesg( $vld, 3, SIMPAN_DATA );
                }
                else {
                    $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
                }    
            }    
            unset( $vld );
        }
        else
        {
            $q = "\r\n\t\t    UPDATE msyys SET\r\n\t\t    KDYYSMSYYS='{$id}',\r\n\t\t    NMYYSMSYYS='{$nama}',\r\n\t\t    ALMT1MSYYS='{$alamat1}',\r\n\t\t    ALMT2MSYYS='{$alamat2}',\r\n\t\t    KOTAAMSYYS='{$kota}',\r\n\t\t    KDPOSMSYYS='{$kodepos}',\r\n\t\t    TELPOMSYYS='{$telepon}',\r\n\t\t    FAKSIMSYYS='{$faks}',\r\n\t\t    NOMSKMSYYS='{$nomorsk}',\r\n\t\t    NOMBNMSYYS='{$nomor2}',\r\n\t\t    EMAILMSYYS='{$email}',\r\n\t\t    HPAGEMSYYS='{$homepage}',\r\n\t\t    TGYYSMSYYS='{$thn1}-{$bln1}-{$tgl1}',\r\n\t\t    TGLBNMSYYS={$tanggal2},\r\n\t\t    TGAWLMSYYS='{$thna}-{$blna}-{$tgla}'\r\n\t\t  ";
           # echo $q;exit();
			doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Badan Hukum berhasil disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( $vld, 2, SIMPAN_DATA );
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
#printjudulmenu( "Data Badan Hukum", "bantuan" );
#printhelp( trim( $arrayhelp[yayasan] ), "bantuan" );
#printmesg( $errmesg );
$q = "SELECT * FROM msyys LIMIT 0,1";
$h = doquery($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO msyys (KDYYSMSYYS) VALUES (0) ";
    doquery($koneksi,$q);
    $q = "SELECT * FROM msyys LIMIT 0,1";
    $h = doquery($koneksi,$q);
}
$d = sqlfetcharray( $h );
$tmp = explode( "-", $d['TGYYSMSYYS'] );
$thn1 = $tmp[0];
$bln1 = $tmp[1];
$tgl1 = $tmp[2];
$tmp = explode( "-", $d['TGLBNMSYYS'] );
$thn2 = $tmp[0];
$bln2 = $tmp[1];
$tgl2 = $tmp[2];
$tmp = explode( "-", $d['TGAWLMSYYS'] );
$thna = $tmp[0];
$blna = $tmp[1];
$tgla = $tmp[2];
#echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n<table class=form>\r\n  <tr>\r\n    <td width=100>Kode Badan Hukum    </td>\r\n    <td><input type=text size=7 name=id value='{$d['KDYYSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Nama Badan Hukum    </td>\r\n    <td><input type=text size=50 name=nama value='{$d['NMYYSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Tanggal Awal Berdiri</td>\r\n    <td>\r\n    <input type=text size=2 name=tgla value='{$tgla}'>-\r\n    <input type=text size=2 name=blna value='{$blna}'>-\r\n    <input type=text size=4 name=thna value='{$thna}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Alamat</td>\r\n    <td><input type=text size=30 name=alamat1 value='{$d['ALMT1MSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Alamat (2)  </td>\r\n    <td><input type=text size=30 name=alamat2 value='{$d['ALMT2MSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Kota</td>\r\n    <td><input type=text size=20 name=kota value='{$d['KOTAAMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Kode Pos</td>\r\n    <td><input type=text size=5 name=kodepos value='{$d['KDPOSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Telepon</td>\r\n    <td><input type=text size=20 name=telepon value='{$d['TELPOMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Faks</td>\r\n    <td><input type=text size=20 name=faks value='{$d['FAKSIMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td  nowrap>Nomor Akta Terakhir</td>\r\n    <td><input type=text size=30 name=nomorsk value='{$d['NOMSKMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td nowrap>Tanggal Akta Terakhir</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl1 value='{$tgl1}'>-\r\n    <input type=text size=2 name=bln1 value='{$bln1}'>-\r\n    <input type=text size=4 name=thn1 value='{$thn1}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Nomor Pengesahan</td>\r\n    <td><input type=text size=30 name=nomor2 value='{$d['NOMBNMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Tanggal Pengesahan</td>\r\n    <td>    \r\n    <input type=text size=2 name=tgl2 value='{$tgl2}'>-\r\n    <input type=text size=2 name=bln2 value='{$bln2}'>-\r\n    <input type=text size=4 name=thn2 value='{$thn2}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Email</td>\r\n    <td><input type=text size=40 name=email value='{$d['EMAILMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Homepage</td>\r\n    <td><input type=text size=40 name=homepage value='{$d['HPAGEMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n  <tr>\r\n    <td colspan='2'><form action=cetakbh.php target=_blank method=post>\r\n    ".IKONCETAK32." <input type=submit name=aksi value=Cetak>\r\n    </form></td>\r\n  </tr>\r\n</table>\r\n\r\n\r\n";

echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">
						
							<!-- BEGIN SAMPLE FORM PORTLET-->
							";
								printmesg( $errmesg );
								echo "
											<div class='portlet-title'>";
												printtitle("Data Yayasan / Badan Hukum");
								echo "		</div>";									
											/*echo "<div class='portlet-body form'>
												<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n<div class=\"portlet-body\">
													<div class=\"table-scrollable\">
														<table class=\"table table-striped table-bordered table-hover\">\r\n  <tr>\r\n    <td>Kode Badan Hukum    </td>\r\n    <td><input type=text style='width:auto;' name=id value='{$d['KDYYSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Nama Badan Hukum    </td>\r\n    <td><input type=text style='width:auto;' name=nama value='{$d['NMYYSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Tanggal Awal Berdiri</td>\r\n    <td>\r\n    <input type=text size=2 name=tgla value='{$tgla}'>-\r\n    <input type=text size=2 name=blna value='{$blna}'>-\r\n    <input type=text size=4 name=thna value='{$thna}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td>Alamat</td>\r\n    <td><input type=text style='width:auto;' name=alamat1 value='{$d['ALMT1MSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Alamat (2)  </td>\r\n    <td><input type=text style='width:auto;' name=alamat2 value='{$d['ALMT2MSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Kota</td>\r\n    <td><input type=text style='width:auto;' name=kota value='{$d['KOTAAMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Kode Pos</td>\r\n    <td><input type=text style='width:auto;' name=kodepos value='{$d['KDPOSMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Telepon</td>\r\n    <td><input type=text style='width:auto;' name=telepon value='{$d['TELPOMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Faks</td>\r\n    <td><input type=text style='width:auto;' name=faks value='{$d['FAKSIMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td  nowrap>Nomor Akta Terakhir</td>\r\n    <td><input type=text style='width:auto;' name=nomorsk value='{$d['NOMSKMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td nowrap>Tanggal Akta Terakhir</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl1 value='{$tgl1}'>-\r\n    <input type=text size=2 name=bln1 value='{$bln1}'>-\r\n    <input type=text size=4 name=thn1 value='{$thn1}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td>Nomor Pengesahan</td>\r\n    <td><input type=text style='width:auto;' name=nomor2 value='{$d['NOMBNMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Tanggal Pengesahan</td>\r\n    <td>    \r\n    <input type=text size=2 name=tgl2 value='{$tgl2}'>-\r\n    <input type=text size=2 name=bln2 value='{$bln2}'>-\r\n    <input type=text size=4 name=thn2 value='{$thn2}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Email</td>\r\n    <td><input type=text style='width:auto;' name=email value='{$d['EMAILMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Homepage</td>\r\n    <td><input type=text style='width:auto;' name=homepage value='{$d['HPAGEMSYYS']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td></td>\r\n    <td>  <input type=\"submit\" class=\"btn btn-brand\" value=Simpan name=aksi></input>
															<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input> </td> \r\n  </tr>\r\n  <tr>\r\n    <td colspan='2'><form action=cetakbh.php target=_blank method=post><input type=submit name=aksi value=Cetak class=\"btn btn-brand\"></td>\r\n  </tr>
														</table>
													</div>
												</form>
											</div>
										</div>
							</div>
						</div>
					</div>
				</div>
		</div>";*/
		echo "<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
					<div class=\"m-portlet__body\">		
						<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-md-2 col-form-label\">Kode Badan Hukum</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=7 name=id class=\"form-control m-input\" value='{$d['KDYYSMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Nama Badan Hukum </label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=nama value='{$d['NMYYSMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Awal Berdiri</label>\r\n    
								<label class=\"col-form-label\"><input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=tgla value='{$tgla}'> - <input type=text size=2 name=blna class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" value='{$blna}'> - <input type=text size=4 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=thna value='{$thna}'>\r\n    </div>\r\n  
							</div>		
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=alamat1 value='{$d['ALMT1MSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Alamat (2)</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=alamat2 value='{$d['ALMT2MSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 class=\"form-control m-input\" name=kota value='{$d['KOTAAMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Kode Pos</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=5 class=\"form-control m-input\" name=kodepos value='{$d['KDPOSMSYYS']}'>
								</label>
							</div> 
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Telepon</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 class=\"form-control m-input\" name=telepon value='{$d['TELPOMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Faks</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 class=\"form-control m-input\" name=faks value='{$d['FAKSIMSYYS']}'>
								</label>
							</div> 
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Nomor Akta Terakhir</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=nomorsk value='{$d['NOMSKMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Akta Terakhir</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=tgl1 value='{$tgl1}'> - <input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=bln1 value='{$bln1}'> - <input type=text class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" size=4 name=thn1 value='{$thn1}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Nomor Pengesahan</label>\r\n    
								<div class=\"col-lg-6\"><input type=text size=30 class=\"form-control m-input\" name=nomor2 value='{$d['NOMBNMSYYS']}'></div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Pengesahan</label>\r\n    
								<label class=\"col-form-label\">  
									<input type=text size=2 name=tgl2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" value='{$tgl2}'>
									<input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=bln2 value='{$bln2}'>
									<input type=text size=4 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=thn2 value='{$thn2}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Email</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=email value='{$d['EMAILMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Homepage</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 class=\"form-control m-input\" name=homepage value='{$d['HPAGEMSYYS']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n  
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Simpan name=aksi></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>	
					<!--end::Portlet Body-->
				</form>
				<!--end::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=cetakbh.php target=\"_blank\" method=post style=\"background-color:#d8e2f7;\">
					<div class=\"m-portlet__body\">	
						<div class=\"form-group m-form__group row\">
								<div class=\"col-lg-6\"><input type=submit name=aksi value=Cetak class=\"btn btn-success\"></div>
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
		<!--end::container-fluid-->";
?>
