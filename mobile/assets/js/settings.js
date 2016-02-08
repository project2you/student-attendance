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

	var sql1 = "CREATE TABLE IF NOT EXISTS Settings (id INTEGER PRIMARY KEY AUTOINCREMENT, site_name TEXT, currency_prefix  TEXT , sales_prefix TEXT , sales_vat  TEXT )";
    var sql2 = "INSERT INTO Settings (site_name , currency_prefix , sales_prefix , sales_vat ) SELECT * FROM (SELECT 'Default', 'USD', 'SL' , '7') AS tmp WHERE NOT EXISTS ( SELECT site_name FROM Settings WHERE site_name = 'Default' ) LIMIT 1;";

    db.transaction(
        function (transaction) {

            transaction.executeSql(sql1, [], showRecords_settings, handleErrors_settings);
            transaction.executeSql(sql2, [], showRecords_settings, handleErrors_settings);
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
    cancelAction_settings();
	//cancelAction_catalogs();
});


// Settings
function insertRecord_settings() {
    console.debug('called insertRecord_settings()');

    var site_name = $('#site_name').val();
	var currency_prefix = $('#currency_prefix').val();
	var sales_prefix = $('#sales_prefix').val();
	var sales_vat = $('#sales_vat').val();

    var sql = 'INSERT INTO Settings (site_name , currency_prefix , sales_prefix  , sales_vat ) VALUES (?, ? , ? , ? )';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [site_name , currency_prefix , sales_prefix], showRecordsAndResetForm_settings, handleErrors_settings);
            console.debug('executeSql: ' + sql);
        }
    );
}

function deleteRecord_settings(id) {
    console.debug('called deleteRecord_settings()');

    var sql = 'DELETE FROM Settings WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [id], showRecords_settings, handleErrors_settings);
            console.debug('executeSql: ' + sql);
            alert('Delete Sucessfully');
        }
    );

    resetForm();
}

function updateRecord_settings() {
    console.debug('called updateRecord()');

    var site_name = $('#site_name').val();
	var currency_prefix = $('#currency_prefix').val();
	var sales_prefix = $('#sales_prefix').val();
	var sales_vat = $('#sales_vat').val();

    var id = $("#id").val();

    var sql = 'UPDATE Settings SET site_name=?, currency_prefix=? , sales_prefix=? , sales_vat=? WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [site_name , currency_prefix , sales_prefix , sales_vat , id], showRecordsAndResetForm_settings, handleErrors_settings);
            console.debug('executeSql: ' + sql);
        }
    );
}

function dropTable_settings() {
    console.debug('called dropTable_settings()');

    var sql = 'DROP TABLE Settings';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], showRecords_settings, handleErrors_settings);
        }
    );

    resetForm_settings();

    initDatabase();
}

function resetForm_settings() {
    console.debug('called resetForm()');

    $('#site_name').val('');
    $('#currency_prefix').val('');
    $('#sales_prefix').val('');
	$('#sales_vat').val('');
	$('#id').val('');
}

function showRecordsAndResetForm_settings() {
    console.debug('called showRecordsAndResetForm_settings()');

    resetForm_settings();
    showRecords_settings()
}

function handleErrors_settings(transaction, error) {
    console.debug('called handleErrors()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}

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

    html = '';
    $('#results').html('');

    dataset = results.rows;

    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

            html = html + '    <li>';
            html = html + '      <h3>การกำหนดค่า</h3>';
            html = html + '      <p>ชื่อบริษัท: ' + item['site_name'] + '</p>';
            html = html + '      <p>สกุงเงิน: ' + item['currency_prefix'] + '</p>';
            html = html + '      <p>รหัสการขาย: ' + item['sales_prefix'] + '</p>';
            html = html + '      <p>อัตราภาษี : ' + item['sales_vat'] + '</p>';
            html = html + '    </li>';
        }

        html = html + '  </ul>';

        $('#results').append(html);
        $('#results ul').listview();
    }
}

function prepareAdd_settings() {
  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ insertRecord_settings() });
  $('#btnSave').on('click', function(){ cancelAction_settings() });
  $('#name').focus();
}

function prepareEdit_settings(i) {
  loadRecord_settings(i)

  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ updateRecord_settings() });
  $('#btnSave').on('click', function(){ cancelAction_settings() });
  $('#name').focus();
}

function loadRecord_settings(i) {
    console.debug('called loadRecord_settings()');

    var item = dataset.item(i);

    $('#site_name').val(item['site_name']);
    $('#currency_prefix').val(item['currency_prefix']);
	$('#sales_prefix').val(item['sales_prefix']);
	$('#sales_vat').val(item['sales_vat']);

    $('#id').val(item['id']);
}

function cancelAction_settings() {
  $('form').hide();
  $('#btnAdd').removeClass('ui-disabled');
  $('#results').removeClass('ui-disabled');
  $('#btnSave').off('click');
}

//// END Settings /////////////////////////////////////////////////