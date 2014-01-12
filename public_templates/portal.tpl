<h1>Portal</h1>
<table>
<tr><th>Emebed ID</th><th>Stats</th><th>Actions</th></tr>
{foreach from=$embeds item=e}
<tr>
	<td>{$e->embed_id}</td>
	<td>
		<table>
			<tr>
				<th>Video ID</th><th>Action</th><th>Num Actions</th>
			</tr>
			{foreach from=EmbedMgr::GetStats($e->embed_id) item=va}
			<tr>
				<td>{$va->video_id}</td>
				<td>{$va->action}</td>
				<td>{$va->num_actions}</td>
			</tr>
			{foreachelse}
			<tr>
				<td colspan="3">No actions have been recorded</td>
			</tr>
			{/foreach}
		</table>
	</td>
	<td>
		<a href="/edit?embed_id={$e->embed_id}">Edit</a><br>
		<a href="/embed?embed_id={$e->embed_id}&code=true" target="_BLANK">Get View URL</a><br>
		<a href="/success?embed_id={$e->embed_id}&code=true" target="_BLANK">Get Success URL</a>
	</td>
</tr>
{foreachelse}
<tr><td colspan="3"><center>No embeds yet</center></td></tr>
{/foreach}
</table>

<a href="add">Create Embed</a><br>
<a href="logout">Logout</a>
