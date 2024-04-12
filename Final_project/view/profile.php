<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="homepage.php">BookishBabble</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../login/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Picture -->
                <div class="profile-picture">
                    <img id="profileImage" src="<?php echo $_SESSION['picturePath'] ?>" alt="Profile Picture">
                </div>
                <!-- Edit Picture Button -->
                <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                <button class="btn btn-secondary mt-3" onclick="chooseProfilePicture()">Edit Picture</button>
            </div>
            <div class="col-md-8">
                <!-- Profile Details -->
                <div class="profile-details">
                    <h2><?php echo $_SESSION['username'] ?></h2>
                    <p>Joined: <?php echo $_SESSION['joined'] ?></p>
                    <!-- Bio Section -->
                    <div id="bioSection">
                        <p><strong>Bio:</strong> <?php echo $_SESSION['bio'] ?></p>
                        <!-- Edit Bio Button -->
                        <button class="btn btn-secondary" onclick="editBio()">Edit Bio</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Bio Modal -->
        <div class="modal fade" id="editBioModal" tabindex="-1" aria-labelledby="editBioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBioModalLabel">Edit Bio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="newBio" rows="4" placeholder="Enter your new bio"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitBio()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function chooseProfilePicture() {
            document.getElementById("profilePictureInput").click();
        }

        document.getElementById("profilePictureInput").addEventListener("change", function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("profileImage").src = e.target.result;
            }
            reader.readAsDataURL(file);
        });

        function editBio() {
            document.getElementById('newBio').value = '<?php echo $_SESSION['bio'] ?>';
            $('#editBioModal').modal('show');
        }

        function submitBio() {
            const newBio = document.getElementById('newBio').value;
            fetch("../actions/changeBio.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ bio: newBio }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data['success'] === true) {
                    window.location.href = "../actions/setSessionBio.php?bio=" + encodeURIComponent(data['newbio']);
                }
            });
        }
    </script>
</body>
</html>
