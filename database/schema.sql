-- Tutor & Allied AI Academy - Database Schema
-- Incubation Chambers + Core Platform Tables

-- ============================================
-- USERS & AUTH
-- ============================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    bio TEXT,
    github_username VARCHAR(100),
    avatar_url VARCHAR(500),
    role ENUM('user', 'admin', 'partner') DEFAULT 'user',
    status ENUM('active', 'suspended', 'banned') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status)
);

CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_user (user_id)
);

-- ============================================
-- INCUBATION CHAMBERS - PROJECTS
-- ============================================

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category ENUM('web', 'ai', 'automation', 'creator') NOT NULL,
    pitch VARCHAR(500) NOT NULL,
    problem TEXT NOT NULL,
    solution TEXT NOT NULL,
    target_users TEXT,
    stage ENUM('idea', 'prototype', 'mvp', 'beta') DEFAULT 'idea',
    repo_url VARCHAR(500) NOT NULL,
    demo_url VARCHAR(500),
    status ENUM('active', 'paused', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_category (category),
    INDEX idx_stage (stage),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
);

-- Project votes (one per user per project)
CREATE TABLE project_votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (project_id, user_id),
    INDEX idx_project (project_id),
    INDEX idx_user (user_id)
);

-- Project roles needed
CREATE TABLE project_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    role ENUM('dev', 'designer', 'content', 'qa') NOT NULL,
    slots INT DEFAULT 1,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id)
);

-- Team join requests
CREATE TABLE project_team_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('dev', 'designer', 'content', 'qa') NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
);

-- Team members
CREATE TABLE project_team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('dev', 'designer', 'content', 'qa') NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_member (project_id, user_id),
    INDEX idx_project (project_id),
    INDEX idx_user (user_id)
);

-- Project reviews (GitHub-based)
CREATE TABLE project_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    reviewer_id INT NOT NULL,
    summary TEXT NOT NULL,
    instructions TEXT,
    evidence_url VARCHAR(500),
    commit_hash VARCHAR(40),
    status ENUM('pending', 'implemented', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_reviewer (reviewer_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
);

-- Project updates (timeline posts)
CREATE TABLE project_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_created (created_at)
);

-- ============================================
-- FORUM
-- ============================================

CREATE TABLE forum_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    sort_order INT DEFAULT 0,
    is_locked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_order (sort_order)
);

CREATE TABLE forum_threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    last_activity_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES forum_categories(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_user (user_id),
    INDEX idx_last_activity (last_activity_at),
    INDEX idx_created (created_at)
);

CREATE TABLE forum_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    user_id INT NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (thread_id) REFERENCES forum_threads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_thread (thread_id),
    INDEX idx_user (user_id),
    INDEX idx_created (created_at)
);

CREATE TABLE forum_reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('like', 'helpful', 'insightful') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES forum_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_reaction (post_id, user_id, type),
    INDEX idx_post (post_id)
);

CREATE TABLE forum_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT,
    content_type ENUM('thread', 'post') NOT NULL,
    content_id INT NOT NULL,
    reason ENUM('scam', 'fake', 'spam', 'harassment', 'inappropriate', 'other') NOT NULL,
    details TEXT,
    status ENUM('open', 'reviewed', 'actioned') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_content (content_type, content_id),
    INDEX idx_status (status)
);

-- ============================================
-- CHAT
-- ============================================

CREATE TABLE chat_channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    type ENUM('public', 'project', 'private') DEFAULT 'public',
    project_id INT,
    description TEXT,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_slug (slug),
    INDEX idx_type (type),
    INDEX idx_project (project_id)
);

CREATE TABLE chat_channel_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('member', 'moderator') DEFAULT 'member',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (channel_id) REFERENCES chat_channels(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_member (channel_id, user_id),
    INDEX idx_channel (channel_id),
    INDEX idx_user (user_id)
);

CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    message_type ENUM('text', 'system') DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (channel_id) REFERENCES chat_channels(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_channel (channel_id),
    INDEX idx_user (user_id),
    INDEX idx_created (created_at)
);

CREATE TABLE chat_dm_threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_one_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_two_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_thread (user_one_id, user_two_id),
    INDEX idx_user_one (user_one_id),
    INDEX idx_user_two (user_two_id)
);

CREATE TABLE chat_dm_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dm_thread_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (dm_thread_id) REFERENCES chat_dm_threads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_thread (dm_thread_id),
    INDEX idx_created (created_at)
);

CREATE TABLE chat_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT,
    message_id INT NOT NULL,
    reason ENUM('spam', 'harassment', 'inappropriate', 'other') NOT NULL,
    status ENUM('open', 'reviewed', 'actioned') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (message_id) REFERENCES chat_messages(id) ON DELETE CASCADE,
    INDEX idx_message (message_id),
    INDEX idx_status (status)
);

-- ============================================
-- COURSES & TRACKS
-- ============================================

CREATE TABLE tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    level ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    description TEXT,
    outcome TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    track_id INT NOT NULL,
    day_number INT NOT NULL,
    focus VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    INDEX idx_track_day (track_id, day_number)
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    track_id INT NOT NULL,
    status ENUM('active', 'completed', 'paused') DEFAULT 'active',
    current_day INT DEFAULT 1,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, track_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
);

-- ============================================
-- DEPLOY CHECKLISTS
-- ============================================

CREATE TABLE deploy_checklists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    track_id INT NOT NULL,
    item_text TEXT NOT NULL,
    `order` INT NOT NULL,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    INDEX idx_track (track_id)
);

CREATE TABLE user_checklist_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT NOT NULL,
    checklist_id INT NOT NULL,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (checklist_id) REFERENCES deploy_checklists(id) ON DELETE CASCADE,
    UNIQUE KEY unique_progress (enrollment_id, checklist_id),
    INDEX idx_enrollment (enrollment_id)
);

-- ============================================
-- CERTIFICATES & GRADUATION
-- ============================================

CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL,
    track_id INT NOT NULL,
    certificate_code VARCHAR(50) NOT NULL UNIQUE,
    issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_code (certificate_code)
);

-- ============================================
-- MODERATION & SAFETY
-- ============================================

CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT,
    target_type ENUM('project', 'thread', 'post', 'message', 'user') NOT NULL,
    target_id INT NOT NULL,
    reason ENUM('scam', 'fake', 'spam', 'harassment', 'inappropriate', 'other') NOT NULL,
    details TEXT,
    status ENUM('pending', 'reviewed', 'resolved', 'dismissed') DEFAULT 'pending',
    moderator_id INT,
    moderator_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (moderator_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_target (target_type, target_id),
    INDEX idx_status (status)
);

CREATE TABLE moderation_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    moderator_id INT NOT NULL,
    target_type ENUM('project', 'thread', 'post', 'message', 'user') NOT NULL,
    target_id INT NOT NULL,
    action ENUM('warn', 'mute', 'suspend', 'ban', 'archive', 'remove') NOT NULL,
    reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (moderator_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_target (target_type, target_id),
    INDEX idx_moderator (moderator_id)
);

-- ============================================
-- INTEGRATIONS & SECRETS
-- ============================================

CREATE TABLE integrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    key_name VARCHAR(100) NOT NULL,
    encrypted_value TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_key (key_name),
    INDEX idx_active (is_active)
);

-- ============================================
-- AUDIT LOGS
-- ============================================

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_entity (entity_type, entity_id),
    INDEX idx_created (created_at)
);

-- ============================================
-- BLOG
-- ============================================

CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content TEXT NOT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_published (published_at)
);

-- ============================================
-- SEED DATA
-- ============================================

-- Forum Categories
INSERT INTO forum_categories (name, slug, description, sort_order) VALUES
('Announcements', 'announcements', 'Platform updates, new features, events', 1),
('Getting Started', 'getting-started', 'Intro questions, track help, sprint setup', 2),
('Coding Green Help', 'coding-green-help', 'Beginner questions, basics, first deployments', 3),
('Aware but Stuck Help', 'aware-but-stuck-help', 'MVP challenges, finishing projects, breaking through', 4),
('Expert Builders', 'expert-builders', 'Advanced patterns, architecture, mentorship', 5),
('Project Reviews', 'project-reviews', 'Request reviews, share progress, get feedback', 6),
('Content Creators', 'content-creators', 'AI workflows, content creation, creator tools', 7),
('AI + Crypto', 'ai-crypto', 'Education-only. No financial advice.', 8),
('Showcase', 'showcase', 'Launches, demos, deployed projects', 9),
('Opportunities', 'opportunities', 'Hackathons, internships, collaborations', 10);

-- Chat Channels
INSERT INTO chat_channels (name, slug, type, description, created_by) VALUES
('General', 'general', 'public', 'General discussion for all Academy members', 1),
('Help Desk', 'help-desk', 'public', 'Get help from the community', 1),
('Showcase', 'showcase', 'public', 'Share your deployments and wins', 1),
('Deploy Day', 'deploy-day', 'public', 'Support for deployment day', 1),
('Off Topic', 'off-topic', 'public', 'Non-building chat', 1);

-- Tracks
INSERT INTO tracks (name, slug, level, description, outcome) VALUES
('Coding Green', 'coding-green', 'beginner', 'For complete beginners who have never built before.', 'Deploy a simple working web app with GitHub and live hosting.'),
('Aware but Stuck', 'aware-but-stuck', 'intermediate', 'For learners who know basics but never finish projects.', 'Ship a functional MVP with clear architecture and reviews.'),
('Expert', 'expert', 'advanced', 'For experienced builders who want to ship faster and mentor.', 'Deliver a production-ready project with peer reviews and mentorship.');
