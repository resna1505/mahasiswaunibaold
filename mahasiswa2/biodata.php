<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#periksaroot();
if ( $aksi == "" )
{
	#echo "aaaa";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #cekhaktulis( $kodemenu );
    #$q = "SELECT \r\n\tmahasiswa.*,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR ,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    
	echo $q;
	$h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmpmasuk = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmpmasuk[0];
        $dtm[tgl] = $tmpmasuk[2];
        $dtm[bln] = $tmpmasuk[1];
        $tmpkeluar= explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmpkeluar[0];
        $dtk[tgl] = $tmpkeluar[2];
        $dtk[bln] = $tmpkeluar[1];
        $tmppindahan = explode( "-", $d[TANGGALSKPINDAHAN] );
        $tanggalskpindahan[thn] = $tmppindahan[0];
        $tanggalskpindahan[tgl] = $tmppindahan[2];
        $tanggalskpindahan[bln] = $tmppindahan[1];
        $tmpkartu = explode( "-", $d[TANGGALKARTU] );
        $tanggalkartu[thn] = $tmpkartu[0];
        $tanggalkartu[tgl] = $tmpkartu[2];
        $tanggalkartu[bln] = $tmpkartu[1];
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
		
        echo "	<div class=\"m-portlet\">
						<!--begin::Form-->";
		echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>								
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."
							<div class=\"m-portlet__body\">	
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<label class=\"col-form-label\">
											".$arrayprodidep[$d[IDPRODI]]."
										</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<label class=\"col-form-label\">
											".$d['ANGKATAN']."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>\r\n    
									<label class=\"col-form-label\">
										".$arraydosendep[$d[IDDOSEN]]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
									<label class=\"col-form-label\">
										".$d['ID']."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
									<label class=\"col-form-label\">
										".$d['NAMA']."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Foto</label>\r\n    
									<label class=\"col-form-label\">
										{$fotosaatini}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
									<label class=\"col-form-label\">
										".nl2br( $d[ALAMAT] )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
									<label class=\"col-form-label\">
										".$d[KOTA]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Provinsi</label>\r\n    
									<label class=\"col-form-label\">
										".$d['PROVINSI']."
									</label>
								</div>";       
									/*if ( $d[UMUR] <= 15 )
									{
										$kelas = "style='background-color:#ffff00'";
									}*/
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
									<label class=\"col-form-label\">
										".$d['TEMPAT']." / ".$d[tgl]."-".$d['bln']."-".$d['thn'] ."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
									<label class=\"col-form-label\">
										".$arraykelamin[$d[KELAMIN]]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Agama</label>\r\n    
									<label class=\"col-form-label\">
										".$arrayagama[$d[AGAMA]]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">No Telepon</label>\r\n    
									<label class=\"col-form-label\">
										{$d['TELEPON']}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
									<label class=\"col-form-label\">
										".$d[HP]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
									<label class=\"col-form-label\">
										".$d[EMAIL]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Asal Sekolah</label>\r\n    
									<label class=\"col-form-label\">
										".$d[ASAL]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Lulus</label>\r\n    
									<label class=\"col-form-label\">
										".$d['TAHUNLULUS']."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Pendidikan Terakhir</label>\r\n    
									<label class=\"col-form-label\">
										".$d[PENDIDIKAN]."
									</label>
								</div>								
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kelas Default Pengambilan Mata Kuliah</label>\r\n    
									<label class=\"col-form-label\">
										".$d[KELAS]."
									</label>
								</div>";	
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Masuk</label>\r\n    
									<label class=\"col-form-label\">
										{$dtm['tgl']}-{$dtm['bln']}-{$dtm['thn']}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Keluar/Lulus</label>\r\n    
									<label class=\"col-form-label\">
										{$dtk['tgl']}-{$dtk['bln']}-{$dtk['thn']}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Status Kuliah</label>\r\n    
									<label class=\"col-form-label\">
										".$d['STATUS']."
									</label>
								</div>";
        /*if ( $UNIVERSITAS == "UNIKAL" )
        {
            echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Sistem KRS</td>\r\n\t\t\t<td>".createinputselect( "sistemkrs", $arraysistemkrs, $d[SISTEMKRS], "", " class=form-control m-input " )."</td>\r\n\t\t</tr> \r\n";
        }*/
        
       include( "mahasiswa2.php" );
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Judul Tugas Akhir/Skripsi</label>\r\n    
									<label class=\"col-form-label\">
										".nl2br( $d[TA] )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing</label>\r\n    
									<label class=\"col-form-label\">
										".nl2br( $d[DOSENTA] )."
									</label>
								</div>
       
							</div>
						</form>
					<!--end::Form-->
				</div>
				<!--end::Portlet-->
			";
	}
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
