/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This file contains JavaScript code for posts/show.blade.php.

*/

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
// Start index from where comments got from DB will start.
var commentStartIdx = window.numberNewComments;
// End index to where comments got from DB will end.
var commentEndIdx = window.numberNewComments * 2 - 1;
// Start index from where replies got from DB will start.
var replyStartIdx = 0;
// End index to where replies got from DB will end.
var replyEndIdx = window.numberNewComments - 1;

(function($){

  $(document).ready(function(){

    // Add Event listeners to all Comment's like, reply and see Replies buttons.
    for(var i = 0; i < Object.keys(window.comments).length; i++)
    {
      $(`#comment_${window.comments[i].id} #likeButton`).click({idx: i}, likeCommentButton_click);
      $(`#comment_${window.comments[i].id} #replyButton`).click({idx: i}, replyButton_click);
      $(`#comment_${window.comments[i].id} #seeRepliesButton`).click({idx: i}, seeRepliesButton_click);
    }

    // Event listener that is triggered when User clicks on  likeCommentButton.
    function likeCommentButton_click(event)
    {
      // Get index where comment is located in comments array.
      var i = event.data.idx;

      // Executes Ajax function
      axios.post('/like/comment/' + window.comments[i].id)
        .then(response => {
          var imagePath = $(`#comment_${window.comments[i].id} div #likeButton img`).attr("src");
          // Toggles image path.
          imagePath = (imagePath == '/storage/images/Like-button.png') ?
            '/storage/images/Blue-Like-button.png' : '/storage/images/Like-button.png';
          $(`#comment_${window.comments[i].id} div #likeButton img`).attr("src",imagePath);

          var likesCount = parseInt(window.comments[i].likesCount);

          if(imagePath == '/storage/images/Blue-Like-button.png')
            likesCount++;
          else
            // Makes sure likesCount won't go below zero.
            likesCount = likesCount > 0 ? likesCount - 1 : 0;

          window.comments[i].likesCount = likesCount;
          $(`#comment_${window.comments[i].id} div #likeButton span`).empty().append(likesCount);

          console.log(response.data);
          })
          .catch(errors => {
            if(errors.response.status == 401)
              window.location = '/login';
          });

    }

    $("#loadComments").click(function(){
      $.ajax(
      {
        type: "post",
        dataType: "json",
        url: "/c/getComments/",
        data: {
          _token: CSRF_TOKEN,
          postId: window.postId,
          startIdx: commentStartIdx,
          endIdx: commentEndIdx,
          numberNewComments: window.numberNewComments
        },

        success: function(response)
        {
          console.log(response);
          $("#loadComments").remove();

          // Appends comments got from DB.
          $("#displayComments").append(response.comments);

          commentStartIdx = response.startIdx;
          commentEndIdx = response.endIdx;

          var oldCommentsTotal = Object.keys(window.comments).length;
          var newCommentsTotal = oldCommentsTotal + response.commentsId.length;
          var newCommentIdx = 0;

          // Add Event listeners to all new Comment's like, reply and see Replies buttons.
          for(var i = oldCommentsTotal ; i < newCommentsTotal ; i++)
          {
            // Insert new comment into comments array.
            window.comments[i] = { id: response.commentsId[newCommentIdx], likesCount: response.likesCounts[newCommentIdx] };

            $(`#comment_${response.commentsId[newCommentIdx]} #likeButton`).click({idx: i}, likeCommentButton_click);
            $(`#comment_${response.commentsId[newCommentIdx]} #replyButton`).click({idx: i}, replyButton_click);
            $(`#comment_${response.commentsId[newCommentIdx]} #seeRepliesButton`).click({idx: i}, seeRepliesButton_click);

            newCommentIdx++;
          }

          if(!response.reachedEndList)
            $("#displayComments").append("<p class='py-2' id='loadComments'>Load more comments...</p>");
        }
      });
    });

    // Event listener triggered when User clicks on replyButton.
    function replyButton_click(event)
    {
      // Get index where comment is located in comments array.
      var i = event.data.idx;

      $("#reply").remove();

      $(`#comment_${window.comments[i].id}`).append(`
      <div id="reply" class="px-3 py-3">
        <div class='form-group row'>
          <textarea id='replyBody' name='replyBody' class='form-control' rows='4' cols='50' placeholder='Comment here...'></textarea>
        </div>
        <div class='row d-flex justify-content-around align-items-center'>
          <button id="sendReply" class="btn btn-primary">Reply</button>
          <span id="cancelReply">Cancel</span>
        </div>

      </div>
      `);

      // Event listener that is triggered when User clicks on sendReply button.
      $("#sendReply").click(function(){

        var body = $("#replyBody").val();

        $.ajax(
        {
          type: "post",
          url: "/reply/create/",
          data: {
            _token: CSRF_TOKEN,
            commentId: window.comments[i].id,
            body: body
          },

          success: function(response)
          {
            console.log(response);
            alert("Reply sent!");
            $("#reply").remove();
          }
        });
      });

      $("#cancelReply").click(function(){
        $("#reply").remove();
      });

    };

    // Event listener that is triggered when User clicks on seeReplies button.
    function seeRepliesButton_click(event)
    {
      // Get index where comment is located in comments array.
      var i = event.data.idx;

      // If #seeRepliesButton exists means that user clicked on a new #seeRepliesButton so we need to reset idxs. If it
      // doesn't, means #loadReplies was clicked.
      if ($(`#comment_${window.comments[i].id} #seeRepliesButton`).length)
      {
        replyStartIdx = 0;
        replyEndIdx = window.numberNewComments - 1;
        $(`#comment_${window.comments[i].id} #seeRepliesButton`).remove();
      }

      $.ajax(
      {
        type: "post",
        dataType: "json",
        url: "/reply/index/",
        data: {
          _token: CSRF_TOKEN,
          commentId: window.comments[i].id,
          startIdx: replyStartIdx,
          endIdx: replyEndIdx,
          numberNewComments: window.numberNewComments
        },

        success: function(response)
        {
          console.log(response);
          $(`#loadReplies`).remove();

          $(`#displayReplies_${window.comments[i].id}`).append(response.replies);

          replyStartIdx = response.startIdx;
          replyEndIdx = response.endIdx;

          if(!response.reachedEndList)
          {
            $(`#displayReplies_${window.comments[i].id}`).append("<p class='pt-2' id='loadReplies'>Load more replies...</p>");
            $(`#displayReplies_${window.comments[i].id}`).click({idx: i}, seeRepliesButton_click);
          }
        }
      });

    };
  });
})(jQuery);
