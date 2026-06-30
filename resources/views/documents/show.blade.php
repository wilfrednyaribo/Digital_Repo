<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    nav[class*="bg-white"][class*="border-b"] { display: none !important; }
    body { 
        padding-top: 0 !important; overflow: hidden !important; font-family: 'Inter', sans-serif; 
        background: #f0f4f8; color: #1e293b; margin: 0;
    }
    
    /* ═══════════════════════════════════════════
       SIDEBAR STYLES
    ═══════════════════════════════════════════ */
    .sidebar {
        width: 272px; 
        background: linear-gradient(180deg, #ffffff 0%, #f8fffe 50%, #f0fdfa 100%); 
        border-right: 1px solid #e2e8f0;
        display: flex; flex-direction: column; position: fixed; height: 100%; left: 0; top: 0; z-index: 1000;
        box-shadow: 2px 0 20px rgba(0, 0, 0, 0.03);
    }
    .sidebar-header { 
        padding: 1.5rem 1.25rem; 
        border-bottom: 1px solid rgba(13, 148, 136, 0.08);
        background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);
    }
    .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
    .brand-icon {
        width: 40px; height: 40px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
    }
    .brand-text { font-size: 1.15rem; font-weight: 800; color: #0f766e; letter-spacing: -0.02em; }
    .brand-badge { font-size: 0.55rem; background: #ccfbf1; color: #0d9488; padding: 2px 6px; border-radius: 6px; font-weight: 700; letter-spacing: 0.05em; margin-left: auto; }
    .sidebar-nav { flex: 1; overflow-y: auto; padding: 1rem 0.75rem; }
    .sidebar-nav::-webkit-scrollbar { width: 3px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .nav-section-label { padding: 0.9rem 0.75rem 0.4rem; color: #94a3b8; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; }
    .menu-group { margin-bottom: 0.25rem; }
    .menu-header {
        display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0.75rem;
        color: #94a3b8; font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.06em; cursor: pointer; user-select: none; border-radius: 8px; transition: all 0.2s;
    }
    .menu-header:hover { color: #0d9488; background: rgba(13, 148, 136, 0.04); }
    .menu-arrow { font-size: 0.6rem; transition: transform 0.3s ease; }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; }
    .submenu.open { max-height: 500px; }
    .menu-header.active .menu-arrow { transform: rotate(180deg); }
    .nav-link {
        display: flex; align-items: center; padding: 0.6rem 0.85rem; color: #64748b; text-decoration: none;
        border-radius: 10px; margin-bottom: 2px; font-size: 0.82rem; font-weight: 500;
        transition: all 0.2s ease; position: relative;
    }
    .nav-link i { width: 20px; margin-right: 10px; font-size: 0.85rem; transition: all 0.2s; text-align: center; }
    .nav-link:hover { background-color: #f1f5f9; color: #0f766e; }
    .nav-link:hover i { transform: scale(1.1); color: #0d9488; }
    .nav-link.active { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0f766e; font-weight: 600; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.1); }
    .nav-link.active i { color: #0d9488; }
    .nav-link .nav-badge { margin-left: auto; background: #0d9488; color: white; font-size: 0.6rem; padding: 1px 7px; border-radius: 10px; font-weight: 700; }
    .sidebar-footer { padding: 0.75rem; border-top: 1px solid #e2e8f0; background: rgba(255,255,255,0.9); }
    .user-card { display: flex; align-items: center; padding: 0.6rem 0.75rem; border-radius: 12px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; }
    .user-avatar-sidebar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; box-shadow: 0 2px 6px rgba(13, 148, 136, 0.3); }
    .user-info { margin-left: 10px; flex: 1; }
    .user-name { font-size: 0.82rem; font-weight: 600; color: #1e293b; display: block; }
    .user-role { font-size: 0.68rem; color: #94a3b8; font-weight: 500; }
    .logout-link { display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.55rem; color: #ef4444; background: #fef2f2; text-decoration: none; border-radius: 10px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; margin-top: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.1); }
    .logout-link:hover { background: #fee2e2; }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    .main-content { margin-left: 272px; flex: 1; display: flex; flex-direction: column; overflow: hidden; min-height: 0; }
    .scroll-area {
        flex: 1; min-height: 0; overflow-y: auto !important;
        padding: 1.75rem 2rem 2rem;
        scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;
    }
    .scroll-area::-webkit-scrollbar { width: 6px; }
    .scroll-area::-webkit-scrollbar-track { background: transparent; }
    .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .scroll-area::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* ═══════════════════════════════════════════
       TOP BAR
    ═══════════════════════════════════════════ */
    .top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; }
    .breadcrumb a { color: #64748b; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
    .breadcrumb a:hover { color: #0d9488; }
    .breadcrumb .sep { color: #e2e8f0; font-size: 0.6rem; }
    .breadcrumb .current { color: #0f172a; font-size: 0.8rem; font-weight: 700; }
    .btn-back {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; font-size: 0.8rem; font-weight: 600;
        border-radius: 10px; text-decoration: none; color: #475569;
        background: white; border: 1px solid #e2e8f0;
        transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .btn-back:hover { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; transform: translateX(-2px); }
    .btn-back i { font-size: 0.7rem; transition: transform 0.2s; }
    .btn-back:hover i { transform: translateX(-3px); }

    /* ═══════════════════════════════════════════
       DOC HEADER CARD
    ═══════════════════════════════════════════ */
    .doc-header-card {
        background: white; border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden; margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        animation: fadeSlideUp 0.5s ease both;
    }
    @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    .doc-header-top { display: flex; gap: 0; }
    .doc-preview-strip {
        width: 220px; min-height: 200px; flex-shrink: 0;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        border-right: 1px solid #f1f5f9;
    }
    .doc-preview-strip img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .doc-preview-strip:hover img { transform: scale(1.05); }
    .doc-preview-strip .strip-fake {
        width: 100%; height: 100%;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem;
    }
    .strip-fake .strip-icon {
        width: 56px; height: 56px; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: white; box-shadow: 0 8px 20px rgba(0,0,0,0.18);
    }
    .strip-fake .strip-type { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; }
    .strip-fake .strip-filename {
        font-size: 0.68rem; font-weight: 600; color: #64748b;
        max-width: 90%; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        padding: 4px 10px; background: rgba(255,255,255,0.7); border-radius: 6px; backdrop-filter: blur(4px);
    }
    .strip-fake.pdf-strip { background: linear-gradient(160deg, #fef2f2 0%, #fee2e2 100%); }
    .strip-fake.pdf-strip .strip-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .strip-fake.word-strip { background: linear-gradient(160deg, #eff6ff 0%, #dbeafe 100%); }
    .strip-fake.word-strip .strip-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .strip-fake.default-strip { background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 100%); }
    .strip-fake.default-strip .strip-icon { background: linear-gradient(135deg, #64748b, #475569); }
    .doc-header-body { flex: 1; padding: 1.75rem 2rem; display: flex; flex-direction: column; }
    .doc-title-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
    .doc-title-row h1 { margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; line-height: 1.25; }
    .doc-visibility-badge {
        display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px;
        border-radius: 8px; font-size: 0.65rem; font-weight: 700; flex-shrink: 0;
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .doc-visibility-badge.public { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .doc-visibility-badge.private { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .doc-description { font-size: 0.88rem; color: #64748b; line-height: 1.7; flex: 1; }
    .doc-description.none { color: #cbd5e1; font-style: italic; }

    /* ═══════════════════════════════════════════
       META STRIP
    ═══════════════════════════════════════════ */
    .doc-meta-strip { display: flex; border-top: 1px solid #f1f5f9; gap: 0; }
    .meta-chip {
        flex: 1; display: flex; align-items: center; gap: 10px;
        padding: 1rem 1.25rem; border-right: 1px solid #f1f5f9; transition: background 0.2s;
    }
    .meta-chip:last-child { border-right: none; }
    .meta-chip:hover { background: #fafbfc; }
    .meta-chip-icon {
        width: 38px; height: 38px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;
    }
    .meta-chip-icon.author-icon { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #7c3aed; }
    .meta-chip-icon.category-icon { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; }
    .meta-chip-icon.size-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
    .meta-chip-icon.date-icon { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7; }
    .meta-chip-label { font-size: 0.62rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 2px; }
    .meta-chip-value { font-size: 0.82rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* ═══════════════════════════════════════════
       ACTION BAR
    ═══════════════════════════════════════════ */
    .action-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.25rem; gap: 1rem; flex-wrap: wrap;
        animation: fadeSlideUp 0.5s ease 0.1s both;
    }
    .action-bar-left { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .action-bar-right { display: flex; align-items: center; gap: 0.75rem; }
    .btn-action {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 22px; font-size: 0.82rem; font-weight: 600;
        border-radius: 12px; text-decoration: none; border: none;
        cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); white-space: nowrap;
    }
    .btn-action i { font-size: 0.85rem; }
    .btn-download {
        background: linear-gradient(135deg, #0d9488, #0f766e);
        color: white; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
    }
    .btn-download:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(13, 148, 136, 0.45); }
    .btn-open-new {
        background: white; color: #4f46e5;
        border: 1.5px solid rgba(79, 70, 229, 0.15);
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.06);
    }
    .btn-open-new i { color: #6366f1; }
    .btn-open-new:hover { background: #eef2ff; border-color: rgba(79, 70, 229, 0.4); transform: translateY(-2px); }
    .btn-delete {
        background: white; color: #dc2626;
        border: 1.5px solid rgba(220, 38, 38, 0.12);
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.04);
    }
    .btn-delete i { color: #ef4444; }
    .btn-delete:hover { background: #fef2f2; border-color: rgba(220, 38, 38, 0.3); transform: translateY(-2px); }

    /* ═══════════════════════════════════════════
       VIEWER CONTAINER
    ═══════════════════════════════════════════ */
    .viewer-wrapper {
        background: white; border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        animation: fadeSlideUp 0.5s ease 0.2s both;
    }
    .viewer-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.7rem 1.5rem; background: linear-gradient(180deg, #fafbfc, #f8fafc);
        border-bottom: 1px solid #f1f5f9;
    }
    .viewer-toolbar-left { display: flex; align-items: center; gap: 8px; }
    .viewer-toolbar-right { display: flex; align-items: center; gap: 6px; }
    .viewer-label { font-size: 0.82rem; font-weight: 700; color: #334155; display: flex; align-items: center; gap: 8px; }
    .viewer-label .dot { width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.5); animation: pulse-dot 2s infinite; }
    @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    .toolbar-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 600;
        background: white; border: 1px solid #e2e8f0; color: #475569;
    }
    .toolbar-chip i { font-size: 0.65rem; color: #94a3b8; }
    .viewer-content { height: 72vh; min-height: 480px; position: relative; background: #e8ecf1; }
    .viewer-content::before {
        content: ''; position: absolute; inset: 0; z-index: 1; pointer-events: none;
        background: radial-gradient(ellipse at center, transparent 60%, rgba(0,0,0,0.03) 100%);
    }
    .viewer-content iframe { width: 100%; height: 100%; border: none; display: block; position: relative; z-index: 0; }
    .viewer-content img {
        max-width: 100%; max-height: 100%; object-fit: contain;
        display: block; margin: 0 auto; padding: 2rem; position: relative; z-index: 0;
        border-radius: 4px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    .viewer-fallback { display: flex; align-items: center; justify-content: center; height: 100%; width: 100%; }
    .fallback-inner { text-align: center; }
    .fallback-icon-wrap {
        width: 88px; height: 88px; border-radius: 28px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .fallback-icon-wrap i { font-size: 2.2rem; color: #94a3b8; }
    .fallback-inner h3 { font-size: 1.1rem; font-weight: 700; color: #334155; margin: 0 0 0.5rem; }
    .fallback-inner p { font-size: 0.88rem; color: #94a3b8; margin: 0 0 1.5rem; max-width: 320px; }

    /* ═══════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .sidebar { width: 240px; }
        .main-content { margin-left: 240px; }
        .doc-preview-strip { width: 170px; min-height: 170px; }
    }
    @media (max-width: 900px) {
        .doc-header-top { flex-direction: column; }
        .doc-preview-strip { width: 100%; min-height: 150px; border-right: none; border-bottom: 1px solid #f1f5f9; }
        .doc-meta-strip { flex-wrap: wrap; }
        .meta-chip { min-width: calc(50% - 1px); }
    }
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .main-content { margin-left: 0; }
        .scroll-area { padding: 1rem; }
        .doc-title-row { flex-direction: column; }
        .action-bar { flex-direction: column; align-items: stretch; }
        .action-bar-left, .action-bar-right { justify-content: center; }
        .viewer-content { height: 55vh; min-height: 300px; }
        .top-bar { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
    }
</style>

<x-app-layout>
    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; z-index: 999;">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="brand">
                    <div class="brand-icon"><i class="fas fa-landmark"></i></div>
                    <div class="brand-text">DigiRepo</div>
                    <span class="brand-badge">v2.0</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section-label">Main</div>
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-gauge-high"></i><span>Dashboard</span></a>
                <div class="nav-section-label">Discover</div>
                <a href="{{ route('documents.index') }}" class="nav-link active"><i class="fas fa-compass"></i><span>Browse All</span></a>
                <a href="{{ route('documents.index', ['sort' => 'newest']) }}" class="nav-link"><i class="fas fa-clock-rotate-left"></i><span>Recent Additions</span></a>
                <div class="nav-section-label">Repository</div>
                <div class="menu-group">
                    <div class="menu-header active" onclick="toggleMenu(this)"><span>By Type</span><i class="fas fa-chevron-down menu-arrow"></i></div>
                    <div class="submenu open">
                        <a href="{{ route('documents.index', ['type' => 'book']) }}" class="nav-link"><i class="fas fa-book"></i> Books & Monographs</a>
                        <a href="{{ route('documents.index', ['type' => 'record']) }}" class="nav-link"><i class="fas fa-file-shield"></i> Archives & Records</a>
                        <a href="{{ route('documents.index', ['type' => 'file']) }}" class="nav-link"><i class="fas fa-photo-film"></i> Media & Files</a>
                        <a href="{{ route('documents.index', ['type' => 'thesis']) }}" class="nav-link"><i class="fas fa-graduation-cap"></i> Theses & Dissertations</a>
                    </div>
                </div>
                @auth
                <div class="menu-group">
                    <div class="menu-header" onclick="toggleMenu(this)"><span>My Workspace</span><i class="fas fa-chevron-down menu-arrow"></i></div>
                    <div class="submenu">
                        <a href="{{ route('documents.index', ['my_uploads' => auth()->id()]) }}" class="nav-link"><i class="fas fa-user-clock"></i> My Uploads</a>
                        <a href="#" class="nav-link"><i class="fas fa-heart"></i> Favorites</a>
                    </div>
                </div>
                @endauth
            </nav>
            @auth
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar-sidebar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="user-info"><span class="user-name">{{ Auth::user()->name }}</span><span class="user-role">Administrator</span></div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 0.5rem;">@csrf<button type="submit" class="logout-link"><i class="fas fa-sign-out-alt" style="margin-right: 6px;"></i> Sign Out</button></form>
            </div>
            @endauth
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="scroll-area">

                <!-- TOP BAR -->
                <div class="top-bar">
                    <div class="breadcrumb">
                        <a href="{{ route('dashboard') }}"><i class="fas fa-house" style="font-size: 0.7rem;"></i> Home</a>
                        <span class="sep"><i class="fas fa-chevron-right"></i></span>
                        <a href="{{ route('documents.index') }}"><i class="fas fa-folder-open" style="font-size: 0.7rem;"></i> Repository</a>
                        <span class="sep"><i class="fas fa-chevron-right"></i></span>
                        <span class="current">Document View</span>
                    </div>
                    <a href="{{ route('documents.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Repository
                    </a>
                </div>

                <!-- DOCUMENT HEADER CARD -->
                <div class="doc-header-card">
                    <div class="doc-header-top">
                        <div class="doc-preview-strip" style="background: linear-gradient(160deg, #f8fafc, #f1f5f9);">
                            @if(in_array($document->file_type, ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->title }}">
                            @elseif($document->file_type == 'pdf')
                                <div class="strip-fake pdf-strip">
                                    <div class="strip-icon"><i class="fas fa-file-pdf"></i></div>
                                    <span class="strip-type">PDF Document</span>
                                    <span class="strip-filename">{{ $document->title }}</span>
                                </div>
                            @elseif(in_array($document->file_type, ['doc', 'docx']))
                                <div class="strip-fake word-strip">
                                    <div class="strip-icon"><i class="fas fa-file-word"></i></div>
                                    <span class="strip-type">Word Document</span>
                                    <span class="strip-filename">{{ $document->title }}</span>
                                </div>
                            @else
                                <div class="strip-fake default-strip">
                                    <div class="strip-icon"><i class="fas fa-file-lines"></i></div>
                                    <span class="strip-type">{{ strtoupper($document->file_type) }} File</span>
                                    <span class="strip-filename">{{ $document->title }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="doc-header-body">
                            <div class="doc-title-row">
                                <h1>{{ $document->title }}</h1>
                                <span class="doc-visibility-badge {{ $document->is_public ? 'public' : 'private' }}">
                                    <i class="fas fa-{{ $document->is_public ? 'globe' : 'lock' }}" style="font-size: 0.6rem;"></i>
                                    {{ $document->is_public ? 'Public' : 'Private' }}
                                </span>
                            </div>
                            <p class="doc-description {{ $document->description ? '' : 'none' }}">
                                {{ $document->description ?? 'No description provided for this document.' }}
                            </p>
                        </div>
                    </div>
                    <div class="doc-meta-strip">
                        <div class="meta-chip">
                            <div class="meta-chip-icon author-icon"><i class="fas fa-user-pen"></i></div>
                            <div>
                                <div class="meta-chip-label">Author</div>
                                <div class="meta-chip-value">{{ $document->author_creator ?? 'Unknown' }}</div>
                            </div>
                        </div>
                        <div class="meta-chip">
                            <div class="meta-chip-icon category-icon"><i class="fas fa-tag"></i></div>
                            <div>
                                <div class="meta-chip-label">Category</div>
                                <div class="meta-chip-value">{{ $document->category->name ?? 'Uncategorized' }}</div>
                            </div>
                        </div>
                        <div class="meta-chip">
                            <div class="meta-chip-icon size-icon"><i class="fas fa-hard-drive"></i></div>
                            <div>
                                <div class="meta-chip-label">File Size</div>
                                <div class="meta-chip-value">{{ $document->formatted_file_size }}</div>
                            </div>
                        </div>
                        <div class="meta-chip">
                            <div class="meta-chip-icon date-icon"><i class="fas fa-calendar-check"></i></div>
                            <div>
                                <div class="meta-chip-label">Uploaded</div>
                                <div class="meta-chip-value">{{ $document->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BAR -->
                <div class="action-bar">
                    <div class="action-bar-left">
                        <a href="{{ route('documents.download', $document) }}" class="btn-action btn-download">
                            <i class="fas fa-download"></i> Download File
                        </a>
                        @if($document->file_type == 'pdf')
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn-action btn-open-new">
                                <i class="fas fa-up-right-from-square"></i> Open in New Tab
                            </a>
                        @endif
                    </div>
                    <div class="action-bar-right">
                        @auth
                            <button type="button" onclick="handleDelete()" class="btn-action btn-delete" id="deleteBtn">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        @endauth
                    </div>
                </div>

                <!-- VIEWER -->
                <div class="viewer-wrapper">
                    <div class="viewer-toolbar">
                        <div class="viewer-toolbar-left">
                            <span class="viewer-label"><span class="dot"></span> Document Preview</span>
                        </div>
                        <div class="viewer-toolbar-right">
                            <span class="toolbar-chip"><i class="fas fa-file"></i> {{ strtoupper($document->file_type) }}</span>
                            <span class="toolbar-chip"><i class="fas fa-weight-hanging"></i> {{ $document->formatted_file_size }}</span>
                            <span class="toolbar-chip"><i class="fas fa-calendar"></i> {{ $document->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                    </div>
                    <div class="viewer-content">
                        @if(in_array($document->file_type, ['jpg', 'jpeg', 'png']))
                            <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->title }}">
                        @elseif($document->file_type == 'pdf')
                            <iframe src="{{ Storage::url($document->file_path) }}"></iframe>
                        @else
                            <div class="viewer-fallback">
                                <div class="fallback-inner">
                                    <div class="fallback-icon-wrap"><i class="fas fa-file-circle-question"></i></div>
                                    <h3>Preview Not Available</h3>
                                    <p>This file type ({{ strtoupper($document->file_type) }}) cannot be previewed in the browser.</p>
                                    <a href="{{ route('documents.download', $document) }}" class="btn-action btn-download" style="display: inline-flex;">
                                        <i class="fas fa-download"></i> Download to View
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleMenu(header) {
        header.classList.toggle('active');
        header.nextElementSibling.classList.toggle('open');
    }

    function handleDelete() {
        Swal.fire({
            title: 'Delete this document?',
            html: '<p style="color:#64748b;font-size:0.9rem;margin:0;">This action is permanent and cannot be undone. The file will be removed from the repository.</p>' +
                 '<div style="margin-top:12px;padding:8px 14px;background:#fff;border:1px solid #fecaca;border-radius:8px;font-size:0.82rem;font-weight:600;color:#dc2626;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $document->title }}">{{ $document->title }}</div>',
            icon: 'warning',
            iconColor: '#dc2626',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: '<i class="fas fa-trash-alt" style="margin-right:6px;"></i> Yes, delete it',
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#64748b',
            focusConfirm: false,
            customClass: { popup: 'border-radius:20px;' },
            showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' },
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while the file is being removed.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("documents.destroy", $document) }}', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'The document has been permanently removed.',
                        confirmButtonColor: '#0d9488',
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: { popup: 'border-radius:20px;' },
                        willClose: function() {
                            window.location.href = '{{ route("dashboard") }}';
                        }
                    });
                };
                xhr.onerror = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Network error. Please check your connection and try again.',
                        confirmButtonColor: '#64748b',
                        customClass: { popup: 'border-radius:20px;' }
                    });
                };
                xhr.send(new FormData(document.getElementById('deleteFormHidden')));
            }
        });
    }
</script>

<!-- Hidden form for CSRF token only -->
<form id="deleteFormHidden" action="{{ route('documents.destroy', $document) }}" method="POST" style="display:none;">
    @method('DELETE')
    @csrf
</form>