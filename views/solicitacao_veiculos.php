<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário MPPA / GSI</title>
    <!-- Favicon do MPPA -->
    <link rel="shortcut icon" href="../public/img/faviconMPPA.png" type="image/x-icon">
    <!-- Integração do CSS personalizado -->
    <link rel="stylesheet" href="../public/css/estilos_cadastro_veiculos.css">
    <!-- Integração do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Integração dos ícones do bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header_container d-flex align-items-center justify-content-between">
            <h1 class="titulo-header">Solicitação de veículo</h1>
            <div class="d-flex align-items-center gap-4">
                <img class="logo-mppa" src="../public/img/logoMppaBranco.png" alt="Logo do MPPA">
                <img class="logo-gsi" src="../public/img/logoGsiMppa.png" alt="Logo do GSI">
            </div>
        </div>
    </header>
    <main>
        <form id="solicitacaoForm" method="post" action="../public/save_solicitacao.php" novalidate>

            <!-- 1. Dados do condutor -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">1. Dados do condutor</h2>

                <div class="d-flex flex-wrap gap-4">
                    <input name="nome" class="form-control input-line flex-item" type="text" placeholder="Nome">
                    <input name="matricula" class="form-control input-line flex-item" type="text" placeholder="Matrícula" pattern="\d*" maxlength="50">
                    <div class="input-wrapper flex-item">
                        <input name="data_missao" type="text" class="form-control input-line campo-data"
                            placeholder="Data da missão (dd.mm.aaaa)">
                        <i class="bi bi-calendar-date-fill icone-data"></i>
                    </div>
                </div>
            </section>

            <!-- 2. Dados do veículo -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">2. Dados do veículo</h2>
                <div class="row g-4">

                    <div class="col-12 col-md-4 mb-3">
                        <div class="input-wrapper">
                            <select name="modelo" class="form-select custom-input">
                                <option value="" selected disabled>Escolha o modelo</option>
                                <option value="VOLKSWAGEM VIRTUS 1.0 PRETO - SZA9E20">VOLKSWAGEM VIRTUS 1.0 PRETO - SZA9E20</option>
                                <option value="VOLKSWAGEM VIRTUS 1.0 PRETO - SZA9I20">VOLKSWAGEM VIRTUS 1.0 PRETO - SZA9I20</option>
                                <option value="CHEVROLET S10 BRANCA - SIC5E83">CHEVROLET S10 BRANCA - SIC5E83</option>
                                <option value="CHEVROLET S10 preto - SIH0G81">CHEVROLET S10 preto - SIH0G81</option>
                                <option value="CHEVROLET S10 preto - SIP3G83">CHEVROLET S10 preto - SIP3G83</option>
                                <option value="HONDA / XRE 300 - QDT6112">HONDA / XRE 300 - QDT6112</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <input name="quilometragem_inicial" class="form-control input-line" type="number" placeholder="KM inicial" min="0" step="1" required>
                    </div>
                    <div class="col-md-2">
                        <input name="quilometragem_final" class="form-control input-line" type="number" placeholder="KM final" min="0" step="1">
                    </div>
                    <div class="col-md-2">
                        <div class="input-wrapper">
                            <input name="retirada" type="text" class="form-control campo-horario"
                                placeholder="Hora de retirada (hh:mm)" pattern="[0-2][0-9]:[0-5][0-9]" maxlength="5">
                            <i class="bi bi-clock-fill icone-horario"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-wrapper">
                            <input name="devolucao" type="text" class="form-control campo-horario"
                                placeholder="Hora de devolução (hh:mm)" pattern="[0-2][0-9]:[0-5][0-9]" maxlength="5">
                            <i class="bi bi-clock-fill icone-horario"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Campo de observações -->
            <section class="section-box p-3 mx-4 my-3">
                <h2 class="section-title mb-3">3. Observações</h2>
                <textarea name="observacao" class="form-control input-line" id="" placeholder="Observações"></textarea>
            </section>

            <!-- 4. Botão de envio -->
            <button type="submit" class="btn-enviar d-block mx-auto text-uppercase my-5 fw-bold"><i class="bi bi-cursor-fill me-2"></i>Enviar</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="../public/js/validacao_veiculos.js"></script>
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




<!-- 

Comentários no código (Ajustes)

-> Ao reduzir o tamanho da tela, notei que todos os campos estão mantendo uma consistência de estender para ocupar o espaço dispónivel, porém apenas o campo select (modelo) não está se comportando da mesma forma. Sugiro ajustar o CSS para que ele também se comporte como os outros campos, ocupando o espaço disponível de forma proporcional.
-> Ao reduzir o espaço horizontal, notei que o layout dos campos está se quebrando o placeholder vai sumindo ao inves de apenas se reduzir proporcionalmente. Sugiro ajustar o CSS para que os campos mantenham uma largura mínima, evitando que o texto do placeholder desapareça.

-->