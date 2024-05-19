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
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "SELECT COUNT(*) AS JUMLAH FROM msdos WHERE NODOSMSDOS='{$idhapus}'";
        $h = doquery($koneksi,$q);
        $d = sqlfetcharray( $h );
        if ( 1 < $d[JUMLAH] + 0 )
        {
            $q = "DELETE FROM msdos WHERE NODOSMSDOS='{$idhapus}'AND KDJENMSDOS='{$jenjanghapus}' AND KDPSTMSDOS='{$kodepsthapus}'";
            doquery($koneksi,$q);
            $ketlog = "Hapus data MSDOS dosen ganda dengan ID='{$idhapus}'";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 11 );
                $errmesg = "Data MSDOS Dosen dengan ID = {$idhapus} berhasil dihapus";
            }
            else
            {
                $errmesg = "Data MSDOS  Dosen dengan ID = '{$idhapus}' tidak berhasil dihapus";
            }
        }
        else
        {
            $errmesg = "Data MSDOS  Dosen dengan ID = '{$idhapus}' sudah benar dan tidak boleh dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
	#echo "ll";exit();
    include( "prosestampildosenganda.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Periksa Data Dosen Ganda", "bantuan" );
    printhelp( trim( $arrayhelp[caridosen] ), "bantuan" );
    printmesg( $errmesg );

    //echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table><tr><td>\r\n    <table  >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=iddepartemen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";

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
											printmesg("Periksa Data Dosen Ganda");
								echo	"</div>
										
									</div>
									<div class='portlet-body form'>*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Periksa Data Dosen Ganda");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
                        <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=iddepartemen><option value=''>Semua</option>";
										foreach ( $arrayprodidep as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
										echo "
									</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIDN</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "id", $id, " class=form-control m-input  size=20" )."<a href=\"javascript:daftardosen('form,wewenang,id',document.form.id.value)\" >daftar dosen</a></div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Status</label>
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arraystatusdosen as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
		echo "						</select>
								</div>
							</div>";
    //foreach ( $arrayprodidep as $k => $v )
    //{
        //echo "<option value='{$k}'>{$v}</option>";
    //}
    //echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t";
    //echo "</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    //foreach ( $arraystatusdosen as $k => $v )
    //{
        //echo "<option value='{$k}'>{$v}</option>";
    //}
    //echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t";
    //echo "</td>\r\n\t\t\t</tr>\r\n      </table>\r\n      ";
    include( "../mahasiswa/cari2.php" );
    echo "\r\n      <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script></div></div></div></div></div></div></div>\r\n\t";
}
?>
