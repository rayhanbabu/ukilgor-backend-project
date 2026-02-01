<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile_picture' => $this->user->profile_picture,
            'agent_user_id' => $this->agent_user_id,
            'agent_name' => $this->agent?$this->agent->name: null,
            'agent_username' => $this->agent?$this->agent->username: null,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'username' => $this->user->username,
            'status' => $this->user->status,
            'user_id' => $this->user_id,
            'english_name' => $this->english_name,
            'bangla_name' => $this->bangla_name,
            'short_address' => $this->short_address,
            'full_address' => $this->full_address,
            'bangla_name_front_size' => $this->bangla_name_front_size,
            'english_name_front_size' => $this->english_name_front_size,
            'eiin' => $this->eiin,
            'full_address_front_size' => $this->full_address_front_size,
            'short_address_front_size' => $this->short_address_front_size,
            'bangla_address' => $this->bangla_address,
            'office_time' => $this->office_time,
            'map_link' => $this->map_link,
            'btcl_phone' => $this->btcl_phone,
            'btcl_email' => $this->btcl_email,
            'btcl_username' => $this->btcl_username,
            'btcl_password' => $this->btcl_password,
            'domain_name' => $this->domain_name,
            'expired_date' => $this->expired_date,
            'remark' => $this->remark,
            'student_access' => $this->student_access,
            'employee_access' => $this->employee_access,
            'setting_access' => $this->setting_access,
            'attendance_access' => $this->attendance_access,
            'institution_finance_access' => $this->institution_finance_access,
            'student_fee_access' => $this->student_fee_access,
            'result_access' => $this->result_access,
            'website_access' => $this->website_access,
            'payment_online_access' => $this->payment_online_access,
            'payment_cash_access' => $this->payment_cash_access,
            'payment_bank_access' => $this->payment_bank_access,
            'attendance_subject' => $this->attendance_subject,
            'attendance_update_day' => $this->attendance_update_day,
            'student_login_access' => $this->student_login_access,
            'employee_login_access' => $this->employee_login_access,
            'counter_name1' => $this->counter_name1,
            'counter1' => $this->counter1,
            'counter_name2' => $this->counter_name2,
            'counter2' => $this->counter2,
            'counter_name3' => $this->counter_name3,
            'counter3' => $this->counter3,
            'counter_name4' => $this->counter_name4,
            'counter4' => $this->counter4,
            'bank_name' => $this->bank_name,
            'branch_name' => $this->branch_name,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'routing_number' => $this->routing_number,
            'headteacher_signature' => $this->headteacher_signature,
            'sms_access' => $this->sms_access,
            'attendance_sms_text' => $this->attendance_sms_text,
            'marksheet_signature_show' => $this->marksheet_signature_show,
            'marksheet_attendance_show' => $this->marksheet_attendance_show,
            'admitcard_image' => $this->admitcard_image,
            'section_merit_label'=> $this->section_merit_label,
            'section_merit_status'=> $this->section_merit_status,
            'class_merit_label'=> $this->class_merit_label,
            'class_merit_status'=> $this->class_merit_status,
            
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
