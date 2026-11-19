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
    const sections = ['home', 'explore', 'search']
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

    function populateShowcase(p, dir = 0) {
        if (!p || !showcase) return;
        currentShowcaseNo = p.no;

        if (dir !== 0 && !reducedMotion.matches) {
            showcase.style.setProperty('--dir', String(dir));
            showcase.classList.add('is-swapping');
            setTimeout(() => showcase.classList.remove('is-swapping'), 180);
        }

        const padded = String(p.num).padStart(3, '0');
        if (scNo) scNo.textContent = `#${padded}`;
        if (scTotal) scTotal.textContent = String(STATE.total || STATE.pokemons.length);
        if (scWatermark) scWatermark.textContent = padded;
        if (scEyebrow) scEyebrow.textContent = `${p.no} · ${p.generasi}`;
        if (scName) scName.textContent = p.name;
        if (scTypes) scTypes.innerHTML = buildBadgeHtml(p.types, 'light');
        if (scLore) scLore.textContent = loreFor(p);
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
})();
