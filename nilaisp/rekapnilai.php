<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "ganti" )
{
    $aksi = "lanjut";
}
else if ( $aksi2 == "Tampilkan" )
{
    if ( !is_array( $datamk ) )
    {
        $aksi = "lanjut";
        $errmesg = "Silakan pilih mata kuliah yang hendak dicetak nilainya";
    }
    else
    {
        include( "prosesrekapnilai.php" );
    }
}
if ( $aksi == "lanjut" )
{
    printjudulmenu( "Laporan Nilai Mata Kuliah " );
    printmesg( $errmesg );
    if ( $idprodi == "" )
    {
        $idprodi = $idprodi2;
    }
    echo "\r\n\t\t<table class=form>";
    if ( $jenisusers != 2 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        if ( $idprodi2 == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $arrayprodidep[$idprodi2];
        }
        echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    if ( $jenisusers == 0 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tDosen Wali\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        if ( $iddosen == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $arraydosendep[$iddosen];
        }
        echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    if ( $jenisusers != 2 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        if ( $angkatan == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $angkatan;
        }
        echo "</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>{$id}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>{$nama}</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        if ( $status == "" )
        {
            echo "Semua";
        }
        else
        {
            echo $arraystatusmahasiswa[status];
        }
        echo "\r\n \t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tNilai M-K yang diambil\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    if ( $nilaidiambil == 1 )
    {
        echo "Nilai Terakhir";
    }
    else
    {
        echo "Nilai Terbaik";
    }
    echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $aksi == "" )
    {
        echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    echo "\r\n \t\t</table>\r\n\t\t<form action=index.php method=post>\r\n\t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "iddosen", "{$iddosen}", "" )."\r\n\t\t\t".createinputhidden( "id", "{$id}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "id", "{$id}", "" )."\r\n\t\t\t".createinputhidden( "nama", "{$status}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "{$aksi}", "" )."\r\n\t\t\t".createinputhidden( "idprodi2", "{$idprodi2}", "" )."\r\n\t\t\t".createinputhidden( "angkatan", "{$angkatan}", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n \t\t\t<table class=form>\r\n\t\t\t\t<tr>\r\n\t\t\t\t<td class=judulform align=left>Jurusan/Program Studi Mata Kuliah\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, "{$idprodi}", "", "class=masukan" )."\r\n\t\t\t\t<input type=submit name=aksi2 value='ganti' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n  \t\t";
    if ( $jenisusers == 2 )
    {
        echo "<input type=hidden name=id value='{$users}'>";
    }
    $q = "SELECT * \r\n\t\tFROM makul\r\n\t\tWHERE\r\n\t\t\tIDPRODI='{$idprodi}'\r\n\t\t\tORDER BY SEMESTER,ID\r\n\t\t";
    $hp = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $hp ) <= 0 )
    {
        printmesg( "Data Mata Kuliah Jurusan/Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
    }
    else
    {
        echo "\r\n  \t\t\t".createinputhidden( "idmahasiswa", "{$idmahasiswa}", "" )."\r\n\t\t\t".createinputhidden( "aksi", "updatemk", "" )."\r\n\t\t\t".createinputhidden( "pilihan", "{$pilihan}", "" )."\r\n\t\t\t".createinputhidden( "idprodi", "{$idprodi}", "" )."\r\n\t\t\t".createinputhidden( "idprodi2", "{$idprodi2}", "" )."\r\n\t\t\t".createinputhidden( "angkatan", "{$angkatan}", "" )."\r\n\t\t\t".createinputhidden( "data[tahun]", "{$data['tahun']}", "" )."\r\n\t\t\t".createinputhidden( "data[semester]", "{$data['semester']}", "" );
        echo "\r\n\t\t\t\r\n\t\t\t\t<table class=data>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td colspan=6 align=right>\r\n\t\t\t\t\t<input type=submit name=aksi2 class=masukan value='Tampilkan'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n \t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $i = 1;
        $semlama = "";
        while ( $dp = sqlfetcharray( $hp ) )
        {
            if ( $semlama != $dp[SEMESTER] )
            {
                $semlama = $dp[SEMESTER];
                echo "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=6>Semester {$dp['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr align=center {$kelas}>\r\n\t\t\t\t\t\t<td>{$i}\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['ID']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMA']}</td>\r\n\t\t\t\t\t\t<td>{$dp['SKS']}</td>\r\n \t\t\t\t\t\t<td>".createinputcek( "datamk[{$dp['ID']}]", "1", "", "", "class=masukan" )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            ++$i;
        }
        echo "</table>\r\n\t\t\t</form>";
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Laporan Nilai Mata Kuliah Semester Pendek" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='lanjut'>\r\n\t\t<table class=form>";
    if ( $jenisusers != 2 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi2>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arrayprodidep as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    if ( $jenisusers == 0 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tDosen Wali\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arraydosendep as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    if ( $jenisusers != 2 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        $waktu = getdate( );
        echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        $i = 1900;
        while ( $i <= $waktu[year] + 5 )
        {
            echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
            ++$i;
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ mahasiswa ]\r\n\t\t\t</a>\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ alumni ]\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arraystatusmahasiswa as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tNilai M-K yang diambil\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=nilaidiambil>\r\n\t\t\t\t\t\t<option value='1'>Nilai Terakhir</option>\r\n\t\t\t\t\t\t<option value='0'>Nilai Terbaik</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tanggal Laporan</td>\r\n\t\t\t<td>".createinputtanggal( "tgllap", $tgllap, " class=masukan " )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
