document.addEventListener('DOMContentLoaded', () => {
    function toggleAddRow() {
        const addRowDiv = document.querySelector('.add-row');
        if (addRowDiv) {
            addRowDiv.style.display = addRowDiv.style.display === 'flex' ? 'none' : 'flex';
        }
    }

    // Attach the toggle function to the "Add Categories" button
    const addButton = document.querySelector('.btn-group button:first-child');
    if (addButton) {
        addButton.addEventListener('click', toggleAddRow);
    }
});
