<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }


            /* Safari 4.0 - 8.0 */
            @-webkit-keyframes mymove {
                0%   {color: red;}
                25%  {color: green;}
                75%  {color: blue}
                100% {color: yellow;}
            }

            /* Standard syntax */
            @keyframes mymove {
                0%   {color: red;}
                25%  {color: green;}
                75%  {color: blue}
                100% {color: yellow;}
            }

            #title-animate {
                -webkit-animation: mymove 5s infinite alternate;
                z-index: 950;
            }
            .raul-img{
                animation: flying linear 3s;
                animation-iteration-count: 1;
                transform-origin: 50% 50%;
                -webkit-animation: flying linear 3s;
                -webkit-animation-iteration-count: 1;
                -webkit-transform-origin: 50% 50%;
                -moz-animation: flying linear 3s;
                -moz-animation-iteration-count: 1;
                -moz-transform-origin: 50% 50%;
                -o-animation: flying linear 3s;
                -o-animation-iteration-count: 1;
                -o-transform-origin: 50% 50%;
                width: 300px;
                margin-left: 65%;
                z-index: 900;
                position: absolute;
            }

            @keyframes flying{
                0% {
                    transform:  translate(0px,0px)  scaleX(1.5) ;
                }
                100% {
                    transform:  translate(-2000px,0px)  scaleX(1.5) ;
                }
            }

            @-moz-keyframes flying{
                0% {
                    transform:  translate(1008px,0px)  scaleX(1.5) ;
                }
                100% {
                    transform:  translate(-1000px,0px)  scaleX(1.5) ;
                }
            }

            @-webkit-keyframes flying {
                0% {
                    transform:  translate(1008px,0px)  scaleX(1.5) ;
                }
                100% {
                    transform:  translate(-1000px,0px)  scaleX(1.5) ;
                }
            }

            @-o-keyframes flying {
                0% {
                    transform:  translate(1008px,0px)  scaleX(1.5) ;
                }
                100% {
                    transform:  translate(-1000px,0px)  scaleX(1.5) ;
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <div id="title-animate">Public Profile</div>
                </div>

                <div class="links">
                    <a href="{{ route('profile_setup') }}">Instalar</a>
                    <a href="#">Frontend</a>
                    <a href="{{ route('backend_profile_post_create') }}">Backend</a>
                    <a href="https://github.com/c0d3rsmx/publicprofile" target="_blank">GitHub</a>
                </div>
            </div>
            
            
            <img id="raul" class="" src="/img/raul.png">

            <script>
                $("#raul").hide();
                wordCode = [];
                wordString = "";

                $(document).keypress(function(e) {
                    if( wordCode.length <= 8) {
                        wordCode.push(e.keyCode);
                    }
                    if(wordCode.length == 9){
                        for(x = 0; x<= wordCode.length - 1; x++){
                            if(wordCode[x] == 115){
                                wordString += "s";
                            }else if(wordCode[x] == 121){
                                wordString += "y";
                            }else if(wordCode[x] == 110){
                                wordString += "n";
                            }else if(wordCode[x] == 101){
                                wordString += "e";
                            }else if(wordCode[x] == 114){
                                wordString += "r";
                            }else if(wordCode[x] == 103){
                                wordString += "g";
                            }else if(wordCode[x] == 121){
                                wordString += "y";
                            }else if(wordCode[x] == 111){
                                wordString += "o";
                            }else if(wordCode[x] == 50){
                                wordString += "2";
                            }
                        }
                        if(wordString == "synergyo2"){
                            $("#raul").show()
                            $("#raul").addClass('raul-img')
                        }else {
                            wordCode = [];
                            wordString = "";
                        }
                    }
                });
            </script>
            
        </div>

    </body>
</html>
