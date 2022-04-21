<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateEvent extends Model
{
    protected $fillable = ['user_id','event_id', 'event_title', 'event_location', 'event_start_date', 'event_start_time', 'event_end_date', 'event_end_time', 'upload_ticket', 'event_description', 'ticket_name', 'quantity_available', 'price', 'ticket_paid_name', 'quantity_paid_available', 'paid_price', 'ticket_donate_name', 'quantity_donate_available', 'donate_price', 'created_at', 'updated_at'];

    protected $table = "create_event";
}
