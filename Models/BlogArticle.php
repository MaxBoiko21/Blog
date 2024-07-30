<?php

namespace Modules\Blog\Models;

use App\Traits\HasName;
use App\Traits\HasSlug;
use App\Traits\HasSorting;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTable;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogArticle extends Model
{
    use HasTable;
    use HasTimestamps;
    use HasSorting;
    use HasStatus;
    use HasTimestamps;
    use HasSlug;
    use HasName;

    protected $fillable = [
        'blog_category_id',
        'name',
    ];

    public static function getDb(): string
    {
        return 'blog_articles';
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
