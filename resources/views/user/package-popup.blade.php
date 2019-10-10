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
                                <label class="col-md-3 label-control input-label">User Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control customer_name"
                                           value="" disabled>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control input-label" for="package_id">Package <span
                                            class="required">*</span></label>
                                <div class="col-md-9">
                                    <select name="package_id" id="package_id" class="app-select2 form-control package_id"
                                            data-msg-required="Package is required"
                                            data-placeholder="Select"
                                            required>
                                        <option></option>
                                        @if(count($packages)>0)
                                            @foreach($packages as $package)
                                                <option value="<?= $package->id ?>"
                                                        @if ( in_array($package->id ,[Input::old('package_id'),'false'] )) selected="selected" @endif>{{ucwords($package->name)}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control required input-label">{{trans('general.activationDate')}}</label>
                                <div class="col-md-9">
                                    <input id="activation_date" data-msg-required="Activation Date is required" type="text" required class="form-control pickadate activation_date"
                                           name="activation_date" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-3 label-control required input-label">{{trans('general.packageRate')}}</label>
                                <div class="col-md-9">
                                    <input id="package_rate" data-msg-required="Package Rate is required" type="text" required class="form-control allownumericwithdecimal package_rate"
                                           name="package_rate" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row package-details d-none">
                            <h3 class="text-center text-bold-500 mb-2 d-block col-md-12">Current Plan <i class="la la-file-text-o font-large-1"></i> </h3>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">User Name</label>
                                <div class="col-md-7">
                                    <h4 class="pad-5 text-bold-600 m-0 blue-grey darken-2 font-medium-1 user_id"></h4>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Package</label>
                                <div class="col-md-7">
                                    <h4 class="pad-5 text-bold-600 m-0 blue-grey darken-2 font-medium-1 package_id"></h4>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">{{trans('general.activationDate')}}</label>
                                <div class="col-md-7">
                                    <h4 class="pad-5 text-bold-600 m-0 blue-grey darken-2 font-medium-1 activation_date"></h4>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-2 row">
                                <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">{{trans('general.packageRate')}}</label>
                                <div class="col-md-7">
                                    <h4 class="pad-5 text-bold-600 m-0 blue-grey darken-2 font-medium-1 package_rate"></h4>
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
                        <button type="button" class="btn btn-blue btn-user-package btn-min-width box-shadow-2 float-right">Activate</button>
                        <button type="button" class="btn btn-blue btn-user-package-edit d-none btn-min-width box-shadow-2 float-right">Edit</button>
                        <button type="button" class="btn btn-blue btn-user-package-renewal d-none btn-min-width box-shadow-2 float-right">Renewal</button>
                        <button type="button" class="btn btn-danger btn-user-package-cancel d-none btn-min-width box-shadow-2 float-right mr-1">Cancel</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

@section('user.package-popup')
    <script>
        var customerPackage = (function(){
            var _this;
            return {
                selectedUser:null,
                selectedRow:null,
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
                    'activate':{'title':'Package Activation','icon':'la-gavel'},
                    'renewal':{'title':'Package Renewal','icon':'la-refresh'}
                },
                selectedModal:'activate',
                onSave:function(){
                    _this.formValidate();
                    var isValidate = $("#customer-package-form").valid();
                    if (isValidate) {
                        var data = {
                            user_id: _this.selectedUser.user_id,
                            package_id: $('#package_id').val(),
                            activation_date: $('#activation_date').pickadate('picker').get('select', 'yyyy-mm-dd'),
                            package_rate: cleanNumber($("#package_rate").val()),
                            type: _this.selectedModal

                        };
                        AppSetting.initBlockUI($("#user-package-modal-container"));
                        AppSetting.httpPost("{!! route('api_user_package') !!}", data)
                            .then(
                                function (res) {
                                    AppSetting.stopBlockUI($("#user-package-modal-container"));
                                    if (res && res.status) {
                                        _this.selectedRow.find('.user-package-activate-btn').addClass('d-none');
                                        _this.selectedRow.find('.user-package-renewal-btn').removeClass('d-none');
                                        $("#userPackageModal").modal("hide");
                                        AppSetting.growler('success',res.message);
                                        $("#vendor-table").DataTable().draw();
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
                populateUserDetails: function(modalType){
                    if(modalType=='renewal'){
                        $(".package-details, .btn-user-package-edit").removeClass("d-none");
                        $(".package-form, .btn-user-package").addClass("d-none");

                        $(".package-details .user_id").html(titleCase(_this.selectedUser.name));
                        if (_this.selectedUser.active_packages && _this.selectedUser.active_packages.length>0){
                            var activationDate = _this.selectedUser.active_packages[0].pivot.activation_date,
                                dateInstance = moment(activationDate);
                            $(".package-details .package_id").html(_this.selectedUser.active_packages[0].name);
                            if(dateInstance.isValid()){
                                $(".package-details .activation_date").html(dateInstance.format('DD MMMM, YYYY'));
                            }
                            $(".package-details .package_rate").html(numberFormat(cleanNumber(_this.selectedUser.active_packages[0].pivot.package_rate)));

                            $(".package-form .package_id").select2('val',_this.selectedUser.active_packages[0].id);
                            $(".package-form .package_rate").val(_this.selectedUser.active_packages[0].pivot.package_rate).trigger('blur');
                            $('#activation_date').pickadate('picker').set('select', activationDate,{format:'yyyy-mm-dd'}).trigger('blur');
                        }
                    }
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

                    }
                    else if(modalType=='renewal'){
                        _modalTitleSelector.find("i")
                            .removeClass(_this.modal.activate.icon)
                            .addClass(_this.modal.renewal.icon);

                        _modalSelector.addClass('bounceInLeft').removeClass('bounceInRight');
                        _modalSelector.find('.form-horizontal').addClass('form-bordered');
                        _modalSelector.find('.form-group').removeClass('mb-2');

                        _this.populateUserDetails(modalType);

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
                    _this.setUser();
                    _this.updateModal('activate');
                },

                setUser: function(){

                    var customerID = cleanNumber(_this.selectedRow.data('customer')),
                        users = AppSetting.datatable.dt.rows().data(),
                        filteredUser= null;

                    if(users.length > 0){
                        filteredUser = users.filter(function(item){
                          return item.user_id == customerID;
                        });
                        if(filteredUser){
                           _this.selectedUser = filteredUser[0];
                           $(".customer_name").val(titleCase(_this.selectedUser.name));
                        }
                    }
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