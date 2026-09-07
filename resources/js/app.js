document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-nav-toggle]');
    const panel = document.querySelector('[data-nav-panel]');

    if (toggle instanceof HTMLElement && panel instanceof HTMLElement) {
        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.body.classList.toggle('overflow-hidden', open);
        };

        toggle.addEventListener('click', () => {
            setOpen(panel.classList.contains('hidden'));
        });

        panel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setOpen(false));
        });
    }

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealNodes = document.querySelectorAll('[data-reveal]');

    if (reduceMotion) {
        revealNodes.forEach((node) => node.classList.add('is-in'));
    } else if (revealNodes.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-in');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -8% 0px' },
        );

        revealNodes.forEach((node) => observer.observe(node));
    } else {
        revealNodes.forEach((node) => node.classList.add('is-in'));
    }

    const parallax = document.querySelector('[data-parallax]');

    if (parallax instanceof HTMLElement && ! reduceMotion) {
        let ticking = false;

        const update = () => {
            const offset = window.scrollY * 0.08;
            parallax.style.transform = `translate3d(0, ${offset}px, 0)`;
            ticking = false;
        };

        window.addEventListener(
            'scroll',
            () => {
                if (! ticking) {
                    ticking = true;
                    window.requestAnimationFrame(update);
                }
            },
            { passive: true },
        );
    }

    const category = document.querySelector('[data-category-select]');
    const service = document.querySelector('[data-service-select]');
    const mapElement = document.querySelector('[data-service-map]');

    if (
        category instanceof HTMLSelectElement &&
        service instanceof HTMLSelectElement &&
        mapElement instanceof HTMLElement
    ) {
        const raw = mapElement.getAttribute('data-service-map') ?? '{}';
        let map = {};

        try {
            map = JSON.parse(raw);
        } catch {
            map = {};
        }

        const placeholder = service.getAttribute('data-placeholder') ?? '';

        const renderOptions = (categoryId) => {
            const current = service.value;
            const options = map[categoryId] ?? [];

            service.innerHTML = '';

            const empty = document.createElement('option');
            empty.value = '';
            empty.textContent = placeholder;
            service.append(empty);

            options.forEach((item) => {
                const option = document.createElement('option');
                option.value = String(item.id);
                option.textContent = item.name;
                service.append(option);
            });

            if ([...service.options].some((option) => option.value === current)) {
                service.value = current;
            }
        };

        category.addEventListener('change', () => renderOptions(category.value));
        renderOptions(category.value);
    }
});
