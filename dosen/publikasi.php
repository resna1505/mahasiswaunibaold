<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
/*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n</div></div>";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$namamakul."</label>
						</div>";
if ( $aksi2 == "hapus" )
{
    if ( $_SESSION['token'] == $_GET['sessid'] )
    {
        $q = "\r\n  \t\t\t\t\tDELETE FROM trpud\r\n  \t\t\t\t\tWHERE\r\n  \t\t\t\t\tNODOSTRPUD='{$idupdate}'\r\n  \t\t\t\t\tAND THSMSTRPUD='{$tahunsemester}' AND NORUTTRPUD='{$urutan}'  \r\n  \t\t\t\t";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Publikasi Dosen berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Publikasi Dosen tidak dihapus";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Publikasi", HAPUS_DATA );
    }
    $aksi2 = "";
}
if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $vldt[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan", $tahun, $semester );
        $vldt[] = cekvaliditaskode( "Jenis Penelitian", $jenis );
        $vldt[] = cekvaliditaskode( "Media Publikasi", $media );
        $vldt[] = cekvaliditaskode( "Jenis pengarang", $pengarang );
        $vldt[] = cekvaliditaskode( "Jenis pengarang", $pengarang );
        $vldt[] = cekvaliditaskode( "Kelompok Mandiri/kegiatan", $mandiri );
        $vldt[] = cekvaliditastahun( "Tahun Publikasi", $tahunp );
        $vldt[] = cekvaliditasinteger( "Bulan Publikasi", $bulanp, 2 );
        $vldt[] = cekvaliditaskode( "Pembiayaan", $biaya );
        $vldt[] = cekvaliditasnumerik( "Jumlah Biaya", $biaya2 );
        $vldt = array_filter( $vldt, "filter_not_empty" );
        if ( isset( $vldt ) && 0 < count( $vldt ) )
        {
            $errmesg = val_err_mesg( $vldt, 2, SIMPAN_DATA );
        }
        else
        {
            $q = "SELECT IDDEPARTEMEN FROM dosen WHERE ID='{$idupdate}'";
            $h = doquery($koneksi,$q);
            $d = sqlfetcharray( $h );
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDDEPARTEMEN']}'";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $idpt = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            $judulp1 = substr( $judulp, 0, 60 );
            $judulp2 = substr( $judulp, 60, 60 );
            $judulp3 = substr( $judulp, 120, 60 );
            $judulp4 = substr( $judulp, 180, 60 );
            $judulp5 = substr( $judulp, 240, 60 );
            if ( $bulanp < 10 )
            {
                $bulanp = "0".$bulanp;
            }
            $q = " UPDATE trpud SET\r\n\t\t\t\tKDPTITRPUD='{$idpt}',\r\n\t\t\t\tKDPSTTRPUD='{$kodeps}',\r\n\t\t\t\tKDJENTRPUD ='{$kodejenjang}', \r\n\t\t\t\tKDLITTRPUD ='{$jenis}',\r\n\t\t\t\tKDPUBTRPUD='{$media}' ,\r\n\t\t\t\tKDATHTRPUD='{$pengarang}' ,\r\n\t\t\t\tKDKELTRPUD='{$mandiri}' ,\r\n\t\t\t\tTHNBLTRPUD='{$tahunp}{$bulanp}' ,\r\n\t\t\t\tKDBIYTRPUD='{$biaya}' ,\r\n\t\t\t\tJMBIYTRPUD='{$biaya2}',\r\n\t\t\t\tJUDU1TRPUD='{$judulp1}' ,\r\n\t\t\t\tJUDU2TRPUD='{$judulp2}' ,\r\n\t\t\t\tJUDU3TRPUD='{$judulp3}' ,\r\n\t\t\t\tJUDU4TRPUD='{$judulp4}' ,\r\n\t\t\t\tJUDU5TRPUD='{$judulp5}' ,\r\n\t\t\t\tTHSMSTRPUD='{$tahun}{$semester}',\r\n\t\t\t\tSKS='{$sks}'\r\n\t\t\t\tWHERE NODOSTRPUD ='{$idupdate}' AND NORUTTRPUD='{$urutan}' \r\n\t\t\t\tAND THSMSTRPUD='{$tahunsemester}'\r\n           ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $tahunsemester = "{$tahun}{$semester}";
                $errmesg = "Data Publikasi Dosen berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Publikasi Dosen tidak disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Publikasi", SIMPAN_DATA );
    }
    $aksi2 = "formupdate";
}
if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $vldt[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan", $tahun, $semester );
        $vldt[] = cekvaliditaskode( "Jenis Penelitian", $jenis );
        $vldt[] = cekvaliditaskode( "Media Publikasi", $media );
        $vldt[] = cekvaliditaskode( "Jenis pengarang", $pengarang );
        $vldt[] = cekvaliditaskode( "Jenis pengarang", $pengarang );
        $vldt[] = cekvaliditaskode( "Kelompok Mandiri/kegiatan", $mandiri );
        $vldt[] = cekvaliditastahun( "Tahun Publikasi", $tahunp );
        $vldt[] = cekvaliditasinteger( "Bulan Publikasi", $bulanp, 2 );
        $vldt[] = cekvaliditaskode( "Pembiayaan", $biaya );
        $vldt[] = cekvaliditasnumerik( "Jumlah Biaya", $biaya2 );
        $vldt = array_filter( $vldt, "filter_not_empty" );
        if ( isset( $vldt ) && 0 < count( $vldt ) )
        {
            $errmesg = val_err_mesg( $vldt, 2, TAMBAH_DATA );
        }
        else
        {
            if ( trim( $judulp ) == "" )
            {
                $errmesg = "Judul Publikasi harus diisi";
            }
            else
            {
                $idbaru = getnewidsyarat( "NORUTTRPUD", "trpud", " WHERE \r\n\t\t\tNODOSTRPUD='{$idupdate}' AND THSMSTRPUD='{$tahun}{$semester}'\r\n\t\t\t" );
                $q = "SELECT IDDEPARTEMEN FROM dosen WHERE ID='{$idupdate}'";
                $h = doquery($koneksi,$q);
                $d = sqlfetcharray( $h );
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDDEPARTEMEN']}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $idpt = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $judulp1 = substr( $judulp, 0, 60 );
                $judulp2 = substr( $judulp, 60, 60 );
                $judulp3 = substr( $judulp, 120, 60 );
                $judulp4 = substr( $judulp, 180, 60 );
                $judulp5 = substr( $judulp, 240, 60 );
                if ( $bulanp < 10 )
                {
                    $bulanp = "0{$bulanp}";
                }
                $q = " INSERT INTO trpud \r\n\t\t\t   (THSMSTRPUD,KDPTITRPUD,KDPSTTRPUD,KDJENTRPUD ,NODOSTRPUD ,NORUTTRPUD ,KDLITTRPUD ,\r\n\t\t\t   KDPUBTRPUD ,KDATHTRPUD ,KDKELTRPUD ,THNBLTRPUD ,KDBIYTRPUD ,JMBIYTRPUD,\r\n         JUDU1TRPUD ,\r\n\t\t\t   JUDU2TRPUD,JUDU3TRPUD,JUDU4TRPUD,JUDU5TRPUD,SKS )\r\n\t\t\t   VALUES\r\n         ('{$tahun}{$semester}','{$idpt}','{$kodeps}','{$kodejenjang}','{$idupdate}','{$idbaru}','{$jenis}',\r\n         '{$media}','{$pengarang}','{$mandiri}','{$tahunp}{$bulanp}','{$biaya}','{$biaya2}',\r\n         '{$judulp1}',\r\n         '{$judulp2}','{$judulp3}','{$judulp4}','{$judulp5}','{$sks}')\r\n         ";
                doquery($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Publikasi Dosen berhasil disimpan";
                    $data = "";
                    $jenis = $media = $tahunp = $bulanp = $pengarang = $mandiri = $biaya = $kodenegara = "";
                }
                else
                {
                    $errmesg = "Data Publikasi Dosen tidak disimpan";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Publikasi", TAMBAH_DATA );
    }
    $aksi2 = "formtambah";
}
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>\t\t\t\t".IKONTAMBAH." Tambah Data</td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>\t\t\t\t".IKONUPDATE."\r\n Edit Data</td>\r\n  </tr>\r\n</table></div></div>";
printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi2 == "formupdate" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
	include( "formpublikasi.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "formtambah" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n  ";
	include( "formpublikasi.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trpud WHERE NODOSTRPUD='{$idupdate}' ORDER BY THSMSTRPUD DESC, NORUTTRPUD";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n\t\t\t<br>\r\n\t\t\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\" {$border} class=data >\r\n \t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Jenis Penelitian</td>\r\n\t\t\t\t\t\t<td>Media Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun / Bulan Publikasi</td>\r\n\t\t\t\t\t\t<td>Jumlah SKS</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Biaya (Rp.)</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n\t\t\t\t\t\t<td colspan=2>Aksi</td>\r\n\t\t\t\t\t</tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								 <tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Jenis Penelitian</td>\r\n\t\t\t\t\t\t<td>Media Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun / Bulan Publikasi</td>\r\n\t\t\t\t\t\t<td>Jumlah SKS</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Biaya (Rp.)</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n\t\t\t\t\t\t<td colspan=2>Aksi</td>\r\n\t\t\t\t\t</tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRPUD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            $tmp = $d[THNBLTRPUD];
            $tp[thn] = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $tp[bln] = $tmp[4].$tmp[5];
            $judulp = $d[JUDU1TRPUD].$d[JUDU2TRPUD].$d[JUDU3TRPUD].$d[JUDU4TRPUD].$d[JUDU5TRPUD];
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center nowrap>\r\n             {$tahun}\r\n             ".$arraysemester[$semester]."\r\n             </td>\r\n\t\t\t\t\t\t<td>".$arrayjenispenelitian[$d[KDLITTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraymediapublikasi[$d[KDPUBTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arrayperanpenulisan[$d[KDATHTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraykegiatanmandiri[$d[KDKELTRPUD]]."</td>\r\n\t\t\t\t\t\t<td nowrap align=center>{$tp['thn']}-{$tp['bln']}</td>\r\n\t\t\t\t\t\t<td align=center>".$d[SKS]."</td>\r\n\t\t\t\t\t\t<td>".$arraypembiayaan[$d[KDBIYTRPUD]]."</td>\r\n\t\t\t\t\t\t<td align=right>".cetakuang( $d[JMBIYTRPUD] )."</td>\r\n\t\t\t\t\t\t<td>".nl2br( $judulp )."</td>\r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTTRPUD']}&tahunsemester={$d['THSMSTRPUD']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Publikasi Dosen?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTTRPUD']}&tahunsemester={$d['THSMSTRPUD']}&aksi2=hapus&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>              \r\n\r\n\t\t\t\t\t</tr>";
            ++$i;
        }
        #echo "\r\n\t\t\t\t</table></div></div>\r\n\t\t\t";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
        echo "<p>";
        printmesg( "Data Publikasi tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
