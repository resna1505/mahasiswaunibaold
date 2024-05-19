<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$updatenilai = 0;
if ( $aksitambah == "Update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Nilai", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $pilihupdate ) )
    {
        if ( $pilihan == "ntambah" )
        {
            $jmlaf = 0;
            $q = "\r\n    \t\t\tSELECT IDKOMPONEN,NAMA  FROM komponensp\r\n    \t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n    \t\t\tAND TAHUN='{$tahunupdate}'\r\n    \t\t\tAND SEMESTER='{$semesterupdate}'\r\n    \t\t\tAND IDDOSEN='{$iddosenupdate}'\r\n    \t\t\tAND KELAS='{$kelasupdate}'\r\n    \t\t";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                while ( $d = sqlfetcharray( $h ) )
                {
                    $kp[] = $d[IDKOMPONEN];
                    $namakomponen[$d[IDKOMPONEN]] = $d[NAMA];
                }
                $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakulupdate );
                $vld[] = cekvaliditasthnajaran( "Tahun Akademik", $tahunupdate, $semesterupdate );
                $vld[] = cekvaliditasinteger( "Kelas", $kelasupdate, 2 );
                $vld[] = cekvaliditaskode( "Dosen", $iddosenupdate );
                foreach ( $data as $nimid => $v21 )
                {
                    if ( $pilihupdate[$nimid] == 1 )
                    {
                        foreach ( $v21 as $k2 => $v2 )
                        {
                            $vld[] = cekvaliditasnumerik( "Nilai '{$namakomponen[$k2]}' untuk NIM {$nimid} : {$v2}", $v2, 5 );
                        }
                    }
                }
                $vld = array_filter( $vld, "filter_not_empty" );
                if ( isset( $vld ) && 0 < count( $vld ) )
                {
                    $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
                }
                else
                {
                    foreach ( $data as $k => $v )
                    {
                        if ( $pilihupdate[$k] == 1 )
                        {
                            foreach ( $kp as $kk => $vk )
                            {
                                $q = "INSERT INTO nilaisp (IDMAHASISWA,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NILAI,SEMESTER) VALUES ('{$k}','{$vk}','{$idmakulupdate}','{$tahunupdate}','{$kelasupdate}','".$v[$vk]."','{$semesterupdate}')";
                                mysqli_query($koneksi,$q);
                                if ( 0 < sqlaffectedrows( $koneksi ) )
                                {
                                    $ketlog = "Tambah Data Nilai SP dengan ID Makul={$idmakulupdate}, Tahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},Semester=".$arraysemester[$semesterupdate].",Kelas={$kelasupdate},ID Komponen={$vk},ID Mahasiswa={$k},Nilai=".$v[$vk]."";
                                    buatlog( 33 );
                                    ++$jmlaf;
                                }
                                else
                                {
                                    $q = "\r\n    \t\t\t\t\t\t\t\t\tUPDATE nilaisp \r\n    \t\t\t\t\t\t\t\t\tSET \r\n    \t\t\t\t\t\t\t\t\t\tNILAI='".$v[$vk]."'\r\n    \t\t\t\t\t\t\t\t\tWHERE\r\n    \t\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n    \t\t\t\t\t\t\t\t\tAND\r\n    \t\t\t\t\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n    \t\t\t\t\t\t\t\t\tAND\r\n    \t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n    \t\t\t\t\tAND\r\n    \t\t\t\t\t\t\t\t\tKELAS='{$kelasupdate}'\r\n    \t\t\t\t\t\t\t\t\tAND\r\n    \t\t\t\t\t\t\t\t\tIDMAHASISWA='{$k}'\r\n    \t\t\t\t\t\t\t\t\tAND\r\n    \t\t\t\t\t\t\t\t\tIDKOMPONEN='{$vk}'\r\n    \t\t\t\t\t\t\t\t\t\r\n    \t\t\t\t\t\t\t\t";
                                    mysqli_query($koneksi,$q);
                                    ++$jmlaf;
                                    if ( 0 < sqlaffectedrows( $koneksi ) )
                                    {
                                        $ketlog = "Update Data Nilai SP dengan \r\n    \t\t\t\t\t\t\t\t\tID Makul={$idmakulupdate}, \r\n    \t\t\t\t\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n    \t\t\t\t\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n    \t\t\t\t\t\t\t\t\tKelas={$kelasupdate},\r\n    \t\t\t\t\t\t\t\t\tID Komponen={$vk},\r\n    \t\t\t\t\t\t\t\t\tID Mahasiswa={$k},\r\n    \t\t\t\t\t\t\t\t  Nilai=".$v[$vk]."\r\n    \t\t\t\t\t\t\t\t\t";
                                        buatlog( 34 );
                                    }
                                }
                            }
                        }
                    }
                    if ( 0 < $jmlaf )
                    {
                        $errmesg = "Data nilai   berhasil diupdate";
                        $updatenilai = 1;
                    }
                    else
                    {
                        $errmesg = "Data nilai tidak diupdate";
                    }
                }
            }
        }
        else
        {
            $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakulupdate );
            $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodiupdate );
            $vld[] = cekvaliditasthnajaran( "Tahun Akademik", $tahunupdate, $semesterupdate );
            $vld[] = cekvaliditasinteger( "Kelas", $kelasupdate, 2 );
            $vld[] = cekvaliditaskode( "Dosen", $iddosenupdate );
            foreach ( $pilihupdate as $nimid => $v21 )
            {
                $str = "data_".$nimid."_NILAI";
                $data[$nimid][NILAI] = $$str;
                $str = "data_".$nimid."_BOBOT";
                $data[$nimid][BOBOT] = $$str;
                $str = "data_".$nimid."_SIMBOL";
                $data[$nimid][SIMBOL] = $$str;
                $v21 = $data[$nimid];
                $vld[] = cekvaliditasnilaibobot( "Nilai BOBOT NIM {$nimid} : {$v21['BOBOT']}", $v21[BOBOT], 5 );
                $vld[] = cekvaliditasnilaihuruf( "Nilai SIMBOL NIM {$nimid} : {$v21['SIMBOL']}", $v21[SIMBOL], 5 );
            }
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            }
            else
            {
                foreach ( $data as $k => $v )
                {
                    $q = "UPDATE pengambilanmksp SET\r\n\t\t\t\t\t\tNILAI='{$v['NILAI']}',\r\n\t\t\t\t\t\tSIMBOL='{$v['SIMBOL']}',\r\n\t\t\t\t\t\tBOBOT='{$v['BOBOT']}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$k}'\r\n\t\t\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    $q = "UPDATE trnlmsp SET\r\n\t\t\t\t\t\tNLAKHTRNLM='{$v['SIMBOL']}',\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\tBOBOTTRNLM='{$v['BOBOT']}'\r\n\t\t\t\t\t\tWHERE NIMHSTRNLM='{$d['ID']}'\r\n\t\t\t\t\t\tAND trnlmsp.KDKMKTRNLM='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND trnlmsp.THSMSTRNLM='".( $tahunupdate - 1 )."{$semesterupdate}' \r\n\t\t\t\t\t \r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    $ketlog = "Edit Nilai SP Mahasiswa {$k}, MK={$idmakulupdate}, TAHUN={$tahunupdate}/".( $tahunupdate + 1 ).", SEM={$semesterupdate}, BOBOT={$v['BOBOT']}, SIMBOL={$v['SIMBOL']}";
                    buatlog( 58 );
                }
                $errmesg = "Data nilai sudah diupdate.";
            }
        }
    }
    else
    {
        $errmesg = "Tidak ada data yang dipilih.";
    }
    $aksi = "formtambah";
}
if ( $aksi == "lihatdata" )
{
    if ( $aksi == "lihatdata" && $pilihan == "ntambah" )
    {
        include( "prosestampileditnilai2.php" );
    }
    else if ( $aksi == "lihatdata" && $pilihan == "ntambahm" )
    {
	#echo "aaa";
        include( "prosestampileditnilaim2.php" );
    }
}
unset( $kp );
if ( $aksi == "formtambah" )
{
    if ( $jenisusers == 1 && $aturaneditnilaidosen == 0 )
    {
        echo "Maaf, Anda tidak dapat mengedit nilai.";
        exit( );
    }
    else
    {
        $aturaneditnilai = getaturan( "EDITNILAI" );
        if ( $aturaneditnilai == 1 )
        {
            $q = "SELECT mahasiswa.NAMA,mahasiswa.ID ,pengambilanmksp.SIMBOL,pengambilanmksp.BOBOT FROM mahasiswa,pengambilanmksp WHERE ".
	    "mahasiswa.ID=pengambilanmksp.IDMAHASISWA AND pengambilanmksp.IDMAKUL='{$idmakulupdate}' AND pengambilanmksp.TAHUN='{$tahunupdate}' ".
	    "AND pengambilanmksp.SEMESTER='{$semesterupdate}'AND pengambilanmksp.KELAS='{$kelasupdate}'AND SIMBOL=''ORDER BY mahasiswa.ID";
            $ht = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $ht ) )
            {
                session_register_sikad( "statusnilai" );
                $statusnilai = 1;
            }
        }
        else
        {
            session_register_sikad( "statusnilai" );
            $statusnilai = 1;
        }
    }
    if ( !session_is_registered_sikad( "statusnilai" ) || $statusnilai != 1 )
    {
        include( "passwordnilai.php" );
    }
    else if ( session_is_registered_sikad( "statusnilai" ) && $statusnilai == 1 )
    {
        if ( $aksi == "formtambah" && $pilihan == "ntambah" )
        {
			#echo "ntambah";	
            include( "prosestampileditnilai.php" );
        }
        else if ( $aksi == "formtambah" && $pilihan == "ntambahm" )
        {
			#echo "kkk";exit();
			#echo "ntambahm";	
            include( "prosestampileditnilaim.php" );
        }
        else if ( $aksi == "formtambah" && $pilihan == "editmhs" )
        {
			#echo "mm";exit();
            include( "proseseditnilaimahasiswa.php" );
        }
    }
}
if ( $aksi == "tampilkanawal" )
{
	#echo "lkkk";
    $aksi = " ";
    session_unregister_sikad( "statusnilai" );
    include( "prosestampilnilaiawal.php" );
}
if ( $aksi == "tampilkan" )
{
	echo "lll";
    $aksi = " ";
    include( "prosestampilnilai.php" );
}
if ( $aksi == "tambahawal" )
{
   
    #printmesg( $errmesg );
    session_unregister_sikad( "statusnilai" );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Edit Nilai Mata Kuliah Semester Pendek </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\"><form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>\r\n\t\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t ";
    */
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Nilai Mata Kuliah Semester Pendek");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkanawal'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>";
												foreach ( $arrayprodidepmakul as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
		echo "								</select>
										</label>
									</div>";
    if ( $jenisusers == 0 )
    {
        echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
										</div>
									</div>";
    }
    echo "							<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>    
										<div class=\"col-lg-6\">
											".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
											<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\">daftar mata kuliah</a>-->
											<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
												<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
											</div>
										</div>
									</div> 
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $waktu[year] == $i )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option {$cek} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Semester</label>    
										<label class=\"col-form-label\">
											<select name=semester class=form-control m-input> \r\n\t\t\t\t\t\t ";
												foreach ( $arraysemester as $k => $v )
												{
													echo "<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
	echo "									</select>
										</label>
									</div> ";
    $arraylabelkelas[''] = "Semua";
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>    
										<label class=\"col-form-label\">
											".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Lanjut' class=\"btn btn-brand\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	  ";
}
if ( $aksi == "tambahawalm" )
{
   
    printmesg( $errmesg );
    session_unregister_sikad( "statusnilai" );
   echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">
							<!-- BEGIN SAMPLE FORM PORTLET-->
						";
							printmesg( $errmesg );
	echo "					<div class='portlet-title'>";
								printmesg("Edit Nilai Mata Kuliah ".$judultambahan);
	echo "					</div>";										
	echo "					<div class=\"m-portlet\">				
								<!--begin::Form-->";
	echo "						<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='formtambah'>
									<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\">daftar mahasiswa</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Lanjut' class=\"btn btn-brand\"></div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				";
}
?>
