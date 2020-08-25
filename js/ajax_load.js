var urlhientai='';
var interval = '';
function ajax_post2(cur_url,act)
{
	if (document.getElementById) {
		var x = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}
	if (x)
	{
		x.onreadystatechange = function()
		{
			el = document.getElementById('noidungchinh');
			document.getElementById('loading').style.display = 'block';
			self.scrollTo(0, 0);
			if (x.readyState == 4 && x.status == 200)
			{
				el.innerHTML = x.responseText;
				document.getElementById('loading').style.display = 'none';
			}
		}
	urlhientai = window.location.href;
	var url='act='+act;
	x.open("POST", './yesajax.php');
	x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	x.send(url);
	}
}
function getact(){
	var url = window.location.href+"/";//link hien tai tren trinh duyet
	if (url.indexOf('#')!=-1) 
		var c_url = url.split('#');
	else
		{
			window.location.href = './#trang-chu/';
			return 'trang-chu';
		}
	var id = c_url?c_url[1]:'#';//Lay gia tri phia sau # trong url
	return id;
}
function sinhvienit_load()
{
	var url=window.location.href;
	var act=getact();
	if (urlhientai!=url)
		{
			ajax_post2(url,act);
		}
}
function startLoad() {
	interval = setInterval('sinhvienit_load()',10);
}
function gopage(url)
{
	window.location.href = url;
	return false;
}