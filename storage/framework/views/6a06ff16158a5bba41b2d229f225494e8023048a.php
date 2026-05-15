<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIP Puskesmas Driyorejo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        html,body{min-height:100vh;font-family:'Plus Jakarta Sans',sans-serif;overflow-x:hidden;overflow-y:auto}

        /* === BACKGROUND === */
        body{
            background:linear-gradient(135deg,#021a10 0%,#032e1c 25%,#054a2c 50%,#032e1c 75%,#021a10 100%);
            position:relative;
        }

        /* Canvas for particles */
        #particleCanvas{position:fixed;inset:0;z-index:0;pointer-events:none}
        
        body:not(:hover) .glass-card::before { animation-play-state: paused !important; }
        body:not(:hover) .logo-orbit::before, body:not(:hover) .logo-orbit::after { animation-play-state: paused !important; }
        body:not(:hover) .btn-login { animation-play-state: paused !important; }

        /* === FLOATING MEDICAL ICONS === */
        .med-bg{position:fixed;inset:0;z-index:1;pointer-events:none;overflow:hidden}
        .med-item{
            position:absolute;
            color:rgba(52,211,153,0.55);
            font-size:var(--s,2.5rem);
            top:var(--y,50%);
            left:var(--x,50%);
            filter:drop-shadow(0 0 15px rgba(16,185,129,0.5)) drop-shadow(0 0 30px rgba(5,150,105,0.25));
            text-shadow:0 0 20px rgba(16,185,129,0.4);
            transform: translate(0, 0);
            transition: transform 0.15s ease-out;
        }
        .med-item:nth-child(even){color:rgba(110,231,183,0.5)}
        .med-item:nth-child(3n){color:rgba(167,243,208,0.45)}

        /* === BLOBS === */
        .orb{position:fixed;border-radius:50%;filter:blur(80px);opacity:.4;z-index:0;transition:transform 0.2s ease-out}
        .orb-1{width:500px;height:500px;background:radial-gradient(circle,#059669,transparent);top:-15%;left:-10%}
        .orb-2{width:400px;height:400px;background:radial-gradient(circle,#10B981,transparent);bottom:-10%;right:-5%}
        .orb-3{width:300px;height:300px;background:radial-gradient(circle,#047857,transparent);top:50%;left:60%}

        /* === WRAPPER === */
        .login-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;position:relative;z-index:2}

        /* === GLASS CARD === */
        .glass-card{
            background:rgba(255,255,255,0.07);
            backdrop-filter:blur(20px) saturate(180%);
            -webkit-backdrop-filter:blur(20px) saturate(180%);
            border:1px solid rgba(16,185,129,0.25);
            border-radius:24px;
            width:100%;max-width:420px;
            padding:2.5rem 2.25rem;
            box-shadow:0 25px 50px rgba(0,0,0,0.5),0 0 80px rgba(5,150,105,0.15),inset 0 1px 0 rgba(255,255,255,0.1);
            animation:cardIn .8s cubic-bezier(.16,1,.3,1) forwards;
            opacity:0;transform:translateY(50px) scale(.96);
            position:relative;overflow:hidden;
        }
        .glass-card::before{
            content:'';position:absolute;top:0;left:0;right:0;height:3px;
            background:linear-gradient(90deg,transparent,#10B981,#059669,#10B981,transparent);
            background-size:300% 100%;animation:shimBar 4s linear infinite;
        }

        @keyframes cardIn{to{opacity:1;transform:translateY(0) scale(1)}}
        @keyframes shimBar{0%{background-position:300% 0}100%{background-position:-300% 0}}

        /* === BRAND === */
        .brand{text-align:center;margin-bottom:2rem}
        .logo-orbit{display:inline-block;position:relative;width:90px;height:90px;margin-bottom:1rem}
        .logo-orbit::before{
            content:'';position:absolute;inset:-6px;border-radius:50%;
            border:2px solid transparent;border-top-color:#10B981;border-right-color:#059669;
            animation:spin 3s linear infinite;
        }
        .logo-orbit::after{
            content:'';position:absolute;inset:-12px;border-radius:50%;
            border:1.5px solid transparent;border-bottom-color:#34D399;border-left-color:#10B981;
            animation:spin 5s linear infinite reverse;
        }
        @keyframes spin{to{transform:rotate(360deg)}}

        .logo-img{
            width:78px;height:78px;border-radius:50%;object-fit:cover;
            border:3px solid rgba(16,185,129,0.4);
            position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
            box-shadow:0 0 30px rgba(5,150,105,0.3);
            transition:transform .4s;z-index:1;
        }
        .logo-img:hover{transform:translate(-50%,-50%) scale(1.08)}

        .brand h1{font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-.5px;margin-bottom:.15rem;text-shadow:0 2px 10px rgba(0,0,0,.3)}
        .brand p{font-size:.85rem;color:rgba(255,255,255,.6);font-weight:500}

        .secure-badge{
            display:inline-flex;align-items:center;gap:.3rem;
            background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);
            border-radius:50px;padding:.25rem .75rem;font-size:.72rem;
            color:#34D399;font-weight:600;margin-top:.6rem;
        }

        /* === FORM === */
        .field{position:relative;margin-bottom:1rem}
        .field input{
            width:100%;padding:.9rem 1rem .9rem 3rem;
            background:rgba(255,255,255,0.06);
            border:1.5px solid rgba(16,185,129,0.3);
            border-radius:14px;color:#fff;font-size:.95rem;
            transition:all .3s ease;outline:none;
            font-family:'Plus Jakarta Sans',sans-serif;
        }
        .field input::placeholder{color:rgba(255,255,255,.35)}
        .field input:focus{
            border-color:#10B981;
            box-shadow:0 0 0 4px rgba(16,185,129,.15),0 0 20px rgba(5,150,105,.1);
            background:rgba(255,255,255,0.1);
        }
        .field .fi{
            position:absolute;top:50%;left:1rem;transform:translateY(-50%);
            color:rgba(52,211,153,.6);font-size:1rem;transition:color .3s;pointer-events:none;
        }
        .field:focus-within .fi{color:#10B981}
        .field input[name="kode_id"]{font-family:'Courier New',monospace;letter-spacing:2px}

        .pw-eye{
            position:absolute;top:50%;right:1rem;transform:translateY(-50%);
            background:none;border:none;color:rgba(52,211,153,.5);cursor:pointer;
            font-size:.95rem;transition:color .3s;padding:0;
        }
        .pw-eye:hover{color:#10B981}

        /* === BUTTON === */
        .btn-login{
            display:flex;align-items:center;justify-content:center;gap:.5rem;
            width:100%;padding:.95rem;margin-top:.5rem;
            background:linear-gradient(135deg,#059669,#047857,#10B981);
            background-size:200% 200%;animation:gradShift 4s ease infinite;
            color:#fff;font-weight:700;font-size:1rem;
            border:none;border-radius:14px;cursor:pointer;
            box-shadow:0 8px 25px rgba(5,150,105,.5);
            transition:all .3s ease;position:relative;overflow:hidden;
        }
        .btn-login::before{
            content:'';position:absolute;top:50%;left:50%;width:0;height:0;
            background:rgba(255,255,255,.15);border-radius:50%;
            transition:width .6s,height .6s,top .6s,left .6s;
            transform:translate(-50%,-50%);
        }
        .btn-login:hover::before{width:300px;height:300px}
        .btn-login:hover{transform:translateY(-3px);box-shadow:0 12px 35px rgba(5,150,105,.6)}
        .btn-login:active{transform:translateY(0)}
        .btn-login .arrow{transition:transform .3s}
        .btn-login:hover .arrow{transform:translateX(5px)}

        @keyframes gradShift{
            0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}
        }

        /* === DIVIDER === */
        .sep{display:flex;align-items:center;gap:.75rem;margin:1.5rem 0;color:rgba(255,255,255,.25);font-size:.78rem}
        .sep::before,.sep::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(16,185,129,.3),transparent)}

        /* === HELP === */
        .help{text-align:center}
        .help p{color:rgba(255,255,255,.45);font-size:.82rem;margin-bottom:.7rem;font-weight:500}
        .wa-btn{
            display:inline-flex;align-items:center;gap:.4rem;
            background:linear-gradient(135deg,#25D366,#128C7E);
            color:#fff;padding:.55rem 1.3rem;border-radius:50px;
            text-decoration:none;font-weight:600;font-size:.82rem;
            transition:all .3s;box-shadow:0 4px 15px rgba(37,211,102,.3);
        }
        .wa-btn:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(37,211,102,.4);color:#fff}

        /* === FOOTER === */
        .foot{position:absolute;bottom:1rem;left:0;right:0;text-align:center;font-size:.72rem;color:rgba(255,255,255,.25);z-index:2}

        /* === RESPONSIVE === */
        @media(max-width:480px){
            .glass-card{padding:2rem 1.5rem;margin:1rem;width:calc(100% - 2rem)}
            .med-item{transform:scale(0.7) !important} /* Make icons smaller on mobile */
            .logo-orbit{width:70px;height:70px}
            .logo-img{width:60px;height:60px}
            .brand h1{font-size:1.3rem}
            .login-wrap{padding:1rem}
            .foot{position:relative;margin-top:1rem;bottom:0}
        }
    </style>
</head>
<body>
    <canvas id="particleCanvas"></canvas>

    <!-- Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Floating medical icons -->
    <div class="med-bg" aria-hidden="true">
        <i class="fas fa-stethoscope med-item" style="--s:3.5rem;--x:10%;--y:20%;" data-speed="3"></i>
        <i class="fas fa-heart-pulse med-item" style="--s:3rem;--x:80%;--y:15%;" data-speed="-2.5"></i>
        <i class="fas fa-pills med-item" style="--s:2.5rem;--x:20%;--y:70%;" data-speed="1.8"></i>
        <i class="fas fa-briefcase-medical med-item" style="--s:4rem;--x:85%;--y:80%;" data-speed="-3"></i>
        <i class="fas fa-hospital med-item" style="--s:5rem;--x:50%;--y:10%;" data-speed="1"></i>
        <i class="fas fa-microscope med-item" style="--s:3.5rem;--x:15%;--y:45%;" data-speed="-1.5"></i>
        <i class="fas fa-user-doctor med-item" style="--s:4rem;--x:75%;--y:50%;" data-speed="2.5"></i>
        <i class="fas fa-dna med-item" style="--s:2.8rem;--x:40%;--y:85%;" data-speed="-1.2"></i>
        <i class="fas fa-syringe med-item" style="--s:3rem;--x:90%;--y:35%;" data-speed="3.5"></i>
        <i class="fas fa-notes-medical med-item" style="--s:2.5rem;--x:5%;--y:80%;" data-speed="-2"></i>
        <i class="fas fa-tablets med-item" style="--s:2.2rem;--x:60%;--y:25%;" data-speed="1.5"></i>
        <i class="fas fa-kit-medical med-item" style="--s:3.8rem;--x:30%;--y:15%;" data-speed="-3.2"></i>
        <i class="fas fa-lungs med-item" style="--s:3rem;--x:95%;--y:70%;" data-speed="2.2"></i>
        <i class="fas fa-vial med-item" style="--s:2rem;--x:50%;--y:90%;" data-speed="-2.8"></i>
        <i class="fas fa-thermometer med-item" style="--s:2.6rem;--x:25%;--y:55%;" data-speed="1.4"></i>
        <i class="fas fa-hand-holding-medical med-item" style="--s:3.2rem;--x:65%;--y:65%;" data-speed="-1.8"></i>
    </div>

    <div class="login-wrap">
        <div class="glass-card">
            <div class="brand">
                <div class="logo-orbit">
                    <img src="https://img.favpng.com/9/7/20/puskesmas-regency-bengkulu-health-logo-png-favpng-QBnrLkYYPT1QdTbmGSNWRXN8J.jpg"
                         alt="Logo Puskesmas" class="logo-img"
                         onerror="this.src='https://ui-avatars.com/api/?name=SIP&background=059669&color=fff&rounded=true&size=128'">
                </div>
                <h1>SIP Driyorejo</h1>
                <p>Sistem Informasi Puskesmas</p>
                <div class="secure-badge"><i class="fas fa-shield-halved"></i> Akses Aman &amp; Terenkripsi</div>
            </div>

            <form action="<?php echo e(route('login')); ?>" method="POST" id="loginForm">
                <?php echo csrf_field(); ?>
                <div class="field">
                    <i class="fas fa-id-badge fi"></i>
                    <input type="text" name="kode_id" id="kodeId" placeholder="Kode ID Login" value="<?php echo e(old('kode_id')); ?>" required autofocus autocomplete="off">
                </div>
                <div class="field">
                    <i class="fas fa-lock fi"></i>
                    <input type="password" name="password" id="pwInput" placeholder="Password" required autocomplete="current-password">
                    <button type="button" class="pw-eye" id="pwToggle" aria-label="Toggle password"><i class="fas fa-eye-slash" id="pwIcon"></i></button>
                </div>
                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fas fa-right-to-bracket"></i>
                    <span id="btnLabel">Masuk</span>
                    <i class="fas fa-arrow-right arrow"></i>
                </button>
            </form>

            <div class="sep">atau</div>

            <div class="help">
                <p>Belum punya akun? Hubungi Admin</p>
                <a href="https://wa.me/6285604099078?text=Halo%20Admin,%20saya%20ingin%20meminta%20akses%20akun%20SIP%20Puskesmas%20Driyorejo" target="_blank" rel="noopener" class="wa-btn">
                    <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <p class="foot">&copy; <?php echo e(date('Y')); ?> Puskesmas Driyorejo — SIP v2.0</p>

    <script>
    // ── Particles ──
    const cvs=document.getElementById('particleCanvas'),ctx=cvs.getContext('2d');
    let W,H,particles=[];
    function resize(){W=cvs.width=window.innerWidth;H=cvs.height=window.innerHeight}
    window.addEventListener('resize',resize);resize();

    class Particle{
        constructor(){this.reset()}
        reset(){
            this.x=Math.random()*W;this.y=Math.random()*H;
            this.r=Math.random()*2+.5;
            this.vx=(Math.random()-.5)*.4;this.vy=(Math.random()-.5)*.4;
            this.alpha=Math.random()*.5+.1;
            this.color=`hsla(${140+Math.random()*30},80%,70%,${this.alpha})`;
        }
        update(){
            this.x+=this.vx;this.y+=this.vy;
            if(this.x<0||this.x>W)this.vx*=-1;
            if(this.y<0||this.y>H)this.vy*=-1;
        }
        draw(){
            ctx.beginPath();ctx.arc(this.x,this.y,this.r,0,Math.PI*2);
            ctx.fillStyle=this.color;ctx.fill();
        }
    }

    for(let i=0;i<80;i++)particles.push(new Particle());

    function drawLines(){
        for(let i=0;i<particles.length;i++){
            for(let j=i+1;j<particles.length;j++){
                const dx=particles[i].x-particles[j].x,dy=particles[i].y-particles[j].y;
                const dist=Math.sqrt(dx*dx+dy*dy);
                if(dist<120){
                    ctx.beginPath();ctx.moveTo(particles[i].x,particles[i].y);
                    ctx.lineTo(particles[j].x,particles[j].y);
                    ctx.strokeStyle=`rgba(16,185,129,${.12*(1-dist/120)})`;
                    ctx.lineWidth=.5;ctx.stroke();
                }
            }
        }
    }

    function animateParticles(){
        ctx.clearRect(0,0,W,H);
        particles.forEach(p=>{p.update();p.draw()});
        drawLines();
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    // ── Parallax Mouse/Touch Move ──
    function updateParallax(clientX, clientY) {
        const x = (clientX - W / 2) / 100;
        const y = (clientY - H / 2) / 100;
        
        document.querySelectorAll(".med-item").forEach(item => {
            const speed = parseFloat(item.getAttribute("data-speed") || 1);
            // Limit movement on mobile
            const mult = W < 480 ? 1 : 2.5;
            item.style.transform = `translate(${x * speed * mult}px, ${y * speed * mult}px) scale(${W < 480 ? 0.7 : 1})`;
        });
        
        document.querySelectorAll(".orb").forEach((orb, index) => {
            const speed = (index + 1) * -1.5;
            orb.style.transform = `translate(${x * speed * 3}px, ${y * speed * 3}px)`;
        });
    }

    document.addEventListener("mousemove", e => updateParallax(e.clientX, e.clientY));
    
    // Parallax on mobile via device orientation
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', function(e) {
            if(W >= 480) return; // Only apply on mobile
            const clientX = W/2 + (e.gamma || 0) * 5; // gamma is left/right
            const clientY = H/2 + ((e.beta || 0) - 45) * 5; // beta is front/back
            updateParallax(clientX, clientY);
        });
    }

    // ── Password Toggle ──
    const pwI=document.getElementById('pwInput'),pwT=document.getElementById('pwToggle'),pwIc=document.getElementById('pwIcon');
    pwT.addEventListener('click',()=>{
        const show=pwI.type==='password';
        pwI.type=show?'text':'password';
        pwIc.className=show?'fas fa-eye':'fas fa-eye-slash';
    });

    // ── Form Submit ──
    document.getElementById('loginForm').addEventListener('submit',function(e){
        const btn=document.getElementById('submitBtn'),lbl=document.getElementById('btnLabel');
        btn.disabled=true;lbl.textContent='Memproses…';
        btn.querySelector('.arrow').className='fas fa-spinner fa-spin arrow';
    });

    // ── Error Popup (SweetAlert2) ──
    <?php if($errors->any()): ?>
    Swal.fire({
        icon:'error',
        title:'Login Gagal!',
        text:<?php echo json_encode($errors->first('kode_id') ?? 'Kode ID atau Password salah.'); ?>,
        confirmButtonColor:'#059669',
        background:'rgba(2,26,16,0.95)',
        color:'#fff',
        backdrop:'rgba(2,26,16,0.6)',
        customClass:{popup:'animate__animated animate__shakeX'}
    });
    <?php endif; ?>

    // ── Success Animation on page load ──
    <?php if(session('status')): ?>
    Swal.fire({
        icon:'success',
        title:'Berhasil!',
        text:<?php echo json_encode(session('status')); ?>,
        confirmButtonColor:'#059669',
        background:'rgba(2,26,16,0.95)',
        color:'#fff',
        timer:3000,
        timerProgressBar:true
    });
    <?php endif; ?>
    </script>
</body>
</html><?php /**PATH C:\laragon\www\maganglaravel\resources\views/auth/login.blade.php ENDPATH**/ ?>