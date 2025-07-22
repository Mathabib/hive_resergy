 <div class="border border-white" style="flex:1; padding:20px; border-radius:12px; box-shadow:0 8px 16px rgba(0,0,0,0.05); max-height: 600px;">
    <h3>Comments</h3>
    <div id="comments-container" style="height: 350px; overflow-y: auto" data-url="{{ route('get.comments', ['task' => $task->id]) }}" data-userid="{{ Auth::user()->id }}" style="display:flex; flex-direction: column-reverse; gap: 12px;">
      
    </div>

    <div class="form-isi" id="comment-form" style="margin-top: 20px; position: relative;">
      <textarea class="form-control" id="comment-input" rows="3" placeholder="Add a comment..." style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;"></textarea>
      <button id="kirim_comment" style="margin-top: 10px; background:#3182ce; color:#fff; padding:10px 15px; border:none; border-radius:8px; cursor:pointer;">Send</button>
    </div>
    
  </div>

  <script>
  $(document).ready(function() {
    var url = $('#comments-container').data('url'); // ambil data-url dengan jQuery

    function loadComments() {
      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var container = $('#comments-container');
          container.empty(); // kosongkan dulu

          console.log(response);

          $.each(response, function(index, comment) {
            var html = `
              <div style="padding:10px; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                <small><strong>${comment.user.name}</strong></small>
                <small>${new Date(comment.created_at).toLocaleString()}</small>
                <p>${comment.content}</p>
              </div>
            `;
            container.append(html);
          });
        },
        error: function(xhr, status, error) {
          console.error('Gagal mengambil komentar:', error);
        }
      });
    }

    function kirimKomentar() {
      let userID = $('#comments-container').data('userid')
      let url = $('#comments-container').data('url')
      let comment = $('#comment-input').val()
      $.ajax({
        url: url,
        method: 'POST',
        data: {
          user_id: userID,
          comment: comment
        },
        success: function(response) {
          console.log('Komentar berhasil ditambahkan:', response);
          $('#comment-input').val('');
          loadComments();
        },
        error: function(xhr) {
          console.error('Gagal menambahkan komentar:', xhr.responseJSON);
        }
      });

    }

    $('#kirim_comment').on('click', function() {
      console.log('tombol kirim bekerja dengan baik alhamdulillah')
      comment = $('#comment-input').val();
      let userID = $('#comments-container').data('userid')
        if (comment.trim()) {
          kirimKomentar()
          console.log(userID)
        } else {
          alert('Comment cannot be empty!');
        }

    })

        // Panggil saat halaman selesai dimuat
    loadComments();
    
  });
</script>