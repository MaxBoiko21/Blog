<?php

namespace Modules\Blog\Models;

use App\Traits\HasBreadcrumbs;
use App\Traits\HasName;
use App\Traits\HasRoute;
use App\Traits\HasSlug;
use App\Traits\HasSorting;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTable;
use App\Traits\HasTemplate;
use App\Traits\HasTimestamps;
use App\Traits\HasTranslate;
use App\Traits\HasViews;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Seo\Traits\HasSeo;

class BlogArticle extends Model
{
    use HasTable;
    use HasSorting;
    use HasStatus;
    use HasTimestamps;
    use HasSlug;
    use HasName;
    use HasSeo;
    use HasTranslate;
    use HasRoute;
    use HasBreadcrumbs;
    use HasViews;
    use HasTemplate;

    protected $fillable = [
        'blog_category_id',
        'name',
    ];

    public static function getDb(): string
    {
        return 'blog_articles';
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
    public function route(): string
    {
        return tRoute('blog-article', ['category' => $this->category->slug, 'article' => $this->slug]);
    }
    public function getBreadcrumbs(): array
    {
        return array_merge($this->category->getBreadcrumbs(), [
            $this->name => $this->route(),
        ]);
    }
}
