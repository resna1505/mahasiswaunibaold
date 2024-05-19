<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#echo "  ";
periksaroot( );
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "SELECT COUNT(*) AS JML FROM mahasiswa WHERE IDPRODI='{$idhapus}'";
        $h = doquery($koneksi, $q );
        $d = sqlfetcharray( $h );
        $dataterkait = $d['JML'];
        $q = "SELECT COUNT(*) AS JML FROM dosen WHERE IDDEPARTEMEN='{$idhapus}'";
        $h = doquery($koneksi, $q );
        $d = sqlfetcharray( $h );
        $dataterkait=$dataterkait+$d['JML'];
        $q = "SELECT COUNT(*) AS JML FROM makul WHERE IDPRODI='{$idhapus}'";
        $h = doquery($koneksi, $q );
        $d = sqlfetcharray( $h );
        $dataterkait=$dataterkait+$d['JML'];
        if ( 0 < $dataterkait )
        {
            $errmesg = "Data Prodi tidak dapat dihapus karena ada data Dosen, Mahasiswa, dan atau Mata Kuliah yang terkait di dalamnya.";
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM prodi WHERE ID='{$idhapus}'";
            doquery($koneksi, $q );
            $ketlog = "Hapus Program Studi dengan ID {$idhapus}";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 8 );
                $errmesg = "Data Program Studi dengan Kode = {$idhapus} berhasil dihapus";
                $q = "SELECT ID FROM makul WHERE IDPRODI='{$idhapus}'";
                $h = doquery($koneksi, $q );
				if( 0 < sqlnumrows($h))
				{
					while ($d = sqlfetcharray($h))
					{
						$q = "DELETE FROM komponen WHERE IDMAKUL='{$d['ID']}'";
						doquery($koneksi, $q );
						$q = "DELETE FROM konversi WHERE IDMAKUL='{$d['ID']}'";
						doquery($koneksi, $q );
						$q = "DELETE FROM dosenpengajar WHERE IDMAKUL='{$d['ID']}'";
						doquery($koneksi, $q );
						$q = "DELETE FROM nilai WHERE IDMAKUL='{$d['ID']}'";
						doquery($koneksi, $q );
						$q = "DELETE FROM pengambilanmk WHERE IDMAKUL='{$d['ID']}'";
						doquery($koneksi, $q );
					}
				}
                $q = "DELETE FROM makul WHERE IDPRODI='{$idhapus}'";
                doquery($koneksi, $q );
                $q = "DELETE FROM mahasiswa WHERE IDPRODI='{$idhapus}'";
                doquery($koneksi, $q );
                $q = "DELETE FROM mspst WHERE IDX='{$idhapus}'";
                doquery($koneksi, $q );
            }
            else
            {
                $errmesg = "Data Program Studi dengan Kode = '{$idhapus}' tidak berhasil dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Program Studi", HAPUS_DATA );
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        cekhaktulis( $kodemenu );
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasinteger( "Kode Program Studi", $id, 8, false );
        $vld[] = cekvaliditasinteger( "Fakultas/Jurusan", $data['iddepartemen'], 8, false );
        $vld[] = cekvaliditasnama( "Nama Prodi", $nama, 64, false );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi", $idj, 3, false );
        $vld[] = cekvaliditasinteger( "Jumlah SKS Minimum", $data['sksmin'], 3 );
        $vld[] = cekvaliditaskode( "Jenis Program Studi", $data['jenis'], 3 );
        $vld[] = cekvaliditasnidn( "NIDN Ketua", $data['nippimpinan'] );
        $vld[] = cekvaliditasnama( "Nama Pimpinan", $data[namapimpinan] );
        $vld[] = cekvaliditasnama( "Gelar Kelulusan", $data['gelar'] );
        $vld[] = cekvaliditaskode( "Kode Perguruan Tinggi", $idpt );
        $vld[] = cekvaliditaskode( "Kode Program Studi", $id );
        $vld[] = cekvaliditastanggal( "Tanggal Awal Berdiri", $tgla, $blna, $thna );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Awal mulai lapor", $tahun, $semester, false );
        $vld[] = cekvaliditaskode( "Status", $status, 2, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Mulai", $tahun2, $semester2, false );
        $vld[] = cekvaliditasemail( "Email", $email, 64 );
        $vld[] = cekvaliditaskode( "Frekuensi Pemutakhiran Kurikulum", $frek, 3 );
        $vld[] = cekvaliditaskode( "Pelaksanaan Pemutakhiran Kurikulum", $pel, 3 );
        $vld[] = cekvaliditastelp( "Telp Ketua Prodi", $teleponk, 16 );
        $vld[] = cekvaliditastelp( "Telp Prodi", $telepon, 16 );
        $vld[] = cekvaliditastelp( "Faks Prodi", $faks, 16 );
        $vld[] = cekvaliditasnama( "Nama Operator", $namaopr, 64 );
        $vld[] = cekvaliditastelp( "Telepon Operator", $teleponopr, 16 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            if ( trim( $nama ) == "" )
            {
                $errmesg = "Nama Program Studi harus diisi";
            }
            else
            {
                if ( $status != "H" )
                {
                    $tahun2 = $semester2 = "";
                }
                if ( $thnak1 == "" || $blnak1 == "" || $tglak1 == "" )
                {
                    $tanggalak1 = "NULL";
                }
                else
                {
                    $tanggalak1 = "'{$thnak1}-{$blnak1}-{$tglak1}'";
                }
                if ( $thnak2 == "" || $blnak2 == "" || $tglak2 == "" )
                {
                    $tanggalak2 = "NULL";
                }
                else
                {
                    $tanggalak2 = "'{$thnak2}-{$blnak2}-{$tglak2}'";
                }
                $q = "\r\n\t\t\t\tUPDATE mspst SET \r\n\t \t\t\tKDPTIMSPST='{$idpt}', \r\n\t\t\t\tKDFAKMSPST='".$arraydepfak2[$data[iddepartemen]]."',\r\n\t\t\t\tKDJENMSPST='{$idj}',  \r\n\t\t\t\tKDPSTMSPST='{$id}',  \r\n\t\t\t\tNMPSTMSPST='{$nama}',  \r\n\t\t\t\tTGAWLMSPST='{$thna}-{$blna}-{$tgla}', \r\n\t\t\t\tSMAWLMSPST='{$tahun}{$semester}',\r\n\t\t\t\tSTATUMSPST='{$status}', \r\n\t\t\t\tMLSEMMSPST='{$tahun2}{$semester2}',\r\n\t\t\t\tSKSTTMSPST='{$data['sksmin']}',  \r\n\t\t\t\tEMAILMSPST='{$email}',  \r\n\t\t\t\tNOMSKMSPST='{$nosk}',  \r\n\t\t\t\tTGLSKMSPST='{$thn1}-{$bln1}-{$tgl1}',  \r\n\t\t\t\tTGLAKMSPST='{$thn2}-{$bln2}-{$tgl2}',  \r\n\t\t\t\tNOMBAMSPST='{$noak}',  \r\n\t\t\t\tTGLBAMSPST={$tanggalak1},\r\n\t\t\t\tTGLABMSPST={$tanggalak2}, \r\n\t\t\t\tKDSTAMSPST='{$statusak}',  \r\n\t\t\t\tKDFREMSPST='{$frek}',  \r\n\t\t\t\tKDPELMSPST='{$pel}',  \r\n\t\t\t\tNOKPSMSPST='{$data['nippimpinan']}',  \r\n\t\t\t\tTELPSMSPST='{$teleponk}',  \r\n\t\t\t\tTELPOMSPST='{$telepon}',\r\n\t\t\t\tFAKSIMSPST='{$faks}',  \r\n\t\t\t\tNMOPRMSPST='{$namaopr}',  \r\n\t\t\t\tTELPRMSPST='{$teleponopr}' \r\n\t\t\t\tWHERE IDX='{$idupdate}'\r\n\t\t\t";
                doquery($koneksi, $q );
                $errmesg = "";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Program Studi berhasil diupdate";
                }
                $q = "\r\n\t\t\t\tUPDATE prodi SET \r\n\t \t\t\tNAMA='{$nama}',\r\n\t \t\t\tNAMA2='{$nama2}',\r\n\t \t\t\tNAMAJENJANG2='{$namajenjang2}',\r\n\t\t\t\tTINGKAT='{$idj}',\r\n\t\t\t\tSKSMIN='{$data['sksmin']}',\r\n\t\t\t\tSEMESTERMAX='{$data['semestermax']}',\r\n\t\t\t\tJENIS='{$data['jenis']}',\r\n\t\t\t\tIDDEPARTEMEN='{$data['iddepartemen']}',\r\n\t\t\t\tNIPPIMPINAN='{$data['nippimpinan']}',\r\n\t\t\t\tNAMAPIMPINAN='{$data['namapimpinan']}',\r\n\t\t\t\tNAMAPUKET1AKADEMIK='{$data['namapuket1akademik']}',\r\n\t\t\t\tNIPPUKET1AKADEMIK='{$data['nippuket1akademik']}',\r\n\t\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t\tGELAR='{$data['gelar']}',\r\n\t\t\t\tGELAR2='{$data['gelar2']}',\r\n\t\t\t\tIDNIM='{$idnim}',\r\n\r\n\t \t\t\tLABELSKRIPSI='{$labelskripsi}',\r\n\t \t\t\tLABELSKRIPSI2='{$labelskripsi2}'\r\n\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
                #echo $q.'<br>';
		doquery($koneksi, $q );
                $ketlog = "Update Program Studi dengan Kode = {$idupdate} dan Nama ={$nama}";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    buatlog( 7 );
                    $errmesg = "Data Program Studi berhasil diupdate";
                    if ( $idlama != $id || $idjlama != $idj )
                    {
                        $q = "UPDATE msdos SET KDPSTMSDOS='{$id}', KDJENMSDOS='{$idj}' WHERE KDPSTMSDOS='{$idlama}' AND KDJENMSDOS='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE msmhs SET KDPSTMSMHS='{$id}', KDJENMSMHS='{$idj}' WHERE KDPSTMSMHS='{$idlama}' AND KDJENMSMHS='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE mspds SET KDPSTMSPDS='{$id}', KDJENMSPDS='{$idj}' WHERE KDPSTMSPDS='{$idlama}' AND KDJENMSPDS='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE msphs SET KDPSTMSPHS='{$id}', KDJENMSPHS='{$idj}' WHERE KDPSTMSPHS='{$idlama}' AND KDJENMSPHS='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE tbbnl SET KDPSTTBBNL='{$id}', KDJENTBBNL='{$idj}' WHERE KDPSTTBBNL='{$idlama}' AND KDJENTBBNL='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE tbkmk SET KDPSTTBKMK='{$id}', KDJENTBKMK='{$idj}' WHERE KDPSTTBKMK='{$idlama}' AND KDJENTBKMK='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE tbkmksp SET KDPSTTBKMK='{$id}', KDJENTBKMK='{$idj}' WHERE KDPSTTBKMK='{$idlama}' AND KDJENTBKMK='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trakd SET KDPSTTRAKD='{$id}', KDJENTRAKD='{$idj}' WHERE KDPSTTRAKD='{$idlama}' AND KDJENTRAKD='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trakm SET KDPSTTRAKM='{$id}', KDJENTRAKM='{$idj}' WHERE KDPSTTRAKM='{$idlama}' AND KDJENTRAKM='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trfas SET KDPSTTRFAS='{$id}', KDJENTRFAS='{$idj}' WHERE KDPSTTRFAS='{$idlama}' AND KDJENTRFAS='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trkap SET KDPSTTRKAP='{$id}', KDJENTRKAP='{$idj}' WHERE KDPSTTRKAP='{$idlama}' AND KDJENTRKAP='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trlab SET KDPSTTRLAB='{$id}', KDJENTRLAB='{$idj}' WHERE KDPSTTRLAB='{$idlama}' AND KDJENTRLAB='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trlsd SET KDPSTTRLSD='{$id}', KDJENTRLSD='{$idj}' WHERE KDPSTTRLSD='{$idlama}' AND KDJENTRLSD='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trlsm SET KDPSTTRLSM='{$id}', KDJENTRLSM='{$idj}' WHERE KDPSTTRLSM='{$idlama}' AND KDJENTRLSM='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trnlm SET KDPSTTRNLM='{$id}', KDJENTRNLM='{$idj}' WHERE KDPSTTRNLM='{$idlama}' AND KDJENTRNLM='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trnlmsp SET KDPSTTRNLM='{$id}', KDJENTRNLM='{$idj}' WHERE KDPSTTRNLM='{$idlama}' AND KDJENTRNLM='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trpid SET KDPSTTRPID='{$id}', KDJENTRPID='{$idj}' WHERE KDPSTTRPID='{$idlama}' AND KDJENTRPID='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trppg SET KDPSTTRPPG='{$id}', KDJENTRPPG='{$idj}' WHERE KDPSTTRPPG='{$idlama}' AND KDJENTRPPG='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trpud SET KDPSTTRPUD='{$id}', KDJENTRPUD='{$idj}' WHERE KDPSTTRPUD='{$idlama}' AND KDJENTRPUD='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trskr SET KDPSTTRSKR='{$id}', KDJENTRSKR='{$idj}' WHERE KDPSTTRSKR='{$idlama}' AND KDJENTRSKR='{$idjlama}'";
                        doquery($koneksi, $q );
                        $q = "UPDATE trtes SET KDPSTTRTES='{$id}', KDJENTRTES='{$idj}' WHERE KDPSTTRTES='{$idlama}' AND KDJENTRTES='{$idjlama}'";
                        doquery($koneksi, $q );
                    }
                }
                else
                {
                    if ( $errmesg == "" )
                    {
                        $errmesg = "Data Program Studi tidak diupdate";
                    }
                }
            }
        }
    }
    else
    {
        $ermesg = token_err_mesg( "Program Studi", SIMPAN_DATA );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM prodi WHERE ID='{$idupdate}'";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Program Studi", "bantuan" );
        printhelp( trim( $arrayhelp[updateprodi] ), "bantuan" );
        #printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $labelskripsi = $d[LABELSKRIPSI];
        $labelskripsi2 = $d[LABELSKRIPSI2];
        /*echo "\r\n <div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>
											<i class='fa fa-gift'></i>Update Data Program Studi
										</div>
										
									</div>
									<div class='portlet-body form'><form action=../lain/index.php method=post>\r\n  <input type=hidden name=pilihan value='1'>\r\n  <input type=hidden name=idprodi value='{$idupdate}'>";
        printjudulmenukecil( "<b>DATA KEGIATAN PERKULIAHAN</b>" );
        echo "\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n    <tr>\r\n      <td>Jurusan/Program Studi</td>\r\n      <td><b>".$arrayprodidep[$idupdate]." \r\n      \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>Semester/Tahun Pelaporan</td>\r\n      <td>\r\n";
        */
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Update Data Program Studi");
						echo "			</div>";
						echo "
										<div class=\"m-portlet\">
											
											<!--begin::Form-->
											<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
												<input type=hidden name=pilihan value='1'>\r\n  <input type=hidden name=idprodi value='{$idupdate}'>
												<div class=\"m-portlet__body\">	
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
														<div class=\"col-lg-6\"><b>".$arrayprodidep[$idupdate]."</b></div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Semester/Tahun Pelaporan</label>\r\n    
														<div class=\"col-lg-6\">";
															$waktu = getdate( );
															echo "\r\n\r\n\t\t\t\t\t\t<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
															unset( $arraysemester[3] );
															foreach ( $arraysemester as $k => $v )
															{
																if ( $k == $semester )
																{
																	$selected = "selected";
																}
																echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
																$selected = "";
															}
															echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
																$selected = "";
																$i = 1901;
																while ( $i <= $waktu[year] + 5 )
																{
																	if ( $i == $waktu[year] )
																	{
																		$selected = "selected";
																	}
																	echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
																	$selected = "";
																	++$i;
																}
																echo "\r\n\t\t\t\t\t\t</select>\r\n      
														</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
														<div class=\"col-lg-6\">
																<input type=submit name=aksi value='Lanjutkan' class=\"btn btn-brand\"> 
															</div>
													</div>
												</div>
											</form>
										</div>";
						echo "			<div class='portlet-title'>";
												printtitle("Detail Program Studi");
						echo "			</div>";
						echo "
										<div class=\"m-portlet\">
											
											<!--begin::Form-->
											<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
												".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "idjlama", "{$d['TINGKAT']}", "" )."
												<div class=\"m-portlet__body\">	
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Kode Program Studi *</label>\r\n    
														<div class=\"col-lg-6\">".createinputtext( "idbaru", $d['ID'], " class=form-control m-input  size=5 readonly" ).".\r\n      \r\n      Kode Prodi untuk NIM otomatis ".createinputtext( "idnim", $d[IDNIM], " class=form-control m-input  size=5 " ).".</div>
													</div>	
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">{$JUDULFAKULTAS} / Jurusan</label>\r\n    
														<div class=\"col-lg-6\">".createinputselect( "data[iddepartemen]", $arraydepfak, $d['IDDEPARTEMEN'], "", " class=form-control m-input" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Nama Program Studi *</label>\r\n    
														<div class=\"col-lg-6\">".createinputtext( "nama", $d['NAMA'], " class=form-control m-input  size=50" )."</div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Nama Program Studi Dalam bahasa Inggris</label>\r\n    
														<div class=\"col-lg-6\">".createinputtext( "nama2", $d['NAMA2'], " class=form-control m-input  size=50" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi *</label>\r\n    
														<div class=\"col-lg-6\">".createinputselect( "idj", $arrayjenjang, $d['TINGKAT'], "", " class=form-control m-input" )." </div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi Dalam Bahasa Inggris</label>    
														<div class=\"col-lg-6\">".createinputtext( "namajenjang2", $d['NAMAJENJANG2'], " class=form-control m-input  size=50" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jumlah SKS Minimum</label>    
														<div class=\"col-lg-6\">".createinputtext( "data[sksmin]", $d['SKSMIN'], " class=form-control m-input  size=4" )."</div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Jumlah Semester Normal</label>    
														<div class=\"col-lg-6\">".createinputtext( "data[semestermax]", $d['SEMESTERMAX'], " class=form-control m-input  size=4" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Jenis Program Studi</label>
														<div class=\"col-lg-6\">".createinputselect( "data[jenis]", $arrayjenisprodi, $d['JENIS'], "", " class=form-control m-input" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">NIDN Ketua *</label>
														<div class=\"col-lg-6\">".createinputtext( "data[nippimpinan]", $d['NIPPIMPINAN'], " class=form-control m-input  size=30" )."</div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Nama Ketua *</label>
														<div class=\"col-lg-6\">".createinputtext( "data[namapimpinan]", $d['NAMAPIMPINAN'], " class=form-control m-input size=30" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">NIDN Puket 1 Bidang Akademik</label>
														<div class=\"col-lg-6\">".createinputtext( "data[nippuket1akademik]", $d['NIPPUKET1AKADEMIK'], " class=form-control m-input  size=30" )."</div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Nama Puket 1 Bidang Akademik</label>
														<div class=\"col-lg-6\">".createinputtext( "data[namapuket1akademik]", $d['NAMAPUKET1AKADEMIK'], " class=form-control m-input size=30" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Alamat Program Studi</label>
														<div class=\"col-lg-6\">".createinputtextarea( "data[alamat]", $d['ALAMAT'], " class=form-control m-input cols=50 rows=3" )."</div>
													</div>
													<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">Gelar kelulusan</label>
														<div class=\"col-lg-6\">".createinputtext( "data[gelar]", $d['GELAR'], " class=form-control m-input size=30" )."</div>
													</div>
													<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
														<label class=\"col-lg-2 col-form-label\">Gelar kelulusan Dalam bahasa Inggris</label>
														<div class=\"col-lg-6\">".createinputtext( "data[gelar2]", $d['GELAR2'], " class=form-control m-input size=30" )."</div>
													</div>";
													include( "prodi2.php" );
											echo "	<div class=\"form-group m-form__group row\">
														<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
														<div class=\"col-lg-6\">
																<input type=\"submit\" class=\"btn btn-brand\" value=Update></input>
																<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
														</div>
													</div>
												</div>
											</form>
										<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
</div>
<!--end::page-content-->
<script>\r\n \t\t\t\tform.nama.focus();\r\n\t\t\t</script>\r\n\t\t";
		/*printjudulmenukecil( "<b>DETIL PROGRAM STUDI</b>" );
        echo "\r\n\t\t\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "idjlama", "{$d['TINGKAT']}", "" )."\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kode Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "idbaru", $d[ID], " class=masukan  size=5 readonly" ).".\r\n      \r\n      Kode Prodi untuk NIM otomatis ".createinputtext( "idnim", $d[IDNIM], " class=masukan  size=5 " ).".</td>\r\n\t\t</tr>\r\n     <tr class=judulform>\r\n\t\t\t<td>{$JUDULFAKULTAS} / Jurusan</td>\r\n\t\t\t<td>".createinputselect( "data[iddepartemen]", $arraydepfak, $d[IDDEPARTEMEN], "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "nama", $d[NAMA], " class=masukan  size=50" )."</td> \r\n    </tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td nowrap>Nama Program Studi Dalam bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "nama2", $d[NAMA2], " class=masukan  size=50" )."</td> \r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Jenjang Program Studi *</td>\r\n\t\t\t<td>".createinputselect( "idj", $arrayjenjang, $d[TINGKAT], "", " class=masukan" )."      </td> \r\n\t\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td nowrap>Jenjang Program Studi Dalam Bahasa Inggris</td>\r\n\t\t\t<td> ".createinputtext( "namajenjang2", $d[NAMAJENJANG2], " class=masukan  size=50" )."</td>\r\n    </tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jumlah SKS Minimum</td>\r\n\t\t\t<td>".createinputtext( "data[sksmin]", $d[SKSMIN], " class=masukan  size=4" )."</td> \r\n\t\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jumlah Semester Normal</td>\r\n\t\t\t<td>".createinputtext( "data[semestermax]", $d[SEMESTERMAX], " class=masukan  size=4" )."</td> \r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jenis Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[jenis]", $arrayjenisprodi, $d[JENIS], "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\r\n\t\t\r\n\t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $d[NIPPIMPINAN], " class=masukan  size=30" )."</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Nama Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $d[NAMAPIMPINAN], " class=masukan size=30" )."</td>\r\n\t\t\t</tr>\r\n\t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[nippuket1akademik]", $d[NIPPUKET1AKADEMIK], " class=masukan  size=30" )."</td>\r\n\t\t</tr>\r\n\r\n      <tr class=judulform>\r\n\t\t\t<td>Nama Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[namapuket1akademik]", $d[NAMAPUKET1AKADEMIK], " class=masukan size=30" )."</td>\r\n\t\t\t</tr>\r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat Program Studi</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $d[ALAMAT], " class=masukan cols=50 rows=3" )."</td>\r\n\t\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar kelulusan</td>\r\n\t\t\t<td>".createinputtext( "data[gelar]", $d[GELAR], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar kelulusan Dalam bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "data[gelar2]", $d[GELAR2], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n      \r\n      ";
        include( "prodi2.php" );
        echo "\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=\"submit\" class=\"btn blue\" value=Update></input>
                                            <input type=\"reset\" class=\"btn red\" value=Reset></input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form></div></div></div></div></div></div></div>\r\n\t\t\t<script>\r\n \t\t\t\tform.nama.focus();\r\n\t\t\t</script>\r\n\t\t";
		*/
	}
    else
    {
        $errmesg = "Data Program Studi dengan Kode = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        unset( $_SESSION['token'] );
        #$vld[] = cekvaliditasinteger( "Kode Program Studi", $id, 8, false );
        $vld[] = cekvaliditasinteger( "Fakultas/Jurusan", $data['iddepartemen'], 8, false );
        $vld[] = cekvaliditasnama( "Nama Prodi", $nama, 64, false );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi", $idj, 3, false );
        $vld[] = cekvaliditasinteger( "Jumlah SKS Minimum", $data['sksmin'], 3 );
        $vld[] = cekvaliditaskode( "Jenis Program Studi", $data['jenis'], 3 );
        $vld[] = cekvaliditasnidn( "NIDN Ketua", $data['nippimpinan'] );
        $vld[] = cekvaliditasnama( "Nama Pimpinan", $data[namapimpinan] );
        $vld[] = cekvaliditasnama( "Gelar Kelulusan", $data['gelar'] );
        $vld[] = cekvaliditaskode( "Kode Perguruan Tinggi", $idpt );
        #$vld[] = cekvaliditaskode( "Kode Program Studi", $id );
        $vld[] = cekvaliditastanggal( "Tanggal Awal Berdiri", $tgla, $blna, $thna );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Awal mulai lapor", $tahun, $semester, false );
        $vld[] = cekvaliditaskode( "Status", $status, 2, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Mulai", $tahun2, $semester2, false );
        $vld[] = cekvaliditasemail( "Email", $email, 64 );
        $vld[] = cekvaliditaskode( "Frekuensi Pemutakhiran Kurikulum", $frek, 3 );
        $vld[] = cekvaliditaskode( "Pelaksanaan Pemutakhiran Kurikulum", $pel, 3 );
        $vld[] = cekvaliditastelp( "Telp Ketua Prodi", $teleponk, 16 );
        $vld[] = cekvaliditastelp( "Telp Prodi", $telepon, 16 );
        $vld[] = cekvaliditastelp( "Faks Prodi", $faks, 16 );
        $vld[] = cekvaliditasnama( "Nama Operator", $namaopr, 64 );
        $vld[] = cekvaliditastelp( "Telepon Operator", $teleponopr, 16 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else
        {
            cekhaktulis( $kodemenu );
            if ( trim( $nama ) == "" )
            {
                $errmesg = "Nama Program Studi harus diisi";
            }
            else
            {
                if ( $idbaru == "" )
                {
                    $idbaru = getnewid( "prodi" );
                }
                $q = "\r\n\t\t\t\tINSERT INTO prodi (ID,NAMA,TINGKAT,IDDEPARTEMEN,SKSMIN,JENIS,NIPPIMPINAN,NAMAPIMPINAN,ALAMAT,GELAR,NAMAPUKET1AKADEMIK,NAMA2,\r\n        NAMAJENJANG2,GELAR2,IDNIM,SEMESTERMAX,NIPPUKET1AKADEMIK) \r\n\t\t\t\tVALUES ('{$idbaru}','{$nama}','{$idj}','{$data['iddepartemen']}',\r\n\t\t\t\t'{$data['sksmin']}','{$data['jenis']}','{$data['nippimpinan']}','{$data['namapimpinan']}','{$data['alamat']}','{$data['gelar']}','{$data['namapuket1akademik']}',\r\n        '{$nama2}',\r\n        '{$namajenjang2}','{$data['gelar2']}','{$idbaru}','{$data['semestermax']}','{$data['nippuket1akademik']}')\r\n\t\t\t";
                doquery($koneksi, $q );
                $ketlog = "Tambah Program Studi dengan Kode = {$idbaru} dan Nama ={$nama}";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    buatlog( 6 );
                    if ( $status != "H" )
                    {
                        $tahun2 = $semester2 = "";
                    }
                    if ( $thnak1 == "" || $blnak1 == "" || $tglak1 == "" )
                    {
                        $tanggalak1 = "NULL";
                    }
                    else
                    {
                        $tanggalak1 = "'{$thnak1}-{$blnak1}-{$tglak1}'";
                    }
                    if ( $thnak2 == "" || $blnak2 == "" || $tglak2 == "" )
                    {
                        $tanggalak2 = "NULL";
                    }
                    else
                    {
                        $tanggalak2 = "'{$thnak2}-{$blnak2}-{$tglak2}'";
                    }
                    $q = " INSERT INTO mspst \r\n\t\t\t\t\t\t(KDPTIMSPST,KDFAKMSPST,  KDJENMSPST,  KDPSTMSPST,  NMPSTMSPST,  TGAWLMSPST,SMAWLMSPST,\r\n\t\t\t\t\t\tSTATUMSPST, MLSEMMSPST,SKSTTMSPST,  EMAILMSPST,  NOMSKMSPST,  TGLSKMSPST,  TGLAKMSPST,  \r\n\t\t\t\t\t\tNOMBAMSPST,  TGLBAMSPST, TGLABMSPST,  KDSTAMSPST,  KDFREMSPST,  KDPELMSPST,  NOKPSMSPST,  \r\n\t\t\t\t\t\tTELPSMSPST,  TELPOMSPST,FAKSIMSPST,  NMOPRMSPST,  TELPRMSPST,IDX)\r\n\t\t\t\t\t\tVALUES \r\n\t\t\t\t\t\t('{$idpt}','".$arraydepfak2[$data[iddepartemen]]."','{$idj}','{$id}','{$nama}','{$thna}-{$blna}-{$tgla}',\r\n\t\t\t\t\t\t'{$tahun}{$semester}','{$status}','{$tahun2}{$semester2}','{$data['sksmin']}',\r\n\t\t\t\t\t\t'{$email}','{$nosk}','{$thn1}-{$bln1}-{$tgl1}','{$thn2}-{$bln2}-{$tgl2}','{$noak}',{$tanggalak1},\r\n\t\t\t\t\t\t{$tanggalak2},'{$statusak}','{$frek}','{$pel}','{$data['nippimpinan']}','{$teleponk}',\r\n\t\t\t\t\t\t'{$telepon}','{$faks}','{$namaopr}','{$teleponopr}','{$idbaru}')";
                    doquery($koneksi, $q );
                    $errmesg = "Data Program Studi berhasil ditambah";
                    $data = "";
                    $nama = "";
                    $id = $email = $nosk = $noak = $statusak = $frek = $pel = $teleponk = $telepon = $faks = $namaopr = $teleponopr = "";
                }
                else
                {
                    $errmesg = "Data Program Studi tidak berhasil ditambah";
                }
            }
        }
    }
    else
    {
        $ermesg = token_err_mesg( "Program Studi", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Tambah Data Program Studi", "bantuan" );
    #printhelp( trim( $arrayhelp[tambahprodi] ), "bantuan" );
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Kode Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "idbaru", $idbaru, " class=masukan  size=5" )."(kosongkan untuk Kode otomatis. <b>PERHATIAN!!! Kode 9000 s.d 9999 digunakan untuk Kode DUMMY</b>, Tidak akan digunakan/dikonversi ke laporan EPSBED. Rentang Kode tersebut hanya digunakan untuk pembuatan Prodi penampung Mata Kuliah Umum di Menu Mata Kuliah.)</td>\r\n\t\t\t</tr>\r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td>{$JUDULFAKULTAS} / Jurusan</td>\r\n\t\t\t<td>".createinputselect( "data[iddepartemen]", $arraydepfak, $data[iddepartemen], "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td> \r\n    </tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td nowrap>Nama Program Studi Dalam bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "nama2", $nama2, " class=masukan  size=50" )."</td> \r\n    </tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Jenjang Program Studi *</td>\r\n\t\t\t<td> \r\n".createinputselect( "idj", $arrayjenjang, $idj, "", " class=masukan" )."      \r\n      </td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td nowrap>Jenjang Program Studi Dalam Bahasa Inggris</td>\r\n\t\t\t<td> ".createinputtext( "namajenjang2", $namajenjang2, " class=masukan  size=50" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Jumlah SKS Minimum</td>\r\n\t\t\t<td>".createinputtext( "data[sksmin]", $data[sksmin], " class=masukan size=4" )."</td>\r\n      </tr>\r\n\r\n\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jumlah Semester Normal</td>\r\n\t\t\t<td>".createinputtext( "data[semestermax]", $data[semestermax], " class=masukan  size=4" )."</td> \r\n\t\t\t</tr>     \r\n\r\n     <tr class=judulform>\r\n\t\t\t<td>Jenis Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[jenis]", $arrayjenisprodi, $data[jenis], "", " class=masukan" )."</td></tr>\r\n\t\t\t\r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\t\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>NIP/NIDN Ketua</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $data[nippimpinan], " class=masukan  size=30" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Ketua</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $data[namapimpinan], " class=masukan size=30" )."</td> \r\n     </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIP/NIDN Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[nippuket1akademik]", $data[nippuket1akademik], " class=masukan  size=30" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[namapuket1akademik]", $data[namapuket1akademik], " class=masukan size=30" )."</td>\r\n\t\t\t</tr>\r\n     \r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\r\n      \r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat </td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", $data[alamat] ), " class=masukan cols=50 rows=3" )."</td></tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar Kelulusan</td>\r\n\t\t\t<td>".createinputtext( "data[gelar]", $data[gelar], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar Kelulusan Dalam Bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "data[gelar2]", $data[gelar2], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n      ";*/
    /*echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Tambah Data Program Studi");
										echo "</div>
										
									</div>
									<div class='portlet-body form'>
                           <form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Kode Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "idbaru", $idbaru, " class=masukan  size=5" )."(kosongkan untuk Kode otomatis. <b>PERHATIAN!!! Kode 9000 s.d 9999 digunakan untuk Kode DUMMY</b>, Tidak akan digunakan/dikonversi ke laporan EPSBED. Rentang Kode tersebut hanya digunakan untuk pembuatan Prodi penampung Mata Kuliah Umum di Menu Mata Kuliah.)</td>\r\n\t\t\t</tr>\r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td>{$JUDULFAKULTAS} / Jurusan</td>\r\n\t\t\t<td>".createinputselect( "data[iddepartemen]", $arraydepfak, $data[iddepartemen], "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td> \r\n    </tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td nowrap>Nama Program Studi Dalam bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "nama2", $nama2, " class=masukan  size=50" )."</td> \r\n    </tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Jenjang Program Studi *</td>\r\n\t\t\t<td> \r\n".createinputselect( "idj", $arrayjenjang, $idj, "", " class=masukan" )."      \r\n      </td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td nowrap>Jenjang Program Studi Dalam Bahasa Inggris</td>\r\n\t\t\t<td> ".createinputtext( "namajenjang2", $namajenjang2, " class=masukan  size=50" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Jumlah SKS Minimum</td>\r\n\t\t\t<td>".createinputtext( "data[sksmin]", $data[sksmin], " class=masukan size=4" )."</td>\r\n      </tr>\r\n\r\n\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Jumlah Semester Normal</td>\r\n\t\t\t<td>".createinputtext( "data[semestermax]", $data[semestermax], " class=masukan  size=4" )."</td> \r\n\t\t\t</tr>     \r\n\r\n     <tr class=judulform>\r\n\t\t\t<td>Jenis Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[jenis]", $arrayjenisprodi, $data[jenis], "", " class=masukan" )."</td></tr>\r\n\t\t\t\r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\t\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>NIP/NIDN Ketua</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $data[nippimpinan], " class=masukan  size=30" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Ketua</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $data[namapimpinan], " class=masukan size=30" )."</td> \r\n     </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIP/NIDN Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[nippuket1akademik]", $data[nippuket1akademik], " class=masukan  size=30" )."</td>\r\n    </tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Puket 1 Bidang Akademik</td>\r\n\t\t\t<td>".createinputtext( "data[namapuket1akademik]", $data[namapuket1akademik], " class=masukan size=30" )."</td>\r\n\t\t\t</tr>\r\n     \r\n     <tr>\r\n      <td colspan=2><hr width=100%></td>\r\n     </tr>\t\t\t\r\n\r\n      \r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat </td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", $data[alamat] ), " class=masukan cols=50 rows=3" )."</td></tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar Kelulusan</td>\r\n\t\t\t<td>".createinputtext( "data[gelar]", $data[gelar], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelar Kelulusan Dalam Bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "data[gelar2]", $data[gelar2], " class=masukan size=30" )."</td>\r\n      </tr>      \r\n      ";
    include( "prodi2.php" );
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2><input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
                                            <input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.nama.focus();\r\n\t\t\t</script>\r\n\t\t</div></div></div></div></div></div></diV>";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Tambah Data Program Studi");
								echo "	</div>";
								
	echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
					<div class=\"m-portlet__body\">		
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Kode Program Studi *</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "idbaru", $idbaru, " class=form-control m-input  size=5" )."(kosongkan untuk Kode otomatis. <b>PERHATIAN!!! Kode 9000 s.d 9999 digunakan untuk Kode DUMMY</b>, Tidak akan digunakan/dikonversi ke laporan EPSBED. Rentang Kode tersebut hanya digunakan untuk pembuatan Prodi penampung Mata Kuliah Umum di Menu Mata Kuliah.)</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">{$JUDULFAKULTAS} / Jurusan</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[iddepartemen]", $arraydepfak, "", "", " class=form-control m-input" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Program Studi *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "nama", "", " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama Program Studi Dalam Bahasa Inggris</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "nama2", "", " class=form-control m-input  size=50" )."
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "idj", $arrayjenjang, "", "", " class=form-control m-input" )." 
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi Dalam Bahasa Inggris</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "namajenjang2", "", " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Jumlah SKS Minimum</label>
								<label class=\"col-form-label\">
									".createinputtext( "data[sksmin]", "", " class=form-control m-input size=4" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jumlah Semester Normal</label>
								<label class=\"col-form-label\">
									".createinputtext( "data[semestermax]", "", " class=form-control m-input  size=4" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Jenis Program Studi</label>
								<label class=\"col-form-label\">
									".createinputselect( "data[jenis]", $arrayjenisprodi, "", "", " class=form-control m-input" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP/NIDN Ketua</label>
								<label class=\"col-form-label\">
									".createinputtext( "data[nippimpinan]", "", " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Ketua</label>
								<label class=\"col-form-label\">
									".createinputtext( "data[namapimpinan]", "", " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP/NIDN Puket 1 Bidang Akademik</label>
								<div class=\"col-lg-6\">".createinputtext( "data[nippuket1akademik]", "", " class=form-control m-input  size=30" )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Puket 1 Bidang Akademik</label>
								<div class=\"col-lg-6\">".createinputtext( "data[namapuket1akademik]", "", " class=form-control m-input size=30" )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat </label>
								<div class=\"col-lg-6\">".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", "" ), " class=form-control m-input cols=50 rows=3" )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Gelar Kelulusan</label>
								<div class=\"col-lg-6\">".createinputtext( "data[gelar]", "", " class=form-control m-input size=30" )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Gelar Kelulusan Dalam Bahasa Inggris</label>
								<div class=\"col-lg-6\">".createinputtext( "data[gelar2]", "", " class=form-control m-input size=30" )."</div>
							</div>"; 
							include( "prodi2.php" );
echo 						"<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
							</div>
							
						</div>
						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->	
</div>
<!--end::page-content-->		
<script>\r\n \t\t\t\tform.nama.focus();\r\n\t\t\t</script>\r\n\t\t";										
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilprodi.php" );
}
if ( $aksi == "" )
{
    
    #printhelp( trim( $arrayhelp[cariprodi] ), "bantuan" );
    #printmesg( $errmesg );
    
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Lihat Data Program Studi");
								echo "	</div>";
						echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post><input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>
					<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">{$JUDULFAKULTAS} / Jurusan</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=iddepartemen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arraydepfak as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
	echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama Program Studi</label>\r\n    
									<div class=\"col-lg-6\"><input type=text class=form-control m-input name=namaprodi size=30></div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\"></label>\r\n    
									<div class=\"col-lg-6\"><input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input></div>
							</div></div>
						
					</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
			</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
	<script>\r\n \t\t\t\tform.submit.focus();\r\n\t\t\t</script>";

	#echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNama Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<input type=text class=masukan name=namaprodi size=30>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=\"submit\" class=\"btn blue\" value=Tampilkan></input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table><br><br>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.submit.focus();\r\n\t\t\t</script><br><br></div></div></div></div><br></div><br></div></div>\r\n\t";
}
?>
