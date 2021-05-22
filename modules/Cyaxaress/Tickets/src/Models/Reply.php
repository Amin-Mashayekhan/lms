<?php
namespace Cyaxaress\Ticket\Models;

use Cyaxaress\Media\Models\Media;
use Cyaxaress\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model{

    protected $guarded = [];
    protected $table = "ticket_replies";

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
