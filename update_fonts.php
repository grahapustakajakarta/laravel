<?php

$cssFile = 'c:/xampp/htdocs/Buku_Jakarta/public/assets/css/style.css';
$cssContent = file_get_contents($cssFile);

// 1. Add CSS Variables to top of style.css if not already there
$cssVars = ":root {\n  --font-serif: 'Playfair Display', Georgia, serif;\n  --font-sans: 'Source Sans 3', 'Helvetica Neue', Arial, sans-serif;\n}\n\n";
if (strpos($cssContent, '--font-serif') === false) {
    $cssContent = $cssVars . $cssContent;
}

// 2. Define font mapping
$serifFonts = [
    "'72 Black'", '"72 Black"',
    "'Bell MT'", '"Bell MT"',
    "'Times New Roman'", '"Times New Roman"',
    "'Playfair Display'", '"Playfair Display"'
];
$sansFonts = [
    "'72 Condensed'", '"72 Condensed"',
    "'7d Condensed'", '"7d Condensed"', // typo seen in blade
    "'Aptos Narrow'", '"Aptos Narrow"',
    "'Poppins'", '"Poppins"',
    "'Latto'", '"Latto"',
    "'Source Sans 3'", '"Source Sans 3"',
    "'Helvetica Neue'", '"Helvetica Neue"'
];

// Helper to escape regex
function escapeFonts($fonts) {
    return array_map(function($f) { return preg_quote($f, '/'); }, $fonts);
}

$serifRegex = '/font-family\s*:\s*(?:' . implode('|', escapeFonts($serifFonts)) . ')[^;]*;/i';
$sansRegex = '/font-family\s*:\s*(?:' . implode('|', escapeFonts($sansFonts)) . ')[^;]*;/i';

// Replace in CSS
$cssContent = preg_replace($serifRegex, 'font-family: var(--font-serif);', $cssContent);
$cssContent = preg_replace($sansRegex, 'font-family: var(--font-sans);', $cssContent);
file_put_contents($cssFile, $cssContent);

echo "Updated style.css\n";

// 3. Update all blade files
$directory = new RecursiveDirectoryIterator('c:/xampp/htdocs/Buku_Jakarta/resources/views');
$iterator = new RecursiveIteratorIterator($directory);
$bladeFiles = new RegexIterator($iterator, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach ($bladeFiles as $file) {
    $filePath = $file[0];
    $content = file_get_contents($filePath);
    $original = $content;
    
    $content = preg_replace($serifRegex, 'font-family: var(--font-serif);', $content);
    $content = preg_replace($sansRegex, 'font-family: var(--font-sans);', $content);
    
    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $count++;
    }
}

echo "Updated $count blade files.\n";
