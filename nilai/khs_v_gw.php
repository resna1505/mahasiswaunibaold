<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$seed = mt_srand( make_seed( ) );
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
	#echo "ll";exit();
    include( "proseslihatkhs.php" );
}
if ( $aksi == "tampilsemua" )
{
    include( "proseslihatkhs2.php" );
}
if ( $aksi == "" )
{
	#printjudulmenu( "Nilai Kuliah" );
    
    #printjudulmenu( "Kartu Hasil Studi" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  >\r\n    ";
    if ( $jenisusers != 3 )
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
        $arrayangkatan = getarrayangkatan( );
        foreach ( $arrayangkatan as $k => $v )
        {
            echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ mahasiswa ]\r\n\t\t\t</a>\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\t[ alumni ]\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arraystatusmahasiswa as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        echo "\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td> {$users}\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> ";
    }
    echo "\r\n\r\n";
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Jenis Kelas Default </td>\r\n\t\t\t<td>\r\n        <select name='jeniskelas' >\r\n        <option value=''>Semua</option>\r\n      ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n      </select>\r\n      \r\n      </td>\r\n\t\t</tr>\r\n     ";
    }
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0 )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \r\n \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tNilai M-K yang diambil\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=nilaidiambil>";
    if ( $UNIVERSITAS != "STEI INDONESIA" )
    {
        echo "\r\n\t\t\t\t\t\t<option value='1'>Nilai Terakhir</option>";
    }
    echo "\r\n \t\t\t\t\t\t<option value='0' selected>Nilai Terbaik</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tPerlakuan terhadap Nilai Kosong/Tunda\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=nilaikosong>";
    if ( $UNIVERSITAS != "STEI INDONESIA" )
    {
        echo "\r\n\t\t\t\t\t\t<option value='0'>Tidak dihitung</option>\r\n            ";
    }
    echo "\r\n\t\t\t\t\t\t<option value='1'>Dihitung</option>\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNilai SP\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    if ( $UNIVERSITAS == "STEI INDONESIA" )
    {
        $ceksp = "checked";
    }
    echo "\r\n\t\t\t\t<input type=checkbox name=sp value=1 {$ceksp}>Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td class=judulform>Cetak Diagram\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=radio class=masukan name=diagram value=1 >Ya\r\n\t\t\t<input type=radio class=masukan name=diagram value=0 checked>Tidak\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=judulform>Jenis\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
    if ( $FILEKHS != "" && $UNIVERSITAS != "" )
    {
        echo "\r\n       \t\t<input type=radio class=masukan name=jenistampilan value=99 checked >KHS {$UNIVERSITAS} <br>\r\n        ";
        $checked = "";
    }
    else if ( $UNIVERSITAS == "" )
    {
        $checked = "checked ";
    }
    if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
    {
        echo "\r\n  \t\t\t<input type=radio class=masukan name=jenistampilan value=untag {$checked}>KHS {$UNIVERSITAS} - BLANKO<br>\r\n        ";
    }
    echo "\r\n\t\t\t<input type=radio class=masukan name=jenistampilan value=1 {$checked}>Standar\r\n \r\n\t\t</td>\r\n\t</tr>\r\n\t\t\t\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tanggal Laporan</td>\r\n\t\t\t<td>".createinputtanggal( "tgllap", $tgllap, " class=masukan " )."</td>\r\n\t\t</tr> \t\t\t";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "\r\n\t<tr>\r\n\t\t<td class=judulform>Data Per Halaman\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=text class=masukan name=dataperhalaman value='{$maxdata}' size=2>Sebaiknya nilainya diperkecil karena pemrosesan KHS akan memakan waktu relatif lama\r\n\t\t</td>\r\n\t</tr>";
        if ( $jenisusers == 0 )
        {
            echo "\r\n\t<tr>\r\n\t\t<td class=judulform>Kop Surat\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=radio class=masukan name=kopsurat value='' checked>Tanpa Kop\r\n\t\t\t<input type=radio class=masukan name=kopsurat value='1' >Cetak Kop Surat Umum\r\n\t\t\t<input type=radio class=masukan name=kopsurat value='2' >Cetak Kop Surat Fakultas\r\n\t\t</td>\r\n\t</tr>";
        }
        echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tCatatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t <textarea name=catatan cols=40 rows=5>{$catatan}</textarea>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \r\n  ";
    }
    echo "\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
