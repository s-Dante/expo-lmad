<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Easter Egg - Delfín</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        canvas {
            display: block;
        }

        #ui-container {
            position: absolute;
            top: 10%;
            width: 100%;
            text-align: center;
            z-index: 10;
            pointer-events: none;
        }

        h1 {
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            animation: float 3s ease-in-out infinite;
        }

        p#phrase {
            font-size: 1.2rem;
            margin-top: 10px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>

    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
            }
        }
    </script>
</head>

<body>
    <div id="ui-container">
        <h1>¡Has encontrado al delfín!</h1>
        <p id="phrase"></p>
    </div>

    <script>
        const phrases = [
            "Un delfín siempre encuentra su camino en el océano digital.",
            "Sigue nadando, el código se compilará.",
            "El mar de posibilidades es infinito.",
            "Este es tu premio por explorar.",
            "¡Felicidades, encontraste el delfín místico!",
            "¿Sabías que los delfines también disfrutan de la Expo LMAD?",
            "El conocimiento es profundo como el mar."
        ];
        document.getElementById('phrase').innerText = phrases[Math.floor(Math.random() * phrases.length)];
    </script>

    <script type="module">
        import * as THREE from 'three';
        import {
            GLTFLoader
        } from 'three/addons/loaders/GLTFLoader.js';

        const scene = new THREE.Scene();
        // Cámara ligeramente en picado, centrada
        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0, 1.5, 6);
        camera.lookAt(0, 0, 0);

        const renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        document.body.appendChild(renderer.domElement);

        const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
        scene.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 2);
        directionalLight.position.set(5, 5, 5);
        scene.add(directionalLight);

        const gltfLoader = new GLTFLoader();

        let mixers = [];
        let modelsToRotate = [];

        // 1. MODELO PRINCIPAL (Cuerpo sólido del delfín)
        gltfLoader.load('{{ asset("assets/eastereggs/delfin/dolphin.glb") }}', function(gltf) {
            let model = gltf.scene;

            // Forzamos al modelo a verse sólido para arreglar la transparencia de los ojos/boca
            model.traverse(function(child) {
                if (child.isMesh && child.material) {
                    child.material.depthWrite = true;
                    if (child.material.transparent) {
                        child.material.alphaTest = 0.5; // Elimina las partes difuminadas (como las gotas)
                    }
                }
            });

            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            model.position.sub(center);

            const groupDolphin = new THREE.Group();
            groupDolphin.add(model);
            scene.add(groupDolphin);

            const size = box.getSize(new THREE.Vector3()).length();
            const scale = 5 / size;
            groupDolphin.scale.set(scale, scale, scale);

            if (gltf.animations && gltf.animations.length) {
                let mixer = new THREE.AnimationMixer(model);
                mixer.clipAction(gltf.animations[0]).play();
                mixers.push(mixer);
            }
            modelsToRotate.push(groupDolphin);
        }, undefined, function(error) {
            console.error('Error loading main dolphin:', error);
        });

        // 2. MODELO DE GOTITAS (Solo agua)
        // Puedes comentar o eliminar todo este bloque si te piden quitar las gotas.
        gltfLoader.load('{{ asset("assets/eastereggs/delfin/dolphin.glb") }}', function(gltf) {
            let model = gltf.scene;

            model.traverse(function(child) {
                if (child.isMesh && child.material) {
                    // Dejamos las transparencias originales, pero deshabilitamos la escritura en profundidad 
                    // para que no haya conflicto (z-fighting) con el cuerpo sólido.
                    child.material.depthWrite = false;

                    // Opcional: si sabes el nombre de la malla de agua, podrías hacer algo como:
                    // if(child.name !== "Water") child.visible = false;
                }
            });

            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            model.position.sub(center);

            const groupDrops = new THREE.Group();
            groupDrops.add(model);
            scene.add(groupDrops);

            const size = box.getSize(new THREE.Vector3()).length();
            const scale = 5 / size;
            groupDrops.scale.set(scale, scale, scale);

            if (gltf.animations && gltf.animations.length) {
                let mixer = new THREE.AnimationMixer(model);
                mixer.clipAction(gltf.animations[0]).play();
                mixers.push(mixer);
            }
            modelsToRotate.push(groupDrops);
        }, undefined, function(error) {
            console.error('Error loading droplets:', error);
        });

        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame(animate);
            const delta = clock.getDelta();

            mixers.forEach(m => m.update(delta));
            modelsToRotate.forEach(m => {
                m.rotation.y += 0.8 * delta;
            });

            renderer.render(scene, camera);
        }

        animate();

        window.addEventListener('resize', onWindowResize, false);

        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }
    </script>

    <x-easter-eggs.info-button />
</body>

</html>