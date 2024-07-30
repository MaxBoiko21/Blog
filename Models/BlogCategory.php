<?php

namespace Modules\Blog\Models;

use App\Traits\HasSlug;
use App\Traits\HasSorting;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTable;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    use HasTable;
    use HasTimestamps;
    use HasSorting;
    use HasStatus;
    use HasTimestamps;
    use HasSlug;

    public static function getDb(): string
    {
        return 'blog_categories';
    }

    protected $fillable = [
        'name'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(BlogArticle::class);
    }
}
