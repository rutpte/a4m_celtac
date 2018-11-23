Celtac_class.prototype.init_form_customer = function () {
	var celtac = this;
	
    var el_file_index = 0;

//#########################################################################################################################################
    //--> combo list_payment_method
    celtac.list_payment_method = {};
    celtac.list_payment_method = new Ext.form.ComboBox({
        id              : "payment_method_data",
		name			: "payment_method_data",
        width           : 90,
        //fieldLabel      : "list_payment_method",
        typeAhead       : true,
        triggerAction   : "all",
        emptyText       : "list_payment_method2",
        selectOnFocus   : true,
        forceSelection  : true,
        mode            : "local",
        autoSelect      : true,
        store           : new Ext.data.ArrayStore({
            fields : [
                "value",
                "label"
            ],
            data   : [
                [["on_site"], "On site"],
                [["bank_transfer"], "Bank transfer"],
				[["credit_card"], "Credit card"],
				[["cash"], "Cash"]
            ]
        }),
        valueField      : "value",
        displayField    : "label",
        value:'on_site',
        listeners : {
            change: function (combo, newVal) {
                console.debug(newVal[0]);
                if ( newVal[0] == 'xxx') {
                    //console.debug(newVal[0]);
                } else {
                    //console.debug(newVal[0]);
                }
                
            },
            focus: function (evt) {
            }
        }
    });
//#########################################################################################################################################
// form view and edit
    celtac.formPanel = {};
    celtac.formPanel = new Ext.FormPanel({
        fileUpload  : true,
        width       : 800,
        frame       : true,
        title       : "all detail customer",
        autoHeight  : true,
        //bodyStyle   : "padding: 10px 10px 20px 10px;",
        labelWidth  : 150,
        defaults    : {
            //anchor      : "95%",
			//width       : 100,
            //allowBlank  : true,
            msgTarget   : "side"
        },
        items       : [
			{
                id          : 'id_data',
                xtype       : 'textfield',
                fieldLabel  : 'ID',
				width       : 100,
				//maxLength	: 2,
                name        : 'id_data',
				hidden		: true
            },{
                id          : '_no_data',
                xtype       : 'textfield',
                fieldLabel  : 'NO',
				width       : 100,
				maxLength	: 100,
                name        : '_no_data'
            },{
                id          : 'title_data',
                xtype       : 'textfield',
                fieldLabel  : 'Title',
				width       : 200,
				maxLength	: 100,
                name        : 'title_data'
            },{
                id          : 'name_data',
                xtype       : 'textfield',
                fieldLabel  : 'Name',
				width       : 200,
				maxLength	: 50,
                name        : 'name_data'
            },{
                id          : 'surname_data',
                xtype       : 'textfield',
                fieldLabel  : 'Surname',
				width       : 200,
				maxLength	: 50,
                name        : 'surname_data'
            },{
                id          : 'address1_data',
                xtype       : 'textarea',
                fieldLabel  : 'Address1',
				width       : 200,
				maxLength	: 300,
                name        : 'address1_data'
            },{
                id          : 'address2_data',
                xtype       : 'textarea',
                fieldLabel  : 'Address2',
				width       : 200,
				maxLength	: 300,
                name        : 'address2_data'
            },{
                id          : 'region_data',
                xtype       : 'textfield',
                fieldLabel  : 'Region',
				width       : 200,
				maxLength	: 50,
                name        : 'region_data'
            },{
                id          : 'phone_data',
                xtype       : 'textfield',
                fieldLabel  : 'Phone',
				width       : 200,
				maxLength	: 20,
                name        : 'phone_data'
            },{
                id          : 'mphone_data',
                xtype       : 'textfield',
                fieldLabel  : 'Mphone',
				width       : 200,
				maxLength	: 50,
                name        : 'mphone_data'
            },{
                id          : 'email_data',
                xtype       : 'textfield',
                fieldLabel  : 'E-mail',
				width       : 200,
				maxLength	: 50,
                name        : 'email_data'
            },{
                id          : 'amount_data',
                xtype       : 'numberfield',
                fieldLabel  : 'Amount',
				width       : 200,
				maxLength	: 10,
                name        : 'amount_data'
            },{
                id          : 'currency_data',
                xtype       : 'textfield',
                fieldLabel  : 'Currency',
				width       : 200,
				maxLength	: 20,
                name        : 'currency_data'
            },{
                id          : 'registration_date_data',
                xtype       : 'datefield',
				value		: new Date(),
				format		: 'd/m/Y',
                fieldLabel  : 'Registration_date*',
				width       : 200,
				//maxLength	: 2,
                name        : 'registration_date_data'
            },{
                id          : 'payment_date_data',
                xtype       : 'datefield',
				value		: new Date(),
				format		: 'd/m/Y',
                fieldLabel  : 'Due_date*',
				width       : 200,
				//maxLength	: 2,
                name        : 'payment_date_data'
            },{
                id          : 'payment_by_data',
                xtype       : 'textfield',
                fieldLabel  : 'Payment_by',
				width       : 200,
				//maxLength	: 2,
                name        : 'payment_by_data'
            },{
                id          : 'remark_data',
                xtype       : 'textfield',
                fieldLabel  : 'Remark',
				width       : 200,
				maxLength	: 20,
                name        : 'remark_data'
            },{
                xtype: "fieldset",
                autoHeight: true,
                title: "Payment process",
                layout: "column", 
                items: [
                    {
                        xtype: 'container',
                        autoEl:{},
                        //columnWidth: 0.5,
                        layout: 'form',
                        items: [{
							xtype       : "radiogroup",
							//fieldLabel  : "payment_process",
							columns     : [160, 180],
							vertical    : true,
							id          : "payment_process_data",
							items       : [
								{ boxLabel : "Paid", 			name: "payment_process_data", inputValue: "paid", checked: true },
								{ boxLabel : "Under process", 	name: "payment_process_data", inputValue: "under_process" }
							]
                        }]
                    }
                ]
            },{
                xtype: "fieldset",
                autoHeight: true,
                title: "Payment method",
                layout: "column", 
                items: [
                    {
                        xtype: 'container',
                        autoEl:{},
                        //columnWidth: 0.5,
                        layout: 'form',
                        items: [
							celtac.list_payment_method
                        ]
                    }
                ]
            },{
                xtype: "fieldset",
                autoHeight: true,
                title: "Status",
                layout: "column", 
                items: [
                    {
                        xtype: 'container',
                        autoEl:{},
                        //columnWidth: 0.5,
                        layout: 'form',
                        items: [{
							xtype       : "radiogroup",
							columns     : [160, 180],
							vertical    : true,
							id          : "status_data",
							items       : [
								{ boxLabel : "Active", 		name: "status_data", inputValue: "true", checked: true },
								{ boxLabel : "Unactive", 	name: "status_data", inputValue: "false" }
							]
                        }]
                    }
                ]
            }
        ]
        ,buttons: [
			{
				//--> update follow id
				text    : "update",
				hidden	: true,
				handler : function () {
					var form = celtac.formPanel.getForm();
					if (form.isValid()) {
						//debugger;

						form.submit({
							url     : "list.php",
							params  : {
								q : "update"
							},
							waitMsg : 'WaitMsg',//celtac.locale.uploadWaitMsg,
							success : function(form, action){
								var res = JSON.parse(action.response.responseText);
									if (res.success) {
										celtac.alert('update','complete','INFO');
										
										//--> load grid with old data before
										celtac.reload_grid();
										
										//celtac.win_upload.destroy();
									} else {
										celtac.alert('update','can not complete','ERROR');
									}
							},
							failure: function(form, action){
								if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
									celtac.alert('error', "Status:"+action.response.status+": "+action.response.statusText, "ERROR");//celtac.locale.error
								}
								if (action.failureType === Ext.form.Action.SERVER_INVALID){
									// server responded with success = false
									if (!Ext.isIE) {
										console.debug(["Invalid", action.result, "error"]);
										celtac.alert('error', "Status: don't success: ", "ERROR");//celtac.locale.error
									}
								}
							}
						});
					}
					
				}
			},{
				text    : "save",
				hidden	: true,
				handler : function () {
					var form = celtac.formPanel.getForm();
					if (form.isValid()) {
						//debugger;

						//------------------------------------------------------------------------- > end validate field

						form.submit({
							url     : "list.php",
							params  : {
								q : "insert"
							},
							waitMsg : 'WaitMsg',//celtac.locale.uploadWaitMsg,
							success : function(form, action){
								var res = JSON.parse(action.response.responseText);
									if (res.success) {
										celtac.alert('update','complete','INFO');
										extStore_grid.load();
										celtac.win_upload.destroy();
									} else {
										celtac.alert('update','can not complete','ERROR');
									}
							},
							failure: function(form, action){
								if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
									celtac.alert('error', "Status:"+action.response.status+": "+action.response.statusText, "ERROR");//celtac.locale.error
								}
								if (action.failureType === Ext.form.Action.SERVER_INVALID){
									// server responded with success = false
									if (!Ext.isIE) {
										console.debug(["Invalid", action.result, "error"]);
										celtac.alert('error', "Status: don't success: ", "ERROR");//celtac.locale.error
									}
								}
							}
						});
					}
				}
			}
		],
		listeners: {
            afterrender: function (store, record, options) {
				//set date picker
				// $('#payment_date_data').datepicker({
					// beforeShow: function(){
						// $('.ui-datepicker').css('z-index',9999999999999999999)
					// }
				// });
				// $('#payment_by_data').datepicker({
					// beforeShow: function(){
						// $('.ui-datepicker').css('z-index',9999999999999999999)
					// }
				// });
            }
        }
    
        
    });
//---------------------------------------------------------------------------------------------------
	//--------------------------------------------
	celtac.reload_grid = function(){
		var last_params_page 	= extStore_grid.lastOptions.params;//Object {start: 120, limit: 30}
		var start_row 	= 0;
		var end_row		= 'null';
		if(typeof(last_params_page) !== "undefined"){
			if(typeof(last_params_page.start) !== "undefined"){
				start_row 	= last_params_page.start;
			}else{
				start_row 	= 'null';
			}
			//---
			if(typeof(last_params_page.limit) !== "undefined"){
				end_row 	= last_params_page.limit;
			}else{
				end_row 	= 'null';
			}
		}
		//console.debug(last_params_page);
		//--------------------------------------------
		//--------------------------------------------
		var last_params_q		= extStore_grid.baseParams; //Object {q: "grid", query: "ss"}
		var q 			= 0;
		var query		= '';
		if(typeof(last_params_q) !== "undefined"){
			if(typeof(last_params_q.q) !== "undefined"){
				q 	= last_params_q.q;
			}else{
				q 	= 'null';
			}
			//---
			if(typeof(last_params_q.query) !== "undefined"){
				query 	= last_params_q.query;
			}else{
				query 	= '';
			}
		}
		//--------------------------------------------
		extStore_grid.load({params: {
			start: start_row, 
			limit: end_row,
			query: query
		}});
	}

//---------------------------------------------------------------------------------------------------
//--> destroy if type is object or not undefined
    if (typeof celtac.win_upload =="object"){
        celtac.win_upload.destroy();
    }
    
    celtac.win_upload = new Ext.Window({
        id          : "fileUploadWin",
		y			: 50,                //--> set position
		title		: '',
        border      : false,
        modal       : true,
        layout      : "fit",
        width       : 400,
        //autoHeight  : true,
        closeAction : "hide",
        //plain       : true,
		closable	: true,			
        items       : [celtac.formPanel]
		//celtac.win_upload.setPosition(500,100)
    });
};
