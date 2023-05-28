<?php
class ControllerExtensionPaymentRocketWallet extends Controller {
	public function index() {
		$this->load->language('extension/payment/rocket_wallet');

		$data['rocket'] = nl2br($this->config->get('payment_rocket_wallet_rocket' . $this->config->get('config_language_id')));

		return $this->load->view('extension/payment/rocket_wallet', $data);
	}

	public function confirm() {
		$json = array();
		
		if ($this->session->data['payment_method']['code'] == 'rocket_wallet') {
			$this->load->language('extension/payment/rocket_wallet');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_instruction') . "\n\n";
			$comment .= $this->config->get('payment_rocket_wallet_rocket' . $this->config->get('config_language_id')) . "\n\n";
			$comment .= $this->language->get('text_payment');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_rocket_wallet_order_status_id'), $comment, true);
		
			$json['redirect'] = $this->url->link('checkout/success');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
}