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

function lookupKurikulumSP(inputString,prodi,tahun,semester) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsKurikulum').hide();
    } else {
        $.post("../lib/carikurikulumsp.php", {queryString: ""+inputString+""  ,  prodi: ""+prodi+""  ,  tahun: ""+tahun+""  ,  semester: ""+semester+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsKurikulum').show();
                $('#autoSuggestionsListKurikulum').html(data);
            } else {
              $('#suggestionsKurikulum').hide();
            }
        });
    }
} // lookup
function fillKurikulumSP(thisValue) {
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

function lookupListProdi(inputStringListProdi) {
    if(inputStringListProdi.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListProdi').hide();
    } else {
        $.post("../lib/carilistprodi.php", {queryString: ""+inputStringListProdi+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListProdi').show();
                $('#autoSuggestionsListProdi').html(data);
            } else {
              $('#suggestionsListProdi').hide();
            }
        });
    }
} // lookup
function fillListProdi(thisValue) {
    $('#inputStringListProdi').val(thisValue);
   $('#suggestionsListProdi').hide();
}

function lookupListDosenNidn(inputStringListDosenNidn) {
    if(inputStringListDosenNidn.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListDosenNidn').hide();
    } else {
        $.post("../lib/carilistdosennidn.php", {queryString: ""+inputStringListDosenNidn+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListDosenNidn').show();
                $('#autoSuggestionsListDosenNidn').html(data);
            } else {
              $('#suggestionsListDosenNidn').hide();
            }
        });
    }
} // lookup
function fillListDosenNidn(thisValue) {
    $('#inputStringListDosenNidn').val(thisValue);
   $('#suggestionsListDosenNidn').hide();
}

function lookupListDosenNidn2(inputStringListDosenNidn2) {
    if(inputStringListDosenNidn2.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListDosenNidn2').hide();
    } else {
        $.post("../lib/carilistdosennidn2.php", {queryString: ""+inputStringListDosenNidn2+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListDosenNidn2').show();
                $('#autoSuggestionsListDosenNidn2').html(data);
            } else {
              $('#suggestionsListDosenNidn2').hide();
            }
        });
    }
} // lookup
function fillListDosenNidn2(thisValue) {
    $('#inputStringListDosenNidn2').val(thisValue);
   $('#suggestionsListDosenNidn2').hide();
}

function lookupListDosenNidn3(inputStringListDosenNidn3) {
    if(inputStringListDosenNidn3.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListDosenNidn3').hide();
    } else {
        $.post("../lib/carilistdosennidn3.php", {queryString: ""+inputStringListDosenNidn3+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListDosenNidn3').show();
                $('#autoSuggestionsListDosenNidn3').html(data);
            } else {
              $('#suggestionsListDosenNidn3').hide();
            }
        });
    }
} // lookup
function fillListDosenNidn3(thisValue) {
    $('#inputStringListDosenNidn3').val(thisValue);
   $('#suggestionsListDosenNidn3').hide();
}

function lookupListDosenNidn4(inputStringListDosenNidn3) {
    if(inputStringListDosenNidn4.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListDosenNidn4').hide();
    } else {
        $.post("../lib/carilistdosennidn4.php", {queryString: ""+inputStringListDosenNidn4+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListDosenNidn4').show();
                $('#autoSuggestionsListDosenNidn4').html(data);
            } else {
              $('#suggestionsListDosenNidn4').hide();
            }
        });
    }
} // lookup
function fillListDosenNidn4(thisValue) {
    $('#inputStringListDosenNidn4').val(thisValue);
   $('#suggestionsListDosenNidn4').hide();
}

function lookupListDosenNidn5(inputStringListDosenNidn3) {
    if(inputStringListDosenNidn5.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListDosenNidn5').hide();
    } else {
        $.post("../lib/carilistdosennidn5.php", {queryString: ""+inputStringListDosenNidn5+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListDosenNidn5').show();
                $('#autoSuggestionsListDosenNidn5').html(data);
            } else {
              $('#suggestionsListDosenNidn5').hide();
            }
        });
    }
} // lookup
function fillListDosenNidn5(thisValue) {
    $('#inputStringListDosenNidn5').val(thisValue);
   $('#suggestionsListDosenNidn5').hide();
}

function lookupListPT(inputStringListPT) {
    if(inputStringListPT.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsListPT').hide();
    } else {
        $.post("../lib/carilistpt.php", {queryString: ""+inputStringListPT+""}, function(data){
            if(data.length >0) {
                $('#suggestionsListPT').show();
                $('#autoSuggestionsListPT').html(data);
            } else {
              $('#suggestionsListPT').hide();
            }
        });
    }
} // lookup
function fillListPT(thisValue) {
    $('#inputStringListPT').val(thisValue);
   $('#suggestionsListPT').hide();
}

function lookupListAlumni(inputStringListAlumni,prodi,angkatan) {
    if(inputStringListAlumni.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsAlumni').hide();
    } else {
        $.post("../lib/carialumni.php", {queryString: ""+inputStringListAlumni+"",  prodi: ""+prodi+""  ,  angkatan: ""+angkatan+"" }, function(data){
            if(data.length >0) {
                $('#suggestionsAlumni').show();
                $('#autoSuggestionsListAlumni').html(data);
            } else {
              $('#suggestionsAlumni').hide();
            }
        });
    }
} // lookup
function fillListAlumni(thisValue) {
    $('#inputStringListAlumni').val(thisValue);
   $('#suggestionsAlumni').hide();
}

function lookupProdiPT(inputStringProdiPT) {
    if(inputStringProdiPT.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsProdiPT').hide();
    } else {
        $.post("../lib/cariprodipt.php", {queryString: ""+inputStringProdiPT+""}, function(data){
            if(data.length >0) {
                $('#suggestionsProdiPT').show();
                $('#autoSuggestionsProdiPT').html(data);
            } else {
              $('#suggestionsProdiPT').hide();
            }
        });
    }
} // lookup
function fillProdiPT(thisValue) {
    $('#inputStringProdiPT').val(thisValue);
   $('#suggestionsProdiPT').hide();
}

function lookupProdiPT2(inputStringProdiPT2) {
    if(inputStringProdiPT2.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsProdiPT2').hide();
    } else {
        $.post("../lib/cariprodipt2.php", {queryString: ""+inputStringProdiPT2+""}, function(data){
            if(data.length >0) {
                $('#suggestionsProdiPT2').show();
                $('#autoSuggestionsProdiPT2').html(data);
            } else {
              $('#suggestionsProdiPT2').hide();
            }
        });
    }
} // lookup
function fillProdiPT2(thisValue) {
    $('#inputStringProdiPT2').val(thisValue);
   $('#suggestionsProdiPT2').hide();
}

function lookupPropinsi(inputStringPropinsi) {
    if(inputStringPropinsi.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsPropinsi').hide();
    } else {
        $.post("../lib/caripropinsi.php", {queryString: ""+inputStringPropinsi+""}, function(data){
            if(data.length >0) {
                $('#suggestionsPropinsi').show();
                $('#autoSuggestionsListPropinsi').html(data);
            } else {
              $('#suggestionsPropinsi').hide();
            }
        });
    }
} // lookup
function fillPropinsi(thisValue) {
    $('#inputStringPropinsi').val(thisValue);
   $('#suggestionsPropinsi').hide();
}

function lookupKecamatan(inputString,prodi) {
    if(inputString.length <= 2) {
        // Hide the suggestion box.
        $('#suggestionsKecamatan').hide();
    } else {
        $.post("../lib/carikecamatan.php", {queryString: ""+inputString+"" ,  prodi: ""+prodi+""  }, function(data){
            if(data.length >0) {
                $('#suggestionsKecamatan').show();
                $('#autoSuggestionsListKecamatan').html(data);
            } else {
              $('#suggestionsKecamatan').hide();
            }
        });
    }
} // lookup
function fillKecamatan(thisValue,thisValue2) {
   $('#inputStringDataKecamatan').val(thisValue);
   $('#inputStringKecamatan').val(thisValue2);
   $('#suggestionsKecamatan').hide();
}
// -->
</script>
