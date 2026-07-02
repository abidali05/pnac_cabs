<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HcbApplication extends Model
{
    protected $table = 'hcb_applications';
    protected $fillable = ['application_no','scheme_name','application_type','organization_name','status','current_step','submitted_at','created_by'];
    protected $casts = ['submitted_at' => 'datetime'];

    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function basicInformation(): HasOne { return $this->hasOne(HcbBasicInformation::class, 'application_id'); }
    public function subOffices(): HasMany { return $this->hasMany(HcbSubOffice::class, 'application_id'); }
    public function aboutHcb(): HasOne { return $this->hasOne(HcbAboutHcb::class, 'application_id'); }
    public function chiefExecutives(): HasMany { return $this->hasMany(HcbChiefExecutive::class, 'application_id'); }
    public function shariahExperts(): HasMany { return $this->hasMany(HcbShariahExpert::class, 'application_id'); }
    public function qualityReps(): HasMany { return $this->hasMany(HcbQualityManagementRepresentative::class, 'application_id'); }
    public function managementMembers(): HasMany { return $this->hasMany(HcbManagementMember::class, 'application_id'); }
    public function permanentAuditors(): HasMany { return $this->hasMany(HcbPermanentAuditor::class, 'application_id'); }
    public function externalAuditors(): HasMany { return $this->hasMany(HcbExternalAuditor::class, 'application_id'); }
    public function scopes(): HasMany { return $this->hasMany(HcbScope::class, 'application_id'); }
    public function qualitySystem(): HasMany { return $this->hasMany(HcbQualitySystem::class, 'application_id'); }
    public function nonCompliances(): HasMany { return $this->hasMany(HcbNonCompliance::class, 'application_id'); }
    public function otherApprovals(): HasMany { return $this->hasMany(HcbOtherApproval::class, 'application_id'); }
    public function declaration(): HasOne { return $this->hasOne(HcbDeclaration::class, 'application_id'); }
    public function documents(): HasMany { return $this->hasMany(HcbDocument::class, 'application_id'); }
}
