@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
:root {
    --font-serif: 'Playfair Display', serif;
    --font-sans: 'Source Sans 3', sans-serif;
}
/* ============================================================
   DASHBOARD PROFIL — Mengikuti bahasa visual Galeri Buku Jakarta
   Editorial minimalis: border-bottom, serif heading, uppercase label
   Warna: #111, #b70d0f (merah), #888 (abu), tanpa border-radius
   ============================================================ */

/* ─── WRAPPER ─────────────────────────────────────────── */
#profil-page, #profil-page * {
    box-sizing: border-box;
}

#profil-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 24px 100px;
    min-height: 100vh;
}

/* ─── PAGE HEADER ─────────────────────────────────────── */
.profil-page-header {
    border-bottom: 2px solid #111;
    padding-bottom: 18px;
    margin-bottom: 36px;
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.profil-page-header h1 {
    font-family: var(--font-serif);
    font-size: 2.6rem;
    font-weight: 900;
    color: #111;
    margin: 0;
    letter-spacing: -1px;
    line-height: 1;
}

.profil-page-header-meta {
    font-family: var(--font-sans);
    font-size: 0.82rem;
    color: #888;
    display: flex;
    align-items: center;
    gap: 12px;
}

.profil-premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-family: var(--font-sans);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #b70d0f;
    border: 1.5px solid #b70d0f;
    padding: 3px 9px;
}

.profil-free-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-family: var(--font-sans);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #888;
    border: 1.5px solid #ccc;
    padding: 3px 9px;
}

/* ─── LAYOUT: SIDEBAR + MAIN ─────────────────────────── */
.profil-layout {
    display: flex;
    gap: 60px;
    align-items: flex-start;
}

/* ─── SIDEBAR ─────────────────────────────────────────── */
.profil-sidebar {
    flex: 0 0 190px;
    position: sticky;
    top: 80px;
}

.profil-avatar-area {
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #ddd;
}

.profil-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #111;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-sans);
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    overflow: hidden;
    margin-bottom: 12px;
}

.profil-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profil-user-name {
    font-family: var(--font-sans);
    font-size: 1rem;
    font-weight: 700;
    color: #111;
    line-height: 1.3;
    margin-bottom: 3px;
}

.profil-user-email {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    color: #888;
    word-break: break-all;
}

/* Nav */
.profil-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profil-nav li {
    border-bottom: 1px solid #eee;
}

.profil-nav a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 0;
    text-decoration: none;
    font-family: var(--font-sans);
    font-size: 0.88rem;
    color: #444;
    transition: color 0.15s;
    line-height: 1.2;
}

.profil-nav a:hover { color: #111; }

.profil-nav a.aktif {
    color: #b70d0f;
    font-weight: 700;
}

.profil-nav-label { flex: 1; }

.profil-nav-count {
    font-size: 0.72rem;
    color: #999;
    font-family: var(--font-sans);
    font-weight: 400;
}

.profil-nav-lock {
    font-size: 0.65rem;
    color: #b70d0f;
}

/* Logout link */
.profil-nav-logout {
    padding-top: 20px;
    margin-top: 4px;
}

.profil-nav-logout a {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    color: #aaa;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.profil-nav-logout a:hover { color: #b70d0f; }

/* ─── MAIN CONTENT ────────────────────────────────────── */
.profil-main { flex: 1; min-width: 0; }

/* Section heading (seperti "MAGAZINE" di magz.blade) */
.profil-section-head {
    border-bottom: 1px solid #ddd;
    padding-bottom: 14px;
    margin-bottom: 28px;
}

.profil-section-head h2 {
    font-family: var(--font-sans);
    font-size: 1.9rem;
    font-weight: 700;
    color: #111;
    margin: 0 0 4px;
    letter-spacing: -0.5px;
}

.profil-section-head p {
    font-family: var(--font-sans);
    font-size: 0.82rem;
    color: #888;
    margin: 0;
}

/* ─── ALERT / NOTICE ──────────────────────────────────── */
.profil-notice {
    padding: 11px 15px;
    margin-bottom: 22px;
    font-family: var(--font-sans);
    font-size: 0.87rem;
    border-left: 3px solid;
    line-height: 1.5;
}

.profil-notice-ok   { background: #f4faf4; color: #2a6a2a; border-color: #4caf50; }
.profil-notice-err  { background: #fdf4f4; color: #8a0000; border-color: #b70d0f; }
.profil-notice-warn { background: #fffbf0; color: #7a5200; border-color: #e09900; }

/* ─── FORM ELEMENTS ───────────────────────────────────── */
.profil-field {
    margin-bottom: 20px;
}

.profil-field label {
    display: block;
    font-family: var(--font-sans);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #555;
    margin-bottom: 7px;
}

.profil-field input,
.profil-field select,
.profil-field textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #ccc;
    border-radius: 0;
    background: #fff;
    font-family: var(--font-sans);
    font-size: 0.95rem;
    color: #111;
    outline: none;
    transition: border-color 0.2s;
    -webkit-appearance: none;
}

.profil-field input:focus,
.profil-field select:focus,
.profil-field textarea:focus {
    border-color: #111;
}

.profil-field input[type=file]::file-selector-button {
    background: #111;
    color: #fff;
    border: none;
    padding: 8px 14px;
    font-family: var(--font-sans);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 1px;
    cursor: pointer;
    margin-right: 10px;
    transition: background 0.2s;
}

.profil-field input[type=file]::file-selector-button:hover {
    background: #b70d0f;
}

.profil-field input:disabled,
.profil-field input[readonly],
.profil-field select:disabled {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

.profil-field textarea { min-height: 170px; resize: vertical; }

.profil-field-hint {
    font-size: 0.78rem;
    color: #aaa;
    margin-top: 5px;
    font-family: var(--font-sans);
}

.profil-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

/* ─── BUTTONS ─────────────────────────────────────────── */
.profil-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 20px;
    font-family: var(--font-sans);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s ease;
    border: none;
    line-height: 1;
}

.profil-btn-black { background: #111; color: #fff; }
.profil-btn-black:hover { background: #b70d0f; color: #fff; }

.profil-btn-red { background: #b70d0f; color: #fff; }
.profil-btn-red:hover { background: #8c0000; color: #fff; }

.profil-btn-outline { background: #fff; color: #111; border: 1.5px solid #111; }
.profil-btn-outline:hover { background: #111; color: #fff; }

.profil-btn-ghost { background: #fff; color: #555; border: 1.5px solid #ddd; }
.profil-btn-ghost:hover { border-color: #999; color: #111; }

.profil-btn-sm { padding: 7px 13px; font-size: 0.68rem; letter-spacing: 1.5px; }

/* Action links (gaya pub-download di magz) */
.profil-action-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.82rem;
    color: #111;
    text-decoration: underline;
    text-underline-offset: 3px;
    font-family: var(--font-sans);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    transition: color 0.15s;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.profil-action-link:hover { color: #b70d0f; }
.profil-action-link.red { color: #b70d0f; }
.profil-action-link.red:hover { color: #8c0000; }

/* ─── FOTO PROFIL ─────────────────────────────────────── */
.profil-photo-row {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    margin-bottom: 24px;
}

.profil-photo-preview {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #111;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-sans);
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    overflow: hidden;
    flex-shrink: 0;
}

.profil-photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ─── ITEM LIST (seperti pub-item di magz.blade) ─────── */
.profil-item-list { }

.profil-item {
    padding: 22px 0;
    border-bottom: 1px solid #ddd;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
}

.profil-item:first-child { border-top: 1px solid #ddd; }

.profil-item-body { flex: 1; min-width: 0; }

.profil-item-cat {
    font-size: 0.72rem;
    color: #888;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
    font-family: var(--font-sans);
    text-transform: uppercase;
}

.profil-item-cat span { color: #b70d0f; font-weight: 700; }

.profil-item-title {
    font-family: var(--font-sans);
    font-size: 1.2rem;
    font-weight: 500;
    color: #111;
    margin-bottom: 8px;
    line-height: 1.3;
    text-decoration: none;
    display: block;
    transition: color 0.15s;
}

.profil-item-title:hover { color: #b70d0f; }

.profil-item-meta {
    font-size: 0.8rem;
    color: #888;
    font-family: var(--font-sans);
    margin-bottom: 12px;
}

.profil-item-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.profil-item-sep { color: #ccc; font-size: 0.9rem; }

.profil-item-side {
    flex-shrink: 0;
    text-align: right;
}

/* Status tags */
.profil-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: var(--font-sans);
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 3px 8px;
    border: 1px solid;
}

.profil-status-pending  { color: #7a5200; border-color: #e09900; background: #fffbf0; }
.profil-status-approved { color: #1e5e2d; border-color: #4caf50; background: #f0faf2; }
.profil-status-rejected { color: #8a0000; border-color: #b70d0f; background: #fdf4f4; }

/* Catatan redaksi */
.profil-redaksi-note {
    padding: 11px 15px;
    margin-top: 10px;
    font-family: var(--font-sans);
    font-size: 0.85rem;
    border-left: 3px solid;
    line-height: 1.5;
}

.profil-redaksi-warn { background: #fffbf0; color: #7a5200; border-color: #e09900; }
.profil-redaksi-ok   { background: #f0faf2; color: #1e5e2d; border-color: #4caf50; }

/* ─── EMPTY STATE ─────────────────────────────────────── */
.profil-empty {
    text-align: center;
    padding: 70px 20px;
    color: #aaa;
    font-family: var(--font-sans);
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}

.profil-empty i { font-size: 2.2rem; margin-bottom: 14px; display: block; }

.profil-empty h3 {
    font-family: var(--font-sans);
    font-size: 1.3rem;
    color: #555;
    margin-bottom: 8px;
    font-weight: 500;
}

.profil-empty p {
    font-size: 0.88rem;
    color: #aaa;
    margin-bottom: 22px;
    max-width: 340px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

/* ─── LANGGANAN (SUBSCRIPTION) ────────────────────────── */
.profil-sub-header {
    border-bottom: 1px solid #ddd;
    padding-bottom: 22px;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
}

.profil-sub-header-left h3 {
    font-family: var(--font-sans);
    font-size: 1.5rem;
    font-weight: 700;
    color: #111;
    margin: 0 0 4px;
}

.profil-sub-header-left p {
    font-family: var(--font-sans);
    font-size: 0.82rem;
    color: #888;
    margin: 0;
}

.profil-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-sans);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 5px 12px;
    border: 1.5px solid;
}

.profil-pill-aktif { color: #1e5e2d; border-color: #4caf50; }
.profil-pill-expired { color: #8a0000; border-color: #b70d0f; }
.profil-pill-none { color: #888; border-color: #ccc; }

.profil-sub-meta {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 0;
    border: 1px solid #eee;
    margin-bottom: 28px;
}

.profil-sub-meta-cell {
    padding: 18px 20px;
    border-right: 1px solid #eee;
}

.profil-sub-meta-cell:last-child { border-right: none; }

.profil-sub-meta-cell label {
    display: block;
    font-family: var(--font-sans);
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #999;
    margin-bottom: 6px;
}

.profil-sub-meta-cell span {
    font-family: var(--font-sans);
    font-size: 1rem;
    font-weight: 600;
    color: #111;
    line-height: 1.3;
}

.profil-sub-meta-cell span.expired { color: #b70d0f; }

/* Benefit grid */
.profil-benefit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border: 1px solid #eee;
    margin-top: 28px;
}

.profil-benefit-item {
    padding: 16px 18px;
    border-right: 1px solid #eee;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.profil-benefit-item:nth-child(2n) { border-right: none; }
.profil-benefit-item:nth-last-child(-n+2) { border-bottom: none; }

.profil-benefit-item i {
    color: #b70d0f;
    font-size: 0.95rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.profil-benefit-item-text strong {
    display: block;
    font-family: var(--font-sans);
    font-size: 0.85rem;
    font-weight: 700;
    color: #111;
    margin-bottom: 2px;
}

.profil-benefit-item-text span {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    color: #888;
}

/* ─── KIRIM TULISAN: LAYOUT PICKER ────────────────────── */
.profil-layout-picker {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border: 1.5px solid #ccc;
    margin-bottom: 28px;
    cursor: pointer;
}

.profil-layout-opt {
    padding: 18px 20px;
    border-right: 1.5px solid #ccc;
    cursor: pointer;
    transition: background 0.15s;
    position: relative;
}

.profil-layout-opt:last-child { border-right: none; }

.profil-layout-opt:hover { background: #fafafa; }

.profil-layout-opt.selected {
    background: #fff;
    border-bottom: 2px solid #b70d0f;
}

.profil-layout-opt input { position: absolute; opacity: 0; }

.profil-layout-opt-title {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #111;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.profil-layout-opt.selected .profil-layout-opt-title { color: #b70d0f; }

.profil-layout-radio {
    width: 14px;
    height: 14px;
    border: 2px solid #ccc;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}

.profil-layout-opt.selected .profil-layout-radio {
    border-color: #b70d0f;
    background: #b70d0f;
    box-shadow: inset 0 0 0 2px #fff;
}

.profil-layout-opt-desc {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    color: #888;
    line-height: 1.5;
}

/* Form 2-col layout for kirim tulisan */
.profil-form-main {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 60px;
    align-items: start;
}

.profil-form-sidebar-box {
    position: sticky;
    top: 80px;
}

.profil-form-sidebar-box h4 {
    font-family: var(--font-sans);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #111;
    margin-top: 0;
    margin-bottom: 18px;
    padding-bottom: 8px;
    border-bottom: 1.5px solid #ccc;
}

/* ─── PREMIUM LOCK SCREEN ─────────────────────────────── */
.profil-premium-lock {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 60px 30px;
    text-align: center;
}

.profil-premium-lock i.lock-icon {
    font-size: 2rem;
    color: #ccc;
    margin-bottom: 18px;
}

.profil-premium-lock h3 {
    font-family: var(--font-sans);
    font-size: 1.6rem;
    font-weight: 700;
    color: #111;
    margin-bottom: 10px;
}

.profil-premium-lock p {
    font-family: var(--font-sans);
    font-size: 0.9rem;
    color: #888;
    max-width: 360px;
    margin: 0 auto 24px;
    line-height: 1.65;
}

.profil-premium-features {
    display: flex;
    justify-content: center;
    gap: 28px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.profil-premium-features span {
    font-family: var(--font-sans);
    font-size: 0.8rem;
    color: #555;
    display: flex;
    align-items: center;
    gap: 6px;
}

.profil-premium-features span i { color: #b70d0f; }

/* ─── MODAL ───────────────────────────────────────────── */
.profil-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.profil-modal-box {
    background: #fff;
    width: 100%;
    max-width: 660px;
    max-height: 90vh;
    overflow-y: auto;
    border-top: 3px solid #111;
}

.profil-modal-header {
    padding: 18px 22px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 2;
}

.profil-modal-header h4 {
    font-family: var(--font-sans);
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
}

.profil-modal-close {
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    color: #aaa;
    line-height: 1;
    padding: 2px 6px;
}

.profil-modal-close:hover { color: #111; }

.profil-modal-body { padding: 22px; }

.profil-modal-footer {
    padding: 15px 22px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* ─── CROP MODAL ──────────────────────────────────────── */
.profil-crop-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.85);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.profil-crop-box {
    background: #fff;
    width: 90%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 24px;
    border-top: 3px solid #111;
}

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 860px) {
    .profil-layout { flex-direction: column; gap: 28px; }
    .profil-sidebar { position: static; flex: unset; width: 100%; }
    .profil-avatar-area { display: flex; align-items: center; gap: 16px; padding-bottom: 16px; }
    .profil-avatar { margin-bottom: 0; flex-shrink: 0; }
    .profil-nav { display: flex; flex-wrap: wrap; gap: 0; }
    .profil-nav li { flex: 0 0 50%; }
    .profil-sub-meta { grid-template-columns: 1fr 1fr; }
    .profil-sub-meta-cell:nth-child(2) { border-right: none; }
    .profil-sub-meta-cell:nth-child(3) { border-top: 1px solid #eee; grid-column: 1 / -1; }
    .profil-form-main { grid-template-columns: 1fr; }
    .profil-form-sidebar-box { position: static; }
    .profil-layout-picker { grid-template-columns: 1fr; }
    .profil-layout-opt { border-right: none; border-bottom: 1.5px solid #ccc; }
    .profil-layout-opt:last-child { border-bottom: none; }
    .profil-row-2 { grid-template-columns: 1fr; }
    .profil-benefit-grid { grid-template-columns: 1fr; }
    .profil-benefit-item:nth-child(n) { border-right: none; }
}

@media (max-width: 640px) {
    #profil-page { padding: 16px 16px 80px; }
    .profil-page-header h1 { font-size: 2rem; }
    .profil-nav li { flex: 0 0 100%; }
    
    /* Subscription Mobile Tweaks */
    .profil-sub-header { 
        flex-direction: row; 
        justify-content: space-between;
        align-items: center;
        text-align: left;
    }
    .profil-sub-meta { grid-template-columns: 1fr; }
    .profil-sub-meta-cell { 
        border-right: none; 
        border-bottom: 1px solid #eee; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 16px;
        text-align: left;
    }
    .profil-sub-meta-cell label {
        margin-bottom: 0;
    }
    .profil-sub-meta-cell:last-child { border-bottom: none; }
    .profil-notice { text-align: left; }
}
</style>
@endpush

@section('content')
<section id="profil-page">

    {{-- Page Header --}}
    <div class="profil-page-header">
        <h1>PROFIL</h1>
        <div class="profil-page-header-meta">
            <span style="font-family:var(--font-sans);font-size:0.82rem;">{{ $user->email }}</span>
            @if($isPremium)
                <span class="profil-premium-badge"><i class="fas fa-crown"></i> Premium</span>
            @else
                <span class="profil-free-badge">Gratis</span>
            @endif
        </div>
    </div>

    <div class="profil-layout">

        {{-- ═══════════════════════════════════════════════
             SIDEBAR
        ═══════════════════════════════════════════════ --}}
        <aside class="profil-sidebar">
            <div class="profil-avatar-area">
                <div class="profil-avatar">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/profile/' . $user->foto_profil) }}" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="profil-user-name">{{ $user->nama }}</div>
                    <div class="profil-user-email">{{ $user->email }}</div>
                </div>
            </div>

            <ul class="profil-nav">
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'akun']) }}"
                       class="{{ $tab == 'akun' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Manajemen Akun</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'langganan']) }}"
                       class="{{ $tab == 'langganan' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Status Langganan</span>
                        @if($isPremium)
                            <span class="profil-nav-count" style="color:#1e5e2d;">Aktif</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'kirim-tulisan']) }}"
                       class="{{ $tab == 'kirim-tulisan' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Kirim Tulisan</span>
                        @if(!$isPremium)
                            <span class="profil-nav-lock"><i class="fas fa-lock"></i></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'kelola-tulisan']) }}"
                       class="{{ $tab == 'kelola-tulisan' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Kelola Tulisan</span>
                        @if($userTulisans->count() > 0)
                            <span class="profil-nav-count">{{ $userTulisans->count() }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'simpanan']) }}"
                       class="{{ $tab == 'simpanan' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Artikel Disimpan</span>
                        @if($savedArtikels->count() > 0)
                            <span class="profil-nav-count">{{ $savedArtikels->count() }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile', ['tab' => 'koleksi']) }}"
                       class="{{ $tab == 'koleksi' ? 'aktif' : '' }}">
                        <span class="profil-nav-label">Koleksi Digital</span>
                        @if($koleksis->count() > 0)
                            <span class="profil-nav-count">{{ $koleksis->count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <div class="profil-nav-logout">
                <form action="{{ route('user.signout') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Keluar dari akun ini?')" style="background:none; border:none; padding:0; font-family:var(--font-sans); font-size:0.78rem; color:#aaa; text-decoration:underline; text-underline-offset:2px; cursor:pointer;" onmouseover="this.style.color='#b70d0f'" onmouseout="this.style.color='#aaa'">Keluar</button>
                </form>
            </div>
        </aside>

        {{-- ═══════════════════════════════════════════════
             MAIN
        ═══════════════════════════════════════════════ --}}
        <main class="profil-main">

            {{-- ────────────────────────────────────────────
                 MANAJEMEN AKUN
            ──────────────────────────────────────────── --}}
            @if($tab == 'akun')
            <div class="profil-section-head">
                <h2>Manajemen Akun</h2>
                <p>Perbarui informasi profil dan kata sandi Anda</p>
            </div>

            @if(session('success'))
                <div class="profil-notice profil-notice-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="profil-notice profil-notice-err"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Foto Profil --}}
                <div class="profil-photo-row">
                    <div class="profil-photo-preview" id="profile-preview-container">
                        @if($user->foto_profil)
                            <img id="profile-preview-img" src="{{ asset('storage/profile/' . $user->foto_profil) }}" alt="Foto Profil">
                        @else
                            <span id="profile-initial">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                            <img id="profile-preview-img" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>
                    <div>
                        <div style="font-family:var(--font-sans);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#555;margin-bottom:8px;">Foto Profil</div>
                        <div class="profil-field" style="margin-bottom: 0;">
                            <input type="file" id="foto_profil_input" accept="image/*" style="font-family:var(--font-sans);font-size:0.85rem;color:#555;border:none;padding:0;">
                        </div>
                        <input type="hidden" name="cropped_foto" id="cropped_foto">
                        <div style="font-size:0.75rem;color:#aaa;margin-top:5px;font-family:var(--font-sans);">Format JPG/PNG, maks 2MB</div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="profil-row-2" style="margin-bottom:20px;">
                    <div class="profil-field">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    <div class="profil-field">
                        <label>Alamat Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="profil-row-1" style="margin-bottom:20px;">
                    <div class="profil-field">
                        <label>Biografi Profil</label>
                        <textarea name="bio" id="userBio" rows="4" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-family: var(--font-sans);">{{ old('bio', $user->bio) }}</textarea>
                        <div style="font-size: 0.8rem; color: #666; margin-top: 5px; text-align: right;">
                            Kata: <span id="wordCount">0</span> / 35
                        </div>
                        @error('bio')
                            <div style="color: #b70d0f; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div style="border-top:1px solid #eee;padding-top:20px;margin-bottom:24px;">
                    <div style="font-family:var(--font-sans);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin-bottom:16px;">Ganti Kata Sandi <span style="font-weight:400;letter-spacing:0;text-transform:none;">(Opsional)</span></div>
                    <div class="profil-row-2">
                        <div class="profil-field">
                            <label>Password Baru</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="profil-field">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <button type="submit" class="profil-btn profil-btn-black">Simpan Perubahan</button>
            </form>
            @endif

            {{-- ────────────────────────────────────────────
                 STATUS LANGGANAN
            ──────────────────────────────────────────── --}}
            @if($tab == 'langganan')
            <div class="profil-section-head">
                <h2>Status Langganan</h2>
                <p>Kelola paket Premium Anda</p>
            </div>

            @if(session('error'))
                <div class="profil-notice profil-notice-err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            @if(!$subscription)
                {{-- Belum Berlangganan --}}
                <div class="profil-empty">
                    <i class="fas fa-crown"></i>
                    <h3>Belum Berlangganan</h3>
                    <p>Anda belum memiliki paket premium. Tingkatkan akun Anda untuk mengakses konten eksklusif dan fitur menulis.</p>
                    <a href="{{ route('subscribe') }}" class="profil-btn profil-btn-red">Mulai Berlangganan</a>
                </div>

            @else
                {{-- Punya Langganan --}}
                @php
                    $namaP = match($subscription->paket) {
                        'bulanan' => 'Bulanan',
                        'paket4bulan' => '4 Bulan',
                        'paket6bulan' => '6 Bulan',
                        default => ucfirst($subscription->paket),
                    };
                @endphp

                <div class="profil-sub-header">
                    <div class="profil-sub-header-left">
                        <h3>Langganan {{ $namaP }}</h3>
                        <p>Galeri Buku Jakarta Digital Premium</p>
                    </div>
                    @if($isPremium)
                        <span class="profil-status-pill profil-pill-aktif"><i class="fas fa-check-circle"></i> Aktif</span>
                    @else
                        <span class="profil-status-pill profil-pill-expired"><i class="fas fa-times-circle"></i> Kedaluwarsa</span>
                    @endif
                </div>

                <div class="profil-sub-meta">
                    <div class="profil-sub-meta-cell">
                        <label>Paket</label>
                        <span>{{ $namaP }}</span>
                    </div>
                    <div class="profil-sub-meta-cell">
                        <label>Terdaftar Sejak</label>
                        <span>{{ \Carbon\Carbon::parse($subscription->created_at)->format('d M Y') }}</span>
                    </div>
                    <div class="profil-sub-meta-cell">
                        <label>Berlaku Hingga</label>
                        <span class="{{ $isPremium ? '' : 'expired' }}">{{ \Carbon\Carbon::parse($subscription->berlaku_hingga)->format('d M Y') }}</span>
                    </div>
                </div>

                @if(!$isPremium)
                    <div class="profil-notice profil-notice-warn">
                        <i class="fas fa-exclamation-triangle"></i>
                        Masa aktif langganan Anda berakhir pada <strong>{{ \Carbon\Carbon::parse($subscription->berlaku_hingga)->format('d F Y') }}</strong>. Perbarui untuk memulihkan akses Premium.
                    </div>
                    <a href="{{ route('subscribe') }}" class="profil-btn profil-btn-red">Perbarui Langganan</a>
                @else
                    @php $sisaHari = \Carbon\Carbon::now()->diffInDays($subscription->berlaku_hingga, false); @endphp
                    @if($sisaHari <= 7)
                        <div class="profil-notice profil-notice-warn">
                            <i class="fas fa-clock"></i>
                            Langganan Anda akan berakhir dalam <strong>{{ $sisaHari }} hari</strong>. Segera perpanjang agar tidak terputus.
                        </div>
                    @else
                        <div class="profil-notice profil-notice-ok">
                            <i class="fas fa-shield-alt"></i>
                            Langganan aktif hingga <strong>{{ \Carbon\Carbon::parse($subscription->berlaku_hingga)->format('d F Y') }}</strong>.
                        </div>
                    @endif
                    <a href="{{ route('subscribe') }}" class="profil-btn profil-btn-outline">Perpanjang Paket</a>
                @endif

                {{-- Benefit --}}
                <div style="margin-top:36px;border-top:1px solid #eee;padding-top:20px;">
                    <div style="font-family:var(--font-sans);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin-bottom:16px;">Benefit Premium Anda</div>
                    <div class="profil-benefit-grid">
                        @foreach([
                            ['fas fa-pen', 'Kirim Tulisan', 'Kirimkan naskah ke redaksi'],
                            ['fas fa-book-open', 'Akses Magz Digital', 'Koleksi majalah eksklusif'],
                            ['fas fa-star', 'Konten Premium', 'Artikel pilihan kuratorial'],
                            ['fas fa-bookmark', 'Simpan Artikel', 'Tandai bacaan favorit'],
                        ] as $b)
                        <div class="profil-benefit-item">
                            <i class="{{ $b[0] }}"></i>
                            <div class="profil-benefit-item-text">
                                <strong>{{ $b[1] }}</strong>
                                <span>{{ $b[2] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @endif

            {{-- ────────────────────────────────────────────
                 KIRIM TULISAN
            ──────────────────────────────────────────── --}}
            @if($tab == 'kirim-tulisan')
            <div class="profil-section-head">
                <h2>{{ isset($editTulisan) ? 'Edit Tulisan' : 'Kirim Tulisan' }}</h2>
                <p>Naskah terpilih akan dikurasi dan ditayangkan oleh tim redaksi</p>
            </div>

            @if(!$isPremium)
                <div class="profil-premium-lock">
                    <i class="fas fa-lock lock-icon"></i>
                    <h3>Fitur Premium</h3>
                    <p>Fitur mengirimkan naskah tulisan hanya tersedia untuk pengguna dengan langganan Premium aktif.</p>
                    <div class="profil-premium-features">
                        <span><i class="fas fa-check"></i> Kurasi oleh redaktur</span>
                        <span><i class="fas fa-check"></i> Tayang di Galeri Buku Jakarta</span>
                        <span><i class="fas fa-check"></i> Jangkau ribuan pembaca</span>
                    </div>
                    <a href="{{ route('subscribe') }}" class="profil-btn profil-btn-red">Berlangganan Sekarang</a>
                </div>

            @else
                @if(session('success_tulisan'))
                    <div class="profil-notice profil-notice-ok"><i class="fas fa-check-circle"></i> {{ session('success_tulisan') }}</div>
                @endif
                @if(session('error_tulisan'))
                    <div class="profil-notice profil-notice-err"><i class="fas fa-exclamation-circle"></i> {{ session('error_tulisan') }}</div>
                @endif

                @if(isset($editTulisan))
                    <div class="profil-notice profil-notice-warn">
                        <i class="fas fa-edit"></i> Mode Edit — memperbarui "<strong>{{ $editTulisan->judul }}</strong>" untuk dikirim ulang.
                        <a href="{{ route('user.profile', ['tab' => 'kelola-tulisan']) }}" style="float:right;color:inherit;text-decoration:underline;">Batal</a>
                    </div>
                @endif

                <form action="{{ isset($editTulisan) ? route('user.profile.update_tulisan', $editTulisan->id) : route('user.profile.tulisan') }}"
                      method="POST" enctype="multipart/form-data" id="form-kirim-tulisan">
                    @csrf

                    {{-- Layout Picker --}}
                    <div style="font-family:var(--font-sans);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#555;margin-bottom:10px;">Model Tampilan *</div>
                    <div class="profil-layout-picker">
                        <label class="profil-layout-opt {{ (isset($editTulisan) && $editTulisan->layout == 'artikel2') ? 'selected' : '' }}" id="opt-artikel2">
                            <input type="radio" name="layout" value="artikel2" {{ (isset($editTulisan) && $editTulisan->layout == 'artikel2') ? 'checked' : '' }}>
                            <div class="profil-layout-opt-title">
                                <span class="profil-layout-radio" id="radio-artikel2"></span>
                                Artikel Reguler
                            </div>
                            <div class="profil-layout-opt-desc">Editor teks kaya (bold, gambar, list). Untuk esai, ulasan, reportase.</div>
                        </label>
                        <label class="profil-layout-opt {{ (isset($editTulisan) && $editTulisan->layout == 'artikel3') ? 'selected' : '' }}" id="opt-artikel3">
                            <input type="radio" name="layout" value="artikel3" {{ (isset($editTulisan) && $editTulisan->layout == 'artikel3') ? 'checked' : '' }}>
                            <div class="profil-layout-opt-title">
                                <span class="profil-layout-radio" id="radio-artikel3"></span>
                                Puisi
                            </div>
                            <div class="profil-layout-opt-desc">Editor baris polos. Satu Enter = satu baris sajak. Kategori otomatis.</div>
                        </label>
                    </div>

                    {{-- Form Fields --}}
                    <div id="form-fields" style="{{ isset($editTulisan) ? '' : 'display:none;' }}">
                        <div class="profil-form-main">
                            {{-- Kiri --}}
                            <div>
                                <div class="profil-field">
                                    <label>Judul Tulisan *</label>
                                    <input type="text" name="judul" value="{{ isset($editTulisan) ? $editTulisan->judul : '' }}" required placeholder="Tulis judul yang kuat dan menarik...">
                                </div>
                                <div class="profil-field">
                                    <label>Sinopsis *</label>
                                    <textarea name="sinopsis" style="min-height:80px;" required placeholder="Ringkasan 2–3 kalimat yang merangkum isi tulisan Anda...">{{ isset($editTulisan) ? $editTulisan->sinopsis : '' }}</textarea>
                                </div>

                                {{-- Konten Artikel --}}
                                <div class="profil-field" id="konten-artikel-container">
                                    <label>Konten Artikel *</label>
                                    <textarea name="konten" id="summernote">{{ (isset($editTulisan) && $editTulisan->layout != 'artikel3') ? $editTulisan->konten : '' }}</textarea>
                                </div>

                                {{-- Konten Puisi --}}
                                <div class="profil-field" id="konten-puisi-container" style="display:none;">
                                    <label>Konten Puisi / Sajak *</label>
                                    <div class="profil-notice profil-notice-warn" style="margin-bottom:10px;font-size:0.8rem;background:#f8f9fa;border-left:4px solid #0d6efd;padding:10px 14px;border-radius:0 6px 6px 0;">
                                        <div style="display:flex;gap:8px;align-items:baseline;margin-bottom:5px;"><span style="background:#e9ecef;border:1px solid #ccc;border-radius:3px;padding:1px 6px;font-family:monospace;font-size:12px;white-space:nowrap;">Enter</span><span>Ganti baris — setiap Enter = satu baris baru puisi.</span></div>
                                        <div style="display:flex;gap:8px;align-items:baseline;margin-bottom:5px;"><span style="background:#e9ecef;border:1px solid #ccc;border-radius:3px;padding:1px 6px;font-family:monospace;font-size:12px;white-space:nowrap;">Enter 2×</span><span>Baris kosong = jarak antar bait / stanza.</span></div>
                                        <div style="display:flex;gap:8px;align-items:baseline;"><span style="background:#e9ecef;border:1px solid #ccc;border-radius:3px;padding:1px 6px;font-family:monospace;font-size:12px;white-space:nowrap;"># Judul</span><span>Awali dengan <code>#</code> untuk <strong>subjudul tebal</strong>. Contoh: <code># Bab Satu</code></span></div>
                                    </div>
                                    <div style="display:flex;gap:16px;align-items:flex-start;">
                                        <div style="flex:1;min-width:0;">
                                            <textarea name="konten_puisi" id="konten_puisi" rows="15"
                                                style="font-family:'EB Garamond',Garamond,Georgia,serif;font-size:18px;line-height:1.4;min-height:280px;width:100%;letter-spacing:0;"
                                                placeholder="Ada yang aneh di Ibu Kota&#10;Sebagai mana huruf-huruf...&#10;&#10;# Bab Dua&#10;Tempat dimana...">{{ (isset($editTulisan) && $editTulisan->layout == 'artikel3') ? $editTulisan->konten : '' }}</textarea>
                                            <div style="font-size:12px;color:#888;text-align:right;margin-top:4px;"><span id="puisi-line-count">0</span> baris</div>
                                        </div>
                                        <div style="flex:1;min-width:0;border:1px solid #e0e0e0;border-radius:8px;padding:20px 24px;min-height:280px;background:#fff;">
                                            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#999;margin-bottom:12px;border-bottom:1px solid #eee;padding-bottom:6px;">👁 Pratinjau Tampilan</div>
                                            <div id="puisi-user-preview" style="font-family:'EB Garamond',Garamond,Georgia,serif;font-size:18px;line-height:1.1;color:#1a1a1a;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Kanan --}}
                            <div>
                                <div class="profil-form-sidebar-box">
                                    <h4>Detail Tulisan</h4>

                                    <div class="profil-field" id="kategori-container">
                                        <label>Kategori *</label>
                                        <select name="kategori_id" id="kategori_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoriList as $kat)
                                                <option value="{{ $kat->id }}" data-nama="{{ strtolower($kat->nama) }}"
                                                    {{ (isset($editTulisan) && $editTulisan->kategori_id == $kat->id) ? 'selected' : '' }}>
                                                    {{ $kat->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="kategori_id_hidden" id="kategori_id_hidden" disabled>
                                    </div>

                                    <div class="profil-field">
                                        <label>Penulis</label>
                                        <input type="text" value="{{ Auth::guard('pengguna')->user()->nama }}" disabled>
                                    </div>

                                    <div class="profil-field">
                                        <label>Jenis Konten *</label>
                                        <select name="jenis_artikel" required>
                                            <option value="free" {{ (isset($editTulisan) && $editTulisan->jenis_artikel == 'free') ? 'selected' : '' }}>Bebas Akses</option>
                                            <option value="premium" {{ (isset($editTulisan) && $editTulisan->jenis_artikel == 'premium') ? 'selected' : '' }}>Khusus Premium</option>
                                        </select>
                                    </div>

                                    <div class="profil-field">
                                        <label>Tanggal Publikasi *</label>
                                        <input type="date" name="tanggal_publikasi" required
                                               value="{{ isset($editTulisan) ? \Carbon\Carbon::parse($editTulisan->tanggal_publikasi)->format('Y-m-d') : date('Y-m-d') }}">
                                    </div>

                                    <div class="profil-field">
                                        <label>Gambar Artikel *</label>
                                        <div id="gambar-container">
                                            <div class="gambar-row" style="margin-bottom:8px;padding:10px;background:#f9f9f9;border:1px solid #eee;position:relative;">
                                                <input type="file" name="gambar[]" accept="image/*" required style="width:100%;font-size:0.82rem;margin-bottom:6px;">
                                                <input type="text" name="deskripsi_gambar[]" placeholder="Keterangan gambar (opsional)" style="width:100%;padding:7px 10px;border:1.5px solid #ccc;font-size:0.82rem;font-family:var(--font-sans);">
                                            </div>
                                        </div>
                                        <button type="button" id="btn-add-gambar" class="profil-btn profil-btn-ghost profil-btn-sm" style="width:100%;margin-top:8px;justify-content:center;">
                                            <i class="fas fa-plus"></i> Tambah Gambar
                                        </button>
                                    </div>

                                    <button type="submit" class="profil-btn profil-btn-black" style="width:100%;justify-content:center;padding:13px;">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ isset($editTulisan) ? 'Kirim Ulang' : 'Kirim Tulisan' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
            @endif

            {{-- ────────────────────────────────────────────
                 KELOLA TULISAN
            ──────────────────────────────────────────── --}}
            @if($tab == 'kelola-tulisan')
            <div class="profil-section-head">
                <h2>Kelola Tulisan</h2>
                <p>Riwayat dan status kurasi naskah yang dikirimkan</p>
            </div>

            @if(session('success_tulisan'))
                <div class="profil-notice profil-notice-ok"><i class="fas fa-check-circle"></i> {{ session('success_tulisan') }}</div>
            @endif

            @if($userTulisans->count() > 0)
                <div class="profil-item-list">
                    @foreach($userTulisans as $tulisan)
                    <div class="profil-item">
                        <div class="profil-item-body">
                            <div class="profil-item-cat">
                                {{ $tulisan->kategori->nama }}
                                <span style="margin: 0 6px; color: #ccc;">|</span>
                                @if($tulisan->status == 'pending')
                                    <span class="profil-status profil-status-pending">Menunggu Kurasi</span>
                                @elseif($tulisan->status == 'disetujui')
                                    <span class="profil-status profil-status-approved">Disetujui &amp; Live</span>
                                @else
                                    <span class="profil-status profil-status-rejected">Ditolak</span>
                                @endif
                            </div>
                            <div class="profil-item-title">{{ $tulisan->judul }}</div>
                            <div class="profil-item-meta">Dikirim {{ $tulisan->created_at->format('d M Y') }}</div>

                            @if(($tulisan->status == 'ditolak' || $tulisan->status == 'pending') && $tulisan->alasan_penolakan)
                                <div class="profil-redaksi-note profil-redaksi-warn">
                                    <strong>Catatan Redaksi:</strong> {{ $tulisan->alasan_penolakan }}
                                </div>
                            @elseif($tulisan->status == 'disetujui')
                                <div class="profil-redaksi-note profil-redaksi-ok">
                                    Tulisan Anda telah dipublikasikan. Terima kasih atas kontribusi Anda!
                                </div>
                            @endif

                            <div class="profil-item-actions" style="margin-top:12px;">
                                <button type="button" class="profil-action-link" onclick="bukaPreviewModal({{ $tulisan->id }})">
                                    Lihat Detail
                                </button>

                                @if($tulisan->status == 'pending' || $tulisan->status == 'ditolak')
                                    <span class="profil-item-sep">|</span>
                                    <a href="{{ route('user.profile', ['tab' => 'kirim-tulisan', 'edit_id' => $tulisan->id]) }}"
                                       class="profil-action-link">Edit &amp; Kirim Ulang</a>
                                    <span class="profil-item-sep">|</span>
                                    <form action="{{ route('user.profile.delete_tulisan', $tulisan->id) }}" method="POST"
                                          style="display:inline;" onsubmit="return confirm('Hapus kiriman ini selamanya?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="profil-action-link red">Hapus</button>
                                    </form>
                                @endif

                                @if($tulisan->status == 'disetujui' && $tulisan->artikel)
                                    <span class="profil-item-sep">|</span>
                                    <a href="{{ route('artikel.show', $tulisan->artikel->slug) }}" target="_blank"
                                       class="profil-action-link" style="color:#1e5e2d;">
                                        Lihat Live <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i>
                                    </a>
                                    @if(empty($tulisan->pesan_revisi))
                                        <span class="profil-item-sep">|</span>
                                        <button type="button" class="profil-action-link" onclick="bukaRevisiModal({{ $tulisan->id }})">
                                            Ajukan Edit
                                        </button>
                                    @else
                                        <span class="profil-item-sep">|</span>
                                        <span style="font-family:var(--font-sans);font-size:0.8rem;color:#aaa;">Menunggu Izin Edit</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Modal Revisi --}}
                    @if($tulisan->status == 'disetujui' && empty($tulisan->pesan_revisi))
                    <div id="revisiModal-{{ $tulisan->id }}" class="profil-modal">
                        <div class="profil-modal-box">
                            <div class="profil-modal-header">
                                <h4>Ajukan Pengeditan Ulang</h4>
                                <button class="profil-modal-close" onclick="tutupRevisiModal({{ $tulisan->id }})">×</button>
                            </div>
                            <form action="{{ route('user.profile.request_revisi', $tulisan->id) }}" method="POST">
                                @csrf
                                <div class="profil-modal-body">
                                    <p style="font-family:var(--font-sans);font-size:0.87rem;color:#666;margin-bottom:16px;line-height:1.6;">
                                        Artikel yang sudah rilis tidak bisa diedit sepihak. Jelaskan alasan Anda memerlukan pengeditan (misalnya: kesalahan data, typo penting).
                                    </p>
                                    <div class="profil-field">
                                        <label>Alasan Pengajuan *</label>
                                        <textarea name="pesan_revisi" rows="4" required placeholder="Tuliskan alasan yang jelas dan spesifik..."></textarea>
                                    </div>
                                </div>
                                <div class="profil-modal-footer">
                                    <button type="button" class="profil-btn profil-btn-ghost profil-btn-sm" onclick="tutupRevisiModal({{ $tulisan->id }})">Batal</button>
                                    <button type="submit" class="profil-btn profil-btn-black profil-btn-sm">Kirim Pengajuan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Modal Preview --}}
                    <div id="previewModal-{{ $tulisan->id }}" class="profil-modal">
                        <div class="profil-modal-box" style="max-width:720px;">
                            <div class="profil-modal-header">
                                <h4>{{ $tulisan->judul }}</h4>
                                <button class="profil-modal-close" onclick="tutupPreviewModal({{ $tulisan->id }})">×</button>
                            </div>
                            <div class="profil-modal-body">
                                <div style="display:flex;gap:14px;flex-wrap:wrap;margin-bottom:16px;font-family:var(--font-sans);font-size:0.8rem;color:#888;text-transform:uppercase;letter-spacing:0.5px;">
                                    <span>{{ $tulisan->kategori->nama }}</span>
                                    <span style="color:#ccc;">|</span>
                                    <span>{{ $tulisan->created_at->format('d M Y') }}</span>
                                    <span style="color:#ccc;">|</span>
                                    <span>{{ ucfirst($tulisan->layout) }}</span>
                                </div>
                                @if($tulisan->sinopsis)
                                    <div style="background:#f9f9f9;padding:14px;border-left:3px solid #b70d0f;margin-bottom:18px;font-family:var(--font-sans);font-size:0.88rem;color:#555;font-style:italic;line-height:1.6;">
                                        {{ $tulisan->sinopsis }}
                                    </div>
                                @endif
                                @if($tulisan->gambar_array)
                                    <div style="display:flex;gap:10px;overflow-x:auto;margin-bottom:18px;padding-bottom:4px;">
                                        @foreach(json_decode($tulisan->gambar_array, true) as $gbr)
                                            <img src="{{ asset('img/' . $gbr['file_gambar']) }}" style="height:80px;flex-shrink:0;object-fit:cover;" alt="">
                                        @endforeach
                                    </div>
                                @endif
                                <hr style="margin:0 0 16px;border:none;border-top:1px solid #eee;">
                                <div style="font-family:var(--font-sans);font-size:0.9rem;line-height:1.75;color:#333;max-height:320px;overflow-y:auto;">
                                    {!! nl2br(e($tulisan->konten)) !!}
                                </div>
                            </div>
                            <div class="profil-modal-footer" style="justify-content:flex-start;">
                                <button type="button" class="profil-btn profil-btn-ghost profil-btn-sm" onclick="tutupPreviewModal({{ $tulisan->id }})">Tutup</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            @else
                <div class="profil-empty">
                    <i class="fas fa-pen-nib"></i>
                    <h3>Belum Ada Tulisan</h3>
                    <p>Anda belum pernah mengirimkan naskah. Mulai kontribusikan karya terbaik Anda sekarang.</p>
                    @if($isPremium)
                        <a href="{{ route('user.profile', ['tab' => 'kirim-tulisan']) }}" class="profil-btn profil-btn-black">Tulis Sekarang</a>
                    @else
                        <a href="{{ route('subscribe') }}" class="profil-btn profil-btn-red">Berlangganan untuk Menulis</a>
                    @endif
                </div>
            @endif
            @endif

            {{-- ────────────────────────────────────────────
                 ARTIKEL DISIMPAN
            ──────────────────────────────────────────── --}}
            @if($tab == 'simpanan')
            <div class="profil-section-head">
                <h2>Artikel Disimpan</h2>
                <p>{{ $savedArtikels->count() }} artikel tersimpan</p>
            </div>

            @if($savedArtikels->count() > 0)
                <div class="profil-item-list">
                    @foreach($savedArtikels as $simpan)
                        @if($simpan->artikel)
                        <div class="profil-item">
                            <div class="profil-item-body">
                                @if($simpan->artikel->kategori)
                                    <div class="profil-item-cat">{{ $simpan->artikel->kategori->nama }}</div>
                                @endif
                                <a href="{{ route('artikel.show', $simpan->artikel->slug) }}" class="profil-item-title">
                                    {{ $simpan->artikel->judul }}
                                </a>
                                <div class="profil-item-meta">Disimpan {{ $simpan->created_at->format('d M Y') }}</div>
                                <div class="profil-item-actions">
                                    <a href="{{ route('artikel.show', $simpan->artikel->slug) }}" class="profil-action-link">Baca</a>
                                    <span class="profil-item-sep">|</span>
                                    <form action="{{ route('user.profile.remove_artikel', $simpan->id) }}" method="POST"
                                          style="display:inline;" onsubmit="return confirm('Hapus dari simpanan?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="profil-action-link red">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="profil-empty">
                    <i class="fas fa-bookmark"></i>
                    <h3>Belum Ada Artikel Tersimpan</h3>
                    <p>Tandai artikel favorit dengan ikon bookmark dan mereka akan muncul di sini.</p>
                    <a href="{{ route('home') }}" class="profil-btn profil-btn-outline">Jelajahi Artikel</a>
                </div>
            @endif
            @endif

            {{-- ────────────────────────────────────────────
                 KOLEKSI MAGZ & PUBLIKASI
            ──────────────────────────────────────────── --}}
            @if($tab == 'koleksi')
            <div class="profil-section-head">
                <h2>Koleksi Digital</h2>
                <p>{{ $koleksis->count() }} item dalam koleksi Anda</p>
            </div>

            @if($koleksis->count() > 0)
                <div class="profil-item-list">
                    @foreach($koleksis as $koleksi)
                        @php $item = $koleksi->koleksiItem; @endphp
                        @if($item)
                        <div class="profil-item">
                            <div class="profil-item-body">
                                {{-- Badge type --}}
                                <div class="profil-item-cat">{{ strtoupper($koleksi->item_type) }}</div>

                                {{-- Judul --}}
                                @php
                                    $itemTitle = match($koleksi->item_type) {
                                        'magz'     => ($item->judul ?? $item->title ?? '-'),
                                        'pustaka'  => ($item->judul ?? '-'),
                                        'publikasi'=> ($item->judul ?? '-'),
                                        default    => '-',
                                    };
                                    $itemUrl = match($koleksi->item_type) {
                                        'magz'     => route('magz.baca', $item->slug),
                                        'pustaka'  => ($item->file_pdf ? route('pustaka.baca', $item->slug) : route('pustaka.detail', $item->slug)),
                                        'publikasi'=> route('publikasi.show', $item->id),
                                        default    => '#',
                                    };
                                    $actionLabel = match($koleksi->item_type) {
                                        'magz'     => 'Unduh PDF',
                                        'pustaka'  => ($item->file_pdf ? 'Unduh PDF' : 'Lihat Detail'),
                                        'publikasi'=> 'Lihat',
                                        default    => 'Buka',
                                    };
                                @endphp

                                <a href="{{ $itemUrl }}"
                                   class="profil-item-title"
                                   @if($koleksi->item_type !== 'publikasi') target="_blank" @endif>
                                    {{ $itemTitle }}
                                </a>

                                <div class="profil-item-meta">
                                    @if($koleksi->item_type == 'magz' && isset($item->edisi))Edisi {{ $item->edisi }} · @endif
                                    Ditambahkan {{ $koleksi->created_at->format('d M Y') }}
                                </div>

                                <div class="profil-item-actions">
                                    <a href="{{ $itemUrl }}"
                                       class="profil-action-link"
                                       @if($koleksi->item_type !== 'publikasi') target="_blank" @endif>
                                        {{ $actionLabel }}
                                    </a>
                                    <span class="profil-item-sep">|</span>
                                    <form action="{{ route('user.profile.remove_koleksi', $koleksi->id) }}" method="POST"
                                          style="display:inline;" onsubmit="return confirm('Hapus dari koleksi?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="profil-action-link red">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="profil-empty">
                    <i class="fas fa-layer-group"></i>
                    <h3>Koleksi Masih Kosong</h3>
                    <p>Magz digital, publikasi, dan pustaka yang Anda beli akan tersimpan di sini untuk diakses kapan saja.</p>
                    <a href="{{ route('magz.index') }}" class="profil-btn profil-btn-outline">Jelajahi Magz</a>
                </div>
            @endif
            @endif

        </main>
    </div>
</section>

{{-- Crop Modal --}}
<div class="profil-crop-modal" id="cropModal">
    <div class="profil-crop-box">
        <h4 style="font-family:var(--font-serif);margin-bottom:16px;">Sesuaikan Foto Profil</h4>
        <div style="width:100%;max-height:50vh;overflow:hidden;margin-bottom:20px;background:#eee;text-align:center;">
            <img id="imageToCrop" style="max-width:100%;display:block;margin:0 auto;">
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button type="button" onclick="document.getElementById('cropModal').style.display='none';"
                    class="profil-btn profil-btn-ghost profil-btn-sm">Batal</button>
            <button type="button" id="cropButton" class="profil-btn profil-btn-black profil-btn-sm">
                Potong &amp; Simpan
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {

    // ── Summernote ─────────────────────────────────────────
    $('#summernote').summernote({
        height: 360,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });

    // ── Live Preview Puisi ─────────────────────────────────
    function renderPuisiPreviewUser(raw) {
        if (!raw || !raw.trim()) return '<span style="color:#bbb;font-style:italic;">Pratinjau kosong...</span>';
        var lines = raw.split('\n');
        var html = '';
        lines.forEach(function(line) {
            if (/^#\s*(.+)/.test(line)) {
                html += '<p style="margin:0 0 3px;white-space:nowrap;"><strong>' + line.replace(/^#\s*/, '') + '</strong></p>';
            } else if (line.trim() === '') {
                html += '<p style="margin:0 0 14px;">&nbsp;</p>';
            } else {
                html += '<p style="margin:0 0 3px;white-space:nowrap;">' + line + '</p>';
            }
        });
        return html;
    }

    $('#konten_puisi').on('input keyup', function() {
        var val = $(this).val();
        $('#puisi-user-preview').html(renderPuisiPreviewUser(val));
        $('#puisi-line-count').text(val === '' ? 0 : val.split('\n').length);
    });

    // Init preview on page load
    var initPuisiVal = $('#konten_puisi').val();
    if (initPuisiVal) {
        $('#puisi-user-preview').html(renderPuisiPreviewUser(initPuisiVal));
        $('#puisi-line-count').text(initPuisiVal.split('\n').length);
    }

    // ── Layout Picker ─────────────────────────────────────
    function applyLayout(val) {
        if (!val) return;
        $('#form-fields').fadeIn(250);
        $('#opt-artikel2, #opt-artikel3').removeClass('selected');
        $('#radio-artikel2, #radio-artikel3').css({ background: '', 'border-color': '#ccc', 'box-shadow': '' });

        var $kat = $('#kategori_id');

        if (val === 'artikel3') {
            $('#opt-artikel3').addClass('selected');
            $('#radio-artikel3').css({ background: '#b70d0f', 'border-color': '#b70d0f', 'box-shadow': 'inset 0 0 0 2px #fff' });
            $('#konten-artikel-container').hide();
            $('#konten-puisi-container').show();
            $('#summernote').removeAttr('required');
            $('#konten_puisi').attr('required', 'required');
            $kat.find('option').each(function() {
                if ($(this).data('nama') && $(this).data('nama').includes('kata')) $kat.val($(this).val());
            });
            $kat.prop('disabled', true);
            $('#kategori_id_hidden').val($kat.val()).prop('disabled', false);
        } else {
            $('#opt-artikel2').addClass('selected');
            $('#radio-artikel2').css({ background: '#b70d0f', 'border-color': '#b70d0f', 'box-shadow': 'inset 0 0 0 2px #fff' });
            $('#konten-puisi-container').hide();
            $('#konten-artikel-container').show();
            $('#konten_puisi').removeAttr('required');
            $('#summernote').attr('required', 'required');
            $kat.prop('disabled', false);
            $('#kategori_id_hidden').prop('disabled', true);
            if ($kat.find('option:selected').data('nama') && $kat.find('option:selected').data('nama').includes('kata')) $kat.val('');
            $kat.find('option').each(function() {
                if ($(this).data('nama') && $(this).data('nama').includes('kata')) $(this).hide();
                else $(this).show();
            });
        }
    }

    $('.profil-layout-opt').on('click', function() {
        var val = $(this).find('input[type="radio"]').val();
        $(this).find('input[type="radio"]').prop('checked', true);
        applyLayout(val);
    });

    var pre = $('input[name="layout"]:checked').val();
    if (pre) applyLayout(pre);

    // ── Gambar field ──────────────────────────────────────
    $('#btn-add-gambar').click(function() {
        $('#gambar-container').append(`
            <div class="gambar-row" style="margin-bottom:8px;padding:10px;background:#f9f9f9;border:1px solid #eee;position:relative;">
                <button type="button" onclick="this.closest('.gambar-row').remove()" style="position:absolute;top:6px;right:8px;background:none;border:none;color:#b70d0f;cursor:pointer;font-size:0.9rem;"><i class="fas fa-times"></i></button>
                <input type="file" name="gambar[]" accept="image/*" required style="width:100%;font-size:0.82rem;margin-bottom:6px;">
                <input type="text" name="deskripsi_gambar[]" placeholder="Keterangan gambar (opsional)" style="width:100%;padding:7px 10px;border:1.5px solid #ccc;font-size:0.82rem;font-family:var(--font-sans);">
            </div>
        `);
    });

    // ── Foto Profil Crop ─────────────────────────────────
    var cropper;
    $('#foto_profil_input').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imageToCrop').attr('src', e.target.result);
                document.getElementById('cropModal').style.display = 'flex';
                if (cropper) cropper.destroy();
                cropper = new Cropper(document.getElementById('imageToCrop'), { aspectRatio: 1, viewMode: 1 });
            };
            reader.readAsDataURL(this.files[0]);
            $(this).val('');
        }
    });

    $('#cropButton').click(function() {
        if (!cropper) return;
        var canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        var base64 = canvas.toDataURL('image/jpeg', 0.9);
        $('#profile-preview-img').attr('src', base64).show();
        $('#profile-initial').hide();
        $('#cropped_foto').val(base64);
        document.getElementById('cropModal').style.display = 'none';
    });

    // ── Bio Word Counter ─────────────────────────────────
    const bioTextarea = document.getElementById('userBio');
    const wordCountSpan = document.getElementById('wordCount');
    
    if (bioTextarea) {
        function countWords(str) {
            str = str.replace(/(^\s*)|(\s*$)/gi,"");
            str = str.replace(/[ ]{2,}/gi," ");
            str = str.replace(/\n /,"\n");
            if (str.length === 0) return 0;
            return str.split(' ').length;
        }

        function updateWordCount(e) {
            let words = countWords(bioTextarea.value);
            
            if (words > 35) {
                let strArr = bioTextarea.value.trim().split(/\s+/);
                bioTextarea.value = strArr.slice(0, 35).join(' ');
                words = 35;
                if (e && e.type === 'keydown' && e.key !== 'Backspace' && e.key !== 'Delete') {
                    e.preventDefault();
                }
            }
            
            wordCountSpan.innerText = words;
            if (words >= 35) {
                wordCountSpan.style.color = '#b70d0f';
            } else {
                wordCountSpan.style.color = '#666';
            }
        }
        
        bioTextarea.addEventListener('input', updateWordCount);
        bioTextarea.addEventListener('keydown', updateWordCount);
        updateWordCount();
    }
});

// ── Modal ────────────────────────────────────────────────
function bukaPreviewModal(id) { document.getElementById('previewModal-' + id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function tutupPreviewModal(id) { document.getElementById('previewModal-' + id).style.display = 'none'; document.body.style.overflow = ''; }
function bukaRevisiModal(id)  { document.getElementById('revisiModal-' + id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function tutupRevisiModal(id) { document.getElementById('revisiModal-' + id).style.display = 'none'; document.body.style.overflow = ''; }

document.querySelectorAll('.profil-modal').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target === m) { m.style.display = 'none'; document.body.style.overflow = ''; }
    });
});
</script>
@endpush
