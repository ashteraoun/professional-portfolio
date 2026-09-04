# Design System

Premium minimal portfolio design language — editorial typography, intentional whitespace, cyan accent on deep ink backgrounds.

## Colors

### Dark Mode (default)
| Token | Value | Usage |
|-------|-------|-------|
| `--color-ink` | `#0a0a0f` | Page background |
| `--color-surface` | `#16161f` | Cards, panels |
| `--color-text` | `#f4f4f5` | Primary text |
| `--color-text-muted` | `#a1a1aa` | Secondary text |
| `--color-accent` | `#22d3ee` | CTAs, links, highlights |
| `--color-accent-soft` | `rgba(34,211,238,0.12)` | Selection, hover backgrounds |

### Light Mode
| Token | Value |
|-------|-------|
| `--color-light-bg` | `#fafafa` |
| `--color-light-surface` | `#ffffff` |
| `--color-light-ink` | `#09090b` |
| `--color-light-muted` | `#52525b` |

Toggle via `#theme-toggle` or command palette. Preference stored in `localStorage`.

## Typography

| Role | Font | Scale |
|------|------|-------|
| Display | Space Grotesk | `.display-xl` 4xl→7xl, `.display-lg` 3xl→5xl |
| Body | Inter | Base 16px, relaxed leading |
| Labels | Mono uppercase | `.label-mono` 11px, 0.2em tracking |

## Spacing

- **Section padding:** `.section-padding` — py-20 → py-32 responsive
- **Container:** `.container-site` — max-w-7xl, px-5→8
- **Radius:** sm 6px, md 12px, lg 20px, xl 32px

## Components

| Class | Purpose |
|-------|---------|
| `.btn-primary` | Filled accent CTA |
| `.btn-secondary` | Outlined secondary action |
| `.surface-card` | Elevated card surface |
| `.link-underline` | Animated underline link |
| `.reveal` | Scroll-triggered fade-up |
| `.label-mono` | Section labels |

## Motion

- **Easing:** `--ease-out-expo` for reveals and hovers
- **Scroll:** Lenis smooth scroll (disabled when `prefers-reduced-motion`)
- **Reveals:** Intersection Observer → `.is-visible`
- **Hero:** Cursor-following glow (desktop, fine pointer only)
- **Marquee:** Infinite ticker, pauses on hover

## Breakpoints

Tailwind defaults: `sm` 640px, `md` 768px, `lg` 1024px, `xl` 1280px, `2xl` 1536px

## Accessibility

- Skip link to `#main-content`
- Visible `:focus-visible` outlines (accent)
- `prefers-reduced-motion` disables decorative animation
- Custom cursor hidden on touch/coarse pointer
- Semantic HTML, ARIA on dialogs/menus where needed
- WCAG 2.2 contrast targets on text/background pairs

## UX Principles

1. Visual polish must not break usability
2. No fabricated metrics, testimonials, or experience
3. Database-driven content — nothing hardcoded in components
4. Progressive enhancement — site works without WebGL/JS
5. Mobile-first layouts, reduced motion on touch devices
