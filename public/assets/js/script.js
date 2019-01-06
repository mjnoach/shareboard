$(document).ready(function() {

  // Small viewport menu
  $('#smallMenuToggle').click(function () {
    $('#smallMenu').slideToggle(300);
  });
  $(window).on('resize', function() {
    if($(window).width() > 750) {
      $('#smallMenu').hide();
    }
  });

  // Like a Share
  $('.likeBtn').click(function() {
    var shareId = $(this).data('share-id');
    var isLiked = $(this).data('is-liked');
    var likeCount = +($('#like-counter-share-'+shareId).text());
    if (isLiked == 1) {
      likeCount--;
      $('#heart-icon-share-'+shareId).css('color', '');
      $(this).data('is-liked', 0);
    }
    else {
      likeCount++;
      $('#heart-icon-share-'+shareId).css('color', '#007BFF');
      $(this).data('is-liked', 1);
    }
    $('#like-counter-share-'+shareId).load(root_url+'/shares/like', {shareId: shareId, isLiked: isLiked, likeCount: likeCount});
  });

  // Dislike a Share in user panel
  $('.dislike-share-button').click(function() {
    var shareId = $(this).data('share-id');
    $.post(root_url+'/shares/dislike', {shareId: shareId}, function() {
      $('#likedShare-'+shareId).slideToggle(300);
    });
  });

  // Delete published Share in user panel
  $('.delete-share-button').click(function() {
    var shareId = $(this).data('share-id');
    $.post(root_url+'/shares/delete', {shareId: shareId}, function() {
      $('#publishedShare-'+shareId).slideToggle(300);
      $('#likedShare-'+shareId).hide();
    });
  });

  // Update About contents
  $("button[name='aboutSubmit']").click(function() {
    var aboutContent = $('#aboutUpdate').val();
    $.post(root_url+'/users/about', {aboutContent: aboutContent}, function(data) {
      if(data == false) {
        location.reload();
      }
      else {
        $("#message").hide();
        $('#profileAboutText').html(data);
      }
    });
    $('#aboutModal').modal('toggle');
  });

  // Update Profile picture
  $('.custom-file-input').on('change', function() {
    var filePath = $(this).val().split('\\');
    var fileName = filePath[2];
    $(this).next('.form-control-file').addClass('selected').html(fileName);
  });

  // Post a comment
  $("#commentInput").keyup(function() {
    if($.trim($("#commentInput").val()).length == 0) {
      $("#commentSubmit").css("cursor", "not-allowed");
      $("#commentSubmit").addClass("disabled");
    }
    else {
      $("#commentSubmit").css("cursor", "default");
      $("#commentSubmit").removeClass("disabled");
    }
  });
  $("#commentSubmit").click(function() {
    if(!$(this).hasClass("disabled")) {
      var shareId = $("#share").data("share-id");
      var text = $("#commentInput").val();
      var charCount = text.length;
      if(charCount > 1000) {
        $("#commentInput").addClass("is-invalid");
        $("#commentMsg").show();
      }
      else {
        $("#commentInput").removeClass("is-invalid");
        $("#commentMsg").hide();
        $.post(root_url+'/shares/comment', {text: text, shareId: shareId}, function(data) {
          $("#commentSubmit").css("cursor", "not-allowed");
          $("#commentSubmit").addClass("disabled");
          var dataArray = jQuery.parseJSON(data);

          $("#comment-counter-share-"+shareId).html(dataArray.commentCount);
          $("#commentInput").val("");

          var newComment = $(".comment:first").clone();
          newComment.attr("id", "comment-"+dataArray.commentId);
          newComment.find(".icon-cancel-1").attr("data-comment-id", dataArray.commentId);
          newComment.find(".comment-date").html(dataArray.date);
          newComment.find(".comment-text").html(dataArray.text);
          newComment.find(".comment-profile-link").attr("href", root_url+'/users/profile');
          newComment.find(".comment-user-name > a").html(dataArray.userName);
          newComment.insertAfter(".comment:first");
          newComment.slideDown();

          var deleteButton = newComment.find('.icon-cancel-1');
          deleteButton.click(function() {
            deleteComment(deleteButton);
          });
        });
      }
    }
  });

  // Delete a comment
  $('.icon-cancel-1').click(function() {
    deleteComment(this);
  });
  function deleteComment(target) {
    var commentId = $(target).data('comment-id');
    var shareId = $(target).data('share-id');
    $.post(root_url+'/shares/deleteComment', {commentId: commentId, shareId: shareId}, function(comment_count) {
      $('#comment-'+commentId).slideUp(300);
      $("#comment-counter-share-"+shareId).html(comment_count);
    });
  };
});
