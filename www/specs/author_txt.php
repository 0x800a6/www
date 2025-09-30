<?php

$title = 'Author DSL Specification';
$description = 'Complete specification and testing interface for the Author DSL parser - a robust configuration language for author profiles and metadata.';
$version = '1.0';
$type = 'Configuration Language';
$status = 'Active';  // Active, Draft, Deprecated, Archived
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Primary Meta Tags -->
    <title><?php echo htmlspecialchars($title); ?> v<?php echo htmlspecialchars($version); ?> | Lexi's Website</title>
    <meta name="title" content="<?php echo htmlspecialchars($title); ?> v<?php echo htmlspecialchars($version); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>" />
    <meta name="keywords" content="author dsl, configuration language, parser, metadata, author.txt, structured data, machine readable, <?php echo htmlspecialchars(strtolower($type)); ?>" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://lrr.sh/specs/author_txt" />
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?> v<?php echo htmlspecialchars($version); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>" />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    <meta property="article:author" content="Lexi Rose Rogers" />
    <meta property="article:section" content="Technical Specifications" />
    <meta property="article:tag" content="<?php echo htmlspecialchars($type); ?>" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/specs/author_txt" />
    <meta property="twitter:title" content="<?php echo htmlspecialchars($title); ?> v<?php echo htmlspecialchars($version); ?>" />
    <meta property="twitter:description" content="<?php echo htmlspecialchars($description); ?>" />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/specs/author_txt" />
    <meta name="theme-color" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="/static/css/style.css">
    <style>
      .section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: #1d2021;
        border: 1px solid #3c3836;
        border-radius: 8px;
      }
      .notice {
        background: #3c3836;
        border: 1px solid var(--yellow);
        border-radius: 6px;
        padding: 1rem;
        margin: 1rem 0;
        color: var(--fg);
      }
      .notice strong {
        color: var(--yellow);
      }
      ul {
        color: var(--fg);
      }
      ul li {
        margin: 0.5rem 0;
      }
      ul li strong {
        color: var(--green);
      }
      pre {
        background: #1d2021 !important;
        border: 1px solid #3c3836;
        border-radius: 8px;
        padding: 1rem;
        overflow-x: auto;
        margin: 1rem 0;
        font-size: 0.9rem;
        line-height: 1.5;
      }
      code {
        font-family: "Fira Code", "JetBrains Mono", "Consolas", "Monaco",
          "Courier New", monospace;
        font-size: 0.9em;
        background: #3c3836;
        padding: 0.2em 0.4em;
        border-radius: 4px;
        color: var(--yellow);
      }
      pre code {
        background: transparent !important;
        padding: 0;
        color: var(--fg);
      }
    </style>
  </head>
  <body class="container">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    
    <!-- Header -->
    <header>
      <h1 id="title">AUTHOR.TXT DSL Specification v1.0</h1>
      <p>
        This document defines the <code>author.txt</code> file format and the
        Author DSL parser version 1.0. It explains the syntax, rules, and expected
        behavior. It includes examples, parser usage, AST representation, error
        handling, and guidance for extension. The goal is to allow websites and
        projects to provide structured author metadata.
      </p>
    </header>

    <div class="section" id="purpose">
      <h2>1. Purpose</h2>
      <p>
        The <code>author.txt</code> file provides metadata about the creator or
        maintainers of a website, software project, or digital resource. It is
        intended to be machine-readable and human-readable. Tools can use it to:
      </p>
      <ul>
        <li>Identify the author of a project</li>
        <li>Provide contact information for security reports or inquiries</li>
        <li>Track skills, projects, or social links</li>
        <li>Support automated indexing or dashboards</li>
      </ul>
      <p>
        By standardizing metadata, <code>author.txt</code> helps maintain
        consistency across sites and projects. It does not replace documentation
        or human-readable profiles. It complements them by providing structured
        information for tools and scripts.
      </p>
    </div>

    <div class="section" id="file-location">
      <h2>2. File Location</h2>
      <p>
        The <code>author.txt</code> file should be located at the root of a web
        server:
      </p>
      <pre>/author.txt</pre>
      <p>Optionally, it can be placed under a well-known path:</p>
      <pre>/.well-known/author.txt</pre>
      <p>
        Placing it under <code>/.well-known</code> follows the convention used
        by <code>security.txt</code> and other site metadata standards. Parsers
        and crawlers can detect it automatically at this path.
      </p>
    </div>

    <div class="section" id="syntax">
      <h2>3. Syntax</h2>
      <p>
        The Author DSL is line-oriented. Each line contains a statement, a block
        directive, or a comment.
      </p>

      <h3>3.1 Comments</h3>
      <p>
        Lines starting with <code>#</code> are comments. They are ignored by the
        parser.
      </p>
      <pre># This is a comment</pre>

      <h3>3.2 Statements</h3>
      <p>
        Statements are key-value pairs separated by a colon. Whitespace around
        the key or value is trimmed.
      </p>
      <pre>Author: Lexi</pre>

      <p>
        Keys can have a type annotation. Use the <code>@</code> symbol to
        specify a type.
      </p>
      <pre>Website@url: https://lrr.sh</pre>
      <p>
        Common types include <code>url</code>, <code>email</code>,
        <code>date</code>, <code>fingerprint</code>, and <code>multiline</code>.
        Parsers should validate the value according to the type if possible.
      </p>

      <h3>3.3 Blocks</h3>
      <p>
        Blocks group related statements. A block starts with
        <code>Begin BlockName</code> and ends with <code>End BlockName</code>.
        Blocks can be nested. Each block instance is represented as an object or
        array in the AST.
      </p>
      <pre>
Begin Profile
    Skills: Rust, C, Assembly
    Motto: "Building the future"
End Profile
</pre
      >

      <h3>3.4 Lists</h3>
      <p>Lists can be represented in two ways:</p>
      <ul>
        <li>Repeated keys. Each occurrence is added to an array.</li>
        <li>Comma-separated values. Parser splits the values on commas.</li>
      </ul>
      <pre>
Skill: Rust
Skill: Go
Skills: Assembly, C, TypeScript
</pre
      >

      <h3>3.5 Multiline Values</h3>
      <p>
        Use triple quotes <code>"""</code> for multiline strings. The value can
        span multiple lines.
      </p>
      <pre>
Bio@multiline: """
Systems programmer.
Privacy advocate.
Inspired by Serial Experiments Lain.
"""
</pre
      >

      <h3>3.6 Includes</h3>
      <p>
        The <code>Include</code> directive references another
        <code>author.txt</code> file. The parser should fetch or read the
        included file if needed.
      </p>
      <pre>Include: https://lrr.sh/more-links.txt</pre>

      <h3>3.7 Reserved Keys</h3>
      <ul>
        <li><code>Author-DSL</code> - DSL version</li>
        <li><code>Include</code> - external files</li>
        <li><code>Expires</code> - optional expiration date</li>
        <li>
          <code>PublicKey</code> / <code>Fingerprint</code> - optional
          authenticity verification
        </li>
      </ul>
    </div>

    <div class="section" id="ast">
      <h2>4. AST Representation</h2>
      <p>
        The parser converts input into an abstract syntax tree. It is a nested
        structure of objects and arrays. Example:
      </p>
      <pre>
{
  "Author": "Lexi",
  "Handle": "lrr",
  "Alias": ["lexi", "author", "sysprog"],
  "Website": { "type":"url", "value":"https://lrr.sh" },
  "Bio": "Systems programmer.\nPrivacy advocate.\nInspired by Serial Experiments Lain.",
  "Profile": [
    { "Skills":["Rust","C","Assembly"], "Motto":"Building the future" }
  ]
}
</pre
      >
      <p>
        Blocks appear as arrays of objects. Typed keys appear as objects with
        <code>type</code> and <code>value</code>.
      </p>
    </div>

    <div class="section" id="parser">
      <h2>5. Parser Features</h2>
      <ul>
        <li>Validates input for empty strings and non-string input.</li>
        <li>Detects and reports syntax errors with line numbers.</li>
        <li>Supports nested blocks and repeated keys.</li>
        <li>Handles typed keys, multiline values, and lists.</li>
        <li>Builds a clean AST suitable for scripts and applications.</li>
        <li>
          Provides utility functions: <code>getValueByKey</code>,
          <code>formatParsedData</code>, <code>validateParsedData</code>.
        </li>
        <li>
          Throws <code>DSLParseError</code> on mismatched or unclosed blocks.
        </li>
      </ul>
    </div>

    <div class="section" id="examples">
      <h2>6. Example AUTHOR.TXT</h2>
      <pre>
# Author file example
Author-DSL: 1.0
Author: Lexi
Handle: lrr
Alias: lexi, author, sysprog
Website@url: https://lrr.sh
Contact@email: mailto:lexi@example.com
Birthday@date: 1999-09-26

Bio@multiline: """
Systems programmer.
Privacy advocate.
Inspired by Serial Experiments Lain.
"""

Begin Profile
    Skills: Assembly, Rust, C, TypeScript
    Skill: Zig
    Motto: "Building the future, one line at a time"
End Profile

Begin Links
    GitHub@url: https://github.com/0x800a6
    Resume@url: https://lrr.sh/resume.php
End Links

Include: https://lrr.sh/more-links.txt
</pre
      >
    </div>

    <div class="section" id="parser-test">
      <h2>7. Testing the Parser</h2>
      <p>Use Node.js to parse an <code>author.txt</code> file:</p>
      <pre><code>
const { parseAuthorDSL, formatParsedData, validateParsedData } = require('@0x800a6/author-txt');
const fs = require('fs');

const input = fs.readFileSync('author.txt', 'utf-8');
try {
  const data = parseAuthorDSL(input);
  console.log('Parsed JSON:', JSON.stringify(data,null,2));
  console.log('Formatted:\n', formatParsedData(data));
  const warnings = validateParsedData(data);
  if (warnings.length) warnings.forEach(w => console.warn(w));
} catch(e) {
  console.error(e.message);
}
</code></pre>

      <div class="notice">
        <p>The parser throws descriptive errors in these cases:</p>
        <ul>
          <li>Unclosed blocks or multiline values</li>
          <li>Invalid key or type syntax</li>
          <li>Mismatched <code>End</code> statements</li>
          <li>Empty key or value</li>
        </ul>
      </div>
    </div>

    <div class="section" id="extensibility">
      <h2>8. Extensibility</h2>
      <p>The DSL can be extended without breaking existing parsers. You can:</p>
      <ul>
        <li>
          Add new types, such as <code>@phone</code> or <code>@github</code>
        </li>
        <li>Add new blocks for projects, skills, or social profiles</li>
        <li>
          Add attributes to keys, e.g.,
          <code>Social::Handle{preferred=main}</code>
        </li>
        <li>Add new reserved directives</li>
      </ul>
      <p>
        Parsers should ignore unknown keys or blocks to remain compatible with
        future extensions.
      </p>
    </div>

    <div class="section" id="license">
      <h2>9. License</h2>
      <p>
        The Author DSL specification and reference parser are licensed under the
        MIT License. You may use, modify, and distribute freely.
      </p>
    </div>

    <div class="section" id="installation">
      <h2>10. Installation</h2>
      <p>
        You can install the Author DSL parser using <strong>npm</strong> or clone it directly with <strong>git</strong>:
      </p>
      <ul>
        <li>
          <strong>npm:</strong>
          <pre><code>npm install @0x800a6/author-txt</code></pre>
        </li>
        <li>
          <strong>git:</strong>
          <pre><code>git clone https://github.com/0x800a6/author.txt.git authortxt
cd authortxt
</code></pre>
        </li>
      </ul>
    </div>


    <div class="section" id="references">
      <h2>11. References</h2>
      <ul>
        <li>
          <a href="https://www.rfc-editor.org/rfc/rfc8615"
            >RFC 8615 - Well-Known URIs</a
          >
        </li>
        <li><a href="https://securitytxt.org/">security.txt</a></li>
      </ul>
    </div>
    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-bash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-javascript.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/plugins/autoloader/prism-autoloader.min.js"></script>
    <script>
      // Anime.js animations
      anime({
        targets: "#title",
        opacity: [0, 1],
        translateY: [-20, 0],
        easing: "easeOutExpo",
        duration: 800,
      });
      anime({
        targets: ".section",
        opacity: [0, 1],
        translateY: [15, 0],
        delay: anime.stagger(200, { start: 500 }),
        duration: 700,
        easing: "easeOutQuad",
      });
    </script>
  </body>
</html>
