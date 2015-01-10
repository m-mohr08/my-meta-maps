/**
 * This is a basic Backbone.Model which tries to avoid multiple server requests with the same data (flooding)
 */
BaseModel = Backbone.Model.extend({
	time: function() {
		return Math.floor(Date.now() / 1000);
	},
	isSameRequest: function(data) {
		var request = JSON.stringify(data.request);
		// If not old request available or last request is expired or request data is different => Allow new request
		if (BaseModel.last === null || BaseModel.last.expire < this.time() || JSON.stringify(BaseModel.last.request) !== request) {
			BaseModel.last = data;
			return false;
		}
		else {
			Debug.log('Anti-flooding for Backbone.Model in effect. Skipping request: ' + request);
			return true;
		}
	},
	serializeRequest: function(method, params) {
		return {
			expire: this.time() + 15, // Expire in 15 seconds
			request: {
				method: method,
				url: this.url(),
				params: params
			}
		};
	},
	fetch: function(options) {
		var data = this.serializeRequest('fetch', options);
		if (!this.isSameRequest(data)) {
			return Backbone.Model.prototype.fetch.call(this, options);
		}
		else {
			return null;
		}
	},
	save: function(key, val, options) {
		var data = this.serializeRequest('save', {key: key, val: val, options: options});
		if (!this.isSameRequest(data)) {
			return Backbone.Model.prototype.save.call(this, key, val, options);
		}
		else {
			return null;
		}
	}
});
// Statics
BaseModel.last = null;