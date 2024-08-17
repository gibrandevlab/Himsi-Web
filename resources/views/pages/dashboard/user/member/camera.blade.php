@extends('layouts.main')

@section('content')
<div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center py-5 px-5">
        <div id="reader" style="width: 360px" class="border border-primary rounded shadow"></div>
        <span class="info-message my-3 text-capitalize"></span>
        <button id="startScan" class="btn btn-primary mt-3">Mulai Pemindaian</button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.1/html5-qrcode.min.js" integrity="sha512-cuVnjPNH3GyigomLiyATgpCoCmR9T3kwjf94p0BnSfdtHClzr1kyaMHhUmadydjxzi1pwlXjM5sEWy4Cd4WScA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const infoMessage = document.querySelector(".info-message");
        const startScanButton = document.getElementById("startScan");

        let html5QrCode;
        let cameraStream;

        const startScanning = () => {
            infoMessage.innerText = "Memulai pemindaian...";
            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 180,
                        height: 180
                    },
                },
                (decodedText, decodedResult) => {
                    infoMessage.innerText = "Berhasil scan";

                    // Menghentikan pemindaian
                    html5QrCode.stop().then(() => {
                        if (cameraStream) {
                            cameraStream.getTracks().forEach(track => track.stop());
                        }
                    }).catch(err => {
                        console.error("Error stopping the scanner:", err);
                    });

                    // Mengirim hasil scan ke backend
                    fetch("{{ route('scan.process') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                decodedText: decodedText
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                infoMessage.innerText = data.message;
                                // Tampilkan data yang ditemukan atau redirect
                                if (data.redirect) {
                                    window.location.href = data.redirect; // Arahkan ke URL
                                }
                            } else {
                                infoMessage.innerText = data.message;
                            }
                        })
                        .catch(error => {
                            infoMessage.innerText = "Error: " + error;
                        });
                },
                (errorMessage) => {
                    infoMessage.innerText = "Kode QR tidak terdeteksi: " + errorMessage;
                }
            ).catch((err) => {
                infoMessage.innerText = "Error: " + err;
            });
        }

        startScanButton.addEventListener("click", () => {
            infoMessage.innerText = "Meminta izin akses kamera...";

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        // Permission granted, now start scanning
                        cameraStream = stream;
                        infoMessage.innerText = "Izin akses kamera diberikan.";
                        startScanning();
                    })
                    .catch(err => {
                        // Permission denied or error occurred
                        infoMessage.innerText = "Izin akses kamera ditolak: " + err.message;
                    });
            } else {
                infoMessage.innerText = "Browser tidak mendukung akses kamera.";
            }
        });

        // Debug: List available media devices
        navigator.mediaDevices.enumerateDevices()
            .then(devices => {
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                console.log("Available video devices:", videoDevices);
                if (videoDevices.length === 0) {
                    infoMessage.innerText = "Tidak ada kamera ditemukan.";
                }
            })
            .catch(err => {
                console.error("Error enumerating devices:", err);
            });
    });
</script>
@endpush
