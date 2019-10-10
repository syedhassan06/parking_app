var booking = (function () {
    var _this;
    return {
        selectedUserID:null,
        selectedUserRef:null,
        datasource:null,
        selectedBooking:null,
        replyMsgTemplate:function(userReply){
            if(userReply){
                return '<div class="media media-wrapper"> ' +
                    '<div class="mr-2"  ></div> ' +
                    '<div class="media-body"> ' +
                    '<h5 class="mt-0 text-bold-500 font-sans">Feedback</h5> ' +
                    '<div class="repeat-feedback"> ' +
                    '<div class="font-sans font-small-3">'+userReply.comment+'</div> ' +
                    '</div> <div class="media mt-2"> ' +
                    '<a class="pr-3" href="#"> </a> ' +
                    '<div class="media-body"> ' +
                    '<h5 class="mt-0 text-bold-500 font-sans">Your Reply</h5> ' +
                    '<div class="repeat-replies"> ' +
                        '<div class="font-sans font-small-3"> '+((userReply.replies && userReply.replies.length>0 && userReply.replies[0].reply) || ' ') +' </div> ' +
                    '</div> ' +
                    '<div class="comment-section '+ ((userReply.replies && userReply.replies.length>0)?'d-none':'') +' "  data-feedbackid="'+userReply.id+'" > ' +
                        '<textarea class="form-control" cols="30" rows="3"></textarea> ' +
                        '<button type="button" class="mt-1 btn btn-outline-primary btn-min-width box-shadow-1 round btn-sm send-comment"> Send </button> ' +
                    '</div> ' +
                    '</div> ' +
                    '</div> ' +
                    '</div> ' +
                    '</div>'
            }
            return '<div class="font-sans font-small-3"></div>'
        },
        feedbackMsgTemplate:function(feedback){
            if(feedback){
                return '<div class="font-sans font-small-3">'+(feedback.comment)+'</div>'
            }
            return '<div class="font-sans font-small-3"></div>'
        },
        onClickUser: function () {
            var data = {
                user_id: $(this).data('id'),
                _token: CSRF_TOKEN
            };
            _this.selectedUserID =data['user_id'];
            _this.selectedUserRef = $(this);
            var currentUserRow = $(this).closest('.user-col');
            currentUserRow.addClass('user-selected');
            currentUserRow.prevAll().removeClass('user-selected');
            currentUserRow.nextAll().removeClass('user-selected');
            $("#feedback-wrapper").empty();

            AppSetting.initBlockUI($("#replies-user-section"));
            AppSetting.httpPost(_this.datasource.routes.api_user_reply, data)
                .then(
                    function (res) {
                        AppSetting.stopBlockUI($("#replies-user-section"));
                        if (res && res.status) {
                            if(res.data && res.data.length>0){
                                $.each(res.data,function(key,item){
                                    $("#feedback-wrapper").append(_this.replyMsgTemplate(item));
                                });
                            }
                        }else{
                            AppSetting.growler('error',res.message,'Error!!');
                        }
                    },
                    function (err) {
                        AppSetting.stopBlockUI($("#replies-user-section"));
                        AppSetting.growler('error',res.message,'Error!!');

                    }
                );
        },
        onSendComment: function(){
            var row = $(this).closest('.comment-section'),
                reply = row.find('textarea').val(),
                feedbackID = row.data('feedbackid');

            var data = {
                'user_id':_this.selectedUserID,
                'feedback_id':feedbackID,
                'reply':reply,
                _token: CSRF_TOKEN
            };

            AppSetting.initBlockUI($("#replies-user-section"));
            AppSetting.httpPost(_this.datasource.routes.api_post_user_reply, data)
                .then(
                    function (res) {
                        AppSetting.stopBlockUI($("#replies-user-section"));
                        if (res && res.status) {
                            if(res.data && res.data.length>0){
                                $("#feedback-wrapper").empty();
                                $.each(res.data,function(key,item){
                                    $("#feedback-wrapper").append(_this.replyMsgTemplate(item));
                                });
                            }
                        }else{
                            AppSetting.growler('error',res.message,'Error!!');
                        }
                    },
                    function (err) {
                        AppSetting.stopBlockUI($("#replies-user-section"));
                        AppSetting.growler('error',res.message,'Error!!');

                    }
                );
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
            $("body").on('click','.user-action',_this.onClickUser);
            $("body").on('click','.send-comment',_this.onSendComment);
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
