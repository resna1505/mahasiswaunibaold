
 
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="utf-8"> <title>Academic Management System (AMS) </title>	
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1.0" name="viewport" shrink-to-fit=no><meta content="" name="description"><meta content="" name="author"><!--begin::Web font -->
		<script src="../tampilan/default/assets/vendors/base/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font --><!--begin::Base Styles -->  
        <!--begin::Page Vendors -->
			<link href="../tampilan/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->
			<link href="../tampilan/default/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
			<link href="../tampilan/default/assets/demo/demo9/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
			<link rel="shortcut icon" href="../tampilan/default/assets/demo/demo9/media/img/logo/favicon.ico" /><?
// JavaScript Document
//periksaroot
?>
<script language='Javascript' type="text/javascript">
<!--

function addCommas(nStr)

{

  nStr += '';

  x = nStr.split('.');

  x1 = x[0];

  x2 = x.length > 1 ? '.' + x[1] : '';

  var rgx = /(\d+)(\d{3})/;

  while (rgx.test(x1)) {

    x1 = x1.replace(rgx, '$1' + '.' + '$2');

  }

  return x1 + x2;

}



function daftarakun(pfld,pfltr) {
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listakun.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarkelompokakun(pfld,pfltr) {
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listklpakun.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function showUserList(pfld,pfltr) {
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listp.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=a', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftaruserpilih(pfld,pfltr) {
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listppilih.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=a', 'List', 'width=500,height=600,scrollbars=yes');
 
}

function daftarmakul(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listmakul.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarmakul2(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('lib/listmakul.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function daftardosen(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listdosen.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftardosentextarea(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listdosent.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function daftardosenpayroll(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listdosenpayroll.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function daftarmhs(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listmhs.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarcalonmhs(pfld,pfltr,tahun,gelombang,pilihan) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listcalonmhs.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A&tahun='+tahun+'&gelombang='+gelombang+'&pilihan='+pilihan, 'List', 'width=500,height=600,scrollbars=yes');
}

function daftaralumni(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listalumni.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarpt(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listpt.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarprodi(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listprodi.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftarprop(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listprop.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}
function daftardos(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listdos.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function daftarprodipt(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listprodipt.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function daftargrafik(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listgrafik.php?diagram=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

     function showhide(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
 
function daftarnegara(pfld,pfltr) {
				 
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/listnegara.php?satu=1&pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');
}

function lookup(inputString,angkatan,prodi) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestions').hide();
    } else {
        $.post("../lib/carimahasiswa.php", {queryString: ""+inputString+""  , angkatan: ""+angkatan+""  , prodi: ""+prodi+""  }, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            } else {
              $('#suggestions').hide();
            }
        });
    }
} // lookup
function fill(thisValue) {
    $('#inputString').val(thisValue);
   $('#suggestions').hide();
}

function lookupCalonMhs(inputString,tahun,gelombang,idpilihan) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsCalonMhs').hide();
    } else {
        $.post("../lib/caricalonmahasiswa.php", {queryString: ""+inputString+""  , tahun: ""+tahun+""  , gelombang: ""+gelombang+"" , idpilihan: ""+idpilihan+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsCalonMhs').show();
                $('#autoSuggestionsListCalonMhs').html(data);
            } else {
              $('#suggestionsCalonMhs').hide();
            }
        });
    }
} // lookup
function fillCalonMhs(thisValue) {
    $('#inputStringCalonMhs').val(thisValue);
   $('#suggestionsCalonMhs').hide();
}



function lookupDosen(inputString,prodi) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsDosen').hide();
    } else {
        $.post("../lib/caridosen.php", {queryString: ""+inputString+""  ,  prodi: ""+prodi+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsDosen').show();
                $('#autoSuggestionsListDosen').html(data);
            } else {
              $('#suggestionsDosen').hide();
            }
        });
    }
} // lookup
function fillDosen(thisValue) {
    $('#inputStringDosen').val(thisValue);
   $('#suggestionsDosen').hide();
}

function lookupKurikulum(inputString,prodi,tahun,semester) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsKurikulum').hide();
    } else {
        $.post("../lib/carikurikulum.php", {queryString: ""+inputString+""  ,  prodi: ""+prodi+""  ,  tahun: ""+tahun+""  ,  semester: ""+semester+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsKurikulum').show();
                $('#autoSuggestionsListKurikulum').html(data);
            } else {
              $('#suggestionsKurikulum').hide();
            }
        });
    }
} // lookup
function fillKurikulum(thisValue) {
    $('#inputStringKurikulum').val(thisValue);
   $('#suggestionsKurikulum').hide();
}


function lookupMakul(inputString,prodi) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsMakul').hide();
    } else {
        $.post("../lib/carimakul.php", {queryString: ""+inputString+"" ,  prodi: ""+prodi+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsMakul').show();
                $('#autoSuggestionsListMakul').html(data);
            } else {
              $('#suggestionsMakul').hide();
            }
        });
    }
} // lookup
function fillMakul(thisValue) {
    $('#inputStringMakul').val(thisValue);
   $('#suggestionsMakul').hide();
}


// -->
</script>
<!-- begin::Quick Nav -->	
    	<!--begin::Base Scripts -->
		<script src='../tampilan/default/assets/vendors/base/vendors.bundle.js' type='text/javascript'></script>
		<script src='../tampilan/default/assets/demo/demo9/base/scripts.bundle.js' type='text/javascript'></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
		<script src='../tampilan/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js' type='text/javascript'></script>
		<!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
		<script src='../tampilan/default/assets/app/js/dashboard.js' type='text/javascript'></script>
		<!--end::Page Snippets -->   
        <!-- begin::Page Loader -->
		<script>
            $(window).on('load', function() {
                $('body').removeClass('m-page--loading');         
            });
		</script>    </head><body class="m--skin- m-page--loading-enabled m-page--loading m-content--skin-light m-header--fixed m-header--fixed-mobile m-aside-left--offcanvas-default m-aside-left--enabled m-aside-left--fixed m-aside-left--skin-dark m-aside--offcanvas-default"> <!--</head>-->
<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header "  m-minimize="minimize" m-minimize-mobile="minimize" m-minimize-offset="200" m-minimize-mobile-offset="200" >
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop  m-header__wrapper">
						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand m-brand--mobile">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="index.html" class="m-brand__logo-wrapper">
										<img alt="" src="default/assets/demo/demo9/media/img/logo/logo.png"/>
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">
									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_toggle_mobile" class="m-brand__icon m-brand__toggler m-brand__toggler--left">
										<span></span>
									</a>
									<!-- END -->
							<!-- BEGIN: Responsive Header Menu Toggler -->
									<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler">
										<span></span>
									</a>
									<!-- END -->
			<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>
						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--middle m-stack__item--left m-header-head" id="m_header_nav">
							<div class="m-stack m-stack--ver m-stack--desktop">
								<div class="m-stack__item m-stack__item--middle m-stack__item--fit">
									<!-- BEGIN: Aside Left Toggle -->
									<!--<a href="javascript:;" id="m_aside_left_toggle" class="m-aside-left-toggler m-aside-left-toggler--left m_aside_left_toggler">
										<span></span>
									</a>-->
									<!--<a href="index.html" class="m-brand__logo-wrapper">
										<img alt="" src="assets/demo/demo9/media/img/logo/logo.png"/>
									</a>-->
									<!-- END: Aside Left Toggle -->
								</div>	
	<!-- BEGIN HEADER TOP -->
	








<div class="m-stack__item m-stack__item--middle m-stack__item--left m-header-head" id="m_header_nav">
				<div class="m-stack m-stack--ver m-stack--desktop">
					<div class="m-stack__item m-stack__item--middle m-stack__item--fit">
					</div>
					<div class="m-stack__item m-stack__item--fluid">
						<!-- BEGIN: Horizontal Menu -->
						<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark" id="m_aside_header_menu_mobile_close_btn">
							<i class="la la-close"></i>
						</button>
						<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark">
							<ul class="m-menu__nav  m-menu__nav--submenu-arrow">	
								<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
									<a  href="javascript:;" class="m-menu__link m-menu__toggle">
										<span class="m-menu__item-here"></span>
											<i class="m-menu__link-icon flaticon-analytics"></i>
												<span class="m-menu__link-text">Akademik</span>
														<i class="m-menu__hor-arrow la la-angle-down"></i>
														<i class="m-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
										<span class="m-menu__arrow m-menu__arrow--adjust"></span>
											<ul class="m-menu__subnav">
                 
											<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
												<a  href="javascript:;" class="m-menu__link m-menu__toggle">
													<i class="m-menu__link-icon flaticon-business"></i>
													<span class="m-menu__link-text">
																	 Badan Hukum/PT
													</span>
													<i class="m-menu__hor-arrow la la-angle-right"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
												</a>
												<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
													<span class="m-menu__arrow"></span>
													<ul class="m-menu__subnav">
														<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="inner.html" class="m-menu__link ">
																<span class="m-menu__link-text">
																					Badan Hukum
																</span>
															</a>
														</li>
														<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																<a  href="inner.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																					PT
																	</span>
																</a>
														</li>
														<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																	<i class="m-menu__link-icon flaticon-business"></i>
																	<span class="m-menu__link-text">
																					Fakultas
																	</span>
																	<i class="m-menu__hor-arrow la la-angle-right"></i>
																	<i class="m-menu__ver-arrow la la-angle-right"></i>
																</a>
																<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																	<span class="m-menu__arrow "></span>
																		<ul class="m-menu__subnav">		
																			<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																				<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																						Tambah Fakultas
																				</span>
																				</a>
																			</li> 
																			<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																				<a  href="inner.html" class="m-menu__link ">
																					<span class="m-menu__link-text">
																							Cari Fakultas
																					</span>
																				</a>
																			</li> 
																		</ul>
																</div>
														</li> 
														<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																	<i class="m-menu__link-icon flaticon-business"></i>
																	<span class="m-menu__link-text">
																					Jurusan
																	</span>
																	<i class="m-menu__hor-arrow la la-angle-right"></i>
																	<i class="m-menu__ver-arrow la la-angle-right"></i>
																</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tambah Jurusan
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Jurusan
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Program Studi
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tambah Prodi
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Prodi
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Koreksi Prodi
																						</span>
																					</a>
																</li> </ul></div></li>  </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Dosen
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Dosen
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Dosen
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Rekap Dosen
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Koreksi Dosen
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Koreksi Dosen Ganda
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Mahasiswa
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Mahasiswa
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Mahasiswa
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Label Kelas
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Distribusi Kelas
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Setting Kartu
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Template Kartu
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Koreksi Data Mhs
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Rekap Data Mhs
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Alumni
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Alumni
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li>
	             	<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="m-menu__link m-menu__toggle">
									<span class="m-menu__item-here"></span>
										<i class="m-menu__link-icon flaticon-analytics"></i>
											<span class="m-menu__link-text">Perkuliahan</span>
													<i class="m-menu__hor-arrow la la-angle-down"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
													<span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
                 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Kurikulum/KRS Reg.
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Mata Kuliah (M-K)
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tambah MK
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari MK
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Copy Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Koreksi Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Kelompok Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Hapus Kurikulum
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Dosen Pengajar M-K
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tambah Dosen
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Dosen
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Koreksi Dosen
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Pengambilan M-K (KRS)
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Koreksi KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Syarat KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Waktu KRS Online
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tampilan KRS Online
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Pembagian Kelas
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Laporan
																						</span>
																					</a>
																</li> </ul></div></li>  </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Nilai Kuliah Reg.
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Komponen Nilai
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Komponen Nilai
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Komponen Nilai
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Komponen Default
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Konversi Nilai
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Konversi Nilai
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Nilai Mahasiswa
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai (Otomatis)
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai (Manual)
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai per Mhs
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Waktu Entri Nilai Dosen
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai Ujian Akhir
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Laporan
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Proses IPS/IPK
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Transkrip Nilai
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Kartu Hasil Studi
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Rekap IP Kumulatif
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Rekap Nilai MK
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Laporan Rekap Nilai
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cetak Ijazah
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Konfigurasi Lain
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Predikat Kelulusan
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Penanda tangan
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Setting Cetak Ijazah
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Setting Kop Surat
																						</span>
																					</a>
																</li> </ul></div></li>  </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Jadwal Kuliah Reg.
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Jadwal Kuliah
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Jadwal Kuliah
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Ruang Kosong
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Ruangan
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Ruangan
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Cetak Kartu Reg.
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak KRS
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak Kartu Ujian
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak Absensi
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Kurikulum/KRS SP
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Kurikulum SP
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Lihat Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Copy Kurikulum
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Hapus Kurikulum
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Dosen Pengajar M-K (SP)
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Tambah Dosen
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Update/Cari Dosen
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Pengambilan M-K (SP)
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Data KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Data KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Syarat KRS
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Waktu KRS Online
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Laporan
																						</span>
																					</a>
																</li> </ul></div></li>  </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Nilai Kuliah SP
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Komponen Nilai
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Komponen Nilai
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Cari Komponen Nilai
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Konversi Nilai
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Konversi Nilai
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Nilai Mahasiswa
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai (Otomatis)
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai (Manual)
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Edit Nilai per Mhs
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Waktu Entri Nilai Dosen
																						</span>
																					</a>
																</li> </ul></div></li> 
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					Laporan
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Transfer Nilai SP
																						</span>
																					</a>
																</li> <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																					<a  href="inner.html" class="m-menu__link ">
																						<span class="m-menu__link-text">
																							Kartu Hasil Studi
																						</span>
																					</a>
																</li> </ul></div></li>  </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Jadwal Kuliah SP
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Jadwal Kuliah SP
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Jadwal Kuliah SP
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Ruang Kosong
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Cetak Kartu SP
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak KRS
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak Kartu Ujian
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cetak Absensi
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li>
	             	<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="m-menu__link m-menu__toggle">
									<span class="m-menu__item-here"></span>
										<i class="m-menu__link-icon flaticon-analytics"></i>
											<span class="m-menu__link-text">PMB</span>
													<i class="m-menu__hor-arrow la la-angle-down"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
													<span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
                 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	Penerimaan Mhsw Baru
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Calon Mhs
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Calon Mhs
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Impor Calon Mhs
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Saringan Masuk
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Entri Nilai Ujian
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Proses Kelulusan
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Registrasi Mhs Baru
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Registrasi Mhs Baru (2)
																				</span>
																			</a>
																		
										 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	Ujian PMB
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Jadwal Pendaftaran
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Jadwal Ujian
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Setting Waktu
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Konfig Mail/SMTP
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Konfig Pendaftaran
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Konfig Reset Password
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Konfig Pengumuman
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Keterangan 
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li>
	             	<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="m-menu__link m-menu__toggle">
									<span class="m-menu__item-here"></span>
										<i class="m-menu__link-icon flaticon-analytics"></i>
											<span class="m-menu__link-text">Keuangan</span>
													<i class="m-menu__hor-arrow la la-angle-down"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
													<span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
                 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	 Keuangan Mhs
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Impor Pembayaran
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Entri Pembayaran
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Pembayaran
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Laporan
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Beasiswa
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Beasiswa
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Impor Rekening S1
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Impor Rekening S2
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Setting Cicilan Tagihan
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Buat Tagihan S1
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Buat Tagihan S2
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Biaya Komponen
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Komponen 
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Update Komponen 
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Kalender keuangan
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li>
	             	<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="m-menu__link m-menu__toggle">
									<span class="m-menu__item-here"></span>
										<i class="m-menu__link-icon flaticon-analytics"></i>
											<span class="m-menu__link-text">Info</span>
													<i class="m-menu__hor-arrow la la-angle-down"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
													<span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
                 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	Pengumuman
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Pengumuman
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Lihat Pengumuman
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li>
	             	<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="m-menu__link m-menu__toggle">
									<span class="m-menu__item-here"></span>
										<i class="m-menu__link-icon flaticon-analytics"></i>
											<span class="m-menu__link-text">Sistem</span>
													<i class="m-menu__hor-arrow la la-angle-down"></i>
													<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
													<span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
                 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	Password
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Ganti Password
																				</span>
																			</a>
																		
										
												<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																				<i class="m-menu__link-icon flaticon-business"></i>
																				<span class="m-menu__link-text">
																					
																				</span>
																				<i class="m-menu__hor-arrow la la-angle-right"></i>
																				<i class="m-menu__ver-arrow la la-angle-right"></i>
																			</a>
												
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																				<span class="m-menu__arrow "></span>
																				<ul class="m-menu__subnav">		
												 </ul></div></li> 
							<li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
															<a  href="javascript:;" class="m-menu__link m-menu__toggle">
																<i class="m-menu__link-icon flaticon-business"></i>
																<span class="m-menu__link-text">
																	Data Operator
																</span>
																<i class="m-menu__hor-arrow la la-angle-right"></i>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</a>
					  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
																<span class="m-menu__arrow"></span>
																<ul class="m-menu__subnav">
							
									
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Tambah Operator
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Cari Operator
																				</span>
																			</a>
																		
										
											<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
																			<a  href="inner.html" class="m-menu__link ">
																				<span class="m-menu__link-text">
																					Data Lokasi
																				</span>
																			</a>
																		
										 </ul></div></li> </ul></li><li><a href='index.php?aksi=logout' class='menulink'>Logout</a></li>       </ul><ul class='rightlink'><li>selamat datang <strong>  ( admin ) </strong></li><li><a href='#'></a></li></ul> </div>
        <script type='text/javascript'>
        var menu=new menu.dd('menu');
        menu.init('menu','menuhover');
        </script>
	   </div> <!--- END HEADER --></div> </div><div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle"> 
				<!-- BEGIN CONTAINER -->
				<div class="page-container">
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                           
<script language="javascript" type="text/javascript" src="../tiny_mce/init_tiny_mce.js"></script>
<br />
<b>Warning</b>:  include(banksoalpmb.php): failed to open stream: No such file or directory in <b>E:\xamp\htdocs\ams_new\aksi.php</b> on line <b>25</b><br />
<br />
<b>Warning</b>:  include(): Failed opening 'banksoalpmb.php' for inclusion (include_path='E:\xamp\php\PEAR') in <b>E:\xamp\htdocs\ams_new\aksi.php</b> on line <b>25</b><br />

    </div>
    </div>
    </div>   </div><!-- end content --></div><!-- end content wrapper--></div><!-- end container--></div></div><div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                    <!-- BEGIN FOOTER -->
                    <!-- BEGIN PRE-FOOTER -->
                    <div class="page-prefooter">
                        <div class="container">
							<div class="row"></div>
						</div>
					</div>
         <!-- footer -->

                        <div class="page-footer" id="footer">

                        <div class="container">

                        Academic Management System  UNIVERSITAS BATAM <br/> Developed by &#169; ICT UNIVERSITAS BATAM

                        </div>

                        </div>
         
                        <!-- end footer -->
         <div class="scroll-to-top" style="display: block;">
                        <i class="icon-arrow-up"></i>
                    </div></div> <!-- end wrap --> 