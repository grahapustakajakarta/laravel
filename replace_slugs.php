<?php
$dir = __DIR__.'/resources/views/pages';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$count = 0;
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        
        // Match things like url('/artikel/'.$row->id) or url('/artikel/'.$row_head->id)
        // We will replace ->id with ->slug only in the context of artikel links
        $newContent = preg_replace('/url\(\s*[\'"]\/artikel\/[\'"]\s*\.\s*\$([a-zA-Z0-9_]+)->id\s*(.*?)\)/', "url('/artikel/'.$$1->slug$2)", $content);
        
        if ($newContent !== $content) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getFilename() . "\n";
            $count++;
        }
    }
}
echo "Total files updated: $count\n";
