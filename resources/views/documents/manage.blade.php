<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    
    nav[class*="bg-white"][class*="border-b"] { display: none !important; }
    body { 
        padding-top: 0 !important; overflow: hidden !important; font-family: 'Inter', sans-serif; 
        background: #f1f5f9; color: #1e293b; margin: 0;
    }

    /* ═══════════════════════════════════════════
       BACKGROUND TEXTURE
    ═══════════════════════════════════════════ */
    .bg-pattern {
        position: fixed; inset: 0; z-index: 0; pointer-events: none;
        background-image: 
            radial-gradient(circle at 20% 20%, rgba(13, 148, 136, 0.04) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(99, 102, 241, 0.04) 0%, transparent 50%),
            radial-gradient(circle at 50% 0%, rgba(13, 148, 136, 0.02) 0%, transparent 40%);
    }
    .bg-pattern::after {
        content: ''; position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2394a3b8' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* ═══════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════ */
    .sidebar {
        width: 272px; 
        background: #ffffff; 
        border-right: 1px solid #e2e8f0;
        display: flex; flex-direction: column; position: fixed; height: 100%; left: 0; top: 0; z-index: 1000;
        box-shadow: 2px 0 24px rgba(0, 0, 0, 0.04);
    }
    .sidebar-header { 
        padding: 1.5rem 1.25rem; 
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(180deg, #ffffff 0%, #f8fffe 100%);
    }
    .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
    .brand-icon {
        width: 42px; height: 42px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
        box-shadow: 0 4px 16px rgba(13, 148, 136, 0.3), inset 0 1px 0 rgba(255,255,255,0.15);
        position: relative; overflow: hidden;
    }
    .brand-icon::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.1) 100%); }
    .brand-text { font-size: 1.2rem; font-weight: 900; color: #0f172a; letter-spacing: -0.03em; }
    .brand-badge { font-size: 0.52rem; background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488; padding: 2px 7px; border-radius: 6px; font-weight: 800; letter-spacing: 0.04em; margin-left: auto; border: 1px solid rgba(13, 148, 136, 0.15); }
    .sidebar-nav { flex: 1; overflow-y: auto; padding: 0.75rem 0.65rem; }
    .sidebar-nav::-webkit-scrollbar { width: 3px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    .nav-section-label { padding: 1rem 0.75rem 0.35rem; color: #94a3b8; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
    .menu-group { margin-bottom: 0.15rem; }
    .menu-header {
        display: flex; justify-content: space-between; align-items: center; padding: 0.55rem 0.75rem;
        color: #94a3b8; font-size: 0.64rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: 0.06em; cursor: pointer; user-select: none; border-radius: 8px; transition: all 0.25s;
    }
    .menu-header:hover { color: #0d9488; background: rgba(13, 148, 136, 0.04); }
    .menu-arrow { font-size: 0.5rem; transition: transform 0.3s ease; }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; }
    .submenu.open { max-height: 500px; }
    .menu-header.active .menu-arrow { transform: rotate(180deg); }
    .nav-link {
        display: flex; align-items: center; padding: 0.55rem 0.8rem; color: #64748b; text-decoration: none;
        border-radius: 9px; margin-bottom: 1px; font-size: 0.82rem; font-weight: 500;
        transition: all 0.2s ease; position: relative;
    }
    .nav-link::before {
        content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
        width: 3px; height: 0; background: #0d9488; border-radius: 0 4px 4px 0; transition: height 0.2s ease;
    }
    .nav-link i { width: 20px; margin-right: 10px; font-size: 0.82rem; transition: all 0.2s; text-align: center; }
    .nav-link:hover { background-color: #f8fafc; color: #0f766e; }
    .nav-link:hover i { transform: scale(1.1); color: #0d9488; }
    .nav-link.active { background: linear-gradient(135deg, #f0fdfa, #ccfbf1); color: #0f766e; font-weight: 600; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.08); }
    .nav-link.active::before { height: 55%; }
    .nav-link.active i { color: #0d9488; }
    .nav-link .nav-badge { margin-left: auto; background: #0d9488; color: white; font-size: 0.58rem; padding: 1px 7px; border-radius: 10px; font-weight: 700; box-shadow: 0 2px 6px rgba(13, 148, 136, 0.3); }
    .sidebar-footer { padding: 0.75rem; border-top: 1px solid #f1f5f9; background: #fafbfc; }
    .user-card { display: flex; align-items: center; padding: 0.6rem 0.75rem; border-radius: 12px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.03); }
    .user-avatar-sidebar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25); }
    .user-info { margin-left: 10px; flex: 1; }
    .user-name { font-size: 0.82rem; font-weight: 600; color: #0f172a; display: block; }
    .user-role { font-size: 0.66rem; color: #94a3b8; font-weight: 500; }
    .logout-link { display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.55rem; color: #ef4444; background: #fef2f2; text-decoration: none; border-radius: 10px; font-size: 0.78rem; font-weight: 600; transition: all 0.2s; margin-top: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.08); }
    .logout-link:hover { background: #fee2e2; border-color: rgba(239, 68, 68, 0.15); }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    .main-content { margin-left: 272px; flex: 1; padding: 1.75rem 2rem; width: calc(100% - 272px); display: flex; flex-direction: column; overflow: hidden; min-height: 0; position: relative; z-index: 1; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-shrink: 0; }
    .page-header-left h1 { margin: 0; font-size: 1.75rem; color: #0f172a; font-weight: 900; letter-spacing: -0.03em; }
    .page-header-left p { color: #94a3b8; margin: 6px 0 0 0; font-size: 0.88rem; font-weight: 400; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; margin-top: 10px; font-size: 0.75rem; color: #cbd5e1; }
    .breadcrumb a { color: #0d9488; text-decoration: none; font-weight: 600; transition: all 0.2s; }
    .breadcrumb a:hover { color: #0f766e; }
    .breadcrumb .sep { color: #e2e8f0; }
    .breadcrumb .current { color: #64748b; font-weight: 700; }

    .header-actions { display: flex; gap: 0.6rem; align-items: center; }
    .btn-action { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; font-size: 0.82rem; font-weight: 600; border-radius: 11px; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1.5px solid transparent; cursor: pointer; white-space: nowrap; background: none; }
    .btn-action.primary { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; box-shadow: 0 4px 16px rgba(13, 148, 136, 0.3), inset 0 1px 0 rgba(255,255,255,0.1); }
    .btn-action.primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13, 148, 136, 0.4); }
    .btn-action.secondary { background: white; color: #475569; border-color: #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .btn-action.secondary:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; flex-shrink: 0; }
    .stat-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.1rem 1.2rem;
        position: relative; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .stat-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        border-radius: 14px 14px 0 0; transition: height 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
    .stat-card:hover::before { height: 4px; }
    .stat-card.emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .stat-card.violet::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
    .stat-card.amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-icon-wrap { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; margin-bottom: 0.7rem; }
    .stat-card.emerald .stat-icon-wrap { background: #ecfdf5; color: #059669; }
    .stat-card.blue .stat-icon-wrap { background: #eff6ff; color: #2563eb; }
    .stat-card.violet .stat-icon-wrap { background: #f5f3ff; color: #7c3aed; }
    .stat-card.amber .stat-icon-wrap { background: #fffbeb; color: #d97706; }
    .stat-value { font-size: 1.6rem; font-weight: 900; color: #0f172a; letter-spacing: -0.03em; line-height: 1; }
    .stat-label { font-size: 0.7rem; color: #94a3b8; font-weight: 600; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.04em; }

    /* ═══════════════════════════════════════════
       SCROLL AREA
    ═══════════════════════════════════════════ */
    .scroll-area { flex: 1; min-height: 0; overflow-y: auto !important; padding-bottom: 2rem; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
    .scroll-area::-webkit-scrollbar { width: 6px; }
    .scroll-area::-webkit-scrollbar-track { background: transparent; }
    .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

    /* ═══════════════════════════════════════════
       TYPE TABS
    ═══════════════════════════════════════════ */
    .type-tabs { display: flex; gap: 0.4rem; margin-bottom: 1.25rem; flex-shrink: 0; flex-wrap: wrap; }
    .type-tab {
        display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px;
        background: white; border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.78rem; font-weight: 600; color: #64748b; cursor: pointer;
        transition: all 0.25s; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .type-tab:hover { border-color: #cbd5e1; background: #f8fafc; color: #334155; transform: translateY(-1px); }
    .type-tab.active { border-color: #0d9488; background: linear-gradient(135deg, #f0fdfa, #ccfbf1); color: #0f766e; box-shadow: 0 2px 10px rgba(13, 148, 136, 0.12); }
    .type-tab .tab-count { font-size: 0.62rem; background: #f1f5f9; color: #94a3b8; padding: 2px 7px; border-radius: 6px; font-weight: 700; }
    .type-tab.active .tab-count { background: rgba(13, 148, 136, 0.15); color: #0d9488; }
    .type-tab i { font-size: 0.8rem; }

    /* ═══════════════════════════════════════════
       TOOLBAR
    ═══════════════════════════════════════════ */
    .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; gap: 1rem; flex-wrap: wrap; }
    .toolbar-left { display: flex; align-items: center; gap: 0.65rem; flex: 1; min-width: 0; }
    .toolbar-right { display: flex; align-items: center; gap: 0.5rem; }

    .search-box { position: relative; display: flex; align-items: center; flex: 1; max-width: 320px; }
    .search-box > i { position: absolute; left: 13px; color: #94a3b8; font-size: 0.8rem; pointer-events: none; z-index: 2; }
    .search-box input { padding: 9px 38px 9px 36px; background: white; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; width: 100%; transition: all 0.25s; color: #1e293b; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .search-box input:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08), 0 2px 8px rgba(13, 148, 136, 0.06); }
    .search-box input::placeholder { color: #cbd5e1; }
    .search-box .btn-reset { position: absolute; right: 8px; width: 26px; height: 26px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 7px; display: none; align-items: center; justify-content: center; cursor: pointer; color: #94a3b8; font-size: 0.65rem; transition: all 0.2s; padding: 0; z-index: 2; }
    .search-box .btn-reset:hover { background: #fee2e2; border-color: #fca5a5; color: #ef4444; }
    .search-box .btn-reset.visible { display: flex; }

    .filter-select { padding: 9px 32px 9px 12px; background: white; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; color: #64748b; cursor: pointer; transition: all 0.25s; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .filter-select:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08); }

    .bulk-bar { display: none; align-items: center; gap: 0.75rem; padding: 10px 16px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; border-radius: 12px; margin-bottom: 1rem; animation: slideDown 0.25s ease; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08); }
    .bulk-bar.visible { display: flex; }
    .bulk-bar .bulk-count { font-size: 0.82rem; font-weight: 600; color: #1e40af; }
    .bulk-bar .btn-bulk { padding: 6px 14px; font-size: 0.75rem; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
    .bulk-bar .btn-bulk.danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .bulk-bar .btn-bulk.danger:hover { background: #fee2e2; }
    .bulk-bar .btn-bulk.cancel { background: white; color: #64748b; border: 1px solid #e2e8f0; }
    .bulk-bar .btn-bulk.cancel:hover { background: #f8fafc; }

    /* ═══════════════════════════════════════════
       DATA TABLE
    ═══════════════════════════════════════════ */
    .table-container { background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 0 0 1px rgba(0,0,0,0.01); }
    .table-scroll { overflow-x: auto; }
    .table-scroll::-webkit-scrollbar { height: 5px; }
    .table-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .data-table thead { background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 2px solid #e2e8f0; }
    .data-table th { padding: 13px 16px; text-align: left; font-weight: 700; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; }
    .data-table th.sortable { cursor: pointer; user-select: none; transition: color 0.2s; }
    .data-table th.sortable:hover { color: #0f766e; }
    .data-table th.sortable .sort-icon { margin-left: 4px; font-size: 0.55rem; color: #cbd5e1; }
    .data-table th.sortable.active .sort-icon { color: #0d9488; }

    .data-table td { padding: 14px 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; color: #334155; }
    .data-table tbody tr { transition: all 0.2s ease; }
    .data-table tbody tr:hover { background: #f8fffe; }
    .data-table tbody tr.selected { background: #f0fdfa; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    /* Checkbox */
    .doc-checkbox { width: 17px; height: 17px; accent-color: #0d9488; cursor: pointer; border-radius: 4px; }

    /* Thumbnail */
    .table-thumb { width: 42px; height: 56px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0; background: #f8fafc; box-shadow: 0 1px 3px rgba(0,0,0,0.06); transition: transform 0.2s; }
    .data-table tbody tr:hover .table-thumb { transform: scale(1.05); }
    .table-thumb-placeholder { width: 42px; height: 56px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .table-thumb-placeholder.pdf { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #ef4444; }
    .table-thumb-placeholder.doc { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #3b82f6; }
    .table-thumb-placeholder.img { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #10b981; }
    .table-thumb-placeholder.default { background: #f8fafc; color: #94a3b8; }

    /* Title cell */
    .table-title { font-weight: 700; color: #0f172a; display: block; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.84rem; }
    .table-title a { color: inherit; text-decoration: none; transition: all 0.2s; }
    .table-title a:hover { color: #0d9488; }
    .table-subtitle { font-size: 0.7rem; color: #94a3b8; font-weight: 400; margin-top: 3px; display: block; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* Badges */
    .type-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 8px; font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
    .type-badge.record { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .type-badge.file { background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; }
    .type-badge.book { background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .type-badge.thesis { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }

    .cat-badge { display: inline-block; padding: 4px 10px; background: #f1f5f9; color: #475569; border-radius: 7px; font-size: 0.7rem; font-weight: 500; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border: 1px solid #e2e8f0; }

    /* ═══════════════════════════════════════════
       ACTION BUTTONS — CLEARLY VISIBLE
    ═══════════════════════════════════════════ */
    .table-actions { display: flex; gap: 6px; }
    .btn-table {
        width: 34px; height: 34px; border-radius: 9px; border: none;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); font-size: 0.78rem;
        position: relative; overflow: hidden;
    }
    .btn-table::after {
        content: ''; position: absolute; inset: 0; border-radius: 9px;
        background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.2) 100%);
        opacity: 0; transition: opacity 0.2s;
    }
    .btn-table:hover::after { opacity: 1; }

    /* View — Teal */
    .btn-table.view {
        background: #ecfdf5; color: #059669;
        box-shadow: 0 1px 4px rgba(5, 150, 105, 0.15), inset 0 0 0 1px rgba(5, 150, 105, 0.1);
    }
    .btn-table.view:hover {
        background: #059669; color: white;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    /* Download — Blue */
    .btn-table.download {
        background: #eff6ff; color: #2563eb;
        box-shadow: 0 1px 4px rgba(37, 99, 235, 0.15), inset 0 0 0 1px rgba(37, 99, 235, 0.1);
    }
    .btn-table.download:hover {
        background: #2563eb; color: white;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Edit — Amber */
    .btn-table.edit {
        background: #fffbeb; color: #d97706;
        box-shadow: 0 1px 4px rgba(217, 119, 6, 0.15), inset 0 0 0 1px rgba(217, 119, 6, 0.1);
    }
    .btn-table.edit:hover {
        background: #d97706; color: white;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }

    /* Delete — Red */
    .btn-table.delete {
        background: #fef2f2; color: #dc2626;
        box-shadow: 0 1px 4px rgba(220, 38, 38, 0.12), inset 0 0 0 1px rgba(220, 38, 38, 0.08);
    }
    .btn-table.delete:hover {
        background: #dc2626; color: white;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Table footer */
    .table-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border-top: 1px solid #f1f5f9; background: #fafbfc; }
    .table-footer-info { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }
    .table-footer-info strong { color: #475569; }

    /* Pagination */
    .pagination { display: flex; gap: 4px; }
    .pagination a, .pagination span { padding: 7px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 600; border: 1.5px solid #e2e8f0; color: #64748b; text-decoration: none; transition: all 0.25s; background: white; }
    .pagination a:hover { background: #f0fdfa; border-color: #99f6e4; color: #0d9488; transform: translateY(-1px); }
    .pagination .active { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-color: transparent; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3); }
    .pagination .disabled { opacity: 0.35; pointer-events: none; }

    /* Empty state */
    .empty-table { padding: 5rem 2rem; text-align: center; }
    .empty-icon-wrap { width: 72px; height: 72px; border-radius: 18px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .empty-icon-wrap i { font-size: 1.8rem; color: #cbd5e1; }
    .empty-table h3 { font-size: 1.05rem; font-weight: 700; color: #334155; margin: 0 0 0.4rem; }
    .empty-table p { font-size: 0.82rem; color: #94a3b8; margin: 0; }

    /* ═══════════════════════════════════════════
       DELETE CONFIRM MODAL
    ═══════════════════════════════════════════ */
    .modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(6px); z-index: 2000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    .modal-overlay.active { opacity: 1; pointer-events: auto; }
    .confirm-modal { position: fixed; top: 50%; left: 50%; width: 420px; max-width: 95vw; background: white; z-index: 2001; border-radius: 1.25rem; box-shadow: 0 25px 60px -12px rgba(0,0,0,0.2), 0 0 0 1px rgba(0,0,0,0.03); overflow: hidden; transform: translate(-50%, -50%) scale(0.95); opacity: 0; pointer-events: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .confirm-modal.active { transform: translate(-50%, -50%) scale(1); opacity: 1; pointer-events: auto; }
    .confirm-modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; }
    .confirm-modal-body { padding: 1.5rem; text-align: center; }
    .confirm-icon { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .confirm-icon i { font-size: 1.4rem; color: #ef4444; }
    .confirm-modal-body h3 { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem; }
    .confirm-modal-body p { font-size: 0.82rem; color: #64748b; margin: 0; line-height: 1.6; }
    .confirm-doc-name { font-weight: 600; color: #0f172a; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; display: inline-block; margin-top: 0.6rem; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border: 1px solid #e2e8f0; font-size: 0.82rem; }
    .confirm-modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center; gap: 0.75rem; background: #fafbfc; }
    .btn-confirm-cancel { padding: 10px 22px; background: white; color: #64748b; font-size: 0.82rem; font-weight: 600; border-radius: 10px; border: 1.5px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
    .btn-confirm-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-confirm-delete { padding: 10px 22px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; font-size: 0.82rem; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; transition: all 0.25s; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3); }
    .btn-confirm-delete:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4); }

    /* ═══ Toast Notification ═══ */
    .toast-container { position: fixed; top: 1.5rem; right: 1.5rem; z-index: 3000; display: flex; flex-direction: column; gap: 0.5rem; }
    .toast { display: flex; align-items: center; gap: 10px; padding: 14px 18px; background: white; border-radius: 12px; box-shadow: 0 12px 36px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.03); animation: toastIn 0.35s ease; min-width: 300px; }
    .toast.success { border-left: 4px solid #10b981; }
    .toast.error { border-left: 4px solid #ef4444; }
    .toast.success .toast-icon { color: #10b981; }
    .toast.error .toast-icon { color: #ef4444; }
    .toast-icon { font-size: 1.1rem; }
    .toast-msg { font-size: 0.82rem; font-weight: 500; color: #334155; flex: 1; }
    .toast-close { background: none; border: none; color: #cbd5e1; cursor: pointer; font-size: 0.75rem; padding: 4px; transition: color 0.2s; }
    .toast-close:hover { color: #64748b; }
    @keyframes toastIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    /* ═══════════════════════════════════════════
       ROW ENTRANCE ANIMATION
    ═══════════════════════════════════════════ */
    @keyframes rowSlideIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .data-table tbody tr { animation: rowSlideIn 0.3s ease both; }
    .data-table tbody tr:nth-child(1) { animation-delay: 0.02s; }
    .data-table tbody tr:nth-child(2) { animation-delay: 0.04s; }
    .data-table tbody tr:nth-child(3) { animation-delay: 0.06s; }
    .data-table tbody tr:nth-child(4) { animation-delay: 0.08s; }
    .data-table tbody tr:nth-child(5) { animation-delay: 0.10s; }
    .data-table tbody tr:nth-child(6) { animation-delay: 0.12s; }
    .data-table tbody tr:nth-child(7) { animation-delay: 0.14s; }
    .data-table tbody tr:nth-child(8) { animation-delay: 0.16s; }
    .data-table tbody tr:nth-child(9) { animation-delay: 0.18s; }
    .data-table tbody tr:nth-child(10) { animation-delay: 0.20s; }
    .data-table tbody tr:nth-child(n+11) { animation-delay: 0.22s; }

    @media (max-width: 1024px) { .sidebar { width: 240px; } .main-content { margin-left: 240px; width: calc(100% - 240px); } .stat-cards { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .type-tabs { gap: 0.3rem; } .type-tab { padding: 7px 10px; font-size: 0.7rem; } .toolbar { flex-direction: column; align-items: stretch; } .toolbar-left { flex-direction: column; } .search-box { max-width: 100%; } .stat-cards { grid-template-columns: 1fr 1fr; gap: 0.65rem; } .stat-card { padding: 0.9rem 1rem; } .stat-value { font-size: 1.3rem; } }
</style>

<x-app-layout>
    <!-- BG TEXTURE -->
    <div class="bg-pattern"></div>

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
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-gauge-high"></i><span>Dashboard</span></a>
                <div class="nav-section-label">Discover</div>
                <a href="{{ route('documents.index') }}" class="nav-link"><i class="fas fa-compass"></i><span>Browse All</span></a>
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
                        <a href="{{ route('documents.manage') }}" class="nav-link active"><i class="fas fa-table-list"></i> Manage All</a>
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
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Manage Documents</h1>
                    <p>View, organize, and maintain all records in the system.</p>
                    <div class="breadcrumb">
                        <a href="{{ route('documents.index') }}">Documents</a>
                        <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem;"></i></span>
                        <span class="current">Manage</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('documents.index') }}" class="btn-action secondary"><i class="fas fa-arrow-left"></i> Back to Browse</a>
                    <button onclick="window.location.href='{{ route('documents.index') }}'" class="btn-action primary"><i class="fas fa-plus"></i> Upload New</button>
                </div>
            </div>

            <div class="scroll-area">
                <!-- STAT CARDS -->
                <div class="stat-cards">
                    <div class="stat-card emerald">
                        <div class="stat-icon-wrap"><i class="fas fa-layer-group"></i></div>
                        <div class="stat-value">{{ $documents->total() }}</div>
                        <div class="stat-label">Total Documents</div>
                    </div>
                    <div class="stat-card blue">
                        <div class="stat-icon-wrap"><i class="fas fa-file-shield"></i></div>
                        <div class="stat-value">{{ $typeCounts->get('record', 0) }}</div>
                        <div class="stat-label">Records</div>
                    </div>
                    <div class="stat-card violet">
                        <div class="stat-icon-wrap"><i class="fas fa-book"></i></div>
                        <div class="stat-value">{{ $typeCounts->get('book', 0) + $typeCounts->get('thesis', 0) }}</div>
                        <div class="stat-label">Books & Theses</div>
                    </div>
                    <div class="stat-card amber">
                        <div class="stat-icon-wrap"><i class="fas fa-hard-drive"></i></div>
                        <div class="stat-value">{{ number_format($documents->sum('file_size') / 1048576, 1) }}<span style="font-size:0.8rem;font-weight:600;color:#94a3b8;margin-left:2px;">MB</span></div>
                        <div class="stat-label">Total Storage</div>
                    </div>
                </div>

                <!-- TYPE TABS -->
                <div class="type-tabs">
                    <a href="{{ route('documents.manage') }}" class="type-tab {{ !request('type') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i> All
                        <span class="tab-count">{{ $documents->total() }}</span>
                    </a>
                    <a href="{{ route('documents.manage', ['type' => 'record']) }}" class="type-tab {{ request('type') == 'record' ? 'active' : '' }}">
                        <i class="fas fa-file-shield"></i> Records
                        <span class="tab-count">{{ $typeCounts->get('record', 0) }}</span>
                    </a>
                    <a href="{{ route('documents.manage', ['type' => 'file']) }}" class="type-tab {{ request('type') == 'file' ? 'active' : '' }}">
                        <i class="fas fa-photo-film"></i> Files
                        <span class="tab-count">{{ $typeCounts->get('file', 0) }}</span>
                    </a>
                    <a href="{{ route('documents.manage', ['type' => 'book']) }}" class="type-tab {{ request('type') == 'book' ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Books
                        <span class="tab-count">{{ $typeCounts->get('book', 0) }}</span>
                    </a>
                    <a href="{{ route('documents.manage', ['type' => 'thesis']) }}" class="type-tab {{ request('type') == 'thesis' ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i> Theses
                        <span class="tab-count">{{ $typeCounts->get('thesis', 0) }}</span>
                    </a>
                </div>

                <!-- TOOLBAR -->
                <form id="manageFilterForm" action="{{ route('documents.manage') }}" method="GET">
                    @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
                    <div class="toolbar">
                        <div class="toolbar-left">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, description..." autocomplete="off">
                                <button type="button" class="btn-reset {{ request('search') ? 'visible' : '' }}" onclick="clearSearch()" title="Clear"><i class="fas fa-xmark"></i></button>
                            </div>
                            <select name="category" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="toolbar-right">
                            <select name="sort" class="filter-select" onchange="this.form.submit()" style="width:160px;">
                                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                                <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                                <option value="file_size" {{ request('sort') == 'file_size' ? 'selected' : '' }}>Largest First</option>
                                <option value="file_size_asc" {{ request('sort') == 'file_size_asc' ? 'selected' : '' }}>Smallest First</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- BULK ACTION BAR -->
                <div class="bulk-bar" id="bulkBar">
                    <span class="bulk-count"><span id="bulkCountNum">0</span> selected</span>
                    <button class="btn-bulk danger" onclick="bulkDelete()"><i class="fas fa-trash-alt"></i> Delete Selected</button>
                    <button class="btn-bulk cancel" onclick="clearSelection()"><i class="fas fa-xmark"></i> Cancel</button>
                </div>

                <!-- TABLE -->
                <div class="table-container">
                    @if($documents->count() > 0)
                        <div class="table-scroll">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"><input type="checkbox" class="doc-checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                                        <th style="width:62px;">Cover</th>
                                        <th>Title</th>
                                        <th style="width:110px;">Type</th>
                                        <th style="width:150px;">Category</th>
                                        <th style="width:130px;">Author</th>
                                        <th style="width:90px;">Size</th>
                                        <th style="width:100px;">Date</th>
                                        <th style="width:140px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $doc)
                                        @php
                                            $thumbClass = 'default';
                                            $thumbIcon = 'fa-file-lines';
                                            if($doc->file_type == 'pdf') { $thumbClass = 'pdf'; $thumbIcon = 'fa-file-pdf'; }
                                            elseif(in_array($doc->file_type, ['doc','docx'])) { $thumbClass = 'doc'; $thumbIcon = 'fa-file-word'; }
                                            elseif(in_array($doc->file_type, ['jpg','jpeg','png','gif','webp'])) { $thumbClass = 'img'; $thumbIcon = 'fa-file-image'; }
                                        @endphp
                                        <tr id="row-{{ $doc->id }}" data-id="{{ $doc->id }}">
                                            <td><input type="checkbox" class="doc-checkbox row-check" value="{{ $doc->id }}" onchange="updateBulkBar()"></td>
                                            <td>
                                                @if($doc->cover_image)
                                                    <img src="{{ Storage::url($doc->cover_image) }}" class="table-thumb" alt="">
                                                @elseif(in_array($doc->file_type, ['jpg','jpeg','png']))
                                                    <img src="{{ Storage::url($doc->file_path) }}" class="table-thumb" alt="">
                                                @else
                                                    <div class="table-thumb-placeholder {{ $thumbClass }}"><i class="fas {{ $thumbIcon }}"></i></div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="table-title"><a href="{{ route('documents.show', $doc) }}">{{ $doc->title }}</a></span>
                                                <span class="table-subtitle">{{ $doc->description ? Str::limit($doc->description, 60) : 'No description' }}</span>
                                            </td>
                                            <td>
                                                <span class="type-badge {{ $doc->document_type ?? 'record' }}">
                                                    @if($doc->document_type == 'book')<i class="fas fa-book"></i>
                                                    @elseif($doc->document_type == 'file')<i class="fas fa-photo-film"></i>
                                                    @elseif($doc->document_type == 'thesis')<i class="fas fa-graduation-cap"></i>
                                                    @else<i class="fas fa-file-shield"></i>
                                                    @endif
                                                    {{ ucfirst($doc->document_type ?? 'record') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($doc->category)
                                                    <span class="cat-badge" title="{{ $doc->category->name }}">{{ $doc->category->name }}</span>
                                                @else
                                                    <span style="color:#cbd5e1; font-size:0.75rem;">—</span>
                                                @endif
                                            </td>
                                            <td style="font-size:0.78rem; color:#64748b; max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $doc->author_creator ?? '' }}">
                                                {{ $doc->author_creator ?? '—' }}
                                            </td>
                                            <td style="font-size:0.78rem; color:#475569; font-weight:600;">{{ number_format($doc->file_size / 1048576, 2) }} <span style="font-weight:400;color:#94a3b8;">MB</span></td>
                                            <td style="font-size:0.75rem; color:#94a3b8; white-space:nowrap;">{{ $doc->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="{{ route('documents.show', $doc) }}" class="btn-table view" title="View"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('documents.download', $doc) }}" class="btn-table download" title="Download"><i class="fas fa-download"></i></a>
                                                    <a href="{{ route('documents.edit', $doc) }}" class="btn-table edit" title="Edit"><i class="fas fa-pen"></i></a>
                                                    <button onclick="confirmDelete({{ $doc->id }}, '{{ str_replace("'", "\\'", $doc->title) }}')" class="btn-table delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer">
                            <div class="table-footer-info">
                                Showing <strong>{{ ($documents->currentPage() - 1) * $documents->perPage() + 1 }}</strong> to <strong>{{ min($documents->currentPage() * $documents->perPage(), $documents->total()) }}</strong> of <strong>{{ $documents->total() }}</strong> results
                            </div>
                            <div class="pagination">{{ $documents->links() }}</div>
                        </div>
                    @else
                        <div class="empty-table">
                            <div class="empty-icon-wrap"><i class="fas fa-inbox"></i></div>
                            <h3>No documents found</h3>
                            <p>Try adjusting your search or filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteOverlay" class="modal-overlay" onclick="closeDeleteModal()"></div>
    <div id="deleteModal" class="confirm-modal">
        <div class="confirm-modal-header"></div>
        <div class="confirm-modal-body">
            <div class="confirm-icon"><i class="fas fa-trash-alt"></i></div>
            <h3>Delete Document?</h3>
            <p>This action cannot be undone. The file and all its data will be permanently removed.</p>
            <div class="confirm-doc-name" id="deleteDocName"></div>
        </div>
        <div class="confirm-modal-footer">
            <button onclick="closeDeleteModal()" class="btn-confirm-cancel">Cancel</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-delete"><i class="fas fa-trash-alt"></i> Yes, Delete</button>
            </form>
        </div>
    </div>

    <!-- TOAST CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
    function toggleMenu(header) {
        header.classList.toggle('active');
        header.nextElementSibling.classList.toggle('open');
    }

    function clearSearch() {
        const input = document.querySelector('#manageFilterForm input[name="search"]');
        if (input) { input.value = ''; }
        document.getElementById('manageFilterForm').submit();
    }

    let searchTimeout;
    document.querySelector('#manageFilterForm input[name="search"]')?.addEventListener('input', function() {
        const btn = this.parentElement.querySelector('.btn-reset');
        btn.classList.toggle('visible', this.value.trim().length > 0);
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('manageFilterForm').submit();
        }, 600);
    });

    function toggleSelectAll(master) {
        document.querySelectorAll('.row-check').forEach(cb => { cb.checked = master.checked; });
        updateBulkBar();
    }

    function updateBulkBar() {
        const checked = document.querySelectorAll('.row-check:checked');
        const bar = document.getElementById('bulkBar');
        const num = document.getElementById('bulkCountNum');
        if (checked.length > 0) {
            bar.classList.add('visible');
            num.textContent = checked.length;
            checked.forEach(cb => { cb.closest('tr').classList.add('selected'); });
        } else {
            bar.classList.remove('visible');
            num.textContent = '0';
        }
        document.querySelectorAll('.row-check:not(:checked)').forEach(cb => { cb.closest('tr').classList.remove('selected'); });
        const all = document.querySelectorAll('.row-check');
        const master = document.getElementById('selectAll');
        master.checked = all.length > 0 && checked.length === all.length;
        master.indeterminate = checked.length > 0 && checked.length < all.length;
    }

    function clearSelection() {
        document.querySelectorAll('.row-check').forEach(cb => { cb.checked = false; });
        document.getElementById('selectAll').checked = false;
        document.getElementById('selectAll').indeterminate = false;
        updateBulkBar();
    }

    let pendingDeleteId = null;

    function confirmDelete(id, name) {
        pendingDeleteId = id;
        document.getElementById('deleteDocName').textContent = name;
        document.getElementById('deleteForm').action = '/documents/' + id;
        document.getElementById('deleteOverlay').classList.add('active');
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteOverlay').classList.remove('active');
        document.getElementById('deleteModal').classList.remove('active');
        pendingDeleteId = null;
    }

    function bulkDelete() {
        const checked = document.querySelectorAll('.row-check:checked');
        if (checked.length === 0) return;

        const ids = Array.from(checked).map(cb => cb.value);
        const count = ids.length;

        pendingDeleteId = 'bulk';
        document.getElementById('deleteDocName').textContent = count + ' document' + (count > 1 ? 's' : '');
        document.getElementById('deleteOverlay').classList.add('active');
        document.getElementById('deleteModal').classList.add('active');

        const form = document.getElementById('deleteForm');
        form.action = '{{ route("documents.bulk-delete") }}';
        form.onsubmit = function(e) {
            e.preventDefault();
            closeDeleteModal();
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            fetch('{{ route("documents.bulk-delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(response => response.json())
            .then(data => {
                if (data.deleted) {
                    ids.forEach(id => {
                        const row = document.getElementById('row-' + id);
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(20px)';
                            setTimeout(() => row.remove(), 300);
                        }
                    });
                    showToast('success', data.deleted + ' document' + (data.deleted > 1 ? 's' : '') + ' deleted successfully.');
                    clearSelection();
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showToast('error', data.message || 'Failed to delete documents.');
                }
            })
            .catch(() => {
                showToast('error', 'Something went wrong. Please try again.');
            });

            form.onsubmit = null;
        };
    }

    function showToast(type, message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        toast.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} toast-icon"></i>
            <span class="toast-msg">${message}</span>
            <button onclick="this.parentElement.remove()" class="toast-close"><i class="fas fa-xmark"></i></button>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
    </script>
</x-app-layout>