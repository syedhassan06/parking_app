function _defineProperty(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}function numberFormat(e,t,a){isNaN(e)&&(e=0),0===t?t=0:""!=t&&void 0!==t||(t=2);return a=a&&"string"==typeof a&&a?a+" ":"",parseFloat(e)<0?Number(e).toFixed(t).toString().replace(/\B(?=(\d{3})+(?!\d))/g,",").replace(/-/,"(")+")":a+Number(e).toFixed(t).toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}function cleanNumber(e){return e+=" ",e.indexOf("(")>-1&&(e=e.replace("(","-")),e=Number(e.replace(/\D+$/g,"").replace(/[,| |\$]/g,"").replace(/[,| |\%]/g,"")),isNaN(e)?0:e}function formatPercentage(e,t){return t=void 0===t?0:t,Number(e)?Number(e).toFixed(t)+"%":Number("0").toFixed(t)+"%"}function formatQuantity(e){return null!=e?'<div class="text-center">'+numberFormat(e,0)+"</div>":""}function currencyFormat(e){return null!=e?'<div class="text-right">'+numberFormat(e,2)+"</div>":'<div class="text-right">0</div>'}function checkbox(e){return'<div class="text-center"><input class="checkbox multi-select" type="checkbox" name="val[]" value="'+e+'" /></div>'}function titleCase(e){return e=e||"","string"!=typeof e&&(e=String(e)),e.toUpperCase()==e?e:e.toLowerCase().replace(/(?:^|[\s-\/])\w/g,function(e){return e.toUpperCase()})}function row_status(e){return null==e?"":-1!=["pending","in-process"].indexOf(e)?'<div class="text-center"><span class="badge  badge-warning">'+titleCase(e)+"</span></div>":-1!=["designing"].indexOf(e)?'<div class="text-center"><span class="badge bg-purple bg-lighten-1 white">'+titleCase(e)+"</span></div>":-1!=["completed","paid","sent","received","stock-in","delivered"].indexOf(e)?'<div class="text-center"><span class="badge badge-success">'+titleCase(e)+"</span></div>":-1!=["ready"].indexOf(e)?'<div class="text-center"><span class="badge bg-teal bg-lighten-3 white">'+titleCase(e)+"</span></div>":-1!=["partial","transferring","ordered","dispatched"].indexOf(e)?'<div class="text-center"><span class="badge badge-info">'+titleCase(e)+"</span></div>":-1!=["due","returned","stock-out"].indexOf(e)?'<div class="text-center"><span class="badge badge-danger">'+titleCase(e)+"</span></div>":'<div class="text-center"><span class="badge badge-secondary">'+titleCase(e)+"</span></div>"}function twoDigitFormat(e){return e>9?""+e:"0"+e}function fld(e){var t={dateFormats:{js_sdate:"dd-mm-yyyy"}};if(null!=e){var a=e.split("-"),n=a[2].split(" ");return year=a[0],month=a[1],day=n[0],time=n[1],"dd-mm-yyyy"==t.dateFormats.js_sdate?day+"-"+month+"-"+year+" "+time:"dd/mm/yyyy"===t.dateFormats.js_sdate?day+"/"+month+"/"+year+" "+time:"dd.mm.yyyy"==t.dateFormats.js_sdate?day+"."+month+"."+year+" "+time:"mm/dd/yyyy"==t.dateFormats.js_sdate?month+"/"+day+"/"+year+" "+time:"mm-dd-yyyy"==t.dateFormats.js_sdate?month+"-"+day+"-"+year+" "+time:"mm.dd.yyyy"==t.dateFormats.js_sdate?month+"."+day+"."+year+" "+time:e}return""}function fsd(e){var t={dateFormats:{js_sdate:"dd-mm-yyyy"}};if(null!=e){var a=e.split("-");return"dd-mm-yyyy"==t.dateFormats.js_sdate?a[2]+"-"+a[1]+"-"+a[0]:"dd/mm/yyyy"===t.dateFormats.js_sdate?a[2]+"/"+a[1]+"/"+a[0]:"dd.mm.yyyy"==t.dateFormats.js_sdate?a[2]+"."+a[1]+"."+a[0]:"mm/dd/yyyy"==t.dateFormats.js_sdate?a[1]+"/"+a[2]+"/"+a[0]:"mm-dd-yyyy"==t.dateFormats.js_sdate?a[1]+"-"+a[2]+"-"+a[0]:"mm.dd.yyyy"==t.dateFormats.js_sdate?a[1]+"."+a[2]+"."+a[0]:e}return""}var AppSetting;!function(e,t,a){AppSetting=function(){var e=null,n=_defineProperty({progressBar:!0,showMethod:"slideDown",hideMethod:"slideUp",timeOut:1e3,closeButton:!0,preventDuplicates:!0,hideEasing:"swing",hideDuration:500,showDuration:500},"timeOut",2500),i={message:'<div class="ball-clip-rotate loader-primary"><div></div></div>',fadeIn:700,fadeOut:700,overlayCSS:{backgroundColor:"#fff",opacity:.8,cursor:"wait"},css:{border:0,padding:0,backgroundColor:"transparent"}};return{loader:'<div class="ball-clip-rotate loader-primary"><div></div></div>',formValidations:function(){a("input,select,textarea").not("[type=submit]").jqBootstrapValidation(),a(".skin-square input").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green"})},initSelect:function(e,t){var n={allowClear:!0,width:"100%"};return n=a.extend({},n,t),a(e).length>0?a(e).select2(n):a(".app-select2").select2(n)},initFormWizard:function(){var e=a(".steps-validation").show();a(".steps-validation").steps({headerTag:"h6",bodyTag:"fieldset",transitionEffect:"fade",titleTemplate:'<span class="step">#index#</span> #title#',labels:{finish:"Submit"},onStepChanging:function(t,n,i){return n>i||!(3===i&&Number(a("#age-2").val())<18)&&(n<i&&(e.find(".body:eq("+i+") label.error").remove(),e.find(".body:eq("+i+") .error").removeClass("error")),e.validate().settings.ignore=":disabled,:hidden",e.valid())},onFinishing:function(t,a){return e.validate().settings.ignore=":disabled",e.valid()},onFinished:function(t,a){e.submit()}}),a(".steps-validation").validate({ignore:"input[type=hidden]",errorElement:"label",errorClass:"danger",successClass:"success",highlight:function(e,t){a(e).removeClass(t)},unhighlight:function(e,t){a(e).removeClass(t)},errorPlacement:function(e,t){t.parent(".input-group").length?e.insertAfter(t.parent()):t.hasClass("select2-hidden-accessible")?e.insertAfter(t.closest(".form-group").find(".select2")):e.insertAfter(t)},rules:{email:{email:!0}}}),a(".icons-tab-steps").steps({headerTag:"h6",bodyTag:"fieldset",transitionEffect:"fade",titleTemplate:'<span class="step">#index#</span> #title#',labels:{finish:"Order Placed"},onFinished:function(e,t){a("form.icons-tab-steps").submit()}})},growler:function(e,t,i,s){var r=a.extend({},n,s);switch(e){case"success":toastr.success(t,i,r);break;case"error":toastr.error(t,i,r);break;case"warning":toastr.warning(t,i,r);break;default:toastr.info(t,i,r)}},removeAllNotification:function(){toastr.remove()},initBlockUI:function(e){e.block&&e.block(i)},stopBlockUI:function(e){e.unblock&&e.unblock()},initDatePicker:function(e){var e=e||a(".pickadate"),t=e.pickadate({formatSubmit:"dd/mm/yyyy"}),n=t.pickadate("picker");n&&n.set("select",a(".pickadate").data("dateval"),{format:"yyyy-mm-dd"})},initTouchspin:function(e,t){var e=e||a(".touchspin");"vertical"==t?e.TouchSpin({verticalbuttons:!0,verticalupclass:"la la-chevron-up",verticaldownclass:"la la-chevron-down",buttondown_class:"btn btn-primary",buttonup_class:"btn btn-primary"}):e.TouchSpin({buttondown_class:"btn btn-primary",buttonup_class:"btn btn-primary",buttondown_txt:'<i class="ft-minus"></i>',buttonup_txt:'<i class="ft-plus"></i>'})},attachHandler:function(){a(t).click(function(e){e.stopPropagation(),0===a(".dropDown").has(e.target).length&&a(".subMenu").hide()})},httpPost:function(e,t){return a.ajax({cache:!1,url:e,dataType:"json",type:"post",data:t})},init:function(){e=this,e.formValidations(),e.initFormWizard(),e.initSelect(),e.initDatePicker(),e.initTouchspin()}}}(),AppSetting.init(),AppSetting.icheck=function(){var e;return{build:function(){var t=["orange","pink"],n="";e.create("input[type='checkbox']"),a.each(t,function(t,i){n=a("input[type='checkbox']").filter("."+i),e.create(n,{checkboxClass:"icheckbox_square-"+i,radioClass:"iradio_square-"+i})})},create:function(e,n){n=a.extend({},{checkboxClass:"icheckbox_square-blue",handle:"checkbox",radioClass:"iradio_square-blue"},n),a(t).find(e).iCheck(n),a("input").iCheck("update")},onCheckedDatatable:function(e){a(".checkth, .checkft").iCheck("check"),a(".multi-select").each(function(){a(this).iCheck("check"),a(this).closest("tr").toggleClass("selected")})},onUnCheckedDatatable:function(e){a(".checkth, .checkft").iCheck("uncheck"),a(".multi-select").each(function(){a(this).iCheck("uncheck")})},onUnCheckedDatatableCell:function(e){a(".checkth, .checkft").prop("checked",!1),a(".checkth, .checkft").iCheck("update")},onToggleCheckbox:function(e){var t=a(this).prop("checked");a(this).val(t?1:0)},onToggleDatatableCell:function(e){var t=a(this).prop("checked");a(this).closest("tr").toggleClass("selected"),t?a(this).closest("tr").addClass("selected"):a(this).closest("tr").removeClass("selected")},attachHandler:function(){a(t).on("ifChecked",".checkth, .checkft",e.onCheckedDatatable),a(t).on("ifUnchecked",".checkth, .checkft",e.onUnCheckedDatatable),a(t).on("ifUnchecked",".multi-select",e.onUnCheckedDatatableCell),a(t).on("ifToggled",".multi-select",e.onToggleDatatableCell),a("body").on("ifToggled",".toggle-chkbox,.toggle-radio",e.onToggleCheckbox)},init:function(){e=this,e.build(),e.attachHandler()}}}(),AppSetting.icheck.init(),AppSetting.datatable=function(){var e,t;return{dt:null,config:(e={processing:!0,serverSide:!0,lengthMenu:[[3,10,25,50,100],[3,10,25,50,100]],order:[[1,"asc"]],paging:!0,deferRender:!0,initComplete:function(e,t){setTimeout(function(){a(a.fn.dataTable.tables(!0)).DataTable().columns.adjust()},900)},ajax:function(e,t,n){a.ajax({url:"/your/url",type:"POST",data:e,success:function(e){t(e)}})}},_defineProperty(e,"ajax",{type:"GET",url:"ajax.php",dataSrc:function(e){return alert("Done!"),e.data}}),_defineProperty(e,"drawCallback",function(e){AppSetting.icheck.create("input[type='checkbox']")}),_defineProperty(e,"columnDefs",[{name:"action",sortable:!1,targets:[-1]}]),_defineProperty(e,"language",{processing:'<div class="reporting-loader-container"> <i class="la la-circle-o-notch spinner blue"></i><span class="loader-text">loading<span class="dot one">.</span><span class="dot two">.</span><span class="dot three">.</span></div> </div>'}),e),init:function(e,n){return t=this,n=a.extend({},t.config,n),t.dt=a(e).DataTable(n),t.dt}}}()}(window,document,jQuery);