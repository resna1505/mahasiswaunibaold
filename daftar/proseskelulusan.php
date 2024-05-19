<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ll";exit();
#echo $pilihan;exit();
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $tahunmasuk != "" )
{
    $qfield .= " AND TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}
if ( $notes != "" )
{
    $qfield .= " AND NOTES = '{$notes}'";
    $qjudul .= " No. Tes '{$notes}' <br>";
    $qinput .= " <input type=hidden name=notes value='{$notes}'>";
    $href .= "notes={$notes}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID = '{$id}'";
    $qjudul .= " Urutan '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $idpilihan != "" )
{
    $qfield .= " AND PILIHAN='{$idpilihan}'";
    $qjudul .= " Pilihan '".$arraypilihanpmb["{$idpilihan}"]."' <br>";
    $qinput .= " <input type=hidden name=idpilihan value='{$idpilihan}'>";
    $href .= "idpilihan={$idpilihan}&";
}
if ( $idprodi1 != "" )
{
    $qfield .= " AND PRODI1='{$idprodi1}'";
    $qjudul .= " Pilihan 1 '".$arrayprodi[$idprodi1]."' <br>";
    $qinput .= " <input type=hidden name=idprodi1 value='{$idprodi1}'>";
    $href .= "idprodi1={$idprodi1}&";
}
if ( $idprodi2 != "" )
{
    $qfield .= " AND PRODI2='{$idprodi2}'";
    $qjudul .= " Pilihan 2 '".$arrayprodi[$idprodi2]."' <br>";
    $qinput .= " <input type=hidden name=idprodi2 value='{$idprodi2}'>";
    $href .= "idprodi2={$idprodi2}&";
}
if ( $statusprodi1 != "" )
{
    $qfield .= " AND STATUSPRODI1='{$statusprodi1}'";
    $qjudul .= " Status Pilihan 1 '".$arraystatuslulus[$statusprodi1]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi1 value='{$statusprodi1}'>";
    $href .= "statusprodi1={$statusprodi1}&";
}
if ( $statusprodi2 != "" )
{
    $qfield .= " AND STATUSPRODI2='{$statusprodi2}'";
    $qjudul .= " Status Pilihan 2 '".$arraystatuslulus[$statusprodi2]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi2 value='{$statusprodi2}'>";
    $href .= "statusprodi2={$statusprodi2}&";
}
if ( $sort == "" )
{
    $sort = " NILAI DESC";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM calonmahasiswa \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$q = "SELECT calonmahasiswa.*,YEAR(NOW())-YEAR(TANGGALLAHIR) AS UMUR \r\n  FROM calonmahasiswa \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
#echo $q;exit();
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Proses Kelulusan Calon Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Proses Kelulusan Calon Mahasiswa" );
        printmesgcetak( $qjudul );
        printmesgcetak( $errmesg );
    }*/
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printmesg("Proses Kelulusan Calon Mahasiswa");
    if ( $aksi != "cetak" )
    {
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
                                <span class=\"caption-subject bold uppercase\"> Proses Kelulusan Calon Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		printmesg( $qjudul );	
        echo "						<div class=\"tools\">
										<form target=_blank action='cetakkelulusan.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
										".createinputhidden( "sessid", $_SESSION['token'], "" )."
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='{$aksi}'>
										<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
										<input type=hidden name=gelombang value='{$gelombang}'>
										<input type=hidden name=idpilihan value='{$idpilihan}'>
											<div class=\"m-portlet__body\">
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-form-label\" style=padding-right:4.5px;>
															<input type=submit name=aksi2 class=\"btn btn-brand\" value='Kirim Pengumuman Kelulusan' onClick=\"return confirm('Kirim pengumuman kelulusan calon mahasiswa?');\">
													</label>
													<label class=\"col-form-label\" style=padding-right:4.5px;>
														Ke &nbsp;<select name=pilihankirim class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua </option><option value='lulus'>Yang Lulus </option><option value='tidaklulus'>Yang Tidak Lulus </option></select>
													</label>
													<label class=\"col-form-label\">
														Melalui &nbsp;<select name=pilihankirim2 class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''> E-mail dan SMS </option> \r\n         <option value='email'> E-mail </option> \r\n         <option value='sms'> SMS </option> \r\n         </select>\r\n \r\n         
													</label>
													<label class=\"col-form-label\">
															&nbsp;&nbsp;<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}
													</label>
												</div>
												<!--<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													
												</div>-->
												
											</div>
										</form>
									</div>
									<div class=\"tools\">
										<form  action='index.php' method=post>
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=aksi value='{$aksi}'>
										<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
										<input type=hidden name=gelombang value='{$gelombang}'>
										<input type=hidden name=idpilihan value='{$idpilihan}'>
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr>
														<td align=right><input type=submit name=aksi2 class=\"btn btn-brand\" value='Simpan Status Kelulusan'>\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\r\n\t\t\t\t</td></tr></table>
											</div>											
									</div>{$tpage} {$tpage2}";

        #echo " \t \r\n\t\t\t<form target=_blank action='cetakkelulusan.php' method=post>\r\n\t\t\t ".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t   <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t   <input type=hidden name=aksi value='{$aksi}'>\r\n\t\t\t   <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>\r\n\t\t\t   <input type=hidden name=gelombang value='{$gelombang}'>\r\n\t\t\t   <input type=hidden name=idpilihan value='{$idpilihan}'>\r\n\r\n\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t<tr><td align=left>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Kirim Pengumuman Kelulusan'\r\n         onClick=\"return confirm('Kirim pengumuman kelulusan calon mahasiswa?');\">\r\n          Ke \r\n         <select name=pilihankirim>\r\n         <option value=''>Semua </option> \r\n         <option value='lulus'>Yang Lulus </option> \r\n         <option value='tidaklulus'>Yang Tidak Lulus </option> \r\n         </select>\r\n         Melalui\r\n         <select name=pilihankirim2 >\r\n         <option value=''> E-mail dan SMS </option> \r\n         <option value='email'> E-mail </option> \r\n         <option value='sms'> SMS </option> \r\n         </select>\r\n \r\n         </td>\r\n \t\t\t\t<td align=right>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn green\" value='Cetak'>\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\r\n\t\t\t\t</td></tr></table></form>";
        #echo " \r\n\t\t\t<form  action='index.php' method=post>\r\n\t\t\t   <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t   <input type=hidden name=aksi value='{$aksi}'>\r\n\t\t\t   <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>\r\n\t\t\t   <input type=hidden name=gelombang value='{$gelombang}'>\r\n\t\t\t   <input type=hidden name=idpilihan value='{$idpilihan}'>\r\n\r\n\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t<tr><td align=right>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Simpan Status Kelulusan'>\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\t  \r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td> No. Tes</td>\r\n\t\t\t\t<td> Nama</td>\r\n\t\t\t\t<td> Tahun</td>\r\n\t\t\t\t<td> Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>Urutan</td> -->\r\n\t\t\t\t<td> Pilihan</td>\r\n\t\t\t\t<td> Pilihan 1</td>\r\n\t\t\t\t<td> PIG</td>\r\n \r\n\t\t\t\t<td> Pilihan 2</td>\r\n\t\t\t\t<td> PIG</td>\r\n \t\t\t\t<td> NILAI UJIAN</td> \r\n \t\t\t\t<td> STATUS</td>";
    echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$cetak}  align=center>
															<td>No</td>\r\n\t\t\t\t<td> No. Tes</td>\r\n\t\t\t\t<td> Nama</td>\r\n\t\t\t\t<td> Tahun</td>\r\n\t\t\t\t<td> Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>Urutan</td> -->\r\n\t\t\t\t<td> Pilihan</td>\r\n\t\t\t\t<td> Pilihan 1</td>\r\n\t\t\t\t<td> PIG</td>\r\n \r\n\t\t\t\t<td> Pilihan 2</td>\r\n\t\t\t\t<td> PIG</td>\r\n \t\t\t\t<td> NILAI UJIAN</td> \r\n \t\t\t\t<td> STATUS</td>";
															if ( $aksi2 == "Kirim Pengumuman Kelulusan" )
															{
																echo "\r\n \t\t\t\t<td> STATUS KELULUSAN YANG SUDAH DISIMPAN</td>\r\n \t\t\t\t<td> EMAIL</td>\r\n \t\t\t\t<td> SMS</td>\r\n \t\t\t\t<td> KETERANGAN</td>\r\n         \r\n         ";
																include_once( "teskirimsms.php" );
															}
    echo "												</tr>
													</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $d[UMUR] <= 15 && $aksi != "cetak" )
        {
            $kelas = "style='background-color:#ffff00'";
        }
        $bgstatus = "style='background-color:#bbbbbb;'";
        if ( $datafilter[$d[GELOMBANG]][$d[PRODI1]][NILAI] <= $d[NILAI] && $datafilter[$d[GELOMBANG]][$d[PRODI1]][JUMLAHMHS] < $datafilter[$d[GELOMBANG]][$d[PRODI1]][JUMLAH] )
        {
            $statuslulus = "Lulus Pilihan 1\r\n            <input type=hidden name='lulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['PRODI1']}'>\r\n            <input type=hidden name='idpilihanlulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['PILIHAN']}'>\r\n            ";
            ++$datafilter[$d[GELOMBANG]][$d[PRODI1]][JUMLAHMHS];
            $bgstatus = "";
        }
        else if ( $datafilter[$d[GELOMBANG]][$d[PRODI2]][NILAI] <= $d[NILAI] && $datafilter[$d[GELOMBANG]][$d[PRODI2]][JUMLAHMHS] < $datafilter[$d[GELOMBANG]][$d[PRODI2]][JUMLAH] )
        {
            $statuslulus = "Lulus Pilihan 2\r\n             <input type=hidden name='lulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['PRODI2']}'>\r\n            <input type=hidden name='idpilihanlulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['PILIHAN']}'>\r\n            ";
            ++$datafilter[$d[GELOMBANG]][$d[PRODI2]][JUMLAHMHS];
            $bgstatus = "";
        }
        else
        {
            $statuslulus = "Tidak Lulus\r\n            <input type=hidden name='lulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='-1'>           \r\n             <input type=hidden name='idpilihanlulus[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['PILIHAN']}'>\r\n           ";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$cetak} {$bgstatus}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=center>{$d['GELOMBANG']}</td>\r\n \t\t\t\t\t<!--<td align=center>{$d['ID']}</td>-->\r\n \t\t\t\t\t<td align=center>".$arraypilihanpmb[$d[PILIHAN]]."\r\n            </td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[PRODI1]]."</td>\r\n \t\t\t\t\t<td align=center>".$datafilter[$d[GELOMBANG]][$d[PRODI1]][NILAI]."</td>\r\n \r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[PRODI2]]."</td>\r\n \t\t\t\t\t<td align=center>".$datafilter[$d[GELOMBANG]][$d[PRODI2]][NILAI]."</td>\r\n          <td align=center> \r\n              {$d['NILAI']} \r\n          </td>";
        echo "\r\n          <td align=center> \r\n              {$statuslulus} \r\n          </td> ";
        $ket = "";
        $namafakultas = "";
        $namaprodi = "";
        $okbisadikirim = 0;
        if ( $aksi2 == "Kirim Pengumuman Kelulusan" )
        {
            if ( $d[LULUS] == "" )
            {
                $ket = "Status kelulusan belum disimpan";
                $statuslulusimpan = "-";
            }
            else
            {
                $dr = get_konfigpengumumanpmb( "PMB" );
                if ( $d[LULUS] == "-1" )
                {
                    if ( $pilihankirim == "" || $pilihankirim == "tidaklulus" )
                    {
                        $okbisadikirim = 1;
                    }
                    $statuslulusimpan = "Tidak Lulus";
                    $dmail[subject] = html_entity_decode( $dr[SUBJEK] );
                    $dmail[body] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", html_entity_decode( $dr[ISI2] ) );
                    $dmail[body] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[body] );
                    $dmail[body] = str_replace( "[STATUSKELULUSAN]", "TIDAK LULUS", $dmail[body] );
                }
                else if ( $d[LULUS] != "-1" && $d[LULUS] != "" )
                {
                    if ( $pilihankirim == "" || $pilihankirim == "lulus" )
                    {
                        $okbisadikirim = 1;
                    }
                    $statuslulusimpan = "Lulus ".$arrayprodi[$d[LULUS]];
                    $namaprodi = $arrayprodi[$d[LULUS]];
                    $namafakultas = "";
                    $q = "SELECT departemen.IDFAKULTAS AS FAKULTAS FROM departemen,prodi WHERE departemen.ID=prodi.IDDEPARTEMEN AND prodi.ID='{$d['LULUS']}'";
                    $h2 = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h2 ) )
                    {
                        $d2 = sqlfetcharray( $h2 );
                        $namafakultas = $arrayfakultas[$d2[FAKULTAS]];
                    }
                    $dmail[subject] = html_entity_decode( $dr[SUBJEK] );
                    $dmail[body] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", html_entity_decode( $dr[ISI] ) );
                    $dmail[body] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[body] );
                    $dmail[body] = str_replace( "[STATUSKELULUSAN]", "LULUS", $dmail[body] );
                    $dmail[body] = str_replace( "[PILIHANPRODI]", $namaprodi, $dmail[body] );
                    $dmail[body] = str_replace( "[PILIHANFAKULTAS]", $namafakultas, $dmail[body] );
                }
                $via = "";
                if ( $okbisadikirim == 1 )
                {
                    if ( ( $pilihankirim2 == "" || $pilihankirim2 == "email" ) && $d[EMAIL] != "" )
                    {
                        $dmail[to] = $d[EMAIL];
                        $via .= "email ";
                        $hasil = kirimemail_calonmahasiswa( $dmail );
                        if ( $hasil == 1 )
                        {
                            $ket .= "Terkirim via email<br>";
                        }
                        else
                        {
                            $ket .= "Tidak terkirim via email<br> {$hasil} <br>";
                        }
                    }
                    else if ( $d[EMAIL] == "" )
                    {
                        $ket .= "Alamat email tidak ada<br>";
                    }
                    if ( ( $pilihankirim2 == "" || $pilihankirim2 == "sms" ) && $d[HP] != "" )
                    {
                        $via .= "sms ";
                        if ( $SMSOK == 1 )
                        {
                            $dmail[body] = str_replace( "&nbsp;", "", $dmail[body] );
                            include( "kirimsms.php" );
                            $ket .= $ketemail;
                        }
                        else
                        {
                            if ( $SMSOK == 0 )
                            {
                                $ket .= "Error: Setting SMS Gateway Tidak Ada.<br>";
                            }
                            else
                            {
                                if ( $SMSOK == 0 - 1 )
                                {
                                    $ket .= "Error: Program SMS Gateway Tidak Ada.<br>";
                                }
                            }
                        }
                    }
                    else if ( $d[HP] == "" )
                    {
                        $ket .= "No Hp tidak ada<br>";
                    }
                    $ketlog = "Kirim Pengumuman Kelulusan ke Calon Mahasiswa.   ID={$d['ID']}, NIM={$d['NAMA']}, Status={$statuslulusimpan}. Via={$via} ";
                    buatlog( 89 );
                }
                else
                {
                    $ket = "Tidak dikirim";
                }
            }
            echo "\r\n \t\t\t\t<td> {$statuslulusimpan}</td>\r\n \t\t\t\t<td> {$d['EMAIL']}</td>\r\n \t\t\t\t<td> {$d['HP']} </td>\r\n \t\t\t\t<td align=left> {$ket}</td>\r\n         \r\n         ";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>\r\n    \t</form>\r\n   </div></div>{$tpage} {$tpage2}</div></div></div> ";
	echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Calon Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
