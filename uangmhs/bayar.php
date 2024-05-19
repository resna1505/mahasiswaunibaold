<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT * FROM aturan ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $aturankeuangan = $d2[KRSONLINE];
}
#printjudulmenu( "Pembayaran Keuangan Mahasiswa" );
if ( $aksi2 == "hapus" && ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) ) )
{
    $q = "DELETE FROM bayarkomponen WHERE ID='{$idhapus}'";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data berhasil dihapus";
        $q = "SELECT ID FROM transkeuangan WHERE KODE='BK-{$idhapus}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $q = "DELETE FROM detilkeuangansgm WHERE IDTRANS='{$d['ID']}'";
            mysqli_query($koneksi,$q);
            $q = "DELETE FROM transkeuangan WHERE ID='{$d['ID']}'";
            mysqli_query($koneksi,$q);
        }
    }
}
if ( $aksi == "Simpan" && $REQUEST_METHOD == POST )
{
    if ( is_array( $pilihbayar ) )
    {
        if ( $manual == 1 )
        {
            $arraybayar2 = $arraybayar;
        }
        else
        {
            $arraybayar2 = $biayak;
        }
        $jmltambah = 0;
        $aksilanjut = "";
        $q = "SELECT NAMA,ANGKATAN,IDPRODI,GELOMBANG, JENISKELAS FROM mahasiswa WHERE ID='{$idmahasiswa}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $angkatan = $d[ANGKATAN];
        $idprodi = $d[IDPRODI];
        $gelombang = $d[GELOMBANG];
        $jeniskelas = $d[JENISKELAS];
        foreach ( $pilihbayar as $k => $v )
        {
            if ( $aksilanjut == "" )
            {
                if ( $tahunbayar[$k] == "" || $angkatan < $tahunbayar[$k] )
                {
                    $q = "SELECT SUM(JUMLAH) AS JML FROM bayarkomponen WHERE\r\n            IDMAHASISWA='{$idmahasiswa}' AND\r\n            IDKOMPONEN='{$k}' AND\r\n            TAHUNAJARAN='".$tahunbayar[$k]."' AND\r\n            SEMESTER='".$arraysemesterbayar[$k]."'\r\n            ";
                    $h = mysqli_query($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $pernahdibayar = $d[JML];
                    $q = "SELECT SUM(BIAYA) AS JML FROM biayakomponen WHERE\r\n            IDPRODI='{$idprodi}' AND\r\n            IDKOMPONEN='{$k}' AND\r\n            ANGKATAN='".$angkatan."' AND\r\n            GELOMBANG='".$gelombang."'\r\n            ";
                    $h = mysqli_query($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $harusdibayar = $d[JML];
                    $diskonbayar = 0;
                    if ( $aturankeuangan == 3 )
                    {
                        if ( $k == 99 )
                        {
                            $jumlahsks = getjumlahsks( $idmahasiswa, $tahunbayar[$k], $arraysemesterbayar[$k] );
                            $jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahunbayar[$k], $arraysemesterbayar[$k] );
                            $skslebih = 0;
                            if ( $jumlahskswajib < $jumlahsks )
                            {
                                $skslebih = $jumlahsks - $jumlahskswajib;
                            }
                            $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n            \t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n              \t\t  mahasiswa.ID='{$idmahasiswa}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='99'\r\n            \t\t\t \r\n            \t\t";
                            $ht = mysqli_query($koneksi,$q);
                            $dt = sqlfetcharray( $ht );
                            $biayakomponen = $dt[TOTAL] + 0;
                            if ( $BIAYASKSKULIAH == 1 )
                            {
                                $biaya = $jumlahsks * $biayakomponen;
                            }
                            else
                            {
                                $biaya = $skslebih * $biayakomponen;
                            }
                            $harusdibayar = $biaya;
                        }
                        $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$k}' ";
                        $hdiskon = mysqli_query($koneksi,$q);
                        echo mysqli_error($koneksi);
                        if ( 0 < sqlnumrows( $hdiskon ) )
                        {
                            $ddiskon = sqlfetcharray( $hdiskon );
                            $diskonbeasiswa = $ddiskon[DISKON];
                            $diskonbayar = $diskonbeasiswa * $harusdibayar / 100;
                        }
                    }
                    $sisa = $harusdibayar - $diskonbayar - $pernahdibayar;
                    if ( 0 < $sisa && $arraybayar2[$k] <= $sisa )
                    {
                        $q = "INSERT INTO bayarkomponen \r\n        \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n              TANGGAL,USER,TGLUPDATE,DENDA,BIAYA)\r\n        \t\t\tVALUES \r\n        \t\t\t('{$idmahasiswa}','{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','{$k}','".$jenisk[$k]."',\r\n        \t\t\t'".$arraybayar2[$k]."','".$arrayket[$k]."',\r\n        \t\t\t'".$tahunbayar[$k]."','".$arraysemesterbayar[$k]."','{$carabayar}','".$arraydiskon[$k]."',\r\n              NOW(),'{$users}',NOW(),'".$arraydenda[$k]."','".$biayak[$k]."')";
                        mysqli_query($koneksi,$q);
                        echo mysqli_error($koneksi);
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            $idbayar = mysqli_insert_id($koneksi);
                            $ketlog = "Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen={$k} (".$arraybayar2[$k]."),ID Mahasiswa={$idmahasiswa},\r\n        \t\t\t\tTanggal bayar={$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}\r\n        \t\t\t\t";
                            buatlog( 54 );
                            ++$jmltambah;
                            $jenisjurnal = $arrayakunjenisjurnal[$carabayar];
                            $q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
                            $h = mysqli_query($koneksi,$q);
                            $d = sqlfetcharray( $h );
                            if ( $d[MAX] == "" )
                            {
                                $idbaru = 1;
                            }
                            else
                            {
                                $idbaru = $d[MAX] + 1;
                            }
                            $q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}','{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}',\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$k]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar[$k]." \\ ".$arraysemesterbayar[$k]." \r\n                            ".$arrayket[$k]." ','{$users}',NOW(),'BK-{$idbayar}')";
                            mysqli_query($koneksi,$q);
                            if ( 0 < sqlaffectedrows( $koneksi ) )
                            {
                                $q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
                                $h = mysqli_query($koneksi,$q);
                                $d = sqlfetcharray( $h );
                                if ( $d[MAX] == "" )
                                {
                                    $iddetilbaru = 0;
                                }
                                else
                                {
                                    $iddetilbaru = $d[MAX] + 1;
                                }
                                if ( $carabayar == 0 )
                                {
                                    $idakun = $arrayakun[kas];
                                }
                                else
                                {
                                    $idakun = $arrayakun[bank];
                                }
                                $q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$arraybayar2[$k]."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$k]." mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar[$k]." \\ ".$arraysemesterbayar[$k]." \r\n                            ".$arrayket[$k]." ','D')\r\n                              ";
                                mysqli_query($koneksi,$q);
                                $q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
                                $h = mysqli_query($koneksi,$q);
                                $d = sqlfetcharray( $h );
                                if ( $d[MAX] == "" )
                                {
                                    $iddetilbaru = 0;
                                }
                                else
                                {
                                    $iddetilbaru = $d[MAX] + 1;
                                }
                                $q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$arraybayar2[$k]."','{$tanda}','".$arrayakun[pendapatan]."-{$k}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$k]."  mahasiswa dengan NIM {$idmahasiswa} ".$tahunbayar[$k]." \\ ".$arraysemesterbayar[$k]." \r\n                            ".$arrayket[$k]." ','K')\r\n                              ";
                                mysqli_query($koneksi,$q);
                            }
                        }
                    }
                    else
                    {
                        $errmesg2 .= "<br>Jumlah yang dibayar (".$arraybayar2[$k].") melebihi sisa yg harus dibayar ({$sisa}).";
                    }
                }
            }
            else if ( $aksilanjut == "edit" )
            {
                $q = "\r\n\t\t\t\t\tUPDATE bayarkomponen SET \r\n\t\t\t\t\tJUMLAH='".$arraybayar2[$k]."',\r\n\t\t\t\t\tBIAYA='".$biayak[$k]."',\r\n\t\t\t\t\tDISKON='".$arraydiskon[$k]."',\r\n\t\t\t\t\tDENDA='".$arraydenda[$k]."',\r\n\t\t\t\t\tKET='".$arrayket[$k]."',\r\n\t\t\t\t\tTAHUNAJARAN='".$tahunbayar[$k]."',\r\n\t\t\t\t\tSEMESTER='".$arraysemesterbayar[$k]."',\r\n\t\t\t\t\tUSER='{$users}',\r\n\t\t\t\t\tTGLUPDATE=NOW()\r\n\t\t\t\t\tWHERE IDMAHASISWA='{$idmahasiswa}' \r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDKOMPONEN='{$k}' AND TANGGALBAYAR='{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}'  \r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                $ketlog = "Update Pembayaran dengan \r\n\t\t\t\tID Komponen={$k} (".$arraybayar2[$k]."),ID Mahasiswa={$idmahasiswa},\r\n\t\t\t\tTanggal bayar={$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}\r\n\t\t\t\t";
                buatlog( 55 );
            }
        }
        if ( 0 < $jmltambah )
        {
            $aksilanjut = "edit";
            $errmesg = "Data Pembayaran sudah disimpan. {$errmesg2}";
        }
        else
        {
            $errmesg = "Data Pembayaran tidak disimpan. {$errmesg2}";
        }
    }
    else
    {
        $errmesg = "Tidak ada komponen yang dipilih. Data Pembayaran tidak disimpan";
    }
    $aksi = "Lanjut";
}
if ( $aksi == "Lanjut" )
{
    if ( trim( $idmahasiswa ) == "" )
    {
        $errmesg = "NIM harus diisi";
        $aksi = "";
    }
    else if ( !istanggal( $tglbayar[tgl], $tglbayar[bln], $tglbayar[thn], "" ) )
    {
        $errmesg = "Tanggal pembayaran salah";
        $aksi = "";
    }
    else
    {
        printmesg( $errmesg );
        $q = "SELECT NAMA,ANGKATAN,IDPRODI,GELOMBANG FROM mahasiswa WHERE ID='{$idmahasiswa}' AND STATUS!='L' ";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $errmesg = "Tidak ada mahasiswa dengan NIM '{$idmahasiswa}', atau mahasiswa ybs sudah lulus.";
            $aksi = "";
        }
        else
        {
            $data = sqlfetcharray( $h );
            echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Pembayaran Keuangan Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
                        
            echo "\r\n\t\t\t\t<form name=form action=index.php method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t\t\t\t<input type=hidden name=aksilanjut value='{$aksilanjut}'>\r\n\t\t \t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=200>NIM</td>\r\n\t\t\t\t\t\t<td><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td><b>{$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td><b>{$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t\t\t\t<td><b>{$data['GELOMBANG']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t\t\t<td><b>".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<b>{$tglbayar['tgl']} ".$arraybulan[$tglbayar[bln] - 1]." {$tglbayar['thn']}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Cara Bayar </td>\r\n\t\t\t\t\t\t<td><b>".$arraycarabayar[$carabayar]."\r\n\t\t\t\t\t\t<input type=hidden name=carabayar value='{$carabayar}'>\r\n            \r\n            </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
            $i = 0;
            while ( $i < $count )
            {
                $str = "jeniskomponen_{$i}";
                $k = $$str;
                $jeniskomponen[$k] = 1;
                ++$i;
            }
            $href = "tahunajaran={$tahunajaran}&tahunajaran2={$tahunajaran2}&semesterbayar={$semesterbayar}&bulanbayar={$bulanbayar}&";
            $qinput .= "<input type=hidden name='tahunajaran' value='{$tahunajaran}'>";
            $qinput .= "<input type=hidden name='tahunajaran2' value='{$tahunajaran2}'>";
            $qinput .= "<input type=hidden name='semesterbayar' value='{$semesterbayar}'>";
            $qinput .= "<input type=hidden name='bulanbayar' value='{$bulanbayar}'>";
            if ( is_array( $jeniskomponen ) )
            {
                $qkomponen = " AND (  ";
                foreach ( $jeniskomponen as $k => $v )
                {
                    $qinput .= "<input type=hidden name='jeniskomponen[{$k}]' value=1>";
                    $qkomponen .= " IDKOMPONEN='{$k}' OR";
                    $href .= "jeniskomponen[{$k}]=1&";
                }
                $qkomponen .= ")";
                $qkomponen = str_replace( "OR)", ")", $qkomponen );
            }
            $q = "SELECT komponenpembayaran.* {$field99}  ,  biayakomponen.BIAYA,\r\n       biayakomponen.TANGGAL,biayakomponen.DENDA,\r\n       biayakomponen.JENISDENDA \r\n\t\t\t \r\n\t\t\tFROM komponenpembayaran,biayakomponen\r\n\t\t\tWHERE \r\n\t\t \tkomponenpembayaran.ID=biayakomponen.IDKOMPONEN AND\r\n\t\t \tANGKATAN='{$data['ANGKATAN']}' AND\r\n\t\t \tIDPRODI='{$data['IDPRODI']}' AND\r\n\t\t \tGELOMBANG='{$data['GELOMBANG']}'\r\n\t\t \t{$qkomponen}\r\n\t\t \t{$where992}\r\n\t\t\tORDER BY komponenpembayaran.ID";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                printjudulmenukecil( "Komponen Pembayaran" );
                echo "\r\n\t\t \t\t\t<table   class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td colspan=9 align=right>\r\n\t\t\t\t\t\t<input type=checkbox name=manual value=1 checked>biaya manual <input class=masukan type=submit name=aksi value=Simpan>\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t\t</td>\r\n\t\t \t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>Jenis</td>\r\n\t\t\t\t\t\t<td>Waktu</td>\r\n\t\t\t\t\t\t<td>Biaya<br>Rp.</td>\r\n\t\t\t\t\t\t<!-- <td>Sudah<br>Dibayar<br>Rp.</td> -->\r\n\t\t\t\t\t\t<td>Dibayar<br>Saat Ini<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Diskon<br>Rp.</td>\r\n\t\t\t\t\t\t<!-- <td>Sisa<br>Rp.</td> -->\r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t\t<td>Ket</td>\r\n\t\t \t\t\t</tr>\r\n\t\t\t\t";
                $i = 1;
                $waktu = getdate( );
                $totalbayar = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    $baru = 0;
                    $totaldenda = 0;
                    $kettambahan = "";
                    unset( $d2 );
                    unset( $diskonbeasiswa );
                    $q = "SELECT \r\n           * FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t\tAND TANGGALBAYAR=DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d') AND\r\n\t\t\t\t\tIDKOMPONEN='{$d['ID']}'\r\n          ";
                    $h2 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h2 ) )
                    {
                        $d2 = sqlfetcharray( $h2 );
                    }
                    else
                    {
                        $baru = 1;
                        if ( $aturankeuangan == 3 )
                        {
                            $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$d['ID']}' ";
                            $hdiskon = mysqli_query($koneksi,$q);
                            echo mysqli_error($koneksi);
                            if ( 0 < sqlnumrows( $hdiskon ) )
                            {
                                $ddiskon = sqlfetcharray( $hdiskon );
                                $diskonbeasiswa = $ddiskon[DISKON];
                            }
                        }
                    }
                    $cek = "";
                    $kelas = kelas( $i );
                    echo "\r\n\t\t\t\t\t\t<tr align=center {$kelas} valign=top>\r\n\t\t\t\t\t\t\t<td>{$i}</td>\r\n \t\t \t\t\t\t\t<td align=left nowrap>{$d['NAMAKOMPONEN']}  </td>\r\n\t\t \t\t\t\t\t<td align=left nowrap>".$arrayjenispembayaran[$d[JENIS]]." \r\n\t\t\t\t\t\t\t\t\t<input type=hidden name='jenisk[{$d['ID']}]' value='{$d['JENIS']}'>\t\t \t\t\t\t\t\r\n\t\t \t\t\t\t\t</td>\r\n\t\t \t\t\t\t\t<td align=center  nowrap>";
                    if ( $d[JENIS] == 2 )
                    {
                        echo "\r\n\t\t\t\t\t\t\t\t\t<select name='tahunbayar[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
                        $ii = 1900;
                        while ( $ii <= $waktu[year] + 5 )
                        {
                            $cek = "";
                            if ( $ii == $d2[TAHUNAJARAN] )
                            {
                                $cek = "selected";
                                $tahunpilih = $d2[TAHUNAJARAN];
                            }
                            else if ( $ii == $tahunajaran && $d2[TAHUNAJARAN] == "" )
                            {
                                $cek = "selected";
                                $tahunpilih = $ii;
                            }
                            echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                            ++$ii;
                        }
                        echo "\r\n\t\t\t\t\t\t\t\t\t</select>";
                        $qdibayar = " AND TAHUNAJARAN='{$tahunpilih}' ";
                    }
                    else if ( $d[JENIS] == 3 )
                    {
                        echo "\r\n\t\t\t\t\t\t\t\t\t\t<select name='arraysemesterbayar[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t ";
                        foreach ( $arraysemester as $k => $v )
                        {
                            $cek = "";
                            if ( $k == $d2[SEMESTER] )
                            {
                                $cek = "selected";
                                $semesterpilih = $k;
                            }
                            else if ( $k == $semesterbayar && $d2[SEMESTER] == "" )
                            {
                                $cek = "selected";
                                $semesterpilih = $k;
                            }
                            echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
                        }
                        echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>    \r\n\t\t\t\t\t\t\t\t\t<select name='tahunbayar[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
                        $ii = 1900;
                        while ( $ii <= $waktu[year] + 5 )
                        {
                            $cek = "";
                            if ( $ii == $d2[TAHUNAJARAN] )
                            {
                                $cek = "selected";
                                $tahunpilih = $ii;
                            }
                            else if ( $ii == $tahunajaran && $d2[TAHUNAJARAN] == "" )
                            {
                                $cek = "selected";
                                $tahunpilih = $ii;
                            }
                            echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                            ++$ii;
                        }
                        echo "\r\n\t\t\t\t\t\t\t\t\t</select> ";
                        $qdibayar = " AND TAHUNAJARAN='{$tahunpilih}' AND\r\n                  SEMESTER='{$semesterpilih}' ";
                    }
                    else if ( $d[JENIS] == 5 )
                    {
                        echo "\r\n\t\t\t\t\t\t\t\t\t\t<select name='arraysemesterbayar[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t ";
                        foreach ( $arraybulan as $k => $v )
                        {
                            $cek = "";
                            if ( $k + 1 == $d2[SEMESTER] )
                            {
                                $cek = "selected";
                                $semesterpilih = $k + 1;
                            }
                            else if ( $k + 1 == $bulanbayar && $d2[SEMESTER] == "" )
                            {
                                $cek = "selected";
                                $semesterpilih = $k + 1;
                            }
                            echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
                        }
                        echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t<select name='tahunbayar[{$d['ID']}]' class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
                        $ii = 1900;
                        while ( $ii <= $waktu[year] + 5 )
                        {
                            $cek = "";
                            if ( $ii == $d2[TAHUNAJARAN] )
                            {
                                $cek = "selected";
                                $tahunpilih = $ii;
                            }
                            else if ( $ii == $tahunajaran2 && $d2[TAHUNAJARAN] == "" )
                            {
                                $cek = "selected";
                                $tahunpilih = $ii;
                            }
                            echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                            ++$ii;
                        }
                        echo "\r\n\t\t\t\t\t\t\t\t\t</select>";
                        $qdibayar = " AND TAHUNAJARAN='{$tahunpilih}' AND\r\n                  SEMESTER='{$semesterpilih}' ";
                        $totaldenda = 0;
                        $kettambahan = "";
                        $q = "SELECT TO_DAYS('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}')-TO_DAYS('{$tahunpilih}-{$semesterpilih}-{$d['TANGGAL']}') AS HARI ";
                        $hx = mysqli_query($koneksi,$q);
                        $dx = sqlfetcharray( $hx );
                        $jumlahhari = $dx[HARI] + 0;
                        if ( 0 < $jumlahhari )
                        {
                            if ( $d[JENISDENDA] == 0 )
                            {
                                $totaldenda = $d[DENDA];
                            }
                            else
                            {
                                $totaldenda = $d[DENDA] * $jumlahhari;
                            }
                            $kettambahan = "Denda terlambat Rp. ".cetakuang( $totaldenda );
                        }
                    }
                    else
                    {
                        echo "-";
                    }
                    if ( $d[ID] != "99" )
                    {
                        $biaya = $d[BIAYA];
                    }
                    else
                    {
                        $jumlahsks = getjumlahsks( $idmahasiswa, $tahunpilih, $semesterpilih );
                        $jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahunpilih, $semesterpilih );
                        $skslebih = 0;
                        if ( $jumlahskswajib < $jumlahsks )
                        {
                            $skslebih = $jumlahsks - $jumlahskswajib;
                        }
                        $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n            \t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n              \t\t  mahasiswa.ID='{$idmahasiswa}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='99'\r\n            \t\t\t \r\n            \t\t";
                        $ht = mysqli_query($koneksi,$q);
                        $dt = sqlfetcharray( $ht );
                        $biayakomponen = $dt[TOTAL] + 0;
                        if ( $BIAYASKSKULIAH == 1 )
                        {
                            $biaya = $jumlahsks * $biayakomponen;
                        }
                        else
                        {
                            $biaya = $skslebih * $biayakomponen;
                        }
                    }
                    $biaya += $totaldenda;
                    $q = "SELECT SUM(JUMLAH) AS TOTAL,SUM(DENDA) AS TOTALDENDA\r\n                 FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t\tAND TANGGALBAYAR < DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d') AND\r\n\t\t\t\t\tIDKOMPONEN='{$d['ID']}'\r\n          {$qdibayar}\r\n          ";
                    $h3 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h3 ) )
                    {
                        $d3 = sqlfetcharray( $h3 );
                        $dibayar = $d3[TOTAL];
                    }
                    if ( $d2[KET] == "" )
                    {
                        $d2[KET] = "{$kettambahan}";
                    }
                    if ( $d2[DENDA] == "" )
                    {
                        $d2[DENDA] = $totaldenda - $d3[TOTALDENDA];
                    }
                    $strdiskon = "";
                    if ( $baru == 1 )
                    {
                        $d2[DISKON] = $diskonbeasiswa * $biaya / 100;
                        $d2[JUMLAH] = $biaya - $d2[DISKON];
                        if ( 0 < $biaya && 0 < $diskonbeasiswa )
                        {
                            $strdiskon = " ({$diskonbeasiswa} %) ";
                        }
                    }
                    $sisa = $biaya - $dibayar - $d2[JUMLAH] - $d2[DISKON];
                    $cekpilih = "";
                    if ( 0 < $d2[JUMLAH] )
                    {
                        $cekpilih = "checked";
                    }
                    echo "</td>\t\t\t\t\t\t\t\t\r\n               \t<input type=hidden name='biayak[{$d['ID']}]' value='{$biaya}'>\t\t \t\t\t\t\t\r\n\r\n\t\t \t\t\t\t\t<td align=right> ".cetakuang( $biaya )." </td>\r\n\t\t \t\t\t\t\t<!-- <td align=right>".cetakuang( $dibayar )."</td> -->\r\n\t\t \t\t\t\t\t<td align=center>\r\n\t\t \t\t\t\t\t<input type=hidden  name='arraydenda[{$d['ID']}]' value='{$d2['DENDA']}'>\r\n\t\t \t\t\t\t\t<input type=hidden  name='arraysisa[{$d['ID']}]' value='{$sisa}'>\r\n\t\t \t\t\t\t\t\r\n\t\t \t\t\t\t\t<input type=text size=8 class=masukan name='arraybayar[{$d['ID']}]' value='{$d2['JUMLAH']}'>\r\n\t\t \t\t\t\t\t</td>\r\n\t\t \t\t\t\t\t<td align=center nowrap>\r\n\t\t \t\t\t\t\t<input type=text size=6 class=masukan name='arraydiskon[{$d['ID']}]' value='{$d2['DISKON']}'> {$strdiskon}\r\n\t\t \t\t\t\t\t</td>\r\n\t\t \t\t\t\t\t<!-- <td align=right>".cetakuang( $sisa )."</td> -->\r\n\t\t \t\t\t\t\t<td align=center>\r\n\t\t \t\t\t\t\t<input type=checkbox class=masukan name='pilihbayar[{$d['ID']}]' value='1' {$cekpilih} >\r\n\t\t \t\t\t\t\t</td>\r\n\t\t \t\t\t\t\t<td align=center>\r\n\t\t \t\t\t\t\t<textarea cols=12 rows=2 class=masukan name='arrayket[{$d['ID']}]' >{$d2['KET']}</textarea>\r\n\t\t \t\t\t\t\t</td>\r\n\t\t \t\t\t\t</tr>\r\n\t\t\t\t\t";
                    $totalbayar += $d2[JUMLAH];
                    ++$i;
                }
                echo "\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td colspan=4 align=right>Total</td>\r\n\t\t\t\t\t\t<td align=right><b>".cetakuang( $totalbayar )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\r\n\t\t\t\t</table>\r\n\t\t\t\t</form>\r\n\t\t\t\t<form name=form action=cetakkuitansi.php method=post target=_blank>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t\t\t\t<input type=hidden name=carabayar value='{$carabayar}'>\r\n\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n<input class=masukan type=submit name=aksi value='Cetak Kuitansi'>        \r\n";
            }
            echo "\r\n\t\t\t\t</form>\r\n\t\t\t";
            $q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(TANGGALBAYAR=DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d'),1,0) AS STATUSTANGGAL\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND\r\n        \r\n      IDMAHASISWA='{$idmahasiswa}' \r\n      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "\r\n\t\t\t   <br>\r\n\t\t\t   <b>Rincian Transaksi Keuangan Mahasiswa</b>\r\n          <table class=form width=95%>\r\n            <tr class=juduldata align=center>\r\n              <td>Nama</td>\r\n              <td>Jenis</td>\r\n               <td>Waktu</td>\r\n               <td>Tanggal Bayar</td>\r\n              <td>Biaya</td>\r\n              <td>Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Sisa</td>\r\n              <td>Ket</td>\r\n              <td>Hapus</td>\r\n            </tr>";
                $idkomponenlama = $tahunlama = $semlama = 0 - 1;
                $sisa = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    $waktu = "-";
                    if ( $d[BIAYA] == 0 )
                    {
                        $d[BIAYA] = $d[BIAYA2];
                    }
                    if ( $d[JENIS] == 2 )
                    {
                        $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                    }
                    else if ( $d[JENIS] == 3 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                    }
                    else if ( $d[JENIS] == 5 )
                    {
                        $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                    }
                    if ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] )
                    {
                        $sisa = $d[BIAYA];
                        $idkomponenlama = $d[IDKOMPONEN];
                        $tahunlama = $d[TAHUNAJARAN];
                        $semlama = $d[SEMESTER];
                        echo "\r\n                  <tr class=juduldata><td colspan=10>&nbsp;</td></tr>\r\n                  ";
                    }
                    $sisa -= $d[JUMLAH] + $d[DISKON];
                    $trtgl = "";
                    if ( $d[STATUSTANGGAL] == 1 )
                    {
                        $trtgl = "style='background-color:#ffff00;'";
                    }
                    echo "\r\n            <tr valign=top {$tr} {$trtgl}>\r\n              <td> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n              <td> ".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n               <td align=center>{$waktu}</td>\r\n               <td align=center>{$d['TANGGALBAYAR']}</td>\r\n              <td align=right>".cetakuang( $d[BIAYA] )."</td>\r\n              <td align=right>".cetakuang( $d[JUMLAH] )."</td>\r\n              <td align=right>".cetakuang( $d[DISKON] )."</td>\r\n              <td align=right> ".cetakuang( $sisa )."</td>\r\n              <td align=left>{$d['KET']}</td>";
                    if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
                    {
                        echo "\r\n              <td align=center><a onClick=\"return confirm('Hapus data pembayaran?');\" href='index.php?pilihan={$pilihan}&idhapus={$d['ID']}&aksi={$aksi}&aksi2=hapus&idmahasiswa={$idmahasiswa}&carabayar={$carabayar}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&{$href}'>hapus</a></td>";
                    }
                    else
                    {
                        echo "";
                    }
                    echo "\r\n            </tr>";
                }
                echo "\r\n          </table>\r\n  </div></div></div></div></div>       ";
            }
        }
    }
}
if ( $aksi == "" )
{
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20      id='inputString' onkeyup=\"lookup(this.value,'','');\">\r\n\t" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Cara Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=carabayar>";
    foreach ( $arraycarabayar as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Komponen Pembayaran</td>\r\n\t\t\t\t\t\t<td>";
    $i = 0;
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "<input id=jeniskomponen{$i}  type=checkbox name='jeniskomponen_{$i}' value='{$k}'>{$v}<br>";
        ++$i;
    }
    echo "\r\n              [<a href='#' onClick='cekall();return false;'>pilih semua</a>] \r\n              [<a href='#' onClick='uncekall();return false;'>batal pilih semua</a>]\r\n              <input type=hidden name=count value='{$i}'>\r\n\t\t\t<script>\r\n \t\t\t\tvar count={$i};\r\n\t\t\t\tfunction cekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n \r\n\t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=true;\r\n\t\t\t\t\t\t \r\n \t\t\t\t\t}\r\n \r\n \t\t\t\t}\r\n\t\t\t\tfunction uncekall() {\r\n\t\t\t\t\tvar i=0;\r\n\t\t\t\t\tfor (i=0;i<count ;i++) {\r\n \r\n\t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=false;\r\n \t\t\t\t\t}\r\n \r\n \t\t\t\t}\r\n \t\t\t</script>\r\n              \r\n              \r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Bulan/Semester/Tahun</td>\r\n\t\t\t\t\t\t<td> \r\n<select name=bulanbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t  ";
    foreach ( $arraybulan as $k => $v )
    {
        $cek = "";
        if ( $k + 1 == $w[mon] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t<select name=tahunajaran2 class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
    $ii = 1900;
    while ( $ii <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $ii == $d2[TAHUNAJARAN] )
        {
            $cek = "selected";
        }
        else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}> {$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
        ++$ii;
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t</select> <br>\r\n<select name=semesterbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t  ";
    foreach ( $arraysemester as $k => $v )
    {
        $cek = "";
        if ( $k == $d2[SEMESTER] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
    $ii = 1900;
    while ( $ii <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $ii == $d2[TAHUNAJARAN] )
        {
            $cek = "selected";
        }
        else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
        ++$ii;
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t</select>            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
