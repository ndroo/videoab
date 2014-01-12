<h1>Create Acount</h1>
{if isset($error)}
<p>Invalid Input / User Already Exists</p>
{/if}
<form action="create" method="POST">
	<label>Email</label>
	<input type="text" name="email"/>
	<label>Password</label>
	<input type="password" name="password"/>
	<button>Signup</button>
</form>
<div>
<a href="/index">Login</a>
</div>
