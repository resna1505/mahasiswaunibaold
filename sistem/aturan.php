<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Aturan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Aturan Edit Nilai(1)", $editnilai, 2 );
        $vld[] = cekvaliditaskode( "Aturan Edit Nilai(2)", $editnilaidosen, 2 );
        $vld[] = cekvaliditaskode( "Aturan KRS Online(1)", $krsonline, 2 );
        $vld[] = cekvaliditaskode( "Aturan KRS Online(2)", $krsonline2, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else if ( $batasdiam < 0 )
        {
            $errmesg = "Lama waktu tanpa aktifitas harus diisi lebih dari sama dengan 0 ";
        }
        else
        {
            $q = "UPDATE aturan SET\r\n\t\tPUSAKA='{$pusaka}',\r\n\t\tURLPUSAKA='{$urlpusaka}',\r\n\t\tEDITNILAI='{$editnilai}',\r\n\t\tEDITNILAIDOSEN='{$editnilaidosen}',\r\n\t\tEDITNILAIDOSEN2='{$editnilaidosen2}',\r\n\t\tEDITNILAIOPERATOR='{$editnilaioperator}',\r\n\t\tEDITKOMPONENNILAIDOSEN='{$editkomponennilaidosen}',\r\n\t\tEDITKONVERSINILAIDOSEN='{$editkonversinilaidosen}',\r\n\t\tKELASKRSONLINE='{$kelaskrsonline}',\r\n\t\tKRSONLINE='{$krsonline}',\r\n\t\tKRSONLINE2='{$krsonline2}',\r\n\t\tKRSONLINE3='{$krsonline3}',\r\n\t\tKURIKULUM='{$kurikulum}',\r\n\t\tKARTUUJIAN='{$kartuujian}',\r\n\t\tKEUANGAN='{$keuangan}',\r\n\t\tKEUANGAN2='{$keuangan2}',\r\n\t\tBIAYAKEUANGAN='{$biayakeuangan}',\r\n\t\tSYARATKRSONLINE='{$syaratkrsonline}',\r\n\t\tSYARATKRSONLINE2='{$syaratkrsonline2}',\r\n\t\tBATASDIAM='{$batasdiam}',\r\n\t\tPENGINGATPASSWORD='{$pengingatpassword}',\r\n\t\tPENGINGATBACKUP='{$pengingatbackup}',\r\n\t\tTAHUNAJARAN='2012-{$tahunajaran['bln']}-{$tahunajaran['tgl']}',\r\n\t\tSEMESTERGANJIL='2012-{$semesterganjil['bln']}-{$semesterganjil['tgl']}',\r\n\t\tSEMESTERGENAP='2012-{$semestergenap['bln']}-{$semestergenap['tgl']}',\r\n\t\tAPPROVEBEASISWA='{$approvebeasiswa}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Aturan berhasil disimpan";
            }
            else
            {
                $errmesg = "Aturan tidak disimpan";
            }
        }
    }
}
$q = "SELECT * FROM aturan ";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO aturan (EDITNILAI) VALUES (0)";
    mysqli_query($koneksi,$q);
    $q = "SELECT * FROM aturan ";
    $h = mysqli_query($koneksi,$q);
}
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    if ( $d[EDITNILAI] == 0 )
    {
        $editnilai0 = "checked";
        $editnilai1 = "";
    }
    else if ( $d[EDITNILAI] == 1 )
    {
        $editnilai0 = "";
        $editnilai1 = "checked";
    }
    if ( $d[EDITNILAIDOSEN] == 0 )
    {
        $editnilaidosen0 = "checked";
        $editnilaidosen1 = "";
    }
    else if ( $d[EDITNILAIDOSEN] == 1 )
    {
        $editnilaidosen0 = "";
        $editnilaidosen1 = "checked";
    }
    if ( $d[EDITNILAIOPERATOR] == 0 )
    {
        $editnilaioperator0 = "checked";
        $editnilaioperator1 = "";
    }
    else if ( $d[EDITNILAIOPERATOR] == 1 )
    {
        $editnilaioperator0 = "";
        $editnilaioperator1 = "checked";
    }
    if ( $d[EDITNILAIDOSEN2] == 0 )
    {
        $editnilaidosen20 = "checked";
        $editnilaidosen21 = "";
    }
    else if ( $d[EDITNILAIDOSEN2] == 1 )
    {
        $editnilaidosen20 = "";
        $editnilaidosen21 = "checked";
    }
    if ( $d[EDITKOMPONENNILAIDOSEN] == 0 )
    {
        $editkomponennilaidosen0 = "checked";
        $editkomponennilaidosen1 = "";
    }
    else if ( $d[EDITKOMPONENNILAIDOSEN] == 1 )
    {
        $editkomponennilaidosen0 = "";
        $editkomponennilaidosen1 = "checked";
    }
    if ( $d[EDITKONVERSINILAIDOSEN] == 0 )
    {
        $editkonversinilaidosen0 = "checked";
        $editkonversinilaidosen1 = "";
    }
    else if ( $d[EDITKONVERSINILAIDOSEN] == 1 )
    {
        $editkonversinilaidosen0 = "";
        $editkonversinilaidosen1 = "checked";
    }
    $krsonline0 = $krsonline1 = $krsonline2 = "";
    if ( $d[KRSONLINE] == 0 )
    {
        $krsonline0 = "checked";
        $krsonline1 = "";
        $krsonline3 = "";
        $krsonline2 = "";
    }
    else if ( $d[KRSONLINE] == 1 )
    {
        $krsonline0 = "";
        $krsonline1 = "checked";
        $krsonline3 = "";
        $krsonline2 = "";
    }
    else if ( $d[KRSONLINE] == 2 )
    {
        $krsonline0 = "";
        $krsonline1 = "";
        $krsonline2 = "checked";
        $krsonline3 = "";
    }
    else if ( $d[KRSONLINE] == 3 )
    {
        $krsonline0 = "";
        $krsonline1 = "";
        $krsonline2 = "";
        $krsonline3 = "checked";
    }
    $syaratkrsonline = $d[SYARATKRSONLINE];
    $syaratkrsonline2 = $d[SYARATKRSONLINE2];
    $selectedS = $selectedS = "";
    if ( $syaratkrsonline2 == "T" )
    {
        $selectedT = "selected";
    }
    else if ( $syaratkrsonline2 == "S" )
    {
        $selectedS = "selected";
    }
    if ( $d[KRSONLINE2] == 0 )
    {
        $krsonline02 = "checked";
        $krsonline12 = "";
    }
    else if ( $d[KRSONLINE2] == 1 )
    {
        $krsonline02 = "";
        $krsonline12 = "checked";
    }
    if ( $d[KRSONLINE3] == 0 )
    {
        $krsonline03 = "checked";
        $krsonline13 = "";
    }
    else if ( $d[KRSONLINE3] == 1 )
    {
        $krsonline03 = "";
        $krsonline13 = "checked";
    }
    if ( $d[KELASKRSONLINE] == 0 )
    {
        $kelaskrsonline0 = "checked";
        $kelaskrsonline1 = "";
    }
    else if ( $d[KELASKRSONLINE] == 1 )
    {
        $kelaskrsonline0 = "";
        $kelaskrsonline1 = "checked";
    }
    if ( $d[KELAS] == 0 )
    {
        $kelas0 = "checked";
        $kelas1 = "";
    }
    else if ( $d[KELAS] == 1 )
    {
        $kelas0 = "";
        $kelas1 = "checked";
    }
    if ( $d[KARTUUJIAN] == 0 )
    {
        $kartuujian0 = "checked";
        $kartuujian1 = "";
    }
    else if ( $d[KARTUUJIAN] == 1 )
    {
        $kartuujian0 = "";
        $kartuujian1 = "checked";
    }
    if ( $d[KURIKULUM] == 0 )
    {
        $kurikulum0 = "checked";
        $kurikulum1 = "";
    }
    else if ( $d[KURIKULUM] == 1 )
    {
        $kurikulum0 = "";
        $kurikulum1 = "checked";
    }
    if ( $d[APPROVEBEASISWA] == 0 )
    {
        $approvebeasiswa0 = "checked";
        $approvebeasiswa1 = "";
    }
    else if ( $d[APPROVEBEASISWA] == 1 )
    {
        $approvebeasiswa0 = "";
        $approvebeasiswa1 = "checked";
    }
    if ( $d[KEUANGAN] == 0 )
    {
        $keuangan0 = "checked";
        $keuangan1 = "";
    }
    else if ( $d[KEUANGAN] == 1 )
    {
        $keuangan0 = "";
        $keuangan1 = "checked";
    }
    if ( $d[KEUANGAN2] == 0 )
    {
        $keuangan20 = "checked";
        $keuangan21 = "";
    }
    else if ( $d[KEUANGAN2] == 1 )
    {
        $keuangan20 = "";
        $keuangan21 = "checked";
    }
    if ( $d[BIAYAKEUANGAN] == 0 )
    {
        $biayakeuangan0 = "checked";
        $biayakeuangan1 = "";
    }
    else if ( $d[BIAYAKEUANGAN] == 1 )
    {
        $biayakeuangan0 = "";
        $biayakeuangan1 = "checked";
    }
    $tmp = explode( "-", $d[TAHUNAJARAN] );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", $d[SEMESTERGANJIL] );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", $d[SEMESTERGENAP] );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $cekpusaka = "";
    if ( $d[PUSAKA] == 1 )
    {
        $cekpusaka = "checked";
    }
    $urlpusaka = $d[URLPUSAKA];
    printjudulmenu( "Aturan-aturan" );
    printmesg( "{$errmesg}" );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    echo "\r\n<form action=index.php method=post> ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $token, "" )."\r\n       \r\n   <table class=form border=1>\r\n     <tr>\r\n      <td align=left colspan=2><b>NILAI</td>\r\n     </tr> \r\n     <tr>\r\n      <td width=150>Edit Nilai (1)</td>\r\n      <td>\r\n      <input type=radio name=editnilai value=0 {$editnilai0}>Operator Nilai bebas mengedit Nilai <br>\r\n      <input type=radio name=editnilai value=1 {$editnilai1}>Operator Nilai harus meminta password dari Supervisor sebelum mengubah data nilai\r\n      </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Edit Nilai (2)</td>\r\n      <td>\r\n      <input type=radio name=editnilaidosen value=0 {$editnilaidosen0}>Dosen tidak dapat mengedit Nilai <br>\r\n      <input type=radio name=editnilaidosen value=1 {$editnilaidosen1}>Dosen dapat mengedit nilai\r\n      </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Edit Nilai oleh  Dosen</td>\r\n      <td>\r\n      <input type=radio name=editnilaidosen2 value=0 {$editnilaidosen20}>Bisa berkali-kali <br>\r\n      <input type=radio name=editnilaidosen2 value=1 {$editnilaidosen21}>Hanya satu kali simpan\r\n      </td>\r\n    </tr>    \r\n     <tr>\r\n      <td width=150>Edit Nilai oleh  Operator</td>\r\n      <td>\r\n      <input type=radio name=editnilaioperator value=0 {$editnilaioperator0}>Bisa berkali-kali <br>\r\n      <input type=radio name=editnilaioperator value=1 {$editnilaioperator1}>Hanya satu kali simpan, butuh approve Supervisor untuk mengedit nilai yang telah disimpan.\r\n      </td>\r\n    </tr>    \r\n     <tr>\r\n      <td width=150>Edit Komponen Nilai oleh  Dosen</td>\r\n      <td>\r\n      <input type=radio name=editkomponennilaidosen value=0 {$editkomponennilaidosen0} >Dosen tidak dapat mengedit komponen nilai<br>\r\n      <input type=radio name=editkomponennilaidosen value=1 {$editkomponennilaidosen1} >Dosen dapat mengedit komponen nilai\r\n      </td>\r\n    </tr>    \r\n     <tr>\r\n      <td width=150>Edit Konversi Nilai oleh  Dosen</td>\r\n      <td>\r\n      <input type=radio name=editkonversinilaidosen value=0 {$editkonversinilaidosen0} >Dosen tidak dapat mengedit konversi nilai<br>\r\n      <input type=radio name=editkonversinilaidosen value=1 {$editkonversinilaidosen1} >Dosen dapat mengedit konversi nilai\r\n      </td>\r\n    </tr>    \r\n     <tr>\r\n      <td align=left colspan=2><b>KRS</td>\r\n     </tr> \r\n    \r\n        \r\n     <tr>\r\n      <td width=150>KRS Online</td>\r\n      <td>\r\n      <input type=radio name=krsonline value=0 {$krsonline0}>Tanpa syarat u/ mahasiswa<br>\r\n      <input type=radio name=krsonline value=1 {$krsonline1}>Mahasiswa harus membayar lunas komponen pembayaran : \r\n      <select name=syaratkrsonline>";
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        if ( $arrayjeniskomponenpembayaran[$k] == 4 )
        {
            continue;
        }
        $selected = "";
        if ( $syaratkrsonline == $k )
        {
            $selected = "selected";
        }
        echo "<option value='{$k}' {$selected}>{$v}</option>";
    }
    echo "\r\n      </select> <br>\r\n\r\n      <input type=radio name=krsonline value=2 {$krsonline2}>Mahasiswa harus membayar minimal Total Pembayaran : \r\n      <select name=syaratkrsonline2>\r\n          <option value='T' {$selectedT}>Tahunan</option>\r\n          <option value='S' {$selectedS}>Semesteran</option>\r\n       </select>\r\n\r\n      <br>\r\n      <input type=radio name=krsonline value=3 {$krsonline3}>Mahasiswa harus membayar minimal pembayaran per komponen  keuangan\r\n\r\n      </td>\r\n    </tr>\r\n\r\n\r\n     <tr>\r\n      <td width=150>KRS Online (2)</td>\r\n      <td>\r\n      <input type=radio name=krsonline2 value=0 {$krsonline02}>Mahasiswa baru (belum punya KRS/IPS) tidak boleh KRS<br>\r\n      <input type=radio name=krsonline2 value=1 {$krsonline12}>Mahasiswa baru (belum punya KRS/IPS) boleh KRS\r\n      </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>KRS Online (3)</td>\r\n      <td>\r\n      <input type=radio name=krsonline3 value=0 {$krsonline03}>Mahasiswa TIDAK WAJIB bimibngan ke dosen wali/PA<br>\r\n      <input type=radio name=krsonline3 value=1 {$krsonline13}>Mahasiswa WAJIB bimibngan ke dosen wali/PA\r\n      </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Kelas KRS Online </td>\r\n      <td>\r\n      <input type=radio name=kelaskrsonline value=0 {$kelaskrsonline0}>Semua kelas tampil (01-99) di KRS Online<br>\r\n      <input type=radio name=kelaskrsonline value=1 {$kelaskrsonline1}>Hanya kelas yang ada dosen pengajarnya saja yang tampil di KRS Online\r\n      </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Tampilan Kurikulum KRS Online Mahasiswa</td>\r\n      <td>\r\n      <input type=radio name=kurikulum value=0 {$kurikulum0} >Default<br>\r\n      <input type=radio name=kurikulum value=1 {$kurikulum1} >Kurikulum yang muncul hanya 1 semester dan Mata Kuliah yang harus diulang (Nilai D,E)<br>\r\n      Khusus untuk Mahasiswa Reguler yang tidak pernah mengambil cuti.\r\n      </td>\r\n    </tr>\r\n    \r\n    \r\n    ";
    if ( $d[KRSONLINE] == 3 )
    {
        echo "\r\n     <tr>\r\n      <td width=150>KARTU UJIAN UTS/UAS</td>\r\n      <td>\r\n      <input type=radio name=kartuujian value=0 {$kartuujian0}>Tanpa Syarat Keuangan<br>\r\n      <input type=radio name=kartuujian value=1 {$kartuujian1}>Mahasiswa Wajib Melunasi keuangan \r\n      </td>\r\n    </tr>      \r\n      \r\n      ";
    }
    echo "\r\n     <tr>\r\n      <td align=left colspan=2><b>KEUANGAN</td>\r\n     </tr> \r\n\r\n     <tr>\r\n      <td width=150>Keuangan</td>\r\n      <td>\r\n      <input type=radio name=keuangan value=0 {$keuangan0} >Tanpa Syarat untuk menghapus Data<br>\r\n      <input type=radio name=keuangan value=1 {$keuangan1} >Hanya Supervisor yang Dapat Menghapus Data\r\n      </td>\r\n    </tr>   \r\n    \r\n    \r\n    ";
    if ( $JENISKELAS == 1 )
    {
        echo "   \r\n\r\n     <tr>\r\n      <td width=150>Biaya Komponen Keuangan</td>\r\n      <td>\r\n      <input type=radio name=biayakeuangan value=0 {$biayakeuangan0} >Normal, Tidak Menggunakan Jenis Kelas Mahasiswa<br>\r\n      <input type=radio name=biayakeuangan value=1 {$biayakeuangan1} >Menggunakan Jenis Kelas Mahasiswa\r\n      </td>\r\n    </tr>      \r\n";
    }
    echo "\r\n     <tr>\r\n      <td width=150>Keuangan (2)</td>\r\n      <td>\r\n      <input type=radio name=keuangan2 value=0 {$keuangan20} >Tanpa syarat pembayaran semester sebelumnya untuk entri keuangan komponen semester<br>\r\n      <input type=radio name=keuangan2 value=1 {$keuangan21} >Harus membayar lunas pembayaran semester sebelumnya untuk entri keuangan komponen semester kecuali untuk semester pertama mahasiswa ybs.\r\n      </td>\r\n    </tr> \r\n\r\n     <tr>\r\n      <td width=150>Approve Beasiswa</td>\r\n      <td>\r\n      <input type=radio name=approvebeasiswa value=0 {$approvebeasiswa0} >Tanpa Syarat Approve beasiswa untuk mencetak Transkrip dan Ijazah<br>\r\n      <input type=radio name=approvebeasiswa value=1 {$approvebeasiswa1} >Supervisor wajib mengapprove beasiswa untuk mencetak Transkrip dan Ijazah.\r\n      </td>\r\n    </tr>   \r\n\r\n     <tr>\r\n      <td align=left colspan=2><b>LOGIN DLL</td>\r\n     </tr> \r\n\r\n     <tr>\r\n      <td width=150>LOGIN</td>\r\n      <td>\r\n          Lama waktu tanpa aktivitas <input type=text size=2 name=batasdiam value='{$d['BATASDIAM']}'> menit. Isikan Nol (0) untuk mengabaikan setting ini apabila dianggap terlalu merepotkan.\r\n       </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Pengingat Ganti Password</td>\r\n      <td>\r\n          Rentang waktu pengingat untuk mengganti password secara berkala <input type=text size=2 name=pengingatpassword value='{$d['PENGINGATPASSWORD']}'> hari. Isikan Nol (0) untuk mengabaikan setting ini apabila dianggap terlalu merepotkan.\r\n       </td>\r\n    </tr>\r\n     <tr>\r\n      <td width=150>Pengingat Untuk Membackup Data<br>(Efek khusus ke admin)</td>\r\n      <td>\r\n          Rentang waktu pengingat untuk membackup data secara berkala <input type=text size=2 name=pengingatbackup value='{$d['PENGINGATBACKUP']}'> hari. Isikan Nol (0) untuk mengabaikan setting ini apabila dianggap terlalu merepotkan.\r\n       </td>\r\n    </tr>\r\n\r\n     <tr>\r\n      <td width=150>Default Semester dan Tahun Akademik</td>\r\n      <td>\r\n      <table>\r\n        <tr>\r\n          <td>\r\n             Tahun Ajaran Baru Berganti Setiap Tanggal\r\n          </td>\r\n          <td>\r\n            ".createinputtanggalbulan( "tahunajaran", $tahunajaran, $attr )."\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>\r\n             Semester Ganjil Baru Berganti Setiap Tanggal\r\n          </td>\r\n          <td>\r\n            ".createinputtanggalbulan( "semesterganjil", $semesterganjil, $attr )."\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>\r\n             Semester Genap Berganti Setiap Tanggal\r\n          </td>\r\n          <td>\r\n            ".createinputtanggalbulan( "semestergenap", $semestergenap, $attr )."\r\n          </td>\r\n        </tr>\r\n      </table>\r\n       </td>\r\n    </tr> \r\n\r\n\r\n     <tr>\r\n      <td align=left colspan=2><b>PUSAKA (Sistem Informasi Perpustakaan)</td>\r\n     </tr> \r\n\r\n     <tr>\r\n      <td width=150>Sinkronisasi Anggota</td>\r\n      <td>\r\n      <input type=checkbox name=pusaka value=1 {$cekpusaka}  >Sinkronisasi otomatis data Mahasiswa dan Dosen dengan data Anggota Pusaka<br>\r\n       </td>\r\n    </tr> \r\n     <tr>\r\n      <td width=150>URL Program Pusaka</td>\r\n      <td>\r\n      <input type=text name=urlpusaka value='{$urlpusaka}' size=80 > \r\n       </td>\r\n    </tr> \r\n     <tr>\r\n      <td></td>\r\n      <td><input type=submit name=aksi2 value='Simpan'></td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n";
}
else
{
    printmesg( "Data aturan tidak ada." );
}
?>
