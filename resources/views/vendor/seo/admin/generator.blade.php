<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageForge Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-btn.active { border-bottom: 2px solid #2563eb; color: #2563eb; }
        .tox-tinymce { border-color: #d1d5db !important; border-radius: 0.5rem !important; }
        .pf-modal { display: none; }
        .pf-modal.active { display: flex; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h1 class="text-2xl font-bold">PageForge Admin Generator</h1>
            <div class="flex flex-wrap gap-2">
                <button type="button" data-open-modal="demo-data-modal" onclick="window.nirjonSeoOpenModal && window.nirjonSeoOpenModal('demo-data-modal')" class="rounded-md border border-blue-200 bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-100">Use Demo Data</button>
                <button type="button" data-open-modal="css-help-modal" onclick="window.nirjonSeoOpenModal && window.nirjonSeoOpenModal('css-help-modal')" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">CSS Classes</button>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="flex border-b mb-6">
            <button id="tab-generator" class="tab-btn active px-4 py-2 font-medium text-gray-600 hover:text-blue-600 focus:outline-none" onclick="switchTab('generator')">
                Generator Form
            </button>
            <button id="tab-pages" class="tab-btn px-4 py-2 font-medium text-gray-600 hover:text-blue-600 focus:outline-none" onclick="switchTab('pages')">
                Generated Pages
            </button>
        </div>

        <div id="alert-container" class="hidden mb-4 p-4 rounded text-white font-medium"></div>

        <!-- Tab Content: Generator Form -->
        <div id="content-generator" class="tab-content active">
            <form id="generator-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Template Title</label>
                    <input type="text" id="templateTitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Template Slug</label>
                    <input type="text" id="templateSlug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                    <input type="text" id="meta_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                    <textarea id="meta_description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                    <input type="text" id="meta_keywords" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Upload Featured Image</label>
                    <input type="file" id="featured_image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Author</label>
                    <input type="text" id="author" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Publisher</label>
                    <input type="text" id="publisher" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Copyright</label>
                    <input type="text" id="copyright" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Site Name</label>
                    <input type="text" id="site_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-gray-800">Generated Page Design</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Page Logo</label>
                            <input type="file" id="logo_image" accept="image/*" class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Font Family</label>
                            <input type="text" id="font_family" value="Inter, Arial, sans-serif" class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Primary Color</label>
                            <input type="color" id="primary_color" value="#111827" class="mt-1 h-10 w-full rounded-md border border-gray-300 bg-white p-1 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Accent Color</label>
                            <input type="color" id="accent_color" value="#2563eb" class="mt-1 h-10 w-full rounded-md border border-gray-300 bg-white p-1 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Background Color</label>
                            <input type="color" id="background_color" value="#f8fafc" class="mt-1 h-10 w-full rounded-md border border-gray-300 bg-white p-1 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Text Color</label>
                            <input type="color" id="text_color" value="#1f2937" class="mt-1 h-10 w-full rounded-md border border-gray-300 bg-white p-1 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Container Width</label>
                            <input type="text" id="container_width" value="960px" class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Custom CSS</label>
                            <textarea id="custom_css" rows="5" class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 font-mono text-sm shadow-sm" placeholder=".pf-hero { ... }"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Keyword Bundle 1 (comma separated)</label>
                    <input type="text" id="bundle1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Keyword Bundle 2 (comma separated)</label>
                    <input type="text" id="bundle2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-5 rounded-md mb-6 text-sm shadow-sm">
    <h4 class="text-base font-bold mb-3 flex items-center text-blue-900">
        <span class="mr-2 text-lg"></span> How to Get the Best Results:
    </h4>
    <ul class="list-disc pl-5 space-y-3 text-gray-700">
        <li>
            <strong class="text-gray-900">Dynamic Keywords:</strong> Use <code>{0}</code> for words in your first bundle, and <code>{1}</code> for the second. 
            <br><span class="text-xs text-gray-500 italic">Example: "Looking for {0} repair in {1}?" will automatically become "Looking for iPhone repair in London?"</span>
        </li>
        <li>
            <strong class="text-gray-900">Keep Content Unique (Spintax):</strong> Prevent duplicate content penalties in SEO by using format like <code>{Best|Top|Reliable}</code>. The generator will randomly pick one word for every new page.
        </li>
        <li>
            <strong class="text-gray-900">Add Images & Videos:</strong> Make your content engaging! Feel free to paste standard HTML tags like <code>&lt;img src="..."&gt;</code> or YouTube <code>&lt;iframe src="..."&gt;</code> directly into the Content box.
        </li>
        <li>
            <strong class="text-gray-900">Social Media Preview:</strong> Upload a catchy Featured Image. This will automatically generate Open Graph (OG) tags so your pages look professional when shared on Facebook, Twitter, or LinkedIn.
        </li>
    </ul>
</div>

                <button type="button" id="generate-btn" onclick="generatePages()" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition-colors">
                    Generate Pages
                </button>
                <div id="loading-ui" class="hidden text-sm text-gray-500 mt-2">Loading... please wait.</div>
            </form>
        </div>

        <!-- Tab Content: Generated Pages -->
        <div id="content-pages" class="tab-content">
            <div id="generatedPagesContainer" class="space-y-4">
                <!-- Pages will be dynamically rendered here -->
                <div class="text-gray-500">Loading pages...</div>
            </div>
        </div>
    </div>

    <div id="demo-data-modal" class="pf-modal fixed inset-0 z-50 items-center justify-center bg-slate-900/60 p-4">
        <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-lg bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Demo Data</h2>
                    <p class="text-sm text-slate-500">Fill PageForge with a working demo template.</p>
                </div>
                <button type="button" data-close-modal onclick="window.nirjonSeoCloseModals && window.nirjonSeoCloseModals()" class="rounded-md px-2 py-1 text-slate-500 hover:bg-slate-100">Close</button>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <button type="button" data-demo-type="consultancy" class="rounded-lg border border-slate-200 p-4 text-left hover:border-blue-400 hover:bg-blue-50">
                    <strong class="block text-slate-900">Consultancy Landing Page</strong>
                    <span class="text-sm text-slate-500">Professional stress-test template using service + city combinations.</span>
                    <span class="mt-3 block text-xs font-semibold uppercase tracking-wide text-slate-500">Fills</span>
                    <span class="mt-1 block text-sm text-slate-600">Template title, slug, content, meta fields, author, publisher, colors, and keyword bundles.</span>
                    <span class="mt-2 block rounded-md bg-slate-50 p-2 text-xs text-slate-600">Expert {0} Consultancy in {1}<br>Top {0} Services in {1} | BlackTech</span>
                    <span class="mt-2 block text-xs text-slate-500">Bundles: Web Development, SEO Audit, API Integration + Dhaka, Sylhet</span>
                </button>
                <button type="button" data-demo-type="restaurant" class="rounded-lg border border-slate-200 p-4 text-left hover:border-blue-400 hover:bg-blue-50">
                    <strong class="block text-slate-900">Restaurant Menu Design</strong>
                    <span class="text-sm text-slate-500">Local landing pages with richer visual content.</span>
                    <span class="mt-3 block text-xs font-semibold uppercase tracking-wide text-slate-500">Fills</span>
                    <span class="mt-1 block text-sm text-slate-600">Menu-design title, slug, HTML content, SEO metadata, design defaults, and keyword bundles.</span>
                    <span class="mt-2 block text-xs text-slate-500">Bundles: Restaurant, Cafe, Bistro + Dhaka, Sylhet, Chittagong</span>
                </button>
            </div>
        </div>
    </div>

    <div id="css-help-modal" class="pf-modal fixed inset-0 z-50 items-center justify-center bg-slate-900/60 p-4">
        <div class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-lg bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Demo CSS Customization</h2>
                    <p class="text-sm text-slate-500">Use these classes in the Custom CSS field.</p>
                </div>
                <button type="button" data-close-modal onclick="window.nirjonSeoCloseModals && window.nirjonSeoCloseModals()" class="rounded-md px-2 py-1 text-slate-500 hover:bg-slate-100">Close</button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-200 p-4">
                    <h3 class="mb-2 font-bold text-slate-900">Available Classes</h3>
                    <ul class="space-y-1 text-sm text-slate-700">
                        <li><code>.pf-page</code> controls the full generated page background and outer spacing</li>
                        <li><code>.pf-shell</code> controls the centered page width wrapper</li>
                        <li><code>.pf-header</code> controls the logo/header row above the card</li>
                        <li><code>.pf-logo</code> controls uploaded logo size and fit</li>
                        <li><code>.pf-card</code> controls the main page card border, radius, and shadow</li>
                        <li><code>.pf-hero</code> controls the title section background and spacing</li>
                        <li><code>.pf-title</code> controls the generated page H1</li>
                        <li><code>.pf-featured</code> controls the uploaded featured image</li>
                        <li><code>.pf-content</code> controls generated HTML body content</li>
                        <li><code>.pf-related</code> controls the related pages section</li>
                        <li><code>.pf-related-card</code> controls each related page card</li>
                    </ul>
                </div>
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900">Sample CSS</h3>
                        <button type="button" id="apply-demo-css" class="rounded-md bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-slate-700">Use This CSS</button>
                    </div>
                    <pre class="overflow-x-auto rounded-lg bg-slate-950 p-4 text-xs text-slate-100"><code id="demo-css-code">.pf-card {
  border-radius: 6px;
  box-shadow: 0 24px 70px rgba(15, 23, 42, 0.14);
}

.pf-hero {
  background: linear-gradient(135deg, #eff6ff, #ffffff);
}

.pf-featured {
  aspect-ratio: 16 / 7;
}

.pf-content h3 {
  border-left: 4px solid var(--pf-accent);
  padding-left: 14px;
}

.pf-related-card {
  background: #f8fafc;
}</code></pre>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        (function () {
            function openModal(id) {
                closeModals();
                var modal = document.getElementById(id);
                if (modal) {
                    modal.classList.add('active');
                    modal.setAttribute('aria-hidden', 'false');
                }
            }

            function closeModals() {
                document.querySelectorAll('.pf-modal').forEach(function (modal) {
                    modal.classList.remove('active');
                    modal.setAttribute('aria-hidden', 'true');
                });
            }

            window.nirjonSeoOpenModal = openModal;
            window.nirjonSeoCloseModals = closeModals;

            document.addEventListener('click', function (event) {
                var opener = event.target.closest('[data-open-modal]');
                if (opener) {
                    event.preventDefault();
                    openModal(opener.getAttribute('data-open-modal'));
                    return;
                }

                if (event.target.closest('[data-close-modal]')) {
                    event.preventDefault();
                    closeModals();
                }
            });
        })();

        document.addEventListener('DOMContentLoaded', fetchAndRenderPages);

        document.addEventListener('DOMContentLoaded', function () {
            if (window.tinymce && document.getElementById('content')) {
                tinymce.init({
                    selector: '#content',
                    height: 460,
                    menubar: 'file edit view insert format tools table help',
                    branding: false,
                    promotion: false,
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount help emoticons codesample',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote codesample | removeformat code fullscreen preview',
                    toolbar_mode: 'sliding',
                    setup: function (editor) {
                        editor.on('change keyup', function () {
                            editor.save();
                        });
                    }
                });
            }
        });

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            document.getElementById('content-' + tabName).classList.add('active');
            document.getElementById('tab-' + (tabName === 'generator' ? 'generator' : 'pages')).classList.add('active');

            if (tabName === 'pages') {
                fetchAndRenderPages();
            }
        }

        function setValue(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.value = value || '';
            }
        }

        function setEditorHtml(value) {
            const tinyEditor = window.tinymce ? tinymce.get('content') : null;
            if (tinyEditor) {
                tinyEditor.setContent(value || '');
                return;
            }
            setValue('content', value || '');
        }

        function openModal(id) {
            window.nirjonSeoOpenModal(id);
        }

        function closeModals() {
            window.nirjonSeoCloseModals();
        }

        function demoPayload(type) {
            if (type === 'restaurant') {
                return {
                    templateTitle: '{Premium|Modern|Creative} {0} Menu Design in {1}',
                    templateSlug: '{0}-menu-design-{1}',
                    content: '<h3>Professional {0} Menu Design in {1}</h3><p>Your menu is often the first sales tool your customer sees. We create <strong>{premium|modern|conversion-focused}</strong> menu designs that help restaurants, cafes, and food brands present offers clearly.</p><p>Our team combines layout, typography, food imagery, and local SEO structure so your {0} business in <strong>{1}</strong> looks polished online.</p>',
                    metaTitle: '{0} Menu Design in {1} | BlackTech',
                    metaDescription: 'Professional {0} menu design services in {1}. Get a polished restaurant menu and SEO-ready landing page.',
                    metaKeywords: '{0}, menu design, restaurant branding, {1}',
                    bundle1: 'Restaurant, Cafe, Bistro',
                    bundle2: 'Dhaka, Sylhet, Chittagong'
                };
            }

            return {
                templateTitle: 'Expert {0} Consultancy in {1}',
                templateSlug: 'expert-{0}-consultancy-{1}',
                content: '<h3>Need {0} Services in {1}?</h3><p>BlackTech Consultancy helps growing businesses plan, build, and optimize professional <strong>{0}</strong> solutions for teams in <strong>{1}</strong> and beyond.</p><p>From discovery and implementation to reporting and continuous improvement, our consultants focus on measurable outcomes, clean delivery, and long-term scalability.</p><p>Get the {premium|fast|reliable} experience your project deserves.</p>',
                metaTitle: 'Top {0} Services in {1} | BlackTech',
                metaDescription: 'Hire expert {0} developers in {1} for your business growth. Professional services by BlackTech.',
                metaKeywords: '{0}, {1}, expert services, BlackTech',
                bundle1: 'Web Development, SEO Audit, API Integration',
                bundle2: 'Dhaka, Sylhet'
            };
        }

        function fillDemoData(type) {
            const demo = demoPayload(type);
            setValue('templateTitle', demo.templateTitle);
            setValue('templateSlug', demo.templateSlug);
            setEditorHtml(demo.content);
            setValue('meta_title', demo.metaTitle);
            setValue('meta_description', demo.metaDescription);
            setValue('meta_keywords', demo.metaKeywords);
            setValue('author', 'Nirjon Roy');
            setValue('publisher', 'BlackTech Consultancy');
            setValue('copyright', '\u00a9 2026 BlackTech Consultancy');
            setValue('site_name', 'BlackTech Consultancy');
            setValue('bundle1', demo.bundle1);
            setValue('bundle2', demo.bundle2);
            setValue('primary_color', '#111827');
            setValue('accent_color', '#2563eb');
            setValue('background_color', '#f8fafc');
            setValue('text_color', '#1f2937');
            setValue('font_family', 'Inter, Arial, sans-serif');
            setValue('container_width', '960px');
            closeModals();
            switchTab('generator');
        }

        async function editPage(id) {
            if (!id) {
                return;
            }

            try {
                const response = await fetch(`/admin/seo-admin/generator/api-pages/${encodeURIComponent(id)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();

                if (!response.ok || !data.template) {
                    alert('Could not load page data for editing.');
                    return;
                }

                const template = data.template;
                setValue('templateTitle', template.title_structure || data.page.final_title || '');
                setValue('templateSlug', template.slug_structure || data.page.url_slug || '');
                setEditorHtml(template.content || data.page.final_content || '');
                setValue('meta_title', template.meta_title || data.page.meta_title || '');
                setValue('meta_description', template.meta_description || data.page.meta_description || '');
                setValue('meta_keywords', template.meta_keywords || data.page.meta_keywords || '');
                setValue('author', template.author || '');
                setValue('publisher', template.publisher || '');
                setValue('copyright', template.copyright || '');
                setValue('site_name', template.site_name || '');
                setValue('primary_color', template.primary_color || '#111827');
                setValue('accent_color', template.accent_color || '#2563eb');
                setValue('background_color', template.background_color || '#f8fafc');
                setValue('text_color', template.text_color || '#1f2937');
                setValue('font_family', template.font_family || 'Inter, Arial, sans-serif');
                setValue('container_width', template.container_width || '960px');
                setValue('custom_css', template.custom_css || '');
                setValue('bundle1', data.keyword_bundle_1 || '');
                setValue('bundle2', data.keyword_bundle_2 || '');
                switchTab('generator');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } catch (error) {
                alert('Could not load page data for editing.');
            }
        }

        async function fetchAndRenderPages() {
            const container = document.getElementById('generatedPagesContainer');
            container.innerHTML = '<div class="text-gray-500">Loading pages...</div>';

            try {
                const response = await fetch('/admin/seo-admin/generator/api-pages');
                const data = await response.json();

                const pages = Array.isArray(data) ? data : (data.data || []);

                if (!response.ok) {
                    container.innerHTML = `<div class="text-red-500">Failed to load pages. ${data.message || ''}</div>`;
                    return;
                }

                if (pages.length === 0) {
                    container.innerHTML = '<div class="text-gray-500">No generated pages found.</div>';
                    return;
                }

                let html = '<div class="overflow-x-auto"><table class="min-w-full bg-white border border-gray-200">';
                html += `
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm uppercase tracking-wider text-gray-600">
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Slug</th>
                            <th class="py-2 px-4 border-b">Created At</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                `;

                pages.forEach(page => {
                    const viewUrl = '/' + page.url_slug;
                    const date = page.created_at ? new Date(page.created_at).toLocaleString() : 'N/A';
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">${page.id || ''}</td>
                            <td class="py-2 px-4 border-b font-medium">${page.final_title || ''}</td>
                            <td class="py-2 px-4 border-b text-gray-500">${page.url_slug || ''}</td>
                            <td class="py-2 px-4 border-b">${date}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex gap-3">
                                    <a href="${viewUrl}" target="_blank" class="text-blue-600 hover:underline">View</a>
                                    <button type="button" onclick="editPage(${page.id})" class="text-amber-600 hover:underline font-medium">Edit</button>
                                    <button type="button" onclick="deletePage(${page.id})" class="text-red-600 hover:underline font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                html += '</tbody></table></div>';
                container.innerHTML = html;
            } catch (error) {
                container.innerHTML = '<div class="text-red-500">An error occurred while fetching pages.</div>';
                console.error(error);
            }
        }

        async function generatePages() {
            const templateTitle = document.getElementById('templateTitle').value;
            const templateSlug = document.getElementById('templateSlug').value;
            const tinyEditor = window.tinymce ? tinymce.get('content') : null;
            const content = tinyEditor ? tinyEditor.getContent() : document.getElementById('content').value;
            
            const metaTitle = document.getElementById('meta_title').value;
            const metaDescription = document.getElementById('meta_description').value;
            const metaKeywords = document.getElementById('meta_keywords').value;
            const author = document.getElementById('author').value;
            const publisher = document.getElementById('publisher').value;
            const copyright = document.getElementById('copyright').value;
            const siteName = document.getElementById('site_name').value;
            
            const bundle1Input = document.getElementById('bundle1').value;
            const bundle2Input = document.getElementById('bundle2').value;
            
            const bundle1 = bundle1Input ? bundle1Input.split(',').map(s => s.trim()).filter(s => s) : [];
            const bundle2 = bundle2Input ? bundle2Input.split(',').map(s => s.trim()).filter(s => s) : [];

            let bundles = [];
            if (bundle1.length > 0) {
                bundles.push({ name: 'Bundle 1', keywords: bundle1 });
            }
            if (bundle2.length > 0) {
                bundles.push({ name: 'Bundle 2', keywords: bundle2 });
            }

            const formData = new FormData();
            formData.append('title', templateTitle);
            formData.append('slug', templateSlug);
            formData.append('content', content);
            formData.append('metaTitle', metaTitle);
            formData.append('metaDescription', metaDescription);
            formData.append('metaKeywords', metaKeywords);
            formData.append('author', author);
            formData.append('publisher', publisher);
            formData.append('copyright', copyright);
            formData.append('siteName', siteName);
            formData.append('primaryColor', document.getElementById('primary_color').value);
            formData.append('accentColor', document.getElementById('accent_color').value);
            formData.append('backgroundColor', document.getElementById('background_color').value);
            formData.append('textColor', document.getElementById('text_color').value);
            formData.append('fontFamily', document.getElementById('font_family').value);
            formData.append('containerWidth', document.getElementById('container_width').value);
            formData.append('customCss', document.getElementById('custom_css').value);
            
            if (document.getElementById('featured_image').files.length > 0) {
                formData.append('featured_image', document.getElementById('featured_image').files[0]);
            }
            if (document.getElementById('logo_image').files.length > 0) {
                formData.append('logo_image', document.getElementById('logo_image').files[0]);
            }
            formData.append('bundles', JSON.stringify(bundles));

            const btn = document.getElementById('generate-btn');
            const loading = document.getElementById('loading-ui');
            const alertContainer = document.getElementById('alert-container');

            btn.disabled = true;
            loading.classList.remove('hidden');
            alertContainer.classList.add('hidden');

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const tokenValue = csrfToken ? csrfToken.content : '';

                const response = await fetch('/admin/seo-admin/generator/api-generate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': tokenValue
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alertContainer.textContent = data.message || 'Generation successful!';
                    alertContainer.className = 'mb-4 p-4 rounded text-white bg-green-500 block';
                    document.getElementById('generator-form').reset();
                    if (tinyEditor) {
                        tinyEditor.setContent('');
                    }
                    setTimeout(() => switchTab('pages'), 1500);
                } else {
                    alertContainer.textContent = data.message || 'Error occurred';
                    alertContainer.className = 'mb-4 p-4 rounded text-white bg-red-500 block';
                }
            } catch (error) {
                alertContainer.textContent = 'A network error occurred.';
                alertContainer.className = 'mb-4 p-4 rounded text-white bg-red-500 block';
            } finally {
                btn.disabled = false;
                loading.classList.add('hidden');
            }
        }

        async function deletePage(id) {
            if (!id || !confirm('Are you sure you want to delete this page?')) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]');

            try {
                const response = await fetch(`/admin/seo-admin/generator/api-pages/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    fetchAndRenderPages();
                    return;
                }

                alert('Could not delete page.');
            } catch (error) {
                console.error(error);
                alert('Could not delete page.');
            }
        }
        
        // Add window object exposure just to be completely safe in some environments
        window.generatePages = generatePages;
        window.fetchAndRenderPages = fetchAndRenderPages;
        window.switchTab = switchTab;
        window.deletePage = deletePage;
        window.editPage = editPage;

        document.addEventListener('click', function (event) {
            const target = event.target.closest('[data-open-modal], [data-close-modal], [data-demo-type], #apply-demo-css');

            if (!target) {
                return;
            }

            if (target.matches('[data-open-modal]')) {
                openModal(target.getAttribute('data-open-modal'));
                return;
            }

            if (target.matches('[data-close-modal]')) {
                closeModals();
                return;
            }

            if (target.matches('[data-demo-type]')) {
                fillDemoData(target.getAttribute('data-demo-type'));
                return;
            }

            if (target.matches('#apply-demo-css')) {
                setValue('custom_css', document.getElementById('demo-css-code') ? document.getElementById('demo-css-code').textContent : '');
                closeModals();
            }
        });
    </script>
</body>
</html>
