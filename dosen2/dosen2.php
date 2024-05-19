<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
    $q = "SELECT * FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO msdos (NODOSMSDOS) VALUES ('{$idupdate}') ";
        mysqli_query($koneksi,$q);
        $q = "SELECT * FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
        $h = mysqli_query($koneksi,$q);
    }
    $d2 = sqlfetcharray( $h );
    $tmp = $d2[MLSEMMSDOS];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
    $tmp = explode( "-", $d2[TGLHRMSDOS] );
    $dt[thn] = $tmp[0];
    $dt[bln] = $tmp[1];
    $dt[tgl] = $tmp[2];
}
echo "		<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">KTP Dosen</label>\r\n    
				<div class=\"col-lg-6\">
					{$d2['NOKTPMSDOS']}
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Gelar Akademik</label>\r\n    
				<div class=\"col-lg-6\">
					{$d2['GELARMSDOS']}
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
				<div class=\"col-lg-6\">
					{$d2['TPLHRMSDOS']} / {$dt['tgl']}-{$dt['bln']}-{$dt['thn']} 
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
				<div class=\"col-lg-6\">
					".$arraykelamin[$d2[KDJEKMSDOS]]."
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Jabatan Akademik</label>\r\n    
				<div class=\"col-lg-6\">
					".$arrayjabatanakademik[$d2[KDJANMSDOS]]."
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Pendidikan Tertinggi</label>\r\n    
				<div class=\"col-lg-6\">
					".$arraypendidikantertinggi[$d2[KDPDAMSDOS]]."
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Status Ikatan Kerja</label>\r\n    
				<div class=\"col-lg-6\">
					".$arraystatusid[$d2[KDSTAMSDOS]]."
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">NIP PNS</label>\r\n    
				<div class=\"col-lg-6\">
					{$d['NIPPNS']}
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Instansi</label>\r\n    
				<div class=\"col-lg-6\">
					{$d['INSTANSI']}
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Semester Dosen Mulai Keluar/Pensiun/Alm.</label>\r\n    
				<div class=\"col-lg-6\">
					{$semester2}
				</div>
			</div>";
?>
