<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    
    nav[class*="bg-white"][class*="border-b"] { display: none !important; }
    body { 
        padding-top: 0 !important; overflow: hidden !important; font-family: 'Inter', sans-serif; 
        background: #f1f5f9; color: #1e293b; margin: 0;
    }

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

    .sidebar {
        width: 272px; background: #ffffff; border-right: 1px solid #e2e8f0;
        display: flex; flex-direction: column; position: fixed; height: 100%; left: 0; top: 0; z-index: 1000;
        box-shadow: 2px 0 24px rgba(0, 0, 0, 0.04);
    }
    .sidebar-header { padding: 1.5rem 1.25rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(180deg, #ffffff 0%, #f8fffe 100%); }
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
    .sidebar-footer { padding: 0.75rem; border-top: 1px solid #f1f5f9; background: #fafbfc; }
    .user-card { display: flex; align-items: center; padding: 0.6rem 0.75rem; border-radius: 12px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.03); }
    .user-avatar-sidebar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25); }
    .user-info { margin-left: 10px; flex: 1; }
    .user-name { font-size: 0.82rem; font-weight: 600; color: #0f172a; display: block; }
    .user-role { font-size: 0.66rem; color: #94a3b8; font-weight: 500; }
    .logout-link { display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.55rem; color: #ef4444; background: #fef2f2; text-decoration: none; border-radius: 10px; font-size: 0.78rem; font-weight: 600; transition: all 0.2s; margin-top: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.08); }
    .logout-link:hover { background: #fee2e2; border-color: rgba(239, 68, 68, 0.15); }

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

    .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; flex-shrink: 0; }
    .stat-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.1rem 1.2rem;
        position: relative; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 14px 14px 0 0; transition: height 0.3s ease; }
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

    .scroll-area { flex: 1; min-height: 0; overflow-y: auto !important; padding-bottom: 2rem; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
    .scroll-area::-webkit-scrollbar { width: 6px; }
    .scroll-area::-webkit-scrollbar-track { background: transparent; }
    .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

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

    .table-container { background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 0 0 1px rgba(0,0,0,0.01); }
    .table-scroll { overflow-x: auto; }
    .table-scroll::-webkit-scrollbar { height: 5px; }
    .table-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .data-table thead { background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 2px solid #e2e8f0; }
    .data-table th { padding: 13px 16px; text-align: left; font-weight: 700; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; }
    .data-table td { padding: 14px 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; color: #334155; }
    .data-table tbody tr { transition: all 0.2s ease; }
    .data-table tbody tr:hover { background: #f8fffe; }
    .data-table tbody tr.selected { background: #f0fdfa; }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .doc-checkbox { width: 17px; height: 17px; accent-color: #0d9488; cursor: pointer; border-radius: 4px; }

    .cat-icon-dot {
        width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: relative; overflow: hidden; transition: transform 0.2s;
    }
    .cat-icon-dot::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.2) 100%); }
    .data-table tbody tr:hover .cat-icon-dot { transform: scale(1.08); }
    .table-title { font-weight: 700; color: #0f172a; display: block; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.84rem; }
    .table-title a { color: inherit; text-decoration: none; transition: all 0.2s; cursor: pointer; }
    .table-title a:hover { color: #0d9488; }
    .table-subtitle { font-size: 0.7rem; color: #94a3b8; font-weight: 400; margin-top: 3px; display: block; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .doc-count-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; }
    .doc-count-badge.has-docs { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .doc-count-badge.no-docs { background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0; }
    .slug-badge { display: inline-block; padding: 4px 10px; background: #f1f5f9; color: #64748b; border-radius: 7px; font-size: 0.68rem; font-weight: 500; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border: 1px solid #e2e8f0; font-family: 'SF Mono', 'Fira Code', monospace; }

    .table-actions { display: flex; gap: 6px; }
    .btn-table {
        width: 34px; height: 34px; border-radius: 9px; border: none;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); font-size: 0.78rem;
        position: relative; overflow: hidden;
    }
    .btn-table::after { content: ''; position: absolute; inset: 0; border-radius: 9px; background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.2) 100%); opacity: 0; transition: opacity 0.2s; }
    .btn-table:hover::after { opacity: 1; }
    .btn-table.view { background: #ecfdf5; color: #059669; box-shadow: 0 1px 4px rgba(5, 150, 105, 0.15), inset 0 0 0 1px rgba(5, 150, 105, 0.1); }
    .btn-table.view:hover { background: #059669; color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); }
    .btn-table.edit { background: #fffbeb; color: #d97706; box-shadow: 0 1px 4px rgba(217, 119, 6, 0.15), inset 0 0 0 1px rgba(217, 119, 6, 0.1); }
    .btn-table.edit:hover { background: #d97706; color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); }
    .btn-table.delete { background: #fef2f2; color: #dc2626; box-shadow: 0 1px 4px rgba(220, 38, 38, 0.12), inset 0 0 0 1px rgba(220, 38, 38, 0.08); }
    .btn-table.delete:hover { background: #dc2626; color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3); }

    .table-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border-top: 1px solid #f1f5f9; background: #fafbfc; }
    .table-footer-info { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }
    .table-footer-info strong { color: #475569; }
    .pagination { display: flex; gap: 4px; }
    .pagination a, .pagination span { padding: 7px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 600; border: 1.5px solid #e2e8f0; color: #64748b; text-decoration: none; transition: all 0.25s; background: white; }
    .pagination a:hover { background: #f0fdfa; border-color: #99f6e4; color: #0d9488; transform: translateY(-1px); }
    .pagination .active { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-color: transparent; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3); }
    .pagination .disabled { opacity: 0.35; pointer-events: none; }
    .empty-table { padding: 5rem 2rem; text-align: center; }
    .empty-icon-wrap { width: 72px; height: 72px; border-radius: 18px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .empty-icon-wrap i { font-size: 1.8rem; color: #cbd5e1; }
    .empty-table h3 { font-size: 1.05rem; font-weight: 700; color: #334155; margin: 0 0 0.4rem; }
    .empty-table p { font-size: 0.82rem; color: #94a3b8; margin: 0; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(6px); z-index: 2000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    .modal-overlay.active { opacity: 1; pointer-events: auto; }
    .generic-modal { position: fixed; top: 50%; left: 50%; width: 480px; max-width: 95vw; background: white; z-index: 2001; border-radius: 1.25rem; box-shadow: 0 25px 60px -12px rgba(0,0,0,0.2), 0 0 0 1px rgba(0,0,0,0.03); overflow: hidden; transform: translate(-50%, -50%) scale(0.95); opacity: 0; pointer-events: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .generic-modal.active { transform: translate(-50%, -50%) scale(1); opacity: 1; pointer-events: auto; }
    .modal-head { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .modal-head h3 { margin: 0; font-size: 1.05rem; font-weight: 800; color: #0f172a; }
    .modal-head-close { width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; font-size: 0.75rem; }
    .modal-head-close:hover { background: #fef2f2; color: #ef4444; border-color: #fecaca; }
    .modal-body { padding: 1.5rem; }
    .modal-foot { padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 0.65rem; background: #fafbfc; }

    .form-group { margin-bottom: 1.15rem; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
    .form-input { width: 100%; padding: 10px 14px; background: white; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; color: #1e293b; transition: all 0.25s; box-shadow: 0 1px 2px rgba(0,0,0,0.02); font-family: 'Inter', sans-serif; }
    .form-input:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08), 0 2px 8px rgba(13, 148, 136, 0.06); }
    .form-input::placeholder { color: #cbd5e1; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .form-hint { font-size: 0.7rem; color: #94a3b8; margin-top: 4px; }
    .form-error { font-size: 0.72rem; color: #ef4444; margin-top: 4px; display: none; }

    .btn-modal { padding: 10px 22px; font-size: 0.82rem; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; transition: all 0.25s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-modal.cancel { background: white; color: #64748b; border: 1.5px solid #e2e8f0; }
    .btn-modal.cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-modal.save { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.3); }
    .btn-modal.save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(13, 148, 136, 0.4); }
    .btn-modal.save:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .btn-modal.danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3); }
    .btn-modal.danger:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4); }

    .confirm-icon { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .confirm-icon i { font-size: 1.4rem; color: #ef4444; }
    .confirm-icon.warning { background: linear-gradient(135deg, #fffbeb, #fef3c7); border-color: #fde68a; }
    .confirm-icon.warning i { color: #f59e0b; }
    .confirm-modal-body { padding: 1.5rem; text-align: center; }
    .confirm-modal-body h3 { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem; }
    .confirm-modal-body p { font-size: 0.82rem; color: #64748b; margin: 0; line-height: 1.6; }
    .confirm-doc-name { font-weight: 600; color: #0f172a; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; display: inline-block; margin-top: 0.6rem; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border: 1px solid #e2e8f0; font-size: 0.82rem; }

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
    @keyframes rowSlideIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
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
    @media (max-width: 768px) { .toolbar { flex-direction: column; align-items: stretch; } .toolbar-left { flex-direction: column; } .search-box { max-width: 100%; } .stat-cards { grid-template-columns: 1fr 1fr; gap: 0.65rem; } .stat-card { padding: 0.9rem 1rem; } .stat-value { font-size: 1.3rem; } }
</style>

<x-app-layout>
    <div class="bg-pattern"></div>

    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; z-index: 999;">
        
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
                    <div class="menu-header" onclick="toggleMenu(this)"><span>By Type</span><i class="fas fa-chevron-down menu-arrow"></i></div>
                    <div class="submenu">
                        <a href="{{ route('documents.index', ['type' => 'book']) }}" class="nav-link"><i class="fas fa-book"></i> Books & Monographs</a>
                        <a href="{{ route('documents.index', ['type' => 'record']) }}" class="nav-link"><i class="fas fa-file-shield"></i> Archives & Records</a>
                        <a href="{{ route('documents.index', ['type' => 'file']) }}" class="nav-link"><i class="fas fa-photo-film"></i> Media & Files</a>
                        <a href="{{ route('documents.index', ['type' => 'thesis']) }}" class="nav-link"><i class="fas fa-graduation-cap"></i> Theses & Dissertations</a>
                    </div>
                </div>
                @auth
                <div class="menu-group">
                    <div class="menu-header active" onclick="toggleMenu(this)"><span>Administration</span><i class="fas fa-chevron-down menu-arrow"></i></div>
                    <div class="submenu open">
                        <a href="{{ route('documents.manage') }}" class="nav-link"><i class="fas fa-table-list"></i> Manage Documents</a>
                        <a href="{{ route('categories.manage') }}" class="nav-link active"><i class="fas fa-tags"></i> Manage Categories</a>
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

        <main class="main-content">
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Manage Categories</h1>
                    <p>Organize and maintain document categories across the repository.</p>
                    <div class="breadcrumb">
                        <a href="{{ route('home') }}">Dashboard</a>
                        <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem;"></i></span>
                        <a href="{{ route('documents.manage') }}">Administration</a>
                        <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem;"></i></span>
                        <span class="current">Categories</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('documents.manage') }}" class="btn-action secondary"><i class="fas fa-arrow-left"></i> Back to Documents</a>
                    <button onclick="openCreateModal()" class="btn-action primary"><i class="fas fa-plus"></i> New Category</button>
                </div>
            </div>

            <div class="scroll-area">
                <div class="stat-cards">
                    <div class="stat-card emerald">
                        <div class="stat-icon-wrap"><i class="fas fa-tags"></i></div>
                        <div class="stat-value">{{ $categories->total() }}</div>
                        <div class="stat-label">Total Categories</div>
                    </div>
                    <div class="stat-card blue">
                        <div class="stat-icon-wrap"><i class="fas fa-folder-open"></i></div>
                        <div class="stat-value">{{ $withDocsCount }}</div>
                        <div class="stat-label">With Documents</div>
                    </div>
                    <div class="stat-card violet">
                        <div class="stat-icon-wrap"><i class="fas fa-folder"></i></div>
                        <div class="stat-value">{{ $emptyCount }}</div>
                        <div class="stat-label">Empty Categories</div>
                    </div>
                    <div class="stat-card amber">
                        <div class="stat-icon-wrap"><i class="fas fa-file-lines"></i></div>
                        <div class="stat-value">{{ $totalDocsInCats }}</div>
                        <div class="stat-label">Total Documents</div>
                    </div>
                </div>

                <form id="manageFilterForm" action="{{ route('categories.manage') }}" method="GET">
                    <div class="toolbar">
                        <div class="toolbar-left">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories by name or description..." autocomplete="off">
                                <button type="button" class="btn-reset {{ request('search') ? 'visible' : '' }}" onclick="clearSearch()" title="Clear"><i class="fas fa-xmark"></i></button>
                            </div>
                            <select name="status" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="with_docs" {{ request('status') == 'with_docs' ? 'selected' : '' }}>With Documents</option>
                                <option value="empty" {{ request('status') == 'empty' ? 'selected' : '' }}>Empty</option>
                            </select>
                        </div>
                        <div class="toolbar-right">
                            <select name="sort" class="filter-select" onchange="this.form.submit()" style="width:160px;">
                                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                                <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                <option value="docs_count" {{ request('sort') == 'docs_count' ? 'selected' : '' }}>Most Documents</option>
                                <option value="docs_count_asc" {{ request('sort') == 'docs_count_asc' ? 'selected' : '' }}>Least Documents</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="bulk-bar" id="bulkBar">
                    <span class="bulk-count"><span id="bulkCountNum">0</span> selected</span>
                    <button class="btn-bulk danger" onclick="bulkDelete()"><i class="fas fa-trash-alt"></i> Delete Selected</button>
                    <button class="btn-bulk cancel" onclick="clearSelection()"><i class="fas fa-xmark"></i> Cancel</button>
                </div>

                <div class="table-container">
                    @if($categories->count() > 0)
                        <div class="table-scroll">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"><input type="checkbox" class="doc-checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                                        <th style="width:62px;">Icon</th>
                                        <th>Name</th>
                                        <th style="width:140px;">Slug</th>
                                        <th style="width:120px;">Documents</th>
                                        <th style="width:100px;">Created</th>
                                        <th style="width:110px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $cat)
                                        @php $docCount = $cat->documents_count ?? $cat->documents->count(); @endphp
                                        <tr id="row-{{ $cat->id }}" data-id="{{ $cat->id }}"
                                            data-name="{{ $cat->name }}"
                                            data-description="{{ $cat->description ?? '' }}">
                                            <td><input type="checkbox" class="doc-checkbox row-check" value="{{ $cat->id }}" onchange="updateBulkBar()"></td>
                                            <td>
                                                @php $hue = abs(crc32($cat->name)) % 360; @endphp
                                                <div class="cat-icon-dot" style="background: hsl({{ $hue }}, 55%, 45%);">
                                                    <i class="fas fa-tag" style="position:relative;z-index:1;"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="table-title"><a onclick="openEditModal({{ $cat->id }})">{{ $cat->name }}</a></span>
                                                <span class="table-subtitle">{{ $cat->description ? Str::limit($cat->description, 70) : 'No description provided' }}</span>
                                            </td>
                                            <td>
                                                <span class="slug-badge" title="{{ $cat->slug }}">{{ $cat->slug }}</span>
                                            </td>
                                            <td>
                                                @if($docCount > 0)
                                                    <span class="doc-count-badge has-docs">
                                                        <i class="fas fa-file-lines" style="font-size:0.7rem;"></i>
                                                        {{ $docCount }} {{ Str::plural('doc', $docCount) }}
                                                    </span>
                                                @else
                                                    <span class="doc-count-badge no-docs">
                                                        <i class="fas fa-inbox" style="font-size:0.7rem;"></i>
                                                        Empty
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="font-size: 0.75rem; color: #94a3b8; white-space: nowrap;">{{ $cat->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="{{ route('documents.index', ['category' => $cat->id]) }}" class="btn-table view" title="View Documents"><i class="fas fa-eye"></i></a>
                                                    <button onclick="openEditModal({{ $cat->id }})" class="btn-table edit" title="Edit Category"><i class="fas fa-pen"></i></button>
                                                    <button onclick="confirmDelete({{ $cat->id }}, '{{ str_replace("'", "\\'", $cat->name) }}', {{ $docCount }})" class="btn-table delete" title="Delete Category"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer">
                            <div class="table-footer-info">
                                Showing <strong>{{ ($categories->currentPage() - 1) * $categories->perPage() + 1 }}</strong> to <strong>{{ min($categories->currentPage() * $categories->perPage(), $categories->total()) }}</strong> of <strong>{{ $categories->total() }}</strong> categories
                            </div>
                            <div class="pagination">{{ $categories->links() }}</div>
                        </div>
                    @else
                        <div class="empty-table">
                            <div class="empty-icon-wrap"><i class="fas fa-tags"></i></div>
                            <h3>No categories found</h3>
                            <p>Try adjusting your search or filters, or create a new category to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- CREATE MODAL -->
    <div id="createOverlay" class="modal-overlay" onclick="closeCreateModal()"></div>
    <div id="createModal" class="generic-modal">
        <div class="modal-head">
            <h3><i class="fas fa-plus" style="color:#0d9488;margin-right:8px;font-size:0.9rem;"></i>New Category</h3>
            <button class="modal-head-close" onclick="closeCreateModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form id="createForm">
                @csrf
                <div class="form-group">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" id="createName" class="form-input" placeholder="e.g. Historical Archives" required maxlength="100" autofocus>
                    <div class="form-error" id="createNameError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description <span style="font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0;">(optional)</span></label>
                    <textarea name="description" id="createDesc" class="form-input" placeholder="Brief description of this category..." maxlength="255" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button class="btn-modal cancel" onclick="closeCreateModal()">Cancel</button>
            <button class="btn-modal save" id="createBtn" onclick="submitCreate()"><i class="fas fa-check"></i> Create Category</button>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editOverlay" class="modal-overlay" onclick="closeEditModal()"></div>
    <div id="editModal" class="generic-modal">
        <div class="modal-head">
            <h3><i class="fas fa-pen" style="color:#d97706;margin-right:8px;font-size:0.85rem;"></i>Edit Category</h3>
            <button class="modal-head-close" onclick="closeEditModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form id="editForm">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" id="editName" class="form-input" placeholder="Category name" required maxlength="100">
                    <div class="form-error" id="editNameError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description <span style="font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0;">(optional)</span></label>
                    <textarea name="description" id="editDesc" class="form-input" placeholder="Brief description..." maxlength="255" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button class="btn-modal cancel" onclick="closeEditModal()">Cancel</button>
            <button class="btn-modal save" id="editBtn" onclick="submitEdit()"><i class="fas fa-check"></i> Save Changes</button>
        </div>
    </div>

    <!-- DELETE CONFIRM MODAL -->
    <div id="deleteOverlay" class="modal-overlay" onclick="closeDeleteModal()"></div>
    <div id="deleteModal" class="generic-modal">
        <div class="confirm-modal-body" style="padding-top:2rem;">
            <div class="confirm-icon" id="deleteIcon"><i class="fas fa-trash-alt"></i></div>
            <h3 id="deleteTitle">Delete Category?</h3>
            <p id="deleteMessage">This action cannot be undone. The category will be permanently removed.</p>
            <div class="confirm-doc-name" id="deleteDocName"></div>
        </div>
        <div class="modal-foot" style="justify-content:center;">
            <button onclick="closeDeleteModal()" class="btn-modal cancel">Cancel</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal danger"><i class="fas fa-trash-alt"></i> Yes, Delete</button>
            </form>
        </div>
    </div>

    <!-- BULK DELETE MODAL -->
    <div id="bulkDeleteOverlay" class="modal-overlay" onclick="closeBulkDeleteModal()"></div>
    <div id="bulkDeleteModal" class="generic-modal">
        <div class="confirm-modal-body" style="padding-top:2rem;">
            <div class="confirm-icon"><i class="fas fa-trash-alt"></i></div>
            <h3>Delete Selected Categories?</h3>
            <p>This will permanently remove <strong id="bulkDeleteCount">0</strong> selected categories. Documents in those categories will become uncategorized.</p>
        </div>
        <div class="modal-foot" style="justify-content:center;">
            <button onclick="closeBulkDeleteModal()" class="btn-modal cancel">Cancel</button>
            <form id="bulkDeleteForm" method="POST" action="/categories/bulk-destroy" style="display:inline;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="ids" id="bulkDeleteIds" value="">
                <button type="submit" class="btn-modal danger"><i class="fas fa-trash-alt"></i> Yes, Delete All</button>
            </form>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
    function toggleMenu(header) {
        header.classList.toggle('active');
        header.nextElementSibling.classList.toggle('open');
    }

    function clearSearch() {
        const input = document.querySelector('#manageFilterForm input[name="search"]');
        if (input) input.value = '';
        document.getElementById('manageFilterForm').submit();
    }
    let searchTimeout;
    document.querySelector('#manageFilterForm input[name="search"]')?.addEventListener('input', function() {
        this.parentElement.querySelector('.btn-reset').classList.toggle('visible', this.value.trim().length > 0);
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => document.getElementById('manageFilterForm').submit(), 600);
    });

    function toggleSelectAll(master) {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }
    function updateBulkBar() {
        const checked = document.querySelectorAll('.row-check:checked');
        const bar = document.getElementById('bulkBar');
        const num = document.getElementById('bulkCountNum');
        document.querySelectorAll('.row-check').forEach(cb => cb.closest('tr').classList.toggle('selected', cb.checked));
        if (checked.length > 0) {
            bar.classList.add('visible');
            num.textContent = checked.length;
        } else {
            bar.classList.remove('visible');
            num.textContent = '0';
        }
        const all = document.querySelectorAll('.row-check');
        const master = document.getElementById('selectAll');
        if (master) master.checked = all.length > 0 && checked.length === all.length;
    }
    function clearSelection() {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateBulkBar();
    }

    function openCreateModal() {
        document.getElementById('createForm').reset();
        document.getElementById('createNameError').style.display = 'none';
        document.getElementById('createOverlay').classList.add('active');
        document.getElementById('createModal').classList.add('active');
        setTimeout(() => document.getElementById('createName').focus(), 300);
    }
    function closeCreateModal() {
        document.getElementById('createOverlay').classList.remove('active');
        document.getElementById('createModal').classList.remove('active');
    }
    function submitCreate() {
        const name = document.getElementById('createName').value.trim();
        const desc = document.getElementById('createDesc').value.trim();
        const errEl = document.getElementById('createNameError');
        const btn = document.getElementById('createBtn');
        if (!name) {
            errEl.textContent = 'Category name is required.';
            errEl.style.display = 'block';
            document.getElementById('createName').focus();
            return;
        }
        errEl.style.display = 'none';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
        fetch('{{ route("categories.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('#createForm input[name="_token"]').value
            },
            body: JSON.stringify({ name, description: desc || null })
        })
        .then(r => r.json())
        .then(data => {
            if (data.errors) {
                errEl.textContent = data.errors.name ? data.errors.name[0] : 'An error occurred.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Create Category';
                return;
            }
            closeCreateModal();
            showToast('Category "' + (data.name || name) + '" created successfully!', 'success');
            setTimeout(() => location.reload(), 600);
        })
        .catch(() => {
            errEl.textContent = 'Network error. Please try again.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Create Category';
        });
    }

    let editingId = null;
    function openEditModal(id) {
        const row = document.getElementById('row-' + id);
        if (!row) return;
        editingId = id;
        document.getElementById('editName').value = row.dataset.name || '';
        document.getElementById('editDesc').value = row.dataset.description || '';
        document.getElementById('editNameError').style.display = 'none';
        document.getElementById('editOverlay').classList.add('active');
        document.getElementById('editModal').classList.add('active');
        setTimeout(() => document.getElementById('editName').focus(), 300);
    }
    function closeEditModal() {
        document.getElementById('editOverlay').classList.remove('active');
        document.getElementById('editModal').classList.remove('active');
        editingId = null;
    }
    function submitEdit() {
        const name = document.getElementById('editName').value.trim();
        const desc = document.getElementById('editDesc').value.trim();
        const errEl = document.getElementById('editNameError');
        const btn = document.getElementById('editBtn');
        if (!name) {
            errEl.textContent = 'Category name is required.';
            errEl.style.display = 'block';
            document.getElementById('editName').focus();
            return;
        }
        if (!editingId) return;
        errEl.style.display = 'none';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        fetch('/categories/' + editingId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('#editForm input[name="_token"]').value
            },
            body: JSON.stringify({ name, description: desc || null })
        })
        .then(r => r.json())
        .then(data => {
            if (data.errors) {
                errEl.textContent = data.errors.name ? data.errors.name[0] : 'An error occurred.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Save Changes';
                return;
            }
            closeEditModal();
            showToast('Category updated successfully!', 'success');
            setTimeout(() => location.reload(), 600);
        })
        .catch(() => {
            errEl.textContent = 'Network error. Please try again.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Save Changes';
        });
    }

    function confirmDelete(id, name, docCount) {
        const icon = document.getElementById('deleteIcon');
        const title = document.getElementById('deleteTitle');
        const msg = document.getElementById('deleteMessage');
        document.getElementById('deleteDocName').textContent = name;
        document.getElementById('deleteForm').action = '/categories/' + id;
        if (docCount > 0) {
            icon.className = 'confirm-icon warning';
            icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            title.textContent = 'Delete Category with Documents?';
            msg.innerHTML = 'This category contains <strong>' + docCount + ' document(s)</strong>. Deleting it will make those documents uncategorized.';
        } else {
            icon.className = 'confirm-icon';
            icon.innerHTML = '<i class="fas fa-trash-alt"></i>';
            title.textContent = 'Delete Category?';
            msg.textContent = 'This action cannot be undone. The category will be permanently removed.';
        }
        document.getElementById('deleteOverlay').classList.add('active');
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeDeleteModal() {
        document.getElementById('deleteOverlay').classList.remove('active');
        document.getElementById('deleteModal').classList.remove('active');
    }

    function bulkDelete() {
        const checked = document.querySelectorAll('.row-check:checked');
        if (!checked.length) return;
        const ids = Array.from(checked).map(cb => cb.value);
        document.getElementById('bulkDeleteCount').textContent = ids.length;
        document.getElementById('bulkDeleteIds').value = ids.join(',');
        document.getElementById('bulkDeleteOverlay').classList.add('active');
        document.getElementById('bulkDeleteModal').classList.add('active');
    }
    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteOverlay').classList.remove('active');
        document.getElementById('bulkDeleteModal').classList.remove('active');
    }

    function showToast(message, type) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast ' + type;
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        toast.innerHTML = '<i class="fas ' + icon + ' toast-icon"></i><span class="toast-msg">' + message + '</span><button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>';
        container.appendChild(toast);
        setTimeout(() => { if (toast.parentElement) toast.remove(); }, 4000);
    }

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session("error") }}', 'error');
    @endif

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeCreateModal(); closeEditModal(); closeDeleteModal(); closeBulkDeleteModal(); }
    });
    document.getElementById('createName')?.addEventListener('keydown', function(e) { if (e.key === 'Enter') { e.preventDefault(); submitCreate(); } });
    document.getElementById('editName')?.addEventListener('keydown', function(e) { if (e.key === 'Enter') { e.preventDefault(); submitEdit(); } });
    </script>
</x-app-layout>