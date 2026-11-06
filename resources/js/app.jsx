import './bootstrap';
import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import ContactModal from './components/ContactModal';
import JobApplicationModal from './components/JobApplicationModal';

window.openContactModal = window.openContactModal || function (serviceType = '') {
    window.__contactModalQueue = window.__contactModalQueue || [];
    window.__contactModalQueue.push(serviceType);
};

window.openJobApplicationModal = window.openJobApplicationModal || function (jobId = null) {
    window.__jobApplicationModalQueue = window.__jobApplicationModalQueue || [];
    window.__jobApplicationModalQueue.push(jobId);
};

function parseJsonData(value, fallback = []) {
    if (!value) {
        return fallback;
    }

    try {
        return JSON.parse(value);
    } catch (error) {
        console.warn('React init: failed to parse JSON data', error);
        return fallback;
    }
}

function App() {
    const rootEl = document.getElementById('react-root');
    const allServices = parseJsonData(rootEl?.dataset.allServices, []);
    const allJobs = parseJsonData(rootEl?.dataset.allJobs, []);
    const contactSubmitUrl = rootEl?.dataset.contactSubmitUrl || '/contact/form/submit';
    const jobSubmitUrl = rootEl?.dataset.jobSubmitUrl || '/careers/application/submit';

    const [isContactOpen, setIsContactOpen] = useState(false);
    const [isJobOpen, setIsJobOpen] = useState(false);
    const [contactPresetValue, setContactPresetValue] = useState('');
    const [jobPresetId, setJobPresetId] = useState(null);

    const openContact = (serviceType = '') => {
        const value = String(serviceType || '');
        if (typeof window.showSiteContactModal === 'function') {
            window.showSiteContactModal(value);
            return;
        }
        setContactPresetValue(value);
        setIsContactOpen(true);
    };

    useEffect(() => {
        window.__contactModalReady = true;
        window.openContactModal = openContact;
        window.closeContactModal = () => setIsContactOpen(false);
        window.openJobApplicationModal = (jobId = null) => {
            setJobPresetId(jobId);
            setIsJobOpen(true);
        };
        window.closeJobApplicationModal = () => setIsJobOpen(false);

        const queued = window.__contactModalQueue || [];
        if (queued.length) {
            openContact(queued[queued.length - 1]);
            window.__contactModalQueue = [];
        }

        const jobQueued = window.__jobApplicationModalQueue || [];
        if (jobQueued.length) {
            openJobApplicationModal(jobQueued[jobQueued.length - 1]);
            window.__jobApplicationModalQueue = [];
        }

        const onContactRequest = (event) => {
            openContact(event.detail ?? '');
        };
        window.addEventListener('contact-modal-request', onContactRequest);

        return () => {
            window.__contactModalReady = false;
            delete window.openContactModal;
            delete window.closeContactModal;
            delete window.openJobApplicationModal;
            delete window.closeJobApplicationModal;
            window.removeEventListener('contact-modal-request', onContactRequest);
        };
    }, []);

    useEffect(() => {
        document.body.classList.toggle('overflow-hidden', isContactOpen || isJobOpen);
    }, [isContactOpen, isJobOpen]);

    return (
        <>
            <ContactModal
                isOpen={isContactOpen}
                onClose={() => setIsContactOpen(false)}
                initialServiceType={contactPresetValue}
                allServices={allServices}
                submitUrl={contactSubmitUrl}
            />
            <JobApplicationModal
                isOpen={isJobOpen}
                onClose={() => setIsJobOpen(false)}
                initialJobId={jobPresetId}
                allJobs={allJobs}
                submitUrl={jobSubmitUrl}
            />
        </>
    );
}

const container = document.getElementById('react-root');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
