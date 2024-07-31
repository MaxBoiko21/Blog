<?php

namespace Modules\Blog\Components;

use App\View\Components\PageComponent;
use Modules\Blog\Models\BlogArticle;

class BlogArticlePage extends PageComponent
{
    public function __construct(BlogArticle $entity)
    {
        if (empty($entity->template)) {
            $entity->template =  setting(config('settings.blog.article.template'), []);
        }
        $component = setting(config('settings.blog.article.template'), 'Base');
        $component = 'template.' . strtolower(template()) . '.pages.blog-category.' . strtolower($component);

        parent::__construct($entity, $component);
    }
}
