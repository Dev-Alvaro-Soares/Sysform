/**
 * Gerenciador de Escolta - Frontend
 * Busca dados da API e popula a tabela
 */

document.addEventListener('DOMContentLoaded', function() {
    carregarEscolta();
});

function carregarEscolta() {
    fetch('api/escolta.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                preencherTabelaEscolta(data.data);
            } else {
                console.error('Erro ao carregar dados:', data.error);
                mostrarErroEscolta('Erro ao carregar dados: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            mostrarErroEscolta('Erro ao conectar com o servidor: ' + error.message);
        });
}

function preencherTabelaEscolta(dados) {
    const tbody = document.querySelector('#tabelaEscolta tbody');

    if (!tbody) {
        console.error('Tabela de escolta não encontrada!');
        return;
    }

    tbody.innerHTML = '';

    if (dados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Nenhum registro encontrado</td></tr>';
        return;
    }

    dados.forEach(registro => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="padding: 0.75rem !important;">` + registro.numero_protocolo + `</td>
            <td style="padding: 0.75rem !important;">` + registro.created_at + `</td>
            <td style="padding: 0.75rem !important;">` + registro.nome_protegido + `</td>
            <td style="padding: 0.75rem !important;">` + registro.atividade_missao + `</td>
            <td style="padding: 0.75rem !important;">
                <button class="btn btn-sm btn-info" onclick="verDetalhesEscolta('${registro.numero_protocolo}')">Ver</button>
                <button class="btn btn-sm btn-edit" onclick="editarEscolta('${registro.numero_protocolo}')">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="deletarEscolta('${registro.numero_protocolo}')">Deletar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        if ($.fn.DataTable.isDataTable('#tabelaEscolta')) {
            $('#tabelaEscolta').DataTable().destroy();
        }
        $('#tabelaEscolta').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
            },
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            order: [[0, 'asc']]
        });
        
        // Forçar padding nas células
        $('#tabelaEscolta thead th, #tabelaEscolta tbody td').css('padding', '0.75rem');
    }
}

function mostrarErroEscolta(mensagem) {
    const tbody = document.querySelector('#tabelaEscolta tbody');
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">${mensagem}</td></tr>`;
    }
}

function verDetalhesEscolta(protocolo) {
    alert('Ver detalhes do protocolo: ' + protocolo);
}

function editarEscolta(protocolo) {
    alert('Editar protocolo: ' + protocolo);
}

function deletarEscolta(protocolo) {
    if (confirm('Tem certeza que deseja deletar este registro?')) {
        alert('Deletar protocolo: ' + protocolo);
    }
}
