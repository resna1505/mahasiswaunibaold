<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
$arraytabel2[0] = "mahasiswa2";
$arraytabel2[1] = "dosen2";
$arraytabel[0] = "Mahasiswa";
$arraytabel[1] = "Dosen";
$arraytipefieldsql[0] = "VARCHAR";
$arraytipefieldsql[1] = "TINYTEXT";
$arraytipefieldsql[2] = "ENUM";
$arraytipefieldsql[3] = "SET";
$arraytipefieldsql[4] = "DATE";
$arraytipefieldsql[5] = "TIME";
$arraytipefieldsql[6] = "TINYTEXT";
$arraytipefieldsql[7] = "TINYTEXT";
$arraytipefieldsql[8] = "INT";
$arraytipefieldsql[9] = "FLOAT";
$arraytipefieldsql[99] = "TINYTEXT";
$arraytipefield[0] = "Teks";
$arraytipefield[1] = "Teks Area";
$arraytipefield[8] = "Bilangan Bulat";
$arraytipefield[9] = "Bilangan Real";
$arraytipefield[2] = "Pilihan Tunggal";
$arraytipefield[3] = "Himpunan";
$arraytipefield[4] = "Tanggal";
$arraytipefield[5] = "Jam";
$arraytipefield[6] = "Image (jpeg)";
$arraytipefield[7] = "File Upload";
$arraytipefield[99] = "Pemisah";
if ( $aksi == 1 )
{
    if ( $aksi2 == "Tambah" )
    {
        if ( $_SESSION['token'] == $_POST['sessid'] )
        {
            unset( $_SESSION['token'] );
            cekhaktulis( $kodemenu );
            if ( trim( $idbaru ) == "" )
            {
                $errmesg = "Nama Field harus diisi";
            }
            else
            {
                $letak2 = "";
                if ( $letak == 0 )
                {
                    $letak2 = "FIRST";
                }
                else if ( $letak == 2 )
                {
                    $letak2 = "AFTER {$idletak} ";
                }
                $atribut2 = "";
                $comment = "";
                $idbaru2 = str_replace( " ", "_", strtoupper( trim( $idbaru ) ) );
                if ( $tipe == 0 )
                {
                    if ( $atribut <= 0 )
                    {
                        $atribut = 50;
                    }
                    $atribut2 = "({$atribut})";
                }
                else if ( $tipe == 9 )
                {
                    if ( $atribut != "" )
                    {
                        $atribut2 = "({$atribut})";
                    }
                }
                else if ( $tipe == 2 )
                {
                    $tmp = explode( ",", str_replace( "'", "", trim( $atribut ) ) );
                    $atribut2 = "(";
                    foreach ( $tmp as $v )
                    {
                        $atribut2 .= "'".trim( $v )."',";
                    }
                    $atribut2 .= ")";
                    $atribut2 = str_replace( ",)", ")", $atribut2 );
                }
                else if ( $tipe == 3 )
                {
                    $tmp = explode( ",", str_replace( "'", "", trim( $atribut ) ) );
                    $atribut2 = "(";
                    foreach ( $tmp as $v )
                    {
                        $atribut2 .= "'".trim( $v )."',";
                    }
                    $atribut2 .= ")";
                    $atribut2 = str_replace( ",)", ")", $atribut2 );
                }
                else if ( $tipe == 6 )
                {
                    $comment = "FOTO";
                }
                else if ( $tipe == 7 )
                {
                    $comment = "FILE";
                }
                else if ( $tipe == 99 )
                {
                    $comment = "PEMISAH";
                }
                $q = "ALTER TABLE ".$arraytabel2[$tabel]." \r\n           ADD COLUMN  {$idbaru2} ".$arraytipefieldsql[$tipe]."{$atribut2} NOT NULL COMMENT  '{$comment}' {$letak2} ";
                if ( mysqli_query($koneksi,$q) )
                {
                    $errmesg = "Field {$idbaru2} berhasil ditambah.";
                }
                else
                {
                    $errmesg = "Field {$idbaru2} tidak berhasil ditambah. Perbaiki nama field";
                }
            }
        }
        else
        {
            $errmesg = token_err_mesg( "Field", TAMBAH_DATA );
        }
    }
    if ( $aksi2 == "Simpan Pilihan" )
    {
        if ( $_SESSION['token'] == $_POST['sessid'] )
        {
            unset( $_SESSION['token'] );
            cekhaktulis( $kodemenu );
            if ( is_array( $arraypilih ) )
            {
                $q = "ALTER TABLE ".$arraytabel2[$tabel];
                foreach ( $arraypilih as $k => $v )
                {
                    if ( $k != "ID" )
                    {
                        $idbaru2 = str_replace( " ", "_", strtoupper( trim( $arrayid[$k] ) ) );
                        $atribut2 = $comment = "";
                        if ( $arraytipe[$k] == 0 )
                        {
                            if ( $arrayatribut[$k] <= 0 )
                            {
                                $arrayatribut[$k] = 50;
                            }
                            $atribut2 = "({$arrayatribut[$k]})";
                        }
                        else if ( $arraytipe[$k] == 9 )
                        {
                            if ( $arrayatribut[$k] != "" )
                            {
                                $atribut2 = "({$arrayatribut[$k]})";
                            }
                        }
                        else if ( $arraytipe[$k] == 2 )
                        {
                            $tmp = explode( ",", str_replace( "'", "", trim( $arrayatribut[$k] ) ) );
                            $atribut2 = "(";
                            foreach ( $tmp as $v )
                            {
                                $atribut2 .= "'".trim( $v )."',";
                            }
                            $atribut2 .= ")";
                            $atribut2 = str_replace( ",)", ")", $atribut2 );
                        }
                        else if ( $arraytipe[$k] == 3 )
                        {
                            $tmp = explode( ",", str_replace( "'", "", trim( $arrayatribut[$k] ) ) );
                            $atribut2 = "(";
                            foreach ( $tmp as $v )
                            {
                                $atribut2 .= "'".trim( $v )."',";
                            }
                            $atribut2 .= ")";
                            $atribut2 = str_replace( ",)", ")", $atribut2 );
                        }
                        else if ( $tipe == 6 )
                        {
                            $comment = "FOTO";
                        }
                        else if ( $tipe == 7 )
                        {
                            $comment = "FILE";
                        }
                        else if ( $tipe == 99 )
                        {
                            $comment = "PEMISAH";
                        }
                        if ( $arraycari[$k] == 1 )
                        {
                            $comment .= " CARI";
                        }
                        $q .= " CHANGE {$k} {$idbaru2} ".$arraytipefieldsql[$arraytipe[$k]]."{$atribut2} NOT NULL COMMENT '{$comment}',";
                    }
                }
                $q = trim( $q, "," );
                if ( mysqli_query($koneksi,$q) )
                {
                    $errmesg = "Data Field berhasil disimpan. ".sqlaffectedrows( $koneksi )." data diubah";
                }
                else
                {
                    $errmesg = "Data Field tidak berhasil disimpan.";
                }
            }
        }
        else
        {
            $errmesg = token_err_mesg( "Field", SIMPAN_DATA );
        }
    }
    if ( $aksi2 == "Hapus Pilihan" )
    {
        if ( $_SESSION['token'] == $_POST['sessid'] )
        {
            unset( $_SESSION['token'] );
            cekhaktulis( $kodemenu );
            if ( is_array( $arraypilih ) )
            {
                $q = "ALTER TABLE ".$arraytabel2[$tabel];
                foreach ( $arraypilih as $k => $v )
                {
                    if ( $k != "ID" )
                    {
                        $q .= " DROP {$k},";
                    }
                }
                $q = trim( $q, "," );
                if ( mysqli_query($koneksi,$q) )
                {
                    $errmesg = "Data Field berhasil dihapus. ".sqlaffectedrows( $koneksi )." data terhapus";
                }
                else
                {
                    $errmesg = "Data Field tidak berhasil dihapus.";
                }
            }
        }
        else
        {
            $errmesg = token_err_mesg( "Field", HAPUS_DATA );
        }
    }
    if ( $tabel != "" )
    {
        printjudulmenu( "Kelola Field Bebas Data ".$arraytabel[$tabel] );
        printmesg( $errmesg );
        $q = "SHOW TABLES LIKE '{$arraytabel2[$tabel]}'";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $q = "CREATE TABLE ".$arraytabel2[$tabel]." (\r\n          ID CHAR(20) NOT NULL PRIMARY KEY\r\n        )";
            mysqli_query($koneksi,$q);
        }
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        echo "\r\n    <form action=index.php method=post onSubmit=\"return confirm('Lakukan Perubahan?');\">\r\n      <input type=hidden name='pilihan' value='{$pilihan}'>\r\n      <input type=hidden name='aksi' value='{$aksi}'>\r\n      <input type=hidden name='sessid' value='{$token}'>\r\n      <input type=hidden name='tabel' value='{$tabel}'>\r\n    ";
        $q = "SHOW FULL COLUMNS FROM ".$arraytabel2[$tabel]."";
        $h = mysqli_query($koneksi,$q);
        echo "<table class=form>\r\n        <tr align=center class=juduldata>\r\n          <td>No</td>\r\n          <td>Nama Field</td>\r\n          <td>Tipe</td>\r\n          <td>Ukuran/Atribut</td>\r\n          <td>Sisipkan di </td>\r\n          <td></td>\r\n        </tr>\r\n        <tr valign=top>\r\n          <td align=center>*</td>\r\n          <td><input type=text size=20 name=idbaru value=''></td>\r\n          <td>".createinputselect( "tipe", $arraytipefield, $tipe, "", "" )."</td>\r\n          <td><input type=text size=40 name=atribut value=''></td>\r\n          <td nowrap>\r\n          <input type=radio name=letak value=0>Awal <br>\r\n          <input type=radio name=letak value=1 checked>Akhir <br>";
        $q = "SHOW FULL COLUMNS FROM ".$arraytabel2[$tabel]."";
        $h2 = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h2 ) )
        {
            echo "\r\n                <input type=radio name=letak value=2>Setelah\r\n                <select name=idletak>\r\n                  ";
            while ( $d2 = sqlfetcharray( $h2 ) )
            {
                if ( $d2[0] != "ID" )
                {
                    echo "<option value='".trim( $d2[0] )."'>".trim( $d2[0] )."</option>";
                }
            }
            echo "\r\n                </select>";
        }
        echo "\r\n          </td>\r\n          <td align=right><input type=submit name=aksi2 value='Tambah'></td>\r\n        </tr>";
        if ( 1 < sqlnumrows( $h ) )
        {
            echo "<tr align=center class=juduldata>\r\n          <td>No</td>\r\n          <td>Nama Field</td>\r\n          <td>Tipe</td>\r\n          <td>Ukuran/Atribut</td>\r\n          <td>Lain2</td>\r\n          <td>Pilih</td>\r\n        </tr>\r\n      ";
            $i = 0;
            $contohtabeltampilan = "\r\n        <b>Contoh Tampilan</b>\r\n      <table class=form  >\r\n        <tr align=center class=juduldata>\r\n           <td>Nama Field</td>\r\n          <td>Isian</td>\r\n         </tr>      \r\n      ";
            while ( $d = sqlfetcharray( $h ) )
            {
                if ( $d[0] != "ID" )
                {
                    $kelas = kelas( $i );
                    ++$i;
                    $atribut = $contohtampilan = "";
                    $hasil = getmetadata( $d, "contoh", "", "readonly" );
                    $tipe = $hasil[tipe];
                    $atribut = $hasil[atribut];
                    $contohtampilan = $hasil[contohtampilan];
                    $cari = $hasil[cari];
                    echo " \r\n          <tr valign=top {$kelas}>\r\n            <td align=center>{$i}</td>\r\n            <td><input type=text size=20 name='arrayid[{$d['0']}]' value='{$d['0']}'></td>\r\n            <td>".createinputselect( "arraytipe[{$d['0']}]", $arraytipefield, $tipe, "", "" )."</td>\r\n            <td><input type=text size=40 name='arrayatribut[{$d['0']}]' value='{$atribut}'></td>\r\n            <td>";
                    $cekcari = "";
                    if ( $tipe != 99 && $tipe != 6 && $tipe != 7 )
                    {
                        if ( $cari == 1 )
                        {
                            $cekcari = "checked";
                        }
                        echo "\r\n              <input type=checkbox name='arraycari[{$d['0']}]' value=1 {$cekcari}> Pencarian            </td>";
                    }
                    echo "\r\n          <td align=left><input type=checkbox name='arraypilih[{$d['0']}]' value='1'></td>\r\n          </tr>\r\n          ";
                    if ( $hasil[tipe] != 99 )
                    {
                        $contohtabeltampilan .= "\r\n            <tr valign=top {$kelas} >\r\n               <td width=150> ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." </td>\r\n              <td>{$contohtampilan}</td>\r\n            </tr>\r\n            ";
                    }
                    else
                    {
                        $contohtabeltampilan .= "\r\n            <tr valign=top {$kelas} >\r\n                <td colspan=2 nowrap>{$contohtampilan}</td>\r\n            </tr>\r\n            ";
                    }
                }
            }
            $contohtabeltampilan .= "</table>";
            echo "\r\n        <tr  >\r\n          <td align=center> </td>\r\n          <td> </td>\r\n          <td> </td>\r\n           <td colspan=3 align=right>\r\n          <input type=submit name=aksi2 value='Simpan Pilihan'>\r\n          <input type=submit name=aksi2 value='Hapus Pilihan'>\r\n          </td>\r\n        </tr>";
        }
        echo "</table>\r\n      \r\n      {$contohtabeltampilan}\r\n      ";
        echo "</form>";
    }
    else
    {
    }
}
if ( !( $tabel == 1 ) || $aksi == "" )
{
    printjudulmenu( "Kelola Field Bebas" );
    echo "<ul>";
    foreach ( $arraytabel as $k => $v )
    {
        echo "<li><a href='index.php?pilihan={$pilihan}&aksi=1&tabel={$k}'>{$v}</a></li>";
    }
    echo "</ul>";
}
?>
