<?php
require_once 'vendor/autoload.php';

use App\Models\Post;

// Update the Nigerian economy post image
$post = Post::where('slug', 'nigerian-economy-challenges-and-opportunities')->first();

if ($post) {
    $oldImage = 'https://images.unsplash.com/photo-1526379095098-6789e538b5b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MXxzZVfo3ZXJ8fHx8&auto=format&fit=crop&w=800&q=80';
    $newImage = 'https://images.unsplash.com/photo-1579546929518-7b1ad425473?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MXxzZVfo3ZXJ8fHx8&auto=format&fit=crop&w=1200&q=80';
    
    $post->content = str_replace($oldImage, $newImage, $post->content);
    $post->save();
    
    echo "Post image updated to Lagos skyline!\n";
}
