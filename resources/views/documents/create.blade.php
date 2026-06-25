<x-app-layout>
    <div class="flex-1 lg:pl-72">
        <div class="p-6 lg:p-10 max-w-4xl">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <i class="fas fa-cloud-arrow-up text-white text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ request('type') == 'book' ? 'Upload Book' : (request('type') == 'file' ? 'Upload File' : 'Upload Record') }}
                        </h1>
                        <p class="text-sm text-gray-500">Add a new document to the repository</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                
                <!-- Type Badge (hidden input) -->
                <input type="hidden" name="document_type" value="{{ request('type', 'record') }}">

                <div class="space-y-6">
                    
                    <!-- Main Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Document Information
                            </h2>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Title -->
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-medium text-gray-700 mb-2">
                                    Title <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    required 
                                    placeholder="Enter document title..."
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-sm"
                                >
                            </div>

                            <!-- Author & Category Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="flex items-center gap-1.5 text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user-pen text-gray-400 text-xs"></i>
                                        Author / Creator
                                    </label>
                                    <input 
                                        type="text" 
                                        name="author_creator" 
                                        placeholder="Who created this?"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-sm"
                                    >
                                </div>
                                <div>
                                    <label class="flex items-center gap-1.5 text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-folder text-gray-400 text-xs"></i>
                                        Category
                                    </label>
                                    <select 
                                        name="category_id" 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-sm appearance-none cursor-pointer"
                                        style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236b7280%22><path fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/></svg>'); background-position: right 12px center; background-repeat: no-repeat; background-size: 20px;"
                                    >
                                        <option value="">Select category...</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-align-left text-gray-400 text-xs"></i>
                                    Description
                                </label>
                                <textarea 
                                    name="description" 
                                    rows="3" 
                                    placeholder="Brief description of the document..."
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 text-sm resize-none"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-file-arrow-up text-blue-500"></i>
                                File Upload
                            </h2>
                        </div>
                        <div class="p-6">
                            <!-- Drag & Drop Zone -->
                            <div 
                                id="dropZone"
                                class="relative border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-300 group"
                            >
                                <input 
                                    type="file" 
                                    name="file" 
                                    id="fileInput"
                                    required 
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                >
                                
                                <div id="uploadPlaceholder" class="space-y-4">
                                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-blue-100 transition-colors duration-300">
                                        <i class="fas fa-cloud-arrow-up text-2xl text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">
                                            Drop your file here or <span class="text-blue-600 font-semibold">browse</span>
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, JPG, PNG, TXT — Max 50MB</p>
                                    </div>
                                </div>

                                <!-- File Selected State -->
                                <div id="fileSelected" class="hidden space-y-3">
                                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto">
                                        <i class="fas fa-file-circle-check text-2xl text-green-500"></i>
                                    </div>
                                    <div>
                                        <p id="fileName" class="text-sm font-semibold text-gray-900"></p>
                                        <p id="fileSize" class="text-xs text-gray-400 mt-0.5"></p>
                                    </div>
                                    <button 
                                        type="button" 
                                        id="removeFile"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 mx-auto"
                                    >
                                        <i class="fas fa-xmark"></i> Remove file
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visibility Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-eye text-amber-500 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Public Access</p>
                                        <p class="text-xs text-gray-400">Allow viewing without login</p>
                                    </div>
                                </div>
                                <!-- Toggle Switch -->
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="is_public" 
                                        id="is_public" 
                                        value="1" 
                                        class="sr-only peer"
                                    >
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a 
                            href="{{ route('documents.index') }}" 
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200"
                        >
                            <i class="fas fa-arrow-left text-xs"></i>
                            Cancel
                        </a>
                        <button 
                            type="submit" 
                            id="submitBtn"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-200 hover:-translate-y-0.5"
                        >
                            <i class="fas fa-upload text-xs"></i>
                            Upload {{ request('type') == 'book' ? 'Book' : (request('type') == 'file' ? 'File' : 'Record') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

@push('styles')
<style>
    /* Custom scrollbar for sidebar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileSelected = document.getElementById('fileSelected');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(name) {
        const ext = name.split('.').pop().toLowerCase();
        const icons = {
            pdf: 'fa-file-pdf text-red-500',
            doc: 'fa-file-word text-blue-500',
            docx: 'fa-file-word text-blue-500',
            jpg: 'fa-file-image text-green-500',
            jpeg: 'fa-file-image text-green-500',
            png: 'fa-file-image text-green-500',
            txt: 'fa-file-lines text-gray-500'
        };
        return icons[ext] || 'fa-file text-gray-500';
    }

    function handleFile(file) {
        if (file) {
            uploadPlaceholder.classList.add('hidden');
            fileSelected.classList.remove('hidden');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Update icon
            const iconEl = fileSelected.querySelector('i');
            iconEl.className = 'fas ' + getFileIcon(file.name) + ' text-2xl';
            
            dropZone.classList.add('border-green-300', 'bg-green-50/30');
            dropZone.classList.remove('border-gray-200', 'hover:border-blue-400', 'hover:bg-blue-50/30');
        }
    }

    function resetFile() {
        fileInput.value = '';
        uploadPlaceholder.classList.remove('hidden');
        fileSelected.classList.add('hidden');
        dropZone.classList.remove('border-green-300', 'bg-green-50/30');
        dropZone.classList.add('border-gray-200', 'hover:border-blue-400', 'hover:bg-blue-50/30');
    }

    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    removeFile.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        resetFile();
    });

    // Drag and drop
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('border-blue-400', 'bg-blue-50/50', 'scale-[1.01]');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50/50', 'scale-[1.01]');
        });
    });

    dropZone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFile(files[0]);
        }
    });

    // Submit button loading state
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Uploading...
        `;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    });
});
</script>
@endpush