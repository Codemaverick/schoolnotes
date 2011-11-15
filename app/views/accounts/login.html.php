<?php $this->title("Login"); ?>

<h1>Login</h1>

<h4>First Your Password, then Open Sesame...!</h4>
<div>
<form method="post" action="/accounts/loginuser">
	<div class="formItem">
		<label>Username:</label>
		<input type="text" name="usermodel[username]" id="usermodel_username" placeholder="username" />
	</div>
	<div class="formItem">
		<label>Password:</label>
		<input type="password" name="usermodel[password]" id="usermodel_password" placeholder="password" />
	</div>
	<div class="formItem">
		<input type="submit" name="submit" id="usermodel_submit" value="submit" />
	</div>
</form>
	
</div>