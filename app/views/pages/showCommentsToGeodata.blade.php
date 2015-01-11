<div class="modal fade" id="ModalShowCommentsToGeodata" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Kommentar erstellen</h4>
			</div>
						
			<div class="modal-body">
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="commentHeader">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#showCommentsToGeodata" aria-expanded="true" aria-controls="showCommentsToGeodata">Kommentare</a>
						</h4>
					</div>
					
					<ul id="showCommentsToGeodata" class="list-group collapse in" role="tabpanel" aria-labelledby="commentHeader">
						
						<% _.each(data, function(row) { %>
							<li class="list-group-item"><%= _.escape(row.text) %></li>
						<% }); %>
								
					</ul>
					
				</div>
						
			</div>
					
		</div>
							
			</div>
				
		</div>
	</div>
</div>
