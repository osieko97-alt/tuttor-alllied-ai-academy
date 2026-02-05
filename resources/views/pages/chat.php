<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Chat</p>
        <h1>Real-time Discussions</h1>
        <p class="lead">Connect with builders in topic-based channels and project rooms.</p>
    </div>
</section>

<section class="section chat-layout">
    <div class="container">
        <div class="chat-container">
            <!-- Channels Sidebar -->
            <aside class="chat-sidebar">
                <div class="sidebar-section">
                    <h4>Channels</h4>
                    <ul class="channel-list">
                        <li class="channel active">
                            <span class="channel-hash">#</span>
                            <span class="channel-name">general</span>
                        </li>
                        <li class="channel">
                            <span class="channel-hash">#</span>
                            <span class="channel-name">help-desk</span>
                        </li>
                        <li class="channel">
                            <span class="channel-hash">#</span>
                            <span class="channel-name">showcase</span>
                        </li>
                        <li class="channel">
                            <span class="channel-hash">#</span>
                            <span class="channel-name">deploy-day</span>
                        </li>
                        <li class="channel">
                            <span class="channel-hash">#</span>
                            <span class="channel-name">off-topic</span>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-section">
                    <h4>Project Rooms</h4>
                    <ul class="channel-list project-rooms">
                        <li class="channel">
                            <span class="channel-icon">🚀</span>
                            <span class="channel-name">PulseBoard</span>
                        </li>
                        <li class="channel">
                            <span class="channel-icon">🎯</span>
                            <span class="channel-name">MentorMatch</span>
                        </li>
                        <li class="channel">
                            <span class="channel-icon">⚡</span>
                            <span class="channel-name">DeployLite</span>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-section ai-sync-section">
                    <div class="ai-sync-toggle">
                        <div class="ai-toggle-info">
                            <span class="ai-toggle-label">AI Sync</span>
                            <span class="ai-toggle-status">Coming Soon</span>
                        </div>
                        <div class="ai-toggle-switch disabled">
                            <span class="toggle-dot"></span>
                        </div>
                    </div>
                    <p class="ai-tooltip">When enabled, AI can help summarize and suggest replies. You can always choose human-only chat.</p>
                </div>
            </aside>

            <!-- Chat Main Area -->
            <main class="chat-main">
                <div class="chat-header">
                    <div class="chat-channel-info">
                        <span class="channel-hash">#</span>
                        <h3>general</h3>
                    </div>
                    <div class="chat-actions">
                        <button class="button ghost small">Login to Chat</button>
                    </div>
                </div>

                <div class="chat-messages">
                    <div class="message">
                        <div class="message-avatar">SK</div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">Sarah K.</span>
                                <span class="message-time">10:32 AM</span>
                            </div>
                            <p class="message-text">Hey everyone! Just deployed my first app through the Coding Green track. So excited! 🚀</p>
                        </div>
                    </div>

                    <div class="message">
                        <div class="message-avatar">JM</div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">James M.</span>
                                <span class="message-time">10:35 AM</span>
                            </div>
                            <p class="message-text">Congrats @Sarah! What did you build?</p>
                        </div>
                    </div>

                    <div class="message">
                        <div class="message-avatar">SK</div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">Sarah K.</span>
                                <span class="message-time">10:37 AM</span>
                            </div>
                            <p class="message-text">A simple task tracker with PHP and MySQL. Nothing fancy but it works and is live!</p>
                        </div>
                    </div>

                    <div class="message">
                        <div class="message-avatar">AT</div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">Alex T.</span>
                                <span class="message-time">10:42 AM</span>
                            </div>
                            <p class="message-text">That's awesome! I'm still on Day 4 of Coding Green. The database day was a bit challenging 😅</p>
                        </div>
                    </div>

                    <div class="message">
                        <div class="message-avatar">JM</div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">James M.</span>
                                <span class="message-time">10:45 AM</span>
                            </div>
                            <p class="message-text">@Alex keep going! Day 8 is when it all starts clicking. The deploy checklist really helps structure things.</p>
                        </div>
                    </div>
                </div>

                <div class="chat-composer">
                    <div class="composer-wrapper">
                        <input type="text" placeholder="Message #general..." class="composer-input" disabled>
                        <button class="composer-send" disabled>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="login-prompt">Login to send messages</p>
                </div>
            </main>

            <!-- Channel Info Sidebar -->
            <aside class="chat-info-sidebar">
                <div class="info-section">
                    <h4>#general</h4>
                    <p class="info-desc">General discussion for all Academy members. Be respectful and helpful!</p>
                </div>

                <div class="info-section">
                    <h4>Members</h4>
                    <div class="member-count">128 online</div>
                </div>

                <div class="info-section">
                    <h4>Pinned</h4>
                    <div class="pinned-item">
                        <span class="pinned-icon">📌</span>
                        <span class="pinned-text">Welcome! Introduce yourself here 👋</span>
                    </div>
                    <div class="pinned-item">
                        <span class="pinned-icon">📌</span>
                        <span class="pinned-text">Deploy checklist: <a href="#">bit.ly/deploy-check</a></span>
                    </div>
                </div>

                <div class="info-section rules-section">
                    <h4>Channel Rules</h4>
                    <ul class="mini-rules">
                        <li>Be respectful</li>
                        <li>No spam</li>
                        <li>Stay on topic</li>
                        <li>Help others</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        <div class="chat-features">
            <div class="section-head">
                <h2>Chat Features</h2>
                <p>Fast coordination. Real connections.</p>
            </div>
            <div class="grid three">
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3>Topic Channels</h3>
                    <p>Organized spaces for different discussions. General, help, showcase, and more.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3>Project Rooms</h3>
                    <p>Each incubation project gets its own chat for real-time team coordination.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Safe & Moderated</h3>
                    <p>Rate limits, report buttons, and moderation to keep the community safe.</p>
                </div>
            </div>
        </div>
    </div>
</section>
