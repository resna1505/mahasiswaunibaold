<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT ID,NAMA,IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printmesg( $errmesg );
    $d = sqlfetcharray( $h );
    $q = "SELECT STPIDMSMHS FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
    $h2 = mysqli_query($koneksi,$q);
    $d2 = sqlfetcharray( $h2 );
    $statuspindahan = $d2[STPIDMSMHS];
    if ( $d2[STPIDMSMHS] != "P" )
    {
        $strpindahan = "<br><center style='font-size:12pt;color:#ff0000'><b>Perhatian! Anda BUKAN Mahasiswa Pindahan. <br>Semua nilai konversi yang disimpan tidak akan mempengaruhi IPK Anda.</b></center>\r\n        <br>";
    }
    #echo "\r\n \t\t{$strpindahan}\r\n\t\t<table class=form>"." \r\n     <tr class=judulform>\r\n\t\t\t<td width=150><b>Jurusan/Program Studi</td>\r\n\t\t\t<td><b>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n      <tr class=judulform>\r\n\t\t\t<td width=100><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table>\r\n \t\t\r\n  \t\t";
    echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post>
					{$strpindahan}
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d[IDPRODI]]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>";
	$q = "SELECT nilaikonversi.* ,trnlp.THSMSTRNLP,BOBOTTRNLP AS BOBOT ,NLAKHTRNLP AS NILAI\r\n        FROM nilaikonversi LEFT JOIN trnlp ON \r\n        nilaikonversi.IDMAHASISWA=trnlp.NIMHSTRNLP AND  \r\n        nilaikonversi.IDMAKUL=trnlp.KDKMKTRNLP \r\n        WHERE IDMAHASISWA='{$idupdate}' \r\n        ORDER BY SEMESTERMAKUL,IDMAKUL";
    echo $q;
	$h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=form >\r\n\t \t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>ThnSem</td>\r\n \t\t\t\t\t\t<td>Semester Makul</td>\r\n\t\t\t\t\t\t<td>Kode Makul</td>\r\n\t\t\t\t\t\t<td>Nama Makul</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n \r\n \t\t\t\t\t</tr>";
        echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>ThnSem</td>\r\n \t\t\t\t\t\t<td>Semester Makul</td>\r\n\t\t\t\t\t\t<td>Kode Makul</td>\r\n\t\t\t\t\t\t<td>Nama Makul</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Nilai</td></tr>
													</thead>
													<tbody>";
		$i = 1;
        $totalsks = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>\r\n              {$d['THSMSTRNLP']}\r\n               </td>\r\n \t\t\t\t\t\t<td align=center> {$d['SEMESTERMAKUL']}  </td>\r\n \t\t\t\t\t\t<td align=center> {$d['IDMAKUL']} </td>\r\n \t\t\t\t\t\t<td align=left> {$d['NAMAMAKUL']} </td>\r\n \t\t\t\t\t\t<td align=center> {$d['SKS']} </td>\r\n \t\t\t\t\t\t<td align=center> {$d['BOBOT']} </td>\r\n \t\t\t\t\t\t<td align=center> {$d['NILAI']} </td>\r\n \t\t\t\t\t</tr>";
            $totalsks += $d[SKS];
            $totalbobot += $d[SKS] * $d[BOBOT];
            ++$i;
        }
        $ipkkonversi = number_format_sikad( @$totalbobot / @$totalsks, 2 );
        echo "\r\n      <tr>\r\n        <td colspan=5 align=right>Total SKS diakui</td>\r\n        <td align=center><b>{$totalsks}</b></td>\r\n        <td colspan=3 align=center>IPK Konversi : <b>{$ipkkonversi}</b></td>\r\n      </tr>\r\n      ";
        if ( $statuspindahan == "P" )
        {
            $q = "UPDATE msmhs SET SKSDIMSMHS='{$totalsks}'\r\n        WHERE NIMHSMSMHS ='{$idupdate}'";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $strsksdiakui = "SKS diakui untuk mahasiswa pindahan telah diupdate";
            }
        }
        #echo "\r\n\t\t\t\t</table>\r\n\t\t\t\t{$strsksdiakui}\r\n \r\n\t\t<form name=form2 action=cetakkonversi.php method=post target=_blank >\r\n \t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td align=center> <input type=submit name=aksi value=Cetak></td>\r\n \t\t</tr> \r\n    </table>\r\n\t\t\t";
		 echo "\r\n\t\t\t\t</table>\r\n\t\t\t\t{$strsksdiakui}\r\n        </form>
				<form name=form2 action=cetakkonversi.php method=post target=_blank >
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "sessid", $_SESSION['token'], "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )." 
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
else
{
    $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
