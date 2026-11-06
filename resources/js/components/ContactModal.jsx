import React, { useEffect, useMemo, useState } from 'react';
import { createPortal } from 'react-dom';

const getServiceOptions = (services) => [
    { value: '', label: 'Please select' },
    ...services.map((service) => ({
        value: `service_${service.id}`,
        label: service.translated_title || service.title || `Service ${service.id}`,
        serviceId: service.id,
        serviceTitle: service.translated_title || service.title || '',
    })),
    { value: 'management', label: 'Contact management' },
    { value: 'other', label: 'Other' },
];

const ModalShell = ({ isOpen, onClose, title, children }) => {
    if (!isOpen) return null;

    return createPortal(
        <div className="fixed inset-0 z-[100050] flex items-center justify-center p-4 sm:p-6 overflow-hidden overscroll-contain">
            <div className="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onClick={onClose} />
            <div className="relative z-10 w-full max-w-[min(95vw,900px)] max-h-[min(95vh,900px)] min-h-0 flex flex-col overflow-hidden rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-700">
                <div className="flex-shrink-0 sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800/80 bg-white dark:bg-slate-900 px-4 py-4">
                    <h2 className="text-xl font-bold text-navy-deep dark:text-white">{title}</h2>
                    <button type="button" onClick={onClose} className="rounded-full p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors">
                        <span className="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>
                <div className="flex-1 min-h-0 p-6 sm:p-8 overflow-y-auto overflow-x-hidden custom-scrollbar overscroll-contain">{children}</div>
            </div>
        </div>,
        document.body
    );
};

const InputError = ({ message }) => {
    if (!message) return null;
    return <p className="mt-1 text-sm text-red-600">{message}</p>;
};

const ContactModal = ({ isOpen, onClose, allServices, initialServiceType, submitUrl }) => {
    const [helpWith, setHelpWith] = useState('');
    const [serviceType, setServiceType] = useState('');
    const [subService, setSubService] = useState('');
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [email, setEmail] = useState('');
    const [phone, setPhone] = useState('');
    const [additionalInfo, setAdditionalInfo] = useState('');
    const [file, setFile] = useState(null);
    const [fileName, setFileName] = useState('No file chosen');
    const [privacyConsent, setPrivacyConsent] = useState(false);
    const [errors, setErrors] = useState({});
    const [status, setStatus] = useState(null);
    const helpWithOptions = getServiceOptions(allServices);

    const selectedService = useMemo(() => {
        if (!helpWith?.startsWith('service_')) {
            return null;
        }

        const id = Number(helpWith.split('_')[1]);
        return allServices.find((service) => Number(service.id) === id) || null;
    }, [helpWith, allServices]);

    const subServiceOptions = useMemo(() => {
        const list = selectedService?.activeSubServices || [];
        return list.map((subServiceItem) => ({
            value: `sub_service_${subServiceItem.id}`,
            label: subServiceItem.title || subServiceItem.translated_title || `Sub-service ${subServiceItem.id}`,
        }));
    }, [selectedService]);

    useEffect(() => {
        if (isOpen) {
            setStatus(null);
            setErrors({});
            setHelpWith(String(initialServiceType || ''));
        }
    }, [isOpen, initialServiceType]);

    useEffect(() => {
        if (!isOpen) {
            return;
        }

        if (helpWith && !helpWith.startsWith('service_')) {
            setSubService('');
        }
    }, [helpWith, isOpen]);

    const resetForm = () => {
        setHelpWith('');
        setSubService('');
        setFirstName('');
        setLastName('');
        setEmail('');
        setPhone('');
        setAdditionalInfo('');
        setFile(null);
        setFileName('No file chosen');
        setPrivacyConsent(false);
        setErrors({});
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        setStatus(null);
        setErrors({});

        if (!helpWith) {
            setErrors((prev) => ({ ...prev, help_with: 'Please select a reason for contact.' }));
            return;
        }

        if (!firstName || !lastName || !email || !phone || !privacyConsent) {
            const newErrors = {};
            if (!firstName) newErrors.first_name = 'First name is required.';
            if (!lastName) newErrors.last_name = 'Last name is required.';
            if (!email) newErrors.email = 'Email is required.';
            if (!phone) newErrors.phone = 'Phone number is required.';
            if (!privacyConsent) newErrors.privacy_consent = 'Please accept the privacy terms.';
            setErrors(newErrors);
            return;
        }

        if (subServiceOptions.length > 0 && !subService) {
            setErrors((prev) => ({ ...prev, sub_service: 'Please select a sub-service.' }));
            return;
        }

        const formData = new FormData();
        formData.append('help_with', helpWith);
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('additional_info', additionalInfo);
        formData.append('privacy_consent', privacyConsent ? '1' : '0');
        formData.append('service_type', selectedService?.translated_title || serviceType || helpWith || 'N/A');
        formData.append('sub_service', subService || '');

        if (file) {
            formData.append('file', file);
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        try {
            const response = await fetch(submitUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin',
            });

            const payload = await response.json();

            if (!response.ok || !payload.success) {
                if (payload.errors) {
                    setErrors(payload.errors);
                }

                setStatus({
                    type: 'error',
                    message: payload.message || 'Unable to send your message. Please try again.',
                });
                return;
            }

            setStatus({
                type: 'success',
                message: payload.message || 'Message sent successfully!',
            });

            resetForm();
            setTimeout(() => {
                onClose();
            }, 1800);
        } catch (error) {
            console.error('Contact submit failed', error);
            setStatus({
                type: 'error',
                message: 'An unexpected error occurred. Please try again later.',
            });
        }
    };

    const handleFileChange = (event) => {
        const selectedFile = event.target.files?.[0] || null;
        setFile(selectedFile);
        setFileName(selectedFile?.name || 'No file chosen');
    };

    return (
        <ModalShell isOpen={isOpen} onClose={onClose} title="Send a Message">
            <form className="form-shell-elevated space-y-4 max-w-full overflow-x-hidden" onSubmit={handleSubmit}>
                <div>
                    <label htmlFor="help_with" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                        What can we help you with? <span className="text-red-500">*</span>
                    </label>
                    <select
                        id="help_with"
                        value={helpWith}
                        onChange={(event) => setHelpWith(event.target.value)}
                        className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                    >
                        {helpWithOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                    <InputError message={errors.help_with} />
                </div>
                {subServiceOptions.length > 0 && (
                    <div>
                        <label htmlFor="sub_service" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                            Select sub-service <span className="text-red-500">*</span>
                        </label>
                        <select
                            id="sub_service"
                            value={subService}
                            onChange={(event) => setSubService(event.target.value)}
                            className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                        >
                            <option value="">Please select</option>
                            {subServiceOptions.map((option) => (
                                <option key={option.value} value={option.value}>
                                    {option.label}
                                </option>
                            ))}
                        </select>
                        <InputError message={errors.sub_service} />
                    </div>
                )}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label htmlFor="first_name" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                            First name <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="first_name"
                            value={firstName}
                            onChange={(event) => setFirstName(event.target.value)}
                            className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                        />
                        <InputError message={errors.first_name} />
                    </div>
                    <div>
                        <label htmlFor="last_name" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                            Last name <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="last_name"
                            value={lastName}
                            onChange={(event) => setLastName(event.target.value)}
                            className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                        />
                        <InputError message={errors.last_name} />
                    </div>
                </div>
                <div>
                    <label htmlFor="email" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                        Email <span className="text-red-500">*</span>
                    </label>
                    <input
                        id="email"
                        type="email"
                        value={email}
                        onChange={(event) => setEmail(event.target.value)}
                        className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                    />
                    <InputError message={errors.email} />
                </div>
                <div>
                    <label htmlFor="phone" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                        Phone number <span className="text-red-500">*</span>
                    </label>
                    <input
                        id="phone"
                        type="tel"
                        value={phone}
                        onChange={(event) => setPhone(event.target.value)}
                        className="w-full min-w-0 max-w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent box-border"
                    />
                    <InputError message={errors.phone} />
                </div>
                <div>
                    <label htmlFor="additional_info" className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                        Additional information
                    </label>
                    <textarea
                        id="additional_info"
                        rows="4"
                        value={additionalInfo}
                        onChange={(event) => setAdditionalInfo(event.target.value)}
                        className="w-full px-4 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-navy-deep dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                    />
                </div>
                <div>
                    <label className="block text-sm font-bold text-navy-deep dark:text-white mb-2">
                        Additional file
                    </label>
                    <div className="flex items-center gap-2">
                        <label
                            htmlFor="file"
                            className="inline-flex cursor-pointer items-center rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2 text-sm font-medium text-navy-deep dark:text-white transition hover:bg-gray-50 dark:hover:bg-slate-700"
                        >
                            Choose file
                        </label>
                        <span className="text-sm text-gray-600 dark:text-gray-400">{fileName}</span>
                    </div>
                    <input
                        id="file"
                        type="file"
                        accept=".pdf,.doc,.docx,.txt"
                        className="hidden"
                        onChange={handleFileChange}
                    />
                </div>
                <div className="flex items-start gap-2">
                    <input
                        id="privacy_consent"
                        type="checkbox"
                        checked={privacyConsent}
                        onChange={(event) => setPrivacyConsent(event.target.checked)}
                        className="mt-1 h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                    />
                    <label htmlFor="privacy_consent" className="text-sm text-gray-700 dark:text-gray-300">
                        I agree to the privacy policy.
                    </label>
                </div>
                <InputError message={errors.privacy_consent} />
                {status && (
                    <div
                        className={`p-3 rounded ${status.type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`}
                    >
                        {status.message}
                    </div>
                )}
                <div className="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <button
                        type="button"
                        onClick={() => {
                            resetForm();
                            onClose();
                        }}
                        className="w-full sm:w-auto rounded-lg border border-gray-300 bg-white px-6 py-3 text-navy-deep dark:border-slate-700 dark:bg-slate-800 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700 font-bold transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        className="primary-action w-full sm:w-auto rounded-lg bg-primary px-6 py-3 text-white font-bold hover:bg-primary/90 transition"
                    >
                        Send
                    </button>
                </div>
            </form>
        </ModalShell>
    );
};

export default ContactModal;
