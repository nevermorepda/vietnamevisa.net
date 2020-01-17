<? $method = $this->util->slug($this->router->fetch_method()); ?>
<ul class="nav nav-tabs">
	<li role="presentation" class="nav-item"><a class="nav-link <?=($method == 'index' || $method == 'myaccount') ? 'active' : ''?>" href="<?=site_url("member")?>">My Application</a></li>
	<li role="presentation" class="nav-item"><a class="nav-link <?=($method == 'profile') ? 'active' : ''?>" href="<?=site_url("member/profile")?>">Profile</a></li>
	<li role="presentation" class="nav-item"><a class="nav-link <?=($method == 'change-password') ? 'active' : ''?>" href="<?=site_url("member/change-password")?>">Change Password</a></li>
</ul>