# Guljar_WP_php_form
# 📇 Contact Manager Pro

A modern, feature-rich contact management system built with PHP, MySQL, and vanilla JavaScript.

## ✨ Features

- ✅ **Add, Edit, Delete Contacts** - Full CRUD functionality
- 🎨 **Modern UI Design** - Beautiful gradient design with smooth animations
- 📱 **Fully Responsive** - Works perfectly on desktop, tablet, and mobile
- 🔔 **Toast Notifications** - Real-time feedback for all actions
- ✏️ **Inline Editing** - Edit contacts directly from the list
- 🔍 **Form Validation** - Client-side and server-side validation
- 🎯 **Clean Code** - Well-structured, secure, and maintainable

## 🛠️ Technologies Used

- **Backend**: PHP 7.4+ with PDO
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Design**: Modern gradient UI with smooth animations

## 📋 Prerequisites

Before you begin, ensure you have:

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server (or XAMPP/WAMP/MAMP)
- Web browser (Chrome, Firefox, Safari, Edge)

## 🚀 Installation

### Step 1: Clone or Download

Download the project files to your web server directory:
```
your-webroot/
├── index.php
├── style.css
├── scripts.js
└── database.sql
```

### Step 2: Setup Database

1. Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`)
2. Click on "SQL" tab
3. Copy and paste the entire content from `database.sql`
4. Click "Go" to execute

**OR** use MySQL command line:
```bash
mysql -u root -p < database.sql
```

### Step 3: Configure Database Connection

Open `index.php` and update the database credentials (lines 2-5):

```php
$host = 'localhost';        // Usually 'localhost'
$dbname = 'contacts_db';    // Database name
$username = 'root';         // Your MySQL username
$password = '';             // Your MySQL password
```

### Step 4: Access the Application

Open your web browser and navigate to:
```
http://localhost/your-folder-name/index.php
```

Or if using XAMPP:
```
http://localhost/contact-manager/index.php
```

## 📁 File Structure

```
project/
│
├── index.php          # Main application file (PHP + HTML)
├── style.css          # All styles and animations
├── scripts.js         # JavaScript for interactivity
├── database.sql       # Database schema and sample data
└── README.md          # This file
```

## 🎯 Usage

### Adding a Contact
1. Fill in the form on the left side
2. Enter Name, Email, and Phone
3. Click "➕ Add Contact"
4. Success notification will appear

### Editing a Contact
1. Click the ✏️ (Edit) icon on any contact
2. Form will populate with contact data
3. Make your changes
4. Click "💾 Update Contact"

### Deleting a Contact
1. Click the 🗑️ (Delete) icon
2. Confirm the deletion
3. Contact will be removed

## 🔒 Security Features

- **PDO Prepared Statements** - Prevents SQL injection
- **Input Sanitization** - XSS protection with htmlspecialchars()
- **CSRF Protection** - POST/Redirect/GET pattern
- **Data Validation** - Both client and server-side

## 🎨 Customization

### Change Color Scheme

Edit `style.css` and modify the gradient colors:

```css
/* Main gradient */
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Button gradient */
.btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Modify Database Structure

To add more fields (e.g., address, company):

1. Update `database.sql` table structure
2. Add input fields in the form section of `index.php`
3. Update the INSERT/UPDATE queries
4. Add table columns in the display section

## 🐛 Troubleshooting

### "Connection failed" Error
- Check database credentials in `index.php`
- Ensure MySQL server is running
- Verify database `contacts_db` exists

### Page Shows PHP Code
- Ensure you're using a PHP-enabled server (Apache/Nginx)
- Access via `localhost`, not by opening file directly
- Check that PHP is properly installed

### Styling Not Working
- Verify `style.css` is in the same folder as `index.php`
- Check browser console for 404 errors
- Clear browser cache (Ctrl+F5)

### JavaScript Not Working
- Verify `scripts.js` is in the same folder
- Check browser console for errors
- Ensure file name is exactly `scripts.js` (case-sensitive on Linux)

## 🔄 Recent Updates

- ✅ Fixed file naming inconsistencies
- ✅ Enhanced CSS with modern gradients
- ✅ Improved form validation
- ✅ Better responsive design
- ✅ Added database setup file
- ✅ Security improvements

## 📝 Database Schema

```sql
contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

## 🤝 Contributing

Feel free to fork, modify, and use this project for:
- Learning PHP and MySQL
- Building your own contact manager
- Creating similar CRUD applications

## 📄 License

This project is open-source and free to use for personal and commercial projects.

## 💡 Tips

- **Keyboard Shortcut**: Press `Ctrl+K` to focus on the name input
- **Quick Delete**: Hold Shift while clicking delete to skip confirmation (coming soon)
- **Backup**: Regularly export your database from phpMyAdmin

## 🆘 Support

If you encounter issues:
1. Check the Troubleshooting section
2. Verify all files are in the correct location
3. Ensure database is properly configured
4. Check browser console for JavaScript errors
5. Check PHP error logs

## 🎓 Learning Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/)

---

**Made with ❤️ for learning and productivity**

Happy Contact Managing! 🎉
