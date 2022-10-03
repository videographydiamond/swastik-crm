// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function () {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Save cart
    function saveCart() {
        // sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
        // cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }

    if (sessionStorage.getItem("shoppingCart") != null) {
        loadCart();
    }

    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};

    obj.addItem = {
        name: '',
        hsn: '',
        price: 0,
        uom: '',
        gst: 0,
        gstVal: 0,
        cgst: 0,
        sgst: 0,
        igst: 0,
        cgstVal:0,
        sgstVal:0,
        igstVal:0,
        discount: 0,
        count: 1,
        pid: null,
        row: 1,
        id: null,
        type: '',
        editid:''
    };
    console.log(obj.addItem);

    obj.addImg = '';
    obj.removeImg = '';
    obj.products = {};

    obj.initialItems = function (items) {
        console.log('items', items);
        if (items.length < 1) {
            shoppingCart.addItemToCart(shoppingCart.addItem);
        } else {
            cart = items;
        }
    }

    // Add to cart
    obj.addItemToCart = function (newItem) {
        for (var item in cart) {
            if (cart[item].pid === newItem.pid) {
                // cart[item].count++;
                console.log('exists');
                saveCart();
                return;
            }
        }

        // var item = new Item(newItem);
        cart.push(newItem);
        saveCart();
    }

    // Set quantity from item
    obj.setCountForItem = function (row, quantity) {
        for (var i in cart) {
            if (cart[i].row == row) {
                cart[i].count = quantity;
                break;
            }
        }
    }

    obj.setPriceForItem = function (row, price) {
        for (var i in cart) {
            if (cart[i].row == row) {
                cart[i].price = price;
                break;
            }
        }
    }

    obj.setDiscountForItem = function (row, discount) {
        for (var i in cart) {
            if (cart[i].row == row) {
                cart[i].discount = discount;
                break;
            }
        }
    }

    // Remove item from cart
    obj.removeItemFromCart = function (pid) {
        for (var item in cart) {
            if (cart[item].pid == pid) {
                cart.splice(item, 1);
                break;
            }
        }
        var count = 1;
        for (var item in cart) {
            cart[item].row = count;
            count++;
        }
        saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (pid) {
        for (var item in cart) {
            if (cart[item].pid === pid) {
                cart.splice(item, 1);
                break;
            }
        }
        saveCart();
    }

    // Clear cart
    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    // Count cart 
    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0;
        for (var i in cart) {
            item = cart[i];
            totalCart += ((item.price * item.count)) - item.discount;
        }
        return (totalCart.toFixed(2));
    }

    /**
     * Update tax values in cart list
     * @param {*} centerState 
      cgstVal:0,
        sgstVal:0,
        igstVal:0,
     */
    obj.updateTax = function (centerState) {
        var state = Number($('#state').val());
        var cgst = 0;
        var sgst = 0;
        var igst = 0;
        console.log(centerState,state);
        for (var i in cart) {
            item = cart[i];
            var quantity = item.count;
            var gst = item.gst ? Number(item.gst) : 0;
            var cgstVal = 0;
            var sgstVal = 0;
            var igstVal = 0;
            var gstVal = 0;

            if (centerState == state) {
                cgst = gst / 2;
                sgst = gst / 2;
                igst = 0;
                cgstVal = this.getPercentOfNumberVal(item.price, cgst, gst);
                sgstVal = this.getPercentOfNumberVal(item.price, sgst, gst);
            } else {
                cgst = 0;
                sgst = 0;
                igst = gst;
            }

            var igstVal = this.getPercentOfNumber(item.price, igst);
            var gstVal = this.getPercentOfNumber(item.price, gst);

            cart[i].cgst    = ( cgst );
            cart[i].cgstVal = ( cgstVal * quantity).toFixed(2);
            cart[i].sgst    = ( sgst );
            cart[i].sgstVal = ( sgstVal * quantity).toFixed(2);
            cart[i].igst    = ( igst );
            cart[i].igstVal = ( igstVal * quantity).toFixed(2);
            cart[i].gstVal = ( gstVal * quantity).toFixed(2);
        }
    }

    // List cart
    obj.listCart = function () {
        var cartCopy = [];
        /*console.log('listCart', cart);*/
        for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
                itemCopy[p] = item[p];

            }
            itemCopy.total = Number(((item.price * item.count)) - item.discount).toFixed(2);
            cartCopy.push(itemCopy)
        }
        return cartCopy;
    }

    obj.updateItem = function (newItem, row, pid) {
        console.log('updateItem', newItem);
        var pids = [];
        for (var i in cart) {
            pids[i] = cart[i].pid;
        }
        if ($.inArray(pid, pids) > -1) {
            console.log('Item already exist');
            toastr.error("Item already Added");
            return;
        }
        for (var i in cart) {
            if (cart[i].row === row) {
                cart[i] = newItem;
                saveCart();
                break;
            }
        }
    }

    obj.getPercentOfNumber = function (number, percent) {
        // return (percent / 100) * number;
        return (number * percent) / (percent + 100);
    }

    obj.getPercentOfNumberVal = function (number, percent, gst) {
        return (number * percent) / (100 + gst);
        // return (number * percent) / 118;
    }

    obj.itemTotal = function (price, cgst, sgst, igst, quantity, discount) {
        var totalCart = 0;
        var taxval = 0;
        var cgstvalue = this.getPercentOfNumber(price, cgst);
        var sgstvalue = this.getPercentOfNumber(price, sgst);
        var igstvalue = this.getPercentOfNumber(price, igst);
        taxval = (cgstvalue + igstvalue + sgstvalue) * quantity;
        totalCart = ((price * quantity) + taxval) - discount;
        return totalCart;
    }

    obj.renderTax = function (centerState, row) {
        var rowField = $('.row-' + row);
        var quantity = Number(rowField.find('.quantity').val());
        var gst = Number(rowField.find('.gst').val());
        var state = Number($('#state').val());
        var price = Number(rowField.find('.price').val());

        var cgst = 0;
        var sgst = 0;
        var igst = 0;

        var cgstVal = 0;
        var sgstVal = 0;
        var igstVal = 0;

         console.log(centerState,state); 
        if (centerState == state) {
            cgst = gst / 2;
            sgst = gst / 2;
            igst = 0;
            cgstVal = this.getPercentOfNumberVal(price, cgst, gst);
            sgstVal = this.getPercentOfNumberVal(price, sgst, gst);
        } else {
            cgst = 0;
            sgst = 0;
            igst = gst;
        }

        var igstVal = this.getPercentOfNumber(price, igst);
        var gstVal = this.getPercentOfNumber(price, gst);

        rowField.find('.cgstRate').val((cgst).toFixed(2));
        rowField.find('.sgstRate').val((sgst).toFixed(2));
        rowField.find('.igstRate').val((igst).toFixed(2));
        rowField.find('.cgstVal').val((cgstVal * quantity).toFixed(2));
        rowField.find('.sgstVal').val((sgstVal * quantity).toFixed(2));
        rowField.find('.igstVal').val((igstVal * quantity).toFixed(2));
        rowField.find('.gstVal').val((gstVal * quantity).toFixed(2));

        rowField.find('.cgst').text((cgstVal * quantity).toFixed(2) + ' (' + cgst + '%)');
        rowField.find('.sgst').text((sgstVal * quantity).toFixed(2) + ' (' + sgst + '%)');
        rowField.find('.igst').text((igstVal * quantity).toFixed(2) + ' (' + igst + '%)');
    }

    obj.calculateCart = function (centerState, row) {
        this.renderTax(centerState, row);
        var rowField = $('.row-' + row);
        var row_price = rowField.find('.price').val();
        var row_quantity = rowField.find('.quantity').val()
        var row_discount = rowField.find('.discount').val();
        var subtotal = (Number(row_quantity) * Number(row_price)) - Number(row_discount);
        //Update subtotal field
        rowField.find('.subtotal').text(subtotal.toFixed(2));
        rowField.find('.subTotalAmount').val(subtotal.toFixed(2));

        var cartArray = shoppingCart.listCart();
        var totalAmount = 0;
        for (var i in cartArray) {
            var quantity = Number(cartArray[i].count);
            var price = Number(cartArray[i].price);
            var discount = Number(cartArray[i].discount);
            totalAmount += (quantity * price) - discount;
        }
        // var shippingCharge = this.shippingCharge();
        // totalAmount += shippingCharge;

        $('.totalCart').text(totalAmount.toFixed(2));
        $('#total').val(totalAmount.toFixed(2));
        

        //Update balance field
        var pendingBill = Number($('#pending_bill').val());
        var advance = Number($('#advance').val());
        var balance = (totalAmount - advance) + pendingBill;
        $('#balance').val(Number(balance).toFixed(2));
        $('.pending-bill').text(Number(pendingBill).toFixed(2));
        var total_paid = Number($('#total_paid').text());
        $('#pending_amount').text(Number(totalAmount - total_paid).toFixed(2));

    }

    /**
     * Update outstanding field
     */
    obj.outstanding = function () {
        var cartArray = shoppingCart.listCart();
        var totalAmount = 0;
        for (var i in cartArray) {
            var quantity = Number(cartArray[i].count);
            var price = Number(cartArray[i].price);
            var discount = Number(cartArray[i].discount);
            totalAmount += (quantity * price) - discount;
        }

        // var shippingCharge = this.shippingCharge();
        // totalAmount += shippingCharge;
        $('.totalCart').text(totalAmount.toFixed(2));
        $('#total').val(totalAmount.toFixed(2));
        //Update balance field
         
        var advance = ($('#sales_form #advance').val()) ? Number($('#sales_form  #advance').val()) : 0;
        var balance = (totalAmount - advance);
        $('#balance').val(Number(balance).toFixed(2));
         
    }

    obj.shippingCharge = function () {
        var shippingCharge = Number($('#shipping_charge').val());
        var shipping_percent = this.getPercentOfNumber(shippingCharge, 18);
        var totalShipping = shippingCharge;
        $('.shipping-charge').text(totalShipping.toFixed(2));
        return totalShipping;
    }

    //Display the cart
    obj.displayCart = function () {
        var cartArray = this.listCart();
        var removeImg = this.removeImg;
        var addImg = this.addImg;
        var output = "";
        var count = 1;
        var cartBody = $('#card_body');
        for (var i in cartArray) {
            var productType = cartArray[i].type;
            var productOptions = selectDropDown(this.products, cartArray[i].pid);
            var hiddenFields = '<span><input type="hidden" class="pid" name="items[' + i + '][product_id]" value="' + cartArray[i].pid + '">';
            hiddenFields += '<input type="hidden" class="gst" name="items[' + i + '][gst]" value="' + cartArray[i].gst + '">';
            hiddenFields += '<input type="hidden" class="gstVal" name="items[' + i + '][gstVal]" value="' + cartArray[i].gstVal + '">';
            hiddenFields += '<input type="hidden" class="cgstVal" name="items[' + i + '][cgstVal]" value="' + cartArray[i].cgstVal + '">';
            hiddenFields += '<input type="hidden" class="sgstVal" name="items[' + i + '][sgstVal]" value="' + cartArray[i].sgstVal + '">';
            hiddenFields += '<input type="hidden" class="igstVal" name="items[' + i + '][igstVal]" value="' + cartArray[i].igstVal + '">';
            hiddenFields += '<input type="hidden" class="cgstRate" name="items[' + i + '][cgstRate]" value="' + cartArray[i].cgst + '">';
            hiddenFields += '<input type="hidden" class="sgstRate" name="items[' + i + '][sgstRate]" value="' + cartArray[i].sgst + '">';
            hiddenFields += '<input type="hidden" class="igstRate" name="items[' + i + '][igstRate]" value="' + cartArray[i].igst + '">';
            hiddenFields += '<input type="hidden" class="subTotalAmount" name="items[' + i + '][subTotalAmount]" value="' + cartArray[i].total + '">';
            hiddenFields += '<input type="hidden" class="editid" name="items[' + i + '][editid]" value="' + cartArray[i].editid + '">';
            
            if (cartArray[i].id) {
                hiddenFields += '<input type="hidden" name="items[' + i + '][id]" value="' + cartArray[i].id + '">';
            }
            hiddenFields += "</span>";
            var removeAction = '<a class="mr-2 remove-item" href="javascript:void(0)" data-row="' + count + '" data-pid="' + cartArray[i].pid + '"><img src="' + removeImg + '" alt="remove"/></a>';
            var addAction = '<a class="add-item" href="javascript:void(0)" data-row="' + count + '"><img src="' + addImg + '" alt="add"/></a>';
            var actions = removeAction;
            if (i == cartArray.length - 1) {
                actions += addAction;
            }

            var isPriceDisabled = productType !== 'shipping' ? 'disabled="disabled"' : '';
            isPriceDisabled = '';

            output += "<tr class='row-" + count + "'>"
                + td(hiddenFields + '<select required class="form-control form-control-sm select2 product " id="product' + count + '" name="items[' + i + '][product_id]" data-row="' + count + '">' + productOptions + '</select>')
                + td('<input type="text"  name="items[' + i + '][uom]" disabled="disabled" class="form-control form-control-sm  uom" value="' + cartArray[i].uom + '">')
                + td('<input type="text" name="items[' + i + '][price]" ' + isPriceDisabled + ' class="form-control form-control-sm numberAndDot price" data-row="' + count + '" value="' + cartArray[i].price + '">')
                + td('<input type="text" name="items[' + i + '][quantity]" class="form-control form-control-sm  quantity numberAndDot" data-row="' + count + '" value="' + cartArray[i].count + '">')
                + td('<span type="text" class="cgst">' + cartArray[i].cgstVal+' ('+ cartArray[i].cgst + ' %) </span')
                + td('<span type="text" class="sgst">' + cartArray[i].sgstVal+' (' + cartArray[i].sgst + ' %) </span')
                + td('<span type="text" class="igst">' + cartArray[i].igstVal +' ('  +cartArray[i].igst + '  %)  </span')
                + td('<input type="text" name="items[' + i + '][discount]" class="form-control form-control-sm  discount numberAndDot" data-row="' + count + '" value="' + cartArray[i].discount + '">')
                + td('<div class="text-right subtotal">' + cartArray[i].total + '</div>')
                + td('<div>' + actions + '</div>')
                + "</tr>";
            count++;
        }
        cartBody.html(output);
        // var shippingCharge = Number(this.shippingCharge());
        var totalCart = Number(this.totalCart());

        $('.totalCart').text((totalCart).toFixed(2));
        $('#total').val(totalCart.toFixed(2));
        function td(value) {
            return '<td>' + value + '</td>';
        }
    }

    //On cart product change
    obj.onProductChange = function (url, productId, row, centerState) {
        $('.item-data .overlay').show();
        /*console.log('product change', row);*/
        $.ajax({
            type: 'GET',
            url: url + productId,
            data: {},
            dataType:'json',
             beforeSend: function(){
               show_loader();
             },
             complete: function(){
                hide_loader();
             },
            success: function (response) {
                $('.item-data .overlay').hide();
                if (response) {
                    var data = response;
                  
                    /*console.log(data.title);*/

                    var addItem = {
                        name: data.name,
                        hsn: data.hsn,
                        price: data.price,
                        uom: data.usage_unit ? data.usage_unit : '',
                        gst: data.tax_rate ? data.tax_rate : 0,
                        gstVal: 0,
                        cgst: 0,
                        sgst: 0,
                        igst: 0,
                        cgstVal:0,
                        sgstVal:0,
                        igstVal:0,
                        igst: 0,
                        discount: (data.discount) ? data.discount : 0,
                        count: 1,
                        pid: data.id,
                        row: row,
                        type: null,
                        editid:''
                    };
                    shoppingCart.updateItem(addItem, row, addItem.pid);
                    shoppingCart.updateTax(centerState);
                    shoppingCart.displayCart();
                    shoppingCart.renderTax(centerState, row);
                    shoppingCart.outstanding();
                    $(".select2").select2();
                }
            }
        });
    }//On cart product change
    obj.onProductOfBookingChange = function (url, productId, row, centerState,price,discount,quantity) {
         
        /*console.log('product change', row);*/
        $.ajax({
            type: 'GET',
            url: url + productId,
            data: {},
            dataType:'json',
             beforeSend: function(){
               show_loader();
             },
             complete: function(){
                hide_loader();
             },
            success: function (response) {
                 
                if (response) {
                    var data = response;
                    var addItem = {
                        name: data.name,
                        hsn: data.hsn,
                        price: price,
                        uom: data.usage_unit ? data.usage_unit : '',
                        gst: data.tax_rate ? data.tax_rate : 0,
                        cgst: 0,
                        sgst: 0,
                        igst: 0,
                        cgstVal:0,
                        sgstVal:0,
                        igstVal:0,
                        igst: 0,
                        discount: (discount) ? discount : 0,
                        count: quantity ? quantity : 1,
                        pid: data.id,
                        row: row,
                        type: null,
                        editid:''
                    };
                    shoppingCart.updateItem(addItem, row, addItem.pid);
                    shoppingCart.updateTax();
                    shoppingCart.displayCart();
                    shoppingCart.renderTax(centerState, row);
                    shoppingCart.outstanding();
                    $(".select2").select2();
                }
            }
        });
    }  
    obj.onOrderLoad = function( jsonss , centerState) {
         
          var jsonss = JSON.parse(jsonss); 
        var row = 1;
         for (var i in jsonss) {

                    var data = jsonss[i];
                      
                     
                    var addItem = {
                        name: data.productname,
                        hsn: data.producthsn,
                        price: data.price,
                        uom: data.uoms ? data.uoms : '',
                        gst: data.tax_rate ? data.tax_rate : 0,
                        gstVal: data.tax_amount ? data.tax_amount : 0,
                        cgst: 0,
                        sgst: 0,
                        igst: 0,
                        cgstVal:0,
                        sgstVal:0,
                        igstVal:0,
                        igst: 0,
                        discount: (data.discount) ? data.discount : 0,
                        count: (data.quantity) ? (data.quantity) : 1,
                        pid: data.product_id,
                        row: row,
                        type: null,
                        editid: data.id
                    };
                    /*shoppingCart.updateItem(addItem, row, addItem.pid);
                    shoppingCart.updateTax();
                    shoppingCart.displayCart();
                    
                    shoppingCart.outstanding();*/
                    shoppingCart.updateTax(centerState);
                    shoppingCart.renderTax(centerState, row);
                    shoppingCart.addItemToCart(addItem);
                    // shoppingCart.outstanding();
                    var row = row+1;

                  
                 
        }
     }
    return obj;
})();