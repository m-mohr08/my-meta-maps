<div class="col-md-8 column hundred">
	<div id="map"></div>
</div>

<div class="col-md-4 column hundred" id="mapDataPanel">

	<div class="panel-group" role="tablist">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="filterHeader">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#filterArea" aria-expanded="true" aria-controls="filterArea">Filter einstellen</a>
				</h4>
			</div>
			<div id="filterArea" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterHeader">
				<div class="panel-body">

					<div class="form-group clearfix col-md-12 column">
						<div class="pull-right"><input type="checkbox" name="metadata" id="includeMetadata"> <label for="includeMetadata" class="label-metadata">Metadaten einbeziehen</label></div>
						<label class="label-filter">Suchbegriffe</label>
						<div class="input-group">
							<input type="text" class="form-control" id="SearchTerms" placeholder="Suchbegriff(e)">
							<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
						</div>
					</div>

					<div class="form-group clearfix">
						<div class="input-group col-md-12 column">
							<label class="label-filter">Wähle Start- und Endzeitpunkt</label>
						</div>
						<div class="input-group col-md-6 column">
							<span id="show-datepicker-start" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input class="form-control" type="text" id="filterStartTime" placeholder="Startzeitpunkt" datepicker data-trigger="#show-datepicker-start">
						</div>
						<div class="input-group col-md-6 column">
							<span id="show-datepicker-end" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input class="form-control" type="text" id="filterEndTime" placeholder="Endzeitpunkt" datepicker data-trigger="#show-datepicker-end">
						</div>
					</div>

					<div class="clearfix col-md-12 column">
						<label class="label-filter">Lege einen Umkreis fest</label>
						<div class="input select rating-underline">
							<select id="spatialFilter">
								<option value="" selected="selected"></option>
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option value="200">200</option>
								<option value="500">500</option>
							</select>
						</div>
					</div>

					<div class="form-group clearfix col-md-12 column">
						<label class="label-filter">Bewertung größer als ... ?</label>
						<div class="input select rating-stars">
							<select id="ratingFilter">
								<option value="" selected="selected"></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
					</div>

				</div>

				<!-- For barRating-plugin; loaded in header, otherwise it doesnt works -->
				<script type="text/javascript" src="/js/plugins/barRating/jquery.barrating.min.js"></script>

				<!-- For the datePicker-plugin -->
				<script type="text/javascript" src="/js/plugins/datePicker/datepicker.min.js"></script>
				<script type="text/javascript" src="/js/plugins/datePicker/datePicker-views.js"></script>

			</div>
		</div>
	</div>
	<div class="panel panel-default" style="margin-top: 5px;">
		<div class="panel-heading" role="tab" id="geodataHeader">
			<h4 class="panel-title">
				<a data-toggle="collapse" href="#geodataArea" aria-expanded="true" aria-controls="geodataArea">Geodatensätze</a>
			</h4>
		</div>
		<div id="geodataArea" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="geodataHeader">
			<div class="panel-body" id="showComments"></div>
		</div>
	</div>
</div>

<!-- For barRating-plugin; loaded in header, otherwise it doesnt works -->
<script type="text/javascript" src="/js/plugins/barRating/jquery.barrating.min.js"></script>

<!-- For the datePicker-plugin -->
<script type="text/javascript" src="/js/plugins/datePicker/datepicker.min.js"></script>
<script type="text/javascript" src="/js/plugins/datePicker/datePicker-views.js"></script>