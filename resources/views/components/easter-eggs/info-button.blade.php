<div class="easter-egg-info-btn-wrapper">
    <button id="easterEggInfoBtn" class="easter-egg-btn">?</button>
</div>

<div id="easterEggInfoModal" class="easter-egg-modal">
    <div class="easter-egg-modal-content">
        <span class="easter-egg-close">&times;</span>
        <h2>¡Felicidades!</h2>
        <p>¡Has encontrado un Easter Egg!</p>
        <p>Comunícate con el departamento de multimedia o manda un mensaje al Instagram de la <strong>Expo LMAD</strong> para validar que encontraste este secreto.</p>
        <a href="https://www.instagram.com/expolmad/" target="_blank" class="instagram-link">Ir al Instagram</a>
    </div>
</div>

<style>
    .easter-egg-info-btn-wrapper {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    .easter-egg-btn {
        background-color: #ffcc00;
        color: #000;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s, background-color 0.2s;
        font-family: sans-serif;
    }

    .easter-egg-btn:hover {
        transform: scale(1.1);
        background-color: #ffdb4d;
    }

    .easter-egg-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(5px);
    }

    .easter-egg-modal-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        color: #333;
        font-family: 'Inter', sans-serif;
    }

    .easter-egg-modal-content h2 {
        margin-top: 0;
        color: #e1306c;
    }

    .easter-egg-close {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .easter-egg-close:hover,
    .easter-egg-close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .instagram-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        transition: opacity 0.2s;
    }

    .instagram-link:hover {
        opacity: 0.9;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById("easterEggInfoModal");
        var btn = document.getElementById("easterEggInfoBtn");
        var span = document.getElementsByClassName("easter-egg-close")[0];

        if (btn && modal && span) {
            btn.onclick = function() {
                modal.style.display = "flex";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    });
</script>