<% _.each(data, function(row) { %>
	<a><%= row.metadata.title %></a>
	<a><%= row.comments %></a>
	<br>
<% }); %>