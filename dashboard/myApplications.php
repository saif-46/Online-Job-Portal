<?php include "../includes/conn.php"; ?>
<?php include "../includes/indexHeader.php"; ?>

<body>
  <?php include "../includes/indexNavbar.php"; ?>

  <div class="dashboard-container">
    <?php include "./dashboardSidebar.php"; ?>
    <div class="dashboard-content-container">
      <?php if (($_SESSION['role_id']) == 1) : ?>
        <div class="applied-jobs-section">
          <h2>Your Applied Jobs</h2>
          <div class="applied-jobs-list">
            <?php
            $id_user = $_SESSION['id_user']; // Get the user ID from session

            // SQL query to fetch applied jobs with company name, application date, and deadline
            $sql = "SELECT distinct
                        jp.id_jobpost AS JobPostID, 
                        jp.jobtitle AS JobTitle, 
                        jp.description AS JobDescription, 
                        c.companyname AS CompanyName, 
                        aj.createdat AS ApplicationDate,
                        jp.deadline AS JobDeadline 
                    FROM applied_jobposts aj 
                    INNER JOIN job_post jp ON aj.id_jobpost = jp.id_jobpost 
                    INNER JOIN company c ON jp.id_company = c.id_company 
                    WHERE aj.id_user = '$id_user' 
                    ORDER BY aj.createdat DESC";
            $query = $conn->query($sql);

            if ($query->num_rows > 0) {
              // Loop through the results and display each applied job
              while ($row = $query->fetch_assoc()) {
                echo "<div class='job-card'>";
                
                // Display job title
                echo "<h3>" . htmlspecialchars($row['JobTitle']) . "</h3>";
                
                // Display job description
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['JobDescription']) . "</p>";
                
                // Display company name
                echo "<p><strong>Company:</strong> " . htmlspecialchars($row['CompanyName']) . "</p>";
                
                // Display application date
                echo "<p><strong>Application Date:</strong> " . htmlspecialchars($row['ApplicationDate']) . "</p>";
                
                // Display job deadline
                echo "<p><strong>Deadline:</strong> " . htmlspecialchars($row['JobDeadline']) . "</p>";
                
                echo "</div>";
              }
            } else {
              // If no jobs found
              echo "<p class='no-jobs'>You have not applied for any jobs yet.</p>";
            }
            ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <style>
    .applied-jobs-section {
      margin: 20px;
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .applied-jobs-section h2 {
      margin-bottom: 20px;
      font-size: 1.8rem;
      color: #333;
    }

    .applied-jobs-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .job-card {
      padding: 15px;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      transition: box-shadow 0.3s ease;
    }

    .job-card h3 {
      margin-bottom: 10px;
      font-size: 1.5rem;
      color: #007BFF;
    }

    .job-card p {
      margin-bottom: 10px;
      font-size: 1rem;
      color: #555;
    }

    .job-card a.view-details {
      text-decoration: none;
      color: #fff;
      background-color: #007BFF;
      padding: 8px 12px;
      border-radius: 4px;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
    }

    .job-card a.view-details:hover {
      background-color: #0056b3;
    }

    .job-card:hover {
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .no-jobs {
      font-size: 1.2rem;
      color: #999;
      text-align: center;
    }
  </style>
</body>
