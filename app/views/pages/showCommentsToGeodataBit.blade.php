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
		<span class="badge alert-default map-Marker" title="@lang('misc.geoData')">
			<span class="glyphicon glyphicon-map-marker"></span>
		</span>
		<% } if (!_.isEmpty(comment.time.start) || !_.isEmpty(comment.time.end)) { %>
		<a href="#" class="badge alert-default" title="@lang('misc.timerange')" role="button" data-placement="left" data-toggle="popover" data-container="#showCommentsToGeodata"
		   data-content="@lang('misc.startingDate') <%- comment.time.start ? comment.time.start : '@lang('misc.notSpec')' %>&lt;br /&gt;@lang('misc.endingDate') <%- comment.time.end ? comment.time.end : '@lang('misc.notSpec')' %>">		
			<span class="glyphicon glyphicon-time"></span>
		</a>
		<% } %>
		<a href="#" class="badge alert-default" title="@lang('misc.permlink')" role="button" data-placement="left" data-toggle="popover" data-container="#showCommentsToGeodata"
		   data-content="&lt;a href='<%- comment.permalink %>' target='_blank'&gt;<%- comment.permalink %>&lt;/a&gt;">
			<span class="glyphicon glyphicon-share-alt"></span>
		</a>
		<span class="badge alert-default" title="@lang('misc.rate') <%- comment.rating %> @lang('misc.stars')">
			<% for (i = 1; i <= 5; i++) {  %>
			<span class="glyphicon <%= (i <= comment.rating) ? 'glyphicon-star' : 'glyphicon-star-empty' %>"></span>
			<% } %>
		</span>
	</div>
</div>