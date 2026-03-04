@php
    $tools = auth()->user()->vendor ? auth()->user()->vendor->tools : collect();
    $activeToolId = session('active_tool_id');
    $activeTool = $tools->firstWhere('id', $activeToolId) ?? $tools->first();
@endphp

@if ($tools->isNotEmpty())
    <li class="nav-item navbar-dropdown dropdown me-3 me-xl-1">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <i class="bx bx-wrench me-1"></i>
            <span class="d-none d-sm-inline-block">{{ $activeTool ? $activeTool->name : 'Select Tool' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            @foreach ($tools as $tool)
                <li>
                    <a class="dropdown-item {{ $activeToolId == $tool->id ? 'active' : '' }}"
                        href="{{ route('vendor.switch-tool', $tool->id) }}">
                        <span class="align-middle">{{ $tool->name }}</span>
                    </a>
                </li>
            @endforeach
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('vendor.tools.index') }}">
                    <i class="bx bx-plus me-2"></i>
                    <span class="align-middle">Manage Tools</span>
                </a>
            </li>
        </ul>
    </li>
@endif
