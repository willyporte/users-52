@if($errors->any())
    <div class="alert alert-danger">
        @lang('auth.errors_title'):<br><br>
        <ul>
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
@endif