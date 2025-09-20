<?php
require_once(dirname(__FILE__) . "/utils/data.php");
require_once(dirname(__FILE__) . "/utils/content.php");

$me = $me_data; // For backward compatibility
$recentPosts = get_recent_blog_posts(3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Home";
    include 'includes/seo.php';
    ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/blog.css">
</head>

<body class="site-body">
    <?php include 'includes/nav.php'; ?>
    <main>
        <!-- Hero -->
        <section class="hero">
            <div>
                <img src="<?php echo $me['avatar']; ?>" alt="<?php echo $me['name']; ?> avatar" class="avatar shadow">
                <h1>Hi, I'm <?php echo $me['name']; ?></h1>
                <p class="lead">
                    <?php echo $me['bio']; ?>
                </p>
            </div>
        </section>

        <!-- About -->
        <div id="about" class="container my-5">
            <h2 class="section-title" style="font-family: 'Dancing Script', 'Nunito', 'Comfortaa', sans-serif;">About Me
            </h2>
            <p>
                I'm Lexi (aka <strong>0x800a6</strong>), a software developer who loves building efficient systems
                and meaningful digital experiences. My journey began in 2020, evolving into
                a focus on <em>systems programming</em>, <em>performance optimization</em>, and
                <em>modern web technologies</em>.
            </p>
        </div>

        <!-- Resume -->
        <div id="resume" class="container my-5">
            <h2 class="section-title">Professional Resume</h2>
            <p><strong>Software Developer</strong> — VTubersTV (Current)</p>
            <ul>
                <li>Developing and maintaining platform services</li>
                <li>Contributing to TypeScript type definitions and utilities</li>
                <li>Collaborating with the open source community</li>
            </ul>
            <p><strong>Open Source Contributor</strong> (2020–Present)</p>
            <ul>
                <li>Active contributor to 26+ repositories</li>
                <li>160+ stars across projects</li>
                <li>Building tools and libraries for developers</li>
            </ul>
        </div>

        <!-- Skills -->
        <div class="container my-5">
            <h2 class="section-title">Technical Skills</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <p><strong>Systems</strong><br>Go, Rust, C</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Web</strong><br>TypeScript, React, Next.js</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Tools</strong><br>Docker, Linux, Vim, Git</p>
                </div>
            </div>
        </div>

        <!-- Privacy -->
        <div id="privacy" class="container my-5">
            <h2 class="section-title">Privacy</h2>
            <div class="mb-4">
            <p>
                The world is not what it seems. Governments want to know what you do. They build big computers. They run wires under the ground. They watch the network. They log every click, every word, every page. They say it is for safety. They say it is for order. They do not ask you. They do not tell you. They just watch.
            </p>
            <p>
                Companies join in. They want your habits. They want your face, your voice, your thoughts. They put trackers in every site. They hide scripts in every ad. They build a shadow of you. They sell it. They trade it. You become a number in a database. You become a product.
            </p>
            </div>
            <div class="alert alert-warning" role="alert">
            <strong>No trackers. No analytics. No cookies. No scripts from strangers.</strong>
            </div>
            <ul>
            <li>This site does not log your IP address.</li>
            <li>This site does not use Google Analytics or Facebook pixels.</li>
            <li>This site does not load fonts or scripts from outside servers.</li>
            <li>This site does not fingerprint your browser.</li>
            <li>This site does not care who you are.</li>
            </ul>
            <div class="mb-4">
            <p>
                If you want to stay private, use Tor. Use a VPN. Use a computer you trust. Do not trust the network. Do not trust the cloud. Do not trust the browser. The watchers are patient. They wait. They collect. They connect the dots.
            </p>
            <p>
                The world is full of watchers. They are not your friends. They do not care about your story. They want control. They want order. They want to know everything. Stay sharp. Stay awake. Do not give them what they want.
            </p>
            </div>
            <div class="card bg-light border-0">
            <div class="card-body">
                <h5 class="card-title">How to Stay Private</h5>
                <ul>
                <li>Use open source software. Read the code if you can.</li>
                <li>Block scripts. Block ads. Block third-party requests.</li>
                <li>Use strong passwords. Do not reuse them.</li>
                <li>Encrypt your messages. Use PGP or Signal.</li>
                <li>Do not trust big companies. They work with the watchers.</li>
                <li>Question everything. Even this site.</li>
                </ul>
            </div>
            </div>
            <div class="mt-4">
            <p>
                You are not alone. The system is big, but you are not powerless. You can choose what you share. You can choose what you hide. You can choose to be a ghost in the machine. The watchers will never stop. You must never stop either.
            </p>
            </div>
        </div>

        <!-- Contact -->
        <div id="contact" class="container my-5">
            <h2 class="section-title">Contact</h2>
            <p>Email: <a href="mailto:<?php echo $me['contact']['email']; ?>"><?php echo $me['contact']['email']; ?></a>
            </p>
            <?php
            if (!empty($me['contact']['pgp_fingerprint'])) {
                echo '<div class="mt-3">';
                echo '<p><strong>PGP Key:</strong> <a href="/static/pgp.asc" target="_blank" rel="noopener noreferrer">Download</a></p>';
                echo '<pre class="bg-light p-2 rounded"><code>' . wordwrap(htmlspecialchars($me['contact']['pgp_fingerprint']), 32, "\n", true) . '</code></pre>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Blog -->
        <div id="blog" class="container my-5">
            <h2 class="section-title">Recent Blog Posts</h2>
             <?php if (!empty($recentPosts)): ?>
                <div class="row g-4">
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 blog-card">
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title mb-2">
                                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="text-decoration-none text-primary">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="mb-2 text-muted small">
                                        <?php echo date('F j, Y', strtotime($post['date'])); ?>
                                        <?php if (isset($post['readingTime'])): ?>
                                            • <?php echo $post['readingTime']; ?> min read
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($post['tags'])): ?>
                                        <div class="mb-2">
                                            <?php foreach (array_slice($post['tags'], 0, 3) as $tag): ?>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <p class="card-text flex-grow-1"><?php echo htmlspecialchars($post['summary']); ?></p>
                                    <div class="mt-3">
                                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="btn btn-outline-primary btn-sm w-100">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No blog posts yet. Check back soon!</p>
            <?php endif; ?>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

  
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const greetings = <?php echo json_encode($me['greetings']); ?>;

            const heroTitle = document.querySelector('.hero h1');
            let greetIndex = 0;

            function typeGreeting(text, element, delay = 70, cb) {
                element.textContent = '';
                let i = 0;
                function type() {
                    if (i < text.length) {
                        element.textContent += text.charAt(i);
                        i++;
                        setTimeout(type, delay);
                    } else if (cb) {
                        setTimeout(cb, 1200);
                    }
                }
                type();
            }

            function cycleGreetings() {
                typeGreeting(greetings[greetIndex], heroTitle, 70, () => {
                    greetIndex = (greetIndex + 1) % greetings.length;
                    cycleGreetings();
                });
            }

            if (heroTitle) {
                cycleGreetings();
            }
        });
    </script>
</body>

</html>