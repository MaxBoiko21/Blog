<?php

namespace Modules\Blog\Components;

use App\Models\DesignSetting;
use App\View\Components\PageComponent;
use Modules\Blog\Models\BlogCategory;

class BlogCategoryPage extends PageComponent
{
    public function __construct(BlogCategory $entity)
    {
        $setting = design(DesignSetting::PRODUCT);
        if (empty($entity->template)) {
            $entity->template = $setting->template;
        }
        $component = 'template.' . strtolower(template()) . '.pages.blog-category.' . strtolower($setting->value['type']);
        $breadcrumbs = [
            [
                'title' => $entity->name,
                'url' => tRoute('slug', ['slug' => $entity->slug]),
            ],
        ];
        parent::__construct($entity, $component, DesignSetting::PRODUCT, breadcrumbs: $breadcrumbs);
    }

}
