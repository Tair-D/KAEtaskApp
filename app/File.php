<?php

namespace App;

use App\FileItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * App\File
 *
 * @property int $id ИД
 * @property string $name Название
 * @property string $url Ссылка на файл
 * @property string $hash Хэш файла
 * @property string $extension Расширение
 * @property string $size Размер
 * @property int|null $user_id ИД пользователя
 * @property int|null $task_id ID задачи
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\FileCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FileItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereTaskId($value)
 * @mixin \Eloquent
 * @property int $is_signed Подписан
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereIsSigned($value)
 */
class File extends Model
{
    /**
     * @param string $name
     * @param string $url
     * @return self | bool
     */
    protected $table='files';

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function task(){
        return $this->hasOne(Task::class,'id','task_id');
    }


}
