$(document).ready(function() {
    // Delete button
    let studentIdToDelete = null;

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        studentIdToDelete = $(this).data('id');
        $('#deleteModal').fadeIn(200);
    });

    $('#cancelDelete').click(function() {
        studentIdToDelete = null;
        $('#deleteModal').fadeOut(200);
    });

    $('#confirmDelete').click(function() {
        if (studentIdToDelete) {
            $.ajax({
                url: 'actions/delete_student.php',
                type: 'POST',
                data: { id: studentIdToDelete },
                success: function(response) {
                    response = response.trim();
                    if (response === 'success') {
                        $('a.btn-delete[data-id="'+studentIdToDelete+'"]').closest('tr')
                            .fadeOut(500, function() { $(this).remove(); });
                        $('#deleteModal').fadeOut(200);
                    } else {
                        alert('Error deleting student.');
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
    function searchStudents() {
        let query = $('#searchInput').val().trim();
        let filter = $('#filterSelect').val();

        $.ajax({
            url: 'actions/search_student.php',
            type: 'POST',
            data: { query: query, filter: filter },
            success: function(response) {
                $('table tbody').html(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error searching students.');
            }
        });
    }

    $('#searchInput').on('keyup', searchStudents);
    $('#filterSelect').on('change', searchStudents);
});
