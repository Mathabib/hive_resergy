<!--begin::Header-->
<div class="view-tabs d-flex justify-content-center border-bottom mt-5">
    <a href="{{ route('projects.show', $project->id) }}" 
       class="tab-link {{ request()->routeIs('projects.show') ? 'active' : '' }}">
        BOARD
    </a>
    <a href="{{ route('projects.list', $project->id) }}" 
       class="tab-link {{ request()->routeIs('projects.list') ? 'active' : '' }}">
        LIST
    </a>
    <a href="{{ route('projects.gantt', $project->id) }}" 
       class="tab-link {{ request()->routeIs('projects.gantt') ? 'active' : '' }}">
        GANTT
    </a>
</div>
<!--end::Header-->

<style>
.view-tabs {
    display: flex;
    gap: 20px;
}
.tab-link {
    padding: 10px 20px;
    text-decoration: none;
    /* color: #333; */
    color: white;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}
.tab-link:hover {
    /* color: #fd0d0dff;
    border-bottom: 2px solid #fd0d0dff; */
    color: #ffc107;
    border-bottom: 2px solid #ffc107;
}
.tab-link.active {
    /* color: #fd0d0dff;
    font-weight: 600;
    border-bottom: 3px solid #fd0d0dff; */
    color: #ffc107;
    font-weight: 600;
    border-bottom: 3px solid #ffc107;
}
</style>
