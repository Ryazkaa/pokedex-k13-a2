/* ==========================================================================
   Crimson Dark Pokédex — Client Interactions (vanilla JS)
   Meliputi: sticky navbar, scrollspy, drawer, hero slider + sinkronisasi
   Info Cards, micro-UX import (file chip + drag & drop), search/filter/sort/
   paginasi tabel (20/hlm), serta Showcase Modal (<dialog> + deep-link URL).
   ========================================================================== */

(() => {
    'use strict';

    const STATE = window.POKEDEX || {
        pokemons: [],
        featured: [],
        total: 0,
        types: {},
        regions: {},
        genCounts: {},
        newIds: [],
    };

    const SPRITE_BASE = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon';
    const FALLBACK_SVG = "data:image/svg+xml;utf8," + encodeURIComponent(
        `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="52" fill="none" stroke="#75020f" stroke-width="6" opacity=".55"/>
            <path d="M8 60h36m32 0h36" stroke="#75020f" stroke-width="6" opacity=".55"/>
            <circle cx="60" cy="60" r="14" fill="none" stroke="#75020f" stroke-width="6" opacity=".55"/>
        </svg>`
    );

    const byNo = new Map(STATE.pokemons.map((p) => [p.no, p]));
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    /* ----------------------------------------------------------------------
       1. Helper: Top-layer dialog close + light-dismiss fallback
       (Sesuai panduan modern-web-guidance: light-dismiss-a-dialog &
       animate-to-from-top-layer)
       ---------------------------------------------------------------------- */
    let supportsDisplayTransition;
    function canTransitionDisplay() {
        if (supportsDisplayTransition !== undefined) return supportsDisplayTransition;
        if (!window.CSS?.supports?.('transition-behavior', 'allow-discrete') || !document.body) {
            return false;
        }
        const probe = document.createElement('div');
        probe.style.cssText = 'transition: display 1s allow-discrete !important; display: block;';
        document.body.appendChild(probe);
        getComputedStyle(probe).display;
        probe.style.display = 'none';
        supportsDisplayTransition = getComputedStyle(probe).display === 'block';
        probe.remove();
        return supportsDisplayTransition;
    }

    function supportsTopLayerExit() {
        return window.CSS?.supports?.('overlay', 'auto') && canTransitionDisplay();
    }

    async function closeTopLayer(dialog) {
        if (!dialog || !dialog.open) return;
        if (!supportsTopLayerExit()) {
            dialog.setAttribute('data-closing', '');
            const animations = dialog.getAnimations({ subtree: true });
            if (animations.length > 0) {
                await Promise.race([
                    Promise.allSettled(animations.map((a) => a.finished)),
                    new Promise((r) => setTimeout(r, 450)),
                ]);
            }
            if (!dialog.hasAttribute('data-closing')) return;
            dialog.removeAttribute('data-closing');
        }
        dialog.close();
    }

    function setupDialog(dialog) {
        if (!dialog) return;

        dialog.addEventListener('cancel', (event) => {
            event.preventDefault();
            closeTopLayer(dialog);
        });

        // Fallback untuk browser yang belum mendukung atribut closedby="any"
        if (!('closedBy' in HTMLDialogElement.prototype)) {
            dialog.addEventListener('click', (event) => {
                if (event.target !== dialog) return;
                const rect = dialog.getBoundingClientRect();
                const inside =
                    rect.top <= event.clientY &&
                    event.clientY <= rect.top + rect.height &&
                    rect.left <= event.clientX &&
                    event.clientX <= rect.left + rect.width;
                if (!inside) closeTopLayer(dialog);
            });
        }
    }

    document.querySelectorAll('dialog').forEach(setupDialog);

    document.addEventListener('click', (e) => {
        const closeBtn = e.target.closest('[data-close-dialog]');
        if (closeBtn) {
            closeTopLayer(closeBtn.closest('dialog'));
        }
    });

    /* ----------------------------------------------------------------------
       2. Fallback gambar rusak -> siluet Pokéball
       ---------------------------------------------------------------------- */
    document.addEventListener(
        'error',
        (e) => {
            const img = e.target;
            if (img && img.tagName === 'IMG' && img.src !== FALLBACK_SVG) {
                img.src = FALLBACK_SVG;
            }
        },
        true
    );

    /* ----------------------------------------------------------------------
       3. Topbar sticky, Scrollspy, Menu Drawer, & Dropdown Trainer
       ---------------------------------------------------------------------- */
    const topbar = document.getElementById('topbar');
    const syncTopbar = () => {
        if (topbar) topbar.classList.toggle('is-scrolled', window.scrollY > 16);
    };
    syncTopbar();
    window.addEventListener('scroll', syncTopbar, { passive: true });

    // Navigasi Sliding Pill (merah -> pink pegas & memanjang saat berpindah tab) + Scrollspy
    const navLinks = Array.from(document.querySelectorAll('.nav-links a'));
    const navPill = document.getElementById('navPill');
    const sections = ['home', 'explore', 'pokedex-caught', 'search']
        .map((id) => document.getElementById(id))
        .filter(Boolean);

    let activeNavLink = navLinks.find((l) => l.classList.contains('is-current')) || navLinks[0] || null;
    let pillAnim = null;

    function moveNavPill(targetLink, animate = true) {
        if (!navPill || !targetLink) return;
        const prevLink = activeNavLink;
        activeNavLink = targetLink;

        navLinks.forEach((link) => {
            const active = link === targetLink;
            link.classList.toggle('target-current', active);
            link.classList.toggle('is-current', active);
            link.setAttribute('aria-current', active ? 'true' : 'false');
        });

        const nextLeft = targetLink.offsetLeft;
        const nextWidth = targetLink.offsetWidth;

        if (!animate || reducedMotion.matches || !prevLink || prevLink === targetLink || !navPill.animate) {
            navPill.style.left = `${nextLeft}px`;
            navPill.style.width = `${nextWidth}px`;
            return;
        }

        const prevLeft = prevLink.offsetLeft;
        const prevWidth = prevLink.offsetWidth;
        const stretchLeft = Math.min(prevLeft, nextLeft);
        const stretchRight = Math.max(prevLeft + prevWidth, nextLeft + nextWidth);
        const stretchWidth = Math.max(nextWidth * 1.25, stretchRight - stretchLeft);
        const dir = nextLeft >= prevLeft ? 1 : -1;

        if (pillAnim) pillAnim.cancel();

        navPill.style.left = `${nextLeft}px`;
        navPill.style.width = `${nextWidth}px`;

        pillAnim = navPill.animate(
            [
                {
                    left: `${prevLeft}px`,
                    width: `${prevWidth}px`,
                    transform: 'scaleY(1)',
                },
                {
                    left: `${stretchLeft}px`,
                    width: `${stretchWidth}px`,
                    transform: 'scaleY(0.84)',
                    offset: 0.42,
                },
                {
                    left: `${nextLeft + dir * 5}px`,
                    width: `${Math.max(24, nextWidth * 0.94)}px`,
                    transform: 'scaleY(1.04)',
                    offset: 0.78,
                },
                {
                    left: `${nextLeft}px`,
                    width: `${nextWidth}px`,
                    transform: 'scaleY(1)',
                },
            ],
            {
                duration: 460,
                easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
            }
        );
    }

    if (activeNavLink) {
        requestAnimationFrame(() => moveNavPill(activeNavLink, false));
        window.addEventListener('resize', () => moveNavPill(activeNavLink, false), { passive: true });
    }

    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            moveNavPill(link, true);
        });
    });

    if ('IntersectionObserver' in window) {
        const spy = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const hash = `#${entry.target.id}`;
                        const matched = navLinks.find((link) => link.getAttribute('href') === hash);
                        if (matched && matched !== activeNavLink) {
                            moveNavPill(matched, true);
                        }
                    }
                });
            },
            { rootMargin: '-45% 0px -45% 0px', threshold: 0 }
        );
        sections.forEach((sec) => spy.observe(sec));
    }

    // Helper untuk me-reset animasi Fold Down setiap kali dropdown Made By dibuka
    function replayFoldDown(container) {
        if (!container || reducedMotion.matches) return;
        const rows = container.querySelectorAll('.fold-row, .fold-row__inner');
        rows.forEach((el) => {
            el.style.animation = 'none';
            void el.offsetHeight;
            el.style.animation = '';
        });
    }

    // Helper untuk me-reset animasi Side Drawer stagger setiap kali Menu dibuka
    function replayDrawerStagger(container) {
        if (!container || reducedMotion.matches) return;
        const items = container.querySelectorAll('.drawer-stagger');
        items.forEach((el) => {
            el.style.animation = 'none';
            void el.offsetHeight;
            el.style.animation = '';
        });
    }

    // Drawer menu (Side Drawer: springs in from the right as the page dims, rows stagger in)
    const drawer = document.getElementById('drawer');
    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn && drawer) {
        menuBtn.addEventListener('click', () => {
            drawer.showModal();
            menuBtn.setAttribute('aria-expanded', 'true');
            replayDrawerStagger(drawer);
        });
        drawer.addEventListener('close', () => {
            menuBtn.setAttribute('aria-expanded', 'false');
        });
    }

    // Dropdown Made By: (animasi Fold Down + tutup saat klik di luar)
    const trainerDetails = document.querySelector('details.trainer');
    if (trainerDetails) {
        trainerDetails.addEventListener('toggle', () => {
            if (trainerDetails.open) {
                replayFoldDown(trainerDetails);
            }
        });
        document.addEventListener('click', (e) => {
            if (trainerDetails.open && !trainerDetails.contains(e.target)) {
                trainerDetails.open = false;
            }
        });
    }

    // Klik link Search -> fokus ke kotak pencarian setelah scroll
    document.querySelectorAll('[data-focus-search]').forEach((el) => {
        el.addEventListener('click', () => {
            setTimeout(() => document.getElementById('searchInput')?.focus({ preventScroll: true }), 250);
        });
    });

    /* ----------------------------------------------------------------------
       4. Hero Slider (Stack Slides: 20 Fun Facts) + Sinkronisasi Bento
       ---------------------------------------------------------------------- */
    const heroSection = document.getElementById('home');
    const slides = Array.from(document.querySelectorAll('.hero__slide[data-slot]'));
    const dots = Array.from(document.querySelectorAll('.hero__dot[data-goto]'));
    const heroPrev = document.getElementById('heroPrev');
    const heroNext = document.getElementById('heroNext');
    const heroCounter = document.getElementById('heroCounter');
    let activeSlide = 0;
    let slideTimer = null;
    let slideOutTimeout = null;

    function buildBadgeHtml(types, variant = '') {
        if (variant === 'icons' || variant === 'table') {
            return `<span class="type-badges type-badges--icons">${types
                .map((t) => {
                    const key = String(t).trim().toLowerCase();
                    const meta = STATE.types[key] || { label: t, icon: `/images/types/${key}.svg` };
                    const iconUrl = meta.icon || `/images/types/${key}.svg`;
                    const label = meta.label || t;
                    return `<span class="type-icon-chip" title="${escapeHtml(label)}" aria-label="${escapeHtml(label)}">
                        <img src="${escapeHtml(iconUrl)}" alt="${escapeHtml(label)}" width="28" height="28" loading="lazy">
                    </span>`;
                })
                .join('')}</span>`;
        }
        const cls = variant ? `type-badge type-badge--${variant}` : 'type-badge';
        return `<span class="type-badges">${types
            .map((t) => {
                const key = String(t).trim().toLowerCase();
                const meta = STATE.types[key] || { label: t, color: '#888888', icon: '/images/types/normal.svg' };
                const iconUrl = meta.icon || `/images/types/${key}.svg`;
                return `<span class="${cls}" style="--tc: ${meta.color}">
                    <img src="${escapeHtml(iconUrl)}" alt="" class="type-badge__icon" width="20" height="20">
                    <span>${escapeHtml(meta.label || t)}</span>
                </span>`;
            })
            .join('')}</span>`;
    }

    function loreFor(p) {
        if (p?.lore && String(p.lore).trim() !== '') {
            return String(p.lore).trim();
        }
        const primary = String(p?.types?.[0] || '').toLowerCase();
        const typeDesc = STATE.types[primary]?.desc || '';
        return `${p.name} adalah Pokémon bertipe ${p.tipe} yang berasal dari ${p.generasi}. ${typeDesc}`.trim();
    }

    function updateInfoCards(p) {
        if (!p) return;
        const primaryKey = String(p.types?.[0] || '').toLowerCase();
        const typeMeta = STATE.types[primaryKey] || { label: p.tipe, color: '#75020f', desc: '' };
        const regionMeta = STATE.regions[p.gen] || { name: p.region, desc: '' };
        const genCount = STATE.genCounts[p.gen] ?? 0;

        const infoType = document.getElementById('infoType');
        if (infoType) {
            const icon = infoType.querySelector('[data-f="icon"]');
            const abbr = infoType.querySelector('[data-f="abbr"]');
            const title = infoType.querySelector('[data-f="title"]');
            const desc = infoType.querySelector('[data-f="desc"]');
            if (icon) icon.style.setProperty('--tc', typeMeta.color);
            if (abbr) abbr.textContent = String(typeMeta.label || '?').slice(0, 3).toUpperCase();
            if (title) title.textContent = p.tipe;
            if (desc) desc.textContent = typeMeta.desc || 'Tipe elemen Pokémon.';
            pulseCard(infoType);
        }

        const infoRegion = document.getElementById('infoRegion');
        if (infoRegion) {
            const kicker = infoRegion.querySelector('[data-f="kicker"]');
            const title = infoRegion.querySelector('[data-f="title"]');
            const desc = infoRegion.querySelector('[data-f="desc"]');
            if (kicker) kicker.textContent = `Generasi ${p.gen || '—'}`;
            if (title) title.textContent = p.region || regionMeta.name || '—';
            if (desc) {
                desc.innerHTML = `${escapeHtml(regionMeta.desc || '')} <strong data-f="count">${genCount} Pokémon</strong> dari generasi ini ada di koleksimu.`;
            }
            pulseCard(infoRegion);
        }
    }

    function pulseCard(card) {
        card.classList.remove('is-updating');
        void card.offsetWidth;
        card.classList.add('is-updating');
    }

    function syncDeckDepths(outgoingSlide = null, dir = 1) {
        const total = slides.length;
        if (total === 0) return;

        slides.forEach((slide, i) => {
            const active = i === activeSlide;
            const offset = ((i - activeSlide) % total + total) % total;
            const depth = Math.min(offset, 4);

            slide.classList.remove('is-sliding-out', 'is-sliding-out-right');
            slide.dataset.depth = String(depth);
            slide.classList.toggle('is-active', active);
            slide.toggleAttribute('inert', !active);
        });

        if (outgoingSlide && !reducedMotion.matches) {
            outgoingSlide.classList.add(dir < 0 ? 'is-sliding-out-right' : 'is-sliding-out');
            if (slideOutTimeout) clearTimeout(slideOutTimeout);
            slideOutTimeout = window.setTimeout(() => {
                outgoingSlide.classList.remove('is-sliding-out', 'is-sliding-out-right');
            }, 560);
        }
    }

    function goToSlide(index, dir = null) {
        if (slides.length === 0) return;
        const total = slides.length;
        const nextIndex = ((index % total) + total) % total;
        if (nextIndex === activeSlide) return;

        const prevSlide = slides[activeSlide];
        const resolvedDir = dir !== null ? dir : nextIndex > activeSlide ? 1 : -1;
        activeSlide = nextIndex;

        syncDeckDepths(prevSlide, resolvedDir);

        dots.forEach((dot, i) => {
            const active = i === activeSlide;
            dot.classList.toggle('is-active', active);
            if (active) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });

        if (heroCounter) {
            heroCounter.textContent = `${activeSlide + 1} / ${total}`;
        }

        const currentNo = slides[activeSlide]?.dataset.no;
        updateInfoCards(byNo.get(currentNo));
    }

    function startAutoSlide() {
        stopAutoSlide();
        if (slides.length <= 1 || reducedMotion.matches) return;
        slideTimer = window.setInterval(() => goToSlide(activeSlide + 1, 1), 7000);
    }

    function stopAutoSlide() {
        if (slideTimer) {
            clearInterval(slideTimer);
            slideTimer = null;
        }
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const target = Number(dot.dataset.goto || 0);
            const dir = target >= activeSlide ? 1 : -1;
            goToSlide(target, dir);
            startAutoSlide();
        });
    });

    heroPrev?.addEventListener('click', () => {
        goToSlide(activeSlide - 1, -1);
        startAutoSlide();
    });

    heroNext?.addEventListener('click', () => {
        goToSlide(activeSlide + 1, 1);
        startAutoSlide();
    });

    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopAutoSlide);
        heroSection.addEventListener('mouseleave', startAutoSlide);
        heroSection.addEventListener('focusin', stopAutoSlide);
        heroSection.addEventListener('focusout', startAutoSlide);
    }

    startAutoSlide();

    /* Floating Card Popup: Fun Fact Lengkap (Springs Down + Cascade Content) */
    const factModal = document.getElementById('factModal');
    const factModalTopic = document.getElementById('factModalTopic');
    const factModalPoke = document.getElementById('factModalPoke');
    const factModalArt = document.getElementById('factModalArt');
    const factModalCategory = document.getElementById('factModalCategory');
    const factModalSource = document.getElementById('factModalSource');
    const factModalTitle = document.getElementById('factModalTitle');
    const factModalDesc = document.getElementById('factModalDesc');

    function openFactModal(slide) {
        if (!factModal || !slide) return;
        const d = slide.dataset;

        if (factModalTopic) factModalTopic.textContent = `Fun Fact · ${d.factTopic || ''}`;
        if (factModalPoke) factModalPoke.textContent = `${d.factNo || ''} ${d.factName || ''}`.trim();
        if (factModalCategory) factModalCategory.textContent = d.factCategory || 'Fun Fact';
        if (factModalSource) factModalSource.textContent = d.factSource || '';
        if (factModalTitle) factModalTitle.textContent = d.factTitle || '';
        if (factModalDesc) factModalDesc.textContent = d.factDesc || '';
        if (factModalArt) {
            factModalArt.src = d.factArt || '';
            factModalArt.alt = d.factName || 'Pokémon';
        }

        // Replay cascade animation on every open
        const cascadeEls = factModal.querySelectorAll('.fact-cascade');
        cascadeEls.forEach((el) => {
            el.style.animation = 'none';
            void el.offsetWidth;
            el.style.animation = '';
        });

        stopAutoSlide();
        if (!factModal.open && typeof factModal.showModal === 'function') {
            factModal.showModal();
        }
    }

    document.addEventListener('click', (e) => {
        const readMoreBtn = e.target.closest('[data-open-fact]');
        if (readMoreBtn) {
            e.preventDefault();
            const slide = readMoreBtn.closest('.hero__slide') || slides[activeSlide];
            openFactModal(slide);
        }
    });

    if (factModal) {
        factModal.addEventListener('click', (e) => {
            if (e.target === factModal) {
                factModal.close();
            }
        });
        factModal.addEventListener('close', () => {
            startAutoSlide();
        });
    }

    // Promosikan Pokémon mana pun ke slide 0
    function promoteToHero(p) {
        const slide = slides[0];
        if (!slide || !p) return;
        slide.dataset.no = p.no;
        const noEl = slide.querySelector('[data-f="no"]');
        const nameEl = slide.querySelector('[data-f="name"]');
        const loreEl = slide.querySelector('[data-f="lore"]');
        const typesEl = slide.querySelector('[data-f="types"]');
        const genEl = slide.querySelector('[data-f="generasi"]');
        const artEl = slide.querySelector('[data-f="art"]');
        const moreBtn = slide.querySelector('[data-open-pokemon]');
        if (noEl) noEl.textContent = p.no;
        if (nameEl) nameEl.textContent = p.name;
        if (loreEl) loreEl.textContent = loreFor(p);
        if (typesEl) typesEl.innerHTML = buildBadgeHtml(p.types);
        if (genEl) genEl.textContent = p.generasi;
        if (artEl) {
            artEl.src = `${SPRITE_BASE}/other/official-artwork/${p.num}.png`;
            artEl.alt = p.name;
        }
        if (moreBtn) moreBtn.dataset.openPokemon = p.no;
        if (dots[0]) dots[0].setAttribute('aria-label', `Fun Fact 1: ${p.name}`);
        goToSlide(0, -1);
        startAutoSlide();
    }

    /* ----------------------------------------------------------------------
       5. Control Panel: Hold to Confirm (Import & Export) + Envelope Seal
       ---------------------------------------------------------------------- */
    const importForm = document.getElementById('importForm');
    const importFile = document.getElementById('importFile');
    const importTrigger = document.getElementById('importTrigger');
    const importChip = document.getElementById('importChip');
    const importName = document.getElementById('importName');
    const importCancel = document.getElementById('importCancel');
    const importSubmit = document.getElementById('importSubmit');
    const dropZone = document.getElementById('dropZone');

    const exportTrigger = document.getElementById('exportTrigger');
    const exportChip = document.getElementById('exportChip');
    const exportCancel = document.getElementById('exportCancel');
    const exportHoldBtn = document.getElementById('exportHoldBtn');
    const envelopeOverlay = document.getElementById('envelopeOverlay');

    // Helper: Hold to Confirm (Hold it down: a ring fills around the button, then turns into a checklist logo)
    function setupHoldButton(btn, { holdMs = 950, confirmedLabel = 'Confirmed!', onConfirm } = {}) {
        if (!btn) return { reset: () => {} };

        const labelEl = btn.querySelector('[data-label]');
        const defaultLabel = labelEl ? labelEl.textContent : '';
        let pct = 0;
        let holding = false;
        let confirmed = false;
        let rafId = null;
        let lastTs = 0;

        function setPct(val) {
            pct = Math.max(0, Math.min(100, val));
            btn.style.setProperty('--hold-pct', pct.toFixed(2));
        }

        function tick(ts) {
            if (!lastTs) lastTs = ts;
            const dt = ts - lastTs;
            lastTs = ts;

            if (holding && !confirmed) {
                setPct(pct + (dt / holdMs) * 100);
                if (pct >= 100) {
                    confirmed = true;
                    holding = false;
                    btn.classList.remove('is-holding');
                    btn.classList.add('is-confirmed');
                    if (labelEl && confirmedLabel) {
                        labelEl.textContent = confirmedLabel;
                    }
                    if (typeof onConfirm === 'function') {
                        onConfirm();
                    }
                    return;
                }
                rafId = requestAnimationFrame(tick);
            } else if (!holding && !confirmed && pct > 0) {
                setPct(pct - (dt / 260) * 100);
                if (pct > 0) {
                    rafId = requestAnimationFrame(tick);
                }
            }
        }

        function startHold(e) {
            if (confirmed || btn.disabled) return;
            if (e.type === 'pointerdown' && e.button !== 0) return;
            holding = true;
            lastTs = 0;
            btn.classList.add('is-holding');
            if (rafId) cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(tick);
        }

        function stopHold() {
            if (!holding || confirmed) return;
            holding = false;
            lastTs = 0;
            btn.classList.remove('is-holding');
            if (rafId) cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(tick);
        }

        function reset() {
            if (rafId) cancelAnimationFrame(rafId);
            holding = false;
            confirmed = false;
            lastTs = 0;
            setPct(0);
            btn.classList.remove('is-holding', 'is-confirmed', 'is-loading');
            if (labelEl) labelEl.textContent = defaultLabel;
        }

        btn.addEventListener('pointerdown', startHold);
        btn.addEventListener('pointerup', stopHold);
        btn.addEventListener('pointerleave', stopHold);
        btn.addEventListener('pointercancel', stopHold);
        btn.addEventListener('contextmenu', (e) => {
            if (holding) e.preventDefault();
        });

        btn.addEventListener('keydown', (e) => {
            if ((e.key === ' ' || e.key === 'Enter') && !e.repeat) {
                e.preventDefault();
                startHold(e);
            }
        });
        btn.addEventListener('keyup', (e) => {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                stopHold();
            }
        });

        return { reset };
    }
    window.pkmSetupHoldButton = setupHoldButton;

    const importHoldCtrl = setupHoldButton(importSubmit, {
        holdMs: 950,
        confirmedLabel: 'Mengimpor Excel…',
        onConfirm: () => {
            window.setTimeout(() => {
                importForm?.submit();
            }, 340);
        },
    });

    function syncImportUi() {
        const file = importFile?.files?.[0];
        if (!importChip || !importSubmit || !importTrigger) return;
        importHoldCtrl.reset();
        if (file) {
            importName.textContent = file.name;
            importChip.hidden = false;
            importSubmit.hidden = false;
            importTrigger.hidden = true;
        } else {
            importChip.hidden = true;
            importSubmit.hidden = true;
            importTrigger.hidden = false;
        }
    }

    function openExportConfirm() {
        if (!exportChip || !exportHoldBtn) return;
        exportHoldCtrl.reset();
        exportChip.hidden = false;
        exportHoldBtn.hidden = false;
        dropZone?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => exportHoldBtn.focus({ preventScroll: true }), 220);
    }

    function closeExportConfirm() {
        if (!exportChip || !exportHoldBtn) return;
        exportHoldCtrl.reset();
        exportChip.hidden = true;
        exportHoldBtn.hidden = true;
    }

    function playEnvelopeSealAndExport(exportUrl) {
        if (!envelopeOverlay) {
            window.location.href = exportUrl;
            return;
        }

        envelopeOverlay.hidden = false;
        envelopeOverlay.setAttribute('aria-hidden', 'false');
        envelopeOverlay.classList.remove('is-playing');
        void envelopeOverlay.offsetWidth;
        envelopeOverlay.classList.add('is-playing');

        // Trigger download saat amplop tersegel dan mulai melesat pergi
        window.setTimeout(() => {
            window.location.href = exportUrl;
        }, 1250);

        // Bersihkan overlay & form konfirmasi export setelah animasi selesai
        window.setTimeout(() => {
            envelopeOverlay.classList.remove('is-playing');
            envelopeOverlay.hidden = true;
            envelopeOverlay.setAttribute('aria-hidden', 'true');
            closeExportConfirm();
        }, 2150);
    }

    const exportHoldCtrl = setupHoldButton(exportHoldBtn, {
        holdMs: 950,
        confirmedLabel: 'Menyegel File .xlsx…',
        onConfirm: () => {
            const url = exportHoldBtn?.dataset.exportUrl || exportTrigger?.getAttribute('href') || '/export';
            window.setTimeout(() => {
                playEnvelopeSealAndExport(url);
            }, 300);
        },
    });

    document.querySelectorAll('[data-export-trigger]').forEach((el) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            if (drawer?.open) drawer.close();
            if (trainerDetails?.open) trainerDetails.open = false;
            openExportConfirm();
        });
    });

    exportCancel?.addEventListener('click', () => {
        closeExportConfirm();
    });

    document.querySelectorAll('[data-action="import"]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (trainerDetails) trainerDetails.open = false;
            importFile?.click();
        });
    });

    importFile?.addEventListener('change', () => {
        syncImportUi();
        if (importFile.files?.length) {
            dropZone?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    importCancel?.addEventListener('click', () => {
        if (importFile) importFile.value = '';
        syncImportUi();
    });

    importForm?.addEventListener('submit', () => {
        if (importSubmit) {
            importSubmit.classList.add('is-loading');
            const lbl = importSubmit.querySelector('[data-label]');
            if (lbl) lbl.textContent = 'Mengimpor…';
        }
    });

    if (dropZone && importFile) {
        ['dragenter', 'dragover'].forEach((evt) => {
            dropZone.addEventListener(evt, (e) => {
                e.preventDefault();
                dropZone.classList.add('is-dragover');
            });
        });
        ['dragleave', 'drop'].forEach((evt) => {
            dropZone.addEventListener(evt, (e) => {
                e.preventDefault();
                dropZone.classList.remove('is-dragover');
            });
        });
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer?.files;
            if (files && files.length > 0) {
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                importFile.files = dt.files;
                syncImportUi();
            }
        });
    }

    // Tombol tutup alert
    document.querySelectorAll('[data-dismiss-alert]').forEach((btn) => {
        btn.addEventListener('click', () => {
            btn.closest('.alert')?.remove();
        });
    });

    /* ----------------------------------------------------------------------
       6. Tabel Pokédex: Search, Filter, Sort, & Paginasi (20 baris / halaman)
       ---------------------------------------------------------------------- */
    const PAGE_SIZE = 20;
    const tbody = document.getElementById('dexBody');
    const allRows = tbody ? Array.from(tbody.querySelectorAll('.dex-row')) : [];
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const genFilter = document.getElementById('genFilter');
    const resetPill = document.getElementById('resetPill');
    const resetGenPill = document.getElementById('resetGenPill');
    const resultCount = document.getElementById('resultCount');
    const emptyState = document.getElementById('emptyState');
    const noResult = document.getElementById('noResult');
    const noResultQuery = document.getElementById('noResultQuery');
    const pager = document.getElementById('pager');
    const sortButtons = Array.from(document.querySelectorAll('.dex-table th button[data-sort]'));
    const genChips = Array.from(document.querySelectorAll('[data-filter-gen]'));
    const typeChips = Array.from(document.querySelectorAll('[data-filter-type]'));

    let sortKey = 'num';
    let sortDir = 1; // 1 = asc, -1 = desc
    let currentPage = 1;
    let visibleNos = STATE.pokemons.map((p) => p.no);

    // Tandai baris baru hasil import
    if (Array.isArray(STATE.newIds) && STATE.newIds.length > 0) {
        const newSet = new Set(STATE.newIds);
        allRows.forEach((r) => {
            if (newSet.has(r.dataset.no)) r.classList.add('is-new');
        });
    }

    function normalizeQuery(q) {
        return q.trim().toLowerCase();
    }

    function rowMatches(row, q, typeVal, genVal) {
        if (typeVal) {
            const types = (row.dataset.types || '').split('|');
            if (!types.includes(typeVal.toLowerCase())) return false;
        }
        if (genVal && row.dataset.gen !== genVal) {
            return false;
        }
        if (q) {
            const name = row.dataset.name || '';
            const no = (row.dataset.no || '').toLowerCase();
            const num = row.dataset.num || '';
            const cleanQ = q.replace(/^#/, '').replace(/^0+/, '');
            const matchName = name.includes(q);
            const matchNo = no.includes(q) || (cleanQ !== '' && num === cleanQ);
            if (!matchName && !matchNo) return false;
        }
        return true;
    }

    function compareRows(a, b) {
        if (sortKey === 'num') {
            return (Number(a.dataset.num) - Number(b.dataset.num)) * sortDir;
        }
        if (sortKey === 'gen') {
            const diff = Number(a.dataset.genNum) - Number(b.dataset.genNum);
            return (diff !== 0 ? diff : Number(a.dataset.num) - Number(b.dataset.num)) * sortDir;
        }
        const av = a.dataset[sortKey] || '';
        const bv = b.dataset[sortKey] || '';
        return av.localeCompare(bv, 'id') * sortDir;
    }

    function syncFilterPills() {
        const tVal = typeFilter?.value || '';
        const gVal = genFilter?.value || '';

        genChips.forEach((chip) => {
            chip.setAttribute('aria-pressed', chip.dataset.filterGen === gVal ? 'true' : 'false');
        });
        typeChips.forEach((chip) => {
            chip.setAttribute('aria-pressed', chip.dataset.filterType === tVal ? 'true' : 'false');
        });

        if (resetGenPill) {
            resetGenPill.hidden = !gVal;
        }
        if (resetPill) {
            resetPill.hidden = !tVal;
        }

        const bentoGen = document.getElementById('bentoGenFilter');
        if (bentoGen && bentoGen.value !== gVal) {
            bentoGen.value = gVal;
        }
    }

    let totalPagesCount = 1;

    function renderPager(totalPages) {
        totalPagesCount = totalPages;
        if (!pager) return;
        if (totalPages <= 1) {
            pager.innerHTML = '';
            return;
        }

        // Tampilkan maksimal 5 tombol angka (1 2 3 4 5, bergeser bila halaman aktif > 5)
        const maxVisible = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

        const items = [];
        items.push(
            `<button type="button" data-page="1" ${currentPage === 1 ? 'disabled' : ''} aria-label="Halaman pertama" title="Halaman pertama">&laquo;</button>`,
            `<button type="button" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''} aria-label="Halaman sebelumnya" title="Halaman sebelumnya">&lsaquo;</button>`
        );

        for (let p = startPage; p <= endPage; p++) {
            const current = p === currentPage ? 'aria-current="page"' : '';
            items.push(`<button type="button" data-page="${p}" ${current}>${p}</button>`);
        }

        items.push(
            `<input type="text" inputmode="numeric" pattern="[0-9]*" class="pager__input" id="pagerJump" placeholder="…" aria-label="Ketik nomor halaman (1–${totalPages})" title="Ketik halaman (1–${totalPages}) lalu tekan Enter">`,
            `<button type="button" data-page-next="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''} aria-label="Halaman berikutnya" title="Halaman berikutnya">&rsaquo;</button>`,
            `<button type="button" data-page="${totalPages}" ${currentPage === totalPages ? 'disabled' : ''} aria-label="Halaman terakhir (${totalPages})" title="Langsung ke halaman terakhir (${totalPages})">&raquo;</button>`
        );

        pager.innerHTML = items.join('');
    }

    function applyTable(resetPage = false) {
        if (!tbody) return;
        if (resetPage) currentPage = 1;

        const q = normalizeQuery(searchInput?.value || '');
        const tVal = typeFilter?.value || '';
        const gVal = genFilter?.value || '';

        syncFilterPills();

        const matched = allRows.filter((r) => rowMatches(r, q, tVal, gVal));
        matched.sort(compareRows);
        visibleNos = matched.map((r) => r.dataset.no);

        const totalPages = Math.max(1, Math.ceil(matched.length / PAGE_SIZE));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PAGE_SIZE;
        const pageSet = new Set(matched.slice(start, start + PAGE_SIZE));

        // Susun ulang DOM sesuai urutan sort & sembunyikan baris di luar halaman aktif
        const frag = document.createDocumentFragment();
        matched.forEach((row) => {
            row.hidden = !pageSet.has(row);
            frag.appendChild(row);
        });
        allRows.forEach((row) => {
            if (!matched.includes(row)) {
                row.hidden = true;
                frag.appendChild(row);
            }
        });
        tbody.appendChild(frag);

        if (resultCount) resultCount.textContent = String(matched.length);

        if (allRows.length === 0) {
            if (emptyState) emptyState.hidden = false;
            if (noResult) noResult.hidden = true;
        } else {
            if (emptyState) emptyState.hidden = true;
            if (noResult) {
                noResult.hidden = matched.length > 0;
                if (noResultQuery) {
                    const parts = [q, tVal, gVal].filter(Boolean);
                    noResultQuery.textContent = parts.join(' · ') || 'filter saat ini';
                }
            }
        }

        renderPager(totalPages);
    }

    searchInput?.addEventListener('input', () => applyTable(true));
    typeFilter?.addEventListener('change', () => applyTable(true));
    genFilter?.addEventListener('change', () => applyTable(true));

    // Radar Efektivitas & Kelemahan Elemen (Kolom Tengah Bento)
    const TYPE_MATCHUPS = {
        Normal:   { strong: [], weak: ['Fighting'], resist: [], immune: ['Ghost'] },
        Fire:     { strong: ['Grass', 'Ice', 'Bug', 'Steel'], weak: ['Water', 'Ground', 'Rock'], resist: ['Fire', 'Grass', 'Ice', 'Bug', 'Steel', 'Fairy'], immune: [] },
        Water:    { strong: ['Fire', 'Ground', 'Rock'], weak: ['Electric', 'Grass'], resist: ['Fire', 'Water', 'Ice', 'Steel'], immune: [] },
        Grass:    { strong: ['Water', 'Ground', 'Rock'], weak: ['Fire', 'Ice', 'Poison', 'Flying', 'Bug'], resist: ['Water', 'Electric', 'Grass', 'Ground'], immune: [] },
        Electric: { strong: ['Water', 'Flying'], weak: ['Ground'], resist: ['Electric', 'Flying', 'Steel'], immune: [] },
        Ice:      { strong: ['Grass', 'Ground', 'Flying', 'Dragon'], weak: ['Fire', 'Fighting', 'Rock', 'Steel'], resist: ['Ice'], immune: [] },
        Fighting: { strong: ['Normal', 'Ice', 'Rock', 'Dark', 'Steel'], weak: ['Flying', 'Psychic', 'Fairy'], resist: ['Bug', 'Rock', 'Dark'], immune: [] },
        Poison:   { strong: ['Grass', 'Fairy'], weak: ['Ground', 'Psychic'], resist: ['Grass', 'Fighting', 'Poison', 'Bug', 'Fairy'], immune: [] },
        Ground:   { strong: ['Fire', 'Electric', 'Poison', 'Rock', 'Steel'], weak: ['Water', 'Grass', 'Ice'], resist: ['Poison', 'Rock'], immune: ['Electric'] },
        Flying:   { strong: ['Grass', 'Fighting', 'Bug'], weak: ['Electric', 'Ice', 'Rock'], resist: ['Grass', 'Fighting', 'Bug'], immune: ['Ground'] },
        Psychic:  { strong: ['Fighting', 'Poison'], weak: ['Bug', 'Ghost', 'Dark'], resist: ['Fighting', 'Psychic'], immune: [] },
        Bug:      { strong: ['Grass', 'Psychic', 'Dark'], weak: ['Fire', 'Flying', 'Rock'], resist: ['Grass', 'Fighting', 'Ground'], immune: [] },
        Rock:     { strong: ['Fire', 'Ice', 'Flying', 'Bug'], weak: ['Water', 'Grass', 'Fighting', 'Ground', 'Steel'], resist: ['Normal', 'Fire', 'Poison', 'Flying'], immune: [] },
        Ghost:    { strong: ['Psychic', 'Ghost'], weak: ['Ghost', 'Dark'], resist: ['Poison', 'Bug'], immune: ['Normal', 'Fighting'] },
        Dragon:   { strong: ['Dragon'], weak: ['Ice', 'Dragon', 'Fairy'], resist: ['Fire', 'Water', 'Grass', 'Electric'], immune: [] },
        Dark:     { strong: ['Psychic', 'Ghost'], weak: ['Fighting', 'Bug', 'Fairy'], resist: ['Ghost', 'Dark'], immune: ['Psychic'] },
        Steel:    { strong: ['Ice', 'Rock', 'Fairy'], weak: ['Fire', 'Fighting', 'Ground'], resist: ['Normal', 'Grass', 'Ice', 'Flying', 'Psychic', 'Bug', 'Rock', 'Dragon', 'Steel', 'Fairy'], immune: ['Poison'] },
        Fairy:    { strong: ['Fighting', 'Dragon', 'Dark'], weak: ['Poison', 'Steel'], resist: ['Fighting', 'Bug', 'Dark'], immune: ['Dragon'] },
        Stellar:  { strong: ['Tera (2×)'], weak: [], resist: [], immune: [] },
    };

    const typeMetaMap = window.POKEDEX?.types || {};
    let activeRadarType = 'Fire';
    const typeRadarCard = document.getElementById('typeRadarCard');
    const typeRadarPicker = document.getElementById('typeRadarPicker');
    const typeRadarPickerBtn = document.getElementById('typeRadarPickerBtn');
    const typeRadarDropdown = document.getElementById('typeRadarDropdown');
    const typeRadarIcon = document.getElementById('typeRadarIcon');
    const typeRadarName = document.getElementById('typeRadarName');
    const typeRadarCount = document.getElementById('typeRadarCount');
    const typeRadarStrong = document.getElementById('typeRadarStrong');
    const typeRadarWeak = document.getElementById('typeRadarWeak');
    const typeRadarResist = document.getElementById('typeRadarResist');

    function setRadarDropdownOpen(open) {
        if (!typeRadarDropdown || !typeRadarPickerBtn) return;
        typeRadarDropdown.hidden = !open;
        typeRadarPickerBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function renderRadarPillList(container, list, immuneList = []) {
        if (!container) return;
        container.innerHTML = '';
        const combined = list.map((name) => ({ name, immune: false }))
            .concat(immuneList.map((name) => ({ name, immune: true })));

        if (combined.length === 0) {
            const muted = document.createElement('span');
            muted.className = 'type-radar-pill type-radar-pill--muted';
            muted.textContent = 'Netral (1×)';
            container.appendChild(muted);
            return;
        }

        combined.forEach(({ name, immune }) => {
            const meta = typeMetaMap[name.toLowerCase()];
            const isSelectable = Boolean(meta);
            const pill = document.createElement(isSelectable ? 'button' : 'span');
            if (isSelectable) pill.type = 'button';
            pill.className = 'type-radar-pill' + (immune ? ' type-radar-pill--immune' : '');
            if (meta?.color) pill.style.setProperty('--pc', meta.color);

            if (meta?.icon) {
                const img = document.createElement('img');
                img.src = meta.icon;
                img.alt = '';
                img.width = 13;
                img.height = 13;
                pill.appendChild(img);
            }
            const txt = document.createElement('span');
            txt.textContent = immune ? `${name} (0×)` : name;
            pill.appendChild(txt);

            if (isSelectable) {
                pill.title = `Lihat Radar elemen ${name}`;
                pill.addEventListener('click', () => {
                    renderTypeRadar(meta.label);
                });
            }
            container.appendChild(pill);
        });
    }

    function renderTypeRadar(typeLabel) {
        const key = Object.keys(TYPE_MATCHUPS).find((k) => k.toLowerCase() === String(typeLabel || '').toLowerCase()) || 'Fire';
        activeRadarType = key;
        const rule = TYPE_MATCHUPS[key];
        const meta = typeMetaMap[key.toLowerCase()] || {};
        const pool = Array.isArray(window.POKEDEX?.pokemons) ? window.POKEDEX.pokemons : [];
        const totalOfType = pool.filter((p) => Array.isArray(p.types) && p.types.some((t) => t.toLowerCase() === key.toLowerCase())).length;

        if (typeRadarCard && meta.color) typeRadarCard.style.setProperty('--trc', meta.color);
        if (typeRadarIcon && meta.icon) {
            typeRadarIcon.src = meta.icon;
            typeRadarIcon.alt = key;
        }
        if (typeRadarName) typeRadarName.textContent = key;
        if (typeRadarCount) typeRadarCount.textContent = `${totalOfType} Pokémon`;

        if (typeRadarDropdown) {
            typeRadarDropdown.querySelectorAll('.type-radar-opt').forEach((opt) => {
                const active = String(opt.dataset.radarType || '').toLowerCase() === key.toLowerCase();
                opt.classList.toggle('is-active', active);
                opt.setAttribute('aria-selected', active ? 'true' : 'false');
            });
        }

        renderRadarPillList(typeRadarStrong, rule.strong);
        renderRadarPillList(typeRadarWeak, rule.weak);
        renderRadarPillList(typeRadarResist, rule.resist, rule.immune);
    }

    typeRadarPickerBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const willOpen = Boolean(typeRadarDropdown?.hidden);
        setRadarDropdownOpen(willOpen);
    });

    typeRadarDropdown?.addEventListener('click', (e) => {
        const opt = e.target.closest('.type-radar-opt');
        if (!opt) return;
        renderTypeRadar(opt.dataset.radarType);
        setRadarDropdownOpen(false);
        typeRadarPickerBtn?.focus();
    });

    document.addEventListener('click', (e) => {
        if (typeRadarPicker && !typeRadarPicker.contains(e.target)) {
            setRadarDropdownOpen(false);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && typeRadarDropdown && !typeRadarDropdown.hidden) {
            setRadarDropdownOpen(false);
            typeRadarPickerBtn?.focus();
        }
    });

    renderTypeRadar(activeRadarType);

    // Shortcut "/" untuk fokus ke kotak search
    document.addEventListener('keydown', (e) => {
        if (e.key === '/' && !e.ctrlKey && !e.metaKey && !e.altKey) {
            const tag = document.activeElement?.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || document.querySelector('dialog[open]')) {
                return;
            }
            e.preventDefault();
            searchInput?.focus();
            searchInput?.select();
        }
    });

    // Quick filter chips (Bento & Drawer)
    genChips.forEach((chip) => {
        chip.addEventListener('click', () => {
            if (!genFilter) return;
            const val = chip.dataset.filterGen || '';
            genFilter.value = genFilter.value === val ? '' : val;
            applyTable(true);
            document.getElementById('search')?.scrollIntoView({ behavior: 'smooth' });
        });
    });

    typeChips.forEach((chip) => {
        chip.addEventListener('click', () => {
            if (!typeFilter) return;
            const val = chip.dataset.filterType || '';
            typeFilter.value = typeFilter.value === val ? '' : val;
            applyTable(true);
            document.getElementById('search')?.scrollIntoView({ behavior: 'smooth' });
        });
    });

    document.querySelectorAll('[data-reset-gen]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (genFilter) genFilter.value = '';
            applyTable(true);
        });
    });

    document.querySelectorAll('[data-reset-type]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (typeFilter) typeFilter.value = '';
            applyTable(true);
        });
    });

    document.querySelectorAll('[data-reset-filters]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (typeFilter) typeFilter.value = '';
            if (genFilter) genFilter.value = '';
            applyTable(true);
        });
    });

    // Klik kartu "Indeks Terakhir" -> loncat langsung ke halaman terakhir tabel
    function jumpToLastTablePage(targetNo = '') {
        if (searchInput) searchInput.value = '';
        if (typeFilter) typeFilter.value = '';
        if (genFilter) genFilter.value = '';
        sortKey = 'num';
        sortDir = 1;
        sortButtons.forEach((b) => {
            const th = b.closest('th');
            if (!th) return;
            th.setAttribute('aria-sort', b.dataset.sort === 'num' ? 'ascending' : 'none');
        });

        currentPage = Math.max(1, Math.ceil(allRows.length / PAGE_SIZE));
        applyTable(false);

        const targetRow = targetNo
            ? allRows.find((r) => r.dataset.no === targetNo)
            : allRows[allRows.length - 1];

        if (targetRow) {
            targetRow.classList.remove('is-located');
            void targetRow.offsetWidth;
            targetRow.classList.add('is-located');
            targetRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            document.getElementById('search')?.scrollIntoView({ behavior: 'smooth' });
        }
    }

    document.querySelectorAll('[data-jump-last-page]').forEach((card) => {
        card.addEventListener('click', () => {
            jumpToLastTablePage(card.dataset.jumpLastPage || '');
        });
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                jumpToLastTablePage(card.dataset.jumpLastPage || '');
            }
        });
    });

    // Sort kolom
    sortButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.sort || 'num';
            if (sortKey === key) {
                sortDir *= -1;
            } else {
                sortKey = key;
                sortDir = 1;
            }
            sortButtons.forEach((b) => {
                const th = b.closest('th');
                if (!th) return;
                if (b === btn) {
                    th.setAttribute('aria-sort', sortDir === 1 ? 'ascending' : 'descending');
                } else {
                    th.setAttribute('aria-sort', 'none');
                }
            });
            applyTable(false);
        });
    });

    function jumpToPage(target) {
        const num = parseInt(String(target).trim(), 10);
        if (Number.isNaN(num)) return false;
        currentPage = Math.min(totalPagesCount, Math.max(1, num));
        applyTable(false);
        document.getElementById('search')?.scrollIntoView({ behavior: 'smooth' });
        return true;
    }

    // Klik halaman di paginasi (termasuk tombol > dan >>)
    pager?.addEventListener('click', (e) => {
        const nextBtn = e.target.closest('button[data-page-next]');
        if (nextBtn) {
            const jumpInput = document.getElementById('pagerJump');
            if (jumpInput && jumpInput.value.trim() !== '') {
                jumpToPage(jumpInput.value);
                return;
            }
            if (!nextBtn.disabled) {
                jumpToPage(nextBtn.dataset.pageNext);
            }
            return;
        }

        const btn = e.target.closest('button[data-page]');
        if (!btn || btn.disabled) return;
        jumpToPage(btn.dataset.page);
    });

    // Ketik nomor halaman di kotak input lalu tekan Enter (atau klik >)
    pager?.addEventListener('input', (e) => {
        if (e.target.id === 'pagerJump') {
            const nextBtn = pager.querySelector('button[data-page-next]');
            if (nextBtn) {
                nextBtn.disabled = e.target.value.trim() === '' && currentPage === totalPagesCount;
            }
        }
    });

    pager?.addEventListener('keydown', (e) => {
        if (e.target.id === 'pagerJump' && e.key === 'Enter') {
            e.preventDefault();
            jumpToPage(e.target.value);
        }
    });

    // Klik baris tabel -> buka Showcase
    tbody?.addEventListener('click', (e) => {
        if (e.target.closest('[data-open-pokemon]')) return; // ditangani listener global
        const row = e.target.closest('.dex-row');
        if (row?.dataset.no) openShowcase(row.dataset.no);
    });

    applyTable(true);

    /* ----------------------------------------------------------------------
       7. Showcase Modal (Character Showcase View + Deep-Link URL)
       ---------------------------------------------------------------------- */
    const showcase = document.getElementById('showcase');
    const scNo = document.getElementById('scNo');
    const scTotal = document.getElementById('scTotal');
    const scWatermark = document.getElementById('scWatermark');
    const scArt = document.getElementById('scArt');
    const scEyebrow = document.getElementById('scEyebrow');
    const scName = document.getElementById('scName');
    const scTypes = document.getElementById('scTypes');
    const scLore = document.getElementById('scLore');
    const scGallery = document.getElementById('scGallery');
    const scPrev = document.getElementById('scPrev');
    const scNext = document.getElementById('scNext');
    const scFeature = document.getElementById('scFeature');
    const scLocate = document.getElementById('scLocate');

    let currentShowcaseNo = null;
    let lastTriggerEl = null;

    function gallerySources(num) {
        return [
            { label: 'Official', url: `${SPRITE_BASE}/other/official-artwork/${num}.png`, pixel: false },
            { label: 'Shiny Art', url: `${SPRITE_BASE}/other/official-artwork/shiny/${num}.png`, pixel: false },
            { label: 'Front', url: `${SPRITE_BASE}/${num}.png`, pixel: true },
            { label: 'Shiny', url: `${SPRITE_BASE}/shiny/${num}.png`, pixel: true },
        ];
    }

    const enLoreCache = new Map();
    async function setEnglishLore(p) {
        if (!scLore || !p) return;
        if (enLoreCache.has(p.num)) {
            scLore.textContent = enLoreCache.get(p.num);
            return;
        }

        const fallback = `${p.name} is a ${p.types.join('/')}-type Pokémon native to the ${p.region || 'Kanto'} region.`;
        scLore.textContent = fallback;

        try {
            const res = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${p.num}`);
            if (!res.ok) throw new Error('Network error');
            const data = await res.json();
            const enEntry = data.flavor_text_entries?.find(e => e.language?.name === 'en');
            if (enEntry && enEntry.flavor_text) {
                const cleanText = enEntry.flavor_text
                    .replace(/[\f\n\r\t]/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
                enLoreCache.set(p.num, cleanText);
                if (currentShowcaseNo === p.no && scLore) {
                    scLore.textContent = cleanText;
                }
            }
        } catch (err) {
            enLoreCache.set(p.num, fallback);
        }
    }

    function populateShowcase(p, dir = 0) {
        if (!p || !showcase) return;
        currentShowcaseNo = p.no;

        if (dir !== 0 && !reducedMotion.matches) {
            showcase.style.setProperty('--dir', String(dir));
            showcase.classList.add('is-swapping');
            setTimeout(() => showcase.classList.remove('is-swapping'), 180);
        }

        const isEn = (localStorage.getItem('pokedex_lang') || 'id') === 'en';
        const padded = String(p.num).padStart(3, '0');
        if (scNo) scNo.textContent = `#${padded}`;
        if (scTotal) scTotal.textContent = String(STATE.total || STATE.pokemons.length);
        if (scWatermark) scWatermark.textContent = padded;
        if (scEyebrow) {
            const genText = isEn ? (p.generasi || '').replace('Generasi ', 'Generation ') : p.generasi;
            scEyebrow.textContent = `${p.no} · ${genText}`;
        }
        if (scName) scName.textContent = p.name;
        if (scTypes) scTypes.innerHTML = buildBadgeHtml(p.types, 'icons');
        if (scLore) {
            if (isEn) {
                setEnglishLore(p);
            } else {
                scLore.textContent = loreFor(p);
            }
        }
        updateInfoCards(p);

        const sources = gallerySources(p.num);
        if (scArt) {
            scArt.classList.remove('is-pixel');
            scArt.src = sources[0].url;
            scArt.alt = p.name;
        }
        if (scGallery) {
            scGallery.innerHTML = sources
                .map(
                    (s, i) => `
                    <button type="button" class="gallery__item ${s.pixel ? 'is-pixel' : ''}"
                            data-src="${s.url}" data-pixel="${s.pixel ? '1' : '0'}"
                            aria-pressed="${i === 0 ? 'true' : 'false'}" aria-label="${s.label} ${escapeHtml(p.name)}">
                        <img src="${s.url}" alt="" loading="lazy" width="120" height="80">
                        <span>${s.label}</span>
                    </button>`
                )
                .join('');
        }
    }

    scGallery?.addEventListener('click', (e) => {
        const btn = e.target.closest('.gallery__item');
        if (!btn || !scArt) return;
        scArt.src = btn.dataset.src || '';
        scArt.classList.toggle('is-pixel', btn.dataset.pixel === '1');
        scGallery.querySelectorAll('.gallery__item').forEach((el) => {
            el.setAttribute('aria-pressed', el === btn ? 'true' : 'false');
        });
    });

    function syncUrlWithPokemon(no, replace = false) {
        const url = new URL(window.location.href);
        const param = no ? no.replace(/^#/, '') : null;
        if (param) url.searchParams.set('pokemon', param);
        else url.searchParams.delete('pokemon');

        if (replace) window.history.replaceState({ pokemon: no }, '', url);
        else window.history.pushState({ pokemon: no }, '', url);
    }

    function openShowcase(no, { pushUrl = true, dir = 0 } = {}) {
        const p = byNo.get(no);
        if (!p || !showcase) return;

        const wasOpen = showcase.open;
        if (!wasOpen) {
            lastTriggerEl = document.activeElement;
        }

        populateShowcase(p, wasOpen ? dir : 0);

        if (!wasOpen) {
            showcase.showModal();
        }
        if (pushUrl) {
            syncUrlWithPokemon(p.no, wasOpen);
        }
    }

    function stepShowcase(delta) {
        const list = visibleNos.length > 0 ? visibleNos : STATE.pokemons.map((p) => p.no);
        if (list.length === 0 || !currentShowcaseNo) return;
        const idx = list.indexOf(currentShowcaseNo);
        const nextIdx = ((idx + delta) % list.length + list.length) % list.length;
        openShowcase(list[nextIdx], { pushUrl: true, dir: delta });
    }

    scPrev?.addEventListener('click', () => stepShowcase(-1));
    scNext?.addEventListener('click', () => stepShowcase(1));

    // Tombol "Jadikan Featured" di dalam Showcase
    scFeature?.addEventListener('click', () => {
        const p = byNo.get(currentShowcaseNo);
        if (!p) return;
        promoteToHero(p);
        scFeature.classList.add('is-done');
        scFeature.lastChild.textContent = ' Ditampilkan di Hero';
    });

    // Tombol "Lihat di Tabel" di dalam Showcase
    scLocate?.addEventListener('click', async () => {
        const targetNo = currentShowcaseNo;
        if (!targetNo) return;
        await closeTopLayer(showcase);

        // Pastikan baris tidak tersembunyi oleh filter
        if (!visibleNos.includes(targetNo)) {
            if (searchInput) searchInput.value = '';
            if (typeFilter) typeFilter.value = '';
            if (genFilter) genFilter.value = '';
            applyTable(true);
        }
        const pos = visibleNos.indexOf(targetNo);
        if (pos >= 0) {
            currentPage = Math.floor(pos / PAGE_SIZE) + 1;
            applyTable(false);
        }
        const row = tbody?.querySelector(`.dex-row[data-no="${CSS.escape(targetNo)}"]`);
        if (row) {
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            row.classList.remove('is-located');
            void row.offsetWidth;
            row.classList.add('is-located');
            row.querySelector('.row-link')?.focus({ preventScroll: true });
        }
    });

    // Klik elemen apa pun yang memiliki [data-open-pokemon]
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-open-pokemon]');
        if (trigger) {
            openShowcase(trigger.dataset.openPokemon);
        }
    });

    // Navigasi panah kiri/kanan & swipe di dalam Showcase
    document.addEventListener('keydown', (e) => {
        if (!showcase?.open) return;
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            stepShowcase(-1);
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            stepShowcase(1);
        }
    });

    let touchStartX = null;
    showcase?.addEventListener(
        'touchstart',
        (e) => {
            touchStartX = e.changedTouches?.[0]?.clientX ?? null;
        },
        { passive: true }
    );
    showcase?.addEventListener(
        'touchend',
        (e) => {
            if (touchStartX === null) return;
            const dx = (e.changedTouches?.[0]?.clientX ?? touchStartX) - touchStartX;
            if (Math.abs(dx) > 50) stepShowcase(dx < 0 ? 1 : -1);
            touchStartX = null;
        },
        { passive: true }
    );

    showcase?.addEventListener('close', () => {
        currentShowcaseNo = null;
        const url = new URL(window.location.href);
        if (url.searchParams.has('pokemon')) {
            syncUrlWithPokemon(null, true);
        }
        if (lastTriggerEl && typeof lastTriggerEl.focus === 'function') {
            lastTriggerEl.focus({ preventScroll: true });
        }
    });

    window.addEventListener('popstate', () => {
        const param = new URL(window.location.href).searchParams.get('pokemon');
        if (param) {
            const match = findPokemonByParam(param);
            if (match) openShowcase(match.no, { pushUrl: false });
        } else if (showcase?.open) {
            closeTopLayer(showcase);
        }
    });

    function findPokemonByParam(raw) {
        const clean = String(raw).trim();
        const direct = byNo.get(clean) || byNo.get(`#${clean.padStart(4, '0')}`);
        if (direct) return direct;
        const num = parseInt(clean.replace(/\D/g, ''), 10);
        return STATE.pokemons.find((p) => p.num === num) || null;
    }

    // Buka otomatis bila URL memiliki ?pokemon=...
    const initialParam = new URL(window.location.href).searchParams.get('pokemon');
    if (initialParam) {
        const match = findPokemonByParam(initialParam);
        if (match) openShowcase(match.no, { pushUrl: false });
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, (c) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
        }[c]));
    }

    // =========================================================================
    // FITUR MULTI-BAHASA (INDONESIA / ENGLISH) DENGAN SKELETON SHIMMER & POPUP KONFIRMASI - v1.2.4
    // =========================================================================
    const FLAG_ID_SVG = `<svg viewBox="0 0 24 16" width="100%" height="100%" preserveAspectRatio="none" aria-hidden="true" style="display:block;"><rect width="24" height="8" fill="#E70011"/><rect y="8" width="24" height="8" fill="#FFFFFF"/></svg>`;
    const FLAG_EN_SVG = `<svg viewBox="0 0 60 30" width="100%" height="100%" preserveAspectRatio="none" aria-hidden="true" style="display:block;"><clipPath id="uk-clip-dyn"><rect width="60" height="30"/></clipPath><g clip-path="url(#uk-clip-dyn)"><rect width="60" height="30" fill="#012169"/><path d="M0 0 L60 30 M60 0 L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0 L60 30 M60 0 L0 30" stroke="#C8102E" stroke-width="2"/><path d="M30 0 v30 M0 15 h60" stroke="#fff" stroke-width="10"/><path d="M30 0 v30 M0 15 h60" stroke="#C8102E" stroke-width="6"/></g></svg>`;

    const I18N_DICTIONARY = {
        id: {
            nav_home: "Beranda",
            nav_explore: "Eksplorasi",
            nav_caught: "Koleksi",
            nav_library: "Pustaka",
            nav_home_sub: "Fun Facts Pokémon",
            nav_explore_sub: "Kontrol Data & Statistik",
            nav_caught_sub: "Pokédex Caught Tracker",
            nav_library_sub: "Tabel Data Pokédex",
            drawer_label_nav: "Navigasi",
            drawer_label_account: "Akun Trainer",
            drawer_label_lang: "Bahasa / Language",
            btn_login_or_register: "Masuk / Daftar Akun",
            btn_switch_acc: "Ganti Akun",
            btn_logout: "Keluar",
            btn_login: "Masuk",
            top_made_by: "Made By",
            id_group_lbl: "Kelompok",
            id_group_val: "Kelompok 13",
            id_class_lbl: "Kelas Praktikum",
            id_class_val: "Kelas A / A2",
            guide_kicker: "Distribusi Wilayah",
            guide_title: "Generasi I – IX",
            region_panel_sub: "Populasi Regional",
            region_panel_badge: "9 Region · Filter",
            region_panel_hint: "Klik wilayah mana saja untuk langsung menyaring tabel Pustaka Pokémon.",
            guide_struct_title: "Struktur Excel",
            guide_struct_badge: "4 Kolom Wajib",
            guide_val_title: "Validasi Import",
            guide_val_badge: "3 Status Cek",
            rule_success_title: "Berhasil",
            rule_success_desc: "4 kolom sesuai & nomor index baru",
            rule_dup_title: "Ditolak (Duplikat)",
            rule_dup_desc: "Nomor index sudah ada di database",
            rule_invalid_title: "Tidak Valid",
            rule_invalid_desc: "Ada kolom kosong atau data tidak cocok",
            control_kicker: "Kontrol Data & Koleksi",
            control_title: "Excel & Filter",
            control_import_title: "Import Pokemon untuk Database",
            control_import_btn: "Import Pokemon untuk Database",
            badge_dev_feature: "Fitur Developer",
            badge_locked_dev: "Terkunci (Dev Only)",
            control_import_sub_dev: "Khusus Developer · Perbarui atau tambahkan semua Pokémon terbaru ke Library (.xlsx)",
            control_import_sub_guest: "Khusus 4 Akun Developer (Kelompok 13) · Klik untuk info & login",
            pill_gen_filter: "Filter Generasi",
            opt_all_generations: "Semua Generasi (Pilih Gen 1 – 9)",
            pill_type_filter: "Filter Tipe",
            pill_type_radar: "Radar Efektivitas Tipe",
            radar_hint_badge: "Pilih Elemen",
            radar_super_lbl: "2× Efektif Serang",
            radar_weak_lbl: "2× Kelemahan",
            radar_resist_lbl: "½× / 0× Resistensi",
            btn_reset_filter: "Reset filter ×",
            drop_hint_dev: "Tarik & lepas file .xlsx langsung ke panel ini untuk import cepat",
            drop_hint_guest: "Mode Read-Only · Fitur Import Spreadsheet khusus akun Developer",
            btn_open_dev_switch: "Buka Switch Developer (K13)",
            stats_kicker: "Statistik Database",
            stats_title: "Progress Koleksi",
            card_caught_kicker: "Koleksi Pokédex",
            guest_caught_title: "Belum Masuk Akun",
            guest_caught_desc: 'Silakan <a href="javascript:void(0)" onclick="openAuthModal(\'loginTab\')" style="color: var(--crimson, #ff4655); font-weight: 700; text-decoration: underline;">Masuk</a> atau <a href="javascript:void(0)" onclick="openAuthModal(\'registerTab\')" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">Daftar</a> untuk mulai melacak progres koleksi Pokémon Anda.',
            card_lib_kicker: "Kelengkapan Library",
            card_lib_title: "Semua 9 Generasi Terdaftar (Gen I–IX)",
            card_lib_desc: "Seluruh 1.025 Pokémon (Gen I–IX) telah lengkap terdaftar!",
            card_last_kicker: "Indeks Terakhir",
            card_last_jump: "Hal. 1 ↗",
            pokedex_kicker: "Pustaka Pokémon",
            pokedex_title: "Data Master Pokémon",
            caught_kicker: "Pokédex Collection Tracker",
            caught_title: "Koleksi Tangkapan Trainer",
            caught_subtitle: "Daftar Pokémon yang berhasil Anda tangkap di lapangan, lengkap dengan lokasi dan catatan strategi.",
            btn_add_collection: "Tambah Koleksi",
            btn_export_data: "Ekspor Data",
            btn_export_excel: "Ekspor Excel",
            btn_export_pdf: "Unduh Laporan PDF",
            search_placeholder: "Cari nama atau nomor index…",
            opt_all_types: "Semua tipe (19)",
            th_no_index: "NO INDEX",
            th_sprite: "SPRITE",
            th_pokemon_name: "NAMA POKÉMON",
            th_type: "TIPE",
            th_generation: "GENERASI",
            th_caught_date: "TANGGAL TANGKAP",
            th_actions: "AKSI & JURNAL",
            btn_edit_date: "Tanggal",
            btn_delete: "Hapus",
            btn_tactics: "Taktik",
            journal_modal_title: "Jurnal Taktis Trainer",
            journal_modal_sub: "Analisis Medan & Strategi Bertarung",
            journal_caught_date: "Tanggal Tangkap",
            journal_caught_loc: "Lokasi Penangkapan",
            journal_title: "Judul Strategi",
            journal_tactics_notes: "Catatan & Analisis Taktik (WYSIWYG)",
            btn_delete_journal: "Hapus Catatan",
            btn_save_journal: "Simpan Jurnal Taktik",
            lbl_edit_caught_at: "Tanggal Penangkapan Baru",
            format_dmy_hint: "Format: Tanggal - Bulan - Tahun (DD/MM/YYYY)",
            modal_edit_caught_title: "Edit Tanggal Tangkap",
            modal_edit_caught_subtitle: "Ubah riwayat tanggal penangkapan Pokémon",
            lbl_caught_date_format: "Tanggal Penangkapan (Tanggal - Bulan - Tahun)",
            btn_open_account_menu: "Masuk / Buka Menu Akun",
            btn_close: "Tutup",
            btn_open_login_menu: "Buka Menu Login / Daftar",
            hero_readmore: "(selengkapnya...)",
            hero_eyebrow_prefix: "Fun Fact",
            fact_modal_hint: "Tekan <kbd>Esc</kbd> atau klik di luar kartu untuk menutup",
            dev_lock_title: "Akses Fitur Terkunci",
            dev_lock_badge: "Khusus Developer Kelompok 13",
            guide_col_idx: "nomor_index",
            guide_col_name: "nama_pokemon",
            guide_col_type: "tipe",
            guide_col_gen: "generasi",
            guide_col_gen_val: "Generasi I (Kanto)",
            sc_brand: "Pokédex",
            sc_sprites_label: "Sprites",
            sc_nav_hint: "Gunakan ← → untuk berpindah · Esc untuk menutup",
            footer_team: "Pokédex - Kelompok 13 - Kelas A / A2",
            footer_meta: "Laravel 11 · PhpSpreadsheet · Artwork dari PokeAPI",
            tab_login: "Login",
            tab_register: "Daftar",
            tab_switch_dev: "Switch Dev (K13)"
        },
        en: {
            nav_home: "Home",
            nav_explore: "Explore",
            nav_caught: "Collection",
            nav_library: "Library",
            nav_home_sub: "Pokémon Fun Facts",
            nav_explore_sub: "Data Controls & Stats",
            nav_caught_sub: "Pokédex Caught Tracker",
            nav_library_sub: "Pokédex Master Table",
            drawer_label_nav: "Navigation",
            drawer_label_account: "Trainer Account",
            drawer_label_lang: "Language / Bahasa",
            btn_login_or_register: "Login / Register",
            btn_switch_acc: "Switch Account",
            btn_logout: "Logout",
            btn_login: "Login",
            top_made_by: "Made By",
            id_group_lbl: "Group",
            id_group_val: "Group 13",
            id_class_lbl: "Practicum Class",
            id_class_val: "Class A / A2",
            guide_kicker: "Region Distribution",
            guide_title: "Generations I – IX",
            region_panel_sub: "Regional Population",
            region_panel_badge: "9 Regions · Filter",
            region_panel_hint: "Click any region above to instantly filter the Pokémon Library table.",
            guide_struct_title: "Excel Structure",
            guide_struct_badge: "4 Required Columns",
            guide_val_title: "Import Validation",
            guide_val_badge: "3 Status Checks",
            rule_success_title: "Success",
            rule_success_desc: "4 valid columns & unique index number",
            rule_dup_title: "Rejected (Duplicate)",
            rule_dup_desc: "Index number already exists in database",
            rule_invalid_title: "Invalid Format",
            rule_invalid_desc: "Empty columns or mismatched data types",
            control_kicker: "Data & Collection Controls",
            control_title: "Excel & Filter",
            control_import_title: "Import Pokemon for Database",
            control_import_btn: "Import Pokemon for Database",
            badge_dev_feature: "Developer Feature",
            badge_locked_dev: "Locked (Dev Only)",
            control_import_sub_dev: "Developer Exclusive · Update or append new Pokémon to Library (.xlsx)",
            control_import_sub_guest: "Developer Exclusive (Group 13) · Click for info & login",
            pill_gen_filter: "Generation Filter",
            opt_all_generations: "All Generations (Select Gen 1 – 9)",
            pill_type_filter: "Type Filter",
            pill_type_radar: "Type Effectiveness Radar",
            radar_hint_badge: "Select Element",
            radar_super_lbl: "2× Super Effective",
            radar_weak_lbl: "2× Weak Against",
            radar_resist_lbl: "½× / 0× Resistances",
            btn_reset_filter: "Reset filter ×",
            drop_hint_dev: "Drag & drop .xlsx file directly into this panel for fast import",
            drop_hint_guest: "Read-Only Mode · Spreadsheet Import is restricted to Developer accounts",
            btn_open_dev_switch: "Open Dev Switcher (G13)",
            stats_kicker: "Database Statistics",
            stats_title: "Collection Progress",
            card_caught_kicker: "Pokédex Collection",
            guest_caught_title: "Not Logged In",
            guest_caught_desc: 'Please <a href="javascript:void(0)" onclick="openAuthModal(\'loginTab\')" style="color: var(--crimson, #ff4655); font-weight: 700; text-decoration: underline;">Log In</a> or <a href="javascript:void(0)" onclick="openAuthModal(\'registerTab\')" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">Register</a> to start tracking your Pokémon catch collection.',
            card_lib_kicker: "Library Completeness",
            card_lib_title: "All 9 Generations Registered (Gen I–IX)",
            card_lib_desc: "All 1,025 Pokémon (Gen I–IX) are fully registered in the catalog!",
            card_last_kicker: "Last Index",
            card_last_jump: "Page 1 ↗",
            pokedex_kicker: "Pokémon Library",
            pokedex_title: "Pokédex Master Data",
            caught_kicker: "Pokédex Collection Tracker",
            caught_title: "Trainer Catch Collection",
            caught_subtitle: "List of Pokémon you caught in the wild, complete with capture date, location, and tactics.",
            btn_add_collection: "Add Collection",
            btn_export_data: "Export Data",
            btn_export_excel: "Export Excel",
            btn_export_pdf: "Download PDF Report",
            search_placeholder: "Search name or index number…",
            opt_all_types: "All types (19)",
            th_no_index: "INDEX NO",
            th_sprite: "SPRITE",
            th_pokemon_name: "POKÉMON NAME",
            th_type: "TYPE",
            th_generation: "GENERATION",
            th_caught_date: "CAUGHT DATE",
            th_actions: "ACTIONS & JOURNAL",
            btn_edit_date: "Date",
            btn_delete: "Delete",
            btn_tactics: "Tactics",
            journal_modal_title: "Trainer Tactical Journal",
            journal_modal_sub: "Field Analysis & Battle Strategy",
            journal_caught_date: "Caught Date",
            journal_caught_loc: "Capture Location",
            journal_title: "Strategy Title",
            journal_tactics_notes: "Tactical Notes & Analysis (WYSIWYG)",
            btn_delete_journal: "Delete Note",
            btn_save_journal: "Save Tactical Journal",
            lbl_edit_caught_at: "New Capture Date",
            format_dmy_hint: "Format: Day - Month - Year (DD/MM/YYYY)",
            modal_edit_caught_title: "Edit Capture Date",
            modal_edit_caught_subtitle: "Modify Pokémon capture date history",
            lbl_caught_date_format: "Capture Date (Day - Month - Year)",
            btn_open_account_menu: "Log In / Open Account Menu",
            btn_close: "Close",
            btn_open_login_menu: "Open Login / Register Menu",
            hero_readmore: "(read more...)",
            hero_eyebrow_prefix: "Fun Fact",
            fact_modal_hint: "Press <kbd>Esc</kbd> or click outside card to close",
            dev_lock_title: "Feature Access Locked",
            dev_lock_badge: "Group 13 Developer Exclusive",
            guide_col_idx: "index_number",
            guide_col_name: "pokemon_name",
            guide_col_type: "type",
            guide_col_gen: "generation",
            guide_col_gen_val: "Generation I (Kanto)",
            sc_brand: "Pokédex",
            sc_sprites_label: "Sprites",
            sc_nav_hint: "Use ← → to navigate · Esc to close",
            footer_team: "Pokédex - Group 13 - Class A / A2",
            footer_meta: "Laravel 11 · PhpSpreadsheet · Artwork from PokéAPI",
            tab_login: "Login",
            tab_register: "Register",
            tab_switch_dev: "Switch Dev (G13)"
        }
    };

    let pendingTargetLang = null;

    window.closeLangConfirmModal = function() {
        const modal = document.getElementById('langConfirmModal');
        if (modal) modal.hidden = true;
        pendingTargetLang = null;
    };

    function requestLanguageSwitch(targetLang) {
        const currentLang = localStorage.getItem('pokedex_lang') || 'id';
        if (targetLang === currentLang) {
            const drawer = document.getElementById('drawer');
            if (drawer && drawer.open) drawer.close();
            return;
        }

        pendingTargetLang = targetLang;
        const modal = document.getElementById('langConfirmModal');
        const fromFlag = document.getElementById('langConfirmFromFlag');
        const toFlag = document.getElementById('langConfirmToFlag');
        const titleEl = document.getElementById('langConfirmTitle');
        const descEl = document.getElementById('langConfirmDesc');
        const cancelBtn = document.getElementById('langConfirmBtnCancel');
        const okBtn = document.getElementById('langConfirmBtnOk');

        if (fromFlag) fromFlag.innerHTML = currentLang === 'id' ? FLAG_ID_SVG : FLAG_EN_SVG;
        if (toFlag) toFlag.innerHTML = targetLang === 'id' ? FLAG_ID_SVG : FLAG_EN_SVG;

        if (targetLang === 'en') {
            titleEl.textContent = 'Switch Language to English?';
            descEl.textContent = 'All interface headers, guide cards, database statistics, and interactive tables will be translated instantly.';
            if (cancelBtn) cancelBtn.textContent = 'Cancel';
            if (okBtn) okBtn.textContent = 'Yes, Switch to English';
        } else {
            titleEl.textContent = 'Ganti Bahasa ke Indonesia?';
            descEl.textContent = 'Seluruh judul antarmuka, kartu panduan, statistik database, dan tabel interaktif akan disesuaikan ke Bahasa Indonesia.';
            if (cancelBtn) cancelBtn.textContent = 'Batal';
            if (okBtn) okBtn.textContent = 'Ya, Ganti ke Indonesia';
        }

        const drawer = document.getElementById('drawer');
        if (drawer && drawer.open) drawer.close();

        if (modal) modal.hidden = false;
    }

    function applyLanguageWithShimmer(lang) {
        const main = document.getElementById('main') || document.body;
        main.classList.remove('lang-shimmer-active');
        void main.offsetWidth; // trigger reflow
        main.classList.add('lang-shimmer-active');

        setLanguage(lang);

        document.querySelectorAll('[data-i18n]').forEach((el) => {
            el.classList.remove('type-revealed');
            void el.offsetWidth;
            el.classList.add('type-revealed');
        });

        setTimeout(() => {
            main.classList.remove('lang-shimmer-active');
            document.querySelectorAll('.type-revealed').forEach(el => el.classList.remove('type-revealed'));
        }, 350);
    }

    function setLanguage(lang) {
        if (!['id', 'en'].includes(lang)) lang = 'id';
        localStorage.setItem('pokedex_lang', lang);
        const dict = I18N_DICTIONARY[lang];
        const isEn = lang === 'en';

        document.querySelectorAll('[data-i18n]').forEach((el) => {
            const key = el.getAttribute('data-i18n');
            if (dict[key]) {
                if (dict[key].includes('<')) {
                    el.innerHTML = dict[key];
                } else {
                    el.textContent = dict[key];
                }
            }
        });

        const searchInput = document.getElementById('searchInput');
        if (searchInput && dict.search_placeholder) {
            searchInput.placeholder = dict.search_placeholder;
        }

        const bentoGenFirstOpt = document.querySelector('#bentoGenFilter option[value=""]');
        if (bentoGenFirstOpt && dict.opt_all_generations) {
            bentoGenFirstOpt.textContent = dict.opt_all_generations;
        }

        const typeFilterFirstOpt = document.querySelector('#typeFilter option[value=""]');
        if (typeFilterFirstOpt && dict.opt_all_types) {
            typeFilterFirstOpt.textContent = dict.opt_all_types;
        }

        // 1. Update Hero Slides & Fact Modal
        slides.forEach((slide) => {
            const d = slide.dataset;
            const topic = isEn ? (d.factTopicEn || d.factTopicId) : d.factTopicId;
            const title = isEn ? (d.factTitleEn || d.factTitleId) : d.factTitleId;
            const desc = isEn ? (d.factDescEn || d.factDescId) : d.factDescId;
            const cat = isEn ? (d.factCategoryEn || d.factCategoryId) : d.factCategoryId;
            const src = isEn ? (d.factSourceEn || d.factSourceId) : d.factSourceId;

            if (topic) d.factTopic = topic;
            if (title) d.factTitle = title;
            if (desc) d.factDesc = desc;
            if (cat) d.factCategory = cat;
            if (src) d.factSource = src;

            const topicEl = slide.querySelector('.hero-topic-text');
            if (topicEl && topic) topicEl.textContent = topic;

            const titleEl = slide.querySelector('.hero-title-text');
            if (titleEl && title) titleEl.textContent = title;

            const descEl = slide.querySelector('.hero-desc-preview');
            if (descEl && desc) {
                const short = desc.length > 148 ? desc.slice(0, 148).trim() : desc;
                descEl.textContent = short + '…';
            }

            const catEl = slide.querySelector('.hero-cat-text');
            if (catEl && cat) catEl.textContent = cat;

            const srcEl = slide.querySelector('.hero-src-text');
            if (srcEl && src) srcEl.textContent = src;
        });

        if (factModal && factModal.open) {
            const activeSlideEl = slides[activeSlide] || slides[0];
            if (activeSlideEl) {
                const d = activeSlideEl.dataset;
                if (factModalTopic) factModalTopic.textContent = `Fun Fact · ${d.factTopic || ''}`;
                if (factModalCategory) factModalCategory.textContent = d.factCategory || 'Fun Fact';
                if (factModalSource) factModalSource.textContent = d.factSource || '';
                if (factModalTitle) factModalTitle.textContent = d.factTitle || '';
                if (factModalDesc) factModalDesc.textContent = d.factDesc || '';
            }
        }

        // 2. Bento Card 3: Caught status count & description
        const caughtStatus = document.getElementById('caughtStatusCount');
        if (caughtStatus) {
            const count = caughtStatus.getAttribute('data-count') || caughtStatus.textContent.match(/\d+/)?.[0] || '0';
            caughtStatus.setAttribute('data-count', count);
            caughtStatus.textContent = isEn ? `${count} of 1,025 Pokémon` : `${count} dari 1.025 Pokémon`;
        }

        const caughtDesc = document.getElementById('caughtStatusDesc');
        if (caughtDesc) {
            const count = parseInt(caughtStatus?.getAttribute('data-count') || '0', 10);
            if (isEn) {
                caughtDesc.textContent = count > 0
                    ? "Total Pokémon you successfully caught & recorded in your personal Pokédex."
                    : "No catches yet. Add your first collection!";
            } else {
                caughtDesc.textContent = count > 0
                    ? "Total Pokémon yang berhasil Anda tangkap & tercatat di Pokédex pribadi."
                    : "Belum ada tangkapan. Tambahkan koleksi pertama Anda!";
            }
        }

        document.querySelectorAll('.top-last-gen').forEach((el) => {
            if (!el.getAttribute('data-raw-gen')) {
                el.setAttribute('data-raw-gen', el.textContent.trim());
            }
            const raw = el.getAttribute('data-raw-gen');
            el.textContent = isEn ? raw.replace('Generasi ', 'Generation ') : raw;
        });

        const submeta = document.getElementById('lastIndexSubmeta');
        if (submeta) {
            const total = submeta.getAttribute('data-total') || '1025';
            const max = submeta.getAttribute('data-max') || '1025';
            const next = submeta.getAttribute('data-next') || 'Lengkap';
            if (Number(total) >= Number(max)) {
                submeta.innerHTML = isEn
                    ? `Entry #<strong>${total}</strong> · <strong>All ${max} Pokémon Registered!</strong>`
                    : `Entri ke-<strong>${total}</strong> · <strong>Seluruh ${max} Pokémon Terdaftar!</strong>`;
            } else {
                submeta.innerHTML = isEn
                    ? `Entry #<strong>${total}</strong> · Next import target: <strong>${next}</strong>`
                    : `Entri ke-<strong>${total}</strong> · Target import berikutnya: <strong>${next}</strong>`;
            }
        }

        const devLockDesc = document.getElementById('devLockDesc');
        if (devLockDesc) {
            const isAuth = devLockDesc.getAttribute('data-auth') === '1';
            const userName = devLockDesc.getAttribute('data-name') || 'Trainer';
            if (isEn) {
                if (!isAuth) {
                    devLockDesc.innerHTML = 'The <strong>Import Master Dataset (.xlsx)</strong> feature is restricted to <strong>4 Developer Accounts</strong> (Yanuar, Arya, Madina, Iasha) to protect the integrity of the 1,025 Pokémon catalog database.<br><br>Please switch to a Developer account via the menu below:';
                } else {
                    devLockDesc.innerHTML = `You are currently signed in as <strong>${escapeHtml(userName)}</strong> with <strong>TRAINER</strong> status.<br><br>Regular Trainer accounts have read-only catalog access. Master data import authority is strictly reserved for the 4 Group 13 Developers.`;
                }
            } else {
                if (!isAuth) {
                    devLockDesc.innerHTML = 'Fitur <strong>Import Master Dataset (.xlsx)</strong> dilindungi dan hanya dapat diakses oleh <strong>4 Akun Developer</strong> (Yanuar, Arya, Madina, Iasha) untuk menjaga integritas database katalog 1.025 Pokémon.<br><br>Silakan beralih ke akun Developer melalui menu di bawah:';
                } else {
                    devLockDesc.innerHTML = `Anda saat ini masuk sebagai <strong>${escapeHtml(userName)}</strong> dengan status <strong>TRAINER</strong>.<br><br>Pengguna umum berstatus Trainer hanya memiliki izin melihat katalog Pokémon (<em>Read-Only</em>). Otoritas import master data dibatasi khusus untuk 4 Developer Kelompok 13.`;
                }
            }
        }

        // 3. Table Rows & Generation Filter Options
        allRows.forEach((r) => {
            const genCell = r.querySelector('.dex-gen');
            if (genCell) {
                if (!genCell.getAttribute('data-raw-gen')) {
                    genCell.setAttribute('data-raw-gen', genCell.textContent.trim());
                }
                const raw = genCell.getAttribute('data-raw-gen');
                genCell.textContent = isEn ? raw.replace('Generasi ', 'Generation ') : raw;
            }
        });

        document.querySelectorAll('.caught-gen-cell').forEach((cell) => {
            if (!cell.getAttribute('data-raw-gen')) {
                cell.setAttribute('data-raw-gen', cell.textContent.trim());
            }
            const raw = cell.getAttribute('data-raw-gen');
            cell.textContent = isEn ? raw.replace('Generasi ', 'Generation ') : raw;
        });

        const genSelect = document.getElementById('genFilter');
        if (genSelect) {
            Array.from(genSelect.options).forEach((opt, idx) => {
                if (idx === 0) {
                    opt.textContent = isEn ? 'All generations (Gen I – IX)' : 'Semua generasi (Gen I – IX)';
                } else {
                    if (!opt.getAttribute('data-raw-text')) {
                        opt.setAttribute('data-raw-text', opt.textContent.trim());
                    }
                    const raw = opt.getAttribute('data-raw-text');
                    opt.textContent = isEn ? raw.replace('Generasi ', 'Generation ') : raw;
                }
            });
        }

        // 4. Showcase Modal (if open)
        if (showcase && showcase.open && currentShowcaseNo) {
            const curP = byNo.get(currentShowcaseNo);
            if (curP) {
                if (scEyebrow) {
                    const genText = isEn ? (curP.generasi || '').replace('Generasi ', 'Generation ') : curP.generasi;
                    scEyebrow.textContent = `${curP.no} · ${genText}`;
                }
                if (scLore) {
                    if (isEn) {
                        setEnglishLore(curP);
                    } else {
                        scLore.textContent = loreFor(curP);
                    }
                }
            }
        }

        // 5. Header / Drawer language pills & flags
        const langText = document.getElementById('langCurrentText');
        if (langText) {
            langText.textContent = lang.toUpperCase();
        }

        const flagContainer = document.getElementById('langFlagContainer');
        if (flagContainer) {
            flagContainer.innerHTML = lang === 'id' ? FLAG_ID_SVG : FLAG_EN_SVG;
        }

        document.querySelectorAll('.lang-choice-btn').forEach((btn) => {
            if (btn.getAttribute('data-lang') === lang) {
                btn.style.borderColor = '#ff4655';
                btn.style.color = '#ff4655';
                btn.style.background = 'rgba(255, 70, 85, 0.15)';
            } else {
                btn.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                btn.style.color = '#94a3b8';
                btn.style.background = 'transparent';
            }
        });
    }

    const langToggleBtn = document.getElementById('langToggleBtn');
    if (langToggleBtn) {
        langToggleBtn.addEventListener('click', () => {
            const current = localStorage.getItem('pokedex_lang') || 'id';
            const next = current === 'id' ? 'en' : 'id';
            requestLanguageSwitch(next);
        });
    }

    document.querySelectorAll('.lang-choice-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const lang = btn.getAttribute('data-lang');
            requestLanguageSwitch(lang);
        });
    });

    const btnExecute = document.getElementById('btnExecuteLangSwitch');
    if (btnExecute) {
        btnExecute.addEventListener('click', () => {
            if (pendingTargetLang) {
                applyLanguageWithShimmer(pendingTargetLang);
                window.closeLangConfirmModal();
            }
        });
    }

    const savedLang = localStorage.getItem('pokedex_lang') || 'id';
    setLanguage(savedLang);
})();
