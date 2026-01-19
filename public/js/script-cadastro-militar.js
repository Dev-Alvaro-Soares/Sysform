/**
 * Script de gerenciamento de cursos no formulário de cadastro de militares
 * Permite adicionar, visualizar e remover cursos antes de submeter o formulário principal
 */

// Array para armazenar cursos adicionados
var cursosAdicionados = [];

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('formCurso');
    if (!form) return;

    var nomeInput = document.getElementById('inputNomeCurso');
    var descInput = document.getElementById('inputDescricao');
    var cargaInput = document.getElementById('inputCargaHoraria');
    var dataInput = document.getElementById('inputData');
    var fileInput = document.getElementById('inputArquivoPdf');
    var tbody = document.getElementById('tabelaCursosBody');

    // Adicionar curso ao clicar em "Adicionar Curso" no modal
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var nome = nomeInput.value.trim();
        var descricao = descInput.value.trim();
        var carga = (cargaInput && cargaInput.value) ? cargaInput.value.trim() : '';
        var data = dataInput.value;
        var file = (fileInput && fileInput.files && fileInput.files[0]) ? fileInput.files[0] : null;

        // Armazenar dados do curso em memória
        var cursoData = {
            nome: nome,
            descricao: descricao,
            carga_horaria: carga,
            data: data,
            arquivo: file
        };
        cursosAdicionados.push(cursoData);

        // Criar linha na tabela de preview
        var tr = document.createElement('tr');
        [nome, descricao, (carga || ''), formatDate(data)].forEach(function (val) {
            var td = document.createElement('td');
            td.textContent = val;
            td.classList.add('text-center', 'align-middle');
            tr.appendChild(td);
        });

        // Coluna com nome do arquivo PDF
        var tdUpload = document.createElement('td');
        tdUpload.classList.add('text-center', 'align-middle');
        var objectUrl = null;
        if (file) {
            objectUrl = URL.createObjectURL(file);
            tdUpload.textContent = file.name;
        } else {
            tdUpload.textContent = '';
        }
        tr.appendChild(tdUpload);

        // Coluna com botões de ação
        var tdAcao = document.createElement('td');
        tdAcao.classList.add('text-center', 'align-middle');

        // Botão para visualizar PDF
        var btnView = document.createElement('button');
        btnView.type = 'button';
        btnView.className = 'btn btn-link p-0 me-2';
        btnView.innerHTML = '<i class="bi bi-eye"></i>';
        btnView.addEventListener('click', function () {
            if (objectUrl) {
                visualizarPdf(objectUrl);
            } else {
                alert('Nenhum arquivo PDF foi anexado para este curso.');
            }
        });
        tdAcao.appendChild(btnView);

        // Botão para remover curso
        var btnDelete = document.createElement('button');
        btnDelete.type = 'button';
        btnDelete.className = 'btn btn-link text-danger p-0 btn-remover';
        btnDelete.innerHTML = '<i class="bi bi-trash-fill"></i>';
        var cursoIndex = cursosAdicionados.length - 1;
        btnDelete.addEventListener('click', function () {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }
            cursosAdicionados.splice(cursoIndex, 1);
            tr.remove();
        });
        tdAcao.appendChild(btnDelete);
        tr.appendChild(tdAcao);

        tbody.appendChild(tr);

        // Limpar formulário e fechar modal
        form.reset();
        var modalEl = document.getElementById('modalCurso');
        var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
    });

    // Converter data de formato ISO para dd/mm/yyyy
    function formatDate(iso) {
        if (!iso) return '';
        var parts = iso.split('-');
        if (parts.length !== 3) return iso;
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    // Enviar formulário principal com os cursos agregados
    var formPrincipal = document.getElementById('cadastroMilitarForm');
    if (formPrincipal) {
        formPrincipal.addEventListener('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(formPrincipal);

            // Preparar cursos em formato JSON para envio
            if (cursosAdicionados.length > 0) {
                var cursosParaEnvio = [];
                cursosAdicionados.forEach(function (curso, index) {
                    var cursoObj = {
                        nome_curso: curso.nome,
                        descricao: curso.descricao,
                        carga_horaria: curso.carga_horaria,
                        data: curso.data
                    };
                    
                    // Adicionar arquivo PDF se existir
                    if (curso.arquivo) {
                        formData.append('cursos_arquivo_' + index, curso.arquivo);
                        cursoObj.tem_arquivo = true;
                    }
                    
                    cursosParaEnvio.push(cursoObj);
                });
                
                // Serializar como JSON e adicionar ao FormData
                var jsonString = JSON.stringify(cursosParaEnvio);
                formData.append('cursos_json', jsonString);
            }

            // Enviar dados via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open(formPrincipal.method, formPrincipal.action, true);
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = '../views/cadastro_militares.php?success=1';
                } else {
                    alert('Erro ao enviar formulario. Status: ' + xhr.status);
                }
            };

            xhr.onerror = function () {
                alert('Erro de rede ao enviar formulario.');
            };
            
            xhr.send(formData);
        });
    }
});

/**
 * Abre o PDF em uma nova aba do navegador
 */
function visualizarPdf(url) {
    if (!url) return;
    window.open(url, '_blank');
}
