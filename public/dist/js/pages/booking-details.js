var booking = (function () {
    var _this;
    return {
        datasource:null,
        selectedBooking:null,
        onShownModal: function () {
            $('#deleteConfirmBookingModal').modal('show');
        },
        onDismissModal: function () {
            _this.selectedParkingSlot = null;
        },
        onClickConfirmation: function () {
            $('#deleteConfirmBookingModal').modal('hide');
            var data = {
                id: _this.selectedBooking.id,
                _token: CSRF_TOKEN
            };
            AppSetting.initBlockUI($("#booking-details-section"));
            AppSetting.httpPost(_this.datasource.routes.booking_cancel+'/'+_this.selectedBooking.id, data)
                .then(
                    function (res) {
                        AppSetting.stopBlockUI($("#booking-details-section"));
                        if (res && res.status) {
                            $('.booking_status_text').html('<span class="badge badge-danger">Cancelled</span>');
                            $(".cancel-booking-btn").hide();
                            AppSetting.growler('success',res.message,'Success');
                        }else{
                            AppSetting.growler('error',res.message,'Error!!');
                        }
                    },
                    function (err) {
                        AppSetting.stopBlockUI($("#booking-section"));
                        AppSetting.growler('error',res.message,'Error!!');

                    }
                );
        },
        attachEventHandlers: function () {
            $("body").on('click','.cancel-booking-btn',_this.onShownModal);
            $("#deleteConfirmBookingModal").on('hidden.bs.modal',_this.onDismissModal);
            $(".confirm-cancel-btn").on('click',_this.onClickConfirmation);
        },

        init: function(){
            _this= this;
            _this.attachEventHandlers();
            //New Instance
            _this.datasource = $.extend({},_PBS);
            _this.selectedBooking = _this.datasource['booking'];
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
