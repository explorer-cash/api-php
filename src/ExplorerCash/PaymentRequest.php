<?php
/**
 *  Explorer Cash
 *
 *  @author    explorer.cash <support@explorer.cash>
 *  @copyright 2020 explorer.cash. All rights reserved.
 *  @license   LGPL-3.0 https://www.gnu.org/licenses/lgpl-3.0.en.html
 */

namespace ExplorerCash;

class PaymentRequest
{

    protected $mode = 'production';
    
    protected $payment_id = null;
    
    public function mode($mode = null)
    {
        if ($mode) {
            $this->mode = $mode;
        }
        
        return $this->mode;
    }
    
    public function paymentId()
    {
        return $this->payment_id;
    }

    public function push($payment)
    {
        return $this->payment_id = Api::paymentRequest($payment, $this->mode);
    }
    
    public function pull()
    {
        $payment = json_decode(file_get_contents('php://input'), true);
        
        if (!$payment || empty($payment['payment_id']) || empty($payment['payment_reference'])) {
            throw new \Exception('Payment is invalid');
        }
        
        return $payment;
    }
}
