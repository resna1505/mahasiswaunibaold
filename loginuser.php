<?php
periksaroot();
$hasil = generaterandomcaptcha(4);
$_SESSION['tokenlogin'] = $hasil['token'];
$_SESSION['antispamlogin'] = $hasil['rand'];
#print_r($_SESSION);
#$_SESSION['tokenlogin'] = '123AA';
#$_SESSION['antispamlogin'] = '123AA';


?>
<!-- BEGIN SAMPLE FORM PORTLET-->
<?php 
echo "	<script language=JAVASCRIPT>
			function teslogin (form) {
				if (form.iduser.value=='') {
					alert('ID harus diisi');
					form.iduser.focus();
				}
				else if (form.password.value=='') {
					alert('Password harus diisi');form.password.focus();
				} 
				else {
					return true;
				}
					return false;
				}
		</script>";
echo "	<!--  form login -->
		<form class=\"m-form\" role=\"form\" name=log action=index.php method=post>";
?>
    <!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
					<div class="m-stack m-stack--hor m-stack--desktop">
						<div class="m-stack__item m-stack__item--fluid">
							<div class="m-login__wrapper" style="padding:0;">
								<div class="m-login__logo">
									<a href="#">
										<img src="gambar/logo-uniba.png" width="100px" height="100px">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head">
										<h3 class="m-login__title">
											Form login
										</h3>
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" placeholder="ID User" name="iduser" autocomplete="off">
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
									</div>
									<div class="form-group">
										<div class="col-md-9">
											<img src="antispam.php?idspam=1" width='220' height='80'/>							                                          
										</div>
									</div>
									<div class="form-group">
										<input name="randlogin" type="text" class="form-control m-input" placeholder="Masukan Kode Diatas">								
									</div>	
									<div class="m-login__form-action">
										<input type="submit" class="btn m-btn--pill m-btn--air btn-info btn-block" value="Login" style="font-size:1.2rem;" name="aksi" onClick="return teslogin(log);">
									</div>									
								</div>								
							</div>
						</div>						
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(assets/admin/layout/img/bg-5.jpg)">
					<div class="m-grid__item m-grid__item--middle">
						<h3 class="m-login__welcome">
							Selamat Datang Para Pengguna
						</h3>
						<p class="m-login__msg">
							Untuk menggunakan aplikasi
							<br>
							Silahkan login pada form login yang tersedia	
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->

<?php

if ( $errlogin != "" )
{
    echo "<SCRIPT>";
    if ( $errlogin == "id" )
    {
        echo "log.iduser.focus();";
    }
    else
    {
        echo "log.password.focus();";
    }
    echo "</SCRIPT>";
}
?>
