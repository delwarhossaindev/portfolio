// ===== Theme Toggle =====
const themeSwitch = document.getElementById('themeSwitch');
const htmlEl = document.documentElement;

function applyTheme(theme) {
    htmlEl.setAttribute('data-theme', theme);
    if (themeSwitch) {
        themeSwitch.setAttribute('aria-checked', theme === 'dark' ? 'true' : 'false');
    }
}

// Load saved theme
const savedTheme = localStorage.getItem('theme') || 'dark';
applyTheme(savedTheme);

if (themeSwitch) {
    themeSwitch.addEventListener('click', () => {
        document.body.classList.add('theme-transitioning');

        const currentTheme = htmlEl.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        applyTheme(newTheme);
        localStorage.setItem('theme', newTheme);

        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 500);
    });

    // Allow Space/Enter to toggle when focused
    themeSwitch.addEventListener('keydown', (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            themeSwitch.click();
        }
    });
}

// ===== Eyes Follow Mouse =====
const eyes = document.querySelectorAll('.eye');

document.addEventListener('mousemove', (e) => {
    eyes.forEach(eye => {
        const rect = eye.getBoundingClientRect();
        const eyeCenterX = rect.left + rect.width / 2;
        const eyeCenterY = rect.top + rect.height / 2;

        const dx = e.clientX - eyeCenterX;
        const dy = e.clientY - eyeCenterY;
        const angle = Math.atan2(dy, dx);
        const maxMove = 4;

        const distance = Math.min(Math.sqrt(dx * dx + dy * dy), 200);
        const moveScale = (distance / 200) * maxMove;

        const x = Math.cos(angle) * moveScale;
        const y = Math.sin(angle) * moveScale;

        const eyeball = eye.querySelector('.eyeball');
        eyeball.style.transform = `translate(${x}px, ${y}px)`;
    });
});

// ===== Typing Animation =====
const typedTextElement = document.getElementById('typedText');
if (typedTextElement) {
    const dynamicRoles = (typedTextElement.dataset.roles || '')
        .split(',')
        .map(role => role.trim())
        .filter(role => role.length > 0);
    const texts = dynamicRoles.length > 0
        ? dynamicRoles
        : ['Full Stack Developer', 'Software Engineer', 'Laravel & Vue.js Expert', 'PHP Developer'];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function typeText() {
        const currentText = texts[textIndex];

        if (isDeleting) {
            typedTextElement.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typedTextElement.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
        }

        let speed = isDeleting ? 50 : 100;

        if (!isDeleting && charIndex === currentText.length) {
            speed = 2000;
            isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
            speed = 500;
        }

        setTimeout(typeText, speed);
    }

    typeText();
}

// ===== Navbar Scroll Effect =====
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ===== Mobile Navigation =====
const navToggle = document.getElementById('navToggle');
const navLinks = document.getElementById('navLinks');

function setNavExpanded(expanded) {
    if (!navToggle || !navLinks) return;
    navLinks.classList.toggle('active', expanded);
    navToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    navToggle.setAttribute('aria-label', expanded ? 'Close menu' : 'Open menu');
    const icon = navToggle.querySelector('i');
    if (icon) {
        icon.classList.toggle('fa-bars', !expanded);
        icon.classList.toggle('fa-times', expanded);
    }
}

if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
        const isExpanded = navLinks.classList.contains('active');
        setNavExpanded(!isExpanded);
    });

    // Close on link click
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => setNavExpanded(false));
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navLinks.classList.contains('active')) {
            setNavExpanded(false);
            navToggle.focus();
        }
    });
}

// ===== Active Nav Link =====
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
    const scrollY = window.scrollY + 100;
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');
        const navLink = document.querySelector(`.nav-links a[href="#${sectionId}"]`);

        if (navLink && scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
            document.querySelectorAll('.nav-links a').forEach(a => {
                a.classList.remove('active');
                a.removeAttribute('aria-current');
            });
            navLink.classList.add('active');
            navLink.setAttribute('aria-current', 'page');
        }
    });
});

// ===== Back to Top =====
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
});

backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ===== Scroll Indicator Hide on Scroll =====
const scrollIndicator = document.querySelector('.scroll-indicator');
if (scrollIndicator) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            scrollIndicator.style.opacity = '0';
            scrollIndicator.style.pointerEvents = 'none';
        } else {
            scrollIndicator.style.opacity = '1';
            scrollIndicator.style.pointerEvents = 'auto';
        }
    });
}

// ===== Scroll Animations =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Add fade-in class to individual elements
document.querySelectorAll('.timeline-item, .project-card, .stat-item, .tech-icon, .contact-item').forEach(el => {
    el.classList.add('fade-in');
    observer.observe(el);
});

// Also observe larger containers for stagger parent
document.querySelectorAll('.about-content, .tech-stack, .contact-info, .contact-form-wrapper').forEach(el => {
    el.classList.add('fade-in');
    observer.observe(el);
});

// ===== Stat Counter Animation =====
const statNumbers = document.querySelectorAll('.stat-number');

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = entry.target;
            const count = parseFloat(target.getAttribute('data-count'));
            const isDecimal = count % 1 !== 0;
            const duration = 2000;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const current = count * easeOut;

                target.textContent = isDecimal ? current.toFixed(1) : Math.floor(current);

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    target.textContent = isDecimal ? count.toFixed(1) : count;
                }
            }

            requestAnimationFrame(updateCounter);
            counterObserver.unobserve(target);
        }
    });
}, { threshold: 0.5 });

statNumbers.forEach(stat => counterObserver.observe(stat));

// ===== Particles =====
const particlesContainer = document.getElementById('particles');

for (let i = 0; i < 30; i++) {
    const particle = document.createElement('div');
    particle.classList.add('particle');
    particle.style.left = Math.random() * 100 + '%';
    particle.style.top = Math.random() * 100 + '%';
    particle.style.animationDelay = Math.random() * 6 + 's';
    particle.style.animationDuration = (4 + Math.random() * 4) + 's';
    particlesContainer.appendChild(particle);
}

// ===== Smooth Navbar Link Scroll =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        const target = document.querySelector(targetId);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
