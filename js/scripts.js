document.addEventListener('DOMContentLoaded', () => {
    const toggleSwitch = document.querySelector('#checkbox');
    const body = document.body;
    const modeLabel = document.querySelector('#mode-label');

    // Verifica se os elementos existem antes de adicionar o evento
    if (toggleSwitch) {
        toggleSwitch.addEventListener('change', (e) => {
            if (e.target.checked) {
                body.classList.add('dark-theme');
                modeLabel.textContent = "Modo Claro";
            } else {
                body.classList.remove('dark-theme');
                modeLabel.textContent = "Modo Escuro";
            }
        });
    }
});
// O bloco abaixo verifica a opção do tema selecionado pelo usuário, salvando no navegador.
document.addEventListener('DOMContentLoaded', () => {
    // 1. Seleciona o checkbox do switch de tema
    const toggleSwitch = document.getElementById('checkbox');
    const modeLabel = document.getElementById('mode-label'); // Opcional: para mudar o texto

    // 2. Verifica se já existe um tema salvo no localStorage
    const currentTheme = localStorage.getItem('theme');

    // 3. Se houver um tema salvo, aplica ele na página
    if (currentTheme) {
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            toggleSwitch.checked = true; // Mantém o switch marcado
            // modeLabel.textContent = 'Modo Claro'; // Descomente se quiser alternar o texto
        }
    }

    // 4. Função que roda toda vez que o usuário clica no switch
    function switchTheme(e) {
        if (e.target.checked) {
            // Ativa o modo escuro
            document.body.classList.add('dark-theme');
            // Salva no localStorage
            localStorage.setItem('theme', 'dark');
            // modeLabel.textContent = 'Modo Claro';
        } else {
            // Desativa o modo escuro
            document.body.classList.remove('dark-theme');
            // Salva no localStorage
            localStorage.setItem('theme', 'light');
            // modeLabel.textContent = 'Modo Escuro';
        }
    }

    // 5. Adiciona o ouvinte de evento no checkbox
    toggleSwitch.addEventListener('change', switchTheme);
});

// Mascara do telefone

const inputCelular = document.getElementById('telefone');

inputCelular.addEventListener('input', (e) => {
    let valor = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
    
    // Limita a quantidade de dígitos
    if (valor.length > 11) valor = valor.slice(0, 11);

    // Formata a máscara
    if (valor.length > 6) {
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    } else if (valor.length > 2) {
        valor = valor.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
    } else if (valor.length > 0) {
        valor = valor.replace(/^(\d*)$/, '($1');
    }

    e.target.value = valor;
});