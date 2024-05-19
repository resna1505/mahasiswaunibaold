<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Operator Bank", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM operatorbank WHERE ID='{$idhapus}'";
        mysqli_query($koneksi,$q);
        $ketlog = "Hapus data operator bank dengan ID='{$idhapus}'";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Operator Bank dengan ID = {$idhapus} berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Operator Bank dengan ID = '{$idhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Operator Bank harus diisi";
        }
        else
        {
            $valdata[] = cekvaliditasnama( "Nama", $data[nama], 64, false );
            $valdata[] = cekvaliditaskode( "Status", $data[status], 2 );
            $valdata[] = cekvaliditasnama( "Nama Bank", $data[namabank], 64, false );
            $valdata = array_filter( $valdata, "filter_not_empty" );
            if ( isset( $valdata ) && 0 < count( $valdata ) )
            {
                $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
                unset( $valdata );
            }
            else
            {
                $qlogout = "";
                if ( $iflogout == 1 )
                {
                    $qlogout = ", STATUSLOGIN=0 ";
                }
                if ( trim( $data[password] ) != "" )
                {
                    $qpwd = "PASSWORD=MD5('{$data['password']}'),";
                }
                $q = "\r\n\t\t\t\tUPDATE operatorbank SET \r\n\t \t\t\tNAMA='{$data['nama']}', \r\n\t\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t\t{$qpwd}\r\n\t\t\t\tSTATUS='{$data['status']}',\r\n\t\t\t\tNAMABANK='{$data['namabank']}',\r\n \t\t\t\tCABANG='{$data['cabang']}',\r\n\t\t\t\tTELEPON='{$data['telepon']}',\r\n\t\t\t\tKET='{$data['ket']}' \r\n\t\t\t      {$qlogout}\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
                mysqli_query($koneksi,$q);
                $ketlog = "Update data operator bank dengan ID={$idupdate} dan Nama={$data['nama']}";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "";
                    $errmesg .= "Data Operator Bank berhasil diupdate <br>";
                    $data = "";
                }
                else
                {
                    $errmesg .= "Data Operator Bank tidak diupdate <br>";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Operator Bank", SIMPAN_DATA );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Update Data Operator Bank" );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM operatorbank WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "idupdate", $idupdate, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" )." <tr class=judulform>\r\n\t\t\t<td>ID Operator Bank *</td>\r\n\t\t\t<td> {$idupdate}\r\n      </td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password *</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=masukan  size=20" )."Maksimal 16 karakter"."\r\n      [<a target=_blank href='../passwordacak.php'>buat password acak</a>]<br>\r\n      (Password tidak akan diubah jika tidak diisi)\r\n      </td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Operator Bank *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $d[NAMA], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Bank </td>\r\n\t\t\t<td>".createinputtext( "data[namabank]", $d[NAMABANK], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Cabang</td>\r\n\t\t\t<td>".createinputtext( "data[cabang]", $d[CABANG], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", $d[ALAMAT] ), " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Telepon</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $d[TELEPON], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", str_replace( "\\r\\n", "\n", $d[KET] ), " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n \t\t\r\n \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Operator Bank</td>\r\n\t\t\t<td>".createinputselect( "data[status]", $arraystatusoperatorbank, $d[STATUS], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr> \r\n\t \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $valdata[] = cekvaliditaskode( "ID", $id, 32, false );
        $valdata[] = cekvaliditasnama( "Nama", $data[nama], 64, false );
        $valdata[] = cekvaliditaskode( "Status", $data[status], 2 );
        $valdata[] = cekvaliditasnama( "Nama Bank", $data[namabank], 64, false );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
            unset( $valdata );
        }
        else
        {
            if ( trim( $data[password] ) == "" )
            {
                $data[password] = "{$id}";
            }
            $q = "\r\n\t\t\t\tINSERT INTO operatorbank (ID,NAMA,ALAMAT,STATUS, PASSWORD,CSS,\r\n\t\t\t\tNAMABANK,CABANG,TELEPON,KET) \r\n\t\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['alamat']}','{$data['status']}' ,\r\n\t\t\t\tMD5('{$data['password']}'),'style.inc',\r\n\t\t\t\t'{$data['namabank']}','{$data['cabang']}','{$data['telepon']}','{$data['ket']}' )\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Tambah data operator bank dengan ID={$id} dan Nama={$data['nama']}";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Operator Bank berhasil ditambah";
                $data = "";
                $id = "";
                $semester2 = $semesterawal = $ktp = $gelar = $jabatan = $pendidikan = $instansidosen = "";
            }
            else
            {
                $errmesg = "Data Operator Bank tidak berhasil ditambah. \r\n      <br>ID Operator Bank sudah ada di basisdata, silakan gunakan ID yg lain.";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Operator Bank", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Data Operator Bank", "bantuan" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )." <tr class=judulform>\r\n\t\t\t<td>ID Operator Bank *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 maxlength=10" )."\r\n        \r\n      </td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password *</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=masukan  size=20" )."Maksimal 16 karakter"."\r\n      [<a target=_blank href='../passwordacak.php'>buat password acak</a>]\r\n      </td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Operator Bank *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Bank </td>\r\n\t\t\t<td>".createinputtext( "data[namabank]", $data[namabank], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Cabang</td>\r\n\t\t\t<td>".createinputtext( "data[cabang]", $data[cabang], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", $data[alamat] ), " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Telepon</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $data[telepon], " class=masukan  size=50" )."  </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", str_replace( "\\r\\n", "\n", $data[ket] ), " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n \t\t\r\n \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Operator Bank</td>\r\n\t\t\t<td>".createinputselect( "data[status]", $arraystatusoperatorbank, $data[status], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr> \r\n\t \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampiloperatorbank.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Data Operator Bank ", "bantuan" );
    printhelp( trim( $arrayhelp[caridosen] ), "bantuan" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table><tr><td>\r\n    <table  >\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>ID Operator Bank</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.iddepartemen.value);\" " )."\r\n \t\t\t</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Operator</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Bank</td>\r\n\t\t\t<td>".createinputtext( "namabank", $namabank, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusoperatorbank as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n      </table> \r\n      <table>\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
