// Convert time to a format of hours, minutes, seconds, and milliseconds
$(document).ready(function () {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	$("#ketogori-selector").prop("disabled", false);

	$.ajax({
		url: BaseURL + "stopwatch/datatimer",
		success: function (data) {
			console.log(data);
		},
	});

	var datatimer = $("#time_record").DataTable({
		processing: true,
		responsive: true,
		ajax: BaseURL + "stopwatch/datatimer",
		stateSave: true,
		order: [],
	});

	function timeToString(time) {
		let diffInHrs = time / 3600000;
		let hh = Math.floor(diffInHrs);

		let diffInMin = (diffInHrs - hh) * 60;
		let mm = Math.floor(diffInMin);

		let diffInSec = (diffInMin - mm) * 60;
		let ss = Math.floor(diffInSec);

		let diffInMs = (diffInSec - ss) * 100;
		let ms = Math.floor(diffInMs);

		let formattedMM = mm.toString().padStart(2, "0");
		let formattedSS = ss.toString().padStart(2, "0");
		let formattedMS = ms.toString().padStart(2, "0");

		return `${formattedMM}:${formattedSS}:${formattedMS}`;
	}

	// Declare variables to use in our functions below

	let startTime;
	let elapsedTime = 0;
	let timerInterval;
	let dipausin = "N";
	let tanggalpause;

	// Create function to modify innerHTML

	function print(txt) {
		document.getElementById("display").innerHTML = txt;
	}

	// Create "start", "pause" and "reset" functions

	function start() {
		startTime = Date.now() - elapsedTime;
		timerInterval = setInterval(function printTime() {
			elapsedTime = Date.now() - startTime;
			print(timeToString(elapsedTime));
		}, 10);
		showButton("PAUSE");
		$("#ketogori-selector").prop("disabled", true);
	}

	function pause() {
		var ktgins = $("#ketogori-selector").val();
		var wktins = "";
		var tglins = startTime;
		Swal.fire({
			title: "Pause Stopwatch",
			text: "Apakah anda yakin akan mempause stopwatch ini ? data anda akan tersimpan sementara",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Pause",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				clearInterval(timerInterval);
				showButton("PLAY");
				if (dipausin == "N") {
					swal.close();
					wktins = elapsedTime;
					$.ajax({
						url: BaseURL + "stopwatch/recins",
						method: "post",
						data: {
							kategori: ktgins,
							tanggal: tglins,
							waktu: wktins,
						},
						success: function (data) {
							const dataku = JSON.parse(data);
							tanggalpause = dataku.start;
							datatimer.ajax.reload(null, false);
							dipausin = "Y";
						},
					});
				}
				if (dipausin == "Y") {
					wktins = elapsedTime;
					$.ajax({
						url: BaseURL + "stopwatch/recupd",
						method: "post",
						data: {
							tanggal: tanggalpause,
							waktu: wktins,
						},
						success: function (data) {
							datatimer.ajax.reload(null, false);
						},
					});
				}
			}
		});
	}

	function reset() {
		var ktgins = $("#ketogori-selector").val();
		var wktins = 0;
		var tglins = startTime;
		if (elapsedTime != 0) {
			Swal.fire({
				title: "Hentikan Stopwatch",
				text: "Apakah anda yakin akan menghentikan stopwatch ini ? Setelah dihentikan maka penghitung waktu ini akan direkam dan disimpan kedalam database",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Hentikan",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					if (dipausin == "N") {
						wktins = elapsedTime;
						$.ajax({
							url: BaseURL + "stopwatch/recins",
							method: "post",
							data: {
								kategori: ktgins,
								tanggal: tglins,
								waktu: wktins,
							},
							success: function (data) {
								datatimer.ajax.reload(null, false);
							},
						});
					}
					if (dipausin == "Y") {
						wktins = elapsedTime;
						$.ajax({
							url: BaseURL + "stopwatch/recupd",
							method: "post",
							data: {
								tanggal: tanggalpause,
								waktu: wktins,
							},
							success: function (data) {
								datatimer.ajax.reload(null, false);
							},
						});
					}
					clearInterval(timerInterval);
					print("00:00:00");
					elapsedTime = 0;
					showButton("PLAY");
					$("#ketogori-selector").prop("disabled", false);
					dipausin = "N";
				}
			});
		}
	}

	// Create function to display buttons

	function showButton(buttonKey) {
		const buttonToShow = buttonKey === "PLAY" ? playButton : pauseButton;
		const buttonToHide = buttonKey === "PLAY" ? pauseButton : playButton;
		buttonToShow.style.display = "block";
		buttonToHide.style.display = "none";
	}
	// Create event listeners

	let playButton = document.getElementById("playButton");
	let pauseButton = document.getElementById("pauseButton");
	let resetButton = document.getElementById("resetButton");

	playButton.addEventListener("click", start);
	pauseButton.addEventListener("click", pause);
	resetButton.addEventListener("click", reset);

	$("#time_record").on("click", "#tombolhapus", function () {
		var idrecord = $(this).data("idrow");
		Swal.fire({
			title: "Hapus Data",
			text: "Anda ingin menghapus data ini ? Harap tinjau kembali sebelum menghapus data",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Hapus",
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			cancelButtonText: "Tidak",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: BaseURL + "stopwatch/recdel",
					method: "post",
					beforeSend: function () {
						swal.fire({
							title: "Menunggu",
							html: "Memproses data",
							didOpen: () => {
								swal.showLoading();
							},
						});
					},
					data: {
						idrecord: idrecord,
					},
					success: function (data) {
						swal.fire("Hapus", "Berhasil Terhapus", "success");
						datatimer.ajax.reload(null, false);
					},
				});
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal.fire("Batal", "Anda membatalkan penghapusan", "error");
			}
		});
	});

	$("#newktg").click(function (e) {
		return false;
	});
});
