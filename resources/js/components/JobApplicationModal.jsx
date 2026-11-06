import React, { useEffect, useMemo, useState } from 'react';
import { createPortal } from 'react-dom';

const ModalShell = ({ isOpen, onClose, title, children }) => {
    if (!isOpen) return null;

    return createPortal(
        <div className="fixed inset-0 z-[100050] flex items-center justify-center p-4 sm:p-6 overflow-hidden overscroll-contain">
            <div className="absolute inset-0 bg-slate-950/60 backdrop-blur-md transition-opacity" onClick={onClose} />
            <div className="relative z-10 w-full max-w-[min(95vw,900px)] max-h-[min(95vh,900px)] min-h-0 flex flex-col overflow-hidden rounded-[2rem] bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl shadow-2xl border border-white/50 dark:border-slate-700/50 animate-in fade-in zoom-in-95 duration-300">
                <div className="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent dark:via-white/10 z-30"></div>
                <div className="flex-shrink-0 sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-slate-200/50 dark:border-slate-800/50 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md px-6 py-5">
                    <h2 className="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-navy-deep to-primary dark:from-white dark:to-slate-300">{title}</h2>
                    <button type="button" onClick={onClose} className="rounded-full p-2 text-slate-500 hover:bg-slate-200/50 dark:text-slate-400 dark:hover:bg-slate-800/50 transition-colors">
                        <span className="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>
                <div className="flex-1 min-h-0 p-6 sm:p-8 md:p-10 overflow-y-auto overflow-x-hidden custom-scrollbar overscroll-contain">{children}</div>
            </div>
        </div>,
        document.body
    );
};

const InputError = ({ message }) => {
    if (!message) return null;
    return <p className="mt-1 text-sm text-red-600">{message}</p>;
};

const JobApplicationModal = ({ isOpen, onClose, initialJobId, allJobs, submitUrl }) => {
    const [jobId, setJobId] = useState(null);
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [email, setEmail] = useState('');
    const [phone, setPhone] = useState('');
    const [coverLetter, setCoverLetter] = useState('');
    const [resumeFile, setResumeFile] = useState(null);
    const [resumeName, setResumeName] = useState('No file chosen');
    const [privacyConsent, setPrivacyConsent] = useState(false);
    const [errors, setErrors] = useState({});
    const [status, setStatus] = useState(null);

    const jobOptions = useMemo(
        () => [
            { value: '', label: 'Please select' },
            ...allJobs.map((job) => ({
                value: `job_${job.id}`,
                label: `${job.title} - ${job.department || 'General'} (${job.location || 'Remote'})`,
                jobId: job.id,
            })),
        ],
        [allJobs]
    );

    useEffect(() => {
        if (isOpen) {
            setStatus(null);
            setErrors({});
            setJobId(initialJobId || null);
        }
    }, [isOpen, initialJobId]);

    const selectedJob = useMemo(() => {
        if (!jobId) return null;
        return allJobs.find((job) => Number(job.id) === Number(jobId)) || null;
    }, [jobId, allJobs]);

    const resetForm = () => {
        setJobId(null);
        setFirstName('');
        setLastName('');
        setEmail('');
        setPhone('');
        setCoverLetter('');
        setResumeFile(null);
        setResumeName('No file chosen');
        setPrivacyConsent(false);
        setErrors({});
    };

    const handleResumeChange = (event) => {
        const file = event.target.files?.[0] || null;
        setResumeFile(file);
        setResumeName(file?.name || 'No file chosen');
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        setStatus(null);
        setErrors({});

        if (!jobId || !firstName || !lastName || !email || !phone || !privacyConsent) {
            const newErrors = {};
            if (!jobId) newErrors.job_position = 'Please select a job position.';
            if (!firstName) newErrors.first_name = 'First name is required.';
            if (!lastName) newErrors.last_name = 'Last name is required.';
            if (!email) newErrors.email = 'Email is required.';
            if (!phone) newErrors.phone = 'Phone number is required.';
            if (!privacyConsent) newErrors.privacy_consent = 'Please accept the privacy terms.';
            setErrors(newErrors);
            return;
        }

        const formData = new FormData();
        formData.append('job_id', selectedJob?.id || jobId);
        formData.append('job_position', selectedJob?.title || 'N/A');
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('cover_letter', coverLetter);
        formData.append('privacy_consent', privacyConsent ? '1' : '0');
        if (resumeFile) {
            formData.append('resume', resumeFile);
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
                    message: payload.message || 'Unable to submit application. Please try again.',
                });
                return;
            }

            setStatus({
                type: 'success',
                message: payload.message || 'Application submitted successfully!',
            });
            resetForm();
            setTimeout(() => onClose(), 1800);
        } catch (error) {
            console.error('Job submission failed', error);
            setStatus({
                type: 'error',
                message: 'An unexpected error occurred while submitting your application.',
            });
        }
    };

    return (
        <ModalShell isOpen={isOpen} onClose={onClose} title="Job Application">
            <form className="space-y-6 max-w-full overflow-hidden" onSubmit={handleSubmit}>
                <div className="relative group/input">
                    <label htmlFor="job_position" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                        Job position <span className="text-red-500">*</span>
                    </label>
                    <div className="relative">
                        <select
                            id="job_position"
                            value={jobId ? `job_${jobId}` : ''}
                            onChange={(event) => {
                                const value = event.target.value;
                                setJobId(value ? Number(value.replace('job_', '')) : null);
                            }}
                            className="w-full appearance-none box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none cursor-pointer"
                        >
                            {jobOptions.map((option) => (
                                <option key={option.value} value={option.value}>
                                    {option.label}
                                </option>
                            ))}
                        </select>
                        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-slate-500">
                            <span className="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>
                    <InputError message={errors.job_position} />
                </div>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 min-w-0">
                    <div className="relative group/input">
                        <label htmlFor="job_first_name" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                            First name <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="job_first_name"
                            value={firstName}
                            onChange={(event) => setFirstName(event.target.value)}
                            className="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none"
                        />
                        <InputError message={errors.first_name} />
                    </div>
                    <div className="relative group/input">
                        <label htmlFor="job_last_name" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                            Last name <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="job_last_name"
                            value={lastName}
                            onChange={(event) => setLastName(event.target.value)}
                            className="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none"
                        />
                        <InputError message={errors.last_name} />
                    </div>
                </div>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 min-w-0">
                    <div className="relative group/input">
                        <label htmlFor="job_email" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                            Email <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="job_email"
                            type="email"
                            value={email}
                            onChange={(event) => setEmail(event.target.value)}
                            className="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none"
                        />
                        <InputError message={errors.email} />
                    </div>
                    <div className="relative group/input">
                        <label htmlFor="job_phone" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                            Phone number <span className="text-red-500">*</span>
                        </label>
                        <input
                            id="job_phone"
                            type="tel"
                            value={phone}
                            onChange={(event) => setPhone(event.target.value)}
                            className="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none"
                        />
                        <InputError message={errors.phone} />
                    </div>
                </div>
                <div className="relative group/input">
                    <label htmlFor="cover_letter" className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                        Cover letter
                    </label>
                    <textarea
                        id="cover_letter"
                        rows="4"
                        value={coverLetter}
                        onChange={(event) => setCoverLetter(event.target.value)}
                        className="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none resize-y"
                    />
                </div>
                <div className="relative group/input">
                    <label className="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">
                        Resume / CV
                    </label>
                    <div 
                        className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-800/30 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-colors cursor-pointer"
                        onClick={() => document.getElementById('job_resume').click()}
                    >
                        <div className="space-y-1 text-center">
                            <span className="material-symbols-outlined text-4xl text-slate-400 dark:text-slate-500 mb-2 block">cloud_upload</span>
                            <div className="flex flex-col sm:flex-row text-sm text-slate-600 dark:text-slate-400 items-center justify-center gap-1">
                                <label
                                    htmlFor="job_resume"
                                    className="relative cursor-pointer rounded-md bg-transparent font-medium text-primary hover:text-indigo-500 focus-within:outline-none"
                                >
                                    <span>Upload a file</span>
                                    <input
                                        id="job_resume"
                                        type="file"
                                        accept=".pdf,.doc,.docx"
                                        className="sr-only"
                                        onChange={handleResumeChange}
                                    />
                                </label>
                                <p className="pl-1">or drag and drop</p>
                            </div>
                            <p className="text-xs text-slate-500 dark:text-slate-500">PDF or Word doc up to 5MB</p>
                            <p className="text-sm font-semibold text-primary mt-2">{resumeName}</p>
                        </div>
                    </div>
                </div>
                <div className="flex items-start gap-3 min-w-0 pt-2">
                    <div className="flex items-center h-5 mt-0.5">
                        <input
                            id="job_privacy_consent"
                            type="checkbox"
                            checked={privacyConsent}
                            onChange={(event) => setPrivacyConsent(event.target.checked)}
                            className="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 bg-slate-50 dark:bg-slate-800 dark:border-slate-600 transition-colors cursor-pointer"
                        />
                    </div>
                    <label htmlFor="job_privacy_consent" className="text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                        I agree to the privacy policy and consent to having this website store my submitted information.
                    </label>
                </div>
                <InputError message={errors.privacy_consent} />
                {status && (
                    <div
                        className={`p-4 rounded-xl border ${status.type === 'success' ? 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800' : 'bg-red-50 border-red-200 text-red-700 dark:bg-red-900/20 dark:border-red-800'}`}
                    >
                        {status.message}
                    </div>
                )}
                <div className="flex flex-col sm:flex-row justify-end gap-4 pt-6">
                    <button
                        type="button"
                        onClick={() => {
                            resetForm();
                            onClose();
                        }}
                        className="w-full sm:w-auto rounded-xl border-2 border-slate-200 bg-transparent px-8 py-4 text-slate-600 dark:border-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 font-bold transition-colors"
                    >
                        Cancel
                    </button>
                    <button type="submit" className="relative overflow-hidden w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-primary to-indigo-600 px-10 py-4 text-white font-bold tracking-wide hover:from-primary/90 hover:to-indigo-600/90 hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-xl shadow-primary/30 group/btn">
                        <span className="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                        <span className="relative">Submit Application</span>
                        <span className="material-symbols-outlined text-xl relative group-hover/btn:translate-x-1 transition-transform">send</span>
                    </button>
                </div>
            </form>
        </ModalShell>
    );
};

export default JobApplicationModal;
