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
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT COUNT(*) AS JML FROM bayarkomponen WHERE IDKOMPONEN='{$idhapus}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    if ( 0 < $d[JML] )
    {
        $errmesg = "Data Komponen Pembayaran tidak dapat dihapus. Ada data pembayaran yang berkaitan langsung dengan komponen ini.";
    }
    else
    {
        $q = "DELETE FROM komponenpembayaran WHERE ID='{$idhapus}' AND ID!='98' AND ID!='99'";
        mysqli_query($koneksi,$q);
        buatlog( 14 );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ketlog = "Hapus Komponen Pembayaran dengan \r\n    \t\t\tID ={$idhapus}\r\n    \t\t\t";
            buatlog( 50 );
            $errmesg = "Data Komponen Pembayaran dengan ID = '{$idhapus}' berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Komponen Pembayaran dengan ID = '{$idhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" && $pilihan=="mlihat")
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" && ( $idupdate != 98 && $idupdate != 99 ) )
    {
        $errmesg = "Kode Komponen Pembayaran harus diisi";
    }
    else if ( trim( $data[nama] ) == "" && ( $idupdate != 98 && $idupdate != 99 ) )
    {
        $errmesg = "Nama Komponen Pembayaran harus diisi";
    }
    else
    {
        $ok = 1;
        if ( $labelspc != "" )
        {
            $q = "SELECT * FROM komponenpembayaran WHERE LABELSPC='{$labelspc}' AND ID!='{$idupdate}' LIMIT 0,1";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $errmesg = "Label SCP sudah digunakan oleh komponen yang lain.";
                $ok = 0;
            }
        }
        if ( $ok == 1 )
        {
            if ( $idupdate != 98 && $idupdate != 99 )
            {
                $q = "\r\n    \t\t\tUPDATE komponenpembayaran SET \r\n     \t\t\tNAMA='{$data['nama']}',\r\n     \t\t\tLABELSPC='{$labelspc}',\r\n    \t\t \r\n    \t\t\tJENIS='{$data['jenis']}',KODEBANK='{$data['kode_bank']}',KODEREKENING='{$data['kode_rekening']}' WHERE ID='{$idupdate}'\r\n    \t\t";
            }
            else
            {
                $q = "\r\n    \t\t\tUPDATE komponenpembayaran SET \r\n      \t\t\tLABELSPC='{$labelspc}',KODEBANK='{$data['kode_bank']}',KODEREKENING='{$data['kode_rekening']}' WHERE ID='{$idupdate}'";
            }
            mysqli_query($koneksi,$q);
            buatlog( 13 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Update Komponen Pembayaran dengan \r\n\t\t\tID ={$idupdate} ({$data['nama']})\r\n\t\t\t";
                buatlog( 49 );
                $errmesg = "Data Komponen Pembayaran berhasil diupdate";
                $q = "\r\n      INSERT INTO `akun` (`ID`, `NAMA`, `SUBID`, `UNTUK`, `UNTUKNERACA`, `KONTRAID`, `TINGKAT`, `SUBUNTUKNERACA`, `UNTUKRUGILABA`, `AWAL`, `SAATINI`, `TGLAWAL`) VALUES\r\n('".$arrayakun[pendapatan]."-{$id}', '{$data['nama']}', '".$arrayakun[pendapatan]."', '1', '0', '', '1', '1', '0', 0, 0, CURDATE()) \r\n      ";
                mysqli_query($koneksi,$q);
                if ( $id != $idupdate )
                {
                    $idupdate = $id;
                }
                $data[password] = "";
                foreach ( $arrayprodidep as $k => $v )
                {
                    if ( $dataprodi[$k] == 1 )
                    {
                        $q = "REPLACE INTO komponenpembayaran_prodi (IDKOMPONEN,IDPRODI) VALUES ('{$id}','{$k}')";
                        mysqli_query($koneksi,$q);
                    }
                    else
                    {
                        $q = "DELETE FROM komponenpembayaran_prodi WHERE   IDKOMPONEN='{$id}' AND IDPRODI='{$k}' ";
                        mysqli_query($koneksi,$q);
                    }
                }
            }
            else
            {
                $errmesg = "Data Komponen Pembayaran tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}

if ( $aksi == "update" && $pilihan=="mlihat2")
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" && ( $idupdate != 98 && $idupdate != 99 ) )
    {
        $errmesg = "Kode Komponen Pembayaran harus diisi";
    }
    else if ( trim( $data[nama] ) == "" && ( $idupdate != 98 && $idupdate != 99 ) )
    {
        $errmesg = "Nama Komponen Pembayaran harus diisi";
    }
    else
    {
        $ok = 1;
        if ( $labelspc != "" )
        {
            $q = "SELECT * FROM komponenpembayaran WHERE LABELSPC='{$labelspc}' AND ID!='{$idupdate}' LIMIT 0,1";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $errmesg = "Label SCP sudah digunakan oleh komponen yang lain.";
                $ok = 0;
            }
        }
        if ( $ok == 1 )
        {
            if ( $idupdate != 98 && $idupdate != 99 )
            {
                $q = "\r\n    \t\t\tUPDATE komponenpembayaran SET \r\n     \t\t\tNAMA='{$data['nama']}',\r\n     \t\t\tLABELSPC='{$labelspc}',\r\n    \t\t \r\n    \t\t\tJENIS='{$data['jenis']}',KODEBANK='{$data['kode_bank']}',KODEREKENING='{$data['kode_rekening']}',KODEBANK2='{$data['kode_bank2']}',KODEREKENING2='{$data['kode_rekening2']}',SECRETKEY='{$data['SECRETKEY']}' WHERE ID='{$idupdate}'\r\n    \t\t";
            }
            else
            {
                $q = "\r\n    \t\t\tUPDATE komponenpembayaran SET \r\n      \t\t\tLABELSPC='{$labelspc}',KODEBANK='{$data['kode_bank']}',KODEREKENING='{$data['kode_rekening']}',KODEBANK2='{$data['kode_bank2']}',KODEREKENING2='{$data['kode_rekening2']}',SECRETKEY='{$data['SECRETKEY']}' WHERE ID='{$idupdate}'";
            }
		#echo $q.'<br>';exit();
            mysqli_query($koneksi,$q);
            buatlog( 13 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Update Komponen Pembayaran dengan \r\n\t\t\tID ={$idupdate} ({$data['nama']})\r\n\t\t\t";
                buatlog( 49 );
                $errmesg = "Data Komponen Pembayaran berhasil diupdate";
                $q = "\r\n      INSERT INTO `akun` (`ID`, `NAMA`, `SUBID`, `UNTUK`, `UNTUKNERACA`, `KONTRAID`, `TINGKAT`, `SUBUNTUKNERACA`, `UNTUKRUGILABA`, `AWAL`, `SAATINI`, `TGLAWAL`) VALUES\r\n('".$arrayakun[pendapatan]."-{$id}', '{$data['nama']}', '".$arrayakun[pendapatan]."', '1', '0', '', '1', '1', '0', 0, 0, CURDATE()) \r\n      ";
                mysqli_query($koneksi,$q);
                if ( $id != $idupdate )
                {
                    $idupdate = $id;
                }
                $data[password] = "";
                
            }
            else
            {
                $errmesg = "Data Komponen Pembayaran tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
    $pilihan="mlihat2";	
}


if ( $aksi == "formupdate" && $pilihan=="mlihat" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT *\r\n\tFROM komponenpembayaran  WHERE \r\n\tkomponenpembayaran.ID='{$idupdate}'\r\n\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Komponen Pembayaran" );
        #printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
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
                                <span class=\"caption-subject bold uppercase\"> Update Data Komponen Pembayaran </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Update Data Komponen Pembayaran");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
        echo "				<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							".createinputhidden( "pilihan", $pilihan, "" ).
							createinputhidden( "aksi", "update", "" ).
							createinputhidden( "idupdate", "{$idupdate}", "" )."
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kode Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "id", "{$idupdate}", " class=form-control m-input  size=10 readonly" )."
									</label>
								</div>";
        if ( $idupdate != 98 && $idupdate != 99 )
        {
            echo "\r\n      \t\t<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nama]", $d[NAMA], " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[jenis]", $arrayjenispembayaran, "{$d['JENIS']}", "", " class=form-control m-input  " )."
									</label>
								</div> ";
        }
        else
        {
            echo "\r\n      \t\t <div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">>Nama Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										{$d['NAMA']} 
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<label class=\"col-form-label\">
										".$arrayjenispembayaran[$d[JENIS]]."
									</label>
								</div>";
        }
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Label Kolom SPC</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "labelspc", $arraykolomspc, "{$d['LABELSPC']}", "", " class=form-control m-input   " )." 
									</label>
								</div>
								<!--<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Kode Bank Mandiri *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_bank]", $d['KODEBANK'], " class=form-control m-input  size=5 maxlength=5" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Rekening Mandiri *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_rekening]", $d['KODEREKENING'], " class=form-control m-input  size=5 maxlength=1" )."
										</label>
									</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Kode Bank BNI *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_bank]", $d['KODEBANK'], " class=form-control m-input  size=5 maxlength=5" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Rekening Mandiri *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_rekening]", $d['KODEREKENING'], " class=form-control m-input  size=5 maxlength=1" )."
										</label>
									</div>-->

								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Digunakan di Program Studi</label>\r\n    
									<div class=\"col-lg-8\">
										<div class=\"m-checkbox-list\">";
        $q = "SELECT * FROM komponenpembayaran_prodi WHERE IDKOMPONEN='{$idupdate}'";
        $h = mysqli_query($koneksi,$q);
		if(0 < sqlnumrows( $h )){
			while ( $d = sqlfetcharray( $h ) )
			{
				$dataprodi[$d[IDPRODI]] = 1;
			}
		}
        foreach ( $arrayprodidep as $k => $v )
        {
            $cek = "";
            if ( $dataprodi[$k] == 1 )
            {
                $cek = "checked";
            }
            #echo "\r\n          <input type=checkbox name='dataprodi[{$k}]' value=1 {$cek} > {$v} <br>\r\n        ";
			echo "								<label class=\"m-checkbox\">";
			echo "									<input type=checkbox name='dataprodi[{$k}]' value=1 checked> {$v}";
			echo "									<span></span>";
			echo "								</label>";
        }
        echo "								</div>
										</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\">
										<input type=reset value='Reset' class=\"btn btn-brand\">
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
    else
    {
        $errmesg = "Data Komponen Pembayaran dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}

if ( $aksi == "formupdate" && $pilihan=="mlihat2" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT *\r\n\tFROM komponenpembayaran  WHERE \r\n\tkomponenpembayaran.ID='{$idupdate}'\r\n\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Komponen Pembayaran" );
        #printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
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
                                <span class=\"caption-subject bold uppercase\"> Update Data Komponen Pembayaran </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Update Data Komponen Pembayaran");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
        echo "				<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							".createinputhidden( "pilihan", $pilihan, "" ).
							createinputhidden( "aksi", "update", "" ).
							createinputhidden( "idupdate", "{$idupdate}", "" )."
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kode Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "id", "{$idupdate}", " class=form-control m-input  size=10 readonly" )."
									</label>
								</div>";
        if ( $idupdate != 98 && $idupdate != 99 )
        {
            echo "\r\n      \t\t<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nama]", "{$d['NAMA']}", " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[jenis]", $arrayjenispembayaran, "{$d['JENIS']}", "", " class=form-control m-input  " )."
									</label>
								</div> ";
        }
        else
        {
            echo "\r\n      \t\t <div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">>Nama Komponen  *</label>\r\n    
									<label class=\"col-form-label\">
										{$d['NAMA']} 
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<label class=\"col-form-label\">
										".$arrayjenispembayaran[$d['JENIS']]."
									</label>
								</div>";
        }
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Label Kolom SPC</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "labelspc", $arraykolomspc, "{$d['LABELSPC']}", "", " class=form-control m-input   " )." 
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Kode Bank Mandiri *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_bank]", $d['KODEBANK'], " class=form-control m-input  size=5 maxlength=5" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Rekening Mandiri *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_rekening]", $d['KODEREKENING'], " class=form-control m-input  size=5 maxlength=1" )."
										</label>
									</div>

								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Prefix BNI *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_bank2]", $d['KODEBANK2'], " class=form-control m-input  size=5 maxlength=3" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Client ID BNI *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_rekening2]", $d['KODEREKENING2'], " class=form-control m-input  size=8 maxlength=5" )."
										</label>
									</div>
								<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Secret Key BNI *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[SECRETKEY]", $d['SECRETKEY'], " class=form-control m-input  size=30 " )."
										</label>
									</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\">
										<input type=reset value='Reset' class=\"btn btn-brand\">
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
    else
    {
        $errmesg = "Data Komponen Pembayaran dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}

if ( $aksi == "tambah" )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" || trim( $id ) == 99 )
    {
        $errmesg = "Kode Komponen Pembayaran harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Komponen Pembayaran harus diisi";
    }
    else
    {
        $ok = 1;
        if ( $labelspc != "" )
        {
            $q = "SELECT * FROM komponenpembayaran WHERE LABELSPC='{$labelspc}' AND ID!='{$id}' LIMIT 0,1";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $errmesg = "Label SCP sudah digunakan oleh komponen yang lain.";
                $ok = 0;
            }
        }
        if ( $ok == 1 )
        {
            $q = "\r\n      \t\t\tINSERT INTO komponenpembayaran (ID,NAMA,JENIS,LABELSPC,KODEBANK,KODEREKENING) \r\n      \t\t\tVALUES ('{$id}','{$data['nama']}','{$data['jenis']}','{$labelspc}','{$kode_bank}','{$kode_rekening}')\r\n      \t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                foreach ( $arrayprodidep as $k => $v )
                {
                    if ( $dataprodi[$k] == 1 )
                    {
                        $q = "REPLACE INTO komponenpembayaran_prodi (IDKOMPONEN,IDPRODI) VALUES ('{$id}','{$k}')";
                        mysqli_query($koneksi,$q);
                    }
                    else
                    {
                        $q = "DELETE FROM komponenpembayaran_prodi WHERE   IDKOMPONEN='{$id}' AND IDPRODI='{$k}' ";
                        mysqli_query($koneksi,$q);
                    }
                }
                $ketlog = "Tambah Komponen Pembayaran dengan \r\n      \t\t\tID ={$idupdate} ({$data['nama']})\r\n      \t\t\t";
                buatlog( 48 );
                $errmesg = "Data Komponen Pembayaran berhasil ditambah";
                $q = "\r\n            INSERT INTO `akun` (`ID`, `NAMA`, `SUBID`, `UNTUK`, `UNTUKNERACA`, `KONTRAID`, `TINGKAT`, `SUBUNTUKNERACA`, `UNTUKRUGILABA`, `AWAL`, `SAATINI`, `TGLAWAL`) VALUES\r\n      ('".$arrayakun[pendapatan]."-{$id}', '{$data['nama']}', '".$arrayakun[pendapatan]."', '1', '0', '', '1', '1', '0', 0, 0, CURDATE()) \r\n            ";
                mysqli_query($koneksi,$q);
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Komponen Pembayaran tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Tambah Data Komponen Pembayaran");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "pilihan", $pilihan, "" ).
								 createinputhidden( "aksi", "tambah", "" )."
								 <div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">ID Komponen *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $id, " class=form-control m-input  size=5" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama Komponen *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[nama]", "", " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "data[jenis]", $arrayjenispembayaran, "", "", " class=form-control m-input   " )."  
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Label Kolom SPC</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "labelspc", $arraykolomspc, "{$labelspc}", "", " class=form-control m-input   " )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Kode Bank *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_bank]", "", " class=form-control m-input  size=5 maxlength=5" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Rekening *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[kode_rekening]", "", " class=form-control m-input  size=5 maxlength=1" )."
										</label>
									</div>
									
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Digunakan di Program Studi</label>\r\n    
										<div class=\"col-lg-8\">
											<div class=\"m-checkbox-list\">";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "	<label class=\"m-checkbox\">";
													echo "		<input type=checkbox name='dataprodi[{$k}]' value=1 checked> {$v}";
													echo "		<span></span>";
													echo "	</label>";
												}
    echo "									</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tambah' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-brand\">
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
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    if($pilihan=="mlihat"){	
    	include( "prosestampilmahasiswa.php" );
    }else{
    	include( "prosestampilmahasiswa2.php" );
    }
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Komponen Pembayaran " );
    /*printmesg( $errmesg );
    echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Lihat Data Komponen Pembayaran </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Lihat Data Komponen Pembayaran");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Kode</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $id, " class=form-control m-input  size=20" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
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
