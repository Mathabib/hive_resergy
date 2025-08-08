@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <h3>Broadcast Email</h3>
        <form action="{{ route('broadcast.send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Subject -->
            <div class="form-group mb-3">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>

            <!-- Message -->
            <div class="form-group mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>

            <!-- Attachment -->
            <div class="form-group mb-3">
                <label>Attachment (optional)</label>
                <input type="file" name="attachment" class="form-control">
            </div>

            <!-- Recipient Dropdown -->
            <div class="mb-3">
                <!-- Trigger -->
                <div class="form-control d-flex justify-content-between align-items-center" 
                     id="assignDropdownToggle" style="cursor: pointer;">
                    <span id="selectedCount">Select Recipients</span>
                    <i class="bi bi-chevron-down"></i>
                </div>

                <!-- Dropdown -->
                <div id="assignDropdown" class="border rounded mt-1 bg-white shadow-sm w-100" style="display: none;">
                    
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
                    <div id="assignList" class="p-2">
                        @foreach($clients as $client)
                        <div class="form-check">
                            <input class="form-check-input user-checkbox" 
                                   type="checkbox" 
                                   name="recipients[]" 
                                   value="{{ $client->email }}" 
                                   id="user_{{ $client->id }}">
                            <label class="form-check-label" for="user_{{ $client->id }}">
                                {{ $client->name }} ({{ $client->email }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Send Broadcast</button>
        </form>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("assignDropdownToggle");
    const dropdown = document.getElementById("assignDropdown");
    const search = document.getElementById("searchAssignee");
    const checkboxes = document.querySelectorAll(".user-checkbox");
    const selectAll = document.getElementById("selectAll");
    const selectedCount = document.getElementById("selectedCount");

    // Toggle dropdown (dorong layout ke bawah)
    toggle.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    });

    // Search filter
    search.addEventListener("input", function () {
        const term = this.value.toLowerCase();
        checkboxes.forEach(cb => {
            const label = cb.nextElementSibling.textContent.toLowerCase();
            cb.closest(".form-check").style.display = label.includes(term) ? "" : "none";
        });
    });

    // Select all
    selectAll.addEventListener("change", function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    // Update count when individual checked
    checkboxes.forEach(cb => cb.addEventListener("change", updateSelectedCount));

    function updateSelectedCount() {
        const checked = document.querySelectorAll(".user-checkbox:checked").length;
        selectedCount.textContent = checked > 0 ? `${checked} selected` : "Select Recipients";
    }
});
</script>
@endsection
