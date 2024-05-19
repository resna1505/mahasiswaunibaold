<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

session_start( );
include( "header.php" );
periksaroot();
if ( $_POST['sessid'] == $_SESSION['token'] && trim( $aksi ) == "Reset Password" && $REQUEST_METHOD == POST )
{
    if ( $_SESSION['tokenlogin'] != md5( $randlogin ) )
    {
        $errmesg = "<p class='error-forget'>Kode anti-spam yang Anda masukkan salah.</p>";
    }
    else if ( trim( $iduser ) == "" )
    {
        $errmesg = "<p class='error-forget'>Maaf, user ID wajib diisi.</p>";
    }
    else if ( $jenis == "email" && !validasi_email( $email, false ) )
    {
        $errmesg = "<p class='error-forget'>Maaf, alamat e-mail wajib diisi dengan benar.</p>";
    }
    else
    {
        if ( $jenis == "sms" && !validasi_angka( $hp, false ) )
        {
            $errmesg = "<p class='error-forget'>Maaf, No HP wajib diisi dengan benar.</p>";
        }
        else
        {
            if ( $jenis == "email" )
            {
                $qfield = " AND EMAIL='{$email}'  ";
            }
            else if ( $jenis == "sms" )
            {
                $qfield = " AND HP='{$hp}'  ";
            }
            $q = "SELECT * FROM calonmahasiswa WHERE ID='{$iduser}' {$qfield} AND  STATUS=1 LIMIT 0,1";
            $h = mysqli_query($koneksi, $q);
            if ( mysqli_num_rows( $h ) <= 0 )
            {
                if ( $jenis == "email" )
                {
                    $errmesg = "<p class='error-forget'>Maaf, User ID dan alamat e-mail Anda tidak cocok, atau akun Anda sudah tidak aktif. Terima kasih.</p>";
                }
                else
                {
                    if ( $jenis == "sms" )
                    {
                        $errmesg = "<p class='error-forget'>Maaf, User ID dan No HP Anda tidak cocok, atau akun Anda sudah tidak aktif. Terima kasih.</p>";
                    }
                }
            }
            else
            {
                $d = mysqli_fetch_array( $h );
                $passwordacak = substr( md5( uniqid( rand( ), TRUE ) ), 0, 8 );
                $dr = get_resetpassword( "PMB" );
                $dmail[subject] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", $dr[SUBJEK] );
                $dmail[subject] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[subject] );
                $dmail[subject] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[subject] );
                $dmail[body] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", $dr[ISI] );
                $dmail[body] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[body] );
                $dmail[body] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[body] );
                if ( $jenis == "email" )
                {
                    $query = "UPDATE calonmahasiswa SET PASSWORD=MD5('{$passwordacak}')   ,COUNTERPASSWORD=COUNTERPASSWORD+1,\r\n          \r\n          \r\n                TANGGALUPDATE=NOW(),\r\n                UPDATER\t='{$iduser}'\r\n              \t\tWHERE ID='{$iduser}' AND EMAIL='{$email}'   ";
                    mysqli_query($koneksi, $query);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $dmail[to] = $d[EMAIL];
                        $hasil = kirimemail_calonmahasiswa( $dmail );
                        $ketlog = "Calon Mahasiswa Ganti Password via Email. ID={$users_pmb}";
                        $users = $users_pmb;
                        buatlog( 70 );
                        if ( $hasil == 1 )
                        {
                            $errmesg = "<p class='error-forget'>Password Anda telah diganti dengan yang baru  dan dikirim ke email Anda. Terima kasih.</p>";
                        }
                        else
                        {
                            $errmesg = "<p class='error-forget'>Password Anda telah diganti dengan yang baru  tetapi gagal dikirim ke email Anda. Terima kasih. <br> {$hasil}</p>";
                        }
                    }
                    else
                    {
                        $errmesg = "<p class='error-forget'>Maaf. Password Anda tidak berhasil diganti dengan yang baru. Terima kasih</p>";
                    }
                }
                
            }
        }
    }
}
if ( trim( $aksi ) == "Login" && $REQUEST_METHOD == POST )
{
    $ketlog = "Login ID={$iduser}, Jenis={$jenisuser}";
    buatlog( 0 );
    if ( !( anti_sql_injection( $iduser ) && anti_sql_injection( $password ) ) )
    {
        $errmesg = "Jangan macam-macam please...";
    }
    else if ( trim( $iduser == "" ) )
    {
        $errmesg = "<p class='error'>ID User harus diisi</p>";
        $errlogin = "id";
    }
    else if ( trim( $password == "" ) )
    {
        $errmesg = "<p class='error'>Password harus diisi</p>";
        $errlogin = "password";
    }
    else
    {
        $ok = 1;
        $d = status_login( $iduser, $jenisuser, "pmb" );
        $iddle_time = getaturan( "BATASDIAM" ) * 60;
        if ( $iddle_time < $d[LAMADIAM] )
        {
            set_status_login( $iduser, $jenisuser, 0, "", "pmb" );
        }
        if ( 0 < $iddle_time && is_sedang_login( $iduser, $jenisuser ) )
        {
            $ok = 0;
            $errmesg = "<p class='error'>Maaf, ID Anda sedang login di tempat lain. Sementara ini Anda tidak dapat login sebelum ID Anda di tempat lain tersebut logout. Apabila Anda merasa hal ini adalah kesalahan, silakan hubungi administrator Anda.</p>";
        }
        $tokenlogin = md5( uniqid( rand( ), TRUE ) );
        if ( $jenisuser == 0 )
        {
            #$query = "SELECT * FROM calonmahasiswa WHERE ID='{$iduser}' AND PASSWORD=MD5('{$password}') AND  STATUS=1 ";
	    $query = "SELECT * FROM calonmahasiswa WHERE ID='{$iduser}' AND PASSWORD=MD5('{$password}') AND  LULUS!=-1 ";	
            $hasil = mysqli_query($koneksi, $query);
            if ( 0 < mysqli_num_rows( $hasil ) )
            {
                $data = mysqli_fetch_array( $hasil );
                session_start( );
                session_register_sikad( "users_pmb" );
                session_register_sikad( "namausers_pmb" );
                session_register_sikad( "tingkats_pmb" );
                session_register_sikad( "css_pmb" );
                session_register_sikad( "URLS_pmb" );
                session_register_sikad( "tokenusers_pmb" );
                $css_pmb = $data[CSS];
                $users_pmb = $iduser;
                $namausers_pmb = $data[NAMA];
                $tingkats_pmb = "PMB:T";
                $tokenusers_pmb = $tokenlogin;
                $URLS_pmb = str_replace( "{$PHP_SELF}", "", $SCRIPT_FILENAME );
                $_SESSION['users_pmb'] = $users_pmb;
                $_SESSION['namausers_pmb'] = $namausers_pmb;
                $_SESSION['tingkats_pmb'] = $tingkats_pmb;
                $_SESSION['css_pmb'] = $css_pmb;
                $_SESSION['URLS_pmb'] = $URLS_pmb;
                $_SESSION['tokenusers_pmb'] = $tokenlogin;
				
                if ( $data[SETTINGTAMPILAN] == "" )
                {
                    $data[SETTINGTAMPILAN] = "MENUUTAMA=0;SUBMENU=1";
                }
                $tmp = explode( ";", trim( $data[SETTINGTAMPILAN] ) );
                if ( is_array( $tmp ) )
                {
                    foreach ( $tmp as $k => $v )
                    {
                        $tmp2 = explode( "=", $v );
                        $_SESSION[TAMPILAN][trim( $tmp2[0] )] = trim( $tmp2[1] );
                    }
                }
                mysqli_close($koneksi);
                Header( "Location:calonmahasiswa/index.php" );
                $ketlog = "Login PMB Calon Mahasiswa sukses. ID={$users_pmb}";
                $users = $users_pmb;
                buatlog( 66 );
                set_status_login( $iduser, $jenisuser, 1, $tokenlogin, "pmb" );
                exit( );
            }
            else
            {
                $errmesg = "<p class='error'>Maaf, ID dan Password Anda tidak sesuai. \r\n  \t\t\t\tSilakan mengisi kembali ID dan Password Anda.</p>";
                $errlogin = "id";
            }
        }
    }
}
$waktu = getdate( time( ) );
printheader();
#include( "welcomemenu.php" );
?>
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<div align="center"><br><img src="gambar/logo-uniba.png" width="100px" height="100px" align="center"></div>
			<!-- END LOGO -->
		</div>
	</div>
	<br>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu" style="margin-top:50px;">
	<?php
	//printmesg( $errmesg );
echo "<br><div style=\"margin-left:10px;width:44%;height:100%;\"><marquee width='1330px' behavior='alternate' ><font color=#ffffff>Untuk menggunakan aplikasi login pmb. Silahkan login terlebih dahulu</font></marquee><br>" ; 
echo "</div>";
?>
		<div class="container-fluid">
			<!-- BEGIN HEADER SEARCH BOX -->
			
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					
						</ul>
					</li>
					
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
<?php
printmesg( $errmesg );
if ( $pilihan == "" )
{
	echo "	<div class=\"col-md-6\" style=\"display:flex;align-items:center;justify-content:center;max-width:none;\">";
	echo "<script language=JAVASCRIPT>\r\n\tfunction teslogin (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.password.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.password.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script>";
	echo "<!--  form login -->\r\n
			<form class=\"form-horizontal\" id=\"lg-form\" name=log action=\"{$PHP_SELF}\" method=post>";
	
?>
					<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">Login Form</div>
							</div>
							<div class="portlet-body form">
								<form class="form-horizontal" role="form">
									<div class="form-body">
									   
										<div class="form-group">
											<label class="col-md-3 control-label">User ID</label>
											<div class="col-md-9">
												<div class="input-inline input-medium">
													<div class="input-group">
														<span class="input-group-addon">
														<i class="fa fa-user"></i>
														</span>
														<input name="iduser" type="text" class="form-control" placeholder="ID User">
													</div>
												</div>
											</div>
										</div>
										 <div class="form-group">
											<label class="col-md-3 control-label">Password</label>
											<div class="col-md-9">
												<div class="input-inline input-medium">
													<div class="input-group">
														<span class="input-group-addon">
														<i class="fa fa-lock"></i>
														</span>
														<input name="password" type="password" class="form-control" placeholder="Password">
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<div class="form-actions left">
								<?php
								echo "<input name=aksi class=\"btn blue\" type=\"submit\" value=\"Login\" onClick=\"return teslogin(log);\"/>
									  <input class=\"btn default\" type=\"reset\" value=\"Reset\"/>";
								?>
										
									</div>
								
							</div>
						</div>
					</div>
<?php
				echo "<!-- end maincontent --></div><!-- end content --></div><!--end wrap--></div>";
				#printfooter( );
				echo "</body></html>";
	/*echo "<!doctype html>\r\n<html lang=\"en\">\r\n<head>\r\n  <meta charset=\"utf-8\">\r\n  <title>AMS Login PMB</title>\r\n  <link rel=\"stylesheet\" href=\"tampilan/login_bank_pmb/lib/login.css\">\r\n  <link rel=\"shortcut icon\" href=\"images/favicon.png\">\r\n  ";
	echo "<s";
	echo "cript src=\"tampilan/login_bank_pmb/lib/jquery-1.7.1.min.js\"></script>\r\n  <!--";
	echo "<s";
	echo "cript src=\"js/jquery.spinner.js\"></script>-->\r\n  <!--[if lt IE 9]>\r\n  <![endif]-->\r\n    <!---FadeIn Effect, Validation and Spinner-->\r\n  ";
	echo "<s";
	echo "cript>\r\n    $(document).ready(function () {\r\n       $('div.wrapper').hide();\r\n        $('div.wrapper').fadeIn(1200);\r\n        $('#lg-form').validate();\r\n        $('.submit').click(function() {\r\n        var \$this = $(this);\r\n        \$this.spinner();\r\n        setTimeout(function() {\r\n                \$this.spinner('remove');\r\n        }, 1000);\r\n       });\r\n    });\r\n  </script>\r\n  \r\n  \r\n  <!-- js notifi";
	echo "kasi -->\r\n  ";
	echo "<s";
	echo "cript language=JAVASCRIPT>\r\n\tfunction teslogin (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.password.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.password.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script>\r\n\r\n</head>\r\n<body>\r\n\t<div class=\"wrapper\">\r\n      \t";
	printmesg($errmesg);
	echo "\t <div class=\"lg-body\"><div><img width=\"60\" height=\"54\" src=\"gambar/unimal..png\"></div>";
	echo "<div align=\"center\" style=\"margin-top:-40px;font-size:17px;\">Selamat Datang di Academic Management System</div>";
	echo "<div style=\"margin-top:-33px;float:right;\"><img width=\"60\" height=\"54\" src=\"gambar/unimal..png\"></div><br/><br/><br/><div style=\"margin-left:0px;\"><form id=\"lg-form\" method=\"post\" class=\"stylized\" name=\"log\" action='";
	echo $PHP_SELF;
	echo "'><table width='100%' border='0'><tr><td colspan=\"2\" style=\"background-color:#23a24d;font-size:25px;color:#FFF;padding:10px 30px;\"><h3>Login Form</h3></td></tr><tr><td colspan=\"2\"> <p class=\"notify\">Untuk menggunakan aplikasi login pmb. Silahkan login terlebih dahulu</p>\r\n</td></tr><tr><td><label>User ID</label>\r\n</td><td><input class=\"textfieldlogin\" name=\"iduser\" type=\"text\" size=\"26\" minlength =\"1\" placeholder=\"Username...\" /></td></tr><tr><td><label>Password</label>\r\n</td><td><input class=\"textfieldlogin\" name=\"password\" type=\"password\" size=\"26\" minlength=\"1\" placeholder=\"Password...\" /";
	echo "></td></tr><tr><td>&nbsp;</td></tr><tr><td colspan='2' style=\"background-color:#23a24d;font-size:25px;color:#FFF;padding:10px 30px;\" ><input class=\"submit\" type=\"submit\" value=\"Login\" name=\"aksi\" onClick=\"return teslogin(log);\"/><input class=\"submit\" type=\"reset\" value=\"Reset\"/></td></tr></form></div></div></body>\r\n</html>\r\n    \r\n";
	*/
    /*echo "\r\n<!doctype html>\r\n<html lang=\"en\">\r\n<head>\r\n  <meta charset=\"utf-8\">\r\n  <title>SIMAK Login PMB</title>\r\n  <link rel=\"stylesheet\" href=\"tampilan/login_bank_pmb/lib/login.css\">\r\n  <link rel=\"shortcut icon\" href=\"images/favicon.png\">\r\n  ";
    echo "<s";
    echo "cript src=\"tampilan/login_bank_pmb/lib/jquery-1.7.1.min.js\"></script>\r\n  <!--";
    echo "<s";
    echo "cript src=\"js/jquery.spinner.js\"></script>-->\r\n  <!--[if lt IE 9]>\r\n  <![endif]-->\r\n    <!---FadeIn Effect, Validation and Spinner-->\r\n  ";
    echo "<s";
    echo "cript>\r\n    $(document).ready(function () {\r\n       $('div.wrapper').hide();\r\n        $('div.wrapper').fadeIn(1200);\r\n        $('#lg-form').validate();\r\n        $('.submit').click(function() {\r\n        var \$this = $(this);\r\n        \$this.spinner();\r\n        setTimeout(function() {\r\n                \$this.spinner('remove');\r\n        }, 1000);\r\n       });\r\n    });\r\n  </script>\r\n\r\n</head>\r\n<body>\r\n\t<div c";
    echo "lass=\"wrapper\">\r\n    \t";
    printmesg( $errmesg );
    echo "\t <div class=\"logo\">\r\n\t \t<h1></h1>\r\n\t </div>\r\n   <div class=\"lg-body\">\r\n     <div class=\"inner\">\r\n       <div id=\"lg-head\">\r\n         <p>Login Form</p>\r\n         <div class=\"separator\"></div>\r\n       </div>\r\n       <div class=\"login\">\r\n         <form id=\"lg-form\" method=\"post\" name=log action='";
    echo $PHP_SELF;
    echo "'>\r\n           <fieldset>\r\n              <ul>\r\n                 <li id=\"usr-field\">\r\n                  <input class=\"input required\" name=\"iduser\" type=\"text\" size=\"26\" minlength =\"1\" placeholder=\"Username...\" />\r\n                 </li>\r\n                 <li id=\"psw-field\">\r\n                  <input class=\"input required\" name=\"password\" type=\"password\" size=\"26\" minlength=\"1\" placeholder=\"Password...\" /";
    echo ">\r\n                 </li>\r\n                 <li>\r\n                  <input name=\"aksi\" class=\"submit\" type=\"submit\" value=\"Login\" onClick=\"return teslogin(log);\"/>\r\n                  <input class=\"submit\" type=\"reset\" value=\"Reset\"/>\r\n                 </li>\r\n              </ul>\r\n           </fieldset>\r\n          </form>\r\n          \r\n          ";
    echo "<s";
    echo "pan id=\"lost-psw\">\r\n            ";
    echo "<a href='{$PHP_SELF}?pilihan=lupa'>Lupa password? </a>";
    echo "          </span>\r\n          \r\n        </div>\r\n     </div>\r\n    </div>\r\n    <!--\r\n    <div id=\"login-msg\">\r\n      <p class=\"font-bold\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <p>\r\n    </div>\r\n    -->\r\n\t</div>\r\n</body>\r";
    echo "\n</html>\r\n\r\n";*/
}
else
{
    if ( $pilihan == "lupa" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        $hasil = generaterandomcaptcha( 4 );
        $_SESSION['tokenlogin'] = $hasil[token];
        $_SESSION['antispamlogin'] = $hasil[rand];
        echo " \r\n<html lang=\"en\">\r\n<head>\r\n\t<title>Lupa Password</title>\r\n\t<link rel=\"stylesheet\" href=\"tampilan/login_bank_pmb/lib/login.css\">\r\n\t<link rel=\"shortcut icon\" href=\"images/favicon.png\">\r\n\t\r\n\t<script>\r\n    $(document).ready(function () {\r\n       $('div.wrapper').hide();\r\n        $('div.wrapper').fadeIn(1200);\r\n        $('#lg-form').validate();\r\n        $('.submit').click(function() {\r\n        var {$this} = $(this);\r\n        {$this}.spinner();\r\n        setTimeout(function() {\r\n                {$this}.spinner('remove');\r\n        }, 1000);\r\n       });\r\n    });\r\n  </script>\r\n  \r\n</head>\r\n<body>\r\n\t<div class='wrapper-forget'>\r\n   <div class='lg-body-forgetpass'>\r\n     <div class='inner'>\r\n       <div id='lg-head'>   \r\n         <p>Lupa Password Login PMB.</p>\r\n         <div class='separator'></div>\r\n       </div>\r\n       <div class='login'>";
        printmesg( $errmesg );
        echo "<form class=\"stylized\" name=log action='{$PHP_SELF}' method=post>  ".createinputhidden( "sessid", $_SESSION['token'], "" )."  \r\n <input type=hidden name='pilihan' value='{$pilihan}'>      \t\r\n            <div class=\"box\">\r\n\t\t\t\t\r\n                <label class=\"labelforum\">\r\n                   <span class=\"inputname\">User ID</span>\r\n                   <input class=\"input_text\" name=\"iduser\" type=\"text\">\r\n                </label>\r\n                \r\n                <div class=\"labelforum\">\r\n                   <span class=\"inputname\"><input type=radio name=jenis value=email checked>&nbsp;Email</span>\r\n                   <input class=\"input_text\" name=\"email\" id=\"email\" type=\"text\">\r\n\t\t\t\t   <p style=\"color:#000\">Contoh : calonmahasiswa@mail.com</p>\r\n                </div>\r\n                \r\n                <div class=\"labelforum\">\r\n                   <span class=\"inputname\"><input type=radio name=jenis value=sms>&nbsp;No HP</span>\r\n                   <input class=\"input_text\" name=\"hp\" id=\"email\" type=\"text\">\r\n\t\t\t\t   <p style=\"color:#000\">Contoh : 0812249xxxx </p>\r\n                </div>\r\n                \r\n                <label>\r\n                \t<span class=\"inputname\">Anti Spam</span>\r\n                    <img class=\"codenumber\" src=\"antispam.php?idspam=1\" width='230' height='50'/>\r\n\t\t\t\t\t<ul class='info2'>\r\n                        <li>Jika kode tidak jelas Refresh untuk memperoleh kode baru</li>\r\n                        <li>Karakter yg tampil adalah 0-9 dan a-z tanpa huruf kapita</li>\r\n\t\t\t\t\t</ul>\r\n                </label>\r\n                \r\n                <label class=\"labelforum\">\r\n                    <span class=\"inputname\">Masukan Kode</span>\r\n                    <input class=\"input_text\" name=\"randlogin\" type=\"text\">   \r\n                </label>\r\n               \r\n                <input name=aksi class=\"resetpass\" type=\"submit\" value=\"Reset Password\" onClick=\"return confirm('Lakukan reset password? Pastikan user id dan alamat email/No HP Anda valid sesuai pendaftaran! Password yang baru akan dikirim ke alamat e-mail/No HP Anda.');\"/>        \t\t\t\r\n\t\t\t\t\r\n            </div>            \r\n        </form>\r\n\t\t\r\n </div>\r\n     </div>\r\n    </div>\r\n\t\t<a href='{$PHP_SELF}'>Kembali ke Halaman Login</a>\r\n\t</div>\r\n    \r\n</body>\r\n</html>\t\r\n\t\r\n";
    }
}
?>
