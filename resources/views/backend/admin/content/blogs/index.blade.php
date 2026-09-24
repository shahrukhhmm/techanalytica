@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Blogs')

@section('vendor-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:#fff;">
                    <i class="fa-solid fa-newspaper me-2" style="color:var(--accent-pink);"></i> Blog Posts
                </h4>
                <p class="text-muted mb-0" style="font-size:13px;">
                    Manage all editorial articles, guides, and insights published on TechAnalytica.
                </p>
            </div>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fa-solid fa-plus"></i> New Blog Post
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            @php
                $total     = $blogs->total() ?? count($blogs);
                $published = $blogs->getCollection()->where('status', 'published')->count();
                $draft     = $blogs->getCollection()->where('status', 'draft')->count();
            @endphp
            <div class="col-6 col-md-3">
                <div class="card border-0 h-100" style="background:rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07) !important;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(var(--bs-primary-rgb),0.15);display:flex;align-items:center;justify-content:center;color:var(--bs-primary);font-size:18px;">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div>
                            <div style="font-size:22px;font-weight:800;color:#fff;">{{ number_format($total) }}</div>
                            <div style="font-size:11px;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Total Posts</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 h-100" style="background:rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07) !important;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;color:#10b981;font-size:18px;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div style="font-size:22px;font-weight:800;color:#fff;">{{ number_format($published) }}</div>
                            <div style="font-size:11px;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Published</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 h-100" style="background:rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07) !important;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;color:#f59e0b;font-size:18px;">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div style="font-size:22px;font-weight:800;color:#fff;">{{ number_format($draft) }}</div>
                            <div style="font-size:11px;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Drafts</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 h-100" style="background:rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07) !important;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(224,67,133,0.15);display:flex;align-items:center;justify-content:center;color:var(--accent-pink);font-size:18px;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <div style="font-size:22px;font-weight:800;color:#fff;">{{ $blogs->getCollection()->whereNotNull('published_at')->where('published_at', '>=', now()->subDays(7))->count() }}</div>
                            <div style="font-size:11px;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">This Week</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main DataTable Card --}}
        <div class="card" style="border: 1px solid rgba(255,255,255,0.07) !important;">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:14px;font-weight:700;color:#fff;">All Blog Posts</span>
                    <span class="badge" style="background:rgba(224,67,133,0.2);color:var(--accent-pink);font-size:11px;">{{ number_format($total) }} total</span>
                </div>
                {{-- Status filter pills --}}
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-sm status-filter-btn active" data-status="all" style="font-size:12px;">All</button>
                    <button class="btn btn-sm status-filter-btn" data-status="published" style="font-size:12px;background:rgba(16,185,129,0.12);color:#10b981;border-color:rgba(16,185,129,0.3);">Published</button>
                    <button class="btn btn-sm status-filter-btn" data-status="draft" style="font-size:12px;background:rgba(245,158,11,0.12);color:#f59e0b;border-color:rgba(245,158,11,0.3);">Draft</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="blogsDataTable" class="table table-hover align-middle mb-0" style="width:100%;">
                        <thead style="background:rgba(255,255,255,0.03); border-bottom:1px solid rgba(255,255,255,0.08);">
                            <tr>
                                <th style="width:50px; padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">#</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">Title</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">Author</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">Category</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">Status</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45);">Published</th>
                                <th style="padding:14px 16px; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:rgba(255,255,255,0.45); text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $i => $blog)
                                <tr class="blog-row" data-status="{{ $blog->status }}">
                                    <td style="padding:14px 16px; color:rgba(255,255,255,0.4); font-size:13px;">{{ $blogs->firstItem() + $i }}</td>
                                    <td style="padding:14px 16px; max-width:340px;">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($blog->cover_image)
                                                <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}"
                                                     style="width:52px;height:38px;object-fit:cover;border-radius:6px;border:1px solid rgba(255,255,255,0.08);flex-shrink:0;"
                                                     onerror="this.style.display='none'">
                                            @else
                                                <div style="width:52px;height:38px;background:rgba(224,67,133,0.12);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(224,67,133,0.2);">
                                                    <i class="fa-solid fa-image" style="font-size:14px;color:var(--accent-pink);"></i>
                                                </div>
                                            @endif
                                            <div style="min-width:0;">
                                                <a href="{{ route('admin.blogs.show', $blog) }}"
                                                   style="font-size:14px;font-weight:600;color:#fff;text-decoration:none;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px;"
                                                   title="{{ $blog->title }}">
                                                    {{ $blog->title }}
                                                </a>
                                                @if($blog->slug)
                                                    <span style="font-size:11px;color:rgba(255,255,255,0.3);font-family:monospace;">/blogs/{{ $blog->slug }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px;height:28px;border-radius:50%;background:var(--button-gradient);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">
                                                {{ strtoupper(substr($blog->author->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span style="font-size:13px;color:rgba(255,255,255,0.75);">{{ $blog->author->name ?? 'â€”' }}</span>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px;">
                                        @if($blog->category)
                                            <span style="font-size:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:3px 10px;color:rgba(255,255,255,0.6);">
                                                {{ $blog->category->name ?? $blog->category }}
                                            </span>
                                        @else
                                            <span style="color:rgba(255,255,255,0.25);font-size:13px;">â€”</span>
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px;">
                                        @if($blog->status === 'published')
                                            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25);color:#10b981;border-radius:20px;padding:3px 12px;font-size:12px;font-weight:600;">
                                                <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>
                                                Published
                                            </span>
                                        @elseif($blog->status === 'draft')
                                            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);color:#f59e0b;border-radius:20px;padding:3px 12px;font-size:12px;font-weight:600;">
                                                <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;"></span>
                                                Draft
                                            </span>
                                        @else
                                            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);border-radius:20px;padding:3px 12px;font-size:12px;font-weight:600;">
                                                {{ ucfirst($blog->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px;">
                                        @if($blog->published_at)
                                            <span style="font-size:13px;color:rgba(255,255,255,0.6);">{{ $blog->published_at->format('M d, Y') }}</span>
                                            <br>
                                            <span style="font-size:11px;color:rgba(255,255,255,0.3);">{{ $blog->published_at->format('H:i') }}</span>
                                        @else
                                            <span style="color:rgba(255,255,255,0.25);font-size:13px;">â€”</span>
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px; text-align:right;">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('admin.blogs.show', $blog) }}"
                                               class="btn btn-sm" title="View"
                                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.7);width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:8px;transition:all 0.2s;"
                                               onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                                                <i class="fa-solid fa-eye" style="font-size:12px;"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                               class="btn btn-sm" title="Edit"
                                               style="background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.25);color:var(--accent-pink);width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:8px;transition:all 0.2s;"
                                               onmouseover="this.style.background='rgba(224,67,133,0.22)'" onmouseout="this.style.background='rgba(224,67,133,0.1)'">
                                                <i class="fa-solid fa-pen-to-square" style="font-size:12px;"></i>
                                            </a>
                                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete"
                                                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#ef4444;width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:8px;cursor:pointer;transition:all 0.2s;"
                                                    onmouseover="this.style.background='rgba(239,68,68,0.22)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                                    <i class="fa-solid fa-trash" style="font-size:12px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 px-4 py-3" style="border-top:1px solid rgba(255,255,255,0.06);">
                    <div style="font-size:13px;color:rgba(255,255,255,0.4);">
                        Showing <strong style="color:rgba(255,255,255,0.7);">{{ $blogs->firstItem() ?? 0 }}</strong>
                        to <strong style="color:rgba(255,255,255,0.7);">{{ $blogs->lastItem() ?? 0 }}</strong>
                        of <strong style="color:rgba(255,255,255,0.7);">{{ $blogs->total() }}</strong> entries
                    </div>
                    <div>
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // â”€â”€ Initialize DataTable â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const table = new DataTable('#blogsDataTable', {
        paging:      false,   // Laravel handles pagination
        info:        false,
        ordering:    true,
        searching:   true,
        responsive:  true,
        dom: '<"d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2"<"d-flex gap-2"B><"ms-auto"f>>t',
        buttons: [
            {
                extend:    'csvHtml5',
                text:      '<i class="fa-solid fa-file-csv me-1"></i> CSV',
                className: 'btn btn-sm',
                title:     'TechAnalytica_Blogs',
                exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa-solid fa-file-excel me-1"></i> Excel',
                className: 'btn btn-sm',
                title:     'TechAnalytica_Blogs',
                exportOptions: { columns: [1, 2, 3, 4, 5] }
            },
            {
                extend:    'print',
                text:      '<i class="fa-solid fa-print me-1"></i> Print',
                className: 'btn btn-sm',
                exportOptions: { columns: [1, 2, 3, 4, 5] }
            }
        ],
        language: {
            search:          '',
            searchPlaceholder: 'ðŸ” Search blogs...',
            zeroRecords:     '<div style="text-align:center;padding:40px;color:rgba(255,255,255,0.3);"><i class="fa-solid fa-magnifying-glass" style="font-size:32px;margin-bottom:12px;display:block;"></i>No matching blog posts found.</div>',
        },
        columnDefs: [
            { orderable: false, targets: [0, 6] },
            { searchable: false, targets: [0, 6] }
        ],
        initComplete: function () {
            // Style the search input
            const searchInput = document.querySelector('#blogsDataTable_filter input');
            if (searchInput) {
                searchInput.style.cssText = 'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:8px;padding:7px 14px;font-size:13px;outline:none;min-width:220px;';
                searchInput.placeholder = 'ðŸ” Search blogs...';
            }
            // Style export buttons
            document.querySelectorAll('.dt-buttons .btn').forEach(btn => {
                btn.style.cssText = 'background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.7);border-radius:8px;font-size:12px;padding:6px 14px;margin-right:4px;transition:all 0.2s;';
                btn.addEventListener('mouseover', () => { btn.style.background = 'rgba(224,67,133,0.15)'; btn.style.borderColor = 'rgba(224,67,133,0.35)'; btn.style.color = '#fff'; });
                btn.addEventListener('mouseout',  () => { btn.style.background = 'rgba(255,255,255,0.05)'; btn.style.borderColor = 'rgba(255,255,255,0.1)'; btn.style.color = 'rgba(255,255,255,0.7)'; });
            });
        }
    });

    // â”€â”€ Status Filter Pill Buttons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.querySelectorAll('.status-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.status-filter-btn').forEach(b => {
                b.classList.remove('active');
                b.style.background = '';
                b.style.color = '';
                b.style.borderColor = '';
            });
            this.classList.add('active');
            this.style.background   = 'rgba(224,67,133,0.2)';
            this.style.color        = '#ff7bb3';
            this.style.borderColor  = 'rgba(224,67,133,0.4)';

            const status = this.dataset.status;
            document.querySelectorAll('.blog-row').forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // â”€â”€ Style default active filter btn â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const activeBtn = document.querySelector('.status-filter-btn.active');
    if (activeBtn) {
        activeBtn.style.background  = 'rgba(224,67,133,0.2)';
        activeBtn.style.color       = '#ff7bb3';
        activeBtn.style.borderColor = 'rgba(224,67,133,0.4)';
    }
});
</script>
@endsection
