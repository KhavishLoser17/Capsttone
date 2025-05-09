<div id="loadingScreen" class="fixed inset-0 flex flex-col items-center justify-center bg-gray-50 z-[99999]">
    <div class="w-64 md:w-96 h-3 bg-gray-300 rounded-full relative">
        <div id="progressBar" class="relative h-full bg-blue-500 rounded-full relative flex items-center" style="width: 0%;">
            <img id="progressImage" src="{{ asset('img/loading.png') }}" alt="Loading Image" class="absolute w-12 -top-10">
        </div>
    </div>
    <p id="loadingText" class="mt-2 text-blue-500">Loading...</p>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const progressBar = document.getElementById('progressBar');
        const progressImage = document.getElementById('progressImage');
        const loadingText = document.getElementById('loadingText');

        let itemsLoaded = 0;
        const totalItems = document.querySelectorAll('img, script, link').length;

        function updateProgress() {
            itemsLoaded++;
            const progress = Math.min((itemsLoaded / totalItems) * 100, 100);
            progressBar.style.width = progress + '%';

            // Ensure the image stays within the bounds of the progress bar
            const progressBarWidth = progressBar.parentElement.clientWidth;
            progressImage.style.transform = `translateX(${(progressBarWidth * (progress / 100)) - (progressImage.clientWidth / 2)}px)`;

            loadingText.textContent = `Loading... ${Math.round(progress)}%`;

            if (progress >= 100) {
                document.getElementById('loadingScreen').style.display = 'none';
            }
        }

        document.querySelectorAll('img, script, link').forEach(item => {
            item.addEventListener('load', updateProgress);
            item.addEventListener('error', updateProgress);
        });

        window.onload = function() {
            progressBar.style.width = '100%';
            progressImage.style.transform = `translateX(${progressBar.parentElement.clientWidth - (progressImage.clientWidth / 2)}px)`;
            loadingText.textContent = 'Loading... 100%';
            setTimeout(() => {
                document.getElementById('loadingScreen').style.display = 'none';
            }, 300);
        };
    });
</script>


