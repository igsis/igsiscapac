<?php
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/igsiscapac/");
define('NOMESIS', "CAPAC");
date_default_timezone_set('America/Sao_Paulo');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos
?>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>CAPAC | SMC</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" />

</head>
<!--<body class="hold-transition login-page">-->
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="login-page">
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="offset-1 col-lg-10">
                                <div class="card">
                                    <div class="card-header bg-dark">
                                        <a href="<?= SERVERURL ?>inicio" class="brand-link">
                                            <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                                            <span class="brand-text font-weight-light"><?= NOMESIS ?> - Cadastro de Artistas e Profissionais de Arte e Cultura</span>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="card-text"><span style="text-align: justify; display:block;">Este sistema tem por objetivo criar um ambiente para credenciamento de artistas e profissionais de arte e cultura a fim de agilizar os processos de contratação artística em eventos realizados pela Secretaria Municipal de Cultura de São Paulo.</span></p>
                                                <p class="card-text"><span style="text-align: justify; display:block;">Uma vez cadastrados, esses artistas poderão atualizar suas informações e enviar a documentação necessária para o processo de contratação. Como o sistema possui ligação direta com o sistema da programação, a medida que o cadastro do artista no CAPAC encontra-se atualizado, o processo de contratação consequentemente é agilizado.</span></p>
                                                <p class="card-text">Podem se cadastrar artistas ou grupos artísticos, como pessoa física ou jurídica.</p>
                                                <p class="card-text">Dúvidas entre em contato com o setor responsável por sua contratação.</p>
                                                <a href="http://smcsistemas.prefeitura.sp.gov.br/manual/capac" target="_blank" class="btn btn-danger btn-block">Manual de Uso e Dúvidas Frequentes</a>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="btn disabled info-box bg-purple" id="inscreverEvento" data-toggle="tooltip" data-placement="top" title="Em Breve">
                                                                    <span class="info-box-icon"><i class="fas fa-file"></i></span>
                                                                    <div class="card-body">
                                                                        <span class="info-box-number">Quero Inscrever Meu Evento</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/igsiscapac/login.php">
                                                                    <div class="info-box bg-cyan">
                                                                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                                                        <div class="card-body">
                                                                            <span class="info-box-number">Sou Proponente de Emenda Parlamentar</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/igsiscapac/login.php">
                                                                    <div class="info-box bg-olive">
                                                                        <span class="info-box-icon"><i class="fas fa-thumbs-up"></i></span>
                                                                        <div class="card-body">
                                                                            <span class="info-box-number">Sou Contratado</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/capac/fomento_edital">
                                                                    <div class="info-box bg-maroon">
                                                                        <span class="info-box-icon"><i class="fas fa-theater-masks"></i></span>
                                                                        <div class="card-body">
                                                                            <span class="info-box-number">Fomentos</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/igsiscapac/login.php">
                                                                    <div class="info-box bg-orange">
                                                                        <span class="info-box-icon"><i class="fas fa-guitar"></i></span>
                                                                        <div class="card-body">
                                                                            <span class="info-box-number">Oficineiros</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/igsiscapac/login.php">
                                                                    <div class="btn info-box bg-teal" id="formacao">
                                                                        <span class="info-box-icon"><i class="fas fa-child"></i></span>
                                                                        <div class="card-body">
                                                                            <span class="info-box-number">Formação</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.login-card-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light-gradient text-center">
                                        <img src="<?= SERVERURL ?>views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png" alt="logo cultura">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Formação -->
            <div class="modal fade" id="modalFormacao" style="display: none" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ações (Expressões Artístico-culturais)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            Aeoo
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-theme" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $('#formacao').on('click', function () {
                    $('#modalFormacao').modal();
                });

                $(document).ready(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
            </script>
        </div>
    </div>

<script src="<?= SERVERURL ?>views/plugins/moment/moment.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= SERVERURL ?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= SERVERURL ?>views/dist/js/adminlte.min.js"></script>
</body>
</html>