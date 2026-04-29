<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php
    include 'includes/db.php';
?>

    <!-- Top Navigation Bar -->
    <nav class="navbar">
        <div class="nav-brand">
            <img src="images/logo.jpeg" id="logo" alt="Logo">
            <span class="brand-text">StudentHub</span>
        </div>
        <div class="nav-links">
            <button class="navbarbuttons" onclick="showSection('create')">
                <span class="btn-icon">&#10010;</span> Create
            </button>
            <button class="navbarbuttons" onclick="showSection('read')">
                <span class="btn-icon">&#9783;</span> Read
            </button>
            <button class="navbarbuttons" onclick="showSection('update')">
                <span class="btn-icon">&#9998;</span> Update
            </button>
            <button class="navbarbuttons btn-danger" onclick="showSection('delete')">
                <span class="btn-icon">&#10006;</span> Delete
            </button>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="main-container">

        <!-- Home Section -->
        <section id="home" class="homecontent">
            <div class="home-card">
                <div class="home-icon">&#127891;</div>
                <h1 class="splash-title">Student Management System</h1>
                <p class="splash-subtitle">A Project in Integrative Programming Technologies</p>
                <div class="home-divider"></div>
                <p class="splash-desc">Manage student records with ease. Use the navigation above to Create, Read, Update, or Delete student entries.</p>
                <div class="home-stats">
                    <?php
                        $students = getStudents();
                        $totalStudents = count($students);
                    ?>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $totalStudents; ?></span>
                        <span class="stat-label">Total Students</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">4</span>
                        <span class="stat-label">Operations</span>
                    </div>
                </div>
            </div>

            <!-- Troll Area -->
            <div id="troll-area" style="position: fixed; bottom: 24px; right: 24px; display: flex; align-items: center; gap: 12px; z-index: 9999;">
                <img src="images/logo.jpeg" alt="Rick Logo" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #00ffcc; box-shadow: 0 4px 12px rgba(0, 255, 204, 0.3);">
                <button id="troll-btn" class="troll-btn" title="Surprise!" onclick="playRickroll()">click here</button>
            </div>
        </section>

        <!-- Create Section -->
        <section id="create" class="content">
            <div class="section-card">
                <div class="card-header">
                    <span class="card-icon">&#10010;</span>
                    <h1 class="contenttitle">Insert New Student</h1>
                </div>

                <form action="includes/insert.php" method="POST">
                    <div class="form-group">
                        <label for="surname" class="label">Surname</label>
                        <input type="text" name="surname" id="surname" class="field" placeholder="Enter surname" required>
                    </div>

                    <div class="form-group">
                        <label for="name" class="label">Name</label>
                        <input type="text" name="name" id="name" class="field" placeholder="Enter first name" required>
                    </div>

                    <div class="form-group">
                        <label for="middlename" class="label">Middle Name</label>
                        <input type="text" name="middlename" id="middlename" class="field" placeholder="Enter middle name">
                    </div>

                    <div class="form-group">
                        <label for="address" class="label">Address</label>
                        <input type="text" name="address" id="address" class="field" placeholder="Enter address">
                    </div>

                    <div class="form-group">
                        <label for="contact" class="label">Mobile Number</label>
                        <input type="text" name="contact" id="contact" class="field" placeholder="Enter mobile number">
                    </div>

                    <div id="btncontainer">
                        <button type="button" id="clrbtn" class="btns btn-secondary" onclick="clearFields()">Clear Fields</button>
                        <button type="submit" id="savebtn" class="btns btn-primary">Save Student</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Read Section -->
        <section id="read" class="content">
            <div class="section-card section-card-wide">
                <div class="card-header">
                    <span class="card-icon">&#9783;</span>
                    <h1 class="contenttitle">View Students</h1>
                </div>

                <div class="table-wrapper">
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Surname</th>
                                <th>Name</th>
                                <th>Middle Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $students = getStudents();

                                if (count($students) > 0) {
                                    foreach ($students as $row) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['middlename']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='empty-row'>No records found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Update Section -->
        <section id="update" class="content">
            <div class="section-card">
                <div class="card-header">
                    <span class="card-icon">&#9998;</span>
                    <h1 class="contenttitle">Update Student Record</h1>
                </div>

                <form method="POST" action="index.php" class="search-form">
                    <div class="form-group form-inline">
                        <label for="search_id" class="label">Student ID</label>
                        <input type="number" name="search_id" id="search_id" class="field" placeholder="Enter student ID" required value="<?php echo isset($_POST['search_id']) ? intval($_POST['search_id']) : ''; ?>">
                        <button type="submit" name="search_update" class="btns btn-primary btn-search">Search</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['search_update'])) {
                    $search_id = intval($_POST['search_id']);
                    $students = getStudents();
                    $student = null;
                    foreach ($students as $s) {
                        if ($s['id'] == $search_id) {
                            $student = $s;
                            break;
                        }
                    }

                    if ($student !== null) {
                ?>
                <div class="divider"></div>
                <form action="includes/update.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

                    <div class="form-group">
                        <label for="update_surname" class="label">Surname</label>
                        <input type="text" name="surname" id="update_surname" class="field" value="<?php echo htmlspecialchars($student['surname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="update_name" class="label">Name</label>
                        <input type="text" name="name" id="update_name" class="field" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="update_middlename" class="label">Middle Name</label>
                        <input type="text" name="middlename" id="update_middlename" class="field" value="<?php echo htmlspecialchars($student['middlename']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="update_address" class="label">Address</label>
                        <input type="text" name="address" id="update_address" class="field" value="<?php echo htmlspecialchars($student['address']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="update_contact" class="label">Mobile Number</label>
                        <input type="text" name="contact" id="update_contact" class="field" value="<?php echo htmlspecialchars($student['contact_number']); ?>">
                    </div>

                    <div id="btncontainer">
                        <button type="button" class="btns btn-secondary" onclick="clearFields()">Clear Fields</button>
                        <button type="submit" class="btns btn-primary">Update Student</button>
                    </div>
                </form>
                <?php
                    } else {
                        echo "<div class='alert alert-error'>No student found with ID: $search_id</div>";
                    }
                }
                ?>
            </div>
        </section>

        <!-- Delete Section -->
        <section id="delete" class="content">
            <div class="section-card">
                <div class="card-header">
                    <span class="card-icon card-icon-danger">&#10006;</span>
                    <h1 class="contenttitle">Remove Student Record</h1>
                </div>

                <form method="POST" action="index.php" class="search-form">
                    <div class="form-group form-inline">
                        <label for="delete_search_id" class="label">Student ID</label>
                        <input type="number" name="delete_search_id" id="delete_search_id" class="field" placeholder="Enter student ID" required value="<?php echo isset($_POST['delete_search_id']) ? intval($_POST['delete_search_id']) : ''; ?>">
                        <button type="submit" name="search_delete" class="btns btn-primary btn-search">Search</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['search_delete'])) {
                    $search_id = intval($_POST['delete_search_id']);
                    $students = getStudents();
                    $student = null;
                    foreach ($students as $s) {
                        if ($s['id'] == $search_id) {
                            $student = $s;
                            break;
                        }
                    }

                    if ($student !== null) {
                ?>
                <div class="divider"></div>
                <div class="student-details">
                    <h3 class="details-title">Student Details</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">ID</span>
                            <span class="detail-value"><?php echo $student['id']; ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Surname</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student['surname']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Name</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student['name']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Middle Name</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student['middlename']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Address</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student['address']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student['contact_number']); ?></span>
                        </div>
                    </div>
                </div>

                <form action="includes/delete.php" method="POST" id="deleteForm">
                    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                    <button type="submit" class="btns btn-delete" formnovalidate>
                        &#128465; Delete Student
                    </button>
                </form>
                <?php
                    } else {
                        echo "<div class='alert alert-error'>No student found with ID: $search_id</div>";
                    }
                }
                ?>
            </div>
        </section>

    </main>

    <!-- Toast Notifications -->
    <div id="success-toast" class="toast toast-hidden toast-success">
        &#10004; Registration Successful!
    </div>
    <div id="update-toast" class="toast toast-hidden toast-success">
        &#10004; Record Updated Successfully!
    </div>
    <div id="delete-toast" class="toast toast-hidden toast-success">
        &#10004; Record Deleted Successfully!
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
    <?php if (isset($_POST['search_update'])): ?>
    <script>showSection('update');</script>
    <?php endif; ?>
    <?php if (isset($_POST['search_delete'])): ?>
    <script>showSection('delete');</script>
    <?php endif; ?>
</body>
</html>
