<div class="list-group-item" id="CommentId<%- comment.id %>">
	<div class="row clearfix">
		<dd><pre><%= ViewUtils.parseComment(comment.text) %></pre></dd>
	</div>
	<div class="row clearfix text-right metadata-comment">
		<% if (_.isEmpty(comment.user)) { %>
			<span class="badge alert-default pull-left">
				<span class="glyphicon glyphicon-user"></span>&nbsp;<span>@lang('misc.anonym')</span>
			</span>
		<% } else { %>
			<span class="badge alert-info pull-left">
				<span class="glyphicon glyphicon-user"></span>&nbsp;<span><%- comment.user.name %></span>
			</span>
		<% } %>
		<% if (!_.isEmpty(comment.geometry)) { %>
		<span class="badge alert-default map-Marker" title="Geodaten vorhanden"><!-- TODO: Language -->
			<span class="glyphicon glyphicon-map-marker"></span>
		</span>
		<% } if (!_.isEmpty(comment.time.start) || !_.isEmpty(comment.time.end)) { %>
		<a href="#" class="badge alert-default" title="Zeitraum" role="button" data-placement="left" data-toggle="popover" data-container="#showCommentsToGeodata"
		   data-content="Anfangsdatum: <%- comment.time.start ? comment.time.start : 'Keine Angabe' %>&lt;br /&gt;Enddatum: <%- comment.time.end ? comment.time.end : 'Keine Angabe' %>">
			<!-- TODO: Language -->
			<span class="glyphicon glyphicon-time"></span>
		</a>
		<% } %>
		<!-- TODO: Language -->
		<a href="#" class="badge alert-default" title="Permalink" role="button" data-placement="left" data-toggle="popover" data-container="#showCommentsToGeodata"
		   data-content="&lt;a href='<%- comment.permalink %>' target='_blank'&gt;<%- comment.permalink %>&lt;/a&gt;">
			<span class="glyphicon glyphicon-share-alt"></span>
		</a>
		<span class="badge alert-default" title="Bewertung: <%- comment.rating %> Sterne"><!-- TODO: Language -->
			<% for (i = 1; i <= 5; i++) {  %>
			<span class="glyphicon <%= (i <= comment.rating) ? 'glyphicon-star' : 'glyphicon-star-empty' %>"></span>
			<% } %>
		</span>
	</div>
</div>