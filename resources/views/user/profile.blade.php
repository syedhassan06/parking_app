@extends('layouts.master')
@section('styles')
    {{Html::style('style.css')}}
@endsection

@section('content')
    <div class="content-header row">
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <ul class="nav nav-pills nav-pill-toolbar nav-justified d-print-none">
                            <li class="nav-item">
                                <a class="nav-link active" id="active2-pill1" data-toggle="pill"
                                   href="#profile"
                                   aria-expanded="true"><i class="icon-user"></i>YOUR PROFILE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="opt2" data-toggle="pill"
                                   href="#password"
                                   aria-expanded="true"><i class="icon-key"></i>CHANGE PASSWORD</a>
                            </li>

                        </ul>
                        <form class="form form-horizontal" novalidate action="{{route('update_profile')}}" method="POST">
                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active animated zoomIn" id="profile"
                                 aria-labelledby="active2-pill1"
                                 aria-expanded="true">
                                <div class="card-body order-content">
                                        {{ csrf_field() }}
                                        <div class="form-body">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control required" for="first_name">Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="name" class="form-control"
                                                           placeholder="Name" name="name" value="{{ old('name', $user->name) }}" required >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control required" for="email">E-mail</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="email" class="form-control"
                                                           placeholder="E-mail" name="email" value="{{ old('email', $user->email) }}" required  >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="contacts">Contact Number</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="contacts" class="form-control"
                                                           placeholder="Contact Number" name="contacts" value="{{ old('contacts', $user->contacts) }}">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="dropping_address">
                                                    Address</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="address" class="form-control"
                                                           placeholder="Address" name="address"  value="{{ old('address', $user->address) }}">
                                                </div>
                                            </div>

                                        </div>
                                        {{----}}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated zoomIn" id="password"
                                 aria-labelledby="opt2"
                                 aria-expanded="true">
                                <div class="card-body order-content">
                                    <div class="form-body">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="password">New Password</label>
                                                <div class="col-md-9">
                                                    <input type="password" id="password" class="form-control"
                                                           placeholder="New Password" name="password" ro >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="cpassword">Confirm Password</label>
                                                <div class="col-md-9">
                                                    <input type="password" id="cpassword" class="form-control"
                                                           placeholder="Confirm Password" name="cpassword" data-validation-match-match="password"
                                                           minlength="6"
                                                    >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>
                        </div>
                            <div class="form-actions text-right">

                                <button type="submit" class="btn btn-primary">
                                     <i class="la la-check-square-o"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('scripts')
    {{Html::script('dist/js/pages/jquery.repeater.min.js')}}
    <script>

        var ukDashboard;

        ukDashboard = (function () {
            var _this;
            return {
                rowIndex: null,
                order: {
                    productDetails: [],
                    removedProduct: {repeaterDeleteInstance: null, element: null},
                    total: 0,
                    discount: 0,
                    netTotal: 0,
                    qtyTotal: 0
                },
                resetOrder: function () {
                    _this.updateProductDetails();
                    _this.order.total = 0;
                    _this.order.netTotal = 0;
                    _this.order.discount = 0;
                    _this.order.qtyTotal = 0;
                },
                calculateTotal: function () {
                    var total = 0, qty = 0, salesPrice = 0;
                    _this.resetOrder();
                    //console.log("_this.order.productDetails instanceof Array", _this.order.productDetails instanceof Array);

                    console.log(_this.order.productDetails);
                    if (_this.order.productDetails instanceof Array) {
                        console.log("_this.order", _this.order);
                        $.each(_this.order.productDetails, function (index, item) {
                            qty = cleanNumber(item.qty);
                            salesPrice = cleanNumber(item.price);
                            item.product_total = qty * salesPrice;
                            $(".product-table").find("tr.product-item").eq(index).find('.product_total').val(numberFormat(item.product_total));
                            _this.order.total += qty * salesPrice;
                            _this.order.qtyTotal += qty;
                            console.log(_this.order.total)

                        });
                    } else {
                        _this.order.total = 0;
                        _this.order.qtyTotal = 0;
                    }
                    console.log(_this.order)
                    _this.calculateDiscount();
                    _this.stockAvailability();
                    $(".order-total").html(numberFormat(_this.order.total));
                    $(".order-net-total").html(numberFormat(_this.order.netTotal));
                },
                productRepeater: function () {

                    var productRepeater = $(".product-repeater").repeater({
                        show: function (e) {
                            $(this).slideDown();
                            //redraw select2
                            $(this).find('.select2-container').remove();
                            AppSetting.initSelect($(this).find('.product_id'));
                            AppSetting.initTouchspin($(this).find('.qty'), 'vertical');

                            $(this).find('td').fadeIn(700, 'swing');
                            _this.updateProductDetails();

                        },
                        hide: function (deleteElement) {
                            _this.order.removedProduct = $.extend({}, _this.order.removedProduct, {
                                repeaterDeleteInstance: deleteElement,
                                element: $(this)
                            });
                            $("#confirmModal").modal("show");

                        },
                        initEmpty: true
                    });
                    if (orderForm.items) {
                        orderForm.items = orderForm.items.map(function (item) {
                            item.sales_price = numberFormat(item.sales_price);
                            return item
                        });
                    }
                    productRepeater.setList(orderForm.items);
                    setTimeout(function () {
                        $(".qty").trigger('blur');
                    }, 200);


                },
                removeProduct: function () {
                    $("#confirmModal").modal("hide");
                    $(_this.order.removedProduct.element).find('td').fadeOut(500, 'swing', function () {
                        if ($(this).is(':last-child')) {
                            _this.order.removedProduct.repeaterDeleteInstance();
                            _this.updateProductDetails();
                            _this.calculateTotal();
                            _this.order.removedProduct.element = null;
                            _this.order.removedProduct.repeaterDeleteInstance = null;
                        }
                    });
                },
                onSelectProduct: function () {
                    var id = $(this).val(),
                        trElement = $(this).closest("tr"),
                        product = productList.filter(function (item) {
                            return item.id == id;
                        });
                    if (product.length > 0) {
                        product = product[0];
                        trElement.find("input.sales-price").val(numberFormat(product.product_retail_price));
                    }
                    _this.calculateTotal();
                },
                attachHandler: function () {
                    $(".product-table").on("keyup change", ".price,.qty,.order-discount", _this.calculateTotal);
                    $(".product-table").on("change", ".product_id", _this.onSelectProduct);
                    $("body").on("click", ".remove-product-btn", _this.removeProduct);
                },
                init: function () {
                    var _this = this;
                    _this.attachHandler();
                }
            }
        })().init;
    </script>

@endsection
