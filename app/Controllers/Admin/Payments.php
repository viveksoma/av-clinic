<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\PaymentModel;

class Payments extends BaseController
{
    public function update()
    {
        $paymentModel = new \App\Models\Admin\PaymentModel();
        $appointmentId = $this->request->getPost('appointment_id');

        $data = [
            'appointment_id'  => $appointmentId,
            'payment_amount'  => $this->request->getPost('payment_amount'),
            'payment_mode'    => $this->request->getPost('payment_mode'),
            'payment_status'  => $this->request->getPost('payment_status'),
        ];

        $existing = $paymentModel->where('appointment_id', $appointmentId)->first();

        if ($existing) {
            $paymentModel->update($existing['id'], $data);
        } else {
            $paymentModel->insert($data);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
