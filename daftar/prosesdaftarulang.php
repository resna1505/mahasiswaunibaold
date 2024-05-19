<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
					if($idpilihan!=""){
					
						$qfilter = "AND PILIHAN='{$idpilihan}'";
					
					}elseif($prodilulus!=""){
					
						$qfilter = "AND PRODI1='{$prodilulus}'";
					
					}elseif($prodilulus!="" && $idpilihan!=""){
						
						$qfilter = "AND PRODI1='{$prodilulus}' AND PILIHAN='{$idpilihan}'";
					
					}else{
					
						$qfilter = "";
					
					}
					#echo "kk";
#$q = "SELECT \r\n\tcalonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR \r\n\tFROM calonmahasiswa  WHERE \r\n\tcalonmahasiswa.ID='{$id}'\r\n\tAND  TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' AND\r\n\tPILIHAN='{$idpilihan}' AND LULUS !='' AND LULUS!=-1\r\n\t";
$q = "SELECT \r\n\tcalonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR \r\n\tFROM calonmahasiswa  WHERE \r\n\tcalonmahasiswa.ID='{$id}'\r\n\tAND  TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' {$qfilter} AND LULUS !='' AND LULUS!=-1\r\n\t";
#echo $q;exit();
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printjudulmenu( "Registrasi Mahasiswa Baru  - Satu Per Satu" );
    printmesg( $errmesg );
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TANGGALLAHIR] );
    $d[thn] = $tmp[0];
    $d[tgl] = $tmp[2];
    $d[bln] = $tmp[1];
    $tmp = explode( "-", $d[TANGGALIJAZAH] );
    $tglijazah[thn] = $tmp[0];
    $tglijazah[tgl] = $tmp[2];
    $tglijazah[bln] = $tmp[1];
    if ( $d[NOTES] == "" )
    {
        $tmp = explode( "/", $arraypilihanpmb2[$idpilihan] );
        $notes = "";
        foreach ( $tmp as $k => $v )
        {
            if ( trim( $v ) == "TAHUN" )
            {
                $notes .= $tahuna;
            }
            else if ( trim( $v ) == "GEL" )
            {
                $notes .= $gelombang;
            }
            else if ( trim( $v ) == "PIL" )
            {
                $notes .= $idpilihan;
            }
            else if ( trim( $v ) == "URUT" )
            {
                $notes .= $id;
            }
        }
        $d[NOTES] = $notes;
    }
    $fotosaatini = "";
    echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "id", "{$id}", "" ).createinputhidden( "gelombang", "{$gelombang}", "" ).createinputhidden( "tahunmasuk", "{$tahunmasuk}", "" ).createinputhidden( "idpilihan", "{$idpilihan}", "" ).createinputhidden( "aksi", "{$aksi}", "" )." \r\n\r\n    <tr class=judulform>\r\n\t\t\t<td width=250> Tahun Masuk</td>\r\n\t\t\t<td><b>{$tahunmasuk}</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang</td> \r\n\t\t\t<td><b>{$gelombang}</td>\r\n\t\t</tr> \r\n<tr class=judulform>\r\n\t\t\t<td>Pilihan</td>\r\n\t\t\t<td><b>".$arraypilihanpmb[$idpilihan]."</td>\r\n\t\t</tr>\r\n        <tr class=judulform>\r\n\t\t\t<td>ID/No. Tes</td> \r\n\t\t\t<td><b>{$id}</td>\r\n\t\t</tr> \r\n     <tr class=judulform>\r\n\t\t\t<td>Lulus ke Program Studi</td>\r\n\t\t\t<td><b>".$arrayprodidep[$d[LULUS]]."</td>\r\n\t\t</tr> \r\n \r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Nama Calon Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t</tr>\r\n     <tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."</td>\r\n\t\t</tr>  \r\n    <tr {$kelas}>\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td> {$d['TEMPATLAHIR']}  / {$d['tgl']}-{$d['bln']}-{$d['thn']}</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t</tr>\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td colspan=2><b>Data Isian Untuk Mahasiswa Baru</td>\r\n\t\t</tr>   \t\t\t\r\n";
    $q = "SELECT IDNIM FROM prodi WHERE ID='{$d['LULUS']}'";
    $hx = doquery($koneksi,$q);
    $dx = sqlfetcharray( $hx );
    $idnim = $dx[IDNIM];
    $kodetahun = substr( $tahunmasuk, 2, 2 );
    $q = "SELECT MAX(ID) AS MAXID FROM mahasiswa WHERE ANGKATAN='{$tahunmasuk}' AND IDPRODI='{$d['LULUS']}'";
    $hx = doquery($koneksi,$q);
    $dx = sqlfetcharray( $hx );
    $nimterakhir = $dx[MAXID];
    $nimterakhir = addnol( substr( $nimterakhir, strlen( $nimterakhir ) - 3, 3 ) + 1, 3 );
    $nimbaru = $idnim.$kodetahun.$nimterakhir;
    echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td><input type=text size=20 name=nim value='{$nimbaru}'></td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas Default Pengambilan Mata Kuliah</td>\r\n\t\t\t<td>  ".createinputselect( "kelas", $arraylabelkelas, $d[KELAS], "", "" )."\r\n        \r\n      \r\n      </td>\r\n\t\t</tr> ";
    if ( $STEIINDONESIA == 1 || $JENISKELAS == 1 )
    {
        echo "\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Jenis Kelas Default </td>\r\n\t\t\t<td>\r\n        <select name='jeniskelas' >\r\n      ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n      </select>\r\n      \r\n      </td>\r\n\t\t</tr>\r\n    ";
    }
    echo " \r\n \t\t<tr >\r\n\t\t\t<td>Tanggal Masuk</td>\r\n\t\t\t<td>".createinputtanggal( "dtm", $dtm, " class=masukan" )."</td>\r\n\t\t</tr>\r\n<tr>\r\n  <td>Semester Awal Terdaftar Sebagai Mahasiswa</td>\r\n  <td>\r\n";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 20 )
    {
        if ( $i == $tahunmasuk )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n  \r\n   </td>\r\n</tr>\r\n<tr>\r\n  <td>Batas Studi</td>\r\n  <td>\r\n";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 20 )
    {
        if ( $i == $tahunmasuk + 6 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n   \r\n  \r\n   </td>\r\n</tr>\r\n \r\n<tr>\r\n  <td>Kode Propinsi Asal Pendidikan Terakhir</td>\r\n  <td><input type=text size=2 name=kodeprop value='{$d2['ASSMAMSMHS']}'>\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprop('form,wewenang,kodeprop',\r\n\t\t\tdocument.form.kodeprop.value)\" >\r\n\t\t\tdaftar Propinsi/Negara\r\n\t\t\t</a>     \r\n  </td>\r\n</tr>\r\n\r\n    <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Proses' name=aksi2 class=masukan onClick=\"return confirm('Proses Data Mahasiswa Baru?')\">\r\n \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
}
else
{
    $errmesg = "Data Calon Mahasiswa Lulus dengan ID = '{$id}' tidak ada";
    $id = "";
    $aksi = "Lanjutkan";
}
?>
