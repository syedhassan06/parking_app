@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(Session::has($key))
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="alert bg-{{ $key }} alert-icon-right alert-arrow-right alert-dismissible mb-1" role="alert">
                <span class="alert-icon">
                    @switch($key)
                        @case('success')
                        <i class="la la-thumbs-o-up"></i>
                        @break
                        @case('warning')
                        <i class="la la-info-circle"></i>
                        @break
                        @case('danger')
                        <i class="la la-warning"></i>
                        @break
                        @case('info')
                        <i class="la la-info-circle"></i>
                        @break
                        @default
                    @endswitch
                </span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <span>{{ Session::get($key) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach