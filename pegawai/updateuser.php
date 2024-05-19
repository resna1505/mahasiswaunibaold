<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksitambahan == "Hapus" )
{
    $i = 0;
    if ( is_array( $hapususer ) )
    {
        foreach ( $hapususer as $v )
        {
            $query = "DELETE FROM presensi WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM kegiatan WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM penugas WHERE ID='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM pesan WHERE KE='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM shiftbebas WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM gaji WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM salinangaji WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM pendapatanb WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "SELECT ID FROM pengeluaranb WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            $h = mysqli_query($koneksi,$query);
            if(0 < sqlnumrows( $h )){
				while ($dt = @sqlfetcharray( @$h ) )
				{
					$query = "DELETE FROM detilpengeluaranb WHERE IDP='{$dt['ID']}'";
					mysqli_query($koneksi,$query);
				}
			}
            $query = "DELETE FROM pengeluaranb WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM penugasan WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM naikpangkat WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM belajar WHERE IDUSER='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM ruangdiskusi WHERE PENGIRIM='{$v}'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM topikdiskusi WHERE PENGIRIM='{$v}'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM undangandiskusi WHERE UNDANGAN='{$v}'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM pesertadiskusi WHERE IDUSER='{$v}'";
            mysqli_query($koneksi,$query);
            $query = "DELETE FROM user WHERE ID='{$v}' AND ID!='superadmin'";
           mysqli_query($koneksi,$query);
            $i += sqlaffectedrows( $koneksi );
            @removedir( @"../file/p/{$v}" );
        }
        if ( $i == 0 )
        {
            $errmesg = "Tidak ada data Operator yang dihapus";
        }
        else
        {
            $errmesg = "{$i} data Operator telah dihapus";
        }
    }
    else
    {
        $errmesg = "Tidak ada data Operator yang dihapus";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "tampilkan" )
{
    include( "prosestampiluser.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cari Data Operator" );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Cari Data Operator");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";  
    echo "					<form action=index.php?pilihan=lihat method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value=\"lihat\">
							<input type=hidden name=aksi value=\"tampilkan\">
							<input type=hidden name=sort value=\"ID\">";
   # echo "<table   class=\"table table-striped table-bordered table-hover\">\r\n\r\n\r\n";
	echo "						<div class=\"m-portlet__body\">";
    include( "filteruser.php" );
    echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input class=\"btn btn-brand\" type=submit value='Cari'>
											<input class=\"btn btn-secondary\" type=reset value=Reset>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
}
?>
