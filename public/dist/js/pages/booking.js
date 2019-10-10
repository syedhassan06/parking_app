var booking = (function () {
    var _this;
    return {
        datasource:null,
        selectedArea:null,
        selectedLocation:null,
        selectedBookingDate:null,
        selectedStartTime:null,
        selectedEndTime:null,
        validation:{
            rules:{
                booking_date:{required:true},
                start_time:{required:true},
                end_time:{required:true},
                location_id:{required:true},
                area_id:{required:true}
            },
            messages:{}
        },
        bookedSlots:[],
        selectedParkingSlot:null,
        parkingSlots:[],

        reset: function(){
            //trigger
            /*$("input[name=template_type_id]:checked").trigger('change');
            $(".countryselect").trigger('change');*/
        },

        fetchBooking: function () {
            //console.log(_this.selectedArea,_this.selectedLocation);
            var booking_date = _this.selectedBookingDate,
                area_id = _this.selectedArea && _this.selectedArea.id,
                location_id = _this.selectedLocation && _this.selectedLocation.id,
                start_time = _this.selectedStartTime && _this.selectedStartTime,
                end_time = _this.selectedEndTime && _this.selectedEndTime;

            if (booking_date && area_id && location_id && start_time && end_time) {
                var data = {
                    booking_date: booking_date,
                    area_id: area_id,
                    location_id: location_id,
                    start_time: start_time,
                    end_time: end_time,
                    _token: CSRF_TOKEN
                };

                _this.selectedExchangeRate = null;

                $(".car-slots-wrapper").fadeOut();
                $("#slot-section").empty();
                AppSetting.initBlockUI($("#booking-section"));
                AppSetting.httpPost(_this.datasource.routes.fetch_booking, data)
                    .then(
                        function (res) {
                            AppSetting.stopBlockUI($("#booking-section"));
                            if (res && res.status) {
                                _this.bookedSlots = res.data;
                                var slots = _this.datasource.slots.slice();

                                //Mapped booked slots with avaiable slots
                                if(slots.length>0 || _this.bookedSlots.length>0){
                                    $.each(slots,function(key,item){

                                        var foundAssignedSlot = _this.bookedSlots.findIndex(function(assignedSlots){
                                            return assignedSlots.slot && assignedSlots.slot.id ==item.id && assignedSlots.booking_status=='booked';
                                        });
                                        if(foundAssignedSlot!=-1){
                                            item['is_booking']=1;
                                        }else{
                                            item['is_booking']=0;
                                        }
                                    });
                                }
                                //console.log('slots',slots);
                                _this.parkingSlots = slots;
                                //Displayed SLots
                                if(slots.length>0){
                                    $.each(slots,function(key,item){
                                        var slotTemplate = _this.getSlotTemplate(item);
                                        $("#slot-section").append(slotTemplate);
                                    });
                                }else{
                                    $("#slot-section").append('<h4 class="text-center">Sorry, No Slot Available at the moment.</h4>');
                                }
                                $(".car-slots-wrapper").fadeIn();
                                //AppSetting.growler('success','New Customer has been added successfully','Success');
                                // var newOption = new Option(res.data.name, res.data.id, true, true);
                                // $("#customer").append(newOption).trigger('change');
                                // $("#customerModal").modal("hide");
                                // AppSetting.growler('success','New Customer has been added successfully');
                                // $("#customer-form").length > 0 && $("#customer-form")[0].reset();
                            }else{
                                AppSetting.growler('error',res.message,'Error!!');
                            }
                        },
                        function (err) {
                            AppSetting.stopBlockUI($("#booking-section"));
                            AppSetting.growler('error',res.message,'Error!!');

                        }
                    );
            }
        },

        getSlotTemplate: function (slot) {
            return '<div class="col-md-3 car-slots-col mb-2">'+
                '<i class="la la-car '+((slot.is_booking)?'booked ':'slot-booking-btn ')+' " data-id="'+slot.id+'" ></i>'+
                '<div class="font-sans text-bold-500 text-uppercase slot-label">'+slot.display_name+'</div>'+
            '</div>';
        },

        onChangeBookingDate: function(date){
            if(date && date.select){
                _this.selectedBookingDate = moment(date.select).format('YYYY-MM-DD');
                //$('#supply_date').pickadate('picker').get('select', 'yyyy-mm-dd')
            }else{
                _this.selectedBookingDate = null;
            }
        },
        onChangeStartTime: function(date){
            var startTime= $('#start_time').pickatime('picker').get('select');
            if(startTime){
                _this.selectedStartTime = startTime.hour+':'+startTime.mins+':00';
            }
            //console.log("_this.start_time",_this.selectedStartTime)
        },
        onChangeEndTime: function(date){
            var endTime= $('#end_time').pickatime('picker').get('select');
            if(endTime){
                _this.selectedEndTime = endTime.hour+':'+endTime.mins+':00';
            }
           // console.log("_this.end_time",_this.selectedEndTime)
        },
        onChangeArea: function(){
            var val= $(this).val();
            var filtered = _this.datasource.areas.filter(function(item){
                //console.log("item",item,val)
                return item.id == val;
            });
            if(filtered.length>0){
                _this.selectedArea = filtered[0];
            }else{
                _this.selectedArea = null;
            }
        },
        onChangeLocation: function(){
            var val= $(this).val();
            var filtered = _this.datasource.locations.filter(function(item){
                return item.id == val;
            });
            if(filtered.length>0){
                _this.selectedLocation = filtered[0];
            }else{
                _this.selectedLocation = null;
            }
        },
        validateFormControl:function(){
            var valid = $(this).valid();
        },
        formValidate:function(){
            $("#booking-form").validate({
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
        validateInput: function () {

        },
        onSearchBooking: function(){
            _this.formValidate();
            var isValidate = $("#booking-form").valid();
            _this.fetchBooking();
        },
        getParameterByName : function (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        },

        onShownModal: function () {
            var slotID= $(this).data('id');
            var filteredSlot = _this.parkingSlots.filter(function (item) {
                return item.id==slotID
            });
            if(filteredSlot.length>0){
                _this.selectedParkingSlot = filteredSlot[0];
            }
            $("input[name='slot_id']").val(_this.selectedParkingSlot.id);
            $(".parking_slot_text").html(_this.selectedParkingSlot.display_name);
            $(".booking_date_text").html($('#booking_date').pickadate('picker').get());
            $(".location_text").html(_this.selectedLocation.location_name);
            $(".area_text").html(_this.selectedArea.area_name);
            $(".start_time").html($('#start_time').pickatime('picker').get());
            $(".end_time").html($('#end_time').pickatime('picker').get());
            $('#bookingModal').modal('show');
        },
        onDismissModal: function () {
            _this.selectedParkingSlot = null;
            $("input[name='slot_id']").val("");
            $(".parking_slot_text,.booking_date_text,.location_text,.area_text, .start_time, .end_time").html("");
        },
        onClickConfirmation: function () {
            $("#booking-form").submit();
        },

        attachEventListeners: function () {

            var bookingDateInput = $("#booking_date").pickadate().pickadate('picker'),
                startTimeInput = $("#start_time").pickatime().pickatime('picker'),
                endTimeInput = $("#end_time").pickatime().pickatime('picker');

            $(".btn-search").on('click',_this.onSearchBooking);
            $(".areaselect").on('change',_this.onChangeArea);
            $(".locationselect").on('change',_this.onChangeLocation);
            bookingDateInput.on({set:_this.onChangeBookingDate});
            startTimeInput.on({set:_this.onChangeStartTime});
            endTimeInput.on({set:_this.onChangeEndTime});
            $("select,.pickadate,.timepicker").on('change',_this.validateFormControl);

            $("body").on('click','.slot-booking-btn',_this.onShownModal);
            $("#bookingModal").on('hidden.bs.modal',_this.onDismissModal);
            $(".btn-booking-submit").on('click',_this.onClickConfirmation);

            if($('.sale-items-table').length > 0){
                $('.sale-items-table-wrapper').perfectScrollbar({
                    theme:"dark",
                    wheelSpeed:100,
                });
                $(".sale-items-table").on('mouseover',function(){
                    $('#sale-items-table-wrapper').perfectScrollbar('update')
                });
            }

            // $(".btn-test").on('click',function (){
            //     console.log($('form').serializeArray());
            // });
        },

        init: function(){
            _this = this;
            _this.attachEventListeners();

            //New Instance
            _this.datasource = $.extend({},_PBS);

            //Reset
            _this.reset();
            $('.select2-size-xs').select2({
                containerCssClass: 'select-xs'
            });
            $('.timepicker').pickatime({
                formatSubmit: 'HH:i',
                hiddenName: true
            })

        }
    };
})();


booking.config = (function(){
    var _this;
    return {

        init: function(){
            _this = this;
        }
    }
})();

booking.config.init();
booking.init();
