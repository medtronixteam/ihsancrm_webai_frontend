<html>

<head>
  <title>Chat Full V1</title>
</head>
<body>


    @if ($Counter>0)

<link rel="stylesheet" href="https://webai.ihsancrm.com/chat/chatV2.1.css">

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
