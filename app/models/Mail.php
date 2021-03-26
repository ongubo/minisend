<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Attachment;
use App\models\Status;

class Mail extends Model
{
    public function attachments()
    {
      return $this->hasMany(Attachment::class);
    }
    public function status()
    {
      return $this->belongsTo(Status::class);
    }
}
