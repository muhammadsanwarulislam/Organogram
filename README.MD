# Organogram Management Package for Laravel

A comprehensive Laravel package for managing organizational structures, specifically designed for any kind of government offices or organization. This package provides tools to visualize organograms, manage employee data, and streamline reporting relationships.

## ✨ Features

- **Organizational Hierarchy Management**: Create and manage complex organizational structures
- **Visual Organogram Tree**: Interactive tree visualization of organizational hierarchy
- **Employee Management**: Comprehensive employee data management
- **Multi-language Support**: Built-in support for Bangla and English
- **RESTful API**: Complete API endpoints for integration with frontend applications
- **Database Migrations**: Ready-to-use database schema
- **Sample Data Seeder**: Pre-configured sample data for quick setup
- **Responsive Frontend**: Beautiful, mobile-friendly interface
- **Laravel Integration**: Seamless integration with Laravel applications

## 📋 Requirements

- PHP 8.0 or higher
- Laravel 10, 11, or 12
- MySQL 5.7

## 🚀 Installation

### 1. Install via Composer

```bash
composer require sanwarul/organogram
```

### 2. Install Package (Recommended)

The package includes an installation command that will set up everything:

```bash
php artisan organogram:install
```

This command will:
- Run migrations
- Publish seeders
- Seed the database with sample data
- Optionally install the frontend


## 📖 Usage

### Creating Organizations

```php
use Sanwarul\Organogram\Models\Organization;

$ministry = Organization::create([
    'name' => 'Ministry of Public Administration',
    'code' => 'MOPA',
    'type' => 'ministry',
    'address' => 'Bangladesh Secretariat, Dhaka',
    'phone' => '02-12345678',
    'email' => 'mopa@mopa.gov.bd',
]);

// Add Bangla translation
$ministry->setTranslation('name', 'bn', 'জনপ্রশাসন মন্ত্রণালয়');
$ministry->save();
```

### Creating Sub-organizations

```php
$division = Organization::create([
    'name' => 'Public Administration Division',
    'code' => 'PAD',
    'type' => 'division',
    'parent_id' => $ministry->id,
    'address' => 'Bangladesh Secretariat, Dhaka',
    'phone' => '02-87654321',
    'email' => 'pad@mopa.gov.bd',
]);
```

### Retrieving Organizational Tree

```php
$tree = Organization::with('children')->whereNull('parent_id')->get();
```

## 🔌 API Endpoints

The package provides the following API endpoints:

### Organizations

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/organizations` | List all organizations |
| POST | `/api/organizations` | Create new organization |
| GET | `/api/organizations/{id}` | Get organization details |
| PUT | `/api/organizations/{id}` | Update organization |
| DELETE | `/api/organizations/{id}` | Delete organization |

### Organogram

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/organogram/{id}` | Get organization tree |
| GET | `/api/organogram/{id}/employees` | Get employees in organization |


## 🗄️ Database Schema

### Organizations Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Organization name |
| code | string | Unique code |
| type | string | Organization type (ministry, division, department, office) |
| parent_id | bigint | Foreign key to parent organization |
| address | text | Physical address |
| phone | string | Contact phone |
| email | string | Contact email |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Employees Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Employee name |
| position_id | bigint | Foreign key to position |
| department_id | bigint | Foreign key to department |
| organization_id | bigint | Foreign key to organization |
| email | string | Email address |
| phone | string | Phone number |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

## 📊 Sample Data Structure

The package seeds a sample organizational structure:

```
Ministry of Public Administration (MOPA)
└── Public Administration Division (PAD)
    └── Chief Information Commissioner Office (CICO)
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 🔒 Security

If you discover any security related issues, please email muhammad.sanwarul94@gmail.com instead of using the issue tracker.

## 👨‍💻 Credits

- [Sanwarul Islam](https://github.com/muhammadsanwarulislam)
- [All Contributors](../../contributors)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 🆘 Support

If you are having general issues with the package, feel free to reach out to me:

- Email: muhammad.sanwarul94@gmail.com
- LinkedIn: [Sanwarul Islam](https://www.linkedin.com/in/sanwarul/)
- GitHub: [muhammadsanwarulislam](https://github.com/muhammadsanwarulislam)
