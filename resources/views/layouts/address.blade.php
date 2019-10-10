<div class="row">
    <div class="col-md-12">
        {{$data['street1']}}
    </div>
    @if($data['street2'])
        <div class="col-md-12">
            {{$data['street2']}}
        </div>
    @endif
    <div class="col-md-12">
        {{$data['city']}}, {{$data['state']}} {{$data['postal_code']}}
    </div>
    <div class="col-md-12">
        @if(is_array($data['country']))
            {{$data['country']['name']}}
        @endif
        @if(is_string($data['country']))
            {{$data['country']}}
        @endif
    </div>

</div>