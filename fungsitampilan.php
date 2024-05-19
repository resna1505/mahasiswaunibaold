<?php
function getpenandatangan( )
{
    global $koneksi;
    global $nipdirektur;
    global $namadirektur;
    global $nipkabag;
    global $namakabag;
    global $jabatandirektur;
    global $jabatankabag;
    global $namabaak;
    global $jabatanbaak;
    global $nipbaak;
    global $namadirektur2;
    global $nipdirektur2;
    global $jabatandirektur2;
    global $namadirektur5;
    global $nipdirektur5;
    global $jabatandirektur5;
    global $namakhs;
    global $nipkhs;
    global $jabatankhs;
    global $namapasca;
    global $nippasca;
    global $jabatanpasca;
    $q = "SELECT * from penandatanganumum WHERE ID=0 ";
    $h = mysqli_query($koneksi, $q);
    if ( 0 < mysqli_num_rows( $h ) )
    {
        $d = mysqli_fetch_array( $h );
        $nipdirektur = $d[NIPDIREKTUR];
        $namadirektur = $d[NAMADIREKTUR];
        $nipkabag = $d[NIPKABAG];
        $namakabag = $d[NAMAKABAG];
        $jabatandirektur = $d[JABATANDIREKTUR];
        $jabatankabag = $d[JABATANKABAG];
        $namabaak = $d[NAMABAAK];
        $jabatanbaak = $d[JABATANBAAK];
        $nipbaak = $d[NIPBAAK];
        $namadirektur2 = $d[NAMADIREKTUR2];
        $nipdirektur2 = $d[NIPDIREKTUR2];
        $jabatandirektur2 = $d[JABATANDIREKTUR2];
        $namadirektur5 = $d[NAMADIREKTUR5];
        $nipdirektur5 = $d[NIPDIREKTUR5];
        $jabatandirektur5 = $d[JABATANDIREKTUR5];
        $namakhs = $d[NAMAKHS];
        $nipkhs = $d[NIPKHS];
        $jabatankhs = $d[JABATANKHS];
        $namapasca = $d[NAMAPASCA];
        $nippasca = $d[NIPPASCA];
        $jabatanpasca = $d[JABATANPASCA];
    }
}

function getarraysemestercuti( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM\t= '{$idmahasiswa}' AND STMHSTRLSM = 'C' ORDER BY THSMSTRLSM";
    $h = mysqli_query($koneksi, $q);
	if(0 < mysqli_num_rows( $h )){
    #while ( !( 0 < mysqli_num_rows( $h ) ) || !( $d = mysqli_fetch_array( $h ) ) )
		while($d = mysqli_fetch_array( $h ))
		{
			$tahuncuti = substr( $d[THSMSTRLSM], 0, 4 );
			$semestercuti = substr( $d[THSMSTRLSM], 4, 1 );
			$tmp[$d[THSMSTRLSM]][tahun] = $tahuncuti;
			$tmp[$d[THSMSTRLSM]][semester] = $semestercuti;
		}
	}
    return $tmp;
}

function createinputtahunajaransemestercuti( $semua = 1, $semester = "semester", $idmahasiswa )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM\t= '{$idmahasiswa}' AND STMHSTRLSM = 'C' ORDER BY THSMSTRLSM";
	#echo $q;
    $h = mysqli_query($koneksi, $q);
    if ( 0 < mysqli_num_rows( $h ) )
    {
        $tmp .= "\r\n                <select name={$semester} class=masukan> \r\n              \r\n    \t\t\t\t\t\t ";
        if ( $semua == 1 )
        {
            $tmp .= "\r\n                    <option value=''>Semua</option>\r\n                  ";
        }
        while ( $d = mysqli_fetch_array( $h ) )
        {
            $tahuncuti = substr( $d[THSMSTRLSM], 0, 4 );
            $semestercuti = substr( $d[THSMSTRLSM], 4, 1 );
            $selected = "";
            if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
            {
                if ( $k == $waktu[year] + 1 )
                {
                    $selected = "selected";
                }
            }
            else if ( $k == $waktu[year] )
            {
                $selected = "selected";
            }
            $tmp .= "\r\n\t\t\t\t\t\t\t<option value='{$d['THSMSTRLSM']}' {$selected} >{$tahuncuti}/".( $tahuncuti + 1 )."  ".$arraysemester[$semestercuti]."  </option>\r\n\t\t\t\t\t\t\t";
        }
        $tmp .= "\r\n\t\t\t\t\t\t</select>\t";
    }
    else
    {
        $tmp = "Data cuti mahasiswa tidak ditemukan";
    }
    return $tmp;
}

function createinputtahunmasuk( $semua = 1, $tahun = "tahun", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=masukan> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    $arrayangkatan = getarrayangkatan( "", $addnumber );
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n  \r\n  ";
    return $tmp;
}

function createinputtahunakademik( $semua = 1, $tahun = "tahun", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=masukan> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    $arrayangkatan = getarrayangkatan( "K", $addnumber );
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".$v."/".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n  \r\n  ";
    return $tmp;
}

function createinputtahunajaransemester( $semua = 1, $tahun = "tahun", $semester = "semester", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
	#print_r($tmp);exit();
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    $arrayangkatan = getarrayangkatan( "K", $addnumber );
	#print_r($arrayangkatan);
#exit();
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".$v."/".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n            <select name={$semester} class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n            ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    foreach ( $arraysemester as $k => $v )
    {
        $selected = "";
        if ( $semesterganjil[bln] <= $waktu[mon] && $semesterganjil[tgl] <= $waktu[mday] )
        {
            if ( $k == 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $semestergenap[bln] <= $waktu[mon] && $semestergenap[tgl] <= $waktu[mday] && $k == 2 )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>  \r\n  \r\n  ";
    return $tmp;
}

function printheader()
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    global $csskantor;
    echo "\r\n    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head><meta charset=\"utf-8\"> <title>{$namaprogram} </title>\t\r\n    ";
  echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">";
echo "<meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\">";
echo "<meta content=\"\" name=\"description\">";
echo "<meta content=\"\" name=\"author\">";

	#include($root."javascript.js" );
	
	//================================== CSS ============================================================================
	//<!-- BEGIN GLOBAL MANDATORY STYLES -->
    echo "<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/font-awesome/css/font-awesome.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/bootstrap/css/bootstrap.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css\" type=\"text/css\" />";
    
	//<!-- END GLOBAL MANDATORY STYLES -->
    
	//<!-- BEGIN PAGE LEVEL PLUGINS -->
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/morris/morris.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/plugins/fullcalendar/fullcalendar.min.css\" type=\"text/css\" />";
	
	//<!-- END PAGE LEVEL PLUGINS -->
    
	//<!-- BEGIN THEME GLOBAL STYLES -->
    #echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/css/components.min.css\" id=\"style_components\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/global/css/plugins.min.css\" type=\"text/css\" />";
	
	//<!-- END THEME GLOBAL STYLES -->
    //<!-- BEGIN THEME LAYOUT STYLES -->
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/admin/layout3/css/layout.css\" type=\"text/css\" />";
    
	/*echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/admin/layout3/css/layout.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/admin/layout3/css/themes/default.min.css\" type=\"text/css\" id=\"style_color\"/>";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/admin/layout3/css/custom.min.css\" type=\"text/css\" />";
	*/
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/vendors/base/vendors.bundle.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/default{$css}/assets/demo/default/base/style.bundle.css\" type=\"text/css\" id=\"style_color\"/>";
    
	//<!-- END THEME LAYOUT STYLES -->
	
	echo "<style type='text/css'>
		#popup {
		background-color: rgba(0,0,0,0.8);
		position: fixed;
		top:0;		
		left:0;
		right:0;
		bottom:0;
		margin:0;			
	}

	.popup-container {
		position: relative;
		margin: auto;
		padding: 0px 50px;		
		color: #fff;
		border-radius: 3px;	
	}

	@media (min-width: 768px){
		.img-front-responsive{
			padding-top:0;
			width: 500px;
  			height: 590px;
		}
	}
	@media (max-width: 767px){
		.img-front-responsive{
			padding-top:15%;
			width: 100%;
  			height: auto;
		}
	}

	.form-02-main{
	  background:url(images/bg-01.jpg);
	  background-size:cover;
	  background-repeat:no-repeat;
	  background-position:center;
	  position:relative;
	  z-index:2;
	  overflow:hidden;
	}

	

	.form-03-main{
	  width:500px;
	  display:block;
	  margin:20px auto;
	  padding:25px 50px 25px;
	  background:rgba(255,255,255,0.6);
	  border-radius:6px;
	  z-index:9;
	}

	.logo{
	  display:block;
	  margin:20px auto;
	  width:100px;
	  height:100px;
	}

	.form-group{
	  padding:12px 0px;
	  display:inline-block;
	  width:100%;
	  position:relative;
	}

	.form-group p{
	  margin:0px;
	}

	.form-control{
	  min-height:45px;
	  -webkit-box-shadow: none;
	  box-shadow: none;
	  padding: 10px 15px;
	  border-radius:20px;
	  border:1px solid#2b3990;
	}

	@media screen and (max-width: 600px) {
	  .form-03-main{
		width: 100%;
	  }
	}
		

</style>";

    //================================== END CSS ============================================================================
	
	//================================== BEGIN JAVASCRIPT ============================================================================
	
	//<!-- BEGIN CORE PLUGINS -->
    //echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    //echo "<script src='".$root."/tampilan/lib/script_luar.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/bootstrap/js/bootstrap.min.js' type='text/javascript'></script>";
    #echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/js/js.cookie.min.js' type='text/javascript'></script>";
	echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js' type='text/javascript'></script>";
   	echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery.blockui.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js' type='text/javascript'></script>";
    //<!-- END CORE PLUGINS -->
    //<!-- BEGIN PAGE LEVEL PLUGINS -->
	 //<!-- END PAGE LEVEL PLUGINS -->
    //<!-- BEGIN THEME GLOBAL SCRIPTS -->
	echo "<script src='".$root."tampilan/{$csskantor}/assets/global/scripts/app.min.js' type='text/javascript'></script>";
    //<!-- END THEME GLOBAL SCRIPTS -->
    //<!-- BEGIN PAGE LEVEL SCRIPTS -->
	echo "<script src='".$root."tampilan/{$csskantor}/assets/pages/scripts/form-samples.min.js' type='text/javascript'></script>";
    //<!-- END PAGE LEVEL SCRIPTS -->
    //<!-- BEGIN THEME LAYOUT SCRIPTS -->
	#echo "<script src='".$root."tampilan/{$csskantor}/assets/admin/layout3/scripts/layout.min.js' type='text/javascript'></script>";
    #echo "<script src='".$root."tampilan/{$csskantor}/assets/admin/layout3/scripts/demo.min.js' type='text/javascript'></script>";
	//<!-- END THEME LAYOUT SCRIPTS -->
	
	//================================== END JAVASCRIPT ============================================================================
	
echo "	   <script type='text/javascript'>
		$(document).ready(function () {
    			//select the POPUP FRAME and show it
    			$('#popup').hide().fadeIn(1000);

    		//close the POPUP if the button with id='close' is clicked
    			$('#close').on('click', function (e) {
       				e.preventDefault();
        			$('#popup').fadeOut(1000);
    			});
		});
</script>";

    if ( $csskantor == "default" )
    {
        //echo "<script src='".$root."/tampilan/lib/snow.js' type='text/javascript'></script>";
    }
   
    #echo "<link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' /></head><body  onLoad='startclock()'  >\r\n\t<div class='gradient'>\r\n    <div id=\"wrap\">\r\n\t\r\n    ";
    echo "<link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' /></head><body>\r\n\t<div class='gradient'>\r\n    <div id=\"wrap\">\r\n\t\r\n    ";
        
#include( $root."tampilan/siteheader.php" );
}

function printmesg( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "<div class=\"alert alert-success\" style=\"font-color:red;\">{$errmesg}</div>";
		
    }
}

function printwarning( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "<div class=\"alert alert-success\" style=\"background-color:red;\">{$errmesg}</div>";
		
    }
}



function printtitle( $title )
{
    if ( $title != "" )
    {
        echo "<div class=\"alert alert-success\" style=\"background-image: linear-gradient(to right, rgb(66, 134, 244), rgb(55, 59, 68));\">{$title}</div>";
		
    }
}

function printheader_dlm( )
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    global $arraycss;
    global $csskantor;
    global $users_bank;
    $css = "";
    if ( $jenisusers === 0 )
    {
        $q = "SELECT CSS FROM user WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 1 )
    {
        $q = "SELECT CSS FROM dosen WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        $q = "SELECT CSS FROM mahasiswa WHERE ID='{$users}'";
    }
    else if ( session_is_registered_sikad( "users_bank" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    }
    else if ( session_is_registered_sikad( "users_pmb" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    }
	#echo $q.'<br>';
    $h = mysqli_query($koneksi, $q);
    if ( 0 < mysqli_num_rows( $h ) )
    {
        $d = mysqli_fetch_array( $h );
        $cssasli = $css = $d['CSS'];
    }
    if ( $arraycss[$css] == "" )
    {
        $css = "default";
    }
	$urlapp=$_SERVER['REQUEST_URI'];
	list($uri1,$uri2,$uri3)=explode("/",$urlapp);
	#echo "URI=".$uri3;
	echo "\r\n    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head><meta charset=\"utf-8\"> <title>{$namaprogram} </title>\t\r\n    ";
  echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">";
echo "<meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\" shrink-to-fit=no>";
echo "<meta content=\"\" name=\"description\">";
echo "<meta content=\"\" name=\"author\">";
echo "<!--begin::Web font -->
		<script src=\"".$root."tampilan/default/assets/vendors/base/webfont.js\"></script>
		<script>
          WebFont.load({
            google: {'families':['Poppins:300,400,500,600,700','Roboto:300,400,500,600,700']},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->";
echo "<!--begin::Base Styles -->  
        <!--begin::Page Vendors -->
			<link href=\"".$root."tampilan/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css\" rel=\"stylesheet\" type=\"text/css\" />
			<link href=\"".$root."tampilan/default/assets/vendors/custom/datatables/datatables.bundle.css\" rel=\"stylesheet\" type=\"text/css\" />
		<!--end::Page Vendors -->
			<link href=\"".$root."tampilan/default/assets/vendors/base/vendors.bundle.css\" rel=\"stylesheet\" type=\"text/css\" />
			<link href=\"".$root."tampilan/default/assets/demo/demo9/base/style.bundle.css\" rel=\"stylesheet\" type=\"text/css\" />
			<!--<link href=\"".$root."tampilan/default/assets/demo/default/base/style.bundle.css\" rel=\"stylesheet\" type=\"text/css\" />-->
		<!--end::Base Styles -->
			<link rel=\"shortcut icon\" href=\"".$root."tampilan/default/assets/demo/demo9/media/img/logo/favicon.ico\" />";
include( $root."javascript.js" );

echo "		<!--<script src='".$root."tampilan/default/assets/app/js/dashboard.js' type='text/javascript'></script>-->
		<!--end::Page Snippets -->   
		<!-- begin::Page Loader -->
		<!--begin::Page Vendors -->
		<script src='".$root."tampilan/default/assets/vendors/custom/datatables/datatables.bundle.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/summernote/summernote.js' type='text/javascript'></script>
		<!--<script src='".$root."tampilan/default/assets/vendors/custom/datatables/datatables-min.js' type='text/javascript'></script>-->";

		if($_GET['aksi']=="tagihanvamahasiswa"){
            echo "<script src='".$root."tampilan/default/assets/vendors/custom/chart/Chart.min.js' type='text/javascript'></script>";
            echo "<script src='".$root."tampilan/default/assets/vendors/custom/chart/chartjs-plugin-datalabels.min.js' type='text/javascript'></script>";
            echo "<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/highcharts.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/highcharts-more.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/solid-gauge.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/exporting.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/export-data.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/accessibility.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/variable-pie.js' type='text/javascript'></script>
            <link rel=\"stylesheet\" href='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/css/style.css'>
            <link rel=\"stylesheet\" href='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/css/bootstrap.min.css'>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
            <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
            <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
            <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap\" rel=\"stylesheet\">
            <script type=\"module\" src=\"https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js\"></script>
            <script nomodule src=\"https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js\"></script>
            <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js\"></script>
            <link href='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/fullcalendar.bundle.css' rel=\"stylesheet\" type=\"text/css\" />
            <script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/fullcalendar.bundle.js'></script>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css\">";
            $tmp .= "<script>
                        document.addEventListener('DOMContentLoaded', function () {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    });
                </script>";
                echo $tmp;		
		}
    
	
	//================================== CSS ============================================================================
	/*echo "<!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/font-awesome/css/font-awesome.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap/css/bootstrap.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css\" type=\"text/css\" />";
    
	echo "<!-- END GLOBAL MANDATORY STYLES -->
    
	<!-- BEGIN PAGE LEVEL PLUGINS -->";
	#echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css\" type=\"text/css\" />";
    #echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/morris/morris.css\" type=\"text/css\" />";
    #echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/fullcalendar/fullcalendar.min.css\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/select2/css/select2.min.css\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/select2/css/select2-bootstrap.min.css\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css\" type=\"text/css\" />";
	
	echo "<!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/css/components.min.css\" id=\"style_components\" type=\"text/css\" />";
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/global/css/plugins.min.css\" type=\"text/css\" />";
	
	echo "<!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->";
	#echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/layouts/layout3/css/layout.css\" type=\"text/css\" />";
    
	echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/layouts/layout3/css/layout.min.css\" type=\"text/css\" />";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/layouts/layout3/css/themes/default.min.css\" type=\"text/css\" id=\"style_color\"/>";
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/assets/layouts/layout3/css/custom.min.css\" type=\"text/css\" />";
	
	echo "<!-- END THEME LAYOUT STYLES -->";
	*/
	
    //================================== END CSS ============================================================================
	
	//================================== BEGIN JAVASCRIPT ============================================================================
	
	//<!-- BEGIN CORE PLUGINS -->
    //echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    //echo "<script src='".$root."/tampilan/lib/script_luar.js' type='text/javascript'></script>";
    /*echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/bootstrap/js/bootstrap.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/js.cookie.min.js' type='text/javascript'></script>";
	echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js' type='text/javascript'></script>";
   	echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/jquery.blockui.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js' type='text/javascript'></script>";
    echo "<!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
	<script src='".$root."tampilan/{$csskantor}/assets/global/scripts/app.min.js' type='text/javascript'></script>";
    echo "<!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src='".$root."tampilan/{$csskantor}/assets/pages/scripts/form-samples.min.js' type='text/javascript'></script>";
    echo "<!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
	<script src='".$root."tampilan/{$csskantor}/assets/layouts/layout3/scripts/layout.min.js' type='text/javascript'></script>";
    echo "<script src='".$root."tampilan/{$csskantor}/assets/layouts/layout3/scripts/demo.min.js' type='text/javascript'></script>
	<!-- END THEME LAYOUT SCRIPTS -->
	<!-- END PAGE LEVEL PLUGINS -->";
	*/
	echo "<!-- begin::Quick Nav -->	
    	<!--begin::Base Scripts -->
		<script src='".$root."tampilan/default/assets/vendors/base/vendors.bundle.js' type='text/javascript'></script>
		<!--<script src='".$root."tampilan/default/assets/demo/demo9/base/scripts.bundle.js' type='text/javascript'></script>-->
		<script src='".$root."tampilan/default/assets/demo/default/base/scripts.bundle.js' type='text/javascript'></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
		<script src='".$root."tampilan/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js' type='text/javascript'></script>
		<!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
		<!--<script src='".$root."tampilan/default/assets/app/js/dashboard.js' type='text/javascript'></script>-->
		<!--end::Page Snippets -->   
		<!-- begin::Page Loader -->
		<!--begin::Page Vendors -->
		<script src='".$root."tampilan/default/assets/vendors/custom/datatables/datatables.bundle.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/summernote/summernote.js' type='text/javascript'></script>
		<!--<script src='".$root."tampilan/default/assets/vendors/custom/datatables/datatables-min.js' type='text/javascript'></script>-->";
		if($uri3=="pengumuman"){
		echo "<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/highcharts.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/highcharts-more.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/solid-gauge.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/exporting.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/export-data.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/accessibility.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/code/modules/variable-pie.js' type='text/javascript'></script>
		<link rel=\"stylesheet\" href='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/css/style.css'>
		<link rel=\"stylesheet\" href='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/css/bootstrap.min.css'>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
		<script src='".$root."tampilan/default/assets/vendors/custom/chart/highcharts/bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
		
		<script nomodule src=\"https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js\"></script>
		<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js\"></script>
		<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css\">";	
		$tmp .= "<script>
            		document.addEventListener('DOMContentLoaded', function () {
               		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
                	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    		return new bootstrap.Tooltip(tooltipTriggerEl);
                	});
            	});
        	</script>";
        	echo $tmp;
		}
echo"		<!--end::Page Vendors -->  
        <!--begin::Page Resources -->
		<!--<script src='".$root."tampilan/default/assets/demo/demo9/custom/crud/datatables/basic/scrollable.js' type='text/javascript'></script>-->
		<!--end::Page Resources -->
		<script>
            $(window).on('load', function() {
                $('body').removeClass('m-page--loading');         
            });
		";
echo"			$(document).ready(function() {
				$('#m_table_1').DataTable( {
					scrollY:'50vh',
					scrollX:!0,
					scrollCollapse:!0,
					ordering: false
				} );
			} );
			
			$(document).ready(function() {
				$('#ket').summernote({				  	
				  height: '300px',
				  styleWithSpan: false,
				  toolbar: [
					// [groupName, [list of button]]
					  ['font', ['bold', 'underline', 'clear']],
					  ['fontname', ['fontname']],
					  ['para', ['ul', 'ol', 'paragraph']],
					  ['insert', ['link']],
					  ['view', ['help']],
				  ]
				});
				
				$('#isi').summernote({				  	
				  height: '300px',
				  styleWithSpan: false,
				  toolbar: [
					// [groupName, [list of button]]
					  ['font', ['bold', 'underline', 'clear']],
					  ['fontname', ['fontname']],
					  ['para', ['ul', 'ol', 'paragraph']],
					  ['insert', ['link']],
					  ['view', ['help']],
				  ]
				});
				$('#isi2').summernote({				  	
				  height: '300px',
				  styleWithSpan: false,
				  toolbar: [
					// [groupName, [list of button]]
					  ['font', ['bold', 'underline', 'clear']],
					  ['fontname', ['fontname']],
					  ['para', ['ul', 'ol', 'paragraph']],
					  ['insert', ['link']],
					  ['view', ['help']],
				  ]
				});
				";
	if ($uri3 == "pengumuman") {
        echo "
        getAjaxDataIpk();
        function getAjaxDataIpk(){
            $.ajax({
                url: 'dataIPK.php',
                method: 'POST',
                dataType: 'json',
                success: function(dataIPK) {
                    Highcharts.chart('ipk-mahasiswa', {
                        credits: {
                            enabled: false
                        },
                        chart: {
                            type: 'area',
                            height: 183,
                        },
                        title: {
                            text: null,
                            align: 'left'
                        },
                        subtitle: {
                            text: null,
                            align: 'left'
                        },
                        xAxis: {
                            lineColor: 'transparent',
                            lineWidth: 0,
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8'],
                            tickInterval: 1,
                            title: {
                                text: 'Grafik IPS Semester'
                            }
                        },
                        yAxis: {
                            title: null,
                            labels: {
                                enabled: false // Menghilangkan label di sumbu y
                            },
                            min: 2,
                            max: 4,
                        },
                        tooltip: {
                            shared: true,
                        },
                        plotOptions: {
                            series: {
                                // pointStart: 1,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}',
                                    style: {
                                        color: '#004680',
                                        fontSize: '12px'
                                    }
                                }
                            },
                            area: {
                                stacking: 'normal',
                                lineColor: '#004680',
                                lineWidth: 1,
                                marker: {
                                    lineWidth: 4,
                                    lineColor: '#004680',
                                    fillColor: '#004680',
                                },
                                fillOpacity: 1,
                                fillColor: 'rgba(227, 234, 250, 1)'
                            }
                        },
                        series: dataIPK.series,
                    });
                },
                cache: false
            });
        }

    /* Highcharts.chart('ipk-mahasiswa', {
        credits: {
            enabled: false
        },
        chart: {
            type: 'area',
            height: 183,
        },
        title: {
            text: null,
            align: 'left'
        },
        subtitle: {
            text: null,
            align: 'left'
        },
        xAxis: {
            lineColor: 'transparent',
            lineWidth: 0,
            categories: ['1', '2', '3', '4', '5', '6', '7', '8'],
            tickInterval: 1,
            title: {
                text: 'Grafik IPS Semester'
            }
        },
        yAxis: {
            title: null,
            labels: {
                enabled: false // Menghilangkan label di sumbu y
            },
            min: 2,
            max: 4,
        },
        tooltip: {
            shared: true,
        },
        plotOptions: {
            series: {
                // pointStart: 1,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}',
                    style: {
                        color: '#004680',
                        fontSize: '12px'
                    }
                }
            },
            area: {
                stacking: 'normal',
                lineColor: '#004680',
                lineWidth: 1,
                marker: {
                    lineWidth: 4,
                    lineColor: '#004680',
                    fillColor: '#004680',
                },
                fillOpacity: 1,
                fillColor: 'rgba(227, 234, 250, 1)'
            }
        },
        series: [{
            name: 'IPS',
            data: [3.68, 3.54, 3.63, 3.57, 3, 3.53, 3.7, 3.6],
            showInLegend: false
        }]
    }); */
    ";

	}
echo "
			  });
		</script>";

	//================================== END JAVASCRIPT ============================================================================
    
    #include( $root."tampilan/jam.php" );
    #echo "<script type='text/javascript'>$(function() { $('#chkall').click(function() { $('.chkbox').attr('checked', $( this ).is( ':checked' ) ? 'checked' :'');});});</script>";
	#echo "<script type='text/javascript'>$(function() { $('#chkall').click(function() { $('.chkbox').attr('checked', $( this ).is( ':checked' ) ? 'checked' :'');}); $('#exceljadwal').click(function(){if($('#hal').val()=='' || $('#hal').val()==undefined) {h=0} else {h=$('#hal').val()} location.href='export_excel.php?tahunmasuk='+$('#tahunmasuk').val()+'&hal='+h});$('#exceljadwal').click(function(){if($('#hal').val()=='' || $('#hal').val()==undefined) {h=0} else {h=$('#hal').val()} location.href='export_excel.php?semester='+$('#semester').val()+'&tahun='+$('#tahun').val()+'&iddepartemen='+$('#iddepartemen').val()+'&makul='+$('#makul').val()+'&kelasjadwal='+$('#kelasjadwal').val()+'&hari='+$('#hari').val()+'&hal='+h})});</script>";    
	#echo "    </head>\r\n        <body  onLoad='startclock()'  >\r\n         {$scr}\r\n        <div id=\"wrap\">\r\n        ";
	#echo "    </head>\r\n        <body class=\"page-container-bg-solid wysihtml5-supported\"><div class=\"page-wrapper\">\r\n        ";
echo "<script type='text/javascript'>$(function() { 
		$('#chkall').click(function() { 
			$('.chkbox').attr('checked', $( this ).is( ':checked' ) ? 'checked' :'');
		});
		$('#chkallva').change(function(){  //'select all' change 
			var status = this.checked; // 'select all' checked status
			$('.chkboxva').each(function(){ //iterate all listed checkbox items
				this.checked = status; //change '.checkbox' checked status
			});
		});

		$('.chkboxva').change(function(){ //'.checkbox' change 
			//uncheck 'select all', if one of the listed checkbox item is unchecked
			if(this.checked == false){ //if this item is unchecked
				$('#select_all')[0].checked = false; //change 'select all' checked status to false
			}
			
			//check 'select all' if all checkbox items are checked
			if ($('.chkboxva:checked').length == $('.chkboxva').length ){ 
				$('#select_all')[0].checked = true; //change 'select all' checked status to true
			}
		});	 
			
			$('#exceljadwal').click(function(){
				if($('#hal').val()=='' || $('#hal').val()==undefined) {
						h=0
					}				
				else {
					h=$('#hal').val()
				} 
				
				location.href='export_excel.php?tahun='+$('#tahun').val()+'&semester='+$('#semester').val()+'&iddepartemen='+$('#iddepartemen').val()+'&makul='+$('#makul').val()+'&kelasjadwal='+$('#kelasjadwal').val()+'&hari='+$('#hari').val()+'&hal='+h
			});
				
			$('#exceldosen').click(function(){
				if($('#hal').val()=='' || $('#hal').val()==undefined) {
					h=0
				} 
				else {
					h=$('#hal').val()
				} 
				
				if($('#lihatsemua').val()=='' || $('#lihatsemua').val()==undefined) {
					lihatsemua=0
				} 
				else {
					lihatsemua=$('#lihatsemua').val()
				} 
				
				location.href='export_excel.php?iddepartemen='+$('#iddepartemen').val()+'&nama='+$('#nama').val()+'&id='+$('#id').val()+'&status='+$('#status').val()+'&hal='+h+'&lihatsemua='+lihatsemua
			});
		});
	
	</script>";   	
echo "    </head>";
	echo "<body class=\"m--skin- m-page--loading-enabled m-page--loading m-content--skin-light m-header--fixed m-header--fixed-mobile m-aside-left--offcanvas-default m-aside-left--enabled m-aside-left--fixed m-aside-left--skin-dark m-aside--offcanvas-default\"> ";
	echo "<!-- begin::Page loader -->
		<div class=\"m-page-loader m-page-loader--base\">
			<div class=\"m-blockui\">
				<span>
					Please wait...
				</span>
				<span>
					<div class=\"m-loader m-loader--brand\"></div>
				</span>
			</div>
		</div>
		<!-- end::Page Loader -->";
   include( $root."tampilan/siteheader_dlm.php" );
}


function printmenudropdown($arraymenu){
	include $root."unik.php";
	global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	global $tingkats,$tingkataksesusers,$users,$borderdata,$root,$arrayikonsubmenu,$jenisusers,$namausers;
	$jumlahmenu=count($arraymenu);
	$ii=0;
 	
		#echo "KELOMPOK MENU".'<br>';
		#print_r($arraykelompokmenu).'<br>';
 		$tmp="<div class=\"m-stack__item m-stack__item--middle m-stack__item--left m-header-head\" id=\"m_header_nav\">
				<div class=\"m-stack m-stack--ver m-stack--desktop\">
					<div class=\"m-stack__item m-stack__item--middle m-stack__item--fit\">
						<!-- BEGIN: Aside Left Toggle -->
									<!--<a href=\"javascript:;\" id=\"m_aside_left_toggle\" class=\"m-aside-left-toggler m-aside-left-toggler--left m_aside_left_toggler\">
										<span></span>
									</a>-->
									<!--<a href=\"index.html\" class=\"m-brand__logo-wrapper\">
										<img alt=\"\" src=\"assets/demo/demo9/media/img/logo/logo.png\"/>
									</a>-->
									<!-- END: Aside Left Toggle -->
					</div>
					<div class=\"m-stack__item m-stack__item--fluid\">
						<!-- BEGIN: Horizontal Menu -->
						<button class=\"m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark\" id=\"m_aside_header_menu_mobile_close_btn\">
							<i class=\"la la-close\"></i>
						</button>
						<div id=\"m_header_menu\" class=\"m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark\">
							<ul class=\"m-menu__nav  m-menu__nav--submenu-arrow\">";
	foreach ($arraykelompokmenu as $kk=>$vv) {
		#print_r($kk).'<br>';
 		$kelas=kelasmenu($ii);
	 	$tmpx = "";
			//tampilkan kelompok menu sebagai menu utama yaitu akademik,perkuliahan dan lainnya.
    
		#$tmpx .= "
	    #         <li><a href='#' class='menulink'>Kelompok Menu=$vvvv</a><ul>
        #         ";
						$tmpx .="	
								<li class=\"m-menu__item  m-menu__item--submenu m-menu__item--rel\"  m-menu-submenu-toggle=\"click\" aria-haspopup=\"true\">
									<a  href=\"javascript:;\" class=\"m-menu__link m-menu__toggle\">
										<span class=\"m-menu__item-here\"></span>
											<i class=\"m-menu__link-icon flaticon-analytics\"></i>
												<span class=\"m-menu__link-text\">$vv</span>
														<i class=\"m-menu__hor-arrow la la-angle-down\"></i>
														<i class=\"m-menu__ver-arrow la la-angle-right\"></i>
									</a>
								";
						$tmpx .="	<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--left\">
										<span class=\"m-menu__arrow m-menu__arrow--adjust\"></span>
										<ul class=\"m-menu__subnav\">
								";
    	$k=0;
		#echo "KELOMPOK MENU".'<br>';
		#print_r($arraykelompokmenu).'<br>';
		
		#echo "ARRAY MENU".'<br>';
		#print_r($arraymenu).'<br>';
		//$filesubmenu="../".str_replace("index.php","",$v[href])."/submenu.php";
                      
		foreach ($arraymenu as $i=>$v) {
			#echo "ISI V ADALAH".'<br>';
		
			#print_r($v).'<br>';
			#echo "ZZZ".$v[k]."CC".$kk;
			if ($v['k']!=$kk) {
				#echo "XXX".$v[Judul].'<br>';
				continue ;
			} 
			#else {
				$bolehdiakses=false;
				#echo "AAA".$v[t].'<br>'."MM".$tingkataksesusers[$v[t]];
				if ($v['t']!="" && $tingkataksesusers[$v['t']]!="") {
					$bolehdiakses=true;
				}
				#echo $bolehdiakses."MMM";
				#print_r(session_is_registered_sikad("tingkats")).'AKAK ';
				#if  (session_is_registered_sikad("tingkats") && ($bolehdiakses || ($v[t]==""))) {
				if  (session_is_registered_sikad("tingkats") && ($bolehdiakses || ($v['t']==""))) {
					#echo "AAmmm".'<br>';
  					  #$tmpx.= " <li> <a href='../$vvv[href]'  class='sub'>MENU=$vvv[Judul]</a>";
					  
					  //menu pertama
					  
					  
					  if ($v['href']!="") {
						/*$tmpx.="	<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
										<span class=\"m-menu__arrow\"></span>
										<ul class=\"m-menu__subnav\">			
									";  */
						$tmpx .="			<li class=\"m-menu__item  m-menu__item--submenu\"  m-menu-submenu-toggle=\"hover\" m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
												<a href=\"javascript:;\" class=\"m-menu__link m-menu__toggle\">																
													<span class=\"m-menu__link-text\">
														$v[Judul]
													</span>
													<i class=\"m-menu__hor-arrow la la-angle-right\"></i>
													<i class=\"m-menu__ver-arrow la la-angle-right\"></i>
												</a>
								";
						$tmpx.="				<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
													<span class=\"m-menu__arrow\"></span>
													<ul class=\"m-menu__subnav\">			
								";
						
					  }else{
						$tmpx .="						<li class=\"m-menu__item  m-menu__item--submenu\"  m-menu-submenu-toggle=\"hover\" m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
												<a href=\"../$v[href]\" class=\"m-menu__link m-menu__toggle\">																
													<span class=\"m-menu__link-text\">
														$v[Judul]
													</span>
													
												</a>";
					  }
					 /* $tmpx .="						<li class=\"m-menu__item  m-menu__item--submenu\"  m-menu-submenu-toggle=\"hover\" m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
												<a href=\"../$v[href]\" class=\"m-menu__link m-menu__toggle\">																
													<span class=\"m-menu__link-text\">
														$v[Judul]
													</span>
													
												</a>";*/
					unset($arraysubmenu);
                      $filesubmenu="../".str_replace("index.php","",$v['href'])."submenu.php";
					  #echo $filesubmenu;
                      $dirsubmenu="../".str_replace("index.php","",$v['href'])."";
					 #echo "KELOMPOK SUB MENU".'<br>';
					#print_r($arraysubmenu).'<br>';
                    if (file_exists($filesubmenu)) {
                          include "../".str_replace("index.php","",$v['href'])."/submenu.php";
						  #print_r($arraysubmenu).'<br>';
                        if (is_array($arraysubmenu)) {
							#$tmpx.=" <ul> ";
								/*$tmpx.="<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
													<span class=\"m-menu__arrow\"></span>
													<ul class=\"m-menu__subnav\">							
									";*/
					
                            foreach ($arraysubmenu as $ksub=>$vsub) {
                          		#if ($v[t]=="T" && $tingkataksesusers[$kodemenu]!="T") {
                          		
								#} else {
        
                                #if ($v[href]!="") {
                                if ( $vsub['t'] == "T" && $tingkataksesusers[$kodemenu] != "T" )
								{
									continue;
									
								}else{
									
								   
                                  #$tmpx.=" <li><a href='".$dirsubmenu."$v[href]'>".$arrayikonsubmenu[$v[ico]]." $v[Judul]</a></li>";
								  #$tmpx .= " <li><a href='".$dirsubmenu."$vv[href]'>SUB MENU=$vv[Judul]</a></li>";
									if ($vsub['href']!="") {
										
										$tmpx .="
														<li class=\"m-menu__item \"  m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
																			<a  href='".$dirsubmenu."{$vsub['href']}' class=\"m-menu__link \">
																				<span class=\"m-menu__link-text\">
																					$vsub[Judul]
																				</span>
																			</a>
														</li>							
										 ";
								  
									}else{
										
										$tmpx .= "
														<li class=\"m-menu__item  m-menu__item--submenu\"  m-menu-submenu-toggle=\"hover\" m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
															<a  href=\"javascript:;\" class=\"m-menu__link m-menu__toggle\">
																<span class=\"m-menu__link-text\">
																	$vsub[Judul]
																</span>
																<i class=\"m-menu__hor-arrow la la-angle-right\"></i>
																<i class=\"m-menu__ver-arrow la la-angle-right\"></i>
															</a>														
												";
												
										$tmpx.="			<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
																<span class=\"m-menu__arrow \"></span>
																<ul class=\"m-menu__subnav\">		
												";
										
									}
								#}
										  unset($arraysubsubmenu);
										  $filesubsubmenu="../".str_replace("index.php","",$v['href'])."subsubmenu.php";
										  #echo $filesubsubmenu;
										  $dirsubsubmenu="../".str_replace("index.php","",$v['href'])."";
										  #echo "KELOMPOK SUB SUB MENU".'<br>';
										#print_r($arraysubmenu).'<br>';
											if (file_exists($filesubsubmenu)) {
												#echo "kesini";
												#print_r($vv[k]).'<br>';
												include "../".str_replace("index.php","",$v['href'])."subsubmenu.php";
												if (is_array($arraysubsubmenu)) {
													#print_r($arraysubsubmenu).'<br>';
													#$tmpx.=" <ul> ";
													#$tmpx.="
													#	<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
													#								<span class=\"m-menu__arrow \"></span>
													#								<ul class=\"m-menu__subnav\">
													#";
													/*$tmpx.="
															<div class=\"m-menu__submenu m-menu__submenu--classic m-menu__submenu--right\">
																						<span class=\"m-menu__arrow \"></span>
																						<ul class=\"m-menu__subnav\">		
														";*/
														
													foreach ($arraysubsubmenu as $k=>$vsubsub) {
														if ( $vsubsub['k'] != $ksub )
														{
															continue;
														}
														else{
														#if ($v[t]!="" && $v[href]=="") {
															if ( $tipe == ""  && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
															{	
																#$tmpx .= " <li><a href='".$dirsubmenu."$v[href]'>$v[Judul]</a></li>";
																if ($vsubsub['t'] == "T" && $tingkataksesusers[$kodemenu] != "T" ){
																		continue;
																	}else{

										$tmpx .= " 						<li class=\"m-menu__item \"  m-menu-link-redirect=\"1\" aria-haspopup=\"true\">
																						<a  href='".$dirsubsubmenu."{$vsubsub['href']}' class=\"m-menu__link \">
																							<span class=\"m-menu__link-text\">
																								{$vsubsub['Judul']}
																							</span>
																						</a>
																		</li>";
																	}
															}
														}
														#}
														
													}
													
													#$tmpx.=" </ul></div> ";
												}
												
												if ($vsub['href']=="") {
													#$tmpx.="</li>";
												#}else{
													$tmpx.="</ul></div></li> ";
												}
											}
											#$tmpx.=" </ul></div> ";
									#}
							}
							   #$tmpx.=" </ul></div> ";
						}
					}
						$tmpx.= " </ul></div></li> ";	
					$k++;
					$j++;
				}
			}
		}
            
		$tmpx.= "					</ul>
									</div>
								</li>";
 		if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		}
 	}
	$tmp.="</div></div></div></div>";
	$tmp.="<div class=\"m-stack__item m-stack__item--middle m-stack__item--center\">
							<!-- BEGIN: Brand -->
							<!--<a href=\"index.html\" class=\"m-brand m-brand--desktop\">
								<img alt=\"\" src=\"assets/demo/demo9/media/img/logo/logo.png\"/>
							</a>-->
							<!-- END: Brand -->
						</div>";
	$tmp.="<div class=\"m-stack__item m-stack__item--right\">
							<!-- BEGIN: Topbar -->
							<div id=\"m_header_topbar\" class=\"m-topbar  m-stack m-stack--ver m-stack--general\">
								<div class=\"m-stack__item m-topbar__nav-wrapper\">
									<ul class=\"m-topbar__nav m-nav m-nav--inline\">
										<li class=\"m-nav__item m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light\" m-dropdown-toggle=\"click\">
											<a href=\"#\" class=\"m-nav__link m-dropdown__toggle\">
												<span class=\"m-topbar__username m--hidden-mobile\">".
													printid($users)."
												</span>
												<span class=\"m-topbar__userpic\">
													<img src=\"".$root."tampilan/default/assets/app/media/img/users/no_photo.jpg\" class=\"m--img-rounded m--marginless m--img-centered\" alt=\"\"/>
												</span>
												<span class=\"m-nav__link-icon m-topbar__usericon  m--hide\">
													<span class=\"m-nav__link-icon-wrapper\">
														<i class=\"flaticon-user-ok\"></i>
													</span>
												</span>
											</a>
											<div class=\"m-dropdown__wrapper\">
												<span class=\"m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust\"></span>
												<div class=\"m-dropdown__inner\">
													<div class=\"m-dropdown__header m--align-center\">
														<div class=\"m-card-user m-card-user--skin-light\">
															<div class=\"m-card-user__pic\">
																<img src=\"".$root."tampilan/default/assets/app/media/img/users/no_photo.jpg\" class=\"m--img-rounded m--marginless\" alt=\"\"/>
															</div>
															<div class=\"m-card-user__details\">
																<span class=\"m-card-user__name m--font-weight-500\">".
																	printid($namausers)."
																</span>
																
															</div>
														</div>
													</div>
													<div class=\"m-dropdown__body\">
														<div class=\"m-dropdown__content\">
															<ul class=\"m-nav m-nav--skin-light\">
																<li class=\"m-nav__section m--hide\">
																	<span class=\"m-nav__section-text\">
																		Section
																	</span>
																</li>
																
																
																<li class=\"m-nav__separator m-nav__separator--fit\"></li>
																<li class=\"m-nav__item\">
																	<a href=\"index.php?aksi=logout\" class=\"btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder\">
																		Logout
																	</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
										
									</ul>
								</div>
							</div>
							<!-- END: Topbar -->
						</div>
					</div>
				";
	#$tmp.=$tmpx;
	#$tmp .= "<li><a href='index.php?aksi=logout' class='menulink'>Logout</a></li>       </ul><ul class='rightlink'><li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
    
	
}

function createsubmenu( $judul, $kode, $arraysubmenu, $tipe = "" )
{
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
	
	
    echo "\r\n         <div class='submenu'>\r\n         <h2 class='titlebar'>{$judul}</h2>\r\n         <ul class='leftnav'>\r\n         ";
    $jj = 0;
	/*if($judul==='Data Mahasiswa'){
	
		$hasil = "	<li> <a href='?' >Akademik</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Nilai Semester</a></li><li> <a href='' >Konversi Nilai</a></li>
					<li> <a href='?' >Kelulusan/Cuti/Non Aktif/DO</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>";
	}*/
	#echo $hasil;	
    foreach ( $arraysubmenu as $ia => $va )
    {
        if ( !isangka( $ia ) )
        {
            $hasil = "</ul><h2 class='titlebarbottom'>{$va['Judul']}</h2><ul class='leftnav'>";
        }
        else
        {
            #$hasil = "<li> <a href='{$va['href']}' >".$arrayikonsubmenu[$va[ico]]." {$va['Judul']}</a></li>";
			$hasil = "<li> <a href='{$va['href']}' >{$va['Judul']}</a></li>";
        }
        if ( $va[t] == "T" && $tingkataksesusers[$kode] != "T" )
        {
            continue;
        }
        if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
        {
            echo " {$hasil}  ";
            $jj++;
        }
    }
    echo "</ul></div>";
}

function printmenudropdownbank($arraysubmenu){
	include $root."unik.php";
	#global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	#global $tingkats,$tingkataksesusers,$users,$borderdata,$users_bank,$root,$arrayikonsubmenu,$jenisusers;
	global $tingkats_bank,$users_bank;
	$jumlahmenu=count($arraysubmenu);
	$ii=0;
	$tipe="bank";
	#print_r($kodemenu);
	#print_r($tingkataksesusers);
 	$tmp="
        <!-- navigator -->
        <div id='navigator'>
        <ul class='menu' id='menu'>				 
        ";
		#include("")
		#print_r($arraysubmenu);
		foreach ($arraysubmenu as $kk=>$vv) {
			#print_r($arraykelompokmenu);
			#echo '<br>';
			#print_r($kk);
			#echo '<br>';
			#print_r($vv);
			#echo '<br>';
			$kelas=kelasmenu($ii);
			$tmpx = "";
			if ( $vv[t] == "T" && session_is_registered_sikad( "tingkats_bank" ) != "T" )
			{
				continue;
			}
			if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
			{
				#echo " {$hasil}  ";
				#$jj++;
				$tmpx .= "
					 <li><a href='$vv[href]' class='menulink'>$vv[Judul] </a>
					 ";
			}
			
		#	$k=0;
		#$tmpx.= "</ul></li>";	
		$tmpx.= "</li>";
 		#if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		#}
 	}
	#$q = "SELECT * FROM operatorbank WHERE ID='{$users_bank}'";
	#echo $q;
	#$h = mysqli_query($koneksi, $q);
	#$d = mysqli_fetch_array( $h );

	#$tmp.=$tmpx;
	#$tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    $tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank}</strong></li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
		
}

function printmenudropdownpmb($arraysubmenu){
	include $root."unik.php";
	#global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	#global $tingkats,$tingkataksesusers,$users,$borderdata,$users_bank,$root,$arrayikonsubmenu,$jenisusers;
	global $tingkats_pmb,$users_pmb,$namausers_pmb;
	$jumlahmenu=count($arraysubmenu);
	$ii=0;
	$tipe="pmb";
	#print_r($kodemenu);
	#print_r($tingkataksesusers);
 	$tmp="
        <!-- navigator -->
        <div id='navigator'>
        <ul class='menu' id='menu'>				 
        ";
		#include("")
		#print_r($arraysubmenu);
		foreach ($arraysubmenu as $kk=>$vv) {
			#print_r($arraykelompokmenu);
			#echo '<br>';
			#print_r($kk);
			#echo '<br>';
			#print_r($vv);
			#echo '<br>';
			$kelas=kelasmenu($ii);
			$tmpx = "";
			if ( $vv[t] == "T" && session_is_registered_sikad( "tingkats_pmb" ) != "T" )
			{
				continue;
			}
			if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
			{
				#echo " {$hasil}  ";
				#$jj++;
				$tmpx .= "
					 <li><a href='$vv[href]' class='menulink'>$vv[Judul] </a>
					 ";
			}
			
		#	$k=0;
		#$tmpx.= "</ul></li>";	
		$tmpx.= "</li>";
 		#if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		#}
 	}
	#$q = "SELECT * FROM operatorbank WHERE ID='{$users_bank}'";
	#echo $q;
	#$h = mysqli_query($koneksi, $q);
	#$d = mysqli_fetch_array( $h );

	#$tmp.=$tmpx;
	#$tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    $tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$namausers_pmb}</strong></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
		
}

function printfooter_dlm( )
{
	global $koneksi;	
    $q = "SELECT * FROM mspti LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    $r = mysqli_fetch_array( $h );
	/*echo "<div class=\"page-wrapper-row\">
                <div class=\"page-wrapper-bottom\">
                    <!-- BEGIN FOOTER -->
                    <!-- BEGIN PRE-FOOTER -->
                    <div class=\"page-prefooter\">
                        <div class=\"container\">
							<div class=\"row\"></div>
						</div>
					</div>";
    echo "\r\n         <!-- footer -->\r\n
                        <div class=\"page-footer\" id=\"footer\">\r\n
                        <div class=\"container\">\r\n
                        Academic Management System  {$r['NMPTIMSPTI']} <br/> Developed by &#169; ICT {$r['NMPTIMSPTI']}\r\n
                        </div>\r\n
                        </div>\r\n         
                        <!-- end footer -->\r\n         ";
	echo "<div class=\"scroll-to-top\" style=\"display: block;\">
                        <i class=\"icon-arrow-up\"></i>
                    </div>";*/
	
	echo "<!-- begin::Footer -->
			<footer class=\"m-grid__item  m-footer \">
				<div class=\"m-container m-container--responsive m-container--xxl m-container--full-height\">
					<div class=\"m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop\">
						<div class=\"m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last\">
							<span class=\"m-footer__copyright\">
								Academic Management System  {$r['NMPTIMSPTI']} <br/> Developed by &#169; ICT {$r['NMPTIMSPTI']}\r\n
							</span>
						</div>
						
					</div>
				</div>
			</footer>
			<!-- end::Footer -->";				
}

function printjudulmenu( $judul, $idbantuan = "", $ikon = "" )
{
    echo "\r\n        <div class='titlecontent'>\r\n            \r\n            <h2 class='titlepostcontent'>".strtoupper( $judul )."</h2>\r\n        </div>\r\n        <div class='postcontent'>   \r\n    ";
}

function printjudul( $judul )
{
    global $koneksi;
    global $tabellatar;
    global $namausers;
    global $users;
    global $arraykomponenpembayaran2;
    global $jenisusers;
    global $angkatanusers;
    global $prodiusers;
    global $arrayjeniskomponenpembayaran;
    global $waktu;
    global $arraysemester;
    global $arraybulan;
    global $arrayhari;
    global $root;
    if ( $users != "" )
    {
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND DIBACA IS NULL";
        $h = mysqli_query($koneksi, $q);
        $d = mysqli_fetch_array( $h );
        $jumlahpesan = $d['JML'];
        if ( $jumlahpesan != "" && 0 < $jumlahpesan )
        {
            $pesan = ". Anda mendapatkan <b>{$jumlahpesan} <a href='../pesan/index.php'>pesan baru</a></b>\r\n\t\t";
        }
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND ALERT ='0'";
        $h = mysqli_query($koneksi, $q);
        $d = mysqli_fetch_array( $h );
        $jumlahpesana = $d['JML'];
        if ( $jumlahpesana != "" && 0 < $jumlahpesana )
        {
            $pesan .= "\r\n\t\t<script language='Javascript' type=\"text/javascript\">\r\n\t\t\talert('Anda mendapatkan {$jumlahpesan} pesan baru. Silakan dibaca. Terima kasih');\r\n\t\t</script>\r\n\t\t";
            $q = "UPDATE pesan SET ALERT='1' WHERE KE = '{$users}' AND ALERT ='0'";
            $h = mysqli_query($koneksi, $q);
        }
       # echo "\r\n        <!-- topheader --> \r\n    \t<div id='topheader'>\r\n        \t<ul class='rightlink'>\r\n            \t<li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li>\r\n                <li><a href='#'>";
       # include( $root."tampilan/siteheaderclock.php" );
       # echo "</a></li>\r\n                <li><a class=\"red\" href='index.php?aksi=logout'><b>[ Logout ]</b></a></li>\r\n            </ul>\r\n        </div>\r\n        <!-- end topheader -->\r\n\t    ";
        if ( $pesanbayar != "" )
        {
            echo "\r\n\t\t\t<div id='welcome2'><center>{$pesanbayar} </div>\r\n\t\t";
        }
    }
}

function printjudulmenucetak( $judul )
{
    echo "\r\n\t<h2 class='judulmenucetak'>\r\n\t\t{$judul}\r\n\t</h2>\r\n<div class='postcontent'> \r\n\t";
}

function printjudulmenukecil( $judul )
{
    echo "\r\n\t<p>\r\n\t<table class=judulmenukecil>\r\n\t\t<tr align=left>\r\n\t\t\t<td>\r\n\t\t\t{$judul}\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</p>\r\n   \r\n\t";
}

function cetakpimpinan( )
{
    global $koneksi;
    global $arraybulan;
    global $arraylokasi;
    global $idlokasikantor;
    global $waktu;
    global $namakantor;
    $q = "select NIP,NAMA FROM user WHERE JABATAN=0";
    $h = mysqli_query($koneksi, $q);
    if ( 0 < mysqli_num_rows( $h ) )
    {
        $d = mysqli_fetch_array( $h );
        $nama = $d[NAMA];
        $nip = $d[NIP];
    }
    echo "\r\n<br><br>\r\n\t<table width=100%>\t\r\n\t<tr><td width=40%></td>\r\n\t<td>\r\n\t".$arraylokasi[$idlokasikantor].", {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t{$namakantor} \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\tKepala, \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<BR><BR><BR>\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<u>{$nama}</u><br>\r\n\tNIP. {$nip}\r\n\t</td></tr>\r\n\t</table>\r\n\t";
}

function printjudul2( $judul )
{
    global $tabeljudul;
    if ( $judul != "" )
    {
        echo "\r\n\t<table width=100% {$tabelpengumuman}>\r\n\t\t<tr valign=middle>\r\n\t\t\t<td >\r\n\t\t\t\t<font  style='font-size:10pt;font-family: Arial;'><b>{$judul}</b></font>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
    }
}

function printfooter( )
{
    global $root;
    global $tabelisian3;
    global $versi;
    global $namaprogram;
    include( $root."tampilan/footer.php" );
    mysqli_close($koneksi);
}

function printjudulmenulama( $judul, $idbantuan = "", $ikon = "" )
{
    global $root;
    global $CSS_IKON_FOLDER;
    echo "\r\n\t<div id=\"pageName\">\r\n\t <table  >\r\n\t <tr>\r\n\t <td>\r\n    <h2 class='judulmenu'>".strtoupper( $judul )." </h2>\r\n    ";
    if ( $idbantuan != "" )
    {
        echo "\r\n      </td><td align=right>\r\n        <a href=# onclick=\"showhide('{$idbantuan}');\">\r\n        <img src='".$root."/".$CSS_IKON_FOLDER."tanya.png' height=30 border=0>\r\n        </a>\r\n      ";
    }
    echo "\r\n    </td></tr>\r\n    </table>\r\n\t\t</div>\r\n\t";
}

function printhelp( $string, $id = "bantuan", $display = "" )
{
    if ( $display == "" )
    {
        $disp = "style='display:none;'";
    }
    echo "\r\n  <div id='{$id}' {$disp}>\r\n  <table class=form cellpadding=4 cellspacing=2 width=95% border=1 style='background-color:#DDFFDD;'>\r\n    <tr>\r\n      <td>".nl2br( $string )."</td>\r\n    </tr>\r\n  </table>\r\n  <br>\r\n  </div>\r\n";
}

function printmesgcetak( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "\r\n\t<p class='printerrmesg'>\r\n\t{$errmesg}\r\n\t</p>\r\n\t";
    }
}

function printmenu( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    global $JUDULFAKULTAS;
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    global $jenisusers;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id='menu' >\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<ul  >\r\n  \t\t\t\t\t<li>\r\n    \t\t\t\t\t <h2>{$vv}</h2> \r\n                <ul>\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = FALSE;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = TRUE;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $tmpx .= " <li> <a     href='../{$v['href']}'>{$v['Judul']} </a>";
                unset( $arraysubmenu );
                $filesubmenu = "../".str_replace( "index.php", "", $v[href] )."/submenu.php";
                $dirsubmenu = "../".str_replace( "index.php", "", $v[href] )."";
                if ( file_exists( $filesubmenu ) )
                {
                    include( "../".str_replace( "index.php", "", $v[href] )."/submenu.php" );
                    if ( is_array( $arraysubmenu ) )
                    {
                        $tmpx .= " <ul> ";
                        foreach ( $arraysubmenu as $k => $v )
                        {
                            if ( $v[t] == "T" && $tingkataksesusers[$kodemenu] != "T" )
                            {
                            }
                            else if ( $v[href] != "" )
                            {
                                $tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
                            }
                        }
                        $tmpx .= " </ul> ";
                    }
                }
                $tmpx .= " </li> ";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n      \t\t</ul>\r\n     \t\t</li>\r\n     \t\t</ul>\r\n     \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n </div>\r\n <!--globalnav -->\r\n\t";
    echo $tmp;
}

function printmenulama( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id=\"globalNav\" >\r\n\t\t\t\t\t<table width=100% cellpadding=0 cellspacing=0>\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<tr height=18 {$kelas} valign=middle id=globallink  >\r\n\t\t\t\t\t<td  nowrap class=\"glinktd\">\r\n\t\t\t\t\t<b>{$vv}</b>\r\n\t\t\t\t\t</td><td nowrap >\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = FALSE;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = TRUE;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $br = "&nbsp;";
                $tkiri = "<font style='font-size:8px'> {$br} [</font>";
                $tkanan = "<font style='font-size:8px'>]</font>";
                $reg = str_replace( "?", "\\?", $v[href] );
                if ( ereg_sikad( "({$reg})", $REQUEST_URI ) )
                {
                    $ta = "style='color:#ee2222'";
                    $b = "<b>";
                    $tb = "</b>";
                }
                $tmpx .= "<a class=glink {$ta} href='../{$v['href']}'>\r\n\t\t\t\t\t\t\t{$v['Judul']} </a>";
                $t = "";
                $ta = "";
                $td = "";
                $b = "";
                $tb = "";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n\t\t</td>\r\n \t\t</tr>\r\n \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n</table> \r\n</div><!--globalnav -->\r\n\t";
    echo $tmp;
}

function printhtml( )
{
    global $style;
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body>\r\n \t";
}

function printhtmlcetak()
{
    global $root;
    include( $root."css/printstyle.inc" );
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body class=cetak>\r\n \t";
}

function kelas( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenap";
    }
    else
    {
        $kelas = " class=dataganjil";
    }
    return $kelas;
}

function kelasmenu( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapmenu";
    }
    else
    {
        $kelas = " class=dataganjilmenu";
    }
    return $kelas;
}

function kelassm( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapsm";
    }
    else
    {
        $kelas = " class=dataganjilsm";
    }
    return $kelas;
}

function createform( $nama, $metod, $action, $attr )
{
    $tmp = "\r\n\t\t<form method='{$metod}' name='{$nama}' action='{$action}' {$attr}>\r\n\t\t\t<--isi-->\r\n\t\t</form>\r\n\t";
    return $tmp;
}

function createinputhidden( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=hidden name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputtext( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=text name=\"{$nama}\" value=\"{$value}\" {$attr} >\r\n\t";
    return $tmp;
}

function createinputtextarea( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<textarea name='{$nama}'  {$attr}>{$value}</textarea>\r\n\t";
    return $tmp;
}

function createinputpassword( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=password name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputcek( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=checkbox name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputcekarray( $nama, $tabelvalue, $tabelkey, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( @in_array( @$k, @$tabelkey ) )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name={$nama}"."[{$k}] type=checkbox value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

function createinputradio( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=radio name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputradioarray( $nama, $tabelvalue, $key, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( $k == $key )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name='{$nama}' type=radio value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

/*function createinputselect( $nama, $tabelvalue, $key, $multiple, $attr )
{
	#echo $nama."ll".$tabelvalue."zzz".$key."".$multiple."".$attr."VV".$multiple;
	#echo "LALA".trim($multiple);
	#print_r($tabelvalue);
    $tmp = "<select name='$nama' $attr $multiple>";
    foreach ( $tabelvalue as $k => $v )
    {
		#echo $key."MM".$k."LL".$key;
       /* if ( $key == $k && trim( $multiple ) != "multiple" )
        {
            $cek = "selected";
        }
        #elseif (in_array( $k, $key ) && trim( $multiple ) == "multiple" )
		elseif (trim( $multiple ) == "multiple" )
        {
            $cek = "selected";
        
		}else{
			
			$cek = "";
        
		}*/
		/*if ($key==$k && trim($multiple)!="multiple") {
				$cek="selected";
			} elseif ((@in_array($k,$key) && trim($multiple)=="multiple")) {
				$cek="selected";
			}

        $tmp .= "\r\n\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t";
        $cek = "";
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}*/

function createinputselect($nama,$tabelvalue,$key,$multiple,$attr) {
	$tmp ="
		<select name='$nama' $attr $multiple>";
		foreach ($tabelvalue as $k=>$v) {
			if ($key==$k && trim($multiple)!="multiple") {
				$cek="selected";
			} elseif ((@in_array($k,$key) && trim($multiple)=="multiple")) {
				$cek="selected";
			}
			$tmp.= "
			<option value='$k' $cek>$v</option>
			";
			$cek="";
		}
	$tmp.="
		</select>
	";
	return $tmp;
}


function createinputtanggalblank( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n\t\t<option value='' >tgl</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n\t\t<option value='' >bln</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n\t\t<option value='' >thn</option>\r\n\t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputbulantahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
	while ( $i <= $waktu[year] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    /*do
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    } while ( 1 );*/
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtanggalbulan( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mday] == $i && @$value[tgl] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select> \r\n\t";
    return $tmp;
}

function createinputtanggal( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mday] == $i && @$value[tgl] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahunajaran( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputjam( $nama, $value, $isdetik, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[jam]' {$attr}>";
    $i = 0;
    while ( $i <= 23 )
    {
        if ( $value[jam] == $i && $value[jam] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[hours] == $i && $value[jam] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[mnt]' {$attr}>";
    $i = 0;
    while ( $i <= 59 )
    {
        if ( $value[mnt] == $i && $value[mnt] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[minutes] == $i && $value[mnt] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    if ( $isdetik != "" )
    {
        $tmp .= "\r\n\t\t\t<select name='".$nama."[dtk]' {$attr}>\r\n\t\t\t";
        $i = 0;
        while ( $i <= 59 )
        {
            if ( $value[dtk] == $i && $value[dtk] != "" )
            {
                $cek = "selected";
            }
            else if ( $waktu[seconds] == $i && $value[dtk] == "" )
            {
                $cek = "selected";
            }
            $tmp .= "\r\n\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t";
            $cek = "";
            ++$i;
        }
        $tmp .= "\r\n\t\t\t</select>\r\n\t\t";
    }
    else
    {
        $tmp .= "00\r\n\t\t\t<input type=hidden name='".$nama."[dtk]' value=0>\r\n\t\t";
    }
    return $tmp;
}

function printdemo( )
{
    echo "\r\n\t<table class=form>\r\n\t\t<tr align=center>\r\n\t\t\t<td>\r\n\t\t\t\tTerima Kasih telah menggunakan SITU versi Demo.  <br>\r\n\t\t\t\tUntuk fitur yang lebih lengkap, silakan membeli versi asli dari SITU.\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
}

periksaroot( );
?>
