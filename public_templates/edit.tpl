<h1>Edit</h1>

<form action="edit" method="post">
	<input type="hidden" value="update" name="action"/>
	<input type="hidden" value="{$embed->embed_id}" name="embed_id"/>

	<label>Embed ID</label>
	<br>
	<input type="text" readonly="true" value="{$embed->embed_id}"/>
	<br>
	<label>Date Created</label>
	<br>
	<input type="text" readonly="true" value="{$embed->date_created}"/>
	<br>
	<label>Enabled</label>
	<br>
	<select name="enabled" disabled="disabled">
		<option value="1" {if $embed->enabled}SELECTED{/if}>Yes</option>
		<option value="0" {if $embed->enabled eq false}SELECTED{/if}>No</option>
	</select>
	<!-- update button should go here @todo implement -->
</form>

<h2>Videos</h2>
<table>
	<tr>
		<th>Video ID</th>
		<th>Embed Code</th>
		<th>Preview</th>
		<th>Actions</th>
	</tr>
	{foreach from=$embed->videos item=v}
	<tr>
		<td>{$v->video_id}</td>
		<td>{htmlentities($v->embed_code)}</td>
		<td>{$v->embed_code}</td>
		<td>
			<a href="edit?action=removevideo&video_id={$v->video_id}&embed_id={$embed->embed_id}">Remove</a>
		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="2">No videos have been added yet.</td>
	</tr>
	{/foreach}
</table>

<h2>Add Video</h2>
<form action="edit" method="post">
	<input type="hidden" value="addvideo" name="action"/>
	<input type="hidden" value="{$embed->embed_id}" name="embed_id"/>

	<label>Embed Code</label>
	<input type="text" name="embed_code" value=""/>

	<button>Add</button>
</form>

<a href="portal">Back</a><br>
