<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $STEIINDONESIA != 1 )
{
    exit( );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilsisadeposit.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Sisa Deposit Mahasiswa " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $jenisusers == 0 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNIDN Dosen Wali\r\n\t\t\t\t</td>\r\n\t\t\t\t<td> ".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\t\t\t\t\r\n \t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    else if ( $jenisusers == 1 )
    {
        echo "<input type=hidden name=iddosen value='{$users}'>";
    }
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmahasiswa as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
