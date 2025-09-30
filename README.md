# GUVI_HCL TASK - ‼️User Management System

### 1. Registration Page
![Profile Screenshot](assets/Screenshot%202025-10-01%20004618.png)

### 2. Login Page
![Login Screenshot](assets/Screenshot%202025-10-01%20004604.png)

### 3. Profile Update Page
![Home Screenshot](assets/Screenshot%202025-10-01%20004546.png)


## Complete Setup Guide

### Prerequisites Installation

#### 1. Install XAMPP
- Download XAMPP from: https://www.apachefriends.org/download.html
- Install to default location: `C:\xampp`
- Start Apache and MySQL from XAMPP Control Panel

#### 2. Install MongoDB Community Server
- Download from: https://www.mongodb.com/try/download/community
- Install with default settings
- MongoDB will run as Windows service automatically
- Default port: 27017

#### 3. Install Redis for Windows
- Download from: https://github.com/microsoftarchive/redis/releases
- Extract to `C:\redis`
- Run `redis-server.exe` to start Redis
- Default port: 6379

#### 4. Install PHP Extensions

**For Redis Extension:**
1. Download `php_redis.dll` from: https://pecl.php.net/package/redis
2. Copy to `C:\xampp\php\ext\`
3. Add to `C:\xampp\php\php.ini`:
   ```ini
   extension=redis
   ```

**For MongoDB Extension:**
1. Download `php_mongodb.dll` from: https://pecl.php.net/package/mongodb
2. Copy to `C:\xampp\php\ext\`
3. Add to `C:\xampp\php\php.ini`:
   ```ini
   extension=mongodb
   ```

### Database Setup

#### 1. MySQL Database Setup
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Choose `database_setup.sql` file
4. Click "Go" to execute

**OR via MySQL Command Line:**
```bash
cd C:\xampp\mysql\bin
mysql -u root -p
source D:\Guvi_030\database_setup.sql
```

#### 2. MongoDB Setup
- MongoDB will automatically create the database and collection
- Database: `user_management`
- Collection: `profiles`

#### 3. Redis Setup
- No initial setup required
- Redis will store session data automatically

### Installation Steps

#### Using XAMPP 
1. Copy entire project folder to `C:\xampp\htdocs\`
2. Rename folder to `user_management`
3. Start XAMPP Control Panel
4. Start Apache and MySQL services
5. Start MongoDB service (if not auto-started)
6. Start Redis server: `C:\redis\redis-server.exe`
7. Access: `http://localhost/user_management/`


### Verification Steps

#### Check Services are Running:
```bash
# Check MySQL
tasklist | findstr "mysqld.exe"

# Check MongoDB
tasklist | findstr "mongod.exe"

# Check Apache (if using XAMPP)
tasklist | findstr "httpd.exe"

# Check Redis
tasklist | findstr "redis"
```

#### Test Database Connections:
1. **MySQL**: Access phpMyAdmin at `http://localhost/phpmyadmin`
2. **MongoDB**: Use MongoDB Compass or command line
3. **Redis**: Use Redis CLI: `redis-cli ping`

### Application Features

- **User Registration**: Secure account creation with validation
- **User Authentication**: Login with email/password
- **Profile Management**: Update personal details (age, DOB, contact, address)
- **Session Management**: Redis backend + localStorage frontend
- **Security**: Password hashing, prepared statements, session validation

### Tech Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5, jQuery
- **Backend**: PHP 7.4+
- **Databases**: MySQL 8.0+ (credentials), MongoDB 4.4+ (profiles)
- **Cache**: Redis 6.0+ (sessions)
- **Communication**: jQuery AJAX

### Project Structure
```
Guvi_030/
├── assets/           # Static assets
├── css/
│   └── style.css     # Custom styles
├── js/
│   ├── login.js      # Login functionality
│   ├── profile.js    # Profile management
│   └── register.js   # Registration logic
├── php/
│   ├── login.php     # Login API
│   ├── profile.php   # Profile API
│   └── register.php  # Registration API
├── index.html        # Landing page
├── login.html        # Login form
├── profile.html      # Profile dashboard
├── register.html     # Registration form
├── database_setup.sql # MySQL schema
└── README.md         # This file
```

### Application Flow
1. **Registration** → MySQL stores user credentials
2. **Login** → Validates credentials, creates Redis session
3. **Profile** → MongoDB stores/retrieves profile data

### Quick Start Commands

```bash
# Start all services (run each in separate command prompt)
C:\xampp\apache\bin\httpd.exe
C:\xampp\mysql\bin\mysqld.exe
mongod
C:\redis\redis-server.exe

# Access application
http://localhost/user_management/
```
