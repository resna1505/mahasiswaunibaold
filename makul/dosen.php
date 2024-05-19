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
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen Pengajar", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM dosenpengajar WHERE \r\n\t      \r\n \t\t\tIDMAKUL='{$idmakulhapus}' AND\r\n\t\t\tTAHUN='{$tahunhapus}' AND\r\n\t\t\tSEMESTER='{$semesterhapus}' AND\r\n\t\t\tKELAS='{$kelashapus}' AND\r\n\t\t\tIDPRODI='{$idprodihapus}' AND\r\n\t\t\tIDDOSEN='{$iddosenhapus}'\r\n\t\r\n\t";
        mysqli_query($koneksi,$q);
        $ketlog = "Hapus Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakulhapus}, \r\n\tTahun Akademik=".( $tahunhapus - 1 )."/{$tahunhapus},\r\n\tSemester=".$arraysemester[$semesterhapus].",\r\n\tKelas={$kelashapus},\r\n\tID Dosen={$idhapus},\r\n  ID Podi={$idprodihapus}";
        buatlog( 23 );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst \r\n          WHERE IDX='{$idprodihapus}'";
            $hx = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hx ) )
            {
                $dx = sqlfetcharray( $hx );
                $kodept = $dx[KDPTIMSPST];
                $kodejenjang = $dx[KDJENMSPST];
                $kodeps = $dx[KDPSTMSPST];
            }
            $q = "delete FROM trakd       \r\n      WHERE\r\n       THSMSTRAKD='".( $tahunhapus - 1 )."{$semesterhapus}'\r\n        AND\r\n        KDKMKTRAKD='{$idmakulhapus}' AND\r\n        KELASTRAKD='{$kelashapus}' AND\r\n        KDJENTRAKD='{$kodejenjang}' AND KDPSTTRAKD='{$kodeps}'\r\n        AND NODOSTRAKD='{$iddosenhapus}'\r\n        ";
            mysqli_query($koneksi,$q);
            $errmesg = "Data Dosen Pengajar dengan NIDN = '{$iddosenhapus}' berhasil dihapus";
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
        $errmesg = token_err_mesg( "Dosen Pengajar", SIMPAN_DATA );
        $aksi2 = "formtambah";
    }
    else
    {
        $data[semester] = $semesterk;
        $data[tahun] = $tahunk;
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
            $aksi2 = "formtambah";
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
        else if ( getnamamk( "{$idmakul}", "".( $data[tahun] - 1 )."{$data['semester']}", "{$idprodiampu}" ) == "" )
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
            $q = "UPDATE trakd\r\n       SET \r\n       THSMSTRAKD='".( $data[tahun] - 1 )."{$data['semester']}',KDPTITRAKD='{$kodept}',\r\n       KDPSTTRAKD='{$kodeps}',KDJENTRAKD='{$kodejenjang}',NODOSTRAKD='{$iddosen}',\r\n       KDKMKTRAKD='{$idmakul}',KELASTRAKD='{$data['kelas']}',\r\n       TMRENTRAKD='{$jumlahtatap}',TMRELTRAKD='{$jumlahtatap2}'\r\n       WHERE\r\n       THSMSTRAKD='".( $tahunupdate - 1 )."{$sem}'\r\n        AND\r\n        KDKMKTRAKD='{$idmakulupdate}' AND\r\n        KELASTRAKD='{$kelasupdate}' AND\r\n        KDJENTRAKD='{$kodejenjangupdate}' AND KDPSTTRAKD='{$kodepsupdate}' \r\n        AND NODOSTRAKD ='{$iddosenupdate}'\r\n        AND  KDPTITRAKD !=''\r\n         \r\n       ";
            mysqli_query($koneksi,$q);
            $q = "\r\n\t\t\tUPDATE dosenpengajar SET \r\n \t\t\tIDMAKUL='{$idmakul}',\r\n\t\t\tIDDOSEN='{$iddosen}',\r\n\t\t\tDOSENLAIN='{$data['dosenlain']}',\r\n\t\t\tTAHUN='{$data['tahun']}',\r\n\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\tKELAS='{$data['kelas']}',\r\n\t\t\tIDPRODI='{$idprodiampu}',\r\n\t\t\tTHSHM='".( $data[tahun] - 1 )."{$data['semester']}'\r\n\t\t\tWHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}' AND\r\n\t\t\tIDPRODI='{$idprodiupdate}' AND\r\n\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Update Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakulupdate}, \r\n\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\tKelas={$kelasupdate},\r\n\t\tID Dosen={$iddosen},\r\n    ID Prodi={$idprodi}";
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
                $errmesg = "Data Dosen Pengajar tidak diupdate. ";
            }
        }
    }
    unset( $_SESSION['token'] );
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM dosenpengajar WHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}' AND\r\n\t\t\tIDPRODI='{$idprodiupdate}' AND\r\n\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t";
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
        $idprodiampu = $idprodiupdate;
        include( "edittrakd.php" );
        $q = "SELECT * FROM trakd WHERE \r\n    THSMSTRAKD='".( $tahunupdate - 1 )."{$sem}'\r\n    AND\r\n    KDKMKTRAKD='{$idmakulupdate}' AND\r\n    KELASTRAKD='{$kelasupdate}' AND\r\n    NODOSTRAKD='{$iddosenupdate}' AND\r\n    KDPTITRAKD !=''\r\n    \r\n    ";
        $h2 = mysqli_query($koneksi,$q);
        $d2 = sqlfetcharray( $h2 );
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
        echo "\r\n\t\t<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
			".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "iddosenupdate", "{$d['IDDOSEN']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "sessid", "{$token}", "" )."
			<div class=\"m-portlet__body\">
				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pengajar</label>\r\n    
					<div class=\"col-lg-6\">".createinputtext( "iddosen", "{$d['IDDOSEN']}", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
						<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
						<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
							<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
						</div>
					</div>
				</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Yg Diajar/Diampu</label>\r\n    
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=idprodiampu>\r\n\t\t\t\t\t ";
						foreach ( $arrayprodidep as $k => $v )
						{
							$selected = "";
							if ( $d[IDPRODI] == $k )
							{
								$selected = "selected";
							}
							echo "<option value='{$k}' {$selected}>{$v}</option>";
						}
echo "				</select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
				<div class=\"col-lg-6\">".createinputtahunajaransemester( 0, "tahunk", "semesterk" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah * </label>\r\n    
				<div class=\"col-lg-6\">
					".createinputtext( "idmakul", "{$d['IDMAKUL']}", " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodiampu.value,form.tahunk.value,form.semesterk.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
					<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
					<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
						<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
					</div>
				</div>
			</div>
			
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Dosen Lain</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "data[dosenlain]", $d[DOSENLAIN], " class=form-control m-input cols=40 rows=5" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jumlah Tatap Muka</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "jumlahtatap", $d2[TMRENTRAKD], " class=form-control m-input size=2" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Realisasi Tatap Muka</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "jumlahtatap2", $d2[TMRELTRAKD], " class=form-control m-input size=2" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<div class=\"col-lg-6\">
					<input type=\"submit\" class=\"btn btn-brand\" value='Update'></input>
					<input type=\"reset\" class=\"btn btn-secondary\" value='Reset'></input>  
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
                $q = "INSERT INTO  dosenpengajar \r\n\t\t\t\t(IDDOSEN,IDMAKUL,TAHUN,KELAS,SEMESTER,THSHM) \r\n\t\t\t\tVALUES('{$iddosen}','{$k}','{$data['tahun']}','{$v['kelas']}','{$v['semester']}','".( $data[tahun] - 1 )."{$v['semester']}')\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( sqlaffectedrows( $koneksi ) <= 0 )
                {
                    $q = "UPDATE dosenpengajar \r\n\t\t\t\t\tSET \r\n\t\t\t\t\t\tKELAS='{$v['kelas']}',\r\n\t\t\t\t\t\tDOSENLAIN='{$v['dosenlain']}',\r\n\t\t\t\t\t\tSEMESTER='{$v['semester']}'\t\t\t\t\t\t\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDDOSEN='{$iddosen}'\r\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\t\tAND IDMAKUL='{$k}'\r\n\t\t\t\t\tAND KELAS='{$v['kelaslama']}'\r\n\t\t\t\t\t";
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
                $q = "DELETE FROM dosenpengajar WHERE \r\n\t\t\t\tIDDOSEN='{$iddosen}'\r\n\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\tAND IDMAKUL='{$k}'\r\n\t\t\t\tAND KELAS='{$v['kelaslama']}'\r\n\t\t\t\t";
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
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen Pengajar", TAMBAH_DATA );
        $aksi = "tampiledit";
    }
    else
    {
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
        else
        {
            if ( trim( $iddosen ) == "" || !isdataada( $iddosen, "dosen" ) )
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
            else if ( getnamamk( "{$idmakul}", "".( $data[tahun] - 1 )."{$data['semester']}", "{$idprodiampu}" ) == "" )
            {
                $errmesg = "Kode Mata Kuliah tidak ada di dalam kurikulum";
            }
            else
            {
                $q = "\r\n\t\t\tINSERT INTO dosenpengajar (IDPRODI,IDDOSEN,IDMAKUL,TAHUN,KELAS,DOSENLAIN,SEMESTER,THSHM) \r\n\t\t\tVALUES ('{$idprodiampu}','{$iddosen}','{$idmakul}','{$data['tahun']}',\r\n\t\t\t'{$kelas}','{$dosenlain}','{$data['semester']}','".( $data[tahun] - 1 )."{$data['semester']}')\r\n\t\t";
                mysqli_query($koneksi,$q);
                echo mysqli_error($koneksi);
                $ketlog = "Tambah Dosen Pengajar Mata Kuliah dengan ID Makul={$idmakul}, \r\n\t\tTahun Akademik=".( $data[tahun] - 1 )."/{$data['tahun']},\r\n\t\tSemester=".$arraysemester[$data[semester]].",\r\n\t\tKelas={$kelas},\r\n\t\tID Dosen={$iddosen}";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    buatlog( 21 );
                    $errmesg = "Data Dosen Pengajar berhasil ditambah";
                    $sem = $data[semester];
                    $tahunlama = $data[tahun];
                    include( "edittrakd.php" );
                    $q = "\r\n\t\t\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\t\t\tWHERE IDMAKUL='{$idmakul}'\r\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\t\tAND SEMESTER='{$data['semester']}'\r\n\t\t\t\t\tAND KELAS='{$kelas}'\r\n\t\t\t\t\tAND IDPRODI='{$idprodiampu}'\r\n\t\t\t\t\tORDER BY BOBOT\r\n\t\t\t\t";
                    $h = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $h ) <= 0 )
                    {
                        $q = "INSERT INTO komponen\r\n\t\t\t\t\t\t(IDPRODI,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t('{$idprodiampu}',0,'{$idmakul}','{$data['tahun']}','{$kelas}','UTS','40','{$data['semester']}')";
                        mysqli_query($koneksi,$q);
                        $q = "INSERT INTO komponen\r\n\t\t\t\t\t\t(IDPRODI,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t('{$idprodiampu}',1,'{$idmakul}','{$data['tahun']}','{$kelas}','UAS','60','{$data['semester']}')";
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
    }
}
if ( $aksi == "tampiledit" && $REQUEST_METHOD == POST )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
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
					printmesg("Edit Data Dosen Pengajar");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->
                <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
				".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "iddosen", "{$iddosen}", "" ).createinputhidden( "data[tahun]", "{$data['tahun']}", "" ).createinputhidden( "data[semester]", "{$data['semester']}", "" ).createinputhidden( "sessid", "{$token}", "" )."";
			#echo "\r\n\t\t\t\t<br>\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t\t<tr  >\r\n\t\t\t\t\t\t<td width=250 class=judulform>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t\t\t\t<td >  ".$arraysemester[$data[semester]]."  </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>NIDN</td>\r\n\t\t\t\t\t\t<td >{$iddosen}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Program Studi Dosen</td>\r\n\t\t\t\t\t\t<td >".$arrayprodidep[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t";
            #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "iddosen", "{$iddosen}", "" ).createinputhidden( "data[tahun]", "{$data['tahun']}", "" ).createinputhidden( "data[semester]", "{$data['semester']}", "" ).createinputhidden( "sessid", "{$token}", "" )."\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=250>\r\n\t\t\t\t\tJurusan / Program Studi Yg Diajar/Diampu\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodiampu>\r\n\t\t\t\t\t ";
            echo "<div class=\"m-portlet__body\">
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
						<div class=\"col-lg-6\">".( $data[tahun] - 1 )."/{$data['tahun']}</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
						<div class=\"col-lg-6\">".$arraysemester[$data[semester]]."  </div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">NIDN</label>\r\n    
						<div class=\"col-lg-6\">{$iddosen}</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
						<div class=\"col-lg-6\">{$d['NAMA']}</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Program Studi Dosen</label>\r\n    
						<div class=\"col-lg-6\">".$arrayprodidep[$d[IDDEPARTEMEN]]."</div>
					</div>";
            echo "	<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Yg Diajar/Diampu</label>\r\n    
						<div class=\"col-lg-6\">
							<select class=form-control m-input name=idprodiampu>\r\n\t\t\t\t\t ";
            
								foreach ( $arrayprodidep as $k => $v )
								{
									$selected = "";
									if ( $d[IDDEPARTEMEN] == $k )
									{
										$selected = "selected";
									}
									echo "<option value='{$k}' {$selected}>{$v}</option>";
								}
            echo "			</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>\r\n    
						<div class=\"col-lg-6\">
							".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodiampu.value,'{$data['tahun']}','{$data['semester']}');\" placeholder=\"Ketik Kode / Nama Makul...\" " )."
							<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
								<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
									<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
								</div>
						</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>\r\n    
						<div class=\"col-lg-6\">".createinputselect( "kelas", $arraylabelkelas, $d[KELAS], "", "" )."</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Dosen Lain</label>\r\n    
						<div class=\"col-lg-6\">".createinputtextarea( "dosenlain", $dosenlain, " class=form-control m-input cols=40 rows=5" )."</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Jumlah Tatap Muka</label>\r\n    
						<div class=\"col-lg-6\">".createinputtext( "jumlahtatap", $jumlahtatap, " class=form-control m-input size=2" )."</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Realisasi Tatap Muka</label>\r\n    
						<div class=\"col-lg-6\">".createinputtext( "jumlahtatap2", $jumlahtatap2, " class=form-control m-input size=2" )."</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
					</div>
				</div>
			</form>
			";
            $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tdosenpengajar.*,\r\n\t\t\t\tmakul.NAMA,\r\n\t\t\t\tmakul.SKS,makul.SEMESTER AS SEMESTERMAKUL\r\n\t\t\t\tFROM dosenpengajar,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tdosenpengajar.IDDOSEN='{$iddosen}'\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajar.IDMAKUL=makul.ID\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajar.TAHUN='{$data['tahun']}'\r\n\t\t\t\tAND\r\n\t\t\t\tdosenpengajar.SEMESTER='{$data['semester']}'\r\n\t\t\t\tORDER BY \r\n\t\t\t\tdosenpengajar.TAHUN,dosenpengajar.SEMESTER,IDMAKUL,KELAS\r\n\t\t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                printmesg( "Data Mengajar M-K belum ada" );
            }
            else
            {
                #printjudulmenukecil( "Data Mata Kuliah Yang Diajar" );
                #echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td>Kode MK</td>\r\n\t\t\t\t\t\t<td>Nama MK</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik/Semester</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Dosen Lain</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    echo "		<div class=\"m-portlet m-portlet--mobile\">
							<div class=\"m-portlet__head\">
								<div class=\"m-portlet__head-caption\">
									<div class=\"m-portlet__head-title\">
										<h3 class=\"m-portlet__head-text\">
											Data Mata Kuliah Yang Diajar
										</h3>
									</div>					
								</div>
							</div>";
				/*echo "		<div class=\"m-portlet__body\">
							<!--begin: Datatable -->
							<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_3\">
								<thead>
									<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td>Kode MK</td>\r\n\t\t\t\t\t\t<td>Nama MK</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik/Semester</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Dosen Lain</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
				echo "			</thead>
									<tbody>";*/
		echo "		<div class=\"m-portlet\">			
						<div class=\"m-section__content\">
							<div class=\"table-responsive\">
								<table class=\"table table-bordered table-hover\">
									<thead>
										<tr class=juduldata{$cetak} align=center><td>No</td>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td>Kode MK</td>\r\n\t\t\t\t\t\t<td>Nama MK</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik/Semester</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>Dosen Lain</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
		echo "						</thead>
									<tbody>";
				$i = 1;
                $semlama = "";
                while ( $d = sqlfetcharray( $h ) )
                {
                    $kelas = kelas( $i );
                    $styleerror = "";
                    $errornamakurikulum = "";
                    $datamk = getdatamk( $d[IDMAKUL], "".( $data[tahun] - 1 )."{$data['semester']}", "{$d['IDPRODI']}" );
                    $namamakulkurikulum = $datamk[NAKMKTBKMK];
                    $d[SEMESTERMAKUL] = $datamk[SEMESTBKMK];
                    if ( $namamakulkurikulum == "" )
                    {
                        $styleerror = "style='background-color:#ffaaaa'";
                        $errornamakurikulum = "tidak ada di kurikulum";
                    }
                    echo "\r\n\t\t\t\t\t<tr {$styleerror} {$kelas}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n\t\t\t\t\t\t<td>{$d['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$namamakulkurikulum} {$errornamakurikulum}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} / ".$arraysemester[$d[SEMESTER]]."</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>".$arraylabelkelas[$d[KELAS]]." </td>\r\n\t\t\t\t\t\t<td  nowrap>".str_replace( "\n", "<br>", $d[DOSENLAIN] )." </td>\r\n\t\t\t\t\t</tr>";
                    $totalsks += $d[SKS];
                    $total += $d[SEMESTER];
                    ++$i;
                }
                echo " \r\n\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t<td align=right colspan=4>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=4></td>\r\n\t\t\t\t\t</tr>";
                #echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<br>\r\n\t\t\t\t";
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
		<script>\r\n \t\t\t\tform.idmakul.focus();\r\n\t\t\t</script>\r\n \t\t";
            }
        }
    }
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Edit Data Dosen Pengajar" );
    #printmesg( $errmesg );

   
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
echo "			<div class='portlet-title'>";
					printmesg("Edit Data Dosen Pengajar");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->";
				#echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tampiledit", "" )."<tr class=judulform>\r\n\t\t\t<td class=judulform>NIDN Dosen Pengajar *</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.iddosen.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">\r\n               <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0, "data[tahun]", "data[semester]" )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n    \r\n    \r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Edit' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.iddosen.focus();\r\n\t\t\t</script></div></div></div></div></div><br><br><br><br><br><br><br><br>\r\n \t\t";
    echo "\r\n\t\t<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
		".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tampiledit", "" )."
		<div class=\"m-portlet__body\">
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pengajar *</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\" " )."
					<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
					<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
						<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
					</div>
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
				<div class=\"col-lg-6\">".createinputtahunajaransemester( 0, "data[tahun]", "data[semester]" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<div class=\"col-lg-6\">
					<input type=submit value='Edit' class=\"btn btn-brand\">
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
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildosen.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Dosen Pengajar " );
    #printmesg( $errmesg );
   /* echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Lihat Data Dosen Pengajar </span>
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
								printmesg("Cari Data Dosen Pengajar");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Mata Kuliah</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=idprodi>
												<option value=''>Semua</option>";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
		echo "								</select>";
    echo "								</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Dosen</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=idprodim>
												<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>";    
    echo"								</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
										<div class=\"col-lg-6\">".createinputtahunajaransemester( )." </div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodim.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen </a>-->
											<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
												<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10  id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
											<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
											<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
												<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
											</div>
										</div>
									</div>
									";

										$arraylabelkelas[''] = "Semua";
    
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
										<div class=\"col-lg-6\">".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )."</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
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
									<script>\r\n \t\t\t\tform.iddosen.focus();\r\n\t\t\t</script>
									";
}
?>
