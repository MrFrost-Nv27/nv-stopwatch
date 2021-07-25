refresh();
const STORAGE_KEY = "NV_STOPWATCH";
const STORAGE_KEY2 = "NV_STOPWATCH_KTG";
let startTime = 0;
let ctgSelected = "";

// Declare variables to use in our functions below
let elapsedTime = 0;
let timerInterval;
let dipausin = "N";
let tanggalpause;

// Create event listeners

let playButton = document.getElementById("playButton");
let pauseButton = document.getElementById("pauseButton");
let resetButton = document.getElementById("resetButton");

$("#ketogori-selector").prop("disabled", false);
var datatimer = $("#time_record").DataTable({
	processing: true,
	responsive: true,
	ajax: BaseURL + "stopwatch/datatimer",
	stateSave: true,
	order: [],
});

function refresh() {
	$.ajax({
		url: BaseURL + "stopwatch/listktg",
		success: function (data) {
			$("#list-kategori").html(data);
		},
	});
	$.ajax({
		url: BaseURL + "stopwatch/listhidektg",
		success: function (data) {
			$("#archived").html(data);
		},
	});
	$.ajax({
		url: BaseURL + "stopwatch/datastatistik",
		success: function (data) {
			$("#infografis").html(data);
		},
	});
}
function isStorageExist() {
	if (typeof Storage === undefined) {
		alert("Browser kamu tidak mendukung local storage");
		return false;
	}
	return true;
}

function saveData() {
	localStorage.setItem(STORAGE_KEY, startTime);
	localStorage.setItem(STORAGE_KEY2, ctgSelected);
	document.dispatchEvent(new Event("ondatasaved"));
}

function loadDataFromStorage() {
	const serializedData = localStorage.getItem(STORAGE_KEY);
	const serializedData2 = localStorage.getItem(STORAGE_KEY2);

	let data = parseInt(serializedData);
	let data2 = serializedData2;

	if (data) {
		startTime = data;
		ctgSelected = data2;
		document.dispatchEvent(new Event("ondataloaded"));
	}
}

function updateDataToStorage() {
	if (isStorageExist()) saveData();
}

function timeToString(time) {
	let diffInHrs = time / 3600000;
	let hh = Math.floor(diffInHrs);

	let diffInMin = (diffInHrs - hh) * 60;
	let mm = Math.floor(diffInMin);

	let diffInSec = (diffInMin - mm) * 60;
	let ss = Math.floor(diffInSec);

	let diffInMs = (diffInSec - ss) * 100;
	let ms = Math.floor(diffInMs);

	let formattedHH = hh.toString().padStart(2, "0");
	let formattedMM = mm.toString().padStart(2, "0");
	let formattedSS = ss.toString().padStart(2, "0");
	let formattedMS = ms.toString().padStart(2, "0");

	if (time <= 3600000) {
		return `${formattedMM}:${formattedSS}:${formattedMS}`;
	} else {
		return `${formattedHH}:${formattedMM}:${formattedSS}`;
	}
}

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
	ctgSelected = $("#ketogori-selector").val();
	$("#ketogori-selector").prop("disabled", true);
	updateDataToStorage();
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
						refresh();
					},
				});
			}
			if (dipausin == "Y") {
				wktins = elapsedTime;
				$.ajax({
					url: BaseURL + "stopwatch/ktghide",
					method: "post",
					data: {
						tanggal: tanggalpause,
						waktu: wktins,
					},
					success: function (data) {
						datatimer.ajax.reload(null, false);
						refresh();
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
							refresh();
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
							refresh();
						},
					});
				}
				clearInterval(timerInterval);
				print("00:00:00");
				elapsedTime = 0;
				showButton("PLAY");
				$("#ketogori-selector").prop("disabled", false);
				dipausin = "N";
				localStorage.removeItem(STORAGE_KEY);
				localStorage.removeItem(STORAGE_KEY2);
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

playButton.addEventListener("click", start);
pauseButton.addEventListener("click", pause);
resetButton.addEventListener("click", reset);

function refreshDataFromWaktu() {
	elapsedTime = Date.now() - startTime;
	timerInterval = setInterval(function printTime() {
		elapsedTime = Date.now() - startTime;
		print(timeToString(elapsedTime));
	}, 10);
	showButton("PAUSE");
}
