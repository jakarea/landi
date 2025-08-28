# Fresh Database Migration Files - Complete Summary

## Overview
This document outlines all the fresh migration files created for the Laravel Learning Management System (LMS). All previous migration files have been removed and replaced with optimized, clean migrations with proper indexing, foreign key constraints, and performance optimizations.

## Migration Files Created (31 Tables)

### Core Laravel Tables
1. **2024_01_01_000001_create_users_table.php**
   - Primary user authentication and profile table
   - Indexes: user_role, email_verified_at, last_activity_at, created_at
   - Unique constraint: email

2. **2024_01_01_000002_create_password_reset_tokens_table.php**
   - Password reset functionality
   - Primary key: email
   - Index: created_at

3. **2024_01_01_000003_create_personal_access_tokens_table.php**
   - Laravel Sanctum API tokens
   - Indexes: tokenable_type/id, last_used_at, expires_at
   - Unique constraint: token

4. **2024_01_01_000004_create_failed_jobs_table.php**
   - Queue failed jobs tracking
   - Indexes: failed_at, queue
   - Unique constraint: uuid

### Course Management Tables
5. **2024_01_01_000005_create_courses_table.php**
   - Main courses table with complete course information
   - Foreign keys: user_id, instructor_id → users
   - Indexes: user_id, instructor_id, status, price, offer_price, created_at
   - Full-text search: title, short_description, description
   - Unique constraint: slug

6. **2024_01_01_000006_create_modules_table.php**
   - Course modules/chapters
   - Foreign keys: course_id → courses, instructor_id → users
   - Indexes: course_id, instructor_id, status, reorder, publish_at
   - Unique constraint: course_id + slug

7. **2024_01_01_000007_create_lessons_table.php**
   - Individual lessons within modules
   - Foreign keys: user_id, course_id, instructor_id, module_id
   - Indexes: All foreign keys, status, type, is_public, reorder
   - Full-text search: title, short_description
   - Unique constraint: module_id + slug

### Enrollment & Payment Tables
8. **2024_01_01_000008_create_course_user_table.php**
   - Course enrollment pivot table (CourseEnrollment model)
   - Foreign keys: course_id, user_id, instructor_id → users
   - Indexes: All foreign keys, status, payment_method, paid, promo_code, created_at
   - Unique constraint: course_id + user_id
   - Status enum: payment_pending, pending, approved, rejected
   - Payment methods: bkash, nogod, rocket, cash, free_access

9. **2024_01_01_000011_create_checkouts_table.php**
   - Payment processing records
   - Foreign keys: user_id, course_id, instructor_id → users
   - Indexes: All foreign keys, payment_method, payment_status, status, is_manual, payment_date, transaction_id, created_at
   - Multiple status tracking for payments and records

### Coupon System Tables
10. **2024_01_01_000009_create_coupons_table.php**
    - Coupon definitions and rules
    - Foreign key: instructor_id → users
    - Indexes: instructor_id, type, is_active, valid_from, valid_until, used_count, created_at
    - Unique constraint: code
    - JSON field: applicable_courses

11. **2024_01_01_000010_create_coupon_usages_table.php**
    - Coupon usage tracking
    - Foreign keys: coupon_id, user_id, course_id
    - Indexes: All foreign keys, created_at
    - Unique constraint: coupon_id + user_id + course_id

### Reviews & Engagement Tables
12. **2024_01_01_000012_create_course_reviews_table.php**
    - Course rating and review system
    - Foreign keys: course_id, user_id, instructor_id
    - Indexes: All foreign keys, star, created_at
    - Unique constraint: course_id + user_id
    - Check constraint: star rating 1-5

13. **2024_01_01_000015_create_course_likes_table.php**
    - Course like/favorite system
    - Foreign keys: course_id, instructor_id, user_id
    - Indexes: All foreign keys, status, created_at
    - Unique constraint: course_id + user_id

### Progress Tracking Tables
14. **2024_01_01_000013_create_course_logs_table.php**
    - User's last accessed lesson tracking
    - Foreign keys: course_id, module_id, lesson_id, user_id, instructor_id
    - Indexes: All foreign keys, created_at
    - Unique constraint: course_id + user_id

15. **2024_01_01_000014_create_course_activities_table.php**
    - Detailed lesson completion tracking
    - Foreign keys: course_id, instructor_id, module_id, lesson_id, user_id
    - Indexes: All foreign keys, is_completed, created_at
    - Unique constraint: lesson_id + user_id

### Certificate System
16. **2024_01_01_000016_create_certificates_table.php**
    - Course certificate templates
    - Foreign keys: instructor_id, course_id
    - Indexes: instructor_id, course_id, created_at
    - Unique constraint: course_id

### Bundle System Tables
17. **2024_01_01_000017_create_bundle_courses_table.php**
    - Course bundle definitions
    - Foreign key: instructor_id → users
    - Indexes: instructor_id, status, regular_price, sales_price, created_at
    - Unique constraint: slug
    - JSON field: selected_course

18. **2024_01_01_000018_create_bundle_selects_table.php**
    - Bundle-course relationship tracking
    - Foreign keys: instructor_id, course_id, bundle_course_id
    - Indexes: All foreign keys, created_at
    - Unique constraint: course_id + bundle_course_id

### Shopping Cart System
19. **2024_01_01_000019_create_carts_table.php**
    - Shopping cart for courses and bundles
    - Foreign keys: user_id, course_id, bundle_course_id
    - Indexes: All foreign keys + user_identifier, created_at
    - Check constraint: Either course_id or bundle_course_id must be set

### Subscription Management
20. **2024_01_01_000020_create_subscription_packages_table.php**
    - Subscription plan definitions
    - Foreign key: created_by → users
    - Indexes: status, type, created_by, regular_price, sales_price, created_at
    - Unique constraint: slug
    - JSON field: features

21. **2024_01_01_000021_create_subscriptions_table.php**
    - Active user subscriptions
    - Foreign keys: instructor_id → users, subscription_packages_id
    - Indexes: instructor_id, subscription_packages_id, status, start_at, end_at, trial_ends_at, stripe_plan, created_at

22. **2024_01_01_000031_create_stripe_subscriptions_table.php**
    - Stripe-specific subscription data
    - Foreign key: user_id → users
    - Indexes: user_id, stripe_customer_id, stripe_plan_id, status, current_period_start/end, trial_end, canceled_at, created_at
    - Unique constraint: stripe_subscription_id

### Communication System
23. **2024_01_01_000024_create_groups_table.php**
    - Group/class definitions
    - Foreign key: admin_id → users
    - Indexes: admin_id, status, created_at
    - Unique constraint: code

24. **2024_01_01_000025_create_group_participants_table.php**
    - Group membership tracking
    - Foreign keys: group_id, user_id
    - Indexes: group_id, user_id, role, status, joined_at, created_at
    - Unique constraint: group_id + user_id

25. **2024_01_01_000026_create_chats_table.php**
    - Chat messaging system
    - Foreign keys: sender_id, receiver_id, group_id → users/groups
    - Indexes: sender_id, receiver_id, group_id, message_type, is_read, read_at, created_at
    - Check constraint: Either receiver_id or group_id must be set

### Notification System
26. **2024_01_01_000022_create_notifications_table.php**
    - Laravel notifications + custom LMS notifications
    - Foreign keys: instructor_id, course_id, user_id
    - Indexes: notifiable_type/id, instructor_id, course_id, user_id, status, type_custom, read_at, created_at
    - Unique constraint: id (UUID)

### Content Management
27. **2024_01_01_000027_create_landing_pages_table.php**
    - Dynamic landing pages
    - Foreign key: created_by → users
    - Indexes: status, is_home, created_by, template, created_at
    - Full-text search: title, content, meta_description
    - Unique constraint: slug

28. **2024_01_01_000028_create_manage_pages_table.php**
    - Static pages (About, Privacy, etc.)
    - Indexes: status, show_in_menu, sort_order, created_at
    - Full-text search: title, content, meta_description
    - Unique constraint: slug

### Integration Tables
29. **2024_01_01_000023_create_vimeo_data_table.php**
    - Vimeo API integration data
    - Foreign key: user_id → users
    - Indexes: user_id, created_at
    - Unique constraint: user_id

30. **2024_01_01_000029_create_experiences_table.php**
    - User work experience profiles
    - Foreign key: user_id → users
    - Indexes: user_id, is_current, employment_type, start_date, end_date, created_at

31. **2024_01_01_000030_create_dns_settings_table.php**
    - DNS management for custom domains
    - Foreign key: created_by → users
    - Indexes: domain, type, status, created_by, created_at

## Key Performance Optimizations

### Foreign Key Constraints
- All relationships properly constrained with CASCADE deletion
- Referential integrity maintained across all tables
- Orphaned records prevention

### Index Strategy
- **Primary Indexes**: All foreign keys indexed
- **Performance Indexes**: Frequently queried columns (status, dates, prices)
- **Composite Indexes**: Multi-column queries optimized
- **Unique Indexes**: Business logic constraints (email, slugs, codes)
- **Full-text Indexes**: Search functionality on content fields

### Data Integrity
- **Check Constraints**: Star ratings, proper enum values
- **Unique Constraints**: Prevent duplicates (enrollments, reviews, etc.)
- **Default Values**: Sensible defaults for all fields
- **Proper Data Types**: Optimized column types for storage and performance

### JSON Field Usage
- **Flexible Data**: features, sections, metadata as JSON
- **Array Storage**: Course IDs, applicable courses as JSON arrays
- **Searchable**: Where needed, indexed for performance

## Migration Commands

### Fresh Migration (Recommended)
```bash
# Drop all tables and recreate
php artisan migrate:fresh

# With seeding (if seeders exist)
php artisan migrate:fresh --seed
```

### Standard Migration
```bash
# Run new migrations
php artisan migrate

# Check migration status
php artisan migrate:status
```

### Rollback (if needed)
```bash
# Rollback last batch
php artisan migrate:rollback

# Rollback specific steps
php artisan migrate:rollback --step=5
```

## Database Performance Notes

### Recommended MySQL Settings
```sql
-- For better full-text search
SET GLOBAL innodb_ft_min_token_size = 2;
SET GLOBAL ft_min_word_len = 2;

-- For better JSON performance (MySQL 5.7+)
SET GLOBAL innodb_buffer_pool_size = 1G; -- Adjust based on available RAM
```

### Maintenance Queries
```sql
-- Analyze tables for better query performance
ANALYZE TABLE users, courses, course_user, checkouts, coupons, course_reviews;

-- Check table sizes
SELECT table_name, 
       ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'your_database_name'
ORDER BY (data_length + index_length) DESC;
```

## Important Notes

1. **All old migration files removed** - Clean slate approach
2. **Proper foreign key cascading** - Related records will be cleaned up automatically
3. **Comprehensive indexing** - Optimized for read-heavy LMS workloads
4. **JSON fields used strategically** - Flexible data storage where appropriate
5. **Full-text search ready** - Content searchable out of the box
6. **Payment system compliant** - Multiple payment methods and proper tracking
7. **Multi-tenant ready** - Instructor-based data separation

The database structure is now optimized for:
- **High Performance**: Proper indexing and data types
- **Data Integrity**: Foreign key constraints and checks
- **Scalability**: Efficient queries and storage
- **Flexibility**: JSON fields for dynamic content
- **Maintainability**: Clear structure and documentation

All migration files are ready for a fresh database setup with `php artisan migrate:fresh`.