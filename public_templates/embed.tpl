{if isset($embed_code)}
	{if $mode eq "code"}
	<h1>Instructions</h1>
	<p>Display the following code on your website where you want the video to show:
		<div style="width:500px;border:1px solid black;">
			{$embed_code}
		</div>
	</p>
	<p>Display the following code on your website where the user completes the "success" action:
		<div style="width:500px;border:1px solid black;">
			{$success_code}
		</div>
	</p>

	<a href="portal">Back</a>
	{else}
		{$embed_code}
	{/if}
{else}
	Unknown Embed ID
{/if}
