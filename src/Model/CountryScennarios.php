<?php

namespace App\Model;

use App\Model\Exceptions\CountryAlreadyExistsException;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\InvalidCountryCodeException;

class CountryScenarios
{
    private CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Получение списка всех стран.
     *
     * @return array Массив объектов Country.
     */
    public function GetAll(): array
    {
        return $this->countryRepository->getAll();
    }

    /**
     * Получение страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @return Country Объект Country.
     * @throws CountryNotFoundException Если страна с таким кодом не найдена.
     * @throws InvalidCountryCodeException Если код некорректный.
     */
    public function Get(string $code): Country
    {
        $country = $this->countryRepository->get($code);
        if (!$country) {
            throw new CountryNotFoundException("Страна с кодом '$code' не найдена.");
        }
        return $country;
    }
    public function Get(string $code): Country
    {
        throw new \Exception('not implemented');
    }

    /**
     * Сохранение новой страны.
     *
     * @param Country $country Объект Country.
     * @return void
     * @throws CountryAlreadyExistsException Если страна с таким кодом уже существует.
     * @throws InvalidCountryCodeException Если код некорректный.
     */
    public function Store(Country $country): void
    {
        $this->validateCountry($country);
        try {
            $this->countryRepository->store($country);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new CountryAlreadyExistsException("Страна с таким кодом или наименованием уже существует.");
            }
            throw $e;
        }
    }

    private function validateCountry(Country $country): void
    {
        // Валидация кодов
        if (!preg_match('/^[A-Z]{2}$/', $country->getIsoAlpha2())) {
            throw new InvalidCountryCodeException("Некорректный двухбуквенный код.");
        }
        if (!preg_match('/^[A-Z]{3}$/', $country->getIsoAlpha3())) {
            throw new InvalidCountryCodeException("Некорректный трехбуквенный код.");
        }
        if (!preg_match('/^\d{3}$/', $country->getIsoNumeric())) {
            throw new InvalidCountryCodeException("Некорректный числовой код.");
        }

        // Валидация наименований
        if (empty($country->getShortName())) {
            throw new InvalidCountryCodeException("Не указано короткое наименование.");
        }
        if (empty($country->getFullName())) {
            throw new InvalidCountryCodeException("Не указано полное наименование.");
        }

        // Валидация населения и площади
        if ($country->getPopulation() < 0) {
            throw new InvalidCountryCodeException("Население не может быть отрицательным.");
        }
        if ($country->getSquare() < 0) {
            throw new InvalidCountryCodeException("Площадь не может быть отрицательной.");
        }
    }

     /**
     * Редактирование страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @param Country $country Объект Country с новыми данными.
     * @return void
     * @throws CountryNotFoundException Если страна с таким кодом не найдена.
     * @throws InvalidCountryCodeException Если код некорректный.
     */
    public function Edit(string $code, Country $country): void
    {
        $this->validateCountry($country);
        $existingCountry = $this->countryRepository->get($code);
        if (!$existingCountry) {
            throw new CountryNotFoundException("Страна с кодом '$code' не найдена.");
        }
        $country->setIsoAlpha2($existingCountry->getIsoAlpha2());
        $country->setIsoAlpha3($existingCountry->getIsoAlpha3());
        $country->setIsoNumeric($existingCountry->getIsoNumeric());
        $this->countryRepository->edit($code, $country);
    }

    /**
     * Удаление страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @return void
     * @throws CountryNotFoundException Если страна с таким кодом не найдена.
     * @throws InvalidCountryCodeException Если код некорректный.
     */
    public function Delete(string $code): void
    {
        $this->validateCode($code);
        if (!$this->countryRepository->get($code)) {
            throw new CountryNotFoundException("Страна с кодом '$code' не найдена.");
        }
        $this->countryRepository->delete($code);
    }

    private function validateCode(string $code): void
    {
        if (preg_match('/^[A-Z]{2}$/', $code) || preg_match('/^[A-Z]{3}$/', $code) || preg_match('/^\d{3}$/', $code)) {
            return;
        }
        throw new InvalidCountryCodeException("Некорректный код страны.");
    }
}