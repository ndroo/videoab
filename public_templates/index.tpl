<h1>Login</h1>
{if isset($error)}
<p>Invalid User / Password</p>
{/if}
<form action="index" method="POST">
	<label>Email</label>
	<input type="text" name="email"/>
	<label>Password</label>
	<input type="password" name="password"/>
	<button>Login</button>
</form>
<div>
<a href="/create">Create Account</a>
</div>
