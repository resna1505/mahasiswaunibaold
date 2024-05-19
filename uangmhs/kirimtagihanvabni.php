<?php
if($aksi2=="kirimdata"){
		#echo "kesini";exit();
		
		include_once __DIR__ . '/BniEnc.php';

		// FROM BNI
		$client_id = $client_id;
		#$client_id = '55557';
		$qSecret = "SELECT SECRETKEY FROM komponenpembayaran WHERE 1=1 AND KODEREKENING2='{$client_id}'";
		echo $qSecret.'<br>';
		$hSecret = doquery($koneksi,$qSecret);
		$dSecret = sqlfetcharray($hSecret);
		$secret_key=$dSecret['SECRETKEY'];
		echo "SECRET=".$secret_key.'<br>';
		#$secret_key='34a8801926aaf9f5bd1001e8707b5f5f';
		#echo $secret_key;exit();
		#$customer_name=str_replace(" ", "-", $customer_name);
		#$customer_name=trim($customer_name);
		$url = 'https://apibeta.bni-ecollection.com/';
		#$url = 'https://api.bni-ecollection.com/';
		$waktu_berakhir_tagihan=$dateexpired.' '.$timeexpired;
		$data_asli = array(
			'type' => $type,
			'client_id' => $client_id,
			'trx_id' => $trx_id, // fill with Billing ID
			'trx_amount' => $trx_amount,
			'billing_type' => $billing_type,
			'datetime_expired' => $waktu_berakhir_tagihan, // billing will be expired in 2 hours
			'virtual_account' => $virtual_account,
			'customer_name' => $customer_name,
			'customer_email' => '',
			'customer_phone' => '',
		);
		print_r($data_asli);
		#echo '<br>';
		#exit();
		$hashed_string = BniEnc::encrypt(
			$data_asli,
			$client_id,
			$secret_key
		);

		$data = array(
			'client_id' => $client_id,
			'data' => $hashed_string,
		);
		
		print_r($data);
		echo '<br>';

		$response = get_content($url, json_encode($data));
		print_r($response);
		echo '<br>';
		
		$response_json = json_decode($response, true);
		print_r($response_json);
		echo '<br>';
		if ($response_json['status'] !== '000') {
			// handling jika gagal
			var_dump($response_json);
			#$errmesg = var_dump($response_json);
			$errmesg = "Data Tidak Berhasil Dikirim, Keterangan : ".$response_json['message'];
		}
		else {
			$data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
			// $data_response will contains something like this: 
			// array(
			// 	'virtual_account' => 'xxxxx',
			// 	'trx_id' => 'xxx',
			// );
			#var_dump($data_response);
			#$errmesg = var_dump($data_response);
			$query = "UPDATE buattagihanvabni SET STATUS='2',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID = '{$trx_id}' AND VANUMB='{$virtual_account}'";
			echo $query.'<br>';
			doquery($koneksi,$query);
			$errmesg = "Data Berhasil Dikirim";
		}
		#echo $tgl_tagihan;exit();
		$tanggal=$tgl_tagihan;
		$angkatancari=$angkatan_mhs;
		$idprodicari=$prodi_mhs;
		$koderekening2=$client_id;
		$statuskirim=$statuskirim;
		$aksi = "tampilkan";
}

if($aksi2=="kirimulang"){
		#echo "kesini";exit();
		include_once __DIR__ . '/BniEnc.php';

		// FROM BNI
		$client_id = $client_id;
		#$client_id = '';
		$qSecret = "SELECT SECRETKEY FROM komponenpembayaran WHERE 1=1 AND KODEREKENING2='{$client_id}'";
		$hSecret = doquery($koneksi,$qSecret);
		$dSecret = sqlfetcharray($hSecret);
		$secret_key=$dSecret['SECRETKEY'];
		#$secret_key = '34a8801926aaf9f5bd1001e8707b5f5f';
		
		$url = 'https://apibeta.bni-ecollection.com/';
		#$url = 'https://api.bni-ecollection.com/';
		$waktu_berakhir_tagihan=$dateexpired.' '.$timeexpired;
		$data_asli = array(
			'type' => $type,
			'client_id' => $client_id,
			'trx_id' => $trx_id, // fill with Billing ID
			'trx_amount' => $trx_amount,
			'billing_type' => $billing_type,
			'datetime_expired' => $waktu_berakhir_tagihan, // billing will be expired in 2 hours
			'customer_name' => $customer_name,
			'customer_email' => '',
			'customer_phone' => '',
		);
		print_r($data_asli);
		echo '<br>';
		#exit();
		$hashed_string = BniEnc::encrypt(
			$data_asli,
			$client_id,
			$secret_key
		);

		$data = array(
			'client_id' => $client_id,
			'data' => $hashed_string,
		);
		
		print_r($data);
		echo '<br>';

		$response = get_content($url, json_encode($data));
		print_r($response);
		echo '<br>';
		
		$response_json = json_decode($response, true);
		print_r($response_json);
		echo '<br>';

		#exit();
		if ($response_json['status'] !== '000') {
			// handling jika gagal
			#var_dump($response_json);
			#$errmesg = var_dump($response_json);
			$errmesg = "Data Tidak Berhasil Dikirim, Keterangan : ".$response_json['message'];
		}
		else {
			$data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
			// $data_response will contains something like this: 
			// array(
			// 	'virtual_account' => 'xxxxx',
			// 	'trx_id' => 'xxx',
			// );
			#var_dump($data_response);
			#$errmesg = var_dump($data_response);
			$query = "UPDATE buattagihanvabni SET STATUS='4',IDUSER='{$users}',TGLUPDATE=NOW() WHERE TRXID = '{$trx_id}' AND VANUMB='{$virtual_account}'";
			#echo $query.'<br>';
			doquery($koneksi,$query);
			$errmesg = "Data Berhasil Di Update";
		}
		#echo $tgl_tagihan;exit();
		$tanggal=$tgl_tagihan;
		$angkatancari=$angkatan_mhs;
		$idprodicari=$prodi_mhs;
		$statuskirim=$statuskirim;
		$koderekening2=$client_id;
		$aksi = "tampilkan";
}

if ( $aksi == "tampilkan" )
{
	#echo "aaa";exit();
    $aksi = "";
	
		#echo "masuk";exit();
		include("prosestampilkirimtagihanvabni.php");
	
}

if ( $aksi == "" )
{
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    
	
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL ".
	"FROM buattagihanvabni WHERE 1=1 GROUP BY TANGGALTAGIHAN ORDER BY TANGGALTAGIHAN DESC";
	echo "TAGIHAN BNI=".$q.'<br>';
   
$h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d['TANGGALTAGIHAN']] = $d;
        }
        $jeniskolom = $d['JENISKOLOM'];
        $strunduh = str_replace( "name=jeniskolom value=\"\"", "name=jeniskolom value=\"{$jeniskolom}\"", $strunduh );
       
		echo "			<div class='portlet-title'>";
								printtitle("Kirim Data Tagihan VA BNI");
		echo "			</div>";
        echo "			<form method=post action=index.php class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
									<label class=\"col-form-label\">
										<select name=tanggal class=form-control m-input>";
											foreach ( $arraytagihan as $k => $v )
											{
												echo "<option value='{$k}'>{$v['TGL']}</option>";
											}
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\"> <br>\r\n            <input type=radio name=jenisfile value=\"HTML\"> HTML   <br>\r\n            <input type=radio name=jenisfile value=\"EXCEL\"> Excel \r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr><tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\      <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        echo "              		</select>
									</label>
								</div>";
		echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodicari>
											<!--<option value=''>Semua</option>-->";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Kode Rekening</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=koderekening2>
											<!--<option value=''>Semua</option>-->";
											foreach ( $arrayrekening2 as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
	echo "								</select>
									</label>
								</div>";
	echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Status Kirim</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=statuskirim>
											<option value=''>All</option>
											<option value='0'>Kirim Data Baru</option>
											<option value='2'>Kirim Ulang Data</option>
											<option value='4'>Berhasil Kirim Ulang</option>";										
	echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">											
											<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>
										</div>
									</label>
								</div>
							</div>
						</form>";
            
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
     echo "
					</div>
				</div>
			</div>
		</div>";
    }
}
?>
