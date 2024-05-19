<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );

if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
	#echo "kkk";exit();
	#print_r($data);exit();
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
		
        $errmesg = token_err_mesg( "Mahasiswa", SIMPAN_DATA );
    }
    else
    {
		#echo "mm";exit();
        unset( $_SESSION['token'] );
        $vldts[] = cekvaliditasemail( "E-mail Pembayaran", $data[email2], 50, false );
        
        $vldts = array_filter( $vldts, "filter_not_empty" );
        if ( isset( $vldts ) && 0 < count( $vldts ) )
        {
            $errmesg = val_err_mesg( $vldts, 2, SIMPAN_DATA );
            unset( $vldts );
        }
        else
        {
	    #$digitpertama=substr(trim($data['hp']),0,1);
		#echo "digit=".$digitpertama;exit();
			#echo "vvv";exit();
            #cekhaktulis( $kodemenu );
           if ( trim( $data[email2] ) == "" )
	    {
		$errmesg .= "Email Pembayaran harus diisi<br>";
	    }	
	    	
	    else
            {
		
                $q = "UPDATE mahasiswa SET EMAIL2='{$data['email2']}' WHERE ID='{$idupdate}'";
				#echo $q.'<br>';
				doquery($koneksi,$q);
			
		if ( 0 < sqlaffectedrows( $koneksi ) )
                {
					
                    $ketlog = "Update data Email Pembayaran Mahasiswa dengan ID={$idupdate} ({$data['email2']})";
                    buatlog( 13 );
                    $errmesg = "Data Mahasiswa berhasil diupdate";
                    
            	}
             }
    	}
    }
	#$errmesg=$errmesg;
}
if ( $aksi == "formupdate" )
{
	#echo "aaaa";
	#echo $errmesg;
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.*,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR ,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    #echo $q;
	$h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg($errmesg);
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALSKPINDAHAN] );
        $tanggalskpindahan[thn] = $tmp[0];
        $tanggalskpindahan[tgl] = $tmp[2];
        $tanggalskpindahan[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKARTU] );
        $tanggalkartu[thn] = $tmp[0];
        $tanggalkartu[tgl] = $tmp[2];
        $tanggalkartu[bln] = $tmp[1];

	if(empty($d['IDCALONMAHASISWA'])){

		//ambil data ktp dari table mahasiswa
		$sql_mahasiswa_lama="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER,NISN FROM mahasiswa WHERE ID='{$d[ID]}'";
        	$h_mahasiswa_lama = mysqli_query($koneksi,$sql_mahasiswa_lama);
		$d_mahasiswa_lama = sqlfetcharray( $h_mahasiswa_lama );
		$KTP=$d_mahasiswa_lama['KTP'];
		$NISN=$d_mahasiswa_lama['NISN'];
		$KELURAHAN=$d_mahasiswa_lama['KELURAHAN'];
        	$KECAMATAN=$d_mahasiswa_lama['KECAMATAN'];
		$JASALMAMATER=$d_mahasiswa_lama['JASALMAMATER'];

	
	}else{
		//ambil data ktp dari table calon mahasiswa
		$sql_calon_mahasiswa="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER,NISN FROM calonmahasiswa WHERE ID='{$d[IDCALONMAHASISWA]}'";
        	#echo $sql_calon_mahasiswa;
		$h_calon_mahasiswa = mysqli_query($koneksi,$sql_calon_mahasiswa);
		$d_calon_mahasiswa = sqlfetcharray( $h_calon_mahasiswa );
		$KTP=$d_calon_mahasiswa['KTP'];
		$NISN=$d_calon_mahasiswa['NISN'];
		$KELURAHAN=$d_calon_mahasiswa['KELURAHAN'];
        	$KECAMATAN=$d_calon_mahasiswa['KECAMATAN'];
		$JASALMAMATER=$d_calon_mahasiswa['JASALMAMATER'];
	}
	

        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
		
        echo "	<br>
					<div class=\"m-portlet\">
						<!--begin::Form-->";
		echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>								
							".createinputhidden( "pilihan", $pilihan, "" ).
							createinputhidden( "aksi", "update", "" ).
							createinputhidden( "sessid", $_SESSION['token'], "" ).
							createinputhidden( "idupdate", "{$idupdate}", "" ).
							createinputhidden( "tab", "{$tab}", "" )."
							<div class=\"m-portlet__body\">	
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">E-mail Pembayaran</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[email2]", $d[EMAIL2], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\"></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
			</div>
		</form>
	<!--end::Form-->
</div>
<!--end::Portlet-->";
	}
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
