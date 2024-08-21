<?php

namespace Modules\Blog\Components\Microdata;

use App\View\Components\Microdata;
use Closure;
use Illuminate\Contracts\View\View;

class BlogArticle extends Microdata
{
    public function __construct(\Modules\Blog\Models\BlogArticle $entity)
    {
        $properties = $this->buildData($entity);
        parent::__construct('BlogPosting', $properties);
    }

    public function render(): View|Closure|string
    {
        return '<x-microdata :type="$type" :properties="$properties" />';
    }

    public function buildData(\Modules\Blog\Models\BlogArticle $entity): array
    {
        $blogCategory = \Modules\Blog\Models\BlogArticle::query()->find($entity->blog_category_id);
        $data = [
            'mainEntityOfPage' => (object) [
                '@type' => 'WebPage',
                '@id' => route('blog-article', ['category' => $blogCategory->slug, 'article' => $entity->slug]),
                'headline' => $entity->name,
                'alternativeHeadline' => $entity->meta_title,
                'image' => asset('/storage/' . $entity->image),
                'publisher' => (object) [
                    '@type' => 'Organization',
                    'name' => setting('company_name'),
                    'logo' => (object) [
                        '@type' => 'ImageObject',
                        'url' => asset(setting('header_logo') ?? setting('footer_logo') ?? '/'),
                    ],
                ],
                'datePublished' => $entity->created_at->format('Y-m-d'),
                'dateModified' => $entity->updated_at->format('Y-m-d'),
                'description' => $entity->meta_description,
                'articleBody' => $entity->content,
            ],
        ];

        return $data;
    }
}
