<?php

namespace Modules\Blog\Components;

use App\View\Components\PageComponent;
use Modules\Blog\Models\BlogCategory;

class BlogCategoryPage extends PageComponent
{
    public function __construct(BlogCategory $entity)
    {
        if (empty($entity->template)) {
            $entity->template = setting(config('settings.blog.category.template'), []);
        }
        $component = setting(config('settings.blog.category.design'), 'Base');
        $component = 'template.' . strtolower(template()) . '.pages.blog-category.' . strtolower($component);
        parent::__construct($entity, $component);
    }
}
