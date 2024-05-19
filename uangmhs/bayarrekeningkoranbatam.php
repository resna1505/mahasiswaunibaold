<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Pembayaran Keuangan Rekening Koran Mahasiswa" );
if ( $aksi2 == "Simpan Data" && $REQUEST_METHOD == POST )
{
    if ( is_array( $arraypilih ) )
    {
        $i = 0;
        foreach ( $arraypilih as $k => $v )
        {
            $q = "UPDATE t_bni_ibank_paid SET ket='".$arrayket[$k]."',USER='{$users}',TGLUPDATE=NOW() WHERE no_id='{$k}'";
            #echo $q;
			mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $i++;
            }
        }
		#exit();
        if ( 0 < $i )
        {
            $errmesg = "Data pembayaran sudah disimpan";
        }
        else
        {
            $errmesg = "Data pembayaran tidak disimpan";
        }
    }
    $aksi = "Lanjut";
}

if ( $aksi == "Lanjut" )
{
	#echo "kesini";exit();
    if ( trim( $idmahasiswa ) == "" )
    {
        $errmesg = "NIM harus diisi";
        $aksi = "";
    }
    else
    {
		#echo "kesini";
        printmesg( $errmesg );
        $q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $errmesg = "Tidak ada mahasiswa dengan NIM '{$idmahasiswa}'";
            $aksi = "";
        }
        else
        {
            $data = sqlfetcharray( $h );
            echo "\r\n\t\t\t\t<form name=form action=index.php method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t \t\t<table class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=200>NIM</td>\r\n\t\t\t\t\t\t<td><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td><b>{$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td><b>{$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t\t\t<td><b>".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<b>{$tglbayar['tgl']} ".$arraybulan[$tglbayar[bln] - 1]." {$tglbayar['thn']}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr></table>";
            $q = "SELECT t_bni_ibank_paid.*  FROM t_bni_ibank_paid  WHERE  t_bni_ibank_paid.dates='{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}'  AND t_bni_ibank_paid.no_mahasiswa='{$idmahasiswa}'";
            #echo $q;
			$h = mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "<table>\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>Pilih</td>\r\n            <td>No</td>\r\n \t\t\t\t\t\t<td>Bulan</td>\r\n\t\t\t\t\t\t<td>Tahun</td>\r\n\t\t\t\t\t\t<td>Jumlah</td><td>Ket</td>\r\n\t\t\t\t\t\t\r\n\t\t \t\t\t</tr>\r\n\r\n        ";
                $i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    
                    $kelas = kelas( $i );
                    
                    echo "\r\n\t\t\t\t\t<tr  {$kelas} {$styletd}>\r\n\t\t\t\t\t\t<td  nowrap><input {$cektd}  type=checkbox name='arraypilih[{$d['no_id']}]' value=1></td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$i}</td>\r\n \t\t\t\t\t\t<td  nowrap align=center>{$d['bulan']}</td>\r\n\t\t\t\t\t\t<td  nowrap align=center>{$d['tahun']}</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang($d['amount'])."</td></td>\r\n\t\t\t\t\t\t<td  nowrap width='30'><textarea cols=30 rows=2 name='arrayket[{$d['no_id']}]'>{$d['ket']}</textarea></td></tr>";
                   
                }
                echo "\r\n          <tr>\r\n            <td colspan=12 align=left>\r\n              <input type=submit name=aksi2 value='Simpan Data'></td>\r\n          </tr>\r\n        ";
                echo "</table>";
                echo "\t</form>";
                printmesg( $strerror );
                #echo "\r\n\t\t\t\t<form name=form action=cetakkuitansibatam.php method=post target=_blank>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t\t\t\t<input type=hidden name=carabayar value='{$carabayar}'>\r\n\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n<input class=masukan type=submit name=aksi value='Cetak Kuitansi'>        \r\n";
            }
            else
            {
                printmesg( "Data pembayaran belum ada" );
            }
            echo "\r\n\t\t\t\t</form>\r\n\t\t\t";
        }
    }
}
if ( $aksi == "" )
{
	#echo "ll";
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Cara Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=carabayar>";
    foreach ( $arraycarabayar as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n \r\n\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
