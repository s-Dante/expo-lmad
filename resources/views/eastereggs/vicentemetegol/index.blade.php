<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Vicente Metegol</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bytesized&family=Jersey+10&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fireworks-js@2.x/dist/index.umd.js"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(135deg, #0B2927, #214f35);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        sponsors {
            position: absolute;
            z-index: 2;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .perimeter-board {
            position: absolute;
            overflow: hidden;
            background: #2D6E20;
        }

        .perimeter-board.left {
            left: 0;
            top: 0;
            height: 100%;
            width: 5vw;
            margin: 0px 10px;
        }

        .perimeter-board.right {
            right: 0;
            top: 0;
            height: 100%;
            width: 5vw;
            margin: 0px 10px;
        }

        .perimeter-board.top {
            top: 0;
            left: 0;
            width: 100%;
            height: 5vw;
            margin: 10px 0px;
        }

        .perimeter-board.bottom {
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5vw;
            margin: 10px 0px;
        }

        .scroll-content {
            display: flex;
            gap: 40px;
            /* Espacio fijo entre logos */
            align-items: center;
            justify-content: center;
        }

        .scroll-content.left,
        .scroll-content.right {
            flex-direction: column;
            width: 100%;
            padding: 20px 0;
        }

        .scroll-content.top,
        .scroll-content.bottom {
            flex-direction: row;
            height: 100%;
            padding: 0 20px;
        }

        .scroll-content.left {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            animation: scroll-vertical 10s linear infinite;

        }

        .scroll-content.right {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            animation: scroll-vertical 10s linear infinite reverse;
        }

        /* Rotación correcta para laterales */
        .perimeter-board.left,
        .perimeter-board.right {
            width: 6vw;
            height: 100%;
            margin: 0;
        }

        .perimeter-board.top,
        .perimeter-board.bottom {
            width: 100%;
            height: 22vw;
            margin: 0;
        }

        .scroll-content.top {
            display: flex;
            height: 100%;
            animation: scroll 10s linear infinite;
        }

        .scroll-content.bottom {
            display: flex;
            height: 100%;
            animation: scroll 10s linear infinite reverse;
            animation-direction: reverse;
        }

        .sponsor-logo-vertical {
            width: 110%;
            max-width: 200px;
            height: auto;
            object-fit: contain;
            margin-top: 101px;
        }

        .perimeter-board.left .sponsor-logo-vertical {
            transform: rotate(-90deg);
        }

        .perimeter-board.right .sponsor-logo-vertical {
            transform: rotate(90deg);
        }

        .sponsor-logo-horizontal {
            height: 100%;
            width: auto;
            max-height: 50px;
            object-fit: contain;
        }

        @keyframes scroll-vertical {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }

            /* move up half since content is doubled */
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }

            /* move left half since content is doubled */
        }

        canvas {
            display: block;
            background-color: #214f35;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            max-width: 100vw;
            max-height: 100vh;

            touch-action: none;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        fireworks {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 2;
        }

        fireworks canvas {
            background-color: transparent !important;
        }

        hud {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: white;
            z-index: 3;
            pointer-events: none;
        }

        h1 {
            font-size: 15vmin;
            font-family: 'Bytesized', sans-serif;
            margin: 0;
            text-align: center;
        }

        score {
            position: absolute;
            bottom: 20px;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;

            font-family: "Jersey 10", sans-serif;
            font-size: 5vmin;
            min-width: 60vmin;
            background-color: #242142;
        }

        score span {
            text-align: center;
        }

        #score {
            background-color: rgb(2, 195, 195);
            min-width: 17vmin;
            grid-column: 2;
        }
    </style>
</head>

<body>

    <sponsors>
        @php
            $tierOrden = ['Titanium', 'Diamante', 'Oro', 'Plata', 'Bronce'];
        @endphp
        <div id="left-sponsor" class="perimeter-board left">
            <div class="scroll-content left">
                @for ($i = 0; $i < 4; $i++)
                    @foreach ($tierOrden as $tierNombre)
                        @if (isset($porTier[$tierNombre]))
                            @foreach ($porTier[$tierNombre] as $patrocinador)
                                @if ($patrocinador->logo_url)
                                    <img src="{{ $patrocinador->logo_url }}" class="sponsor-logo-vertical" alt="{{ $patrocinador->nombre }}">
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endfor
            </div>
        </div>
        <div id="right-sponsor" class="perimeter-board right">
            <div class="scroll-content right">
                @for ($i = 0; $i < 4; $i++)
                    @foreach ($tierOrden as $tierNombre)
                        @if (isset($porTier[$tierNombre]))
                            @foreach ($porTier[$tierNombre] as $patrocinador)
                                @if ($patrocinador->logo_url)
                                    <img src="{{ $patrocinador->logo_url }}" class="sponsor-logo-vertical" alt="{{ $patrocinador->nombre }}">
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endfor
            </div>
        </div>
        <div id="top-sponsor" class="perimeter-board top">
            <div class="scroll-content top">
                @for ($i = 0; $i < 4; $i++)
                    @foreach ($tierOrden as $tierNombre)
                        @if (isset($porTier[$tierNombre]))
                            @foreach ($porTier[$tierNombre] as $patrocinador)
                                @if ($patrocinador->logo_url)
                                    <img src="{{ $patrocinador->logo_url }}" class="sponsor-logo-horizontal" alt="{{ $patrocinador->nombre }}">
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endfor
            </div>
        </div>
        <div id="bottom-sponsor" class="perimeter-board bottom">
            <div class="scroll-content bottom">
                @for ($i = 0; $i < 4; $i++)
                    @foreach ($tierOrden as $tierNombre)
                        @if (isset($porTier[$tierNombre]))
                            @foreach ($porTier[$tierNombre] as $patrocinador)
                                @if ($patrocinador->logo_url)
                                    <img src="{{ $patrocinador->logo_url }}" class="sponsor-logo-horizontal" alt="{{ $patrocinador->nombre }}">
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endfor
            </div>
        </div>
    </sponsors>

    <canvas id="canvas">
    </canvas>
    <hud>
        <h1 id="msg"></h1>
        <score>
            <span>Visitante</span>
            <span id="score">0-0</span>
            <span>Vicente</span>
        </score>
    </hud>
    <fireworks></fireworks>
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d", { willReadFrequently: true });
        ctx.imageSmoothingEnabled = false;
        const msg = document.getElementById('msg');
        const hud = document.querySelector('hud');
        const score = document.getElementById('score');
        const fireworkContainer = document.querySelector('fireworks');
        const leftSponsor = document.getElementById('left-sponsor');
        const rightSponsor = document.getElementById('right-sponsor');
        const topSponsor = document.getElementById('top-sponsor');
        const bottomSponsor = document.getElementById('bottom-sponsor');

        const fireworks = new Fireworks.default(fireworkContainer, {
            autoresize: true,
            opacity: 0.5,
            acceleration: 1.0,
            friction: 0.97,
            gravity: 1.5,
            particles: 50,
            traceLength: 3,
            traceSpeed: 10,
            explosion: 5,
            intensity: 100,
            flickering: 50,
            lineStyle: 'square',
            hue: {
                min: 0,
                max: 360
            },
            rocketsPoint: {
                min: 50,
                max: 50
            },
            lineWidth: {
                explosion: {
                    min: 8,
                    max: 8
                },
                trace: {
                    min: 8,
                    max: 8
                }
            },
            brightness: {
                min: 50,
                max: 80
            },
            decay: {
                min: 0.03,
                max: 0.04
            },
            mouse: {
                click: false,
                move: false,
                max: 1
            }
        });

        const aspectRatio = 3 / 4;

        const game = {
            hasScheduledReset: false,
            playerScore: 0,
            vicenteScore: 0,
            scale: 1,
            prevScale: 1,
            middle: {
                x: canvas.width / 2,
                y: canvas.height / 2
            },
            setMiddle: function () {
                this.middle.x = canvas.width / 2;
                this.middle.y = canvas.height / 2;
            }
        }

        const field = {
            img: new Image(),
            w: 0,
            h: 0,
            init: function () {
                this.w = this.img.width;
                this.h = this.img.height;
            },
            scale: function () {
                this.w = this.img.width * game.scale;
                this.h = this.img.height * game.scale;
            }
        }

        const goal = {
            //redundante pero útil
            rightBottomBorder: 1630,
            leftBottomBorder: 100,
            rightTopBorder: 1770,
            leftTopBorder: 240,
            bottomBorder: 640 + 280,
            topBorder: 70 + 280,
            polygon: [],
            scale: function () {
                this.polygon = [
                    { x: this.leftTopBorder * game.scale, y: this.topBorder * game.scale },
                    { x: this.leftBottomBorder * game.scale, y: this.bottomBorder * game.scale },
                    { x: this.rightTopBorder * game.scale, y: this.bottomBorder * game.scale },
                    { x: this.rightBottomBorder * game.scale, y: this.topBorder * game.scale }
                ];
            },
            isBallInPolygon: function (ball) {
                const pointsToCheck = [
                    { x: ball.middlePoint.x + ball.radius, y: ball.middlePoint.y },
                    { x: ball.middlePoint.x - ball.radius, y: ball.middlePoint.y },
                    { x: ball.middlePoint.x, y: ball.middlePoint.y + ball.radius },
                    { x: ball.middlePoint.x, y: ball.middlePoint.y - ball.radius },
                ];

                return pointsToCheck.every(p => this.pointInPolygon(p.x, p.y, this.polygon));
            },
            pointInPolygon: function (x, y, polygon) {
                let inside = false;
                for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
                    const xi = polygon[i].x, yi = polygon[i].y;
                    const xj = polygon[j].x, yj = polygon[j].y;
                    const intersect = ((yi > y) !== (yj > y)) &&
                        (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                    if (intersect) inside = !inside;
                }
                return inside;
            }
        };

        const vicente = {
            img: new Image(),
            x: 0,
            y: 0,
            w: 0,
            h: 0,
            toppos: 380,
            shotsData: [],
            prediction: 0,
            reachedPrediction: false,
            startingSpeed: 8,
            speed: 8,
            init: function () {
                this.w = this.img.width;
                this.h = this.img.height;
                const goalLeft = goal.leftBottomBorder * game.scale;
                const goalRight = goal.rightBottomBorder * game.scale;
                this.x = (goalLeft + goalRight) / 2 - this.w / 2;
                this.y = this.toppos * game.scale;
                this.prediction = this.x + this.w / 2;
            },
            scale: function () {
                this.w = this.img.width * game.scale;
                this.h = this.img.height * game.scale;
                this.y = this.toppos * game.scale;

                this.x = this.x * game.scale / game.prevScale;
                this.startingSpeed = this.startingSpeed * game.scale / game.prevScale;
                this.speed = this.speed * game.scale / game.prevScale;

                if (this.shotsData.length > 0) {
                    this.shotsData = this.shotsData.map(shot => shot * game.scale / game.prevScale);
                    this.prediction = this.prediction * game.scale / game.prevScale;
                } else {
                    this.prediction = this.x + this.w / 2;
                }
            },
            reset: function () {
                this.reachedPrediction = false;
                this.speed = this.startingSpeed + (game.playerScore - game.vicenteScore) * 0.25;
            },
            predict: function () {
                let mood = Math.random();

                if (mood < 0.5) { //make prediction the exact opposite of ball.predictedShot[0]
                    this.prediction = ((ball.predictedShot[0] - game.middle.x) * -1) + game.middle.x;
                } else {
                    this.prediction = ball.predictedShot[0] + (Math.random() - 0.5) * 50;
                }

                this.prediction = clamp(this.prediction, (goal.leftTopBorder + vicente.w / 2) * game.scale, (goal.rightTopBorder - vicente.w / 2) * game.scale);
            }
        };

        const ball = {
            img: new Image(),
            x: 0,
            y: 0,
            w: 0,
            h: 0,
            rotation: 0,
            radius: 0,
            initialY: 1500,
            middlePoint: {
                x: 0,
                y: 0
            },
            isDoneMoving: false,
            isMoving: false,
            speedNdir: [0, 0],
            predictedShot: [0, 0],
            optimalDistance: 35,
            init: function () {
                this.w = this.img.width;
                this.h = this.img.height;
                this.radius = this.img.width / 2;
                this.reset();
            },
            scale: function () {
                this.w = this.img.width * game.scale;
                this.h = this.img.height * game.scale;
                this.radius = (this.img.width / 2) * game.scale;

                this.x = this.x * game.scale / game.prevScale;
                this.y = this.y * game.scale / game.prevScale;
                this.speedNdir[0] *= game.scale / game.prevScale;
                this.speedNdir[1] *= game.scale / game.prevScale;
                this.predictedShot[0] *= game.scale / game.prevScale;
                this.predictedShot[1] *= game.scale / game.prevScale;
                this.optimalDistance *= game.scale / game.prevScale;

                this.middlePoint.x = this.x + this.w / 2;
                this.middlePoint.y = this.y + this.h / 2;

                this.initialY *= game.scale / game.prevScale;
            },
            reset: function () {
                this.x = game.middle.x - this.w / 2;
                this.y = this.initialY;
                this.middlePoint.x = this.x + this.w / 2;
                this.middlePoint.y = this.y + this.h / 2;
                this.isDoneMoving = false;
                this.isMoving = false;
                this.speedNdir = [0, 0];
                this.predictedShot = [game.middle.x, game.middle.y];
            },
            calculateSpeed: function (e) {
                const rect = canvas.getBoundingClientRect();
                mouse.x = e.clientX - rect.left;
                mouse.y = e.clientY - rect.top;
                this.x = mouse.x - this.radius;
                this.y = mouse.y - this.radius;
                this.middlePoint.x = this.x + this.w / 2;
                this.middlePoint.y = this.y + this.h / 2;

                this.speedNdir = [(game.middle.x - mouse.x) * 0.05, (ball.initialY - mouse.y) * 0.05];

                let predictionMultiplier = 50;
                this.predictedShot = [
                    this.middlePoint.x + this.speedNdir[0] * predictionMultiplier,
                    this.middlePoint.y + this.speedNdir[1] * predictionMultiplier
                ];
            },
            calculateSpeedFromPos: function (inputX, inputY) {
                this.x = inputX - this.radius;
                this.y = inputY - this.radius;
                this.middlePoint.x = this.x + this.w / 2;
                this.middlePoint.y = this.y + this.h / 2;

                // Aumentamos un poco la sensibilidad para móviles (0.07 en lugar de 0.05)
                const sensitivity = 0.06;
                this.speedNdir = [(game.middle.x - inputX) * sensitivity, (this.initialY - inputY) * sensitivity];

                let predictionMultiplier = 50;
                this.predictedShot = [
                    this.middlePoint.x + this.speedNdir[0] * predictionMultiplier,
                    this.middlePoint.y + this.speedNdir[1] * predictionMultiplier
                ];
            }
        };

        let pixCanvas;
        const mouse = { x: 0, y: 0, isDown: false };

        function isPixelOverlap(img1, x, y, w, h, img2, x1, y1, w1, h1) {
            const ax = Math.max(x, x1);
            const ay = Math.max(y, y1);
            const aw = Math.min(x + w, x1 + w1) - ax;
            const ah = Math.min(y + h, y1 + h1) - ay;

            if (aw <= 0 || ah <= 0) return false;

            if (!pixCanvas) pixCanvas = document.createElement("canvas");
            pixCanvas.width = aw;
            pixCanvas.height = ah;

            const pixCtx = pixCanvas.getContext("2d", { willReadFrequently: true });
            pixCtx.clearRect(0, 0, aw, ah);
            pixCtx.drawImage(img1, x - ax, y - ay, w, h);
            pixCtx.globalCompositeOperation = "destination-in";
            pixCtx.drawImage(img2, x1 - ax, y1 - ay, w1, h1);
            pixCtx.globalCompositeOperation = "source-over";

            try {
                const imageData = new Uint32Array(pixCtx.getImageData(0, 0, aw, ah).data.buffer);
                return imageData.some(val => val !== 0);
            } catch (e) {
                console.error("getImageData error:", e);
                return false;
            }
        }

        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(field.img, 0, 0, field.w, field.h);

            if (!ball.isMoving && !ball.isDoneMoving) {
                let time = Date.now() * 0.002; // Linear time progression
                let rainbowOffset = (-time * 0.5) % 1; // Negative for reverse flow
                if (rainbowOffset < 0) rainbowOffset += 1; // Keep it positive (0-1 range)

                let gradient = ctx.createRadialGradient(game.middle.x, ball.initialY, 0, ball.middlePoint.x, ball.middlePoint.y, 50 * game.scale);

                let spread = 0.1; // How wide each green line is
                let numLines = 4; // Number of green lines
                let spacing = 1 / numLines; // Space them evenly

                // Start with white background
                gradient.addColorStop(0, `rgba(50, 100, 50, 1)`);

                // Create multiple green lines
                for (let i = 0; i < numLines; i++) {
                    let center = (i * spacing + rainbowOffset) % 1;
                    // Add green line at this position
                    gradient.addColorStop(Math.max(0, center - spread), `rgba(50, 100, 50, 1)`);
                    //get the vector length of speed n dir
                    let difference = Math.abs(Math.hypot(ball.speedNdir[0], ball.speedNdir[1]) - ball.optimalDistance) / 10;
                    gradient.addColorStop(center, `rgba(${difference * 255}, ${(1 - difference) * 255}, 0, 1)`);
                    gradient.addColorStop(Math.min(1, center + spread), `rgba(50, 100, 50, 1)`);
                }

                gradient.addColorStop(1, `rgba(50, 100, 50, 1)`);

                ctx.strokeStyle = gradient;
                ctx.lineWidth = 100 * game.scale;
                ctx.beginPath();
                ctx.moveTo(game.middle.x, ball.initialY);
                ctx.lineTo(ball.middlePoint.x, ball.middlePoint.y);
                ctx.stroke();
            }

            //draw images
            ctx.drawImage(vicente.img, vicente.x, vicente.y, vicente.w, vicente.h);

            //draw ball with rotation
            ctx.save();
            ctx.translate(ball.middlePoint.x, ball.middlePoint.y);
            ctx.rotate(ball.rotation);
            ctx.drawImage(ball.img, -ball.w / 2, -ball.h / 2, ball.w, ball.h);
            ctx.restore();

            if (ball.isMoving) {
                ball.x += ball.speedNdir[0];
                ball.y += ball.speedNdir[1];
                ball.middlePoint.x = ball.x + ball.w / 2;
                ball.middlePoint.y = ball.y + ball.h / 2;
                ball.speedNdir[0] *= 0.98;
                ball.speedNdir[1] *= 0.98;
                ball.rotation += 0.05;

                if (Math.abs(ball.speedNdir[0]) < 0.1 && Math.abs(ball.speedNdir[1]) < 0.1) {
                    ball.isMoving = false;
                    ball.isDoneMoving = true;
                }

                const vicenteCenter = vicente.x + vicente.w / 2;
                const targetX = vicente.reachedPrediction ? ball.x + ball.w / 2 : vicente.prediction;
                const dx = targetX - vicenteCenter;

                if (Math.abs(dx) > 2) {
                    vicente.x += Math.sign(dx) * vicente.speed;
                    vicente.speed *= 0.99; // Gradual slowdown
                } else if (!vicente.reachedPrediction) {
                    vicente.reachedPrediction = true;
                }

                //const goalLeft = goal.leftBottomBorder * game.scale;
                //const goalRight = goal.rightBottomBorder * game.scale;
                //vicente.x = Math.max(goalLeft, Math.min(goalRight - vicente.w, vicente.x));
            }

            if (ball.isDoneMoving && !game.hasScheduledReset) {
                game.hasScheduledReset = true;

                const overlap = isPixelOverlap(
                    vicente.img, vicente.x, vicente.y, vicente.w, vicente.h,
                    ball.img, ball.x, ball.y, ball.w, ball.h
                );

                if (overlap) {
                    msg.textContent = "¡VICENTE!";
                    game.vicenteScore++;
                } else if (goal.isBallInPolygon(ball)) {
                    msg.textContent = "¡GOL!";
                    fireworks.launch(5);
                    game.playerScore++;
                } else {
                    msg.textContent = "¡FUERA!";
                }
                score.textContent = `${game.playerScore}-${game.vicenteScore}`;

                setTimeout(() => {
                    game.hasScheduledReset = false;
                    msg.textContent = "";
                    vicente.reset();
                    ball.reset();
                }, 1000);
            }
        }

        function loop() {
            draw();
            requestAnimationFrame(loop);
        }

        canvas.addEventListener("mousemove", e => {
            if (!mouse.isDown || ball.isMoving || ball.isDoneMoving) return;
            ball.calculateSpeed(e);
        });

        canvas.addEventListener("mousedown", e => {
            if (ball.isMoving || ball.isDoneMoving) return;
            if (e.button === 0) {
                mouse.isDown = true;
                ball.calculateSpeed(e);
            }
        });

        canvas.addEventListener("mouseup", () => {
            if (ball.isMoving || ball.isDoneMoving) return;
            mouse.isDown = false;
            ball.isMoving = true;
            vicente.predict();
        });

        function resizeCanvas() {
            let width = window.innerWidth;
            let height = window.innerHeight;

            if (width / height < .87) {
                leftSponsor.style.display = 'none';
                rightSponsor.style.display = 'none';
            } else {
                leftSponsor.style.display = 'block';
                rightSponsor.style.display = 'block';
            }

            if (width / height > .70) {
                topSponsor.style.display = 'none';
                bottomSponsor.style.display = 'none';
            } else {
                topSponsor.style.display = 'block';
                bottomSponsor.style.display = 'block';
            }

            if (width / height > aspectRatio) {
                width = height * aspectRatio;
            } else {
                height = width / aspectRatio;
            }

            canvas.width = width;
            canvas.height = height;
            game.prevScale = game.scale;
            game.scale = canvas.width / field.img.width;
            game.setMiddle();
            field.scale();
            goal.scale();
            ball.scale();
            vicente.scale();
            draw();

            const canvasRect = canvas.getBoundingClientRect();

            fireworkContainer.style.left = canvasRect.left + 'px';
            fireworkContainer.style.top = canvasRect.top + 'px';
            fireworkContainer.style.width = canvasRect.width + 'px';
            fireworkContainer.style.height = canvasRect.height + 'px';
            hud.style.left = canvasRect.left + 'px';
            hud.style.top = canvasRect.top + 'px';
            hud.style.width = canvasRect.width + 'px';
            hud.style.height = canvasRect.height + 'px';
        }

        window.addEventListener("resize", resizeCanvas);

        async function loadSVGImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }

        async function init() {
            await loadSVGImage("/assets/eastereggs/visentemetegol/images/Cancha_v2.png").then(img => {
                field.img = img;
                field.init();
            });
            await loadSVGImage("/assets/eastereggs/visentemetegol/images/Bisonte_v3.svg").then(img => {
                vicente.img = img;
            });
            await loadSVGImage("/assets/eastereggs/visentemetegol/images/Pelota_v1.svg").then(img => {
                ball.img = img;
            });

            vicente.init();
            ball.init();
            resizeCanvas();
            fireworks.updateSize();

            ball.reset();
            vicente.reset();
            loop();
        }

        init();


        function getPointerPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        const handleStart = (e) => {
            if (ball.isMoving || ball.isDoneMoving) return;
            mouse.isDown = true;
            const pos = getPointerPos(e);
            // Usamos las coordenadas corregidas
            ball.calculateSpeedFromPos(pos.x, pos.y);
        };

        // 2. MOVIMIENTO
        const handleMove = (e) => {
            if (!mouse.isDown || ball.isMoving || ball.isDoneMoving) return;
            const pos = getPointerPos(e);
            ball.calculateSpeedFromPos(pos.x, pos.y);
            if (e.cancelable) e.preventDefault(); // Evita que la página se mueva
        };

        // 3. SOLTAR
        const handleEnd = () => {
            if (ball.isMoving || ball.isDoneMoving || !mouse.isDown) return;
            mouse.isDown = false;
            ball.isMoving = true;
            vicente.predict();
        };

        canvas.addEventListener("mousedown", handleStart);
        canvas.addEventListener("touchstart", handleStart, { passive: false });

        window.addEventListener("mousemove", handleMove);
        canvas.addEventListener("touchmove", handleMove, { passive: false });

        window.addEventListener("mouseup", handleEnd);
        canvas.addEventListener("touchend", handleEnd);
    </script>
    <x-easter-eggs.info-button />
</body>

</html>