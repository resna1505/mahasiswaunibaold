<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function createformtambah( $form, $data, $attr1, $attr2 )
{
	#echo "KJL";exit();
    $tmpform = createform( $form['nama'], $form['metod'], $form['action'], $form['attr'] );
    $tmp = "\r\n\t\t<table {$attr1}>\r\n\t";
    foreach ( $data as $k => $v )
    {
        $periksa = "";
        $bintang = "";
        if ( $v[periksa] == 1 )
        {
            $periksa = "1";
            $bintang = "*";
        }
        if ( $v[jenis] != hidden )
        {
            $tmp .= "\r\n\t\t\t\t<tr ".$v[tr][attr].">\r\n\t\t\t\t\t<td ".$v[td1][attr].">\r\n\t\t\t\t\t\t{$v['judul']} {$bintang}\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td ".$v[td2][attr].">\r\n\t\t\t";
        }
        if ( $v[jenis] == hidden )
        {
            $tmp .= createinputhidden( $v[nama], $v[value], $v[attr] );
        }
        else if ( $v[jenis] == text )
        {
            $tmp .= createinputtext( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
        }
        else if ( $v[jenis] == textarea )
        {
            $tmp .= createinputtextarea( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
        }
        else if ( $v[jenis] == password )
        {
            $tmp .= createinputpassword( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
        }
        else if ( $v[jenis] == cek )
        {
            $tmp .= createinputcek( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[ket], $v[cek], $v[attr] );
        }
        else if ( $v[jenis] == cekarray )
        {
            $tmp .= createinputcekarray( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[attr] );
        }
        else if ( $v[jenis] == radio )
        {
            $tmp .= createinputradio( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[ket], $v[cek], $v[attr] );
        }
        else if ( $v[jenis] == radioarray )
        {
            $tmp .= createinputradioarray( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[attr] );
        }
        else if ( $v[jenis] == select )
        {
            $tmp .= createinputselect( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[multiple], $v[attr] );
        }
        else if ( $v[jenis] == tanggal )
        {
            $tmp .= createinputtanggal( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
        }
        else if ( $v[jenis] == jam )
        {
            $tmp .= createinputjam( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$periksa}", $v[value], $v[detik], $v[attr] );
        }
        if ( $v[jenis] != hidden )
        {
            $tmp .= "\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        }
    }
    $tmp .= "\r\n\t\t<tr>\r\n\t\t\t<td colspan=2>\r\n\t\t\t\t<input type=submit value='Tambah' {$attr2}>\r\n\t\t\t\t<input type=reset value='Hapus'  {$attr2}>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>";
    return str_replace( "<--isi-->", $tmp, $tmpform );
}

function createformcari( $form, $data, $attr1, $attr2 )
{
	#echo "KJL";exit();
    $tmpform = createform( $form[nama], $form[metod], $form[action], $form[attr] );
    $tmp = "\r\n\t\t<table {$attr1}>\r\n\t";
    foreach ( $data as $k => $v )
    {
        $periksa = "";
        $bintang = "";
        if ( $v[periksa] == 1 )
        {
            $periksa = "1";
            $bintang = "*";
        }
        if ( $v[jenis] != hidden )
        {
            $tmp .= "\r\n\t\t\t\t<tr ".$v[tr][attr].">\r\n\t\t\t\t\t<td ".$v[td1][attr].">\r\n\t\t\t\t\t\t{$v['judul']} \r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td ".$v[td2][attr].">\r\n\t\t\t";
        }
        if ( $v[jenis] == hidden )
        {
            $tmp .= createinputhidden( $v[nama], $v[value], $v[attr] );
        }
        else
        {
            if ( $v[jenis] == text )
            {
                $tmp .= createinputtext( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
            }
            if ( $v[jenis] == textarea )
            {
                $tmp .= createinputtextarea( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
            }
            else if ( $v[jenis] == password )
            {
                $tmp .= createinputpassword( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
            }
            else if ( $v[jenis] == cek )
            {
                $tmp .= createinputcek( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[ket], $v[cek], $v[attr] );
            }
            else if ( $v[jenis] == cekarray )
            {
                $tmp .= createinputcekarray( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[attr] );
            }
            else if ( $v[jenis] == radio )
            {
                $tmp .= createinputradio( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[ket], $v[cek], $v[attr] );
            }
            else if ( $v[jenis] == radioarray )
            {
                $tmp .= createinputradioarray( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[attr] );
            }
            else if ( $v[jenis] == select )
            {
                $tmp .= createinputselect( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[key], $v[multiple], $v[attr] );
            }
            else if ( $v[jenis] == tanggal )
            {
                $tmp .= createinputtanggal( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$v['tipe']}_{$periksa}]", $v[value], $v[attr] );
            }
            else if ( $v[jenis] == jam )
            {
                $tmp .= createinputjam( "datahasil["."{$v['jenis']}"."_"."{$v['nama']}"."_".$k."_{$periksa}", $v[value], $v[detik], $v[attr] );
            }
        }
        if ( $v[jenis] != hidden )
        {
            $tmp .= "\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        }
    }
    $tmp .= "\r\n\t\t<tr>\r\n\t\t\t<td colspan=2>\r\n\t\t\t\t<input type=submit value='Cari' {$attr2}>\r\n\t\t\t\t<input type=reset value='Hapus'  {$attr2}>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>";
    return str_replace( "<--isi-->", $tmp, $tmpform );
}

include( "array.php" );
include( "initkop.php" );
$q = "SELECT EDITNILAIDOSEN FROM aturan ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$aturaneditnilaidosen = $d['EDITNILAIDOSEN'];
if ( $jenisusers == 1 )
{
    $qfieldx1 = " AND mahasiswa.IDDOSEN = '{$users}'";
    $qfieldx2 = " AND dosenpengajar.IDDOSEN = '{$users}'";
    $href .= "iddosen={$users}&";
}
else
{
    if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        $qfieldtambahan = " \r\n\tAND dosenpengajar.TAHUN=pengambilanmk.TAHUN\r\n\tAND dosenpengajar.SEMESTER=pengambilanmk.SEMESTER\r\n\tAND dosenpengajar.KELAS=pengambilanmk.KELAS\r\n\tAND dosenpengajar.IDMAKUL=pengambilanmk.IDMAKUL\r\n\t AND pengambilanmk.IDMAHASISWA = '{$users}'";
        $qfieldtambahan2 = " \r\n\t AND mahasiswa.ID = '{$users}'";
        $tabeltambahan = ",pengambilanmk";
        $href .= "idmahasiswa={$users}&";
    }
}
?>
