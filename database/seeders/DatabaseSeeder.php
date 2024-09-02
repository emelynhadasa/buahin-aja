<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('majors')->insert([
            ['name' => 'None'],
            ['name' => 'Computer Science'],
            ['name' => 'Visual Communication Design'],
        ]);

        DB::table('batches')->insert([
            ['name' => 'None'],
            ['name' => '2021'],
            ['name' => '2022'],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Academic'],
            ['name' => 'Science'],
            ['name' => 'Art'],
        ]);

        DB::table('types')->insert([
            ['name' => 'Quiz'],
            ['name' => 'Submission'],
        ]);

        DB::table('avatars')->insert([
            [
                'name' => "cool",
                'type' => "png",
                'image' => '/images/avatar1.png'
            ],
            [
                'name' => "uncool",
                'type' => "png",
                'image' => '/images/avatar2.png'
            ],
        ]);

        // Seed the users table
        DB::table('users')->insert([
            [
                'email' => 'test1@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('mudahKok'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 1,
                'avatar_id' => '1',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => '123456789',
                'batch_id' => '2',
                'major_id' => '2',
                'date_of_birth' => $faker->date('Y-m-d'),
                'GPA' => 3.5,
            ],
            [
                'email' => 'test2@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('mudahKok'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 0,
                'avatar_id' => '2',
                'first_name' => 'sammy',
                'last_name' => 'manurung',
                'student_id' => '12345678',
                'batch_id' => '2',
                'major_id' => '2',
                'date_of_birth' => $faker->date('Y-m-d'),
                'GPA' => 3.5,
            ],
        ]);

        // Seed the news table
        DB::table('news')->insert([
            [
                'title' => 'Enrollment New Periode',
                'type' => 'Type 1',
                'description' => 'On July 23, students is expected to enroll in the class with the offered courses',
                'publisher' => 'Academic',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719977649_blog-academic-programss.png',
                'order_number' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Compshere',
                'type' => 'Type 2',
                'description' => 'Compsphere is ready to embark on a new challenge in technology. There will be exhibition and competition.',
                'publisher' => 'PUFA Computing',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719977692_maxresdefault.jpg',
                'order_number' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Competition of Accounting',
                'type' => 'Event',
                'description' => 'Be ready to make yourself as a winner by competing with 1000 students from all over Indonesia',
                'publisher' => 'PUMA Accounting',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719979077_1630566764544.jpeg',
                'order_number' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Charity by PU',
                'type' => 'News',
                'description' => 'Lets share the love to our fellow. Give your donations in money, clothes, or books that might be useful for them. Spread love!',
                'publisher' => 'Student Activity',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719979127_Activities-for-Students-in-School.jpg',
                'order_number' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Youth Today oGTa/e',
                'type' => 'Event',
                'description' => "Dreaming of interning abroad? Worry not!\r\nNow, we already have the opportunity to you! It's beneficial and a good experience to try, let's join the info session in theater presuniv",
                'publisher' => 'AIESEC in President University',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719979242_poster-feed-with-schoters-3-6247ac725a74dc36b13490d5.png',
                'order_number' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Eid Adha Holiday',
                'type' => 'News',
                'description' => 'On Monday, we are no longer have academic activities',
                'publisher' => 'Academic',
                'publish_date' => Carbon::now(),
                'image' => '/images/1719979181_public_holiday.png',
                'order_number' => 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);



        // Seed the schedule table
        DB::table('schedules')->insert([
            [
                'course_name' => 'Course 1',
                'class_time' => '9:00 AM - 11:00 AM',
                'room_code' => 'A101',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_name' => 'Course 2',
                'class_time' => '1:00 PM - 3:00 PM',
                'room_code' => 'B202',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_name' => 'Course 3',
                'class_time' => '2:00 PM - 4:00 PM',
                'room_code' => 'B203',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the attendance table
        DB::table('attendance')->insert([
            [
                'date' => Carbon::now(),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'date' => Carbon::now(),
                'status' => 'absent',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'date' => Carbon::now(),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'date' => Carbon::now(),
                'status' => 'late',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the student_schedule table
        DB::table('student_schedule')->insert([
            [
                'user_id' => 1,
                'schedule_id' => 1,
                'attendance_id' => 1,
            ],
            [
                'user_id' => 1,
                'schedule_id' => 2,
                'attendance_id' => 2,
            ],
            [
                'user_id' => 1,
                'schedule_id' => 3,
                'attendance_id' => 3,
            ],
            [
                'user_id' => 1,
                'schedule_id' => 1,
                'attendance_id' => 4,
            ],
        ]);
        // Seed the events table
        DB::table('events')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Event 1',
                'point' => 100,
                'target' => 100,
                'max_participants' => 50,
                'start' => Carbon::now(),
                'end' => Carbon::now()->addDays(7),
                'type_id' => 1,
                'description' => 'Description 1',
                'image' => '/images/1719977649_blog-academic-programss.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'name' => 'Event 2',
                'point' => 200,
                'target' => 100,
                'max_participants' => 30,
                'start' => Carbon::now(),
                'end' => Carbon::now()->addDays(5),
                'type_id' => 1,
                'description' => 'Description 2',
                'image' => '/images/1719977692_maxresdefault.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'category_id' => 3,
                'name' => 'Event 3: Submission',
                'point' => 200,
                'target' => 100,
                'max_participants' => 30,
                'start' => Carbon::now(),
                'end' => Carbon::now()->addDays(5),
                'type_id' => 2,
                'description' => 'Description 3',
                'image' => '/images/1719979181_public_holiday.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the category progress table
        DB::table('category_progress')->insert([
            [
                'user_id' => 1,
                'category_id' => 1,
                'score' => 80,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'score' => 70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'score' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'score' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'score' => 220,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'score' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the event requirements table
        DB::table('event_requirements')->insert([
            [
                'event_id' => 1,
                'batch_id' => 2,
                'major_id' => 2,
                'category_id' => 1,
                'category_score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 2,
                'batch_id' => 2,
                'major_id' => 2,
                'category_id' => 2,
                'category_score' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 3,
                'batch_id' => 2,
                'major_id' => 2,
                'category_id' => 1,
                'category_score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 3,
                'batch_id' => 2,
                'major_id' => 3,
                'category_id' => 3,
                'category_score' => 90,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Seed the event_progress table
        DB::table('event_progress')->insert([
            [
                'user_id' => 1,
                'event_id' => 1,
                'progress' => 50,
                'score' => 80,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'event_id' => 1,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'event_id' => 2,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'event_id' => 2,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'event_id' => 3,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'event_id' => 3,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'event_id' => 3,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'event_id' => 3,
                'progress' => 25,
                'score' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

        // Seed the quiz events table
        DB::table('quiz_events')->insert([
            [
                'event_id' => 1,
                'quiz_name' => 'Quiz 1',
                'duration' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 2,
                'quiz_name' => 'Quiz 2',
                'duration' => 45,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the quiz_question table
        DB::table('quiz_questions')->insert([
            [
                'event_id' => 1,
                'question' => 'What does PU stand for?',
                'order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 1,
                'question' => 'Where is PU located at?',
                'order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 2,
                'question' => 'What are the four rooms within a human heart?',
                'order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 2,
                'question' => 'What mammal has the largest brain?',
                'order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the quiz options table
        DB::table('quiz_options')->insert([
            [
                'option' => 'President University',
                'score' => 1,
                'question_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Pelita University',
                'score' => 0,
                'question_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Penabur University',
                'score' => 0,
                'question_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Penuai University',
                'score' => 0,
                'question_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Jababeka Education Park in Kota Jababeka',
                'score' => 1,
                'question_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Scientia Business Park, Jl. Gading Serpong Boulevard No.1 Tower 1 15810 Kabupaten Tangerang Banten',
                'score' => 0,
                'question_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Jalan Douwes Dekker No. 1',
                'score' => 0,
                'question_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'MH Thamrin Boulevard 1100 15811 Kelapa Dua Banten',
                'score' => 0,
                'question_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Left Atrium, Right Atrium, Left Ventricle, Right Ventricle',
                'score' => 1,
                'question_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Atrioventicular (AV) node, Atrioventicular (AV) bundle, Sinoatrial (SA) node, Purkinje fibers',
                'score' => 0,
                'question_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Atrium, Conus Arteriosus, Ventricle, Sinus Venosus',
                'score' => 0,
                'question_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Jugular, Caval, Brachial, Pulmonary',
                'score' => 0,
                'question_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Sperm Whale',
                'score' => 1,
                'question_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Human',
                'score' => 0,
                'question_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Dolphin',
                'score' => 0,
                'question_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'option' => 'Elephant',
                'score' => 0,
                'question_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the submission_answers table
        DB::table('submission_events')->insert([
            [
                'event_id' => 3,
                'submission_name' => 'Submission 1',
                'file_type' => '.png',
                'desc' => "PNG Submission",
                'file_size' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed the submission_answers table
        DB::table('submission_answers')->insert([
            [
                'event_id' => 3,
                'student_id' => 1,
                'file_link' => 'Exercise_Path.png',
                'score' => 80,
                'last_updated' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('professions')->insert([
            [
                'name' => 'Academician',
                'prize' => 'Rp. 100.000,00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('profession_requirements')->insert([
            [
                'score' => 50,
                'category_id' => 1,
                'profession_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'score' => 50,
                'category_id' => 2,
                'profession_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
