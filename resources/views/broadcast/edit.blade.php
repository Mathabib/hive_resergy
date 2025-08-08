@extends('layouts.app')

@section('content')
<style>
    /* Bisa gunakan style yang sama seperti create */
    main.app-main {
        background-color: #f9fafb;
        min-height: 100vh;
        padding: 2rem;
        color: #333;
    }

    h3 {
        color: #b91c1c;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    form {
        max-width: 1500px;
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(185, 28, 28, 0.15);
    }

    label {
        font-weight: 600;
        color: #7f1d1d;
    }

    input[type="text"],
    input[type="file"],
    #assignDropdownToggle,
    #searchAssignee {
        border-radius: 0.5rem;
        border: 1.5px solid #f87171;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        color: #333;
        transition: border-color 0.3s ease;
        width: 100%;
    }

    input[type="text"]:focus,
    input[type="file"]:focus,
    #assignDropdownToggle:focus,
    #searchAssignee:focus {
        border-color: #b91c1c;
        outline: none;
        box-shadow: 0 0 8px rgba(185, 28, 28, 0.4);
    }

    /* Quill editor container */
    #messageEditor {
        height: 180px;
        border: 1.5px solid #f87171;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
    }

    /* Dropdown styling */
    #assignDropdownToggle {
        cursor: pointer;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #assignDropdown {
        max-height: 240px;
        overflow-y: auto;
        z-index: 10;
        position: absolute;
        background: white;
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Button */
    button[type="submit"] {
        background-color: #b91c1c;
        border: none;
        color: white;
        font-weight: 700;
        padding: 0.65rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 1.5rem;
    }

    button[type="submit"]:hover {
        background-color: #7f1d1d;
        box-shadow: 0 0 12px rgba(185, 28, 28, 0.6);
    }
</style>

<main class="app-main">
    <div class="container-fluid">
        <h3>Edit Broadcast Email</h3>
        <form action="{{ route('broadcast.update', $broadcast->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return submitForm()">
            @csrf
            @method('PUT')

            <!-- Subject -->
            <div class="form-group mb-3">
                <label for="subject">Subject</label>
                <input id="subject" type="text" name="subject" class="form-control" required
                       value="{{ old('subject', $broadcast->subject) }}">
            </div>

            <!-- Message -->
            <div class="form-group mb-3">
                <label for="messageEditor">Message</label>
                <div id="messageEditor">{!! old('message', $broadcast->message) !!}</div>
                <input type="hidden" name="message" id="messageInput" required>
            </div>

            <!-- Attachment -->
            <div class="form-group mb-3">
                <label for="attachment">Attachment (optional)</label>
                <input id="attachment" type="file" name="attachment" class="form-control">
                @if($broadcast->attachment)
                    <small>Current: <a href="{{ asset('storage/' . $broadcast->attachment) }}" target="_blank">View attachment</a></small>
                @endif
            </div>

            <!-- Recipient Dropdown -->
            <div class="mb-3" style="position: relative;">
                <!-- Trigger -->
                <div class="form-control d-flex justify-content-between align-items-center" 
                     id="assignDropdownToggle" tabindex="0" aria-haspopup="listbox" aria-expanded="false" style="cursor: pointer;">
                    <span id="selectedCount">Select Recipients</span>
                    <i class="bi bi-chevron-down"></i>
                </div>

                <!-- Dropdown -->
                <div id="assignDropdown" class="border rounded mt-1 bg-white shadow-sm w-99" style="display: none;">
                    
                    <!-- Search -->
                    <div class="p-2 border-bottom">
                        <input type="text" class="form-control form-control-sm" 
                               id="searchAssignee" placeholder="Search...">
                    </div>

                    <!-- Select All -->
                    <div class="form-check mx-2 mt-2">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label" for="selectAll">Select All</label>
                    </div>

                    <!-- List Users -->
                    <div id="assignList" class="p-2" style="max-height: 200px; overflow-y: auto;">
                        @foreach($clients as $client)
                        <div class="form-check">
                            <input class="form-check-input user-checkbox" 
                                   type="checkbox" 
                                   name="recipients[]" 
                                   value="{{ $client->email }}" 
                                   id="user_{{ $client->id }}"
                                   @if(in_array($client->email, old('recipients', $broadcastRecipients))) checked @endif>
                            <label class="form-check-label" for="user_{{ $client->id }}">
                                {{ $client->name }} ({{ $client->email }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit">Update Broadcast</button>
        </form>
    </div>
</main>

<!-- Quill CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var quill = new Quill('#messageEditor', {
        theme: 'snow',
        placeholder: 'Type your message here...',
        modules: {
            toolbar: [
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'super' }, { 'script': 'sub' }],
                [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                ['direction', { 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Set initial content if exists
    let initialContent = `{!! addslashes(old('message', $broadcast->message)) !!}`;
    if(initialContent) {
        quill.root.innerHTML = initialContent;
    }

    window.submitForm = function() {
        var html = quill.root.innerHTML.trim();
        if (html === '<p><br></p>' || html === '') {
            alert('Message cannot be empty.');
            return false;
        }
        document.getElementById('messageInput').value = html;
        return true;
    }

    const toggle = document.getElementById("assignDropdownToggle");
    const dropdown = document.getElementById("assignDropdown");
    const search = document.getElementById("searchAssignee");
    const checkboxes = document.querySelectorAll(".user-checkbox");
    const selectAll = document.getElementById("selectAll");
    const selectedCount = document.getElementById("selectedCount");

    function updateSelectedCount() {
        const checked = document.querySelectorAll(".user-checkbox:checked").length;
        selectedCount.textContent = checked > 0 ? `${checked} selected` : "Select Recipients";
        selectAll.checked = checked === checkboxes.length;
    }

    toggle.addEventListener("click", () => {
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
            toggle.setAttribute("aria-expanded", "true");
        } else {
            dropdown.style.display = "none";
            toggle.setAttribute("aria-expanded", "false");
        }
    });

    search.addEventListener("input", function () {
        const term = this.value.toLowerCase();
        checkboxes.forEach(cb => {
            const label = cb.nextElementSibling.textContent.toLowerCase();
            cb.closest(".form-check").style.display = label.includes(term) ? "" : "none";
        });
    });

    selectAll.addEventListener("change", function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    checkboxes.forEach(cb => cb.addEventListener("change", updateSelectedCount));

    updateSelectedCount();

    document.addEventListener("click", function(e) {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
            toggle.setAttribute("aria-expanded", "false");
        }
    });
});
</script>
@endsection
