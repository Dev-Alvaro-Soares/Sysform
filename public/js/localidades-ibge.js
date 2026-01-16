/**
 * Autocomplete de Municípios do Pará usando API do IBGE
 * @description Busca e filtra municípios em tempo real com seleção múltipla
 */

document.addEventListener('DOMContentLoaded', () => {
    // Variáveis globais
    let municipiosPara = [];
    let municipiosSelecionados = [];  // Array para armazenar municípios selecionados
    const inputLocalidade = document.getElementById('localidade');
    const suggestionsBox = document.getElementById('localidade-suggestions');

    // Verifica se os elementos existem na página
    if (!inputLocalidade || !suggestionsBox) {
        return; // Sai se não encontrar os elementos
    }

    // 1. BUSCAR municípios da API do IBGE quando a página carregar
    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados/15/municipios')
        .then(response => response.json())  // Converte resposta para JSON
        .then(data => {
            // Guardar lista de municípios na memória
            municipiosPara = data.map(m => m.nome).sort();
            console.log(`${municipiosPara.length} municípios do PA carregados`);
        })
        .catch(error => {
            console.error('Erro ao buscar municípios:', error);
        });

    // Função para atualizar o campo com municípios selecionados
    function atualizarCampo() {
        if (municipiosSelecionados.length > 0) {
            inputLocalidade.value = municipiosSelecionados.join(', ') + ', ';
        } else {
            inputLocalidade.value = '';
        }
    }

    // 2. FILTRAR e MOSTRAR sugestões quando usuário digita
    inputLocalidade.addEventListener('input', function() {
        // Pega apenas o último termo digitado (após a última vírgula)
        const valorCompleto = this.value;
        const partes = valorCompleto.split(',').map(p => p.trim()).filter(p => p.length > 0);
        
        // Atualiza array de selecionados (remove o último se estiver digitando)
        municipiosSelecionados = partes.slice(0, -1);
        const ultimoTermo = partes[partes.length - 1] || '';
        
        suggestionsBox.innerHTML = '';  // Limpa sugestões antigas

        if (ultimoTermo.length < 2) {  // Só busca com 2+ caracteres
            suggestionsBox.style.display = 'none';
            return;
        }

        // Filtrar municípios que começam com o termo digitado e que não foram selecionados ainda
        const resultados = municipiosPara.filter(m => 
            m.toLowerCase().startsWith(ultimoTermo.toLowerCase()) && 
            !municipiosSelecionados.includes(m)
        ).slice(0, 8);  // Limita a 8 resultados

        if (resultados.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        // Mostrar resultados
        resultados.forEach(municipio => {
            const item = document.createElement('div');
            item.classList.add('autocomplete-item');
            item.textContent = municipio;
            
            // Ao clicar, adiciona ao array de selecionados
            item.addEventListener('click', (e) => {
                e.preventDefault();
                municipiosSelecionados.push(municipio);
                atualizarCampo();
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
                inputLocalidade.focus();  // Mantém foco no campo
            });

            suggestionsBox.appendChild(item);
        });

        suggestionsBox.style.display = 'block';
    });

    // 3. Permitir remover municípios usando Backspace no campo vazio
    inputLocalidade.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && this.value.endsWith(', ')) {
            // Remove o último município selecionado
            municipiosSelecionados.pop();
            atualizarCampo();
            e.preventDefault();
        }
    });

    // 4. FECHAR sugestões ao clicar fora
    document.addEventListener('click', (e) => {
        if (!inputLocalidade.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });
});
