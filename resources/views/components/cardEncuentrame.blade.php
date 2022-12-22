<div class="adopcion">
    <div class="img">
        <img src="{{ asset("storage/$imagen") }}" alt="">
        <div class="descrip">
            <h2>{{ $mascota }}</h2>
        </div>
    </div>
    <div class="more"><a href="#popup" style="text-decoration: none; color: #fff;">Mas Informacion</a></div>
</div>
<div class="contenedor-modal" id=popup>
    <div class="moda">
        <div class="informacion">
            <img src="{{ asset("storage/$imagen") }}" alt="Adopta">
            <div class="descripcion">
                <div class="cont">
                    <p>Nombre:</p>
                    <p>(nombre)</p>
                </div>
                <div class="cont">
                    <p>Especie:</p>
                    <p>(especie)</p>
                </div>
                <div class="cont">
                    <p>Raza:</p>
                    <p>(raza)</p>
                </div>
                <div class="cont">
                    <p>Color:</p>
                    <p>(color)</p>
                </div>
                <div class="cont">
                    <p>Edad:</p>
                    <p>(edad)</p>
                </div>
                <div class="cont">
                    <p>Tamaño:</p>
                    <p>(tamaño)</p>
                </div>
            </div>
            <div class="tener-en-cuenta">
                <h4>Descripcion:</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita quibusdam ducimus reprehenderit. Deserunt dolor soluta sapiente, voluptates porro qui debitis, quis dicta praesentium quo fuga facere vero non nihil quam!</p>
            </div>
        </div>
        <a href="#" class="btn-close-modal">X</a>
    </div>
</div>
