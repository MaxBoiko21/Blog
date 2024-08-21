<?php

namespace Modules\Blog\Components\Microdata;

use App\View\Components\Microdata;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class BlogCategory extends Microdata
{
    public function __construct(\Modules\Blog\Models\BlogCategory $entity)
    {
        $properties = $this->buildData($entity);
        parent::__construct('Blog', $properties);
    }

    public function render(): View|Closure|string
    {
        return '<x-microdata :type="$type" :properties="$properties" />';
    }

    public function buildData(\Modules\Blog\Models\BlogCategory $entity): array
    {
        $data = [
            'name' => $entity->meta_title,
            'description' => $entity->meta_description,
            'url' => route('blog-category', ['category' => $entity->slug]),
        ];
        $logo = setting('header_logo') ?? setting('footer_logo') ?? '/';
        $values = [];

        foreach ($entity->blog_article as $article) {
            $values[] = (object) [
                '@type' => 'BlogPosting',
                'headline' => $article->name,
                'alternativeHeadline' => $article->meta_title,
                'image' => asset('/storage/' . $article->image),
                //                'author' => $article->authors ?? '',
                'datePublished' => $article->created_at->format('Y-m-d'),
                'dateModified' => $article->updated_at->format('Y-m-d'),
                'mainEntityOfPage' => route('blog-article', ['category' => $entity->slug, 'article' => $article->slug]),
                'publisher' => (object) [
                    '@type' => 'Organization',
                    'name' => setting('company_name'),
                    'logo' => (object) [
                        '@type' => 'ImageObject',
                        'url' => asset('/storage/' . $logo),
                    ],
                ],
                'description' => $article->meta_description,
                'articleBody' => $article->content,
            ];
        }

        $data['blogPost'] = $values;

        return $data;
    }
}
