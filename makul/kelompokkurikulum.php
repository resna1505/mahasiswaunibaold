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
#printjudulmenu( "Data Kelompok Kurikulum" );
$ok = false;
if ( $aksi == "Update" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        $i = 0;
        foreach ( $idupdate as $k => $v )
        {
            if ( trim( $ket[$k] ) != "" )
            {
                $query = "UPDATE kelompokkurikulum SET \r\n\t\t\t\t\tNAMA='".$ket[$k]."'\r\n\t\t\t\t\tWHERE ID='{$k}'";
                $hasil =mysqli_query($koneksi,$query);
                echo mysqli_error($koneksi);
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Update data Kelompok Kurikulum berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Update data Kelompok Kurikulum tidak berhasil dilakukan.";
        }
    }
}
if ( $aksi == "Hapus" && is_array( $idhapus ) )
{
    $i = 0;
    foreach ( $idhapus as $k => $v )
    {
        $query = "DELETE FROM kelompokkurikulum  WHERE ID='{$k}'";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            ++$i;
        }
    }
    if ( 0 < $i )
    {
        $errmesg = "Penghapusan data Kelompok Kurikulum    berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data Kelompok Kurikulum    tidak dilakukan.";
    }
}
if ( $aksi == "Tambah" )
{
    if ( trim( $id ) == "" )
    {
        $errmesg = "ID kelompok harus diisi";
    }
    else if ( trim( $ket ) == "" )
    {
        $errmesg = "Nama kelompok harus diisi";
    }
    else
    {
        $query = "INSERT INTO kelompokkurikulum VALUES('{$id}','{$ket}' )";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penambahan data Kelompok Kurikulum      berhasil dilakukan.";
        }
        else
        {
            $errmesg = "Penambahan data Kelompok Kurikulum      gagal dilakukan.";
        }
    }
    $aksi = "";
}
printmesg( $errmesg );
#printjudulmenukecil( "Tambah Data Kelompok Kurikulum" );
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
                                <span class=\"caption-subject bold uppercase\"> Tambah Data Kelompok Kurikulum </span>
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
                    ";
						printmesg( $errmesg );
echo "			<div class='portlet-title'>";
					printmesg("Tambah Data Kelompok Kurikulum");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->";
				echo "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php?pilihan=kelompokkurikulum method=post>
						<input type=hidden name=aksi value=\"Tambah\">
						<input type=hidden name=pilihan value=kelompokkurikulum>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">ID kelompok </label>\r\n    
								<div class=\"col-lg-6\"><input class=form-control m-input type=text size=20  name=id class=form-control m-input>  </div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama kelompok</label>\r\n    
								<div class=\"col-lg-6\"><input class=form-control m-input type=text size=30 name=ket ></div>
							</div>
							<div class=\"form-group m-form__group row\">
								<div class=\"col-lg-6\">
									<input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
									<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
						</form>
			</div>
			<!--end::Portlet-->			
		</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->
</div>";
$query = "SELECT ID,NAMA FROM kelompokkurikulum WHERE ID!='N' ORDER BY ID";
$hasil =mysqli_query($koneksi,$query);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hasil ) )
{
    #printjudulmenukecil( "Daftar  Kelompok Kurikulum" );
    /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Daftar  Kelompok Kurikulum </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
	echo "
										<div class='caption'>";
											printmesg("Daftar  Kelompok Kurikulum");
								echo	"</div>";
                        
    echo "\r\n\t\t\t\t\t\t\t<form action=index.php method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=kelompokkurikulum>\r\n\t\t\t\t";
    #echo "\r\n\t\t\t\t\t<table class=data>\r\n\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t<td colspan=3>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus Kelompok Kurikulum ?');\">\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>";

    echo "<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
                                <thead align=\"center\">
                                    <tr align=\"center\">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><input type=submit name=aksi value='Update' class=\"btn btn-brand\"></th>
                                        <th><input type=submit name=aksi value='Hapus' class=\"btn btn-secondary\" onclick=\"return confirm('Hapus Kelompok Kurikulum ?');\"></th>
                                <thead align=\"center\">
                                    <tr align=\"center\">
                                        <th scope=\"col\">No</th>
                                        <th scope=\"col\">ID</th>
                                        <th scope=\"col\">Nama</th>
                                        <th scope=\"col\">Pilih<BR>Update</th>
                                        <th scope=\"col\">Pilih<BR>Hapus</th>";

    #echo "\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tID\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama  \r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Update\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=50 >\r\n\t\t\t\t\t\t\t\tPilih<BR>Hapus\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    echo "			</tr> 
				</thead>
					<tbody>";
	$i = 0;
    settype( $i, "integer" );
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
        $ket = $datauser[NAMA];
        $kelompokkurikulum = $datauser[ID];
        $gol = $datauser[GOL];
        $subgol = $datauser[SUBGOL];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$kelompokkurikulum}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t";
        if ( $kelompokkurikulum == "" )
        {
            echo "\r\n  \t\t\t\t\t\t\t <td align=center >\t\r\n  \t\t\t\t\t\t\t {$ket}\r\n  \t\t\t\t\t\t\t</td>\r\n  \r\n  \r\n  \t\t\t\t\t\t\t<td align=center >\r\n  \t\t\t\t\t\t\t -\r\n   \t\t\t\t\t\t\t</td>\r\n  \r\n  \t\t\t\t\t\t\t<td align=center >\r\n  \t\t\t\t\t\t\t -\r\n   \t\t\t\t\t\t\t</td>";
        }
        else
        {
            echo "\r\n                  <td align=center >\r\n    \t\t\t\t\t\t\t\t<input type=text name='ket[{$kelompokkurikulum}]' value='{$ket}' size=50  class=masukan>\r\n    \t\t\t\t\t\t\t</td>\r\n    \r\n    \r\n    \t\t\t\t\t\t\t<td align=center >\r\n    \t\t\t\t\t\t\t\t<input type=checkbox name='idupdate[{$kelompokkurikulum}]' value=1 class=tombol >\r\n    \t\t\t\t\t\t\t</td>\r\n    \r\n    \t\t\t\t\t\t\t<td align=center >\r\n    \t\t\t\t\t\t\t\t\t<input type=checkbox name='idhapus[{$kelompokkurikulum}]' value=1 class=tombol >\r\n    \t\t\t\t\t\t\t</td>";
        }
        echo "\r\n\r\n\t\r\n\t\t\t\t\t\t</tr></thead>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t</form>\r\n\r\n\t\t\t\t";

    echo "</form>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
        </div>
    </div>";
}
else
{
    printmesg( "Daftar Kelompok Kurikulum tidak ada." );
    $aksi = "";
}
echo "<br>\r\n";
?>
