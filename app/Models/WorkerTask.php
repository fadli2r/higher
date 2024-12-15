<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerTask extends Model
{
    protected $fillable = [
        'worker_id', 'order_id', 'task_description', 'progress', 'deadline',
        'task_count', 'product_workflow_id','file_path', 'created_at', 'updated_at'
    ];
    protected $dates = [ 'deadline' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function worker()
    {
        return $this->belongsTo(Pekerja::class, 'worker_id');
    }

    public function workflow()
    {
        return $this->belongsTo(ProductWorkflow::class); // Relasi ke ProductWorkflow
    }
    public function productWorkflow()
    {
        return $this->belongsTo(ProductWorkflow::class, 'product_workflow_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'task_id');
    }
    public function pekerja()
{
    return $this->belongsTo(Pekerja::class, 'worker_id');
}
public function revisions()
{
    return $this->hasMany(Revision::class, 'task_id');
}
}
