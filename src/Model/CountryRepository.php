<?php

namespace App\Model;

interface CountryRepository
{
    /**
     * Получение списка всех стран.
     *
     * @return array Массив объектов Country.
     */
    public function getAll(): array;

    /**
     * Получение страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @return Country|null Объект Country, если страна найдена.
     */
    public function get(string $code): ?Country;

    /**
     * Сохранение новой страны.
     *
     * @param Country $country Объект Country.
     * @return void
     */
    public function store(Country $country): void;

    /**
     * Редактирование страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @param Country $country Объект Country с новыми данными.
     * @return void
     */
    public function edit(string $code, Country $country): void;

    /**
     * Удаление страны по коду.
     *
     * @param string $code Двухбуквенный, трехбуквенный или числовой код страны.
     * @return void
     */
    public function delete(string $code): void;
}