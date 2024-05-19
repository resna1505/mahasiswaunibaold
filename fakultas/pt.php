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
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $vld[] = cekvaliditasnama( "Nama", $nama, 64 );
        $vld[] = cekvaliditasnama( "Kota", $kota );
        $vld[] = cekvaliditasinteger( "Kode Pos", $kodepos );
        $vld[] = cekvaliditastelp( "Telepon", $telepon );
        $vld[] = cekvaliditastelp( "Faks", $faks );
        $vld[] = cekvaliditasemail( "Email", $email );
        $vld[] = cekvaliditastanggal( "Tanggal Awal Berdiri", $tgl1, $bln1, $thn1 );
        $vld[] = cekvaliditastanggal( "Tanggal Akta/SK", $tgla, $blna, $thna );
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
                unset( $vld );
            }    
        }
        else
        {
            $q = "\r\n    UPDATE mspti SET\r\n    KDYYSMSPTI='{$idy}',\r\n    KDPTIMSPTI='{$id}',\r\n    NMPTIMSPTI='{$nama}',\r\n    ALMT1MSPTI='{$alamat1}',\r\n    ALMT2MSPTI='{$alamat2}',\r\n    KOTAAMSPTI='{$kota}',\r\n    KDPOSMSPTI='{$kodepos}',\r\n    TELPOMSPTI='{$telepon}',\r\n    FAKSIMSPTI='{$faks}',\r\n    NOMSKMSPTI='{$nomorsk}',\r\n    EMAILMSPTI='{$email}',\r\n    HPAGEMSPTI='{$homepage}',\r\n    TGPTIMSPTI='{$thn1}-{$bln1}-{$tgl1}',\r\n    TGAWLMSPTI='{$thna}-{$blna}-{$tgla}'\r\n  ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Perguruan Tinggi berhasil disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Perguruan Tinggi", SIMPAN_DATA );
    }
}

printhelp( trim( $arrayhelp['pt'] ), "bantuan" );
#printmesg( $errmesg );
$q = "SELECT KDYYSMSYYS FROM msyys LIMIT 0,1";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$idy = $d['KDYYSMSYYS'];
$q = "SELECT * FROM mspti LIMIT 0,1";
$h = doquery($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO mspti (KDYYSMSYYS) VALUES (0) ";
    doquery($koneksi,$q);
    $q = "SELECT * FROM mspti LIMIT 0,1";
    $h = doquery($koneksi,$q);
}
$d = sqlfetcharray( $h );
$tmp = explode( "-", $d['TGPTIMSPTI'] );
$thn1 = $tmp[0];
$bln1 = $tmp[1];
$tgl1 = $tmp[2];
$tmp = explode( "-", $d['TGAWLMSPTI'] );
$thna = $tmp[0];
$blna = $tmp[1];
$tgla = $tmp[2];
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
/*echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=sessid value='{$token}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=100>Kode Badan Hukum    </td>\r\n    <td><input type=text size=7 name=idy value='{$idy}' readonly></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Kode PT    </td>\r\n    <td><input type=text size=6 name=id value='{$d['KDPTIMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Nama PT    </td>\r\n    <td><input type=text size=50 name=nama value='{$d['NMPTIMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Tanggal Awal Berdiri</td>\r\n    <td>\r\n    <input type=text size=2 name=tgla value='{$tgla}'>-\r\n    <input type=text size=2 name=blna value='{$blna}'>-\r\n    <input type=text size=4 name=thna value='{$thna}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Alamat</td>\r\n    <td><input type=text size=30 name=alamat1 value='{$d['ALMT1MSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Alamat (2)  </td>\r\n    <td><input type=text size=30 name=alamat2 value='{$d['ALMT2MSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Kota</td>\r\n    <td><input type=text size=20 name=kota value='{$d['KOTAAMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Kode Pos</td>\r\n    <td><input type=text size=5 name=kodepos value='{$d['KDPOSMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Telepon</td>\r\n    <td><input type=text size=20 name=telepon value='{$d['TELPOMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Faks</td>\r\n    <td><input type=text size=20 name=faks value='{$d['FAKSIMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td   nowrap>Nomor Akta/S.K. Pendirian</td>\r\n    <td><input type=text size=30 name=nomorsk value='{$d['NOMSKMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Tanggal Akta/S.K.</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl1 value='{$tgl1}'>-\r\n    <input type=text size=2 name=bln1 value='{$bln1}'>-\r\n    <input type=text size=4 name=thn1 value='{$thn1}'>\r\n    </td>\r\n  </tr>\r\n    <tr>\r\n    <td width=100>Email</td>\r\n    <td><input type=text size=40 name=email value='{$d['EMAILMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100>Homepage</td>\r\n    <td><input type=text size=40 name=homepage value='{$d['HPAGEMSPTI']}'></td>\r\n  </tr>\r\n  <tr>\r\n    <td width=100></td>\r\n    <td>\r\n    <br> ".IKONUPDATE48."\r\n\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  ></form>\r\n     </td>\r\n  </tr>\r\n  <tr>\r\n  <td colspan='2'><form action=cetakpt.php target=_blank method=post>\r\n    ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    </form></td>\r\n  </tr>\r\n</table>\r\n";
*/

echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Data Perguruan Tinggi");
								echo "	</div>";
	
echo "<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
					<div class=\"m-portlet__body\">		
						<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=sessid value='{$token}'>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Kode Badan Hukum</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=7 name=idy class=\"form-control m-input\" value='{$idy}' readonly>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode PT </label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=id class=\"form-control m-input\" value='{$d['KDPTIMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama PT </label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=nama class=\"form-control m-input\" value='{$d['NMPTIMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Awal Berdiri</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=2 name=tgla class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" value='{$tgla}'>
									<input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=blna value='{$blna}'>
									<input type=text size=4 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=thna value='{$thna}'>
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=alamat1 class=\"form-control m-input\" value='{$d['ALMT1MSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat (2)</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=alamat2 class=\"form-control m-input\" value='{$d['ALMT2MSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 name=kota class=\"form-control m-input\" value='{$d['KOTAAMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode Pos</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=5 name=kodepos class=\"form-control m-input\" value='{$d['KDPOSMSPTI']}'>
								</label>
							</div> 
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Telepon</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 name=telepon class=\"form-control m-input\" value='{$d['TELPOMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Faks</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=20 name=faks class=\"form-control m-input\" value='{$d['FAKSIMSPTI']}'>
								</label>
							</div> 
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nomor Akta / S.K. Pendirian</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=nomorsk class=\"form-control m-input\" value='{$d['NOMSKMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Akta / S.K.</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=2 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=tgl1 value='{$tgl1}'>
									<input type=text class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" size=2 name=bln1 value='{$bln1}'>
									<input type=text size=4 class=\"form-control m-input\" style=\"width:auto;display:inline-block;\" name=thn1 value='{$thn1}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Email</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=email class=\"form-control m-input\" value='{$d['EMAILMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\" >
								<label class=\"col-lg-2 col-form-label\">Homepage</label>\r\n    
								<label class=\"col-form-label\">
									<input type=text size=30 name=homepage class=\"form-control m-input\" value='{$d['HPAGEMSPTI']}'>
								</label>
							</div>
							<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Simpan name=aksi></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
						</div>						
				</form>
				<!--end::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=cetakpt.php target=\"_blank\" method=post>
					<div class=\"m-portlet__body\">	
						<div class=\"form-group m-form__group row\">
								<div class=\"col-lg-6\"><input type=submit name=aksi value=Cetak class=\"btn btn-success\"></div>
							</div>
					</div>
				</form>
			</div>
			<!--end::Portlet-->
					
				</div>
			</div>
		</div>
	</div>
		";
?>
