$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    var table = $('#orderTable').DataTable({
        ajax: {
            url: "/api/orders",
            dataSrc: ""
        },
        columns: [
            { data: 'id', title: 'Order ID' },
            { data: 'customer.name', title: 'Customer Name' },
            { data: 'customer.address', title: 'Address' },
            { data: 'courier', title: 'Courier' },
            { data: 'payment_method', title: 'Payment Method' },
            { data: 'order_status', title: 'Status' },
            { data: 'created_at', title: 'Date Ordered' },
            {
                data: null,
                title: 'Change Status',
                render: function (data, type, row) {
                    return `<button class="btn btn-warning change-status-btn" data-id="${row.id}" data-status="${row.order_status}">Change Status</button>`;
                }
            },
            {
                data: null,
                title: 'Delete',
                render: function (data, type, row) {
                    return `<button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>`;
                }
            }
        ],
        responsive: true,
        order: [[0, 'asc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            emptyTable: "No data available in table"
        }
    });

    $('#orderTable tbody').on('click', 'button.change-status-btn', function () {
        var orderId = $(this).data('id');
        var orderStatus = $(this).data('status');

        $('#orderName').val(orderId);
        $('#statusDropdown').val(orderStatus);
        $('#orderId').val(orderId);

        $('#changeStatusModal').modal('show');
    });

    $('#saveStatusBtn').on('click', function () {
        var orderId = $('#orderId').val();
        var orderStatus = $('#statusDropdown').val();

        $.ajax({
            type: "PUT",
            url: `/api/orders/${orderId}/status`,
            data: {
                status: orderStatus
            },
            success: function () {
                $('#changeStatusModal').modal('hide');
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#orderTable tbody').on('click', 'button.delete-btn', function () {
        var orderId = $(this).data('id');
        var $row = $(this).closest('tr');

        $.ajax({
            type: "DELETE",
            url: `/api/orders/${orderId}`,
            success: function () {
                table.row($row).remove().draw();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});
