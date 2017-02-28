@extends(config('publicprofile.views_to_use').'::backend.layout.app')
@section('content')
    <div class="container">
        {!! $error !!}
    </div>
@endsection