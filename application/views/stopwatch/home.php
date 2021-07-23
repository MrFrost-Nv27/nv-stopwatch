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
                        <div class="form-group" id="list-kategori">
                            <label for="ketogori-selector">Pilih Kategori :</label>
                            <select class="form-control" id="ketogori-selector" name="kategori-selector">
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
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card text-light">
                            <a href="javascript:void(0)" role="button" data-toggle="modal" data-target="#staticBackdrop"
                                id="tombolhidektglist">
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

    <!-- Modal -->
    <div class="modal fade text-dark" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Arsip Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="archived">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="formadd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="FormAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddktg">
                        <div class="form-group">
                            <label for="add-namaktg" class="col-form-label">Nama Kategori :</label>
                            <input type="text" class="form-control" id="add-namaktg" required>
                            <div class="invalid-feedback">Masukkan nama kategori lain!</div>
                            <div class="valid-feedback">Nama kategori tersedia</div>
                        </div>
                        <div class="form-group">
                            <label for="add-iconktg" class="col-form-label">Ikon : </label>
                            <input type="text" class="form-control" id="add-iconktg" required>
                            <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&q=blog&m=free" target="_blank">
                                <div class="float-right">
                                    Cek Ikon <i class="fa fa-arrow-circle-right"></i>
                                </div>
                            </a>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="tomboladd">Tambah</button>
                </div>
                </form>
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
    <script src="<?=base_url('assets/'); ?>js/data.js"></script>
    <script src="<?=base_url('assets/'); ?>js/stopwatch.js"></script>
    <script src="https://kit.fontawesome.com/3c5643e4eb.js" crossorigin="anonymous"></script>

</body>

</html>
