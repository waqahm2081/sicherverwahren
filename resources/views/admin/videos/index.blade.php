<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos verwalten — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @include('admin.partials.styles')
    <style>
        .adm-video-row { cursor: grab; transition: background .15s, box-shadow .15s; }
        .adm-video-row:active { cursor: grabbing; }
        .adm-video-row.drag-over { background: #f3f0fa; box-shadow: 0 0 0 2px #6f54a4; }
        .adm-video-row.dragging  { opacity: .4; }
        .adm-drag-handle { color: #bbb; padding: 0 8px; cursor: grab; font-size: 18px; line-height: 1; }
        .adm-pkg-chip { display:inline-block; font-size:11px; background:#ede9f7; color:#6f54a4;
                        border-radius:20px; padding:2px 8px; margin:2px; white-space:nowrap; }
        .adm-video-url { font-size:11.5px; color:#888; max-width:280px;
                         overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="adm-main">
        @include('admin.partials.topbar', ['title' => 'Videos verwalten'])

        <div class="adm-content">
            <div class="adm-page-header" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h1>Kurs-Videos</h1>
                    <p>Videos per Drag &amp; Drop sortieren. Nur aktive Videos werden im Dashboard gezeigt.</p>
                </div>
                <a href="{{ route('admin.videos.create') }}" class="adm-btn adm-btn--primary">
                    <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Neues Video
                </a>
            </div>

            @if(session('success'))
                <div class="adm-alert adm-alert--success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="adm-table-card">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width:36px;"></th>
                            <th>#</th>
                            <th>Titel</th>
                            <th>Tag / Dauer</th>
                            <th>Pakete</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody id="videoTableBody">
                        @foreach($videos as $video)
                        <tr class="adm-video-row" data-id="{{ $video->id }}"
                            draggable="true">
                            <td>
                                <span class="adm-drag-handle" title="Ziehen zum Sortieren">⠿</span>
                            </td>
                            <td style="color:#aaa;font-size:12px;">{{ $video->sort_order }}</td>
                            <td>
                                <span style="font-weight:600;">{{ $video->title }}</span>
                                @if($video->description)
                                    <span style="display:block;font-size:11.5px;color:#888;margin-top:2px;">
                                        {{ Str::limit($video->description, 60) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($video->tag)
                                    <span class="adm-pkg-chip">{{ $video->tag }}</span>
                                @endif
                                @if($video->duration)
                                    <span style="font-size:12px;color:#666;display:block;margin-top:3px;">
                                        ⏱ {{ $video->duration }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @forelse($video->packages as $pkg)
                                    <span class="adm-pkg-chip">{{ $pkg->name }}</span>
                                @empty
                                    <span style="color:#ccc;font-size:12px;">—</span>
                                @endforelse
                            </td>
                            <td>
                                <span class="adm-video-url" title="{{ $video->video_url }}">
                                    {{ $video->video_url }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.videos.update', $video) }}"
                                      style="display:inline;" id="toggle-{{ $video->id }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="title"       value="{{ $video->title }}">
                                    <input type="hidden" name="video_url"   value="{{ $video->video_url }}">
                                    <input type="hidden" name="sort_order"  value="{{ $video->sort_order }}">
                                    <input type="hidden" name="is_active"   value="{{ $video->is_active ? 0 : 1 }}">
                                    <button type="submit"
                                        class="adm-status-toggle {{ $video->is_active ? 'adm-status-toggle--active' : 'adm-status-toggle--inactive' }}">
                                        {{ $video->is_active ? 'Aktiv' : 'Inaktiv' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="adm-actions">
                                    <a href="{{ route('admin.videos.edit', $video) }}"
                                       class="adm-action-btn adm-action-btn--edit" title="Bearbeiten">
                                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}"
                                          data-confirm="true" data-confirm-type="Video"
                                          data-confirm-name="{{ $video->title }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="adm-action-btn adm-action-btn--delete" title="Löschen">
                                            <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($videos->isEmpty())
                    <div style="text-align:center;padding:48px;color:#aaa;">
                        <p>Noch keine Videos vorhanden. Klicken Sie auf "Neues Video".</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('admin.partials.delete-modal')

    <script>
    (function () {
        const tbody    = document.getElementById('videoTableBody');
        const reorder  = '{{ route('admin.videos.reorder') }}';
        const csrfToken = '{{ csrf_token() }}';

        if (!tbody) return;

        let dragged = null;

        tbody.addEventListener('dragstart', e => {
            dragged = e.target.closest('tr');
            if (!dragged) return;
            dragged.classList.add('dragging');
        });

        tbody.addEventListener('dragend', () => {
            if (dragged) dragged.classList.remove('dragging');
            document.querySelectorAll('.drag-over').forEach(r => r.classList.remove('drag-over'));
            dragged = null;
        });

        tbody.addEventListener('dragover', e => {
            e.preventDefault();
            const row = e.target.closest('tr');
            if (!row || row === dragged) return;
            document.querySelectorAll('.drag-over').forEach(r => r.classList.remove('drag-over'));
            row.classList.add('drag-over');
        });

        tbody.addEventListener('drop', e => {
            e.preventDefault();
            const target = e.target.closest('tr');
            if (!target || target === dragged) return;

            const rows  = [...tbody.querySelectorAll('tr')];
            const dragI = rows.indexOf(dragged);
            const dropI = rows.indexOf(target);

            if (dragI < dropI) {
                tbody.insertBefore(dragged, target.nextSibling);
            } else {
                tbody.insertBefore(dragged, target);
            }

            /* Update sort-order display + persist */
            const newOrder = [...tbody.querySelectorAll('tr[data-id]')].map(r => parseInt(r.dataset.id));

            newOrder.forEach((id, i) => {
                const row = tbody.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    const numCell = row.querySelectorAll('td')[1];
                    if (numCell) numCell.textContent = i;
                }
            });

            fetch(reorder, {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ order: newOrder }),
            });
        });
    })();
    </script>
</body>
</html>