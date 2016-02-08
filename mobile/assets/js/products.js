var db;
var dataset;

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

            createTableIfNotExists();
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

function createTableIfNotExists() {
    console.debug('called createTableIfNotExists()');

	var sql1 = "CREATE TABLE IF NOT EXISTS Products (id INTEGER PRIMARY KEY AUTOINCREMENT,  code TEXT , name TEXT , unit TEXT , size TEXT , cost TEXT , price TEXT , category_id TEXT , quantity TEXT )";

	var sql2 = "CREATE TABLE IF NOT EXISTS Sales (id INTEGER PRIMARY KEY AUTOINCREMENT,  reference_no TEXT , customer_id TEXT , date DATE , inv_total TEXT , total_tax TEXT , total TEXT, paid_by TEXT , paid TEXT , status TEXT)";

	var sql3 = "CREATE TABLE IF NOT EXISTS Sales_Item (id INTEGER PRIMARY KEY AUTOINCREMENT, sale_id TEXT , product_code TEXT , quantity TEXT , unit_price TEXT , total TEXT )";

    var sql4 = "DELETE FROM Sales";

    var sql4 = "INSERT INTO Sales (status ) SELECT * FROM (SELECT 'Default') AS tmp WHERE NOT EXISTS ( SELECT status FROM Sales WHERE status = 'Default' ) LIMIT 1;";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql1, [], showRecords_products, handleErrors_products);
            transaction.executeSql(sql2, [], showRecords_products, handleErrors_products);
			transaction.executeSql(sql3, [], showRecords_products, handleErrors_products);
			transaction.executeSql(sql4, [], showRecords_products, handleErrors_products);

			console.debug('executeSql: ' + sql1);
        }
    );
}

function updateCacheContent(event) {
    console.debug('called updateCacheContent()');
    window.applicationCache.swapCache();
}

$(document).ready(function () {
    window.applicationCache.addEventListener('updateready', updateCacheContent, false);

    initDatabase();
    cancelAction_products();
});


// Products
function insertRecord_products() {
    console.debug('called insertRecord_products()');

	var code = $('#code').val();
    var name = $('#name').val();
	var unit = $('#unit').val();
	var size = $('#size').val();
	var cost = $('#cost').val();
	var price = $('#price').val();
	var category_id= $('#category_id').val();
	var quantity = $('#quantity').val();

    var sql = 'INSERT INTO products (code , name , unit , size , cost , price , category_id , quantity) VALUES (?, ?, ?, ? , ?, ?, ?, ? )';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [code , name , unit , size , cost , price , category_id , quantity], showRecordsAndResetForm_products, handleErrors_products);
            console.debug('executeSql: ' + sql);
        }
    );
}

function deleteRecord_products(id) {
    console.debug('called deleteRecord_products()');

    var sql = 'DELETE FROM products WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [id], showRecords_products, handleErrors_products);
            console.debug('executeSql: ' + sql);
            alert('Delete Sucessfully');
        }
    );

    resetForm_products();
}

function updateRecord_products() {
    console.debug('called updateRecord()');

	var code = $('#code').val();
    var name = $('#name').val();
	var unit = $('#unit').val();
	var size = $('#size').val();
	var cost = $('#cost').val();
	var price = $('#price').val();
	var category_id= $('#category_id').val();
	var quantity = $('#quantity').val();
    var id = $("#id").val();

    var sql = 'UPDATE products SET code=?, name=?, unit=? , size=? , cost=? , price=? , category_id=? , quantity=?  WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [code , name , unit , size , cost , price , category_id , quantity , id], showRecordsAndResetForm_products, handleErrors_products);
            console.debug('executeSql: ' + sql);
        }
    );
}

function dropTable_products() {
    console.debug('called dropTable_products()');

    var sql = 'DROP TABLE products';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], showRecords_products, handleErrors_products);
        }
    );

    resetForm_products();

    initDatabase();
}

function resetForm_products() {
    console.debug('called resetForm_products()');

    $('#code').val('');
    $('#name').val('');
    $('#unit').val('');
    $('#size').val('');
    $('#cost').val('');
    $('#price').val('');
    $('#category_id').val('');
    $('#quantity').val('');
}

function showRecordsAndResetForm_products() {
    console.debug('called showRecordsAndResetForm_products()');

    resetForm_products();
    showRecords_products()
}

function handleErrors_products(transaction, error) {
    console.debug('called handleErrors_products()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}

function showRecords_products() {
    console.debug('called showRecords_products()');

    var sql = "SELECT * FROM products";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_products, handleErrors_products);
        }
    );
}

function renderRecords_products(transaction, results) {
    console.debug('called renderRecords_products()');

    html = '';
    $('#results').html('');

    dataset = results.rows;

    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

            html = html + '    <li>';
            html = html + '      <h4>รหัสสินค้า :' + item['code'] + '</h4>';
            html = html + '      <p>ชื่อสินค้า : ' + item['name'] + '</p>';
            html = html + '      <p>ราคา : ' + item['price']  + '</p>';
            html = html + '      <p>';
            html = html + '        <button type="button" data-icon="arrow-u" onClick="prepareEdit_products(' + i + ');">แก้ไขข้อมูล</button>';
            html = html + '        <button type"button" data-icon="delete" onClick="deleteRecord_products(' + item['id'] + ');">ลบข้อมูล</button>';
            html = html + '      </p>';
            html = html + '    </li>';
        }

        html = html + '  </ul>';

        $('#results').append(html);
        //$('#results ul').listview();
    }
}

function prepareAdd_products() {
  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ insertRecord_products() });
  $('#btnSave').on('click', function(){ cancelAction_products() });
  $('#code').focus();
}

function prepareEdit_products(i) {
  loadRecord_products(i)

  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ updateRecord_products() });
  $('#btnSave').on('click', function(){ cancelAction_products() });
  $('#code').focus();
}

function loadRecord_products(i) {
    console.debug('called loadRecord_products()');

    var item = dataset.item(i);

    $('#code').val(item['code']);
    $('#name').val(item['name']);
	$('#unit').val(item['unit']);
	$('#size').val(item['size']);
	$('#cost').val(item['cost']);
	$('#price').val(item['price']);
	$('#category_id').val(item['category_id']);
	$('#quantity').val(item['quantity']);
    $('#id').val(item['id']);
}

function cancelAction_products() {
  $('form').hide();
  $('#btnAdd').removeClass('ui-disabled');
  $('#results').removeClass('ui-disabled');
  $('#btnSave').off('click');
}

//// END PRODUCTS /////////////////////////////////////////////////

