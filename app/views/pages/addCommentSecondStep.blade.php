<h1>@lang('misc.createComm')</h1>
											
<form id="form-comment-secondStep" class="column col-md-5" onsubmit="return false">
	<h2 class="row">@lang('misc.enterData')</h2>

	<div class="row form-group">
		<label for="url">URL*</label>
		<input class="form-control" name="url" id="inputURL" type="text" readonly="readonly" value="<%- (data.url) %>">
		<div class="error-message"></div>
	</div>

	<div class="row form-group">
		<label for="datatype">@lang('misc.dataFormat')</label>
		<input class="form-control" name="datatype" type="text" readonly="readonly" value="<%- config.datatypes[data.metadata.datatype] %>">
		<input type="hidden" id="inputDataType" value="<%- data.metadata.datatype %>">
		<div class="error-message"></div>
	</div>

	<% if (!_.isEmpty(data.layer)) { %>
	<div class="row form-group">
		<label for="title">Layer</label>
		<select class="form-control" name="layer" id="inputLayer">
			<option value="">@lang('misc.commNoLay')</option>
			<% _.each(data.layer, function(l) { %>
			<option value="<%- l.id %>"><%- ViewUtils.join(' - ', [l.title, l.id]) %></option>
			<% }); %>
		</select>
		<div class="error-message"></div>
	</div>
	<% } %>

	<% if (data.isNew) { %>
	<div class="row form-group">
		<label for="title">@lang('misc.title')</label>
		<input class="form-control" name="title" id="inputTitle" type="text" value="<%- data.metadata.title %>">
		<div class="error-message"></div>
	</div>
	<% } %>

	<div class="row form-group">
		<label for="text">@lang('misc.freetext')</label>
		<textarea class="form-control" rows="6" name="text" id="inputText"></textarea>
		<div class="error-message"></div>
	</div>

	<div class="row form-group">
		<label for="startDate">@lang('misc.timerange')</label>
			<div class="input-group">
				<span id="show-datepicker-startComment" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				<input class="form-control" name="start" id="inputStartDate" type="text"placeholder="Startzeitpunkt ({{ Config::get('view.datepicker.placeholder') }})" datepicker data-date-format="{{ Config::get('view.datepicker.format') }}" data-trigger="#show-datepicker-startComment">
			</div>
			<span class="error-message"></span>
	</div>

	<div class="row form-group">
		<div class="input-group">
			<span id="show-datepicker-endComment" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			<input class="form-control" name="end" id="inputEndDate" type="text"placeholder="Endzeitpunkt ({{ Config::get('view.datepicker.placeholder') }})" datepicker data-date-format="{{ Config::get('view.datepicker.format') }}" data-trigger="#show-datepicker-endComment">
		</div>
		<div class="error-message"></div>
	</div>

	<div class="row form-group">
		<div class="input select rating-stars">
			<label for="ratingComment">@lang('misc.rating')</label>
			<select id="ratingComment" name="rating">
				<option value="" selected="selected"></option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="error-message"></div>
	</div>

	<div class="row form-group text-right">
		<button type="submit" class="btn btn-primary" id="addCommentSecondBtn">@lang('misc.create')</button>
	</div>

</form>
<div id="form-comment-metadata" class="column col-md-7">
	<h2 class="row">@lang('misc.addMeta')</h2>

	<dl class="dl-horizontal metadata-list">
	<% if (!data.isNew) { %>
		<dt>Titel</dt>
		<dd><%- data.metadata.title %></dd>
	<% } %>
		<dt>Karte</dt>
		<dd><%- data.metadata.bbox %></dd>
	<% if (!_.isEmpty(data.metadata.language)) { %>
		<dt>Sprache</dt>
		<dd><%- data.metadata.language %></dd>
	<% } if (!_.isEmpty(data.metadata.abstract)) { %>
		<dt>Beschreibung</dt>
		<dd><pre><%- data.metadata.abstract %></pre></dd>
	<% } if (!_.isEmpty(data.metadata.keywords)) { %>
		<dt>Tags</dt>
		<dd>
			<% _.each(data.metadata.keywords, function(word) { %>
			<span class="label label-default"><%- word %></span>
			<% }); %>
		</dd>
	<% } if (!_.isEmpty(data.metadata.time.start) || !_.isEmpty(data.metadata.time.end)) { %>
		<dt>Zeitraum</dt>
		<dd>
			Anfangsdatum: <%- data.metadata.time.start ? data.metadata.time.start : 'Unbekannt' %><br />
			Enddatum: <%- data.metadata.time.end ? data.metadata.time.end : 'Unbekannt' %>
		</dd>
	<% } if (!_.isEmpty(data.metadata.author)) { %>
		<dt>Autor</dt>
		<dd><pre><%- data.metadata.author %></pre></dd>
	<% } if (!_.isEmpty(data.metadata.copyright)) { %>
		<dt>Copyright</dt>
		<dd><pre><%- data.metadata.copyright %></pre></dd>
	<% } if (!_.isEmpty(data.metadata.license)) { %>
		<dt>Lizenz</dt>
		<dd><pre><%- data.metadata.license %></pre></dd>
	<% } %>
	</dl>

</div>
			
 <!-- For barRating-plugin; loaded in header, otherwise it doesnt works -->
 <script type="text/javascript" src="/js/plugins/barRating/jquery.barrating.min.js"></script>
		
<!-- For the datePicker-plugin -->
<script type="text/javascript" src="/js/plugins/datePicker/datepicker.min.js"></script>
