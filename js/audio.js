const botao = document.getElementById("botaoPlayPause");

botao.addEventListener("click", funcaoPlayPause);
botao.addEventListener("click", outraFuncaoQualquer);

function alternarAudio() {
    const audio = document.getElementById('player');
    const icone = document.getElementById('icone-audio');

    if (audio.paused) {
        // Se estiver pausado: toca o áudio e muda o ícone para "volume alto" (ou pausa)
        audio.play();
        icone.classList.remove('fa-volume-xmark'); // ou 'fa-pause'
        icone.classList.add('fa-volume-high');
    } else {
        // Se estiver tocando: pausa o áudio e muda o ícone para "mutado/desativado"
        audio.pause();
        icone.classList.remove('fa-volume-high');
        icone.classList.add('fa-volume-xmark'); // você também pode usar 'fa-volume-off' ou 'fa-pause'
    }
}

// Opcional: Quando o áudio terminar sozinho, volta o ícone para o estado pausado
document.getElementById('player').addEventListener('ended', function() {
    const icone = document.getElementById('icone-audio');
    icone.classList.remove('fa-volume-high');
    icone.classList.add('fa-volume-xmark');
});