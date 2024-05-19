<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

@cekuser( "AD" );
if ( $aksitambahan == "Update Shift" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        foreach ( $idupdate as $k => $v )
        {
            $query = "UPDATE user SET SHIFT={$shiftuser[$k]} WHERE ID='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $i += sqlaffectedrows( $koneksi );
        }
        if ( $i <= 0 )
        {
            $errmesg = "Tidak ada data shift kehadiran Operator yang diupdate";
        }
        else
        {
            $errmesg = angkatoteks( $i )." ( {$i} ) data shift Operator telah diupdate";
        }
    }
    else
    {
        $errmesg = "Tidak ada data shift kehadiran Operator yang diupdate";
    }
    $aksi = "tampilkan";
}
if ( $err == "idkosong" )
{
    $errmesg = "ID User harus diisi";
}
else if ( $err == "idadmin" )
{
    $errmesg = "ID User = superadmin tidak bisa diupdate";
}
else if ( $err == "nouser" )
{
    $errmesg = "Tidak ada user dengan ID = {$iduser}";
}
else if ( $err == "updateok" )
{
    $errmesg = "Data user dengan ID = {$iduser} telah terupdate";
}
if ( $aksi == "tampilkan" )
{
    if ( $tingkats == "A" )
    {
        $menulihat = "\t\t\t<table width=100%>\r\n\t\t\t\t<tr>\r\n\r\n\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t<input class=tombol type=submit value='Update Shift' name=aksitambahan>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>";
    }
    buatlog( 15, $admin );
    printmesg( $errmesg );
    $namadicari2 = trim( $namadicari );
    if ( $namadicari2 !== "" )
    {
        $qnama = " AND NAMA LIKE '%{$namadicari2}%'";
        $namadicari2 = htmlspecialchars( $namadicari2 );
        $jnama = ". Nama mengandung kata '{$namadicari2}'";
    }
    if ( $sort == "" )
    {
        $sort = "NAMA";
        $qsort = "ORDER BY {$sort}";
    }
    else
    {
        $qsort = "ORDER BY {$sort},NAMA";
    }
    if ( $bidang != "semua" )
    {
        $qbidang = " AND BIDANG = {$bidang} ";
        $jbidang = ". Bidang: ".$bidanguser[$bidang]."";
    }
    if ( $shift != "semua" )
    {
        $qshift = " AND SHIFT = {$shift} ";
        $jshift = ". Shift: ".$arrayshift[$shift]."";
    }
    if ( $lokasi != "semua" )
    {
        $qlokasi = " AND LOKASI = {$lokasi} ";
        $jlokasi = ". Lokasi: ".$arraylokasi[$lokasi]."";
    }
    if ( $statuspegawai != "semua" )
    {
        $qstatuspegawai = " AND STATUSPEGAWAI = {$statuspegawai} ";
        $jstatuspegawai = ". Status: ".$arraystatuspegawai[$statuspegawai]."";
    }
    $query = "SELECT ID, NAMA,BIDANG,LOKASI,STATUSPEGAWAI,SHIFT\r\n\t\tFROM user WHERE ID!='superadmin' \r\n\t\t{$qbidang} {$qlokasi} {$qstatuspegawai} {$qshift} {$qstatusl}\r\n\t\t{$qnama} \r\n\t\t{$qsort} ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        $i = 1;
        settype( $i, "integer" );
        $href = "index.php?pilihan=shift&aksi=tampilkan&bidang={$bidang}&statuspegawai={$statuspegawai}&lokasi={$lokasi}&namadicari={$namadicari2}&shift={$shift}&statuslogin={$statuslogin}&";
        printmesg( "Data Operator".$jnama.$jbidang.$jstatuspegawai.$jlokasi.$jshift.$jstatusl );
        echo "<CENTER>\r\n<table width=100% {$tabellatar}>\r\n<tr\tvalign=top>\r\n<td align=center>\t\r\n\t\t<form action=index.php?pilihan=shift&aksi=tampilkan method=post>\r\n\t\t<input type=hidden name=sort value='{$sort}'>\r\n\t\t<input type=hidden name=namadicari value='{$namadicari}'>\r\n\t\t<input type=hidden name=bidang value='{$bidang}'>\r\n\t\t<input type=hidden name=lokasi value='{$lokasi}'>\r\n\t\t<input type=hidden name=shift value={$shift}>\r\n\t\t<input type=hidden name=statuspegawai value='{$statuspegawai}'>\r\n\t\t\t{$menulihat}\t\r\n\t\t\t<table width=100%  {$tabelisian}\t>\r\n\t\t\t<tr class=judulkolom>\r\n\t\t\t\t<td align=center>No</td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=ID"."'>ID</a></td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=NAMA"."'>Nama</a></td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=BIDANG"."'>Bidang</a></td>\t\t\t\t\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=STATUSPEGAWAI"."'>Status</a></td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=LOKASI"."'>Lokasi</a></td>\r\n\t\t\t\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=SHIFT"."'>Shift Kehadiran</a></td>\r\n\t\t\t\t\r\n\r\n\t\t\t</tr>";
        while ( $data = sqlfetcharray( $hasil ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "class=datagenap";
            }
            else
            {
                $kelas = "class=dataganjil";
            }
            echo "\r\n\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t<td align=center>{$i}\r\n\t\t\t\t\t\t<input type=hidden name=idupdate[{$i}] value='{$data['ID']}'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=center>".printid( $data[ID] )."</td>\r\n\t\t\t\t\t<td >{$data['NAMA']}</td>\r\n\t\t\t\t\t<td align=center>".$bidanguser[$data[BIDANG]]."</td>\r\n\t\t\t\t\t<td align=center>".$arraystatuspegawai[$data[STATUSPEGAWAI]]."</td>\r\n\t\t\t\t\t<td align=center>".$arraylokasi[$data[LOKASI]]."</td>\r\n\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t<select class=teksbox name=shiftuser[{$i}]>";
            foreach ( $arrayshift as $k => $v )
            {
                if ( $k == $data[SHIFT] )
                {
                    $cek = "selected";
                }
                echo "<option {$cek} value={$k} >{$v}</option>";
                $cek = "";
            }
            echo "\r\n\t\t\t\t</select>\r\n\t\t\t\t\t\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>";
            ++$i;
        }
        echo "</table>{$menulihat}\r\n\t\t</td>\r\n</tr>\r\n</table>\r\n\t\t";
    }
    else
    {
        printmesg( "Data Operator tidak ada" );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    echo "<CENTER>\r\n<table width=100% ";
    echo $tabellatar;
    echo ">\r\n<tr\tvalign=top>\r\n<td >\r\n";
    printman( $manupdateshift );
    echo "<form action=index.php?pilihan=shift method=post>\r\n<input type=hidden name=pilihan value=\"shift\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table ";
    echo $tabelpengumuman;
    echo " width=600>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=100>Nama</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=namadicari class=teksbox value='";
    echo $namadicari;
    echo "'>\r\n\t\t\t<br>Kosongkan isian Nama untuk menampilkan seluruh data atau isi untuk \r\n\t\t\tmenampilkan seluruh Operator dengan nama yang mengandung kata yang dimasukkan\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Bidang</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=bidang>\r\n\t\t\t\t<option value=semua >Semua Bidang</option>\r\n\t\t\t";
    foreach ( $bidanguser as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=statuspegawai>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
    foreach ( $arraystatuspegawai as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tLokasi</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
    echo "<s";
    echo "elect class=teksbox name=lokasi>\r\n\t\t\t<option value=semua >Semua Lokasi</option>\r\n\t\t\t";
    foreach ( $arraylokasi as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tShift Kehadiran</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
    echo "<s";
    echo "elect class=teksbox name=shift>\r\n\t\t\t<option value=semua >Semua Shift</option>\r\n\t\t\t";
    foreach ( $arrayshift as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t</select>\r\n\t</td>\r\n\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td colspan=2><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n</CENTER>\r\n\r\n";
}
?>
