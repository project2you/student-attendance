
$(document).ready(function () {

    // We are overriding the autocomplete UI menu styles to create our own.
    // You can add information from the returned json array as needed
    // Just be sure that your array contains the correct value when returned
    // You'll want to modify the data/item-data.php file for the returned values

    $.ui.autocomplete.prototype._renderItem = function (ul, item) {
        return $("<li></li>")
            .data("item.autocomplete", item)

            // This is the autocomplete list that is generated
            .append("<a class='additionalInfo'>" + item.jItemCode + " - " + item.jItemDesc + " " +

            // This is the hover box that is generated when you hover over an item in the list
            //"<span class='additionalInfoColor'>" +
            //"<div><h4>Item Information</h4></div>" +
            //"<div><strong>Item Code:</strong> " + item.jItemCode + "</div>" +
            //"<div><strong>Qty on Hand:</strong> " + item.jQtyOnHand + "</div>" +
            //"<div><strong>Merchant:</strong> $" + item.jItemPrice + "</div>" +
            //"<div><strong>Wholesale:</strong> $" + item.jItemWholesale + "</div>" +
            //"<div><strong>Retail:</strong> $" + item.jItemRetail + "</div>" +
            "</span> </a>")

            .appendTo(ul);
    };

    // We don't want the user to leave the page if they have started working with it so we set the
    // onbeforeload method
    $('#itemCode').focus(function () {
        window.onbeforeunload = function () {
            return "You haven't saved your data.  Are you sure you want to leave this page without saving first?";
        };
    });

    // Update invoice total when item Qty or Price inputs have been updated
    $("#itemQty, #itemPrice").on('keyup', function () {
        // Locate the row we are working with
        var $itemRow = $(this).closest('tr');
        // Update the price.
        updatePrice($itemRow);
    });

    $("#itemQty, #itemPrice").on('focusout', function () {
        // Locate the row we are working with
        var $itemRow = $(this).closest('tr');
        // Update the price.
        updatePrice($itemRow);
    });


    // Use the .autocomplete() method to compile the list based on input from user
    $('#itemCode').autocomplete({
        source: myJson ,
        minLength: 1,
        select:function (event, ui) {
            var $itemrow = $(this).closest('tr');
            // Populate the input fields from the returned values
            $itemrow.find('#itemCode').val(ui.item.jItemCode);
            $itemrow.find('#itemDesc').val(ui.item.jItemDesc);
            $itemrow.find('#itemPrice').val(ui.item.jItemPrice);
            // Give focus to the next input field to recieve input from user
            $('#itemQty').focus();
            return false;
        }
    });

    /*
     * Here's where we start adding rows to the invoice
     */
    // Add row to list and allow user to use autocomplete to find items.
    $("#addRow").on('click', function () {

        // Get the table object to use for adding a row at the end of the table
        var $itemsTable = $('#itemsTable');

        // Create an Array to for the table row. ** Just to make things a bit easier to read.
        var rowTemp = [
            '<tr class="item-row">',
            '<td><i id="deleteRow" class="icon-remove"></i></td>',
            '<td><input type="text" name="itemCode[]" class="input-mini" value="" id="itemCode" /> </td>',
            '<td><input type="text" name="itemQty[]" class="input-mini" value="" id="itemQty" /></td>',
            '<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemPrice[]" class=" input-mini" id="itemPrice" type="text"></div></td>',
            '<td><div class="input-prepend input-append"><span class="add-on">$</span><input name="itemLineTotal[]" class=" input-mini" id="itemLineTotal" type="text" readonly="readonly"></div></td>',
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
            $row.find("#itemQty, #itemPrice").on('keyup', function () {
                // Locate the row we are working with
                var $itemRow = $(this).closest('tr');
                // Update the price.
                updatePrice($itemRow);
            });


        } else {
            $('.alert').fadeIn('slow').html('You need to complete the item inputs');
        }

        // End if last itemCode input is empty
        return false;
    });

}); // End DOM


/* Description: Update price function
*  @param: $itemRow - Row Object
* */

 var updatePrice = function($itemRow){
    // Calculate the price of the row.  Remove and $ so the calculation doesn't break
    var price = $itemRow.find('#itemPrice').val().replace("$", "") * $itemRow.find('#itemQty').val();
    price = roundNumber(price, 2);
    isNaN(price) ? $itemRow.find('#itemLineTotal').val("N/A") : $itemRow.find('#itemLineTotal').val(price);
    update_total();
};

var update_total = function() {
    var total = 0;
	var calvat = 0;
	var count = 0;

    $('input#itemLineTotal').each(function (i) {
        price = $(this).val().replace("$", "");
        if (!isNaN(price)) total += Number(price);
    });

    total = roundNumber(total, 2);
	
	calvat = (total * vat / 100);
	calvat = roundNumber(calvat, 2);

	count = Number(calvat) + Number(total);
	count = roundNumber(count, 2);

    $('#invGrandTotalTop, #labelTotal').html("<h5><p align='right'>Total</p></h5>");
    $('#invGrandTotalTop, #invGrandTotal').html("<h5>$ " + total + "</h5>");
	$('#inv_total').val(total)

    $('#invGrandTotalTop, #labelVat').html("<h5><p align='right'>Vat " + vat + " % </p></h5>");   
    $('#invGrandTotalTop, #calVat').html("<h5>$ " + calvat + " </h5>");
	$('#inv_vat').val(calvat)

    $('#invGrandTotalTop, #labelSummary').html("<h5><p align='right'>Summary</p></h5>");
    $('#invGrandTotalTop, #invGrandSummary').html("<h5>$ " + count + "</h5>");
	$('#total').val(count)

	$('#reference_no').val(reference_no+run);

};

// Update message
var updateMessage = function(msgType, message, delay){
    $('#alert').fadeIn('slow').addClass(msgType).html(message).delay(delay).fadeOut('slow');
};

//########################################################################################################################
function roundNumber(number, decimals) {
    var newString;// The new rounded number
    decimals = Number(decimals);
    if (decimals < 1) {
        newString = (Math.round(number)).toString();
    } else {
        var numString = number.toString();
        if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
            numString += ".";// give it one at the end
        }
        var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
        var d1 = Number(numString.substring(cutoff, cutoff + 1));// The value of the last decimal place that we'll end up with
        var d2 = Number(numString.substring(cutoff + 1, cutoff + 2));// The next decimal, after the last one we want
        if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
            if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
                while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                    if (d1 != ".") {
                        cutoff -= 1;
                        d1 = Number(numString.substring(cutoff, cutoff + 1));
                    } else {
                        cutoff -= 1;
                    }
                }
            }
            d1 += 1;
        }
        if (d1 == 10) {
            numString = numString.substring(0, numString.lastIndexOf("."));
            var roundedNum = Number(numString) + 1;
            newString = roundedNum.toString() + '.';
        } else {
            newString = numString.substring(0, cutoff) + d1.toString();
        }
    }
    if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
        newString += ".";
    }
    var decs = (newString.substring(newString.lastIndexOf(".") + 1)).length;
    for (var i = 0; i < decimals - decs; i++) newString += "0";
    //var newNumber = Number(newString);// make it a number if you like
    return newString; // Output the result to the form field (change for your purposes)
}