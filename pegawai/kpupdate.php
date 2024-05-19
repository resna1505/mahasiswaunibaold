<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

@cekuser( "AD" );
if ( $aksitambahan == "Update Data" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        foreach ( $idupdate as $k => $v )
        {
            $f = fopen( "kp4/{$v}", "w" );
            echo $datak[$v][mtahun];
            if ( is_array( $datak[$v] ) )
            {
                foreach ( $datak[$v] as $k1 => $v1 )
                {
                    fwrite( $f, "{$k1}={$v1}\n", strlen( "{$k1}={$v1}\n" ) );
                }
            }
            fclose( $f );
            ++$i;
        }
        if ( $i <= 0 )
        {
            $errmesg = "Tidak ada data  Operator yang diupdate";
        }
        else
        {
            $errmesg = angkatoteks( $i )." ( {$i} ) data   Operator telah diupdate";
        }
    }
    else
    {
        $errmesg = "Tidak ada data  Operator yang diupdate";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "tampilkan" )
{
    if ( $tingkats == "A" )
    {
        $menulihat = "\t\t\t<table width=100%>\r\n\t\t\t\t<tr>\r\n\r\n\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t<input class=tombol type=submit value='Update Data' name=aksitambahan>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>";
    }
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
    if ( $jabatan != "semua" )
    {
        $qjabatan = " AND JABATAN = {$jabatan} ";
        $jjabatan = ". Jabatan Struktural: ".$arrayjabatan[$jabatan]."";
    }
    if ( $jabatan2 != "semua" )
    {
        $qjabatan2 = " AND JABATANS = {$jabatan2} ";
        $jjabatan2 = ". Jabatan Fungsional: ".$arrayjabatans[$jabatan2]."";
    }
    if ( $lokasi != "semua" )
    {
        $qlokasi = " AND LOKASI = {$lokasi} ";
        $jlokasi = ". Lokasi Kerja: ".$arraylokasi[$lokasi]."";
    }
    if ( $lokasigaji != "semua" )
    {
        $qlokasigaji = " AND LOKASIGAJI = {$lokasigaji} ";
        $jlokasigaji = ". Lokasi Gaji: ".$arraylokasi[$lokasigaji]."";
    }
    if ( $gol != "semua" )
    {
        $qgol = " AND GOLONGAN = {$gol} ";
        $jgol = ". Golongan: ".$arraygolongan[$gol]."";
    }
    if ( $subgol != "semua" )
    {
        $qsubgol = " AND SUBGOLONGAN = '{$subgol}' ";
        $jsubgol = ". Ruang: ".$arraysubgolongan[$subgol]."";
    }
    if ( $statuspegawai != "semua" )
    {
        $qstatuspegawai = " AND STATUSPEGAWAI = {$statuspegawai} ";
        $jstatuspegawai = ". Status Operator: ".$arraystatuspegawai[$statuspegawai]."";
    }
    if ( $statuspegawai2 != "semua" )
    {
        $qstatuspegawai2 = " AND STATUSPEGAWAI2 = {$statuspegawai2} ";
        $jstatuspegawai2 = ". Status PNS: ".$arraystatuspegawai2[$statuspegawai2]."";
    }
    if ( $statuskerja != "semua" )
    {
        $qstatuskerja = " AND STATUSKERJA = {$statuskerja} ";
        $jstatuskerja = ". Status Kerja: ".$arraystatuskerja[$statuskerja]."";
    }
    $query = "SELECT ID, NAMA {$diupdate}\r\n\t\tFROM user WHERE ID!='superadmin' \r\n\t\t{$qjabatan} {$qjabatan2} {$qgol} {$qsubgol} {$qbidang} {$qlokasi} \r\n\t\t{$qlokasigaji}\r\n\t\t{$qstatuspegawai} \r\n\t\t{$qstatuspegawai2} \r\n\t\t{$qstatuskerja} \r\n\t\t{$qshift} {$qstatusl}\r\n\t\t{$qnama} \r\n\t\t{$qsort} ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        $i = 1;
        settype( $i, "integer" );
        $href = "index.php?pilihan=kpupdate&aksi=tampilkan&bidang={$bidang}&statuspegawai={$statuspegawai}&statuspegawai2={$statuspegawai2}&statuskerja={$statuskerja}&lokasi={$lokasi}&lokasigaji={$lokasigaji}&namadicari={$namadicari2}&shift={$shift}&statuslogin={$statuslogin}&jabatan={$jabatan}&jabatan2={$jabatan2}&plgaji={$plgaji}&gol={$gol}&subgol={$subgol}&";
        printmesg( "Data Operator".$jnama.$jjabatan.$jjabatan2.$jgol.$jsubgol.$jbidang.$jstatuspegawai.$jstatuspegawai2.$jstatuskerja.$jlokasi.$jlokasigaji.$jshift.$jstatusl );
        echo "<CENTER>\r\n<table width=100% {$tabellatar}>\r\n<tr\tvalign=top>\r\n<td align=center>\t\r\n\t\t<form action=index.php?pilihan=kpupdate&aksi=tampilkan method=post>\r\n\t\t<input type=hidden name=sort value='{$sort}'>\r\n\t\t<input type=hidden name=namadicari value='{$namadicari}'>\r\n\t\t<input type=hidden name=bidang value='{$bidang}'>\r\n\t\t<input type=hidden name=lokasi value='{$lokasi}'>\r\n\t\t<input type=hidden name=lokasigaji value='{$lokasigaji}'>\r\n\t\t<input type=hidden name=plgaji value='{$plgaji}'>\r\n\t\t<input type=hidden name=gol value='{$gol}'>\r\n\t\t<input type=hidden name=subgol value='{$subgol}'>\r\n\t\t<input type=hidden name=jabatan value='{$jabatan}'>\r\n\t\t<input type=hidden name=jabatan2 value='{$jabatan2}'>\r\n\t\t<input type=hidden name=statuspegawai value='{$statuspegawai}'>\r\n\t\t<input type=hidden name=statuspegawai2 value='{$statuspegawai2}'>\r\n\t\t<input type=hidden name=statuskerja value='{$statuskerja}'>\r\n\t\t\t{$menulihat}\t\r\n\t\t\t<table width=100%  {$tabelisian}\t>\r\n\t\t\t<tr class=judulkolom>\r\n\t\t\t\t<td align=center>No</td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=ID"."'>ID</a></td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=NAMA"."'>Nama</a></td>\r\n\t\t\t\r\n\t\t\t\t<td align=center>Penghasilan Lain (Rp)</td>\r\n\t\t\t\t<td align=center>Penghasilan Pensiun/<BR>Pensiun Janda (Rp)</td>\r\n\t\t\t\t\r\n\r\n\t\t\t</tr>";
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
            $dk = @file( @"kp4/{$data['ID']}" );
            if ( is_array( $dk ) )
            {
                foreach ( $dk as $v )
                {
                    $t = explode( "=", $v );
                    $datak[$t[0]] = $t[1];
                }
            }
            echo "\r\n\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t<td align=center>{$i}\r\n\t\t\t\t\t\t<input type=hidden name=idupdate[{$i}] value='{$data['ID']}'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=center>".printid( $data[ID] )."</td>\r\n\t\t\t\t\t<td >{$data['NAMA']}</td>\r\n\t\t\t\t\t<td ><input class=teksbox name='datak[{$data['ID']}][plain]' type=text size=15 value='{$datak['plain']}'></td>\r\n\t\t\t\t\t<td ><input class=teksbox name='datak[{$data['ID']}][ppensiun]' type=text size=15 value='{$datak['ppensiun']}'></td>\r\n\t\t\t\t</tr>";
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
    printman( $manupdatekp4 );
    echo "<form action=index.php?pilihan=kpupdate method=post>\r\n<input type=hidden name=pilihan value=\"kpupdate\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table ";
    echo $tabelpengumuman;
    echo " width=700>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=200>Nama</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=namadicari class=teksbox value='";
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
}
?>
