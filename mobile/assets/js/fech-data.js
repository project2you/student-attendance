var db;
var dataset;
var myJson = [];

$(document).ready(function () {
    window.applicationCache.addEventListener('updateready', updateCacheContent, false);
	initDatabase();
	showRecords_products_json();
});

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

function updateCacheContent(event) {
    console.debug('called updateCacheContent()');
    window.applicationCache.swapCache();
}

function showRecords_products_json() {
    console.debug('called showRecords_products_json()');

    var sql = "SELECT * FROM products";

    db.transaction(
        function (transaction) {
            transaction.executeSql(sql, [], renderRecords_products_json, []);
        }
    );
}

function renderRecords_products_json(transaction, results) {
    console.debug('called renderRecords_products()');

    html = '';
    $('#results').html('');

    dataset = results.rows;

	var rowTemp ;
	
    if (dataset.length > 0) {
        html = html + '  <ul data-role="listview">';

        for (var i = 0, item = null; i < dataset.length; i++) {
            item = dataset.item(i);

			myJson.push({jItemCode: item['code'] , jItemDesc : item['name'] , jItemRetail : item['cost']  , jItemPrice  : item['price'] });
        }
    }
}

//// END DATA SOURCE JSON /////////////////////////////////////////////////

