<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "Kode Mata Kuliah harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Mata Kuliah harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tUPDATE makul SET \r\n \t\t\tNAMA='{$data['nama']}',\r\n\t\t\tID='{$id}',\r\n\t\t\tKET='{$data['ket']}',\r\n\t\t\tSKS='{$data['sks']}',\r\n\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\tJENIS='{$data['jenis']}',\r\n\t\t\tKELOMPOK='{$data['kelompok']}',\r\n \t\t\tIDPRODI='{$idprodi}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
        mysqli_query($koneksi,$q);
        $ketlog = "Update Mata Kuliah dengan ID={$idupdate} ({$data['nama']})";
        mysqli_error($koneksi);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Mata Kuliah berhasil diupdate";
            if ( $idupdate != $id )
            {
                $q = "UPDATE tbkmksp SET KDKMKTBKMK='{$id}' WHERE KDKMKTBKMK='{$idupdate}'";
                mysqli_query($koneksi,$q);
                $q = "UPDATE dosenpengajarsp SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                mysqli_query($koneksi,$q);
                $q = "UPDATE pengambilanmksp SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                mysqli_query($koneksi,$q);
                $q = "UPDATE nilaisp SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                mysqli_query($koneksi,$q);
            }
            $idupdate = $id;
            buatlog( 19 );
        }
        else
        {
            $errmesg = "Data Mata Kuliah tidak diupdate";
        }
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM makul WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<br>\r\n\t\t<form name=form  action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan / Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, "{$d['IDPRODI']}", "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah *</td>\r\n\t\t\t<td>".createinputtext( "id", "{$d['ID']}", " class=masukan  size=20" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama Mata Kuliah *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", "{$d['NAMA']}", " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", "{$d['KET']}", " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputtext( "data[semester]", "{$d['SEMESTER']}", " class=masukan size=4" )."</td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>SKS</td>\r\n\t\t\t<td>".createinputtext( "data[sks]", "{$d['SKS']}", " class=masukan size=4" )."</td>\r\n\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJenis\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=data[jenis]>\r\n\t\t\t\t\t\t";
        foreach ( $arrayjenismakul as $k => $v )
        {
            $cek = "";
            if ( $k == $d[JENIS] )
            {
                $cek = "selected";
            }
            echo "<option {$cek} value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
        echo "\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mata Kuliah dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
