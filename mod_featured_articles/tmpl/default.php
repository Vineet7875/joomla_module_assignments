<?php
// No direct access
defined('_JEXEC') or die;

if (!empty($articles)): ?>
    <style>
        .featured-articles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .article-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
            transition: transform 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .article-card:hover {
            transform: scale(1.02);
        }
        .intro-image {
            width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
            margin-bottom: 10px;
        }
        .article-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        .publish-date {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }
        .intro-text {
            font-size: 1em;
            color: #444;
            line-height: 1.4;
        }
        @media (max-width: 600px) {
            .featured-articles {
                padding: 10px;
            }
        }
    </style>

    <div class="featured-articles">
        <?php foreach ($articles as $article): ?>
            <div class="article-card">
                <?php if (!empty($article->images)): ?>
                    <?php 
                    $images = json_decode($article->images);
                    if (!empty($images->image_intro)): ?>
                        <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($article->title); ?>" class="intro-image">
                    <?php endif; ?>
                <?php endif; ?>
                
                <h2 class="article-title"><?php echo htmlspecialchars($article->title); ?></h2>
                <p class="publish-date"><?php echo JHtml::_('date', $article->created, 'd-m-Y'); ?></p>
                
                <?php if ($introText): ?>

                    <p class="intro-text"><?php echo $article->introtext; ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No articles found for the selected criteria.</p>
<?php endif; ?>
