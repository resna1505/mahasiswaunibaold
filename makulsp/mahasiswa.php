<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#echo $aksi;exit();
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "KRS SP", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswahapus}'";
        $h = mysqli_query($koneksi,$q);
        unset( $d );
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
        }
        if ( $tingkataksesusers[$kodemenu] == "T" && ( $statusoperatormakul == 1 && $prodis == $d[IDPRODI] || $prodis == "" ) )
        {
            $q = "DELETE FROM pengambilanmksp WHERE \r\n \t\t\tIDMAKUL='{$idmakulhapus}' AND\r\n\t\t\tTAHUN='{$tahunhapus}' AND\r\n\t\t\tSEMESTER='{$semesterhapus}' AND\r\n\t\t\tIDMAHASISWA='{$idmahasiswahapus}'\r\n\t\r\n\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Hapus Pengambilan Mata Kuliah SP dengan ID Makul={$idmakulhapus}, \r\n\tTahun Akademik=".( $tahunhapus - 1 )."/{$tahunhapus},\r\n\tSemester=".$arraysemester[$semesterhapus].",\r\n\tID Mahasiswa={$idmahasiswahapus} ";
            buatlog( 26 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Pengambilan M-K Mahasiswa SP dengan ID = '{$idhapus}' berhasil dihapus";
                $q = "DELETE FROM trnlmsp WHERE \r\n    \t\t\t\tNIMHSTRNLM='{$idmahasiswahapus}'\r\n    \t\t\t\tAND THSMSTRNLM='".( $tahunhapus - 1 )."{$semesterhapus}'\r\n    \t\t\t\tAND KDKMKTRNLM='{$idmakulhapus}'\r\n    \t\t\t\t \r\n    \t\t\t\t";
                mysqli_query($koneksi,$q);
            }
            else
            {
                $errmesg = "Data Pengambilan M-K SP Mahasiswa dengan ID = '{$idhapus}' tidak berhasil dihapus";
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "KRS", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakul, 16, false );
        $vld[] = cekvaliditasnim( "NIM", $idmahasisa, 16, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $data['tahun'], $data['semester'] );
        $vld[] = cekvaliditasinteger( "Semester", $data['kelas'], 2, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
        {
            $errmesg = "NIM harus diisi atau tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
        }
        else if ( trim( $idmakul ) == "" || !isdataada( $idmakul, "makul" ) )
        {
            $errmesg = "Kode Mata Kuliah harus diisi  atau tidak ada Mata Kuliah dengan Kode '{$idmakul}'";
        }
        else if ( trim( $data[semester] ) == "" || !isintegerpositif( $data[semester] ) )
        {
            $errmesg = "Semester Mata Kuliah harus diisi dengan angka > 0";
        }
        else if ( trim( $data[kelas] ) == "" )
        {
            $errmesg = "Kode Kelas harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tSELECT  IDPRODI,\r\n\t\t\tKDPSTMSMHS,KDJENMSMHS \r\n\t\t\tFROM  mahasiswa,msmhs\r\n\t\t\tWHERE\r\n\t\t\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\t\t  mahasiswa.ID='{$idmahasiswa}'\r\n\t\t  {$qfilter}\r\n \t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $errmesg = "Data Mahasiswa Tidak Ada";
                $aksi = "tambahawal";
            }
            else
            {
                $d = sqlfetcharray( $h );
                $idprodimhs = $d[IDPRODI];
                $kodeprodi = $d[KDPSTMSMHS];
                $kodejenjang = $d[KDJENMSMHS];
                $q = "SELECT SEMESTBKMK  +0 AS SEMESTER\r\n\t\tFROM tbkmksp\r\n\t\tWHERE\r\n\t\t  tbkmksp.KDKMKTBKMK ='{$idmakul}' AND\r\n \t\t  tbkmksp.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\r\n      tbkmksp.KDPSTTBKMK='{$d['KDPSTMSMHS']}' AND\r\n      tbkmksp.KDJENTBKMK='{$d['KDJENMSMHS']}'  ";
                $h = mysqli_query($koneksi,$q);
                echo mysqli_error($koneksi);
                if ( sqlnumrows( $h ) <= 0 )
                {
                    $errmesg = "Mata Kuliah tidak ada di Kurikulum pada tahun ( ".( $data[tahun] - 1 )."/{$data['tahun']} ) dan semester ".$arraysemester[$data[semester]]." untu Prodi ".$arrayprodidep[$idprodimhs]."";
                }
                else
                {
                    $d = sqlfetcharray( $h );
                    $q = "\r\n\t\t\tUPDATE pengambilanmksp SET \r\n \t\t\tIDMAKUL='{$idmakul}',\r\n\t\t\tIDMAHASISWA='{$idmahasiswa}',\r\n\t\t\tTHNSM='".( $data[tahun] - 1 )."{$data['semester']}',\r\n\t\t\tTAHUN='{$data['tahun']}',\r\n\t\t\tSEMESTERMAKUL='{$d['SEMESTER']}',\r\n\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\tKELAS='{$data['kelas']}'\r\n\t\t\tWHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tIDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t";
                    mysqli_query($koneksi,$q);
                    $ketlog = "Update Pengambilan Mata Kuliah SP dengan ID Makul={$idmakulupdate}, \r\n\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\tID Mahasiswa={$idmahasiswaupdate} ";
                    buatlog( 25 );
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Pengambilan M-K Mahasiswa berhasil diupdate";
                        $idmakulupdate = $idmakul;
                        $kelasupdate = $data[kelas];
                        $tahunupdate = $data[tahun];
                        $semesterupdate = $data[semester];
                    }
                    else
                    {
                        $errmesg = "Data Pengambilan M-K Mahasiswa tidak diupdate. Data memang tidak diubah atau \r\n\t\t\tSeorang Mahasiswa tidak dapat mengambil dua mata kuliah yang sama pada tahun ajaran yang sama";
                    }
                }
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM pengambilanmksp WHERE \r\n \t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tIDMAHASISWA='{$idmahasiswaupdate}'\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Pengambilan M-K Mahasiswa" );
       # printmesg( $errmesg );
        $d = sqlfetcharray( $h );
       echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
							printmesg("Update Data Pengambilan M-K Semester Pendek Mahasiswa");
		echo "		</div>";
		echo "		<div class=\"m-portlet\">
						<!--begin::Form-->";
        echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							".createinputhidden( "pilihan", $pilihan, "" ).
							createinputhidden( "aksi", "update", "" ).
							createinputhidden( "sessid", "{$token}", "" ).
							createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).
							createinputhidden( "idmahasiswaupdate", "{$idmahasiswaupdate}", "" ).
							createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).
							createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">NIM  Mahasiswa *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "idmahasiswa", "{$d['IDMAHASISWA']}", " class=form-control m-input  size=20 readonly " )."
										<!--<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>
										<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
											<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
										</div>-->
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "idmakul", "{$d['IDMAKUL']}", " class=form-control m-input  size=10 readonly" )."
										<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtahunajaran( "data[tahun]", "{$d['TAHUN']}", " class=form-control m-input  cols=50 rows=4" )."
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[semester]", $arraysemester, $semesterupdate, "", " class=form-control m-input" )."
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\">
										<input type=reset value='Reset' class=\"btn btn-secondary\">
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
                form.idmahasiswa.focus();
            </script>
    ";
    }
    else
    {
        $errmesg = "Data Pengambilan M-K Mahasiswa  tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "updatemk" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "KRS", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $jmlupdate = 0;
        $jmlhapus = 0;
        $j = 0;
        while ( $j < $count )
        {
            $ttmp = "idambil_{$j}";
            $idambil[$$ttmp] = 1;
            ++$j;
        }
        foreach ( $datax as $k => $v )
        {
            if ( $idambil[$k] == 1 && $aksi2 == "ambil" )
            {
                $q = "INSERT INTO  pengambilanmksp \r\n\t\t\t\t(IDMAHASISWA,IDMAKUL,TAHUN,KELAS,SEMESTER,SEMESTERMAKUL,SKSMAKUL,NAMA,THNSM) \r\n\t\t\t\tVALUES('{$idmahasiswa}','{$k}','{$data['tahun']}','{$v['kelas']}',{$data['semester']},\r\n\t\t\t\t'{$v['semester']}','{$v['sks']}','{$v['nama']}', '".( $data[tahun] - 1 )."{$data['semester']}')\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( sqlaffectedrows( $koneksi ) <= 0 )
                {
                    $q = "UPDATE pengambilanmksp \r\n\t\t\t\t\tSET \r\n\t\t\t\t\t\tKELAS='{$v['kelas']}',\r\n\t\t\t\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\t\t\t\tSEMESTERMAKUL='{$v['semester']}',\t\t\t\t\t\t\r\n\t\t\t\t\t\tSKSMAKUL='{$v['sks']}',\r\n\t\t\t\t\t\tNAMA='{$v['nama']}'\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\t\tAND IDMAKUL='{$k}'";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        mysqli_query($koneksi,$q);
                        $ketlog = "Update Pengambilan Mata Kuliah dengan ID Makul={$k}, \r\n\t\t\t\t\t\tTahun Akademik=".( $data[tahun] - 1 )."/{$data['tahun']},\r\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\r\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                        buatlog( 25 );
                        $sem = $data[semester];
                        $tahunlama = $data[tahun];
                        include( "edittrakm.php" );
                        ++$jmlupdate;
                    }
                }
                else
                {
                    ++$jmlupdate;
                    $ketlog = "Tambah Pengambilan Mata Kuliah dengan ID Makul={$k}, \r\n\t\t\t\t\t\tTahun Akademik=".( $data[tahun] - 1 )."/{$data['tahun']},\r\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\r\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                    buatlog( 24 );
                    $sem = $data[semester];
                    $tahunlama = $data[tahun];
                }
            }
            else if ( $idambil[$k] == 1 && $aksi2 == "batal" )
            {
                $q = "DELETE FROM pengambilanmksp WHERE \r\n\t\t\t\tIDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND TAHUN='{$data['tahun']}'\r\n\t\t\t\tAND IDMAKUL='{$k}'\r\n\t\t\t\tAND SEMESTER='{$data['semester']}'\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Hapus Pengambilan Mata Kuliah dengan ID Makul={$k}, \r\n\t\t\t\t\t\tTahun Akademik=".( $data[tahun] - 1 )."/{$data['tahun']},\r\n\t\t\t\t\t\tSemester=".$arraysemester[$data[semester]].",\r\n\t\t\t\t\t\tID Mahasiswa={$idmahasiswa} ";
                    buatlog( 26 );
                    $q = "DELETE FROM trnlmsp WHERE \r\n    \t\t\t\tNIMHSTRNLM='{$idmahasiswa}'\r\n    \t\t\t\tAND THSMSTRNLM='".( $data[tahun] - 1 )."{$data['semester']}'\r\n    \t\t\t\tAND KDKMKTRNLM='{$k}'\r\n    \t\t\t\t \r\n    \t\t\t\t";
                    mysqli_query($koneksi,$q);
                    $q = "SELECT IDMAHASISWA FROM pengambilanmksp \r\n          WHERE \r\n          IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'";
                    $h = mysqli_query($koneksi,$q);
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
if ( $aksi == "tampiledit" )
{
	#echo "kkk";exit();
	#print_r($data);
    $tmpcetak = "";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
    {
        $errmesg = "NIM harus diisi atau tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
        $aksi = "tambahawal";
    }
    else if ( !ismahasiswaaktif( $idmahasiswa ) )
    {
        $errmesg = "Data tidak dapat diproses karena mahasiswa dengan ID '{$idmahasiswa}' DO/Lulus/Cuti";
        $aksi = "tambahawal";
    }
    else
    {
        if ( trim( $data[semester] ) == "" || !isintegerpositif( $data[semester] ) )
        {
            $errmesg = "Semester Mata Kuliah harus diisi dengan angka > 0";
            $aksi = "tambahawal";
        }
        else
        {
            if ( $prodis != "" )
            {
                $qfilter = " AND mahasiswa.IDPRODI='{$prodis}' ";
            }
            $q = "\r\n\t\t\tSELECT mahasiswa.NAMA,ANGKATAN,IDPRODI,KELAS AS KELASDEFAULT,\r\n      KDPSTMSMHS,KDJENMSMHS,SISTEMKRS \r\n\t\t\t\r\n\t\t\tFROM  mahasiswa,msmhs\r\n\t\t\tWHERE\r\n\t\t\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\t\t  mahasiswa.ID='{$idmahasiswa}'\r\n\t\t  {$qfilter}\r\n \t\t";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $errmesg = "Data Mahasiswa  Tidak Ada";
                $aksi = "tambahawal";
            }
            else
            {
                $d = sqlfetcharray( $h );
                if ( $data[semester] != 3 )
                {
                    $semesterx = "".( ( $data[tahun] - 1 - $d[ANGKATAN] ) * 2 + $data[semester] )."";
                    $kurawal = "(";
                    $kurtutup = ")";
                }
                if ( $data[semester] != 3 && $semesterx <= 0 )
                {
                    $errmesg = "Tahun Akademik salah. Mahasiswa ybs belum masuk pada tahun ajaran yang dipilih.";
                    $aksi = "tambahawal";
                }
                else
                {
                    #printjudulmenu( "Edit Data Pengambilan M-K" );
                    #printmesg( $errmesg );
					echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printtitle("Edit Data Pengambilan M-K Semester Pendek");
								echo	"</div>
										
									</div>
									<div class='portlet-body form'>
                            <div class=\"portlet-body\">
						<div class=\"table-scrollable\">";
                    $angkatanx = $d[ANGKATAN];
                    $sistemkrs = $d[SISTEMKRS];
                    $q = "SELECT sksmaksimumsp.* \r\n            FROM sksmaksimumsp ,mahasiswa\r\n            WHERE \r\n            mahasiswa.IDPRODI=sksmaksimumsp.IDPRODI\r\n              AND mahasiswa.ID='{$idmahasiswa}'\r\n            ";
                    $hs = mysqli_query($koneksi,$q);
                    $jenisip = 0;
                    if ( 0 < sqlnumrows( $hs ) )
                    {
                        $ds = sqlfetcharray( $hs );
                        $sksmaksimum = $ds[SKS];
                        $semesteracuan = $ds[SEMESTER];
                        $jenisip = $ds[JENISIP] + 0;
                    }

		    $qmksp = "SELECT SUM(SKSMAKUL) AS SKSEMTRAKM FROM pengambilanmksp \n    WHERE IDMAHASISWA='{$idmahasiswa}' AND TAHUN='".$data['tahun']."'";
					
		    #echo $qmksp.'<br>';
		    $hmksp = doquery($koneksi,$qmksp);
		    $sksmkspsekarang = 0;
		    if ( 0 < sqlnumrows( $hmksp ) )
		    {
			$dmksp = sqlfetcharray( $hmksp );
			$sksmkspsekarang = $dmksp['SKSEMTRAKM'];
		    }
		    $sksdiambilsp = $sksmkspsekarang;
                    $thnlalu = $data[tahun] - 1;
                    $semlalu = $data[semester];
                    if ( 0 < $semesteracuan )
                    {
                        if ( $semlalu % 2 == 0 )
                        {
                            $thnlalu = $thnlalu - floor( $semesteracuan / 2 );
                            if ( $semesteracuan % 2 == 0 )
                            {
                                $semlalu = 2;
                            }
                            else
                            {
                                $semlalu = 1;
                            }
                        }
                        else
                        {
                            $thnlalu = $thnlalu - ceil( $semesteracuan / 2 );
                            if ( $semesteracuan % 2 == 0 )
                            {
                                $semlalu = 1;
                            }
                            else
                            {
                                $semlalu = 2;
                            }
                        }
                    }
                    if ( $data[semester] == 2 )
                    {
                        $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
                    }
                    else
                    {
                        $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
                    }
                    if ( $jenisip == 0 )
                    {
                        $qtrakm = " NLIPSTRAKM AS ";
                        $jtrakm = " Semester (IPS) ";
                    }
                    else
                    {
                        $qtrakm = " NLIPKTRAKM AS ";
                        $jtrakm = " Kumulatif (IPK) ";
                    }
                    $q = "\r\n    \t\t\tSELECT {$qtrakm} NLIPSTRAKM\r\n    \t\t\tFROM  trakm\r\n    \t\t\tWHERE\r\n    \t\t  NIMHSTRAKM='{$idmahasiswa}' AND\r\n    \t\t  THSMSTRAKM<='{$thnlalu}{$semlalu}'\r\n    \t\t  ORDER BY THSMSTRAKM DESC LIMIT 0,1\r\n    \t\t  \r\n     \t\t";
                    $hip = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hip ) )
                    {
                        $dip = sqlfetcharray( $hip );
                        $ips = $dip[NLIPSTRAKM];
                    }
                    else
                    {
                        $ips = "Tidak ada";
                    }
                    $semesterkrs = $semesterx;
                    /*$tmpcetak .= "\r\n\t\t\t\t<br>\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t\t\t\t<td > {$semesterx} {$kurawal} ".$arraysemester[$data[semester]]." {$kurtutup} </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td >{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Angkatan</td>\r\n\t\t\t\t\t\t<td >{$d['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >IP {$jtrakm} ";
                    */
					$tmpcetak .= "<table class=\"table table-striped table-bordered table-hover\"><tr>\r\n\t\t\t\t\t\t<td class=judulform width=25%>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td >".( $data[tahun] - 1 )."/{$data['tahun']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t\t\t\t<td > {$semesterx} {$kurawal} ".$arraysemester[$data[semester]]." {$kurtutup} </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td >{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td >{$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >Angkatan</td>\r\n\t\t\t\t\t\t<td >{$d['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >IP {$jtrakm} ";
                    
					if ( 0 < $semesteracuan )
                    {
                        $tmpcetak .= "{$semesteracuan} Semester Lalu";
                    }
                    else
                    {
                        $tmpcetak .= "semester ini";
                    }
                    $tmpcetak .= "</td>\r\n\t\t\t\t\t\t<td ><b>{$ips}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t</table>\r\n\t\t\t";
                    $idprodimhs = $d[IDPRODI];
                    $kodeprodi = $d[KDPSTMSMHS];
                    $kodejenjang = $d[KDJENMSMHS];
                    $q = "SELECT * FROM syaratkrssp WHERE IDPRODI='{$idprodimhs}' ORDER BY SKS DESC";
                    $hkrs = mysqli_query($koneksi,$q);
                    if(0 < sqlnumrows( $hkrs )){
						while ($dkrs = sqlfetcharray( $hkrs ))
						{
							$arraysyaratkrs["{$dkrs['SKS']}"] = "{$dkrs['IPS']}";
						}
					}
                    if ( $idprodi == "" )
                    {
                        $idprodi = $d[IDPRODI];
                    }
					//tutup div kotak atas
					$tmpcetak.="				
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>";
                    $tmpcetak .= "\r\n\t\t<form  action=index.php method=post>\r\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "{$aksi}", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\r\n\t\t</form>";
                    /*$tmpcetak .="<form name=form action=index.php method=post>";
					*/
					$q = "SELECT makul.ID,tbkmksp.NAKMKTBKMK  NAMA  ,THSMSTBKMK,\r\n      tbkmksp.KDWPLTBKMK,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER\r\n\t\tFROM makul,tbkmksp\r\n\t\tWHERE\r\n\t\t  makul.ID=tbkmksp.KDKMKTBKMK AND\r\n\t\t  tbkmksp.THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\r\n\t\t  tbkmksp.STKMKTBKMK='A' AND\r\n\t\t\t\t(  (KDPSTTBKMK='{$kodeprodi}' AND KDJENTBKMK='{$kodejenjang}' ))\r\n\t\t\tORDER BY SEMESTER,ID\r\n\t\t";
                    #echo $q;exit();
					$hp = mysqli_query($koneksi,$q);
                    if ( sqlnumrows( $hp ) <= 0 )
                    {
                        printmesg( "Data Mata Kuliah Jurusan / Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
                    }
                    else
                    {
                        /*$tmpcetak .= "\r\n        \t\t\t\t<form action=cetakkrs.php method=post target=_blank>\r\n\t\t\t\t  <input type=hidden name=idmahasiswaupdate value='{$idmahasiswa}'>\r\n\t\t\t\t  <input type=hidden name=tahunupdate value='{$data['tahun']}'>\r\n          <input type=hidden name=semesterupdate value='{$data['semester']}'>\r\n          <input type=submit value='Cetak KRS'>\r\n\t\t\t\t</form>\t\t\r\n\t\t<table>\r\n\t\t<tr valign=top><td width=50%>\r\n\t\t<b>Kurikulum Mata Kuliah Semester Ini</b><br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "sessid", "{$token}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" );
                        $tmpcetak .= "\r\n\t\t\t\t<table  class=form width=100%>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td colspan=8 align=right>\r\n\t\t\t\t\t\t<a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \r\n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \r\n\t\t\t\t\t<input type=submit class=form-control m-input name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t<input type=submit class=form-control m-input name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Wajib/Pilihan</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t<td>Syarat</td>\r\n \t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t<td>Ambil</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
                        */
						$tmpcetak .= "<form action=cetakkrs.php method=post target=_blank>\r\n\t\t\t\t  <input type=hidden name=idmahasiswaupdate value='{$idmahasiswa}'>\r\n\t\t\t\t  <input type=hidden name=tahunupdate value='{$data['tahun']}'>\r\n          <input type=hidden name=semesterupdate value='{$data['semester']}'><input type=submit class=\"btn btn-brand\" value='Cetak KRS'></form>";
                        $tmpcetak.="
								<div class=\"row\">
									<div class=\"col-md-6\">	
										<div class=\"m-portlet m-portlet--mobile\">
													<div class=\"m-portlet__head\">
														<div class=\"m-portlet__head-caption\">
															<div class=\"m-portlet__head-title\">
																<h3 class=\"m-portlet__head-text\">
																	Kurikulum Mata Kuliah Semester Ini
																</h3>
															</div>					
														</div>
													</div>";
						$tmpcetak .= "			<form name=form action=index.php method=post>".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil", "{$pilihtampil}", "" )."\r\n\t\t\t".createinputhidden( "pilihtampil2", "{$pilihtampil2}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "sessid", "{$token}", "" )."".createinputhidden( "data[semester]", "{$data['semester']}", "" );	
						 $tmpcetak.= "					<div class=\"m-portlet\">			
															<div class=\"m-section__content\">
																<div class=\"table-responsive\">
																	<table class=\"table table-bordered table-hover\">
																		<thead>	
																			<tr align=center class=juduldata><td colspan=8 align=left><a href='#' onClick='cekall();return false;'>[pilih semua]</a>  \r\n\t\t\t\t\t\t<a href='#' onClick='uncekall();return false;'>[batal pilih semua]</a> \r\n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t<input type=submit class=\"btn btn-secondary\" name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>
																			<tr align=center class=juduldata><td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Wajib/Pilihan</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t<td>Syarat</td>\r\n \t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t<td>Ambil</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
										echo "							</thead>
									<tbody>";
						$i = 0;
                        $semlama = "";
                        $startawal = 0;
                        while ( $dp = sqlfetcharray( $hp ) )
                        {
                            /*if ( !( $dp[SEMESTER] % 2 == $semesterx % 2 ) )
                            {
                                continue;
                            }*/
							if ( $pilihtampil == 1 && !( $dp[SEMESTER] % 2 == $semesterx % 2 ) )
                            {
                                continue;
                            }
                            if ( $semlama != $dp[SEMESTER] )
                            {
                                if ( $semlama != "" )
                                {
                                    $tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=8 align=left>\r\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua]</a>\r\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \r\n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t<input type=submit class=\"btn btn-secondary\" name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\r\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\r\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\t  \r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t</script>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
                                    $startawal = $i;
                                }
                                $semlama = $dp[SEMESTER];
                                $tmpcetak .= "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=8>Semester {$dp['SEMESTER']} </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                            }
                            $kelas = kelas( $i );
                            $q = "SELECT syaratpengambilanmksp.*  \r\n        FROM syaratpengambilanmksp  \r\n        WHERE\r\n        syaratpengambilanmksp.IDMAKUL='{$dp['ID']}' AND\r\n        syaratpengambilanmksp.TAHUN='{$data['tahun']}'\r\n        AND syaratpengambilanmksp.SEMESTER='{$data['semester']}'\r\n         \r\n         ";
                            $hss = mysqli_query($koneksi,$q);
                            $daftarsyarat = "";
                            $syaratok = 1;
                            $jmlsyarat = sqlnumrows( $hss );
                            $totalsyarat = 0;
                            if ( 0 < sqlnumrows( $hss ) )
                            {
                                $syaratok = 0;
								while ( $dss = sqlfetcharray( $hss ) )
                                {
                                    $daftarsyarat .= "{$dss['IDSYARAT']}, {$dss['NILAI']}, {$dss['BOBOT']} <br>";
                                    $q = "SELECT pengambilanmksp.NILAI,BOBOT,SIMBOL  \r\n            FROM pengambilanmksp  \r\n            WHERE\r\n            pengambilanmksp.IDMAKUL='{$dss['IDSYARAT']}' AND\r\n             IDMAHASISWA='{$idmahasiswa}'\r\n            AND BOBOT >= {$dss['BOBOT']} AND SIMBOL!='MD'\r\n             ";
                                    $hss2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $hss2 ) )
                                    {
                                        ++$totalsyarat;
                                    }
                                    $logicsyarat = $dss[LOGIC];
                                }
                                $daftarsyarat .= "{$logicsyarat}";
                            }
                            if ( ( $jmlsyarat <= $totalsyarat && $logicsyarat == "AND" || 0 < $totalsyarat && $logicsyarat == "OR" ) && 0 < $jmlsyarat )
                            {
                                $syaratok = 1;
                            }
                            /*$tmpcetak .= "\r\n\t\t\t\t\t<tr align=center {$kelas}><td>  ".( $i + 1 )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][semester]", "{$dp['SEMESTER']}", "class=form-control m-input size=2" )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][sks]", "{$dp['SKS']}", "class=form-control m-input size=2" )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][nama]", "{$dp['NAMA']}", "class=form-control m-input  " )."\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['ID']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMA']}   </td>\r\n\t\t\t\t\t\t<td align=center>".$arrayjenismk[$dp[KDWPLTBKMK]]."</td>\r\n\t\t\t\t\t\t<td>{$dp['SKS']}  </td>\r\n\t\t\t\t\t\t<td nowrap>{$daftarsyarat}</td>";
                            */
							$tmpcetak .= "<tr align=center {$kelas}>".createinputhidden( "datax[{$dp['ID']}][semester]", "{$dp['SEMESTER']}", "class=form-control m-input size=2" )."".createinputhidden( "datax[{$dp['ID']}][sks]", "{$dp['SKS']}", "class=form-control m-input size=2" )."\r\n\t\t\t\t\t\t".createinputhidden( "datax[{$dp['ID']}][nama]", "{$dp['NAMA']}", "class=form-control m-input  " )."<td>{$dp['ID']}</td><td align=left>{$dp['NAMA']}</td><td align=center>".$arrayjenismk[$dp[KDWPLTBKMK]]."</td><td>{$dp['SKS']}  </td>\r\n\t\t\t\t\t\t<td nowrap>{$daftarsyarat}</td>";
                            unset( $arraykelasdosenpengajar );
                            if ( $syaratok == 1 )
                            {
                                if ( getaturan( "KELASKRSONLINE" ) == 0 )
                                {
                                    $tmpcetak .= "\r\n             \t\t\t\t\t\t<td>".createinputselect( "datax[".$dp[ID]."][kelas]", $arraylabelkelas, $dx[KELAS], "", "" )."\r\n                           \r\n                         \r\n                         </td>";
                                    $tmpcetak .= "\r\n            \t\t\t\t\t\t<td> \r\n                        ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                        ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                        \r\n                        </td>";
                                }
                                else if ( getaturan( "KELASKRSONLINE" ) == 1 )
                                {
                                    $q = "SELECT DISTINCT KELAS FROM dosenpengajarsp \r\n                      WHERE IDMAKUL='{$dp['ID']}' AND TAHUN='{$data['tahun']}' AND SEMESTER='{$data['semester']}' AND\r\n                      IDPRODI='{$idprodi}'\r\n                      ORDER BY KELAS ";
                                    $hkelas = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $hkelas ) )
                                    {
                                        while ( $dkelas = sqlfetcharray( $hkelas ) )
                                        {
                                            $arraykelasdosenpengajar[$dkelas[KELAS]] = $arraylabelkelas[$dkelas[KELAS]];
                                        }
                                        $tmpcetak .= "\r\n           \t\t\t\t\t\t<td> ".createinputselect( "datax[".$dp[ID]."][kelas]", $arraykelasdosenpengajar, $dx[KELAS], "", "" )."\r\n                         \r\n                       \r\n                       </td>";
                                        $tmpcetak .= "\r\n          \t\t\t\t\t\t<td> \r\n                      ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                      ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                      \r\n                      </td>";
                                    }
                                    else
                                    {
                                        $tmpcetak .= "\r\n                        <td align=center>tidak ada dosen pengajar</td>\r\n                        <td align=center>-</td>\r\n                        ";
                                    }
                                }
                                $arraycekmakul[$dp[ID]] = $i;
                            }
                            else
                            {
                                #$tmpcetak .= "<td colspan=2 align=center nowrap><b>tidak memenuhi syarat</td>";
				$tmpcetak .= "\r\n             \t\t\t\t\t\t<td style=\"background-color:yellow\">".createinputselect( "datax[".$dp[ID]."][kelas]", $arraylabelkelas, $dx[KELAS], "", "" )."\r\n                           \r\n                         \r\n                         </td>";
                                $tmpcetak .= "\r\n            \t\t\t\t\t\t<td style=\"background-color:yellow\"> \r\n                        ".createinputcek( "idambil_{$i}", "{$dp['ID']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                        ".createinputhidden( "sks_idambil_{$i}", "{$dp['SKS']}", "", "{$cekdx}", "class=form-control m-input" )."\r\n                        \r\n                        </td>";
                            }
                            $tmpcetak .= "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
                            ++$i;
                        }
                        /*$tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=8 align=right>\r\n\t\t\t\t\t\t\t\t\t <a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua]</a>\r\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \r\n\t\t\t\t\t<input type=submit class=form-control m-input name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t<input type=submit class=form-control m-input name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\r\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\r\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\t  \r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t</script>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
                        $tmpcetak .= "\r\n\r\n\t\t\t</table>\r\n\r\n \t\t\t\t<input type=hidden name=count value='{$i}'>\r\n\r\n\r\n\t\t\t\r\n\t\t\t</form>\r\n\r\n\t\t\t<script>\r\n \t\t\t\tvar count={$i};\r\n\t\t\t\tfunction cekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n\t\t\t\tfunction uncekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n \t\t\t</script>\r\n\t\t\t</td>\r\n\r\n      <td width=50%>\r\n       <b>Mata Kuliah Yang Telah Diambil </b><br>\r\n\t\t\t";
						*/
						$tmpcetak.="</tbody>";
						$tmpcetak .= "\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=8 align=left><a href='#' onClick='cekall{$semlama}();return false;'>[pilih semua]</a>\r\n\t\t\t\t\t\t\t\t\t<a href='#' onClick='uncekall{$semlama}();return false;'>[batal pilih semua]</a> \r\n\t\t\t\t\t<input type=submit class=\"btn btn-brand\" name=aksi2 value='ambil' onClick=\"return confirm('Lakukan Proses Pengambilan Mata Kuliah?');\">&nbsp;<input type=submit class=\"btn btn-secondary\" name=aksi2 value='batal'  onClick=\"return confirm('Batalkan Pengambilan Mata Kuliah?');\">\r\n\t\t\t\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\t\t\t\tvar start{$semlama}={$startawal};\r\n\t\t\t\t\t\t \t\t\t\tvar count{$semlama}={$i};\r\n\t\t\t\t\t\t\t\t\t\tfunction cekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\t  \r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t\t\t\t\tfunction uncekall{$semlama}() {\r\n\t\t\t\t\t\t\t\t\t\t\tvar i=0;\r\n\t\t\t\t\t\t\t\t\t\t\tfor (i=start{$semlama};i<count{$semlama} ;i++) {\r\n\t\t\t\t\t\t\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n\t\t\t\t\t\t \t\t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t\t}\r\n\t\t\t\t\t\t \t\t\t</script>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
                        $tmpcetak .= "</table>";
						/*$tmpcetak .= "\r\n\r\n\t\t\t</table>\r\n\r\n \t\t\t\t<input type=hidden name=count value='{$i}'>\r\n\r\n\r\n\t\t\t\r\n\t\t\t</form>\r\n\r\n\t\t\t<script>\r\n \t\t\t\tvar count={$i};\r\n\t\t\t\tfunction cekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n\t\t\t\tfunction uncekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n \t\t\t</script>\r\n\t\t\t</td>\r\n\r\n      <td width=50%>\r\n       <b>Mata Kuliah Yang Telah Diambil </b><br>\r\n\t\t\t";
						*/
						$tmpcetak.="<input type=hidden name=count value='{$i}'>\r\n\r\n\r\n\t\t\t\r\n\t\t\t</form>\r\n\r\n\t\t\t";
						
						$tmpcetak.="	</div>  
									</div>
								</div>
							</div>
						</div>
						<script>\r\n \t\t\t\tvar count={$i};\r\n\t\t\t\tfunction cekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=true');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n\t\t\t\tfunction uncekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n\t\t\t\t\t\teval('form.idambil_'+i+'.checked=false');\r\n \t\t\t\t\t}\r\n \t\t\t\t}\r\n \t\t\t</script>";
						$tmpcetak.="
										<div class=\"col-md-6\">	
											<div class=\"m-portlet m-portlet--mobile\">
														<div class=\"m-portlet__head\">
															<div class=\"m-portlet__head-caption\">
																<div class=\"m-portlet__head-title\">
																	<h3 class=\"m-portlet__head-text\">
																		Mata Kuliah Yang Telah Diambil
																	</h3>
																</div>					
															</div>
														</div>";
					}
                    $q = "SELECT IDMAHASISWA FROM pengambilanmksp \r\n          WHERE \r\n          IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t  AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'";
                    $h = mysqli_query($koneksi,$q);
                    if ( $pilihtampil2 == 0 )
                    {
                        $qfield = "";
                    }
                    else
                    {
                        $qfield = "AND pengambilanmksp.TAHUN='{$data['tahun']}' AND pengambilanmksp.SEMESTER ='{$data['semester']}'";
                    }
                    $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tpengambilanmksp.* ,\r\n \t\t\t\tSKSMAKUL AS SKS,\r\n \t\t\t\ttbkmksp.NAKMKTBKMK AS NAMAMAKUL\r\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.TAHUN,pengambilanmksp.SEMESTER,pengambilanmksp.IDMAKUL\r\n\t\t\t";
                    $h = mysqli_query($koneksi,$q);
                    $tmpcetak .= mysqli_error($koneksi);
					$tmpcetak.="	<div class=\"m-portlet\">			
											<div class=\"m-section__content\">
												<div class=\"table-responsive\">";
                    if ( sqlnumrows( $h ) <= 0 )
                    {
                        printmesg( "Data Pengambilan Mata Kuliah belum ada<br><BR>" );
                        $tmpcetak .= "<br><p align='center'>Belum ada / Tidak ada mata kuliah yang diambil.</p>";
                    }
                    else
                    {
                        $tmpcetak .= " \r\n\r\n\r\n        ";
                        /*$tmpcetak .= "\r\n\t\t\t\t\r\n\t\t\t\t\t<table class=data width=100%>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
                        */
						$tmpcetak.="<table class=\"table table-bordered table-hover\">
														<thead>	
															<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
						echo "						</thead>
									<tbody>";
						$i = 1;
                        $semlama = "";
                        $tahunlama = "";
                        while ( $d = sqlfetcharray( $h ) )
                        {
                            $semesterx = ( $d[TAHUN] - 1 - $angkatanx ) * 2 + $d[SEMESTER];
                            $semestertulis = $semesterx;
                            $kurawal = "(";
                            $kurakhir = ")";
                            if ( $d[SEMESTER] == 3 )
                            {
                                $semesterx += 0.5;
                                $semestertulis = "";
                                $kurawal = $kurakhir = "";
                            }
                            $tmp = "";
                            if ( $semlama != $semesterx )
                            {
                                if ( $semlama != "" )
                                {
                                    $tmp = "\r\n\t\t\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\r\n\t\t\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t\t\t</tr>";
                                }
                                $semlama = $semesterx;
                                $tmpcetak .= "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=8>Semester {$semestertulis}  \r\n\t\t\t\t\t\t\t\t{$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurakhir}</td>\r\n\t\t\t\t\t\t\t</tr>";
                            }
                            $kelas = kelas( $i );
                            $styleerror = "";
                            $errornamakurikulum = "";
                            if ( $d[NAMA] == "" )
                            {
                                $d[NAMA] = $d[NAMAMAKUL];
                            }
                            $tmpa = "";
                            if ( $semesterkrs == $semestertulis )
                            {
                                $tmpa = "<a href='#' onClick=\"\r\n            if (form.idambil_".$arraycekmakul[$d[IDMAKUL]].".checked == true) {\r\n              eval('form.idambil_'+".$arraycekmakul[$d[IDMAKUL]]."+'.checked=false');\r\n            } else {\r\n              eval('form.idambil_'+".$arraycekmakul[$d[IDMAKUL]]."+'.checked=true');\r\n            }\r\n            return false;\">";
                            }
                            $tmpcetak .= "\r\n\t\t\t\t\t<tr {$kelas} {$styleerror}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td> {$tmpa} {$d['IDMAKUL']}</a> </td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']} {$namamakulkurikulum} {$errornamakurikulum}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>".$arraylabelkelas[$d[KELAS]]."</td>\r\n\t\t\t\t\t</tr>";
                            $totalsks += $d[SKS];
                            $total += $semesterx;
                            $tahunlama = $d[TAHUN];
                            $sem = $d[SEMESTER] % 2;
                            if ( $sem == 0 )
                            {
                                $sem = 2;
                            }
                            $idmakul = $d[IDMAKUL];
                            $kelasmk = $d[KELAS];
                            include( "editrnlm.php" );
                            ++$i;
                        }
                        if ( $semlama != "" )
                        {
                            $tmpcetak .= "\r\n\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}  </td>\r\n\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t</tr>";
                        }
                        $tmpcetak .= " \r\n\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t</tr>";
                        /*$tmpcetak .= "\r\n\t\t\t\t\t</table>\r\n\r\n\t\t\t\t";*/
						$tmpcetak .= "</tbody></table>";
                        #if ( $sistemkrs == 0 && ( $sksmaksimum < $total[$semesterkrs] && 0 < $sksmaksimum ) )
			if ( $sistemkrs == 0 && ( $sksmaksimum < $sksdiambilsp && 0 < $sksmaksimum ) )	
                        {
                            #printmesg( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", SKS maksimum yang dapat diambil adalah {$sksmaksimum}." );
			    printwarning( "Peringatan : SKS diambil sebanyak ".($sksdiambilsp).", SKS maksimum yang dapat diambil adalah {$sksmaksimum}." );	
                        }
                        if ( $sistemkrs == 0 && is_array( $arraysyaratkrs ) )
                        {
                            foreach ( $arraysyaratkrs as $k => $v )
                            {
                                if ( $total[$semesterkrs] < $k )
                                {
                                    continue;
                                }
                                if ( $ips < $v )
                                {
                                    printwarning( "Peringatan : SKS diambil sebanyak ".$total[$semesterkrs].", syarat SKS >= {$k} adalah IP {$jtrakm} {$semesteracuan} semester yg lalu minimal {$v}. IP {$jtrakm} yg lalu mahasiswa adalah {$ips}." );
                                    break;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    /*$tmpcetak .= "\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<br>";*/
	$tmpcetak .= "			</div>
						</div>
					</div>
				</div>
			</div>";
    echo $tmpcetak;
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Edit Data Pengambilan M-K Mahasiswa" );
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
                                <span class=\"caption-subject bold uppercase\"> Edit Data Pengambilan M-K Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Data Pengambilan M-K SP Mahasiswa");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
								".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tampiledit", "" )."
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM *</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" placeholder=\"Ketik NIM / Nama Mahasiswa...\" " )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>"."
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtahunajaran( "data[tahun]", $data[tahun], " class=form-control m-input  cols=50 rows=4" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "data[semester]", $arraysemester, "{$data['semester']}", "", " class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Filter Kurikulum</label>\r\n    
										<label class=\"col-form-label\">
											<input type=radio name=pilihtampil value=0 >Tampilkan semua mata kuliah <br>
											<input type=radio name=pilihtampil value=1 checked >Tampilkan mata kuliah semester ganjil/genap saja
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Filter Mata Kuliah yg Diambil</label>\r\n    
										<label class=\"col-form-label\">
											<input type=radio name=pilihtampil2 value=0 >Tampilkan semua mata kuliah yg telah diambil<br>
											<input type=radio name=pilihtampil2 value=1 checked >Tampilkan mata kuliah yg telah diambil di semester ini saja
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Edit' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-secondary\">
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
<script>\r\n \t\t\t\tform.idmahasiswa.focus();\r\n\t\t\t</script>";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Pengambilan M-K Mahasiswa " );
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
                                <span class=\"caption-subject bold uppercase\"> Lihat Data Pengambilan M-K Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "				<div class='portlet-title'>";
								printmesg("Cari Data Pengambilan M-K Mahasiswa");
	echo "				</div>";
										
	echo "				<div class=\"m-portlet\">
							<!--begin::Form-->";
    echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Mata Kuliah</label>   
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
										<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi Mahasiswa</label>   
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
										<label class=\"col-lg-2 col-form-label\">NIM</label>   
										<div class=\"col-lg-6\">
											".createinputtext( "idmahasiswa", $idmahasiswa, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'',form.idprodim.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\"" )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,idmahasiswa',document.form.idmahasiswa.value)\" >daftar mahasiswa</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>";
									if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
									{
										echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>   
													<label class=\"col-form-label\">
														<select name='jeniskelas'>
															<option value=''>Semua</option>";
															foreach ( $arraykelasstei as $k => $v )
															{
																$selected = "";
																if ( $k == $d[JENISKELAS] )
																{
																	$selected = "selected";
																}
																echo "<option value='{$k}' {$selected}>{$v}</option>";
															}
										echo "			</select>
													</label>
												</div>";
									}
    echo "				".	( "		<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>   
										<div class=\"col-lg-6\">" 
							)				.createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
											<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >daftar mata kuliah</a>-->
											<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
												<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>   
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=tahun class=form-control m-input>
												<option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Semester</label>   
										<label class=\"col-form-label\">
											<select name=semester class=form-control m-input>
												<option value=''>Semua</option>";
												foreach ( $arraysemester as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
    echo "									</select>
										</label>
									</div> ";
								$arraylabelkelas[''] = "Semua";
    echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>   
										<label class=\"col-form-label\">
											".createinputselect( "kelas", $arraylabelkelas, $kelas, "class=form-control m-input", "" )."
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
</div>
<!--end::page-content-->
            <script>
                form.idmahasiswa.focus();
            </script>
    ";  
}
?>
