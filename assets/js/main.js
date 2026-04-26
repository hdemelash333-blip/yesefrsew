        (function() {
            // DOM Elements
            const menuToggle = document.getElementById('menuToggle');
            const navLinks = document.getElementById('navLinks');
            const scrollTopBtn = document.getElementById('scrollTop');
            const toast = document.getElementById('toastNotification');
            const modal = document.getElementById('dynamicModal');
            const modalBody = document.getElementById('modalBody');
            const modalClose = document.getElementById('modalCloseBtn');

            // Helper Functions
            function showToast(message) {
                if(toast){
                    toast.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 3000);
                }
            }

            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Modal Management - No automatic form listener attached here
            function openModal(contentHTML, submitHandler) {
                modalBody.innerHTML = contentHTML;
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';

                // Attach the specific submit handler for this modal instance
                const form = modalBody.querySelector('form');
                if(form && submitHandler) {
                    form.addEventListener('submit', submitHandler);
                }
            }

            // Generic modal submit handler that prevents default and shows success
            function createSubmitHandler(successMessage, additionalCallback) {
                return function(e) {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    const name = formData.get('name') || 'Guest';
                    const email = formData.get('email');

                    if(email) {
                        // Save to localStorage for demonstration
                        let subscribers = JSON.parse(localStorage.getItem('yesefersew_subs') || '[]');
                        if(!subscribers.includes(email)) {
                            subscribers.push(email);
                            localStorage.setItem('yesefersew_subs', JSON.stringify(subscribers));
                        }

                        showToast(`✨ Thank you ${name}! ${successMessage}`);
                        closeModal();

                        if(additionalCallback) additionalCallback(formData);
                    } else {
                        showToast('Please provide a valid email address.');
                    }
                };
            }

            // Subscribe Modal
            function showSubscribeModal() {
                const content = `<h3><i class="fas fa-envelope-open-text" style="color: var(--secondary);"></i> Subscribe to YESEFERSEW</h3>
                                <p>Get journal issues, newsletters, and biennial updates directly to your inbox.</p>
                                <form id="modalSubscribeForm">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" placeholder="Your name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" placeholder="you@example.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Preference</label>
                                        <select name="interest">
                                            <option>Journal & Newsletter (Monthly)</option>
                                            <option>Biennial Announcements Only</option>
                                            <option>Opportunities & Open Calls</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary modal-btn">Subscribe →</button>
                                    <p style="font-size:0.75rem; margin-top:1rem; text-align:center;">No spam, unsubscribe anytime.</p>
                                </form>`;
                openModal(content, createSubmitHandler('Your subscription is confirmed! Welcome to YESEFERSEW.'));
            }

            // CFP Submission Modal
            function showCFPModal() {
                const content = `<h3><i class="fas fa-paper-plane" style="color: var(--secondary);"></i> Submit Abstract</h3>
                                <p>Call for Papers: Systemic & Institutional Challenges in the Visual Art Sector</p>
                                <form id="modalCFPForm">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Institutional Affiliation (Optional)</label>
                                        <input type="text" name="affiliation" placeholder="University / Organization">
                                    </div>
                                    <div class="form-group">
                                        <label>Abstract Title</label>
                                        <input type="text" name="title" placeholder="Working title of your paper" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Abstract (300-500 words)</label>
                                        <textarea name="abstract" rows="6" placeholder="Please paste your abstract here..." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Keywords (comma separated)</label>
                                        <input type="text" name="keywords" placeholder="e.g., institutional critique, arts funding, Ethiopia">
                                    </div>
                                    <button type="submit" class="btn btn-primary modal-btn">Submit Abstract →</button>
                                    <p style="font-size:0.75rem; margin-top:1rem; text-align:center;">You will receive a confirmation email within 48 hours.</p>
                                </form>`;
                openModal(content, function(e) {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    const name = formData.get('name');
                    const title = formData.get('title');

                    if(name && title) {
                        showToast(`📄 Thank you ${name}! Your abstract "${title}" has been submitted. The editorial team will respond within 2-3 weeks.`);
                        closeModal();
                    } else {
                        showToast('Please complete all required fields.');
                    }
                });
            }

            // Registration Modal
            function showRegisterModal(type) {
                let title = "Join YESEFERSEW Network";
                let subtitle = "Become part of Ethiopia's premier visual arts ecosystem.";
                let fields = `<div class="form-group"><label>Full Name</label><input type="text" name="name" required></div>
                            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>`;

                if(type === 'artist') {
                    title = "Artist Membership Registration";
                    subtitle = "Showcase your work, access grants & global opportunities.";
                    fields += `<div class="form-group"><label>Artistic Discipline</label>
                                <select name="discipline">
                                    <option>Painting</option>
                                    <option>Sculpture</option>
                                    <option>Photography</option>
                                    <option>Mixed Media</option>
                                    <option>Digital Art</option>
                                </select></div>`;
                } else if(type === 'curator') {
                    title = "Curator & Critic Network";
                    subtitle = "Connect with peers, publish reviews, and curate exhibitions.";
                    fields += `<div class="form-group"><label>Affiliation (Optional)</label>
                                <input type="text" name="affiliation" placeholder="Institution / Gallery"></div>`;
                } else if(type === 'institution') {
                    title = "Institutional Partnership";
                    subtitle = "Collaborate with YESEFERSEW as a gallery, museum, or cultural center.";
                    fields += `<div class="form-group"><label>Organization Name</label>
                                <input type="text" name="org_name" required></div>
                                <div class="form-group"><label>Position</label>
                                <input type="text" name="position"></div>`;
                } else if(type === 'diaspora') {
                    title = "Diaspora Network Registration";
                    subtitle = "Ethiopian art professionals abroad — stay connected and contribute.";
                    fields += `<div class="form-group"><label>Country of Residence</label>
                                <input type="text" name="country" required></div>
                                <div class="form-group"><label>Professional Role</label>
                                <input type="text" name="role" placeholder="Artist, Curator, Writer, etc."></div>`;
                } else if(type === 'biennial') {
                    title = "Addis Adwa Biennial 2027 Registration";
                    subtitle = "Register as participant, volunteer, or attendee.";
                    fields += `<div class="form-group"><label>Registration Type</label>
                                <select name="reg_type">
                                    <option>Exhibiting Artist</option>
                                    <option>Volunteer</option>
                                    <option>Attendee / Visitor</option>
                                    <option>Panelist / Speaker</option>
                                </select></div>`;
                } else if(type === 'mentorship') {
                    title = "Mentorship Program";
                    subtitle = "Find a mentor or become a mentor in Ethiopian contemporary art.";
                    fields += `<div class="form-group"><label>I want to:</label>
                                <select name="mentor_dir">
                                    <option>Find a Mentor</option>
                                    <option>Become a Mentor</option>
                                </select></div>`;
                } else {
                    title = "Network Registration";
                    fields += `<div class="form-group"><label>Role / Interest</label>
                                <input type="text" name="role" placeholder="Artist, Curator, Enthusiast"></div>`;
                }

                const content = `<h3><i class="fas fa-user-plus" style="color: var(--secondary);"></i> ${title}</h3>
                                <p>${subtitle}</p>
                                <form id="modalRegisterForm">
                                    ${fields}
                                    <button type="submit" class="btn btn-primary modal-btn">Complete Registration →</button>
                                    <p style="font-size:0.75rem; margin-top:1rem; text-align:center;">By joining, you agree to our community guidelines.</p>
                                </form>`;

                openModal(content, createSubmitHandler('Your registration is complete! Welcome to the YESEFERSEW network.'));
            }

            // Event Listeners for Modals
            document.querySelectorAll('.open-subscribe-modal').forEach(btn => btn.addEventListener('click', (e) => {
                e.preventDefault();
                showSubscribeModal();
            }));

            document.querySelectorAll('.open-register-modal').forEach(btn => btn.addEventListener('click', (e) => {
                e.preventDefault();
                const type = btn.getAttribute('data-reg-type') || 'general';
                showRegisterModal(type);
            }));

            document.querySelectorAll('.open-cfp-modal').forEach(btn => btn.addEventListener('click', (e) => {
                e.preventDefault();
                showCFPModal();
            }));

            const joinBtn = document.getElementById('joinNetworkBtn');
            if(joinBtn) joinBtn.addEventListener('click', (e) => {
                e.preventDefault();
                showRegisterModal('general');
            });

            // Close modal events
            modalClose.onclick = closeModal;
            window.onclick = (e) => {
                if(e.target === modal) closeModal();
            };

            // Escape key to close modal
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal();
                }
            });

            // Journal links - show toast info
            document.querySelectorAll('.journal-essay-link, .journal-interview-link, .btn-outline-light:not(.open-subscribe-modal):not(.open-register-modal):not(.open-cfp-modal)').forEach(link => {
                if(!link.classList.contains('open-subscribe-modal') && !link.classList.contains('open-register-modal') && !link.classList.contains('open-cfp-modal')) {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        showToast('📖 Explore our rich journal archives — full content launching soon.');
                    });
                }
            });

            // Social icons - show toast
            document.querySelectorAll('.social-icon').forEach(icon => {
                icon.addEventListener('click', (e) => {
                    e.preventDefault();
                    const platform = icon.getAttribute('data-link') || 'social';
                    showToast(`📱 Connect with us on ${platform.charAt(0).toUpperCase() + platform.slice(1)} — official channels launching soon.`);
                });
            });

            // Mobile menu toggle
            if(menuToggle && navLinks) {
                menuToggle.addEventListener('click', () => navLinks.classList.toggle('active'));
                document.querySelectorAll('.nav-links a').forEach(link => link.addEventListener('click', () => navLinks?.classList.remove('active')));
            }

            // Scroll to top button
            if(scrollTopBtn){
                window.addEventListener('scroll', () => scrollTopBtn.classList.toggle('show', window.scrollY > 300));
                scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
            }

            // Footer newsletter form with improved styling
            const footerForm = document.getElementById('newsletterFormFooter');
            const footerEmail = document.getElementById('newsletterEmailFooter');
            const footerMsg = document.getElementById('newsletterMessageFooter');

            if(footerForm) {
                footerForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const email = footerEmail.value.trim();

                    if(!email || !email.includes('@')) {
                        footerMsg.textContent = 'Please enter a valid email address.';
                        footerMsg.classList.add('newsletter-message-error');
                        footerMsg.classList.remove('newsletter-message-success');
                        footerMsg.style.display = 'block';
                        setTimeout(() => {
                            footerMsg.style.display = 'none';
                            footerMsg.classList.remove('newsletter-message-error');
                        }, 3000);
                        return;
                    }

                    const submitBtn = footerForm.querySelector('button');
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Sending...';
                    submitBtn.disabled = true;

                    try {
                        let subs = JSON.parse(localStorage.getItem('yesefersew_subs') || '[]');
                        if(!subs.includes(email)) {
                            subs.push(email);
                            localStorage.setItem('yesefersew_subs', JSON.stringify(subs));
                        }

                        footerMsg.textContent = '✓ Thanks for subscribing! Check your inbox soon.';
                        footerMsg.classList.add('newsletter-message-success');
                        footerMsg.classList.remove('newsletter-message-error');
                        footerMsg.style.display = 'block';
                        footerEmail.value = '';

                        setTimeout(() => {
                            footerMsg.style.display = 'none';
                            footerMsg.classList.remove('newsletter-message-success');
                        }, 4000);

                        showToast('✨ You are now subscribed to YESEFERSEW newsletter!');
                    } catch(err) {
                        footerMsg.textContent = 'Something went wrong. Please try again.';
                        footerMsg.classList.add('newsletter-message-error');
                        footerMsg.classList.remove('newsletter-message-success');
                        footerMsg.style.display = 'block';
                        setTimeout(() => {
                            footerMsg.style.display = 'none';
                            footerMsg.classList.remove('newsletter-message-error');
                        }, 3000);
                    } finally {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }

            // Welcome toast on load
            window.addEventListener('load', () => showToast('Welcome to YESEFERSEW — Call for Papers now open! Submit your abstract today.'));
        })();
