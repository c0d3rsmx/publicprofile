@extends('publicprofile::frontend.layout.app')



@section('content')

    <style>
        body {
            background-color: #e9ebee;
        }
        .cover-image {
            background-image: url(@if($profile->cover_image == "" || $profile->cover_image == null)
                 '/images/publicprofile/no-cover.png'
            @else
                {{ $profile->cover_image }}
            @endif
            );
            background-size: cover;
            background-repeat: no-repeat;
            height: auto;
            width: 100%;
        }

        .cover-image::before {
            content: "";
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: row-reverse;
            position: absolute;
            background-image: -webkit-linear-gradient(bottom,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);
            background-image: -o-linear-gradient(bottom,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);
            background-image: -webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.5)));
            background-image: linear-gradient(to bottom,rgba(0,0,0,.0000001) 0,rgba(0,0,0,.3) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);
            background-repeat: repeat-x;
            margin-left: -15px!important;
        }


        .profile-image {
            text-align: center;
            width: 180px;
            height: 180px;
            margin-left: -15px!important;
        }
        .profile-image-small {
            text-align: center;
            width: 50px;
            height: 50px;
        }
        .profile-name {
            font-size: 26px;
        }

        /* Extra Small devices (tablets, 268px and up) */
        @media (min-width: 268px) {
            .profile-image-container {
                text-align: center;
                padding: 5px 0px 0px 0px;
            }

            .profile-name {
                text-align: center;
            }
        }
        /* Small devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            .profile-image {
                margin-top: 110%;
            }
            .profile-image-container {
                padding: 15px;
            }
            .profile-name {
                text-align: left;
                margin-top: 20%;
            }

        }
        /* Medium devices (desktops, 992px and up) */
        @media (min-width:  992px ) {
            .profile-image {
                margin-top: 110%;
            }
            .profile-name {
                text-align: left;
                margin-top: 20%;
            }
        }
        /* Large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .profile-image {
                margin-top: 110%;
            }
            .profile-name {
                text-align: left;
                margin-top: 20%;
                font-size: 32px;
            }
        }


        .post-main-container {
            padding: 25px 40px 25px 40px;
            overflow-y: auto;
            height: 800px;
        }
        .post-row {
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid #d2d2d2;
            border-radius: 3px;
            background-color: #ffffff;
        }
        .post-image {
            height: 200px;
            width: 100%;
        }
        .post-title {
            padding: 0px 0px 20px 0px;
            font-size: 20px;
        }
        .post-title > span {
            float: right;
            font-size: 14px;
        }
        .post-content {
            margin-top: 18px;
            padding: 25px;
            font-size: 14px;
            color: #626262;
            text-align: justify;
        }
        .feedback-box {
            background-color: #ffffff;
            border: 1px solid #d2d2d2;
            padding: 15px;
            margin-top: 25px;

        }
        .feedback-box .feedbacks {
            border: 1px solid #d2d2d2;
            border-radius: 3px;
            max-height: 800px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .feedback-header {
            background-color: #c8c8c8;
            padding: 5px 5px 5px 15px;
            font-size: 14px;
            text-transform: capitalize;
            font-weight: 600;
        }
        .feedback-header .since {
            float: right;
            font-size: 10px!important;
            padding: 0 15px 0 0;
        }
        .feedback-body {
            padding: 5px 0 5px 15px;
            color: #626262;
        }
        #feedback_text {
            margin-top: 15px;
            resize: none;
        }


        .top-profile {
            z-index: 10;
            /*background-color: darkblue;*/
        }
        .top-profile-content {
            width: 100%;
            min-height: 50px;
            color: #fff;
            padding: 5px;
        }


        .animate-in{
            animation: getin ease 1s;
            animation-iteration-count: 1;
            transform-origin: 50% 50%;
            animation-fill-mode:forwards; /*when the spec is finished*/
            -webkit-animation: getin ease 1s;
            -webkit-animation-iteration-count: 1;
            -webkit-transform-origin: 50% 50%;
            -webkit-animation-fill-mode:forwards; /*Chrome 16+, Safari 4+*/
            -moz-animation: getin ease 1s;
            -moz-animation-iteration-count: 1;
            -moz-transform-origin: 50% 50%;
            -moz-animation-fill-mode:forwards; /*FF 5+*/
            -o-animation: getin ease 1s;
            -o-animation-iteration-count: 1;
            -o-transform-origin: 50% 50%;
            -o-animation-fill-mode:forwards; /*Not implemented yet*/
        }


        @keyframes getin{
            0% {
                opacity:0;
                transform:  translate(0px,-25px);
            }
            100% {
                opacity:1;
                transform:  translate(0px,0px);
            }
        }
        @-moz-keyframes getin{
            0% {
                opacity:0;
                -moz-transform:  translate(0px,-25px);
            }
            100% {
                opacity:1;
                -moz-transform:  translate(0px,0px);
            }
        }
        @-webkit-keyframes getin {
            0% {
                opacity:0;
                -webkit-transform:  translate(0px,-25px);
            }
            100% {
                opacity:1;
                -webkit-transform:  translate(0px,0px);
            }
        }
        @-o-keyframes getin {
            0% {
                opacity:0;
                -o-transform:  translate(0px,-25px);
            }
            100% {
                opacity:1;
                -o-transform:  translate(0px,0px);
            }
        }

    </style>


    <div class="container-fluid" id="app">

        <div class="row">
            <div class="cover-image col-xs-12 top-profile-big">
                <div class="profile-image-container col-xs-4 col-xs-offset-4 col-sm-2 col-sm-offset-0 col-md-2 col-md-offset-0">
                    <img class="profile-image img-thumbnail" src="@if($profile->profile_image == '' || $profile->profile_image == null)
                            /images/publicprofile/no-image.jpg
                            @else
                    {{ $profile->profile_image }}
                    @endif">
                </div>
                <div class="profile-name col-xs-12 col-sm-10 col-md-10">
                    <div style="color: white">{{ $profile->name }} {{ $profile->lastname }}</div>
                    <div style="color: white; font-size: 14px">{{ $profile->email }}</div>
                    <div style="color: white; font-size: 14px">{{ $profile->phone }}</div>
                </div>
            </div>

            <div class="col-xs-12 top-profile">
                <div class="col-md-12 top-profile-content" hidden>
                   <div class="row">
                       <div class="col-xs-12">
                           <img class="profile-image-small img-thumbnail" src="@if($profile->profile_image == '' || $profile->profile_image == null)
                                   /images/publicprofile/no-image.jpg
                                   @else
                                   {{ $profile->profile_image }}
                           @endif">
                           &nbsp;&nbsp;&nbsp;<span style="color: white; font-size: 14px">{{ $profile->name }} {{ $profile->lastname }}</span>
                           &nbsp;&nbsp;&nbsp;<span style="color: white; font-size: 14px">{{ $profile->email }}</span>
                           &nbsp;&nbsp;&nbsp;<span style="color: white; font-size: 14px">{{ $profile->phone }}</span>
                       </div>
                   </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="container-fluid">
                <div class="col-md-8 post-main-container">
                    <div v-for="p in posts" class="row post-row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="post-title">@{{ p.title }} <span>@{{ p.since }}</span></div>
                            </div>
                            <div v-if="p.image != null" class="row">
                                <img class="post-image" src="@{{ p.image }}">
                            </div>
                            <div v-if="p.video != null && p.youtube == true" class="row">
                                <youtube :player-width="youtube_width" id="youtube" :video-id="p.video"></youtube>
                            </div>
                            <div class="row">
                                <div class="post-content">@{{ p.content }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="col-md-12 feedback-box">
                        <div class="row">
                            <div v-if="guest_auth == ''" class="col-md-12">
                                <form>
                                    <div class="form-group">
                                        <label for="nickname">Nickname</label>
                                        <input v-model="guest_nickname" type="text" class="form-control" id="nickname" placeholder="Nickname">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input v-model="guest_email" type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                    <a v-if="guest_nickname != '' && guest_email != ''" style="width: 100%;" type="submit" v-on:click="registerGuest()" class="btn btn-success">Access</a>
                                </form>
                            </div>

                            <div v-if="guest_auth != ''" class="col-md-12">
                                <div v-for="f in profile_feedbacks['feedbacks']" class="col-md-12 feedbacks">
                                    <div class="row">
                                        <div class="feedback-header">
                                            <span>@{{ f.guest_nickname }}</span>
                                            <span class="since">@{{ f.since }}</span>
                                        </div>
                                        <div class="feedback-body">
                                            @{{ f.feedback }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <form>
                                            <div class="form-group">
                                                <textarea v-model="temp_feedback"  rows="5" class="form-control" id="feedback_text"></textarea>
                                            </div>
                                            <a v-on:click="newFeedback()" style="width: 100%" class="btn btn-primary">Comment</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="{{ env('APP_URL') }}:3000/socket.io/socket.io.js"></script>
    <script>
        var socket = io('{{ env('APP_URL') }}:3000');
        var public_profile_id = '{{ $profile->id }}';
        Vue.use(VueYouTubeEmbed)
        var vue = new Vue({
            el: '#app',
            data: {
                posts: '',
                profile_feedbacks: '',
                guest_nickname: '',
                guest_email: '',
                guest_auth: '',
                temp_feedback: '',
                channel: 'channel_'+ public_profile_id,
                channel_feedback : 'feedback_'+ public_profile_id,
                registered: false,
                youtube_width: $('#youtube').parent().width()
            },
            ready: function () {
                socket.emit('channel', this.channel);
                socket.emit('channel', this.channel_feedback);
                this.getPosts();
            },
            watch: {
                'guest_auth': {
                    handler: function (val, oldVal) {
                        if(val != oldVal){
                            this.getFeedbacks()
                        }
                    },
                    deep: true
                }
            },
            methods : {
                onResize: function () {
                    this.youtube_width = $('#youtube').parent().width();
                },
                getPosts: function () {
                    data = {
                        'public_profile_id' : public_profile_id,
                        '_token' : '{{ csrf_token() }}'
                    };
                    this.$http.post('{{ route('frontend_profile_get_posts') }}', data, function (data, status, request) {
                       this.$set('posts', data)
                        if( data != null || data != '') {
                           if(!this.registered) {
                               /* Subscription */
                               this.registerChannel();
                               this.registerChannelFeed();
                               this.registered = true;
                           }
                        }
                    }).error(function (data, status, request) {
                    });
                },
                registerGuest: function () {
                    data = {
                        'nickname' : this.guest_nickname,
                        'email' : this.guest_email,
                        '_token' : '{{ csrf_token() }}'
                    };
                    this.$http.post('{{ route('frontend_profile_auth_guest') }}', data, function (data, status, request) {
                        this.$set('guest_auth', data)
                    }).error(function (data, status, request) {
                    });
                },
                getFeedbacks: function () {
                    data = {
                        'public_profile_id' : public_profile_id
                    };
                    this.$http.post('{{ route('frontend_profile_get_feedbacks') }}', data, function (data, status, request) {
                        this.$set('profile_feedbacks', data)
                    }).error(function (data, status, request) {
                    });
                },
                newFeedback: function () {
                    data = {
                        'public_profile_id': public_profile_id,
                        'profile_feedback_id': this.profile_feedbacks['profile_feedbacks'].id,
                        'guest_id': this.guest_auth.id,
                        'feedback': this.temp_feedback,
                        'guest_nickname': this.guest_auth.nickname,
                        '_token' : '{{ csrf_token() }}'
                    };
                    this.temp_feedback = '';
                    this.$http.post('{{ route('frontend_profile_new_feedbacks') }}', data, function (data, status, request) {
                    }).error(function (data, status, request) {
                    });
                },
                registerChannel: function () {
                    socket.on(vue.channel+":So2platform\\Publicprofile\\Events\\PostsEvent", function (data) {
                        vue.getPosts()
                    });
                },
                registerChannelFeed : function () {
                    socket.on(vue.channel_feedback+":So2platform\\Publicprofile\\Events\\FeedbacksEvent", function (data) {
                        vue.getFeedbacks()
                    });
                }
            }
        });
        $(window).resize(function() {
            vue.onResize();
        });
    </script>
    <script>
        $('.top-profile').affix({
            offset: {
                top: 400,
                bottom: function () {
                    return (this.bottom = $('.footer').outerHeight(true))
                }
            }
        })
        $('.top-profile').on('affix.bs.affix', function () {
            $('.top-profile-content').show();
            $('.top-profile').css('background-color','#3498db')
            $('.top-profile').addClass('animate-in')
        })

        $('.top-profile').on('affix-top.bs.affix', function () {
            $('.top-profile-content').hide();
            $('.top-profile').css('background-color','transparent')
            $('.top-profile').removeClass('animate-in')
        })
    </script>
@endsection