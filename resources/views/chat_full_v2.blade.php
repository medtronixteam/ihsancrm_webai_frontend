<html>

<head>
  <title>Chat Full V1</title>
  <style>

  :root{
    --ic-chatbot-text-color:#fff;
    --ic-chatbot-bg-color:#BB905F;
  }
    .Ihsan_Ai_Custom_ChatBot .chat {
      position: relative;
      /*  top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);*/
      width: 100%;
      height: calc(100% - 15px);
      max-height: 500px;
      z-index: 10;
      overflow: hidden;
      /box-shadow: 0 5px 30px rgba(0, 0, 0, .2);/
      /* background: rgba(0, 0, 0, .5);*/
      background: transparent;
      border-radius: 10px;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
    }

    /*--------------------
Chat Title
--------------------*/
    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title {
      flex: 0 1 45px;
      position: relative;
      z-index: 2;
      width: 100%;
      border-bottom: 1px solid #ccc;
      color: #fff;
      padding-top: 50px;
      padding-bottom: 5px;
      background-color: var(--ic-chatbot-bg-color);
      text-transform: uppercase;
      text-align: center;
    }

    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title h1,
    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title h2 {
      font-weight: normal;
      font-size: 14px;
      margin: 0;
      padding: 0;
    }

    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title h2 {
      /* color: rgba(255, 255, 255, .8);*/
      font-size: 11px;
      letter-spacing: 1px;
    }

    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title .avatar {
      position: absolute;
      z-index: 1;
      top: 8px;
      left: 9px;
      -webkit-border-radius: 30px;
      -moz-border-radius: 30px;
      border-radius: 30px;
      width: 60px;
      height: 60px;
      overflow: hidden;
      margin: 0;
      padding: 0;
      border: 1px solid #fff;
    }

    .Ihsan_Ai_Custom_ChatBot>.chat .chat-title .avatar img {
      width: 100%;
      height: auto;
    }

    /*--------------------
Messages
--------------------*/
    .Ihsan_Ai_Custom_ChatBot .messages {
      flex: 1 1 auto;
      /*  color: rgba(255, 255, 255, .5);
  color: #fff;*/
      overflow: hidden;
      position: relative;
      width: 100%;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .messages-content {
      position: absolute;
      top: 0;
      left: 0;
      height: 93%;
      width: 100%;
      overflow-y: scroll;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message {
      clear: both;
      float: left;
      max-width: 70%;
      padding: 6px 10px 7px;
      -webkit-border-radius: 20px 20px 20px 0;
      -moz-border-radius: 20px 20px 20px 0;
      border-radius: 20px 20px 20px 0;
      background: var(--ic-chatbot-bg-color);
      /rgba(0, 0, 0, 0.1);/
      margin: 8px 0;
      font-size: 14px;
      color: #fff;
      line-height: 1.4;
      margin-left: 35px;
      position: relative;
      border: 1px solid #ccc;

      /text-shadow: 0 1px 1px rgba(0, 0, 0, .2);/
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message .timestamp {
      position: absolute;
      bottom: -15px;
      font-size: 10px;
      color: #555;
      right: 30px;
      /* color: rgba(255, 255, 255, .7);*/
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message .checkmark-sent-delivered {
      position: absolute;
      bottom: -15px;
      right: 10px;
      font-size: 12px;
      color: #999;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message .checkmark-read {
      color: blue;
      position: absolute;
      bottom: -15px;
      right: 16px;
      font-size: 12px;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message .avatar {
      position: absolute;
      z-index: 1;
      bottom: -15px;
      left: -35px;
      -webkit-border-radius: 30px;
      -moz-border-radius: 30px;
      border-radius: 30px;
      width: 30px;
      height: 30px;
      overflow: hidden;
      margin: 0;
      padding: 0;
      border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message .avatar img {
       width: 100%;
      height: 100%;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message.message-personal {
      float: right;
      text-align: right;
      /*      background: linear-gradient(120deg, #ddd, #eee);*/
      /* background: #fff; */
      background-color: gray;
      border: 1px solid #ccc;
      -webkit-border-radius: 20px 20px 0 20px;
      -moz-border-radius: 20px 20px 0 20px;
      border-radius: 20px 20px 0 20px;
      margin-right: 10px;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message:last-child {
      margin-bottom: 30px;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message.new {
      transform: scale(0);
      transform-origin: 0 0;
      animation: bounce 500ms linear both;
      margin-bottom: 10px;
      margin-top: 5px;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message.loading {
      position: relative;
      padding: 20px 45px 7px;
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span {
      content: '';
      position: absolute;
      background: #fff;
      width: 5px;
      /* Adjust ball size as needed */
      height: 5px;
      /* Adjust ball size as needed */
      border-radius: 50%;
      /* Makes it a circle */

      animation: bounces 1s infinite alternate;
      /* Apply animation */
      /
    }

    /* Styling for each ball */
    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span::before,
    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span::after {
      content: '';
      background: #fff;
      position: absolute;
      width: 5px;
      /* Adjust ball size as needed */
      height: 5px;
      /* Adjust ball size as needed */
      border-radius: 50%;
      /* Makes it a circle */

      animation: bounces 1s infinite alternate;
      /* Apply animation */
      /
    }

    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span::before {
      top: 50%;
      left: 20px;
      animation-delay: -0.2s;

    }

    /* Positioning for the second ball */
    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span {
      top: 50%;
      left: 10px;

      animation-delay: -0.1s;
    }

    /* Positioning for the third ball */
    .Ihsan_Ai_Custom_ChatBot .messages .message.loading span::after {
      top: 50%;
      left: 40px;
      animation-delay: -0.3s;

    }

    @keyframes bounces {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-4px);
      }
    }

    /*--------------------
Message Box
--------------------*/
    .Ihsan_Ai_Custom_ChatBot .message-box {
      box-sizing: border-box;
      flex: 0 1 42px;
      width: 90%;
      background: #fff;
      margin: 2px auto;
      /*-webkit-box-shadow: 0px 1px 1px 1px rgba(0,0,0,0.4);
  -moz-box-shadow: 0px 1px 1px 1px rgba(0,0,0,0.4);
  box-shadow: 0px 1px 1px 1px rgba(0,0,0,0.4);*/
      /*background: rgba(0, 0, 0, 0.3);
    border-top:1px solid #e3e3e3;*/
      padding: 10px;
      position: relative;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 5px;
      height: 14px;
      border: 1px solid #ccc;
    }

    .Ihsan_Ai_Custom_ChatBot .message-box .message-input {
      background: none;
      border: none;
      outline: none !important;
      resize: none;
      /* color: rgba(255, 255, 255, .8);*/
      font-size: 15px;
      height: 24px;
      margin: 0;
      padding-right: 20px;
      width: 100%;
      color: #444;
    }

    .Ihsan_Ai_Custom_ChatBot .message-box textarea:focus:-webkit-placeholder {
      color: transparent;
    }

    .Ihsan_Ai_Custom_ChatBot .message-box .message-submit {
      position: absolute;
      z-index: 1;
      top: 5px;
      right: 10px;
      color: #fff;
      border: none;
      /* background: #c29d5f; */
      background: var(--ic-chatbot-bg-color);
      font-size: 12px;
      text-transform: uppercase;
      line-height: 1;
      padding: 10px 13px;
      border-radius: 5px;
      outline: none !important;
      transition: background 0.2s ease;
      cursor: pointer;
    }

    .Ihsan_Ai_Custom_ChatBot .message-box .message-submit:hover {
      background: #fff;
      color: #333;
    }

    /*--------------------
Custom Srollbar
--------------------*/
    .mCSB_scrollTools {
      margin: 1px -3px 1px 0;
      opacity: 0;
    }

    .mCSB_inside>.mCSB_container {
      margin-right: 0px;
      padding: 0 10px;
    }

    .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
      background-color: rgba(0, 0, 0, 0.5) !important;
    }

    /*--------------------
Bounce
--------------------*/
    @keyframes bounce {
      0% {
        transform: matrix3d(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      4.7% {
        transform: matrix3d(0.45, 0, 0, 0, 0, 0.45, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      9.41% {
        transform: matrix3d(0.883, 0, 0, 0, 0, 0.883, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      14.11% {
        transform: matrix3d(1.141, 0, 0, 0, 0, 1.141, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      18.72% {
        transform: matrix3d(1.212, 0, 0, 0, 0, 1.212, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      24.32% {
        transform: matrix3d(1.151, 0, 0, 0, 0, 1.151, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      29.93% {
        transform: matrix3d(1.048, 0, 0, 0, 0, 1.048, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      35.54% {
        transform: matrix3d(0.979, 0, 0, 0, 0, 0.979, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      41.04% {
        transform: matrix3d(0.961, 0, 0, 0, 0, 0.961, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      52.15% {
        transform: matrix3d(0.991, 0, 0, 0, 0, 0.991, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      63.26% {
        transform: matrix3d(1.007, 0, 0, 0, 0, 1.007, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      85.49% {
        transform: matrix3d(0.999, 0, 0, 0, 0, 0.999, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }

      100% {
        transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
      }
    }

    @keyframes ball {
      from {
        transform: translateY(0) scaleY(0.8);
      }

      to {
        transform: translateY(-10px);
      }
    }

    .Ihsan_Ai_Custom_ChatBot {
      opacity: 1;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      height: calc(100% - 60px) !important;
      max-height: 530px !important;
      min-height: 220px !important;
      width: 100%;
      /*  transform: translateY(0);
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
  */
      background: rgba(255, 255, 255, 0.9);
      position: sticky;
      top: 40px;
      margin: auto;
      z-index: +99999999999999999999999999999999;
      box-shadow: 2px 10px 40px rgba(22, 20, 19, 0.4);
      /*  transform: translateX(300px);*/
      -webkit-transition: 0.3s all ease-out 0.1s, transform 0.2s ease-in;
      -moz-transition: 0.3s all ease-out 0.1s, transform 0.2s ease-in;
    }

    .Ihsan_Ai_Custom_ChatBot div.agent-face {
      position: absolute;
      left: 0;
      top: -50px;
      right: 0;
      margin: auto;
      width: 101px;
      height: 50px;
      background: transparent;
      z-index: 12;
    }

    .Ihsan_Ai_Custom_ChatBot div {
      font-size: 14px;
      color: #232323;
    }


    .Ihsan_Ai_Custom_ChatBot .circle {
      display: block;
      width: 80px;
      height: 80px;
      margin: 1em auto;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      -webkit-border-radius: 99em;
      -moz-border-radius: 99em;
      border-radius: 99em;
      border: 2px solid #fff;

      /* -webkit-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
    -moz-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
  box-shadow: 0px 0px 10px rgba(0,0,0,.8);*/
    }

    .Ihsan_Ai_Custom_ChatBot .contact-icon .circle:hover {
      box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
      -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
      -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
      transition: 0.2s all ease-out 0.2s;
      -webkit-transition: 0.2s all ease-out 0.2s;
      -moz-transition: 0.2s all ease-out 0.2s;
    }


    .Ihsan_Ai_Custom_ChatBot .menu div.items {
      /*  height: 140px;
    width: 180px;
    overflow: hidden;
    position: absolute;
    left: -130px;
    z-index: 2;
    top: 20px;*/
    }

    .Ihsan_Ai_Custom_ChatBot .menu .items span {
      color: #111;
      z-index: 12;
      font-size: 14px;
      text-align: center;
      position: absolute;
      right: 0;
      top: 40px;
      height: 86px;
      line-height: 40px;
      background: #fff;
      border-left: 1px solid #ccc;
      border-bottom: 1px solid #ccc;
      border-right: 1px solid #ccc;
      width: 48px;
      opacity: 0;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      transition: 0.3s all ease-in-out;
      -webkit-transition: 0.3s all ease-in-out;
      -moz-transition: 0.3s all ease-in-out;
    }

    .Ihsan_Ai_Custom_ChatBot .minimizeButton {
      font-size: 30px;
      z-index: 12;
      text-align: right;
      color: #fff;
      content: "...";
      display: block;
      width: 48px;
      line-height: 25px;
      height: 40px;
      border-top-right-radius: 20px;
      /*  border-top-left-radius:20px;*/
      position: absolute;
      right: 0;
      padding-right: 10px;
      cursor: pointer;
      transition: 0.3s all ease-in-out;
      -webkit-transition: 0.3s all ease-in-out;
      -moz-transition: 0.3s all ease-in-out;
    }

    .Ihsan_Ai_Custom_ChatBot .menu .button.active {
      background: #ccc;
    }

    .Ihsan_Ai_Custom_ChatBot .menu .items span.active {
      opacity: 1;

    }

    .Ihsan_Ai_Custom_ChatBot .menu .items a {
      color: #111;
      text-decoration: none;
    }

    .Ihsan_Ai_Custom_ChatBot .menu .items a:hover {
      color: #777;
    }

    @media only screen and (max-device-width: 667px),
    screen and (max-width: 450px) {
      .Ihsan_Ai_Custom_ChatBot {
        z-index: 2147483001 !important;
        width: 100% !important;
        height: 100% !important;
        max-height: none !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        border-radius: 0 !important;
        background: #fff;
      }

      .Ihsan_Ai_Custom_ChatBot>.chat .chat-title {
        padding-top: 90px;
      }

      .Ihsan_Ai_Custom_ChatBot div.agent-face {
        top: -10px !important;
        /* left:initial !important;*/
      }

      .Ihsan_Ai_Custom_ChatBot .chat {
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        border-radius: 0 !important;
        max-height: initial !important;
      }

      .Ihsan_Ai_Custom_ChatBot .chat-title {
        /* padding: 20px 20px 15px 10px !important; */
        margin-top: 5px;
        text-align: left;
        padding-top: 89px;
      }

      .Ihsan_Ai_Custom_ChatBot .circle {
        width: 80px;
        height: 80px;
        border: 1px solid #fff;
      }

      .Ihsan_Ai_Custom_ChatBot .menu .button {
        border-top-right-radius: 0;
      }
    }

    @media only screen and (min-device-width: 667px) {
      .Ihsan_Ai_Custom_ChatBot .half {
        margin: auto;
        width: 80px;
        height: 40px;
        background-color: #fff;
        border-top-left-radius: 60px;
        border-top-right-radius: 60px;
        border-bottom: 0;
        box-shadow: 1px 4px 20px rgba(22, 20, 19, 0.6);
        -webkit-box-shadow: 1px 4px 20px rgba(22, 20, 19, 0.6);
        -moz-box-shadow: 1px 4px 20px rgba(22, 20, 19, 0.6);
      }
    }

    .Ihsan_Ai_Custom_ChatBot .messages::-webkit-scrollbar {
      display: none;
    }

    /* Show scrollbar when content overflows vertically */
    .Ihsan_Ai_Custom_ChatBot .messages.overflow-y-auto::-webkit-scrollbar {
      display: block;
    }

    #ihsanSendMessage::placeholder {
      font-size: 14px;
      font-family: sans-serif;
    }


    .form-modal,
    .Ihsan_Ai_Custom_ChatBot {

      z-index: +999999999;

      transition: all 0.4s;
    }

    /* Track */
    .Ihsan_Ai_Custom_ChatBot .messages .messages-content::-webkit-scrollbar {
      width: 10px;
      /* Set width of the scrollbar */
    }

    /* Handle */
    .Ihsan_Ai_Custom_ChatBot .messages .messages-content::-webkit-scrollbar-thumb {
      background: var(--ic-chatbot-bg-color);
      /* Set color of the scrollbar thumb */
    }

    /* Handle on hover */
    .Ihsan_Ai_Custom_ChatBot .messages .messages-content::-webkit-scrollbar-thumb:hover {
      background: #555;
      /* Change color of the scrollbar thumb on hover */
    }

    /* Track */
    .Ihsan_Ai_Custom_ChatBot .messages .messages-content::-webkit-scrollbar-track {
      background: #f1f1f1;
      /* Set color of the scrollbar track */
    }

    /* Handle when dragging */
    .Ihsan_Ai_Custom_ChatBot .messages .messages-content::-webkit-scrollbar-thumb:active {
      background: #666;
      /* Change color of the scrollbar thumb when dragging */
    }

  </style>
</head>
<body>


    @if ($Counter>0)


<script src="https://webai.ihsancrm.com/chat/chatV2.1.js"></script>
<section id="Ihsan_Ai_Custom_ChatBot" class="Ihsan_Ai_Custom_ChatBot"></section>
<script>
    console.log('updated');
const ihsanCRM_init = ihsanCRM('ihsanCRMWebAi', {
name: 'Aaqib AI',
token: '{!! $webKey !!}'
});

if (document.getElementById('message-submit-div')) {
    document.getElementById('message-submit-div').addEventListener('click', function () {

      MessageIhsanAi();
    });

  }
  function submitMessageAD(){
    MessageIhsanAi();
  }
  if (document.getElementById("ihsanSendMessage")) {
    document.getElementById("ihsanSendMessage").addEventListener("keyup", function (event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        MessageIhsanAi();
        return false;
      }
    });
    }
</script>
@else
<h5>Sorry Invalid Bot Key ...</h5>
@endif
</body>

</html>
