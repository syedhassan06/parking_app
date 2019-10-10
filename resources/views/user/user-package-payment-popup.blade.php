<div class="modal animated bounceInRight text-left " id="userPackageModal" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="user-package-modal-container">
            <div class="modal-header">
                <h2 class="modal-title"><i class="la la-gavel font-large-1 mr-1"></i><span>Package Activation</span></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="customer-package-form" class="form form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="col-md-12">

                        <div class="row package-form">
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control input-label" for="package_id">Package</label>
                                <div class="col-md-9">
                                    <input id="package_id" readonly class="form-control ">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control required input-label">Date</label>
                                <div class="col-md-9">
                                    <input id="activation_date" data-msg-required="Date is required" type="text" required class="form-control pickadate activation_date"
                                           name="activation_date" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control required input-label">Payment</label>
                                <div class="col-md-9">
                                    <input id="package_rate" data-msg-required="Payment is required" type="text" required class="form-control allownumericwithdecimal package_rate"
                                           name="package_rate" value="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer row border-top-0">
                    <div class=" col-md-12 border-top border-light pt-1">
                        <button type="button" class="btn btn-secondary btn-min-width box-shadow-2 mr-1 float-left"
                                data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-blue btn-user-package btn-min-width box-shadow-2 float-right">Save Changes</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

@section('user.user-package-payment-popup')
    <script>
        var customerPackage = (function(){
            var _this;
            return {
                selectedRow:null,
                userPackages : ({!! json_encode($userPackages) !!}),
                activatePackage : ({!! json_encode($activatePackage) !!}),
                selectedUser : ({!! json_encode($user) !!}),
                modalSelector:$("#userPackageModal"),
                validation:{
                    rules:{
                        //name:{required:true}
                    },
                    messages:{
                        //name:{required:"User name is required."}
                    }
                },
                modal: {
                    'activate':{'title':'Add Payment','icon':'la-money'},
                    'renewal':{'title':'Package Renewal','icon':'la-refresh'}
                },
                selectedModal:'activate',
                onSave:function(){
                    _this.formValidate();
                    var isValidate = $("#customer-package-form").valid();
                    if (isValidate) {
                        var data = {
                            user_package_id: _this.activatePackage.user_package_id,
                            payment_date: $('#activation_date').pickadate('picker').get('select', 'yyyy-mm-dd'),
                            payment_received: cleanNumber($("#package_rate").val()),
                            type: _this.selectedModal

                        };
                        AppSetting.initBlockUI($("#user-package-modal-container"));
                        AppSetting.httpPost("{!! route('api_package_payment') !!}", data)
                            .then(
                                function (res) {
                                    AppSetting.stopBlockUI($("#user-package-modal-container"));
                                    if (res && res.status) {
                                        _this.selectedRow.find('.user-package-activate-btn').addClass('d-none');
                                        _this.selectedRow.find('.user-package-renewal-btn').removeClass('d-none');
                                        var _date = $('#activation_date').val();
                                        var _rate = $("#package_rate").val();
                                        console.log(_this.activatePackage.package,
                                            _date,
                                            numberFormat(cleanNumber(_rate)));
                                        $("#users-contacts").DataTable().row.add([
                                            '<input type="checkbox" class="input-chk">',
                                            '<a href="javascript:void(0)">'+_this.activatePackage.package+'</a>',
                                            '<h6 class="m-0">'+_date+'</h6>',
                                            '<div class="text-right">'+numberFormat(cleanNumber(_rate))+'</div>'
                                        ]);
                                        setTimeout(function () {
                                            $("#users-contacts").DataTable().draw();
                                            AppSetting.icheck.init()
                                        },500);
                                        $("#userPackageModal").modal("hide");
                                        AppSetting.growler('success',res.message);
                                        _this.userPackages = res.data;

                                    }
                                },
                                function (err) {
                                    AppSetting.stopBlockUI($("#user-package-modal-container"));
                                }
                            );
                    }
                },
                onRenewal: function(){
                    _this.onSave();
                },
                formValidate:function(){
                    $("#customer-package-form").validate({
                        rules: _this.validation.rules,
                        errorElement: 'label',
                        messages: _this.validation.messages,
                        errorClass: 'error',
                        ignore: 'input[type=hidden],:not(select):hidden',
                        errorPlacement: function(error, element) {
                            element.closest('.form-group').addClass('error');
                            if (element.parent('.input-group').length) {
                                error.insertAfter(element.parent());      // radio/checkbox?
                            } else if (element.hasClass('select2-hidden-accessible')) {
                                error.insertAfter(element.closest('.form-group').find('.select2'));
                            } else {
                                error.insertAfter(element);               // default
                            }

                        }
                    });
                },
                cleanFormValidation: function(){
                    $("#customer-package-form")[0].reset();
                    $('.app-select2').val('').trigger('change');
                    $("#customer-package-form").validate().destroy();
                    $.each(['error-control','error','validate'],function (index, val) {
                        $('.'+val).removeClass(val);
                    });
                },
                validateFormControl:function(){
                    var valid = $(this).valid();
                },
                onDismissModal: function(){
                    _this.cleanFormValidation();
                    _this.resetUserDetails();
                    _this.selectedUser= null;
                    _this.selectedRow= null;
                    AppSetting.stopBlockUI($("#user-package-modal-container"));
                    $(".package-form, .btn-user-package.btn-user-package").removeClass('d-none');
                    $(".package-details, .btn-user-package-edit, .btn-user-package-cancel, .btn-user-package-renewal").addClass('d-none');
                },
                onCancel: function(){
                    $(".package-details,.btn-user-package-edit")
                        .removeClass('d-none');
                    $(".package-form,.btn-user-package-cancel,.btn-user-package-renewal")
                        .addClass('d-none');
                },
                onEditPackage: function(){
                    $(".package-details,.btn-user-package-edit")
                        .addClass('d-none');
                    $(".package-form,.btn-user-package-cancel,.btn-user-package-renewal")
                        .removeClass('d-none');
                },
                resetUserDetails: function(){
                    $(".package-details .activation_date,.package-details .user_id,.package-details .package_id,.package-details .package_rate")
                        .html('-');
                },
                updateModal: function(modalType){
                    _this.selectedModal = modalType;

                    var _modal = _this.modal[modalType],
                        _modalSelector = $("#userPackageModal"),
                        _modalTitleSelector = _modalSelector.find(".modal-title");

                    _modalTitleSelector.find("span").html(_modal.title);

                    if(modalType=='activate'){
                        _modalTitleSelector.find("i")
                            .removeClass(_this.modal.renewal.icon)
                            .addClass(_this.modal.activate.icon);

                        _modalSelector.addClass('bounceInRight').removeClass('bounceInLeft');
                        _modalSelector.find('.form-horizontal').removeClass('form-bordered');
                        _modalSelector.find('.form-group').addClass('mb-2');
                        $("#package_id").val(_this.activatePackage.package);
                    }
                    $('#userPackageModal').modal('show');

                },
                onShownRenewalModal: function(){
                    _this.selectedRow = $(this).closest('tr');
                    _this.setUser();
                    _this.updateModal('renewal');
                },
                onShownModal: function(){
                    _this.selectedRow = $(this).closest('tr');
                    _this.updateModal('activate');
                },
                attachEvents:function(){
                    $("body").on('click','.btn-user-package',_this.onSave);
                    $("select,.pickadate").on('change',_this.validateFormControl);
                    $("#userPackageModal").on('hidden.bs.modal',_this.onDismissModal);
                    $("body").on('click','.user-package-activate-btn',_this.onShownModal);
                    $("body").on('click','.user-package-renewal-btn',_this.onShownRenewalModal);
                    $("body").on('click','.btn-user-package-edit',_this.onEditPackage);
                    $("body").on('click','.btn-user-package-cancel',_this.onCancel);
                    $("body").on('click','.btn-user-package-renewal',_this.onRenewal);
                },
                init:function () {
                    _this = this;
                    _this.attachEvents();
                }

            };
        })().init();
    </script>
@endsection