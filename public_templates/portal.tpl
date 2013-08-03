<table>
<tr><td>Emebed ID</td><td>Number of Views</td><td>Number of Successes</td><td>Actions</td></tr>
{foreach from=$embeds item=e}
<tr><td>{$e->embed_id}</td><td>#views</td><td>#success</td><td><a href="/embed?embed_id={$e->embed_id}" target="_BLANK">Test View</a> | <a href="/success?embed_id={$e->embed_id}" target="_BLANK">Test Success</a></td></tr>
{foreachelse}
<tr><td colspan="3"><center>No embeds yet</center></td></tr>
{/foreach}
</table>
