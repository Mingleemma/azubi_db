$(document).ready(function() {


  const urlroot = fdacfg.urlroot;

	$('#dateofcommencement,#dateofbirth, #paymentdate').datepicker({
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'yy-mm-dd'
      });

    $('.prod').SumoSelect({search: true, searchText: 'Select Product  ...'});

    $("#from, #to").datepicker({inline: true,
        changeMonth: true, changeYear: true, yearRange: "1920:2020",
        dateFormat: 'yy-mm-dd', autoclose: true,
        todayHighlight: true });


    $('.apptables').DataTable();

    $('.userroles').SumoSelect();

    $('.packarea').hide();

    function AjaxPostRequest(ajaxurl, postdata){

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data : postdata,
            beforeSend: function () {
                $.blockUI();
            },
            success: function (text) {
                $("#ajaxcontainer").html(text);
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    }


    function AjaxPostRedirection(ajaxurl, postdata, redirectionurl){

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data : postdata,
            beforeSend: function () {
                $.blockUI();
            },
            success: function (text) {
                window.location.href = redirectionurl;
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    }

    $(document).on('click', '#searchpayment', function(){
        var from  = $('#from').val();
        var to  = $('#to').val();
        var postdata = {from:from, to:to};
        var ajaxurl =  urlroot + '/ajax/payments/';
        AjaxPostRequest(ajaxurl, postdata)
    })

    $(document).on('click', '#downloadxml', function(){
        var from  = $('#from').val();
        var to  = $('#to').val();
        var postdata = {from:from, to:to};
        var ajaxurl =  urlroot + '/ajax/paymentxml/';
        AjaxPostRequest(ajaxurl, postdata)
    })

    $(document).on('click', '.approvecustomer', function(){
        var bid =  $(this).attr('bid');
        var ajaxurl = '';
        var postdata = {bid:bid};

        if($(this).is(':checked') == true){
             ajaxurl =  urlroot + '/ajax/approvecustomer';
              var redirectionurl=  urlroot + '/pages/customers';
            if(confirm('Do you want to  approve customer ?')) {
                AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
            }
        }

    })

    $(document).on('click', '.deletecustomer', function(){
        var bid =  $(this).attr('bid');

        var postdata = {bid:bid};

        ajaxurl =  urlroot + '/ajax/deletecustomer';
        var redirectionurl=  urlroot + '/pages/customers';
        if(confirm('Do you want to delete customer ?')) {
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
        }
    })


    $(document).on('click', '.deleteuserrole', function(){
        var role = $(this).attr('role');
        var userid = $(this).attr('userid');
        var ajaxurl =  urlroot + '/ajax/deleteuserrole';
        var redirectionurl =  urlroot + '/pages/edituser/'+userid;
        var postdata = {role:role, userid:userid}
        if(confirm('Do you want to delete role  ?')){
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl);
        }

    })

    $(document).on('click', '.deleteuser', function(){
        var userid = $(this).attr('userid');
        var ajaxurl =  urlroot + '/ajax/deleteuser';
        var redirectionurl =  urlroot + '/pages/users/';
        var postdata = {userid:userid}
        if(confirm('Do you want to delete user?')){
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl);
        }

    })

    $(document).on('click', '.deletepayment', function(){

        var bid =  $(this).attr('bid');
        var payid =  $(this).attr('payid');

        var postdata = {payid:payid};

        ajaxurl =  urlroot + '/ajax/deletepayment';
        var redirectionurl=  urlroot + '/pages/customerprofile/'+ bid;
        if(confirm('Do you want to delete payment ?')) {
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
        }

    })

    $(document).on('click', '.viewtransactions', function(){

        $('#viewmodal').modal('show');
        var code =  $(this).attr('code');
        var postdata = {code:code};
        ajaxurl =  urlroot + '/ajax/viewtransactions';
        AjaxPostRequest(ajaxurl, postdata)
    })


    $('#searchproductname').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: urlroot + "/invoicing/searchproduct",
                type: 'GET',
                dataType: "json",
                data: {
                    term: request.term,
                    request: 'search'
                },
                success: function(data) {
                    console.log(data);
                    response($.map(data, function(item) {
                        return {
                            label: item.productname,
                            value: item.productid
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label); // display the selected text
            var productid = ui.item.value; // selected value
            console.log(productid);
            $('#productid').val(productid)
            return false;
        },
        minLength: 2
    });

    $(document).on('click', '.deletecart', function(){
        var cartid =  $(this).attr('cartid');
        var postdata = {cartid: cartid};
        var ajaxurl =  urlroot + '/ajax/deletecart';
        var redirectionurl =  urlroot + '/invoicing/create';
        AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
    })

    $(document).on('click', '.deletecategory', function(){
        var catid =  $(this).attr('catid');
        var postdata = {catid: catid};
        var ajaxurl =  urlroot + '/ajax/deletecategory';
        var redirectionurl =  urlroot + '/pages/categories';
        if(confirm('Do you want to delete category ?')) {
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
        }
    })

    $(document).on('click', '.deletevproduct', function(){
        var productid =  $(this).attr('productid');
        var postdata = { productid : productid};
        var ajaxurl =  urlroot + '/ajax/deleteproduct';
        var redirectionurl =  urlroot + '/pages/products';
        if(confirm('Do you want to delete product ?')) {
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
        }
    })

    $(document).on('change', '#discountval', function(){
        var discount = $(this).val();
        var postdata = {discount:discount};
        var ajaxurl =  urlroot + '/ajax/discountcalculator';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data : postdata,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI();
            },
            success: function (text) {
                console.log(text)
                $('#discountamount').val(text.discountamount);
                $('#afterdiscount').val(text.afterdiscount);
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    })

    $(document).on('focusout', '#amountpaid', function(){
        var amountpaid = $(this).val();
        var afterdiscount = $('#afterdiscount').val();
        var balance = amountpaid - afterdiscount;
        $('#balance').val(balance);
    })

    $(document).on('change', '#categoryid', function(){
        var category = $('option:selected', this).attr('catname');
        if(category == 'Accessories'){
            $('#packquantity').val();
        }else if(category == 'Profiles') {
            $('#packquantity').val(6);
        }else if(category == 'Glass') {
            $('#packquantity').val(2);
        }
    })



})