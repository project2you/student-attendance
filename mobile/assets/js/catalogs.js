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

	var sql = 'DROP TABLE Catalogs';

	var sql = "CREATE TABLE IF NOT EXISTS Catalogs (id INTEGER PRIMARY KEY AUTOINCREMENT, code_id TEXT, name TEXT  )";

    db.transaction(
        function (transaction) {

            transaction.executeSql(sql, [], showRecords_catalogs, handleErrors_catalogs);
			console.debug('executeSql: ' + sql);

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
    cancelAction_catalogs();
	//cancelAction_catalogs();
});


// Catalogs
function insertRecord_catalogs() {
    console.debug('called insertRecord_catalogs()');

    var code_id = $('#code_id').val();
	var name = $('#name').val();

    var sql = 'INSERT INTO Catalogs (code_id, name ) VALUES (?, ? )';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [code_id, name ], showRecordsAndResetForm_catalogs, handleErrors_catalogs);
            console.debug('executeSql: ' + sql);
        }
    );
}

function deleteRecord_catalogs(id) {
    console.debug('called deleteRecord_catalogs()');

    var sql = 'DELETE FROM Catalogs WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [id], showRecords_catalogs, handleErrors_catalogs);
            console.debug('executeSql: ' + sql);
            alert('Delete Sucessfully');
        }
    );

    resetForm();
}

function updateRecord_catalogs() {
    console.debug('called updateRecord()');

    var code_id = $('#code_id').val();
	var name = $('#name').val();
    var id = $("#id").val();

    var sql = 'UPDATE Catalogs SET code_id=?, name=?  WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [code_id, name , id], showRecordsAndResetForm_catalogs, handleErrors_catalogs);
            console.debug('executeSql: ' + sql);
        }
    );
}

function dropTable_catalogs() {
    console.debug('called dropTable_catalogs()');

    var sql = 'DROP TABLE Catalogs';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], showRecords_catalogs, handleErrors_catalogs);
        }
    );

    resetForm_catalogs();

    initDatabase();
}

function resetForm_catalogs() {
    console.debug('called resetForm()');

    $('#code_id').val('');
    $('#name').val('');
	$('#id').val('');
}

function showRecordsAndResetForm_catalogs() {
    console.debug('called showRecordsAndResetForm_catalogs()');

    resetForm_catalogs();
    showRecords_catalogs()
}

function handleErrors_catalogs(transaction, error) {
    console.debug('called handleErrors_catalogs()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}

function showRecords_catalogs() {
    console.debug('called showRecords_catalogs()');

    var sql = "SELECT * FROM Catalogs";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_catalogs, handleErrors_catalogs);
        }
    );
}

function renderRecords_catalogs(transaction, results) {
    console.debug('called renderRecords_catalogs()');

    html = '';
    $('#results').html('');

    dataset = results.rows;

    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

            html = html + '    <li>';
            html = html + '      <h3>รหัสหมวดหมู่ : ' + item['code_id'] + '</h3>';
            html = html + '      <p>รายละเอียด : ' + item['name'] + '</p>';
            html = html + '      <p>';
            html = html + '        <button type="button" data-icon="arrow-u" onClick="prepareEdit_catalogs(' + i + ');">แก้ไขข้อมูล</button>';
            html = html + '        <button type"button" data-icon="delete" onClick="deleteRecord_catalogs(' + item['id'] + ');">ลบข้อมูล</button>';
            html = html + '      </p>';
            html = html + '    </li>';
        }

        html = html + '  </ul>';

        $('#results').append(html);
        $('#results ul').listview();
    }
}

function prepareAdd_catalogs() {
  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ insertRecord_catalogs() });
  $('#btnSave').on('click', function(){ cancelAction_catalogs() });
  $('#code_id').focus();
}

function prepareEdit_catalogs(i) {
  loadRecord_catalogs(i)

  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ updateRecord_catalogs() });
  $('#btnSave').on('click', function(){ cancelAction_catalogs() });
  $('#code_id').focus();
}

function loadRecord_catalogs(i) {
    console.debug('called loadRecord_catalogs()');

    var item = dataset.item(i);

    $('#code_id').val(item['code_id']);
    $('#name').val(item['name']);
    $('#id').val(item['id']);
}

function cancelAction_catalogs() {
  $('form').hide();
  $('#btnAdd').removeClass('ui-disabled');
  $('#results').removeClass('ui-disabled');
  $('#btnSave').off('click');
}

//// END CATALOGS /////////////////////////////////////////////////