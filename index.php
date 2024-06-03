<?php
require __DIR__.'/boot.php';

if (!isset($_SESSION['is_auth'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Объявления</title>
</head>
<body>
    <h1>Объявления</h1>
    <a href="logout.php">Выйти</a>
    <form id="adForm" method="POST" action="post_ad.php">
        <label for="text">Новое объявление:</label>
        <textarea name="ad_text" id="text" required style="display: block !important;"></textarea>
        <button type="submit">Опубликовать</button>
    </form>
    <div id="ads"></div>
    <script>
        document.getElementById('adForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('post_ad.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const adsDiv = document.getElementById('ads');
                    const newAd = document.createElement('div');
                    newAd.textContent = data.ad_text;
                    adsDiv.appendChild(newAd);
                    this.reset();
                } else {
                    alert('Ошибка публикации объявления.');
                }
            });
        });

        fetch('ads.php')
        .then(response => response.json())
        .then(data => {
            const adsDiv = document.getElementById('ads');
            data.ads.forEach(ad => {
                const adDiv = document.createElement('div');
                adDiv.textContent = ad.ad_text;
                adsDiv.appendChild(adDiv);
            });
        });
    </script>
</body>
</html>
