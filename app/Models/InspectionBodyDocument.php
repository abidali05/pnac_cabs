<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InspectionBodyDocument extends Model
{
    protected $table = 'inspection_body_documents';
    protected $fillable = ['application_id','document_type','file_name','original_name','file_path','mime_type','uploaded_by'];
}
