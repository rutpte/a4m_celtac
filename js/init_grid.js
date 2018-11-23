Celtac_class.prototype.init_grid = function () {
	var celtac = this;
		//--------------------------------------------------------------------------
	celtac.rowclick_setvale = function(data_row){
		//console.debug(data_row);
		Ext.getCmp('id_data').setValue(data_row.id);
		Ext.getCmp('_no_data').setValue(data_row._no);
		Ext.getCmp('title_data').setValue(data_row.title);
		Ext.getCmp('name_data').setValue(data_row.name);
		Ext.getCmp('surname_data').setValue(data_row.surname);
		Ext.getCmp('address1_data').setValue(data_row.address1);
		Ext.getCmp('address2_data').setValue(data_row.address2);
		Ext.getCmp('region_data').setValue(data_row.region);
		Ext.getCmp('phone_data').setValue(data_row.phone);
		Ext.getCmp('mphone_data').setValue(data_row.mphone);
		Ext.getCmp('email_data').setValue(data_row.email);
		Ext.getCmp('amount_data').setValue(data_row.amount);
		Ext.getCmp('currency_data').setValue(data_row.currency);
		var reg_timesp = data_row.registration_date.split(" ");
		var registration_date = reg_timesp[0];
		
		var payment_timesp = data_row.payment_date.split(" ");
		var payment_date = payment_timesp[0];
		//debugger;
		Ext.getCmp('registration_date_data').setValue(registration_date);
		Ext.getCmp('payment_date_data').setValue(payment_date);
		Ext.getCmp('payment_by_data').setValue(data_row.payment_by);
		Ext.getCmp('payment_method_data').setValue(data_row.payment_method);
		Ext.getCmp('payment_process_data').setValue(data_row.payment_process);
		Ext.getCmp('status_data').setValue(data_row.status);
		Ext.getCmp('remark_data').setValue(data_row.remark);
	}
		//--------------------------------------------------------------------------
	extStore_grid = new Ext.data.JsonStore({
		root: "items",
		totalProperty: "total",
		idProperty: "id",
		remoteSort: true,
		fields: [
			{name: "id", type: "int"},
			//"temp_id",
			"_no",
			"title",
			"name",
			"surname",
			"address1",
			"address2",
			"region",
			"phone",
			"mphone",
			"email",
			"amount",
			"currency",
			"registration_date",
			"payment_date",
			"payment_by",
			"payment_method",
			"payment_process",
			"status",
			"remark"
		],

		baseParams : {
			q: "grid"
		},

		proxy: new Ext.data.ScriptTagProxy({
			url: "list.php"
		}),

		autoLoad : true,//the first to creat grid

		listeners: {
			load: function (store, record, options) {
			}
		}
	});
	extStore_grid.setDefaultSort("id", "asc");
	extStore_grid.load({params: {start: 0, limit: 20}});
//------------------------------------------------------------------------------
	grid_show_cus = new Ext.grid.GridPanel({
        store: extStore_grid,
        height: 850,
        //--loadMask: true,
        stripeRows: true,
        frame: true,
        // grid columns
        columns: [{
            header: "No",
            dataIndex: "_no",
            align: "right",
            width: 50,
            sortable: true
        }, {
            header: "Title",
            dataIndex: "title",
            align: "right",
            width: 100,
            sortable: true,
			hidden   : true
        }, {
            header: "Name",
            dataIndex: "name",
            align: "right",
            width: 100,
            sortable: true,
			//hidden   : true
        }, {
            header: "Surname",
            dataIndex: "surname",
            align: "right",
            width: "10%",
            sortable: true,
			//hidden   : true
        }, {
            header: "Address1",
            dataIndex: "address1",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Address2",
            dataIndex: "address2",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Region",
            dataIndex: "region",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Phone",
            dataIndex: "phone",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "E-mail",
            dataIndex: "email",
            align: "right",
            width: 100,
            sortable: true,
			//hidden   : true
        }, {
            header: "Amount",
            dataIndex: "amount",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Currency",
            dataIndex: "currency",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Registration_date",
            dataIndex: "registration_date",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Payment_date",
            dataIndex: "payment_date",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Payment_by",
            dataIndex: "payment_by",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Payment_method",
            dataIndex: "payment_method",
            align: "right",
            width: "10%",
            sortable: true,
			hidden   : true
        }, {
            header: "Payment_process",
            dataIndex: "payment_process",
            align: "right",
            width: "10%",
            sortable: true,
			//hidden   : true
        }, {
            header: "Status",
            dataIndex: "status",
            align: "right",
            width: 60,
            sortable: true,
			//hidden   : true
        }, {
            header: "Remark",
            dataIndex: "remark",
            align: "right",
            width: "10%",
            sortable: true,
			//hidden   : true
        }, {
            xtype: "actioncolumn",
            header: "ดำเนินการ",
            align: "center",
            width: 130,
            items: [
                {
                    icon: "images/png-icons/see-16X16.png", // Use a URL in the icon config
                    tooltip: "ดูข้อมูล",
                    style: "padding-left: 10px;",
                    handler: function(grid, rowIndex, colIndex) {
                        var rec = extStore_grid.getAt(rowIndex);//rec = The Record at the passed index(.getAt)
						
						//--> init form new
						celtac.init_form_customer();
					
						//--> show form
						celtac.win_upload.show();
						
						//-->fill data
						celtac.rowclick_setvale(rec.data);
						//alert("ดูข้อมูล");
                    }
                }, {
                    icon: "images/png-icons/user-edit-16x16.png", // Use a URL in the icon config
                    tooltip: "แก้ไขข้อมูล",
                    style: "padding-left: 10px;",
                    handler: function(grid, rowIndex, colIndex) {
                        var rec = extStore_grid.getAt(rowIndex);//rec = The Record at the passed index(.getAt)
						
						//--> init form new
						celtac.init_form_customer();
						
						//--> show form
						celtac.win_upload.show();
						
						//--> show button update
						celtac.formPanel.buttons[0].show();
						
						//-->fill data
						celtac.rowclick_setvale(rec.data);
                        //alert("แก้ไขข้อมูล");
                        
                    }
                }, {
                    icon: "images/png-icons/trash-16x16.png", // Use a URL in the icon config
                    tooltip: "ลบข้อมูล",
                    style: "padding-left: 10px;",
                    handler: function(grid, rowIndex, colIndex) {
                        var rec = extStore_grid.getAt(rowIndex);//rec = The Record at the passed index(.getAt)
								Ext.MessageBox.confirm(
                                    'confirm',
                                    'Are you sure to delete?',
                                    function (btn) {
                                        if (btn == "yes") {
                                            Ext.Ajax.request({
                                                url: "list.php",
                                                method : "GET",
                                                params : {
                                                    q: "delete",
													id: rec.data.id
                                                },
                                                success: function (obj) {
                                                    var data = Ext.util.JSON.decode(obj.responseText);

                                                    if (data.success) {
														
														//--> load grid with old data before
														celtac.reload_grid();
														
														//extStore_grid.load();
                                                    } else {
                                                        celtac.alert("เกิดข้อผิดพลาด", "ไม่สามารถลบได้]", "ERROR");
														//title, message, icon, callback
                                                    }
                                                },

                                                failure: function () {
                                                    celtac.alert(celtac.locale.um_error, "กรุณาเปิดโปรเจคก่อน ทำการจดบันทึก", "ERROR");
                                                }
                                            });
                                        }
                                    }
                                );
                    }
                }
            ]
        }],
        viewConfig: {
            stripeRows: true
        },
        tbar: [
			'<div class="toolbarLabelWidth">ค้นหา : </div>',
				new Ext.ux.form.SearchField({
					store: extStore_grid,
					listeners: {
					}
				})
			,{
				//--> add new customer
				xtype       : 'button',
				iconCls: 'icon-add',
				handler : function () {
					//--> init form new
					celtac.init_form_customer();
					
					//--> show form
					celtac.win_upload.show();
					
					//--> show button save
					celtac.formPanel.buttons[1].show();
					
					
				}
			}
			//,"<a download ='cc' href='http://127.0.0.1/celtac/download.php?source=export_excel/outputExcel/celtac/export_list_personal.xls'>xxx</a>"
			,{
				//--> download excel
				id			: 'force_download',
				xtype       : 'button',
				iconCls		: 'icon-excel',
				//tooltip		: 'dowlaod',
				//tooltip			: "http://127.0.0.1/celtac/download.php?_dc=1441035561242&source=export_excel%2FoutputExcel%2Fceltac%2Fexport_list_personal.xls",
				handler 	: function () { 
					//window.location = "http://127.0.0.1/celtac/download.php?source=export_excel/outputExcel/celtac/export_list_personal.xls";
					//--window.open('download.php', '_blank');
 								Ext.Ajax.request({
									url: "export_excel/export_excel.php",
									method : "GET",
									params : {
									},
									success: function (obj) {
										var data = Ext.util.JSON.decode(obj.responseText);
										
										if (data.success) {
											window.open('download.php', '_blank');
											/*Ext.Ajax.request({
												url: "download.php",
												method : "POST",
												// params : {
													// source : 'export_excel/outputExcel/celtac/export_list_personal.xls'
												// },
												success: function (obj) {
													//var data = Ext.util.JSON.decode(obj.responseText);
													//console.debug(data);
													if (data.success) {
														window.location = "download.php";
													} else {
														celtac.alert("เกิดข้อผิดพลาด", "can not export excel]", "ERROR");
														//title, message, icon, callback
													}
												},

												failure: function () {
													celtac.alert(celtac.locale.um_error, "กรุณาเปิดโปรเจคก่อน ทำการจดบันทึก", "ERROR");
												}
											});*/
										} else {
											celtac.alert("เกิดข้อผิดพลาด", "can not export excel]", "ERROR");
											//title, message, icon, callback
										}
									},

									failure: function () {
										celtac.alert(celtac.locale.um_error, "error", "ERROR");
									}
								});
				}
			}
        ],
        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: 30,
            store: extStore_grid,
            displayInfo: true,
            displayMsg: "items {0}-{1} of {2}",
            emptyMsg: "No items"
        }),
        listeners : {
            afterrender : function (comp) {
				//xxx
            },
            rowclick: function (grid, rowIndex, evt) {
                
            }
        }
    });
	//--> add button download excel
	//--var exportButton = new Ext.ux.Exporter.Button({
	  //--component: grid_show_cus//extStore_grid,grid_show_cus
	  //,iconCls: 'icon-add'
	  //,text     : "Download excle"
	//--});
	//--grid_show_cus.getTopToolbar().add(exportButton);
		//-----------------------------------------------------------------------------
//     var form_search = new Ext.form.FormPanel({
//         autoHeight: true,
//         labelWidth: 200,
//         monitorValid:true,
//         items:[
//         {
//         xtype: 'textfield',
//         fieldLabel: 'ค้นข้อมูล',
//         name:'search',
//         width:190,
//         allowBlank: true
//         },
//         {
//         xtype: 'datefield',
//         name: 'Dob',
//         fieldLabel: 'Date of Birth',
//         width:190}
//         ]
//     });
// 		tbar = new Ext.Toolbar();
// 
// 		tbar.addField("-");
// 		tbar.addField(
// 
// 		);

//---------------------------------------------------------------------------------------------------------

// [ panel ]--------------------------------------------------------------------
		adminSummary = new Ext.Panel({
			style: "margin-left: auto;margin-right: auto;",
			width: 800,
			frame: true,
			title: "search",
			renderTo: "view",
			bodyStyle: "padding:5px 5px 0",
			//tbar: tbar, //toolbar
			items : [
				grid_show_cus
			]
		});
}//end prototype