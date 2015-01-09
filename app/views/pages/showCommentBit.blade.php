<% _.each(data, function(row) { %>
	<a class="list-group-item"><%= row.metadata.title %>
	<span class="badge"><%= row.comments %></span></a>
<% }); %>