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
                    <div class="menu-header active" onclick="toggleMenu(this)"><span>My Workspace</span><i class="fas fa-chevron-down menu-arrow"></i></div>
                    <div class="submenu open">
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
                    <h1>Edit Document</h1>
                    <p>Update the details and file for this record.</p>
                    <div class="breadcrumb">
                        <a href="{{ route('documents.index') }}">Documents</a>
                        <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem;"></i></span>
                        <a href="{{ route('documents.manage') }}">Manage</a>
                        <span class="sep"><i class="fas fa-chevron-right" style="font-size:0.5rem;"></i></span>
                        <span class="current">Edit #{{ $document->id }}</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('documents.manage') }}" class="btn-action secondary"><i class="fas fa-arrow-left"></i> Back to Manage</a>
                    <a href="{{ route('documents.show', $document) }}" class="btn-action secondary"><i class="fas fa-eye"></i> View Document</a>
                </div>
            </div>

            <div class="scroll-area">
                <form method="POST"
                      action="{{ route('documents.update', $document) }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <!-- ═══ CURRENT PREVIEW CARD ═══ -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
                        <div style="display: flex; align-items: stretch;">
                            <!-- Thumbnail -->
                            <div style="width: 140px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-right: 1px solid #e2e8f0; padding: 1.5rem;">
                                @if($document->cover_image)
                                    <img src="{{ Storage::url($document->cover_image) }}" style="width: 80px; height: 110px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" alt="">
                                @elseif(in_array($document->file_type ?? '', ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ Storage::url($document->file_path) }}" style="width: 80px; height: 110px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" alt="">
                                @else
                                    <div style="width: 72px; height: 96px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;
                                        @if($document->file_type == 'pdf') background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #ef4444;
                                        @elseif(in_array($document->file_type ?? '', ['doc','docx'])) background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #3b82f6;
                                        @else background: #f1f5f9; color: #94a3b8; @endif
                                        border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        @if($document->file_type == 'pdf')<i class="fas fa-file-pdf"></i>
                                        @elseif(in_array($document->file_type ?? '', ['doc','docx']))<i class="fas fa-file-word"></i>
                                        @else<i class="fas fa-file-lines"></i>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <!-- Info -->
                            <div style="flex: 1; padding: 1.25rem 1.5rem; display: flex; flex-direction: column; justify-content: center;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                    <span class="type-badge {{ $document->document_type ?? 'record' }}" style="font-size: 0.6rem; padding: 3px 8px;">
                                        @if($document->document_type == 'book')<i class="fas fa-book"></i>
                                        @elseif($document->document_type == 'file')<i class="fas fa-photo-film"></i>
                                        @elseif($document->document_type == 'thesis')<i class="fas fa-graduation-cap"></i>
                                        @else<i class="fas fa-file-shield"></i>
                                        @endif
                                        {{ ucfirst($document->document_type ?? 'record') }}
                                    </span>
                                    @if($document->category)
                                        <span class="cat-badge" style="font-size: 0.65rem; padding: 3px 8px;">{{ $document->category->name }}</span>
                                    @endif
                                </div>
                                <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.02em;">{{ $document->title }}</h3>
                                <p style="font-size: 0.8rem; color: #94a3b8; margin: 0 0 8px; line-height: 1.5;">
                                    {{ $document->description ? Str::limit($document->description, 100) : 'No description provided.' }}
                                </p>
                                <div style="display: flex; gap: 1.25rem; font-size: 0.72rem; color: #94a3b8;">
                                    @if($document->author_creator)
                                        <span><i class="fas fa-user-pen" style="margin-right: 4px; color: #cbd5e1;"></i>{{ $document->author_creator }}</span>
                                    @endif
                                    @if($document->file_size)
                                        <span><i class="fas fa-hard-drive" style="margin-right: 4px; color: #cbd5e1;"></i>{{ number_format($document->file_size / 1048576, 2) }} MB</span>
                                    @endif
                                    <span><i class="fas fa-calendar" style="margin-right: 4px; color: #cbd5e1;"></i>{{ $document->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TWO COLUMN LAYOUT -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">

                        <!-- LEFT COLUMN -->
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">

                            <!-- Title Card -->
                            <div class="form-card">
                                <div class="form-card-header">
                                    <div class="form-card-icon" style="background: #ecfdf5; color: #059669;"><i class="fas fa-heading"></i></div>
                                    <div>
                                        <h3 class="form-card-title">Title</h3>
                                        <p class="form-card-subtitle">The main name for this document</p>
                                    </div>
                                </div>
                                <div class="form-card-body">
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $document->title) }}"
                                           required
                                           placeholder="Enter document title..."
                                           class="form-input @error('title') !border-red-400 !focus:border-red-400 !focus:ring-red-100 @enderror"
                                    >
                                    @error('title')
                                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Author Card -->
                            <div class="form-card">
                                <div class="form-card-header">
                                    <div class="form-card-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-user-pen"></i></div>
                                    <div>
                                        <h3 class="form-card-title">Author / Creator</h3>
                                        <p class="form-card-subtitle">Who created or contributed to this</p>
                                    </div>
                                </div>
                                <div class="form-card-body">
                                    <input type="text"
                                           id="author_creator"
                                           name="author_creator"
                                           value="{{ old('author_creator', $document->author_creator ?? '') }}"
                                           placeholder="e.g. Juan Dela Cruz"
                                           class="form-input @error('author_creator') !border-red-400 !focus:border-red-400 !focus:ring-red-100 @enderror"
                                    >
                                    @error('author_creator')
                                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Category Card -->
                            @if(isset($categories))
                            <div class="form-card">
                                <div class="form-card-header">
                                    <div class="form-card-icon" style="background: #f5f3ff; color: #7c3aed;"><i class="fas fa-folder-open"></i></div>
                                    <div>
                                        <h3 class="form-card-title">Category</h3>
                                        <p class="form-card-subtitle">Organize into a collection</p>
                                    </div>
                                </div>
                                <div class="form-card-body">
                                    <div class="form-select-wrap">
                                        <select id="category_id"
                                                name="category_id"
                                                class="form-input"
                                                style="padding-right: 36px; appearance: none; cursor: pointer;">
                                            <option value="">Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-chevron-down" style="position: absolute; right: 13px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.7rem; pointer-events: none;"></i>
                                    </div>
                                    @error('category_id')
                                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">

                            <!-- Description Card -->
                            <div class="form-card">
                                <div class="form-card-header">
                                    <div class="form-card-icon" style="background: #fffbeb; color: #d97706;"><i class="fas fa-align-left"></i></div>
                                    <div>
                                        <h3 class="form-card-title">Description</h3>
                                        <p class="form-card-subtitle">Summary or abstract of the content</p>
                                    </div>
                                </div>
                                <div class="form-card-body">
                                    <textarea id="description"
                                              name="description"
                                              rows="5"
                                              placeholder="Write a brief description..."
                                              class="form-input" style="resize: vertical; min-height: 120px;"
                                    >{{ old('description', $document->description) }}</textarea>
                                    @error('description')
                                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- File Upload Card -->
                            <div class="form-card">
                                <div class="form-card-header">
                                    <div class="form-card-icon" style="background: #ecfdf5; color: #059669;"><i class="fas fa-cloud-arrow-up"></i></div>
                                    <div>
                                        <h3 class="form-card-title">File Attachment</h3>
                                        <p class="form-card-subtitle">Replace the current file if needed</p>
                                    </div>
                                </div>
                                <div class="form-card-body">
                                    @if($document->file_path)
                                        <div style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 14px;">
                                            <div style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
                                                @if($document->file_type == 'pdf') background: #fef2f2; color: #ef4444;
                                                @elseif(in_array($document->file_type ?? '', ['doc','docx'])) background: #eff6ff; color: #3b82f6;
                                                @else background: #f1f5f9; color: #94a3b8; @endif
                                                flex-shrink: 0;">
                                                @if($document->file_type == 'pdf')<i class="fas fa-file-pdf"></i>
                                                @elseif(in_array($document->file_type ?? '', ['doc','docx']))<i class="fas fa-file-word"></i>
                                                @else<i class="fas fa-file-lines"></i>
                                                @endif
                                            </div>
                                            <div style="min-width: 0; flex: 1;">
                                                <p style="font-size: 0.8rem; font-weight: 600; color: #334155; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ basename($document->file_path) }}</p>
                                                <p style="font-size: 0.68rem; color: #94a3b8; margin: 2px 0 0;">{{ number_format($document->file_size / 1048576, 2) }} MB &middot; {{ strtoupper($document->file_type ?? 'file') }}</p>
                                            </div>
                                            <span style="flex-shrink: 0; font-size: 0.6rem; font-weight: 700; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; text-transform: uppercase; letter-spacing: 0.03em;">Current</span>
                                        </div>
                                    @endif

                                    <label class="file-drop-zone" id="fileDropZone">
                                        <input type="file" id="file" name="file"
                                               class="file-drop-input @error('file') !border-red-300 @enderror"
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.webp"
                                        >
                                        <div class="file-drop-content">
                                            <div class="file-drop-icon">
                                                <i class="fas fa-cloud-arrow-up"></i>
                                            </div>
                                            <p class="file-drop-text">Click to browse or drag a file here</p>
                                            <p class="file-drop-hint">PDF, DOC, DOCX, XLS, PPT, JPG, PNG — Max 10 MB</p>
                                        </div>
                                    </label>
                                    @error('file')
                                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STICKY ACTION BAR -->
                    <div style="position: sticky; bottom: 0; z-index: 10; padding-top: 1rem; background: linear-gradient(to top, #f1f5f9 60%, transparent); margin: 0 -2rem; padding-left: 2rem; padding-right: 2rem; padding-bottom: 0.5rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.75rem; color: #94a3b8;">
                                <i class="fas fa-info-circle"></i>
                                <span>Changes won't be saved until you click <strong style="color: #475569;">Update Document</strong>.</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <a href="{{ route('documents.manage') }}" class="btn-action secondary" style="padding: 9px 18px;">
                                    Cancel
                                </a>
                                <button type="submit" class="btn-action primary" style="padding: 9px 22px;">
                                    <i class="fas fa-check"></i> Update Document
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        nav[class*="bg-white"][class*="border-b"] { display: none !important; }
        body { padding-top: 0 !important; overflow: hidden !important; font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; margin: 0; }

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
        .brand-icon { width: 42px; height: 42px; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; box-shadow: 0 4px 16px rgba(13, 148, 136, 0.3), inset 0 1px 0 rgba(255,255,255,0.15); position: relative; overflow: hidden; }
        .brand-icon::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.1) 100%); }
        .brand-text { font-size: 1.2rem; font-weight: 900; color: #0f172a; letter-spacing: -0.03em; }
        .brand-badge { font-size: 0.52rem; background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488; padding: 2px 7px; border-radius: 6px; font-weight: 800; letter-spacing: 0.04em; margin-left: auto; border: 1px solid rgba(13, 148, 136, 0.15); }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 0.75rem 0.65rem; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
        .nav-section-label { padding: 1rem 0.75rem 0.35rem; color: #94a3b8; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
        .menu-group { margin-bottom: 0.15rem; }
        .menu-header { display: flex; justify-content: space-between; align-items: center; padding: 0.55rem 0.75rem; color: #94a3b8; font-size: 0.64rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; cursor: pointer; user-select: none; border-radius: 8px; transition: all 0.25s; }
        .menu-header:hover { color: #0d9488; background: rgba(13, 148, 136, 0.04); }
        .menu-arrow { font-size: 0.5rem; transition: transform 0.3s ease; }
        .submenu { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; }
        .submenu.open { max-height: 500px; }
        .menu-header.active .menu-arrow { transform: rotate(180deg); }
        .nav-link { display: flex; align-items: center; padding: 0.55rem 0.8rem; color: #64748b; text-decoration: none; border-radius: 9px; margin-bottom: 1px; font-size: 0.82rem; font-weight: 500; transition: all 0.2s ease; position: relative; }
        .nav-link::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 0; background: #0d9488; border-radius: 0 4px 4px 0; transition: height 0.2s ease; }
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

        .scroll-area { flex: 1; min-height: 0; overflow-y: auto !important; padding-bottom: 2rem; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
        .scroll-area::-webkit-scrollbar { width: 6px; }
        .scroll-area::-webkit-scrollbar-track { background: transparent; }
        .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        .type-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 8px; font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
        .type-badge.record { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .type-badge.file { background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; }
        .type-badge.book { background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
        .type-badge.thesis { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .cat-badge { display: inline-block; padding: 4px 10px; background: #f1f5f9; color: #475569; border-radius: 7px; font-size: 0.7rem; font-weight: 500; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border: 1px solid #e2e8f0; }

        /* ═══════════════════════════════════════════
           FORM CARDS
        ═══════════════════════════════════════════ */
        .form-card {
            background: white; border: 1px solid #e2e8f0; border-radius: 16px;
            overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .form-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .form-card-header {
            display: flex; align-items: center; gap: 12px;
            padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }
        .form-card-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .form-card-title { font-size: 0.88rem; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.01em; }
        .form-card-subtitle { font-size: 0.72rem; color: #94a3b8; margin: 2px 0 0; font-weight: 400; }
        .form-card-body { padding: 16px 20px; }

        .form-input {
            width: 100%; padding: 10px 14px; background: white;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 0.84rem; color: #1e293b; font-family: 'Inter', sans-serif;
            transition: all 0.25s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            outline: none;
        }
        .form-input::placeholder { color: #cbd5e1; }
        .form-input:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08), 0 2px 8px rgba(13, 148, 136, 0.06);
        }
        .form-select-wrap { position: relative; }

        .form-error {
            display: flex; align-items: center; gap: 5px;
            margin: 8px 0 0; font-size: 0.74rem; color: #dc2626; font-weight: 500;
        }
        .form-error i { font-size: 0.7rem; }

        /* ═══════════════════════════════════════════
           FILE DROP ZONE
        ═══════════════════════════════════════════ */
        .file-drop-zone {
            display: flex; align-items: center; justify-content: center;
            width: 100%; min-height: 140px; border-radius: 12px;
            border: 2px dashed #e2e8f0; background: #fafbfc;
            cursor: pointer; position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
        .file-drop-zone:hover {
            border-color: #0d9488; background: linear-gradient(135deg, #f0fdfa, #f8fffe);
        }
        .file-drop-zone.dragover {
            border-color: #0d9488; background: linear-gradient(135deg, #f0fdfa, #ccfbf1);
            transform: scale(1.01);
        }
        .file-drop-input {
            position: absolute; inset: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer; z-index: 2;
        }
        .file-drop-content {
            display: flex; flex-direction: column; align-items: center; gap: 6px;
            pointer-events: none; text-align: center; padding: 1rem;
        }
        .file-drop-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: linear-gradient(135deg, #ecfdf5, #ccfbf1);
            color: #0d9488; display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.1);
        }
        .file-drop-zone:hover .file-drop-icon {
            transform: translateY(-3px); box-shadow: 0 6px 16px rgba(13, 148, 136, 0.2);
        }
        .file-drop-text { font-size: 0.82rem; font-weight: 600; color: #475569; transition: color 0.2s; }
        .file-drop-zone:hover .file-drop-text { color: #0f766e; }
        .file-drop-hint { font-size: 0.68rem; color: #94a3b8; font-weight: 400; }

        /* File name display after selection */
        .file-name-tag {
            display: none; align-items: center; gap: 8px;
            padding: 10px 14px; background: #f0fdfa; border: 1px solid #99f6e4;
            border-radius: 10px; margin-bottom: 10px; font-size: 0.8rem; color: #0f766e; font-weight: 500;
        }
        .file-name-tag.visible { display: flex; }
        .file-name-tag i { color: #0d9488; }
        .file-name-tag .file-remove {
            margin-left: auto; background: none; border: none; color: #94a3b8;
            cursor: pointer; font-size: 0.7rem; padding: 4px; transition: color 0.2s;
        }
        .file-name-tag .file-remove:hover { color: #dc2626; }

        @media (max-width: 1024px) {
            .sidebar { width: 240px; }
            .main-content { margin-left: 240px; width: calc(100% - 240px); }
        }
        @media (max-width: 900px) {
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        }
    </style>

    <script>
        function toggleMenu(header) {
            header.classList.toggle('active');
            header.nextElementSibling.classList.toggle('open');
        }

        // File drop zone interactions
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('file');

        if (dropZone && fileInput) {
            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('dragover');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    updateFileDisplay(files[0]);
                }
            });

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    updateFileDisplay(this.files[0]);
                }
            });
        }

        function updateFileDisplay(file) {
            // Update drop zone visual
            const content = dropZone.querySelector('.file-drop-content');
            if (content) {
                content.innerHTML = `
                    <div class="file-drop-icon" style="background: linear-gradient(135deg, #ecfdf5, #ccfbf1);"><i class="fas fa-check"></i></div>
                    <p class="file-drop-text" style="color: #0f766e;">${file.name}</p>
                    <p class="file-drop-hint">${(file.size / 1048576).toFixed(2)} MB — Click to change</p>
                `;
            }
        }
    </script>
</x-app-layout>