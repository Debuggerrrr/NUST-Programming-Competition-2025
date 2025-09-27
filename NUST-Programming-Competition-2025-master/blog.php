<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - MESMTF Medical Expert System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <style>
        :root {
            --primary-color: #1a5276;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --card-bg: #ffffff;
            --section-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--section-bg);
            color: #333;
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), #154360);
            padding: 0.8rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .nav-logo {
            height: 40px;
            margin-right: 10px;
            border-radius: 5px;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 8px 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(rgba(26, 82, 118, 0.9), rgba(26, 82, 118, 0.8)), url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0 60px;
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .page-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }

        /* Main Content Layout */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Sidebar */
        .sidebar {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .sidebar-section {
            margin-bottom: 30px;
        }

        .sidebar-section h3 {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
        }

        .category-list {
            list-style: none;
            padding: 0;
        }

        .category-list li {
            margin-bottom: 10px;
        }

        .category-list a {
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 0;
            transition: all 0.3s ease;
        }

        .category-list a:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        .category-list a i {
            margin-right: 10px;
            color: var(--secondary-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 15px 10px;
            background: var(--light-color);
            border-radius: 8px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #666;
        }

        /* Reviews Grid */
        .reviews-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .review-card {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--secondary-color);
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .review-info {
            flex: 1;
        }

        .review-info h3 {
            margin: 0 0 5px;
            font-size: 1.3rem;
            color: var(--primary-color);
        }

        .review-author {
            color: #7f8c8d;
            font-style: italic;
            margin-bottom: 5px;
        }

        .review-date {
            color: #95a5a6;
            font-size: 0.9rem;
        }

        .delete-review-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #bdc3c7;
            transition: all 0.3s ease;
            padding: 5px;
        }

        .delete-review-btn:hover {
            color: var(--danger-color);
        }

        .review-content {
            color: #555;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .review-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .review-tag {
            background: #e8f4fc;
            color: var(--secondary-color);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .review-tag:hover {
            background: var(--secondary-color);
            color: white;
        }

        .review-actions {
            display: flex;
            gap: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            background: none;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 6px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            color: #666;
        }

        .action-btn:hover {
            background: #f5f5f5;
        }

        .action-btn.liked {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .action-btn.hearted {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .action-btn.subscribed {
            color: var(--success-color);
            border-color: var(--success-color);
        }

        .action-count {
            font-weight: 600;
            margin-left: 3px;
        }

        /* Add Review Button */
        .add-review-container {
            text-align: center;
            margin: 30px 0;
        }

        .add-review-btn {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .add-review-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        /* Review Form Modal */
        .review-form-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .review-form-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .close-form {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #7f8c8d;
        }

        .review-form-content h3 {
            margin-top: 0;
            color: var(--primary-color);
        }

        .review-form-content label {
            display: block;
            margin: 15px 0 5px;
            font-weight: 500;
        }

        .review-form-content input,
        .review-form-content textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
        }

        .submit-review-btn {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-review-btn:hover {
            background: linear-gradient(135deg, #2980b9, var(--secondary-color));
        }

        /* Language Switcher */
        .lang-switcher-container {
            position: absolute;
            top: 90px;
            right: 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .lang-label {
            margin-right: 10px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .lang-select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        /* Footer */
        footer {
            background: var(--primary-color);
            color: white;
            padding: 50px 0 20px;
            margin-top: 50px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .footer-logo-img {
            height: 50px;
            margin-right: 15px;
            border-radius: 5px;
        }

        .footer-heading {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }

        .contact-info p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .contact-icon {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: static;
                margin-bottom: 30px;
            }
            
            .lang-switcher-container {
                position: static;
                justify-content: center;
                margin: 20px 0;
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            
            .page-header p {
                font-size: 1rem;
            }
            
            .review-header {
                flex-direction: column;
            }
            
            .review-avatar {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .review-actions {
                flex-wrap: wrap;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-placeholder">
                    <img src="images/Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>
                MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diagnosis.php">Diagnosis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Language Switcher -->
    <div class="lang-switcher-container">
        <label for="langSelect" class="lang-label">Language:</label>
        <select id="langSelect" class="lang-select">
            <option value="en">English</option>
            <option value="de">German</option>
            <option value="af">Afrikaans</option>
            <option value="os">Oshiwambo</option>
        </select>
    </div>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>User Reviews</h1>
            <p>See what our users are saying about the Medical Expert System for Malaria and Typhoid Fever</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-wrapper">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-section">
                    <h3>Review Categories</h3>
                    <ul class="category-list">
                        <li><a href="diagnosis.php"><i class="fas fa-stethoscope"></i> Diagnosis</a></li>
                        <li><a href="../auth/login.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                        
                    </ul>
                </div>
                
                <div class="sidebar-section">
                    <h3>Review Stats</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number">128</span>
                            <span class="stat-label">Total Reviews</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">4.8</span>
                            <span class="stat-label">Average Rating</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">94%</span>
                            <span class="stat-label">Positive</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">32</span>
                            <span class="stat-label">This Month</span>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-section">
                    <h3>Filter Reviews</h3>
                    <div class="mb-3">
                        <label for="sortSelect" class="form-label">Sort by:</label>
                        <select class="form-select" id="sortSelect">
                            <option>Newest First</option>
                            <option>Oldest First</option>
                            <option>Highest Rated</option>
                            <option>Most Liked</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tagFilter" class="form-label">Filter by tag:</label>
                        <select class="form-select" id="tagFilter">
                            <option>All Tags</option>
                            <option>Reliable</option>
                            <option>Quick</option>
                            <option>Helpful</option>
                            <option>Accurate</option>
                            <option>Easy to use</option>
                        </select>
                    </div>
                </div>
            </aside>

            <!-- Reviews Content -->
            <main class="reviews-content">
                <!-- Add Review Button -->
                <div class="add-review-container">
                    <button id="addReviewBtn" class="add-review-btn">
                        <div><i class="fas fa-plus-circle"></i></div>Add Your Review
                    </button>
                </div>

                <!-- Reviews Grid -->
                <div class="reviews-grid">
                    <!-- Review Card 1 -->
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="review-info">
                                <h3>Fast & Accurate Diagnosis</h3>
                                <div class="review-author">Sarah M.</div>
                                <div class="review-date">Posted on March 15, 2025</div>
                            </div>
                            <button class="delete-review-btn" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="review-content">
                            I used the system when I felt malaria symptoms, and it quickly gave me an accurate diagnosis. 
                            It saved me a trip to the hospital and helped me start treatment early. Truly life-saving!
                        </div>
                        <div class="review-tags">
                            <a class="review-tag">Reliable</a>
                            <a class="review-tag">Quick</a>
                            <a class="review-tag">Helpful</a>
                            <a class="review-tag">Accurate</a>
                        </div>
                        <div class="review-actions">
                            <button class="action-btn like-btn">
                                <i class="far fa-thumbs-up"></i> <span class="action-count">24</span>
                            </button>
                            <button class="action-btn heart-btn">
                                <i class="far fa-heart"></i> <span class="action-count">18</span>
                            </button>
                            <button class="action-btn subscribe-btn">
                                <i class="far fa-bell"></i> <span class="action-count">12</span>
                            </button>
                        </div>
                    </div>

                    <!-- Review Card 2 -->
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="review-info">
                                <h3>AI Expert Feels Like a Doctor</h3>
                                <div class="review-author">James K.</div>
                                <div class="review-date">Posted on March 12, 2025</div>
                            </div>
                            <button class="delete-review-btn" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="review-content">
                            The AI Expert is incredible. I entered my symptoms and it explained the possible conditions clearly, 
                            even suggesting what I should do next. It feels like having a doctor with me all the time.
                        </div>
                        <div class="review-tags">
                            <a class="review-tag">24/7 Help</a>
                            <a class="review-tag">Easy to use</a>
                            <a class="review-tag">Guided Support</a>
                            <a class="review-tag">Smart System</a>
                        </div>
                        <div class="review-actions">
                            <button class="action-btn like-btn">
                                <i class="far fa-thumbs-up"></i> <span class="action-count">31</span>
                            </button>
                            <button class="action-btn heart-btn">
                                <i class="far fa-heart"></i> <span class="action-count">25</span>
                            </button>
                            <button class="action-btn subscribe-btn">
                                <i class="far fa-bell"></i> <span class="action-count">19</span>
                            </button>
                        </div>
                    </div>

                    <!-- Review Card 3 -->
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="review-info">
                                <h3>Dashboard Keeps Records Safe</h3>
                                <div class="review-author">Anita L.</div>
                                <div class="review-date">Posted on March 8, 2025</div>
                            </div>
                            <button class="delete-review-btn" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="review-content">
                            After registering, I got access to my personal dashboard where I can view all my medical records. 
                            Everything is well-organized and secure, no more lost papers or missing files.
                        </div>
                        <div class="review-tags">
                            <a class="review-tag">Secure</a>
                            <a class="review-tag">Organized</a>
                            <a class="review-tag">Convenient</a>
                            <a class="review-tag">User Friendly</a>
                        </div>
                        <div class="review-actions">
                            <button class="action-btn like-btn">
                                <i class="far fa-thumbs-up"></i> <span class="action-count">17</span>
                            </button>
                            <button class="action-btn heart-btn">
                                <i class="far fa-heart"></i> <span class="action-count">14</span>
                            </button>
                            <button class="action-btn subscribe-btn">
                                <i class="far fa-bell"></i> <span class="action-count">8</span>
                            </button>
                        </div>
                    </div>

                    <!-- Review Card 4 -->
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="review-info">
                                <h3>Easy Appointment Booking</h3>
                                <div class="review-author">Daniel O.</div>
                                <div class="review-date">Posted on March 5, 2025</div>
                            </div>
                            <button class="delete-review-btn" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="review-content">
                            I was able to book an appointment directly from the system in just a few clicks. 
                            No phone calls or waiting in line it was simple, fast, and stress-free.
                        </div>
                        <div class="review-tags">
                            <a class="review-tag">Convenient</a>
                            <a class="review-tag">Fast</a>
                            <a class="review-tag">Stress-Free</a>
                            <a class="review-tag">Efficient</a>
                        </div>
                        <div class="review-actions">
                            <button class="action-btn like-btn">
                                <i class="far fa-thumbs-up"></i> <span class="action-count">22</span>
                            </button>
                            <button class="action-btn heart-btn">
                                <i class="far fa-heart"></i> <span class="action-count">16</span>
                            </button>
                            <button class="action-btn subscribe-btn">
                                <i class="far fa-bell"></i> <span class="action-count">11</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Review Form Modal -->
    <div id="reviewFormModal" class="review-form-modal">
        <div class="review-form-content">
            <span id="closeForm" class="close-form">&times;</span>
            <h3>Submit Your Review</h3>
            <form id="reviewForm">
                <label for="reviewTitle">Title:</label>
                <input type="text" id="reviewTitle" name="reviewTitle" required>

                <label for="reviewUser">Your Name:</label>
                <input type="text" id="reviewUser" name="reviewUser" required>

                <label for="reviewMessage">Review:</label>
                <textarea id="reviewMessage" name="reviewMessage" rows="4" required></textarea>

                <label for="reviewTags">Tags (comma separated):</label>
                <input type="text" id="reviewTags" name="reviewTags" placeholder="Convenient, Fast, Reliable">

                <button type="submit" class="submit-review-btn">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <div class="logo-placeholder">
                            <img src="images/Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
                        </div>
                        <div>
                            <h5 class="footer-heading">MESMTF System</h5>
                            <p>Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="about.php" class="footer-link">About</a></li>
                        <li><a href="services.php" class="footer-link">Services</a></li>
                        <li><a href="diagnosis.php" class="footer-link">Diagnosis</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Contact Us</h5>
                    <div class="contact-info">
                        <p><span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span> 13 Jackson Kaijieua Street<br>Private Bag 1388, Winbrook, NAMIBIA</p>
                        <p><span class="contact-icon"><i class="fas fa-phone"></i></span> +264 61 207 2052</p>
                        <p><span class="contact-icon"><i class="fas fa-envelope"></i></span> tfse@nust.na</p>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Follow Ministry of Health</h5>
                    <div class="social-links">
                        <a href="https://www.facebook.com/MOHSSNamibia" target="_blank" class="social-link">
                            <i class="fab fa-facebook-f"></i> 
                        </a>
                        <a href="https://twitter.com/MOHSS_Namibia" target="_blank" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.youtube.com/user/MOHSSNamibia" target="_blank" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.instagram.com/mohss_namibia" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2025 MESMTF. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Developed for Ministry of Health and Social Services</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.padding = '0.5rem 0';
                    navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
                } else {
                    navbar.style.padding = '0.8rem 0';
                    navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                }
            });

            // Elements
            const addReviewBtn = document.getElementById('addReviewBtn');
            const reviewFormModal = document.getElementById('reviewFormModal');
            const closeForm = document.getElementById('closeForm');
            const reviewForm = document.getElementById('reviewForm');
            const reviewsGrid = document.querySelector('.reviews-grid');

            // Open form
            addReviewBtn.addEventListener('click', () => {
                reviewFormModal.style.display = 'flex';
            });

            // Close form
            closeForm.addEventListener('click', () => {
                reviewFormModal.style.display = 'none';
            });

            // Submit form
            reviewForm.addEventListener('submit', (e) => {
                e.preventDefault();

                // Get values
                const title = document.getElementById('reviewTitle').value;
                const user = document.getElementById('reviewUser').value;
                const message = document.getElementById('reviewMessage').value;
                const tags = document.getElementById('reviewTags').value.split(',').map(t => t.trim());

                // Create new review card
                const newCard = document.createElement('div');
                newCard.className = 'review-card';
                newCard.innerHTML = `
                    <div class="review-header">
                        <div class="review-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="review-info">
                            <h3>${title}</h3>
                            <div class="review-author">${user}</div>
                            <div class="review-date">Posted just now</div>
                        </div>
                        <button class="delete-review-btn" title="Delete Review">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="review-content">${message}</div>
                    <div class="review-tags">
                        ${tags.map(tag => `<a class="review-tag">${tag}</a>`).join('')}
                    </div>
                    <div class="review-actions">
                        <button class="action-btn like-btn">
                            <i class="far fa-thumbs-up"></i> <span class="action-count">0</span>
                        </button>
                        <button class="action-btn heart-btn">
                            <i class="far fa-heart"></i> <span class="action-count">0</span>
                        </button>
                        <button class="action-btn subscribe-btn">
                            <i class="far fa-bell"></i> <span class="action-count">0</span>
                        </button>
                    </div>
                `;

                // Add to the top of reviews
                reviewsGrid.prepend(newCard);

                // Add event listeners to new card
                addEventListenersToCard(newCard);

                // Reset form
                reviewForm.reset();
                reviewFormModal.style.display = 'none';
            });

            // Close modal if clicked outside
            window.addEventListener('click', function(event) {
                if (event.target == reviewFormModal) {
                    reviewFormModal.style.display = 'none';
                }
            });

            // Function to add event listeners to a card
            function addEventListenersToCard(card) {
                // Delete button
                const deleteBtn = card.querySelector('.delete-review-btn');
                deleteBtn.addEventListener('click', function() {
                    card.remove();
                });

                // Like button
                const likeBtn = card.querySelector('.like-btn');
                likeBtn.addEventListener('click', function() {
                    const countSpan = likeBtn.querySelector('.action-count');
                    let count = parseInt(countSpan.textContent);
                    
                    if (likeBtn.classList.contains('liked')) {
                        count--;
                        likeBtn.classList.remove('liked');
                        likeBtn.innerHTML = '<i class="far fa-thumbs-up"></i> <span class="action-count">' + count + '</span>';
                    } else {
                        count++;
                        likeBtn.classList.add('liked');
                        likeBtn.innerHTML = '<i class="fas fa-thumbs-up"></i> <span class="action-count">' + count + '</span>';
                    }
                });

                // Heart button
                const heartBtn = card.querySelector('.heart-btn');
                heartBtn.addEventListener('click', function() {
                    const countSpan = heartBtn.querySelector('.action-count');
                    let count = parseInt(countSpan.textContent);
                    
                    if (heartBtn.classList.contains('hearted')) {
                        count--;
                        heartBtn.classList.remove('hearted');
                        heartBtn.innerHTML = '<i class="far fa-heart"></i> <span class="action-count">' + count + '</span>';
                    } else {
                        count++;
                        heartBtn.classList.add('hearted');
                        heartBtn.innerHTML = '<i class="fas fa-heart"></i> <span class="action-count">' + count + '</span>';
                    }
                });

                // Subscribe button
                const subscribeBtn = card.querySelector('.subscribe-btn');
                subscribeBtn.addEventListener('click', function() {
                    const countSpan = subscribeBtn.querySelector('.action-count');
                    let count = parseInt(countSpan.textContent);
                    
                    if (subscribeBtn.classList.contains('subscribed')) {
                        count--;
                        subscribeBtn.classList.remove('subscribed');
                        subscribeBtn.innerHTML = '<i class="far fa-bell"></i> <span class="action-count">' + count + '</span>';
                    } else {
                        count++;
                        subscribeBtn.classList.add('subscribed');
                        subscribeBtn.innerHTML = '<i class="fas fa-bell"></i> <span class="action-count">' + count + '</span>';
                    }
                });
            }

            // Add event listeners to existing cards
            document.querySelectorAll('.review-card').forEach(card => {
                addEventListenersToCard(card);
            });

            // Language switcher functionality
            const langSelect = document.getElementById('langSelect');
            langSelect.addEventListener('change', function() {
                alert('Language changed to: ' + this.options[this.selectedIndex].text);
            });

            // Navigation links
            document.querySelectorAll('.nav-link, .footer-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#' || 
                        this.getAttribute('href').includes('Modal')) {
                        e.preventDefault();
                        if (this.getAttribute('href').includes('loginModal')) {
                            alert('Login modal would open here');
                        } else if (this.getAttribute('href').includes('registerModal')) {
                            alert('Register modal would open here');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>