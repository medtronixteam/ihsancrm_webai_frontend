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
          document.getElementById('Ihsan_Ai_Custom_ChatBot').innerHTML = chatMsg;

        var container = document.querySelector('.ihsanChat_container');
        // Create loading message
        var loadingDiv = document.createElement('div');
        loadingDiv.className = 'message loading new';
        loadingDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure><span></span>';
        container.appendChild(loadingDiv);
            setTimeout(function() {
              container.removeChild(loadingDiv);
              var newMessageDiv = document.createElement('div');
              newMessageDiv.className = 'message new';
              newMessageDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure>' + data.message; // Assuming 'Fake' is an array containing messages
              container.appendChild(newMessageDiv);
              newMessageDiv.classList.add('new');
            },2000);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
    // Form Modal show data⭐



      if (document.querySelector(".minimizeButton")) {
        document
          .querySelector(".minimizeButton")
          .addEventListener("click", function (event) {
            event.preventDefault();
            let formModalDiv = document.querySelector(".Ihsan_Ai_Custom_ChatBot");
            formModalDiv.style.display = "none";
          });
      }











}

function getCHATBrows(name, question, logo, nameDiv) {
  console.log('called');
  return (
    `
      <div class="menu">
        <div class="items"><span>
            <a href="javascript:void(0)" title="Minimize">&mdash;</a><br>
          </span></div>

      </div>
      <div class="agent-face">
        <div class="half">
          <img class="agent circle" src="${logo}" alt="Jesse Tino">
        </div>
      </div>
      <div class="chat">
        <div class="chat-title">
          <h1><b>${name}</b> </h1>

        </div>
        <div class="messages">
          <div class="messages-content">
            <div class="ihsanChat_container">

            </div>
          </div>
        </div>
        <div class="message-box">
          <textarea type="text" class="message-input" id="ihsanSendMessage" placeholder="Type message..."></textarea>
          <button type="submit" onclick="submitMessageAD()"  class="message-submit" id="message-submit-div">Send</button>
        </div>
      </div>
      </div> `
  );
}

function MessageIhsanAi() {
  msg = document.querySelector('.message-input').value;
  if (msg.trim() === '') {
    return false;
  }
  // Create a new div element
  var div = document.createElement('div');
  div.className = 'message message-personal';
  div.textContent = msg;

  // Get the ihsanChat_container element
  var container = document.querySelector('.ihsanChat_container');

  // Append the new div to the container
  container.appendChild(div);

  // Add the 'new' class to the new div
  div.classList.add('new');

  document.querySelector('.message-input').value = '';
  document.querySelector('#message-submit-div').disabled = true;

  ReceiveAiIHMessage(msg);
  scrollToAiBottom();
}
function scrollToAiBottom() {
  let container_message = document.querySelector('.messages-content');
  container_message.scrollTop = container_message.scrollHeight;
}

function closeTabsofModalAi() {
  if (document.querySelector(".Ihsan_Ai_Custom_ChatBot")) {
    document.querySelector(".Ihsan_Ai_Custom_ChatBot").style.display = "none";
  }
}


function ReceiveAiIHMessage(messages) {
  if (sessionStorage.getItem("AUTHTOKENIH")) {
  var inputValue = document.querySelector('.message-input').value;

  if (inputValue !== '') {
    return false;
  }

  var container = document.querySelector('.ihsanChat_container');
  // Create loading message
  var loadingDiv = document.createElement('div');
  loadingDiv.className = 'message loading new';
  loadingDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure><span></span>';
  container.appendChild(loadingDiv);

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
    container.removeChild(loadingDiv);

      if(data.status===200){
            // Create new fake message
        var newMessageDiv = document.createElement('div');
        newMessageDiv.className = 'message new';
        newMessageDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure>' + data.message; // Assuming 'Fake' is an array containing messages
        container.appendChild(newMessageDiv);
        newMessageDiv.classList.add('new');
      }else{
              // Create new fake message
        var newMessageDiv = document.createElement('div');
        newMessageDiv.className = 'message new error';
        newMessageDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure>' + data.message; // Assuming 'Fake' is an array containing messages
        container.appendChild(newMessageDiv);
        newMessageDiv.classList.add('new');
      }
      document.querySelector('#message-submit-div').disabled = false;
      setTimeout(function() {
        scrollToAiBottom();
      },1200);
    })
    .catch((error) => {
      container.removeChild(loadingDiv);
      document.querySelector('#message-submit-div').disabled = false;
      var newMessageDiv = document.createElement('div');
      newMessageDiv.className = 'message new error';
      newMessageDiv.innerHTML = '<figure class="avatar"><img src="' +sessionStorage.getItem("AUTHIMGIH") + '" /></figure>' +error; // Assuming 'Fake' is an array containing messages
      container.appendChild(newMessageDiv);
      newMessageDiv.classList.add('new');
    });

}//end of tokencheck
}//end of fake


