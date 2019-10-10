<footer class="footer footer-static footer-light navbar-shadow bg-grey bg-darken-1">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 text-center white">
      <span class="d-block d-md-inline-block white">Copyright &copy; {{date('Y')}} <a class="text-bold-800 grey lighten-4" href="javascript:void(0)"
                                                                                     target="_blank">Parking Booking System </a>, All rights reserved. </span>
{{--
        <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i class="ft-heart pink"></i></span>
--}}
    </p>
</footer>
<script>
    var ukiAppConfig = {!! json_encode($appConfig) !!};
    var authenticatedUser = {!! json_encode($authenticatedUser) !!};
    var CSRF_TOKEN = "{!! csrf_token() !!}";
</script>
<script src="{{asset('dist/js/bundle.main.js')}}"></script>
<script src="{{asset('dist/js/pages/datatable/chunk0.js')}}"></script>
@yield('scripts')

<div class="modal animated fadeInLeft text-left" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel52" aria-hidden="true" id="deleteConfirmModal">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel52">Alert</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="m-0">Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-secondary white cancel-btn" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger confirm-remove-btn">Yes</button>
            </div>
        </div>
    </div>
</div>
