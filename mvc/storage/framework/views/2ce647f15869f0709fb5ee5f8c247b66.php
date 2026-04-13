

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Page Header -->
    <div class="text-center mb-16">
        <h1 class="serif-heading text-5xl md:text-6xl font-bold text-slate-900 dark:text-white mb-4">
            Reading Room
        </h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Discover thoughtful articles and stories from our community of writers</p>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 mb-12 shadow-sm">
        <form method="GET" action="<?php echo e(route('blog.index')); ?>" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Search</label>
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Find articles..." 
                        value="<?php echo e(request('search')); ?>"
                        class="input-field"
                    >
                </div>
                
                <!-- Author Filter -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Author</label>
                    <select name="author" class="input-field appearance-none bg-white dark:bg-slate-900 pr-10">
                        <option value="">All Authors</option>
                        <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($author->id); ?>" <?php echo e(request('author') == $author->id ? 'selected' : ''); ?>>
                                <?php echo e($author->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Tag Filter -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Topic</label>
                    <select name="tag" class="input-field appearance-none bg-white dark:bg-slate-900 pr-10">
                        <option value="">All Topics</option>
                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tag->id); ?>" <?php echo e(request('tag') == $tag->id ? 'selected' : ''); ?>>
                                <?php echo e($tag->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Sort By</label>
                    <select name="sort" class="input-field appearance-none bg-white dark:bg-slate-900 pr-10">
                        <option value="latest" <?php echo e(request('sort', 'latest') === 'latest' ? 'selected' : ''); ?>>Latest Published</option>
                        <option value="popular" <?php echo e(request('sort') === 'popular' ? 'selected' : ''); ?>>Most Popular</option>
                        <option value="trending" <?php echo e(request('sort') === 'trending' ? 'selected' : ''); ?>>Trending Now</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary text-sm">
                    Apply Filters
                </button>
                <a href="<?php echo e(route('blog.index')); ?>" class="btn-secondary text-sm">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Main Content Grid -->
    <?php if($posts->count()): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="group card-hover bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col">
                    <!-- Featured Image -->
                    <div class="relative h-48 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <?php if($post->featured_image): ?>
                            <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-linear-to-br from-slate-400 to-slate-600 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/30" fill="currentColor" viewBox="0 0 24 24"><path d="M11 3a8 8 0 100 16 8 8 0 000-16zM2 11a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Content Overlay -->
                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="btn-primary text-sm w-full text-center">
                                Read Full Article
                            </a>
                        </div>

                        <!-- Reading Time Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-slate-900 text-xs px-3 py-1.5 rounded-full font-semibold"><?php echo e($post->reading_time); ?> min</span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="flex flex-col flex-1 p-6">
                        <!-- Author & Date -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-linear-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-sm font-semibold">
                                <?php echo e(substr($post->author->name, 0, 1)); ?>

                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($post->author->name); ?></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($post->published_at->diffForHumans()); ?></p>
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-slate-700 dark:group-hover:text-slate-200 transition-colors">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>"><?php echo e($post->title); ?></a>
                        </h2>

                        <!-- Excerpt -->
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-2 mb-4 flex-1">
                            <?php echo e($post->excerpt ?: Str::limit(strip_tags($post->content), 100)); ?>

                        </p>

                        <!-- Tags -->
                        <?php if($post->tags->count()): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php $__currentLoopData = $post->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        <?php echo e($tag->name); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($post->tags->count() > 2): ?>
                                    <span class="inline-block text-xs font-medium px-2.5 py-1">+<?php echo e($post->tags->count() - 2); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Footer Actions -->
                        <div class="flex justify-between items-center pt-4 border-t border-slate-200 dark:border-slate-700 mt-auto">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="text-slate-900 dark:text-white hover:text-slate-600 dark:hover:text-slate-300 font-medium text-sm transition-colors">
                                Read more →
                            </a>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                <?php echo e($post->comments()->approved()->count()); ?> comments
                            </span>
                        </div>

                        <!-- Quick Actions for Author -->
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->id === $post->user_id): ?>
                                <div class="flex gap-2 mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                                    <a href="<?php echo e(route('blog.edit', $post)); ?>" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('blog.destroy', $post)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors" onclick="return confirm('Delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            <?php echo e($posts->appends(request()->query())->links('pagination::tailwind')); ?>

        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6M6 12a6 6 0 1012 0 6 6 0 01-12 0z"/></path></svg>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No Articles Found</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Try adjusting your search filters or browse all articles</p>
            <a href="<?php echo e(route('blog.index')); ?>" class="btn-primary inline-block">
                View All Articles
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\PHP LARAVEL\mvc\resources\views/blog/index.blade.php ENDPATH**/ ?>