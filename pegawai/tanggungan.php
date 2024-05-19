<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

@cekuser( "AD" );
$ok = false;
if ( $aksi == "tampilawal" )
{
    echo "\r\n\r\n<form name=form action=index.php?pilihan=tlihat method=post>\r\n<input type=hidden name=pilihan value='tlihat'>\r\n<input type=hidden name=aksi value='tampilkan'>\r\n<input type=hidden name=sort value='ID'>\r\n<table {$tabelpengumuman} width=600>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=100>ID User</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=iduser class=teksbox>\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td colspan=2><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n\r\n";
}
if ( $aksi == "Update" )
{
    $query = "UPDATE tanggunganp \r\n\t\tSET \r\n\t\tNAMA='{$nama}',\r\n\t\tTGLLAHIR='{$thn}-{$bln}-{$tgl}',\r\n\t\tTGLKAWIN='{$thnp}-{$blnp}-{$tglp}',\r\n\t\tKET='{$status}',\r\n\t\tPEKERJAAN='{$pekerjaan}',\r\n\t\tTANGGUNGAN='{$tanggungan}'\r\n\t\t \r\n\t\tWHERE ID='{$idtanggungan}'\r\n\t\tAND IDUSER='{$iduser}'";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Update data tanggungan dengan ID User = {$iduser} berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Update data tanggungan dengan ID User = {$iduser} tidak dilakukan.";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Hapus" )
{
    $query = "DELETE FROM tanggunganp WHERE ID='{$idtanggungan}' AND IDUSER='{$iduser}'";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Penghapusan data tanggungan  dengan ID User = {$iduser} berhasil dilakukan.";
    }
    else
    {
        $errmesg = "Penghapusan data tanggungan  dengan ID User = {$iduser} gagal dilakukan.";
    }
    $aksi = "tampilkan";
}
else if ( $aksi == "Tambah" )
{
    if ( trim( $iduser ) == "" || $iduser == "superadmin" )
    {
        $errmesg = "ID User harus diisi dan tidak boleh sama dengan superadmin";
    }
    else if ( trim( $nama ) == "" )
    {
        $errmesg = "Nama tanggungan harus diisi";
    }
    else
    {
        $q = "SELECT ID FROM user WHERE ID='{$iduser}'";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $errmesg = "Tidak ada user dengan ID = {$iduser} ";
        }
        else
        {
            $q = "SELECT MAX(ID)+1 AS IDB FROM tanggunganp WHERE IDUSER='{$iduser}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $id = $d[IDB];
            if ( $id == "" )
            {
                $id = 0;
            }
            $query = "INSERT INTO tanggunganp VALUES('{$id}','{$iduser}','{$nama}',\r\n\t\t\t\t'{$thn}-{$bln}-{$tgl}','{$thnp}-{$blnp}-{$tglp}','{$pekerjaan}','{$status}','{$tanggungan}')";
            $hasil =mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Penambahan data tanggungan  dengan ID User = {$iduser} berhasil dilakukan.";
            }
            else
            {
                $errmesg = "Penambahan data lokasi   dengan ID User = {$iduser} gagal dilakukan.";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "tampilkan" )
{
    printmesg( $errmesg );
    $q = "SELECT NAMA FROM user WHERE ID='{$iduser}'";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) < 1 )
    {
        $errmesg = "Tidak ada user dengan ID = '{$iduser}'";
        $aksi = "";
    }
    else
    {
        $d = sqlfetcharray( $h );
        $namauser = $d[NAMA];
        $query = "SELECT tanggunganp.ID,user.NAMA AS \tNAMAU,IDUSER,tanggunganp.NAMA,KET,PEKERJAAN,\r\n\t\t\t\tDAYOFMONTH(tanggunganp.TGLLAHIR) AS TGL, MONTH(tanggunganp.TGLLAHIR) AS BLN, YEAR(tanggunganp.TGLLAHIR) AS THN, \r\n\t\t\t\tDAYOFMONTH(TGLKAWIN) AS TGLP, MONTH(TGLKAWIN) AS BLNP, YEAR(TGLKAWIN) AS THNP, \r\n\t\t\tTANGGUNGAN\r\n\r\n\t\t\t FROM tanggunganp,user\r\n\t\t\tWHERE \r\n\t\t\tuser.ID=tanggunganp.IDUSER AND\r\n\t\t\tIDUSER='{$iduser}' \r\n\t\t\tORDER BY tanggunganp.TGLLAHIR";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlnumrows( $hasil ) )
        {
            echo "\r\n\t\t\t\t\t<CENTER>\r\n\t\t\t<h4  style='font-family:Arial'>Data Tanggungan <br>User: {$iduser} / {$namauser}</h4>\r\n\t\t\t\t\t\r\n\t\t\t\t\t\t<table width=100% {$tabellatar}>\r\n\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t";
            echo "\r\n\t\t\t\t\t<table width=100% {$tabelisian}>\r\n\t\t\t\t\t\t<tr align=center class=judulkolom>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggal Lahir\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggal Perkawinan<br>Khusus Suami/Istri\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tPekerjaan/Sekolah\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKeterangan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggungan ?\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tAksi\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
            $i = 0;
            settype( $i, "integer" );
            while ( $datauser = sqlfetcharray( $hasil ) )
            {
                if ( $i % 2 == 0 )
                {
                    $kelas = "class=datagenap";
                }
                else
                {
                    $kelas = "class=dataganjil";
                }
                $idtanggungan = $datauser[ID];
                $nama = $datauser[NAMA];
                $tgl = $datauser[TGL];
                $bln = $datauser[BLN];
                $thn = $datauser[THN];
                $tglp = $datauser[TGLP];
                $blnp = $datauser[BLNP];
                $thnp = $datauser[THNP];
                $status = $datauser[KET];
                $pekerjaan = $datauser[PEKERJAAN];
                $tanggungan = $datauser[TANGGUNGAN];
                $ceky = "";
                $cekt = "";
                if ( $tanggungan == "Y" )
                {
                    $ceky = "selected";
                }
                else
                {
                    $cekt = "selected";
                }
                ++$i;
                echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<form action=index.php?pilihan=tlihat method=post>\r\n\t\t\t\t\t\t\t<input type=hidden name=pilihan value=tlihat>\r\n\t\t\t\t\t\t\t<input type=hidden name=iduser value={$iduser}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td nowrap align=center>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=idtanggungan value='{$idtanggungan}'>\r\n\t\t\t\t\t\t\t\t<input type=text name=nama value='{$nama}' size=10 class=teksbox> \t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td nowrap  align=center >\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=tgl>";
                $j = 1;
                while ( $j <= 31 )
                {
                    $cek = "selected";
                    echo "<option value={$j} {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>-\t\t\t\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=bln>\r\n\t\t\t\t\t\t\t\t";
                $j = 1;
                while ( $j <= 12 )
                {
                    if ( $j == $bln )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>".$arraybulan[$j - 1]."</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=thn>\r\n\t\t\t\t\t\t\t\t";
                $j = 1900;
                while ( $j <= $w[year] )
                {
                    if ( $j == $thn )
                    {
                        $cek = "selected";
                    }
                    echo "<option value='{$j}' {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td nowrap align=center >\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=tglp>";
                $j = 1;
                while ( $j <= 31 )
                {
                    if ( $tglp == $j )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>-\t\t\t\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=blnp>\r\n\t\t\t\t\t\t\t\t";
                $j = 1;
                while ( $j <= 12 )
                {
                    if ( $j == $blnp )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>".$arraybulan[$j - 1]."</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=thnp>\r\n\t\t\t\t\t\t\t\t";
                $j = 1900;
                while ( $j <= $w[year] )
                {
                    if ( $j == $thnp )
                    {
                        $cek = "selected";
                    }
                    echo "<option value='{$j}' {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t<input type=text name=pekerjaan value='{$pekerjaan}' size=5 class=teksbox> \t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=status>";
                foreach ( $arraystatustanggungan as $k => $v )
                {
                    if ( $status == $k )
                    {
                        $cek = "selected";
                    }
                    echo "<option {$cek} value={$k} >{$v}</option>";
                    $cek = "";
                }
                echo "\r\n\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t<select class=teksbox name=tanggungan>\r\n\t\t\t\t\t\t\t\t\t<option value='Y' {$ceky}>Ya</option>\r\n\t\t\t\t\t\t\t\t\t<option value='T' {$cekt}>Tidak</option>\r\n\t\t\t\t\t\t\t\t</select>\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t<input type=submit name=aksi value='Update' class=tombol>";
                echo "<input type=submit name=aksi value='Hapus' class=tombol onclick=\"return confirm('Hapus data tanggungan dengan Nama = {$nama}');\">";
                echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t</center>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t</center>\r\n\t\t\t\t";
        }
        else
        {
            printmesg( "Daftar tanggungan untuk ID User = '{$iduser}' ({$namauser}) tidak ada." );
        }
    }
}
else
{
    if ( !$ok )
    {
        printmesg( $errmesg );
        if ( $aksi == "Tambah" || $aksi == "formtambah" )
        {
            echo "\r\n<CENTER>\r\n\t<table width=100% ";
            echo $tabellatar;
            echo ">\r\n\t\t<tr valign=top>\r\n\t\t\t<td align=center>\r\n\t\t\t\t";
            printman( $mantambahtanggungan );
            echo "\t\t\t\t<form name=form action=index.php?pilihan=ttambah method=post>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"Tambah\">\r\n\t\t\t\t\t<input type=hidden name=pilihan value=ttambah>\r\n\t\t\t\t\t<table ";
            echo $tabelisian2;
            echo ">\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td width=100>\r\n\t\t\t\t\t\t\t\tID User\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=teksbox type=text size=10  name=iduser >\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tNama Tanggungan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t";
            echo "\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=teksbox type=text size=30  name=nama>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td  >Status</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=status>\r\n\t\t\t\t\t\t\t\t";
            foreach ( $arraystatustanggungan as $k => $v )
            {
                if ( $status == $k )
                {
                    $cek = "selected";
                }
                echo "<option {$cek} value={$k} >{$v}</option>";
                $cek = "";
            }
            echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggal Lahir\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=tgl>\r\n\t\t\t\t\t\t\t\t";
            $i = 1;
            while ( $i <= 31 )
            {
                if ( $tgl == $i )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>-\t\t\t\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=bln>\r\n\t\t\t\t\t\t\t\t";
            $i = 1;
            while ( $i <= 12 )
            {
                if ( $i == $bln )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=thn>\r\n\t\t\t\t\t\t\t\t";
            $i = 1900;
            while ( $i <= $w[year] )
            {
                if ( $i == $thn )
                {
                    $cek = "selected";
                }
                echo "<option value='{$i}' {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggal Pernikahan<br>(Khusus Suami/Istri)\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=tglp>\r\n\t\t\t\t\t\t\t\t";
            $i = 1;
            while ( $i <= 31 )
            {
                if ( $tglp == $i )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>-\t\t\t\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=blnp>\r\n\t\t\t\t\t\t\t\t";
            $i = 1;
            while ( $i <= 12 )
            {
                if ( $i == $blnp )
                {
                    $cek = "selected";
                }
                echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=thnp>\r\n\t\t\t\t\t\t\t\t";
            $i = 1900;
            while ( $i <= $w[year] )
            {
                if ( $i == $thnp )
                {
                    $cek = "selected";
                }
                echo "<option value='{$i}' {$cek}>{$i}</option>";
                $cek = "";
                ++$i;
            }
            echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tPekerjaan / Sekolah\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input class=teksbox type=text size=30  name=pekerjaan>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTanggungan ?\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
            echo "<s";
            echo "elect class=teksbox name=tanggungan>\r\n\t\t\t\t\t\t\t\t\t<option value='Y'>Ya</option>\r\n\t\t\t\t\t\t\t\t\t<option value='T'>Tidak</option>\r\n\t\t\t\t\t\t\t\t</select>\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 >\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n</c";
            echo "enter>\r\n\r\n";
        }
    }
}
?>
