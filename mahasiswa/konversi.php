<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "update" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        if ( $aksi2 == "Hapus" && $REQUEST_METHOD == POST && is_array( $dataupdate ) )
        {
            foreach ( $dataupdate as $k => $v )
            {
                foreach ( $v as $k2 => $v2 )
                {
                    $q = "\r\n  \t\t\t\t\tDELETE FROM trnlp\r\n  \t\t\t\t\tWHERE\r\n\t\t\t\t\tNIMHSTRNLP='{$idupdate}'\r\n  \t\t\t\t\tAND KDKMKTRNLP='{$k}'\r\n  \t\t\t\t\tAND THSMSTRNLP='{$k2}'\r\n  \t\t\t\t";
                    doquery($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Konversi Nilai Mahasiswa berhasil dihapus";
                        $q = "SELECT COUNT(*) AS JML FROM trnlp WHERE \r\n    \t\t\t\t\tNIMHSTRNLP='{$idupdate}'\r\n      \t\t\t\t\tAND KDKMKTRNLP='{$k}'\r\n               ";
                        $h = doquery($koneksi,$q);
                        $d = sqlfetcharray( $h );
                        if ( $d[JML] <= 0 )
                        {
                            $q = "\r\n        \t\t\t\t\tDELETE FROM nilaikonversi\r\n        \t\t\t\t\tWHERE\r\n      \t\t\t\t\tIDMAHASISWA='{$idupdate}'\r\n        \t\t\t\t\tAND IDMAKUL='{$k}'\r\n        \t\t\t\t";
                            doquery($koneksi,$q);
                        }
                    }
                }
            }
        }
        if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST && is_array( $dataupdate ) )
        {
            unset( $vld );
            foreach ( $dataupdate as $k => $v )
            {
                foreach ( $v as $k2 => $v2 )
                {
                    $vld[] = cekvaliditasinteger( "Semester", $datarp[$k][$k2]['semester'] );
                    $vld[] = cekvaliditaskodemakul( "Kode Makul", $datarp[$k][$k2]['idmakul'] );
                    $vld[] = cekvaliditasnama( "Nama Makul", $datarp[$k][$k2]['namamakul'] );
                    $vld[] = cekvaliditasnilaibobot( "Bobot", $datarp[$k][$k2]['bobot'] );
                    $vld[] = cekvaliditasnilaihuruf( "Nilai", $datarp[$k][$k2]['nilai'] );
                    $vld[] = cekvaliditasinteger( "SKS", $datarp[$k][$k2]['sks'], 3 );
                }
            }
            $vld = array_unique( array_filter( $vld, "filter_not_empty" ) );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            }
            else
            {
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst,mahasiswa \r\n          WHERE mahasiswa.IDPRODI=IDX AND mahasiswa.ID='{$idupdate}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                foreach ( $dataupdate as $k => $v )
                {
                    foreach ( $v as $k2 => $v2 )
                    {
                        $q = " UPDATE nilaikonversi SET\r\n    \t\t\tIDMAKUL='".$datarp[$k][$k2][idmakul]."',\r\n    \t\t\tNAMAMAKUL='".$datarp[$k][$k2][namamakul]."',\r\n    \t\t\tSEMESTERMAKUL ='".$datarp[$k][$k2][semester]."', \r\n    \t\t\tBOBOT ='".$datarp[$k][$k2][bobot]."',\r\n    \t\t\tNILAI ='".$datarp[$k][$k2][nilai]."',\r\n    \t\t\tSKS ='".$datarp[$k][$k2][sks]."' \r\n    \t\t\tWHERE IDMAHASISWA ='{$idupdate}'  AND IDMAKUL='{$k}'\r\n    \t\t\t";
                        doquery($koneksi,$q);
                        $q = "UPDATE trnlp\r\n          SET\r\n          NLAKHTRNLP='".$datarp[$k][$k2][nilai]."',\r\n          BOBOTTRNLP='".$datarp[$k][$k2][bobot]."',\r\n          KDKMKTRNLP='".$datarp[$k][$k2][idmakul]."'\r\n          WHERE\r\n          NIMHSTRNLP='{$idupdate}' \r\n          AND KDKMKTRNLP='{$k}'  \r\n          AND THSMSTRNLP='{$k2}'";
                        doquery($koneksi,$q);
                        if ( sqlaffectedrows( $koneksi ) <= 0 )
                        {
                            $q = "INSERT INTO trnlp \r\n              (THSMSTRNLP,KDPTITRNLP,KDJENTRNLP,KDPSTTRNLP,NIMHSTRNLP,KDKMKTRNLP,NLAKHTRNLP,BOBOTTRNLP,KELASTRNLP)\r\n              VALUES\r\n              ('{$k2}','{$kodept}','{$kodejenjang}','{$kodeps}','{$idupdate}','{$k}','".$datarp[$k][$k2][nilai]."','".$datarp[$k][$k2][bobot]."','01')";
                            doquery($koneksi,$q);
                        }
                    }
                }
                $errmesg = "Data Konversi Nilai Mahasiswa berhasil disimpan";
            }
        }
        if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
        {
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester Kurikulum", $tahun, $semester, false );
            $vld[] = cekvaliditaskodeprodi( "Program Studi Mata Kuliah", $idprodi );
            $vld[] = cekvaliditaskodemakul( "Kode Mata Kuliah", $idmakul );
            $vld[] = cekvaliditasnilaibobot( "Bobot", $bobot );
            $vld[] = cekvaliditasnilaihuruf( "Nilai (simbol)", $nilai );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            }
            else
            {
                if ( trim( $idmakul ) == "" )
                {
                    $errmesg = "Kode Mata Kuliah harus diisi";
                }
                else
                {
                    if ( $idprodi == 0 )
                    {
                        $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
                        $h = doquery($koneksi,$q);
                        $d = sqlfetcharray( $h );
                        $idprodi = $d[IDPRODI];
                    }
                    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                    $h = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $d = sqlfetcharray( $h );
                        $idpt = $d[KDPTIMSPST];
                        $kodejenjang = $d[KDJENMSPST];
                        $kodeps = $d[KDPSTMSPST];
                    }
                    $q = "SELECT NAKMKTBKMK , SKSMKTBKMK, SEMESTBKMK \r\n        FROM tbkmk\r\n        WHERE\r\n        THSMSTBKMK = '{$tahun}{$semester}' AND\r\n        KDJENTBKMK = '{$kodejenjang}' AND\r\n        KDPSTTBKMK = '{$kodeps}' AND\r\n        KDKMKTBKMK = '{$idmakul}' ";
                    $h = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $d = sqlfetcharray( $h );
                        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst,mahasiswa \r\n          WHERE mahasiswa.IDPRODI=IDX AND mahasiswa.ID='{$idupdate}'";
                        $hx = doquery($koneksi,$q);
                        if ( 0 < sqlnumrows( $hx ) )
                        {
                            $dx = sqlfetcharray( $hx );
                            $kodept = $dx[KDPTIMSPST];
                            $kodejenjang = $dx[KDJENMSPST];
                            $kodeps = $dx[KDPSTMSPST];
                        }
                        $q = "INSERT INTO trnlp \r\n          (THSMSTRNLP,KDPTITRNLP,KDJENTRNLP,KDPSTTRNLP,NIMHSTRNLP,KDKMKTRNLP,NLAKHTRNLP,BOBOTTRNLP,KELASTRNLP)\r\n          VALUES\r\n          ('{$tahun}{$semester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$idupdate}','{$idmakul}','{$nilai}','{$bobot}','01')";
                        doquery($koneksi,$q);
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            $q = " INSERT INTO nilaikonversi \r\n  \t\t\t   (IDMAHASISWA,IDMAKUL,NAMAMAKUL,SEMESTERMAKUL,BOBOT,NILAI,SKS)\r\n  \t\t\t   VALUES\r\n           ('{$idupdate}','{$idmakul}','{$d['NAKMKTBKMK']}','{$d['SEMESTBKMK']}','{$bobot}',\r\n           '{$nilai}','{$d['SKSMKTBKMK']}' )\r\n           ";
                            doquery($koneksi,$q);
                            $errmesg = "Data Konversi Nilai Mahasiswa berhasil disimpan";
                            $data = "";
                            $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
                        }
                        else
                        {
                            $errmesg = "Data Konversi Nilai Mahasiswa tidak disimpan";
                        }
                    }
                    else
                    {
                        $errmesg = "Data Mata Kuliah tidak ada di Kurikulum {$tahun}/".( $tahun + 1 )."  ".$arraysemester[$semester]."";
                    }
                }
            }
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi == "formupdate" )
{
    $q = "SELECT ID,NAMA,IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $q = "SELECT STPIDMSMHS FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
        $h2 = doquery($koneksi,$q);
        $d2 = sqlfetcharray( $h2 );
        $statuspindahan = $d2[STPIDMSMHS];
        if ( $d2[STPIDMSMHS] != "P" )
        {
            $strpindahan = "<br><center style='font-size:12pt;color:#ff0000'><b>Perhatian! Mahasiswa ini BUKAN Mahasiswa Pindahan. <br>Semua nilai konversi yang disimpan tidak akan mempengaruhi IPK mahasiswa.</b></center>\r\n        <br>";
        }
        /*echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t{$strpindahan}\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." \r\n     <tr class=judulform>\r\n\t\t\t<td width=150><b>Jurusan/Program Studi</td>\r\n\t\t\t<td><b>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n      <tr class=judulform>\r\n\t\t\t<td width=100><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table></div></div>\r\n \t\t\r\n \t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n<tr>\r\n  <td width=200>Tahun/Semester Kurikulum</td>\r\n  <td >\r\n";
        */
		echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post>
					{$strpindahan}
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "sessid", $_SESSION['token'], "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )."";
		if($_SESSION['users']=="daniel01" || $_SESSION['users']=="admin" || $_SESSION['users']=="sony01" || $_SESSION['users']=="rizfa01" || $_SESSION['users']=="lihai01" ){
		echo "			<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d[IDPRODI]]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>";
		$waktu = getdate( );
        echo "			<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tahun/Semester Kurikulum</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
									$selected = "";
									$i = 1901;
									while ( $i <= $waktu[year] + 5 )
									{
										if ( $tahun == $i )
										{
											$selected = "selected";
										}
										if ( $i == $waktu[year] && $tahun == "" )
										{
											$selected = "selected";
										}
										echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
										$selected = "";
										++$i;
									}
        echo "					</select>/
								<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
									unset( $arraysemester[3] );
									foreach ( $arraysemester as $k => $v )
									{
										if ( $k == $semester )
										{
											$selected = "selected";
										}
										if ( $k == $semester && $semester == "" )
										{
											$selected = "selected";
										}
										echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
										$selected = "";
									}
        echo "					</select>
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Program Studi Mata Kuliah</label>";
								$arrayprodidep[0] = "Otomatis / sama dengan Prodi Mahasiswa";
        echo "				<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=form-control m-input" )."
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>
							<div class=\"col-lg-6\">
								".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,'' );\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
								<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
								<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
									<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
								</div>
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nilai (A-E/Simbol)</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".createinputtext( "nilai", $nilai, " class=form-control m-input  size=2" )."
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Bobot (0-4/Angka)</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".createinputtext( "bobot", $bobot, " class=form-control m-input  size=2" )."
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">
								<input type=\"reset\" class=\"btn btn-secondary\" value=Reset>
							</div>
						</div>					
			</div>";
		}
        $q = "SELECT nilaikonversi.* ,trnlp.THSMSTRNLP,BOBOTTRNLP AS BOBOT ,NLAKHTRNLP AS NILAI\r\n        FROM nilaikonversi LEFT JOIN trnlp ON \r\n        nilaikonversi.IDMAHASISWA=trnlp.NIMHSTRNLP AND  \r\n        nilaikonversi.IDMAKUL=trnlp.KDKMKTRNLP \r\n        WHERE IDMAHASISWA='{$idupdate}' \r\n        ORDER BY SEMESTERMAKUL,IDMAKUL";
        $h = doquery($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            #echo "\r\n\t\t\t<br>\r\n\t\t\t\t{$border} \r\n\t\t\t\t\t<tr  >\r\n \t\t\t\t\t\t<td align=right colspan=9>\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=masukan>\r\n \t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>ThnSem</td>\r\n \t\t\t\t\t\t<td>Semester Makul</td>\r\n\t\t\t\t\t\t<td>Kode Makul</td>\r\n\t\t\t\t\t\t<td>Nama Makul</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n \r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t</tr>";
            echo "															
										<div class=\"tools\">
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr>
														<td>";
														if($_SESSION['users']=="daniel01" || $_SESSION['users']=="admin" || $_SESSION['users']=="sony01" || $_SESSION['users']=="rizfa01" || $_SESSION['users']=="lihai01" ){
			echo "												<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
															<input type=submit name=aksi2 value='Hapus' class=\"btn btn-brand\">";
														}
			echo "											</td>
													</tr>
												</table>
											</div>
										</div>";
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>ThnSem</td>\r\n \t\t\t\t\t\t<td>Semester Makul</td>\r\n\t\t\t\t\t\t<td>Kode Makul</td>\r\n\t\t\t\t\t\t<td>Nama Makul</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n \r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t</tr>
													</thead>
													<tbody>";
			$i = 1;
            $totalsks = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                if ( $d[THSMSTRNLP] == "" )
                {
                    $d[THSMSTRNLP] = "00000";
                }
                echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>\r\n              {$d['THSMSTRNLP']}\r\n              <input type=hidden name='datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][thnsm]' value='{$d['THSMSTRNLP']}'>\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][semester]", $d[SEMESTERMAKUL], " class=masukan  size=1" )."\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][idmakul]", $d[IDMAKUL], " class=masukan  size=10" )."\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][namamakul]", $d[NAMAMAKUL], " class=masukan  size=40" )."\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][sks]", $d[SKS], " class=masukan  size=2" )."\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][bobot]", $d[BOBOT], " class=masukan  size=2" )."\r\n              </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputtext( "datarp[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}][nilai]", $d[NILAI], " class=masukan  size=2" )."\r\n              </td>\r\n  \t\t\t\t\t\t<td align=center><input type=checkbox name='dataupdate[{$d['IDMAKUL']}][{$d['THSMSTRNLP']}]' value=1></td>\r\n\t\t\t\t\t</tr>";
                $totalsks += $d[SKS];
                $totalbobot += $d[SKS] * $d[BOBOT];
                ++$i;
            }
            $ipkkonversi = number_format_sikad( @$totalbobot / @$totalsks, 2 );
            echo "\r\n      <tr>\r\n        <td colspan=5 align=right>Total SKS diakui</td>\r\n        <td align=center><b>{$totalsks}</b></td>\r\n        <td colspan=3 align=center>IPK Konversi : <b>{$ipkkonversi}</b></td>\r\n      </tr>\r\n      ";
            if ( $statuspindahan == "P" )
            {
                $q = "UPDATE msmhs SET SKSDIMSMHS='{$totalsks}'\r\n        WHERE NIMHSMSMHS ='{$idupdate}'";
                doquery($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $strsksdiakui = "SKS diakui untuk mahasiswa pindahan telah diupdate";
                }
            }
            echo "\r\n\t\t\t\t</table>\r\n\t\t\t\t{$strsksdiakui}\r\n        </form>
				<form name=form2 action=cetakkonversi.php method=post target=_blank >
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "sessid", $_SESSION['token'], "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )." 
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<div class=\"col-lg-6\">
								<input type=submit name=aksi value=Cetak class=\"btn btn-brand\">
							</div>
						</div>";
			echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->";
		}
        else
        {
            echo "<p>";
            printmesg( "Data Konversi Nilai tidak ada" );
            echo "</p>";
        }
        #echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
		
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
