<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for clean seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data (in reverse order of dependencies)
        DB::table('chat_reports')->truncate();
        DB::table('chat_dm_messages')->truncate();
        DB::table('chat_dm_threads')->truncate();
        DB::table('chat_messages')->truncate();
        DB::table('chat_channel_members')->truncate();
        DB::table('chat_channels')->truncate();
        DB::table('forum_reactions')->truncate();
        DB::table('forum_reports')->truncate();
        DB::table('forum_posts')->truncate();
        DB::table('forum_threads')->truncate();
        DB::table('forum_categories')->truncate();
        DB::table('project_updates')->truncate();
        DB::table('project_reviews')->truncate();
        DB::table('project_team_members')->truncate();
        DB::table('project_team_requests')->truncate();
        DB::table('project_votes')->truncate();
        DB::table('project_roles')->truncate();
        DB::table('projects')->truncate();
        DB::table('blog_posts')->truncate();
        DB::table('user_deploy_checklist_items')->truncate();
        DB::table('user_deploy_checklists')->truncate();
        DB::table('deploy_checklist_items')->truncate();
        DB::table('deploy_checklist_templates')->truncate();
        DB::table('track_day_submissions')->truncate();
        DB::table('track_day_completions')->truncate();
        DB::table('track_enrollments')->truncate();
        DB::table('lessons')->truncate();
        DB::table('tracks')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================
        // USERS
        // ============================================

        $users = [
            [
                'id' => 1,
                'email' => 'admin@tutor-allied.dev',
                'password_hash' => Hash::make('ChangeMeNow!'),
                'name' => 'Admin User',
                'bio' => 'Platform administrator',
                'github_username' => 'admin',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'email' => 'sarah@example.com',
                'password_hash' => Hash::make('password123'),
                'name' => 'Sarah K.',
                'bio' => 'Computer Science student. Building my first web app.',
                'github_username' => 'sarahk',
                'role' => 'student',
                'status' => 'active',
                'created_at' => now()->subDays(10),
            ],
            [
                'id' => 3,
                'email' => 'james@example.com',
                'password_hash' => Hash::make('password123'),
                'name' => 'James M.',
                'bio' => 'Full-stack developer. Love mentoring juniors.',
                'github_username' => 'jamesm',
                'role' => 'mentor',
                'status' => 'active',
                'created_at' => now()->subDays(20),
            ],
            [
                'id' => 4,
                'email' => 'alex@example.com',
                'password_hash' => Hash::make('password123'),
                'name' => 'Alex T.',
                'bio' => 'Learning PHP and building side projects.',
                'github_username' => 'alext',
                'role' => 'student',
                'status' => 'active',
                'created_at' => now()->subDays(5),
            ],
            [
                'id' => 5,
                'email' => 'miriam@example.com',
                'password_hash' => Hash::make('password123'),
                'name' => 'Miriam W.',
                'bio' => 'Productivity app enthusiast. Building StudyFlow.',
                'github_username' => 'miriamw',
                'role' => 'student',
                'status' => 'active',
                'created_at' => now()->subDays(15),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        // ============================================
        // TRACKS
        // ============================================

        $tracks = [
            [
                'id' => 1,
                'name' => 'Coding Green',
                'slug' => 'coding-green',
                'level' => 'beginner',
                'description' => 'For complete beginners who have never built before. Start from zero and deploy your first web app in 14 days.',
                'outcome' => 'Deploy a simple working web app with GitHub repo and live hosting. Build confidence to continue learning.',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Aware but Stuck',
                'slug' => 'aware-but-stuck',
                'level' => 'intermediate',
                'description' => 'For learners who know basics but never finish projects. Break through and ship your MVP.',
                'outcome' => 'Ship a functional MVP with clear architecture, database, and at least one verified review.',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Expert',
                'slug' => 'expert',
                'level' => 'advanced',
                'description' => 'For experienced builders who want to ship faster, collaborate, and mentor others.',
                'outcome' => 'Deliver a production-ready project with clean architecture, peer reviews, and mentorship contribution.',
                'created_at' => now(),
            ],
        ];

        foreach ($tracks as $track) {
            DB::table('tracks')->insert($track);
        }

        // ============================================
        // LESSONS (14-day curriculum per track)
        // ============================================

        $lessons = [
            // Coding Green Lessons
            ['track_id' => 1, 'day_number' => 1, 'focus' => 'Orientation', 'content' => 'How the web works, mindset, tools overview'],
            ['track_id' => 1, 'day_number' => 2, 'focus' => 'Basics', 'content' => 'HTML + basic CSS'],
            ['track_id' => 1, 'day_number' => 3, 'focus' => 'PHP Intro', 'content' => 'Variables, forms, basic logic'],
            ['track_id' => 1, 'day_number' => 4, 'focus' => 'GitHub', 'content' => 'Repo creation, commits, README'],
            ['track_id' => 1, 'day_number' => 5, 'focus' => 'APIs', 'content' => 'What APIs are, calling a simple API'],
            ['track_id' => 1, 'day_number' => 6, 'focus' => 'Mini Feature', 'content' => 'Build first app feature'],
            ['track_id' => 1, 'day_number' => 7, 'focus' => 'Review Day', 'content' => 'Fix bugs, clean code'],
            ['track_id' => 1, 'day_number' => 8, 'focus' => 'Database', 'content' => 'MySQL basics, saving data'],
            ['track_id' => 1, 'day_number' => 9, 'focus' => 'Auth Lite', 'content' => 'Simple login / session'],
            ['track_id' => 1, 'day_number' => 10, 'focus' => 'Improve UX', 'content' => 'Forms, messages, validations'],
            ['track_id' => 1, 'day_number' => 11, 'focus' => 'Test', 'content' => 'Manual testing, edge cases'],
            ['track_id' => 1, 'day_number' => 12, 'focus' => 'Deploy Prep', 'content' => 'Hosting basics, env setup'],
            ['track_id' => 1, 'day_number' => 13, 'focus' => 'Deploy', 'content' => 'Push live'],
            ['track_id' => 1, 'day_number' => 14, 'focus' => 'Demo Day', 'content' => 'Write project summary + share'],

            // Aware but Stuck Lessons
            ['track_id' => 2, 'day_number' => 1, 'focus' => 'Project Scope', 'content' => 'Choose idea, define MVP'],
            ['track_id' => 2, 'day_number' => 2, 'focus' => 'Architecture', 'content' => 'Folder structure, flow'],
            ['track_id' => 2, 'day_number' => 3, 'focus' => 'Backend', 'content' => 'PHP logic, controllers'],
            ['track_id' => 2, 'day_number' => 4, 'focus' => 'Database', 'content' => 'Relationships, migrations'],
            ['track_id' => 2, 'day_number' => 5, 'focus' => 'API / AI', 'content' => 'External API or AI usage'],
            ['track_id' => 2, 'day_number' => 6, 'focus' => 'Core Feature', 'content' => 'Main functionality'],
            ['track_id' => 2, 'day_number' => 7, 'focus' => 'Mid Review', 'content' => 'Refactor, remove clutter'],
            ['track_id' => 2, 'day_number' => 8, 'focus' => 'Auth', 'content' => 'Roles or permissions'],
            ['track_id' => 2, 'day_number' => 9, 'focus' => 'UX', 'content' => 'User flows, errors'],
            ['track_id' => 2, 'day_number' => 10, 'focus' => 'Collaboration', 'content' => 'Git branching, PRs'],
            ['track_id' => 2, 'day_number' => 11, 'focus' => 'Testing', 'content' => 'Fix edge cases'],
            ['track_id' => 2, 'day_number' => 12, 'focus' => 'Deployment', 'content' => 'Production setup'],
            ['track_id' => 2, 'day_number' => 13, 'focus' => 'Polish', 'content' => 'Performance, README'],
            ['track_id' => 2, 'day_number' => 14, 'focus' => 'Launch', 'content' => 'Share + feedback'],

            // Expert Lessons
            ['track_id' => 3, 'day_number' => 1, 'focus' => 'Idea Validation', 'content' => 'Problem, users, metrics'],
            ['track_id' => 3, 'day_number' => 2, 'focus' => 'Architecture', 'content' => 'Scalable structure'],
            ['track_id' => 3, 'day_number' => 3, 'focus' => 'Backend', 'content' => 'Advanced PHP patterns'],
            ['track_id' => 3, 'day_number' => 4, 'focus' => 'Data', 'content' => 'Optimization strategies'],
            ['track_id' => 3, 'day_number' => 5, 'focus' => 'Integrations', 'content' => 'APIs / AI logic'],
            ['track_id' => 3, 'day_number' => 6, 'focus' => 'Core Build', 'content' => 'Main features'],
            ['track_id' => 3, 'day_number' => 7, 'focus' => 'Review', 'content' => 'Peer code review'],
            ['track_id' => 3, 'day_number' => 8, 'focus' => 'Security', 'content' => 'Validation, auth'],
            ['track_id' => 3, 'day_number' => 9, 'focus' => 'Performance', 'content' => 'Speed improvements'],
            ['track_id' => 3, 'day_number' => 10, 'focus' => 'Docs', 'content' => 'API docs, README'],
            ['track_id' => 3, 'day_number' => 11, 'focus' => 'Testing', 'content' => 'Stress + edge cases'],
            ['track_id' => 3, 'day_number' => 12, 'focus' => 'Deploy', 'content' => 'Production'],
            ['track_id' => 3, 'day_number' => 13, 'focus' => 'Mentor', 'content' => 'Review junior projects'],
            ['track_id' => 3, 'day_number' => 14, 'focus' => 'Publish', 'content' => 'Case study + showcase'],
        ];

        foreach ($lessons as $lesson) {
            DB::table('lessons')->insert($lesson);
        }

        // ============================================
        // DEPLOY CHECKLISTS
        // ============================================

        $checklists = [
            // Coding Green
            ['track_id' => 1, 'item_text' => 'GitHub repo exists', 'order' => 1],
            ['track_id' => 1, 'item_text' => 'App runs without errors', 'order' => 2],
            ['track_id' => 1, 'item_text' => 'One core feature works', 'order' => 3],
            ['track_id' => 1, 'item_text' => 'README explains the app', 'order' => 4],
            ['track_id' => 1, 'item_text' => 'App is deployed and accessible', 'order' => 5],
            ['track_id' => 1, 'item_text' => 'Project listed in Incubation Chambers', 'order' => 6],

            // Aware but Stuck
            ['track_id' => 2, 'item_text' => 'MVP scope clearly defined', 'order' => 1],
            ['track_id' => 2, 'item_text' => 'Core feature works end-to-end', 'order' => 2],
            ['track_id' => 2, 'item_text' => 'Database structured correctly', 'order' => 3],
            ['track_id' => 2, 'item_text' => 'Deployed version works', 'order' => 4],
            ['track_id' => 2, 'item_text' => 'README + setup instructions', 'order' => 5],
            ['track_id' => 2, 'item_text' => 'Accept at least one review from another user', 'order' => 6],

            // Expert
            ['track_id' => 3, 'item_text' => 'Clean architecture', 'order' => 1],
            ['track_id' => 3, 'item_text' => 'Secure auth & validation', 'order' => 2],
            ['track_id' => 3, 'item_text' => 'Performance optimized', 'order' => 3],
            ['track_id' => 3, 'item_text' => 'Peer-reviewed code', 'order' => 4],
            ['track_id' => 3, 'item_text' => 'Live deployment', 'order' => 5],
            ['track_id' => 3, 'item_text' => 'Mentorship contribution logged', 'order' => 6],
        ];

        foreach ($checklists as $checklist) {
            DB::table('deploy_checklists')->insert($checklist);
        }

        // ============================================
        // FORUM CATEGORIES
        // ============================================

        $categories = [
            ['name' => 'Announcements', 'slug' => 'announcements', 'description' => 'Platform updates, new features, events', 'sort_order' => 1],
            ['name' => 'Getting Started', 'slug' => 'getting-started', 'description' => 'Intro questions, track help, sprint setup', 'sort_order' => 2],
            ['name' => 'Coding Green Help', 'slug' => 'coding-green-help', 'description' => 'Beginner questions, basics, first deployments', 'sort_order' => 3],
            ['name' => 'Aware but Stuck Help', 'slug' => 'aware-but-stuck-help', 'description' => 'MVP challenges, finishing projects, breaking through', 'sort_order' => 4],
            ['name' => 'Expert Builders', 'slug' => 'expert-builders', 'description' => 'Advanced patterns, architecture, mentorship', 'sort_order' => 5],
            ['name' => 'Project Reviews', 'slug' => 'project-reviews', 'description' => 'Request reviews, share progress, get feedback', 'sort_order' => 6],
            ['name' => 'Content Creators', 'slug' => 'content-creators', 'description' => 'AI workflows, content creation, creator tools', 'sort_order' => 7],
            ['name' => 'AI + Crypto', 'slug' => 'ai-crypto', 'description' => 'Education-only. No financial advice.', 'sort_order' => 8],
            ['name' => 'Showcase', 'slug' => 'showcase', 'description' => 'Launches, demos, deployed projects', 'sort_order' => 9],
            ['name' => 'Opportunities', 'slug' => 'opportunities', 'description' => 'Hackathons, internships, collaborations', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            DB::table('forum_categories')->insert($category);
        }

        // ============================================
        // FORUM THREADS
        // ============================================

        $threads = [
            [
                'category_id' => 2,
                'user_id' => 2,
                'title' => 'Tips for Day 1 of Coding Green?',
                'slug' => 'tips-for-day-1',
                'body' => 'I\'m just starting the Coding Green track. Any tips for day 1? What tools should I install?',
                'is_pinned' => true,
                'is_locked' => false,
                'views_count' => 45,
                'last_activity_at' => now()->subHours(2),
                'created_at' => now()->subDays(3),
            ],
            [
                'category_id' => 6,
                'user_id' => 5,
                'title' => 'StudyFlow - AI-powered productivity app',
                'slug' => 'studyflow-ai-productivity',
                'body' => 'Working on an AI-powered productivity app for students. Would love some feedback on the architecture!',
                'is_pinned' => false,
                'is_locked' => false,
                'views_count' => 78,
                'last_activity_at' => now()->subHours(5),
                'created_at' => now()->subDays(5),
            ],
            [
                'category_id' => 6,
                'user_id' => 4,
                'title' => 'DeployLite - One-click deploy checklist',
                'slug' => 'deploylite-deploy-checklist',
                'body' => 'Building a tool to help new developers deploy their projects. Check it out!',
                'is_pinned' => false,
                'is_locked' => false,
                'views_count' => 34,
                'last_activity_at' => now()->subDays(1),
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($threads as $thread) {
            DB::table('forum_threads')->insert($thread);
        }

        // ============================================
        // FORUM POSTS
        // ============================================

        $posts = [
            [
                'thread_id' => 1,
                'user_id' => 3,
                'body' => 'Welcome! Day 1 is all about mindset and understanding how the web works. Take your time with the videos and exercises. Don\'t rush!',
                'created_at' => now()->subDays(3),
            ],
            [
                'thread_id' => 1,
                'user_id' => 2,
                'body' => 'Thanks @James! I\'m excited to start this journey.',
                'created_at' => now()->subDays(2),
            ],
            [
                'thread_id' => 2,
                'user_id' => 3,
                'body' => 'This looks great! Have you thought about the AI integration approach?',
                'created_at' => now()->subHours(5),
            ],
        ];

        foreach ($posts as $post) {
            DB::table('forum_posts')->insert($post);
        }

        // ============================================
        // CHAT CHANNELS
        // ============================================

        $channels = [
            ['name' => 'General', 'slug' => 'general', 'type' => 'public', 'description' => 'General discussion for all Academy members', 'created_by' => 1],
            ['name' => 'Help Desk', 'slug' => 'help-desk', 'type' => 'public', 'description' => 'Get help from the community', 'created_by' => 1],
            ['name' => 'Showcase', 'slug' => 'showcase', 'type' => 'public', 'description' => 'Share your deployments and wins', 'created_by' => 1],
            ['name' => 'Deploy Day', 'slug' => 'deploy-day', 'type' => 'public', 'description' => 'Support for deployment day', 'created_by' => 1],
            ['name' => 'Off Topic', 'slug' => 'off-topic', 'type' => 'public', 'description' => 'Non-building chat', 'created_by' => 1],
        ];

        foreach ($channels as $channel) {
            DB::table('chat_channels')->insert($channel);
        }

        // ============================================
        // CHANNEL MEMBERS
        // ============================================

        $channelMembers = [
            ['channel_id' => 1, 'user_id' => 2, 'role' => 'member', 'joined_at' => now()->subDays(10)],
            ['channel_id' => 1, 'user_id' => 3, 'role' => 'moderator', 'joined_at' => now()->subDays(20)],
            ['channel_id' => 1, 'user_id' => 4, 'role' => 'member', 'joined_at' => now()->subDays(5)],
            ['channel_id' => 1, 'user_id' => 5, 'role' => 'member', 'joined_at' => now()->subDays(15)],
            ['channel_id' => 2, 'user_id' => 3, 'role' => 'moderator', 'joined_at' => now()->subDays(20)],
            ['channel_id' => 3, 'user_id' => 5, 'role' => 'member', 'joined_at' => now()->subDays(15)],
        ];

        foreach ($channelMembers as $member) {
            DB::table('chat_channel_members')->insert($member);
        }

        // ============================================
        // CHAT MESSAGES
        // ============================================

        $messages = [
            [
                'channel_id' => 1,
                'user_id' => 2,
                'message' => 'Hey everyone! Just deployed my first app through the Coding Green track. So excited! 🚀',
                'message_type' => 'text',
                'created_at' => now()->subHours(3),
            ],
            [
                'channel_id' => 1,
                'user_id' => 3,
                'message' => 'Congrats @Sarah! What did you build?',
                'message_type' => 'text',
                'created_at' => now()->subHours(2.5),
            ],
            [
                'channel_id' => 1,
                'user_id' => 2,
                'message' => 'A simple task tracker with PHP and MySQL. Nothing fancy but it works and is live!',
                'message_type' => 'text',
                'created_at' => now()->subHours(2),
            ],
            [
                'channel_id' => 1,
                'user_id' => 4,
                'message' => 'That\'s awesome! I\'m still on Day 4 of Coding Green. The database day was a bit challenging 😅',
                'message_type' => 'text',
                'created_at' => now()->subHours(1.5),
            ],
            [
                'channel_id' => 1,
                'user_id' => 3,
                'message' => '@Alex keep going! Day 8 is when it all starts clicking. The deploy checklist really helps structure things.',
                'message_type' => 'text',
                'created_at' => now()->subHours(1),
            ],
        ];

        foreach ($messages as $message) {
            DB::table('chat_messages')->insert($message);
        }

        // ============================================
        // PROJECTS (Incubation Chambers)
        // ============================================

        $projects = [
            [
                'user_id' => 5,
                'title' => 'PulseBoard',
                'slug' => 'pulseboard',
                'category' => 'web',
                'pitch' => 'Live KPI dashboards for student founders to track their progress.',
                'problem' => 'Students often struggle to track their goals and progress effectively.',
                'solution' => 'A simple, visual dashboard for tracking KPIs and milestones.',
                'target_users' => 'Student founders, side project builders',
                'stage' => 'mvp',
                'repo_url' => 'https://github.com/example/pulseboard',
                'demo_url' => 'https://pulseboard.demo.com',
                'status' => 'active',
                'is_featured' => true,
                'views_count' => 156,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subHours(6),
            ],
            [
                'user_id' => 3,
                'title' => 'MentorMatch',
                'slug' => 'mentormatch',
                'category' => 'ai',
                'pitch' => 'AI-assisted mentor scheduling and review loops for student projects.',
                'problem' => 'Finding the right mentor at the right time is hard.',
                'solution' => 'Smart matching based on skills, availability, and project needs.',
                'target_users' => 'Students seeking mentorship, mentors wanting to help',
                'stage' => 'prototype',
                'repo_url' => 'https://github.com/example/mentormatch',
                'status' => 'active',
                'is_featured' => false,
                'views_count' => 89,
                'created_at' => now()->subDays(14),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 4,
                'title' => 'DeployLite',
                'slug' => 'deploylite',
                'category' => 'automation',
                'pitch' => 'One-click deploy checklist for new builders to ship faster.',
                'problem' => 'New developers get stuck on deployment and never ship.',
                'solution' => 'A guided checklist that walks you through deployment step by step.',
                'target_users' => 'New developers, Coding Green track students',
                'stage' => 'idea',
                'repo_url' => 'https://github.com/example/deploylite',
                'status' => 'active',
                'is_featured' => false,
                'views_count' => 45,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
            ],
            [
                'user_id' => 5,
                'title' => 'StudyFlow',
                'slug' => 'studyflow',
                'category' => 'ai',
                'pitch' => 'Productivity app combining Pomodoro, tasks, and AI summarization.',
                'problem' => 'Students use multiple apps for productivity and lose focus.',
                'solution' => 'All-in-one productivity app with AI-powered features.',
                'target_users' => 'Students, remote workers',
                'stage' => 'prototype',
                'repo_url' => 'https://github.com/example/studyflow',
                'demo_url' => 'https://studyflow.demo.com',
                'status' => 'active',
                'is_featured' => true,
                'views_count' => 234,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subHours(12),
            ],
        ];

        foreach ($projects as $project) {
            DB::table('projects')->insert($project);
        }

        // ============================================
        // PROJECT VOTES
        // ============================================

        $votes = [
            ['project_id' => 1, 'user_id' => 2, 'created_at' => now()->subDays(5)],
            ['project_id' => 1, 'user_id' => 3, 'created_at' => now()->subDays(4)],
            ['project_id' => 1, 'user_id' => 4, 'created_at' => now()->subDays(3)],
            ['project_id' => 2, 'user_id' => 2, 'created_at' => now()->subDays(6)],
            ['project_id' => 2, 'user_id' => 5, 'created_at' => now()->subDays(2)],
            ['project_id' => 3, 'user_id' => 2, 'created_at' => now()->subDays(1)],
            ['project_id' => 4, 'user_id' => 2, 'created_at' => now()->subDays(8)],
            ['project_id' => 4, 'user_id' => 3, 'created_at' => now()->subDays(7)],
            ['project_id' => 4, 'user_id' => 4, 'created_at' => now()->subDays(6)],
        ];

        foreach ($votes as $vote) {
            DB::table('project_votes')->insert($vote);
        }

        // ============================================
        // PROJECT ROLES
        // ============================================

        $projectRoles = [
            ['project_id' => 1, 'role' => 'designer', 'slots' => 1],
            ['project_id' => 1, 'role' => 'qa', 'slots' => 1],
            ['project_id' => 2, 'role' => 'dev', 'slots' => 2],
            ['project_id' => 3, 'role' => 'dev', 'slots' => 1],
            ['project_id' => 3, 'role' => 'content', 'slots' => 1],
            ['project_id' => 4, 'role' => 'dev', 'slots' => 2],
        ];

        foreach ($projectRoles as $role) {
            DB::table('project_roles')->insert($role);
        }

        // ============================================
        // PROJECT REVIEWS
        // ============================================

        $reviews = [
            [
                'project_id' => 1,
                'reviewer_id' => 3,
                'summary' => 'Added a dark mode toggle feature',
                'instructions' => 'Toggle the switch in the top right corner',
                'evidence_url' => 'https://github.com/example/pulseboard/pull/5',
                'commit_hash' => 'a1b2c3d4e5f6',
                'status' => 'implemented',
                'created_at' => now()->subDays(3),
            ],
            [
                'project_id' => 1,
                'reviewer_id' => 4,
                'summary' => 'Fixed mobile responsiveness issues on dashboard',
                'instructions' => 'Check the KPI cards on mobile view',
                'evidence_url' => 'https://github.com/example/pulseboard/pull/8',
                'commit_hash' => 'g7h8i9j0k1l2',
                'status' => 'pending',
                'created_at' => now()->subHours(8),
            ],
            [
                'project_id' => 4,
                'reviewer_id' => 3,
                'summary' => 'Improved task sorting algorithm',
                'instructions' => 'Tasks now sort by due date and priority',
                'evidence_url' => 'https://github.com/example/studyflow/pull/12',
                'commit_hash' => 'm3n4o5p6q7r8',
                'status' => 'implemented',
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($reviews as $review) {
            DB::table('project_reviews')->insert($review);
        }

        // ============================================
        // PROJECT UPDATES
        // ============================================

        $updates = [
            [
                'project_id' => 1,
                'user_id' => 5,
                'content' => 'Just launched the MVP! 🚀 Check it out and let me know what you think.',
                'created_at' => now()->subHours(6),
            ],
            [
                'project_id' => 1,
                'user_id' => 5,
                'content' => 'Adding dark mode next. Would love help with the design!',
                'created_at' => now()->subDays(2),
            ],
            [
                'project_id' => 4,
                'user_id' => 5,
                'content' => 'New feature: AI-powered daily summary. It summarizes your tasks and schedule!',
                'created_at' => now()->subHours(12),
            ],
        ];

        foreach ($updates as $update) {
            DB::table('project_updates')->insert($update);
        }

        // ============================================
        // BLOG POSTS
        // ============================================

        $blogPosts = [
            [
                'author_id' => 1,
                'title' => 'Welcome to Tutor & Allied AI Academy',
                'slug' => 'welcome-to-tutor-allied-ai-academy',
                'excerpt' => 'We\'re building a community for young builders to learn, build, and deploy real projects.',
                'content' => '<p>Welcome to Tutor & Allied AI Academy! We\'re excited to have you join our community of builders.</p><p>Our mission is simple: help 16-25 year olds build real skills through real projects.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(30),
                'created_at' => now()->subDays(31),
            ],
            [
                'author_id' => 3,
                'title' => '5 Tips for Your First Deployment',
                'slug' => '5-tips-first-deployment',
                'excerpt' => 'Deploying your first project can be scary. Here are 5 tips to make it easier.',
                'content' => '<p>Deployment doesn\'t have to be scary. Here are my top 5 tips for first-time deployers.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'created_at' => now()->subDays(11),
            ],
        ];

        foreach ($blogPosts as $post) {
            DB::table('blog_posts')->insert($post);
        }

        // ============================================
        // ENROLLMENTS (Sample)
        // ============================================

        $enrollments = [
            [
                'user_id' => 2,
                'track_id' => 1,
                'status' => 'active',
                'current_day' => 7,
                'started_at' => now()->subDays(7),
            ],
            [
                'user_id' => 4,
                'track_id' => 1,
                'status' => 'active',
                'current_day' => 4,
                'started_at' => now()->subDays(4),
            ],
            [
                'user_id' => 5,
                'track_id' => 2,
                'status' => 'active',
                'current_day' => 10,
                'started_at' => now()->subDays(10),
            ],
        ];

        foreach ($enrollments as $enrollment) {
            DB::table('track_enrollments')->insert($enrollment);
        }

        // ============================================
        // DEPLOY CHECKLIST TEMPLATE
        // ============================================

        $this->call(DeployChecklistSeeder::class);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user: admin@tutor-allied.dev / ChangeMeNow!');
    }
}
