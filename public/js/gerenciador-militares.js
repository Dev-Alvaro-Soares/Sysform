/**
 * Gerenciador de Militares - Frontend
 * Busca dados da API e popula a tabela
 */

document.addEventListener('DOMContentLoaded', function() {
    carregarMilitares();
});

function carregarMilitares() {
    fetch('api/militares.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                preencherTabelaMilitares(data.data);
            } else {
                console.error('Erro ao carregar dados:', data.error);
                mostrarErroMilitares('Erro ao carregar dados: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Erro na requisicao:', error);
            mostrarErroMilitares('Erro ao conectar com o servidor: ' + error.message);
        });
}

function preencherTabelaMilitares(dados) {
    const tbody = document.querySelector('#tabelaMilitares tbody');

    if (!tbody) {
        console.error('Tabela de militares nao encontrada!');
        return;
    }

    tbody.innerHTML = '';

    if (dados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Nenhum registro encontrado</td></tr>';
        return;
    }

    dados.forEach(registro => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="padding: 0.75rem !important;">` + registro.numero_protocolo + `</td>
            <td style="padding: 0.75rem !important;">` + registro.created_at + `</td>
            <td style="padding: 0.75rem !important;">` + registro.nome_militar + `</td>
            <td style="padding: 0.75rem !important;">` + registro.patente + `</td>
            <td style="padding: 0.75rem !important;">` + registro.lotacao + `</td>
            <td style="padding: 0.75rem !important;">` + registro.telefone + `</td>
            <td style="padding: 0.75rem !important;">` + registro.email + `</td>
            <td style="padding: 0.75rem !important;">
                <button class="btn btn-sm btn-info" onclick="verDetalhesMilitar('${registro.numero_protocolo}')">Ver</button>
                <button class="btn btn-sm btn-edit" onclick="editarMilitar('${registro.numero_protocolo}')">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="deletarMilitar('${registro.numero_protocolo}')">Deletar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        if ($.fn.DataTable.isDataTable('#tabelaMilitares')) {
            $('#tabelaMilitares').DataTable().destroy();
        }
        $('#tabelaMilitares').DataTable({
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
        $('#tabelaMilitares thead th, #tabelaMilitares tbody td').css('padding', '0.75rem');
    }
}

function mostrarErroMilitares(mensagem) {
    const tbody = document.querySelector('#tabelaMilitares tbody');
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-danger">${mensagem}</td></tr>`;
    }
}

function verDetalhesMilitar(protocolo) {
    alert('Ver detalhes do protocolo: ' + protocolo);
}

function editarMilitar(protocolo) {
    alert('Editar protocolo: ' + protocolo);
}

function deletarMilitar(protocolo) {
    if (confirm('Tem certeza que deseja deletar este registro?')) {
        alert('Deletar protocolo: ' + protocolo);
    }
}
