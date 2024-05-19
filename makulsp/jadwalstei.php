<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampiljadwal.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Jadwal Mata Kuliah " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tSemester Tahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\r\n            <select name=semesterk class=masukan> \r\n\t\t\t\t\t\t ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t\t<select name=tahunk class=masukan> \r\n\t\t\t\t\t\t ";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $selected = "";
        if ( $i == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option {$selected} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan / Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kode MK</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahunk.value,form.semesterk.value);\"" )."\r\n\t\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n               <div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">\r\n               <div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\">\r\n\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama MK</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Semester Makul</td>\r\n\t\t\t<td>".createinputtext( "semester", $semester, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>SKS</td>\r\n\t\t\t<td>".createinputtext( "sks", $sks, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJenis\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayjenismakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
