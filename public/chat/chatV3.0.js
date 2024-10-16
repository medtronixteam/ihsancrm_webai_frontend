var d, h, m,
  i = 0;

const ihsanCRMURL = "https://webai.ihsancrm.com/api/web/instance";
const ihsanCRMMessages = "https://webai.ihsancrm.com/api/web/message";
const ihsanCRMImages = "https://ihsancrm.com";




function checkOverflow(el) {
  if (el.scrollHeight > el.clientHeight) {
    el.classList.add('overflow-y-auto');
  } else {
    el.classList.remove('overflow-y-auto');
  }
}





function ihsanCRM(nameDiv, obj) {


  sessionStorage.setItem("AUTHTOKENIH", obj.token);
  sessionStorage.setItem("AUTHDIVIH", nameDiv);

    console.log("Bot is initialized");
    const formData = {
      token: obj.token,
    };
    console.log(formData);


    fetch(ihsanCRMURL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => response.json())
      .then((data) => {
        // let responseData = JSON.parse(data);
        console.log(data.status);

        if (data.status == 200) {
          sessionStorage.setItem("AUTHCLRIH", data.color);
          sessionStorage.setItem("AUTHIMGIH", ihsanCRMImages+data.logo);
          let chatMsg = getCHATBrows(
            data.name,
            data.message,
            ihsanCRMImages+data.logo,
            nameDiv
          );


          // document.querySelector(
          //   "#Ihsan_Ai_Custom_ChatBot"
          // ).innerHTML = chatMsg;
          document.getElementById('customChat').innerHTML = chatMsg;

        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
    // Form Modal show data⭐












}

function getCHATBrows(name, question, logo, nameDiv) {
  console.log('called');
  return (
    `     <div class="chat-header clearfix">
    <div class="row">
        <div class="col-12 d-flex justify-content-center ">
            <div style="margin-top: -35px;" class=" d-flex flex-column"
                style="width: 250px;">

                <div class="d-flex justify-content-center">
                    <img id="customImage" class="img-fluid"
                        src="${logo}"
                        alt="avatar">
                </div>

                <div class="chat-about text-center">
                    <h6 class="m-b-0">${name}</h6>

                </div>
            </div>

        </div>

    </div>
</div>
<div class="chat-history scrollbar" id="style-2">
    <ul class="m-b-0 ihsanChat_container" id="chatStle">


        <li class="clearfix">
            <div class="message-data text-left">
                <img src="${logo}" alt="avatar">
            </div>
            <div class="message my-message">${question} </div>
        </li>


    </ul>
</div>
<div class="chat-message clearfix">
    <div class="input-group mb-0 position-relative">
        <textarea style="height: 48px;padding-right: 90px;text-indent: 6px;padding-top: 11px;" name="" id="aimessage-submit"
            class="form-control w-100 type-text" placeholder="Type Message ..."></textarea>
        <div class="input-group-prepend position-absolute" style=" right: 10px; top: 5px;">
            <div>
                <button onclick="MessageIhsanAi()" id="message-submit-div" class="btn btn-primary send">Send</button>
            </div>
        </div>
    </div>
</div> `
  );
}

function MessageIhsanAi() {

  msg = document.querySelector('#aimessage-submit').value;
  if (msg.trim() === '') {
    return false;
  }
  document.querySelector('#aimessage-submit').value = '';
  document.querySelector('#message-submit-div').disabled = true;

  ReceiveAiIHMessage(msg);
  scrollToAiBottom();
}
function scrollToAiBottom() {
  let container_message = document.querySelector('.chat-history');
  container_message.scrollTop = container_message.scrollHeight;
}

function closeTabsofModalAi() {
  if (document.querySelector(".Ihsan_Ai_Custom_ChatBot")) {
    document.querySelector(".Ihsan_Ai_Custom_ChatBot").style.display = "none";
  }
}

function createAiElements(msg,typeOfData,status) {
  var li = document.createElement("li");
  li.classList.add("clearfix");

  // Create the <div> element with class "message-data text-right"
  var messageDataDiv = document.createElement("div");
  if(typeOfData=="bot"){
    messageDataDiv.classList.add("message-data", "text-left");
  }else{
    messageDataDiv.classList.add("message-data", "text-right");
  }


  // Create the <img> element
  var img = document.createElement("img");

  if(typeOfData=="bot"){
    img.setAttribute("src",  sessionStorage.getItem("AUTHIMGIH"));
    }else{
      img.setAttribute("src", "https://bootdey.com/img/Content/avatar/avatar7.png");
    }
  img.setAttribute("alt", "avatar");

  // Append the <img> element to the "message-data" div
  messageDataDiv.appendChild(img);

  // Create the <div> element with class "message other-message float-right"
  var messageDiv = document.createElement("div");
  if(typeOfData=="bot"){
  messageDiv.classList.add("message", "my-message");
  }else{
    messageDiv.classList.add("message", "other-message", "float-right");
  }

  messageDiv.textContent = msg; // Set the text content of the message

  // Append the "message-data" div and "message" div to the <li> element
  li.appendChild(messageDataDiv);
  li.appendChild(messageDiv);

  return li;
}

function ReceiveAiIHMessage(messages) {
  if (sessionStorage.getItem("AUTHTOKENIH")) {
  var inputValue = document.querySelector('#aimessage-submit').value;

  if (inputValue !== '') {
    return false;
  }

  var container = document.querySelector('.ihsanChat_container');
  container.appendChild(createAiElements(msg,"user",'success'));

  scrollToAiBottom();

  fetch(ihsanCRMMessages, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({

      token: sessionStorage.getItem("AUTHTOKENIH"),
      message:messages
    }),
  })
    .then((response) => response.json())
    .then((data) => {

          // Remove loading message
    //container.removeChild(loadingDiv);

      if(data.status===200){
        container.appendChild(createAiElements(data.message,"bot",'success'));

      }else{
              // Create new fake message
          container.appendChild(createAiElements(data.message,"bot",'error'));
      }
      document.querySelector('#message-submit-div').disabled = false;
      setTimeout(function() {
        scrollToAiBottom();
      },1200);
    })
    .catch((error) => {
    //  container.removeChild(loadingDiv);
      container.appendChild(createAiElements(error,"bot",'error'));
    });

}//end of tokencheck
}//end of fake


