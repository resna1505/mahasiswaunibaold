<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function cekvaliditaswaktu( $label, $varfile, $max_size = 0 )
{
}

function cekvaliditasfile( $label, $varfile, $max_size = 0 )
{
    $forbidden_ext = array( "php", "php3", "inc" );
    $max_size = $max_size * 1000;
    if($varfile['name']) {
        $ext = array_pop( explode( ".", $varfile['name'] ) ); //there sre Error Strict 
        #print_r($ext);
        #exit();
        if ( $varfile['name'] != "none" )
        {
            if ( in_array( $ext, $forbidden_ext ) )
            {
                return $label." (Tidak boleh mengupload file berekstensi '{$ext}'. Jika memang diperlukan, silahkan di-zip terlebih dahulu sebelum di upload)";
            }
            if ( 0 < $max_size && $max_size < $varfile['size'] )
            {
                return $label." (Ukuran file yang diupoad terlalu besar. Maks = {$max_size} kilobyte)";
            }
        }
    }    
}

function cekvaliditasnama( $label, $nama, $max = 255, $empty = true )
{
    if ( !validasi_nama( $nama, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasnim( $label, $nim )
{
    return cekvaliditaskode( $label, $nim, $max = 20, $empty = true );
}

function cekvaliditasnidn( $label, $nidn, $empty = true )
{
    if ( !validasi_angka_int( $nidn, 20, $empty ) )
    {
        return $label;
    }
}

function cekvaliditaskode( $label, $kode, $max = 255, $empty = true )
{
    if ( $empty == false && $kode == "" )
    {
        return $label." (Tidak boleh kosong)";
    }
    $maks = $max * 1;
    if ( $maks < strlen( $kode ) && $max != 0 )
    {
        return $label."(Tidak boleh lebih dari {$maks} karakter)";
    }
    $pola = "^([0-9a-zA-Z.,-])*\$";
    if ( !eregi_sikad($pola, $kode,"") ) //if there are space, it has been invalid
    {
        return $label;
    }
}

function cekvaliditaskode2( $label, $kode, $max = 255, $empty = true )
{
	#echo $kode;exit();
    if ( $empty == false && $kode == "" )
    {
        return $label." (Tidak boleh kosong)";
    }
    $maks = $max * 1;
    if ( $maks < strlen( $kode ) && $max != 0 )
    {
        return $label."(Tidak boleh lebih dari {$maks} karakter)";
    }
}

function cekvaliditasnilaihuruf( $label, $nilai, $empty = true )
{
    if ( !validasi_nilaihuruf( $nilai, 2, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasnilaibobot( $label, $nilai, $empty = true )
{
    if ( !validasi_nilaibobot( $nilai, 4, $empty ) )
    {
        return $label;
    }
}

function cekvaliditastanggal( $label, $tgl, $bln, $thn, $empty = true )
{
    if ( !validasi_tanggal( $tgl, $bln, $thn, $empty ) )
    {
        return $label;
    }
}

function cekvaliditastahun( $label, $thn = "", $empty = true )
{
    if ( !validasi_tahun( $thn, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasthnajaran( $label, $thn = "", $sem = "", $empty = true )
{
    if ( !validasi_thnajaran( $thn, $sem, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasthnbulan( $label, $thn = "", $bln = "", $empty = true )
{
    if ( !validasi_thnbulan( $thn, $bln, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasemail( $label, $email = "", $empty = true )
{
    if ( !validasi_email( $email, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasweb( $label, $web = "", $max = 64, $empty = true )
{
    if ( !validasi_web( $web, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasinteger( $label, $intgr = "", $max = 32, $empty = true )
{
    if ( !validasi_angka_int( $intgr, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasintegersks( $label, $intgr = "", $max = 32, $empty = true )
{
    if ( !validasi_angka_int_sks( $intgr, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasnumerik( $label, $num = "", $max = 32, $empty = true )
{
    if ( !validasi_angka( $num, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditasalphanum( $label, $alphanum = "", $max = 32, $empty = true )
{
    if ( !validasi_alphanum( $alphanum, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditastelp( $label, $tlpn = "", $max = 32, $empty = true )
{
    if ( !validasi_telpon( $tlpn, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditaskodemakul( $label, $makul = "", $max = 20, $empty = true )
{
    if ( !validasi_makul( $makul, $max, $empty ) )
    {
        return $label;
    }
}

function cekvaliditaskodeprodi( $label, $prodi = "", $max = 10, $empty = true )
{
    if ( !validasi_angka_int( $prodi, $max, $empty ) )
    {
        return $label;
    }
}

function validasi_nama( $nama = "", $maks = 255, $empty = true )
{
    if ( $maks < strlen( $nama ) )
    {
        return false;
    }
    if ( $empty == true && $nama == "" )
    {
        return true;
    }
	else if(stripos(trim($nama), "PUTRI MARLIAN") !== FALSE)
    {
        //$errmesg = "Nama Calon Mahasiswa tidak diizinkan melakukan pendaftaran";
		return false;
    }
    if ( eregi_sikad( "[`]", $nama ) )
    {
        return false;
    }
    return true;
}

function validasi_nilaihuruf( $nilai = "", $maks = 3, $empty = true )
{
    if ( $empty == true && $nilai == "" )
    {
        return true;
    }
    $pola = "^([a-fA-FLMT\\+\\-]{0,{$maks}})\$";
    if ( !eregi_sikad( $pola, $nilai ) )
    {
        return false;
    }
    return true;
}

function validasi_nilaibobot( $nilai = "", $maks = 4, $empty = true )
{
    if ( $empty == true && $nilai == "" )
    {
        return true;
    }
    $pola = "^([0-9.]{0,{$maks}})\$";
    if ( !eregi_sikad( $pola, $nilai ) )
    {
        return false;
    }
    return true;
}

function validasi_tanggal( $tgl, $bln, $thn, $empty = true )
{
    $tglbulan[1] = 31;
    $tglbulan[2] = 28;
    $tglbulan[3] = 31;
    $tglbulan[4] = 30;
    $tglbulan[5] = 31;
    $tglbulan[6] = 30;
    $tglbulan[7] = 31;
    $tglbulan[8] = 31;
    $tglbulan[9] = 30;
    $tglbulan[10] = 31;
    $tglbulan[11] = 30;
    $tglbulan[12] = 31;
    $tgl1 = $tgl * 1;
    $bln1 = $bln * 1;
    $thn1 = $thn * 1;
    if ( $empty == false && ( $tgl1 == 0 || $bln1 == 0 || $thn1 == 0 ) )
    {
        return false;
    }
    if ( $bln1 == 2 && $thn1 % 4 == 0 )
    {
        $tglbulan[2] = 29;
    }
    if ( $tglbulan[$bln1] < $tgl1 || $tgl1 < 0 )
    {
        return false;
    }
    if ( 12 < $bln1 || $bln1 < 0 )
    {
        return false;
    }
    if ( !eregi_sikad( "([0-9]){4}", $thn1 ) && $thn != "" )
    {
        return false;
    }
    return true;
}

function validasi_tahun( $thn = "", $empty = true )
{
    if ( $empty == true && $thn == "" )
    {
        return true;
    }
    if ( !eregi_sikad( "([0-9]){4}", $thn ) && $thn != "" )
    {
        return false;
    }
    return true;
}

function validasi_thnajaran( $thn = "", $sem = "", $empty = true )
{
    if ( ( $thn == "" || $sem == "" ) && $empty == false )
    {
        return false;
    }
    if ( !validasi_tahun( $thn ) )
    {
        return false;
    }
    if ( $sem < 0 || 5 < $sem )
    {
        return false;
    }
    return true;
}

function validasi_thnbulan( $thn = "", $bln = "", $empty = true )
{
    if ( ( $thn == "" || $bln == "" ) && $empty == false )
    {
        return false;
    }
    if ( !validasi_tahun( $thn ) )
    {
        return false;
    }
    if ( $sem < 0 || 12 < $bln )
    {
        return false;
    }
    return true;
}

function validasi_kode( $kode = "", $maxlen = 255, $empty = true )
{
    if ( $empty == true && $kode == "" )
    {
        return true;
    }
    $pola = "^([0-9a-zA-Z.,-])*\$";
    if ( !ereg_sikad( $pola, $kode ) || $maxlen < strlen( $kode ) )
    {
        return false;
    }
    return true;
}

function validasi_email( $mail, $empty = true )
{
    if ( $empty && $mail == "" )
    {
        return true;
    }
    if ( !ereg_sikad( "^[^@]{1,64}@[^@]{1,255}\\.[^@]{1,7}\$", $mail ) )
    {
        return false;
    }
    return true;
}

function validasi_web( $web, $empty = true )
{
    $pola = "^http://.+\\..+\$";
    if ( eregi_sikad( $pola, $web ) )
    {
        return true;
    }
    return false;
}

function validasi_angka_int( $num = "", $maxlen = 255, $empty = true )
{
    $pola = "^([0-9]*)\$";
    if ( $num == "" && $empty == false )
    {
        return false;
    }
    if ( $maxlen < strlen( $num ) || !eregi_sikad( $pola, $num ) )
    {
        return false;
    }
    return true;
}

function validasi_angka_int_sks( $num = "", $maxlen = 255, $empty = true )
{
    $pola = "^([0-10]*)\$";
    if ( $num == "" && $empty == false )
    {
		#echo "llll";exit();
        return false;
    }
	#echo $maxlen."jj".strlen( $num );exit();
    if ( $maxlen < strlen( $num ) || !eregi_sikad( $pola, $num ) )
    {
		#echo "xxxx";exit();
        return false;
    }
    return true;
}

function validasi_angka( $num, $empty = true )
{
    $pola = "^([0-9]*)\\.*([0-9]*)\$";
    if ( eregi_sikad( $pola, $num ) )
    {
        return true;
    }
    return false;
}

function validasi_alphanum( $alphanum, $empty = true )
{
    $pola = "^([a-zA-Z0-9]*)\$";
    if ( eregi_sikad( $pola, $num ) )
    {
        return true;
    }
    return false;
}

function validasi_telpon( $telp = "", $empty = true )
{
    $pola[0] = "^[0-9]*\$";
    $pola[1] = "^\\+[0-9]+\$";
    $pola[2] = "^\\(([0-9]{1,4})\\)[0-9]{1,}\$";
    $pola[3] = "^([0-9]{1,4})\\-[0-9]{1,}\$";
    if ( $empty == false && $telp == "" )
    {
        return false;
    }
    foreach ( $pola as $v )
    {
        if ( eregi_sikad( $v, $telp ) )
        {
            return true;
            break;
        }
    }
    return false;
}

function validasi_makul( $makul = "", $max = 16, $empty = true )
{
    $pola = "^([a-zA-Z0-9]*)\$";
    if ( $empty == false && $makul == "" )
    {
        return false;
    }
    if ( eregi_sikad( $pola, $makul ) )
    {
        return true;
    }
    return false;
}

function inv_message( $invalid_data, $type = 1 )
{
    return compile_message( $invalid_data, $type );
}

function compile_message( $invalid_data, $type = 1 )
{
    if ( 0 < count( $invalid_data ) )
    {
        if ( $type == 1 )
        {
            $step = 1;
            $arr_invalid = array_reverse( $invalid_data );
            foreach ( $arr_invalid as $v )
            {
                if ( $step == 1 )
                {
                    $msg = $v;
                    $step = 2;
                }
                else if ( $step == 2 )
                {
                    $msg = $v." & ".$msg;
                    $step = 3;
                }
                else
                {
                    $msg = $v.", ".$msg;
                }
            }
            return $msg;
        }
        $msg = "<ul>";
        foreach ( $invalid_data as $k => $v )
        {
            $msg .= "<li>".$v."</li>";
        }
        $msg .= "</ul>";
        return $msg;
    }
    return false;
}

function filter_not_empty( $var )
{
    return $var != "";
}

function token_err_mesg( $data, $act = 99 )
{
    switch ( $act )
    {
        case HAPUS_DATA :
            $action = "hapus";
            break;
        case TAMBAH_DATA :
            $action = "tambah";
            break;
        case SIMPAN_DATA :
            $action = "simpan";
            break;
    }
    $action = "cari";
    $msg = "Form Anda telah kadaluarsa. Data ".$data." tidak di".strtolower( $action );
    return $msg;
}

function val_err_mesg( $data, $type = 1, $act = 1 )
{
    switch ( $act )
    {
        case HAPUS_DATA :
            $action = "hapus";
            break;
        case TAMBAH_DATA :
            $action = "tambah";
            break;
        case SIMPAN_DATA :
            $action = "simpan";
            break;
    }
    $action = "cari";
    switch ( $type )
    {
        case 1 :
            $msg = "Data ".inv_message( $data, $type )." tidak valid. Data tidak di".strtolower( $action );
            break;
        case 2 :
            $msg = "Data berikut ini tidak valid, kosong atau tidak diizinkan".inv_message( $data, $type )." Data tidak di".strtolower( $action );
            break;
        case 3 :
            $msg = "Format Alamat E-mail salah";    
    }
    return $msg;
}

define( "HAPUS_DATA", 0 );
define( "TAMBAH_DATA", 1 );
define( "SIMPAN_DATA", 2 );
define( "CARI_DATA", 3 );
?>
