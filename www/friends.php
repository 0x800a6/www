<?php
// Friends data - you can customize this list
$friends = [
    [
        'name' => 'Whooith',
        'username' => '@whooith',
        'bio' => 'Druid VTuber ',
        'avatar' => 'https://pbs.twimg.com/profile_images/1972766109863440384/Y-YMwvFx_400x400.jpg',
        'links' => [
            'twitter' => 'https://twitter.com/whooith',
            'website' => 'https://whooith.carrd.co/'
        ],
        'status' => 'friend', // 'friend' or 'want_to_friend'
        'tags' => ['VTuber']
    ],
    [
        'name' => 'Misa',
        'username' => '@itsmisasoup',
        'bio' => 'your magical mousefailure',
        'avatar' => 'https://pbs.twimg.com/profile_images/1960414220958171136/0miLjdv__400x400.jpg',
        'links' => [
            'twitter' => 'https://twitter.com/itsmisasoup',
            'website' => 'https://itsmisasoup.carrd.co/'
        ],
        'status' => 'want_to_friend', // 'friend' or 'want_to_friend'
        'tags' => ['VTuber']
    ],
    [
        'name' => 'Acvalens',
        'username' => '@acvalensVT',
        'bio' => '🔞 F4F ASMRist | VTuber of a Giant Female variety',
        'avatar' => 'https://pbs.twimg.com/profile_images/1936552116035760128/ci9O2Lks_400x400.jpg',
        'links' => [
            'twitter' => 'https://x.com/acvalensVT',
            'website' => 'https://linktr.ee/acvalens'
        ],
        'status' => 'friend', // 'friend' or 'want_to_friend'
        'tags' => ['VTuber', "ASMR"]
    ],
    [
        'name' => 'Cottontail',
        'username' => '@CottontailVA',
        'bio' => 'Voice Actress ✧ Vtuber ✧ Singer',
        'avatar' => 'https://pbs.twimg.com/profile_images/1962698837543505920/J9zQ83nH_200x200.jpg',
        'links' => [
            'twitter' => 'https://twitter.com/CottontailVA',
            'website' => 'https://cottontailva.carrd.co/'
        ],
        'status' => 'want_to_friend', // 'friend' or 'want_to_friend'
        'tags' => ['VTuber', "Singer"]
    ]
];

function getStatusColor($status) {
    return $status === 'friend' ? 'var(--green)' : 'var(--yellow)';
}

function getStatusText($status) {
    return $status === 'friend' ? 'Friends' : 'Want to be friends';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Friends - Lexi Rose Rogers</title>
    <meta name="title" content="Friends - Lexi Rose Rogers" />
    <meta name="description" content="People I'm friends with or want to connect with in the developer and cosplay community." />
    <meta name="keywords" content="friends, developers, cosplay, community, connections" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/friends" />
    <meta property="og:title" content="Friends - Lexi Rose Rogers" />
    <meta property="og:description" content="People I'm friends with or want to connect with in the developer and cosplay community." />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/friends" />
    <meta property="twitter:title" content="Friends - Lexi Rose Rogers" />
    <meta property="twitter:description" content="People I'm friends with or want to connect with in the developer and cosplay community." />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/friends" />
    <meta name="theme-color" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/static/css/style.css">
    
    <style>
        .friends-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .friend-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .friend-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px var(--shadow);
            border-color: var(--aqua);
        }
        
        .friend-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .friend-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid var(--border);
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .friend-card:hover .friend-avatar {
            border-color: var(--aqua);
            transform: scale(1.05);
        }
        
        .friend-info h3 {
            margin: 0;
            color: var(--yellow);
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .friend-info .username {
            color: var(--gray);
            font-size: 0.9rem;
            margin: 0;
        }
        
        
        .friend-bio {
            color: var(--fg);
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        .friend-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .tag {
            background: var(--bg);
            color: var(--aqua);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            background: var(--border);
            color: var(--yellow);
        }
        
        .friend-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        
        .friend-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--fg);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }
        
        .friend-link:hover {
            background: var(--border);
            color: var(--aqua);
            border-color: var(--aqua);
            transform: translateY(-1px);
        }
        
        .friend-link i {
            font-size: 1rem;
        }
        
        .status-filter {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--fg);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--border);
            color: var(--aqua);
            border-color: var(--aqua);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--border);
        }
        
        @media (max-width: 768px) {
            .friends-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .friend-card {
                padding: 1rem;
            }
            
            .friend-header {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }
            
            
            .friend-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body class="container">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Header -->
    <header>
        <h1>Friends & Connections</h1>
        <p>People I'm friends with or want to be friends with</p>
    </header>
    
    <!-- Filter Buttons -->
    <div class="status-filter">
        <a href="#all" class="filter-btn active" data-filter="all">All</a>
        <a href="#friends" class="filter-btn" data-filter="friend">Friends</a>
        <a href="#want-to-friend" class="filter-btn" data-filter="want_to_friend">Want to be friends</a>
    </div>
    
    <!-- Friends Grid -->
    <div class="friends-grid" id="friends-grid">
        <?php foreach ($friends as $friend): ?>
        <div class="friend-card" data-status="<?php echo $friend['status']; ?>">
            
            <div class="friend-header">
                <img src="<?php echo $friend['avatar']; ?>" alt="<?php echo $friend['name']; ?>" class="friend-avatar">
                <div class="friend-info">
                    <h3><?php echo $friend['name']; ?></h3>
                    <p class="username"><?php echo $friend['username']; ?></p>
                </div>
            </div>
            
            <p class="friend-bio"><?php echo $friend['bio']; ?></p>
            
            <div class="friend-tags">
                <?php foreach ($friend['tags'] as $tag): ?>
                    <span class="tag"><?php echo $tag; ?></span>
                <?php endforeach; ?>
            </div>
            
            <div class="friend-links">
                <?php foreach ($friend['links'] as $platform => $url): ?>
                    <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="friend-link">
                        <?php 
                        $icons = [
                            'github' => 'bi-github',
                            'twitter' => 'bi-twitter-x',
                            'linkedin' => 'bi-linkedin',
                            'website' => 'bi-globe',
                            'portfolio' => 'bi-briefcase',
                            'instagram' => 'bi-instagram'
                        ];
                        $icon = isset($icons[$platform]) ? $icons[$platform] : 'bi-link';
                        ?>
                        <i class="bi <?php echo $icon; ?>"></i>
                        <span><?php echo ucfirst($platform); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const friendCards = document.querySelectorAll('.friend-card');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    // Filter cards
                    friendCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-status') === filter) {
                            card.style.display = 'block';
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(-20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
            
            // Animate cards on load
            friendCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
