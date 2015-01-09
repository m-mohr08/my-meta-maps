<% _.each(list, function(row) { %>
	<tr class="hrefRow" data-url="#">
		<th><%= row.metadata.title %></td>
		<td><%= row.metadata.author %></td>
	</tr>
<% }); %>