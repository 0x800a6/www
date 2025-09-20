<?php
require_once(dirname(__FILE__) . "/utils/data.php");
$me = $me_data;
$title = "Resume";
$description = "Professional resume and experience of {$me['name']}. Systems developer, open source contributor, and privacy advocate.";
include 'includes/seo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- SEO meta tags included above -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/blog.css">
    <style>
        .resume-main {
            max-width: 700px;
            margin: 3rem auto 3rem auto;
            padding: 0 1rem;
        }
        .resume-header {
            text-align: center;
            margin-top: 2rem;
            background: linear-gradient(135deg, #ffdde1 60%, #ee9ca7 100%);
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px #ee9ca733;
            padding: 2.5rem 1rem 2rem 1rem;
        }
        .resume-avatar {
            width: 120px;
            border-radius: 50%;
            box-shadow: 0 2px 16px #ee9ca755;
            border: 4px solid #fff0f6;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #5BCEFA 0%, #F5A9B8 100%);
            padding: 4px;
        }
        .resume-section-title {
            font-family: "Dancing Script", "Nunito", "Comfortaa", cursive;
            font-size: 2rem;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
            font-style: italic;
            color: #ee9ca7;
            text-shadow: 1px 2px 8px #fff0f6, 0 1px 0 #ee9ca7;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 0.5em;
            justify-content: center;
        }
        .resume-list {
            list-style: none;
            padding-left: 0;
            background: #fff0f6;
            border-radius: 1rem;
            box-shadow: 0 2px 12px #ee9ca722;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .resume-list li {
            margin-bottom: 1.1rem;
        }
        .resume-badge {
            font-size: 0.95em;
            margin-left: 0.5em;
            border-radius: 1em;
            background: #ffdde1;
            color: #ee9ca7;
            padding: 0.2em 0.7em;
            font-family: "Quicksand", "Nunito", sans-serif;
            box-shadow: 0 1px 4px #ee9ca722;
            transition: background 0.2s, color 0.2s;
            display: inline-block;
        }
        .resume-badge.secondary {
            background: #f5a9b8;
            color: #fff;
        }
        .resume-badge:hover {
            background: #ee9ca7;
            color: #fff;
        }
        .resume-company {
            font-weight: 500;
            color: #ee9ca7;
        }
        .resume-role {
            font-weight: 600;
            color: #5BCEFA;
            font-family: "Poppins", "Comfortaa", sans-serif;
        }
        .resume-date {
            color: #b48ead;
            font-size: 0.95em;
            margin-left: 0.5em;
        }
        .resume-skills {
            margin-bottom: 1.5rem;
        }
        .resume-skill-badge {
            margin: 0.2em 0.3em 0.2em 0;
            border-radius: 1em;
            font-size: 1em;
            font-family: "Quicksand", "Nunito", sans-serif;
            box-shadow: 0 1px 4px #ee9ca722;
            background: #fff0f6;
            color: #ee9ca7;
            border: 1px solid #ee9ca7;
            transition: background 0.2s, color 0.2s;
            display: inline-block;
            padding: 0.2em 0.9em;
        }
        .resume-skill-badge.primary { background: #5BCEFA; color: #fff; border: none; }
        .resume-skill-badge.success { background: #F5A9B8; color: #fff; border: none; }
        .resume-skill-badge.info { background: #fff0f6; color: #ee9ca7; border: 1px solid #ee9ca7; }
        .resume-skill-badge:hover {
            background: #ee9ca7;
            color: #fff;
        }
        .resume-link {
            color: #ee9ca7;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .resume-link:hover {
            color: #5BCEFA;
            text-decoration: underline;
        }
        .resume-alert {
            background: linear-gradient(90deg, #fff0f6 60%, #ffdde1 100%);
            border: 1px solid #ee9ca7;
            color: #ee9ca7;
            border-radius: 1em;
            font-family: "Quicksand", "Nunito", sans-serif;
            font-size: 1.1em;
            box-shadow: 0 1px 8px #ee9ca722;
            padding: 1em 1.5em;
            margin-bottom: 0.5em;
        }
        .resume-muted {
            color: #b48ead !important;
            font-size: 0.95em;
        }
        @media (max-width: 600px) {
            .resume-header, .resume-list, .resume-main {
                padding: 1rem 0.5rem;
            }
            .resume-section-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body class="site-body">
    <?php include 'includes/nav.php'; ?>
    <main class="resume-main">
        <!-- Header -->
        <div class="resume-header">
            <img src="<?= htmlspecialchars($me['avatar']) ?>" alt="<?= htmlspecialchars($me['name']) ?> avatar" class="resume-avatar mb-3">
            <h1><?= htmlspecialchars($me['name']) ?></h1>
            <p class="lead"><?= htmlspecialchars($me['bio']) ?></p>
            <p>
                <a class="resume-link" href="mailto:<?= htmlspecialchars($me['contact']['email']) ?>"><?= htmlspecialchars($me['contact']['email']) ?></a>
                <?php if (!empty($me['contact']['pgp_fingerprint'])): ?>
                    &nbsp;|&nbsp; <a class="resume-link" href="/static/pgp.asc" target="_blank" rel="noopener">PGP Key</a>
                <?php endif; ?>
                <?php if (!empty($me['twitter'])): ?>
                    &nbsp;|&nbsp; <a class="resume-link" href="https://twitter.com/<?= ltrim($me['twitter'], '@') ?>" target="_blank" rel="noopener"><?= htmlspecialchars($me['twitter']) ?></a>
                <?php endif; ?>
            </p>
        </div>

        <!-- Experience -->
        <section>
            <h2 class="resume-section-title">Experience</h2>
            <ul class="resume-list">
                <li>
                    <span class="resume-role">Software Developer</span>
                    <span class="resume-company"> — VTubersTV</span>
                    <span class="resume-date">(2023–Present)</span>
                    <ul>
                        <li>Architected and maintained scalable backend services for a high-traffic platform.</li>
                        <li>Led TypeScript type definition efforts and improved developer tooling.</li>
                        <li>Collaborated with open source contributors and mentored new team members.</li>
                    </ul>
                </li>
                <li>
                    <span class="resume-role">Open Source Contributor</span>
                    <span class="resume-date">(2020–Present)</span>
                    <ul>
                        <li>Active contributor to 25+ public repositories, focusing on systems, web, and developer tools.</li>
                        <li>Published libraries in Go, Rust, and TypeScript; 160+ GitHub stars across projects.</li>
                        <li>Advocate for privacy, security, and open standards in software.</li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Skills -->
        <section>
            <h2 class="resume-section-title">Technical Skills</h2>
            <div class="resume-skills">
                <span class="resume-skill-badge primary">Go</span>
                <span class="resume-skill-badge primary">Rust</span>
                <span class="resume-skill-badge primary">C</span>
                <span class="resume-skill-badge success">TypeScript</span>
                <span class="resume-skill-badge success">React</span>
                <span class="resume-skill-badge success">Next.js</span>
                <span class="resume-skill-badge info">Docker</span>
                <span class="resume-skill-badge info">Linux</span>
                <span class="resume-skill-badge info">Vim</span>
                <span class="resume-skill-badge info">Git</span>
            </div>
        </section>

        <!-- Projects -->
        <section>
            <h2 class="resume-section-title">Selected Projects</h2>
            <ul class="resume-list">
                <li>
                    <strong>file_uploader</strong>
                    <span class="resume-badge secondary">PHP</span>
                    <span class="resume-badge secondary">Open Source</span>
                    <br>
                    Simple and secure file upload service with a focus on privacy and ease of use.
                </li>
                <li>
                    <strong>website</strong>
                    <span class="resume-badge secondary">PHP/Apache2</span>
                    <span class="resume-badge secondary">Web</span>
                    <br>
                    Personal website and blog platform, built with performance and SEO in mind.
                </li>
            </ul>
            <p style="margin-top:1em;">
                <a class="resume-link" href="https://github.com/0x800a6" target="_blank" rel="noopener">See more on GitHub →</a>
            </p>
        </section>

        <!-- Education -->
        <section>
            <h2 class="resume-section-title">Education</h2>
            <ul class="resume-list">
                <li>
                    <span class="resume-role">Self-Taught</span>
                    <span class="resume-date">(2020–Present)</span>
                    <ul>
                        <li>Focused on systems programming, distributed systems, and web technologies.</li>
                        <li>Continuous learning via open source, online courses, and technical writing.</li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Privacy Statement -->
        <section>
            <h2 class="resume-section-title">Privacy</h2>
            <div class="resume-alert">
                <strong>No trackers. No analytics. No cookies. No scripts from strangers.</strong>
            </div>
            <p class="resume-muted">
                This resume is served statically. No personal data is collected. For secure contact, use PGP.
            </p>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>