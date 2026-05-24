Discover Saudi (اكتشف السعودية)
A dynamic, full-stack web application designed to showcase the rich cultural and geographical diversity of Saudi Arabia. This platform features an interactive public gallery and a secure administrative dashboard for complete content management.

🔗 Live Demo
Public Website: https://discover-saudi.onrender.com

Admin Dashboard: https://discover-saudi.onrender.com/admin/login.php

Demo Access Credentials:

Username: admin

Password: 123456
(Note: These credentials are provided for portfolio demonstration and grading purposes only).

🚀 Features
Public Facing (Client-Side)
Responsive Design: Fully responsive UI utilizing CSS Grid and Flexbox for seamless viewing across mobile, tablet, and desktop screens.

Interactive Filtering: Real-time search and custom alphabetical sorting logic that natively handles Arabic prefixes (e.g., ignoring "ال").

Relational Data Display: Dynamic rendering of regions and their associated historical/tourist landmarks through One-to-Many database queries.

State Management: Persistent "Dark Mode" implemented via JavaScript localStorage.

Administrative (Server-Side)
Secure Authentication: Session-based login ($_SESSION) restricting access to the dashboard.

Complete CRUD Operations: Create, Read, Update, and Delete functionality for both Regions and Places.

Advanced File Upload Security: * Strict MIME-type validation (getimagesize).

File extension allow-listing.

Auto-generation of unique, hashed filenames (uniqid) to prevent overwrite conflicts and malicious script execution.

Flash Messaging: Temporary UI alerts for successful database operations, self-clearing upon refresh.

🛠️ Tech Stack
Frontend: HTML5, CSS3 (Custom Variables, Media Queries), Vanilla JavaScript.

Backend: PHP 8.1

Database: PostgreSQL (Hosted on Neon DB)

Data Access: PHP Data Objects (PDO) with Prepared Statements for SQL Injection prevention.

Infrastructure: Docker, Apache.

🗄️ Database Schema
The application relies on a strictly typed relational database structure:

admin: Stores administrative credentials securely.

id (PK, Serial), username (Varchar), password (Varchar)

regions: Stores primary geographical locations.

id (PK, Serial), name (Varchar), description (Text), image (Varchar)

places: Stores specific landmarks mapped to regions.

id (PK, Serial), region_id (FK to regions.id), name (Varchar), description (Text), image (Varchar)

💻 Local Setup & Installation
If you wish to run this project locally, you can use Docker.

Using Docker (Recommended)
