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
#printjudulmenu( "Data Komponen Nilai Default" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $nama[$k] ) != "" )
            {
                $query = "UPDATE komponendefault SET \r\n\t\t\t\t\t\tNAMA='".$nama[$k]."',\r\n\t\t\t\t\t\tPERSEN='".$persen[$k]."',\r\n\t\t\t\t\t\tUPDATER='{$users}',\r\n\t\t\t\t\t\tTANGGALUPDATE=NOW()\r\n\t\t\t\t\t\tWHERE ID='{$k}'";
                $hasil =mysqli_query($koneksi,$query);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Komponen Nilai Default berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Komponen Nilai Default tidak berhasil dilakukan.";
        }
    }
}
if ( $aksi == "Hapus" && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM komponendefault  WHERE ID='{$k}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data Komponen Nilai Default    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data Komponen Nilai Default    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" )
{
    if ( trim( $nama ) == "" )
    {
        $errmesg = "Data Komponen Default harus diisi";
    }
    else
    {
        if ( $id == "" )
        {
            $id = 0;
        }
        $query = "INSERT INTO komponendefault (ID,NAMA,PERSEN,UPDATER,TANGGALUPDATE) VALUES('{$id}','{$nama}','{$persen}','{$users}',NOW() )";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Komponen Nilai Default      berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data Komponen Nilai Default      gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
#printjudulmenukecil( "Tambah Data Komponen Default" );
echo "
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Tambah Data Komponen Default");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";

echo "									<form action=index.php?pilihan=ltambah method=post>
											<input type=hidden name=aksi value=\"Tambah\">
											<input type=hidden name=pilihan value=komponendefault>
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr class=judulform>\r\n\t\t\t<td class=judulform>Nama Komponen\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=form-control m-input type=text size=40  name=nama>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>
													<tr class=judulform>\r\n\t\t\t<td class=judulform>";
echo "												Persentase\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=form-control m-input type=text size=3  name=persen>%\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><br>\r\n\t\t\t\t\t\t\t\t<input class=\"btn btn-brand\" type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=\"btn btn-secondary\" type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t
												</table>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
			<script>form.nama.focus();</script>";
$query = "SELECT ID,NAMA,PERSEN FROM komponendefault ORDER BY PERSEN DESC,NAMA";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    #printjudulmenukecil( "Daftar  Komponen Default" );
	echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t\t";
    echo "<div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Daftar Komponen Default");
								echo	"</div>
									</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>
															<th scope=col colspan=3>&nbsp;</th>
															<th scope=col><input type=submit name=aksi value='Update' class=\"btn btn-brand\"></th>
															<th scope=col><input type=submit name=aksi value='Hapus' class=\"btn btn-secondary\" onclick=\"return confirm('Hapus Komponen Nilai Default ?');\">\r\n\t\t\t\t\t\t\t</th>
														</tr>
														<tr align=center class=juduldata>
															<th scope=col>No</th>
															<th scope=col>Nama Komponen</th>
															<th scope=col>Persentase (%)</th>
															<th scope=col width=50>\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</th>
															<th scope=col width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</th>
														</tr>
														</thead>
														<tbody>";
    $i = 0;
    settype( $i, "integer" );
    $totalpersen = 0;
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap";
        }
        else
        {
            $kelas = "class=dataganjil";
        }
        $nama = $datauser[NAMA];
        $komponendefault = $datauser[ID];
        $persen = $datauser[PERSEN];
        $totalpersen += $persen;
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<th scope=col align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</th>\r\n\t\t\t\t\t\t\t<th scope=col align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=nama[{$komponendefault}] value='{$nama}' size=40  class=form-control m-input>\r\n\t\t\t\t\t\t\t</th>\r\n\t\t\t\t\t\t\t<th scope=col align=center >\r\n\t\t\t\t\t\t\t\t<input type=text name=persen[{$komponendefault}] value='{$persen}' size=3  class=form-control m-input>\r\n\t\t\t\t\t\t\t</th>\r\n\r\n\r\n\t\t\t\t\t\t\t<th scope=col align=center >\r\n\t\t\t\t\t\t\t\t<input type=checkbox name=idupdate[{$komponendefault}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</th>\r\n\r\n\t\t\t\t\t\t\t<th scope=col align=center >\r\n\t\t\t\t\t\t\t\t\t<input type=checkbox name=idhapus[{$komponendefault}] value=1 class=tombol >\r\n\t\t\t\t\t\t\t</th>\r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<th scope=col align=right colspan=2>\r\n\t\t\t\t\t\t\t <b>Total\r\n \t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<th scope=col align=center >\r\n\t\t\t\t\t\t\t\t<b>{$totalpersen}\r\n\t\t\t\t\t\t\t</th>\r\n\r\n\r\n \r\n\t\r\n\t\t\t\t\t\t</tr>";
	 echo "									</tbody>	
										</table>
									</div>
								</div>
							</div>
							<!---- end m-portlet--->
						</div>
					</div>
				</div>
			</div>		
		</form>
		";
}
else
{
    printmesg( "Daftar Komponen Nilai Default tidak ada." );
    $aksi = "";
}
echo "<br>\r\n";
?>
