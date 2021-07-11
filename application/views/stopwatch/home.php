<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>My Time</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="icon" href="<?=base_url('assets/'); ?>img/icon.png">

    <link rel="stylesheet" href="<?=base_url('assets/'); ?>css/stopwatch.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;1,300&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

</head>

<body>
    <div class="container-fluid text-center mt-5">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-12">
                        <h1><span class="gold">NOVA</span> STOPWATCH<i class="feather" data-feather='clock'></i></h1>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="circle mx-auto">
                            <span class="time" id="display">00:00:00</span>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <form>
                        <div class="form-group">
                            <label for="ketogori-selector">Pilih Kategori :</label>
                            <select class="form-control" id="ketogori-selector">
                                <?php
foreach ($kategori->result_array() as $pilihktg) { ?>
                                <option><?=$pilihktg['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-12" id="controls">
                        <button class="buttonPlay align-middle mt-2">
                            <img id="playButton"
                                src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/play-button_opkxmt.svg" />

                            <img id="pauseButton"
                                src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/pause-button_pinhpy.svg" />
                        </button>

                        <button class="buttonReset align-middle mt-2">
                            <img id="resetButton"
                                src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/reset-button_mdv6wf.svg" />
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bg-light text-dark">
                <h1 class="mt-3 mb-3">Ringkasan <b>Nova</b> Stopwatch</h1>
                <table class="display nowrap" id="time_record" style="width:100%">
                    <thead align="center">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h1 class="mt-3 mb-3">Jumlah Penghitung Waktu Nova</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="row" id="infografis">
                    <?php foreach ($kategori->result_array() as $ktgcard) { ?>
                    <div class="col-md-6 col-lg-3 mt-3">
                        <div class="card text-dark">
                            <div class="card-header border-warning"><?=$ktgcard['nama']; ?>
                                <?php if ($ktgcard['id'] != 1): ?>
                                <a id="hidektg" href="javascript:void(0)" data-idktg="<?=$ktgcard['id']; ?>">
                                    <div class="float-right">
                                        <i class="fa fa-eye-slash"></i>
                                    </div>
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <i class="fa fa-<?=$ktgcard['icon']; ?> fa-5x"></i>
                                    </div>
                                    <div class="col-9 text-right">
                                        <?php $statistik = $this->Period_model->jumlahPeriod($ktgcard['nama']); ?>
                                        <div class="huge"><?=$statistik['time']; ?></div>
                                        <div><?=$statistik['prop']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-6 col-lg-3 mt-3">
                        <div class="card text-dark">
                            <a id="newktg" href="#">
                                <div class="card-header border-success">+ Add
                                    <div class="float-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <i class="fa fa-plus fa-5x"></i>
                                        </div>
                                        <div class="col-9 text-right">
                                            <div class="huge">New</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card text-light">
                            <a id="archived" href="javascript:void(0)">
                                <div class="card-header bg-dark border-danger">Archived
                                    <div class="float-right">
                                        <i class="fa fa-folder-open"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
    var BaseURL = "<?=base_url() ?>";
    </script>
    <script src="<?=base_url('assets/'); ?>js/stopwatch.js"></script>
    <script src="https://kit.fontawesome.com/3c5643e4eb.js" crossorigin="anonymous"></script>

</body>

</html>
