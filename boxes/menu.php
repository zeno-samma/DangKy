<?php 
	if(isset($_GET['ac']) && $_GET['ac'] == 'logout'){
		unset($_SESSION['user_login']);
		header('location:../index.php');
	}
 ?>

		<!--Mainmenu-->
		<div id="main_menu">
			<div id="main_mn">
				<ul>
					<li><a href="https://kiemthe2009.com/" id="trang-chu">
						<span class="head_a"></span>
						Trang chủ<span class="head_b"></span></a><span class="head_b"></span>
					</a></li>
					<li><a href="https://kiemthe2009.com/" target='' id="nap-ssroll">
						<span class="head_a"></span>
						Diễn đàn<span class="head_b"></span></a><span class="head_b"></span>
					</a></li>

					<li><a href="https://kiemthe2009.com/" target='' id="nap-ssroll">
						<span class="head_a"></span>
						Download<span class="head_b"></span></a><span class="head_b"></span>
					</a></li>
					<!--
					<li><a href="https://kiemthe2009.com/" target='' id="nap-ssroll">
						<span class="head_a"></span>
						Nạp thẻ<span class="head_b"></span></a><span class="head_b"></span>
					</a></li>
					-->
				</ul>
		<div id="main_reg">
			<a href="" ><input class="dec" type="reset" name="reset" value="Quên mật khẩu?" />
				<script type="text/javascript"> 
					$('.dec').popupWindow({ 
						windowURL:'forgetpass.php', 
						windowName:'swip' 
					}); 
				</script></a>
				<?php if(!isset($_SESSION['user_login']) or $_SESSION['user_login']==''){?>
					<a href="index.php"><input class="login_b" type="submit" name="submitButtonName" value="Đăng ký" /></a>
				<?php }else{ ?>
					<font color="white" size=4>Chào: <b><?=$_SESSION['user_login'];?></b></font> 
					<a style="color:white;" href="index.php?ac=logout">(Đăng xuất)</a>
					<!-- (<a href="" onclick="return dangxuat();">Đăng xuất</a>) -->
				<?php }?>
			</div>
			</div>
		</div>
		<!--END Mainmenu-->