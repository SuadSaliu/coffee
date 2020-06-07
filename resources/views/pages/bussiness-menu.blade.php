@extends('frontend.appother')

@section('content')
<?php $currency =  setting_by_key("currency"); ?>
<!-- Header Area Start 
    ====================================================== -->
<section class="banner-sec internal-banner" style="background-image:url(assets/frontend/img/menu-page.jpg)">

    <!-- Start: slider-overview -->
    <div class="balck-solid">

        <!-- Start: slider -->
        <div class="container">
            <div class="banner-mid-text internal-header">

                <!-- Start: flexslider -->
                <div class="flexslider">
                    <ul>
                        <!-- Start: flexslider-one -->
                        <li>
                            <h2>Our menu</h2>
                            <div class="hr-outtr-line">
                                <hr><i class="fa fa-heart" aria-hidden="true"></i>
                                <hr>
                            </div>
                        </li>
                        <!-- End: flexslider-one -->
                    </ul>
                </div>
                <!-- End: flexslider -->

            </div>
        </div>
        <!-- End: slider -->

    </div>
    <!-- End: slider-overview -->
</section>
<!-- =================================================
    Header Area End -->


<!-- Reservation  Area Start 
    ====================================================== -->
<section class="resrvation-top-area our-top-sec" id="Welcome">

    <div class="container text-center">
        <div class="row">
            <h2><span>real taste</span>categories</h2>
            <div class="hr-outtr-line">
                <hr><i class="fa fa-heart" aria-hidden="true"></i>
                <hr>
            </div>
        </div>
    </div>
</section>
<!-- =================================================
    AReservation Area End -->


<!--  Amenities  Area Start 
    ====================================================== -->
<section class="our-menu-bg bussiness" id="{!! $bussiness_id ?? '' !!}">
    <div class="container">
        <div class="row">

            <!-- Start: Our-menu-Mains************************Section-one -->
            <div class="our-menu-details">

                <div class="col-xs-12 col-sm-2 col-lg-2 bg-grey menu-list no-pad">
                    <h5 class="mb-0">Categories</h5>
                    <ul class="categories">
                        <li class="fil-cat active" data-rel="all">All</li>
                        @foreach($categories as $cat)
                            <li style="cursor:pointer;" class="fil-cat" data-rel="{{$cat->id}}">{{$cat->name}}</li>
                        @endforeach

                    </ul>
                </div>

                <!-- Start: Our-menu-one -->
                <div class="col-xs-12 col-sm-7 col-lg-7" id="portfolio"></div>

                <div class="col-xs-12 col-sm-3 col-lg-3 bg-grey menu-list no-pad">
                    <h5>Your Order <i class="fa fa-shopping-cart white pull-right"></i></h5>
                    <ul id="CartHTML">
                        <li class="list-pad">VAT(<?php echo setting_by_key("vat"); ?>%) &ensp;<span class="pull-right">
                                0.00</li>
                        <li class="list-pad">Delivery Fee &ensp;<span class="pull-right">0.00</li>
                    </ul>

                    <a type="submit" id="modalBtn"
                        class="btn addTo-cart btn-group-justified" value="">Checkout</a>
                </div>
            </div>
            <!-- End: Our-menu-Mains -->

        </div>
    </div>
</section>
<!-- =================================================
    Amenities  Area End -->

<div id="myModal" class="modal fade cusModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center sub-heading1">Ready to get started</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 form-group">
                    <div style="color:red" id="errors"> </div>
                </div>
                <div class="col-sm-6 col-lg-6 form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off"
                        data-field_type="input">
                </div>
                <div class="col-sm-6 col-lg-6 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="col-sm-6 col-lg-6 form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                </div>
                <div class="col-sm-6 col-lg-6 form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" id="address" name="company" placeholder="Company">
                </div>
                <?php $stripe_payment = setting_by_key("stripe"); 
							if($stripe_payment == "yes") { 
						?>
                <div class="col-sm-6 col-lg-6 form-group">
                    <div class="radio">
                        <label><input type="radio" class="payment_option" checked value="cash" name="payment">Cash On
                            Delivery</label>
                    </div>
                    <!-- <label>Cash On Delivery</label>
							<input type="radio" class="form-control payment_option" checked  value="cash" name="payment" > -->
                </div>
                <div class="col-sm-6 col-lg-6 form-group">
                    <div class="radio">
                        <label><input type="radio" class="payment_option" value="card" name="payment">Pay with
                            Debit/Credit Card</label>
                    </div>
                    <!-- <label>Pay with Debit/Credit Card</label>
							<input type="radio" class="form-control payment_option"  value="card" name="payment" > -->
                </div>
                <input type="hidden" value="" id="payment_type" />
                <input type="hidden" value="" id="total_cost" />
                <span id="card_form">
                    <div class="col-sm-12 col-lg-12 form-group">
                        <label>Card Number</label>
                        <input type="text" class="form-control" id="cc_number" name="company" placeholder="Card Number">
                    </div>

                    <div class="col-sm-3 col-lg-4 form-group">
                        <label>Expiry Month</label>
                        <select class="form-control" id="cc_month">
                            @for($i = 1; $i<=12; $i++) <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-sm-3 col-lg-4 form-group">
                        <label>Expiry Year</label>
                        <select class="form-control" id="cc_year">
                            @for($i = date('Y'); $i<= date('Y') + 6; $i++) <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                        </select>
                    </div>

                    <div class="col-sm-4 col-lg-4 form-group">
                        <label>CC Code</label>
                        <input type="text" class="form-control" id="cc_code" name="company" placeholder="Card Number">
                    </div>
                </span>
                <?php } ?>


                <div class="col-sm-12 col-lg-12 form-group">
                    <label>Comment</label>
                    <textarea class="form-control" rows="2" placeholder="Message" id="comment"
                        name="message"></textarea>
                </div>
                <input type="hidden" id="vat" class="form-control" value="0.00">
                <input type="hidden" id="delivery_cost" class="form-control"
                    value="<?php echo setting_by_key("delivery_cost"); ?>">

                <div class="col-sm-6">
                    <div class="col-xs-12 col-sm-12">
                        <button type="cancel" class="btn submit-btn col-sm-12" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-xs-12 col-sm-12">
                        <button type="submit" class="btn submit-btn col-sm-12 ConfirmOrder">Complete</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<link href="{{url('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{url('assets/js/lodash.min.js')}}"></script>

<style>
    .ml-2 {
        margin-left: 10px;
    }

    .prevPage,
    .nextPage {
        cursor: pointer;
        user-select: none;
    }

    .prevPage.disabled,
    .nextPage.disabled {
        opacity: 0;
        pointer-events: none;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .fil-cat.active {
       background: rgba(89, 89, 89, 0.9)
    }

    .no_products {
        text-align: center;
        margin-top: 2em;
    }
</style>

<script type="text/javascript">

const currency = "<?php echo $currency;?>";

let current_page = 1;
let last_page = 1;
let category = null; 

let getProductHtml = function(product) {
    
    const titles = JSON.parse(product.titles);
    const prices = JSON.parse(product.prices);

    let priceHtml = '';

    titles.forEach((t, key) => {
        const price = prices[key] || '';
        const title = t || '';
        priceHtml += `<div class="or-rgt-menu col-xs-12 col-sm-3">
                        <h1>${title} <strong class="pull-right">${currency} ${price}</strong></h1>
                        <h2 style="cursor:pointer;" class="AddToCart" data-price="${price}"
                            data-id="${product.id}" data-key="${key}" data-size="${title}"
                            data-name="${product.name}">+</h2>
                    </div>`;
    });

    return `<div class="clearfix ${product.category_id} all marginBtn">
                <div class="col-sm-2"><img loading="lazy" class="img-circle" width="100"
                    src="${location.origin}/uploads/products/${product.bussiness_id}/thumb/${product.id}.jpg" class="img-responsive">
                </div>

                <div class="or-lft-menu col-sm-7">
                    <h5><span>${product.name}</span></h5>
                    <p class="hidden-xs">${product.description}</p>
                </div>

                ${priceHtml}
                
            </div>`;
}

let showProducts = function(products) {
    const emtpyHtml = '<div class="no_products">There are no products.</div>';
    try {
        if (!products || !products.data || products.data.length === 0) {
            $("#portfolio").html(emtpyHtml);
            return;    
        }

        last_page = products.last_page;

        let productHtmlCollection = '';
        products.data.forEach(p =>
            productHtmlCollection += getProductHtml(p)
        );

        const pagHtml = `<nav aria-label="pagination">
            <ul class="pager">
                <li><a class="prevPage ${current_page === 1 ? 'disabled' : ''}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Previous</a></li>
                <li class="ml-2"><a class="nextPage ${current_page === last_page ? 'disabled' : ''}">Next <i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
            </ul>
        </nav>`;

        productHtmlCollection += pagHtml;

        $("#portfolio").html(productHtmlCollection); 
    } catch (error) {
        $("#portfolio").html(emtpyHtml);      
    }
}

let getProducts = function() {
    let url = `${location.origin}/api/products?page=${current_page}`;

    if (category) {
        url += `&category=${category}`;
    }

    var bussinessId = $('.bussiness').attr('id');
    if (bussinessId) {
        url += `&bussinessId=${bussinessId}`;
    }

    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: showProducts
    });
}

// ------------------------------------
const onShowProduct = function() {
    $("#portfolio").fadeTo(100, 0.1);  // Animate
    getProducts();
    setTimeout(function () { $("#portfolio").fadeTo(300, 1); }, 700);
}

$( document ).ready(function() {
    onShowProduct();

    $(".fil-cat").on("click", function() {
        $(".fil-cat.active").removeClass('active');
        $(this).addClass('active');
        const catValue = $(this).attr("data-rel");
        category = catValue === 'all' ? null : catValue; 
        onShowProduct();
    });

    $("body").delegate(".prevPage", "click", function() {
        if (current_page <= 1) {
            return;
        }
        current_page--;
        onShowProduct();
    });

    $("body").delegate(".nextPage", "click", function() {
        if (current_page >= last_page) {
            return;
        }
        current_page++;
        onShowProduct();
    });

    $("#modalBtn").on("click", function() {
        if ($('#CartHTML li').length < 3) {
            return;
        }
        $("#myModal").modal("show");
    });
    
});

    

    $("#card_form").hide(100);
    $("body").on("click" , ".payment_option" , function() {
        if($(this).val() == "card") { 
            $("#card_form").show(100);
            $("#payment_type").val("card");
        } else { 
            $("#card_form").hide(100);
            $("#payment_type").val("cash");
        }
    });

    $("body").on("click" , ".ConfirmOrder" , function() {
        var msg = "";
        
        if(cart.length  < 1) {
            swal("Error" , "Cart is Empty" , "error");
            return false;
        }
        
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var comment = $("#comment").val();
        var msg = "";
        if(name == "") { 
            msg+= "Name is Required<br>";
        }
        
        if(email == "") { 
            msg+= "Email is Required<br>";
        }
        
        if(phone == "") { 
            msg+= "Phone is Required<br>";
        }
        if(address == "") { 
            msg+= "Address is Required<br>";
        }
        if(msg) { 
                swal("" , msg, "error");
                return false;
        }
        
        var form_data = {
                name: name,
                email: email,
                phone: phone,
                address: address,
                comment: comment,
                type: "order",
                status: 2,
                delivery_cost: $("#delivery_cost").val(),
                vat: $("#vat").val(),
                payment_with: $("#payment_type").val(),
                cc_number: $("#cc_number").val(),
                cc_month: $("#cc_month").val(),
                cc_year: $("#cc_year").val(),
                cc_code: $("#cc_code").val(),
                total_cost: $("#total_cost").val(),
                items: _.map(cart, function(cart){
                    return {
                        product_id: cart.product_id,
                        size: cart.size,
                        quantity: cart.quantity,
                        price: cart.price
                    }
                })
        };
        
        $(".ConfirmOrder").html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i>');
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo url("sales/online_order"); ?>',
            data: form_data,
            success: function (msg) {
                var obj = $.parseJSON(msg);
                if(obj['error'] == 1) {
                    swal(
                        'Oops...', obj['message'], 'error'
                    )
                $("#payment_message").html(obj['message']);
                    return false;
                }
                    
                $("#myModal").modal("hide");
               
                cart = [];
               
                $("#comments").val("");
                $(".ConfirmOrder").html('Order Confirm');
                swal({
                        title: '',
                        type: 'success',
                        text: obj['message']
                })
                    $("#name").val("");
                    $("#email").val("");
                    $("#phone").val("");
                    $("#address").val("");
                    $("#comment").val("");

                show_cart();
            },
            error: function () {
                swal(
                    'Error!', 'An error occurred while checkout products, please try again', 'error'
                )
                $(".ConfirmOrder").html('Order Confirm');
            }
        });
                
    });

    var products = new Array();
    var cart = new Array();
    $("body").on("click" , ".AddToCart" , function() {
        var ids = _.map(cart, 'id');
        var item = {
            id : $(this).attr("data-id") + $(this).attr("data-key"),
            product_id : $(this).attr("data-id"),
            price : $(this).attr("data-price"),
            size : $(this).attr("data-size"),
            name : $(this).attr("data-name")
        };
            
        if (!_.includes(ids, item.id)) {
            item.quantity = 1;
            item.p_qty = 1;
            cart.push(item);
        } else {
            var index = _.findIndex(cart, item);
                cart[index].quantity = cart[index].quantity + 1
        }
        

    //toastr.success('Successfully Added to Cart')            
    show_cart();    
            
});


$("body").on("click" , "#ClearCart" , function() {
    var cart = [];
    $(".TotalAmount").html(0);
    $("#CartHTML").html("");
});

$("body").on("click" , ".DecreaseToCart" , function() {
    var item = {
        id : $(this).attr("data-id")
    };
    var index = _.findIndex(cart, item);

    (cart[index].quantity == 1) ?
        deleteItemFromCart(item) :
        cart[index].quantity = cart[index].quantity - 1;

    //console.log(cart[index].quantity);
    //toastr.success('Successfully Updated')       
    show_cart();            
});

$("body").on("click" , ".IncreaseToCart" , function() {	
    var item = {
        id : $(this).attr("data-id")
    };
    var index = _.findIndex(cart, item);
    cart[index].quantity = cart[index].quantity + 1;        
    show_cart();            
});

$("body").on("click" , ".DeleteItem" , function() {
    var item = {
        id : $(this).attr("data-id")
    };    

    deleteItemFromCart(item);
});

$("body").on("click" , ".DiscountItem" , function() {
                
});

function deleteItemFromCart(item) { 
    var index = _.findIndex(cart, item);
    cart.splice(index, 1);
    show_cart();
}

function show_cart() { 
    if(cart.length > 0) { 
    var qty = 0;
    var total = 0;
    var cart_html = "";
        var obj = cart; 
                
            $.each( obj, function( key, value ) {

                    
                cart_html += '<li><span style="cursor:pointer;"><i data-id=' +  value.id + ' class="fa fa-minus-circle DecreaseToCart" aria-hidden="true"></i>&ensp;<i data-id=' +  value.id + ' class="fa fa-plus-circle IncreaseToCart" aria-hidden="true"></i></span>&ensp;<span class="">' + value.quantity +'x</span> ' + value.name + '<span class="pull-right" style="cursor:pointer;">'+ value.price + ' <i class="fa fa-times-circle-o fa-lg DeleteItem" data-id=' +  value.id + '></i></span></li>';

                qty = Number(value.quantity);
                total = Number(total) + Number(value.price * qty);
                
            });
            
            cart_html += '<li class="list-pad">Subtotal &ensp;<span class="pull-right TotalAmount"><?php echo $currency; ?> '+ total +'</li>';
                cart_html += '<li>Delivery Fee &ensp;<span class="pull-right"><?php echo $currency; ?><?php echo setting_by_key("delivery_cost"); ?></li>';
                var vat = (Number(total) * <?php echo setting_by_key("vat"); ?>)/100;
                cart_html += '<li>+ VAT (<?php echo setting_by_key("vat"); ?>%) &ensp;<span class="pull-right"><?php echo $currency; ?>' + vat + '</li>';
                var total_cost = Number(total) + <?php echo setting_by_key("delivery_cost"); ?> +  vat;
                cart_html += '<li class="list-pad">Total &ensp;<span class="pull-right bigTotal"><?php echo $currency; ?>'+ total_cost +'</li>';
                
            $("#vat").val(vat);
            
            // cart_html += '<div class="panel-footer"> Total Items' ;
            // cart_html += '<span class="pull-right"> ' + qty ;
            // cart_html += '</span></div>' ;
            
            
            $("#CartHTML").html("");
            $("#total_cost").val(total_cost);
            $("#CartHTML").html(cart_html);
} else { 
    $(".TotalAmount").html(0);
    $("#CartHTML").html("");

    var empty_card = '<li class="list-pad">VAT(<?php echo setting_by_key("vat"); ?>%) &ensp;<span class="pull-right">0.00</li><li class="list-pad">Delivery Fee &ensp;<span class="pull-right">0.00</li>'
    $("#CartHTML").html(empty_card);
}
        
}
</script>


@endsection