<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>WebAi</title>

    <style>
        .Ihsan_Ai_Custom_ChatBot .container {
            max-width: 1300px;
        }
        :root{
            --background: {!!$backGround!!};
            --text: {!!$color!!};
        }

        body {
            background-color: #f4f7f6;
            margin-top: 20px;
        }

        .Ihsan_Ai_Custom_ChatBot .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        .Ihsan_Ai_Custom_ChatBot .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .Ihsan_Ai_Custom_ChatBot .chat-app .chat {
            /* margin-left: 280px; */
            border-left: 1px solid #eaeaea
        }

        .Ihsan_Ai_Custom_ChatBot .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .Ihsan_Ai_Custom_ChatBot.people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .chat-list li.active {
            background: #efefef
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .chat-list li .name {
            font-size: 15px
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .Ihsan_Ai_Custom_ChatBot .people-list img {
            float: left;
            border-radius: 50%
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .about {
            float: left;
            padding-left: 8px
        }

        .Ihsan_Ai_Custom_ChatBot .people-list .status {
            color: #999;
            font-size: 13px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6;
            background-color: var(--background);
            color:var(--text);
            border-radius: 10px 10px 0px 0px;

        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-header img {
            float: left;
            border-radius: 40px;
            max-width: 80px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history ul {
            padding: 0
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .my-message {
            background:var(--background);
            color:var(--text);
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: var(--background);

            border-width: 10px;
            margin-left: -10px
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .other-message {
            background:var(--background);
            color:var(--text);
            text-align: right
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-history .other-message:after {
            border-bottom-color: var(--background);
            left: 93%
        }

        .Ihsan_Ai_Custom_ChatBot .chat .chat-message {
            padding: 20px
        }
        .Ihsan_Ai_Custom_ChatBot .chat .chat-message  textarea{
            resize: none;
        }

        .Ihsan_Ai_Custom_ChatBot .online,
        .Ihsan_Ai_Custom_ChatBot .offline,
        .Ihsan_Ai_Custom_ChatBot .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }



        .Ihsan_Ai_Custom_ChatBot .float-right {
            float: right
        }

        .Ihsan_Ai_Custom_ChatBot .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        .Ihsan_Ai_Custom_ChatBot .chat-app .chat-history {
            height: 390px;
            overflow-x: auto
        }

        .Ihsan_Ai_Custom_ChatBot .send {
            background:var(--background);
            border-color::var(--background);
            color:var(--text);

            z-index: +9999;
        }

        .Ihsan_Ai_Custom_ChatBot .send:hover {
            background-color: transparent;
            border-color: #bb905f;
            color: #bb905f;
        }

        .Ihsan_Ai_Custom_ChatBot .type-text:focus {
            outline: none;
            box-shadow: none;
            border: 1px solid #bb905f;
        }

        @media only screen and (max-width: 767px) {
            .Ihsan_Ai_Custom_ChatBot .chat-app .people-list {
                height: 100%;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .people-list.open {
                left: 0
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .chat {
                margin: 0
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .chat-history {
                height: 60vh;
                overflow-x: auto
            }
        }

        @media only screen and (max-width: 576px) {
            .Ihsan_Ai_Custom_ChatBot .chat .chat-history .message {
                padding: 6px 9px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .Ihsan_Ai_Custom_ChatBot .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .Ihsan_Ai_Custom_ChatBot .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .Ihsan_Ai_Custom_ChatBot .chat-app .chat-history {
                height: calc(100vh - 270px);
                overflow-x: auto
            }
        }

/*
        .Ihsan_Ai_Custom_ChatBot .scrollbar {
            margin-left: 30px;
            float: left;
            height: 390px;
            width: 100%;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .Ihsan_Ai_Custom_ChatBot #style-2::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(202, 190, 190, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .Ihsan_Ai_Custom_ChatBot #style-2::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .Ihsan_Ai_Custom_ChatBot #style-2::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #d1a97b;
        } */
    </style>

</head>

<body>
    <section class="Ihsan_Ai_Custom_ChatBot">
        <div class="container">
            <div class="row clearfix">
                <div class="col-12">
                    <div class="card border-0 chat-app">

                        <div class="chat" id="customChat">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://webai.ihsancrm.com/chat/chatV3.0.js"></script>
    <script>
        const ihsanCRM_init = ihsanCRM('ihsanCRMWebAi', {
            name: 'Aaqib AI',
            token: '{!!$webKey!!}'
            });

    </script>
</body>

</html>
