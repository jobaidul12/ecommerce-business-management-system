A full-stack e-commerce web application for browsing and ordering traditional Bangladeshi fashion — Sarees and Panjabis. Built with PHP, MySQL, and Vanilla JavaScript.

🌟 Key Features

User registration, login, and session management
Product browsing with category filters and live search
Shopping cart with quantity control and delivery options
Order placement with Cash on Delivery support
Personal profile dashboard with full order history and status tracking
AJAX-powered contact form


🛠️ Tech Stack
FrontendHTML5, CSS3, JavaScriptBackendPHPDatabaseMySQLServerXAMPP

🗄️ Database
Database name: project_db
Four tables — users, orders, order_items, and contact_messages — connected through foreign key relationships to keep data clean and normalized.

🚀 Getting Started

Clone the repo and move it to your XAMPP htdocs folder
Start Apache and MySQL from the XAMPP Control Panel
Open phpMyAdmin, create a database named project_db, and import database.sql
Visit http://localhost/sajbari-fashion-house/ in your browser


Default DB credentials in php/db.php are root with no password. Update if yours differ.


🔐 Security
Passwords are hashed using password_hash(). All database queries use prepared statements to prevent SQL injection. Access to profile and order data is protected by PHP session checks.

👨‍💻 Team
NameStudent IDMd. Jobaidul Islam242-008-042Asib Hossen242-011-042Ziaur Rahman Arnab242-045-042
Supervisor: Halima Mowla — Lecturer, CSE Department, Primeasia University# ecommerce-business-management-system
