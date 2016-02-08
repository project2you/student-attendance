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

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function createTableIfNotExists() {
    console.debug('called createTableIfNotExists()');

	var sql1 = "CREATE TABLE IF NOT EXISTS Users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, company TEXT , address TEXT , username TEXT , password TEXT , phone TEXT , email TEXT ,  flag TEXT  )";
    var sql2 = "INSERT INTO Users (name , company , address , username , password , phone , email  , flag )  SELECT * FROM (SELECT 'Stock Name', 'Logistics', 'Maehongson' , 'admin' , 'admin' , '089' , 'support@logistics.or.th' , '1' ) AS tmp WHERE NOT EXISTS ( SELECT flag FROM Users WHERE flag = '1' ) LIMIT 1;";

    db.transaction(
        function (transaction) {

            transaction.executeSql(sql1, [], showRecords_users, handleErrors_users);
            transaction.executeSql(sql2, [], showRecords_users, handleErrors_users);
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
    cancelAction_users();

	var username = getUrlVars()["username"];
	var password = getUrlVars()["password"];

	showRecords_checkusers(username,password);

});


// Users
function insertRecord_users() {
    console.debug('called insertRecord_users()');

    var name = $('#name').val();
	var company = $('#company').val();
	var address = $('#address').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var phone= $('#phone').val();
	var email = $('#email').val();

    var sql = 'INSERT INTO Users (name , company , address , username , password , phone , email) VALUES (?, ? , ?, ? , ?, ? , ?)';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [name , company , address , username , password , phone , email], showRecordsAndResetForm_users, handleErrors_users);
            console.debug('executeSql: ' + sql);
        }
    );
}

function deleteRecord_users(id) {
    console.debug('called deleteRecord_users()');

    var sql = 'DELETE FROM Users WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [id], showRecords_users, handleErrors_users);
            console.debug('executeSql: ' + sql);
            alert('Delete Sucessfully');
        }
    );

    resetForm();
}

function updateRecord_users() {
    console.debug('called updateRecord()');

    var name = $('#name').val();
	var company = $('#company').val();
	var address = $('#address').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var phone= $('#phone').val();
	var email = $('#email').val();
    var id = $("#id").val();

    var sql = 'UPDATE Users SET name=?, company=? , address=? , username=? , password=? , phone=? , email=?  WHERE id=?';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [name , company , address , username , password , phone , email , id], showRecordsAndResetForm_users, handleErrors_users);
            console.debug('executeSql: ' + sql);
        }
    );
}

function dropTable_users() {
    console.debug('called dropTable_users()');

    var sql = 'DROP TABLE Users';

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], showRecords_users, handleErrors_users);
        }
    );

    resetForm_users();

    initDatabase();
}

function resetForm_users() {
    console.debug('called resetForm()');

    $('#name').val('');
    $('#company').val('');
    $('#address').val('');
    $('#username').val('');
    $('#password').val('');
    $('#phone').val('');
    $('#email').val('');
	$('#id').val('');
}

function showRecordsAndResetForm_users() {
    console.debug('called showRecordsAndResetForm_users()');

    resetForm_users();
    showRecords_users()
}

function handleErrors_users(transaction, error) {
    console.debug('called handleErrors()');
    console.error('error ' + error.message);

    alert(error.message);
    return true;
}

function showRecords_users() {
    console.debug('called showRecords_users()');

    var sql = "SELECT * FROM Users";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_users, handleErrors_users);
        }
    );
}


function showRecords_checkusers(username,password) {
    console.debug('called showRecords_checkusers()');

    var sql = "SELECT * FROM Users WHERE username='"+username+"' and password='"+password+"'";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_checkusers, handleErrors_users);
        }
    );
}

function renderRecords_checkusers(transaction, results) {
    console.debug('called renderRecords_checkusers()');

    dataset = results.rows;

    if (dataset.length > 0) {
		window.location='menu.html';
		return true;
    }else{
		var html = '<div class="status error">Error Message</div>';
		$('#results').append(html);
		alert('กรุณาตรวจสอบ Username & Password อีกครั้ง...!!!');
		window.location='login.html?fail=1';
		return false;
	}
}


function renderRecords_users(transaction, results) {
    console.debug('called renderRecords_users()');

    html = '';
    $('#results').html('');

    dataset = results.rows;

    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

            html = html + '    <li>';
            html = html + '      <h3>ข้อมูลผู้ใช้</h3>';
            html = html + '      <p>Name: ' + item['name'] + '</p>';
            html = html + '      <p>Company: ' + item['company'] + '</p>';
            html = html + '      <p>Address: ' + item['address'] + '</p>';
            html = html + '      <p>Username: ' + item['username'] + '</p>';
            html = html + '      <p>Password: ****** </p>';
            html = html + '      <p>Phone: ' + item['phone'] + '</p>';
            html = html + '      <p>Email: ' + item['email'] + '</p>';
            html = html + '    </li>';
        }

        html = html + '  </ul>';

        $('#results').append(html);
        $('#results ul').listview();
    }
}

function prepareAdd_users() {
  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ insertRecord_users() });
  $('#btnSave').on('click', function(){ cancelAction_users() });
  $('#name').focus();
}

function prepareEdit_users(i) {
  loadRecord_users(i)

  $('form').show();
  $('#btnAdd').addClass('ui-disabled');
  $('#results').addClass('ui-disabled');
  $('#btnSave').on('click', function(){ updateRecord_users() });
  $('#btnSave').on('click', function(){ cancelAction_users() });
  $('#name').focus();
}

function loadRecord_users(i) {
    console.debug('called loadRecord_users()');

    var item = dataset.item(i);

    $('#name').val(item['name']);
    $('#company').val(item['company']);
	$('#address').val(item['address']);
	$('#username').val(item['username']);
	$('#password').val(item['password']);
	$('#phone').val(item['phone']);
	$('#email').val(item['email']);
    $('#id').val(item['id']);
}

function cancelAction_users() {
  $('form').hide();
  $('#btnAdd').removeClass('ui-disabled');
  $('#results').removeClass('ui-disabled');
  $('#btnSave').off('click');
}

//// END USERS /////////////////////////////////////////////////