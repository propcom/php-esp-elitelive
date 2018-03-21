<?php

namespace Propcom\ESP\EliteLive\Authentication;

class User
{
	public static function createFromArray($data)
	{
		$instance = (new self());

		foreach ($data as $key => $value) {
			$instance->setData($key, $value);
		}

		return $instance;
	}

	protected $data = [];

	public function setData($key, $value)
	{
		$this->data[$key] = $value;

		return $this;
	}

	public function getAllData()
	{
		return $this->data;
	}

	public function getData($key)
	{
		return $this->data[$key];
	}

	public function getFullName()
	{
		return $this->getData('FullName');
	}

	public function getTitle()
	{
		return $this->getData('Title');
	}

	public function getFirstName()
	{
		return $this->getData('FirstName');
	}

	public function getSurname()
	{
		return $this->getData('Surname');
	}

	public function getSalutation()
	{
		return $this->getData('Salutation');
	}

	public function getCompany()
	{
		return $this->getData('Company');
	}

	public function getAddr1()
	{
		return $this->getData('Addr1');
	}

	public function getAddr2()
	{
		return $this->getData('Addr2');
	}

	public function getAddr3()
	{
		return $this->getData('Addr3');
	}

	public function getCity()
	{
		return $this->getData('City');
	}

	public function getCounty()
	{
		return $this->getData('County');
	}

	public function getPostCode()
	{
		return $this->getData('PostCode');
	}

	public function getCountry()
	{
		return $this->getData('Country');
	}

	public function getEmail()
	{
		return $this->getData('Email');
	}

	public function getGender()
	{
		return $this->getData('Gender');
	}

	public function getLocalAddrCode()
	{
		return $this->getData('LocalAddrCode');
	}

	public function getMemberNumber()
	{
		return $this->getData('MembNo');
	}

	public function getPhone1()
	{
		return $this->getData('Phone1');
	}

	public function getPhone2()
	{
		return $this->getData('Phone2');
	}

	public function getPhone3()
	{
		return $this->getData('Phone3');
	}

	public function getMobile()
	{
		return $this->getData('Mobile');
	}
}
