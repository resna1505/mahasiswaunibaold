<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi == "tampilkan" )
{
    if ( $diagram == 1 )
    {
        delgambartemp( );
        $seed = mt_srand( make_seed( ) );
        $folder = "gambardiagram/";
        $ombangambing = 1;
    }
    include( "prosestampiltranskrip.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Transkrip Nilai" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
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
    if ( $jenisusers != 2 && $jenisusers != 3 )
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
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ mahasiswa ]\r\n\t\t\t</a>\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ alumni ]\r\n\t\t\t</a>\r\n\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arraystatusmahasiswa as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNilai M-K yang diambil\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=nilaidiambil>\r\n\t\t\t\t\t\t<option value='1'>Nilai Terakhir</option>\r\n\t\t\t\t\t\t<option value='0'>Nilai Terbaik</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t<tr>\r\n\t\t<td class=judulform>Cetak Diagram\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=radio class=masukan name=diagram value=1 >Ya\r\n\t\t\t<input type=radio class=masukan name=diagram value=0 checked>Tidak\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=judulform>Jenis\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=radio class=masukan name=jenistampilan value=1 checked >Standar\r\n\t\t\t<input type=radio class=masukan name=jenistampilan value=0>Dipisah Per Jenis Mata Kuliah\r\n\t\t\t<input type=radio class=masukan name=jenistampilan value=2 >Per Kolom Semester\r\n\t\t\t<input type=radio class=masukan name=jenistampilan value=3  >Dua Kolom\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tanggal Laporan</td>\r\n\t\t\t<td>".createinputtanggal( "tgllap", $tgllap, " class=masukan " )."</td>\r\n\t\t</tr> ";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "\r\n\t<tr>\r\n\t\t<td class=judulform>Data Per Halaman\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=text class=masukan name=dataperhalaman value='{$maxdata}' size=2>Sebaiknya nilainya diperkecil karena pemrosesan transkrip akan memakan waktu relatif lama\r\n\t\t</td>\r\n\t</tr>";
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
