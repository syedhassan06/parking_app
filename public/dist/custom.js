var AppSetting;

function numberFormat(number, dp, currency) {
    if (isNaN(number))
        number = 0;

    if (dp == "" || typeof dp == "undefined") {

        dp = 2;

    }
    var a;
    if (currency && typeof currency == "string") {
        currency = currency ? (currency + " ") : "";
    } else {
        currency = "";
    }

    if (parseFloat(number) < 0) {

        a = Number(number).toFixed(dp).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(/-/, "($") + ")";

    } else {

        a = currency + Number(number).toFixed(dp).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    }

    return a;

}



function cleanNumber(num) {

    num = num + ' ';
    if (num.indexOf("(") > -1) {
        num = num.replace("(", "-");
    }
    num = Number(num.replace(/\D+$/g, "").replace(/[,| |\$]/g, '').replace(/[,| |\%]/g, ''));
    return isNaN(num) ? 0 : num;

}

function formatPercentage(number, dp) {

    dp = ( dp === undefined ? 0 : dp );

    if (!Number(number)) {

        return Number("0").toFixed(dp) + "%";

    }

    return Number(number).toFixed(dp) + "%";

}

function checkbox(data) {
    var checkbox = '<div class="text-center"><input class="checkbox multi-select" type="checkbox" name="val[]" value="' + data + '" /></div>';
    //AppSetting.initICheck(".multi-select");
    return checkbox;
}

(function (window, document, $) {
    AppSetting = function () {
        var _this = null,
            toastrConfig = {
                "progressBar": true,
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
                timeOut: 1000,
                "closeButton": true,
                preventDuplicates: true,
                hideEasing: 'swing',
                hideDuration: 500,
                showDuration: 500,
                timeOut: 2500
            },
            overlayConfig = {
                message: '<div class="ball-clip-rotate loader-primary"><div></div></div>',
                fadeIn: 700,
                fadeOut: 700,
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            };

        return {
            'formValidations': function () {
                // Input, Select, Textarea validations except submit button
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
                // Square Checkbox & Radio
                $('.skin-square input').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });
            },
            'initSelect': function (element, option) {
                var defaultOption = {
                    allowClear: true,
                    width: "100%"
                };
                defaultOption = $.extend({}, defaultOption, option);
                if ($(element).length > 0) {
                    return $(element).select2(defaultOption);
                } else {
                    return $(".app-select2").select2(defaultOption);
                }

            },

            'initFormWizard': function () {
                var form = $(".steps-validation").show();

                $(".steps-validation").steps({
                    headerTag: "h6",
                    bodyTag: "fieldset",
                    transitionEffect: "fade",
                    titleTemplate: '<span class="step">#index#</span> #title#',
                    labels: {
                        finish: 'Submit'
                    },
                    onStepChanging: function (event, currentIndex, newIndex) {
                        // Allways allow previous action even if the current form is not valid!
                        if (currentIndex > newIndex) {
                            return true;
                        }
                        // Forbid next action on "Warning" step if the user is to young
                        if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                            return false;
                        }
                        // Needed in some cases if the user went back (clean up)
                        if (currentIndex < newIndex) {
                            // To remove error styles
                            form.find(".body:eq(" + newIndex + ") label.error").remove();
                            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                        }
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onFinishing: function (event, currentIndex) {
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex) {
                        //alert("Submitted!");
                        form.submit();

                    }
                });

                $(".steps-validation").validate({
                    ignore: 'input[type=hidden]', // ignore hidden fields
                    errorElement: 'label',
                    errorClass: 'danger',
                    successClass: 'success',
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    errorPlacement: function (error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());      // radio/checkbox?
                        } else if (element.hasClass('select2-hidden-accessible')) {
                            error.insertAfter(element.closest('.form-group').find('.select2'));
                            //error.insertAfter(element.next('label'));  // select2
                        } else {
                            error.insertAfter(element);               // default
                        }
                    },
                    rules: {
                        email: {
                            email: true
                        }
                    }
                });

                $(".icons-tab-steps").steps({
                    headerTag: "h6",
                    bodyTag: "fieldset",
                    transitionEffect: "fade",
                    titleTemplate: '<span class="step">#index#</span> #title#',
                    labels: {
                        finish: 'Order Placed'
                    },
                    onFinished: function (event, currentIndex) {
                        //console.log("Form submitted.");
                        //console.log("event",event);
                        $("form.icons-tab-steps").submit();
                    }
                });

                // Initialize validation
            },
            growler: function (type, content, title, option) {
                var config = $.extend({}, toastrConfig, option);
                switch (type) {
                    case "success":
                        toastr.success(content, title, config);
                        break;
                    case "error":
                        toastr.error(content, title, config);
                        break;
                    case "warning":
                        toastr.warning(content, title, config);
                        break;
                    default:
                        toastr.info(content, title, config);

                }
            },
            initBlockUI: function (overlayWrapperElement) {
                overlayWrapperElement.block && overlayWrapperElement.block(overlayConfig);
            },
            stopBlockUI: function (overlayWrapperElement) {
                overlayWrapperElement.unblock && overlayWrapperElement.unblock();
            },
            initDatePicker: function (element) {
                var element = element || $('.pickadate'),
                    inputDate = element.pickadate({formatSubmit: 'dd/mm/yyyy'}),
                    picker = inputDate.pickadate('picker');

                picker && picker.set('select', $('.pickadate').data('dateval'), {format: 'yyyy-mm-dd'});
                //console.log("picker",picker);
                //console.log("d",$('.pickadate').data('dateval'));
                /**
                 $('.pickadate-format').pickadate({
                     // Escape any 'rule' characters with an exclamation mark (!).
                     format: 'Selecte!d Date : dddd, dd mmmm, yyyy',
                     formatSubmit: 'mm/dd/yyyy',
                     hiddenPrefix: 'prefix__',
                     hiddenSuffix: '__suffix'
                });
                 * */
            },
            initTouchspin: function (element, type) {
                var element = element || $(".touchspin");
                if (type == 'vertical') {
                    element.TouchSpin({
                        verticalbuttons: true,
                        verticalupclass: 'la la-chevron-up',//la-angle-up
                        verticaldownclass: 'la la-chevron-down', //la la-angle-down
                        buttondown_class: "btn btn-primary",
                        buttonup_class: "btn btn-primary",
                    });
                } else {
                    element.TouchSpin({
                        buttondown_class: "btn btn-primary",
                        buttonup_class: "btn btn-primary",
                        buttondown_txt: '<i class="ft-minus"></i>',
                        buttonup_txt: '<i class="ft-plus"></i>'
                    });
                }

            },
            attachHandler:function(){
                $(document).click(function (e) {
                    e.stopPropagation();
                    var container = $(".dropDown");

                    //check if the clicked area is dropDown or not
                    if (container.has(e.target).length === 0) {
                        $('.subMenu').hide();
                    }
                })
            },
            httpPost: function (url, data) {
                var request = $.ajax({
                    cache: false,
                    url: url,
                    dataType: "json",
                    type: "post",
                    data: data
                });
                return request;
            },
            'init': function () {
                _this = this;
                _this.formValidations();
                _this.initFormWizard();
                _this.initSelect();
                _this.initDatePicker();
                _this.initTouchspin();

            }
        };
    }();
    AppSetting.init();

    AppSetting.icheck = (function () {
        var _this;
        return {
            build: function () {
                var colorSchemeCSSClass = ['orange', 'pink'],
                    iteratedSelector = "";
                _this.create("input[type='checkbox']");

                $.each(colorSchemeCSSClass, function (index, color) {
                    iteratedSelector = $("input[type='checkbox']").filter("." + color);

                    _this.create(iteratedSelector, {
                        checkboxClass: 'icheckbox_square-' + color,
                        radioClass: 'iradio_square-' + color
                    });
                });
            },
            create: function (selector, _config) {
                _config = $.extend({}, {
                    checkboxClass: 'icheckbox_square-blue',
                    handle: 'checkbox',
                    radioClass: 'iradio_square-blue'
                }, _config);
                $(document).find(selector).iCheck(_config);
                $('input').iCheck('update');
            },

            onCheckedDatatable:function(event){
                $('.checkth, .checkft').iCheck('check');
                $('.multi-select').each(function () {
                    $(this).iCheck('check');
                    $(this).closest("tr").toggleClass("selected");
                });
            },
            onUnCheckedDatatable:function(event){
                $('.checkth, .checkft').iCheck('uncheck');
                $('.multi-select').each(function () {
                    $(this).iCheck('uncheck');
                    console.log($(this).closest("tr"));
                    //$(this).closest("tr").toggleClass("selected");
                });
            },
            onUnCheckedDatatableCell:function(event){
                console.log("cell-changed")
                $('.checkth, .checkft').prop('checked', false);
                $('.checkth, .checkft').iCheck('update');
            },
            onToggleCheckbox:function(event){
                var status = $(this).prop('checked');
                $(this).val(status ? 1 : 0);
            },
            onToggleDatatableCell:function(event){
                var checked = $(this).prop("checked");
                console.log("checked",checked)
                $(this).closest("tr").toggleClass("selected");
                if(checked){
                    $(this).closest("tr").addClass("selected");
                }else{
                    $(this).closest("tr").removeClass("selected");
                }
            },
            attachHandler : function(){
                $(document).on('ifChecked', '.checkth, .checkft', _this.onCheckedDatatable);

                $(document).on('ifUnchecked', '.checkth, .checkft', _this.onUnCheckedDatatable );

                $(document).on('ifUnchecked', '.multi-select', _this.onUnCheckedDatatableCell );
                $(document).on('ifToggled', '.multi-select', _this.onToggleDatatableCell );

                $('body').on('ifToggled', '.toggle-chkbox,.toggle-radio', _this.onToggleCheckbox);
            },
            init: function () {
                console.log("CHECKBOX")
                _this = this;
                _this.build();
                //_this.attachHandler();
            }
        };
    })();
    AppSetting.icheck.init();

    AppSetting.datatable = (function () {
        var _this;
        return {
            dt:null,
            config: {
                //"scrollX": true,
                //scrollCollapse: true,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[3, 10, 25, 50, 100], [3, 10, 25, 50, 100]],
                "order": [[ 1, "asc" ]],
                "paging": true,
                "deferRender": true,//For speed
                //"responsive": true,
                "initComplete": function (settings, json) {
                    //$('.dataTables_scrollBody thead tr').hide();
                    //$('.dataTables_scrollBody thead tr').show();
                    //$('.dataTables_scrollFoot').css({ display: 'none' });
                    //$('div.loading').remove();
                },
                ajax: function (data, callback, settings) {
                    $.ajax({
                        url: '/your/url',
                        type: 'POST',
                        data: data,
                        success: function (data) {
                            callback(data);
                            // Do whatever you want.
                        }
                    });
                },
                "ajax": {
                    "type": "GET",
                    "url": "ajax.php",
                    "dataSrc": function (json) {
                        //Make your callback here.
                        alert("Done!");
                        return json.data;
                    }
                },
                "drawCallback": function (settings) {
                    //console.log(settings.json);
                    AppSetting.icheck.create("input[type='checkbox']");
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                    //console.log("_this",_this);
                    //$('.dataTables_scrollBody thead tr').hide();
                    //$('.dataTables_scrollBody tfoot tr').css({ display: 'none' });
                    //do whatever
                },
                columnDefs: [
                    {name:'action',sortable:false,targets: [-1]}
                    //{ targets: [{name:'action'}], sortable:false}
                ],
                language: {
                    //console.log("TEST");
                    //processing: '<div class="loader-container"> <div class="ball-scale-multiple loader-primary"> <div></div> <div></div> <div></div> </div> </div>'
                    processing: '<div class="reporting-loader-container"> <i class="la la-circle-o-notch spinner blue"></i><span class="loader-text">loading<span class="dot one">.</span><span class="dot two">.</span><span class="dot three">.</span></div> </div>'
                }

            },
            init: function (element, config) {
                _this = this;
                config = $.extend({}, _this.config, config);
                _this.dt= $(element).DataTable(config);
                return _this.dt;
                /*$('#loading').ajaxStart(function () {
                 $(this).show();
                 }).ajaxStop(function () {
                 $(this).hide();
                 });*/
            }
        };
    })();


})(window, document, jQuery);


