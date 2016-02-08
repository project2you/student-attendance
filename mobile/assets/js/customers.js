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

	var sql1 = "CREATE TABLE IF NOT EXISTS Customers (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, company TEXT , address TEXT , city TEXT , state TEXT , postal_code TEXT , country TEXT , phone TEXT , email TEXT  )";

    db.transaction(
        function (transaction) {

            transaction.executeSql(sql1, [], showRecords_customers, handleErrors_customers);
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
    cancelAction_customers();
	//cancelAction_catalogs();
});


// Customers
function insertRecord_customers() {
    console.debug('called insertRecord_customers()');

    var name = $('#name').val();
	var company = $('#company').val();
	var address = $('#address').val();
	var city = $('#city').val();
	var state = $('#state').val();
	var postal_code= $('#postal_code').val();
	var country = $('#country').val();
    var phone = $('#phone').val();
	var email = $('#email').val();


    var sql = 'INSERT INTO Customers (name, company , address , city , state , postal_code , country , phone , email) VALUES (?, ? , ?, ? , ?, ? , ?, ?, ?)';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [name, company , address , city , state , postal_code , country , phone , email], showRecordsAndResetForm_customers, handleErrors_customers);
            console.debug('executeSql: ' + sql);
        }
    );
}

function deleteRecord_customers(id) {
    console.debug('called deleteRecord_customers()');

    var sql = 'DELETE FROM Customers WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [id], showRecords_customers, handleErrors_customers);
            console.debug('executeSql: ' + sql);
            alert('Delete Sucessfully');
        }
    );

    resetForm();
}

function updateRecord_customers() {
    console.debug('called updateRecord()');

    var name = $('#name').val();
	var company = $('#company').val();
	var address = $('#address').val();
	var city = $('#city').val();
	var state = $('#state').val();
	var postal_code= $('#postal_code').val();
	var country = $('#country').val();
    var phone = $('#phone').val();
	var email = $('#email').val();
    var id = $("#id").val();

    var sql = 'UPDATE Customers SET name=?, company=? , address=? , city=? , state=? , postal_code=? , country=? , phone=? , email=?  WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [name, company , address , city , state , postal_code , country , phone , email , id], showRecordsAndResetForm_customers, handleErrors_customers);
            console.debug('executeSql: ' + sql);
        }
    );
}

function dropTable_customers() {
    console.debug('called dropTable_customers()');

    var sql = 'DROP TABLE Customers';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], showRecords_customers, handleErrors_customers);
        }
    );

    resetForm_customers();

    initDatabase();
}

function resetForm_customers() {
    console.debug('called resetForm()');

    $('#name').val('');
    $('#company').val('');
    $('#address').val('');
    $('#city').val('');
    $('#state').val('');
    $('#postal_code').val('');
    $('#country').val('');
    $('#phone').val('');
    $('#email').val('');
	$('#id').val('');
}

function showRecordsAndResetForm_customers() {
    console.debug('called showRecordsAndResetForm_customers()');

    resetForm_customers();
    showRecords_customers()
}

function handleErrors_customers(transaction, error) {
    console.debug('called handleErrors()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
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

function renderRecords_customers(transaction, results) {
    console.debug('called renderRecords_customers()');

    html = '';
    $('#results').html('');

    dataset = results.rows;

    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            
			item = dataset.item(i);

            html = html + '    <li>';
            html = html + '      <h4>ชื่อลูกค้า ' + item['name'] + '</h4>';
            html = html + '      <p> ชื่อบริษัท  ' + item['company'] + '</p>';
            html = html + '      <p>เบอร์โทร : ' + item['phone'] + '</p>';
            html = html + '      <p>อีเมล์ : ' + item['email'] + '</p>';
            html = html + '      <p>';
            html = html + '        <button type="button" data-icon="arrow-u" onClick="prepareEdit_customers(' + i + ');">แก้ไขข้อมูล</button>';
            html = html + '        <button type"button" data-icon="delete" onClick="deleteRecord_customers(' + item['id'] + ');">ลบข้อมูล</button>';
            html = html + '      </p>';
            html = html + '    </li>';
        }

        html = html + '  </ul>';

        $('#results').append(html);
        $('#results ul').listview();
    }
}

function prepareAdd_customers() {
  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ insertRecord_customers() });
  $('#btnSave').on('click', function(){ cancelAction_customers() });
  $('#name').focus();
}

function prepareEdit_customers(i) {
  loadRecord_customers(i)

  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ updateRecord_customers() });
  $('#btnSave').on('click', function(){ cancelAction_customers() });
  $('#name').focus();
}

function loadRecord_customers(i) {
    console.debug('called loadRecord_customers()');

    var item = dataset.item(i);

    $('#name').val(item['name']);
    $('#company').val(item['company']);
	$('#address').val(item['address']);
	$('#city').val(item['city']);
	$('#state').val(item['state']);
	$('#postal_code').val(item['postal_code']);
	$('#country').val(item['country']);
	$('#phone').val(item['phone']);
	$('#email').val(item['email']);
    $('#id').val(item['id']);
}

function cancelAction_customers() {
  $('form').hide();
  $('#btnAdd').removeClass('ui-disabled');
  $('#results').removeClass('ui-disabled');
  $('#btnSave').off('click');
}

//// END CUSTOMER /////////////////////////////////////////////////