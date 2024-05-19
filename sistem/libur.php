<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksitambahan == "Hapus" )
{
    $i = 0;
    if ( is_array( $hapuslibur ) )
    {
        foreach ( $hapuslibur as $v )
        {
            $query = "DELETE FROM libur WHERE TGLLIBUR='{$v}'";
           mysqli_query($koneksi,$query);
            $i += sqlaffectedrows( $koneksi );
        }
        if ( $i == 0 )
        {
            $errmesg = "Tidak ada data hari libur yang dihapus";
        }
        else
        {
            $errmesg = "{$i} data hari libur telah dihapus";
        }
    }
    else
    {
        $errmesg = "Tidak ada data hari libur yang dihapus";
    }
    $aksi = "";
}
if ( $aksi == "tambah" || $aksi == "update" )
{
    $waktu = getdate( time( ) );
    if ( $aksiuser == "Tambah" )
    {
        if ( istanggal( $tgl, $bln, $thn, "Libur" ) )
        {
            $query = "INSERT INTO libur VALUES\r\n\t\t\t\t('{$thn}-{$bln}-{$tgl}',NOW(),'{$userlogin}','{$ket}')";
           mysqli_query($koneksi,$query);
            if ( sqlaffectedrows( $koneksi ) == 0 )
            {
                $errmesg = "Data gagal ditambahkan. Mungkin sudah ada data hari libur untuk tanggal {$tgl}-{$bln}-{$thn}";
            }
            else
            {
                $errmesg = "Data hari libur tanggal {$tgl}-{$bln}-{$thn} berhasil ditambah";
            }
            $thn = $waktu[year];
            $bln = $waktu[mon];
            $ket = "";
        }
        else
        {
            $errmesg = "Salah memilih tanggal";
        }
    }
    else if ( $aksiuser == "Update" )
    {
        if ( istanggal( $tgl, $bln, $thn, "Libur" ) )
        {
            $query = "UPDATE libur SET\r\n\t\t\t\tLASTUPDATE=NOW(),UPDATER='{$userlogin}',KET='{$ket}'\r\n\t\t\t\tWHERE TGLLIBUR='{$thn}-{$bln}-{$tgl}'";
           mysqli_query($koneksi,$query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Update data hari libur berhasil";
                $errmesg = "Data hari libur tanggal {$tgl}-{$bln}-{$thn} berhasil diupdate";
            }
            else
            {
                $errmesg = "Data hari libur tanggal {$tgl}-{$bln}-{$thn} tidak berhasil diupdate. Data mungkin tidak ada.";
            }
        }
        else
        {
            $errmesg = "Salah memilih tanggal";
        }
    }
    else if ( $thn == "" && $bln == "" )
    {
        $thn = $waktu[year];
        $bln = $waktu[mon];
    }
    if ( $aksi == "tambah" )
    {
        $btn = "Tambah";
        $aksibalik = "Update";
        $aksiblk = "update";
    }
    else if ( $aksi == "update" )
    {
        $query = "SELECT KET FROM libur WHERE \r\n\t\t\t\t\tTGLLIBUR='{$thn}-{$bln}-{$tgl}'";
        $hasil =mysqli_query($koneksi,$query);
        $data = sqlfetcharray( $hasil );
        $ket = $data[KET];
        $btn = "Update";
        $aksibalik = "Tambah";
        $aksiblk = "tambah";
    }
    if ( $aksi == "tambah" )
    {
        printjudulmenu( "Tambah Data Hari Libur" );
    }
    else
    {
        printjudulmenu( "Update Data Hari Libur" );
    }
    printmesg( $errmesg );
    echo "<form action=index.php?pilihan=lbtambah method=post>\r\n<input type=hidden name=aksi value=";
    echo $aksi;
    echo ">\r\n<input type=hidden name=pilihan value=lbtambah>\r\n<table class=form>\r\n\t<tr>\r\n\t\t<td width=100>Tanggal\r\n\t\t</td>\r\n\t\t<td>\r\n\r\n\t\t\t";
    echo "<s";
    echo "elect  class=masukan name=tgl>\r\n\t\t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( $tgl == $i && $aksi == "update" )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>{$i}</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t</select>-\t\t\t\r\n\t\t\t";
    echo "<s";
    echo "elect  class=masukan name=bln>\r\n\t\t\t";
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
    echo "\t\t\t</select>-\r\n\r\n\t\t\t";
    echo "<s";
    echo "elect class=masukan name=thn>\r\n\t\t\t";
    $i = $tahuninstal - 5;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>{$i}</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t</select>\r\n\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >\r\n\t\t\tKeterangan\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<textarea  class=masukan name=ket cols=60 rows=5>";
    echo $ket;
    echo "</textarea>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td></td> <td>\r\n\t\t\t<input  class=tombol type=submit name=aksiuser value=\"";
    echo $btn;
    echo "\">\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n\t\r\n</table>\r\n</form>\r\n\r\n\r\n";
}
else if ( $aksi == "lihat" || $aksi == "" )
{
    $query = "SELECT DAYOFMONTH(TGLLIBUR) AS TGL, MONTH(TGLLIBUR) AS BLN, YEAR(TGLLIBUR) AS THN,\r\n\t\tDATE_FORMAT(LASTUPDATE,'%d-%m-%Y %H:%i:%s') AS LASTUP,\r\n\t\tUPDATER, KET \r\n\t\tFROM libur WHERE YEAR(TGLLIBUR)={$thndari} ORDER BY TO_DAYS(TGLLIBUR) DESC";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        printjudulmenu( "Data Hari Libur" );
        printmesg( $errmesg );
        $i = 1;
        echo "<form action=index.php?pilihan=lblihat method=post>\r\n\t\t\t<input type=hidden name=pilihan value=lbtambah>\r\n\t\t\t<input type=hidden name=thndari value={$thndari}>\r\n\r\n\t\t\t<table class=data>\r\n\t\t\t\t<tr >\r\n\t\t\t\t\t\r\n\t\t\t\t\t<td colspan=2 align=right  >\r\n\t\t\t\t\t\t<input class=tombol type=submit value=Hapus name=aksitambahan ";
        printconfirmjs( "Hapus data hari libur yang telah dipilih? Data yang dihapus tidak dapat dikembalikan lagi" );
        echo ">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t<table class=data>\r\n\t\t\t<tr class=juduldata>\r\n\t\t\t\t<td align=center>No</td>\r\n\t\t\t\t<td align=center>Tanggal Libur</td>\r\n\t\t\t\t<td align=center>Keterangan</td>\r\n\t\t\t\t<td align=center>Waktu Penambahan</td>\r\n\t\t\t\t<td align=center>Update</td>\r\n\t\t\t\t<td align=center>Hapus</td>\r\n\t\t\t</tr>";
        settype( $i, "integer" );
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
            echo "\r\n\t\t\t\t<tr {$kelas}>\r\n\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t<td   >{$data['TGL']} ".$arraybulan[$data[BLN] - 1]." {$data['THN']}</td>\r\n\t\t\t\t\t<td>{$data['KET']}</td>\r\n\t\t\t\t\t<td align=center>{$data['LASTUP']}</td>\r\n\t\t\t\t\t<td align=center><a href=index.php?pilihan=lbtambah&aksi=update&tgl={$data['TGL']}&bln={$data['BLN']}&thn={$data['THN']}><font color=#000000>Update</font></a></td>\r\n\t\t\t\t\t<td align=center><input class=masukan type=checkbox name=hapuslibur[] value='{$data['THN']}-{$data['BLN']}-{$data['TGL']}'></td>\r\n\t\t\t\t</tr>";
            ++$i;
        }
        echo "</table>\r\n\t\t\t<table class=data>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<td colspan=2 align=right  >\r\n\t\t\t\t\t\t<input class=tombol  type=submit value=Hapus name=aksitambahan ";
        printconfirmjs( "Hapus data hari libur yang telah dipilih? Data yang dihapus tidak dapat dikembalikan lagi" );
        echo ">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n";
    }
    else
    {
        $errmesg = "Data hari libur tidak ada";
        $aksi = "tampilawal";
    }
}
if ( $aksi == "tampilawal" )
{
    printjudulmenu( "Lihat Data Hari Libur" );
    printmesg( $errmesg );
    echo "\t\t\t\t<form name=formisian action=index.php?pilihan=lblihat&aksi=tampilkan method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=lblihat>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"lihat\">\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td class=judulform>\r\n\t\t\t\t\t\t\t\tTahun Hari Libur\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t";
    echo "<s";
    echo "elect class=masukan name=thndari>\r\n\t\t\t\t\t\t\t\t\t";
    $i = $tahuninstal - 5;
    while ( $i <= $waktu[year] )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>{$i}</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 ><BR>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n\t\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n \t";
}
?>
