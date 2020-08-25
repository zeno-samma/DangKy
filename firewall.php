<?php
# Global variables
$conf = array();
require_once('firewall_config.php');
$conf['now']  = time();
$conf['addr'] = fetch_ip();
$conf['save_log'] = $conf['addr'].' - '.$_SERVER['HTTP_USER_AGENT'].' - '.get_gmdate($conf['now']).' - "'.$_SERVER['REQUEST_METHOD'].' '.fetch_url().' '.$_SERVER['SERVER_PROTOCOL'].'"'."\r\n";

# Initiated
reset_firewall( $conf['path'], 'resetfw.txt' );

check_spam($conf['path'].'/spamips.txt', $conf['save_log']);
$bot_safe = check_bot();
if( ! $_GET['adsess'] || ! $bot_safe )
{
	// check_attack($conf['path'].'/attackips.txt', $conf['save_log']);
	check_flood($conf['path'].'/'.$conf['addr']);
}

function reset_firewall($path, $file_resetfw)
{
    $time_check_pre = check_log( $path ."/". $file_resetfw, 'rb' );
    $day_now = date("j", time() );
    if( $time_check_pre != $day_now ) {
        delete_allfile_folder($path);
        check_log( $path ."/". $file_resetfw, 'w', $day_now );
        check_log( $path .'/'. 'attackips.txt' );
        check_log( $path .'/'. 'floodips.txt' );
        check_log( $path .'/'. 'index.html' );
        check_log( $path .'/'. 'spamips.txt' );
    }
}

function delete_allfile_folder($tmp_path)
{
    if (!is_writeable($tmp_path) && is_dir($tmp_path)) {
        chmod($tmp_path, 0777);
    }
    $handle = opendir($tmp_path);
    while ($tmp = readdir($handle)) {
        if ($tmp != '..' && $tmp != '.' && $tmp != '') {
            if (is_writeable($tmp_path . DS . $tmp) && is_file($tmp_path . DS . $tmp)) {
                unlink($tmp_path . DS . $tmp);
            } elseif (!is_writeable($tmp_path . DS . $tmp) && is_file($tmp_path . DS . $tmp)) {
                chmod($tmp_path . DS . $tmp, 0666);
                unlink($tmp_path . DS . $tmp);
            }
        }
    }
    closedir($handle);
}

function check_bot()
{
	# Search engine spider bots
	$apps[] = 'googlebot';				// Google
	$apps[] = 'mediapartners-google';	// Google Adsense
	$apps[] = 'yahoo! slurp';			// Yahoo
	$apps[] = 'yahoo-mm';				// Yahoo-MMCrawler/Yahoo-MMAudVid
	$apps[] = 'slurp@inktomi';			// Hot Bot
	$apps[] = 'lycos';					// Lycos
	$apps[] = 'fast-webcrawler';		// Fast AllTheWeb
	$apps[] = 'msnbot';					// MSN Search
	$apps[] = 'ask jeeves';				// Ask Jeeves
	$apps[] = 'teoma';					// Teoma
	$apps[] = 'scooter';				// Altavista
	$apps[] = 'ia_archiver';			// Archive.org
	$apps[] = 'almaden';				// IBM Almaden Web Crawler
	$apps[] = 'gigabot';				// Gigabot spider
	$apps[] = 'whatuseek';				// What You Seek

	# Various http utility libaries
	$apps[] = 'w3c_validator';
	$apps[] = 'wdg_validator';
	$apps[] = 'libwww-perl';
	$apps[] = 'jakarta commons-httpclient';
	$apps[] = 'python-urllib';

	for( $i = 0; $i <= count($apps); $i++ )
	{
		if( stristr($_SERVER['HTTP_USER_AGENT'], $apps[$i]) ) return TRUE;
	}
}

function check_spam($path,$log)
{
	$apps = array('CherryPicker','Crescent','DDoSkit','EmailCollector','EmailSiphon','EmailWolf','ExtractorPro','FileHound','Mozilla/3.Mozilla/2.01','NICErsPRO','Wget','Whacker');
	for( $i = 0; $i <= count($apps); $i++ )
	{
		if( stristr($_SERVER['HTTP_USER_AGENT'], $apps[$i]) )
		{
			check_log($path, 'a', $log);
			exit();
		}
	}
}

function check_attack($path,$log)
{
	$input  = strtolower($_SERVER['QUERY_STRING']);
	$array  = array('alter','create','drop','rename','delete%20','handler','insert','load%20data','replace','select','join','union','truncate','describe','lock%20tables','grant','revoke','set%20password','flush','kill','shutdown','distinct','having','procedure','order%20by','group%20by','exec');
	$return = str_replace($array, "", $input);
	if( $input != $return )
	{
		check_log($path, 'a', $log);
		print_error("Hoạt động của bạn bị cấm.");
	}
}

function check_flood($path)
{
	global $conf;

	$pass = 0;

	# Take a small check
	$blocktime = check_log($path.'.lock','rb');
	if( $blocktime == 'banned' )
	{
		print_error("Địa chỉ IP <font color='red'>{$conf['addr']}</font> đã bị khóa.<br />Hãy sử dụng email bạn đã đăng kí và gửi yêu cầu về <br />đến <a href='mailto:{$conf['mailadds']}'>{$conf['mailname']}</a> để kích hoạt sử dụng.");
	}
	elseif( $blocktime > 0 )
	{
		if( ( $conf['now'] - $blocktime ) <= $conf['blocktime'] )
		{
			print_error("Phát hiện hành vi tấn công!<br />Hãy đợi ít nhất <font color='red'>{$conf['blocktime']} giây</font> trước khi sử dụng tiếp (Thời gian đã khóa: ".($conf['now'] - $blocktime)." giây).");
		}
		else
		{
			$pass = 1;
			check_log($path.'.lock');
		}
	}

	# Log IP
	$content = check_log($path,'rb');
	if( $content )
	{
		$content = preg_replace("/,$/", "", $content);
		if( substr_count($content, ',') >= ( $conf['requests'] + 1 ) )
		{
			$pass  = 1;
			$count = 0;
			$cache = explode(',', $content);

			for( $i = 1; $i <= count($cache); $i++ )
			{
				if( ( $cache[$i] - $cache[$i-1] ) <= $conf['interval'] ) $count++;
			}

			if( $count >= $conf['requests'] )
			{
				# Check the number of attack
				$log_file = $conf['path'].'/floodips.txt';
				$floodips = check_log($log_file,'rb');
				$floodips = preg_replace("/,$/", "", $floodips);
				if( substr_count($floodips, $conf['addr']) <= $conf['maxaccess'] )
				{
					check_log($path.'.lock', 'w', $conf['now']);
					check_log($log_file, 'a', $conf['save_log']);
				}
				else
				{
					check_log($path.'.lock', 'w', 'banned');
					exit();
				}
			}
		}
		else
		{
			$pass = 0;
		}
	}

	if( $pass )
	{
		check_log($path);
	}
	else
	{
		check_log($path, 'a', $conf['now'].',');
	}
}

function check_log($path,$mode='w',$str='')
{
	$buffer = '';
	if( $FH = @fopen($path, $mode) )
	{
		if( $mode == 'rb' )
		{
			while( ! @feof($FH) )
			{
				$buffer .= @fgets($FH, 1024);
			}
		}
		else
		{
			@fwrite($FH, $str);
		}
		@fclose($FH);
		@chmod($path, 0777);
	}

	return $buffer;
}

function fetch_ip()
{
	# Enable X_FORWARDED_FOR IP matching?
	$do_check = 1;
	$addrs = array();

	if( $do_check )
	{
		foreach( array_reverse(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])) as $x_f )
		{
			$x_f = trim($x_f);
			if( preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $x_f) )
			{
				$addrs[] = $x_f;
			}
		}

		$addrs[] = $_SERVER['HTTP_CLIENT_IP'];
		$addrs[] = $_SERVER['HTTP_PROXY_USER'];
	}

	$addrs[] = $_SERVER['REMOTE_ADDR'];

	foreach( $addrs as $v )
	{
		if( $v )
		{
			preg_match("/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/", $v, $match);
			$ip = $match[1].'.'.$match[2].'.'.$match[3].'.'.$match[4];

			if( $ip && $ip != '...' )
			{
				break;
			}
		}
	}

	if( ! $ip || $ip == '...' )
	{
		print_error("Không thể xác định địa chỉ IP của bạn.");
	}

	return $ip;
}

function fetch_url()
{
	if( $_SERVER['REQUEST_URI'] || $_ENV['REQUEST_URI'] )
	{
		$url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_ENV['REQUEST_URI'];
	}
	else
	{
		if( $_SERVER['PATH_INFO'] || $_ENV['PATH_INFO'] )
		{
			$url = $_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : $_ENV['PATH_INFO'];
		}
		elseif( $_SERVER['REDIRECT_URL'] || $_ENV['REDIRECT_URL'] )
		{
			$url = $_SERVER['REDIRECT_URL'] ? $_SERVER['REDIRECT_URL'] : $_ENV['REDIRECT_URL'];
		}
		else
		{
			$url = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_ENV['PHP_SELF'];
		}

		if( $_SERVER['QUERY_STRING'] || $_ENV['QUERY_STRING'] )
		{
			$url .= '?'.( $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_ENV['QUERY_STRING'] );
		}
	}

	$url = preg_replace('/s=[a-z0-9]{32}?&?/', '', $url);
	$url = preg_replace('/&(?!#[0-9]+;)/si', '&amp;', $url);
	$url = str_replace(array('<','>','"'), array('&lt;','&gt;','&quot;'), $url);
	$url = preg_replace(array('#javascript#i','#vbscript#i'), array('java script','vb script'), $url);

	return $url;
}

function get_gmdate($time="")
{
	$offset  = 7 * 3600; // GMT+07:00
	$timenow = $time ? $time : time();

	return gmdate("D d-M-Y H:i:s A", ($timenow + $offset));
}

function print_error($msg)
{
	echo "
	<html>
	<head><title>Hệ thống chống xâm nhập</title>
		<style type='text/css'>
			html{ overflow-x:auto; }
			body{ background:#FFF; color:#222; font-family:Arial, Verdana, Tahoma, Times New Roman, Courier; font-size:11px; line-height:135%; margin:0; padding:0; text-align:center; }
			a:link, a:visited, a:active{ background:transparent; color:#0066CC; text-decoration:none; }
			a:hover{ background:transparent; color:#000000; text-decoration:underline; }
			#wrapper{ margin:5px auto 20px auto; text-align:left; width:80%; }
			.borderwrap{ background:#FFF; border:1px solid #EEE; padding:3px; margin:0; }
			.borderwrap p{ background:#F9F9F9; border:1px solid #CCC; margin:5px; padding:10px; text-align:left; }
			.warnbox{ border:1px solid #F00; background:#FFE0E0; padding:6px; margin-right:1%; margin-left:1%; text-align:left; }
		</style>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	</head>
	<body>
	<div id='wrapper'><br /><br />
		<div class='borderwrap'>
			<p style='font-size:15pt; color:#FF3300;'><b>Cảnh Báo:</b></p><br /><br />
			<div class='warnbox'>
				<b>$msg</b>
			</div><br />
		</div><br />
		<div align='center' style='border:1px solid #EEE; padding:5px 0px 5px 5px; color:#808080; font-face:Tahoma;'><a href='http://123.30.136.202/' target='_blank'>Hệ thống chống xâm nhập</a> &copy; ".date('Y')." <a href='mailto:rick.vocam@yahoo.com.vn'>Kiem the lau Security</a></div>
	</div>
	</body>
	</html>";
	exit();
}

?>