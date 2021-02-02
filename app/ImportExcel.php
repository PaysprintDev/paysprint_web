<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportExcel extends Model
{
    protected $fillable = ['transaction_date', 'invoice_no', 'payee_ref_no', 'name', 'transaction_ref', 'description', 'amount', 'remaining_balance', 'payment_due_date', 'payee_email', 'address', 'customer_id', 'service', 'installpay', 'status', 'uploaded_by', 'recurring', 'reminder', 'created_at', 'updated_at'];

    protected $table = "import_excel";
}



