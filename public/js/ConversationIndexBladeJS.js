/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This files contains the javascript code for conversations/index.blade.php

*/

window.currentConversation = -1;
var conversation_clickIsRunning = false;

// Helps to get/send messages live between users.
let pusher = new Pusher($("#pusher_app_key").val(), {
    cluster: $("#pusher_cluster").val(),
    encrypted: true
});

let channel = pusher.subscribe('chat');

// listen for the send event, this event will be triggered on click the send btn
channel.bind('sendMessage_click', function(data) {
    displayMessage(data.data);
});

// Force to overflow '.conversations' so vertical scroll bar appears.
var pxsToOverFlowConversations = $('.conversations').height() - $('.conversationList').height() + 60;
$('.conversations #overflowing').height(pxsToOverFlowConversations);

// If vertical scroll bar is scrolled, fires fetchConversations().
var prevLeft = 0;
$('.conversations').scroll( function(evt) {

    var currentLeft = $(this).scrollLeft();
    if(prevLeft != currentLeft) {
        prevLeft = currentLeft;
    }
    else {
      fetchConversations();
    }
});

$('.messages').height($('.viewMessages').height() - $('#usernameHeader').height()
 - $('#messageBoxContainer').height());

// Fires function when user inputs something in "#messageBox"
$("#messageBox").on('input', function() {
  // If user hasn't clicked on a conversation or #messageBox is empty
  if($('#messageBox').val() == "" || window.currentConversation == -1)
  {
    $("#sendMessage").unbind("click");
    $("#sendMessage").attr("src", "/storage/images/Send-message-arrow-disabled.png");
  }
  else
  {
    $("#sendMessage").unbind("click");
    $(`#sendMessage`).click(sendMessage_click);
    $("#sendMessage").attr("src", "/storage/images/Send-message-arrow.png");
  }
 });

// Event Handler when a conversation is clicked. Gets Messages for that conversation.
function conversation_click(event)
{

  // Prevents that function runs more than once at the time.
  if (!conversation_clickIsRunning)
    conversation_clickIsRunning = true;
  else
    return false;

  // Index where conversation's Id that was clicked is located in window.conversations
  var i = event.data.idx;
  var profileId = $('#profileId').attr("value");

  axios.get('/profile/' + profileId +'/messages/', {
    params: {
      conversationId: window.conversations[i]
    }
  })
    .then(response => {

      conversation_clickIsRunning = true;

      // Makes sure components are cleared
      $(".messages").unbind("scroll");
      $('.messageList').empty();
      $('#messageBox').prop( "disabled", false);
      $('#messageBox').val("");
      $("#sendMessage").unbind("click");
      $("#sendMessage").attr("src", "/storage/images/Send-message-arrow-disabled.png");

      $("#usernameHeader").text($(`#conversation_${window.conversations[i]} #profileUsername`).text());
      // Deletes "New Message" sign.
      $(`#conversation_${window.conversations[i]} #seenConversation`).empty();
      window.currentConversation = window.conversations[i];


      $('.messageList').prepend(response.data.messages);
      $('.endless-pagination-message').data('next-page', response.data.next_page);

      // Force to overflow '.messages' so vertical scroll bar appears.
      var pxsToOverFlowMessages = $('.messages').height() - $('.messageList').height() + 60;
      $('.messages #overflowing').height(pxsToOverFlowMessages);

      // Moves scroll bar all to bottom
      $('.messages').scrollTop($('.messages')[0].scrollHeight);

      // If vertical scroll bar is scrolled, fires fetchMessages().
      var prevLeft = 0;
      $('.messages').scroll( function(evt) {

          var currentLeft = $(this).scrollLeft();
          if(prevLeft != currentLeft) {
              prevLeft = currentLeft;
          }
          else {
            fetchMessages(window.conversations[i]);
          }
      });

      conversation_clickIsRunning = false;

    })
    .catch(errors => {
      // Makes sure components are cleared
      window.currentConversation = -1;
      $(".messages").unbind("scroll");
      $('#messageBox').prop( "disabled", true);
      $("#sendMessage").unbind("click");
      $("#sendMessage").attr("src", "/storage/images/Send-message-arrow-disabled.png");
    });

}

// Get next page of conversations.
function fetchConversations()
{

  var page = $('.endless-pagination').data('next-page');

  // Page will be null iof there isn't a next page
  if(page !== null && page !== "")
  {
    clearTimeout( $.data ( this, "scrollCheck" ));

    // We will get new conversations every time we scroll through the website. If we don't set a clearTimeout, the ajax method
    // will be fired many times and we will get so many conversations. To avoid this we set the clearTimeout.
    $.data( this, "scrollCheck", setTimeout(function() {

      var scrollPositionForConversationsLoad = $('.conversations')[0].scrollHeight - 40;
      // scrollTop is the height we have scrolled.
      // height is the visible part of the element in the screen
      var scrollPosition = $('.conversations').scrollTop() + $('.conversations').height();

      // If user gets to the point where we want to fetch conversations.
      if(scrollPositionForConversationsLoad <= scrollPosition)
      {
        $.get(page, function(data) {
          $('.conversations #overflowing').remove();
          $('.conversationList').append(data.conversations);
          $('.endless-pagination').data('next-page', data.next_page);

          // Append new conversation's Ids to window.conversations and add event handler.
          var i;
          var commentsArrayLength = Object.keys(window.conversations).length;
          var newConversationIdx = 0;
          for(i = commentsArrayLength; i < commentsArrayLength + parseInt($('#newConversationsCount').val()); i++)
          {
            var conversationId = parseInt($(`#newConversation_${newConversationIdx}`).val());
            window.conversations[i] = conversationId;
            $(`#conversation_${conversationId}`).click({idx: i}, conversation_click);

            $(`#newConversation_${newConversationIdx++}`).remove();
          }

          $('#newConversationsCount').remove();
          // Force to overflow '.conversations' so vertical scroll bar appears.
          var pxsToOverFlowConversations = $('.conversations').height() - $('.conversationList').height() + 100;
          $('.conversations #overflowing').height(pxsToOverFlowConversations);

        });
      }
    }, 1000 ) );
  }
}

// Get next page of Messages.
// @param Int. Conversation's Id.
function fetchMessages(conversationId)
{
  var page = $('.endless-pagination-message').data('next-page');

  // Page will be null if there isn't a next page
  if(page !== null && page !== "")
  {
   clearTimeout( $.data ( this, "scrollCheck" ));

   // We will get new conversations every time we scroll through the website. If we don't set a clearTimeout, the ajax method
   // will be fired many times and we will get so many conversations. To avoid this we set the clearTimeout.
   $.data( this, "scrollCheck", setTimeout(function() {

     var scrollPositionForMessagesLoad = 20;
     // scrollTop is the height we have scrolled.
     // height is the visible part of the element in the screen
     var scrollPosition = $('.messages').scrollTop();

     // If user reached the point where we want to fetch more messages
     if(scrollPositionForMessagesLoad >= scrollPosition)
     {
       $.get(page, { 'conversationId': conversationId }, function(data) {
         $('.messageList').prepend(data.messages);
         $('.messages #overflowing').remove();
         $('.messages').prepend("<div id='overflowing'></div>");

         $('.messages').scrollTop(60);

         $('.endless-pagination-message').data('next-page', data.next_page);

       });
     }
   }, 1000 ) );
  }
}

// Event Handler when user clicks on "img id='sendMessage'". Stores new message in DB.
function sendMessage_click()
{
  $.get('/m', {
   'conversationId': window.currentConversation, 'message': $('#messageBox').val() },
    function(data) {
   $('.messageList').append(data.message);
   // Move scroll bar to bottom.
   $('.messages').scrollTop($('.messages')[0].scrollHeight);
  });
}

// Gets fired when a user sends a Message.
function displayMessage(message)
{
  let alert_sound = document.getElementById("chat-alert-sound");

  // Check if the current user isn't the sender of the message
  if($("#current_user").val() != message.profile_id) {
      alert_sound.play();

      // Check if the message's receiver has the message sender's chat opened.
      if(window.currentConversation == message.conversation_id)
      {
        // Gets the message the other user sent you
        $.get('/m/getMessage', {
          'messageId': message.id },
           function(data) {
          $('.messageList').append(data.message);
          $('.messages').scrollTop($('.messages')[0].scrollHeight);
        });
      }
      else
      {
        // Shows a "New message" sign.
        $(`#conversation_${message.conversation_id} #seenConversation`).empty().append('NEW Message');
      }

      // Makes sure that the sign that shows if the last message that was sent in a conversation was yours.
      $(`#conversation_${message.conversation_id} #yourMessageSign`).empty();

  }
  else
  {
    // Shows a sign that means you sent the last message.
    $(`#conversation_${message.conversation_id} #yourMessageSign`).empty().append("You: ");
    $('#messageBox').val("");
  }

  // Shows the contents of the last message in "#conversation_id"
  $(`#conversation_${message.conversation_id} #lastMessage`).empty().append(message.body);
}
