<?php

namespace Chapa\Model;

require_once __DIR__ . '/../../../../autoload.php';

/**
 * The PostData class is an object representation of JSON form data
 * that will be posted to Chapa API.
 */
class PostData
{

	private $amount;
	private $currency;
	private $email;
	private $firstname;
	private $lastname;
	private $transactionRef;
	private $callbackUrl;
	private $customizations;

	public function getAmount()
	{
		return $this->amount;
	}

	public function amount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	public function getCurrency()
	{
		return $this->currency;
	}

	public function currency($currency)
	{
		$this->currency = $currency;
		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function email($email)
	{
		$this->email = $email;
		return $this;
	}

	public function getFirstName()
	{
		return $this->firstname;
	}

	public function firstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

	public function getLastName()
	{
		return $this->lastname;
	}

	public function lastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}

	public function getTransactionRef()
	{
		return $this->transactionRef;
	}

	public function transactionRef($transactionRef)
	{
		$this->transactionRef = $transactionRef;
		return $this;
	}

	public function getCallbackUrl()
	{
		return $this->callbackUrl;
	}

	public function callbackUrl($callbackUrl)
	{
		$this->callbackUrl = $callbackUrl;
		return $this;
	}

	public function getCustomizations()
	{
		return $this->customizations;
	}

	public function customizations($customizations)
	{
		$this->customizations = $customizations;
		return $this;
	}

    /**
     * @return array    An associative array that contains post data
     *                  as a key-value pair.
     */
	public function getAsKeyValue()
	{
		$data = array();

		$data['amount'] = $this->amount;
		$data['currency'] = $this->currency;
		$data['email'] = $this->email;
		$data['first_name'] = $this->firstname;
		$data['last_name'] = $this->firstname;
		$data['tx_ref'] = $this->transactionRef;

		if (!is_null($this->callbackUrl)) {
			$data['callback_url'] = $this->callbackUrl;
		}

		if (!is_null($this->customizations)) {
			foreach ($this->customizations as $key => $value) {
				$data[$key] = $value;
			}
		}
		return $data;
	}
}
