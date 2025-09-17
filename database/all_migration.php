<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop all tables in reverse order to handle foreign keys
        $this->dropAllTables();

        // Create all tables in proper order
        $this->createCoreTables();
        $this->createCourseTables();
        $this->createPaymentTables();
        $this->createCommunicationTables();
        $this->createOtherTables();
    }

    /**
     * Drop all tables in reverse order
     */
    private function dropAllTables(): void
    {
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('vimeo_data');
        Schema::dropIfExists('d_n_s_settings');
        Schema::dropIfExists('stripe_subscriptions');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_packages');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('manage_pages');
        Schema::dropIfExists('landing_pages');
        Schema::dropIfExists('live_classes');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('bundle_selects');
        Schema::dropIfExists('bundle_courses');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('group_participants');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('course_reviews');
        Schema::dropIfExists('course_logs');
        Schema::dropIfExists('course_likes');
        Schema::dropIfExists('course_activities');
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('checkouts');
        Schema::dropIfExists('course_user');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }

    /**
     * Create core Laravel and user tables
     */
    private function createCoreTables(): void
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_role')->default('student');
            $table->text('company_name')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('social_links')->nullable();
            $table->longText('description')->nullable();
            $table->string('recivingMessage')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('vimeo_data')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('nogod_number')->nullable();
            $table->string('rocket_number')->nullable();
            $table->string('stripe_public_key')->nullable();
            $table->string('session_id')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('last_activity_at')->nullable()->comment('User last activity');
            $table->rememberToken();
            $table->timestamps();
        });

        // Password reset tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Password resets
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Personal access tokens
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index(['tokenable_type', 'tokenable_id']);
        });

        // Failed jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        // Cache locks
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Create course-related tables
     */
    private function createCourseTables(): void
    {
        // Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->tinyInteger('auto_complete')->default(1);
            $table->integer('user_id')->nullable();
            $table->integer('instructor_id')->nullable();
            $table->text('slug')->nullable();
            $table->string('promo_video', 191)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->text('categories')->nullable();
            $table->string('thumbnail', 191)->default('latest/assets/images/courses/thumbnail.png');
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->tinyInteger('hascertificate')->default(0);
            $table->string('sample_certificates', 191)->nullable();
            $table->tinyInteger('numbershow')->nullable();
            $table->string('numbervalue')->nullable();
            $table->string('status', 25)->default('draft');
            $table->tinyInteger('allow_review')->default(1);
            $table->string('language', 30)->nullable();
            $table->string('platform', 50)->nullable();
            $table->longText('objective')->nullable();
            $table->longText('who_should_join')->nullable();
            $table->string('curriculum', 191)->nullable();
            $table->timestamps();
        });

        // Modules
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->text('title');
            $table->text('slug');
            $table->string('status', 30)->default('draft');
            $table->dateTime('publish_at')->nullable();
            $table->integer('reorder')->default(0);
            $table->timestamps();
        });

        // Lessons
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('duration')->default(0);
            $table->integer('module_id');
            $table->text('title');
            $table->text('slug');
            $table->string('video_link', 191)->nullable();
            $table->string('video_type', 20)->default('vimeo');
            $table->string('thumbnail', 191)->nullable();
            $table->text('short_description')->nullable();
            $table->string('status', 30)->default('pending');
            $table->boolean('is_public')->default(false);
            $table->enum('type', ['video', 'audio', 'text', 'live']);
            $table->dateTime('live_start_time')->nullable();
            $table->integer('live_duration_minutes')->nullable();
            $table->string('zoom_meeting_id')->nullable();
            $table->string('zoom_join_url')->nullable();
            $table->string('zoom_password')->nullable();
            $table->string('audio')->nullable();
            $table->string('text')->nullable();
            $table->string('lesson_file')->nullable();
            $table->integer('reorder')->default(0);
            $table->timestamps();
        });

        // Course enrollment
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('instructor_id');
            $table->enum('payment_method', ['bkash', 'nogod', 'rocket', 'cash', 'free_access'])->default('cash');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->string('promo_code', 50)->nullable();
            $table->decimal('promo_discount', 10, 2)->default(0.00);
            $table->boolean('paid')->default(false);
            $table->enum('status', ['payment_pending', 'pending', 'approved', 'rejected'])->default('payment_pending');
            $table->string('payment_screenshot')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });

        // Course activities
        Schema::create('course_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('is_completed')->default(0);
            $table->unsignedBigInteger('duration')->default(0);
            $table->timestamps();
        });

        // Course logs
        Schema::create('course_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        // Course likes
        Schema::create('course_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->timestamps();
        });

        // Course reviews
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('user_id');
            $table->longText('comment')->nullable();
            $table->integer('star');
            $table->timestamps();
        });

        // Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->integer('course_id');
            $table->string('certificate_clr')->nullable();
            $table->string('accent_clr')->nullable();
            $table->integer('style');
            $table->string('logo')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Create payment and subscription tables
     */
    private function createPaymentTables(): void
    {
        // Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 8, 2);
            $table->unsignedBigInteger('instructor_id');
            $table->json('applicable_courses')->nullable();
            $table->integer('usage_limit')->default(1);
            $table->integer('used_count')->default(0);
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['code', 'is_active']);
            $table->index(['instructor_id', 'is_active']);
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Coupon usages
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('original_amount', 8, 2);
            $table->decimal('discount_amount', 8, 2);
            $table->decimal('final_amount', 8, 2);
            $table->timestamps();

            $table->unique(['coupon_id', 'user_id', 'course_id']);
            $table->index(['coupon_id', 'created_at']);
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        // Checkouts
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('sender_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->json('payment_details')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'decline', 'canceled', 'refunded', 'failed', 'deleted'])->default('pending');
            $table->integer('amount')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Create communication tables
     */
    private function createCommunicationTables(): void
    {
        // Groups
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedBigInteger('admin_id')->comment('Creator of group');
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Group participants
        Schema::create('group_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Chats
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->longText('message')->nullable();
            $table->string('file')->nullable();
            $table->string('file_extension', 50)->nullable();
            $table->tinyInteger('file_type')->default(1)->comment('1:Message, 2:File');
            $table->tinyInteger('message_type')->default(1)->comment('1:Personal message, 2:Group message');
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Create other supporting tables
     */
    private function createOtherTables(): void
    {
        // Live classes
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('course_name')->nullable();
            $table->dateTime('start_time');
            $table->integer('duration_minutes');
            $table->string('zoom_meeting_id')->nullable();
            $table->text('zoom_start_url')->nullable();
            $table->text('zoom_join_url')->nullable();
            $table->string('zoom_password')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->json('zoom_response')->nullable();
            $table->timestamps();

            $table->index(['instructor_id', 'course_id']);
            $table->index('start_time');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });

        // User sessions
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('session_id')->unique();
            $table->string('device_name')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('ip_address', 45);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('user_agent');
            $table->timestamp('last_activity')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('is_current')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'last_activity']);
            $table->index('session_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Bundle courses
        Schema::create('bundle_courses', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id');
            $table->text('title');
            $table->text('sub_title')->nullable();
            $table->text('slug')->nullable();
            $table->string('selected_course');
            $table->string('regular_price')->nullable();
            $table->string('sales_price')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        // Bundle selects
        Schema::create('bundle_selects', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->text('title')->nullable();
            $table->integer('instructor_id')->nullable();
            $table->text('slug')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->string('thumbnail', 191)->default('public/assets/images/courses/thumbnail.png');
            $table->longText('short_description')->nullable();
            $table->timestamps();
        });

        // Additional tables (simplified versions for compatibility)
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_identifier')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('bundle_course_id')->nullable();
            $table->string('instructor_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('profession');
            $table->string('company_name');
            $table->string('job_type');
            $table->text('experience')->nullable();
            $table->date('join_date');
            $table->date('retire_date')->nullable();
            $table->text('short_description');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('instructor_id');
            $table->integer('course_id');
            $table->integer('user_id');
            $table->string('type');
            $table->longText('message');
            $table->string('status')->default('unseen');
            $table->timestamps();
        });

        Schema::create('vimeo_data', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('access_key')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        // Create remaining tables with minimal structure
        $simpleTable = function($tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        };

        $simpleTable('subscription_packages');
        $simpleTable('subscriptions');
        $simpleTable('stripe_subscriptions');
        $simpleTable('landing_pages');
        $simpleTable('manage_pages');
        $simpleTable('d_n_s_settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropAllTables();
    }
};