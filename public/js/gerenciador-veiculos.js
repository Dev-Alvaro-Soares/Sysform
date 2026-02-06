/**
 * Gerenciador de Veículos - Frontend
 * Busca dados da API e popula a tabela
 */

document.addEventListener('DOMContentLoaded', function() {
    carregarVeiculos();
});

function carregarVeiculos() {
    // Fazer requisição para o backend
    fetch('api/veiculos.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data); // Debug
            if (data.success) {
                preencherTabelaVeiculos(data.data);
            } else {
                console.error('Erro ao carregar dados:', data.error);
                mostrarErro('Erro ao carregar dados: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            mostrarErro('Erro ao conectar com o servidor: ' + error.message);
        });
}

function preencherTabelaVeiculos(dados) {
    console.log('preencherTabelaVeiculos chamada com:', dados);
    console.log('Quantidade de registros:', dados.length);
    
    const tbody = document.querySelector('#tabelaVeiculos tbody');
    console.log('tbody encontrado:', tbody);
    
    if (!tbody) {
        console.error('Tabela não encontrada!');
        return;
    }
    
    // Limpar tabela anterior
    tbody.innerHTML = '';

    // Se não há dados
    if (dados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Nenhum registro encontrado</td></tr>';
        return;
    }

    // Preencher a tabela com os dados
    dados.forEach((registro, index) => {
        console.log(`Adicionando registro ${index + 1}:`, registro);
        const tr = document.createElement('tr');
        tr.style.padding = '0.75rem';
        tr.innerHTML = `
            <td style="padding: 0.75rem !important;">` + registro.numero_protocolo + `</td>
            <td style="padding: 0.75rem !important;">` + registro.created_at + `</td>
            <td style="padding: 0.75rem !important;">` + registro.nome + `</td>
            <td style="padding: 0.75rem !important;">` + registro.modelo + `</td>
            <td style="padding: 0.75rem !important;">` + registro.data_missao + `</td>
            <td style="padding: 0.75rem !important;">
                <button class="btn btn-sm btn-info" onclick="verDetalhes('${registro.numero_protocolo}')">Ver</button>
                <button class="btn btn-sm btn-edit" onclick="editarRegistro('${registro.numero_protocolo}')">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="deletarRegistro('${registro.numero_protocolo}')">Deletar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
    
    console.log('Tabela preenchida com sucesso!');

    // Inicializar DataTables DEPOIS de adicionar os dados
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        // Verificar se já está inicializado e destruir
        if ($.fn.DataTable.isDataTable('#tabelaVeiculos')) {
            $('#tabelaVeiculos').DataTable().destroy();
        }
        // Inicializar com os dados já na tabela
        $('#tabelaVeiculos').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
            },
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
               order: [[0, 'asc']] // Ordenar por protocolo crescente
        });
        
        // Forçar padding nas células
        $('#tabelaVeiculos thead th, #tabelaVeiculos tbody td').css('padding', '0.75rem');
        
        console.log('DataTables inicializado!');
    }
}

function mostrarErro(mensagem) {
    const tbody = document.querySelector('#tabelaVeiculos tbody');
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${mensagem}</td></tr>`;
}

function verDetalhes(protocolo) {
    alert('Ver detalhes do protocolo: ' + protocolo);
    // TODO: Implementar visualização de detalhes
}

function editarRegistro(protocolo) {
    alert('Editar protocolo: ' + protocolo);
    // TODO: Implementar edição de registro
}

function deletarRegistro(protocolo) {
    if (confirm('Tem certeza que deseja deletar este registro?')) {
        alert('Deletar protocolo: ' + protocolo);
        // TODO: Implementar deleção de registro
    }
}
