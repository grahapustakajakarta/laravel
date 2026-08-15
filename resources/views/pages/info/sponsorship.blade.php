@extends('layouts.app')

@push('styles')
<style>
    /* =========================================
       BAGIAN 1: NEWSLETTER BANNER
       ========================================= */
    .newsletter-section {
        background-color: #EFEFEA; 
        padding: 90px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .pattern-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: repeating-linear-gradient(90deg, transparent, transparent 15px, #7e3dd4 15px, #7e3dd4 17px);
        -webkit-mask-image: repeating-linear-gradient(-35deg, black, black 40px, transparent 40px, transparent 80px);
        mask-image: repeating-linear-gradient(-35deg, black, black 40px, transparent 40px, transparent 80px);
        z-index: 1;
    }

    .newsletter-box {
        background-color: #ffffff;
        width: 100%;
        max-width: 880px;
        display: flex;
        padding: 55px 45px;
        position: relative;
        z-index: 2;
    }

    .newsletter-left {
        flex: 1;
        padding-right: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .newsletter-left h2 {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.15;
        margin-top: 0;
        margin-bottom: 25px;
        letter-spacing: -0.5px;
        color: #000;
    }

    .newsletter-left a {
        color: #7e3dd4;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .newsletter-right {
        flex: 1.1;
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .newsletter-right p {
        font-family: Georgia, serif;
        font-size: 16px;
        color: #444;
        line-height: 1.5;
        margin-top: 0;
        margin-bottom: 30px;
    }

    .form-group {
        display: flex;
        align-items: flex-end;
        gap: 15px;
        margin-bottom: 5px;
    }

    .input-wrapper {
        flex: 1;
    }

    .input-wrapper input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #d1d1d1;
        padding: 10px 0;
        font-size: 13px;
        color: #333;
        outline: none;
        background: transparent;
    }
    
    .input-wrapper input::placeholder {
        color: #999;
    }

    .form-group button,
    .form-group a.btn-selengkapnya {
        background-color: #7e3dd4;
        color: #fff;
        border: none;
        padding: 13px 22px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    /* =========================================
       BAGIAN 2: LOGO GRID & SVG ART
       ========================================= */
    .logos-section {
        max-width: 950px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .logos-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 15px;
        margin-bottom: 40px;
    }

    .logos-header h2 {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #000;
        margin: 0;
    }

    .logos-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        row-gap: 50px;
        column-gap: 20px;
    }

    /* Styling khusus container logo buatan kode */
    .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        text-align: center;
        height: 80px; 
    }

    .logo-art {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .logo-text {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #000;
        line-height: 1.2;
    }

    @media (max-width: 768px) {
        .newsletter-box { flex-direction: column; padding: 35px; }
        .newsletter-left { padding-right: 0; margin-bottom: 30px; }
        .newsletter-right { padding-left: 0; }
        .logos-grid { grid-template-columns: repeat(3, 1fr); row-gap: 40px; }
        .logos-header { flex-direction: column; align-items: flex-start; gap: 15px; }
    }
</style>
@endpush

@section('content')
    <section class="newsletter-section">
        <div class="pattern-overlay"></div> 
        <div class="newsletter-box">
            <div class="newsletter-left">
                <h2>Reclaiming Our <br>Cities with Art <br>and Culture</h2>
                <a href="{{ url('/page/jktplus') }}">See All Inspiration</a>
            </div>
            <div class="newsletter-right">
                <p>Kolaborasi bersama merayakan kota; menghasilkan karya bermakna dan berdampak. Inovatif dan berkelanjutan..</p>
                <div class="form-group">
                    <a href="#" class="btn-selengkapnya">Here We Are</a>
                </div>
            </div>
        </div>
    </section>

    <section class="logos-section">
        <div class="logos-header">
            <h2>Galeri Network Group</h2>
            
        </div>

        <div class="logos-grid">
            <div class="logo-container">
                <div class="logo-art"><svg width="60" height="50" viewBox="0 0 60 50"><text x="30" y="45" font-family="serif" font-size="45" font-weight="bold" text-anchor="middle">A</text><ellipse cx="22" cy="28" rx="15" ry="5" fill="none" stroke="black" stroke-width="1.5" transform="rotate(-20 25 35)"/></svg></div>
                <div class="logo-text">AVERY</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="50" height="50" viewBox="0 0 60 60"><rect x="10" y="5" width="40" height="50" fill="none" stroke="black" stroke-width="2"/><text x="30" y="45" font-family="serif" font-size="40" text-anchor="middle">B</text></svg></div>
                <div class="logo-text">BERKLEY</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><rect x="5" y="5" width="30" height="40" fill="none" stroke="black" stroke-width="3"/></svg></div>
                <div class="logo-text">DUTTON</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="50" viewBox="0 0 50 60"><rect x="0" y="0" width="50" height="60" fill="black"/><text x="25" y="45" font-family="serif" font-size="45" font-style="italic" fill="white" text-anchor="middle">ft</text></svg></div>
                <div class="logo-text">FAMILY<br>TREE<br>BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="85" height="25" viewBox="0 0 100 30"><rect x="0" y="0" width="100" height="30" rx="15" fill="#222"/><text x="50" y="16" font-family="sans-serif" font-size="10" font-weight="bold" fill="white" text-anchor="middle" letter-spacing="1">PUTNAM</text><text x="50" y="24" font-family="sans-serif" font-size="5" fill="white" text-anchor="middle" letter-spacing="2">EST. 1838</text></svg></div>
                <div class="logo-text"></div> </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 40 60"><text x="20" y="55" font-family="serif" font-size="60" font-weight="bold" text-anchor="middle">I</text><line x1="0" y1="20" x2="40" y2="30" stroke="white" stroke-width="3"/><line x1="0" y1="40" x2="40" y2="35" stroke="white" stroke-width="2"/></svg></div>
                <div class="logo-text">IMPACT</div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="55" viewBox="0 0 50 60"><rect x="0" y="0" width="50" height="60" fill="black"/><circle cx="25" cy="30" r="18" fill="white"/><text x="25" y="38" font-family="serif" font-size="28" font-weight="bold" fill="black" text-anchor="middle">kp</text></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 50 60"><path d="M10,60 L20,0 L40,60" fill="none" stroke="black" stroke-width="8"/><path d="M10,0 L10,60" stroke="black" stroke-width="8"/><path d="M40,0 L40,60" stroke="black" stroke-width="8"/><line x1="0" y1="10" x2="50" y2="20" stroke="white" stroke-width="2"/><line x1="0" y1="30" x2="50" y2="40" stroke="white" stroke-width="3"/></svg></div>
                <div class="logo-text">NORTH<br>LIGHT<br>BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><circle cx="25" cy="25" r="20" fill="none" stroke="black" stroke-width="1.5"/><text x="25" y="30" font-family="serif" font-size="16" fill="black" text-anchor="middle">pgd</text></svg></div>
                <div class="logo-text" style="font-size:7px;">PAMELA<br>DORMAN<br>BOOKS<br>VIKING</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><ellipse cx="20" cy="25" rx="15" ry="22" fill="none" stroke="black" stroke-width="2"/><path d="M20,10 C15,15 15,35 20,40 C25,35 25,15 20,10 Z" fill="black"/></svg></div>
                <div class="logo-text">PENGUIN<br>CLASSICS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><rect x="0" y="0" width="50" height="50" fill="black"/><text x="20" y="35" font-family="serif" font-size="30" fill="white" text-anchor="middle">P</text><text x="30" y="35" font-family="serif" font-size="30" fill="white" text-anchor="middle">P</text></svg></div>
                <div class="logo-text" style="text-transform: capitalize;">Penguin<br>Press</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="40" viewBox="0 0 50 50"><path d="M25,45 C10,45 10,25 25,25 C40,25 40,5 25,5 C10,5 10,25 25,25" fill="none" stroke="black" stroke-width="5"/><circle cx="25" cy="25" r="5" fill="black"/></svg></div>
                <div class="logo-text">PLUME</div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="45" viewBox="0 0 40 50"><rect x="0" y="15" width="40" height="15" fill="black"/><text x="20" y="45" font-family="serif" font-size="50" font-weight="bold" fill="black" text-anchor="middle">P</text><rect x="0" y="15" width="40" height="15" fill="none" stroke="white" stroke-width="2"/></svg></div>
                <div class="logo-text" style="font-size:7px;">POPULAR WOODWORKING BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="50" viewBox="0 0 50 60"><circle cx="25" cy="45" r="15" fill="#e86b24"/><path d="M15,60 L25,30 L35,60 Z" fill="black"/><circle cx="25" cy="25" r="5" fill="black"/><line x1="10" y1="10" x2="40" y2="40" stroke="black" stroke-width="2"/></svg></div>
                <div class="logo-text">PORTFOLIO<br>PENGUIN</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><rect x="0" y="0" width="50" height="50" fill="#222"/><text x="25" y="38" font-family="serif" font-size="40" fill="white" text-anchor="middle">R</text></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 40 60"><rect x="30" y="20" width="8" height="12" fill="black"/><path d="M20,10 L15,60 L25,60 Z" fill="black"/><circle cx="20" cy="15" r="6" fill="black"/><line x1="20" y1="20" x2="35" y2="20" stroke="black" stroke-width="2"/></svg></div>
                <div class="logo-text">SENTINEL</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><text x="20" y="45" font-family="serif" font-size="45" font-style="italic" fill="#0b7a39" text-anchor="middle">t</text><path d="M20,10 C25,5 35,5 40,10" fill="none" stroke="#0b7a39" stroke-width="3"/></svg></div>
                <div class="logo-text" style="text-transform: capitalize;">Tarcher</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="65" height="45" viewBox="0 0 80 50"><text x="35" y="45" font-family="serif" font-size="45" font-weight="bold" fill="#222" text-anchor="middle">A</text><path d="M15,45 L20,30 L25,45 Z" fill="black"/><circle cx="20" cy="25" r="4" fill="black"/><line x1="20" y1="35" x2="30" y2="35" stroke="black" stroke-width="3"/><text x="50" y="20" font-family="sans-serif" font-size="14" font-weight="bold">Tiny</text><text x="50" y="35" font-family="sans-serif" font-size="14" font-weight="bold">Rep</text><text x="50" y="50" font-family="sans-serif" font-size="14" font-weight="bold">Books</text></svg></div>
                <div class="logo-text"></div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="55" height="35" viewBox="0 0 60 40"><ellipse cx="30" cy="20" rx="25" ry="18" fill="none" stroke="black" stroke-width="1.5"/><path d="M10,25 Q30,40 50,25 Q30,30 10,25 Z" fill="black"/><path d="M25,5 L25,25 L35,25 L35,5 Z" fill="none" stroke="black" stroke-width="1.5"/><path d="M30,5 L40,15 L30,25" fill="none" stroke="black" stroke-width="1.5"/></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><circle cx="25" cy="25" r="23" fill="#222"/><circle cx="25" cy="25" r="20" fill="none" stroke="white" stroke-width="1"/><text x="25" y="32" font-family="sans-serif" font-size="18" font-weight="bold" fill="white" text-anchor="middle">WD</text></svg></div>
                <div class="logo-text">WRITER'S DIGEST<br>BOOKS</div>
            </div>
            
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </section>
@endsection
