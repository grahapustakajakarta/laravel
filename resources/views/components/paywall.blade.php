<div class="paywall-container">
    <div class="paywall-fade"></div>
    <div class="paywall-content">
        <h2>Keep Reading</h2>
        
        <div class="paywall-icon">
            <svg viewBox="0 0 100 100" width="120" height="120" xmlns="http://www.w3.org/2000/svg">
                <!-- Typewriter SVG -->
                <!-- Paper -->
                <path d="M35 15 L65 15 L65 30 L35 30 Z" fill="none" stroke="#111" stroke-width="3" stroke-linejoin="round"/>
                <!-- Paper lines -->
                <line x1="42" y1="20" x2="58" y2="20" stroke="#111" stroke-width="2" stroke-linecap="round"/>
                <line x1="40" y1="25" x2="60" y2="25" stroke="#111" stroke-width="2" stroke-linecap="round"/>
                
                <!-- Roller -->
                <path d="M28 30 L72 30 L72 38 L28 38 Z" fill="none" stroke="#111" stroke-width="3" stroke-linejoin="round" rx="2"/>
                <line x1="24" y1="34" x2="28" y2="34" stroke="#111" stroke-width="3" stroke-linecap="round"/>
                <line x1="72" y1="34" x2="76" y2="34" stroke="#111" stroke-width="3" stroke-linecap="round"/>
                
                <!-- Main Body -->
                <path d="M22 45 L78 45 L82 70 L18 70 Z" fill="none" stroke="#111" stroke-width="3" stroke-linejoin="round"/>
                <path d="M28 38 L72 38 L78 45 L22 45 Z" fill="none" stroke="#111" stroke-width="3" stroke-linejoin="round"/>
                
                <!-- Keys background -->
                <path d="M22 50 L78 50 L80 65 L20 65 Z" fill="#111"/>
                
                <!-- Keys (White dots) -->
                <circle cx="28" cy="54" r="1.5" fill="#fff"/>
                <circle cx="34" cy="54" r="1.5" fill="#fff"/>
                <circle cx="40" cy="54" r="1.5" fill="#fff"/>
                <circle cx="46" cy="54" r="1.5" fill="#fff"/>
                <circle cx="52" cy="54" r="1.5" fill="#fff"/>
                <circle cx="58" cy="54" r="1.5" fill="#fff"/>
                <circle cx="64" cy="54" r="1.5" fill="#fff"/>
                <circle cx="70" cy="54" r="1.5" fill="#fff"/>
                
                <circle cx="31" cy="59" r="1.5" fill="#fff"/>
                <circle cx="37" cy="59" r="1.5" fill="#fff"/>
                <circle cx="43" cy="59" r="1.5" fill="#fff"/>
                <circle cx="49" cy="59" r="1.5" fill="#fff"/>
                <circle cx="55" cy="59" r="1.5" fill="#fff"/>
                <circle cx="61" cy="59" r="1.5" fill="#fff"/>
                <circle cx="67" cy="59" r="1.5" fill="#fff"/>
                
                <!-- Spacebar -->
                <line x1="40" y1="63" x2="60" y2="63" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                
                <!-- Lever -->
                <path d="M28 30 L20 30 L20 20 L24 20" fill="none" stroke="#111" stroke-width="3" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="paywall-desc">
            Continue reading with a <em>Galeri Buku Jakarta</em> subscription and get unlimited access, exclusive newsletters, and more. <strong>Your first month is free.</strong>
        </div>

        <a href="{{ route('subscribe', ['plan' => 'paket4bulan']) }}" class="paywall-btn">START FREE TRIAL</a>

        <div class="paywall-signin">
            Already a subscriber? <a href="{{ route('user.signin') }}">Sign In</a>
        </div>
    </div>
</div>

<style>
    .paywall-container {
        position: relative;
        margin-top: -60px; /* Overlap with the text slightly */
        padding-top: 100px;
        text-align: center;
        clear: both;
        font-family: 'Source Sans 3', Arial, sans-serif;
    }
    
    .paywall-fade {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 120px;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 80%);
        pointer-events: none;
        z-index: 10;
    }

    .paywall-content {
        position: relative;
        z-index: 20;
        background: #fff;
        padding: 20px 20px 60px;
        max-width: 650px;
        margin: 0 auto;
    }

    .paywall-content h2 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 25px;
        letter-spacing: -0.5px;
    }

    .paywall-icon {
        margin: 20px 0 30px;
        display: flex;
        justify-content: center;
    }

    .paywall-desc {
        font-size: 1.05rem;
        color: #111;
        line-height: 1.6;
        margin-bottom: 35px;
        font-family: 'Source Sans 3', Arial, sans-serif !important;
        text-align: center !important;
    }
    
    .paywall-desc em {
        font-style: italic;
    }

    .paywall-desc strong {
        font-weight: 700;
    }

    .paywall-btn {
        display: inline-block;
        background: #e6231f; /* Matching the red button from the image */
        color: #fff !important;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 16px 40px;
        text-decoration: none;
        border-radius: 4px;
        transition: background 0.2s;
        margin-bottom: 25px;
        width: 100%;
        max-width: 320px;
        box-sizing: border-box;
    }

    .paywall-btn:hover {
        background: #c01b17;
    }

    .paywall-signin {
        font-size: 0.95rem;
        color: #666;
    }

    .paywall-signin a {
        color: #111 !important;
        text-decoration: underline !important;
        font-weight: 400;
        text-underline-offset: 3px;
    }
    .paywall-signin a:hover {
        color: #e6231f !important;
    }
</style>
