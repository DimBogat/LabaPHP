<?php

namespace App\Rdb;

use App\Model\Country;
use App\Model\CountryRepository;
use PDO;

class CountryStorage implements CountryRepository
{
    private SqlHelper $sqlHelper;

    public function __construct(SqlHelper $sqlHelper)
    {
        $this->sqlHelper = $sqlHelper;
    }

    public function getAll(): array
    {
        $pdo = $this->sqlHelper->openDbConnection();
        $stmt = $pdo->prepare('SELECT * FROM countries');
        $stmt->execute();
        $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function (array $countryData) {
            return new Country(
                $countryData['short_name'],
                $countryData['full_name'],
                $countryData['iso_alpha2'],
                $countryData['iso_alpha3'],
                $countryData['iso_numeric'],
                (int)$countryData['population'],
                (float)$countryData['square']
            );
        }, $countries);
    }

    public function get(string $code): ?Country
    {
        $pdo = $this->sqlHelper->openDbConnection();
        $stmt = $pdo->prepare('SELECT * FROM countries WHERE iso_alpha2 = :code OR iso_alpha3 = :code OR iso_numeric = :code');
        $stmt->bindValue(':code', $code);
        $stmt->execute();
        $countryData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($countryData) {
            return new Country(
                $countryData['short_name'],
                $countryData['full_name'],
                $countryData['iso_alpha2'],
                $countryData['iso_alpha3'],
                $countryData['iso_numeric'],
                (int)$countryData['population'],
                (float)$countryData['square']
            );
        }
        return null;
    }

    public function store(Country $country): void
    {
        $pdo = $this->sqlHelper->openDbConnection();
        $stmt = $pdo->prepare('INSERT INTO countries (short_name, full_name, iso_alpha2, iso_alpha3, iso_numeric, population, square) VALUES (:short_name, :full_name, :iso_alpha2, :iso_alpha3, :iso_numeric, :population, :square)');
        $stmt->bindValue(':short_name', $country->getShortName());
        $stmt->bindValue(':full_name', $country->getFullName());
        $stmt->bindValue(':iso_alpha2', $country->getIsoAlpha2());
        $stmt->bindValue(':iso_alpha3', $country->getIsoAlpha3());
        $stmt->bindValue(':iso_numeric', $country->getIsoNumeric());
        $stmt->bindValue(':population', $country->getPopulation());
        $stmt->bindValue(':square', $country->getSquare());
        $stmt->execute();
    }
    public function delete(string $code): void
    {
        $pdo = $this->sqlHelper->openDbConnection();
        $stmt = $pdo->prepare('DELETE FROM countries WHERE iso_alpha2 = :code OR iso_alpha3 = :code OR iso_numeric = :code');
        $stmt->bindValue(':code', $code);
        $stmt->execute();
    }
}