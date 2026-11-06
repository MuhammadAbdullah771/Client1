@php
    $strip = fn ($v, $limit = 1200) => \Illuminate\Support\Str::limit(strip_tags((string) ($v ?? '')), $limit);
    $chatServices = collect($allServices ?? [])->map(function ($service) use ($strip) {
        $subServices = ($service->activeSubServices ?? collect())->map(function ($sub) use ($strip) {
            $sections = [];
            for ($i = 1; $i <= 5; $i++) {
                $h = $sub->{'heading_'.$i} ?? null;
                $c = $sub->{'content_'.$i} ?? null;
                if ($h || $c) {
                    $sections[] = ['heading' => $strip($h, 200), 'content' => $strip($c, 400)];
                }
            }
            return [
                'title' => $sub->title,
                'description' => $strip($sub->description, 400),
                'sections' => $sections,
            ];
        })->values()->all();

        return [
            'id' => $service->id,
            'title' => $service->title,
            'translated_title' => $service->translated_title,
            'image' => $service->display_image_url ?? null,
            'description' => $strip($service->description, 800),
            'intro_text' => $strip($service->intro_text, 400),
            'main_heading' => $strip($service->main_heading, 200),
            'content_paragraph_1' => $strip($service->content_paragraph_1, 600),
            'content_paragraph_2' => $strip($service->content_paragraph_2, 600),
            'services_list' => $strip($service->services_list, 800),
            'section_title' => $strip($service->section_title, 200),
            'section_content_1' => $strip($service->section_content_1, 400),
            'section_content_2' => $strip($service->section_content_2, 400),
            'section_content_3' => $strip($service->section_content_3, 400),
            'additional_info_title' => $strip($service->additional_info_title, 200),
            'additional_info_content' => $strip($service->additional_info_content, 500),
            'contact_message' => $strip($service->contact_message, 400),
            'sub_services' => $subServices,
        ];
    })->values()->all();

    $chatJobs = collect($allJobs ?? [])->map(fn ($job) => [
        'id' => $job->id,
        'title' => $job->title,
        'department' => $job->department,
        'location' => $job->location,
        'employment_type' => $job->employment_type,
        'description' => $strip($job->description, 300),
    ])->values()->all();
@endphp

<div id="ai-chatbot-widget" class="ai-chatbot-fixed" aria-live="polite">
    <div id="ai-chat-window" class="ai-chat-window pointer-events-auto" role="dialog" aria-label="9A Assistant chat" aria-hidden="true">
        <div class="bg-primary p-4 flex items-center justify-between text-white shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <span class="ai-bot-logo-wrap shrink-0">
                    @include('components.chatbot-icon', ['class' => 'w-9 h-9'])
                </span>
                <div class="min-w-0">
                    <h4 class="font-bold text-sm truncate">9A Assistant</h4>
                    <p class="text-xs text-white/80 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-400 shrink-0"></span> Online — services, contact &amp; careers
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1 shrink-0">
                <button type="button" id="new-chatbot" class="text-white hover:bg-white/20 p-1 rounded-full transition shrink-0" aria-label="Start new chat" title="New chat">
                    <span class="material-symbols-outlined">refresh</span>
                </button>
                <button type="button" id="close-chatbot" class="text-white hover:bg-white/20 p-1 rounded-full transition shrink-0" aria-label="Close chat">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <div id="ai-chat-messages"
            class="flex-1 min-h-0 p-4 overflow-y-auto overflow-x-hidden bg-slate-50 dark:bg-slate-800/50 flex flex-col gap-3 custom-scrollbar">
            <div class="flex gap-2 min-w-0">
                <span class="ai-bot-logo-wrap ai-chat-avatar shrink-0">
                    @include('components.chatbot-icon', ['class' => 'w-8 h-8'])
                </span>
                <div class="bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-700 dark:text-slate-300 border border-slate-100 dark:border-slate-700 max-w-[85%] break-words">
                    Hello! I'm <strong>9A Assistant</strong>. How can I help you today?
                </div>
            </div>
            <div id="ai-chat-suggestions" class="ai-chat-suggestions" aria-label="Suggested questions">
                <button type="button" class="ai-chat-suggestion" data-question="What services do you offer?">What services do you offer?</button>
                <button type="button" class="ai-chat-suggestion" data-question="Tell me about VAT and ZATCA compliance">VAT &amp; ZATCA compliance</button>
                <button type="button" class="ai-chat-suggestion" data-question="How does the contact form work?">Contact form help</button>
                <button type="button" class="ai-chat-suggestion" data-question="contact me">Submit a contact request</button>
                <button type="button" class="ai-chat-suggestion" data-question="What jobs are open?">Open jobs</button>
                <button type="button" class="ai-chat-suggestion" data-question="How do I apply for a job?">How to apply</button>
                <button type="button" class="ai-chat-suggestion" data-question="I want to apply for a job">Send career interest</button>
            </div>
        </div>

        <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 shrink-0">
            <form id="ai-chat-form" class="flex items-center gap-2 min-w-0 max-w-full">
                <input type="text" id="ai-chat-input"
                    class="flex-1 min-w-0 max-w-full border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-full px-4 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-slate-700 dark:text-white box-border"
                    placeholder="Type your message..." autocomplete="off">
                <button type="submit" aria-label="Send message"
                    class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center hover:bg-primary/90 transition shrink-0">
                    <span class="material-symbols-outlined text-lg translate-x-[1px]">send</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    const CHAT_SERVICES = @json($chatServices);
    const CHAT_JOBS = @json($chatJobs);
    const CHAT_AVATAR_HTML = '<span class="ai-assistant-icon-wrap ai-chat-avatar shrink-0"><img src="{{ asset('logo.png') }}" alt="" class="ai-assistant-logo-img"></span>';
    const ANSWER_URL = @json(route('api.chatbot.answer'));
    const CONTACT_URL = @json(route('contact.form.submit'));
    const JOB_URL = @json(route('careers.application.submit'));

    let isChatOpen = false;
    let chatStep = 0;
    let chatPhase = 'qa';
    let leadData = { message: '', email: '', phone: '', intent: '', serviceType: '', helpWith: '', firstName: '', lastName: '' };
    let initialMessagesHtml = '';

    function getEls() {
        return {
            widget: document.getElementById('ai-chatbot-widget'),
            chatWindow: document.getElementById('ai-chat-window'),
            closeBtn: document.getElementById('close-chatbot'),
            newChatBtn: document.getElementById('new-chatbot'),
            chatForm: document.getElementById('ai-chat-form'),
            chatInput: document.getElementById('ai-chat-input'),
            messagesArea: document.getElementById('ai-chat-messages'),
            suggestionsArea: document.getElementById('ai-chat-suggestions'),
        };
    }

    function updateHeaderOffset() {
        const header = document.querySelector('.premium-header') || document.querySelector('header');
        let offset = 120;
        if (header) {
            const rect = header.getBoundingClientRect();
            if (rect.bottom > 0) offset = rect.bottom;
        }
        document.documentElement.style.setProperty('--site-header-offset', Math.round(offset) + 'px');
    }

    function pinChatbotToViewport() {
        const { widget } = getEls();
        if (!widget) return;
        if (widget.parentElement !== document.body) {
            document.body.appendChild(widget);
        }
        widget.classList.add('ai-chatbot-fixed');
        widget.style.cssText = 'position:fixed!important;bottom:max(1.25rem,env(safe-area-inset-bottom,0px))!important;right:max(1.25rem,env(safe-area-inset-right,0px))!important;top:auto!important;left:auto!important;z-index:2147483000!important;margin:0!important;transform:none!important;pointer-events:none;';
        updateHeaderOffset();
    }

    function setChatOpen(open) {
        const { chatWindow, chatInput } = getEls();
        if (!chatWindow) return;
        isChatOpen = !!open;
        pinChatbotToViewport();
        chatWindow.classList.toggle('is-open', isChatOpen);
        chatWindow.setAttribute('aria-hidden', isChatOpen ? 'false' : 'true');
        document.body.classList.toggle('ai-chat-open', isChatOpen);
        if (isChatOpen) {
            setTimeout(function () {
                try { chatInput?.focus({ preventScroll: true }); } catch (e) { chatInput?.focus(); }
            }, 60);
        }
    }

    window.open9AAssistant = function () { setChatOpen(true); };
    window.close9AAssistant = function () { setChatOpen(false); };
    window.toggle9AAssistant = function () { setChatOpen(!isChatOpen); };

    function escapeHtml(text) {
        const el = document.createElement('div');
        el.textContent = text == null ? '' : String(text);
        return el.innerHTML;
    }

    function normalizeText(text) {
        return String(text || '').toLowerCase().replace(/[^a-z0-9\s]/g, ' ').replace(/\s+/g, ' ').trim();
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function wantsContactFlow(text) {
        return /\b(contact me|call me|callback|get a quote|request a quote|get started|speak to|talk to|email me|consultation|hire you|book (a )?appointment|submit a contact)\b/i.test(text);
    }

    function wantsCareerLead(text) {
        return /\b(i want to apply|apply for a job|send (my )?cv|career interest|interested in (a |the )?job|job application)\b/i.test(text);
    }

    function matchService(text) {
        const normalized = normalizeText(text);
        if (!normalized) return null;
        let best = null, bestScore = 0;
        CHAT_SERVICES.forEach(function (service) {
            [service.title, service.translated_title].filter(Boolean).forEach(function (title) {
                const titleNorm = normalizeText(title);
                if (!titleNorm) return;
                let score = 0;
                if (normalized.includes(titleNorm) || titleNorm.includes(normalized)) score = titleNorm.length + 10;
                else titleNorm.split(' ').forEach(function (word) {
                    if (word.length > 3 && normalized.includes(word)) score += word.length;
                });
                if (score > bestScore) { bestScore = score; best = service; }
            });
        });
        return bestScore >= 3 ? best : null;
    }

    function detectIntent(text) {
        const lower = text.toLowerCase();
        if (wantsCareerLead(text) || /\b(job|career|careers|hiring|vacancy|apply|cv|resume)\b/.test(lower)) return 'careers';
        if (wantsContactFlow(text) || /\b(contact|quote|pricing|cost|price)\b/.test(lower)) return 'contact';
        if (/\b(all services|what services|list services)\b/.test(lower) || matchService(text)) return 'service';
        return 'general';
    }

    function addMessage(text, isUser) {
        const { messagesArea } = getEls();
        if (!messagesArea) return;
        const msgDiv = document.createElement('div');
        msgDiv.className = 'flex gap-2 min-w-0' + (isUser ? ' flex-row-reverse' : '');
        const avatar = isUser
            ? '<div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-sm">person</span></div>'
            : CHAT_AVATAR_HTML;
        const bubbleClass = isUser
            ? 'bg-primary text-white rounded-2xl rounded-tr-sm shadow-sm p-3 text-sm'
            : 'bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-700 dark:text-slate-300 border border-slate-100 dark:border-slate-700';
        msgDiv.innerHTML = avatar + '<div class="' + bubbleClass + ' max-w-[85%] break-words">' + text + '</div>';
        messagesArea.appendChild(msgDiv);
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    function showTypingIndicator() {
        const { messagesArea } = getEls();
        if (!messagesArea || document.getElementById('typing-indicator')) return;
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'flex gap-2 min-w-0';
        typingDiv.innerHTML = CHAT_AVATAR_HTML + '<div class="bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-500 border border-slate-100 dark:border-slate-700 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce"></span><span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay:0.2s"></span><span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay:0.4s"></span></div>';
        messagesArea.appendChild(typingDiv);
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    function removeTypingIndicator() {
        document.getElementById('typing-indicator')?.remove();
    }

    function hideSuggestions() {
        const { suggestionsArea } = getEls();
        if (suggestionsArea) suggestionsArea.style.display = 'none';
    }

    function resetInputType() {
        const { chatInput } = getEls();
        if (!chatInput) return;
        chatInput.type = 'text';
        chatInput.disabled = false;
        chatInput.placeholder = 'Type your message...';
    }

    function resetChat() {
        const { messagesArea, chatInput } = getEls();
        if (messagesArea && initialMessagesHtml) {
            messagesArea.innerHTML = initialMessagesHtml;
            messagesArea.scrollTop = 0;
        }
        chatStep = 0;
        chatPhase = 'qa';
        leadData = { message: '', email: '', phone: '', intent: '', serviceType: '', helpWith: '', firstName: '', lastName: '' };
        resetInputType();
        if (chatInput) {
            chatInput.value = '';
            try { chatInput.focus({ preventScroll: true }); } catch (e) { /* no-op */ }
        }
    }

    const FIELD_CLS = 'w-full box-border px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 rounded-lg text-slate-700 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary';
    const LABEL_CLS = 'block text-[0.65rem] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1';

    function formFieldHtml(label, inner, required) {
        return '<div class="min-w-0"><label class="' + LABEL_CLS + '">' + label + (required ? ' <span class="text-red-500">*</span>' : '') + '</label>' + inner + '</div>';
    }

    // Same contact form the website uses (posts to the same endpoint).
    function showContactForm(preset) {
        const options = ['<option value="general">General Inquiry</option>'].concat(
            CHAT_SERVICES.map(function (s) {
                const selected = preset && preset.serviceId === s.id ? ' selected' : '';
                return '<option value="service_' + s.id + '"' + selected + '>' + escapeHtml(s.translated_title || s.title) + '</option>';
            })
        ).join('');

        const html =
            '<form class="ai-inline-form space-y-2" data-form-kind="contact" novalidate>' +
            '<p class="text-sm font-bold mb-1">Send a Message</p>' +
            formFieldHtml('What can we help you with?', '<select name="help_with" required class="' + FIELD_CLS + '">' + options + '</select>', true) +
            '<div class="grid grid-cols-2 gap-2">' +
            formFieldHtml('First name', '<input type="text" name="first_name" required class="' + FIELD_CLS + '" placeholder="John">', true) +
            formFieldHtml('Last name', '<input type="text" name="last_name" required class="' + FIELD_CLS + '" placeholder="Doe">', true) +
            '</div>' +
            formFieldHtml('Email', '<input type="email" name="email" required class="' + FIELD_CLS + '" placeholder="you@example.com">', true) +
            formFieldHtml('Phone number', '<input type="tel" name="phone" required class="' + FIELD_CLS + '" placeholder="+966 ...">', true) +
            formFieldHtml('Additional information', '<textarea name="additional_info" rows="2" class="' + FIELD_CLS + '" placeholder="Tell us more (optional)"></textarea>', false) +
            '<label class="flex items-start gap-2 text-xs text-slate-600 dark:text-slate-400"><input type="checkbox" name="privacy_consent" value="1" required class="mt-0.5"> I agree to the privacy policy.</label>' +
            '<p class="ai-form-error text-xs text-red-500 hidden"></p>' +
            '<button type="submit" class="w-full bg-primary text-white text-sm font-semibold rounded-lg py-2 hover:bg-primary/90 transition">Send Message</button>' +
            '</form>';
        addMessage(html);
    }

    // Same job application form the Careers page uses (posts to the same endpoint).
    function showJobForm(presetJobId) {
        if (!CHAT_JOBS.length) {
            addMessage('There are no open positions right now. Check the <strong>Careers</strong> page later or send a general message via the contact form.');
            showContactForm(null);
            return;
        }

        const options = CHAT_JOBS.map(function (j) {
            const selected = presetJobId === j.id ? ' selected' : '';
            const meta = [j.department, j.location].filter(Boolean).join(' · ');
            return '<option value="' + j.id + '"' + selected + '>' + escapeHtml(j.title + (meta ? ' (' + meta + ')' : '')) + '</option>';
        }).join('');

        const html =
            '<form class="ai-inline-form space-y-2" data-form-kind="job" enctype="multipart/form-data" novalidate>' +
            '<p class="text-sm font-bold mb-1">Job Application</p>' +
            formFieldHtml('Position', '<select name="job_id" required class="' + FIELD_CLS + '">' + options + '</select>', true) +
            '<div class="grid grid-cols-2 gap-2">' +
            formFieldHtml('First name', '<input type="text" name="first_name" required class="' + FIELD_CLS + '" placeholder="John">', true) +
            formFieldHtml('Last name', '<input type="text" name="last_name" required class="' + FIELD_CLS + '" placeholder="Doe">', true) +
            '</div>' +
            formFieldHtml('Email', '<input type="email" name="email" required class="' + FIELD_CLS + '" placeholder="you@example.com">', true) +
            formFieldHtml('Phone number', '<input type="tel" name="phone" required class="' + FIELD_CLS + '" placeholder="+966 ...">', true) +
            formFieldHtml('Cover letter', '<textarea name="cover_letter" rows="2" class="' + FIELD_CLS + '" placeholder="Why are you a great fit? (optional)"></textarea>', false) +
            formFieldHtml('Resume (PDF/DOC, max 2MB)', '<input type="file" name="resume" accept=".pdf,.doc,.docx" class="' + FIELD_CLS + ' text-xs">', false) +
            '<label class="flex items-start gap-2 text-xs text-slate-600 dark:text-slate-400"><input type="checkbox" name="privacy_consent" value="1" required class="mt-0.5"> I agree to the privacy policy.</label>' +
            '<p class="ai-form-error text-xs text-red-500 hidden"></p>' +
            '<button type="submit" class="w-full bg-primary text-white text-sm font-semibold rounded-lg py-2 hover:bg-primary/90 transition">Submit Application</button>' +
            '</form>';
        addMessage(html);
    }

    function startLeadCapture(kind, text, api, matched) {
        leadData.message = text || '';
        leadData.intent = kind;
        if (kind === 'careers') {
            addMessage('Great — here is the same <strong>job application form</strong> as on our Careers page. Fill it in and I will send it straight to HR.');
            showJobForm(CHAT_JOBS.length === 1 ? CHAT_JOBS[0].id : null);
        } else {
            let preset = null;
            if (api?.service_id) preset = { serviceId: api.service_id };
            else if (matched) preset = { serviceId: matched.id };
            addMessage('Sure — here is the same <strong>contact form</strong> as on our website. Fill it in and our team will follow up.');
            showContactForm(preset);
        }
    }

    async function fetchAnswerFromDatabase(text) {
        const token = csrfToken();
        if (!token) return null;
        try {
            const res = await fetch(ANSWER_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ message: text }),
            });
            if (!res.ok) return null;
            return await res.json();
        } catch (e) {
            console.error('Chatbot answer failed', e);
            return null;
        }
    }

    function setFormError(form, message) {
        const errEl = form.querySelector('.ai-form-error');
        if (!errEl) return;
        errEl.textContent = message || '';
        errEl.classList.toggle('hidden', !message);
    }

    async function submitInlineForm(form) {
        const kind = form.getAttribute('data-form-kind');
        setFormError(form, '');

        const requiredFields = form.querySelectorAll('[required]');
        for (const field of requiredFields) {
            if (field.type === 'checkbox' ? !field.checked : !String(field.value || '').trim()) {
                setFormError(form, field.type === 'checkbox' ? 'Please accept the privacy policy.' : 'Please fill in all required fields.');
                return;
            }
        }

        const emailField = form.querySelector('[name="email"]');
        if (emailField && (!emailField.value.includes('@') || !emailField.value.includes('.'))) {
            setFormError(form, 'Please enter a valid email address.');
            return;
        }

        const formData = new FormData(form);
        let url = CONTACT_URL;
        if (kind === 'job') {
            url = JOB_URL;
            const jobSelect = form.querySelector('[name="job_id"]');
            formData.append('job_position', jobSelect?.selectedOptions[0]?.textContent || '');
            const resume = form.querySelector('[name="resume"]');
            if (resume?.files[0] && resume.files[0].size > 2 * 1024 * 1024) {
                setFormError(form, 'Resume file size must not exceed 2MB.');
                return;
            }
        } else {
            const helpSelect = form.querySelector('[name="help_with"]');
            formData.append('service_type', helpSelect?.selectedOptions[0]?.textContent || 'Chatbot Lead');
            formData.set('additional_info', (formData.get('additional_info') || '') + '\n\n[Submitted via AI Assistant]');
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalLabel = submitBtn ? submitBtn.textContent : '';
        if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Sending…'; }

        try {
            const token = csrfToken();
            if (!token) throw new Error('Missing CSRF token');
            const res = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            });
            const data = await res.json().catch(function () { return {}; });

            if (!res.ok || data.success === false) {
                const firstError = data.errors ? Object.values(data.errors)[0]?.[0] : null;
                setFormError(form, firstError || data.message || 'Something went wrong. Please try again or use the website form.');
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalLabel; }
                return;
            }

            form.querySelectorAll('input, select, textarea, button').forEach(function (el) { el.disabled = true; });
            if (submitBtn) submitBtn.textContent = 'Sent ✓';
            if (kind === 'job') {
                addMessage('Your application has been submitted to HR — the same as applying on the <strong>Careers</strong> page. We\'ll be in touch soon!');
            } else {
                addMessage("Your message has been sent — the same as the website's contact form. Our team will follow up shortly!");
            }
        } catch (e) {
            console.error('Chatbot form submission failed', e);
            setFormError(form, 'We could not send your request right now. Please try again shortly.');
            if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalLabel; }
        }
    }

    async function processUserMessage(text) {
        const { chatInput } = getEls();
        if (!text) return;

        addMessage(escapeHtml(text), true);
        hideSuggestions();

        showTypingIndicator();

        setTimeout(async function () {
            removeTypingIndicator();

            const api = await fetchAnswerFromDatabase(text);
            const intent = api?.intent || detectIntent(text);
            const reply = api?.html || 'Ask about any service, say <em>contact me</em>, or ask <em>what jobs are open</em>.';
            const matched = matchService(text);
            const startLead = wantsContactFlow(text) || wantsCareerLead(text) || intent === 'contact' || intent === 'pricing' || intent === 'careers' && wantsCareerLead(text);

            if (wantsCareerLead(text) || (intent === 'careers' && /\b(apply|cv|resume|interest)\b/i.test(text))) {
                if (api?.html && !wantsCareerLead(text)) addMessage(reply);
                startLeadCapture('careers', text, api, matched);
                return;
            }

            if (startLead && intent !== 'careers') {
                if (intent === 'pricing' && reply) addMessage(reply);
                startLeadCapture('contact', text, api, matched);
                return;
            }

            // A list-type question shows just the service names as options;
            // details (with picture) appear after the user picks one.
            if (isServicesListQuery(text)) {
                addServicePicker();
                return;
            }

            addMessage(reply);
            if (api?.service_id && api?.service_title) {
                leadData.serviceType = api.service_title;
                leadData.helpWith = 'service_' + api.service_id;
                addServiceCta(api.service_id, api.service_title);
            } else if (matched) {
                leadData.serviceType = matched.translated_title || matched.title;
                leadData.helpWith = 'service_' + matched.id;
                addServiceCta(matched.id, matched.translated_title || matched.title);
            } else if (intent === 'service') {
                addServicePicker();
            }
        }, 450);
    }

    function isServicesListQuery(text) {
        const t = String(text || '').toLowerCase();
        if (/\b(all|what|which|list|show|your|our)\b[^?]*\bservices?\b/.test(t)) return true;
        if (/\bservices?\b[^?]*\b(offer|offered|available|provide|provided|list)\b/.test(t)) return true;
        return /^\s*services?\s*\??\s*$/.test(t);
    }

    // Offer a shortcut to the contact form pre-filled with the discussed service.
    function addServiceCta(serviceId, serviceTitle) {
        addMessage(
            '<span class="block mb-2">Interested in <strong>' + escapeHtml(serviceTitle) + '</strong>?</span>' +
            '<button type="button" class="ai-chat-suggestion ai-service-cta" data-service-id="' + serviceId + '">Request this service — open contact form</button>'
        );
    }

    // Name-only options; picking one shows the details card.
    function addServicePicker() {
        if (!CHAT_SERVICES.length) return;
        const buttons = CHAT_SERVICES.map(function (s) {
            return '<button type="button" class="ai-chat-suggestion ai-service-pick" data-service-id="' + s.id + '">' + escapeHtml(s.translated_title || s.title) + '</button>';
        }).join(' ');
        addMessage('<span class="block mb-2">Here are our services — select one to see the details:</span><span class="flex flex-wrap gap-1.5">' + buttons + '</span>');
    }

    // Details card: picture + description from the database + contact form shortcut.
    async function showServiceDetails(serviceId) {
        const service = CHAT_SERVICES.find(function (s) { return s.id === serviceId; });
        if (!service) return;
        const title = service.translated_title || service.title;

        addMessage(escapeHtml(title), true);
        showTypingIndicator();

        const api = await fetchAnswerFromDatabase('Tell me about ' + (service.title || title));
        removeTypingIndicator();

        const imageHtml = service.image
            ? '<img src="' + escapeHtml(service.image) + '" alt="' + escapeHtml(title) + '" class="w-full h-32 object-cover rounded-lg mb-2" loading="lazy" onerror="this.remove()">'
            : '';
        const detailHtml = api?.html || ('<strong>' + escapeHtml(title) + '</strong><br>' + escapeHtml(service.description || service.intro_text || ''));

        addMessage(imageHtml + detailHtml);

        leadData.serviceType = title;
        leadData.helpWith = 'service_' + service.id;
        addServiceCta(service.id, title);
    }

    function bindUi() {
        pinChatbotToViewport();
        const { closeBtn, newChatBtn, chatForm, chatInput, messagesArea } = getEls();

        initialMessagesHtml = messagesArea ? messagesArea.innerHTML : '';

        closeBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            setChatOpen(false);
        });

        newChatBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            resetChat();
        });

        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('[data-open-ai-chat]');
            if (!trigger) return;
            e.preventDefault();
            window.toggle9AAssistant();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isChatOpen) setChatOpen(false);
        });

        // Delegated so suggestion buttons keep working after a chat reset
        // restores the initial messages HTML.
        messagesArea?.addEventListener('click', function (e) {
            const pick = e.target.closest('.ai-service-pick');
            if (pick) {
                showServiceDetails(parseInt(pick.getAttribute('data-service-id'), 10));
                return;
            }
            const cta = e.target.closest('.ai-service-cta');
            if (cta) {
                const serviceId = parseInt(cta.getAttribute('data-service-id'), 10);
                const service = CHAT_SERVICES.find(function (s) { return s.id === serviceId; });
                const title = service ? (service.translated_title || service.title) : 'this service';
                addMessage('Here is the contact form with <strong>' + escapeHtml(title) + '</strong> already selected:');
                showContactForm({ serviceId: serviceId });
                return;
            }
            const btn = e.target.closest('.ai-chat-suggestion');
            if (!btn) return;
            const question = btn.getAttribute('data-question') || btn.textContent || '';
            processUserMessage(question.trim());
        });

        messagesArea?.addEventListener('submit', function (e) {
            const form = e.target.closest('.ai-inline-form');
            if (!form) return;
            e.preventDefault();
            submitInlineForm(form);
        });

        chatForm?.addEventListener('submit', function (e) {
            e.preventDefault();
            const text = (chatInput?.value || '').trim();
            if (!text) return;
            chatInput.value = '';
            processUserMessage(text);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindUi);
    } else {
        bindUi();
    }

    window.addEventListener('load', pinChatbotToViewport);
    window.addEventListener('resize', pinChatbotToViewport, { passive: true });
})();
</script>
