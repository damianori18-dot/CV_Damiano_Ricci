(() => {
    const canvas = document.querySelector('#code-canvas');
    const ctx = canvas.getContext('2d', { alpha: false });
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const snippets = [
        'const createExperience = () => {', 'display: grid;', 'function animate(frame) {',
        'color: var(--accent);', 'return <Interface />;', 'addEventListener("scroll", update);',
        'const [state, setState] = useState();', 'transition: transform 400ms ease;',
        'if (isReady) render();', 'background: #0b121b;', 'export default Portfolio;',
        'await fetch("/api/projects");', 'opacity: 0.72;', 'git commit -m "refine motion";',
        'while (ideas.length) build();', 'grid-template-columns: 1fr 1fr;',
        'const motion = { fluid: true };', 'requestAnimationFrame(draw);', '</section>',
        'border-radius: 1rem;', 'import { useEffect } from "react";', 'return data.map(item => ...);',
        'transform: translate3d(0, 0, 0);', 'const palette = ["#ff806b", "#a8c7dc"];'
    ];
    const colors = ['#9db4c7', '#7d9bad', '#ff806b', '#d4dde5', '#6f8a9c'];
    let width = 0, height = 0, dpr = 1, lines = [], raf = 0, last = 0;
    const rand = (min, max) => Math.random() * (max - min) + min;

    function resize() {
        dpr = Math.min(window.devicePixelRatio || 1, 1.7);
        width = window.innerWidth; height = window.innerHeight;
        canvas.width = Math.floor(width * dpr); canvas.height = Math.floor(height * dpr);
        canvas.style.width = width + 'px'; canvas.style.height = height + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        const count = Math.max(18, Math.min(54, Math.round(width / 27)));
        lines = Array.from({ length: count }, () => makeLine(true));
        paintBackground();
    }
    function makeLine(initial = false) {
        const fontSize = rand(10, 15);
        return {
            text: snippets[Math.floor(Math.random() * snippets.length)],
            x: rand(-width * .2, width * 1.05),
            y: initial ? rand(-height * .1, height * 1.1) : height + rand(20, 150),
            speed: rand(5, 19), drift: rand(-5, 8),
            alpha: rand(.12, .38), size: fontSize,
            color: colors[Math.floor(Math.random() * colors.length)],
            phase: rand(0, Math.PI * 2)
        };
    }
    function paintBackground() {
        ctx.fillStyle = '#0b121b'; ctx.fillRect(0, 0, width, height);
    }
    function draw(time = 0) {
        if (reduceMotion.matches) {
            paintBackground();
            lines.forEach(line => drawLine(line, 0));
            return;
        }
        const dt = Math.min((time - (last || time)) / 1000, .04); last = time;
        paintBackground();
        for (const line of lines) {
            line.y -= line.speed * dt;
            line.x += line.drift * dt;
            line.phase += dt * .35;
            if (line.y < -40 || line.x > width + 420 || line.x < -520) Object.assign(line, makeLine());
            drawLine(line, time / 1000);
        }
        raf = requestAnimationFrame(draw);
    }
    function drawLine(line, time) {
        const pulse = .82 + Math.sin(time + line.phase) * .18;
        ctx.save();
        ctx.globalAlpha = line.alpha * pulse;
        ctx.font = `${line.size}px ui-monospace, SFMono-Regular, Menlo, Consolas, monospace`;
        ctx.fillStyle = line.color;
        ctx.fillText(line.text, line.x, line.y);
        ctx.restore();
    }
    resize();
    if (!reduceMotion.matches) raf = requestAnimationFrame(draw); else draw(0);
    window.addEventListener('resize', () => { cancelAnimationFrame(raf); resize(); last = 0; if (!reduceMotion.matches) raf = requestAnimationFrame(draw); else draw(0); }, { passive: true });
    reduceMotion.addEventListener?.('change', () => { cancelAnimationFrame(raf); last = 0; if (!reduceMotion.matches) raf = requestAnimationFrame(draw); else draw(0); });
})();

document.querySelectorAll('.project-card-description').forEach(description => {
    const card = description.closest('.card-custom');
    const trigger = card?.querySelector('.project-description-trigger');

    if (!trigger) {
        return;
    }

    const updateTriggerVisibility = () => {
        trigger.classList.toggle('d-none', description.scrollHeight <= description.clientHeight + 1);
    };

    updateTriggerVisibility();
    window.addEventListener('resize', updateTriggerVisibility, { passive: true });
});

const projectDescriptionModal = document.querySelector('#projectDescriptionModal');

projectDescriptionModal?.addEventListener('show.bs.modal', event => {
    const trigger = event.relatedTarget;

    if (!(trigger instanceof HTMLElement)) {
        return;
    }

    projectDescriptionModal.querySelector('#projectDescriptionModalTitle').textContent =
        trigger.dataset.projectTitle;
    projectDescriptionModal.querySelector('#projectDescriptionModalText').textContent =
        trigger.dataset.projectDescription;
});
