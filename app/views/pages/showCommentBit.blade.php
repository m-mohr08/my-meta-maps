<% _.each(data, function(row) { %>
	<a class="list-group-item"><%= row.metadata.title %>
	<span class="badge"><%= row.comments %></span></a>
<% }); %>
<% if (_.isEmpty(data)) { %>
	Es entsprechen leider keine Daten der Suchanfrage.
<% } %>