@extends('layouts.app')

@section('content')
<style>
  .cell-label{
    width: 150px;
    font-weight: bold;
  }
  .cell-konten{
    width: 200px;
  }
  [contenteditable="true"] {
  border: none;
  outline: none;
  }
</style>
<!-- Font Awesome (versi 6) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div style="display:flex; gap:20px;">
<meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Form Edit Task -->
  <div style="flex:2;  padding:20px; border-radius:12px;">
    <div class="d-flex justify-content-between">
  <div>
    <a href="{{ url()->previous() }}" style="text-decoration: none; color: #6b6666ff;">
      <h2><i class="fa-solid fa-arrow-left"></i></h2>
    </a>
  </div>
  <div>
   
    <div class="dropdown d-inline">
      <span class="float-end fs-5 fw-bold" style="cursor: pointer" data-bs-toggle="dropdown" aria-expanded="false">
        <h1>...</h1>
      </span>
     <ul class="dropdown-menu">
  <li>
    <a href="#" id="edit-btn" class="dropdown-item d-flex align-items-center text-warning">
      <i class="fa-solid fa-pen me-2"></i> Edit Task
    </a>
  </li>
  <li>
    <a href="{{ route('task.delete', ['project' => $task->project->id, 'task' => $task->id]) }}" 
       class="dropdown-item d-flex align-items-center text-danger">
      <i class="fa-solid fa-trash me-2"></i> Delete Task
    </a>
  </li>
</ul>

    </div>
  </div>
</div>
    <div class="row">
      
      <div class="col-10">
        <h3 contenteditable="true" id="nama_task_editable">{{ $task->nama_task }}</h3>
        <input type="hidden" name="nama_task" id="nama_task_input">
      </div>      
    </div>
    
    <div id="success-message" style="color:green; margin-bottom: 15px; display:none;"></div>

    <form id="task-form" data-url="{{ route('tasks.update.api', ['task' => $task->id]) }}">
      @csrf
      {{-- @method('PUT') --}}
      @method('POST')

      <div class="d-flex p-5 justify-content-between">
        <div role="table">
          <div role="row" class="d-flex mb-3">
            <div role="cell" class="me-3 cell-label" >Status</div> 
            <div role="cell" class=" cell-konten">
              <select  class="form-control form-control-sm" name="status" id="status_input" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                @foreach(['todo' => 'To Do', 'inprogress' => 'In Progress', 'done' => 'Complete'] as $key => $label)
                  <option value="{{ $key }}" @if(old('status', $task->status) == $key) selected @endif>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div role="row" class="d-flex mb-3">
            <div role="cell" class="me-3 cell-label" >Priority</div> 
            <div role="cell" class=" cell-konten">
              <select  class="form-control form-control-sm" name="priority" id="priority_input" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $key => $label)
                  <option value="{{ $key }}" @if(old('priority', $task->priority) == $key) selected @endif>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>          
          <div role="row" class="d-flex mb-3">
            <div role="cell" class="me-3 cell-label" >Assign To</div> 
            <div role="cell" class=" cell-konten">
              <select multiple class="form-control form-control-sm" name="assign_to[]" id="assign_to_input" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                @foreach($task->project->users as $user)
                <option value="{{ $user->id }}" 
                  @if(in_array($user->id, old('assign_to', $task->assignedUsers->pluck('id')->toArray()))) selected @endif>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
                  <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                  * Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd ⌘</strong> (Mac) to select multiple users.
                </small>
            </div>
          </div>      
        </div>

        <div role="table">
         <div role="row" class="d-flex mb-3">
          <div role="cell" class="me-3 cell-label">Date Start</div>
          <div role="cell" class="cell-konten">
            <input 
              class="form-control form-control-sm" 
              type="date" 
              name="start_date" 
              id="start_date_input"  
              value="{{ old('start_date', $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') : '') }}" 
              style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
          </div>
        </div>

         <div role="row" class="d-flex mb-3">
          <div role="cell" class="me-3 cell-label">Deadline</div>
          <div role="cell" class="cell-konten">
            <input 
              class="form-control form-control-sm" 
              type="date" 
              name="end_date" 
              id="end_date_input" 
              value="{{ old('end_date', $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') : '' ) }}" 
              style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
          </div>
        </div>
                <div role="row" class="d-flex mb-3">
          <div role="cell" class="me-3 cell-label">Time Estimate</div>
          <div role="cell" class="cell-konten">
            <span id="estimate_content">{{ $estimate }} Days</span>
          </div>
          
        </div>
        </div>
      </div>
   
    <div class="mb-4">
      <label for="attachment" class="form-label fw-bold">Upload Attachment</label>
      <input type="file" name="attachment[]" id="attachment" class="form-control" multiple>
      <small class="form-text text-muted">You can select multiple files at once.</small>
    </div>
    

    <div id="attachment-section" class="mb-4 {{ $task->attachments && $task->attachments->count() > 0 ? '' : 'd-none' }}">
      <label class="form-label fw-bold">Existing Attachments</label>
      <ul class="list-group" id="attachment-list">
        @if($task->attachments && $task->attachments->count() > 0)
          @foreach($task->attachments as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center" id="attachment-item-{{ $file->id }}">
              <div class="d-flex align-items-center">
                <i class="bi bi-paperclip me-2 text-primary"></i>
                <a href="{{ asset('storage/attachments/' . $file->filename) }}" target="_blank" class="text-decoration-none fw-medium">
                  {{ $file->filename }}
                </a>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary">{{ strtoupper(pathinfo($file->filename, PATHINFO_EXTENSION)) }}</span>
                <button type="button" 
        class="btn btn-sm btn-outline-danger delete-attachment" 
        data-id="{{ $file->id }}" 
        data-url="{{ route('attachments.destroy', $file->id) }}">
  <i class="bi bi-trash"></i>
</button>

              </div>
            </li>
          @endforeach
        @endif
      </ul>
    </div>




      <div class="mb-3">
        <label for="description" name="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" id="description" rows="10">{{ old('description', $task->description) }}</textarea>

      </div>



    </form>
    <div class="text-end mt-3">
  <button id="save-btn" class="btn btn-success" style="display:none;">
    <i class="fa-solid fa-save"></i> Save
  </button>
</div>
  </div>

  <!-- Comments Section -->
  <div class="border border-white" style="flex:1; padding:20px; border-radius:12px; box-shadow:0 8px 16px rgba(0,0,0,0.05); max-height: 600px;">
    <h3>Comments</h3>
    <div id="comments-container" style="height: 350px; overflow-y: auto" data-url="{{ route('get.comments', ['task' => $task->id]) }}" data-userid="{{ Auth::user()->id }}" style="display:flex; flex-direction: column-reverse; gap: 12px;">
      
    </div>

    <div class="form-isi" id="comment-form" style="margin-top: 20px; position: relative;">
      <textarea class="form-control" id="comment-input" rows="3" placeholder="Add a comment..." style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;"></textarea>
      <button id="kirim_comment" style="margin-top: 10px; background:#3182ce; color:#fff; padding:10px 15px; border:none; border-radius:8px; cursor:pointer;">Send</button>
    </div>
    
  </div>

</div>

<script src="{{ asset('js/jquery.js') }}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const startDateInput = document.getElementById('start_date_input');
  const endDateInput = document.getElementById('end_date_input');
  const estimateContent = document.getElementById('estimate_content');

  startDateInput.addEventListener('change', function () {
    const startDateStr = this.value;
    const estimateMatch = estimateContent.textContent.trim().match(/(\d+)/);
    const estimateDays = estimateMatch ? parseInt(estimateMatch[1]) : 0;

    if (startDateStr && estimateDays > 0) {
      const startDate = new Date(startDateStr);
      startDate.setDate(startDate.getDate() + estimateDays);

      const yyyy = startDate.getFullYear();
      const mm = String(startDate.getMonth() + 1).padStart(2, '0');
      const dd = String(startDate.getDate()).padStart(2, '0');
      const newEndDate = `${yyyy}-${mm}-${dd}`;

      endDateInput.value = newEndDate;
    }
  });
});
</script>



<script>
  $(document).ready(function () {
    var url = $('#comments-container').data('url');

    function formatTanggal(dateStr) {
      const options = {
        weekday: 'long', day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
      };
      return new Date(dateStr).toLocaleString('id-ID', options);
    }

    function loadComments() {
      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          var container = $('#comments-container');
          container.empty();

          $.each(response, function (index, comment) {
            var html = `
              <div style="padding:10px; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom: 12px;">
                <small><strong>${comment.user.name}</strong></small><br>
                <small>${formatTanggal(comment.created_at)}</small>
                <p>${comment.content}</p>
              </div>
            `;
            container.append(html);
          });
        },
        error: function (xhr, status, error) {
          console.error('Gagal mengambil komentar:', error);
        }
      });
    }

    function kirimKomentar() {
      let userID = $('#comments-container').data('userid');
      let comment = $('#comment-input').val();

      $('#kirim_comment').prop('disabled', true).text('Mengirim...');

      // tampilkan komentar sementara (loading)
      var container = $('#comments-container');
      var tempHtml = `
        <div id="temp-comment" style="padding:10px; border-radius:8px; background:#f0f0f0; margin-bottom:12px;">
          <small><strong>Anda</strong></small><br>
          <small>sedang mengirim...</small>
          <p>${comment}</p>
        </div>
      `;
      container.prepend(tempHtml);

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          user_id: userID,
          comment: comment
        },
        success: function (response) {
          console.log('Komentar berhasil ditambahkan:', response);
          $('#comment-input').val('');
          $('#temp-comment').remove();
          loadComments();
        },
        error: function (xhr) {
          console.error('Gagal menambahkan komentar:', xhr.responseJSON);
          $('#temp-comment').remove();
          alert('Gagal mengirim komentar.');
        },
        complete: function () {
          $('#kirim_comment').prop('disabled', false).text('Kirim');
        }
      });
    }

    $('#kirim_comment').on('click', function () {
      const comment = $('#comment-input').val();
      if (comment.trim()) {
        kirimKomentar();
      } else {
        alert('Komentar tidak boleh kosong!');
      }
    });

    loadComments();
  });
</script>


<script>
$(document).ready(function () {
  // Disable semua input (kecuali file)
  $('#task-form :input').not('#attachment').prop('disabled', true);
  $('#attachment').prop('disabled', true); // Disable file input saat awal
  $('#nama_task_editable').attr('contenteditable', false);

  // Disable tombol delete file saat awal
  disableDeleteButtons();

  // Tombol Edit
  $('#edit-btn').on('click', function () {
    $('#task-form :input').not('#attachment').prop('disabled', false); // Enable semua input kecuali file
    $('#attachment').prop('disabled', false); // Aktifkan upload file
    $('#nama_task_editable').attr('contenteditable', true);

    // Aktifkan tombol delete file
    enableDeleteButtons();

    $(this).hide();
    $('#save-btn').show();
  });

  // Tombol Save
 $('#save-btn').on('click', function (e) {
    e.preventDefault();

    // Buat FormData dari form
    let formData = new FormData($('#task-form')[0]);

    // Ambil contenteditable dan tambahkan langsung ke FormData
    let namaTask = $('#nama_task_editable').text().trim();
    formData.append('nama_task', namaTask);

    // Hilangkan file jika tidak ingin dikirim bersamaan
    formData.delete('attachment');

    // Debug: cek isi FormData sebelum dikirim
    for (var pair of formData.entries()) {
      console.log(pair[0]+ ': ' + pair[1]);
    }

    // CSRF token
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    // Kirim AJAX
    $.ajax({
      url: $('#task-form').data('url'),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        alert('Task saved successfully!');

        $('#task-form :input').not('#attachment, #nama_task_input').prop('disabled', true);
        $('#attachment').prop('disabled', true); // Disable upload file lagi
        $('#nama_task_editable').attr('contenteditable', false);

        disableDeleteButtons();

        $('#save-btn').hide();
        $('#edit-btn').show();

        loadAttachments(response.attachments);
      },
      error: function (xhr) {
        console.error('Error:', xhr.responseText);
        alert('Gagal menyimpan task.');
      }
    });
});


  // Upload file otomatis saat dipilih (hanya jika input file enabled)
  $('#attachment').on('change', function () {
    if ($(this).prop('disabled')) {
      alert('Klik tombol Edit dulu untuk menambahkan file.');
      return;
    }

    let formData = new FormData($('#task-form')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
      url: $('#task-form').data('url'),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        alert('File uploaded successfully!');
        loadAttachments(response.attachments);
         $('#attachment').val('');
      },
      error: function (xhr) {
        console.error('Gagal upload file:', xhr.responseText);
      }
    });
  });

  // Load ulang attachment list
function loadAttachments(attachments) {
    let list = $('#attachment-list');
    list.empty();
    if (attachments.length > 0) {
        $('#attachment-section').removeClass('d-none');
        attachments.forEach(file => {
            let ext = file.filename.split('.').pop().toUpperCase();
            let item = `
                <li class="list-group-item d-flex justify-content-between align-items-center" id="attachment-item-${file.id}">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-paperclip me-2 text-primary"></i>
                        <a href="/storage/attachments/${file.filename}" target="_blank" class="text-decoration-none fw-medium">
                            ${file.filename}
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary">${ext}</span>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger delete-attachment disabled" 
                                data-id="${file.id}" 
                                data-url="${file.delete_url}"
                                disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </li>`;
            list.append(item);
        });
    } else {
        $('#attachment-section').addClass('d-none');
    }
}

// Saat klik Edit → aktifkan delete file
$('#edit-btn').on('click', function () {
    enableDeleteButtons();
});

// Saat klik Save → disable delete file lagi
$('#save-btn').on('click', function () {
    disableDeleteButtons();
});

// Hapus file (pastikan tombol aktif)
$(document).on('click', '.delete-attachment', function () {
    if ($(this).prop('disabled')) {
        alert('Klik tombol Edit dulu untuk menghapus file.');
        return;
    }

    let attachmentId = $(this).data('id');
    let deleteUrl = $(this).data('url');
    if (!deleteUrl) {
        alert('URL delete tidak ditemukan.');
        return;
    }

    if (!confirm('Are you sure want to delete this file?')) return;

    let button = $(this);
    button.prop('disabled', true).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
        url: deleteUrl,
        type: 'POST',
        data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response.message);
            $(`#attachment-item-${attachmentId}`).fadeOut(300, function () {
                $(this).remove();
                if ($('#attachment-list li').length === 0) {
                    $('#attachment-section').addClass('d-none');
                }
            });
        },
        error: function (xhr) {
            console.error('Gagal hapus attachment:', xhr.responseText);
            alert('Failed to delete file!');
            button.prop('disabled', false).removeClass('disabled').html('<i class="bi bi-trash"></i>');
        }
    });
});

// Helpers
function disableDeleteButtons() {
    $('.delete-attachment').prop('disabled', true).addClass('disabled');
}

function enableDeleteButtons() {
    $('.delete-attachment').prop('disabled', false).removeClass('disabled');
}

});
</script>

<script>
  function updateEstimate() {
  const start = new Date($('#start_date_input').val());
  const end = new Date($('#end_date_input').val());

  if (!isNaN(start.getTime()) && !isNaN(end.getTime()) && end >= start) {
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 biar hari awal & akhir ikut
    $('#estimate_content').text(`${diffDays} Days`);
  } else {
    $('#estimate_content').text('0 Days');
  }
}

// Jalankan setiap kali user ubah tanggal
$('#start_date_input, #end_date_input').on('change', updateEstimate);

// Jalankan sekali saat halaman load
updateEstimate();

</script>





@endsection
