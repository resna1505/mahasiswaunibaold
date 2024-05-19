<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#unset( $arraysort );
#$arraysort[0] = "calonmahasiswa.NAMA";
#$href = "index.php?pilihan={$pilihan}&aksi=Lanjutkan&";
if ( $aksi == "Lanjutkan" )
{
    if ( $aksi2 == "Proses" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Mahasiswa Baru", TAMBAH_DATA );
        }
        else if ( is_array( $arraypilih ) )
        {
            foreach ( $arraypilih as $k => $v )
            {
                $nim = $datanim[$k];
                if ( $nim == "" )
                {
                    $errmesg .= "NIM harus diisi - ({$k})<br>";
                }
                else
                {
                    $q = "SELECT ID FROM mahasiswa WHERE ID='{$nim}'";
                    $h = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $errmesg .= "NIM {$nim} sudah ada di basis data. Gunakan NIM yang lain - ({$k}) <br>";
                    }
                    else
                    {
                        if($idpilihan!=""){
                    
                            $qfilter = "AND calonmahasiswa.PILIHAN='{$idpilihan}'";
                            
                            $judulpilihan=$arraypilihanpmb[$idpilihan];
                            
                            $pilihanprodi='Semua';
                        
                        }elseif($prodilulus!=""){
                        
                            $qfilter = "AND calonmahasiswa.PRODI1='{$prodilulus}'";
                            
                            $pilihanprodi=$arrayprodidep[$prodilulus];
                            
                            $judulpilihan='Semua';
                        
                        }elseif($prodilulus!="" && $idpilihan!=""){
                            
                            $qfilter = "AND calonmahasiswa.PRODI1='{$prodilulus}' AND calonmahasiswa.PILIHAN='{$idpilihan}'";
                            
                            $judulpilihan=$arraypilihanpmb[$idpilihan];
                            
                            $pilihanprodi=$arrayprodidep[$prodilulus];
                        
                        }else{
                        
                            if($idpilihan==""){
                                #echo "lll";
                                $judulpilihan='Semua';
                            }
                            
                            if($prodilulus==""){
                            
                                $pilihanprodi='Semua';
                            }
                        
                            $qfilter = "";
                        
                        }
                        #$q = "SELECT * FROM calonmahasiswa  WHERE ID='{$k}' AND \r\n                  TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' AND PILIHAN='{$idpilihan}' AND LULUS!=''";
                        $q = "SELECT * FROM calonmahasiswa  WHERE ID='{$k}' AND \r\n                  TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' {$qfilter} AND LULUS!='' AND LULUS !=-1";
                       # echo $q.'<br>';exit();
                        $h = doquery($koneksi,$q);
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $data = sqlfetcharray( $h );
                            foreach ( $data as $k2 => $v2 )
                            {
                                $data2[$k2] = mysqli_real_escape_string($koneksi, $v2 );
                            }
                            $data = $data2;
                            #$q = "\r\n              INSERT INTO mahasiswa (ID,NAMA,ALAMAT,STATUS,IDPRODI,ANGKATAN,TEMPAT,TANGGAL,KELAMIN,AGAMA,TELEPON,ASAL, TANGGALMASUK,CSS,KELAS,NAMAAYAH,NAMAIBU,ALAMATAYAH,GELOMBANG,JENISKELAS,IDCALONMAHASISWA,PILIHAN,EMAIL,KOTA,PROVINSI,TAHUNLULUS,PENDIDIKAN ,ALAMATIBU,NOAYAH,NOIBU,HP,PASSWORD,FLAGPASSWORD,CATATAN) VALUES ('{$nim}','".strtoupper( $data[NAMA] )."','{$data['ALAMAT']}','A','".$dataprodi[$k]."',\r\n                      \t\t\t'{$tahunmasuk}',  \r\n                      \t\t\t'{$data['TEMPATLAHIR']}','{$data['TANGGALLAHIR']}','{$data['KELAMIN']}',\r\n                      \t\t\t'{$data['AGAMA']}','{$data['TELEPON']}','{$data['ASALSMA']}', \r\n                      \t\t\t'".$dtm[$k][thn]."-".$dtm[$k][bln]."-".$dtm[$k][tgl]."','style.inc','".$datakelas[$k]."',\r\n                            '{$data['NAMAAYAH']}','{$data['NAMAIBU']}','{$data['ALAMATORTU']}','{$data['GELOMBANG']}','".$datajeniskelas[$k]."',\r\n                            '{$data['ID']}','{$data['PILIHAN']}',\r\n                            \r\n                            '{$data['EMAIL']}','{$data['KOTA']}','{$data['PROVINSI']}','{$data['TAHUNLULUSSMA']}',\r\n                            '{$data['PENDIDIKAN']}' ,'{$data['ALAMATIBU']}','{$data['TELEPONAYAH']}','{$data['TELEPONIBU']}','{$data['HP']}',\r\n                            MD5('{$nim}'),1,'{$data['CATATAN']}')\r\n                      \t\t";
                            #echo $q;exit();
                            $q = "\r\n              INSERT INTO mahasiswa (ID,NAMA,ALAMAT,STATUS,IDPRODI,ANGKATAN,TEMPAT,TANGGAL,KELAMIN,AGAMA,TELEPON,ASAL, TANGGALMASUK,CSS,KELAS,NAMAAYAH,NAMAIBU,ALAMATAYAH,GELOMBANG,JENISKELAS,IDCALONMAHASISWA,PILIHAN,EMAIL,KOTA,PROVINSI,TAHUNLULUS,PENDIDIKAN ,ALAMATIBU,NOAYAH,NOIBU,HP,PASSWORD,FLAGPASSWORD,KTP) VALUES ('{$nim}','".strtoupper( $data[NAMA] )."','{$data['ALAMAT']}','A','".$dataprodi[$k]."',\r\n                      \t\t\t'{$tahunmasuk}',  \r\n                      \t\t\t'{$data['TEMPATLAHIR']}','{$data['TANGGALLAHIR']}','{$data['KELAMIN']}',\r\n                      \t\t\t'{$data['AGAMA']}','{$data['TELEPON']}','{$data['ASALSMA']}', \r\n                      \t\t\t'".$dtm[$k][thn]."-".$dtm[$k][bln]."-".$dtm[$k][tgl]."','style.inc','".$datakelas[$k]."',\r\n                            '{$data['NAMAAYAH']}','{$data['NAMAIBU']}','{$data['ALAMATORTU']}','{$data['GELOMBANG']}','".$datajeniskelas[$k]."',\r\n                            '{$data['ID']}','{$data['PILIHAN']}',\r\n                            \r\n                            '{$data['EMAIL']}','{$data['KOTA']}','{$data['PROVINSI']}','{$data['TAHUNLULUSSMA']}',\r\n                            '{$data['PENDIDIKAN']}' ,'{$data['ALAMATIBU']}','{$data['TELEPONAYAH']}','{$data['TELEPONIBU']}','{$data['HP']}',\r\n                            MD5('{$nim}'),1,'{$data['KTP']}')\r\n                      \t\t";
                            
                            doquery($koneksi,$q);
                            //echo mysql_error();
                            if ( 0 < sqlaffectedrows( $koneksi ) )
                            {
                                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='".$dataprodi[$k]."'";
                                $h2 = doquery($koneksi,$q);
                                if ( 0 < sqlnumrows( $h2 ) )
                                {
                                    $d2 = sqlfetcharray( $h2 );
                                    $kodept = $d2[KDPTIMSPST];
                                    $kodejenjang = $d2[KDJENMSPST];
                                    $kodeps = $d2[KDPSTMSPST];
                                }
                                $q = "INSERT INTO msmhs \r\n                              (KDPTIMSMHS ,KDPSTMSMHS,KDJENMSMHS,NIMHSMSMHS ,NMMHSMSMHS ,TPLHRMSMHS ,\r\n                              TGLHRMSMHS,KDJEKMSMHS,TAHUNMSMHS ,SMAWLMSMHS,BTSTUMSMHS,ASSMAMSMHS ,\r\n                              TGMSKMSMHS ,TGLLSMSMHS,STMHSMSMHS ,STPIDMSMHS,SKSDIMSMHS,ASNIMMSMHS,\r\n                              ASPTIMSMHS ,ASJENMSMHS ,ASPSTMSMHS ,BISTUMSMHS ,PEKSBMSMHS ,NMPEKMSMHS ,\r\n                              PTPEKMSMHS ,PSPEKMSMHS ,NOPRMMSMHS ,NOKP1MSMHS ,NOKP2MSMHS,NOKP3MSMHS ,\r\n                              NOKP4MSMHS,SHIFTMSMHS)\r\n                              VALUES \r\n                              ('{$kodept}','{$kodeps}','{$kodejenjang}','{$nim}','".strtoupper( $data[NAMA] )."','{$data['TEMPATLAHIR']}',\r\n                              '{$data['TANGGALLAHIR']}','{$data['KELAMIN']}','{$tahunmasuk}','".$datatahun[$k]."".$datasemester[$k]."',\r\n                              '".$datatahunbatas[$k]."".$datasemesterbatas[$k]."','{$kodeprop}','".$dtm[$k][thn]."-".$dtm[$k][bln]."-".$dtm[$k][tgl]."',NULL,\r\n                              'A','B','{$sksbaru}','{$nimasal}','{$ptasal}','{$jasal}','{$psasal}',\r\n                              '{$kodebiaya}','{$kodekerja}','{$tempatkerja}','{$ptkerja}','{$pskerja}',\r\n                              '{$nidnpro}','{$nidnpro1}','{$nidnpro2}','{$nidnpro3}','{$nidnpro4}','{$kodekelas}')";
                                doquery($koneksi,$q);
                                $errmesg = "Data Mahasiswa Baru telah disimpan - ({$k}) <br>";
                                $q = "UPDATE calonmahasiswa SET NIM='{$nim}' WHERE ID='{$k}' AND \r\n                          TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' AND PILIHAN='{$idpilihan}'";
                                doquery($koneksi,$q);
                                $ketlog = "proses Daftar Ulang Calon Mahasiswa.   ID={$k}, NIM={$nim} ";
                                buatlog( 88 );
                            }
                        }
                    }
                }
            }
        }
    }
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Registrasi Mahasiswa Baru - Sekaligus" );
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    
    /*if($idpilihan!=""){
                    
                        $qfilter = "AND calonmahasiswa.PILIHAN='{$idpilihan}'";
                    
                    }elseif($prodilulus!=""){
                    
                        $qfilter = "AND calonmahasiswa.PRODI1='{$prodilulus}'";
                    
                    }else{
                        
                        $qfilter = "";
                    }*/
                    
                    
                    #echo "MM".$idpilihan;exit();
                    if($idpilihan!=""){
                    
                        $qfilter = "AND calonmahasiswa.PILIHAN='{$idpilihan}'";
                        
                        $judulpilihan=$arraypilihanpmb[$idpilihan];
                        
                        $pilihanprodi='Semua';
                    
                    }elseif($prodilulus!=""){
                    
                        $qfilter = "AND calonmahasiswa.PRODI1='{$prodilulus}'";
                        
                        $pilihanprodi=$arrayprodidep[$prodilulus];
                        
                        $judulpilihan='Semua';
                    
                    }elseif($prodilulus!="" && $idpilihan!=""){
                        
                        $qfilter = "AND calonmahasiswa.PRODI1='{$prodilulus}' AND calonmahasiswa.PILIHAN='{$idpilihan}'";
                        
                        $judulpilihan=$arraypilihanpmb[$idpilihan];
                        
                        $pilihanprodi=$arrayprodidep[$prodilulus];
                    
                    }else{
                    
                        if($idpilihan==""){
                            #echo "lll";
                            $judulpilihan='Semua';
                        }
                        
                        if($prodilulus==""){
                        
                            $pilihanprodi='Semua';
                        }
                    
                        $qfilter = "";
                    
                    }
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "				<div class='portlet-title'>";
								printmesg("Registrasi Mahasiswa Baru");
	echo "				</div>";
	echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "						<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "sessid", $_SESSION['token'], "" )."
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
								<input type=hidden name=gelombang value='{$gelombang}'>
								<input type=hidden name=idpilihan value='{$idpilihan}'>
								<input type=hidden name=prodilulus value='{$prodilulus}'>
								<input type=hidden name=aksi value='{$aksi}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\"><b>{$tahunmasuk}</b></label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											<b>{$gelombang}</b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
										<label class=\"col-form-label\">
											<b>".$judulpilihan."</b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Program Studi Kelulusan</label>\r\n    
										<label class=\"col-form-label\">
											<b>".$pilihanprodi."</b>
										</label>
									</div>
								</div> ";
    $qinput .= " <input type=text name=sort value='{$sort}'>";
    #$q = "SELECT \r\n\tcalonmahasiswa.* ,mahasiswa.ID  AS NIMBARU      ,mahasiswa.IDPRODI,mahasiswa.KELAS,DATE_FORMAT(mahasiswa.TANGGALMASUK,'%d-%m-%Y') AS TANGGALMASUK\r\n\tFROM calonmahasiswa  LEFT JOIN mahasiswa ON calonmahasiswa.NIM=mahasiswa.ID\r\n  \r\n  WHERE  \r\n  calonmahasiswa.TAHUN='{$tahunmasuk}' AND calonmahasiswa.GELOMBANG='{$gelombang}' {$qfilter} AND calonmahasiswa.LULUS !='' AND calonmahasiswa.LULUS !=-1  ORDER BY calonmahasiswa.NIM DESC,calonmahasiswa.ID\r\n\t";
    $q = "SELECT \r\n\tcalonmahasiswa.* ,mahasiswa.ID  AS NIMBARU      ,mahasiswa.IDPRODI,mahasiswa.KELAS,DATE_FORMAT(mahasiswa.TANGGALMASUK,'%d-%m-%Y') AS TANGGALMASUK\r\n\tFROM calonmahasiswa  LEFT JOIN mahasiswa ON calonmahasiswa.NIM=mahasiswa.ID\r\n  \r\n  WHERE  \r\n  calonmahasiswa.TAHUN='{$tahunmasuk}' AND calonmahasiswa.GELOMBANG='{$gelombang}' {$qfilter} AND calonmahasiswa.LULUS !='' AND calonmahasiswa.LULUS !=-1  ORDER BY calonmahasiswa.NAMA ASC,calonmahasiswa.NIM\r\n\t";
    
    #echo $q;
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n      <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr class=juduldata align=center>\r\n          <td align=left colspan=10>\r\n          <input type=submit value='Proses' name=aksi2 class=\"btn blue\" onClick=\"return confirm('Proses Data Mahasiswa Baru?')\">\r\n          </td> \r\n        </tr>\r\n        <tr class=juduldata align=center>\r\n          <td>Pilih</td>\r\n          <td>No</td>\r\n          <td>NIM Mahasiswa Baru</td>\r\n          <td>No. Tes</td>\r\n          <td>Nama</td>\r\n          <td>Program Studi Yang Diambil</td>\r\n          <td>Kelas Default MK</td>";
        echo "															
										<div class=\"tools\">
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr>
														<td>
															<input type=submit name=aksi2 value='Proses' class=\"btn btn-brand\">														
														</td>
													</tr>
												</table>
											</div>
									</div>";
		echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n          
															<td>Pilih</td>\r\n          <td>No</td>\r\n          <td>NIM Mahasiswa Baru</td>\r\n          <td>No. Tes</td>\r\n          <td>Nama</td>\r\n          <td>Program Studi Yang Diambil</td>\r\n          <td>Kelas Default MK</td>";
																if ( $STEIINDONESIA == 1 || $JENISKELAS == 1 )
																{
																	echo "\r\n \r\n\t\t\t<td>Jenis Kelas Default </td> \r\n    ";
																}
        echo " 												<td>Tgl masuk</td>\r\n \r\n          <td>Sem Awal</td>\r\n          <td>Batas Studi</td>\r\n          <!-- <td>Kode Propinsi</td>     -->\r\n        
														</tr>
													</thead>
													<tbody>";
        $increment = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $increment++;
            $pilihanprodi = "";
            unset( $arraypilihancm );
            if ( $d[NIMBARU] == "" )
            {
                $arraypilihancm[$d[PRODI1]] = $arrayprodidep[$d[PRODI1]];
                if ( trim( $d[PRODI2] ) + 0 != 0 )
                {
                    $arraypilihancm[$d[PRODI2]] = $arrayprodidep[$d[PRODI2]];
                }
                if ( $d[LULUS] == $d[PRODI1] )
                {
                    $pilihanprodi = " ".createinputselect( "dataprodi[{$d['ID']}]", $arraypilihancm, $d[LULUS], "", "" )."\r\n          ";
                }
                else
                {
                    $pilihanprodi = "\r\n            <input type=hidden name='dataprodi[{$d['ID']}]' value='{$d['LULUS']}' >\r\n            ".$arrayprodidep[$d[LULUS]]."\r\n          ";
                }
                echo "\r\n          <tr>\r\n            <td align=center><input type=checkbox name='arraypilih[{$d['ID']}]' value='1'></td>\r\n            <td align=center>{$increment}</td>\r\n            <td align=center><input type=text size=20 maxlength=12 name='datanim[{$d['ID']}]' value=''></td>\r\n            <td align=left>{$d['ID']}</td>\r\n            <td align=left>{$d['NAMA']}</td>\r\n            <td align=left>{$pilihanprodi}   </td>\r\n            <td align=left>".createinputselect( "datakelas[{$d['ID']}]", $arraylabelkelas, $d[KELAS], "", "" )."</td>";
                if ( $STEIINDONESIA == 1 || $JENISKELAS == 1 )
                {
                    echo "\r\n \r\n\t\t\t<td>\r\n        <select name='datajeniskelas[{$d['ID']}]' >\r\n      ";
                    foreach ( $arraykelasstei as $k => $v )
                    {
                        $selected = "";
                        if ( $k == $d[JENISKELAS] )
                        {
                            $selected = "selected";
                        }
                        echo "<option value='{$k}' {$selected}>{$v}</option>";
                    }
                    echo "\r\n      </select>\r\n      \r\n      </td>\r\n \r\n    ";
                }
                echo " \r\n            \r\n            \r\n            \r\n            <td align=left nowrap>".createinputtanggal( "dtm[{$d['ID']}]", $dtm[$d[ID]], " class=masukan" )."</td>\r\n            <td nowrap>\r\n            ";
                $waktu = getdate( );
                echo "\r\n\t\t\t\t\t\t<select name='datatahun[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t ";
                $selected = "";
                $i = $tahunmasuk;
                while ( $i <= $waktu[year] + 5 )
                {
                    if ( $i == $tahunmasuk )
                    {
                        $selected = "selected";
                    }
                    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
                    $selected = "";
                    ++$i;
                }
                echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name='datasemester[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t ";
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
                echo "\r\n\t\t\t\t\t\t</select>\r\n            \r\n            </td>\r\n\r\n            <td nowrap>\r\n            ";
                $waktu = getdate( );
                echo "\r\n\t\t\t\t\t\t<select name='datatahunbatas[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t ";
                $selected = "";
                $i = $tahunmasuk;
                while ( $i <= $waktu[year] + 20 )
                {
                    if ( $i == $tahunmasuk + 6 )
                    {
                        $selected = "selected";
                    }
                    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
                    $selected = "";
                    ++$i;
                }
                echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name='datasemesterbatas[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t ";
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
                echo "\r\n\t\t\t\t\t\t</select>\r\n            \r\n            </td>\r\n\r\n\r\n\r\n          </tr>\r\n        ";
            }
            else
            {
                echo "\r\n          <tr>\r\n            <td align=center>-</td>\r\n            <td align=center>{$increment}</td>\r\n            <td align=center>{$d['NIMBARU']}</td>\r\n            <td align=left>{$d['ID']}</td>\r\n            <td align=left>{$d['NAMA']}</td>\r\n            <td align=left>".$arrayprodidep[$d[IDPRODI]]."   </td>\r\n            <td align=left>".$arraylabelkelas[$d[KELAS]]."</td>\r\n            <td align=left nowrap>{$d['TANGGALMASUK']}</td>\r\n            <td nowrap align=center colspan=2> \r\n            sudah diproses</td>\r\n\r\n\r\n\r\n          </tr>\r\n        ";
            }
        }
        echo "\r\n      </table>\r\n   ";
    }
    else
    {
        printmesg( "Maaf, tidak ada data calon mahasiswa yang sudah lulus." );
    }
    #echo "\r\n\t\t</form>\r\n \t</div></div></div></div></div>";
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
if ( $aksi == "" )
{
    #printjudulmenu( "Registrasi Mahasiswa Baru - Sekaligus" );
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    
     echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
	echo "				<div class='portlet-title'>";
								printmesg("Registrasi Mahasiswa Baru");
	echo "				</div>";
	echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='Lanjutkan'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=tahunmasuk class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 2007;
												while ( $i <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $i == $waktu[year] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idpilihan><option value=''>Semua</option>";
												foreach ( $arraypilihanpmb as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    #echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<!--\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>ID/Nomor Tes </td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=form-control m-input  size=50 " )."\r\n  \t\t\t</td>\r\n\t\t</tr>  \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\t  Program Studi Kelulusan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=prodilulus>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Program Studi Kelulusan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=prodilulus><option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Lanjutkan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>";
    #echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\r\n\t\t\r\n \r\n-->\r\n\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjutkan' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
