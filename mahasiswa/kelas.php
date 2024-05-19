<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
#printjudulmenu( "Distribusi Kelas" );
if ( $aksi == "Tambah" )
{
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = "Sesi login Anda telah berubah.<br>Ulangi proses tambah kelas";
    }
    else
    {
        $vld[] = cekvaliditaskode( "Retang Awal NPM/NIM", $nim1b );
        $vld[] = cekvaliditaskode( "Retang Akhir NPM/NIM", $nim2b );
        $vld[] = cekvaliditasinteger( "Kelas", $kelasbaru, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = "Data ".inv_message( $vld )." tidak valid.<br>Data tidak ditambahkan";
            unset( $vld );
        }
        else
        {
            $q = "INSERT INTO kelas (ID,NIM1,NIM2,KELAS,UPDATER,TANGGALUPDATE)\r\n  VALUES (0,'{$nim1b}','{$nim2b}','{$kelasbaru}','{$users}',NOW())";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Distribusi Kelas berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Distribusi Kelas tidak disimpan";
            }
        }
    }
}
if ( $aksi == "Hapus" )
{
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = "Sesi login Anda telah berubah.<br>Ulangi proses tambah kelas";
    }
    else if ( is_array( $pilih ) )
    {
        foreach ( $pilih as $k => $v )
        {
            $q = "DELETE FROM kelas WHERE ID='{$k}'";
            doquery($koneksi,$q);
        }
        $errmesg = "Data Distribusi Kelas berhasil dihapus";
    }
}
if ( $aksi == "Simpan" )
{
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = "Sesi login Anda telah berubah.<br>Ulangi proses tambah kelas";
    }
    else if ( is_array( $pilih ) )
    {
        foreach ( $pilih as $k => $v )
        {
            $vld[] = cekvaliditaskode( "Retang NPM/NIM", $nim1[$k] );
            $vld[] = cekvaliditaskode( "Retang NPM/NIM", $nim2[$k] );
            $vld[] = cekvaliditasinteger( "Kelas", $kelas[$k], 2 );
        }
        $vld = array_unique( array_filter( $vld, "filter_not_empty" ) );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = "Data ".inv_message( $vld )." tidak valid.<br>Data tidak disimpan";
            unset( $vld );
        }
        else
        {
            foreach ( $pilih as $k => $v )
            {
                $q = "UPDATE kelas \r\n        SET NIM1='".$nim1[$k]."',\r\n        NIM2='".$nim2[$k]."',\r\n        KELAS='".$kelas[$k]."'\r\n        WHERE ID='{$k}'";
                doquery($koneksi,$q);
            }
            $errmesg = "Data Distribusi Kelas berhasil disimpan";
        }
    }
}
printmesg( $errmesg );
/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Distribusi Kelas</span>
                            </div>
                            <div class=\"tools\">";

echo "\r\n<form method=post action=index.php>\r\n <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n ".IKONTOOLS48."\r\n";  


echo"</form>
                            </div>
                        </div>
                        <div class=\"portlet-body\"><div class=\"table-scrollable\"><table class=\"table table-striped table-bordered table-hover\">";

echo "<thead>
                            <tr>
                                <th scope=\"col\">No</th>
                                <th scope=col>Rentang NPM/NIM</th>
                                <th scope=col>Kelas</th>
                                <th scope=col>Aksi</th></tr></thead>";*/

/*echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Distribusi Kelas");
								echo	"</div>
										
									</div>
									<div class='portlet-body form'>
                           <form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
							<input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>
							<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">";
 */  
/*echo "\r\n<form method=post action=index.php>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n ".IKONTOOLS48."\r\n  <table  width=90%>\r\n    <tr class=juduldata align=center>\r\n      <td>No</td>\r\n      <td>Rentang NPM/NIM</td>\r\n      <td>Kelas</td>\r\n      <td>Aksi</td>\r\n    </tr>\r\n    <tr class=datagenap align=center>\r\n      <td>*</td>\r\n      <td><input type=text name=nim1b size=3> s.d <input type=text name=nim2b size=3></td>\r\n      <td><input type=text name=kelasbaru size=2></td>\r\n      <td><input type=submit name=aksi value='Tambah'></td>\r\n    </tr>";*/
echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"tools\">
											<div class=\"table-scrollable\">
											
											</div>{$tpage} {$tpage2}";
									
										printtitle("Distribusi Kelas");
echo "								</div>
								<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
									<input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=sessid value='{$_SESSION['token']}'>
									<div class=\"m-portlet\">
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
														<th align=\"center\">No</th>
														<th>Rentang NPM/NIM</th>
														<th>Kelas</th>
														<th>Aksi</th>
														</tr>
														<tr class=datagenap align=center>\r\n      
															<td>*</td>\r\n      
															<td><input type=text name=nim1b size=3> s.d <input type=text name=nim2b size=3></td>\r\n    
															<td><input type=text name=kelasbaru size=2></td>\r\n      
															<td><input type=submit name=aksi class=\"btn btn-brand\" value='Tambah'></td>
														</tr>
													</thead>
													
													<tbody>
														";
#echo "<tr class=juduldata align=center>\r\n      <td>No</td>\r\n      <td>Rentang NPM/NIM</td>\r\n      <td>Kelas</td>\r\n      <td>Aksi</td>\r\n    </tr>\r\n    <tr class=datagenap align=center>\r\n      <td>*</td>\r\n      <td><input type=text name=nim1b size=3> s.d <input type=text name=nim2b size=3></td>\r\n      <td><input type=text name=kelasbaru size=2></td>\r\n      <td><input type=submit name=aksi class=\"btn btn-brand\" value='Tambah'></td>\r\n    </tr>";
$q = "SELECT * FROM kelas ORDER BY NIM1,NIM2";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        #echo "\r\n            <tr class=datagenap align=center>\r\n              <td>{$i}</td>\r\n              <td><input type=text name=nim1[{$d['ID']}] size=3 value='{$d['NIM1']}'> s.d \r\n                  <input type=text name=nim2[{$d['ID']}] size=3  value='{$d['NIM2']}'></td>\r\n              <td><input type=text name=kelas[{$d['ID']}] size=2  value='{$d['KELAS']}'></td>\r\n              <td><input type=checkbox name=pilih[{$d['ID']}] value=1></td>\r\n            </tr>\r\n            \r\n            ";
		echo "<tr class=datagenap align=center>
            <td>{$i}</td>
            <td><input type=text name=nim1[{$d['ID']}] size=3 value='{$d['NIM1']}'> s.d \r\n                  <input type=text name=nim2[{$d['ID']}] size=3  value='{$d['NIM2']}'></td>
			<td><input type=text name=kelas[{$d['ID']}] size=2  value='{$d['KELAS']}'></td>\r\n      
			<td><input type=checkbox name=pilih[{$d['ID']}] value=1></td>\r\n   
        </tr>";
	}
    echo "\r\n    <tr class=datagenap align=center>\r\n      <td></td>\r\n      <td></td>\r\n      <td></td>\r\n      <td><input type=submit name=aksi class=\"btn btn-brand\" value='Simpan'> <input type=submit name=aksi class=\"btn btn-secondary\" value='Hapus'></td>\r\n    </tr>      \r\n      ";
}
#echo "\r\n  </table></div>\r\n</form>\r\n";
echo "												</tbody>
												</table>
											</div>
										</div>
									</div>
								</form>";
echo "<hr>";
if ( $aksi == "Update Kelas" )
{
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = "Sesi login Anda telah berubah.<br>Ulangi proses tambah kelas";
    }
    else
    {
        $vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
        $vld[] = cekvaliditastahun( "Angkatan", $angkatan );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = "Data ".inv_message( $vld )." tidak valid.<br>Data tidak disimpan";
            unset( $vld );
        }
        else
        {
            if ( $idprodi != "" )
            {
                $qfield = " AND IDPRODI='{$idprodi}'";
            }
            if ( $angkatan != "" )
            {
                $qfield .= " AND ANGKATAN='{$angkatan}'";
            }
            $q = "SELECT * FROM kelas ORDER BY NIM1,NIM2";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    $q = "UPDATE mahasiswa SET KELAS='{$d['KELAS']}' \r\n          WHERE substring(ID,length(id)-3+1,3)+0 >= {$d['NIM1']} AND\r\n          substring(ID,length(id)-3+1,3)+0 <= {$d['NIM2']} \r\n          {$qfield}";
                    doquery($koneksi,$q);
                }
                $errmesg = "Data Kelas Default Mahasiswa Berhasil diupdate";
            }
        }
    }
}
#echo "Update Kelas Default Mahasiswa berdasarkan Distribusi Kelas</br></br>";
printtitle("Update Kelas Default Mahasiswa berdasarkan Distribusi Kelas");
printmesg( $errmesg );

/*echo "<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">
								*/
echo "				<div class=\"m-portlet\">				
						<!--begin::Form-->
                        <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post method=post onSubmit=\"return confirm('Update Kelas Default Mahasiswa?')\" ENCTYPE='MULTIPART/FORM-DATA'>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=sessid value='{$_SESSION['token']}'>
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
									<div class=\"col-lg-6\">
										<select name=idprodi class=form-control m-input>
											<option value=''>Semua</option>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
											echo "</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<div class=\"col-lg-6\">";
										$waktu = getdate( );
										echo "\r\n\t\t\t\t\t\t<select name=angkatan class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										$i = 1900;
										while ( $i <= $waktu[year] + 5 )
										{
											echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
											++$i;
										}

										echo "\r\n\t\t\t\t\t\t</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\"><input type=\"submit\" class=\"btn btn-brand\" name=\"aksi\" value='Update Kelas'></input></div>
								</div>
						</form>
					</div>
				</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->";	
?>
