function ajax_get(url,id)
{
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x)
	{
		x.onreadystatechange = function()
		{
			el = document.getElementById(id);
			//el.innerHTML = loadstatustext;
			document.getElementById('loading').style.display = 'block';
			if (x.readyState == 4 && x.status == 200)
			{
				el.innerHTML = x.responseText;
				document.getElementById('loading').style.display = 'none';
			}
		}
	x.open("GET", url, true);
	x.send(null);
	}
}
function ajax_post(page,url,id,flag)
{
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x)
	{
		x.onreadystatechange = function()
		{
			el = document.getElementById(id);
			//linkz = document.getElementById("linkz");
			//el.innerHTML = loadstatustext;
			//document.getElementById('loading').style.display = 'block';
			if (x.readyState == 4 && x.status == 200)
			{
				el.innerHTML = x.responseText;
				if(flag==1){
					setTimeout(' document.location=document.location' ,100);
				}
				//linkz.innerHTML = "Please F5.";
				//document.getElementById('loading').style.display = 'none';
			}
		}
	x.open("POST", page);
	x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	x.send(url);
	}
}


//Hien DIV ID
function hien(div) {
	if (document.getElementById(div).style.display == 'none')
		document.getElementById(div).style.display = '';
	else
		document.getElementById(div).style.display = 'none';
	return false;
}
//-----------------Dang ky thanh vien
function dangky() {
	var url;
	//---------Thong tin bat buoc
	var user_name = document.frmDangky.user_name.value;
	var user_pass = document.frmDangky.user_pass.value;
	var user_pass2 = document.frmDangky.user_pass2.value;
	var user_email = document.frmDangky.user_email.value;
	var user_fullname = document.frmDangky.user_fullname.value;
	var user_gioitinh = document.frmDangky.user_gioitinh.value;	
	var user_anti = document.frmDangky.user_anti.value;	
	//----------Ngay sinh
	var user_ngay = document.frmDangky.user_ngay.value;
	var user_thang = document.frmDangky.user_thang.value;
	var user_nam = document.frmDangky.user_nam.value;
	//-------------Thong tin ko bat buoc
	var user_work = document.frmDangky.user_work.value;

	//--------------Kiem tra du lieu nhap vao
	if (user_name == "")
		{
			alert("Type username");
			document.frmDangky.user_name.focus();
		}
	else if (user_pass == "")
		{
			alert("Type password");
			document.frmDangky.user_pass.focus();
		}
	else if (user_pass2 == "")
		{
			alert("Type password again");
			document.frmDangky.user_pass2.focus();
		}
	else if	(user_pass != user_pass2)
		{
			alert("Not match password");
			document.frmDangky.user_pass.focus();
		}
	else if (user_email == "")
		{
			alert("Type Email");
			document.frmDangky.user_email.focus();
		}
	else if (user_fullname == "")
		{
			alert("Type name");
			document.frmDangky.user_fullname.focus();
		}
	else if (user_ngay == "")
		{
			alert("Type birthday day");
			document.frmDangky.user_ngay.focus();
		}
	else if (user_thang == "")
		{
			alert("Type birthday month");
			document.frmDangky.user_thang.focus();
		}
	else if (user_nam == "")
		{
			alert("Type birthday year");
			document.frmDangky.user_nam.focus();
		}
	else if (user_anti == "")
		{
			alert("Type security code");
			document.frmDangky.user_anti.focus();
		}
	else {
			//------------------Gui yeu cau dang ky
			url='dangky=ok&user_name='+user_name+'&user_pass='+user_pass+'&user_pass2='+user_pass2+'&user_email='+user_email+'&user_fullname='+user_fullname+'&user_nghenghiep='+user_work+'&user_gioitinh='+user_gioitinh+'&user_ngay='+user_ngay+'&user_thang='+user_thang+'&user_nam='+user_nam+'&user_anti='+user_anti;
			ajax_post('ajax.php',url,'divDangky',0);
		}
	return false;
}

//-----------Dang nhap nhanh
function dangnhapnhanh() {
	var user_name,user_pass,ghinho,url;
	user_name = document.frmDangnhap.username.value;
	user_pass = document.frmDangnhap.password.value;
	if (document.frmDangnhap.ghinho.checked==true)
		ghinho='yes';
	else
		ghinho='no';
	if (user_name == "")
		{
			alert("Please fill Username");
			document.frmDangnhap.username.focus();
		}
	else if (user_pass == "")
		{
			alert("Please fill Password");
			document.frmDangnhap.password.focus();
		}		
	else {
			url='dangnhap=ok&user_name='+user_name+'&user_pass='+user_pass+'&ghinho='+ghinho;
			ajax_post('ajax.php',url,'userinfo',1);
		}
	return false;
}
//-----------Dang xuat
function dangxuat() {
			var xacnhan=confirm('Are you sure ?');
			if (xacnhan==true)
				{
					var url='page=dangxuat';
					ajax_post('user_process.php?'+url,'','main_reg',1);
				
					
				}
				setTimeout(' document.location=document.location' ,3000);
		return false;
}
//-----------doi mat khau cap 2
function doimk2() {
			user_name = document.frm_doimk2.username.value;
			cauhoi_bimat = document.frm_doimk2.cauhoibimat.value;
			traloi_cauhoi = document.frm_doimk2.traloicauhoi.value;
			password_2 = document.frm_doimk2.password2.value;
					var url='username='+user_name+'&cauhoibimat='+cauhoi_bimat+'&traloicauhoi='+encodeURI(traloi_cauhoi)+'&password2='+password_2;
					//alert(url);
					ajax_post('user_process.php?page=mk2',url,'thongbaodoimk2',0);
				
		return false;
}
//-----------Lien he
function lienhe() {
	var lienhe_email,lienhe_tieude,lienhe_thongdiep,lienhe_mabaove,url;
	lienhe_email = document.frmContact.lienhe_email.value;
	lienhe_tieude = document.frmContact.lienhe_tieude.value;
	lienhe_thongdiep = document.frmContact.lienhe_thongdiep.value;
	lienhe_mabaove = document.frmContact.lienhe_mabaove.value;
	if (lienhe_email == "")
		{
			alert("Please fill Email");
			document.frmContact.lienhe_email.focus();
		}
	else if (lienhe_tieude == "")
		{
			alert("Please fill title");
			document.frmContact.lienhe_tieude.focus();
		}
	else if (lienhe_thongdiep == "")
		{
			alert("Please fill content");
			document.frmContact.lienhe_thongdiep.focus();
		}
	else if (lienhe_mabaove == "")
		{
			alert("Please fill security code");
			document.frmContact.lienhe_mabaove.focus();
		}
	else {
			url='lienhe=ok&lienhe_email='+lienhe_email+'&lienhe_tieude='+lienhe_tieude+'&lienhe_mabaove='+lienhe_mabaove+'&lienhe_thongdiep='+lienhe_thongdiep;
			ajax_post('./ajax.php',url,'divContact');
		}
	return false;
}

//-------------------Tim kiem
function timkiem(trang) {
			var tukhoa=document.frmtimkiem.tukhoa.value;
			var kieutim=document.frmtimkiem.searchtype.value;
			var url='tukhoa='+tukhoa+'&kieutim='+kieutim+'&page='+trang;
			if (tukhoa=="")
				{
					alert("Please type keyword");
					document.frmtimkiem.tukhoa.focus();
				}
			else
				{
					ajax_post('./timkiem.php',url,'noidungchinh');
				}
	return false;
}
//-------------------Tim kiem YesAjax
function timkiem_ajax(trang) {
			var tukhoa=document.frmtimkiem.tukhoa.value;
			var kieutim=document.frmtimkiem.searchtype.value;
			var url='tukhoa='+tukhoa+'&kieutim='+kieutim+'&page='+trang;
			if (tukhoa=="")
				{
					alert("Please type keyword");
					document.frmtimkiem.tukhoa.focus();
				}
			else
				{
					ajax_post('./timkiem_ajax.php',url,'noidungchinh');
				}
	return false;
}
//----------------Go to top page
function gotop()
{
	self.scrollTo(0, 0);
	return false;
}
//--------------Mo popup
function openwin(url,width,height)
{
	if (width == null)  { width  = 200; }   // default width
	if (height == null) { height = 400; }   // default height
	newwin=window.open(url,'callgirl3xnet','fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width='+width+',height='+height);
	if (document.all)
	{
		newwin.moveTo(0,0);
		newwin.focus();
	}
	return false;
}