<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário MPPA / GSI</title>
    <!-- Favicon do MPPA -->
    <link rel="shortcut icon" href="../public/img/faviconMPPA.png" type="image/x-icon">
    <!-- Integração do CSS personalizado -->
    <link rel="stylesheet" href="../public/css/estilos_cadastro_militares.css">
    <!-- Integração do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Integração dos ícones do bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        
    </style>
</head>

<body>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cabeçalho -->
    <header>
        <div class="header_container d-flex align-items-center justify-content-between">
            <h1 class="titulo-header">Cadastro de militares</h1>
            <div class="d-flex align-items-center gap-4">
                <img class="logo-mppa" src="../public/img/logoMppaBranco.png" alt="Logo do MPPA">
                <img class="logo-gsi" src="../public/img/logoGsiMppa.png" alt="Logo do GSI">
            </div>
        </div>
    </header>
    <main>
        <form id="cadastroMilitarForm" action="../app/Controllers/CadastroMilitarController.php" method="POST" enctype="multipart/form-data">

            <!-- 1. Identificação do militar -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">1. Identificação do militar</h2>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <input class="form-control input-line" type="text" name="nome_militar" placeholder="Nome">
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="form-control input-line" type="text" name="nome_guerra" placeholder="Nome de guerra">
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="input-wrapper">
                            <select class="form-select" name="patente">
                                <option value="" selected disabled>Patente</option>
                                <option value="Coronel">Cel. (Coronel)</option>
                                <option value="Tenente Coronel">Ten. Cel. (Tenente Coronel)</option>
                                <option value="Major">Maj. (Major)</option>
                                <option value="Capitão">Cap. (Capitão)</option>
                                <option value="Primeiro Tenente">1º Ten. (Primeiro Tenente)</option>
                                <option value="Segundo Tenente">2º Ten. (Segundo Tenente)</option>
                                <option value="Subtenente">Subten. (Subtenente)</option>
                                <option value="Primeiro Sargento">1º Sgt. (Primeiro Sargento)</option>
                                <option value="Segundo Sargento">2º Sgt. (Segundo Sargento)</option>
                                <option value="Terceiro Sargento">3º Sgt. (Terceiro Sargento)</option>
                                <option value="Cabo">Cb. (Cabo)</option>
                                <option value="Soldado">Sd. (Soldado)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="form-control input-line" type="text" name="lotacao" placeholder="Lotação">
                    </div>

                    <div class="col-12">
                        <input class="form-control input-line" type="text" name="doc_militar_numero"
                            placeholder="Nº documento de identificação do militar">
                    </div>
                    <div class="col-12">
                        <label for="doc_militar" class="form-label label-position">Anexar o documento de identificação do militar</label>
                        <input class="form-control input-line" type="file" id="doc_militar" name="doc_militar" accept=".pdf">
                    </div>
                </div>
            </section>

            <!-- 2. Identificação civil -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">2. Identificação civil</h2>

                <div class="row g-4">
                    <div class="col-12">
                        <input class="form-control input-line" type="text" name="nome_civil" placeholder="Nome do pai">
                    </div>
                    <div class="col-12">
                        <input class="form-control input-line" type="text" name="nome_mae" placeholder="Nome da mãe">
                    </div>
                    <div class="col-12">
                        <input class="form-control input-line" type="text" name="doc_civil_numero"
                            placeholder="Nº documento de identificação civil">
                    </div>
                    <div class="col-12">
                        <label for="doc_civil" class="form-label label-position">Anexar o documento de identificação civil</label>
                        <input class="form-control input-line" type="file" id="doc_civil" name="doc_civil" accept=".pdf">
                    </div>
                </div>
            </section>

            <!-- 3. Dados de endereço -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">3. Dados de endereço</h2>

                <!-- Subseção: Endereço Pessoal -->
                <div class="endereco-subsection mb-4">
                    <h3 class="subsection-title mb-3">Pessoal</h3>
                    <div class="row g-4">
                        <div class="col-12 col-lg-4">
                            <input class="form-control input-line" type="text" name="endereco_pessoal" placeholder="Endereço, número">
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="text" name="bairro_pessoal" placeholder="Bairro">
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="text" name="cidade_pessoal" placeholder="Cidade">
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="input-wrapper">
                                <select class="form-select" name="estado_pessoal">
                                    <option value="" selected disabled>Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="number" name="cep_pessoal" placeholder="CEP">
                        </div>
                    </div>
                </div>

                <!-- Subseção: Endereço Funcional -->
                <div class="endereco-subsection">
                    <h3 class="subsection-title mb-3">Funcional</h3>
                    <div class="row g-4">
                        <div class="col-12 col-lg-4">
                            <input class="form-control input-line" type="text" name="endereco_funcional" placeholder="Endereço, número">
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="text" name="bairro_funcional" placeholder="Bairro">
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="text" name="cidade_funcional" placeholder="Cidade">
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="input-wrapper">
                                <select class="form-select" name="estado_funcional">
                                    <option value="" selected disabled>Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input class="form-control input-line" type="number" name="cep_funcional" placeholder="CEP">
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Informações complementares -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">4. Informações complementares</h2>

                <div class="row g-4">
                    <div class="col-12 col-lg-3">
                        <div class="input-wrapper">
                            <select class="form-select" name="qualificacao">
                                <option value="" selected disabled>Qualificação</option>
                                <option value="Ensino médio">Ensino médio</option>
                                <option value="Ensino superior (Graduação)">Ensino superior (Graduação)</option>
                                <option value="Ensino superior (Pós-graduação)">Ensino superior (Pós-graduação)</option>
                                <option value="Mestrado">Mestrado</option>
                                <option value="Doutorado">Doutorado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <input class="form-control input-line" type="text" name="indicado_por" placeholder="Indicado por">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input class="telefone-input form-control input-line" type="tel" name="telefone"
                            placeholder="Telefone (DDD)">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input class="form-control input-line" type="email" name="email" placeholder="Email">
                    </div>
                    <div class="col-12 col-lg-6">
                        <input class="form-control input-line" type="text" name="conjuge" placeholder="Cônjuge">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input class="form-control input-line" type="number" name="numero_filhos" placeholder="Nº de filhos">
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-wrapper">
                            <select class="form-select custom-input" name="tipo_sanguineo">
                                <option value="" selected disabled>Tipo sanguíneo</option>
                                <option value="O+">O+</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="O-">O-</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Vínculo com o Ministério Público:</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vinculo_mp" id="vinculo-ativo"
                                    value="ativo" checked>
                                <label class="form-check-label" for="vinculo-ativo">
                                    Ativo (Agregado)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vinculo_mp" id="vinculo-reserva"
                                    value="reserva">
                                <label class="form-check-label" for="vinculo-reserva">
                                    Reserva (Reconvocado)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. Cursos realizados (anexar certificado) -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">5. Cursos realizados (anexar certificado)</h2>

                <a href="#" class="link-primary d-inline-block mb-3" data-bs-toggle="modal"
                    data-bs-target="#modalCurso">Novo anexo</a>

                <div class="table-responsive">
                    <table class="table table-bordered tabela-cursos text-center">
                        <colgroup>
                            <col class="col-3"><!-- Nome -->
                            <col class="col-3"><!-- Descrição -->
                            <col class="col-1"><!-- Carga horária -->
                            <col class="col-1"><!-- Data -->
                            <col class="col-3"><!-- Upload PDF -->
                            <col class="col-1"><!-- Ação -->
                        </colgroup>
                        <thead class="table-secondary">
                            <tr>
                                <th class="align-middle" scope="col">Nome do curso</th>
                                <th class="align-middle" scope="col">Descrição</th>
                                <th class="align-middle" scope="col">Carga horária do curso (Horas)</th>
                                <th class="align-middle" scope="col">Data</th>
                                <th class="align-middle" scope="col">Upload do arquivo (PDF)</th>
                                <th class="align-middle" scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaCursosBody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 6. Botão de envio -->
            <button type="submit" class="btn-enviar d-block mx-auto text-uppercase my-5 fw-bold">
                <i class="bi bi-cursor-fill me-2"></i>Enviar
            </button>

        </form>
    </main>
    <div class="modal fade" id="modalCurso" tabindex="-1" aria-labelledby="modalCursoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="formCurso">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCursoLabel">Novo anexo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputNomeCurso" class="form-label">Nome do curso</label>
                        <input type="text" class="form-control" id="inputNomeCurso" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescricao" class="form-label">Descrição</label>
                        <textarea class="form-control ta-noresize" id="inputDescricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="inputCargaHoraria" class="form-label">Carga horária do curso (Horas)</label>
                        <input type="number" class="form-control" id="inputCargaHoraria" min="0" step="0.5" placeholder="Ex.: 20" required>
                        <div class="invalid-feedback">Informe a carga horária.</div>
                    </div>
                    <div class="mb-3">
                        <label for="inputData" class="form-label">Data</label>
                        <input type="date" class="form-control" id="inputData" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputArquivoPdf" class="form-label">Upload do arquivo (PDF)</label>
                        <input type="file" class="form-control" id="inputArquivoPdf" accept="application/pdf,.pdf" required>
                        <div class="invalid-feedback">Anexe um arquivo PDF.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarCurso">Adicionar</button>
                </div>
            </form>
        </div>
    </div>

        <!-- Modal de sucesso -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Cadastro de militar realizado com sucesso.
                        <div id="protocoloInfo" style="display: none;">
                            Protocolo: <span id="protocoloNumero" class="texto-protocolo"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de erro (validação) -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">Erro</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="errorModalBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

            <!-- Integração do Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

            <!-- Integração do JS personalizado -->
        <script src="../public/js/validacao_militares.js"></script>
        <script src="../public/js/script-cadastro-militar.js"></script>

        <!-- Script para exibir modal de sucesso -->
        <script>
            (function(){
                try {
                    const params = new URLSearchParams(window.location.search);
                    if (params.get('success') === '1') {
                        const protocolo = params.get('protocolo');
                        const protocoloInfo = document.getElementById('protocoloInfo');
                        const protocoloEl = document.getElementById('protocoloNumero');
                        if (protocolo && protocoloInfo && protocoloEl) {
                            protocoloEl.textContent = protocolo;
                            protocoloInfo.style.display = 'block';
                        }
                        const modalEl = document.getElementById('successModal');
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                        // remover param da URL para evitar reaparecer ao recarregar
                        params.delete('success');
                        params.delete('protocolo');
                        const newUrl = window.location.pathname + (params.toString() ? ('?' + params.toString()) : '');
                        history.replaceState(null, '', newUrl);
                    }
                } catch (e) {
                    console.error('Erro ao exibir modal:', e);
                }
            })();
        </script>
</body>

</html>