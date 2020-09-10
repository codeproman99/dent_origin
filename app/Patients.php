<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{

    /**
     * Base Table
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_surname', 'phone_number', 'dentist_id', 'calendar_id', 'first_visit_start', 'first_visit_end', 'visit_status', 'quotation_status', 'total_accepted_quotation', 'total_collected'
    ];


    /**
     * The attributes Date
     *
     * @var array
     */
    protected $dates = ['first_visit_start', 'first_visit_end', 'created_at', 'updated_at'];


    /**
     * Get all Patients by the Dentist ID
     *
     * @param int $id
     * @return Object $patients
     */
    public function getAllPatientsByDentistID($id)
    {
        $patients = Patients::leftJoin('quotation_status', 'quotation_status', '=', 'quotation_status.id')
            ->leftJoin('visit_status', 'visit_status', '=', 'visit_status.id')
            ->addSelect('patients.*', 'quotation_status.status_title as quotation_status_title', 'visit_status.status_title as visit_status_title')
            ->where('dentist_id', '=', $id)
            ->get();
        return $patients;
    }

    /**
     * Get Patient Data by the patient ID
     *
     * @param int $id
     * @return Object $patient
     */
    public function getByID($id)
    {
        $patient = Patients::where('id', '=', $id)->first();
        return $patient;
    }
}
