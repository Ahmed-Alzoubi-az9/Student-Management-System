$(document).ready(function() {
    // Per-module endpoints (students default for backward compatibility)
    var cfg = window.AppConfig || {
        deleteUrl: 'actions/delete_student.php',
        searchUrl: 'actions/search_student.php'
    };

    // Delete button
    let itemToDelete = null;

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        itemToDelete = $(this).data('id');
        $('#deleteModal').fadeIn(200);
    });

    $('#cancelDelete').click(function() {
        itemToDelete = null;
        $('#deleteModal').fadeOut(200);
    });

    $('#confirmDelete').click(function() {
        if (itemToDelete) {
            $.ajax({
                url: cfg.deleteUrl,
                type: 'POST',
                data: { id: itemToDelete },
                success: function(response) {
                    response = response.trim();
                    if (response === 'success') {
                        $('a.btn-delete[data-id="'+itemToDelete+'"]').closest('tr')
                            .fadeOut(500, function() { $(this).remove(); });
                        $('#deleteModal').fadeOut(200);
                    } else {
                        alert('Error deleting record.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('AJAX error occurred: ' + error);
                }
            });
        }
    });

    // Search & Filter
    function searchItems() {
        let query = $('#searchInput').val().trim();
        let filter = $('#filterSelect').val();

        $.ajax({
            url: cfg.searchUrl,
            type: 'POST',
            data: { query: query, filter: filter },
            success: function(response) {
                $('table tbody').html(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error searching.');
            }
        });
    }

    $('#searchInput').on('keyup', searchItems);
    $('#filterSelect').on('change', searchItems);
});
