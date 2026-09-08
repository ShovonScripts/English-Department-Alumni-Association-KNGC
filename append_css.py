import os

css_to_append = """
/* ── Animated Backgrounds ──────────────────────────────── */
@keyframes ambient-glow {
    0%, 100% { transform: scale(1) translate(0, 0); opacity: 0.15; }
    25% { transform: scale(1.1) translate(2%, 3%); opacity: 0.25; }
    50% { transform: scale(0.95) translate(-1%, 2%); opacity: 0.15; }
    75% { transform: scale(1.05) translate(-2%, -1%); opacity: 0.25; }
}

.bg-ambient-orb {
    animation: ambient-glow 15s ease-in-out infinite alternate;
    filter: blur(80px);
}

.hero-gradient-mesh {
    background: radial-gradient(circle at 15% 50%, rgba(200, 150, 45, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(135, 45, 83, 0.08), transparent 25%);
    background-size: cover;
}

/* ── Animate On Scroll (AOS) System ────────────────────── */
.aos-init {
    opacity: 0;
    will-change: opacity, transform;
}

.aos-fade-in {
    transition: opacity 0.8s ease-out;
}
.aos-fade-in.aos-animate {
    opacity: 1;
}

.aos-fade-up {
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.aos-fade-up.aos-animate {
    opacity: 1;
    transform: translateY(0);
}

.aos-fade-right {
    transform: translateX(-30px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.aos-fade-right.aos-animate {
    opacity: 1;
    transform: translateX(0);
}

/* Delay Utilities for Staggering */
.aos-delay-100 { transition-delay: 100ms; }
.aos-delay-200 { transition-delay: 200ms; }
.aos-delay-300 { transition-delay: 300ms; }
.aos-delay-400 { transition-delay: 400ms; }
.aos-delay-500 { transition-delay: 500ms; }

/* ── Refined Glassmorphism ─────────────────────────────── */
/* Enhancing existing .glass classes with multi-layered shadows and gradient borders */
.glass {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 4px 24px -1px rgba(0, 0, 0, 0.05), inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
}

.glass-light {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.6);
    box-shadow: 0 8px 32px -4px rgba(0, 0, 0, 0.06), inset 0 1px 0 0 rgba(255, 255, 255, 0.8);
}

.glass-dark {
    background: linear-gradient(135deg, rgba(31, 47, 82, 0.7) 0%, rgba(21, 32, 58, 0.85) 100%);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px -4px rgba(0, 0, 0, 0.3), inset 0 1px 0 0 rgba(255, 255, 255, 0.05);
}

/* ── Button Micro-interactions ─────────────────────────── */
/* Ripple/pulse effect on click and magnetic feel */
.btn {
    position: relative;
    overflow: hidden;
    transform: translateZ(0); /* Force hardware acceleration */
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, transparent 60%);
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
    transition: transform 0.4s ease-out, opacity 0.4s ease-out;
    border-radius: 50%;
    pointer-events: none;
}

.btn:active::before {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
    transition: 0s;
}

/* Hover pulse for primary buttons */
.btn-primary:hover, .btn-accent:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
}

.btn-primary:active, .btn-accent:active {
    transform: translateY(0);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* ── 3D Tilt Wrapper ───────────────────────────────────── */
.tilt-card {
    transform-style: preserve-3d;
    transform: perspective(1000px);
}

.tilt-inner {
    transform: translateZ(30px);
}
"""

# Read existing CSS
with open('resources/css/app.css', 'r', encoding='utf-8') as f:
    existing_css = f.read()

# Replace the old glass classes with the new ones, or just append since appending overwrites in CSS (last rule wins)
# But it's cleaner to replace the block if possible. Appending is easier.
with open('resources/css/app.css', 'a', encoding='utf-8') as f:
    f.write(css_to_append)

print("CSS appended successfully.")
