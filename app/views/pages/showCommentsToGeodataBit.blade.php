<% _.each(data, function(row) { %>
	<a class="list-group-item"><%= _.escape(row.comments.title) %>
	<span class="badge"><%= row.comments.rating %></span></a>
<% }); %>
<% if (_.isEmpty(data)) { %>
	<span class="list-group-item">Es konnten keine Kommentare zu diesem Geodatensatz angezeigt werden.</span>
<% } %>