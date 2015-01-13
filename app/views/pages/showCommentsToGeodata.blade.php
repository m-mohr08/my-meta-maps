<div class="modal fade bs-example-modal-lg" id="ModalShowCommentsToGeodata" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel"><%- data.metadata.title %></h4>
			</div>

			<div class="modal-body row"><!-- Model Body Start -->

				<div class="col-md-6"><!-- Left Column Start -->
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="commentHeader">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#showCommentsToGeodata" aria-expanded="true" aria-controls="showCommentsToGeodata">Kommentare</a>
							</h4>
						</div>

						<div id="showCommentsToGeodata" class="panel-body collapse in" role="tabpanel" aria-labelledby="commentHeader">

							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="General_Header">
									<h4 class="panel-title">
										<a data-toggle="collapse" href="#General_Body" aria-expanded="true" aria-controls="General_Body">
											Allgemeine Kommentare
										</a>
										<span class="badge pull-right"><%= data.comments.length %></span>
									</h4>
								</div>
								<div class="panel-body list-group collapse in" id="General_Body" role="tabpanel" aria-labelledby="General_Header">
									<% _.each(data.comments, function(comment) { %>
									@include('pages.showCommentsToGeodataBit')
									<% }); if (_.isEmpty(data.comments)) { %>
									<span class="list-group-item">Es liegen leider keine allgemeinen Kommentare vor.</span>
									<% } %>
								</div>
							</div>

							<% _.each(data.layer, function(layer, key) { %>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="Layer<%= key %>Header">
									<h4 class="panel-title">
										<a data-toggle="collapse" href="#Layer<%= key %>Body" aria-expanded="true" aria-controls="Layer<%= key %>Body">
											Layer: <%- ViewUtils.join(' - ', [layer.title, layer.id]) %>
										</a>
										<span class="badge pull-right"><%= layer.comments.length %></span>
									</h4>
								</div>
								<div class="panel-body list-group collapse" id="Layer<%= key %>Body" role="tabpanel" aria-labelledby="Layer<%= key %>Header">
									<% _.each(layer.comments, function(comment) { %>
									@include('pages.showCommentsToGeodataBit')
									<% }); if (_.isEmpty(layer.comments)) { %>
									<span class="list-group-item">Zu diesem Layer liegen noch keine Kommentare vor.</span>
									<% } %>
								</div>
							</div>
							<% }); %>

						</div>

					</div>
				</div> <!-- Left Column End -->

				<div class="col-md-6"><!-- Right Column Start -->
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="dataHeader">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#showDataToGeodata" aria-expanded="true" aria-controls="showDataToGeodata">Allgemeine Daten</a>
							</h4>
						</div>
						<dl class="panel-body dl-horizontal metadata-list collapse in" id="showDataToGeodata" role="tabpanel" aria-labelledby="dataHeader">
							<dt>Adresse</dt>
							<dd><a href="<%- data.url %>" target="_blank"><%- data.url %></a></dd>
							<dt>Datenformat</dt>
							<dd><%- config.datatypes[data.metadata.datatype] %></dd>
							<dt>Σ Kommentare</dt>
							<dd><%- data.commentCount.filtered %> (<%- data.commentCount.all %> gesamt)</dd>
							<dt>Ø Bewertung</dt>
							<dd><%- data.ratingAvg.filtered %> (<%- data.ratingAvg.all %> gesamt)</dd>
							<dt>Permalink</dt>
							<dd><a href="<%- data.permalink %>" target="_blank"><%- data.permalink %></a></dd>
						</dl>
					</div>
					
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="mapHeader">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#showMapToGeodata" aria-expanded="true" aria-controls="showMapToGeodata">Karte</a>
							</h4>
						</div>
						<div class="panel-body collapse in" id="showMapToGeodata" role="tabpanel" aria-labelledby="mapHeader">
							Es folgt eine Karte...
						</div>
					</div>

					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="metadataHeader">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#showMetadataToGeodata" aria-expanded="true" aria-controls="showMetadataToGeodata">Metadaten</a>
							</h4>
						</div>
						<dl class="panel-body dl-horizontal metadata-list collapse in" id="showMetadataToGeodata" role="tabpanel" aria-labelledby="metadataHeader">
							<%  if (!_.isEmpty(data.metadata.abstract)) { %>
							<dt>Beschreibung</dt>
							<dd><pre><%- data.metadata.abstract %></pre></dd>
							<% } if (!_.isEmpty(data.metadata.keywords)) { %>
							<dt>Tags</dt>
							<dd>
								<% _.each(data.metadata.keywords, function(word) { %>
								<span class="label label-default"><%- word %></span>
								<% }); %>
							</dd>
							<% } if (!_.isEmpty(data.metadata.language)) { %>
							<dt>Sprache</dt>
							<dd><%- data.metadata.language %></dd>
							<% } if (!_.isEmpty(data.metadata.beginTime) || !_.isEmpty(data.metadata.endTime)) { %>
							<dt>Zeitraum</dt>
							<dd>
								Anfangsdatum: <%- data.metadata.beginTime ? data.metadata.beginTime : 'Unbekannt' %><br />
								Enddatum: <%- data.metadata.endTime ? data.metadata.endTime : 'Unbekannt' %>
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
				</div><!-- Right Column End -->

			</div><!-- Model Body End -->
		</div>
	</div>
