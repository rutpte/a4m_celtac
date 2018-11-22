var Celtac_class = function () {
	var celtac = this;
	celtac.alert = function (title, message, icon, callback) {
		Ext.Msg.show({
			title: title,
			msg: message,
			minWidth: 200,
			modal: true,
			icon: Ext.Msg[icon],
			buttons: Ext.Msg.OK
			,fn: callback
		});
	}
	
	celtac.init_grid();
	celtac.init_form_customer();
}