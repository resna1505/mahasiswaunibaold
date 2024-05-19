<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $aksi;exit();
periksaroot( );
if ( $aksitambah == "Hapus" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Komponen Nilai SP", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $jmlaf = 0;
        foreach ( $data as $k => $v )
        {
            if ( $v[hapus] == 1 )
            {
                $q = "\r\n\t\t\t\t\tDELETE FROM komponensp \r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDKOMPONEN='{$k}'\r\n\t\t\t\t\t\tAND\tIDPRODI='{$idprodiupdate}'\r\n\t\t\t\t\t\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Hapus Komponen Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\tID Komponen={$k}\r\n\t\t\t\t\t";
                    buatlog( 29 );
                    ++$jmlaf;
                    $q = "DELETE FROM nilaisp \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\tIDKOMPONEN='{$k}'\r\n \t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                }
            }
        }
        if ( 0 < $jmlaf )
        {
            $errmesg = "Data komponen nilai berhasil dihapus";
        }
        else
        {
            $errmesg = "Data komponen nilai tidak dihapus";
        }
    }
}
if ( $aksitambah == "Update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Komponen Nilai SP", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakulupdate );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahunupdate, $semesterupdate );
        $vld[] = cekvaliditasinteger( "Kode Kelas", $kelasupdate );
        foreach ( $data as $k => $v )
        {
            $vld[] = cekvaliditasnama( "Nama Komponen {$v['nama']}", $v['nama'], 32, false );
            $vld[] = cekvaliditasnumerik( "Bobot {$v['bobot']} untuk komponen {$v['nama']}", $v['bobot'], 6, false );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[update] == 1 )
                {
                    $q = "\r\n\t\t\t\t\tUPDATE komponensp \r\n\t\t\t\t\tSET \r\n\t\t\t\t\t\tNAMA='{$v['nama']}',\r\n\t\t\t\t\t\tBOBOT='{$v['bobot']}'\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDKOMPONEN='{$k}'\r\n\t\t\t\t\t\tAND\tIDPRODI='{$idprodiupdate}'\r\n\t\t\t\t\t\r\n\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Update Komponen Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\tID Komponen={$k} ({$v['nama']}/{$v['bobot']})\r\n\t\t\t\t\t";
                        buatlog( 28 );
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data komponen nilai berhasil diupdate";
            }
            else
            {
                $errmesg = "Data komponen nilai tidak diupdate";
            }
        }
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Komponen Nilai SP", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama Komponen", $nama, 32, false );
        $vld[] = cekvaliditasnumerik( "Bobot", $data['bobot'], 6, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, TAMBAH_DATA );
        }
        else if ( trim( $nama ) == "" )
        {
            $errmesg = "Nama komponen nilai baru harus diisi";
        }
        else if ( trim( $data[bobot] ) == "" || $data[bobot] < 0 )
        {
            $errmesg = "Bobot komponen nilai harus diisi >= 0";
        }
        else
        {
            $idbaru = getnewidsyarat( "IDKOMPONEN", "komponensp", "\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\t\t\t\tAND\tIDPRODI='{$idprodiupdate}'\r\n\t\t\t" );
            $q = "\r\n\t\t\tINSERT INTO komponensp (IDPRODI,IDDOSEN,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER) \r\n\t\t\tVALUES ('{$idprodiupdate}','{$iddosenupdate}','{$idbaru}','{$idmakulupdate}','{$tahunupdate}',\r\n\t\t\t'{$kelasupdate}','{$nama}','{$data['bobot']}','{$semesterupdate}')\r\n\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Update Komponen Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\tKelas={$kelasupdate},\r\n\t\tID Komponen={$idbaru} ({$nama}/{$data['bobot']})\r\n\t\t";
            buatlog( 27 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Komponen Nilai berhasil ditambah";
                $data = "";
                $nama = "";
            }
            else
            {
                $errmesg = "Data Komponen Nilai  tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Edit Data Komponen Nilai" );
   printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Edit Data Komponen Nilai </span>
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
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Edit Data Komponen Nilai");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
	echo "								<div class=\"table-scrollable\">";
	echo "									<table class=\"table table-striped table-bordered table-hover\">
												<tr class=judulform>\r\n\t\t\t<td>Prodi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr> \t\t\r\n     <tr class=judulform>\r\n\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar *</td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."
											</table>
										</div>
									</div>
					</div>
				</div>
			</div>
		</div>
	";
    #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", "{$token}", "" )."\r\n     <tr class=judulform>\r\n\t\t\t<td>Prodi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr> \t\t\r\n     <tr class=judulform>\r\n\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar *</td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t\r\n\t\t";
    #printjudulmenukecil( "Data Komponen Nilai Baru" );
    /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Komponen Nilai Baru </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
    $q = "\r\n\t\t\tSELECT (100-SUM(BOBOT)) AS SISABOBOT FROM komponensp WHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\t\t\tAND\tIDPRODI='{$idprodiupdate}'\r\n \t\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $data[bobot] = $d[SISABOBOT];
	#echo "\r\n\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n \t\t <tr class=judulform>\r\n\t\t\t<td class=judulform>Nama Komponen</td>\r\n\t\t\t<td>".createinputtext( "nama", "{$nama}", "size=40 class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Bobot (persentase)</td>\r\n\t\t\t<td>".createinputtext( "data[bobot]", "{$data['bobot']}", "size=4 class=form-control m-input" )."%</td>\r\n\t\t\t</td>\r\n\t\t</tr>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn default\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t<script>\r\n\t\t\tform.nama.focus();\r\n\t\t</script>\r\n \t\t";
    echo "<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", "{$token}", "" )."
	<div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Data Komponen Nilai Baru");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
	echo "							
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr class=judulform>
													<td class=judulform>Nama Komponen</td>
													<td>".createinputtext( "nama", "{$nama}", "size=40 class=form-control m-input" )."</td>
												</tr>"."
												<tr class=judulform>
													<td>Bobot (persentase)</td>
													<td>".createinputtext( "data[bobot]", "{$data['bobot']}", "size=4 class=form-control m-input" )."%</td>
												</tr>"."
												<tr>
													<td colspan=2>
														<input type=submit value='Tambah' class=\"btn btn-brand\">
														<input type=reset value='Reset' class=\"btn btn-secondary\">
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</form><script>form.nama.focus();</script>";
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponensp\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\t\t\tAND IDPRODI='{$idprodiupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $arraykomponendefault = getkomponendefault( );
        if ( is_array( $arraykomponendefault ) )
        {
            foreach ( $arraykomponendefault as $k => $d )
            {
                $q = "INSERT INTO komponensp\r\n    \t\t\t\t(IDPRODI,IDDOSEN,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NAMA,BOBOT,SEMESTER)\r\n    \t\t\t\tVALUES\r\n    \t\t\t\t('{$idprodiupdate}','{$iddosenupdate}',{$k},'{$idmakulupdate}','{$tahunupdate}','{$kelasupdate}','{$d['NAMA']}','{$d['PERSEN']}','{$semesterupdate}')";
                mysqli_query($koneksi,$q);
            }
        }
    }
    #printjudulmenukecil( "Rincian Komponen Nilai" );
    /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Rincian Komponen Nilai </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponensp\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\tAND IDPRODI='{$idprodiupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDDOSEN='{$iddosenupdate}'\r\n\t\t\tORDER BY BOBOT DESC\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n\t\t<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", "{$token}", "" )."";
		echo "<div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Rincian Komponen Nilai");
								echo	"</div>
									</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>
															<td colspan=3></td>
															<td><input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td>
															<td><input type=submit name=aksitambah value='Hapus' class=\"btn btn-secondary\" onClick=\"return confirm('Hapus Data Komponen? Penghapusan data komponen nilai juga akan menghapus data nilai mahasiswa yang mengambil M-K bersangkutan')\"></td>
														</tr>
														<tr class=juduldata align=center>
															<td>No</td>
															<td>Nama Komponen</td>
															<td>Bobot (%)</td>
															<td >Pilih Update</td>
															<td >Pilih Hapus</td>
														</tr>
													</thead>
													<tbody>";
        $i = 1;
        $totalbobot = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKOMPONEN']}][nama]", "{$d['NAMA']}", " class=form-control m-input size=40" )."</td>\r\n\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKOMPONEN']}][bobot]", "{$d['BOBOT']}", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKOMPONEN']}][update]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKOMPONEN']}][hapus]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            $totalbobot += $d[BOBOT];
            ++$i;
        }
        echo " \r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=2 align=right>Total Bobot</td>\r\n\t\t\t\t\t<td>{$totalbobot}</td>\r\n\t\t\t\t\t<td colspan=2></td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
       echo "										</tbody>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		";
		 #echo "</table>\r\n\t\t\t</div></div></div></div></div><br><br>";
		
    }
    else
    {
        $errmesg = "Komponen Nilai belum ada";
        printmesg( $errmesg );
    }
}
if ( $aksi == "tampilkanawal" )
{
	#echo "tampilkanawal";	
    cekhaktulis( $kodemenu );
    $aksi = " ";
    include( "prosestampilkomponenawal.php" );
}
if ( $aksi == "tampilkan" )
{
	#echo "tampilkan";
    $aksi = " ";
    include( "prosestampilkomponen.php" );
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Edit Komponen Nilai Mata Kuliah " );
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Data Komponen Nilai Mata Kuliah Semester Pendek");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkanawal'>
									<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
	echo "										</select>
											</label>
										</div>";
    if ( $jenisusers == 0 )
    {
        echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
											<div class=\"col-lg-6\">
												".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
												<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
												<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
													<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
												</div>
											</div>
										</div>";
    }
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
											<div class=\"col-lg-6\">
												".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
												<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
												<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
													<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
												</div>
											</div>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
											<label class=\"col-form-label\">";
												$waktu = getdate( );
	echo "										<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													$i = 1900;
													while ( $i <= $waktu[year] + 5 )
													{
														echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
														++$i;
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
											<label class=\"col-form-label\">
												<select name=semester class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
													foreach ( $arraysemester as $k => $v )
													{
														echo "<option value='{$k}' {$cek}>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>";
										$arraylabelkelas[''] = "Semua";
    echo "								<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
											<label class=\"col-form-label\">
												".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "class=form-control m-input" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit value='Lanjut' class=\"btn btn-brand\">
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
                form.id.focus();
            </script>";
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Komponen Nilai Mata Kuliah " );
     echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Data Komponen Nilai Mata Kuliah Semester Pendek");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=10 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\">daftar dosen</a>-->
											<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
												<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10  id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahun.value,form.semester.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
											<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
											<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
												<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
										<label class=\"col-form-label\">
											<select name=semester class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraysemester as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
    echo "									</select>
										</label>
									</div>";
										$arraylabelkelas[''] = "Semua";
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
										</div>
									</div>
									</div>
		</form>
		<!--end::Form--></div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
            <script>
                form.idmakul.focus();
            </script>";
}
?>