<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekuser( "AGD" );
echo "<CENTER>\r\n<table width=100% ";
echo $tabellatar;
echo ">\r\n<tr\tvalign=top>\r\n<td >\r\n";
printman( $manupdatekupdate );
echo "<form name=form action=cetakkp4.php?pilihan=kupdate method=post target=_blank>\r\n<input type=hidden name=pilihan value=\"kupdate\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table ";
echo $tabelpengumuman;
echo " width=700>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=200>ID User</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=iduser class=teksbox value='";
echo $iduser;
echo "'>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t<br>Kosongkan isian ID User untuk mencetak form KP4 sekelompok Operator\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=200>Nama</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=namadicari class=teksbox value='";
echo $namadicari;
echo "'>\r\n\t\t\t<br>Kosongkan isian Nama untuk menampilkan seluruh data atau isi untuk \r\n\t\t\tmenampilkan seluruh Operator dengan nama yang mengandung kata yang dimasukkan\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Jabatan Struktural</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=jabatan>\r\n\t\t\t\t<option value='semua'>Semua Jabatan</option>\r\n\t\t\t";
foreach ( $arrayjabatan as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Jabatan Fungsional</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=jabatan2>\r\n\t\t\t\t<option value='semua'>Semua Jabatan</option>\r\n\t\t\t";
foreach ( $arrayjabatans as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Golongan Ruang</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=gol>\r\n\t\t\t\t<option value='semua' >Semua Gol</option>\r\n\t\t\t";
foreach ( $arraygolongan as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=subgol>\r\n\t\t\t\t<option value='semua' >Semua Sub. Gol</option>\r\n\t\t\t";
foreach ( $arraysubgolongan as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Bidang</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=bidang>\r\n\t\t\t\t<option value=semua >Semua Bidang</option>\r\n\t\t\t";
foreach ( $bidanguser as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status Operator</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=statuspegawai>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
foreach ( $arraystatuspegawai as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status PNS</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=statuspegawai2>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
foreach ( $arraystatuspegawai2 as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status Kerja</td>\r\n\t\t<td>\r\n\t\t\t";
echo "<s";
echo "elect class=teksbox name=statuskerja>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
foreach ( $arraystatuskerja as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tLokasi Kerja</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
echo "<s";
echo "elect class=teksbox name=lokasi>\r\n\t\t\t<option value=semua >Semua Lokasi</option>\r\n\t\t\t";
foreach ( $arraylokasi as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tLokasi Gaji</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
echo "<s";
echo "elect class=teksbox name=lokasigaji>\r\n\t\t\t<option value=semua >Semua Lokasi</option>\r\n\t\t\t";
foreach ( $arraylokasi as $k => $v )
{
    echo "<option {$cek} value={$k} >{$v}</option>";
}
echo "\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td colspan=2><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n</CENTER>\r\n\r\n";
?>
