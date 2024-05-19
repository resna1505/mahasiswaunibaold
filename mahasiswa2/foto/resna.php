<?php

if ( $datasetting['JENISDENDA'] == 0 ) // jenis denda sekali
{
    echo "JENIS DENDA SEKALI".'<br>';
    #$denda = $datasetting[DENDA];
    if($datasetting['KATEGORIDENDA']==0){ //kategori persentase
        $denda = ($datasetting['DENDA'])/100;
    }else{
        $denda = ($datasetting['DENDA']);
    }
}else{ //jenis denda perhari
    //ambil tanggal bulan tahun server
    $periodeserver=date('Y-m-d');
    
    $periode_bayar_terakhir = date('Y-m-t', strtotime($datasetting['TANGGALBAYAR2']));
    list($thnbayartagihan,$blnbayartagihan,$tglbayartagihan)=explode("-",$datasetting['TANGGALBAYAR2']);
    #echo "TAHUN BAYAR=".$thnbayartagihan;exit();
    list($thnbayarakhirtagihan,$blnbayarakhirtagihan,$tglbayarakhirtagihan)=explode("-",$periode_bayar_terakhir);
    
    $q = "SELECT TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$tglbayarakhirtagihan}')-TO_DAYS('{$thnbayartagihan}-{$blnbayartagihan}-{$datasetting['TGL_AKHIR']}') AS HARI ";
    echo $q.'<br>';
    $hx = mysqli_query($koneksi,$q);
    $dx = sqlfetcharray( $hx );
    $jumlahhari = $dx['HARI'] + 0;
    if ( 0 < $jumlahhari )
    {									
        #echo "JENIS DENDA PERHARI".'<br>';
        #$denda = $datasetting['DENDA'] * $jumlahhari;
        if($datasetting['KATEGORIDENDA']==0){ //kategori persentase
            $denda = (($datasetting['DENDA'])/100)* $jumlahhari;
        }else{
            $denda = $datasetting['DENDA'] * $jumlahhari;
        }						
    }
}


// Beasiswa

if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 || $arrayjeniskomponenpembayaran[$idkomponen] == 4 )
    {
    $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' ";
        #echo $q.'<br>';
        $hdiskon = doquery($koneksi,$q );
        if ( 0 < sqlnumrows( $hdiskon ) )
        {
            $ddiskon = sqlfetcharray( $hdiskon );
            if($ddiskon['DISKON']>100){

                $diskon_rp=$ddiskon['DISKON'];
                #$diskon=0;
                $diskonbeasiswa=$diskon_rp;
                $ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
            }else{
            
                $diskon=$ddiskon['DISKON'];
                $diskon_rp=0;
                $diskonbeasiswa=$diskon;
                $ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
            }
            #$diskonbeasiswa = $ddiskon[DISKON];
            #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
        }
	}
else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
{ // Per Tahun Ajaran
    $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND  TAHUN='{$tahunajaran}' ";
    echo $q.'<br>';
    $hdiskon = doquery($koneksi,$q );
    if ( 0 < sqlnumrows( $hdiskon ) )
    {
        $ddiskon = sqlfetcharray( $hdiskon );
        #$diskonbeasiswa = $ddiskon[DISKON];
        #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
        if($ddiskon['DISKON']>100){

            $diskon_rp=$ddiskon['DISKON'];
            #$diskon=0;
            $diskonbeasiswa=$diskon_rp;
            $ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
        }else{
        
            $diskon=$ddiskon['DISKON'];
            $diskon_rp=0;
            $diskonbeasiswa=$diskon;
            $ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
        }
    }
}
else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
{ // PERSEMESTER
    #echo "BIAYA ATAS=".$biaya.'<br>';
    #echo "kkk";
    $q = "SELECT * FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND ".
    "TAHUN='{$tahun}' AND SEMESTER='{$semester}'";
    echo "PERSEMESTER=".$q.'<br>';
    $hdiskon = doquery($koneksi,$q );
    if ( 0 < sqlnumrows( $hdiskon ) )
    {
        #echo "CARI DISKON";
        $ddiskon = sqlfetcharray( $hdiskon );
        #$diskonbeasiswa = $ddiskon[DISKON];
        #$ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
        if($ddiskon['DISKON']>100){

            $diskon_rp=$ddiskon['DISKON'];
            #$diskon=0;
            $diskonbeasiswa=$diskon_rp;
            $ketdiskon = "Sudah Diskon ".cetakuang($diskonbeasiswa);
        }else{
        
            $diskon=$ddiskon['DISKON'];
            $diskon_rp=0;
            $diskonbeasiswa=$diskon;
            $ketdiskon = "Sudah Diskon {$diskonbeasiswa} %.";
        }
    }
}

if($diskonbeasiswa>100){
	$biayatampil = $biaya-$diskonbeasiswa;

	
}else{
	$biayatampil = ( 100 - $diskonbeasiswa ) / 100 * $biaya;
}