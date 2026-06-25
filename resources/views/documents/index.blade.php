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
    .nav-link .nav-badge.warning { background: #f59e0b; color: white; }

    .sidebar-footer { padding: 0.75rem; border-top: 1px solid #e2e8f0; background: rgba(255,255,255,0.9); }
    .user-card { display: flex; align-items: center; padding: 0.6rem 0.75rem; border-radius: 12px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; }
    .user-avatar-sidebar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; box-shadow: 0 2px 6px rgba(13, 148, 136, 0.3); }
    .user-info { margin-left: 10px; flex: 1; }
    .user-name { font-size: 0.82rem; font-weight: 600; color: #1e293b; display: block; }
    .user-role { font-size: 0.68rem; color: #94a3b8; font-weight: 500; }
    .logout-link { display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.55rem; color: #ef4444; background: #fef2f2; text-decoration: none; border-radius: 10px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; margin-top: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.1); }
    .logout-link:hover { background: #fee2e2; border-color: rgba(239, 68, 68, 0.2); }

    /* ═══════════════════════════════════════════
       MAIN CONTENT STYLES
    ═══════════════════════════════════════════ */
    .main-content { margin-left: 272px; flex: 1; padding: 1.75rem 2rem; width: calc(100% - 272px); display: flex; flex-direction: column; overflow: hidden; min-height: 0; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.75rem; flex-shrink: 0; }
    .page-header-left h1 { margin: 0; font-size: 1.65rem; color: #0f172a; font-weight: 800; letter-spacing: -0.02em; background: linear-gradient(135deg, #0f172a, #334155); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .page-header-left p { color: #94a3b8; margin: 6px 0 0 0; font-size: 0.88rem; font-weight: 400; }
    .page-header-left .header-date { display: inline-flex; align-items: center; gap: 6px; margin-top: 8px; font-size: 0.75rem; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; }

    .header-actions { display: flex; gap: 0.75rem; align-items: center; }
    .btn-upload { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; font-size: 0.82rem; font-weight: 600; border-radius: 12px; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1.5px solid transparent; cursor: pointer; white-space: nowrap; background: none; }
    .btn-upload.primary { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35); }
    .btn-upload.primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(13, 148, 136, 0.45); }
    .btn-upload.file { background: white; color: #4f46e5; border-color: rgba(79, 70, 229, 0.15); box-shadow: 0 2px 8px rgba(79, 70, 229, 0.06); }
    .btn-upload.file i { color: #6366f1; }
    .btn-upload.file:hover { background: #eef2ff; border-color: rgba(79, 70, 229, 0.4); transform: translateY(-2px); }
    .btn-upload.book { background: white; color: #7c3aed; border-color: rgba(124, 58, 237, 0.15); box-shadow: 0 2px 8px rgba(124, 58, 237, 0.06); }
    .btn-upload.book i { color: #8b5cf6; }
    .btn-upload.book:hover { background: #f5f3ff; border-color: rgba(124, 58, 237, 0.4); transform: translateY(-2px); }

    /* ═══ ADD CATEGORY BUTTON ═══ */
    .btn-upload.add-category {
        background: white;
        color: #d97706;
        border-color: rgba(217, 119, 6, 0.15);
        box-shadow: 0 2px 8px rgba(217, 119, 6, 0.06);
        position: relative;
        overflow: hidden;
    }
    .btn-upload.add-category i { color: #f59e0b; }
    .btn-upload.add-category:hover {
        background: #fffbeb;
        border-color: rgba(217, 119, 6, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(217, 119, 6, 0.15);
    }
    .btn-upload.add-category::after {
        content: '';
        position: absolute;
        top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.06), transparent);
        transition: left 0.5s ease;
    }
    .btn-upload.add-category:hover::after { left: 100%; }

    .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; font-size: 0.85rem; font-weight: 600; border-radius: 12px; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4); }

    /* ═══════════════════════════════════════════
       SCROLLABLE CONTENT AREA
    ═══════════════════════════════════════════ */
    .scroll-area {
        flex: 1;
        min-height: 0;
        overflow-y: auto !important;
        padding-bottom: 2rem;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .scroll-area::-webkit-scrollbar { width: 6px; }
    .scroll-area::-webkit-scrollbar-track { background: transparent; }
    .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .scroll-area::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.75rem; }
    .stat-card { background: white; border-radius: 16px; border: 1px solid rgba(226, 232, 240, 0.8); padding: 1.35rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: default; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 16px 16px 0 0; }
    .stat-card::after { content: ''; position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; opacity: 0.04; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); border-color: transparent; }
    .stat-card.blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); } .stat-card.blue::after { background: #3b82f6; } .stat-card.blue:hover { box-shadow: 0 12px 24px rgba(59, 130, 246, 0.12); }
    .stat-card.green::before { background: linear-gradient(90deg, #10b981, #34d399); } .stat-card.green::after { background: #10b981; } .stat-card.green:hover { box-shadow: 0 12px 24px rgba(16, 185, 129, 0.12); }
    .stat-card.orange::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); } .stat-card.orange::after { background: #f59e0b; } .stat-card.orange:hover { box-shadow: 0 12px 24px rgba(245, 158, 11, 0.12); }
    .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); } .stat-card.purple::after { background: #8b5cf6; } .stat-card.purple:hover { box-shadow: 0 12px 24px rgba(139, 92, 246, 0.12); }
    .stat-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: white; }
    .stat-card.blue .stat-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .stat-card.green .stat-icon { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .stat-card.orange .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    .stat-card.purple .stat-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); }
    .stat-trend { display: inline-flex; align-items: center; gap: 3px; font-size: 0.7rem; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
    .stat-trend.up { background: #ecfdf5; color: #059669; } .stat-trend.down { background: #fef2f2; color: #dc2626; } .stat-trend.neutral { background: #f1f5f9; color: #64748b; }
    .stat-label { font-size: 0.72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
    .stat-value { font-size: 1.75rem; font-weight: 800; color: #0f172a; line-height: 1; letter-spacing: -0.02em; }
    .stat-sub { font-size: 0.72rem; color: #94a3b8; margin-top: 6px; font-weight: 400; }

    /* ═══════════════════════════════════════════
       FILTER BAR
    ═══════════════════════════════════════════ */
    .filter-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; gap: 1rem; }
    .filter-bar h2 { font-size: 1.05rem; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px; }
    .filter-bar h2 .count-badge { font-size: 0.7rem; background: #f1f5f9; color: #64748b; padding: 2px 8px; border-radius: 8px; font-weight: 600; }
    .filter-controls { display: flex; gap: 0.5rem; align-items: center; }
    .search-box { position: relative; display: flex; align-items: center; }
    .search-box > i.fa-search { position: absolute; left: 12px; color: #94a3b8; font-size: 0.8rem; pointer-events: none; z-index: 2; }
    .search-box input { padding: 9px 38px 9px 36px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; width: 240px; transition: all 0.2s; color: #1e293b; }
    .search-box input:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
    .search-box input::placeholder { color: #cbd5e1; }
    .search-box .btn-reset {
        position: absolute; right: 8px; width: 26px; height: 26px;
        background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 7px;
        display: none; align-items: center; justify-content: center;
        cursor: pointer; color: #94a3b8; font-size: 0.65rem;
        transition: all 0.2s; padding: 0; z-index: 2;
    }
    .search-box .btn-reset:hover { background: #fee2e2; border-color: #fca5a5; color: #ef4444; }
    .search-box .btn-reset.visible { display: flex; }
    .filter-select { padding: 9px 32px 9px 12px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; color: #64748b; cursor: pointer; transition: all 0.2s; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; }
    .filter-select:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }

    /* ═══════════════════════════════════════════
       DOCUMENT CARDS — BOOK COVER STYLE
    ═══════════════════════════════════════════ */
   .doc-grid {
    width: 100%;
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(6, 1fr);
    transition: opacity 0.2s ease;
}

    .doc-card {
        background: white;
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .doc-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 16px 32px rgba(0,0,0,0.08);
        border-color: transparent;
    }

    .doc-cover {
    aspect-ratio: 2 / 3;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

    .doc-cover::after {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 8px;
        background: linear-gradient(90deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.05) 50%, transparent 100%);
        z-index: 5;
        pointer-events: none;
    }
    
    .doc-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.5s ease;
}
    .doc-card:hover .doc-cover img {
        transform: scale(1.05);
    }

    .doc-file-type-badge {
        position: absolute;
        bottom: 8px;
        left: 12px;
        z-index: 10;
        font-size: 0.55rem;
        padding: 3px 8px;
        border-radius: 5px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.25);
    }
    .doc-file-type-badge.pdf { background: rgba(220, 38, 38, 0.92); color: white; }
    .doc-file-type-badge.doc { background: rgba(37, 99, 235, 0.92); color: white; }
    .doc-file-type-badge.img { background: rgba(5, 150, 105, 0.92); color: white; }
    .doc-file-type-badge.default { background: rgba(71, 85, 105, 0.92); color: white; }

    .fake-cover {
        text-align: center;
        padding: 1rem;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(160deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 3px solid transparent;
    }
    .fake-cover.pdf { border-bottom-color: #ef4444; background: linear-gradient(160deg, #fef2f2 0%, #fff5f5 40%, #ffffff 100%); }
    .fake-cover.word { border-bottom-color: #3b82f6; background: linear-gradient(160deg, #eff6ff 0%, #f0f7ff 40%, #ffffff 100%); }
    .fake-cover.default { border-bottom-color: #94a3b8; }
    
    .fake-cover-icon {
        width: 52px; height: 52px; border-radius: 14px; margin-bottom: 0.75rem;
        display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
        box-shadow: 0 6px 16px -3px rgba(0,0,0,0.18);
    }
    .fake-cover.pdf .fake-cover-icon { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .fake-cover.word .fake-cover-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
    .fake-cover.default .fake-cover-icon { background: linear-gradient(135deg, #64748b, #475569); color: white; }
    
    .fake-cover-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #334155;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        padding: 0 0.75rem;
    }
    .fake-cover-subtitle {
        font-size: 0.65rem;
        color: #94a3b8;
        margin-top: 0.35rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .doc-details {
        padding: 0.85rem 0.9rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .doc-title {
        font-size: 0.84rem;
        font-weight: 700; color: #0f172a; margin-bottom: 0.3rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .doc-rating-stars {
        display: flex;
        align-items: center;
        gap: 1px;
        margin-bottom: 0.5rem;
    }
    .doc-rating-stars i {
        font-size: 0.68rem;
        color: #fbbf24;
    }
    .doc-rating-stars i.half {
        position: relative;
        color: #e2e8f0;
    }
    .doc-rating-stars i.half::before {
        content: '\f005';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        left: 0; top: 0;
        width: 50%;
        overflow: hidden;
        color: #fbbf24;
    }
    .doc-rating-stars i.empty {
        color: #e2e8f0;
    }

    .doc-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.3rem;
        margin-top: auto;
        margin-bottom: 0.7rem;
        padding-bottom: 0.7rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .meta-item {
        display: flex; align-items: center; gap: 4px; font-size: 0.66rem;
    }
    .meta-item i { color: #94a3b8; width: 12px; text-align: center; font-size: 0.58rem; }
    .meta-item span { color: #64748b; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .meta-item.full-width { grid-column: 1 / -1; }

    .doc-actions {
        display: flex;
        gap: 0.4rem;
    }
    .btn-doc {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 0.5rem 0.25rem;
        font-size: 0.68rem;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }
    .btn-doc-view {
        background: linear-gradient(135deg, #0d9488, #0f766e);
        color: white;
        box-shadow: 0 2px 4px rgba(13, 148, 136, 0.2);
    }
    .btn-doc-view:hover {
        box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
        transform: translateY(-1px);
        color: white;
    }
    .btn-doc-download {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .btn-doc-download:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .empty-state { grid-column: 1 / -1; background: white; border-radius: 16px; border: 2px dashed #e2e8f0; padding: 4rem 2rem; text-align: center; }
    .empty-icon { width: 72px; height: 72px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .empty-icon i { font-size: 1.75rem; color: #cbd5e1; }
    .empty-state h3 { font-size: 1rem; font-weight: 700; color: #334155; margin: 0 0 0.4rem; }
    .empty-state p { font-size: 0.82rem; color: #94a3b8; margin: 0; }

    .success-alert { margin-bottom: 1.5rem; padding: 12px 16px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0; border-radius: 12px; display: flex; align-items: center; gap: 10px; animation: slideDown 0.3s ease; }
    .success-alert-icon { width: 28px; height: 28px; background: #10b981; color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3); }
    .success-alert p { font-size: 0.85rem; font-weight: 500; color: #065f46; margin: 0; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 2rem; }
    .pagination a, .pagination span { padding: 8px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 500; border: 1px solid #e2e8f0; color: #64748b; text-decoration: none; transition: all 0.2s; }
    .pagination a:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .pagination .active { background: #0d9488; color: white; border-color: #0d9488; }
    .pagination .disabled { opacity: 0.4; pointer-events: none; }

    /* ═══════════════════════════════════════════
       BULLETPROOF CENTERED MODAL
    ═══════════════════════════════════════════ */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        z-index: 2000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
    }
    .modal-overlay.active { opacity: 1; pointer-events: auto; }

    .modal-panel {
        position: fixed;
        top: 50%; left: 50%; width: 660px; max-width: 95vw; max-height: 90vh; 
        background: white; z-index: 2001; border-radius: 1.5rem;
        box-shadow: 0 25px 60px -12px rgba(0,0,0,0.35);
        overflow: hidden;
        transform: translate(-50%, -50%) scale(0.95);
        opacity: 0; pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .modal-panel.active { transform: translate(-50%, -50%) scale(1); opacity: 1; pointer-events: auto; }

    .modal-panel form { display: flex; flex-direction: column; height: 100%; max-height: 90vh; }

    .modal-header {
        padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: #fafafa;
        display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;
    }
    .modal-header h2 { margin: 0; font-size: 1.15rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 10px; }
    .modal-close {
        width: 36px; height: 36px; border-radius: 10px; background: white; border: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; transition: all 0.2s;
    }
    .modal-close:hover { background: #f1f5f9; color: #0f172a; }

    .modal-body { flex: 1; overflow-y: auto; padding: 1.5rem; }
    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }

    .modal-footer { 
        padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9; background: white; 
        display: flex; justify-content: flex-end; gap: 0.75rem; flex-shrink: 0;
    }

    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%; padding: 0.65rem 0.85rem; border: 1px solid #e5e7eb; border-radius: 0.6rem;
        font-size: 0.85rem; color: #111827; background: white; transition: all 0.2s;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
    .form-input:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
    
    .drop-zone {
        border: 2px dashed #d1d5db; border-radius: 0.75rem; padding: 1.5rem; text-align: center;
        cursor: pointer; transition: all 0.2s; background: #f9fafb; position: relative;
    }
    .drop-zone:hover, .drop-zone.drag-over { border-color: #0d9488; background: rgba(13, 148, 136, 0.05); }
    .drop-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

    /* ═══════════════════════════════════════════
       COVER IMAGE UPLOAD IN MODAL
    ═══════════════════════════════════════════ */
    .cover-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #fafbfc, #f8f9ff);
        margin-bottom: 1.25rem;
    }
    .cover-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .cover-section-header .form-label { margin-bottom: 0; }
    .cover-hint {
        font-size: 0.68rem;
        color: #94a3b8;
        font-weight: 400;
    }
    .cover-drop-zone {
        border: 2px dashed #d1d5db;
        border-radius: 0.6rem;
        padding: 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        position: relative;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cover-drop-zone:hover, .cover-drop-zone.drag-over {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.03);
    }
    .cover-drop-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2;
    }
    .cover-preview-container {
        display: none;
        position: relative;
        width: 100%;
        text-align: center;
    }
    .cover-preview-container.active {
        display: block;
    }
    .cover-preview-img {
        max-width: 160px;
        max-height: 180px;
        object-fit: contain;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .cover-preview-remove {
        position: absolute;
        top: -4px;
        right: calc(50% - 90px);
        width: 24px;
        height: 24px;
        background: #ef4444;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        transition: all 0.2s;
        z-index: 5;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
    }
    .cover-preview-remove:hover {
        background: #dc2626;
        transform: scale(1.15);
    }
    .cover-auto-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.63rem;
        background: #ecfdf5;
        color: #059669;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
        margin-top: 8px;
        border: 1px solid #a7f3d0;
    }
    .cover-manual-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.63rem;
        background: #f5f3ff;
        color: #7c3aed;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
        margin-top: 8px;
        border: 1px solid #ddd6fe;
    }
    .cover-placeholder-text {
        color: #94a3b8;
        font-size: 0.78rem;
        line-height: 1.6;
    }
    .cover-placeholder-text i {
        font-size: 1.4rem;
        color: #cbd5e1;
        margin-bottom: 0.4rem;
        display: block;
    }
    .cover-loading {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 1rem;
        color: #0d9488;
        font-size: 0.78rem;
        font-weight: 500;
    }
    .cover-loading.active { display: flex; }
    .cover-loading .spinner {
        width: 18px; height: 18px;
        border: 2px solid #ccfbf1;
        border-top-color: #0d9488;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ═══════════════════════════════════════════
       STAR RATING SELECTOR IN MODAL
    ═══════════════════════════════════════════ */
    .star-rating-selector {
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .star-rating-selector .star-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        color: #e2e8f0;
        transition: all 0.15s ease;
        padding: 2px;
        line-height: 1;
    }
    .star-rating-selector .star-btn:hover,
    .star-rating-selector .star-btn.hovered {
        color: #fcd34d;
        transform: scale(1.2);
    }
    .star-rating-selector .star-btn.active {
        color: #fbbf24;
    }
    .star-rating-selector .star-btn.active:hover {
        filter: drop-shadow(0 0 6px rgba(251, 191, 36, 0.5));
    }
    .star-rating-label {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
        margin-left: 10px;
        min-width: 70px;
    }

    /* ═══════════════════════════════════════════
       CATEGORY MODAL (SMALLER, FOCUSED)
    ═══════════════════════════════════════════ */
    .cat-modal-panel {
        position: fixed;
        top: 50%; left: 50%; width: 440px; max-width: 95vw;
        background: white; z-index: 2001; border-radius: 1.25rem;
        box-shadow: 0 25px 60px -12px rgba(0,0,0,0.35);
        overflow: hidden;
        transform: translate(-50%, -50%) scale(0.95);
        opacity: 0; pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .cat-modal-panel.active { transform: translate(-50%, -50%) scale(1); opacity: 1; pointer-events: auto; }

    .cat-modal-header {
        padding: 1.15rem 1.35rem; border-bottom: 1px solid #f1f5f9; background: #fafafa;
        display: flex; justify-content: space-between; align-items: center;
    }
    .cat-modal-header h2 {
        margin: 0; font-size: 1.05rem; font-weight: 700; color: #0f172a;
        display: flex; align-items: center; gap: 10px;
    }
    .cat-modal-header h2 .cat-icon-box {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        display: flex; align-items: center; justify-content: center;
        color: #d97706; font-size: 0.85rem;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.25);
    }

    .cat-modal-body { padding: 1.35rem; }

    .cat-modal-footer {
        padding: 0.85rem 1.35rem; border-top: 1px solid #f1f5f9; background: white;
        display: flex; justify-content: flex-end; gap: 0.65rem;
    }

    .cat-form-input {
        width: 100%; padding: 0.7rem 1rem; border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #111827; background: white; transition: all 0.2s;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.04);
    }
    .cat-form-input:focus {
        outline: none; border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.12);
    }
    .cat-form-input::placeholder { color: #cbd5e1; }

    .cat-form-hint {
        display: flex; align-items: center; gap: 6px;
        margin-top: 0.6rem; font-size: 0.72rem; color: #94a3b8; font-weight: 500;
    }
    .cat-form-hint i { font-size: 0.68rem; color: #cbd5e1; }

    .cat-form-error {
        display: none; align-items: center; gap: 6px;
        margin-top: 0.6rem; font-size: 0.75rem; color: #dc2626; font-weight: 500;
        padding: 6px 10px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;
    }
    .cat-form-error.visible { display: flex; }
    .cat-form-error i { font-size: 0.7rem; }

    .cat-form-success {
        display: none; align-items: center; gap: 8px;
        margin-top: 0.6rem; font-size: 0.78rem; color: #059669; font-weight: 600;
        padding: 8px 12px; background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1px solid #a7f3d0; border-radius: 8px;
        animation: slideDown 0.3s ease;
    }
    .cat-form-success.visible { display: flex; }
    .cat-form-success i { font-size: 0.75rem; }

    .btn-cat-cancel {
        padding: 9px 18px; background: white; color: #64748b; font-size: 0.82rem;
        font-weight: 600; border-radius: 10px; border: 1px solid #e2e8f0;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-cat-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }

    .btn-cat-submit {
        padding: 9px 20px; background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white; font-size: 0.82rem; font-weight: 600; border-radius: 10px;
        border: none; cursor: pointer; transition: all 0.2s; display: inline-flex;
        align-items: center; gap: 6px;
        box-shadow: 0 3px 10px rgba(245, 158, 11, 0.3);
    }
    .btn-cat-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(245, 158, 11, 0.4);
    }
    .btn-cat-submit:disabled {
        opacity: 0.6; cursor: not-allowed; transform: none;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.15);
    }
    .btn-cat-submit .submit-spinner {
        display: none; width: 14px; height: 14px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white; border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    .btn-cat-submit.loading .submit-spinner { display: inline-block; }
    .btn-cat-submit.loading .submit-text { display: none; }

    /* Existing categories preview inside modal */
    .cat-existing-list {
        margin-top: 1rem; padding-top: 0.85rem; border-top: 1px solid #f1f5f9;
    }
    .cat-existing-label {
        font-size: 0.68rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;
    }
    .cat-existing-tags {
        display: flex; flex-wrap: wrap; gap: 6px; max-height: 90px; overflow-y: auto;
    }
    .cat-existing-tags::-webkit-scrollbar { width: 3px; }
    .cat-existing-tags::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
    .cat-existing-tag {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 6px; font-size: 0.7rem; font-weight: 500; color: #64748b;
        transition: all 0.15s;
    }
    .cat-existing-tag.newly-added {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-color: #fde68a;
        color: #d97706;
        font-weight: 600;
        animation: slideDown 0.3s ease;
    }
    .cat-existing-tag .tag-dot {
        width: 5px; height: 5px; border-radius: 50%; background: #cbd5e1;
    }
    .cat-existing-tag.newly-added .tag-dot { background: #f59e0b; }

    @media (max-width: 1600px) { 
    .doc-grid { grid-template-columns: repeat(5, 1fr); } 
}
@media (max-width: 1300px) { 
    .stats-grid { grid-template-columns: repeat(2, 1fr); } 
    .doc-grid { grid-template-columns: repeat(4, 1fr); } 
}
@media (max-width: 1024px) { 
    .sidebar { width: 240px; } 
    .main-content { margin-left: 240px; width: calc(100% - 240px); } 
    .doc-grid { grid-template-columns: repeat(3, 1fr); } 
}
@media (max-width: 768px) { 
    .stats-grid { grid-template-columns: 1fr; } 
    .doc-grid { grid-template-columns: repeat(2, 1fr); } 
    .modal-panel { width: 95vw; max-height: 95vh; } 
    .header-actions { flex-wrap: wrap; }
}
@media (max-width: 480px) { 
    .doc-grid { grid-template-columns: 1fr; } 
}
    @media (max-width: 1024px) { .sidebar { width: 240px; } .main-content { margin-left: 240px; width: calc(100% - 240px); } }
    @media (max-width: 768px) { 
        .stats-grid { grid-template-columns: 1fr; } 
        .doc-grid { grid-template-columns: 1fr; } 
        .modal-panel { width: 95vw; max-height: 95vh; } 
    }
</style>

<x-app-layout>
    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; z-index: 999;">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="brand">
                    <div class="brand-icon"><i class="fas fa-landmark"></i></div>
                    <div class="brand-text">DigiRepo</div>
                    <span class="brand-badge">v2.0</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section-label">Main</div>
                <a href="{{ route('home') }}" class="nav-link @if(request()->routeIs('home')) active @endif"><i class="fas fa-gauge-high"></i><span>Dashboard</span></a>
                <div class="nav-section-label">Discover</div>
                <a href="{{ route('documents.index') }}" class="nav-link @if(request()->routeIs('documents.index') && !request()->has('my_uploads')) active @endif"><i class="fas fa-compass"></i><span>Browse All</span><span class="nav-badge">{{ $documents->total() }}</span></a>
                <a href="{{ route('documents.manage') }}" class="nav-link"><i class="fas fa-table-list"></i> Manage All</a>
                <a href="{{ route('documents.index', ['sort' => 'newest']) }}" class="nav-link"><i class="fas fa-clock-rotate-left"></i><span>Recent Additions</span></a>
                <a href="{{ route('documents.index', ['filter' => 'popular']) }}" class="nav-link"><i class="fas fa-fire"></i><span>Most Popular</span></a>
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
                        <a href="#" class="nav-link"><i class="fas fa-clock-rotate-left"></i> Drafts <span class="nav-badge warning">2</span></a>
                    </div>
                    <div class="menu-group">
    <div class="menu-header" onclick="toggleMenu(this)"><span>My Workspace</span><i class="fas fa-chevron-down menu-arrow"></i></div>
    <div class="submenu">
        <a href="{{ route('documents.index', ['my_uploads' => auth()->id()]) }}" class="nav-link"><i class="fas fa-user-clock"></i> My Uploads</a>
        
        <a href="#" class="nav-link"><i class="fas fa-heart"></i> Favorites</a>
        <a href="#" class="nav-link"><i class="fas fa-clock-rotate-left"></i> Drafts <span class="nav-badge warning">2</span></a>
    </div>
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
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Digital Repository</h1>
                    <p>Manage and organize your digitized records, books, and files.</p>
                    <div class="header-date"><i class="fas fa-calendar-day"></i> {{ now()->format('l, F j, Y') }}</div>
                </div>
                @auth
                    <div class="header-actions">
                        <!-- ★ ADD CATEGORY BUTTON — positioned LEFT of Upload Record -->
                        <button onclick="openCategoryModal()" class="btn-upload add-category">
                            <i class="fas fa-tags"></i> Add Category
                        </button>
                        <button onclick="openModal('record')" class="btn-upload primary"><i class="fas fa-file-circle-plus"></i> Upload Record</button>
                        <button onclick="openModal('file')" class="btn-upload file"><i class="fas fa-cloud-arrow-up"></i> Upload File</button>
                        <button onclick="openModal('book')" class="btn-upload book"><i class="fas fa-book-open"></i> Upload Book</button>
                    </div>
                @endauth
            </div>

            <div class="scroll-area">
                @if(session('success'))
                    <div class="success-alert"><div class="success-alert-icon"><i class="fas fa-check"></i></div><p>{{ session('success') }}</p></div>
                @endif

                <div class="stats-grid">
                    <div class="stat-card blue"><div class="stat-card-top"><div class="stat-icon"><i class="fas fa-folder-open"></i></div><span class="stat-trend neutral"><i class="fas fa-database"></i> All</span></div><div class="stat-label">Total Records</div><div class="stat-value">{{ number_format($documents->total()) }}</div><div class="stat-sub">Complete document inventory</div></div>
                    <div class="stat-card green"><div class="stat-card-top"><div class="stat-icon"><i class="fas fa-layer-group"></i></div><span class="stat-trend up"><i class="fas fa-check-circle"></i> Active</span></div><div class="stat-label">Categories</div><div class="stat-value" id="statCategoryCount">{{ $categories->count() }}</div><div class="stat-sub">Organized classifications</div></div>
                    <div class="stat-card orange"><div class="stat-card-top"><div class="stat-icon"><i class="fas fa-clock"></i></div><span class="stat-trend up"><i class="fas fa-arrow-up"></i> New</span></div><div class="stat-label">Recent Uploads</div><div class="stat-value">{{ number_format($recentCount) }}</div><div class="stat-sub">Added in last 7 days</div></div>
                    <div class="stat-card purple"><div class="stat-card-top"><div class="stat-icon"><i class="fas fa-bolt"></i></div><span class="stat-trend up"><i class="fas fa-database"></i> Size</span></div><div class="stat-label">Total Size</div><div class="stat-value">{{ number_format($totalSize / 1048576, 1) }}<span style="font-size:0.85rem;font-weight:600;"> MB</span></div><div class="stat-sub">Storage used</div></div>
                </div>

                <div class="filter-bar">
                    <h2>All Files <span class="count-badge">{{ $documents->count() }} items</span></h2>
                    <div class="filter-controls">
                        <form id="filterForm" action="{{ route('documents.index') }}" method="GET" class="flex gap-2 items-center">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" id="liveSearch" value="{{ request('search') }}" placeholder="Search files..." autocomplete="off">
                                <button type="button" class="btn-reset {{ request('search') ? 'visible' : '' }}" id="btnResetSearch" title="Clear search">
                                    <i class="fas fa-xmark"></i>
                                </button>
                            </div>
                            <select name="category" id="categorySelect" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- ═══════════ DOCUMENT GRID WITH BOOK COVERS ═══════════ -->
                <div class="doc-grid">
                    @forelse($documents as $doc)
                        <div class="doc-card">
                            <div class="doc-cover">
                                @if(isset($doc->cover_image) && $doc->cover_image)
                                    <img src="{{ Storage::url($doc->cover_image) }}" alt="{{ $doc->title }}">
                                @elseif(in_array($doc->file_type, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->title }}">
                                @else
                                    <div class="fake-cover {{ $doc->file_type == 'pdf' ? 'pdf' : (in_array($doc->file_type, ['doc', 'docx']) ? 'word' : 'default') }}">
                                        <div class="fake-cover-icon">
                                            @if($doc->file_type == 'pdf')
                                                <i class="fas fa-file-pdf"></i>
                                            @elseif(in_array($doc->file_type, ['doc', 'docx']))
                                                <i class="fas fa-file-word"></i>
                                            @else
                                                <i class="fas fa-file-lines"></i>
                                            @endif
                                        </div>
                                        <div class="fake-cover-title">{{ $doc->title }}</div>
                                        <div class="fake-cover-subtitle">{{ strtoupper($doc->file_type ?? 'file') }} Document</div>
                                    </div>
                                @endif

                                @php
                                    $badgeClass = 'default';
                                    if($doc->file_type == 'pdf') $badgeClass = 'pdf';
                                    elseif(in_array($doc->file_type, ['doc','docx'])) $badgeClass = 'doc';
                                    elseif(in_array($doc->file_type, ['jpg','jpeg','png','gif','webp'])) $badgeClass = 'img';
                                @endphp
                                <span class="doc-file-type-badge {{ $badgeClass }}">{{ strtoupper($doc->file_type ?? 'file') }}</span>
                            </div>

                            <div class="doc-details">
                                <div class="doc-title" title="{{ $doc->title }}">{{ $doc->title }}</div>

                                @if(isset($doc->rating) && $doc->rating > 0)
                                    <div class="doc-rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($doc->rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i == ceil($doc->rating) && $doc->rating % 1 >= 0.25)
                                                <i class="fas fa-star half"></i>
                                            @else
                                                <i class="fas fa-star empty"></i>
                                            @endif
                                        @endfor
                                        <span class="rating-count" style="font-size:0.63rem; color:#94a3b8; font-weight:500; margin-left:4px;">{{ number_format($doc->rating, 1) }}</span>
                                    </div>
                                @endif

                                <div class="doc-meta-grid">
                                    <div class="meta-item full-width">
                                        <i class="fas fa-user-pen"></i>
                                        <span title="{{ $doc->user->name ?? 'Unknown' }}">{{ $doc->user->name ?? 'Unknown User' }}</span>
                                    </div>
                                    
                                    <div class="meta-item">
                                        <i class="fas fa-hard-drive"></i>
                                        <span>{{ number_format($doc->file_size / 1048576, 2) }} MB</span>
                                    </div>

                                    <div class="meta-item">
                                        <i class="fas fa-calendar-day"></i>
                                        <span>{{ $doc->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <div class="doc-actions">
                                    <a href="{{ route('documents.show', $doc) }}" class="btn-doc btn-doc-view">
                                        <i class="fas fa-{{ $doc->file_type == 'pdf' ? 'book-open-reader' : 'eye' }}"></i> 
                                        {{ $doc->file_type == 'pdf' ? 'Read' : 'View' }}
                                    </a>
                                    <a href="{{ route('documents.download', $doc) }}" class="btn-doc btn-doc-download">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                            <h3>No documents found</h3>
                            <p>Start building your digital repository by uploading your first file.</p>
                            @auth
                            <button onclick="openModal('record')" class="btn-primary" style="margin-top: 1.25rem; display: inline-flex;"><i class="fas fa-plus"></i> Upload First Record</button>
                            @endauth
                        </div>
                    @endforelse
                </div>

                @if($documents->hasPages())
                    <div class="pagination">{{ $documents->links() }}</div>
                @endif
            </div>
        </main>
    </div>

    <!-- ═══════════ CENTERED POP-UP MODAL (Upload) ═══════════ -->
    <div id="modalOverlay" class="modal-overlay" onclick="closeModal()"></div>
    
    <div id="modalPanel" class="modal-panel">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <input type="hidden" name="document_type" id="hiddenDocType" value="record">
            <input type="hidden" name="cover_base64" id="coverBase64" value="">
            <input type="hidden" name="rating" id="ratingInput" value="0">

            <div class="modal-header">
                <h2 id="modalTitle">
                    <span class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center text-teal-600 text-sm"><i class="fas fa-cloud-arrow-up"></i></span>
                    Upload Record
                </h2>
                <button type="button" onclick="closeModal()" class="modal-close"><i class="fas fa-xmark"></i></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Title <span class="text-red-400">*</span></label>
                    <input type="text" name="title" required class="form-input" placeholder="Enter document title...">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Author / Creator</label>
                        <input type="text" name="author_creator" class="form-input" placeholder="Who created this?">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="modalCategorySelect" class="form-input">
                            <option value="">Select category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="form-input" placeholder="Brief description of the document..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload File</label>
                    <div id="dropZone" class="drop-zone">
                        <input type="file" name="file" id="fileInput" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt">
                        <div id="uploadPlaceholder">
                            <i class="fas fa-file-arrow-up text-3xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-600 font-medium">Drag & drop or <span class="text-teal-600 font-semibold">browse</span></p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, JPG, PNG, TXT (Max 50MB)</p>
                        </div>
                        <div id="fileSelected" class="hidden">
                            <i id="fileIcon" class="fas fa-file-circle-check text-3xl text-teal-500 mb-3"></i>
                            <p id="fileName" class="text-sm font-semibold text-gray-900 truncate"></p>
                            <p id="fileSize" class="text-xs text-gray-400 mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Cover Image Section -->
                <div class="cover-section">
                    <div class="cover-section-header">
                        <label class="form-label"><i class="fas fa-image" style="color:#8b5cf6;"></i> Cover Image</label>
                        <span class="cover-hint">Optional — for books & visual documents</span>
                    </div>
                    <div class="cover-drop-zone" id="coverDropZone">
                        <input type="file" name="cover_image" id="coverImageInput" accept="image/*">
                        <div id="coverPlaceholder" class="cover-placeholder-text">
                            <i class="fas fa-panorama"></i>
                            Drop cover image or click to browse
                        </div>
                        <div id="coverLoading" class="cover-loading">
                            <div class="spinner"></div>
                            Processing image...
                        </div>
                        <div id="coverPreviewContainer" class="cover-preview-container">
                            <img id="coverPreviewImg" class="cover-preview-img" src="" alt="Cover preview">
                            <button type="button" id="coverRemoveBtn" class="cover-preview-remove" onclick="removeCoverImage(event)">
                                <i class="fas fa-xmark"></i>
                            </button>
                            <div>
                                <span id="coverBadge" class="cover-auto-badge"><i class="fas fa-wand-magic-sparkles"></i> Auto-compressed</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-star" style="color:#fbbf24;"></i> Rating</label>
                    <div class="star-rating-selector" id="starRatingSelector">
                        <button type="button" class="star-btn" data-value="1"><i class="fas fa-star"></i></button>
                        <button type="button" class="star-btn" data-value="2"><i class="fas fa-star"></i></button>
                        <button type="button" class="star-btn" data-value="3"><i class="fas fa-star"></i></button>
                        <button type="button" class="star-btn" data-value="4"><i class="fas fa-star"></i></button>
                        <button type="button" class="star-btn" data-value="5"><i class="fas fa-star"></i></button>
                        <span class="star-rating-label" id="starRatingLabel">Not rated</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn-cat-cancel">Cancel</button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-upload"></i> Upload Document
                </button>
            </div>
        </form>
    </div>

    <!-- ═══════════ ADD CATEGORY MODAL ═══════════ -->
    <div id="catModalOverlay" class="modal-overlay" onclick="closeCategoryModal()"></div>
    
    <div id="catModalPanel" class="cat-modal-panel">
        <div class="cat-modal-header">
            <h2>
                <span class="cat-icon-box"><i class="fas fa-tags"></i></span>
                Add New Category
            </h2>
            <button type="button" onclick="closeCategoryModal()" class="modal-close"><i class="fas fa-xmark"></i></button>
        </div>

        <div class="cat-modal-body">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="newCategoryName">Category Name <span style="color:#ef4444;">*</span></label>
                <input 
                    type="text" 
                    id="newCategoryName" 
                    class="cat-form-input" 
                    placeholder="e.g. Historical Archives, Research Papers..."
                    autocomplete="off"
                    maxlength="100"
                >
                <div class="cat-form-hint" id="catCharCount">
                    <i class="fas fa-circle-info"></i>
                    <span>0 / 100 characters</span>
                </div>
                <div class="cat-form-error" id="catFormError">
                    <i class="fas fa-circle-exclamation"></i>
                    <span id="catErrorText">This category already exists.</span>
                </div>
                <div class="cat-form-success" id="catFormSuccess">
                    <i class="fas fa-circle-check"></i>
                    <span id="catSuccessText">Category added successfully!</span>
                </div>
            </div>

            <!-- Preview of existing categories -->
            <div class="cat-existing-list">
                <div class="cat-existing-label">Existing Categories</div>
                <div class="cat-existing-tags" id="catExistingTags">
                    @foreach($categories as $cat)
                        <span class="cat-existing-tag" data-id="{{ $cat->id }}">
                            <span class="tag-dot"></span>
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="cat-modal-footer">
            <button type="button" onclick="closeCategoryModal()" class="btn-cat-cancel">Cancel</button>
            <button type="button" onclick="submitCategory()" id="catSubmitBtn" class="btn-cat-submit">
                <span class="submit-text"><i class="fas fa-plus"></i> Add Category</span>
                <span class="submit-spinner"></span>
            </button>
        </div>
    </div>

    <!-- ═══════════ JAVASCRIPT ═══════════ -->
    <script>
    // ═══════════════════════════════════════
    // SIDEBAR MENU TOGGLE
    // ═══════════════════════════════════════
    function toggleMenu(header) {
        header.classList.toggle('active');
        const submenu = header.nextElementSibling;
        submenu.classList.toggle('open');
    }

    // ═══════════════════════════════════════
    // UPLOAD MODAL
    // ═══════════════════════════════════════
    function openModal(type) {
        const titles = {
            record: '<span class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center text-teal-600 text-sm"><i class="fas fa-file-circle-plus"></i></span> Upload Record',
            file: '<span class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 text-sm"><i class="fas fa-cloud-arrow-up"></i></span> Upload File',
            book: '<span class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 text-sm"><i class="fas fa-book-open"></i></span> Upload Book'
        };
        document.getElementById('modalTitle').innerHTML = titles[type] || titles.record;
        document.getElementById('hiddenDocType').value = type;
        document.getElementById('modalOverlay').classList.add('active');
        document.getElementById('modalPanel').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('active');
        document.getElementById('modalPanel').classList.remove('active');
        document.body.style.overflow = '';
        resetUploadForm();
    }

    function resetUploadForm() {
        const form = document.getElementById('uploadForm');
        if (form) form.reset();
        document.getElementById('hiddenDocType').value = 'record';
        document.getElementById('coverBase64').value = '';
        document.getElementById('ratingInput').value = '0';
        const placeholder = document.getElementById('uploadPlaceholder');
        const selected = document.getElementById('fileSelected');
        if (placeholder) placeholder.classList.remove('hidden');
        if (selected) selected.classList.add('hidden');
        resetStarRating();
        removeCoverImage();
    }

    // ═══════════════════════════════════════
    // FILE INPUT DISPLAY
    // ═══════════════════════════════════════
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const placeholder = document.getElementById('uploadPlaceholder');
            const selected = document.getElementById('fileSelected');
            if (this.files && this.files[0]) {
                placeholder.classList.add('hidden');
                selected.classList.remove('hidden');
                document.getElementById('fileName').textContent = this.files[0].name;
                document.getElementById('fileSize').textContent = formatFileSize(this.files[0].size);
            } else {
                placeholder.classList.remove('hidden');
                selected.classList.add('hidden');
            }
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // ═══════════════════════════════════════
    // STAR RATING
    // ═══════════════════════════════════════
    const starLabels = ['Not rated', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    let currentRating = 0;

    document.querySelectorAll('#starRatingSelector .star-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            const val = parseInt(this.dataset.value);
            highlightStars(val, 'hovered');
        });
        btn.addEventListener('mouseleave', function() {
            clearStarHover();
            highlightStars(currentRating, 'active');
        });
        btn.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.value);
            document.getElementById('ratingInput').value = currentRating;
            document.getElementById('starRatingLabel').textContent = starLabels[currentRating];
            highlightStars(currentRating, 'active');
        });
    });

    function highlightStars(upTo, className) {
        document.querySelectorAll('#starRatingSelector .star-btn').forEach(btn => {
            const val = parseInt(btn.dataset.value);
            if (className === 'active') {
                btn.classList.toggle('active', val <= upTo);
                btn.classList.remove('hovered');
            } else {
                btn.classList.toggle('hovered', val <= upTo);
            }
        });
    }

    function clearStarHover() {
        document.querySelectorAll('#starRatingSelector .star-btn').forEach(btn => {
            btn.classList.remove('hovered');
        });
    }

    function resetStarRating() {
        currentRating = 0;
        document.querySelectorAll('#starRatingSelector .star-btn').forEach(btn => {
            btn.classList.remove('active', 'hovered');
        });
        const label = document.getElementById('starRatingLabel');
        if (label) label.textContent = starLabels[0];
    }

    // ═══════════════════════════════════════
    // COVER IMAGE HANDLING
    // ═══════════════════════════════════════
    const coverInput = document.getElementById('coverImageInput');
    const coverDropZone = document.getElementById('coverDropZone');
    const coverPlaceholder = document.getElementById('coverPlaceholder');
    const coverPreviewContainer = document.getElementById('coverPreviewContainer');
    const coverPreviewImg = document.getElementById('coverPreviewImg');
    const coverLoading = document.getElementById('coverLoading');

    if (coverInput) {
        coverInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                processCoverImage(e.target.files[0]);
            }
        });
    }

    if (coverDropZone) {
        coverDropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });
        coverDropZone.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });
        coverDropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                if (e.dataTransfer.files[0].type.startsWith('image/')) {
                    processCoverImage(e.dataTransfer.files[0]);
                }
            }
        });
    }

    function processCoverImage(file) {
        coverPlaceholder.style.display = 'none';
        coverPreviewContainer.classList.remove('active');
        coverLoading.classList.add('active');

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const maxW = 600;
                const maxH = 900;
                let w = img.width, h = img.height;
                if (w > maxW) { h = h * (maxW / w); w = maxW; }
                if (h > maxH) { w = w * (maxH / h); h = maxH; }
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);
                const base64 = canvas.toDataURL('image/jpeg', 0.8);
                document.getElementById('coverBase64').value = base64;
                coverPreviewImg.src = base64;
                coverLoading.classList.remove('active');
                coverPreviewContainer.classList.add('active');
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function removeCoverImage(e) {
        if (e) e.stopPropagation();
        document.getElementById('coverBase64').value = '';
        coverPreviewImg.src = '';
        coverPreviewContainer.classList.remove('active');
        coverLoading.classList.remove('active');
        coverPlaceholder.style.display = '';
        if (coverInput) coverInput.value = '';
    }

    // ═══════════════════════════════════════
    // DROP ZONE FOR MAIN FILE
    // ═══════════════════════════════════════
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });
        });
        ['dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
            });
        });
        dropZone.addEventListener('drop', function(e) {
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                fileInput.files = e.dataTransfer.files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }

    // ═══════════════════════════════════════
    // SEARCH & FILTER
    // ═══════════════════════════════════════
    const liveSearch = document.getElementById('liveSearch');
    const filterForm = document.getElementById('filterForm');
    const btnResetSearch = document.getElementById('btnResetSearch');

    if (liveSearch) {
        let searchTimeout;
        liveSearch.addEventListener('input', function() {
            const val = this.value.trim();
            btnResetSearch.classList.toggle('visible', val.length > 0);
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });
    }

    if (btnResetSearch) {
        btnResetSearch.addEventListener('click', function() {
            liveSearch.value = '';
            this.classList.remove('visible');
            filterForm.submit();
        });
    }

    // ═══════════════════════════════════════════════════
    // ADD CATEGORY MODAL — OPEN / CLOSE
    // ═══════════════════════════════════════════════════
    function openCategoryModal() {
        document.getElementById('catModalOverlay').classList.add('active');
        document.getElementById('catModalPanel').classList.add('active');
        document.body.style.overflow = 'hidden';
        // Reset form state
        document.getElementById('newCategoryName').value = '';
        document.getElementById('catCharCount').querySelector('span').textContent = '0 / 100 characters';
        document.getElementById('catFormError').classList.remove('visible');
        document.getElementById('catFormSuccess').classList.remove('visible');
        document.getElementById('catSubmitBtn').classList.remove('loading');
        document.getElementById('catSubmitBtn').disabled = false;
        // Remove previously "newly-added" highlights
        document.querySelectorAll('.cat-existing-tag.newly-added').forEach(tag => {
            tag.classList.remove('newly-added');
        });
        // Focus input after animation
        setTimeout(() => {
            document.getElementById('newCategoryName').focus();
        }, 350);
    }

    function closeCategoryModal() {
        document.getElementById('catModalOverlay').classList.remove('active');
        document.getElementById('catModalPanel').classList.remove('active');
        document.body.style.overflow = '';
    }

    // ═══════════════════════════════════════════════════
    // CATEGORY INPUT — CHARACTER COUNT & ENTER KEY
    // ═══════════════════════════════════════════════════
    const catNameInput = document.getElementById('newCategoryName');
    if (catNameInput) {
        catNameInput.addEventListener('input', function() {
            const len = this.value.length;
            document.getElementById('catCharCount').querySelector('span').textContent = len + ' / 100 characters';
            // Clear error while typing
            if (len > 0) {
                document.getElementById('catFormError').classList.remove('visible');
            }
        });

        catNameInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitCategory();
            }
            if (e.key === 'Escape') {
                closeCategoryModal();
            }
        });
    }

    // ═══════════════════════════════════════════════════
    // SUBMIT CATEGORY — AJAX
    // ═══════════════════════════════════════════════════
    function submitCategory() {
        const nameInput = document.getElementById('newCategoryName');
        const name = nameInput.value.trim();
        const errorEl = document.getElementById('catFormError');
        const errorText = document.getElementById('catErrorText');
        const successEl = document.getElementById('catFormSuccess');
        const submitBtn = document.getElementById('catSubmitBtn');

        // Validate
        if (!name) {
            errorText.textContent = 'Please enter a category name.';
            errorEl.classList.add('visible');
            successEl.classList.remove('visible');
            nameInput.focus();
            return;
        }

        if (name.length < 2) {
            errorText.textContent = 'Category name must be at least 2 characters.';
            errorEl.classList.add('visible');
            successEl.classList.remove('visible');
            nameInput.focus();
            return;
        }

        // Check duplicate locally first
        const existingTags = document.querySelectorAll('.cat-existing-tag');
        for (let tag of existingTags) {
            if (tag.textContent.trim().toLowerCase() === name.toLowerCase()) {
                errorText.textContent = 'This category already exists.';
                errorEl.classList.add('visible');
                successEl.classList.remove('visible');
                nameInput.focus();
                nameInput.select();
                return;
            }
        }

        // Show loading
        errorEl.classList.remove('visible');
        successEl.classList.remove('visible');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        // AJAX request
        fetch('{{ route("categories.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || data.errors?.name?.[0] || 'Failed to add category.');
                });
            }
            return response.json();
        })
        .then(data => {
            const newId = data.id || data.category?.id;
            const newName = data.name || data.category?.name || name;

            // 1. Add to filter bar dropdown
            addOptionToSelect('categorySelect', newId, newName);

            // 2. Add to upload modal dropdown
            addOptionToSelect('modalCategorySelect', newId, newName);

            // 3. Add tag to existing categories list in modal
            const tagsContainer = document.getElementById('catExistingTags');
            const newTag = document.createElement('span');
            newTag.className = 'cat-existing-tag newly-added';
            newTag.dataset.id = newId;
            newTag.innerHTML = '<span class="tag-dot"></span> ' + escapeHtml(newName);
            tagsContainer.prepend(newTag);
            // Scroll to top to show the new tag
            tagsContainer.scrollTop = 0;

            // 4. Update stat card count
            const statCount = document.getElementById('statCategoryCount');
            if (statCount) {
                statCount.textContent = parseInt(statCount.textContent) + 1;
            }

            // 5. Show success message
            document.getElementById('catSuccessText').textContent = '"' + newName + '" added successfully!';
            successEl.classList.add('visible');

            // 6. Clear input
            nameInput.value = '';
            document.getElementById('catCharCount').querySelector('span').textContent = '0 / 100 characters';

            // 7. Re-enable button
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;

            // 8. Focus input for quick successive adds
            nameInput.focus();
        })
        .catch(error => {
            errorText.textContent = error.message || 'Something went wrong. Please try again.';
            errorEl.classList.add('visible');
            successEl.classList.remove('visible');
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
        });
    }

    // Helper: add an <option> to a <select> by ID
    function addOptionToSelect(selectId, value, text) {
        const select = document.getElementById(selectId);
        if (!select) return;

        // Check if option already exists
        const existing = select.querySelector('option[value="' + value + '"]');
        if (existing) return;

        const opt = document.createElement('option');
        opt.value = value;
        opt.textContent = text;
        // Insert before the last position (after all current options, but keep "Select category..." or "All Categories" at top)
        select.appendChild(opt);
    }

    // Helper: escape HTML to prevent XSS
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    // ═══════════════════════════════════════
    // CLOSE MODALS ON ESCAPE KEY
    // ═══════════════════════════════════════
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close category modal first (higher priority if open)
            if (document.getElementById('catModalPanel').classList.contains('active')) {
                closeCategoryModal();
                return;
            }
            // Then close upload modal
            if (document.getElementById('modalPanel').classList.contains('active')) {
                closeModal();
            }
        }
    });
    </script>
</x-app-layout>