@if(Session::has('flash_message'))
    <div class="alert alert-{{Session::get('flash_message_level')}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('flash_message') }}
    </div>
@endif