@extends('publicprofile::backend.layout.app')



@section('content')
    <style>
        textarea {
            resize: none;
        }
    </style>

    <div class="container" id="app">
        <div class="row">
            <div align="center"  class="col-md-12">
                <h1> User Profile Create</h1>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="{{ route('backend_profile_store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    {{-- here goes the user id --}}
                    <input type="text" name="profile_user_id" value="{{ $user_id }}" hidden>

                    <div class="form-group">
                        <label for="user_name">Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Lastname</label>
                        <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Lastname">
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="user_nickname">Profile nickname</label>
                        <input type="text" class="form-control" id="user_nickname" name="user_nickname"  placeholder="Nickname">
                    </div>


                    <div class="form-group">
                        <label for="user_phone">Phone</label>
                        <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Phone">
                    </div>


                    <div class="form-group">
                        <label for="user_profile_image">User Profile Image</label>
                        <input type="file" id="user_profile_image" name="user_profile_image">
                    </div>

                    <div class="form-group">
                        <label for="user_cover_image">User Cover Image</label>
                        <input type="file" id="user_cover_image" name="user_cover_image">
                    </div>


                    <div class="checkbox">
                        <label>
                            <input id="is_active" type="checkbox"> Active
                            <input id="user_status" name="user_status" type="hidden" value="false">
                        </label>
                    </div>

                    <button type="submit" style="width: 100%" class="btn btn-primary">Create</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('#is_active').change(function () {
            if($(this).is(':checked')){
                $('#user_status').val(true);
            }else {
                $('#user_status').val(false);
            }
        })
    </script>

@endsection