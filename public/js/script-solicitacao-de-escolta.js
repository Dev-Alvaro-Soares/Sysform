// JS para funcionalidades da solicitação de escolta

(() => {
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

		// Inicializar tooltip para o novo botão
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
			// Destruir tooltip antes de remover a linha
			const tooltip = bootstrap.Tooltip.getInstance(botao);
			if (tooltip) {
				tooltip.dispose();
			}
			linha.remove();
		}
	});
})();
