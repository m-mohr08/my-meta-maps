@if(Auth::user()->oauth)
<div class="row form-group form-group-marginSides alert alert-info">
	<strong>Hinweis:</strong> Sie haben sich über einen externen Anbieter authentifiziert. In diesem Zuge haben wir Ihnnen einen My Meta Maps-Account eingerichtet, dessen Daten Sie hier ändern können. Ihre Daten beim externen Anbieter bleiben unberührt!
</div>
@endif