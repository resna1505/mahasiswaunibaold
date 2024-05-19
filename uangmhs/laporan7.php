<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan7.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "REKAP TUNGGAKAN PEMBAYARAN MAHASISWA" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n \t\t\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\"  " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $arrayangkatan = getarrayangkatan( );
    foreach ( $arrayangkatan as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=kelas>\r\n            <option value=''>Semua</option>\r\n            ";
    foreach ( $arraykelasmhs as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=idprodi>\r\n            <option value=''>Semua</option>\r\n            ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t</tr>\t\t\r\n        <!--\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Komponen Pembayaran</td>\r\n\t\t\t\t\t\t<td>";
    $i = 0;
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "<input  id=jeniskomponen{$i}  type=checkbox name='jeniskomponen[{$k}]' value=1 checked>{$v}<br>";
        ++$i;
    }
    echo "\r\n              [<a href='#' onClick='cekall();return false;'>pilih semua</a>] \r\n              [<a href='#' onClick='uncekall();return false;'>batal pilih semua</a>]\r\n              <input type=hidden name=count value='{$i}'>\r\n        \t\t\t<script>\r\n         \t\t\t\tvar count={$i};\r\n        \t\t\t\tfunction cekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=true;\r\n        \t\t\t\t\t\t \r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n        \t\t\t\tfunction uncekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=false;\r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n         \t\t\t</script>\r\n<br><br>\r\n<table>\r\n  <tr>\r\n  <td>\r\n\t\t\tTahun Akademik : </td><td>\r\n\t\t\t\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    $arrayangkatan = getarrayangkatan( "R" );
    foreach ( $arrayangkatan as $k => $v )
    {
        $selected = "";
        if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    ++$k;
    echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>\r\n\t\t\t\t\t\t\t";
    echo "\r\n\t\t\t\t\t\t\t\t\t</select> </td><td>( Khusus pilihan Per Tahun Akademik )\t\t\r\n\t\t\t</td>\r\n\t\t\t <tr>\r\n\t\t \r\n\t\t\t   <td>\r\n\t\t\tTahun Akademik dan Semester : </td><td>\r\n\t\t\t<select name=tahunbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    $arrayangkatan = getarrayangkatan( "R" );
    foreach ( $arrayangkatan as $k => $v )
    {
        $selected = "";
        if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    ++$k;
    echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>\r\n\t\t\t\t\t\t\t";
    echo "\r\n\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t\t<select name=semesterbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    foreach ( $arraysemester as $k => $v )
    {
        $cek = "";
        if ( $k == $d2[SEMESTER] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</select> </td><td> (Khusus pilihan Semester ) </td>\r\n\t\t\t<tr>\r\n\t\t\t<td>\r\n\tBulan/Tahun :</td><td> <select name=semesterbayar2 class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    foreach ( $arraybulan as $k => $v )
    {
        $cek = "";
        if ( $k == $d2[SEMESTER] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t<select name=tahunajaran2 class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    $ii = 1901;
    while ( $ii <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $ii == $d2[TAHUNAJARAN] )
        {
            $cek = "selected";
        }
        else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
        ++$ii;
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t</select> </td><td> (Khusus pilihan Per Bulan )\t\t</td>\r\n\r\n                      </tr></table>              \r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t  \t\r\n            \r\n            \r\n            \t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Operator Keuangan</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=operator>\r\n            <option value=''>Semua</option>\r\n            ";
    $arrayoperatorkeuangan = getoperatorkeuangan( );
    if ( is_array( $arrayoperatorkeuangan ) )
    {
        foreach ( $arrayoperatorkeuangan as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t</tr>\t\r\n\t\t\t\t\t-->\r\n \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
