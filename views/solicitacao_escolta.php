<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulário MPPA / GSI</title>
    <!-- Favicon do MPPA -->
    <link rel="shortcut icon" href="../public/img/faviconMPPA.png" type="image/x-icon">
    <!-- Integração do CSS personalizado -->
    <link rel="stylesheet" href="../public/css/estilos_solicitacao_escolta.css">
    <!-- Flatpickr CSS (local) -->
    <link rel="stylesheet" href="../flatpickr/flatpickr.min.css">
    <!-- Integração do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Integração dos ícones do bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>

    <!--  Modal  -->

    <div class="modal fade" id="modal_01" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Instruções gerais</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p style="text-align: justify">Este roteiro operacional é elaborado em consonância com a Política de Segurança
            Institucional
            (PSI/MP) e o Sistema Nacional de Segurança Institucional (SNS/MP) do Ministério Público (Resolução CNMP nº
            156/2016), as regras gerais de proteção pessoal (Resolução CNMP nº 116/2014) e as atribuições do Grupo de
            Atuação Especial de Inteligência e Segurança Institucional (GSI) do MPPA. (Resolução n° 13/2024 - CPJ)</p>
          <p class="text-justify">A missão da equipe de escolta é garantir a segurança e a integridade física do(a) membro/servidor(a).</p>
          <p class="text-justify fw-bold">Recomendações para a Equipe de Escolta: </p>
          <ul>
            <li style="text-align: justify"><span class="fw-bold">Profissionalismo e Discrição:</span> atuar com o mais alto grau de profissionalismo, mantendo
              a discrição em todos os momentos para não expor desnecessariamente o(a) Protegido(a) ou a missão.</li>
            <li style="text-align: justify"><span class="fw-bold">Sigilo:</span> manter absoluto sigilo sobre a missão, a identidade do(a) Protegido(a), as
              rotinas observadas e todas as informações obtidas. O compartilhamento de informações é restrito ao Grupo
              de Inteligência e Segurança e ao Gabinete Militar.</li>
            <li style="text-align: justify"><span class="fw-bold">Comunicação Interna:</span> manter comunicação constante e eficaz dentro da própria equipe.
            </li>
            <li style="text-align: justify"><span class="fw-bold">Uso de Equipamentos e Veículos:</span> zelar pela conservação e bom funcionamento dos
              equipamentos (rádios, armamento, etc.) e veículos utilizados.</li>
            <li style="text-align: justify"><span class="fw-bold">Respeito às Normas:</span> observar todas as leis, regulamentos e procedimentos operacionais
              do Ministério Público do Estado do Pará e das forças de segurança de origem dos agentes.</li>
            <li style="text-align: justify"><span class="fw-bold">Execução da Escolta:</span> realizar o acompanhamento do(a) Protegido(a) conforme o
              planejamento. Manter vigilância constante do entorno em todos os momentos.</li>
            <li style="text-align: justify"><span class="fw-bold">Segurança em Deslocamento:</span> utilizar técnicas de direção defensiva e evasiva, se
              necessário. Manter a formação adequada dos veículos.</li>
            <li style="text-align: justify"><span class="fw-bold">Observação e Relato:</span> observar atentamente o ambiente, pessoas, veículos, sons e
              qualquer detalhe incomum.</li>
            <li style="text-align: justify"><span class="fw-bold">Gerenciamento de Incidentes:</span> em caso de risco, seguir protocolos de resposta rápida e
              comunicar imediatamente o Grupo de Inteligência e Segurança e ao Gabinete Militar.</li>
            <li style="text-align: justify"><span class="fw-bold">Debriefing Final da Equipe:</span> avaliar atividades realizadas e preparar informações para o
              relatório.</li>
            <p class="my-3">⚠️ Reportar Imediatamente ao Gabinete Militar e ao Grupo de Inteligência e
              Segurança qualquer problema técnico:</p>
            <ul class="contato-emergencia">
              <li>Cel Franco <span>(91) 98187-8018</span></li>
              <li>Cel Gomes <span>(91) 98097-0001</span></li>
              <li>Dra. Érika Menezes <span>(91) 98871-2101 (Coordenadora do GSI)</span></li>
              <li>Pedro Moreira <span>(91) 98898-2559 (Assessor do GSI)</span></li>
            </ul>
          </ul>
          <p class="text-danger fw-bold fs-6">É IMPRESCINDÍVEL e OBRIGATÓRIO o encaminhamento deste
            Relatório de Atividades.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary mx-auto d-block" data-bs-dismiss="modal">Ciente</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Cabeçalho -->
    <header>
        <div class="header_container d-flex align-items-center justify-content-between">
            <h1 class="titulo-header">Solicitação de escolta</h1>
            <div class="d-flex align-items-center gap-4">
                <img class="logo-mppa" src="../public/img/logoMppaBranco.png" alt="Logo do MPPA">
                <img class="logo-gsi" src="../public/img/logoGsiMppa.png" alt="Logo do GSI">
            </div>
        </div>
    </header>
    <main>
        <form id="solicitacaoForm" method="post" action="../app/Controllers/SolicitacaoEscoltaController.php" novalidate>

            <!-- 1. Dados do protegido -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">1. Dados do protegido</h2>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <input name="nome_protegido" class="form-control input-line" type="text" placeholder="Nome" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <select name="atividade_missao" class="form-select custom-input" required>
                            <option value="" selected disabled>Escolha a atividade realizada na missão</option>
                            <option value="Visita carcerária">Visita carcerária</option>
                            <option value="Acompanhamento em evento">Acompanhamento em evento</option>
                            <option value="Júri">Júri</option>
                            <option value="Audiência">Audiência</option>
                            <option value="Reunião por acumulação de cargo">Reunião por acumulação de cargo</option>
                            <option value="Diligências">Diligências</option>
                            <option value="Inspeção">Inspeção</option>
                            <option value="Fiscalização">Fiscalização</option>
                            <option value="Plantão em promotoria de Justiça">Plantão em promotoria de Justiça</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- 2. Equipe militar -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">2. Equipe militar</h2>

                                <button type="button" class="btn btn-primary d-inline-block mb-3" data-bs-toggle="modal" data-bs-target="#modalEquipeMilitar">Adicionar</button>

                                <div class="table-responsive">
                                    <table class="table table-bordered tabela-cursos text-center">
                                        <colgroup>
                                            <col class="col-4"><!-- Patente -->
                                            <col class="col-4"><!-- Nome -->
                                            <col class="col-3"><!-- Função -->
                                            <col class="col-1"><!-- Ação -->
                                        </colgroup>
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="align-middle" scope="col">Patente</th>
                                                <th class="align-middle" scope="col">Nome</th>
                                                <th class="align-middle" scope="col">Função</th>
                                                <th class="align-middle" scope="col">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabelaEquipeBody"></tbody>
                                    </table>
                                </div>
            </section>

            <!-- 3. Dados da missão -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">3. Dados da missão</h2>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="position-relative">
                            <input name="localidades" id="localidade" class="form-control input-line" type="text" placeholder="Localidades" autocomplete="off" required>
                            <div id="localidade-suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-3">
                      <div class="input-wrapper">
                        <input name="data_inicio_missao" class="form-control input-line campo-data" type="text" placeholder="Data do início da missão (dd.mm.aaaa)" required>
                        <i class="bi bi-calendar-date-fill icone-data"></i>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="input-wrapper">
                        <input name="data_final_missao" class="form-control input-line campo-data" type="text" placeholder="Data do final da missão (dd.mm.aaaa)" required>
                        <i class="bi bi-calendar-date-fill icone-data"></i>
                      </div>
                    </div>
                    <div class="col-3">
                        <div class="input-wrapper">
                            <input name="horario_chegada" class="form-control input-line campo-horario" type="text" placeholder="Horário de chegada do local (hh:mm)" pattern="[0-2][0-9]:[0-5][0-9]" maxlength="5" required>
                            <i class="bi bi-clock-fill icone-horario"></i>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-wrapper">
                            <input name="horario_saida" class="form-control input-line campo-horario" type="text" placeholder="Horário de saída do local (hh:mm)" pattern="[0-2][0-9]:[0-5][0-9]" maxlength="5" required>
                            <i class="bi bi-clock-fill icone-horario"></i>
                        </div>
                    </div>
                    <div class="col-12">
                        <textarea name="descricao_atividades" class="form-control input-line" rows="3" placeholder="Descrição das atividades realizadas e locais frequentados" required></textarea>
                    </div>
                </div>
            </section>

            <!-- 4. Observações -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">4. Observações</h2>
                <textarea name="observacoes" class="form-control input-line" placeholder="Observações"></textarea>
            </section>

            <!-- Botão de envio -->
            <button type="submit" class="btn-enviar d-block mx-auto text-uppercase my-5 fw-bold"><i class="bi bi-cursor-fill me-2"></i>Enviar</button>
        </form>

        <p class="text-danger fs-5 ms-3">SIGILO: O relatório é documento de inteligência/segurança institucional e deve ser tratado com o máximo de sigilo (Resolução 13/2024 MPPA, art. 28).</p>

        <!-- Modal: Adicionar militar -->
        <div class="modal fade" id="modalEquipeMilitar" tabindex="-1" aria-labelledby="modalEquipeMilitarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" id="formEquipeMilitar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEquipeMilitarLabel">Adicionar militar à equipe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="selectPatente" class="form-label">Patente</label>
                            <select class="form-select" id="selectPatente" required>
                                <option value="" selected disabled>Selecione a patente</option>
                                <option value="Cel. (Coronel)">Cel. (Coronel)</option>
                                <option value="Ten. Cel. (Tenente Coronel)">Ten. Cel. (Tenente Coronel)</option>
                                <option value="Maj. (Major)">Maj. (Major)</option>
                                <option value="Cap. (Capitão)">Cap. (Capitão)</option>
                                <option value="1º Ten. (Primeiro Tenente)">1º Ten. (Primeiro Tenente)</option>
                                <option value="2º Ten. (Segundo Tenente)">2º Ten. (Segundo Tenente)</option>
                                <option value="Subten. (Subtenente)">Subten. (Subtenente)</option>
                                <option value="1º Sgt. (Primeiro Sargento)">1º Sgt. (Primeiro Sargento)</option>
                                <option value="2º Sgt. (Segundo Sargento)">2º Sgt. (Segundo Sargento)</option>
                                <option value="3º Sgt. (Terceiro Sargento)">3º Sgt. (Terceiro Sargento)</option>
                                <option value="Cb. (Cabo)">Cb. (Cabo)</option>
                                <option value="Sd. (Soldado)">Sd. (Soldado)</option>
                                <!-- Opções serão definidas manualmente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputNomeMilitar" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputNomeMilitar" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputFuncaoMissao" class="form-label">Função na missão</label>
                            <input type="text" class="form-control" id="inputFuncaoMissao" placeholder="Ex.: Liderança, Planejamento, Segurança, etc." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>

        <!-- Flatpickr (local) -->
        <script src="../flatpickr/flatpickr.min.js"></script>
        <script src="../flatpickr/l10n/pt.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Inicializar Flatpickr
                if (window.flatpickr) {
                    flatpickr('.campo-data', {
                        dateFormat: 'd.m.Y',
                        locale: 'pt',
                        allowInput: true
                    });
                }
            });
        </script>
        
        <script src="../public/js/localidades-ibge.js"></script>
        <script src="../public/js/script-solicitacao-de-escolta.js"></script>

        <!-- Modal de sucesso -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sua Solicitação foi enviada.
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

        <script>
            (function(){
                try {
                    const params = new URLSearchParams(window.location.search);
                    if (params.get('success') === '1') {
                        const modalEl = document.getElementById('successModal');
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                        // remover param da URL para evitar reaparecer ao recarregar
                        params.delete('success');
                        const newUrl = window.location.pathname + (params.toString() ? ('?' + params.toString()) : '');
                        history.replaceState(null, '', newUrl);
                    }
                } catch (e) {
                    // silencioso se algo falhar
                    console.error(e);
                }
            })();
        </script>
</body>

</html>