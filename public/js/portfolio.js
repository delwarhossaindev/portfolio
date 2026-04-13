// ===== Theme Toggle =====
const themeSwitch = document.getElementById('themeSwitch');
const htmlEl = document.documentElement;

// Load saved theme
const savedTheme = localStorage.getItem('theme') || 'dark';
htmlEl.setAttribute('data-theme', savedTheme);

themeSwitch.addEventListener('click', () => {
    // Add transition class for smooth color change
    document.body.classList.add('theme-transitioning');

    const currentTheme = htmlEl.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    htmlEl.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);

    // Remove transition class after animation
    setTimeout(() => {
        document.body.classList.remove('theme-transitioning');
    }, 500);
});

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

navToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    const icon = navToggle.querySelector('i');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
});

// Close mobile nav on link click
navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        const icon = navToggle.querySelector('i');
        icon.classList.add('fa-bars');
        icon.classList.remove('fa-times');
    });
});

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
            document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));
            navLink.classList.add('active');
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

// Add fade-in class to elements
document.querySelectorAll('.timeline-item, .project-card, .stat-item, .tech-icon, .contact-item').forEach(el => {
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
