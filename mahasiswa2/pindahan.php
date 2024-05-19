<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
if ( $aksi == "" )
{
    $q = "SELECT \r\n\tmahasiswa.IDPRODI,mahasiswa.ID,mahasiswa.NAMA,\r\n  prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
		
        $q = "SELECT * FROM trpid WHERE NIMHSTRPID='{$idupdate}'";
        $h2 = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h2 ) )
        {
            $d2 = sqlfetcharray( $h2 );
        }
        else
        {
            echo "<br>";
            printmesg( "Data Pindahan belum ada. Semua field di bawah ini tidak merepresentasikan data mahasisswa yang sebenarnya." );
        }
        $tmp = explode( "-", $d2[TGLLSTRLSM] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d2[TGLRETRLSM] );
        $tglsk[thn] = $tmp[0];
        $tglsk[tgl] = $tmp[2];
        $tglsk[bln] = $tmp[1];
        $tmp = $d2[THSMSTRLSM];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d2[BLAWLTRLSM];
        $bulanawal = $tmp[0].$tmp[1];
        $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        #echo "\r\n\t\t<br>\r\n \t\t<table class=form> \r\n     <tr class=judulform>\r\n\t\t\t<td width=200 >Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>NIM </td>\r\n\t\t\t<td>{$d['ID']}</td>\r\n\t\t</tr> \t\t \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama  </td>\r\n\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t</tr> \r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Perguruan Tinggi Asal</td>\r\n\t\t\t<td>{$d2['NMPTITRPID']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Program Studi Asal</td>\r\n\t\t\t<td>{$d2['NMPSTTRPID']}</td>\r\n\t\t</tr>\r\n \r\n \r\n    \t\r\n  \t\t\t</table>\r\n \r\n\t\t";
		echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post>
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )."
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama Perguruan Tinggi Asal</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d2['NMPTITRPID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Program Studi Asal</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d2['NMPSTTRPID']}</label>
						</div>
					</div>
				</form>
			</div>";
	}
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
