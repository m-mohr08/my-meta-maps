<div class="modal fade bs-example-modal-lg" id="ModalShowCommentsToGeodata" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Kommentar erstellen</h4>
			</div>
						
			<div class="modal-body">
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="metadataHeader">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#showMetadataToGeodata" aria-expanded="true" aria-controls="showMetadataToGeodata">Zusätzliche Metadaten</a>
						</h4>
					</div>
					
					<ul id="showMetadataToGeodata" class="list-group collapse in" role="tabpanel" aria-labelledby="metadataHeader">
						
						<dl class="dl-horizontal metadata-list">
							<% if (!data.isNew) { %>
								<dt>Titel</dt>
								<dd><%= _.escape(data.metadata.title) %></dd>
							<% } %>
								<dt>Karte</dt>
								<dd><%= _.escape(data.metadata.bbox) %></dd>
							<% if (!_.isEmpty(data.metadata.language)) { %>
								<dt>Sprache</dt>
								<dd><%= _.escape(data.metadata.language) %></dd>
							<% } if (!_.isEmpty(data.metadata.abstract)) { %>
								<dt>Beschreibung</dt>
								<dd><pre><%= _.escape(data.metadata.abstract) %></pre></dd>
							<% } if (!_.isEmpty(data.metadata.keywords)) { %>
								<dt>Tags</dt>
								<dd>
									<% _.each(data.metadata.keywords, function(word) { %>
									<span class="label label-default"><%= _.escape(word) %></span>
									<% }); %>
								</dd>
							<% } if (!_.isEmpty(data.metadata.beginTime) || !_.isEmpty(data.metadata.endTime)) { %>
								<dt>Zeitraum</dt>
								<dd>
									Anfangsdatum: <%= data.metadata.beginTime ? _.escape(data.metadata.beginTime) : 'Unbekannt' %><br />
									Enddatum: <%= data.metadata.endTime ? _.escape(data.metadata.endTime) : 'Unbekannt' %>
								</dd>
							<% } if (!_.isEmpty(data.metadata.author)) { %>
								<dt>Autor</dt>
								<dd><pre><%= _.escape(data.metadata.author) %></pre></dd>
							<% } if (!_.isEmpty(data.metadata.copyright)) { %>
								<dt>Copyright</dt>
								<dd><pre><%= _.escape(data.metadata.copyright) %></pre></dd>
							<% } if (!_.isEmpty(data.metadata.license)) { %>
								<dt>Lizenz</dt>
								<dd><pre><%= _.escape(data.metadata.license) %></pre></dd>
							<% } %>
						</dl>
								
					</ul>
					
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="commentHeader">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#showCommentsToGeodata" aria-expanded="true" aria-controls="showCommentsToGeodata">Kommentare</a>
						</h4>
					</div>
					
					<ul id="showCommentsToGeodata" class="list-group collapse in" role="tabpanel" aria-labelledby="commentHeader">
					    
						<table class="table">
					    	<thead>
					        	<div class="col-md-8">
									<h5>Stern(e)</h5>
								</div>
								<div class="col-md-4">
									<h5>Username - Symbol</h5>
								</div>
					      	</thead>
					    </table>
					    
					    <textarea class="form-control" rows="3" style="margin-top: -20px; resize: none" readonly="">Dieser Geodatensatz sieht nicht schön aus und ist es auch nicht.  - Dies ist nicht vom Server</textarea>		
						
						<table class="table">
					    	<thead>
					        	<div class="col-md-8">
									<h5>Stern(e)</h5>
								</div>
								<div class="col-md-4">
									<h5>Username - Symbol</h5>
								</div>
					      	</thead>
					    </table>
					    
					    <textarea class="form-control" rows="3" style="margin-top: -20px; resize: none" readonly="">Ich finde diesen Geodatensatz ebenfalls schlecht. - Dies ist nicht vom Server</textarea>	
						
						<% _.each(data, function(row) { %>
							
							<table class="table">
						    	<thead>
						        	<div class="col-md-8">
										<h5><%= _.escape(row.rating) %></h5>
									</div>
									<div class="col-md-4">
										<h5> Username- Symbol </h5>
									</div>
						      	</thead>
						    </table>
					    
					   		<textarea class="form-control" rows="3" style="margin-top: -20px; resize: none" readonly=""><%= _.escape(row.text) %></textarea>	

						<% }); %>
						<% if (_.isEmpty(data)) { %>
							<span class="list-group-item">Es konnten keine Kommentare zu diesem Geodatensatz angezeigt werden.</span>
						<% } %>
								
					</ul>
					
				</div>
						
			</div>
					
		</div>
							
			</div>
				
		</div>
	</div>
</div>
