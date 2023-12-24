@extends('layouts.sidebar')
@section('content')

<style>
  /* Centering the modals */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  width: 300px;
  text-align: center;
}
  .close {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
  }

  input {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
  }

  button:hover {
    background-color: #0056b3;
  }

  /* Style for delete modal confirmation button */
  #confirmDelete {
    background-color: #dc3545;
  }

  /* Center the modals horizontally */
  .modal-content {
    display: inline-block;
  }
</style>



<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
   

  <div class="card">
       <h5 class=" mt-3 mb-2 pl-3">All Users</h5>
       <hr>
      <div class="card-body">
            <table id="userTable" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Update</th>
                <th style="width:100px;display:none;">API KEY</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertype }}</td>
                    
                     <td>
        <button class="update-btn" data-user-id="{{ $user->id }}">Update</button>
        <button class="delete-btn" data-user-id="{{ $user->id }}">Delete</button>
        <td style="width:100px;display:none;">{{ $user->api_key }}</td>
    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
      </div>
  </div>
</div>
<!-- Update User Modal -->
<div id="updateUserModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <input type="text" id="updateUserName" placeholder="Name">
        <input type="text" id="updateUserEmail" placeholder="Email">
        <textarea id="updateUserApiKey" placeholder="API Key" class="form-control"></textarea>

        <button id="updateUser">Update</button>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Are you sure you want to delete this user?</p>
        <button id="confirmDelete">Delete</button>
        <button id="cancelDelete">Cancel</button>
    </div>
</div>
<script>
  // Function to show the Update User Modal
  function showUpdateModal() {
    document.getElementById("updateUserModal").style.display = "block";
  }

  // Function to show the Delete User Modal
  function showDeleteModal() {
    document.getElementById("deleteUserModal").style.display = "block";
  }

  // Event listeners to show the modals when buttons are clicked
  document.querySelector(".update-btn").addEventListener("click", showUpdateModal);
  document.querySelector(".delete-btn").addEventListener("click", showDeleteModal);

  // Function to close the modals
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
  }

  // Event listeners to close the modals when the close button is clicked
  document.querySelectorAll(".close").forEach((closeButton) => {
    closeButton.addEventListener("click", function () {
      closeModal(this.getAttribute("data-modal-id"));
    });
  });

  // Event listener to close the modals when the background is clicked
  window.addEventListener("click", function (event) {
    if (event.target.classList.contains("modal")) {
      closeModal(event.target.id);
    }
  });
</script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
<script>
    $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".update-btn").click(function () {
        var userId = $(this).data("user-id");
        var userRow = $(this).closest("tr");
        var userName = userRow.find("td:eq(0)").text();
        var userEmail = userRow.find("td:eq(1)").text();
        var userKEY = userRow.find("td:eq(4)").text();

        // Fill the Update User Modal fields
        $("#updateUserName").val(userName);
        $("#updateUserEmail").val(userEmail);
        $("#updateUserApiKey").val(userKEY);

        // Show the Update User Modal
        $("#updateUserModal").show();

        // Handle the Update button click
        $("#updateUser").click(function () {
            var updatedName = $("#updateUserName").val();
            var updatedEmail = $("#updateUserEmail").val();
            var updatedApiKey = $("#updateUserApiKey").val();

            // Make an AJAX request to update the user
            $.ajax({
                type: "POST",
                url: "/updateUser", // Replace with your backend endpoint
                data: {
                     _token: $('meta[name="csrf-token"]').attr('content'), 
                    userId: userId,
                    name: updatedName,
                    email: updatedEmail,
                    api_key: updatedApiKey,
                },
                success: function (response) {
                    // Handle the response
                    // Close the modal
                    $("#updateUserModal").hide();
                },
            });
        });
    });

    // Delete button click event
    $(".delete-btn").click(function () {
        var userId = $(this).data("user-id");

        // Show the Delete User Modal
        $("#deleteUserModal").show();

        // Handle the Delete button click
        $("#confirmDelete").click(function () {
            // Make an AJAX request to delete the user
            $.ajax({
                type: "POST",
                url: "/deleteUser", // Replace with your backend endpoint
                data: {
                     _token: $('meta[name="csrf-token"]').attr('content'), 
                    userId: userId,
                },
                success: function (response) {
                    // Handle the response
                    // Close the modal
                    $("#deleteUserModal").hide();
                },
            });
        });

        // Handle the Cancel button click
        $("#cancelDelete").click(function () {
            // Close the modal
            $("#deleteUserModal").hide();
        });
    });

    // Close modals when the close button is clicked
    $(".close").click(function () {
        $(this).closest(".modal").hide();
    });
});

</script>
@endsection
