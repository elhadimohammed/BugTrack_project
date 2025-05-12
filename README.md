# 🐞 Bug Tracking System

A full-stack web application built to manage and track software bugs and defects submitted by users. It includes roles for Admin, Staff, and Customer with role-based dashboards and actions.

## 🚀 Features

### 👤 Customer
- Register, login, and logout
- Submit new bug reports with attachments (images/PDFs)
- View, edit, and delete submitted bugs
- Track bug status and case flow
- Comment on bugs
- Rate resolved bugs (1–5 stars)

### 🧑‍💻 Staff
- View bugs assigned to them
- Submit solution messages (internal)
- Mark bugs as resolved
- Reassign bugs to another staff member
- Add internal comments

### 👑 Admin
- Manage all submitted bugs
- Assign bugs to staff members
- Create and manage projects
- View all comments
- Manage and deactivate users

## 🛠 Tech Stack

| Layer         | Technology             |
|---------------|-------------------------|
| Frontend      | HTML, CSS,              |
| Backend       | PHP                     |
| Database      | Microsoft SQL Server    |
| Connection    | ODBC (using `odbc_connect`) |
| Web Server    | Apache (via XAMPP)      |
| Platform      | Windows (XAMPP + SQL Server Express) |

## 📂 Folder Structure

```
BugTrack_project/
├── assets/
│   ├── css/
│   │   └── style.css             
├── uploads/                      # Stores user-submitted screenshots
├── includes/
│   ├── db.php                    # Centralized DB connection
│   ├── header.php                # Common HTML <head> + top nav
│   ├── footer.php                # Common footer HTML
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── register.php
├── dashboards                   # Entry point: detects role
├── bugs/
│   ├── submitBugReport.php       # Customer form
│   ├── bugList.php               # Admin master list
│   ├── assignBug.php
│   ├── reassignBug.php
│   ├── resolveBug.php
│   ├── viewBug.php               # View a single bug with details
│   └── rateBug.php
├── comments/
│   ├── viewComments.php
│   └── addComment.php
├── projects/
│   └── createProject.php
├── users/
│   └── manageUsers.php
├── README.md
└── index.php                     # Optional landing page
```

## 🧪 Testing Checklist

- ✅ Works on `http://localhost/BugTrack_project`
- ✅ Separate dashboards for Admin, Staff, Customer
- ✅ File upload tested for JPG, PNG, PDF
- ✅ Data persists in SQL Server DB
- ✅ Session-based login/logout secure
- ✅ Tested on multiple roles & flows

## 📝 Setup Instructions

1. Clone/download the project to `C:\xampp\htdocs\BugTrack_project`
2. Start **XAMPP**:
   - Start **Apache**
   - Ensure **SQL Server** is running
3. Create the DB:
   - Use `BugTrack_project.sql` (or use provided queries)
4. Set DB login in `db.php`
5. Visit `http://localhost/BugTrack_project/auth/login.php`

## 👨‍💻 Developer

- 🧑 Developed by: **[Our Team]**
- 🎓 For: *CS251 – Software Engineering 1, Spring 2025*
