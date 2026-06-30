<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Republic of Kenya — Digital Library Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
    <style>
        :root {
            --gok-green: #006B3F;
            --gok-green-dark: #004D2E;
            --gok-green-light: #00875A;
            --gok-red: #BB2538;
            --gok-red-dark: #8B1A28;
            --gok-black: #1A1A1A;
            --gok-black-light: #2D2D2D;
            --gok-white: #FFFFFF;
            --gok-cream: #FAFAF5;
            --gok-gray-50: #F8F9FA;
            --gok-gray-100: #F1F3F5;
            --gok-gray-200: #E5E7EB;
            --gok-gray-300: #D1D5DB;
            --gok-gray-400: #9CA3AF;
            --gok-gray-500: #6B7280;
            --gok-gray-600: #4B5563;
            --gok-gold: #B8860B;
        }

        html { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
        .reader-content { -webkit-user-select: text; -moz-user-select: text; -ms-user-select: text; user-select: text; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--gok-cream); color: var(--gok-black); overflow-x: hidden; }

        .gok-top-bar {
            height: 4px; background: linear-gradient(90deg, var(--gok-black) 0%, var(--gok-black) 50%, var(--gok-red) 50%, var(--gok-red) 100%);
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
        }

        .r-nav {
            position: fixed; top: 4px; left: 0; right: 0; z-index: 100;
            height: 60px; background: rgba(255,255,255,0.92); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gok-gray-200);
            display: flex; align-items: center; justify-content: space-between; padding: 0 2rem;
        }
        .r-nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .r-nav-coat {
            width: 38px; height: 38px; background: linear-gradient(135deg, var(--gok-green), var(--gok-green-dark));
            color: white; border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 0.9rem;
            box-shadow: 0 3px 12px rgba(0, 107, 63, 0.3);
            position: relative; overflow: hidden;
        }
        .r-nav-coat::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.12) 100%); }
        .r-nav-text-group { display: flex; flex-direction: column; }
        .r-nav-name { font-size: 0.85rem; font-weight: 800; color: var(--gok-green-dark); letter-spacing: 0.02em; line-height: 1.2; }
        .r-nav-sub { font-size: 0.55rem; color: var(--gok-gray-500); font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }
        .r-nav-center { display: flex; align-items: center; gap: 0.15rem; }
        .r-nav-tab {
            padding: 8px 16px; font-size: 0.78rem; font-weight: 500; color: var(--gok-gray-500);
            text-decoration: none; border-radius: 8px; transition: all 0.2s; position: relative;
        }
        .r-nav-tab:hover { color: var(--gok-green); background: rgba(0, 107, 63, 0.04); }
        .r-nav-tab.active { color: var(--gok-green-dark); background: rgba(0, 107, 63, 0.08); font-weight: 600; }
        .r-nav-tab.active::after { content: ''; position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%); width: 16px; height: 2px; background: var(--gok-green); border-radius: 2px; }
        .r-nav-right { display: flex; align-items: center; gap: 0.6rem; }
        .r-nav-search {
            display: flex; align-items: center; background: var(--gok-gray-50); border-radius: 10px;
            padding: 0 14px; height: 36px; transition: all 0.2s; border: 1.5px solid var(--gok-gray-200);
        }
        .r-nav-search:focus-within { border-color: var(--gok-green); background: white; box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.08); }
        .r-nav-search i { color: var(--gok-gray-400); font-size: 0.75rem; margin-right: 8px; }
        .r-nav-search input { border: none; background: none; outline: none; font-size: 0.8rem; font-family: 'Inter', sans-serif; color: var(--gok-black); width: 200px; }
        .r-nav-search input::placeholder { color: var(--gok-gray-300); }
        .r-admin-btn {
            padding: 8px 16px; font-size: 0.72rem; font-weight: 700; color: var(--gok-gray-500);
            background: none; border: 1.5px solid var(--gok-gray-200); border-radius: 8px;
            cursor: pointer; transition: all 0.25s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        .r-admin-btn:hover { color: var(--gok-green-dark); border-color: var(--gok-green); background: rgba(0, 107, 63, 0.03); }

        .r-hero {
            margin-top: 64px; padding: 5rem 2rem 4rem; position: relative; overflow: hidden;
            background: linear-gradient(160deg, var(--gok-black) 0%, var(--gok-black-light) 40%, #0a3d25 100%);
        }
        .r-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 80% at 85% 30%, rgba(0, 107, 63, 0.12) 0%, transparent 70%), radial-gradient(ellipse 40% 60% at 10% 90%, rgba(187, 37, 56, 0.06) 0%, transparent 60%);
        }
        .r-hero::after {
            content: ''; position: absolute; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M20 0L40 20L20 40L0 20z'/%3E%3C/g%3E/svg%3E");
        }
        .r-hero-inner { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; text-align: center; }
        .r-hero-crest {
            width: 72px; height: 72px; margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--gok-green), var(--gok-green-dark));
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: white; position: relative;
            box-shadow: 0 0 0 4px rgba(0, 107, 63, 0.15), 0 8px 32px rgba(0, 107, 63, 0.25);
        }
        .r-hero-crest::after { content: ''; position: absolute; inset: -4px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.1); }
        .r-hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0, 107, 63, 0.12); border: 1px solid rgba(0, 107, 63, 0.2);
            color: #6ee7b7; font-size: 0.62rem; font-weight: 700; padding: 6px 16px;
            border-radius: 20px; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.1em;
        }
        .r-hero-badge i { font-size: 0.55rem; color: var(--gok-red); }
        .r-hero h1 { font-family: 'Playfair Display', serif; font-size: 3.25rem; font-weight: 700; color: var(--gok-white); line-height: 1.15; letter-spacing: -0.01em; margin-bottom: 0.75rem; }
        .r-hero h1 .highlight { color: #6ee7b7; }
        .r-hero .r-hero-motto { font-size: 0.95rem; color: rgba(255,255,255,0.4); font-style: italic; font-family: 'Lora', serif; margin-bottom: 1.5rem; letter-spacing: 0.02em; }
        .r-hero p { font-size: 1rem; color: rgba(255,255,255,0.55); max-width: 540px; margin: 0 auto 2.5rem; line-height: 1.75; }
        .r-hero-stats { display: flex; justify-content: center; gap: 3.5rem; }
        .r-hero-stat { text-align: center; }
        .r-hero-stat-val { font-size: 1.75rem; font-weight: 900; color: var(--gok-white); line-height: 1; }
        .r-hero-stat-val .accent { color: var(--gok-gold); }
        .r-hero-stat-label { font-size: 0.6rem; color: rgba(255,255,255,0.3); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 6px; }
        .r-hero-tricolor { display: flex; justify-content: center; gap: 0; margin-top: 2.5rem; }
        .r-hero-tricolor span { height: 3px; width: 60px; }
        .r-hero-tricolor .t-black { background: var(--gok-black); border-radius: 2px 0 0 2px; }
        .r-hero-tricolor .t-red { background: var(--gok-red); }
        .r-hero-tricolor .t-green { background: var(--gok-green); border-radius: 0 2px 2px 0; }

        .r-features { max-width: 1200px; margin: -2rem auto 0; padding: 0 2rem; position: relative; z-index: 2; }
        .r-features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .r-feature-card { background: white; border-radius: 16px; padding: 1.5rem; text-align: center; border: 1px solid var(--gok-gray-200); box-shadow: 0 4px 16px rgba(0,0,0,0.04); transition: all 0.3s; }
        .r-feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); border-color: transparent; }
        .r-feature-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin: 0 auto 0.75rem; }
        .r-feature-card:nth-child(1) .r-feature-icon { background: rgba(0, 107, 63, 0.08); color: var(--gok-green); }
        .r-feature-card:nth-child(2) .r-feature-icon { background: rgba(187, 37, 56, 0.08); color: var(--gok-red); }
        .r-feature-card:nth-child(3) .r-feature-icon { background: rgba(0,0,0,0.06); color: var(--gok-black-light); }
        .r-feature-title { font-size: 0.82rem; font-weight: 700; color: var(--gok-black); margin-bottom: 0.3rem; }
        .r-feature-desc { font-size: 0.72rem; color: var(--gok-gray-500); line-height: 1.5; }

        /* ═══ SHELF ═══ */
        .r-shelf { max-width: 1320px; margin: 0 auto; padding: 3rem 1.5rem; }
        .r-shelf-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; }
        .r-shelf-title { font-size: 1.2rem; font-weight: 800; color: var(--gok-black); display: flex; align-items: center; gap: 10px; }
        .r-shelf-title .gok-bar { width: 4px; height: 22px; background: linear-gradient(180deg, var(--gok-green), var(--gok-red)); border-radius: 2px; }
        .r-shelf-count { font-size: 0.78rem; color: var(--gok-gray-400); font-weight: 500; margin-left: 4px; }
        .r-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 1.25rem; }
        .r-book { position: relative; transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; cursor: pointer; }
        .r-book:hover { transform: translateY(-6px); }
        .r-book-cover {
            aspect-ratio: 3 / 4.2; border-radius: 6px 10px 10px 6px; overflow: hidden;
            position: relative; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 8px 24px rgba(0,0,0,0.08);
            transition: box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .r-book:hover .r-book-cover { box-shadow: 0 4px 12px rgba(0,0,0,0.08), 0 16px 40px rgba(0,0,0,0.14); }
        .r-book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .r-book:hover .r-book-cover img { transform: scale(1.04); }
        .r-book-spine { position: absolute; left: 0; top: 0; bottom: 0; width: 10px; background: linear-gradient(90deg, rgba(0,0,0,0.22) 0%, rgba(0,0,0,0.08) 40%, transparent 100%); z-index: 2; pointer-events: none; }
        .r-book-cover::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.0) 50%); opacity: 0; transition: opacity 0.35s; z-index: 3; pointer-events: none; border-radius: inherit; }
        .r-book:hover .r-book-cover::after { opacity: 1; }
        .r-book-read-badge {
            position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%) translateY(8px);
            z-index: 5; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);
            color: var(--gok-green-dark); font-size: 0.6rem; font-weight: 700;
            padding: 5px 14px; border-radius: 6px; opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none; text-transform: uppercase; letter-spacing: 0.06em;
            border: 1px solid rgba(0, 107, 63, 0.1); white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .r-book:hover .r-book-read-badge { opacity: 1; transform: translateX(-50%) translateY(0); }

        .r-fake { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem 0.75rem; border-left: 3px solid rgba(0, 107, 63, 0.12); }
        .r-fake.pdf-bg { background: linear-gradient(160deg, #fef2f2, #fff5f5, #ffffff); }
        .r-fake.word-bg { background: linear-gradient(160deg, #eff6ff, #f0f4ff, #ffffff); }
        .r-fake.def-bg { background: linear-gradient(160deg, var(--gok-gray-50), #ffffff, #ffffff); }
        .r-fake-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; margin-bottom: 0.6rem; box-shadow: 0 4px 14px -4px rgba(0,0,0,0.18); }
        .r-fake.pdf-bg .r-fake-icon { background: linear-gradient(135deg, var(--gok-red), var(--gok-red-dark)); color: white; }
        .r-fake.word-bg .r-fake-icon { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; }
        .r-fake.def-bg .r-fake-icon { background: linear-gradient(135deg, var(--gok-green), var(--gok-green-dark)); color: white; }
        .r-fake-title { font-size: 0.6rem; font-weight: 700; color: var(--gok-black-light); text-align: center; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .r-book-info { padding: 0.6rem 0.1rem 0; flex: 1; display: flex; flex-direction: column; min-height: 0; }
        .r-book-title { font-size: 0.7rem; font-weight: 700; color: var(--gok-black); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.2rem; }
        .r-book-author { font-size: 0.62rem; color: var(--gok-gray-400); font-weight: 500; margin-bottom: 0.15rem; }
        .r-book-meta { font-size: 0.55rem; color: var(--gok-gray-300); display: flex; align-items: center; gap: 4px; }

        .r-read-btn {
            margin-top: 0.55rem; width: 100%; padding: 7px 0; border: none; border-radius: 7px;
            background: linear-gradient(135deg, var(--gok-green) 0%, var(--gok-green-dark) 100%);
            color: white; font-size: 0.62rem; font-weight: 700; font-family: 'Inter', sans-serif;
            letter-spacing: 0.05em; text-transform: uppercase; cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; align-items: center; justify-content: center; gap: 5px;
            position: relative; overflow: hidden; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 107, 63, 0.2);
        }
        .r-read-btn::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%); pointer-events: none; }
        .r-read-btn i { font-size: 0.58rem; transition: transform 0.25s; }
        .r-read-btn:hover { background: linear-gradient(135deg, var(--gok-green-light) 0%, var(--gok-green) 100%); box-shadow: 0 4px 16px rgba(0, 107, 63, 0.3); transform: translateY(-1px); }
        .r-read-btn:hover i { transform: translateX(2px); }
        .r-read-btn:active { transform: translateY(0) scale(0.98); box-shadow: 0 1px 4px rgba(0, 107, 63, 0.2); }

        .r-file-badge { display: inline-flex; align-items: center; justify-content: center; padding: 1px 6px; border-radius: 3px; font-size: 0.5rem; font-weight: 800; letter-spacing: 0.04em; text-transform: uppercase; line-height: 1.6; }
        .r-file-badge.pdf { background: rgba(187, 37, 56, 0.08); color: var(--gok-red); }
        .r-file-badge.doc { background: rgba(37, 99, 235, 0.08); color: #2563eb; }
        .r-file-badge.def { background: rgba(0, 107, 63, 0.08); color: var(--gok-green); }

        /* ╔═══════════════════════════════════════════════╗
           ║  READER OVERLAY — WITH ZOOM CONTROLS         ║
           ╚═══════════════════════════════════════════════╝ */
        .r-overlay {
            position: fixed; inset: 0; z-index: 200;
            display: none; flex-direction: column;
            background: #FEFDFB;
            transition: background 0.3s;
        }
        .r-overlay.open { display: flex; }
        .r-overlay.dark-mode { background: var(--gok-black); }
        .r-overlay.sepia-mode { background: #F5F0E3; }

        /* ── Top Bar ── */
        .r-reader-bar {
            height: 52px; background: var(--gok-white); border-bottom: 2px solid var(--gok-green);
            display: flex; align-items: center; justify-content: space-between; padding: 0 1.25rem; flex-shrink: 0;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark-mode .r-reader-bar { background: #111; border-bottom-color: var(--gok-green-dark); }
        .sepia-mode .r-reader-bar { background: #EDE5D3; border-bottom-color: #8B7355; }

        .r-reader-left { display: flex; align-items: center; gap: 0.75rem; }
        .r-reader-back {
            background: none; border: none; color: var(--gok-gray-500); cursor: pointer;
            font-size: 0.76rem; font-weight: 600; font-family: 'Inter', sans-serif;
            display: flex; align-items: center; gap: 6px; transition: color 0.2s; padding: 0;
        }
        .r-reader-back:hover { color: var(--gok-green); }
        .r-reader-title {
            font-size: 0.8rem; font-weight: 600; color: var(--gok-gray-600);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 320px;
            transition: color 0.3s;
        }
        .dark-mode .r-reader-title { color: #bbb; }
        .sepia-mode .r-reader-title { color: #5C4D3A; }

        /* ── Controls Area ── */
        .r-reader-controls { display: flex; align-items: center; gap: 0.35rem; }
        .r-ctrl-sep { width: 1px; height: 22px; background: var(--gok-gray-200); margin: 0 3px; flex-shrink: 0; }
        .dark-mode .r-ctrl-sep { background: #333; }
        .sepia-mode .r-ctrl-sep { background: #C9BDAA; }

        .r-ctrl-btn {
            width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--gok-gray-200);
            background: white; color: var(--gok-gray-500); cursor: pointer;
            display: flex; align-items: center; justify-content: center; font-size: 0.75rem; transition: all 0.2s;
            flex-shrink: 0;
        }
        .r-ctrl-btn:hover { background: var(--gok-gray-50); color: var(--gok-green); border-color: var(--gok-green); }
        .r-ctrl-btn.active { background: var(--gok-green); color: white; border-color: var(--gok-green); }
        .dark-mode .r-ctrl-btn { background: #1a1a1a; border-color: #333; color: #888; }
        .dark-mode .r-ctrl-btn:hover { background: #252525; color: #6ee7b7; border-color: #6ee7b7; }
        .dark-mode .r-ctrl-btn.active { background: var(--gok-green-dark); color: white; border-color: var(--gok-green-dark); }
        .sepia-mode .r-ctrl-btn { background: #EDE5D3; border-color: #C9BDAA; color: #8B7355; }
        .sepia-mode .r-ctrl-btn:hover { background: #E5DCC8; color: #6B5D3E; border-color: #6B5D3E; }
        .sepia-mode .r-ctrl-btn.active { background: #6B5D3E; color: white; border-color: #6B5D3E; }

        .r-font-select {
            background: white; border: 1px solid var(--gok-gray-200); border-radius: 8px;
            color: var(--gok-gray-600); font-size: 0.7rem; padding: 6px 8px;
            font-family: 'Inter', sans-serif; cursor: pointer; outline: none; max-width: 110px;
        }
        .r-font-select:focus { border-color: var(--gok-green); }
        .dark-mode .r-font-select { background: #1a1a1a; border-color: #333; color: #aaa; }
        .sepia-mode .r-font-select { background: #EDE5D3; border-color: #C9BDAA; color: #5C4D3A; }

        /* ── ZOOM WIDGET ── */
        .r-zoom-widget {
            display: flex; align-items: center; gap: 0; background: var(--gok-gray-50);
            border-radius: 8px; border: 1px solid var(--gok-gray-200); overflow: hidden;
            flex-shrink: 0; transition: background 0.3s, border-color 0.3s;
        }
        .dark-mode .r-zoom-widget { background: #1a1a1a; border-color: #333; }
        .sepia-mode .r-zoom-widget { background: #E5DCC8; border-color: #C9BDAA; }

        .r-zoom-btn {
            width: 34px; height: 34px; border: none; background: transparent;
            color: var(--gok-gray-500); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem; transition: all 0.15s; flex-shrink: 0;
        }
        .r-zoom-btn:hover { color: var(--gok-green); background: rgba(0, 107, 63, 0.06); }
        .r-zoom-btn:active { transform: scale(0.9); }
        .r-zoom-btn.disabled { color: var(--gok-gray-300); cursor: not-allowed; pointer-events: none; }
        .dark-mode .r-zoom-btn { color: #666; }
        .dark-mode .r-zoom-btn:hover { color: #6ee7b7; background: rgba(110, 231, 183, 0.06); }
        .dark-mode .r-zoom-btn.disabled { color: #333; }
        .sepia-mode .r-zoom-btn { color: #8B7355; }
        .sepia-mode .r-zoom-btn:hover { color: #4A3F2E; background: rgba(74, 63, 46, 0.06); }

        .r-zoom-value {
            min-width: 46px; text-align: center; font-size: 0.72rem; font-weight: 700;
            color: var(--gok-gray-700); font-family: 'Inter', sans-serif;
            border-left: 1px solid var(--gok-gray-200); border-right: 1px solid var(--gok-gray-200);
            padding: 0 4px; line-height: 34px; cursor: pointer; position: relative;
            transition: color 0.3s, border-color 0.3s;
        }
        .dark-mode .r-zoom-value { color: #ccc; border-color: #333; }
        .sepia-mode .r-zoom-value { color: #5C4D3A; border-color: #C9BDAA; }

        .r-zoom-dropdown {
            position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            background: white; border: 1px solid var(--gok-gray-200); border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); padding: 4px;
            min-width: 80px; z-index: 20; display: none;
            margin-top: 4px;
        }
        .r-zoom-dropdown.open { display: block; }
        .dark-mode .r-zoom-dropdown { background: #1a1a1a; border-color: #333; box-shadow: 0 8px 30px rgba(0,0,0,0.4); }
        .sepia-mode .r-zoom-dropdown { background: #EDE5D3; border-color: #C9BDAA; }

        .r-zoom-option {
            display: block; width: 100%; text-align: center; padding: 6px 12px;
            border: none; background: transparent; color: var(--gok-gray-600);
            font-size: 0.72rem; font-weight: 500; cursor: pointer;
            border-radius: 6px; font-family: 'Inter', sans-serif; transition: all 0.1s;
        }
        .r-zoom-option:hover { background: rgba(0, 107, 63, 0.06); color: var(--gok-green-dark); }
        .r-zoom-option.active { background: rgba(0, 107, 63, 0.1); color: var(--gok-green-dark); font-weight: 700; }
        .dark-mode .r-zoom-option { color: #aaa; }
        .dark-mode .r-zoom-option:hover { background: rgba(110, 231, 183, 0.08); color: #6ee7b7; }
        .dark-mode .r-zoom-option.active { background: rgba(110, 231, 183, 0.12); color: #6ee7b7; }
        .sepia-mode .r-zoom-option { color: #5C4D3A; }
        .sepia-mode .r-zoom-option:hover { background: rgba(107, 93, 62, 0.08); color: #3C3226; }
        .sepia-mode .r-zoom-option.active { background: rgba(107, 93, 62, 0.12); color: #3C3226; }

        /* ── Reader Body ── */
        .r-reader-body { flex: 1; overflow: hidden; position: relative; }
        .r-reader-page {
            position: absolute; inset: 0; overflow-y: auto; padding: 2.5rem 0;
            scrollbar-width: thin; scrollbar-color: var(--gok-gray-200) transparent;
            transition: background 0.3s;
        }
        .r-reader-page::-webkit-scrollbar { width: 6px; }
        .r-reader-page::-webkit-scrollbar-track { background: transparent; }
        .r-reader-page::-webkit-scrollbar-thumb { background: var(--gok-gray-200); border-radius: 3px; }
        .dark-mode .r-reader-page::-webkit-scrollbar-thumb { background: #333; }
        .sepia-mode .r-reader-page::-webkit-scrollbar-thumb { background: #C9BDAA; }

        .r-page-inner { max-width: 700px; margin: 0 auto; padding: 0 2rem; transition: max-width 0.3s; }

        /* ── Text Styles ── */
        .r-chapter-title {
            font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;
            line-height: 1.25; margin-bottom: 0.5rem; letter-spacing: -0.01em;
            transition: color 0.3s;
        }
        .dark-mode .r-chapter-title { color: var(--gok-white); }
        .sepia-mode .r-chapter-title { color: #2C2218; }

        .r-chapter-sub {
            font-size: 0.85rem; font-weight: 400; margin-bottom: 2.5rem;
            padding-bottom: 2rem; border-bottom: 1px solid var(--gok-gray-200);
            transition: color 0.3s, border-color 0.3s;
        }
        .dark-mode .r-chapter-sub { color: rgba(255,255,255,0.4); border-bottom-color: #333; }
        .sepia-mode .r-chapter-sub { color: #8B7355; border-bottom-color: #C9BDAA; }

        .r-reader-text { line-height: 1.9; transition: color 0.3s, font-size 0.2s, line-height 0.2s; }
        .dark-mode .r-reader-text { color: #d4d4d4; }
        .sepia-mode .r-reader-text { color: #3C3226; }

        .r-reader-text p { margin-bottom: 1.2em; text-indent: 1.5em; }
        .r-reader-text p:first-child { text-indent: 0; }
        .r-reader-text p:first-child::first-letter {
            font-size: 3.2em; float: left; line-height: 0.8; margin-right: 0.08em;
            font-weight: 700; color: var(--gok-green); font-family: 'Playfair Display', serif;
            transition: color 0.3s;
        }
        .dark-mode .r-reader-text p:first-child::first-letter { color: #6ee7b7; }
        .sepia-mode .r-reader-text p:first-child::first-letter { color: #6B5D3E; }

        .r-reader-text h2 { font-size: 1.3em; font-weight: 700; margin: 1.5em 0 0.5em; text-indent: 0; color: var(--gok-green-dark); transition: color 0.3s; }
        .dark-mode .r-reader-text h2 { color: #6ee7b7; }
        .sepia-mode .r-reader-text h2 { color: #6B5D3E; }

        /* ── Bottom Footer ── */
        .r-reader-footer {
            height: 40px; background: var(--gok-white); border-top: 2px solid var(--gok-green);
            display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; flex-shrink: 0;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark-mode .r-reader-footer { background: #111; border-top-color: var(--gok-green-dark); }
        .sepia-mode .r-reader-footer { background: #EDE5D3; border-top-color: #8B7355; }

        .r-page-info { display: flex; align-items: center; gap: 0.75rem; }
        .r-page-indicator { font-size: 0.68rem; color: var(--gok-gray-400); font-weight: 500; transition: color 0.3s; }
        .dark-mode .r-page-indicator { color: #666; }
        .sepia-mode .r-page-indicator { color: #8B7355; }

        .r-progress-bar { width: 200px; height: 3px; background: var(--gok-gray-100); border-radius: 2px; overflow: hidden; cursor: pointer; transition: background 0.3s; }
        .r-progress-fill { height: 100%; background: var(--gok-green); border-radius: 2px; transition: width 0.15s; width: 0%; }
        .dark-mode .r-progress-bar { background: #333; }
        .sepia-mode .r-progress-bar { background: #C9BDAA; }

        .r-watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 4rem; font-weight: 900; color: rgba(0, 0, 0, 0.012); pointer-events: none; z-index: 210; white-space: nowrap; letter-spacing: 0.15em; text-transform: uppercase; }

        /* PDF canvases */
        .pdf-page-canvas {
            display: block; width: 100%; max-width: 680px;
            margin: 0 auto 1.5rem; border-radius: 4px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08); background: white;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top center;
        }
        .dark-mode .pdf-page-canvas { box-shadow: 0 2px 16px rgba(0,0,0,0.3); }
        .pdf-render-progress { text-align: center; padding: 1.5rem 0 0.5rem; color: var(--gok-gray-400); font-size: 0.78rem; font-weight: 500; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; }
        .pdf-render-bar { width: 180px; height: 3px; background: var(--gok-gray-100); border-radius: 2px; overflow: hidden; }
        .pdf-render-bar-fill { height: 100%; background: var(--gok-green); border-radius: 2px; transition: width 0.3s; width: 0%; }

        /* State messages */
        .r-reader-state { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh; gap: 1rem; text-align: center; padding: 2rem; }
        .r-reader-state-icon { width: 72px; height: 72px; border-radius: 20px; background: var(--gok-gray-50); display: flex; align-items: center; justify-content: center; }
        .r-reader-state-icon i { font-size: 1.8rem; color: var(--gok-gray-300); }
        .r-reader-state h2 { color: var(--gok-gray-600); font-size: 1.15rem; font-weight: 700; }
        .r-reader-state p { color: var(--gok-gray-400); font-size: 0.85rem; max-width: 440px; line-height: 1.65; }
        .r-reader-state-btn { margin-top: 0.5rem; padding: 10px 24px; background: var(--gok-green); color: white; border: none; border-radius: 10px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .r-reader-state-btn:hover { background: var(--gok-green-dark); }

        /* ═══ FOOTER ═══ */
        .r-footer { background: var(--gok-black); padding: 3rem 2rem 1.5rem; margin-top: 2rem; }
        .r-footer-inner { max-width: 1200px; margin: 0 auto; }
        .r-footer-grid { display: grid; grid-template-columns: 2.5fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 2rem; }
        .r-footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 0.75rem; }
        .r-footer-brand-icon { width: 32px; height: 32px; background: var(--gok-green); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; }
        .r-footer-brand-text { font-size: 0.95rem; font-weight: 800; color: var(--gok-gray-300); }
        .r-footer-desc { font-size: 0.78rem; color: var(--gok-gray-500); line-height: 1.7; max-width: 300px; }
        .r-footer-heading { font-size: 0.6rem; font-weight: 700; color: var(--gok-gray-500); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; }
        .r-footer-link { display: block; font-size: 0.78rem; color: var(--gok-gray-500); text-decoration: none; padding: 4px 0; transition: color 0.2s; }
        .r-footer-link:hover { color: #6ee7b7; }
        .r-footer-bottom { border-top: 1px solid rgba(255,255,255,0.06); padding-top: 1.25rem; display: flex; justify-content: space-between; font-size: 0.68rem; color: var(--gok-gray-500); }
        .r-footer-tricolor { display: flex; gap: 0; margin-bottom: 1.25rem; }
        .r-footer-tricolor span { height: 2px; width: 40px; }
        .r-footer-tricolor .t-black { background: var(--gok-gray-500); }
        .r-footer-tricolor .t-red { background: var(--gok-red); }
        .r-footer-tricolor .t-green { background: var(--gok-green); }

        @media (max-width: 1200px) { .r-grid { grid-template-columns: repeat(4, 1fr); gap: 1.1rem; } }
        @media (max-width: 900px) { .r-grid { grid-template-columns: repeat(3, 1fr); gap: 1rem; } }
        @media (max-width: 768px) {
            .r-nav-center { display: none; } .r-nav-search { display: none; }
            .r-hero { padding: 3.5rem 1.5rem 2.5rem; } .r-hero h1 { font-size: 2rem; }
            .r-hero-stats { gap: 1.5rem; } .r-hero-stat-val { font-size: 1.3rem; }
            .r-features-grid { grid-template-columns: 1fr; }
            .r-grid { grid-template-columns: repeat(2, 1fr); gap: 0.85rem; }
            .r-shelf { padding: 2rem 1rem; }
            .r-reader-title { max-width: 140px; font-size: 0.7rem; }
            .r-font-select { display: none; }
            .r-page-inner { padding: 0 1.25rem; }
            .r-chapter-title { font-size: 1.5rem; }
            .r-footer-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            .r-footer-bottom { flex-direction: column; gap: 0.5rem; text-align: center; }
        }
    </style>
</head>
<body>

<div class="gok-top-bar"></div>

<nav class="r-nav">
    <a href="{{ route('reader.portal') }}" class="r-nav-brand">
        <div class="r-nav-coat"><i class="fas fa-landmark"></i></div>
        <div class="r-nav-text-group"><span class="r-nav-name">Digital Library</span><span class="r-nav-sub">Republic of Kenya</span></div>
    </a>
    <div class="r-nav-center">
        <a href="{{ route('reader.portal') }}" class="r-nav-tab active"><i class="fas fa-book-open" style="margin-right:4px;font-size:0.7rem;"></i> Browse All</a>
        {{-- <a href="{{ route('documents.index', ['type' => 'book']) }}" class="r-nav-tab">Books</a>
        <a href="{{ route('documents.index', ['type' => 'thesis']) }}" class="r-nav-tab">Theses</a> --}}
    </div>
    <div class="r-nav-right">
        <div class="r-nav-search"><i class="fas fa-search"></i><input type="text" placeholder="Search titles..." id="shelfSearch" oninput="filterShelf()"></div>
        <a href="{{ route('login') }}" class="r-admin-btn"><i class="fas fa-lock" style="font-size:0.6rem;"></i> Admin</a>
    </div>
</nav>

<section class="r-hero">
    <div class="r-hero-inner">
        <div class="r-hero-crest"><i class="fas fa-landmark"></i></div>
        <div class="r-hero-badge"><i class="fas fa-shield-halved"></i> Official Digital Library Portal</div>
        <h1>Republic of <span class="highlight">Kenya</span></h1>
        <p class="r-hero-motto">"Read, Learn, Grow — For a Prosperous Nation"</p>
        <p>Browse our national collection of publications, research papers, and institutional documents — available to read freely in your browser.</p>
        <div class="r-hero-stats">
            <div class="r-hero-stat"><div class="r-hero-stat-val">{{ $documents->total() }}</div><div class="r-hero-stat-label">Documents</div></div>
            <div class="r-hero-stat"><div class="r-hero-stat-val">{{ $categories->count() }}</div><div class="r-hero-stat-label">Categories</div></div>
            <div class="r-hero-stat"><div class="hero-stat-val"><span class="accent">Free</span></div><div class="r-hero-stat-label">Access</div></div>
        </div>
        <div class="r-hero-tricolor"><span class="t-black"></span><span class="t-red"></span><span class="t-green"></span></div>
    </div>
</section>

<div class="r-features">
    <div class="r-features-grid">
        <div class="r-feature-card"><div class="r-feature-icon"><i class="fas fa-book-open-reader"></i></div><div class="r-feature-title">Read Instantly</div><div class="r-feature-desc">Open and read any document directly in your browser without downloading.</div></div>
        <div class="r-feature-card"><div class="r-feature-icon"><i class="fas fa-shield-halved"></i></div><div class="r-feature-title">Protected Content</div><div class="r-feature-desc">All materials are protected against unauthorized copying and distribution.</div></div>
        <div class="r-feature-card"><div class="r-feature-icon"><i class="fas fa-users"></i></div><div class="r-feature-title">Public Access</div><div class="r-feature-desc">No registration required. Read freely as a citizen right to information.</div></div>
    </div>
</div>

<div class="r-shelf">
    <div class="r-shelf-header">
        <div class="r-shelf-title"><span class="gok-bar"></span> National Collection <span class="r-shelf-count" id="shelfCount">{{ $documents->count() }} titles</span></div>
    </div>
    <div class="r-grid" id="bookGrid">
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
    </div>
</div>

<footer class="r-footer">
    <div class="r-footer-inner">
        <div class="r-footer-tricolor"><span class="t-black"></span><span class="t-red"></span><span class="t-green"></span></div>
        <div class="r-footer-grid">
            <div><div class="r-footer-brand"><div class="r-footer-brand-icon"><i class="fas fa-landmark"></i></div><span class="r-footer-brand-text">Digital Library</span></div><p class="r-footer-desc">An official digital repository of the Republic of Kenya. All content is for in-browser reading only.</p></div>
            <div><div class="r-footer-heading">Browse</div><a href="{{ route('reader.portal') }}" class="r-footer-link">All Documents</a><a href="{{ route('documents.index', ['type' => 'book']) }}" class="r-footer-link">Books</a><a href="{{ route('documents.index', ['type' => 'thesis']) }}" class="r-footer-link">Theses</a></div>
            <div><div class="r-footer-heading">Government</div><a href="https://www.go.ke" class="r-footer-link" target="_blank">GoK Official</a><a href="#" class="r-footer-link">Ministry Portal</a><a href="#" class="r-footer-link">About</a></div>
            <div><div class="r-footer-heading">Legal</div><a href="#" class="r-footer-link">Copyright Policy</a><a href="#" class="r-footer-link">Privacy Policy</a><a href="#" class="r-footer-link">Terms of Use</a></div>
        </div>
        <div class="r-footer-bottom"><span>&copy; {{ date('Y') }} Republic of Kenya — Digital Library. All rights reserved.</span><span>Content protected under Kenyan intellectual property law.</span></div>
    </div>
</footer>

<!-- ═══ READER OVERLAY ═══ -->
<div class="r-overlay" id="readerOverlay">
    <div class="r-watermark">REPUBLIC OF KENYA</div>

    <div class="r-reader-bar">
        <div class="r-reader-left">
            <button class="r-reader-back" onclick="closeReader()"><i class="fas fa-arrow-left"></i> Back</button>
            <span class="r-reader-title" id="readerTitle">Book Title</span>
        </div>
        <div class="r-reader-controls">
            <!-- ZOOM: minus | percentage | plus -->
            <div class="r-zoom-widget" id="zoomWidget">
                <button class="r-zoom-btn" id="zoomOutBtn" onclick="zoomOut()" title="Zoom out"><i class="fas fa-minus"></i></button>
                <div class="r-zoom-value" id="zoomValue" onclick="toggleZoomDropdown()" title="Click to select zoom level">
                    100%
                    <div class="r-zoom-dropdown" id="zoomDropdown"></div>
                </div>
                <button class="r-zoom-btn" id="zoomInBtn" onclick="zoomIn()" title="Zoom in"><i class="fas fa-plus"></i></button>
            </div>

            <div class="r-ctrl-sep"></div>

            <!-- FONT family (text mode only) -->
            <select class="r-font-select" id="fontSelect" onchange="changeFont(this.value)">
                <option value="'Merriweather', serif">Merriweather</option>
                <option value="'Lora', serif">Lora</option>
                <option value="'Playfair Display', serif">Playfair</option>
                <option value="'Inter', sans-serif">Inter</option>
            </select>

            <div class="r-ctrl-sep"></div>

            <!-- Theme buttons -->
            <button class="r-ctrl-btn active" id="btnLight" onclick="setTheme('light')" title="Light"><i class="fas fa-sun"></i></button>
            <button class="r-ctrl-btn" id="btnDark" onclick="setTheme('dark')" title="Dark"><i class="fas fa-moon"></i></button>
            <button class="r-ctrl-btn" id="btnSepia" onclick="setTheme('sepia')" title="Sepia"><i class="fas fa-scroll"></i></button>

            <div class="r-ctrl-sep"></div>

            <button class="r-ctrl-btn" onclick="toggleFullscreen()" title="Fullscreen"><i class="fas fa-expand"></i></button>
        </div>
    </div>

    <div class="r-reader-body">
        <div class="r-reader-page" id="readerPage">
            <div class="r-page-inner reader-content" id="readerContent"></div>
        </div>
    </div>

    <div class="r-reader-footer">
        <div class="r-page-info">
            <span class="r-page-indicator" id="pageIndicator">Scroll to read</span>
        </div>
        <div class="r-progress-bar" id="progressBar" onclick="jumpToProgress(event)">
            <div class="r-progress-fill" id="progressFill"></div>
        </div>
        <div class="r-page-info">
            <span class="r-page-indicator" id="zoomFooterLabel">100%</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('keydown', e => {
        if (e.key === 'PrintScreen' || (e.ctrlKey && e.key === 'p') || (e.ctrlKey && e.key === 's') || (e.metaKey && e.key === 's')) e.preventDefault();
    });
    document.addEventListener('copy', e => e.preventDefault());

    if (typeof pdfjsLib !== 'undefined') pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    function filterShelf() {
        const q = document.getElementById('shelfSearch').value.toLowerCase();
        const books = document.querySelectorAll('.r-book');
        let visible = 0;
        books.forEach(b => { const m = b.dataset.title.includes(q); b.style.display = m ? '' : 'none'; if (m) visible++; });
        document.getElementById('shelfCount').textContent = visible + ' title' + (visible !== 1 ? 's' : '');
    }

    /* ═══════════════════════════════════════
       READER & ZOOM STATE
    ═══════════════════════════════════════ */
    let currentFontSize = 18;
    let currentTheme = 'light';
    let currentReaderMode = 'text'; // 'text' | 'pdf'

    const ZOOM_LEVELS = [50, 75, 100, 125, 150, 175, 200, 250, 300];
    let zoomLevel = 100; // percentage
    const ZOOM_STEP = 25;

    function escapeHtml(s) { if (!s) return ''; const d = document.createElement('div'); d.appendChild(document.createTextNode(s)); return d.innerHTML; }

    function showLoading(msg) {
        document.getElementById('readerContent').innerHTML = `<div class="r-reader-state"><div style="width:40px;height:40px;border:3px solid var(--gok-gray-200);border-top-color:var(--gok-green);border-radius:50%;animation:spin 0.8s linear infinite;"></div><p style="color:var(--gok-gray-400);font-size:0.85rem;margin:0;">${msg || 'Loading...'}</p></div>`;
    }

    function showError(title, msg) {
        document.getElementById('readerContent').innerHTML = `<div class="r-reader-state"><div class="r-reader-state-icon"><i class="fas fa-exclamation-triangle" style="color:var(--gok-red);"></i></div><h2>${title}</h2><p>${msg}</p><button class="r-reader-state-btn" onclick="closeReader()"><i class="fas fa-arrow-left" style="font-size:0.75rem;"></i> Go Back</button></div>`;
    }

    /* ═══════════════════════════════════════
       ZOOM CONTROLS
    ═══════════════════════════════════════ */
    function zoomIn() {
        setZoom(Math.min(300, zoomLevel + ZOOM_STEP));
    }

    function zoomOut() {
        setZoom(Math.max(50, zoomLevel - ZOOM_STEP));
    }

    function setZoom(level) {
        zoomLevel = level;
        updateZoomUI();
        applyZoom();
    }

    function updateZoomUI() {
        const val = document.getElementById('zoomValue');
        const footer = document.getElementById('zoomFooterLabel');
        const inBtn = document.getElementById('zoomOutBtn');
        const outBtn = document.getElementById('zoomInBtn');

        // Update displayed percentage (strip trailing zeros)
        const display = zoomLevel % 100 === 0 ? zoomLevel + '%' : zoomLevel.toFixed(0) + '%';
        val.childNodes[0].textContent = display + '\n        ';
        footer.textContent = display;

        // Disable buttons at limits
        outBtn.classList.toggle('disabled', zoomLevel <= 50);
        inBtn.classList.toggle('disabled', zoomLevel >= 300);

        // Highlight active dropdown option
        document.querySelectorAll('.r-zoom-option').forEach(opt => {
            opt.classList.toggle('active', parseInt(opt.dataset.zoom) === zoomLevel);
        });
    }

    function applyZoom() {
        const scale = zoomLevel / 100;

        if (currentReaderMode === 'pdf') {
            // Scale all PDF canvases
            document.querySelectorAll('.pdf-page-canvas').forEach(canvas => {
                canvas.style.transform = `scale(${scale})`;
                // Adjust margin to prevent overlap — the canvas visual size changes with scale
                const h = canvas.height * scale;
                canvas.style.marginBottom = Math.max(8, 24 * scale) + 'px';
            });
            // Adjust container width so scaled canvases don't clip
            const inner = document.querySelector('.r-page-inner');
            if (inner) {
                inner.style.maxWidth = (700 * scale) + 'px';
            }
        } else {
            // Text mode: scale font size proportionally
            const baseSize = 18;
            const newSize = Math.max(10, Math.min(48, Math.round(baseSize * scale)));
            currentFontSize = newSize;
            const textEl = document.querySelector('.r-reader-text');
            if (textEl) textEl.style.fontSize = newSize + 'px';
        }
    }

    function toggleZoomDropdown() {
        const dd = document.getElementById('zoomDropdown');
        dd.classList.toggle('open');
    }

    function buildZoomDropdown() {
        const dd = document.getElementById('zoomDropdown');
        dd.innerHTML = ZOOM_LEVELS.map(z =>
            `<button class="r-zoom-option${z === zoomLevel ? ' active' : ''}" data-zoom="${z}" onclick="setZoom(${z}); toggleZoomDropdown();">${z}%</button>`
        ).join('');
    }

    // Close dropdown on outside click
    document.addEventListener('click', e => {
        const dd = document.getElementById('zoomDropdown');
        const val = document.getElementById('zoomValue');
        if (dd.classList.contains('open') && !val.contains(e.target)) {
            dd.classList.remove('open');
        }
    });

    /* ═══════════════════════════════════════
       OPEN READER
    ═══════════════════════════════════════ */
    function openReaderFromCard(cardEl) {
        if (!cardEl) return;
        const fileUrl = cardEl.dataset.fileUrl;
        const title = cardEl.querySelector('.r-book-title')?.textContent || 'Untitled';
        const author = cardEl.dataset.author || 'Unknown';
        const type = (cardEl.dataset.fileType || '').toLowerCase();

        if (!fileUrl) { showError('File Not Found', 'No file URL available.'); return; }

        // Reset zoom to 100%
        zoomLevel = 100;
        currentFontSize = 18;

        document.getElementById('readerTitle').textContent = title;
        document.getElementById('readerContent').innerHTML = '';

        const overlay = document.getElementById('readerOverlay');
        overlay.classList.add('open');
        overlay.classList.remove('dark-mode', 'sepia-mode');
        currentTheme = 'light';
        document.querySelectorAll('#btnLight,#btnDark,#btnSepia').forEach(b => b.classList.remove('active'));
        document.getElementById('btnLight').classList.add('active');

        document.body.style.overflow = 'hidden';
        document.getElementById('readerPage').scrollTop = 0;
        document.getElementById('progressFill').style.width = '0%';
        document.getElementById('pageIndicator').textContent = 'Scroll to read';

        // Reset content width
        const inner = document.querySelector('.r-page-inner');
        if (inner) inner.style.maxWidth = '700px';

        // Show/hide font select based on mode
        const isImage = ['jpg','jpeg','png','gif','webp'].includes(type);
        document.getElementById('fontSelect').style.display = (type === 'pdf' || isImage) ? 'none' : '';

        buildZoomDropdown();
        updateZoomUI();

        switch (type) {
            case 'pdf':
                if (typeof pdfjsLib === 'undefined') { showError('Library Not Available', 'PDF.js could not be loaded.'); return; }
                currentReaderMode = 'pdf'; loadPdf(fileUrl, title, author); break;
            case 'doc': case 'docx':
                if (typeof mammoth === 'undefined') { showError('Library Not Available', 'Document converter could not be loaded.'); return; }
                currentReaderMode = 'text'; loadDocx(fileUrl, title, author); break;
            case 'txt':
                currentReaderMode = 'text'; loadTextFile(fileUrl, title, author); break;
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'webp':
                currentReaderMode = 'pdf'; loadImage(fileUrl, title, author); break;
            default:
                currentReaderMode = 'text'; showError('Unsupported Format', `.${type || '?'} files are not supported.`);
        }
    }

    /* ═══════════════════════════════════════
       PDF LOADER
    ═══════════════════════════════════════ */
    async function loadPdf(url, title, author) {
        const content = document.getElementById('readerContent');
        showLoading('Loading PDF...');
        try {
            const pdf = await pdfjsLib.getDocument(url).promise;
            content.innerHTML = `
                <h1 class="r-chapter-title">${escapeHtml(title)}</h1>
                <div class="r-chapter-sub">By ${escapeHtml(author)} &middot; PDF &middot; ${pdf.numPages} page${pdf.numPages !== 1 ? 's' : ''}</div>
                <div id="pdfPageContainer"></div>
                <div class="pdf-render-progress" id="pdfProgress">
                    <div class="pdf-render-bar"><div class="pdf-render-bar-fill" id="pdfBarFill"></div></div>
                    <span id="pdfProgressText">Rendering page 1 of ${pdf.numPages}...</span>
                </div>`;
            const container = document.getElementById('pdfPageContainer');
            const barFill = document.getElementById('pdfBarFill');
            const progressText = document.getElementById('pdfProgressText');

            for (let i = 1; i <= pdf.numPages; i++) {
                const page = await pdf.getPage(i);
                const vp0 = page.getViewport({ scale: 1 });
                const scale = 680 / vp0.width;
                const vp = page.getViewport({ scale });
                const canvas = document.createElement('canvas');
                canvas.width = Math.floor(vp.width);
                canvas.height = Math.floor(vp.height);
                canvas.className = 'pdf-page-canvas';
                await page.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise;
                container.appendChild(canvas);
                barFill.style.width = Math.round(i / pdf.numPages * 100) + '%';
                progressText.textContent = `Rendering page ${i} of ${pdf.numPages}...`;
            }
            document.getElementById('pdfProgress').remove();
            applyZoom();
        } catch (err) {
            console.error(err);
            if (err.name === 'PasswordException') showError('Password Protected', 'This PDF is password-protected.');
            else if (err instanceof TypeError) showError('Network Error', 'Could not fetch the file. Check CORS settings if using S3.');
            else showError('Failed to Load PDF', 'Could not load or render this PDF.');
        }
    }

    /* ═══════════════════════════════════════
       DOCX LOADER
    ═══════════════════════════════════════ */
    async function loadDocx(url, title, author) {
        showLoading('Loading document...');
        try {
            const res = await fetch(url); if (!res.ok) throw new Error(res.status);
            const result = await mammoth.convertToHtml({ arrayBuffer: await res.arrayBuffer() });
            let html = result.value;
            if (!html || html.trim().length < 10) { showError('Empty Document', 'This document contains no extractable text.'); return; }
            html = html.replace(/(?:<br\s*\/?>\s*)+(?=<\/?)/gi, '</p><p>');
            if (!html.startsWith('<p') && !html.startsWith('<h') && !html.startsWith('<div')) html = '<p>' + html + '</p>';
            document.getElementById('readerContent').innerHTML = `
                <h1 class="r-chapter-title">${escapeHtml(title)}</h1>
                <div class="r-chapter-sub">By ${escapeHtml(author)} &middot; Word Document &middot; Scrollable</div>
                <div class="r-reader-text" style="font-size:${currentFontSize}px;">${html}</div>`;
            applyZoom();
        } catch (err) {
            console.error(err);
            if (err instanceof TypeError) showError('Network Error', 'Could not fetch the file. Check CORS settings.');
            else showError('Failed to Load', 'Could not convert this document.');
        }
    }

    /* ═══════════════════════════════════════
       TEXT LOADER
    ═══════════════════════════════════════ */
    async function loadTextFile(url, title, author) {
        showLoading('Loading text...');
        try {
            const res = await fetch(url); if (!res.ok) throw new Error(res.status);
            const text = await res.text();
            if (!text || text.trim().length < 5) { showError('Empty File', 'This file is empty.'); return; }
            const html = text.split(/\n\s*\n/).map(b => b.trim()).filter(b => b).map(b => '<p>' + b.split(/\n/).map(l => l.trim()).join(' ') + '</p>').join('');
            document.getElementById('readerContent').innerHTML = `
                <h1 class="r-chapter-title">${escapeHtml(title)}</h1>
                <div class="r-chapter-sub">By ${escapeHtml(author)} &middot; Text File &middot; Scrollable</div>
                <div class="r-reader-text" style="font-size:${currentFontSize}px;">${html}</div>`;
            applyZoom();
        } catch (err) { showError('Failed to Load', 'Could not load this text file.'); }
    }

    /* ═══════════════════════════════════════
       IMAGE LOADER
    ═══════════════════════════════════════ */
    function loadImage(url, title, author) {
        document.getElementById('readerContent').innerHTML = `
            <h1 class="r-chapter-title">${escapeHtml(title)}</h1>
            <div class="r-chapter-sub">By ${escapeHtml(author)} &middot; Image</div>
            <div style="text-align:center;padding:1rem 0;">
                <img src="${escapeHtml(url)}" alt="${escapeHtml(title)}" style="max-width:100%;border-radius:4px;box-shadow:0 2px 20px rgba(0,0,0,0.08);transition:transform 0.25s;transform-origin:top center;" onerror="this.outerHTML='<p style=\\'color:var(--gok-gray-400);padding:3rem 0;\\'>Image could not be loaded.</p>'" />
            </div>`;
        applyZoom();
    }

    /* ═══════════════════════════════════════
       READER CONTROLS
    ═══════════════════════════════════════ */
    function closeReader() {
        document.getElementById('readerOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function changeFont(f) {
        const el = document.querySelector('.r-reader-text');
        if (el) el.style.fontFamily = f;
    }

    function setTheme(theme) {
        currentTheme = theme;
        const overlay = document.getElementById('readerOverlay');
        overlay.classList.remove('dark-mode', 'sepia-mode');
        if (theme !== 'light') overlay.classList.add(theme + '-mode');
        document.querySelectorAll('#btnLight,#btnDark,#btnSepia').forEach(b => b.classList.remove('active'));
        document.getElementById('btn' + theme.charAt(0).toUpperCase() + theme.slice(1)).classList.add('active');
    }

    function toggleFullscreen() {
        if (!document.fullscreenElement) document.getElementById('readerOverlay').requestFullscreen().catch(() => {});
        else document.exitFullscreen();
    }

    function jumpToProgress(e) {
        const bar = document.getElementById('progressBar');
        const scroll = document.getElementById('readerPage');
        const pct = (e.clientX - bar.getBoundingClientRect().left) / bar.offsetWidth;
        scroll.scrollTop = pct * (scroll.scrollHeight - scroll.clientHeight);
    }

    /* ═══════════════════════════════════════
       SCROLL PROGRESS
    ═══════════════════════════════════════ */
    document.getElementById('readerPage')?.addEventListener('scroll', function() {
        const s = this, max = s.scrollHeight - s.clientHeight;
        if (max <= 0) return;
        const pct = Math.min(100, Math.max(0, (s.scrollTop / max) * 100));
        document.getElementById('progressFill').style.width = pct + '%';
        document.getElementById('pageIndicator').textContent = Math.round(pct) + '% read';
    });

    /* ═══════════════════════════════════════
       KEYBOARD SHORTCUTS
    ═══════════════════════════════════════ */
    document.addEventListener('keydown', e => {
        if (!document.getElementById('readerOverlay').classList.contains('open')) return;
        if (e.key === 'Escape') closeReader();
        // Ctrl + / Ctrl - for zoom
        if ((e.ctrlKey || e.metaKey) && (e.key === '=' || e.key === '+')) { e.preventDefault(); zoomIn(); }
        if ((e.ctrlKey || e.metaKey) && e.key === '-') { e.preventDefault(); zoomOut(); }
        if ((e.ctrlKey || e.metaKey) && e.key === '0') { e.preventDefault(); setZoom(100); }
        // Arrow keys to scroll
        if (e.key === 'ArrowUp' && !e.ctrlKey) { e.preventDefault(); document.getElementById('readerPage').scrollBy({ top: -60, behavior: 'smooth' }); }
        if (e.key === 'ArrowDown' && !e.ctrlKey) { e.preventDefault(); document.getElementById('readerPage').scrollBy({ top: 60, behavior: 'smooth' }); }
    });

    // Mouse wheel zoom for PDFs (ctrl+scroll)
    document.getElementById('readerPage')?.addEventListener('wheel', function(e) {
        if (!e.ctrlKey && !e.metaKey) return;
        if (currentReaderMode !== 'pdf') return;
        e.preventDefault();
        if (e.deltaY < 0) zoomIn(); else zoomOut();
    }, { passive: false });

    const spinStyle = document.createElement('style');
    spinStyle.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
    document.head.appendChild(spinStyle);
</script>

</body>
</html>