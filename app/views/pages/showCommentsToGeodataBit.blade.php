<% _.each(data, function(row) { %>
	<li class="list-group-item"><%= _.escape(row.comments.title) %>
	<span class="badge"><%= row.comments.rating %></span></li>
<% }); %>
<% if (_.isEmpty(data)) { %>
	<span class="list-group-item">Es konnten keine Kommentare zu diesem Geodatensatz angezeigt werden.</span>
<% } %>