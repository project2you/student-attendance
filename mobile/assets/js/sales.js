var db;
var dataset;
var barcode;
var price;
var total;
var vat;
var reference_no;
var sales_prefix;
var run;

function initDatabase() {

    console.debug('called initDatabase()');
    try {
        if (!window.openDatabase) {
            alert('not supported');
        } else {
            var shortName = 'QR-CODE';
            var version = '1.0';
            var displayName = 'My Test Database Example';
            var maxSizeInBytes = 65536;
            db = openDatabase(shortName, version, displayName, maxSizeInBytes);
        }
    } catch(e) {
        if (e == 2) {
            alert('Invalid database version');
        } else {
            alert('Unknown error ' + e);
        }
        return;
    }
}

// Setting
function showRecords_settings() {
    console.debug('called showRecords_settings()');

    var sql = "SELECT * FROM Settings";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_settings, handleErrors_settings);
        }
    );
}

function renderRecords_settings(transaction, results) {
    console.debug('called renderRecords_settings()');

    dataset = results.rows;
	item = dataset.item(0);

	reference_no = item['sales_prefix'];
	sales_prefix = item['sales_prefix'];
	vat = item['sales_vat'];
}

function handleErrors_settings(transaction, error) {
    console.debug('called handleErrors()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}
// END SETTING


// Sales
function insertRecord_sales(reference_no, select_customer , inv_total , inv_vat , total ,  date_time , paid , select_status ){
  
	//alert(select_customer);
	//alert(inv_total);
	//alert(inv_vat);
	//alert(total);
	//alert(date_time);
	//alert(paid);
	//alert(select_status);
	//console.debug('called insertRecord_sales()');
	
    var sql = 'INSERT INTO Sales (reference_no , customer_id , date , inv_total , total_tax , total, paid_by , paid , status ) VALUES (?, ?, ?, ? , ?, ?, ?, ? , ?  )';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [reference_no, select_customer , date_time , inv_total , inv_vat , total , 'cash'  , paid , select_status  ], showRecordsAndResetForm_sales, handleErrors_sales);
            console.debug('executeSql: ' + sql);
        }
    );
}

function showRecordsAndResetForm_sales() {
    console.debug('called showRecordsAndResetForm_sales()');
}

// Sales Item
function insertRecord_salesItem(sale_id , product_code  , quantity  , unit_price  , total ){
  
    var sql = 'INSERT INTO Sales_Item (sale_id  , product_code  , quantity  , unit_price  , total  ) VALUES ( ? , ?, ?, ?, ?  )';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [ sale_id , product_code  , quantity  , unit_price  , total ], showRecordsAndResetForm_salesItem, handleErrors_sales);
            console.debug('executeSql: ' + sql);
        }
    );
}

function showRecordsAndResetForm_salesItem() {
    console.debug('called showRecordsAndResetForm_salesItem()');
}

function handleErrors_sales(transaction, error) {
    console.debug('called handleErrors_sales()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}
// END SALE

/// SALE SUB ITEM
function showRecords_sales_item() {
	
    console.debug('called showRecords_sales_item()');

    var sql = "SELECT * FROM Sales WHERE status <> 'Default' ORDER BY id DESC";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_salesItem, handleErrors_sales);
        }
    );
}

function renderRecords_salesItem(transaction, results) {
	
    console.debug('called renderRecords_salesItem()');

    html = '';
	var info = '';
    dataset = results.rows;

    if (dataset.length > 0) {
		 for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

                 html = html + '<tr class="even">';
                 html = html + '   <td>'+item['reference_no']+'</td>';
				  html = html + '	<td>'+item['date']+'</td>';
				  html = html + '	<td>'+item['total']+'</td>';
					
				
					switch(item['status']) {

					case '0':
					  info = '<span class="button submit small white-back rounded" onclick="viewData('+item['id']+')  " >กรุณาเลือกสถานะ</span>';
					  break;

					case '1':
					  info = '<span class="button submit small blue-back rounded" onclick="viewData('+item['id']+') "  >ชำระเงินครบแล้ว</span>';
					  break;
					case '2':
					  info = '<span class="button submit small green-back rounded" onclick="viewData('+item['id']+')  " >ชำระเงินบางส่วน</span>';
					  break;
					case '3':
					  info = '<span class="button submit small white-back rounded" onclick="viewData('+item['id']+')  " >อยู่ระหว่างดำเนินการ</span>';
					  break;
					case '4':
					  info = '<span class="button submit small orange-back rounded" onclick="viewData('+item['id']+')  " >จ่ายเงินเกินกำหนด</span>';
					  break;
					case '5':
					  info = '<span class="button submit small red-back rounded" onclick="viewData('+item['id']+') " >ยกเลิกการขายแล้ว</span>';
					  break;
					}

                   html = html + '  <td>'+info+'</td>';
                
                 html = html + '</tr>';
		 }
	}

	$('#saleList').append(html);
}

//END SALE SUB ITEM

//
function countRecords_sales() {
	
    console.debug('called countRecords_sales()');

    var sql = "SELECT * FROM Sales WHERE status <> '999' ORDER BY id DESC LIMIT 1";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_countSales, handleErrors_sales);
        }
    );
}

function renderRecords_countSales(transaction, results) {
	
    console.debug('called renderRecords_countSales()');

    html = '';
	
	dataset = results.rows;

	item = dataset.item(0);

    if ( dataset.length > 0  ) {
		run =  Number(item['id'])+1;
	}else{
		run =  1;
	}

	if (run < 9)
	{
		run = "000"+run
	}

	if (run >= 10)
	{
		run = "00"+run
	}

	if (run >= 100)
	{
		run = "0"+run
	}

}

function showRecords_customers() {
	
    console.debug('called showRecords_customers()');

    var sql = "SELECT * FROM Customers";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_customers, handleErrors_customers);
        }
    );
}

function handleErrors_customers(transaction, error) {
    console.debug('called handleErrors()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}

function renderRecords_customers(transaction, results) {
	
    console.debug('called renderRecords_customers()');

    html = '';

    dataset = results.rows;

    if (dataset.length > 0) {

        for (var i = 0, item = null; i < dataset.length; i++) {
            
			item = dataset.item(i);
			$("#select_customer").append('<option value=' + item['id'] + '>' + item['name'] + '</option>');
        }
    }
}

function barcodeScanner(item) {
    console.debug('called showRecords_sales()');

    var sql = "SELECT * FROM Products WHERE code="+item;
	barcode = item;

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderBarcode, handleErrors_barcode);
        }
    );
}

function renderBarcode(transaction, results) {
    console.debug('called renderBarcode()');
	
	var $itemsTable = $('#itemsTable');

    dataset = results.rows;

    if (dataset.length > 0) {
		
		item = dataset.item(0);

        // Create an Array to for the table row. ** Just to make things a bit easier to read.
        var rowTemp = [
            '<tr class="item-row">',
            '<td><i id="deleteRow" class="icon-remove" onclick="deleteRowNow(this);" ></i></td>',
            '<td><input type="text" name="itemCode[]" class="input-mini" value="'+item['code']+'" id="itemCode" /> </td>',
            '<td><input type="text" name="itemQty[]" class="input-mini" value="1" id="itemQty" /></td>',
            '<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemPrice[]" value="'+item['price']+'" class=" input-mini" id="itemPrice" type="text"></div></td>',
            '<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemLineTotal[]" value="'+item['price']+'" class=" input-mini" id="itemLineTotal" type="text" readonly="readonly"></div></td>',
            '</tr>'
        ].join('');

        var $row = $(rowTemp);

        // save reference to inputs within row
        var $itemCode = $row.find('#itemCode');
        //var $itemDesc = $row.find('#itemDesc');
        var $itemPrice = $row.find('#itemPrice');
        var $itemQty = $row.find('#itemQty');
		
		var cal_price = 0;

        if ($('#itemCode:last').val() != '') {

            // Add row after the first row in table
            $('.item-row:last', $itemsTable).after($row);
            $($itemCode).focus();

            // apply autocomplete method to newly created row
            $row.find('#itemCode').autocomplete({
                source: myJson,
                minLength:1,
                select:function (event, ui) {
                    $itemCode.val(ui.item.jItemCode);
                    //$itemDesc.val(ui.item.jItemDesc);
                    $itemPrice.val(ui.item.jItemPrice);
					//$itemQty.val(1);
                    // Give focus to the next input field to receive input from user
                    $itemQty.focus();
                    return false;
                }
            });

			var x = document.getElementsByTagName("INPUT");
			var y = [];
			var cnt2 = 0;
			for (var cnt = 0; cnt < x.length; cnt++) {
				if (x[cnt].name == "itemLineTotal[]") {
					cal_price = Number(cal_price) + Number(x[cnt].value);
				}
			}
			
			cal_vat =  Number(cal_price) * 7 / 100;

			var x=document.getElementById("labelTotal").innerHTML="<h5><p align='right'>Total</p></h5>";
			var x=document.getElementById("invGrandTotal").innerHTML="<h5>$ " + cal_price + "</h5>";

			var x=document.getElementById("labelVat").innerHTML="<h5><p align='right'>Vat "+ vat +" % </p></h5>";
			var x=document.getElementById("calVat").innerHTML="<h5>$ " + cal_vat + "</h5>";

			var x=document.getElementById("labelSummary").innerHTML="<h5><p align='right'>Summary</p></h5>";
			var x=document.getElementById("invGrandSummary").innerHTML="<h5>$ " + (Number(cal_price) + Number(cal_vat)) + "</h5>";


		}

    }else{
		alert('Not Found : ' + barcode);
	}
}

function deleteRowNow(el) {

  // while there are parents, keep going until reach TR 
  while (el.parentNode && el.tagName.toLowerCase() != 'tr') {
    el = el.parentNode;
  }

  // If el has a parentNode it must be a TR, so delete it
  // Don't delte if only 3 rows left in table
  if (el.parentNode && el.parentNode.rows.length > 3) {
    el.parentNode.removeChild(el);
  }
}

function update_total_barcode() {

}

function handleErrors_barcode(transaction, error) {
    console.debug('called handleErrors_barcode()');
    console.error('error ' + error.message);
    alert(error.message);
    return true;
}


function updateCacheContent(event) {
    console.debug('called updateCacheContent()');
    window.applicationCache.swapCache();
}

$(document).ready(function () {
    window.applicationCache.addEventListener('updateready', updateCacheContent, false);

    initDatabase();

	showRecords_settings();
	showRecords_customers();
	countRecords_sales();
	
});


///////// UPDATE SALES
function viewSaleUpdate(item) {
    console.debug('called viewSaleUpdate()');
	
    var sql = "SELECT * FROM Sales WHERE id="+item+" ORDER BY id DESC ";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderViewSaleUpdate, handleErrors_sales);
        }
    );
}


function renderViewSaleUpdate(transaction, results) {
	
    console.debug('called renderRecords_customers()');

    html = '';

    dataset = results.rows;

    if (dataset.length > 0) {
		
		item = dataset.item(0);
		
		//Sale_View
		$('#paid').val(item['paid']);
		$('#hide_select_customer').val(item['customer_id']);
		$('#hide_select_status').val(item['status']);
		$('#hid_reference_no').val(item['reference_no']);
		$('#select_status option[value=1]').attr('selected', 'selected');

		saleSubUpdate(item['reference_no']);
	}
}

function saleSubUpdate(item) {
    console.debug('called saleSubUpdate()');

    var sql = "SELECT * FROM Sales_Item WHERE sale_id='"+item+"'";
	
    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderSaleUpdate, handleErrors_sales);
        }
    );
}

function renderSaleUpdate(transaction, results) {
    console.debug('called renderSaleUpdate()');
	
	var $itemsTable = $('#itemsTable');

    dataset = results.rows;
	
    if (dataset.length > 0) {
		
		for (var i = 0, item = null; i < dataset.length; i++) {
		   item = dataset.item(i);

			// Create an Array to for the table row. ** Just to make things a bit easier to read.
			var rowTemp = [
				'<tr class="item-row">',
				'<td><i id="deleteRow" class="icon-remove" onclick="deleteRowNow(this);" ></i></td>',
				'<td><input type="text" name="itemCode[]" class="input-mini" value="'+item['product_code']+'" id="itemCode" /> </td>',
				'<td><input type="text" name="itemQty[]" class="input-mini" value="'+item['quantity']+'" id="itemQty" /></td>',
				'<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemPrice[]" value="'+item['unit_price']+'" class=" input-mini" id="itemPrice" type="text"></div></td>',
				'<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemLineTotal[]" value="'+item['total']+'" class=" input-mini" id="itemLineTotal" type="text" readonly="readonly"></div></td>',
				'</tr>'
			].join('');


			var $row = $(rowTemp);
			// save reference to inputs within row
			var $itemCode = $row.find('#itemCode');
			//var $itemDesc = $row.find('#itemDesc');
			var $itemPrice = $row.find('#itemPrice');
			var $itemQty = $row.find('#itemQty');

			// If the last row itemCode is empty then don't let the user continue adding a row
			if ($('#itemCode:last').val() != '') {

				// Add row after the first row in table
				$('.item-row:last', $itemsTable).after($row);
				$($itemCode).focus();


				// apply autocomplete method to newly created row
				$row.find('#itemCode').autocomplete({
					 source: myJson,
					minLength:1,
					select:function (event, ui) {
						$itemCode.val(ui.item.jItemCode);
						//$itemDesc.val(ui.item.jItemDesc);
						$itemPrice.val(ui.item.jItemPrice);
						//$itemQty.val(1);
						// Give focus to the next input field to receive input from user
						$itemQty.focus();
						return false;
					}
				});

				// Remove row when clicked
				$row.find("#deleteRow").on('click', function () {
					// Remove this row we clicked on
					$(this).parents('.item-row').remove();
					// Show alert we removed the row
					updateMessage('.alert', 'Item was removed!', 2000);
					// Hide delete Icon if we only have one row in the list.
					if ($(".item-row").length < 2) $("#deleteRow").hide();
					// Update total
					update_total();
				});
			

				// Update the invoice total on keyup when the user updates the item qty or price input
				// ** Note: This is for the newly created row
				$row.find("#itemQty, #itemPrice").on('focus', function () {
					// Locate the row we are working with
					var $itemRow = $(this).closest('tr');
					// Update the price.
					updatePrice($itemRow);
				});

			}else{
				  $('.alert').fadeIn('slow').html('You need to complete the item inputs');
			}
		}

    }else{
		alert('Not Found : ');
	}
}

	function deleteRecord_sales(id) {
   
		console.debug('called deleteRecord_sales()');
	
		var sql = "DELETE FROM Sales WHERE id=?";

		//var sql2 = "DELETE FROM Sales_Item";


		db.transaction(
			function (transaction) {
				transaction.executeSql(sql ,[id], redirect_sales_item, handleErrors_delsales);

				//transaction.executeSql(sql2 , redirect_sales_item, handleErrors_delsales);

				console.debug('executeSql: ' + sql);

				//console.debug('executeSql: ' + sql2);
				
				//alert('Delete Sucessfully');
			}
		);
}

	function deleteRecord_sales_item(reference_no) {
   
		console.debug('called deleteRecord_sales()');
	

		var sql2 = "DELETE FROM Sales_Item";


		db.transaction(
			function (transaction) {
			
				transaction.executeSql(sql2 , redirect_sales_item, handleErrors_delsales);

				console.debug('executeSql: ' + sql2);

				alert('Delete Sucessfully');
			}
		);
}

function redirect_sales_item(){

	window.location.href  = "sales_list.html";

}


function handleErrors_delsales(transaction, error) {
    console.debug('called handleErrors_delsales()');
    console.error('error ' + error.message);
    alert(error.message);
    return true;
}


function updateRecord_sales( customer_id , inv_total , total_tax , total , paid , status , id) {
    console.debug('called updateRecord_sales()');

    var sql1 = 'UPDATE Sales SET customer_id=? , inv_total=? , total_tax=? , total=? , paid=? , status=?  WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql1, [customer_id , inv_total , total_tax , total , paid , status , id], showRecords_sales_item, handleErrors_sales);
            console.debug('executeSql: ' + sql1);
        }
    );
}


function deleteRecord_sales_item(reference_no) {
    
	console.debug('called deleteRecord_products()');

    var sql = 'DELETE FROM Sales_Item WHERE sale_id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [reference_no], showRecords_sales_item, handleErrors_sales);
            console.debug('executeSql: ' + sql);
            //alert('Delete Sucessfully');
        }
    );
}

//////// END UPDATE SALES
