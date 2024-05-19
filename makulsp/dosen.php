<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen Pengajar SP", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM dosenpengajarsp WHERE \r\n \t\t\tIDMAKUL='{$idmakulhapus}' AND\r\n\t\t\tTAHUN='{$tahunhapus}' AND\r\n\t\t\tSEMESTER='{$semesterhapus}' AND\r\n\t\t\tKELAS='{$kelashapus}' AND\r\n\t\t\tIDPRODI='{$idprodihapus}' AND\r\n\t\t\tIDDOSEN='{$iddosenhapus}'\r\n\t\r\n\t";
        mysqli_query($koneksi,$q);
        $ketlog = "Hapus Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakulhapus}, \r\n\tTahun Akademik=".( $tahunhapus - 1 )."/{$tahunhapus},\r\n\tSemester=".$arraysemester[$semesterhapus].",\r\n\tKelas={$kelashapus},\r\n\tID Dosen={$idhapus}\r\n   ID Podi={$idprodihapus}";
        buatlog( 23 );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Dosen Pengajar dengan ID = '{$idhapus}' berhasil dihapus";
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst \r\n          WHERE IDX='{$idprodihapus}'";
            $hx = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hx ) )
            {
                $dx = sqlfetcharray( $hx );
                $kodept = $dx[KDPTIMSPST];
                $kodejenjang = $dx[KDJENMSPST];
                $kodeps = $dx[KDPSTMSPST];
            }
        }
        else
        {
            $errmesg = "Data Dosen Pengajar dengan NIDN = '{$iddosenhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen Pengajar SP", SIMPAN_DATA );
        $aksi2 = "formupdate";
    }
    else
    {
        $data[semester] = $semesterk;
        $data[tahun] = $tahunk;
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Dosen Pengajar", $iddosen, 16, false );
        $vld[] = cekvaliditasthnajaran( "Tahun Akademik/Semester", $data['tahun'], $data['semester'] );
        $vld[] = cekvaliditaskodeprodi( "Program Studi", $idprodiampu );
        $vld[] = cekvaliditasinteger( "Kelas", $data['kelas'], 2 );
        $vld[] = cekvaliditasnama( "Dosen lain", $data['dosenlain'], 4 * 32 );
        $vld[] = cekvaliditasinteger( "Jumlah Tatap Muka", $jumlahtatap, 2 );
        $vld[] = cekvaliditasinteger( "Realisasi Tatap Muka", $jumlahtatap2, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
            $aksi2 = "formupdate";
        }
        else if ( trim( $iddosen ) == "" || !isdataada( $iddosen, "dosen" ) )
        {
            $errmesg = "NIDN Dosen Pengajar harus diisi atau tidak ada Dosen dengan NIP '{$iddosen}'";
        }
        else if ( trim( $idmakul ) == "" || !isdataada( $idmakul, "makul" ) )
        {
            $errmesg = "Kode Mata Kuliah harus diisi  atau tidak ada Mata Kuliah dengan Kode '{$idmakul}'";
        }
        else if ( trim( $data[kelas] ) == "" )
        {
            $errmesg = "Kode Kelas harus diisi";
        }
        else if ( getnamamksp( "{$idmakul}", "".( $data[tahun] - 1 )."{$data['semester']}", "{$idprodiampu}", 1 ) == "" )
        {
            $errmesg = "Kode Mata Kuliah tidak ada di dalam kurikulum";
        }
        else
        {
            $sem = $semesterupdate;
            $idprodi = $idprodiampu;
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
            $hx = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hx ) )
            {
                $dx = sqlfetcharray( $hx );
                $kodept = $dx[KDPTIMSPST];
                $kodejenjang = $dx[KDJENMSPST];
                $kodeps = $dx[KDPSTMSPST];
            }
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodiupdate}'";
            $hx = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hx ) )
            {
                $dx = sqlfetcharray( $hx );
                $kodeptupdate = $dx[KDPTIMSPST];
                $kodejenjangupdate = $dx[KDJENMSPST];
                $kodepsupdate = $dx[KDPSTMSPST];
            }
            $q = "\r\n\t\t\tUPDATE dosenpengajarsp SET \r\n \t\t\tIDMAKUL='{$idmakul}',\r\n\t\t\tIDDOSEN='{$iddosen}',\r\n\t\t\tDOSENLAIN='{$data['dosenlain']}',\r\n\t\t\tTAHUN='{$data['tahun']}',\r\n\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\tIDPRODI='{$idprodiampu}'\r\n\t\t\tKELAS='{$data['kelas']}',\r\n\t\t\tTHSHM='".( $data[tahun] - 1 )."{$data['semester']}'\r\n      WHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}'  AND\r\n\t\t\tIDPRODI='{$idprodiupdate}' AND\r\n\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Update Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakulupdate}, \r\n\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\tKelas={$kelasupdate},\r\n\t\tID Dosen={$iddosen}";
            buatlog( 22 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Dosen Pengajar berhasil diupdate";
                $idmakulupdate = $idmakul;
                $kelasupdate = $data[kelas];
                $tahunupdate = $data[tahun];
                $semesterupdate = $data[semester];
                $idprodiupdate = $idprodiampu;
                $iddosenupdate = $iddosen;
            }
            else
            {
                $errmesg = "Data Dosen Pengajar tidak diupdate.";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM dosenpengajarsp WHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}' AND\r\n\t\t\tIDPRODI='{$idprodiupdate}' AND\r\n\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Dosen Pengajar" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $sem = $semesterupdate;
        $tahunlama = $tahunupdate;
        $iddosen = $d[IDDOSEN];
        $idmakul = $idmakulupdate;
        $kelas = $kelasupdate;
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
                                <span class=\"caption-subject bold uppercase\"> Update Data Dosen Pengajar </span>
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
							printmesg("Update Data Dosen Pengajar");
		echo "		</div>";
		echo "		<div class=\"m-portlet\">
						<!--begin::Form-->";
        echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "iddosenupdate", "{$d['IDDOSEN']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pengajar  *</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "iddosen", "{$d['IDDOSEN']}", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
										<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
										<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
											<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Yg Diajar/Diampu</label>   
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodiampu>";
											foreach ( $arrayprodidep as $k => $v )
											{
												$selected = "";
												if ( $d[IDPRODI] == $k )
												{
													$selected = "selected";
												}
												echo "<option value='{$k}' {$selected}>{$v}</option>";
											}
        echo "							</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>   
									<div class=\"col-lg-6\">
										".createinputtext( "idmakul", "{$d['IDMAKUL']}", " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulumSP(this.value,form.idprodiampu.value,form.tahunk.value,form.semesterk.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
										<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
										<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
											<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
										</div>
									</div>
								</div>"."
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>   
									<label class=\"col-form-label\">
										".createinputtahunajaran( "tahunk", "{$d['TAHUN']}", " class=form-control m-input  cols=50 rows=4" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester</label>   
									<label class=\"col-form-label\">
										".createinputselect( "semesterk", $arraysemester, $semesterupdate, "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kelas</label>   
									<label class=\"col-form-label\">
										".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "" )."";
        
        echo " 						</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Dosen Lain</label>   
									<label class=\"col-form-label\">
										".createinputtextarea( "data[dosenlain]", $d[DOSENLAIN], " class=form-control m-input cols=40 rows=5" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\">
										<input type=reset value='Reset' class=\"btn btn-secondary\">
									</div>
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
		<!--end::container-fluid-->
			<script>\r\n \t\t\t\tform.iddosen.focus();\r\n\t\t\t</script>";	
    }
    else
    {
        $errmesg = "Data Dosen Pengajar   tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "updatemk" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( is_array( $data ) )
    {
        $jmlupdate = 0;
        $jmlhapus = 0;
        foreach ( $datax as $k => $v )
        {
            if ( $v[cek] == 1 )
            {
                $q = "INSERT INTO  dosenpengajarsp \r\n\t\t\t\t(IDDOSEN,IDMAKUL,TAHUN,KELAS,SEMESTER,THSHM) \r\n\t\t\t\tVALUES('{$iddosen}','{$k}','{$data['tahun']}','{$v['kelas']}','{$v['semester']}','".( $data[tahun] - 1 )."{$v['semester']}')\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( sqlaffectedrows( $koneksi ) <= 0 )
                {
                    $q = "UPDATE dosenpengajarsp \r\n\t\t\t\t\tSET \r\n\t\t\t\t\t\tKELAS='{$v['kelas']}',\r\n\t\t\t\t\t\tDOSENLAIN='{$v['dosenlain']}',\r\n\t\t\t\t\t\tSEMESTER='{$v['semester']}'\t\t\t\t\t\t\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDDOSEN='{$iddosen}'\r\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\t\tAND IDMAKUL='{$k}'\r\n\t\t\t\t\tAND KELAS='{$v['kelaslama']}'\r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        ++$jmlupdate;
                    }
                }
                else
                {
                    ++$jmlupdate;
                }
            }
            else
            {
                $q = "DELETE FROM dosenpengajarsp WHERE \r\n\t\t\t\tIDDOSEN='{$iddosen}'\r\n\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\tAND IDMAKUL='{$k}'\r\n\t\t\t\tAND KELAS='{$v['kelaslama']}'\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    ++$jmlhapus;
                }
            }
        }
        if ( 0 < $jmlupdate )
        {
            $errmesg = "Pengambilan Mata Kuliah Telah ditambahkan/diupdate sebanyak {$jmlupdate} buah";
        }
        if ( 0 < $jmlhapus )
        {
            $errmesg .= "<br>Pengambilan Mata Kuliah Telah Dihapus sebanyak {$jmlhapus} buah";
        }
    }
    $aksi = "tampiledit";
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    $errmesg = token_err_mesg( "Dosen Pengajar SP", TAMBAH_DATA );
    $aksi = "tampiledit";
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditaskodeprodi( "Program Studi yang diajar", $idprodiampu, 16, false );
    $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakul );
    $vld[] = cekvaliditasinteger( "Kelas", $kelas );
    $vld[] = cekvaliditasnama( "Dosen lain", $dosenlain, 4 * 32 );
    $vld[] = cekvaliditasinteger( "Jumlah Tatap Muka", $jumlahtatap, 2 );
    $vld[] = cekvaliditasinteger( "Realisasi Tatap Muka", $jumlahtatap2, 2 );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        $aksi = "tampiledit";
    }
    else if ( trim( $iddosen ) == "" || !isdataada( $iddosen, "dosen" ) )
    {
        $errmesg = "NIDN Dosen Pengajar harus diisi atau tidak ada Dosen dengan NIP '{$iddosen}'";
    }
    else if ( trim( $idmakul ) == "" || !isdataada( $idmakul, "makul" ) )
    {
        $errmesg = "Kode Mata Kuliah harus diisi  atau tidak ada Mata Kuliah dengan Kode '{$data['idmakul']}'";
    }
    else if ( trim( $kelas ) == "" )
    {
        $errmesg = "Kode Kelas harus diisi";
    }
    else if ( getnamamksp( "{$idmakul}", "".( $data[tahun] - 1 )."{$data['semester']}", "{$idprodiampu}", 1 ) == "" )
    {
        $errmesg = "Kode Mata Kuliah tidak ada di dalam kurikulum";
    }
    else
    {
        $q = "\r\n\t\t\tINSERT INTO dosenpengajarsp (IDPRODI,IDDOSEN,IDMAKUL,TAHUN,KELAS,DOSENLAIN,SEMESTER,THSHM) \r\n\t\t\tVALUES ('{$idprodiampu}','{$iddosen}','{$idmakul}','{$data['tahun']}',\r\n\t\t\t'{$kelas}','{$dosenlain}','{$data['semester']}','".( $data[tahun] - 1 )."{$data['semester']}')\r\n\t\t";
        mysqli_query($koneksi,$q);
        $ketlog = "Tambah Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakul}, \r\n\t\tTahun Akademik=".( $data[tahun] - 1 )."/{$data['tahun']},\r\n\t\tSemester=".$arraysemester[$data[semester]].",\r\n\t\tKelas={$kelas},\r\n\t\tID Dosen={$iddosen}";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            buatlog( 21 );
            $errmesg = "Data Dosen Pengajar berhasil ditambah";
            $sem = $data[semester];
            $tahunlama = $data[tahun];
            $q = "\r\n\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponensp\r\n\t\t\t\t\tWHERE IDMAKUL='{$idmakul}'\r\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\t\tAND SEMESTER='{$data['semester']}'\r\n\t\t\t\t\tAND KELAS='{$kelas}'\r\n\t\t\t\t\tAND IDPRODI='{$idprodiampu}'\r\n\t\t\t\t\tORDER BY BOBOT\r\n\t\t\t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $q = "INSERT INTO komponensp\r\n\t\t\t\t\t\t(IDPRODI,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t('{$idprodiampu}',0,'{$idmakul}','{$data['tahun']}','{$kelas}','UTS','40','{$data['semester']}')";
                mysqli_query($koneksi,$q);
                $q = "INSERT INTO komponensp\r\n\t\t\t\t\t\t(IDPRODI,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t('{$idprodiampu}',1,'{$idmakul}','{$data['tahun']}','{$kelas}','UAS','60','{$data['semester']}')";
                mysqli_query($koneksi,$q);
            }
        }
        else
        {
            $errmesg = "Data Dosen Pengajar tidak berhasil ditambah. \r\n\t\t\tSuatu kelas Mata Kuliah pada Tahun ajaran tertentu tidak \r\n\t\t\tdapat diajar oleh lebih dari 1 dosen";
        }
    }
    $aksi = "tampiledit";
}
if ( $aksi == "tampiledit" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    if ( trim( $iddosen ) == "" || !isdataada( $iddosen, "dosen" ) )
    {
        $errmesg = "NIDN harus diisi atau tidak ada Dosen dengan NIDN '{$iddosen}'";
        $aksi = "tambahawal";
    }
    else
    {
        $q = "\r\n\t\t\tSELECT dosen.NAMA,IDDEPARTEMEN\r\n\t\t\tFROM dosen\r\n\t\t\tWHERE\r\n\t\t\tdosen.ID='{$iddosen}'\r\n \t\t";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $errmesg = "Data Dosen Tidak Ada";
            $aksi = "tambahawal";
        }
        else
        {
            #printjudulmenu( "Edit Data Dosen Pengajar" );
            #printmesg( $errmesg );
            $d = sqlfetcharray( $h );
             echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
echo "			<div class='portlet-title'>";
					printmesg("Edit Data Dosen Pengajar Semester Pendek");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
					".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "iddosen", "{$iddosen}", "" ).createinputhidden( "data[tahun]", "{$data['tahun']}", "" ).createinputhidden( "data[semester]", "{$data['semester']}", "" )."
					<div class=\"m-portlet__body\">
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>
							<label class=\"col-form-label\">".( $data[tahun] - 1 )."/{$data['tahun']}</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Semester</label>
							<label class=\"col-form-label\">".$arraysemester[$data[semester]]." </label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">NIDN</label>
							<label class=\"col-form-label\">{$iddosen} </label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama</label>
							<label class=\"col-form-label\">{$d['NAMA']} </label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Program Studi</label>
							<label class=\"col-form-label\">".$arrayprodidep[$d[IDDEPARTEMEN]]." </label>
						</div>";
			echo "		<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Yg Diajar/Diampu</label>
							<label class=\"col-form-label\">
								<select class=form-control m-input name=idprodiampu>";
			/*echo "\r\n\t\t\t\t<br>\r\n\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t\t\t\t<td >  ".$arraysemester[$data[semester]]."  </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>NIDN</td>\r\n\t\t\t\t\t\t<td >{$iddosen}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Program Studi</td>\r\n\t\t\t\t\t\t<td >".$arrayprodidep[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</div>";

            echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "iddosen", "{$iddosen}", "" ).createinputhidden( "data[tahun]", "{$data['tahun']}", "" ).createinputhidden( "data[semester]", "{$data['semester']}", "" )."\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan / Program Studi Yg Diajar/Diampu\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodiampu>\r\n\t\t\t\t\t ";
            */
			foreach ( $arrayprodidep as $k => $v )
            {
                $selected = "";
                if ( $d[IDDEPARTEMEN] == $k )
                {
                    $selected = "selected";
                }
                echo "<option value='{$k}' {$selected}>{$v}</option>";
            }
            echo "					</select> </label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>
							<div class=\"col-lg-6\">
								".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulumSP(this.value,form.idprodiampu.value,'{$data['tahun']}','{$data['semester']}');\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
								<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
								<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
									<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
								</div>
							</div>
						</div>"."
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>
							<label class=\"col-form-label\">
								".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )."
							</label>
						</div>"."
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Dosen Lain</label>
							<label class=\"col-form-label\">
								".createinputtextarea( "dosenlain", $dosenlain, " class=form-control m-input cols=40 rows=5" )."
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Tambah' class=\"btn btn-brand\">
									<input type=reset value='Reset' class=\"btn btn-secondary\">
								</div>
						</div>
						</div>
			</form>
			<script>\r\n \t\t\t\tform.idmakul.focus();\r\n\t\t\t</script>";

            $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tdosenpengajarsp.*,\r\n\t\t\t\tmakul.NAMA,\r\n\t\t\t\tmakul.SKS,makul.SEMESTER AS SEMESTERMAKUL,\r\n\t\t\t\tmakul.SKS,makul.SEMESTER AS SEMESTER\r\n\t\t\t\tFROM dosenpengajarsp,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tdosenpengajarsp.IDDOSEN='{$iddosen}'\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajarsp.IDMAKUL=makul.ID\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajarsp.TAHUN='{$data['tahun']}'\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajarsp.SEMESTER='{$data['semester']}'\r\n\t\t\t\tORDER BY \r\n\t\t\t\tdosenpengajarsp.TAHUN,dosenpengajarsp.SEMESTER,IDMAKUL,KELAS\r\n\t\t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                printmesg( "Data Mengajar M-K belum ada" );
            }
            else
            {
                #printjudulmenukecil( "Data Mata Kuliah Yang Diajar" );
                #echo "\r\n\t\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Dosen Lain</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
                echo "		<div class=\"m-portlet m-portlet--mobile\">
							<div class=\"m-portlet__head\">
								<div class=\"m-portlet__head-caption\">
									<div class=\"m-portlet__head-title\">
										<h3 class=\"m-portlet__head-text\">
											Data Mata Kuliah Semester Pendek Yang Diajar
										</h3>
									</div>					
								</div>
							</div>";
				echo "		<div class=\"m-portlet\">			
						<div class=\"m-section__content\">
							<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">
									<thead>
										<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Dosen Lain</td>\r\n\t\t\t\t\t</tr>";
				echo "				</thead>
									<tbody>";
				$i = 1;
                $semlama = "";
                while ( $d = sqlfetcharray( $h ) )
                {
                    $kelas = kelas( $i );
                    $styleerror = "";
                    $errornamakurikulum = "";
                    $namamakulkurikulum = getnamamksp( $d[IDMAKUL], "".( $data[tahun] - 1 )."{$data['semester']}", "{$d['IDPRODI']}", 1 );
                    if ( $namamakulkurikulum == "" )
                    {
                        $styleerror = "style='background-color:#ffaaaa'";
                        $errornamakurikulum = "tidak ada di kurikulum";
                    }
                    echo "\r\n\t\t\t\t\t<tr {$kelas}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n\t\t\t\t\t\t<td>{$d['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$namamakulkurikulum} {$errornamakurikulum}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>".$arraylabelkelas[$d[KELAS]]." </td>\r\n\t\t\t\t\t\t<td  nowrap>".str_replace( "\n", "<br>", $d[DOSENLAIN] )." </td>\r\n\t\t\t\t\t</tr>";
                    $totalsks += $d[SKS];
                    $total += $d[SEMESTER];
                    ++$i;
                }
                echo " \r\n\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t<td align=right colspan=4>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=4></td>\r\n\t\t\t\t\t</tr>";
                #echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<br>\r\n\t\t\t\t</div></div></div></div>";
				 echo "			</tbody>
							</table>
						</div>
					</div>  
				</div>
			</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->
		";
            }
        }
    }
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Edit Data Dosen Pengajar Semester Pendek" );
    #printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Edit Data Dosen Pengajar Semester Pendek </span>
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
						printmesg("Edit Data Dosen Pengajar Semester Pendek");
	echo "		</div>";
	echo "		<div class=\"m-portlet\">
					<!--begin::Form-->";
    echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tampiledit", "" )."
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pengajar *</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
									<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
									<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\"> 
										<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
									</div>
								</div>
							</div>"."
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
								<label class=\"col-form-label\">".createinputtahunajaran( "data[tahun]", $data[tahun], " class=form-control m-input  cols=50 rows=4" )."</label>
							</div>"."
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[semester]", $arraysemester, "{$data['semester']}", "", " class=form-control m-input" )."
								</abel>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<div class=\"col-lg-6\">
									<input type=submit value='Edit' class=\"btn btn-brand\">
									<input type=reset value='Reset' class=\"btn btn-secondary\"></div>
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
		<!--end::container-fluid-->
			<script>\r\n \t\t\t\tform.iddosen.focus();\r\n\t\t\t</script>";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildosen.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cari Data Dosen Pengajar Semester Pendek" );
    #printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Cari Data Dosen Pengajar Semester Pendek </span>
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
	echo "				<div class='portlet-title'>";
								printmesg("Cari Data Dosen Pengajar Semester Pendek");
	echo "				</div>";
										
	echo "				<div class=\"m-portlet\">
				
							<!--begin::Form-->";

    echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Mata Kuliah</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>
												<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Dosen</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodim>
												<option value=''>Semua</option>";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
											echo "<select name=tahun class=form-control m-input><option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
										<label class=\"col-form-label\">
											<select name=semester class=form-control m-input>
												<option value=''>Semua</option>";
												foreach ( $arraysemester as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodim.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
											<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
												<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
											</div>
										</div>
									</div>"."
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
											<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
											<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
												<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
											</div>
										</div>
									</div>
									";
    $arraylabelkelas[''] = "Semua";
    echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>    
										<label class=\"col-form-label\">
											".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
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
            <script>
                form.id.focus();
            </script>
		";
}
?>
