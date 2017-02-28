@extends(config('publicprofile.views_to_use').'::backend.layout.app')
{{-- view extends are customizable --}}



@section('content')
    <style>
        textarea {
            resize: none;
        }
    </style>

    <div class="container" id="app">
        <div class="row">
            <div align="center"  class="col-md-12">
                <h1> User Public Posts</h1>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="{{ route('backend_profile_post_store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{-- here goes the user id --}}
                    <input type="text" name="post_public_profile_id" value="{{ $public_profile_id }}" hidden>
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input v-model="title" type="text" class="form-control" id="post_title" name="post_title" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label for="post_content">Content</label>
                        <textarea v-model="content" rows="10"  class="form-control" id="post_content" name="post_content" placeholder="Content"></textarea>
                    </div>
                    <div v-show="image == ''" class="form-group">
                        <label for="post_video">Video link</label>
                        <input v-model="video" type="text" class="form-control" id="post_video" name="post_video" placeholder="Link">
                    </div>
                    <div v-show="video == ''" class="form-group">
                        <label for="post_image">Post Image</label>
                        <input v-model="image" type="file" id="post_image" name="post_image">
                        <p class="help-block">Image for post. (video will be unavailable)</p>
                    </div>
                    <div v-show="image == ''" class="checkbox">
                        <label>
                            <input v-on:click="isYoutube()" id="post_type" type="checkbox"> Youtube video
                            <input v-model="type" id="post_type" name="post_type" type="hidden">
                        </label>
                    </div>
                    <button type="submit" style="width: 100%" class="btn btn-primary">Post</button>
                </form>

            </div>
        </div>
    </div>


    <script>
        new Vue({
            el: '#app',
            data: {
                video: '',
                image: '',
                type: false
            },
            methods : {
                isYoutube: function () {
                    if(!this.type){
                        this.type = true;
                    }else {
                        this.type = false;
                    }
                }
            },
            watch : {
                video: {
                    handler: function (val, oldVal) {
                        this.image = '';
                    },
                    deep: true
                },
                image: {
                    handler: function (val, oldVal) {
                        this.video = '';
                        this.type = false;
                    },
                    deep: true
                }
            }
        });

    </script>

@endsection