{{-- Site-wide contact modal (vanilla JS — works without React/Vite) --}}
<div id="site-contact-modal" class="hidden fixed inset-0 z-[100060] flex items-center justify-center p-4 sm:p-6 overflow-hidden overscroll-contain" aria-hidden="true" role="dialog" aria-labelledby="site-contact-modal-title">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" data-close-contact-modal></div>
    <div class="relative z-10 w-full max-w-[min(95vw,900px)] max-h-[min(95vh,900px)] min-h-0 flex flex-col overflow-hidden rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-700">
        <div class="flex-shrink-0 flex items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 px-4 py-4 sm:px-6">
            <h2 id="site-contact-modal-title" class="text-xl font-bold text-navy-deep dark:text-white">Send a Message</h2>
            <button type="button" data-close-contact-modal class="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Close">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden p-4 sm:p-6 md:p-8 custom-scrollbar">
            <form id="site-contact-modal-form" class="site-form form-shell-elevated space-y-4 max-w-full overflow-x-hidden">
                @csrf
                <div>
                    <label for="modal_help_with" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">What can we help you with? <span class="text-red-500">*</span></label>
                    <select name="help_with" id="modal_help_with" required class="w-full min-w-0 max-w-full box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Please select</option>
                        @foreach($allServices ?? [] as $service)
                            <option value="service_{{ $service->id }}">{{ $service->translated_title ?? $service->title }}</option>
                        @endforeach
                        <option value="management">Contact management</option>
                        <option value="other">Other</option>
                    </select>
                    <p id="modal_help_with_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>
                <div id="modal_sub_service_wrap" class="hidden">
                    <label for="modal_sub_service" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Select sub-service</label>
                    <select name="sub_service" id="modal_sub_service" class="w-full min-w-0 max-w-full box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Please select</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 min-w-0">
                    <div>
                        <label for="modal_first_name" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">First name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" id="modal_first_name" required class="w-full min-w-0 box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label for="modal_last_name" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Last name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" id="modal_last_name" required class="w-full min-w-0 box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>
                <div>
                    <label for="modal_email" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="modal_email" required class="w-full min-w-0 box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                    <label for="modal_phone" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Phone number <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" id="modal_phone" required class="w-full min-w-0 box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                    <label for="modal_additional_info" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Additional information</label>
                    <textarea name="additional_info" id="modal_additional_info" rows="4" class="w-full min-w-0 box-border px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                </div>
                <div>
                    <label for="modal_file" class="block text-sm font-bold text-navy-deep dark:text-white mb-2">Attachment (optional)</label>
                    <div class="modal-file-row">
                        <label for="modal_file" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-medium text-navy-deep dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700 shrink-0">
                            Choose file
                        </label>
                        <span id="modal_file_name" class="text-sm text-slate-500 dark:text-slate-400 break-all min-w-0">No file chosen</span>
                    </div>
                    <input type="file" name="file" id="modal_file" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png" class="sr-only">
                    <p class="mt-1 text-xs text-slate-500">PDF, Word, text, or image — max 5MB</p>
                </div>
                <div class="flex items-start gap-2 min-w-0">
                    <input type="checkbox" name="privacy_consent" id="modal_privacy_consent" value="1" required class="mt-1 h-4 w-4 shrink-0 rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="modal_privacy_consent" class="text-sm text-gray-700 dark:text-gray-300 break-words">I agree to the privacy policy.</label>
                </div>
                <div id="modal_form_status" class="hidden p-3 rounded-lg text-sm"></div>
                <input type="hidden" name="service_type" id="modal_service_type" value="">
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                    <button type="button" data-close-contact-modal class="w-full sm:w-auto rounded-lg border border-gray-300 bg-white px-6 py-3 font-bold text-navy-deep dark:border-slate-700 dark:bg-slate-800 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700 transition">Cancel</button>
                    <button type="submit" id="modal_submit_btn" class="w-full sm:w-auto rounded-lg bg-primary px-6 py-3 text-white font-bold hover:bg-primary/90 transition">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="application/json" id="modal-sub-services-json">
@json(collect($allServices ?? [])->mapWithKeys(function ($s) {
    return [$s->id => $s->activeSubServices->map(fn ($sub) => ['id' => $sub->id, 'title' => $sub->title])->values()];
})->all())
</script>

<script>
(function () {
    const modal = document.getElementById('site-contact-modal');
    const form = document.getElementById('site-contact-modal-form');
    const helpSelect = document.getElementById('modal_help_with');
    const subWrap = document.getElementById('modal_sub_service_wrap');
    const subSelect = document.getElementById('modal_sub_service');
    const serviceTypeInput = document.getElementById('modal_service_type');
    const statusEl = document.getElementById('modal_form_status');
    const fileInput = document.getElementById('modal_file');
    const fileNameEl = document.getElementById('modal_file_name');
    fileInput?.addEventListener('change', function () {
        fileNameEl.textContent = fileInput.files?.[0]?.name || 'No file chosen';
    });

    const submitBtn = document.getElementById('modal_submit_btn');

    let subServicesMap = {};
    try {
        subServicesMap = JSON.parse(document.getElementById('modal-sub-services-json')?.textContent || '{}');
    } catch (e) {}

    const serviceLabels = {};
    if (helpSelect) {
        Array.from(helpSelect.options).forEach(function (opt) {
            if (opt.value && opt.value.startsWith('service_')) serviceLabels[opt.value] = opt.textContent;
        });
    }

    function updateSubServices() {
        const val = helpSelect?.value || '';
        subSelect.innerHTML = '<option value="">Please select</option>';
        if (!val.startsWith('service_')) {
            subWrap?.classList.add('hidden');
            return;
        }
        const id = val.replace('service_', '');
        const subs = subServicesMap[id] || [];
        if (!subs.length) {
            subWrap?.classList.add('hidden');
            return;
        }
        subs.forEach(function (sub) {
            const opt = document.createElement('option');
            opt.value = 'sub_service_' + sub.id;
            opt.textContent = sub.title;
            subSelect.appendChild(opt);
        });
        subWrap?.classList.remove('hidden');
    }

    helpSelect?.addEventListener('change', function () {
        updateSubServices();
        serviceTypeInput.value = serviceLabels[helpSelect.value] || helpSelect.value || '';
    });

    function closeModal() {
        modal?.classList.add('hidden');
        modal?.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }

    function openModal(preset) {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        if (preset && helpSelect) {
            const found = Array.from(helpSelect.options).find(function (o) { return o.value === preset || o.textContent.trim() === preset; });
            if (found) helpSelect.value = found.value;
            else if (preset.startsWith('service_')) helpSelect.value = preset;
        }
        updateSubServices();
        serviceTypeInput.value = serviceLabels[helpSelect?.value] || helpSelect?.value || '';
        statusEl?.classList.add('hidden');
        setTimeout(function () { document.getElementById('modal_first_name')?.focus(); }, 100);
    }

    window.showSiteContactModal = openModal;
    window.closeSiteContactModal = closeModal;

    window.openContactModal = function (serviceType) {
        openModal(String(serviceType || ''));
    };

    if (window.__contactModalPending !== undefined) {
        openModal(window.__contactModalPending);
        window.__contactModalPending = undefined;
    }

    modal?.querySelectorAll('[data-close-contact-modal]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeModal();
    });

    form?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        formData.set('privacy_consent', document.getElementById('modal_privacy_consent')?.checked ? '1' : '0');
        if (!serviceTypeInput.value) {
            serviceTypeInput.value = serviceLabels[helpSelect.value] || helpSelect.value || 'General Inquiry';
        }
        formData.set('service_type', serviceTypeInput.value);

        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
        statusEl.classList.add('hidden');

        try {
            const res = await fetch('{{ route('contact.form.submit') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });
            const data = await res.json();
            statusEl.classList.remove('hidden');
            if (res.ok && data.success) {
                statusEl.className = 'p-3 rounded-lg text-sm bg-green-100 border border-green-400 text-green-800';
                statusEl.textContent = data.message || 'Message sent successfully!';
                form.reset();
                subWrap?.classList.add('hidden');
                setTimeout(closeModal, 2000);
            } else {
                statusEl.className = 'p-3 rounded-lg text-sm bg-red-100 border border-red-400 text-red-800';
                statusEl.textContent = data.message || 'Unable to send. Please try again.';
            }
        } catch (err) {
            statusEl.classList.remove('hidden');
            statusEl.className = 'p-3 rounded-lg text-sm bg-red-100 border border-red-400 text-red-800';
            statusEl.textContent = 'Network error. Please try again.';
        }
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send';
    });
})();
</script>
