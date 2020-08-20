<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="public/css/style.css" type="text/css" />
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="script.js"></script>
</head>
<body>

<center>
	<div id="body">
		<div id="content">
			<form id='login' action='login-submit.php' method='post' accept-charset='UTF-8'>
				<table align="center">
					<tr>
					<td align="center">
							<legend>Login</legend>
						</td>
					</tr>
					<tr>
						<td>
							<label for='username' >UserName*:</label>
							<input type='email' name='username' id='username'  maxlength="50" />
						</td>
					</tr>
					<tr>
						<td>
							<label for='password' >Password*:</label>
							<input type='password' name='password' id='password' maxlength="50" />
						</td>
					</tr>
					<tr>
						<td>
							type<br>
							<div style="padding-left: 12px">
								<input id="type_A" type="radio" name="type" placeholder="type" value="admin" checked style="height: initial;
								width: initial;" /><label for="type_A">Admin</label><br>
								<input id="type_CR" type="radio" name="type" placeholder="type" value="controleur" style="height: initial;
								width: initial;"/><label for="type_CR">Controleur/Releveur</label><br>
								<input id="type_C" type="radio" name="type" placeholder="type" value="client" style="height: initial;
								width: initial;"/><label for="type_C">Client</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='Submit' value='Submit' />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	</center>
</body>
</html>