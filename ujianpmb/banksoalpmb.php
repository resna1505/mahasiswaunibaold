<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", HAPUS_DATA );
    }
    else
    {
        $q = "DELETE FROM banksoalpmb WHERE ID='{$idhapus}' ";
        mysqli_query($koneksi,$q);
        $ketlog = "Hapus data Bank Soal PMB dengan ID={$idhapus}";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            if ( file_exists( "foto/{$d['ID']}" ) )
            {
                @unlink( @"foto/{$d['ID']}" );
            }
            $errmesg = "Data Bank Soal PMB  berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Bank Soal PMB   tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else if ( trim( $gelombang ) == "" )
    {
        $errmesg = "Gelombang harus diisi";
    }
    else if ( trim( $pertanyaan ) == "" )
    {
        $errmesg = "Isi Pertanyaan harus diisi";
    }
    else if ( $jenis == "B" && $kuncibs == "" )
    {
        $errmesg = "Kunci Jawaban harus diisi";
    }
    else if ( $jenis == "P" && $kunci == "" )
    {
        $errmesg = "Kunci Jawaban harus diisi";
    }
    else if ( $jenis == "P" && ( $jawaban1 == "" || $jawaban2 == "" || $jawaban3 == "" || $jawaban4 == "" ) )
    {
        $errmesg = "Jawaban harus diisi";
    }
    else
    {
        $qhapusgambar = "";
        if ( $hapusgambar == 1 )
        {
            $q = "SELECT GAMBAR FROM banksoalpmb WHERE ID='{$idupdate}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                @unlink( @"gambar/{$d['GAMBAR']}" );
                $qhapusgambar = ",GAMBAR='' ";
            }
        }
        $q = "UPDATE banksoalpmb\r\n   \r\n   SET\r\n    TAHUN='{$tahuna}',\r\n\r\n`GELOMBANG`='{$gelombang}' ,\r\n`FAKULTAS`='{$idfakultas}' ,\r\n`IDBIDANG`='{$idbidang}' ,\r\n`PERTANYAAN`='{$pertanyaan}' ,\r\n`NILAI`='{$nilai}' ,\r\n`NILAISALAH`='{$nilaisalah}' ,\r\n`JENIS`='{$jenis}' ,\r\n`JAWABAN1`='{$jawaban1}' ,\r\n`JAWABAN2`='{$jawaban2}' ,\r\n`JAWABAN3`='{$jawaban3}' ,\r\n`JAWABAN4`='{$jawaban4}' ,\r\n`JAWABAN5`='{$jawaban5}' ,\r\n`JAWABAN6`='{$jawaban6}' ,\r\n`KUNCIBS`='{$kuncibs}' ,\r\n`UPDATER`='{$users}' ,\r\n`TANGGALUPDATE`=NOW() ,\r\n`KUNCI`='{$kunci}'\r\n{$qhapusgambar}\r\n \r\n   WHERE ID='{$idupdate}'";
        mysqli_query($koneksi,$q);
        if ( $filegambar != "" )
        {
            $ext = get_file_extension( $filegambar_name );
            $q = "SELECT GAMBAR FROM banksoalpmb WHERE ID='{$idupdate}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                @unlink( @"gambar/{$d['GAMBAR']}" );
            }
            @move_uploaded_file( @$filegambar, @"gambar/{$idupdate}.{$ext}" );
            $q = "UPDATE banksoalpmb SET GAMBAR='{$idupdate}.{$ext}' WHERE ID='{$idupdate}' ";
            mysqli_query($koneksi,$q);
        }
        echo mysqli_error($koneksi);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Bank Soal PMB berhasil disimpan";
        }
        else
        {
            $errmesg = "Data Bank Soal PMB tidak disimpan";
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Update Data Bank Soal PMB" );
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT \r\n\t* FROM banksoalpmb WHERE ID='{$idupdate}'\r\n\t";
	#echo $q;exit();
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $tahuna = $d[TAHUN];
        $gelombang = $d[GELOMBANG];
        $idfakultas = $d[FAKULTAS];
        $idbidang = $d[IDBIDANG];
        $pertanyaan = $d[PERTANYAAN];
        $jenis = $d[JENIS];
        $kunci = $d[KUNCI];
        $kuncibs = $d[KUNCIBS];
        $nilai = $d[NILAI];
        $nilaisalah = $d[NILAISALAH];
        $i = 1;
        while ( $i <= 6 )
        {
            ${ "jawaban".$i } = $d["JAWABAN{$i}"];
            ++$i;
        }
        echo "<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )." ".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Angkatan/Tahun Daftar</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $tahuna, " class=masukan " )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang</td>";
        if ( $gelombang == "" )
        {
            $gelombang = 1;
        }
        if ( $tahuna == "" )
        {
            $tahuna = $w[year];
        }
        if ( $idpilihan == "" )
        {
            $idpilihan = $arraypilihan[$initidpilihan];
        }
        unset( $arrayfakultas[''] );
        echo "<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Fakultas</td>\r\n\t\t\t<td>".createinputselect( "idfakultas", $arrayfakultas, $idfakultas, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Bidang Soal</td>\r\n\t\t\t<td>".createinputselect( "idbidang", $arraybidangsoal, $idbidang, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n\r\n     \r\n     \r\n     ";
        echo "";
        echo "<tr class=judulform>\r\n\t\t\t<td>Isi Pertanyaan</td>\r\n\t\t\t<td> <textarea name=pertanyaan class=mce cols=60 rows=20>{$pertanyaan}</textarea></td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Gambar untuk ditampilkan</td>\r\n\t\t\t<td><input type=file class=masukan name=filegambar >\r\n      ";
        if ( $d[GAMBAR] != "" && file_exists( "gambar/{$d['GAMBAR']}" ) )
        {
            echo "<br><img src='gambar/{$d['GAMBAR']}' width=300><br>\r\n        <input type=checkbox name=hapusgambar value=1>Hapus gambar";
        }
        echo "\r\n      </td>\r\n\t\t</tr> \r\n \r\n \r\n";
        if ( $jenis == "" || $jenis == 0 )
        {
            $cekganda = "checked";
        }
        else if ( $jenis == 1 )
        {
            $cekbs = "checked";
        }
        echo "\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Jenis Soal</td>\r\n\t\t\t<td>\r\n      <input type=radio name=jenis value=0 {$cekganda}  onclick=\"showHideJenisBankSoalPmb(this.value); \"> Pilihan Ganda\r\n      <input type=radio name=jenis value=1 {$cekbs}  onclick=\"showHideJenisBankSoalPmb(this.value); \"> Benar/Salah\r\n      </td>\r\n\t\t</tr>\r\n    </table>";
        if ( $jenis == 0 )
        {
            $styleshowbenarsalah = "style='display:none;' ";
        }
        else if ( $jenis == 1 )
        {
            $styleshowpilihanganda = "style='display:none;' ";
        }
        echo "\r\n<div id=pilihanganda {$styleshowpilihanganda} >\r\n<table>";
        $i = 1;
        while ( $i <= 6 )
        {
            if ( $kunci == $i )
            {
               # $cekkunci.$i = "checked";
			   ${ "cekkunci".$i } = "checked";
            }
			#echo $cekkunci.$i;exit();
            echo "<tr class=judulform><td width=250>Jawaban ".chr( $i + 64 )."</td><td><textarea name='jawaban{i}' class=mce cols=40 rows=4>".${ "jawaban".$i }."</textarea>\r\n      \r\n \r\n      <input type=radio name=kunci value=$i ${ "cekkunci".$i }> Kunci Jawaban\r\n      </td>\r\n\t\t</tr>\r\n    ";
           # echo "\r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Jawaban ".chr( $i + 64 )."</td>\r\n\t\t\t<td>\r\n      <textarea name=jawaban class=mce cols=40 rows=4>AAA</textarea><input type=radio name=kunci value=> Kunci Jawaban</td>";
            # echo "\r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Jawaban ".chr( $i + 64 )."</td>\r\n\t\t\t<td>\r\n      <textarea name='jawaban{$i}' class=mce cols=40 rows=4>".$"jawaban{$i}"."</textarea>\r\n      \r\n \r\n      <input type=radio name=kunci value='{$i}' ".${ "cekkunci".$i }."> Kunci Jawaban\r\n      </td>\r\n\t\t</tr>\r\n    ";
      
			++$i;
        }
        echo "\r\n</table>\r\n\r\n";
        echo "\r\n\r\n\r\n</div> ";
        if ( $kuncibs == "B" )
        {
            $cekkuncibsb = "checked";
        }
        else if ( $kuncibs == "S" )
        {
            $cekkuncibss = "checked";
        }
        echo "\r\n<div id=benarsalah {$styleshowbenarsalah} >\r\n<table>\r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Jawaban </td>\r\n\t\t\t<td> \r\n      <input type=radio name=kuncibs value='B' {$cekkuncibsb}  > BENAR\r\n      <input type=radio name=kuncibs value='S' {$cekkuncibss}  > SALAH\r\n      </td>\r\n\t\t</tr>\r\n\t\t</table>\r\n</div>\r\n  <table>\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n         <tr class=judulform>\r\n\t\t\t<td width=250 >Nilai Jika Benar</td>\r\n\t\t\t<td>".createinputtext( "nilai", $nilai, " class=masukan  size=4" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Pengurangan Nilai Jika Salah</td>\r\n\t\t\t<td>".createinputtext( "nilaisalah", $nilaisalah, " class=masukan  size=4" )."</td>\r\n\t\t</tr>\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
       # echo "AAA".$d[JENIS];exit();
		if ( $d[JENIS] == 1 )
        {
            $cekbenar = $ceksalah = $cektidakjawab = "";
            if ( $arrayjawabanmahasiswa[$d[ID]] == "B" )
            {
                $cekbenar = "checked";
            }
            else if ( $arrayjawabanmahasiswa[$d[ID]] == "S" )
            {
                $ceksalah = "checked";
            }
            else if ( $arrayjawabanmahasiswa[$d[ID]] == "" )
            {
                $cektidakjawab = "checked";
                $bgjawaban = $statussimpanjawaban = "";
            }
            $daftarjawaban = "\r\n               <tr  id='hasiljawaban{$i}'  {$bgjawaban} >\r\n                <td align=left  >Jawaban </td>\r\n                <td align=left>\r\n                  <input type=radio  name='previewjawaban{$d['ID']}' value=B {$cekbenar} > BENAR <br>\r\n                  <input type=radio   name='previewjawaban{$d['ID']}' value=S {$ceksalah} > SALAH <br>\r\n                  <input type=radio   name='previewjawaban{$d['ID']}' value='' {$cektidakjawab} > TIDAK MENJAWAB <br> <br>\r\n                  <div id='hasiljawaban2{$i}'>{$statussimpanjawaban}</div>\r\n                </td>\r\n              </tr>\r\n            ";
        }
        else if ( $d[JENIS] == 0 )
        {
			#echo "aaa";exit();
            if ( $arrayjawabanmahasiswa[$d[ID]] == "" )
            {
                $cek = "checked";
                $bgjawaban = $statussimpanjawaban = "";
            }
            $daftarjawaban = "<tr  id='hasiljawaban{$i}' {$bgjawaban} >\r\n                <td align=left >Jawaban</td>\r\n                <td align=left>";
            $cek = "";
            $ii = 1;
            while ( $ii <= 6 )
            {
				echo "BBB".$ii.'<br>';
                if ( $d["JAWABAN{$ii}"] != "" )
                {
					echo $d["JAWABAN{$ii}"].'<br>';
					echo $d['ID'].'<br>';
					#echo "MMM".$arrayjawabanmahasiswa[$d[ID]].'<br>';
                    if ( $arrayjawabanmahasiswa[$d[ID]] == $ii )
                    {
						#echo "lll";exit();
                        $cek = "checked";
                    }
                    $daftarjawaban .= "".chr( $ii + 64 ).". <input type=radio name='previewjawaban{$d['ID']}' value='{$ii}' $cek> ".htmlspecialchars_decode( $d["JAWABAN{$ii}"] )." <br>\r\n                  ";
                    $cek = "";
                }
                ++$ii;
            }
			#exit();
            if ( $arrayjawabanmahasiswa[$d[ID]] == "" )
            {
                $cek = "checked";
                $bgjawaban = $statussimpanjawaban = "";
            }
            $daftarjawaban .= "\r\n                  ".chr( $ii + 64 )."     <input type=radio name='previewjawaban{$d['ID']}' value='' {$cek} > TIDAK MENJAWAB <br> <br>\r\n                    <div id='hasiljawaban2{$i}'>{$statussimpanjawaban}</div>\r\n                </td>\r\n              </tr>\r\n            ";
        }
        printjudulmenukecil( "PREVIEW" );
        echo "\r\n \r\n\r\n       <table  >\r\n           <tr>\r\n            <td align=left  >Soal  </td>\r\n            <td align=left>".htmlspecialchars_decode( $d[PERTANYAAN] )."\r\n            ";
        if ( $d[GAMBAR] != "" && file_exists( "../ujianpmb/gambar/{$d['GAMBAR']}" ) )
        {
            echo "<br><img src='../ujianpmb/gambar/{$d['GAMBAR']}' width=400><br> ";
        }
        echo "\r\n            \r\n            </td>\r\n          </tr>\r\n          ";
        echo "\r\n           {$daftarjawaban}\r\n \r\n        </table>\r\n";
    }
    else
    {
        printmesg( "Data bank soal tidak ada!" );
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", TAMBAH_DATA );
    }
    else if ( trim( $gelombang ) == "" )
    {
        $errmesg = "Gelombang harus diisi";
    }
    else if ( trim( $pertanyaan ) == "" )
    {
        $errmesg = "Isi Pertanyaan harus diisi";
    }
    else if ( $jenis == "B" && $kuncibs == "" )
    {
        $errmesg = "Kunci Jawaban harus diisi";
    }
    else if ( $jenis == "P" && $kunci == "" )
    {
        $errmesg = "Kunci Jawaban harus diisi";
    }
    else if ( $jenis == "P" && ( $jawaban1 == "" || $jawaban2 == "" || $jawaban3 == "" || $jawaban4 == "" ) )
    {
        $errmesg = "Jawaban harus diisi";
    }
    else
    {
        $q = "INSERT INTO banksoalpmb (TAHUN,GELOMBANG,FAKULTAS,IDBIDANG,PERTANYAAN,GAMBAR,NILAI,NILAISALAH,JENIS,JAWABAN1,JAWABAN2,JAWABAN3,JAWABAN4,JAWABAN5,".
		"JAWABAN6,KUNCIBS,UPDATER,TANGGALUPDATE,KUNCI) VALUES ( '{$tahuna}',  '{$gelombang}',  '{$idfakultas}',  '{$idbidang}',  '{$pertanyaan}',  '',  '{$nilai}',  '{$nilaisalah}',  '{$jenis}', \r\n '{$jawaban1}',  '{$jawaban2}',  '{$jawaban3}',  '{$jawaban4}',  '{$jawaban5}',  '{$jawaban6}',  '{$kuncibs}',  '{$users}',  NOW(),  '{$kunci}');\t\t    \r\n \r\n\t\t";
        #echo $q;exit();
		mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            if ( $filegambar != "" )
            {
                $id = mysqli_insert_id( $koneksi );
                $ext = get_file_extension( $filegambar_name );
                @move_uploaded_file( @$filegambar, @"gambar/{$id}.{$ext}" );
                $qgambar = ",GAMBAR='{$id}.{$ext}'  ";
                $q = "UPDATE banksoalpmb SET GAMBAR='{$id}.{$ext}' WHERE ID='{$id}' ";
                mysqli_query($koneksi,$q);
            }
            $errmesg = "Data Bank Soal PMB berhasil ditambah";
            $data = "";
            $id = $pertanyaan = $kunci = $kuncibs = $nilai = $nilaisalah = $jawaban1 = $jawaban2 = $jawaban3 = $jawaban4 = $jawaban5 = $jawaban6 = "";
        }
        else
        {
            $errmesg = "Data Bank Soal PMB tidak berhasil ditambah";
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
	#echo "aaa";exit();
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Data Bank Soal" );
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Angkatan/Tahun Daftar</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $tahuna, " class=masukan " )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang</td>";
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    if ( $tahuna == "" )
    {
        $tahuna = $w[year];
    }
    if ( $idpilihan == "" )
    {
        $idpilihan = $arraypilihan[$initidpilihan];
    }
    unset( $arrayfakultas[''] );
    echo "\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Fakultas</td>\r\n\t\t\t<td>".createinputselect( "idfakultas", $arrayfakultas, $idfakultas, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Bidang Soal</td>\r\n\t\t\t<td>".createinputselect( "idbidang", $arraybidangsoal, $idbidang, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n\r\n     \r\n     \r\n \r\n\r\n \r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Isi Pertanyaan</td>\r\n\t\t\t<td><textarea name=pertanyaan class=mce cols=60 rows=20>{$pertanyaan}</textarea></td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Gambar untuk ditampilkan</td>\r\n\t\t\t<td><input type=file class=masukan name=filegambar ></td>\r\n\t\t</tr> \r\n \r\n \r\n";
    $jenis = "";
    if ( $jenis == "" || $jenis == 0 )
    {
        $cekganda = "checked";
    }
    else if ( $jenis == 1 )
    {
        $cekbs = "checked";
    }
    echo "\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>";
    echo "\r\n    <tr class=judulform>\r\n\t\t\t<td  width=250>Jenis Soal</td>\r\n\t\t\t<td>\r\n      <input type=radio  name=jenis value=0 {$cekganda}  onclick=\"showHideJenisBankSoalPmb(this.value); \"> Pilihan Ganda\r\n      <input type=radio  name=jenis value=1 {$cekbs}   onclick=\"showHideJenisBankSoalPmb(this.value); \" > Benar/Salah\r\n      </td>\r\n\t\t</tr>\r\n    </table>";
    echo "\r\n<div id=pilihanganda  >\r\n  <table>\r\n";
    $i = 1;
    while ( $i <= 6 )
    {
        if ( $kunci == $i )
        {
            ${ "cekkunci".$i } = "checked";
        }
		#echo $cekkunci.$i;exit(); 
       # echo "\r\n    <tr class=judulform>\r\n\t\t\t<td  width=250>Jawaban ".chr( $i + 64 )."</td>\r\n\t\t\t<td>\r\n      <textarea name='jawaban{$i}' class=mce cols=40 rows=4>".$"jawaban{$i}"."</textarea>\r\n \r\n      <input type=radio name=kunci value='{$i}' ".${ "cekkunci".$i }."> Kunci Jawaban\r\n      </td>\r\n\t\t</tr>\r\n\t\r\n    ";
		echo "<tr class=judulform><td  width=250>Jawaban ".chr( $i + 64 )."</td><td><textarea name='jawaban{$i}' class=mce cols=40 rows=4>".$jawaban{$i}."</textarea><input type=radio name=kunci value=$i ${ "cekkunci".$i }> Kunci Jawaban";
       	
	   ++$i;
    }
    echo "\t</table>\r\n</div> ";
    if ( $kuncibs == "B" )
    {
        $cekkuncibsb = "checked";
    }
    else if ( $kuncibs == "S" )
    {
        $cekkuncibss = "checked";
    }
    echo "\r\n<div id=benarsalah style='display:none;' >\r\n  <table  >\r\n    <tr class=judulform>\r\n\t\t\t<td  width=250>Jawaban </td>\r\n\t\t\t<td > \r\n      <input type=radio name=kuncibs value='B' {$cekkuncibsb}  > BENAR\r\n      <input type=radio name=kuncibs value='S' {$cekkuncibss}  > SALAH\r\n      </td>\r\n\t\t</tr>\r\n\t\t</table>\r\n</div>\r\n    <table>\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>    \r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Nilai Jika Benar</td>\r\n\t\t\t<td>".createinputtext( "nilai", $nilai, " class=masukan  size=4" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Pengurangan Nilai Jika Salah</td>\r\n\t\t\t<td>".createinputtext( "nilaisalah", $nilaisalah, " class=masukan  size=4" )."</td>\r\n\t\t</tr>\r\n      <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
	#echo "kk";exit();
    $aksi = " ";
    include( "prosestampilbanksoalpmb.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Data Bank Soal PMB " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td width=200 >\r\n\t\t\t\t\tTahun Masuk/Angkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "  \r\n\t\t\t\t\t\t<select name=tahunmasuk class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $tahunmasuk == $i )
        {
            $cek = "selected";
        }
        else if ( $tahunmasuk == "" && $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Gelombang</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."\r\n  \t\t\t</td>\r\n\t\t</tr>\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Fakultas</td>\r\n\t\t\t<td>".createinputselect( "fakultas", $arrayfakultas, $fakultas, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n \r\n";
    $arraybidangsoal[''] = "Semua";
    ksort( $arraybidangsoal );
    echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Bidang Soal</td>\r\n\t\t\t<td>".createinputselect( "idbidang", $arraybidangsoal, $idbidang, "", " class=masukan" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Jenis Soal</td>\r\n\t\t\t<td>\r\n      <input type=radio name=jenis value=0 {$cekganda}> Pilihan Ganda\r\n      <input type=radio name=jenis value=1 {$cekbs}> Benar/Salah\r\n      </td>\r\n\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \r\n\t";
}
?>
