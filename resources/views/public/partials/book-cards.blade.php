@foreach($documents as $doc)
    @php
        $coverClass = 'def-bg'; $coverIcon = 'fa-file-lines'; $badgeClass = 'def';
        if($doc->file_type == 'pdf') { $coverClass = 'pdf-bg'; $coverIcon = 'fa-file-pdf'; $badgeClass = 'pdf'; }
        elseif(in_array($doc->file_type, ['doc','docx'])) { $coverClass = 'word-bg'; $coverIcon = 'fa-file-word'; $badgeClass = 'doc'; }
    @endphp
    <div class="r-book" data-title="{{ strtolower($doc->title) }}" data-file-url="{{ Storage::url($doc->file_path) }}" data-author="{{ $doc->author_creator ?? 'Unknown' }}" data-file-type="{{ $doc->file_type }}">
        <div class="r-book-cover" onclick="openReaderFromCard(this.closest('.r-book'))">
            @if($doc->cover_image)
                <img src="{{ Storage::url($doc->cover_image) }}" alt="{{ $doc->title }}" loading="lazy">
            @elseif(in_array($doc->file_type, ['jpg','jpeg','png']))
                <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->title }}" loading="lazy">
            @else
                <div class="r-fake {{ $coverClass }}"><div class="r-fake-icon"><i class="fas {{ $coverIcon }}"></i></div><div class="r-fake-title">{{ $doc->title }}</div></div>
            @endif
            <div class="r-book-spine"></div>
            <div class="r-book-read-badge"><i class="fas fa-book-open" style="margin-right:3px;"></i> Read</div>
        </div>
        <div class="r-book-info">
            <div class="r-book-title">{{ $doc->title }}</div>
            <div class="r-book-author">{{ $doc->author_creator ?? 'Unknown Author' }}</div>
            <div class="r-book-meta"><span class="r-file-badge {{ $badgeClass }}">{{ strtoupper($doc->file_type) }}</span><span>{{ $doc->created_at->format('M Y') }}</span></div>
            <button class="r-read-btn" onclick="openReaderFromCard(this.closest('.r-book'))"><i class="fas fa-book-open"></i> Read Now</button>
        </div>
    </div>
@endforeach