<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#printjudulmenu( "Data KRS Mahasiswa Perwalian" );
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Data KRS Mahasiswa Perwalian");
								echo "	</div>";
						
$tmpcetak = "";
if ( trim( $idmahasiswa ) == "" || !isdataada( $idmahasiswa, "mahasiswa" ) )
{
    $errmesg = "Tidak ada Mahasiswa dengan NIM '{$idmahasiswa}'";
    $aksi = "tambahawal";
}
else
{
    $q = "\r\n\t\t\tSELECT mahasiswa.NAMA,ANGKATAN,IDPRODI,KELAS AS KELASDEFAULT FROM  mahasiswa	WHERE mahasiswa.ID='{$idmahasiswa}'\r\n \t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $errmesg = "Data Mahasiswa / Data Dosen Wali Tidak Ada";
        $aksi = "tambahawal";
    }
    $d = sqlfetcharray( $h );
    $angkatanx = $d[ANGKATAN];
    echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								{$idmahasiswa}
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								{$d['NAMA']}
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								{$d['ANGKATAN']}
							</label>
						</div>
					</div>
				</form>
				</div>";
    #$q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\tmakul.NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS\r\n\t\t\t\tFROM pengambilanmk,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.TAHUN,pengambilanmk.SEMESTER\r\n\t\t\t";
    $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.* ,\r\n \t\t\t\tSKSMAKUL AS SKS,\r\n \t\t\t\ttbkmk.NAKMKTBKMK AS NAMA\r\n\t\t\t\tFROM pengambilanmk,tbkmk,msmhs\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.TAHUN,pengambilanmk.SEMESTER \r\n\t\t\t";
    echo $q;
	$h = mysqli_query($koneksi,$q);
    $tmpcetak .= mysqli_error($koneksi);
    if ( sqlnumrows( $h ) <= 0 )
    {
        printmesg( "Data Pengambilan Mata Kuliah belum ada<br><BR>" );
    }
    else
    {
        #$tmpcetak .= "<br> <b>Data Mata Kuliah Yang Telah Diambil</b><br><br>";
		$tmpcetak .= "		<div class='portlet-title'>";
								printmesg("Data Mata Kuliah Yang Telah Diambil");
		$tmpcetak .= "	</div>";
        #$tmpcetak .= "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
        $tmpcetak .="	<div class=\"m-portlet\">
							<div class=\"m-section__content\">
								<div class=\"table-responsive\">
									<table class=\"table table-bordered table-hover\">
										<thead>
											<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
		$tmpcetak .="					</thead>
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
            $tmp = "";
            if ( $semlama != $semesterx )
            {
                if ( $semlama != "" )
                {
                    $tmp = "\r\n\t\t\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\r\n\t\t\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t\t\t</tr>";
                }
                $semlama = $semesterx;
                $tmpcetak .= "\r\n \t\t\t\t\t\t   {$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=7>Semester {$semestertulis}  \r\n\t\t\t\t\t\t\t\t{$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurakhir}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }
            $kelas = kelas( $i );
            $tmpcetak .= "\r\n\t\t\t\t\t<tr {$kelas}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td>{$d['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>{$d['KELAS']}</td>\r\n\t\t\t\t\t</tr>";
            $totalsks += $d[SKS];
            $total += $semesterx;
            $tahunlama = $d[TAHUN];
            $sem = $d[SEMESTER] % 2;
            if ( $sem == 0 )
            {
                $sem = 2;
            }
            $idmakul = $d[IDMAKUL];
            ++$i;
        }
        if ( $semlama != "" )
        {
            $tmpcetak .= "\r\n\t\t\t\t\t\t<tr class=juduldata >\r\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester</td>\r\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}  </td>\r\n\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t</tr>";
        }
        $tmpcetak .= " \r\n\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t</tr>";
        #$tmpcetak .= "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t \r\n\t\t\t\t";
		$tmpcetak .="					</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>";
		
    }
}
echo $tmpcetak;
?>
