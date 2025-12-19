// Script para inserir os cursos na tabela a partir do modal
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('formCurso');
            if (!form) return;

            var nomeInput = document.getElementById('inputNomeCurso');
            var descInput = document.getElementById('inputDescricao');
            var cargaInput = document.getElementById('inputCargaHoraria');
            var dataInput = document.getElementById('inputData');
            var fileInput = document.getElementById('inputArquivoPdf');
            var tbody = document.getElementById('tabelaCursosBody');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                var nome = nomeInput.value.trim();
                var descricao = descInput.value.trim();
                var carga = (cargaInput && cargaInput.value) ? cargaInput.value.trim() : '';
                var data = dataInput.value;
                var file = (fileInput && fileInput.files && fileInput.files[0]) ? fileInput.files[0] : null;

                var tr = document.createElement('tr');
                [nome, descricao, (carga || ''), formatDate(data)].forEach(function (val) {
                    var td = document.createElement('td');
                    td.textContent = val;
                    td.classList.add('text-center', 'align-middle');
                    tr.appendChild(td);
                });

                // Coluna de upload do PDF (apenas nome do arquivo)
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

                // Adicionar coluna de ação com botão de visualizar e deletar
                var tdAcao = document.createElement('td');
                tdAcao.classList.add('text-center', 'align-middle');

                // Botão de visualizar PDF
                var btnView = document.createElement('button');
                btnView.type = 'button';
                btnView.className = 'btn btn-link p-0 me-2';
                btnView.innerHTML = '<i class="bi bi-eye"></i>';
                btnView.setAttribute('data-bs-toggle', 'tooltip');
                btnView.setAttribute('data-bs-title', 'Visualizar PDF');
                btnView.setAttribute('aria-label', 'Visualizar');
                btnView.addEventListener('click', function () {
                    visualizarPdf(objectUrl);
                    // Destruir tooltip após visualizar
                    var viewTooltip = bootstrap.Tooltip.getInstance(btnView);
                    if (viewTooltip) viewTooltip.dispose();
                });
                tdAcao.appendChild(btnView);
                new bootstrap.Tooltip(btnView);

                var btnDelete = document.createElement('button');
                btnDelete.type = 'button';
                btnDelete.className = 'btn btn-link text-danger p-0 btn-remover';
                btnDelete.innerHTML = '<i class="bi bi-trash-fill"></i>';
                btnDelete.setAttribute('data-bs-toggle', 'tooltip');
                btnDelete.setAttribute('data-bs-title', 'Deletar este curso');
                btnDelete.setAttribute('aria-label', 'Deletar');
                btnDelete.addEventListener('click', function () {
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                    }
                    // Destruir tooltips antes de remover a linha
                    var viewTooltip = bootstrap.Tooltip.getInstance(btnView);
                    if (viewTooltip) viewTooltip.dispose();
                    var deleteTooltip = bootstrap.Tooltip.getInstance(btnDelete);
                    if (deleteTooltip) deleteTooltip.dispose();
                    tr.remove();
                });
                tdAcao.appendChild(btnDelete);
                new bootstrap.Tooltip(btnDelete);

                tr.appendChild(tdAcao);

                tbody.appendChild(tr);

                form.reset();
                form.classList.remove('was-validated');

                var modalEl = document.getElementById('modalCurso');
                var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });

            function formatDate(iso) {
                if (!iso) return '';
                var parts = iso.split('-');
                if (parts.length !== 3) return iso;
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            });

    // Funcionalidade: visualizar PDF do curso ao clicar no ícone
    function visualizarPdf(url) {
        if (!url) return;
        window.open(url, '_blank');
    }
