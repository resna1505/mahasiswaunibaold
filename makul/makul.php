<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

/*periksaroot();
#echo $aksi;exit();
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = "Sesi Anda telah berubah. Data tidak dihapus";
        $aksi = "tampilkan";
    }
    else
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM makul WHERE ID='{$idhapus}'";
        mysqli_query($koneksi,$q);
        $ketlog = "Hapus Mata Kuliah dengan ID={$idhapus}";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            buatlog( 20 );
            $errmesg = "Data Mata Kuliah dengan Kode = '{$idhapus}' berhasil dihapus";
            $q = "DELETE FROM tbkmk WHERE KDKMKTBKMK='{$idhapus}'";
            mysqli_query($koneksi,$q);
        }
        else
        {
            $errmesg = "Data Mata Kuliah dengan Kode = '{$idhapus}' tidak berhasil dihapus";
        }
        $aksi = "tampilkan";
    }
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $tab == 0 || $tab == "" )
    {
        if ( $statusoperatormakul == 1 && $prodis == getprodimakul( $idupdate ) || $prodis == "" )
        {
            include( "biodata.php" );
        }
        else
        {
            include( "dikti.php" );
        }
    }
    else if ( $tab == 1 )
    {
        include( "dikti.php" );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Update Data Mata Kuliah" );
    if ( $statusoperatormakul == 1 && $prodis == getprodimakul( $idupdate ) || $prodis == "" )
    {
        $arraymenutab[0] = "Data Master Mata Kuliah";
    }
    $arraymenutab[1] = "Data Dikti/Kurikulum (Laporan per Semester)";
    echo "\t\t\t\r\n\t\t<table width=95% class=menutab>\r\n\t\t\t<tr>\r\n\t";
    foreach ( $arraymenutab as $k => $v )
    {
        echo "\r\n\t\t\t\t\t<td align=center><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</a> \r\n          ";
        if ( $arrayhelpk[$k] != "" )
        {
            echo "<a href=# onclick=\"showhide('h{$k}');\">[?]</a>";
        }
        echo "\r\n           </td>\r\n\t\t";
    }
    echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t";
    foreach ( $arraymenutab as $k => $v )
    {
        printhelp( trim( $arrayhelp[$arrayhelpk[$k]] ), $id = "h{$k}" );
    }
    if ( $tab == 0 || $tab == "" )
    {
        if ( $statusoperatormakul == 1 && $prodis == getprodimakul( $idupdate ) || $prodis == "" )
        {
            include( "biodata.php" );
        }
        else
        {
            include( "dikti.php" );
        }
    }
    else if ( $tab == 1 )
    {
        include( "dikti.php" );
    }
}
if ( $_POST['sessid'] != $_SESSION['token'] )
{
    $errmesg = token_err_mesg( "Mata Kuliah", TAMBAH_DATA );
    $aksi = "formtambah";
}
else
{
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodi );
    $vld[] = cekvaliditaskodemakul( "Kode Mata Kuliah", $id, 20, false );
    $vld[] = cekvaliditasnama( "Nama Mata Kuliah", $data['nama'], 100, false );
    $vld[] = cekvaliditasinteger( "Semester", $data['semester'] );
    $vld[] = cekvaliditaskode( "Jenis", $data['jenis'], 1 );
    $vld[] = cekvaliditasnama( "Nama Mata Kuliah di Kurikulum", $namamakul2, 100, false );
    $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun2, $semester2 );
    $vld[] = cekvaliditaskode( "Jenjang Program Studi", $jenjang1, 2, false );
    $vld[] = cekvaliditasinteger( "SKS Kurikulum", $sks, 1, false );
    $vld[] = cekvaliditasinteger( "SKS Tatap Muka", $sks2, 1 );
    $vld[] = cekvaliditasinteger( "SKS Praktikum", $sks3, 1 );
    $vld[] = cekvaliditasinteger( "SKS Praktek Lapangan", $sks4, 1 );
    $vld[] = cekvaliditasinteger( "Penempatan Semester", $sem, 2 );
    $vld[] = cekvaliditaskode( "Kelompok Mata Kuliah", $kelompok, 2 );
    $vld[] = cekvaliditaskode( "Kurikulum Inti/Institusi", $kurikulum, 2 );
    $vld[] = cekvaliditaskode( "Mata Kuliah Wajib/Pilihan", $wajib, 2 );
    $vld[] = cekvaliditasnidn( "No Dosen pengampu", $dosen );
    $vld[] = cekvaliditaskode( "Jenjang Program Studi Pengampu", $jenjang, 2 );
    $vld[] = cekvaliditaskodeprodi( "Program Studi Pengampu", $prodi );
    $vld[] = cekvaliditaskode( "Status Mata Kuliah", $status, 2 );
    $vld[] = cekvaliditaskode( "Silabus", $silabus, 2 );
    $vld[] = cekvaliditaskode( "Satuan Acara Perkuliahan", $satuan, 2 );
    $vld[] = cekvaliditaskode( "Bahan Ajar", $bahan, 2 );
    $vld[] = cekvaliditaskode( "Diktat", $diktat, 2 );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2 );
        unset( $vld );
        $aksi = "formtambah";
    }
    else
    {
        cekhaktulis( $kodemenu );
        if ( trim( $id ) == "" )
        {
            $errmesg = "Kode Mata Kuliah harus diisi";
        }
        else if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Mata Kuliah harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tINSERT INTO makul (ID,NAMA,NAMA2,KET,IDPRODI,SKS,SEMESTER,JENIS,KELOMPOK) \r\n\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['nama2']}','{$data['ket']}','{$idprodi}',\r\n\t\t\t'{$sks}','{$data['semester']}','{$data['jenis']}','{$kelompok}')\r\n\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Tambah Mata Kuliah dengan ID={$id} ({$data['nama']})";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 18 );
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $q = "\r\n        INSERT INTO tbkmk\r\n        (THSMSTBKMK ,KDPTITBKMK ,KDPSTTBKMK ,KDJENTBKMK,KDKMKTBKMK ,NAKMKTBKMK ,\r\n        SKSMKTBKMK ,SKSTMTBKMK ,SKSPRTBKMK ,SKSLPTBKMK ,SEMESTBKMK ,\r\n        KDKELTBKMK ,KDKURTBKMK ,KDWPLTBKMK ,NODOSTBKMK ,JENJATBKMK ,\r\n        PRODITBKMK ,STKMKTBKMK ,SLBUSTBKMK ,SAPPPTBKMK ,BHNAJTBKMK ,\r\n        DIKTTTBKMK)\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$id}','{$data['nama']}',\r\n        '{$sks}','{$sks2}','{$sks3}','{$sks4}','{$sem}','{$kelompok}','{$kurikulum}',\r\n        '{$wajib}','{$dosen}','{$jenjang}','{$prodi}','{$status}','{$silabus}',\r\n        '{$satuan}','{$bahan}','{$diktat}')\r\n      ";
                mysqli_query($koneksi,$q);
                $errmesg = "Data Mata Kuliah berhasil ditambah";
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Mata Kuliah tidak berhasil ditambah. <br>\r\n      Kode Mata Kuliah sudah ada di basisdata. Silakan gunakan Kode Mata Kuliah yang lain.";
            }
			
			$aksi = "formtambah";
        }
        
    }
}
#echo $aksi;exit();
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Data Mata Kuliah", "bantuan" );
    printhelp( trim( $arrayhelp[tambahmakul] ), "bantuan" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan / Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Mata Kuliah *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=50" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Mata Kuliah Dalam Bahasa Inggris</td>\r\n\t\t\t<td>".createinputtext( "data[nama2]", $data[nama2], " class=masukan  size=50" )."</td>\r\n\t\t</tr>\r\n\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", $data[ket], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputtext( "data[semester]", $data[semester], " class=masukan size=4" )."</td>\r\n\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJenis\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=data[jenis]>\r\n\t\t\t\t\t\t";
    foreach ( $arrayjenismakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    include( "makul2.php" );
    echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    include( "../strip_input_error.php" );
    $aksi = " ";
    include( "prosestampilmakul.php" );
}
if ( $aksi == "" )
{
	echo "lll";exit();
    printjudulmenu( "Lihat Data Mata Kuliah ", "bantuan" );
    printhelp( trim( $arrayhelp[carimakul] ), "bantuan" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan / Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidepmakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kode MK</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,form.idprodi.value );\"" )."\r\n\t\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n <div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">\r\n               <div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\">\r\n\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama MK</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputtext( "semester", $semester, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>SKS</td>\r\n\t\t\t<td>".createinputtext( "sks", $sks, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJenis\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayjenismakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}*/

periksaroot();

if ($aksi=="hapus") {
//Husnil
//<code : begin>
if ($_GET['sessid'] != $_SESSION['token'])
{
	$errmesg = "Sesi Anda telah berubah. Data tidak dihapus";
	$aksi = "tampilkan";
}else{
	unset($_SESSION['token']);
//<code : end>
	cekhaktulis($kodemenu);
	//// Di sini harus ada cukup banyak syarat ////////////////////////////////
	$q="DELETE FROM makul WHERE ID='$idhapus'";
	mysqli_query($koneksi,$q) ;
	$ketlog="Hapus Mata Kuliah dengan ID=$idhapus";
	if (sqlaffectedrows($koneksi)>0) {
  	buatlog(20);
		$errmesg="Data Mata Kuliah dengan Kode = '$idhapus' berhasil dihapus";
  	$q="DELETE FROM tbkmk WHERE KDKMKTBKMK='$idhapus'";
  	mysqli_query($koneksi,$q) ;
	} else {
		$errmesg="Data Mata Kuliah dengan Kode = '$idhapus' tidak berhasil dihapus";
	}
	$aksi="tampilkan";
}
}

if ($aksi=="update") {
cekhaktulis($kodemenu);
  //echo $statusoperatormakul;
	if ($tab==0 || $tab=="") {
	  
	  
		if (($statusoperatormakul==1 && $prodis==getprodimakul($idupdate)) || $prodis=="") {
			echo "aaaa";
      include "biodata.php";
    } else {
		echo "bbb";
      include "dikti.php";
    }
	}	elseif ($tab==1) {
		echo "ccc";
		include "dikti.php";
	}	 
	
 	$aksi="formupdate";
}


if ($aksi=="formupdate") {
	cekhaktulis($kodemenu);
	#printjudulmenu("Update Data Mata Kuliah");
    /*echo "
<div class=\"page-content\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-12\">
            <br><br><br>
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class=\"portlet light\">
            <div class=\"portlet-title\">
        <div class=\"caption font-green-haze\">
<i class=\"icon-settings font-green-haze\"></i>
<span class=\"caption-subject bold uppercase\"> Update Data Mata Kuliah</span></div>";
echo "<div class=\"actions\"></div></div>
<div class=\"portlet-body form\"><div class=\"table-scrollable\">";*/
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Update Data Mata Kuliah");
								echo	"</div>
										
									</div>
									<div class='portlet-body form'>
                           <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr>\r\n\t";

	if (($statusoperatormakul==1 && $prodis==getprodimakul($idupdate)) || $prodis=="") 
	{
		$arraymenutab[0]="Data Master Mata Kuliah";
	}
	$arraymenutab[1]="Data Dikti/Kurikulum (Laporan per Semester)";
	
	/*echo "			
		<table width=95% class=\"table table-striped table-bordered table-hover\">
			<tr>
	";*/
	foreach ($arraymenutab as $k=>$v) {
		echo "
					<td align=center><a href='index.php?pilihan=$pilihan&aksi=$aksi&tab=$k&idupdate=$idupdate'>$v</a> 
          ";
          /*if ($arrayhelpk[$k]!="") {
          echo "<a href=# onclick=\"showhide('h$k');\">[?]</a>";
          }*/
          echo "
           </td>
		";
 
	}
	/*echo "
				</tr>
			</table>
	";*/	
     echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div></div>";	
	
	foreach ($arraymenutab as $k=>$v) {
     printhelp(trim($arrayhelp[$arrayhelpk[$k]]),$id="h$k");
	}
	/*echo "<div class=\"actions\"></div></div>
<div class=\"portlet-body form\"><div class=\"table-scrollable\">";*/
echo "<div class=\"m-portlet__body\">";	
						
	if ($tab==0 || $tab=="") {
		if (($statusoperatormakul==1 && $prodis==getprodimakul($idupdate)) || $prodis=="") {
			
      include "biodata.php";
    } else {
      include "dikti.php";
    }
	}	elseif ($tab==1) {
		#echo "kkkk";
		include "dikti.php";
	}	 
		
	echo "</div>";	

}





if ($aksi=="tambah"  && $REQUEST_METHOD==POST) {
//Husnil
//Code : begin
if ($_POST['sessid'] != $_SESSION['token'])
{
	$errmesg = token_err_mesg('Mata Kuliah',TAMBAH_DATA);
	$aksi = "formtambah";
}else{
	unset($_SESSION['token']);
	//echo "Tess";
	$vld[] = cekvaliditaskodeprodi("Kode Prodi",$idprodi);
	$vld[] = cekvaliditaskodemakul("Kode Mata Kuliah",$id,20,false);
	$vld[] = cekvaliditasnama("Nama Mata Kuliah",$data['nama'],100,false);
	$vld[] = cekvaliditasinteger("Semester",$data['semester']);
	$vld[] = cekvaliditaskode("Jenis",$data['jenis'],1);
	$vld[] = cekvaliditasnama('Nama Mata Kuliah di Kurikulum',$namamakul2,100,false);
	$vld[] = cekvaliditasthnajaran('Tahun/Semester Pelaporan Data',$tahun2,$semester2);
	$vld[] = cekvaliditaskode('Jenjang Program Studi',$jenjang1,2,false);
	//$vld[] = cekvaliditaskodeprodi('Program Studi',$prodi1,false);
	#$vld[] = cekvaliditasintegersks('SKS Kurikulum',$sks,1,false);
	#$vld[] = cekvaliditasintegersks('SKS Tatap Muka',$sks2,1);
	#$vld[] = cekvaliditasintegersks('SKS Praktikum',$sks3,1);
	#$vld[] = cekvaliditasintegersks('SKS Praktek Lapangan',$sks4,1);
	//$vld[] = cekvaliditasintegersks('Penempatan Semester',$sem,2);
	$vld[] = cekvaliditaskode('Kelompok Mata Kuliah',$kelompok,2);
	$vld[] = cekvaliditaskode('Kurikulum Inti/Institusi',$kurikulum,2);
	$vld[] = cekvaliditaskode('Mata Kuliah Wajib/Pilihan',$wajib,2);
	$vld[] = cekvaliditasnidn('No Dosen pengampu',$dosen);
	$vld[] = cekvaliditaskode('Jenjang Program Studi Pengampu',$jenjang,2);
	$vld[] = cekvaliditaskodeprodi('Program Studi Pengampu',$prodi);
	$vld[] = cekvaliditaskode('Status Mata Kuliah',$status,2);
	$vld[] = cekvaliditaskode('Silabus',$silabus,2);
	$vld[] = cekvaliditaskode('Satuan Acara Perkuliahan',$satuan,2);
	$vld[] = cekvaliditaskode('Bahan Ajar',$bahan,2);
	$vld[] = cekvaliditaskode('Diktat',$diktat,2);
	$vld = array_filter($vld,'filter_not_empty');
	if(isset($vld) && count($vld) > 0 )
	{
		$errmesg = val_err_mesg($vld,2);
		unset($vld);
		$aksi = "formtambah";
	}else{
//<code : end>
	cekhaktulis($kodemenu);
	if(trim($id)=="") {
		$errmesg="Kode Mata Kuliah harus diisi";
	} elseif(trim($data[nama])=="") {
		$errmesg="Nama Mata Kuliah harus diisi";
 	} else {
	   $q="
			INSERT INTO makul (ID,NAMA,NAMA2,KET,IDPRODI,SKS,SEMESTER,JENIS,KELOMPOK) 
			VALUES ('$id','$data[nama]','$data[nama2]','$data[ket]','$idprodi',
			'$sks','$data[semester]','$data[jenis]','$kelompok')
		";
		mysqli_query($koneksi,$q); 
		$ketlog="Tambah Mata Kuliah dengan ID=$id ($data[nama])";
		//echo mysql_error();
		if (sqlaffectedrows($koneksi)>0) {
  		buatlog(18);
		
		  $q="SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='$idprodi'";
			$h=mysqli_query($koneksi,$q);
			if (sqlnumrows($h)>0) {
			 $d=sqlfetcharray($h);
			 $kodept=$d[KDPTIMSPST];
			 $kodejenjang=$d[KDJENMSPST];
			 $kodeps=$d[KDPSTMSPST];
      }
		
		  $q="
        INSERT INTO tbkmk
        (THSMSTBKMK ,KDPTITBKMK ,KDPSTTBKMK ,KDJENTBKMK,KDKMKTBKMK ,NAKMKTBKMK ,
        SKSMKTBKMK ,SKSTMTBKMK ,SKSPRTBKMK ,SKSLPTBKMK ,SEMESTBKMK ,
        KDKELTBKMK ,KDKURTBKMK ,KDWPLTBKMK ,NODOSTBKMK ,JENJATBKMK ,
        PRODITBKMK ,STKMKTBKMK ,SLBUSTBKMK ,SAPPPTBKMK ,BHNAJTBKMK ,
        DIKTTTBKMK)
        VALUES
        ('$tahun2$semester2','$kodept','$kodeps','$kodejenjang','$id','$data[nama]',
        '$sks','$sks2','$sks3','$sks4','$sem','$kelompok','$kurikulum',
        '$wajib','$dosen','$jenjang','$prodi','$status','$silabus',
        '$satuan','$bahan','$diktat')
      ";
      mysqli_query($koneksi,$q); 
			$errmesg="Data Mata Kuliah berhasil ditambah";
			$data="";$id="";
 		} else {
			$errmesg="Data Mata Kuliah tidak berhasil ditambah. <br>
      Kode Mata Kuliah sudah ada di basisdata. Silakan gunakan Kode Mata Kuliah yang lain.";
		}
	}
	
 	$aksi="formtambah";
}
}
}


if ($aksi=="formtambah") {
//Husnil
//<code : begin>
	$token = md5(uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
//<code : end>

	cekhaktulis($kodemenu);
 	#printjudulmenu("Tambah Data Mata Kuliah","bantuan");
    printhelp(trim($arrayhelp[tambahmakul]),"bantuan");
	#printmesg($errmesg);
 		
/*echo "
<div class=\"page-content\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-12\">
            <br><br><br>
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class=\"portlet light\">
            <div class=\"portlet-title\">
        <div class=\"caption font-green-haze\">
<i class=\"icon-settings font-green-haze\"></i>
<span class=\"caption-subject bold uppercase\"> Tambah Mata Kuliah</span></div>

<div class=\"actions\"></div></div>
<div class=\"portlet-body form\"><div class=\"table-scrollable\">";*/
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
echo "			<div class='portlet-title'>";
					printmesg("Tambah Data Mata Kuliah");
echo "		</div>";
echo "		<div class=\"m-portlet\">
				<!--begin::Form-->";
echo "	       <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>".
				createinputhidden("pilihan",$pilihan,"").
				createinputhidden("sessid",$token,"").
				createinputhidden("aksi","tambah","").
        "<div class=\"m-portlet__body\">
				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
				<label class=\"col-form-label\">".createinputselect("idprodi",$arrayprodidep,$idprodi,'',"class=form-control m-input")."</label>
			</div>".
			"<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>\r\n    
					<label class=\"col-form-label\">".
						createinputtext("id",$id," class=form-control m-input  size=20").
		 "			</label>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah *</label>\r\n    
				<label class=\"col-form-label\">".
					createinputtext("data[nama]",""," class=form-control m-input  size=50").
				"</label>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah Dalam Bahasa Inggris</label>\r\n    
				<label class=\"col-form-label\">".
					createinputtext("data[nama2]",""," class=form-control m-input  size=50").
				"</label>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
				<label class=\"col-form-label\">".
					createinputtextarea("data[ket]",""," class=form-control m-input  cols=50 rows=4").
				"</label>
			</div>".
			"<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
				<label class=\"col-form-label\">".
					createinputtext("data[semester]",""," class=form-control m-input size=4").
				"</label>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
				<label class=\"col-form-label\">
						<select class=form-control m-input name=data[jenis]>
							";
							foreach ($arrayjenismakul as $k=>$v) {
								echo "<option value='$k'>$v</option>";
							}
							echo "
						</select>
				</label>
			</div>";
		
include "makul2.php";


echo "
			<div class=\"form-group m-form__group row\">
				<div class=\"col-lg-6\">
					<input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
					<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
				</div>
			</div>
			</div>
				</form>
			</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->
			<script>
 				form.id.focus();
			</script>
";


        if ( $d[FILE] != "" )
        {
            echo "\r\n        <img src='lihat.php?idupdate={$idupdate}' height=75> <br>\r\n        <input   type=checkbox name='hapusfilettd' value=1 > hapus file\r\n        ";
        }
        /*echo "\r\n      </td>\r\n\t\t\t</tr>\r\n      <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";*/

        
 }
 


if ($aksi=="tampilkan") {
    #include "../strip_input_error.php";
	$aksi=" ";
	include "prosestampilmakul.php";
}

if ($aksi=="") {
    #printjudulmenu("Lihat Data Mata Kuliah ","bantuan");
    #printhelp(trim($arrayhelp[carimakul]),"bantuan");
    #printmesg($errmesg);
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Lihat Data Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
    echo "
        <form name=form action=index.php method=post>
            <input type=hidden name=pilihan value='$pilihan'>
            <input type=hidden name=aksi value='tampilkan'>
            ".IKONCARI48."
        <table class=\"table table-striped table-bordered table-hover\" >";*/
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Data Mata Kuliah");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
								<div class=\"col-lg-6\">".
									createinputselect("idprodi",$arrayprodidep,$idprodi,''," class=form-control m-input").
            "					</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode MK</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext("id",$id," class=form-control m-input  size=20 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,form.idprodi.value );\" placeholder=\"Ketik Kode / Nama Makul...\"")."
									<!--<a href=\"javascript:daftarmakul('form,wewenang,id',document.form.id.value)\" >daftar mata kuliah</a>-->
									<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
										<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
									</div>
								</div>
							</div>".
        "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Nama MK</label>\r\n    
									<div class=\"col-lg-6\">".
										createinputtext("nama",$nama," class=form-control m-input  size=50").
            "						</div>
							</div> 
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
								<div class=\"col-lg-6\">".
									createinputtext("semester",$semester," class=form-control m-input  size=2").
            "					</div>
							</div> 
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
								<div class=\"col-lg-6\">".
									createinputtext("sks",$sks," class=form-control m-input  size=2").
            "					</div>
							</div> 
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=jenismakul>
									<option value=''>Semua</option>";
										foreach ($arrayjenismakul as $k=>$v) {
											echo "<option value='$k'>$v</option>";
										}
echo "		                    	</select>
								</div>
							</div>";
            /*
            <tr>    
                <td>
                    Kelompok
                </td>
                <td>
                    <select class=form-control m-input name=kelompokmakul>
                        <option value=''>Semua</option>";
                        foreach ($arraykelompokmakul as $k=>$v) {
                            echo "<option value='$k'>$v</option>";
                        }
                        echo "
                    </select>
                </td>
            </tr>
            */
            echo "
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Tampilkan' class=\"btn btn-brand\">
								</div>
							</div>
						</div>
        </form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
            <script>
                form.id.focus();
            </script>
    ";
}
?>

