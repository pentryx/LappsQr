<!DOCTYPE html>
<html>
<head>
    <title>Et Qr Çözücü</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px; /* logo ile yazı arası boşluk */
        }

        .header img {
            height: 140px; /* logo boyutu */
            width: auto;
        }

        .header .school-name {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        text-align: left;
        
        #startButton {
        font-size: 24px; /* yazı boyutu büyütüldü */
        display: none; /* Butonu gizle */
        font-weight: bold; /* yazıyı kalın yapar */
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-transform: uppercase; /* tüm harfleri büyük yapar */
        box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* gölge efekti */
        transition: all 0.3s ease; /* hover efekti için yumuşak geçiş */
        }

        #startButton:hover {
        background-color: #45a049; /* hover durumunda renk değişimi */
        transform: scale(1.05); /* hover durumunda hafif büyüme */
        box-shadow: 0 6px 12px rgba(0,0,0,0.3); /* hover durumunda gölge artışı */
        }

        #reader {
            width: 100%;
            max-width: 380px;
            max-height: 380px
            margin: 0 auto;
            display: block; /* reader'ı direkt görünür yap */
        }

        #result {
        display: none;
        font-size: 48px;
        font-color: red;
        }

        .decrypted {
        font-size: 48px;
        font-color: red;
        }

        .original {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .error {
            color: #f44336;
            margin-top: 10px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
</head>
<body>
    <div class="header">
        <img src="logo.png" alt="Okul Logo">
        <div class="school-name">Akyazı Cumhuriyet Ortaokulu</div>
    </div><br>
    <h2 color="red"><div id="result"></div></h2><br>
    <div id="reader"></div>
    

 <script>
        let html5QrcodeScanner = null;

        function decryptAES(encryptedText) {
            try {
                // Gelen metni sayıya çevir
                let number = parseFloat(encryptedText);
                
                if (isNaN(number)) {
                    throw new Error("Geçerli bir sayı değil");
                }

                // 5'e böl
                let step1 = number / 13;
                
              // İkinci karekök
                let finalResult = Math.sqrt(step1);
                
                // Sonucu tam sayıya çevir
                finalResult = Math.round(finalResult);
                
                return `
                   ${finalResult}
                `;
                
            } catch (e) {
                console.error("İşlem hatası:", e);
                return "İşlem hatası: " + e.message;
            }
        }

        // Sayfa yüklendiğinde çalışacak
        window.onload = function() {
            startScanner();
        };

        function startScanner() {
            html5QrcodeScanner = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: { width: 380, height: 380 },
                aspectRatio: 0.5
            };

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        onScanSuccess
                    ).catch(err => {
                        console.error("Kamera başlatma hatası:", err);
                        alert("Kamera başlatılamadı. Lütfen kamera iznini kontrol edin.");
                    });
                }
            }).catch(err => {
                console.error("Kamera listesi alınamadı:", err);
                alert("Kameralar listelenemiyor. Lütfen kamera iznini kontrol edin.");
            });
        }

        function onScanSuccess(encryptedText) {
            const resultElement = document.getElementById('result');
            resultElement.style.display = 'block';
            
            try {
                const decryptedText = decryptAES(encryptedText);
                
                resultElement.innerHTML = `
                    <div class="decrypted">
                        <strong>Kod: </strong>
                        ${decryptedText}
                    </div>
                `;

                // Başarılı tarama sesi
                let audio = new Audio('data:audio/mp3;base64,SUQzBAAAAAAAI1RTU0UAAAAPAAADTGF2ZjU4Ljc2LjEwMAAAAAAAAAAAAAAA//OEAAAAAAAAAAAAAAAAAAAAAAAASW5mbwAAAA8AAAAeAAAgAABITExMTExMTGhoaGhoaGiEhISEhISEnJycnJycnLi4uLi4uLjQ0NDQ0NDQ7Ozs7Ozs7P////////////////////8AAAAATGF2YzU4LjEzAAAAAAAAAAAAAAAAJAYAAAAAAAAAIAAs/+MYxAAAAANIAAAAAExBTUUzLjEwMFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//MYxDsAAANIAAAAAFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//MYxHYAAANIAAAAAFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//MYxLEAAANIAAAAAFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV');
                audio.play();
            } catch (error) {
                resultElement.innerHTML = `
                    <div class="error">
                        İşlem hatası: ${error.message}
                    </div>
                    <div class="original">
                        <strong>Okunan Değer:</strong><br>
                        ${encryptedText}
                    </div>
                `;
            }
        }
    </script>
</body>
</html>