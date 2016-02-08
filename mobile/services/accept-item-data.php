<!DOCTYPE html>
<html>
<body onload="saveData()">

<p id="demo">Click the button to save data the array into a databases.</p>

<button onclick="myFunction()">Save Now</button>

<script>

function saveData(){

	var qrStr = window.location.search;
	var select_customer = getParameterByName('select-customer');	
	var select_cash = getParameterByName('select-cash');	
	var cash = getParameterByName('cash');	
	
	myFunction();

}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function myFunction() {

	var qrStr = window.location.search;
	var spQrStr = qrStr.substring(1);
	var arrQrStr = new Array();
	var arr = spQrStr.split('&');

	var itemCode= new Array();
	var itemDesc= new Array();
	var itemQty = new Array();
	var itemPrice = new Array();
	var itemLineTotal = new Array();

	var a=0;
	var b=0;
	var c=0;
	var d=0;
	var e=0;

	for (var i=0;i<arr.length;i++){
		var queryvalue = arr[i].split('=');
		var  id=queryvalue[0];
		var comment=queryvalue[1];
		
		id = id.replace(/%5B%5D/g, "");

		if (id == 'itemCode')
		{
			itemCode[a] = comment;
			a++;
		}

		if (id == 'itemQty')
		{
			itemQty[c] = comment;
			c++;
		}

		if (id == 'itemPrice')
		{
			itemPrice[d] = comment;
			d++;
		}


		if (id == 'itemLineTotal')
		{
			itemLineTotal[e] = comment;
			e++;
		}

	}
		for (var i=0;i<itemCode.length;i++){
			alert(itemCode[i] + itemQty[i] + itemPrice[i] + itemLineTotal[i] );	
		}
}
</script>

</body>
</html>

