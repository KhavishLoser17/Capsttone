document.addEventListener('DOMContentLoaded', () => {
    const itemsPerPage = 10;

    // Function to initialize pagination for a given list
    function initPagination(listId, prevButtonId, nextButtonId, pageNumId) {
        const list = document.getElementById(listId);
        const allItems = Array.from(list.children); // Convert list items to array for easier manipulation
        const totalItems = allItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        let currentPage = 1;

        // References to pagination controls
        const prevButton = document.getElementById(prevButtonId);
        const nextButton = document.getElementById(nextButtonId);
        const pageNum = document.getElementById(pageNumId);

        // Function to display items for the current page
        function displaySchedules(page) {
            allItems.forEach((item, index) => {
                item.style.display = 'none'; // Hide all items
            });

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Show only items for the current page
            allItems.slice(start, end).forEach((item) => {
                item.style.display = 'flex';
            });
        }

        // Update pagination buttons based on the current page
        function handlePagination() {
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;
            pageNum.textContent = `Page ${currentPage} of ${totalPages}`;
        }

        // Event listener for "Previous" button
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displaySchedules(currentPage);
                handlePagination();
            }
        });

        // Event listener for "Next" button
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                displaySchedules(currentPage);
                handlePagination();
            }
        });

        // Initialize display and pagination for the first page
        displaySchedules(currentPage);
        handlePagination();
    }

    // Initialize pagination for each list
    initPagination('overtime-list', 'prev-overtime', 'next-overtime', 'page-num-overtime');
    initPagination('attendance-list', 'prev-attendance', 'next-attendance', 'page-num-attendance');
});
