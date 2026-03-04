@php
    use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Route::currentRouteName();

                if (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (Route::is($slug . '*') || Route::is($slug)) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (Route::is($submenu->slug . '*') || Route::is($submenu->slug)) {
                            $activeClass = $active;
                        }
                    }
                } else {
                    if (Route::is($submenu->slug . '*') || Route::is($submenu->slug)) {
                        $activeClass = 'active';
                    }
                }
            @endphp
            @php
                $isLocked =
                    isset($submenu->permission) && !in_array($submenu->permission, $current_vendor_permissions ?? []);
            @endphp

            <li class="menu-item {{ $activeClass }} {{ $isLocked ? 'menu-locked' : '' }}">
                <a href="{{ $isLocked ? route('vendor.billing') : (isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)') }}"
                    class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif
                    @if ($isLocked) data-bs-toggle="tooltip" data-bs-placement="right" title="Upgrade to Unlock" @endif>
                    @if (isset($submenu->icon))
                        <i class="{{ $submenu->icon }}"></i>
                    @endif
                    <div class="d-flex align-items-center">
                        {{ isset($submenu->name) ? __($submenu->name) : '' }}
                        @if ($isLocked)
                            <i class="bx bx-lock-alt ms-2 small text-muted"></i>
                        @endif
                    </div>
                    @isset($submenu->badge)
                        <div class="badge rounded-pill bg-{{ $submenu->badge[0] }} text-uppercase ms-auto">
                            {{ $submenu->badge[1] }}</div>
                    @endisset
                </a>

                {{-- submenu --}}
                @if (isset($submenu->submenu))
                    @include('backend.vendor.layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>
