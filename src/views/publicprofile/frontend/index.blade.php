@extends(config('publicprofile.views_to_use').'::frontend.layout.app')
{{-- view extends are customizable --}}



@section('content')
    @include(config('publicprofile.views_to_use').'::frontend.component')
@endsection