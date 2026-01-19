
// FUNÇÃO AUXILIAR - escapar HTML
function htmlEscape(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Array em memória para equipe
const equipeMilitar = [];

// ========== INTERCEPTAR ENVIO DO FORMULÁRIO PRINCIPAL ==========
document.addEventListener('DOMContentLoaded', () => {
    console.log('[ESCOLTA] Script carregado');
    
    const form = document.getElementById('solicitacaoForm');
    console.log('[ESCOLTA] Formulário encontrado:', !!form);
    
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('[ESCOLTA] Evento submit disparado');
            e.preventDefault();
            e.stopPropagation();
            
            const formData = new FormData(form);
            const action = form.getAttribute('action');
            console.log('[ESCOLTA] Action:', action);

            // Serializar equipe e anexar ao FormData
            if (equipeMilitar.length > 0) {
                const equipeJson = JSON.stringify(equipeMilitar);
                formData.append('equipe_militar_json', equipeJson);
                console.log('[ESCOLTA] Equipe adicionada ao FormData:', equipeJson);
            }
            
            fetch(action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('[ESCOLTA] Resposta recebida, status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('[ESCOLTA] JSON recebido:', data);
                
                if (data.success === true) {
                    console.log('[ESCOLTA] Sucesso confirmado - abrindo modal');
                    
                    const successModalElement = document.getElementById('successModal');
                    console.log('[ESCOLTA] Modal elemento encontrado:', !!successModalElement);
                    
                    if (successModalElement && typeof bootstrap !== 'undefined') {
                        try {
                            const modal = new bootstrap.Modal(successModalElement);
                            modal.show();
                            console.log('[ESCOLTA] Modal exibido com sucesso');
                            form.reset();
                            equipeMilitar.length = 0; // limpar array
                            const tbody = document.getElementById('tabelaEquipeBody');
                            if (tbody) tbody.innerHTML = '';
                        } catch (err) {
                            console.error('[ESCOLTA] Erro ao exibir modal:', err);
                            alert('Solicitação enviada com sucesso!');
                        }
                    } else {
                        console.error('[ESCOLTA] Modal não encontrado ou Bootstrap indisponível');
                        alert('Solicitação enviada com sucesso!');
                    }
                } else {
                    console.log('[ESCOLTA] Resposta indicou erro:', data);
                    
                    const errorModalElement = document.getElementById('errorModal');
                    const errorBody = document.getElementById('errorModalBody');
                    
                    if (errorBody && data.errors) {
                        errorBody.innerHTML = data.errors.map(e => `<li>${htmlEscape(e)}</li>`).join('');
                    }
                    
                    if (errorModalElement && typeof bootstrap !== 'undefined') {
                        try {
                            const modal = new bootstrap.Modal(errorModalElement);
                            modal.show();
                        } catch (err) {
                            console.error('[ESCOLTA] Erro ao exibir modal de erro:', err);
                            alert('Erro: ' + (data.errors ? data.errors[0] : 'Desconhecido'));
                        }
                    }
                }
            })
            .catch(error => {
                console.error('[ESCOLTA] Erro no fetch:', error);
                alert('Erro ao enviar: ' + error.message);
            });
        }, false);
    }
    
    // Modal de instruções
    const instrucoes = document.getElementById('modal_01');
    if (instrucoes) {
        const modal = new bootstrap.Modal(instrucoes);
        modal.show();
    }
});

// ========== FUNCIONALIDADES DA EQUIPE MILITAR ==========
(() => {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('formEquipeMilitar');
        const tabelaBody = document.getElementById('tabelaEquipeBody');
        const modalElement = document.getElementById('modalEquipeMilitar');
        const modalInstance = modalElement ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;

        if (!form || !tabelaBody) {
            return;
        }

        const selectPatente = document.getElementById('selectPatente');
        const inputNome = document.getElementById('inputNomeMilitar');
        const inputFuncao = document.getElementById('inputFuncaoMissao');

        const obterPatente = () => {
            if (!selectPatente) return '';
            const value = selectPatente.value.trim();
            if (value) return value;
            const option = selectPatente.selectedOptions && selectPatente.selectedOptions[0];
            return option ? option.textContent.trim() : '';
        };

        const limparFormulario = () => {
            form.reset();
            if (selectPatente) {
                selectPatente.selectedIndex = 0;
            }
        };

        const criarCelulaTexto = (texto) => {
            const td = document.createElement('td');
            td.classList.add('align-middle');
            td.textContent = texto;
            return td;
        };

        const criarCelulaAcao = () => {
            const td = document.createElement('td');
            td.classList.add('align-middle');

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-link text-danger p-0 btn-remover';
            btn.setAttribute('aria-label', 'Remover');
            btn.setAttribute('data-bs-toggle', 'tooltip');
            btn.setAttribute('data-bs-title', 'Excluir entrada');
            btn.innerHTML = '<i class="bi bi-trash-fill"></i>';

            td.appendChild(btn);
            return td;
        };

        const adicionarLinha = ({ patente, nome, funcao }) => {
            const tr = document.createElement('tr');
            tr.appendChild(criarCelulaTexto(patente));
            tr.appendChild(criarCelulaTexto(nome));
            tr.appendChild(criarCelulaTexto(funcao));
            const celulaAcao = criarCelulaAcao();
            tr.appendChild(celulaAcao);
            tabelaBody.appendChild(tr);

            const btn = celulaAcao.querySelector('.btn-remover');
            if (btn) {
                new bootstrap.Tooltip(btn);
            }
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const patente = obterPatente();
            const nome = inputNome ? inputNome.value.trim() : '';
            const funcao = inputFuncao ? inputFuncao.value.trim() : '';

            if (!patente || !nome || !funcao) {
                form.reportValidity && form.reportValidity();
                return;
            }

            equipeMilitar.push({ patente, nome, funcao });
            adicionarLinha({ patente, nome, funcao });
            limparFormulario();

            if (modalInstance) {
                modalInstance.hide();
            }
        });

        tabelaBody.addEventListener('click', (event) => {
            const botao = event.target.closest('.btn-remover');
            if (!botao) {
                return;
            }

            const linha = botao.closest('tr');
            if (linha) {
                const tooltip = bootstrap.Tooltip.getInstance(botao);
                if (tooltip) {
                    tooltip.dispose();
                }
                // remover do array pela posição atual da linha
                const index = Array.from(tabelaBody.children).indexOf(linha);
                if (index >= 0) {
                    equipeMilitar.splice(index, 1);
                }
                linha.remove();
            }
        });
    });
})();
